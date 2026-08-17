@php($editing = $integration->exists)

<x-admin-layout :title="$editing ? 'Edit Integration' : 'New Integration'">
    <x-admin.page-header :title="$editing ? 'Edit: '.$integration->name : 'New Integration / Software'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.integrations.update', $integration) : route('admin.integrations.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" value="{{ old('name', $integration->name) }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="category" value="Category" />
                    <x-select-input id="category" name="category" class="mt-0">
                        <option value="integration" @selected(old('category', $integration->category) === 'integration')>Integration & Compliance</option>
                        <option value="setup" @selected(old('category', $integration->category) === 'setup')>Software Setup & Implement</option>
                        <option value="pos" @selected(old('category', $integration->category) === 'pos')>POS Software</option>
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="setup_price" value="Setup Price (£, optional)" />
                    <x-text-input id="setup_price" type="number" step="0.01" min="0" name="setup_price" value="{{ old('setup_price', $integration->setup_price) }}" class="mt-0" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <input type="hidden" name="currency" value="{{ old('currency', $integration->currency ?: 'GBP') }}">
                <div>
                    <x-input-label for="color" value="Accent Color" />
                    <x-text-input id="color" name="color" value="{{ old('color', $integration->color ?: 'slate') }}" class="mt-0" />
                </div>
                <div>
                    <x-input-label for="sort_order" value="Sort Order" />
                    <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $integration->sort_order ?? 0) }}" required class="mt-0" />
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $integration->is_active : true)" />
                Active (visible on website)
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create' }}</x-primary-button>
                <a href="{{ route('admin.integrations.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
