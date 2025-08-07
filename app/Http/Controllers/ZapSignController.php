<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
// Importe aqui os models dos seus documentos, por exemplo:
use App\Models\Prescricao;
use App\Models\Atestado;
use App\Models\Laudo;

class ZapSignController extends Controller
{
    private $apiToken;
    private $apiUrl = 'https://api.zapsign.com.br/api/v1';

    public function __construct()
    {
        // Pega o token do seu arquivo config/services.php
        $this->apiToken = config('services.zapsign.token');
    }

    /**
     * Envia um documento para assinatura na ZapSign.
     * Este método é mais robusto, criando o documento e depois adicionando o assinante.
     *
     * @param string $documentPath - Caminho do arquivo no storage (ex: 'prescricoes/prescricao-123.pdf')
     * @param object $signer - O objeto do usuário (médico) que vai assinar
     * @param object $documentModel - O objeto do documento (ex: Prescricao) para salvar o token
     * @return string|null - Retorna a URL de assinatura ou nulo em caso de erro.
     */
    public function sendDocumentForSignature($documentPath, $signer, $documentModel)
    {
        if (!$this->apiToken) {
            Log::error('Token da API ZapSign não configurado.');
            return null;
        }

        try {
            $fileContent = Storage::get($documentPath);
            
            // 1. Cria o documento na ZapSign
            $response = Http::withQueryParameters(['api_token' => $this->apiToken])
                ->attach('file', $fileContent, basename($documentPath))
                ->post("{$this->apiUrl}/docs/");

            if (!$response->successful()) {
                Log::error('Falha ao enviar documento para ZapSign:', $response->json());
                return null;
            }

            $docToken = $response->json()['token'];

            // 2. Adiciona o médico como assinante do documento recém-criado
            $signerResponse = Http::withQueryParameters(['api_token' => $this->apiToken])
                ->post("{$this->apiUrl}/docs/{$docToken}/add-signer/", [
                    'email' => $signer->email,
                    'name' => $signer->name,
                    'auth_mode' => 'certinCloud', // Exige assinatura com Certificado Digital em Nuvem
                    'redirect_url' => route('medico.dashboard'), // Para onde o médico volta após assinar
                    'webhook_url' => route('zapsign.webhook'), // Onde a ZapSign nos notifica
                ]);

            if (!$signerResponse->successful()) {
                Log::error('Falha ao adicionar assinante na ZapSign:', $signerResponse->json());
                return null;
            }

            // 3. Salva o token da ZapSign no nosso banco de dados, associado ao documento
            // Adicione uma coluna 'zapsign_token' (string, nullable) nas suas tabelas de documentos
            $documentModel->zapsign_token = $docToken;
            $documentModel->save();

            // 4. Retorna a URL de assinatura para o médico
            return $signerResponse->json()['sign_url'];

        } catch (\Exception $e) {
            Log::error('Exceção ao integrar com ZapSign: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * ---- MÉTODO WEBHOOK IMPLEMENTADO ----
     * Recebe a notificação da ZapSign quando um evento ocorre (ex: documento assinado).
     */
    public function webhook(Request $request)
    {
        // É uma boa prática registrar toda a notificação para depuração
        Log::info('Webhook da ZapSign recebido:', $request->all());

        $docToken = $request->input('token');
        $eventType = $request->input('event');

        // Verifica se o evento é de um documento completamente assinado
        if ($eventType === 'doc_signed' && $docToken) {
            
            // Tenta encontrar o documento em qualquer um dos seus models
            // Isso requer que você adicione a coluna 'zapsign_token' em cada uma das tabelas
            $prescricao = Prescricao::where('zapsign_token', $docToken)->first();
            $atestado = Atestado::where('zapsign_token', $docToken)->first();
            $laudo = Laudo::where('zapsign_token', $docToken)->first();

            $document = $prescricao ?? $atestado ?? $laudo;

            if ($document) {
                // Adicione uma coluna 'status' nas suas tabelas de documentos
                $document->status = 'assinado';
                $document->save();
                Log::info("Documento (Token: {$docToken}) marcado como assinado com sucesso.");
            } else {
                Log::warning("Webhook da ZapSign: Documento com token {$docToken} não encontrado no banco de dados.");
            }
        }

        // Responde ao ZapSign com status 200 OK para confirmar o recebimento
        return response()->json(['message' => 'Webhook recebido.'], 200);
    }

    /**
 * Rota de teste para verificar a conexão e o token da API ZapSign.
 */
public function testConnection()
{
    // Verifica se o token foi carregado do .env
    if (!$this->apiToken) {
        return "Erro: O ZAPSIGN_TOKEN não está configurado no seu arquivo .env ou a cache de configuração não foi limpa.";
    }

    try {
        // Tenta fazer uma chamada simples para a API
        $response = Http::withQueryParameters(['api_token' => $this->apiToken])
            ->get("{$this->apiUrl}/organizations/");

        if ($response->successful()) {
            // Se a conexão for bem-sucedida, mostra uma mensagem de sucesso e os dados recebidos
            echo "<h1>Conexão com a ZapSign bem-sucedida!</h1>";
            echo "<p>O token da API é válido.</p>";
            echo "<pre>";
            print_r($response->json());
            echo "</pre>";
        } else {
            // Se falhar, mostra o código do erro e a mensagem
            echo "<h1>Falha na conexão com a ZapSign!</h1>";
            echo "<p>Código do Erro: " . $response->status() . "</p>";
            echo "<p>Verifique se o seu token de API está correto e se o seu plano permite acesso à API.</p>";
            echo "<pre>";
            print_r($response->json());
            echo "</pre>";
        }

    } catch (\Exception $e) {
        // Se ocorrer um erro de conexão (como o timeout que vimos antes)
        return "<h1>Erro de Conexão!</h1> <p>Não foi possível conectar ao servidor da ZapSign. Verifique os logs do servidor para mais detalhes. Erro: " . $e->getMessage() . "</p>";
    }
}
}