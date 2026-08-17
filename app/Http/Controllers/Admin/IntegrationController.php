<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IntegrationController extends Controller
{
    public function index(): View
    {
        $integrations = Integration::orderBy('category')->orderBy('sort_order')->get()->groupBy('category');

        return view('admin.integrations.index', compact('integrations'));
    }

    public function create(): View
    {
        return view('admin.integrations.form', ['integration' => new Integration]);
    }

    public function store(Request $request): RedirectResponse
    {
        Integration::create($this->validated($request));

        return redirect()->route('admin.integrations.index')->with('status', 'Integration created.');
    }

    public function edit(Integration $integration): View
    {
        return view('admin.integrations.form', compact('integration'));
    }

    public function update(Request $request, Integration $integration): RedirectResponse
    {
        $integration->update($this->validated($request));

        return redirect()->route('admin.integrations.index')->with('status', 'Integration updated.');
    }

    public function destroy(Integration $integration): RedirectResponse
    {
        $integration->delete();

        return redirect()->route('admin.integrations.index')->with('status', 'Integration deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:integration,setup,pos'],
            'setup_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:8'],
            'color' => ['required', 'string', 'max:20'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
