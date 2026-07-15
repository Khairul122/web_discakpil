<?php
require_once 'models/PenilaianModel.php';

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

        // Role check - admin, kepala_dinas, dan staff yang boleh akses
        $allowedRoles = ['admin', 'kepala_dinas', 'staff'];
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

        // 1. Ambil semua kriteria dengan bobot
        $kriterias = $this->penilaianModel->getAllKriteria();
        $total_bobot = array_sum(array_column($kriterias, 'bobot'));

        // 2. Normalisasi bobot (pastikan total = 100% atau 1)
        $normalized_weights = [];
        $kriteria_jenis = [];
        foreach ($kriterias as $k) {
            $normalized_weights[$k['id_kriteria']] = $k['bobot'] / $total_bobot;
            $kriteria_jenis[$k['id_kriteria']] = $k['jenis'] ?? 'benefit';
        }

        // 3. Group penilaian berdasarkan alternatif (layanan)
        $penilaian_by_alternatif = [];
        foreach ($penilaians as $p) {
            $penilaian_by_alternatif[$p['id_alternatif']][] = $p;
        }

        // 4. Hitung nilai SMART untuk setiap alternatif
        $hasil_smart = [];
        foreach ($penilaian_by_alternatif as $id_alternatif => $penilaian_list) {
            $nilai_smart = 0;
            $covered_weight = 0;

            foreach ($penilaian_list as $penilaian) {
                // Rumus SMART: Σ(Wi × Si)
                // Wi = Bobot normalisasi kriteria i
                // Si = Nilai utility sub-kriteria yang dipilih (dibalik jika kriteria bertipe "cost")
                $bobot_normal = $normalized_weights[$penilaian['id_kriteria']];
                $nilai_utility = $penilaian['nilai_utility'];
                $jenis = $kriteria_jenis[$penilaian['id_kriteria']] ?? 'benefit';

                if ($jenis === 'cost') {
                    $nilai_utility = 100 - $nilai_utility;
                }

                // Hitung kontribusi kriteria
                $kontribusi = $bobot_normal * $nilai_utility;
                $nilai_smart += $kontribusi;
                $covered_weight += $bobot_normal;
            }

            // Ambil nama alternatif/layanan
            $alternatif_data = null;
            foreach ($this->penilaianModel->getAllAlternatif() as $alt) {
                if ($alt['id_alternatif'] == $id_alternatif) {
                    $alternatif_data = $alt;
                    break;
                }
            }

            $hasil_smart[] = [
                'id_alternatif' => $id_alternatif,
                'nama_layanan' => $alternatif_data['nama_layanan'],
                'nilai_smart' => $nilai_smart,
                'detail_kriteria' => $penilaian_list,
                'incomplete' => $covered_weight < 0.999,
                'covered_weight' => $covered_weight
            ];
        }

        // 5. Sorting berdasarkan nilai SMART (descending)
        usort($hasil_smart, function($a, $b) {
            return $b['nilai_smart'] <=> $a['nilai_smart'];
        });

        // 6. Tentukan ranking
        foreach ($hasil_smart as $index => &$hasil) {
            $hasil['ranking'] = $index + 1;
        }
        unset($hasil);

        // 7. Simpan layanan terbaik (ranking #1) ke tabel hasil_akhir
        // (tabel hanya menyimpan 1 baris per responden - UNIQUE KEY idx_responden)
        if (!empty($hasil_smart)) {
            try {
                $layanan_terbaik = $hasil_smart[0];

                $cek_query = "SELECT id_hasil FROM hasil_akhir WHERE id_responden = ?";
                $cek_stmt = $this->penilaianModel->conn->prepare($cek_query);
                $cek_stmt->execute([$id_responden]);
                $existing = $cek_stmt->fetch(PDO::FETCH_ASSOC);

                if ($existing) {
                    $update_query = "UPDATE hasil_akhir
                                   SET id_alternatif_terbaik = ?,
                                       nilai_smart = ?,
                                       tanggal_perhitungan = CURRENT_TIMESTAMP
                                   WHERE id_responden = ?";
                    $stmt = $this->penilaianModel->conn->prepare($update_query);
                    $stmt->execute([
                        $layanan_terbaik['id_alternatif'],
                        $layanan_terbaik['nilai_smart'],
                        $id_responden
                    ]);
                } else {
                    $insert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif_terbaik, nilai_smart)
                                   VALUES (?, ?, ?)";
                    $stmt = $this->penilaianModel->conn->prepare($insert_query);
                    $stmt->execute([
                        $id_responden,
                        $layanan_terbaik['id_alternatif'],
                        $layanan_terbaik['nilai_smart']
                    ]);
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

            $total_bobot = array_sum(array_column($kriterias, 'bobot'));

            // Normalisasi bobot
            $normalized_weights = [];
            $kriteria_jenis = [];
            foreach ($kriterias as $k) {
                $normalized_weights[$k['id_kriteria']] = $k['bobot'] / $total_bobot;
                $kriteria_jenis[$k['id_kriteria']] = $k['jenis'] ?? 'benefit';
            }

            $total_responden_processed = 0;
            $total_hasil_created = 0;
            $errors = [];

            // Process each respondent
            foreach ($respondens as $responden) {
                $id_responden = $responden['id_responden'];

                try {
                    // Get penilaians for this respondent
                    $penilaians = $this->penilaianModel->getByResponden($id_responden);

                    if (empty($penilaians)) {
                        continue; // Skip if no penilaians
                    }

                    // Group penilaian by alternatif
                    $penilaian_by_alternatif = [];
                    foreach ($penilaians as $p) {
                        $penilaian_by_alternatif[$p['id_alternatif']][] = $p;
                    }

                    // Calculate SMART for each alternatif
                    $hasil_smart = [];
                    foreach ($penilaian_by_alternatif as $id_alternatif => $penilaian_list) {
                        $nilai_smart = 0;
                        $covered_weight = 0;

                        foreach ($penilaian_list as $penilaian) {
                            $bobot_normal = $normalized_weights[$penilaian['id_kriteria']];
                            $nilai_utility = $penilaian['nilai_utility'];
                            $jenis = $kriteria_jenis[$penilaian['id_kriteria']] ?? 'benefit';

                            if ($jenis === 'cost') {
                                $nilai_utility = 100 - $nilai_utility;
                            }

                            $kontribusi = $bobot_normal * $nilai_utility;
                            $nilai_smart += $kontribusi;
                            $covered_weight += $bobot_normal;
                        }

                        $hasil_smart[] = [
                            'id_alternatif' => $id_alternatif,
                            'nilai_smart' => $nilai_smart,
                            'incomplete' => $covered_weight < 0.999
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
                    unset($hasil);

                    // SIMPAN HANYA LAYANAN TERBAIK KE TABEL hasil_akhir
                    if (!empty($hasil_smart)) {
                        try {
                            $layanan_terbaik = $hasil_smart[0]; // Ranking #1

                            if (!empty($layanan_terbaik['incomplete'])) {
                                $errors[] = "Responden ID {$id_responden}: hasil dihitung dari data yang tidak lengkap (ada kriteria aktif yang belum dinilai untuk layanan ini), skor mungkin kurang akurat.";
                            }

                            // Cek apakah sudah ada hasil untuk responden ini
                            $cek_query = "SELECT id_hasil FROM hasil_akhir WHERE id_responden = ?";
                            $cek_stmt = $this->penilaianModel->conn->prepare($cek_query);
                            $cek_stmt->execute([$id_responden]);
                            $existing = $cek_stmt->fetch(PDO::FETCH_ASSOC);

                            if ($existing) {
                                // Update existing
                                $update_query = "UPDATE hasil_akhir
                                               SET id_alternatif_terbaik = ?,
                                                   nilai_smart = ?,
                                                   tanggal_perhitungan = CURRENT_TIMESTAMP
                                               WHERE id_responden = ?";
                                $update_stmt = $this->penilaianModel->conn->prepare($update_query);
                                $update_stmt->execute([
                                    $layanan_terbaik['id_alternatif'],
                                    $layanan_terbaik['nilai_smart'],
                                    $id_responden
                                ]);
                                error_log("Updated hasil_akhir for respondent ID {$id_responden}");
                            } else {
                                // Insert new
                                $insert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif_terbaik, nilai_smart)
                                               VALUES (?, ?, ?)";
                                $insert_stmt = $this->penilaianModel->conn->prepare($insert_query);
                                $insert_stmt->execute([
                                    $id_responden,
                                    $layanan_terbaik['id_alternatif'],
                                    $layanan_terbaik['nilai_smart']
                                ]);
                                error_log("Inserted hasil_akhir for respondent ID {$id_responden}");
                            }

                            $total_hasil_created++;
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
