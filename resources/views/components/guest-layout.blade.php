<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FirstServe Accounting') }}</title>
    <x-favicon-tags />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-navy-50 via-white to-white px-4 py-10">
        <a href="{{ route('home') }}" class="mb-8">
            <x-brand-mark size="h-16 w-auto max-w-[260px]" />
        </a>

        <div class="w-full sm:max-w-md overflow-hidden rounded-2xl border border-slate-200 bg-white px-6 py-7 shadow-lg shadow-navy-900/5 sm:px-8">
            {{ $slot }}
        </div>

        <a href="{{ route('home') }}" class="mt-6 text-xs font-semibold text-slate-400 hover:text-navy-700">&larr; Back to website</a>
    </div>
</body>
</html>
