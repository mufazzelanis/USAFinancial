<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Store a public quote / contact request (plan signup or hourly service enquiry).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:255'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'hourly_service_id' => ['nullable', 'exists:hourly_services,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['source'] = 'website';
        $validated['status'] = 'new';

        Lead::create($validated);

        return back()->with('quote_success', 'Thanks! Your request has been received — our team will contact you shortly.');
    }
}
