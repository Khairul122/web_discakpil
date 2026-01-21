<?php
require_once 'KriteriaModel.php';

class SubKriteriaModel
{
    private $conn;
    private $table = 'sub_kriteria';
    private $kriteriaModel;

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->kriteriaModel = new KriteriaModel($connection);
    }

    public function getAll()
    {
        try {
            $query = "SELECT sk.*, k.nama_kriteria, k.kode_kriteria
                     FROM " . $this->table . " sk
                     JOIN kriteria k ON sk.id_kriteria = k.id_kriteria
                     ORDER BY k.kode_kriteria ASC, sk.nilai_utility DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all sub kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id_sub)
    {
        try {
            $query = "SELECT sk.*, k.nama_kriteria, k.kode_kriteria
                     FROM " . $this->table . " sk
                     JOIN kriteria k ON sk.id_kriteria = k.id_kriteria
                     WHERE sk.id_sub = :id_sub
                     LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_sub', $id_sub);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get sub kriteria by ID error: " . $e->getMessage());
            return false;
        }
    }

    public function getByKriteria($id_kriteria)
    {
        try {
            $query = "SELECT * FROM " . $this->table . "
                     WHERE id_kriteria = :id_kriteria
                     ORDER BY nilai_utility DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get sub kriteria by kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function create($id_kriteria, $nama_pilihan, $nilai_utility)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (id_kriteria, nama_pilihan, nilai_utility)
                     VALUES (:id_kriteria, :nama_pilihan, :nilai_utility)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->bindParam(':nama_pilihan', $nama_pilihan);
            $stmt->bindParam(':nilai_utility', $nilai_utility);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create sub kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id_sub, $id_kriteria, $nama_pilihan, $nilai_utility)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET id_kriteria = :id_kriteria,
                         nama_pilihan = :nama_pilihan,
                         nilai_utility = :nilai_utility
                     WHERE id_sub = :id_sub";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_sub', $id_sub);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->bindParam(':nama_pilihan', $nama_pilihan);
            $stmt->bindParam(':nilai_utility', $nilai_utility);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update sub kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id_sub)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_sub = :id_sub";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_sub', $id_sub);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete sub kriteria error: " . $e->getMessage());
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
            error_log("Get total sub kriteria error: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalByKriteria($id_kriteria)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE id_kriteria = :id_kriteria";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total by kriteria error: " . $e->getMessage());
            return 0;
        }
    }

    public function search($keyword)
    {
        try {
            $query = "SELECT sk.*, k.nama_kriteria, k.kode_kriteria
                     FROM " . $this->table . " sk
                     JOIN kriteria k ON sk.id_kriteria = k.id_kriteria
                     WHERE sk.nama_pilihan LIKE :keyword
                        OR k.nama_kriteria LIKE :keyword
                        OR k.kode_kriteria LIKE :keyword
                     ORDER BY k.kode_kriteria ASC, sk.nilai_utility DESC";

            $stmt = $this->conn->prepare($query);
            $keywordParam = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search sub kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllKriteria()
    {
        return $this->kriteriaModel->getAll();
    }

    public function getKriteriaById($id_kriteria)
    {
        return $this->kriteriaModel->getById($id_kriteria);
    }

    public function checkKriteriaExists($id_kriteria)
    {
        return $this->kriteriaModel->getById($id_kriteria) !== false;
    }
}
?>
