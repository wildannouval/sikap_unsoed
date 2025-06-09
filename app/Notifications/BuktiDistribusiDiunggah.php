<?php
namespace App\Notifications;

use App\Models\Distribusi;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class BuktiDistribusiDiunggah extends Notification
{
    use Queueable;
    protected Distribusi $distribusi;

    public function __construct(Distribusi $distribusi)
    {
        $this->distribusi = $distribusi;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $mahasiswaName = $this->distribusi->mahasiswa->user->name;

        // URL akan berbeda untuk Bapendik dan Dosen
        if ($notifiable->role === 'bapendik') {
            $url = route('bapendik.spk.index'); // Atau halaman rekap KP Bapendik
        } else { // Untuk Dosen
            $url = route('dosen-pembimbing.bimbingan-kp.konsultasi.show', $this->distribusi->pengajuan_kp_id);
        }

        return [
            'distribusi_id' => $this->distribusi->id,
            'message' => "Mahasiswa {$mahasiswaName} telah mengupload bukti distribusi laporan KP.",
            'url' => $url,
            'icon' => 'fa-solid fa-book-bookmark',
        ];
    }
}
