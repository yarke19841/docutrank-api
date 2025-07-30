<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CertificateController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

// Rutas protegidas por autenticación
Route::middleware('auth.jwt')->group(function () {

    // Usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);

    // Usuario Ciudadano - Solicitudes
    Route::post('/requests', [CertificateRequestController::class, 'store']); // alternativo
    Route::post('/certificaterequests', [CertificateRequestController::class, 'store']);
    Route::get('/my-requests', [CertificateRequestController::class, 'myRequests']);
    Route::get('/certificaterequests', [CertificateRequestController::class, 'myRequests']);

    // Usuario Ciudadano - Documentos
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::get('/requests/{id}/documents', [DocumentController::class, 'forRequest']);

    // Certificados (generar, ver, descargar)
    Route::post('/generate-certificate/{id}', [CertificateController::class, 'generate']);
    Route::get('/certificates/{id}', [CertificateController::class, 'show']);
    Route::get('/certificates/{id}/download', [CertificateController::class, 'download']);
    Route::get('/certificates/{id}/view', [CertificateController::class, 'view']);
    Route::get('/requests/{id}/certificate/download', [CertificateController::class, 'download']);
Route::get('/certificates/{id}/download', [CertificateController::class, 'download']);

    // ADMIN - Panel de control
    Route::get('/admin/requests', [CertificateRequestController::class, 'indexAll']);           // Lista todas
    Route::get('/admin/requests/{id}', [CertificateRequestController::class, 'show']);          // Ver detalle
    Route::put('/admin/requests/{id}/status', [CertificateRequestController::class, 'updateStatus']); // Cambiar estado
    Route::put('/admin/requests/{id}/status', [CertificateRequestController::class, 'updateStatus']);
    Route::put('/admin/requests/{id}/stage', [CertificateRequestController::class, 'updateStage']);
    Route::post('/logout', function () {
    auth()->logout(); // solo funciona con JWT
    return response()->json(['message' => 'Sesión cerrada correctamente']);
});


});
