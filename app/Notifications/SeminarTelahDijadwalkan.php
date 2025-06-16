<?php
namespace App\Notifications;
use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class SeminarTelahDijadwalkan extends Notification
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
        $jadwal = Carbon::parse($this->seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY');
        $jam = Carbon::parse($this->seminar->jam_mulai)->format('H:i');
        $mahasiswaName = $this->seminar->mahasiswa->user->name;

        // Pesan yang berbeda untuk Mahasiswa dan Dosen
        if ($notifiable->role === 'mahasiswa') {
            $message = "Jadwal seminar Anda telah ditetapkan pada {$jadwal}, pukul {$jam}.";
            $url = route('mahasiswa.seminar.index');
        } else { // Untuk dosen
            $message = "Jadwal seminar untuk mahasiswa bimbingan Anda, {$mahasiswaName}, telah ditetapkan.";
            $url = route('dosen.pembimbing.penilaian-seminar.index');
        }

        return [
            'seminar_id' => $this->seminar->id,
            'message' => $message,
            'url' => $url,
            'icon' => 'fa-solid fa-calendar-check',
        ];
    }
}
