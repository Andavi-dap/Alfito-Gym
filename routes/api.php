<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::get('/me', [ApiController::class, 'members']);
    Route::get('/trainers', [ApiController::class, 'trainers']);
    Route::get('/programs', [ApiController::class, 'programs']);
    Route::get('/plans', [ApiController::class, 'plans']);
    Route::get('/applications', [ApiController::class, 'applications']);
    Route::post('/applications', [ApiController::class, 'storeApplication']);
    Route::get('/bookings', [ApiController::class, 'bookings']);
    Route::post('/bookings', [ApiController::class, 'storeBooking']);
    Route::delete('/bookings/{booking}', [ApiController::class, 'destroyBooking']);
});
