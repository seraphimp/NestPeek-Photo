<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function start()
    {
        $user = auth()->user();

        if ($user->isClient()) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.start', compact('user'));
    }

    public function profile(Request $request)
    {
        $request->validate([
            'brand_name'             => 'nullable|string|max:255',
            'tagline'                => 'nullable|string|max:255',
            'specialization'         => 'required|string',
            'bio'                    => 'nullable|string|max:2000',
            'location'               => 'nullable|string|max:255',
            'years_experience'       => 'nullable|integer|min:0|max:50',
            'starting_price'         => 'nullable|numeric|min:0',
            'availability_note'      => 'nullable|string|max:255',
            'instagram'              => 'nullable|string|max:255',
            'facebook'               => 'nullable|string|max:255',
            'website'                => 'nullable|url|max:255',
            'phone'                  => 'nullable|string|max:50',
        ]);

        $user = auth()->user();

        // Update user table fields
        $user->update([
            'bio'       => $request->bio,
            'location'  => $request->location,
            'instagram' => $request->instagram,
            'facebook'  => $request->facebook,
            'website'   => $request->website,
            'phone'     => $request->phone,
        ]);

        // Parse JSON tag fields (comma-separated strings from tag inputs)
        $styles       = $this->parseTagField($request->input('styles'));
        $skills       = $this->parseTagField($request->input('skills'));
        $equipment    = $this->parseTagField($request->input('equipment'));
        $serviceAreas = $this->parseTagField($request->input('service_areas'));

        // Update creator profile
        $profile = $user->creatorProfile;
        $profile->update([
            'brand_name'             => $request->brand_name,
            'tagline'                => $request->tagline,
            'specialization'         => $request->specialization,
            'years_experience'       => $request->years_experience ?? 0,
            'starting_price'         => $request->starting_price,
            'is_available'           => $request->boolean('is_available'),
            'travels_internationally' => $request->boolean('travels_internationally'),
            'availability_note'      => $request->availability_note,
            'styles'                 => $styles,
            'skills'                 => $skills,
            'equipment'              => $equipment,
            'service_areas'          => $serviceAreas,
        ]);

        // Rebuild slug from brand_name or user name
        $profile->slug = Str::slug($request->brand_name ?? $user->name) . '-' . $user->id;
        $profile->save();

        return redirect()->route('onboarding.services');
    }

    public function services()
    {
        $user = auth()->user();
        return view('onboarding.services', compact('user'));
    }

    public function complete(Request $request)
    {
        $user    = auth()->user();
        $profile = $user->creatorProfile;

        // Save services if submitted
        if ($request->has('services')) {
            $request->validate([
                'services.*.name'                => 'required|string|max:255',
                'services.*.category'            => 'required|string',
                'services.*.price'               => 'required|numeric|min:0',
                'services.*.price_type'          => 'nullable|string',
                'services.*.duration_hours'      => 'nullable|numeric|min:0',
                'services.*.description'         => 'nullable|string|max:2000',
                'services.*.inclusions'          => 'nullable|string|max:1000',
                'services.*.deposit_percentage'  => 'nullable|integer|min:0|max:100',
                'services.*.max_bookings_per_day' => 'nullable|integer|min:1',
            ]);

            foreach ($request->services as $svc) {
                // Skip empty/incomplete entries
                if (empty($svc['name']) || empty($svc['price'])) continue;

                Service::insert([
                    'serviceable_type'        => get_class($profile),
                    'serviceable_id'          => $profile->id,
                    'name'                    => $svc['name'],
                    'slug'                    => Str::slug($svc['name']) . '-' . Str::random(4),
                    'category'                => $svc['category'] ?? 'other',
                    'description'             => $svc['description'] ?? null,
                    'inclusions'              => $svc['inclusions'] ?? null,
                    'price'                   => $svc['price'],
                    'price_type'              => $svc['price_type'] ?? 'fixed',
                    'duration_hours'          => $svc['duration_hours'] ?? null,
                    'requires_deposit'        => !empty($svc['deposit_percentage']),
                    'deposit_percentage'      => $svc['deposit_percentage'] ?? null,
                    'max_bookings_per_day'    => $svc['max_bookings_per_day'] ?? 1,
                    'is_active'               => 1,
                    'created_at'              => now(),
                    'updated_at'              => now(),
                ]);
            }

            // Update starting_price to lowest service price if not already set
            if (!$profile->starting_price) {
                $lowestPrice = Service::where('serviceable_type', get_class($profile))
                    ->where('serviceable_id', $profile->id)
                    ->min('price');

                if ($lowestPrice) {
                    $profile->update(['starting_price' => $lowestPrice]);
                }
            }
        }

        return redirect()->route('dashboard')
            ->with('success', 'Profile setup complete! Welcome to NestPeek Photo. 🎉');
    }

    /**
     * Parse a comma-separated tag string into an array.
     * Returns null if empty so JSON column stays null rather than [].
     */
    private function parseTagField(?string $value): ?array
    {
        if (!$value || trim($value) === '') return null;

        $tags = array_values(
            array_filter(
                array_map('trim', explode(',', $value)),
                fn($t) => $t !== ''
            )
        );

        return count($tags) > 0 ? $tags : null;
    }
}
