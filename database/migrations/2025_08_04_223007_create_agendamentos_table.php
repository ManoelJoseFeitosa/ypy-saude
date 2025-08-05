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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_fim');
            $table->enum('status', ['agendado', 'confirmado', 'cancelado', 'realizado'])->default('agendado');
            $table->enum('tipo', ['presencial', 'teleconsulta'])->default('teleconsulta');
            $table->string('link_teleconsulta')->nullable(); // Para guardar o link da sala virtual
            $table->text('notas_paciente')->nullable(); // Notas que o paciente pode adicionar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
