<?php
/**
 * Shared admin chrome (sidebar + topbar) - DISDUKCAPIL Kota Padang
 * Preserves role-based navigation logic from the legacy template/navbar.php + template/sidebar.php
 */

date_default_timezone_set("Asia/Jakarta");

$nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : (isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna');
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

$roleDisplay = 'Guest';
if ($userRole === 'admin') {
    $roleDisplay = 'Administrator';
} elseif ($userRole === 'kepala_dinas') {
    $roleDisplay = 'Kepala Dinas';
} elseif ($userRole === 'staff') {
    $roleDisplay = 'Staff';
}

function isActive($controller, $action = null)
{
    $currentController = isset($_GET['controller']) ? $_GET['controller'] : '';
    $currentAction = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === null) {
        return $currentController === $controller;
    }
    return $currentController === $controller && $currentAction === $action;
}

function hasRole($allowedRoles)
{
    $userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

    if ($allowedRoles === 'all') return true;

    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    return in_array($userRole, $allowedRoles);
}

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
            return 'index.php?controller=auth&action=logout';
    }
}

$logoutUrl = 'index.php?controller=' . ($_SESSION['role'] ?? 'auth') . '&action=logout';
?>

<!-- Sidebar backdrop (mobile) -->
<div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full lg:translate-x-0 transition-transform duration-300
              bg-white border-r border-slate-100 text-slate-700 flex flex-col shadow-soft-raised-lg">
  <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-100">
    <img src="assets/images/logo-nonpdf.png" alt="Logo DISDUKCAPIL Kota Padang" class="h-9 w-auto object-contain max-w-[170px]">
    <button id="sidebarClose" type="button" class="ml-auto lg:hidden text-slate-400 hover:text-slate-650 min-h-[44px] min-w-[44px] flex items-center justify-center">
      <i class="fas fa-xmark"></i>
    </button>
  </div>

  <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
      <a href="<?= getDashboardUrl(); ?>"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= (isActive('admin') || isActive('kepalaDinas') || isActive('staff')) ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-home w-5 text-center"></i>
        <span>Dashboard</span>
      </a>
    <?php endif; ?>

    <?php if (hasRole('admin')): ?>
      <div class="pt-2">
        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chev').classList.toggle('rotate-180')"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
          <i class="fas fa-database w-5 text-center"></i>
          <span>Master Data</span>
          <i class="fas fa-chevron-down chev ml-auto text-xs transition-transform"></i>
        </button>
        <div class="pl-4 mt-1 space-y-1 <?= (isActive('alternatif') || isActive('kriteria')) ? '' : 'hidden' ?>">
          <a href="index.php?controller=alternatif&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-all duration-200
                    <?= isActive('alternatif') ? 'bg-gov-blue-100 text-gov-blue-900 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
            <i class="fas fa-list-alt w-5 text-center text-xs"></i>
            <span>Alternatif</span>
          </a>
          <a href="index.php?controller=kriteria&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-all duration-200
                    <?= isActive('kriteria') ? 'bg-gov-blue-100 text-gov-blue-900 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
            <i class="fas fa-sliders-h w-5 text-center text-xs"></i>
            <span>Kriteria</span>
          </a>
          <a href="index.php?controller=subKriteria&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-all duration-200
                    <?= isActive('subKriteria') ? 'bg-gov-blue-100 text-gov-blue-900 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' ?>">
            <i class="fas fa-layer-group w-5 text-center text-xs"></i>
            <span>Sub Kriteria</span>
          </a>
        </div>
      </div>

      <a href="index.php?controller=responden&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= isActive('responden') ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-users w-5 text-center"></i>
        <span>Responden</span>
      </a>

      <a href="index.php?controller=penilaian&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= isActive('penilaian') ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-clipboard-check w-5 text-center"></i>
        <span>Penilaian</span>
      </a>

      <a href="index.php?controller=hasil&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= isActive('hasil') ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-chart-line w-5 text-center"></i>
        <span>Hasil Akhir</span>
      </a>

      <a href="index.php?controller=cetak&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= isActive('cetak') ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-print w-5 text-center"></i>
        <span>Cetak Laporan</span>
      </a>
    <?php endif; ?>

    <?php if (hasRole('kepala_dinas')): ?>
      <a href="index.php?controller=kepalaDinas&action=penilaian"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= (isActive('kepalaDinas', 'penilaian') || isActive('kepalaDinas', 'detailPenilaian')) ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-clipboard-list w-5 text-center"></i>
        <span>Data Penilaian</span>
      </a>

      <a href="index.php?controller=cetak&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-semibold min-h-[44px] transition-all duration-200
                <?= isActive('cetak') ? 'bg-gov-blue-100 text-gov-blue-800 border-l-4 border-gov-blue-800 shadow-soft-raised-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
        <i class="fas fa-print w-5 text-center"></i>
        <span>Cetak Laporan</span>
      </a>
    <?php endif; ?>
  </nav>
</aside>

<!-- Main column -->
<div class="flex-1 flex flex-col min-w-0 lg:pl-72">
  <!-- Topbar -->
  <header class="sticky top-0 z-20 flex items-center gap-4 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 sm:px-6 py-3 shadow-soft-raised-sm">
    <button id="sidebarOpen" type="button" class="lg:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-gov text-gov-blue-800 hover:bg-gov-blue-100">
      <i class="fas fa-bars text-lg"></i>
    </button>
    <div class="flex-1"></div>
    <div class="relative" id="userMenuWrapper">
      <button id="userMenuButton" type="button" class="flex items-center gap-3 rounded-gov px-2.5 py-1.5 hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all min-h-[44px]">
        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-gov-blue-800 to-gov-blue-700 flex items-center justify-center text-white shadow-soft-raised-sm">
          <i class="fas fa-user text-sm"></i>
        </div>
        <div class="hidden sm:block text-left">
          <p class="text-sm font-bold text-slate-800 leading-tight"><?= htmlspecialchars($nama) ?></p>
          <p class="text-[10px] text-slate-400 leading-tight uppercase font-extrabold tracking-wider mt-0.5"><?= htmlspecialchars($roleDisplay) ?></p>
        </div>
        <i class="fas fa-chevron-down text-xs text-slate-400 ml-1"></i>
      </button>
      <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-56 card-gov !p-2 z-30 shadow-soft-raised-lg border border-slate-150 bg-white">
        <div class="px-3 py-2 border-b border-slate-100 mb-1">
          <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($nama) ?></p>
          <p class="text-xs text-slate-400 mt-0.5">Role: <?= htmlspecialchars($roleDisplay) ?></p>
        </div>
        <?php if (in_array($userRole, ['admin', 'kepala_dinas', 'staff'])): ?>
          <a href="<?= getDashboardUrl(); ?>" class="flex items-center gap-2 px-3 py-2.5 rounded-gov text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <i class="fas fa-gauge text-gov-blue-800 w-4"></i> Dashboard
          </a>
          <a href="#" onclick="event.preventDefault(); govConfirmLogout('<?= $logoutUrl ?>')" class="flex items-center gap-2 px-3 py-2.5 rounded-gov text-sm text-rose-600 hover:bg-rose-50 transition-colors">
            <i class="fas fa-power-off w-4"></i> Keluar
          </a>
        <?php else: ?>
          <a href="index.php?controller=auth&action=index" class="flex items-center gap-2 px-3 py-2.5 rounded-gov text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
            <i class="fas fa-right-to-bracket w-4"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Page content -->
  <main class="flex-1 px-4 sm:px-6 py-6">
