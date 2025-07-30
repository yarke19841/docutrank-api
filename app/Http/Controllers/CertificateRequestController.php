<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CertificateRequest;
    // ADMIN: Cambiar etapa de una solicitud
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Certificate;

class CertificateRequestController extends Controller
{
    // Crear nueva solicitud
    public function store(Request $request)
    {
        $request->validate([
            'certificate_type' => 'required|string',
            'full_name' => 'required|string',
            'document_number' => 'required|string',
            'document' => 'required|file|mimes:pdf',
        ]);

        // Guardar el archivo PDF
        $path = $request->file('document')->store('certificates', 'public');

        // Crear la solicitud
        $certificateRequest = CertificateRequest::create([
            'user_id' => auth()->id(),
            'certificate_type' => $request->certificate_type,
            'full_name' => $request->full_name,
            'document_number' => $request->document_number,
            'document_path' => $path,
            'status' => 'Pendiente',
            'stage' => 'Recibido',
        ]);

        return response()->json([
            'message' => 'Solicitud creada correctamente',
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


public function updateStage(Request $request, $id)
{
    $this->authorizeAdmin();

    $request->validate([
        'stage' => 'required|string|in:En Validación,Emitido',
    ]);

    $certRequest = CertificateRequest::findOrFail($id);
    $certRequest->stage = $request->stage;
    $certRequest->save();

    // Si la etapa es "Emitido" y aún no hay certificado, lo genera
    if ($request->stage === 'Emitido' && !$certRequest->certificate) {
        $certificateNumber = 'CERT-' . strtoupper(uniqid());
        $issuedAt = now();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', [
            'type' => $certRequest->certificate_type,
            'full_name' => $certRequest->full_name,
            'document_number' => $certRequest->document_number,
            'issued_at' => $issuedAt->format('Y-m-d'),
        ]);

        $fileName = $certificateNumber . '.pdf';
        $filePath = 'certificates/' . $fileName;
        \Storage::disk('public')->put($filePath, $pdf->output());

        Certificate::create([
            'certificate_request_id' => $certRequest->id,
            'certificate_number' => $certificateNumber,
            'issued_at' => $issuedAt,
            'file_path' => $filePath,
        ]);
    }

    return response()->json([
        'message' => 'Etapa actualizada correctamente.',
        'data' => $certRequest->load('certificate'),
    ]);
}


// Verificar si el usuario es administrador
protected function authorizeAdmin()
{
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'No autorizado');
    }
}


}
