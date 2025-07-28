<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('certificate_requests')->onDelete('cascade');
            $table->string('file_path'); // Ruta del archivo guardado
            $table->string('file_type'); // Ej: pdf, jpg, png
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
