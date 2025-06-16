# SIKAP - Sistem Informasi Kerja Praktek

<p align="center">
  <img src="public/images/logo_unsoed.png" alt="Logo SIKAP" width="150"/>
</p>

<p align="center">
  Aplikasi web komprehensif untuk mengelola dan memfasilitasi seluruh alur proses Kerja Praktek (KP) mahasiswa di Fakultas Teknik, Universitas Jenderal Soedirman.
</p>

---

## ✨ Fitur Utama

Aplikasi ini dirancang dengan serangkaian fitur yang kuat untuk melayani kebutuhan semua peran yang terlibat dalam proses Kerja Praktek.

-   **Manajemen Multi-Peran:** Sistem otentikasi dan otorisasi dengan 4 peran utama: **Mahasiswa**, **Dosen Pembimbing**, **Dosen Komisi**, dan **Bapendik**, masing-masing dengan hak akses yang terdefinisi dengan jelas.
-   **Dasbor yang Informatif & Modern:** Setiap peran memiliki dasbor yang dirancang khusus untuk menyoroti tugas mendesak, statistik kunci, dan aktivitas terbaru, memastikan pengguna dapat langsung fokus pada hal yang paling penting.
-   **Alur Kerja KP End-to-End:** Mengelola seluruh proses secara digital, mulai dari pengajuan surat pengantar, validasi proposal KP, penunjukan dosen pembimbing, bimbingan konsultasi, pengajuan dan penjadwalan seminar, proses penilaian, hingga pengumpulan laporan akhir.
-   **Notifikasi In-App Real-time:** Sistem notifikasi berbasis database untuk memberitahu pengguna secara proaktif tentang pembaruan status atau tugas yang memerlukan tindakan mereka, lengkap dengan link langsung ke halaman terkait.
-   **Manajemen Data Master Terpusat:** Antarmuka CRUD (Create, Read, Update, Delete) yang konsisten dan aman untuk Bapendik mengelola data penting seperti Jurusan, Pengguna (Mahasiswa & Dosen), dan Ruangan Seminar.
-   **Ekspor Dokumen & Laporan:**
    - Kemampuan untuk men-generate dokumen resmi (Surat Pengantar, SPK, Berita Acara) dalam format `.docx` menggunakan template.
    - Fitur ekspor laporan data KP ke Excel dengan fungsionalitas filter yang kuat.
-   **Antarmuka Modern & Responsif:** Dibangun dengan tumpukan teknologi modern (Laravel, Vite, Tailwind CSS, Flowbite) untuk pengalaman pengguna yang bersih, cepat, dan dapat diakses dengan baik di berbagai perangkat.
-   **Personalisasi Pengguna:** Termasuk fitur manajemen profil lengkap dengan kemampuan untuk mengunggah, mengubah, dan menghapus foto profil, serta pilihan tema gelap dan terang (Dark Mode) untuk kenyamanan visual.

---

## 🛠️ Teknologi & Arsitektur

Aplikasi ini dibangun menggunakan tumpukan teknologi modern yang berfokus pada kecepatan, keamanan, dan kemudahan pemeliharaan.

-   **Backend:** **Laravel 12**, menyediakan fondasi MVC yang kuat, keamanan bawaan, dan ekosistem yang kaya.
-   **Frontend:** **Vite** untuk *asset bundling* yang sangat cepat, **Tailwind CSS** untuk *styling* dengan pendekatan *utility-first*, dan **Alpine.js** untuk interaktivitas ringan.
-   **UI Components:** **Flowbite**, digunakan untuk komponen UI interaktif seperti modal, dropdown, dan tab, mempercepat pengembangan antarmuka yang konsisten.
-   **Database:** **MySQL**, sebagai sistem manajemen database relasional yang andal.
-   **Export Dokumen:** `phpoffice/phpword` untuk generate file `.docx` dan `maatwebsite/excel` untuk ekspor ke `.xlsx`.

Arsitektur aplikasi ini didasarkan pada **Role-Based Access Control (RBAC)** yang ketat, diimplementasikan melalui middleware kustom (`CheckRole`, `CheckIsKomisi`) untuk melindungi setiap rute.

---

## 🚀 Instalasi & Setup Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan development.

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer 2.x
- Node.js 20.x & NPM
- Database Server (MySQL direkomendasikan)

### Langkah-langkah Instalasi
1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORY_ANDA] sikap-project
    cd sikap-project
    ```

2.  **Instal Dependensi PHP & JavaScript**
    ```bash
    composer install
    npm install
    ```

3.  **Setup File Lingkungan `.env`**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan konfigurasikan koneksi database Anda. Pastikan nama database sudah dibuat di server database Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sikap_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Kunci Aplikasi & Buat Storage Link**
    ```bash
    php artisan key:generate
    php artisan storage:link
    ```

5.  **Jalankan Migrasi dan Seeder**
    Perintah ini akan membuat semua tabel di database dan mengisinya dengan data demo yang sudah disiapkan untuk pengujian.
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Jalankan Server Development**
    - Buka satu terminal dan jalankan server Vite:
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

Setelah menjalankan seeder, Anda bisa login menggunakan akun-akun berikut untuk mendemokan atau menguji setiap alur kerja. **Password untuk semua akun adalah `password`**.

| Peran | Nama | Email (Username) | Skenario Penggunaan |
| :--- | :--- | :--- | :--- |
| **Bapendik** | Admin Bapendik | `bapendik@sikap.test` | Mengelola semua data master dan alur kerja administratif (validasi surat, penjadwalan, dll.). |
| **Dosen Komisi**| Dr. Dosen Komisi | `komisi@sikap.test` | Mendemokan proses validasi pengajuan KP dari mahasiswa dan penunjukan Dosen Pembimbing. |
| **Dosen Pembimbing**| Dr. Dosen Pembimbing| `dospem@sikap.test` | Mendemokan proses bimbingan, verifikasi konsultasi, persetujuan seminar, dan penilaian. |
| **Mahasiswa Utama**| Mahasiswa Demo | `mahasiswa@sikap.test`| Mahasiswa dengan alur KP yang sudah berjalan, siap untuk mengajukan seminar atau tugas tahap lanjut. |
| **Mahasiswa Baru**| Mahasiswa Baru | `mahasiswabaru@sikap.test`| Mahasiswa yang belum memiliki riwayat KP, cocok untuk mendemokan alur dari nol. |

---

## 🚢 Alur Deployment ke Server

Proses deployment ke server VPS (Ubuntu 24.04) melibatkan langkah-langkah berikut:
1.  **Persiapan Server**: Update server & buat user baru non-root.
2.  **Instalasi Stack LEMP**: Nginx, MySQL, PHP 8.3 beserta ekstensinya.
3.  **Instalasi Alat Bantu**: Composer, Git, Node.js & NPM.
4.  **Konfigurasi Server**: Buat database & user MySQL, konfigurasikan Nginx server block.
5.  **Deploy Aplikasi**:
    - `git clone` repository ke `/var/www/nama-folder`.
    - Atur hak akses folder.
    - `composer install --no-dev`.
    - `npm install` & `npm run build`.
    - Konfigurasi file `.env` produksi.
    - `php artisan migrate --force`.
    - `php artisan optimize:clear` dan cache ulang (`config:cache`, `route:cache`, `view:cache`).
6.  **Instalasi SSL**: Mengamankan domain dengan Sertifikat SSL gratis menggunakan Certbot & Let's Encrypt.

Untuk update aplikasi yang sudah live, gunakan alur `php artisan down`, `git pull`, dan seterusnya seperti yang pernah kita diskusikan.

---

## 💡 Pengembangan Lanjutan

Aplikasi ini memiliki fondasi yang kuat untuk dikembangkan lebih lanjut. Beberapa area yang bisa dieksplorasi:
-   **Refactoring**: Memindahkan logika bisnis dari controller ke *Service Class* untuk meningkatkan keterbacaan dan kemudahan pengujian.
-   **Blade Components**: Mengabstraksi elemen UI yang berulang (tombol, input) untuk efisiensi dan konsistensi.
-   **Pengujian Otomatis (Automated Testing)**: Membuat *Feature Test* dengan Pest atau PHPUnit untuk memastikan stabilitas aplikasi dalam jangka panjang.
-   **CI/CD**: Mengimplementasikan alur kerja otomatis dengan GitHub Actions untuk proses deployment yang lebih cepat dan andal.

---

## 📄 Lisensi & Copyright

Aplikasi ini merupakan bagian dari pemenuhan Tugas Akhir.

**Copyright © 2025 - Wildan Nouval Rizki (H1D021017)**

Dibuat sebagai bagian dari program studi Informatika, Fakultas Teknik, Universitas Jenderal Soedirman. Seluruh hak cipta dilindungi.
