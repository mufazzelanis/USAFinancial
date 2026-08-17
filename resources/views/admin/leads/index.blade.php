<x-admin-layout title="Leads">
    <x-admin.page-header title="Leads" subtitle="Quote requests and contact form submissions from the website." />

    <div class="mb-5 flex flex-wrap gap-2">
        <a href="{{ route('admin.leads.index') }}" @class(['rounded-full px-4 py-1.5 text-xs font-bold', 'bg-navy-900 text-white' => !request('status'), 'bg-slate-100 text-slate-600' => request('status')])>All</a>
        @foreach ($statuses as $value => $label)
            <a href="{{ route('admin.leads.index', ['status' => $value]) }}" @class(['rounded-full px-4 py-1.5 text-xs font-bold', 'bg-navy-900 text-white' => request('status') === $value, 'bg-slate-100 text-slate-600' => request('status') !== $value])>{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Interested In</th>
                    <th class="px-5 py-3">Contact</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Received</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($leads as $lead)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-navy-900">{{ $lead->name }}</p>
                            <p class="text-xs text-slate-400">{{ $lead->company }}</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $lead->plan->name ?? $lead->hourlyService->name ?? 'General enquiry' }}</td>
                        <td class="px-5 py-4 text-slate-500">
                            <p>{{ $lead->email }}</p>
                            <p class="text-xs">{{ $lead->phone }}</p>
                        </td>
                        <td class="px-5 py-4"><x-status-badge :status="$lead->status" /></td>
                        <td class="px-5 py-4 text-slate-400">{{ $lead->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.leads.show', $lead) }}" class="font-semibold text-navy-700 hover:text-gold-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No leads found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $leads->links() }}</div>
</x-admin-layout>
