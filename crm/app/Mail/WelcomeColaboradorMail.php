<?php

namespace App\Mail;

use App\Models\Colaborador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeColaboradorMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Colaborador $colaborador)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bem-vindo(a) à empresa!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.welcome-colaborador',
            with: [
                'colaborador' => $this->colaborador,
                'company_name' => $this->colaborador->company->company_name ?? config('app.name'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
