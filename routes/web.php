<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Livewire\AdminOverview;
use App\Livewire\BusinessCreate;
use App\Livewire\BusinessQueues;
use App\Livewire\JoinQueue;
use App\Livewire\QueueCreate;
use App\Livewire\QueueDashboard;
use Illuminate\Support\Facades\Route;

// ── Welcome ──
Route::get('/', function () {
    return view('welcome');
});

// ── Public: customer join page (no auth) ──
Route::get('/join/{queue:slug}', JoinQueue::class)->name('join.queue');

// ── Admin: public login routes ──
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
});

// ── Admin: protected routes (must be auth + admin role) ──
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Overview dashboard
    Route::get('/', AdminOverview::class)->name('admin.dashboard');

    // Redirect legacy /dashboard → /admin
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

    // Businesses
    Route::get('/businesses/create', BusinessCreate::class)->name('businesses.create');

    // Business queues
    Route::get('/business/{business:slug}/queues', BusinessQueues::class)->name('business.queues');
    Route::get('/business/{business:slug}/queues/create', QueueCreate::class)->name('business.create-queue');

    // Queue dashboard
    Route::get('/queue/{queue:slug}', QueueDashboard::class)->name('dashboard.queue');
});

// ── Profile (Breeze) ──
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
