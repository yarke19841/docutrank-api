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
            'certificate_request_id' => 'required|exists:certificate_requests,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
            'file_type' => 'required|string|max:255',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'request_id' => $request->certificate_request_id, // Aquí el cambio clave
            'file_path'  => $path,
            'file_type'  => $request->file_type,
        ]);

        return response()->json([
            'message'  => 'Documento subido correctamente',
            'document' => $document
        ]);
    }

    public function forRequest($id)
{
    $userId = auth()->id();

    $documents = \App\Models\Document::whereHas('request', function ($query) use ($userId, $id) {
        $query->where('user_id', $userId)->where('id', $id);
    })->get();

    return response()->json([
        'data' => $documents
    ]);
}

}
