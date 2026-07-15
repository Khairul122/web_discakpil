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
<body class="font-sans bg-surface-page min-h-screen">

  <div class="min-h-screen flex">
    <!-- Left institutional panel -->
    <div class="hidden lg:flex flex-1 bg-gradient-to-br from-gov-blue-900 via-gov-blue-800 to-indigo-950 relative overflow-hidden items-center justify-center">
      <div class="absolute inset-0 opacity-15" style="background-image: radial-gradient(circle at 10% 10%, white 1.5px, transparent 1.5px); background-size: 32px 32px;"></div>
      <div class="absolute -top-40 -right-40 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="relative z-10 text-center px-12 max-w-lg">
        <div class="mx-auto mb-8 flex h-28 w-28 items-center justify-center rounded-full bg-white/10 border border-white/20 backdrop-blur-md shadow-soft-raised-lg">
          <i class="fas fa-building-columns text-5xl text-amber-300"></i>
        </div>
        <h1 class="font-sans text-2xl font-extrabold mb-4 text-white tracking-tight leading-snug">
          Sistem Informasi Penilaian Kepuasan Masyarakat
        </h1>
        <p class="text-sm text-white/80 mb-12 font-medium leading-relaxed">
          Terhadap Layanan Kantor Dinas Kependudukan dan Pencatatan Sipil Kota Padang Menggunakan Metode SMART
        </p>
        
        <div class="grid grid-cols-3 gap-4">
          <div class="rounded-gov-lg bg-white/10 border border-white/20 backdrop-blur-sm p-5 hover:bg-white/15 transition-all duration-300">
            <i class="fas fa-users text-2xl text-amber-300 mb-2.5"></i>
            <p class="text-2xl font-bold text-white">24+</p>
            <p class="text-xs text-white/70 font-semibold uppercase tracking-wider">Kecamatan</p>
          </div>
          <div class="rounded-gov-lg bg-white/10 border border-white/20 backdrop-blur-sm p-5 hover:bg-white/15 transition-all duration-300">
            <i class="fas fa-building text-2xl text-amber-300 mb-2.5"></i>
            <p class="text-2xl font-bold text-white">100+</p>
            <p class="text-xs text-white/70 font-semibold uppercase tracking-wider">Kelurahan</p>
          </div>
          <div class="rounded-gov-lg bg-white/10 border border-white/20 backdrop-blur-sm p-5 hover:bg-white/15 transition-all duration-300">
            <i class="fas fa-id-card text-2xl text-amber-300 mb-2.5"></i>
            <p class="text-2xl font-bold text-white">1M+</p>
            <p class="text-xs text-white/70 font-semibold uppercase tracking-wider">Penduduk</p>
          </div>
        </div>
        
        <p class="text-white/70 mt-12 leading-relaxed font-medium">Melayani dengan sepenuh hati untuk masyarakat Kota Padang</p>
      </div>
    </div>

    <!-- Right form panel -->
    <div class="flex-1 flex items-center justify-center px-6 py-12 bg-slate-50/50">
      <div class="w-full max-w-md">
        <div class="card-gov !p-8 sm:!p-10 shadow-soft-raised-lg bg-white border border-slate-100/80">
          <div class="mb-8 text-center lg:text-left">
            <div class="lg:hidden mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-gov bg-gradient-to-br from-gov-blue-800 to-gov-blue-700 shadow-soft-raised text-white">
              <i class="fas fa-building-columns"></i>
            </div>
            <h2 class="font-sans text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
            <p class="text-slate-500 mt-1 font-semibold text-sm">Silakan masuk ke akun Anda</p>
          </div>

          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-gov-error">
              <i class="fas fa-exclamation-circle text-lg mt-0.5"></i>
              <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['error']) ?></p>
            </div>
            <?php unset($_SESSION['error']); ?>
          <?php endif; ?>

          <form method="POST" action="index.php?controller=auth&action=login" class="space-y-5" data-loading-label="Memproses...">
            <div>
              <label class="label-gov"><i class="fas fa-user text-gov-blue-800 text-xs"></i> Username</label>
              <input type="text" name="username" required class="input-gov" placeholder="Masukkan username">
            </div>

            <div>
              <label class="label-gov"><i class="fas fa-lock text-gov-blue-800 text-xs"></i> Password</label>
              <div class="relative">
                <input type="password" name="password" required id="passwordInput" class="input-gov pr-12" placeholder="Masukkan password">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-gov-blue-800 transition-colors">
                  <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
              </div>
            </div>

            <button type="submit" class="btn-gov-primary w-full !py-3.5 !min-h-[50px] uppercase font-bold tracking-wider text-xs">
              <i class="fas fa-sign-in-alt"></i> Login
            </button>
          </form>

          <div class="mt-8 text-center">
            <a href="index.php?controller=landing&action=index" class="text-xs uppercase font-extrabold tracking-wider text-gov-blue-800 hover:text-gov-blue-900 transition-colors">
              <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
            </a>
          </div>
        </div>

        <p class="text-center text-slate-400 text-xs font-semibold uppercase tracking-wider mt-8">&copy; <?= date('Y') ?> Dinas Kependudukan dan Pencatatan Sipil Kota Padang</p>
      </div>
    </div>
  </div>

  <script>
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
