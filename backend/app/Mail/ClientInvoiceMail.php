<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $booking;
    protected $resort;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking,$resort)
    {
        $this->booking = $booking;
        $this->resort  = $resort;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('client_invoice_email')->with([
            'booking' => $this->booking,
            'resort'  => $this->resort,
        ]);

    }
}
