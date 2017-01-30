-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2017 at 12:35 AM
-- Server version: 5.5.52-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dime_ark_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_member`
--

CREATE TABLE IF NOT EXISTS `ark_dataclass_member` (
  `object_fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_fid` int(11) NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_blob`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_blob` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_boolean`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_boolean` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_date`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_date` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_date`
--

INSERT INTO `ark_fragment_date` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(30, 'find', '1', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(31, 'find', '2', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(32, 'find', '3', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(33, 'find', '4', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(34, 'find', '5', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(35, 'find', '6', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(36, 'find', '7', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(37, 'find', '8', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(38, 'find', '9', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(39, 'find', '10', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(40, 'find', '11', 'finddate', NULL, '2017-01-29', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_datetime`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_datetime` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_decimal` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_decimal`
--

INSERT INTO `ark_fragment_decimal` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(50, 'find', '1', 'length', 'mm', '22', NULL, 0, '2017-01-29 20:24:17', 0, '2017-01-29 20:23:17', ''),
(51, 'find', '2', 'length', 'mm', '31', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(52, 'find', '3', 'length', 'mm', '22', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(53, 'find', '4', 'length', 'mm', '20', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(54, 'find', '5', 'length', 'mm', '31', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(55, 'find', '6', 'length', 'mm', '31', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(56, 'find', '7', 'length', 'mm', '36', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(57, 'find', '8', 'length', 'mm', '60', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(58, 'find', '9', 'length', 'mm', '19', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(59, 'find', '10', 'length', 'mm', '30', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(60, 'find', '11', 'length', 'm', '1', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_float`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_float` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_integer`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_integer` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_item` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_item`
--

INSERT INTO `ark_fragment_item` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(2, 'find', '2', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(3, 'find', '3', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(4, 'find', '4', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(5, 'find', '5', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(6, 'find', '6', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(7, 'find', '7', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(8, 'find', '8', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(9, 'find', '9', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(10, 'find', '10', 'museum', 'actor', 'NJM', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_object` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_string`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_string` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=558 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(168, 'actor', 'ARV', 'id', '', 'ARV', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(169, 'actor', 'BMR', 'id', '', 'BMR', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(170, 'actor', 'DKM', 'id', '', 'DKM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(171, 'actor', 'FHM', 'id', '', 'FHM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(172, 'actor', 'HBV', 'id', '', 'HBV', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(173, 'actor', 'HEM', 'id', '', 'HEM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(174, 'actor', 'HOM', 'id', '', 'HOM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(175, 'actor', 'KBM', 'id', '', 'KBM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(176, 'actor', 'KNV', 'id', '', 'KNV', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(177, 'actor', 'MKH', 'id', '', 'MKH', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(178, 'actor', 'MLF', 'id', '', 'MLF', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(179, 'actor', 'MNS', 'id', '', 'MNS', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(180, 'actor', 'MOE', 'id', '', 'MOE', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(181, 'actor', 'MSA', 'id', '', 'MSA', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(182, 'actor', 'MSJ', 'id', '', 'MSJ', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(183, 'actor', 'MVE', 'id', '', 'MVE', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(184, 'actor', 'NJM', 'id', '', 'NJM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(185, 'actor', 'OBM', 'id', '', 'OBM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(186, 'actor', 'ØFM', 'id', '', 'ØFM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(187, 'actor', 'ØHM', 'id', '', 'ØHM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(188, 'actor', 'ROM', 'id', '', 'ROM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(189, 'actor', 'SBM', 'id', '', 'SBM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(190, 'actor', 'SJM', 'id', '', 'SJM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(191, 'actor', 'SKH', 'id', '', 'SKH', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(192, 'actor', 'TAK', 'id', '', 'TAK', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(193, 'actor', 'THY', 'id', '', 'THY', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(194, 'actor', 'VHM', 'id', '', 'VHM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(195, 'actor', 'VKH', 'id', '', 'VKH', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(196, 'actor', 'VMÅ', 'id', '', 'VMÅ', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(197, 'actor', 'VSM', 'id', '', 'VSM', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(198, 'actor', 'ARV', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(199, 'actor', 'BMR', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(200, 'actor', 'DKM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(201, 'actor', 'FHM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(202, 'actor', 'HBV', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(203, 'actor', 'HEM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(204, 'actor', 'HOM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(205, 'actor', 'KBM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(206, 'actor', 'KNV', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(207, 'actor', 'MKH', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(208, 'actor', 'MLF', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(209, 'actor', 'MNS', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(210, 'actor', 'MOE', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(211, 'actor', 'MSA', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(212, 'actor', 'MSJ', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(213, 'actor', 'MVE', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(214, 'actor', 'NJM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(215, 'actor', 'OBM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(216, 'actor', 'ØFM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(217, 'actor', 'ØHM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(218, 'actor', 'ROM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(219, 'actor', 'SBM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(220, 'actor', 'SJM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(221, 'actor', 'SKH', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(222, 'actor', 'TAK', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(223, 'actor', 'THY', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(224, 'actor', 'VHM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(225, 'actor', 'VKH', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(226, 'actor', 'VMÅ', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(227, 'actor', 'VSM', 'type', 'dime.actor.type', 'museum', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(244, 'file', '1', 'id', NULL, '1', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(245, 'file', '1', 'type', 'core.file.type', 'text', NULL, 0, '2017-01-25 19:46:09', 0, '0000-00-00 00:00:00', ''),
(246, 'file', '1', 'mediatype', NULL, 'text/plain', NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(247, 'file', '1', 'status', 'core.file.status', 'new', NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(250, 'locality', '1', 'id', NULL, '1', NULL, 0, '2017-01-26 14:33:48', 0, '2017-01-26 14:33:48', ''),
(251, 'locality', '1', 'type', NULL, 'test', NULL, 0, '2017-01-26 22:43:27', 0, '2017-01-26 14:33:48', ''),
(252, 'locality', '2', 'id', NULL, '2', NULL, 0, '2017-01-26 14:34:15', 0, '2017-01-26 14:34:15', ''),
(253, 'locality', '2', 'type', NULL, 'test', NULL, 0, '2017-01-26 14:34:15', 0, '2017-01-26 14:34:15', ''),
(281, 'locality', '3', 'id', NULL, '3', NULL, 0, '2017-01-26 22:21:34', 0, '2017-01-26 22:21:34', ''),
(282, 'locality', '3', 'type', NULL, 'hgfdhdg', NULL, 0, '2017-01-26 22:21:34', 0, '2017-01-26 22:21:34', ''),
(288, 'actor', 'KBM', 'kommuner', 'dime.denmark.kommune', '101', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(289, 'actor', 'KBM', 'kommuner', 'dime.denmark.kommune', '147', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(290, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '151', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(291, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '153', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(292, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '155', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(293, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '157', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(294, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '159', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(295, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '161', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(296, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '163', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(297, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '165', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(298, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '167', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(299, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '169', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(300, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '173', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(301, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '175', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(302, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '183', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(303, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '185', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(304, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '187', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(305, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '190', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(306, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '201', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(307, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '210', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(308, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '217', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(309, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '219', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(310, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '223', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(311, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '230', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(312, 'actor', 'TAK', 'kommuner', 'dime.denmark.kommune', '240', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(313, 'actor', 'ROM', 'kommuner', 'dime.denmark.kommune', '250', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(314, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '253', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(315, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '259', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(316, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '260', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(317, 'actor', 'ROM', 'kommuner', 'dime.denmark.kommune', '265', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(318, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '269', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(319, 'actor', 'MNS', 'kommuner', 'dime.denmark.kommune', '270', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(320, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '306', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(321, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '316', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(322, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '320', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(323, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '326', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(324, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '329', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(325, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '330', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(326, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '336', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(327, 'actor', 'MVE', 'kommuner', 'dime.denmark.kommune', '340', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(328, 'actor', 'ROM', 'kommuner', 'dime.denmark.kommune', '350', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(329, 'actor', 'MLF', 'kommuner', 'dime.denmark.kommune', '360', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(330, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '370', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(331, 'actor', 'MLF', 'kommuner', 'dime.denmark.kommune', '376', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(332, 'actor', 'KNV', 'kommuner', 'dime.denmark.kommune', '390', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(333, 'actor', 'BMR', 'kommuner', 'dime.denmark.kommune', '400', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(334, 'actor', 'OBM', 'kommuner', 'dime.denmark.kommune', '410', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(335, 'actor', 'OBM', 'kommuner', 'dime.denmark.kommune', '420', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(336, 'actor', 'ØHM', 'kommuner', 'dime.denmark.kommune', '430', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(337, 'actor', 'ØFM', 'kommuner', 'dime.denmark.kommune', '440', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(338, 'actor', 'ØFM', 'kommuner', 'dime.denmark.kommune', '450', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(339, 'actor', 'OBM', 'kommuner', 'dime.denmark.kommune', '461', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(340, 'actor', 'ØHM', 'kommuner', 'dime.denmark.kommune', '479', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(341, 'actor', 'OBM', 'kommuner', 'dime.denmark.kommune', '480', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(342, 'actor', 'ØHM', 'kommuner', 'dime.denmark.kommune', '482', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(343, 'actor', 'ØHM', 'kommuner', 'dime.denmark.kommune', '492', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(344, 'actor', 'MSJ', 'kommuner', 'dime.denmark.kommune', '510', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(345, 'actor', 'SJM', 'kommuner', 'dime.denmark.kommune', '530', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(346, 'actor', 'MSJ', 'kommuner', 'dime.denmark.kommune', '540', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(347, 'actor', 'MSJ', 'kommuner', 'dime.denmark.kommune', '550', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(348, 'actor', 'SJM', 'kommuner', 'dime.denmark.kommune', '561', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(349, 'actor', 'SJM', 'kommuner', 'dime.denmark.kommune', '563', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(350, 'actor', 'ARV', 'kommuner', 'dime.denmark.kommune', '573', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(351, 'actor', 'HBV', 'kommuner', 'dime.denmark.kommune', '575', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(352, 'actor', 'MSJ', 'kommuner', 'dime.denmark.kommune', '580', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(353, 'actor', 'VKH', 'kommuner', 'dime.denmark.kommune', '607', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(354, 'actor', 'HOM', 'kommuner', 'dime.denmark.kommune', '615', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(355, 'actor', 'MKH', 'kommuner', 'dime.denmark.kommune', '621', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(356, 'actor', 'VKH', 'kommuner', 'dime.denmark.kommune', '630', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(357, 'actor', 'HEM', 'kommuner', 'dime.denmark.kommune', '657', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(358, 'actor', 'DKM', 'kommuner', 'dime.denmark.kommune', '661', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(359, 'actor', 'DKM', 'kommuner', 'dime.denmark.kommune', '665', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(360, 'actor', 'DKM', 'kommuner', 'dime.denmark.kommune', '671', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(361, 'actor', 'MOE', 'kommuner', 'dime.denmark.kommune', '706', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(362, 'actor', 'MOE', 'kommuner', 'dime.denmark.kommune', '707', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(363, 'actor', 'FHM', 'kommuner', 'dime.denmark.kommune', '710', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(364, 'actor', 'FHM', 'kommuner', 'dime.denmark.kommune', '727', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(365, 'actor', 'MOE', 'kommuner', 'dime.denmark.kommune', '730', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(366, 'actor', 'SKH', 'kommuner', 'dime.denmark.kommune', '740', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(367, 'actor', 'FHM', 'kommuner', 'dime.denmark.kommune', '741', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(368, 'actor', 'SBM', 'kommuner', 'dime.denmark.kommune', '746', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(369, 'actor', 'FHM', 'kommuner', 'dime.denmark.kommune', '751', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(370, 'actor', 'HEM', 'kommuner', 'dime.denmark.kommune', '756', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(371, 'actor', 'ARV', 'kommuner', 'dime.denmark.kommune', '760', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(372, 'actor', 'HOM', 'kommuner', 'dime.denmark.kommune', '766', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(373, 'actor', 'THY', 'kommuner', 'dime.denmark.kommune', '773', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(374, 'actor', 'MSA', 'kommuner', 'dime.denmark.kommune', '779', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(375, 'actor', 'THY', 'kommuner', 'dime.denmark.kommune', '787', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(376, 'actor', 'VSM', 'kommuner', 'dime.denmark.kommune', '791', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(377, 'actor', 'VHM', 'kommuner', 'dime.denmark.kommune', '810', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(378, 'actor', 'VHM', 'kommuner', 'dime.denmark.kommune', '813', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(379, 'actor', 'VMÅ', 'kommuner', 'dime.denmark.kommune', '820', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(380, 'actor', 'VHM', 'kommuner', 'dime.denmark.kommune', '825', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(381, 'actor', 'NJM', 'kommuner', 'dime.denmark.kommune', '840', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(382, 'actor', 'NJM', 'kommuner', 'dime.denmark.kommune', '846', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(383, 'actor', 'NJM', 'kommuner', 'dime.denmark.kommune', '849', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(384, 'actor', 'NJM', 'kommuner', 'dime.denmark.kommune', '851', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(385, 'actor', 'VHM', 'kommuner', 'dime.denmark.kommune', '860', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(467, 'find', '1', 'finder_id', NULL, '5178K189-1', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(468, 'find', '1', 'type', 'dime.find.type', 'accessory', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(469, 'find', '1', 'period_start', 'dime.period', 'CYVX', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(470, 'find', '1', 'material', 'dime.material', 'ag', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(471, 'find', '1', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(472, 'find', '1', 'id', NULL, '1', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(473, 'find', '2', 'finder_id', NULL, '5182K117-3', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(474, 'find', '2', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(475, 'find', '2', 'period_start', 'dime.period', 'CYVY', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(476, 'find', '2', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(477, 'find', '2', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(478, 'find', '2', 'id', NULL, '2', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(479, 'find', '3', 'finder_id', NULL, '5595K024-1', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(480, 'find', '3', 'type', 'dime.find.type', 'coin', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(481, 'find', '3', 'period_start', 'dime.period', 'CYVÆ', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(482, 'find', '3', 'material', 'dime.material', 'ag', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(483, 'find', '3', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(484, 'find', '3', 'id', NULL, '3', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(485, 'find', '4', 'finder_id', NULL, '5923K002-1', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(486, 'find', '4', 'type', 'dime.find.type', 'coin', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(487, 'find', '4', 'period_start', 'dime.period', 'CÆRY', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(488, 'find', '4', 'material', 'dime.material', 'ag', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(489, 'find', '4', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(490, 'find', '4', 'id', NULL, '4', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(491, 'find', '5', 'finder_id', NULL, '5924K016-1', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(492, 'find', '5', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(493, 'find', '5', 'period_start', 'dime.period', 'CYVÆ', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(494, 'find', '5', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(495, 'find', '5', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(496, 'find', '5', 'id', NULL, '5', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(497, 'find', '6', 'finder_id', NULL, '6128K002-3', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(498, 'find', '6', 'type', 'dime.find.type', 'accessory', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(499, 'find', '6', 'period_start', 'dime.period', 'DXXX', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(500, 'find', '6', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(501, 'find', '6', 'condition', 'dime.find.condition', 'fragmented', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(502, 'find', '6', 'id', NULL, '6', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(503, 'find', '7', 'finder_id', NULL, '6300K004-1', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(504, 'find', '7', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(505, 'find', '7', 'period_start', 'dime.period', 'VEM', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(506, 'find', '7', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(507, 'find', '7', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(508, 'find', '7', 'id', NULL, '7', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(509, 'find', '7', 'secondary', 'dime.find.secondary', 'enamel', NULL, 0, '2017-01-29 21:01:00', 0, '2017-01-29 21:01:00', ''),
(510, 'find', '8', 'finder_id', NULL, '6309K027-1', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(511, 'find', '8', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(512, 'find', '8', 'period_start', 'dime.period', 'CYGY', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(513, 'find', '8', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(514, 'find', '8', 'secondary', 'dime.find.secondary', 'tinned', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(515, 'find', '8', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(516, 'find', '8', 'id', NULL, '8', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(517, 'find', '9', 'finder_id', NULL, '6309K028-1', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(518, 'find', '9', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(519, 'find', '9', 'period_start', 'dime.period', 'DÆXX', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(520, 'find', '9', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(521, 'find', '9', 'secondary', 'dime.find.secondary', 'gilded', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(522, 'find', '9', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(523, 'find', '9', 'id', NULL, '9', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(524, 'find', '10', 'finder_id', NULL, '6400K002-14', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(525, 'find', '10', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(526, 'find', '10', 'period_start', 'dime.period', 'CYGY', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(527, 'find', '10', 'material', 'dime.material', 'cual', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(528, 'find', '10', 'condition', 'dime.find.condition', 'whole', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(529, 'find', '10', 'id', NULL, '10', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(530, 'find', '1', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(531, 'find', '2', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(532, 'find', '3', 'treasure', 'dime.treasure', 'treasure', NULL, 0, '2017-01-29 22:46:48', 0, '2017-01-29 22:37:39', ''),
(533, 'find', '4', 'treasure', 'dime.treasure', 'treasure', NULL, 0, '2017-01-29 22:48:31', 0, '2017-01-29 22:37:39', ''),
(534, 'find', '5', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(535, 'find', '6', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(536, 'find', '7', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(537, 'find', '8', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(538, 'find', '9', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(539, 'find', '10', 'treasure', 'dime.treasure', 'assessing', NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(540, 'find', '11', 'finder_id', NULL, 'qqqqq', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(541, 'find', '11', 'type', 'dime.find.type', 'accessory', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(542, 'find', '11', 'material', 'dime.material', 'ag', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(543, 'find', '11', 'condition', 'dime.find.condition', 'fragmented', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(544, 'find', '11', 'id', NULL, '11', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(545, 'find', '1', 'image', NULL, '5178K189-1.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(546, 'find', '2', 'image', NULL, '5182K117-3.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(547, 'find', '3', 'image', NULL, '5595K024-1.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(548, 'find', '4', 'image', NULL, '5923K002-1.bagside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(549, 'find', '4', 'image', NULL, '5923K002-1.forside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(550, 'find', '5', 'image', NULL, '5924K016-1.bagside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(551, 'find', '5', 'image', NULL, '5924K016-1.forside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(552, 'find', '6', 'image', NULL, '6128K002-3.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(553, 'find', '7', 'image', NULL, '6300K004-1.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(554, 'find', '8', 'image', NULL, '6309K027-1.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(555, 'find', '9', 'image', NULL, '6309K028-1.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(556, 'find', '10', 'image', NULL, '6400K002-14.bagside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(557, 'find', '10', 'image', NULL, '6400K002-14.forside.jpg', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_text` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(41, 'page', 'about', 'content', 'da', '<h2>Om DIME</h2><p>DIME står for ”Digitale Metaldetektorfund” og er en brugerdrevet platform til registrering af metaldetektorfund til brug i formidling, forskning og forvaltning.</p><p>Ideen bag DIME er, at den skal:<ul><li>øge inddragelse af metaldetektorbrugerne i det museale arbejde</li><li>øge og skærpe samarbejdet mellem metaldetektorbrugere og museer</li><li>lette arbejdsbyrden vedr. fundregistrering og danefæbehandling på museerne</li><li>muliggøre en hurtig behandling af Danefæ</li><li>muliggøre en ensartet registreringspraksis landet over</li><li>optimere tilgængeligheden af information om metaldetektorfundene til forskningsbrug</li><li>fungere som indgang for indberetning af fund til centrale, museale databaser (SARA mfl.)</li></ul></p><h3>Baggrunden for DIME</h3><p>Hvert år finder frivillige metaldetektorbrugere på danske marker i 1000vis af fund af stor kulturhistorisk betydning. De bidrager løbende til fremkomsten af nogle af de mest opsigtsvækkende fund i dansk arkæologi, og metaldetektorfundene har i mange henseender revolutioneret vor forståelse af de forhistoriske og historiske samfund fra bronzealder til nyere tid. Dansk metaldetektorarkæologi har på den baggrund udviklet sig til en unik og internationalt anerkendt succeshistorie, som forener de bedste sider af den danske model med en bred folkelig involvering i det arkæologiske arbejde og en decentral museumsstruktur. Men den kolossale tilvækst af indkomne fund har i stigende grad tydeliggjort behovet for en samlet registrering af metaldetektorfundene, idet kun en brøkdel af de mange fund er tilgængelige for offentligheden, museerne og for forskningen. DIME er udviklet med henblik på at muliggøre optimal udnyttelse af metaldetektorfundenes store formidlings- og forskningsmæssige potentiale.</p><h3>Udviklingen af DIME</h3><p>DIME-databasen blev udviklet i 2016-2017 af en gruppe museumsfolk og universitetsarkæologer i tæt samarbejde med detektorbrugere og et bredt panel fagfolk fra museer landet over. DIME er således udviklet af brugere for brugere, og under udformning af databasen har udviklerne bl.a. kunne støtte sig til:<ul><li>Interview af 27 museumsmedarbejder (fra 27 forskellige museer) om praksis og erfaringer med fundregistrering og krav til en evt. databaseløsning</li><li>Online spørgeskema blandt detektorfolk om praksis og ønsker til fundregistrering (168 besvarelser)</li><li>Fokusgruppeinterview med udvalgte detektorfolk</li></ul></p><p>DIME er udviklet af følgende institutioner:<ul><li>Aarhus Universitet</li><li>Moesgaard Museum</li><li>Nordjyllands Historiske Museum</li><li>Odense Bys Museer</li></ul></p><p>Udvikling af DIME blev muliggjort med økonomisk støtte fra KROGAGERFONDEN</p>', NULL, 0, '2017-01-24 14:06:45', 0, '0000-00-00 00:00:00', ''),
(42, 'page', 'treasure', 'content', 'da', '<h2>Danefæ</h2><p>Danefæ er genstande fra fortiden, der kommer til veje som jordfund i Danmark, og som er forarbejdet af ædelt metal eller i øvrigt er af kulturhistorisk værdi, herunder mønter. Den, der finder danefæ eller får danefæ i sin besiddelse, skal aflevere det, idet danefæ tilhører staten.<p>Loven om danefæ kan spores tilbage til middelalderen. Nationalmuseet administrerer denne lov, der sikrer, at vigtige fund fra Danmarks fortid bliver bevaret for kommende generationer.<h3>Indlevering af Danefæ</h3><p>Oldsager og andre betydningsfulde genstande fra fortiden, som skønnes at være danefæ, skal indleveres til staten. Det foregår i praksis ved, at finderen indleverer fundet til det lokale museum, der har ansvaret for arkæologiske fund i området - <a href="http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/ansvarsomraader-og-kontakt/">se fordelingen af ansvarsområder her</a>.<p>Den endelige vurdering af fundets danefæ-status foretages på Nationalmuseet. Den faglige bestemmelse af fundene foretages af medarbejdere fra tre af Nationalmuseets enheder: Den Kgl. Mønt- og Medaillesamling, Danmarks Middelalder og Renæssance og Danmarks Oldtid.<p>Nationalmuseet har fra 2013 indført en transportordning for danefæ og ikke-danefæ. Ordningen indebærer, at Nationalmuseet en gang årligt transporterer danefæ til uddeponering samt ikke-danefæ retur til lokalmuseerne. Transporten kan også medtage danefæ til vurdering fra lokalmuseet til Nationalmuseet. Det er dog stadig muligt for lokalmuseerne, at indlevere genstande til danefævurdering direkte til Nationalmuseet.<h3>Jeg har fundet danefæ - hvad gør jeg?</h3><p>Du skal i første omgang henvende dig på dit lokale museum. Det er dit lokale museum, der skal tage imod dit fund og kontakte Nationalmuseet. Her kan du printe <a href="http://natmus.dk/fileadmin/user_upload/natmus/Danefae/Kvitteringsseddel.pdf">et kvitteringsskema, du afleverer sammen med dit fund</a>(PDF).<p>Hvis du alligevel ønsker at indlevere til Nationalmuseet, tager vi kontakten til det lokale museum. Derved kan danefævurderingen trække ud, da vi skal afvente, at det lokale museum indberetter fundet. Nationalmuseet anmoder herefter det lokale museum om at indsende en danefæanmeldelse ud fra de oplysninger, som du har indleveret sammen med genstanden. Den indleverede genstand bliver på Nationalmuseet og afventer fundanmeldelse fra det lokale museum. Herefter fortsætter danefæsagen efter sædvanlig procedure.<h3>Sådan udviser man omhu ved fund af danefæ</h3><p><strong>Forskellige udtryk for omhu i forbindelse med danefæfund:</strong><p><strong>Ved tilfældige fund</strong>, dvs. ikke-detektorfund kan finderen udvises særlig omhu ved:<ol><li>Forsigtig håndtering.<li>Forsvarlig emballering.<li>Hurtig kontakt til antikvariske myndigheder.<li>Opmærksomhed på forekomsten af relevante kulturspor: skår, lerklining, trækul, sten, knoglestumper, sortjord, etc.</ol><p><strong>Ved detektorfund</strong> kan finderen i øvrigt udvises særlig omhu ved:<ol><li>Nøjagtig ”on-site” lokalisering af fundsted – ved indmåling af GPS-koordinater.</li><li>Øjeblikkelig ”on-site” fotodokumentation af fundenes tilstand og GPS-målingernes troværdighed</li><li>Tilsvarende omhyggelig indsamling af ”ikke danefæ”- fund, til belysning af konteksten for de regulære danefæ-stykker, dvs. til sikring af danefæets videnskabelige værdi. Ligeledes at finder har indgået aftale med det lokale museum om at overdrage ikke-danefæ til lokalmuseet. Kvitteringsblanket skal være underskrevet.</li><li>Elektronisk fundrapportering til lokalmuseet (med foreløbige betegnelser, eventuelle løbenumre, koordinater, fotos).  </li><li>I tvivlstilfælde og ved mulighed for dybereliggende grav- eller skattefund kontaktes lokalmuseet  straks. Ingen gravning under pløjedybde!</li><li>Der gives løbende orientering om eventuelle fund til lodsejer og lokalmuseum.</li><li>Fund udsættes ikke for afrensning, imprægnering eller afstøbning</li><li>Fund udsættes ikke for skader eller informations-tab som følge af uhensigtsmæssig (eller langvarig) opbevaring.</li></ol><p><em>Ved grundig registrering af fundene i DIME opfyldes en række af ovenstående punkter udpeget af Nationalmuseet som særligt væsentlige for omhyggelig behandling af potentielt danefæ.</em><h3>Hvad kan være danefæ?</h3><p>Som udgangspunkt er fragmenter lige så vigtige som hele genstande i detektorsammenhæng, idet de(t) resterende fragment(er) oftest dukker op med tiden. Det afgørende for om noget bør erklæres for danefæ er altså typen af genstand - ikke genstandens tilstand. Hittegods er aldrig danefæ.<h4>Guld</h4><p>Alle genstande af guld er danefæ.<h4>Sølv</h4><p>+ Genstande af sølv fra før 1700 samt sølvklip og -fragmenter<p>- Sølv fra tiden efter 1700 med mindre det er af ekstraordinær karakter<h4>Bronze</h4><p>+ Bronzegenstande fra oldtid og vikingetid er danefæ<p>+ Genstande af bronze med særlig ornamentik eller udsmykning - f.eks. inskription eller emalje fra middelalder<p>+ Hele eller tilnærmelsesvis hele malmgryder<p>+ Vægtlodder<p>+ Seglstamper fra før 1700<p>- Simple genstande af bronze fra middelalder og renæssance<p>- Fragmenter af malmgryder<p>- Taphaner<p>- Nøgler eller hængelåse uden kunstnerisk udsmykning.<h4>Bly</h4><p>+ Vægtlodder<p>+ Støbemodeller<p>+ Tenvægte med særlig udsmykning fra middelalder<p>+ Klædeplomber med ornamentik og/eller skrift<p>+ Genstande med runer eller anden skrift<p>- Musketkugler<p>- Udaterbare smelteklumper og simple blygenstande fra tiden efter 1536<h4>Jern</h4><p>+ Ekstraordinære jerngenstande og genstande med f.eks. tauschering, indlægning, ornamentik; eksempelvis sværd fra oldtiden og middelalderen<p>- Andre genstande af jern fra oldtid og middelalder, våben som værktøj o.a.<h4>Mønter</h4><p>+ Mønter fra oldtid, vikingetid og middelalder (fra 1536 og før)<p>+ Mønter i skattefund - flere mønter nedlagt sammen<p>+ Guldmønter og større sølvmønter, f.eks. dalermønter fra tiden efter 1536.<p>- Småmønter af sølv og kobber fra tiden efter 1536<h4>Figurer</h4><p>+ Figurer og plastiske fremstillinger i sten, metal, ben, rav og træ<p>+ Figurer i keramik og tegl fra oldtid og middelalder<h4>Runer og anden indskrift</h4><p>+ Sten og andre genstande med runer og anden indskrift<p><p>Desuden omfatter listen af muligt Danefæ også en række ikke-metalliske genstande. For nærmere herom <a href="http://natmus.dk/salg-og-ydelser/museumsfaglige-ydelser/danefae/hvad-kan-vaere-danefae/">se Nationalmuseets hjemmeside</a>.<p>(Kilde: Nationalmuseet)', NULL, 0, '2017-01-24 14:06:25', 0, '0000-00-00 00:00:00', ''),
(43, 'page', 'background', 'content', 'da', '<h2>Metaldetektorbrug i Danmark</h2><p>Siden 1970erne har metaldetektering vundet stor popularitet blandt private brugere i Danmark. Hvert år bruger entusiastiske detektorbrugere i tusindvis af timer på at afsøge marker over hele landet og bidrager alle på denne vis til at redde vigtige arkæologiske fund fra gradvis nedbrydning som følge af dyrkning, vind og vejr.<p>Tabt, ofret til guderne eller gemt til senere brug. De mange genstande, som bliver fundet med metaldetektor, er endt i jorden af vidt forskellige årsager igennem tiderne. De fleste er dog små enkeltliggende genstande, f.eks. mønter og smykker, som øjensynligt er blevet tabt under brug. Mange fund i et område indikerer derfor, at her har været høj aktivitet. Men mængden af fund afspejler i høj grad også, hvor udbredt brugen af metaller har været. Der er således betydeligt længere mellem fundene fra bronzealderen og de tidligste dele af jernalderen, hvor metaller udgjorde kostbare sjældenheder, end mellem fundene fra yngre jernalder og ikke mindst fra middelalderen og fremefter. På sammen vis er genstande af jern, bronze, bly og aluminium almindelige mens fund af sølv og i særdeleshed fund af guld naturligvis er anderledes sjældne.<p>Metaldetektorens effektive søgedybde afhænger af metalgenstandens karakter og markens overflade og udgør oftest kun nogle kun få cm, hvorfor dyrkede marker, hvor ploven jævnligt vender de dybere dele af muldlaget op til overfladen, opbyder de mest optimale ”jagtmarker”. Højsæsonen for metaldetektering er derfor ikke overraskende forår og efterår, hvor markerne står uden afgrøder.<h3>Regler</h3><p>I Danmark er det lovligt at gå med metaldetektor i de fleste områder. Der er dog nogle enkle regler, som skal overholdes, og Kulturstyrelsen har udarbejdet følgende vejledning til, hvordan man som detektorbruger skal og bør forholde sig.<p>Du skal:<ul><li>Du  skal sørge for at få tilladelse til at gå på det areal du ønsker, hos ejeren af jorden. Er ejeren offentlig, skal du henvende dig til den relevante myndighed, f.eks. en kommunes tekniske forvaltning. <a href="http://svana.dk/natur/friluftsliv/hvad-maa-jeg-i-naturen/">For statens arealer, der forvaltes af Naturstyrelsen, gælder der særlige regler</a>.</li><li>Du skal aflevere de fundne genstande til det lokale museum (eller Nationalmuseet), såfremt du mener at der kan være tale om danefæ.</li></ul><p>Du må ikke:<ul><li>Du må ikke gå med detektor på fredede fortidsminder, eller nærmere end to meter fra fredningsgrænsen. Se om et fortidsminde er fredet på Kulturstyrelsens database <a href="http://www.kulturarv.dk/fundogfortidsminder/">Fund og Fortidsminder</a></li><li>Du må ikke foretage en udgravning af et fundområde, herunder grave dybere end pløjelaget.</li></ul><p>Du må gerne:<ul><li>Du må gerne gå med detektor på <a href="http://www.kulturstyrelsen.dk/index.php?id=13240">kulturarvsarealer</a>, dog ikke på fredede fortidsminder indenfor arealerne, se <a href="http://www.kulturarv.dk/fundogfortidsminder/">Fund og Fortidsminder</a>, og du skal stadig spørge ejeren om lov.</li></ul><p>Om selve genstandene (danefæ):<ul><li>En række af de genstande du kan finde med en metaldetektor kan være danefæ (se menupunktet ”danefæ”). Danefæ tilhører staten, og er du det mindste i tvivl, om det du har fundet evt. kan være danefæ, skal du kontakte det lokale museum eller Nationalmuseet, der kan vejlede dig om det videre forløb.</li><li>Du må ikke sælge genstande/danefæ.</li><li>Du må ikke videregive genstande/danefæ.</li><li>Du bør behandle genstandene med omhu og forsigtighed, de er sårbare.</li><li>Du bør ikke rengøre, børste eller vaske genstande da informationer kan gå tabt.</li><li>Du bør opbevare genstande i en plastpose og æske med låg.</li><li>Du bør anvende en GPS til at måle dine fund ind med – også dem du er i tvivl om er noget.</li><li>Du bør notere findernavn, sted, dato og GPS-koordinater sammen med fundet. Hvis du skriver på en seddel der lægges i posen, så brug en blyant – aldrig kuglepen eller filtpen da skriftes let flyder ud hvis papiret bliver fugtigt.</li><li>Du bør markere fundområdet på et kort.</li></ul><p>Om fundstedet:<li>Du må ikke påbegynde en udgravning af fundstedet. Grav aldrig dybere end pløjelagets dybde.</li><p>Det er en god idé:<ul><li>At have god kontakt med lokalmuseet.</li><li>At have god kontakt med lodsejere.</li><li>At orientere sig i <a href="http://www.kulturarv.dk/fundogfortidsminder/">Fund & Fortidsminder-databasen</a>.</li><li>At være medlem af den lokale detektorklub eller amatørarkæologiske forening.</li><li>At være to eller flere, der går sammen.</li><li>At have indbyrdes klare aftaler med hinanden og med lodsejer.</li><li>At være systematisk i sin søgen.</li><li>At føre dagbog over sin søgen.</li><li>At diskutere fundne genstande og afsøgningsmetoder i detektorklubben.</li></ul><h3>Metaldetektorfund og arkæologiske udgravninger</h3><p>Grundejere, der skal give lov til, at der må anvendes metaldetektor på ens ejendom – typisk landmænd – er indimellem usikre omkring, hvorvidt fund gjort med metaldetektor kan medføre udgravninger, som skal betales af ejeren af jorden. Fremkomsten af detektorfund vil i sig selv ikke medføre, at en jordejer påføres udgifter til en evt. efterfølgende arkæologisk udgravning.<p>De fleste detektorfund indgår i museernes samlinger - enten som danefæ på Nationalmuseet eller på det lokale museum som almindelige genstande, der indlemmes i museets samling. Enkelte fund, typisk fra nyere tid, kan beholdes af detektorføreren selv.<p>I de sjældne tilfælde, hvor der gøres et skattefund, f.eks. mønter eller værdifuldt metal, er museerne ofte interesserede i at gennemføre en begrænset undersøgelse af fundstedet. Formålet vil være at sikre de dele af skatten, der muligvis endnu er bevaret under pløjelaget. Herved kan man sikre en række væsentlige oplysninger om deponeringsmåden (i et lerkar, en læderpung eller lignende) og ofte også årsagen til deponeringen (til gudernes gunst eller i ufredstider). Samtidig sikrer man, at alle dele af skatten kommer til syne – og dermed er den videnskabelige værdi af fundet væsentligt større.<p>Når en skat i første omgang findes, skyldes det, at nogle af genstandene allerede ligger oppe i pløjelaget. De kan være ført derop af markredskaber for både 10, 50 eller 100 år siden. Altså som følge af ”jordarbejde i forbindelse med erosion eller jordarbejde udført som led i dyrkning af almindelige landbrugsafgrøder eller som led i almindelig skovdrift,” som det hedder i lovteksten (<a href="https://www.retsinformation.dk/forms/r0710.aspx?id=12017">Museumslovens § 27, stk. 5. pind 1</a>). Arkæologiske undersøgelser af denne type skal ikke betales af jordejeren, men bekostes typisk af midler fra en pulje, som Slots- og Kulturstyrelsen råder over, efter ansøgning fra det lokale museum. Afhængig af undersøgelsens omfang og tidspunkt på året kan jordejeren kompenseres for eventuelle tab efter gældende regler for afgrødeerstatning.<h3>Fra landmand til bygherre</h3><p>Der kan dog opstå situationer, hvor detektorfund på længere sigt kan være en medvirkende årsag til, at der skal gennemføres en arkæologisk undersøgelse for landmandens regning – nemlig i det tilfælde, hvor han går fra at dyrke marken til at være bygherre. Et eksempel:<p>Hvis man forestiller sig, at der bliver gået med metaldetektor tæt ind til en eksisterende gård, og der på hele den vestlige side fremkommer spredte metalfund, f.eks. fra en bebyggelse fra vikingetid og ældre middelalder, vil det i første omgang ikke medføre en udgravning. Metaldetektorfundene er naturligvis med til at forøge vores viden om placeringen af landsbyer, bopladser og gravpladser rundt omkring i landskabet. På den måde er detektorfundene med til at give et mere detaljeret indblik i den forhistoriske udnyttelse af landskabet, end hvis vi ikke havde disse fund. Det svarer til fund af potteskår eller flintredskaber som f.eks. økser eller dolke.<p>Hvis landmanden på et senere tidspunkt ønsker at udvide sin gård, f.eks. med en ny løsdriftsstald med tilhørende gylletank og plansilo, vil metaldetektorfundene - på lige fod med alle andre oplysninger, som museet kender til (f.eks. overpløjede gravhøje, løsfundne stenoldsager, spor set fra luften eller som fremgår af såkaldte LiDAR-scanninger) - danne baggrund for den rådgivning, som museet vil tilbyde landmanden i forbindelse med hans byggeprojekt.<p>Landmanden kan i den forbindelse vælge at få gennemført en forundersøgelse af arealet (<a href="http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/vejledning-om-arkaeologiske-undersoegelser/">se mere i Vejledning om arkæologiske undersøgelser</a>), og hvis det herefter viser sig, at der på det areal, hvor han ønsker at udvide gården, fremkommer væsentlige fortidsminder, er det museumslovens bestemmelse, at han som bygherre skal betale for den nødvendige arkæologiske undersøgelse før byggestart. En bygherre - i dette eksempel en landmand - kan i den forbindelse godt have den opfattelse, at det er metaldetektor-fundenes skyld, at han kommer til at betale for en arkæologisk undersøgelse. Det er dog ikke korrekt, for uanset om der er gjort metalfund eller ej, ville en arkæologisk forundersøgelse afsløre, at der er væsentlige fortidsminder bevaret under muldjorden i form af eksempelvis stolpehuller efter huse, brønde, hegnsspor og affaldsgruber. Museumsloven bestemmer herefter, at den nødvendige arkæologiske undersøgelse skal betales af bygherre, med mindre det er muligt at bevare fortidsminderne på stedet ved at ændre eller flytte anlægsarbejdet.  (Kilde: Kulturstyrelsen - http://slks.dk/fortidsminder-diger/metaldetektor-og-danefae/)', NULL, 0, '2017-01-24 14:05:44', 0, '0000-00-00 00:00:00', ''),
(44, 'page', 'research', 'content', 'da', '<h2>Vidensdeling via DIME</h2><p>Gennem vidensdeling bliver vi alle klogere. DIME hylder og søger aktivt at understøtte dette princip, hvorfor vi ikke kun opfordrer detektorbrugerne til at levere deres unikke viden i form af fundindberetninger, men også tilskynder, at forskere her på hjemmesiden offentliggør nye forskningsresultater vedrørende metaldetektorfundene. For at stimulere denne ”delingskultur” bliver alle med forskeradgang til databasen afkrævet et kort resumé af deres arbejde, når de publicerer forskning med afsæt i DIME. Disse resuméer kan i lighed med anden relevant forskning og henvisninger til andre forskningsarbejder findes ved at følgende de forskellige nedenstående links.', NULL, 0, '2017-01-24 14:04:03', 0, '0000-00-00 00:00:00', ''),
(46, 'actor', 'ARV', 'shortname', 'da', 'ARKVEST', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(47, 'actor', 'BMR', 'shortname', 'da', 'Bornholms', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(48, 'actor', 'DKM', 'shortname', 'da', 'Holstebro', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(49, 'actor', 'FHM', 'shortname', 'da', 'Moesgård', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(50, 'actor', 'HBV', 'shortname', 'da', 'Sønderskov', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(51, 'actor', 'HEM', 'shortname', 'da', 'Midtjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(52, 'actor', 'HOM', 'shortname', 'da', 'Horsens', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(53, 'actor', 'KBM', 'shortname', 'da', 'Københavns', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(54, 'actor', 'KNV', 'shortname', 'da', 'Sydøstdanmark', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(55, 'actor', 'MKH', 'shortname', 'da', 'Koldinghus', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(56, 'actor', 'MLF', 'shortname', 'da', 'Lolland-Falster', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(57, 'actor', 'MNS', 'shortname', 'da', 'Nordsjælland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(58, 'actor', 'MOE', 'shortname', 'da', 'Østjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(59, 'actor', 'MSA', 'shortname', 'da', 'Skive', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(60, 'actor', 'MSJ', 'shortname', 'da', 'Sønderjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(61, 'actor', 'MVE', 'shortname', 'da', 'Vestsjælland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(62, 'actor', 'NJM', 'shortname', 'da', 'Nordjyllands', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(63, 'actor', 'OBM', 'shortname', 'da', 'Odense', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(64, 'actor', 'ØFM', 'shortname', 'da', 'Østfyns', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(65, 'actor', 'ØHM', 'shortname', 'da', 'Øhavs', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(66, 'actor', 'ROM', 'shortname', 'da', 'Roskilde', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(67, 'actor', 'SBM', 'shortname', 'da', 'Skanderborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(68, 'actor', 'SJM', 'shortname', 'da', 'Sydvestjyske', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(69, 'actor', 'SKH', 'shortname', 'da', 'Silkeborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(70, 'actor', 'TAK', 'shortname', 'da', 'Kroppedal', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(71, 'actor', 'THY', 'shortname', 'da', 'Thy', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(72, 'actor', 'VHM', 'shortname', 'da', 'Vendsyssel', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(73, 'actor', 'VKH', 'shortname', 'da', 'Vejle', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(74, 'actor', 'VMÅ', 'shortname', 'da', 'Vesthimmerlands', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(75, 'actor', 'VSM', 'shortname', 'da', 'Viborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(77, 'actor', 'ARV', 'shortname', 'en', 'ARKVEST', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(78, 'actor', 'BMR', 'shortname', 'en', 'Bornholms', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(79, 'actor', 'DKM', 'shortname', 'en', 'Holstebro', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(80, 'actor', 'FHM', 'shortname', 'en', 'Moesgård', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(81, 'actor', 'HBV', 'shortname', 'en', 'Sønderskov', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(82, 'actor', 'HEM', 'shortname', 'en', 'Central Denmark', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(83, 'actor', 'HOM', 'shortname', 'en', 'Horsens', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(84, 'actor', 'KBM', 'shortname', 'en', 'Copenhagen', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(85, 'actor', 'KNV', 'shortname', 'en', 'Southeast Denmark Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(86, 'actor', 'MKH', 'shortname', 'en', 'Koldinghus', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(87, 'actor', 'MLF', 'shortname', 'en', 'Lolland-Falster', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(88, 'actor', 'MNS', 'shortname', 'en', 'North Zealand', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(89, 'actor', 'MOE', 'shortname', 'en', 'East Jutland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(90, 'actor', 'MSA', 'shortname', 'en', 'Skive', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(91, 'actor', 'MSJ', 'shortname', 'en', 'South Jutland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(92, 'actor', 'MVE', 'shortname', 'en', 'West Zealand', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(93, 'actor', 'NJM', 'shortname', 'en', 'North Jutland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(94, 'actor', 'OBM', 'shortname', 'en', 'Odense', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(95, 'actor', 'ØFM', 'shortname', 'en', 'Østfyns', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(96, 'actor', 'ØHM', 'shortname', 'en', 'Øhavs', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(97, 'actor', 'ROM', 'shortname', 'en', 'Roskilde', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(98, 'actor', 'SBM', 'shortname', 'en', 'Skanderborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(99, 'actor', 'SJM', 'shortname', 'en', 'Southwest Jutland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(100, 'actor', 'SKH', 'shortname', 'en', 'Silkeborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(101, 'actor', 'TAK', 'shortname', 'en', 'Kroppedal', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(102, 'actor', 'THY', 'shortname', 'en', 'Thy', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(103, 'actor', 'VHM', 'shortname', 'en', 'Vendsyssel', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(104, 'actor', 'VKH', 'shortname', 'en', 'Vejle', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(105, 'actor', 'VMÅ', 'shortname', 'en', 'Vesthimmerlands', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(106, 'actor', 'VSM', 'shortname', 'en', 'Viborg', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(108, 'actor', 'ARV', 'fullname', 'da', 'ARKVEST Arkæologi Vestjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(109, 'actor', 'BMR', 'fullname', 'da', 'Bornholms Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(110, 'actor', 'DKM', 'fullname', 'da', 'De Kulturhistoriske Museer i Holstebro Kommune', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(111, 'actor', 'FHM', 'fullname', 'da', 'Moesgård Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(112, 'actor', 'HBV', 'fullname', 'da', 'Museet på Sønderskov', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(113, 'actor', 'HEM', 'fullname', 'da', 'Museum Midtjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(114, 'actor', 'HOM', 'fullname', 'da', 'Horsens Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(115, 'actor', 'KBM', 'fullname', 'da', 'Københavns Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(116, 'actor', 'KNV', 'fullname', 'da', 'Museum Sydøstdanmark', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(117, 'actor', 'MKH', 'fullname', 'da', 'Museet på Koldinghus', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(118, 'actor', 'MLF', 'fullname', 'da', 'Museum Lolland-Falster', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(119, 'actor', 'MNS', 'fullname', 'da', 'Museum Nordsjælland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(120, 'actor', 'MOE', 'fullname', 'da', 'Museum Østjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(121, 'actor', 'MSA', 'fullname', 'da', 'Museum Salling, Skive Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(122, 'actor', 'MSJ', 'fullname', 'da', 'Museum Sønderjylland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(123, 'actor', 'MVE', 'fullname', 'da', 'Museum Vestsjælland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(124, 'actor', 'NJM', 'fullname', 'da', 'Nordjyllands Historiske Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(125, 'actor', 'OBM', 'fullname', 'da', 'Odense Bys Museer', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(126, 'actor', 'ØFM', 'fullname', 'da', 'Østfyns Museer', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(127, 'actor', 'ØHM', 'fullname', 'da', 'Øhavsmuseet', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(128, 'actor', 'ROM', 'fullname', 'da', 'Roskilde Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(129, 'actor', 'SBM', 'fullname', 'da', 'Skanderborg Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(130, 'actor', 'SJM', 'fullname', 'da', 'Sydvestjyske Museer', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(131, 'actor', 'SKH', 'fullname', 'da', 'Silkeborg Kulturhistoriske Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(132, 'actor', 'TAK', 'fullname', 'da', 'Kroppedal Museum, Arkæologi', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(133, 'actor', 'THY', 'fullname', 'da', 'Museum Thy', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(134, 'actor', 'VHM', 'fullname', 'da', 'Vendsyssel Historiske Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(135, 'actor', 'VKH', 'fullname', 'da', 'Vejle Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(136, 'actor', 'VMÅ', 'fullname', 'da', 'Vesthimmerlands Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(137, 'actor', 'VSM', 'fullname', 'da', 'Viborg Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(139, 'actor', 'ARV', 'fullname', 'en', 'ARKVEST Archaeology Jutland', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(140, 'actor', 'BMR', 'fullname', 'en', 'Bornholms Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(141, 'actor', 'DKM', 'fullname', 'en', 'The Cultural History Museums in Holstebro Municipality', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(142, 'actor', 'FHM', 'fullname', 'en', 'Moesgård Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(143, 'actor', 'HBV', 'fullname', 'en', 'Museum at Sønderskov', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(144, 'actor', 'HEM', 'fullname', 'en', 'Central Denmark Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(145, 'actor', 'HOM', 'fullname', 'en', 'Horsens Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(146, 'actor', 'KBM', 'fullname', 'en', 'Copenhagen Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(147, 'actor', 'KNV', 'fullname', 'en', 'Southeast Denmark Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(148, 'actor', 'MKH', 'fullname', 'en', 'Museum at Koldinghus', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(149, 'actor', 'MLF', 'fullname', 'en', 'Lolland-Falster Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(150, 'actor', 'MNS', 'fullname', 'en', 'North Zealand Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(151, 'actor', 'MOE', 'fullname', 'en', 'East Jutland Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(152, 'actor', 'MSA', 'fullname', 'en', 'Museum Salling, Skive Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(153, 'actor', 'MSJ', 'fullname', 'en', 'South Jutland Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(154, 'actor', 'MVE', 'fullname', 'en', 'West Zealand Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(155, 'actor', 'NJM', 'fullname', 'en', 'North Jutland Historical Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(156, 'actor', 'OBM', 'fullname', 'en', 'Odense City Museer', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(157, 'actor', 'ØFM', 'fullname', 'en', 'Østfyns Museums', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(158, 'actor', 'ØHM', 'fullname', 'en', 'Øhavs Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(159, 'actor', 'ROM', 'fullname', 'en', 'Roskilde Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(160, 'actor', 'SBM', 'fullname', 'en', 'Skanderborg Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(161, 'actor', 'SJM', 'fullname', 'en', 'Southwest Jutland Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(162, 'actor', 'SKH', 'fullname', 'en', 'Silkeborg Museum of Cultural History', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(163, 'actor', 'TAK', 'fullname', 'en', 'Kroppedal Museum, Archaeology', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(164, 'actor', 'THY', 'fullname', 'en', 'Thy Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(165, 'actor', 'VHM', 'fullname', 'en', 'Vendsyssel Historical Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(166, 'actor', 'VKH', 'fullname', 'en', 'Vejle Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(167, 'actor', 'VMÅ', 'fullname', 'en', 'Vesthimmerlands Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(168, 'actor', 'VSM', 'fullname', 'en', 'Viborg Museum', NULL, 0, '2017-01-25 13:01:03', 0, '0000-00-00 00:00:00', ''),
(180, 'file', '1', 'title', 'en', 'A File', NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(181, 'file', '1', 'description', 'en', 'A test file', NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(217, 'find', '1', 'description', 'da', 'Velbevaret, skjoldformet, orientalsk bæltebeslag med planteslyngsornamentik.', NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(218, 'find', '2', 'description', 'da', 'Hel pladefibel i gennembrudt arbejde med støbt, slynget, etfodet dyr i Mammen/ Ringerike stil. Over ryggen ses desuden en bladlignende vinge?\r\n\r\nForside: lettere korroderet\r\n\r\nBagside: ukendt', NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(219, 'find', '3', 'description', 'da', 'Hel, let bøjet men ellers velbevaret dirhem', NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(220, 'find', '4', 'description', 'da', 'Hel,velbevaret siliqua. RIC 102/133', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(221, 'find', '5', 'description', 'da', 'Hel pladefibel i gennembrudt arbejde. Overflade lettere korroderet, men motivet fremstår nogenlunde tydeligt. \r\n\r\nForside: Smykket viser en spydbevæbnet rytter til hest og en skjoldbærende, langskørtet person stående foran hesten, alle figurer i profil. Den stående figur rækker noget frem mod hest eller rytter og under hestens bug ses et ternet klæde? Herudover er der på både hest og begge figurer en række detaljer - bl.a. personernes påklædning og hår er meget detaljeret.\r\n\r\nBagside: Lokalt ses blanke områder som muligvis er fortinning. Øverst på fiblen på bagsiden af rytterens hoved ses et lodretstående øsken, som må have udgjort nålefæstet. Modsat ses de sidste rester af nåleholderen på bagsiden af hovedet af den stående kvinde. \r\n\r\nLignende men ikke helt identiske stykker kendes bl.a. fra flere nordjyske lokaliteter men også fra resten af landet bl.a. ved Tissø er der fundet et meget velbevaret eksemplar http://scienceblogs.com/aardvarchaeology/2013/01/07/valkyrie-figurine-from-harby/', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(222, 'find', '6', 'description', 'da', 'Rektangulær plade fra spænde som mangler. I venstre side af plade er noget knækket af – formentlig de flige som har holdt bøjlen. Pladen er smukt dekoreret med et bredt ansigt i velbevaret emalje. Huden er hvid, pupiller, læber og øre i rødt og de mandelformede øjne er i lighed med hår og tøjkraven i blåt.\r\n\r\nBagside: ukendt\r\n\r\nRef.: Næsten identisk parallel fundet i Lincolnshire – se PAS https://finds.org.uk/database/search/results/q/LIN_E64986', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(223, 'find', '7', 'description', 'da', 'Angelsaksiske-sydskandinavisk celleemaljefibel. Cirkulær med perlet rand - Frick type 1 var. 2. Stjerneformet motiv i celleemalje. Emaljen kun delvist bevaret. Cirkulært felt i centrum i rødt, stjernestrålerne i gult og halvbueformede felter langs rand i blåt?', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(224, 'find', '8', 'description', 'da', 'Hel velbevaret fuglefibel med fliget fiskehale og flot fortinning. På nær hovedet er fiblen flad i profil. Langs kanten er fiblen prydet med en række stempler og på kroppen ses ridser, som muligvis har været del af indridset ornamentik.', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(225, 'find', '9', 'description', 'da', 'Hel lille, let hvælvet blikfibel med delvist bevaret forgyldning. Cirkulær med afsat kant og et øsken ved randen. I centrum ses et lidt skævt ligebenet kors eller en blomst med fire spidse kronblade samlet i et uregelmæssigt, næsten kvadratisk midterfelt.', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(226, 'find', '10', 'description', 'da', 'Hel lille pladefibel.\r\n\r\nForside: Lettere korroderet overflade. Fiblen er prydet af støbt, fladedækkende slyngbånd indrammet af en markant, glat ramme. \r\n\r\nBagside: Meget korroderet. Nåleholderen, i form af en støbt, ombøjet flig placeret parallelt med fiblens længderetning, er helt bevaret. I modsatte ende ses de sidste rester af nålefæstet. Omkring sidstnævnte er overfladen rustfarvet.', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(227, 'find', '11', 'description', 'da', 'qqqqq', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_time` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_wkt`
--

CREATE TABLE IF NOT EXISTS `ark_fragment_wkt` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_fragment_wkt`
--

INSERT INTO `ark_fragment_wkt` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(18, 'find', '1', 'findpoint', '4326', 'POINT (9.727013 57.034633)', NULL, 0, '2017-01-29 20:42:24', 0, '2017-01-29 20:23:17', ''),
(19, 'find', '2', 'findpoint', '4326', 'POINT (9.740322 56.993769)', NULL, 0, '2017-01-29 20:45:58', 0, '2017-01-29 20:29:28', ''),
(20, 'find', '3', 'findpoint', '4326', 'POINT (9.968663 57.010178)', NULL, 0, '2017-01-29 20:46:25', 0, '2017-01-29 20:39:17', ''),
(21, 'find', '4', 'findpoint', '4326', 'POINT (9.973601 57.011353)', NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(22, 'find', '5', 'findpoint', '4326', 'POINT (9.975734 57.011713)', NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(23, 'find', '6', 'findpoint', '4326', 'POINT (10.181632 57.071948)', NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(24, 'find', '7', 'findpoint', '4326', 'POINT (10.044265 56.959717)', NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(25, 'find', '8', 'findpoint', '4326', 'POINT (9.740236 57.028384)', NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(26, 'find', '9', 'findpoint', '4326', 'POINT (9.740109 57.03276)', NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(27, 'find', '10', 'findpoint', '4326', 'POINT (10.012489 56.958308)', NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(28, 'find', '11', 'findpoint', '4326', 'POINT (1 1)', NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE IF NOT EXISTS `ark_item_actor` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('ARV', 'dime.actor', 'institution', '', '', 'ARV', 'ARV', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('BMR', 'dime.actor', 'institution', '', '', 'BMR', 'BMR', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('DKM', 'dime.actor', 'institution', '', '', 'DKM', 'DKM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('FHM', 'dime.actor', 'institution', '', '', 'FHM', 'FHM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('HBV', 'dime.actor', 'institution', '', '', 'HBV', 'HBV', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('HEM', 'dime.actor', 'institution', '', '', 'HEM', 'HEM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('HOM', 'dime.actor', 'institution', '', '', 'HOM', 'HOM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('KBM', 'dime.actor', 'institution', '', '', 'KBM', 'KBM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('KNV', 'dime.actor', 'institution', '', '', 'KNV', 'KNV', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MKH', 'dime.actor', 'institution', '', '', 'MKH', 'MKH', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MLF', 'dime.actor', 'institution', '', '', 'MLF', 'MLF', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MNS', 'dime.actor', 'institution', '', '', 'MNS', 'MNS', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MOE', 'dime.actor', 'institution', '', '', 'MOE', 'MOE', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MSA', 'dime.actor', 'institution', '', '', 'MSA', 'MSA', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MSJ', 'dime.actor', 'institution', '', '', 'MSJ', 'MSJ', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('MVE', 'dime.actor', 'institution', '', '', 'MVE', 'MVE', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('NJM', 'dime.actor', 'institution', '', '', 'NJM', 'NJM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('OBM', 'dime.actor', 'institution', '', '', 'OBM', 'OBM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('ØFM', 'dime.actor', 'institution', '', '', 'ØFM', 'ØFM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('ØHM', 'dime.actor', 'institution', '', '', 'ØHM', 'ØHM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('ROM', 'dime.actor', 'institution', '', '', 'ROM', 'ROM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('SBM', 'dime.actor', 'institution', '', '', 'SBM', 'SBM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('SJM', 'dime.actor', 'institution', '', '', 'SJM', 'SJM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('SKH', 'dime.actor', 'institution', '', '', 'SKH', 'SKH', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('TAK', 'dime.actor', 'institution', '', '', 'TAK', 'TAK', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('THY', 'dime.actor', 'institution', '', '', 'THY', 'THY', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('VHM', 'dime.actor', 'institution', '', '', 'VHM', 'VHM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('VKH', 'dime.actor', 'institution', '', '', 'VKH', 'VKH', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('VMÅ', 'dime.actor', 'institution', '', '', 'VMÅ', 'VMÅ', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('VSM', 'dime.actor', 'institution', '', '', 'VSM', 'VSM', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_campaign`
--

CREATE TABLE IF NOT EXISTS `ark_item_campaign` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE IF NOT EXISTS `ark_item_file` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_file`
--

INSERT INTO `ark_item_file` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'core.file', 'document', NULL, NULL, '1', '1', 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE IF NOT EXISTS `ark_item_find` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_find`
--

INSERT INTO `ark_item_find` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'dime.find', 'accessory', NULL, NULL, '1', '1', 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
('10', 'dime.find', 'fibula', NULL, NULL, '10', '10', 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
('2', 'dime.find', 'fibula', NULL, NULL, '2', '2', 0, '2017-01-29 20:45:58', 0, '2017-01-29 20:45:58', ''),
('3', 'dime.find', 'coin', NULL, NULL, '3', '3', 0, '2017-01-29 22:46:48', 0, '2017-01-29 22:46:48', ''),
('4', 'dime.find', 'coin', NULL, NULL, '4', '4', 0, '2017-01-29 22:48:31', 0, '2017-01-29 22:48:31', ''),
('5', 'dime.find', 'fibula', NULL, NULL, '5', '5', 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
('6', 'dime.find', 'accessory', NULL, NULL, '6', '6', 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
('7', 'dime.find', 'fibula', NULL, NULL, '7', '7', 0, '2017-01-29 21:01:00', 0, '2017-01-29 21:01:00', ''),
('8', 'dime.find', 'fibula', NULL, NULL, '8', '8', 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
('9', 'dime.find', 'fibula', NULL, NULL, '9', '9', 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_image`
--

CREATE TABLE IF NOT EXISTS `ark_item_image` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_locality`
--

CREATE TABLE IF NOT EXISTS `ark_item_locality` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_location`
--

CREATE TABLE IF NOT EXISTS `ark_item_location` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_location`
--

INSERT INTO `ark_item_location` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'dime.locality', NULL, NULL, NULL, '1', '1', 0, '2017-01-26 10:29:28', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_page`
--

CREATE TABLE IF NOT EXISTS `ark_item_page` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('about', 'core.page', '', NULL, NULL, 'about', 'about', 0, '2017-01-24 01:39:34', 0, '0000-00-00 00:00:00', ''),
('background', 'core.page', '', NULL, NULL, 'background', 'background', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', ''),
('detector', 'core.page', '', NULL, NULL, 'detector', 'detector', 0, '2017-01-24 01:39:44', 0, '0000-00-00 00:00:00', ''),
('exhibits', 'core.page', '', NULL, NULL, 'exhibits', 'exhibits', 0, '2017-01-24 09:06:29', 0, '0000-00-00 00:00:00', ''),
('news', 'core.page', '', NULL, NULL, 'news', 'news', 0, '2017-01-24 09:06:32', 0, '0000-00-00 00:00:00', ''),
('research', 'core.page', '', NULL, NULL, 'research', 'research', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', ''),
('treasure', 'core.page', '', NULL, NULL, 'treasure', 'treasure', 0, '2017-01-24 09:06:35', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_relation_xmi`
--

CREATE TABLE IF NOT EXISTS `ark_relation_xmi` (
`fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xmi_module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xmi_item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence`
--

CREATE TABLE IF NOT EXISTS `ark_sequence` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_sequence`
--

INSERT INTO `ark_sequence` (`module`, `parent`, `sequence`, `idx`, `min`, `max`) VALUES
('find', '', 'id', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_lock`
--

CREATE TABLE IF NOT EXISTS `ark_sequence_lock` (
`id` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `recycle` tinyint(1) NOT NULL DEFAULT '0',
  `locked_by` int(11) NOT NULL,
  `locked_on` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_reserve`
--

CREATE TABLE IF NOT EXISTS `ark_sequence_reserve` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_spatial_search`
--

CREATE TABLE IF NOT EXISTS `ark_spatial_search` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `geometry` geometry NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dime_communes`
--

CREATE TABLE IF NOT EXISTS `dime_communes` (
  `wkt` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `museum` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `museum_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commune_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marnint` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commune` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_dataclass_member`
--
ALTER TABLE `ark_dataclass_member`
 ADD PRIMARY KEY (`object_fid`,`module`,`item`,`property`,`member`,`member_fid`);

--
-- Indexes for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
 ADD PRIMARY KEY (`fid`), ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
 ADD PRIMARY KEY (`fid`), ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
 ADD PRIMARY KEY (`fid`), ADD KEY `item` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_wkt`
--
ALTER TABLE `ark_fragment_wkt`
 ADD PRIMARY KEY (`fid`), ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_campaign`
--
ALTER TABLE `ark_item_campaign`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
 ADD PRIMARY KEY (`id`), ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE, ADD KEY `name` (`label`(191)) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_image`
--
ALTER TABLE `ark_item_image`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_locality`
--
ALTER TABLE `ark_item_locality`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_location`
--
ALTER TABLE `ark_item_location`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`label`) USING BTREE, ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`), ADD KEY `xmi_module` (`xmi_module`,`xmi_item`);

--
-- Indexes for table `ark_sequence`
--
ALTER TABLE `ark_sequence`
 ADD PRIMARY KEY (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ark_sequence_reserve`
--
ALTER TABLE `ark_sequence_reserve`
 ADD PRIMARY KEY (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_spatial_search`
--
ALTER TABLE `ark_spatial_search`
 ADD PRIMARY KEY (`fid`), ADD KEY `module` (`module`,`item`,`property`), ADD SPATIAL KEY `geometry` (`geometry`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=558;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=228;
--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_wkt`
--
ALTER TABLE `ark_fragment_wkt`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
