-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2018 at 05:01 PM
-- Server version: 10.2.12-MariaDB
-- PHP Version: 7.1.13

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
-- Database: `dime_ark_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_association`
--

CREATE TABLE `ark_association` (
  `fid` int(11) NOT NULL,
  `module1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` longblob DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` tinyint(1) DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` date DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` datetime DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` double DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
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
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''integer''',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `value` bigint(20) NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` bigint(20) DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL'
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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `value` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_object`
--

INSERT INTO `ark_fragment_object` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `object`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, 'actor', 'registrar', 'address', 'object', NULL, NULL, '', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(4, 'actor', 'detectorist', 'address', 'object', NULL, NULL, '', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(7, 'actor', 'researcher', 'address', 'object', NULL, NULL, '', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', '');

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
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wkt',
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '4326',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `object`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(168, 'actor', 'ARV', 'id', 'string', '', '', 'ARV', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(169, 'actor', 'BMR', 'id', 'string', '', '', 'BMR', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(170, 'actor', 'DKM', 'id', 'string', '', '', 'DKM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(171, 'actor', 'FHM', 'id', 'string', '', '', 'FHM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(172, 'actor', 'HBV', 'id', 'string', '', '', 'HBV', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(173, 'actor', 'HEM', 'id', 'string', '', '', 'HEM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(174, 'actor', 'HOM', 'id', 'string', '', '', 'HOM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(175, 'actor', 'KBM', 'id', 'string', '', '', 'KBM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(176, 'actor', 'KNV', 'id', 'string', '', '', 'KNV', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(177, 'actor', 'MKH', 'id', 'string', '', '', 'MKH', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(178, 'actor', 'MLF', 'id', 'string', '', '', 'MLF', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(179, 'actor', 'MNS', 'id', 'string', '', '', 'MNS', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(180, 'actor', 'MOE', 'id', 'string', '', '', 'MOE', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(181, 'actor', 'MSA', 'id', 'string', '', '', 'MSA', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(182, 'actor', 'MSJ', 'id', 'string', '', '', 'MSJ', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(183, 'actor', 'MVE', 'id', 'string', '', '', 'MVE', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(184, 'actor', 'NJM', 'id', 'string', '', '', 'NJM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(185, 'actor', 'OBM', 'id', 'string', '', '', 'OBM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(186, 'actor', 'ØFM', 'id', 'string', '', '', 'ØFM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(187, 'actor', 'ØHM', 'id', 'string', '', '', 'ØHM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(188, 'actor', 'ROM', 'id', 'string', '', '', 'ROM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(189, 'actor', 'SBM', 'id', 'string', '', '', 'SBM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(190, 'actor', 'SJM', 'id', 'string', '', '', 'SJM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(191, 'actor', 'SKH', 'id', 'string', '', '', 'SKH', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(192, 'actor', 'TAK', 'id', 'string', '', '', 'TAK', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(193, 'actor', 'THY', 'id', 'string', '', '', 'THY', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(194, 'actor', 'VHM', 'id', 'string', '', '', 'VHM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(195, 'actor', 'VKH', 'id', 'string', '', '', 'VKH', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(196, 'actor', 'VMÅ', 'id', 'string', '', '', 'VMÅ', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(197, 'actor', 'VSM', 'id', 'string', '', '', 'VSM', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(198, 'actor', 'ARV', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(199, 'actor', 'BMR', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(200, 'actor', 'DKM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(201, 'actor', 'FHM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(202, 'actor', 'HBV', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(203, 'actor', 'HEM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(204, 'actor', 'HOM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(205, 'actor', 'KBM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(206, 'actor', 'KNV', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(207, 'actor', 'MKH', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(208, 'actor', 'MLF', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(209, 'actor', 'MNS', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(210, 'actor', 'MOE', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(211, 'actor', 'MSA', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(212, 'actor', 'MSJ', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(213, 'actor', 'MVE', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(214, 'actor', 'NJM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(215, 'actor', 'OBM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(216, 'actor', 'ØFM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(217, 'actor', 'ØHM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(218, 'actor', 'ROM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(219, 'actor', 'SBM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(220, 'actor', 'SJM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(221, 'actor', 'SKH', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(222, 'actor', 'TAK', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(223, 'actor', 'THY', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(224, 'actor', 'VHM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(225, 'actor', 'VKH', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(226, 'actor', 'VMÅ', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(227, 'actor', 'VSM', 'class', 'string', '', 'core.actor.class', 'museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(288, 'actor', 'KBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '101', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(289, 'actor', 'KBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '147', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(290, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '151', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(291, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '153', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(292, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '155', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(293, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '157', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(294, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '159', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(295, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '161', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(296, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '163', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(297, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '165', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(298, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '167', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(299, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '169', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(300, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '173', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(301, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '175', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(302, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '183', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(303, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '185', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(304, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '187', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(305, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '190', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(306, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '201', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(307, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '210', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(308, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '217', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(309, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '219', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(310, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '223', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(311, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '230', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(312, 'actor', 'TAK', 'kommuner', 'string', '', 'dime.denmark.municipality', '240', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(313, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.municipality', '250', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(314, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '253', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(315, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '259', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(316, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '260', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(317, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.municipality', '265', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(318, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '269', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(319, 'actor', 'MNS', 'kommuner', 'string', '', 'dime.denmark.municipality', '270', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(320, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '306', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(321, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '316', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(322, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '320', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(323, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '326', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(324, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '329', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(325, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '330', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(326, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '336', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(327, 'actor', 'MVE', 'kommuner', 'string', '', 'dime.denmark.municipality', '340', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(328, 'actor', 'ROM', 'kommuner', 'string', '', 'dime.denmark.municipality', '350', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(329, 'actor', 'MLF', 'kommuner', 'string', '', 'dime.denmark.municipality', '360', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(330, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '370', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(331, 'actor', 'MLF', 'kommuner', 'string', '', 'dime.denmark.municipality', '376', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(332, 'actor', 'KNV', 'kommuner', 'string', '', 'dime.denmark.municipality', '390', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(333, 'actor', 'BMR', 'kommuner', 'string', '', 'dime.denmark.municipality', '400', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(334, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '410', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(335, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '420', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(336, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '430', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(337, 'actor', 'ØFM', 'kommuner', 'string', '', 'dime.denmark.municipality', '440', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(338, 'actor', 'ØFM', 'kommuner', 'string', '', 'dime.denmark.municipality', '450', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(339, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '461', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(340, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '479', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(341, 'actor', 'OBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '480', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(342, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '482', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(343, 'actor', 'ØHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '492', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(344, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.municipality', '510', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(345, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '530', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(346, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.municipality', '540', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(347, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.municipality', '550', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(348, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '561', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(349, 'actor', 'SJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '563', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(350, 'actor', 'ARV', 'kommuner', 'string', '', 'dime.denmark.municipality', '573', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(351, 'actor', 'HBV', 'kommuner', 'string', '', 'dime.denmark.municipality', '575', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(352, 'actor', 'MSJ', 'kommuner', 'string', '', 'dime.denmark.municipality', '580', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(353, 'actor', 'VKH', 'kommuner', 'string', '', 'dime.denmark.municipality', '607', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(354, 'actor', 'HOM', 'kommuner', 'string', '', 'dime.denmark.municipality', '615', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(355, 'actor', 'MKH', 'kommuner', 'string', '', 'dime.denmark.municipality', '621', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(356, 'actor', 'VKH', 'kommuner', 'string', '', 'dime.denmark.municipality', '630', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(357, 'actor', 'HEM', 'kommuner', 'string', '', 'dime.denmark.municipality', '657', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(358, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.municipality', '661', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(359, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.municipality', '665', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(360, 'actor', 'DKM', 'kommuner', 'string', '', 'dime.denmark.municipality', '671', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(361, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.municipality', '706', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(362, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.municipality', '707', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(363, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '710', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(364, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '727', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(365, 'actor', 'MOE', 'kommuner', 'string', '', 'dime.denmark.municipality', '730', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(366, 'actor', 'SKH', 'kommuner', 'string', '', 'dime.denmark.municipality', '740', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(367, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '741', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(368, 'actor', 'SBM', 'kommuner', 'string', '', 'dime.denmark.municipality', '746', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(369, 'actor', 'FHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '751', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(370, 'actor', 'HEM', 'kommuner', 'string', '', 'dime.denmark.municipality', '756', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(371, 'actor', 'ARV', 'kommuner', 'string', '', 'dime.denmark.municipality', '760', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(372, 'actor', 'HOM', 'kommuner', 'string', '', 'dime.denmark.municipality', '766', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(373, 'actor', 'THY', 'kommuner', 'string', '', 'dime.denmark.municipality', '773', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(374, 'actor', 'MSA', 'kommuner', 'string', '', 'dime.denmark.municipality', '779', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(375, 'actor', 'THY', 'kommuner', 'string', '', 'dime.denmark.municipality', '787', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(376, 'actor', 'VSM', 'kommuner', 'string', '', 'dime.denmark.municipality', '791', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(377, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '810', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(378, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '813', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(379, 'actor', 'VMÅ', 'kommuner', 'string', '', 'dime.denmark.municipality', '820', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(380, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '825', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(381, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '840', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(382, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '846', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(383, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '849', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(384, 'actor', 'NJM', 'kommuner', 'string', '', 'dime.denmark.municipality', '851', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(385, 'actor', 'VHM', 'kommuner', 'string', '', 'dime.denmark.municipality', '860', 0, NULL, NULL, 'sysadmin', '2017-05-07 13:58:36', 'sysadmin', '0000-00-00 00:00:00', ''),
(1565, 'actor', 'sysadmin', 'id', 'string', '', NULL, 'sysadmin', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(1566, 'actor', 'sysadmin', 'class', 'string', '', 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2017-02-15 15:41:13', 'sysadmin', '0000-00-00 00:00:00', ''),
(1606, 'actor', 'admin', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2017-06-25 19:57:20', 'sysadmin', '2017-06-25 19:57:20', ''),
(1614, 'actor', 'admin', 'id', 'string', NULL, NULL, 'admin', 0, NULL, NULL, 'sysadmin', '2017-06-25 19:57:20', 'sysadmin', '2017-06-25 19:57:20', ''),
(2298, 'actor', 'anonymous', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2017-06-25 19:57:20', 'sysadmin', '2017-06-25 19:57:20', ''),
(2299, 'actor', 'anonymous', 'id', 'string', NULL, NULL, 'anonymous', 0, NULL, NULL, 'sysadmin', '2017-06-25 19:57:20', 'sysadmin', '2017-06-25 19:57:20', ''),
(2300, 'actor', 'registrar', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:02', 'sysadmin', '2018-01-12 12:10:02', ''),
(2301, 'actor', 'registrar', 'city', 'string', NULL, NULL, 'Algade 48', 0, NULL, 1, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2302, 'actor', 'registrar', 'country', 'string', NULL, 'country', 'DK', 0, NULL, 1, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2303, 'actor', 'registrar', 'postcode', 'string', NULL, NULL, '9000 Aalborg', 0, NULL, 1, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2304, 'actor', 'registrar', 'street', 'string', NULL, NULL, 'Nordjyllands Historiske Museum', 0, NULL, 1, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2305, 'actor', 'registrar', 'telephone', 'string', NULL, NULL, '555-5555', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2306, 'actor', 'registrar', 'terms', 'string', NULL, 'core.user.terms', 'v1', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2307, 'actor', 'registrar', 'id', 'string', NULL, NULL, 'registrar', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2308, 'actor', 'registrar', 'email', 'string', NULL, NULL, 'registrar@danefae.dk', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2311, 'actor', 'registrar', 'status', 'string', NULL, 'core.security.user.status', 'registered', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(2316, 'actor', 'detectorist', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:33', 'sysadmin', '2018-01-12 12:11:33', ''),
(2317, 'actor', 'detectorist', 'city', 'string', NULL, NULL, '9000 Aalborg', 0, NULL, 4, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2318, 'actor', 'detectorist', 'country', 'string', NULL, 'country', 'DK', 0, NULL, 4, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2319, 'actor', 'detectorist', 'street', 'string', NULL, NULL, 'Mine Strasse', 0, NULL, 4, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2320, 'actor', 'detectorist', 'telephone', 'string', NULL, NULL, '555-5555', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2321, 'actor', 'detectorist', 'terms', 'string', NULL, 'core.user.terms', 'v1', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2322, 'actor', 'detectorist', 'id', 'string', NULL, NULL, 'detectorist', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2323, 'actor', 'detectorist', 'email', 'string', NULL, NULL, 'detectorist@danefae.dk', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2324, 'actor', 'detectorist', 'detectorist_id', 'string', NULL, NULL, 'DB000001', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2327, 'actor', 'detectorist', 'status', 'string', NULL, 'core.security.user.status', 'registered', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(2332, 'actor', 'researcher', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2333, 'actor', 'researcher', 'city', 'string', NULL, NULL, 'Aalborg', 0, NULL, 7, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2334, 'actor', 'researcher', 'country', 'string', NULL, 'country', 'DK', 0, NULL, 7, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2335, 'actor', 'researcher', 'street', 'string', NULL, NULL, 'Mine Strasse', 0, NULL, 7, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2336, 'actor', 'researcher', 'telephone', 'string', NULL, NULL, '555-5555', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2337, 'actor', 'researcher', 'terms', 'string', NULL, 'core.user.terms', 'v1', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2338, 'actor', 'researcher', 'id', 'string', NULL, NULL, 'researcher', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2339, 'actor', 'researcher', 'email', 'string', NULL, NULL, 'researcher@danefae.dk', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', ''),
(2342, 'actor', 'researcher', 'status', 'string', NULL, 'core.security.user.status', 'registered', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:04', 'sysadmin', '2018-01-12 12:13:04', '');

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `object`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(41, 'page', 'dime.about', 'content', 'text', 'text/html', 'da', '<h2>Om DIME</h2><p>DIME står for ”Digitale Metaldetektorfund” og er en brugerdrevet platform til registrering af metaldetektorfund til brug i formidling, forskning og forvaltning.</p><p>Ideen bag DIME er, at den skal:<ul><li>øge inddragelse af metaldetektorbrugerne i det museale arbejde</li><li>øge og skærpe samarbejdet mellem metaldetektorbrugere og museer</li><li>lette arbejdsbyrden vedr. fundregistrering og danefæbehandling på museerne</li><li>muliggøre en hurtig behandling af Danefæ</li><li>muliggøre en ensartet registreringspraksis landet over</li><li>optimere tilgængeligheden af information om metaldetektorfundene til forskningsbrug</li><li>fungere som indgang for indberetning af fund til centrale, museale databaser (SARA mfl.)</li></ul></p><h3>Baggrunden for DIME</h3><p>Hvert år finder frivillige metaldetektorbrugere på danske marker i 1000vis af fund af stor kulturhistorisk betydning. De bidrager løbende til fremkomsten af nogle af de mest opsigtsvækkende fund i dansk arkæologi, og metaldetektorfundene har i mange henseender revolutioneret vor forståelse af de forhistoriske og historiske samfund fra bronzealder til nyere tid. Dansk metaldetektorarkæologi har på den baggrund udviklet sig til en unik og internationalt anerkendt succeshistorie, som forener de bedste sider af den danske model med en bred folkelig involvering i det arkæologiske arbejde og en decentral museumsstruktur. Men den kolossale tilvækst af indkomne fund har i stigende grad tydeliggjort behovet for en samlet registrering af metaldetektorfundene, idet kun en brøkdel af de mange fund er tilgængelige for offentligheden, museerne og for forskningen. DIME er udviklet med henblik på at muliggøre optimal udnyttelse af metaldetektorfundenes store formidlings- og forskningsmæssige potentiale.</p><h3>Udviklingen af DIME</h3><p>DIME-databasen blev udviklet i 2016-2017 af en gruppe museumsfolk og universitetsarkæologer i tæt samarbejde med detektorbrugere og et bredt panel fagfolk fra museer landet over. DIME er således udviklet af brugere for brugere, og under udformning af databasen har udviklerne bl.a. kunne støtte sig til:<ul><li>Interview af 27 museumsmedarbejder (fra 27 forskellige museer) om praksis og erfaringer med fundregistrering og krav til en evt. databaseløsning</li><li>Online spørgeskema blandt detektorfolk om praksis og ønsker til fundregistrering (168 besvarelser)</li><li>Fokusgruppeinterview med udvalgte detektorfolk</li></ul></p><p>DIME er udviklet af følgende institutioner:<ul><li>Aarhus Universitet</li><li>Moesgaard Museum</li><li>Nordjyllands Historiske Museum</li><li>Odense Bys Museer</li></ul></p><p>Udvikling af DIME blev muliggjort med økonomisk støtte fra KROGAGERFONDEN</p>', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:11', 'sysadmin', '0000-00-00 00:00:00', ''),
(42, 'page', 'dime.treasure', 'content', 'text', 'text/html', 'da', '<h2>Danefæ</h2><p>Danefæ er genstande fra fortiden, der kommer til veje som jordfund i Danmark, og som er forarbejdet af ædelt metal eller i øvrigt er af kulturhistorisk værdi, herunder mønter. Den, der finder danefæ eller får danefæ i sin besiddelse, skal aflevere det, idet danefæ tilhører staten.</p><p>Loven om danefæ kan spores tilbage til middelalderen. Nationalmuseet administrerer denne lov, der sikrer, at vigtige fund fra Danmarks fortid bliver bevaret for kommende generationer.</p><h3>Indlevering af Danefæ</h3><p>Oldsager og andre betydningsfulde genstande fra fortiden, som skønnes at være danefæ, skal indleveres til staten. Det foregår i praksis ved, at finderen indleverer fundet til det lokale museum, der har ansvaret for arkæologiske fund i området - <a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/ansvarsomraader-og-kontakt/\">se fordelingen af ansvarsområder her</a>.</p><p>Den endelige vurdering af fundets danefæ-status foretages på Nationalmuseet. Den faglige bestemmelse af fundene foretages af medarbejdere fra tre af Nationalmuseets enheder: Den Kgl. Mønt- og Medaillesamling, Danmarks Middelalder og Renæssance og Danmarks Oldtid.</p><p>Nationalmuseet har fra 2013 indført en transportordning for danefæ og ikke-danefæ. Ordningen indebærer, at Nationalmuseet en gang årligt transporterer danefæ til uddeponering samt ikke-danefæ retur til lokalmuseerne. Transporten kan også medtage danefæ til vurdering fra lokalmuseet til Nationalmuseet. Det er dog stadig muligt for lokalmuseerne, at indlevere genstande til danefævurdering direkte til Nationalmuseet.</p><h3>Jeg har fundet danefæ - hvad gør jeg?</h3><p>Du skal i første omgang henvende dig på dit lokale museum. Det er dit lokale museum, der skal tage imod dit fund og kontakte Nationalmuseet. Her kan du printe <a href=\"http://natmus.dk/fileadmin/user_upload/natmus/Danefae/Kvitteringsseddel.pdf\">et kvitteringsskema, du afleverer sammen med dit fund</a>(PDF).</p><p>Hvis du alligevel ønsker at indlevere til Nationalmuseet, tager vi kontakten til det lokale museum. Derved kan danefævurderingen trække ud, da vi skal afvente, at det lokale museum indberetter fundet. Nationalmuseet anmoder herefter det lokale museum om at indsende en danefæanmeldelse ud fra de oplysninger, som du har indleveret sammen med genstanden. Den indleverede genstand bliver på Nationalmuseet og afventer fundanmeldelse fra det lokale museum. Herefter fortsætter danefæsagen efter sædvanlig procedure.</p><h3>Sådan udviser man omhu ved fund af danefæ</h3><p><strong>Forskellige udtryk for omhu i forbindelse med danefæfund:</strong></p><p><strong>Ved tilfældige fund</strong>, dvs. ikke-detektorfund kan finderen udvises særlig omhu ved:</p><ol><li>Forsigtig håndtering.</li><li>Forsvarlig emballering.</li><li>Hurtig kontakt til antikvariske myndigheder.</li><li>Opmærksomhed på forekomsten af relevante kulturspor: skår, lerklining, trækul, sten, knoglestumper, sortjord, etc.</li></ol><p><strong>Ved detektorfund</strong> kan finderen i øvrigt udvises særlig omhu ved:</p><ol><li>Nøjagtig ”on-site” lokalisering af fundsted – ved indmåling af GPS-koordinater.</li><li>Øjeblikkelig ”on-site” fotodokumentation af fundenes tilstand og GPS-målingernes troværdighed</li><li>Tilsvarende omhyggelig indsamling af ”ikke danefæ”- fund, til belysning af konteksten for de regulære danefæ-stykker, dvs. til sikring af danefæets videnskabelige værdi. Ligeledes at finder har indgået aftale med det lokale museum om at overdrage ikke-danefæ til lokalmuseet. Kvitteringsblanket skal være underskrevet.</li><li>Elektronisk fundrapportering til lokalmuseet (med foreløbige betegnelser, eventuelle løbenumre, koordinater, fotos).  </li><li>I tvivlstilfælde og ved mulighed for dybereliggende grav- eller skattefund kontaktes lokalmuseet  straks. Ingen gravning under pløjedybde!</li><li>Der gives løbende orientering om eventuelle fund til lodsejer og lokalmuseum.</li><li>Fund udsættes ikke for afrensning, imprægnering eller afstøbning</li><li>Fund udsættes ikke for skader eller informations-tab som følge af uhensigtsmæssig (eller langvarig) opbevaring.</li></ol><p><em>Ved grundig registrering af fundene i DIME opfyldes en række af ovenstående punkter udpeget af Nationalmuseet som særligt væsentlige for omhyggelig behandling af potentielt danefæ.</em></p><h3>Hvad kan være danefæ?</h3><p>Som udgangspunkt er fragmenter lige så vigtige som hele genstande i detektorsammenhæng, idet de(t) resterende fragment(er) oftest dukker op med tiden. Det afgørende for om noget bør erklæres for danefæ er altså typen af genstand - ikke genstandens tilstand. Hittegods er aldrig danefæ.</p><h4>Guld</h4><p>Alle genstande af guld er danefæ.</p><h4>Sølv</h4><p>+ Genstande af sølv fra før 1700 samt sølvklip og -fragmenter</p><p>- Sølv fra tiden efter 1700 med mindre det er af ekstraordinær karakter</p><h4>Bronze</h4><p>+ Bronzegenstande fra oldtid og vikingetid er danefæ</p><p>+ Genstande af bronze med særlig ornamentik eller udsmykning - f.eks. inskription eller emalje fra middelalder</p><p>+ Hele eller tilnærmelsesvis hele malmgryder</p><p>+ Vægtlodder</p><p>+ Seglstamper fra før 1700</p><p>- Simple genstande af bronze fra middelalder og renæssance</p><p>- Fragmenter af malmgryder</p><p>- Taphaner</p><p>- Nøgler eller hængelåse uden kunstnerisk udsmykning.</p><h4>Bly</h4><p>+ Vægtlodder</p><p>+ Støbemodeller</p><p>+ Tenvægte med særlig udsmykning fra middelalder</p><p>+ Klædeplomber med ornamentik og/eller skrift</p><p>+ Genstande med runer eller anden skrift</p><p>- Musketkugler</p><p>- Udaterbare smelteklumper og simple blygenstande fra tiden efter 1536</p><h4>Jern</h4><p>+ Ekstraordinære jerngenstande og genstande med f.eks. tauschering, indlægning, ornamentik; eksempelvis sværd fra oldtiden og middelalderen</p><p>- Andre genstande af jern fra oldtid og middelalder, våben som værktøj o.a.</p><h4>Mønter</h4><p>+ Mønter fra oldtid, vikingetid og middelalder (fra 1536 og før)</p><p>+ Mønter i skattefund - flere mønter nedlagt sammen</p><p>+ Guldmønter og større sølvmønter, f.eks. dalermønter fra tiden efter 1536.</p><p>- Småmønter af sølv og kobber fra tiden efter 1536</p><h4>Figurer</h4><p>+ Figurer og plastiske fremstillinger i sten, metal, ben, rav og træ</p><p>+ Figurer i keramik og tegl fra oldtid og middelalder</p><h4>Runer og anden indskrift</h4><p>+ Sten og andre genstande med runer og anden indskrift</p><p></p><p>Desuden omfatter listen af muligt Danefæ også en række ikke-metalliske genstande. For nærmere herom <a href=\"http://natmus.dk/salg-og-ydelser/museumsfaglige-ydelser/danefae/hvad-kan-vaere-danefae/\">se Nationalmuseets hjemmeside</a>.</p><p>(Kilde: Nationalmuseet)</p>', 0, NULL, NULL, 'sysadmin', '2017-05-03 13:14:23', 'sysadmin', '2017-01-31 23:12:14', ''),
(43, 'page', 'dime.detector', 'content', 'text', 'text/html', 'da', '<h2>Metaldetektorbrug i Danmark</h2><p>Siden 1970erne har metaldetektering vundet stor popularitet blandt private brugere i Danmark. Hvert år bruger entusiastiske detektorbrugere i tusindvis af timer på at afsøge marker over hele landet og bidrager alle på denne vis til at redde vigtige arkæologiske fund fra gradvis nedbrydning som følge af dyrkning, vind og vejr.<p>Tabt, ofret til guderne eller gemt til senere brug. De mange genstande, som bliver fundet med metaldetektor, er endt i jorden af vidt forskellige årsager igennem tiderne. De fleste er dog små enkeltliggende genstande, f.eks. mønter og smykker, som øjensynligt er blevet tabt under brug. Mange fund i et område indikerer derfor, at her har været høj aktivitet. Men mængden af fund afspejler i høj grad også, hvor udbredt brugen af metaller har været. Der er således betydeligt længere mellem fundene fra bronzealderen og de tidligste dele af jernalderen, hvor metaller udgjorde kostbare sjældenheder, end mellem fundene fra yngre jernalder og ikke mindst fra middelalderen og fremefter. På sammen vis er genstande af jern, bronze, bly og aluminium almindelige mens fund af sølv og i særdeleshed fund af guld naturligvis er anderledes sjældne.<p>Metaldetektorens effektive søgedybde afhænger af metalgenstandens karakter og markens overflade og udgør oftest kun nogle kun få cm, hvorfor dyrkede marker, hvor ploven jævnligt vender de dybere dele af muldlaget op til overfladen, opbyder de mest optimale ”jagtmarker”. Højsæsonen for metaldetektering er derfor ikke overraskende forår og efterår, hvor markerne står uden afgrøder.<h3>Regler</h3><p>I Danmark er det lovligt at gå med metaldetektor i de fleste områder. Der er dog nogle enkle regler, som skal overholdes, og Kulturstyrelsen har udarbejdet følgende vejledning til, hvordan man som detektorbruger skal og bør forholde sig.<p>Du skal:<ul><li>Du  skal sørge for at få tilladelse til at gå på det areal du ønsker, hos ejeren af jorden. Er ejeren offentlig, skal du henvende dig til den relevante myndighed, f.eks. en kommunes tekniske forvaltning. <a href=\"http://svana.dk/natur/friluftsliv/hvad-maa-jeg-i-naturen/\">For statens arealer, der forvaltes af Naturstyrelsen, gælder der særlige regler</a>.</li><li>Du skal aflevere de fundne genstande til det lokale museum (eller Nationalmuseet), såfremt du mener at der kan være tale om danefæ.</li></ul><p>Du må ikke:<ul><li>Du må ikke gå med detektor på fredede fortidsminder, eller nærmere end to meter fra fredningsgrænsen. Se om et fortidsminde er fredet på Kulturstyrelsens database <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a></li><li>Du må ikke foretage en udgravning af et fundområde, herunder grave dybere end pløjelaget.</li></ul><p>Du må gerne:<ul><li>Du må gerne gå med detektor på <a href=\"http://www.kulturstyrelsen.dk/index.php?id=13240\">kulturarvsarealer</a>, dog ikke på fredede fortidsminder indenfor arealerne, se <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund og Fortidsminder</a>, og du skal stadig spørge ejeren om lov.</li></ul><p>Om selve genstandene (danefæ):<ul><li>En række af de genstande du kan finde med en metaldetektor kan være danefæ (se menupunktet ”danefæ”). Danefæ tilhører staten, og er du det mindste i tvivl, om det du har fundet evt. kan være danefæ, skal du kontakte det lokale museum eller Nationalmuseet, der kan vejlede dig om det videre forløb.</li><li>Du må ikke sælge genstande/danefæ.</li><li>Du må ikke videregive genstande/danefæ.</li><li>Du bør behandle genstandene med omhu og forsigtighed, de er sårbare.</li><li>Du bør ikke rengøre, børste eller vaske genstande da informationer kan gå tabt.</li><li>Du bør opbevare genstande i en plastpose og æske med låg.</li><li>Du bør anvende en GPS til at måle dine fund ind med – også dem du er i tvivl om er noget.</li><li>Du bør notere findernavn, sted, dato og GPS-koordinater sammen med fundet. Hvis du skriver på en seddel der lægges i posen, så brug en blyant – aldrig kuglepen eller filtpen da skriftes let flyder ud hvis papiret bliver fugtigt.</li><li>Du bør markere fundområdet på et kort.</li></ul><p>Om fundstedet:<li>Du må ikke påbegynde en udgravning af fundstedet. Grav aldrig dybere end pløjelagets dybde.</li><p>Det er en god idé:<ul><li>At have god kontakt med lokalmuseet.</li><li>At have god kontakt med lodsejere.</li><li>At orientere sig i <a href=\"http://www.kulturarv.dk/fundogfortidsminder/\">Fund & Fortidsminder-databasen</a>.</li><li>At være medlem af den lokale detektorklub eller amatørarkæologiske forening.</li><li>At være to eller flere, der går sammen.</li><li>At have indbyrdes klare aftaler med hinanden og med lodsejer.</li><li>At være systematisk i sin søgen.</li><li>At føre dagbog over sin søgen.</li><li>At diskutere fundne genstande og afsøgningsmetoder i detektorklubben.</li></ul><h3>Metaldetektorfund og arkæologiske udgravninger</h3><p>Grundejere, der skal give lov til, at der må anvendes metaldetektor på ens ejendom – typisk landmænd – er indimellem usikre omkring, hvorvidt fund gjort med metaldetektor kan medføre udgravninger, som skal betales af ejeren af jorden. Fremkomsten af detektorfund vil i sig selv ikke medføre, at en jordejer påføres udgifter til en evt. efterfølgende arkæologisk udgravning.<p>De fleste detektorfund indgår i museernes samlinger - enten som danefæ på Nationalmuseet eller på det lokale museum som almindelige genstande, der indlemmes i museets samling. Enkelte fund, typisk fra nyere tid, kan beholdes af detektorføreren selv.<p>I de sjældne tilfælde, hvor der gøres et skattefund, f.eks. mønter eller værdifuldt metal, er museerne ofte interesserede i at gennemføre en begrænset undersøgelse af fundstedet. Formålet vil være at sikre de dele af skatten, der muligvis endnu er bevaret under pløjelaget. Herved kan man sikre en række væsentlige oplysninger om deponeringsmåden (i et lerkar, en læderpung eller lignende) og ofte også årsagen til deponeringen (til gudernes gunst eller i ufredstider). Samtidig sikrer man, at alle dele af skatten kommer til syne – og dermed er den videnskabelige værdi af fundet væsentligt større.<p>Når en skat i første omgang findes, skyldes det, at nogle af genstandene allerede ligger oppe i pløjelaget. De kan være ført derop af markredskaber for både 10, 50 eller 100 år siden. Altså som følge af ”jordarbejde i forbindelse med erosion eller jordarbejde udført som led i dyrkning af almindelige landbrugsafgrøder eller som led i almindelig skovdrift,” som det hedder i lovteksten (<a href=\"https://www.retsinformation.dk/forms/r0710.aspx?id=12017\">Museumslovens § 27, stk. 5. pind 1</a>). Arkæologiske undersøgelser af denne type skal ikke betales af jordejeren, men bekostes typisk af midler fra en pulje, som Slots- og Kulturstyrelsen råder over, efter ansøgning fra det lokale museum. Afhængig af undersøgelsens omfang og tidspunkt på året kan jordejeren kompenseres for eventuelle tab efter gældende regler for afgrødeerstatning.<h3>Fra landmand til bygherre</h3><p>Der kan dog opstå situationer, hvor detektorfund på længere sigt kan være en medvirkende årsag til, at der skal gennemføres en arkæologisk undersøgelse for landmandens regning – nemlig i det tilfælde, hvor han går fra at dyrke marken til at være bygherre. Et eksempel:<p>Hvis man forestiller sig, at der bliver gået med metaldetektor tæt ind til en eksisterende gård, og der på hele den vestlige side fremkommer spredte metalfund, f.eks. fra en bebyggelse fra vikingetid og ældre middelalder, vil det i første omgang ikke medføre en udgravning. Metaldetektorfundene er naturligvis med til at forøge vores viden om placeringen af landsbyer, bopladser og gravpladser rundt omkring i landskabet. På den måde er detektorfundene med til at give et mere detaljeret indblik i den forhistoriske udnyttelse af landskabet, end hvis vi ikke havde disse fund. Det svarer til fund af potteskår eller flintredskaber som f.eks. økser eller dolke.<p>Hvis landmanden på et senere tidspunkt ønsker at udvide sin gård, f.eks. med en ny løsdriftsstald med tilhørende gylletank og plansilo, vil metaldetektorfundene - på lige fod med alle andre oplysninger, som museet kender til (f.eks. overpløjede gravhøje, løsfundne stenoldsager, spor set fra luften eller som fremgår af såkaldte LiDAR-scanninger) - danne baggrund for den rådgivning, som museet vil tilbyde landmanden i forbindelse med hans byggeprojekt.<p>Landmanden kan i den forbindelse vælge at få gennemført en forundersøgelse af arealet (<a href=\"http://slks.dk/fortidsminder-diger/arkaeologi-paa-land/museernes-arkaeologiske-arbejde/vejledning-om-arkaeologiske-undersoegelser/\">se mere i Vejledning om arkæologiske undersøgelser</a>), og hvis det herefter viser sig, at der på det areal, hvor han ønsker at udvide gården, fremkommer væsentlige fortidsminder, er det museumslovens bestemmelse, at han som bygherre skal betale for den nødvendige arkæologiske undersøgelse før byggestart. En bygherre - i dette eksempel en landmand - kan i den forbindelse godt have den opfattelse, at det er metaldetektor-fundenes skyld, at han kommer til at betale for en arkæologisk undersøgelse. Det er dog ikke korrekt, for uanset om der er gjort metalfund eller ej, ville en arkæologisk forundersøgelse afsløre, at der er væsentlige fortidsminder bevaret under muldjorden i form af eksempelvis stolpehuller efter huse, brønde, hegnsspor og affaldsgruber. Museumsloven bestemmer herefter, at den nødvendige arkæologiske undersøgelse skal betales af bygherre, med mindre det er muligt at bevare fortidsminderne på stedet ved at ændre eller flytte anlægsarbejdet.  (Kilde: Kulturstyrelsen - http://slks.dk/fortidsminder-diger/metaldetektor-og-danefae/)', 0, NULL, NULL, 'sysadmin', '2017-05-03 13:14:27', 'sysadmin', '0000-00-00 00:00:00', '');
INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `object`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
INSERT INTO `ark_fragment_text` (`fid`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `object`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(46, 'actor', 'ARV', 'shortname', 'text', 'text/plain', 'da', 'ARKVEST', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(47, 'actor', 'BMR', 'shortname', 'text', 'text/plain', 'da', 'Bornholms', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(48, 'actor', 'DKM', 'shortname', 'text', 'text/plain', 'da', 'Holstebro', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(49, 'actor', 'FHM', 'shortname', 'text', 'text/plain', 'da', 'Moesgård', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(50, 'actor', 'HBV', 'shortname', 'text', 'text/plain', 'da', 'Sønderskov', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(51, 'actor', 'HEM', 'shortname', 'text', 'text/plain', 'da', 'Midtjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(52, 'actor', 'HOM', 'shortname', 'text', 'text/plain', 'da', 'Horsens', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(53, 'actor', 'KBM', 'shortname', 'text', 'text/plain', 'da', 'Københavns', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(54, 'actor', 'KNV', 'shortname', 'text', 'text/plain', 'da', 'Sydøstdanmark', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(55, 'actor', 'MKH', 'shortname', 'text', 'text/plain', 'da', 'Koldinghus', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(56, 'actor', 'MLF', 'shortname', 'text', 'text/plain', 'da', 'Lolland-Falster', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(57, 'actor', 'MNS', 'shortname', 'text', 'text/plain', 'da', 'Nordsjælland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(58, 'actor', 'MOE', 'shortname', 'text', 'text/plain', 'da', 'Østjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(59, 'actor', 'MSA', 'shortname', 'text', 'text/plain', 'da', 'Skive', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(60, 'actor', 'MSJ', 'shortname', 'text', 'text/plain', 'da', 'Sønderjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(61, 'actor', 'MVE', 'shortname', 'text', 'text/plain', 'da', 'Vestsjælland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(62, 'actor', 'NJM', 'shortname', 'text', 'text/plain', 'da', 'Nordjyllands', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(63, 'actor', 'OBM', 'shortname', 'text', 'text/plain', 'da', 'Odense', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(64, 'actor', 'ØFM', 'shortname', 'text', 'text/plain', 'da', 'Østfyns', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(65, 'actor', 'ØHM', 'shortname', 'text', 'text/plain', 'da', 'Øhavs', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(66, 'actor', 'ROM', 'shortname', 'text', 'text/plain', 'da', 'Roskilde', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(67, 'actor', 'SBM', 'shortname', 'text', 'text/plain', 'da', 'Skanderborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(68, 'actor', 'SJM', 'shortname', 'text', 'text/plain', 'da', 'Sydvestjyske', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(69, 'actor', 'SKH', 'shortname', 'text', 'text/plain', 'da', 'Silkeborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(70, 'actor', 'TAK', 'shortname', 'text', 'text/plain', 'da', 'Kroppedal', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(71, 'actor', 'THY', 'shortname', 'text', 'text/plain', 'da', 'Thy', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(72, 'actor', 'VHM', 'shortname', 'text', 'text/plain', 'da', 'Vendsyssel', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(73, 'actor', 'VKH', 'shortname', 'text', 'text/plain', 'da', 'Vejle', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(74, 'actor', 'VMÅ', 'shortname', 'text', 'text/plain', 'da', 'Vesthimmerlands', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(75, 'actor', 'VSM', 'shortname', 'text', 'text/plain', 'da', 'Viborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(77, 'actor', 'ARV', 'shortname', 'text', 'text/plain', 'en', 'ARKVEST', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(78, 'actor', 'BMR', 'shortname', 'text', 'text/plain', 'en', 'Bornholms', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(79, 'actor', 'DKM', 'shortname', 'text', 'text/plain', 'en', 'Holstebro', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(80, 'actor', 'FHM', 'shortname', 'text', 'text/plain', 'en', 'Moesgård', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(81, 'actor', 'HBV', 'shortname', 'text', 'text/plain', 'en', 'Sønderskov', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(82, 'actor', 'HEM', 'shortname', 'text', 'text/plain', 'en', 'Central Denmark', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(83, 'actor', 'HOM', 'shortname', 'text', 'text/plain', 'en', 'Horsens', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(84, 'actor', 'KBM', 'shortname', 'text', 'text/plain', 'en', 'Copenhagen', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(85, 'actor', 'KNV', 'shortname', 'text', 'text/plain', 'en', 'Southeast Denmark Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(86, 'actor', 'MKH', 'shortname', 'text', 'text/plain', 'en', 'Koldinghus', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(87, 'actor', 'MLF', 'shortname', 'text', 'text/plain', 'en', 'Lolland-Falster', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(88, 'actor', 'MNS', 'shortname', 'text', 'text/plain', 'en', 'North Zealand', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(89, 'actor', 'MOE', 'shortname', 'text', 'text/plain', 'en', 'East Jutland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(90, 'actor', 'MSA', 'shortname', 'text', 'text/plain', 'en', 'Skive', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(91, 'actor', 'MSJ', 'shortname', 'text', 'text/plain', 'en', 'South Jutland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(92, 'actor', 'MVE', 'shortname', 'text', 'text/plain', 'en', 'West Zealand', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(93, 'actor', 'NJM', 'shortname', 'text', 'text/plain', 'en', 'North Jutland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(94, 'actor', 'OBM', 'shortname', 'text', 'text/plain', 'en', 'Odense', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(95, 'actor', 'ØFM', 'shortname', 'text', 'text/plain', 'en', 'Østfyns', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(96, 'actor', 'ØHM', 'shortname', 'text', 'text/plain', 'en', 'Øhavs', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(97, 'actor', 'ROM', 'shortname', 'text', 'text/plain', 'en', 'Roskilde', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(98, 'actor', 'SBM', 'shortname', 'text', 'text/plain', 'en', 'Skanderborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(99, 'actor', 'SJM', 'shortname', 'text', 'text/plain', 'en', 'Southwest Jutland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(100, 'actor', 'SKH', 'shortname', 'text', 'text/plain', 'en', 'Silkeborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(101, 'actor', 'TAK', 'shortname', 'text', 'text/plain', 'en', 'Kroppedal', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(102, 'actor', 'THY', 'shortname', 'text', 'text/plain', 'en', 'Thy', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(103, 'actor', 'VHM', 'shortname', 'text', 'text/plain', 'en', 'Vendsyssel', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(104, 'actor', 'VKH', 'shortname', 'text', 'text/plain', 'en', 'Vejle', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(105, 'actor', 'VMÅ', 'shortname', 'text', 'text/plain', 'en', 'Vesthimmerlands', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(106, 'actor', 'VSM', 'shortname', 'text', 'text/plain', 'en', 'Viborg', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(108, 'actor', 'ARV', 'fullname', 'text', 'text/plain', 'da', 'ARKVEST Arkæologi Vestjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(109, 'actor', 'BMR', 'fullname', 'text', 'text/plain', 'da', 'Bornholms Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(110, 'actor', 'DKM', 'fullname', 'text', 'text/plain', 'da', 'De Kulturhistoriske Museer i Holstebro Kommune', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(111, 'actor', 'FHM', 'fullname', 'text', 'text/plain', 'da', 'Moesgård Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(112, 'actor', 'HBV', 'fullname', 'text', 'text/plain', 'da', 'Museet på Sønderskov', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(113, 'actor', 'HEM', 'fullname', 'text', 'text/plain', 'da', 'Museum Midtjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(114, 'actor', 'HOM', 'fullname', 'text', 'text/plain', 'da', 'Horsens Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(115, 'actor', 'KBM', 'fullname', 'text', 'text/plain', 'da', 'Københavns Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(116, 'actor', 'KNV', 'fullname', 'text', 'text/plain', 'da', 'Museum Sydøstdanmark', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(117, 'actor', 'MKH', 'fullname', 'text', 'text/plain', 'da', 'Museet på Koldinghus', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(118, 'actor', 'MLF', 'fullname', 'text', 'text/plain', 'da', 'Museum Lolland-Falster', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(119, 'actor', 'MNS', 'fullname', 'text', 'text/plain', 'da', 'Museum Nordsjælland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(120, 'actor', 'MOE', 'fullname', 'text', 'text/plain', 'da', 'Museum Østjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(121, 'actor', 'MSA', 'fullname', 'text', 'text/plain', 'da', 'Museum Salling, Skive Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(122, 'actor', 'MSJ', 'fullname', 'text', 'text/plain', 'da', 'Museum Sønderjylland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(123, 'actor', 'MVE', 'fullname', 'text', 'text/plain', 'da', 'Museum Vestsjælland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(124, 'actor', 'NJM', 'fullname', 'text', 'text/plain', 'da', 'Nordjyllands Historiske Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(125, 'actor', 'OBM', 'fullname', 'text', 'text/plain', 'da', 'Odense Bys Museer', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(126, 'actor', 'ØFM', 'fullname', 'text', 'text/plain', 'da', 'Østfyns Museer', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(127, 'actor', 'ØHM', 'fullname', 'text', 'text/plain', 'da', 'Øhavsmuseet', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(128, 'actor', 'ROM', 'fullname', 'text', 'text/plain', 'da', 'Roskilde Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(129, 'actor', 'SBM', 'fullname', 'text', 'text/plain', 'da', 'Skanderborg Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(130, 'actor', 'SJM', 'fullname', 'text', 'text/plain', 'da', 'Sydvestjyske Museer', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(131, 'actor', 'SKH', 'fullname', 'text', 'text/plain', 'da', 'Silkeborg Kulturhistoriske Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(132, 'actor', 'TAK', 'fullname', 'text', 'text/plain', 'da', 'Kroppedal Museum, Arkæologi', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(133, 'actor', 'THY', 'fullname', 'text', 'text/plain', 'da', 'Museum Thy', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(134, 'actor', 'VHM', 'fullname', 'text', 'text/plain', 'da', 'Vendsyssel Historiske Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(135, 'actor', 'VKH', 'fullname', 'text', 'text/plain', 'da', 'Vejle Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(136, 'actor', 'VMÅ', 'fullname', 'text', 'text/plain', 'da', 'Vesthimmerlands Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(137, 'actor', 'VSM', 'fullname', 'text', 'text/plain', 'da', 'Viborg Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(139, 'actor', 'ARV', 'fullname', 'text', 'text/plain', 'en', 'ARKVEST Archaeology Jutland', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(140, 'actor', 'BMR', 'fullname', 'text', 'text/plain', 'en', 'Bornholms Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(141, 'actor', 'DKM', 'fullname', 'text', 'text/plain', 'en', 'The Cultural History Museums in Holstebro Municipality', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(142, 'actor', 'FHM', 'fullname', 'text', 'text/plain', 'en', 'Moesgård Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(143, 'actor', 'HBV', 'fullname', 'text', 'text/plain', 'en', 'Museum at Sønderskov', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(144, 'actor', 'HEM', 'fullname', 'text', 'text/plain', 'en', 'Central Denmark Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(145, 'actor', 'HOM', 'fullname', 'text', 'text/plain', 'en', 'Horsens Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(146, 'actor', 'KBM', 'fullname', 'text', 'text/plain', 'en', 'Copenhagen Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(147, 'actor', 'KNV', 'fullname', 'text', 'text/plain', 'en', 'Southeast Denmark Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(148, 'actor', 'MKH', 'fullname', 'text', 'text/plain', 'en', 'Museum at Koldinghus', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(149, 'actor', 'MLF', 'fullname', 'text', 'text/plain', 'en', 'Lolland-Falster Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(150, 'actor', 'MNS', 'fullname', 'text', 'text/plain', 'en', 'North Zealand Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(151, 'actor', 'MOE', 'fullname', 'text', 'text/plain', 'en', 'East Jutland Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(152, 'actor', 'MSA', 'fullname', 'text', 'text/plain', 'en', 'Museum Salling, Skive Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(153, 'actor', 'MSJ', 'fullname', 'text', 'text/plain', 'en', 'South Jutland Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(154, 'actor', 'MVE', 'fullname', 'text', 'text/plain', 'en', 'West Zealand Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(155, 'actor', 'NJM', 'fullname', 'text', 'text/plain', 'en', 'North Jutland Historical Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(156, 'actor', 'OBM', 'fullname', 'text', 'text/plain', 'en', 'Odense City Museer', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(157, 'actor', 'ØFM', 'fullname', 'text', 'text/plain', 'en', 'Østfyns Museums', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(158, 'actor', 'ØHM', 'fullname', 'text', 'text/plain', 'en', 'Øhavs Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(159, 'actor', 'ROM', 'fullname', 'text', 'text/plain', 'en', 'Roskilde Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(160, 'actor', 'SBM', 'fullname', 'text', 'text/plain', 'en', 'Skanderborg Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(161, 'actor', 'SJM', 'fullname', 'text', 'text/plain', 'en', 'Southwest Jutland Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(162, 'actor', 'SKH', 'fullname', 'text', 'text/plain', 'en', 'Silkeborg Museum of Cultural History', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(163, 'actor', 'TAK', 'fullname', 'text', 'text/plain', 'en', 'Kroppedal Museum, Archaeology', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(164, 'actor', 'THY', 'fullname', 'text', 'text/plain', 'en', 'Thy Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(165, 'actor', 'VHM', 'fullname', 'text', 'text/plain', 'en', 'Vendsyssel Historical Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(166, 'actor', 'VKH', 'fullname', 'text', 'text/plain', 'en', 'Vejle Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(167, 'actor', 'VMÅ', 'fullname', 'text', 'text/plain', 'en', 'Vesthimmerlands Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(168, 'actor', 'VSM', 'fullname', 'text', 'text/plain', 'en', 'Viborg Museum', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(248, 'actor', 'anonymous', 'shortname', 'text', 'text/plain', 'da', 'Anonymous', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(249, 'actor', 'anonymous', 'fullname', 'text', 'text/plain', 'da', 'Anonymous', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(299, 'actor', 'sysadmin', 'shortname', 'text', 'text/plain', 'en', 'SysAdmin', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(300, 'actor', 'sysadmin', 'fullname', 'text', 'text/plain', 'en', 'System Administrator', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(353, 'actor', 'admin', 'shortname', 'text', 'text/plain', 'en', 'Admin', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(354, 'actor', 'admin', 'fullname', 'text', 'text/plain', 'en', 'Administrator', 0, NULL, NULL, 'sysadmin', '2017-02-15 14:12:03', 'sysadmin', '0000-00-00 00:00:00', ''),
(355, 'actor', 'registrar', 'fullname', 'text', 'text/plain', 'en', 'Registrar NJM', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:03', ''),
(356, 'actor', 'detectorist', 'fullname', 'text', 'text/plain', 'en', 'A Detectorist', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:34', ''),
(357, 'actor', 'researcher', 'fullname', 'text', 'text/plain', 'en', 'A Researcher', 0, NULL, NULL, 'sysadmin', '2018-01-12 12:13:03', 'sysadmin', '2018-01-12 12:13:03', '');

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
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `extent` time DEFAULT NULL,
  `object` int(11) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE `ark_item_actor` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actor',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.actor',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('admin', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'admin', 'admin', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', ''),
('anonymous', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'anonymous', 'anonymous', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', ''),
('ARV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ARV', 'ARV', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('BMR', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'BMR', 'BMR', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('detectorist', 'actor', 'core.actor', 'person', 'allocated', 'private', NULL, NULL, 'detectorist', 'detectorist', 'sysadmin', '2018-01-12 12:11:34', 'sysadmin', '2018-01-12 12:11:33', ''),
('DKM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'DKM', 'DKM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('FHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'FHM', 'FHM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('HBV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HBV', 'HBV', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('HEM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HEM', 'HEM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('HOM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'HOM', 'HOM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('jlayt', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'jlayt', 'jlayt', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('KBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'KBM', 'KBM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('KNV', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'KNV', 'KNV', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MKH', 'MKH', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MLF', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MLF', 'MLF', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MNS', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MNS', 'MNS', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MOE', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MOE', 'MOE', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MSA', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MSA', 'MSA', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MSJ', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MSJ', 'MSJ', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('MVE', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'MVE', 'MVE', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('NJM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'NJM', 'NJM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('OBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'OBM', 'OBM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('ØFM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ØFM', 'ØFM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('ØHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ØHM', 'ØHM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('registrar', 'actor', 'core.actor', 'person', 'allocated', 'private', NULL, NULL, 'registrar', 'registrar', 'sysadmin', '2018-01-12 12:10:03', 'sysadmin', '2018-01-12 12:10:02', ''),
('researcher', 'actor', 'core.actor', 'person', 'allocated', 'private', NULL, NULL, 'researcher', 'researcher', 'sysadmin', '2018-01-12 12:13:04', 'sysadmin', '2018-01-12 12:13:03', ''),
('ROM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'ROM', 'ROM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('SBM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SBM', 'SBM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('SJM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SJM', 'SJM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('SKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'SKH', 'SKH', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('sysadmin', 'actor', 'core.actor', 'person', 'registered', 'restricted', NULL, NULL, 'sysadmin', 'sysadmin', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', ''),
('TAK', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'TAK', 'TAK', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('THY', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'THY', 'THY', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('VHM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VHM', 'VHM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('VKH', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VKH', 'VKH', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('VMÅ', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VMÅ', 'VMÅ', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', ''),
('VSM', 'actor', 'core.actor', 'museum', 'registered', 'restricted', NULL, NULL, 'VSM', 'VSM', '0', '2017-04-29 12:55:29', '0', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_event`
--

CREATE TABLE `ark_item_event` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'event',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.event',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE `ark_item_file` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'file',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.file',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'find',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dime.find',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_message`
--

CREATE TABLE `ark_item_message` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'message',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.message',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_page`
--

CREATE TABLE `ark_item_page` (
  `id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'page',
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'core.page',
  `class` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allocated',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `parent_module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_item_page`
--

INSERT INTO `ark_item_page` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('dime.about', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'about', 'about', 'sysadmin', '2017-02-15 15:53:46', 'sysadmin', '0000-00-00 00:00:00', ''),
('dime.detector', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'detector', 'detector', 'sysadmin', '2017-02-15 15:53:46', 'sysadmin', '0000-00-00 00:00:00', ''),
('dime.news', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'news', 'news', 'sysadmin', '2017-02-15 15:53:46', 'sysadmin', '0000-00-00 00:00:00', ''),
('dime.research', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'research', 'research', 'sysadmin', '2017-02-15 15:53:46', 'sysadmin', '0000-00-00 00:00:00', ''),
('dime.treasure', 'page', 'core.page', '', 'registered', 'restricted', NULL, NULL, 'treasure', 'treasure', 'sysadmin', '2017-02-15 15:53:46', 'sysadmin', '2017-01-31 23:12:14', '');

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
('DIME', '', 'detectorist_id', 1, NULL, NULL),
('object', '', 'fid', 18, NULL, NULL);

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
  `recycle` tinyint(1) NOT NULL DEFAULT 0,
  `locked_by` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_sequence_reserve`
--

CREATE TABLE `ark_sequence_reserve` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_actor_role`
--

CREATE TABLE `ark_workflow_actor_role` (
  `actor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_for` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_actor_role`
--

INSERT INTO `ark_workflow_actor_role` (`actor`, `role`, `agent_for`, `enabled`, `expires_at`) VALUES
('admin', 'admin', 'admin', 1, NULL),
('anonymous', 'anonymous', 'anonymous', 1, NULL),
('detectorist', 'detectorist', 'detectorist', 1, NULL),
('registrar', 'registrar', 'NJM', 1, NULL),
('researcher', 'researcher', 'NJM', 1, NULL),
('sysadmin', 'sysadmin', 'sysadmin', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_actor_user`
--

CREATE TABLE `ark_workflow_actor_user` (
  `actor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_actor_user`
--

INSERT INTO `ark_workflow_actor_user` (`actor`, `user`, `enabled`, `expires_at`) VALUES
('admin', 'admin', 1, NULL),
('anonymous', 'anonymous', 1, NULL),
('detectorist', 'detectorist', 1, NULL),
('registrar', 'registrar', 1, NULL),
('researcher', 'researcher', 1, NULL),
('sysadmin', 'sysadmin', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_association`
--
ALTER TABLE `ark_association`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `association` (`association`),
  ADD KEY `item1` (`module1`,`id1`),
  ADD KEY `item2` (`module2`,`id2`);

--
-- Indexes for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `item` (`module`,`item`) USING BTREE;

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `value` (`value`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE;

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE;

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `extent` (`extent`),
  ADD KEY `value` (`value`),
  ADD KEY `item` (`module`,`item`) USING BTREE;

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `object_foreign` (`object`) USING BTREE;

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `extent` (`extent`),
  ADD KEY `value` (`value`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE;

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE;

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE;

--
-- Indexes for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE;

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE;
ALTER TABLE `ark_fragment_string` ADD FULLTEXT KEY `value` (`value`);
ALTER TABLE `ark_fragment_string` ADD FULLTEXT KEY `extent` (`extent`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE;
ALTER TABLE `ark_fragment_text` ADD FULLTEXT KEY `value` (`value`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`) USING BTREE,
  ADD KEY `attribute` (`module`,`attribute`) USING BTREE,
  ADD KEY `object_foreign` (`object`) USING BTREE,
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`) USING BTREE;

--
-- Indexes for table `ark_item_event`
--
ALTER TABLE `ark_item_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `label` (`label`) USING BTREE,
  ADD KEY `idx` (`idx`);

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`(191)) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE,
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`) USING BTREE;

--
-- Indexes for table `ark_item_message`
--
ALTER TABLE `ark_item_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`) USING BTREE;

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`) USING BTREE;

--
-- Indexes for table `ark_sequence`
--
ALTER TABLE `ark_sequence`
  ADD PRIMARY KEY (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sequence_foreign` (`module`,`parent`,`sequence`) USING BTREE;

--
-- Indexes for table `ark_sequence_reserve`
--
ALTER TABLE `ark_sequence_reserve`
  ADD PRIMARY KEY (`module`,`parent`,`sequence`,`block`),
  ADD KEY `sequence_foreign` (`module`,`parent`,`sequence`) USING BTREE;

--
-- Indexes for table `ark_workflow_actor_role`
--
ALTER TABLE `ark_workflow_actor_role`
  ADD PRIMARY KEY (`actor`,`role`,`agent_for`),
  ADD KEY `actor_foreign` (`actor`) USING BTREE,
  ADD KEY `agent_foreign` (`agent_for`) USING BTREE;

--
-- Indexes for table `ark_workflow_actor_user`
--
ALTER TABLE `ark_workflow_actor_user`
  ADD PRIMARY KEY (`actor`,`user`),
  ADD KEY `actor_foreign` (`actor`) USING BTREE;

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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=829;

--
-- AUTO_INCREMENT for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2395;

--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_fragment_blob`
--
ALTER TABLE `ark_fragment_blob`
  ADD CONSTRAINT `fragment_blob_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD CONSTRAINT `fragment_boolean_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD CONSTRAINT `ark_fragment_date_ibfk_1` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD CONSTRAINT `fragment_datetime_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD CONSTRAINT `fragment_decimal_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD CONSTRAINT `fragment_float_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD CONSTRAINT `fragment_integer_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD CONSTRAINT `fragment_item_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD CONSTRAINT `fragment_object_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  ADD CONSTRAINT `fragment_spatial_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD CONSTRAINT `fragment_string_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD CONSTRAINT `fragment_text_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD CONSTRAINT `fragment_time_object_constraint` FOREIGN KEY (`object`) REFERENCES `ark_fragment_object` (`fid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  ADD CONSTRAINT `sequence_lock_sequence_constraint` FOREIGN KEY (`module`,`parent`,`sequence`) REFERENCES `ark_sequence` (`module`, `parent`, `sequence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_sequence_reserve`
--
ALTER TABLE `ark_sequence_reserve`
  ADD CONSTRAINT `sequence_reserve_sequence_constraint` FOREIGN KEY (`module`,`parent`,`sequence`) REFERENCES `ark_sequence` (`module`, `parent`, `sequence`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_actor_role`
--
ALTER TABLE `ark_workflow_actor_role`
  ADD CONSTRAINT `workflow_actor_role_actor_constraint` FOREIGN KEY (`actor`) REFERENCES `ark_item_actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_actor_role_agent_constraint` FOREIGN KEY (`agent_for`) REFERENCES `ark_item_actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_actor_user`
--
ALTER TABLE `ark_workflow_actor_user`
  ADD CONSTRAINT `workflow_actor_user_actor_constraint` FOREIGN KEY (`actor`) REFERENCES `ark_item_actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;