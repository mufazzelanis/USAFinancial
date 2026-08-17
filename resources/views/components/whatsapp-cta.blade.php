@props([
    'number' => null,
    'message' => null,
    'heading' => 'Ready to Get Started?',
    'subtext' => 'Message us on WhatsApp now — our team replies in minutes and can get you onboarded today.',
    'compact' => false,
])

@php
    $digits = preg_replace('/\D+/', '', (string) $number);
    $message = $message ?: "Hi, I'd like to know more about your services.";
@endphp

@if ($digits)
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#075E54] via-[#0d8a63] to-[#25D366] {{ $compact ? 'p-6 sm:p-8' : 'p-8 sm:p-14' }} text-center text-white shadow-2xl shadow-[#128C7E]/30">
        {{-- decorative glow --}}
        <div class="pointer-events-none absolute -top-16 -right-16 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-black/10 blur-3xl"></div>

        <div class="relative">
            <span class="relative mx-auto flex {{ $compact ? 'h-14 w-14' : 'h-20 w-20' }} items-center justify-center rounded-full bg-white/15">
                <span class="absolute inset-0 animate-ping rounded-full bg-white/20"></span>
                <svg class="relative {{ $compact ? 'h-7 w-7' : 'h-10 w-10' }}" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
            </span>

            <h2 class="mt-5 {{ $compact ? 'text-xl sm:text-2xl' : 'text-2xl sm:text-4xl' }} font-extrabold tracking-tight">{{ $heading }}</h2>
            <p class="mx-auto mt-3 max-w-xl {{ $compact ? 'text-sm' : 'text-base sm:text-lg' }} text-white/90">{{ $subtext }}</p>

            <a
                href="https://wa.me/{{ $digits }}?text={{ urlencode($message) }}"
                target="_blank"
                rel="noopener"
                class="group mt-8 inline-flex items-center gap-3 rounded-full bg-white {{ $compact ? 'px-7 py-3.5 text-sm' : 'px-10 py-5 text-lg' }} font-extrabold text-[#075E54] shadow-xl transition hover:scale-105 hover:shadow-2xl"
            >
                <svg class="{{ $compact ? 'h-5 w-5' : 'h-6 w-6' }} text-[#25D366]" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
                Chat With Us on WhatsApp
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>

            <p class="mt-4 flex items-center justify-center gap-1.5 text-xs font-semibold text-white/75">
                <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                Usually replies within minutes
            </p>
        </div>
    </div>
@endif
