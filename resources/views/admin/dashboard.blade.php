<x-admin-layout title="Dashboard">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
        <x-admin.stat-card label="Total Clients" :value="$stats['total_clients']" icon="users" color="navy" />
        <x-admin.stat-card label="Active Subscriptions" :value="$stats['active_subscriptions']" icon="grid" color="blue" />
        <x-admin.stat-card label="New Leads" :value="$stats['new_leads']" icon="inbox" color="gold" />
        <x-admin.stat-card label="Open Requests" :value="$stats['open_requests']" icon="clipboard" color="purple" />
        <x-admin.stat-card label="Est. MRR" :value="'£'.number_format($stats['mrr'], 0)" icon="currency" color="green" />
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-navy-900">Recent Leads</h3>
                <a href="{{ route('admin.leads.index') }}" class="text-xs font-bold text-navy-700 hover:text-gold-600">View all →</a>
            </div>
            <div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentLeads as $lead)
                    <a href="{{ route('admin.leads.show', $lead) }}" class="flex items-center justify-between gap-4 py-3.5 -mx-2 rounded-lg px-2 hover:bg-slate-50">
                        <div>
                            <p class="text-sm font-semibold text-navy-900">{{ $lead->name }}</p>
                            <p class="text-xs text-slate-400">{{ $lead->plan->name ?? 'General enquiry' }} · {{ $lead->created_at->diffForHumans() }}</p>
                        </div>
                        <x-status-badge :status="$lead->status" />
                    </a>
                @empty
                    <p class="py-6 text-center text-sm text-slate-400">No leads yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-navy-900">Recent Service Requests</h3>
                <a href="{{ route('admin.requests.index') }}" class="text-xs font-bold text-navy-700 hover:text-gold-600">View all →</a>
            </div>
            <div class="mt-4 divide-y divide-slate-100">
                @forelse ($recentRequests as $request)
                    <div class="flex items-center justify-between gap-4 py-3.5">
                        <div>
                            <p class="text-sm font-semibold text-navy-900">{{ $request->title }}</p>
                            <p class="text-xs text-slate-400">{{ $request->user->name ?? 'Unknown' }} · {{ $request->created_at->diffForHumans() }}</p>
                        </div>
                        <x-status-badge :status="$request->status" />
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-slate-400">No requests yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold text-navy-900">Quick Actions</h3>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('admin.plans.create') }}" class="rounded-full bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">+ New Plan</a>
            <a href="{{ route('admin.clients.create') }}" class="rounded-full bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">+ New Client</a>
            <a href="{{ route('admin.staff.create') }}" class="rounded-full bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy-800">+ New Staff Member</a>
            <a href="{{ route('admin.settings.edit') }}" class="rounded-full border border-slate-300 px-5 py-2.5 text-sm font-semibold text-navy-900 hover:bg-slate-50">Edit Site Content</a>
        </div>
    </div>
</x-admin-layout>
