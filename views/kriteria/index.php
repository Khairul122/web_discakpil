<?php $page_title = 'Kelola Kriteria - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-list-ol"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Kelola Kriteria</h1>
      <p class="text-slate-500 text-sm">Manajemen Data Kriteria Penilaian DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=kriteria&action=create" class="btn-gov-primary"><i class="fas fa-plus"></i> Tambah Kriteria</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-list-ol"></i></div>
    <p class="card-gov-stat-label">Total Kriteria</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Kriteria penilaian</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-plus-circle"></i></div>
    <p class="card-gov-stat-label">Benefit</p>
    <p class="card-gov-stat-value"><?= $data['benefit_count'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Kriteria benefit</p>
  </div>
  <div class="card-gov-stat" style="--stat-c1:#475569; --stat-c2:#1e293b;">
    <div class="card-gov-stat-icon"><i class="fas fa-minus-circle"></i></div>
    <p class="card-gov-stat-label">Cost</p>
    <p class="card-gov-stat-value"><?= $data['cost_count'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Kriteria cost</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-weight-hanging"></i></div>
    <p class="card-gov-stat-label">Total Bobot</p>
    <p class="card-gov-stat-value"><?= $data['total_bobot'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Skala 1-100</p>
  </div>
</div>

<div class="search-gov-wrap">
  <form method="GET" action="index.php?controller=kriteria&action=index" class="flex flex-col sm:flex-row gap-3 w-full">
    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari berdasarkan kode, nama kriteria, atau pertanyaan..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-search"></i> Cari</button>
    <?php if (!empty($data['keyword'])): ?>
      <a href="index.php?controller=kriteria&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i></a>
    <?php endif; ?>
  </form>
</div>

<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Kode</th><th>Nama Kriteria</th><th>Pertanyaan</th><th>Bobot</th><th>Jenis</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($data['kriterias'])): ?>
          <?php $no = 1; foreach ($data['kriterias'] as $kriteria): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td><span class="badge-gov-primary"><?= htmlspecialchars($kriteria['kode_kriteria']) ?></span></td>
              <td class="font-semibold text-slate-800"><?= htmlspecialchars($kriteria['nama_kriteria']) ?></td>
              <td class="text-slate-500 text-sm">
                <?= htmlspecialchars(substr($kriteria['pertanyaan'], 0, 80)) ?><?= strlen($kriteria['pertanyaan']) > 80 ? '...' : '' ?>
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <div class="bar-gov-track w-20"><div class="bar-gov-fill" style="width: <?= $kriteria['bobot'] ?>%"></div></div>
                  <span class="text-xs font-semibold text-gov-blue-700"><?= $kriteria['bobot'] ?>%</span>
                </div>
              </td>
              <td><span class="badge-gov-<?= $kriteria['jenis'] == 'benefit' ? 'success' : 'info' ?>"><?= ucfirst($kriteria['jenis']) ?></span></td>
              <td>
                <div class="flex gap-2">
                  <a href="index.php?controller=kriteria&action=edit&id=<?= $kriteria['id_kriteria'] ?>" class="btn-gov-icon-edit" title="Edit"><i class="fas fa-edit"></i></a>
                  <button onclick="govConfirmDelete('index.php?controller=kriteria&action=delete&id=<?= $kriteria['id_kriteria'] ?>', {text:'Kriteria ini akan dihapus secara permanen!'})" class="btn-gov-icon-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7">
            <div class="empty-gov">
              <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
              <h4 class="font-bold text-slate-700 mb-1">Belum ada data kriteria</h4>
              <p class="text-slate-500 text-sm mb-4">Mulai dengan menambahkan kriteria penilaian baru</p>
              <a href="index.php?controller=kriteria&action=create" class="btn-gov-primary"><i class="fas fa-plus"></i> Tambah Kriteria</a>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
