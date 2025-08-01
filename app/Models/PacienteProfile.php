<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PacienteProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'cpf'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}