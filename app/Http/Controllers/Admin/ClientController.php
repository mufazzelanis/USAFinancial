<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\StaffMember;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = User::where('role', 'customer')
            ->with(['activeSubscription.plan'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%'.$request->string('search').'%';
                $q->where(fn ($q2) => $q2->where('name', 'like', $term)->orWhere('email', 'like', $term)->orWhere('company', 'like', $term));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.create', [
            'plans' => Plan::orderBy('sort_order')->get(),
            'staff' => StaffMember::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'password' => ['required', Password::defaults()],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'account_manager_id' => ['nullable', 'exists:staff_members,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        if (! empty($validated['plan_id'])) {
            $plan = Plan::find($validated['plan_id']);

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'hours_allocated' => $plan->hours_per_month,
                'hours_used' => 0,
                'status' => 'active',
                'started_at' => now(),
                'renews_at' => now()->addMonth(),
                'account_manager_id' => $validated['account_manager_id'] ?? null,
            ]);
        }

        return redirect()->route('admin.clients.index')->with('status', 'Client created.');
    }

    public function show(User $client): View
    {
        abort_unless($client->role === 'customer', 404);

        $client->load(['subscriptions.plan', 'subscriptions.accountManager', 'serviceRequests']);

        return view('admin.clients.show', [
            'client' => $client,
            'plans' => Plan::orderBy('sort_order')->get(),
            'staff' => StaffMember::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->role === 'customer', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$client->id],
            'company' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $client->update($validated);

        return back()->with('status', 'Client updated.');
    }

    public function destroy(User $client): RedirectResponse
    {
        abort_unless($client->role === 'customer', 404);

        $client->delete();

        return redirect()->route('admin.clients.index')->with('status', 'Client removed.');
    }

    public function storeSubscription(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->role === 'customer', 404);

        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'hours_allocated' => ['required', 'integer', 'min:0'],
            'hours_used' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:active,paused,cancelled'],
            'account_manager_id' => ['nullable', 'exists:staff_members,id'],
            'started_at' => ['nullable', 'date'],
            'renews_at' => ['nullable', 'date'],
        ]);

        $client->subscriptions()->create($validated);

        return back()->with('status', 'Subscription added.');
    }

    public function updateSubscription(Request $request, User $client, Subscription $subscription): RedirectResponse
    {
        abort_unless($subscription->user_id === $client->id, 404);

        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'hours_allocated' => ['required', 'integer', 'min:0'],
            'hours_used' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', 'in:active,paused,cancelled'],
            'account_manager_id' => ['nullable', 'exists:staff_members,id'],
            'started_at' => ['nullable', 'date'],
            'renews_at' => ['nullable', 'date'],
        ]);

        $subscription->update($validated);

        return back()->with('status', 'Subscription updated.');
    }
}
