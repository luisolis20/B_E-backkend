<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarActualizacionEmprendimiento extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreUsuario;
    public $nombreEmprendimiento;
    public $correoUsuario;
    /**
     * Create a new message instance.
     */
    public function __construct($nombreUsuario, $nombreEmprendimiento, $correoUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->nombreEmprendimiento = $nombreEmprendimiento;
        $this->correoUsuario = $correoUsuario;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Revisión de Actualización de Emprendimiento - Bolsa de Empleo UTLVTE',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.enviar-emprendimiento',
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
        return $this->from('no-reply@utelvt.edu.ec', 'Revisor de Emprendimientos')
                    ->to('vinculacion@utelvt.edu.ec') 
                    ->replyTo($this->correoUsuario, $this->nombreUsuario)
        ->subject('Revisión de Actualización de Emprendimiento - Bolsa de Empleo UTLVTE')
        ->view('mails.enviar-actualizar-emprendimiento')
        ->with(['nombreUsuario' => $this->nombreUsuario,
            'nombreEmprendimiento' => $this->nombreEmprendimiento]);
    }
}
