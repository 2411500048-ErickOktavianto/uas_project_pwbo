-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2025 at 07:02 AM
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
-- Database: `jual_proxy`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_pesan`
--

CREATE TABLE `daftar_pesan` (
  `id_pesan` int NOT NULL,
  `waktu` varchar(50) NOT NULL,
  `nama_pembeli` varchar(64) NOT NULL,
  `server` int NOT NULL,
  `team` int DEFAULT NULL,
  `status_pesan` varchar(25) NOT NULL,
  `harga` bigint NOT NULL,
  `satuan` varchar(8) NOT NULL,
  `create_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `daftar_pesan`
--

INSERT INTO `daftar_pesan` (`id_pesan`, `waktu`, `nama_pembeli`, `server`, `team`, `status_pesan`, `harga`, `satuan`, `create_at`) VALUES
(14, '15.00 - 18.00', 'Daffa', 1, 1, 'Done', 30, 'DL', '2025-12-12 23:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id_hutang` int NOT NULL,
  `nama_orang` varchar(64) NOT NULL,
  `total_hutang` int NOT NULL,
  `status_hutang` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL,
  `satuan` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`id_hutang`, `nama_orang`, `total_hutang`, `status_hutang`, `create_at`, `satuan`) VALUES
(1, 'Rio kanncil', 100, 'Lunas', '0000-00-00 00:00:00', 'DL'),
(4, 'burung jg', 590, 'Lunas', '0000-00-00 00:00:00', 'IDR'),
(5, 'orang', 50, 'Belum Lunas', '0000-00-00 00:00:00', 'DL'),
(6, 'adad', 20, 'Lunas', '2025-12-12 22:37:01', 'DL');

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

CREATE TABLE `server` (
  `id_server` int NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `expired` date NOT NULL,
  `status` varchar(25) NOT NULL,
  `create_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `server`
--

INSERT INTO `server` (`id_server`, `ip_address`, `expired`, `status`, `create_at`) VALUES
(1, '38.240.49.234', '2025-12-10', 'Available', '2025-12-03 23:40:46'),
(3, '38.240.49.181', '2025-12-28', 'Available', '2025-12-03 23:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id_team` int NOT NULL,
  `nama_team` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id_team`, `nama_team`) VALUES
(1, 'Octa'),
(3, 'VIT');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `password`, `email`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_pesan`
--
ALTER TABLE `daftar_pesan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `server_ip` (`server`),
  ADD KEY `server_team` (`team`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id_hutang`);

--
-- Indexes for table `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id_server`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id_team`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_pesan`
--
ALTER TABLE `daftar_pesan`
  MODIFY `id_pesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id_hutang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `server`
--
ALTER TABLE `server`
  MODIFY `id_server` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id_team` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_pesan`
--
ALTER TABLE `daftar_pesan`
  ADD CONSTRAINT `server_ip` FOREIGN KEY (`server`) REFERENCES `server` (`id_server`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `server_team` FOREIGN KEY (`team`) REFERENCES `team` (`id_team`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
