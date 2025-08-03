<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Prontuario extends Model
{
    use HasFactory;

    protected $table = 'prontuarios';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'data_atendimento',
        'anotacao',
        'relacionado_id',
        'relacionado_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_atendimento' => 'date',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    /**
     * Relacionamento polimórfico: pode pertencer a uma Prescricao, Atestado, etc.
     */
    public function relacionado(): MorphTo
    {
        return $this->morphTo();
    }
}
