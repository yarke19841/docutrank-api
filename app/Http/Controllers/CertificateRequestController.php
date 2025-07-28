<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CertificateRequest;

class CertificateRequestController extends Controller
{
    // Crear nueva solicitud
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'certificate_type' => 'required|string|in:Nacimiento,Matrimonio,Defunción',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'El tipo de certificado es inválido',
                'errors' => $validator->errors(),
            ], 422);
        }

        $certificateRequest = CertificateRequest::create([
            'user_id' => Auth::id(),
            'certificate_type' => $request->certificate_type,
            'status' => 'Recibido',
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'data' => $certificateRequest,
        ], 201);
    }

    // Mostrar las solicitudes del usuario autenticado
    public function myRequests()
{
    $requests = CertificateRequest::with('certificate')
        ->where('user_id', Auth::id())
        ->get();

    return response()->json([
        'data' => $requests,
    ]);
}

}
