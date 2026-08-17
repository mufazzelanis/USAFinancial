<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-navy-900 border border-navy-900 rounded-lg font-semibold text-sm text-white hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2 active:bg-navy-950 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
