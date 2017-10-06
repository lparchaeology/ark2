-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2017 at 06:35 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.1.10-1+0~20170929170818.9+stretch~1.gbp501135

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
-- Database: `avalon_ark_data`
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blob',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` longblob,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'boolean',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` tinyint(1) DEFAULT NULL,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'date',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` date DEFAULT NULL,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'datetime',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` datetime DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_datetime`
--

INSERT INTO `ark_fragment_datetime` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, 8, 'file', '4', 'created', 'datetime', NULL, 'UTC', '2017-09-27 08:20:58', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(2, 8, 'file', '4', 'modified', 'datetime', NULL, 'UTC', '2017-09-27 08:20:58', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(3, NULL, 'event', '1', 'occurred', 'datetime', NULL, 'UTC', '2017-09-27 08:20:59', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(4, NULL, 'message', '1', 'sent', 'datetime', NULL, 'UTC', '2017-09-27 08:20:59', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE `ark_fragment_decimal` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'decimal',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'float',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` double DEFAULT NULL,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'integer',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` bigint(20) DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_integer`
--

INSERT INTO `ark_fragment_integer` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, 8, 'file', '4', 'sequence', 'integer', NULL, NULL, 20170927082058, 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE `ark_fragment_item` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'item',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_item`
--

INSERT INTO `ark_fragment_item` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, NULL, 'actor', 'sysadmin', 'avatar', 'item', NULL, 'file', '4', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(2, NULL, 'event', '1', 'agents', 'item', NULL, 'actor', 'anonymous', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(3, NULL, 'event', '1', 'subject', 'item', NULL, 'actor', 'sysadmin', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(4, NULL, 'message', '1', 'sender', 'item', NULL, 'actor', 'anonymous', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(5, NULL, 'message', '1', 'event', 'item', NULL, 'event', '1', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE `ark_fragment_object` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'object',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_object`
--

INSERT INTO `ark_fragment_object` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(7, NULL, 'actor', 'sysadmin', 'address', 'object', NULL, NULL, '', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(8, NULL, 'file', '4', 'versions', 'object', NULL, NULL, '', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(9, NULL, 'message', '1', 'recipients', 'object', NULL, NULL, '', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(10, NULL, 'message', '1', 'recipients', 'object', NULL, NULL, '', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_spatial`
--

CREATE TABLE `ark_fragment_spatial` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'spatial',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wkt',
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '4326',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` longtext COLLATE utf8mb4_unicode_ci,
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
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_string`
--

INSERT INTO `ark_fragment_string` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, NULL, 'actor', 'anonymous', 'id', 'string', NULL, NULL, 'anonymous', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(2, NULL, 'actor', 'anonymous', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(3, NULL, 'actor', 'sysadmin', 'class', 'string', NULL, 'core.actor.class', 'person', 0, NULL, 'anonymous', '2017-09-27 08:20:57', 'anonymous', '2017-09-27 08:20:57', ''),
(4, 7, 'actor', 'sysadmin', 'city', 'string', NULL, NULL, 'London', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(5, 7, 'actor', 'sysadmin', 'country', 'string', NULL, 'country', 'GB', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(6, 7, 'actor', 'sysadmin', 'postcode', 'string', NULL, NULL, 'E1 6QL', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(7, 7, 'actor', 'sysadmin', 'street', 'string', NULL, NULL, '1 Brick Lane', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(8, NULL, 'actor', 'sysadmin', 'telephone', 'string', NULL, NULL, '123456', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(9, NULL, 'file', '4', 'class', 'string', NULL, 'core.file.class', 'image', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(10, NULL, 'file', '4', 'mediatype', 'string', NULL, 'mediatype', 'image/png', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(11, NULL, 'file', '4', 'id', 'string', NULL, NULL, '4', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(12, 8, 'file', '4', 'path', 'string', NULL, NULL, 'image/0/4.20170927082058.png', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(13, 8, 'file', '4', 'name', 'string', NULL, NULL, 'Screen Shot 2017-09-06 at 09.52.15.png', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(14, 8, 'file', '4', 'extension', 'string', NULL, NULL, 'png', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(15, 8, 'file', '4', 'version', 'string', NULL, NULL, '2017-09-27 08:20:58', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(16, 8, 'file', '4', 'creator', 'string', NULL, NULL, 'anonymous', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(17, 8, 'file', '4', 'modifier', 'string', NULL, NULL, 'anonymous', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(18, NULL, 'actor', 'sysadmin', 'id', 'string', NULL, NULL, 'sysadmin', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(19, NULL, 'actor', 'sysadmin', 'email', 'string', NULL, NULL, 'sysadmin@lparchaeology.com', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(20, NULL, 'event', '1', 'class', 'string', NULL, 'core.event.class', 'registered', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(21, NULL, 'event', '1', 'id', 'string', NULL, NULL, '1', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(22, NULL, 'actor', 'sysadmin', 'status', 'string', NULL, 'core.security.status', 'registered', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(23, NULL, 'message', '1', 'class', 'string', NULL, 'core.message.class', 'notification', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(24, 9, 'message', '1', 'status', 'string', NULL, 'core.message.recipient.status', 'unread', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(25, 10, 'message', '1', 'role', 'string', NULL, NULL, 'admin', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', ''),
(26, NULL, 'message', '1', 'id', 'string', NULL, NULL, '1', 0, NULL, 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE `ark_fragment_text` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text/plain',
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` longtext COLLATE utf8mb4_unicode_ci,
  `modifier` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `version` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_text`
--

INSERT INTO `ark_fragment_text` (`fid`, `object`, `module`, `item`, `attribute`, `datatype`, `format`, `parameter`, `value`, `span`, `extent`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
(1, NULL, 'actor', 'anonymous', 'fullname', 'text', 'text/plain', 'en', 'Anonymous', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(2, NULL, 'actor', 'anonymous', 'shortname', 'text', 'text/plain', 'en', 'Anon', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(3, NULL, 'actor', 'anonymous', 'initials', 'text', 'text/plain', 'en', 'ANO', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(4, NULL, 'page', 'demo', 'content', 'text', 'text/html', 'en', '<div class=\"container theme-showcase\" role=\"main\">\r\n\r\n<br><br><br><br><br>\r\n\r\n<!-- TEXT STYLING -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">Headings &amp; Paragraphs</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <div class=\"col-md-6\">\r\n        <h1>Sample heading h1</h1>\r\n        <h2>Sample heading h2</h2>\r\n        <h3>Sample heading h3</h3>\r\n        <h4>Sample heading h4</h4>\r\n        <h5>Sample heading h5</h5>\r\n        <h6>Sample heading h6</h6>\r\n      </div>\r\n\r\n      <div class=\"col-md-6\">\r\n        <p><strong>Paragraph:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n        <br>\r\n        <p class=\"small\"><strong>Paragraph Small:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n      </div>\r\n    </div>\r\n  </div>\r\n\r\n<br><br>\r\n<!-- BUTTONS -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">BUTTONS</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <p>\r\n        <br>\r\n        <button type=\"button\" class=\"btn btn-lg btn-default\">Default</button>\r\n        <button type=\"button\" class=\"btn btn-lg btn-primary\">Primary</button>\r\n        <button type=\"button\" class=\"btn btn-lg btn-danger\">Danger</button>\r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n        <button type=\"button\" class=\"btn btn-lg btn-success\">Success</button>\r\n        <button type=\"button\" class=\"btn btn-lg btn-info\">Info</button>\r\n        <button type=\"button\" class=\"btn btn-lg btn-warning\">Warning</button>\r\n        <button type=\"button\" class=\"btn btn-lg btn-link\">Link</button>\r\n      </p><br>\r\n      <p>\r\n        <button type=\"button\" class=\"btn btn-default\">Default</button>\r\n        <button type=\"button\" class=\"btn btn-primary\">Primary</button>\r\n        <button type=\"button\" class=\"btn btn-danger\">Danger</button>\r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n        <button type=\"button\" class=\"btn btn-success\">Success</button>\r\n        <button type=\"button\" class=\"btn btn-info\">Info</button>\r\n        <button type=\"button\" class=\"btn btn-warning\">Warning</button>\r\n        <button type=\"button\" class=\"btn btn-link\">Link</button>\r\n      </p><br>\r\n      <p>\r\n        <button type=\"button\" class=\"btn btn-sm btn-default\">Default</button>\r\n        <button type=\"button\" class=\"btn btn-sm btn-primary\">Primary</button>\r\n        <button type=\"button\" class=\"btn btn-sm btn-danger\">Danger</button>\r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n        <button type=\"button\" class=\"btn btn-sm btn-success\">Success</button>\r\n        <button type=\"button\" class=\"btn btn-sm btn-info\">Info</button>\r\n        <button type=\"button\" class=\"btn btn-sm btn-warning\">Warning</button>\r\n        <button type=\"button\" class=\"btn btn-sm btn-link\">Link</button>\r\n      </p><br>\r\n    </div>\r\n  </div>\r\n\r\n<br><br>\r\n<!-- TABLE -->\r\n  <div class=\"row\">\r\n    <div class=\"col-md-12\">\r\n      <table class=\"table\">\r\n        <thead>\r\n          <tr>\r\n            <th>Name</th>\r\n            <th>Type</th>\r\n            <th>Registered text</th>\r\n            <th>Subgroup</th>\r\n            <th>Issued to</th>\r\n            <th>Issue date</th>\r\n          </tr>\r\n        </thead>\r\n        <tbody>\r\n          <tr>\r\n            <td><strong>MN012_1</strong></td>\r\n            <td>Deposit</td>\r\n            <td>Ward Boundary-Marker in situ, pre…</td>\r\n            <td>MN012_1421</td>\r\n            <td>Naralie Johnston</td>\r\n            <td>10 Jan, 2016</td>\r\n          </tr>\r\n          <tr>\r\n            <td><strong>MN012_1</strong></td>\r\n            <td>Deposit</td>\r\n            <td>Ward Boundary-Marker in situ, pre…</td>\r\n            <td>MN012_1421</td>\r\n            <td>Naralie Johnston</td>\r\n            <td>10 Jan, 2016</td>\r\n          </tr>\r\n          <tr>\r\n            <td><strong>MN012_1</strong></td>\r\n            <td>Deposit</td>\r\n            <td>Ward Boundary-Marker in situ, pre…</td>\r\n            <td>MN012_1421</td>\r\n            <td>Naralie Johnston</td>\r\n            <td>10 Jan, 2016</td>\r\n          </tr>\r\n          <td><strong>MN012_1</strong></td>\r\n          <td>Deposit</td>\r\n          <td>Ward Boundary-Marker in situ, pre…</td>\r\n          <td>MN012_1421</td>\r\n          <td>Naralie Johnston</td>\r\n          <td>10 Jan, 2016</td>\r\n        </tr>\r\n        <tr>\r\n          <td><strong>MN012_1</strong></td>\r\n          <td>Deposit</td>\r\n          <td>Ward Boundary-Marker in situ, pre…</td>\r\n          <td>MN012_1421</td>\r\n          <td>Naralie Johnston</td>\r\n          <td>10 Jan, 2016</td>\r\n        </tr>\r\n        </tbody>\r\n      </table>\r\n    </div>\r\n  </div>\r\n\r\n<br><br>\r\n<!-- LABELS -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">LABELS</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <p class=\"text-center\">\r\n        <span class=\"label label-primary\">context</span>\r\n        <span class=\"label label-danger\">find</span>\r\n        <span class=\"label label-warning\">photo</span>\r\n        <span class=\"label label-info\">section</span>\r\n        <span class=\"label label-success\">subgroup</span>\r\n        <span class=\"label label-mustard\">timber</span>\r\n        <span class=\"label label-brown\">sample</span>\r\n        <span class=\"label label-blue\">plan</span>\r\n        <span class=\"label label-default\">default</span>\r\n      </p>\r\n      <br>\r\n      <h4 class=\"text-center\">\r\n        <span class=\"label label-primary\">context</span>\r\n        <span class=\"label label-danger\">find</span>\r\n        <span class=\"label label-warning\">photo</span>\r\n        <span class=\"label label-info\">section</span>\r\n        <span class=\"label label-success\">subgroup</span>\r\n        <span class=\"label label-mustard\">timber</span>\r\n        <span class=\"label label-brown\">sample</span>\r\n        <span class=\"label label-blue\">plan</span>\r\n        <span class=\"label label-default\">default</span>\r\n      </h4>\r\n    </div>\r\n  </div>\r\n\r\n<br><br>\r\n<!-- CARDS -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">CARDS</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <div class=\"col-md-3\">\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-primary\">context</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://www.dyfedarchaeology.org.uk/nevern/plan.jpg\" class=\"img-responsive\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Issued to: Dan Eddisford</p>\r\n              <p>Issue Date: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-info\">section</span>\r\n            <div class=\"image\">\r\n              <img src=\"https://s-media-cache-ak0.pinimg.com/originals/26/1a/5d/261a5dd4c44b81063a9079247455e6f8.jpg\" class=\"img-responsive\" alt=\"\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Location: TP3</p>\r\n              <p>Context: MNO12_1, MNO12_2, MNO12_4, MNO12_5</p>\r\n              <p>Drawn by: Chriz Harward</p>\r\n              <p>Drawn on: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-warning\">photo</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://photos.projects-abroad.co.uk/volunteer-projects/archaeology/archaeology-romania.jpg\" class=\"img-responsive\" alt=\"\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_0001</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Ward Boundary-Marker in situ, pre demolition 100 Minories</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Taken by: Naralie Johnston</p>\r\n              <p>Taken on: 10 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-md-3\">\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-warning\">photo</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://photos.projects-abroad.co.uk/volunteer-projects/archaeology/archaeology-romania.jpg\" class=\"img-responsive\" alt=\"\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_0001</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Ward Boundary-Marker in situ, pre demolition 100 Minories</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Taken by: Naralie Johnston</p>\r\n              <p>Taken on: 10 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-blue\">plan</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://www.sbarch.org.uk/History_SG/Stoke_Park/Stoke_Park_Misc/Rotunda.jpg\" class=\"img-responsive\" alt=\"\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12</div>\r\n            <small>\r\n              <p>Type: Object</p>\r\n              <p>Context: MNO12_30</p>\r\n              <p>Register text: Lorem ipusaiydiua dusaydui asyduisay a dsuiyi…</p>\r\n              <p>Object material: N/A</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-danger\">find</span>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_30</div>\r\n            <small>\r\n              <p>Type: Object</p>\r\n              <p>Context: MNO12_30</p>\r\n              <p>Register text: Lorem ipusaiydiua dusaydui asyduisay a dsuiyi…</p>\r\n              <p>Object material: N/A</p>\r\n              <p>Date added: 08 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-md-3\">\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-success\">subgroup</span>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">Subgroup Test</div>\r\n            <small>\r\n              <p>Type: Object</p>\r\n              <p>Context: MNO12_30</p>\r\n              <p>Register text: Lorem ipusaiydiua dusaydui asyduisay a dsuiyi…</p>\r\n              <p>Object material: N/A</p>\r\n              <p>Date added: 08 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-primary\">context</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://www.dyfedarchaeology.org.uk/nevern/plan.jpg\" class=\"img-responsive\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Issued to: Dan Eddisford</p>\r\n              <p>Issue Date: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-warning\">photo</span>\r\n            <div class=\"image\">\r\n              <img src=\"http://photos.projects-abroad.co.uk/volunteer-projects/archaeology/archaeology-romania.jpg\" class=\"img-responsive\" alt=\"\">\r\n            </div>\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_0001</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Ward Boundary-Marker in situ, pre demolition 100 Minories</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Taken by: Naralie Johnston</p>\r\n              <p>Taken on: 10 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n      </div>\r\n\r\n      <div class=\"col-md-3\">\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-brown\">sample</span>\r\n            <img src=\"https://www.york.ac.uk/media/archaeology/images/Colluvial%20deposits%20Mwanga%20smaller.jpg\" class=\"img-responsive\">\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Issued to: Dan Eddisford</p>\r\n              <p>Issue Date: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-mustard\">timber</span>\r\n            <img src=\"http://www.britannia-archaeology.com/files/9614/3337/3296/North_Fen_Walkway.JPG\" class=\"img-responsive\">\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Issued to: Dan Eddisford</p>\r\n              <p>Issue Date: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n        <div class=\"card\">\r\n          <div class=\"card-header\">\r\n            <span class=\"label label-primary\">context</span>\r\n            <img src=\"https://msu.edu/~aarondan/archaeology_files/image006.jpg\" class=\"img-responsive\">\r\n          </div>\r\n          <div class=\"card-description\">\r\n            <div class=\"title\">MNO12_1</div>\r\n            <small>\r\n              <p>Type: Deposit</p>\r\n              <p>Registered text: Lorem ipsum dolor sit amet</p>\r\n              <p>Subgroup: MN012_1421</p>\r\n              <p>Issued to: Dan Eddisford</p>\r\n              <p>Issue Date: 14 Jan, 2016</p>\r\n            </small>\r\n          </div>\r\n        </div>\r\n      </div>\r\n      <div class=\"col-md-12\">\r\n        <p class=\"text-center\">\r\n          <button type=\"button\" class=\"btn btn-lg btn-default\">Load more</button>\r\n          <br><br>\r\n        </p>\r\n\r\n      </div>\r\n\r\n    </div>\r\n  </div>\r\n\r\n<br><br>\r\n<!-- HORIZONTAL PILLS -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">Horizontal Pills</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <div class=\"col-md-12\">\r\n        <ul class=\"nav nav-pills\">\r\n          <li role=\"presentation\" class=\"active\"><a href=\"#\">Selected Tab</a></li>\r\n          <li role=\"presentation\"><a href=\"#\">Tab Two</a></li>\r\n          <li role=\"presentation\"><a href=\"#\">Tab Three</a></li>\r\n          <li role=\"presentation\"><a href=\"#\">Tab Four</a></li>\r\n          <li role=\"presentation\"><a href=\"#\">Tab Five</a></li>\r\n          <li role=\"presentation\"><a href=\"#\">Tab Six</a></li>\r\n        </ul>\r\n      </div>\r\n    </div>\r\n  </div>\r\n\r\n<!-- VERTICAL PILLS -->\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">Vertical Pills</h3>\r\n    </div>\r\n    <br>\r\n    <div class=\"panel-body\">\r\n      <div class=\"col-md-2\">\r\n        <ul class=\"nav nav-pills nav-stacked nav-pills-stacked-example\">\r\n          <li role=\"presentation\" class=\"active\"><a href=\"#\">All Records</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-primary circle\"></span> &nbsp;Contexts</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-danger circle\"></span> &nbsp;Finds</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-warning circle\"></span> &nbsp;Photos</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-blue circle\"></span>  &nbsp;Plans</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-info circle\"></span> &nbsp;Sections</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-success circle\"></span> &nbsp;Sub-groups</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-mustard circle\"></span>  &nbsp;Timbers</a></li>\r\n          <li role=\"presentation\"><a href=\"#\"><span class=\"label label-brown circle\"></span>  &nbsp;Samples</a></li>\r\n        </ul>\r\n      </div>\r\n      <div class=\"col-md-10\">\r\n        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n        </p>\r\n      </div>\r\n    </div>\r\n    <br>\r\n  </div>\r\n\r\n  <div class=\"panel panel-default\">\r\n    <div class=\"panel-heading\">\r\n      <h3 class=\"panel-title\">Dropdowns & Dropups</h3>\r\n    </div>\r\n    <div class=\"panel-body\">\r\n      <div class=\"col-md-4\">\r\n        <div class=\"dropdown theme-dropdown clearfix\">\r\n          <a id=\"dropdownMenu1\" href=\"#\" class=\"sr-only dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Dropdown <span class=\"caret\"></span></a>\r\n          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">\r\n            <li class=\"active\"><a href=\"#\">Action</a></li>\r\n            <li><a href=\"#\">Another action</a></li>\r\n            <li><a href=\"#\">Something else here</a></li>\r\n            <li role=\"separator\" class=\"divider\"></li>\r\n            <li><a href=\"#\">Separated link</a></li>\r\n          </ul>\r\n        </div>\r\n\r\n\r\n        <div class=\"dropdown\">\r\n          <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">\r\n            Dropdown\r\n            <span class=\"caret\"></span>\r\n          </button>\r\n          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu2\">\r\n            <li><a href=\"#\">Action</a></li>\r\n            <li><a href=\"#\">Another action</a></li>\r\n            <li><a href=\"#\">Something else here</a></li>\r\n            <li role=\"separator\" class=\"divider\"></li>\r\n            <li><a href=\"#\">Separated link</a></li>\r\n          </ul>\r\n        </div>\r\n      </div>\r\n      <div class=\"col-md-4\">\r\n        <div class=\"dropdown theme-dropdown clearfix\">\r\n          <a id=\"dropdownMenu1\" href=\"#\" class=\"sr-only dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Dropdown <span class=\"caret\"></span></a>\r\n          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">\r\n            <li class=\"active\"><a href=\"#\">Action</a></li>\r\n            <li><a href=\"#\">Another action</a></li>\r\n            <li><a href=\"#\">Something else here</a></li>\r\n            <li role=\"separator\" class=\"divider\"></li>\r\n            <li><a href=\"#\">Separated link</a></li>\r\n          </ul>\r\n        </div>\r\n        <div class=\"dropup\">\r\n          <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">\r\n            Dropup\r\n            <span class=\"caret\"></span>\r\n          </button>\r\n          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu2\">\r\n            <li><a href=\"#\">Action</a></li>\r\n            <li><a href=\"#\">Another action</a></li>\r\n            <li><a href=\"#\">Something else here</a></li>\r\n            <li role=\"separator\" class=\"divider\"></li>\r\n            <li><a href=\"#\">Separated link</a></li>\r\n          </ul>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n\r\n\r\n\r\n  <div class=\"page-header\">\r\n    <h1>List groups</h1>\r\n  </div>\r\n  <div class=\"row\">\r\n    <div class=\"col-sm-4\">\r\n      <ul class=\"list-group\">\r\n        <li class=\"list-group-item\">Cras justo odio</li>\r\n        <li class=\"list-group-item\">Dapibus ac facilisis in</li>\r\n        <li class=\"list-group-item\">Morbi leo risus</li>\r\n        <li class=\"list-group-item\">Porta ac consectetur ac</li>\r\n        <li class=\"list-group-item\">Vestibulum at eros</li>\r\n      </ul>\r\n    </div><!-- /.col-sm-4 -->\r\n    <div class=\"col-sm-4\">\r\n      <div class=\"list-group\">\r\n        <a href=\"#\" class=\"list-group-item active\">\r\n          Cras justo odio\r\n        </a>\r\n        <a href=\"#\" class=\"list-group-item\">Dapibus ac facilisis in</a>\r\n        <a href=\"#\" class=\"list-group-item\">Morbi leo risus</a>\r\n        <a href=\"#\" class=\"list-group-item\">Porta ac consectetur ac</a>\r\n        <a href=\"#\" class=\"list-group-item\">Vestibulum at eros</a>\r\n      </div>\r\n    </div><!-- /.col-sm-4 -->\r\n    <div class=\"col-sm-4\">\r\n      <div class=\"list-group\">\r\n        <a href=\"#\" class=\"list-group-item active\">\r\n          <h4 class=\"list-group-item-heading\">List group item heading</h4>\r\n          <p class=\"list-group-item-text\">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>\r\n        </a>\r\n        <a href=\"#\" class=\"list-group-item\">\r\n          <h4 class=\"list-group-item-heading\">List group item heading</h4>\r\n          <p class=\"list-group-item-text\">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>\r\n        </a>\r\n        <a href=\"#\" class=\"list-group-item\">\r\n          <h4 class=\"list-group-item-heading\">List group item heading</h4>\r\n          <p class=\"list-group-item-text\">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>\r\n        </a>\r\n      </div>\r\n    </div><!-- /.col-sm-4 -->\r\n  </div>\r\n\r\n\r\n\r\n  <div class=\"page-header\">\r\n    <h1>Carousel</h1>\r\n  </div>\r\n  <div id=\"carousel-example-generic\" class=\"carousel slide\" data-ride=\"carousel\">\r\n    <ol class=\"carousel-indicators\">\r\n      <li data-target=\"#carousel-example-generic\" data-slide-to=\"0\" class=\"active\"></li>\r\n      <li data-target=\"#carousel-example-generic\" data-slide-to=\"1\"></li>\r\n      <li data-target=\"#carousel-example-generic\" data-slide-to=\"2\"></li>\r\n    </ol>\r\n    <div class=\"carousel-inner\" role=\"listbox\">\r\n      <div class=\"item active\">\r\n        <img src=\"http://anthro.ucsc.edu/images/20091205_CLWHD_arch_dig_0255.jpg?t=0\" alt=\"First slide\">\r\n      </div>\r\n      <div class=\"item\">\r\n        <img src=\"http://anthro.ucsc.edu/images/20091205_CLWHD_arch_dig_0255.jpg?t=0\" alt=\"Second slide\">\r\n      </div>\r\n      <div class=\"item\">\r\n        <img src=\"http://anthro.ucsc.edu/images/20091205_CLWHD_arch_dig_0255.jpg?t=0\" alt=\"Third slide\">\r\n      </div>\r\n    </div>\r\n    <a class=\"left carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"prev\">\r\n      <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>\r\n      <span class=\"sr-only\">Previous</span>\r\n    </a>\r\n    <a class=\"right carousel-control\" href=\"#carousel-example-generic\" role=\"button\" data-slide=\"next\">\r\n      <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>\r\n      <span class=\"sr-only\">Next</span>\r\n    </a>\r\n  </div>\r\n\r\n\r\n</div> <!-- /container -->', 0, NULL, 'core', '2017-09-06 00:00:00', 'core', '2017-09-06 00:00:00', NULL),
(5, NULL, 'actor', 'sysadmin', 'fullname', 'text', 'text/plain', 'en', 'Sysadmin', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(6, NULL, 'actor', 'sysadmin', 'shortname', 'text', 'text/plain', 'en', 'Sysadmin', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(7, NULL, 'actor', 'sysadmin', 'initials', 'text', 'text/plain', 'en', 'LPA', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', ''),
(8, NULL, 'actor', 'sysadmin', 'biography', 'text', 'text/plain', 'en', 'Sysadmin', 0, NULL, 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE `ark_fragment_time` (
  `fid` int(11) NOT NULL,
  `object` int(11) DEFAULT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'time',
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `span` tinyint(1) NOT NULL DEFAULT '0',
  `extent` time DEFAULT NULL,
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
('anonymous', 'actor', 'core.actor', 'person', 'allocated', 'public', NULL, NULL, 'anonymous', 'anonymous', '', '2017-09-06 00:00:00', '', '2017-09-06 00:00:00', NULL),
('sysadmin', 'actor', 'core.actor', 'person', 'allocated', 'private', NULL, NULL, 'sysadmin', 'sysadmin', 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_context`
--

CREATE TABLE `ark_item_context` (
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

--
-- Dumping data for table `ark_item_event`
--

INSERT INTO `ark_item_event` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('1', 'event', 'core.event', 'registered', 'allocated', 'private', 'actor', 'sysadmin', '1', '1', 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

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

--
-- Dumping data for table `ark_item_file`
--

INSERT INTO `ark_item_file` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('4', 'file', 'core.file', 'image', 'allocated', 'private', NULL, NULL, '4', '4', 'anonymous', '2017-09-27 08:20:58', 'anonymous', '2017-09-27 08:20:58', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_group`
--

CREATE TABLE `ark_item_group` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_landuse`
--

CREATE TABLE `ark_item_landuse` (
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

--
-- Dumping data for table `ark_item_message`
--

INSERT INTO `ark_item_message` (`id`, `module`, `schma`, `class`, `status`, `visibility`, `parent_module`, `parent_id`, `idx`, `label`, `modifier`, `modified`, `creator`, `created`, `version`) VALUES
('1', 'message', 'core.message', 'notification', 'allocated', 'private', NULL, NULL, '1', '1', 'anonymous', '2017-09-27 08:20:59', 'anonymous', '2017-09-27 08:20:59', '');

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
('demo', 'page', 'core.page', NULL, 'allocated', 'public', NULL, NULL, 'about', 'about', '', '2017-09-06 00:00:00', '', '2017-09-06 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_photo`
--

CREATE TABLE `ark_item_photo` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_plan`
--

CREATE TABLE `ark_item_plan` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_project`
--

CREATE TABLE `ark_item_project` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_sample`
--

CREATE TABLE `ark_item_sample` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_section`
--

CREATE TABLE `ark_item_section` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_site`
--

CREATE TABLE `ark_item_site` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_subgroup`
--

CREATE TABLE `ark_item_subgroup` (
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_timber`
--

CREATE TABLE `ark_item_timber` (
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
('event', '', 'id', 2, NULL, NULL),
('file', '', 'id', 5, NULL, NULL),
('message', '', 'id', 2, NULL, NULL),
('object', '', 'fid', 14, NULL, NULL);

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
  `locked_by` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked_on` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_sequence_lock`
--

INSERT INTO `ark_sequence_lock` (`id`, `module`, `parent`, `sequence`, `idx`, `recycle`, `locked_by`, `locked_on`) VALUES
(1, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:10:09'),
(2, 'file', '', 'id', 1, 0, NULL, '2017-09-27 09:10:10'),
(3, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:10:10'),
(4, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:10:56'),
(5, 'file', '', 'id', 1, 0, NULL, '2017-09-27 09:10:56'),
(6, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:10:56'),
(7, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:12:56'),
(8, 'file', '', 'id', 1, 0, NULL, '2017-09-27 09:12:57'),
(9, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:12:57'),
(10, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:20:58'),
(11, 'file', '', 'id', 1, 0, NULL, '2017-09-27 09:20:58'),
(12, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:20:58'),
(13, 'event', '', 'id', 1, 0, NULL, '2017-09-27 09:20:59'),
(14, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:20:59'),
(15, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:20:59'),
(16, 'message', '', 'id', 1, 0, NULL, '2017-09-27 09:20:59'),
(17, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:21:59'),
(18, 'file', '', 'id', 1, 0, NULL, '2017-09-27 09:21:59'),
(19, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:21:59'),
(20, 'event', '', 'id', 1, 0, NULL, '2017-09-27 09:21:59'),
(21, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:21:59'),
(22, 'object', '', 'fid', 1, 0, NULL, '2017-09-27 09:21:59'),
(23, 'message', '', 'id', 1, 0, NULL, '2017-09-27 09:21:59');

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
  `agent_for` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_actor_role`
--

INSERT INTO `ark_workflow_actor_role` (`actor`, `role`, `agent_for`, `enabled`, `expires_at`) VALUES
('anonymous', 'anonymous', NULL, 1, NULL),
('sysadmin', 'sysadmin', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_actor_user`
--

CREATE TABLE `ark_workflow_actor_user` (
  `actor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_actor_user`
--

INSERT INTO `ark_workflow_actor_user` (`actor`, `user`, `enabled`, `expires_at`) VALUES
('anonymous', 'anonymous', 1, NULL),
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
  ADD KEY `object_foreign` (`object`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `item` (`module`,`item`);

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `value` (`value`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`);

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `attribute` (`module`,`attribute`);

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `extent` (`extent`(191)),
  ADD KEY `value` (`value`(191)),
  ADD KEY `item` (`module`,`item`);

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `object_foreign` (`object`);

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `extent` (`extent`),
  ADD KEY `value` (`value`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`);

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`),
  ADD KEY `attribute` (`module`,`attribute`);

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `attribute` (`module`,`attribute`);

--
-- Indexes for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `attribute` (`module`,`attribute`);

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`);
ALTER TABLE `ark_fragment_string` ADD FULLTEXT KEY `value` (`value`);
ALTER TABLE `ark_fragment_string` ADD FULLTEXT KEY `extent` (`extent`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`);
ALTER TABLE `ark_fragment_text` ADD FULLTEXT KEY `value` (`value`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`),
  ADD KEY `attribute` (`module`,`attribute`),
  ADD KEY `object_foreign` (`object`),
  ADD KEY `value` (`value`),
  ADD KEY `extent` (`extent`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_context`
--
ALTER TABLE `ark_item_context`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_event`
--
ALTER TABLE `ark_item_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `label` (`label`),
  ADD KEY `idx` (`idx`);

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`(191));

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_group`
--
ALTER TABLE `ark_item_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_landuse`
--
ALTER TABLE `ark_item_landuse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_message`
--
ALTER TABLE `ark_item_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_page`
--
ALTER TABLE `ark_item_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_photo`
--
ALTER TABLE `ark_item_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_plan`
--
ALTER TABLE `ark_item_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_project`
--
ALTER TABLE `ark_item_project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_sample`
--
ALTER TABLE `ark_item_sample`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_section`
--
ALTER TABLE `ark_item_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_site`
--
ALTER TABLE `ark_item_site`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_subgroup`
--
ALTER TABLE `ark_item_subgroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

--
-- Indexes for table `ark_item_timber`
--
ALTER TABLE `ark_item_timber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

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
  ADD KEY `sequence_foreign` (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_sequence_reserve`
--
ALTER TABLE `ark_sequence_reserve`
  ADD PRIMARY KEY (`module`,`parent`,`sequence`,`block`),
  ADD KEY `sequence_foreign` (`module`,`parent`,`sequence`);

--
-- Indexes for table `ark_workflow_actor_role`
--
ALTER TABLE `ark_workflow_actor_role`
  ADD PRIMARY KEY (`actor`,`role`),
  ADD KEY `actor_foreign` (`actor`),
  ADD KEY `agent_foreign` (`agent_for`);

--
-- Indexes for table `ark_workflow_actor_user`
--
ALTER TABLE `ark_workflow_actor_user`
  ADD PRIMARY KEY (`actor`,`user`),
  ADD KEY `actor_foreign` (`actor`);

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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ark_fragment_spatial`
--
ALTER TABLE `ark_fragment_spatial`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_sequence_lock`
--
ALTER TABLE `ark_sequence_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
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
  ADD CONSTRAINT `workflow_actor_role_agent_constraint` FOREIGN KEY (`agent_for`) REFERENCES `ark_item_actor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
