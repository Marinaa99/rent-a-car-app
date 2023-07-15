<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CarReservationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $car;
    /**
     * Create a new message instance.
     */
    public function __construct($car)
    {
        $this->car = $car;

    }

    public function build()
    {
        $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Car reservation')
            ->view('mail.reservation', ['car' => $this->car]);
    }


}
