<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollTier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PayrollTierController extends Controller
{
    public function index(): View
    {
        $tiers = PayrollTier::orderBy('sort_order')->get();

        return view('admin.payroll-tiers.index', compact('tiers'));
    }

    public function create(): View
    {
        return view('admin.payroll-tiers.form', ['tier' => new PayrollTier]);
    }

    public function store(Request $request): RedirectResponse
    {
        PayrollTier::create($this->validated($request));

        return redirect()->route('admin.payroll-tiers.index')->with('status', 'Payroll tier created.');
    }

    public function edit(PayrollTier $payrollTier): View
    {
        return view('admin.payroll-tiers.form', ['tier' => $payrollTier]);
    }

    public function update(Request $request, PayrollTier $payrollTier): RedirectResponse
    {
        $payrollTier->update($this->validated($request));

        return redirect()->route('admin.payroll-tiers.index')->with('status', 'Payroll tier updated.');
    }

    public function destroy(PayrollTier $payrollTier): RedirectResponse
    {
        $payrollTier->delete();

        return redirect()->route('admin.payroll-tiers.index')->with('status', 'Payroll tier deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_limit' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:8'],
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
