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
                          <?= $data['form_type'] == 'create' ? 'Tambah Kriteria Baru' : 'Edit Kriteria' ?>
                        </h3>
                        <p class="text-muted mb-0">
                          <?= $data['form_type'] == 'create' ? 'Isi form untuk menambahkan kriteria penilaian baru' : 'Perbarui data kriteria penilaian' ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="action-buttons">
                    <a href="index.php?controller=kriteria&action=index"
                       class="btn btn-modern-secondary btn-lg shadow-sm hover-lift"
                       data-aos="zoom-in"
                       data-aos-delay="100">
                      <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                  </div>
                </div>

                <!-- Alert Messages -->
                <?php if (isset($_SESSION['error'])): ?>
                  <div class="alert alert-modern-danger alert-dismissible fade show" role="alert" data-aos="slide-down">
                    <div class="alert-content">
                      <div class="alert-icon">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                      </div>
                      <div class="alert-message">
                        <strong>Error!</strong>
                        <p class="mb-0"><?= $_SESSION['error'] ?></p>
                      </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php unset($_SESSION['error']); endif; ?>

                <!-- Modern Form Card -->
                <div class="card-modern-form" data-aos="fade-up" data-aos-delay="200">
                  <div class="card-modern-form-header">
                    <div class="form-header-content">
                      <div class="form-header-icon">
                        <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus' : 'edit' ?>"></i>
                      </div>
                      <div class="form-header-text">
                        <h4 class="form-header-title">
                          <?= $data['form_type'] == 'create' ? 'Form Tambah Kriteria' : 'Form Edit Kriteria' ?>
                        </h4>
                        <p class="form-header-subtitle">Lengkapi data di bawah ini</p>
                      </div>
                    </div>
                  </div>

                  <div class="card-modern-form-body">
                    <form method="POST" action="<?= $data['form_action'] ?>" id="kriteriaForm" class="form-modern">

                      <?php if ($data['form_type'] == 'edit'): ?>
                        <input type="hidden" name="id_kriteria" value="<?= $data['kriteria']['id_kriteria'] ?>">
                      <?php endif; ?>

                      <!-- Kode Kriteria -->
                      <div class="form-group-modern">
                        <label for="kode_kriteria" class="form-label-modern">
                          <i class="fas fa-hashtag label-icon"></i>
                          Kode Kriteria <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                          <input type="text"
                                 class="form-control-modern"
                                 id="kode_kriteria"
                                 name="kode_kriteria"
                                 value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['kode_kriteria']) : '' ?>"
                                 placeholder="Contoh: C1, C2, C3"
                                 required
                                 maxlength="10"
                                 pattern="[A-Z0-9]+"
                                 oninput="this.value = this.value.toUpperCase()">
                          <div class="input-icon-modern">
                            <i class="fas fa-key"></i>
                          </div>
                        </div>
                        <small class="form-text-modern">
                          <i class="fas fa-info-circle"></i>
                          Maksimal 10 karakter, huruf kapital dan angka saja
                        </small>
                      </div>

                      <!-- Nama Kriteria -->
                      <div class="form-group-modern">
                        <label for="nama_kriteria" class="form-label-modern">
                          <i class="fas fa-tag label-icon"></i>
                          Nama Kriteria <span class="required">*</span>
                        </label>
                        <div class="input-group-modern">
                          <input type="text"
                                 class="form-control-modern"
                                 id="nama_kriteria"
                                 name="nama_kriteria"
                                 value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['nama_kriteria']) : '' ?>"
                                 placeholder="Masukkan nama kriteria"
                                 required
                                 maxlength="100">
                          <div class="input-icon-modern">
                            <i class="fas fa-file-signature"></i>
                          </div>
                        </div>
                        <small class="form-text-modern">
                          <i class="fas fa-info-circle"></i>
                          Nama kriteria penilaian
                        </small>
                      </div>

                      <!-- Pertanyaan -->
                      <div class="form-group-modern">
                        <label for="pertanyaan" class="form-label-modern">
                          <i class="fas fa-question-circle label-icon"></i>
                          Pertanyaan <span class="required">*</span>
                        </label>
                        <div class="textarea-group-modern">
                          <textarea class="form-control-modern form-control-textarea-modern"
                                    id="pertanyaan"
                                    name="pertanyaan"
                                    rows="4"
                                    placeholder="Tuliskan pertanyaan untuk kriteria ini..."
                                    required
                                    maxlength="500"><?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['pertanyaan']) : '' ?></textarea>
                          <div class="textarea-counter">
                            <span id="pertanyaan-counter">0</span>/500
                          </div>
                        </div>
                        <small class="form-text-modern">
                          <i class="fas fa-info-circle"></i>
                          Pertanyaan yang akan diajukan kepada responden
                        </small>
                      </div>

                      <!-- Bobot & Jenis (Two Columns) -->
                      <div class="row">
                        <!-- Bobot -->
                        <div class="col-md-6">
                          <div class="form-group-modern">
                            <label for="bobot" class="form-label-modern">
                              <i class="fas fa-weight-hanging label-icon"></i>
                              Bobot <span class="required">*</span>
                            </label>
                            <div class="input-group-modern">
                              <input type="number"
                                     class="form-control-modern"
                                     id="bobot"
                                     name="bobot"
                                     value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['bobot']) : '' ?>"
                                     placeholder="1-100"
                                     required
                                     min="1"
                                     max="100">
                              <div class="input-icon-modern">
                                <i class="fas fa-percent"></i>
                              </div>
                            </div>
                            <small class="form-text-modern">
                              <i class="fas fa-info-circle"></i>
                              Skala 1-100
                            </small>
                          </div>
                        </div>

                        <!-- Jenis -->
                        <div class="col-md-6">
                          <div class="form-group-modern">
                            <label for="jenis" class="form-label-modern">
                              <i class="fas fa-exchange-alt label-icon"></i>
                              Jenis <span class="required">*</span>
                            </label>
                            <div class="select-group-modern">
                              <select class="form-control-modern"
                                      id="jenis"
                                      name="jenis"
                                      required>
                                <option value="">Pilih Jenis</option>
                                <option value="benefit" <?= $data['form_type'] == 'edit' && $data['kriteria']['jenis'] == 'benefit' ? 'selected' : '' ?>>
                                  Benefit (Keuntungan)
                                </option>
                                <option value="cost" <?= $data['form_type'] == 'edit' && $data['kriteria']['jenis'] == 'cost' ? 'selected' : '' ?>>
                                  Cost (Biaya)
                                </option>
                              </select>
                              <div class="select-icon-modern">
                                <i class="fas fa-chevron-down"></i>
                              </div>
                            </div>
                            <small class="form-text-modern">
                              <i class="fas fa-info-circle"></i>
                              Benefit: semakin tinggi semakin baik
                            </small>
                          </div>
                        </div>
                      </div>

                      <!-- Submit Buttons -->
                      <div class="form-actions-modern">
                        <button type="submit" class="btn btn-modern-primary btn-lg">
                          <i class="fas fa-save mr-2"></i>
                          <?= $data['form_type'] == 'create' ? 'Simpan' : 'Perbarui' ?>
                        </button>
                        <a href="index.php?controller=kriteria&action=index" class="btn btn-modern-secondary btn-lg">
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
                          <strong>Kode Unik</strong>
                          <p>Kode kriteria harus unik dan tidak boleh duplikat</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Bobot 1-100</strong>
                          <p>Bobot menggunakan skala 1-100 untuk setiap kriteria</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Jenis Kriteria</strong>
                          <p>Benefit: semakin tinggi semakin baik, Cost: semakin rendah semakin baik</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Metode SMART</strong>
                          <p>Kriteria akan digunakan dalam perhitungan metode SMART</p>
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
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
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

    /* Modern Textarea */
    .textarea-group-modern {
      position: relative;
    }

    .form-control-textarea-modern {
      resize: vertical;
      min-height: 100px;
      padding-right: 4rem !important;
    }

    .textarea-counter {
      position: absolute;
      bottom: 1rem;
      right: 1rem;
      background: rgba(74, 85, 104, 0.1);
      color: #4a5568;
      padding: 0.25rem 0.75rem;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 600;
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

    /* Modern Alerts */
    .alert-modern-danger {
      background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
      border-left: 4px solid #e53e3e;
      border-radius: 12px;
      padding: 1rem 1.5rem;
      box-shadow: 0 4px 16px rgba(229, 62, 62, 0.15);
      margin-bottom: 1.5rem;
    }

    .alert-content {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
    }

    .alert-icon {
      flex-shrink: 0;
      color: #e53e3e;
    }

    .alert-message {
      flex: 1;
    }

    .alert-message strong {
      display: block;
      margin-bottom: 0.25rem;
      font-size: 1rem;
      color: #c53030;
    }

    .alert-message p {
      margin-bottom: 0;
      color: #4a5568;
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
      0%, 100% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
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

    // Character counter for textarea
    const pertanyaan = document.getElementById('pertanyaan');
    const counter = document.getElementById('pertanyaan-counter');

    if (pertanyaan && counter) {
      // Set initial count
      counter.textContent = pertanyaan.value.length;

      // Update count on input
      pertanyaan.addEventListener('input', function() {
        counter.textContent = this.value.length;

        // Change color when approaching limit
        if (this.value.length > 450) {
          counter.style.background = 'rgba(229, 62, 62, 0.1)';
          counter.style.color = '#e53e3e';
        } else if (this.value.length > 400) {
          counter.style.background = 'rgba(246, 173, 85, 0.1)';
          counter.style.color = '#d69e2e';
        } else {
          counter.style.background = 'rgba(74, 85, 104, 0.1)';
          counter.style.color = '#4a5568';
        }
      });
    }

    // Form validation with visual feedback
    document.getElementById('kriteriaForm').addEventListener('submit', function(e) {
      const kode = document.getElementById('kode_kriteria');
      const nama = document.getElementById('nama_kriteria');
      const pertanyaan = document.getElementById('pertanyaan');
      const bobot = document.getElementById('bobot');
      const jenis = document.getElementById('jenis');
      let isValid = true;

      // Reset error states
      [kode, nama, pertanyaan, bobot, jenis].forEach(el => {
        el.style.borderColor = '#e2e8f0';
      });

      // Validate kode
      if (!kode.value.trim()) {
        e.preventDefault();
        kode.style.borderColor = '#e53e3e';
        kode.focus();
        showAlert('Kode kriteria wajib diisi!', 'error');
        isValid = false;
      } else if (!/^[A-Z0-9]+$/.test(kode.value)) {
        e.preventDefault();
        kode.style.borderColor = '#e53e3e';
        kode.focus();
        showAlert('Kode kriteria hanya boleh huruf kapital dan angka!', 'error');
        isValid = false;
      } else if (kode.value.length > 10) {
        e.preventDefault();
        kode.style.borderColor = '#e53e3e';
        kode.focus();
        showAlert('Kode kriteria maksimal 10 karakter!', 'error');
        isValid = false;
      }

      // Validate nama
      if (!nama.value.trim()) {
        e.preventDefault();
        nama.style.borderColor = '#e53e3e';
        nama.focus();
        showAlert('Nama kriteria wajib diisi!', 'error');
        isValid = false;
      }

      // Validate pertanyaan
      if (!pertanyaan.value.trim()) {
        e.preventDefault();
        pertanyaan.style.borderColor = '#e53e3e';
        pertanyaan.focus();
        showAlert('Pertanyaan wajib diisi!', 'error');
        isValid = false;
      }

      // Validate bobot
      if (!bobot.value || bobot.value < 1 || bobot.value > 100) {
        e.preventDefault();
        bobot.style.borderColor = '#e53e3e';
        bobot.focus();
        showAlert('Bobot harus antara 1-100!', 'error');
        isValid = false;
      }

      // Validate jenis
      if (!jenis.value) {
        e.preventDefault();
        jenis.style.borderColor = '#e53e3e';
        jenis.focus();
        showAlert('Jenis kriteria wajib dipilih!', 'error');
        isValid = false;
      }

      return isValid;
    });

    // Show alert function
    function showAlert(message, type) {
      const alertDiv = document.createElement('div');
      alertDiv.className = 'alert alert-modern-danger alert-dismissible fade show';
      alertDiv.innerHTML = `
        <div class="alert-content">
          <div class="alert-icon">
            <i class="fas fa-exclamation-triangle fa-2x"></i>
          </div>
          <div class="alert-message">
            <strong>Error!</strong>
            <p class="mb-0">${message}</p>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      `;

      const formCard = document.querySelector('.card-modern-form');
      formCard.parentNode.insertBefore(alertDiv, formCard);

      // Auto remove after 5 seconds
      setTimeout(function() {
        alertDiv.remove();
      }, 5000);
    }

    // Auto-hide alerts
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);

    // Add loading animation to submit button
    document.getElementById('kriteriaForm').addEventListener('submit', function() {
      const button = this.querySelector('button[type="submit"]');
      if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
      }
    });
  </script>

</body>

</html>
