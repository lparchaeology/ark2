-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 23, 2017 at 12:39 AM
-- Server version: 10.0.22-MariaDB
-- PHP Version: 7.0.14

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
(1, 'find', '1', 'finddate', NULL, '2017-01-01', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '');

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
(1, 'find', '1', 'weight', 'g', '123.4', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(2, 'find', '1', 'length', 'm', '1.23', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '');

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
(1, 'find', '1', 'material', 'dime.material', 'au', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(2, 'find', '1', 'secondary', 'dime.material', 'fe', NULL, 0, '2017-01-20 14:08:36', 0, '0000-00-00 00:00:00', ''),
(3, 'find', '1', 'secondary', 'dime.material', 'pb', NULL, 0, '2017-01-20 14:08:34', 0, '0000-00-00 00:00:00', ''),
(4, 'find', '1', 'secondary', 'dime.material', 'al', NULL, 0, '2017-01-20 14:08:33', 0, '0000-00-00 00:00:00', ''),
(5, 'find', '1', 'period_start', 'dime.period', 'AYTX', NULL, 0, '2017-01-20 14:07:53', 0, '0000-00-00 00:00:00', ''),
(6, 'find', '1', 'period_end', 'dime.period', 'AYGX', NULL, 0, '2017-01-20 14:08:00', 0, '0000-00-00 00:00:00', ''),
(7, 'find', '2', 'material', 'dime.material', 'fe', NULL, 0, '2017-01-20 14:08:22', 0, '0000-00-00 00:00:00', ''),
(8, 'find', '3', 'material', 'dime.material', 'pb', NULL, 0, '2017-01-20 14:08:31', 0, '0000-00-00 00:00:00', ''),
(9, 'find', '1', 'type', 'dime.find.type', 'coin', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(10, 'find', '2', 'type', 'dime.find.type', 'fibula', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(11, 'find', '3', 'type', 'dime.find.type', 'coin', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(12, 'find', '1', 'id', '', '1', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(13, 'find', '2', 'id', '', '2', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', ''),
(14, 'find', '3', 'id', '', '3', NULL, 0, '2017-01-20 14:08:29', 0, '0000-00-00 00:00:00', '');

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
(1, 'find', '1', 'name', 'en', 'My find number one', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(3, 'find', '2', 'name', 'en', 'My find number two', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(5, 'find', '3', 'name', 'en', 'My find number two', NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(7, 'find', '1', 'description', 'en', 'A multiline description\\n\\nA multiline description\\n\\nA multiline description\\n\\nA multiline description', NULL, 0, '2017-01-17 17:04:13', 0, '0000-00-00 00:00:00', ''),
(8, 'find', '1', 'title', 'en', 'Find 1 title', NULL, 0, '2017-01-20 00:39:58', 0, '0000-00-00 00:00:00', ''),
(9, 'find', '2', 'title', 'en', 'Find 2 title', NULL, 0, '2017-01-20 00:40:07', 0, '0000-00-00 00:00:00', ''),
(10, 'find', '3', 'title', 'en', 'Find 3 title', NULL, 0, '2017-01-10 10:28:56', 0, '0000-00-00 00:00:00', '');

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
('3', 'dime.find', 'coin', NULL, NULL, '3', '3', 0, '2017-01-20 14:00:36', 0, '0000-00-00 00:00:00', '');

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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
