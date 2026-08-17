<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HourlyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HourlyServiceController extends Controller
{
    public function index(): View
    {
        $services = HourlyService::orderBy('sort_order')->get();

        return view('admin.hourly-services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.hourly-services.form', ['service' => new HourlyService]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = ($validated['slug'] ?? '') ?: Str::slug($validated['name']);

        HourlyService::create($validated);

        return redirect()->route('admin.hourly-services.index')->with('status', 'Service created.');
    }

    public function edit(HourlyService $hourlyService): View
    {
        return view('admin.hourly-services.form', ['service' => $hourlyService]);
    }

    public function update(Request $request, HourlyService $hourlyService): RedirectResponse
    {
        $validated = $this->validated($request, $hourlyService);
        $validated['slug'] = ($validated['slug'] ?? '') ?: Str::slug($validated['name']);

        $hourlyService->update($validated);

        return redirect()->route('admin.hourly-services.index')->with('status', 'Service updated.');
    }

    public function destroy(HourlyService $hourlyService): RedirectResponse
    {
        $hourlyService->delete();

        return redirect()->route('admin.hourly-services.index')->with('status', 'Service deleted.');
    }

    private function validated(Request $request, ?HourlyService $service = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:hourly_services,slug,'.($service?->id)],
            'icon' => ['required', 'string', 'max:50'],
            'price_from' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:8'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
