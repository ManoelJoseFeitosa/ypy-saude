<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZapSignService
{
    protected $apiToken;
    protected $baseUrl;
    protected $httpClient;

    /**
     * Prepara o serviço com as credenciais da API.
     */
    public function __construct()
    {
        $this->apiToken = config('zapsign.api_token');
        $this->baseUrl = config('zapsign.api_url');

        if (!$this->apiToken) {
            throw new \Exception('O token da API da ZapSign não foi configurado no arquivo .env');
        }

        $this->httpClient = Http::withQueryParameters(['api_token' => $this->apiToken])
                                ->baseUrl($this->baseUrl)
                                ->timeout(30);
    }

    /**
     * Testa a conexão com a API buscando as organizações.
     *
     * @return array|null
     */
    public function testConnection()
    {
        try {
            $response = $this->httpClient->get('organizations');

            if ($response->successful()) {
                return $response->json();
            }

            // Se a resposta não for bem-sucedida, retorna o erro.
            return [
                'error' => true,
                'status_code' => $response->status(),
                'body' => $response->json() ?? $response->body()
            ];

        } catch (\Exception $e) {
            // Captura erros de conexão (timeout, cURL error, etc.)
            return [
                'error' => true,
                'message' => 'Falha na conexão com a API da ZapSign.',
                'exception_message' => $e->getMessage()
            ];
        }
    }
}