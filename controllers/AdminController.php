<?php
require_once 'models/DashboardModel.php';

class AdminController
{
    private $dashboardModel;

    public function __construct($connection)
    {
        // Check authentication dan role
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=dashboard&action=index');
            exit;
        }

        $this->dashboardModel = new DashboardModel($connection);
    }

    public function index()
    {
        // Get statistics
        $stats = $this->dashboardModel->getStatistics();

        // Get recent activities
        $activities = $this->dashboardModel->getRecentActivity();

        // Get top layanan
        $topLayanan = $this->dashboardModel->getTopLayanan(5);

        // Get chart data
        $chartKriteria = $this->dashboardModel->getChartKriteria();

        // Get kriteria distribution
        $kriteriaDist = $this->dashboardModel->getKriteriaDistribution();

        // Get recent responden
        $recentResponden = $this->dashboardModel->getRecentResponden(5);

        // Get layanan by performance
        $layananPerformance = $this->dashboardModel->getLayananByPerformance();

        $data = [
            'title' => 'Dashboard Admin - DISDUKCAPIL Kota Padang',
            'page_title' => 'Dashboard Administrator',
            'stats' => $stats,
            'activities' => $activities,
            'top_layanan' => $topLayanan,
            'chart_kriteria' => $chartKriteria,
            'kriteria_dist' => $kriteriaDist,
            'recent_responden' => $recentResponden,
            'layanan_performance' => $layananPerformance,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/dashboard/admin.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=auth&action=index');
        exit;
    }

    public function profile()
    {
        $data = [
            'title' => 'Profile Admin - DISDUKCAPIL Kota Padang',
            'page_title' => 'Profile Saya',
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/dashboard/profile.php';
    }
}
?>
