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
        Schema::create('movimentacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade_movimentada');
            $table->char('tipo_movimentacao');
            $table->integer('estoque_antes');
            $table->decimal('valor_custo', 9, 2)->nullable();
            $table->integer('estoque_apos');
            $table->unsignedBigInteger('os_id')->nullable();
            $table->unsignedBigInteger('venda_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacaos');
    }
};
