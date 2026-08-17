<x-customer-layout title="New Service Request">
    <div class="mx-auto max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @if (!$subscription)
            <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                You don't have an active subscription yet — you can still submit a request and our team will follow up.
            </div>
        @endif

        <form method="POST" action="{{ route('customer.requests.store') }}" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="title" value="Request Title" />
                <x-text-input id="title" name="title" value="{{ old('title') }}" required class="mt-0" />
                <x-input-error :messages="$errors->get('title')" class="mt-1" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="type" value="Service Type" />
                    <x-select-input id="type" name="type" required class="mt-0">
                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}" @selected(old('type') === $value)>{{ $label }}</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="priority" value="Priority" />
                    <x-select-input id="priority" name="priority" required class="mt-0">
                        <option value="low" @selected(old('priority') === 'low')>Low</option>
                        <option value="normal" @selected(old('priority', 'normal') === 'normal')>Normal</option>
                        <option value="high" @selected(old('priority') === 'high')>High</option>
                    </x-select-input>
                </div>
            </div>

            <div>
                <x-input-label for="description" value="Details" />
                <x-textarea-input id="description" name="description" rows="5" class="mt-0">{{ old('description') }}</x-textarea-input>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <div class="flex items-center gap-3">
                <x-primary-button>Submit Request</x-primary-button>
                <a href="{{ route('customer.requests.index') }}" class="text-sm font-semibold text-slate-500 hover:text-navy-900">Cancel</a>
            </div>
        </form>
    </div>
</x-customer-layout>
