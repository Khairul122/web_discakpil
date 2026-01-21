# Dashboard Admin & Kepala Dinas - Documentation

## 📋 File yang Dibuat

### 1. **models/DashboardModel.php**
Model untuk mengambil data dashboard:
- `getStatistics()` - Statistik umum (6 counters)
- `getRecentActivity()` - Aktivitas terbaru
- `getTopLayanan()` - Top layanan terbaik
- `getChartKriteria()` - Data chart kriteria
- `getRecentResponden()` - Responden terbaru
- `getLayananByPerformance()` - Performa layanan
- `getKriteriaDistribution()` - Distribusi benefit/cost
- `getSurveyTrend()` - Trend survey bulanan

### 2. **controllers/AdminController.php**
Controller untuk admin dashboard:
- **Role check**: Hanya `admin` yang boleh akses
- `index()` - Dashboard dengan semua data
- `logout()` - Logout
- `profile()` - Profile admin

### 3. **controllers/KepalaDinasController.php**
Controller untuk kepala dinas dashboard:
- **Role check**: `admin` dan `kepala_dinas` boleh akses
- `index()` - Dashboard dengan data analisis
- `laporan()` - Halaman laporan lengkap
- `logout()` - Logout

### 4. **views/dashboard/admin.php**
View admin dashboard dengan:
- ✅ 4 Statistics cards (gradient)
- ✅ Top 5 layanan terbaik table
- ✅ Kriteria distribution chart (doughnut)
- ✅ Recent activities (tabs: penilaian & hasil)
- ✅ Quick actions buttons
- ✅ Menggunakan template existing

### 5. **views/dashboard/kadis.php**
View kepala dinas dashboard dengan:
- ✅ 4 Statistics cards (gradient)
- ✅ Performa layanan table (with progress bar)
- ✅ Top 10 layanan terbaik
- ✅ Kriteria distribution pie chart
- ✅ Menu laporan & analisis
- ✅ Status badges (Sangat Baik, Baik, Cukup, Kurang)
- ✅ Ranking badges (🥇🥈🥉)

---

## 🎨 Design & Layout

### Template Structure:
```php
<?php include('template/header.php'); ?>
<body>
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <!-- Content here -->
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>
</body>
</html>
```

### Color Scheme (Gradient):
- **Primary** (Biru): Layanan, Charts
- **Success** (Hijau): Kriteria, Top Rankings
- **Info** (Cyan): Responden, Kepala Dinas
- **Warning** (Kuning): Penilaian, 3rd Place

---

## 📊 Dashboard Features

### Admin Dashboard:
1. **Statistics Cards**
   - Total Layanan (alternatif)
   - Total Kriteria
   - Total Responden
   - Total Penilaian

2. **Top 5 Layanan Table**
   - Rank badge
   - Kode alternatif
   - Nama layanan
   - Nilai rata-rata

3. **Kriteria Distribution Chart**
   - Doughnut chart
   - Benefit vs Cost
   - Chart.js library

4. **Recent Activities (Tabs)**
   - Penilaian terbaru
   - Hasil SMART terbaru

5. **Quick Actions**
   - Kelola Layanan
   - Kelola Kriteria
   - Kelola Responden
   - Hitung SMART

### Kepala Dinas Dashboard:
1. **Statistics Cards**
   - Total Layanan
   - Total Kriteria
   - Total Responden
   - Total Hasil SMART

2. **Performa Layanan Table**
   - Ranking dengan emoji badges (🥇🥈🥉)
   - Progress bar nilai
   - Periode
   - Status (Sangat Baik, Baik, Cukup, Kurang)

3. **Top 10 Layanan**
   - 10 terbaik
   - Rank badges
   - Total penilaian

4. **Kriteria Distribution**
   - Pie chart
   - Summary benefit/cost

5. **Laporan Menu**
   - Laporan lengkap
   - Daftar layanan
   - Hasil SMART

---

## 🔐 Access Control

### Role-Based Access:

| Page | Admin | Kepala Dinas | Staff |
|------|-------|--------------|-------|
| Admin Dashboard | ✅ | ❌ | ❌ |
| Kadis Dashboard | ✅ | ✅ | ❌ |

### Auth Check:
```php
// AdminController
if ($_SESSION['role'] !== 'admin') {
    // Redirect ke dashboard
}

// KepalaDinasController
$allowedRoles = ['admin', 'kepala_dinas'];
if (!in_array($_SESSION['role'], $allowedRoles)) {
    // Redirect
}
```

---

## 🎯 Cara Akses

### Login sebagai Admin:
```bash
# Login dulu
URL: http://localhost/web_discakpil/index.php?controller=auth&action=index
Username: admin
Password: admin123

# Setelah login, otomatis redirect ke:
http://localhost/web_discakpil/index.php?controller=admin&action=index
```

### Login sebagai Kepala Dinas:
```bash
# Login dulu
URL: http://localhost/web_discakpil/index.php?controller=auth&action=index
Username: kadis
Password: kadis123

# Setelah login, otomatis redirect ke:
http://localhost/web_discakpil/index.php?controller=kepala_dinas&action=index
```

---

## 📈 Database Queries yang Digunakan

### Statistics:
```sql
SELECT COUNT(*) FROM alternatif
SELECT COUNT(*) FROM kriteria
SELECT COUNT(*) FROM sub_kriteria
SELECT COUNT(*) FROM responden
SELECT COUNT(*) FROM penilaian
SELECT COUNT(*) FROM hasil_akhir_smart
```

### Top Layanan:
```sql
SELECT a.*, AVG(h.nilai_akhir) as rata_nilai, COUNT(h.id_hasil) as total_penilaian
FROM hasil_akhir_smart h
JOIN alternatif a ON h.id_alternatif = a.id_alternatif
GROUP BY a.id_alternatif
ORDER BY rata_nilai DESC
LIMIT 5
```

### Performa Layanan (Periode Terbaru):
```sql
SELECT a.*, h.ranking, h.nilai_akhir, h.periode
FROM hasil_akhir_smart h
JOIN alternatif a ON h.id_alternatif = a.id_alternatif
WHERE h.periode = (SELECT MAX(periode) FROM hasil_akhir_smart)
ORDER BY h.ranking ASC
```

---

## 🎨 UI Components

### Badges:
```html
<!-- Ranking -->
<span class="badge badge-success">🥇 1</span>

<!-- Status -->
<span class="badge badge-info">Baik</span>

<!-- Role -->
<span class="badge badge-primary">Admin</span>
```

### Progress Bar:
```html
<div class="progress">
  <div class="progress-bar bg-gradient-primary" style="width: 85%">
    85%
  </div>
</div>
```

### Charts:
```javascript
// Doughnut Chart
new Chart(ctx, {
  type: 'doughnut',
  data: { ... },
  options: { ... }
});

// Pie Chart
new Chart(ctx, {
  type: 'pie',
  data: { ... }
});
```

---

## 🔗 Controllers yang Perlu Dibuat Selanjutnya

Untuk melengkapi dashboard, perlu membuat:

1. **AlternatifController** - Kelola layanan (CRUD)
2. **KriteriaController** - Kelola kriteria (CRUD)
3. **SubKriteriaController** - Kelola sub kriteria
4. **RespondenController** - Kelola responden (CRUD)
5. **PenilaianController** - Input penilaian
6. **SmartController** - Perhitungan metode SMART

---

## ✅ Checklist

- ✅ DashboardModel dibuat
- ✅ AdminController dibuat (role: admin only)
- ✅ KepalaDinasController dibuat (role: admin + kadis)
- ✅ Admin dashboard view dengan template
- ✅ Kadis dashboard view dengan template
- ✅ Statistics cards
- ✅ Tables dengan data real
- ✅ Charts (Chart.js)
- ✅ Quick actions
- ✅ Role-based access control
- ✅ Responsive design
- ✅ Menggunakan template existing

---

## 🚀 Next Steps

1. Buat controllers untuk CRUD data
2. Buat views untuk input penilaian
3. Implementasi perhitungan metode SMART
4. Buat halaman laporan lengkap
5. Tambah export PDF/Excel

Dashboard sudah siap digunakan dengan template existing dan fitur lengkap! 🎉
