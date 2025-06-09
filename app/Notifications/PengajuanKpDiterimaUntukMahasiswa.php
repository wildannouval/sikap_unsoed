<?php
namespace App\Notifications;
use App\Models\PengajuanKp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanKpDiterimaUntukMahasiswa extends Notification
{
    use Queueable;
    protected PengajuanKp $pengajuanKp;

    public function __construct(PengajuanKp $pengajuanKp)
    {
        $this->pengajuanKp = $pengajuanKp;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_kp_id' => $this->pengajuanKp->id,
            'message' => 'Selamat! Pengajuan KP Anda untuk judul "' . \Illuminate\Support\Str::limit($this->pengajuanKp->judul_kp, 30) . '" telah disetujui oleh Komisi.',
            'url' => route('mahasiswa.pengajuan-kp.index'),
            'icon' => 'fa-solid fa-check-circle',
        ];
    }
}
