<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:certificate_requests,id',
            'file' => 'required|file|max:5120', // Máx 5MB
        ]);

        $path = $request->file('file')->store('documents', 'public');

        $fileType = $request->file('file')->getClientMimeType();

        $document = Document::create([
            'request_id' => $request->request_id,
            'file_path'  => $path,
            'file_type'  => $fileType,
        ]);

        return response()->json([
            'message' => 'Documento subido correctamente',
            'data'    => $document,
        ], 201);
    }
}
