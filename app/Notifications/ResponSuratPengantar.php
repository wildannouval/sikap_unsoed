<?php

namespace App\Notifications;

use App\Models\SuratPengantar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ResponSuratPengantar extends Notification
{
    use Queueable;

    protected SuratPengantar $suratPengantar;

    public function __construct(SuratPengantar $suratPengantar)
    {
        $this->suratPengantar = $suratPengantar;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kirim notifikasi ke dalam aplikasi
    }

    public function toArray(object $notifiable): array
    {
        // Buat pesan dinamis berdasarkan status persetujuan
        $statusText = '';
        $icon = 'fa-solid fa-file-circle-question'; // Ikon default

        if ($this->suratPengantar->status_bapendik === 'disetujui') {
            $statusText = 'telah DISETUJUI';
            $icon = 'fa-solid fa-file-circle-check';
        } elseif ($this->suratPengantar->status_bapendik === 'ditolak') {
            $statusText = 'telah DITOLAK';
            $icon = 'fa-solid fa-file-circle-xmark';
        }

        return [
            'surat_pengantar_id' => $this->suratPengantar->id,
            'message' => 'Pengajuan surat pengantar Anda ke ' . Str::limit($this->suratPengantar->lokasi_penelitian, 25) . ' ' . $statusText . '.',
            'url' => route('mahasiswa.surat-pengantar.index'), // Arahkan ke halaman riwayat surat pengantar
            'icon' => $icon,
        ];
    }
}
