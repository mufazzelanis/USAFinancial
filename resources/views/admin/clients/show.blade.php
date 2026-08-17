<x-admin-layout title="Client: {{ $client->name }}">
    <a href="{{ route('admin.clients.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-navy-900">&larr; Back to clients</a>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            {{-- Profile --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h3 class="text-lg font-bold text-navy-900">Client Profile</h3>
                <form method="POST" action="{{ route('admin.clients.update', $client) }}" class="mt-4 space-y-5">
                    @csrf @method('PATCH')
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input id="name" name="name" value="{{ old('name', $client->name) }}" required class="mt-0" />
                        </div>
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" type="email" name="email" value="{{ old('email', $client->email) }}" required class="mt-0" />
                        </div>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="company" value="Company" />
                            <x-text-input id="company" name="company" value="{{ old('company', $client->company) }}" class="mt-0" />
                        </div>
                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" value="{{ old('phone', $client->phone) }}" class="mt-0" />
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                        <x-checkbox name="is_active" value="1" :checked="old('is_active', $client->is_active)" />
                        Active account
                    </label>
                    <x-primary-button>Save Changes</x-primary-button>
                </form>
            </div>

            {{-- Subscriptions --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h3 class="text-lg font-bold text-navy-900">Subscriptions</h3>

                <div class="mt-4 space-y-4">
                    @forelse ($client->subscriptions as $subscription)
                        <details class="rounded-xl border border-slate-200 p-4">
                            <summary class="flex cursor-pointer items-center justify-between gap-3">
                                <span class="font-semibold text-navy-900">{{ $subscription->plan->name }} · {{ $subscription->hours_used }}/{{ $subscription->hours_allocated }} hrs</span>
                                <x-status-badge :status="$subscription->status" />
                            </summary>
                            <form method="POST" action="{{ route('admin.clients.subscriptions.update', [$client, $subscription]) }}" class="mt-4 grid gap-4 sm:grid-cols-2">
                                @csrf @method('PATCH')
                                <div>
                                    <x-input-label value="Plan" />
                                    <x-select-input name="plan_id" class="mt-0">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" @selected($subscription->plan_id === $plan->id)>{{ $plan->name }}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                <div>
                                    <x-input-label value="Status" />
                                    <x-select-input name="status" class="mt-0">
                                        @foreach (['active' => 'Active', 'paused' => 'Paused', 'cancelled' => 'Cancelled'] as $value => $label)
                                            <option value="{{ $value }}" @selected($subscription->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                <div>
                                    <x-input-label value="Hours Allocated" />
                                    <x-text-input type="number" name="hours_allocated" value="{{ $subscription->hours_allocated }}" class="mt-0" />
                                </div>
                                <div>
                                    <x-input-label value="Hours Used" />
                                    <x-text-input type="number" name="hours_used" value="{{ $subscription->hours_used }}" class="mt-0" />
                                </div>
                                <div>
                                    <x-input-label value="Account Manager" />
                                    <x-select-input name="account_manager_id" class="mt-0">
                                        <option value="">— Unassigned —</option>
                                        @foreach ($staff as $member)
                                            <option value="{{ $member->id }}" @selected($subscription->account_manager_id === $member->id)>{{ $member->name }}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                                <div>
                                    <x-input-label value="Renews At" />
                                    <x-text-input type="date" name="renews_at" value="{{ optional($subscription->renews_at)->format('Y-m-d') }}" class="mt-0" />
                                </div>
                                <div class="sm:col-span-2">
                                    <x-primary-button>Update Subscription</x-primary-button>
                                </div>
                            </form>
                        </details>
                    @empty
                        <p class="text-sm text-slate-400">No subscriptions yet.</p>
                    @endforelse
                </div>

                <details class="mt-5 rounded-xl border border-dashed border-slate-300 p-4">
                    <summary class="cursor-pointer text-sm font-bold text-navy-700">+ Add a new subscription</summary>
                    <form method="POST" action="{{ route('admin.clients.subscriptions.store', $client) }}" class="mt-4 grid gap-4 sm:grid-cols-2">
                        @csrf
                        <div>
                            <x-input-label value="Plan" />
                            <x-select-input name="plan_id" class="mt-0">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label value="Status" />
                            <x-select-input name="status" class="mt-0">
                                <option value="active">Active</option>
                                <option value="paused">Paused</option>
                                <option value="cancelled">Cancelled</option>
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label value="Hours Allocated" />
                            <x-text-input type="number" name="hours_allocated" value="160" class="mt-0" />
                        </div>
                        <div>
                            <x-input-label value="Hours Used" />
                            <x-text-input type="number" name="hours_used" value="0" class="mt-0" />
                        </div>
                        <div>
                            <x-input-label value="Account Manager" />
                            <x-select-input name="account_manager_id" class="mt-0">
                                <option value="">— Unassigned —</option>
                                @foreach ($staff as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </x-select-input>
                        </div>
                        <div>
                            <x-input-label value="Started At" />
                            <x-text-input type="date" name="started_at" value="{{ now()->format('Y-m-d') }}" class="mt-0" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-primary-button>Add Subscription</x-primary-button>
                        </div>
                    </form>
                </details>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Service Requests</h3>
                <div class="mt-4 divide-y divide-slate-100">
                    @forelse ($client->serviceRequests as $request)
                        <div class="py-3">
                            <p class="text-sm font-semibold text-navy-900">{{ $request->title }}</p>
                            <div class="mt-1 flex items-center justify-between">
                                <span class="text-xs text-slate-400">{{ $request->created_at->format('d M Y') }}</span>
                                <x-status-badge :status="$request->status" />
                            </div>
                        </div>
                    @empty
                        <p class="py-4 text-sm text-slate-400">No requests yet.</p>
                    @endforelse
                </div>
            </div>

            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Delete this client and all related data?');">
                @csrf @method('DELETE')
                <button class="w-full rounded-lg border border-red-200 bg-white py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50">Delete Client</button>
            </form>
        </div>
    </div>
</x-admin-layout>
