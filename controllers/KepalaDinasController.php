<?php
require_once 'models/DashboardModel.php';

class KepalaDinasController
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

        // Admin dan kepala_dinas boleh akses
        $allowedRoles = ['admin', 'kepala_dinas'];
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=auth&action=index');
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
        $topLayanan = $this->dashboardModel->getTopLayanan(10);

        // Get chart data
        $chartKriteria = $this->dashboardModel->getChartKriteria();

        // Get kriteria distribution
        $kriteriaDist = $this->dashboardModel->getKriteriaDistribution();

        // Get survey trend
        $surveyTrend = $this->dashboardModel->getSurveyTrend();

        $data = [
            'title' => 'Dashboard Kepala Dinas - DISDUKCAPIL Kota Padang',
            'page_title' => 'Dashboard Kepala Dinas',
            'stats' => $stats,
            'activities' => $activities,
            'top_layanan' => $topLayanan,
            'chart_kriteria' => $chartKriteria,
            'kriteria_dist' => $kriteriaDist,
            'survey_trend' => $surveyTrend,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Kepala Dinas',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'kepala_dinas'
            ]
        ];

        require_once 'views/dashboard/kadis.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=auth&action=index');
        exit;
    }
}
?>
