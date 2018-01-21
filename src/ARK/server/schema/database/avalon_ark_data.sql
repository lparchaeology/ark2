-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2017 at 08:01 PM
-- Server version: 10.2.10-MariaDB
-- PHP Version: 7.1.11

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
-- Table structure for table `ark_item_area`
--

CREATE TABLE `ark_item_area` (
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
-- Table structure for table `ark_item_drawing`
--

CREATE TABLE `ark_item_drawing` (
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_item_area`
--
ALTER TABLE `ark_item_area`
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
-- Indexes for table `ark_item_drawing`
--
ALTER TABLE `ark_item_drawing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent_module`,`parent_id`),
  ADD KEY `idx` (`idx`),
  ADD KEY `label` (`label`);

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
-- Indexes for table `ark_item_photo`
--
ALTER TABLE `ark_item_photo`
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

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
