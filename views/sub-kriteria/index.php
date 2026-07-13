<?php $page_title = 'Kelola Sub Kriteria - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-layer-group"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Kelola Sub Kriteria</h1>
      <p class="text-slate-500 text-sm">Manajemen Data Sub Kriteria Penilaian DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=subKriteria&action=create" class="btn-gov-primary"><i class="fas fa-plus"></i> Tambah Sub Kriteria</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-layer-group"></i></div>
    <p class="card-gov-stat-label">Total Sub Kriteria</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Pilihan penilaian</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-list-ol"></i></div>
    <p class="card-gov-stat-label">Total Kriteria</p>
    <p class="card-gov-stat-value"><?= count($data['kriterias'] ?? []) ?></p>
    <p class="card-gov-stat-sub">Kriteria penilaian</p>
  </div>
</div>

<div class="search-gov-wrap">
  <form method="GET" action="index.php?controller=subKriteria&action=index" class="flex flex-col sm:flex-row gap-3 w-full">
    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari sub kriteria..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <select name="id_kriteria" class="input-gov sm:w-64">
      <option value="">Semua Kriteria</option>
      <?php foreach ($data['kriterias'] as $kriteria): ?>
        <option value="<?= $kriteria['id_kriteria'] ?>" <?= $data['filter_kriteria'] == $kriteria['id_kriteria'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($kriteria['kode_kriteria'] . ' - ' . $kriteria['nama_kriteria']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-filter"></i> Filter</button>
  </form>
</div>

<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Kriteria</th><th>Nama Pilihan</th><th>Nilai Utility</th><th>Visualisasi</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($data['sub_kriterias'])): ?>
          <?php $no = 1; foreach ($data['sub_kriterias'] as $sub_kriteria): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td>
                <span class="badge-gov-primary"><?= htmlspecialchars($sub_kriteria['kode_kriteria']) ?></span>
                <p class="text-xs text-slate-500 mt-1"><?= htmlspecialchars($sub_kriteria['nama_kriteria']) ?></p>
              </td>
              <td class="font-semibold text-slate-800"><?= htmlspecialchars($sub_kriteria['nama_pilihan']) ?></td>
              <td><span class="text-lg font-bold text-gov-blue-700"><?= number_format($sub_kriteria['nilai_utility'], 1) ?></span><span class="text-xs text-slate-500">%</span></td>
              <td><div class="bar-gov-track w-32"><div class="bar-gov-fill" style="width: <?= $sub_kriteria['nilai_utility'] ?>%"></div></div></td>
              <td>
                <div class="flex gap-2">
                  <a href="index.php?controller=subKriteria&action=edit&id=<?= $sub_kriteria['id_sub'] ?>" class="btn-gov-icon-edit" title="Edit"><i class="fas fa-edit"></i></a>
                  <button onclick="govConfirmDelete('index.php?controller=subKriteria&action=delete&id=<?= $sub_kriteria['id_sub'] ?>', {text:'Sub kriteria ini akan dihapus secara permanen!'})" class="btn-gov-icon-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6">
            <div class="empty-gov">
              <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
              <h4 class="font-bold text-slate-700 mb-1">Belum ada data sub kriteria</h4>
              <p class="text-slate-500 text-sm mb-4">Mulai dengan menambahkan sub kriteria penilaian baru</p>
              <a href="index.php?controller=subKriteria&action=create" class="btn-gov-primary"><i class="fas fa-plus"></i> Tambah Sub Kriteria</a>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
