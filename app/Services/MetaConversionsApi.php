<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Meta (Facebook) Conversions API — sends conversion events server-side,
 * deduplicated with the browser Pixel via a shared event_id.
 *
 * Why this exists alongside the browser Pixel: ad blockers, Safari's ITP,
 * and iOS 14.5+ App Tracking Transparency all suppress a meaningful share of
 * client-side pixel fires. A server-side call for the events that actually
 * matter (leads) is the standard, Meta-recommended way to keep conversion
 * data accurate. It's deliberately used only for genuine, server-validated
 * conversions (a Lead actually saved to the database) — never for page
 * views or clicks, which stay client-side where they belong.
 *
 * Fails silently (logs a warning, never throws) — a tracking outage must
 * never break the actual user-facing flow (e.g. submitting a quote).
 */
class MetaConversionsApi
{
    private const API_VERSION = 'v21.0';

    public function isConfigured(): bool
    {
        return filled(SiteSetting::get('fb_pixel_id'))
            && filled(config('services.meta_capi.access_token'));
    }

    /**
     * @param  array{email?: ?string, phone?: ?string, first_name?: ?string, last_name?: ?string}  $userData
     * @param  array<string, mixed>  $customData
     */
    public function sendEvent(
        string $eventName,
        string $eventId,
        Request $request,
        array $userData = [],
        array $customData = [],
    ): bool {
        $pixelId = SiteSetting::get('fb_pixel_id');
        $accessToken = config('services.meta_capi.access_token');

        if (! $pixelId || ! $accessToken) {
            return false;
        }

        $payload = [
            'data' => [[
                'event_name' => $eventName,
                'event_time' => now()->timestamp,
                'event_id' => $eventId,
                'action_source' => 'website',
                'event_source_url' => $request->fullUrl(),
                'user_data' => $this->hashUserData($userData, $request),
                'custom_data' => $customData,
            ]],
            'access_token' => $accessToken,
        ];

        if ($testCode = config('services.meta_capi.test_event_code')) {
            $payload['test_event_code'] = $testCode;
        }

        try {
            $response = Http::timeout(3)
                ->asJson()
                ->post("https://graph.facebook.com/".self::API_VERSION."/{$pixelId}/events", $payload);

            if (! $response->successful()) {
                Log::warning('Meta Conversions API event failed', [
                    'event' => $eventName,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('Meta Conversions API event exception', [
                'event' => $eventName,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Build Meta's user_data block: PII fields SHA-256 hashed per their spec
     * (lowercased + trimmed first), plus IP/UA/click-id cookies for matching.
     *
     * @param  array{email?: ?string, phone?: ?string, first_name?: ?string, last_name?: ?string}  $userData
     */
    private function hashUserData(array $userData, Request $request): array
    {
        $hashed = [];

        if (filled($userData['email'] ?? null)) {
            $hashed['em'] = [$this->hash(strtolower(trim($userData['email'])))];
        }

        if (filled($userData['phone'] ?? null)) {
            $digits = preg_replace('/\D+/', '', $userData['phone']);
            if ($digits) {
                $hashed['ph'] = [$this->hash($digits)];
            }
        }

        if (filled($userData['first_name'] ?? null)) {
            $hashed['fn'] = [$this->hash(strtolower(trim($userData['first_name'])))];
        }

        if (filled($userData['last_name'] ?? null)) {
            $hashed['ln'] = [$this->hash(strtolower(trim($userData['last_name'])))];
        }

        $hashed['client_ip_address'] = $request->ip();
        $hashed['client_user_agent'] = $request->userAgent();

        // _fbp / _fbc are set by the browser Pixel itself; forwarding them
        // (when present) lets Meta attribute this server event to the same
        // browsing session and ad click as the client-side Pixel does.
        if ($fbp = $request->cookie('_fbp')) {
            $hashed['fbp'] = $fbp;
        }

        if ($fbc = $request->cookie('_fbc')) {
            $hashed['fbc'] = $fbc;
        }

        return $hashed;
    }

    private function hash(string $value): string
    {
        return hash('sha256', $value);
    }
}
