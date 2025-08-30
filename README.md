<p align="center">
  <a href="#">
    <img src="public/image/logo.png" alt="Ukire Logo" width="300">
  </a>
</p>

<h1 align="center">Ukire - E-commerce Furnitur Kayu Premium</h1>

<p align="center">
  Sebuah platform e-commerce modern yang dibangun dengan Laravel, Livewire, dan Filament, dirancang untuk pengalaman belanja furnitur pra-pesan yang premium dan eksklusif.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-3.x-4d52d1.svg?style=for-the-badge&logo=livewire" alt="Livewire">
  <img src="https://img.shields.io/badge/Filament-3.x-f59e0b.svg?style=for-the-badge&logo=filament" alt="Filament">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4.svg?style=for-the-badge&logo=php" alt="PHP">
</p>

---

## 📜 Tentang Proyek

**Ukire** adalah implementasi lengkap dari sebuah website e-commerce modern yang berfokus pada penjualan furnitur kayu dengan sistem pra-pesan. Proyek ini dibangun dari nol dengan filosofi "best practice", mengedepankan pengalaman pengguna (UI/UX) yang superior, baik untuk pelanggan di halaman depan maupun untuk admin di panel manajemen.

Aplikasi ini mencakup seluruh alur, mulai dari penjelajahan katalog, proses _checkout_ yang aman dengan integrasi _payment gateway_, hingga _dashboard_ personal untuk pelanggan dan panel admin yang sangat canggih untuk mengelola bisnis.

<br>

### ✨ Fitur Unggulan

**Frontend (Untuk Pelanggan):**

-   **Desain Imersif:** Landing page, navbar, dan footer dengan desain _clean_, modern, dan minimalis, lengkap dengan animasi halus.
-   **Katalog Interaktif:** Dibangun dengan Livewire untuk _filtering_, _sorting_, dan pencarian _real-time_ tanpa _reload_ halaman.
-   **Fitur "Quick View":** Modal _popup_ untuk melihat detail produk tanpa meninggalkan halaman katalog.
-   **Alur Checkout Profesional:** Layout bebas distraksi, formulir "floating label", dan integrasi penuh dengan Midtrans Snap.
-   **Pusat Akun Personal:** Dashboard, riwayat pesanan interaktif dengan linimasa visual, dan halaman profil yang terpoles.
-   **Fitur Lanjutan:** Keranjang belanja dengan _selective checkout_, unduh faktur PDF, dan tombol "Pesan Lagi".

**Backend (Untuk Admin):**

-   **Admin Panel Canggih:** Dibangun dengan Filament 3.x, menyediakan UI/UX manajemen yang superior.
-   **Dashboard BI Interaktif:** Dilengkapi _widget_ statistik, grafik penjualan, _pie chart_ kategori, dan filter rentang tanggal universal.
-   **Manajemen Data Hiper-Efisien:** Pencarian global, aksi cepat di tabel (misal: "Tandai Selesai"), aksi massal, dan manajemen gambar _drag-and-drop_.
-   **Wawasan Pelanggan 360°:** Halaman detail pengguna yang menampilkan statistik LTV (_Lifetime Value_) dan riwayat pesanan lengkap.
-   **Branding & Personalisasi:** Tema, logo, _favicon_, dan halaman _login_ kustom.

<br>

### 🛠️ Dibangun Dengan

-   **Backend:** Laravel 12, PHP 8.2+
-   **Frontend Interaktif:** Livewire 3, Alpine.js
-   **Admin Panel:** Filament 3
-   **Styling:** Tailwind CSS
-   **Database:** MySQL / PostgreSQL
-   **Fitur Utama:**
    -   `darryldecode/cart` - Manajemen Keranjang Belanja
    -   `midtrans/midtrans-php` - Integrasi Payment Gateway
    -   `barryvdh/laravel-dompdf` - Generate Faktur PDF

<br>

## 🚀 Memulai (Getting Started)

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah di bawah ini.

### Prasyarat

Pastikan Anda sudah menginstal:

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   Database (misal: MySQL, MariaDB)

### Instalasi

1.  **Clone repository ini:**

    ```bash
    git clone https://github.com/username/ukire-app.git
    cd ukire-app
    ```

2.  **Install dependensi PHP:**

    ```bash
    composer install
    ```

3.  **Install dependensi JavaScript:**

    ```bash
    npm install
    ```

4.  **Setup Environment File:**
    Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan konfigurasikan koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD), kredensial Midtrans, kredensial Google OAuth, dan kredensial Whatsapp.

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ukire_db
    DB_USERNAME=root
    DB_PASSWORD=

    MIDTRANS_CLIENT_KEY=...
    MIDTRANS_SERVER_KEY=...
    MIDTRANS_IS_PRODUCTION=false

    GOOGLE_CLIENT_ID=...
    GOOGLE_CLIENT_SECRET=...

    UKIRE_WHATSAPP_NUMBER=...
    UKIRE_WHATSAPP_MESSAGE=...
    ```

5.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Database:**
    Pastikan Anda sudah membuat _database_ `ukire_db`.

    ```bash
    php artisan migrate
    ```

7.  **Buat Storage Link:**

    ```bash
    php artisan storage:link
    ```

8.  **Jalankan Server:**
    Buka **dua jendela terminal**. - Di terminal pertama, jalankan Vite:
    `npm run dev` - Di terminal kedua, jalankan server Laravel:
    `php artisan serve`

        Aplikasi Anda sekarang berjalan di `https://127.0.0.1:8000`.

    <br>

## 🕹️ Penggunaan

### Akses Admin Panel

1.  Buat pengguna admin pertama Anda dengan menjalankan perintah ini dan ikuti petunjuknya:

    ```bash
    php artisan make:filament-user
    ```

2.  Buka admin panel di browser Anda:
    [https://127.0.0.1:8000/admin](https://127.0.0.1:8000/admin)

3.  Login menggunakan kredensial yang baru saja Anda buat.

---

Terima kasih telah menjelajahi proyek Ukire!
