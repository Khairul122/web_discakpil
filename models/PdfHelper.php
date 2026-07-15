<?php
// Komponen HTML/TCPDF bersama untuk semua laporan cetak (kop surat, gaya tabel,
// blok tanda tangan) supaya setiap halaman "Cetak PDF" konsisten dan tidak duplikasi.
class PdfHelper
{
    public static function newPdf(string $title): TCPDF
    {
        $pdf = new TCPDF('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

        $pdf->SetCreator('DISDUKCAPIL Kota Padang');
        $pdf->SetAuthor('DISDUKCAPIL');
        $pdf->SetTitle($title);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(20, 20, 20);
        $pdf->SetAutoPageBreak(true, 30);

        $pdf->AddPage();

        return $pdf;
    }

    public static function baseStyles(): string
    {
        return '<style>
            @page { margin-top: 20mm; margin-bottom: 25mm; margin-left: 15mm; margin-right: 15mm; }
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: Arial, Helvetica, sans-serif; font-size: 11pt; color: #000; line-height: 1.4; }
            .kop-surat-container { margin-bottom: 15px; }
            .kop-surat { text-align: center; margin-bottom: 5px; }
            .kop-title { font-size: 14pt; font-weight: bold; text-transform: uppercase; color: #000; margin-bottom: 2px; line-height: 1.2; }
            .kop-alamat { font-size: 9pt; color: #333; font-style: normal; line-height: 1.2; }
            .garis-kop { border-top: 2px solid #000; margin-bottom: 8px; margin-top: 5px; }
            .judul-laporan { text-align: center; margin-bottom: 15px; }
            .judul-laporan h1 { font-size: 15pt; font-weight: bold; text-transform: uppercase; color: #000; margin-bottom: 5px; line-height: 1.2; }
            .judul-laporan .periode { font-size: 11pt; color: #333; }
            .info-box { margin: 10px 0 18px 0; font-size: 10pt; }
            .info-box table { width: 100%; border-collapse: collapse; }
            .info-box td { padding: 3px 6px; vertical-align: top; }
            .info-box td.label { width: 32%; color: #333; }
            .data-table { width: 100%; border-collapse: collapse; margin: 12px 0; font-size: 10pt; }
            .data-table thead { display: table-header-group; }
            .data-table th { color: #000 !important; font-weight: bold; padding: 8px; text-align: center; border: 1px solid #000; font-size: 9pt; text-transform: uppercase; vertical-align: middle; background-color: #eef2f7; }
            .data-table td { padding: 7px 8px; border: 1px solid #000; vertical-align: middle; color: #000; }
            .data-table tbody tr:nth-child(even) { background-color: #f5f5f5; }
            .text-center { text-align: center; }
            .text-left { text-align: left; }
            .text-right { text-align: right; }
            .footer-row td { padding: 8px; border: 1px solid #000; font-weight: bold; background-color: #e0e0e0; }
            .signature-section { margin-top: 25px; page-break-inside: avoid; }
            .signature-table { width: 100%; margin-top: 20px; }
            .signature-table td { padding: 5px; text-align: left; vertical-align: middle; border: none; }
            .ttd-space { height: 70px; }
            .nama-pejabat { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
            .ttd-container { padding-left: 30px; }
            .location-date-container { padding-left: 30px; }
            .location-date { margin-bottom: 20px; font-size: 10pt; }
        </style>';
    }

    public static function kopSurat(string $judul, string $periode = ''): string
    {
        $periode_html = $periode !== '' ? '<div class="periode" style="font-size: 10pt; color: #333333; margin-top: 3px;">' . htmlspecialchars($periode) . '</div>' : '';
        $logo_path = realpath('assets/images/logo-pdf.png');

        return '<table style="width: 100%; border-collapse: collapse; border: none; margin-bottom: 2px;">
                    <tr>
                        <td width="15%" style="vertical-align: middle; text-align: center; border: none;">
                            <img src="' . $logo_path . '" height="80" />
                        </td>
                        <td width="70%" style="text-align: center; border: none; vertical-align: middle;">
                            <span style="font-size: 24pt; font-weight: bold; font-family: Arial, Helvetica, sans-serif; color: #000000; line-height: 1.2;">KEMENTERIAN DALAM NEGERI</span><br>
                            <span style="font-size: 22pt; font-weight: bold; font-family: Arial, Helvetica, sans-serif; color: #000000; line-height: 1.2;">REPUBLIK INDONESIA</span><br>
                            <span style="font-size: 16pt; font-weight: bold; font-family: Arial, Helvetica, sans-serif; color: #000000; line-height: 1.2;">DIREKTORAT JENDERAL KEPENDUDUKAN DAN PENCATATAN SIPIL</span><br>
                            <span style="font-size: 10pt; font-family: Arial, Helvetica, sans-serif; color: #333333; line-height: 1.3;">Jalan Raya Pasar Minggu KM. 19 Jakarta Selatan 12072</span><br>
                            <span style="font-size: 10pt; font-family: Arial, Helvetica, sans-serif; color: #333333; line-height: 1.3;">Telp. (021) 79194075 (Hunting) Fax (021) 780655, 79499770</span>
                        </td>
                        <td width="15%" style="vertical-align: middle; border: none;"></td>
                    </tr>
                </table>
                <hr style="border: none; border-top: 2.5px double #000000; height: 0px; margin-top: 2px; margin-bottom: 12px;" />
                <div class="judul-laporan" style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                    <h1 style="font-size: 16pt; font-weight: bold; text-transform: uppercase; color: #000000;">' . htmlspecialchars($judul) . '</h1>
                    ' . $periode_html . '
                </div>';
    }

    // Ambil nama Kepala Dinas (user dengan role kepala_dinas) dari database
    public static function getKepalaDinasName(PDO $conn): string
    {
        $nama_kepala_dinas = 'TEDDY ANTONIUS';
        try {
            $stmt = $conn->prepare("SELECT nama_lengkap FROM users WHERE role = 'kepala_dinas' LIMIT 1");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['nama_lengkap'])) {
                $nama_kepala_dinas = strtoupper($result['nama_lengkap']);
            }
        } catch (Exception $e) {
            error_log('Error getting kepala dinas: ' . $e->getMessage());
        }
        return $nama_kepala_dinas;
    }

    public static function tanggalIndonesia(): string
    {
        $bulan_indonesia = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli',
            'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober',
            'November' => 'November', 'December' => 'Desember'
        ];
        return str_replace(array_keys($bulan_indonesia), array_values($bulan_indonesia), date('d F Y'));
    }

    public static function signatureBlock(string $nama_kepala_dinas, string $nama_petugas): string
    {
        $tanggal = self::tanggalIndonesia();
        return '<div class="signature-section" style="margin-top: 30px;">
                    <table class="signature-table" style="width: 100%; border: none;">
                        <tr>
                            <td width="45%" style="vertical-align: top; text-align: left; border: none;">
                                <strong>Mengetahui,</strong><br>
                                <strong>Kepala Dinas</strong><br>
                                Dinas Kependudukan dan Pencatatan Sipil<br>
                                Kota Padang<br>
                                <br><br><br><br>
                                <span style="font-weight: bold; text-decoration: underline;">' . htmlspecialchars($nama_kepala_dinas) . '</span><br>
                                NIP. 19720412 199803 1 002
                            </td>
                            <td width="30%" style="border: none;"></td>
                            <td width="25%" style="vertical-align: top; text-align: left; border: none;">
                                Padang, ' . $tanggal . '<br>
                                <strong>Petugas Pelayanan,</strong><br>
                                Bagian Pelayanan<br>
                                DISDUKCAPIL Kota Padang<br>
                                <br><br><br><br>
                                <span style="font-weight: bold; text-decoration: underline;">' . htmlspecialchars($nama_petugas) . '</span><br>
                                NIP. 19900101 201001 2 002
                            </td>
                        </tr>
                    </table>
                  </div>';
    }

    public static function kategoriSmart(float $nilai): string
    {
        if ($nilai >= 80) return 'Sangat Baik';
        if ($nilai >= 60) return 'Baik';
        if ($nilai >= 40) return 'Cukup';
        if ($nilai >= 20) return 'Kurang';
        return 'Sangat Kurang';
    }
}
?>
