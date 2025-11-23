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
        Schema::create('votacions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');//Titulo de la votación
            $table->string('estado')->default('cerrada');//Estado de la votación (abierta/cerrada)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votacions');
    }
};
