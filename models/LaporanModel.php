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

    public function getLaporanFormal()
    {
        try {
            $query_alternatif = "SELECT id_alternatif, kode_alternatif, nama_layanan
                                  FROM alternatif
                                  ORDER BY kode_alternatif ASC";
            $stmt_alt = $this->conn->prepare($query_alternatif);
            $stmt_alt->execute();
            $alternatifs = $stmt_alt->fetchAll(PDO::FETCH_ASSOC);

            $query_responden = "SELECT
                                    r.id_responden,
                                    r.nama_lengkap,
                                    h.nilai_smart as nilai_smart_terbaik,
                                    h.id_alternatif_terbaik,
                                    h.tanggal_perhitungan
                                  FROM {$this->table_hasil} h
                                  JOIN responden r ON h.id_responden = r.id_responden
                                  ORDER BY r.nama_lengkap ASC";
            $stmt_resp = $this->conn->prepare($query_responden);
            $stmt_resp->execute();
            $responden_data = $stmt_resp->fetchAll(PDO::FETCH_ASSOC);

            $query_nilai_alternatif = "SELECT
                                          p.id_responden,
                                          p.id_alternatif,
                                          a.kode_alternatif,
                                          SUM(sk.nilai_utility * k.bobot / 100) as nilai_smart
                                        FROM {$this->table_penilaian} p
                                        JOIN alternatif a ON p.id_alternatif = a.id_alternatif
                                        JOIN kriteria k ON p.id_kriteria = k.id_kriteria
                                        JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
                                        GROUP BY p.id_responden, p.id_alternatif, a.kode_alternatif
                                        ORDER BY p.id_responden, a.kode_alternatif";
            $stmt_nilai = $this->conn->prepare($query_nilai_alternatif);
            $stmt_nilai->execute();
            $nilai_alternatif_data = $stmt_nilai->fetchAll(PDO::FETCH_ASSOC);

            $nilai_per_responden_alternatif = [];
            foreach ($nilai_alternatif_data as $row) {
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
                        h.id_alternatif_terbaik,
                        alt_terbaik.nama_layanan as layanan_terbaik,
                        h.tanggal_perhitungan
                     FROM responden r
                     LEFT JOIN {$this->table_penilaian} p ON r.id_responden = p.id_responden
                     LEFT JOIN {$this->table_hasil} h ON r.id_responden = h.id_responden
                     LEFT JOIN alternatif alt_terbaik ON h.id_alternatif_terbaik = alt_terbaik.id_alternatif
                     WHERE 1=1";

            $params = [];

            if ($filter_responden > 0) {
                $query .= " AND r.id_responden = :id_responden";
                $params[':id_responden'] = $filter_responden;
            }

            $query .= " GROUP BY r.id_responden, r.nama_lengkap, r.usia, r.pekerjaan,
                          h.nilai_smart, h.id_alternatif_terbaik, alt_terbaik.nama_layanan, h.tanggal_perhitungan
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

    // Get laporan by alternatif
    public function getLaporanByAlternatif($filter_alternatif = 0)
    {
        try {
            $query = "SELECT
                        a.id_alternatif,
                        a.nama_layanan,
                        COUNT(DISTINCT p.id_responden) as total_responden,
                        COUNT(p.id_penilaian) as total_penilaian,
                        COUNT(DISTINCT h.id_responden) as total_memilih_terbaik,
                        AVG(h.nilai_smart) as rata_rata_smart
                     FROM alternatif a
                     LEFT JOIN {$this->table_penilaian} p ON a.id_alternatif = p.id_alternatif
                     LEFT JOIN {$this->table_hasil} h ON a.id_alternatif = h.id_alternatif_terbaik
                     WHERE 1=1";

            $params = [];

            if ($filter_alternatif > 0) {
                $query .= " AND a.id_alternatif = :id_alternatif";
                $params[':id_alternatif'] = $filter_alternatif;
            }

            $query .= " GROUP BY a.id_alternatif, a.nama_layanan
                       ORDER BY total_responden DESC";

            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get laporan by alternatif error: " . $e->getMessage());
            return false;
        }
    }

    // Get laporan perhitungan SMART per responden
    public function getLaporanSMART($id_responden)
    {
        try {
            // Get detail penilaian
            $penilaians = $this->getDetailPenilaianByResponden($id_responden);

            if (empty($penilaians)) {
                return false;
            }

            // Get all kriteria dengan bobot
            require_once 'KriteriaModel.php';
            $kriteriaModel = new KriteriaModel($this->conn);
            $kriterias = $kriteriaModel->getAll();
            $total_bobot = array_sum(array_column($kriterias, 'bobot'));

            // Normalisasi bobot
            $normalized_weights = [];
            foreach ($kriterias as $k) {
                $normalized_weights[$k['id_kriteria']] = $k['bobot'] / $total_bobot;
            }

            // Group penilaian by alternatif
            $penilaian_by_alternatif = [];
            foreach ($penilaians as $p) {
                $penilaian_by_alternatif[$p['nama_layanan']][] = $p;
            }

            // Hitung SMART untuk setiap alternatif
            $hasil_smart = [];
            foreach ($penilaian_by_alternatif as $nama_layanan => $penilaian_list) {
                $nilai_smart = 0;
                $detail_kriteria = [];

                foreach ($penilaian_list as $penilaian) {
                    $bobot_normal = $normalized_weights[$penilaian['id_kriteria']];
                    $nilai_utility = $penilaian['nilai_utility'];
                    $kontribusi = $bobot_normal * $nilai_utility;
                    $nilai_smart += $kontribusi;

                    $detail_kriteria[] = [
                        'kode_kriteria' => $penilaian['kode_kriteria'],
                        'nama_kriteria' => $penilaian['nama_kriteria'],
                        'bobot' => $penilaian['bobot'],
                        'bobot_normal' => $bobot_normal,
                        'nilai_utility' => $nilai_utility,
                        'kontribusi' => $kontribusi
                    ];
                }

                $hasil_smart[] = [
                    'nama_layanan' => $nama_layanan,
                    'nilai_smart' => $nilai_smart,
                    'detail_kriteria' => $detail_kriteria
                ];
            }

            // Sort by nilai_smart descending
            usort($hasil_smart, function($a, $b) {
                return $b['nilai_smart'] <=> $a['nilai_smart'];
            });

            // Add ranking
            foreach ($hasil_smart as $index => &$hasil) {
                $hasil['ranking'] = $index + 1;
            }

            return [
                'penilaians' => $penilaians,
                'hasil_smart' => $hasil_smart,
                'normalized_weights' => $normalized_weights,
                'total_bobot' => $total_bobot
            ];

        } catch (Exception $e) {
            error_log("Get laporan SMART error: " . $e->getMessage());
            return false;
        }
    }

    // Get statistics untuk laporan
    public function getStatistics()
    {
        try {
            $stats = [];

            // Total responden
            $query = "SELECT COUNT(*) as total FROM {$this->table_hasil}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['total_responden'] = $result['total'];

            // Rata-rata SMART
            $query = "SELECT AVG(nilai_smart) as rerata FROM {$this->table_hasil}";
            $stmt = $this->conn->prepare($query);
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
