<?php

namespace App\Notifications;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RevisiJadwalDiminta extends Notification
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
        $mahasiswaName = $this->seminar->mahasiswa->user->name;

        // Pesan yang berbeda untuk Mahasiswa dan Dosen
        if ($notifiable->role === 'mahasiswa') {
            $message = "Bapendik meminta revisi untuk usulan jadwal seminar Anda. Silakan ajukan ulang setelah berkoordinasi dengan pembimbing.";
            $url = route('mahasiswa.seminar.index');
        } else { // Untuk dosen
            $message = "Bapendik meminta revisi jadwal untuk seminar mahasiswa bimbingan Anda, {$mahasiswaName}.";
            $url = route('dosen.pembimbing.seminar-approval.index');
        }

        return [
            'seminar_id' => $this->seminar->id,
            'message' => $message,
            'url' => $url,
            'icon' => 'fa-solid fa-clock-rotate-left',
        ];
    }
}
