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
        // Validação completa para todos os campos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'string', 'in:paciente,medico'],
            
            'crm' => ['required_if:tipo,medico', 'nullable', 'string', 'max:255'],
            'uf_crm' => ['required_if:tipo,medico', 'nullable', 'string', 'max:2'],
            'especialidade' => ['nullable', 'string', 'max:255'],
            
            'cpf' => [
                'required_if:tipo,paciente',
                'nullable',
                new CpfValidationRule(),
                'unique:paciente_profiles,cpf'
            ],
        ]);

        // Cria o usuário com o 'tipo' correto
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => $request->tipo,
        ]);

        // Se for médico, cria o perfil de médico
        if ($user->tipo === 'medico') {
            MedicoProfile::create([
                'user_id' => $user->id,
                'crm' => $request->crm,
                'uf_crm' => strtoupper($request->uf_crm),
                'especialidade' => $request->especialidade,
            ]);
        } 
        // Se for paciente, cria o perfil de paciente
        elseif ($user->tipo === 'paciente') {
            PacienteProfile::create([
                'user_id' => $user->id,
                'cpf' => $request->cpf,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}