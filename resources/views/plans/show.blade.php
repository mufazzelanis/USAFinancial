<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $plan->name }} — {{ $plan->tagline }}. £{{ number_format($plan->price, 0) }}/month from {{ $settings['company_name'] ?? 'FirstServe Accounting' }}.">
    <title>{{ $plan->name }} — {{ $settings['company_name'] ?? 'FirstServe Accounting' }}</title>
    <x-favicon-tags />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white scroll-smooth" x-data="{ mobileMenu: false }">

    @include('partials.site-header')

    @php
        $planTheme = [
            'green' => ['ring' => 'border-green-200', 'bar' => 'bg-green-600', 'chip' => 'bg-green-50 text-green-700', 'price' => 'bg-green-600', 'icon' => 'text-green-600'],
            'blue' => ['ring' => 'border-blue-300', 'bar' => 'bg-blue-600', 'chip' => 'bg-blue-50 text-blue-700', 'price' => 'bg-blue-600', 'icon' => 'text-blue-600'],
            'purple' => ['ring' => 'border-purple-200', 'bar' => 'bg-purple-600', 'chip' => 'bg-purple-50 text-purple-700', 'price' => 'bg-purple-600', 'icon' => 'text-purple-600'],
        ];
        $theme = $planTheme[$plan->color] ?? $planTheme['blue'];
        $waMessage = "Hi, I'm interested in the {$plan->name} (£".number_format($plan->price, 0)."/mo). Please help me get started.";
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-navy-50 via-white to-white">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
            <a href="{{ route('home') }}#pricing" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-navy-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to all plans
            </a>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-full {{ $theme['chip'] }} px-3 py-1 text-xs font-bold uppercase tracking-wide">{{ $plan->tagline }}</span>
                @if ($plan->is_featured)
                    <span class="inline-flex items-center rounded-full bg-gold-500 px-3 py-1 text-xs font-bold uppercase tracking-wide text-navy-950">Most Popular</span>
                @endif
            </div>

            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-navy-900 sm:text-5xl">{{ $plan->name }}</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">
                A dedicated {{ $plan->hours_per_month }} hours / month resource team — everything you need to stay compliant, organised and confidently in control of your numbers.
            </p>

            <div class="mt-8 flex flex-wrap items-end gap-3">
                <span class="text-5xl font-extrabold text-navy-900">£{{ number_format($plan->price, 0) }}</span>
                <span class="pb-1.5 text-lg text-slate-400">/ month</span>
                <span class="mb-1.5 h-2 w-2 rounded-full {{ $theme['bar'] }}"></span>
            </div>
        </div>
    </section>

    {{-- Primary, unmissable WhatsApp CTA --}}
    <section class="px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <x-whatsapp-cta
                :number="\App\Models\SiteSetting::whatsappNumber()"
                :message="$waMessage"
                :heading="'Get Started with the '.$plan->name.' — Instantly'"
                subtext="Skip the forms. Message our team on WhatsApp right now and we'll walk you through onboarding today."
            />
        </div>
    </section>

    {{-- What's included --}}
    <section class="py-14 sm:py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-navy-900 sm:text-3xl">What's Included</h2>
            <p class="mt-2 text-sm text-slate-500">Everything covered under the {{ $plan->name }}.</p>

            <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                @foreach ($plan->features as $feature)
                    <li class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 {{ $theme['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <span class="text-sm font-medium text-slate-700">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Second WhatsApp CTA for anyone who scrolled through the features --}}
    <section class="bg-slate-50 py-14 sm:py-20">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <x-whatsapp-cta
                :number="\App\Models\SiteSetting::whatsappNumber()"
                :message="$waMessage"
                heading="Still Deciding?"
                subtext="Ask us anything about the {{ $plan->name }} — pricing, onboarding, switching accountants — our team is on WhatsApp now."
                :compact="true"
            />

            <p class="mt-6 text-center text-sm text-slate-400">
                Prefer email instead?
                <a href="{{ route('home') }}#quote" class="font-semibold text-navy-600 underline underline-offset-2 hover:text-navy-900">Fill out our contact form</a>
            </p>
        </div>
    </section>

    {{-- Other plans --}}
    @if ($otherPlans->isNotEmpty())
        <section class="py-14 sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-center text-xl font-extrabold tracking-tight text-navy-900">Looking for something else?</h2>
                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    @foreach ($otherPlans as $other)
                        @php($otherTheme = $planTheme[$other->color] ?? $planTheme['blue'])
                        <a href="{{ route('plans.show', $other) }}" class="group flex items-center justify-between rounded-2xl border-2 {{ $otherTheme['ring'] }} bg-white p-6 shadow-sm transition hover:shadow-lg">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide {{ $otherTheme['icon'] }}">{{ $other->tagline }}</p>
                                <p class="mt-1 text-lg font-extrabold text-navy-900">{{ $other->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">£{{ number_format($other->price, 0) }}/month</p>
                            </div>
                            <svg class="h-5 w-5 text-slate-400 transition group-hover:translate-x-1 group-hover:text-navy-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('partials.site-footer')
    <x-tracking-scripts />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.Tracking) {
                Tracking.event('ViewContent', 'view_item', {
                    content_name: @js($plan->name),
                    content_ids: [@js((string) $plan->id)],
                    content_type: 'product',
                    currency: 'GBP',
                    value: @js((float) $plan->price),
                });
            }
        });
    </script>
</body>
</html>
