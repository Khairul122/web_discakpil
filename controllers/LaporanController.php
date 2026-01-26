<?php
require_once 'models/LaporanModel.php';

class LaporanController
{
    private $laporanModel;

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

        // Role check - admin dan kepala_dinas yang boleh akses
        $allowedRoles = ['admin', 'kepala_dinas'];
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini!';
            header('Location: index.php?controller=auth&action=index');
            exit;
        }

        $this->laporanModel = new LaporanModel($connection);
    }

    public function index()
    {
        $laporan_data = $this->laporanModel->getLaporanFormal();

        if ($laporan_data === false) {
            $laporan_data = [
                'alternatifs' => [],
                'responden_data' => [],
                'nilai_per_responden_alternatif' => []
            ];
        }

        $statistics = $this->laporanModel->getStatistics();

        $data = [
            'title' => 'Laporan Kepuasan Masyarakat - DISDUKCAPIL Kota Padang',
            'page_title' => 'Laporan Penilaian Kepuasan Masyarakat',
            'laporan_data' => $laporan_data,
            'statistics' => $statistics,
            'user' => [
                'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Admin',
                'username' => $_SESSION['username'] ?? '',
                'role' => $_SESSION['role'] ?? 'admin'
            ]
        ];

        require_once 'views/laporan/index.php';
    }

    public function generatePDF()
    {
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/config/tcpdf_config.php';

        $laporan_data = $this->laporanModel->getLaporanFormal();
        $statistics = $this->laporanModel->getStatistics();

        if ($laporan_data === false || empty($laporan_data['responden_data'])) {
            $_SESSION['error'] = 'Tidak ada data untuk dibuat laporan!';
            header('Location: index.php?controller=laporan&action=index');
            exit;
        }

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'F4', true, 'UTF-8', false);

        $pdf->SetCreator('DISDUKCAPIL Kota Padang');
        $pdf->SetAuthor('DISDUKCAPIL');
        $pdf->SetTitle('Laporan Penilaian Kepuasan Masyarakat');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(20, 20, 20);
        $pdf->SetAutoPageBreak(TRUE, 30);

        $pdf->AddPage();

        $html = $this->generateFormalReportHTML($laporan_data, $statistics);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();

        $pdf->Output('laporan_kepuasan_masyarakat_' . date('Y-m-d_His') . '.pdf', 'I');
        exit;
    }

    private function generateFormalReportHTML($data, $stats)
    {
        ob_start();

        $alternatifs = $data['alternatifs'];
        $responden_data = $data['responden_data'];
        $nilai_per_responden_alternatif = $data['nilai_per_responden_alternatif'];

        // Pastikan minimal ada 3 alternatif untuk fallback
        $jumlah_alternatif = !empty($alternatifs) ? count($alternatifs) : 3;
        // Hitung lebar kolom alternatif: 100% - 12% (NO) - 13% (NAMA) - 15% (HASIL) = 60% / jumlah alternatif
        $lebar_kolom_alternatif = ($jumlah_alternatif > 0) ? (60 / $jumlah_alternatif) : 20;

        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                @page {
                    margin-top: 20mm;
                    margin-bottom: 25mm;
                    margin-left: 15mm;
                    margin-right: 15mm;
                }

                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 11pt;
                    color: #000;
                    line-height: 1.4;
                }

                .kop-surat-container {
                    margin-bottom: 15px;
                }

                .kop-surat {
                    text-align: center;
                    margin-bottom: 5px;
                }

                .kop-title {
                    font-size: 14pt;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #000;
                    margin-bottom: 2px;
                    line-height: 1.2;
                }

                .kop-subtitle {
                    font-size: 12pt;
                    font-weight: bold;
                    color: #000;
                    margin-bottom: 2px;
                    line-height: 1.2;
                }

                .kop-alamat {
                    font-size: 9pt;
                    color: #333;
                    font-style: normal;
                    line-height: 1.2;
                }

                .garis-kop {
                    border-top: 2px solid #000;
                    margin-bottom: 8px;
                    margin-top: 5px;
                }

                .judul-laporan {
                    text-align: center;
                    margin-bottom: 15px;
                }

                .judul-laporan h1 {
                    font-size: 16pt;
                    font-weight: bold;
                    text-transform: uppercase;
                    color: #000;
                    margin-bottom: 5px;
                    line-height: 1.2;
                }

                .judul-laporan .periode {
                    font-size: 11pt;
                    color: #333;
                }

                .data-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 15px 0;
                    font-size: 10pt;
                }

                .data-table thead {
                    display: table-header-group;
                }

                .data-table th {
                    color: #000000 !important;
                    font-weight: bold;
                    padding: 10px 8px;
                    text-align: center;
                    border: 1px solid #000;
                    font-size: 9pt;
                    text-transform: uppercase;
                    vertical-align: middle;
                    background-color: #ffffff;
                }

                .data-table td {
                    padding: 8px;
                    border: 1px solid #000;
                    vertical-align: middle;
                    color: #000;
                }

                .data-table tbody tr:nth-child(even) {
                    background-color: #f5f5f5;
                }

                .text-center {
                    text-align: center;
                }

                .text-left {
                    text-align: left;
                }

                .text-right {
                    text-align: right;
                }

                .col-no {
                    width: 12%;
                    text-align: center;
                }

                .col-nama {
                    width: 13%;
                }

                .col-hasil {
                    width: 15%;
                    text-align: center;
                }

                .footer-label {
                    background-color: #e0e0e0;
                    font-weight: bold;
                    text-transform: uppercase;
                }

                .footer-row td {
                    padding: 10px 8px;
                    border: 1px solid #000;
                    font-weight: bold;
                }

                .signature-section {
                    margin-top: 30px;
                    page-break-inside: avoid;
                }

                .signature-table {
                    width: 100%;
                    margin-top: 20px;
                }

                .signature-table td {
                    padding: 5px;
                    text-align: left;
                    vertical-align: middle;
                    border: none;
                }

                .ttd-space {
                    height: 70px;
                }

                .nama-pejabat {
                    font-weight: bold;
                    text-decoration: underline;
                    text-transform: uppercase;
                }

                .ttd-container {
                    padding-left: 30px;
                }

                .location-date-container {
                    padding-left: 30px;
                }

                .location-date {
                    margin-bottom: 20px;
                    font-size: 10pt;
                }

                .page-number {
                    text-align: center;
                    font-size: 9pt;
                    margin-top: 20px;
                    color: #666;
                }

                .nilai-cell {
                    font-size: 9pt;
                }
            </style>
        </head>
        <body>';

        echo '<div class="kop-surat-container">
                <div class="kop-surat">
                    <div class="kop-title" style="padding-top: 20px;">DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</div>
                    <div class="kop-subtitle">KOTA PADANG</div>
                    <div class="kop-alamat">Jl. Jend. Sudirman Exs SMAN 1 No.1, Kp. Jao, Kec. Padang Bar., Kota Padang, Sumatera Barat 25136</div>
                </div>
                <div class="garis-kop"></div>
                <div class="judul-laporan">
                    <h1>LAPORAN KEPUASAN MASYARAKAT</h1>
                    <div class="periode">Periode: ' . date('F Y') . '</div>
                </div>
              </div>';

        echo '<table class="data-table">
                <thead>
                    <tr>
                        <th class="col-no" style="width: 12%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">NO</th>
                        <th class="col-nama" style="width: 13%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">NAMA RESPONDEN</th>';

        if (!empty($alternatifs)) {
            foreach ($alternatifs as $alt) {
                $kode = htmlspecialchars($alt['kode_alternatif'] ?? 'A');
                echo '<th style="width: ' . $lebar_kolom_alternatif . '%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">' . $kode . '</th>';
            }
        } else {
            // Fallback 3 kolom dengan distribusi: 60% / 3 = 20% per kolom
            echo '<th style="width: 20%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">A1</th>';
            echo '<th style="width: 20%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">A2</th>';
            echo '<th style="width: 20%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">A3</th>';
        }

        echo '      <th class="col-hasil" style="width: 15%; color: #000000; font-weight: bold; padding: 10px 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #ffffff;">HASIL SMART</th>
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
                        <td class="text-center">' . $no++ . '</td>
                        <td>' . htmlspecialchars($responden['nama_lengkap']) . '</td>';

                if (!empty($alternatifs)) {
                    foreach ($alternatifs as $alt) {
                        $kode_alt = $alt['kode_alternatif'];
                        $nilai = isset($nilai_per_responden_alternatif[$id_responden][$kode_alt])
                            ? $nilai_per_responden_alternatif[$id_responden][$kode_alt]
                            : 0;
                        echo '<td class="text-center nilai-cell">' . number_format($nilai, 2, ',', '.') . '</td>';
                    }
                } else {
                    echo '<td class="text-center nilai-cell">0.00</td>';
                    echo '<td class="text-center nilai-cell">0.00</td>';
                    echo '<td class="text-center nilai-cell">0.00</td>';
                }

                echo '    <td class="text-center"><strong>' . number_format($nilai_terbaik, 2, ',', '.') . '</strong></td>
                      </tr>';
            }
        } else {
            // Tampilkan baris kosong jika tidak ada data
            echo '<tr>
                    <td class="text-center" colspan="' . ($jumlah_alternatif + 3) . '" style="padding: 20px;">
                        <em style="color: #999;">Tidak ada data responden</em>
                    </td>
                  </tr>';
        }

        $rerata_smart = ($stats['rerata_smart'] ?? 0);
        $kesimpulan = ($rerata_smart >= 80) ? 'SANGAT BAIK' : (($rerata_smart >= 60) ? 'BAIK' : 'CUKUP');

        $colspan_footer = $jumlah_alternatif + 2;

        echo '<tr class="footer-row">
                    <td colspan="2" class="footer-label">Total Nilai</td>
                    <td colspan="' . $jumlah_alternatif . '" class="text-right">' . number_format($total_nilai, 2, ',', '.') . '</td>
                    <td class="text-center">' . number_format($total_nilai, 2, ',', '.') . '</td>
                </tr>
                <tr class="footer-row">
                    <td colspan="2" class="footer-label">Rata-rata Nilai</td>
                    <td colspan="' . $jumlah_alternatif . '" class="text-right">' . number_format($rerata_smart, 2, ',', '.') . '</td>
                    <td class="text-center">' . number_format($rerata_smart, 2, ',', '.') . '</td>
                </tr>
                <tr class="footer-row">
                    <td colspan="2" class="footer-label">Kesimpulan</td>
                    <td colspan="' . $jumlah_alternatif . '" class="text-center">' . $kesimpulan . '</td>
                    <td class="text-center">' . $kesimpulan . '</td>
                </tr>
              </tbody>
            </table>';

        // Ambil data user dari session
        $nama_petugas = isset($_SESSION['nama_lengkap']) ? strtoupper($_SESSION['nama_lengkap']) : 'ADMIN PETUGAS';
        $username_petugas = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        // Ambil data kepala dinas dari database (user dengan role admin)
        $nama_kepala_dinas = 'NAMA KEPALA DINAS';
        try {
            $query = "SELECT nama_lengkap FROM users WHERE role = 'admin' LIMIT 1";
            $stmt = $this->laporanModel->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['nama_lengkap'])) {
                $nama_kepala_dinas = strtoupper($result['nama_lengkap']);
            }
        } catch (Exception $e) {
            // Jika error, gunakan default
            error_log("Error getting kepala dinas: " . $e->getMessage());
        }

        // Signature Section
        // Konversi nama bulan ke bahasa Indonesia
        $bulan_indonesia = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $tanggal_inggris = date('d F Y');
        $tanggal_indonesia = str_replace(array_keys($bulan_indonesia), array_values($bulan_indonesia), $tanggal_inggris);

        echo '<div class="signature-section">
                <div class="location-date">&nbsp;Sumatera Barat, ' . $tanggal_indonesia . '</div>
                <table class="signature-table">
                    <tr>
                        <td width="50%" style="vertical-align: top; padding-right: 20px;">
                            <strong>Kepala Dinas</strong><br>
                            Dinas Kependudukan dan<br>
                            Pencatatan Sipil Kota Padang<br><br>
                            <div class="ttd-space"></div>
                            <div class="ttd-container">
                                <span class="nama-pejabat">' . $nama_kepala_dinas . '</span><br>
                                NIP. 19800101 200001 1 001
                            </div>
                        </td>
                        <td width="50%" style="vertical-align: top; padding-left: 20px;">
                            <strong>Petugas</strong><br>
                            Bagian Pelayanan<br>
                            DISDUKCAPIL Kota Padang<br><br>
                            <div class="ttd-space"></div>
                            <div class="ttd-container">
                                <span class="nama-pejabat">' . $nama_petugas . '</span><br>
                                NIP. 19900101 201001 2 002
                            </div>
                        </td>
                    </tr>
                </table>
              </div>';

        echo '<div class="page-number">
                Halaman 1 dari 1
              </div>';

        echo '</body>
              </html>';

        return ob_get_clean();
    }
}
