<?php $page_title = 'Hasil Perhitungan SMART - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-chart-bar"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Hasil Perhitungan SMART</h1>
      <p class="text-slate-500 text-sm">Analisis Kepuasan Layanan DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <button onclick="confirmDeleteAll()" class="btn-gov-danger"><i class="fas fa-trash"></i> Hapus Semua</button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Responden</p>
    <p class="card-gov-stat-value"><?= $data['statistics']['total_responden'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Dengan hasil perhitungan</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-star"></i></div>
    <p class="card-gov-stat-label">Layanan Terbaik</p>
    <p class="card-gov-stat-value !text-lg leading-tight"><?= htmlspecialchars($data['top_alternatif']['nama_layanan'] ?? '-') ?></p>
    <p class="card-gov-stat-sub">Skor: <?= number_format($data['top_alternatif']['rerata_smart'] ?? 0, 2) ?></p>
  </div>
  <div class="card-gov-stat" style="--stat-c1:#475569; --stat-c2:#1e293b;">
    <div class="card-gov-stat-icon"><i class="fas fa-chart-line"></i></div>
    <p class="card-gov-stat-label">Rata-rata SMART</p>
    <p class="card-gov-stat-value"><?= number_format($data['statistics']['rerata_keseluruhan'] ?? 0, 1) ?></p>
    <p class="card-gov-stat-sub">Skor keseluruhan</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-trophy"></i></div>
    <p class="card-gov-stat-label">Total Hasil</p>
    <p class="card-gov-stat-value"><?= $data['statistics']['total_hasil'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Data perhitungan</p>
  </div>
</div>

<div class="card-gov mb-6">
  <div class="flex items-center flex-wrap gap-3">
    <button class="btn-gov <?= $data['view_mode'] === 'responden' ? 'btn-gov-primary' : 'btn-gov-secondary' ?>" onclick="switchView('responden')">
      <i class="fas fa-users"></i> Per Responden
    </button>
    <button class="btn-gov <?= $data['view_mode'] === 'alternatif' ? 'btn-gov-primary' : 'btn-gov-secondary' ?>" onclick="switchView('alternatif')">
      <i class="fas fa-concierge-bell"></i> Per Layanan
    </button>
    <a href="index.php?controller=hasil&action=exportCSV&view=<?= $data['view_mode'] ?>" class="btn-gov-success ml-auto">
      <i class="fas fa-file-csv"></i> Export CSV
    </a>
  </div>
</div>

<div class="table-gov-wrap">
  <?php if ($data['view_mode'] === 'alternatif'): ?>
    <?php if (!empty($data['hasil_data'])): ?>
      <div class="table-gov-scroll">
        <table class="table-gov">
          <thead><tr><th>No</th><th>Layanan</th><th>Total Memilih</th><th>Rata-rata SMART</th><th>Aksi</th></tr></thead>
          <tbody>
            <?php $no = 1; foreach ($data['hasil_data'] as $alternatif): ?>
              <tr>
                <td><span class="row-number-gov"><?= $no++ ?></span></td>
                <td class="font-semibold text-slate-800"><?= htmlspecialchars($alternatif['nama_layanan']) ?></td>
                <td><i class="fas fa-users text-gov-blue-700 mr-1"></i><strong><?= $alternatif['total_memilih'] ?></strong> <span class="text-xs text-slate-500">responden</span></td>
                <td>
                  <span class="text-xl font-bold <?= $alternatif['rerata_smart'] >= 80 ? 'text-gov-green-700' : ($alternatif['rerata_smart'] >= 60 ? 'text-gov-blue-700' : ($alternatif['rerata_smart'] >= 40 ? 'text-amber-600' : 'text-gov-maroon-700')) ?>">
                    <?= number_format($alternatif['rerata_smart'], 2) ?>
                  </span>
                </td>
                <td><a href="index.php?controller=hasil&action=detailAlternatif&id_alternatif=<?= $alternatif['id_alternatif'] ?>" class="btn-gov-icon-view" title="Lihat Detail Responden"><i class="fas fa-eye"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="empty-gov">
        <i class="fas fa-chart-bar text-4xl text-slate-300 mb-4"></i>
        <h4 class="font-bold text-slate-700 mb-1">Belum ada hasil perhitungan</h4>
        <p class="text-slate-500 text-sm mb-4">Silakan hitung SMART terlebih dahulu</p>
        <a href="index.php?controller=penilaian&action=index" class="btn-gov-success"><i class="fas fa-calculator"></i> Hitung SMART</a>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <?php if (!empty($data['hasil_data'])): ?>
      <div class="table-gov-scroll">
        <table class="table-gov">
          <thead><tr><th>No</th><th>Responden</th><th>Layanan Terbaik</th><th>Nilai SMART</th><th>Aksi</th></tr></thead>
          <tbody>
            <?php $no = 1; foreach ($data['hasil_data'] as $hasil): ?>
              <tr>
                <td><span class="row-number-gov"><?= $no++ ?></span></td>
                <td>
                  <strong class="text-slate-800"><?= htmlspecialchars($hasil['nama_lengkap']) ?></strong>
                  <p class="text-xs text-slate-500 mt-0.5"><i class="fas fa-birthday-cake mr-1"></i><?= $hasil['usia'] ?> tahun <span class="mx-1">|</span><i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($hasil['pekerjaan']) ?></p>
                </td>
                <td>
                  <span class="badge-gov-primary !text-[10px] mr-2"><i class="fas fa-star"></i> Terbaik</span>
                  <strong class="text-slate-800"><?= htmlspecialchars($hasil['nama_layanan']) ?></strong>
                </td>
                <td>
                  <span class="text-xl font-bold <?= $hasil['nilai_smart'] >= 80 ? 'text-gov-green-700' : ($hasil['nilai_smart'] >= 60 ? 'text-gov-blue-700' : ($hasil['nilai_smart'] >= 40 ? 'text-amber-600' : 'text-gov-maroon-700')) ?>">
                    <?= number_format($hasil['nilai_smart'], 2) ?>
                  </span>
                  <div class="bar-gov-track w-24 mt-1"><div class="bar-gov-fill" style="width: <?= $hasil['nilai_smart'] ?>%"></div></div>
                </td>
                <td>
                  <div class="flex gap-2">
                    <a href="index.php?controller=hasil&action=detailResponden&id_responden=<?= $hasil['id_responden'] ?>" class="btn-gov-icon-view" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                    <button onclick="confirmDeleteResponden(<?= $hasil['id_responden'] ?>)" class="btn-gov-icon-delete" title="Hapus Hasil"><i class="fas fa-trash"></i></button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="empty-gov">
        <i class="fas fa-chart-bar text-4xl text-slate-300 mb-4"></i>
        <h4 class="font-bold text-slate-700 mb-1">Belum ada hasil perhitungan</h4>
        <p class="text-slate-500 text-sm mb-4">Silakan hitung SMART terlebih dahulu</p>
        <a href="index.php?controller=penilaian&action=index" class="btn-gov-success"><i class="fas fa-calculator"></i> Hitung SMART</a>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  function switchView(view) {
    window.location.href = 'index.php?controller=hasil&action=index&view=' + view;
  }

  function confirmDeleteAll() {
    govConfirmDelete('index.php?controller=hasil&action=deleteAll', {
      title: 'Hapus Semua Hasil?',
      text: 'Semua data hasil perhitungan SMART akan dihapus dan tidak dapat dikembalikan!'
    });
  }

  function confirmDeleteResponden(id_responden) {
    govConfirmDelete('index.php?controller=hasil&action=deleteResponden&id_responden=' + id_responden, {
      title: 'Hapus Hasil Responden?',
      text: 'Hasil perhitungan untuk responden ini akan dihapus!'
    });
  }
</script>
