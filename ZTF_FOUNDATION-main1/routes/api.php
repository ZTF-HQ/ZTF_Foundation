<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

Route::middleware('api')->group(function () {
// Route publique pour getAllUsers
    Route::get('v1/getAllUsers', [AuthController::class, 'getAllUsers']);

});

// Routes d'authentification
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

// Routes protégées
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserApiController::class)->except(['create', 'store']);
    
    // Route pour les statistiques du staff
    Route::get('staff/statistics', 'App\Http\Controllers\StatistiqueController@apiStats');
});
