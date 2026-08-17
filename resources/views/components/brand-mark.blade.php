{{-- See brand-logo.blade.php: $size must stay "h-N w-auto max-w-[..]", never a square "h-N w-N". --}}
@props(['dark' => false, 'size' => 'h-10 w-auto max-w-[180px]'])

@php
    $hasCustomLogo = filled(\App\Models\SiteSetting::get('site_logo'));
    $companyName = \App\Models\SiteSetting::get('company_name', 'FirstServe Accounting');
    [$wordmarkMain, $wordmarkSub] = str($companyName)->wordCount() > 1
        ? [str($companyName)->before(' '), str($companyName)->after(' ')]
        : [$companyName, ''];
@endphp

<span class="inline-flex items-center gap-2.5">
    <x-brand-logo :class="$size" />
    @unless ($hasCustomLogo)
        <span class="leading-tight">
            <span class="block text-lg font-extrabold tracking-tight {{ $dark ? 'text-white' : 'text-navy-900' }}">{{ strtoupper($wordmarkMain) }}</span>
            @if ($wordmarkSub)
                <span class="block text-[10px] font-semibold tracking-[0.3em] {{ $dark ? 'text-gold-300' : 'text-gold-600' }}">{{ strtoupper($wordmarkSub) }}</span>
            @endif
        </span>
    @endunless
</span>
