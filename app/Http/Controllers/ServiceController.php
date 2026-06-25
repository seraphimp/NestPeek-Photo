<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Studio;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services for a studio.
     */
    public function index(Studio $studio)
    {
        // Check if user owns this studio
        abort_unless(auth()->id() === $studio->owner_id, 403);

        $services = $studio->services;

        return view('studios.services.index', compact('studio', 'services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(Studio $studio)
    {
        // Check if user owns this studio
        abort_unless(auth()->id() === $studio->owner_id, 403);

        return view('studios.services.create', compact('studio'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request, Studio $studio)
    {
        abort_unless(auth()->id() === $studio->owner_id, 403);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'category'        => 'required|in:wedding_package,portrait_session,event_coverage,video_production,photo_editing,studio_rental,coordination,add_on,other',
            'price'           => 'required|numeric|min:0',
            'duration_hours'  => 'nullable|integer|min:1',
            'requires_deposit' => 'nullable|boolean',
            'deposit_amount'  => 'nullable|numeric|min:0',
        ]);

        $validated['requires_deposit'] = $request->boolean('requires_deposit');

        $studio->services()->create($validated);

        return redirect()->route('studios.services.index', $studio)
            ->with('success', 'Service added successfully!');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Studio $studio, Service $service)
    {
        // Check if user owns this studio
        abort_unless(auth()->id() === $studio->owner_id, 403);

        // Ensure the service belongs to the studio
        if ($service->studio_id !== $studio->id) {
            abort(404, 'Service not found for this studio.');
        }

        return view('studios.services.edit', compact('studio', 'service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Studio $studio, Service $service)
    {
        // Check if user owns this studio
        abort_unless(auth()->id() === $studio->owner_id, 403);

        // Ensure the service belongs to the studio
        if ($service->studio_id !== $studio->id) {
            abort(404, 'Service not found for this studio.');
        }

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'category'        => 'required|in:wedding_package,portrait_session,event_coverage,video_production,photo_editing,studio_rental,coordination,add_on,other',
            'price'           => 'required|numeric|min:0',
            'duration_hours'  => 'nullable|integer|min:1',
            'requires_deposit' => 'nullable|boolean',
            'deposit_amount'  => 'nullable|numeric|min:0',
        ]);

        $validated['requires_deposit'] = $request->boolean('requires_deposit');

        $service->update($validated);

        return redirect()->route('studios.services.index', $studio)
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Studio $studio, Service $service)
    {
        // Check if user owns this studio
        abort_unless(auth()->id() === $studio->owner_id, 403);

        // Ensure the service belongs to the studio
        if ($service->studio_id !== $studio->id) {
            abort(404, 'Service not found for this studio.');
        }

        $service->delete();

        return redirect()->route('studios.services.index', $studio)
            ->with('success', 'Service deleted successfully!');
    }
}
