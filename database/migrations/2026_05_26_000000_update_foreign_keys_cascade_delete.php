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
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropForeign(['lote_id']);
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
        });

        Schema::table('insumos', function (Blueprint $table) {
            $table->dropForeign(['cultivo_id']);
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['cultivo_id']);
            $table->dropForeign(['lote_id']);
            $table->foreign('cultivo_id')->references('id')->on('cultivos')->onDelete('cascade');
            $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividades', function (Blueprint $table) {
            $table->dropForeign(['lote_id']);
            $table->foreign('lote_id')->references('id')->on('lotes');
        });

        Schema::table('insumos', function (Blueprint $table) {
            $table->dropForeign(['cultivo_id']);
            $table->foreign('cultivo_id')->references('id')->on('cultivos');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign(['cultivo_id']);
            $table->dropForeign(['lote_id']);
            $table->foreign('cultivo_id')->references('id')->on('cultivos');
            $table->foreign('lote_id')->references('id')->on('lotes');
        });
    }
};
