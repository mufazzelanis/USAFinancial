<x-admin-layout title="Clients">
    <x-admin.page-header title="Clients" subtitle="Customer accounts and their active subscriptions.">
        <x-slot name="actions">
            <a href="{{ route('admin.clients.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Client</a>
        </x-slot>
    </x-admin.page-header>

    <form method="GET" class="mb-5 max-w-sm">
        <x-text-input type="search" name="search" value="{{ request('search') }}" placeholder="Search name, email or company…" class="mt-0" />
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Client</th>
                    <th class="px-5 py-3">Company</th>
                    <th class="px-5 py-3">Plan</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($clients as $client)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-navy-900">{{ $client->name }}</p>
                            <p class="text-xs text-slate-400">{{ $client->email }}</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $client->company ?: '—' }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $client->activeSubscription->plan->name ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $client->is_active, 'bg-slate-200 text-slate-500' => !$client->is_active])>
                                {{ $client->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.clients.show', $client) }}" class="font-semibold text-navy-700 hover:text-gold-600">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No clients yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $clients->links() }}</div>
</x-admin-layout>
