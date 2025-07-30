<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CertificateController;

// Ruta raíz para probar que la API responde
Route::get('/', function () {
    return response()->json(['message' => 'Laravel API corriendo correctamente']);
});

// Ruta /status para monitoreo o test en Render
Route::get('/status', function () {
    return response()->json(['status' => 'API funcionando correctamente ✅']);
});

// Rutas públicas (sin autenticación)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

// Rutas protegidas por autenticación JWT
Route::middleware('auth.jwt')->group(function () {
    
    // Usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);

    // Solicitudes de certificados por usuarios
    Route::post('/requests', [CertificateRequestController::class, 'store']);
    Route::post('/certificaterequests', [CertificateRequestController::class, 'store']); // redundante pero útil

    Route::get('/my-requests', [CertificateRequestController::class, 'myRequests']);
    Route::get('/certificaterequests', [CertificateRequestController::class, 'myRequests']);

    // Documentos relacionados a solicitudes
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::get('/requests/{id}/documents', [DocumentController::class, 'forRequest']);

    // Certificados emitidos
    Route::post('/generate-certificate/{id}', [CertificateController::class, 'generate']);
    Route::get('/certificates/{id}', [CertificateController::class, 'show']);
    Route::get('/certificates/{id}/download', [CertificateController::class, 'download']);
    Route::get('/certificates/{id}/view', [CertificateController::class, 'view']);
    Route::get('/requests/{id}/certificate/download', [CertificateController::class, 'download']);

    // Panel de administrador
    Route::get('/admin/requests', [CertificateRequestController::class, 'indexAll']); // listar todas
    Route::get('/admin/requests/{id}', [CertificateRequestController::class, 'show']); // ver detalle
    Route::put('/admin/requests/{id}/status', [CertificateRequestController::class, 'updateStatus']);
    Route::put('/admin/requests/{id}/stage', [CertificateRequestController::class, 'updateStage']);

    // Cierre de sesión (JWT)
    Route::post('/logout', function () {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    });
});
