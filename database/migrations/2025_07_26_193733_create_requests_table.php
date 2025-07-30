<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('certificate_type');

            $table->enum('status', [
                'Pendiente',
                'Aprobado',
                'Rechazado',
                'Corrección Solicitada'
            ])->default('Pendiente'); // ✅ Corregido

            $table->enum('stage', [
                'Recibido',
                'En Validación',
                'Emitido'
            ])->default('Recibido'); // ✅ Campo separado para la etapa

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};
