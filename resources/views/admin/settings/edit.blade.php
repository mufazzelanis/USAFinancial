<x-admin-layout title="Site Settings">
    <x-admin.page-header title="Site Settings" subtitle="Edit the text content shown across the public website." />

    {{-- Branding: logo & favicon each have their own small upload form, kept separate
         from the settings form below so a file input never interferes with plain text saves. --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500">Branding</h3>
        <div class="grid gap-8 sm:grid-cols-2">
            <div>
                <p class="mb-2 text-sm font-semibold text-slate-700">Site Logo</p>
                <div class="flex items-start gap-4 rounded-xl border border-dashed border-slate-300 p-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-slate-50">
                        @if ($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Site logo" class="max-h-full max-w-full object-contain">
                        @else
                            <x-brand-logo class="h-10 w-10" />
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 space-y-3">
                        <form method="POST" action="{{ route('admin.settings.logo.upload') }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                            @csrf
                            <input type="file" name="file" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-navy-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-navy-800 sm:w-auto">
                            <button class="shrink-0 rounded-lg bg-navy-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-navy-800">Upload</button>
                        </form>
                        @if ($logoUrl)
                            <form method="POST" action="{{ route('admin.settings.logo.remove') }}" onsubmit="return confirm('Remove the current logo and use the default monogram instead?');">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-600 hover:text-red-700">Remove logo</button>
                            </form>
                        @endif
                        <p class="text-xs text-slate-400">PNG, JPG or SVG, up to 1MB. Falls back to the default monogram when removed.</p>
                    </div>
                </div>
            </div>

            <div>
                <p class="mb-2 text-sm font-semibold text-slate-700">Favicon</p>
                <div class="flex items-start gap-4 rounded-xl border border-dashed border-slate-300 p-4">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-slate-50">
                        @if ($faviconUrl)
                            <img src="{{ $faviconUrl }}" alt="Favicon" class="max-h-10 max-w-10 object-contain">
                        @else
                            <span class="text-2xl">🌐</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 space-y-3">
                        <form method="POST" action="{{ route('admin.settings.favicon.upload') }}" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
                            @csrf
                            <input type="file" name="file" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-navy-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-navy-800 sm:w-auto">
                            <button class="shrink-0 rounded-lg bg-navy-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-navy-800">Upload</button>
                        </form>
                        @if ($faviconUrl)
                            <form method="POST" action="{{ route('admin.settings.favicon.remove') }}" onsubmit="return confirm('Remove the current favicon?');">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-600 hover:text-red-700">Remove favicon</button>
                            </form>
                        @endif
                        <p class="text-xs text-slate-400">Square PNG or ICO recommended, up to 512KB.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- novalidate: this form holds every setting at once, so a native browser constraint
         (type=url/email) on any single field must never be able to block saving the rest. --}}
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6" novalidate>
        @csrf @method('PUT')

        @foreach ($settings as $group => $items)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500">{{ str($group)->headline() }}</h3>

                @if ($group === 'tracking')
                    <div class="mb-5 rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600">
                        <p class="font-semibold text-slate-700">How this works</p>
                        <p class="mt-1">The Pixel ID and Measurement ID below are safe to store here — they're public identifiers that appear in your page source anyway. Visitors are shown a cookie consent banner first; tracking scripts only load after they accept.</p>
                        <p class="mt-2 flex items-center gap-1.5">
                            <span @class(['h-2 w-2 rounded-full shrink-0', 'bg-green-500' => $metaCapiConfigured, 'bg-amber-400' => !$metaCapiConfigured])></span>
                            @if ($metaCapiConfigured)
                                <span class="font-semibold text-green-700">Server-side lead tracking (Conversions API) is configured.</span>
                            @else
                                <span><span class="font-semibold text-amber-700">Server-side lead tracking isn't configured yet.</span> For accurate, ad-blocker-proof lead data, add <code class="rounded bg-slate-200 px-1 py-0.5">FACEBOOK_CAPI_ACCESS_TOKEN</code> to your server's <code class="rounded bg-slate-200 px-1 py-0.5">.env</code> file (Meta Events Manager → Data Sources → your Pixel → Settings → Conversions API). This is an access token, not a page ID, so it's kept out of the database and admin forms for security.</span>
                            @endif
                        </p>
                    </div>
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ($items as $setting)
                        @continue($setting->key === 'whatsapp_number')
                        @php
                            $key = $setting->key;
                            $type = $fieldTypes[$key] ?? 'text';
                            $label = str($key)->replace('_', ' ')->headline();
                            $placeholder = $fieldHelp[$key]['placeholder'] ?? null;
                            $help = $fieldHelp[$key]['help'] ?? null;
                            $currentValue = old('settings.'.$key, $setting->value);
                        @endphp

                        <div @class(['sm:col-span-2' => $type === 'textarea' || $key === 'whatsapp_country'])>
                            @if ($key === 'whatsapp_country')
                                @php
                                    $numberSetting = $items->firstWhere('key', 'whatsapp_number');
                                    $numberValue = old('settings.whatsapp_number', $numberSetting->value ?? '');
                                    $numberPlaceholder = $fieldHelp['whatsapp_number']['placeholder'] ?? null;
                                    $numberHelp = $fieldHelp['whatsapp_number']['help'] ?? null;
                                @endphp
                                <div x-data="{ country: @js($currentValue), num: @js($numberValue), dials: @js($countries->mapWithKeys(fn ($c, $iso) => [$iso => $c['dial']])) }">
                                    <x-input-label value="WhatsApp Number" />
                                    <div class="flex flex-col gap-2 sm:flex-row">
                                        <x-select-input name="settings[whatsapp_country]" x-model="country" class="mt-0 sm:w-64">
                                            @foreach ($countries as $iso => $country)
                                                <option value="{{ $iso }}" @selected($currentValue === $iso)>{{ $country['name'] }} (+{{ $country['dial'] }})</option>
                                            @endforeach
                                        </x-select-input>
                                        <div class="flex flex-1 items-center gap-2">
                                            <span class="flex items-center rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-500" x-text="'+' + dials[country]"></span>
                                            <x-text-input type="tel" name="settings[whatsapp_number]" placeholder="{{ $numberPlaceholder }}" x-model="num" class="mt-0 flex-1" />
                                        </div>
                                        <a
                                            :href="'https://wa.me/' + dials[country] + num.replace(/\D/g, '').replace(/^0+/, '')"
                                            target="_blank"
                                            rel="noopener"
                                            :class="num.replace(/\D/g, '').replace(/^0+/, '').length < 5 ? 'pointer-events-none opacity-40' : ''"
                                            class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-lg bg-[#25D366] px-4 py-2.5 text-xs font-bold text-white hover:bg-[#20bd5a]"
                                        >
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
                                            Test Number
                                        </a>
                                    </div>
                                    <p class="mt-1.5 text-xs text-slate-400" x-text="'Full number that will be used: +' + dials[country] + num.replace(/\D/g, '').replace(/^0+/, '')"></p>
                                    @if ($numberHelp)
                                        <p class="mt-1 text-xs text-slate-400">{{ $numberHelp }}</p>
                                    @endif
                                </div>
                            @elseif ($type === 'checkbox')
                                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <input type="hidden" name="settings[{{ $key }}]" value="0">
                                    <x-checkbox name="settings[{{ $key }}]" value="1" :checked="$currentValue === '1'" />
                                    {{ $label }}
                                </label>
                            @elseif ($type === 'textarea')
                                <x-input-label :for="$key" :value="$label" />
                                <x-textarea-input :id="$key" name="settings[{{ $key }}]" rows="3" placeholder="{{ $placeholder }}" class="mt-0">{{ $currentValue }}</x-textarea-input>
                                @if ($help)
                                    <p class="mt-1.5 text-xs text-slate-400">{{ $help }}</p>
                                @endif
                            @else
                                <x-input-label :for="$key" :value="$label" />
                                <x-text-input
                                    :id="$key"
                                    :type="$type === 'email' ? 'email' : ($type === 'url' ? 'url' : ($type === 'tel' ? 'tel' : 'text'))"
                                    name="settings[{{ $key }}]"
                                    value="{{ $currentValue }}"
                                    placeholder="{{ $placeholder }}"
                                    class="mt-0"
                                />
                                @if ($help)
                                    <p class="mt-1.5 text-xs text-slate-400">{{ $help }}</p>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <x-primary-button>Save Settings</x-primary-button>
    </form>
</x-admin-layout>
