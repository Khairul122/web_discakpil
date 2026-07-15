<?php
require_once 'models/HasilModel.php';

class HasilController
{
    private $hasilModel;

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
        $allowedRoles = ['admin'];
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        $this->hasilModel = new HasilModel($connection);
    }

    public function index()
    {
        // Get view mode (responden or alternatif)
        $view_mode = isset($_GET['view']) ? $_GET['view'] : 'responden';

        // Get data based on view mode
        if ($view_mode === 'alternatif') {
            $hasil_data = $this->hasilModel->getAllGroupedByAlternatif();
        } else {
            $hasil_data = $this->hasilModel->getAllTerbaik();
        }

        // Ensure hasil_data is an array
        if ($hasil_data === false) {
            $hasil_data = [];
        }

        // Get statistics
        $statistics = $this->hasilModel->getStatistics();

        // Get top alternatif
        $top_alternatif = $this->hasilModel->getTopAlternatif();

        $data = [
            'title' => 'Hasil Perhitungan SMART - DISDUKCAPIL Kota Padang',
            'page_title' => 'Hasil Perhitungan Metode SMART',
            'hasil_data' => $hasil_data,
            'view_mode' => $view_mode,
            'statistics' => $statistics,
            'top_alternatif' => $top_alternatif,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/hasil/index.php';
    }

    // Detail hasil per responden
    public function detailResponden()
    {
        $id_responden = isset($_GET['id_responden']) ? intval($_GET['id_responden']) : 0;

        if ($id_responden <= 0) {
            $_SESSION['error'] = 'ID responden tidak valid!';
            header('Location: index.php?controller=hasil&action=index');
            exit;
        }

        // Get responden data
        require_once 'models/RespondenModel.php';
        $respondenModel = new RespondenModel($this->hasilModel->conn);
        $responden = $respondenModel->getById($id_responden);

        if (!$responden) {
            $_SESSION['error'] = 'Responden tidak ditemukan!';
            header('Location: index.php?controller=hasil&action=index');
            exit;
        }

        // Get hasil for this respondent (layanan terbaik)
        $hasil = $this->hasilModel->getByResponden($id_responden);

        if (!$hasil) {
            $_SESSION['error'] = 'Tidak ada hasil perhitungan untuk responden ini!';
            header('Location: index.php?controller=hasil&action=index');
            exit;
        }

        // Get seluruh skor SMART (semua layanan yang dinilai) untuk responden ini,
        // sudah correctly-weighted langsung dari hasil_akhir - tidak perlu hitung manual di view.
        $all_hasil = $this->hasilModel->getAllByResponden($id_responden);

        $data = [
            'title' => 'Detail Hasil - DISDUKCAPIL Kota Padang',
            'page_title' => 'Detail Hasil Perhitungan',
            'responden' => $responden,
            'hasil' => $hasil,
            'all_hasil' => $all_hasil,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/hasil/detail_responden.php';
    }

    // Detail hasil per alternatif
    public function detailAlternatif()
    {
        $id_alternatif = isset($_GET['id_alternatif']) ? intval($_GET['id_alternatif']) : 0;

        if ($id_alternatif <= 0) {
            $_SESSION['error'] = 'ID alternatif tidak valid!';
            header('Location: index.php?controller=hasil&action=index&view=alternatif');
            exit;
        }

        // Get alternatif data
        require_once 'models/AlternatifModel.php';
        $alternatifModel = new AlternatifModel($this->hasilModel->conn);
        $alternatif = $alternatifModel->getById($id_alternatif);

        if (!$alternatif) {
            $_SESSION['error'] = 'Layanan tidak ditemukan!';
            header('Location: index.php?controller=hasil&action=index&view=alternatif');
            exit;
        }

        // Get hasil for this alternatif
        $hasil_list = $this->hasilModel->getByAlternatif($id_alternatif);

        if (empty($hasil_list)) {
            $_SESSION['error'] = 'Tidak ada hasil perhitungan untuk layanan ini!';
            header('Location: index.php?controller=hasil&action=index&view=alternatif');
            exit;
        }

        // Calculate statistics for this alternatif
        $nilai_smart_list = array_column($hasil_list, 'nilai_smart');
        $statistics = [
            'rerata' => array_sum($nilai_smart_list) / count($nilai_smart_list),
            'tertinggi' => max($nilai_smart_list),
            'terendah' => min($nilai_smart_list),
            'total_penilai' => count($hasil_list)
        ];

        $data = [
            'title' => 'Detail Hasil Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Detail Hasil Per Layanan',
            'alternatif' => $alternatif,
            'hasil_list' => $hasil_list,
            'statistics' => $statistics,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/hasil/detail_alternatif.php';
    }

    // Delete hasil by responden
    public function deleteResponden()
    {
        $id_responden = isset($_GET['id_responden']) ? intval($_GET['id_responden']) : 0;

        if ($id_responden <= 0) {
            $_SESSION['error'] = 'ID responden tidak valid!';
            header('Location: index.php?controller=hasil&action=index');
            exit;
        }

        // Check if hasil exists
        if (!$this->hasilModel->hasHasilForResponden($id_responden)) {
            $_SESSION['error'] = 'Hasil tidak ditemukan untuk responden ini!';
            header('Location: index.php?controller=hasil&action=index');
            exit;
        }

        // Delete hasil
        if ($this->hasilModel->deleteByResponden($id_responden)) {
            $_SESSION['success'] = 'Hasil perhitungan berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus hasil perhitungan!';
        }

        header('Location: index.php?controller=hasil&action=index');
        exit;
    }

    // Delete all hasil
    public function deleteAll()
    {
        // Delete all hasil
        if ($this->hasilModel->deleteAll()) {
            $_SESSION['success'] = 'Semua hasil perhitungan berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus hasil perhitungan!';
        }

        header('Location: index.php?controller=hasil&action=index');
        exit;
    }
}
?>
