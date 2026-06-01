<?php
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\FragranceApiController;
use App\Http\Controllers\API\CollectionApiController;
use App\Http\Controllers\API\BrandApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function() {
    Route::post(uri:'login',action:LoginController::class);
    Route::post(uri:'logout',action:LogoutController::class);
});


// Ruta para obtener datos del usuario autenticado
Route::middleware(['auth:api'])->get('/user', function () {
    return response()->json(auth('api')->user());
});

// Rutas solo para admin
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome Admin Dashboard']);
    });
});



Route::get('/fragrances',          [FragranceApiController::class, 'index']);
Route::get('/fragrances/{fragrance}', [FragranceApiController::class, 'show']);


Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/fragrances',                [FragranceApiController::class, 'store']);
    Route::put('/fragrances/{fragrance}',     [FragranceApiController::class, 'update']);
    Route::delete('/fragrances/{fragrance}',  [FragranceApiController::class, 'destroy']);
});



Route::get('/collections',              [CollectionApiController::class, 'index']);
Route::get('/collections/{collection}', [CollectionApiController::class, 'show']);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/collections',                 [CollectionApiController::class, 'store']);
    Route::put('/collections/{collection}',     [CollectionApiController::class, 'update']);
    Route::delete('/collections/{collection}',  [CollectionApiController::class, 'destroy']);
});



Route::get('/brands',         [BrandApiController::class, 'index']);
Route::get('/brands/{brand}', [BrandApiController::class, 'show']);


Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::post('/brands',              [BrandApiController::class, 'store']);
    Route::put('/brands/{brand}',       [BrandApiController::class, 'update']);
    Route::delete('/brands/{brand}',    [BrandApiController::class, 'destroy']);
});