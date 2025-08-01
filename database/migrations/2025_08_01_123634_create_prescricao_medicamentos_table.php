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
        Schema::create('prescricao_medicamentos', function (Blueprint $table) {
            $table->id();

            // Coluna da chave estrangeira
            $table->unsignedBigInteger('prescricao_id');

            // DEFINIÇÃO MANUAL E EXPLÍCITA DA CHAVE ESTRANGEIRA
            // "Esta coluna ('prescricao_id') refere-se à coluna 'id' na tabela 'prescricoes'."
            $table->foreign('prescricao_id')->references('id')->on('prescricoes')->onDelete('cascade');

            $table->string('nome_medicamento');
            $table->string('dosagem');
            $table->text('posologia');
            $table->string('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescricao_medicamentos');
    }
};