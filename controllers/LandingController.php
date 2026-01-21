<?php
/**
 * LandingController
 * Controller untuk halaman landing page Dinas Kependudukan dan Pencatatan Sipil Kota Padang
 */
class LandingController
{
    /**
     * Action index - Menampilkan halaman utama landing page
     */
    public function index()
    {
        // Data statis untuk landing page
        $data = [
            'title' => 'Dinas Kependudukan dan Pencatatan Sipil Kota Padang',
            'page_title' => 'DISDUKCAPIL Kota Padang',
            'subtitle' => 'Melayani dengan Sepenuh Hati',
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
