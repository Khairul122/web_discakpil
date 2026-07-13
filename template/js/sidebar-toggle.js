(function () {
  var sidebar = document.getElementById('sidebar');
  var backdrop = document.getElementById('sidebarBackdrop');
  var openBtn = document.getElementById('sidebarOpen');
  var closeBtn = document.getElementById('sidebarClose');

  function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('-translate-x-full');
    if (backdrop) backdrop.classList.remove('hidden');
  }

  function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('-translate-x-full');
    if (backdrop) backdrop.classList.add('hidden');
  }

  if (openBtn) openBtn.addEventListener('click', openSidebar);
  if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
  if (backdrop) backdrop.addEventListener('click', closeSidebar);

  var userMenuButton = document.getElementById('userMenuButton');
  var userMenuDropdown = document.getElementById('userMenuDropdown');
  if (userMenuButton && userMenuDropdown) {
    userMenuButton.addEventListener('click', function (e) {
      e.stopPropagation();
      userMenuDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', function (e) {
      if (!userMenuDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
        userMenuDropdown.classList.add('hidden');
      }
    });
  }
})();
