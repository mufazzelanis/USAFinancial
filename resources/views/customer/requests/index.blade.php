<x-customer-layout title="Service Requests">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-500">Track every request you've sent to your dedicated team.</p>
        <a href="{{ route('customer.requests.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">
            + New Request
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Request</th>
                    <th class="px-5 py-3">Type</th>
                    <th class="px-5 py-3">Priority</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Submitted</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($requests as $request)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <a href="{{ route('customer.requests.show', $request) }}" class="font-semibold text-navy-900 hover:text-gold-600">{{ $request->title }}</a>
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ \App\Models\ServiceRequest::types()[$request->type] ?? $request->type }}</td>
                        <td class="px-5 py-4 text-slate-500 capitalize">{{ $request->priority }}</td>
                        <td class="px-5 py-4"><x-status-badge :status="$request->status" /></td>
                        <td class="px-5 py-4 text-slate-400">{{ $request->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No requests submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $requests->links() }}</div>
</x-customer-layout>
