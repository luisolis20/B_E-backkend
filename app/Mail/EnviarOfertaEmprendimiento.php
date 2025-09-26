<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarOfertaEmprendimiento extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreUsuario;
    public $nombreEmprendimiento;
    public $correoUsuario;
    public $nombreOferta;
    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario, $nombreEmprendimiento, $correoUsuario, $nombreOferta)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->nombreEmprendimiento = $nombreEmprendimiento;
        $this->correoUsuario = $correoUsuario;
        $this->nombreOferta = $nombreOferta;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Revisión de Oferta Laboral de Emprendimiento - Bolsa de Empleo UTLVTE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.enviar-oferta-emprendimiento',
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
        return $this->from('no-reply@utelvt.edu.ec', 'Sistema de Emprendimientos') 
                    ->to('vinculacion@utelvt.edu.ec') 
                    ->replyTo($this->correoUsuario, $this->nombreUsuario)
        ->subject('Revisión de Oferta Laboral de Emprendimiento - Bolsa de Empleo UTLVTE')
        ->view('enviar-oferta-emprendimiento')
        ->with(['nombreUsuario' => $this->nombreUsuario,
            'nombreEmprendimiento' => $this->nombreEmprendimiento,
            'nombreOferta' => $this->nombreOferta]);
    }
}
