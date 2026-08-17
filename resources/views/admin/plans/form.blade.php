@php($editing = $plan->exists)

<x-admin-layout :title="$editing ? 'Edit Plan' : 'New Plan'">
    <x-admin.page-header :title="$editing ? 'Edit Plan: '.$plan->name : 'New Plan'" />

    <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.plans.update', $plan) : route('admin.plans.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Plan Name" />
                    <x-text-input id="name" name="name" value="{{ old('name', $plan->name) }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="slug" value="Slug (optional)" />
                    <x-text-input id="slug" name="slug" value="{{ old('slug', $plan->slug) }}" class="mt-0" placeholder="auto-generated if left blank" />
                </div>
            </div>

            <div>
                <x-input-label for="tagline" value="Tagline" />
                <x-text-input id="tagline" name="tagline" value="{{ old('tagline', $plan->tagline) }}" class="mt-0" placeholder="e.g. Dedicated 160 Hours / Month" />
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <x-input-label for="price" value="Price / Month (£)" />
                    <x-text-input id="price" type="number" step="0.01" min="0" name="price" value="{{ old('price', $plan->price) }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="hours_per_month" value="Hours / Month" />
                    <x-text-input id="hours_per_month" type="number" min="0" name="hours_per_month" value="{{ old('hours_per_month', $plan->hours_per_month ?: 160) }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="currency" value="Currency" />
                    <x-text-input id="currency" name="currency" value="{{ old('currency', $plan->currency ?: 'GBP') }}" required class="mt-0" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="color" value="Card Color" />
                    <x-select-input id="color" name="color" class="mt-0">
                        @foreach (['green' => 'Green (Basic)', 'blue' => 'Blue (Growth)', 'purple' => 'Purple (Enterprise)'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('color', $plan->color) === $value)>{{ $label }}</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="sort_order" value="Sort Order" />
                    <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $plan->sort_order ?? 0) }}" required class="mt-0" />
                </div>
            </div>

            <div>
                <x-input-label for="features" value="Features (one per line)" />
                <x-textarea-input id="features" name="features" rows="7" class="mt-0">{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('features')" class="mt-1" />
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <x-checkbox name="is_featured" value="1" :checked="old('is_featured', $plan->is_featured)" />
                    Mark as "Most Popular"
                </label>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $plan->is_active : true)" />
                    Active (visible on website)
                </label>
            </div>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Plan' }}</x-primary-button>
                <a href="{{ route('admin.plans.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
