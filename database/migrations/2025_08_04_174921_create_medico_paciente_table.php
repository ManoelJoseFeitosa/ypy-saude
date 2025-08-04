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
            Schema::create('medico_paciente', function (Blueprint $table) {
                // Chave primária composta para garantir que um vínculo não se repita
                $table->primary(['medico_id', 'paciente_id']);

                // Chave estrangeira para o médico
                $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');

                // Chave estrangeira para o paciente
                $table->foreignId('paciente_id')->constrained('users')->onDelete('cascade');

                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('medico_paciente');
        }
    };
    