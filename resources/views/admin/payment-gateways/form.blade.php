@php($editing = $gateway->exists)

<x-admin-layout :title="$editing ? 'Edit Gateway' : 'New Gateway'">
    <x-admin.page-header :title="$editing ? 'Edit: '.$gateway->name : 'New Payment Gateway'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.payment-gateways.update', $gateway) : route('admin.payment-gateways.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" name="name" value="{{ old('name', $gateway->name) }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="sort_order" value="Sort Order" />
                    <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $gateway->sort_order ?? 0) }}" required class="mt-0" />
                </div>
            </div>

            <div>
                <x-input-label for="features" value="Feature Bullets (one per line)" />
                <x-textarea-input id="features" name="features" rows="4" class="mt-0">{{ old('features', is_array($gateway->features) ? implode("\n", $gateway->features) : '') }}</x-textarea-input>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $gateway->is_active : true)" />
                Active (visible on website)
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Gateway' }}</x-primary-button>
                <a href="{{ route('admin.payment-gateways.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
