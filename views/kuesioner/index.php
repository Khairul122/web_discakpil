<?php $page_title = 'Kuesioner Kepuasan Masyarakat - DISDUKCAPIL Kota Padang'; ?>
<?php include('template/layout_public_head.php'); ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

  <div class="text-center mb-12 reveal-on-scroll is-visible">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gov-blue-100 text-gov-blue-800 text-sm font-semibold mb-5">
      <i class="fas fa-star text-gov-gold-600"></i> Survei Kepuasan Masyarakat
    </div>
    <h1 class="font-sans text-2xl sm:text-4xl font-bold text-gov-blue-900 mb-4">
      Sistem Informasi Penilaian Kepuasan Masyarakat
    </h1>
    <p class="text-slate-500 text-sm max-w-2xl mx-auto leading-relaxed font-semibold">
      Terhadap Layanan Kantor Dinas Kependudukan dan Pencatatan Sipil Kota Padang Menggunakan Metode SMART
    </p>
  </div>

  <form method="POST" action="index.php?controller=penilaianKuesioner&action=submit" id="kuesionerForm" class="card-gov !p-6 sm:!p-10" data-loading-label="Mengirim...">

    <div class="text-center mb-10 pb-8 border-b border-slate-200">
      <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white text-2xl">
        <i class="fas fa-poll"></i>
      </div>
      <h2 class="text-2xl font-bold text-slate-800 mb-2">Kuesioner Kepuasan Masyarakat</h2>
      <p class="text-slate-500">Mohon luangkan waktu sejenak untuk memberikan penilaian Anda</p>
    </div>

    <!-- Identitas -->
    <div class="mb-10">
      <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
        <i class="fas fa-user-circle text-gov-blue-700"></i> Identitas Responden
      </h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
          <label class="label-gov">Nama Lengkap <span class="text-gov-maroon-700">*</span></label>
          <input type="text" class="input-gov" name="nama_responden" placeholder="Masukkan nama lengkap atau anonim" required maxlength="100">
          <p class="help-gov"><i class="fas fa-info-circle"></i> Bisa menggunakan nama anonim (contoh: "Warga 001")</p>
        </div>
        <div>
          <label class="label-gov">Usia <span class="text-gov-maroon-700">*</span></label>
          <input type="number" class="input-gov" name="usia" placeholder="Usia dalam tahun" required min="1" max="120">
          <p class="help-gov"><i class="fas fa-birthday-cake"></i> Rentang: 1-120 tahun</p>
        </div>
        <div class="sm:col-span-2">
          <label class="label-gov">Pekerjaan <span class="text-gov-maroon-700">*</span></label>
          <input type="text" class="input-gov" name="pekerjaan" placeholder="Contoh: Pelajar, PNS, Wiraswasta" required maxlength="50">
          <p class="help-gov"><i class="fas fa-briefcase"></i> Pekerjaan saat ini</p>
        </div>
      </div>
    </div>

    <!-- Penilaian -->
    <div class="mb-10">
      <h3 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2">
        <i class="fas fa-star text-gov-blue-700"></i> Penilaian Layanan
      </h3>
      <p class="text-sm text-slate-600 bg-gov-blue-100/60 rounded-gov p-4 mb-6 text-center">
        <i class="fas fa-lightbulb text-gov-gold-600 mr-1"></i>
        Berikan penilaian untuk layanan yang pernah Anda gunakan. Opsional & fleksibel.
      </p>

      <?php foreach ($data['alternatifs'] as $altIndex => $alternatif): ?>
        <div class="mb-6 rounded-gov-lg border border-slate-200 bg-surface-card p-5 sm:p-6">
          <div class="mb-5 pb-4 border-b border-slate-200 flex items-start gap-3">
            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-gov bg-gradient-to-b from-gov-blue-600 to-gov-blue-800 text-white font-bold text-sm">
              <?= $altIndex + 1 ?>
            </div>
            <div>
              <h4 class="text-lg font-bold text-slate-800"><?= htmlspecialchars($alternatif['nama_layanan']) ?></h4>
              <?php if (!empty($alternatif['deskripsi'])): ?>
                <p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($alternatif['deskripsi']) ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="space-y-4">
            <?php foreach ($data['kriterias'] as $kriteria): ?>
              <div class="rounded-gov bg-white border border-slate-200 p-4">
                <span class="badge-gov-primary mb-2"><?= htmlspecialchars($kriteria['kode_kriteria']) ?></span>
                <h5 class="font-bold text-slate-800 mb-2"><?= htmlspecialchars($kriteria['nama_kriteria']) ?></h5>
                <?php if (!empty($kriteria['pertanyaan'])): ?>
                  <p class="text-sm text-slate-600 bg-amber-50 border-l-4 border-gov-gold-400 rounded-r-gov p-3 italic mb-3">
                    <i class="fas fa-quote-left text-gov-gold-600 mr-1"></i><?= htmlspecialchars($kriteria['pertanyaan']) ?>
                  </p>
                <?php endif; ?>

                <label class="label-gov">Penilaian Anda</label>
                <select class="input-gov kriteria-select" name="id_sub_<?= $alternatif['id_alternatif'] ?>_<?= $kriteria['id_kriteria'] ?>">
                  <option value="">-- Tidak Menilai --</option>
                  <?php
                    $subs = $data['penilaianModel']->getSubKriteriaByKriteria($kriteria['id_kriteria']);
                    foreach ($subs as $sub): ?>
                    <option value="<?= $sub['id_sub'] ?>" data-nilai="<?= $sub['nilai_utility'] ?>">
                      <?= htmlspecialchars($sub['nama_pilihan']) ?> (Nilai: <?= $sub['nilai_utility'] ?>%)
                    </option>
                  <?php endforeach; ?>
                </select>

                <div class="utility-preview mt-3 hidden" id="utility_preview_<?= $alternatif['id_alternatif'] ?>_<?= $kriteria['id_kriteria'] ?>">
                  <div class="bar-gov-track">
                    <div class="utility-fill bar-gov-fill" style="width: 0%"></div>
                  </div>
                  <p class="text-center text-xs text-slate-500 mt-1.5">Indeks Kepuasan: <strong class="nilai-display text-gov-blue-800">0</strong>%</p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center pt-6 border-t border-slate-200">
      <p class="text-sm text-slate-500 mb-5"><i class="fas fa-shield-alt text-gov-blue-700 mr-1"></i> Data Anda kami jaga kerahasiaannya sesuai peraturan perundang-undangan</p>
      <button type="submit" class="btn-gov-primary !min-h-[48px] px-10 text-base">
        <i class="fas fa-paper-plane"></i> Kirim Penilaian
      </button>
    </div>
  </form>
</div>

<?php include('template/layout_public_foot.php'); ?>

<script>
  document.querySelectorAll('.kriteria-select').forEach(select => {
    select.addEventListener('change', function () {
      const previewId = this.name.replace('id_sub_', 'utility_preview_');
      const previewDiv = document.getElementById(previewId);
      const selectedOption = this.options[this.selectedIndex];

      if (this.value && selectedOption.dataset.nilai) {
        const nilai = selectedOption.dataset.nilai;
        previewDiv.classList.remove('hidden');
        const fill = previewDiv.querySelector('.utility-fill');
        const display = previewDiv.querySelector('.nilai-display');
        fill.style.width = nilai + '%';
        display.textContent = nilai;
      } else {
        previewDiv.classList.add('hidden');
      }
    });
  });

  document.getElementById('kuesionerForm').addEventListener('submit', function (e) {
    const namaResponden = document.querySelector('input[name="nama_responden"]');
    const usia = document.querySelector('input[name="usia"]');
    const pekerjaan = document.querySelector('input[name="pekerjaan"]');
    let isValid = true;

    [namaResponden, usia, pekerjaan].forEach(el => el.classList.remove('input-gov-invalid'));

    if (!namaResponden.value.trim()) {
      e.preventDefault();
      namaResponden.classList.add('input-gov-invalid');
      Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Nama lengkap wajib diisi!', confirmButtonColor: '#2456A6' });
      isValid = false;
    }
    if (!usia.value || usia.value < 1 || usia.value > 120) {
      e.preventDefault();
      usia.classList.add('input-gov-invalid');
      Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Usia harus antara 1-120 tahun!', confirmButtonColor: '#2456A6' });
      isValid = false;
    }
    if (!pekerjaan.value.trim()) {
      e.preventDefault();
      pekerjaan.classList.add('input-gov-invalid');
      Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pekerjaan wajib diisi!', confirmButtonColor: '#2456A6' });
      isValid = false;
    }

    let hasRating = false;
    document.querySelectorAll('.kriteria-select').forEach(select => { if (select.value) hasRating = true; });
    if (!hasRating) {
      e.preventDefault();
      Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Mohon memberikan penilaian untuk minimal satu layanan!', confirmButtonColor: '#2456A6' });
      isValid = false;
    }

    return isValid;
  });
</script>
