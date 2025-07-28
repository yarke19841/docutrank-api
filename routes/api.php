<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\DocumentController;

use App\Http\Controllers\CertificateController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/requests', [CertificateRequestController::class, 'store']);
    Route::get('/my-requests', [CertificateRequestController::class, 'myRequests']);
Route::post('/documents', [DocumentController::class, 'store']);
Route::post('/generate-certificate/{id}', [CertificateController::class, 'generate']);
Route::get('/certificates/{id}', [CertificateController::class, 'show']);
Route::get('/certificates/{id}/download', [CertificateController::class, 'download']);
Route::post('/documents', [DocumentController::class, 'store']);
Route::get('/requests/{id}/documents', [DocumentController::class, 'forRequest']);
Route::get('/requests/{id}/certificate/download', [CertificateController::class, 'download']);
Route::get('/certificates/{id}/view', [CertificateController::class, 'view']);

});

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});


