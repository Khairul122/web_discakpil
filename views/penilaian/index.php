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
                        <i class="fas fa-clipboard-check fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Kelola Penilaian</h3>
                        <p class="text-muted mb-0">Manajemen Data Penilaian Layanan DISDUKCAPIL Kota Padang</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=penilaian&action=formPenilaian"
                       class="btn btn-modern-success btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-star mr-2"></i>Form Penilaian
                    </a>
                  </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                  <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-modern card-modern-primary">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Total Penilaian</h4>
                          <h2 class="card-modern-value"><?= $data['total'] ?? 0 ?></h2>
                          <p class="card-modern-text">Data penilaian</p>
                        </div>
                        <div class="card-modern-chart">
                          <div class="progress-chart">
                            <svg viewBox="0 0 100 100">
                              <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                              <circle cx="50" cy="50" r="45" fill="none" stroke="#fff" stroke-width="8"
                                      stroke-dasharray="283" stroke-dashoffset="0" stroke-linecap="round"
                                      class="progress-circle"/>
                            </svg>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-modern card-modern-success">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-users"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Layanan Dinilai</h4>
                          <h2 class="card-modern-value"><?= count($data['alternatifs'] ?? []) ?></h2>
                          <p class="card-modern-text">Layanan aktif</p>
                        </div>
                        <div class="card-modern-chart">
                          <div class="progress-chart">
                            <svg viewBox="0 0 100 100">
                              <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                              <circle cx="50" cy="50" r="45" fill="none" stroke="#fff" stroke-width="8"
                                      stroke-dasharray="283" stroke-dashoffset="70" stroke-linecap="round"
                                      class="progress-circle"/>
                            </svg>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-modern card-modern-info">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Rata-rata</h4>
                          <h2 class="card-modern-value"><?= $data['total'] > 0 ? round($data['total'] / max(count($data['alternatifs'] ?? []), 1), 1) : 0 ?></h2>
                          <p class="card-modern-text">Penilaian per layanan</p>
                        </div>
                        <div class="card-modern-chart">
                          <div class="progress-chart">
                            <svg viewBox="0 0 100 100">
                              <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8"/>
                              <circle cx="50" cy="50" r="45" fill="none" stroke="#fff" stroke-width="8"
                                      stroke-dasharray="283" stroke-dashoffset="141" stroke-linecap="round"
                                      class="progress-circle"/>
                            </svg>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mb-4" data-aos="fade-up" data-aos-delay="300">
                  <div class="col-12">
                    <div class="action-buttons-wrapper">
                      <button onclick="calculateAllSMART()"
                              class="btn btn-modern-calculate btn-lg mr-2">
                        <i class="fas fa-calculator mr-2"></i>Hitung SMART Semua
                      </button>
                      <a href="index.php?controller=hasil&action=index"
                         class="btn btn-modern-results btn-lg">
                        <i class="fas fa-chart-bar mr-2"></i>Lihat Hasil Perhitungan
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Search & Filter -->
                <div class="card-modern-search mb-4" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-modern-search-body">
                    <form method="GET" action="index.php?controller=penilaian&action=index">
                      <div class="row align-items-center">
                        <div class="col-md-5">
                          <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text"
                                   name="keyword"
                                   class="form-control search-input-modern"
                                   placeholder="Cari penilaian..."
                                   value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
                            <?php if (!empty($data['keyword'])): ?>
                              <a href="index.php?controller=penilaian&action=index" class="search-clear">
                                <i class="fas fa-times"></i>
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <select name="id_alternatif" class="form-control filter-select-modern">
                            <option value="">Semua Layanan</option>
                            <?php foreach ($data['alternatifs'] as $alternatif): ?>
                              <option value="<?= $alternatif['id_alternatif'] ?>"
                                      <?= $data['filter_alternatif'] == $alternatif['id_alternatif'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($alternatif['nama_layanan']) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-modern-search btn-block">
                            <i class="fas fa-filter mr-2"></i>Filter
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <!-- Modern Table -->
                <div class="card-modern-table" data-aos="fade-up" data-aos-delay="400">
                  <div class="card-modern-table-body">
                    <div class="table-responsive-modern">
                      <table class="table-modern">
                        <thead>
                          <tr>
                            <th width="10%">No</th>
                            <th width="60%">Responden</th>
                            <th width="30%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($data['penilaians']) && count($data['penilaians']) > 0): ?>
                            <?php $no = 1; foreach ($data['penilaians'] as $responden): ?>
                            <tr class="table-row-modern" data-aos="fade-in" data-aos-delay="<?= $no * 50 ?>">
                              <td>
                                <span class="row-number"><?= $no++ ?></span>
                              </td>
                              <td>
                                <div class="responden-info">
                                  <strong><?= htmlspecialchars($responden['nama_responden']) ?></strong>
                                  <small class="text-muted d-block">
                                    <i class="fas fa-birthday-cake mr-1"></i><?= $responden['usia'] ?> tahun
                                    <span class="mx-1">|</span>
                                    <i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($responden['pekerjaan']) ?>
                                  </small>
                                </div>
                              </td>
                              <td>
                                <div class="action-buttons-modern">
                                  <a href="index.php?controller=penilaian&action=detailSmart&id_responden=<?= $responden['id_responden'] ?>"
                                     class="btn-modern-action btn-modern-view"
                                     title="Lihat Analisis SMART">
                                    <i class="fas fa-chart-line"></i>
                                  </a>
                                  <button onclick="confirmDeleteResponden(<?= $responden['id_responden'] ?>)"
                                          class="btn-modern-action btn-modern-delete"
                                          title="Hapus Semua Penilaian">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr class="empty-state-modern">
                              <td colspan="3" class="text-center">
                                <div class="empty-state-content">
                                  <div class="empty-state-icon">
                                    <i class="fas fa-clipboard fa-4x"></i>
                                  </div>
                                  <h4 class="empty-state-title">Belum ada data penilaian</h4>
                                  <p class="empty-state-text">Mulai dengan mengisi form penilaian layanan</p>
                                  <a href="index.php?controller=penilaian&action=formPenilaian"
                                     class="btn btn-modern-success btn-lg">
                                    <i class="fas fa-star mr-2"></i>Isi Form Penilaian
                                  </a>
                                </div>
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

  <!-- Custom Modern CSS -->
  <style>
    /* Modern Cards - Formal Gray Theme */
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

    .card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .card-modern-primary {
      --card-bg-1: #4a5568;
      --card-bg-2: #2d3748;
      --card-accent-1: #4a5568;
      --card-accent-2: #2d3748;
    }

    .card-modern-success {
      --card-bg-1: #718096;
      --card-bg-2: #4a5568;
      --card-accent-1: #718096;
      --card-accent-2: #4a5568;
    }

    .card-modern-info {
      --card-bg-1: #a0aec0;
      --card-bg-2: #718096;
      --card-accent-1: #a0aec0;
      --card-accent-2: #718096;
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
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1;
      margin-bottom: 0.5rem;
    }

    .card-modern-text {
      font-size: 0.75rem;
      opacity: 0.8;
      margin-bottom: 0;
    }

    .card-modern-chart {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      width: 80px;
      height: 80px;
    }

    .progress-chart svg {
      width: 100%;
      height: 100%;
      animation: rotate 2s linear infinite;
    }

    .progress-circle {
      transform: rotate(-90deg);
      transform-origin: 50% 50%;
    }

    @keyframes rotate {
      from { stroke-dashoffset: 283; }
      to { stroke-dashoffset: 0; }
    }

    /* Modern Search */
    .card-modern-search {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-modern-search-body {
      padding: 1.5rem;
    }

    .search-input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .search-icon {
      position: absolute;
      left: 1rem;
      color: #a0aec0;
      font-size: 1.1rem;
      z-index: 10;
    }

    .search-input-modern {
      padding: 0.875rem 3rem 0.875rem 3rem !important;
      border: 2px solid #e2e8f0 !important;
      border-radius: 12px !important;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: #f7fafc;
    }

    .search-input-modern:focus {
      border-color: #4a5568 !important;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
    }

    .search-clear {
      position: absolute;
      right: 1rem;
      color: #a0aec0;
      cursor: pointer;
      transition: all 0.2s ease;
      z-index: 10;
    }

    .search-clear:hover {
      color: #e53e3e;
    }

    .filter-select-modern {
      padding: 0.875rem 1rem;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 0.95rem;
      background: #f7fafc;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .filter-select-modern:focus {
      border-color: #4a5568;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
      outline: none;
    }

    .btn-modern-search {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border: none;
      color: #fff;
      padding: 0.875rem;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .btn-modern-search:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(74, 85, 104, 0.3);
    }

    /* Modern Table */
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
      animation: slideIn 0.3s ease forwards;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-10px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .table-row-modern:hover {
      background: linear-gradient(90deg, rgba(74, 85, 104, 0.05) 0%, rgba(45, 55, 72, 0.05) 100%);
      transform: scale(1.01);
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

    .responden-info strong {
      color: #2d3748;
      font-weight: 600;
    }

    .layanan-info {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .badge-modern {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.875rem;
      width: fit-content;
    }

    .badge-modern-primary {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
    }

    .kriteria-info {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .badge-kriteria {
      display: inline-block;
      padding: 0.35rem 0.75rem;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.8rem;
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      color: #fff;
      width: fit-content;
    }

    .penilaian-text {
      font-weight: 600;
      color: #2d3748;
    }

    .utility-value {
      display: flex;
      align-items: baseline;
      gap: 0.25rem;
    }

    .utility-number {
      font-size: 1.5rem;
      font-weight: 700;
      color: #4a5568;
    }

    .utility-percent {
      font-size: 0.875rem;
      color: #718096;
    }

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
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(113, 128, 150, 0.3);
    }

    .btn-modern-view:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(113, 128, 150, 0.4);
    }

    .btn-modern-delete {
      background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(160, 174, 192, 0.3);
    }

    .btn-modern-delete:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 16px rgba(160, 174, 192, 0.4);
    }

    /* Empty State */
    .empty-state-modern td {
      padding: 3rem !important;
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

    /* Modern Buttons */
    .btn-modern-primary {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(74, 85, 104, 0.3);
    }

    .btn-modern-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(74, 85, 104, 0.4);
    }

    .btn-modern-success {
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      border: none;
      color: #fff;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(113, 128, 150, 0.3);
    }

    .btn-modern-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(113, 128, 150, 0.4);
    }

    .btn-modern-calculate {
      background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
      border: none;
      color: #fff;
      padding: 1rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(56, 161, 105, 0.3);
    }

    .btn-modern-calculate:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(56, 161, 105, 0.4);
    }

    .btn-modern-results {
      background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
      border: none;
      color: #fff;
      padding: 1rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(49, 130, 206, 0.3);
    }

    .btn-modern-results:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(49, 130, 206, 0.4);
    }

    .action-buttons-wrapper {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
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
      .card-modern-chart {
        display: none;
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

    // Confirm delete using SweetAlert2
    function confirmDelete(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data penilaian akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#4a5568',
        confirmButtonText: 'Ya, hapus!',
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
          window.location.href = 'index.php?controller=penilaian&action=delete&id=' + id;
        }
      });
    }

    // Calculate All SMART
    function calculateAllSMART() {
      Swal.fire({
        title: 'Hitung SMART Semua Responden?',
        text: 'Sistem akan menghitung nilai SMART untuk semua responden dan menyimpannya ke tabel hasil_akhir. Proses ini mungkin memerlukan waktu beberapa saat.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#38a169',
        cancelButtonColor: '#4a5568',
        confirmButtonText: '<i class="fas fa-calculator mr-2"></i>Ya, Hitung Semua!',
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
          // Show loading
          Swal.fire({
            title: 'Menghitung SMART...',
            text: 'Mohon tunggu, sistem sedang memproses data semua responden',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            willOpen: () => {
              Swal.showLoading();
            }
          });

          // Ajax request
          fetch('index.php?controller=penilaian&action=calculateAllSMART', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Check if there are warnings
              if (data.has_warnings && data.errors) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Perhitungan Selesai dengan Warning',
                  html: `
                    <p>Hasil SMART berhasil dihitung:</p>
                    <ul style="text-align: left; display: inline-block;">
                      <li><strong>${data.total_responden}</strong> Responden berhasil</li>
                      <li><strong>${data.total_hasil}</strong> Hasil Perhitungan</li>
                    </ul>
                    <br><br>
                    <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-top: 10px;">
                      <strong>Warning:</strong>
                      <p style="margin: 5px 0;">${data.warning_message}</p>
                      <details style="margin-top: 10px;">
                        <summary style="cursor: pointer; color: #856404;">Lihat Detail Error</summary>
                        <ul style="text-align: left; margin-top: 10px; font-size: 0.85rem;">
                          ${data.errors.map(err => `<li>${err}</li>`).join('')}
                        </ul>
                      </details>
                    </div>
                  `,
                  confirmButtonText: 'Lihat Hasil',
                  confirmButtonColor: '#d69e2e',
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
                    window.location.href = 'index.php?controller=hasil&action=index';
                  }
                });
              } else {
                // Full success
                Swal.fire({
                  icon: 'success',
                  title: 'Perhitungan Berhasil!',
                  html: `
                    <p>Hasil SMART berhasil dihitung dan disimpan untuk:</p>
                    <ul style="text-align: left; display: inline-block;">
                      <li><strong>${data.total_responden}</strong> Responden</li>
                      <li><strong>${data.total_hasil}</strong> Hasil Perhitungan</li>
                    </ul>
                    <br><br>
                    <p class="text-success">${data.message}</p>
                  `,
                  confirmButtonText: 'Lihat Hasil',
                  confirmButtonColor: '#38a169',
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
                    window.location.href = 'index.php?controller=hasil&action=index';
                  }
                });
              }
            } else {
              // Failed
              let errorHtml = `<p>${data.message || 'Terjadi kesalahan saat menghitung SMART'}</p>`;

              if (data.errors && data.errors.length > 0) {
                errorHtml += `
                  <details style="margin-top: 15px;">
                    <summary style="cursor: pointer; color: #e53e3e;">Lihat Detail Error</summary>
                    <ul style="text-align: left; margin-top: 10px; font-size: 0.85rem;">
                      ${data.errors.map(err => `<li>${err}</li>`).join('')}
                    </ul>
                  </details>
                `;
              }

              if (data.debug_info) {
                errorHtml += `
                  <details style="margin-top: 15px;">
                    <summary style="cursor: pointer; color: #e53e3e;">Debug Info</summary>
                    <div style="text-align: left; margin-top: 10px; font-size: 0.75rem; background: #f7fafc; padding: 10px; border-radius: 5px;">
                      <p><strong>File:</strong> ${data.debug_info.file}</p>
                      <p><strong>Line:</strong> ${data.debug_info.line}</p>
                      <p><strong>Trace:</strong> <pre style="white-space: pre-wrap;">${data.debug_info.trace}</pre></p>
                    </div>
                  </details>
                `;
              }

              Swal.fire({
                icon: 'error',
                title: 'Perhitungan Gagal!',
                html: errorHtml,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#e53e3e',
                width: '600px'
              });
            }
          })
          .catch(error => {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi Kesalahan!',
              text: 'Gagal terhubung ke server. Silakan coba lagi.',
              confirmButtonText: 'Tutup',
              confirmButtonColor: '#e53e3e'
            });
          });
        }
      });
    }

    function confirmDeleteResponden(id_responden) {
      Swal.fire({
        title: 'Hapus Semua Penilaian?',
        text: 'Semua data penilaian dari responden ini akan dihapus dan tidak dapat dikembalikan!',
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
          window.location.href = 'index.php?controller=responden&action=delete&id=' + id_responden;
        }
      });
    }


    // Show Dialog function using SweetAlert2
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

    // Check for PHP session messages and show dialog
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
