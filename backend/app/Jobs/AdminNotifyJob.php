<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\AdminNotifyMail;

class AdminNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $booking;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking,$user)
    {
        $this->booking = $booking;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $adminNotifyMail = new AdminNotifyMail($this->booking,$this->resort);
        Mail::to($this->user['email'])->send($adminNotifyMail);
    }
}
