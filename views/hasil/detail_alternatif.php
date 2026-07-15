<?php $page_title = 'Detail Hasil Layanan - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-concierge-bell"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Detail Hasil Layanan</h1>
      <p class="text-slate-500 text-sm">Hasil Perhitungan SMART per Layanan</p>
    </div>
  </div>
  <a href="index.php?controller=hasil&action=index&view=alternatif" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card-gov !bg-gradient-to-br !from-gov-blue-800 !to-gov-blue-950 !text-white mb-6">
  <div class="flex items-center justify-between flex-wrap gap-6">
    <div>
      <h2 class="font-sans text-xl font-bold mb-3"><i class="fas fa-concierge-bell mr-2"></i><?= htmlspecialchars($data['alternatif']['nama_layanan']) ?></h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 text-sm text-white/85">
        <p><i class="fas fa-users mr-2"></i><strong>Total Penilai:</strong> <?= $data['statistics']['total_penilai'] ?></p>
        <p><i class="fas fa-arrow-up mr-2"></i><strong>Tertinggi:</strong> <?= number_format($data['statistics']['tertinggi'], 2) ?></p>
        <p><i class="fas fa-chart-line mr-2"></i><strong>Rata-rata:</strong> <?= number_format($data['statistics']['rerata'], 2) ?></p>
        <p><i class="fas fa-arrow-down mr-2"></i><strong>Terendah:</strong> <?= number_format($data['statistics']['terendah'], 2) ?></p>
      </div>
    </div>
    <div class="flex h-28 w-28 flex-shrink-0 flex-col items-center justify-center rounded-full bg-white/15 border-4 border-white/25">
      <span class="text-3xl font-bold"><?= number_format($data['statistics']['rerata'], 1) ?></span>
      <span class="text-xs text-white/70">Rata-rata</span>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
  <div class="card-gov !border-l-4 !border-l-gov-green-700">
    <div class="flex items-center gap-3"><div class="flex h-11 w-11 items-center justify-center rounded-gov bg-gradient-to-b from-gov-green-700 to-emerald-900 text-white"><i class="fas fa-chart-line"></i></div>
    <div><p class="text-xs text-slate-500">Rata-rata</p><p class="text-xl font-bold text-slate-800"><?= number_format($data['statistics']['rerata'], 2) ?></p></div></div>
  </div>
  <div class="card-gov !border-l-4 !border-l-gov-blue-700">
    <div class="flex items-center gap-3"><div class="flex h-11 w-11 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white"><i class="fas fa-arrow-up"></i></div>
    <div><p class="text-xs text-slate-500">Tertinggi</p><p class="text-xl font-bold text-slate-800"><?= number_format($data['statistics']['tertinggi'], 2) ?></p></div></div>
  </div>
  <div class="card-gov !border-l-4 !border-l-gov-gold-600">
    <div class="flex items-center gap-3"><div class="flex h-11 w-11 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950"><i class="fas fa-arrow-down"></i></div>
    <div><p class="text-xs text-slate-500">Terendah</p><p class="text-xl font-bold text-slate-800"><?= number_format($data['statistics']['terendah'], 2) ?></p></div></div>
  </div>
  <div class="card-gov !border-l-4 !border-l-slate-500">
    <div class="flex items-center gap-3"><div class="flex h-11 w-11 items-center justify-center rounded-gov bg-gradient-to-b from-slate-500 to-slate-700 text-white"><i class="fas fa-users"></i></div>
    <div><p class="text-xs text-slate-500">Penilai</p><p class="text-xl font-bold text-slate-800"><?= $data['statistics']['total_penilai'] ?></p></div></div>
  </div>
</div>

<div class="card-gov">
  <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-list text-gov-blue-700 mr-1"></i> Daftar Responden yang Menilai</h3>
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Responden</th><th>Nilai SMART</th><th>Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $no = 1; foreach ($data['hasil_list'] as $hasil): ?>
          <tr>
            <td><span class="row-number-gov"><?= $no++ ?></span></td>
            <td>
              <strong class="text-slate-800"><?= htmlspecialchars($hasil['nama_lengkap']) ?></strong>
              <p class="text-xs text-slate-500 mt-0.5"><i class="fas fa-birthday-cake mr-1"></i><?= $hasil['usia'] ?> tahun <span class="mx-1">|</span><i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($hasil['pekerjaan']) ?></p>
            </td>
            <td>
              <span class="text-xl font-bold <?= $hasil['nilai_smart'] >= 80 ? 'text-gov-green-700' : ($hasil['nilai_smart'] >= 60 ? 'text-gov-blue-700' : ($hasil['nilai_smart'] >= 40 ? 'text-amber-600' : 'text-gov-maroon-700')) ?>"><?= number_format($hasil['nilai_smart'], 2) ?></span>
              <div class="bar-gov-track w-32 mt-1"><div class="bar-gov-fill" style="width: <?= $hasil['nilai_smart'] ?>%"></div></div>
            </td>
            <td>
              <?php if ($hasil['nilai_smart'] >= 80): ?><span class="badge-gov-success">Sangat Baik</span>
              <?php elseif ($hasil['nilai_smart'] >= 60): ?><span class="badge-gov-info">Baik</span>
              <?php elseif ($hasil['nilai_smart'] >= 40): ?><span class="badge-gov-warning">Cukup</span>
              <?php elseif ($hasil['nilai_smart'] >= 20): ?><span class="badge-gov-danger">Kurang</span>
              <?php else: ?><span class="badge-gov" style="background:#334155;color:#fff;">Sangat Kurang</span>
              <?php endif; ?>
            </td>
            <td><a href="index.php?controller=hasil&action=detailResponden&id_responden=<?= $hasil['id_responden'] ?>" class="btn-gov-icon-view" title="Lihat Detail Responden"><i class="fas fa-eye"></i></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
