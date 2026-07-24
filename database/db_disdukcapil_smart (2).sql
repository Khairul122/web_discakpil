-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 24, 2026 at 01:52 PM
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
(1, 1, 1, 93.7500, 1, '2026-07-24 20:49:55'),
(2, 1, 4, 93.7500, 0, '2026-07-24 20:49:55'),
(3, 1, 3, 92.5000, 0, '2026-07-24 20:49:55'),
(4, 1, 2, 88.7500, 0, '2026-07-24 20:49:55'),
(5, 2, 3, 93.7500, 1, '2026-07-24 20:49:55'),
(6, 2, 2, 92.5000, 0, '2026-07-24 20:49:55'),
(7, 2, 5, 92.5000, 0, '2026-07-24 20:49:55'),
(8, 2, 1, 88.7500, 0, '2026-07-24 20:49:55'),
(9, 3, 2, 93.7500, 1, '2026-07-24 20:49:56'),
(10, 3, 5, 93.7500, 0, '2026-07-24 20:49:56'),
(11, 3, 1, 92.5000, 0, '2026-07-24 20:49:56'),
(12, 3, 4, 92.5000, 0, '2026-07-24 20:49:56'),
(13, 4, 1, 93.7500, 1, '2026-07-24 20:49:56'),
(14, 4, 4, 93.7500, 0, '2026-07-24 20:49:56'),
(15, 4, 3, 92.5000, 0, '2026-07-24 20:49:56'),
(16, 4, 5, 88.7500, 0, '2026-07-24 20:49:56'),
(17, 5, 3, 93.7500, 1, '2026-07-24 20:49:56'),
(18, 5, 2, 92.5000, 0, '2026-07-24 20:49:56'),
(19, 5, 5, 92.5000, 0, '2026-07-24 20:49:56'),
(20, 5, 4, 88.7500, 0, '2026-07-24 20:49:56'),
(21, 6, 2, 93.7500, 1, '2026-07-24 20:49:56'),
(22, 6, 1, 92.5000, 0, '2026-07-24 20:49:56'),
(23, 6, 4, 92.5000, 0, '2026-07-24 20:49:56'),
(24, 6, 3, 88.7500, 0, '2026-07-24 20:49:56'),
(25, 7, 1, 93.7500, 1, '2026-07-24 20:49:57'),
(26, 7, 3, 92.5000, 0, '2026-07-24 20:49:57'),
(27, 7, 2, 88.7500, 0, '2026-07-24 20:49:57'),
(28, 7, 5, 88.7500, 0, '2026-07-24 20:49:57'),
(29, 8, 2, 92.5000, 1, '2026-07-24 20:49:57'),
(30, 8, 5, 92.5000, 0, '2026-07-24 20:49:57'),
(31, 8, 1, 88.7500, 0, '2026-07-24 20:49:57'),
(32, 8, 4, 88.7500, 0, '2026-07-24 20:49:57'),
(33, 9, 5, 93.7500, 1, '2026-07-24 20:49:57'),
(34, 9, 1, 92.5000, 0, '2026-07-24 20:49:57'),
(35, 9, 4, 92.5000, 0, '2026-07-24 20:49:57'),
(36, 9, 3, 88.7500, 0, '2026-07-24 20:49:57'),
(37, 10, 4, 93.7500, 1, '2026-07-24 20:49:57'),
(38, 10, 3, 92.5000, 0, '2026-07-24 20:49:57'),
(39, 10, 2, 88.7500, 0, '2026-07-24 20:49:57'),
(40, 10, 5, 88.7500, 0, '2026-07-24 20:49:57'),
(41, 11, 3, 93.7500, 1, '2026-07-24 20:49:57'),
(42, 11, 2, 92.5000, 0, '2026-07-24 20:49:57'),
(43, 11, 1, 88.7500, 0, '2026-07-24 20:49:58'),
(44, 11, 4, 88.7500, 0, '2026-07-24 20:49:58'),
(45, 12, 2, 93.7500, 1, '2026-07-24 20:49:58'),
(46, 12, 5, 93.7500, 0, '2026-07-24 20:49:58'),
(47, 12, 1, 92.5000, 0, '2026-07-24 20:49:58'),
(48, 12, 3, 88.7500, 0, '2026-07-24 20:49:58'),
(49, 13, 1, 93.7500, 1, '2026-07-24 20:49:58'),
(50, 13, 4, 93.7500, 0, '2026-07-24 20:49:58'),
(51, 13, 2, 88.7500, 0, '2026-07-24 20:49:58'),
(52, 13, 5, 88.7500, 0, '2026-07-24 20:49:58'),
(53, 14, 3, 93.7500, 1, '2026-07-24 20:49:58'),
(54, 14, 5, 92.5000, 0, '2026-07-24 20:49:58'),
(55, 14, 1, 88.7500, 0, '2026-07-24 20:49:58'),
(56, 14, 4, 88.7500, 0, '2026-07-24 20:49:58'),
(57, 15, 2, 93.7500, 1, '2026-07-24 20:49:58'),
(58, 15, 5, 93.7500, 0, '2026-07-24 20:49:58'),
(59, 15, 4, 92.5000, 0, '2026-07-24 20:49:58'),
(60, 15, 3, 88.7500, 0, '2026-07-24 20:49:58'),
(61, 16, 1, 93.7500, 1, '2026-07-24 20:49:59'),
(62, 16, 4, 93.7500, 0, '2026-07-24 20:49:59'),
(63, 16, 3, 92.5000, 0, '2026-07-24 20:49:59'),
(64, 16, 2, 88.7500, 0, '2026-07-24 20:49:59'),
(65, 17, 3, 93.7500, 1, '2026-07-24 20:49:59'),
(66, 17, 2, 92.5000, 0, '2026-07-24 20:49:59'),
(67, 17, 5, 92.5000, 0, '2026-07-24 20:49:59'),
(68, 17, 1, 88.7500, 0, '2026-07-24 20:49:59'),
(69, 18, 2, 93.7500, 1, '2026-07-24 20:49:59'),
(70, 18, 5, 93.7500, 0, '2026-07-24 20:49:59'),
(71, 18, 1, 92.5000, 0, '2026-07-24 20:49:59'),
(72, 18, 4, 92.5000, 0, '2026-07-24 20:49:59'),
(73, 19, 1, 93.7500, 1, '2026-07-24 20:49:59'),
(74, 19, 4, 93.7500, 0, '2026-07-24 20:49:59'),
(75, 19, 3, 92.5000, 0, '2026-07-24 20:49:59'),
(76, 19, 5, 88.7500, 0, '2026-07-24 20:49:59'),
(77, 20, 3, 93.7500, 1, '2026-07-24 20:49:59'),
(78, 20, 2, 92.5000, 0, '2026-07-24 20:49:59'),
(79, 20, 5, 92.5000, 0, '2026-07-24 20:49:59'),
(80, 20, 4, 88.7500, 0, '2026-07-24 20:49:59');

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
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 6),
(3, 1, 1, 3, 9),
(4, 1, 1, 4, 13),
(5, 1, 1, 5, 18),
(6, 1, 1, 6, 21),
(7, 1, 1, 7, 25),
(8, 1, 2, 1, 2),
(9, 1, 2, 2, 5),
(10, 1, 2, 3, 9),
(11, 1, 2, 4, 14),
(12, 1, 2, 5, 17),
(13, 1, 2, 6, 21),
(14, 1, 2, 7, 26),
(15, 1, 3, 1, 1),
(16, 1, 3, 2, 5),
(17, 1, 3, 3, 10),
(18, 1, 3, 4, 13),
(19, 1, 3, 5, 17),
(20, 1, 3, 6, 22),
(21, 1, 3, 7, 25),
(22, 1, 4, 1, 1),
(23, 1, 4, 2, 6),
(24, 1, 4, 3, 9),
(25, 1, 4, 4, 13),
(26, 1, 4, 5, 18),
(27, 1, 4, 6, 21),
(28, 1, 4, 7, 25),
(29, 2, 1, 1, 2),
(30, 2, 1, 2, 5),
(31, 2, 1, 3, 9),
(32, 2, 1, 4, 14),
(33, 2, 1, 5, 17),
(34, 2, 1, 6, 21),
(35, 2, 1, 7, 26),
(36, 2, 2, 1, 1),
(37, 2, 2, 2, 5),
(38, 2, 2, 3, 10),
(39, 2, 2, 4, 13),
(40, 2, 2, 5, 17),
(41, 2, 2, 6, 22),
(42, 2, 2, 7, 25),
(43, 2, 3, 1, 1),
(44, 2, 3, 2, 6),
(45, 2, 3, 3, 9),
(46, 2, 3, 4, 13),
(47, 2, 3, 5, 18),
(48, 2, 3, 6, 21),
(49, 2, 3, 7, 25),
(50, 2, 5, 1, 1),
(51, 2, 5, 2, 5),
(52, 2, 5, 3, 10),
(53, 2, 5, 4, 13),
(54, 2, 5, 5, 17),
(55, 2, 5, 6, 22),
(56, 2, 5, 7, 25),
(57, 3, 1, 1, 1),
(58, 3, 1, 2, 5),
(59, 3, 1, 3, 10),
(60, 3, 1, 4, 13),
(61, 3, 1, 5, 17),
(62, 3, 1, 6, 22),
(63, 3, 1, 7, 25),
(64, 3, 2, 1, 1),
(65, 3, 2, 2, 6),
(66, 3, 2, 3, 9),
(67, 3, 2, 4, 13),
(68, 3, 2, 5, 18),
(69, 3, 2, 6, 21),
(70, 3, 2, 7, 25),
(71, 3, 4, 1, 1),
(72, 3, 4, 2, 5),
(73, 3, 4, 3, 10),
(74, 3, 4, 4, 13),
(75, 3, 4, 5, 17),
(76, 3, 4, 6, 22),
(77, 3, 4, 7, 25),
(78, 3, 5, 1, 1),
(79, 3, 5, 2, 6),
(80, 3, 5, 3, 9),
(81, 3, 5, 4, 13),
(82, 3, 5, 5, 18),
(83, 3, 5, 6, 21),
(84, 3, 5, 7, 25),
(85, 4, 1, 1, 1),
(86, 4, 1, 2, 6),
(87, 4, 1, 3, 9),
(88, 4, 1, 4, 13),
(89, 4, 1, 5, 18),
(90, 4, 1, 6, 21),
(91, 4, 1, 7, 25),
(92, 4, 3, 1, 1),
(93, 4, 3, 2, 5),
(94, 4, 3, 3, 10),
(95, 4, 3, 4, 13),
(96, 4, 3, 5, 17),
(97, 4, 3, 6, 22),
(98, 4, 3, 7, 25),
(99, 4, 4, 1, 1),
(100, 4, 4, 2, 6),
(101, 4, 4, 3, 9),
(102, 4, 4, 4, 13),
(103, 4, 4, 5, 18),
(104, 4, 4, 6, 21),
(105, 4, 4, 7, 25),
(106, 4, 5, 1, 2),
(107, 4, 5, 2, 5),
(108, 4, 5, 3, 9),
(109, 4, 5, 4, 14),
(110, 4, 5, 5, 17),
(111, 4, 5, 6, 21),
(112, 4, 5, 7, 26),
(113, 5, 2, 1, 1),
(114, 5, 2, 2, 5),
(115, 5, 2, 3, 10),
(116, 5, 2, 4, 13),
(117, 5, 2, 5, 17),
(118, 5, 2, 6, 22),
(119, 5, 2, 7, 25),
(120, 5, 3, 1, 1),
(121, 5, 3, 2, 6),
(122, 5, 3, 3, 9),
(123, 5, 3, 4, 13),
(124, 5, 3, 5, 18),
(125, 5, 3, 6, 21),
(126, 5, 3, 7, 25),
(127, 5, 4, 1, 2),
(128, 5, 4, 2, 5),
(129, 5, 4, 3, 9),
(130, 5, 4, 4, 14),
(131, 5, 4, 5, 17),
(132, 5, 4, 6, 21),
(133, 5, 4, 7, 26),
(134, 5, 5, 1, 1),
(135, 5, 5, 2, 5),
(136, 5, 5, 3, 10),
(137, 5, 5, 4, 13),
(138, 5, 5, 5, 17),
(139, 5, 5, 6, 22),
(140, 5, 5, 7, 25),
(141, 6, 1, 1, 1),
(142, 6, 1, 2, 5),
(143, 6, 1, 3, 10),
(144, 6, 1, 4, 13),
(145, 6, 1, 5, 17),
(146, 6, 1, 6, 22),
(147, 6, 1, 7, 25),
(148, 6, 2, 1, 1),
(149, 6, 2, 2, 6),
(150, 6, 2, 3, 9),
(151, 6, 2, 4, 13),
(152, 6, 2, 5, 18),
(153, 6, 2, 6, 21),
(154, 6, 2, 7, 25),
(155, 6, 3, 1, 2),
(156, 6, 3, 2, 5),
(157, 6, 3, 3, 9),
(158, 6, 3, 4, 14),
(159, 6, 3, 5, 17),
(160, 6, 3, 6, 21),
(161, 6, 3, 7, 26),
(162, 6, 4, 1, 1),
(163, 6, 4, 2, 5),
(164, 6, 4, 3, 10),
(165, 6, 4, 4, 13),
(166, 6, 4, 5, 17),
(167, 6, 4, 6, 22),
(168, 6, 4, 7, 25),
(169, 7, 1, 1, 1),
(170, 7, 1, 2, 6),
(171, 7, 1, 3, 9),
(172, 7, 1, 4, 13),
(173, 7, 1, 5, 18),
(174, 7, 1, 6, 21),
(175, 7, 1, 7, 25),
(176, 7, 2, 1, 2),
(177, 7, 2, 2, 5),
(178, 7, 2, 3, 9),
(179, 7, 2, 4, 14),
(180, 7, 2, 5, 17),
(181, 7, 2, 6, 21),
(182, 7, 2, 7, 26),
(183, 7, 3, 1, 1),
(184, 7, 3, 2, 5),
(185, 7, 3, 3, 10),
(186, 7, 3, 4, 13),
(187, 7, 3, 5, 17),
(188, 7, 3, 6, 22),
(189, 7, 3, 7, 25),
(190, 7, 5, 1, 2),
(191, 7, 5, 2, 5),
(192, 7, 5, 3, 9),
(193, 7, 5, 4, 14),
(194, 7, 5, 5, 17),
(195, 7, 5, 6, 21),
(196, 7, 5, 7, 26),
(197, 8, 1, 1, 2),
(198, 8, 1, 2, 5),
(199, 8, 1, 3, 9),
(200, 8, 1, 4, 14),
(201, 8, 1, 5, 17),
(202, 8, 1, 6, 21),
(203, 8, 1, 7, 26),
(204, 8, 2, 1, 1),
(205, 8, 2, 2, 5),
(206, 8, 2, 3, 10),
(207, 8, 2, 4, 13),
(208, 8, 2, 5, 17),
(209, 8, 2, 6, 22),
(210, 8, 2, 7, 25),
(211, 8, 4, 1, 2),
(212, 8, 4, 2, 5),
(213, 8, 4, 3, 9),
(214, 8, 4, 4, 14),
(215, 8, 4, 5, 17),
(216, 8, 4, 6, 21),
(217, 8, 4, 7, 26),
(218, 8, 5, 1, 1),
(219, 8, 5, 2, 5),
(220, 8, 5, 3, 10),
(221, 8, 5, 4, 13),
(222, 8, 5, 5, 17),
(223, 8, 5, 6, 22),
(224, 8, 5, 7, 25),
(225, 9, 1, 1, 1),
(226, 9, 1, 2, 5),
(227, 9, 1, 3, 10),
(228, 9, 1, 4, 13),
(229, 9, 1, 5, 17),
(230, 9, 1, 6, 22),
(231, 9, 1, 7, 25),
(232, 9, 3, 1, 2),
(233, 9, 3, 2, 5),
(234, 9, 3, 3, 9),
(235, 9, 3, 4, 14),
(236, 9, 3, 5, 17),
(237, 9, 3, 6, 21),
(238, 9, 3, 7, 26),
(239, 9, 4, 1, 1),
(240, 9, 4, 2, 5),
(241, 9, 4, 3, 10),
(242, 9, 4, 4, 13),
(243, 9, 4, 5, 17),
(244, 9, 4, 6, 22),
(245, 9, 4, 7, 25),
(246, 9, 5, 1, 1),
(247, 9, 5, 2, 6),
(248, 9, 5, 3, 9),
(249, 9, 5, 4, 13),
(250, 9, 5, 5, 18),
(251, 9, 5, 6, 21),
(252, 9, 5, 7, 25),
(253, 10, 2, 1, 2),
(254, 10, 2, 2, 5),
(255, 10, 2, 3, 9),
(256, 10, 2, 4, 14),
(257, 10, 2, 5, 17),
(258, 10, 2, 6, 21),
(259, 10, 2, 7, 26),
(260, 10, 3, 1, 1),
(261, 10, 3, 2, 5),
(262, 10, 3, 3, 10),
(263, 10, 3, 4, 13),
(264, 10, 3, 5, 17),
(265, 10, 3, 6, 22),
(266, 10, 3, 7, 25),
(267, 10, 4, 1, 1),
(268, 10, 4, 2, 6),
(269, 10, 4, 3, 9),
(270, 10, 4, 4, 13),
(271, 10, 4, 5, 18),
(272, 10, 4, 6, 21),
(273, 10, 4, 7, 25),
(274, 10, 5, 1, 2),
(275, 10, 5, 2, 5),
(276, 10, 5, 3, 9),
(277, 10, 5, 4, 14),
(278, 10, 5, 5, 17),
(279, 10, 5, 6, 21),
(280, 10, 5, 7, 26),
(281, 11, 1, 1, 2),
(282, 11, 1, 2, 5),
(283, 11, 1, 3, 9),
(284, 11, 1, 4, 14),
(285, 11, 1, 5, 17),
(286, 11, 1, 6, 21),
(287, 11, 1, 7, 26),
(288, 11, 2, 1, 1),
(289, 11, 2, 2, 5),
(290, 11, 2, 3, 10),
(291, 11, 2, 4, 13),
(292, 11, 2, 5, 17),
(293, 11, 2, 6, 22),
(294, 11, 2, 7, 25),
(295, 11, 3, 1, 1),
(296, 11, 3, 2, 6),
(297, 11, 3, 3, 9),
(298, 11, 3, 4, 13),
(299, 11, 3, 5, 18),
(300, 11, 3, 6, 21),
(301, 11, 3, 7, 25),
(302, 11, 4, 1, 2),
(303, 11, 4, 2, 5),
(304, 11, 4, 3, 9),
(305, 11, 4, 4, 14),
(306, 11, 4, 5, 17),
(307, 11, 4, 6, 21),
(308, 11, 4, 7, 26),
(309, 12, 1, 1, 1),
(310, 12, 1, 2, 5),
(311, 12, 1, 3, 10),
(312, 12, 1, 4, 13),
(313, 12, 1, 5, 17),
(314, 12, 1, 6, 22),
(315, 12, 1, 7, 25),
(316, 12, 2, 1, 1),
(317, 12, 2, 2, 6),
(318, 12, 2, 3, 9),
(319, 12, 2, 4, 13),
(320, 12, 2, 5, 18),
(321, 12, 2, 6, 21),
(322, 12, 2, 7, 25),
(323, 12, 3, 1, 2),
(324, 12, 3, 2, 5),
(325, 12, 3, 3, 9),
(326, 12, 3, 4, 14),
(327, 12, 3, 5, 17),
(328, 12, 3, 6, 21),
(329, 12, 3, 7, 26),
(330, 12, 5, 1, 1),
(331, 12, 5, 2, 6),
(332, 12, 5, 3, 9),
(333, 12, 5, 4, 13),
(334, 12, 5, 5, 18),
(335, 12, 5, 6, 21),
(336, 12, 5, 7, 25),
(337, 13, 1, 1, 1),
(338, 13, 1, 2, 6),
(339, 13, 1, 3, 9),
(340, 13, 1, 4, 13),
(341, 13, 1, 5, 18),
(342, 13, 1, 6, 21),
(343, 13, 1, 7, 25),
(344, 13, 2, 1, 2),
(345, 13, 2, 2, 5),
(346, 13, 2, 3, 9),
(347, 13, 2, 4, 14),
(348, 13, 2, 5, 17),
(349, 13, 2, 6, 21),
(350, 13, 2, 7, 26),
(351, 13, 4, 1, 1),
(352, 13, 4, 2, 6),
(353, 13, 4, 3, 9),
(354, 13, 4, 4, 13),
(355, 13, 4, 5, 18),
(356, 13, 4, 6, 21),
(357, 13, 4, 7, 25),
(358, 13, 5, 1, 2),
(359, 13, 5, 2, 5),
(360, 13, 5, 3, 9),
(361, 13, 5, 4, 14),
(362, 13, 5, 5, 17),
(363, 13, 5, 6, 21),
(364, 13, 5, 7, 26),
(365, 14, 1, 1, 2),
(366, 14, 1, 2, 5),
(367, 14, 1, 3, 9),
(368, 14, 1, 4, 14),
(369, 14, 1, 5, 17),
(370, 14, 1, 6, 21),
(371, 14, 1, 7, 26),
(372, 14, 3, 1, 1),
(373, 14, 3, 2, 6),
(374, 14, 3, 3, 9),
(375, 14, 3, 4, 13),
(376, 14, 3, 5, 18),
(377, 14, 3, 6, 21),
(378, 14, 3, 7, 25),
(379, 14, 4, 1, 2),
(380, 14, 4, 2, 5),
(381, 14, 4, 3, 9),
(382, 14, 4, 4, 14),
(383, 14, 4, 5, 17),
(384, 14, 4, 6, 21),
(385, 14, 4, 7, 26),
(386, 14, 5, 1, 1),
(387, 14, 5, 2, 5),
(388, 14, 5, 3, 10),
(389, 14, 5, 4, 13),
(390, 14, 5, 5, 17),
(391, 14, 5, 6, 22),
(392, 14, 5, 7, 25),
(393, 15, 2, 1, 1),
(394, 15, 2, 2, 6),
(395, 15, 2, 3, 9),
(396, 15, 2, 4, 13),
(397, 15, 2, 5, 18),
(398, 15, 2, 6, 21),
(399, 15, 2, 7, 25),
(400, 15, 3, 1, 2),
(401, 15, 3, 2, 5),
(402, 15, 3, 3, 9),
(403, 15, 3, 4, 14),
(404, 15, 3, 5, 17),
(405, 15, 3, 6, 21),
(406, 15, 3, 7, 26),
(407, 15, 4, 1, 1),
(408, 15, 4, 2, 5),
(409, 15, 4, 3, 10),
(410, 15, 4, 4, 13),
(411, 15, 4, 5, 17),
(412, 15, 4, 6, 22),
(413, 15, 4, 7, 25),
(414, 15, 5, 1, 1),
(415, 15, 5, 2, 6),
(416, 15, 5, 3, 9),
(417, 15, 5, 4, 13),
(418, 15, 5, 5, 18),
(419, 15, 5, 6, 21),
(420, 15, 5, 7, 25),
(421, 16, 1, 1, 1),
(422, 16, 1, 2, 6),
(423, 16, 1, 3, 9),
(424, 16, 1, 4, 13),
(425, 16, 1, 5, 18),
(426, 16, 1, 6, 21),
(427, 16, 1, 7, 25),
(428, 16, 2, 1, 2),
(429, 16, 2, 2, 5),
(430, 16, 2, 3, 9),
(431, 16, 2, 4, 14),
(432, 16, 2, 5, 17),
(433, 16, 2, 6, 21),
(434, 16, 2, 7, 26),
(435, 16, 3, 1, 1),
(436, 16, 3, 2, 5),
(437, 16, 3, 3, 10),
(438, 16, 3, 4, 13),
(439, 16, 3, 5, 17),
(440, 16, 3, 6, 22),
(441, 16, 3, 7, 25),
(442, 16, 4, 1, 1),
(443, 16, 4, 2, 6),
(444, 16, 4, 3, 9),
(445, 16, 4, 4, 13),
(446, 16, 4, 5, 18),
(447, 16, 4, 6, 21),
(448, 16, 4, 7, 25),
(449, 17, 1, 1, 2),
(450, 17, 1, 2, 5),
(451, 17, 1, 3, 9),
(452, 17, 1, 4, 14),
(453, 17, 1, 5, 17),
(454, 17, 1, 6, 21),
(455, 17, 1, 7, 26),
(456, 17, 2, 1, 1),
(457, 17, 2, 2, 5),
(458, 17, 2, 3, 10),
(459, 17, 2, 4, 13),
(460, 17, 2, 5, 17),
(461, 17, 2, 6, 22),
(462, 17, 2, 7, 25),
(463, 17, 3, 1, 1),
(464, 17, 3, 2, 6),
(465, 17, 3, 3, 9),
(466, 17, 3, 4, 13),
(467, 17, 3, 5, 18),
(468, 17, 3, 6, 21),
(469, 17, 3, 7, 25),
(470, 17, 5, 1, 1),
(471, 17, 5, 2, 5),
(472, 17, 5, 3, 10),
(473, 17, 5, 4, 13),
(474, 17, 5, 5, 17),
(475, 17, 5, 6, 22),
(476, 17, 5, 7, 25),
(477, 18, 1, 1, 1),
(478, 18, 1, 2, 5),
(479, 18, 1, 3, 10),
(480, 18, 1, 4, 13),
(481, 18, 1, 5, 17),
(482, 18, 1, 6, 22),
(483, 18, 1, 7, 25),
(484, 18, 2, 1, 1),
(485, 18, 2, 2, 6),
(486, 18, 2, 3, 9),
(487, 18, 2, 4, 13),
(488, 18, 2, 5, 18),
(489, 18, 2, 6, 21),
(490, 18, 2, 7, 25),
(491, 18, 4, 1, 1),
(492, 18, 4, 2, 5),
(493, 18, 4, 3, 10),
(494, 18, 4, 4, 13),
(495, 18, 4, 5, 17),
(496, 18, 4, 6, 22),
(497, 18, 4, 7, 25),
(498, 18, 5, 1, 1),
(499, 18, 5, 2, 6),
(500, 18, 5, 3, 9),
(501, 18, 5, 4, 13),
(502, 18, 5, 5, 18),
(503, 18, 5, 6, 21),
(504, 18, 5, 7, 25),
(505, 19, 1, 1, 1),
(506, 19, 1, 2, 6),
(507, 19, 1, 3, 9),
(508, 19, 1, 4, 13),
(509, 19, 1, 5, 18),
(510, 19, 1, 6, 21),
(511, 19, 1, 7, 25),
(512, 19, 3, 1, 1),
(513, 19, 3, 2, 5),
(514, 19, 3, 3, 10),
(515, 19, 3, 4, 13),
(516, 19, 3, 5, 17),
(517, 19, 3, 6, 22),
(518, 19, 3, 7, 25),
(519, 19, 4, 1, 1),
(520, 19, 4, 2, 6),
(521, 19, 4, 3, 9),
(522, 19, 4, 4, 13),
(523, 19, 4, 5, 18),
(524, 19, 4, 6, 21),
(525, 19, 4, 7, 25),
(526, 19, 5, 1, 2),
(527, 19, 5, 2, 5),
(528, 19, 5, 3, 9),
(529, 19, 5, 4, 14),
(530, 19, 5, 5, 17),
(531, 19, 5, 6, 21),
(532, 19, 5, 7, 26),
(533, 20, 2, 1, 1),
(534, 20, 2, 2, 5),
(535, 20, 2, 3, 10),
(536, 20, 2, 4, 13),
(537, 20, 2, 5, 17),
(538, 20, 2, 6, 22),
(539, 20, 2, 7, 25),
(540, 20, 3, 1, 1),
(541, 20, 3, 2, 6),
(542, 20, 3, 3, 9),
(543, 20, 3, 4, 13),
(544, 20, 3, 5, 18),
(545, 20, 3, 6, 21),
(546, 20, 3, 7, 25),
(547, 20, 4, 1, 2),
(548, 20, 4, 2, 5),
(549, 20, 4, 3, 9),
(550, 20, 4, 4, 14),
(551, 20, 4, 5, 17),
(552, 20, 4, 6, 21),
(553, 20, 4, 7, 26),
(554, 20, 5, 1, 1),
(555, 20, 5, 2, 5),
(556, 20, 5, 3, 10),
(557, 20, 5, 4, 13),
(558, 20, 5, 5, 17),
(559, 20, 5, 6, 22),
(560, 20, 5, 7, 25);

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
(1, 'Rahmat Hidayat', 32, 'PNS', '2026-07-24 20:49:55'),
(2, 'Siti Nurhaliza', 28, 'Wiraswasta', '2026-07-24 20:49:55'),
(3, 'Budi Santoso', 45, 'Dosen', '2026-07-24 20:49:55'),
(4, 'Dewi Anggraini', 26, 'Karyawan Swasta', '2026-07-24 20:49:56'),
(5, 'Ahmad Fauzi', 38, 'Guru', '2026-07-24 20:49:56'),
(6, 'Rina Marlina', 30, 'Dokter', '2026-07-24 20:49:56'),
(7, 'Hendra Gunawan', 42, 'Wiraswasta', '2026-07-24 20:49:56'),
(8, 'Yuni Kartika', 24, 'Mahasiswa', '2026-07-24 20:49:57'),
(9, 'Rudi Hartono', 50, 'PNS', '2026-07-24 20:49:57'),
(10, 'Fitri Handayani', 35, 'Ibu Rumah Tangga', '2026-07-24 20:49:57'),
(11, 'Agus Setiawan', 39, 'Arsitek', '2026-07-24 20:49:57'),
(12, 'Maya Putri', 27, 'Karyawan Swasta', '2026-07-24 20:49:58'),
(13, 'Dedi Kurniawan', 44, 'PNS', '2026-07-24 20:49:58'),
(14, 'Nurul Hidayah', 31, 'Bidan', '2026-07-24 20:49:58'),
(15, 'Bambang Wijaya', 48, 'Wiraswasta', '2026-07-24 20:49:58'),
(16, 'Wulan Sari', 29, 'Guru', '2026-07-24 20:49:58'),
(17, 'Joko Prasetyo', 36, 'Apoteker', '2026-07-24 20:49:59'),
(18, 'Ratna Permata', 33, 'PNS', '2026-07-24 20:49:59'),
(19, 'Eko Purnomo', 41, 'Wiraswasta', '2026-07-24 20:49:59'),
(20, 'Indah Lestari', 25, 'Mahasiswa', '2026-07-24 20:49:59');

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
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

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
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT for table `responden`
--
ALTER TABLE `responden`
  MODIFY `id_responden` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
