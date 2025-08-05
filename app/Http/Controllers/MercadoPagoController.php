<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function checkout(User $user)
    {
        // 1. Configura o SDK com sua chave do .env
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        // 2. Cria o cliente de Preferência de Pagamento
        $client = new PreferenceClient();

        // 3. Cria a preferência com os detalhes da compra
        $preference = $client->create([
            "items"=> [
                [
                    "title" => "Assinatura Plano Padrão - Ypy Saúde",
                    "quantity" => 1,
                    "unit_price" => 59.90
                ]
            ],
            // Identifica o usuário que está pagando
            "external_reference" => $user->id, 

            // URL para onde o sistema do Mercado Pago enviará a notificação de pagamento
            "notification_url" => route('mercadopago.webhook'),

            // URLs de retorno para o usuário
            "back_urls" => [
                "success" => route('subscribe.success'), // Rota para página de sucesso
                "failure" => route('subscribe.failure'), // Rota para página de falha
            ],
            "auto_return" => "approved"
        ]);

        // 4. Redireciona o usuário para o link de pagamento gerado
        return redirect($preference->init_point);
    }
}