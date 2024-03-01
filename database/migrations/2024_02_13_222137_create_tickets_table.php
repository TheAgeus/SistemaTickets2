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
        $mytime = Carbon\Carbon::now();

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string("titulo")->unique();
            $table->string("descripcion");
            $table->string("prioridad");
            $table->string("estado")->default("PENDIENTE");
            $table->timestamp('tiempo_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('tiempo_inicio')->nullable();
            $table->timestamp('tiempo_final')->nullable();
            $table->string('como_fue_servicio')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('cliente_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
