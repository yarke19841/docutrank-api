<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    DB::statement("ALTER TABLE certificate_requests DROP CONSTRAINT certificate_requests_stage_check");

    DB::statement("ALTER TABLE certificate_requests ADD CONSTRAINT certificate_requests_stage_check 
        CHECK (stage IN ('Recibido', 'En Validación', 'Emitido'))");
}

public function down()
{
    DB::statement("ALTER TABLE certificate_requests DROP CONSTRAINT certificate_requests_stage_check");

    DB::statement("ALTER TABLE certificate_requests ADD CONSTRAINT certificate_requests_stage_check 
        CHECK (stage IN ('Recibido', 'En Validación'))");
}

};
