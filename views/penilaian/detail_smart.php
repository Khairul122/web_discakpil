<?php
// Data yang sudah diproses di controller
$responden = $data['responden'];
$hasil_smart = $data['hasil_smart'];
$normalized_weights = $data['normalized_weights'];
?>

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

              <!-- Animated Header -->
              <div class="smart-header mb-4" data-aos="fade-down">
                <div class="smart-header-content">
                  <div class="smart-header-left">
                    <div class="smart-icon-animated">
                      <div class="smart-icon-pulse"></div>
                      <i class="fas fa-brain"></i>
                    </div>
                    <div class="smart-header-text">
                      <h1 class="smart-title">Analisis SMART</h1>
                      <p class="smart-subtitle">Simple Multi-Attribute Rating Technique</p>
                      <div class="smart-badges">
                        <span class="smart-badge">
                          <i class="fas fa-users mr-1"></i>
                          <?= htmlspecialchars($responden['nama_lengkap']) ?>
                        </span>
                        <span class="smart-badge">
                          <i class="fas fa-briefcase mr-1"></i>
                          <?= htmlspecialchars($responden['pekerjaan']) ?>
                        </span>
                        <span class="smart-badge">
                          <i class="fas fa-birthday-cake mr-1"></i>
                          <?= $responden['usia'] ?> Tahun
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="smart-header-right">
                    <a href="index.php?controller=penilaian&action=index"
                       class="btn btn-back-animated">
                      <i class="fas fa-arrow-left mr-2"></i>
                      <span>Kembali</span>
                    </a>
                  </div>
                </div>
              </div>

              <!-- Formula Card with REAL DATA -->
              <div class="formula-card mb-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="formula-card-header">
                  <i class="fas fa-calculator mr-2"></i>
                  <span>Perhitungan Metode SMART - Data Nyata</span>
                </div>
                <div class="formula-card-body">
                  <!-- Ambil salah satu layanan sebagai contoh -->
                  <?php if (!empty($hasil_smart)): ?>
                    <?php
                      $sample_hasil = $hasil_smart[0];
                      $total_bobot_real = 0;
                      foreach ($sample_hasil['detail_kriteria'] as $k) {
                        // Hitung total bobot asli
                        foreach ($data['penilaians'] as $p) {
                          if ($p['id_kriteria'] == $k['id_kriteria']) {
                            foreach ($kriterias ?? [] as $kr) {
                              if ($kr['id_kriteria'] == $k['id_kriteria']) {
                                $total_bobot_real = $kr['bobot'];
                                break 2;
                              }
                            }
                            break;
                          }
                        }
                      }
                    ?>

                    <!-- Info Layanan -->
                    <div class="sample-info">
                      <i class="fas fa-info-circle mr-2"></i>
                      <strong>Contoh Perhitungan untuk:</strong>
                      <span class="sample-layanan"><?= htmlspecialchars($sample_hasil['nama_layanan']) ?></span>
                    </div>

                    <!-- Langkah 1: Normalisasi Bobot -->
                    <div class="formula-step">
                      <div class="step-badge">Langkah 1: Normalisasi Bobot</div>
                      <div class="step-content">
                        <div class="step-desc">Rumus: Wi = bobot_kriteria / Σ(bobot_semua)</div>
                        <div class="step-desc">Total Bobot Semua Kriteria: <strong><?= $total_bobot_real ?>%</strong></div>
                        <div class="calculation-table">
                          <table class="calc-table">
                            <thead>
                              <tr>
                                <th>Kriteria</th>
                                <th>Bobot Asli</th>
                                <th>Bobot Normalisasi (Wi)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($sample_hasil['detail_kriteria'] as $idx => $detail): ?>
                                <?php
                                  $bobot_asli = 0;
                                  foreach ($kriterias ?? [] as $kr) {
                                    if ($kr['id_kriteria'] == $detail['id_kriteria']) {
                                      $bobot_asli = $kr['bobot'];
                                      break;
                                    }
                                  }
                                  $bobot_norm = $normalized_weights[$detail['id_kriteria']] ?? 0;
                                ?>
                                <tr>
                                  <td>
                                    <span class="kriteria-badge-sm"><?= htmlspecialchars($detail['kode_kriteria']) ?></span>
                                  </td>
                                  <td class="text-center">
                                    <span class="bobot-original"><?= $bobot_asli ?>%</span>
                                  </td>
                                  <td class="text-center">
                                    <span class="bobot-normalized"><?= number_format($bobot_norm, 4) ?></span>
                                    <span class="calc-equals">= <?= number_format($bobot_asli) ?> / <?= $total_bobot_real ?></span>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- Langkah 2 & 3: Hitung Kontribusi -->
                    <div class="formula-step">
                      <div class="step-badge">Langkah 2 & 3: Hitung Kontribusi (Ki = Wi × Ui)</div>
                      <div class="step-content">
                        <div class="calculation-table">
                          <table class="calc-table">
                            <thead>
                              <tr>
                                <th>Kriteria</th>
                                <th>Wi (Bobot)</th>
                                <th>Ui (Nilai)</th>
                                <th>Kontribusi (Ki)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $total_kontribusi_sample = 0;
                              foreach ($sample_hasil['detail_kriteria'] as $idx => $detail):
                                $bobot_norm = $normalized_weights[$detail['id_kriteria']] ?? 0;
                                $nilai_util = $detail['nilai_utility'];
                                $kontribusi = $bobot_norm * $nilai_util;
                                $total_kontribusi_sample += $kontribusi;
                              ?>
                                <tr class="calc-row">
                                  <td>
                                    <span class="kriteria-badge-sm"><?= htmlspecialchars($detail['kode_kriteria']) ?></span>
                                    <small class="text-muted"><?= htmlspecialchars($detail['nama_kriteria']) ?></small>
                                  </td>
                                  <td class="text-center">
                                    <span class="calc-variable-wi"><?= number_format($bobot_norm, 4) ?></span>
                                  </td>
                                  <td class="text-center">
                                    <span class="calc-variable-ui"><?= number_format($nilai_util, 1) ?>%</span>
                                  </td>
                                  <td class="text-center">
                                    <span class="calc-result">
                                      <?= number_format($bobot_norm, 4) ?> × <?= number_format($nilai_util, 1) ?>
                                      <br>
                                      <strong>= <?= number_format($kontribusi, 2) ?></strong>
                                    </span>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                              <tr class="calc-row-total">
                                <td colspan="3" class="text-right">
                                  <strong>Total Kontribusi (Σ Ki)</strong>
                                </td>
                                <td class="text-center">
                                  <span class="calc-total-result"><?= number_format($total_kontribusi_sample, 2) ?></span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- Hasil Akhir -->
                    <div class="formula-step result-step">
                      <div class="step-badge step-badge-success">HASIL AKHIR</div>
                      <div class="step-content">
                        <div class="final-result">
                          <div class="result-label">Nilai SMART untuk Layanan "<?= htmlspecialchars($sample_hasil['nama_layanan']) ?>"</div>
                          <div class="result-value">
                            <span class="result-number"><?= number_format($sample_hasil['nilai_smart'], 2) ?></span>
                          </div>
                          <div class="result-rank">Ranking: #<?= array_search($sample_hasil['id_alternatif'], array_column($hasil_smart, 'id_alternatif')) + 1 ?></div>
                        </div>
                      </div>
                    </div>

                    <!-- Semua Hasil -->
                    <div class="formula-step">
                      <div class="step-badge">Hasil Semua Layanan</div>
                      <div class="step-content">
                        <div class="all-results-grid">
                          <?php foreach ($hasil_smart as $idx => $hasil): ?>
                            <div class="result-mini-card">
                              <div class="result-mini-rank">#<?= $idx + 1 ?></div>
                              <div class="result-mini-name"><?= htmlspecialchars($hasil['nama_layanan']) ?></div>
                              <div class="result-mini-score"><?= number_format($hasil['nilai_smart'], 2) ?></div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>

                  <?php endif; ?>

                  <!-- Legend -->
                  <div class="formula-legend">
                    <div class="legend-item">
                      <span class="legend-variable">Wi</span>
                      <span class="legend-desc">= Bobot normalisasi kriteria ke-i</span>
                    </div>
                    <div class="legend-item">
                      <span class="legend-variable">Ui</span>
                      <span class="legend-desc">= Nilai utility sub-kriteria (0-100)</span>
                    </div>
                    <div class="legend-item">
                      <span class="legend-variable">Ki</span>
                      <span class="legend-desc">= Kontribusi kriteria ke-i</span>
                    </div>
                    <div class="legend-item">
                      <span class="legend-variable">Si</span>
                      <span class="legend-desc">= Nilai SMART untuk layanan ke-i</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Results Cards -->
              <div class="results-container">
                <?php
                $winner = $hasil_smart[0];
                $score_color = $winner['nilai_smart'] >= 80 ? 'gradient-gold' :
                              ($winner['nilai_smart'] >= 60 ? 'gradient-green' :
                              ($winner['nilai_smart'] >= 40 ? 'gradient-blue' : 'gradient-orange'));
                ?>

                <!-- Winner Card -->
                <div class="winner-card <?= $score_color ?>" data-aos="flip-left" data-aos-delay="200">
                  <div class="winner-card-bg"></div>
                  <div class="winner-card-content">
                    <div class="winner-crown">
                      <i class="fas fa-crown"></i>
                    </div>
                    <div class="winner-badge">
                      <span class="winner-rank">#1</span>
                      <span class="winner-label">Layanan Terbaik</span>
                    </div>
                    <h2 class="winner-name"><?= htmlspecialchars($winner['nama_layanan']) ?></h2>
                    <div class="winner-score-container">
                      <div class="winner-score-value"><?= number_format($winner['nilai_smart'], 2) ?></div>
                      <div class="winner-score-label">Nilai SMART</div>
                    </div>
                    <div class="winner-description">
                      <?php
                        $ket = $winner['nilai_smart'] >= 80 ? 'Sangat Baik' :
                              ($winner['nilai_smart'] >= 60 ? 'Baik' :
                              ($winner['nilai_smart'] >= 40 ? 'Cukup' :
                              ($winner['nilai_smart'] >= 20 ? 'Kurang' : 'Sangat Kurang')));
                      ?>
                      <span class="winner-ket"><?= $ket ?></span>
                    </div>
                  </div>
                  <div class="winner-particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                  </div>
                </div>

                <!-- Rankings List -->
                <div class="rankings-list" data-aos="fade-up" data-aos-delay="300">
                  <?php foreach ($hasil_smart as $index => $hasil):
                    $rank = $index + 1;
                    $is_winner = $rank === 1;
                    $card_delay = 400 + ($index * 100);
                  ?>
                    <div class="ranking-card <?= $is_winner ? 'ranking-winner' : '' ?>"
                         data-aos="slide-up"
                         data-aos-delay="<?= $card_delay ?>"
                         data-aos-offset="50">
                      <div class="ranking-card-left">
                        <div class="ranking-number <?= $is_winner ? 'ranking-1' : 'ranking-' . ($rank <= 3 ? 'top3' : 'other') ?>">
                          <?php if ($is_winner): ?>
                            <i class="fas fa-trophy"></i>
                          <?php else: ?>
                            <?= $rank ?>
                          <?php endif; ?>
                        </div>
                        <div class="ranking-info">
                          <h3 class="ranking-name"><?= htmlspecialchars($hasil['nama_layanan']) ?></h3>
                          <?php if ($is_winner): ?>
                            <span class="ranking-medal">🏆 Pemenang</span>
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="ranking-card-right">
                        <div class="ranking-score-container">
                          <div class="ranking-score-value"><?= number_format($hasil['nilai_smart'], 2) ?></div>
                          <div class="ranking-score-bar">
                            <div class="ranking-score-fill" style="width: <?= $hasil['nilai_smart'] ?>%"></div>
                          </div>
                        </div>
                      </div>

                      <!-- Expandable Details -->
                      <div class="ranking-details">
                        <button class="ranking-toggle" type="button" onclick="toggleDetails('<?= $hasil['id_alternatif'] ?>', this)">
                          <i class="fas fa-chevron-down mr-2" id="icon-<?= $hasil['id_alternatif'] ?>"></i>
                          <span>Lihat Detail Per Kriteria</span>
                        </button>
                        <div id="details-<?= $hasil['id_alternatif'] ?>" class="ranking-details-content" style="display: none;">
                          <div class="details-table-container">
                            <table class="details-table">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="25%">Kriteria</th>
                                  <th width="25%">Sub Kriteria</th>
                                  <th width="15%" class="text-center">Nilai</th>
                                  <th width="15%" class="text-center">Bobot</th>
                                  <th width="15%" class="text-center">Kontribusi</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $total_kontribusi = 0;
                                foreach ($hasil['detail_kriteria'] as $idx => $detail):
                                  $bobot = $normalized_weights[$detail['id_kriteria']];
                                  $kontribusi = $bobot * $detail['nilai_utility'];
                                  $total_kontribusi += $kontribusi;
                                ?>
                                  <tr class="detail-row">
                                    <td><?= $idx + 1 ?></td>
                                    <td>
                                      <span class="kriteria-badge"><?= htmlspecialchars($detail['kode_kriteria']) ?></span>
                                      <span class="kriteria-name ml-2"><?= htmlspecialchars($detail['nama_kriteria']) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($detail['nama_pilihan']) ?></td>
                                    <td class="text-center">
                                      <span class="nilai-badge nilai-<?= floor($detail['nilai_utility']/20) ?>">
                                        <?= number_format($detail['nilai_utility'], 1) ?>%
                                      </span>
                                    </td>
                                    <td class="text-center">
                                      <span class="bobot-badge"><?= number_format($bobot * 100, 1) ?>%</span>
                                    </td>
                                    <td class="text-center">
                                      <span class="kontribusi-value font-weight-bold"><?= number_format($kontribusi, 2) ?></span>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                                <tr class="detail-row-total">
                                  <td colspan="5" class="text-right">
                                    <strong>Total Nilai SMART</strong>
                                  </td>
                                  <td class="text-center">
                                    <span class="total-value"><?= number_format($total_kontribusi, 2) ?></span>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <!-- Statistics Summary -->
              <div class="stats-summary" data-aos="fade-up" data-aos-delay="800">
                <div class="stat-card">
                  <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-layer-group"></i>
                  </div>
                  <div class="stat-content">
                    <div class="stat-value"><?= count($hasil_smart) ?></div>
                    <div class="stat-label">Layanan Dinilai</div>
                  </div>
                </div>
                <div class="stat-card">
                  <div class="stat-icon stat-icon-success">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <div class="stat-content">
                    <div class="stat-value"><?= number_format($winner['nilai_smart'], 1) ?></div>
                    <div class="stat-label">Nilai Tertinggi</div>
                  </div>
                </div>
                <div class="stat-card">
                  <div class="stat-icon stat-icon-info">
                    <i class="fas fa-star"></i>
                  </div>
                  <div class="stat-content">
                    <div class="stat-value"><?= number_format(array_sum(array_column($hasil_smart, 'nilai_smart')) / count($hasil_smart), 1) ?></div>
                    <div class="stat-label">Rata-rata</div>
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

  <!-- Custom Styles -->
  <style>
    /* Header Styles */
    .smart-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
      position: relative;
      overflow: hidden;
    }

    .smart-header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    .smart-header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      z-index: 1;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .smart-header-left {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      flex: 1;
    }

    .smart-icon-animated {
      width: 80px;
      height: 80px;
      position: relative;
    }

    .smart-icon-pulse {
      position: absolute;
      width: 100%;
      height: 100%;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    @keyframes pulse-ring {
      0% { transform: scale(0.8); opacity: 1; }
      80%, 100% { transform: scale(1.3); opacity: 0; }
    }

    .smart-icon-animated i {
      position: relative;
      font-size: 2.5rem;
      color: #fff;
      z-index: 1;
    }

    .smart-header-text {
      color: #fff;
    }

    .smart-title {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .smart-subtitle {
      font-size: 1rem;
      opacity: 0.9;
      margin-bottom: 1rem;
    }

    .smart-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .smart-badge {
      background: rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.875rem;
      color: #fff;
      display: inline-flex;
      align-items: center;
    }

    .btn-back-animated {
      background: rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255,255,255,0.3);
      color: #fff;
      padding: 0.875rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
    }

    .btn-back-animated:hover {
      background: rgba(255,255,255,0.3);
      transform: translateX(-5px);
    }

    /* Formula Card */
    .formula-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .formula-card-header {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      padding: 1.5rem;
      color: #fff;
      font-size: 1.25rem;
      font-weight: 600;
    }

    .formula-card-body {
      padding: 2rem;
    }

    /* Formula Steps */
    .formula-step {
      background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1rem;
      border-left: 4px solid #667eea;
      transition: all 0.3s ease;
    }

    .formula-step:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
    }

    .step-badge {
      display: inline-block;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-weight: 700;
      font-size: 0.875rem;
      margin-bottom: 1rem;
    }

    .step-content {
      margin-top: 1rem;
    }

    .step-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #2d3748;
      margin-bottom: 0.75rem;
    }

    .step-equation {
      font-size: 1.25rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
      margin-bottom: 0.5rem;
    }

    .step-equation.main-formula {
      font-size: 1.5rem;
      background: #fff;
      padding: 1rem;
      border-radius: 10px;
      border: 2px solid #667eea;
    }

    .step-label {
      font-weight: 700;
      color: #764ba2;
      min-width: 30px;
    }

    .step-operator {
      color: #4a5568;
      font-weight: 600;
    }

    .step-sum {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 700;
      font-size: 1.5rem;
    }

    .step-bracket {
      color: #4a5568;
      font-weight: 700;
      font-size: 1.5rem;
    }

    .step-variable {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 700;
    }

    .step-formula {
      color: #718096;
      font-style: italic;
      flex: 1;
    }

    .step-desc {
      font-size: 0.875rem;
      color: #718096;
      margin-top: 0.5rem;
    }

    .step-example {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 0.75rem;
    }

    .example-badge {
      background: #fff;
      color: #764ba2;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.875rem;
      font-weight: 600;
      border: 2px solid #e2e8f0;
    }

    .formula-legend {
      display: flex;
      gap: 2rem;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 2px dashed #e2e8f0;
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .legend-variable {
      font-weight: 700;
      color: #764ba2;
      font-size: 1.1rem;
    }

    .legend-desc {
      color: #718096;
    }

    /* Winner Card */
    .winner-card {
      background: #fff;
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      position: relative;
      overflow: hidden;
    }

    .winner-card-bg {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      opacity: 0.1;
    }

    .winner-card.gradient-gold .winner-card-bg {
      background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    }

    .winner-card.gradient-green .winner-card-bg {
      background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .winner-card.gradient-blue .winner-card-bg {
      background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    }

    .winner-card.gradient-orange .winner-card-bg {
      background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
    }

    .winner-card-content {
      position: relative;
      z-index: 1;
      text-align: center;
    }

    .winner-crown {
      font-size: 4rem;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }

    .winner-badge {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .winner-rank {
      font-size: 2rem;
      font-weight: 700;
    }

    .winner-label {
      font-size: 1.25rem;
      font-weight: 600;
      opacity: 0.9;
    }

    .winner-name {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .winner-score-container {
      margin: 1.5rem 0;
    }

    .winner-score-value {
      font-size: 3.5rem;
      font-weight: 700;
      line-height: 1;
    }

    .winner-score-label {
      font-size: 1rem;
      opacity: 0.8;
    }

    /* Sample Info */
    .sample-info {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      font-size: 1rem;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .sample-layanan {
      background: rgba(255,255,255,0.2);
      padding: 0.25rem 0.75rem;
      border-radius: 5px;
      font-weight: 600;
    }

    /* Calculation Tables */
    .calculation-table {
      margin-top: 1rem;
    }

    .calc-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .calc-table thead th {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 1rem;
      font-weight: 600;
      text-align: left;
    }

    .calc-table tbody td {
      padding: 1rem;
      border-bottom: 1px solid #e2e8f0;
    }

    .calc-table tbody tr:last-child td {
      border-bottom: none;
    }

    .calc-row:hover {
      background: #f7fafc;
    }

    .calc-row-total {
      background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%) !important;
      font-weight: 700;
    }

    .kriteria-badge-sm {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      padding: 0.25rem 0.5rem;
      border-radius: 5px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .bobot-original {
      font-weight: 600;
      color: #4a5568;
    }

    .bobot-normalized {
      font-weight: 700;
      color: #764ba2;
      font-size: 1rem;
    }

    .calc-equals {
      display: block;
      font-size: 0.75rem;
      color: #718096;
      font-style: italic;
    }

    .calc-variable-wi {
      background: #e2e8f0;
      padding: 0.25rem 0.5rem;
      border-radius: 5px;
      font-weight: 600;
      color: #764ba2;
    }

    .calc-variable-ui {
      background: #feebc8;
      padding: 0.25rem 0.5rem;
      border-radius: 5px;
      font-weight: 600;
      color: #c05621;
    }

    .calc-result {
      font-size: 0.9rem;
    }

    .calc-total-result {
      font-size: 1.25rem;
      font-weight: 700;
      color: #276749;
    }

    /* Result Step */
    .result-step {
      background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%) !important;
      border-left-color: #276749 !important;
    }

    .step-badge-success {
      background: linear-gradient(135deg, #276749 0%, #22543d 100%) !important;
    }

    .final-result {
      text-align: center;
      padding: 1rem;
    }

    .result-label {
      font-size: 1.1rem;
      color: #fff;
      margin-bottom: 1rem;
    }

    .result-value {
      margin: 1rem 0;
    }

    .result-number {
      font-size: 3.5rem;
      font-weight: 700;
      color: #fff;
      line-height: 1;
    }

    .result-rank {
      font-size: 1.25rem;
      color: rgba(255,255,255,0.9);
      font-weight: 600;
    }

    /* All Results Grid */
    .all-results-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
      margin-top: 1rem;
    }

    .result-mini-card {
      background: #fff;
      padding: 1rem;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }

    .result-mini-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }

    .result-mini-rank {
      font-size: 0.875rem;
      color: #718096;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .result-mini-name {
      font-size: 0.9rem;
      color: #4a5568;
      font-weight: 600;
      margin-bottom: 0.5rem;
      line-height: 1.2;
    }

    .result-mini-score {
      font-size: 1.5rem;
      font-weight: 700;
      color: #764ba2;
    }

    /* Rankings List */
    .rankings-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .ranking-card {
      background: #fff;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .ranking-card::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
    }

    .ranking-card.ranking-winner::before {
      background: linear-gradient(180deg, #f6ad55 0%, #ed8936 100%);
    }

    .ranking-card:not(.ranking-winner)::before {
      background: linear-gradient(180deg, #4a5568 0%, #2d3748 100%);
    }

    .ranking-card:hover {
      transform: translateX(10px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .ranking-card-left {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .ranking-number {
      width: 60px;
      height: 60px;
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
    }

    .ranking-number.ranking-1 {
      background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
      animation: pulse-glow 2s infinite;
    }

    @keyframes pulse-glow {
      0%, 100% { box-shadow: 0 0 0 0 rgba(246, 173, 85, 0.7); }
      50% { box-shadow: 0 0 0 10px rgba(246, 173, 85, 0); }
    }

    .ranking-number.top3 {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
    }

    .ranking-number.other {
      background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
    }

    .ranking-info {
      flex: 1;
    }

    .ranking-name {
      font-size: 1.25rem;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 0.25rem;
    }

    .ranking-medal {
      background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
      color: #fff;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.875rem;
      font-weight: 600;
    }

    .ranking-card-right {
      flex-shrink: 0;
    }

    .ranking-score-container {
      text-align: right;
      min-width: 150px;
    }

    .ranking-score-value {
      font-size: 2rem;
      font-weight: 700;
      color: #4a5568;
      margin-bottom: 0.5rem;
    }

    .ranking-score-bar {
      height: 8px;
      background: #e2e8f0;
      border-radius: 10px;
      overflow: hidden;
    }

    .ranking-score-fill {
      height: 100%;
      background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
      border-radius: 10px;
      transition: width 1s ease;
    }

    /* Details Section */
    .ranking-details {
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 2px dashed #e2e8f0;
    }

    .ranking-toggle {
      width: 100%;
      padding: 0.75rem 1rem;
      background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
      border: none;
      border-radius: 10px;
      color: #4a5568;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .ranking-toggle:hover {
      background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
    }

    .ranking-toggle i {
      transition: transform 0.3s ease;
    }

    .ranking-toggle[aria-expanded="true"] i {
      transform: rotate(180deg);
    }

    .ranking-details-content {
      margin-top: 1rem;
    }

    .details-table-container {
      background: #f7fafc;
      border-radius: 15px;
      padding: 1rem;
    }

    .details-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .details-table thead th {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      padding: 1rem;
      font-weight: 600;
      text-align: left;
    }

    .details-table thead th:first-child {
      border-radius: 15px 0 0 0;
    }

    .details-table thead th:last-child {
      border-radius: 0 15px 0 0;
    }

    .detail-row {
      background: #fff;
      transition: all 0.2s ease;
    }

    .detail-row:hover {
      background: #f7fafc;
      transform: scale(1.02);
    }

    .details-table td {
      padding: 1rem;
      border-bottom: 1px solid #e2e8f0;
    }

    .kriteria-badge {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
      color: #fff;
      padding: 0.25rem 0.5rem;
      border-radius: 5px;
      font-weight: 700;
      font-size: 0.875rem;
    }

    .kriteria-name {
      color: #4a5568;
      font-weight: 500;
    }

    .nilai-badge {
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .nilai-badge.nilai-0 { background: #fed7d7; color: #c53030; }
    .nilai-badge.nilai-1 { background: #feebc8; color: #c05621; }
    .nilai-badge.nilai-2 { background: #fefcbf; color: #d69e2e; }
    .nilai-badge.nilai-3 { background: #c6f6d5; color: #2f855a; }
    .nilai-badge.nilai-4 { background: #9ae6b4; color: #276749; }

    .bobot-badge {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      padding: 0.25rem 0.5rem;
      border-radius: 5px;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .kontribusi-value {
      color: #764ba2;
      font-size: 1.1rem;
    }

    .detail-row-total {
      background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
    }

    .detail-row-total td {
      padding: 1rem;
      font-weight: 700;
      color: #276749;
      border-bottom: none;
    }

    .detail-row-total td:first-child {
      border-radius: 0 0 0 15px;
    }

    .detail-row-total td:last-child {
      border-radius: 0 0 15px 0;
    }

    .total-value {
      font-size: 1.25rem;
      font-weight: 700;
    }

    /* Stats Summary */
    .stats-summary {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1rem;
      margin-top: 2rem;
    }

    .stat-card {
      background: #fff;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
    }

    .stat-icon-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-icon-success {
      background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .stat-icon-info {
      background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    }

    .stat-content {
      flex: 1;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #2d3748;
      line-height: 1;
    }

    .stat-label {
      font-size: 0.875rem;
      color: #718096;
    }

    /* Particles */
    .winner-particles {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .particle {
      position: absolute;
      width: 10px;
      height: 10px;
      background: rgba(255,255,255,0.6);
      border-radius: 50%;
      animation: float-up 3s infinite;
    }

    .particle:nth-child(1) {
      left: 20%;
      animation-delay: 0s;
    }

    .particle:nth-child(2) {
      left: 50%;
      animation-delay: 1s;
    }

    .particle:nth-child(3) {
      left: 80%;
      animation-delay: 2s;
    }

    @keyframes float-up {
      0% {
        bottom: -20px;
        opacity: 0;
      }
      50% {
        opacity: 1;
      }
      100% {
        bottom: 100%;
        opacity: 0;
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .smart-header-content {
        flex-direction: column;
        text-align: center;
      }

      .smart-header-left {
        flex-direction: column;
        text-align: center;
      }

      .smart-badges {
        justify-content: center;
      }

      .smart-title {
        font-size: 1.5rem;
      }

      .winner-name {
        font-size: 1.75rem;
      }

      .winner-score-value {
        font-size: 2.5rem;
      }

      .ranking-card {
        padding: 1rem;
      }

      .ranking-card-left {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
      }

      .ranking-score-container {
        min-width: auto;
        text-align: center;
      }

      .ranking-score-value {
        font-size: 1.5rem;
      }

      .details-table {
        font-size: 0.875rem;
      }

      .details-table thead th,
      .details-table td {
        padding: 0.5rem;
      }

      .formula-equation {
        font-size: 1.25rem;
      }

      .legend-item {
        font-size: 0.875rem;
      }

      .stats-summary {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <script>
    AOS.init({
      duration: 1000,
      easing: 'ease-out-cubic',
      once: true,
      offset: 50
    });

    // Toggle Details Function
    function toggleDetails(id, button) {
      var detailsDiv = document.getElementById('details-' + id);
      var icon = document.getElementById('icon-' + id);
      var span = button.querySelector('span');

      if (detailsDiv.style.display === 'none') {
        detailsDiv.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        span.textContent = 'Tutup Detail Per Kriteria';
      } else {
        detailsDiv.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        span.textContent = 'Lihat Detail Per Kriteria';
      }
    }
  </script>

</body>

</html>
