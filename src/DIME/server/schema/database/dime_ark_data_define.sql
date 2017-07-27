-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2017 at 08:47 AM
-- Server version: 10.2.7-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dime_ark_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'find',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dime.find',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `creator` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
