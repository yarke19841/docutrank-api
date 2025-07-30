<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function generate(Request $request, $id)
    {
        $user = auth()->user();

        $certRequest = CertificateRequest::where('id', $id)
                        ->where('user_id', $user->id)
                        ->first();

        if (!$certRequest) {
            return response()->json(['error' => 'Solicitud no encontrada'], 404);
        }

        if ($certRequest->certificate) {
            return response()->json(['error' => 'Certificado ya generado'], 400);
        }

        $pdf = Pdf::loadView('certificates.pdf', [
            'type' => $certRequest->certificate_type,
            'name' => $user->name,
            'date' => now()->format('d/m/Y')
        ]);

        $fileName = 'certificates/' . 'CERT_' . Str::uuid() . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        $certificate = Certificate::create([
            'certificate_request_id' => $id,
            'certificate_number'     => 'CERT-' . strtoupper(Str::random(8)),
            'issued_at'              => now(),
            'file_path'              => $fileName,
        ]);

        return response()->json([
            'message' => 'Certificado generado',
            'certificate' => [
                'id' => $certificate->id,
                'certificate_number' => $certificate->certificate_number,
                'issued_at' => $certificate->issued_at,
                'file_path' => $certificate->file_path // ✅ corregido aquí
            ]
        ]);
    }

   public function show($id)
{
    $user = auth()->user();

    $certRequest = CertificateRequest::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();

    if (!$certRequest || !$certRequest->certificate) {
        return response()->json(['error' => 'Certificado no encontrado'], 404);
    }

    $certificate = $certRequest->certificate->load('request');

    return response()->json([
        'certificate' => [
            'id' => $certificate->id,
            'certificate_number' => $certificate->certificate_number,
            'file_path' => $certificate->file_path,
            'stage' => $certificate->request->stage, // solo si lo necesitas
        ]
    ]);
}


    public function download($id)
    {
        $user = auth()->user();

        $certificate = Certificate::where('id', $id)
            ->whereHas('request', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->first();

        if (!$certificate) {
            return response()->json(['error' => 'Certificado no encontrado'], 404);
        }

        if (!Storage::disk('public')->exists($certificate->file_path)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->download(storage_path('app/public/' . $certificate->file_path));
    }

    public function view($id)
    {
        $user = auth()->user();

        $certificate = Certificate::where('id', $id)
            ->whereHas('request', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if (!$certificate || !Storage::disk('public')->exists($certificate->file_path)) {
            return response()->json(['error' => 'Certificado no encontrado'], 404);
        }

        $mimeType = Storage::disk('public')->mimeType($certificate->file_path);
        $content = Storage::disk('public')->get($certificate->file_path);

        return response($content, 200)->header('Content-Type', $mimeType);
    }
}
