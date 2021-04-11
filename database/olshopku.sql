-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 07:40 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `olshopku`
--
CREATE DATABASE IF NOT EXISTS `olshopku` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `olshopku`;

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE IF NOT EXISTS `t_admin` (
  `id_admin` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(35) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `fullname` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reset` varchar(35) NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `username`, `fullname`, `password`, `email`, `reset`) VALUES
(1, 'admin', 'Administrator', '$2y$10$ts23gbh44DqKFh/v.92xZOQkrBn2X8bLnjl7M.wZ.tr83chTcEDRG', 'azbeeshop@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_detail_order`
--

CREATE TABLE IF NOT EXISTS `t_detail_order` (
  `id_order` varchar(10) NOT NULL,
  `id_item` int(7) NOT NULL,
  `qty` smallint(4) NOT NULL,
  `biaya` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_detail_order`
--

INSERT INTO `t_detail_order` (`id_order`, `id_item`, `qty`, `biaya`) VALUES
('1557819983', 1, 1, 7000),
('1557820651', 20, 4, 60000),
('1557894172', 3, 2, 24000),
('1557935343', 20, 1, 15000),
('1557935343', 25, 1, 10000),
('1557979918', 3, 1, 12000),
('1557983225', 2, 1, 15000),
('1557983225', 3, 1, 12000),
('1557983225', 5, 1, 10000),
('1557985647', 2, 1, 15000),
('1557985647', 14, 1, 10000),
('1557985647', 17, 1, 10000),
('1557986800', 5, 1, 10000),
('1558237875', 6, 3, 36000),
('1558242159', 16, 1, 12000),
('1558359383', 19, 1, 12000),
('1558407032', 9, 1, 10000),
('1558407032', 1, 1, 7000),
('1558407765', 24, 1, 13000);

--
-- Triggers `t_detail_order`
--
DROP TRIGGER IF EXISTS `penjualan_barang`;
DELIMITER //
CREATE TRIGGER `penjualan_barang` AFTER INSERT ON `t_detail_order`
 FOR EACH ROW BEGIN
	UPDATE t_items i SET i.stok = i.stok - new.qty
    WHERE i.id_item = new.id_item;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `return_barang`;
DELIMITER //
CREATE TRIGGER `return_barang` AFTER DELETE ON `t_detail_order`
 FOR EACH ROW BEGIN
	UPDATE t_items i SET i.stok = i.stok + old.qty
    WHERE i.id_item = old.id_item;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_favorite`
--

CREATE TABLE IF NOT EXISTS `t_favorite` (
  `id_user` int(7) NOT NULL,
  `id_item` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_favorite`
--

INSERT INTO `t_favorite` (`id_user`, `id_item`) VALUES
(1, 3),
(1, 20),
(1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `t_img`
--

CREATE TABLE IF NOT EXISTS `t_img` (
  `id_item` int(7) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_img`
--

INSERT INTO `t_img` (`id_item`, `img`) VALUES
(20, 'img15577636370.jpg'),
(20, 'img15577636371.jpg'),
(20, 'img15577636372.jpg'),
(20, 'img15577636373.jpg'),
(21, 'img15577637470.jpg'),
(21, 'img15577637471.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `t_items`
--

CREATE TABLE IF NOT EXISTS `t_items` (
  `id_item` int(7) NOT NULL AUTO_INCREMENT,
  `link` varchar(10) NOT NULL,
  `nama_item` varchar(255) NOT NULL,
  `harga` int(10) NOT NULL,
  `berat` int(5) NOT NULL,
  `stok` smallint(2) NOT NULL,
  `aktif` tinyint(1) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `t_items`
--

INSERT INTO `t_items` (`id_item`, `link`, `nama_item`, `harga`, `berat`, `stok`, `aktif`, `gambar`, `deskripsi`) VALUES
(1, '1557755374', 'Bolu Kuwuk', 7000, 100, 6, 1, 'gambar1557761553.jpg', 'empuk'),
(2, '1557759646', 'Madumongso', 15000, 300, 29, 1, 'gambar1557761614.jpg', 'matab jiwo'),
(3, '1557761445', 'Brem Lima Rasa', 12000, 200, 21, 1, 'gambar1557761445.jpg', 'anyep'),
(4, '1557761757', 'Wajik Bandung', 10000, 227, 5, 1, 'gambar1557761757.jpg', 'Komposisi: Ketan, Gula Jawa, garam'),
(5, '1557761828', 'Kembang Gula', 10000, 180, 5, 1, 'gambar1557761828.jpg', 'Komposisi : kelapa, gula, aroma'),
(6, '1557761956', 'Jenang rasa durian', 12000, 250, 0, 1, 'gambar1557761956.jpg', 'legit'),
(7, '1557762056', 'Enting Jahe', 15000, 200, 9, 1, 'gambar1557762056.jpg', 'Komposisi: Jahe, gula, wijen'),
(8, '1557762178', 'Sale Pisang', 13000, 200, 17, 1, 'gambar1557762178.jpg', 'Produksi Ucupz Putra'),
(9, '1557762280', 'Uteran', 10000, 300, 9, 1, 'gambar1557762280.jpg', 'Kriuk'),
(10, '1557762381', 'Kacang goreng', 14000, 350, 4, 1, 'gambar1557762381.jpg', 'produksi by muatu rama'),
(11, '1557762442', 'Grubi Telo rambat', 16000, 350, 7, 1, 'gambar1557762442.jpg', 'by Sultan'),
(12, '1557762504', 'Kurma', 20000, 200, 40, 1, 'gambar1557762504.jpg', 'Manis '),
(13, '1557762559', 'Choco crunch', 10000, 200, 10, 1, 'gambar1557762559.jpg', 'renyah'),
(14, '1557762759', 'Kacang mix', 10000, 300, 9, 1, 'gambar1557762759.jpg', 'mix kacang polo, kacang koro'),
(15, '1557762894', 'Sereal Corn', 10000, 250, 10, 1, 'gambar1557762894.jpg', 'renyah '),
(16, '1557763118', 'Kacang Disco', 12000, 400, 14, 1, 'gambar1557763118.jpg', 'kacang disko'),
(17, '1557763222', 'Kacang Polong Tepung', 10000, 400, 9, 1, 'gambar1557763222.jpg', 'kacang polong tepung by Az-Bee'),
(18, '1557763267', 'Kacang Polong', 10000, 400, 10, 1, 'gambar1557763267.jpg', 'Kacang Polong by Az-Bee'),
(19, '1557763472', 'Pangsit Waluh', 12000, 300, 45, 1, 'gambar1557763472.jpg', 'pangsit waluh gurih'),
(20, '1557763637', 'Astor mini', 15000, 500, 66, 1, 'gambar1557763637.jpg', 'tersedia berbagai macam warna'),
(21, '1557763747', 'Astor Mini Belang', 15000, 500, 41, 1, 'gambar1557763747.jpg', 'Tersedia berbagai macam warna'),
(22, '1557763817', 'Semprong panjang', 8000, 200, 6, 1, 'gambar1557763817.jpg', 'semprong'),
(23, '1557764170', 'Semprong segitiga', 9000, 200, 8, 1, 'gambar1557764170.jpg', 'renyah'),
(24, '1557764304', 'Roti Wijen', 13000, 300, 19, 1, 'gambar1557764304.jpg', 'manis'),
(25, '1557764716', 'Keripik Kulit Tahu', 10000, 200, 9, 1, 'gambar1557764716.jpg', 'Keripik kulit tahu by Az-Bee');

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori`
--

CREATE TABLE IF NOT EXISTS `t_kategori` (
  `id_kategori` smallint(6) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(30) NOT NULL,
  `url` varchar(30) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `t_kategori`
--

INSERT INTO `t_kategori` (`id_kategori`, `kategori`, `url`) VALUES
(2, 'Roti', 'roti'),
(3, 'Snack', 'snack'),
(4, 'Keripik', 'keripik'),
(6, 'DLL', 'dll'),
(16, 'Kacang-kacangan', 'kacang-kacangan');

-- --------------------------------------------------------

--
-- Table structure for table `t_order`
--

CREATE TABLE IF NOT EXISTS `t_order` (
  `id_order` varchar(15) NOT NULL,
  `nama_pemesan` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `total` double NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `pos` int(5) NOT NULL,
  `kota` varchar(25) NOT NULL,
  `kurir` varchar(5) NOT NULL,
  `service` varchar(50) NOT NULL,
  `tgl_pesan` date NOT NULL,
  `bts_bayar` date NOT NULL,
  `bukti` varchar(25) NOT NULL,
  `pengiriman` varchar(25) DEFAULT NULL,
  `status_proses` enum('belum','proses','selesai') NOT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_order`
--

INSERT INTO `t_order` (`id_order`, `nama_pemesan`, `email`, `total`, `tujuan`, `pos`, `kota`, `kurir`, `service`, `tgl_pesan`, `bts_bayar`, `bukti`, `pengiriman`, `status_proses`) VALUES
('1557819983', 'ika fw', 'ikafw29@gmail.com', 25000, 'bantul', 66281, 'Bantul', 'jne', 'REG', '2019-05-14', '2019-05-17', 'bukti1557819983.jpg', NULL, 'selesai'),
('1557820651', 'ika fw', 'ikafw29@gmail.com', 76000, 'Madiun', 662581, 'Madiun', 'jne', 'REG', '2019-05-14', '2019-05-17', 'bukti1557820651.jpg', NULL, 'proses'),
('1557894172', 'ika fw', 'ikafw29@gmail.com', 42000, 'sapen', 55221, 'Yogyakarta', 'jne', 'REG', '2019-05-15', '2019-05-18', 'bukti15578941721.jpg', NULL, 'proses'),
('1557935343', 'ika fw', 'ikafw29@gmail.com', 40000, 'sapen', 556281, 'Yogyakarta', 'jne', 'OKE', '2019-05-15', '2019-05-18', 'bukti1557935343.jpg', NULL, 'belum'),
('1557979918', 'ika fw', 'ikafw29@gmail.com', 35000, 'kp', 55321, 'Kulon Progo', 'jne', 'REG', '2019-05-16', '2019-05-19', 'bukti15579799181.png', NULL, 'belum'),
('1557983225', 'ika fw', 'ikafw29@gmail.com', 65000, 'gyyfyf', 76757, 'Lebak', 'pos', 'Paket Kilat Khusus', '2019-05-16', '2019-05-19', 'bukti1557983225.jpg', 'bukti1557984182.jpg', 'proses'),
('1557985647', 'benti puri', 'azbeeshop@gmail.com', 59000, 'badung bali', 66351, 'Badung', 'jne', 'OKE', '2019-05-16', '2019-05-19', 'bukti1557985647.jpg', 'bukti1557986037.jpg', 'selesai'),
('1557986800', 'ika fw', 'ikafw29@gmail.com', 76000, 'bengkalis', 62851, 'Bengkalis', 'jne', 'REG', '2019-05-16', '2019-05-19', 'bukti1557986800.jpg', NULL, 'proses'),
('1558237875', 'ika fw', 'ikafw29@gmail.com', 44000, 'pacitan jawa timur', 66581, 'Pacitan', 'jne', 'REG', '2019-05-19', '2019-05-22', 'bukti1558237875.jpg', 'bukti1558239036.jpg', 'proses'),
('1558242159', 'nia wati', 'niawati@gmail.com', 83000, 'kupang', 66575, 'Kupang', 'jne', 'OKE', '2019-05-19', '2019-05-22', '', NULL, 'belum'),
('1558359383', 'ika fw', 'ikafw29@gmail.com', 33000, 'bandung', 66591, 'Bandung', 'jne', 'OKE', '2019-05-20', '2019-05-23', 'bukti1558359383.jpg', 'bukti1558360017.jpg', 'proses'),
('1558407032', 'ika fw', 'ikafw29@gmail.com', 40000, 'kranggan', 56271, 'Temanggung', 'jne', 'REG', '2019-05-21', '2019-05-24', 'bukti1558407032.jpg', NULL, 'selesai'),
('1558407765', 'ika fw', 'ikafw29@gmail.com', 31000, 'sapen', 55221, 'Yogyakarta', 'jne', 'REG', '2019-05-21', '2019-05-24', '', 'bukti1558407928.jpg', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `t_profil`
--

CREATE TABLE IF NOT EXISTS `t_profil` (
  `id_profil` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `gplus` varchar(255) NOT NULL,
  `email_toko` varchar(50) NOT NULL,
  `pass_toko` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `asal` mediumint(9) NOT NULL,
  `rekening` varchar(15) NOT NULL,
  PRIMARY KEY (`id_profil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `t_profil`
--

INSERT INTO `t_profil` (`id_profil`, `title`, `alamat_toko`, `phone`, `facebook`, `twitter`, `gplus`, `email_toko`, `pass_toko`, `api_key`, `asal`, `rekening`) VALUES
(1, 'Az-Bee', 'Jalan Raya Pacitan-Ponorogo Km. 11', '085731109000', 'https://facebook.com/Az-Bee', 'https://twitter.com/Az-Bee', 'https://googleplus.com/Az-Bee', 'Azbeeshop@gmail.com', 'azbee12345', 'cedd3418f5b538d99a4a0da24e81d712', 305, '9068795445634');

-- --------------------------------------------------------

--
-- Table structure for table `t_rkategori`
--

CREATE TABLE IF NOT EXISTS `t_rkategori` (
  `id_item` int(7) NOT NULL,
  `id_kategori` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_rkategori`
--

INSERT INTO `t_rkategori` (`id_item`, `id_kategori`) VALUES
(9, 11),
(9, 4),
(2, 15),
(2, 6),
(3, 15),
(3, 2),
(4, 15),
(4, 6),
(5, 15),
(5, 6),
(6, 15),
(6, 6),
(7, 15),
(7, 6),
(8, 6),
(8, 15),
(10, 16),
(10, 15),
(11, 6),
(11, 15),
(12, 6),
(12, 15),
(13, 3),
(13, 15),
(14, 15),
(14, 16),
(15, 3),
(15, 15),
(16, 15),
(16, 16),
(17, 15),
(17, 16),
(18, 15),
(18, 16),
(19, 4),
(19, 15),
(20, 3),
(20, 15),
(21, 3),
(21, 15),
(22, 3),
(22, 15),
(23, 3),
(23, 15),
(24, 2),
(24, 15),
(25, 4),
(25, 15),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `id_user` int(7) NOT NULL AUTO_INCREMENT,
  `username` varchar(35) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `reset` varchar(35) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id_user`, `username`, `fullname`, `email`, `password`, `jk`, `telp`, `alamat`, `status`, `reset`) VALUES
(1, 'ikafw', 'ika fw', 'ikafw29@gmail.com', '$2y$10$gxfsawg/a/O8IQzP4tYuseXIT5s3KxC4CCECyl.70NzZga7COivhC', 'P', '082338282219', 'pacitan jawa timur', 1, ''),
(2, 'winda', 'winda vionitha', 'wvionitha@gmail.com', '$2y$10$h2RY1fFkMqyMp.CXjcSG7Ojb7yRxEhAlLI.SXd7c.vsjoa1ZPlnDK', 'P', '082227639983', 'sapen yogyakarta', 1, ''),
(3, 'benti', 'benti puri', 'azbeeshop@gmail.com', '$2y$10$G/awHlq3tsZsMk66ZZJJuueX.n2lU4OpkrP5aLveA/HwGy8Uy/VxW', 'P', '089765231980', 'kota yogyakarta', 1, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
