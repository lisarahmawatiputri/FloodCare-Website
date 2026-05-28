<?php

namespace App\Observers;

use App\Mail\LaporanMail;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LaporanObserver
{
    public function created(Laporan $laporan): void
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->send(new LaporanMail($laporan));
        }
    }
}