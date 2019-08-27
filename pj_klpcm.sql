-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2019 at 01:24 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pj_klpcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(3) NOT NULL,
  `nama_dokter` varchar(50) DEFAULT NULL,
  `spesialis` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `spesialis`) VALUES
(1, 'dr. Agung Prasetya Wibowo, Sp.A ', NULL),
(2, 'dr. Agus Suhartono, Sp. Og. K', NULL),
(3, 'dr. Andi Sulistyo H, Sp. PD ', NULL),
(4, 'dr. Arief Usman, Sp. An', NULL),
(5, 'dr. Dewa Gede Chriswidarma', NULL),
(6, 'dr. Dheni Pramudia Haryanto', NULL),
(7, 'dr. Dicky Kurniawan Tontowiputro, Sp. PD', NULL),
(8, 'dr. Endang Budi WachJuni, M.Si', NULL),
(9, 'dr. Gregorio Satrio Pinunggul\r', NULL),
(10, 'dr. Husnul Asariati, Sp. A. Biomed\r', NULL),
(11, 'dr. Imelda, Sp.OG\r', NULL),
(12, 'dr. Laksmi Senja Agusta', NULL),
(13, 'dr. Mochamad Aleq Sander, M. Kes., Sp. B., FINACS', NULL),
(14, 'dr. Nur Huda Satria Kusuma', NULL),
(15, 'dr. Nurul Fauzi, Sp. KK', NULL),
(16, 'dr. Shelly Widiyanti\r', NULL),
(17, 'dr. R.A Siti Juhariyah,Sp.P\r', NULL),
(18, 'dr. Solita Vasya Siregar', NULL),
(19, 'dr. Wildan Aulia Firdaus', NULL),
(20, 'dr. Wisniardhy Suarnata Pradana\r', NULL),
(21, 'drg. Hesti Muharini, Sp. Kg.A', NULL),
(22, 'drg. Wiedianto Suwarsono, Sp. KG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_rawat_inap`
--

CREATE TABLE `form_rawat_inap` (
  `id_inap` int(2) NOT NULL,
  `rawat_inap` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form_rawat_inap`
--

INSERT INTO `form_rawat_inap` (`id_inap`, `rawat_inap`) VALUES
(1, 'FU 17'),
(2, 'FU 21'),
(3, 'FU 35'),
(4, 'RM 01.01'),
(5, 'RM 01.03'),
(6, 'RM 01.05'),
(7, 'RM 01.08'),
(8, 'RM 01.09'),
(9, 'RM 01.10'),
(10, 'RM 01.11'),
(11, 'RM 01.17'),
(12, 'RM 02.02'),
(13, 'RM 04.01'),
(14, 'RM 04.02'),
(15, 'RM 04.03'),
(16, 'RM 04.04'),
(17, 'RM 04.05'),
(18, 'RM 04.06'),
(19, 'RM 05.01'),
(20, 'RM 05.02'),
(21, 'RM 05.03'),
(22, 'RM 05.05'),
(23, 'RM 05.06'),
(24, 'RM 05.07'),
(25, 'RM 05.08'),
(26, 'RM 05.09'),
(27, 'RM 06.01'),
(28, 'RM 06.02'),
(29, 'RM 06.03'),
(30, 'RM 06.04'),
(31, 'RM 06.05'),
(32, 'RM 06.08'),
(33, 'RM 06.10'),
(34, 'RM 06.13'),
(35, 'RM 06.14'),
(36, 'RM 06.15'),
(37, 'RM 06.17'),
(38, 'RM 06.18'),
(39, 'RM 06.20'),
(40, 'RM 06.21'),
(41, 'RM 06.24'),
(42, 'RM 06.26'),
(43, 'RM 07.01'),
(44, 'RM 07.02'),
(45, 'RM 07.03'),
(46, 'RM 10.01'),
(47, 'RM 10.03');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `tanggal_mrs` date DEFAULT NULL,
  `no_rm` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama_pasien`, `tanggal_mrs`, `no_rm`) VALUES
(7, 'NORA LIANA', '2019-01-09', 233),
(8, 'DEDI WANSAH SOLIN', '2019-01-09', 234),
(9, 'ZULMI RAMADHAN', '2019-01-12', 235),
(10, 'LILIS KARLINA', '2019-01-12', 290),
(11, 'JUS MANIAR', '2019-01-15', 291),
(12, 'BIMA', '2019-02-09', 29222);

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `no_rm` int(5) NOT NULL,
  `instalasi_dpjp` int(3) DEFAULT NULL,
  `dokter_1` int(3) DEFAULT NULL,
  `dokter_2` int(3) DEFAULT NULL,
  `id_ruang` int(3) NOT NULL,
  `identitas` varchar(2) DEFAULT NULL,
  `otentifikasi` varchar(2) DEFAULT NULL,
  `lap_penting` varchar(2) DEFAULT NULL,
  `pencatatan` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekam_medis`
--

INSERT INTO `rekam_medis` (`no_rm`, `instalasi_dpjp`, `dokter_1`, `dokter_2`, `id_ruang`, `identitas`, `otentifikasi`, `lap_penting`, `pencatatan`) VALUES
(233, 5, 7, NULL, 6, 'T', 'L', 'L', 'T'),
(234, 18, NULL, NULL, 2, 'L', 'L', 'L', 'T'),
(235, 22, NULL, NULL, 3, 'L', 'L', 'L', 'L'),
(290, 4, 6, 2, 5, 'T', 'T', 'L', 'L'),
(291, 13, NULL, NULL, 2, 'L', 'L', 'T', 'L'),
(29222, 18, NULL, NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id_ruang` int(3) NOT NULL,
  `nama_ruang` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id_ruang`, `nama_ruang`) VALUES
(1, 'IGD'),
(2, 'Teratai'),
(3, 'Tulip'),
(4, 'Anggrek'),
(5, 'HCU'),
(6, 'Perinatologi'),
(7, 'Gizi');

-- --------------------------------------------------------

--
-- Table structure for table `tl_rawat_inap`
--

CREATE TABLE `tl_rawat_inap` (
  `id_rawat_inap` int(2) NOT NULL,
  `no_rm` int(5) NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tl_rawat_inap`
--

INSERT INTO `tl_rawat_inap` (`id_rawat_inap`, `no_rm`, `keterangan`) VALUES
(1, 291, 'lap_penting'),
(5, 291, 'lap_penting'),
(24, 291, 'lap_penting'),
(1, 290, 'identitas'),
(2, 290, 'identitas'),
(30, 290, 'otentifikasi'),
(13, 233, 'identitas'),
(46, 233, 'pencatatan'),
(14, 234, 'pencatatan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `status`) VALUES
(1, 'Rekam Medis', 'rekammed', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1),
(2, 'Perawat', 'perawat', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `form_rawat_inap`
--
ALTER TABLE `form_rawat_inap`
  ADD PRIMARY KEY (`id_inap`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `no_rm` (`no_rm`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`no_rm`),
  ADD KEY `dpjp_dokter` (`instalasi_dpjp`),
  ADD KEY `dokter_1` (`dokter_1`),
  ADD KEY `dokter_2` (`dokter_2`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id_ruang`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_rawat_inap`
--
ALTER TABLE `form_rawat_inap`
  MODIFY `id_inap` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ruang`
--
ALTER TABLE `ruang`
  MODIFY `id_ruang` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_ibfk_1` FOREIGN KEY (`no_rm`) REFERENCES `rekam_medis` (`no_rm`);

--
-- Constraints for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `dokter_1` FOREIGN KEY (`dokter_1`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dokter_2` FOREIGN KEY (`dokter_2`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `dpjp_dokter` FOREIGN KEY (`instalasi_dpjp`) REFERENCES `dokter` (`id_dokter`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
