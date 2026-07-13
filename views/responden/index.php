<?php $page_title = 'Kelola Responden - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center gap-3 mb-6">
  <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
    <i class="fas fa-users"></i>
  </div>
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Kelola Responden</h1>
    <p class="text-slate-500 text-sm">Manajemen Data Responden DISDUKCAPIL Kota Padang</p>
  </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Total Responden</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Responden terdaftar</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-birthday-cake"></i></div>
    <p class="card-gov-stat-label">Rata-rata Usia</p>
    <p class="card-gov-stat-value"><?= $data['avg_age'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Tahun</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-briefcase"></i></div>
    <p class="card-gov-stat-label">Jenis Pekerjaan</p>
    <p class="card-gov-stat-value"><?= count($data['total_by_pekerjaan'] ?? []) ?></p>
    <p class="card-gov-stat-sub">Kategori pekerjaan</p>
  </div>
</div>

<div class="search-gov-wrap">
  <form method="GET" action="index.php?controller=responden&action=index" class="flex flex-col sm:flex-row gap-3 w-full">
    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari responden berdasarkan nama atau pekerjaan..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-search"></i> Cari</button>
  </form>
</div>

<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Nama Lengkap</th><th>Usia</th><th>Pekerjaan</th><th>Tanggal Isi</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($data['respondens'])): ?>
          <?php $no = 1; foreach ($data['respondens'] as $responden): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td class="font-semibold text-slate-800"><?= htmlspecialchars($responden['nama_lengkap']) ?></td>
              <td><span class="font-bold text-gov-blue-700"><?= $responden['usia'] ?></span> <span class="text-xs text-slate-500">Tahun</span></td>
              <td><span class="badge-gov-primary"><i class="fas fa-briefcase"></i> <?= htmlspecialchars($responden['pekerjaan']) ?></span></td>
              <td class="text-sm text-slate-500"><i class="fas fa-calendar-alt mr-1"></i><?= date('d/m/Y H:i', strtotime($responden['tanggal_isi'])) ?></td>
              <td>
                <div class="flex gap-2">
                  <a href="index.php?controller=responden&action=detail&id=<?= $responden['id_responden'] ?>" class="btn-gov-icon-view" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                  <button onclick="govConfirmDelete('index.php?controller=responden&action=delete&id=<?= $responden['id_responden'] ?>', {text:'Data responden dan semua penilaiannya akan dihapus secara permanen!'})" class="btn-gov-icon-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6">
            <div class="empty-gov">
              <i class="fas fa-users text-4xl text-slate-300 mb-4"></i>
              <h4 class="font-bold text-slate-700 mb-1">Belum ada data responden</h4>
              <p class="text-slate-500 text-sm">Data responden akan muncul setelah mengisi form penilaian</p>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
