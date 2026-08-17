<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\HourlyServiceController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PayrollTierController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StaffMemberController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ServiceRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/plans/{plan:slug}', [PlanPageController::class, 'show'])->name('plans.show');
Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Backward-compatible dashboard redirect based on role.
Route::get('/dashboard', function () {
    $user = auth()->user();

    return redirect($user?->isAdmin() ? route('admin.dashboard') : route('customer.dashboard'));
})->middleware(['auth'])->name('dashboard');

// Customer portal
Route::middleware(['auth', 'role:customer'])->prefix('portal')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show'])->name('requests.show');
});

// Admin panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('plans', PlanController::class)->except('show');
    Route::resource('hourly-services', HourlyServiceController::class)->except('show');
    Route::resource('payroll-tiers', PayrollTierController::class)->except('show');
    Route::resource('integrations', IntegrationController::class)->except('show');
    Route::resource('payment-gateways', PaymentGatewayController::class)->except('show');
    Route::resource('staff', StaffMemberController::class)->except('show');
    Route::resource('footer-links', FooterLinkController::class)->except('show');

    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::patch('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::patch('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/clients/{client}/subscriptions', [ClientController::class, 'storeSubscription'])->name('clients.subscriptions.store');
    Route::patch('/clients/{client}/subscriptions/{subscription}', [ClientController::class, 'updateSubscription'])->name('clients.subscriptions.update');

    Route::get('/requests', [AdminServiceRequestController::class, 'index'])->name('requests.index');
    Route::patch('/requests/{serviceRequest}', [AdminServiceRequestController::class, 'update'])->name('requests.update');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/logo', [SettingController::class, 'uploadLogo'])->name('settings.logo.upload');
    Route::delete('/settings/logo', [SettingController::class, 'removeLogo'])->name('settings.logo.remove');
    Route::post('/settings/favicon', [SettingController::class, 'uploadFavicon'])->name('settings.favicon.upload');
    Route::delete('/settings/favicon', [SettingController::class, 'removeFavicon'])->name('settings.favicon.remove');
});

require __DIR__.'/auth.php';
