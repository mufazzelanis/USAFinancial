<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $admins = User::where('role', 'admin')->orderBy('name')->get();

        return view('admin.admin-users.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin.admin-users.form', ['adminUser' => new User]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.admin-users.index')->with('status', 'Admin user created.');
    }

    public function edit(User $adminUser): View
    {
        abort_unless($adminUser->role === 'admin', 404);

        return view('admin.admin-users.form', compact('adminUser'));
    }

    public function update(Request $request, User $adminUser): RedirectResponse
    {
        abort_unless($adminUser->role === 'admin', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($adminUser->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $adminUser->name = $validated['name'];
        $adminUser->email = $validated['email'];
        // Never let an admin lock themselves out, even via a crafted request.
        $adminUser->is_active = $adminUser->id === $request->user()->id ? true : $request->boolean('is_active');

        if (! empty($validated['password'])) {
            $adminUser->password = Hash::make($validated['password']);
        }

        $adminUser->save();

        return redirect()->route('admin.admin-users.index')->with('status', 'Admin user updated.');
    }

    public function destroy(Request $request, User $adminUser): RedirectResponse
    {
        abort_unless($adminUser->role === 'admin', 404);

        if ($adminUser->id === $request->user()->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if (User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'You cannot delete the last remaining admin account.');
        }

        $adminUser->delete();

        return redirect()->route('admin.admin-users.index')->with('status', 'Admin user removed.');
    }
}
