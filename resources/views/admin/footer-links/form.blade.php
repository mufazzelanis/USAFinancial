@php($editing = $link->exists)

<x-admin-layout :title="$editing ? 'Edit Footer Link' : 'New Footer Link'">
    <x-admin.page-header :title="$editing ? 'Edit: '.$link->label : 'New Footer Link'" />

    <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ $editing ? route('admin.footer-links.update', $link) : route('admin.footer-links.store') }}" class="space-y-5">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div>
                <x-input-label for="label" value="Label" />
                <x-text-input id="label" name="label" value="{{ old('label', $link->label) }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('label')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="url" value="URL" />
                <x-text-input id="url" name="url" value="{{ old('url', $link->url) }}" required class="mt-0" placeholder="#pricing or https://example.com" />
                <p class="mt-1.5 text-xs text-slate-400">Use a page anchor like <code>#pricing</code> to jump to a section, or a full URL for an external link.</p>
                <x-input-error :messages="$errors->get('url')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="sort_order" value="Sort Order" />
                <x-text-input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $link->sort_order ?? 0) }}" required class="mt-0" />
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                <x-checkbox name="is_active" value="1" :checked="old('is_active', $editing ? $link->is_active : true)" />
                Active (visible in footer)
            </label>

            <div class="flex items-center gap-3 border-t border-slate-100 pt-5">
                <x-primary-button>{{ $editing ? 'Save Changes' : 'Create Link' }}</x-primary-button>
                <a href="{{ route('admin.footer-links.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
