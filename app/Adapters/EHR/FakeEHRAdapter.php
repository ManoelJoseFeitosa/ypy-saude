<?php

namespace App\Adapters\EHR;

use App\Interfaces\EHR\EHRIntegrationInterface;
use Illuminate\Support\Facades\Log;

/**
 * Uma implementação "fake" da nossa interface de integração para fins de
 * desenvolvimento e teste. Simula a comunicação com um sistema externo.
 */
class FakeEHRAdapter implements EHRIntegrationInterface
{
    public function getPatientById(string $externalPatientId): array
    {
        Log::info("FakeEHRAdapter: Buscando paciente com ID externo: {$externalPatientId}");

        // Simula um retorno de dados no formato FHIR simplificado
        return [
            'resourceType' => 'Patient',
            'id' => $externalPatientId,
            'name' => [
                [
                    'use' => 'official',
                    'family' => 'Silva',
                    'given' => ['Maria', 'Joaquina']
                ]
            ],
            'gender' => 'female',
            'birthDate' => '1975-08-15',
        ];
    }

    public function saveObservation(string $externalPatientId, array $observationData): bool
    {
        Log::info("FakeEHRAdapter: Salvando observação para o paciente {$externalPatientId}", [
            'data' => $observationData
        ]);

        // Simula que a operação sempre funciona
        return true;
    }
}