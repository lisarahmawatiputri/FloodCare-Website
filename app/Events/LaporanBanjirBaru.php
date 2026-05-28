<?php

namespace App\Events;

use App\Models\Laporan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LaporanBanjirBaru implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(public Laporan $laporan)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('admin-laporan');
    }

    public function broadcastAs(): string
    {
        return 'laporan-baru';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->laporan->id,
            'judul' => $this->laporan->judul ?? 'Laporan Banjir Baru',
            'alamat_lokasi' => $this->laporan->alamat_lokasi ?? null,
            'tingkat_risiko' => $this->laporan->tingkat_risiko ?? 'rendah',
            'status_laporan' => $this->laporan->status_laporan ?? 'menunggu',
            'created_at' => optional($this->laporan->created_at)->diffForHumans(),
        ];
    }
}
