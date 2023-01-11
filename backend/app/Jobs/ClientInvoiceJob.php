<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\ClientInvoiceMail;


class ClientInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $booking;
    protected $resort;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking,$resort)
    {
        $this->booking = $booking;
        $this->resort = $resort;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $clientInvoiceMail = new ClientInvoiceMail($this->booking,$this->resort);
        Mail::to($this->booking['email'])->send($clientInvoiceMail);

    }
}
