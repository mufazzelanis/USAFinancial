@props(['status'])

@php
$map = [
    'pending' => 'bg-amber-100 text-amber-700',
    'in_progress' => 'bg-blue-100 text-blue-700',
    'completed' => 'bg-green-100 text-green-700',
    'cancelled' => 'bg-slate-200 text-slate-600',
    'new' => 'bg-blue-100 text-blue-700',
    'contacted' => 'bg-amber-100 text-amber-700',
    'converted' => 'bg-green-100 text-green-700',
    'closed' => 'bg-slate-200 text-slate-600',
    'active' => 'bg-green-100 text-green-700',
    'paused' => 'bg-amber-100 text-amber-700',
];
$classes = $map[$status] ?? 'bg-slate-200 text-slate-600';
@endphp

<span {{ $attributes->merge(['class' => "rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide $classes"]) }}>
    {{ str($status)->replace('_', ' ') }}
</span>
