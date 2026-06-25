<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'total_users'      => User::count(),
            'total_creators'   => User::where('role', 'creator')->count(),
            'total_studios'    => Studio::count(),
            'total_bookings'   => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_revenue'    => Payment::where('status', 'completed')->sum('amount'),
            'new_users_month'  => User::whereMonth('created_at', now()->month)->count(),
        ];

        $recentBookings = Booking::with(['client', 'service'])->latest()->limit(10)->get();
        $recentUsers    = User::latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentUsers'));
    }

    public function users(Request $request)
    {
        $query = User::with('creatorProfile');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function verifyCreator(User $user)
    {
        $user->update(['is_verified' => true]);
        $user->creatorProfile?->update(['is_verified' => true]);

        return back()->with('success', "Creator verified: {$user->name}");
    }

    public function featureCreator(User $user)
    {
        $user->update(['is_featured' => ! $user->is_featured]);

        $status = $user->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "{$user->name} has been {$status}.");
    }

    public function bookings(Request $request)
    {
        $bookings = Booking::with(['client', 'service', 'creatorProfile.user'])
            ->latest()
            ->paginate(20);

        return view('admin.bookings', compact('bookings'));
    }

    public function studios(Request $request)
    {
        $studios = Studio::with(['owner'])->latest()->paginate(20);

        return view('admin.studios', compact('studios'));
    }
}
