# Dokumentasi Autentikasi DISDUKCAPIL Kota Padang

## File yang Dibuat

### 1. **AuthModel.php** (`models/AuthModel.php`)
Model untuk mengelola operasi database terkait autentikasi:
- `login($username, $password)` - Validasi user
- `getUserById($id_user)` - Ambil data user berdasarkan ID
- `register($username, $password, $nama_lengkap, $role)` - Registrasi user baru

### 2. **AuthController.php** (`controllers/AuthController.php`)
Controller untuk menangani logika autentikasi:
- `index()` - Tampilkan halaman login
- `login()` - Proses login
- `logout()` - Proses logout

### 3. **login.php** (`views/auth/login.php`)
Halaman login dengan desain Premium Web 3.0:
- Glassmorphism effect
- Parallax background
- Custom cursor
- Particle animations
- AOS animations
- Toggle password visibility

### 4. **setup_auth.sql** (`database/setup_auth.sql`)
SQL script untuk setup tabel users dan user default

## Cara Setup

### 1. Import Database
Jalankan script SQL di phpMyAdmin atau terminal:
```bash
mysql -u root -p kp-simpan-pinjam < database/setup_auth.sql
```

### 2. Akses Halaman Login
Buka browser dan navigasi ke:
```
http://localhost/web_discakpil/index.php?controller=auth&action=index
```

### 3. Login dengan Akun Default

**Akun Admin:**
- Username: `admin`
- Password: `admin123`
- Role: `admin`

**Akun Kepala Dinas:**
- Username: `kepaladinas`
- Password: `admin123`
- Role: `kepala_dinas`

## Fitur Premium Web 3.0

### Visual Effects
- ✅ Glassmorphism dengan backdrop-blur(25px)
- ✅ Parallax background (3 layers)
- ✅ Custom cursor dengan hover effect
- ✅ Floating particles animation
- ✅ Breathing icon animation

### Interactivity
- ✅ AOS animations (fade-up, zoom-in, shake)
- ✅ Input field focus effects
- ✅ Button hover dengan glow
- ✅ Toggle password visibility
- ✅ Responsive design

### Security
- ✅ Password hashing dengan bcrypt
- ✅ Prepared statements (PDO)
- ✅ Session management
- ✅ SQL injection protection

## Struktur Database

### Tabel: `users`
```sql
- id_user (INT, PRIMARY KEY, AUTO_INCREMENT)
- username (VARCHAR(50), UNIQUE)
- password (VARCHAR(255), hashed)
- nama_lengkap (VARCHAR(100))
- role (ENUM: 'admin', 'kepala_dinas')
- created_at (TIMESTAMP)
```

## Alur Autentikasi

1. **Login Page** → User masukkan username & password
2. **AuthController::login()** → Validasi input
3. **AuthModel::login()** → Cek database
4. **Session Create** → Simpan data user di session
5. **Redirect** → Ke dashboard (perlu dibuat)
6. **Logout** → Hapus session & redirect ke landing page

## Next Steps

Untuk melengkapi sistem, perlu membuat:
1. **DashboardController** - Halaman dashboard
2. **Middleware/Auth** - Proteksi halaman
3. **User Management** - CRUD user (opsional)
4. **Change Password** - Ganti password

## Catatan Penting

- Password default: `admin123` (harus diganti setelah login pertama)
- Session disimpan dengan nama: `user_id`, `username`, `nama_lengkap`, `role`
- Logout akan menghapus semua session data
- Desain konsisten dengan landing page Premium Web 3.0
