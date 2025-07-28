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
            'full_name'        => 'required|string|max:255',
            'document_number'  => 'required|string|max:50',
            'document'         => 'required|file|mimes:pdf'
        ], [
            'document.mimes' => 'El archivo debe ser un documento PDF.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Guardar archivo
        $path = $request->file('document')->store('certificates', 'public');

        // Crear la solicitud
        $certificateRequest = CertificateRequest::create([
            'user_id'          => Auth::id(),
            'certificate_type' => $request->certificate_type,
            'full_name'        => $request->full_name,
            'document_number'  => $request->document_number,
            'document_path'    => $path,
            'status'           => 'Recibido',
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'data'    => $certificateRequest,
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

    // ADMIN: Listar todas las solicitudes
    public function indexAll()
    {
        $this->authorizeAdmin();

        $requests = CertificateRequest::with('user', 'certificate')->latest()->get();

        return response()->json([
            'data' => $requests,
        ]);
    }

    // ADMIN: Ver detalle de una solicitud
    public function show($id)
    {
        $request = CertificateRequest::with('user', 'certificate')->findOrFail($id);

        return response()->json([
            'data' => $request,
        ]);
    }

    // ADMIN: Cambiar estado de una solicitud
    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => 'required|string|in:Aprobado,Rechazado,Corrección Solicitada',
        ]);

        $certRequest = CertificateRequest::findOrFail($id);
        $certRequest->status = $request->status;
        $certRequest->save();

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'data'    => $certRequest,
        ]);
    }

    // Validar si el usuario autenticado es administrador
    protected function authorizeAdmin()
    {
       if (!Auth::check() || !Auth::user()->isAdmin()) {
    abort(403, 'No autorizado');
}

    }
}
