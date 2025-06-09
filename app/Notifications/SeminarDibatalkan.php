<?php

namespace App\Notifications;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SeminarDibatalkan extends Notification
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
            'message' => 'Seminar KP untuk judul "' . Str::limit($this->seminar->judul_kp_final, 25) . '" telah DIBATALKAN oleh Bapendik.',
            'url' => route('mahasiswa.seminar.index'),
            'icon' => 'fa-solid fa-ban',
        ];
    }
}
