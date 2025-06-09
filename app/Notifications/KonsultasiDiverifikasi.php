<?php

namespace App\Notifications;

use App\Models\Konsultasi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class KonsultasiDiverifikasi extends Notification
{
    use Queueable;

    protected Konsultasi $konsultasi;

    public function __construct(Konsultasi $konsultasi)
    {
        $this->konsultasi = $konsultasi;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // Buat pesan yang dinamis berdasarkan apakah diverifikasi atau hanya diberi catatan
        $pesan = $this->konsultasi->diverifikasi
            ? 'telah DIVERIFIKASI oleh dosen pembimbing.'
            : 'telah DIBERI CATATAN oleh dosen pembimbing.';

        return [
            'konsultasi_id' => $this->konsultasi->id,
            'dosen_name' => $this->konsultasi->dosenPembimbing->user->name,
            'message' => 'Konsultasi Anda untuk topik "' . Str::limit($this->konsultasi->topik_konsultasi, 25) . '" ' . $pesan,
            'url' => route('mahasiswa.pengajuan-kp.konsultasi.index', $this->konsultasi->pengajuan_kp_id),
            'icon' => 'fa-solid fa-comments',
        ];
    }
}
