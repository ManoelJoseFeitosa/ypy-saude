<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo', // Adicionado para permitir a definição do tipo de usuário
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELACIONAMENTOS ---

    // --- Perfis ---
    public function medicoProfile(): HasOne
    {
        return $this->hasOne(MedicoProfile::class);
    }

    public function pacienteProfile(): HasOne
    {
        return $this->hasOne(PacienteProfile::class);
    }

    // --- Prescrições ---
    public function prescricoesEmitidas(): HasMany
    {
        return $this->hasMany(Prescricao::class, 'medico_id');
    }

    public function prescricoesRecebidas(): HasMany
    {
        return $this->hasMany(Prescricao::class, 'paciente_id');
    }

    // --- Atestados ---
    public function atestadosEmitidos(): HasMany
    {
        return $this->hasMany(Atestado::class, 'medico_id');
    }

    public function atestadosRecebidos(): HasMany
    {
        return $this->hasMany(Atestado::class, 'paciente_id');
    }

      // --- Prontuários ---
    /**
     * Retorna todos os registros de prontuário de um usuário (como paciente).
     */
    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class, 'paciente_id');
    }

    // --- Laudos ---
    public function laudosEmitidos(): HasMany
    {
        return $this->hasMany(Laudo::class, 'medico_id');
    }

    public function laudosRecebidos(): HasMany
    {
        return $this->hasMany(Laudo::class, 'paciente_id');
    }
}