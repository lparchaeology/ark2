-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2017 at 11:33 AM
-- Server version: 5.6.28
-- PHP Version: 7.0.10

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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` longblob NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_boolean`
--

CREATE TABLE `ark_fragment_boolean` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` tinyint(1) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_date`
--

CREATE TABLE `ark_fragment_date` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` date NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_datetime`
--

CREATE TABLE `ark_fragment_datetime` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` datetime NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_decimal`
--

CREATE TABLE `ark_fragment_decimal` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_float`
--

CREATE TABLE `ark_fragment_float` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` double NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_geometry`
--

CREATE TABLE `ark_fragment_geometry` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_integer`
--

CREATE TABLE `ark_fragment_integer` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` bigint(20) NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_item`
--

CREATE TABLE `ark_fragment_item` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_object`
--

CREATE TABLE `ark_fragment_object` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_string`
--

CREATE TABLE `ark_fragment_string` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_text`
--

CREATE TABLE `ark_fragment_text` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_time`
--

CREATE TABLE `ark_fragment_time` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` time NOT NULL,
  `object_fid` int(11) DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_actor`
--

CREATE TABLE `ark_item_actor` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_actor`
--

INSERT INTO `ark_item_actor` (`id`, `parent_module`, `parent_id`, `idx`, `name`, `modtype`, `schema_id`, `mod_by`, `mod_on`, `cre_by`, `cre_on`) VALUES
('1', NULL, NULL, '1', 'admin', 'person', 'core', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_campaign`
--

CREATE TABLE `ark_item_campaign` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_file`
--

CREATE TABLE `ark_item_file` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_find`
--

CREATE TABLE `ark_item_find` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_find`
--

INSERT INTO `ark_item_find` (`id`, `parent_module`, `parent_id`, `idx`, `name`, `modtype`, `schema_id`, `mod_by`, `mod_on`, `cre_by`, `cre_on`) VALUES
('1', NULL, NULL, '1', '1', NULL, 'dime', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_image`
--

CREATE TABLE `ark_item_image` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_item_location`
--

CREATE TABLE `ark_item_location` (
  `id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent_module` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idx` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schema_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mod_by` int(11) NOT NULL,
  `mod_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `cre_by` int(11) NOT NULL,
  `cre_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_item_location`
--

INSERT INTO `ark_item_location` (`id`, `parent_module`, `parent_id`, `idx`, `name`, `modtype`, `schema_id`, `mod_by`, `mod_on`, `cre_by`, `cre_on`) VALUES
('1', NULL, NULL, '1', '1', NULL, 'dime', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ark_relation_xmi`
--

CREATE TABLE `ark_relation_xmi` (
  `fid` int(11) NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `xmi_module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
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
  ADD KEY `property` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_boolean`
--
ALTER TABLE `ark_fragment_boolean`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_date`
--
ALTER TABLE `ark_fragment_date`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_decimal`
--
ALTER TABLE `ark_fragment_decimal`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_float`
--
ALTER TABLE `ark_fragment_float`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_geometry`
--
ALTER TABLE `ark_fragment_geometry`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `property` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_integer`
--
ALTER TABLE `ark_fragment_integer`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_item`
--
ALTER TABLE `ark_fragment_item`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_object`
--
ALTER TABLE `ark_fragment_object`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `item` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_string`
--
ALTER TABLE `ark_fragment_string`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_fragment_time`
--
ALTER TABLE `ark_fragment_time`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `module` (`module`,`item`,`property`);

--
-- Indexes for table `ark_item_actor`
--
ALTER TABLE `ark_item_actor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_campaign`
--
ALTER TABLE `ark_item_campaign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_file`
--
ALTER TABLE `ark_item_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE,
  ADD KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `ark_item_find`
--
ALTER TABLE `ark_item_find`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_image`
--
ALTER TABLE `ark_item_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE,
  ADD KEY `parent` (`parent_module`,`parent_id`) USING BTREE;

--
-- Indexes for table `ark_item_location`
--
ALTER TABLE `ark_item_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE,
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_datetime`
--
ALTER TABLE `ark_fragment_datetime`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_fragment_text`
--
ALTER TABLE `ark_fragment_text`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
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