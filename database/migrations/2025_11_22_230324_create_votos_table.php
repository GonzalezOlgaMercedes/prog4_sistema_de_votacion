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
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');//qué usuario votó
            $table->unsignedBigInteger('votacion_id');//en qué votación votó
            $table->unsignedBigInteger('opcion_id');//qué opción eligió

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('votacion_id')->references('id')->on('votacions')->onDelete('cascade');
            $table->foreign('opcion_id')->references('id')->on('opcions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};
