<?php
/**
 * Navbar - DISDUKCAPIL Kota Padang
 * Menampilkan navigasi atas dengan informasi user
 */

// Set timezone Indonesia
date_default_timezone_set("Asia/Jakarta");

// Ambil data user dari session
$nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna');
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

// Tentukan display role
$roleDisplay = 'Guest';
if ($userRole === 'admin') {
    $roleDisplay = 'Administrator';
} elseif ($userRole === 'kepala_dinas') {
    $roleDisplay = 'Kepala Dinas';
} elseif ($userRole === 'staff') {
    $roleDisplay = 'Staff';
}
?>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <a class="navbar-brand brand-logo" href="index.php">
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #059669;">
            <i class="fas fa-user" style="font-size: 18px; color: white;"></i>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 3px solid #059669;">
              <i class="fas fa-user" style="font-size: 28px; color: white;"></i>
            </div>
            <p class="mb-1 mt-3 font-weight-semibold"><?= htmlspecialchars($nama) ?></p>
            <p class="mb-0 text-muted small">
              Role: <span class="text-primary font-weight-semibold"><?= htmlspecialchars($roleDisplay) ?></span>
            </p>
          </div>

          <div class="dropdown-divider"></div>

          <?php if (in_array($userRole, ['admin', 'kepala_dinas', 'staff'])): ?>
            <!-- Menu Dashboard untuk user yang sudah login -->
            <?php if ($userRole === 'admin'): ?>
              <a class="dropdown-item" href="index.php?controller=admin&action=index">
                <i class="dropdown-item-icon mdi mdi-view-dashboard text-primary me-2"></i>
                Dashboard
              </a>
            <?php elseif ($userRole === 'kepala_dinas'): ?>
              <a class="dropdown-item" href="index.php?controller=kepalaDinas&action=index">
                <i class="dropdown-item-icon mdi mdi-view-dashboard text-primary me-2"></i>
                Dashboard
              </a>
            <?php endif; ?>
          <?php else: ?>
            <!-- Menu Guest / Belum Login -->
            <a class="dropdown-item" href="index.php?controller=auth&action=index">
              <i class="dropdown-item-icon mdi mdi-login text-primary me-2"></i>
              Login
            </a>
          <?php endif; ?>

          <div class="dropdown-divider"></div>

          <?php if (in_array($userRole, ['admin', 'kepala_dinas', 'staff'])): ?>
            <a class="dropdown-item" href="index.php?controller=<?= $userRole === 'admin' ? 'admin' : 'kepalaDinas' ?>&action=logout">
              <i class="dropdown-item-icon mdi mdi-power text-danger me-2"></i>
              <span class="text-danger">Sign Out</span>
            </a>
          <?php endif; ?>
        </div>
      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<style>
  .welcome-text {
    font-family: 'Source Sans Pro', sans-serif;
    margin: 0;
    font-weight: 400;
    color: #6c7293;
  }

  .navbar-brand {
    font-weight: 500;
    font-size: 24px;
  }

  .dropdown-item-icon {
    font-size: 18px;
    vertical-align: middle;
  }

  .user-dropdown img {
    transition: transform 0.2s;
  }

  .user-dropdown img:hover {
    transform: scale(1.05);
  }
</style>
