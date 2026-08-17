@php($layout = auth()->user()->isAdmin() ? 'admin-layout' : 'customer-layout')

<x-dynamic-component :component="$layout" title="My Profile">
    <div class="mx-auto max-w-2xl space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-2xl border border-red-100 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-dynamic-component>
