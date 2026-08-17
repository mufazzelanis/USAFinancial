@props(['label', 'value', 'icon' => 'grid', 'color' => 'navy'])

@php
$colors = [
    'navy' => 'bg-navy-900 text-gold-300',
    'gold' => 'bg-gold-500 text-navy-900',
    'green' => 'bg-green-600 text-white',
    'blue' => 'bg-blue-600 text-white',
    'purple' => 'bg-purple-600 text-white',
];
@endphp

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-center gap-4">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $colors[$color] ?? $colors['navy'] }}">
            <x-icon :icon="$icon" class="h-5 w-5" />
        </div>
        <div>
            <p class="text-2xl font-extrabold text-navy-900">{{ $value }}</p>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</p>
        </div>
    </div>
</div>
