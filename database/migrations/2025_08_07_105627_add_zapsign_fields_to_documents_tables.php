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
        Schema::table('prescricoes', function (Blueprint $table) {
            $table->string('zapsign_token')->nullable();
        });

        Schema::table('atestados', function (Blueprint $table) {
            $table->string('zapsign_token')->nullable();
        });

        Schema::table('laudos', function (Blueprint $table) {
            $table->string('zapsign_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescricoes', function (Blueprint $table) {
            $table->dropColumn(['zapsign_token']);
        });

        Schema::table('atestados', function (Blueprint $table) {
            $table->dropColumn(['zapsign_token']);
        });

        Schema::table('laudos', function (Blueprint $table) {
            $table->dropColumn(['zapsign_token']);
        });
    }
};