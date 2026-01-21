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

              <!-- Header -->
              <div class="home-header mb-4" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="animated-title">
                    <div class="d-flex align-items-center">
                      <div class="title-icon mr-3">
                        <i class="fas fa-user fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Detail Hasil Perhitungan</h3>
                        <p class="text-muted mb-0">Hasil SMART untuk Responden</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=hasil&action=index"
                       class="btn btn-modern-back btn-lg">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Responden Info Card -->
                <div class="card-modern card-modern-info mb-4" data-aos="fade-up">
                  <div class="card-modern-body">
                    <div class="row align-items-center">
                      <div class="col-md-8">
                        <h4 class="mb-3">
                          <i class="fas fa-user-circle mr-2"></i>
                          <?= htmlspecialchars($data['responden']['nama_lengkap']) ?>
                        </h4>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="mb-2">
                              <i class="fas fa-birthday-cake mr-2 text-muted"></i>
                              <strong>Usia:</strong> <?= $data['responden']['usia'] ?> tahun
                            </p>
                            <p class="mb-0">
                              <i class="fas fa-briefcase mr-2 text-muted"></i>
                              <strong>Pekerjaan:</strong> <?= htmlspecialchars($data['responden']['pekerjaan']) ?>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <p class="mb-2">
                              <i class="fas fa-calendar mr-2 text-muted"></i>
                              <strong>Terdaftar:</strong>
                              <?= date('d M Y', strtotime($data['responden']['created_at'])) ?>
                            </p>
                            <p class="mb-0">
                              <i class="fas fa-list-ol mr-2 text-muted"></i>
                              <strong>Total Layanan Dinilai:</strong> <?= count($data['all_penilaians']) ?>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 text-center">
                        <div class="ranking-circle">
                          <div class="ranking-value">
                            <?= count($data['all_penilaians']) ?>
                          </div>
                          <div class="ranking-label">Layanan</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Best Service Card -->
                <?php if (!empty($data['hasil'])): ?>
                  <?php $best_service = $data['hasil']; ?>
                  <div class="best-service-card mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="best-service-body">
                      <div class="best-service-icon">
                        <i class="fas fa-trophy"></i>
                      </div>
                      <div class="best-service-content">
                        <h5 class="text-success mb-2">
                          <i class="fas fa-star mr-2"></i>Layanan Terbaik
                        </h5>
                        <h4 class="mb-1"><?= htmlspecialchars($best_service['nama_layanan']) ?></h4>
                        <p class="text-muted mb-0">
                          Nilai SMART: <strong class="text-success"><?= number_format($best_service['nilai_smart'], 2) ?></strong>
                        </p>
                        <p class="text-muted mb-0">
                          <small>Tanggal: <?= date('d/m/Y H:i', strtotime($best_service['tanggal_perhitungan'])) ?></small>
                        </p>
                      </div>
                      <div class="best-service-score">
                        <div class="score-number"><?= number_format($best_service['nilai_smart'], 1) ?></div>
                        <div class="score-label">Points</div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

                <!-- All Services Table -->
                <div class="card-modern-table" data-aos="fade-up" data-aos-delay="200">
                  <div class="card-modern-table-body">
                    <h5 class="mb-3">
                      <i class="fas fa-list mr-2"></i>Semua Layanan yang Dinilai
                    </h5>
                    <div class="alert alert-info mb-3">
                      <i class="fas fa-info-circle mr-2"></i>
                      Menampilkan detail perhitungan SMART untuk semua layanan
                    </div>
                    <div class="table-responsive-modern">
                      <table class="table-modern">
                        <thead>
                          <tr>
                            <th width="10%">No</th>
                            <th width="40%">Layanan</th>
                            <th width="50%">Nilai SMART</th>
                            <th width="20%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($data['all_penilaians'])): ?>
                            <?php
                            // Group penilaians by alternatif
                            $grouped = [];
                            foreach ($data['all_penilaians'] as $p) {
                              if (!isset($grouped[$p['id_alternatif']])) {
                                $grouped[$p['id_alternatif']] = [
                                  'nama_layanan' => $p['nama_layanan'],
                                  'nilai_smart' => 0,
                                  'kriteria_count' => 0
                                ];
                              }
                              $grouped[$p['id_alternatif']]['nilai_smart'] += $p['nilai_utility'];
                              $grouped[$p['id_alternatif']]['kriteria_count']++;
                            }

                            // Sort by nilai_smart descending
                            uasort($grouped, function($a, $b) {
                              return $b['nilai_smart'] <=> $a['nilai_smart'];
                            });
                            ?>

                            <?php $no = 1; foreach ($grouped as $id_alt => $layanan): ?>
                              <tr class="table-row-modern">
                                <td>
                                  <span class="row-number"><?= $no++ ?></span>
                                </td>
                                <td>
                                  <div class="layanan-info">
                                    <strong><?= htmlspecialchars($layanan['nama_layanan']) ?></strong>
                                    <small class="text-muted d-block">
                                      <i class="fas fa-check-circle mr-1"></i>
                                      <?= $layanan['kriteria_count'] ?> kriteria dinilai
                                    </small>
                                  </div>
                                </td>
                                <td>
                                  <div class="smart-value-wrapper">
                                    <div class="smart-value
                                      <?= $layanan['nilai_smart'] >= 80 ? 'text-success' :
                                         ($layanan['nilai_smart'] >= 60 ? 'text-info' :
                                         ($layanan['nilai_smart'] >= 40 ? 'text-warning' : 'text-danger')) ?>">
                                      <?= number_format($layanan['nilai_smart'], 2) ?>
                                    </div>
                                    <div class="progress" style="height: 8px; width: 150px;">
                                      <div class="progress-bar
                                        <?= $layanan['nilai_smart'] >= 80 ? 'bg-success' :
                                           ($layanan['nilai_smart'] >= 60 ? 'bg-info' :
                                           ($layanan['nilai_smart'] >= 40 ? 'bg-warning' : 'bg-danger')) ?>"
                                           role="progressbar"
                                           style="width: <?= $layanan['nilai_smart'] ?>%">
                                      </div>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <a href="index.php?controller=penilaian&action=detailSmart&id_responden=<?= $data['responden']['id_responden'] ?>"
                                     class="btn-modern-action btn-modern-view"
                                     title="Lihat Detail Perhitungan Lengkap">
                                    <i class="fas fa-chart-line"></i>
                                  </a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="4" class="text-center">
                                <p class="text-muted">Tidak ada data penilaian</p>
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <!-- Custom CSS -->
  <style>
    .card-modern {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .card-modern-info {
      background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
    }

    .card-modern-body {
      padding: 1.5rem;
      color: #fff;
    }

    .card-modern h4 {
      color: #fff;
    }

    .card-modern p {
      color: rgba(255, 255, 255, 0.9);
    }

    .ranking-circle {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .ranking-value {
      font-size: 2.5rem;
      font-weight: 700;
      color: #fff;
      line-height: 1;
    }

    .ranking-label {
      font-size: 0.875rem;
      color: rgba(255, 255, 255, 0.9);
      margin-top: 0.25rem;
    }

    .card-modern-table {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
    }

    .card-modern-table-body {
      padding: 1.5rem;
    }

    .table-modern thead th {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      font-weight: 600;
      padding: 1rem;
      border: none;
    }

    .table-modern thead th:first-child {
      border-top-left-radius: 16px;
    }

    .table-modern thead th:last-child {
      border-top-right-radius: 16px;
    }

    .table-row-modern {
      transition: all 0.3s ease;
    }

    .table-row-modern:hover {
      background: linear-gradient(90deg, rgba(74, 85, 104, 0.05) 0%, rgba(45, 55, 72, 0.05) 100%);
    }

    .table-modern td {
      padding: 1.25rem;
      border-bottom: 1px solid #e2e8f0;
      vertical-align: middle;
    }

    .ranking-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1rem;
    }

    .ranking-1 {
      background: linear-gradient(135deg, #d69e2e 0%, #b7791f 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(214, 158, 46, 0.4);
    }

    .ranking-2 {
      background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
      color: #fff;
    }

    .ranking-3 {
      background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
      color: #fff;
    }

    .ranking-4, .ranking-5, .ranking-6 {
      background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
      color: #4a5568;
    }

    .smart-value-wrapper {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .smart-value {
      font-size: 1.75rem;
      font-weight: 700;
    }

    .layanan-info strong {
      color: #2d3748;
      font-weight: 600;
    }

    .btn-modern-back {
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(113, 128, 150, 0.3);
      text-decoration: none;
      display: inline-block;
    }

    .btn-modern-back:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(113, 128, 150, 0.4);
    }

    .btn-modern-action {
      width: 45px;
      height: 45px;
      border-radius: 12px;
      border: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-modern-view {
      background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);
    }

    .btn-modern-view:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(49, 130, 206, 0.4);
    }

    .best-service-card {
      background: linear-gradient(135deg, #d69e2e 0%, #b7791f 100%);
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(214, 158, 46, 0.3);
      overflow: hidden;
    }

    .best-service-body {
      padding: 2rem;
      display: flex;
      align-items: center;
      gap: 2rem;
      color: #fff;
    }

    .best-service-icon {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
    }

    .best-service-content {
      flex: 1;
    }

    .best-service-content h4 {
      color: #fff;
      font-size: 1.5rem;
    }

    .best-service-content p {
      color: rgba(255, 255, 255, 0.9);
    }

    .best-service-score {
      text-align: center;
    }

    .score-number {
      font-size: 3rem;
      font-weight: 700;
      line-height: 1;
    }

    .score-label {
      font-size: 0.875rem;
      opacity: 0.9;
    }

    .title-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 24px rgba(74, 85, 104, 0.3);
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    @media (max-width: 768px) {
      .best-service-body {
        flex-direction: column;
        text-align: center;
      }

      .smart-value-wrapper {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>

  <script>
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 50
    });
  </script>

</body>

</html>
