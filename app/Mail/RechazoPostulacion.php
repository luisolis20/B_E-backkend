<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RechazoPostulacion extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreUsuario;
    public $nombreEmpresa;
    public $nombreOferta;
    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario, $nombreEmpresa, $nombreOferta)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->nombreOferta = $nombreOferta;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Postulación Rechazada - Bolsa de Empleo UTLVTE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.rechazar-postulacion',
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
        return $this->subject('Postulación Rechazada - Bolsa de Empleo UTLVTE')
        ->view('mails.rechazar-postulacion')
        ->with(['nombreUsuario' => $this->nombreUsuario,
            'nombreEmpresa' => $this->nombreEmpresa,
            'nombreOferta' => $this->nombreOferta]);
    }
}
