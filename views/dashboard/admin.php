<?php $page_title = 'Dashboard Admin - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, <?= htmlspecialchars($data['user']['nama_lengkap']) ?>!</h1>
    <p class="text-slate-500">Dashboard Administrator - Sistem Penilaian Kepuasan Masyarakat Kantor DISDUKCAPIL Kota Padang (SMART)</p>
  </div>
  <span class="badge-gov-success"><i class="fas fa-user-shield"></i> <?= ucfirst($data['user']['role']) ?></span>
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
    <div class="card-gov-stat-icon"><i class="fas fa-star"></i></div>
    <p class="card-gov-stat-label">Penilaian</p>
    <p class="card-gov-stat-value"><?= $data['stats']['total_penilaian'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Total Penilaian</p>
  </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-1">Top 5 Layanan Terbaik</h3>
    <p class="text-sm text-slate-500 mb-4">Berdasarkan rata-rata nilai SMART</p>
    <div class="table-gov-scroll">
      <table class="table-gov">
        <thead><tr><th>Rank</th><th>Kode</th><th>Nama Layanan</th><th>Nilai</th></tr></thead>
        <tbody>
          <?php if (!empty($data['top_layanan'])): ?>
            <?php foreach ($data['top_layanan'] as $index => $layanan): ?>
              <tr>
                <td><span class="row-number-gov"><?= $index + 1 ?></span></td>
                <td><?= htmlspecialchars($layanan['kode_alternatif']) ?></td>
                <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
                <td><span class="badge-gov-success"><?= number_format($layanan['rata_nilai'], 4) ?></span></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center text-slate-400 py-6">Belum ada data</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-gov">
    <h3 class="font-bold text-slate-800 mb-1">Distribusi Kriteria</h3>
    <p class="text-sm text-slate-500 mb-4">Benefit vs Cost</p>
    <div style="height: 220px;"><canvas id="kriteriaChart"></canvas></div>
  </div>
</div>

<div class="card-gov mb-6">
  <h3 class="font-bold text-slate-800 mb-4">Aktivitas Terbaru</h3>
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>Responden</th><th>Layanan</th><th>Kriteria</th><th>Sub Kriteria</th></tr></thead>
      <tbody>
        <?php if (!empty($data['activities']['penilaian'])): ?>
          <?php foreach ($data['activities']['penilaian'] as $penilaian): ?>
            <tr>
              <td><?= htmlspecialchars($penilaian['nama_responden']) ?></td>
              <td><?= htmlspecialchars($penilaian['nama_layanan']) ?></td>
              <td><?= htmlspecialchars($penilaian['nama_kriteria']) ?></td>
              <td><?= htmlspecialchars($penilaian['nama_sub']) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center text-slate-400 py-6">Belum ada data penilaian</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card-gov">
  <h3 class="font-bold text-slate-800 mb-4">Aksi Cepat</h3>
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    <a href="index.php?controller=alternatif&action=index" class="btn-gov-primary w-full"><i class="fas fa-clipboard-list"></i> Layanan</a>
    <a href="index.php?controller=kriteria&action=index" class="btn-gov-secondary w-full"><i class="fas fa-tasks"></i> Kriteria</a>
    <a href="index.php?controller=responden&action=index" class="btn-gov-secondary w-full"><i class="fas fa-users"></i> Responden</a>
    <a href="index.php?controller=hasil&action=index" class="btn-gov-gold w-full"><i class="fas fa-calculator"></i> Hasil SMART</a>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  const ctx = document.getElementById('kriteriaChart').getContext('2d');
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
        backgroundColor: ['#2563EB', '#F59E0B'],
        borderRadius: 6
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { x: { beginAtZero: true } }
    }
  });
</script>
