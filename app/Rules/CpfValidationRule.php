<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Respect\Validation\Validator as v; // Importa o validador

class CpfValidationRule implements ValidationRule
{
    /**
     * Executa a regra de validação.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Usa a biblioteca Respect/Validation para verificar se o valor é um CPF válido
        if (!v::cpf()->validate($value)) {
            // Se a validação falhar, retorna uma mensagem de erro.
            $fail('O campo :attribute não é um CPF válido.');
        }
    }
}