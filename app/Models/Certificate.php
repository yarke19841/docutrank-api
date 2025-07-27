<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificateRequest;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'pdf_path',
        'generated_at',
    ];

    public function request()
{
    return $this->belongsTo(CertificateRequest::class);
}

}
