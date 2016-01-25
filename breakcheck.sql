-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2016 at 03:16 PM
-- Server version: 10.1.10-MariaDB-log
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `breakcheck`
--
CREATE DATABASE IF NOT EXISTS `breakcheck` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `breakcheck`;

-- --------------------------------------------------------

--
-- Table structure for table `pontos`
--

CREATE TABLE `pontos` (
  `p_id` int(11) NOT NULL,
  `p_lat` double NOT NULL,
  `p_lon` double NOT NULL,
  `p_nome` varchar(90) NOT NULL,
  `p_data_cria` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `p_data_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `p_existe` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pontos`
--
ALTER TABLE `pontos`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pontos`
--
ALTER TABLE `pontos`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
