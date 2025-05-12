<?php

namespace App\Jobs;

use App\Mail\OTPMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OTPJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $otp;
    protected $otpId;


    /**
     * Create a new job instance.
     */
    public function __construct($email, $otp, $otpId)
    {
        $this->email = $email;
        $this->otp = $otp;
        $this->otpId = $otpId;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new OTPMail($this->otpId, $this->otp));

    }
}
