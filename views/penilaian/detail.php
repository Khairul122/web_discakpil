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
                        <i class="fas fa-star fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Detail Penilaian</h3>
                        <p class="text-muted mb-0">Informasi lengkap data penilaian</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=penilaian&action=index"
                       class="btn btn-modern-secondary btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Detail Cards -->
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                  <!-- Responden Info -->
                  <div class="col-md-6">
                    <div class="card-modern-detail">
                      <div class="card-modern-detail-header">
                        <div class="detail-header-icon">
                          <i class="fas fa-user"></i>
                        </div>
                        <h4 class="detail-header-title">Responden</h4>
                      </div>
                      <div class="card-modern-detail-body">
                        <div class="detail-info-grid">
                          <div class="detail-info-item">
                            <div class="detail-info-label">Nama Lengkap</div>
                            <div class="detail-info-value">
                              <strong><?= htmlspecialchars($data['penilaian']['nama_responden']) ?></strong>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Layanan Info -->
                  <div class="col-md-6">
                    <div class="card-modern-detail card-modern-detail-layanan">
                      <div class="card-modern-detail-header">
                        <div class="detail-header-icon">
                          <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4 class="detail-header-title">Layanan</h4>
                      </div>
                      <div class="card-modern-detail-body">
                        <div class="detail-info-grid">
                          <div class="detail-info-item">
                            <div class="detail-info-label">Nama Layanan</div>
                            <div class="detail-info-value">
                              <span class="badge-modern badge-modern-primary">
                                <i class="fas fa-concierge-bell mr-1"></i>
                                <?= htmlspecialchars($data['penilaian']['nama_layanan']) ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Kriteria & Penilaian Detail -->
                <div class="card-modern-detail" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-modern-detail-header">
                    <div class="detail-header-icon">
                      <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h4 class="detail-header-title">Detail Penilaian</h4>
                  </div>
                  <div class="card-modern-detail-body">
                    <div class="penilaian-detail-grid">
                      <!-- Kriteria -->
                      <div class="penilaian-detail-section">
                        <h6 class="penilaian-section-title">
                          <i class="fas fa-list-alt mr-2"></i>Kriteria Penilaian
                        </h6>
                        <div class="kriteria-detail-card">
                          <div class="kriteria-badge">
                            <span class="kriteria-code"><?= htmlspecialchars($data['penilaian']['kode_kriteria']) ?></span>
                            <span class="kriteria-name"><?= htmlspecialchars($data['penilaian']['nama_kriteria']) ?></span>
                          </div>
                        </div>
                      </div>

                      <!-- Pilihan Penilaian -->
                      <div class="penilaian-detail-section">
                        <h6 class="penilaian-section-title">
                          <i class="fas fa-star mr-2"></i>Pilihan Penilaian
                        </h6>
                        <div class="pilihan-detail-card">
                          <div class="pilihan-text">
                            <?= htmlspecialchars($data['penilaian']['nama_pilihan']) ?>
                          </div>
                        </div>
                      </div>

                      <!-- Nilai Utility -->
                      <div class="penilaian-detail-section">
                        <h6 class="penilaian-section-title">
                          <i class="fas fa-chart-line mr-2"></i>Nilai Utility
                        </h6>
                        <div class="utility-detail-card">
                          <div class="utility-display">
                            <div class="utility-number"><?= number_format($data['penilaian']['nilai_utility'], 1) ?></div>
                            <div class="utility-percent">%</div>
                          </div>
                          <div class="utility-bar-wrapper">
                            <div class="utility-bar">
                              <div class="utility-fill" style="width: <?= $data['penilaian']['nilai_utility'] ?>%"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Utility Interpretation -->
                    <div class="utility-interpretation mt-4">
                      <?php
                        $nilai = $data['penilaian']['nilai_utility'];
                        $interpretation = '';
                        $color = '';
                        if ($nilai >= 80) {
                          $interpretation = 'Sangat Baik';
                          $color = '#38a169';
                        } elseif ($nilai >= 60) {
                          $interpretation = 'Baik';
                          $color = '#4a5568';
                        } elseif ($nilai >= 40) {
                          $interpretation = 'Cukup';
                          $color = '#d69e2e';
                        } elseif ($nilai >= 20) {
                          $interpretation = 'Kurang';
                          $color = '#dd6b20';
                        } else {
                          $interpretation = 'Sangat Kurang';
                          $color = '#e53e3e';
                        }
                      ?>
                      <div class="interpretation-badge" style="background: <?= $color ?>;">
                        <i class="fas fa-info-circle mr-2"></i>
                        Interpretasi: <strong><?= $interpretation ?></strong>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Info Card -->
                <div class="card-modern-info" data-aos="fade-up" data-aos-delay="400">
                  <div class="card-modern-info-body">
                    <div class="info-header">
                      <div class="info-icon">
                        <i class="fas fa-lightbulb"></i>
                      </div>
                      <div class="info-title">
                        <h4>Informasi Penilaian</h4>
                        <p>Detail sistem penilaian SMART</p>
                      </div>
                    </div>
                    <div class="info-list">
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Metode SMART</strong>
                          <p>Penilaian menggunakan metode Simple Multi-Attribute Rating Technique</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Nilai Utility</strong>
                          <p>Nilai 0-100 yang merepresentasikan tingkat kepuasan responden</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Interpretasi</strong>
                          <p>Nilai dikelompokkan menjadi: Sangat Kurang, Kurang, Cukup, Baik, Sangat Baik</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Penggunaan</strong>
                          <p>Penilaian digunakan untuk perankingan dan analisis kualitas layanan</p>
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

  <!-- Custom Modern CSS -->
  <style>
    /* Modern Detail Card */
    .card-modern-detail {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08);
      margin-bottom: 1.5rem;
    }

    .card-modern-detail-layanan {
      border: 1px solid rgba(113, 128, 150, 0.2);
    }

    .card-modern-detail-header {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      padding: 1.5rem;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .detail-header-icon {
      width: 50px;
      height: 50px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .detail-header-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 0;
    }

    .card-modern-detail-body {
      padding: 1.5rem;
    }

    .detail-info-grid {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .detail-info-item {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .detail-info-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: #718096;
    }

    .detail-info-value {
      font-size: 1rem;
      color: #2d3748;
    }

    .badge-modern {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .badge-modern-primary {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
    }

    /* Penilaian Detail Grid */
    .penilaian-detail-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .penilaian-detail-section {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .penilaian-section-title {
      font-size: 1rem;
      font-weight: 700;
      color: #2d3748;
      margin: 0;
      display: flex;
      align-items: center;
    }

    .kriteria-detail-card {
      background: linear-gradient(135deg, #f7fafc 0%, #ffffff 100%);
      border-radius: 12px;
      padding: 1.5rem;
      border: 2px solid #e2e8f0;
    }

    .kriteria-badge {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .kriteria-code {
      padding: 0.5rem 1rem;
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      color: #fff;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.875rem;
    }

    .kriteria-name {
      font-weight: 600;
      color: #2d3748;
      font-size: 1rem;
    }

    .pilihan-detail-card {
      background: linear-gradient(135deg, #f7fafc 0%, #ffffff 100%);
      border-radius: 12px;
      padding: 1.5rem;
      border: 2px solid #e2e8f0;
    }

    .pilihan-text {
      font-size: 1.1rem;
      font-weight: 600;
      color: #2d3748;
    }

    .utility-detail-card {
      background: linear-gradient(135deg, #f7fafc 0%, #ffffff 100%);
      border-radius: 12px;
      padding: 1.5rem;
      border: 2px solid #e2e8f0;
    }

    .utility-display {
      display: flex;
      align-items: baseline;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }

    .utility-number {
      font-size: 3rem;
      font-weight: 700;
      color: #4a5568;
    }

    .utility-percent {
      font-size: 1.5rem;
      color: #718096;
    }

    .utility-bar-wrapper {
      padding: 0.5rem 0;
    }

    .utility-bar {
      height: 12px;
      background: #e2e8f0;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
    }

    .utility-fill {
      height: 100%;
      background: linear-gradient(90deg, #4a5568 0%, #718096 100%);
      border-radius: 10px;
      transition: width 0.5s ease;
      position: relative;
    }

    .utility-fill::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    .utility-interpretation {
      display: flex;
      justify-content: center;
    }

    .interpretation-badge {
      padding: 1rem 2rem;
      border-radius: 12px;
      color: #fff;
      font-size: 1.1rem;
      font-weight: 600;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Modern Info Card */
    .card-modern-info {
      background: linear-gradient(135deg, #f6f8fb 0%, #ffffff 100%);
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-modern-info-body {
      padding: 2rem;
    }

    .info-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .info-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.5rem;
      box-shadow: 0 4px 16px rgba(74, 85, 104, 0.3);
    }

    .info-title h4 {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
      color: #2d3748;
    }

    .info-title p {
      margin: 0;
      color: #718096;
      font-size: 0.875rem;
    }

    .info-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 1rem;
      background: #fff;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .info-item:hover {
      transform: translateX(8px);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .info-item-icon {
      flex-shrink: 0;
      width: 32px;
      height: 32px;
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 0.875rem;
    }

    .info-item-content strong {
      display: block;
      color: #2d3748;
      margin-bottom: 0.25rem;
      font-size: 0.95rem;
    }

    .info-item-content p {
      margin: 0;
      color: #718096;
      font-size: 0.875rem;
    }

    /* Modern Buttons */
    .btn-modern-secondary {
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      border: none;
      color: #fff;
      padding: 0.875rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(113, 128, 150, 0.3);
    }

    .btn-modern-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(113, 128, 150, 0.4);
    }

    .hover-lift {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
      transform: translateY(-4px);
    }

    /* Animated Title */
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
      .penilaian-detail-grid {
        grid-template-columns: 1fr;
      }

      .utility-number {
        font-size: 2.5rem;
      }

      .card-modern-detail-body {
        padding: 1rem;
      }

      .card-modern-info-body {
        padding: 1.5rem;
      }

      .info-item {
        flex-direction: column;
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
  </script>

</body>

</html>
