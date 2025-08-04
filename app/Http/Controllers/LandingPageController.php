<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    // Método para a página inicial (Home)
    public function home()
    {
        return view('welcome');
    }

    // Método para a página de Contato
    public function contato()
    {
        return view('pages.contato');
    }

    // Método para a página de Planos
    public function planos()
    {
        return view('pages.planos');
    }

    // Método para a página de termo de uso
    public function termos()
    {
        return view('pages.termos');
    }
}
