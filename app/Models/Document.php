<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'file_path',
        'file_type',
    ];

    public function request()
    {
        return $this->belongsTo(CertificateRequest::class, 'request_id');
    }
}
