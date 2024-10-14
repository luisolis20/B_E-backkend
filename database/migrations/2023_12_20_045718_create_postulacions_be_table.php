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
        Schema::create('postulacions_be', function (Blueprint $table) {
            $table->id();
            $table->string('CIInfPer');
            $table->foreign('CIInfPer')->references('CIInfPer')->on('informacionpersonal')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('oferta_id');
            $table->foreign('oferta_id')->references('id')->on('oferta__empleos_be')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulacions_be');
    }
};
