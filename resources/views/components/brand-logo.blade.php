@props(['class' => 'h-10 w-10'])

@php
    $logoPath = \App\Models\SiteSetting::get('site_logo');
@endphp

@if ($logoPath)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logoPath) }}"
        alt="Logo"
        {{ $attributes->merge(['class' => $class.' object-contain']) }}
    >
@else
    <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => $class]) }}>
        <circle cx="24" cy="24" r="23" fill="#0B2545" stroke="#D4A017" stroke-width="1.5" />
        <circle cx="24" cy="24" r="18" fill="none" stroke="#D4A017" stroke-width="1" opacity="0.35" />
        <path d="M15 30 L15 20 Q15 15 20 15 L24 15" stroke="#D4A017" stroke-width="2.5" fill="none" stroke-linecap="round" />
        <path d="M24 15 Q29 15 29 20 L29 22" stroke="#FFFFFF" stroke-width="2.5" fill="none" stroke-linecap="round" />
        <path d="M33 18 L33 28 Q33 33 28 33 L24 33" stroke="#FFFFFF" stroke-width="2.5" fill="none" stroke-linecap="round" />
        <path d="M24 33 Q19 33 19 28 L19 26" stroke="#D4A017" stroke-width="2.5" fill="none" stroke-linecap="round" />
        <circle cx="24" cy="24" r="2.2" fill="#D4A017" />
    </svg>
@endif
