<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffMemberController extends Controller
{
    public function index(): View
    {
        $staff = StaffMember::withCount('subscriptions')->orderBy('name')->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('admin.staff.form', ['member' => new StaffMember]);
    }

    public function store(Request $request): RedirectResponse
    {
        StaffMember::create($this->validated($request));

        return redirect()->route('admin.staff.index')->with('status', 'Staff member added.');
    }

    public function edit(StaffMember $staffMember): View
    {
        return view('admin.staff.form', ['member' => $staffMember]);
    }

    public function update(Request $request, StaffMember $staffMember): RedirectResponse
    {
        $staffMember->update($this->validated($request));

        return redirect()->route('admin.staff.index')->with('status', 'Staff member updated.');
    }

    public function destroy(StaffMember $staffMember): RedirectResponse
    {
        $staffMember->delete();

        return redirect()->route('admin.staff.index')->with('status', 'Staff member removed.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'role_title' => ['required', 'string', 'in:accountant,bookkeeper,payroll_associate'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
