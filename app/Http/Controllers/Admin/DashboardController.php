<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\ServiceRequest;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients' => User::where('role', 'customer')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'new_leads' => Lead::where('status', 'new')->count(),
            'open_requests' => ServiceRequest::whereIn('status', ['pending', 'in_progress'])->count(),
            'mrr' => Subscription::where('status', 'active')->join('plans', 'plans.id', '=', 'subscriptions.plan_id')->sum('plans.price'),
        ];

        $recentLeads = Lead::with('plan')->latest()->take(6)->get();
        $recentRequests = ServiceRequest::with('user')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentRequests'));
    }
}
