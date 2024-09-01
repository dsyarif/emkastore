-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: Aug 04, 2024 at 08:59 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36776430_emkastore`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_keluar_tb`
--

INSERT INTO `barang_keluar_tb` (`id_barang_keluar`, `kode_barang`, `tanggal_keluar`, `jumlah_keluar`, `keterangan`, `alasan`) VALUES
(5, 'BRG-00001', '2024-06-29', 50, 'Terjual', ''),
(6, 'BRG-00003', '2024-07-18', 3, 'Terjual', 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_tb`
--

CREATE TABLE `barang_masuk_tb` (
  `id_barang_masuk` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_masuk_tb`
--

INSERT INTO `barang_masuk_tb` (`id_barang_masuk`, `kode_barang`, `tanggal_masuk`, `jumlah_masuk`) VALUES
(10, 'BRG-00001', '2024-06-29', 72),
(11, 'BRG-00003', '2024-07-15', 90),
(12, 'BRG-00003', '2024-07-18', 5);

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
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang_tb`
--

INSERT INTO `barang_tb` (`id_barang`, `kode_barang`, `id_supplier`, `id_kategori`, `id_sub_kategori`, `nm_barang`, `stok`, `harga_beli`, `harga_jual`) VALUES
(1, 'BRG-00001', 1, 1, 1, 'Hitam Standart', 72, 45000, 80000),
(2, 'BRG-00002', 2, 2, 2, 'Sarung Printing', 50, 40000, 65000),
(3, 'BRG-00003', 2, 3, 3, 'Kemeja Kantor Dewasa', 90, 30000, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_tb`
--

CREATE TABLE `kategori_tb` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `status_kategori` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_tb`
--

INSERT INTO `kategori_tb` (`id_kategori`, `kategori`, `status_kategori`) VALUES
(1, 'Fashion Pria - Bawahan Pria - ', 'Aktif'),
(2, 'Sarung', 'Aktif'),
(3, 'Kemeja Polos', 'Aktif');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna_tb`
--

INSERT INTO `pengguna_tb` (`id_pengguna`, `username`, `password`, `nama`, `level`) VALUES
(3, 'admin', '$2y$10$opOw4CmicLLODPswBrzAN.0jSx6DuLDC490ngu4D3XcuCvHtSxBdC', 'Admin', 'Admin'),
(4, 'owner', '$2y$10$u9HzlIFqRvptpd3XVg3EIOrAZnZp2OREYh0QEQqP8WAV/Lqkvy4Kq', 'Owner', 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori_tb`
--

CREATE TABLE `sub_kategori_tb` (
  `id_sub_kategori` int(11) NOT NULL,
  `sub_kategori` varchar(30) NOT NULL,
  `status_sub_kategori` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_kategori_tb`
--

INSERT INTO `sub_kategori_tb` (`id_sub_kategori`, `sub_kategori`, `status_sub_kategori`) VALUES
(1, 'Celana Panjang Kantor Slimfit ', 'Aktif'),
(2, 'Sarung Dewasa', 'Aktif'),
(3, 'Kemeja Dewasa', 'Aktif');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_tb`
--

INSERT INTO `supplier_tb` (`id_supplier`, `nama_supplier`, `no_hp`, `alamat`, `status_supplier`) VALUES
(1, 'Hasan', '087749804283', 'Ulujami, Kota Pekalongan', 'Aktif'),
(2, 'Al-Latif Store', '08150021000', 'Kertoharjo', 'Aktif');

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
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `barang_masuk_tb`
--
ALTER TABLE `barang_masuk_tb`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `barang_tb`
--
ALTER TABLE `barang_tb`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_tb`
--
ALTER TABLE `kategori_tb`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengguna_tb`
--
ALTER TABLE `pengguna_tb`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_kategori_tb`
--
ALTER TABLE `sub_kategori_tb`
  MODIFY `id_sub_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_tb`
--
ALTER TABLE `supplier_tb`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
