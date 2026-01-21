<?php
require_once 'models/SubKriteriaModel.php';

class SubKriteriaController
{
    private $subKriteriaModel;

    public function __construct($connection)
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        // Role check - hanya admin yang boleh akses
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=admin&action=index');
            exit;
        }

        $this->subKriteriaModel = new SubKriteriaModel($connection);
    }

    public function index()
    {
        // Get search keyword if exists
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $filter_kriteria = isset($_GET['id_kriteria']) ? intval($_GET['id_kriteria']) : 0;

        if (!empty($keyword)) {
            $subKriterias = $this->subKriteriaModel->search($keyword);
        } elseif ($filter_kriteria > 0) {
            $subKriterias = $this->subKriteriaModel->getByKriteria($filter_kriteria);
        } else {
            $subKriterias = $this->subKriteriaModel->getAll();
        }

        $data = [
            'title' => 'Kelola Sub Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kelola Sub Kriteria',
            'sub_kriterias' => $subKriterias,
            'keyword' => $keyword,
            'filter_kriteria' => $filter_kriteria,
            'total' => $this->subKriteriaModel->getTotal(),
            'kriterias' => $this->subKriteriaModel->getAllKriteria(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/sub-kriteria/index.php';
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Sub Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Tambah Sub Kriteria Baru',
            'form_action' => 'index.php?controller=subKriteria&action=store',
            'form_type' => 'create',
            'kriterias' => $this->subKriteriaModel->getAllKriteria(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/sub-kriteria/form.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        $id_kriteria = intval($_POST['id_kriteria'] ?? 0);
        $nama_pilihan = trim($_POST['nama_pilihan'] ?? '');
        $nilai_utility = floatval($_POST['nilai_utility'] ?? 0);

        // Validation
        if ($id_kriteria <= 0 || empty($nama_pilihan)) {
            $_SESSION['error'] = 'Kriteria dan nama pilihan wajib diisi!';
            header('Location: index.php?controller=subKriteria&action=create');
            exit;
        }

        // Check if kriteria exists
        if (!$this->subKriteriaModel->checkKriteriaExists($id_kriteria)) {
            $_SESSION['error'] = 'Kriteria tidak ditemukan!';
            header('Location: index.php?controller=subKriteria&action=create');
            exit;
        }

        if ($nilai_utility < 0 || $nilai_utility > 100) {
            $_SESSION['error'] = 'Nilai utility harus antara 0-100!';
            header('Location: index.php?controller=subKriteria&action=create');
            exit;
        }

        // Insert data
        if ($this->subKriteriaModel->create($id_kriteria, $nama_pilihan, $nilai_utility)) {
            $_SESSION['success'] = 'Sub kriteria berhasil ditambahkan!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal menambahkan sub kriteria!';
            header('Location: index.php?controller=subKriteria&action=create');
            exit;
        }
    }

    public function edit()
    {
        $id_sub = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_sub <= 0) {
            $_SESSION['error'] = 'ID sub kriteria tidak valid!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        $subKriteria = $this->subKriteriaModel->getById($id_sub);

        if (!$subKriteria) {
            $_SESSION['error'] = 'Sub kriteria tidak ditemukan!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        $data = [
            'title' => 'Edit Sub Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Edit Sub Kriteria',
            'form_action' => 'index.php?controller=subKriteria&action=update',
            'form_type' => 'edit',
            'sub_kriteria' => $subKriteria,
            'kriterias' => $this->subKriteriaModel->getAllKriteria(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/sub-kriteria/form.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        $id_sub = intval($_POST['id_sub'] ?? 0);
        $id_kriteria = intval($_POST['id_kriteria'] ?? 0);
        $nama_pilihan = trim($_POST['nama_pilihan'] ?? '');
        $nilai_utility = floatval($_POST['nilai_utility'] ?? 0);

        // Validation
        if ($id_sub <= 0 || $id_kriteria <= 0 || empty($nama_pilihan)) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: index.php?controller=subKriteria&action=edit&id=' . $id_sub);
            exit;
        }

        // Check if kriteria exists
        if (!$this->subKriteriaModel->checkKriteriaExists($id_kriteria)) {
            $_SESSION['error'] = 'Kriteria tidak ditemukan!';
            header('Location: index.php?controller=subKriteria&action=edit&id=' . $id_sub);
            exit;
        }

        if ($nilai_utility < 0 || $nilai_utility > 100) {
            $_SESSION['error'] = 'Nilai utility harus antara 0-100!';
            header('Location: index.php?controller=subKriteria&action=edit&id=' . $id_sub);
            exit;
        }

        // Update data
        if ($this->subKriteriaModel->update($id_sub, $id_kriteria, $nama_pilihan, $nilai_utility)) {
            $_SESSION['success'] = 'Sub kriteria berhasil diperbarui!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal memperbarui sub kriteria!';
            header('Location: index.php?controller=subKriteria&action=edit&id=' . $id_sub);
            exit;
        }
    }

    public function delete()
    {
        $id_sub = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_sub <= 0) {
            $_SESSION['error'] = 'ID sub kriteria tidak valid!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        // Check if data exists
        $subKriteria = $this->subKriteriaModel->getById($id_sub);
        if (!$subKriteria) {
            $_SESSION['error'] = 'Sub kriteria tidak ditemukan!';
            header('Location: index.php?controller=subKriteria&action=index');
            exit;
        }

        // Delete data
        if ($this->subKriteriaModel->delete($id_sub)) {
            $_SESSION['success'] = 'Sub kriteria berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus sub kriteria!';
        }

        header('Location: index.php?controller=subKriteria&action=index');
        exit;
    }
}
?>
