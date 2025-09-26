<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RechazoEmprendimiento extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreUsuario;
    public $nombreEmprendimiento;
    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario, $nombreEmprendimiento)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->nombreEmprendimiento = $nombreEmprendimiento;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Emprenidmiento No Aprobado - Bolsa de Empleo UTLVTE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.rechazar-emprendimiento',
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
    public function build()
    {
        return $this->subject('Emprendimiento no Aprobado - Bolsa de Empleo UTLVTE')
        ->view('mails.rechazar-emprendimiento')
        ->with(['nombreUsuario' => $this->nombreUsuario,
            'nombreEmprendimiento' => $this->nombreEmprendimiento]);
    }
}
