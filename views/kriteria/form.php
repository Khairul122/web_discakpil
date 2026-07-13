<?php $page_title = ($data['form_type'] == 'create' ? 'Tambah' : 'Edit') . ' Kriteria - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus-circle' : 'edit' ?>"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800"><?= $data['form_type'] == 'create' ? 'Tambah Kriteria Baru' : 'Edit Kriteria' ?></h1>
      <p class="text-slate-500 text-sm"><?= $data['form_type'] == 'create' ? 'Isi form untuk menambahkan kriteria penilaian baru' : 'Perbarui data kriteria penilaian' ?></p>
    </div>
  </div>
  <a href="index.php?controller=kriteria&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card-gov">
    <form method="POST" action="<?= $data['form_action'] ?>" id="kriteriaForm" data-loading-label="Menyimpan...">
      <?php if ($data['form_type'] == 'edit'): ?>
        <input type="hidden" name="id_kriteria" value="<?= $data['kriteria']['id_kriteria'] ?>">
      <?php endif; ?>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-hashtag text-gov-blue-700"></i> Kode Kriteria <span class="text-gov-maroon-700">*</span></label>
        <input type="text" class="input-gov" id="kode_kriteria" name="kode_kriteria"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['kode_kriteria']) : '' ?>"
               placeholder="Contoh: C1, C2, C3" required maxlength="10" pattern="[A-Z0-9]+" oninput="this.value = this.value.toUpperCase()">
        <p class="help-gov"><i class="fas fa-info-circle"></i> Maksimal 10 karakter, huruf kapital dan angka saja</p>
      </div>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-tag text-gov-blue-700"></i> Nama Kriteria <span class="text-gov-maroon-700">*</span></label>
        <input type="text" class="input-gov" id="nama_kriteria" name="nama_kriteria"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['nama_kriteria']) : '' ?>"
               placeholder="Masukkan nama kriteria" required maxlength="100">
      </div>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-question-circle text-gov-blue-700"></i> Pertanyaan <span class="text-gov-maroon-700">*</span></label>
        <textarea class="input-gov" id="pertanyaan" name="pertanyaan" rows="4" required maxlength="500"
                  placeholder="Tuliskan pertanyaan untuk kriteria ini..."><?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['pertanyaan']) : '' ?></textarea>
        <p class="help-gov"><i class="fas fa-info-circle"></i> Pertanyaan yang akan diajukan kepada responden (<span id="pertanyaan-counter">0</span>/500)</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
        <div>
          <label class="label-gov"><i class="fas fa-weight-hanging text-gov-blue-700"></i> Bobot <span class="text-gov-maroon-700">*</span></label>
          <input type="number" class="input-gov" id="bobot" name="bobot"
                 value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['kriteria']['bobot']) : '' ?>"
                 placeholder="1-100" required min="1" max="100">
          <p class="help-gov"><i class="fas fa-info-circle"></i> Skala 1-100</p>
        </div>
        <div>
          <label class="label-gov"><i class="fas fa-exchange-alt text-gov-blue-700"></i> Jenis <span class="text-gov-maroon-700">*</span></label>
          <select class="input-gov" id="jenis" name="jenis" required>
            <option value="">Pilih Jenis</option>
            <option value="benefit" <?= $data['form_type'] == 'edit' && $data['kriteria']['jenis'] == 'benefit' ? 'selected' : '' ?>>Benefit (Keuntungan)</option>
            <option value="cost" <?= $data['form_type'] == 'edit' && $data['kriteria']['jenis'] == 'cost' ? 'selected' : '' ?>>Cost (Biaya)</option>
          </select>
          <p class="help-gov"><i class="fas fa-info-circle"></i> Benefit: semakin tinggi semakin baik</p>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-slate-200">
        <button type="submit" class="btn-gov-primary"><i class="fas fa-save"></i> <?= $data['form_type'] == 'create' ? 'Simpan' : 'Perbarui' ?></button>
        <a href="index.php?controller=kriteria&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i> Batal</a>
      </div>
    </form>
  </div>

  <div class="card-gov h-fit">
    <div class="flex items-center gap-3 mb-4">
      <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950"><i class="fas fa-lightbulb"></i></div>
      <div><h4 class="font-bold text-slate-800">Informasi Penting</h4><p class="text-xs text-slate-500">Panduan pengisian form</p></div>
    </div>
    <div class="space-y-3">
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Kode Unik</strong><p class="text-xs text-slate-500">Kode kriteria harus unik dan tidak boleh duplikat</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Bobot 1-100</strong><p class="text-xs text-slate-500">Bobot menggunakan skala 1-100 untuk setiap kriteria</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Jenis Kriteria</strong><p class="text-xs text-slate-500">Benefit: semakin tinggi semakin baik, Cost: semakin rendah semakin baik</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Metode SMART</strong><p class="text-xs text-slate-500">Kriteria akan digunakan dalam perhitungan metode SMART</p></div></div>
    </div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  const pertanyaan = document.getElementById('pertanyaan');
  const counter = document.getElementById('pertanyaan-counter');
  if (pertanyaan && counter) {
    counter.textContent = pertanyaan.value.length;
    pertanyaan.addEventListener('input', function () { counter.textContent = this.value.length; });
  }

  document.getElementById('kriteriaForm').addEventListener('submit', function (e) {
    const kode = document.getElementById('kode_kriteria');
    const nama = document.getElementById('nama_kriteria');
    const pert = document.getElementById('pertanyaan');
    const bobot = document.getElementById('bobot');
    const jenis = document.getElementById('jenis');
    [kode, nama, pert, bobot, jenis].forEach(el => el.classList.remove('input-gov-invalid'));
    let isValid = true;

    if (!kode.value.trim() || !/^[A-Z0-9]+$/.test(kode.value)) {
      e.preventDefault(); kode.classList.add('input-gov-invalid'); kode.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Kode kriteria wajib diisi dan hanya boleh huruf kapital/angka!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!nama.value.trim()) {
      e.preventDefault(); nama.classList.add('input-gov-invalid'); nama.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nama kriteria wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!pert.value.trim()) {
      e.preventDefault(); pert.classList.add('input-gov-invalid'); pert.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pertanyaan wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!bobot.value || bobot.value < 1 || bobot.value > 100) {
      e.preventDefault(); bobot.classList.add('input-gov-invalid'); bobot.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Bobot harus antara 1-100!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!jenis.value) {
      e.preventDefault(); jenis.classList.add('input-gov-invalid'); jenis.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Jenis kriteria wajib dipilih!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    }

    return isValid;
  });
</script>
