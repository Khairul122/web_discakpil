<?php
require_once 'RespondenModel.php';
require_once 'AlternatifModel.php';

class HasilModel
{
    public $conn;
    private $table = 'hasil_akhir';
    private $respondenModel;
    private $alternatifModel;

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->respondenModel = new RespondenModel($connection);
        $this->alternatifModel = new AlternatifModel($connection);
    }

    // Get all hasil with responden and alternatif details
    public function getAll()
    {
        try {
            $query = "SELECT h.*,
                             r.nama_lengkap,
                             r.usia,
                             r.pekerjaan,
                             a.nama_layanan
                      FROM " . $this->table . " h
                      JOIN responden r ON h.id_responden = r.id_responden
                      JOIN alternatif a ON h.id_alternatif_terbaik = a.id_alternatif
                      ORDER BY h.nilai_smart DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all hasil error: " . $e->getMessage());
            return false;
        }
    }

    // Get hasil grouped by respondent
    public function getAllGroupedByResponden()
    {
        // Not needed anymore since 1 record per responden
        return $this->getAll();
    }

    // Get hasil grouped by alternatif (layanan terbaik)
    public function getAllGroupedByAlternatif()
    {
        try {
            $query = "SELECT h.id_alternatif_terbaik as id_alternatif,
                             a.nama_layanan,
                             COUNT(*) as total_memilih,
                             AVG(h.nilai_smart) as rerata_smart
                      FROM " . $this->table . " h
                      JOIN alternatif a ON h.id_alternatif_terbaik = a.id_alternatif
                      GROUP BY h.id_alternatif_terbaik, a.nama_layanan
                      ORDER BY total_memilih DESC, rerata_smart DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all grouped by alternatif error: " . $e->getMessage());
            return [];
        }
    }

    // Get hasil by responden
    public function getByResponden($id_responden)
    {
        try {
            $query = "SELECT h.*,
                             a.nama_layanan
                      FROM " . $this->table . " h
                      JOIN alternatif a ON h.id_alternatif_terbaik = a.id_alternatif
                      WHERE h.id_responden = :id_responden
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get hasil by responden error: " . $e->getMessage());
            return false;
        }
    }

    // Get hasil by alternatif (responden yang memilih layanan ini sebagai terbaik)
    public function getByAlternatif($id_alternatif)
    {
        try {
            $query = "SELECT h.*,
                             r.nama_lengkap,
                             r.usia,
                             r.pekerjaan
                      FROM " . $this->table . " h
                      JOIN responden r ON h.id_responden = r.id_responden
                      WHERE h.id_alternatif_terbaik = :id_alternatif
                      ORDER BY h.nilai_smart DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get hasil by alternatif error: " . $e->getMessage());
            return false;
        }
    }

    // Get hasil by ID
    public function getById($id_hasil)
    {
        try {
            $query = "SELECT h.*,
                             r.nama_lengkap,
                             r.usia,
                             r.pekerjaan,
                             a.nama_layanan
                      FROM " . $this->table . " h
                      JOIN responden r ON h.id_responden = r.id_responden
                      JOIN alternatif a ON h.id_alternatif_terbaik = a.id_alternatif
                      WHERE h.id_hasil = :id_hasil
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_hasil', $id_hasil);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get hasil by ID error: " . $e->getMessage());
            return false;
        }
    }

    // Get top alternatif (layanan yang paling banyak dipilih sebagai terbaik)
    public function getTopAlternatif()
    {
        try {
            $query = "SELECT h.id_alternatif_terbaik as id_alternatif,
                             a.nama_layanan,
                             COUNT(*) as total_penilai
                      FROM " . $this->table . " h
                      JOIN alternatif a ON h.id_alternatif_terbaik = a.id_alternatif
                      GROUP BY h.id_alternatif_terbaik, a.nama_layanan
                      ORDER BY total_penilai DESC
                      LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Get average SMART for this alternatif
                $query2 = "SELECT AVG(nilai_smart) as rerata_smart
                          FROM " . $this->table . "
                          WHERE id_alternatif_terbaik = :id_alternatif";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindParam(':id_alternatif', $result['id_alternatif']);
                $stmt2->execute();
                $avg = $stmt2->fetch(PDO::FETCH_ASSOC);
                $result['rerata_smart'] = $avg['rerata_smart'];
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Get top alternatif error: " . $e->getMessage());
            return false;
        }
    }

    // Get ranking summary for all alternatif
    public function getAlternatifRanking()
    {
        return $this->getAllGroupedByAlternatif();
    }

    // Get statistics
    public function getStatistics()
    {
        try {
            $stats = [];

            // Total hasil (sama dengan total responden karena 1 record per responden)
            $query = "SELECT COUNT(*) as total FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_hasil'] = $result['total'];
            $stats['total_responden'] = $result['total'];

            // Total alternatif yang dipilih sebagai terbaik
            $query = "SELECT COUNT(DISTINCT id_alternatif_terbaik) as total FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_alternatif'] = $result['total'];

            // Rata-rata SMART keseluruhan
            $query = "SELECT AVG(nilai_smart) as rerata FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['rerata_keseluruhan'] = $result['rerata'];

            // Nilai SMART tertinggi
            $query = "SELECT MAX(nilai_smart) as max FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['nilai_tertinggi'] = $result['max'];

            // Nilai SMART terendah
            $query = "SELECT MIN(nilai_smart) as min FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['nilai_terendah'] = $result['min'];

            return $stats;
        } catch (PDOException $e) {
            error_log("Get statistics error: " . $e->getMessage());
            return [];
        }
    }

    // Delete hasil by responden
    public function deleteByResponden($id_responden)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_responden = :id_responden";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete hasil by responden error: " . $e->getMessage());
            return false;
        }
    }

    // Delete all hasil
    public function deleteAll()
    {
        try {
            $query = "DELETE FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete all hasil error: " . $e->getMessage());
            return false;
        }
    }

    // Check if hasil exists for responden
    public function hasHasilForResponden($id_responden)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE id_responden = :id_responden";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check hasil for responden error: " . $e->getMessage());
            return false;
        }
    }

    // Get all responden
    public function getAllResponden()
    {
        return $this->respondenModel->getAll();
    }

    // Get all alternatif
    public function getAllAlternatif()
    {
        return $this->alternatifModel->getAll();
    }
}
?>
