<?php $page_title = 'Detail Hasil Perhitungan - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-user"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Detail Hasil Perhitungan</h1>
      <p class="text-slate-500 text-sm">Hasil SMART untuk Responden</p>
    </div>
  </div>
  <a href="index.php?controller=hasil&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card-gov !bg-gradient-to-br !from-gov-blue-800 !to-gov-blue-950 !text-white mb-6">
  <div class="flex items-center justify-between flex-wrap gap-6">
    <div>
      <h2 class="font-sans text-xl font-bold mb-3"><i class="fas fa-user-circle mr-2"></i><?= htmlspecialchars($data['responden']['nama_lengkap']) ?></h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 text-sm text-white/85">
        <p><i class="fas fa-birthday-cake mr-2"></i><strong>Usia:</strong> <?= $data['responden']['usia'] ?> tahun</p>
        <p><i class="fas fa-calendar mr-2"></i><strong>Terdaftar:</strong> <?= date('d M Y', strtotime($data['responden']['created_at'])) ?></p>
        <p><i class="fas fa-briefcase mr-2"></i><strong>Pekerjaan:</strong> <?= htmlspecialchars($data['responden']['pekerjaan']) ?></p>
        <p><i class="fas fa-list-ol mr-2"></i><strong>Total Layanan Dinilai:</strong> <?= count($data['all_hasil']) ?></p>
      </div>
    </div>
    <div class="flex h-28 w-28 flex-shrink-0 flex-col items-center justify-center rounded-full bg-white/15 border-4 border-white/25">
      <span class="text-3xl font-bold"><?= count($data['all_hasil']) ?></span>
      <span class="text-xs text-white/70">Layanan</span>
    </div>
  </div>
</div>

<?php if (!empty($data['hasil'])): $best_service = $data['hasil']; ?>
  <div class="card-gov !bg-gradient-to-br !from-gov-gold-400 !to-gov-gold-600 !text-gov-blue-950 mb-6">
    <div class="flex items-center gap-5 flex-wrap">
      <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/25 text-3xl flex-shrink-0"><i class="fas fa-trophy"></i></div>
      <div class="flex-1">
        <p class="font-bold text-sm uppercase tracking-wide mb-1"><i class="fas fa-star"></i> Layanan Terbaik</p>
        <h4 class="font-sans text-xl font-bold"><?= htmlspecialchars($best_service['nama_layanan']) ?></h4>
        <p class="text-sm opacity-80">Nilai SMART: <strong><?= number_format($best_service['nilai_smart'], 2) ?></strong></p>
        <p class="text-xs opacity-70">Tanggal: <?= date('d/m/Y H:i', strtotime($best_service['tanggal_perhitungan'])) ?></p>
      </div>
      <div class="text-center">
        <p class="text-3xl font-bold"><?= number_format($best_service['nilai_smart'], 1) ?></p>
        <p class="text-xs opacity-80">Points</p>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="card-gov">
  <h3 class="font-bold text-slate-800 mb-2"><i class="fas fa-list text-gov-blue-700 mr-1"></i> Semua Layanan yang Dinilai</h3>
  <div class="alert-gov-info !mb-4"><i class="fas fa-info-circle"></i><p class="text-sm">Menampilkan detail perhitungan SMART untuk semua layanan</p></div>

  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Layanan</th><th>Nilai SMART</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($data['all_hasil'])): ?>
          <?php $no = 1; foreach ($data['all_hasil'] as $layanan): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td>
                <strong class="text-slate-800"><?= htmlspecialchars($layanan['nama_layanan']) ?></strong>
                <?php if (!empty($layanan['is_terbaik'])): ?>
                  <p class="text-xs text-gov-gold-600 mt-0.5"><i class="fas fa-star mr-1"></i>Layanan favorit</p>
                <?php endif; ?>
              </td>
              <td>
                <span class="text-xl font-bold <?= $layanan['nilai_smart'] >= 80 ? 'text-gov-green-700' : ($layanan['nilai_smart'] >= 60 ? 'text-gov-blue-700' : ($layanan['nilai_smart'] >= 40 ? 'text-amber-600' : 'text-gov-maroon-700')) ?>"><?= number_format($layanan['nilai_smart'], 2) ?></span>
                <div class="bar-gov-track w-32 mt-1"><div class="bar-gov-fill" style="width: <?= min($layanan['nilai_smart'], 100) ?>%"></div></div>
              </td>
              <td><a href="index.php?controller=penilaian&action=detailSmart&id_responden=<?= $data['responden']['id_responden'] ?>" class="btn-gov-icon-view" title="Lihat Detail Perhitungan Lengkap"><i class="fas fa-chart-line"></i></a></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center text-slate-400 py-6">Tidak ada data penilaian</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
