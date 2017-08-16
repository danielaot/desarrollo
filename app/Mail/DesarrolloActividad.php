<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DesarrolloActividad extends Mailable
{
    use Queueable, SerializesModels;

    public $actividaddesp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($actividaddesp) {
        $this->actividad = $actividaddesp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = 'Desarrollo de Actividad';
        $actividad = $this->actividad;

        return $this->subject('Calidad de Datos y Homologación')
                    ->view('emails.pricat.desarrolloActividad')
                    ->with(compact('titulo', 'actividad'));
    }
}
