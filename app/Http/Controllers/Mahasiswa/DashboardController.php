<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKp;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->mahasiswa) {
            return view('mahasiswa.dashboard')->withErrors(['profil_mahasiswa' => 'Profil mahasiswa tidak ditemukan.']);
        }
        $mahasiswa = $user->mahasiswa;

        $pengajuanKpAktif = PengajuanKp::where('mahasiswa_id', $mahasiswa->id)
            ->whereNotIn('status_kp', ['lulus', 'tidak_lulus', 'dibatalkan_total']) // Status akhir
            ->where(function ($query) { // Bisa jadi baru diajukan atau sudah diterima komisi
                $query->where('status_komisi', 'diterima')
                    ->orWhere('status_komisi', 'direview');
            })
            ->with(['dosenPembimbing.user', 'seminars' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'distribusi', 'konsultasis' => function($query) {
                $query->where('diverifikasi', true);
            }, 'suratPengantar']) // Tambahkan suratPengantar
            ->orderBy('created_at', 'desc')
            ->first();

        $seminarTerkini = null;
        if ($pengajuanKpAktif && $pengajuanKpAktif->seminars->isNotEmpty()){
            $seminarTerkini = $pengajuanKpAktif->seminars->first();
        }

        $minKonsultasi = SeminarKpController::MIN_KONSULTASI_VERIFIED;

        // Logika untuk menentukan status ringkas dan aksi berikutnya
        $statusRingkas = "";
        $aksiBerikutnyaText = "";
        $aksiBerikutnyaRoute = "#";
        $pesanTambahan = "";

        if ($pengajuanKpAktif) {
            // KP Sudah Diajukan dan Diproses
            if ($pengajuanKpAktif->status_komisi == 'direview') {
                $statusRingkas = "Pengajuan KP Anda sedang direview oleh Komisi.";
                $aksiBerikutnyaText = "Lihat Detail Pengajuan";
                $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.index'); // Arahkan ke daftar KP
            } elseif ($pengajuanKpAktif->status_komisi == 'ditolak') {
                $statusRingkas = "Pengajuan KP Anda ditolak oleh Komisi.";
                $pesanTambahan = "Alasan: " . ($pengajuanKpAktif->alasan_tidak_layak ?: 'Tidak ada catatan.');
                $aksiBerikutnyaText = "Ajukan KP Baru";
                $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.create');
            } elseif ($pengajuanKpAktif->status_komisi == 'diterima') {
                if ($pengajuanKpAktif->status_kp == 'pengajuan') { // Baru diterima komisi, belum mulai proses
                    $statusRingkas = "Pengajuan KP Anda telah disetujui Komisi!";
                    $pesanTambahan = "Dosen Pembimbing: " . ($pengajuanKpAktif->dosenPembimbing->user->name ?? 'Segera ditentukan');
                    $aksiBerikutnyaText = "Mulai Konsultasi";
                    $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKpAktif->id);
                } elseif ($pengajuanKpAktif->status_kp == 'dalam_proses') {
                    $statusRingkas = "Anda sedang dalam proses Kerja Praktek.";
                    $pesanTambahan = "Konsultasi Terverifikasi: " . $pengajuanKpAktif->jumlah_konsultasi_verified . "/" . $minKonsultasi;

                    if ($seminarTerkini) {
                        if ($seminarTerkini->status_pengajuan == 'diajukan_mahasiswa') {
                            $statusRingkas = "Pengajuan seminar Anda sedang menunggu persetujuan Dosen Pembimbing.";
                            $aksiBerikutnyaText = "Lihat Status Seminar";
                            $aksiBerikutnyaRoute = route('mahasiswa.seminar.index');
                        } elseif ($seminarTerkini->status_pengajuan == 'disetujui_dospem') {
                            $statusRingkas = "Pengajuan seminar Anda disetujui Dospem, menunggu penjadwalan oleh Bapendik.";
                            $aksiBerikutnyaText = "Lihat Status Seminar";
                            $aksiBerikutnyaRoute = route('mahasiswa.seminar.index');
                        } elseif ($seminarTerkini->status_pengajuan == 'dijadwalkan_bapendik') {
                            $statusRingkas = "Seminar Anda telah dijadwalkan!";
                            $pesanTambahan = "Jadwal: " . \Carbon\Carbon::parse($seminarTerkini->tanggal_seminar)->isoFormat('dddd, D MMM YY') . ", Pukul " . \Carbon\Carbon::parse($seminarTerkini->jam_mulai)->format('H:i') . " di Ruang " . $seminarTerkini->ruangan;
                            $aksiBerikutnyaText = "Persiapkan Seminar";
                            $aksiBerikutnyaRoute = route('mahasiswa.seminar.index');
                        } elseif ($seminarTerkini->status_pengajuan == 'selesai_dinilai') {
                            if (!$pengajuanKpAktif->sudah_upload_bukti_distribusi) {
                                $statusRingkas = "Seminar Anda telah selesai dinilai.";
                                $pesanTambahan = "Silakan upload bukti distribusi laporan untuk melihat nilai.";
                                $aksiBerikutnyaText = "Upload Bukti Distribusi";
                                $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.distribusi.create', $pengajuanKpAktif->id);
                            } else {
                                $statusRingkas = "Proses KP hampir selesai!";
                                $pesanTambahan = "Nilai seminar sudah dapat dilihat. Bukti distribusi sudah diupload.";
                                $aksiBerikutnyaText = "Lihat Nilai Seminar";
                                $aksiBerikutnyaRoute = route('mahasiswa.seminar.index');
                            }
                        } elseif (in_array($seminarTerkini->status_pengajuan, ['ditolak_dospem', 'dibatalkan', 'revisi_jadwal_komisi'])) {
                            $statusRingkas = "Pengajuan Seminar Anda: " . ucfirst(str_replace('_',' ',$seminarTerkini->status_pengajuan));
                            $aksiBerikutnyaText = "Lihat Detail Seminar";
                            $aksiBerikutnyaRoute = route('mahasiswa.seminar.index');
                        }
                    } elseif ($pengajuanKpAktif->jumlah_konsultasi_verified >= $minKonsultasi && !$pengajuanKpAktif->has_active_seminar) {
                        $statusRingkas = "Anda sudah memenuhi syarat konsultasi untuk seminar.";
                        $aksiBerikutnyaText = "Ajukan Seminar KP";
                        $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.seminar.create', $pengajuanKpAktif->id);
                    } else {
                        $aksiBerikutnyaText = "Lanjutkan Konsultasi";
                        $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKpAktif->id);
                    }
                }
            }
        } else {
            // Tidak ada Pengajuan KP aktif, cek Surat Pengantar terakhir
            $suratPengantarTerakhir = SuratPengantar::where('mahasiswa_id', $mahasiswa->id)
                ->latest('tanggal_pengajuan')->first();
            if ($suratPengantarTerakhir) {
                if ($suratPengantarTerakhir->status_bapendik == 'menunggu') {
                    $statusRingkas = "Surat Pengantar Anda sedang divalidasi Bapendik.";
                    $aksiBerikutnyaText = "Lihat Status Surat Pengantar";
                    $aksiBerikutnyaRoute = route('mahasiswa.surat-pengantar.index');
                } elseif ($suratPengantarTerakhir->status_bapendik == 'disetujui') {
                    $statusRingkas = "Surat Pengantar Anda sudah disetujui Bapendik.";
                    $aksiBerikutnyaText = "Ajukan Kerja Praktek";
                    $aksiBerikutnyaRoute = route('mahasiswa.pengajuan-kp.create');
                } elseif ($suratPengantarTerakhir->status_bapendik == 'ditolak') {
                    $statusRingkas = "Surat Pengantar Anda ditolak.";
                    $pesanTambahan = "Alasan: " . ($suratPengantarTerakhir->catatan_bapendik ?: 'Tidak ada catatan.');
                    $aksiBerikutnyaText = "Ajukan Surat Pengantar Baru";
                    $aksiBerikutnyaRoute = route('mahasiswa.surat-pengantar.create');
                }
            } else {
                $statusRingkas = "Anda belum memulai proses Kerja Praktek.";
                $aksiBerikutnyaText = "Ajukan Surat Pengantar";
                $aksiBerikutnyaRoute = route('mahasiswa.surat-pengantar.create');
            }
        }


        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'pengajuanKpAktif',
            'seminarTerkini',
            'minKonsultasi',
            'statusRingkas',
            'aksiBerikutnyaText',
            'aksiBerikutnyaRoute',
            'pesanTambahan'
        ));
    }
//    public function index()
//    {
//        $user = Auth::user();
//        if (!$user || !$user->mahasiswa) {
//            return view('mahasiswa.dashboard')->withErrors(['profil_mahasiswa' => 'Profil mahasiswa tidak ditemukan.']);
//        }
//        $mahasiswa = $user->mahasiswa;
//
//        // Mengambil PengajuanKP yang paling relevan (aktif atau yang terakhir)
//        // Kita akan butuh relasi ke suratPengantar, seminars, konsultasis (verified), dan distribusi
//        $pengajuanKp = PengajuanKp::where('mahasiswa_id', $mahasiswa->id)
//            ->with([
//                'suratPengantar',
//                'dosenPembimbing.user',
//                'konsultasis' => function ($query) {
//                    $query->where('diverifikasi', true); // Hanya yang terverifikasi
//                },
//                'seminars' => function ($query) { // Ambil semua seminar terkait, urutkan terbaru
//                    $query->orderBy('created_at', 'desc');
//                },
//                'distribusi' // Relasi hasOne ke distribusi
//            ])
//            ->orderBy('created_at', 'desc') // Ambil yang terbaru jika ada banyak
//            ->first(); // Kita fokus pada satu pengajuan KP aktif/terbaru untuk timeline
//
//        $minKonsultasi = SeminarKpController::MIN_KONSULTASI_VERIFIED;
//        $seminarTerkini = null;
//        if ($pengajuanKp && $pengajuanKp->seminars->isNotEmpty()){
//            $seminarTerkini = $pengajuanKp->seminars->first();
//        }
//
//        // Data untuk card Quick Actions (bisa tetap)
//        // ...
//
//        return view('mahasiswa.dashboard', compact(
//            'mahasiswa',
//            'pengajuanKp', // Ini akan kita gunakan sebagai $pengajuanKP di viewmu
//            'seminarTerkini',
//            'minKonsultasi'
//        ));
//    }
}
