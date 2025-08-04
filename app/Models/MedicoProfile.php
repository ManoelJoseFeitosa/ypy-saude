<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicoProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'crm',
        'uf_crm',
        'especialidade',
        'rqe',
        'endereco_completo',
    ];

    /**
     * Relação: um Perfil de Médico pertence a um único Usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}