<?php

namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use App\Models\Favorite;
use App\Models\Portfolio;
use App\Models\Studio;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'favorable_type' => 'required|in:creator,studio,portfolio',
            'favorable_id'   => 'required|integer',
        ]);

        $modelMap = [
            'creator'   => CreatorProfile::class,
            'studio'    => Studio::class,
            'portfolio' => Portfolio::class,
        ];

        $type = $modelMap[$request->favorable_type];

        $existing = Favorite::where([
            'user_id'        => auth()->id(),
            'favorable_type' => $type,
            'favorable_id'   => $request->favorable_id,
        ])->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['favorited' => false]);
        }

        Favorite::create([
            'user_id'        => auth()->id(),
            'favorable_type' => $type,
            'favorable_id'   => $request->favorable_id,
        ]);

        return response()->json(['favorited' => true]);
    }

    public function index()
    {
        $user      = auth()->user();
        $favorites = Favorite::where('user_id', $user->id)
            ->with('favorable')
            ->latest()
            ->paginate(20);

        return view('favorites.index', compact('favorites'));
    }
}
