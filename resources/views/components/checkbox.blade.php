@props(['disabled' => false])

<input type="checkbox" @disabled($disabled) {{ $attributes->merge(['class' => 'rounded border-slate-300 text-navy-600 shadow-sm focus:ring-navy-500']) }}>
