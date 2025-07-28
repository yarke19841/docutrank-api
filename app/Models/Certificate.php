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

    public function request()
    {
        return $this->belongsTo(CertificateRequest::class, 'certificate_request_id');
    }
}


