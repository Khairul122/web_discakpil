# Multi-Role Auth System - Documentation

## 📋 Analisis Masalah

### Masalah yang Ditemukan:
1. ❌ Query menggunakan **MD5** untuk password
2. ❌ Sistem support MD5 tapi database menggunakan MD5
3. ❌ Belum ada multi-role system yang lengkap

### Solusi yang Diterapkan:
✅ **Hybrid Authentication** - Support MD5 + BCRYPT
✅ **Auto-migration** - MD5 otomatis di-convert ke BCRYPT saat login pertama
✅ **Multi-role system** - 3 role dengan hierarchy system
✅ **Role-based routing** - Redirect dashboard berdasarkan role

---

## 🔐 Sistem Enkripsi Hybrid

### Cara Kerja:
```
Login Request
     ↓
Cek format hash di database
     ↓
┌─────────────────┬─────────────────┐
│   Jika MD5      │   Jika BCRYPT   │
│  (32 karakter)  │  (60 karakter)  │
└─────────────────┴─────────────────┘
     ↓                    ↓
md5($password)    password_verify()
     ↓                    ↓
    LOGIN SUCCESS → AUTO-MIGRATE TO BCRYPT
```

### Keuntungan:
- ✅ Backward compatible dengan MD5 yang sudah ada
- ✅ Auto-migrate ke BCRYPT yang lebih aman
- ✅ Tidak perlu reset semua password user
- ✅ Transisi smooth tanpa downtime

---

## 👥 Multi-Role System

### Role Hierarchy:
```
Level 1: admin
         ↓ BISA AKSES SEMUA
Level 2: kepala_dinas
         ↓ BISA AKSES STAFF & DIRI SENDIRI
Level 3: staff
         ↓ HANYA AKSES MILIK SENDIRI
```

### Permission Matrix:
| Fitur | Admin | Kepala Dinas | Staff |
|-------|-------|--------------|-------|
| CRUD Users | ✅ | ❌ | ❌ |
| Laporan | ✅ | ✅ | ❌ |
| CRUD Data | ✅ | ✅ | ✅ |
| Settings | ✅ | ❌ | ❌ |

---

## 🚀 Setup Database

### Jalankan SQL:
```bash
mysql -u root -p kp-simpan-pinjam < database/setup_auth.sql
```

### Atau manual di phpMyAdmin:
```sql
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepala_dinas', 'staff') DEFAULT 'admin';

INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', MD5('admin123'), 'Administrator Sistem', 'admin'),
('kadis', MD5('kadis123'), 'Teddy Antonius', 'kepala_dinas'),
('staff', MD5('staff123'), 'Staff Administrasi', 'staff');
```

---

## 🔑 Login Credentials

| Role | Username | Password | Nama |
|------|----------|----------|------|
| **Admin** | `admin` | `admin123` | Administrator Sistem |
| **Kepala Dinas** | `kadis` | `kadis123` | Teddy Antonius |
| **Staff** | `staff` | `staff123` | Staff Administrasi |

---

## 📁 File yang Diperbarui

### 1. **AuthModel.php** (models/AuthModel.php)
**Methods Baru:**
- `login()` - Hybrid MD5/BCRYPT detection
- `isMD5()` - Deteksi format hash
- `getAllUsers()` - Ambil semua user
- `createUser()` - Tambah user baru
- `updateUser()` - Update user data
- `updatePassword()` - Ganti password
- `deleteUser()` - Hapus user
- `getUserByUsername()` - Cek username
- `checkUsernameExists()` - Validasi unik
- `migrateMD5ToBcrypt()` - Migrasi otomatis
- `hasPermission()` - Cek permission role

### 2. **AuthController.php** (controllers/AuthController.php)
**Methods Baru:**
- `redirectToDashboard()` - Role-based redirect
- `checkAuth()` - Middleware autentikasi
- `requireRole()` - Middleware authorization

**Logic Redirect:**
```php
admin        → admin/dashboard
kepala_dinas → kepala_dinas/dashboard
staff         → staff/dashboard
```

### 3. **setup_auth.sql** (database/setup_auth.sql)
- Update ENUM role untuk support 3 role
- Insert 3 user dengan MD5 hash
- ON DUPLICATE KEY untuk re-runable

---

## 🎯 Cara Penggunaan

### Login:
```
URL: http://localhost/web_discakpil/index.php?controller=auth&action=index
```

Sistem akan otomatis:
1. Deteksi format password (MD5/BCRYPT)
2. Verifikasi login
3. Migrate ke BCRYPT jika masih MD5
4. Redirect ke dashboard sesuai role

### Check Auth di Controller:
```php
// Di constructor controller
public function __construct($connection) {
    $auth = new AuthController($connection);
    $auth->checkAuth(); // Redirect ke login jika belum auth
}
```

### Role-Based Access Control:
```php
// Hanya admin dan kepala_dinas
$auth->requireRole(['admin', 'kepala_dinas']);

// Atau single role
$auth->requireRole('admin');

// Cek permission
if ($authModel->hasPermission($_SESSION['role'], 'kepala_dinas')) {
    // Allowed
}
```

---

## 🔄 Alur Auto-Migration

### Proses:
1. User login dengan password MD5
2. Sistem detect: "Ini hash MD5 (32 karakter hex)"
3. Login berhasil
4. **OTOMATIS** update password ke BCRYPT
5. Next login: pakai BCRYPT (lebih aman)

### Cek Database:
```sql
-- Sebelum login
SELECT username, LENGTH(password) as pass_length FROM users;
-- Hasil: admin = 32 (MD5)

-- Setelah login pertama
-- Hasil: admin = 60 (BCRYPT)
```

---

## 🛡️ Security Features

### ✅ Sudah Implementasi:
- Prepared statements (PDO)
- Password hashing (BCRYPT)
- SQL injection protection
- Session management
- Role-based access control
- Auto-migration password
- Permission checking

### 🔐 Password Hash:

**MD5 (lama):**
```
0192023a7bbd73250516f069df18b500  (32 karakter)
```

**BCRYPT (baru - auto-migrate):**
```
$2y$10$xYZ...abc123... (60 karakter)
```

---

## 📝 Contoh Implementasi Role-Based Dashboard

### Admin Dashboard:
```php
class AdminController {
    public function __construct($connection) {
        $auth = new AuthController($connection);
        $auth->requireRole('admin'); // Hanya admin
    }
}
```

### Kepala Dinas Dashboard:
```php
class KepalaDinasController {
    public function __construct($connection) {
        $auth = new AuthController($connection);
        $auth->requireRole(['admin', 'kepala_dinas']); // Admin & Kadis
    }
}
```

### Staff Dashboard:
```php
class StaffController {
    public function __construct($connection) {
        $auth = new AuthController($connection);
        $auth->checkAuth(); // Semua user yang sudah login
    }
}
```

---

## ⚠️ Catatan Penting

1. **MD5 tetap support** untuk backward compatibility
2. **Auto-migration** terjadi setelah login pertama
3. **BCRYPT adalah default** untuk user baru
4. **Role system** dengan hierarchy level
5. **Permission checking** dengan `hasPermission()`

---

## 🧪 Testing

### Test 1 - Login MD5:
```bash
# Login dengan admin (MD5)
Username: admin
Password: admin123

# Expected: Login berhasil + password otomatis di-convert ke BCRYPT
```

### Test 2 - Login BCRYPT:
```bash
# Login kedua (sudah di-migrate)
Username: admin
Password: admin123

# Expected: Login berhasil dengan BCRYPT verify
```

### Test 3 - Multi-Role:
```bash
# Test semua 3 role
admin      → Redirect ke admin dashboard
kadis      → Redirect ke kepala_dinas dashboard
staff      → Redirect ke staff dashboard
```

---

## ✅ Summary

Sistem sekarang:
- ✅ Support MD5 (untuk existing data)
- ✅ Support BCRYPT (untuk baru & migrated)
- ✅ Auto-migration password
- ✅ Multi-role system (3 role)
- ✅ Role-based routing
- ✅ Permission checking
- ✅ Ready untuk production
