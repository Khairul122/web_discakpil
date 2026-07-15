<?php
class DashboardModel
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function getStatistics()
    {
        $stats = [];

        try {
            // Total alternatif (layanan)
            $query = "SELECT COUNT(*) as total FROM alternatif";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_alternatif'] = $result['total'];

            // Total kriteria
            $query = "SELECT COUNT(*) as total FROM kriteria";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_kriteria'] = $result['total'];

            // Total sub kriteria
            $query = "SELECT COUNT(*) as total FROM sub_kriteria";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_sub_kriteria'] = $result['total'];

            // Total responden
            $query = "SELECT COUNT(*) as total FROM responden";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_responden'] = $result['total'];

            // Total penilaian
            $query = "SELECT COUNT(*) as total FROM penilaian";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_penilaian'] = $result['total'];

            // Total hasil SMART
            $query = "SELECT COUNT(*) as total FROM hasil_akhir";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_hasil'] = $result['total'];

            return $stats;
        } catch (PDOException $e) {
            error_log("Get statistics error: " . $e->getMessage());
            return false;
        }
    }

    public function getRecentActivity()
    {
        try {
            $activities = [];

            // Penilaian terbaru
            $query = "SELECT p.*, r.nama_lengkap as nama_responden, a.nama_layanan as nama_layanan,
                             k.nama_kriteria as nama_kriteria, s.nama_pilihan as nama_sub
                     FROM penilaian p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria s ON p.id_sub = s.id_sub
                     ORDER BY p.id_penilaian DESC LIMIT 5";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $activities['penilaian'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Hasil SMART terbaru (5 responden terakhir yang dihitung, layanan favoritnya)
            $query = "SELECT h.*, a.nama_layanan, a.kode_alternatif
                     FROM hasil_akhir h
                     JOIN alternatif a ON h.id_alternatif = a.id_alternatif
                     WHERE h.is_terbaik = 1
                     ORDER BY h.tanggal_perhitungan DESC
                     LIMIT 5";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $activities['hasil_smart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $activities;
        } catch (PDOException $e) {
            error_log("Get recent activity error: " . $e->getMessage());
            return false;
        }
    }

    // Rata-rata SMART per layanan dari SEMUA responden yang menilainya (agregat SKM)
    public function getTopLayanan($limit = 5)
    {
        try {
            $query = "SELECT a.id_alternatif, a.kode_alternatif, a.nama_layanan,
                             AVG(h.nilai_smart) as rata_nilai, COUNT(h.id_hasil) as total_penilaian
                     FROM hasil_akhir h
                     JOIN alternatif a ON h.id_alternatif = a.id_alternatif
                     GROUP BY a.id_alternatif, a.kode_alternatif, a.nama_layanan
                     ORDER BY rata_nilai DESC
                     LIMIT :limit";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get top layanan error: " . $e->getMessage());
            return false;
        }
    }

    public function getChartKriteria()
    {
        try {
            $query = "SELECT k.id_kriteria, k.kode_kriteria, k.nama_kriteria, k.bobot, k.jenis,
                             COUNT(s.id_sub) as total_sub
                     FROM kriteria k
                     LEFT JOIN sub_kriteria s ON k.id_kriteria = s.id_kriteria
                     GROUP BY k.id_kriteria, k.kode_kriteria, k.nama_kriteria, k.bobot, k.jenis
                     ORDER BY k.bobot DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get chart kriteria error: " . $e->getMessage());
            return false;
        }
    }

    public function getRecentResponden($limit = 5)
    {
        try {
            $query = "SELECT * FROM responden
                     ORDER BY tanggal_isi DESC
                     LIMIT :limit";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get recent responden error: " . $e->getMessage());
            return false;
        }
    }

    public function getKriteriaDistribution()
    {
        try {
            $query = "SELECT jenis, COUNT(*) as total, SUM(bobot) as total_bobot
                     FROM kriteria
                     GROUP BY jenis";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get kriteria distribution error: " . $e->getMessage());
            return false;
        }
    }

    public function getSurveyTrend()
    {
        try {
            $query = "SELECT DATE_FORMAT(tanggal_isi, '%Y-%m') as bulan,
                             COUNT(*) as total_survey
                     FROM responden
                     GROUP BY DATE_FORMAT(tanggal_isi, '%Y-%m')
                     ORDER BY bulan DESC
                     LIMIT 12";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get survey trend error: " . $e->getMessage());
            return false;
        }
    }
}
?>
