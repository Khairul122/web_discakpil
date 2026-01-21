# CRUD Alternatif (Layanan) - Documentation

## 📋 File yang Dibuat

### 1. **models/AlternatifModel.php**
Model untuk operasi database tabel `alternatif`:
- `getAll()` - Ambil semua data layanan
- `getById($id)` - Ambil layanan berdasarkan ID
- `getByKode($kode)` - Ambil layanan berdasarkan kode
- `create($kode, $nama, $deskripsi)` - Tambah layanan baru
- `update($id, $kode, $nama, $deskripsi)` - Update layanan
- `delete($id)` - Hapus layanan
- `checkKodeExists($kode, $exclude_id)` - Cek kode unik
- `getTotal()` - Hitung total layanan
- `search($keyword)` - Cari layanan

### 2. **controllers/AlternatifController.php**
Controller untuk manajemen layanan:
- `index()` - List layanan dengan search
- `create()` - Form tambah layanan
- `store()` - Proses tambah layanan
- `edit()` - Form edit layanan
- `update()` - Proses update layanan
- `delete()` - Hapus layanan

**Role Check**: Hanya **admin** yang boleh akses

### 3. **views/alternatif/index.php**
Halaman list layanan dengan:
- ✅ Statistics cards (total, aktif, periode)
- ✅ Search form (berdasarkan kode, nama, deskripsi)
- ✅ Table dengan data lengkap
- ✅ Tombol edit & delete
- ✅ Empty state dengan tombol tambah
- ✅ Responsive table
- ✅ Alert messages

### 4. **views/alternatif/form.php**
Form tambah/edit layanan dengan:
- ✅ Kode Layanan (required, max 10 karakter, uppercase auto)
- ✅ Nama Layanan (required, max 100 karakter)
- ✅ Deskripsi (optional, max 1000 karakter, textarea)
- ✅ Validasi client-side
- ✅ Info card
- ✅ Batal & Simpan buttons

---

## 🎨 Fitur UI

### **Statistics Cards:**
```
┌─────────────┬─────────────┬─────────────┐
│ Total       │ Aktif       │ Periode     │
│ Layanan     │             │             │
│     5       │      5      │   2025-01   │
└─────────────┴─────────────┴─────────────┘
```

### **Table Columns:**
1. **No** - Nomor urut
2. **Kode Layanan** - Badge primary pill
3. **Nama Layanan** - Bold text
4. **Deskripsi** - Text (dipotong 100 karakter)
5. **Aksi** - Tombol edit & delete

### **Form Fields:**
- **Kode Layanan**:
  - Required
  - Maxlength: 10 karakter
  - Pattern: `[A-Z0-9]+` (huruf kapital + angka)
  - Auto-uppercase on input
  - Placeholder: "A01, B02, C03"

- **Nama Layanan**:
  - Required
  - Maxlength: 100 karakter
  - Placeholder: "Masukkan nama layanan"

- **Deskripsi**:
  - Optional
  - Maxlength: 1000 karakter
  - Textarea 5 rows
  - Placeholder: "Jelaskan layanan ini secara singkat"

---

## 🔐 Access Control

### **Role**:
- ✅ **Admin** - Full CRUD access
- ❌ **Kepala Dinas** - No access
- ❌ **Staff** - No access

### **Authentication Check**:
```php
// Di constructor AlternatifController
if (!isset($_SESSION['user_id'])) {
    redirect('auth');
}

if ($_SESSION['role'] !== 'admin') {
    redirect('admin/dashboard');
}
```

---

## 🎯 Cara Menggunakan

### **1. Lihat Daftar Layanan**
```
URL: index.php?controller=alternatif&action=index
```

### **2. Tambah Layanan Baru**
```
URL: index.php?controller=alternatif&action=create
```

### **3. Edit Layanan**
```
URL: index.php?controller=alternatif&action=edit&id=1
```

### **4. Hapus Layanan**
```
URL: index.php?controller=alternatif&action=delete&id=1
```
Konfirmasi dialog akan muncul sebelum menghapus.

### **5. Cari Layanan**
```
URL: index.php?controller=alternatif&action=index&keyword=A01
```
Pencarian berdasarkan:
- Kode alternatif
- Nama layanan
- Deskripsi

---

## ✨ Validasi

### **Server-Side (PHP):**
1. Required fields (kode, nama)
2. Maxlength check
3. Unique code check
4. ID validity check (edit/delete)

### **Client-Side (JavaScript):**
1. Required fields
2. Pattern validation (A-Z0-9)
3. Maxlength check (10 karakter)
4. Confirm delete dialog

---

## 🎨 Styling

### **Buttons:**
```html
<!-- Primary (Tambah/Simpan) -->
<button class="btn btn-gradient-primary">
  <i class="fas fa-save mr-2"></i>Simpan
</button>

<!-- Secondary (Batal) -->
<a href="..." class="btn btn-gradient-secondary">
  <i class="fas fa-times mr-2"></i>Batal
</a>

<!-- Info (Edit) -->
<a href="..." class="btn btn-gradient-info">
  <i class="fas fa-edit"></i>
</a>

<!-- Danger (Hapus) -->
<button class="btn btn-gradient-danger">
  <i class="fas fa-trash"></i>
</button>
```

### **Badges:**
```html
<!-- Kode Layanan -->
<span class="badge badge-primary badge-pill px-3 py-2">A01</span>
```

### **Alerts:**
```php
// Success
$_SESSION['success'] = 'Layanan berhasil ditambahkan!';

// Error
$_SESSION['error'] = 'Gagal menambahkan layanan!';
```

---

## 📱 Responsive Behavior

### **Desktop (>= 768px):**
- Table full width
- 3 statistics cards in row
- Search & filter form

### **Mobile (< 768px):**
- Table scrollable
- Cards stacked
- Form full width

---

## 🔄 Alur CRUD

### **Create:**
```
index.php?controller=alternatif&action=create
     ↓
[Isi Form]
     ↓
[Submit → Store()]
     ↓
[Validation & Insert Database]
     ↓
[Redirect ke Index + Success Message]
```

### **Update:**
```
[index → Klik Edit]
     ↓
index.php?controller=alternatif&action=edit&id=1
     ↓
[Tampil Form dengan Data]
     ↓
[Edit + Submit → Update()]
     ↓
[Validation & Update Database]
     ↓
[Redirect ke Index + Success Message]
```

### **Delete:**
```
[index → Klik Delete]
     ↓
[Confirm Dialog]
     ↓
index.php?controller=alternatif&action=delete&id=1
     ↓
[Delete from Database]
     ↓
[Redirect ke Index + Success Message]
```

---

## 🎯 Error Handling

### **Database Error:**
```php
error_log("Error message");
return false;
```

### **User-Friendly Messages:**
- "Kode alternatif sudah terdaftar!"
- "Layanan tidak ditemukan!"
- "Gagal menambahkan layanan!"

---

## 📝 Notes

1. **Foreign Key**: Tabel `alternatif` di-reference oleh tabel:
   - `penilaian.id_alternatif`
   - `hasil_akhir_smart.id_alternatif`

2. **Cascade Delete**: Ketika alternatif dihapus, data terkait juga terhapus:
   - Semua penilaian untuk layanan tersebut
   - Hasil SMART untuk layanan tersebut

3. **Kode Format**: Rekomendasi format kode:
   - A01, A02, A03... (Layanan tipe A)
   - B01, B02, B03... (Layanan tipe B)
   - Atau format lain sesuai kebutuhan

4. **Auto-uppercase**: Input kode otomatis jadi kapital

5. **Character Limits**:
   - Kode: 10 karakter
   - Nama: 100 karakter
   - Deskripsi: 1000 karakter

CRUD Layanan sudah lengkap dan siap digunakan! 🎉
