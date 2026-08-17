@php($editing = $member->exists)

<x-admin-layout :title="$editing ? 'Edit Staff Member' : 'New Staff Member'">
    <x-admin.page-header :title="$editing ? 'Edit: '.$member->name : 'New Staff Member'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.staff.update', $member) : route('admin.staff.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Full Name" />
                    <x-text-input id="name" name="name" value="{{ old('name', $member->name) }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="role_title" value="Role" />
                    <x-select-input id="role_title" name="role_title" class="mt-0">
                        @foreach (\App\Models\StaffMember::roleTitles() as $value => $label)
                            <option value="{{ $value }}" @selected(old('role_title', $member->role_title) === $value)>{{ $label }}</option>
                        @endforeach
                    </x-select-input>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" type="email" name="email" value="{{ old('email', $member->email) }}" class="mt-0" />
                </div>
                <div>
                    <x-input-label for="phone" value="Phone" />
                    <x-text-input id="phone" name="phone" value="{{ old('phone', $member->phone) }}" class="mt-0" />
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $member->is_active : true)" />
                Active
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Add Staff Member' }}</x-primary-button>
                <a href="{{ route('admin.staff.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
