<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    $fakeContent = "CERTIFICADO DE " . strtoupper($certRequest->certificate_type) . "\n\nNombre: " . $user->name;
    $path = 'certificates/certificate_' . Str::uuid() . '.txt';
    Storage::disk('public')->put($path, $fakeContent);

    $certificate = Certificate::create([
        'certificate_request_id' => $id,
        'certificate_number'     => 'CERT-' . uniqid(),
        'issued_at'              => now(),
        'file_path'              => $path,
    ]);

    return response()->json([
    'message'     => 'Certificado generado',
    'certificate' => [
        'id' => $certificate->id,
        'certificate_number' => $certificate->certificate_number,
        'issued_at' => $certificate->issued_at,
        'url' => $certificate->file_url
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

    return response()->json([
        'certificate' => $certRequest->certificate
    ]);
}

public function download($id)
{
    $user = auth()->user();

    $certRequest = CertificateRequest::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();

    if (!$certRequest || !$certRequest->certificate) {
        return response()->json(['error' => 'Certificado no encontrado'], 404);
    }

    $path = $certRequest->certificate->file_path;

    if (!\Storage::disk('public')->exists($path)) {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }

    return response()->download(storage_path('app/public/' . $path));
}

}
