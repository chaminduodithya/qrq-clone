<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AdminOverview;
use App\Livewire\BusinessCreate;
use App\Livewire\BusinessQueues;
use App\Livewire\JoinQueue;
use App\Livewire\QueueCreate;
use App\Livewire\QueueDashboard;
use App\Livewire\QueueQr;
use Illuminate\Support\Facades\Route;
use Livewire\View;


Route::get('/', function () {
    return view('welcome');
});

// ── Public: customer join page (no auth) ──
Route::get('/join/{queue:slug}', JoinQueue::class)->name('join.queue');

// ── Public: display page (no auth) ──
Route::get('/display/{queue:slug}', App\Livewire\PublicDisplay::class)->name('display.queue');

// ── Admin login (accessible without auth) ──
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');

// ── Admin panel (auth required) ──
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/admin', AdminOverview::class)->name('admin.dashboard');

    // Redirect Breeze default /dashboard → /admin
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

    // Businesses
    Route::get('/businesses/create', BusinessCreate::class)->name('businesses.create');

    // Business queues
    Route::get('/business/{business:slug}/queues', BusinessQueues::class)->name('business.queues');
    Route::get('/business/{business:slug}/queues/create', QueueCreate::class)->name('business.create-queue');

    // Queue dashboard
    Route::get('/dashboard/{queue:slug}', QueueDashboard::class)->name('dashboard.queue');

    // Queue QR code page
    Route::get('/queue/{queue:slug}/qr', QueueQr::class)->name('queue.qr');
});

// ── Profile (Breeze) ──
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
