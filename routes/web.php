<?php
// ============================================================
<<<<<<< HEAD
// FILE: routes/web.php (FULLY COMPLETE)
=======
// FILE: routes/web.php
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
// ============================================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
<<<<<<< HEAD
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminController;

// ── Public routes ────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Creators (public browsing)
=======
use App\Http\Controllers\Admin\AdminController;

// Public routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Creators
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
Route::prefix('creators')->name('creators.')->group(function () {
    Route::get('/', [CreatorController::class, 'index'])->name('index');
    Route::get('/{creatorProfile:slug}', [CreatorController::class, 'show'])->name('show');
});

<<<<<<< HEAD
// Studios (public browsing — index only here; the wildcard {studio} route
// is registered further down, AFTER the static /studios/create etc routes,
// so Laravel doesn't mistake "create" for a studio slug)
Route::prefix('studios')->name('studios.')->group(function () {
    Route::get('/', [StudioController::class, 'index'])->name('index');
});

// Auth scaffolding
require __DIR__ . '/auth.php';

// ── Authenticated routes ─────────────────────────────────────
=======
// Studios
Route::prefix('studios')->name('studios.')->group(function () {
    Route::get('/', [StudioController::class, 'index'])->name('index');
    Route::get('/{studio:slug}', [StudioController::class, 'show'])->name('show');
});

// Auth
require __DIR__ . '/auth.php';

// Authenticated routes
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
Route::middleware(['auth', 'verified'])->group(function () {

    // Onboarding
    Route::get('/onboarding', [OnboardingController::class, 'start'])->name('onboarding.start');
    Route::post('/onboarding/profile', [OnboardingController::class, 'profile'])->name('onboarding.profile');
    Route::get('/onboarding/services', [OnboardingController::class, 'services'])->name('onboarding.services');
    Route::post('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
<<<<<<< HEAD
        Route::get('/',                       [BookingController::class, 'index'])->name('index');
        Route::get('/create',                 [BookingController::class, 'create'])->name('create');
        Route::post('/',                      [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}',              [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/confirm',     [BookingController::class, 'confirm'])->name('confirm');
        Route::post('/{booking}/cancel',      [BookingController::class, 'cancel'])->name('cancel');
        Route::patch('/{booking}/accept',     [BookingController::class, 'accept'])->name('accept');
        Route::patch('/{booking}/decline',    [BookingController::class, 'decline'])->name('decline');
=======
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
    });

    // Reviews
    Route::post('/bookings/{booking}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
<<<<<<< HEAD
        Route::get('/',                        [MessageController::class, 'index'])->name('index');
        Route::get('/{conversation}',          [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/send',    [MessageController::class, 'send'])->name('send');
=======
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{conversation}', [MessageController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [MessageController::class, 'send'])->name('send');
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
    });

    // Favorites
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

<<<<<<< HEAD
    // Portfolio
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    // Creator & studio owner routes
    Route::middleware('role:creator,studio_owner')->group(function () {

        // Creator profile
        Route::get('/my-profile/edit', [CreatorController::class, 'edit'])->name('creators.edit');
        Route::put('/my-profile',      [CreatorController::class, 'update'])->name('creators.update');

        // Portfolio management
        Route::post('/portfolios',                   [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::delete('/portfolios/{portfolio}',     [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

        // ── STUDIO MANAGEMENT ────────────────────────────────────
        // STATIC routes (no {studio} parameter) MUST come first
        Route::get('/studios/create', [StudioController::class, 'create'])->name('studios.create');
        Route::post('/studios',       [StudioController::class, 'store'])->name('studios.store');

        // ── SERVICE & MEMBER MANAGEMENT ──────────────────────────
        // IMPORTANT: Add these BEFORE the {studio}/edit route!
        // These handle adding services and members to a studio
        Route::prefix('studios/{studio}')->group(function () {

            // ── SERVICE ROUTES ──────────────────────────────────────
            // Index/List services
            Route::get('/services', [ServiceController::class, 'index'])->name('studios.services.index');

            // Create service
            Route::get('/services/create', [ServiceController::class, 'create'])->name('studios.services.create');
            Route::post('/services',       [ServiceController::class, 'store'])->name('studios.services.store');

            // Edit/Update/Delete service
            Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('studios.services.edit');
            Route::put('/services/{service}',      [ServiceController::class, 'update'])->name('studios.services.update');
            Route::delete('/services/{service}',   [ServiceController::class, 'destroy'])->name('studios.services.destroy');

            // ── MEMBER ROUTES ──────────────────────────────────────
            // Index/List members
            Route::get('/members', [StudioController::class, 'members'])->name('studios.members.index');

            // Add member
            Route::get('/members/create', [StudioController::class, 'createMember'])->name('studios.members.create');
            Route::post('/members',       [StudioController::class, 'addMember'])->name('studios.members.store');

            // Remove member
            Route::delete('/members/{creator}', [StudioController::class, 'removeMember'])->name('studios.members.destroy');

            // Update member role (optional)
            Route::patch('/members/{creator}/role', [StudioController::class, 'updateMemberRole'])->name('studios.members.update-role');

            // ── AVAILABILITY ROUTES ───────────────────────────────
            Route::get('/availability', [AvailabilityController::class, 'index'])->name('studios.availability.index');
            Route::post('/availability', [AvailabilityController::class, 'update'])->name('studios.availability.update');

            // ── GALLERY/PHOTOS ROUTES ──────────────────────────────
            Route::post('/photos', [StudioController::class, 'uploadPhoto'])->name('studios.photos.store');
            Route::delete('/photos/{photo}', [StudioController::class, 'deletePhoto'])->name('studios.photos.destroy');
        });

        // ── EDIT ROUTE ────────────────────────────────────────────
        // This comes AFTER all the specific POST routes
        Route::get('/studios/{studio}/edit', [StudioController::class, 'edit'])->name('studios.edit');
        Route::put('/studios/{studio}',      [StudioController::class, 'update'])->name('studios.update');

        // ── DASHBOARD ROUTE ──────────────────────────────────────
        // This comes after edit so it doesn't conflict
        Route::get('/studios/{studio:slug}/dashboard', [StudioController::class, 'show'])->name('studios.show');
    });

    // Payments (commented out until Stripe is configured)
    // Route::post('/bookings/{booking}/pay',      [PaymentController::class, 'processDeposit'])->name('payments.deposit');
    // Route::post('/bookings/{booking}/pay-full', [PaymentController::class, 'processFull'])->name('payments.full');
    // Route::get('/payments/success',             [PaymentController::class, 'success'])->name('payments.success');

    // Profile settings (commented out until ProfileController is ready)
    // Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Notification routes - ADD THESE
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// ── Admin routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard',              [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                  [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/verify',   [AdminController::class, 'verifyCreator'])->name('verify');
    Route::post('/users/{user}/feature',  [AdminController::class, 'featureCreator'])->name('feature');
    Route::get('/bookings',               [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/studios',                [AdminController::class, 'studios'])->name('studios');
});

// ── Public studio detail page ─────────────────────────────────
// Wildcard route — registered LAST among /studios/* routes so it
// never shadows /studios/create, /studios (POST), etc above.
Route::get('/studios/{studio:slug}', [StudioController::class, 'showPublic'])->name('studios.public');

// Stripe Webhooks (commented out until configured)
// Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
Route::get('/creators', [CreatorController::class, 'index'])->name('creators.index');
Route::middleware(['auth', 'verified', 'role:creator,studio_owner'])->prefix('studios')->group(function () {
    Route::get('/{studio}/members', [StudioController::class, 'members'])->name('studios.members.index');
    Route::post('/{studio}/members', [StudioController::class, 'addMember'])->name('studios.members.add');
    Route::post('/{studio}/members/{userId}/role', [StudioController::class, 'changeRole'])->name('studios.members.role');
    Route::delete('/{studio}/members/{userId}', [StudioController::class, 'removeMember'])->name('studios.members.remove');
});
=======
    // Creator profile management
    Route::middleware('role:creator,studio_owner')->group(function () {
        Route::get('/my-profile/edit', [CreatorController::class, 'edit'])->name('creators.edit');
        Route::put('/my-profile', [CreatorController::class, 'update'])->name('creators.update');

        // Services
        //Route::resource('services', ServiceController::class)->except(['show']);

        // Portfolio
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

        // Availability
        //Route::post('/availability', [AvailabilityController::class, 'update'])->name('availability.update');

        // Studio management
        Route::get('/studios/create', [StudioController::class, 'create'])->name('studios.create');
        Route::post('/studios', [StudioController::class, 'store'])->name('studios.store');
        Route::get('/studios/{studio}/edit', [StudioController::class, 'edit'])->name('studios.edit');
        Route::put('/studios/{studio}', [StudioController::class, 'update'])->name('studios.update');
    });

    // Payments
//    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'processDeposit'])->name('payments.deposit');
  //  Route::post('/bookings/{booking}/pay-full', [PaymentController::class, 'processFull'])->name('payments.full');
    //Route::get('/payments/success', [PaymentController::class, 'success'])->name('payments.success');

    // Profile settings
    //Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::put('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/verify', [AdminController::class, 'verifyCreator'])->name('verify');
    Route::post('/users/{user}/feature', [AdminController::class, 'featureCreator'])->name('feature');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/studios', [AdminController::class, 'studios'])->name('studios');
});

Route::prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
    Route::post('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
    Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    // ADD THESE TWO:
    Route::patch('/{booking}/accept', [BookingController::class, 'accept'])->name('accept');
    Route::patch('/{booking}/decline', [BookingController::class, 'decline'])->name('decline');
});

Route::patch('/{booking}/accept', [BookingController::class, 'accept'])->name('accept');
Route::patch('/{booking}/decline', [BookingController::class, 'decline'])->name('decline');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
// Stripe Webhooks
//Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
>>>>>>> f904dc6f13fa0b79d16d33deaac04478b369d83f
