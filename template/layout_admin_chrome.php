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
<div id="sidebarBackdrop" class="fixed inset-0 bg-gov-blue-950/50 z-30 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full lg:translate-x-0 transition-transform duration-300
              bg-gradient-to-b from-gov-blue-900 to-gov-blue-950 text-white flex flex-col shadow-soft-raised-lg">
  <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
    <div class="flex h-11 w-11 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 shadow-soft-raised-sm">
      <i class="fas fa-building-columns text-gov-blue-950"></i>
    </div>
    <div>
      <p class="font-serif font-bold text-sm leading-tight">DISDUKCAPIL</p>
      <p class="text-xs text-white/60">Kota Padang</p>
    </div>
    <button id="sidebarClose" type="button" class="ml-auto lg:hidden text-white/70 hover:text-white min-h-[44px] min-w-[44px] flex items-center justify-center">
      <i class="fas fa-xmark"></i>
    </button>
  </div>

  <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
    <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
      <a href="<?= getDashboardUrl(); ?>"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= (isActive('admin') || isActive('kepalaDinas') || isActive('staff')) ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-home w-5 text-center"></i>
        <span>Dashboard</span>
      </a>
    <?php endif; ?>

    <?php if (hasRole('admin')): ?>
      <div class="pt-2">
        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chev').classList.toggle('rotate-180')"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] text-white/75 hover:bg-white/5 hover:text-white transition-colors">
          <i class="fas fa-database w-5 text-center"></i>
          <span>Master Data</span>
          <i class="fas fa-chevron-down chev ml-auto text-xs transition-transform"></i>
        </button>
        <div class="pl-4 mt-1 space-y-1 <?= (isActive('alternatif') || isActive('kriteria')) ? '' : 'hidden' ?>">
          <a href="index.php?controller=alternatif&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-colors
                    <?= isActive('alternatif') ? 'bg-white/10 text-white font-medium' : 'text-white/65 hover:bg-white/5 hover:text-white' ?>">
            <i class="fas fa-list-alt w-5 text-center text-xs"></i>
            <span>Alternatif</span>
          </a>
          <a href="index.php?controller=kriteria&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-colors
                    <?= isActive('kriteria') ? 'bg-white/10 text-white font-medium' : 'text-white/65 hover:bg-white/5 hover:text-white' ?>">
            <i class="fas fa-sliders-h w-5 text-center text-xs"></i>
            <span>Kriteria</span>
          </a>
          <a href="index.php?controller=subKriteria&action=index"
             class="flex items-center gap-3 px-4 py-2.5 rounded-gov text-sm min-h-[44px] transition-colors
                    <?= isActive('subKriteria') ? 'bg-white/10 text-white font-medium' : 'text-white/65 hover:bg-white/5 hover:text-white' ?>">
            <i class="fas fa-layer-group w-5 text-center text-xs"></i>
            <span>Sub Kriteria</span>
          </a>
        </div>
      </div>

      <a href="index.php?controller=responden&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= isActive('responden') ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-users w-5 text-center"></i>
        <span>Responden</span>
      </a>

      <a href="index.php?controller=penilaian&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= isActive('penilaian') ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-clipboard-check w-5 text-center"></i>
        <span>Penilaian</span>
      </a>

      <a href="index.php?controller=hasil&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= isActive('hasil') ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-chart-line w-5 text-center"></i>
        <span>Hasil Akhir</span>
      </a>
    <?php endif; ?>

    <?php if (hasRole('kepala_dinas')): ?>
      <a href="index.php?controller=penilaian&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= isActive('penilaian') ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-clipboard-check w-5 text-center"></i>
        <span>Penilaian</span>
      </a>

      <a href="index.php?controller=laporan&action=index"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] transition-colors
                <?= isActive('laporan') ? 'bg-white/10 border-l-4 border-gov-gold-400 text-white' : 'text-white/75 hover:bg-white/5 hover:text-white' ?>">
        <i class="fas fa-file-pdf w-5 text-center"></i>
        <span>Laporan</span>
      </a>
    <?php endif; ?>
  </nav>

  <?php if (hasRole(['admin', 'kepala_dinas', 'staff'])): ?>
    <div class="p-3 border-t border-white/10">
      <a href="<?= $logoutUrl ?>"
         class="flex items-center gap-3 px-4 py-3 rounded-gov text-sm font-medium min-h-[44px] text-white/75 hover:bg-gov-maroon-700/40 hover:text-white transition-colors">
        <i class="fas fa-sign-out-alt w-5 text-center"></i>
        <span>Keluar</span>
      </a>
    </div>
  <?php endif; ?>
</aside>

<!-- Main column -->
<div class="flex-1 flex flex-col min-w-0 lg:pl-72">
  <!-- Topbar -->
  <header class="sticky top-0 z-20 flex items-center gap-4 bg-surface-card/95 backdrop-blur border-b border-slate-200 px-4 sm:px-6 py-3 shadow-soft-raised-sm">
    <button id="sidebarOpen" type="button" class="lg:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-gov text-gov-blue-800 hover:bg-gov-blue-100">
      <i class="fas fa-bars text-lg"></i>
    </button>
    <div class="flex-1"></div>
    <div class="relative" id="userMenuWrapper">
      <button id="userMenuButton" type="button" class="flex items-center gap-3 rounded-gov px-2 py-1.5 hover:bg-gov-blue-100 transition-colors min-h-[44px]">
        <div class="h-9 w-9 rounded-full bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 flex items-center justify-center text-white shadow-soft-raised-sm">
          <i class="fas fa-user text-sm"></i>
        </div>
        <div class="hidden sm:block text-left">
          <p class="text-sm font-semibold text-slate-800 leading-tight"><?= htmlspecialchars($nama) ?></p>
          <p class="text-xs text-slate-500 leading-tight"><?= htmlspecialchars($roleDisplay) ?></p>
        </div>
        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
      </button>
      <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-56 card-gov !p-2 z-30">
        <div class="px-3 py-2 border-b border-slate-200 mb-1">
          <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($nama) ?></p>
          <p class="text-xs text-slate-500">Role: <?= htmlspecialchars($roleDisplay) ?></p>
        </div>
        <?php if (in_array($userRole, ['admin', 'kepala_dinas', 'staff'])): ?>
          <a href="<?= getDashboardUrl(); ?>" class="flex items-center gap-2 px-3 py-2 rounded-gov text-sm text-slate-700 hover:bg-gov-blue-100">
            <i class="fas fa-gauge text-gov-blue-700 w-4"></i> Dashboard
          </a>
          <a href="<?= $logoutUrl ?>" class="flex items-center gap-2 px-3 py-2 rounded-gov text-sm text-gov-maroon-700 hover:bg-red-50">
            <i class="fas fa-power-off w-4"></i> Keluar
          </a>
        <?php else: ?>
          <a href="index.php?controller=auth&action=index" class="flex items-center gap-2 px-3 py-2 rounded-gov text-sm text-slate-700 hover:bg-gov-blue-100">
            <i class="fas fa-right-to-bracket w-4"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Page content -->
  <main class="flex-1 px-4 sm:px-6 py-6">
