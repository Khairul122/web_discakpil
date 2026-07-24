<?php

class RespondenModel
{
    public $conn;
    private $table = 'responden';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_responden DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all responden error: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id_responden)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id_responden = :id_responden LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get responden by ID error: " . $e->getMessage());
            return false;
        }
    }

    public function create($nama_lengkap, $usia, $pekerjaan)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (nama_lengkap, usia, pekerjaan)
                     VALUES (:nama_lengkap, :usia, :pekerjaan)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':usia', $usia);
            $stmt->bindParam(':pekerjaan', $pekerjaan);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create responden error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id_responden, $nama_lengkap, $usia, $pekerjaan)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET nama_lengkap = :nama_lengkap,
                         usia = :usia,
                         pekerjaan = :pekerjaan
                     WHERE id_responden = :id_responden";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->bindParam(':nama_lengkap', $nama_lengkap);
            $stmt->bindParam(':usia', $usia);
            $stmt->bindParam(':pekerjaan', $pekerjaan);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update responden error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id_responden)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_responden = :id_responden";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete responden error: " . $e->getMessage());
            return false;
        }
    }

    public function getTotal()
    {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total responden error: " . $e->getMessage());
            return 0;
        }
    }

    public function search($keyword)
    {
        try {
            $query = "SELECT * FROM " . $this->table . "
                     WHERE nama_lengkap LIKE :keyword
                        OR pekerjaan LIKE :keyword
                     ORDER BY id_responden DESC";

            $stmt = $this->conn->prepare($query);
            $keywordParam = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search responden error: " . $e->getMessage());
            return false;
        }
    }

    // Statistik berdasarkan pekerjaan
    public function getTotalByPekerjaan()
    {
        try {
            $query = "SELECT pekerjaan, COUNT(*) as total
                     FROM " . $this->table . "
                     GROUP BY pekerjaan
                     ORDER BY total DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get total by pekerjaan error: " . $e->getMessage());
            return [];
        }
    }

    // Rata-rata usia responden
    public function getAverageAge()
    {
        try {
            $query = "SELECT AVG(usia) as avg_age FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['avg_age'] ? round($result['avg_age'], 1) : 0;
        } catch (PDOException $e) {
            error_log("Get average age error: " . $e->getMessage());
            return 0;
        }
    }

    // Responden terbaru
    public function getLatest($limit = 5)
    {
        try {
            $query = "SELECT * FROM " . $this->table . "
                     ORDER BY id_responden DESC
                     LIMIT :limit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get latest responden error: " . $e->getMessage());
            return [];
        }
    }
}
?>