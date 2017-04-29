-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 29, 2017 at 09:07 PM
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
-- Table structure for table `ark_association`
--

CREATE TABLE `ark_association` (
  `fid` int(11) NOT NULL,
  `module1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_blob`
--

CREATE TABLE `ark_fragment_blob` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blob',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `span` longblob,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_boolean`
--

CREATE TABLE `ark_fragment_boolean` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'boolean',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `span` tinyint(1) DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_date`
--

CREATE TABLE `ark_fragment_date` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'date',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `span` date DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_date`
--

INSERT INTO `ark_fragment_date` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(30, 'find', '1', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(31, 'find', '2', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(32, 'find', '3', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(33, 'find', '4', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(34, 'find', '5', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(35, 'find', '6', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(36, 'find', '7', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(37, 'find', '8', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(38, 'find', '9', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(39, 'find', '10', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(40, 'find', '11', 'finddate', 'date', '', NULL, '2017-01-29', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(41, 'find', '11', 'finddate', 'date', '', NULL, '2017-01-30', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(42, 'find', '12', 'finddate', 'date', '', NULL, '2017-01-30', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(43, 'find', '13', 'finddate', 'date', '', NULL, '2017-01-30', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(44, 'find', '14', 'finddate', 'date', '', NULL, '2017-01-31', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_datetime`
--

CREATE TABLE `ark_fragment_datetime` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'datetime',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `span` datetime DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_datetime`
--

INSERT INTO `ark_fragment_datetime` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'message', '1', 'sent_at', 'datetime', NULL, NULL, '2017-03-14 00:00:00', NULL, NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(2, 'message', '2', 'sent_at', 'datetime', NULL, NULL, '2017-03-02 00:00:00', NULL, NULL, 0, '2017-03-27 11:58:35', 0, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE `ark_fragment_decimal` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'decimal',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_decimal`
--

INSERT INTO `ark_fragment_decimal` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(50, 'find', '1', 'length', 'decimal', '', 'mm', '22', NULL, NULL, 0, '2017-01-29 20:24:17', 0, '2017-01-29 20:23:17', ''),
(51, 'find', '2', 'length', 'decimal', '', 'mm', '31', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(52, 'find', '3', 'length', 'decimal', '', 'mm', '22', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(53, 'find', '4', 'length', 'decimal', '', 'mm', '20', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(54, 'find', '5', 'length', 'decimal', '', 'mm', '31', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(55, 'find', '6', 'length', 'decimal', '', 'mm', '31', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(56, 'find', '7', 'length', 'decimal', '', 'mm', '36', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(57, 'find', '8', 'length', 'decimal', '', 'mm', '60', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(58, 'find', '9', 'length', 'decimal', '', 'mm', '19', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(59, 'find', '10', 'length', 'decimal', '', 'mm', '30', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(60, 'find', '11', 'length', 'decimal', '', 'm', '1', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(61, 'find', '11', 'length', 'decimal', '', 'mm', '34', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(62, 'find', '12', 'weight', 'decimal', '', 't', '10', NULL, NULL, 0, '2017-01-30 10:36:35', 0, '2017-01-30 10:35:09', ''),
(63, 'find', '12', 'length', 'decimal', '', 'm', '15.2', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(64, 'find', '13', 'weight', 'decimal', '', 'g', '34', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(65, 'find', '13', 'length', 'decimal', '', 'mm', '123', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(66, 'find', '14', 'weight', 'decimal', '', 'g', '10', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(67, 'find', '14', 'length', 'decimal', '', 'mm', '70', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_float`
--

CREATE TABLE `ark_fragment_float` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'float',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `span` double DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_integer`
--

CREATE TABLE `ark_fragment_integer` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'integer',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `span` bigint(20) DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE `ark_fragment_item` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'item',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_item`
--

INSERT INTO `ark_fragment_item` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(1, 'find', '1', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(2, 'find', '2', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(3, 'find', '3', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(4, 'find', '4', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(5, 'find', '5', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(6, 'find', '6', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(7, 'find', '7', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(8, 'find', '8', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(9, 'find', '9', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(10, 'find', '10', 'museum', 'item', '', 'actor', 'NJM', '', NULL, 0, '2017-01-29 22:41:15', 0, '2017-01-29 22:37:39', ''),
(11, 'find', '1', 'custodian', 'item', '', 'actor', 'ahavfrue', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(12, 'find', '1', 'owner', 'item', '', 'actor', 'ahavfrue', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(13, 'find', '1', 'finder', 'item', '', 'actor', 'ahavfrue', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(14, 'message', '1', 'sender', 'item', '', 'actor', 'ahavfrue', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', ''),
(15, 'message', '2', 'sender', 'item', '', 'actor', 'ahavfrue', '', NULL, 0, '2017-01-29 22:41:12', 0, '2017-01-29 22:37:39', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE `ark_fragment_object` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'object',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_spatial`
--

CREATE TABLE `ark_fragment_spatial` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'spatial',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` longtext COLLATE utf8mb4_unicode_ci,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_fragment_spatial`
--

INSERT INTO `ark_fragment_spatial` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(18, 'find', '1', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.727013 57.034633)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:23:17', ''),
(19, 'find', '2', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.740322 56.993769)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:29:28', ''),
(20, 'find', '3', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.968663 57.010178)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:39:17', ''),
(21, 'find', '4', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.973601 57.011353)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:44:41', ''),
(22, 'find', '5', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.975734 57.011713)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:50:43', ''),
(23, 'find', '6', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (10.181632 57.071948)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 20:53:52', ''),
(24, 'find', '7', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (10.044265 56.959717)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 21:00:51', ''),
(25, 'find', '8', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.740236 57.028384)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 21:03:54', ''),
(26, 'find', '9', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (9.740109 57.03276)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 21:07:02', ''),
(27, 'find', '10', 'findpoint', 'spatial', 'wkt', 'EPSG:4326', 'POINT (10.012489 56.958308)', NULL, NULL, 0, '2017-02-15 15:12:31', 0, '2017-01-29 21:09:38', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_string`
--

CREATE TABLE `ark_fragment_string` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(168, 'actor', 'ARV', 'id', 'string', '', '', 'ARV', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(169, 'actor', 'BMR', 'id', 'string', '', '', 'BMR', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(170, 'actor', 'DKM', 'id', 'string', '', '', 'DKM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(171, 'actor', 'FHM', 'id', 'string', '', '', 'FHM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(172, 'actor', 'HBV', 'id', 'string', '', '', 'HBV', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(173, 'actor', 'HEM', 'id', 'string', '', '', 'HEM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(174, 'actor', 'HOM', 'id', 'string', '', '', 'HOM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(175, 'actor', 'KBM', 'id', 'string', '', '', 'KBM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(176, 'actor', 'KNV', 'id', 'string', '', '', 'KNV', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(177, 'actor', 'MKH', 'id', 'string', '', '', 'MKH', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(178, 'actor', 'MLF', 'id', 'string', '', '', 'MLF', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(179, 'actor', 'MNS', 'id', 'string', '', '', 'MNS', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(180, 'actor', 'MOE', 'id', 'string', '', '', 'MOE', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(181, 'actor', 'MSA', 'id', 'string', '', '', 'MSA', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(182, 'actor', 'MSJ', 'id', 'string', '', '', 'MSJ', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(183, 'actor', 'MVE', 'id', 'string', '', '', 'MVE', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(184, 'actor', 'NJM', 'id', 'string', '', '', 'NJM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(185, 'actor', 'OBM', 'id', 'string', '', '', 'OBM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(186, 'actor', 'ØFM', 'id', 'string', '', '', 'ØFM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(187, 'actor', 'ØHM', 'id', 'string', '', '', 'ØHM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(188, 'actor', 'ROM', 'id', 'string', '', '', 'ROM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(189, 'actor', 'SBM', 'id', 'string', '', '', 'SBM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(190, 'actor', 'SJM', 'id', 'string', '', '', 'SJM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(191, 'actor', 'SKH', 'id', 'string', '', '', 'SKH', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(192, 'actor', 'TAK', 'id', 'string', '', '', 'TAK', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(193, 'actor', 'THY', 'id', 'string', '', '', 'THY', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(194, 'actor', 'VHM', 'id', 'string', '', '', 'VHM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(195, 'actor', 'VKH', 'id', 'string', '', '', 'VKH', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(196, 'actor', 'VMÅ', 'id', 'string', '', '', 'VMÅ', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(197, 'actor', 'VSM', 'id', 'string', '', '', 'VSM', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(198, 'actor', 'ARV', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(199, 'actor', 'BMR', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(200, 'actor', 'DKM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(201, 'actor', 'FHM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(202, 'actor', 'HBV', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(203, 'actor', 'HEM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(204, 'actor', 'HOM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(205, 'actor', 'KBM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(206, 'actor', 'KNV', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(207, 'actor', 'MKH', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(208, 'actor', 'MLF', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(209, 'actor', 'MNS', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(210, 'actor', 'MOE', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(211, 'actor', 'MSA', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(212, 'actor', 'MSJ', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(213, 'actor', 'MVE', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(214, 'actor', 'NJM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(215, 'actor', 'OBM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(216, 'actor', 'ØFM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(217, 'actor', 'ØHM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(218, 'actor', 'ROM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(219, 'actor', 'SBM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(220, 'actor', 'SJM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(221, 'actor', 'SKH', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(222, 'actor', 'TAK', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(223, 'actor', 'THY', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(224, 'actor', 'VHM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(225, 'actor', 'VKH', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(226, 'actor', 'VMÅ', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(227, 'actor', 'VSM', 'type', 'string', '', 'dime.actor.type', 'museum', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(244, 'file', '1', 'id', 'string', '', NULL, '1', NULL, NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
(245, 'file', '1', 'type', 'string', '', 'core.file.type', 'text', NULL, NULL, 0, '2017-01-25 19:46:09', 0, '0000-00-00 00:00:00', ''),
(246, 'file', '1', 'mediatype', 'string', '', NULL, 'text/plain', NULL, NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(247, 'file', '1', 'status', 'string', '', 'core.file.status', 'new', NULL, NULL, 0, '2017-01-25 19:46:09', 0, '2017-01-25 19:46:09', ''),
(250, 'locality', '1', 'id', 'string', '', NULL, '1', NULL, NULL, 0, '2017-01-26 14:33:48', 0, '2017-01-26 14:33:48', ''),
(251, 'locality', '1', 'type', 'string', '', NULL, 'test', NULL, NULL, 0, '2017-01-26 22:43:27', 0, '2017-01-26 14:33:48', ''),
(252, 'locality', '2', 'id', 'string', '', NULL, '2', NULL, NULL, 0, '2017-01-26 14:34:15', 0, '2017-01-26 14:34:15', ''),
(253, 'locality', '2', 'type', 'string', '', NULL, 'test', NULL, NULL, 0, '2017-01-26 14:34:15', 0, '2017-01-26 14:34:15', ''),
(281, 'locality', '3', 'id', 'string', '', NULL, '3', NULL, NULL, 0, '2017-01-26 22:21:34', 0, '2017-01-26 22:21:34', ''),
(282, 'locality', '3', 'type', 'string', '', NULL, 'hgfdhdg', NULL, NULL, 0, '2017-01-26 22:21:34', 0, '2017-01-26 22:21:34', ''),
(288, 'actor', 'KBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '101', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(289, 'actor', 'KBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '147', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(290, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '151', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(291, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '153', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(292, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '155', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(293, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '157', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(294, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '159', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(295, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '161', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(296, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '163', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(297, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '165', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(298, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '167', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(299, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '169', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(300, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '173', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(301, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '175', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(302, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '183', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(303, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '185', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(304, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '187', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(305, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '190', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(306, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '201', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(307, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '210', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(308, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '217', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(309, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '219', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(310, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '223', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(311, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '230', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(312, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.kommune', '240', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(313, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.kommune', '250', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(314, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '253', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(315, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '259', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(316, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '260', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(317, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.kommune', '265', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(318, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '269', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(319, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.kommune', '270', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(320, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '306', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(321, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '316', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(322, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '320', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(323, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '326', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(324, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '329', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(325, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '330', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(326, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '336', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(327, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.kommune', '340', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(328, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.kommune', '350', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(329, 'actor', 'MLF', 'kommuner', 'string', '', 'dime.denmark.kommune', '360', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(330, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '370', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(331, 'actor', 'MLF', 'kommuner', 'string', '', 'dime.denmark.kommune', '376', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(332, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.kommune', '390', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(333, 'actor', 'BMR', 'kommuner', 'string', '', 'dime.denmark.kommune', '400', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(334, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '410', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(335, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '420', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(336, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '430', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(337, 'actor', 'ØFM', 'kommuner', 'string', '', 'dime.denmark.kommune', '440', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(338, 'actor', 'ØFM', 'kommuner', 'string', '', 'dime.denmark.kommune', '450', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(339, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '461', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(340, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '479', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(341, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '480', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(342, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '482', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(343, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '492', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(344, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.kommune', '510', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(345, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '530', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(346, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.kommune', '540', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(347, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.kommune', '550', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(348, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '561', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(349, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '563', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(350, 'actor', 'ARV', 'kommuner', 'string', '', 'dime.denmark.kommune', '573', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(351, 'actor', 'HBV', 'kommuner', 'string', '', 'dime.denmark.kommune', '575', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(352, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.kommune', '580', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(353, 'actor', 'VKH', 'kommuner', 'string', '', 'dime.denmark.kommune', '607', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(354, 'actor', 'HOM', 'kommuner', 'string', '', 'dime.denmark.kommune', '615', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(355, 'actor', 'MKH', 'kommuner', 'string', '', 'dime.denmark.kommune', '621', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(356, 'actor', 'VKH', 'kommuner', 'string', '', 'dime.denmark.kommune', '630', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(357, 'actor', 'HEM', 'kommuner', 'string', '', 'dime.denmark.kommune', '657', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(358, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.kommune', '661', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(359, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.kommune', '665', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(360, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.kommune', '671', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(361, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.kommune', '706', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(362, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.kommune', '707', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(363, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '710', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(364, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '727', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(365, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.kommune', '730', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(366, 'actor', 'SKH', 'kommuner', 'string', '', 'dime.denmark.kommune', '740', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(367, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '741', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(368, 'actor', 'SBM', 'kommuner', 'string', '', 'dime.denmark.kommune', '746', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(369, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '751', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(370, 'actor', 'HEM', 'kommuner', 'string', '', 'dime.denmark.kommune', '756', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(371, 'actor', 'ARV', 'kommuner', 'string', '', 'dime.denmark.kommune', '760', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(372, 'actor', 'HOM', 'kommuner', 'string', '', 'dime.denmark.kommune', '766', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(373, 'actor', 'THY', 'kommuner', 'string', '', 'dime.denmark.kommune', '773', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(374, 'actor', 'MSA', 'kommuner', 'string', '', 'dime.denmark.kommune', '779', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(375, 'actor', 'THY', 'kommuner', 'string', '', 'dime.denmark.kommune', '787', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(376, 'actor', 'VSM', 'kommuner', 'string', '', 'dime.denmark.kommune', '791', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(377, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '810', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(378, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '813', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(379, 'actor', 'VMÅ', 'kommuner', 'string', '', 'dime.denmark.kommune', '820', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(380, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '825', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(381, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '840', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(382, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '846', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(383, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '849', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(384, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.kommune', '851', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(385, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.kommune', '860', NULL, NULL, 0, '2017-02-15 15:41:13', 0, '0000-00-00 00:00:00', ''),
(467, 'find', '1', 'finder_id', 'string', '', NULL, '5178K189-1', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(468, 'find', '1', 'type', 'string', '', 'dime.find.type', 'accessory', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(469, 'find', '1', 'period_start', 'string', '', 'dime.period', 'CYVX', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(470, 'find', '1', 'material', 'string', '', 'dime.material', 'ag', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(471, 'find', '1', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(472, 'find', '1', 'id', 'string', '', NULL, '1', NULL, NULL, 0, '2017-01-29 20:23:17', 0, '2017-01-29 20:23:17', ''),
(473, 'find', '2', 'finder_id', 'string', '', NULL, '5182K117-3', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(474, 'find', '2', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(475, 'find', '2', 'period_start', 'string', '', 'dime.period', 'CYVY', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(476, 'find', '2', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(477, 'find', '2', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(478, 'find', '2', 'id', 'string', '', NULL, '2', NULL, NULL, 0, '2017-01-29 20:29:28', 0, '2017-01-29 20:29:28', ''),
(479, 'find', '3', 'finder_id', 'string', '', NULL, '5595K024-1', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(480, 'find', '3', 'type', 'string', '', 'dime.find.type', 'coin', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(481, 'find', '3', 'period_start', 'string', '', 'dime.period', 'CYVÆ', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(482, 'find', '3', 'material', 'string', '', 'dime.material', 'ag', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(483, 'find', '3', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(484, 'find', '3', 'id', 'string', '', NULL, '3', NULL, NULL, 0, '2017-01-29 20:39:17', 0, '2017-01-29 20:39:17', ''),
(485, 'find', '4', 'finder_id', 'string', '', NULL, '5923K002-1', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(486, 'find', '4', 'type', 'string', '', 'dime.find.type', 'coin', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(487, 'find', '4', 'period_start', 'string', '', 'dime.period', 'CÆRY', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(488, 'find', '4', 'material', 'string', '', 'dime.material', 'ag', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(489, 'find', '4', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(490, 'find', '4', 'id', 'string', '', NULL, '4', NULL, NULL, 0, '2017-01-29 20:44:41', 0, '2017-01-29 20:44:41', ''),
(491, 'find', '5', 'finder_id', 'string', '', NULL, '5924K016-1', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(492, 'find', '5', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(493, 'find', '5', 'period_start', 'string', '', 'dime.period', 'CYVÆ', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(494, 'find', '5', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(495, 'find', '5', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(496, 'find', '5', 'id', 'string', '', NULL, '5', NULL, NULL, 0, '2017-01-29 20:50:43', 0, '2017-01-29 20:50:43', ''),
(497, 'find', '6', 'finder_id', 'string', '', NULL, '6128K002-3', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(498, 'find', '6', 'type', 'string', '', 'dime.find.type', 'accessory', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(499, 'find', '6', 'period_start', 'string', '', 'dime.period', 'DXXX', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(500, 'find', '6', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(501, 'find', '6', 'condition', 'string', '', 'dime.find.condition', 'fragmented', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(502, 'find', '6', 'id', 'string', '', NULL, '6', NULL, NULL, 0, '2017-01-29 20:53:52', 0, '2017-01-29 20:53:52', ''),
(503, 'find', '7', 'finder_id', 'string', '', NULL, '6300K004-1', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(504, 'find', '7', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(505, 'find', '7', 'period_start', 'string', '', 'dime.period', 'VEM', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(506, 'find', '7', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(507, 'find', '7', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(508, 'find', '7', 'id', 'string', '', NULL, '7', NULL, NULL, 0, '2017-01-29 21:00:51', 0, '2017-01-29 21:00:51', ''),
(509, 'find', '7', 'secondary', 'string', '', 'dime.find.secondary', 'enamel', NULL, NULL, 0, '2017-01-29 21:01:00', 0, '2017-01-29 21:01:00', ''),
(510, 'find', '8', 'finder_id', 'string', '', NULL, '6309K027-1', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(511, 'find', '8', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(512, 'find', '8', 'period_start', 'string', '', 'dime.period', 'CYGY', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(513, 'find', '8', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(514, 'find', '8', 'secondary', 'string', '', 'dime.find.secondary', 'tinned', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(515, 'find', '8', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(516, 'find', '8', 'id', 'string', '', NULL, '8', NULL, NULL, 0, '2017-01-29 21:03:54', 0, '2017-01-29 21:03:54', ''),
(517, 'find', '9', 'finder_id', 'string', '', NULL, '6309K028-1', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(518, 'find', '9', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(519, 'find', '9', 'period_start', 'string', '', 'dime.period', 'DÆXX', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(520, 'find', '9', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(521, 'find', '9', 'secondary', 'string', '', 'dime.find.secondary', 'gilded', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(522, 'find', '9', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(523, 'find', '9', 'id', 'string', '', NULL, '9', NULL, NULL, 0, '2017-01-29 21:07:02', 0, '2017-01-29 21:07:02', ''),
(524, 'find', '10', 'finder_id', 'string', '', NULL, '6400K002-14', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(525, 'find', '10', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(526, 'find', '10', 'period_start', 'string', '', 'dime.period', 'CYGY', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(527, 'find', '10', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(528, 'find', '10', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(529, 'find', '10', 'id', 'string', '', NULL, '10', NULL, NULL, 0, '2017-01-29 21:09:38', 0, '2017-01-29 21:09:38', ''),
(530, 'find', '1', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(531, 'find', '2', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(532, 'find', '3', 'treasure', 'string', '', 'dime.treasure', 'treasure', NULL, NULL, 0, '2017-01-29 22:46:48', 0, '2017-01-29 22:37:39', ''),
(533, 'find', '4', 'treasure', 'string', '', 'dime.treasure', 'treasure', NULL, NULL, 0, '2017-01-29 22:48:31', 0, '2017-01-29 22:37:39', ''),
(534, 'find', '5', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(535, 'find', '6', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(536, 'find', '7', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(537, 'find', '8', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(538, 'find', '9', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(539, 'find', '10', 'treasure', 'string', '', 'dime.treasure', 'assessing', NULL, NULL, 0, '2017-01-29 22:37:39', 0, '2017-01-29 22:37:39', ''),
(540, 'find', '11', 'finder_id', 'string', '', NULL, 'qqqqq', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(541, 'find', '11', 'type', 'string', '', 'dime.find.type', 'accessory', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(542, 'find', '11', 'material', 'string', '', 'dime.material', 'ag', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(543, 'find', '11', 'condition', 'string', '', 'dime.find.condition', 'fragmented', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(544, 'find', '11', 'id', 'string', '', NULL, '11', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(545, 'find', '1', 'image', 'string', '', NULL, '5178K189-1.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(546, 'find', '2', 'image', 'string', '', NULL, '5182K117-3.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(547, 'find', '3', 'image', 'string', '', NULL, '5595K024-1.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(548, 'find', '4', 'image', 'string', '', NULL, '5923K002-1.bagside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(549, 'find', '4', 'image', 'string', '', NULL, '5923K002-1.forside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(550, 'find', '5', 'image', 'string', '', NULL, '5924K016-1.bagside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(551, 'find', '5', 'image', 'string', '', NULL, '5924K016-1.forside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(552, 'find', '6', 'image', 'string', '', NULL, '6128K002-3.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(553, 'find', '7', 'image', 'string', '', NULL, '6300K004-1.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(554, 'find', '8', 'image', 'string', '', NULL, '6309K027-1.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(555, 'find', '9', 'image', 'string', '', NULL, '6309K028-1.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(556, 'find', '10', 'image', 'string', '', NULL, '6400K002-14.bagside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(557, 'find', '10', 'image', 'string', '', NULL, '6400K002-14.forside.jpg', NULL, NULL, 0, '2017-01-30 00:00:07', 0, '2017-01-30 00:00:07', ''),
(558, 'find', '11', 'finder_id', 'string', '', NULL, 'MYFIND-1', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(559, 'find', '11', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(560, 'find', '11', 'period_start', 'string', '', 'dime.period', 'CÆRÆ', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(561, 'find', '11', 'material', 'string', '', 'dime.material', 'al', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(562, 'find', '11', 'condition', 'string', '', 'dime.find.condition', 'fragmented', NULL, NULL, 0, '2017-01-30 10:34:16', 0, '2017-01-30 10:34:16', ''),
(563, 'find', '12', 'finder_id', 'string', '', NULL, 'KurtRavnErGud', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(564, 'find', '12', 'type', 'string', '', 'dime.find.type', 'military', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(565, 'find', '12', 'period_start', 'string', '', 'dime.period', 'CÆRÆ', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(566, 'find', '12', 'material', 'string', '', 'dime.material', 'fe', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(568, 'find', '12', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(569, 'find', '12', 'id', 'string', '', NULL, '12', NULL, NULL, 0, '2017-01-30 10:35:09', 0, '2017-01-30 10:35:09', ''),
(571, 'find', '12', 'secondary', 'string', '', 'dime.find.secondary', 'zz', NULL, NULL, 0, '2017-01-30 10:37:24', 0, '2017-01-30 10:37:24', ''),
(572, 'find', '13', 'finder_id', 'string', '', NULL, 'myfind', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(573, 'find', '13', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(574, 'find', '13', 'period_start', 'string', '', 'dime.period', 'AXXX', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(575, 'find', '13', 'material', 'string', '', 'dime.material', 'cu', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(576, 'find', '13', 'secondary', 'string', '', 'dime.find.secondary', 'glass', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(577, 'find', '13', 'secondary', 'string', '', 'dime.find.secondary', 'organic', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(578, 'find', '13', 'condition', 'string', '', 'dime.find.condition', 'whole', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(579, 'find', '13', 'id', 'string', '', NULL, '13', NULL, NULL, 0, '2017-01-30 10:42:51', 0, '2017-01-30 10:42:51', ''),
(580, 'locality', '1', 'id', 'string', '', NULL, '1', NULL, NULL, 0, '2017-01-31 07:56:30', 0, '2017-01-31 07:56:30', ''),
(581, 'locality', '1', 'type', 'string', '', NULL, 'Sted', NULL, NULL, 0, '2017-01-31 07:56:30', 0, '2017-01-31 07:56:30', ''),
(582, 'find', '14', 'finder_id', 'string', '', NULL, 'NytNummer', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(583, 'find', '14', 'type', 'string', '', 'dime.find.type', 'fibula', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(584, 'find', '14', 'period_start', 'string', '', 'dime.period', 'BÆX1', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(585, 'find', '14', 'material', 'string', '', 'dime.material', 'cual', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(586, 'find', '14', 'condition', 'string', '', 'dime.find.condition', 'fragmented', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(587, 'find', '14', 'id', 'string', '', NULL, '14', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(588, 'message', '1', 'id', 'string', '', NULL, '1', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(589, 'message', '2', 'id', 'string', '', NULL, '2', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(590, 'message', '1', 'type', 'string', '', 'core.message.type', 'notification', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', ''),
(591, 'message', '2', 'type', 'string', '', 'core.message.type', 'notification', NULL, NULL, 0, '2017-01-31 07:59:45', 0, '2017-01-31 07:59:45', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE `ark_fragment_text` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text/plain',
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` longtext COLLATE utf8mb4_unicode_ci,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `object_fid`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
(41, 'page', 'about', 'content', 'text', 'text/html', 'da', '<h2>Om DIME</h2><p>DIME står for ”Digitale Metaldetektorfund” og er en brugerdrevet platform til registrering af metaldetektorfund til brug i formidling, forskning og forvaltning.</p><p>Ideen bag DIME er, at den skal:<ul><li>øge inddragelse af metaldetektorbrugerne i det museale arbejde</li><li>øge og skærpe samarbejdet mellem metaldetektorbrugere og museer</li><li>lette arbejdsbyrden vedr. fundregistrering og danefæbehandling på museerne</li><li>muliggøre en hurtig behandling af Danefæ</li><li>muliggøre en ensartet registreringspraksis landet over</li><li>optimere tilgængeligheden af information om metaldetektorfundene til forskningsbrug</li><li>fungere som indgang for indberetning af fund til centrale, museale databaser (SARA mfl.)</li></ul></p><h3>Baggrunden for DIME</h3><p>Hvert år finder frivillige metaldetektorbrugere på danske marker i 1000vis af fund af stor kulturhistorisk betydning. De bidrager løbende til fremkomsten af nogle af de mest opsigtsvækkende fund i dansk arkæologi, og metaldetektorfundene har i mange henseender revolutioneret vor forståelse af de forhistoriske og historiske samfund fra bronzealder til nyere tid. Dansk metaldetektorarkæologi har på den baggrund udviklet sig til en unik og internationalt anerkendt succeshistorie, som forener de bedste sider af den danske model med en bred folkelig involvering i det arkæologiske arbejde og en decentral museumsstruktur. Men den kolossale tilvækst af indkomne fund har i stigende grad tydeliggjort behovet for en samlet registrering af metaldetektorfundene, idet kun en brøkdel af de mange fund er tilgængelige for offentligheden, museerne og for forskningen. DIME er udviklet med henblik på at muliggøre optimal udnyttelse af metaldetektorfundenes store formidlings- og forskningsmæssige potentiale.</p><h3>Udviklingen af DIME</h3><p>DIME-databasen blev udviklet i 2016-2017 af en gruppe museumsfolk og universitetsarkæologer i tæt samarbejde med detektorbrugere og et bredt panel fagfolk fra museer landet over. DIME er således udviklet af brugere for brugere, og under udformning af databasen har udviklerne bl.a. kunne støtte sig til:<ul><li>Interview af 27 museumsmedarbejder (fra 27 forskellige museer) om praksis og erfaringer med fundregistrering og krav til en evt. databaseløsning</li><li>Online spørgeskema blandt detektorfolk om praksis og ønsker til fundregistrering (168 besvarelser)</li><li>Fokusgruppeinterview med udvalgte detektorfolk</li></ul></p><p>DIME er udviklet af følgende institutioner:<ul><li>Aarhus Universitet</li><li>Moesgaard Museum</li><li>Nordjyllands Historiske Museum</li><li>Odense Bys Museer</li></ul></p><p>Udvikling af DIME blev muliggjort med økonomisk støtte fra KROGAGERFONDEN</p>', NULL, NULL, 0, '2017-02-15 14:12:11', 0, '0000-00-00 00:00:00', ''),
(43, 'page', 'background', 'content', 'text', 'text/html', 'da', '<h2>Metaldetektorbrug i Danmark</h2><p>Siden 1970erne har metaldetektering vundet stor popularitet blandt private brugere i Danmark. Hvert år bruger entusiastiske detektorbrugere i tusindvis af timer på at afsøge marker over hele landet og bidrager alle på denne vis til at redde vigtige arkæologiske fund fra gradvis nedbrydning som følge af dyrkning, vind og vejr.<p>Tabt, ofret til guderne eller gemt til senere brug. De mange genstande, som bliver fundet med metaldetektor, er endt i jorden af vidt forskellige årsager igennem tiderne. De fleste er dog små enkeltliggende genstande, f.eks. mønter og smykker, som øjensynligt er blevet tabt under brug. Mange fund i et område indikerer derfor, at her har været høj aktivitet. Men mængden af fund afspejler i høj grad også, hvor udbredt brugen af metaller har været. Der er således betydeligt længere mellem fundene fra bronzealderen og de tidligste dele af jernalderen, hvor metaller udgjorde kostbare sjældenheder, end mellem fundene fra yngre jernalder og ikke mindst fra middelalderen og fremefter. På sammen vis er genstande af jern, bronze, bly og aluminium almindelige mens fund af sølv og i særdeleshed fund af guld naturligvis er anderledes sjældne.<p>Metaldetektorens effektive søgedybde afhænger af metalgenstandens karakter og markens overflade og udgør oftest kun nogle kun få cm, hvorfor dyrkede marker, hvor ploven jævnligt vender de dybere dele af muldlaget op til overfladen, opbyder de mest optimale ”jagtmarker”. Højsæsonen for metaldetektering er derfor ikke overraskende forår og efterår, hvor markerne står uden afgrøder.<h3>Regler</h3><p>I Danmark er det lovligt at gå med metaldetektor i de fleste områder. Der er dog nogle enkle regler, som skal overholdes, og Kulturstyrelsen har udarbejdet følgende vejledning til, hvordan man som detektorbruger skal og bør forholde sig.<p>Du skal:<ul><li>Du  skal sørge for at få tilladelse til at gå på det areal du ønsker, hos ejeren af jorden. Er ejeren offentlig, skal du henvende dig til den relevante myndighed, f.eks. en kommunes tekniske forvaltning. <a href=\"http://svana.dk/natur/friluftsliv/hvad-maa-jeg-i-naturen/\">For statens arealer, der forvaltes af Naturstyrelsen, gælder der særlige regler</a>.</li><li>Du skal aflevere de fundne genstande til det lokale museum (eller Nationalmuseet), såfremt du mener at der kan være tale om danefæ.</li></ul><p>Du må ikke:<ul><li>Du må ikke gå med detektor på fredede fortidsminder, eller nærmere end to meter fra fredningsgrænsen. Se om et fortidsminde er fredet på Kulturstyrelsens database <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a></li><li>Du må ikke foretage en udgravning af et fundområde, herunder grave dybere end pløjelaget.</li></ul><p>Du må gerne:<ul><li>Du må gerne gå med detektor på <a href=\"http://www.kulturstyrelsen.dk/index.php?id=13240\">kulturarvsarealer</a>, dog ikke på fredede fortidsminder indenfor arealerne, se <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a>, og du skal stadig spørge ejeren om lov.</li></ul><p>Om selve genstandene (danefæ):<ul><li>En række af de genstande du kan finde med en metaldetektor kan være danefæ (se menupunktet ”danefæ”). Danefæ tilhører staten, og er du det mindste i tvivl, om det du har fundet evt. kan være danefæ, skal du kontakte det lokale museum eller Nationalmuseet, der kan vejlede dig om det videre forløb.</li><li>Du må ikke sælge genstande/danefæ.</li><li>Du må ikke videregive genstande/danefæ.</li><li>Du bør behandle genstandene med omhu og forsigtighed, de er sårbare.</li><li>Du bør ikke rengøre, børste eller vaske genstande da informationer kan gå tabt.</li><li>Du bør opbevare genstande i en plastpose og æske med låg.</li><li>Du bør anvende en GPS til at måle dine fund ind med – også dem du er i tvivl om er noget.</li><li>Du bør notere findernavn, sted, dato og GPS-koordinater sammen med fundet. Hvis du skriver på en seddel der lægges i posen, så brug en blyant – aldrig kuglepen eller filtpen da skriftes let flyder ud hvis papiret bliver fugtigt.</li><li>Du bør markere fundområdet på et kort.</li></ul><p>Om fundstedet:<li>Du må ikke påbegynde en udgravning af fundstedet. Grav aldrig dybere end pløjelagets dybde.</li><p>Det er en god idé:<ul><li>At have god kontakt med lokalmuseet.</li><li>At have god kontakt med lodsejere.</li><li>At orientere sig i <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund & Fortidsminder-databasen</a>.</li><li>At være medlem af den lokale detektorklub eller amatørarkæologiske forening.</li><li>At være to eller flere, der går sammen.</li><li>At have indbyrdes klare aftaler med hinanden og med lodsejer.</li><li>At være systematisk i sin søgen.</li><li>At føre dagbog over sin søgen.</li><li>At diskutere fundne genstande og afsøgningsmetoder i detektorklubben.</li></ul><h3>Metaldetektorfund og arkæologiske udgravninger</h3><p>Grundejere, der skal give lov til, at der må anvendes metaldetektor på ens ejendom – typisk landmænd – er indimellem usikre omkring, hvorvidt fund gjort med metaldetektor kan medføre udgravninger, som skal betales af ejeren af jorden. Fremkomsten af detektorfund vil i sig selv ikke medføre, at en jordejer påføres udgifter til en evt. efterfølgende arkæologisk udgravning.<p>De fleste detektorfund indgår i museernes samlinger - enten som danefæ på Nationalmuseet eller på det lokale museum som almindelige genstande, der indlemmes i museets samling. Enkelte fund, typisk fra nyere tid, kan beholdes af detektorføreren selv.<p>I de sjældne tilfælde, hvor der gøres et skattefund, f.eks. mønter eller værdifuldt metal, er museerne ofte interesserede i at gennemføre en begrænset undersøgelse af fundstedet. Formålet vil være at sikre de dele af skatten, der muligvis endnu er bevaret under pløjelaget. Herved kan man sikre en række væsentlige oplysninger om deponeringsmåden (i et lerkar, en læderpung eller lignende) og ofte også årsagen til deponeringen (til gudernes gunst eller i ufredstider). Samtidig sikrer man, at alle dele af skatten kommer til syne – og dermed er den videnskabelige værdi af fundet væsentligt større.<p>Når en skat i første omgang findes, skyldes det, at nogle af genstandene allerede ligger oppe i pløjelaget. De kan være ført derop af markredskaber for både 10, 50 eller 100 år siden. Altså som følge af ”jordarbejde i forbindelse med erosion eller jordarbejde udført som led i dyrkning af almindelige landbrugsafgrøder eller som led i almindelig skovdrift,” som det hedder i lovteksten (<a href=\"https://www.retsinformation.dk/forms/r0710.aspx?id=12017\">Museumslovens § 27, stk. 5. pind 1</a>). Arkæologiske undersøgelser af denne type skal ikke betales af jordejeren, men bekostes typisk af midler fra en pulje, som Slots- og Kulturstyrelsen råder over, efter ansøgning fra det lokale museum. Afhængig af undersøgelsens omfang og tidspunkt på året kan jordejeren kompenseres for eventuelle tab efter gældende regler for afgrødeerstatning.<h3>Fra landmand til bygherre</h3><p>Der kan dog opstå situationer, hvor detektorfund på længere sigt kan være en medvirkende årsag til, at der skal gennemføres en arkæologisk undersøgelse for landmandens regning – nemlig i det tilfælde, hvor han går fra at dyrke marken til at være bygherre. Et eksempel:<p>Hvis man forestiller sig, at der bliver gået med metaldetektor tæt ind til en eksisterende gård, og der på hele den vestlige side fremkommer spredte metalfund, f.eks. fra en bebyggelse fra vikingetid og ældre middelalder, vil det i første omgang ikke medføre en udgravning. Metaldetektorfundene er naturligvis med til at forøge vores viden om placeringen af landsbyer, bopladser og gravpladser rundt omkring i landskabet. På den måde er detektorfundene med til at give et mere detaljeret indblik i den forhistoriske udnyttelse af landskabet, end hvis vi ikke havde disse fund. Det svarer til fund af potteskår eller flintredskaber som f.eks. økser eller dolke.<p>Hvis landmanden på et senere tidspunkt ønsker at udvide sin gård, f.eks. med en ny løsdriftsstald med tilhørende gylletank og plansilo, vil metaldetektorfundene - på lige fod med alle andre oplysninger, som museet kender til (f.eks. overpløjede gravhøje, løsfundne stenoldsager, spor set fra luften eller som fremgår af såkaldte LiDAR-scanninger) - danne baggrund for den rådgivning, som museet vil tilbyde landmanden i forbindelse med hans byggeprojekt.<p>Landmanden kan i den forbindelse vælge at få gennemført en forundersøgelse af arealet (<a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/vejledning-om-arkaeologiske-undersoegelser/\">se mere i Vejledning om arkæologiske undersøgelser</a>), og hvis det herefter viser sig, at der på det areal, hvor han ønsker at udvide gården, fremkommer væsentlige fortidsminder, er det museumslovens bestemmelse, at han som bygherre skal betale for den nødvendige arkæologiske undersøgelse før byggestart. En bygherre - i dette eksempel en landmand - kan i den forbindelse godt have den opfattelse, at det er metaldetektor-fundenes skyld, at han kommer til at betale for en arkæologisk undersøgelse. Det er dog ikke korrekt, for uanset om der er gjort metalfund eller ej, ville en arkæologisk forundersøgelse afsløre, at der er væsentlige fortidsminder bevaret under muldjorden i form af eksempelvis stolpehuller efter huse, brønde, hegnsspor og affaldsgruber. Museumsloven bestemmer herefter, at den nødvendige arkæologiske undersøgelse skal betales af bygherre, med mindre det er muligt at bevare fortidsminderne på stedet ved at ændre eller flytte anlægsarbejdet.  (Kilde: Kulturstyrelsen - http://slks.dk/fortidsminder-diger/metaldetektor-og-danefae/)', NULL, NULL, 0, '2017-02-15 14:12:17', 0, '0000-00-00 00:00:00', ''),
(44, 'page', 'research', 'content', 'text', 'text/html', 'da', '<h2>Vidensdeling via DIME</h2><p>Gennem vidensdeling bliver vi alle klogere. DIME hylder og søger aktivt at understøtte dette princip, hvorfor vi ikke kun opfordrer detektorbrugerne til at levere deres unikke viden i form af fundindberetninger, men også tilskynder, at forskere her på hjemmesiden offentliggør nye forskningsresultater vedrørende metaldetektorfundene. For at stimulere denne ”delingskultur” bliver alle med forskeradgang til databasen afkrævet et kort resumé af deres arbejde, når de publicerer forskning med afsæt i DIME. Disse resuméer kan i lighed med anden relevant forskning og henvisninger til andre forskningsarbejder findes ved at følgende de forskellige nedenstående links.', NULL, NULL, 0, '2017-02-15 14:12:24', 0, '0000-00-00 00:00:00', ''),
(46, 'actor', 'ARV', 'shortname', 'text', 'text/plain', 'da', 'ARKVEST', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(47, 'actor', 'BMR', 'shortname', 'text', 'text/plain', 'da', 'Bornholms', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(48, 'actor', 'DKM', 'shortname', 'text', 'text/plain', 'da', 'Holstebro', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(49, 'actor', 'FHM', 'shortname', 'text', 'text/plain', 'da', 'Moesgård', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(50, 'actor', 'HBV', 'shortname', 'text', 'text/plain', 'da', 'Sønderskov', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(51, 'actor', 'HEM', 'shortname', 'text', 'text/plain', 'da', 'Midtjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(52, 'actor', 'HOM', 'shortname', 'text', 'text/plain', 'da', 'Horsens', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(53, 'actor', 'KBM', 'shortname', 'text', 'text/plain', 'da', 'Københavns', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(54, 'actor', 'KNV', 'shortname', 'text', 'text/plain', 'da', 'Sydøstdanmark', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(55, 'actor', 'MKH', 'shortname', 'text', 'text/plain', 'da', 'Koldinghus', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(56, 'actor', 'MLF', 'shortname', 'text', 'text/plain', 'da', 'Lolland-Falster', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(57, 'actor', 'MNS', 'shortname', 'text', 'text/plain', 'da', 'Nordsjælland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(58, 'actor', 'MOE', 'shortname', 'text', 'text/plain', 'da', 'Østjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(59, 'actor', 'MSA', 'shortname', 'text', 'text/plain', 'da', 'Skive', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(60, 'actor', 'MSJ', 'shortname', 'text', 'text/plain', 'da', 'Sønderjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(61, 'actor', 'MVE', 'shortname', 'text', 'text/plain', 'da', 'Vestsjælland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(62, 'actor', 'NJM', 'shortname', 'text', 'text/plain', 'da', 'Nordjyllands', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(63, 'actor', 'OBM', 'shortname', 'text', 'text/plain', 'da', 'Odense', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(64, 'actor', 'ØFM', 'shortname', 'text', 'text/plain', 'da', 'Østfyns', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(65, 'actor', 'ØHM', 'shortname', 'text', 'text/plain', 'da', 'Øhavs', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(66, 'actor', 'ROM', 'shortname', 'text', 'text/plain', 'da', 'Roskilde', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(67, 'actor', 'SBM', 'shortname', 'text', 'text/plain', 'da', 'Skanderborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(68, 'actor', 'SJM', 'shortname', 'text', 'text/plain', 'da', 'Sydvestjyske', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(69, 'actor', 'SKH', 'shortname', 'text', 'text/plain', 'da', 'Silkeborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(70, 'actor', 'TAK', 'shortname', 'text', 'text/plain', 'da', 'Kroppedal', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(71, 'actor', 'THY', 'shortname', 'text', 'text/plain', 'da', 'Thy', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(72, 'actor', 'VHM', 'shortname', 'text', 'text/plain', 'da', 'Vendsyssel', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(73, 'actor', 'VKH', 'shortname', 'text', 'text/plain', 'da', 'Vejle', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(74, 'actor', 'VMÅ', 'shortname', 'text', 'text/plain', 'da', 'Vesthimmerlands', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(75, 'actor', 'VSM', 'shortname', 'text', 'text/plain', 'da', 'Viborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(77, 'actor', 'ARV', 'shortname', 'text', 'text/plain', 'en', 'ARKVEST', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(78, 'actor', 'BMR', 'shortname', 'text', 'text/plain', 'en', 'Bornholms', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(79, 'actor', 'DKM', 'shortname', 'text', 'text/plain', 'en', 'Holstebro', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(80, 'actor', 'FHM', 'shortname', 'text', 'text/plain', 'en', 'Moesgård', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(81, 'actor', 'HBV', 'shortname', 'text', 'text/plain', 'en', 'Sønderskov', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(82, 'actor', 'HEM', 'shortname', 'text', 'text/plain', 'en', 'Central Denmark', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(83, 'actor', 'HOM', 'shortname', 'text', 'text/plain', 'en', 'Horsens', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(84, 'actor', 'KBM', 'shortname', 'text', 'text/plain', 'en', 'Copenhagen', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(85, 'actor', 'KNV', 'shortname', 'text', 'text/plain', 'en', 'Southeast Denmark Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(86, 'actor', 'MKH', 'shortname', 'text', 'text/plain', 'en', 'Koldinghus', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(87, 'actor', 'MLF', 'shortname', 'text', 'text/plain', 'en', 'Lolland-Falster', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(88, 'actor', 'MNS', 'shortname', 'text', 'text/plain', 'en', 'North Zealand', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(89, 'actor', 'MOE', 'shortname', 'text', 'text/plain', 'en', 'East Jutland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(90, 'actor', 'MSA', 'shortname', 'text', 'text/plain', 'en', 'Skive', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(91, 'actor', 'MSJ', 'shortname', 'text', 'text/plain', 'en', 'South Jutland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(92, 'actor', 'MVE', 'shortname', 'text', 'text/plain', 'en', 'West Zealand', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(93, 'actor', 'NJM', 'shortname', 'text', 'text/plain', 'en', 'North Jutland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(94, 'actor', 'OBM', 'shortname', 'text', 'text/plain', 'en', 'Odense', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(95, 'actor', 'ØFM', 'shortname', 'text', 'text/plain', 'en', 'Østfyns', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(96, 'actor', 'ØHM', 'shortname', 'text', 'text/plain', 'en', 'Øhavs', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(97, 'actor', 'ROM', 'shortname', 'text', 'text/plain', 'en', 'Roskilde', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(98, 'actor', 'SBM', 'shortname', 'text', 'text/plain', 'en', 'Skanderborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(99, 'actor', 'SJM', 'shortname', 'text', 'text/plain', 'en', 'Southwest Jutland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(100, 'actor', 'SKH', 'shortname', 'text', 'text/plain', 'en', 'Silkeborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(101, 'actor', 'TAK', 'shortname', 'text', 'text/plain', 'en', 'Kroppedal', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(102, 'actor', 'THY', 'shortname', 'text', 'text/plain', 'en', 'Thy', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(103, 'actor', 'VHM', 'shortname', 'text', 'text/plain', 'en', 'Vendsyssel', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(104, 'actor', 'VKH', 'shortname', 'text', 'text/plain', 'en', 'Vejle', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(105, 'actor', 'VMÅ', 'shortname', 'text', 'text/plain', 'en', 'Vesthimmerlands', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(106, 'actor', 'VSM', 'shortname', 'text', 'text/plain', 'en', 'Viborg', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(108, 'actor', 'ARV', 'fullname', 'text', 'text/plain', 'da', 'ARKVEST Arkæologi Vestjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(109, 'actor', 'BMR', 'fullname', 'text', 'text/plain', 'da', 'Bornholms Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(110, 'actor', 'DKM', 'fullname', 'text', 'text/plain', 'da', 'De Kulturhistoriske Museer i Holstebro Kommune', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(111, 'actor', 'FHM', 'fullname', 'text', 'text/plain', 'da', 'Moesgård Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(112, 'actor', 'HBV', 'fullname', 'text', 'text/plain', 'da', 'Museet på Sønderskov', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(113, 'actor', 'HEM', 'fullname', 'text', 'text/plain', 'da', 'Museum Midtjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(114, 'actor', 'HOM', 'fullname', 'text', 'text/plain', 'da', 'Horsens Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(115, 'actor', 'KBM', 'fullname', 'text', 'text/plain', 'da', 'Københavns Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(116, 'actor', 'KNV', 'fullname', 'text', 'text/plain', 'da', 'Museum Sydøstdanmark', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(117, 'actor', 'MKH', 'fullname', 'text', 'text/plain', 'da', 'Museet på Koldinghus', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(118, 'actor', 'MLF', 'fullname', 'text', 'text/plain', 'da', 'Museum Lolland-Falster', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(119, 'actor', 'MNS', 'fullname', 'text', 'text/plain', 'da', 'Museum Nordsjælland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(120, 'actor', 'MOE', 'fullname', 'text', 'text/plain', 'da', 'Museum Østjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(121, 'actor', 'MSA', 'fullname', 'text', 'text/plain', 'da', 'Museum Salling, Skive Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(122, 'actor', 'MSJ', 'fullname', 'text', 'text/plain', 'da', 'Museum Sønderjylland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(123, 'actor', 'MVE', 'fullname', 'text', 'text/plain', 'da', 'Museum Vestsjælland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(124, 'actor', 'NJM', 'fullname', 'text', 'text/plain', 'da', 'Nordjyllands Historiske Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(125, 'actor', 'OBM', 'fullname', 'text', 'text/plain', 'da', 'Odense Bys Museer', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(126, 'actor', 'ØFM', 'fullname', 'text', 'text/plain', 'da', 'Østfyns Museer', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(127, 'actor', 'ØHM', 'fullname', 'text', 'text/plain', 'da', 'Øhavsmuseet', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(128, 'actor', 'ROM', 'fullname', 'text', 'text/plain', 'da', 'Roskilde Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(129, 'actor', 'SBM', 'fullname', 'text', 'text/plain', 'da', 'Skanderborg Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(130, 'actor', 'SJM', 'fullname', 'text', 'text/plain', 'da', 'Sydvestjyske Museer', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(131, 'actor', 'SKH', 'fullname', 'text', 'text/plain', 'da', 'Silkeborg Kulturhistoriske Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(132, 'actor', 'TAK', 'fullname', 'text', 'text/plain', 'da', 'Kroppedal Museum, Arkæologi', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(133, 'actor', 'THY', 'fullname', 'text', 'text/plain', 'da', 'Museum Thy', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(134, 'actor', 'VHM', 'fullname', 'text', 'text/plain', 'da', 'Vendsyssel Historiske Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(135, 'actor', 'VKH', 'fullname', 'text', 'text/plain', 'da', 'Vejle Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(136, 'actor', 'VMÅ', 'fullname', 'text', 'text/plain', 'da', 'Vesthimmerlands Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(137, 'actor', 'VSM', 'fullname', 'text', 'text/plain', 'da', 'Viborg Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(139, 'actor', 'ARV', 'fullname', 'text', 'text/plain', 'en', 'ARKVEST Archaeology Jutland', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(140, 'actor', 'BMR', 'fullname', 'text', 'text/plain', 'en', 'Bornholms Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(141, 'actor', 'DKM', 'fullname', 'text', 'text/plain', 'en', 'The Cultural History Museums in Holstebro Municipality', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(142, 'actor', 'FHM', 'fullname', 'text', 'text/plain', 'en', 'Moesgård Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(143, 'actor', 'HBV', 'fullname', 'text', 'text/plain', 'en', 'Museum at Sønderskov', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(144, 'actor', 'HEM', 'fullname', 'text', 'text/plain', 'en', 'Central Denmark Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(145, 'actor', 'HOM', 'fullname', 'text', 'text/plain', 'en', 'Horsens Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(146, 'actor', 'KBM', 'fullname', 'text', 'text/plain', 'en', 'Copenhagen Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(147, 'actor', 'KNV', 'fullname', 'text', 'text/plain', 'en', 'Southeast Denmark Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(148, 'actor', 'MKH', 'fullname', 'text', 'text/plain', 'en', 'Museum at Koldinghus', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(149, 'actor', 'MLF', 'fullname', 'text', 'text/plain', 'en', 'Lolland-Falster Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(150, 'actor', 'MNS', 'fullname', 'text', 'text/plain', 'en', 'North Zealand Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(151, 'actor', 'MOE', 'fullname', 'text', 'text/plain', 'en', 'East Jutland Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(152, 'actor', 'MSA', 'fullname', 'text', 'text/plain', 'en', 'Museum Salling, Skive Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(153, 'actor', 'MSJ', 'fullname', 'text', 'text/plain', 'en', 'South Jutland Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(154, 'actor', 'MVE', 'fullname', 'text', 'text/plain', 'en', 'West Zealand Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(155, 'actor', 'NJM', 'fullname', 'text', 'text/plain', 'en', 'North Jutland Historical Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(156, 'actor', 'OBM', 'fullname', 'text', 'text/plain', 'en', 'Odense City Museer', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(157, 'actor', 'ØFM', 'fullname', 'text', 'text/plain', 'en', 'Østfyns Museums', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(158, 'actor', 'ØHM', 'fullname', 'text', 'text/plain', 'en', 'Øhavs Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(159, 'actor', 'ROM', 'fullname', 'text', 'text/plain', 'en', 'Roskilde Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(160, 'actor', 'SBM', 'fullname', 'text', 'text/plain', 'en', 'Skanderborg Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(161, 'actor', 'SJM', 'fullname', 'text', 'text/plain', 'en', 'Southwest Jutland Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(162, 'actor', 'SKH', 'fullname', 'text', 'text/plain', 'en', 'Silkeborg Museum of Cultural History', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(163, 'actor', 'TAK', 'fullname', 'text', 'text/plain', 'en', 'Kroppedal Museum, Archaeology', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(164, 'actor', 'THY', 'fullname', 'text', 'text/plain', 'en', 'Thy Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(165, 'actor', 'VHM', 'fullname', 'text', 'text/plain', 'en', 'Vendsyssel Historical Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(166, 'actor', 'VKH', 'fullname', 'text', 'text/plain', 'en', 'Vejle Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(167, 'actor', 'VMÅ', 'fullname', 'text', 'text/plain', 'en', 'Vesthimmerlands Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(168, 'actor', 'VSM', 'fullname', 'text', 'text/plain', 'en', 'Viborg Museum', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(180, 'file', '1', 'title', 'text', 'text/plain', 'en', 'A File', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-25 19:46:09', ''),
(181, 'file', '1', 'description', 'text', 'text/plain', 'en', 'A test file', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-25 19:46:09', ''),
(217, 'find', '1', 'description', 'text', 'text/plain', 'da', 'Velbevaret, skjoldformet, orientalsk bæltebeslag med planteslyngsornamentik.', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:23:17', ''),
(218, 'find', '2', 'description', 'text', 'text/plain', 'da', 'Hel pladefibel i gennembrudt arbejde med støbt, slynget, etfodet dyr i Mammen/ Ringerike stil. Over ryggen ses desuden en bladlignende vinge?\\r\\n\\r\\nForside: lettere korroderet\\r\\n\\r\\nBagside: ukendt', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:29:28', ''),
(219, 'find', '3', 'description', 'text', 'text/plain', 'da', 'Hel, let bøjet men ellers velbevaret dirhem', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:39:17', ''),
(220, 'find', '4', 'description', 'text', 'text/plain', 'da', 'Hel,velbevaret siliqua. RIC 102/133', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:44:41', ''),
(221, 'find', '5', 'description', 'text', 'text/plain', 'da', 'Hel pladefibel i gennembrudt arbejde. Overflade lettere korroderet, men motivet fremstår nogenlunde tydeligt. \\r\\n\\r\\nForside: Smykket viser en spydbevæbnet rytter til hest og en skjoldbærende, langskørtet person stående foran hesten, alle figurer i profil. Den stående figur rækker noget frem mod hest eller rytter og under hestens bug ses et ternet klæde? Herudover er der på både hest og begge figurer en række detaljer - bl.a. personernes påklædning og hår er meget detaljeret.\\r\\n\\r\\nBagside: Lokalt ses blanke områder som muligvis er fortinning. Øverst på fiblen på bagsiden af rytterens hoved ses et lodretstående øsken, som må have udgjort nålefæstet. Modsat ses de sidste rester af nåleholderen på bagsiden af hovedet af den stående kvinde. \\r\\n\\r\\nLignende men ikke helt identiske stykker kendes bl.a. fra flere nordjyske lokaliteter men også fra resten af landet bl.a. ved Tissø er der fundet et meget velbevaret eksemplar http://scienceblogs.com/aardvarchaeology/2013/01/07/valkyrie-figurine-from-harby/', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:50:43', ''),
(222, 'find', '6', 'description', 'text', 'text/plain', 'da', 'Rektangulær plade fra spænde som mangler. I venstre side af plade er noget knækket af – formentlig de flige som har holdt bøjlen. Pladen er smukt dekoreret med et bredt ansigt i velbevaret emalje. Huden er hvid, pupiller, læber og øre i rødt og de mandelformede øjne er i lighed med hår og tøjkraven i blåt.\\r\\n\\r\\nBagside: ukendt\\r\\n\\r\\nRef.: Næsten identisk parallel fundet i Lincolnshire – se PAS https://finds.org.uk/database/search/results/q/LIN_E64986', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 20:53:52', ''),
(223, 'find', '7', 'description', 'text', 'text/plain', 'da', 'Angelsaksiske-sydskandinavisk celleemaljefibel. Cirkulær med perlet rand - Frick type 1 var. 2. Stjerneformet motiv i celleemalje. Emaljen kun delvist bevaret. Cirkulært felt i centrum i rødt, stjernestrålerne i gult og halvbueformede felter langs rand i blåt?', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 21:00:51', ''),
(224, 'find', '8', 'description', 'text', 'text/plain', 'da', 'Hel velbevaret fuglefibel med fliget fiskehale og flot fortinning. På nær hovedet er fiblen flad i profil. Langs kanten er fiblen prydet med en række stempler og på kroppen ses ridser, som muligvis har været del af indridset ornamentik.', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 21:03:54', ''),
(225, 'find', '9', 'description', 'text', 'text/plain', 'da', 'Hel lille, let hvælvet blikfibel med delvist bevaret forgyldning. Cirkulær med afsat kant og et øsken ved randen. I centrum ses et lidt skævt ligebenet kors eller en blomst med fire spidse kronblade samlet i et uregelmæssigt, næsten kvadratisk midterfelt.', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-29 21:07:02', ''),
(226, 'find', '10', 'description', 'text', 'text/plain', 'da', 'Hel lille pladefibel.Forside: Lettere korroderet overflade. Fiblen er prydet af støbt, fladedækkende slyngbånd indrammet af en markant, glat ramme.Bagside: Meget korroderet. Nåleholderen, i form af en støbt, ombøjet flig placeret parallelt med fiblens længderetning, er helt bevaret. I modsatte ende ses de sidste rester af nålefæstet. Omkring sidstnævnte er overfladen rustfarvet.', NULL, NULL, 0, '2017-03-28 09:10:05', 0, '2017-01-29 21:09:38', ''),
(227, 'find', '11', 'description', 'text', 'text/plain', 'da', 'qqqqq', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-30 00:00:07', ''),
(228, 'find', '11', 'description', 'text', 'text/plain', 'da', 'Aluminioumnfind', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-30 10:34:16', ''),
(229, 'find', '12', 'description', 'text', 'text/plain', 'da', 'Kedelig', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-30 10:35:09', ''),
(230, 'find', '13', 'description', 'text', 'text/plain', 'da', 'test find', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-30 10:42:51', ''),
(231, 'find', '14', 'description', 'text', 'text/plain', 'da', 'En ting', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '2017-01-31 07:59:45', ''),
(232, 'page', 'treasure', 'content', 'text', 'text/html', 'da', '<h2>Danefæ</h2><p>Danefæ er genstande fra fortiden, der kommer til veje som jordfund i Danmark, og som er forarbejdet af ædelt metal eller i øvrigt er af kulturhistorisk værdi, herunder mønter. Den, der finder danefæ eller får danefæ i sin besiddelse, skal aflevere det, idet danefæ tilhører staten.</p><p>Loven om danefæ kan spores tilbage til middelalderen. Nationalmuseet administrerer denne lov, der sikrer, at vigtige fund fra Danmarks fortid bliver bevaret for kommende generationer.</p><h3>Indlevering af Danefæ</h3><p>Oldsager og andre betydningsfulde genstande fra fortiden, som skønnes at være danefæ, skal indleveres til staten. Det foregår i praksis ved, at finderen indleverer fundet til det lokale museum, der har ansvaret for arkæologiske fund i området - <a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/ansvarsomraader-og-kontakt/\">se fordelingen af ansvarsområder her</a>.</p><p>Den endelige vurdering af fundets danefæ-status foretages på Nationalmuseet. Den faglige bestemmelse af fundene foretages af medarbejdere fra tre af Nationalmuseets enheder: Den Kgl. Mønt- og Medaillesamling, Danmarks Middelalder og Renæssance og Danmarks Oldtid.</p><p>Nationalmuseet har fra 2013 indført en transportordning for danefæ og ikke-danefæ. Ordningen indebærer, at Nationalmuseet en gang årligt transporterer danefæ til uddeponering samt ikke-danefæ retur til lokalmuseerne. Transporten kan også medtage danefæ til vurdering fra lokalmuseet til Nationalmuseet. Det er dog stadig muligt for lokalmuseerne, at indlevere genstande til danefævurdering direkte til Nationalmuseet.</p><h3>Jeg har fundet danefæ - hvad gør jeg?</h3><p>Du skal i første omgang henvende dig på dit lokale museum. Det er dit lokale museum, der skal tage imod dit fund og kontakte Nationalmuseet. Her kan du printe <a href=\"http://natmus.dk/fileadmin/user_upload/natmus/Danefae/Kvitteringsseddel.pdf\">et kvitteringsskema, du afleverer sammen med dit fund</a>(PDF).</p><p>Hvis du alligevel ønsker at indlevere til Nationalmuseet, tager vi kontakten til det lokale museum. Derved kan danefævurderingen trække ud, da vi skal afvente, at det lokale museum indberetter fundet. Nationalmuseet anmoder herefter det lokale museum om at indsende en danefæanmeldelse ud fra de oplysninger, som du har indleveret sammen med genstanden. Den indleverede genstand bliver på Nationalmuseet og afventer fundanmeldelse fra det lokale museum. Herefter fortsætter danefæsagen efter sædvanlig procedure.</p><h3>Sådan udviser man omhu ved fund af danefæ</h3><p><strong>Forskellige udtryk for omhu i forbindelse med danefæfund:</strong></p><p><strong>Ved tilfældige fund</strong>, dvs. ikke-detektorfund kan finderen udvises særlig omhu ved:</p><ol><li>Forsigtig håndtering.</li><li>Forsvarlig emballering.</li><li>Hurtig kontakt til antikvariske myndigheder.</li><li>Opmærksomhed på forekomsten af relevante kulturspor: skår, lerklining, trækul, sten, knoglestumper, sortjord, etc.</li></ol><p><strong>Ved detektorfund</strong> kan finderen i øvrigt udvises særlig omhu ved:</p><ol><li>Nøjagtig ”on-site” lokalisering af fundsted – ved indmåling af GPS-koordinater.</li><li>Øjeblikkelig ”on-site” fotodokumentation af fundenes tilstand og GPS-målingernes troværdighed</li><li>Tilsvarende omhyggelig indsamling af ”ikke danefæ”- fund, til belysning af konteksten for de regulære danefæ-stykker, dvs. til sikring af danefæets videnskabelige værdi. Ligeledes at finder har indgået aftale med det lokale museum om at overdrage ikke-danefæ til lokalmuseet. Kvitteringsblanket skal være underskrevet.</li><li>Elektronisk fundrapportering til lokalmuseet (med foreløbige betegnelser, eventuelle løbenumre, koordinater, fotos).  </li><li>I tvivlstilfælde og ved mulighed for dybereliggende grav- eller skattefund kontaktes lokalmuseet  straks. Ingen gravning under pløjedybde!</li><li>Der gives løbende orientering om eventuelle fund til lodsejer og lokalmuseum.</li><li>Fund udsættes ikke for afrensning, imprægnering eller afstøbning</li><li>Fund udsættes ikke for skader eller informations-tab som følge af uhensigtsmæssig (eller langvarig) opbevaring.</li></ol><p><em>Ved grundig registrering af fundene i DIME opfyldes en række af ovenstående punkter udpeget af Nationalmuseet som særligt væsentlige for omhyggelig behandling af potentielt danefæ.</em></p><h3>Hvad kan være danefæ?</h3><p>Som udgangspunkt er fragmenter lige så vigtige som hele genstande i detektorsammenhæng, idet de(t) resterende fragment(er) oftest dukker op med tiden. Det afgørende for om noget bør erklæres for danefæ er altså typen af genstand - ikke genstandens tilstand. Hittegods er aldrig danefæ.</p><h4>Guld</h4><p>Alle genstande af guld er danefæ.</p><h4>Sølv</h4><p>+ Genstande af sølv fra før 1700 samt sølvklip og -fragmenter</p><p>- Sølv fra tiden efter 1700 med mindre det er af ekstraordinær karakter</p><h4>Bronze</h4><p>+ Bronzegenstande fra oldtid og vikingetid er danefæ</p><p>+ Genstande af bronze med særlig ornamentik eller udsmykning - f.eks. inskription eller emalje fra middelalder</p><p>+ Hele eller tilnærmelsesvis hele malmgryder</p><p>+ Vægtlodder</p><p>+ Seglstamper fra før 1700</p><p>- Simple genstande af bronze fra middelalder og renæssance</p><p>- Fragmenter af malmgryder</p><p>- Taphaner</p><p>- Nøgler eller hængelåse uden kunstnerisk udsmykning.</p><h4>Bly</h4><p>+ Vægtlodder</p><p>+ Støbemodeller</p><p>+ Tenvægte med særlig udsmykning fra middelalder</p><p>+ Klædeplomber med ornamentik og/eller skrift</p><p>+ Genstande med runer eller anden skrift</p><p>- Musketkugler</p><p>- Udaterbare smelteklumper og simple blygenstande fra tiden efter 1536</p><h4>Jern</h4><p>+ Ekstraordinære jerngenstande og genstande med f.eks. tauschering, indlægning, ornamentik; eksempelvis sværd fra oldtiden og middelalderen</p><p>- Andre genstande af jern fra oldtid og middelalder, våben som værktøj o.a.</p><h4>Mønter</h4><p>+ Mønter fra oldtid, vikingetid og middelalder (fra 1536 og før)</p><p>+ Mønter i skattefund - flere mønter nedlagt sammen</p><p>+ Guldmønter og større sølvmønter, f.eks. dalermønter fra tiden efter 1536.</p><p>- Småmønter af sølv og kobber fra tiden efter 1536</p><h4>Figurer</h4><p>+ Figurer og plastiske fremstillinger i sten, metal, ben, rav og træ</p><p>+ Figurer i keramik og tegl fra oldtid og middelalder</p><h4>Runer og anden indskrift</h4><p>+ Sten og andre genstande med runer og anden indskrift</p><p></p><p>Desuden omfatter listen af muligt Danefæ også en række ikke-metalliske genstande. For nærmere herom <a href=\"http://natmus.dk/salg-og-ydelser/museumsfaglige-ydelser/danefae/hvad-kan-vaere-danefae/\">se Nationalmuseets hjemmeside</a>.</p><p>(Kilde: Nationalmuseet)</p>', NULL, NULL, 0, '2017-02-15 14:12:45', 0, '2017-01-31 23:12:14', ''),
(233, 'actor', 'ahavfrue', 'shortname', 'text', 'text/plain', 'da', 'Ariel', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(234, 'actor', 'ahavfrue', 'fullname', 'text', 'text/plain', 'da', 'Ariel Havfrue', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(235, 'actor', 'dsvendson', 'shortname', 'text', 'text/plain', 'da', 'Dicte', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(236, 'actor', 'dsvendson', 'fullname', 'text', 'text/plain', 'da', 'Dicte Svendson', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(237, 'actor', 'bnchristensen', 'shortname', 'text', 'text/plain', 'da', 'Birgitte', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(238, 'actor', 'bnchristensen', 'fullname', 'text', 'text/plain', 'da', 'Birgitte Nyborg Christensen', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(239, 'actor', 'slund', 'shortname', 'text', 'text/plain', 'da', 'Sarah', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(240, 'actor', 'slund', 'fullname', 'text', 'text/plain', 'da', 'Sarah Lund', NULL, NULL, 0, '2017-02-15 14:12:03', 0, '0000-00-00 00:00:00', ''),
(241, 'message', '1', 'body', 'text', 'text/plain', 'en', 'This is a test message.', NULL, NULL, 0, '2017-03-27 10:40:35', 0, '0000-00-00 00:00:00', NULL),
(242, 'message', '2', 'body', 'text', 'text/plain', 'en', 'This is a second message', NULL, NULL, 0, '2017-03-27 10:40:35', 0, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE `ark_fragment_time` (
  `fid` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'time',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `span` time DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE `ark_item_actor` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actor',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.actor',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`item`, `module`, `schma`, `type`, `status`, `visibility`, `parent_module`, `parent_item`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('ahavfrue', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'ahavfrue', 'ahavfrue', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('ARV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ARV', 'ARV', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('BMR', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'BMR', 'BMR', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('bnchristensen', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'bnchristensen', 'bnchristensen', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('DKM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'DKM', 'DKM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('dsvendson', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'dsvendson', 'dsvendson', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', ''),
('FHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'FHM', 'FHM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('HBV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HBV', 'HBV', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('HEM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HEM', 'HEM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('HOM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HOM', 'HOM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('KBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'KBM', 'KBM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('KNV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'KNV', 'KNV', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MKH', 'MKH', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MLF', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MLF', 'MLF', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MNS', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MNS', 'MNS', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MOE', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MOE', 'MOE', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MSA', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MSA', 'MSA', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MSJ', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MSJ', 'MSJ', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('MVE', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MVE', 'MVE', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('NJM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'NJM', 'NJM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('OBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'OBM', 'OBM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('ØFM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ØFM', 'ØFM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('ØHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ØHM', 'ØHM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('ROM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ROM', 'ROM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('SBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SBM', 'SBM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('SJM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SJM', 'SJM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('SKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SKH', 'SKH', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('slund', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'slund', 'slund', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('TAK', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'TAK', 'TAK', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('THY', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'THY', 'THY', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('VHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VHM', 'VHM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('VKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VKH', 'VKH', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('VMÅ', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VMÅ', 'VMÅ', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', ''),
('VSM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VSM', 'VSM', 0, '2017-04-29 12:55:29', 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_event`
--

CREATE TABLE `ark_item_event` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'event',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.event',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE `ark_item_file` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.file',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibilty` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_find`
--

INSERT INTO `ark_item_find` (`item`, `module`, `schma`, `type`, `status`, `visibility`, `parent_module`, `parent_item`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('1', 'find', 'dime.find', 'accessory', 'registered', 'restricted', NULL, NULL, '1', '1', 0, '2017-04-27 18:59:35', 0, '2017-04-27 18:59:35', ''),
('10', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '10', '10', 0, '2017-02-15 15:52:17', 0, '2017-01-29 21:09:38', ''),
('2', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '2', '2', 0, '2017-02-15 15:52:17', 0, '2017-01-29 20:45:58', ''),
('3', 'find', 'dime.find', 'coin', 'registered', 'restricted', NULL, NULL, '3', '3', 0, '2017-02-15 15:52:17', 0, '2017-01-29 22:46:48', ''),
('4', 'find', 'dime.find', 'coin', 'registered', 'restricted', NULL, NULL, '4', '4', 0, '2017-02-15 15:52:17', 0, '2017-01-29 22:48:31', ''),
('5', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '5', '5', 0, '2017-02-15 15:52:17', 0, '2017-01-29 20:50:43', ''),
('6', 'find', 'dime.find', 'accessory', 'registered', 'restricted', NULL, NULL, '6', '6', 0, '2017-02-15 15:52:17', 0, '2017-01-29 20:53:52', ''),
('7', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '7', '7', 0, '2017-02-15 15:52:17', 0, '2017-01-29 21:01:00', ''),
('8', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '8', '8', 0, '2017-02-15 15:52:17', 0, '2017-01-29 21:03:54', ''),
('9', 'find', 'dime.find', 'fibula', 'registered', 'restricted', NULL, NULL, '9', '9', 0, '2017-02-15 15:52:17', 0, '2017-01-29 21:07:02', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_locality`
--

CREATE TABLE `ark_item_locality` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'locality',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dime.locality',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_message`
--

CREATE TABLE `ark_item_message` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'message',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.message',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_page`
--

CREATE TABLE `ark_item_page` (
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'page',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.page',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_item` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL DEFAULT '0',
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`item`, `module`, `schma`, `type`, `status`, `visibility`, `parent_module`, `parent_item`, `idx`, `label`, `mod_by`, `mod_on`, `cre_by`, `cre_on`, `version`) VALUES
('about', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'about', 'about', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('background', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'background', 'background', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('core.home', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'core.home', 'core.home', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('detector', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'detector', 'detector', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('exhibits', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'exhibits', 'exhibits', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('news', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'news', 'news', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('research', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'research', 'research', 0, '2017-02-15 15:53:46', 0, '0000-00-00 00:00:00', ''),
('treasure', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'treasure', 'treasure', 0, '2017-02-15 15:53:46', 0, '2017-01-31 23:12:14', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_actor_role`
--

CREATE TABLE `ark_rbac_actor_role` (
  `actor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_requested_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_rbac_actor_role`
--

INSERT INTO `ark_rbac_actor_role` (`actor`, `role`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `verification_token`, `verification_requested_at`) VALUES
('ahavfrue', 'detectorist', 1, 1, 0, 0, NULL, '', NULL),
('bnchristensen', 'appraiser', 1, 0, 0, 0, NULL, '', NULL),
('dsvendson', 'researcher', 1, 0, 0, 0, NULL, '', NULL),
('slund', 'registrar', 1, 0, 0, 0, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_actor_user`
--

CREATE TABLE `ark_rbac_actor_user` (
  `actor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `verification_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_requested_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_rbac_actor_user`
--

INSERT INTO `ark_rbac_actor_user` (`actor`, `user`, `enabled`, `verified`, `locked`, `expired`, `expires_at`, `verification_token`, `verification_requested_at`) VALUES
('ahavfrue', 1, 1, 1, 0, 0, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence`
--

CREATE TABLE `ark_sequence` (
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

CREATE TABLE `ark_sequence_lock` (
  `id` int(11) NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `recycle` tinyint(1) NOT NULL DEFAULT '0',
  `locked_by` int(11) NOT NULL,
  `locked_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_reserve`
--

CREATE TABLE `ark_sequence_reserve` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_association`
--
ALTER TABLE `ark_association`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `association` (`association`),
  ADD KEY `item1` (`module1`,`item1`) USING BTREE,
  ADD KEY `item2` (`module2`,`item2`) USING BTREE;

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
-- Indexes for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  ADD PRIMARY KEY (`fid`) USING BTREE,
  ADD KEY `property` (`module`,`item`,`attribute`) USING BTREE;

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
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_item_event`
--
ALTER TABLE `ark_item_event`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`item`),
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE,
  ADD KEY `name` (`label`(191)) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_item_locality`
--
ALTER TABLE `ark_item_locality`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_item_message`
--
ALTER TABLE `ark_item_message`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
  ADD PRIMARY KEY (`item`),
  ADD KEY `name` (`label`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_item`) USING BTREE;

--
-- Indexes for table `ark_rbac_actor_role`
--
ALTER TABLE `ark_rbac_actor_role`
  ADD PRIMARY KEY (`actor`,`role`);

--
-- Indexes for table `ark_rbac_actor_user`
--
ALTER TABLE `ark_rbac_actor_user`
  ADD PRIMARY KEY (`actor`,`user`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_association`
--
ALTER TABLE `ark_association`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=592;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_rbac_actor_role`
--
ALTER TABLE `ark_rbac_actor_role`
  ADD CONSTRAINT `ark_rbac_actor_role_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `ark_item_actor` (`item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_rbac_actor_user`
--
ALTER TABLE `ark_rbac_actor_user`
  ADD CONSTRAINT `ark_rbac_actor_user_ibfk_1` FOREIGN KEY (`actor`) REFERENCES `ark_item_actor` (`item`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
