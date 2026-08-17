@props([
    'number' => null,
    'message' => "Hi, I'd like to know more about your services.",
    'name' => 'FirstServe Accounting',
])

@php
    $digits = preg_replace('/\D+/', '', (string) $number);
    $message = $message ?: "Hi, I'd like to know more about your services.";
    $name = $name ?: 'FirstServe Accounting';
@endphp

@if ($digits)
    <div
        x-data="{ open: false, dismissed: false }"
        x-init="setTimeout(() => { if (!dismissed) open = true }, 2500)"
        class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3"
    >
        {{-- Teaser popup --}}
        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="relative w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
        >
            <button
                @click="open = false; dismissed = true"
                aria-label="Close"
                class="absolute right-2 top-2 z-10 flex h-6 w-6 items-center justify-center rounded-full bg-white/80 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
            >
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <div class="flex items-center gap-3 bg-[#075E54] px-4 py-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/15 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-white">{{ $name }}</p>
                    <p class="text-[11px] text-white/80">Usually replies within minutes</p>
                </div>
            </div>

            <div class="px-4 py-3">
                <p class="rounded-xl rounded-tl-sm bg-slate-100 px-3 py-2 text-sm text-slate-700">
                    👋 {{ $message }}
                </p>
                <a
                    href="https://wa.me/{{ $digits }}?text={{ urlencode($message) }}"
                    target="_blank"
                    rel="noopener"
                    class="mt-3 flex items-center justify-center gap-2 rounded-lg bg-[#25D366] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#20bd5a]"
                >
                    <svg class="h-4 w-4" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
                    Start Chat
                </a>
            </div>
        </div>

        {{-- Floating action button --}}
        <a
            href="https://wa.me/{{ $digits }}?text={{ urlencode($message) }}"
            target="_blank"
            rel="noopener"
            aria-label="Chat with us on WhatsApp"
            class="group relative flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl shadow-[#25D366]/40 transition hover:scale-105 hover:bg-[#20bd5a]"
        >
            <span class="absolute inset-0 animate-ping rounded-full bg-[#25D366] opacity-75"></span>
            <svg class="relative h-7 w-7" viewBox="0 0 32 32" fill="currentColor"><path d="M16.004 3C9.376 3 4 8.373 4 15c0 2.31.65 4.47 1.78 6.31L4 29l7.86-1.75A11.94 11.94 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm6.98 17.02c-.29.82-1.7 1.57-2.35 1.66-.6.09-1.36.13-2.2-.14-.5-.16-1.15-.38-1.99-.74-3.5-1.51-5.78-5.05-5.96-5.29-.17-.24-1.43-1.9-1.43-3.63s.92-2.58 1.24-2.93c.33-.35.71-.44.95-.44.24 0 .48 0 .69.01.22.01.52-.08.81.62.29.72 1 2.45 1.09 2.63.09.18.14.39.03.63-.11.24-.17.39-.34.6-.17.21-.36.47-.51.63-.17.18-.35.37-.15.72.2.35.9 1.48 1.93 2.4 1.33 1.18 2.44 1.55 2.79 1.72.35.18.56.15.77-.09.2-.24.87-1.01 1.1-1.36.23-.35.46-.29.77-.18.32.12 2.02.95 2.37 1.13.35.17.58.26.66.4.1.15.1.86-.19 1.68Z"/></svg>
        </a>
    </div>
@endif
