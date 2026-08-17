<x-admin-layout title="Admin Users">
    <x-admin.page-header title="Admin Users" subtitle="People who can log in and manage this admin panel.">
        <x-slot name="actions">
            <a href="{{ route('admin.admin-users.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-navy-900 px-5 py-2.5 text-sm font-bold text-white hover:bg-navy-800">+ New Admin User</a>
        </x-slot>
    </x-admin.page-header>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-100 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Joined</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($admins as $admin)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-navy-900 text-xs font-semibold text-gold-300">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </span>
                                <span class="font-semibold text-navy-900">{{ $admin->name }}</span>
                                @if ($admin->id === auth()->id())
                                    <span class="rounded-full bg-navy-100 px-2 py-0.5 text-[10px] font-bold uppercase text-navy-700">You</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-500">{{ $admin->email }}</td>
                        <td class="px-5 py-4">
                            <span @class(['rounded-full px-2.5 py-1 text-[11px] font-bold', 'bg-green-100 text-green-700' => $admin->is_active, 'bg-slate-200 text-slate-500' => !$admin->is_active])>
                                {{ $admin->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-400">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.admin-users.edit', $admin) }}" class="font-semibold text-navy-700 hover:text-gold-600">Edit</a>
                                <form method="POST" action="{{ route('admin.admin-users.destroy', $admin) }}" onsubmit="return confirm('Remove this admin user? They will lose access immediately.');">
                                    @csrf @method('DELETE')
                                    <button class="font-semibold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No admin users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
