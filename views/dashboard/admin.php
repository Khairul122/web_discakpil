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
                    <p class="text-muted">Dashboard Administrator - Sistem DISDUKCAPIL Kota Padang</p>
                  </div>
                  <div class="badge badge-success badge-pill px-3 py-2">
                    <i class="fas fa-user-shield mr-1"></i>
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
                            <h4 class="card-title text-white">Penilaian</h4>
                            <h2 class="mb-0 font-weight-bold"><?= $data['stats']['total_penilaian'] ?? 0 ?></h2>
                            <p class="text-white opacity-75 small">Total Penilaian</p>
                          </div>
                          <i class="fas fa-star icon-lg fa-2x text-white opacity-50"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Charts & Tables -->
                <div class="row">
                  <!-- Top Layanan Table -->
                  <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Top 5 Layanan Terbaik</h4>
                        <p class="card-description">Berdasarkan rata-rata nilai SMART</p>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Rank</th>
                                <th>Kode</th>
                                <th>Nama Layanan</th>
                                <th>Nilai Rata-rata</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (!empty($data['top_layanan'])): ?>
                                <?php foreach ($data['top_layanan'] as $index => $layanan): ?>
                                <tr>
                                  <td><span class="badge badge-primary"><?= $index + 1 ?></span></td>
                                  <td><?= htmlspecialchars($layanan['kode_alternatif']) ?></td>
                                  <td><?= htmlspecialchars($layanan['nama_layanan']) ?></td>
                                  <td><span class="badge badge-success"><?= number_format($layanan['rata_nilai'], 4) ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Recent Activities -->
                <div class="row">
                  <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Aktivitas Terbaru</h4>
                        <p class="card-description">Penilaian dan hasil SMART terbaru</p>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="activityTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="penilaian-tab" data-toggle="tab" href="#penilaian" role="tab">Penilaian Terbaru</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="hasil-tab" data-toggle="tab" href="#hasil" role="tab">Hasil SMART</a>
                          </li>
                        </ul>

                        <div class="tab-content" id="activityTabContent">
                          <!-- Penilaian Tab -->
                          <div class="tab-pane fade show active" id="penilaian" role="tabpanel">
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Responden</th>
                                    <th>Layanan</th>
                                    <th>Kriteria</th>
                                    <th>Sub Kriteria</th>
                                  </tr>
                                </thead>
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
                                    <tr>
                                      <td colspan="4" class="text-center text-muted">Belum ada data penilaian</td>
                                    </tr>
                                  <?php endif; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>

                          <!-- Hasil Tab -->
                          <div class="tab-pane fade" id="hasil" role="tabpanel">
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Kode Layanan</th>
                                    <th>Nama Layanan</th>
                                    <th>Nilai SMART</th>
                                    <th>Tanggal Perhitungan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php if (!empty($data['activities']['hasil_smart'])): ?>
                                    <?php foreach ($data['activities']['hasil_smart'] as $hasil): ?>
                                    <tr>
                                      <td><?= htmlspecialchars($hasil['kode_alternatif']) ?></td>
                                      <td><?= htmlspecialchars($hasil['nama_layanan']) ?></td>
                                      <td><span class="badge badge-success"><?= number_format($hasil['nilai_smart'], 4) ?></span></td>
                                      <td><?= date('d/m/Y H:i', strtotime($hasil['tanggal_perhitungan'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                  <?php else: ?>
                                    <tr>
                                      <td colspan="4" class="text-center text-muted">Belum ada hasil perhitungan</td>
                                    </tr>
                                  <?php endif; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                  <div class="col-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Aksi Cepat</h4>
                        <div class="row">
                          <div class="col-md-3">
                            <a href="index.php?controller=alternatif&action=index" class="btn btn-gradient-primary btn-block">
                              <i class="fas fa-clipboard-list mr-2"></i>Kelola Layanan
                            </a>
                          </div>
                          <div class="col-md-3">
                            <a href="index.php?controller=kriteria&action=index" class="btn btn-gradient-success btn-block">
                              <i class="fas fa-tasks mr-2"></i>Kelola Kriteria
                            </a>
                          </div>
                          <div class="col-md-3">
                            <a href="index.php?controller=responden&action=index" class="btn btn-gradient-info btn-block">
                              <i class="fas fa-users mr-2"></i>Kelola Responden
                            </a>
                          </div>
                          <div class="col-md-3">
                            <a href="index.php?controller=hasil&action=index" class="btn btn-gradient-warning btn-block">
                              <i class="fas fa-calculator mr-2"></i>Hasil SMART
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
    const ctx = document.getElementById('kriteriaChart').getContext('2d');
    const kriteriaChart = new Chart(ctx, {
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
              family: "'Inter', sans-serif"
            },
            bodyFont: {
              size: 13,
              family: "'Inter', sans-serif"
            },
            padding: 12,
            cornerRadius: 4
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            },
            ticks: {
              font: {
                family: "'Inter', sans-serif",
                size: 12
              },
              color: '#4a5568'
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
