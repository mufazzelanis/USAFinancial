@php($editing = $service->exists)

<x-admin-layout :title="$editing ? 'Edit Service' : 'New Service'">
    <x-admin.page-header :title="$editing ? 'Edit Service: '.$service->name : 'New Per-Hour Service'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.hourly-services.update', $service) : route('admin.hourly-services.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="name" value="Service Name" />
                    <x-text-input id="name" name="name" value="{{ old('name', $service->name) }}" required class="mt-0" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="slug" value="Slug (optional)" />
                    <x-text-input id="slug" name="slug" value="{{ old('slug', $service->slug) }}" class="mt-0" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-3">
                <div>
                    <x-input-label for="price_from" value="Price From (£/hr)" />
                    <x-text-input id="price_from" type="number" step="0.01" min="0" name="price_from" value="{{ old('price_from', $service->price_from) }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="currency" value="Currency" />
                    <x-text-input id="currency" name="currency" value="{{ old('currency', $service->currency ?: 'GBP') }}" required class="mt-0" />
                </div>
                <div>
                    <x-input-label for="sort_order" value="Sort Order" />
                    <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" required class="mt-0" />
                </div>
            </div>

            <div>
                <x-input-label for="icon" value="Icon Key" />
                <x-select-input id="icon" name="icon" class="mt-0">
                    @foreach (['book-open', 'document-text', 'calculator', 'user-group', 'chart-bar', 'pencil-square', 'academic-cap'] as $icon)
                        <option value="{{ $icon }}" @selected(old('icon', $service->icon) === $icon)>{{ str($icon)->headline() }}</option>
                    @endforeach
                </x-select-input>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $service->is_active : true)" />
                Active (visible on website)
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Service' }}</x-primary-button>
                <a href="{{ route('admin.hourly-services.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
