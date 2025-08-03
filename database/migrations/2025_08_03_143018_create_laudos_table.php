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
        Schema::create('laudos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('users');
            $table->foreignId('paciente_id')->constrained('users');
            $table->string('titulo'); // Ex: "Laudo de Exame de Imagem", "Relatório de Consulta"
            $table->text('conteudo'); // O corpo do laudo
            $table->date('data_emissao');
            $table->string('hash_validacao')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laudos');
    }
};
