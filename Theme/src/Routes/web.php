<?php

use AsefSondaj\Theme\Http\Controllers\AsefContactController;
use AsefSondaj\Theme\Http\Controllers\AsefHomeController;
use AsefSondaj\Theme\Http\Controllers\AsefKatalogController;
use AsefSondaj\Theme\Http\Controllers\AsefQuoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Asef Theme routes
|--------------------------------------------------------------------------
| Registered under 'web' middleware (see AsefThemeServiceProvider::boot()).
| Uses distinct Asef URLs so Bagisto's default routes stay intact for admin
| but our storefront serves these.
*/

// Homepage — override Bagisto default
Route::get('/', [AsefHomeController::class, 'index'])->name('asef.home');

// Catalog listing + product detail
Route::get('/katalog', [AsefKatalogController::class, 'index'])->name('asef.katalog');
Route::get('/katalog/urun/{sku}', [AsefKatalogController::class, 'show'])->name('asef.katalog.product');
Route::get('/katalog/{category}', [AsefKatalogController::class, 'index'])->name('asef.katalog.category')->where('category', '[a-z0-9-]+');

// Teklif Listem (session-based, but view uses localStorage on the client)
Route::get('/teklif', [AsefQuoteController::class, 'index'])->name('asef.quote');
Route::post('/teklif/send', [AsefQuoteController::class, 'send'])->name('asef.quote.send');

// İletişim
Route::get('/iletisim', [AsefContactController::class, 'index'])->name('asef.contact');
