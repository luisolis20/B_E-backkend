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
        Schema::create('praempresa', function (Blueprint $table) {
            $table->id('idempresa');
            $table->string('ruc', 20)->nullable();
            $table->string('empresacorta', 250)->nullable();
            $table->string('empresa', 400)->nullable();
            $table->string('pais')->nullable();
            $table->string('lugar', 45)->nullable();
            $table->longtext('vision')->nullable();
            $table->longtext('mision')->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('url', 105)->nullable();
            $table->string('logo', 45)->nullable();
            $table->string('tipo', 255)->nullable();
            $table->string('titulo', 65)->nullable();
            $table->string('representante', 245)->nullable();
            $table->string('cargo', 85)->nullable();
            $table->string('actividad', 245)->nullable();
            $table->dateTime('fechafin')->nullable();
            $table->string('tipoinstitucion', 65)->nullable()->default('OTRO');
            $table->binary('imagen')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('be_users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praempresa');
    }
};
