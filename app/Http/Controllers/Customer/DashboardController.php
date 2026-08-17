<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $subscription = $user->subscriptions()->with(['plan', 'accountManager'])->latest()->first();
        $requests = $user->serviceRequests()->latest()->take(5)->get();

        $stats = [
            'open_requests' => $user->serviceRequests()->whereIn('status', ['pending', 'in_progress'])->count(),
            'completed_requests' => $user->serviceRequests()->where('status', 'completed')->count(),
        ];

        return view('customer.dashboard', compact('subscription', 'requests', 'stats'));
    }
}
