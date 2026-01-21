<?php
require_once 'models/AlternatifModel.php';

class AlternatifController
{
    private $alternatifModel;

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

        $this->alternatifModel = new AlternatifModel($connection);
    }

    public function index()
    {
        // Get search keyword if exists
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        if (!empty($keyword)) {
            $alternatifs = $this->alternatifModel->search($keyword);
        } else {
            $alternatifs = $this->alternatifModel->getAll();
        }

        $data = [
            'title' => 'Kelola Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kelola Layanan',
            'alternatifs' => $alternatifs,
            'keyword' => $keyword,
            'total' => $this->alternatifModel->getTotal(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/alternatif/index.php';
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Tambah Layanan Baru',
            'form_action' => 'index.php?controller=alternatif&action=store',
            'form_type' => 'create',
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/alternatif/form.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        $kode_alternatif = trim($_POST['kode_alternatif'] ?? '');
        $nama_layanan = trim($_POST['nama_layanan'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        // Validation
        if (empty($kode_alternatif) || empty($nama_layanan)) {
            $_SESSION['error'] = 'Kode alternatif dan nama layanan wajib diisi!';
            header('Location: index.php?controller=alternatif&action=create');
            exit;
        }

        // Cek kode unik
        if ($this->alternatifModel->checkKodeExists($kode_alternatif)) {
            $_SESSION['error'] = 'Kode alternatif sudah terdaftar!';
            header('Location: index.php?controller=alternatif&action=create');
            exit;
        }

        // Insert data
        if ($this->alternatifModel->create($kode_alternatif, $nama_layanan, $keterangan)) {
            $_SESSION['success'] = 'Layanan berhasil ditambahkan!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal menambahkan layanan!';
            header('Location: index.php?controller=alternatif&action=create');
            exit;
        }
    }

    public function edit()
    {
        $id_alternatif = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_alternatif <= 0) {
            $_SESSION['error'] = 'ID layanan tidak valid!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        $alternatif = $this->alternatifModel->getById($id_alternatif);

        if (!$alternatif) {
            $_SESSION['error'] = 'Layanan tidak ditemukan!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        $data = [
            'title' => 'Edit Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Edit Layanan',
            'form_action' => 'index.php?controller=alternatif&action=update',
            'form_type' => 'edit',
            'alternatif' => $alternatif,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/alternatif/form.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        $id_alternatif = intval($_POST['id_alternatif'] ?? 0);
        $kode_alternatif = trim($_POST['kode_alternatif'] ?? '');
        $nama_layanan = trim($_POST['nama_layanan'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        // Validation
        if ($id_alternatif <= 0 || empty($kode_alternatif) || empty($nama_layanan)) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: index.php?controller=alternatif&action=edit&id=' . $id_alternatif);
            exit;
        }

        // Cek kode unik (exclude current id)
        if ($this->alternatifModel->checkKodeExists($kode_alternatif, $id_alternatif)) {
            $_SESSION['error'] = 'Kode alternatif sudah terdaftar!';
            header('Location: index.php?controller=alternatif&action=edit&id=' . $id_alternatif);
            exit;
        }

        // Update data
        if ($this->alternatifModel->update($id_alternatif, $kode_alternatif, $nama_layanan, $keterangan)) {
            $_SESSION['success'] = 'Layanan berhasil diperbarui!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        } else {
            $_SESSION['error'] = 'Gagal memperbarui layanan!';
            header('Location: index.php?controller=alternatif&action=edit&id=' . $id_alternatif);
            exit;
        }
    }

    public function delete()
    {
        $id_alternatif = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_alternatif <= 0) {
            $_SESSION['error'] = 'ID layanan tidak valid!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        // Check if data exists
        $alternatif = $this->alternatifModel->getById($id_alternatif);
        if (!$alternatif) {
            $_SESSION['error'] = 'Layanan tidak ditemukan!';
            header('Location: index.php?controller=alternatif&action=index');
            exit;
        }

        // Delete data
        if ($this->alternatifModel->delete($id_alternatif)) {
            $_SESSION['success'] = 'Layanan berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus layanan!';
        }

        header('Location: index.php?controller=alternatif&action=index');
        exit;
    }
}
?>
