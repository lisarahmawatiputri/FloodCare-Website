<?php

namespace App\Mail;

use App\Models\Laporan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LaporanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Laporan $laporan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Laporan Banjir Baru Masuk — ' . $this->laporan->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.laporan',
        );
    }

    public function attachments(): array
    {
        if (!$this->laporan->foto_laporan) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->laporan->foto_laporan)
                ->withMime('image/jpeg'),
        ];
    }
}