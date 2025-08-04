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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => $request->tipo,
            'terms_accepted_at' => now(), // Salva a data e hora do aceite
        ]);

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
        // Se for paciente, cria o perfil de paciente
        elseif ($user->tipo === 'paciente') {
            PacienteProfile::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
            ]);

            // --- LÓGICA DE VÍNCULO ADICIONADA ---
            // Se um médico foi selecionado no formulário, cria o vínculo
            if ($request->filled('medico_id')) {
                $medico = User::find($request->medico_id);
                // Garante que o ID selecionado é realmente de um médico
                if ($medico && $medico->tipo === 'medico') {
                    // Usa o relacionamento 'medicos()' para criar a ligação na tabela pivô
                    $user->medicos()->attach($medico->id);
                }
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
