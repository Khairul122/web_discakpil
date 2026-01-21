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

              <!-- Modern Page Header -->
              <div class="home-header mb-4" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="animated-title">
                    <div class="d-flex align-items-center mb-2">
                      <div class="title-icon mr-3">
                        <i class="fas fa-chart-bar fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Hasil Perhitungan SMART</h3>
                        <p class="text-muted mb-0">Analisis Kepuasan Layanan DISDUKCAPIL Kota Padang</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <button onclick="confirmDeleteAll()" class="btn btn-modern-danger btn-lg shadow-sm hover-lift" data-aos="zoom-in" data-aos-delay="100">
                      <i class="fas fa-trash mr-2"></i>Hapus Semua
                    </button>
                  </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-modern card-modern-primary">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-users"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Responden</h4>
                          <h2 class="card-modern-value"><?= $data['statistics']['total_responden'] ?? 0 ?></h2>
                          <p class="card-modern-text">Dengan hasil perhitungan</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-modern card-modern-success">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-star"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Layanan Terbaik</h4>
                          <h2 class="card-modern-value" style="font-size: 1.5rem; line-height: 1.3;">
                            <?= htmlspecialchars($data['top_alternatif']['nama_layanan'] ?? '-') ?>
                          </h2>
                          <p class="card-modern-text">
                            Skor: <?= number_format($data['top_alternatif']['rerata_smart'] ?? 0, 2) ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-modern card-modern-info">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Rata-rata SMART</h4>
                          <h2 class="card-modern-value"><?= number_format($data['statistics']['rerata_keseluruhan'] ?? 0, 1) ?></h2>
                          <p class="card-modern-text">Skor keseluruhan</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-modern card-modern-warning">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-trophy"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Total Hasil</h4>
                          <h2 class="card-modern-value"><?= $data['statistics']['total_hasil'] ?? 0 ?></h2>
                          <p class="card-modern-text">Data perhitungan</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- View Mode Tabs -->
                <div class="card-modern-tabs mb-4" data-aos="fade-up" data-aos-delay="300">
                  <div class="tabs-header">
                    <button class="tab-btn <?= $data['view_mode'] === 'responden' ? 'active' : '' ?>"
                            onclick="switchView('responden')">
                      <i class="fas fa-users mr-2"></i>Per Responden
                    </button>
                    <button class="tab-btn <?= $data['view_mode'] === 'alternatif' ? 'active' : '' ?>"
                            onclick="switchView('alternatif')">
                      <i class="fas fa-concierge-bell mr-2"></i>Per Layanan
                    </button>
                    <div class="tab-actions">
                      <a href="index.php?controller=hasil&action=exportCSV&view=<?= $data['view_mode'] ?>"
                         class="btn btn-modern-export">
                        <i class="fas fa-file-csv mr-2"></i>Export CSV
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Modern Table -->
                <div class="card-modern-table" data-aos="fade-up" data-aos-delay="400">
                  <div class="card-modern-table-body">
                    <?php if ($data['view_mode'] === 'alternatif'): ?>
                      <!-- View by Alternatif (Layanan yang Paling Banyak Dipilih) -->
                      <?php if (!empty($data['hasil_data'])): ?>
                        <div class="table-responsive-modern">
                          <table class="table-modern">
                            <thead>
                              <tr>
                                <th width="10%">No</th>
                                <th width="40%">Layanan</th>
                                <th width="20%">Total Memilih</th>
                                <th width="20%">Rata-rata SMART</th>
                                <th width="10%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; foreach ($data['hasil_data'] as $alternatif): ?>
                                <tr class="table-row-modern">
                                  <td>
                                    <span class="row-number"><?= $no++ ?></span>
                                  </td>
                                  <td>
                                    <div class="layanan-info">
                                      <strong><?= htmlspecialchars($alternatif['nama_layanan']) ?></strong>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="stat-highlight">
                                      <i class="fas fa-users mr-2 text-info"></i>
                                      <strong><?= $alternatif['total_memilih'] ?></strong>
                                      <small class="text-muted">responden</small>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="smart-value-wrapper">
                                      <div class="smart-value
                                        <?= $alternatif['rerata_smart'] >= 80 ? 'text-success' :
                                           ($alternatif['rerata_smart'] >= 60 ? 'text-info' :
                                           ($alternatif['rerata_smart'] >= 40 ? 'text-warning' : 'text-danger')) ?>">
                                        <?= number_format($alternatif['rerata_smart'], 2) ?>
                                      </div>
                                    </div>
                                  </td>
                                  <td>
                                    <a href="index.php?controller=hasil&action=detailAlternatif&id_alternatif=<?= $alternatif['id_alternatif'] ?>"
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
                      <?php else: ?>
                        <div class="empty-state-modern">
                          <div class="empty-state-content">
                            <div class="empty-state-icon">
                              <i class="fas fa-chart-bar fa-4x"></i>
                            </div>
                            <h4 class="empty-state-title">Belum ada hasil perhitungan</h4>
                            <p class="empty-state-text">Silakan hitung SMART terlebih dahulu</p>
                            <a href="index.php?controller=penilaian&action=index" class="btn btn-modern-success btn-lg">
                              <i class="fas fa-calculator mr-2"></i>Hitung SMART
                            </a>
                          </div>
                        </div>
                      <?php endif; ?>

                    <?php else: ?>
                      <!-- View by Responden (Default) -->
                      <?php if (!empty($data['hasil_data'])): ?>
                        <div class="table-responsive-modern">
                          <table class="table-modern">
                            <thead>
                              <tr>
                                <th width="10%">No</th>
                                <th width="50%">Responden</th>
                                <th width="25%">Layanan Terbaik</th>
                                <th width="15%">Nilai SMART</th>
                                <th width="10%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1; foreach ($data['hasil_data'] as $hasil): ?>
                                <tr class="table-row-modern" data-aos="fade-in" data-aos-delay="<?= $no * 50 ?>">
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
                                    <div class="layanan-info">
                                      <span class="badge badge-modern-primary mr-2">
                                        <i class="fas fa-star mr-1"></i>Terbaik
                                      </span>
                                      <strong><?= htmlspecialchars($hasil['nama_layanan']) ?></strong>
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
                                      <div class="progress" style="height: 4px; width: 100px;">
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
                                    <div class="action-buttons-modern">
                                      <a href="index.php?controller=hasil&action=detailResponden&id_responden=<?= $hasil['id_responden'] ?>"
                                         class="btn-modern-action btn-modern-view"
                                         title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                      </a>
                                      <button onclick="confirmDeleteResponden(<?= $hasil['id_responden'] ?>)"
                                              class="btn-modern-action btn-modern-delete"
                                              title="Hapus Hasil">
                                        <i class="fas fa-trash"></i>
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      <?php else: ?>
                        <div class="empty-state-modern">
                          <div class="empty-state-content">
                            <div class="empty-state-icon">
                              <i class="fas fa-chart-bar fa-4x"></i>
                            </div>
                            <h4 class="empty-state-title">Belum ada hasil perhitungan</h4>
                            <p class="empty-state-text">Silakan hitung SMART terlebih dahulu</p>
                            <a href="index.php?controller=penilaian&action=index" class="btn btn-modern-success btn-lg">
                              <i class="fas fa-calculator mr-2"></i>Hitung SMART
                            </a>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
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

  <!-- Custom Modern CSS -->
  <style>
    /* Import from penilaian index */
    .card-modern {
      background: linear-gradient(135deg, var(--card-bg-1) 0%, var(--card-bg-2) 100%);
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      position: relative;
    }

    .card-modern::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--card-accent-1), var(--card-accent-2));
    }

    .card-modern-primary {
      --card-bg-1: #4a5568;
      --card-bg-2: #2d3748;
      --card-accent-1: #4a5568;
      --card-accent-2: #2d3748;
    }

    .card-modern-success {
      --card-bg-1: #38a169;
      --card-bg-2: #2f855a;
      --card-accent-1: #38a169;
      --card-accent-2: #2f855a;
    }

    .card-modern-info {
      --card-bg-1: #3182ce;
      --card-bg-2: #2b6cb0;
      --card-accent-1: #3182ce;
      --card-accent-2: #2b6cb0;
    }

    .card-modern-warning {
      --card-bg-1: #d69e2e;
      --card-bg-2: #b7791f;
      --card-accent-1: #d69e2e;
      --card-accent-2: #b7791f;
    }

    .card-modern-body {
      padding: 1.5rem;
      position: relative;
      z-index: 1;
    }

    .card-modern-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      font-size: 1.5rem;
      color: #fff;
    }

    .card-modern-content {
      color: #fff;
    }

    .card-modern-title {
      font-size: 0.875rem;
      font-weight: 500;
      opacity: 0.9;
      margin-bottom: 0.5rem;
    }

    .card-modern-value {
      font-size: 2rem;
      font-weight: 700;
      line-height: 1;
      margin-bottom: 0.5rem;
    }

    .card-modern-text {
      font-size: 0.75rem;
      opacity: 0.8;
      margin-bottom: 0;
    }

    /* Tabs */
    .card-modern-tabs {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .tabs-header {
      display: flex;
      align-items: center;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #e2e8f0;
      gap: 0.5rem;
    }

    .tab-btn {
      padding: 0.75rem 1.5rem;
      border: none;
      background: transparent;
      color: #4a5568;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .tab-btn:hover {
      background: rgba(74, 85, 104, 0.1);
    }

    .tab-btn.active {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
    }

    .tab-actions {
      margin-left: auto;
    }

    .btn-modern-export {
      background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(56, 161, 105, 0.3);
      text-decoration: none;
      display: inline-block;
    }

    .btn-modern-export:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(56, 161, 105, 0.4);
    }

    .btn-modern-danger {
      background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(229, 62, 62, 0.3);
    }

    .btn-modern-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(229, 62, 62, 0.4);
    }

    /* Table Styles */
    .card-modern-table {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-modern-table-body {
      padding: 0;
    }

    .table-responsive-modern {
      overflow-x: auto;
    }

    .table-modern {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 0;
    }

    .table-modern thead th {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      font-weight: 600;
      padding: 1rem 1.25rem;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      border: none;
      position: sticky;
      top: 0;
      z-index: 10;
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

    .table-modern tbody tr:last-child td {
      border-bottom: none;
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

    /* Ranking Badge */
    .ranking-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 0.875rem;
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

    /* Smart Value */
    .smart-value-wrapper {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .smart-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2d3748;
    }

    .smart-score {
      font-size: 1.25rem;
      font-weight: 700;
    }

    /* Hasil Layanan Item */
    .hasil-layanan-wrapper {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .hasil-layanan-item {
      padding: 0.75rem;
      background: #f7fafc;
      border-radius: 8px;
      border-left: 3px solid #4a5568;
    }

    /* Alternatif Card */
    .alternatif-card {
      background: #fff;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      overflow: hidden;
    }

    .alternatif-card-header {
      padding: 1.25rem;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .alternatif-stats {
      display: flex;
      gap: 0.5rem;
    }

    .alternatif-card-body {
      padding: 1.5rem;
    }

    /* Action Buttons */
    .action-buttons-modern {
      display: flex;
      gap: 0.5rem;
    }

    .btn-modern-action {
      width: 40px;
      height: 40px;
      border-radius: 10px;
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

    .btn-modern-delete {
      background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(229, 62, 62, 0.3);
    }

    .btn-modern-delete:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(229, 62, 62, 0.4);
    }

    /* Empty State */
    .empty-state-modern {
      padding: 4rem 2rem;
      text-align: center;
    }

    .empty-state-content {
      text-align: center;
    }

    .empty-state-icon {
      color: #cbd5e0;
      margin-bottom: 1.5rem;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .empty-state-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 0.5rem;
    }

    .empty-state-text {
      color: #718096;
      font-size: 1rem;
      margin-bottom: 1.5rem;
    }

    .btn-modern-success {
      background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(56, 161, 105, 0.3);
      text-decoration: none;
      display: inline-block;
    }

    .btn-modern-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(56, 161, 105, 0.4);
    }

    .hover-lift {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
      transform: translateY(-4px);
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

    /* Responsive */
    @media (max-width: 768px) {
      .tabs-header {
        flex-direction: column;
      }

      .tab-actions {
        width: 100%;
        text-align: center;
      }

      .action-buttons-modern {
        flex-direction: column;
      }

      .btn-modern-action {
        width: 100%;
      }
    }
  </style>

  <!-- Custom Modern Scripts -->
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      easing: 'ease-out-cubic',
      once: true,
      offset: 50
    });

    // Switch View
    function switchView(view) {
      window.location.href = 'index.php?controller=hasil&action=index&view=' + view;
    }

    // Confirm Delete All
    function confirmDeleteAll() {
      Swal.fire({
        title: 'Hapus Semua Hasil?',
        text: 'Semua data hasil perhitungan SMART akan dihapus dan tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#4a5568',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal',
        showClass: {
          popup: 'swal2-show',
          backdrop: 'swal2-backdrop-show',
          icon: 'swal2-icon-show'
        },
        hideClass: {
          popup: 'swal2-hide',
          backdrop: 'swal2-backdrop-hide',
          icon: 'swal2-icon-hide'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php?controller=hasil&action=deleteAll';
        }
      });
    }

    // Confirm Delete Responden
    function confirmDeleteResponden(id_responden) {
      Swal.fire({
        title: 'Hapus Hasil Responden?',
        text: 'Hasil perhitungan untuk responden ini akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#4a5568',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        showClass: {
          popup: 'swal2-show',
          backdrop: 'swal2-backdrop-show',
          icon: 'swal2-icon-show'
        },
        hideClass: {
          popup: 'swal2-hide',
          backdrop: 'swal2-backdrop-hide',
          icon: 'swal2-icon-hide'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php?controller=hasil&action=deleteResponden&id_responden=' + id_responden;
        }
      });
    }

    // Show Dialog function
    function showDialog(message, type = 'error') {
      if (type === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: message,
          confirmButtonText: 'Tutup',
          confirmButtonColor: '#4a5568',
          showClass: {
            popup: 'swal2-show',
            backdrop: 'swal2-backdrop-show',
            icon: 'swal2-icon-show'
          },
          hideClass: {
            popup: 'swal2-hide',
            backdrop: 'swal2-backdrop-hide',
            icon: 'swal2-icon-hide'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload();
          }
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Peringatan',
          text: message,
          confirmButtonText: 'OK',
          confirmButtonColor: '#4a5568',
          timer: 5000,
          timerProgressBar: true,
          showClass: {
            popup: 'swal2-show',
            backdrop: 'swal2-backdrop-show',
            icon: 'swal2-icon-show'
          },
          hideClass: {
            popup: 'swal2-hide',
            backdrop: 'swal2-backdrop-hide',
            icon: 'swal2-icon-hide'
          }
        });
      }
    }

    // Check for PHP session messages
    <?php if (isset($_SESSION['error'])): ?>
      showDialog("<?= addslashes($_SESSION['error']) ?>", 'error');
      <?php unset($_SESSION['error']); endif;
    ?>

    <?php if (isset($_SESSION['success'])): ?>
      showDialog("<?= addslashes($_SESSION['success']) ?>", 'success');
      <?php unset($_SESSION['success']); endif;
    ?>
  </script>

</body>

</html>
