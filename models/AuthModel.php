<?php
class AuthModel
{
    private $conn;
    private $table = 'users';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function login($username, $password)
    {
        try {
            $query = "SELECT id_user, username, password, nama_lengkap, role
                     FROM " . $this->table . "
                     WHERE username = :username LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $storedPassword = $user['password'];

                if ($this->isMD5($storedPassword)) {
                    if (md5($password) === $storedPassword) {
                        return $user;
                    }
                } else {
                    if (password_verify($password, $storedPassword)) {
                        return $user;
                    }
                }
            }

            return false;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    private function isMD5($hash)
    {
        return preg_match('/^[a-f0-9]{32}$/', $hash);
    }

    public function getUserById($id_user)
    {
        try {
            $query = "SELECT id_user, username, nama_lengkap, role, created_at
                     FROM " . $this->table . "
                     WHERE id_user = :id_user LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user error: " . $e->getMessage());
            return false;
        }
    }

    public function register($username, $password, $nama_lengkap, $role = 'admin')
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, role)
                     VALUES (:username, :password, :nama_lengkap, :role)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllUsers()
    {
        try {
            $query = "SELECT id_user, username, nama_lengkap, role, created_at
                     FROM " . $this->table . "
                     ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all users error: " . $e->getMessage());
            return false;
        }
    }

    public function createUser($username, $password, $nama_lengkap, $role)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, role)
                     VALUES (:username, :password, :nama_lengkap, :role)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create user error: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id_user, $nama_lengkap, $role)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET nama_lengkap = :nama_lengkap, role = :role
                     WHERE id_user = :id_user";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update user error: " . $e->getMessage());
            return false;
        }
    }

    public function updatePassword($id_user, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "UPDATE " . $this->table . "
                     SET password = :password
                     WHERE id_user = :id_user";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update password error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id_user)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_user = :id_user";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_user', $id_user);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete user error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $query = "SELECT id_user, username, nama_lengkap, role, created_at
                     FROM " . $this->table . "
                     WHERE username = :username LIMIT 1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user by username error: " . $e->getMessage());
            return false;
        }
    }

    public function checkUsernameExists($username, $exclude_id = null)
    {
        try {
            if ($exclude_id) {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE username = :username AND id_user != :id_user";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':id_user', $exclude_id);
            } else {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE username = :username";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $username);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check username error: " . $e->getMessage());
            return false;
        }
    }

    public function migrateMD5ToBcrypt($id_user, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE " . $this->table . "
                     SET password = :password
                     WHERE id_user = :id_user";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Migrate password error: " . $e->getMessage());
            return false;
        }
    }

    public function hasPermission($role, $requiredRole)
    {
        $roleHierarchy = [
            'admin' => 1,
            'kepala_dinas' => 2,
            'staff' => 3
        ];

        if (!isset($roleHierarchy[$role]) || !isset($roleHierarchy[$requiredRole])) {
            return false;
        }

        return $roleHierarchy[$role] <= $roleHierarchy[$requiredRole];
    }
}
?>
