# SIMANTAP - Sistem Manajemen Inventaris Terpadu BMN

[![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**SIMANTAP** adalah aplikasi web untuk manajemen inventaris **Barang Milik Negara (BMN)** yang dibangun menggunakan Laravel. Aplikasi ini dirancang khusus untuk membantu pengelolaan aset dan inventaris di instansi pemerintah seperti **BPS (Badan Pusat Statistik)**.

![Dashboard Preview](public/images/dashboard-preview.png)

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi & Setup](#-instalasi--setup)
- [Konfigurasi Database](#-konfigurasi-database)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Akun Default](#-akun-default)
- [Struktur Folder](#-struktur-folder)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [Kontributor](#-kontributor)

---

## ✨ Fitur Utama

### 👨‍💼 Untuk Operator BMN (Admin)
- **Dashboard Analytics** - Statistik lengkap dengan grafik interaktif
- **Manajemen Barang** - CRUD barang dengan auto-generate kode & deteksi duplikat
- **Persetujuan Permintaan** - Approve/reject dengan partial approval
- **Stock Opname** - Pencatatan stok fisik dengan auto penyesuaian
- **Laporan** - Export ke Excel dan PDF dengan styling profesional
- **Manajemen Pengguna** - Kelola akun operator dan pegawai

### 👤 Untuk Pegawai
- **Daftar Barang** - Lihat katalog barang tersedia dengan sorting & filter
- **Ajukan Permintaan** - Request barang dengan validasi stok real-time
- **Batalkan Permintaan** - Batalkan pengajuan yang masih menunggu
- **Monitor Status** - Tracking status permintaan real-time
- **Edit Profil** - Update data diri dan foto profil

### 🔐 Keamanan
- **Role-based Access Control** - Operator vs Pegawai
- **Database Transaction** - Row locking untuk mencegah race condition
- **Snapshot Data** - Histori data pegawai saat pengajuan

### 🎨 UI/UX
- **Auto-dismiss Alerts** - Notifikasi otomatis hilang setelah beberapa detik
- **Responsive Design** - Tampilan optimal di desktop dan mobile
- **Modern Interface** - Gradient, badges, dan animasi smooth

---

## 🛠 Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **Laravel** | 9.x | PHP Framework |
| **PHP** | 8.0+ | Backend Language |
| **MySQL** | 8.0+ | Database |
| **Tailwind CSS** | 3.x | CSS Framework |
| **Jetstream** | 2.x | Authentication (Laravel Fortify) |
| **Livewire** | 2.x | Dynamic Components |
| **Flowbite** | 2.x | UI Component Library |
| **Alpine.js** | 3.x | Lightweight JS Framework |
| **PhpSpreadsheet** | 5.x | Export Excel |
| **Vite** | 4.x | Asset Bundler |

---

## 💻 Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut:

- **PHP** >= 8.0 dengan ekstensi:
  - BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, Zip
- **Composer** >= 2.0
- **Node.js** >= 18.x dan **NPM** >= 9.x
- **MySQL** >= 8.0 atau **MariaDB** >= 10.3
- **Git** (untuk cloning repository)

---

## 🚀 Instalasi & Setup

### 1️⃣ Clone Repository

```bash
# Clone repository dari GitHub
git clone https://github.com/evelynn-tan/simantap.git

# Masuk ke direktori project
cd simantap
```

### 2️⃣ Install Dependencies PHP

```bash
# Install dependencies menggunakan Composer
composer install
```

### 3️⃣ Install Dependencies JavaScript

```bash
# Install dependencies menggunakan NPM
npm install
```

### 4️⃣ Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5️⃣ Edit File `.env`

Buka file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME=SIMANTAP
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simantap
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄 Konfigurasi Database

### 1️⃣ Buat Database

Buat database baru di MySQL:

```sql
CREATE DATABASE simantap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau menggunakan phpMyAdmin:
1. Buka `http://localhost/phpmyadmin`
2. Klik **New** di sidebar kiri
3. Masukkan nama database: `simantap`
4. Pilih collation: `utf8mb4_unicode_ci`
5. Klik **Create**

### 2️⃣ Jalankan Migrasi

```bash
# Jalankan migrasi database
php artisan migrate
```

### 3️⃣ Jalankan Seeder

```bash
# Isi database dengan data awal
php artisan db:seed
```

Atau jalankan migrasi dan seeder sekaligus:

```bash
# Fresh migrate + seed (HATI-HATI: menghapus semua data!)
php artisan migrate:fresh --seed

# Buat symbolic link untuk storage (untuk upload foto)
php artisan storage:link
```

Output yang diharapkan:

```
╔══════════════════════════════════════════════════╗
║           SIMANTAP Database Seeder               ║
║    Sistem Manajemen Inventaris Terpadu BMN       ║
╚══════════════════════════════════════════════════╝

Cleaning existing data...
✓ All tables cleaned

Seeding Users, Operators, dan Pegawai...
  → Created 2 Operator accounts
  → Created 10 Pegawai accounts
✓ Users seeded successfully!

Seeding Kategori Barang...
✓ Created 32 Kategori

Seeding Barang Inventaris...
✓ Created 55 Barang dengan kode auto-generate

╔══════════════════════════════════════════════════╗
║              SEEDING COMPLETED!                  ║
╚══════════════════════════════════════════════════╝

📊 Database Summary:
   • Users     : 12 records
   • Operators : 2 records
   • Pegawai   : 10 records
   • Kategori  : 32 records
   • Barang    : 55 records

🔐 Login Credentials:
   Operator : operator1@bps.go.id / password
   Pegawai  : nabhan@bps.go.id / password
```

---

## ▶️ Menjalankan Aplikasi

### Development Mode

Buka **2 terminal** dan jalankan perintah berikut:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server (untuk hot reload CSS/JS):**
```bash
npm run dev
```

Buka browser dan akses: **http://localhost:8000**

### Production Build

```bash
# Build assets untuk production
npm run build

# Jalankan migrasi (PENTING: setiap kali pull update!)
php artisan migrate --force

# Optimasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

> ⚠️ **PENTING**: Setelah setiap `git pull`, WAJIB jalankan `php artisan migrate --force` untuk update database schema!

---

## 🔑 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

### Operator BMN (Admin)
| Email | Password | Akses |
|-------|----------|-------|
| `operator1@bps.go.id` | `password` | Full Admin |
| `operator2@bps.go.id` | `password` | Full Admin |

### Pegawai BPS
| Email | Password | Nama |
|-------|----------|------|
| `nabhan@bps.go.id` | `password` | Nabhan Athallah |
| `faruq@bps.go.id` | `password` | M. Faruq Hafidzullah |
| `danang@bps.go.id` | `password` | Danang Ivan Pangestu |
| `difya@bps.go.id` | `password` | Difya Ayu Meisya |
| `aulia@bps.go.id` | `password` | Aulia Ul Hasanah |
| `evelyn@bps.go.id` | `password` | Evelyn Tan Eldisha |
| `indri@bps.go.id` | `password` | Indri Putri Lestari |
| `bambang@bps.go.id` | `password` | Bambang Setiawan |
| `siti@bps.go.id` | `password` | Siti Marhaeni |
| `rudi@bps.go.id` | `password` | Rudi Hartono |

---

## 📁 Struktur Folder

```
simantap/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller untuk Operator
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── DataBarangController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── ManajemenPenggunaController.php
│   │   │   │   ├── ManajemenPermintaanController.php
│   │   │   │   └── StockOpnameController.php
│   │   │   └── Pegawai/        # Controller untuk Pegawai
│   │   │       ├── DashboardController.php
│   │   │       ├── PermintaanController.php
│   │   │       └── ProfilController.php
│   │   └── Middleware/
│   │       └── CheckRole.php   # Middleware role-based access
│   └── Models/                 # Eloquent Models
│       ├── User.php
│       ├── Pegawai.php
│       ├── Operator.php
│       ├── Kategori.php
│       ├── Barang.php
│       ├── Pengajuan.php
│       ├── PengajuanDetail.php
│       ├── Transaksi.php
│       ├── DetailRangging.php
│       ├── StockOpname.php
│       ├── StockOpnameDetail.php
│       └── Laporan.php
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
│       ├── DatabaseSeeder.php  # Master seeder
│       ├── UserSeeder.php      # Seeder untuk Users
│       ├── KategoriSeeder.php  # Seeder untuk Kategori
│       └── BarangSeeder.php    # Seeder untuk Barang
├── resources/
│   └── views/
│       ├── admin/              # Views untuk Operator
│       ├── pegawai/            # Views untuk Pegawai
│       ├── components/         # Blade components
│       └── layouts/            # Layout templates
├── routes/
│   └── web.php                 # Route definitions
└── public/                     # Public assets
```

---

## 📖 Panduan Penggunaan

### Login
1. Buka aplikasi di browser
2. Masukkan email dan password
3. Sistem akan redirect ke dashboard sesuai role

### Sebagai Operator
1. **Dashboard** - Lihat statistik dan permintaan terbaru
2. **Data Barang** - Tambah/edit/hapus barang inventaris
3. **Permintaan** - Approve atau reject permintaan pegawai
4. **Stock Opname** - Lakukan stock opname berkala
5. **Laporan** - Generate dan export laporan

### Sebagai Pegawai
1. **Dashboard** - Lihat barang yang sedang digunakan
2. **Daftar Barang** - Browse katalog dengan sorting (klik header kolom)
3. **Ajukan Permintaan** - Request barang, sistem cek stok tersedia
4. **Monitor Permintaan** - Cek status & batalkan jika masih menunggu
5. **Edit Profil** - Update data diri dan foto

---

## 🔧 Troubleshooting

### Error: SQLSTATE[HY000] Connection refused
```bash
# Pastikan MySQL sudah berjalan
# Cek konfigurasi DB_HOST, DB_PORT di file .env
```

### Error: Class not found
```bash
# Regenerate autoload
composer dump-autoload
```

### Error: Mix manifest not found
```bash
# Build ulang assets
npm run build
```

### Error: Permission denied (storage)
```bash
# Set permission storage folder
chmod -R 775 storage bootstrap/cache
```

---

## 👥 Kontributor

| Nama | Role | NIM |
|------|------|-----|
| Nabhan Athallah | Developer | 222313272 |
| M. Faruq Hafidzullah | Developer | 222313186 |
| Danang Ivan Pangestu | Developer | 222313036 |
| Evelyn Tan Eldisha N. | Developer | 222313067 |
| Difya Ayu Meisya N. | Developer | 222313049 |
| Aulia Ul Hasanah | Developer | 222313000 |

---


## 🙏 Acknowledgements

- [Laravel](https://laravel.com) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Jetstream](https://jetstream.laravel.com) - Authentication
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io) - Excel Export

---

**Made with ❤️ for BPS (Badan Pusat Statistik)**
