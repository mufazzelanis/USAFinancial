<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Setting keys that have their own dedicated UI (branding uploads) and should
     * never be rendered by the generic text-field loop.
     */
    private const BRANDING_KEYS = ['site_logo', 'site_favicon'];

    /**
     * Explicit input type per setting key. Anything not listed falls back to a plain text input.
     */
    private const FIELD_TYPES = [
        'hero_subtitle' => 'textarea',
        'footer_cta_subtitle' => 'textarea',
        'address' => 'textarea',
        'whatsapp_message' => 'textarea',
        'whatsapp_enabled' => 'checkbox',
        'phone' => 'tel',
        'email' => 'email',
        'social_facebook' => 'url',
        'social_twitter' => 'url',
        'social_linkedin' => 'url',
        'social_instagram' => 'url',
        // 'website' is intentionally plain text, not type="url": it's shown as a display
        // label on the site (e.g. "www.example.co.uk"), not used as a real href, and a
        // strict native url constraint here previously blocked saving the ENTIRE settings
        // form (all fields share one <form>) whenever this value had no http(s):// scheme.
        //
        // 'whatsapp_country' + 'whatsapp_number' are rendered together as one combined
        // country-select + local-number control by the view (see whatsapp-number.blade.php
        // partial) rather than through this generic type map.
    ];

    /**
     * Placeholder + help text shown under specific fields.
     */
    private const FIELD_HELP = [
        'whatsapp_number' => [
            'placeholder' => 'e.g. 1760153182',
            'help' => 'Local number only — no country code, no leading 0. Pick your country on the left; we build the correct international number automatically.',
        ],
        'whatsapp_message' => [
            'placeholder' => "Hi, I'd like to know more about your services.",
            'help' => 'Pre-filled message a visitor sees when they open WhatsApp from the site widget.',
        ],
        'phone' => [
            'placeholder' => '+44 20 1234 5678',
            'help' => null,
        ],
        'footer_copyright' => [
            'placeholder' => null, // filled in dynamically in edit(), see FIELD_HELP_DYNAMIC
            'help' => 'Leave blank to auto-generate using the company name and current year.',
        ],
        'footer_tagline' => [
            'placeholder' => 'UK Chartered Accounting Firm',
            'help' => null,
        ],
        'social_facebook' => ['placeholder' => 'https://facebook.com/yourpage', 'help' => null],
        'social_twitter' => ['placeholder' => 'https://x.com/yourhandle', 'help' => null],
        'social_linkedin' => ['placeholder' => 'https://linkedin.com/company/yourcompany', 'help' => null],
        'social_instagram' => ['placeholder' => 'https://instagram.com/yourhandle', 'help' => null],
    ];

    public function edit(): View
    {
        $settings = SiteSetting::allCached()
            ->reject(fn (SiteSetting $setting) => in_array($setting->key, self::BRANDING_KEYS, true))
            ->groupBy('group');

        $fieldHelp = self::FIELD_HELP;
        $fieldHelp['footer_copyright']['placeholder'] = '© '.date('Y').' '.(SiteSetting::get('company_name') ?? 'Your Company').'. All rights reserved.';

        $logoPath = SiteSetting::get('site_logo');
        $faviconPath = SiteSetting::get('site_favicon');

        return view('admin.settings.edit', [
            'settings' => $settings,
            'fieldTypes' => self::FIELD_TYPES,
            'fieldHelp' => $fieldHelp,
            'countries' => collect(config('countries'))->sortBy('name'),
            'logoUrl' => $logoPath ? Storage::disk('public')->url($logoPath) : null,
            'faviconUrl' => $faviconPath ? Storage::disk('public')->url($faviconPath) : null,
        ]);
    }

    /**
     * Extra validation rules for specific setting keys, merged on top of the
     * baseline ['nullable', 'string', 'max:5000'] applied to every field.
     */
    private const VALIDATION_RULES = [
        'whatsapp_number' => ['regex:/^0*[0-9]{6,12}$/'],
        'email' => ['email:filter'],
    ];

    public function update(Request $request): RedirectResponse
    {
        $values = $request->input('settings', []);
        $countryKeys = array_keys(config('countries'));

        $rules = [];
        foreach (array_keys($values) as $key) {
            $rules["settings.{$key}"] = array_merge(
                ['nullable', 'string', 'max:5000'],
                match ($key) {
                    'whatsapp_country' => ['in:'.implode(',', $countryKeys)],
                    default => self::VALIDATION_RULES[$key] ?? [],
                }
            );
        }

        $validated = $request->validate($rules, [
            'settings.whatsapp_country.in' => 'Please choose a valid country.',
            'settings.whatsapp_number.regex' => 'The WhatsApp number should be your local number only — digits, no country code, no leading 0 needed (it will be stripped automatically).',
            'settings.email.email' => 'Please enter a valid email address.',
        ]);

        foreach ($validated['settings'] ?? [] as $key => $value) {
            if ($key === 'whatsapp_number') {
                $value = ltrim(preg_replace('/\D+/', '', (string) $value), '0');
            }

            SiteSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('status', 'Settings updated.');
    }

    public function uploadLogo(Request $request): RedirectResponse
    {
        return $this->uploadBrandingImage($request, 'site_logo', maxKb: 1024);
    }

    public function removeLogo(): RedirectResponse
    {
        return $this->removeBrandingImage('site_logo');
    }

    public function uploadFavicon(Request $request): RedirectResponse
    {
        return $this->uploadBrandingImage($request, 'site_favicon', maxKb: 512);
    }

    public function removeFavicon(): RedirectResponse
    {
        return $this->removeBrandingImage('site_favicon');
    }

    private function uploadBrandingImage(Request $request, string $key, int $maxKb): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'max:'.$maxKb],
        ]);

        $setting = SiteSetting::firstOrCreate(['key' => $key], ['group' => 'branding', 'value' => null]);

        if ($setting->value) {
            Storage::disk('public')->delete($setting->value);
        }

        $path = $request->file('file')->store('branding', 'public');

        $setting->update(['value' => $path]);

        return back()->with('status', 'Uploaded successfully.');
    }

    private function removeBrandingImage(string $key): RedirectResponse
    {
        $setting = SiteSetting::where('key', $key)->first();

        if ($setting?->value) {
            Storage::disk('public')->delete($setting->value);
            $setting->update(['value' => null]);
        }

        return back()->with('status', 'Removed.');
    }
}
