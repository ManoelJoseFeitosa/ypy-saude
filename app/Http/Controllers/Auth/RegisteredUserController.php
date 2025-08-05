<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MedicoProfile;
use App\Models\PacienteProfile;
use App\Rules\CpfValidationRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'string', 'in:paciente,medico'],
            
            'crm' => ['required_if:tipo,medico', 'nullable', 'string', 'max:255'],
            'uf_crm' => ['required_if:tipo,medico', 'nullable', 'string', 'max:2'],
            'endereco_completo' => ['required_if:tipo,medico', 'nullable', 'string', 'max:255'],
            'rqe' => ['nullable', 'string', 'max:255'],

            'cpf' => ['required_if:tipo,paciente', 'nullable', new CpfValidationRule(), 'unique:paciente_profiles,cpf'],
            
            'terms' => ['accepted'], // Valida se o checkbox foi marcado
            'medico_id' => ['nullable', 'exists:users,id'], // Valida o novo campo de vínculo
        ]);

        // --- LÓGICA DE STATUS ADICIONADA ---
        // Define os dados base do usuário
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => $request->tipo,
            'terms_accepted_at' => now(),
        ];

        // Define o status da conta com base no tipo de usuário
        if ($request->tipo === 'medico') {
            $userData['status'] = 'pagamento_pendente';
        } else {
            $userData['status'] = 'ativo'; // Pacientes são ativados imediatamente
        }

        $user = User::create($userData);

        // --- LÓGICA DE CRIAÇÃO DE PERFIL (Mantida) ---
        if ($user->tipo === 'medico') {
            MedicoProfile::create([
                'user_id' => $user->id,
                'crm' => $request->crm,
                'uf_crm' => strtoupper($request->uf_crm),
                'especialidade' => $request->especialidade,
                'rqe' => $request->rqe,
                'endereco_completo' => $request->endereco_completo,
            ]);
        } 
        elseif ($user->tipo === 'paciente') {
            PacienteProfile::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
            ]);

            if ($request->filled('medico_id')) {
                $medico = User::find($request->medico_id);
                if ($medico && $medico->tipo === 'medico') {
                    $user->medicos()->attach($medico->id);
                }
            }
        }

        event(new Registered($user));

        // --- LÓGICA DE REDIRECIONAMENTO CONDICIONAL ---
        // Se for paciente, faz o login e vai para o dashboard
        if ($user->tipo === 'paciente') {
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        } 
        // Se for médico, NÃO faz login e vai para o checkout
        elseif ($user->tipo === 'medico') {
            // Adiciona uma mensagem flash para explicar o próximo passo ao usuário
            session()->flash('info', 'Seu pré-cadastro foi realizado com sucesso! Efetue o pagamento para ativar sua conta e ter acesso completo à plataforma.');
            
            // Redireciona para a rota de checkout do Mercado Pago
            return redirect()->route('mercadopago.checkout', ['user' => $user->id]);
        }

        // Redirecionamento padrão de segurança (não deve ser atingido)
        return redirect('/');
    }
}