<x-admin-layout title="Pricing Plans">
    <x-admin.page-header title="Pricing Plans" subtitle="Manage the plans shown in the pricing section of the website.">
        <x-slot name="actions">
            <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Plan</a>
        </x-slot>
    </x-admin.page-header>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Plan</th>
                    <th class="px-5 py-3">Price</th>
                    <th class="px-5 py-3">Hours</th>
                    <th class="px-5 py-3">Color</th>
                    <th class="px-5 py-3">Featured</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($plans as $plan)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 font-semibold text-navy-900">{{ $plan->name }}</td>
                        <td class="px-5 py-4 text-slate-600">£{{ number_format($plan->price, 0) }}/mo</td>
                        <td class="px-5 py-4 text-slate-600">{{ $plan->hours_per_month }} hrs</td>
                        <td class="px-5 py-4"><span class="capitalize text-slate-600">{{ $plan->color }}</span></td>
                        <td class="px-5 py-4">{{ $plan->is_featured ? 'Yes' : '—' }}</td>
                        <td class="px-5 py-4">
                            <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $plan->is_active, 'bg-slate-200 text-slate-500' => !$plan->is_active])>
                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.plans.edit', $plan) }}" class="font-semibold text-navy-700 hover:text-gold-600">Edit</a>
                                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" onsubmit="return confirm('Delete this plan?');">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No plans yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
