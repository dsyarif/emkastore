-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 04:14 PM
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
-- Database: `emkastore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_tb`
--

CREATE TABLE `barang_keluar_tb` (
  `id_barang_keluar` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `keterangan` enum('Barang Rusak','Terjual') NOT NULL,
  `alasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_tb`
--

CREATE TABLE `barang_masuk_tb` (
  `id_barang_masuk` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang_tb`
--

CREATE TABLE `barang_tb` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(12) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_sub_kategori` int(11) NOT NULL,
  `nm_barang` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_tb`
--

CREATE TABLE `kategori_tb` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `status_kategori` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_tb`
--

CREATE TABLE `pengguna_tb` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna_tb`
--

INSERT INTO `pengguna_tb` (`id_pengguna`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', '$2y$10$opOw4CmicLLODPswBrzAN.0jSx6DuLDC490ngu4D3XcuCvHtSxBdC', 'Admin', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori_tb`
--

CREATE TABLE `sub_kategori_tb` (
  `id_sub_kategori` int(11) NOT NULL,
  `sub_kategori` varchar(30) NOT NULL,
  `status_sub_kategori` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_tb`
--

CREATE TABLE `supplier_tb` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_hp` text NOT NULL,
  `alamat` text NOT NULL,
  `status_supplier` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_keluar_tb`
--
ALTER TABLE `barang_keluar_tb`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indexes for table `barang_masuk_tb`
--
ALTER TABLE `barang_masuk_tb`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indexes for table `barang_tb`
--
ALTER TABLE `barang_tb`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `kategori_tb`
--
ALTER TABLE `kategori_tb`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pengguna_tb`
--
ALTER TABLE `pengguna_tb`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `sub_kategori_tb`
--
ALTER TABLE `sub_kategori_tb`
  ADD PRIMARY KEY (`id_sub_kategori`);

--
-- Indexes for table `supplier_tb`
--
ALTER TABLE `supplier_tb`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar_tb`
--
ALTER TABLE `barang_keluar_tb`
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_masuk_tb`
--
ALTER TABLE `barang_masuk_tb`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_tb`
--
ALTER TABLE `barang_tb`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_tb`
--
ALTER TABLE `kategori_tb`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna_tb`
--
ALTER TABLE `pengguna_tb`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_kategori_tb`
--
ALTER TABLE `sub_kategori_tb`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_tb`
--
ALTER TABLE `supplier_tb`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
