<?php

namespace App\Http\Controllers;

use App\Interfaces\EHR\EHRIntegrationInterface;
use Illuminate\Http\Request;

class EHRTestController extends Controller
{
    // Injetamos a interface, e o Laravel nos dará o FakeEHRAdapter
    public function __construct(private EHRIntegrationInterface $ehrService)
    {
    }

    public function show(string $patientId)
    {
        // Nosso controller chama o serviço, sem saber qual sistema está por trás.
        $patientData = $this->ehrService->getPatientById($patientId);

        // Apenas para teste, vamos exibir os dados na tela.
        dd($patientData);
    }
}