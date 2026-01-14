-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2026 at 06:29 AM
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
-- Database: `proyek_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `harga` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `kategori`, `satuan`, `stok`, `harga`) VALUES
(1, 'Semen', 'Material', 'Sak', 503, 75000.00),
(2, 'Besi Beton', 'Material', 'Batang', 216, 120000.00),
(3, 'Pasir', 'Material', 'M3', 55, 350000.00),
(4, 'Cat Tembok', 'Material', 'Kaleng', 107, 150000.00),
(5, 'Paku', 'Material', 'Kg', 33, 50000.00),
(6, 'Palu', 'Alat', 'Unit', 20, 120000.00),
(7, 'Scaffold', 'Alat', 'Unit', 10, 2500000.00),
(8, 'Kayu Balok', 'Material', 'Batang', 150, 200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_proyek` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_tahap` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_keluar`, `id_barang`, `id_proyek`, `jumlah`, `tanggal`, `id_tahap`) VALUES
(6, 1, 1, 2, '2026-01-10', 1),
(7, 3, 1, 10, '2026-01-10', 1),
(8, 5, 2, 5, '2026-01-11', 2),
(9, 4, 2, 3, '2026-01-11', 3),
(10, 2, 1, 4, '2026-01-12', 2);

--
-- Triggers `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `trg_barang_keluar` AFTER INSERT ON `barang_keluar` FOR EACH ROW BEGIN
    UPDATE barang
    SET stok = stok - NEW.jumlah
    WHERE id_barang = NEW.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_proyek` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_masuk`, `id_barang`, `id_supplier`, `jumlah`, `tanggal`, `id_proyek`) VALUES
(1, 1, 1, 5, '2026-01-05', 1),
(2, 2, 2, 20, '2026-01-06', 1),
(3, 3, 1, 15, '2026-01-07', 1),
(4, 4, 3, 10, '2026-01-08', 1),
(5, 5, 3, 8, '2026-01-09', 1);

--
-- Triggers `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `trg_barang_masuk` AFTER INSERT ON `barang_masuk` FOR EACH ROW BEGIN
    UPDATE barang
    SET stok = stok + NEW.jumlah
    WHERE id_barang = NEW.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_proyek`
--

CREATE TABLE `kebutuhan_proyek` (
  `id_kebutuhan` int(11) NOT NULL,
  `id_proyek` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_tahap` int(11) NOT NULL,
  `jumlah_kebutuhan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kebutuhan_proyek`
--

INSERT INTO `kebutuhan_proyek` (`id_kebutuhan`, `id_proyek`, `id_barang`, `id_tahap`, `jumlah_kebutuhan`) VALUES
(1, 1, 1, 2, 1000),
(2, 1, 2, 3, 500),
(3, 1, 3, 2, 200);

-- --------------------------------------------------------

--
-- Table structure for table `proyek`
--

CREATE TABLE `proyek` (
  `id_proyek` int(11) NOT NULL,
  `nama_proyek` varchar(100) NOT NULL,
  `jenis_proyek` enum('Perumahan','Gedung','Jalan','Renovasi') NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('Perencanaan','Berjalan','Selesai') DEFAULT 'Perencanaan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proyek`
--

INSERT INTO `proyek` (`id_proyek`, `nama_proyek`, `jenis_proyek`, `lokasi`, `tanggal_mulai`, `tanggal_selesai`, `status`) VALUES
(1, 'Perumahan A', 'Perumahan', 'Jakarta', '2026-01-01', '2026-06-30', 'Berjalan'),
(2, 'Gedung B', 'Gedung', 'Bandung', '2026-02-01', '2026-12-31', 'Berjalan'),
(3, 'Perumahan C', 'Perumahan', 'Surabaya', '2026-03-15', '2026-09-30', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `kontak`, `alamat`) VALUES
(1, 'PT. Bangun Jaya', '081234567890', 'Jl. Raya No.10, Jakarta'),
(2, 'CV. Mandiri Abadi', '082345678901', 'Jl. Industri No.5, Bandung'),
(3, 'UD. Sumber Makmur', '083456789012', 'Jl. Pembangunan No.3, Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `tahap_proyek`
--

CREATE TABLE `tahap_proyek` (
  `id_tahap` int(11) NOT NULL,
  `nama_tahap` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahap_proyek`
--

INSERT INTO `tahap_proyek` (`id_tahap`, `nama_tahap`) VALUES
(1, 'PREPARATIONS'),
(2, 'FOUNDATION'),
(3, 'STRUCTURE'),
(4, 'FINISHING');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Administrator', 'admin', '$2y$10$.SCepyR4PN7yxMnb/fuTBuGMHKT/pqTqdfN8jHVLNH6xTWRqN7kuO', 'admin'),
(2, 'Azriel', 'azriel', '$2y$10$YpR9Hc9o8H7hXKzN8y6q4uZ2HqgZrVx2W9KQ8u8Gm3Pq8E1v4lC5m', 'admin'),
(3, 'Azl', 'azl', '$2y$10$uJHFYT/2syrWHFNUPxmINOh/LPE2IjfmNMsdpBJMyeLeCVVSsK6ZO', 'user');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_stok_barang`
-- (See below for the actual view)
--
CREATE TABLE `view_stok_barang` (
`id_barang` int(11)
,`nama_barang` varchar(100)
,`kategori` varchar(50)
,`satuan` varchar(20)
,`stok` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `view_stok_barang`
--
DROP TABLE IF EXISTS `view_stok_barang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_stok_barang`  AS SELECT `b`.`id_barang` AS `id_barang`, `b`.`nama_barang` AS `nama_barang`, `b`.`kategori` AS `kategori`, `b`.`satuan` AS `satuan`, `b`.`stok` AS `stok` FROM `barang` AS `b` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `fk_barangkeluar_tahap` (`id_tahap`),
  ADD KEY `fk_barangkeluar_proyek` (`id_proyek`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_proyek` (`id_proyek`);

--
-- Indexes for table `kebutuhan_proyek`
--
ALTER TABLE `kebutuhan_proyek`
  ADD PRIMARY KEY (`id_kebutuhan`),
  ADD KEY `id_proyek` (`id_proyek`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_tahap` (`id_tahap`);

--
-- Indexes for table `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id_proyek`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tahap_proyek`
--
ALTER TABLE `tahap_proyek`
  ADD PRIMARY KEY (`id_tahap`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kebutuhan_proyek`
--
ALTER TABLE `kebutuhan_proyek`
  MODIFY `id_kebutuhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `proyek`
--
ALTER TABLE `proyek`
  MODIFY `id_proyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tahap_proyek`
--
ALTER TABLE `tahap_proyek`
  MODIFY `id_tahap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_keluar_ibfk_2` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barangkeluar_proyek` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`),
  ADD CONSTRAINT `fk_barangkeluar_tahap` FOREIGN KEY (`id_tahap`) REFERENCES `tahap_proyek` (`id_tahap`);

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_3` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`);

--
-- Constraints for table `kebutuhan_proyek`
--
ALTER TABLE `kebutuhan_proyek`
  ADD CONSTRAINT `kebutuhan_proyek_ibfk_1` FOREIGN KEY (`id_proyek`) REFERENCES `proyek` (`id_proyek`),
  ADD CONSTRAINT `kebutuhan_proyek_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `kebutuhan_proyek_ibfk_3` FOREIGN KEY (`id_tahap`) REFERENCES `tahap_proyek` (`id_tahap`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
