-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2016 at 06:41 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_priv`
--

CREATE TABLE IF NOT EXISTS `group_priv` (
`group_priv_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `access_priv` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `group_priv`
--

INSERT INTO `group_priv` (`group_priv_id`, `group_id`, `module_id`, `access_priv`) VALUES
(1, 1, 6, 'lihat,tambah,update,hapus'),
(2, 2, 6, 'lihat,hapus');

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE IF NOT EXISTS `group_user` (
`group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `status` enum('A','N','D') NOT NULL DEFAULT 'A' COMMENT 'A=Active, N=Non-Active, D=Deleted',
  `protected` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=bisa hapus dari aplikasi, 1=tidak bisa hapus dari aplikasi'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`group_id`, `group_name`, `status`, `protected`) VALUES
(1, 'admin', 'A', '1'),
(2, 'direktur', 'A', '0'),
(3, 'marketing', 'A', '0'),
(4, 'TAF', 'A', '0'),
(5, 'Orang Lapangan', 'A', '0');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
`module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `access_rule` varchar(255) NOT NULL COMMENT 'jenis akses tiap modul',
  `menu` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=tampil, 0=tidak tampil'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `order`, `url`, `description`, `access_rule`, `menu`) VALUES
(1, 'Admin', 1, '-', 'sementara belum ada', 'misal: lihat, tambah, update, hapus', '0'),
(2, 'Home', 2, '/site/index', 'Home', 'lihat', '1'),
(5, 'Login', 6, '/site/login', '', 'lihat', '1'),
(6, 'Jadwal', 5, '/jadwal', 'Jadwal Pameran', 'lihat, tambah, update, hapus', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Deleted'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `group_id`, `username`, `auth_key`, `password`, `password_reset_token`, `email`, `status`) VALUES
(1, 1, 'marfiyano', 'MhvQgulQ3QDBtUotp-c8SNu7Jp42UXAQ', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'admin123456@hotmail.com', 1),
(2, 2, 'nico', '', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'pass123456@email.com', 1);

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
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_priv`
--
ALTER TABLE `group_priv`
MODIFY `group_priv_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `group_user`
--
ALTER TABLE `group_user`
MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
