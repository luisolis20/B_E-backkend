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
        Schema::create('oferta__empleos_be', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->longtext('descripcion');
            $table->longtext('requisistos');
            $table->string('jornada');
            $table->string('tipo_contrato');
            $table->string('modalidad');
            $table->string('categoria');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas_be')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta__empleos_be');
    }
};
