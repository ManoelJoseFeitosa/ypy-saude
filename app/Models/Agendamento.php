<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'medico_id',
        'paciente_id',
        'data_hora_inicio',
        'data_hora_fim',
        'status',
        'tipo',
        'link_teleconsulta',
        'notas_paciente',
    ];

    /**
     * O médico associado ao agendamento.
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    /**
     * O paciente associado ao agendamento.
     */
    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}
