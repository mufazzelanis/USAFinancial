@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Admin · FirstServe Accounting</title>
    <x-favicon-tags />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ mobileNav: false }">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:flex-col bg-navy-900 text-white">
            <div class="px-6 py-6 border-b border-white/10">
                <a href="{{ route('home') }}"><x-brand-mark dark size="h-9 w-9" /></a>
            </div>
            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1 text-sm">
                <x-portal-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="grid">Dashboard</x-portal-nav-link>

                <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Website Content</p>
                <x-portal-nav-link :href="route('admin.plans.index')" :active="request()->routeIs('admin.plans.*')" icon="currency">Pricing Plans</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.hourly-services.index')" :active="request()->routeIs('admin.hourly-services.*')" icon="clock">Per-Hour Services</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.payroll-tiers.index')" :active="request()->routeIs('admin.payroll-tiers.*')" icon="users">Payroll Tiers</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.integrations.index')" :active="request()->routeIs('admin.integrations.*')" icon="link">Integrations & POS</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.payment-gateways.index')" :active="request()->routeIs('admin.payment-gateways.*')" icon="currency">Payment Gateways</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.footer-links.index')" :active="request()->routeIs('admin.footer-links.*')" icon="link">Footer Links</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')" icon="cog">Site Settings</x-portal-nav-link>

                <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Operations</p>
                <x-portal-nav-link :href="route('admin.leads.index')" :active="request()->routeIs('admin.leads.*')" icon="inbox">Leads</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.clients.index')" :active="request()->routeIs('admin.clients.*')" icon="users">Clients</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.requests.index')" :active="request()->routeIs('admin.requests.*')" icon="clipboard">Service Requests</x-portal-nav-link>
                <x-portal-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')" icon="user">Team / Staff</x-portal-nav-link>

                <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Account</p>
                <x-portal-nav-link :href="route('admin.admin-users.index')" :active="request()->routeIs('admin.admin-users.*')" icon="cog">Admin Users</x-portal-nav-link>
                <x-portal-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="user">My Profile</x-portal-nav-link>
                <x-portal-nav-link :href="route('home')" icon="globe">View Website</x-portal-nav-link>
            </nav>
            <div class="px-4 py-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-white/70 hover:bg-white/10 hover:text-white transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex flex-col min-h-screen">
            <header class="sticky top-0 z-30 flex items-center justify-between gap-4 border-b border-slate-200 bg-white px-4 py-3 lg:px-8">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden text-slate-500" @click="mobileNav = true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-gold-600">Admin Panel</p>
                        <h1 class="text-lg font-bold text-navy-900">{{ $title }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:block text-sm text-slate-500">{{ auth()->user()->name }}</span>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-navy-900 text-sm font-semibold text-gold-300">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
            </header>

            <div x-cloak x-show="mobileNav" class="fixed inset-0 z-40 lg:hidden" x-transition.opacity>
                <div class="absolute inset-0 bg-black/50" @click="mobileNav = false"></div>
                <div class="absolute left-0 top-0 h-full w-72 overflow-y-auto bg-navy-900 text-white p-6" @click.outside="mobileNav = false">
                    <x-brand-mark dark size="h-9 w-9" />
                    <nav class="mt-8 space-y-1 text-sm">
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="grid">Dashboard</x-portal-nav-link>

                        <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Website Content</p>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.plans.index')" :active="request()->routeIs('admin.plans.*')" icon="currency">Pricing Plans</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.hourly-services.index')" :active="request()->routeIs('admin.hourly-services.*')" icon="clock">Per-Hour Services</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.payroll-tiers.index')" :active="request()->routeIs('admin.payroll-tiers.*')" icon="users">Payroll Tiers</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.integrations.index')" :active="request()->routeIs('admin.integrations.*')" icon="link">Integrations & POS</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.payment-gateways.index')" :active="request()->routeIs('admin.payment-gateways.*')" icon="currency">Payment Gateways</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.footer-links.index')" :active="request()->routeIs('admin.footer-links.*')" icon="link">Footer Links</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.settings.edit')" :active="request()->routeIs('admin.settings.*')" icon="cog">Site Settings</x-portal-nav-link>

                        <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Operations</p>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.leads.index')" :active="request()->routeIs('admin.leads.*')" icon="inbox">Leads</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.clients.index')" :active="request()->routeIs('admin.clients.*')" icon="users">Clients</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.requests.index')" :active="request()->routeIs('admin.requests.*')" icon="clipboard">Service Requests</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')" icon="user">Team / Staff</x-portal-nav-link>

                        <p class="px-3 pt-4 pb-1 text-[11px] font-semibold uppercase tracking-widest text-white/30">Account</p>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('admin.admin-users.index')" :active="request()->routeIs('admin.admin-users.*')" icon="cog">Admin Users</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="user">My Profile</x-portal-nav-link>
                        <x-portal-nav-link @click="mobileNav = false" :href="route('home')" icon="globe">View Website</x-portal-nav-link>
                    </nav>
                </div>
            </div>

            <main class="flex-1 px-4 py-6 lg:px-8 lg:py-8">
                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
