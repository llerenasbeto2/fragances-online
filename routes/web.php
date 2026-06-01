<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FragranceController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CollectionController;
use Inertia\Inertia;
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
*/

Route::get('/', function () {
    return Inertia::render('Home');
});


Route::get('/login', function () {
    return Inertia::render('Auth/Login');
});



Route::get('/user/dashboard', function () {
    return Inertia::render('User/Dashboard');
})->middleware('role:user');

Route::get('/admin/dashboard', function () {
    return Inertia::render('Auth/Admin/Dashboard');
})->middleware('role:admin');


Route::middleware('role:admin')->group(function () {
    Route::get('/admin/fragrances', [FragranceController::class, 'index'])->name('admin.fragrances.index');
    Route::get('/admin/fragrances/create', [FragranceController::class, 'create'])->name('admin.fragrances.create');
    Route::post('/admin/fragrances', [FragranceController::class, 'store'])->name('admin.fragrances.store');
    Route::get('/admin/fragrances/{fragrance}/edit', [FragranceController::class, 'edit'])->name('admin.fragrances.edit');
    Route::put('/admin/fragrances/{fragrance}', [FragranceController::class, 'update'])->name('admin.fragrances.update');
    Route::delete('/admin/fragrances/{fragrance}', [FragranceController::class, 'destroy'])->name('admin.fragrances.destroy');

    // Brands — nuevas
    Route::get('/admin/brands',              [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('/admin/brands/create',       [BrandController::class, 'create'])->name('admin.brands.create');
    Route::post('/admin/brands',             [BrandController::class, 'store'])->name('admin.brands.store');
    Route::get('/admin/brands/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
    Route::put('/admin/brands/{brand}',      [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('/admin/brands/{brand}',   [BrandController::class, 'destroy'])->name('admin.brands.destroy');

    // Collections — nuevas
    Route::get('/admin/collections',                   [CollectionController::class, 'index'])->name('admin.collections.index');
    Route::get('/admin/collections/create',            [CollectionController::class, 'create'])->name('admin.collections.create');
    Route::post('/admin/collections',                  [CollectionController::class, 'store'])->name('admin.collections.store');
    Route::get('/admin/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('admin.collections.edit');
    Route::put('/admin/collections/{collection}',      [CollectionController::class, 'update'])->name('admin.collections.update');
    Route::delete('/admin/collections/{collection}',   [CollectionController::class, 'destroy'])->name('admin.collections.destroy');
});

/*
Route::get('/admin/fragrances', [FragranceController::class, 'index'])->name('admin.fragrances.index');
Route::get('/admin/fragrances/create', [FragranceController::class, 'create'])->name('admin.fragrances.create');
Route::post('/admin/fragrances', [FragranceController::class, 'store'])->name('admin.fragrances.store');
Route::get('/admin/fragrances/{fragrance}/edit', [FragranceController::class, 'edit'])->name('admin.fragrances.edit');
Route::put('/admin/fragrances/{fragrance}', [FragranceController::class, 'update'])->name('admin.fragrances.update');
Route::delete('/admin/fragrances/{fragrance}', [FragranceController::class, 'destroy'])->name('admin.fragrances.destroy');*/