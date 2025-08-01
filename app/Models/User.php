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

    // --- RELACIONAMENTOS ADICIONADOS ---

    /**
     * Relação: um Usuário pode ter um Perfil de Médico.
     */
    public function medicoProfile(): HasOne
    {
        return $this->hasOne(MedicoProfile::class);
    }

    /**
     * Relação: um Usuário (como médico) pode emitir muitas prescrições.
     */
    public function prescricoesEmitidas(): HasMany
    {
        return $this->hasMany(Prescricao::class, 'medico_id');
    }

    /**
     * Relação: um Usuário (como paciente) pode receber muitas prescrições.
     */
    public function prescricoesRecebidas(): HasMany
    {
        return $this->hasMany(Prescricao::class, 'paciente_id');
    }

    /**
 * Relação: um Usuário pode ter um Perfil de Paciente.
 */
    public function pacienteProfile()
    {
        return $this->hasOne(PacienteProfile::class);
    }
}