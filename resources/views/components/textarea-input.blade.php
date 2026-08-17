@props(['disabled' => false, 'rows' => 4])

<textarea @disabled($disabled) rows="{{ $rows }}" {{ $attributes->merge(['class' => 'w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-navy-500 focus:ring-navy-500']) }}>{{ $slot }}</textarea>
