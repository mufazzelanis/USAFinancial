<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Plan;
use App\Services\MetaConversionsApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    /**
     * Store a public quote / contact request (plan signup or hourly service enquiry).
     */
    public function store(Request $request, MetaConversionsApi $metaCapi): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:255'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'hourly_service_id' => ['nullable', 'exists:hourly_services,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['source'] = 'website';
        $validated['status'] = 'new';

        $lead = Lead::create($validated);
        $plan = $lead->plan_id ? Plan::find($lead->plan_id) : null;

        // Shared between the server-side Conversions API call below and the
        // browser Pixel fire on the redirected page (see welcome.blade.php) —
        // Meta uses this to dedupe the two into a single conversion instead
        // of double-counting a lead that both sides genuinely observed.
        $eventId = (string) Str::uuid();

        if ($metaCapi->isConfigured()) {
            [$firstName, $lastName] = array_pad(explode(' ', $lead->name, 2), 2, null);

            $metaCapi->sendEvent(
                eventName: 'Lead',
                eventId: $eventId,
                request: $request,
                userData: [
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ],
                customData: array_filter([
                    'content_name' => $plan?->name ?? 'General enquiry',
                    'currency' => 'GBP',
                    'value' => $plan?->price,
                ]),
            );
        }

        return back()
            ->with('quote_success', 'Thanks! Your request has been received — our team will contact you shortly.')
            ->with('quote_event_id', $eventId)
            ->with('quote_plan_name', $plan?->name)
            ->with('quote_plan_price', $plan?->price);
    }
}
