<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentGatewayController extends Controller
{
    public function index(): View
    {
        $gateways = PaymentGateway::orderBy('sort_order')->get();

        return view('admin.payment-gateways.index', compact('gateways'));
    }

    public function create(): View
    {
        return view('admin.payment-gateways.form', ['gateway' => new PaymentGateway]);
    }

    public function store(Request $request): RedirectResponse
    {
        PaymentGateway::create($this->validated($request));

        return redirect()->route('admin.payment-gateways.index')->with('status', 'Payment gateway created.');
    }

    public function edit(PaymentGateway $paymentGateway): View
    {
        return view('admin.payment-gateways.form', ['gateway' => $paymentGateway]);
    }

    public function update(Request $request, PaymentGateway $paymentGateway): RedirectResponse
    {
        $paymentGateway->update($this->validated($request));

        return redirect()->route('admin.payment-gateways.index')->with('status', 'Payment gateway updated.');
    }

    public function destroy(PaymentGateway $paymentGateway): RedirectResponse
    {
        $paymentGateway->delete();

        return redirect()->route('admin.payment-gateways.index')->with('status', 'Payment gateway deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['sometimes', 'boolean'],
            'features' => ['nullable', 'string'],
        ]);

        $validated['features'] = collect(explode("\n", $validated['features'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
