# SIKAP - Sistem Informasi Kerja Praktek

<p align="center">
  <img src="public/images/logo_unsoed.png" alt="Logo SIKAP" width="150"/>
</p>

<p align="center">
  Aplikasi web untuk mengelola dan memfasilitasi seluruh alur proses Kerja Praktek (KP) mahasiswa di Fakultas Teknik.
</p>

---

## ✨ Fitur Utama

-   **Manajemen Multi-Peran:** Sistem otentikasi dan otorisasi dengan 4 peran utama: Mahasiswa, Dosen (Pembimbing & Komisi), dan Bapendik.
-   **Dashboard Informatif:** Setiap peran memiliki dashboard sendiri yang menyoroti tugas mendesak dan statistik kunci.
-   **Alur Kerja KP End-to-End:** Mengelola seluruh proses, mulai dari pengajuan surat pengantar, pengajuan KP, bimbingan, pengajuan seminar, penjadwalan, penilaian, hingga distribusi laporan akhir.
-   **Notifikasi In-App:** Sistem notifikasi berbasis database untuk memberitahu pengguna tentang pembaruan status atau tugas yang memerlukan tindakan.
-   **Manajemen Data Master:** Antarmuka CRUD yang konsisten untuk Bapendik mengelola data penting seperti Jurusan, Pengguna, dan Ruangan Seminar.
-   **Export Dokumen:** Kemampuan untuk men-generate dokumen resmi (Surat Pengantar, SPK, Berita Acara) dalam format `.docx`.
-   **Tampilan Modern & Responsif:** Dibangun dengan Laravel, Vite, Tailwind CSS, dan Flowbite untuk pengalaman pengguna yang bersih, modern, dan dapat diakses di berbagai perangkat.
-   **Dark Mode:** Pilihan tema gelap dan terang untuk kenyamanan pengguna.

---

## 🚀 Instalasi & Setup Proyek

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan development.

### Prasyarat
- PHP 8.3 atau lebih tinggi
- Composer
- Node.js & NPM (atau Yarn)
- Database Server (MySQL direkomendasikan)

### Langkah-langkah Instalasi
1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username/sikap-project.git](https://github.com/username/sikap-project.git)
    cd sikap-project
    ```

2.  **Instal Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Instal Dependensi JavaScript**
    ```bash
    npm install
    ```

4.  **Setup File `.env`**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan konfigurasikan koneksi database-mu:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sikap_unsoed
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi dan Seeder**
    Perintah ini akan membuat semua tabel di database dan mengisinya dengan data demo yang sudah disiapkan.
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan Server Development**
    - Buka satu terminal dan jalankan server Vite untuk kompilasi aset front-end:
        ```bash
        npm run dev
        ```
    - Buka terminal kedua dan jalankan server Laravel:
        ```bash
        php artisan serve
        ```
    Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

---

## 🔑 Akun Demo

Setelah menjalankan seeder, kamu bisa login menggunakan akun-akun berikut. **Password untuk semua akun adalah `password`**.

-   **Bapendik:** `bapendik@sikap.test`
-   **Dosen Komisi:** `komisi@sikap.test`
-   **Dosen Pembimbing:** `dospem@sikap.test`
-   **Mahasiswa (dengan alur aktif):** `mahasiswa@sikap.test`
-   **Mahasiswa (baru, belum ada alur):** `mahasiswabaru@sikap.test`

---

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan tumpukan teknologi modern, antara lain:
-   **Backend:** Laravel 12
-   **Frontend:** Vite, Tailwind CSS, Alpine.js
-   **UI Components:** Flowbite
-   **Database:** MySQL
-   **Export Dokumen:** `phpoffice/phpword`

---

## 📖 Alur Status Utama

Aplikasi ini menggunakan beberapa status kunci untuk melacak progres.

#### Status Pengajuan KP (`pengajuan_kps.status_kp`)
1.  `pengajuan`
2.  `dalam_proses`
3.  `lulus`
4.  `tidak_lulus`

#### Status Seminar (`seminars.status_pengajuan`)
1.  `diajukan_mahasiswa`
2.  `disetujui_dospem`
3.  `ditolak_dospem`
4.  `revisi_dospem`
5.  `dijadwalkan_bapendik`
6.  `revisi_jadwal_bapendik`
7.  `dibatalkan`
8.  `selesai_dinilai`

---

## 📄 Lisensi & Copyright

Aplikasi ini merupakan bagian dari pemenuhan Tugas Akhir.

**Copyright © 2025 - Wildan Nouval Rizki (H1D021017)**

Dibuat sebagai bagian dari program studi Informatika, Fakultas Teknik, Universitas Jenderal Soedirman. Seluruh hak cipta dilindungi.
