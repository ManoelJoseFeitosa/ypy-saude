<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ESTA É A LINHA ESSENCIAL QUE CORRIGE O ERRO
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'medicamentos';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'principio_ativo',
    ];

    /**
     * Indica se o modelo deve ter timestamps (created_at e updated_at).
     *
     * @var bool
     */
    public $timestamps = false; // A nossa tabela não tem created_at/updated_at
}
