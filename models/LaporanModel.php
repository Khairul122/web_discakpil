<?php
require_once 'RespondenModel.php';
require_once 'AlternatifModel.php';
require_once 'KriteriaModel.php';
require_once 'SubKriteriaModel.php';

class LaporanModel
{
    public $conn;
    private $table_penilaian = 'penilaian';
    private $table_hasil = 'hasil_akhir';

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    // Dibaca langsung dari hasil_akhir (matriks penuh responden x alternatif, hasil SmartCalculator
    // via PenilaianController). Tidak lagi menghitung ulang dengan SQL mentah, supaya angka di laporan
    // ini dijamin identik dengan angka di halaman Penilaian/Hasil (satu sumber kebenaran).
    // Precondition: "Hitung Ulang SMART" harus sudah dijalankan setelah ada penilaian baru.
    //
    // $start_date/$end_date (format 'Y-m-d H:i:s', opsional): filter berdasarkan responden.tanggal_isi
    // - kapan warga mengisi survei, bukan kapan SMART dihitung ulang.
    public function getLaporanFormal($start_date = null, $end_date = null)
    {
        try {
            $query_alternatif = "SELECT id_alternatif, kode_alternatif, nama_layanan
                                  FROM alternatif
                                  ORDER BY kode_alternatif ASC";
            $stmt_alt = $this->conn->prepare($query_alternatif);
            $stmt_alt->execute();
            $alternatifs = $stmt_alt->fetchAll(PDO::FETCH_ASSOC);

            $has_filter = $start_date && $end_date;
            $date_filter = $has_filter ? " AND r.tanggal_isi BETWEEN :start_date AND :end_date" : "";

            $query_responden = "SELECT
                                    r.id_responden,
                                    r.nama_lengkap,
                                    h.nilai_smart as nilai_smart_terbaik,
                                    h.id_alternatif,
                                    h.tanggal_perhitungan
                                  FROM {$this->table_hasil} h
                                  JOIN responden r ON h.id_responden = r.id_responden
                                  WHERE h.is_terbaik = 1{$date_filter}
                                  ORDER BY r.nama_lengkap ASC";
            $stmt_resp = $this->conn->prepare($query_responden);
            if ($has_filter) {
                $stmt_resp->bindValue(':start_date', $start_date);
                $stmt_resp->bindValue(':end_date', $end_date);
            }
            $stmt_resp->execute();
            $responden_data = $stmt_resp->fetchAll(PDO::FETCH_ASSOC);

            $query_matrix = "SELECT h.id_responden, a.kode_alternatif, h.nilai_smart
                              FROM {$this->table_hasil} h
                              JOIN alternatif a ON h.id_alternatif = a.id_alternatif
                              JOIN responden r ON h.id_responden = r.id_responden
                              WHERE 1=1{$date_filter}";
            $stmt_matrix = $this->conn->prepare($query_matrix);
            if ($has_filter) {
                $stmt_matrix->bindValue(':start_date', $start_date);
                $stmt_matrix->bindValue(':end_date', $end_date);
            }
            $stmt_matrix->execute();
            $matrix_data = $stmt_matrix->fetchAll(PDO::FETCH_ASSOC);

            $nilai_per_responden_alternatif = [];
            foreach ($matrix_data as $row) {
                $nilai_per_responden_alternatif[$row['id_responden']][$row['kode_alternatif']] = $row['nilai_smart'];
            }

            return [
                'alternatifs' => $alternatifs,
                'responden_data' => $responden_data,
                'nilai_per_responden_alternatif' => $nilai_per_responden_alternatif
            ];

        } catch (PDOException $e) {
            error_log("Get laporan formal error: " . $e->getMessage());
            return false;
        }
    }

    // Ringkasan kepuasan per layanan (output SKM inti): rata-rata skor SMART dari
    // SEMUA responden yang menilai layanan tersebut, bukan hanya yang menobatkannya favorit.
    //
    // $start_date/$end_date (opsional): filter berdasarkan responden.tanggal_isi. Filter dipasang
    // di klausa ON (bukan WHERE) supaya layanan yang tidak punya penilai pada periode itu tetap
    // muncul dengan total_penilai=0 (LEFT JOIN tidak rusak oleh WHERE pada kolom sisi kanan).
    public function getRingkasanPerLayanan($start_date = null, $end_date = null)
    {
        try {
            $has_filter = $start_date && $end_date;
            $join_filter = $has_filter
                ? " AND h.id_responden IN (SELECT id_responden FROM responden WHERE tanggal_isi BETWEEN :start_date AND :end_date)"
                : "";

            $query = "SELECT a.id_alternatif, a.kode_alternatif, a.nama_layanan,
                             COUNT(h.id_hasil) as total_penilai,
                             AVG(h.nilai_smart) as rerata_smart,
                             MIN(h.nilai_smart) as nilai_min,
                             MAX(h.nilai_smart) as nilai_max
                      FROM alternatif a
                      LEFT JOIN {$this->table_hasil} h ON a.id_alternatif = h.id_alternatif{$join_filter}
                      GROUP BY a.id_alternatif, a.kode_alternatif, a.nama_layanan
                      ORDER BY rerata_smart DESC";
            $stmt = $this->conn->prepare($query);
            if ($has_filter) {
                $stmt->bindValue(':start_date', $start_date);
                $stmt->bindValue(':end_date', $end_date);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get ringkasan per layanan error: " . $e->getMessage());
            return [];
        }
    }

    // Get laporan grouped by responden
    public function getLaporanByResponden($filter_responden = 0)
    {
        try {
            $query = "SELECT
                        r.id_responden,
                        r.nama_lengkap,
                        r.usia,
                        r.pekerjaan,
                        COUNT(DISTINCT p.id_alternatif) as total_layanan_dinilai,
                        COUNT(p.id_penilaian) as total_penilaian,
                        h.nilai_smart as nilai_smart_terbaik,
                        h.id_alternatif,
                        alt_terbaik.nama_layanan as layanan_terbaik,
                        h.tanggal_perhitungan
                     FROM responden r
                     LEFT JOIN {$this->table_penilaian} p ON r.id_responden = p.id_responden
                     LEFT JOIN {$this->table_hasil} h ON r.id_responden = h.id_responden AND h.is_terbaik = 1
                     LEFT JOIN alternatif alt_terbaik ON h.id_alternatif = alt_terbaik.id_alternatif
                     WHERE 1=1";

            $params = [];

            if ($filter_responden > 0) {
                $query .= " AND r.id_responden = :id_responden";
                $params[':id_responden'] = $filter_responden;
            }

            $query .= " GROUP BY r.id_responden, r.nama_lengkap, r.usia, r.pekerjaan,
                          h.nilai_smart, h.id_alternatif, alt_terbaik.nama_layanan, h.tanggal_perhitungan
                       ORDER BY r.nama_lengkap ASC";

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get laporan by responden error: " . $e->getMessage());
            return false;
        }
    }

    // Get laporan by responden dengan detail penilaian
    public function getDetailPenilaianByResponden($id_responden)
    {
        try {
            $query = "SELECT
                        r.nama_lengkap,
                        r.usia,
                        r.pekerjaan,
                        a.nama_layanan,
                        k.kode_kriteria,
                        k.nama_kriteria,
                        k.bobot,
                        sk.nama_pilihan,
                        sk.nilai_utility
                     FROM {$this->table_penilaian} p
                     JOIN responden r ON p.id_responden = r.id_responden
                     JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                     JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                     JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                     WHERE p.id_responden = :id_responden
                     ORDER BY a.nama_layanan ASC, k.kode_kriteria ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_responden', $id_responden);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get detail penilaian by responden error: " . $e->getMessage());
            return false;
        }
    }

    // Get statistics untuk laporan
    // $start_date/$end_date (opsional): filter berdasarkan responden.tanggal_isi
    public function getStatistics($start_date = null, $end_date = null)
    {
        try {
            $stats = [];
            $has_filter = $start_date && $end_date;
            $date_filter = $has_filter ? " AND r.tanggal_isi BETWEEN :start_date AND :end_date" : "";

            // Total responden (distinct - hasil_akhir sekarang berisi banyak baris per responden)
            $query = "SELECT COUNT(DISTINCT h.id_responden) as total
                      FROM {$this->table_hasil} h
                      JOIN responden r ON h.id_responden = r.id_responden
                      WHERE 1=1{$date_filter}";
            $stmt = $this->conn->prepare($query);
            if ($has_filter) {
                $stmt->bindValue(':start_date', $start_date);
                $stmt->bindValue(':end_date', $end_date);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_responden'] = $result['total'];

            // Rata-rata SMART dari skor layanan favorit tiap responden (konsisten dengan
            // footer "Rata-rata Nilai" pada laporan, yang menjumlahkan nilai_smart_terbaik)
            $query = "SELECT AVG(h.nilai_smart) as rerata
                      FROM {$this->table_hasil} h
                      JOIN responden r ON h.id_responden = r.id_responden
                      WHERE h.is_terbaik = 1{$date_filter}";
            $stmt = $this->conn->prepare($query);
            if ($has_filter) {
                $stmt->bindValue(':start_date', $start_date);
                $stmt->bindValue(':end_date', $end_date);
            }
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['rerata_smart'] = $result['rerata'];

            return $stats;
        } catch (PDOException $e) {
            error_log("Get statistics error: " . $e->getMessage());
            return [];
        }
    }
}
?>
