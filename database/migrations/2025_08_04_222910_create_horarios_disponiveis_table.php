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
        Schema::create('horarios_disponiveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');
            $table->integer('dia_semana'); // 0 = Domingo, 1 = Segunda, ..., 6 = Sábado
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->integer('duracao_consulta')->default(30); // Duração da consulta em minutos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_disponiveis');
    }
};
