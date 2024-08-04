<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrateurController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profiles', [ProfileController::class, 'create_profile']);
    Route::put('/profiles/{id}', [ProfileController::class, 'update_profile']);
    Route::delete('/profiles/{id}', [ProfileController::class, 'delete_profile']);
    Route::post('logout', [AuthController::class, 'deconnexion']);
});

Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/admins', [AdministrateurController::class, 'index']);

Route::post('register', [AdministrateurController::class, 'inscription']);
Route::post('login', [AdministrateurController::class, 'connexion']);
