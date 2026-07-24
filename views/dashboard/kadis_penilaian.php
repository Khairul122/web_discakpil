<?php $page_title = 'Data Penilaian IKM (Read-Only) - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Data Penilaian IKM</h1>
      <p class="text-slate-500 text-sm">Mode Peninjauan Eksekutif (Read-Only) — DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=cetak&action=index" class="btn-gov-primary"><i class="fas fa-print"></i> Cetak Laporan PDF</a>
</div>

<!-- Info Banner Read-Only -->
<div class="mb-6 p-4 rounded-gov bg-amber-50 border-l-4 border-amber-500 text-amber-900 text-sm flex items-center gap-3 shadow-soft-raised-sm">
  <i class="fas fa-shield-alt text-xl text-amber-600"></i>
  <div>
    <strong>Akses Peninjauan Eksekutif (Read-Only):</strong> Halaman ini disajikan khusus untuk Kepala Dinas guna meninjau jawaban dan penilaian responden secara transparan tanpa mengubah/menghapus data.
  </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Total Responden</p>
    <p class="card-gov-stat-value"><?= count($data['penilaians'] ?? []) ?></p>
    <p class="card-gov-stat-sub">Responden penilai</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-clipboard-check"></i></div>
    <p class="card-gov-stat-label">Total Penilaian</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Item data terisi</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-concierge-bell"></i></div>
    <p class="card-gov-stat-label">Layanan Dievaluasi</p>
    <p class="card-gov-stat-value"><?= count($data['alternatifs'] ?? []) ?></p>
    <p class="card-gov-stat-sub">Jenis Layanan</p>
  </div>
</div>

<!-- Search & Filter Form -->
<div class="search-gov-wrap mb-6">
  <form method="GET" action="index.php" class="flex flex-col sm:flex-row gap-3 w-full">
    <input type="hidden" name="controller" value="kepalaDinas">
    <input type="hidden" name="action" value="penilaian">

    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari nama responden, pekerjaan..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <select name="id_alternatif" class="input-gov sm:w-64">
      <option value="">Semua Layanan</option>
      <?php foreach ($data['alternatifs'] as $alternatif): ?>
        <option value="<?= $alternatif['id_alternatif'] ?>" <?= ($data['filter_alternatif'] == $alternatif['id_alternatif']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($alternatif['nama_layanan']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-filter"></i> Filter</button>
  </form>
</div>

<!-- Table Data Penilaian -->
<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Responden</th>
          <th>Demografi</th>
          <th>Layanan Yang Dinilai</th>
          <th class="text-center">Aksi (Read-Only)</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($data['penilaians']) && count($data['penilaians']) > 0): ?>
          <?php $no = 1; foreach ($data['penilaians'] as $responden): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td>
                <strong class="text-slate-800 font-bold"><?= htmlspecialchars($responden['nama_responden']) ?></strong>
              </td>
              <td>
                <p class="text-xs text-slate-600">
                  <i class="fas fa-birthday-cake mr-1 text-slate-400"></i> Usia: <strong><?= $responden['usia'] ?> th</strong>
                </p>
                <p class="text-xs text-slate-600 mt-0.5">
                  <i class="fas fa-briefcase mr-1 text-slate-400"></i> Pekerjaan: <strong><?= htmlspecialchars($responden['pekerjaan']) ?></strong>
                </p>
              </td>
              <td>
                <div class="flex flex-wrap gap-1.5">
                  <?php if (!empty($responden['penilaians'])): ?>
                    <?php foreach ($responden['penilaians'] as $altItem): ?>
                      <span class="badge-gov-primary text-[11px]"><?= htmlspecialchars($altItem['nama_layanan']) ?></span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span class="text-xs text-slate-400 italic">Belum ada layanan</span>
                  <?php endif; ?>
                </div>
              </td>
              <td class="text-center">
                <a href="index.php?controller=kepalaDinas&action=detailPenilaian&id_responden=<?= $responden['id_responden'] ?>" 
                   class="btn-gov-info !py-1.5 !px-3 !text-xs inline-flex items-center gap-1.5" 
                   title="Lihat Detail Penilaian">
                  <i class="fas fa-eye"></i> Lihat Detail Rating
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">
              <div class="empty-gov">
                <i class="fas fa-folder-open text-4xl text-slate-300 mb-3"></i>
                <h4 class="font-bold text-slate-700 mb-1">Belum Ada Data Penilaian</h4>
                <p class="text-slate-500 text-sm">Tidak ditemukan data penilaian berdasarkan kata kunci filter Anda.</p>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
