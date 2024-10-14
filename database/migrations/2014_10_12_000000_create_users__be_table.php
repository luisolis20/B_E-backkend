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
        Schema::create('users_be', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string('firts_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('rol');
            $table->string('link')->nullable();
            $table->string('telefono');
            $table->string('direccion');
            $table->integer("estado")->nullable();
            $table->binary('imagen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_be');
    }
};
