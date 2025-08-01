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
    Schema::create('medico_profiles', function (Blueprint $table) {
        $table->id();
        
        // Esta é a linha que liga o perfil ao usuário.
        // Se um usuário for deletado, seu perfil também será (onDelete).
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('crm');
        $table->string('uf_crm', 2); // Apenas 2 caracteres para a sigla do estado (ex: PI)
        $table->string('especialidade')->nullable(); // O campo especialidade é opcional

        $table->timestamps(); // Cria as colunas created_at e updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medico_profiles');
    }
};
