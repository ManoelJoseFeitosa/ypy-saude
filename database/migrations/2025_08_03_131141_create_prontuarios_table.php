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
            Schema::create('prontuarios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('paciente_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');
                
                $table->date('data_atendimento');
                $table->text('anotacao'); // Onde o médico escreverá a evolução, queixa, etc.
                
                // Coluna "polimórfica" para ligar a outros documentos (opcional, mas muito poderosa)
                $table->nullableMorphs('relacionado'); // Ex: pode ligar a uma Prescricao ou Atestado

                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('prontuarios');
        }
    };
    