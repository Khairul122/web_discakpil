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
                        <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Form Penilaian Layanan</h3>
                        <p class="text-muted mb-0">Beri penilaian Anda terhadap layanan DISDUKCAPIL Kota Padang</p>
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

                <!-- Modern Form Card -->
                <div class="card-modern-form" data-aos="fade-up" data-aos-delay="200">
                  <div class="card-modern-form-header">
                    <div class="form-header-content">
                      <div class="form-header-icon">
                        <i class="fas fa-star"></i>
                      </div>
                      <div class="form-header-text">
                        <h4 class="form-header-title">Formulir Penilaian Layanan</h4>
                        <p class="form-header-subtitle">Mohon isi semua pertanyaan di bawah ini dengan jujur dan obyektif</p>
                      </div>
                    </div>
                  </div>

                  <div class="card-modern-form-body">
                    <form method="POST" action="<?= $data['form_action'] ?>" id="penilaianForm" class="form-modern">

                      <!-- Data Responden -->
                      <div class="form-section">
                        <h5 class="form-section-title">
                          <i class="fas fa-user-circle mr-2"></i>Data Responden
                        </h5>

                        <!-- Nama Lengkap -->
                        <div class="form-group-modern">
                          <label for="nama_responden" class="form-label-modern">
                            <i class="fas fa-user label-icon"></i>
                            Nama Lengkap <span class="required">*</span>
                          </label>
                          <div class="input-group-modern">
                            <input type="text"
                                   class="form-control-modern"
                                   id="nama_responden"
                                   name="nama_responden"
                                   placeholder="Masukkan nama lengkap (atau anonim)"
                                   required
                                   maxlength="100">
                            <div class="input-icon-modern">
                              <i class="fas fa-user"></i>
                            </div>
                          </div>
                          <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Boleh menggunakan nama anonim (misal: "Responden 001")
                          </small>
                        </div>

                        <!-- Usia -->
                        <div class="form-group-modern">
                          <label for="usia" class="form-label-modern">
                            <i class="fas fa-birthday-cake label-icon"></i>
                            Usia <span class="required">*</span>
                          </label>
                          <div class="input-group-modern">
                            <input type="number"
                                   class="form-control-modern"
                                   id="usia"
                                   name="usia"
                                   placeholder="Masukkan usia Anda"
                                   required
                                   min="1"
                                   max="120">
                            <div class="input-icon-modern">
                              <i class="fas fa-birthday-cake"></i>
                            </div>
                          </div>
                          <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Usia dalam tahun (1-120)
                          </small>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="form-group-modern">
                          <label for="pekerjaan" class="form-label-modern">
                            <i class="fas fa-briefcase label-icon"></i>
                            Pekerjaan <span class="required">*</span>
                          </label>
                          <div class="input-group-modern">
                            <input type="text"
                                   class="form-control-modern"
                                   id="pekerjaan"
                                   name="pekerjaan"
                                   placeholder="Contoh: Pelajar, PNS, Wiraswasta, dll"
                                   required
                                   maxlength="50">
                            <div class="input-icon-modern">
                              <i class="fas fa-briefcase"></i>
                            </div>
                          </div>
                          <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Pekerjaan Anda saat ini
                          </small>
                        </div>

                        <!-- Layanan yang Dinilai -->
                        <div class="form-group-modern">
                          <label for="id_alternatif" class="form-label-modern">
                            <i class="fas fa-concierge-bell label-icon"></i>
                            Layanan yang Dinilai <span class="required">*</span>
                          </label>
                          <div class="select-group-modern">
                            <select class="form-control-modern"
                                    id="id_alternatif"
                                    name="id_alternatif"
                                    required>
                              <option value="">Pilih Layanan</option>
                              <?php foreach ($data['alternatifs'] as $alternatif): ?>
                                <option value="<?= $alternatif['id_alternatif'] ?>">
                                  <?= htmlspecialchars($alternatif['nama_layanan']) ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                            <div class="select-icon-modern">
                              <i class="fas fa-chevron-down"></i>
                            </div>
                          </div>
                          <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Pilih layanan yang ingin Anda beri penilaian
                          </small>
                        </div>
                      </div>

                      <!-- Penilaian per Kriteria -->
                      <div class="form-section">
                        <h5 class="form-section-title">
                          <i class="fas fa-clipboard-check mr-2"></i>Penilaian Layanan
                        </h5>
                        <p class="form-section-subtitle">Mohon berikan penilaian untuk setiap kriteria di bawah ini</p>

                        <div class="kriteria-container">
                          <?php foreach ($data['kriterias'] as $index => $kriteria): ?>
                            <div class="kriteria-evaluation-card">
                              <div class="kriteria-evaluation-header">
                                <div class="kriteria-number">
                                  <span><?= $index + 1 ?></span>
                                </div>
                                <div class="kriteria-evaluation-info">
                                  <span class="kriteria-code-badge"><?= htmlspecialchars($kriteria['kode_kriteria']) ?></span>
                                  <h6 class="kriteria-evaluation-title">
                                    <?= htmlspecialchars($kriteria['nama_kriteria']) ?>
                                  </h6>
                                  <?php if (!empty($kriteria['pertanyaan'])): ?>
                                    <p class="kriteria-evaluation-question">
                                      <i class="fas fa-question-circle mr-1"></i>
                                      <?= htmlspecialchars($kriteria['pertanyaan']) ?>
                                    </p>
                                  <?php endif; ?>
                                </div>
                              </div>

                              <div class="kriteria-evaluation-body">
                                <label class="form-label-modern">
                                  Pilih Penilaian Anda <span class="required">*</span>
                                </label>
                                <div class="select-group-modern">
                                  <select class="form-control-modern"
                                          name="id_sub_<?= $kriteria['id_kriteria'] ?>"
                                          required>
                                    <option value="">Pilih penilaian</option>
                                    <?php
                                      // Get sub kriteria for this kriteria
                                      $subs = $data['penilaianModel']->getSubKriteriaByKriteria($kriteria['id_kriteria']);
                                      foreach ($subs as $sub): ?>
                                    <option value="<?= $sub['id_sub'] ?>" data-nilai="<?= $sub['nilai_utility'] ?>">
                                      <?= htmlspecialchars($sub['nama_pilihan']) ?> (Nilai: <?= $sub['nilai_utility'] ?>%)
                                    </option>
                                  <?php endforeach; ?>
                                  </select>
                                  <div class="select-icon-modern">
                                    <i class="fas fa-chevron-down"></i>
                                  </div>
                                </div>
                                <div class="utility-preview" id="utility_preview_<?= $kriteria['id_kriteria'] ?>" style="display: none;">
                                  <div class="utility-preview-bar">
                                    <div class="utility-preview-fill" style="width: 0%"></div>
                                  </div>
                                  <small class="utility-preview-text">Nilai Utility: <span class="nilai-preview">0</span>%</small>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>

                      <!-- Submit Button -->
                      <div class="form-actions-modern">
                        <button type="submit" class="btn btn-modern-primary btn-lg">
                          <i class="fas fa-paper-plane mr-2"></i>Kirim Penilaian
                        </button>
                        <a href="index.php?controller=penilaian&action=index" class="btn btn-modern-secondary btn-lg">
                          <i class="fas fa-times mr-2"></i>Batal
                        </a>
                      </div>

                    </form>
                  </div>
                </div>

                <!-- Info Card -->
                <div class="card-modern-info" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-modern-info-body">
                    <div class="info-header">
                      <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                      </div>
                      <div class="info-title">
                        <h4>Informasi Penting</h4>
                        <p>Panduan pengisian form penilaian</p>
                      </div>
                    </div>
                    <div class="info-list">
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Data Diri</strong>
                          <p>Isi data diri dengan lengkap. Nama boleh menggunakan anonim</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Jujur dan Obyektif</strong>
                          <p>Beri penilaian sesuai dengan pengalaman nyata Anda</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Semua Kriteria Wajib</strong>
                          <p>Pastikan semua kriteria dinilai untuk hasil yang akurat</p>
                        </div>
                      </div>
                      <div class="info-item">
                        <div class="info-item-icon">
                          <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="info-item-content">
                          <strong>Satu Kali Per Layanan</strong>
                          <p>Setiap responden hanya bisa menilai satu layanan satu kali</p>
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

    /* Form Section */
    .form-section {
      margin-bottom: 3rem;
      padding-bottom: 2rem;
      border-bottom: 2px solid #e2e8f0;
    }

    .form-section:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }

    .form-section-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
    }

    .form-section-subtitle {
      color: #718096;
      margin-top: 0;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
    }

    /* Modern Form Groups */
    .form-group-modern {
      margin-bottom: 1.5rem;
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

    .input-group-modern,
    .select-group-modern {
      position: relative;
      display: flex;
      align-items: center;
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

    .form-control-modern:focus ~ .select-icon-modern {
      color: #4a5568;
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

    /* Kriteria Evaluation Card */
    .kriteria-container {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .kriteria-evaluation-card {
      background: #f7fafc;
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .kriteria-evaluation-card:hover {
      border-color: #4a5568;
      box-shadow: 0 4px 12px rgba(74, 85, 104, 0.1);
    }

    .kriteria-evaluation-header {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      padding: 1.5rem;
      display: flex;
      align-items: flex-start;
      gap: 1rem;
    }

    .kriteria-number {
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.25rem;
      font-weight: 700;
      flex-shrink: 0;
    }

    .kriteria-evaluation-info {
      flex: 1;
      color: #fff;
    }

    .kriteria-code-badge {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 0.5rem;
    }

    .kriteria-evaluation-title {
      font-size: 1.1rem;
      font-weight: 700;
      margin: 0 0 0.5rem 0;
    }

    .kriteria-evaluation-question {
      font-size: 0.875rem;
      margin: 0;
      opacity: 0.9;
    }

    .kriteria-evaluation-body {
      padding: 1.5rem;
    }

    /* Utility Preview */
    .utility-preview {
      margin-top: 1rem;
      padding: 1rem;
      background: #fff;
      border-radius: 12px;
      border: 2px solid #e2e8f0;
    }

    .utility-preview-bar {
      height: 8px;
      background: #e2e8f0;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 0.5rem;
    }

    .utility-preview-fill {
      height: 100%;
      background: linear-gradient(90deg, #4a5568 0%, #718096 100%);
      border-radius: 10px;
      transition: width 0.3s ease;
    }

    .utility-preview-text {
      color: #718096;
      font-size: 0.875rem;
    }

    .nilai-preview {
      font-weight: 700;
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

      .kriteria-evaluation-header {
        flex-direction: column;
        text-align: center;
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

    // Show utility preview when selecting option
    document.querySelectorAll('select[name^="id_sub_"]').forEach(select => {
      select.addEventListener('change', function() {
        const kriteriaId = this.name.replace('id_sub_', '');
        const previewDiv = document.getElementById('utility_preview_' + kriteriaId);
        const selectedOption = this.options[this.selectedIndex];

        if (this.value && selectedOption.dataset.nilai) {
          const nilai = selectedOption.dataset.nilai;
          previewDiv.style.display = 'block';
          previewDiv.querySelector('.utility-preview-fill').style.width = nilai + '%';
          previewDiv.querySelector('.nilai-preview').textContent = nilai;

          // Change color based on nilai
          const fill = previewDiv.querySelector('.utility-preview-fill');
          if (nilai >= 80) {
            fill.style.background = 'linear-gradient(90deg, #38a169 0%, #48bb78 100%)';
          } else if (nilai >= 60) {
            fill.style.background = 'linear-gradient(90deg, #4a5568 0%, #718096 100%)';
          } else if (nilai >= 40) {
            fill.style.background = 'linear-gradient(90deg, #d69e2e 0%, #ecc94b 100%)';
          } else {
            fill.style.background = 'linear-gradient(90deg, #e53e3e 0%, #fc8181 100%)';
          }
        } else {
          previewDiv.style.display = 'none';
        }
      });
    });

    // Form validation
    document.getElementById('penilaianForm').addEventListener('submit', function(e) {
      const namaResponden = document.getElementById('nama_responden');
      const usia = document.getElementById('usia');
      const pekerjaan = document.getElementById('pekerjaan');
      const idAlternatif = document.getElementById('id_alternatif');
      let isValid = true;

      // Reset error states
      [namaResponden, usia, pekerjaan, idAlternatif].forEach(el => {
        el.style.borderColor = '#e2e8f0';
      });

      // Validate nama responden
      if (!namaResponden.value.trim()) {
        e.preventDefault();
        namaResponden.style.borderColor = '#e53e3e';
        namaResponden.focus();
        showAlert('Nama lengkap wajib diisi!', 'error');
        isValid = false;
      }

      // Validate usia
      if (!usia.value || usia.value < 1 || usia.value > 120) {
        e.preventDefault();
        usia.style.borderColor = '#e53e3e';
        usia.focus();
        showAlert('Usia harus antara 1-120 tahun!', 'error');
        isValid = false;
      }

      // Validate pekerjaan
      if (!pekerjaan.value.trim()) {
        e.preventDefault();
        pekerjaan.style.borderColor = '#e53e3e';
        pekerjaan.focus();
        showAlert('Pekerjaan wajib diisi!', 'error');
        isValid = false;
      }

      // Validate alternatif
      if (!idAlternatif.value) {
        e.preventDefault();
        idAlternatif.style.borderColor = '#e53e3e';
        idAlternatif.focus();
        showAlert('Layanan wajib dipilih!', 'error');
        isValid = false;
      }

      // Validate all kriteria selections
      document.querySelectorAll('select[name^="id_sub_"]').forEach((select, index) => {
        if (!select.value) {
          e.preventDefault();
          select.style.borderColor = '#e53e3e';
          select.focus();
          showAlert('Semua kriteria wajib dinilai!', 'error');
          isValid = false;
          return false;
        }
      });

      return isValid;
    });

    // Show alert function using SweetAlert2
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

    // Show Dialog function using SweetAlert2
    function showDialog(message, type = 'error') {
      if (type === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Terima Kasih!',
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

    // Add loading animation to submit button
    document.getElementById('penilaianForm').addEventListener('submit', function() {
      const button = this.querySelector('button[type="submit"]');
      if (button) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
      }
    });
  </script>

</body>

</html>
