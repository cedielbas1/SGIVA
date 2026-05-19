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
    Schema::create('lotes', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique(); // Identificador único del lote
        $table->foreignId('cultivo_id')->constrained('cultivos')->onDelete('cascade');
        $table->integer('cantidad_filas');
        $table->string('estado')->default('Disponible');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};
