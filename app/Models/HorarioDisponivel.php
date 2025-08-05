<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDisponivel extends Model
{
    use HasFactory;

    protected $table = 'horarios_disponiveis';

    protected $fillable = [
        'medico_id',
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'duracao_consulta',
    ];

    /**
     * O médico dono deste horário.
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }
}
