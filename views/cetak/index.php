<?php $page_title = 'Cetak Laporan - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center gap-3 mb-6">
  <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
    <i class="fas fa-print"></i>
  </div>
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Cetak Laporan</h1>
    <p class="text-slate-500 text-sm">Pusat unduh PDF & CSV untuk semua laporan kepuasan masyarakat</p>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Total Responden</p>
    <p class="card-gov-stat-value"><?= $data['statistics']['total_responden'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Sudah dihitung SMART</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-star"></i></div>
    <p class="card-gov-stat-label">Rata-rata SMART</p>
    <p class="card-gov-stat-value"><?= number_format($data['statistics']['rerata_smart'] ?? 0, 2) ?></p>
    <p class="card-gov-stat-sub">Skor kepuasan keseluruhan</p>
  </div>
</div>

<!-- Filter Periode -->
<div class="card-gov mb-6">
  <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fas fa-filter text-gov-blue-700"></i> Filter Periode Laporan</h3>
  <form method="GET" action="index.php" class="flex flex-col md:flex-row md:items-end gap-4">
    <input type="hidden" name="controller" value="cetak">
    <input type="hidden" name="action" value="index">

    <div class="w-full md:w-64">
      <label class="label-gov">Mode Filter</label>
      <div class="relative">
        <select name="mode" id="filterMode" class="input-gov pr-10 appearance-none bg-white" onchange="toggleFilterMode()">
          <option value="" <?= $data['filter_mode'] === '' ? 'selected' : '' ?>>Semua Data</option>
          <option value="harian" <?= $data['filter_mode'] === 'harian' ? 'selected' : '' ?>>Harian</option>
          <option value="bulanan" <?= $data['filter_mode'] === 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
          <option value="tahunan" <?= $data['filter_mode'] === 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
          <i class="fas fa-chevron-down text-xs"></i>
        </div>
      </div>
    </div>

    <div id="filterHarian" class="w-full md:w-60 <?= $data['filter_mode'] === 'harian' ? '' : 'hidden' ?>">
      <label class="label-gov">Tanggal</label>
      <input type="date" name="tanggal" class="input-gov bg-white" value="<?= htmlspecialchars($data['filter_tanggal']) ?>">
    </div>

    <div id="filterBulanan" class="w-full md:w-60 <?= $data['filter_mode'] === 'bulanan' ? '' : 'hidden' ?>">
      <label class="label-gov">Bulan</label>
      <input type="month" name="bulan" class="input-gov bg-white" value="<?= htmlspecialchars($data['filter_bulan']) ?>">
    </div>

    <div id="filterTahunan" class="w-full md:w-44 <?= $data['filter_mode'] === 'tahunan' ? '' : 'hidden' ?>">
      <label class="label-gov">Tahun</label>
      <input type="number" name="tahun" min="2000" max="2100" class="input-gov bg-white" value="<?= htmlspecialchars($data['filter_tahun']) ?>">
    </div>

    <div class="flex items-center gap-2">
      <button type="submit" class="btn-gov-primary whitespace-nowrap min-h-[44px]"><i class="fas fa-filter"></i> Terapkan</button>
      <?php if ($data['filter_mode'] !== ''): ?>
        <a href="index.php?controller=cetak&action=index" class="btn-gov-secondary whitespace-nowrap min-h-[44px]"><i class="fas fa-times"></i> Reset</a>
      <?php endif; ?>
    </div>
  </form>

  <?php if (!empty($data['period_label'])): ?>
    <div class="alert-gov-info !mt-4"><i class="fas fa-calendar-check"></i> Menampilkan data periode: <strong><?= htmlspecialchars($data['period_label']) ?></strong></div>
  <?php elseif ($data['filter_mode'] !== ''): ?>
    <div class="alert-gov-warning !mt-4"><i class="fas fa-triangle-exclamation"></i> Filter tidak valid, menampilkan semua data.</div>
  <?php endif; ?>
</div>

<!-- 1. Laporan Resmi -->
<div class="card-gov mb-6">
  <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
    <div>
      <h3 class="font-bold text-slate-800"><i class="fas fa-file-contract text-gov-blue-700 mr-1"></i> Laporan Resmi Kepuasan Masyarakat</h3>
      <p class="text-sm text-slate-500">Laporan formal dengan kop surat & tanda tangan Kepala Dinas, memuat matriks nilai tiap responden per layanan</p>
    </div>
    <a href="index.php?controller=cetak&action=pdfLaporanResmi<?= $data['filter_qs'] ?>" target="_blank" class="btn-gov-primary"><i class="fas fa-file-pdf"></i> Unduh PDF</a>
  </div>

  <?php $responden_data = $data['laporan_data']['responden_data'] ?? []; ?>
  <?php if (!empty($responden_data)): ?>
    <button type="button" onclick="document.getElementById('previewLaporan').classList.toggle('hidden')" class="btn-gov-ghost !py-2 !text-xs">
      <i class="fas fa-table"></i> Lihat/Sembunyikan Detail Data
    </button>
    <div id="previewLaporan" class="hidden mt-4">
      <div class="table-gov-scroll" style="max-height: 400px;">
        <table class="table-gov">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Responden</th>
              <?php foreach ($data['laporan_data']['alternatifs'] as $alt): ?>
                <th><?= htmlspecialchars($alt['kode_alternatif']) ?></th>
              <?php endforeach; ?>
              <th>Hasil SMART</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($responden_data as $r): $id_r = $r['id_responden']; ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= htmlspecialchars($r['nama_lengkap']) ?></td>
                <?php foreach ($data['laporan_data']['alternatifs'] as $alt):
                  $kode_alt = $alt['kode_alternatif'];
                  $nilai = $data['laporan_data']['nilai_per_responden_alternatif'][$id_r][$kode_alt] ?? 0;
                ?>
                  <td class="text-center"><?= number_format($nilai, 2, ',', '.') ?></td>
                <?php endforeach; ?>
                <td class="text-center font-bold text-gov-blue-700"><?= number_format($r['nilai_smart_terbaik'], 2, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php else: ?>
    <div class="alert-gov-info !mt-2"><i class="fas fa-info-circle"></i><p class="text-sm">Belum ada data hasil SMART untuk dilaporkan. Hitung SMART dulu di menu Penilaian.</p></div>
  <?php endif; ?>
</div>

<!-- 2. Ringkasan per Layanan -->
<div class="card-gov mb-6">
  <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
    <div>
      <h3 class="font-bold text-slate-800"><i class="fas fa-chart-pie text-gov-blue-700 mr-1"></i> Ringkasan Kepuasan per Layanan</h3>
      <p class="text-sm text-slate-500">Rata-rata nilai SMART per layanan dari seluruh responden yang menilai</p>
    </div>
    <div class="flex gap-2">
      <a href="index.php?controller=cetak&action=pdfRingkasanLayanan<?= $data['filter_qs'] ?>" target="_blank" class="btn-gov-primary"><i class="fas fa-file-pdf"></i> PDF</a>
      <a href="index.php?controller=cetak&action=csvRingkasanLayanan<?= $data['filter_qs'] ?>" class="btn-gov-success"><i class="fas fa-file-csv"></i> CSV</a>
    </div>
  </div>

  <?php if (!empty($data['ringkasan_layanan'])): ?>
    <div class="table-gov-scroll">
      <table class="table-gov">
        <thead><tr><th>No</th><th>Layanan</th><th>Jumlah Penilai</th><th>Rata-rata SMART</th><th>Min</th><th>Max</th></tr></thead>
        <tbody>
          <?php $no = 1; foreach ($data['ringkasan_layanan'] as $r): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td class="font-semibold text-slate-800"><?= htmlspecialchars($r['nama_layanan']) ?></td>
              <td class="text-center"><?= (int) $r['total_penilai'] ?></td>
              <td class="text-center font-bold text-gov-blue-700"><?= number_format($r['rerata_smart'] ?? 0, 2, ',', '.') ?></td>
              <td class="text-center"><?= number_format($r['nilai_min'] ?? 0, 2, ',', '.') ?></td>
              <td class="text-center"><?= number_format($r['nilai_max'] ?? 0, 2, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert-gov-info"><i class="fas fa-info-circle"></i><p class="text-sm">Belum ada data ringkasan layanan.</p></div>
  <?php endif; ?>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  function toggleFilterMode() {
    const mode = document.getElementById('filterMode').value;
    document.getElementById('filterHarian').classList.toggle('hidden', mode !== 'harian');
    document.getElementById('filterBulanan').classList.toggle('hidden', mode !== 'bulanan');
    document.getElementById('filterTahunan').classList.toggle('hidden', mode !== 'tahunan');
  }
</script>
