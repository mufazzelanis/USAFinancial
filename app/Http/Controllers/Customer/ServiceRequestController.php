<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $requests = $request->user()->serviceRequests()->latest()->paginate(10);

        return view('customer.requests.index', compact('requests'));
    }

    public function create(Request $request): View
    {
        $subscription = $request->user()->subscriptions()->latest()->first();

        return view('customer.requests.create', [
            'types' => ServiceRequest::types(),
            'subscription' => $subscription,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:'.implode(',', array_keys(ServiceRequest::types()))],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority' => ['required', 'string', 'in:low,normal,high'],
        ]);

        $subscription = $request->user()->subscriptions()->latest()->first();

        $request->user()->serviceRequests()->create($validated + [
            'subscription_id' => $subscription?->id,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.requests.index')->with('status', 'Your request has been submitted.');
    }

    public function show(Request $request, ServiceRequest $serviceRequest): View
    {
        abort_unless($serviceRequest->user_id === $request->user()->id, 403);

        return view('customer.requests.show', compact('serviceRequest'));
    }
}
