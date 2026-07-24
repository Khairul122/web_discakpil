<?php $page_title = 'Detail Penilaian Responden (Read-Only) - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <a href="index.php?controller=kepalaDinas&action=penilaian" class="btn-gov-secondary !p-2.5" title="Kembali">
      <i class="fas fa-arrow-left"></i>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Detail Penilaian Responden</h1>
      <p class="text-slate-500 text-sm">Mode Peninjauan Eksekutif (Read-Only) — DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=kepalaDinas&action=penilaian" class="btn-gov-secondary"><i class="fas fa-list"></i> Kembali ke Daftar</a>
</div>

<!-- Card Profile Responden -->
<div class="card-gov mb-6 border-l-4 border-gov-blue-800">
  <h3 class="font-bold text-slate-800 text-lg mb-3 flex items-center gap-2">
    <i class="fas fa-user-circle text-gov-blue-800"></i> Profil Responden
  </h3>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
    <div class="p-3 bg-slate-50 rounded-gov border border-slate-100">
      <span class="text-slate-400 block text-xs font-semibold uppercase">Nama Lengkap</span>
      <strong class="text-slate-800 text-base"><?= htmlspecialchars($data['responden']['nama_lengkap'] ?? '-') ?></strong>
    </div>
    <div class="p-3 bg-slate-50 rounded-gov border border-slate-100">
      <span class="text-slate-400 block text-xs font-semibold uppercase">Usia</span>
      <strong class="text-slate-800 text-base"><?= htmlspecialchars($data['responden']['usia'] ?? '-') ?> Tahun</strong>
    </div>
    <div class="p-3 bg-slate-50 rounded-gov border border-slate-100">
      <span class="text-slate-400 block text-xs font-semibold uppercase">Pekerjaan</span>
      <strong class="text-slate-800 text-base"><?= htmlspecialchars($data['responden']['pekerjaan'] ?? '-') ?></strong>
    </div>
  </div>
</div>

<!-- Detail Jawaban Per Kriteria -->
<div class="card-gov mb-6">
  <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
    <i class="fas fa-star text-gov-gold-600"></i> Rincian Jawaban & Utility Rating
  </h3>

  <div class="table-gov-wrap">
    <div class="table-gov-scroll">
      <table class="table-gov">
        <thead>
          <tr>
            <th>No</th>
            <th>Layanan (Alternatif)</th>
            <th>Kode Kriteria</th>
            <th>Nama Kriteria</th>
            <th>Jawaban / Sub Kriteria</th>
            <th class="text-center">Nilai Utility ($u_j$)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($data['penilaians'])): ?>
            <?php $no = 1; foreach ($data['penilaians'] as $row): ?>
              <tr>
                <td><span class="row-number-gov"><?= $no++ ?></span></td>
                <td><span class="badge-gov-primary"><?= htmlspecialchars($row['nama_layanan']) ?></span></td>
                <td><span class="badge-gov-info font-mono"><?= htmlspecialchars($row['kode_kriteria']) ?></span></td>
                <td><strong><?= htmlspecialchars($row['nama_kriteria']) ?></strong></td>
                <td><?= htmlspecialchars($row['nama_pilihan']) ?></td>
                <td class="text-center">
                  <span class="badge-gov-success font-bold"><?= number_format($row['nilai_utility'], 0) ?>%</span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-6 text-slate-400">
                Belum ada rincian data penilaian untuk responden ini.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
