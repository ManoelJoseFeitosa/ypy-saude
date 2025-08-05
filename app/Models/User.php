<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'tipo',
        'terms_accepted_at',
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
        // CORREÇÃO APLICADA AQUI: Especifica a chave estrangeira correta.
        return $this->hasOne(MedicoProfile::class, 'user_id');
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

    // --- NOVOS VÍNCULOS DIRETOS (Muitos-para-Muitos) ---

    /**
     * Os pacientes que este médico atende.
     */
    public function pacientes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'medico_paciente', 'medico_id', 'paciente_id');
    }

    /**
     * Os médicos que atendem este paciente.
     */
    public function medicos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'medico_paciente', 'paciente_id', 'medico_id');
    }

    /**
     * Retorna os horários de atendimento definidos por este utilizador (se for médico).
     */
    public function horariosDisponiveis()
    {
        return $this->hasMany(HorarioDisponivel::class, 'medico_id');
    }
}