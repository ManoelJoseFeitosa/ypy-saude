<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ZapSign API Credentials
    |--------------------------------------------------------------------------
    |
    | As credenciais para a API da ZapSign são lidas do seu arquivo .env.
    | A URL já aponta para o ambiente de Sandbox.
    |
    */

    'api_url' => env('ZAPSIGN_API_URL', 'https://api.sandbox.zapsign.com.br/api/v1'),

    'api_token' => env('ZAPSIGN_API_TOKEN'),
];