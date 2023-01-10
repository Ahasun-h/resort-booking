<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class AdminNotifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $booking;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking,$user)
    {
        $this->booking = $booking;
        $this->user  = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin_notify')->with([
            'booking' => $this->booking,
            'user'  => $this->user,
        ]);

    }
}
