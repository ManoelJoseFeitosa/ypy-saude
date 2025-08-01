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
    // MUDE AQUI PARA 'prescricoes' (com 'e')
    Schema::create('prescricoes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medico_id')->constrained('users');
        $table->foreignId('paciente_id')->constrained('users');
        $table->date('data_prescricao');
        $table->string('status')->default('ativa');
        $table->text('hash_validacao')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescricoes');
    }
};
