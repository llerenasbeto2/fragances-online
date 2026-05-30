<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FragranceController;
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
});

/*
Route::get('/admin/fragrances', [FragranceController::class, 'index'])->name('admin.fragrances.index');
Route::get('/admin/fragrances/create', [FragranceController::class, 'create'])->name('admin.fragrances.create');
Route::post('/admin/fragrances', [FragranceController::class, 'store'])->name('admin.fragrances.store');
Route::get('/admin/fragrances/{fragrance}/edit', [FragranceController::class, 'edit'])->name('admin.fragrances.edit');
Route::put('/admin/fragrances/{fragrance}', [FragranceController::class, 'update'])->name('admin.fragrances.update');
Route::delete('/admin/fragrances/{fragrance}', [FragranceController::class, 'destroy'])->name('admin.fragrances.destroy');*/