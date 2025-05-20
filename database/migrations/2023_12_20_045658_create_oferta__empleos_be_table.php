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
        Schema::create('be_oferta__empleos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->longtext('descripcion');
            $table->longtext('requisistos');
            $table->string('jornada');
            $table->string('tipo_contrato');
            $table->string('modalidad');
            $table->string('categoria');
            $table->unsignedBigInteger('id_empresa');
            $table->foreign('id_empresa')->references('idempresa')->on('praempresa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('be_oferta__empleos');
    }
};
