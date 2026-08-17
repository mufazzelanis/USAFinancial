@php
    $faviconPath = \App\Models\SiteSetting::get('site_favicon');
    $faviconUrl = $faviconPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($faviconPath) : null;
@endphp

@if ($faviconUrl)
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
@else
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48'%3E%3Ccircle cx='24' cy='24' r='23' fill='%230B2545' stroke='%23D4A017' stroke-width='1.5'/%3E%3Cpath d='M15 30 L15 20 Q15 15 20 15 L24 15' stroke='%23D4A017' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3Cpath d='M24 15 Q29 15 29 20 L29 22' stroke='%23FFFFFF' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3Cpath d='M33 18 L33 28 Q33 33 28 33 L24 33' stroke='%23FFFFFF' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3Cpath d='M24 33 Q19 33 19 28 L19 26' stroke='%23D4A017' stroke-width='3' fill='none' stroke-linecap='round'/%3E%3C/svg%3E">
@endif
