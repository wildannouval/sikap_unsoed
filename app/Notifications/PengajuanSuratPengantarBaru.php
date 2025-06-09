<?php

namespace App\Notifications;

use App\Models\SuratPengantar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanSuratPengantarBaru extends Notification
{
    use Queueable;

    protected SuratPengantar $suratPengantar;

    /**
     * Create a new notification instance.
     */
    public function __construct(SuratPengantar $suratPengantar)
    {
        $this->suratPengantar = $suratPengantar;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Kirim notifikasi ini ke 'database' untuk ditampilkan di dalam aplikasi.
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'surat_pengantar_id' => $this->suratPengantar->id,
            'mahasiswa_name' => $this->suratPengantar->mahasiswa->user->name,
            'message' => 'Pengajuan surat pengantar baru dari ' . $this->suratPengantar->mahasiswa->user->name . ' menunggu validasi Anda.',
            'url' => route('bapendik.validasi-surat.edit', $this->suratPengantar->id),
            'icon' => 'fa-solid fa-file-lines', // Contoh ikon FontAwesome
        ];
    }
}
