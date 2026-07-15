<?php $page_title = 'Laporan Kepuasan Masyarakat - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center gap-3 mb-6">
  <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
    <i class="fas fa-chart-bar"></i>
  </div>
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Laporan Kepuasan Masyarakat</h1>
    <p class="text-slate-500 text-sm">DISDUKCAPIL Kota Padang</p>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Total Responden</p>
    <p class="card-gov-stat-value"><?= $data['statistics']['total_responden'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Orang</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-star"></i></div>
    <p class="card-gov-stat-label">Rata-rata SMART</p>
    <p class="card-gov-stat-value"><?= number_format($data['statistics']['rerata_smart'] ?? 0, 2) ?></p>
    <p class="card-gov-stat-sub">Poin</p>
  </div>
</div>

<div class="card-gov mb-6">
  <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-file-pdf text-gov-blue-700 mr-1"></i> Generate Laporan</h3>
  <button onclick="generatePDF()" class="btn-gov-primary w-full !py-4 text-base">
    <i class="fas fa-file-pdf"></i> <strong>GENERATE PDF</strong>
  </button>
  <p class="text-xs text-slate-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Dokumen resmi laporan kepuasan masyarakat DISDUKCAPIL Kota Padang</p>
</div>

<div class="card-gov">
  <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-eye text-gov-blue-700 mr-1"></i> Preview Data</h3>

  <?php
  $laporan_data = $data['laporan_data'];
  $alternatifs = $laporan_data['alternatifs'] ?? [];
  $responden_data = $laporan_data['responden_data'] ?? [];
  $nilai_per_responden_alternatif = $laporan_data['nilai_per_responden_alternatif'] ?? [];
  ?>

  <?php if (!empty($responden_data)): ?>
    <div class="table-gov-wrap">
      <div class="table-gov-scroll" style="max-height: 600px;">
        <table class="table-gov">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Responden</th>
              <?php foreach ($alternatifs as $alt): ?>
                <th><?= htmlspecialchars($alt['kode_alternatif']) ?></th>
              <?php endforeach; ?>
              <th>Hasil SMART</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $total_nilai = 0;
            $jumlah_alternatif = count($alternatifs);
            foreach ($responden_data as $responden):
              $id_responden = $responden['id_responden'];
              $nilai_terbaik = $responden['nilai_smart_terbaik'];
              $total_nilai += $nilai_terbaik;
            ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= htmlspecialchars($responden['nama_lengkap']) ?></td>
                <?php foreach ($alternatifs as $alt):
                  $kode_alt = $alt['kode_alternatif'];
                  $nilai = $nilai_per_responden_alternatif[$id_responden][$kode_alt] ?? 0;
                ?>
                  <td class="text-center"><?= number_format($nilai, 2, ',', '.') ?></td>
                <?php endforeach; ?>
                <td class="text-center font-bold text-gov-blue-700"><?= number_format($nilai_terbaik, 2, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>

            <?php
            $rerata_smart = $data['statistics']['rerata_smart'] ?? 0;
            $kesimpulan = ($rerata_smart >= 80) ? 'SANGAT BAIK' : (($rerata_smart >= 60) ? 'BAIK' : 'CUKUP');
            ?>
            <tr class="!bg-gov-blue-100 font-bold">
              <td colspan="2">Total Nilai</td>
              <td colspan="<?= $jumlah_alternatif ?>" class="text-right"><?= number_format($total_nilai, 2, ',', '.') ?></td>
              <td class="text-center"><?= number_format($total_nilai, 2, ',', '.') ?></td>
            </tr>
            <tr class="!bg-gov-blue-100 font-bold">
              <td colspan="2">Rata-rata Nilai</td>
              <td colspan="<?= $jumlah_alternatif ?>" class="text-right"><?= number_format($rerata_smart, 2, ',', '.') ?></td>
              <td class="text-center"><?= number_format($rerata_smart, 2, ',', '.') ?></td>
            </tr>
            <tr class="!bg-gov-blue-100 font-bold">
              <td colspan="2">Kesimpulan</td>
              <td colspan="<?= $jumlah_alternatif ?>" class="text-center"><?= $kesimpulan ?></td>
              <td class="text-center"><?= $kesimpulan ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  <?php else: ?>
    <div class="empty-gov">
      <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
      <p class="text-slate-500">Tidak ada data laporan</p>
    </div>
  <?php endif; ?>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  function generatePDF() {
    Swal.fire({
      title: 'Generate PDF Laporan?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#2456A6',
      cancelButtonColor: '#64748b',
      confirmButtonText: '<i class="fas fa-file-pdf mr-2"></i>Ya, Generate!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Generating PDF...',
          html: '<i class="fas fa-spinner fa-spin fa-3x" style="color:#2456A6"></i><br><br>Mohon tunggu sebentar...',
          showConfirmButton: false,
          allowOutsideClick: false
        });
        window.location.href = 'index.php?controller=laporan&action=generatePDF';
      }
    });
  }
</script>
