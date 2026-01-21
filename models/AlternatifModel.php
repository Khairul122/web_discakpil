<?php
class AlternatifModel
{
    private $conn;
    private $table = 'alternatif';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY id_alternatif ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all alternatif error: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id_alternatif)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id_alternatif = :id_alternatif LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get alternatif by ID error: " . $e->getMessage());
            return false;
        }
    }

    public function getByKode($kode_alternatif)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE kode_alternatif = :kode_alternatif LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kode_alternatif', $kode_alternatif);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get alternatif by kode error: " . $e->getMessage());
            return false;
        }
    }

    public function create($kode_alternatif, $nama_layanan, $keterangan)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (kode_alternatif, nama_layanan, keterangan)
                     VALUES (:kode_alternatif, :nama_layanan, :keterangan)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kode_alternatif', $kode_alternatif);
            $stmt->bindParam(':nama_layanan', $nama_layanan);
            $stmt->bindParam(':keterangan', $keterangan);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create alternatif error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id_alternatif, $kode_alternatif, $nama_layanan, $keterangan)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET kode_alternatif = :kode_alternatif,
                         nama_layanan = :nama_layanan,
                         keterangan = :keterangan
                     WHERE id_alternatif = :id_alternatif";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->bindParam(':kode_alternatif', $kode_alternatif);
            $stmt->bindParam(':nama_layanan', $nama_layanan);
            $stmt->bindParam(':keterangan', $keterangan);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update alternatif error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id_alternatif)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_alternatif = :id_alternatif";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete alternatif error: " . $e->getMessage());
            return false;
        }
    }

    public function checkKodeExists($kode_alternatif, $exclude_id = null)
    {
        try {
            if ($exclude_id) {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE kode_alternatif = :kode_alternatif AND id_alternatif != :id_alternatif";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':kode_alternatif', $kode_alternatif);
                $stmt->bindParam(':id_alternatif', $exclude_id);
            } else {
                $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                         WHERE kode_alternatif = :kode_alternatif";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':kode_alternatif', $kode_alternatif);
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
            error_log("Get total alternatif error: " . $e->getMessage());
            return 0;
        }
    }

    public function search($keyword)
    {
        try {
            $query = "SELECT * FROM " . $this->table . "
                     WHERE kode_alternatif LIKE :keyword
                        OR nama_layanan LIKE :keyword
                        OR keterangan LIKE :keyword
                     ORDER BY kode_alternatif ASC";

            $stmt = $this->conn->prepare($query);
            $keywordParam = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search alternatif error: " . $e->getMessage());
            return false;
        }
    }
}
?>
