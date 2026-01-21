<?php include('template/header.php'); ?>

<body class="with-welcome-text">
  <div class="container-scroller">
    <?php include 'template/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'template/setting_panel.php'; ?>
      <?php include 'template/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-header">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div>
                    <h3 class="font-weight-bold mb-1">Selamat Datang, <?= htmlspecialchars($data['user']['nama_lengkap']) ?>!</h3>
                    <p class="text-muted">Dashboard Kepala Dinas - Sistem DISDUKCAPIL Kota Padang</p>
                  </div>
                  <div class="badge badge-info badge-pill px-3 py-2">
                    <i class="fas fa-user-tie mr-1"></i>
                    <?= ucfirst($data['user']['role']) ?>
                  </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row">
                  <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card bg-gradient-primary text-white">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="card-title text-white">Layanan</h4>
                            <h2 class="mb-0 font-weight-bold"><?= $data['stats']['total_alternatif'] ?? 0 ?></h2>
                            <p class="text-white opacity-75 small">Total Layanan</p>
                          </div>
                          <i class="fas fa-clipboard-list icon-lg fa-2x text-white opacity-50"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card bg-gradient-success text-white">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="card-title text-white">Kriteria</h4>
                            <h2 class="mb-0 font-weight-bold"><?= $data['stats']['total_kriteria'] ?? 0 ?></h2>
                            <p class="text-white opacity-75 small">Total Kriteria</p>
                          </div>
                          <i class="fas fa-tasks icon-lg fa-2x text-white opacity-50"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card bg-gradient-info text-white">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="card-title text-white">Responden</h4>
                            <h2 class="mb-0 font-weight-bold"><?= $data['stats']['total_responden'] ?? 0 ?></h2>
                            <p class="text-white opacity-75 small">Total Responden</p>
                          </div>
                          <i class="fas fa-users icon-lg fa-2x text-white opacity-50"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card bg-gradient-warning text-white">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                          <div>
                            <h4 class="card-title text-white">Hasil SMART</h4>
                            <h2 class="mb-0 font-weight-bold"><?= $data['stats']['total_hasil'] ?? 0 ?></h2>
                            <p class="text-white opacity-75 small">Perhitungan Selesai</p>
                          </div>
                          <i class="fas fa-chart-line icon-lg fa-2x text-white opacity-50"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Layanan Performance Table -->
                <div class="row">
                  <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                          <div>
                            <h4 class="card-title">Performa Layanan (Periode Terbaru)</h4>
                            <p class="card-description">Ranking layanan berdasarkan metode SMART</p>
                          </div>
                          <a href="index.php?controller=kepala_dinas&action=laporan" class="btn btn-gradient-primary btn-sm">
                            <i class="fas fa-file-alt mr-2"></i>Lihat Laporan Lengkap
                          </a>
                        </div>

                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Ranking</th>
                                <th>Kode</th>
                                <th>Nama Layanan</th>
                                <th>Nilai Akhir</th>
                                <th>Periode</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($data['layanan_performance'])): ?>
                                <?php foreach ($data['layanan_performance'] as $index => $layanan): ?>
                                <tr>
                                  <td>
                                    <?php if ($layanan['ranking'] == 1): ?>
                                      <span class="badge badge-success badge-pill">🥇 <?= $layanan['ranking'] ?></span>
                                    <?php elseif ($layanan['ranking'] == 2): ?>
                                      <span class="badge badge-info badge-pill">🥈 <?= $layanan['ranking'] ?></span>
                                    <?php elseif ($layanan['ranking'] == 3): ?>
                                      <span class="badge badge-warning badge-pill">🥉 <?= $layanan['ranking'] ?></span>
                                    <?php else: ?>
                                      <span class="badge badge-secondary badge-pill"><?= $layanan['ranking'] ?></span>
                                    <?php endif; ?>
                                  </td>
                                  <td><span class="badge badge-primary"><?= htmlspecialchars($layanan['kode_alternatif']) ?></span></td>
                                  <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
                                  <td>
                                    <div class="progress">
                                      <div class="progress-bar bg-gradient-primary" role="progressbar"
                                           style="width: <?= ($layanan['nilai_akhir'] * 100) ?>%"
                                           aria-valuenow="<?= $layanan['nilai_akhir'] * 100 ?>"
                                           aria-valuemin="0" aria-valuemax="100">
                                        <?= number_format($layanan['nilai_akhir'] * 100, 2) ?>%
                                      </div>
                                    </div>
                                  </td>
                                  <td><?= date('d/m/Y', strtotime($layanan['periode'])) ?></td>
                                  <td>
                                    <?php if ($layanan['nilai_akhir'] >= 0.8): ?>
                                      <span class="badge badge-success">Sangat Baik</span>
                                    <?php elseif ($layanan['nilai_akhir'] >= 0.6): ?>
                                      <span class="badge badge-info">Baik</span>
                                    <?php elseif ($layanan['nilai_akhir'] >= 0.4): ?>
                                      <span class="badge badge-warning">Cukup</span>
                                    <?php else: ?>
                                      <span class="badge badge-danger">Kurang</span>
                                    <?php endif; ?>
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Belum ada data perhitungan SMART</p>
                                    <a href="index.php?controller=smart&action=index" class="btn btn-gradient-primary btn-sm mt-2">
                                      <i class="fas fa-calculator mr-2"></i>Mulai Perhitungan
                                    </a>
                                  </td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Top 10 Layanan & Survey Trend -->
                <div class="row">
                  <div class="col-lg-7 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Top 10 Layanan Terbaik</h4>
                        <p class="card-description">Berdasarkan rata-rata nilai SMART</p>
                        <div class="table-responsive">
                          <table class="table table-sm">
                            <thead>
                              <tr>
                                <th>Rank</th>
                                <th>Kode</th>
                                <th>Layanan</th>
                                <th>Nilai Rata-rata</th>
                                <th>Total Penilaian</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($data['top_layanan'])): ?>
                                <?php foreach ($data['top_layanan'] as $index => $layanan): ?>
                                <tr>
                                  <td>
                                    <?php if ($index < 3): ?>
                                      <span class="badge badge-<?= $index == 0 ? 'success' : ($index == 1 ? 'info' : 'warning') ?>">
                                        <?= $index + 1 ?>
                                      </span>
                                    <?php else: ?>
                                      <span class="badge badge-secondary"><?= $index + 1 ?></span>
                                    <?php endif; ?>
                                  </td>
                                  <td><?= htmlspecialchars($layanan['kode_alternatif']) ?></td>
                                  <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
                                  <td><span class="badge badge-primary"><?= number_format($layanan['rata_nilai'], 4) ?></span></td>
                                  <td><span class="badge badge-info"><?= $layanan['total_penilaian'] ?>x</span></td>
                                </tr>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Quick Actions for Kepala Dinas -->
                <div class="row">
                  <div class="col-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Menu Laporan & Analisis</h4>
                        <div class="row">
                          <div class="col-md-4 mb-3">
                            <a href="index.php?controller=kepala_dinas&action=laporan" class="btn btn-gradient-primary btn-block">
                              <i class="fas fa-file-alt mr-2"></i>Laporan Lengkap
                            </a>
                          </div>
                          <div class="col-md-4 mb-3">
                            <a href="index.php?controller=alternatif&action=index" class="btn btn-gradient-info btn-block">
                              <i class="fas fa-list mr-2"></i>Daftar Layanan
                            </a>
                          </div>
                          <div class="col-md-4 mb-3">
                            <a href="index.php?controller=smart&action=index" class="btn btn-gradient-success btn-block">
                              <i class="fas fa-chart-bar mr-2"></i>Hasil SMART
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <script>
    // Kriteria Distribution Chart - Horizontal Bar
    const ctx = document.getElementById('kriteriaPieChart').getContext('2d');
    const kriteriaPieChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Benefit', 'Cost'],
        datasets: [{
          label: 'Jumlah Kriteria',
          data: [
            <?php
              $benefitCount = 0;
              $costCount = 0;
              if (!empty($data['kriteria_dist'])):
                foreach ($data['kriteria_dist'] as $dist):
                  if ($dist['jenis'] == 'benefit') $benefitCount = $dist['total'];
                  if ($dist['jenis'] == 'cost') $costCount = $dist['total'];
                endforeach;
              endif;
            ?>
            <?= $benefitCount ?>,
            <?= $costCount ?>
          ],
          backgroundColor: ['#4a5568', '#718096'],
          borderColor: ['#2d3748', '#4a5568'],
          borderWidth: 2,
          borderRadius: 5
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleFont: {
              size: 14,
              family: "'Inter', sans-serif",
              weight: '600'
            },
            bodyFont: {
              size: 13,
              family: "'Inter', sans-serif"
            },
            padding: 12,
            cornerRadius: 4,
            callbacks: {
              label: function(context) {
                return context.parsed.x + ' kriteria';
              }
            }
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: {
                family: "'Inter', sans-serif",
                size: 12
              },
              color: '#4a5568',
              precision: 0
            }
          },
          y: {
            grid: {
              display: false
            },
            ticks: {
              font: {
                family: "'Inter', sans-serif",
                size: 13,
                weight: '500'
              },
              color: '#2d3748'
            }
          }
        }
      }
    });
  </script>

</body>

</html>
