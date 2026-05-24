<?php

namespace App\Observers;

use App\Mail\LaporanMail;
use App\Models\Laporan;
use Illuminate\Support\Facades\Mail;

class LaporanObserver
{
    public function created(Laporan $laporan): void
    {
        Mail::to(config('mail.admin_email'))->send(new LaporanMail($laporan));
    }
}