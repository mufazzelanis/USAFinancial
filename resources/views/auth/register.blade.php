<x-guest-layout>
    <h1 class="text-xl font-extrabold text-navy-900">Create your client account</h1>
    <p class="mt-1 text-sm text-slate-500">Get access to your dedicated client portal.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="mt-0" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-0" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="company" :value="__('Company (optional)')" />
                <x-text-input id="company" class="mt-0" type="text" name="company" :value="old('company')" autocomplete="organization" />
                <x-input-error :messages="$errors->get('company')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="phone" :value="__('Phone (optional)')" />
                <x-text-input id="phone" class="mt-0" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-0" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="mt-0" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5">{{ __('Register') }}</x-primary-button>

        <p class="text-center text-sm text-slate-500">
            Already registered?
            <a href="{{ route('login') }}" class="font-semibold text-navy-700 hover:text-gold-600">Log in</a>
        </p>
    </form>
</x-guest-layout>
