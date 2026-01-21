-- Setup Database untuk Multi-Role Users DISDUKCAPIL Kota Padang

-- Update tabel users untuk mendukung multi-role
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepala_dinas', 'staff') DEFAULT 'admin';

-- Insert/update user admin (password: admin123) - MD5 untuk backward compatibility
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', MD5('admin123'), 'Administrator Sistem', 'admin')
ON DUPLICATE KEY UPDATE
    password = VALUES(password),
    nama_lengkap = VALUES(nama_lengkap),
    role = VALUES(role);

-- Insert/update user kepala dinas (password: kadis123)
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('kadis', MD5('kadis123'), 'Teddy Antonius', 'kepala_dinas')
ON DUPLICATE KEY UPDATE
    password = VALUES(password),
    nama_lengkap = VALUES(nama_lengkap),
    role = VALUES(role);

-- Insert user staff (password: staff123)
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('staff', MD5('staff123'), 'Staff Administrasi', 'staff')
ON DUPLICATE KEY UPDATE
    password = VALUES(password),
    nama_lengkap = VALUES(nama_lengkap),
    role = VALUES(role);

-- Catatan:
-- 1. Password menggunakan MD5 untuk kompatibilitas dengan sistem yang sudah ada
-- 2. Sistem akan otomatis mendeteksi MD5 vs BCRYPT saat login
-- 3. Untuk migrasi ke BCRYPT, gunakan fungsi migrateMD5ToBcrypt() setelah login pertama
--
-- Login Credentials:
-- Admin:      username='admin',      password='admin123', role='admin'
-- Kepala Dinas: username='kadis',   password='kadis123',  role='kepala_dinas'
-- Staff:      username='staff',     password='staff123',  role='staff'
--
-- Role Hierarchy (permission level):
-- 1. admin      - Akses penuh ke sistem
-- 2. kepala_dinas - Akses supervisi dan laporan
-- 3. staff      - Akses terbatas untuk operasional
