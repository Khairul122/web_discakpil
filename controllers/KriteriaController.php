<?php
require_once 'models/KriteriaModel.php';

class KriteriaController
{
    private $kriteriaModel;

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

        $this->kriteriaModel = new KriteriaModel($connection);
    }

    public function index()
    {
        // Get search keyword if exists
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        if (!empty($keyword)) {
            $kriterias = $this->kriteriaModel->search($keyword);
        } else {
            $kriterias = $this->kriteriaModel->getAll();
        }

        $data = [
            'title' => 'Kelola Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kelola Kriteria',
            'kriterias' => $kriterias,
            'keyword' => $keyword,
            'total' => $this->kriteriaModel->getTotal(),
            'total_bobot' => $this->kriteriaModel->getTotalBobot(),
            'benefit_count' => $this->kriteriaModel->getBenefitCount(),
            'cost_count' => $this->kriteriaModel->getCostCount(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/kriteria/index.php';
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Tambah Kriteria Baru',
            'form_action' => 'index.php?controller=kriteria&action=store',
            'form_type' => 'create',
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/kriteria/form.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        $kode_kriteria = trim($_POST['kode_kriteria'] ?? '');
        $nama_kriteria = trim($_POST['nama_kriteria'] ?? '');
        $pertanyaan = trim($_POST['pertanyaan'] ?? '');
        $bobot = intval($_POST['bobot'] ?? 0);
        $jenis = trim($_POST['jenis'] ?? 'benefit');

        // Validation
        if (empty($kode_kriteria) || empty($nama_kriteria) || empty($pertanyaan)) {
            $_SESSION['error'] = 'Kode, nama kriteria, dan pertanyaan wajib diisi!';
            header('Location: index.php?controller=kriteria&action=create');
            exit;
        }

        if ($bobot < 1 || $bobot > 100) {
            $_SESSION['error'] = 'Bobot harus antara 1-100!';
            header('Location: index.php?controller=kriteria&action=create');
            exit;
        }

        if (!in_array($jenis, ['benefit', 'cost'])) {
            $_SESSION['error'] = 'Jenis kriteria tidak valid!';
            header('Location: index.php?controller=kriteria&action=create');
            exit;
        }

        // Cek kode unik
        if ($this->kriteriaModel->checkKodeExists($kode_kriteria)) {
            $_SESSION['error'] = 'Kode kriteria sudah terdaftar!';
            header('Location: index.php?controller=kriteria&action=create');
            exit;
        }

        // Insert data
        if ($this->kriteriaModel->create($kode_kriteria, $nama_kriteria, $pertanyaan, $bobot, $jenis)) {
            $_SESSION['success'] = 'Kriteria berhasil ditambahkan!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal menambahkan kriteria!';
            header('Location: index.php?controller=kriteria&action=create');
            exit;
        }
    }

    public function edit()
    {
        $id_kriteria = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_kriteria <= 0) {
            $_SESSION['error'] = 'ID kriteria tidak valid!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        $kriteria = $this->kriteriaModel->getById($id_kriteria);

        if (!$kriteria) {
            $_SESSION['error'] = 'Kriteria tidak ditemukan!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        $data = [
            'title' => 'Edit Kriteria - DISDUKCAPIL Kota Padang',
            'page_title' => 'Edit Kriteria',
            'form_action' => 'index.php?controller=kriteria&action=update',
            'form_type' => 'edit',
            'kriteria' => $kriteria,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/kriteria/form.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        $id_kriteria = intval($_POST['id_kriteria'] ?? 0);
        $kode_kriteria = trim($_POST['kode_kriteria'] ?? '');
        $nama_kriteria = trim($_POST['nama_kriteria'] ?? '');
        $pertanyaan = trim($_POST['pertanyaan'] ?? '');
        $bobot = intval($_POST['bobot'] ?? 0);
        $jenis = trim($_POST['jenis'] ?? 'benefit');

        // Validation
        if ($id_kriteria <= 0 || empty($kode_kriteria) || empty($nama_kriteria) || empty($pertanyaan)) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: index.php?controller=kriteria&action=edit&id=' . $id_kriteria);
            exit;
        }

        if ($bobot < 1 || $bobot > 100) {
            $_SESSION['error'] = 'Bobot harus antara 1-100!';
            header('Location: index.php?controller=kriteria&action=edit&id=' . $id_kriteria);
            exit;
        }

        if (!in_array($jenis, ['benefit', 'cost'])) {
            $_SESSION['error'] = 'Jenis kriteria tidak valid!';
            header('Location: index.php?controller=kriteria&action=edit&id=' . $id_kriteria);
            exit;
        }

        // Cek kode unik (exclude current id)
        if ($this->kriteriaModel->checkKodeExists($kode_kriteria, $id_kriteria)) {
            $_SESSION['error'] = 'Kode kriteria sudah terdaftar!';
            header('Location: index.php?controller=kriteria&action=edit&id=' . $id_kriteria);
            exit;
        }

        // Update data
        if ($this->kriteriaModel->update($id_kriteria, $kode_kriteria, $nama_kriteria, $pertanyaan, $bobot, $jenis)) {
            $_SESSION['success'] = 'Kriteria berhasil diperbarui!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal memperbarui kriteria!';
            header('Location: index.php?controller=kriteria&action=edit&id=' . $id_kriteria);
            exit;
        }
    }

    public function delete()
    {
        $id_kriteria = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_kriteria <= 0) {
            $_SESSION['error'] = 'ID kriteria tidak valid!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        // Check if data exists
        $kriteria = $this->kriteriaModel->getById($id_kriteria);
        if (!$kriteria) {
            $_SESSION['error'] = 'Kriteria tidak ditemukan!';
            header('Location: index.php?controller=kriteria&action=index');
            exit;
        }

        // Delete data
        if ($this->kriteriaModel->delete($id_kriteria)) {
            $_SESSION['success'] = 'Kriteria berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus kriteria!';
        }

        header('Location: index.php?controller=kriteria&action=index');
        exit;
    }
}
?>
