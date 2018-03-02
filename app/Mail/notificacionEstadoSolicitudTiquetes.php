<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class notificacionEstadoSolicitudTiquetes extends Mailable
{
    use Queueable, SerializesModels;

    public $objSolTiquete;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($objSolTiquete)
    {
        $this->objSolTiquete = $objSolTiquete;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $style = ['body-line' => 'margin: 0 20px 12px; font-size: 13px; line-height: 21px; color: #4f4f4f; font-family: sans-serif;'];
        $titulo = 'TIQUETES';
        $objSolTiquete = $this->objSolTiquete;

        return $this->subject('TIQUETES - Administración Electronica de Tiquetes')
        ->view('emails.Tiquetes.notificacionEstadoSolicitud')
        ->with(compact('style', 'titulo', 'objSolTiquete'));

    }
}