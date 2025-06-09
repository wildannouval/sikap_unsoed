<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi milik pengguna yang login dengan pagination.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua notifikasi dengan pagination
        $notifications = $user->notifications()->paginate(15);

        // Saat halaman "Semua Notifikasi" dibuka, tandai semua yang belum dibaca sebagai sudah dibaca.
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca, lalu redirect ke URL tujuan notifikasi.
     */
    public function readAndRedirect(DatabaseNotification $notification)
    {
        // Otorisasi: pastikan notifikasi ini milik user yang sedang login
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        // Tandai sebagai sudah dibaca
        $notification->markAsRead();

        // Redirect ke URL yang ada di dalam data notifikasi
        // Jika tidak ada URL, redirect ke dashboard
        return redirect($notification->data['url'] ?? route('home'));
    }

    /**
     * Menandai semua notifikasi yang belum dibaca sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
