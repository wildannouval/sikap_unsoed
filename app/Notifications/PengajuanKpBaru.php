<?php

namespace App\Notifications;

use App\Models\PengajuanKp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class PengajuanKpBaru extends Notification
{
    use Queueable;

    protected PengajuanKp $pengajuanKp;

    public function __construct(PengajuanKp $pengajuanKp)
    {
        $this->pengajuanKp = $pengajuanKp;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kirim notifikasi ke dalam aplikasi
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_kp_id' => $this->pengajuanKp->id,
            'mahasiswa_name' => $this->pengajuanKp->mahasiswa->user->name,
            'message' => 'Pengajuan KP baru dari ' . $this->pengajuanKp->mahasiswa->user->name . ' dengan judul "' . Str::limit($this->pengajuanKp->judul_kp, 25) . '" memerlukan validasi.',
            'url' => route('dosen-komisi.validasi-kp.edit', $this->pengajuanKp->id), // Link aksi untuk Dosen Komisi
            'icon' => 'fa-solid fa-folder-plus', // Contoh ikon
        ];
    }
}
