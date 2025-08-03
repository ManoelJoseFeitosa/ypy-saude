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
    Schema::create('atestados', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medico_id')->constrained('users');
        $table->foreignId('paciente_id')->constrained('users');
        $table->text('motivo'); // Motivo do atestado
        $table->string('cid')->nullable(); // CID (opcional)
        $table->integer('dias_afastamento'); // Número de dias
        $table->date('data_emissao');
        $table->string('hash_validacao')->unique(); // Código único para validação
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atestados');
    }
};
