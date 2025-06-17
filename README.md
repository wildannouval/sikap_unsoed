# SIKAP - Sistem Informasi Kerja Praktek

<p align="center">
  <a href="#">
    <img src="public/images/logo_unsoed.png" alt="Logo SIKAP" width="150"/>
  </a>
</p>

<p align="center">
  Aplikasi web komprehensif untuk mengelola dan memfasilitasi seluruh alur proses Kerja Praktek (KP) mahasiswa di lingkungan Fakultas Teknik, Universitas Jenderal Soedirman.
</p>

---

## ✨ Fitur Utama

Aplikasi ini dirancang dengan serangkaian fitur yang kuat untuk melayani kebutuhan semua peran yang terlibat dalam proses Kerja Praktek.

-   **Manajemen Multi-Peran:** Sistem otentikasi dan otorisasi dengan 3 peran utama (4 jika dosen dipecah): **Mahasiswa**, **Dosen (Pembimbing & Komisi)**, dan **Bapendik**. Setiap peran memiliki hak akses dan dasbor yang terdefinisi dengan jelas.

-   **Alur Kerja KP End-to-End:** Mengelola seluruh proses secara digital, mulai dari pengajuan surat pengantar, validasi proposal KP, penunjukan dosen pembimbing, bimbingan konsultasi, pengajuan dan penjadwalan seminar, proses penilaian, hingga pengumpulan laporan akhir.

-   **Dasbor Informatif & Modern:** Setiap peran disajikan dengan dasbor yang dirancang khusus untuk menyoroti tugas mendesak, wawasan data melalui grafik, dan feed aktivitas terbaru, memastikan pengguna dapat langsung fokus pada hal yang paling penting.

-   **Notifikasi In-App:** Sistem notifikasi berbasis database yang proaktif untuk memberitahu pengguna tentang pembaruan status atau tugas yang memerlukan tindakan mereka, lengkap dengan link langsung ke halaman terkait.

-   **Manajemen Data Master:** Antarmuka CRUD (Create, Read, Update, Delete) yang konsisten dan aman untuk Bapendik mengelola data penting seperti Jurusan, Pengguna, dan Ruangan Seminar.

-   **Ekspor Dokumen & Laporan:**
    -   Kemampuan untuk men-generate dokumen resmi (Surat Pengantar, SPK) dalam format `.docx` menggunakan template.
    -   Pusat laporan terdedikasi dengan fitur filter untuk mengekspor rekapitulasi data KP ke format Excel.

-   **Antarmuka Modern & Responsif:** Dibangun dengan tumpukan teknologi modern untuk pengalaman pengguna yang bersih dan dapat diakses dengan baik di berbagai perangkat.

-   **Personalisasi Pengguna:** Termasuk fitur manajemen profil lengkap dengan kemampuan untuk mengunggah, mengubah, dan menghapus foto profil, serta pilihan tema gelap dan terang (Dark Mode).

---

## 🛠️ Teknologi & Arsitektur

Aplikasi ini dibangun menggunakan tumpukan teknologi modern yang berfokus pada kecepatan, keamanan, dan kemudahan pemeliharaan.

-   **Backend:** **Laravel 12**, menyediakan fondasi MVC yang kuat, keamanan bawaan, dan ekosistem yang kaya.
-   **Frontend:** **Vite** untuk *asset bundling* yang sangat cepat, **Tailwind CSS** untuk *styling* dengan pendekatan *utility-first*.
-   **UI Components & Interactivity:** **Flowbite** untuk komponen UI interaktif (modal, dropdown) dan **Alpine.js** untuk interaktivitas ringan.
-   **Database:** **MySQL**, sebagai sistem manajemen database relasional yang andal.
-   **Export Dokumen:** `phpoffice/phpword` untuk generate file `.docx` dan `maatwebsite/excel` untuk ekspor ke `.xlsx`.

Arsitektur aplikasi ini didasarkan pada **Role-Based Access Control (RBAC)** yang ketat, diimplementasikan melalui middleware kustom (`CheckRole`, `CheckIsKomisi`) untuk melindungi setiap rute.

---

## 🚀 Instalasi & Setup Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan development.

### Prasyarat
-   PHP 8.2 atau lebih tinggi
-   Composer 2.x
-   Node.js 20.x & NPM
-   Database Server (MySQL direkomendasikan)

### Langkah-langkah Instalasi
1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/wildan-rizki/sikap-project.git](https://github.com/wildan-rizki/sikap-project.git) # cd sikap-project
    ```

2.  **Instal Dependensi PHP & JavaScript**
    ```bash
    composer install
    npm install
    ```

3.  **Setup File `.env`**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan konfigurasikan koneksi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sikap_db # Pastikan database ini sudah dibuat
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Kunci Aplikasi & Storage Link**
    ```bash
    php artisan key:generate
    php artisan storage:link
    ```

5.  **Jalankan Migrasi dan Seeder**
    Perintah ini akan membuat semua tabel di database dan mengisinya dengan data demo yang sudah disiapkan.
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Jalankan Server Development**
    -   Buka satu terminal dan jalankan server Vite untuk kompilasi aset front-end:
        ```bash
        npm run dev
        ```
    -   Buka terminal kedua dan jalankan server Laravel:
        ```bash
        php artisan serve
        ```
    Aplikasi sekarang dapat diakses di `http://127.0.0.1:8000`.

---

## 🔑 Akun Demo

Setelah menjalankan seeder, Anda bisa login menggunakan akun-akun berikut. **Password untuk semua akun adalah `password`**.

| Peran | Nama | Email (Username) | Skenario Penggunaan |
| :--- | :--- | :--- | :--- |
| **Bapendik** | Admin Bapendik | `bapendik@sikap.test` | Mengelola semua data master dan alur kerja administratif. |
| **Dosen Komisi**| Dr. Dosen Komisi | `komisi@sikap.test` | Mendemokan proses validasi pengajuan KP. |
| **Dosen Pembimbing**| Dr. Dosen Pembimbing| `dospem@sikap.test` | Mendemokan proses bimbingan, persetujuan seminar, dan penilaian. |
| **Mahasiswa Utama**| Mahasiswa Demo | `mahasiswa@sikap.test`| Mahasiswa dengan alur KP yang sudah berjalan, siap untuk mengajukan seminar. |
| **Mahasiswa Baru**| Mahasiswa Baru | `mahasiswabaru@sikap.test`| Mahasiswa yang belum memiliki riwayat KP, untuk demo dari nol. |

---

## 🚢 Alur Deployment

Aplikasi ini siap di-deploy ke server VPS (Ubuntu 24.04 LTS direkomendasikan) dengan stack LEMP (Linux, Nginx, MySQL, PHP 8.3). Proses deployment dapat dilakukan secara manual atau otomatis.

-   **Deployment Manual**: Melibatkan serangkaian langkah di server: persiapan server, instalasi stack LEMP & tools (Composer, Git, Node.js), konfigurasi Nginx, dan deployment kode (`git pull`, `composer install`, `npm run build`, `artisan migrate`, `artisan cache`, dll).
-   **Deployment Otomatis (CI/CD)**: Metode yang direkomendasikan untuk update. Menggunakan **GitHub Actions**, seluruh proses manual di atas dapat diotomatisasi yang dipicu oleh `git push` ke branch `main`.

---

## 📄 Lisensi & Copyright

Aplikasi ini merupakan bagian dari pemenuhan Tugas Akhir.

**Copyright © 2025 - Wildan Nouval Rizki (H1D021017)**

Dibuat sebagai bagian dari program studi Informatika, Fakultas Teknik, Universitas Jenderal Soedirman. Seluruh hak cipta dilindungi.
