<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescricao extends Model
{
    use HasFactory;

    /**
     * A tabela associada com o Model.
     *
     * @var string
     */
    protected $table = 'prescricoes'; // <-- ADICIONE ESTA LINHA

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'medico_id',
        'paciente_id',
        'data_prescricao',
        'status',
        'tipo',
        'hash_validacao',
    ];

    /**
     * Relação: uma Prescrição pertence a um Usuário (o médico).
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    /**
     * Relação: uma Prescrição pertence a um Usuário (o paciente).
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    /**
     * Relação: uma Prescrição tem muitos Medicamentos.
     */
    public function medicamentos(): HasMany
    {
        return $this->hasMany(PrescricaoMedicamento::class);
    }
}