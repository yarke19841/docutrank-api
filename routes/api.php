<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateRequestController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/requests', [CertificateRequestController::class, 'store']);
    Route::get('/my-requests', [CertificateRequestController::class, 'myRequests']);
});

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});


