<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Kuesioner Kepuasan Masyarakat - DISDUKCAPIL Kota Padang</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            primary: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            }
          }
        }
      }
    }
  </script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    /* Glassmorphism Premium */
    .glass {
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border: 1px solid rgba(255, 255, 255, 0.8);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .glass-strong {
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(30px);
      -webkit-backdrop-filter: blur(30px);
      border: 1px solid rgba(255, 255, 255, 0.9);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    /* Custom Cursor */
    .custom-cursor {
      position: fixed;
      width: 20px;
      height: 20px;
      border: 2px solid #0ea5e9;
      border-radius: 50%;
      pointer-events: none;
      z-index: 10000;
      transition: transform 0.15s ease-out, background 0.15s ease-out;
      transform: translate(-50%, -50%);
    }

    .custom-cursor-dot {
      position: fixed;
      width: 8px;
      height: 8px;
      background: #0ea5e9;
      border-radius: 50%;
      pointer-events: none;
      z-index: 10001;
      transform: translate(-50%, -50%);
    }

    .custom-cursor.hover {
      transform: translate(-50%, -50%) scale(1.5);
      background: rgba(14, 165, 233, 0.1);
    }

    /* Scroll Progress Bar */
    .scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3px;
      background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
      z-index: 10002;
      transition: width 0.1s ease-out;
    }

    /* Particles Container */
    #particles-js {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
      pointer-events: none;
    }

    /* Parallax Background Layer */
    .parallax-layer {
      position: fixed;
      border-radius: 50%;
      filter: blur(60px);
      opacity: 0.15;
      z-index: 0;
      pointer-events: none;
      transition: transform 0.3s ease-out;
    }

    .parallax-1 {
      width: 600px;
      height: 600px;
      background: linear-gradient(135deg, #0ea5e9, #8b5cf6);
      top: -200px;
      right: -200px;
    }

    .parallax-2 {
      width: 500px;
      height: 500px;
      background: linear-gradient(135deg, #8b5cf6, #ec4899);
      bottom: -150px;
      left: -150px;
    }

    .parallax-3 {
      width: 400px;
      height: 400px;
      background: linear-gradient(135deg, #0ea5e9, #06b6d4);
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    /* Typing Animation */
    .typing-cursor {
      display: inline-block;
      width: 3px;
      height: 1.2em;
      background: #0ea5e9;
      margin-left: 4px;
      animation: blink 1s infinite;
      vertical-align: text-bottom;
    }

    @keyframes blink {
      0%, 50% { opacity: 1; }
      51%, 100% { opacity: 0; }
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar.scrolled .glass {
      background: rgba(255, 255, 255, 0.85);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .nav-link {
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
      width: 100%;
    }

    /* Main Content */
    .main-content {
      position: relative;
      z-index: 10;
      padding-top: 100px;
    }

    /* Shimmer Glow Effect */
    @keyframes shimmer {
      0% {
        background-position: -100% 0;
      }
      100% {
        background-position: 200% 0;
      }
    }

    .shimmer-glow {
      background: linear-gradient(90deg, #0ea5e9 0%, #8b5cf6 50%, #0ea5e9 100%);
      background-size: 200% 100%;
      animation: shimmer 3s infinite;
    }

    /* SweetAlert2 Scale Down & Blur */
    .swal2-popup {
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .swal2-show {
      animation: fadeInScale 0.3s ease-out;
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    /* Gradient Text */
    .gradient-text {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .parallax-layer {
        display: none;
      }
    }
  </style>
</head>

<body>

  <!-- Scroll Progress Bar -->
  <div class="scroll-progress" id="scrollProgress"></div>

  <!-- Custom Cursor -->
  <div class="custom-cursor" id="customCursor"></div>
  <div class="custom-cursor-dot" id="customCursorDot"></div>

  <!-- Particles Background -->
  <div id="particles-js"></div>

  <!-- Parallax Background Layers -->
  <div class="parallax-layer parallax-1" data-speed="0.05"></div>
  <div class="parallax-layer parallax-2" data-speed="0.08"></div>
  <div class="parallax-layer parallax-3" data-speed="0.03"></div>

  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="glass">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
          <!-- Logo & Brand -->
          <div class="flex items-center space-x-3">
            <a href="index.php?controller=landing&action=index" class="flex items-center space-x-3 group">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-violet-500 flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                <i class="fas fa-landmark text-xl"></i>
              </div>
              <div>
                <div class="text-xl font-bold text-gray-900 group-hover:text-sky-600 transition-colors">DISDUKCAPIL</div>
                <div class="text-xs text-gray-600">Kota Padang</div>
              </div>
            </a>
          </div>

          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-1">
            <a href="index.php?controller=landing&action=index" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium transition-all">
              <i class="fas fa-home mr-2"></i>Beranda
            </a>
            <a href="#kuesioner" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium transition-all">
              <i class="fas fa-clipboard-list mr-2"></i>Kuesioner
            </a>
            <a href="#tentang" class="nav-link px-4 py-2 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium transition-all">
              <i class="fas fa-info-circle mr-2"></i>Tentang
            </a>
            <a href="index.php?controller=auth&action=login" class="ml-2 px-6 py-2.5 rounded-xl shimmer-glow text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
          </div>

          <!-- Mobile Menu Button -->
          <button class="md:hidden p-2 rounded-lg hover:bg-sky-50 text-gray-700" id="mobileMenuBtn">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden pb-4" id="mobileMenu">
          <div class="flex flex-col space-y-2">
            <a href="index.php?controller=landing&action=index" class="nav-link px-4 py-3 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium">
              <i class="fas fa-home mr-2"></i>Beranda
            </a>
            <a href="#kuesioner" class="nav-link px-4 py-3 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium">
              <i class="fas fa-clipboard-list mr-2"></i>Kuesioner
            </a>
            <a href="#tentang" class="nav-link px-4 py-3 rounded-lg text-gray-700 hover:text-sky-600 hover:bg-sky-50 font-medium">
              <i class="fas fa-info-circle mr-2"></i>Tentang
            </a>
            <a href="index.php?controller=auth&action=login" class="px-4 py-3 rounded-xl shimmer-glow text-white font-semibold text-center">
              <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" id="mainContainer">

      <!-- Hero Section -->
      <div class="text-center mb-16" data-aos="fade-up" data-aos-duration="1000">
        <div class="inline-flex items-center px-4 py-2 rounded-full glass mb-6" data-aos="fade-down" data-aos-delay="200">
          <i class="fas fa-star text-yellow-500 mr-2"></i>
          <span class="text-sm font-semibold text-gray-800">Survei Kepuasan Masyarakat 2025</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 leading-tight" data-aos="fade-up" data-aos-delay="300">
          Suara Anda Membangun<br>
          <span class="bg-gradient-to-r from-sky-500 to-violet-500 bg-clip-text text-transparent">Layanan Kami</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-4">
          DISDUKCAPIL Kota Padang
        </p>
        <p class="text-lg text-gray-500" id="typingSubtitle">
          <span id="typingText"></span><span class="typing-cursor"></span>
        </p>
      </div>

      <!-- Kuesioner Form -->
      <div id="kuesioner" class="max-w-5xl mx-auto" data-aos="fade-up" data-aos-delay="400">
        <form method="POST" action="index.php?controller=Penilaiankuesioner&action=submit" id="kuesionerForm" class="glass-strong rounded-3xl p-8 md:p-12 shadow-2xl">

          <!-- Form Header -->
          <div class="text-center mb-12">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-sky-500 to-violet-500 flex items-center justify-center text-white shadow-lg">
              <i class="fas fa-poll text-3xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">Kuesioner Kepuasan Masyarakat</h2>
            <p class="text-gray-600 text-lg">Mohon luangkan waktu sejenak untuk memberikan penilaian Anda</p>
          </div>

          <!-- Data Diri Section -->
          <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
              <div class="w-10 h-10 mr-3 rounded-xl bg-gradient-to-br from-sky-500 to-violet-500 flex items-center justify-center text-white shadow-md">
                <i class="fas fa-user-circle"></i>
              </div>
              Identitas Responden
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nama Lengkap -->
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                  Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 outline-none transition-all duration-300 bg-white/50 backdrop-blur-sm"
                       name="nama_responden"
                       placeholder="Masukkan nama lengkap atau anonim"
                       required
                       maxlength="100">
                <p class="mt-2 text-sm text-gray-500">
                  <i class="fas fa-info-circle mr-1"></i>
                  Bisa menggunakan nama anonim (contoh: "Warga 001")
                </p>
              </div>

              <!-- Usia -->
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                  Usia <span class="text-red-500">*</span>
                </label>
                <input type="number"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 outline-none transition-all duration-300 bg-white/50 backdrop-blur-sm"
                       name="usia"
                       placeholder="Usia dalam tahun"
                       required
                       min="1"
                       max="120">
                <p class="mt-2 text-sm text-gray-500">
                  <i class="fas fa-birthday-cake mr-1"></i>
                  Rentang: 1-120 tahun
                </p>
              </div>

              <!-- Pekerjaan -->
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                  Pekerjaan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 outline-none transition-all duration-300 bg-white/50 backdrop-blur-sm"
                       name="pekerjaan"
                       placeholder="Contoh: Pelajar, PNS, Wiraswasta"
                       required
                       maxlength="50">
                <p class="mt-2 text-sm text-gray-500">
                  <i class="fas fa-briefcase mr-1"></i>
                  Pekerjaan saat ini
                </p>
              </div>
            </div>
          </div>

          <!-- Penilaian Section -->
          <div class="mb-12" data-aos="fade-up" data-aos-delay="300">
            <h3 class="text-2xl font-bold text-gray-900 mb-3 flex items-center">
              <div class="w-10 h-10 mr-3 rounded-xl bg-gradient-to-br from-sky-500 to-violet-500 flex items-center justify-center text-white shadow-md">
                <i class="fas fa-star"></i>
              </div>
              Penilaian Layanan
            </h3>
            <p class="text-gray-600 mb-8 text-center bg-sky-50 rounded-xl p-4">
              <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
              Berikan penilaian untuk layanan yang pernah Anda gunakan. Opsional & Fleksibel.
            </p>

            <?php foreach ($data['alternatifs'] as $altIndex => $alternatif): ?>
              <div class="mb-8 p-6 rounded-2xl bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 hover:border-sky-200 transition-all duration-300 hover:shadow-lg" data-aos="fade-up" data-aos-delay="<?= ($altIndex + 1) * 100 ?>">
                <!-- Layanan Header -->
                <div class="mb-6 pb-4 border-b-2 border-gray-100">
                  <h4 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                    <div class="w-10 h-10 mr-3 rounded-xl bg-gradient-to-br from-sky-500 to-violet-500 flex items-center justify-center text-white shadow-md flex-shrink-0">
                      <span class="font-bold"><?= $altIndex + 1 ?></span>
                    </div>
                    <?= htmlspecialchars($alternatif['nama_layanan']) ?>
                  </h4>
                  <?php if (!empty($alternatif['deskripsi'])): ?>
                    <p class="text-gray-600 pl-13">
                      <i class="fas fa-info-circle text-sky-500 mr-2"></i>
                      <?= htmlspecialchars($alternatif['deskripsi']) ?>
                    </p>
                  <?php endif; ?>
                </div>

                <!-- Kriteria -->
                <div class="space-y-4">
                  <?php foreach ($data['kriterias'] as $kriteria): ?>
                    <div class="p-5 rounded-xl bg-white border-2 border-gray-100 hover:border-sky-100 transition-all duration-300" data-aos="fade-up" data-aos-delay="<?= ($altIndex * 100) + 50 ?>">
                      <!-- Kriteria Header -->
                      <div class="mb-4">
                        <span class="inline-block px-3 py-1 rounded-lg bg-gradient-to-r from-sky-500 to-violet-500 text-white text-xs font-bold mb-2">
                          <?= htmlspecialchars($kriteria['kode_kriteria']) ?>
                        </span>
                        <h5 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($kriteria['nama_kriteria']) ?></h5>
                        <?php if (!empty($kriteria['pertanyaan'])): ?>
                          <p class="text-gray-700 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-400 rounded-r-lg p-3 italic">
                            <i class="fas fa-quote-left text-yellow-500 mr-2"></i>
                            <?= htmlspecialchars($kriteria['pertanyaan']) ?>
                          </p>
                        <?php endif; ?>
                      </div>

                      <!-- Select Penilaian -->
                      <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Penilaian Anda</label>
                        <select class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 outline-none transition-all duration-300 bg-white kriteria-select"
                                name="id_sub_<?= $alternatif['id_alternatif'] ?>_<?= $kriteria['id_kriteria'] ?>">
                          <option value="">-- Tidak Menilai --</option>
                          <?php
                            $subs = $data['penilaianModel']->getSubKriteriaByKriteria($kriteria['id_kriteria']);
                            foreach ($subs as $sub): ?>
                          <option value="<?= $sub['id_sub'] ?>" data-nilai="<?= $sub['nilai_utility'] ?>">
                            <?= htmlspecialchars($sub['nama_pilihan']) ?> (Nilai: <?= $sub['nilai_utility'] ?>%)
                          </option>
                        <?php endforeach; ?>
                        </select>
                      </div>

                      <!-- Utility Preview -->
                      <div class="utility-preview mt-4 p-4 rounded-xl bg-gray-50 border-2 border-gray-100 hidden" id="utility_preview_<?= $alternatif['id_alternatif'] ?>_<?= $kriteria['id_kriteria'] ?>">
                        <div class="h-3 bg-gray-200 rounded-full overflow-hidden mb-2">
                          <div class="utility-fill h-full rounded-full transition-all duration-600" style="width: 0%"></div>
                        </div>
                        <div class="text-center text-sm text-gray-600">
                          Indeks Kepuasan: <strong class="text-lg nilai-display">0</strong>%
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Submit Section -->
          <div class="text-center pt-8 border-t-2 border-gray-100" data-aos="fade-up" data-aos-delay="600">
            <p class="text-gray-600 mb-6">
              <i class="fas fa-shield-alt text-sky-500 mr-2"></i>
              Data Anda kami jaga kerahasiaannya sesuai peraturan perundang-undangan
            </p>
            <button type="submit" class="px-12 py-4 rounded-xl shimmer-glow text-white font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105">
              <i class="fas fa-paper-plane mr-2"></i>
              Kirim Penilaian
            </button>
          </div>

        </form>
      </div>

      <!-- Footer -->
    </div>
  </main>

  <footer class="py-20 bg-gradient-to-b from-gray-50 to-gray-100 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
        <div data-aos="fade-up">
          <div class="flex items-center mb-6">
            <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-xl">
              <i class="fas fa-building-columns text-white text-2xl"></i>
            </div>
            <span class="text-2xl font-black gradient-text">DISDUKCAPIL</span>
          </div>
          <p class="text-gray-600 leading-relaxed mb-4 font-medium">
            Dinas Kependudukan dan Pencatatan Sipil Kota Padang
          </p>
          <p class="text-gray-500 text-sm">
            Melayani dengan sepenuh hati untuk masyarakat Kota Padang
          </p>
        </div>

        <div data-aos="fade-up" data-aos-delay="100">
          <h4 class="text-xl font-black mb-6 text-gray-900">Kontak Kami</h4>
          <div class="space-y-4">
            <div class="flex items-center text-gray-600">
              <i class="fas fa-map-marker-alt w-7 text-indigo-600 text-xl"></i>
              <span class="ml-4 font-medium">Kota Padang, Sumatera Barat</span>
            </div>
            <div class="flex items-center text-gray-600">
              <i class="fas fa-phone w-7 text-indigo-600 text-xl"></i>
              <span class="ml-4 font-medium">(0751) 123456</span>
            </div>
            <div class="flex items-center text-gray-600">
              <i class="fas fa-envelope w-7 text-indigo-600 text-xl"></i>
              <span class="ml-4 font-medium">info@disdukcapil.padang.go.id</span>
            </div>
            <div class="flex items-center text-gray-600">
              <i class="fas fa-clock w-7 text-indigo-600 text-xl"></i>
              <span class="ml-4 font-medium">Senin - Jumat: 08.00 - 16.00 WIB</span>
            </div>
          </div>
        </div>

        <div data-aos="fade-up" data-aos-delay="200">
          <h4 class="text-xl font-black mb-6 text-gray-900">Tautan Cepat</h4>
          <div class="space-y-3">
            <a href="index.php?controller=landing&action=index#beranda" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
              <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
              <span class="ml-3">Beranda</span>
            </a>
            <a href="index.php?controller=landing&action=index#tentang" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
              <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
              <span class="ml-3">Tentang Kami</span>
            </a>
            <a href="index.php?controller=landing&action=index#visi" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
              <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
              <span class="ml-3">Visi</span>
            </a>
            <a href="index.php?controller=landing&action=index#misi" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
              <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
              <span class="ml-3">Misi</span>
            </a>
            <a href="index.php?controller=auth&action=login" class="interactive flex items-center text-gray-600 hover:text-indigo-600 transition-colors font-medium">
              <i class="fas fa-chevron-right w-5 text-indigo-600"></i>
              <span class="ml-3">Login</span>
            </a>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-300 pt-10 text-center" data-aos="fade-up">
        <p class="text-gray-500 font-medium">
          &copy; <?= date('Y') ?> Dinas Kependudukan dan Pencatatan Sipil Kota Padang. All Rights Reserved.
        </p>
      </div>
    </div>
  </footer>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- AOS Animation -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 100
    });

    // Custom Cursor
    const cursor = document.getElementById('customCursor');
    const cursorDot = document.getElementById('customCursorDot');

    document.addEventListener('mousemove', (e) => {
      cursor.style.left = e.clientX + 'px';
      cursor.style.top = e.clientY + 'px';
      cursorDot.style.left = e.clientX + 'px';
      cursorDot.style.top = e.clientY + 'px';
    });

    // Add hover effect on interactive elements
    document.querySelectorAll('a, button, input, select').forEach(el => {
      el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
      el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
    });

    // Scroll Progress Bar
    window.addEventListener('scroll', () => {
      const scrollProgress = document.getElementById('scrollProgress');
      const scrollTop = document.documentElement.scrollTop;
      const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const progress = (scrollTop / scrollHeight) * 100;
      scrollProgress.style.width = progress + '%';
    });

    // Particles.js
    particlesJS('particles-js', {
      particles: {
        number: { value: 80, density: { enable: true, value_area: 800 } },
        color: { value: '#0ea5e9' },
        shape: { type: 'circle' },
        opacity: { value: 0.5, random: true },
        size: { value: 3, random: true },
        line_linked: {
          enable: true,
          distance: 150,
          color: '#0ea5e9',
          opacity: 0.2,
          width: 1
        },
        move: {
          enable: true,
          speed: 2,
          direction: 'none',
          random: false,
          straight: false,
          out_mode: 'out',
          bounce: false
        }
      },
      interactivity: {
        detect_on: 'canvas',
        events: {
          onhover: { enable: true, mode: 'repulse' },
          onclick: { enable: true, mode: 'push' },
          resize: true
        },
        modes: {
          repulse: { distance: 100, duration: 0.4 },
          push: { particles_nb: 4 }
        }
      },
      retina_detect: true
    });

    // Parallax Effect
    document.addEventListener('mousemove', (e) => {
      const layers = document.querySelectorAll('.parallax-layer');
      const x = (window.innerWidth - e.pageX * 2) / 100;
      const y = (window.innerHeight - e.pageY * 2) / 100;

      layers.forEach(layer => {
        const speed = layer.dataset.speed;
        layer.style.transform = `translate(${x * speed * 100}px, ${y * speed * 100}px)`;
      });
    });

    // Typing Animation
    const typingTexts = [
      'Partisipasi Anda sangat berharga bagi kami',
      'Bantu kami meningkatkan kualitas layanan',
      'Suara Anda membuat perbedaan'
    ];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typingElement = document.getElementById('typingText');

    function typeText() {
      const currentText = typingTexts[textIndex];

      if (isDeleting) {
        typingElement.textContent = currentText.substring(0, charIndex - 1);
        charIndex--;
      } else {
        typingElement.textContent = currentText.substring(0, charIndex + 1);
        charIndex++;
      }

      let typeSpeed = isDeleting ? 50 : 100;

      if (!isDeleting && charIndex === currentText.length) {
        typeSpeed = 2000;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        textIndex = (textIndex + 1) % typingTexts.length;
        typeSpeed = 500;
      }

      setTimeout(typeText, typeSpeed);
    }

    typeText();

    // Navbar Scroll Effect
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Mobile Menu Toggle
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
      const mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    });

    // Utility Preview
    document.querySelectorAll('.kriteria-select').forEach(select => {
      select.addEventListener('change', function() {
        const previewId = this.name.replace('id_sub_', 'utility_preview_');
        const previewDiv = document.getElementById(previewId);
        const selectedOption = this.options[this.selectedIndex];

        if (this.value && selectedOption.dataset.nilai) {
          const nilai = selectedOption.dataset.nilai;
          previewDiv.classList.remove('hidden');
          previewDiv.style.animation = 'fadeInScale 0.4s ease-out';

          const fill = previewDiv.querySelector('.utility-fill');
          const display = previewDiv.querySelector('.nilai-display');

          fill.style.width = '0%';
          setTimeout(() => {
            fill.style.width = nilai + '%';
            display.textContent = nilai;
          }, 100);

          if (nilai >= 80) {
            fill.style.background = 'linear-gradient(90deg, #10b981, #34d399)';
          } else if (nilai >= 60) {
            fill.style.background = 'linear-gradient(90deg, #3b82f6, #60a5fa)';
          } else if (nilai >= 40) {
            fill.style.background = 'linear-gradient(90deg, #f59e0b, #fbbf24)';
          } else {
            fill.style.background = 'linear-gradient(90deg, #ef4444, #f87171)';
          }
        } else {
          previewDiv.classList.add('hidden');
        }
      });
    });

    // Form Validation
    document.getElementById('kuesionerForm').addEventListener('submit', function(e) {
      const namaResponden = document.querySelector('input[name="nama_responden"]');
      const usia = document.querySelector('input[name="usia"]');
      const pekerjaan = document.querySelector('input[name="pekerjaan"]');
      let isValid = true;

      [namaResponden, usia, pekerjaan].forEach(el => {
        el.style.borderColor = '#e5e7eb';
      });

      if (!namaResponden.value.trim()) {
        e.preventDefault();
        namaResponden.style.borderColor = '#ef4444';
        namaResponden.focus();
        showAlert('Nama lengkap wajib diisi!');
        isValid = false;
      }

      if (!usia.value || usia.value < 1 || usia.value > 120) {
        e.preventDefault();
        usia.style.borderColor = '#ef4444';
        usia.focus();
        showAlert('Usia harus antara 1-120 tahun!');
        isValid = false;
      }

      if (!pekerjaan.value.trim()) {
        e.preventDefault();
        pekerjaan.style.borderColor = '#ef4444';
        pekerjaan.focus();
        showAlert('Pekerjaan wajib diisi!');
        isValid = false;
      }

      let hasRating = false;
      document.querySelectorAll('.kriteria-select').forEach(select => {
        if (select.value) {
          hasRating = true;
        }
      });

      if (!hasRating) {
        e.preventDefault();
        showAlert('Mohon memberikan penilaian untuk minimal satu layanan!');
        isValid = false;
      }

      if (isValid) {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
      }

      return isValid;
    });

    function showAlert(message) {
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: message,
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#0ea5e9',
        showClass: {
          popup: 'swal2-show',
          backdrop: 'swal2-backdrop-show',
          icon: 'swal2-icon-show'
        }
      });
    }

    function showDialog(message, type) {
      if (type === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Terima Kasih!',
          text: message,
          confirmButtonText: 'Mengerti',
          confirmButtonColor: '#0ea5e9',
          showClass: {
            popup: 'swal2-show',
            backdrop: 'swal2-backdrop-show',
            icon: 'swal2-icon-show'
          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Maaf',
          text: message,
          confirmButtonText: 'Mengerti',
          confirmButtonColor: '#0ea5e9',
          timer: 5000,
          timerProgressBar: true
        });
      }
    }

    <?php if (isset($_SESSION['error'])): ?>
      showDialog("<?= addslashes($_SESSION['error']) ?>", 'error');
      <?php unset($_SESSION['error']); endif;
    ?>

    <?php if (isset($_SESSION['success'])): ?>
      showDialog("<?= addslashes($_SESSION['success']) ?>", 'success');
      <?php unset($_SESSION['success']); endif;
    ?>
  </script>

</body>
</html>
