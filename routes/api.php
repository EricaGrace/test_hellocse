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

Route::post('register', [AdministrateurController::class, 'inscription']);
Route::post('login', [AdministrateurController::class, 'connexion']);

Route::middleware('auth:sanctum')->group(function () { ##routes protégées par authentification à l'aide de sanctum
    Route::post('logout', [AdministrateurController::class, 'deconnexion']);
    Route::post('/profiles', [ProfileController::class, 'store']);
    Route::put('/profiles/{id}', [ProfileController::class, 'update']);
    Route::delete('/profiles/{id}', [ProfileController::class, 'destroy']);
    Route::get('/admins', [AdministrateurController::class, 'index']);
});

Route::get('/profiles', [ProfileController::class, 'index']);

