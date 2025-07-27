<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CertificateRequest;

class CertificateRequestController extends Controller
{
    // Crear nueva solicitud
    public function store(Request $request)
    {
        $request->validate([
            'certificate_type' => 'required|string|max:255',
        ]);

        $certificateRequest = CertificateRequest::create([
            'user_id' => Auth::id(),
            'certificate_type' => $request->certificate_type,
            'status' => 'Recibido',
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'data' => $certificateRequest
        ], 201);
    }

    // Mostrar las solicitudes del usuario autenticado
    public function myRequests()
    {
        $requests = CertificateRequest::where('user_id', Auth::id())->get();

        return response()->json([
            'data' => $requests
        ]);
    }
}
