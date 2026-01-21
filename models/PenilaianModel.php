<?php
require_once 'RespondenModel.php';
require_once 'AlternatifModel.php';
require_once 'KriteriaModel.php';
require_once 'SubKriteriaModel.php';

class PenilaianModel
{
    public $conn;
    private $table = 'penilaian';
    private $respondenModel;
    private $alternatifModel;
    private $kriteriaModel;
    private $subKriteriaModel;

    public function __construct($connection)
    {
        $this->conn = $connection;
        $this->respondenModel = new RespondenModel($connection);
        $this->alternatifModel = new AlternatifModel($connection);
        $this->kriteriaModel = new KriteriaModel($connection);
        $this->subKriteriaModel = new SubKriteriaModel($connection);
    }

    public function getAll()
    {
        try {
            $query = "SELECT p.*, r.nama_responden, a.nama_layanan, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     ORDER BY p.id_penilaian DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all penilaian error: " . $e->getMessage());
            return false;
        }
    }

    public function getById($id_penilaian)
    {
        try {
            $query = "SELECT p.*, r.nama_responden, a.nama_layanan, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE p.id_penilaian = :id_penilaian
                     LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_penilaian', $id_penilaian);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get penilaian by ID error: " . $e->getMessage());
            return false;
        }
    }

    public function getByResponden($id_responden)
    {
        try {
            $query = "SELECT p.*, a.nama_layanan, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE p.id_responden = :id_responden
                     ORDER BY k.kode_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get penilaian by responden error: " . $e->getMessage());
            return false;
        }
    }

    public function getByAlternatif($id_alternatif)
    {
        try {
            $query = "SELECT p.*, r.nama_responden, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE p.id_alternatif = :id_alternatif
                     ORDER BY p.id_penilaian DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get penilaian by alternatif error: " . $e->getMessage());
            return false;
        }
    }

    public function create($id_responden, $id_alternatif, $id_kriteria, $id_sub)
    {
        try {
            $query = "INSERT INTO " . $this->table . " (id_responden, id_alternatif, id_kriteria, id_sub)
                     VALUES (:id_responden, :id_alternatif, :id_kriteria, :id_sub)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->bindParam(':id_sub', $id_sub);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create penilaian error: " . $e->getMessage());
            return false;
        }
    }

    public function update($id_penilaian, $id_responden, $id_alternatif, $id_kriteria, $id_sub)
    {
        try {
            $query = "UPDATE " . $this->table . "
                     SET id_responden = :id_responden,
                         id_alternatif = :id_alternatif,
                         id_kriteria = :id_kriteria,
                         id_sub = :id_sub
                     WHERE id_penilaian = :id_penilaian";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_penilaian', $id_penilaian);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->bindParam(':id_kriteria', $id_kriteria);
            $stmt->bindParam(':id_sub', $id_sub);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update penilaian error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id_penilaian)
    {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id_penilaian = :id_penilaian";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_penilaian', $id_penilaian);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete penilaian error: " . $e->getMessage());
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
            error_log("Get total penilaian error: " . $e->getMessage());
            return 0;
        }
    }

    public function getTotalByAlternatif($id_alternatif)
    {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE id_alternatif = :id_alternatif";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Get total by alternatif error: " . $e->getMessage());
            return 0;
        }
    }

    public function search($keyword)
    {
        try {
            $query = "SELECT p.*, r.nama_responden, a.nama_layanan, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE r.nama_responden LIKE :keyword
                        OR a.nama_layanan LIKE :keyword
                        OR k.nama_kriteria LIKE :keyword
                        OR sk.nama_pilihan LIKE :keyword
                     ORDER BY p.id_penilaian DESC";

            $stmt = $this->conn->prepare($query);
            $keywordParam = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keywordParam);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search penilaian error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllResponden()
    {
        return $this->respondenModel->getAll();
    }

    public function getAllAlternatif()
    {
        return $this->alternatifModel->getAll();
    }

    public function getAllKriteria()
    {
        return $this->kriteriaModel->getAll();
    }

    public function getSubKriteriaByKriteria($id_kriteria)
    {
        return $this->subKriteriaModel->getByKriteria($id_kriteria);
    }

    public function checkRespondenExists($id_responden)
    {
        return $this->respondenModel->getById($id_responden) !== false;
    }

    public function checkAlternatifExists($id_alternatif)
    {
        return $this->alternatifModel->getById($id_alternatif) !== false;
    }

    public function checkKriteriaExists($id_kriteria)
    {
        return $this->kriteriaModel->getById($id_kriteria) !== false;
    }

    public function checkSubKriteriaExists($id_sub)
    {
        return $this->subKriteriaModel->getById($id_sub) !== false;
    }

    // Untuk mendapatkan penilaian berdasarkan responden dan alternatif
    public function getByRespondenAndAlternatif($id_responden, $id_alternatif)
    {
        try {
            $query = "SELECT p.*, k.nama_kriteria, k.kode_kriteria, sk.nama_pilihan, sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE p.id_responden = :id_responden
                       AND p.id_alternatif = :id_alternatif
                     ORDER BY k.kode_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get penilaian by responden and alternatif error: " . $e->getMessage());
            return false;
        }
    }

    // Cek apakah responden sudah menilai alternatif tertentu
    public function hasRespondenRatedAlternatif($id_responden, $id_alternatif)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . "
                     WHERE id_responden = :id_responden
                     AND id_alternatif = :id_alternatif";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->bindParam(':id_alternatif', $id_alternatif);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Check responden rated alternatif error: " . $e->getMessage());
            return false;
        }
    }

    // Mendapatkan data penilaian yang dikelompokkan berdasarkan responden
    public function getAllGroupedByResponden()
    {
        try {
            $query = "SELECT
                        p.id_penilaian,
                        p.id_responden,
                        r.nama_lengkap,
                        r.usia,
                        r.pekerjaan,
                        p.id_alternatif,
                        a.nama_layanan,
                        p.id_kriteria,
                        k.nama_kriteria,
                        k.kode_kriteria,
                        p.id_sub,
                        sk.nama_pilihan,
                        sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     ORDER BY r.nama_lengkap ASC, a.nama_layanan ASC, k.kode_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group by responden
            $grouped = [];
            foreach ($results as $row) {
                $respondenId = $row['id_responden'];
                $alternatifId = $row['id_alternatif'];

                if (!isset($grouped[$respondenId])) {
                    $grouped[$respondenId] = [
                        'id_responden' => $row['id_responden'],
                        'nama_responden' => $row['nama_lengkap'],
                        'usia' => $row['usia'],
                        'pekerjaan' => $row['pekerjaan'],
                        'penilaians' => []
                    ];
                }

                if (!isset($grouped[$respondenId]['penilaians'][$alternatifId])) {
                    $grouped[$respondenId]['penilaians'][$alternatifId] = [
                        'id_alternatif' => $row['id_alternatif'],
                        'nama_layanan' => $row['nama_layanan'],
                        'kriterias' => []
                    ];
                }

                $grouped[$respondenId]['penilaians'][$alternatifId]['kriterias'][] = [
                    'id_penilaian' => $row['id_penilaian'],
                    'id_kriteria' => $row['id_kriteria'],
                    'nama_kriteria' => $row['nama_kriteria'],
                    'kode_kriteria' => $row['kode_kriteria'],
                    'id_sub' => $row['id_sub'],
                    'nama_pilihan' => $row['nama_pilihan'],
                    'nilai_utility' => $row['nilai_utility']
                ];
            }

            return array_values($grouped);
        } catch (Exception $e) {
            error_log("Get all grouped by responden error: " . $e->getMessage());
            return [];
        }
    }

    // Mendapatkan data penilaian yang dikelompokkan berdasarkan responden dengan filter
    public function getAllGroupedByRespondenWithFilter($keyword = '', $filter_alternatif = 0)
    {
        try {
            $query = "SELECT
                        p.id_penilaian,
                        p.id_responden,
                        r.nama_lengkap,
                        r.usia,
                        r.pekerjaan,
                        p.id_alternatif,
                        a.nama_layanan,
                        p.id_kriteria,
                        k.nama_kriteria,
                        k.kode_kriteria,
                        p.id_sub,
                        sk.nama_pilihan,
                        sk.nilai_utility
                     FROM " . $this->table . " p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE 1=1";

            $params = [];

            if (!empty($keyword)) {
                $query .= " AND (r.nama_lengkap LIKE :keyword
                              OR a.nama_layanan LIKE :keyword
                              OR k.nama_kriteria LIKE :keyword
                              OR sk.nama_pilihan LIKE :keyword)";
                $params[':keyword'] = "%{$keyword}%";
            }

            if ($filter_alternatif > 0) {
                $query .= " AND p.id_alternatif = :id_alternatif";
                $params[':id_alternatif'] = $filter_alternatif;
            }

            $query .= " ORDER BY r.nama_lengkap ASC, a.nama_layanan ASC, k.kode_kriteria ASC";

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group by responden
            $grouped = [];
            foreach ($results as $row) {
                $respondenId = $row['id_responden'];
                $alternatifId = $row['id_alternatif'];

                if (!isset($grouped[$respondenId])) {
                    $grouped[$respondenId] = [
                        'id_responden' => $row['id_responden'],
                        'nama_responden' => $row['nama_lengkap'],
                        'usia' => $row['usia'],
                        'pekerjaan' => $row['pekerjaan'],
                        'penilaians' => []
                    ];
                }

                if (!isset($grouped[$respondenId]['penilaians'][$alternatifId])) {
                    $grouped[$respondenId]['penilaians'][$alternatifId] = [
                        'id_alternatif' => $row['id_alternatif'],
                        'nama_layanan' => $row['nama_layanan'],
                        'kriterias' => []
                    ];
                }

                $grouped[$respondenId]['penilaians'][$alternatifId]['kriterias'][] = [
                    'id_penilaian' => $row['id_penilaian'],
                    'id_kriteria' => $row['id_kriteria'],
                    'nama_kriteria' => $row['nama_kriteria'],
                    'kode_kriteria' => $row['kode_kriteria'],
                    'id_sub' => $row['id_sub'],
                    'nama_pilihan' => $row['nama_pilihan'],
                    'nilai_utility' => $row['nilai_utility']
                ];
            }

            return array_values($grouped);
        } catch (Exception $e) {
            error_log("Get all grouped by responden with filter error: " . $e->getMessage());
            return [];
        }
    }
}
?>
