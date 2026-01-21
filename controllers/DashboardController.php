<?php
class DashboardController
{
    public function __construct($connection = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard - DISDUKCAPIL Kota Padang',
            'page_title' => 'Dashboard',
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'User',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/dashboard/index.php';
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
