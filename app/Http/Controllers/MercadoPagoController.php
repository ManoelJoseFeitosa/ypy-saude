<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Adicionado para logs de erro e depuração
use MercadoPago\Client\Payment\PaymentClient; // Adicionado para consultar pagamentos
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    /**
     * Prepara e redireciona o usuário para o checkout do Mercado Pago.
     */
    public function checkout(User $user)
    {
        try {
            // Seu código do checkout está perfeito aqui.
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
            $client = new PreferenceClient();
            $preference = $client->create([
                "items" => [
                    [
                        "title" => "Assinatura Plano Padrão - Ypy Saúde",
                        "description" => "Acesso completo às funcionalidades para médicos.",
                        "quantity" => 1,
                        "unit_price" => 59.90,
                        "currency_id" => "BRL",
                    ]
                ],
                "external_reference" => $user->id,
                "notification_url" => route('mercadopago.webhook'),
                "back_urls" => [
                    "success" => route('subscribe.success'),
                    "failure" => route('subscribe.failure'),
                ],
                "auto_return" => "approved"
            ]);

            return redirect($preference->init_point);

        } catch (\Exception $e) {
            // Adicionado: Se algo der errado, registre o erro e redirecione com uma mensagem
            Log::error('Erro ao criar checkout do Mercado Pago: ' . $e->getMessage());
            return redirect()->route('planos')->with('error', 'Não foi possível iniciar o processo de pagamento. Por favor, tente novamente.');
        }
    }

    /**
     * ---- MÉTODO WEBHOOK ADICIONADO ----
     * Recebe a notificação de pagamento (Webhook/IPN) do Mercado Pago.
     */
    public function webhook(Request $request)
    {
        Log::info('Mercado Pago Webhook Recebido:', $request->all());

        $paymentId = $request->input('data.id') ?? $request->input('id');
        $topic = $request->input('type') ?? $request->input('topic');

        if ($topic === 'payment' && $paymentId) {
            try {
                MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
                
                $paymentClient = new PaymentClient();
                $payment = $paymentClient->get($paymentId);

                if ($payment && $payment->status === 'approved' && $payment->external_reference) {
                    $user = User::find($payment->external_reference);

                    if ($user && $user->status === 'pagamento_pendente') {
                        $user->status = 'ativo';
                        $user->save();
                        
                        Log::info("Usuário {$user->id} ativado com sucesso via webhook do Mercado Pago.");
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erro no webhook do Mercado Pago: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
        
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * ---- MÉTODO SUCCESS ADICIONADO ----
     * Página de sucesso após o pagamento.
     */
    public function success()
    {
        session()->flash('success', 'Pagamento aprovado! Sua conta foi ativada. Faça o login para começar.');
        return redirect()->route('login');
    }

    /**
     * ---- MÉTODO FAILURE ADICIONADO ----
     * Página de falha após o pagamento.
     */
    public function failure()
    {
        return redirect()->route('planos')->with('error', 'Ocorreu uma falha no pagamento. Por favor, verifique os dados ou tente novamente.');
    }
}