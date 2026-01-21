<?php
require_once 'models/RespondenModel.php';

class RespondenController
{
    private $respondenModel;

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

        // Role check - admin dan staff yang boleh akses
        if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff') {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=admin&action=index');
            exit;
        }

        $this->respondenModel = new RespondenModel($connection);
    }

    public function index()
    {
        // Get search keyword if exists
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        if (!empty($keyword)) {
            $respondens = $this->respondenModel->search($keyword);
        } else {
            $respondens = $this->respondenModel->getAll();
        }

        $data = [
            'title' => 'Kelola Responden - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kelola Data Responden',
            'respondens' => $respondens,
            'keyword' => $keyword,
            'total' => $this->respondenModel->getTotal(),
            'avg_age' => $this->respondenModel->getAverageAge(),
            'total_by_pekerjaan' => $this->respondenModel->getTotalByPekerjaan(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/responden/index.php';
    }

    public function detail()
    {
        $id_responden = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_responden <= 0) {
            $_SESSION['error'] = 'ID responden tidak valid!';
            header('Location: index.php?controller=responden&action=index');
            exit;
        }

        $responden = $this->respondenModel->getById($id_responden);

        if (!$responden) {
            $_SESSION['error'] = 'Responden tidak ditemukan!';
            header('Location: index.php?controller=responden&action=index');
            exit;
        }

        // Get penilaians for this responden
        require_once 'models/PenilaianModel.php';
        $penilaianModel = new PenilaianModel($this->respondenModel->conn);
        $penilaians = $penilaianModel->getByResponden($id_responden);

        // Calculate statistics
        $total_penilaian = count($penilaians);
        $avg_nilai = 0;
        if ($total_penilaian > 0) {
            $total_nilai = 0;
            foreach ($penilaians as $penilaian) {
                $total_nilai += $penilaian['nilai_utility'];
            }
            $avg_nilai = round($total_nilai / $total_penilaian, 1);
        }

        $data = [
            'title' => 'Detail Responden - DISDUKCAPIL Kota Padang',
            'page_title' => 'Detail Responden',
            'responden' => $responden,
            'penilaians' => $penilaians,
            'total_penilaian' => $total_penilaian,
            'avg_nilai' => $avg_nilai,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/responden/detail.php';
    }

    public function delete()
    {
        $id_responden = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_responden <= 0) {
            $_SESSION['error'] = 'ID responden tidak valid!';
            header('Location: index.php?controller=responden&action=index');
            exit;
        }

        // Check if data exists
        $responden = $this->respondenModel->getById($id_responden);
        if (!$responden) {
            $_SESSION['error'] = 'Responden tidak ditemukan!';
            header('Location: index.php?controller=responden&action=index');
            exit;
        }

        // Delete data
        if ($this->respondenModel->delete($id_responden)) {
            $_SESSION['success'] = 'Responden berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus responden!';
        }

        header('Location: index.php?controller=responden&action=index');
        exit;
    }
}
?>
