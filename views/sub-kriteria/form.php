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
                        <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus-circle' : 'edit' ?> fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">
                          <?= $data['form_type'] == 'create' ? 'Tambah Sub Kriteria Baru' : 'Edit Sub Kriteria' ?>
                        </h3>
                        <p class="text-muted mb-0">
                          <?= $data['form_type'] == 'create' ? 'Isi form untuk menambahkan sub kriteria baru' : 'Perbarui data sub kriteria' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=subKriteria&action=index"
                       class="btn btn-modern-secondary btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Modern Form Card -->
                <div class="card-modern-form" data-aos="fade-up" data-aos-delay="200">
                  <div class="card-modern-form-header">
                    <div class="form-header-content">
                      <div class="form-header-icon">
                        <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus' : 'edit' ?>"></i>
                      </div>
                      <div class="form-header-text">
                        <h4 class="form-header-title">
                          <?= $data['form_type'] == 'create' ? 'Form Tambah Sub Kriteria' : 'Form Edit Sub Kriteria' ?>
                        </h4>
                        <p class="form-header-subtitle">Lengkapi data di bawah ini</p>
                      </div>
                    </div>
                  </div>

                  <div class="card-modern-form-body">
                    <form method="POST" action="<?= $data['form_action'] ?>" id="subKriteriaForm" class="form-modern">

                      <?php if ($data['form_type'] == 'edit'): ?>
                        <input type="hidden" name="id_sub" value="<?= $data['sub_kriteria']['id_sub'] ?>">
                      <?php endif; ?>

                      <!-- Kriteria -->
                      <div class="form-group-modern">
                        <label for="id_kriteria" class="form-label-modern">
                          <i class="fas fa-list-ol label-icon"></i>
                          Kriteria <span class="required">*</span>
                        </label>
                        <div class="select-group-modern">
                          <select class="form-control-modern"
                                  id="id_kriteria"
                                  name="id_kriteria"
                                  required>
                            <option value="">Pilih Kriteria</option>
                            <?php foreach ($data['kriterias'] as $kriteria): ?>
                              <option value="<?= $kriteria['id_kriteria'] ?>"
                                      <?= $data['form_type'] == 'edit' && $data['sub_kriteria']['id_kriteria'] == $kriteria['id_kriteria'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($kriteria['kode_kriteria'] . ' - ' . $kriteria['nama_kriteria']) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <div class="select-icon-modern">
                            <i class="fas fa-chevron-down"></i>
                          </div>
                        </div>
                        <small class="form-text-modern">
                          <i class="fas fa-info-circle"></i>
                          Pilih kriteria induk untuk sub kriteria ini
                        </small>
                      </div>

                      <!-- Nama Pilihan -->
                      <div class="form-group-modern">
                        <label for="nama_pilihan" class="form-label-modern">
                          <i class="fas fa-tag label-icon"></i>
                          Nama Pilihan <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                          <input type="text"
                                 class="form-control-modern"
                                 id="nama_pilihan"
                                 name="nama_pilihan"
                                 value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['sub_kriteria']['nama_pilihan']) : '' ?>"
                                 placeholder="Contoh: Sangat Puas, Puas, Cukup"
                                 required
                                 maxlength="50">
                          <div class="input-icon-modern">
                            <i class="fas fa-file-signature"></i>
                          </div>
                        </div>
                        <small class="form-text-modern">
                          <i class="fas fa-info-circle"></i>
                          Nama pilihan jawaban, maksimal 50 karakter
                        </small>
                      </div>

                      <!-- Nilai Utility -->
                      <div class="form-group-modern">
                        <label for="nilai_utility" class="form-label-modern">
                          <i class="fas fa-sliders-h label-icon"></i>
                          Nilai Utility <span class="required">*</span>
                        </label>
                        <div class="utility-input-wrapper">
                          <div class="input-group-modern mb-3">
                            <input type="number"
                                   class="form-control-modern"
                                   id="nilai_utility"
                                   name="nilai_utility"
                                   value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['sub_kriteria']['nilai_utility']) : '' ?>"
                                   placeholder="0-100"
                                   required
                                   min="0"
                                   max="100"
                                   step="0.1">
                            <div class="input-icon-modern">
                              <i class="fas fa-percent"></i>
                            </div>
                          </div>

                      <!-- Submit Buttons -->
                      <div class="form-actions-modern">
                        <button type="submit" class="btn btn-modern-primary btn-lg">
                          <i class="fas fa-save mr-2"></i>
                          <?= $data['form_type'] == 'create' ? 'Simpan' : 'Perbarui' ?>
                        </button>
                        <a href="index.php?controller=subKriteria&action=index" class="btn btn-modern-secondary btn-lg">
                          <i class="fas fa-times mr-2"></i>Batal
                        </a>
                      </div>

                    </form>
                  </div>
                </div>

                <!-- Modern Info Card -->
                <div class="card-modern-info" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-modern-info-body">
                    <div class="info-header">
                      <div class="info-icon">
                        <i class="fas fa-lightbulb"></i>
                      </div>
                      <div class="info-title">
                        <h4>Informasi Penting</h4>
                        <p>Panduan pengisian form</p>
                      </div>
                    </div>
                    <div class="info-list">
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Kriteria Induk</strong>
                          <p>Sub kriteria harus berada di bawah satu kriteria induk</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Nilai Utility</strong>
                          <p>Nilai 0-100 yang merepresentasikan tingkat kepuasan</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Skala Penilaian</strong>
                          <p>100 = Sangat Baik, 75 = Baik, 50 = Cukup, 25 = Kurang, 0 = Sangat Kurang</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Metode SMART</strong>
                          <p>Sub kriteria digunakan untuk perhitungan metode SMART</p>
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
    /* Modern Form Card */
    .card-modern-form {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin-bottom: 2rem;
    }

    .card-modern-form-header {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      padding: 2rem;
      color: #fff;
    }

    .form-header-content {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .form-header-icon {
      width: 60px;
      height: 60px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.75rem;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .form-header-text h4 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .form-header-subtitle {
      opacity: 0.9;
      margin: 0;
      font-size: 0.95rem;
    }

    .card-modern-form-body {
      padding: 2.5rem;
    }

    /* Modern Form Groups */
    .form-group-modern {
      margin-bottom: 2rem;
      position: relative;
    }

    .form-label-modern {
      display: flex;
      align-items: center;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 0.75rem;
      font-size: 0.95rem;
    }

    .label-icon {
      margin-right: 0.5rem;
      color: #4a5568;
      font-size: 1rem;
    }

    .required {
      color: #e53e3e;
      margin-left: 0.25rem;
    }

    .input-group-modern {
      position: relative;
      display: flex;
      align-items: center;
    }

    .form-control-modern {
      width: 100%;
      padding: 1rem 3rem 1rem 1.25rem;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: #f7fafc;
    }

    .form-control-modern:focus {
      border-color: #4a5568;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
      outline: none;
    }

    .input-icon-modern {
      position: absolute;
      right: 1rem;
      color: #a0aec0;
      font-size: 1.1rem;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .form-control-modern:focus + .input-icon-modern {
      color: #4a5568;
      transform: scale(1.1);
    }

    .form-text-modern {
      display: flex;
      align-items: center;
      margin-top: 0.5rem;
      font-size: 0.85rem;
      color: #718096;
    }

    .form-text-modern i {
      margin-right: 0.5rem;
      color: #4a5568;
    }

    /* Modern Select */
    .select-group-modern {
      position: relative;
    }

    .select-group-modern select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      cursor: pointer;
    }

    .select-icon-modern {
      position: absolute;
      right: 1rem;
      color: #a0aec0;
      font-size: 0.875rem;
      pointer-events: none;
      transition: all 0.3s ease;
    }

    .form-control-modern:focus ~ .select-icon-modern {
      color: #4a5568;
    }

    /* Utility Input */
    .utility-input-wrapper {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .utility-slider-wrapper {
      position: relative;
      padding: 1rem 0;
    }

    .utility-slider {
      width: 100%;
      height: 8px;
      background: #e2e8f0;
      border-radius: 10px;
      outline: none;
      -webkit-appearance: none;
      appearance: none;
    }

    .utility-slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 24px;
      height: 24px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
      transition: all 0.3s ease;
    }

    .utility-slider::-webkit-slider-thumb:hover {
      transform: scale(1.2);
      box-shadow: 0 6px 16px rgba(74, 85, 104, 0.4);
    }

    .utility-slider::-moz-range-thumb {
      width: 24px;
      height: 24px;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border-radius: 50%;
      cursor: pointer;
      border: none;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
      transition: all 0.3s ease;
    }

    .utility-slider::-moz-range-thumb:hover {
      transform: scale(1.2);
      box-shadow: 0 6px 16px rgba(74, 85, 104, 0.4);
    }

    .utility-slider-value {
      text-align: center;
      margin-top: 1rem;
    }

    .value-badge {
      display: inline-flex;
      align-items: center;
      padding: 0.5rem 1.5rem;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      border-radius: 25px;
      font-size: 1.25rem;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
    }

    .utility-visual-bar {
      height: 16px;
      background: #e2e8f0;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
    }

    .utility-visual-fill {
      height: 100%;
      background: linear-gradient(90deg, #4a5568 0%, #718096 100%);
      border-radius: 10px;
      transition: width 0.3s ease;
      position: relative;
    }

    .utility-visual-fill::after {
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

    .utility-quick-buttons {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }

    .btn-quick-value {
      flex: 1;
      min-width: 80px;
      padding: 0.75rem 0.5rem;
      border: 2px solid #e2e8f0;
      background: #fff;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.25rem;
    }

    .btn-quick-value:hover {
      border-color: #4a5568;
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.3);
    }

    .btn-quick-value:hover .quick-value,
    .btn-quick-value:hover .quick-label {
      color: #fff;
    }

    .quick-value {
      font-size: 1.25rem;
      font-weight: 700;
      color: #4a5568;
    }

    .quick-label {
      font-size: 0.75rem;
      color: #718096;
    }

    /* Modern Form Actions */
    .form-actions-modern {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 2px solid #e2e8f0;
    }

    /* Modern Buttons */
    .btn-modern-primary {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      border: none;
      color: #fff;
      padding: 0.875rem 2rem;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 16px rgba(74, 85, 104, 0.3);
    }

    .btn-modern-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(74, 85, 104, 0.4);
    }

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
      .card-modern-form-body {
        padding: 1.5rem;
      }

      .form-actions-modern {
        flex-direction: column;
      }

      .form-actions-modern .btn {
        width: 100%;
      }

      .form-header-content {
        flex-direction: column;
        text-align: center;
      }

      .info-item {
        flex-direction: column;
      }

      .utility-quick-buttons {
        flex-direction: column;
      }

      .btn-quick-value {
        width: 100%;
        flex-direction: row;
        justify-content: center;
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

    // Sync slider and number input
    const utilityInput = document.getElementById('nilai_utility');
    const utilitySlider = document.getElementById('utility_slider');
    const sliderValue = document.getElementById('slider_value');
    const utilityVisualFill = document.getElementById('utility_visual_fill');

    function updateUtility(value) {
      utilityInput.value = value;
      utilitySlider.value = value;
      sliderValue.textContent = value;
      utilityVisualFill.style.width = value + '%';

      // Change color based on value
      if (value >= 75) {
        utilityVisualFill.style.background = 'linear-gradient(90deg, #38a169 0%, #48bb78 100%)';
      } else if (value >= 50) {
        utilityVisualFill.style.background = 'linear-gradient(90deg, #4a5568 0%, #718096 100%)';
      } else if (value >= 25) {
        utilityVisualFill.style.background = 'linear-gradient(90deg, #d69e2e 0%, #ecc94b 100%)';
      } else {
        utilityVisualFill.style.background = 'linear-gradient(90deg, #e53e3e 0%, #fc8181 100%)';
      }
    }

    utilitySlider.addEventListener('input', function() {
      updateUtility(this.value);
    });

    utilityInput.addEventListener('input', function() {
      updateUtility(this.value);
    });

    // Quick value buttons
    document.querySelectorAll('.btn-quick-value').forEach(button => {
      button.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        updateUtility(value);
      });
    });

    // Initialize on page load
    updateUtility(utilityInput.value || 50);

    // Form validation
    document.getElementById('subKriteriaForm').addEventListener('submit', function(e) {
      const idKriteria = document.getElementById('id_kriteria');
      const namaPilihan = document.getElementById('nama_pilihan');
      const nilaiUtility = document.getElementById('nilai_utility');
      let isValid = true;

      // Reset error states
      [idKriteria, namaPilihan, nilaiUtility].forEach(el => {
        el.style.borderColor = '#e2e8f0';
      });

      // Validate kriteria
      if (!idKriteria.value) {
        e.preventDefault();
        idKriteria.style.borderColor = '#e53e3e';
        idKriteria.focus();
        showAlert('Kriteria wajib dipilih!', 'error');
        isValid = false;
      }

      // Validate nama pilihan
      if (!namaPilihan.value.trim()) {
        e.preventDefault();
        namaPilihan.style.borderColor = '#e53e3e';
        namaPilihan.focus();
        showAlert('Nama pilihan wajib diisi!', 'error');
        isValid = false;
      }

      // Validate nilai utility
      if (!nilaiUtility.value || nilaiUtility.value < 0 || nilaiUtility.value > 100) {
        e.preventDefault();
        nilaiUtility.style.borderColor = '#e53e3e';
        nilaiUtility.focus();
        showAlert('Nilai utility harus antara 0-100!', 'error');
        isValid = false;
      }

      return isValid;
    });

    // Show Dialog function using SweetAlert2
    function showDialog(message, type = 'error') {
      if (type === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: message,
          confirmButtonText: 'Kembali ke List',
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
            window.location.href = 'index.php?controller=subKriteria&action=index';
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

    // Show alert function - now uses SweetAlert2
    function showAlert(message, type) {
      Swal.fire({
        icon: 'error',
        title: 'Peringatan',
        text: message,
        confirmButtonText: 'OK',
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

    // Add loading animation to submit button
    document.getElementById('subKriteriaForm').addEventListener('submit', function() {
      const button = this.querySelector('button[type="submit"]');
      if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
      }
    });
  </script>

</body>

</html>
