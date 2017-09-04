-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2017 at 05:53 PM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.1.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dime_ark_spatial`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_spatial_fragment`
--

CREATE TABLE `ark_spatial_fragment` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geometry` geometry NOT NULL,
  `srid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `ark_spatial_term`
--

CREATE TABLE `ark_spatial_term` (
  `fid` int(11) NOT NULL,
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geometry` geometry NOT NULL,
  `srid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_spatial_fragment`
--
ALTER TABLE `ark_spatial_fragment`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD SPATIAL KEY `geometry` (`geometry`);

--
-- Indexes for table `ark_spatial_term`
--
ALTER TABLE `ark_spatial_term`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `term` (`concept`,`term`) USING BTREE,
  ADD SPATIAL KEY `geometry` (`geometry`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_spatial_fragment`
--
ALTER TABLE `ark_spatial_fragment`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
