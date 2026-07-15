<?php
require_once 'models/LaporanModel.php';
require_once 'models/PdfHelper.php';

// Satu-satunya tempat untuk ekspor/cetak laporan (PDF & CSV).
class CetakController
{
    private $laporanModel;

    public function __construct($connection)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        $allowedRoles = ['admin', 'kepala_dinas'];
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        $this->laporanModel = new LaporanModel($connection);
    }

    private function requireTcpdf()
    {
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/config/tcpdf_config.php';
    }

    // ========================================
    // FILTER PERIODE (harian/bulanan/tahunan) berdasarkan responden.tanggal_isi
    // ========================================

    // Baca mode + nilai filter dari $_GET, kembalikan [start_datetime, end_datetime, label]
    // atau [null, null, null] kalau tidak ada filter aktif / input tidak valid.
    private function resolveDateFilter(): array
    {
        $mode = $_GET['mode'] ?? '';
        $bulan_indonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if ($mode === 'harian' && !empty($_GET['tanggal'])) {
            $tanggal = $_GET['tanggal'];
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
                return [null, null, null];
            }
            $ts = strtotime($tanggal);
            if ($ts === false) {
                return [null, null, null];
            }
            $label = 'Tanggal ' . date('d', $ts) . ' ' . $bulan_indonesia[(int) date('n', $ts)] . ' ' . date('Y', $ts);
            return ["{$tanggal} 00:00:00", "{$tanggal} 23:59:59", $label];
        }

        if ($mode === 'bulanan' && !empty($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            if (!preg_match('/^\d{4}-\d{2}$/', $bulan)) {
                return [null, null, null];
            }
            [$tahun, $bln] = explode('-', $bulan);
            $bln_int = (int) $bln;
            if ($bln_int < 1 || $bln_int > 12) {
                return [null, null, null];
            }
            $end_day = date('t', strtotime("{$bulan}-01"));
            $label = $bulan_indonesia[$bln_int] . ' ' . $tahun;
            return ["{$bulan}-01 00:00:00", "{$bulan}-{$end_day} 23:59:59", $label];
        }

        if ($mode === 'tahunan' && !empty($_GET['tahun'])) {
            $tahun = intval($_GET['tahun']);
            if ($tahun < 2000 || $tahun > 2100) {
                return [null, null, null];
            }
            return ["{$tahun}-01-01 00:00:00", "{$tahun}-12-31 23:59:59", "Tahun {$tahun}"];
        }

        return [null, null, null];
    }

    // Query string filter yang sedang aktif, dipakai untuk menyambungkan pilihan filter
    // ke tombol unduh PDF/CSV supaya hasil ekspor konsisten dengan yang ditampilkan.
    private function currentFilterQueryString(): string
    {
        $params = [];
        foreach (['mode', 'tanggal', 'bulan', 'tahun'] as $key) {
            if (!empty($_GET[$key])) {
                $params[$key] = $_GET[$key];
            }
        }
        return $params ? ('&' . http_build_query($params)) : '';
    }

    // ========================================
    // HALAMAN UTAMA
    // ========================================

    public function index()
    {
        [$start_date, $end_date, $period_label] = $this->resolveDateFilter();

        $laporan_data = $this->laporanModel->getLaporanFormal($start_date, $end_date);
        if ($laporan_data === false) {
            $laporan_data = ['alternatifs' => [], 'responden_data' => [], 'nilai_per_responden_alternatif' => []];
        }

        $data = [
            'title' => 'Cetak Laporan - DISDUKCAPIL Kota Padang',
            'page_title' => 'Cetak Laporan',
            'statistics' => $this->laporanModel->getStatistics($start_date, $end_date),
            'ringkasan_layanan' => $this->laporanModel->getRingkasanPerLayanan($start_date, $end_date),
            'laporan_data' => $laporan_data,
            'filter_mode' => $_GET['mode'] ?? '',
            'filter_tanggal' => $_GET['tanggal'] ?? '',
            'filter_bulan' => $_GET['bulan'] ?? '',
            'filter_tahun' => $_GET['tahun'] ?? '',
            'period_label' => $period_label,
            'filter_qs' => $this->currentFilterQueryString(),
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/cetak/index.php';
    }

    // ========================================
    // 1. LAPORAN RESMI KEPUASAN MASYARAKAT (PDF)
    // ========================================

    public function pdfLaporanResmi()
    {
        $this->requireTcpdf();

        [$start_date, $end_date, $period_label] = $this->resolveDateFilter();

        $laporan_data = $this->laporanModel->getLaporanFormal($start_date, $end_date);
        $statistics = $this->laporanModel->getStatistics($start_date, $end_date);
        $ringkasan_layanan = $this->laporanModel->getRingkasanPerLayanan($start_date, $end_date);

        if ($laporan_data === false || empty($laporan_data['responden_data'])) {
            $_SESSION['error'] = 'Tidak ada data untuk dibuat laporan pada periode ini!';
            header('Location: index.php?controller=cetak&action=index' . $this->currentFilterQueryString());
            exit;
        }

        $pdf = PdfHelper::newPdf('Laporan Penilaian Kepuasan Masyarakat');
        $pdf->writeHTML($this->generateLaporanResmiHTML($laporan_data, $statistics, $ringkasan_layanan, $period_label), true, false, true, false, '');
        $pdf->lastPage();
        $pdf->Output('laporan_kepuasan_masyarakat_' . date('Y-m-d_His') . '.pdf', 'I');
        exit;
    }

    private function generateLaporanResmiHTML($data, $stats, $ringkasan_layanan = [], $period_label = null)
    {
        ob_start();

        $alternatifs = $data['alternatifs'];
        $responden_data = $data['responden_data'];
        $nilai_per_responden_alternatif = $data['nilai_per_responden_alternatif'];

        $jumlah_alternatif = !empty($alternatifs) ? count($alternatifs) : 3;
        $lebar_kolom_alternatif = ($jumlah_alternatif > 0) ? (55 / $jumlah_alternatif) : 18;

        echo '<!DOCTYPE html><html><head><meta charset="UTF-8">' . PdfHelper::baseStyles() . '</head><body>';
        echo PdfHelper::kopSurat('LAPORAN KEPUASAN MASYARAKAT', 'Periode: ' . ($period_label ?? date('F Y')));

        echo '<table cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 9.5pt;">
                <thead>
                    <tr style="background-color: #f2f2f2; color: #000000;">
                        <th style="width: 8%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">NO</th>
                        <th style="width: 22%; font-weight: bold; text-align: left; border: 1px solid #000000; font-size: 9pt;">NAMA RESPONDEN</th>';

        if (!empty($alternatifs)) {
            foreach ($alternatifs as $alt) {
                $kode = htmlspecialchars($alt['kode_alternatif'] ?? 'A');
                echo '<th style="width: ' . $lebar_kolom_alternatif . '%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">' . $kode . '</th>';
            }
        } else {
            echo '<th style="width: 18%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">A1</th>
                  <th style="width: 18%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">A2</th>
                  <th style="width: 19%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">A3</th>';
        }

        echo '      <th style="width: 15%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9pt;">HASIL SMART</th>
                    </tr>
                </thead>
                <tbody>';

        $no = 1;
        $total_nilai = 0;

        if (!empty($responden_data)) {
            foreach ($responden_data as $responden) {
                $id_responden = $responden['id_responden'];
                $nilai_terbaik = $responden['nilai_smart_terbaik'];
                $total_nilai += $nilai_terbaik;

                echo '<tr>
                        <td style="width: 8%; text-align: center; border: 1px solid #000000; color: #000000;">' . $no++ . '</td>
                        <td style="width: 22%; text-align: left; border: 1px solid #000000; font-weight: bold; color: #000000;">' . htmlspecialchars($responden['nama_lengkap']) . '</td>';

                if (!empty($alternatifs)) {
                    foreach ($alternatifs as $alt) {
                        $kode_alt = $alt['kode_alternatif'];
                        $nilai = $nilai_per_responden_alternatif[$id_responden][$kode_alt] ?? 0;
                        echo '<td style="width: ' . $lebar_kolom_alternatif . '%; text-align: center; border: 1px solid #000000; color: #000000;">' . number_format($nilai, 2, ',', '.') . '</td>';
                    }
                } else {
                    echo '<td style="width: 18%; text-align: center; border: 1px solid #000000; color: #000000;">0,00</td>
                          <td style="width: 18%; text-align: center; border: 1px solid #000000; color: #000000;">0,00</td>
                          <td style="width: 19%; text-align: center; border: 1px solid #000000; color: #000000;">0,00</td>';
                }

                echo '    <td style="width: 15%; text-align: center; border: 1px solid #000000; font-weight: bold; color: #000000;">' . number_format($nilai_terbaik, 2, ',', '.') . '</td>
                      </tr>';
            }
        } else {
            echo '<tr>
                    <td class="text-center" colspan="' . ($jumlah_alternatif + 3) . '" style="padding: 20px; border: 1px solid #000000; color: #000000;">
                        <em style="color: #666666;">Tidak ada data responden</em>
                    </td>
                  </tr>';
        }

        $rerata_smart = ($stats['rerata_smart'] ?? 0);
        $kesimpulan = ($rerata_smart >= 80) ? 'SANGAT BAIK' : (($rerata_smart >= 60) ? 'BAIK' : 'CUKUP');

        echo '<tr style="background-color: #f2f2f2; font-weight: bold; color: #000000;">
                    <td colspan="2" style="border: 1px solid #000000;">Total Nilai</td>
                    <td colspan="' . $jumlah_alternatif . '" style="text-align: right; border: 1px solid #000000; padding-right: 15px;">' . number_format($total_nilai, 2, ',', '.') . '</td>
                    <td style="text-align: center; border: 1px solid #000000;">' . number_format($total_nilai, 2, ',', '.') . '</td>
                </tr>
                <tr style="background-color: #f2f2f2; font-weight: bold; color: #000000;">
                    <td colspan="2" style="border: 1px solid #000000;">Rata-rata Nilai</td>
                    <td colspan="' . $jumlah_alternatif . '" style="text-align: right; border: 1px solid #000000; padding-right: 15px;">' . number_format($rerata_smart, 2, ',', '.') . '</td>
                    <td style="text-align: center; border: 1px solid #000000; color: #000000;">' . number_format($rerata_smart, 2, ',', '.') . '</td>
                </tr>
                <tr style="background-color: #f2f2f2; font-weight: bold; color: #000000;">
                    <td colspan="2" style="border: 1px solid #000000;">Kesimpulan</td>
                    <td colspan="' . $jumlah_alternatif . '" style="text-align: center; border: 1px solid #000000;">' . $kesimpulan . '</td>
                    <td style="text-align: center; border: 1px solid #000000; color: #000000;">' . $kesimpulan . '</td>
                </tr>
              </tbody>
            </table>';

        $nama_petugas = isset($_SESSION['nama_lengkap']) ? strtoupper($_SESSION['nama_lengkap']) : 'ADMIN PETUGAS';
        $nama_kepala_dinas = PdfHelper::getKepalaDinasName($this->laporanModel->conn);
        echo PdfHelper::signatureBlock($nama_kepala_dinas, $nama_petugas);

        echo '</body></html>';
        return ob_get_clean();
    }

    // ========================================
    // 2. RINGKASAN KEPUASAN PER LAYANAN (PDF & CSV)
    // ========================================

    public function pdfRingkasanLayanan()
    {
        $this->requireTcpdf();

        [$start_date, $end_date, $period_label] = $this->resolveDateFilter();

        $ringkasan_layanan = $this->laporanModel->getRingkasanPerLayanan($start_date, $end_date);
        if (empty($ringkasan_layanan)) {
            $_SESSION['error'] = 'Belum ada data ringkasan layanan pada periode ini!';
            header('Location: index.php?controller=cetak&action=index' . $this->currentFilterQueryString());
            exit;
        }

        $pdf = PdfHelper::newPdf('Ringkasan Kepuasan per Layanan');

        ob_start();
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8">' . PdfHelper::baseStyles() . '</head><body>';
        echo PdfHelper::kopSurat('RINGKASAN KEPUASAN PER LAYANAN', 'Periode: ' . ($period_label ?? date('F Y')));
        echo $this->ringkasanLayananTableHTML($ringkasan_layanan, '');

        $nama_petugas = isset($_SESSION['nama_lengkap']) ? strtoupper($_SESSION['nama_lengkap']) : 'ADMIN PETUGAS';
        $nama_kepala_dinas = PdfHelper::getKepalaDinasName($this->laporanModel->conn);
        echo PdfHelper::signatureBlock($nama_kepala_dinas, $nama_petugas);
        echo '</body></html>';
        $html = ob_get_clean();

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        $pdf->Output('ringkasan_per_layanan_' . date('Y-m-d_His') . '.pdf', 'I');
        exit;
    }

    private function ringkasanLayananTableHTML($ringkasan_layanan, $judul = '')
    {
        ob_start();
        if ($judul !== '') {
            echo '<div class="judul-laporan" style="margin-top: 20px; text-align: left;"><h1 style="font-size: 13pt; color: #1e293b;">' . htmlspecialchars($judul) . '</h1></div>';
        }
        echo '<table cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt;">
                <thead>
                    <tr style="background-color: #f2f2f2; color: #000000;">
                        <th style="width: 8%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9.5pt;">NO</th>
                        <th style="width: 44%; font-weight: bold; text-align: left; border: 1px solid #000000; font-size: 9.5pt;">LAYANAN</th>
                        <th style="width: 16%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9.5pt;">JUMLAH PENILAI</th>
                        <th style="width: 16%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9.5pt;">RATA-RATA SMART</th>
                        <th style="width: 16%; font-weight: bold; text-align: center; border: 1px solid #000000; font-size: 9.5pt;">MIN / MAX</th>
                    </tr>
                </thead>
                <tbody>';
        $no = 1;
        foreach ($ringkasan_layanan as $layanan) {
            echo '<tr>
                    <td style="width: 8%; text-align: center; border: 1px solid #000000; color: #000000;">' . $no++ . '</td>
                    <td style="width: 44%; text-align: left; border: 1px solid #000000; font-weight: bold; color: #000000;">' . htmlspecialchars($layanan['nama_layanan']) . '</td>
                    <td style="width: 16%; text-align: center; border: 1px solid #000000; color: #000000;">' . (int) $layanan['total_penilai'] . '</td>
                    <td style="width: 16%; text-align: center; border: 1px solid #000000; font-weight: bold; color: #000000;">' . number_format($layanan['rerata_smart'] ?? 0, 2, ',', '.') . '</td>
                    <td style="width: 16%; text-align: center; border: 1px solid #000000; color: #000000;">' . number_format($layanan['nilai_min'] ?? 0, 2, ',', '.') . ' / ' . number_format($layanan['nilai_max'] ?? 0, 2, ',', '.') . '</td>
                  </tr>';
        }
        echo '  </tbody></table>';
        return ob_get_clean();
    }

    public function csvRingkasanLayanan()
    {
        [$start_date, $end_date] = $this->resolveDateFilter();
        $ringkasan_layanan = $this->laporanModel->getRingkasanPerLayanan($start_date, $end_date);

        $this->streamCsv('ringkasan_per_layanan_' . date('Y-m-d') . '.csv', function ($output) use ($ringkasan_layanan) {
            fputcsv($output, ['Layanan', 'Jumlah Penilai', 'Rata-rata SMART', 'Nilai Min', 'Nilai Max']);
            foreach ($ringkasan_layanan as $r) {
                fputcsv($output, [
                    $r['nama_layanan'],
                    (int) $r['total_penilai'],
                    number_format($r['rerata_smart'] ?? 0, 2),
                    number_format($r['nilai_min'] ?? 0, 2),
                    number_format($r['nilai_max'] ?? 0, 2)
                ]);
            }
        });
    }

    // ========================================
    // Helper CSV output bersama
    // ========================================

    private function streamCsv($filename, callable $writer)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        $writer($output);
        fclose($output);
        exit;
    }
}
?>
