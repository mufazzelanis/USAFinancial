{{-- Utility top bar --}}
<div class="bg-navy-950 text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-xs sm:px-6 lg:px-8">
        <div class="hidden items-center gap-5 sm:flex">
            @if(!empty($settings['phone']))
                <a href="tel:{{ preg_replace('/\s+/', '', $settings['phone']) }}" class="flex items-center gap-1.5 text-white/80 hover:text-gold-300">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    {{ $settings['phone'] }}
                </a>
            @endif
            @if(!empty($settings['email']))
                <a href="mailto:{{ $settings['email'] }}" class="flex items-center gap-1.5 text-white/80 hover:text-gold-300">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    {{ $settings['email'] }}
                </a>
            @endif
        </div>
        <div class="ml-auto flex items-center gap-1.5 font-semibold tracking-wide text-white">
            <span>🇬🇧</span>
            <span>{{ $settings['company_badge'] ?? 'UK CA FIRM' }}</span>
        </div>
    </div>
</div>

{{-- Header --}}
<header class="sticky top-0 z-40 border-b border-slate-100 bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}"><x-brand-mark /></a>

        <nav class="hidden items-center gap-8 text-sm font-semibold text-navy-900 lg:flex">
            <a href="{{ route('home') }}#package" class="hover:text-gold-600">Package</a>
            <a href="{{ route('home') }}#services" class="hover:text-gold-600">Services</a>
            <a href="{{ route('home') }}#pricing" class="hover:text-gold-600">Pricing</a>
            <a href="{{ route('home') }}#payroll" class="hover:text-gold-600">Payroll</a>
            <a href="{{ route('home') }}#integrations" class="hover:text-gold-600">Integrations</a>
            <a href="{{ route('home') }}#quote" class="hover:text-gold-600">Contact</a>
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="text-sm font-semibold text-navy-900 hover:text-gold-600">
                    My Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-navy-900 hover:text-gold-600">Log in</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold text-navy-900 hover:text-gold-600">Register</a>
            @endauth
            <a href="{{ route('home') }}#quote" class="inline-flex items-center gap-1.5 rounded-full bg-gold-500 px-5 py-2.5 text-sm font-bold text-navy-950 shadow-sm transition hover:bg-gold-400">
                Get a Quote
            </a>
        </div>

        <button class="lg:hidden text-navy-900" @click="mobileMenu = ! mobileMenu">
            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /><path x-cloak x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <div x-cloak x-show="mobileMenu" x-transition class="border-t border-slate-100 bg-white px-4 py-4 lg:hidden">
        <nav class="flex flex-col gap-3 text-sm font-semibold text-navy-900">
            <a href="{{ route('home') }}#package" @click="mobileMenu=false">Package</a>
            <a href="{{ route('home') }}#services" @click="mobileMenu=false">Services</a>
            <a href="{{ route('home') }}#pricing" @click="mobileMenu=false">Pricing</a>
            <a href="{{ route('home') }}#payroll" @click="mobileMenu=false">Payroll</a>
            <a href="{{ route('home') }}#integrations" @click="mobileMenu=false">Integrations</a>
            <a href="{{ route('home') }}#quote" @click="mobileMenu=false">Contact</a>
            <div class="mt-2 flex flex-col gap-2 border-t border-slate-100 pt-3">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}">My Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
                <a href="{{ route('home') }}#quote" class="inline-flex w-fit items-center gap-1.5 rounded-full bg-gold-500 px-5 py-2 font-bold text-navy-950">Get a Quote</a>
            </div>
        </nav>
    </div>
</header>
