<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetOtpMail extends Mailable
{
    public int $otp;

    public function __construct(int $otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this
            ->subject('Kode OTP Reset Password FloodCare')
            ->view('emails.password-reset-otp');
    }
}
