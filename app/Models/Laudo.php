<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laudo extends Model
{
    use HasFactory;

    protected $table = 'laudos';

    protected $fillable = [
        'medico_id',
        'paciente_id',
        'titulo',
        'conteudo',
        'data_emissao',
        'hash_validacao',
    ];

    protected $casts = [
        'data_emissao' => 'date',
    ];

    public function medico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}
