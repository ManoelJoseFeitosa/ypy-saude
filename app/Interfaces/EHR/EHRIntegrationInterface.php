<?php

namespace App\Interfaces\EHR;

/**
 * Define o contrato que todos os adaptadores de Prontuário Eletrônico
 * devem seguir.
 */
interface EHRIntegrationInterface
{
    /**
     * Busca os dados de um paciente pelo seu ID no sistema externo.
     *
     * @param string $externalPatientId O ID do paciente no sistema de origem.
     * @return array Os dados do paciente.
     */
    public function getPatientById(string $externalPatientId): array;

    /**
     * Salva uma nova observação (ex: pressão arterial, glicemia) para um paciente.
     *
     * @param string $externalPatientId O ID do paciente no sistema de origem.
     * @param array $observationData Os dados da observação.
     * @return bool Retorna true em caso de sucesso.
     */
    public function saveObservation(string $externalPatientId, array $observationData): bool;
}