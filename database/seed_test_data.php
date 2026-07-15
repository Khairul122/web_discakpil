<?php
// Seed 20 data percobaan (responden + penilaian) untuk keperluan pengujian UI/laporan.
// Jalankan sekali dari root project: php database/seed_test_data.php
// Aman dijalankan berulang - responden dicek dulu berdasarkan nama+usia+pekerjaan sebelum insert.

chdir(__DIR__ . '/..');
require_once 'config/koneksi.php';
require_once 'models/RespondenModel.php';
require_once 'models/PenilaianModel.php';
require_once 'models/SmartCalculator.php';

$database = new Database();
$conn = $database->getConnection();

$respondenModel = new RespondenModel($conn);
$penilaianModel = new PenilaianModel($conn);

// index nilai_utility per kriteria terurut DESC: 0=100 (Sangat..), 1=75, 2=50 (Cukup..), 3=25 (Tidak..)
// urutan kolom 'nilai' = [C1 Kecepatan, C2 Kesesuaian, C3 Kompetensi, C4 Sarana, C5 Respon, C6 Prosedur, C7 Perilaku Pelaksana]
$data_percobaan = [
    ['nama' => 'Andi Saputra',      'usia' => 34, 'pekerjaan' => 'Wiraswasta',        'hari_lalu' => 0,  'alternatif' => 1, 'nilai' => [0, 0, 0, 0, 0, 0, 0]],
    ['nama' => 'Siti Rahma',        'usia' => 28, 'pekerjaan' => 'Ibu Rumah Tangga',  'hari_lalu' => 0,  'alternatif' => 2, 'nilai' => [1, 1, 0, 1, 1, 1, 1]],
    ['nama' => 'Budi Santoso',      'usia' => 45, 'pekerjaan' => 'PNS',               'hari_lalu' => 1,  'alternatif' => 3, 'nilai' => [0, 1, 1, 0, 0, 0, 1]],
    ['nama' => 'Dewi Lestari',      'usia' => 22, 'pekerjaan' => 'Mahasiswa',         'hari_lalu' => 2,  'alternatif' => 4, 'nilai' => [1, 0, 1, 1, 0, 1, 0]],
    ['nama' => 'Ahmad Fauzi',       'usia' => 50, 'pekerjaan' => 'Petani',            'hari_lalu' => 3,  'alternatif' => 5, 'nilai' => [2, 1, 2, 1, 2, 2, 1]],
    ['nama' => 'Rina Marlina',      'usia' => 31, 'pekerjaan' => 'Guru',              'hari_lalu' => 5,  'alternatif' => 1, 'nilai' => [0, 0, 1, 0, 1, 0, 1]],
    ['nama' => 'Hendra Gunawan',    'usia' => 39, 'pekerjaan' => 'Wiraswasta',        'hari_lalu' => 7,  'alternatif' => 2, 'nilai' => [1, 2, 1, 2, 1, 1, 2]],
    ['nama' => 'Yuni Kartika',      'usia' => 26, 'pekerjaan' => 'Karyawan Swasta',   'hari_lalu' => 10, 'alternatif' => 3, 'nilai' => [0, 0, 0, 1, 0, 0, 0]],
    ['nama' => 'Rudi Hartono',      'usia' => 55, 'pekerjaan' => 'Pensiunan',         'hari_lalu' => 14, 'alternatif' => 4, 'nilai' => [2, 3, 2, 2, 3, 3, 2]],
    ['nama' => 'Fitri Handayani',   'usia' => 33, 'pekerjaan' => 'PNS',               'hari_lalu' => 18, 'alternatif' => 5, 'nilai' => [1, 1, 1, 0, 1, 1, 1]],
    ['nama' => 'Agus Setiawan',     'usia' => 41, 'pekerjaan' => 'Buruh',             'hari_lalu' => 22, 'alternatif' => 1, 'nilai' => [2, 2, 3, 2, 2, 2, 3]],
    ['nama' => 'Maya Anggraini',    'usia' => 24, 'pekerjaan' => 'Mahasiswa',         'hari_lalu' => 27, 'alternatif' => 2, 'nilai' => [0, 1, 0, 0, 1, 0, 1]],
    ['nama' => 'Dedi Kurniawan',    'usia' => 37, 'pekerjaan' => 'Wiraswasta',        'hari_lalu' => 35, 'alternatif' => 3, 'nilai' => [1, 0, 1, 1, 1, 0, 1]],
    ['nama' => 'Nurul Hidayah',     'usia' => 29, 'pekerjaan' => 'Ibu Rumah Tangga',  'hari_lalu' => 40, 'alternatif' => 4, 'nilai' => [0, 0, 0, 0, 0, 0, 0]],
    ['nama' => 'Bambang Wijaya',    'usia' => 48, 'pekerjaan' => 'PNS',               'hari_lalu' => 48, 'alternatif' => 5, 'nilai' => [1, 1, 2, 1, 1, 1, 1]],
    ['nama' => 'Wulan Sari',        'usia' => 27, 'pekerjaan' => 'Karyawan Swasta',   'hari_lalu' => 55, 'alternatif' => 1, 'nilai' => [3, 2, 3, 3, 2, 3, 3]],
    ['nama' => 'Joko Prasetyo',     'usia' => 43, 'pekerjaan' => 'Petani',            'hari_lalu' => 63, 'alternatif' => 2, 'nilai' => [1, 1, 0, 1, 0, 1, 0]],
    ['nama' => 'Ratna Sari',        'usia' => 35, 'pekerjaan' => 'Guru',              'hari_lalu' => 70, 'alternatif' => 3, 'nilai' => [0, 1, 1, 0, 1, 0, 1]],
    ['nama' => 'Eko Purnomo',       'usia' => 30, 'pekerjaan' => 'Wiraswasta',        'hari_lalu' => 80, 'alternatif' => 4, 'nilai' => [2, 1, 1, 2, 1, 1, 2]],
    ['nama' => 'Indah Permata',     'usia' => 25, 'pekerjaan' => 'Mahasiswa',         'hari_lalu' => 95, 'alternatif' => 5, 'nilai' => [0, 0, 0, 1, 0, 0, 0]],
];

$kriterias = $penilaianModel->getAllKriteria(); // terurut by kode_kriteria: C1..C5
$sub_by_kriteria = [];
foreach ($kriterias as $k) {
    $sub_by_kriteria[$k['id_kriteria']] = $penilaianModel->getSubKriteriaByKriteria($k['id_kriteria']); // urut nilai_utility DESC
}

$total_responden_baru = 0;
$total_penilaian_baru = 0;
$id_responden_list = [];

foreach ($data_percobaan as $row) {
    // Cek apakah sudah ada (idempoten kalau script dijalankan ulang)
    $existing = $respondenModel->search($row['nama']);
    $id_responden = 0;
    foreach ($existing as $e) {
        if ($e['nama_lengkap'] === $row['nama'] && (int) $e['usia'] === $row['usia'] && $e['pekerjaan'] === $row['pekerjaan']) {
            $id_responden = $e['id_responden'];
            break;
        }
    }

    if ($id_responden <= 0) {
        $respondenModel->create($row['nama'], $row['usia'], $row['pekerjaan']);
        $created = $respondenModel->search($row['nama']);
        foreach ($created as $c) {
            if ($c['nama_lengkap'] === $row['nama'] && (int) $c['usia'] === $row['usia'] && $c['pekerjaan'] === $row['pekerjaan']) {
                $id_responden = $c['id_responden'];
                break;
            }
        }
        $total_responden_baru++;

        // Sebar tanggal_isi mundur sesuai 'hari_lalu' supaya filter harian/bulanan/tahunan punya data nyata
        $tanggal_isi = date('Y-m-d H:i:s', strtotime("-{$row['hari_lalu']} days"));
        $stmt = $conn->prepare("UPDATE responden SET tanggal_isi = ? WHERE id_responden = ?");
        $stmt->execute([$tanggal_isi, $id_responden]);
    }

    $id_responden_list[] = $id_responden;

    // Insert penilaian kalau responden ini belum pernah menilai alternatif tersebut
    if (!$penilaianModel->hasRespondenRatedAlternatif($id_responden, $row['alternatif'])) {
        foreach ($kriterias as $i => $k) {
            $subs = $sub_by_kriteria[$k['id_kriteria']];
            $pilihan_index = $row['nilai'][$i];
            $id_sub = $subs[$pilihan_index]['id_sub'];
            $penilaianModel->create($id_responden, $row['alternatif'], $k['id_kriteria'], $id_sub);
            $total_penilaian_baru++;
        }
    }
}

echo "Responden baru dibuat: {$total_responden_baru}\n";
echo "Baris penilaian baru dibuat: {$total_penilaian_baru}\n";

// Hitung ulang SMART untuk semua responden (logika identik dengan PenilaianController::calculateAllSMART)
$normalized_weights = SmartCalculator::normalizeWeights($kriterias);
$upsert_query = "INSERT INTO hasil_akhir (id_responden, id_alternatif, nilai_smart, is_terbaik, tanggal_perhitungan)
                 VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
                 ON DUPLICATE KEY UPDATE
                    nilai_smart = VALUES(nilai_smart),
                    is_terbaik = VALUES(is_terbaik),
                    tanggal_perhitungan = CURRENT_TIMESTAMP";
$upsert_stmt = $conn->prepare($upsert_query);

$total_hasil = 0;
foreach (array_unique($id_responden_list) as $id_responden) {
    $penilaians = $penilaianModel->getByResponden($id_responden);
    if (empty($penilaians)) continue;
    $hasil_smart = SmartCalculator::calculateAllAlternatif($penilaians, $normalized_weights);
    foreach ($hasil_smart as $h) {
        $is_terbaik = ($h['ranking'] === 1) ? 1 : 0;
        $upsert_stmt->execute([$id_responden, $h['id_alternatif'], $h['nilai_smart'], $is_terbaik]);
        $total_hasil++;
    }
}

echo "Baris hasil_akhir dihitung/diperbarui: {$total_hasil}\n";
echo "Selesai.\n";
