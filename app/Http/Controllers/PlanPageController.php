<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use App\Models\Plan;
use App\Models\SiteSetting;

class PlanPageController extends Controller
{
    public function show(Plan $plan)
    {
        abort_unless($plan->is_active, 404);

        $settings = SiteSetting::allCached()->pluck('value', 'key');

        $otherPlans = Plan::where('is_active', true)
            ->where('id', '!=', $plan->id)
            ->orderBy('sort_order')
            ->get();

        $footerLinks = FooterLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('plans.show', compact('plan', 'settings', 'otherPlans', 'footerLinks'));
    }
}
