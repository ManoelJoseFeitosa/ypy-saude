<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class ImportarMedicamentosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importar:medicamentos {caminho?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa medicamentos de um ficheiro CSV para a base de dados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('A iniciar a importação de medicamentos...');

        // Define o caminho padrão se nenhum for fornecido
        $caminho = $this->argument('caminho') ?? database_path('data/medicamentos.csv');

        if (!file_exists($caminho)) {
            $this->error('Erro: O ficheiro não foi encontrado em ' . $caminho);
            $this->warn('Certifique-se de que o ficheiro CSV está no local correto (ex: database/data/medicamentos.csv)');
            return 1; // Retorna um código de erro
        }

        // Limpa a tabela antes de importar para evitar duplicados
        DB::table('medicamentos')->truncate();
        $this->warn('Tabela de medicamentos limpa.');

        // Usa LazyCollection para processar o ficheiro grande sem esgotar a memória
        LazyCollection::make(function () use ($caminho) {
            $handle = fopen($caminho, 'r');
            while (($line = fgetcsv($handle, 4096, ';')) !== false) {
                yield $line;
            }
            fclose($handle);
        })
        ->skip(1) // Pula a primeira linha (cabeçalho) do CSV
        ->chunk(1000) // Processa os dados em lotes de 1000 linhas
        ->each(function (LazyCollection $chunk) {
            $registos = $chunk->map(function ($linha) {
                // VERIFIQUE A COLUNA CORRETA: O nome do produto está na coluna B, que é o índice [1]
                // (coluna A é [0], B é [1], etc.)
                $nomeProduto = $linha[1] ?? null;

                if ($nomeProduto) {
                    // Tenta converter a codificação de caracteres para UTF-8
                    return ['nome' => mb_convert_encoding($nomeProduto, 'UTF-8', 'ISO-8859-1')];
                }
                return null;
            })
            ->filter() // Remove quaisquer valores nulos
            ->unique('nome') // Garante que estamos a inserir apenas nomes únicos neste lote
            ->toArray();

            if (!empty($registos)) {
                DB::table('medicamentos')->insert($registos);
            }
        });

        $this->info('Importação de medicamentos concluída com sucesso!');
        return 0; // Retorna um código de sucesso
    }
}
