<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importa a classe de autenticação

class CheckIsMedico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está logado E se o seu tipo é 'medico'
        if (Auth::check() && Auth::user()->tipo == 'medico') {
            // Se for, permite que a requisição continue para o seu destino
            return $next($request);
        }

        // Se não for um médico, redireciona para o dashboard padrão
        return redirect('/dashboard');
    }
}