<?php
require_once 'models/PenilaianKuesionerModel.php';

class PenilaianKuesionerController
{
    private $penilaianKuesionerModel;

    public function __construct($connection)
    {
        $this->penilaianKuesionerModel = new PenilaianKuesionerModel($connection);
    }

    public function index()
    {
        $data = [
            'title' => 'Kuesioner Penilaian Layanan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Kuesioner Kepuasan Masyarakat',
            'alternatifs' => $this->penilaianKuesionerModel->getAllAlternatif(),
            'kriterias' => $this->penilaianKuesionerModel->getAllKriteria(),
            'penilaianModel' => $this->penilaianKuesionerModel
        ];

        require_once 'views/kuesioner/index.php';
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=penilaianKesioner&action=index');
            exit;
        }

        // Get form data
        $nama_responden = trim($_POST['nama_responden'] ?? '');
        $usia = intval($_POST['usia'] ?? 0);
        $pekerjaan = trim($_POST['pekerjaan'] ?? '');

        // Validation responden data
        if (empty($nama_responden) || $usia <= 0 || $usia > 120 || empty($pekerjaan)) {
            $_SESSION['error'] = 'Data diri tidak lengkap atau tidak valid!';
            header('Location: index.php?controller=penilaianKesioner&action=index');
            exit;
        }

        // Get all alternatifs (layanan)
        $alternatifs = $this->penilaianKuesionerModel->getAllAlternatif();
        $kriterias = $this->penilaianKuesionerModel->getAllKriteria();

        // Create or get responden (by name, age, job)
        require_once 'models/RespondenModel.php';
        $respondenModel = new RespondenModel($this->penilaianKuesionerModel->conn);

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
                $newRespondents = $respondenModel->search($nama_responden);
                foreach ($newRespondents as $new) {
                    if ($new['nama_lengkap'] === $nama_responden &&
                        $new['usia'] == $usia &&
                        $new['pekerjaan'] === $pekerjaan) {
                        $id_responden = $new['id_responden'];
                        break;
                    }
                }
            } else {
                $_SESSION['error'] = 'Gagal membuat data responden!';
                header('Location: index.php?controller=penilaianKesioner&action=index');
                exit;
            }
        }

        // Process each alternatif (layanan)
        $totalInserted = 0;
        $totalExpected = 0;

        foreach ($alternatifs as $alternatif) {
            $id_alternatif = $alternatif['id_alternatif'];

            // Check if responden already rated this alternatif
            if ($this->penilaianKuesionerModel->hasRespondenRatedAlternatif($id_responden, $id_alternatif)) {
                continue; // Skip if already rated
            }

            // Check if this alternatif has any ratings
            $hasRating = false;
            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria['id_kriteria'];
                $fieldName = 'id_sub_' . $id_alternatif . '_' . $id_kriteria;
                $id_sub = intval($_POST[$fieldName] ?? 0);

                if ($id_sub > 0) {
                    $hasRating = true;
                    break;
                }
            }

            // If no rating provided for this alternatif, skip
            if (!$hasRating) {
                continue;
            }

            // Validate and insert each kriteria's sub_kriteria for this alternatif
            $successCount = 0;
            $totalKriteria = count($kriterias);

            foreach ($kriterias as $kriteria) {
                $id_kriteria = $kriteria['id_kriteria'];
                $fieldName = 'id_sub_' . $id_alternatif . '_' . $id_kriteria;
                $id_sub = intval($_POST[$fieldName] ?? 0);

                // Skip if not rated (optional rating)
                if ($id_sub <= 0) {
                    continue;
                }

                // Check if sub kriteria exists
                if (!$this->penilaianKuesionerModel->checkSubKriteriaExists($id_sub)) {
                    $_SESSION['error'] = 'Sub kriteria tidak valid!';
                    header('Location: index.php?controller=penilaianKesioner&action=index');
                    exit;
                }

                // Insert penilaian
                if ($this->penilaianKuesionerModel->create($id_responden, $id_alternatif, $id_kriteria, $id_sub)) {
                    $successCount++;
                    $totalInserted++;
                }
            }
        }

        if ($totalInserted > 0) {
            $_SESSION['success'] = "Terima kasih! Penilaian Anda berhasil disimpan untuk {$totalInserted} kriteria. Masukan Anda sangat berharga bagi kami untuk meningkatkan kualitas layanan.";
        } else {
            $_SESSION['error'] = 'Anda belum memberikan penilaian untuk layanan manapun!';
        }

        header('Location: index.php?controller=penilaianKesioner&action=index');
        exit;
    }
}
?>
