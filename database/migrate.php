<?php
// Migration runner otomatis untuk database/migration_*.sql
//
// Pemakaian: php database/migrate.php
//
// Cara kerja:
// - Membuat tabel `migrations` (kalau belum ada) untuk mencatat migrasi yang sudah diterapkan.
// - Memindai semua file database/migration_*.sql, diurutkan berdasarkan nomor urut di nama file.
// - Migrasi yang belum tercatat akan dijalankan otomatis, statement demi statement, dalam urutan.
// - Migrasi lama (002, 003) yang sudah pernah diterapkan manual sebelum runner ini ada,
//   dideteksi lewat "probe" skema (lihat $probes) supaya tidak dijalankan ulang dan gagal.
// - Kalau migrasi punya skrip data pendamping (lihat $companion_scripts), skrip itu otomatis
//   dijalankan setelah migrasi SQL-nya berhasil.
// - Berhenti di migrasi pertama yang gagal - migrasi setelahnya TIDAK dijalankan supaya urutan
//   dependensi tetap terjaga.

chdir(__DIR__ . '/..');
require_once 'config/koneksi.php';

$database = new Database();
$conn = $database->getConnection();

$conn->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INT NOT NULL AUTO_INCREMENT,
        migration VARCHAR(255) NOT NULL,
        applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY uniq_migration (migration)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// Probe untuk migrasi yang sudah diterapkan manual SEBELUM runner ini dibuat - mendeteksi
// lewat bukti nyata di skema/data, bukan cuma asumsi, supaya runner aman dipakai di database
// manapun (baik yang sudah pernah dimigrasi manual, maupun database baru yang masih kosong).
$probes = [
    'migration_002_hasil_akhir_full_matrix.sql' => function (PDO $conn): bool {
        $stmt = $conn->query("SHOW COLUMNS FROM hasil_akhir LIKE 'is_terbaik'");
        return $stmt->rowCount() > 0;
    },
    'migration_003_tambah_kriteria_prosedur_perilaku.sql' => function (PDO $conn): bool {
        $stmt = $conn->query("SELECT COUNT(*) FROM kriteria WHERE kode_kriteria = 'C6'");
        return (int) $stmt->fetchColumn() > 0;
    },
];

// Skrip data pendamping yang otomatis dijalankan setelah migrasi SQL terkait berhasil diterapkan.
$companion_scripts = [
    'migration_003_tambah_kriteria_prosedur_perilaku.sql' => 'backfill_kriteria_baru.php',
];

function alreadyApplied(PDO $conn, string $migration): bool
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
    $stmt->execute([$migration]);
    return (int) $stmt->fetchColumn() > 0;
}

function markApplied(PDO $conn, string $migration): void
{
    $stmt = $conn->prepare("INSERT IGNORE INTO migrations (migration) VALUES (?)");
    $stmt->execute([$migration]);
}

// Pecah isi file SQL migrasi jadi daftar statement siap-eksekusi: buang baris komentar `--`
// dan baris START TRANSACTION/COMMIT (DDL MySQL tetap auto-commit per statement, jadi wrapper
// transaksi eksplisit tidak berpengaruh - lihat catatan di migration_002).
function splitSqlStatements(string $sql): array
{
    $lines = explode("\n", $sql);
    $clean_lines = array_filter($lines, function ($line) {
        $trimmed = trim($line);
        if ($trimmed === '' || str_starts_with($trimmed, '--')) return false;
        if (preg_match('/^(START\s+TRANSACTION|COMMIT)\s*;?$/i', $trimmed)) return false;
        return true;
    });

    $statements = array_filter(array_map('trim', explode(';', implode("\n", $clean_lines))));
    return array_values($statements);
}

$files = glob('database/migration_*.sql');
natsort($files);

echo "=== Migration Runner ===\n";

$total_run = 0;
$stopped_early = false;

foreach ($files as $path) {
    $filename = basename($path);

    if (alreadyApplied($conn, $filename)) {
        echo "[skip] {$filename} (sudah tercatat diterapkan)\n";
        continue;
    }

    if (isset($probes[$filename]) && $probes[$filename]($conn)) {
        echo "[skip] {$filename} (terdeteksi sudah diterapkan sebelumnya - dicatat tanpa dijalankan ulang)\n";
        markApplied($conn, $filename);
        if (isset($companion_scripts[$filename])) {
            markApplied($conn, $companion_scripts[$filename]);
        }
        continue;
    }

    echo "[run]  {$filename}\n";
    $statements = splitSqlStatements(file_get_contents($path));

    try {
        foreach ($statements as $stmt) {
            $conn->exec($stmt);
        }
        markApplied($conn, $filename);
        $total_run++;
        echo "       -> berhasil (" . count($statements) . " statement)\n";
    } catch (PDOException $e) {
        echo "       -> GAGAL: " . $e->getMessage() . "\n";
        echo "Migrasi dihentikan. Perbaiki error di atas sebelum menjalankan ulang.\n";
        $stopped_early = true;
        break;
    }

    if (isset($companion_scripts[$filename])) {
        $script = $companion_scripts[$filename];
        $script_path = 'database/' . $script;
        echo "[run]  {$script} (skrip data pendamping {$filename})\n";
        $output = [];
        $exit_code = 0;
        exec('php ' . escapeshellarg($script_path) . ' 2>&1', $output, $exit_code);
        echo '       ' . implode("\n       ", $output) . "\n";
        if ($exit_code !== 0) {
            echo "       -> GAGAL (exit code {$exit_code}). Migrasi dihentikan.\n";
            $stopped_early = true;
            break;
        }
        markApplied($conn, $script);
    }
}

echo "\n";
if ($stopped_early) {
    echo "Migrasi berhenti karena ada error. Migrasi berikutnya (kalau ada) tidak dijalankan.\n";
    exit(1);
}

echo $total_run > 0
    ? "Selesai - {$total_run} migrasi baru diterapkan.\n"
    : "Selesai - tidak ada migrasi baru, semua sudah up to date.\n";
