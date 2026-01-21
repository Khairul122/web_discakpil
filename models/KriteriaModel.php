<?php
class KriteriaModel
{
    private $conn;
    private $table = 'kriteria';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY kode_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id_kriteria)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id_kriteria = :id_kriteria LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get kriteria by ID error: " . $e->getMessage());
            return false;
        }
    }

    public function getByKode($kode_kriteria)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE kode_kriteria = :kode_kriteria LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kode_kriteria', $kode_kriteria);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get kriteria by kode error: " . $e->getMessage());
            return false;
        }
    }

    public function create($kode_kriteria, $nama_kriteria, $pertanyaan, $bobot, $jenis)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (kode_kriteria, nama_kriteria, pertanyaan, bobot, jenis)
                     VALUES (:kode_kriteria, :nama_kriteria, :pertanyaan, :bobot, :jenis)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kode_kriteria', $kode_kriteria);
            $stmt->bindParam(':nama_kriteria', $nama_kriteria);
            $stmt->bindParam(':pertanyaan', $pertanyaan);
            $stmt->bindParam(':bobot', $bobot);
            $stmt->bindParam(':jenis', $jenis);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id_kriteria, $kode_kriteria, $nama_kriteria, $pertanyaan, $bobot, $jenis)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET kode_kriteria = :kode_kriteria,
                         nama_kriteria = :nama_kriteria,
                         pertanyaan = :pertanyaan,
                         bobot = :bobot,
                         jenis = :jenis
                     WHERE id_kriteria = :id_kriteria";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->bindParam(':kode_kriteria', $kode_kriteria);
            $stmt->bindParam(':nama_kriteria', $nama_kriteria);
            $stmt->bindParam(':pertanyaan', $pertanyaan);
            $stmt->bindParam(':bobot', $bobot);
            $stmt->bindParam(':jenis', $jenis);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id_kriteria)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_kriteria = :id_kriteria";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function checkKodeExists($kode_kriteria, $exclude_id = null)
    {
        try {
            if ($exclude_id) {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE kode_kriteria = :kode_kriteria AND id_kriteria != :id_kriteria";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':kode_kriteria', $kode_kriteria);
                $stmt->bindParam(':id_kriteria', $exclude_id);
            } else {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE kode_kriteria = :kode_kriteria";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':kode_kriteria', $kode_kriteria);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check kode exists error: " . $e->getMessage());
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
            error_log("Get total kriteria error: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalBobot()
    {
        try {
            $query = "SELECT SUM(bobot) as total_bobot FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_bobot'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total bobot error: " . $e->getMessage());
            return 0;
        }
    }

    public function search($keyword)
    {
        try {
            $query = "SELECT * FROM " . $this->table . "
                     WHERE kode_kriteria LIKE :keyword
                        OR nama_kriteria LIKE :keyword
                        OR pertanyaan LIKE :keyword
                     ORDER BY kode_kriteria ASC";

            $stmt = $this->conn->prepare($query);
            $keywordParam = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function getBenefitCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE jenis = 'benefit'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get benefit count error: " . $e->getMessage());
            return 0;
        }
    }

    public function getCostCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE jenis = 'cost'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Get cost count error: " . $e->getMessage());
            return 0;
        }
    }
}
?>
