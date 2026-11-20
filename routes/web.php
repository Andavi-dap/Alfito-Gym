<?php

use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\MembershipPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\Member\MembershipApplicationController
    as MemberMembershipApplicationController;
use App\Http\Controllers\Member\PaymentController
    as MemberPaymentController;
use App\Http\Controllers\Member\ProgramBookingController;
use App\Http\Controllers\Admin\MembershipApplicationController
    as AdminMembershipApplicationController;
use App\Http\Controllers\Admin\PaymentController
    as AdminPaymentController;
use App\Http\Controllers\Admin\ProgramBookingController as AdminProgramBookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// LOGOUT
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout');

// PUBLIC HOMEPAGE
Route::view('/', 'pages.home')->name('home');

// PUBLIC PROGRAMS
Route::view('/programs', 'programs.index')
    ->name('programs.index');

// PUBLIC TRAINERS
Route::view('/trainers', 'trainers.index')
    ->name('trainers.index');

// PUBLIC MEMBERSHIP
Route::get('/membership', [MembershipController::class, 'index'])
    ->name('membership');

// DASHBOARD
Route::get('/dashboard', function () {
    $user = auth()->user();
    $memberships = [];
    $payments = [];

    if ($user->role === 'member') {
        $memberships = $user->memberships()->with('membershipPlan')->latest()->get();
        $payments = $user->applications()->with('payments')->get()->pluck('payments')->flatten();
    }

    return view('dashboard', compact('memberships', 'payments'));
})->middleware(['auth', 'verified'])->name('dashboard');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// MEMBER ROUTES
Route::middleware(['auth'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        Route::get('/applications',
            [MemberMembershipApplicationController::class, 'index']
        )->name('applications.index');

        Route::post('/applications',
            [MemberMembershipApplicationController::class, 'store']
        )->name('applications.store');

        Route::post('/applications/{application}/payment',
            [MemberPaymentController::class, 'store']
        )
        ->whereNumber('application')
        ->name('applications.payment.store');

        Route::get('/bookings', [ProgramBookingController::class, 'index'])->name('bookings.index');
        Route::post('/bookings', [ProgramBookingController::class, 'store'])->name('bookings.store');
        Route::delete('/bookings/{booking}', [ProgramBookingController::class, 'destroy'])->name('bookings.destroy');
    });

// ADMIN ROUTES
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('locations', LocationController::class)->except(['show']);
        Route::resource('trainers', TrainerController::class)->except(['show']);
        Route::resource('programs', ProgramController::class)->except(['show']);
        Route::resource('plans', MembershipPlanController::class)->except(['show']);

        Route::get('/bookings', [AdminProgramBookingController::class, 'index'])->name('bookings.index');
        Route::patch('/bookings/{booking}/decision', [AdminProgramBookingController::class, 'update'])->name('bookings.decision');

        Route::get('/applications',
            [AdminMembershipApplicationController::class, 'index']
        )->name('applications.index');

        Route::patch('/applications/{application}/review',
            [AdminMembershipApplicationController::class, 'update']
        )
        ->whereNumber('application')
        ->name('applications.review');

        Route::get('/payments',
            [AdminPaymentController::class, 'index']
        )->name('payments.index');

        Route::patch('/payments/{payment}/decision',
            [AdminPaymentController::class, 'update']
        )
        ->whereNumber('payment')
        ->name('payments.decision');

        Route::get('/payments/{payment}/proof',
            [AdminPaymentController::class, 'proof']
        )
        ->whereNumber('payment')
        ->name('payments.proof');
    });

require __DIR__.'/auth.php';
