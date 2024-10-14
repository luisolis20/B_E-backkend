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
        Schema::create('estado_postulaciones_be', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('postulacion_id');
            $table->foreign('postulacion_id')->references('id')->on('postulacions_be')->onDelete('cascade')->onUpdate('cascade');
            $table->string('estado')->default('pendiente'); // 'aceptado', 'rechazado', 'pendiente'
            $table->dateTime('fecha')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_postulaciones_be');
    }
};
