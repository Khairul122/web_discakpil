<?php $page_title = 'Detail Responden - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-user"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Detail Responden</h1>
      <p class="text-slate-500 text-sm">Informasi lengkap data responden</p>
    </div>
  </div>
  <a href="index.php?controller=responden&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card-gov !bg-gradient-to-br !from-gov-blue-800 !to-gov-blue-950 !text-white mb-6">
  <div class="flex items-center gap-5">
    <div class="flex h-20 w-20 items-center justify-center rounded-gov bg-white/15 text-4xl flex-shrink-0"><i class="fas fa-user"></i></div>
    <div>
      <h2 class="font-serif text-2xl font-bold"><?= htmlspecialchars($data['responden']['nama_lengkap']) ?></h2>
      <p class="text-white/70">Responden DISDUKCAPIL</p>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-200"><i class="fas fa-user-circle text-gov-blue-700 mr-1"></i> Informasi Pribadi</h3>
    <div class="space-y-4">
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1"><i class="fas fa-user"></i> Nama Lengkap</p>
        <p class="font-semibold text-slate-800 mt-1"><?= htmlspecialchars($data['responden']['nama_lengkap']) ?></p>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1"><i class="fas fa-birthday-cake"></i> Usia</p>
        <p class="font-semibold text-slate-800 mt-1"><?= $data['responden']['usia'] ?> Tahun</p>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1"><i class="fas fa-briefcase"></i> Pekerjaan</p>
        <span class="badge-gov-primary mt-1"><?= htmlspecialchars($data['responden']['pekerjaan']) ?></span>
      </div>
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1"><i class="fas fa-calendar-alt"></i> Tanggal Isi</p>
        <p class="font-semibold text-slate-800 mt-1"><?= date('d/m/Y H:i', strtotime($data['responden']['tanggal_isi'])) ?></p>
      </div>
    </div>
  </div>

  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-200"><i class="fas fa-chart-bar text-gov-blue-700 mr-1"></i> Statistik Penilaian</h3>
    <div class="grid grid-cols-2 gap-3 mb-5">
      <div class="rounded-gov border border-slate-200 p-4 text-center">
        <i class="fas fa-star text-gov-blue-700 text-xl mb-2"></i>
        <p class="text-2xl font-bold text-slate-800"><?= $data['total_penilaian'] ?? 0 ?></p>
        <p class="text-xs text-slate-500">Layanan dinilai</p>
      </div>
      <div class="rounded-gov border border-slate-200 p-4 text-center">
        <i class="fas fa-thumbs-up text-gov-green-700 text-xl mb-2"></i>
        <p class="text-2xl font-bold text-slate-800"><?= $data['avg_nilai'] ?? 0 ?></p>
        <p class="text-xs text-slate-500">Rata-rata utility</p>
      </div>
    </div>

    <?php if (!empty($data['penilaians'])): ?>
      <p class="text-sm font-semibold text-slate-700 mb-2">Riwayat Penilaian</p>
      <div class="space-y-2 max-h-96 overflow-y-auto pr-1">
        <?php foreach ($data['penilaians'] as $penilaian): ?>
          <div class="rounded-gov border border-slate-200 p-3">
            <span class="badge-gov-info mb-2"><i class="fas fa-concierge-bell"></i> <?= htmlspecialchars($penilaian['nama_layanan']) ?></span>
            <div class="flex items-center justify-between text-sm mt-1">
              <span class="text-slate-500">Kriteria: <span class="font-semibold text-slate-700"><?= htmlspecialchars($penilaian['nama_kriteria']) ?></span></span>
            </div>
            <div class="flex items-center justify-between text-sm mt-1">
              <span class="text-slate-500">Penilaian: <span class="font-semibold text-slate-700"><?= htmlspecialchars($penilaian['nama_pilihan']) ?></span></span>
              <span class="badge-gov-primary !text-xs"><?= number_format($penilaian['nilai_utility'], 1) ?>%</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-8 text-slate-300">
        <i class="fas fa-inbox text-3xl mb-3"></i>
        <p class="text-slate-500 text-sm">Belum ada penilaian</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
