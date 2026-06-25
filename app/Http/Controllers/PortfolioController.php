<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Portfolio management page.
     */
    public function index(Request $request)
    {
        $user    = auth()->user();
        $profile = $user->creatorProfile;

        $portfolios = $profile->portfolios()
            ->withCount('media')
            ->when($request->category, fn($q, $cat) => $q->where('category', $cat))
            ->latest()
            ->paginate(12);

        return view('portfolio', compact('user', 'profile', 'portfolios'));
    }

    /**
     * Store a new portfolio project with its images.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'description' => 'nullable|string|max:2000',
            'location'    => 'nullable|string|max:255',
            'shoot_date'  => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'images'      => 'required|array|min:1|max:20',
            'images.*'    => 'image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $profile   = auth()->user()->creatorProfile;
        $portfolio = $profile->portfolios()->create([
            ...$request->only(['title', 'category', 'description', 'location', 'shoot_date']),
            'is_published' => $request->boolean('is_published'),
            'is_featured'  => $request->boolean('is_featured'),
        ]);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('portfolios/' . $portfolio->id, 'public');
            $portfolio->media()->create([
                'file_path'  => $path,
                'sort_order' => $index,
            ]);
        }

        // Set the first image as cover
        if ($portfolio->media()->exists()) {
            $portfolio->update([
                'cover_image' => $portfolio->media()->orderBy('sort_order')->first()->file_path,
            ]);
        }

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio project added successfully!');
    }

    /**
     * Delete a portfolio project and all its media files.
     */
    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        foreach ($portfolio->media as $media) {
            Storage::disk('public')->delete($media->file_path);

            if ($media->thumbnail_path) {
                Storage::disk('public')->delete($media->thumbnail_path);
            }
        }

        $portfolio->media()->delete();
        $portfolio->delete();

        return redirect()->route('portfolio.index')
            ->with('success', 'Portfolio project deleted.');
    }
}
