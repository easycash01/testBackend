<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    // Register route removed as requested
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

// Rotte protette per rep_it
Route::group([
    'middleware' => ['api', 'auth:api', 'role:rep_it'],
    'prefix' => 'rep_it'
], function ($router) {
    Route::get('/dashboard', function() {
        return response()->json(['message' => 'Loggato dal rep_it']);
    });
    // Altre rotte specifiche per rep_it
});

// Rotte protette per dipendenti
Route::group([
    'middleware' => ['api', 'auth:api', 'role:dipendente'],
    'prefix' => 'dipendente'
], function ($router) {
    Route::get('/dashboard', function() {
        return response()->json(['message' => 'Loggato da dipendente']);
    });
    // Altre rotte specifiche per dipendenti
});

// Rotte comuni per utenti autenticati
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Rotte per i ticket accessibili a tutti gli utenti autenticati
Route::middleware('auth:api')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    
    // Rotte accessibili solo agli utenti rep_it
    Route::middleware('role:rep_it')->group(function () {
        Route::put('/tickets/{id}', [TicketController::class, 'updateStatus']);
        ###delete delete delete delete delete
        Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);
    });
});
