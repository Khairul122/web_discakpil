<?php $page_title = 'Kelola Penilaian - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-clipboard-check"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Kelola Penilaian</h1>
      <p class="text-slate-500 text-sm">Manajemen Data Penilaian Layanan DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=penilaian&action=formPenilaian" class="btn-gov-success"><i class="fas fa-star"></i> Form Penilaian</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
  <div class="card-gov-stat card-gov-stat-blue">
    <div class="card-gov-stat-icon"><i class="fas fa-clipboard-list"></i></div>
    <p class="card-gov-stat-label">Total Penilaian</p>
    <p class="card-gov-stat-value"><?= $data['total'] ?? 0 ?></p>
    <p class="card-gov-stat-sub">Data penilaian</p>
  </div>
  <div class="card-gov-stat card-gov-stat-green">
    <div class="card-gov-stat-icon"><i class="fas fa-users"></i></div>
    <p class="card-gov-stat-label">Layanan Dinilai</p>
    <p class="card-gov-stat-value"><?= count($data['alternatifs'] ?? []) ?></p>
    <p class="card-gov-stat-sub">Layanan aktif</p>
  </div>
  <div class="card-gov-stat card-gov-stat-gold">
    <div class="card-gov-stat-icon"><i class="fas fa-chart-line"></i></div>
    <p class="card-gov-stat-label">Rata-rata</p>
    <p class="card-gov-stat-value"><?= $data['total'] > 0 ? round($data['total'] / max(count($data['alternatifs'] ?? []), 1), 1) : 0 ?></p>
    <p class="card-gov-stat-sub">Penilaian per layanan</p>
  </div>
</div>

<div class="flex flex-wrap gap-3 mb-6">
  <button onclick="calculateAllSMART()" class="btn-gov-success"><i class="fas fa-calculator"></i> Hitung SMART Semua</button>
  <a href="index.php?controller=hasil&action=index" class="btn-gov-gold"><i class="fas fa-chart-bar"></i> Lihat Hasil Perhitungan</a>
</div>

<div class="search-gov-wrap">
  <form method="GET" action="index.php?controller=penilaian&action=index" class="flex flex-col sm:flex-row gap-3 w-full">
    <div class="relative flex-1">
      <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      <input type="text" name="keyword" class="input-gov !pl-11" placeholder="Cari penilaian..." value="<?= htmlspecialchars($data['keyword'] ?? '') ?>">
    </div>
    <select name="id_alternatif" class="input-gov sm:w-64">
      <option value="">Semua Layanan</option>
      <?php foreach ($data['alternatifs'] as $alternatif): ?>
        <option value="<?= $alternatif['id_alternatif'] ?>" <?= $data['filter_alternatif'] == $alternatif['id_alternatif'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($alternatif['nama_layanan']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-gov-primary"><i class="fas fa-filter"></i> Filter</button>
  </form>
</div>

<div class="table-gov-wrap">
  <div class="table-gov-scroll">
    <table class="table-gov">
      <thead><tr><th>No</th><th>Responden</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if (!empty($data['penilaians']) && count($data['penilaians']) > 0): ?>
          <?php $no = 1; foreach ($data['penilaians'] as $responden): ?>
            <tr>
              <td><span class="row-number-gov"><?= $no++ ?></span></td>
              <td>
                <strong class="text-slate-800"><?= htmlspecialchars($responden['nama_responden']) ?></strong>
                <p class="text-xs text-slate-500 mt-0.5">
                  <i class="fas fa-birthday-cake mr-1"></i><?= $responden['usia'] ?> tahun
                  <span class="mx-1">|</span>
                  <i class="fas fa-briefcase mr-1"></i><?= htmlspecialchars($responden['pekerjaan']) ?>
                </p>
              </td>
              <td>
                <div class="flex gap-2">
                  <a href="index.php?controller=penilaian&action=detailSmart&id_responden=<?= $responden['id_responden'] ?>" class="btn-gov-icon-view" title="Lihat Analisis SMART"><i class="fas fa-chart-line"></i></a>
                  <button onclick="confirmDeleteResponden(<?= $responden['id_responden'] ?>)" class="btn-gov-icon-delete" title="Hapus Semua Penilaian"><i class="fas fa-trash"></i></button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3">
            <div class="empty-gov">
              <i class="fas fa-clipboard text-4xl text-slate-300 mb-4"></i>
              <h4 class="font-bold text-slate-700 mb-1">Belum ada data penilaian</h4>
              <p class="text-slate-500 text-sm mb-4">Mulai dengan mengisi form penilaian layanan</p>
              <a href="index.php?controller=penilaian&action=formPenilaian" class="btn-gov-success"><i class="fas fa-star"></i> Isi Form Penilaian</a>
            </div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  function confirmDeleteResponden(id_responden) {
    govConfirmDelete('index.php?controller=responden&action=delete&id=' + id_responden, {
      title: 'Hapus Semua Penilaian?',
      text: 'Semua data penilaian dari responden ini akan dihapus dan tidak dapat dikembalikan!'
    });
  }

  function calculateAllSMART() {
    Swal.fire({
      title: 'Hitung SMART Semua Responden?',
      text: 'Sistem akan menghitung nilai SMART untuk semua responden dan menyimpannya ke tabel hasil_akhir.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#15803D',
      cancelButtonColor: '#2456A6',
      confirmButtonText: 'Ya, Hitung Semua!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Menghitung SMART...',
          text: 'Mohon tunggu, sistem sedang memproses data semua responden',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          willOpen: () => Swal.showLoading()
        });

        fetch('index.php?controller=penilaian&action=calculateAllSMART', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              if (data.has_warnings && data.errors) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Perhitungan Selesai dengan Warning',
                  html: `<p>Hasil SMART berhasil dihitung: <strong>${data.total_responden}</strong> Responden, <strong>${data.total_hasil}</strong> Hasil.</p>
                    <details style="margin-top:10px;text-align:left"><summary style="cursor:pointer">Lihat Detail Error</summary>
                    <ul style="font-size:0.85rem">${data.errors.map(err => `<li>${err}</li>`).join('')}</ul></details>`,
                  confirmButtonText: 'Lihat Hasil',
                  confirmButtonColor: '#B45309'
                }).then((r) => { if (r.isConfirmed) window.location.href = 'index.php?controller=hasil&action=index'; });
              } else {
                Swal.fire({
                  icon: 'success',
                  title: 'Perhitungan Berhasil!',
                  html: `<p>${data.total_responden} Responden, ${data.total_hasil} Hasil Perhitungan tersimpan.</p>`,
                  confirmButtonText: 'Lihat Hasil',
                  confirmButtonColor: '#15803D'
                }).then((r) => { if (r.isConfirmed) window.location.href = 'index.php?controller=hasil&action=index'; });
              }
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Perhitungan Gagal!',
                text: data.message || 'Terjadi kesalahan saat menghitung SMART',
                confirmButtonColor: '#B91C1C'
              });
            }
          })
          .catch(() => {
            Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan!', text: 'Gagal terhubung ke server.', confirmButtonColor: '#B91C1C' });
          });
      }
    });
  }
</script>
