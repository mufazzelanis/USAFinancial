<x-admin-layout title="Service Requests">
    <x-admin.page-header title="Service Requests" subtitle="All requests submitted by clients from the portal." />

    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('admin.requests.index') }}" @class(['rounded-full px-4 py-1.5 text-xs font-bold', 'bg-navy-900 text-white' => !request('status'), 'bg-slate-100 text-slate-600' => request('status')])>All</a>
        @foreach ($statuses as $value => $label)
            <a href="{{ route('admin.requests.index', ['status' => $value]) }}" @class(['rounded-full px-4 py-1.5 text-xs font-bold', 'bg-navy-900 text-white' => request('status') === $value, 'bg-slate-100 text-slate-600' => request('status') !== $value])>{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Request</th>
                    <th class="px-5 py-3">Client</th>
                    <th class="px-5 py-3">Type</th>
                    <th class="px-5 py-3">Priority</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($requests as $request)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 font-semibold text-navy-900">{{ $request->title }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $request->user->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ \App\Models\ServiceRequest::types()[$request->type] ?? $request->type }}</td>
                        <td class="px-5 py-4 text-slate-500 capitalize">{{ $request->priority }}</td>
                        <td class="px-5 py-4"><x-status-badge :status="$request->status" /></td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.requests.update', $request) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <x-select-input name="status" class="mt-0 py-1.5 text-xs" onchange="this.form.submit()">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($request->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </x-select-input>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</x-admin-layout>
