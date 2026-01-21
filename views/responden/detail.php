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
                        <i class="fas fa-user fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Detail Responden</h3>
                        <p class="text-muted mb-0">Informasi lengkap data responden</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=responden&action=index"
                       class="btn btn-modern-secondary btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Profile Card -->
                <div class="card-modern-profile" data-aos="fade-up" data-aos-delay="200">
                  <div class="card-modern-profile-header">
                    <div class="profile-header-content">
                      <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                      </div>
                      <div class="profile-header-text">
                        <h4 class="profile-header-title">
                          <?= htmlspecialchars($data['responden']['nama_lengkap']) ?>
                        </h4>
                        <p class="profile-header-subtitle">Responden DISDUKCAPIL</p>
                      </div>
                    </div>
                  </div>

                  <div class="card-modern-profile-body">
                    <div class="row">
                      <!-- Info Responden -->
                      <div class="col-md-6">
                        <div class="info-section">
                          <h5 class="info-section-title">
                            <i class="fas fa-user-circle mr-2"></i>Informasi Pribadi
                          </h5>
                          <div class="info-details">
                            <div class="info-detail-item">
                              <div class="info-detail-label">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                              </div>
                              <div class="info-detail-value">
                                <?= htmlspecialchars($data['responden']['nama_lengkap']) ?>
                              </div>
                            </div>
                            <div class="info-detail-item">
                              <div class="info-detail-label">
                                <i class="fas fa-birthday-cake"></i>
                                Usia
                              </div>
                              <div class="info-detail-value">
                                <?= $data['responden']['usia'] ?> Tahun
                              </div>
                            </div>
                            <div class="info-detail-item">
                              <div class="info-detail-label">
                                <i class="fas fa-briefcase"></i>
                                Pekerjaan
                              </div>
                              <div class="info-detail-value">
                                <span class="badge-modern badge-modern-primary">
                                  <?= htmlspecialchars($data['responden']['pekerjaan']) ?>
                                </span>
                              </div>
                            </div>
                            <div class="info-detail-item">
                              <div class="info-detail-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tanggal Isi
                              </div>
                              <div class="info-detail-value">
                                <?= date('d/m/Y H:i', strtotime($data['responden']['tanggal_isi'])) ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Statistik Penilaian -->
                      <div class="col-md-6">
                        <div class="info-section">
                          <h5 class="info-section-title">
                            <i class="fas fa-chart-bar mr-2"></i>Statistik Penilaian
                          </h5>
                          <div class="stats-grid">
                            <div class="stat-card">
                              <div class="stat-icon">
                                <i class="fas fa-star"></i>
                              </div>
                              <div class="stat-content">
                                <h6 class="stat-title">Total Penilaian</h6>
                                <h3 class="stat-value"><?= $data['total_penilaian'] ?? 0 ?></h3>
                                <p class="stat-text">Layanan dinilai</p>
                              </div>
                            </div>
                            <div class="stat-card">
                              <div class="stat-icon stat-icon-success">
                                <i class="fas fa-thumbs-up"></i>
                              </div>
                              <div class="stat-content">
                                <h6 class="stat-title">Rata-rata Nilai</h6>
                                <h3 class="stat-value"><?= $data['avg_nilai'] ?? 0 ?></h3>
                                <p class="stat-text">Utility score</p>
                              </div>
                            </div>
                          </div>

                          <!-- List Penilaian -->
                          <?php if (!empty($data['penilaians'])): ?>
                            <div class="penilaian-list mt-4">
                              <h6 class="penilaian-list-title">Riwayat Penilaian</h6>
                              <div class="penilaian-items">
                                <?php foreach ($data['penilaians'] as $penilaian): ?>
                                  <div class="penilaian-item">
                                    <div class="penilaian-item-header">
                                      <span class="layanan-badge">
                                        <i class="fas fa-concierge-bell mr-1"></i>
                                        <?= htmlspecialchars($penilaian['nama_layanan']) ?>
                                      </span>
                                    </div>
                                    <div class="penilaian-item-body">
                                      <div class="penilaian-detail">
                                        <small class="text-muted">Kriteria:</small>
                                        <span><?= htmlspecialchars($penilaian['nama_kriteria']) ?></span>
                                      </div>
                                      <div class="penilaian-detail">
                                        <small class="text-muted">Penilaian:</small>
                                        <span><?= htmlspecialchars($penilaian['nama_pilihan']) ?></span>
                                        <span class="nilai-badge"><?= number_format($penilaian['nilai_utility'], 1) ?>%</span>
                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          <?php else: ?>
                            <div class="no-penilaan">
                              <i class="fas fa-inbox fa-3x"></i>
                              <p>Belum ada penilaian</p>
                            </div>
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
      </div>
    </div>
  </div>
  <?php include 'template/script.php'; ?>

  <!-- Custom Modern CSS -->
  <style>
    /* Modern Profile Card */
    .card-modern-profile {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .card-modern-profile-header {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      padding: 3rem 2rem;
      color: #fff;
    }

    .profile-header-content {
      display: flex;
      align-items: center;
      gap: 2rem;
    }

    .profile-avatar {
      width: 120px;
      height: 120px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      animation: pulse 2s ease-in-out infinite;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .profile-header-text h4 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .profile-header-subtitle {
      opacity: 0.9;
      margin: 0;
      font-size: 1.1rem;
    }

    .card-modern-profile-body {
      padding: 2.5rem;
    }

    /* Info Section */
    .info-section {
      background: #f7fafc;
      border-radius: 16px;
      padding: 1.5rem;
      height: 100%;
      border: 2px solid #e2e8f0;
    }

    .info-section-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #e2e8f0;
    }

    .info-details {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .info-detail-item {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .info-detail-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: #718096;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .info-detail-value {
      font-size: 1.1rem;
      font-weight: 600;
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

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .stat-card {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      border: 2px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.5rem;
      flex-shrink: 0;
    }

    .stat-icon-success {
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
    }

    .stat-content h6 {
      font-size: 0.75rem;
      font-weight: 600;
      color: #718096;
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .stat-content h3 {
      font-size: 2rem;
      font-weight: 700;
      color: #2d3748;
      margin: 0.25rem 0;
    }

    .stat-content p {
      font-size: 0.75rem;
      color: #a0aec0;
      margin: 0;
    }

    /* Penilaian List */
    .penilaian-list-title {
      font-size: 1rem;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 1rem;
    }

    .penilaian-items {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      max-height: 400px;
      overflow-y: auto;
      padding-right: 0.5rem;
    }

    .penilaian-item {
      background: #fff;
      border-radius: 12px;
      padding: 1rem;
      border: 2px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .penilaian-item:hover {
      border-color: #4a5568;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.1);
    }

    .penilaian-item-header {
      margin-bottom: 0.75rem;
    }

    .layanan-badge {
      display: inline-block;
      padding: 0.35rem 0.75rem;
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      color: #fff;
      border-radius: 8px;
      font-size: 0.875rem;
      font-weight: 600;
    }

    .penilaian-item-body {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .penilaian-detail {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
    }

    .penilaian-detail small {
      min-width: 70px;
    }

    .penilaian-detail span:not(.nilai-badge) {
      font-weight: 600;
      color: #2d3748;
    }

    .nilai-badge {
      margin-left: auto;
      padding: 0.25rem 0.75rem;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 700;
    }

    /* No Penilaan */
    .no-penilaan {
      text-align: center;
      padding: 2rem;
      color: #cbd5e0;
    }

    .no-penilaan i {
      margin-bottom: 1rem;
    }

    .no-penilaan p {
      font-size: 1rem;
      color: #718096;
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

    /* Scrollbar */
    .penilaian-items::-webkit-scrollbar {
      width: 6px;
    }

    .penilaian-items::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .penilaian-items::-webkit-scrollbar-thumb {
      background: #4a5568;
      border-radius: 10px;
    }

    .penilaian-items::-webkit-scrollbar-thumb:hover {
      background: #2d3748;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .profile-header-content {
        flex-direction: column;
        text-align: center;
      }

      .profile-avatar {
        width: 100px;
        height: 100px;
        font-size: 3rem;
      }

      .profile-header-text h4 {
        font-size: 1.5rem;
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .card-modern-profile-body {
        padding: 1.5rem;
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
