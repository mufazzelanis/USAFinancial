<x-admin-layout title="Team / Staff">
    <x-admin.page-header title="Team / Staff" subtitle="Manage accountants, bookkeepers and payroll associates.">
        <x-slot name="actions">
            <a href="{{ route('admin.staff.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Staff Member</a>
        </x-slot>
    </x-admin.page-header>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3">Contact</th>
                    <th class="px-5 py-3">Clients</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($staff as $member)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4 font-semibold text-navy-900">{{ $member->name }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ \App\Models\StaffMember::roleTitles()[$member->role_title] ?? $member->role_title }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $member->email ?: '—' }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $member->subscriptions_count }}</td>
                        <td class="px-5 py-4">
                            <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $member->is_active, 'bg-slate-200 text-slate-500' => !$member->is_active])>
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.staff.edit', $member) }}" class="font-semibold text-navy-700 hover:text-gold-600">Edit</a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $member) }}" onsubmit="return confirm('Remove this staff member?');">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No staff members yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
