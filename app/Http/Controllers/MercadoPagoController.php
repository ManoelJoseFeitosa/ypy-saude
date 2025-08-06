<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Subscription\SubscriptionClient; // ALTERADO: Cliente de Assinatura
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    /**
     * Prepara e redireciona o usuário para o checkout de ASSINATURA do Mercado Pago.
     */
    public function checkout(User $user)
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

            // --- LÓGICA DE ASSINATURA ATUALIZADA ---

            // ID do Plano Semestral que você criou no painel do Mercado Pago
            $planId = 'e7e54a50047b46238d79abee7ee8271b';

            $client = new SubscriptionClient();

            // Cria a requisição de assinatura
            $subscriptionRequest = [
                "reason" => "Assinatura Plano Semestral - Ypy Saúde",
                "preapproval_plan_id" => $planId,
                "payer_email" => $user->email,
                "external_reference" => $user->id,
                "back_url" => route('subscribe.success'), // URL de retorno após sucesso
            ];

            $subscription = $client->create($subscriptionRequest);

            // Redireciona para a URL de assinatura gerada
            return redirect($subscription->init_point);

        } catch (\Exception $e) {
            Log::error('Erro ao criar assinatura no Mercado Pago: ' . $e->getMessage());
            return redirect()->route('planos')->with('error', 'Não foi possível iniciar o processo de assinatura. Tente novamente.');
        }
    }

    /**
     * Recebe a notificação de pagamento (Webhook/IPN) do Mercado Pago.
     */
    public function webhook(Request $request)
    {
        Log::info('Mercado Pago Webhook Recebido:', $request->all());

        // A notificação de assinatura pode ter um formato diferente, vamos verificar
        $topic = $request->input('type') ?? $request->input('topic');
        $id = $request->input('data.id');

        if ($topic === 'preapproval' && $id) {
            try {
                MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
                
                // Busca os detalhes da assinatura (preapproval)
                $client = new SubscriptionClient();
                $subscription = $client->get($id);

                // Se a assinatura foi aprovada e tem nossa referência
                if ($subscription && $subscription->status === 'authorized' && $subscription->external_reference) {
                    
                    $user = User::find($subscription->external_reference);

                    if ($user && $user->status === 'pagamento_pendente') {
                        $user->status = 'ativo';
                        $user->mp_subscription_id = $subscription->id; // Salva o ID da assinatura
                        $user->subscription_started_at = now(); // Salva a data de início
                        $user->save();
                        
                        Log::info("Usuário {$user->id} ativado com sucesso via webhook de assinatura.");
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erro no webhook de assinatura do Mercado Pago: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
            }
        }
        
        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Página de sucesso após o pagamento.
     */
    public function success()
    {
        session()->flash('success', 'Assinatura realizada com sucesso! Sua conta foi ativada. Faça o login para começar.');
        return redirect()->route('login');
    }

    /**
     * Página de falha após o pagamento.
     */
    public function failure()
    {
        return redirect()->route('planos')->with('error', 'Ocorreu uma falha no processo de assinatura. Por favor, verifique os dados ou tente novamente.');
    }
}