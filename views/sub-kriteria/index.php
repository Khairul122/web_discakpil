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
                        <i class="fas fa-layer-group fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Kelola Sub Kriteria</h3>
                        <p class="text-muted mb-0">Manajemen Data Sub Kriteria Penilaian DISDUKCAPIL Kota Padang</p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=subKriteria&action=create"
                       class="btn btn-modern-primary btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-plus mr-2"></i>Tambah Sub Kriteria
                    </a>
                  </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-modern card-modern-primary">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Total Sub Kriteria</h4>
                          <h2 class="card-modern-value"><?= $data['total'] ?? 0 ?></h2>
                          <p class="card-modern-text">Pilihan penilaian</p>
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

                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-modern card-modern-success">
                      <div class="card-modern-body">
                        <div class="card-modern-icon">
                          <i class="fas fa-list-ol"></i>
                        </div>
                        <div class="card-modern-content">
                          <h4 class="card-modern-title">Total Kriteria</h4>
                          <h2 class="card-modern-value"><?= count($data['kriterias'] ?? []) ?></h2>
                          <p class="card-modern-text">Kriteria penilaian</p>
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
                </div>

                <!-- Search & Filter -->
                <div class="card-modern-search mb-4" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-modern-search-body">
                    <form method="GET" action="index.php?controller=subKriteria&action=index">
                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text"
                                   name="keyword"
                                   class="form-control search-input-modern"
                                   placeholder="Cari sub kriteria..."
                                   value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
                            <?php if (!empty($data['keyword'])): ?>
                              <a href="index.php?controller=subKriteria&action=index" class="search-clear">
                                <i class="fas fa-times"></i>
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <select name="id_kriteria" class="form-control filter-select-modern">
                            <option value="">Semua Kriteria</option>
                            <?php foreach ($data['kriterias'] as $kriteria): ?>
                              <option value="<?= $kriteria['id_kriteria'] ?>"
                                      <?= $data['filter_kriteria'] == $kriteria['id_kriteria'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kriteria['kode_kriteria'] . ' - ' . $kriteria['nama_kriteria']) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-md-4">
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
                            <th width="5%">No</th>
                            <th width="15%">Kriteria</th>
                            <th width="25%">Nama Pilihan</th>
                            <th width="20%">Nilai Utility</th>
                            <th width="20%">Visualisasi</th>
                            <th width="10%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($data['sub_kriterias'])): ?>
                            <?php $no = 1; foreach ($data['sub_kriterias'] as $sub_kriteria): ?>
                            <tr class="table-row-modern" data-aos="fade-in" data-aos-delay="<?= $no * 50 ?>">
                              <td>
                                <span class="row-number"><?= $no++ ?></span>
                              </td>
                              <td>
                                <div class="kriteria-info">
                                  <span class="badge-modern badge-modern-primary">
                                    <?= htmlspecialchars($sub_kriteria['kode_kriteria']) ?>
                                  </span>
                                  <small class="text-muted d-block">
                                    <?= htmlspecialchars($sub_kriteria['nama_kriteria']) ?>
                                  </small>
                                </div>
                              </td>
                              <td>
                                <div class="pilihan-name">
                                  <strong><?= htmlspecialchars($sub_kriteria['nama_pilihan']) ?></strong>
                                </div>
                              </td>
                              <td>
                                <div class="utility-value">
                                  <span class="utility-number"><?= number_format($sub_kriteria['nilai_utility'], 1) ?></span>
                                  <span class="utility-percent">%</span>
                                </div>
                              </td>
                              <td>
                                <div class="utility-bar-wrapper">
                                  <div class="utility-bar">
                                    <div class="utility-fill" style="width: <?= $sub_kriteria['nilai_utility'] ?>%"></div>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <div class="action-buttons-modern">
                                  <a href="index.php?controller=subKriteria&action=edit&id=<?= $sub_kriteria['id_sub'] ?>"
                                     class="btn-modern-action btn-modern-edit"
                                     title="Edit">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  <button onclick="confirmDelete(<?= $sub_kriteria['id_sub'] ?>)"
                                          class="btn-modern-action btn-modern-delete"
                                          title="Hapus">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </div>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <tr class="empty-state-modern">
                              <td colspan="6" class="text-center">
                                <div class="empty-state-content">
                                  <div class="empty-state-icon">
                                    <i class="fas fa-inbox fa-4x"></i>
                                  </div>
                                  <h4 class="empty-state-title">Belum ada data sub kriteria</h4>
                                  <p class="empty-state-text">Mulai dengan menambahkan sub kriteria penilaian baru</p>
                                  <a href="index.php?controller=subKriteria&action=create"
                                     class="btn btn-modern-primary btn-lg">
                                    <i class="fas fa-plus mr-2"></i>Tambah Sub Kriteria
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

    .kriteria-info {
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
      text-transform: uppercase;
      letter-spacing: 0.5px;
      width: fit-content;
    }

    .badge-modern-primary {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
    }

    .pilihan-name {
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

    .btn-modern-edit {
      background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
      color: #fff;
      box-shadow: 0 4px 12px rgba(113, 128, 150, 0.3);
    }

    .btn-modern-edit:hover {
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

    .hover-lift {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
      transform: translateY(-4px);
    }

    /* Modern Alerts */

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

    // Confirm delete using SweetAlert2
    function confirmDelete(id) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data sub kriteria akan dihapus secara permanen!',
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
          window.location.href = 'index.php?controller=subKriteria&action=delete&id=' + id;
        }
      });
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

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Add loading animation to buttons
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function() {
        const button = this.querySelector('button[type="submit"]');
        if (button) {
          button.disabled = true;
          button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
        }
      });
    });
  </script>

</body>

</html>
