<?php
namespace App\Notifications;

use App\Models\Seminar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ResponPengajuanSeminar extends Notification
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
        // Buat pesan dinamis berdasarkan status persetujuan
        $statusText = '';
        if ($this->seminar->status_pengajuan == 'disetujui_dospem') {
            $statusText = 'telah DISETUJUI';
        } elseif ($this->seminar->status_pengajuan == 'ditolak_dospem') {
            $statusText = 'telah DITOLAK';
        } elseif ($this->seminar->status_pengajuan == 'revisi_dospem') {
            $statusText = 'meminta REVISI';
        }

        return [
            'seminar_id' => $this->seminar->id,
            'dosen_name' => $this->seminar->pengajuanKp->dosenPembimbing->user->name,
            'message' => 'Pengajuan seminar Anda ' . $statusText . ' oleh Dosen Pembimbing.',
            'url' => route('mahasiswa.seminar.index'),
            'icon' => 'fa-solid fa-calendar-day',
        ];
    }
}
