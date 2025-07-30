<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_request_id',
        'certificate_number',
        'issued_at',
        'file_path',
    ];

    protected $dates = [
        'issued_at',
    ];

    // 👇 Esto es lo que le faltaba
    protected $appends = ['file_url'];

    /**
     * Relación: este certificado pertenece a una solicitud
     */
    public function request()
    {
        return $this->belongsTo(CertificateRequest::class, 'certificate_request_id');
    }

    /**
     * Accesorio para obtener la URL completa del archivo
     */
    public function getFileUrlAttribute()
{
    return asset('storage/' . $this->file_path);
}
    
}
