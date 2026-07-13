<?php
$responden = $data['responden'];
$hasil_smart = $data['hasil_smart'];
$normalized_weights = $data['normalized_weights'];
?>
<?php $page_title = 'Analisis SMART - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="card-gov !bg-gradient-to-br !from-gov-blue-800 !to-gov-blue-950 !text-white mb-6">
  <div class="flex items-center justify-between flex-wrap gap-4">
    <div class="flex items-center gap-4">
      <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/15 text-3xl"><i class="fas fa-brain"></i></div>
      <div>
        <h1 class="font-serif text-2xl font-bold">Analisis SMART</h1>
        <p class="text-white/70 text-sm mb-2">Simple Multi-Attribute Rating Technique</p>
        <div class="flex flex-wrap gap-2">
          <span class="text-xs bg-white/15 rounded-full px-3 py-1"><i class="fas fa-users mr-1"></i><?= htmlspecialchars($responden['nama_lengkap']) ?></span>
          <span class="text-xs bg-white/15 rounded-full px-3 py-1"><i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($responden['pekerjaan']) ?></span>
          <span class="text-xs bg-white/15 rounded-full px-3 py-1"><i class="fas fa-birthday-cake mr-1"></i><?= $responden['usia'] ?> Tahun</span>
        </div>
      </div>
    </div>
    <a href="index.php?controller=penilaian&action=index" class="btn-gov !bg-white/15 !text-white !shadow-none border border-white/30 hover:!bg-white/25">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>
</div>

<?php if (!empty($hasil_smart)):
  $sample_hasil = $hasil_smart[0];
  $total_bobot_real = 0;
  foreach ($sample_hasil['detail_kriteria'] as $k) {
    foreach ($data['penilaians'] as $p) {
      if ($p['id_kriteria'] == $k['id_kriteria']) {
        foreach ($kriterias ?? [] as $kr) {
          if ($kr['id_kriteria'] == $k['id_kriteria']) { $total_bobot_real = $kr['bobot']; break 2; }
        }
        break;
      }
    }
  }
?>
  <div class="card-gov mb-6">
    <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-calculator text-gov-blue-700 mr-1"></i> Perhitungan Metode SMART - Data Nyata</h3>

    <div class="rounded-gov bg-gov-blue-100/60 text-gov-blue-900 p-3 mb-5 text-sm">
      <i class="fas fa-info-circle mr-1"></i> <strong>Contoh Perhitungan untuk:</strong> <?= htmlspecialchars($sample_hasil['nama_layanan']) ?>
    </div>

    <p class="text-xs font-bold text-gov-blue-700 uppercase mb-2">Langkah 1: Normalisasi Bobot</p>
    <p class="text-sm text-slate-500 mb-3">Wi = bobot_kriteria / Σ(bobot_semua) — Total Bobot: <strong><?= $total_bobot_real ?>%</strong></p>
    <div class="table-gov-wrap mb-6">
      <div class="table-gov-scroll">
        <table class="table-gov">
          <thead><tr><th>Kriteria</th><th>Bobot Asli</th><th>Bobot Normalisasi (Wi)</th></tr></thead>
          <tbody>
            <?php foreach ($sample_hasil['detail_kriteria'] as $detail):
              $bobot_asli = 0;
              foreach ($kriterias ?? [] as $kr) { if ($kr['id_kriteria'] == $detail['id_kriteria']) { $bobot_asli = $kr['bobot']; break; } }
              $bobot_norm = $normalized_weights[$detail['id_kriteria']] ?? 0;
            ?>
              <tr>
                <td><span class="badge-gov-primary"><?= htmlspecialchars($detail['kode_kriteria']) ?></span></td>
                <td class="text-center"><?= $bobot_asli ?>%</td>
                <td class="text-center"><strong class="text-gov-blue-700"><?= number_format($bobot_norm, 4) ?></strong> <span class="text-xs text-slate-400">= <?= $bobot_asli ?> / <?= $total_bobot_real ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <p class="text-xs font-bold text-gov-blue-700 uppercase mb-3">Langkah 2 & 3: Hitung Kontribusi (Ki = Wi × Ui)</p>
    <div class="table-gov-wrap mb-6">
      <div class="table-gov-scroll">
        <table class="table-gov">
          <thead><tr><th>Kriteria</th><th>Wi</th><th>Ui</th><th>Kontribusi (Ki)</th></tr></thead>
          <tbody>
            <?php
              $total_kontribusi_sample = 0;
              foreach ($sample_hasil['detail_kriteria'] as $detail):
                $bobot_norm = $normalized_weights[$detail['id_kriteria']] ?? 0;
                $nilai_util = $detail['nilai_utility'];
                $kontribusi = $bobot_norm * $nilai_util;
                $total_kontribusi_sample += $kontribusi;
            ?>
              <tr>
                <td><span class="badge-gov-primary"><?= htmlspecialchars($detail['kode_kriteria']) ?></span> <span class="text-xs text-slate-400"><?= htmlspecialchars($detail['nama_kriteria']) ?></span></td>
                <td class="text-center"><?= number_format($bobot_norm, 4) ?></td>
                <td class="text-center"><?= number_format($nilai_util, 1) ?>%</td>
                <td class="text-center font-bold text-gov-blue-700"><?= number_format($kontribusi, 2) ?></td>
              </tr>
            <?php endforeach; ?>
            <tr class="!bg-emerald-50 font-bold">
              <td colspan="3" class="text-right">Total Kontribusi (Σ Ki)</td>
              <td class="text-center text-gov-green-700"><?= number_format($total_kontribusi_sample, 2) ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="rounded-gov-lg bg-gradient-to-br from-gov-green-700 to-emerald-900 text-white p-6 text-center mb-6">
      <p class="text-sm text-white/80 mb-2">Nilai SMART untuk Layanan "<?= htmlspecialchars($sample_hasil['nama_layanan']) ?>"</p>
      <p class="text-4xl font-bold"><?= number_format($sample_hasil['nilai_smart'], 2) ?></p>
      <p class="text-white/80 mt-1">Ranking: #<?= array_search($sample_hasil['id_alternatif'], array_column($hasil_smart, 'id_alternatif')) + 1 ?></p>
    </div>

    <p class="text-xs font-bold text-gov-blue-700 uppercase mb-3">Hasil Semua Layanan</p>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
      <?php foreach ($hasil_smart as $idx => $hasil): ?>
        <div class="rounded-gov border border-slate-200 p-3 text-center">
          <p class="text-xs text-slate-400">#<?= $idx + 1 ?></p>
          <p class="text-sm font-semibold text-slate-700 leading-tight my-1"><?= htmlspecialchars($hasil['nama_layanan']) ?></p>
          <p class="text-lg font-bold text-gov-blue-700"><?= number_format($hasil['nilai_smart'], 2) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="flex flex-wrap gap-6 justify-center mt-6 pt-5 border-t border-dashed border-slate-200 text-sm">
      <span><strong class="text-gov-blue-700">Wi</strong> = Bobot normalisasi kriteria ke-i</span>
      <span><strong class="text-gov-blue-700">Ui</strong> = Nilai utility sub-kriteria (0-100)</span>
      <span><strong class="text-gov-blue-700">Ki</strong> = Kontribusi kriteria ke-i</span>
      <span><strong class="text-gov-blue-700">Si</strong> = Nilai SMART untuk layanan ke-i</span>
    </div>
  </div>

  <?php
    $winner = $hasil_smart[0];
    $ket = $winner['nilai_smart'] >= 80 ? 'Sangat Baik' : ($winner['nilai_smart'] >= 60 ? 'Baik' : ($winner['nilai_smart'] >= 40 ? 'Cukup' : ($winner['nilai_smart'] >= 20 ? 'Kurang' : 'Sangat Kurang')));
  ?>
  <div class="card-gov !bg-gradient-to-br !from-gov-gold-400 !to-gov-gold-600 !text-gov-blue-950 text-center mb-6">
    <i class="fas fa-crown text-4xl mb-2"></i>
    <p class="font-bold uppercase tracking-wide text-sm">#1 &middot; Layanan Terbaik</p>
    <h2 class="font-serif text-3xl font-bold my-2"><?= htmlspecialchars($winner['nama_layanan']) ?></h2>
    <p class="text-4xl font-bold"><?= number_format($winner['nilai_smart'], 2) ?></p>
    <p class="text-sm opacity-80 mb-2">Nilai SMART</p>
    <span class="badge-gov" style="background:rgba(11,31,58,0.15); color:#0B1F3A;"><?= $ket ?></span>
  </div>

  <div class="space-y-4 mb-6">
    <?php foreach ($hasil_smart as $index => $hasil): $rank = $index + 1; $is_winner = $rank === 1; ?>
      <div class="card-gov <?= $is_winner ? '!border-gov-gold-400 border-2' : '' ?>">
        <div class="flex items-center justify-between flex-wrap gap-4">
          <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-gov text-white font-bold text-lg
                        <?= $is_winner ? 'bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950' : ($rank <= 3 ? 'bg-gradient-to-b from-gov-blue-600 to-gov-blue-800' : 'bg-gradient-to-b from-slate-400 to-slate-600') ?>">
              <?= $is_winner ? '<i class="fas fa-trophy"></i>' : $rank ?>
            </div>
            <div>
              <h3 class="font-bold text-slate-800"><?= htmlspecialchars($hasil['nama_layanan']) ?></h3>
              <?php if ($is_winner): ?><span class="text-xs text-gov-gold-600 font-semibold">🏆 Pemenang</span><?php endif; ?>
            </div>
          </div>
          <div class="text-right min-w-[140px]">
            <p class="text-2xl font-bold text-gov-blue-700"><?= number_format($hasil['nilai_smart'], 2) ?></p>
            <div class="bar-gov-track mt-1"><div class="bar-gov-fill" style="width: <?= $hasil['nilai_smart'] ?>%"></div></div>
          </div>
        </div>

        <div class="mt-4 pt-4 border-t border-dashed border-slate-200">
          <button class="btn-gov-ghost w-full justify-center" type="button" onclick="toggleDetails('<?= $hasil['id_alternatif'] ?>', this)">
            <i class="fas fa-chevron-down mr-2" id="icon-<?= $hasil['id_alternatif'] ?>"></i>
            <span>Lihat Detail Per Kriteria</span>
          </button>
          <div id="details-<?= $hasil['id_alternatif'] ?>" class="mt-3" style="display: none;">
            <div class="table-gov-scroll">
              <table class="table-gov">
                <thead><tr><th>#</th><th>Kriteria</th><th>Sub Kriteria</th><th>Nilai</th><th>Bobot</th><th>Kontribusi</th></tr></thead>
                <tbody>
                  <?php
                    $total_kontribusi = 0;
                    foreach ($hasil['detail_kriteria'] as $idx => $detail):
                      $bobot = $normalized_weights[$detail['id_kriteria']];
                      $kontribusi = $bobot * $detail['nilai_utility'];
                      $total_kontribusi += $kontribusi;
                  ?>
                    <tr>
                      <td><?= $idx + 1 ?></td>
                      <td><span class="badge-gov-primary"><?= htmlspecialchars($detail['kode_kriteria']) ?></span> <?= htmlspecialchars($detail['nama_kriteria']) ?></td>
                      <td><?= htmlspecialchars($detail['nama_pilihan']) ?></td>
                      <td class="text-center"><span class="badge-gov-info"><?= number_format($detail['nilai_utility'], 1) ?>%</span></td>
                      <td class="text-center"><?= number_format($bobot * 100, 1) ?>%</td>
                      <td class="text-center font-bold text-gov-blue-700"><?= number_format($kontribusi, 2) ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="!bg-emerald-50 font-bold">
                    <td colspan="5" class="text-right">Total Nilai SMART</td>
                    <td class="text-center text-gov-green-700"><?= number_format($total_kontribusi, 2) ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <div class="card-gov-stat card-gov-stat-blue">
      <div class="card-gov-stat-icon"><i class="fas fa-layer-group"></i></div>
      <p class="card-gov-stat-value"><?= count($hasil_smart) ?></p>
      <p class="card-gov-stat-label">Layanan Dinilai</p>
    </div>
    <div class="card-gov-stat card-gov-stat-green">
      <div class="card-gov-stat-icon"><i class="fas fa-chart-line"></i></div>
      <p class="card-gov-stat-value"><?= number_format($winner['nilai_smart'], 1) ?></p>
      <p class="card-gov-stat-label">Nilai Tertinggi</p>
    </div>
    <div class="card-gov-stat card-gov-stat-gold">
      <div class="card-gov-stat-icon"><i class="fas fa-star"></i></div>
      <p class="card-gov-stat-value"><?= number_format(array_sum(array_column($hasil_smart, 'nilai_smart')) / count($hasil_smart), 1) ?></p>
      <p class="card-gov-stat-label">Rata-rata</p>
    </div>
  </div>
<?php endif; ?>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  function toggleDetails(id, button) {
    const detailsDiv = document.getElementById('details-' + id);
    const icon = document.getElementById('icon-' + id);
    const span = button.querySelector('span');
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
