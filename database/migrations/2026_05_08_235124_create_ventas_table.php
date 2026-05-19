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
    Schema::create('ventas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cultivo_id')->constrained('cultivos');
        $table->foreignId('lote_id')->constrained('lotes');
        $table->integer('cantidad_vendida');
        $table->decimal('precio_unitario', 10, 2);
        $table->decimal('total', 12, 2);
        $table->date('fecha_venta');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
