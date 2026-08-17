<x-admin-layout title="Per-Hour Services">
    <x-admin.page-header title="Per-Hour Services" subtitle="Manage the hourly-rate services list.">
        <x-slot name="actions">
            <a href="{{ route('admin.hourly-services.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Service</a>
        </x-slot>
    </x-admin.page-header>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Service</th>
                    <th class="px-5 py-3">From (£/hr)</th>
                    <th class="px-5 py-3">Sort</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($services as $service)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 font-semibold text-navy-900">{{ $service->name }}</td>
                        <td class="px-5 py-4 text-slate-600">£{{ number_format($service->price_from, 0) }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $service->sort_order }}</td>
                        <td class="px-5 py-4">
                            <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $service->is_active, 'bg-slate-200 text-slate-500' => !$service->is_active])>
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.hourly-services.edit', $service) }}" class="font-semibold text-navy-700 hover:text-gold-600">Edit</a>
                                <form method="POST" action="{{ route('admin.hourly-services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No services yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
