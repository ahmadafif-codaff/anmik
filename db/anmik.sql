-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 12:51 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anmik`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `browser` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `so` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `message` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_at` datetime NOT NULL DEFAULT current_timestamp(),
  `session` bigint(20) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `os` varchar(2000) NOT NULL,
  `username` varchar(100) NOT NULL,
  `token` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori` varchar(11) NOT NULL,
  `max_upload` varchar(11) NOT NULL,
  `max_download` varchar(11) NOT NULL,
  `bandwidth_kedua` varchar(11) NOT NULL,
  `bandwidth_ketiga` varchar(11) NOT NULL,
  `kuota` varchar(11) NOT NULL,
  `kuota_kedua` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `nama`, `harga`, `kategori`, `max_upload`, `max_download`, `bandwidth_kedua`, `bandwidth_ketiga`, `kuota`, `kuota_kedua`) VALUES
(106, 'Test Kuota', 100000, 'Kuota', '10', '10', '', '', '100', ''),
(107, 'Test Regular', 100000, 'Regular', '5', '5', '0.6', '0.3', '100', '1.5'),
(108, 'Test Premium', 100000, 'Premium', '3', '3', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id_schedule` int(11) NOT NULL,
  `type` varchar(11) NOT NULL,
  `frequency` varchar(11) NOT NULL,
  `time` varchar(100) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id_schedule`, `type`, `frequency`, `time`, `status`) VALUES
(8, 'reboot', 'Day', '01 00:01:00', 'false'),
(9, 'reboot', 'Hour', '00:01:00', 'false'),
(13, 'reboot', 'Day', '09 00:01:00', 'false'),
(14, 'reboot', 'Day', '16 00:01:00', 'false'),
(15, 'reboot', 'Day', '24 00:01:00', 'false'),
(16, 'input', 'Minute', '20', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `usages`
--

CREATE TABLE `usages` (
  `id_usages` int(15) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `upload` bigint(15) NOT NULL,
  `download` bigint(15) NOT NULL,
  `id_client` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` bigint(15) NOT NULL,
  `password` varchar(500) NOT NULL,
  `api_key` int(11) NOT NULL,
  `secret` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `telepon`, `password`, `api_key`, `secret`) VALUES
(1, 'Codaff Project', 'anmik', 'codaffproject@gmail.com', 0, '$2y$10$/n5UIzMAoRPH2qYReDqJ2eNRIAbBhxS6I5JvNvtErGZx/MYxekxt2', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id_schedule`);

--
-- Indexes for table `usages`
--
ALTER TABLE `usages`
  ADD PRIMARY KEY (`id_usages`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=891;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id_schedule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `usages`
--
ALTER TABLE `usages`
  MODIFY `id_usages` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370518;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
