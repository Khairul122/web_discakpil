<?php $page_title = $data['title'] ?? 'DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_public_head.php'); ?>

<!-- Hero Section -->
<section id="beranda" class="bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-50/80 text-slate-800 py-20 sm:py-28 relative overflow-hidden border-b border-slate-100">
  <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      <!-- Left Column: Copy & Actions -->
      <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-gov-blue-800 bg-gov-blue-100 border border-gov-blue-200/30">
          <span class="h-2 w-2 rounded-full bg-gov-blue-800 animate-ping"></span>
          Terintegrasi Secara Nasional
        </span>
        <h1 class="font-sans text-3xl sm:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight reveal-on-scroll is-visible">
          Sistem Informasi Penilaian <span class="bg-gradient-to-r from-gov-blue-800 to-gov-blue-700 bg-clip-text text-transparent">Kepuasan Masyarakat</span>
          <span class="text-base sm:text-lg font-bold text-slate-500 block mt-3 leading-relaxed">
            Terhadap Layanan Kantor Dinas Kependudukan dan Pencatatan Sipil Kota Padang
          </span>
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-amber-800 bg-amber-100 border border-amber-200/30 mt-2">
            Metode SMART
          </span>
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
          Mewujudkan pelayanan administrasi kependudukan yang prima, cepat, dan transparan melalui sistem kuesioner kepuasan berbasis metode keputusan terpadu.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <a href="#tentang" class="btn-gov-primary !min-h-[48px] px-8 text-sm uppercase font-bold tracking-wider">
            <i class="fas fa-compass"></i> Pelajari Selengkapnya
          </a>
          <a href="index.php?controller=penilaianKuesioner&action=index" class="btn-gov-gold !min-h-[48px] px-8 text-sm uppercase font-bold tracking-wider">
            <i class="fas fa-clipboard-list"></i> Isi Kuesioner
          </a>
        </div>
      </div>
      
      <!-- Right Column: Interactive Dashboard Mockup -->
      <div class="lg:col-span-5 hidden lg:block relative reveal-on-scroll is-visible" style="transition-delay: 200ms;">
        <!-- Glowing background behind mockup -->
        <div class="absolute inset-0 bg-gradient-to-tr from-gov-blue-800/10 to-indigo-500/10 rounded-gov-lg blur-2xl -z-10"></div>
        
        <!-- Main Mockup Card -->
        <div class="bg-white border border-slate-100 rounded-gov-lg p-6 shadow-soft-raised-lg relative max-w-sm mx-auto">
          <!-- Floating notification widget -->
          <div class="absolute -top-6 -left-6 bg-white border border-slate-100 p-4 rounded-gov shadow-soft-raised flex items-center gap-3 animate-bounce" style="animation-duration: 5s;">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
              <i class="fas fa-check text-sm"></i>
            </div>
            <div>
              <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">KTP-el Terbit</p>
              <p class="text-xs font-bold text-slate-800">100% Selesai</p>
            </div>
          </div>
          
          <!-- Floating rating badge -->
          <div class="absolute -bottom-6 -right-6 bg-white border border-slate-100 p-4 rounded-gov shadow-soft-raised flex flex-col gap-1 text-center">
            <div class="flex items-center gap-2 justify-center">
              <div class="flex h-7 w-7 items-center justify-center rounded-full bg-amber-50 text-amber-500">
                <i class="fas fa-star text-xs"></i>
              </div>
              <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">IKM Rate</p>
            </div>
            <p class="text-lg font-extrabold text-slate-800">4.87 / 5.0</p>
          </div>

          <!-- Service Tracker UI Inside Mockup -->
          <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
              <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Antrean Layanan</h4>
              <span class="badge-gov-primary !text-[9px]">Real-Time</span>
            </div>
            
            <div class="space-y-1.5">
              <div class="flex justify-between text-xs font-bold">
                <span class="text-slate-800">Kartu Keluarga</span>
                <span class="text-gov-blue-800">88%</span>
              </div>
              <div class="bar-gov-track"><div class="bar-gov-fill" style="width: 88%"></div></div>
            </div>
            
            <div class="space-y-1.5">
              <div class="flex justify-between text-xs font-bold">
                <span class="text-slate-800">Akta Kelahiran</span>
                <span class="text-gov-blue-800">95%</span>
              </div>
              <div class="bar-gov-track"><div class="bar-gov-fill" style="width: 95%"></div></div>
            </div>

            <!-- Inner Feedback Mock -->
            <div class="bg-slate-50 border border-slate-100 rounded-gov p-3 mt-4 text-[10px] text-slate-500 italic leading-relaxed">
              "Kuesioner kependudukan sangat mudah diisi, terimakasih layanannya cepat!"
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="tentang" class="py-20 sm:py-28 relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      <!-- Left Column: Statistics/Key Highlights -->
      <div class="lg:col-span-5 space-y-6">
        <div class="grid grid-cols-2 gap-4">
          <div class="card-gov text-center p-6 hover:-translate-y-1.5 transition-all duration-300">
            <p class="text-3xl font-extrabold text-gov-blue-800 mb-1">98.4%</p>
            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Persentase Kepuasan</p>
          </div>
          <div class="card-gov text-center p-6 hover:-translate-y-1.5 transition-all duration-300">
            <p class="text-3xl font-extrabold text-gov-blue-800 mb-1">15 Mnt</p>
            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Pembuatan KIA Online</p>
          </div>
          <div class="card-gov text-center p-6 hover:-translate-y-1.5 transition-all duration-300">
            <p class="text-3xl font-extrabold text-gov-blue-800 mb-1">24 Jam</p>
            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Akses Portal Kuesioner</p>
          </div>
          <div class="card-gov text-center p-6 hover:-translate-y-1.5 transition-all duration-300">
            <p class="text-3xl font-extrabold text-gov-blue-800 mb-1">100%</p>
            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Transparansi Data</p>
          </div>
        </div>
      </div>

      <!-- Right Column: Text & Features -->
      <div class="lg:col-span-7 space-y-6">
        <h2 class="font-sans text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          <?= htmlspecialchars($data['tentang']['judul']) ?>
        </h2>
        <p class="text-slate-600 leading-relaxed font-medium">
          <?= htmlspecialchars($data['tentang']['deskripsi']) ?>
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <?php foreach ($data['tentang']['poin'] as $index => $poin): ?>
            <div class="flex gap-4 items-start p-3 hover:bg-slate-50 rounded-gov transition-all">
              <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-gov bg-gov-blue-100 text-gov-blue-800 shadow-soft-raised-sm">
                <i class="<?= htmlspecialchars($poin['icon']) ?>"></i>
              </div>
              <div>
                <h4 class="text-sm font-bold text-slate-800 mb-1"><?= htmlspecialchars($poin['judul']) ?></h4>
                <p class="text-xs text-slate-500 leading-relaxed"><?= htmlspecialchars($poin['deskripsi']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Visi & Misi Section (Unified) -->
<section id="visi-misi" class="py-20 sm:py-28 bg-slate-50/60 border-y border-slate-100/85 relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
      <!-- Visi Block -->
      <div class="lg:col-span-5 flex flex-col justify-center">
        <div class="card-gov !p-8 sm:!p-10 relative overflow-hidden bg-white shadow-soft-raised-lg border border-slate-100/50 hover:shadow-soft-raised-lg transition-all duration-300">
          <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-gov-blue-100/50 rounded-full blur-2xl pointer-events-none"></div>
          <div class="flex h-14 w-14 items-center justify-center rounded-gov bg-gradient-to-br from-gov-blue-800 to-gov-blue-700 text-white text-xl shadow-lg shadow-blue-500/10 mb-6">
            <i class="fas fa-bullseye"></i>
          </div>
          <h3 class="font-sans text-xl font-bold text-slate-900 mb-4 tracking-tight">Visi DISDUKCAPIL</h3>
          <p class="text-lg text-slate-700 leading-relaxed font-semibold">
            "<?= htmlspecialchars($data['visi']) ?>"
          </p>
        </div>
      </div>
      
      <!-- Misi Block -->
      <div class="lg:col-span-7 space-y-6">
        <div class="text-left mb-6">
          <h3 class="font-sans text-2xl font-extrabold text-slate-900 tracking-tight">Misi Strategis Kami</h3>
          <p class="text-sm text-slate-500 mt-1 font-medium">Langkah konkrit dalam menyelenggarakan pelayanan kependudukan terbaik</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <?php foreach ($data['misi'] as $index => $misi): ?>
            <div class="card-gov !p-5 flex items-start gap-4 hover:-translate-y-1 hover:shadow-soft-raised-lg transition-all duration-300">
              <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-gov bg-gov-blue-100 text-gov-blue-800 text-xs font-extrabold shadow-soft-raised-sm">
                <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
              </div>
              <p class="text-xs text-slate-650 leading-relaxed font-medium"><?= htmlspecialchars($misi) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section (Accordions) -->
<section id="faq" class="py-20 sm:py-28 relative">
  <div class="max-w-4xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-16">
      <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-gov-blue-800 bg-gov-blue-100 border border-gov-blue-200/30">
        Pusat Bantuan
      </span>
      <h2 class="font-sans text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
      <p class="text-slate-500 mt-2 font-medium">Informasi penting seputar proses pengisian kuesioner dan performa indeks layanan</p>
    </div>
    
    <div class="space-y-4">
      <!-- FAQ Item 1 -->
      <details class="faq-details">
        <summary class="faq-summary">
          <span>Bagaimana cara memberikan penilaian kepuasan layanan?</span>
          <span class="faq-icon"><i class="fas fa-chevron-down text-xs"></i></span>
        </summary>
        <div class="faq-content">
          <p>Anda dapat mengklik tombol <strong>"Isi Kuesioner"</strong> pada navigasi atas atau menu Hero. Masukkan identitas singkat Anda (nama, usia, pekerjaan), lalu berikan penilaian kualitatif untuk setiap atribut kriteria kependudukan yang Anda rasakan.</p>
        </div>
      </details>

      <!-- FAQ Item 2 -->
      <details class="faq-details">
        <summary class="faq-summary">
          <span>Metode apa yang digunakan untuk menghitung kepuasan layanan?</span>
          <span class="faq-icon"><i class="fas fa-chevron-down text-xs"></i></span>
        </summary>
        <div class="faq-content">
          <p>Sistem ini menggunakan metode <strong>SMART (Simple Multi-Attribute Rating Technique)</strong>. Setiap jawaban kuesioner responden dikonversi menjadi nilai bobot ternormalisasi secara matematis untuk memberikan perangkingan objektif terhadap performa jenis layanan DISDUKCAPIL.</p>
        </div>
      </details>

      <!-- FAQ Item 3 -->
      <details class="faq-details">
        <summary class="faq-summary">
          <span>Apakah hasil penilaian ini langsung ter-update di dashboard?</span>
          <span class="faq-icon"><i class="fas fa-chevron-down text-xs"></i></span>
        </summary>
        <div class="faq-content">
          <p>Ya. Sistem kami memproses data secara real-time. Begitu responden menekan tombol submit pada formulir kuesioner, nilai SMART layanan akan otomatis dihitung ulang dan langsung memperbarui grafik IKM di portal administrator.</p>
        </div>
      </details>

      <!-- FAQ Item 4 -->
      <details class="faq-details">
        <summary class="faq-summary">
          <span>Bagaimana cara menghubungi dinas jika memiliki kendala kependudukan?</span>
          <span class="faq-icon"><i class="fas fa-chevron-down text-xs"></i></span>
        </summary>
        <div class="faq-content">
          <p>Anda dapat melihat kontak resmi, email, atau alamat kantor kami langsung pada bagian footer di bawah. Selain itu, Anda juga dapat mengunjungi kantor dinas pada jam pelayanan operasional yang tertera.</p>
        </div>
      </details>
    </div>
  </div>
</section>

<?php include('template/layout_public_foot.php'); ?>
