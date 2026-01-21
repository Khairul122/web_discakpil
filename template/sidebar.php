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

      <!-- MASTER DATA -->
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#masterData" aria-expanded="false" aria-controls="masterData">
          <i class="fas fa-database menu-icon fa-sm"></i>
          <span class="menu-title">Master Data</span>
          <i class="fas fa-chevron-down ml-auto"></i>
        </a>
        <div class="collapse" id="masterData">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link <?php echo isActive('alternatif') ? 'active' : ''; ?>"
                 href="index.php?controller=alternatif&action=index">
                <i class="fas fa-list-alt menu-icon fa-sm"></i>
                <span class="menu-title">Alternatif</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo isActive('kriteria') ? 'active' : ''; ?>"
                 href="index.php?controller=kriteria&action=index">
                <i class="fas fa-sliders-h menu-icon fa-sm"></i>
                <span class="menu-title">Kriteria</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- RESPONDEN -->
      <li class="nav-item">
        <a class="nav-link <?php echo isActive('responden') ? 'active' : ''; ?>"
           href="index.php?controller=responden&action=index">
          <i class="fas fa-users menu-icon fa-sm"></i>
          <span class="menu-title">Responden</span>
        </a>
      </li>

      <!-- PENILAIAN -->
      <li class="nav-item">
        <a class="nav-link <?php echo isActive('penilaian') ? 'active' : ''; ?>"
           href="index.php?controller=penilaian&action=index">
          <i class="fas fa-clipboard-check menu-icon fa-sm"></i>
          <span class="menu-title">Penilaian</span>
        </a>
      </li>

      <!-- HASIL AKHIR -->
      <li class="nav-item">
        <a class="nav-link <?php echo isActive('hasil') ? 'active' : ''; ?>"
           href="index.php?controller=hasil&action=index">
          <i class="fas fa-chart-line menu-icon fa-sm"></i>
          <span class="menu-title">Hasil Akhir</span>
        </a>
      </li>

    <?php endif; ?>

    <!-- ==========================================
         MENU KHUSUS KEPALA DINAS (KADIS)
         ========================================== -->
    <?php if (hasRole('kepala_dinas')): ?>

      <!-- PENILAIAN -->
      <li class="nav-item">
        <a class="nav-link <?php echo isActive('penilaian') ? 'active' : ''; ?>"
           href="index.php?controller=penilaian&action=index">
          <i class="fas fa-clipboard-check menu-icon fa-sm"></i>
          <span class="menu-title">Penilaian</span>
        </a>
      </li>

      <!-- LAPORAN -->
      <li class="nav-item">
        <a class="nav-link <?php echo isActive('laporan') ? 'active' : ''; ?>"
           href="index.php?controller=laporan&action=index">
          <i class="fas fa-file-pdf menu-icon fa-sm"></i>
          <span class="menu-title">Laporan</span>
        </a>
      </li>

    <?php endif; ?>

    <!-- ==========================================
         MENU LOGOUT (SEMUA ROLE)
         ========================================== -->
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
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

  /* Submenu styling */
  .sub-menu {
    background-color: #f9fafb;
    padding-left: 20px;
  }

  .sub-menu .nav-link {
    padding-left: 40px;
    font-size: 0.9rem;
  }

  .sub-menu .nav-link:hover {
    background-color: rgba(79, 70, 229, 0.05);
  }

  .sub-menu .nav-link.active {
    background-color: rgba(79, 70, 229, 0.1);
    border-left: 2px solid #7c3aed;
  }

  /* Chevron rotation when collapsed */
  [data-toggle="collapse"][aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
  }

  .fa-chevron-down {
    transition: transform 0.3s ease;
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

    // Menangani collapse Master Data menu
    const collapseLinks = document.querySelectorAll('[data-toggle="collapse"]');
    collapseLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const target = document.querySelector(targetId);

        if (target) {
          // Toggle aria-expanded
          const isExpanded = this.getAttribute('aria-expanded') === 'true';
          this.setAttribute('aria-expanded', !isExpanded);

          // Toggle collapse
          if (isExpanded) {
            target.classList.remove('show');
          } else {
            target.classList.add('show');
          }
        }
      });
    });

    // Pastikan submenu terbuka jika salah satu itemnya aktif
    const activeSubLinks = document.querySelectorAll('.sub-menu .nav-link.active');
    activeSubLinks.forEach(function(link) {
      const collapse = link.closest('.collapse');
      if (collapse) {
        collapse.classList.add('show');
        const trigger = document.querySelector('[href="#' + collapse.id + '"]');
        if (trigger) {
          trigger.setAttribute('aria-expanded', 'true');
        }
      }
    });
  });
</script>
