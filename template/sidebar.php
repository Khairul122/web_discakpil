<?php

/**
 * Sidebar Navigation - DISDUKCAPIL Kota Padang
 * Navigasi berdasarkan role: Admin, Kepala Dinas, Staff
 */

// Fungsi untuk memeriksa apakah menu aktif
function isActive($controller, $action = null)
{
    $currentController = isset($_GET['controller']) ? $_GET['controller'] : '';
    $currentAction = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === null) {
        return $currentController === $controller;
    }
    return $currentController === $controller && $currentAction === $action;
}

// Fungsi untuk memeriksa role pengguna
function hasRole($allowedRoles)
{
    $userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

    if ($allowedRoles === 'all') return true;

    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    return in_array($userRole, $allowedRoles);
}

// Get dashboard URL berdasarkan role
function getDashboardUrl()
{
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

    switch ($role) {
        case 'admin':
            return 'index.php?controller=admin&action=index';
        case 'kepala_dinas':
            return 'index.php?controller=kepalaDinas&action=index';
        case 'staff':
            return 'index.php?controller=staff&action=index';
        default:
            return 'index.php?controller=dashboard&action=index';
    }
}
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <!-- ==========================================
         MENU DASHBOARD (SEMUA ROLE)
         ========================================== -->
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (isActive('admin') || isActive('kepalaDinas') || isActive('staff')) ? 'active' : ''; ?>"
          href="<?php echo getDashboardUrl(); ?>">
          <i class="fas fa-home menu-icon fa-sm"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
    <?php endif; ?>

    <!-- ==========================================
         MENU KHUSUS ADMIN
         ========================================== -->
    <?php if (hasRole('admin')): ?>

      <!-- Placeholder untuk menu admin lainnya -->
      <!-- Menu akan ditambahkan nanti -->

    <?php endif; ?>

    <!-- ==========================================
         MENU KHUSUS KEPALA DINAS
         ========================================== -->
    <?php if (hasRole(['admin', 'kepala_dinas'])): ?>

      <!-- Placeholder untuk menu kepala dinas lainnya -->
      <!-- Menu akan ditambahkan nanti -->

    <?php endif; ?>

    <!-- ==========================================
         MENU KHUSUS STAFF
         ========================================== -->
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>

      <!-- Placeholder untuk menu staff lainnya -->
      <!-- Menu akan ditambahkan nanti -->

    <?php endif; ?>

    <!-- ==========================================
         MENU LOGOUT (SEMUA ROLE)
         ========================================== -->
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
      <li class="nav-item mt-4">
        <div class="sidebar-user-actions">
          <div class="user-details">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-user-circle fa-2x mr-2"></i>
              <div>
                <p class="font-weight-bold mb-0"><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'User') ?></p>
                <p class="small mb-0">
                  <i class="fas fa-shield-alt mr-1"></i>
                  <?= ucfirst($_SESSION['role'] ?? 'guest') ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=<?= $_SESSION['role'] ?? 'auth' ?>&action=logout">
          <i class="fas fa-sign-out-alt menu-icon fa-sm"></i>
          <span class="menu-title">Logout</span>
        </a>
      </li>
    <?php endif; ?>

  </ul>
</nav>

<style>
  /* Sidebar user actions */
  .sidebar-user-actions {
    margin-top: auto;
    padding: 15px;
    border-top: 1px solid #e5e7eb;
  }

  .user-details {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 12px;
    padding: 15px;
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
  }

  .user-details p {
    color: white;
  }

  .user-details .small {
    opacity: 0.9;
  }

  /* Active menu styling */
  .nav-link.active {
    background: linear-gradient(90deg, rgba(79, 70, 229, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
    border-left: 3px solid #4f46e5;
  }

  /* Menu icon styling */
  .menu-icon {
    width: 20px;
    text-align: center;
    color: #4f46e5;
  }

  .nav-link:hover .menu-icon {
    color: #7c3aed;
  }
</style>

<script>
  // Fungsi untuk menangani aktifasi item menu
  document.addEventListener('DOMContentLoaded', function() {
    // Menangani klik pada mobile untuk menutup sidebar
    const sidebarLinks = document.querySelectorAll('#sidebar .nav-link:not(.disabled)');
    sidebarLinks.forEach(function(link) {
      link.addEventListener('click', function() {
        // Menutup sidebar di mobile setelah klik
        if (window.innerWidth < 992) {
          document.body.classList.remove('sidebar-icon-only');
        }
      });
    });
  });
</script>
