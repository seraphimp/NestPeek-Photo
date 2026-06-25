<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\User;
use App\Models\CreatorProfile;
use App\Notifications\StudioNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudioController extends Controller
{
    /**
     * Display a listing of studios
     */
    /**
     * Display a listing of studios
     */
    public function index()
    {
        $user = auth()->user();

        // If user is logged in, show their studios first
        if ($user) {
            // Get studios where user is owner
            $ownedStudios = $user->ownedStudios()->with('creatorProfile.user')->get();

            // Get studios where user is a member
            $memberStudios = collect();
            if ($user->creatorProfile) {
                $memberStudios = $user->creatorProfile->studios()->with('creatorProfile.user')->get();
            }

            // Combine and remove duplicates
            $studios = $ownedStudios->merge($memberStudios)->unique('id');

            // If user has studios, show them
            if ($studios->isNotEmpty()) {
                // Convert to paginator to be consistent
                $studios = new \Illuminate\Pagination\LengthAwarePaginator(
                    $studios->values(),
                    $studios->count(),
                    12,
                    1,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
                return view('studios.index', compact('studios'));
            }
        }

        // Otherwise show all active studios with pagination
        $studios = Studio::with('creatorProfile.user')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('studios.index', compact('studios'));
    }

    /**
     * Display the studio page
     */
    /**
     * Display the studio page
     */
    public function show(Studio $studio)
    {
        // Load relationships
        $studio->load([
            'creatorProfile',
            'creatorProfile.user',
            'services',
            'reviews',
            'bookings' => function ($query) {
                $query->latest()->limit(10);
            },
            'creators' => function ($query) {
                $query->with('user');
            },
        ]);

        // Check if current user is a member of this studio
        $isMember = false;
        $userRole = null;
        $isFavorited = false;

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->creatorProfile) {
                $member = $studio->creators()
                    ->where('creator_profile_id', $user->creatorProfile->id)
                    ->first();

                if ($member) {
                    $isMember = true;
                    $userRole = $member->pivot->role;
                }
            }

            // Check if studio is favorited by the user
            $isFavorited = $user->favorites()
                ->where('favorable_type', Studio::class)
                ->where('favorable_id', $studio->id)
                ->exists();
        }

        // Get studio members with their users
        $members = $studio->creators()->with('user')->get();

        // Get studio stats
        $stats = [
            'total_bookings' => $studio->bookings()->count(),
            'total_reviews' => $studio->reviews()->count(),
            'average_rating' => $studio->average_rating ?? 0,
            'members_count' => $members->count(),
        ];

        return view('studios.show', compact(
            'studio',
            'members',
            'isMember',
            'userRole',
            'isFavorited',
            'stats'
        ));
    }
    /**
     * Show the form for editing the studio
     */
    public function edit(Studio $studio)
    {
        // Check if user owns or is admin of this studio
        $user = auth()->user();
        $isAuthorized = false;

        // Check if user is the owner
        if ($user->id == $studio->owner_id) {
            $isAuthorized = true;
        }
        // Check if user is an admin member
        else if ($user->creatorProfile) {
            $member = $studio->creators()
                ->where('creator_profile_id', $user->creatorProfile->id)
                ->whereIn('role', ['owner', 'admin'])
                ->first();

            if ($member) {
                $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            abort(403, 'You are not authorized to edit this studio.');
        }

        return view('studios.edit', compact('studio'));
    }

    /**
     * Update the studio
     */
    public function update(Request $request, Studio $studio)
    {
        // Authorization check
        $user = auth()->user();
        $isAuthorized = false;

        // Check if user is the owner
        if ($user->id == $studio->owner_id) {
            $isAuthorized = true;
        }
        // Check if user is an admin member
        else if ($user->creatorProfile) {
            $member = $studio->creators()
                ->where('creator_profile_id', $user->creatorProfile->id)
                ->whereIn('role', ['owner', 'admin'])
                ->first();

            if ($member) {
                $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            abort(403, 'You are not authorized to update this studio.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:120',
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'hourly_rate' => 'nullable|numeric|min:0',
            'half_day_rate' => 'nullable|numeric|min:0',
            'full_day_rate' => 'nullable|numeric|min:0',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'max_capacity' => 'nullable|integer|min:1',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'string|in:photography,videography,coordination,makeup_hair,hosting_mc,music_dj,lighting_sound,drone,graphic_design',
            'cover_photo' => 'nullable|image|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $studio->update([
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'province' => $validated['province'] ?? null,
            'hourly_rate' => $validated['hourly_rate'] ?? null,
            'half_day_rate' => $validated['half_day_rate'] ?? null,
            'full_day_rate' => $validated['full_day_rate'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'max_capacity' => $validated['max_capacity'] ?? null,
            'specializations' => $validated['specializations'],
            'is_active' => $validated['is_active'] ?? $studio->is_active,
        ]);

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('studios/covers', 'public');
            $studio->update(['cover_photo' => $path]);
        }

        return redirect()->route('studios.show', $studio)
            ->with('success', 'Studio updated successfully!');
    }

    /**
     * Delete/Remove the studio
     */
    public function destroy(Studio $studio)
    {
        // Check if user is the owner
        $user = auth()->user();

        if ($user->id != $studio->owner_id) {
            abort(403, 'Only the studio owner can delete this studio.');
        }

        // Notify all members before deleting
        $members = $studio->creators()->get();
        foreach ($members as $member) {
            if ($member->user) {
                $member->user->notify(new StudioNotification(
                    'studio_deleted',
                    [
                        'studio_name' => $studio->name,
                        'deleted_by' => $user->name,
                    ],
                    $studio
                ));
            }
        }

        // Delete the studio
        $studio->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Studio deleted successfully.');
    }

    /**
     * Show studio members management page
     */
    public function members(Studio $studio)
    {
        // Check if user is authorized
        $user = auth()->user();
        $isAuthorized = false;

        if ($user->id == $studio->owner_id) {
            $isAuthorized = true;
        } else if ($user->creatorProfile) {
            $member = $studio->creators()
                ->where('creator_profile_id', $user->creatorProfile->id)
                ->whereIn('role', ['owner', 'admin'])
                ->first();

            if ($member) {
                $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            abort(403, 'You are not authorized to manage studio members.');
        }

        $members = $studio->creators()->with('user')->get();

        return view('studios.members', compact('studio', 'members'));
    }

    // ============================================================
    // YOUR EXISTING METHODS (store, addMember, removeMember, changeRole)
    // ============================================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:studios,name',
            'tagline' => 'nullable|string|max:120',
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'hourly_rate' => 'nullable|numeric|min:0',
            'half_day_rate' => 'nullable|numeric|min:0',
            'full_day_rate' => 'nullable|numeric|min:0',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'max_capacity' => 'nullable|integer|min:1',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'string|in:photography,videography,coordination,makeup_hair,hosting_mc,music_dj,lighting_sound,drone,graphic_design',
            'cover_photo' => 'nullable|image|max:5120',
            'member_emails' => 'nullable|array',
            'member_emails.*' => 'nullable|email',
        ]);

        // CHECK: If user is already a studio member
        if ($request->user()->isStudioMember()) {
            return back()->withErrors([
                'name' => 'You are already a member of a studio. You cannot create or join another one.'
            ]);
        }

        DB::transaction(function () use ($request, $validated, &$studio) {
            // Create studio
            $studio = Studio::create([
                'owner_id' => $request->user()->id,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'tagline' => $validated['tagline'] ?? null,
                'description' => $validated['description'] ?? null,
                'address' => $validated['address'],
                'city' => $validated['city'],
                'province' => $validated['province'] ?? null,
                'hourly_rate' => $validated['hourly_rate'] ?? null,
                'half_day_rate' => $validated['half_day_rate'] ?? null,
                'full_day_rate' => $validated['full_day_rate'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'] ?? null,
                'max_capacity' => $validated['max_capacity'] ?? null,
                'specializations' => $validated['specializations'],
                'is_active' => true,
            ]);

            // Handle cover photo
            if ($request->hasFile('cover_photo')) {
                $path = $request->file('cover_photo')->store('studios/covers', 'public');
                $studio->update(['cover_photo' => $path]);
            }

            // Add owner as member
            if ($request->user()->creatorProfile) {
                $studio->creators()->attach($request->user()->creatorProfile->id, [
                    'role' => 'owner',
                    'joined_at' => now(),
                ]);
            }

            // Process member invitations
            $addedMembers = [];
            if (!empty($validated['member_emails'])) {
                foreach ($validated['member_emails'] as $email) {
                    if (empty($email)) continue;

                    $invitedUser = User::where('email', $email)->first();

                    if ($invitedUser) {
                        // CHECK: If invited user is already in a studio
                        if ($invitedUser->isStudioMember()) {
                            continue; // Skip - already in a studio
                        }

                        // Check if user has a creator profile
                        if ($invitedUser->creatorProfile) {
                            $studio->creators()->attach($invitedUser->creatorProfile->id, [
                                'role' => 'member',
                                'joined_at' => now(),
                            ]);

                            $addedMembers[] = $invitedUser;

                            // SEND NOTIFICATION to the invited user
                            $invitedUser->notify(new StudioNotification(
                                'member_added',
                                [
                                    'role' => 'member',
                                    'added_by' => $request->user()->name,
                                ],
                                $studio
                            ));
                        }
                    }
                }
            }

            // NOTIFY: Studio owner
            $request->user()->notify(new StudioNotification(
                'studio_created',
                [
                    'studio_name' => $studio->name,
                    'members_added' => count($addedMembers),
                ],
                $studio
            ));
        });

        $message = 'Studio created successfully!';
        if (!empty($addedMembers)) {
            $message .= ' ' . count($addedMembers) . ' team member(s) have been added and notified.';
        }

        return redirect()->route('studios.show', $studio)
            ->with('success', $message);
    }

    // Add member method
    public function addMember(Request $request, Studio $studio)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:member,admin',
        ]);

        $user = User::where('email', $request->email)->first();

        // CHECK: If user is already in a studio
        if ($user->isStudioMember()) {
            return back()->withErrors([
                'email' => 'This user is already a member of another studio.'
            ]);
        }

        if (!$user->creatorProfile) {
            return back()->withErrors([
                'email' => 'This user needs to complete their creator profile first.'
            ]);
        }

        // Check if already in this studio
        if ($studio->creators()->where('user_id', $user->id)->exists()) {
            return back()->withErrors([
                'email' => 'This user is already a member of this studio.'
            ]);
        }

        // Add to studio
        $studio->creators()->attach($user->creatorProfile->id, [
            'role' => $request->role,
            'joined_at' => now(),
        ]);

        // SEND NOTIFICATION
        $user->notify(new StudioNotification(
            'member_added',
            [
                'role' => $request->role,
                'added_by' => $request->user()->name,
            ],
            $studio
        ));

        return back()->with('success', 'Member added successfully! They have been notified.');
    }

    // Remove member method
    public function removeMember(Request $request, Studio $studio, $userId)
    {
        $user = User::findOrFail($userId);

        // Can't remove owner
        if ($studio->owner_id == $userId) {
            return back()->withErrors(['error' => 'Cannot remove the studio owner.']);
        }

        // Remove from studio
        $studio->creators()->detach($user->creatorProfile->id);

        // SEND NOTIFICATION
        $user->notify(new StudioNotification(
            'member_removed',
            [
                'removed_by' => $request->user()->name,
            ],
            $studio
        ));

        return back()->with('success', 'Member removed successfully.');
    }

    // Change member role
    public function changeRole(Request $request, Studio $studio, $userId)
    {
        $request->validate([
            'role' => 'required|in:member,admin',
        ]);

        $user = User::findOrFail($userId);

        // Can't change owner's role
        if ($studio->owner_id == $userId) {
            return back()->withErrors(['error' => 'Cannot change the studio owner\'s role.']);
        }

        // Update role
        $studio->creators()->updateExistingPivot($user->creatorProfile->id, [
            'role' => $request->role,
        ]);

        // SEND NOTIFICATION
        $user->notify(new StudioNotification(
            'role_changed',
            [
                'role' => $request->role,
                'changed_by' => $request->user()->name,
            ],
            $studio
        ));

        return back()->with('success', 'Role updated successfully.');
    }
    /**
     * Display the public studio page (for non-authenticated users)
     */
    public function showPublic(Studio $studio)
    {
        // Load relationships
        $studio->load([
            'creatorProfile',
            'creatorProfile.user',
            'services',
            'reviews',
            'bookings' => function ($query) {
                $query->latest()->limit(10);
            },
            'creators' => function ($query) {
                $query->with('user');
            },
        ]);

        // Check if current user is a member of this studio (if authenticated)
        $isMember = false;
        $userRole = null;
        $isFavorited = false;

        if (auth()->check()) {
            $user = auth()->user();

            // Check if user is a member
            if ($user->creatorProfile) {
                $member = $studio->creators()
                    ->where('creator_profile_id', $user->creatorProfile->id)
                    ->first();

                if ($member) {
                    $isMember = true;
                    $userRole = $member->pivot->role;
                }
            }

            // Check if studio is favorited by the user
            $isFavorited = $user->favorites()
                ->where('favorable_type', Studio::class)
                ->where('favorable_id', $studio->id)
                ->exists();
        }

        // Get studio members with their users
        $members = $studio->creators()->with('user')->get();

        // Get studio stats
        $stats = [
            'total_bookings' => $studio->bookings()->count(),
            'total_reviews' => $studio->reviews()->count(),
            'average_rating' => $studio->average_rating ?? 0,
            'members_count' => $members->count(),
        ];

        return view('studios.public', compact(
            'studio',
            'members',
            'isMember',
            'userRole',
            'isFavorited',
            'stats'
        ));
    }
}
