<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterLinkController extends Controller
{
    public function index(): View
    {
        $links = FooterLink::orderBy('sort_order')->get();

        return view('admin.footer-links.index', compact('links'));
    }

    public function create(): View
    {
        return view('admin.footer-links.form', ['link' => new FooterLink]);
    }

    public function store(Request $request): RedirectResponse
    {
        FooterLink::create($this->validated($request));

        return redirect()->route('admin.footer-links.index')->with('status', 'Footer link created.');
    }

    public function edit(FooterLink $footerLink): View
    {
        return view('admin.footer-links.form', ['link' => $footerLink]);
    }

    public function update(Request $request, FooterLink $footerLink): RedirectResponse
    {
        $footerLink->update($this->validated($request));

        return redirect()->route('admin.footer-links.index')->with('status', 'Footer link updated.');
    }

    public function destroy(FooterLink $footerLink): RedirectResponse
    {
        $footerLink->delete();

        return redirect()->route('admin.footer-links.index')->with('status', 'Footer link deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'url' => ['required', 'string', 'max:500'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
