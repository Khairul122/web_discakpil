<?php $page_title = $data['title'] ?? 'DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_public_head.php'); ?>

<!-- Hero -->
<section id="beranda" class="bg-gradient-to-b from-gov-blue-900 to-gov-blue-950 text-white py-20 sm:py-28">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
    <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-full bg-white/10 border-2 border-gov-gold-400/50">
      <i class="fas fa-building-columns text-3xl text-gov-gold-400"></i>
    </div>
    <h1 class="font-serif text-4xl sm:text-6xl font-bold mb-6 leading-tight reveal-on-scroll is-visible">
      <?= htmlspecialchars($data['page_title'] ?? $page_title) ?>
    </h1>
    <p class="text-lg sm:text-xl text-white/80 max-w-2xl mx-auto mb-10 leading-relaxed reveal-on-scroll is-visible">
      Mewujudkan pelayanan administrasi kependudukan yang prima, modern, dan terpercaya
      untuk seluruh masyarakat Kota Padang melalui inovasi digital dan teknologi terkini.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal-on-scroll is-visible">
      <a href="#tentang" class="btn-gov-gold !min-h-[48px] px-8">
        <i class="fas fa-compass"></i> Jelajahi Layanan
      </a>
      <a href="index.php?controller=penilaianKuesioner&action=index" class="btn-gov !min-h-[48px] px-8 text-white bg-white/10 border border-white/20 hover:bg-white/20 shadow-none">
        <i class="fas fa-clipboard-list"></i> Isi Kuesioner
      </a>
    </div>
  </div>
</section>

<!-- Tentang -->
<section id="tentang" class="py-20 sm:py-28">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14 reveal-on-scroll">
      <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gov-blue-900 mb-4"><?= htmlspecialchars($data['tentang']['judul']) ?></h2>
      <p class="text-slate-500 max-w-2xl mx-auto"><?= htmlspecialchars($data['tentang']['deskripsi']) ?></p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($data['tentang']['poin'] as $index => $poin): ?>
        <div class="card-gov reveal-on-scroll" style="transition-delay: <?= $index * 80 ?>ms">
          <div class="flex h-14 w-14 items-center justify-center rounded-gov bg-gov-blue-100 text-gov-blue-700 text-2xl mb-4">
            <i class="<?= htmlspecialchars($poin['icon']) ?>"></i>
          </div>
          <h3 class="text-lg font-bold text-slate-800 mb-2"><?= htmlspecialchars($poin['judul']) ?></h3>
          <p class="text-sm text-slate-500 leading-relaxed"><?= htmlspecialchars($poin['deskripsi']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Visi -->
<section id="visi" class="py-20 sm:py-28 bg-gov-blue-100/40">
  <div class="max-w-4xl mx-auto px-4 sm:px-6">
    <div class="card-gov !p-10 sm:!p-16 text-center reveal-on-scroll">
      <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-2xl">
        <i class="fas fa-bullseye"></i>
      </div>
      <h3 class="font-serif text-2xl font-bold text-gov-blue-900 mb-4">Visi Kami</h3>
      <p class="text-xl sm:text-2xl text-slate-700 leading-relaxed"><?= htmlspecialchars($data['visi']) ?></p>
    </div>
  </div>
</section>

<!-- Misi -->
<section id="misi" class="py-20 sm:py-28">
  <div class="max-w-4xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14 reveal-on-scroll">
      <h2 class="font-serif text-3xl sm:text-4xl font-bold text-gov-blue-900 mb-3">Misi Kami</h2>
      <p class="text-slate-500">Langkah strategis dalam mewujudkan visi bersama</p>
    </div>
    <div class="space-y-4">
      <?php foreach ($data['misi'] as $index => $misi): ?>
        <div class="card-gov flex items-start gap-4 reveal-on-scroll" style="transition-delay: <?= $index * 60 ?>ms">
          <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950 font-bold">
            <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
          </div>
          <p class="text-slate-700 leading-relaxed pt-1.5"><?= htmlspecialchars($misi) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include('template/layout_public_foot.php'); ?>
