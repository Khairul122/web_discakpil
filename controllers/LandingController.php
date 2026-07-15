<?php
/**
 * LandingController
 * Controller untuk halaman landing page Dinas Kependudukan dan Pencatatan Sipil Kota Padang
 */
class LandingController
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    /**
     * Action index - Menampilkan halaman utama landing page dengan data real dari DB
     */
    public function index()
    {
        // 1. Fetch real statistics from database
        $total_responden = 0;
        $total_penilaian = 0;
        $total_alternatif = 0;
        $rerata_smart = 0;

        try {
            // Total Responden
            $total_responden = (int) $this->conn->query("SELECT COUNT(*) FROM responden")->fetchColumn();
            
            // Total Penilaian
            $total_penilaian = (int) $this->conn->query("SELECT COUNT(*) FROM penilaian")->fetchColumn();
            
            // Total Alternatif
            $total_alternatif = (int) $this->conn->query("SELECT COUNT(*) FROM alternatif")->fetchColumn();
            
            // Rerata Nilai SMART
            $avg_val = $this->conn->query("SELECT AVG(nilai_smart) FROM hasil_akhir")->fetchColumn();
            if ($avg_val) {
                $rerata_smart = (float) $avg_val;
            }
        } catch (Exception $e) {
            error_log("Landing statistics fetch error: " . $e->getMessage());
        }

        // 2. Fetch real individual service ratings
        $layanan_rating = [];
        try {
            $stmt = $this->conn->query("
                SELECT a.nama_layanan, COALESCE(AVG(h.nilai_smart), 0) as rerata 
                FROM alternatif a 
                LEFT JOIN hasil_akhir h ON a.id_alternatif = h.id_alternatif 
                GROUP BY a.id_alternatif, a.nama_layanan
                ORDER BY rerata DESC
                LIMIT 3
            ");
            $layanan_rating = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Landing service ratings fetch error: " . $e->getMessage());
        }

        // 3. Fetch most recent respondent
        $recent_responden = null;
        try {
            $stmt = $this->conn->query("SELECT nama_lengkap, tanggal_isi FROM responden ORDER BY tanggal_isi DESC LIMIT 1");
            $recent_responden = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Landing recent respondent fetch error: " . $e->getMessage());
        }

        // Static texts along with the fetched DB statistics
        $data = [
            'title' => 'Sistem Informasi Penilaian Kepuasan Masyarakat Terhadap Layanan Kantor Dinas Kependudukan dan Pencatatan Sipil Kota Padang Menggunakan Metode SMART',
            'page_title' => 'Sistem Informasi Penilaian Kepuasan Masyarakat Terhadap Layanan Kantor Dinas Kependudukan dan Pencatatan Sipil Kota Padang Menggunakan Metode SMART',
            'subtitle' => 'Melayani dengan Sepenuh Hati',
            'total_responden' => $total_responden,
            'total_penilaian' => $total_penilaian,
            'total_alternatif' => $total_alternatif,
            'rerata_smart' => $rerata_smart,
            'layanan_rating' => $layanan_rating,
            'recent_responden' => $recent_responden,
            'tentang' => [
                'judul' => 'Tentang Kami',
                'deskripsi' => 'Dinas Kependudukan dan Pencatatan Sipil (DISDUKCAPIL) Kota Padang adalah unsur pelaksana urusan pemerintahan di bidang administrasi kependudukan dan pencatatan sipil yang bertugas memberikan pelayanan prima kepada masyarakat.',
                'poin' => [
                    [
                        'icon' => 'fas fa-id-card',
                        'judul' => 'Administrasi Kependudukan',
                        'deskripsi' => 'Pelayanan administrasi kependudukan seperti KTP-el, Kartu Keluarga, dan akta pencatatan sipil'
                    ],
                    [
                        'icon' => 'fas fa-users',
                        'judul' => 'Pencatatan Sipil',
                        'deskripsi' => 'Pencatatan kelahiran, kematian, perkawinan, perceraian, dan peristiwa kependudukan lainnya'
                    ],
                    [
                        'icon' => 'fas fa-database',
                        'judul' => 'Sistem Informasi',
                        'deskripsi' => 'Pengelolaan data kependudukan yang terintegrasi secara nasional'
                    ],
                    [
                        'icon' => 'fas fa-hand-holding-heart',
                        'judul' => 'Pelayanan Prima',
                        'deskripsi' => 'Memberikan pelayanan yang cepat, mudah, transparan, dan akuntabel'
                    ]
                ]
            ],
            'visi' => 'Terwujudnya Masyarakat Kota Padang yang Tertib Administrasi Kependudukan melalui Pelayanan Prima yang Cepat, Tepat, dan Profesional Menuju Padang Kota Metropolis Madani',
            'misi' => [
                'Meningkatkan kualitas pelayanan administrasi kependudukan dan pencatatan sipil yang mudah, transparan, dan akuntabel',
                'Menyediakan sarana dan prasarana pelayanan yang memadai dan berbasis teknologi informasi',
                'Meningkatkan kompetensi SDM aparatur yang profesional, berintegritas, dan berorientasi pada pelayanan',
                'Mewujudkan kerja sama yang sinergis dengan seluruh stakeholder terkait',
                'Mengembangkan inovasi pelayanan berbasis digital untuk kemudahan masyarakat',
                'Menjamin keakuratan dan keutuhan data kependudukan yang terintegrasi secara nasional'
            ]
        ];

        // Load view
        require_once 'views/landing/index.php';
    }
}
?>
