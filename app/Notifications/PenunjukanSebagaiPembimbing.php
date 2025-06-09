<?php
namespace App\Notifications;
use App\Models\PengajuanKp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PenunjukanSebagaiPembimbing extends Notification
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
            'mahasiswa_name' => $this->pengajuanKp->mahasiswa->user->name,
            'message' => 'Anda telah ditunjuk sebagai Dosen Pembimbing untuk mahasiswa: ' . $this->pengajuanKp->mahasiswa->user->name . '.',
            'url' => route('dosen-pembimbing.bimbingan-kp.konsultasi.show', $this->pengajuanKp->id),
            'icon' => 'fa-solid fa-user-check',
        ];
    }
}
