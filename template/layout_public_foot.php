  </main>

  <footer class="bg-gov-blue-950 text-white/80 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-sm">&copy; <?= date('Y') ?> DISDUKCAPIL Kota Padang. Hak Cipta Dilindungi.</p>
      <p class="text-xs text-white/50">Melayani dengan sepenuh hati untuk masyarakat Kota Padang</p>
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
          confirmButtonColor: '#1D4E8F'
        });
      });
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
  </script>
</body>

</html>
