<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificateRequest;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'filename',
        'filepath',
        'filetype',
    ];

    public function request()
{
    return $this->belongsTo(CertificateRequest::class);
}

}
