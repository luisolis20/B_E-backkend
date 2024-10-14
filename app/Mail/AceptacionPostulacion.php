<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AceptacionPostulacion extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreUsuario;
    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aceptacion Postulacion',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.aceptar-postulacion',
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
        return $this->subject('Aceptación de postulación')
        ->view('mails.aceptacion_postulacion', [
            'nombreUsuario' => $this->nombreUsuario
        ]);
    }
}
