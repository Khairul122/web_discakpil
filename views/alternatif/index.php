<?php $page_title = 'Kelola Layanan - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Kelola Layanan</h1>
      <p class="text-slate-500 text-sm">Manajemen Data Layanan DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=alternatif&action=create" class="btn-gov-primary">
    <i class="fas fa-plus"></i> Tambah Layanan
  </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-clipboard-list"></i></div>
    <p class="card-gov-stat-label">Total Layanan</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Layanan tersedia</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-check-circle"></i></div>
    <p class="card-gov-stat-label">Layanan Aktif</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Semua aktif</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-calendar-alt"></i></div>
    <p class="card-gov-stat-label">Periode</p>
    <p class="card-gov-stat-value"><?= date('Y') ?></p>
    <p class="card-gov-stat-sub"><?= date('F Y') ?></p>
  </div>
</div>

<div class="search-gov-wrap">
  <form method="GET" action="index.php?controller=alternatif&action=index" class="flex flex-col sm:flex-row gap-3 w-full">
    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari berdasarkan kode, nama layanan, atau keterangan..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-search"></i> Cari</button>
    <?php if (!empty($data['keyword'])): ?>
      <a href="index.php?controller=alternatif&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i></a>
    <?php endif; ?>
  </form>
</div>

<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead>
        <tr><th>No</th><th>Kode Layanan</th><th>Nama Layanan</th><th>Keterangan</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php if (!empty($data['alternatifs'])): ?>
          <?php $no = 1; foreach ($data['alternatifs'] as $alternatif): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td><span class="badge-gov-primary"><?= htmlspecialchars($alternatif['kode_alternatif']) ?></span></td>
              <td class="font-semibold text-slate-800"><?= htmlspecialchars($alternatif['nama_layanan']) ?></td>
              <td class="text-slate-500 text-sm">
                <?= htmlspecialchars(substr($alternatif['keterangan'], 0, 100)) ?><?= strlen($alternatif['keterangan']) > 100 ? '...' : '' ?>
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="index.php?controller=alternatif&action=edit&id=<?= $alternatif['id_alternatif'] ?>" class="btn-gov-icon-edit" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button onclick="govConfirmDelete('index.php?controller=alternatif&action=delete&id=<?= $alternatif['id_alternatif'] ?>', {text:'Layanan ini akan dihapus secara permanen!'})" class="btn-gov-icon-delete" title="Hapus">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5">
              <div class="empty-gov">
                <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                <h4 class="font-bold text-slate-700 mb-1">Belum ada data layanan</h4>
                <p class="text-slate-500 text-sm mb-4">Mulai dengan menambahkan layanan baru</p>
                <a href="index.php?controller=alternatif&action=create" class="btn-gov-primary"><i class="fas fa-plus"></i> Tambah Layanan</a>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
