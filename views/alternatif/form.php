<?php $page_title = ($data['form_type'] == 'create' ? 'Tambah' : 'Edit') . ' Layanan - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-<?= $data['form_type'] == 'create' ? 'plus-circle' : 'edit' ?>"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800"><?= $data['form_type'] == 'create' ? 'Tambah Layanan Baru' : 'Edit Layanan' ?></h1>
      <p class="text-slate-500 text-sm"><?= $data['form_type'] == 'create' ? 'Isi form untuk menambahkan layanan baru' : 'Perbarui data layanan' ?></p>
    </div>
  </div>
  <a href="index.php?controller=alternatif&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card-gov">
    <form method="POST" action="<?= $data['form_action'] ?>" id="alternatifForm" data-loading-label="Menyimpan...">
      <?php if ($data['form_type'] == 'edit'): ?>
        <input type="hidden" name="id_alternatif" value="<?= $data['alternatif']['id_alternatif'] ?>">
      <?php endif; ?>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-hashtag text-gov-blue-700"></i> Kode Layanan <span class="text-gov-maroon-700">*</span></label>
        <input type="text" class="input-gov" id="kode_alternatif" name="kode_alternatif"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['alternatif']['kode_alternatif']) : '' ?>"
               placeholder="Contoh: A01, B02, C03" required maxlength="10" pattern="[A-Z0-9]+"
               oninput="this.value = this.value.toUpperCase()">
        <p class="help-gov"><i class="fas fa-info-circle"></i> Maksimal 10 karakter, huruf kapital dan angka saja</p>
      </div>

      <div class="mb-5">
        <label class="label-gov"><i class="fas fa-tag text-gov-blue-700"></i> Nama Layanan <span class="text-gov-maroon-700">*</span></label>
        <input type="text" class="input-gov" id="nama_layanan" name="nama_layanan"
               value="<?= $data['form_type'] == 'edit' ? htmlspecialchars($data['alternatif']['nama_layanan']) : '' ?>"
               placeholder="Masukkan nama layanan" required maxlength="100">
        <p class="help-gov"><i class="fas fa-info-circle"></i> Nama layanan yang akan ditampilkan dalam sistem</p>
      </div>

      <div class="mb-6">
        <label class="label-gov"><i class="fas fa-align-left text-gov-blue-700"></i> Keterangan Layanan</label>
        <textarea class="input-gov" id="keterangan" name="keterangan" rows="5" maxlength="1000"
                  placeholder="Jelaskan layanan ini secara singkat"><?= $data['form_type'] == 'edit' ? htmlspecialchars($data['alternatif']['keterangan']) : '' ?></textarea>
        <p class="help-gov"><i class="fas fa-info-circle"></i> Keterangan opsional, maksimal 1000 karakter (<span id="keterangan-counter">0</span>/1000)</p>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-slate-200">
        <button type="submit" class="btn-gov-primary"><i class="fas fa-save"></i> <?= $data['form_type'] == 'create' ? 'Simpan' : 'Perbarui' ?></button>
        <a href="index.php?controller=alternatif&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i> Batal</a>
      </div>
    </form>
  </div>

  <div class="card-gov h-fit">
    <div class="flex items-center gap-3 mb-4">
      <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950">
        <i class="fas fa-lightbulb"></i>
      </div>
      <div>
        <h4 class="font-bold text-slate-800">Informasi Penting</h4>
        <p class="text-xs text-slate-500">Panduan pengisian form</p>
      </div>
    </div>
    <div class="space-y-3">
      <div class="flex gap-3 items-start">
        <i class="fas fa-check-circle text-gov-green-700 mt-1"></i>
        <div><strong class="text-sm text-slate-800 block">Metode SMART</strong><p class="text-xs text-slate-500">Layanan akan digunakan dalam perhitungan metode SMART</p></div>
      </div>
      <div class="flex gap-3 items-start">
        <i class="fas fa-check-circle text-gov-green-700 mt-1"></i>
        <div><strong class="text-sm text-slate-800 block">Kode Unik</strong><p class="text-xs text-slate-500">Kode layanan harus unik dan tidak boleh duplikat</p></div>
      </div>
      <div class="flex gap-3 items-start">
        <i class="fas fa-check-circle text-gov-green-700 mt-1"></i>
        <div><strong class="text-sm text-slate-800 block">Format Kode</strong><p class="text-xs text-slate-500">Gunakan huruf kapital dan angka (contoh: A01, B02)</p></div>
      </div>
    </div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  const keterangan = document.getElementById('keterangan');
  const counter = document.getElementById('keterangan-counter');
  if (keterangan && counter) {
    counter.textContent = keterangan.value.length;
    keterangan.addEventListener('input', function () { counter.textContent = this.value.length; });
  }

  document.getElementById('alternatifForm').addEventListener('submit', function (e) {
    const kode = document.getElementById('kode_alternatif');
    const nama = document.getElementById('nama_layanan');
    [kode, nama].forEach(el => el.classList.remove('input-gov-invalid'));
    let isValid = true;

    if (!kode.value.trim()) {
      e.preventDefault(); kode.classList.add('input-gov-invalid'); kode.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Kode layanan wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!/^[A-Z0-9]+$/.test(kode.value)) {
      e.preventDefault(); kode.classList.add('input-gov-invalid'); kode.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Kode layanan hanya boleh huruf kapital dan angka!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    }

    if (!nama.value.trim()) {
      e.preventDefault(); nama.classList.add('input-gov-invalid'); nama.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nama layanan wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    }

    return isValid;
  });
</script>
