{{-- Footer --}}
<footer class="bg-navy-950 text-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <x-brand-mark dark />
                <p class="mt-4 max-w-sm text-sm text-white/60">
                    {{ $settings['hero_subtitle'] ?? 'Reliable accounting, bookkeeping and payroll solutions to help your business grow with accuracy, compliance and confidence.' }}
                </p>

                @php
                    $socials = [
                        'facebook' => ['url' => $settings['social_facebook'] ?? null, 'path' => 'M22 12a10 10 0 10-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0022 12z'],
                        'twitter' => ['url' => $settings['social_twitter'] ?? null, 'path' => 'M18.9 3H21l-6.55 7.49L22.2 21h-6.62l-5.18-6.77L4.44 21H2.32l7.02-8.02L1.8 3h6.78l4.69 6.2L18.9 3Zm-1.16 16.17h1.17L7.32 4.75H6.06l11.68 14.42Z'],
                        'linkedin' => ['url' => $settings['social_linkedin'] ?? null, 'path' => 'M6.94 5a2 2 0 11-4 0 2 2 0 014 0ZM3.2 8.75h3.5V21H3.2V8.75Zm6.2 0h3.36v1.68h.05c.47-.88 1.6-1.8 3.3-1.8 3.53 0 4.18 2.32 4.18 5.35V21h-3.5v-5.44c0-1.3-.02-2.97-1.81-2.97-1.82 0-2.1 1.42-2.1 2.88V21H9.4V8.75Z'],
                        'instagram' => ['url' => $settings['social_instagram'] ?? null, 'path' => 'M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.15.55.55.9 1.11 1.15 1.77.25.64.42 1.37.47 2.43.05 1.06.06 1.4.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 01-1.15 1.77 4.9 4.9 0 01-1.77 1.15c-.64.25-1.37.42-2.43.47-1.06.05-1.4.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 01-1.77-1.15 4.9 4.9 0 01-1.15-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.15-1.77A4.9 4.9 0 015.45 2.53c.64-.25 1.37-.42 2.43-.47C8.94 2.01 9.28 2 12 2Zm0 1.8c-2.67 0-2.99.01-4.04.06-.87.04-1.34.18-1.65.3-.42.16-.71.35-1.02.66-.31.31-.5.6-.66 1.02-.12.31-.26.78-.3 1.65C4.29 8.5 4.28 8.83 4.28 12s.01 2.99.06 4.04c.04.87.18 1.34.3 1.65.16.42.35.71.66 1.02.31.31.6.5 1.02.66.31.12.78.26 1.65.3 1.05.05 1.37.06 4.04.06s2.99-.01 4.04-.06c.87-.04 1.34-.18 1.65-.3.42-.16.71-.35 1.02-.66.31-.31.5-.6.66-1.02.12-.31.26-.78.3-1.65.05-1.05.06-1.37.06-4.04s-.01-2.99-.06-4.04c-.04-.87-.18-1.34-.3-1.65a2.7 2.7 0 00-.66-1.02 2.7 2.7 0 00-1.02-.66c-.31-.12-.78-.26-1.65-.3C14.99 3.81 14.67 3.8 12 3.8Zm0 3.24a4.96 4.96 0 110 9.92 4.96 4.96 0 010-9.92Zm0 1.8a3.16 3.16 0 100 6.32 3.16 3.16 0 000-6.32Zm5.16-1.98a1.16 1.16 0 11-2.32 0 1.16 1.16 0 012.32 0Z'],
                    ];
                    $activeSocials = collect($socials)->filter(fn ($s) => !empty($s['url']));
                @endphp
                @if ($activeSocials->isNotEmpty())
                    <div class="mt-5 flex items-center gap-2">
                        @foreach ($activeSocials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white/80 transition hover:bg-gold-500 hover:text-navy-950">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $social['path'] }}" /></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-gold-400">Quick Links</p>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    @forelse ($footerLinks ?? [] as $link)
                        <li><a href="{{ $link->url }}" class="hover:text-white">{{ $link->label }}</a></li>
                    @empty
                        <li><a href="{{ route('home') }}#pricing" class="hover:text-white">Pricing</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-gold-400">Contact</p>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    @if(!empty($settings['phone']))<li>{{ $settings['phone'] }}</li>@endif
                    @if(!empty($settings['email']))<li>{{ $settings['email'] }}</li>@endif
                    @if(!empty($settings['website']))<li>{{ $settings['website'] }}</li>@endif
                    @if(!empty($settings['address']))<li>{{ $settings['address'] }}</li>@endif
                </ul>
            </div>
        </div>
        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-white/50 sm:flex-row">
            <p>{{ $settings['footer_copyright'] ?? ('© '.date('Y').' '.($settings['company_name'] ?? 'FirstServe Accounting').'. All rights reserved.') }}</p>
            <p>{{ $settings['footer_tagline'] ?? 'UK Chartered Accounting Firm' }}</p>
        </div>
    </div>
</footer>

@if (($settings['whatsapp_enabled'] ?? '1') === '1')
    <x-whatsapp-widget
        :number="\App\Models\SiteSetting::whatsappNumber()"
        :message="$settings['whatsapp_message'] ?? null"
        :name="$settings['company_name'] ?? 'FirstServe Accounting'"
    />
@endif
