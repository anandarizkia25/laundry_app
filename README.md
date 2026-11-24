# 🧺 Laundry Express — Sistem Informasi Manajemen Laundry Berbasis Web

**Laundry Express** adalah aplikasi sistem informasi manajemen laundry berbasis web yang dibangun menggunakan **Laravel**. Aplikasi ini dirancang untuk memudahkan pengelolaan paket layanan laundry, pencatatan transaksi masuk, pemantauan status pengerjaan cucian, serta rekapitulasi pendapatan secara terstruktur.

---

## ✨ Fitur Utama

### 1. Halaman Pelanggan (Pemesanan Laundry)
* **Filter Kategori Layanan:** Menyaring paket layanan berdasarkan kategori (**Semua Layanan**, **Reguler**, **Express**, dan **SuperKilat**).
* **Input Pemesanan Mandiri:** Formulir pengisian identitas pemesan (**Nama Lengkap** dan **Nomor WhatsApp**) serta pemilihan kuantitas (`Kg` / `Pcs`) dari berbagai jenis layanan sekaligus dalam satu transaksi.

### 2. Dashboard Admin (Rekap Transaksi & Status Cucian)
* **Monitoring Pesanan Masuk:** Menampilkan seluruh transaksi pelanggan lengkap dengan rincian layanan yang dipesan (relasi tabel `orders`, `order_details`, dan `services`).
* **Pembaruan Status Pengerjaan:** Memperbarui progres pesanan secara bertahap mulai dari **Transaksi Masuk** $\rightarrow$ **Proses** $\rightarrow$ **Selesai**.
* **Rekap Total Biaya:** Menghitung otomatis total tagihan setiap pesanan sebagai dasar laporan pendapatan usaha.

### 3. Manajemen Data Layanan (CRUD Services)
* **Create:** Menambahkan paket layanan baru lengkap dengan gambar, nama paket, kategori (*Reguler*, *Express*, *SuperKilat*), dan tarif harga (`/ Kg` atau `/ Pcs`).
* **Read:** Menampilkan daftar seluruh paket layanan beserta tarifnya.
* **Update:** Mengubah informasi layanan, foto, kategori, maupun harga.
* **Delete:** Menghapus layanan yang sudah tidak tersedia.

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 12 (PHP 8.2+)
* **Frontend:** Blade Templating, Tailwind CSS, Vite
* **Database:** SQLite / MySQL

---

## 🗄️ Struktur Database

Aplikasi ini menggunakan 4 tabel utama yang saling berelasi:
1. **`users`**: Menyimpan data akun pengguna beserta kolom `role` (`admin` dan `user`).
2. **`services`**: Menyimpan master data jenis layanan laundry, kategori, tarif harga, dan gambar layanan.
3. **`orders`**: Menyimpan data induk transaksi (nama pelanggan, nomor WhatsApp, total harga, dan status pesanan).
4. **`order_details`**: Tabel penghubung (*Foreign Key* `order_id` dan `service_id`) yang mencatat rincian layanan serta jumlah kuantitas yang dipesan pada tiap transaksi.

---

## 🚀 Cara Instalasi & Menjalankan Project

1. **Clone repository ini**
   ```bash
   git clone [https://github.com/username-kamu/laundry_ananda.git](https://github.com/username-kamu/laundry_ananda.git)
   cd laundry_ananda
