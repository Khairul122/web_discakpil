  </main>

  <footer class="bg-slate-900 text-slate-300 pt-16 pb-8 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
        <!-- Column 1: Branding -->
        <div class="space-y-4">
          <div class="flex items-center">
            <img src="assets/images/logo-pdf.png" alt="Logo DISDUKCAPIL Kota Padang" class="h-9 w-auto object-contain">
          </div>
          <p class="text-xs text-slate-400 leading-relaxed pt-2">
            Unit pelaksana urusan pemerintahan di bidang administrasi kependudukan dan pencatatan sipil Kota Padang. Melayani secara prima, transparan, dan akuntabel.
          </p>
          <div class="flex items-center gap-3 pt-2">
            <a href="#" class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:bg-gov-blue-800 hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:bg-gov-blue-800 hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
            <a href="#" class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:bg-gov-blue-800 hover:text-white transition-all"><i class="fab fa-twitter"></i></a>
            <a href="#" class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center text-xs text-slate-400 hover:bg-gov-blue-800 hover:text-white transition-all"><i class="fab fa-youtube"></i></a>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-5 border-l-4 border-gov-blue-800 pl-3">Tautan Cepat</h4>
          <ul class="space-y-3 text-xs">
            <li><a href="index.php?controller=landing&action=index" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-chevron-right text-[8px] text-gov-blue-700 mr-2"></i>Beranda</a></li>
            <li><a href="index.php?controller=penilaianKuesioner&action=index" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-chevron-right text-[8px] text-gov-blue-700 mr-2"></i>Isi Kuesioner</a></li>
            <li><a href="index.php?controller=auth&action=index" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-chevron-right text-[8px] text-gov-blue-700 mr-2"></i>Portal Login</a></li>
          </ul>
        </div>

        <!-- Column 3: Contact -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-5 border-l-4 border-gov-blue-800 pl-3">Kontak Kami</h4>
          <ul class="space-y-3.5 text-xs text-slate-400">
            <li class="flex items-start gap-2.5">
              <i class="fas fa-location-dot text-gov-blue-700 mt-0.5"></i>
              <span>Jl. Jenderal Sudirman No. 1, Kota Padang, Sumatera Barat</span>
            </li>
            <li class="flex items-center gap-2.5">
              <i class="fas fa-phone text-gov-blue-700"></i>
              <span>(0751) 123456</span>
            </li>
            <li class="flex items-center gap-2.5">
              <i class="fas fa-envelope text-gov-blue-700"></i>
              <span>disdukcapil@padang.go.id</span>
            </li>
          </ul>
        </div>

        <!-- Column 4: Operational Hours -->
        <div>
          <h4 class="text-xs font-bold uppercase tracking-widest text-white mb-5 border-l-4 border-gov-blue-800 pl-3">Jam Pelayanan</h4>
          <ul class="space-y-3 text-xs text-slate-400">
            <li class="flex justify-between border-b border-slate-800 pb-2">
              <span>Senin - Kamis</span>
              <span class="text-white font-semibold">08:00 - 15:30</span>
            </li>
            <li class="flex justify-between border-b border-slate-800 pb-2">
              <span>Jumat</span>
              <span class="text-white font-semibold">08:00 - 16:00</span>
            </li>
            <li class="flex justify-between pb-1">
              <span>Sabtu - Minggu</span>
              <span class="text-rose-500 font-bold uppercase tracking-wider text-[10px]">Tutup</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
        <p>&copy; <?= date('Y') ?> Dinas Kependudukan dan Pencatatan Sipil Kota Padang. Hak Cipta Dilindungi.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="template/js/scroll-reveal.js"></script>
  <script>
    <?php if (!empty($_SESSION['error'])): ?>
      window.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'error',
          title: 'Peringatan',
          text: "<?= addslashes($_SESSION['error']) ?>",
          confirmButtonText: 'OK',
          confirmButtonColor: '#2456A6'
        });
      });
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
      window.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: "<?= addslashes($_SESSION['success']) ?>",
          confirmButtonText: 'Tutup',
          confirmButtonColor: '#2456A6'
        });
      });
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
  </script>
</body>

</html>
