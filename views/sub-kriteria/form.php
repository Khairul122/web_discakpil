<?php $page_title = ($data['form_type'] == 'create' ? 'Tambah' : 'Edit') . ' Sub Kriteria - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus-circle' : 'edit' ?>"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800"><?= $data['form_type'] == 'create' ? 'Tambah Sub Kriteria Baru' : 'Edit Sub Kriteria' ?></h1>
      <p class="text-slate-500 text-sm"><?= $data['form_type'] == 'create' ? 'Isi form untuk menambahkan sub kriteria baru' : 'Perbarui data sub kriteria' ?></p>
    </div>
  </div>
  <a href="index.php?controller=subKriteria&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card-gov">
    <form method="POST" action="<?= $data['form_action'] ?>" id="subKriteriaForm" data-loading-label="Menyimpan...">
      <?php if ($data['form_type'] == 'edit'): ?>
        <input type="hidden" name="id_sub" value="<?= $data['sub_kriteria']['id_sub'] ?>">
      <?php endif; ?>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-list-ol text-gov-blue-700"></i> Kriteria <span class="text-gov-maroon-700">*</span></label>
        <select class="input-gov" id="id_kriteria" name="id_kriteria" required>
          <option value="">Pilih Kriteria</option>
          <?php foreach ($data['kriterias'] as $kriteria): ?>
            <option value="<?= $kriteria['id_kriteria'] ?>" <?= $data['form_type'] == 'edit' && $data['sub_kriteria']['id_kriteria'] == $kriteria['id_kriteria'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($kriteria['kode_kriteria'] . ' - ' . $kriteria['nama_kriteria']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <p class="help-gov"><i class="fas fa-info-circle"></i> Pilih kriteria induk untuk sub kriteria ini</p>
      </div>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-tag text-gov-blue-700"></i> Nama Pilihan <span class="text-gov-maroon-700">*</span></label>
        <input type="text" class="input-gov" id="nama_pilihan" name="nama_pilihan"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['sub_kriteria']['nama_pilihan']) : '' ?>"
               placeholder="Contoh: Sangat Puas, Puas, Cukup" required maxlength="50">
      </div>

      <div class="mb-6">
        <label class="label-gov"><i class="fas fa-sliders-h text-gov-blue-700"></i> Nilai Utility <span class="text-gov-maroon-700">*</span></label>
        <input type="number" class="input-gov mb-3" id="nilai_utility" name="nilai_utility"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['sub_kriteria']['nilai_utility']) : '' ?>"
               placeholder="0-100" required min="0" max="100" step="0.1">
        <input type="range" id="utility_slider" min="0" max="100" step="0.1"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['sub_kriteria']['nilai_utility']) : '50' ?>"
               class="w-full accent-gov-blue-700 mb-3">
        <div class="bar-gov-track mb-2"><div id="utility_visual_fill" class="bar-gov-fill" style="width: 50%"></div></div>
        <div class="grid grid-cols-5 gap-2">
          <?php foreach ([0, 25, 50, 75, 100] as $qv): ?>
            <button type="button" class="btn-quick-value btn-gov-secondary !flex-col !py-2 !text-xs" data-value="<?= $qv ?>"><?= $qv ?></button>
          <?php endforeach; ?>
        </div>
        <p class="help-gov"><i class="fas fa-info-circle"></i> Skala 0-100 yang merepresentasikan tingkat kepuasan</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-slate-200">
        <button type="submit" class="btn-gov-primary"><i class="fas fa-save"></i> <?= $data['form_type'] == 'create' ? 'Simpan' : 'Perbarui' ?></button>
        <a href="index.php?controller=subKriteria&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i> Batal</a>
      </div>
    </form>
  </div>

  <div class="card-gov h-fit">
    <div class="flex items-center gap-3 mb-4">
      <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950"><i class="fas fa-lightbulb"></i></div>
      <div><h4 class="font-bold text-slate-800">Informasi Penting</h4><p class="text-xs text-slate-500">Panduan pengisian form</p></div>
    </div>
    <div class="space-y-3">
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Kriteria Induk</strong><p class="text-xs text-slate-500">Sub kriteria harus berada di bawah satu kriteria induk</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Nilai Utility</strong><p class="text-xs text-slate-500">Nilai 0-100 yang merepresentasikan tingkat kepuasan</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Skala Penilaian</strong><p class="text-xs text-slate-500">100 = Sangat Baik, 75 = Baik, 50 = Cukup, 25 = Kurang, 0 = Sangat Kurang</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Metode SMART</strong><p class="text-xs text-slate-500">Sub kriteria digunakan untuk perhitungan metode SMART</p></div></div>
    </div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  const utilityInput = document.getElementById('nilai_utility');
  const utilitySlider = document.getElementById('utility_slider');
  const utilityVisualFill = document.getElementById('utility_visual_fill');

  function updateUtility(value) {
    utilityInput.value = value;
    utilitySlider.value = value;
    utilityVisualFill.style.width = value + '%';
  }

  utilitySlider.addEventListener('input', function () { updateUtility(this.value); });
  utilityInput.addEventListener('input', function () { updateUtility(this.value); });
  document.querySelectorAll('.btn-quick-value').forEach(button => {
    button.addEventListener('click', function () { updateUtility(this.getAttribute('data-value')); });
  });
  updateUtility(utilityInput.value || 50);

  document.getElementById('subKriteriaForm').addEventListener('submit', function (e) {
    const idKriteria = document.getElementById('id_kriteria');
    const namaPilihan = document.getElementById('nama_pilihan');
    const nilaiUtility = document.getElementById('nilai_utility');
    [idKriteria, namaPilihan, nilaiUtility].forEach(el => el.classList.remove('input-gov-invalid'));
    let isValid = true;

    if (!idKriteria.value) {
      e.preventDefault(); idKriteria.classList.add('input-gov-invalid'); idKriteria.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Kriteria wajib dipilih!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!namaPilihan.value.trim()) {
      e.preventDefault(); namaPilihan.classList.add('input-gov-invalid'); namaPilihan.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nama pilihan wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!nilaiUtility.value || nilaiUtility.value < 0 || nilaiUtility.value > 100) {
      e.preventDefault(); nilaiUtility.classList.add('input-gov-invalid'); nilaiUtility.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nilai utility harus antara 0-100!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    }

    return isValid;
  });
</script>
