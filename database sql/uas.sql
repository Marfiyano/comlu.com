-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23 Jun 2016 pada 19.14
-- Versi Server: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_priv`
--

CREATE TABLE `group_priv` (
  `group_priv_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `access_priv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `group_priv`
--

INSERT INTO `group_priv` (`group_priv_id`, `group_id`, `module_id`, `access_priv`) VALUES
(1, 1, 6, 'lihat,tambah,update,hapus'),
(2, 2, 6, 'lihat,hapus'),
(3, 3, 6, 'lihat'),
(4, 4, 6, 'lihat, update');

-- --------------------------------------------------------

--
-- Struktur dari tabel `group_user`
--

CREATE TABLE `group_user` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `status` enum('A','N','D') NOT NULL DEFAULT 'A' COMMENT 'A=Active, N=Non-Active, D=Deleted',
  `protected` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=bisa hapus dari aplikasi, 1=tidak bisa hapus dari aplikasi'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `group_user`
--

INSERT INTO `group_user` (`group_id`, `group_name`, `status`, `protected`) VALUES
(1, 'admin', 'A', '1'),
(2, 'Direktur', 'A', '0'),
(3, 'Marketing', 'A', '0'),
(4, 'TAF', 'A', '0'),
(5, 'Orang Lapangan', 'A', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `access_rule` varchar(255) NOT NULL COMMENT 'jenis akses tiap modul',
  `menu` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=tampil, 0=tidak tampil'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `order`, `url`, `description`, `access_rule`, `menu`) VALUES
(1, 'Admin', 1, '-', 'sementara belum ada', 'misal: lihat, tambah, update, hapus', '0'),
(2, 'Home', 2, '/site/index', 'Home', 'lihat', '1'),
(5, 'Login', 6, '/site/login', '', 'lihat', '1'),
(6, 'Jadwal', 5, '/jadwal', 'Jadwal Pameran', 'lihat, tambah, update, hapus', '1'),
(7, 'Report', 4, '/site/report', 'laporan dalam grafik', 'lihat aj', '1'),
(8, 'About Us', 3, '/site/about', 'about company', 'lihat aj', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) UNSIGNED NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `group_id`, `username`, `auth_key`, `password`, `password_reset_token`, `email`, `status`) VALUES
(1, 1, 'marfiyano', 'MhvQgulQ3QDBtUotp-c8SNu7Jp42UXAQ', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'admin123456@hotmail.com', 1),
(2, 2, 'nico', '', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'pass123456@email.com', 1),
(3, 2, 'drtr01', '', 'drtr01', NULL, 'tinggaldiganti1@kubikal.com', 1),
(4, 1, 'mkt01', '', 'mkt01', NULL, 'mkt01@kubikal.com', 1),
(5, 3, 'taf01', '', 'taf01', NULL, 'taf01@kubikal.com', 1),
(6, 4, 'orlap01', '', 'orlap01', NULL, 'orlap01@kubikal.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_priv`
--
ALTER TABLE `group_priv`
  ADD PRIMARY KEY (`group_priv_id`);

--
-- Indexes for table `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_priv`
--
ALTER TABLE `group_priv`
  MODIFY `group_priv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `group_user`
--
ALTER TABLE `group_user`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
