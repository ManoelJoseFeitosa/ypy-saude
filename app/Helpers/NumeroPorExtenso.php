<?php

namespace App\Helpers;

class NumeroPorExtenso
{
    public static function converter($numero)
    {
        // Esta é uma implementação simples. Para casos complexos, uma biblioteca seria melhor.
        $unidades = ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
        if ($numero >= 0 && $numero <= 9) {
            return $unidades[$numero];
        }
        return $numero; // Retorna o número se for maior que 9
    }
}