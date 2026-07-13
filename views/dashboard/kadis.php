<?php $page_title = 'Dashboard Kepala Dinas - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, <?= htmlspecialchars($data['user']['nama_lengkap']) ?>!</h1>
    <p class="text-slate-500">Dashboard Kepala Dinas - Sistem DISDUKCAPIL Kota Padang</p>
  </div>
  <span class="badge-gov-info"><i class="fas fa-user-tie"></i> <?= ucfirst($data['user']['role']) ?></span>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-clipboard-list"></i></div>
    <p class="card-gov-stat-label">Layanan</p>
    <p class="card-gov-stat-value"><?= $data['stats']['total_alternatif'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Total Layanan</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-tasks"></i></div>
    <p class="card-gov-stat-label">Kriteria</p>
    <p class="card-gov-stat-value"><?= $data['stats']['total_kriteria'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Total Kriteria</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Responden</p>
    <p class="card-gov-stat-value"><?= $data['stats']['total_responden'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Total Responden</p>
  </div>
  <div class="card-gov-stat card-gov-stat-maroon">
    <div class="card-gov-stat-icon"><i class="fas fa-chart-line"></i></div>
    <p class="card-gov-stat-label">Hasil SMART</p>
    <p class="card-gov-stat-value"><?= $data['stats']['total_hasil'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Perhitungan Selesai</p>
  </div>
</div>

<div class="card-gov mb-6">
  <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
    <div>
      <h3 class="font-bold text-slate-800">Performa Layanan (Periode Terbaru)</h3>
      <p class="text-sm text-slate-500">Ranking layanan berdasarkan metode SMART</p>
    </div>
    <a href="index.php?controller=kepalaDinas&action=laporan" class="btn-gov-primary !py-2 !text-xs"><i class="fas fa-file-alt"></i> Laporan Lengkap</a>
  </div>
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>Rank</th><th>Kode</th><th>Nama Layanan</th><th>Nilai SMART</th><th>Tanggal</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (!empty($data['layanan_performance'])): ?>
          <?php foreach ($data['layanan_performance'] as $index => $layanan): ?>
            <tr>
              <td>
                <?php if ($index == 0): ?><span class="badge-gov-gold">🥇 <?= $index + 1 ?></span>
                <?php elseif ($index == 1): ?><span class="badge-gov-info">🥈 <?= $index + 1 ?></span>
                <?php elseif ($index == 2): ?><span class="badge-gov-warning">🥉 <?= $index + 1 ?></span>
                <?php else: ?><span class="badge-gov-info"><?= $index + 1 ?></span>
                <?php endif; ?>
              </td>
              <td><span class="badge-gov-primary"><?= htmlspecialchars($layanan['kode_alternatif']) ?></span></td>
              <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
              <td>
                <div class="bar-gov-track w-32">
                  <div class="bar-gov-fill" style="width: <?= $layanan['nilai_smart'] ?>%"></div>
                </div>
                <span class="text-xs text-slate-500"><?= number_format($layanan['nilai_smart'], 2) ?>%</span>
              </td>
              <td class="text-xs text-slate-500"><?= date('d/m/Y H:i', strtotime($layanan['tanggal_perhitungan'])) ?></td>
              <td>
                <?php if ($layanan['nilai_smart'] >= 80): ?><span class="badge-gov-success">Sangat Baik</span>
                <?php elseif ($layanan['nilai_smart'] >= 60): ?><span class="badge-gov-info">Baik</span>
                <?php elseif ($layanan['nilai_smart'] >= 40): ?><span class="badge-gov-warning">Cukup</span>
                <?php else: ?><span class="badge-gov-danger">Kurang</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center text-slate-400 py-6">
            Belum ada data perhitungan SMART<br>
            <a href="index.php?controller=hasil&action=index" class="btn-gov-primary !py-2 !text-xs mt-2 inline-flex"><i class="fas fa-calculator"></i> Lihat Hasil SMART</a>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-1">Top 10 Layanan Terbaik</h3>
    <p class="text-sm text-slate-500 mb-4">Berdasarkan rata-rata nilai SMART</p>
    <div class="table-gov-scroll">
      <table class="table-gov">
        <thead><tr><th>Rank</th><th>Kode</th><th>Layanan</th><th>Nilai</th><th>Total</th></tr></thead>
        <tbody>
          <?php if (!empty($data['top_layanan'])): ?>
            <?php foreach ($data['top_layanan'] as $index => $layanan): ?>
              <tr>
                <td><span class="row-number-gov"><?= $index + 1 ?></span></td>
                <td><?= htmlspecialchars($layanan['kode_alternatif']) ?></td>
                <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
                <td><span class="badge-gov-primary"><?= number_format($layanan['rata_nilai'], 4) ?></span></td>
                <td><span class="badge-gov-info"><?= $layanan['total_penilaian'] ?>x</span></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-slate-400 py-6">Belum ada data</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-1">Distribusi Jenis Kriteria</h3>
    <p class="text-sm text-slate-500 mb-4">Berdasarkan tipe kriteria</p>
    <div style="height: 220px;"><canvas id="kriteriaPieChart"></canvas></div>
  </div>
</div>

<div class="card-gov">
  <h3 class="font-bold text-slate-800 mb-4">Menu Laporan & Analisis</h3>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
    <a href="index.php?controller=kepalaDinas&action=laporan" class="btn-gov-primary w-full"><i class="fas fa-file-alt"></i> Laporan Lengkap</a>
    <a href="index.php?controller=alternatif&action=index" class="btn-gov-secondary w-full"><i class="fas fa-list"></i> Daftar Layanan</a>
    <a href="index.php?controller=hasil&action=index" class="btn-gov-gold w-full"><i class="fas fa-chart-bar"></i> Hasil SMART</a>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  const ctx = document.getElementById('kriteriaPieChart').getContext('2d');
  <?php
    $benefitCount = 0; $costCount = 0;
    if (!empty($data['kriteria_dist'])) {
      foreach ($data['kriteria_dist'] as $dist) {
        if ($dist['jenis'] == 'benefit') $benefitCount = $dist['total'];
        if ($dist['jenis'] == 'cost') $costCount = $dist['total'];
      }
    }
  ?>
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Benefit', 'Cost'],
      datasets: [{
        label: 'Jumlah Kriteria',
        data: [<?= $benefitCount ?>, <?= $costCount ?>],
        backgroundColor: ['#1D4E8F', '#D4AF37'],
        borderRadius: 6
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
    }
  });
</script>
