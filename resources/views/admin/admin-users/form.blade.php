@php($editing = $adminUser->exists)

<x-admin-layout :title="$editing ? 'Edit Admin User' : 'New Admin User'">
    <x-admin.page-header :title="$editing ? 'Edit: '.$adminUser->name : 'New Admin User'" subtitle="This person will be able to log in and manage the whole admin panel." />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.admin-users.update', $adminUser) : route('admin.admin-users.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" name="name" value="{{ old('name', $adminUser->name) }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" type="email" name="email" value="{{ old('email', $adminUser->email) }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="password" :value="$editing ? 'New Password (optional)' : 'Password'" />
                    <x-text-input id="password" type="password" name="password" :required="! $editing" class="mt-0" autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    @if ($editing)
                        <p class="mt-1.5 text-xs text-slate-400">Leave blank to keep their current password.</p>
                    @endif
                </div>
                <div>
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" :required="! $editing" class="mt-0" autocomplete="new-password" />
                </div>
            </div>

            @if ($editing)
                @if ($adminUser->id === auth()->id())
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-400">
                        <input type="checkbox" checked disabled class="rounded border-slate-300 text-navy-600 shadow-sm">
                        Active (can log in)
                    </label>
                    <input type="hidden" name="is_active" value="1">
                    <p class="mt-1 text-xs text-slate-400">You can't deactivate your own account.</p>
                @else
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <input type="hidden" name="is_active" value="0">
                        <x-checkbox name="is_active" value="1" :checked="old('is_active', $adminUser->is_active)" />
                        Active (can log in)
                    </label>
                @endif
            @endif

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Admin User' }}</x-primary-button>
                <a href="{{ route('admin.admin-users.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
