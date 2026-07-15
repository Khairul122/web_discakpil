<?php
require_once 'models/PenilaianModel.php';
require_once 'models/SmartCalculator.php';

class PenilaianController
{
    private $penilaianModel;

    public function __construct($connection)
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        // Role check - hanya admin dan staff yang boleh akses (kepala_dinas dibatasi ke Dashboard + Cetak Laporan)
        $allowedRoles = ['admin', 'staff'];
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        $this->penilaianModel = new PenilaianModel($connection);
    }

    public function index()
    {
        // Get search keyword if exists
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $filter_alternatif = isset($_GET['id_alternatif']) ? intval($_GET['id_alternatif']) : 0;

        // Get data grouped by responden
        if (!empty($keyword) || $filter_alternatif > 0) {
            $penilaians = $this->penilaianModel->getAllGroupedByRespondenWithFilter($keyword, $filter_alternatif);
        } else {
            $penilaians = $this->penilaianModel->getAllGroupedByResponden();
        }

        // Ensure penilaians is an array
        if ($penilaians === false) {
            $penilaians = [];
        }

        $data = [
            'title' => 'Kelola Penilaian - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kelola Penilaian Responden',
            'penilaians' => $penilaians,
            'keyword' => $keyword,
            'filter_alternatif' => $filter_alternatif,
            'total' => $this->penilaianModel->getTotal(),
            'alternatifs' => $this->penilaianModel->getAllAlternatif(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/penilaian/index.php';
    }

    public function detail()
    {
        $id_penilaian = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_penilaian <= 0) {
            $_SESSION['error'] = 'ID penilaian tidak valid!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        $penilaian = $this->penilaianModel->getById($id_penilaian);

        if (!$penilaian) {
            $_SESSION['error'] = 'Penilaian tidak ditemukan!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        $data = [
            'title' => 'Detail Penilaian - DISDUKCAPIL Kota Padang',
            'page_title' => 'Detail Penilaian',
            'penilaian' => $penilaian,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/penilaian/detail.php';
    }

    // Detail perhitungan SMART untuk responden
    public function detailSmart()
    {
        $id_responden = isset($_GET['id_responden']) ? intval($_GET['id_responden']) : 0;

        if ($id_responden <= 0) {
            $_SESSION['error'] = 'ID responden tidak valid!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        // Ambil data responden
        require_once 'models/RespondenModel.php';
        $respondenModel = new RespondenModel($this->penilaianModel->conn);
        $responden = $respondenModel->getById($id_responden);

        if (!$responden) {
            $_SESSION['error'] = 'Responden tidak ditemukan!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        // Ambil semua penilaian untuk responden ini
        $penilaians = $this->penilaianModel->getByResponden($id_responden);

        if (empty($penilaians)) {
            $_SESSION['error'] = 'Tidak ada data penilaian untuk responden ini!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        // ========================================
        // METODE SMART (Simple Multi-Attribute Rating Technique)
        // ========================================

        // 1. Ambil semua kriteria dengan bobot, normalisasi, lalu hitung skor tiap alternatif
        $kriterias = $this->penilaianModel->getAllKriteria();
        $normalized_weights = SmartCalculator::normalizeWeights($kriterias);
        $hasil_smart = SmartCalculator::calculateAllAlternatif($penilaians, $normalized_weights);

        // 2. Lengkapi nama layanan untuk setiap hasil
        $alternatif_map = [];
        foreach ($this->penilaianModel->getAllAlternatif() as $alt) {
            $alternatif_map[$alt['id_alternatif']] = $alt['nama_layanan'];
        }
        foreach ($hasil_smart as &$hasil) {
            $hasil['nama_layanan'] = $alternatif_map[$hasil['id_alternatif']] ?? '-';
        }
        unset($hasil);

        // 3. Simpan seluruh matriks (responden x alternatif) ke tabel hasil_akhir,
        //    tandai ranking #1 sebagai layanan favorit responden (is_terbaik)
        if (!empty($hasil_smart)) {
            try {
                $upsert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif, nilai_smart, is_terbaik, tanggal_perhitungan)
                                 VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                                 ON DUPLICATE KEY UPDATE
                                    nilai_smart = VALUES(nilai_smart),
                                    is_terbaik = VALUES(is_terbaik),
                                    tanggal_perhitungan = CURRENT_TIMESTAMP";
                $stmt = $this->penilaianModel->conn->prepare($upsert_query);

                foreach ($hasil_smart as $row) {
                    $is_terbaik = ($row['ranking'] === 1) ? 1 : 0;
                    $stmt->execute([$id_responden, $row['id_alternatif'], $row['nilai_smart'], $is_terbaik]);
                }
            } catch (Exception $e) {
                error_log("Error saving hasil SMART: " . $e->getMessage());
            }
        }

        $data = [
            'title' => 'Hasil Analisis SMART - DISDUKCAPIL Kota Padang',
            'page_title' => 'Hasil Perhitungan Metode SMART',
            'responden' => $responden,
            'penilaians' => $penilaians,
            'hasil_smart' => $hasil_smart,
            'normalized_weights' => $normalized_weights,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/penilaian/detail_smart.php';
    }

    public function delete()
    {
        $id_penilaian = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_penilaian <= 0) {
            $_SESSION['error'] = 'ID penilaian tidak valid!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        // Check if data exists
        $penilaian = $this->penilaianModel->getById($id_penilaian);
        if (!$penilaian) {
            $_SESSION['error'] = 'Penilaian tidak ditemukan!';
            header('Location: index.php?controller=penilaian&action=index');
            exit;
        }

        // Delete data
        if ($this->penilaianModel->delete($id_penilaian)) {
            $_SESSION['success'] = 'Penilaian berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus penilaian!';
        }

        header('Location: index.php?controller=penilaian&action=index');
        exit;
    }

    // Calculate SMART for all respondents
    public function calculateAllSMART()
    {
        header('Content-Type: application/json');

        try {
            require_once 'models/RespondenModel.php';
            $respondenModel = new RespondenModel($this->penilaianModel->conn);

            // Get all respondents
            $respondens = $respondenModel->getAll();

            if (empty($respondens)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Tidak ada data responden'
                ]);
                exit;
            }

            // Get all kriteria with weights
            $kriterias = $this->penilaianModel->getAllKriteria();
            if (empty($kriterias)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Tidak ada data kriteria'
                ]);
                exit;
            }

            // Normalisasi bobot (satu kali untuk semua responden)
            $normalized_weights = SmartCalculator::normalizeWeights($kriterias);

            $total_responden_processed = 0;
            $total_hasil_created = 0;
            $errors = [];

            $upsert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif, nilai_smart, is_terbaik, tanggal_perhitungan)
                             VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                             ON DUPLICATE KEY UPDATE
                                nilai_smart = VALUES(nilai_smart),
                                is_terbaik = VALUES(is_terbaik),
                                tanggal_perhitungan = CURRENT_TIMESTAMP";
            $upsert_stmt = $this->penilaianModel->conn->prepare($upsert_query);

            // Process each respondent
            foreach ($respondens as $responden) {
                $id_responden = $responden['id_responden'];

                try {
                    // Get penilaians for this respondent
                    $penilaians = $this->penilaianModel->getByResponden($id_responden);

                    if (empty($penilaians)) {
                        continue; // Skip if no penilaians
                    }

                    // Calculate SMART for each alternatif rated by this respondent
                    $hasil_smart = SmartCalculator::calculateAllAlternatif($penilaians, $normalized_weights);

                    // SIMPAN SELURUH MATRIKS (setiap alternatif) KE TABEL hasil_akhir
                    if (!empty($hasil_smart)) {
                        try {
                            foreach ($hasil_smart as $row) {
                                if (!empty($row['incomplete'])) {
                                    $errors[] = "Responden ID {$id_responden}: hasil dihitung dari data yang tidak lengkap (ada kriteria aktif yang belum dinilai untuk layanan ini), skor mungkin kurang akurat.";
                                }

                                $is_terbaik = ($row['ranking'] === 1) ? 1 : 0;
                                $upsert_stmt->execute([$id_responden, $row['id_alternatif'], $row['nilai_smart'], $is_terbaik]);
                                $total_hasil_created++;
                            }

                            $total_responden_processed++;

                        } catch (Exception $e) {
                            error_log("Error saving hasil_akhir for respondent ID {$id_responden}: " . $e->getMessage());
                            // Don't throw error, just log it
                            $errors[] = "Responden ID {$id_responden}: " . $e->getMessage();
                        }
                    }

                } catch (Exception $e) {
                    // Log error
                    $errors[] = "Responden ID {$id_responden}: " . $e->getMessage();
                    error_log("Error processing respondent ID {$id_responden}: " . $e->getMessage());
                }
            }

            // Prepare response
            if ($total_responden_processed > 0) {
                $response = [
                    'success' => true,
                    'message' => 'Perhitungan SMART berhasil diselesaikan',
                    'total_responden' => $total_responden_processed,
                    'total_hasil' => $total_hasil_created,
                ];

                // Include errors if any (warnings)
                if (!empty($errors)) {
                    $response['errors'] = $errors;
                    $response['has_warnings'] = true;
                    $response['warning_message'] = 'Beberapa responden gagal diproses. Cek error log untuk detail.';
                }

                echo json_encode($response);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Tidak ada responden yang memiliki data penilaian lengkap',
                    'errors' => $errors
                ]);
            }

        } catch (Exception $e) {
            error_log("Calculate all SMART error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'debug_info' => [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }

        exit;
    }

    // Form penilaian untuk responden (user-friendly form)
    public function formPenilaian()
    {
        $data = [
            'title' => 'Form Penilaian Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Formulir Penilaian Layanan',
            'form_action' => 'index.php?controller=penilaian&action=submitPenilaian',
            'alternatifs' => $this->penilaianModel->getAllAlternatif(),
            'kriterias' => $this->penilaianModel->getAllKriteria(),
            'penilaianModel' => $this->penilaianModel,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/penilaian/form_penilaian.php';
    }

    // Submit penilaian dari form user-friendly
    public function submitPenilaian()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        }

        // Get form data
        $nama_responden = trim($_POST['nama_responden'] ?? '');
        $usia = intval($_POST['usia'] ?? 0);
        $pekerjaan = trim($_POST['pekerjaan'] ?? '');
        $id_alternatif = intval($_POST['id_alternatif'] ?? 0);

        // Validation responden data
        if (empty($nama_responden) || $usia <= 0 || $usia > 120 || empty($pekerjaan)) {
            $_SESSION['error'] = 'Data diri tidak lengkap atau tidak valid!';
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        }

        // Check if alternatif exists
        if (!$this->penilaianModel->checkAlternatifExists($id_alternatif)) {
            $_SESSION['error'] = 'Layanan tidak ditemukan!';
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        }

        // Create or get responden (by name, age, job)
        require_once 'models/RespondenModel.php';
        $respondenModel = new RespondenModel($this->penilaianModel->conn);

        // Check if responden with same data exists
        $existingRespondens = $respondenModel->search($nama_responden);
        $id_responden = 0;

        foreach ($existingRespondens as $existing) {
            if ($existing['nama_lengkap'] === $nama_responden &&
                $existing['usia'] == $usia &&
                $existing['pekerjaan'] === $pekerjaan) {
                $id_responden = $existing['id_responden'];
                break;
            }
        }

        // If not exists, create new responden
        if ($id_responden <= 0) {
            if ($respondenModel->create($nama_responden, $usia, $pekerjaan)) {
                // Get the newly created respondent ID
                $newRespondens = $respondenModel->search($nama_responden);
                foreach ($newRespondens as $new) {
                    if ($new['nama_lengkap'] === $nama_responden &&
                        $new['usia'] == $usia &&
                        $new['pekerjaan'] === $pekerjaan) {
                        $id_responden = $new['id_responden'];
                        break;
                    }
                }
            } else {
                $_SESSION['error'] = 'Gagal membuat data responden!';
                header('Location: index.php?controller=penilaian&action=formPenilaian');
                exit;
            }
        }

        // Check if responden already rated this alternatif
        if ($this->penilaianModel->hasRespondenRatedAlternatif($id_responden, $id_alternatif)) {
            $_SESSION['error'] = 'Anda sudah pernah menilai layanan ini!';
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        }

        // Get all kriteria
        $kriterias = $this->penilaianModel->getAllKriteria();

        // Validate and insert each kriteria's sub_kriteria
        $successCount = 0;
        $totalKriteria = count($kriterias);

        foreach ($kriterias as $kriteria) {
            $id_kriteria = $kriteria['id_kriteria'];
            $id_sub = intval($_POST['id_sub_' . $id_kriteria] ?? 0);

            // Validate sub kriteria
            if ($id_sub <= 0) {
                $_SESSION['error'] = 'Semua kriteria wajib dinilai!';
                header('Location: index.php?controller=penilaian&action=formPenilaian');
                exit;
            }

            // Check if sub kriteria exists
            if (!$this->penilaianModel->checkSubKriteriaExists($id_sub)) {
                $_SESSION['error'] = 'Sub kriteria tidak valid!';
                header('Location: index.php?controller=penilaian&action=formPenilaian');
                exit;
            }

            // Insert penilaian
            if ($this->penilaianModel->create($id_responden, $id_alternatif, $id_kriteria, $id_sub)) {
                $successCount++;
            }
        }

        if ($successCount === $totalKriteria) {
            $_SESSION['success'] = "Terima kasih! Penilaian Anda berhasil disimpan untuk {$successCount} kriteria.";
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        } else {
            $_SESSION['error'] = "Gagal menyimpan penilaian! Berhasil: {$successCount}/{$totalKriteria}";
            header('Location: index.php?controller=penilaian&action=formPenilaian');
            exit;
        }
    }
}
?>
