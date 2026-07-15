<?php $page_title = 'Login - DISDUKCAPIL Kota Padang'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/app.css?v=<?= filemtime('assets/css/app.css') ?>">
</head>
<body class="font-sans bg-slate-50 min-h-screen text-slate-700 antialiased relative">

  <!-- Background decorative vectors/waves -->
  <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-20">
    <svg class="absolute -left-10 -bottom-20 w-[600px] h-[600px] text-gov-blue-100" viewBox="0 0 200 200" fill="currentColor">
      <path d="M45.5,-75C59.2,-68.8,70.7,-56.9,78.2,-42.6C85.7,-28.3,89.1,-11.7,86.6,4C84.1,19.6,75.7,34.3,65.8,46.9C55.9,59.5,44.4,70.1,30.8,75.8C17.2,81.4,1.5,82.2,-14,79C-29.6,75.9,-45.1,68.9,-57.4,58C-69.7,47.1,-78.9,32.4,-82.9,16.5C-86.8,0.7,-85.6,-16.3,-78.9,-30.7C-72.2,-45.1,-60.1,-56.8,-46.7,-63.2C-33.4,-69.6,-18.8,-70.7,-2.4,-67.2C13.9,-63.7,28.8,-62.7,45.5,-75Z" transform="translate(100 100)" />
    </svg>
    <svg class="absolute right-0 top-0 w-[500px] h-[500px] text-indigo-50" viewBox="0 0 200 200" fill="currentColor">
      <path d="M42.7,-72.6C55.3,-67.8,65.6,-56.3,73.5,-43.1C81.4,-29.9,86.9,-15,87.6,0.4C88.2,15.8,84.1,31.5,76.5,45.2C68.9,58.8,57.8,70.2,44.3,76.9C30.8,83.5,15.4,85.3,0.3,84.8C-14.8,84.3,-29.6,81.5,-43,74.7C-56.5,67.8,-68.5,57,-76.3,43.3C-84.1,29.6,-87.7,13.1,-87,-3C-86.3,-19.1,-81.3,-34.8,-72.5,-47.5C-63.7,-60.2,-51.1,-69.9,-37.6,-74.2C-24.1,-78.5,-12,-77.3,1.3,-79.6C14.7,-81.9,29.3,-87.7,42.7,-72.6Z" transform="translate(100 100)" />
    </svg>
  </div>

  <div class="min-h-screen flex flex-col lg:flex-row relative z-10">
    <!-- Left institutional panel (Light Theme - Packed with elements) -->
    <div class="hidden lg:flex flex-1 bg-gradient-to-br from-white via-slate-50/80 to-gov-blue-50/30 relative overflow-hidden items-center justify-center p-12 border-r border-slate-200/60">
      <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 1px 1px, #94a3b8 1px, transparent 0); background-size: 20px 20px;"></div>

      <div class="relative z-10 text-left max-w-xl">
        <!-- Badge -->
        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider text-gov-blue-800 bg-gov-blue-100 border border-gov-blue-200/30 mb-6">
          <i class="fas fa-circle-nodes text-[8px] animate-pulse"></i> Dinas Kependudukan dan Pencatatan Sipil Kota Padang
        </span>
        
        <!-- Seal & Title Block -->
        <div class="flex items-center gap-4 mb-6">
          <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-b from-gov-blue-700 to-gov-blue-900 text-white shadow-soft-raised">
            <i class="fas fa-building-columns text-2xl"></i>
          </div>
          <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Portal Administrator</p>
            <h1 class="font-sans text-2xl font-extrabold text-slate-900 tracking-tight leading-none mt-0.5">
              SI-IKM SMART
            </h1>
          </div>
        </div>

        <h2 class="font-sans text-3xl font-black text-slate-800 tracking-tight leading-snug mb-4">
          Sistem Informasi Indeks <br>
          <span class="text-gov-blue-800">Kepuasan Masyarakat (IKM)</span>
        </h2>
        
        <p class="text-sm text-slate-500 mb-8 font-medium leading-relaxed">
          Menggunakan Algoritma keputusan cerdas **SMART (Simple Multi-Attribute Rating Technique)** untuk mengukur dan meningkatkan kualitas pelayanan kependudukan secara berkala.
        </p>
        <!-- NEW ELEMENT: Evaluated Services Badges (Adds details and looks very professional) -->
        <div>
          <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <i class="fas fa-layer-group text-gov-blue-700"></i> Layanan Utama yang Dievaluasi:
          </p>
          <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-slate-100/60 border border-slate-200/40 text-xs font-bold text-slate-700">
              <i class="fas fa-id-card text-gov-blue-800 text-sm"></i>
              <span>KTP Elektronik</span>
            </div>
            <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-slate-100/60 border border-slate-200/40 text-xs font-bold text-slate-700">
              <i class="fas fa-users-viewfinder text-gov-blue-800 text-sm"></i>
              <span>Kartu Keluarga</span>
            </div>
            <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-slate-100/60 border border-slate-200/40 text-xs font-bold text-slate-700">
              <i class="fas fa-baby text-gov-blue-800 text-sm"></i>
              <span>Akta Kelahiran</span>
            </div>
            <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-slate-100/60 border border-slate-200/40 text-xs font-bold text-slate-700">
              <i class="fas fa-address-card text-gov-blue-800 text-sm"></i>
              <span>Kartu Identitas Anak (KIA)</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right form panel (Light Theme) -->
    <div class="flex-1 flex items-center justify-center px-6 py-16">
      <div class="w-full max-w-md">
        <div class="bg-white border border-slate-200 p-8 sm:p-10 rounded-2xl shadow-soft-raised-lg relative overflow-hidden">
          <!-- TOP FLAG STRIPE: Merah Putih Indonesia (Sangat formal & eye catching) -->
          <div class="absolute top-0 inset-x-0 h-1.5 flex">
            <div class="flex-1 bg-red-600"></div>
            <div class="flex-1 bg-slate-150"></div>
          </div>

          <!-- Logo & Header -->
          <div class="mb-8 text-center mt-2">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-xl bg-slate-50 border border-slate-200 shadow-soft p-2 hover:scale-105 transition-transform">
              <img src="assets/images/logo-pdf.png" alt="Logo Disdukcapil" class="h-full w-auto object-contain">
            </div>
            <h2 class="font-sans text-2xl font-black text-slate-800 tracking-tight">Selamat Datang</h2>
            <p class="text-slate-400 mt-1 font-extrabold text-[10px] uppercase tracking-wider">Portal Administrator IKM</p>
          </div>

          <form method="POST" action="index.php?controller=auth&action=login" class="space-y-5" data-loading-label="Memproses...">
            <!-- Username Input -->
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Username</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                  <i class="fas fa-user text-sm"></i>
                </div>
                <input type="text" name="username" required 
                       class="input-gov pl-11 w-full bg-slate-50/50 border-slate-200 text-slate-800 placeholder-slate-450 focus:bg-white focus:border-gov-blue-800 focus:ring-gov-blue-800/10" 
                       placeholder="Masukkan username Anda">
              </div>
            </div>

            <!-- Password Input -->
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Password</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                  <i class="fas fa-lock text-sm"></i>
                </div>
                <input type="password" name="password" required id="passwordInput" 
                       class="input-gov pl-11 pr-12 w-full bg-slate-50/50 border-slate-200 text-slate-800 placeholder-slate-450 focus:bg-white focus:border-gov-blue-800 focus:ring-gov-blue-800/10" 
                       placeholder="Masukkan password Anda">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                  <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
              </div>
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full !py-3.5 !min-h-[48px] bg-gradient-to-r from-gov-blue-800 to-gov-blue-900 hover:from-gov-blue-900 hover:to-indigo-950 text-white rounded-xl shadow-soft hover:shadow-soft-raised transform active:scale-98 transition-all duration-200 uppercase font-bold tracking-widest text-xs">
              <i class="fas fa-sign-in-alt mr-1"></i> Masuk Aplikasi
            </button>
          </form>

          <!-- Back to Beranda Link -->
          <div class="mt-8 text-center pt-5 border-t border-slate-100 flex flex-col items-center gap-3">
            <a href="index.php?controller=landing&action=index" class="text-xs uppercase font-extrabold tracking-wider text-gov-blue-800 hover:text-gov-blue-900 transition-colors flex items-center justify-center gap-1.5">
              <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
          </div>
        </div>

        <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-8">
          &copy; <?= date('Y') ?> DISDUKCAPIL Kota Padang. All Rights Reserved.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if (!empty($_SESSION['error'])): ?>
      window.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: "<?= addslashes($_SESSION['error']) ?>",
          confirmButtonText: 'Coba Lagi',
          confirmButtonColor: '#B91C1C'
        });
      });
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      window.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: "<?= addslashes($_SESSION['success']) ?>",
          confirmButtonText: 'OK',
          confirmButtonColor: '#2456A6'
        });
      });
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    function togglePassword() {
      const input = document.getElementById('passwordInput');
      const icon = document.getElementById('toggleIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>
</body>
</html>

