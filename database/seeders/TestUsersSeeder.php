<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MedicoProfile;
use App\Models\PacienteProfile;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Criar o Médico de Teste (JÁ ATIVO) ---
        $medico = User::create([
            'name' => 'Dr. House',
            'email' => 'house@exemplo.com',
            'password' => Hash::make('password'),
            'tipo' => 'medico',
            'status' => 'ativo', // <-- A MÁGICA ACONTECE AQUI
            'terms_accepted_at' => now(),
        ]);

        MedicoProfile::create([
            'user_id' => $medico->id,
            'crm' => '12345',
            'uf_crm' => 'PI',
            'endereco_completo' => 'Rua Fictícia, 123, Teresina-PI',
        ]);

        // --- Criar Paciente 1 ---
        $paciente1 = User::create([
            'name' => 'Maria Silva',
            'email' => 'maria@exemplo.com',
            'password' => Hash::make('password'),
            'tipo' => 'paciente',
            'status' => 'ativo',
            'terms_accepted_at' => now(),
        ]);

        PacienteProfile::create([
            'user_id' => $paciente1->id,
            'cpf' => '111.111.111-11',
        ]);
        
        // --- Criar Paciente 2 ---
        $paciente2 = User::create([
            'name' => 'João Souza',
            'email' => 'joao@exemplo.com',
            'password' => Hash::make('password'),
            'tipo' => 'paciente',
            'status' => 'ativo',
            'terms_accepted_at' => now(),
        ]);

        PacienteProfile::create([
            'user_id' => $paciente2->id,
            'cpf' => '222.222.222-22',
        ]);
    }
}