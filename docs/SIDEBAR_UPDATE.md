# Sidebar Update - Documentation

## ✅ Sidebar yang Diperbarui

### **File**: `template/sidebar.php`

Sidebar telah diperbarui untuk sistem DISDUKCAPIL dengan 3 role (admin, kepala_dinas, staff).

---

## 📋 Menu yang Tersedia Saat Ini

### **Untuk Semua Role:**
1. ✅ **Dashboard** - Menu utama yang redirect ke dashboard sesuai role
2. ✅ **User Info Card** - Menampilkan nama lengkap dan role
3. ✅ **Logout** - Logout dari sistem

### **Placeholder untuk Menu Tambahan:**
- Admin section (placeholder)
- Kepala Dinas section (placeholder)
- Staff section (placeholder)

---

## 🎨 Fitur Sidebar

### **1. Role-Based Dashboard Link**
```php
function getDashboardUrl() {
    switch ($role) {
        case 'admin':
            return 'index.php?controller=admin&action=index';
        case 'kepala_dinas':
            return 'index.php?controller=kepalaDinas&action=index';
        case 'staff':
            return 'index.php?controller=staff&action=index';
    }
}
```

### **2. User Info Card**
Tampilan user di bagian bawah sidebar:
```html
<div class="user-details">
  <i class="fas fa-user-circle fa-2x"></i>
  <p>Nama Lengkap</p>
  <p><i class="fas fa-shield-alt"></i>Role</p>
</div>
```

**Styling:**
- Background gradient: `#4f46e5` → `#7c3aed` (indigo ke purple)
- Border radius: 12px
- Shadow: `0 4px 12px rgba(79, 70, 229, 0.3)`
- Text: white

### **3. Active Menu Styling**
```css
.nav-link.active {
    background: linear-gradient(90deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.05));
    border-left: 3px solid #4f46e5;
}
```

### **4. Icon Styling**
- Color: `#4f46e5` (indigo primary)
- Hover color: `#7c3aed` (purple)
- Width: 20px, text-align: center

---

## 🔐 Role-Based Access

### **Menu Visibility:**

| Menu | Admin | Kepala Dinas | Staff |
|------|-------|--------------|-------|
| Dashboard | ✅ | ✅ | ✅ |
| User Info | ✅ | ✅ | ✅ |
| Logout | ✅ | ✅ | ✅ |
| Admin Menu Placeholder | ✅ | ❌ | ❌ |
| Kadis Menu Placeholder | ✅ | ✅ | ❌ |
| Staff Menu Placeholder | ✅ | ✅ | ✅ |

---

## 🎯 Cara Menambah Menu Baru

### **Contoh: Menambah menu untuk Admin**

Cari section ini di sidebar.php:
```php
<?php if (hasRole('admin')): ?>

  <!-- Placeholder untuk menu admin lainnya -->
  <!-- Menu akan ditambahkan nanti -->

<?php endif; ?>
```

Ganti dengan:
```php
<?php if (hasRole('admin')): ?>

  <!-- Menu: Kelola Layanan -->
  <li class="nav-item">
    <a class="nav-link <?php echo isActive('alternatif') ? 'active' : ''; ?>"
       href="index.php?controller=alternatif&action=index">
      <i class="fas fa-clipboard-list menu-icon fa-sm"></i>
      <span class="menu-title">Kelola Layanan</span>
    </a>
  </li>

  <!-- Menu: Kelola Kriteria -->
  <li class="nav-item">
    <a class="nav-link <?php echo isActive('kriteria') ? 'active' : ''; ?>"
       href="index.php?controller=kriteria&action=index">
      <i class="fas fa-tasks menu-icon fa-sm"></i>
      <span class="menu-title">Kelola Kriteria</span>
    </a>
  </li>

<?php endif; ?>
```

---

## 🎨 Color Scheme

### **Indigo-Purple Gradient:**
```
#4f46e5 - Indigo Primary (icons, borders)
#7c3aed - Purple Secondary (hover states)
```

### **User Card Gradient:**
```
background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)
```

### **Active State:**
```
background: linear-gradient(90deg,
    rgba(79, 70, 229, 0.1) 0%,
    rgba(124, 58, 237, 0.05) 100%
)
border-left: 3px solid #4f46e5
```

---

## 📱 Responsive Behavior

### **Mobile (< 992px):**
- Sidebar otomatis menutup setelah klik menu
- Class `sidebar-icon-only` dihapus

### **Desktop (>= 992px):**
- Sidebar tetap terbuka
- Smooth hover effects

---

## 🔧 Helper Functions

### **1. isActive()**
Cek apakah menu sedang aktif:
```php
isActive('admin')           // Cek controller
isActive('admin', 'index') // Cek controller + action
```

### **2. hasRole()**
Cek apakah user punya akses:
```php
hasRole('admin')                    // Single role
hasRole(['admin', 'kepala_dinas']) // Multiple roles
hasRole('all')                      // All authenticated users
```

### **3. getDashboardUrl()**
Generate dashboard URL berdasarkan role:
```php
// Admin → index.php?controller=admin&action=index
// Kadis  → index.php?controller=kepalaDinas&action=index
// Staff  → index.php?controller=staff&action=index
```

---

## ✅ Checklist

- ✅ Menu Dashboard untuk semua role
- ✅ User info card dengan gradient indigo-purple
- ✅ Logout button untuk semua role
- ✅ Role-based access control
- ✅ Active state styling
- ✅ Icon styling dengan warna indigo
- ✅ Responsive behavior
- ✅ Placeholder untuk menu tambahan
- ✅ Helper functions lengkap
- ✅ Clean dan minimalis

---

## 🚀 Next Steps

Untuk menambah menu lebih lengkap:

1. **Admin Menu**:
   - Master Data (Alternatif, Kriteria, Sub Kriteria)
   - Penilaian & Perhitungan
   - User Management
   - Settings

2. **Kepala Dinas Menu**:
   - Laporan & Analisis
   - Monitoring
   - Hasil SMART

3. **Staff Menu**:
   - Input Penilaian
   - Data Responden
   - Profile

Sidebar sekarang siap untuk dikembangkan dengan menu tambahan! 🎉
