<?php

namespace App\Mail;

use App\Alumno_Codigo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Alumno_Codigo $codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('alumno.mails.mail_codigo');
    }
}
