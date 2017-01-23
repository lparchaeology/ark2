-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Generation Time: Jan 23, 2017 at 11:22 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `ark_dataclass_member`
--

CREATE TABLE `ark_dataclass_member` (
  `object_fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `member` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `member_fid` int(11) NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_blob`
--

CREATE TABLE `ark_fragment_blob` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_boolean`
--

CREATE TABLE `ark_fragment_boolean` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_date`
--

CREATE TABLE `ark_fragment_date` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_date`
--

INSERT INTO `ark_fragment_date` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'finddate', NULL, '2021-01-04', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(2, 'find', '2', 'finddate', NULL, '2012-01-01', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(3, 'find', '3', 'finddate', NULL, '2015-09-04', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(5, 'find', '', 'finddate', NULL, '2017-01-23', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(7, 'find', '8', 'finddate', NULL, '2017-01-23', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(8, 'find', '9', 'finddate', NULL, '2017-01-23', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_datetime`
--

CREATE TABLE `ark_fragment_datetime` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE `ark_fragment_decimal` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_decimal`
--

INSERT INTO `ark_fragment_decimal` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'weight', 'g', '777', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(2, 'find', '1', 'length', 'm', '555', NULL, 0, '2017-01-23 20:24:32', 0, '0000-00-00 00:00:00', ''),
(3, 'find', '2', 'weight', 'g', '777', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:19:53', ''),
(4, 'find', '2', 'length', 'km', '111', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:19:53', ''),
(5, 'find', '3', 'weight', 'kg', '555', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(6, 'find', '3', 'length', 'µm', '666', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(9, 'find', '', 'weight', 'kg', '1', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(10, 'find', '', 'length', 'm', '4', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(13, 'find', '8', 'weight', 'kg', '1', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(14, 'find', '8', 'length', 'm', '5', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(15, 'find', '9', 'weight', 'µg', '1', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(16, 'find', '9', 'length', 'nm', '6', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_float`
--

CREATE TABLE `ark_fragment_float` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_geometry`
--

CREATE TABLE `ark_fragment_geometry` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_integer`
--

CREATE TABLE `ark_fragment_integer` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE `ark_fragment_item` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE `ark_fragment_object` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_string`
--

CREATE TABLE `ark_fragment_string` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'material', 'dime.material', 'zz', NULL, 0, '2017-01-23 18:03:41', 0, '0000-00-00 00:00:00', ''),
(5, 'find', '1', 'period_start', 'dime.period', 'AYTM', NULL, 0, '2017-01-23 18:03:41', 0, '0000-00-00 00:00:00', ''),
(6, 'find', '1', 'period_end', 'dime.period', 'CXXX', NULL, 0, '2017-01-23 18:03:41', 0, '0000-00-00 00:00:00', ''),
(7, 'find', '2', 'material', 'dime.material', 'niello', NULL, 0, '2017-01-23 20:19:53', 0, '0000-00-00 00:00:00', ''),
(8, 'find', '3', 'material', 'dime.material', 'niello', NULL, 0, '2017-01-23 20:22:09', 0, '0000-00-00 00:00:00', ''),
(9, 'find', '1', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(10, 'find', '2', 'type', 'dime.find.type', 'tool', NULL, 0, '2017-01-23 20:19:53', 0, '0000-00-00 00:00:00', ''),
(11, 'find', '3', 'type', 'dime.find.type', 'coin', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(12, 'find', '1', 'id', '', '1', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(13, 'find', '2', 'id', '', '2', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(14, 'find', '3', 'id', '', '3', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(15, 'find', '1', 'finder_id', NULL, '123xxx', NULL, 0, '2017-01-23 18:03:41', 0, '2017-01-23 15:36:56', ''),
(16, 'find', '1', 'subtype', NULL, '123xxx', NULL, 0, '2017-01-23 18:03:41', 0, '2017-01-23 15:36:56', ''),
(44, 'find', '2', 'finder_id', NULL, '12343tryreytr', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(45, 'find', '2', 'subtype', NULL, 'rteyerty', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(46, 'find', '2', 'period_start', 'dime.period', 'AYGX', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(47, 'find', '2', 'period_end', 'dime.period', 'XXXX', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(60, 'find', '2', 'secondary', 'dime.material', 'stone', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(61, 'find', '2', 'secondary', 'dime.material', 'xx', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(62, 'find', '2', 'secondary', 'dime.material', 'zz', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(63, 'find', '2', 'secondary', 'dime.material', 'cu', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(64, 'find', '2', 'secondary', 'dime.material', 'cual', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(65, 'find', '2', 'secondary', 'dime.material', 'fe', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(66, 'find', '2', 'secondary', 'dime.material', 'glass', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(67, 'find', '2', 'secondary', 'dime.material', 'niello', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(68, 'find', '2', 'secondary', 'dime.material', 'pb', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(69, 'find', '2', 'secondary', 'dime.material', 'ag', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(70, 'find', '2', 'secondary', 'dime.material', 'al', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(71, 'find', '2', 'secondary', 'dime.material', 'au', NULL, 0, '2017-01-23 20:20:20', 0, '2017-01-23 20:20:20', ''),
(72, 'find', '3', 'finder_id', NULL, '123456', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(73, 'find', '3', 'subtype', NULL, 'sss', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(74, 'find', '3', 'period_start', 'dime.period', 'AÆBX', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(75, 'find', '3', 'period_end', 'dime.period', 'AMXX', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(76, 'find', '3', 'secondary', 'dime.material', 'au', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(77, 'find', '3', 'secondary', 'dime.material', 'gem', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(78, 'find', '3', 'secondary', 'dime.material', 'sa', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(86, 'find', '1', 'secondary', 'dime.material', 'fe', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(87, 'find', '1', 'secondary', 'dime.material', 'pb', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(88, 'find', '1', 'secondary', 'dime.material', 'al', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(89, 'find', '1', 'secondary', 'dime.material', 'ag', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(90, 'find', '1', 'secondary', 'dime.material', 'niello', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(91, 'find', '1', 'secondary', 'dime.material', 'zz', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(92, 'find', '1', 'secondary', 'dime.material', 'cual', NULL, 0, '2017-01-23 20:24:32', 0, '2017-01-23 20:24:32', ''),
(97, 'find', '', 'finder_id', NULL, 'fff', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(98, 'find', '', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(99, 'find', '', 'subtype', NULL, 'bbb', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(100, 'find', '', 'period_start', 'dime.period', 'AÆAX', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(101, 'find', '', 'period_end', 'dime.period', 'AÆEM', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(102, 'find', '', 'material', 'dime.material', 'cu', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(106, 'find', '8', 'type', 'dime.find.type', 'accessory', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(107, 'find', '8', 'subtype', NULL, 'rty', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(108, 'find', '8', 'material', 'dime.material', 'cu', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(109, 'find', '', 'secondary', 'dime.material', 'au', NULL, 0, '2017-01-23 22:20:03', 0, '2017-01-23 22:20:03', ''),
(110, 'find', '', 'secondary', 'dime.material', 'gem', NULL, 0, '2017-01-23 22:20:03', 0, '2017-01-23 22:20:03', ''),
(111, 'find', '', 'secondary', 'dime.material', 'sa', NULL, 0, '2017-01-23 22:20:03', 0, '2017-01-23 22:20:03', ''),
(112, 'find', '9', 'type', 'dime.find.type', 'military', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(113, 'find', '9', 'subtype', NULL, 'dfsdfsdf', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(114, 'find', '9', 'period_start', 'dime.period', 'AÆEÆ', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(115, 'find', '9', 'material', 'dime.material', 'xx', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(119, 'find', '9', 'secondary', 'dime.material', 'cu', NULL, 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', ''),
(120, 'find', '9', 'secondary', 'dime.material', 'niello', NULL, 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', ''),
(121, 'find', '9', 'secondary', 'dime.material', 'stone', NULL, 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', ''),
(122, 'find', '9', 'secondary', 'dime.material', 'al', NULL, 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', ''),
(123, 'find', '9', 'secondary', 'dime.material', 'au', NULL, 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE `ark_fragment_text` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `parameter`, `value`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'name', 'eka', 'My find number one', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(3, 'find', '2', 'name', 'ebu', 'My find number two', NULL, 0, '2017-01-23 20:19:53', 0, '0000-00-00 00:00:00', ''),
(5, 'find', '3', 'name', 'en', 'My find number two', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(7, 'find', '1', 'description', 'en', 'qwe\\r\\n\\r\\nqsdr\\r\\n\\r\\ngty\\r\\n\\r\\n\\r\\nqwe\\r\\n\\r\\nqwe\\r\\n\\r\\nqwe', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(8, 'find', '1', 'title', 'eka', 'xxxFind 1 titlexxxrrr', NULL, 0, '2017-01-23 20:24:20', 0, '0000-00-00 00:00:00', ''),
(9, 'find', '2', 'title', 'myv', 'Find 2 some', NULL, 0, '2017-01-23 20:19:53', 0, '0000-00-00 00:00:00', ''),
(10, 'find', '3', 'title', 'en', 'Find 3 title', NULL, 0, '2017-01-10 10:28:56', 0, '0000-00-00 00:00:00', ''),
(11, 'page', 'about', 'content', 'da', '<h2>Om DIME</h2>\r\n\r\n<p>DIME står for ”Digitale Metaldetektorfund” og er en brugerdrevet platform til registrering af metaldetektorfund til brug i formidling, forskning og forvaltning.</p>\r\n\r\n<p>Ideen bag DIME er, at den skal:\r\n<ul><li>øge inddragelse af metaldetektorbrugerne i det museale arbejde</li>\r\n<li>øge og skærpe samarbejdet mellem metaldetektorbrugere og museer</li>\r\n<li>lette arbejdsbyrden vedr. fundregistrering og danefæbehandling på museerne</li>\r\n<li>muliggøre en hurtig behandling af Danefæ</li>\r\n<li>muliggøre en ensartet registreringspraksis landet over</li>\r\n<li>optimere tilgængeligheden af information om metaldetektorfundene til forskningsbrug</li>\r\n<li>fungere som indgang for indberetning af fund til centrale, museale databaser (SARA mfl.)</li></ul>\r\n</p>\r\n\r\n<h3>Baggrunden for DIME</h3>\r\n\r\n<p>Hvert år finder frivillige metaldetektorbrugere på danske marker i 1000vis af fund af stor kulturhistorisk betydning. De bidrager løbende til fremkomsten af nogle af de mest opsigtsvækkende fund i dansk arkæologi, og metaldetektorfundene har i mange henseender revolutioneret vor forståelse af de forhistoriske og historiske samfund fra bronzealder til nyere tid. Dansk metaldetektorarkæologi har på den baggrund udviklet sig til en unik og internationalt anerkendt succeshistorie, som forener de bedste sider af den danske model med en bred folkelig involvering i det arkæologiske arbejde og en decentral museumsstruktur. Men den kolossale tilvækst af indkomne fund har i stigende grad tydeliggjort behovet for en samlet registrering af metaldetektorfundene, idet kun en brøkdel af de mange fund er tilgængelige for offentligheden, museerne og for forskningen. DIME er udviklet med henblik på at muliggøre optimal udnyttelse af metaldetektorfundenes store formidlings- og forskningsmæssige potentiale.</p>\r\n\r\n<h3>Udviklingen af DIME</h3>\r\n\r\n<p>DIME-databasen blev udviklet i 2016-2017 af en gruppe museumsfolk og universitetsarkæologer i tæt samarbejde med detektorbrugere og et bredt panel fagfolk fra museer landet over. DIME er således udviklet af brugere for brugere, og under udformning af databasen har udviklerne bl.a. kunne støtte sig til:\r\n<ul><li>Interview af 27 museumsmedarbejder (fra 27 forskellige museer) om praksis og erfaringer med fundregistrering og krav til en evt. databaseløsning</li>\r\n<li>Online spørgeskema blandt detektorfolk om praksis og ønsker til fundregistrering (168 besvarelser)</li>\r\n<li>Fokusgruppeinterview med udvalgte detektorfolk</li></ul>\r\n</p>\r\n\r\n<p>DIME er udviklet af følgende institutioner:\r\n<li>Aarhus Universitet</li>\r\n<li>Moesgaard Museum</li>\r\n<li>Nordjyllands Historiske Museum</li>\r\n<li>Odense Bys Museer</li>\r\n</p>\r\n\r\n<p>Udvikling af DIME blev muliggjort med økonomisk støtte fra KROGAGERFONDEN</p>\r\n', NULL, 0, '2017-01-10 10:28:56', 0, '0000-00-00 00:00:00', '');
(12, 'find', '2', 'description', 'ab', 'fsdgsdfgsfdg', NULL, 0, '2017-01-23 20:19:53', 0, '2017-01-23 20:19:53', ''),
(13, 'find', '3', 'description', 'cr', 'qqq\\r\\n\\r\\nrrr\\r\\n\\r\\nuuu', NULL, 0, '2017-01-23 20:22:09', 0, '2017-01-23 20:22:09', ''),
(14, 'find', '', 'title', 'en', 'qqq', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(15, 'find', '', 'name', 'en', 'eee', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(16, 'find', '', 'description', 'en', 'fgsfdgsdfgsdfg\\r\\n\\r\\nsfdgsdfgsdfgsdfg', NULL, 0, '2017-01-23 22:07:00', 0, '2017-01-23 22:07:00', ''),
(17, 'find', '8', 'title', 'en', 'sss', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(18, 'find', '8', 'name', 'en', 'eee', NULL, 0, '2017-01-23 22:18:24', 0, '2017-01-23 22:17:17', ''),
(19, 'find', '8', 'description', 'en', 'gfdgdsfgsdfg', NULL, 0, '2017-01-23 22:17:17', 0, '2017-01-23 22:17:17', ''),
(20, 'find', '9', 'title', 'en', 'dfgfsdg', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(21, 'find', '9', 'name', 'en', 'dfsgsdfg', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', ''),
(22, 'find', '9', 'description', 'en', 'jfhjfghjfghj', NULL, 0, '2017-01-23 22:20:52', 0, '2017-01-23 22:20:52', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE `ark_fragment_time` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE `ark_item_actor` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'core.actor', 'person', NULL, NULL, '1', '1', 0, '2017-01-20 14:01:52', 0, '0000-00-00 00:00:00', ''),
('2', 'core.actor', 'person', NULL, NULL, '2', '2', 0, '2017-01-20 14:02:05', 0, '0000-00-00 00:00:00', ''),
('3', 'core.actor', 'person', NULL, NULL, '3', '3', 0, '2017-01-20 14:02:09', 0, '0000-00-00 00:00:00', ''),
('4', 'core.actor', 'person', NULL, NULL, '4', '4', 0, '2017-01-20 14:02:11', 0, '0000-00-00 00:00:00', ''),
('5', 'core.actor', 'institution', NULL, NULL, '5', '5', 0, '2017-01-20 14:02:14', 0, '0000-00-00 00:00:00', ''),
('6', 'core.actor', 'institution', NULL, NULL, '6', '6', 0, '2017-01-20 14:01:57', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_campaign`
--

CREATE TABLE `ark_item_campaign` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE `ark_item_file` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_find`
--

INSERT INTO `ark_item_find` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'dime.find', 'coin', NULL, NULL, '1', '1', 0, '2017-01-20 13:58:46', 0, '0000-00-00 00:00:00', ''),
('2', 'dime.find', 'fibula', NULL, NULL, '2', '2', 0, '2017-01-20 14:00:32', 0, '0000-00-00 00:00:00', ''),
('3', 'dime.find', 'coin', NULL, NULL, '3', '3', 0, '2017-01-20 14:00:36', 0, '0000-00-00 00:00:00', ''),
('8', 'dime.find', 'accessory', NULL, NULL, '8', '8', 0, '2017-01-23 22:18:24', 0, '2017-01-23 22:18:24', ''),
('9', 'dime.find', 'military', NULL, NULL, '9', '9', 0, '2017-01-23 22:21:30', 0, '2017-01-23 22:21:30', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_image`
--

CREATE TABLE `ark_item_image` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_location`
--

CREATE TABLE `ark_item_location` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_location`
--

INSERT INTO `ark_item_location` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'dime.location', NULL, NULL, NULL, '1', '1', 0, '2017-01-11 11:36:01', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_page`
--

CREATE TABLE `ark_item_page` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`id`, `schma`, `type`, `parent_module`, `parent_id`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('about', 'core.page', '', NULL, NULL, 'about', 'about', 0, '2017-01-24 01:39:34', 0, '0000-00-00 00:00:00', ''),
('detector', 'core.page', '', NULL, NULL, 'detector', 'detector', 0, '2017-01-24 01:39:44', 0, '0000-00-00 00:00:00', ''),
('exhibits', 'core.page', NULL, NULL, NULL, 'exhibits', 'exhibits', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('news', 'core.page', NULL, NULL, NULL, 'news', 'news', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('research', 'core.page', NULL, NULL, NULL, 'research', 'research', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_relation_xmi`
--

CREATE TABLE `ark_relation_xmi` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `xmi_module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `xmi_item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence`
--

CREATE TABLE `ark_sequence` (
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_sequence`
--

INSERT INTO `ark_sequence` (`module`, `parent`, `sequence`, `idx`, `min`, `max`) VALUES
('find', '', 'id', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_lock`
--

CREATE TABLE `ark_sequence_lock` (
  `id` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `recycle` tinyint(1) NOT NULL DEFAULT '0',
  `locked_by` int(11) NOT NULL,
  `locked_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_sequence_lock`
--

INSERT INTO `ark_sequence_lock` (`id`, `module`, `parent`, `sequence`, `idx`, `recycle`, `locked_by`, `locked_on`) VALUES
(2, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(3, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(4, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(5, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00'),
(6, 'find', '', 'id', 1, 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_reserve`
--

CREATE TABLE `ark_sequence_reserve` (
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_spatial_search`
--

CREATE TABLE `ark_spatial_search` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `geometry` geometry NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_geometry`
--
ALTER TABLE `ark_fragment_geometry`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`attribute`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_campaign`
--
ALTER TABLE `ark_item_campaign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE,
  ADD KEY `name` (`label`) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_image`
--
ALTER TABLE `ark_item_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_location`
--
ALTER TABLE `ark_item_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`),
  ADD KEY `xmi_module` (`xmi_module`,`xmi_item`);

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
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`),
  ADD SPATIAL KEY `geometry` (`geometry`);

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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_geometry`
--
ALTER TABLE `ark_fragment_geometry`
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_relation_xmi`
--
ALTER TABLE `ark_relation_xmi`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
