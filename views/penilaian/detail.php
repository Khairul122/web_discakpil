<?php $page_title = 'Detail Penilaian - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<?php
  $nilai = $data['penilaian']['nilai_utility'];
  if ($nilai >= 80) { $interpretation = 'Sangat Baik'; $badgeClass = 'badge-gov-success'; }
  elseif ($nilai >= 60) { $interpretation = 'Baik'; $badgeClass = 'badge-gov-info'; }
  elseif ($nilai >= 40) { $interpretation = 'Cukup'; $badgeClass = 'badge-gov-warning'; }
  elseif ($nilai >= 20) { $interpretation = 'Kurang'; $badgeClass = 'badge-gov-warning'; }
  else { $interpretation = 'Sangat Kurang'; $badgeClass = 'badge-gov-danger'; }
?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-star"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Detail Penilaian</h1>
      <p class="text-slate-500 text-sm">Informasi lengkap data penilaian</p>
    </div>
  </div>
  <a href="index.php?controller=penilaian&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
  <div class="card-gov">
    <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Responden</p>
    <p class="text-lg font-bold text-slate-800"><?= htmlspecialchars($data['penilaian']['nama_responden']) ?></p>
  </div>
  <div class="card-gov">
    <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Layanan</p>
    <span class="badge-gov-primary"><i class="fas fa-concierge-bell"></i> <?= htmlspecialchars($data['penilaian']['nama_layanan']) ?></span>
  </div>
</div>

<div class="card-gov mb-5">
  <h3 class="font-bold text-slate-800 mb-5">Detail Penilaian</h3>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">
    <div>
      <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Kriteria Penilaian</p>
      <div class="rounded-gov border border-slate-200 p-3">
        <span class="badge-gov-primary"><?= htmlspecialchars($data['penilaian']['kode_kriteria']) ?></span>
        <p class="font-semibold text-slate-800 mt-1"><?= htmlspecialchars($data['penilaian']['nama_kriteria']) ?></p>
      </div>
    </div>
    <div>
      <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Pilihan Penilaian</p>
      <div class="rounded-gov border border-slate-200 p-3 font-semibold text-slate-800">
        <?= htmlspecialchars($data['penilaian']['nama_pilihan']) ?>
      </div>
    </div>
    <div>
      <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Nilai Utility</p>
      <div class="rounded-gov border border-slate-200 p-3">
        <span class="text-3xl font-bold text-gov-blue-700"><?= number_format($nilai, 1) ?></span><span class="text-slate-500">%</span>
        <div class="bar-gov-track mt-2"><div class="bar-gov-fill" style="width: <?= $nilai ?>%"></div></div>
      </div>
    </div>
  </div>
  <div class="flex justify-center">
    <span class="<?= $badgeClass ?> !text-sm !py-2 !px-5"><i class="fas fa-info-circle"></i> Interpretasi: <?= $interpretation ?></span>
  </div>
</div>

<div class="card-gov">
  <div class="flex items-center gap-3 mb-4">
    <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950"><i class="fas fa-lightbulb"></i></div>
    <div><h4 class="font-bold text-slate-800">Informasi Penilaian</h4><p class="text-xs text-slate-500">Detail sistem penilaian SMART</p></div>
  </div>
  <div class="space-y-3">
    <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Metode SMART</strong><p class="text-xs text-slate-500">Penilaian menggunakan metode Simple Multi-Attribute Rating Technique</p></div></div>
    <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Nilai Utility</strong><p class="text-xs text-slate-500">Nilai 0-100 yang merepresentasikan tingkat kepuasan responden</p></div></div>
    <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Interpretasi</strong><p class="text-xs text-slate-500">Nilai dikelompokkan menjadi: Sangat Kurang, Kurang, Cukup, Baik, Sangat Baik</p></div></div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>
