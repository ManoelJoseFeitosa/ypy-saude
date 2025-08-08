<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZapSignService;

class ZapSignController extends Controller
{
    public function test(ZapSignService $zapSignService)
    {
        // O Laravel vai injetar nosso serviço automaticamente
        $resultado = $zapSignService->testConnection();

        // O comando dd() exibe o resultado na tela e para a execução.
        dd($resultado);
    }
}