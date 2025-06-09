<?php

namespace App\Notifications;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SeminarSelesaiDinilai extends Notification
{
    use Queueable;

    protected Seminar $seminar;

    public function __construct(Seminar $seminar)
    {
        $this->seminar = $seminar;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'seminar_id' => $this->seminar->id,
            'pengajuan_kp_id' => $this->seminar->pengajuan_kp_id,
            'message' => 'Selamat! Seminar KP Anda untuk judul "' . Str::limit($this->seminar->judul_kp_final, 25) . '" telah selesai dinilai.',
            'url' => route('mahasiswa.pengajuan-kp.index'), // Arahkan ke riwayat KP untuk melihat status & nilai
            'icon' => 'fa-solid fa-graduation-cap', // Contoh ikon kelulusan
        ];
    }
}
