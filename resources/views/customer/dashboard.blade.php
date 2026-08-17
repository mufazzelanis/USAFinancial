<x-customer-layout title="Dashboard">
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Subscription overview --}}
        <div class="lg:col-span-2 space-y-6">
            @if ($subscription)
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gold-600">Current Plan</p>
                            <h2 class="mt-1 text-2xl font-extrabold text-navy-900">{{ $subscription->plan->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                £{{ number_format($subscription->plan->price, 0) }}/month ·
                                {{ $subscription->hours_allocated }} hours/month
                            </p>
                        </div>
                        <span @class([
                            'rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide',
                            'bg-green-100 text-green-700' => $subscription->status === 'active',
                            'bg-amber-100 text-amber-700' => $subscription->status === 'paused',
                            'bg-red-100 text-red-700' => $subscription->status === 'cancelled',
                        ])>{{ $subscription->status }}</span>
                    </div>

                    <div class="mt-6">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span>Hours used this cycle</span>
                            <span>{{ $subscription->hours_used }} / {{ $subscription->hours_allocated }} hrs</span>
                        </div>
                        <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-gold-500" style="width: {{ $subscription->hoursPercentUsed() }}%"></div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4 text-sm sm:grid-cols-3">
                        <div>
                            <p class="text-xs font-semibold text-slate-400">Started</p>
                            <p class="font-semibold text-navy-900">{{ optional($subscription->started_at)->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400">Renews</p>
                            <p class="font-semibold text-navy-900">{{ optional($subscription->renews_at)->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400">Account Manager</p>
                            <p class="font-semibold text-navy-900">{{ $subscription->accountManager->name ?? 'Not yet assigned' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
                    <p class="font-semibold text-navy-900">You don't have an active plan yet.</p>
                    <p class="mt-1 text-sm text-slate-500">Choose a plan on our website and our team will activate your subscription.</p>
                    <a href="{{ route('home') }}#pricing" class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-gold-500 px-5 py-2.5 text-sm font-bold text-navy-950 hover:bg-gold-400">View Plans</a>
                </div>
            @endif

            {{-- Recent requests --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-navy-900">Recent Service Requests</h3>
                    <a href="{{ route('customer.requests.index') }}" class="text-xs font-bold text-navy-700 hover:text-gold-600">View all →</a>
                </div>

                <div class="mt-4 divide-y divide-slate-100">
                    @forelse ($requests as $request)
                        <a href="{{ route('customer.requests.show', $request) }}" class="flex items-center justify-between gap-4 py-3.5 hover:bg-slate-50 -mx-2 px-2 rounded-lg">
                            <div>
                                <p class="text-sm font-semibold text-navy-900">{{ $request->title }}</p>
                                <p class="text-xs text-slate-400">{{ \App\Models\ServiceRequest::types()[$request->type] ?? $request->type }} · {{ $request->created_at->diffForHumans() }}</p>
                            </div>
                            <x-status-badge :status="$request->status" />
                        </a>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">No requests yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Quick Stats</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Open Requests</span>
                        <span class="text-lg font-extrabold text-navy-900">{{ $stats['open_requests'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Completed Requests</span>
                        <span class="text-lg font-extrabold text-navy-900">{{ $stats['completed_requests'] }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-navy-900 p-6 text-white">
                <h3 class="text-sm font-bold uppercase tracking-wide text-gold-400">Need Something?</h3>
                <p class="mt-2 text-sm text-white/70">Submit a new request and your dedicated team will pick it up.</p>
                <a href="{{ route('customer.requests.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-gold-500 px-5 py-2.5 text-sm font-bold text-navy-950 hover:bg-gold-400">
                    + New Request
                </a>
            </div>
        </div>
    </div>
</x-customer-layout>
