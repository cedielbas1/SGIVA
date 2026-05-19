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
    Schema::create('inventarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
        $table->integer('fila');
        $table->integer('cantidad_actual');
        $table->integer('cantidad_inicial');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
