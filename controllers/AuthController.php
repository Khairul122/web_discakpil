<?php
require_once 'models/AuthModel.php';

class AuthController
{
    private $authModel;

    public function __construct($connection)
    {
        $this->authModel = new AuthModel($connection);
    }

    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard();
        }
        require_once 'views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username dan password wajib diisi!';
                header('Location: index.php?controller=auth&action=index');
                exit;
            }

            $user = $this->authModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['success'] = 'Selamat datang kembali, ' . $user['nama_lengkap'] . '! Anda berhasil login.';

                // Optional: Auto-migrate MD5 to bcrypt (check if hash is 32 chars hex)
                $storedPassword = $user['password'];
                if (preg_match('/^[a-f0-9]{32}$/', $storedPassword)) {
                    $this->authModel->migrateMD5ToBcrypt($user['id_user'], $password);
                }

                $this->redirectToDashboard();
            } else {
                $_SESSION['error'] = 'Username atau password salah!';
                header('Location: index.php?controller=auth&action=index');
                exit;
            }
        } else {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        
        session_start();
        $_SESSION['success'] = 'Anda telah berhasil keluar dari sistem.';
        header('Location: index.php?controller=landing&action=index');
        exit;
    }

    private function redirectToDashboard()
    {
        $role = $_SESSION['role'] ?? '';

        switch ($role) {
            case 'admin':
                header('Location: index.php?controller=admin&action=index');
                break;
            case 'kepala_dinas':
                header('Location: index.php?controller=kepalaDinas&action=index');
                break;
            case 'staff':
                header('Location: index.php?controller=staff&action=index');
                break;
            default:
                header('Location: index.php?controller=auth&action=logout');
        }
        exit;
    }

    public function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }
        return true;
    }

    public function requireRole($allowedRoles)
    {
        $this->checkAuth();

        if (!is_array($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }

        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            // Redirect berdasarkan role user yang sedang login
            $role = $_SESSION['role'] ?? '';
            switch ($role) {
                case 'admin':
                    header('Location: index.php?controller=admin&action=index');
                    break;
                case 'kepala_dinas':
                    header('Location: index.php?controller=kepalaDinas&action=index');
                    break;
                default:
                    header('Location: index.php?controller=auth&action=index');
            }
            exit;
        }

        return true;
    }
}
?>
