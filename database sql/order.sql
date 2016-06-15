-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2016 at 07:48 PM
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
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
`id_order` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `loading_date` date NOT NULL,
  `unload_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `tax` enum('0','1','','') NOT NULL,
  `note` varchar(255) DEFAULT '-',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id_order`, `company_name`, `loading_date`, `unload_date`, `location`, `price`, `tax`, `note`, `photo`) VALUES
(1, 'PT Astra International', '2016-06-28', '2016-06-30', 'Sunter', 5000000, '0', '-', '0'),
(2, 'Universitas Bunda Mulia', '2016-06-13', '2016-06-17', 'Lodan Raya', 15000000, '0', '-', NULL),
(3, 'PT Mata Laba Laba', '2020-06-20', '2024-06-20', 'Central Park', 9000000, '0', '-', 'PT Mata Laba Laba -@ SapuLidi, Bandung.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
 ADD PRIMARY KEY (`id_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
