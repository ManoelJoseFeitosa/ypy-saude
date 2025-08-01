<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrescricaoMedicamento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prescricao_id',
        'nome_medicamento',
        'dosagem',
        'posologia',
        'quantidade',
    ];

    /**
     * Relação: um item de Medicamento pertence a uma única Prescrição.
     */
    public function prescricao(): BelongsTo
    {
        return $this->belongsTo(Prescricao::class);
    }
}