<x-admin-layout title="Integrations & POS">
    <x-admin.page-header title="Integrations & POS Software" subtitle="Manage integration logos, setup pricing and POS software.">
        <x-slot name="actions">
            <a href="{{ route('admin.integrations.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Item</a>
        </x-slot>
    </x-admin.page-header>

    @php
        $categoryLabels = ['integration' => 'Integration & Compliance', 'setup' => 'Software Setup & Implement', 'pos' => 'POS Software'];
    @endphp

    @foreach ($categoryLabels as $key => $label)
        <div class="mb-8">
            <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-500">{{ $label }}</h3>
            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Name</th>
                            <th class="px-5 py-3">Setup Price</th>
                            <th class="px-5 py-3">Sort</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse (($integrations[$key] ?? []) as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-semibold text-navy-900">{{ $item->name }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->setup_price ? '£'.number_format($item->setup_price, 0) : '—' }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->sort_order }}</td>
                                <td class="px-5 py-4">
                                    <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $item->is_active, 'bg-slate-200 text-slate-500' => !$item->is_active])>
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.integrations.edit', $item) }}" class="font-semibold text-navy-700 hover:text-gold-600">Edit</a>
                                        <form method="POST" action="{{ route('admin.integrations.destroy', $item) }}" onsubmit="return confirm('Delete this item?');">
                                            @csrf @method('DELETE')
                                            <button class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-6 text-center text-slate-400">None yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</x-admin-layout>
