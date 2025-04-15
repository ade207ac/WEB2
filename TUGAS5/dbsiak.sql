-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 07:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsiak`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `tmp_lahir` varchar(30) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `thn_masuk` int(11) DEFAULT NULL,
  `sks_lulus` int(11) DEFAULT NULL,
  `ipk` double DEFAULT NULL,
  `prodi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `tmp_lahir`, `tgl_lahir`, `email`, `thn_masuk`, `sks_lulus`, `ipk`, `prodi_id`) VALUES
('0220101001', 'Akmal Basan', 'Bogor', '2002-10-05', 'akbas@siswa.nurulfikri.ac.id', 2022, 120, 2.87, 1),
('0220101002', 'Widuri Senja', 'Bandung', '2003-04-28', 'widuri@siswa.nurulfikri.ac.id', 2022, 124, 3.67, 1),
('0220201001', 'Ahmad Nizam', 'Depok', '2003-01-11', 'ahzam@siswa.nurulfikri.ac.id', 2022, 124, 3.18, 2),
('0220201002', 'Sri Andjani', 'Malang', '2002-11-21', 'sriand@siswa.nurulfikri.ac.id', 2022, 126, 3.48, 2);

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `thn_kurikulum` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id`, `kode`, `nama`, `thn_kurikulum`) VALUES
(1, 'PWEB1', 'Pemrograman Web 1', 2023),
(2, 'PWEB2', 'Pemrograman Web 2', 2023),
(3, 'DDP', 'Dasar-Dasar Pemrograman', 2023),
(4, 'UIUX', 'UI/UX', 2023),
(5, 'BDAT', 'Basis Data', 2023),
(6, 'KSI', 'Kemanan Sistem Informasi', 2023);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_mahasiswa`
--

CREATE TABLE `nilai_mahasiswa` (
  `id` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `nilai_uts` double DEFAULT NULL,
  `nilai_uas` double DEFAULT NULL,
  `nilai_tugas` double DEFAULT NULL,
  `nilai_akhir` double DEFAULT NULL,
  `grade` char(2) DEFAULT NULL,
  `nim` varchar(10) NOT NULL,
  `matakuliah_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nilai_mahasiswa`
--

INSERT INTO `nilai_mahasiswa` (`id`, `semester`, `nilai_uts`, `nilai_uas`, `nilai_tugas`, `nilai_akhir`, `grade`, `nim`, `matakuliah_id`) VALUES
(1, 1, 84, 79, 80, 80.7, 'A-', '0220201001', 1),
(2, 1, 80, 90, 75, 80.75, 'A-', '0220201002', 1),
(3, 1, 78, 85, 85, 83.25, 'A-', '0220101002', 1),
(4, 1, 78, 77, 78, 77.69999999999999, 'B+', '0220101001', 1),
(5, 1, 84, 90, 85, 86.25, 'A', '0220201001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `kode` varchar(2) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `kaprodi` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `kode`, `nama`, `kaprodi`) VALUES
(1, 'SI', 'Sistem Informasi', 'Misna Azqia M.Kom'),
(2, 'TI', 'Teknik Informatika', 'Tifany Nabarian S.Kom, M.TI'),
(3, 'BD', 'Bisnis Digital', 'Dr. Amalia Rahmah S.T,M.T');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `prodi_id` (`prodi_id`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `matakuliah_id` (`matakuliah_id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`);

--
-- Constraints for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD CONSTRAINT `nilai_mahasiswa_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `nilai_mahasiswa_ibfk_2` FOREIGN KEY (`matakuliah_id`) REFERENCES `matakuliah` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
