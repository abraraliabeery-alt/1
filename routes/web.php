<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\GalleryController;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\PartnerAdminController;
use App\Http\Controllers\Admin\FaqAdminController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Admin\PropertyAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\Admin\TenderAdminController;

// Landing page as the new home (IT company)
Route::get('/', [HomeController::class, 'index'])->name('home');
// Search (Google Custom Search JSON API)
Route::get('/search', [SearchController::class, 'index'])->name('search');
// Batch image search (upload .txt of product names)
Route::get('/images-batch', [SearchController::class, 'showImagesBatch'])->name('images.batch.form');
Route::post('/images-batch', [SearchController::class, 'handleImagesBatch'])->name('images.batch.handle');
// Remove legacy explore/properties pages (real-estate) — no longer used
// Route::get('/explore', [PropertyController::class, 'home'])->name('explore');
// Breeze navigation expects a 'dashboard' route; redirect to home
Route::get('/dashboard', function(){
    return redirect()->route('home');
})->name('dashboard');
// Marketing requests removed
// General contact (keep)
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'storeHome'])->name('contact.home.store');
// Removed: properties pages, property comments, property contact, owner property CRUD

// Events removed

// Services public
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// About page
Route::view('/about', 'about')->name('about');

// Products: dynamic from uploaded TXT, with pagination
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/import', [ProductsController::class, 'importForm'])->name('products.import.form');
Route::post('/products/import', [ProductsController::class, 'importStore'])->name('products.import.store');

// Admin-lite: products images review (no auth for now; add middleware later if desired)
Route::get('/admin/products/images-review', [\App\Http\Controllers\ProductImageReviewController::class, 'index'])->name('admin.products.images.review');
Route::post('/admin/products/images-review', [\App\Http\Controllers\ProductImageReviewController::class, 'store'])->name('admin.products.images.review.store');

// Events management removed

// Gallery public
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Properties public
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Gallery management (staff) — add-only
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/admin/gallery/sort', [GalleryController::class, 'sort'])->name('gallery.sort');
    Route::post('/admin/gallery/sort', [GalleryController::class, 'sortSave'])->name('gallery.sort.save');
});

// Projects (Portfolio) public routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Privacy policy (required for ads)
Route::view('/privacy', 'privacy')->name('privacy');

// Projects management (staff)
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/admin/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/admin/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

// Marketing requests removed

// Admin dashboard (staff)
Route::middleware(['auth','staff'])->group(function(){
    Route::get('/admin', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
    // Contacts management
    Route::get('/admin/contacts', [ContactAdminController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/{contact}', [ContactAdminController::class, 'show'])->name('admin.contacts.show');
    Route::put('/admin/contacts/{contact}', [ContactAdminController::class, 'update'])->name('admin.contacts.update');
    Route::delete('/admin/contacts/{contact}', [ContactAdminController::class, 'destroy'])->name('admin.contacts.destroy');
    // Services management
    Route::get('/admin/services', [ServiceAdminController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/create', [ServiceAdminController::class, 'create'])->name('admin.services.create');
    Route::post('/admin/services', [ServiceAdminController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}/edit', [ServiceAdminController::class, 'edit'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [ServiceAdminController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceAdminController::class, 'destroy'])->name('admin.services.destroy');
    
    // Properties management
    Route::get('/admin/properties', [PropertyAdminController::class, 'index'])->name('admin.properties.index');
    Route::get('/admin/properties/create', [PropertyAdminController::class, 'create'])->name('admin.properties.create');
    Route::post('/admin/properties', [PropertyAdminController::class, 'store'])->name('admin.properties.store');
    Route::get('/admin/properties/{property}/edit', [PropertyAdminController::class, 'edit'])->name('admin.properties.edit');
    Route::put('/admin/properties/{property}', [PropertyAdminController::class, 'update'])->name('admin.properties.update');
    Route::delete('/admin/properties/{property}', [PropertyAdminController::class, 'destroy'])->name('admin.properties.destroy');
    Route::post('/admin/properties/bulk-destroy', [PropertyAdminController::class, 'bulkDestroy'])->name('admin.properties.bulk_destroy');
    Route::post('/admin/properties/{property}/toggle-featured', [PropertyAdminController::class, 'toggleFeatured'])->name('admin.properties.toggle_featured');
    // Partners management
    Route::get('/admin/partners', [PartnerAdminController::class, 'index'])->name('admin.partners.index');
    Route::get('/admin/partners/create', [PartnerAdminController::class, 'create'])->name('admin.partners.create');
    Route::post('/admin/partners', [PartnerAdminController::class, 'store'])->name('admin.partners.store');
    Route::get('/admin/partners/{partner}/edit', [PartnerAdminController::class, 'edit'])->name('admin.partners.edit');
    Route::put('/admin/partners/{partner}', [PartnerAdminController::class, 'update'])->name('admin.partners.update');
    Route::delete('/admin/partners/{partner}', [PartnerAdminController::class, 'destroy'])->name('admin.partners.destroy');

    // FAQs management
    Route::get('/admin/faqs', [FaqAdminController::class, 'index'])->name('admin.faqs.index');
    Route::get('/admin/faqs/create', [FaqAdminController::class, 'create'])->name('admin.faqs.create');
    Route::post('/admin/faqs', [FaqAdminController::class, 'store'])->name('admin.faqs.store');
    Route::get('/admin/faqs/{faq}/edit', [FaqAdminController::class, 'edit'])->name('admin.faqs.edit');
    Route::put('/admin/faqs/{faq}', [FaqAdminController::class, 'update'])->name('admin.faqs.update');
    Route::delete('/admin/faqs/{faq}', [FaqAdminController::class, 'destroy'])->name('admin.faqs.destroy');

    // Settings: Social & contact
    Route::get('/admin/settings/social', [\App\Http\Controllers\Admin\SettingAdminController::class, 'editSocial'])->name('admin.settings.social.edit');
    Route::put('/admin/settings/social', [\App\Http\Controllers\Admin\SettingAdminController::class, 'updateSocial'])->name('admin.settings.social.update');

    // Settings: Sections visibility
    Route::get('/admin/settings/sections', [\App\Http\Controllers\Admin\SettingAdminController::class, 'editSections'])->name('admin.settings.sections.edit');
    Route::put('/admin/settings/sections', [\App\Http\Controllers\Admin\SettingAdminController::class, 'updateSections'])->name('admin.settings.sections.update');

    // Settings: Branding (logo & favicon)
    Route::get('/admin/settings/branding', [\App\Http\Controllers\Admin\SettingAdminController::class, 'editBranding'])->name('admin.settings.branding.edit');
    Route::post('/admin/settings/branding', [\App\Http\Controllers\Admin\SettingAdminController::class, 'updateBranding'])->name('admin.settings.branding.update');

    // Tenders: Keep ONLY these routes
    Route::get('/admin/tenders/{tender}/pdf/preview', [TenderController::class, 'previewPdf'])->name('admin.tenders.pdf.preview');
    Route::get('/admin/tenders/{tender}/pdf/download', [TenderController::class, 'downloadPdf'])->name('admin.tenders.pdf.download');
    Route::get('/admin/tenders/{tender}/example', [TenderController::class, 'exampleForTender'])->name('admin.tenders.example');
    // Tenders: Management index page (dashboard styled)
    Route::get('/admin/tenders', [TenderAdminController::class, 'index'])->name('admin.tenders.index');
    // Tenders: Create (re-enabled)
    Route::get('/admin/tenders/create', [TenderAdminController::class, 'create'])->name('admin.tenders.create');
    Route::post('/admin/tenders', [TenderAdminController::class, 'store'])->name('admin.tenders.store');
});

// Favorites related to properties removed

// Manager-only routes
Route::middleware(['auth','manager'])->group(function(){
    Route::get('/admin/users', [\App\Http\Controllers\ManagerController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/promote', [\App\Http\Controllers\ManagerController::class, 'promoteForm'])->name('admin.users.promote.form');
    Route::post('/admin/users/promote', [\App\Http\Controllers\ManagerController::class, 'promote'])->name('admin.users.promote');
    Route::get('/admin/users/non-employees', [\App\Http\Controllers\ManagerController::class, 'nonEmployees'])->name('admin.users.non_employees');
    Route::get('/admin/users/employees', [\App\Http\Controllers\ManagerController::class, 'employees'])->name('admin.users.employees');
});

require __DIR__.'/auth.php';
