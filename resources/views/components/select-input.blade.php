@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-navy-500 focus:ring-navy-500']) }}>
    {{ $slot }}
</select>
