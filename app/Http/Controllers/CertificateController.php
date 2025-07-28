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

        // Simular archivo PDF generado (en blanco o simple)
        $fakeContent = "CERTIFICADO DE " . strtoupper($certRequest->certificate_type) . "\n\nNombre: " . $user->name;
        $path = 'certificates/certificate_' . Str::uuid() . '.txt';
        Storage::disk('public')->put($path, $fakeContent);

        $certificate = Certificate::create([
            'request_id'         => $certRequest->id,
            'certificate_number' => strtoupper(Str::random(10)),
            'issued_at'          => now(),
            'file_path'          => $path,
        ]);

        return response()->json([
            'message'     => 'Certificado generado',
            'certificate' => $certificate
        ]);
    }
}
