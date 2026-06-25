<?php

namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use App\Models\Studio;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query   = $request->get('q');
        $type    = $request->get('type', 'all');
        $results = [];

        if ($query) {
            if (in_array($type, ['all', 'creators'])) {
                $results['creators'] = CreatorProfile::with('user')
                    ->where(function ($q) use ($query) {
                        $q->where('brand_name', 'like', "%{$query}%")
                            ->orWhereHas('user', function ($q2) use ($query) {
                                $q2->where('name', 'like', "%{$query}%")
                                    ->orWhere('location', 'like', "%{$query}%");
                            });
                    })
                    ->limit(12)
                    ->get();
            }

            if (in_array($type, ['all', 'studios'])) {
                $results['studios'] = Studio::where('is_active', true)
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%")
                            ->orWhere('city', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->limit(12)
                    ->get();
            }
        }

        return view('search.results', compact('results', 'query', 'type'));
    }
}
