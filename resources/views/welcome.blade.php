<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $settings['company_name'] ?? 'FirstServe Accounting' }} — Reliable accounting, bookkeeping and payroll solutions to help your business grow with accuracy, compliance and confidence.">
    <title>{{ $settings['company_name'] ?? 'FirstServe Accounting' }} — Smart Accounting. Stronger Business.</title>
    <x-favicon-tags />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="font-sans antialiased text-slate-800 bg-white scroll-smooth"
    x-data="{ mobileMenu: false, quotePlan: '{{ old('plan_id') }}', quoteService: '{{ old('hourly_service_id') }}' }"
>
    @include('partials.site-header')

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-navy-50 via-white to-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.06]" aria-hidden="true">
            <svg class="absolute -right-24 top-0 h-full w-auto" viewBox="0 0 400 600" fill="none"><rect x="150" y="100" width="60" height="500" fill="#0B2545"/><rect x="130" y="140" width="100" height="20" fill="#0B2545"/><rect x="165" y="60" width="30" height="60" fill="#0B2545"/><rect x="175" y="20" width="10" height="50" fill="#0B2545"/></svg>
        </div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div>
                <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-navy-100 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-navy-700">
                    Reliable · Compliant · Confidential
                </p>
                <h1 class="text-4xl font-extrabold leading-[1.1] tracking-tight text-navy-900 sm:text-5xl lg:text-6xl">
                    {{ $settings['hero_line_1'] ?? 'Smart Accounting.' }}<br>
                    {{ $settings['hero_line_2'] ?? 'Stronger Business.' }}<br>
                    <span class="text-gold-500">{{ $settings['hero_line_3'] ?? 'Global Expertise.' }}</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg text-slate-600">
                    {{ $settings['hero_subtitle'] ?? 'Reliable accounting, bookkeeping and payroll solutions to help your business grow with accuracy, compliance and confidence.' }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#quote" class="inline-flex items-center gap-2 rounded-full bg-gold-500 px-7 py-3.5 text-sm font-bold text-navy-950 shadow-lg shadow-gold-500/20 transition hover:bg-gold-400">
                        Get a Free Quote
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                    <a href="#pricing" class="inline-flex items-center gap-2 rounded-full border-2 border-navy-900 px-7 py-3.5 text-sm font-bold text-navy-900 transition hover:bg-navy-900 hover:text-white">
                        View Pricing
                    </a>
                </div>

                <div class="mt-12 grid grid-cols-2 gap-6 sm:grid-cols-4">
                    @foreach ([
                        ['icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Trusted Professionals'],
                        ['icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'label' => 'Dedicated Team'],
                        ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'label' => 'Confidential & Secure'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'On Time Every Time'],
                    ] as $trust)
                        <div class="flex flex-col items-start gap-2">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-navy-900 text-gold-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $trust['icon'] }}" /></svg>
                            </span>
                            <span class="text-xs font-semibold leading-tight text-slate-600">{{ $trust['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Illustration: laptop dashboard mockup --}}
            <div class="relative mx-auto w-full max-w-lg">
                <div class="absolute -left-6 -top-6 h-40 w-40 rounded-full bg-gold-200/50 blur-3xl"></div>
                <div class="absolute -bottom-10 -right-6 h-48 w-48 rounded-full bg-navy-200/50 blur-3xl"></div>

                <div class="relative rounded-2xl border border-slate-200 bg-white p-4 shadow-2xl shadow-navy-900/10">
                    <div class="mb-3 flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-green-400"></span>
                        <span class="ml-3 text-[11px] font-semibold text-slate-400">FirstServe Dashboard</span>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-2 rounded-xl bg-navy-900 p-4">
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-gold-300">Monthly Revenue</p>
                            <p class="mt-1 text-2xl font-extrabold text-white">£48,250</p>
                            <div class="mt-4 flex h-16 items-end gap-1.5">
                                @foreach ([40, 55, 35, 70, 50, 85, 65] as $h)
                                    <span class="flex-1 rounded-t bg-gold-400/90" style="height: {{ $h }}%"></span>
                                @endforeach
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3 flex flex-col items-center justify-center">
                            <div class="relative h-16 w-16 rounded-full" style="background: conic-gradient(#D4A017 0% 68%, #E2E8F0 68% 100%)">
                                <div class="absolute inset-2 flex items-center justify-center rounded-full bg-white text-xs font-bold text-navy-900">68%</div>
                            </div>
                            <p class="mt-2 text-[10px] font-semibold text-slate-500">Compliance</p>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-100 p-3">
                            <p class="text-[11px] font-semibold text-slate-400">VAT Return</p>
                            <p class="mt-1 flex items-center gap-1 text-sm font-bold text-green-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Filed on time
                            </p>
                        </div>
                        <div class="rounded-xl border border-slate-100 p-3">
                            <p class="text-[11px] font-semibold text-slate-400">Payroll Run</p>
                            <p class="mt-1 text-sm font-bold text-navy-900">28 Aug · 12 staff</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-6 -left-8 hidden items-center gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-xl sm:flex">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gold-100 text-gold-600">☕</span>
                    <div>
                        <p class="text-xs font-bold text-navy-900">FirstServe Team</p>
                        <p class="text-[11px] text-slate-500">Online now</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Dedicated resource strip --}}
    <section class="bg-navy-900 text-white">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-center gap-x-10 gap-y-4 px-4 py-4 text-sm font-semibold sm:px-6 lg:justify-between lg:px-8">
            @foreach ([
                ['icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'label' => 'Dedicated Resource'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => ($settings['dedicated_hours'] ?? 160).' Hours Monthly'],
                ['icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'label' => 'Flexible & Scalable'],
                ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'label' => 'Clear Communication'],
            ] as $item)
                <div class="flex items-center gap-2.5">
                    <svg class="h-5 w-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                    {{ $item['label'] }}
                </div>
            @endforeach
        </div>
    </section>

    {{-- Dedicated Monthly Package --}}
    <section id="package" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-3 text-center">
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">Dedicated Monthly Package</h2>
                <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-xs font-bold uppercase tracking-wide text-green-700">
                    Competitive. Reliable. Dedicated.
                </span>
            </div>

            <div class="mt-10 overflow-hidden rounded-2xl border border-slate-200 shadow-lg">
                <div class="grid divide-y divide-slate-200 lg:grid-cols-5 lg:divide-x lg:divide-y-0">
                    <div class="flex flex-col items-center justify-center gap-1 bg-navy-900 p-8 text-center text-white lg:col-span-1">
                        <span class="text-5xl font-extrabold text-gold-400">{{ $settings['dedicated_hours'] ?? 160 }}</span>
                        <span class="text-sm font-bold uppercase tracking-widest">Hours</span>
                        <span class="text-xs text-white/70">Per Month</span>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-2 p-8 text-center">
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Competitive Price Per Month</span>
                        <span class="rounded-full bg-navy-900 px-5 py-1.5 text-lg font-extrabold text-gold-300">{{ $settings['dedicated_currency'] ?? 'GBP' }}</span>
                    </div>
                    @foreach ([
                        ['icon' => 'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2', 'title' => 'Accountant', 'desc' => 'Financial reporting, budgeting & analysis'],
                        ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Bookkeeper', 'desc' => 'Daily bookkeeping, bank reconciliation, AP & AR'],
                        ['icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'title' => 'Payroll Associate', 'desc' => 'Payroll processing, payslips, tax & compliance'],
                    ] as $role)
                        <div class="flex flex-col items-center gap-2 p-8 text-center">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-gold-100 text-gold-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $role['icon'] }}" /></svg>
                            </span>
                            <span class="font-bold text-navy-900">{{ $role['title'] }}</span>
                            <span class="text-xs text-slate-500">{{ $role['desc'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Per hour services --}}
    <section id="services" class="bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">Per Hour Services</h2>
                <span class="inline-flex items-center rounded-full bg-gold-500 px-4 py-1 text-xs font-bold uppercase tracking-wide text-navy-950">From</span>
            </div>
            <p class="mt-2 max-w-2xl text-sm text-slate-500">Pricing may vary based on complexity and volume of work.</p>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-7">
                @php
                    $serviceIcons = [
                        'book-open' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
                        'document-text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'calculator' => 'M9 7h6m-6 4h6m-6 4h.01M15 15h.01M9 19h6a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2 2v10a2 2 0 002 2z',
                        'user-group' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4',
                        'chart-bar' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                        'pencil-square' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                        'academic-cap' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z',
                    ];
                @endphp
                @foreach ($hourlyServices as $service)
                    <div class="flex flex-col items-center gap-3 rounded-xl border border-slate-200 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-navy-900 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $serviceIcons[$service->icon] ?? $serviceIcons['document-text'] }}" /></svg>
                        </span>
                        <span class="text-sm font-bold text-navy-900">{{ $service->name }}</span>
                        <span class="text-xs font-semibold text-slate-400">From</span>
                        <span class="text-lg font-extrabold text-gold-600">£{{ number_format($service->price_from, 0) }}<span class="text-xs font-medium text-slate-400">/hr</span></span>
                        <a href="#quote" @click="quoteService = '{{ $service->id }}'" class="mt-1 text-xs font-bold text-navy-700 underline underline-offset-2 hover:text-gold-600">Request</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pricing plans --}}
    <section id="pricing" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">Choose Your Plan</h2>
                <p class="mx-auto mt-2 max-w-xl text-sm text-slate-500">Every plan includes a dedicated {{ $settings['dedicated_hours'] ?? 160 }} hours / month resource team.</p>
            </div>

            <div class="mt-10 grid gap-8 md:grid-cols-3">
                @php
                    $planTheme = [
                        'green' => ['ring' => 'border-green-200', 'bar' => 'bg-green-600', 'chip' => 'bg-green-50 text-green-700', 'price' => 'bg-green-600', 'icon' => 'text-green-600'],
                        'blue' => ['ring' => 'border-blue-300', 'bar' => 'bg-blue-600', 'chip' => 'bg-blue-50 text-blue-700', 'price' => 'bg-blue-600', 'icon' => 'text-blue-600'],
                        'purple' => ['ring' => 'border-purple-200', 'bar' => 'bg-purple-600', 'chip' => 'bg-purple-50 text-purple-700', 'price' => 'bg-purple-600', 'icon' => 'text-purple-600'],
                    ];
                @endphp
                @foreach ($plans as $plan)
                    @php
                        $theme = $planTheme[$plan->color] ?? $planTheme['blue'];
                    @endphp
                    <div class="relative flex flex-col rounded-2xl border-2 {{ $theme['ring'] }} bg-white shadow-sm transition hover:shadow-xl {{ $plan->is_featured ? 'lg:-translate-y-3 shadow-xl' : '' }}">
                        @if ($plan->is_featured)
                            <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-gold-500 px-4 py-1 text-[11px] font-bold uppercase tracking-wide text-navy-950 shadow">Most Popular</span>
                        @endif
                        <div class="h-2 rounded-t-2xl {{ $theme['bar'] }}"></div>
                        <div class="flex flex-1 flex-col p-7">
                            <span class="inline-flex w-fit items-center rounded-full {{ $theme['chip'] }} px-3 py-1 text-[11px] font-bold uppercase tracking-wide">{{ $plan->tagline }}</span>
                            <h3 class="mt-4 text-xl font-extrabold text-navy-900">{{ $plan->name }}</h3>

                            <ul class="mt-5 flex-1 space-y-2.5 text-sm text-slate-600">
                                @foreach ($plan->features as $feature)
                                    <li class="flex items-start gap-2">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 {{ $theme['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-6 flex items-end justify-between gap-2 border-t border-slate-100 pt-5">
                                <div>
                                    <span class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Starting From</span>
                                    <p class="text-3xl font-extrabold text-navy-900">£{{ number_format($plan->price, 0) }}<span class="text-sm font-medium text-slate-400">/mo</span></p>
                                </div>
                                <a href="{{ route('plans.show', $plan) }}" class="inline-flex items-center gap-1.5 rounded-full {{ $theme['price'] }} px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:opacity-90">
                                    Get Started
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Compliance Payroll, VAT & Licensing --}}
    <section id="payroll" class="relative overflow-hidden bg-navy-950 py-16 text-white sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-extrabold tracking-tight sm:text-3xl">Compliance Payroll, VAT & Licensing</h2>

            <div class="mt-10 grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)]">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-7">
                    <p class="mb-4 flex items-center gap-2 text-lg font-extrabold">
                        <span>🇬🇧</span> UK Payroll Management
                    </p>
                    <ul class="space-y-3 text-sm text-white/80">
                        @foreach (['Real Time Information', 'HMRC Compliant', 'Auto Enrolment', 'Pension Management', 'Payslips & P60/P45', 'Year End Submissions'] as $item)
                            <li class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ($payrollTiers as $tier)
                        <div class="flex flex-col rounded-2xl border border-white/10 bg-white/5 p-6">
                            <p class="text-xs font-bold uppercase tracking-widest text-gold-400">Payroll for UK LTD</p>
                            <div class="mt-4 grid grid-cols-2 gap-3 text-[11px] font-semibold text-white/70">
                                @foreach (($tier->features ?: []) as $feature)
                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        {{ $feature }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-4">
                                <span class="rounded-full bg-white/10 px-3 py-1 text-[11px] font-bold">Up to {{ $tier->employee_limit }} Employees</span>
                            </div>
                            <div class="mt-3 rounded-xl bg-gold-500 px-4 py-2.5 text-center">
                                <span class="text-lg font-extrabold text-navy-950">£{{ number_format($tier->price, 0) }}</span>
                                <span class="text-xs font-semibold text-navy-800">Per Month</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Integrations, Setup & POS --}}
    <section id="integrations" class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">Software We Work With</h2>

            <div class="mt-10 grid gap-8 lg:grid-cols-3">
                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500">Integration & Compliance</h3>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($integrations as $integration)
                            <span class="rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-bold text-navy-800">{{ $integration->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500">Software Setup & Implement</h3>
                    <div class="space-y-2">
                        @foreach ($setupSoftware as $software)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 px-3.5 py-2.5">
                                <span class="text-xs font-bold text-navy-800">{{ $software->name }}</span>
                                <span class="text-xs font-bold text-gold-600">Setup from £{{ number_format($software->setup_price, 0) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-500">POS Software</h3>
                    <div class="flex h-full flex-col justify-between rounded-2xl bg-navy-900 p-6 text-white">
                        <div>
                            <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-gold-500 text-navy-950">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a1 1 0 001-1V6a1 1 0 00-1-1H3a1 1 0 00-1 1v12a1 1 0 001 1z" /></svg>
                            </span>
                            <p class="mt-4 text-lg font-extrabold">Smart POS Solutions for Every Business</p>
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-extrabold text-gold-400">£{{ number_format(optional($posSoftware)->setup_price ?? 39, 0) }}</span>
                                <span class="text-xs text-white/70">/month</span>
                            </div>
                            <a href="#quote" class="rounded-full bg-gold-500 px-4 py-2 text-xs font-bold text-navy-950">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Payment gateways --}}
    <section class="bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">Payment Gateway for Your Account Open in UK</h2>

            <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($paymentGateways as $gateway)
                    <div class="rounded-xl border border-slate-200 bg-white p-5">
                        <p class="text-base font-extrabold text-navy-900">{{ $gateway->name }}</p>
                        <ul class="mt-3 space-y-1.5 text-xs text-slate-500">
                            @foreach (($gateway->features ?: []) as $feature)
                                <li class="flex items-center gap-1.5">
                                    <span class="h-1 w-1 rounded-full bg-gold-500"></span>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Quote / Contact --}}
    <section id="quote" class="bg-white py-16 sm:py-20">
        <div class="mx-auto grid max-w-5xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">{{ $settings['footer_cta_title'] ?? "Let's Work Together!" }}</h2>
                <p class="mt-3 text-slate-500">{{ $settings['footer_cta_subtitle'] ?? 'Get a dedicated expert, save time & reduce cost.' }}</p>

                <div class="mt-8 space-y-4 text-sm">
                    @if(!empty($settings['phone']))
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-navy-900 text-gold-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </span>
                            <span class="font-semibold text-navy-900">{{ $settings['phone'] }}</span>
                        </div>
                    @endif
                    @if(!empty($settings['email']))
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-navy-900 text-gold-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </span>
                            <span class="font-semibold text-navy-900">{{ $settings['email'] }}</span>
                        </div>
                    @endif
                    @if(!empty($settings['website']))
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-navy-900 text-gold-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 010 18 15 15 0 010-18z" /></svg>
                            </span>
                            <span class="font-semibold text-navy-900">{{ $settings['website'] }}</span>
                        </div>
                    @endif
                </div>

                @if (($settings['whatsapp_enabled'] ?? '1') === '1' && \App\Models\SiteSetting::whatsappNumber())
                    <a
                        href="https://wa.me/{{ \App\Models\SiteSetting::whatsappNumber() }}?text={{ urlencode($settings['whatsapp_message'] ?? "Hi, I'd like to know more about your services.") }}"
                        target="_blank"
                        rel="noopener"
                        class="group relative mt-8 flex items-center gap-4 overflow-hidden rounded-2xl bg-gradient-to-r from-[#075E54] to-[#25D366] p-5 shadow-lg shadow-[#25D366]/25 transition hover:-translate-y-0.5 hover:shadow-xl"
                    >
                        <span class="relative flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-white/15">
                            <span class="absolute inset-0 animate-ping rounded-full bg-white/20"></span>
                            <svg class="relative h-9 w-9 text-white" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-base font-extrabold text-white">Chat with us on WhatsApp</p>
                            <p class="mt-0.5 flex items-center gap-1.5 text-xs font-medium text-white/80">
                                <span class="h-1.5 w-1.5 rounded-full bg-lime-300"></span>
                                Usually replies within minutes
                            </p>
                        </div>
                        <svg class="h-5 w-5 shrink-0 text-white/70 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                @if (session('quote_success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('quote_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('quote.store') }}" class="space-y-4">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input id="name" name="name" value="{{ old('name') }}" required class="mt-0" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-0" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" value="{{ old('phone') }}" class="mt-0" />
                        </div>
                        <div>
                            <x-input-label for="company" value="Company" />
                            <x-text-input id="company" name="company" value="{{ old('company') }}" class="mt-0" />
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="plan_id" value="Interested Plan" />
                            <x-select-input id="plan_id" name="plan_id" x-model="quotePlan" class="mt-0">
                                <option value="">— Not sure yet —</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} (£{{ number_format($plan->price, 0) }}/mo)</option>
                                @endforeach
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label for="hourly_service_id" value="Or a Per-Hour Service" />
                            <x-select-input id="hourly_service_id" name="hourly_service_id" x-model="quoteService" class="mt-0">
                                <option value="">— Not applicable —</option>
                                @foreach ($hourlyServices as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }} (£{{ number_format($service->price_from, 0) }}/hr)</option>
                                @endforeach
                            </x-select-input>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="message" value="Message (optional)" />
                        <x-textarea-input id="message" name="message" rows="3" class="mt-0">{{ old('message') }}</x-textarea-input>
                    </div>
                    <x-primary-button class="w-full justify-center py-3">Request a Quote</x-primary-button>
                </form>
            </div>
        </div>
    </section>

    @include('partials.site-footer')
</body>
</html>
