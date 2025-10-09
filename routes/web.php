<?php

use App\Http\Controllers\PropertyController; // kept for landing method only
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Landing page as the new home (data-backed)
Route::get('/', [PropertyController::class, 'landing'])->name('home');
// Remove legacy explore/properties pages (real-estate) — no longer used
// Route::get('/explore', [PropertyController::class, 'home'])->name('explore');
// Breeze navigation expects a 'dashboard' route; redirect to home
Route::get('/dashboard', function(){
    return redirect()->route('home');
})->name('dashboard');
// Marketing request (public)
Route::get('/marketing/request', [\App\Http\Controllers\MarketingRequestController::class, 'create'])->name('marketing.request.create');
Route::post('/marketing/request', [\App\Http\Controllers\MarketingRequestController::class, 'store'])->name('marketing.request.store');
// General contact (keep)
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'storeHome'])->name('contact.home.store');
// Removed: properties pages, property comments, property contact, owner property CRUD

// Events public
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// Events management (staff)
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/admin/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/admin/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// Gallery public
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Gallery management (staff)
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/admin/gallery/{item}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/admin/gallery/{item}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/admin/gallery/{item}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});

// Projects (Portfolio) public routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Projects management (staff)
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/admin/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/admin/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

// Staff management for marketing requests
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/marketing-requests', [\App\Http\Controllers\MarketingRequestController::class, 'index'])->name('admin.marketing_requests.index');
    Route::get('/admin/marketing-requests/{marketingRequest}', [\App\Http\Controllers\MarketingRequestController::class, 'show'])->name('admin.marketing_requests.show');
    Route::put('/admin/marketing-requests/{marketingRequest}', [\App\Http\Controllers\MarketingRequestController::class, 'update'])->name('admin.marketing_requests.update');
});

// Favorites related to properties removed

// Manager-only routes
Route::middleware(['auth','manager'])->group(function(){
    Route::get('/admin/users/promote', [\App\Http\Controllers\ManagerController::class, 'promoteForm'])->name('admin.users.promote.form');
    Route::post('/admin/users/promote', [\App\Http\Controllers\ManagerController::class, 'promote'])->name('admin.users.promote');
    Route::get('/admin/users/non-employees', [\App\Http\Controllers\ManagerController::class, 'nonEmployees'])->name('admin.users.non_employees');
});

require __DIR__.'/auth.php';
