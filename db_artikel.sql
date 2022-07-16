-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 16, 2022 at 03:49 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_artikel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(3) UNSIGNED NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_artikel`
--

CREATE TABLE `tb_artikel` (
  `id` int(3) UNSIGNED NOT NULL,
  `judul_artikel` varchar(50) DEFAULT NULL,
  `isi_artikel` text,
  `id_penulis` int(3) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_artikel`
--

INSERT INTO `tb_artikel` (`id`, `judul_artikel`, `isi_artikel`, `id_penulis`, `tanggal`) VALUES
(1, 'testing artikel', 'loremloremloremloremlorem', 1, '2022-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail`
--

CREATE TABLE `tb_detail` (
  `id` int(3) UNSIGNED NOT NULL,
  `id_artikel` int(3) DEFAULT NULL,
  `id_komentar` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_detail`
--

INSERT INTO `tb_detail` (`id`, `id_artikel`, `id_komentar`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_komentar`
--

CREATE TABLE `tb_komentar` (
  `id` int(3) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `isi_komentar` text,
  `email` varchar(30) DEFAULT NULL,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_komentar`
--

INSERT INTO `tb_komentar` (`id`, `nama`, `isi_komentar`, `email`, `waktu`) VALUES
(1, 'andre', 'testing komen', 'andre@gmail.com', '2022-07-16 10:41:50'),
(2, 'andre', 'testing komen', 'andre@gmail.com', '2022-07-16 10:41:50');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penulis`
--

CREATE TABLE `tb_penulis` (
  `id_penulis` int(3) UNSIGNED NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `biografi` text,
  `id_user` varchar(64) DEFAULT NULL,
  `status_penulis` enum('Active','Non-Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_penulis`
--

INSERT INTO `tb_penulis` (`id_penulis`, `nama`, `biografi`, `id_user`, `status_penulis`) VALUES
(1, 'andrean', 'biografi', 'Jrp9THNcWrFtRzDf4QeGD7jQgrcyRcjJZC7ZdQJlQsC235wEaXnGuJEBFouqdBU1', 'Non-Active'),
(2, 'penulis', NULL, 'Gl1YOh2zsJ8Y3gZoEcfqc3uFEuFFpuLEt0STIXxc3vGx7kS0Pip82z1NQvsUt3o6', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('PENULIS','ADMIN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENULIS',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `deleted_at`, `remember_token`, `created_at`, `updated_at`, `email`) VALUES
('247294783927489234', 'admin', '$2y$10$6t46voq8PEPRcYfeYPekieyY9kDEyLJFbqTlBmPhm3OucTXZ1pbze', 'Andrean Three', 'ADMIN', NULL, NULL, '2021-11-20 01:42:03', '2021-11-20 01:42:03', 'admin@admin.com'),
('Gl1YOh2zsJ8Y3gZoEcfqc3uFEuFFpuLEt0STIXxc3vGx7kS0Pip82z1NQvsUt3o6', 'penulis', '$2y$10$AKss/PEsRotN4EyU/VLlQ.RSPV/lD5Y0Cmpf1jdKwl4Y7kbO63bIW', 'penulis', 'PENULIS', NULL, NULL, '2022-07-16 03:48:28', '2022-07-16 03:48:28', 'penulis@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_artikel`
--
ALTER TABLE `tb_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_detail`
--
ALTER TABLE `tb_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_komentar`
--
ALTER TABLE `tb_komentar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_penulis`
--
ALTER TABLE `tb_penulis`
  ADD PRIMARY KEY (`id_penulis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_username_email_unique` (`username`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_artikel`
--
ALTER TABLE `tb_artikel`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_detail`
--
ALTER TABLE `tb_detail`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_komentar`
--
ALTER TABLE `tb_komentar`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_penulis`
--
ALTER TABLE `tb_penulis`
  MODIFY `id_penulis` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
