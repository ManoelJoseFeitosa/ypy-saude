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
        Schema::table('medico_profiles', function (Blueprint $table) {
            $table->string('rqe')->nullable()->after('especialidade');
            $table->string('endereco_completo')->nullable()->after('rqe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medico_profiles', function (Blueprint $table) {
            //
        });
    }
};
