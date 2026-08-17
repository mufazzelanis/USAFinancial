{{--
    Renders the site logo (or the default monogram) sized by HEIGHT only.
    Never force a square "w-N h-N" here — uploaded logos are usually wide
    wordmarks, and a square box combined with object-contain squeezes them
    down to a sliver to keep width inside the box. Pass a class like
    "h-10 w-auto max-w-[180px]": height pins the size, width follows the
    logo's own aspect ratio, and max-w just stops an extreme wide logo from
    overrunning tight layouts (sidebar, mobile header).
--}}
@props(['class' => 'h-10 w-auto max-w-[180px]'])

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
