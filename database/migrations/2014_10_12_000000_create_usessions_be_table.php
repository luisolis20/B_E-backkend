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
        
        Schema::create('be_sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->references('id')->on('be_users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ip_address',45)->unique();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('be_sessions');
    }
};
