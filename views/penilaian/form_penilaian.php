<?php $page_title = 'Form Penilaian - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_admin_head.php'); ?>
<?php include('template/layout_admin_chrome.php'); ?>

<div class="flex items-center justify-between flex-wrap gap-4 mb-6">
  <div class="flex items-center gap-3">
    <div class="flex h-12 w-12 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-xl shadow-soft-raised-sm">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Form Penilaian Layanan</h1>
      <p class="text-slate-500 text-sm">Beri penilaian Anda terhadap layanan DISDUKCAPIL Kota Padang</p>
    </div>
  </div>
  <a href="index.php?controller=penilaian&action=index" class="btn-gov-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 card-gov">
    <form method="POST" action="<?= $data['form_action'] ?>" id="penilaianForm" data-loading-label="Mengirim...">

      <div class="mb-8 pb-6 border-b border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fas fa-user-circle text-gov-blue-700"></i> Data Responden</h3>

        <div class="mb-5">
          <label class="label-gov">Nama Lengkap <span class="text-gov-maroon-700">*</span></label>
          <input type="text" class="input-gov" id="nama_responden" name="nama_responden" placeholder="Masukkan nama lengkap (atau anonim)" required maxlength="100">
          <p class="help-gov"><i class="fas fa-info-circle"></i> Boleh menggunakan nama anonim (misal: "Responden 001")</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
          <div>
            <label class="label-gov">Usia <span class="text-gov-maroon-700">*</span></label>
            <input type="number" class="input-gov" id="usia" name="usia" placeholder="Masukkan usia Anda" required min="1" max="120">
          </div>
          <div>
            <label class="label-gov">Pekerjaan <span class="text-gov-maroon-700">*</span></label>
            <input type="text" class="input-gov" id="pekerjaan" name="pekerjaan" placeholder="Contoh: Pelajar, PNS, Wiraswasta" required maxlength="50">
          </div>
        </div>

        <div>
          <label class="label-gov">Layanan yang Dinilai <span class="text-gov-maroon-700">*</span></label>
          <select class="input-gov" id="id_alternatif" name="id_alternatif" required>
            <option value="">Pilih Layanan</option>
            <?php foreach ($data['alternatifs'] as $alternatif): ?>
              <option value="<?= $alternatif['id_alternatif'] ?>"><?= htmlspecialchars($alternatif['nama_layanan']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-1 flex items-center gap-2"><i class="fas fa-clipboard-check text-gov-blue-700"></i> Penilaian Layanan</h3>
        <p class="text-sm text-slate-500 mb-5">Mohon berikan penilaian untuk setiap kriteria di bawah ini</p>

        <div class="space-y-4">
          <?php foreach ($data['kriterias'] as $index => $kriteria): ?>
            <div class="rounded-gov-lg border-2 border-slate-200 overflow-hidden">
              <div class="bg-gradient-to-b from-gov-blue-700 to-gov-blue-900 text-white p-4 flex items-start gap-3">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-gov bg-white/20 font-bold"><?= $index + 1 ?></div>
                <div>
                  <span class="inline-block px-2 py-0.5 rounded bg-white/20 text-xs font-bold uppercase mb-1"><?= htmlspecialchars($kriteria['kode_kriteria']) ?></span>
                  <h4 class="font-bold"><?= htmlspecialchars($kriteria['nama_kriteria']) ?></h4>
                  <?php if (!empty($kriteria['pertanyaan'])): ?>
                    <p class="text-sm text-white/85 mt-1"><i class="fas fa-question-circle mr-1"></i><?= htmlspecialchars($kriteria['pertanyaan']) ?></p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="p-4 bg-surface-card">
                <label class="label-gov">Pilih Penilaian Anda <span class="text-gov-maroon-700">*</span></label>
                <select class="input-gov" name="id_sub_<?= $kriteria['id_kriteria'] ?>" required>
                  <option value="">Pilih penilaian</option>
                  <?php
                    $subs = $data['penilaianModel']->getSubKriteriaByKriteria($kriteria['id_kriteria']);
                    foreach ($subs as $sub): ?>
                    <option value="<?= $sub['id_sub'] ?>" data-nilai="<?= $sub['nilai_utility'] ?>">
                      <?= htmlspecialchars($sub['nama_pilihan']) ?> (Nilai: <?= $sub['nilai_utility'] ?>%)
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="utility-preview mt-3 hidden" id="utility_preview_<?= $kriteria['id_kriteria'] ?>">
                  <div class="bar-gov-track"><div class="utility-preview-fill bar-gov-fill" style="width: 0%"></div></div>
                  <p class="text-xs text-slate-500 mt-1">Nilai Utility: <span class="nilai-preview font-semibold text-gov-blue-700">0</span>%</p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-3 pt-5 border-t border-slate-200">
        <button type="submit" class="btn-gov-primary"><i class="fas fa-paper-plane"></i> Kirim Penilaian</button>
        <a href="index.php?controller=penilaian&action=index" class="btn-gov-secondary"><i class="fas fa-times"></i> Batal</a>
      </div>
    </form>
  </div>

  <div class="card-gov h-fit">
    <div class="flex items-center gap-3 mb-4">
      <div class="flex h-10 w-10 items-center justify-center rounded-gov bg-gradient-to-b from-gov-gold-400 to-gov-gold-600 text-gov-blue-950"><i class="fas fa-info-circle"></i></div>
      <div><h4 class="font-bold text-slate-800">Informasi Penting</h4><p class="text-xs text-slate-500">Panduan pengisian form penilaian</p></div>
    </div>
    <div class="space-y-3">
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Data Diri</strong><p class="text-xs text-slate-500">Isi data diri dengan lengkap. Nama boleh menggunakan anonim</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Jujur dan Obyektif</strong><p class="text-xs text-slate-500">Beri penilaian sesuai dengan pengalaman nyata Anda</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Semua Kriteria Wajib</strong><p class="text-xs text-slate-500">Pastikan semua kriteria dinilai untuk hasil yang akurat</p></div></div>
      <div class="flex gap-3 items-start"><i class="fas fa-check-circle text-gov-green-700 mt-1"></i><div><strong class="text-sm text-slate-800 block">Satu Kali Per Layanan</strong><p class="text-xs text-slate-500">Setiap responden hanya bisa menilai satu layanan satu kali</p></div></div>
    </div>
  </div>
</div>

<?php include('template/layout_admin_foot.php'); ?>

<script>
  document.querySelectorAll('select[name^="id_sub_"]').forEach(select => {
    select.addEventListener('change', function () {
      const kriteriaId = this.name.replace('id_sub_', '');
      const previewDiv = document.getElementById('utility_preview_' + kriteriaId);
      const selectedOption = this.options[this.selectedIndex];

      if (this.value && selectedOption.dataset.nilai) {
        const nilai = selectedOption.dataset.nilai;
        previewDiv.classList.remove('hidden');
        previewDiv.querySelector('.utility-preview-fill').style.width = nilai + '%';
        previewDiv.querySelector('.nilai-preview').textContent = nilai;
      } else {
        previewDiv.classList.add('hidden');
      }
    });
  });

  document.getElementById('penilaianForm').addEventListener('submit', function (e) {
    const namaResponden = document.getElementById('nama_responden');
    const usia = document.getElementById('usia');
    const pekerjaan = document.getElementById('pekerjaan');
    const idAlternatif = document.getElementById('id_alternatif');
    [namaResponden, usia, pekerjaan, idAlternatif].forEach(el => el.classList.remove('input-gov-invalid'));
    let isValid = true;

    if (!namaResponden.value.trim()) {
      e.preventDefault(); namaResponden.classList.add('input-gov-invalid'); namaResponden.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nama lengkap wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!usia.value || usia.value < 1 || usia.value > 120) {
      e.preventDefault(); usia.classList.add('input-gov-invalid'); usia.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Usia harus antara 1-120 tahun!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!pekerjaan.value.trim()) {
      e.preventDefault(); pekerjaan.classList.add('input-gov-invalid'); pekerjaan.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pekerjaan wajib diisi!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    } else if (!idAlternatif.value) {
      e.preventDefault(); idAlternatif.classList.add('input-gov-invalid'); idAlternatif.focus();
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Layanan wajib dipilih!', confirmButtonColor: '#1D4E8F' });
      isValid = false;
    }

    document.querySelectorAll('select[name^="id_sub_"]').forEach((select) => {
      if (!select.value) {
        e.preventDefault(); select.classList.add('input-gov-invalid');
        Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Semua kriteria wajib dinilai!', confirmButtonColor: '#1D4E8F' });
        isValid = false;
      }
    });

    return isValid;
  });
</script>
