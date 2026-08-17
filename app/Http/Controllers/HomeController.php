<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use App\Models\HourlyService;
use App\Models\Integration;
use App\Models\PaymentGateway;
use App\Models\PayrollTier;
use App\Models\Plan;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allCached()->pluck('value', 'key');

        return view('welcome', [
            'settings' => $settings,
            'plans' => Plan::where('is_active', true)->orderBy('sort_order')->get(),
            'hourlyServices' => HourlyService::where('is_active', true)->orderBy('sort_order')->get(),
            'payrollTiers' => PayrollTier::where('is_active', true)->orderBy('sort_order')->get(),
            'integrations' => Integration::where('is_active', true)->where('category', 'integration')->orderBy('sort_order')->get(),
            'setupSoftware' => Integration::where('is_active', true)->where('category', 'setup')->orderBy('sort_order')->get(),
            'posSoftware' => Integration::where('is_active', true)->where('category', 'pos')->orderBy('sort_order')->first(),
            'paymentGateways' => PaymentGateway::where('is_active', true)->orderBy('sort_order')->get(),
            'footerLinks' => FooterLink::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
