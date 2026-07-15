<?php
// Backfill: isi jawaban untuk kriteria baru (C6 Prosedur, C7 Perilaku Pelaksana) pada
// SEMUA pasangan (responden, alternatif) yang sudah pernah mengisi kuesioner SEBELUM
// migration_003 dijalankan - supaya tidak ada kuesioner yang "kosong/nol" untuk
// kriteria baru (yang akan membuat covered_weight < 1 dan skor SMART timpang).
//
// Nilai backfill dipilih konsisten: rata-rata nilai_utility jawaban lama pasangan itu,
// dibulatkan ke level terdekat (100/75/50/25), dipakai untuk kedua kriteria baru -
// supaya tidak mengubah "rasa" kepuasan yang sudah mereka isi.
//
// Jalankan sekali dari root project: php database/backfill_kriteria_baru.php

chdir(__DIR__ . '/..');
require_once 'config/koneksi.php';
require_once 'models/PenilaianModel.php';
require_once 'models/SmartCalculator.php';

$database = new Database();
$conn = $database->getConnection();
$penilaianModel = new PenilaianModel($conn);

// Kriteria baru yang perlu di-backfill
$kriteria_baru = $conn->query("SELECT id_kriteria, kode_kriteria FROM kriteria WHERE kode_kriteria IN ('C6','C7')")->fetchAll(PDO::FETCH_ASSOC);
if (count($kriteria_baru) !== 2) {
    die("Kriteria C6/C7 tidak ditemukan - pastikan migration_003 sudah dijalankan lebih dulu.\n");
}

// Semua pasangan (responden, alternatif) yang sudah pernah mengisi kuesioner,
// beserta rata-rata nilai_utility jawaban mereka yang SUDAH ADA (kriteria lama).
$pairs = $conn->query("
    SELECT p.id_responden, p.id_alternatif, AVG(sk.nilai_utility) as rerata_lama
    FROM penilaian p
    JOIN sub_kriteria sk ON p.id_sub = sk.id_sub
    JOIN kriteria k ON p.id_kriteria = k.id_kriteria
    WHERE k.kode_kriteria NOT IN ('C6','C7')
    GROUP BY p.id_responden, p.id_alternatif
")->fetchAll(PDO::FETCH_ASSOC);

// Sub-kriteria per kriteria baru, terurut nilai_utility DESC (index 0=100,1=75,2=50,3=25)
$sub_by_kriteria = [];
foreach ($kriteria_baru as $k) {
    $sub_by_kriteria[$k['id_kriteria']] = $penilaianModel->getSubKriteriaByKriteria($k['id_kriteria']);
}

function nearestLevelIndex(float $rerata): int
{
    $levels = [100, 75, 50, 25];
    $best_index = 0;
    $best_diff = PHP_FLOAT_MAX;
    foreach ($levels as $i => $lvl) {
        $diff = abs($rerata - $lvl);
        if ($diff < $best_diff) {
            $best_diff = $diff;
            $best_index = $i;
        }
    }
    return $best_index;
}

$total_backfilled = 0;
$affected_responden = [];

foreach ($pairs as $pair) {
    $id_responden = $pair['id_responden'];
    $id_alternatif = $pair['id_alternatif'];
    $level_index = nearestLevelIndex((float) $pair['rerata_lama']);

    foreach ($kriteria_baru as $k) {
        $id_kriteria = $k['id_kriteria'];

        // Idempoten: skip kalau sudah pernah di-backfill / sudah dijawab
        $cek = $conn->prepare("SELECT COUNT(*) FROM penilaian WHERE id_responden=? AND id_alternatif=? AND id_kriteria=?");
        $cek->execute([$id_responden, $id_alternatif, $id_kriteria]);
        if ((int) $cek->fetchColumn() > 0) {
            continue;
        }

        $id_sub = $sub_by_kriteria[$id_kriteria][$level_index]['id_sub'];
        $penilaianModel->create($id_responden, $id_alternatif, $id_kriteria, $id_sub);
        $total_backfilled++;
    }

    $affected_responden[$id_responden] = true;
}

echo "Pasangan (responden, alternatif) diproses: " . count($pairs) . "\n";
echo "Baris penilaian backfill dibuat: {$total_backfilled}\n";

// Hitung ulang SMART untuk semua responden yang terdampak (bobot & jumlah kriteria berubah)
$kriterias = $penilaianModel->getAllKriteria();
$normalized_weights = SmartCalculator::normalizeWeights($kriterias);
$upsert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif, nilai_smart, is_terbaik, tanggal_perhitungan)
                 VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                 ON DUPLICATE KEY UPDATE
                    nilai_smart = VALUES(nilai_smart),
                    is_terbaik = VALUES(is_terbaik),
                    tanggal_perhitungan = CURRENT_TIMESTAMP";
$upsert_stmt = $conn->prepare($upsert_query);

$total_hasil = 0;
$incomplete_warnings = [];
foreach (array_keys($affected_responden) as $id_responden) {
    $penilaians = $penilaianModel->getByResponden($id_responden);
    if (empty($penilaians)) continue;
    $hasil_smart = SmartCalculator::calculateAllAlternatif($penilaians, $normalized_weights);
    foreach ($hasil_smart as $h) {
        if (!empty($h['incomplete'])) {
            $incomplete_warnings[] = "responden {$id_responden} / alternatif {$h['id_alternatif']} (covered_weight={$h['covered_weight']})";
        }
        $is_terbaik = ($h['ranking'] === 1) ? 1 : 0;
        $upsert_stmt->execute([$id_responden, $h['id_alternatif'], $h['nilai_smart'], $is_terbaik]);
        $total_hasil++;
    }
}

echo "Baris hasil_akhir dihitung ulang: {$total_hasil}\n";
if (!empty($incomplete_warnings)) {
    echo "PERINGATAN - masih ada data tidak lengkap:\n";
    foreach ($incomplete_warnings as $w) echo "  - $w\n";
} else {
    echo "Semua kuesioner lengkap - tidak ada kriteria yang kosong/nol.\n";
}
echo "Selesai.\n";
