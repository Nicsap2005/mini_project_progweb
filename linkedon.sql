-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 03:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkedon`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `_email` varchar(50) DEFAULT NULL,
  `_password` varchar(50) DEFAULT NULL,
  `_namadepan` varchar(50) DEFAULT NULL,
  `_namabelakang` varchar(50) DEFAULT NULL,
  `_tanggallahir` varchar(50) DEFAULT NULL,
  `_alamat` varchar(50) DEFAULT NULL,
  `_pictpath` varchar(50) DEFAULT NULL,
  `_user_type` enum('company','client') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`_email`, `_password`, `_namadepan`, `_namabelakang`, `_tanggallahir`, `_alamat`, `_pictpath`, `_user_type`) VALUES
('k@gmail.com', '123', 'nicsap', '.', '0123-03-12', '1231', 'images//1740260298.jpg', 'client'),
('k@gmail.com', '123', 'nicsap', '.', '0123-03-12', '1231', 'images//1740260298.jpg', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `_email` varchar(50) DEFAULT NULL,
  `_password` varchar(50) DEFAULT NULL,
  `_namaPerusahaan` varchar(50) DEFAULT NULL,
  `_tanggalBerdiri` varchar(50) DEFAULT NULL,
  `_alamat` varchar(50) DEFAULT NULL,
  `_pictpath` varchar(50) DEFAULT NULL,
  `_user_type` enum('Company','Employee') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`_email`, `_password`, `_namaPerusahaan`, `_tanggalBerdiri`, `_alamat`, `_pictpath`, `_user_type`) VALUES
('p@gmail.com', '123', 'pp', '0222-02-22', '123', 'images//1740161229.png', 'Company');

-- --------------------------------------------------------

--
-- Table structure for table `current_client`
--

CREATE TABLE `current_client` (
  `_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `current_company`
--

CREATE TABLE `current_company` (
  `_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current_company`
--

INSERT INTO `current_company` (`_email`) VALUES
('p@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

CREATE TABLE `cv` (
  `_nama` varchar(50) DEFAULT NULL,
  `_alamat` varchar(100) DEFAULT NULL,
  `_noTelp` varchar(15) DEFAULT NULL,
  `_tanggalLahir` varchar(15) DEFAULT NULL,
  `_email` varchar(50) DEFAULT NULL,
  `_gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `_cv` varchar(100) DEFAULT NULL,
  `_namaPerusahaan` varchar(50) DEFAULT NULL,
  `_job` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv`
--

INSERT INTO `cv` (`_nama`, `_alamat`, `_noTelp`, `_tanggalLahir`, `_email`, `_gender`, `_cv`, `_namaPerusahaan`, `_job`) VALUES
('Christian nicholas saputra', 'jl sultan agun 10c', '088226843164', '2005-09-22', 'christian.nicholas@ti.ukdw.ac.id', 'Laki-laki', '', 'PT.  Pencari Cinta Sejati', 'Software Engineer'),
('nicsap .', '123', '123', '0312-03-12', 'k@gmail.com', 'Laki-laki', 'pdf/1740313104.pdf', 'pp', 'Network Engineer');

-- --------------------------------------------------------

--
-- Table structure for table `detaillowongan`
--

CREATE TABLE `detaillowongan` (
  `_namaPerusahaan` varchar(50) DEFAULT NULL,
  `_job` varchar(50) DEFAULT NULL,
  `_edit` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loker`
--

CREATE TABLE `loker` (
  `_deskripsi` varchar(500) DEFAULT NULL,
  `_kualifikasi` varchar(500) DEFAULT NULL,
  `_namaPerusahaan` varchar(50) DEFAULT NULL,
  `_gaji` int(11) DEFAULT NULL,
  `_gajiPer` varchar(50) DEFAULT NULL,
  `_pictpath` varchar(50) DEFAULT NULL,
  `_deadline` varchar(50) DEFAULT NULL,
  `_alamat` varchar(100) DEFAULT NULL,
  `_tipe` enum('Full Time','Part Time') DEFAULT NULL,
  `_remote` tinyint(1) DEFAULT NULL,
  `_job` varchar(100) DEFAULT NULL,
  `_keuntungan` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loker`
--

INSERT INTO `loker` (`_deskripsi`, `_kualifikasi`, `_namaPerusahaan`, `_gaji`, `_gajiPer`, `_pictpath`, `_deadline`, `_alamat`, `_tipe`, `_remote`, `_job`, `_keuntungan`) VALUES
('Mengembangkan dan memelihara aplikasi web. Bekerja sama dengan tim untuk merancang solusi teknologi. Menganalisis dan memperbaiki bug dalam sistem.', 'Pendidikan minimal S1 Teknik Informatika atau setara. Pengalaman minimal 2 tahun dalam pengembangan perangkat lunak. Menguasai HTML, CSS, JavaScript, dan framework terkait.', 'PT.  Pencari Cinta Sejati', 8000000, 'bulan', '../Images/2842680.jpg', '28 Februari 2025', 'Jakarta, Indonesia', 'Full Time', 1, 'Software Engineer', 'Asuransi kesehatan, tunjangan makan, dan bonus tahunan.'),
('12', '1', 'pp', 1, 'Hari', '../Images/1740490426.png', '0001-01-01', '1', 'Full Time', 0, '1', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
