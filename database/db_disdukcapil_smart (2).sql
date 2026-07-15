-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2026 at 02:13 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_disdukcapil_smart`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int NOT NULL,
  `kode_alternatif` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_layanan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `kode_alternatif`, `nama_layanan`, `keterangan`, `created_at`) VALUES
(1, 'A1', 'Layanan KTP Elektronik', 'Perekaman dan pencetakan KTP-el', '2026-01-20 13:33:21'),
(2, 'A2', 'Layanan Kartu Keluarga', 'Pembuatan baru atau perubahan KK', '2026-01-20 13:33:21'),
(3, 'A3', 'Layanan Akta Kelahiran', 'Penerbitan kutipan akta kelahiran', '2026-01-20 13:33:21'),
(4, 'A4', 'Layanan Surat Pindah', 'Surat keterangan pindah datang/keluar', '2026-01-20 13:33:21'),
(5, 'A5', 'Layanan KIA', 'Kartu Identitas Anak', '2026-01-20 13:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_akhir`
--

CREATE TABLE `hasil_akhir` (
  `id_hasil` int NOT NULL,
  `id_responden` int NOT NULL,
  `id_alternatif` int NOT NULL COMMENT 'ID layanan yang dinilai (bukan hanya layanan terbaik)',
  `nilai_smart` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'Nilai SMART untuk layanan terbaik',
  `is_terbaik` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = ranking #1 untuk responden ini (baris pemenang)',
  `tanggal_perhitungan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_akhir`
--

INSERT INTO `hasil_akhir` (`id_hasil`, `id_responden`, `id_alternatif`, `nilai_smart`, `is_terbaik`, `tanggal_perhitungan`) VALUES
(2, 2, 1, 100.0000, 1, '2026-07-15 17:23:44'),
(6, 2, 2, 100.0000, 0, '2026-07-15 17:23:44'),
(7, 2, 3, 100.0000, 0, '2026-07-15 17:23:44'),
(8, 2, 4, 100.0000, 0, '2026-07-15 17:23:44'),
(9, 2, 5, 100.0000, 0, '2026-07-15 17:23:44'),
(38, 9, 1, 100.0000, 1, '2026-07-15 17:21:55'),
(39, 10, 2, 78.7500, 1, '2026-07-15 17:21:55'),
(40, 11, 3, 92.5000, 1, '2026-07-15 17:21:55'),
(41, 12, 4, 81.2500, 1, '2026-07-15 17:21:55'),
(42, 13, 5, 56.2500, 1, '2026-07-15 17:21:55'),
(43, 14, 1, 93.7500, 1, '2026-07-15 17:21:55'),
(44, 15, 2, 68.7500, 1, '2026-07-15 17:21:55'),
(45, 16, 3, 97.5000, 1, '2026-07-15 17:21:55'),
(46, 17, 4, 43.7500, 1, '2026-07-15 17:21:55'),
(47, 18, 5, 77.5000, 1, '2026-07-15 17:21:55'),
(48, 19, 1, 46.2500, 1, '2026-07-15 17:21:55'),
(49, 20, 2, 93.7500, 1, '2026-07-15 17:21:55'),
(50, 21, 3, 78.7500, 1, '2026-07-15 17:21:55'),
(51, 22, 4, 100.0000, 1, '2026-07-15 17:21:55'),
(52, 23, 5, 71.2500, 1, '2026-07-15 17:21:55'),
(53, 24, 1, 31.2500, 1, '2026-07-15 17:21:55'),
(54, 25, 2, 81.2500, 1, '2026-07-15 17:21:55'),
(55, 26, 3, 82.5000, 1, '2026-07-15 17:21:55'),
(56, 27, 4, 67.5000, 1, '2026-07-15 17:21:56'),
(57, 28, 5, 97.5000, 1, '2026-07-15 17:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int NOT NULL,
  `kode_kriteria` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kriteria` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_general_ci NOT NULL,
  `bobot` int NOT NULL,
  `jenis` enum('benefit','cost') COLLATE utf8mb4_general_ci DEFAULT 'benefit',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `pertanyaan`, `bobot`, `jenis`, `created_at`) VALUES
(1, 'C1', 'Kecepatan Waktu', 'Bagaimana penilaian Anda terhadap kecepatan waktu penyelesaian dokumen dibanding janji layanan?', 20, 'benefit', '2026-01-20 13:33:21'),
(2, 'C2', 'Kesesuaian Syarat', 'Apakah persyaratan pelayanan yang diminta sesuai dengan ketentuan yang dipublikasikan?', 15, 'benefit', '2026-01-20 13:33:21'),
(3, 'C3', 'Kompetensi Petugas', 'Bagaimana kecakapan dan keterampilan petugas dalam melayani kebutuhan Anda?', 15, 'benefit', '2026-01-20 13:33:21'),
(4, 'C4', 'Sarana Prasarana', 'Bagaimana kenyamanan ruang tunggu dan ketersediaan fasilitas pendukung?', 10, 'benefit', '2026-01-20 13:33:21'),
(5, 'C5', 'Respon Pengaduan', 'Bagaimana respon petugas terhadap pertanyaan atau keluhan yang Anda sampaikan?', 10, 'benefit', '2026-01-20 13:33:21'),
(6, 'C6', 'Prosedur', 'Bagaimana penilaian Anda terhadap kemudahan alur/prosedur pelayanan yang harus dilalui?', 15, 'benefit', '2026-07-15 10:21:08'),
(7, 'C7', 'Perilaku Pelaksana', 'Bagaimana keramahan dan kesopanan petugas dalam memberikan pelayanan kepada Anda?', 15, 'benefit', '2026-07-15 10:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int NOT NULL,
  `migration` varchar(255) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `applied_at`) VALUES
(1, 'migration_002_hasil_akhir_full_matrix.sql', '2026-07-15 10:26:31'),
(2, 'migration_003_tambah_kriteria_prosedur_perilaku.sql', '2026-07-15 10:26:31'),
(3, 'backfill_kriteria_baru.php', '2026-07-15 10:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int NOT NULL,
  `id_responden` int NOT NULL,
  `id_alternatif` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `id_sub` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_responden`, `id_alternatif`, `id_kriteria`, `id_sub`) VALUES
(1, 2, 1, 1, 1),
(2, 2, 1, 2, 5),
(3, 2, 1, 3, 9),
(4, 2, 1, 4, 13),
(5, 2, 1, 5, 17),
(6, 2, 2, 1, 1),
(7, 2, 2, 2, 5),
(8, 2, 2, 3, 9),
(9, 2, 2, 4, 13),
(10, 2, 2, 5, 17),
(11, 2, 3, 1, 1),
(12, 2, 3, 2, 5),
(13, 2, 3, 3, 9),
(14, 2, 3, 4, 13),
(15, 2, 3, 5, 17),
(16, 2, 4, 1, 1),
(17, 2, 4, 2, 5),
(18, 2, 4, 3, 9),
(19, 2, 4, 4, 13),
(20, 2, 4, 5, 17),
(21, 2, 5, 1, 1),
(22, 2, 5, 2, 5),
(23, 2, 5, 3, 9),
(24, 2, 5, 4, 13),
(25, 2, 5, 5, 17),
(76, 9, 1, 1, 1),
(77, 9, 1, 2, 5),
(78, 9, 1, 3, 9),
(79, 9, 1, 4, 13),
(80, 9, 1, 5, 17),
(81, 10, 2, 1, 2),
(82, 10, 2, 2, 6),
(83, 10, 2, 3, 9),
(84, 10, 2, 4, 14),
(85, 10, 2, 5, 18),
(86, 11, 3, 1, 1),
(87, 11, 3, 2, 6),
(88, 11, 3, 3, 10),
(89, 11, 3, 4, 13),
(90, 11, 3, 5, 17),
(91, 12, 4, 1, 2),
(92, 12, 4, 2, 5),
(93, 12, 4, 3, 10),
(94, 12, 4, 4, 14),
(95, 12, 4, 5, 17),
(96, 13, 5, 1, 3),
(97, 13, 5, 2, 6),
(98, 13, 5, 3, 11),
(99, 13, 5, 4, 14),
(100, 13, 5, 5, 19),
(101, 14, 1, 1, 1),
(102, 14, 1, 2, 5),
(103, 14, 1, 3, 10),
(104, 14, 1, 4, 13),
(105, 14, 1, 5, 18),
(106, 15, 2, 1, 2),
(107, 15, 2, 2, 7),
(108, 15, 2, 3, 10),
(109, 15, 2, 4, 15),
(110, 15, 2, 5, 18),
(111, 16, 3, 1, 1),
(112, 16, 3, 2, 5),
(113, 16, 3, 3, 9),
(114, 16, 3, 4, 14),
(115, 16, 3, 5, 17),
(116, 17, 4, 1, 3),
(117, 17, 4, 2, 8),
(118, 17, 4, 3, 11),
(119, 17, 4, 4, 15),
(120, 17, 4, 5, 20),
(121, 18, 5, 1, 2),
(122, 18, 5, 2, 6),
(123, 18, 5, 3, 10),
(124, 18, 5, 4, 13),
(125, 18, 5, 5, 18),
(126, 19, 1, 1, 3),
(127, 19, 1, 2, 7),
(128, 19, 1, 3, 12),
(129, 19, 1, 4, 15),
(130, 19, 1, 5, 19),
(131, 20, 2, 1, 1),
(132, 20, 2, 2, 6),
(133, 20, 2, 3, 9),
(134, 20, 2, 4, 13),
(135, 20, 2, 5, 18),
(136, 21, 3, 1, 2),
(137, 21, 3, 2, 5),
(138, 21, 3, 3, 10),
(139, 21, 3, 4, 14),
(140, 21, 3, 5, 18),
(141, 22, 4, 1, 1),
(142, 22, 4, 2, 5),
(143, 22, 4, 3, 9),
(144, 22, 4, 4, 13),
(145, 22, 4, 5, 17),
(146, 23, 5, 1, 2),
(147, 23, 5, 2, 6),
(148, 23, 5, 3, 11),
(149, 23, 5, 4, 14),
(150, 23, 5, 5, 18),
(151, 24, 1, 1, 4),
(152, 24, 1, 2, 7),
(153, 24, 1, 3, 12),
(154, 24, 1, 4, 16),
(155, 24, 1, 5, 19),
(156, 25, 2, 1, 2),
(157, 25, 2, 2, 6),
(158, 25, 2, 3, 9),
(159, 25, 2, 4, 14),
(160, 25, 2, 5, 17),
(161, 26, 3, 1, 1),
(162, 26, 3, 2, 6),
(163, 26, 3, 3, 10),
(164, 26, 3, 4, 13),
(165, 26, 3, 5, 18),
(166, 27, 4, 1, 3),
(167, 27, 4, 2, 6),
(168, 27, 4, 3, 10),
(169, 27, 4, 4, 15),
(170, 27, 4, 5, 18),
(171, 28, 5, 1, 1),
(172, 28, 5, 2, 5),
(173, 28, 5, 3, 9),
(174, 28, 5, 4, 14),
(175, 28, 5, 5, 17),
(176, 2, 1, 6, 21),
(177, 2, 1, 7, 25),
(178, 2, 2, 6, 21),
(179, 2, 2, 7, 25),
(180, 2, 3, 6, 21),
(181, 2, 3, 7, 25),
(182, 2, 4, 6, 21),
(183, 2, 4, 7, 25),
(184, 2, 5, 6, 21),
(185, 2, 5, 7, 25),
(186, 9, 1, 6, 21),
(187, 9, 1, 7, 25),
(188, 10, 2, 6, 22),
(189, 10, 2, 7, 26),
(190, 11, 3, 6, 21),
(191, 11, 3, 7, 25),
(192, 12, 4, 6, 22),
(193, 12, 4, 7, 26),
(194, 13, 5, 6, 23),
(195, 13, 5, 7, 27),
(196, 14, 1, 6, 21),
(197, 14, 1, 7, 25),
(198, 15, 2, 6, 22),
(199, 15, 2, 7, 26),
(200, 16, 3, 6, 21),
(201, 16, 3, 7, 25),
(202, 17, 4, 6, 23),
(203, 17, 4, 7, 27),
(204, 18, 5, 6, 22),
(205, 18, 5, 7, 26),
(206, 19, 1, 6, 23),
(207, 19, 1, 7, 27),
(208, 20, 2, 6, 21),
(209, 20, 2, 7, 25),
(210, 21, 3, 6, 22),
(211, 21, 3, 7, 26),
(212, 22, 4, 6, 21),
(213, 22, 4, 7, 25),
(214, 23, 5, 6, 22),
(215, 23, 5, 7, 26),
(216, 24, 1, 6, 24),
(217, 24, 1, 7, 28),
(218, 25, 2, 6, 22),
(219, 25, 2, 7, 26),
(220, 26, 3, 6, 22),
(221, 26, 3, 7, 26),
(222, 27, 4, 6, 22),
(223, 27, 4, 7, 26),
(224, 28, 5, 6, 21),
(225, 28, 5, 7, 25);

-- --------------------------------------------------------

--
-- Table structure for table `responden`
--

CREATE TABLE `responden` (
  `id_responden` int NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usia` int DEFAULT NULL,
  `pekerjaan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_isi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responden`
--

INSERT INTO `responden` (`id_responden`, `nama_lengkap`, `usia`, `pekerjaan`, `tanggal_isi`) VALUES
(2, 'BUDI', 20, 'PNS', '2026-01-20 22:11:30'),
(9, 'Andi Saputra', 34, 'Wiraswasta', '2026-07-15 10:16:20'),
(10, 'Siti Rahma', 28, 'Ibu Rumah Tangga', '2026-07-15 10:16:20'),
(11, 'Budi Santoso', 45, 'PNS', '2026-07-14 10:16:20'),
(12, 'Dewi Lestari', 22, 'Mahasiswa', '2026-07-13 10:16:20'),
(13, 'Ahmad Fauzi', 50, 'Petani', '2026-07-12 10:16:20'),
(14, 'Rina Marlina', 31, 'Guru', '2026-07-10 10:16:20'),
(15, 'Hendra Gunawan', 39, 'Wiraswasta', '2026-07-08 10:16:20'),
(16, 'Yuni Kartika', 26, 'Karyawan Swasta', '2026-07-05 10:16:20'),
(17, 'Rudi Hartono', 55, 'Pensiunan', '2026-07-01 10:16:20'),
(18, 'Fitri Handayani', 33, 'PNS', '2026-06-27 10:16:20'),
(19, 'Agus Setiawan', 41, 'Buruh', '2026-06-23 10:16:20'),
(20, 'Maya Anggraini', 24, 'Mahasiswa', '2026-06-18 10:16:20'),
(21, 'Dedi Kurniawan', 37, 'Wiraswasta', '2026-06-10 10:16:21'),
(22, 'Nurul Hidayah', 29, 'Ibu Rumah Tangga', '2026-06-05 10:16:21'),
(23, 'Bambang Wijaya', 48, 'PNS', '2026-05-28 10:16:21'),
(24, 'Wulan Sari', 27, 'Karyawan Swasta', '2026-05-21 10:16:21'),
(25, 'Joko Prasetyo', 43, 'Petani', '2026-05-13 10:16:21'),
(26, 'Ratna Sari', 35, 'Guru', '2026-05-06 10:16:21'),
(27, 'Eko Purnomo', 30, 'Wiraswasta', '2026-04-26 10:16:21'),
(28, 'Indah Permata', 25, 'Mahasiswa', '2026-04-11 10:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nama_pilihan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_utility` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub`, `id_kriteria`, `nama_pilihan`, `nilai_utility`) VALUES
(1, 1, 'Sangat Cepat', 100),
(2, 1, 'Cepat', 75),
(3, 1, 'Cukup Cepat', 50),
(4, 1, 'Tidak Cepat', 25),
(5, 2, 'Sangat Sesuai', 100),
(6, 2, 'Sesuai', 75),
(7, 2, 'Kurang Sesuai', 50),
(8, 2, 'Tidak Sesuai', 25),
(9, 3, 'Sangat Kompeten', 100),
(10, 3, 'Kompeten', 75),
(11, 3, 'Cukup Kompeten', 50),
(12, 3, 'Tidak Kompeten', 25),
(13, 4, 'Sangat Nyaman', 100),
(14, 4, 'Nyaman', 75),
(15, 4, 'Cukup Nyaman', 50),
(16, 4, 'Tidak Nyaman', 25),
(17, 5, 'Sangat Responsif', 100),
(18, 5, 'Responsif', 75),
(19, 5, 'Cukup Responsif', 50),
(20, 5, 'Tidak Responsif', 25),
(21, 6, 'Sangat Mudah', 100),
(22, 6, 'Mudah', 75),
(23, 6, 'Cukup Mudah', 50),
(24, 6, 'Tidak Mudah', 25),
(25, 7, 'Sangat Ramah', 100),
(26, 7, 'Ramah', 75),
(27, 7, 'Cukup Ramah', 50),
(28, 7, 'Tidak Ramah', 25);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','kepala_dinas') COLLATE utf8mb4_general_ci DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `nip`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$TvUkVDZ9eFwF6Fyjha/s/OUh25thVXflceLHtvi4PWs7BN5axRKzS', 'ADMINISTRATOR SISTEM', '19900101 201001 2 002', 'admin', '2026-01-20 13:33:21'),
(2, 'kadis', '$2y$10$TvUkVDZ9eFwF6Fyjha/s/OUh25thVXflceLHtvi4PWs7BN5axRKzS', 'TEDDY ANTONIUS', '19720412 199803 1 002', 'kepala_dinas', '2026-01-20 13:33:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD PRIMARY KEY (`id_hasil`),
  ADD UNIQUE KEY `idx_responden_alternatif` (`id_responden`,`id_alternatif`),
  ADD KEY `idx_nilai_smart` (`nilai_smart` DESC),
  ADD KEY `idx_tanggal` (`tanggal_perhitungan`),
  ADD KEY `idx_alternatif` (`id_alternatif`),
  ADD KEY `idx_responden_terbaik` (`id_responden`,`is_terbaik`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_migration` (`migration`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_responden` (`id_responden`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_sub` (`id_sub`);

--
-- Indexes for table `responden`
--
ALTER TABLE `responden`
  ADD PRIMARY KEY (`id_responden`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `responden`
--
ALTER TABLE `responden`
  MODIFY `id_responden` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD CONSTRAINT `hasil_akhir_ibfk_1` FOREIGN KEY (`id_responden`) REFERENCES `responden` (`id_responden`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_akhir_ibfk_2` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_responden`) REFERENCES `responden` (`id_responden`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_4` FOREIGN KEY (`id_sub`) REFERENCES `sub_kriteria` (`id_sub`) ON DELETE CASCADE;

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
