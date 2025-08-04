<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User; // Modelo de usuário (médico e paciente)
use App\Models\Prescricao; // Supondo que você tem um modelo para Prescricao

class DocumentoMedicoDisponivel extends Mailable
{
    use Queueable, SerializesModels;

    // Propriedades públicas para passar dados para a view do e-mail
    public User $paciente;
    public User $medico;
    public string $tipoDocumento;
    public string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(User $paciente, User $medico, string $tipoDocumento, int $documentoId)
    {
        $this->paciente = $paciente;
        $this->medico = $medico;
        $this->tipoDocumento = $tipoDocumento;
        // Gera a URL para o paciente visualizar o documento (ajuste a rota conforme seu projeto)
        $this->url = route('paciente.documentos.show', ['tipo' => strtolower($tipoDocumento), 'id' => $documentoId]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo(a) ' . ucfirst($this->tipoDocumento) . ' Disponível - Ypy Saúde',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.documento-disponivel',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}