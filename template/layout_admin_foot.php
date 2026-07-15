  </main>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
  <script src="template/js/sidebar-toggle.js"></script>
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

    function govConfirmDelete(url, opts) {
      opts = opts || {};
      Swal.fire({
        title: opts.title || 'Apakah Anda yakin?',
        text: opts.text || 'Data akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B91C1C',
        cancelButtonColor: '#2456A6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    }

    function govConfirmLogout(url) {
      Swal.fire({
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin keluar dari sistem?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#B91C1C',
        cancelButtonColor: '#2456A6',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    }

    document.querySelectorAll('form[data-loading-label]').forEach(function (form) {
      form.addEventListener('submit', function () {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
          button.disabled = true;
          button.dataset.originalHtml = button.innerHTML;
          button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + form.dataset.loadingLabel;
        }
      });
    });
  </script>
</body>

</html>
