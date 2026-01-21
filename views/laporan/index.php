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

              <div class="mb-4" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="animated-title">
                    <div class="d-flex align-items-center mb-2">
                      <div class="title-icon mr-3">
                        <i class="fas fa-chart-bar fa-2x" style="color: #006633;"></i>
                      </div>
                      <div>
                        <h3 class="font-weight-bold mb-0">Laporan Kepuasan Masyarakat</h3>
                        <p class="text-muted mb-0">DISDUKCAPIL Kota Padang</p>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-stat">
                      <div class="card-stat-body">
                        <div class="card-stat-icon">
                          <i class="fas fa-users"></i>
                        </div>
                        <div class="card-stat-content">
                          <h5 class="card-stat-title">Total Responden</h5>
                          <h3 class="card-stat-value"><?= $data['statistics']['total_responden'] ?? 0 ?></h3>
                          <p class="card-stat-text">Orang</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-stat">
                      <div class="card-stat-body">
                        <div class="card-stat-icon">
                          <i class="fas fa-star"></i>
                        </div>
                        <div class="card-stat-content">
                          <h5 class="card-stat-title">Rata-rata SMART</h5>
                          <h3 class="card-stat-value"><?= number_format($data['statistics']['rerata_smart'] ?? 0, 2) ?></h3>
                          <p class="card-stat-text">Poin</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-generate mb-4" data-aos="fade-up" data-aos-delay="300">
                  <div class="card-generate-body">
                    <h5 class="mb-3">
                      <i class="fas fa-file-pdf mr-2" style="color: #006633;"></i>Generate Laporan
                    </h5>
                    <div class="row">
                      <div class="col-md-12">
                        <button onclick="generatePDF()"
                                class="btn btn-generate-pdf btn-block">
                          <i class="fas fa-file-pdf mr-2"></i>
                          <strong>GENERATE PDF</strong>
                        </button>
                        <small class="text-muted d-block mt-2">
                          <i class="fas fa-info-circle mr-1"></i>
                          Format: Koperasi Style dengan Header Hijau (#006633)
                        </small>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-preview" data-aos="fade-up" data-aos-delay="400">
                  <div class="card-preview-body">
                    <h5 class="mb-3">
                      <i class="fas fa-eye mr-2" style="color: #008d75;"></i>Preview Data
                    </h5>

                    <?php
                    $laporan_data = $data['laporan_data'];
                    $alternatifs = $laporan_data['alternatifs'] ?? [];
                    $responden_data = $laporan_data['responden_data'] ?? [];
                    $nilai_per_responden_alternatif = $laporan_data['nilai_per_responden_alternatif'] ?? [];
                    ?>

                    <?php if (!empty($responden_data)): ?>
                      <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table-coop">
                          <thead>
                            <tr>
                              <th width="5%">No</th>
                              <th width="25%">Nama Responden</th>
                              <?php
                              $jumlah_alternatif = count($alternatifs);
                              $lebar_kolom = ($jumlah_alternatif > 0) ? (55 / $jumlah_alternatif) : 10;

                              foreach ($alternatifs as $alt):
                              ?>
                                <th style="width: <?= $lebar_kolom ?>%;"><?= htmlspecialchars($alt['kode_alternatif']) ?></th>
                              <?php endforeach; ?>
                              <th width="15%">Hasil SMART</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no = 1;
                            $total_nilai = 0;

                            foreach ($responden_data as $responden):
                              $id_responden = $responden['id_responden'];
                              $nilai_terbaik = $responden['nilai_smart_terbaik'];
                              $total_nilai += $nilai_terbaik;
                            ?>
                              <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($responden['nama_lengkap']) ?></td>

                                <?php foreach ($alternatifs as $alt): ?>
                                  <?php
                                  $kode_alt = $alt['kode_alternatif'];
                                  $nilai = isset($nilai_per_responden_alternatif[$id_responden][$kode_alt])
                                      ? $nilai_per_responden_alternatif[$id_responden][$kode_alt]
                                      : 0;
                                  ?>
                                  <td class="text-center"><?= number_format($nilai, 2, ',', '.') ?></td>
                                <?php endforeach; ?>

                                <td class="text-center font-weight-bold"><?= number_format($nilai_terbaik, 2, ',', '.') ?></td>
                              </tr>
                            <?php endforeach; ?>

                            <?php
                            $rerata_smart = ($data['statistics']['rerata_smart'] ?? 0);
                            $kesimpulan = ($rerata_smart >= 80) ? 'SANGAT BAIK' : (($rerata_smart >= 60) ? 'BAIK' : 'CUKUP');
                            $colspan_footer = $jumlah_alternatif + 2;
                            ?>

                            <tr class="footer-row">
                              <td colspan="2" class="font-weight-bold">Total Nilai</td>
                              <td colspan="<?= $jumlah_alternatif ?>" class="text-right font-weight-bold"><?= number_format($total_nilai, 2, ',', '.') ?></td>
                              <td class="text-center font-weight-bold"><?= number_format($total_nilai, 2, ',', '.') ?></td>
                            </tr>
                            <tr class="footer-row">
                              <td colspan="2" class="font-weight-bold">Rata-rata Nilai</td>
                              <td colspan="<?= $jumlah_alternatif ?>" class="text-right font-weight-bold"><?= number_format($rerata_smart, 2, ',', '.') ?></td>
                              <td class="text-center font-weight-bold"><?= number_format($rerata_smart, 2, ',', '.') ?></td>
                            </tr>
                            <tr class="footer-row">
                              <td colspan="2" class="font-weight-bold">Kesimpulan</td>
                              <td colspan="<?= $jumlah_alternatif ?>" class="text-center font-weight-bold"><?= $kesimpulan ?></td>
                              <td class="text-center font-weight-bold"><?= $kesimpulan ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    <?php else: ?>
                      <div class="empty-state">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada data laporan</p>
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
  <?php include 'template/script.php'; ?>

  <style>
    .card-stat {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #006633;
      overflow: hidden;
    }

    .card-stat-body {
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .card-stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      background: linear-gradient(135deg, #006633 0%, #004d26 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
    }

    .card-stat-content {
      flex: 1;
    }

    .card-stat-title {
      font-size: 0.875rem;
      color: #6c757d;
      font-weight: 500;
      margin-bottom: 0.25rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card-stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #006633;
      margin-bottom: 0.25rem;
    }

    .card-stat-text {
      font-size: 0.75rem;
      color: #999;
    }

    .card-generate {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #006633;
    }

    .card-generate-body {
      padding: 1.5rem;
    }

    .btn-generate-pdf {
      background: linear-gradient(135deg, #006633 0%, #004d26 100%);
      border: none;
      color: #fff;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 102, 51, 0.3);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-generate-pdf:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 102, 51, 0.4);
      background: linear-gradient(135deg, #004d26 0%, #006633 100%);
    }

    .card-preview {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #dee2e6;
    }

    .card-preview-body {
      padding: 1.5rem;
    }

    .table-coop {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 0.875rem;
    }

    .table-coop thead {
      background-color: #006633;
      border-bottom: 2px solid #006633;
    }

    .table-coop th {
      color: #fff;
      font-weight: 600;
      padding: 0.75rem 0.5rem;
      text-align: center;
      border: 1px solid #006633;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .table-coop td {
      padding: 0.75rem 0.5rem;
      border: 1px solid #006633;
      vertical-align: middle;
    }

    .table-coop tbody tr:nth-child(even) {
      background-color: #f5f5f5;
    }

    .table-coop tbody tr:hover {
      background-color: #e8f5e9;
    }

    .footer-row {
      background-color: #e0e0e0 !important;
      font-weight: 600;
      border-top: 2px solid #006633;
    }

    .footer-row td {
      background-color: #e0e0e0;
    }

    .empty-state {
      padding: 4rem 3rem;
      text-align: center;
    }

    .title-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      background: linear-gradient(135deg, #006633 0%, #004d26 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 24px rgba(0, 102, 51, 0.3);
    }

    @media (max-width: 768px) {
      .card-stat-value {
        font-size: 1.75rem;
      }

      .table-coop th,
      .table-coop td {
        padding: 0.5rem 0.25rem;
        font-size: 0.75rem;
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

    function generatePDF() {
      Swal.fire({
        title: 'Generate PDF Laporan?',
        html: '<p class="text-muted">Format: Koperasi Style</p>' +
              '<ul class="text-left" style="font-size: 0.9rem; margin-top: 1rem;">' +
              '<li>Header: LAPORAN KEPUASAN MASYARAKAT</li>' +
              '<li>Sub-Header: DISDUKCAPIL KOTA PADANG</li>' +
              '<li>Warna Header: Hijau (#006633)</li>' +
              '<li>Font: Arial/Helvetica</li>' +
              '<li>Tabel: No, Nama, A1-A..., Hasil SMART</li>' +
              '<li>Dua tanda tangan: Kepala Dinas & Petugas</li>' +
              '</ul>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#006633',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-file-pdf mr-2"></i>Ya, Generate!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Generating PDF...',
            html: '<i class="fas fa-spinner fa-spin fa-3x" style="color: #006633;"></i><br><br>Mohon tunggu sebentar...',
            showConfirmButton: false,
            allowOutsideClick: false
          });

          window.location.href = 'index.php?controller=laporan&action=generatePDF';
        }
      });
    }
  </script>

</body>

</html>
