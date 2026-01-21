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
                        <i class="fas fa-concierge-bell fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Detail Hasil Layanan</h3>
                        <p class="text-muted mb-0">Hasil Perhitungan SMART per Layanan</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=hasil&action=index&view=alternatif"
                       class="btn btn-modern-back btn-lg">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Alternatif Info Card -->
                <div class="card-modern card-modern-service mb-4" data-aos="fade-up">
                  <div class="card-modern-body">
                    <div class="row align-items-center">
                      <div class="col-md-8">
                        <h4 class="mb-3">
                          <i class="fas fa-concierge-bell mr-2"></i>
                          <?= htmlspecialchars($data['alternatif']['nama_layanan']) ?>
                        </h4>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="mb-2">
                              <i class="fas fa-users mr-2 text-muted"></i>
                              <strong>Total Penilai:</strong> <?= $data['statistics']['total_penilai'] ?>
                            </p>
                            <p class="mb-0">
                              <i class="fas fa-chart-line mr-2 text-muted"></i>
                              <strong>Rata-rata:</strong>
                              <span class="text-success"><?= number_format($data['statistics']['rerata'], 2) ?></span>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <p class="mb-2">
                              <i class="fas fa-arrow-up mr-2 text-success"></i>
                              <strong>Nilai Tertinggi:</strong>
                              <?= number_format($data['statistics']['tertinggi'], 2) ?>
                            </p>
                            <p class="mb-0">
                              <i class="fas fa-arrow-down mr-2 text-danger"></i>
                              <strong>Nilai Terendah:</strong>
                              <?= number_format($data['statistics']['terendah'], 2) ?>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 text-center">
                        <div class="rating-circle">
                          <div class="rating-value">
                            <?= number_format($data['statistics']['rerata'], 1) ?>
                          </div>
                          <div class="rating-label">Rata-rata</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card stat-card-success">
                      <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                      </div>
                      <div class="stat-content">
                        <div class="stat-label">Rata-rata</div>
                        <div class="stat-value"><?= number_format($data['statistics']['rerata'], 2) ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card stat-card-info">
                      <div class="stat-icon">
                        <i class="fas fa-arrow-up"></i>
                      </div>
                      <div class="stat-content">
                        <div class="stat-label">Tertinggi</div>
                        <div class="stat-value"><?= number_format($data['statistics']['tertinggi'], 2) ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card stat-card-warning">
                      <div class="stat-icon">
                        <i class="fas fa-arrow-down"></i>
                      </div>
                      <div class="stat-content">
                        <div class="stat-label">Terendah</div>
                        <div class="stat-value"><?= number_format($data['statistics']['terendah'], 2) ?></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card stat-card-primary">
                      <div class="stat-icon">
                        <i class="fas fa-users"></i>
                      </div>
                      <div class="stat-content">
                        <div class="stat-label">Penilai</div>
                        <div class="stat-value"><?= $data['statistics']['total_penilai'] ?></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Responden Table -->
                <div class="card-modern-table" data-aos="fade-up" data-aos-delay="100">
                  <div class="card-modern-table-body">
                    <h5 class="mb-3">
                      <i class="fas fa-list mr-2"></i>Daftar Responden yang Menilai
                    </h5>
                    <div class="table-responsive-modern">
                      <table class="table-modern">
                        <thead>
                          <tr>
                            <th width="10%">No</th>
                            <th width="35%">Responden</th>
                            <th width="40%">Nilai SMART</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1; foreach ($data['hasil_list'] as $hasil): ?>
                            <tr class="table-row-modern">
                              <td>
                                <span class="row-number"><?= $no++ ?></span>
                              </td>
                              <td>
                                <div class="responden-info">
                                  <strong><?= htmlspecialchars($hasil['nama_lengkap']) ?></strong>
                                  <small class="text-muted d-block">
                                    <i class="fas fa-birthday-cake mr-1"></i><?= $hasil['usia'] ?> tahun
                                    <span class="mx-1">|</span>
                                    <i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($hasil['pekerjaan']) ?>
                                  </small>
                                </div>
                              </td>
                              <td>
                                <div class="smart-value-wrapper">
                                  <div class="smart-value
                                    <?= $hasil['nilai_smart'] >= 80 ? 'text-success' :
                                       ($hasil['nilai_smart'] >= 60 ? 'text-info' :
                                       ($hasil['nilai_smart'] >= 40 ? 'text-warning' : 'text-danger')) ?>">
                                    <?= number_format($hasil['nilai_smart'], 2) ?>
                                  </div>
                                  <div class="progress" style="height: 8px; width: 150px;">
                                    <div class="progress-bar
                                      <?= $hasil['nilai_smart'] >= 80 ? 'bg-success' :
                                         ($hasil['nilai_smart'] >= 60 ? 'bg-info' :
                                         ($hasil['nilai_smart'] >= 40 ? 'bg-warning' : 'bg-danger')) ?>"
                                         role="progressbar"
                                         style="width: <?= $hasil['nilai_smart'] ?>%">
                                    </div>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <?php if ($hasil['nilai_smart'] >= 80): ?>
                                  <span class="badge badge-success">Sangat Baik</span>
                                <?php elseif ($hasil['nilai_smart'] >= 60): ?>
                                  <span class="badge badge-info">Baik</span>
                                <?php elseif ($hasil['nilai_smart'] >= 40): ?>
                                  <span class="badge badge-warning">Cukup</span>
                                <?php elseif ($hasil['nilai_smart'] >= 20): ?>
                                  <span class="badge badge-danger">Kurang</span>
                                <?php else: ?>
                                  <span class="badge badge-dark">Sangat Kurang</span>
                                <?php endif; ?>
                              </td>
                              <td>
                                <a href="index.php?controller=hasil&action=detailResponden&id_responden=<?= $hasil['id_responden'] ?>"
                                   class="btn-modern-action btn-modern-view"
                                   title="Lihat Detail Responden">
                                  <i class="fas fa-eye"></i>
                                </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
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

    .card-modern-service {
      background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%);
    }

    .card-modern-body {
      padding: 1.5rem;
      color: #fff;
    }

    .card-modern h4, .card-modern h5 {
      color: #fff;
    }

    .card-modern p {
      color: rgba(255, 255, 255, 0.9);
    }

    .rating-circle {
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

    .rating-value {
      font-size: 2.5rem;
      font-weight: 700;
      color: #fff;
      line-height: 1;
    }

    .rating-label {
      font-size: 0.875rem;
      color: rgba(255, 255, 255, 0.9);
      margin-top: 0.25rem;
    }

    /* Stat Cards */
    .stat-card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card-success {
      border-left: 4px solid #38a169;
    }

    .stat-card-info {
      border-left: 4px solid #3182ce;
    }

    .stat-card-warning {
      border-left: 4px solid #d69e2e;
    }

    .stat-card-primary {
      border-left: 4px solid #4a5568;
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
    }

    .stat-card-success .stat-icon {
      background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    }

    .stat-card-info .stat-icon {
      background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
    }

    .stat-card-warning .stat-icon {
      background: linear-gradient(135deg, #d69e2e 0%, #b7791f 100%);
    }

    .stat-card-primary .stat-icon {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
    }

    .stat-label {
      font-size: 0.875rem;
      color: #718096;
      font-weight: 500;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2d3748;
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

    .card-modern-table h5 {
      color: #2d3748;
      font-weight: 600;
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

    .row-number {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .responden-info strong {
      color: #2d3748;
      font-weight: 600;
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
      .smart-value-wrapper {
        flex-direction: column;
        align-items: flex-start;
      }

      .stat-card {
        margin-bottom: 1rem;
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
