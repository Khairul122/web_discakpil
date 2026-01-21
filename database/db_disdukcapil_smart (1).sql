-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2026 at 06:06 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
  `kode_alternatif` varchar(10) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `keterangan` text,
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
  `id_alternatif_terbaik` int NOT NULL COMMENT 'ID layanan dengan nilai SMART tertinggi',
  `nilai_smart` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'Nilai SMART untuk layanan terbaik',
  `tanggal_perhitungan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_akhir`
--

INSERT INTO `hasil_akhir` (`id_hasil`, `id_responden`, `id_alternatif_terbaik`, `nilai_smart`, `tanggal_perhitungan`) VALUES
(2, 2, 1, '100.0000', '2026-01-21 04:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `pertanyaan` text NOT NULL,
  `bobot` int NOT NULL,
  `jenis` enum('benefit','cost') DEFAULT 'benefit',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode_kriteria`, `nama_kriteria`, `pertanyaan`, `bobot`, `jenis`, `created_at`) VALUES
(1, 'C1', 'Kecepatan Waktu', 'Bagaimana penilaian Anda terhadap kecepatan waktu penyelesaian dokumen dibanding janji layanan?', 30, 'benefit', '2026-01-20 13:33:21'),
(2, 'C2', 'Kesesuaian Syarat', 'Apakah persyaratan pelayanan yang diminta sesuai dengan ketentuan yang dipublikasikan?', 20, 'benefit', '2026-01-20 13:33:21'),
(3, 'C3', 'Kompetensi Petugas', 'Bagaimana kecakapan dan keterampilan petugas dalam melayani kebutuhan Anda?', 20, 'benefit', '2026-01-20 13:33:21'),
(4, 'C4', 'Sarana Prasarana', 'Bagaimana kenyamanan ruang tunggu dan ketersediaan fasilitas pendukung?', 15, 'benefit', '2026-01-20 13:33:21'),
(5, 'C5', 'Respon Pengaduan', 'Bagaimana respon petugas terhadap pertanyaan atau keluhan yang Anda sampaikan?', 15, 'benefit', '2026-01-20 13:33:21');

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
(25, 2, 5, 5, 17);

-- --------------------------------------------------------

--
-- Table structure for table `responden`
--

CREATE TABLE `responden` (
  `id_responden` int NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `usia` int DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `tanggal_isi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responden`
--

INSERT INTO `responden` (`id_responden`, `nama_lengkap`, `usia`, `pekerjaan`, `tanggal_isi`) VALUES
(2, 'BUDI', 20, 'PNS', '2026-01-20 22:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub` int NOT NULL,
  `id_kriteria` int NOT NULL,
  `nama_pilihan` varchar(50) NOT NULL,
  `nilai_utility` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub`, `id_kriteria`, `nama_pilihan`, `nilai_utility`) VALUES
(1, 1, 'Sangat Cepat', 100),
(2, 1, 'Cepat', 75),
(3, 1, 'Cukup', 50),
(4, 1, 'Lambat', 25),
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
(20, 5, 'Tidak Responsif', 25);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','kepala_dinas') DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$TvUkVDZ9eFwF6Fyjha/s/OUh25thVXflceLHtvi4PWs7BN5axRKzS', 'Administrator Sistem', 'admin', '2026-01-20 13:33:21'),
(2, 'kadis', '8b21bea2277220877c793bc0669171db', 'Teddy Antonius', 'kepala_dinas', '2026-01-20 13:33:21');

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
  ADD UNIQUE KEY `idx_responden` (`id_responden`),
  ADD KEY `idx_alternatif_terbaik` (`id_alternatif_terbaik`),
  ADD KEY `idx_nilai_smart` (`nilai_smart` DESC),
  ADD KEY `idx_tanggal` (`tanggal_perhitungan`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

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
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `responden`
--
ALTER TABLE `responden`
  MODIFY `id_responden` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  ADD CONSTRAINT `hasil_akhir_ibfk_2` FOREIGN KEY (`id_alternatif_terbaik`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE;

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
