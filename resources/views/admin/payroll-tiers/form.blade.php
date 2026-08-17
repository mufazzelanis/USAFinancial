@php($editing = $tier->exists)

<x-admin-layout :title="$editing ? 'Edit Payroll Tier' : 'New Payroll Tier'">
    <x-admin.page-header :title="$editing ? 'Edit Tier: '.$tier->name : 'New Payroll Tier'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.payroll-tiers.update', $tier) : route('admin.payroll-tiers.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" value="{{ old('name', $tier->name ?: 'Payroll for UK LTD') }}" required class="mt-0" />
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <x-input-label for="employee_limit" value="Employee Limit" />
                    <x-text-input id="employee_limit" type="number" min="1" name="employee_limit" value="{{ old('employee_limit', $tier->employee_limit) }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="price" value="Price / Month (£)" />
                    <x-text-input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $tier->price) }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="sort_order" value="Sort Order" />
                    <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $tier->sort_order ?? 0) }}" required class="mt-0" />
                </div>
            </div>

            <input type="hidden" name="currency" value="{{ old('currency', $tier->currency ?: 'GBP') }}">

            <div>
                <x-input-label for="features" value="Features (one per line)" />
                <x-textarea-input id="features" name="features" rows="5" class="mt-0">{{ old('features', is_array($tier->features) ? implode("\n", $tier->features) : '') }}</x-textarea-input>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $tier->is_active : true)" />
                Active (visible on website)
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Tier' }}</x-primary-button>
                <a href="{{ route('admin.payroll-tiers.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
