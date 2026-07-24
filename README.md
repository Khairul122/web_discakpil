# 🇮🇩 SI-IKM SMART — DISDUKCAPIL Kota Padang

> **Sistem Informasi Indeks Kepuasan Masyarakat (IKM) Berbasis Sistem Pendukung Keputusan (SPK) Metode SMART (Simple Multi-Attribute Rating Technique)**  
> *Dinas Kependudukan dan Pencatatan Sipil Kota Padang — Berdasarkan Standardisasi **Permenpan-RB Nomor 14 Tahun 2017***

---

## 📌 1. Deskripsi Proyek

**SI-IKM SMART** adalah platform berbasis web murni (PHP Native MVC) yang dikembangkan khusus untuk **Dinas Kependudukan dan Pencatatan Sipil (DISDUKCAPIL) Kota Padang**. Aplikasi ini berfungsi untuk mengukur, menganalisis, dan mengevaluasi Indeks Kepuasan Masyarakat (IKM) terhadap layanan kependudukan secara digital dan otomatis menggunakan algoritma **SMART (Simple Multi-Attribute Rating Technique)**.

Aplikasi ini memfasilitasi survei kepuasan bagi masyarakat umum, pengolahan data kriteria dan sub-kriteria dinamis oleh administrator, serta pembuatan laporan berstandar formal (PDF/Cetak Landscape F4) ber-Kop Surat resmi Kementerian Dalam Negeri/Disdukcapil untuk pimpinan instansi.

---

## 🛠️ 2. Fitur Utama Sistem

*   **📋 Pengisian Kuesioner Publik Interaktif**: Halaman survei interaktif yang ramah pengguna (user-friendly) untuk mengumpulkan umpan balik masyarakat mengenai 5 layanan kependudukan (KTP-el, KK, KIA, Akta Lahir, Surat Pindah).
*   **🧮 Engine Evaluasi Metode SMART**: Algoritma perhitungan terpusat yang menormalisasi bobot kriteria, menghitung nilai utilitas sub-kriteria, dan merangkum skor akhir IKM untuk setiap alternatif layanan.
*   **📊 Dashboard Statistik Multi-Role**:
    *   **Administrator**: Panel administrasi lengkap untuk manajemen data master kriteria, sub-kriteria, alternatif layanan, responden, matriks penilaian, dan hasil SMART.
    *   **Kepala Dinas (Eksekutif)**: Panel eksekutif ringkas khusus pemantauan indikator kinerja utama IKM dan cetak laporan resmi.
*   **✒️ Pengaturan TTD & Laporan Dinamis**: Sistem fleksibel untuk memperbarui Nama dan NIP Penandatangan Laporan (Kepala Dinas & Petugas) langsung melalui database.
*   **🖨️ Cetak PDF Formal (F4 Landscape)**: Menghasilkan dokumen cetak resmi berpresisi tinggi dengan Kop Surat dinas, tabel formal, dan logo kementerian menggunakan TCPDF.
*   **🔔 Dialog Box Interaktif SweetAlert2**: Proteksi aksi hapus/keluar serta notifikasi flash session yang elegan.

---

## 🧮 3. Metodologi SMART (Simple Multi-Attribute Rating Technique)

Sistem mengimplementasikan metode SMART dengan tahapan matematis sebagai berikut:

1. **Normalisasi Bobot Kriteria ($w_j$)**:
   $$w_j = \frac{W_j}{\sum_{i=1}^{m} W_i}$$
   *(Mengubah bobot kriteria menjadi proporsi terimbang dengan total $\sum w_j = 1.0$)*

2. **Nilai Utility Sub-Kriteria ($u_j$)**:
   Konversi skala kepuasan Likert 4 tingkat ke rentang $[0 - 100]$:
   - **Sangat Baik / Sangat Sesuai**: Utility $100$
   - **Baik / Sesuai**: Utility $75$
   - **Cukup Baik / Cukup Sesuai**: Utility $50$
   - **Kurang Baik / Tidak Sesuai**: Utility $25$

3. **Perhitungan Nilai Akhir SMART ($V(A_i)$)**:
   $$V(A_i) = \sum_{j=1}^{m} (w_j \times u_j(A_i))$$

4. **Kategori Mutu Pelayanan (IKM)**:
   - $80.00 - 100.00$ : **Sangat Baik** (Mutu A)
   - $60.00 - 79.99$ : **Baik** (Mutu B)
   - $40.00 - 59.99$ : **Cukup** (Mutu C)
   - $20.00 - 39.99$ : **Kurang** (Mutu D)

---

## 🏗️ 4. Arsitektur & Tech Stack

| Layer | Teknologi / Pustaka |
| :--- | :--- |
| **Core Backend** | PHP Native (OOP & MVC Pattern) |
| **Database** | MySQL / MariaDB (PDO Handler dengan Prepared Statements) |
| **Styling UI** | Tailwind CSS v3.4 (dikompilasi dari `assets/css/tailwind-input.css`) |
| **Interactive UI** | SweetAlert2, Chart.js, FontAwesome v6, Feather Icons |
| **PDF Generator** | TCPDF v6.10 (`tecnickcom/tcpdf`) |

---

## 🔐 5. Kredensial Login Default

| Role | Username | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `admin123` | Akses penuh (Master Data, Responden, Penilaian, Hasil SMART, Cetak Laporan) |
| **Kepala Dinas** | `kadis` | `admin123` | Akses eksekutif (Dashboard IKM, Data Penilaian Read-Only, & Cetak Laporan PDF) |

---

## 📂 6. Struktur Direktori Proyek

```
web_discakpil/
├── assets/                 # Aset Frontend (Compiled CSS, Images, JS)
│   ├── css/                # Style kompilasi Tailwind CSS (app.css)
│   └── images/             # Berkas logo & aset grafis
├── config/                 # Konfigurasi Inti Aplikasi
│   └── koneksi.php         # PDO Database Connection Handler
├── controllers/            # Controller Layer (MVC)
│   ├── AdminController.php
│   ├── AlternatifController.php
│   ├── AuthController.php
│   ├── CetakController.php
│   ├── HasilController.php
│   ├── KepalaDinasController.php
│   ├── KriteriaController.php
│   ├── LandingController.php
│   ├── PenilaianController.php
│   ├── PenilaianKuesionerController.php
│   ├── RespondenController.php
│   └── SubKriteriaController.php
├── database/               # SQL Schema & Dump Data
│   └── db_disdukcapil_smart (2).sql
├── docs/                   # Dokumentasi Teknis Per Modul
├── models/                 # Model & Engine Logic (MVC)
│   ├── AlternatifModel.php
│   ├── AuthModel.php
│   ├── DashboardModel.php
│   ├── HasilModel.php
│   ├── KriteriaModel.php
│   ├── LaporanModel.php
│   ├── PdfHelper.php       # Generator Laporan PDF Formal
│   ├── PenilaianModel.php
│   ├── RespondenModel.php
│   ├── SmartCalculator.php # Engine Kalkulasi SPK SMART
│   └── SubKriteriaModel.php
├── template/               # Layout Shell Templates
│   ├── layout_admin_chrome.php # Admin Sidebar & Navigation
│   ├── layout_admin_head.php / foot.php
│   └── layout_public_head.php / foot.php
├── views/                  # View Templates (MVC)
├── index.php               # Front Controller Entrypoint
├── package.json            # NPM Build Scripts (Tailwind CSS)
├── composer.json           # Composer Dependencies (TCPDF)
├── studi.md                # Dokumentasi Perhitungan Manual SMART
├── transfer_knowledge.md   # Panduan Transfer Knowledge Developer
└── README.md               # Berkas Dokumentasi Resmi
```

---

## 💻 7. Cara Instalasi & Menjalankan Aplikasi

### Persyaratan Sistem:
- **PHP** >= 8.0 (Direkomendasikan PHP 8.1 / 8.2 / 8.3)
- **MySQL / MariaDB**
- **Composer** (Manajemen dependensi backend)
- **Node.js & npm** (Kompilasi Tailwind CSS)
- **Laragon / XAMPP** (Web Server Lokal)

### Langkah Penyiapan:

1. **Salin Repository Proyek**:
   Letakkan folder proyek di direktori root server lokal Anda:
   - Laragon: `C:\laragon\www\web_discakpil`
   - XAMPP: `C:\xampp\htdocs\web_discakpil`

2. **Impor Database**:
   - Buat database baru bernama `db_disdukcapil_smart` pada PHPMyAdmin.
   - Impor berkas SQL dari folder [database/db_disdukcapil_smart (2).sql](file:///c:/laragon/www/web_discakpil/database/db_disdukcapil_smart%20%282%29.sql).

3. **Instal Dependensi Backend (Composer)**:
   Jalankan perintah berikut di terminal folder proyek:
   ```bash
   composer install
   ```

4. **Kompilasi Assets Frontend (Tailwind CSS)**:
   ```bash
   npm install
   npm run build:css
   ```

5. **Akses Aplikasi**:
   - **Landing Page Publik**: `http://localhost/web_discakpil/`
   - **Halaman Login**: `http://localhost/web_discakpil/index.php?controller=auth&action=index`

---

## 👥 Layanan Dukungan Teknis

Jika Anda membutuhkan bantuan teknis atau pengembangan lebih lanjut, silakan hubungi tim pengembang:

- ✉️ **Email Support**: [synectra24@gmail.com](mailto:synectra24@gmail.com)
- 📞 **WhatsApp Support**: [+62 888-0737-6359](https://wa.me/6288807376359)

---

## 📜 Lisensi & Hak Cipta

Aplikasi ini dikembangkan dan didistribusikan secara resmi di bawah lisensi:

### 📄 MIT License
Hak Cipta &copy; 2026 **Dinas Kependudukan dan Pencatatan Sipil Kota Padang & Synectra Jasa Digital**.
