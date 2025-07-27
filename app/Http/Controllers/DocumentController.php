<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:certificate_requests,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'request_id' => $request->request_id,
            'file_path' => $path,
            'file_type' => $request->file->getClientOriginalExtension(),
        ]);

        return response()->json([
            'message' => 'Documento subido correctamente',
            'data' => $document
        ], 201);
    }
}
