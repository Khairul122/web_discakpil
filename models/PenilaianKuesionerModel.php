<?php
require_once 'RespondenModel.php';
require_once 'AlternatifModel.php';
require_once 'KriteriaModel.php';
require_once 'SubKriteriaModel.php';

class PenilaianKuesionerModel
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
            error_log("Create penilaian kuesioner error: " . $e->getMessage());
            return false;
        }
    }

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

    public function checkAlternatifExists($id_alternatif)
    {
        return $this->alternatifModel->getById($id_alternatif) !== false;
    }

    public function checkSubKriteriaExists($id_sub)
    {
        return $this->subKriteriaModel->getById($id_sub) !== false;
    }
}
?>
