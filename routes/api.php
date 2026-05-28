<?php
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
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