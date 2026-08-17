<x-admin-layout title="Lead Details">
    <a href="{{ route('admin.leads.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-navy-900">&larr; Back to leads</a>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-xl font-extrabold text-navy-900">{{ $lead->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $lead->company ?: 'No company provided' }}</p>
                </div>
                <x-status-badge :status="$lead->status" />
            </div>

            <div class="mt-6 grid grid-cols-2 gap-5 border-t border-slate-100 pt-6 text-sm">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Email</p>
                    <p class="mt-1 font-semibold text-navy-900">{{ $lead->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Phone</p>
                    <p class="mt-1 font-semibold text-navy-900">{{ $lead->phone ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Interested Plan</p>
                    <p class="mt-1 font-semibold text-navy-900">{{ $lead->plan->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Interested Service</p>
                    <p class="mt-1 font-semibold text-navy-900">{{ $lead->hourlyService->name ?? '—' }}</p>
                </div>
            </div>

            @if ($lead->message)
                <div class="mt-6 border-t border-slate-100 pt-6">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Message</p>
                    <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $lead->message }}</p>
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Manage Lead</h3>
            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="mt-4 space-y-4">
                @csrf @method('PATCH')
                <div>
                    <x-input-label for="status" value="Status" />
                    <x-select-input id="status" name="status" class="mt-0">
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected($lead->status === $value)>{{ $label }}</option>
                        @endforeach
                    </x-select-input>
                </div>
                <div>
                    <x-input-label for="admin_notes" value="Internal Notes" />
                    <x-textarea-input id="admin_notes" name="admin_notes" rows="5" class="mt-0">{{ old('admin_notes', $lead->admin_notes) }}</x-textarea-input>
                </div>
                <x-primary-button class="w-full justify-center">Save</x-primary-button>
            </form>

            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" class="mt-3" onsubmit="return confirm('Delete this lead?');">
                @csrf @method('DELETE')
                <button class="w-full rounded-lg border border-red-200 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50">Delete Lead</button>
            </form>
        </div>
    </div>
</x-admin-layout>
