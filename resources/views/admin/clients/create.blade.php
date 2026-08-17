<x-admin-layout title="New Client">
    <x-admin.page-header title="New Client" subtitle="Create a customer account and optionally activate a plan." />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('admin.clients.store') }}" class="space-y-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Full Name" />
                    <x-text-input id="name" name="name" value="{{ old('name') }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="company" value="Company" />
                    <x-text-input id="company" name="company" value="{{ old('company') }}" class="mt-0" />
                </div>
                <div>
                    <x-input-label for="phone" value="Phone" />
                    <x-text-input id="phone" name="phone" value="{{ old('phone') }}" class="mt-0" />
                </div>
            </div>

            <div>
                <x-input-label for="password" value="Temporary Password" />
                <x-text-input id="password" type="text" name="password" value="{{ old('password') }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2 border-t border-slate-100 pt-5">
                <div>
                    <x-input-label for="plan_id" value="Activate Plan (optional)" />
                    <x-select-input id="plan_id" name="plan_id" class="mt-0">
                        <option value="">— No plan yet —</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->name }} (£{{ number_format($plan->price, 0) }}/mo)</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="account_manager_id" value="Account Manager (optional)" />
                    <x-select-input id="account_manager_id" name="account_manager_id" class="mt-0">
                        <option value="">— Unassigned —</option>
                        @foreach ($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </x-select-input>
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>Create Client</x-primary-button>
                <a href="{{ route('admin.clients.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
