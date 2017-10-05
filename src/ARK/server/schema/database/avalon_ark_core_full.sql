-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 04, 2017 at 05:16 PM
-- Server version: 10.2.9-MariaDB
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
-- Database: `avalon_ark_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass`
--

CREATE TABLE `ark_dataclass` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` tinyint(1) NOT NULL DEFAULT 0,
  `array` tinyint(1) NOT NULL DEFAULT 0,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `multiple` tinyint(1) NOT NULL DEFAULT 0,
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `readonly_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `static_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sortable` tinyint(1) NOT NULL DEFAULT 1,
  `searchable` tinyint(1) NOT NULL DEFAULT 1,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass`
--

INSERT INTO `ark_dataclass` (`dataclass`, `datatype`, `format_vocabulary`, `parameter_vocabulary`, `keyword`, `object`, `array`, `span`, `multiple`, `value_name`, `format_name`, `parameter_name`, `entity`, `form_type`, `active_form_type`, `readonly_form_type`, `static_form_type`, `parameter_form_type`, `format_form_type`, `sortable`, `searchable`, `enabled`, `deprecated`) VALUES
('actor', 'item', NULL, NULL, 'core.actor', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\Actor\\Actor', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('address', 'object', NULL, NULL, 'format.address', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('blob', 'blob', NULL, NULL, 'format.blob', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('boolean', 'boolean', NULL, NULL, 'format.boolean', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('color', 'string', NULL, NULL, 'format.colour', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('date', 'date', NULL, NULL, 'format.date', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('datetime', 'datetime', NULL, NULL, 'format.datetime', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('decimal', 'decimal', NULL, NULL, 'format.decimal', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('description', 'object', NULL, NULL, 'format.address', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('dispatch', 'object', NULL, NULL, 'format.recipient', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('distance', 'decimal', NULL, 'distance', 'format.distance', 0, 0, 0, 0, NULL, NULL, 'unit', NULL, 'ARK\\Form\\Type\\UnitPropertyType', NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, 1, 1, 1, 0),
('email', 'string', NULL, NULL, 'format.email', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('event', 'item', NULL, NULL, 'format.event', 1, 0, 0, 0, NULL, NULL, NULL, 'ARK\\Workflow\\Event', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('false', 'boolean', NULL, NULL, 'format.boolean', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('file', 'item', NULL, NULL, 'format.file', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\File\\File', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('float', 'float', NULL, NULL, 'format.float', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('html', 'text', NULL, NULL, 'format.html', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('identifier', 'string', NULL, NULL, 'format.identifier', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('image', 'item', NULL, NULL, 'format.image', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\File\\Image', 'ARK\\Form\\Type\\FilePropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', NULL, 'ARK\\Form\\Type\\ImageCollectionType', NULL, NULL, 0, 0, 1, 0),
('institution', 'item', NULL, NULL, 'core.actor.class.institution', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\Actor\\Institution', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('integer', 'integer', NULL, NULL, 'format.integer', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('item', 'item', NULL, NULL, 'format.item', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('key', 'string', NULL, NULL, 'format.key', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('markdown', 'text', NULL, NULL, 'format.markdown', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('mass', 'decimal', NULL, 'mass', 'format.mass', 0, 0, 0, 0, NULL, NULL, 'unit', NULL, 'ARK\\Form\\Type\\UnitPropertyType', NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, 1, 1, 1, 0),
('message', 'item', NULL, NULL, 'core.actor.format', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\Message\\Message', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('module', 'string', NULL, NULL, 'format.module', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('money', 'decimal', NULL, NULL, 'format.money', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('monthday', 'string', NULL, NULL, 'format.yearmonth', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('ordinaldate', 'string', NULL, NULL, 'format.ordinaldate', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('password', 'string', NULL, NULL, 'format.password', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('percent', 'float', NULL, NULL, 'format.percent', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('person', 'item', NULL, NULL, 'core.actor.class.person', 0, 0, 0, 0, NULL, NULL, NULL, 'ARK\\Actor\\Person', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, NULL, 0, 0, 1, 0),
('plaintext', 'text', NULL, NULL, 'format.localtext', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('richtext', 'text', NULL, NULL, 'format.richtext', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('shorttext', 'text', NULL, NULL, 'format.shortlocaltext', 1, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('spatial', 'spatial', NULL, NULL, 'format.geometry', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('string', 'string', NULL, NULL, 'format.string', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('telephone', 'string', NULL, NULL, 'format.telephone', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('term', 'string', NULL, NULL, 'format.identifier', 0, 0, 0, 0, 'term', NULL, 'concept', 'ARK\\Vocabulary\\Term', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, 1, 1, 1, 0),
('time', 'time', NULL, NULL, 'format.time', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('true', 'boolean', NULL, NULL, 'format.boolean', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('url', 'text', NULL, NULL, 'format.url', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('version', 'object', NULL, NULL, 'format.fileversion', 1, 0, 0, 0, NULL, NULL, NULL, 'ARK\\File\\FileVersion', 'ARK\\Form\\Type\\FilePropertyType', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('weekdate', 'string', NULL, NULL, 'format.weekdate', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('wkt', 'spatial', NULL, NULL, 'format.wkt', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 0),
('year', 'integer', NULL, NULL, 'format.year', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('yearmonth', 'string', NULL, NULL, 'format.yearmonth', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('yearspan', 'integer', NULL, NULL, 'format.yearspan', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0),
('yearweek', 'string', NULL, NULL, 'format.yearweek', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_attribute`
--

CREATE TABLE `ark_dataclass_attribute` (
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  `root` tinyint(1) NOT NULL DEFAULT 0,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `minimum` int(11) NOT NULL DEFAULT 0,
  `maximum` int(11) NOT NULL DEFAULT 1,
  `unique_values` int(11) NOT NULL DEFAULT 1,
  `additional_values` int(11) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_attribute`
--

INSERT INTO `ark_dataclass_attribute` (`parent`, `attribute`, `dataclass`, `vocabulary`, `keyword`, `sequence`, `root`, `span`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`) VALUES
('address', 'city', 'string', NULL, 'format.address.city', 2, 0, 0, 0, 1, 1, 0, 1, 0),
('address', 'country', 'term', 'country', 'format.address.country', 6, 0, 0, 1, 1, 1, 0, 1, 0),
('address', 'postcode', 'string', NULL, NULL, 4, 0, 0, 0, 1, 1, 0, 1, 0),
('address', 'street', 'string', NULL, 'format.address.street', 0, 1, 0, 1, 1, 1, 0, 1, 0),
('description', 'event', 'event', NULL, 'format.description.described', 2, 1, 0, 1, 1, 1, 0, 1, 0),
('description', 'text', 'plaintext', NULL, 'format.description.text', 0, 0, 0, 1, 1, 1, 0, 1, 0),
('dispatch', 'read', 'datetime', NULL, 'format.recipient.read_on', 4, 0, 0, 1, 1, 1, 0, 1, 0),
('dispatch', 'recipient', 'actor', NULL, 'format.recipient.sent_to', 2, 0, 0, 1, 1, 1, 0, 1, 0),
('dispatch', 'role', 'identifier', NULL, 'format.recipient.sent_to', 6, 0, 0, 1, 1, 1, 0, 1, 0),
('dispatch', 'status', 'term', 'core.message.recipient.status', 'format.recipient.status', 0, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'created', 'datetime', NULL, 'format.fileversion.created', 10, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'creator', 'string', NULL, 'format.fileversion.creator', 12, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'expires', 'datetime', NULL, 'format.fileversion.expires', 18, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'extension', 'string', NULL, NULL, 4, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'modified', 'datetime', NULL, 'format.fileversion.modified', 14, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'modifier', 'string', NULL, 'format.fileversion.modifier', 16, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'name', 'string', NULL, 'format.fileversion.name', 2, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'path', 'string', NULL, NULL, 0, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'sequence', 'integer', NULL, 'format.fileversion.sequence', 6, 1, 0, 1, 1, 1, 0, 1, 0),
('version', 'version', 'string', NULL, 'format.fileversion.string', 8, 1, 0, 1, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_blob`
--

CREATE TABLE `ark_dataclass_blob` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preset` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_blob`
--

INSERT INTO `ark_dataclass_blob` (`dataclass`, `preset`) VALUES
('blob', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_boolean`
--

CREATE TABLE `ark_dataclass_boolean` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preset` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_boolean`
--

INSERT INTO `ark_dataclass_boolean` (`dataclass`, `preset`) VALUES
('boolean', NULL),
('false', 0),
('true', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_date`
--

CREATE TABLE `ark_dataclass_date` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unicode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `php` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_date`
--

INSERT INTO `ark_dataclass_date` (`dataclass`, `pattern`, `unicode`, `php`, `preset`) VALUES
('date', '^([0-9]{4})(-)(1[0-2]|0[1-9])\\\\2(3[01]|0[1-9]|[12][0-9])$', NULL, 'Y-m-d', NULL),
('ordinaldate', '^([0-9]{4})-(36[0-6]|3[0-5][0-9]|[12][0-9]{2}|0[1-9][0-9]|00[1-9])$', NULL, 'Y-z', NULL),
('weekdate', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])-([1-7])$', NULL, 'o-W-N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_datetime`
--

CREATE TABLE `ark_dataclass_datetime` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unicode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `php` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_datetime`
--

INSERT INTO `ark_dataclass_datetime` (`dataclass`, `pattern`, `unicode`, `php`, `preset`) VALUES
('datetime', '^([0-9]{4})-(1[0-2]|0[1-9])-(3[01]|0[1-9]|[12][0-9])T(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])$', '', 'c', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_decimal`
--

CREATE TABLE `ark_dataclass_decimal` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prec` int(11) NOT NULL DEFAULT 200,
  `scale` int(11) NOT NULL DEFAULT 0,
  `minimum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT 0,
  `maximum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT 0,
  `multiple_of` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_decimal`
--

INSERT INTO `ark_dataclass_decimal` (`dataclass`, `prec`, `scale`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`, `preset`) VALUES
('decimal', 100, 100, NULL, 0, NULL, 0, '', NULL),
('mass', 100, 100, NULL, 0, NULL, 0, '', NULL),
('money', 198, 2, NULL, 0, NULL, 0, '0.01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_float`
--

CREATE TABLE `ark_dataclass_float` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` double DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT 0,
  `maximum` double DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT 0,
  `multiple_of` double DEFAULT NULL,
  `preset` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_float`
--

INSERT INTO `ark_dataclass_float` (`dataclass`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`, `preset`) VALUES
('float', NULL, 0, NULL, 0, NULL, NULL),
('percent', 0, 0, 100, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_integer`
--

CREATE TABLE `ark_dataclass_integer` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` int(11) DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT 0,
  `maximum` int(11) DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT 0,
  `multiple_of` int(11) DEFAULT 1,
  `preset` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_integer`
--

INSERT INTO `ark_dataclass_integer` (`dataclass`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`, `preset`) VALUES
('integer', -2147483648, 0, 2147483647, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_item`
--

CREATE TABLE `ark_dataclass_item` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_item`
--

INSERT INTO `ark_dataclass_item` (`dataclass`, `module`, `preset`) VALUES
('actor', 'actor', NULL),
('event', 'event', NULL),
('file', 'file', NULL),
('item', NULL, NULL),
('person', 'actor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_object`
--

CREATE TABLE `ark_dataclass_object` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_object`
--

INSERT INTO `ark_dataclass_object` (`dataclass`) VALUES
('address'),
('dispatch'),
('distance'),
('mass'),
('version');

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_spatial`
--

CREATE TABLE `ark_dataclass_spatial` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `srid` int(11) DEFAULT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_spatial`
--

INSERT INTO `ark_dataclass_spatial` (`dataclass`, `srid`, `format`, `extent`, `preset`) VALUES
('spatial', NULL, NULL, NULL, NULL),
('wkt', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_string`
--

CREATE TABLE `ark_dataclass_string` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL,
  `preset` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_string`
--

INSERT INTO `ark_dataclass_string` (`dataclass`, `pattern`, `min_length`, `max_length`, `default_size`, `preset`) VALUES
('color', '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$', 4, 7, 10, NULL),
('email', '^(?!^.{254})(([^@]+)@([^@]+))$', 3, 254, 30, NULL),
('identifier', '^(\\w{1,30})$', 1, 30, 30, NULL),
('key', '^(\\w{1,50})$', 1, 50, 50, NULL),
('module', '^(\\w{1,3})$', 3, 3, 3, NULL),
('monthday', '^(1[0-2]|0[1-9])\\\\2(3[01]|0[1-9]|[12][0-9])$', 6, 7, 7, NULL),
('telephone', '^([0-9+\\(\\)#\\.\\s\\/x-]+)$', 1, 30, 30, NULL),
('term', '^(\\w{1,30})$', 1, 30, 30, NULL),
('yearmonth', '^([0-9]{4})-(1[0-2]|0[1-9])$', 6, 7, 7, NULL),
('yearweek', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])$', 7, 8, 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_text`
--

CREATE TABLE `ark_dataclass_text` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL,
  `preset` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_text`
--

INSERT INTO `ark_dataclass_text` (`dataclass`, `mediatype`, `min_length`, `max_length`, `default_size`, `preset`) VALUES
('html', 'text/html', 1, 1431655765, 30, NULL),
('markdown', 'text/markdown', 1, 1431655765, 30, NULL),
('plaintext', 'text/plain', 1, 1431655765, 30, NULL),
('richtext', 'text/richtext', 1, 1431655765, 30, NULL),
('shorttext', 'text/plain', 1, 100, 30, NULL),
('url', 'text/url', 1, 2083, 50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_time`
--

CREATE TABLE `ark_dataclass_time` (
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unicode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `php` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preset` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_time`
--

INSERT INTO `ark_dataclass_time` (`dataclass`, `pattern`, `unicode`, `php`, `preset`) VALUES
('time', '^(2[0-3]|[01][0-9]):([0-5][0-9])$', '', 'H:i:s', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_dataclass_type`
--

CREATE TABLE `ark_dataclass_type` (
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` tinyint(1) NOT NULL,
  `temporal` tinyint(1) NOT NULL,
  `object` tinyint(1) NOT NULL DEFAULT 0,
  `compound` tinyint(1) NOT NULL DEFAULT 1,
  `storage_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_size` int(11) DEFAULT NULL,
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spanable` tinyint(1) NOT NULL DEFAULT 1,
  `model_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_entity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_entity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `readonly_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `static_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_dataclass_type`
--

INSERT INTO `ark_dataclass_type` (`datatype`, `parameter_vocabulary`, `format_vocabulary`, `keyword`, `number`, `temporal`, `object`, `compound`, `storage_type`, `storage_size`, `value_name`, `parameter_name`, `format_name`, `spanable`, `model_table`, `model_entity`, `data_table`, `data_entity`, `form_type`, `active_form_type`, `readonly_form_type`, `static_form_type`, `parameter_form_type`, `format_form_type`, `enabled`, `deprecated`) VALUES
('blob', NULL, 'mediatype', 'core.datatype.blob', 0, 0, 0, 1, 'blob', NULL, 'blob', NULL, 'mediatype', 0, 'ark_dataclass_blob', 'ARK\\Model\\Dataclass\\BlobDataclass', 'ark_fragment_blob', 'ARK\\Model\\Fragment\\BlobFragment', NULL, NULL, NULL, NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 0, 0),
('boolean', NULL, NULL, 'core.datatype.boolean', 0, 0, 0, 0, 'boolean', NULL, NULL, NULL, NULL, 0, 'ark_dataclass_boolean', 'ARK\\Model\\Dataclass\\BooleanDataclass', 'ark_fragment_boolean', 'ARK\\Model\\Fragment\\BooleanFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('date', NULL, NULL, 'core.datatype.date', 0, 1, 0, 0, 'date', NULL, NULL, NULL, NULL, 1, 'ark_dataclass_datetime', 'ARK\\Model\\Dataclass\\DateDataclass', 'ark_fragment_date', 'ARK\\Model\\Fragment\\DateFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('datetime', NULL, NULL, 'core.datatype.datetime', 0, 1, 0, 0, 'datetime', NULL, 'datetime', 'timezone', NULL, 1, 'ark_dataclass_datetime', 'ARK\\Model\\Dataclass\\DateTimeDataclass', 'ark_fragment_datetime', 'ARK\\Model\\Fragment\\DateTimeFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateTimeType', NULL, 'ARK\\Form\\Type\\StaticType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, 1, 0),
('decimal', NULL, NULL, 'core.datatype.decimal', 1, 0, 0, 0, 'string', 200, NULL, NULL, NULL, 1, 'ark_dataclass_decimal', 'ARK\\Model\\Dataclass\\DecimalDataclass', 'ark_fragment_decimal', 'ARK\\Model\\Fragment\\DecimalFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('float', NULL, NULL, 'core.datatype.float', 1, 0, 0, 0, 'float', NULL, NULL, NULL, NULL, 1, 'ark_dataclass_float', 'ARK\\Model\\Dataclass\\FloatDataclass', 'ark_fragment_float', 'ARK\\Model\\Fragment\\FloatFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('integer', NULL, NULL, 'core.datatype.integer', 1, 0, 0, 0, 'integer', NULL, NULL, NULL, NULL, 1, 'ark_dataclass_integer', 'ARK\\Model\\Dataclass\\IntegerDataclass', 'ark_fragment_integer', 'ARK\\Model\\Fragment\\IntegerFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('item', NULL, NULL, 'core.datatype.item', 0, 0, 0, 1, 'string', 30, 'id', 'module', NULL, 1, 'ark_dataclass_item', 'ARK\\Model\\Dataclass\\ItemDataclass', 'ark_fragment_item', 'ARK\\Model\\Fragment\\ItemFragment', 'ARK\\Form\\Type\\ScalarPropertyType', NULL, NULL, 'ARK\\Form\\Type\\StaticType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, 1, 0),
('object', NULL, NULL, 'core.datatype.object', 0, 0, 1, 0, 'integer', 0, NULL, NULL, NULL, 0, 'ark_dataclass_object', 'ARK\\Model\\Dataclass\\ObjectDataclass', 'ark_fragment_object', 'ARK\\Model\\Fragment\\ObjectFragment', 'ARK\\Form\\Type\\ObjectType', NULL, NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('spatial', 'spatial.crs', 'spatial.format', 'core.datatype.spatial', 0, 0, 0, 1, 'string', 1431655765, 'geometry', 'srid', 'format', 0, 'ark_dataclass_spatial', 'ARK\\Model\\Dataclass\\SpatialDataclass', 'ark_fragment_spatial', 'ARK\\Model\\Fragment\\SpatialFragment', 'ARK\\Form\\Type\\WktPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, 'ARK\\Form\\Type\\StaticType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 1, 0),
('string', NULL, NULL, 'core.datatype.string', 0, 0, 0, 0, 'string', 4000, NULL, NULL, NULL, 1, 'ark_dataclass_string', 'ARK\\Model\\Dataclass\\StringDataclass', 'ark_fragment_string', 'ARK\\Model\\Fragment\\StringFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('text', 'language', 'mediatype', 'core.datatype.text', 0, 0, 0, 1, 'string', 1431655765, 'content', 'language', 'mediatype', 0, 'ark_dataclass_text', 'ARK\\Model\\Dataclass\\TextDataclass', 'ark_fragment_text', 'ARK\\Model\\Fragment\\TextFragment', 'ARK\\Form\\Type\\LocalTextPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 1, 0),
('time', NULL, NULL, 'core.datatype.time', 0, 1, 0, 0, 'time', NULL, NULL, NULL, NULL, 1, 'ark_dataclass_datetime', 'ARK\\Model\\Dataclass\\TimeDataclass', 'ark_fragment_time', 'ARK\\Model\\Fragment\\TimeFragment', 'ARK\\Form\\Type\\ScalarPropertyType', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', NULL, 'ARK\\Form\\Type\\StaticType', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_instance`
--

CREATE TABLE `ark_instance` (
  `instance` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_instance`
--

INSERT INTO `ark_instance` (`instance`, `enabled`, `deprecated`) VALUES
('core', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_instance_route`
--

CREATE TABLE `ark_instance_route` (
  `instance` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_instance_schema`
--

CREATE TABLE `ark_instance_schema` (
  `instance` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_instance_schema`
--

INSERT INTO `ark_instance_schema` (`instance`, `schma`, `enabled`, `deprecated`) VALUES
('core', 'core.actor', 1, 0),
('core', 'core.event', 1, 0),
('core', 'core.file', 1, 0),
('core', 'core.message', 1, 0),
('core', 'core.page', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_map`
--

CREATE TABLE `ark_map` (
  `map` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `draggable` tinyint(1) NOT NULL DEFAULT 1,
  `clickable` tinyint(1) NOT NULL DEFAULT 1,
  `zoomable` tinyint(1) NOT NULL DEFAULT 1,
  `zoom` int(11) NOT NULL,
  `min_zoom` int(11) DEFAULT NULL,
  `max_zoom` int(11) DEFAULT NULL,
  `srid` int(11) DEFAULT NULL,
  `center` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_layer`
--

CREATE TABLE `ark_map_layer` (
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layer` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_map_layer`
--

INSERT INTO `ark_map_layer` (`source`, `layer`, `keyword`, `source_name`, `url`, `options`, `parameters`) VALUES
('bing', 'aerial', 'map.layer.bing.aerial', 'Aerial', '', '', ''),
('bing', 'aerialwithlabels', 'map.layer.bing.aerialwithlabels', 'AerialWithLabels', '', '', ''),
('bing', 'road', 'map.layer.bing.road', 'Road', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_legend`
--

CREATE TABLE `ark_map_legend` (
  `map` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layer` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seq` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_source`
--

CREATE TABLE `ark_map_source` (
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_expiry` datetime DEFAULT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_map_source`
--

INSERT INTO `ark_map_source` (`source`, `keyword`, `type`, `subtype`, `format`, `view_class`, `ticket`, `ticket_expiry`, `options`) VALUES
('bing', 'map.source.bing', 'raster', 'tile', 'bing', 'BingMaps', 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_module`
--

CREATE TABLE `ark_module` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_module`
--

INSERT INTO `ark_module` (`module`, `keyword`, `superclass`, `resource`, `project`, `namespace`, `entity`, `classname`, `tbl`, `core`, `enabled`, `deprecated`) VALUES
('actor', 'core.actor', 'actor', 'actors', 'ARK', 'ARK\\Actor', 'Actor', 'ARK\\Actor\\Actor', 'ark_item_actor', 1, 1, 0),
('event', 'core.event', 'event', 'events', 'ARK', 'ARK\\Workflow', 'Event', 'ARK\\Workflow\\Event', 'ark_item_event', 1, 1, 0),
('file', 'core.file', 'file', 'files', 'ARK', 'ARK\\File', 'File', 'ARK\\File\\File', 'ark_item_file', 1, 1, 0),
('message', 'core.message', 'message', 'messages', 'ARK', 'ARK\\Message', 'Message', 'ARK\\Message\\Message', 'ark_item_message', 1, 1, 0),
('page', 'core.page', 'page', 'page', 'ARK', 'ARK\\Entity', 'Page', 'ARK\\Entity\\Page', 'ark_item_page', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_route`
--

CREATE TABLE `ark_route` (
  `route` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_get` tinyint(1) NOT NULL DEFAULT 1,
  `can_post` tinyint(1) NOT NULL DEFAULT 0,
  `controller` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_route`
--

INSERT INTO `ark_route` (`route`, `page`, `redirect`, `path`, `can_get`, `can_post`, `controller`) VALUES
('admin', 'core_page_admin', NULL, '/admin', 1, 0, 'ARK\\Framework\\Controller\\AdminPageController'),
('admin.event.list', NULL, NULL, '/admin/events', 1, 0, 'ARK\\Framework\\Controller\\EventListPageController'),
('admin.event.view', NULL, NULL, '/admin/events/{event}', 1, 0, 'ARK\\Framework\\Controller\\EventPageController'),
('admin.file.add', NULL, NULL, '/admin/files/add', 1, 0, 'ARK\\Framework\\Controller\\FileAddPageController'),
('admin.file.list', NULL, NULL, '/admin/files', 1, 0, 'ARK\\Framework\\Controller\\FileListPageController'),
('admin.file.view', NULL, NULL, '/admin/files/{file}', 1, 0, 'ARK\\Framework\\Controller\\FilePageController'),
('admin.message.list', NULL, NULL, '/admin/messages', 1, 0, 'ARK\\Framework\\Controller\\MessageListPageController'),
('admin.message.view', NULL, NULL, '/admin/messages/{message}', 1, 0, 'ARK\\Framework\\Controller\\MessagePageController'),
('admin.page.list', NULL, NULL, '/admin/pages', 1, 0, 'ARK\\Framework\\Controller\\PageListPageController'),
('admin.page.view', NULL, NULL, '/admin/pages/{page}', 1, 0, 'ARK\\Framework\\Controller\\PagePageController'),
('admin.user.list', 'core_page_admin_user_list', NULL, '/admin/users', 1, 1, 'ARK\\Security\\Controller\\UserAdminListPageController'),
('admin.user.register', 'core_page_admin_user_register', NULL, '/admin/users/register', 1, 1, 'ARK\\Security\\Controller\\UserRegisterPageController'),
('admin.user.view', 'core_page_admin_user', NULL, '/admin/users/{user}', 1, 1, 'ARK\\Security\\Controller\\UserAdminPageController'),
('admin.vocabulary.list', NULL, NULL, '/admin/vocabularies', 1, 0, 'ARK\\Framework\\Controller\\VocabularyListPageController'),
('admin.vocabulary.term.list', NULL, NULL, '/admin/vocabularies/{vocabulary}/terms', 1, 0, 'ARK\\Framework\\Controller\\VocabularyTermListPageController'),
('admin.vocabulary.term.view', NULL, NULL, '/admin/vocabularies/{vocabulary}/terms/{term}', 1, 0, 'ARK\\Framework\\Controller\\VocabularyTermPageController'),
('admin.vocabulary.view', NULL, NULL, '/admin/vocabularies/{vocabulary}', 1, 0, 'ARK\\Framework\\Controller\\VocabularyPageController'),
('home', 'core_page_home', NULL, '/', 1, 0, 'ARK\\Framework\\Controller\\HomePageController'),
('img', NULL, NULL, '/img/{image}', 1, 0, 'ARK\\Framework\\Controller\\ImageController'),
('news', 'core_page_news', NULL, '/news', 1, 0, 'ARK\\Framework\\Controller\\NewsPageController'),
('profile.list', NULL, NULL, '/profiles', 1, 0, 'ARK\\Security\\Controller\\UserProfileListPageController'),
('profile.message.list', NULL, NULL, '/profiles/{profile}/messages', 1, 0, 'ARK\\Framework\\Controller\\MessageListPageController'),
('profile.message.view', NULL, NULL, '/profiles/{profile}/messages/{message}', 1, 0, 'ARK\\Framework\\Controller\\MessagePageController'),
('profile.view', NULL, NULL, '/profiles/{profile}', 1, 0, 'ARK\\Security\\Controller\\UserProfilePageController'),
('static.demo', 'core_page_static', NULL, '/demo', 1, 0, 'ARK\\Framework\\Controller\\StaticPageController'),
('user.check', NULL, NULL, '/users/check', 1, 1, ''),
('user.confirm', 'core_page_user_confirm', NULL, '/users/confirm', 1, 1, 'ARK\\Security\\Controller\\UserConfirmPageController'),
('user.login', 'core_page_user_login', NULL, '/users/login', 1, 1, 'ARK\\Security\\Controller\\UserLoginPageController'),
('user.register', 'core_page_user_register', NULL, '/users/register', 1, 1, 'ARK\\Security\\Controller\\UserRegisterPageController'),
('user.reset', 'core_page_user_reset', NULL, '/users/reset', 1, 1, 'ARK\\Security\\Controller\\UserResetPageController'),
('user.verify', NULL, NULL, '/users/verify', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_route_parameter`
--

CREATE TABLE `ark_route_parameter` (
  `route` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_route_parameter`
--

INSERT INTO `ark_route_parameter` (`route`, `parameter`) VALUES
('admin.message.view', 'message'),
('profile.message.view', 'message'),
('profile.message.view', 'profile'),
('profile.view', 'profile');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema`
--

CREATE TABLE `ark_schema` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remove` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_property` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entities` tinyint(1) NOT NULL DEFAULT 0,
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `generator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema`
--

INSERT INTO `ark_schema` (`schma`, `module`, `vocabulary`, `event`, `new`, `view`, `edit`, `remove`, `keyword`, `class_property`, `entities`, `visibility`, `generator`, `sequence`, `enabled`, `deprecated`) VALUES
('core.actor', 'actor', 'core.actor.class', NULL, 'core.actor.create', 'core.actor.read', 'core.actor.update', 'core.actor.delete', 'core.actor', 'class', 1, 'restricted', 'assigned', NULL, 1, 0),
('core.event', 'event', 'core.event.class', NULL, 'core.event.create', 'core.event.read', 'core.event.update', 'core.event.delete', 'core.event', 'class', 0, 'restricted', 'sequence', 'id', 1, 0),
('core.file', 'file', 'core.file.class', NULL, 'core.file.create', 'core.event.read', 'core.file.update', 'core.file.delete', 'core.file', 'class', 1, 'restricted', 'sequence', 'id', 1, 0),
('core.message', 'message', 'core.message.class', NULL, 'core.message.create', 'core.message.read', 'core.message.update', 'core.message.delete', 'core.message', 'class', 1, 'restricted', 'sequence', 'id', 1, 0),
('core.page', 'page', NULL, NULL, 'core.page.create', 'core.page.read', 'core.page.update', 'core.page.delete', 'core.page', NULL, 0, 'public', 'assigned', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_association`
--

CREATE TABLE `ark_schema_association` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schema1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schema2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` int(11) NOT NULL,
  `inverse` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inverse_degree` int(11) NOT NULL,
  `bidirectional` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_attribute`
--

CREATE TABLE `ark_schema_attribute` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `span` tinyint(1) NOT NULL DEFAULT 0,
  `minimum` int(11) NOT NULL DEFAULT 0,
  `maximum` int(11) NOT NULL DEFAULT 1,
  `unique_values` int(11) NOT NULL DEFAULT 1,
  `additional_values` int(11) NOT NULL DEFAULT 0,
  `event` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_attribute`
--

INSERT INTO `ark_schema_attribute` (`schma`, `class`, `attribute`, `dataclass`, `vocabulary`, `edit`, `view`, `keyword`, `span`, `minimum`, `maximum`, `unique_values`, `additional_values`, `event`, `visibility`, `enabled`, `deprecated`) VALUES
('core.actor', 'actor', 'address', 'address', NULL, NULL, NULL, 'core.actor.address', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'avatar', 'image', NULL, NULL, NULL, 'core.actor.avatar', 0, 0, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'biography', 'plaintext', NULL, NULL, NULL, 'core.actor.biography', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'class', 'term', 'core.actor.class', 'core.actor.update', 'core.actor.read', 'core.actor.class', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.actor', 'actor', 'email', 'email', NULL, 'core.actor.update', 'core.actor.read', 'core.actor.email', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.actor', 'actor', 'fullname', 'shorttext', NULL, NULL, NULL, 'core.actor.fullname', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'id', 'identifier', NULL, 'core.actor.update', 'core.actor.read', 'core.actor.id', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.actor', 'actor', 'initials', 'shorttext', NULL, NULL, NULL, 'core.actor.initials', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'shortname', 'shorttext', NULL, NULL, NULL, 'core.actor.shortname', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.actor', 'actor', 'telephone', 'telephone', NULL, 'core.actor.update', 'core.actor.read', 'core.actor.telephone', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.actor', 'person', 'status', 'term', 'core.security.user.status', 'core.admin.user', 'core.admin.user', 'core.security.user.status', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.actor', 'person', 'terms', 'term', 'core.user.terms', 'core.actor.update', 'core.actor.read', 'core.user.terms', 0, 1, 1, 1, 0, NULL, 'restricted', 1, 0),
('core.event', 'event', 'agents', 'actor', NULL, NULL, NULL, 'core.event.agent', 0, 1, 0, 1, 0, NULL, 'public', 1, 0),
('core.event', 'event', 'class', 'term', 'core.event.class', NULL, NULL, 'core.event.class', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.event', 'event', 'id', 'identifier', NULL, NULL, NULL, 'core.event.id', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.event', 'event', 'occurred', 'datetime', NULL, NULL, NULL, 'core.event.occurred', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.event', 'event', 'subject', 'item', NULL, NULL, NULL, 'core.event.subject', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'class', 'term', 'core.file.class', NULL, NULL, 'core.file.class', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'copyright', 'actor', NULL, NULL, NULL, 'core.file.copyright', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'description', 'plaintext', NULL, NULL, NULL, 'core.file.description', 0, 0, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'id', 'identifier', NULL, NULL, NULL, 'core.file.id', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'license', 'term', 'core.license', NULL, NULL, 'core.file.status', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'mediatype', 'term', 'mediatype', NULL, NULL, 'core.file.mediatype', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'status', 'term', 'core.file.status', NULL, NULL, 'core.file.status', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'title', 'shorttext', NULL, NULL, NULL, 'core.file.title', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.file', 'file', 'versions', 'version', NULL, NULL, NULL, 'core.file.versions', 0, 1, 0, 1, 0, NULL, 'public', 1, 0),
('core.message', 'mail', 'attachments', 'file', NULL, NULL, NULL, 'core.message.mail.attachments', 0, 0, 0, 1, 0, NULL, 'public', 1, 0),
('core.message', 'mail', 'body', 'plaintext', NULL, NULL, NULL, 'core.message.mail.body', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'mail', 'subject', 'shorttext', NULL, NULL, NULL, 'core.message.mail.subject', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'message', 'class', 'term', 'core.message.class', NULL, NULL, 'core.message.class', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'message', 'id', 'identifier', NULL, NULL, NULL, 'core.message.id', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'message', 'recipients', 'dispatch', NULL, NULL, NULL, 'core.message.recipients', 0, 1, 0, 1, 0, NULL, 'public', 1, 0),
('core.message', 'message', 'sender', 'actor', NULL, NULL, NULL, 'core.message.sender', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'message', 'sent', 'datetime', NULL, NULL, NULL, 'core.message.sent_at', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.message', 'notification', 'event', 'event', NULL, NULL, NULL, 'core.message.notification.event', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.page', 'page', 'content', 'html', NULL, NULL, NULL, 'property.content', 0, 1, 1, 1, 0, NULL, 'public', 1, 0),
('core.page', 'page', 'id', 'identifier', NULL, NULL, NULL, 'core.page.id', 0, 1, 1, 1, 0, NULL, 'public', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_item`
--

CREATE TABLE `ark_schema_item` (
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dataclass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum` int(11) NOT NULL DEFAULT 0,
  `maximum` int(11) NOT NULL DEFAULT 1,
  `unique_values` int(11) NOT NULL DEFAULT 1,
  `additional_values` int(11) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_item`
--

INSERT INTO `ark_schema_item` (`attribute`, `dataclass`, `vocabulary`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('class', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.type'),
('id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.id'),
('index', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.index'),
('label', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.label'),
('module', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.module'),
('schema', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.module'),
('status', 'identifier', 'core.item.status', 1, 1, 1, 0, 1, 0, 'core.item.status');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation`
--

CREATE TABLE `ark_translation` (
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_plural` tinyint(1) NOT NULL DEFAULT 0,
  `has_parameters` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation`
--

INSERT INTO `ark_translation` (`keyword`, `domain`, `is_plural`, `has_parameters`) VALUES
('core.action.activate', 'vocabulary', 0, 0),
('core.action.approve', 'core', 0, 0),
('core.action.cancel', 'core', 0, 0),
('core.action.edit', 'core', 0, 0),
('core.action.redact', 'core', 0, 0),
('core.action.register', 'core', 0, 0),
('core.action.reject', 'core', 0, 0),
('core.action.restore', 'core', 0, 0),
('core.action.select', 'core', 0, 0),
('core.action.suspend', 'core', 0, 0),
('core.action.view', 'core', 0, 0),
('core.action.view1', 'core', 0, 0),
('core.actor', 'core', 0, 0),
('core.actor.address', 'core', 0, 0),
('core.actor.avatar', 'core', 0, 0),
('core.actor.biography', 'core', 0, 0),
('core.actor.class', 'vocabulary', 0, 0),
('core.actor.class.institution', 'vocabulary', 0, 0),
('core.actor.class.museum', 'vocabulary', 0, 0),
('core.actor.class.person', 'vocabulary', 0, 0),
('core.actor.email', 'core', 0, 0),
('core.actor.event', 'vocabulary', 0, 0),
('core.actor.event.activated', 'vocabulary', 0, 0),
('core.actor.event.approved', 'vocabulary', 0, 0),
('core.actor.event.cancelled', 'vocabulary', 0, 0),
('core.actor.event.registered', 'vocabulary', 0, 0),
('core.actor.event.restored', 'vocabulary', 0, 0),
('core.actor.event.suspended', 'vocabulary', 0, 0),
('core.actor.format', 'core', 0, 0),
('core.actor.fullname', 'core', 0, 0),
('core.actor.id', 'core', 0, 0),
('core.actor.initials', 'core', 0, 0),
('core.actor.institution', 'core', 0, 0),
('core.actor.license', 'core', 0, 0),
('core.actor.module', 'core', 0, 0),
('core.actor.person', 'core', 0, 0),
('core.actor.schema', 'core', 0, 0),
('core.actor.shortname', 'core', 0, 0),
('core.actor.telephone', 'core', 0, 0),
('core.actor.visibility', 'core', 0, 0),
('core.admin', 'core', 0, 0),
('core.admin.user.register', 'core', 0, 0),
('core.blank', 'core', 0, 0),
('core.button.apply', 'core', 0, 0),
('core.button.change', 'core', 0, 0),
('core.button.clone', 'core', 0, 0),
('core.button.save', 'core', 0, 0),
('core.button.search', 'core', 0, 0),
('core.button.select', 'core', 0, 0),
('core.button.send', 'core', 0, 0),
('core.datatype.blob', 'vocabulary', 0, 0),
('core.datatype.boolean', 'vocabulary', 0, 0),
('core.datatype.date', 'vocabulary', 0, 0),
('core.datatype.datetime', 'vocabulary', 0, 0),
('core.datatype.decimal', 'vocabulary', 0, 0),
('core.datatype.float', 'vocabulary', 0, 0),
('core.datatype.integer', 'vocabulary', 0, 0),
('core.datatype.item', 'vocabulary', 0, 0),
('core.datatype.object', 'vocabulary', 0, 0),
('core.datatype.spatial', 'vocabulary', 0, 0),
('core.datatype.string', 'vocabulary', 0, 0),
('core.datatype.text', 'vocabulary', 0, 0),
('core.datatype.time', 'vocabulary', 0, 0),
('core.event', 'core', 0, 0),
('core.event.agent', 'core', 0, 0),
('core.event.class', 'core', 0, 0),
('core.event.class.viewed', 'core', 0, 0),
('core.event.edited', 'core', 0, 0),
('core.event.id', 'core', 0, 0),
('core.event.occurred', 'core', 0, 0),
('core.event.subject', 'core', 0, 0),
('core.events', 'core', 0, 0),
('core.file', 'core', 0, 0),
('core.file.class', 'core', 0, 0),
('core.file.class.audio', 'vocabulary', 0, 0),
('core.file.class.document', 'vocabulary', 0, 0),
('core.file.class.image', 'vocabulary', 0, 0),
('core.file.class.other', 'vocabulary', 0, 0),
('core.file.class.text', 'vocabulary', 0, 0),
('core.file.class.video', 'vocabulary', 0, 0),
('core.file.copyright', 'core', 0, 0),
('core.file.description', 'core', 0, 0),
('core.file.id', 'core', 0, 0),
('core.file.mediatype', 'core', 0, 0),
('core.file.status', 'core', 0, 0),
('core.file.status.checkedin', 'vocabulary', 0, 0),
('core.file.status.checkedout', 'vocabulary', 0, 0),
('core.file.status.expired', 'vocabulary', 0, 0),
('core.file.status.locked', 'vocabulary', 0, 0),
('core.file.status.new', 'vocabulary', 0, 0),
('core.file.title', 'core', 0, 0),
('core.file.type.text', 'core', 0, 0),
('core.file.type.video', 'core', 0, 0),
('core.file.versions', 'core', 0, 0),
('core.form.mode', 'core', 0, 0),
('core.form.mode.active', 'vocabulary', 0, 0),
('core.form.mode.disabled', 'vocabulary', 0, 0),
('core.form.mode.excluded', 'vocabulary', 0, 0),
('core.form.mode.hidden', 'vocabulary', 0, 0),
('core.form.mode.readonly', 'vocabulary', 0, 0),
('core.form.mode.static', 'vocabulary', 0, 0),
('core.format.dating.type', 'core', 0, 0),
('core.item.status', 'core', 0, 0),
('core.item.status.allocated', 'vocabulary', 0, 0),
('core.item.status.deleted', 'vocabulary', 0, 0),
('core.item.status.registered', 'vocabulary', 0, 0),
('core.item.status.void', 'vocabulary', 0, 0),
('core.license.cc0', 'vocabulary', 0, 0),
('core.license.ccbyncsa', 'vocabulary', 0, 0),
('core.license.ccbysa', 'vocabulary', 0, 0),
('core.mediatype.image.jpeg', 'vocabulary', 0, 0),
('core.mediatype.image.png', 'vocabulary', 0, 0),
('core.mediatype.text.html', 'vocabulary', 0, 0),
('core.mediatype.text.plain', 'vocabulary', 0, 0),
('core.message', 'core', 0, 0),
('core.message.allmessages', 'core', 0, 0),
('core.message.class', 'vocabulary', 0, 0),
('core.message.class.mail', 'vocabulary', 0, 0),
('core.message.class.notification', 'vocabulary', 0, 0),
('core.message.id', 'core', 0, 0),
('core.message.mail.attachments', 'core', 0, 0),
('core.message.mail.body', 'core', 0, 0),
('core.message.mail.subject', 'core', 0, 0),
('core.message.messages', 'core', 0, 0),
('core.message.messages.new', 'core', 0, 0),
('core.message.newmessages', 'core', 0, 0),
('core.message.notification.body', 'core', 0, 0),
('core.message.notification.event', 'core', 0, 0),
('core.message.notshown', 'core', 0, 0),
('core.message.recipient.status', 'vocabulary', 0, 0),
('core.message.recipient.status.discarded', 'vocabulary', 0, 0),
('core.message.recipient.status.read', 'vocabulary', 0, 0),
('core.message.recipient.status.unread', 'vocabulary', 0, 0),
('core.message.recipients', 'core', 0, 0),
('core.message.sender', 'core', 0, 0),
('core.message.sent_at', 'core', 0, 0),
('core.message.status', 'vocabulary', 0, 0),
('core.message.status.draft', 'vocabulary', 0, 0),
('core.message.status.read', 'vocabulary', 0, 0),
('core.message.status.sent', 'vocabulary', 0, 0),
('core.page', 'core', 0, 0),
('core.page.id', 'core', 0, 0),
('core.placeholder', 'core', 0, 0),
('core.profile', 'core', 0, 0),
('core.profiles', 'core', 0, 0),
('core.security.user.status', 'core', 0, 0),
('core.security.user.status.disabled', 'core', 0, 0),
('core.security.user.status.enabled', 'core', 0, 0),
('core.security.user.status.expired', 'core', 0, 0),
('core.security.user.status.locked', 'core', 0, 0),
('core.security.user.status.registered', 'core', 0, 0),
('core.security.user.status.verified', 'core', 0, 0),
('core.user', 'core', 0, 0),
('core.user.actions', 'core', 0, 0),
('core.user.agree', 'core', 0, 0),
('core.user.email', 'core', 0, 0),
('core.user.email.repeat', 'core', 0, 0),
('core.user.level', 'core', 0, 0),
('core.user.login', 'core', 0, 0),
('core.user.login.heading', 'core', 0, 0),
('core.user.login.notregistered', 'core', 0, 0),
('core.user.login.register', 'core', 0, 0),
('core.user.name', 'core', 0, 0),
('core.user.password', 'core', 0, 0),
('core.user.password.change', 'core', 0, 0),
('core.user.password.change.success', 'core', 0, 0),
('core.user.password.current', 'core', 0, 0),
('core.user.password.forgot', 'core', 0, 0),
('core.user.password.new', 'core', 0, 0),
('core.user.password.repeat', 'core', 0, 0),
('core.user.password.set', 'core', 0, 0),
('core.user.profile', 'core', 0, 0),
('core.user.register', 'core', 0, 0),
('core.user.register.existing', 'core', 0, 0),
('core.user.register.faq', 'core', 0, 0),
('core.user.register.heading', 'core', 0, 0),
('core.user.register.loggedin', 'core', 0, 0),
('core.user.register.login', 'core', 0, 0),
('core.user.register.logout', 'core', 0, 0),
('core.user.register.success', 'core', 0, 0),
('core.user.reset', 'core', 0, 0),
('core.user.reset.heading', 'core', 0, 0),
('core.user.reset.notregistered', 'core', 0, 0),
('core.user.reset.register', 'core', 0, 0),
('core.user.reset.reset', 'core', 0, 0),
('core.user.role', 'core', 0, 0),
('core.user.role.add', 'core', 0, 0),
('core.user.role.expiry', 'core', 0, 0),
('core.user.terms', 'vocabulary', 0, 0),
('core.user.terms.agree', 'core', 0, 0),
('core.user.terms.v1', 'vocabulary', 0, 0),
('core.user.username', 'core', 0, 0),
('core.users', 'core', 0, 0),
('core.visibility', 'vocabulary', 0, 0),
('core.visibility.private', 'vocabulary', 0, 0),
('core.visibility.public', 'vocabulary', 0, 0),
('core.visibility.restricted', 'vocabulary', 0, 0),
('core.vocabulary.mediatype', 'core', 0, 0),
('core.vocabulary.type.list', 'core', 0, 0),
('core.vocabulary.type.ring', 'core', 0, 0),
('core.vocabulary.type.taxonomy', 'core', 0, 0),
('core.vocabulary.type.thesaurus', 'core', 0, 0),
('core.widget.comments', 'core', 0, 0),
('core.widget.send', 'core', 0, 0),
('core.widget.submit', 'core', 0, 0),
('core.workflow.action', 'core', 0, 0),
('core.workflow.role', 'core', 0, 0),
('core.workflow.role.admin', 'core', 0, 0),
('core.workflow.role.anon', 'core', 0, 0),
('core.workflow.role.anonymous', 'core', 0, 0),
('core.workflow.role.sysadmin', 'core', 0, 0),
('core.workflow.role.user', 'core', 0, 0),
('country.afghanistan', 'vocabulary', 0, 0),
('country.alandislands', 'vocabulary', 0, 0),
('country.albania', 'vocabulary', 0, 0),
('country.algeria', 'vocabulary', 0, 0),
('country.americansamoa', 'vocabulary', 0, 0),
('country.andorra', 'vocabulary', 0, 0),
('country.angola', 'vocabulary', 0, 0),
('country.anguilla', 'vocabulary', 0, 0),
('country.antarctica', 'vocabulary', 0, 0),
('country.antigua', 'vocabulary', 0, 0),
('country.argentina', 'vocabulary', 0, 0),
('country.armenia', 'vocabulary', 0, 0),
('country.aruba', 'vocabulary', 0, 0),
('country.australia', 'vocabulary', 0, 0),
('country.austria', 'vocabulary', 0, 0),
('country.azerbaijan', 'vocabulary', 0, 0),
('country.bahamas', 'vocabulary', 0, 0),
('country.bahrain', 'vocabulary', 0, 0),
('country.bangladesh', 'vocabulary', 0, 0),
('country.barbados', 'vocabulary', 0, 0),
('country.belarus', 'vocabulary', 0, 0),
('country.belgium', 'vocabulary', 0, 0),
('country.belize', 'vocabulary', 0, 0),
('country.benin', 'vocabulary', 0, 0),
('country.bermuda', 'vocabulary', 0, 0),
('country.bhutan', 'vocabulary', 0, 0),
('country.bolivia', 'vocabulary', 0, 0),
('country.bonaire', 'vocabulary', 0, 0),
('country.bosniaherzegovina', 'vocabulary', 0, 0),
('country.botswana', 'vocabulary', 0, 0),
('country.brazil', 'vocabulary', 0, 0),
('country.britishvirginislands', 'vocabulary', 0, 0),
('country.brunei', 'vocabulary', 0, 0),
('country.bulgaria', 'vocabulary', 0, 0),
('country.burkinafaso', 'vocabulary', 0, 0),
('country.burundi', 'vocabulary', 0, 0),
('country.caboverde', 'vocabulary', 0, 0),
('country.cambodia', 'vocabulary', 0, 0),
('country.cameroon', 'vocabulary', 0, 0),
('country.canada', 'vocabulary', 0, 0),
('country.caymanislands', 'vocabulary', 0, 0),
('country.centralafricanrepublic', 'vocabulary', 0, 0),
('country.chad', 'vocabulary', 0, 0),
('country.chile', 'vocabulary', 0, 0),
('country.china', 'vocabulary', 0, 0),
('country.christmasisland', 'vocabulary', 0, 0),
('country.cocosislands', 'vocabulary', 0, 0),
('country.colombia', 'vocabulary', 0, 0),
('country.comoros', 'vocabulary', 0, 0),
('country.congo', 'vocabulary', 0, 0),
('country.cookislands', 'vocabulary', 0, 0),
('country.costarica', 'vocabulary', 0, 0),
('country.cotedivoire', 'vocabulary', 0, 0),
('country.croatia', 'vocabulary', 0, 0),
('country.cuba', 'vocabulary', 0, 0),
('country.curacao', 'vocabulary', 0, 0),
('country.cyprus', 'vocabulary', 0, 0),
('country.czechrepublic', 'vocabulary', 0, 0),
('country.democraticrepubliccongo', 'vocabulary', 0, 0),
('country.denmark', 'vocabulary', 0, 0),
('country.djibouti', 'vocabulary', 0, 0),
('country.dominica', 'vocabulary', 0, 0),
('country.dominicanrepublic', 'vocabulary', 0, 0),
('country.ecuador', 'vocabulary', 0, 0),
('country.egypt', 'vocabulary', 0, 0),
('country.elsalvador', 'vocabulary', 0, 0),
('country.equatorialguinea', 'vocabulary', 0, 0),
('country.eritrea', 'vocabulary', 0, 0),
('country.estonia', 'vocabulary', 0, 0),
('country.ethiopia', 'vocabulary', 0, 0),
('country.falklandislands', 'vocabulary', 0, 0),
('country.faroeislands', 'vocabulary', 0, 0),
('country.fiji', 'vocabulary', 0, 0),
('country.finland', 'vocabulary', 0, 0),
('country.france', 'vocabulary', 0, 0),
('country.frenchguiana', 'vocabulary', 0, 0),
('country.frenchpolynesia', 'vocabulary', 0, 0),
('country.gabon', 'vocabulary', 0, 0),
('country.gambia', 'vocabulary', 0, 0),
('country.georgia', 'vocabulary', 0, 0),
('country.germany', 'vocabulary', 0, 0),
('country.ghana', 'vocabulary', 0, 0),
('country.gibraltar', 'vocabulary', 0, 0),
('country.greece', 'vocabulary', 0, 0),
('country.greenland', 'vocabulary', 0, 0),
('country.grenada', 'vocabulary', 0, 0),
('country.guadeloupe', 'vocabulary', 0, 0),
('country.guam', 'vocabulary', 0, 0),
('country.guatemala', 'vocabulary', 0, 0),
('country.guernsey', 'vocabulary', 0, 0),
('country.guinea', 'vocabulary', 0, 0),
('country.guinea-bissau', 'vocabulary', 0, 0),
('country.guyana', 'vocabulary', 0, 0),
('country.haiti', 'vocabulary', 0, 0),
('country.honduras', 'vocabulary', 0, 0),
('country.hongkong', 'vocabulary', 0, 0),
('country.hungary', 'vocabulary', 0, 0),
('country.iceland', 'vocabulary', 0, 0),
('country.india', 'vocabulary', 0, 0),
('country.indonesia', 'vocabulary', 0, 0),
('country.iran', 'vocabulary', 0, 0),
('country.iraq', 'vocabulary', 0, 0),
('country.ireland', 'vocabulary', 0, 0),
('country.isleofman', 'vocabulary', 0, 0),
('country.israel', 'vocabulary', 0, 0),
('country.italy', 'vocabulary', 0, 0),
('country.jamaica', 'vocabulary', 0, 0),
('country.japan', 'vocabulary', 0, 0),
('country.jersey', 'vocabulary', 0, 0),
('country.jordan', 'vocabulary', 0, 0),
('country.kazakhstan', 'vocabulary', 0, 0),
('country.kenya', 'vocabulary', 0, 0),
('country.kiribati', 'vocabulary', 0, 0),
('country.kuwait', 'vocabulary', 0, 0),
('country.kyrgyzstan', 'vocabulary', 0, 0),
('country.lao', 'vocabulary', 0, 0),
('country.latvia', 'vocabulary', 0, 0),
('country.lebanon', 'vocabulary', 0, 0),
('country.lesotho', 'vocabulary', 0, 0),
('country.liberia', 'vocabulary', 0, 0),
('country.libya', 'vocabulary', 0, 0),
('country.liechtenstein', 'vocabulary', 0, 0),
('country.lithuania', 'vocabulary', 0, 0),
('country.luxembourg', 'vocabulary', 0, 0),
('country.macao', 'vocabulary', 0, 0),
('country.macedonia', 'vocabulary', 0, 0),
('country.madagascar', 'vocabulary', 0, 0),
('country.malawi', 'vocabulary', 0, 0),
('country.malaysia', 'vocabulary', 0, 0),
('country.maldives', 'vocabulary', 0, 0),
('country.mali', 'vocabulary', 0, 0),
('country.malta', 'vocabulary', 0, 0),
('country.marshallislands', 'vocabulary', 0, 0),
('country.martinique', 'vocabulary', 0, 0),
('country.mauritania', 'vocabulary', 0, 0),
('country.mauritius', 'vocabulary', 0, 0),
('country.mayotte', 'vocabulary', 0, 0),
('country.mexico', 'vocabulary', 0, 0),
('country.micronesia', 'vocabulary', 0, 0),
('country.moldova', 'vocabulary', 0, 0),
('country.monaco', 'vocabulary', 0, 0),
('country.mongolia', 'vocabulary', 0, 0),
('country.montenegro', 'vocabulary', 0, 0),
('country.montserrat', 'vocabulary', 0, 0),
('country.morocco', 'vocabulary', 0, 0),
('country.mozambique', 'vocabulary', 0, 0),
('country.myanmar', 'vocabulary', 0, 0),
('country.namibia', 'vocabulary', 0, 0),
('country.nauru', 'vocabulary', 0, 0),
('country.nepal', 'vocabulary', 0, 0),
('country.netherlands', 'vocabulary', 0, 0),
('country.newcaledonia', 'vocabulary', 0, 0),
('country.newzealand', 'vocabulary', 0, 0),
('country.nicaragua', 'vocabulary', 0, 0),
('country.niger', 'vocabulary', 0, 0),
('country.nigeria', 'vocabulary', 0, 0),
('country.niue', 'vocabulary', 0, 0),
('country.norfolkisland', 'vocabulary', 0, 0),
('country.northernmarianaislands', 'vocabulary', 0, 0),
('country.northkorea', 'vocabulary', 0, 0),
('country.norway', 'vocabulary', 0, 0),
('country.oman', 'vocabulary', 0, 0),
('country.pakistan', 'vocabulary', 0, 0),
('country.palau', 'vocabulary', 0, 0),
('country.palestine', 'vocabulary', 0, 0),
('country.panama', 'vocabulary', 0, 0),
('country.papuanewguinea', 'vocabulary', 0, 0),
('country.paraguay', 'vocabulary', 0, 0),
('country.peru', 'vocabulary', 0, 0),
('country.philippines', 'vocabulary', 0, 0),
('country.pitcairn', 'vocabulary', 0, 0),
('country.poland', 'vocabulary', 0, 0),
('country.portugal', 'vocabulary', 0, 0),
('country.puertorico', 'vocabulary', 0, 0),
('country.qatar', 'vocabulary', 0, 0),
('country.reunion', 'vocabulary', 0, 0),
('country.romania', 'vocabulary', 0, 0),
('country.russia', 'vocabulary', 0, 0),
('country.rwanda', 'vocabulary', 0, 0),
('country.saintbarthelemy', 'vocabulary', 0, 0),
('country.sainthelena', 'vocabulary', 0, 0),
('country.saintkitts', 'vocabulary', 0, 0),
('country.saintlucia', 'vocabulary', 0, 0),
('country.saintmartin', 'vocabulary', 0, 0),
('country.saintpierremiquelon', 'vocabulary', 0, 0),
('country.saintvincent', 'vocabulary', 0, 0),
('country.samoa', 'vocabulary', 0, 0),
('country.sanmarino', 'vocabulary', 0, 0),
('country.saotome', 'vocabulary', 0, 0),
('country.saudiarabia', 'vocabulary', 0, 0),
('country.senegal', 'vocabulary', 0, 0),
('country.serbia', 'vocabulary', 0, 0),
('country.seychelles', 'vocabulary', 0, 0),
('country.sierraleone', 'vocabulary', 0, 0),
('country.singapore', 'vocabulary', 0, 0),
('country.sintmaarten', 'vocabulary', 0, 0),
('country.slovakia', 'vocabulary', 0, 0),
('country.slovenia', 'vocabulary', 0, 0),
('country.solomonislands', 'vocabulary', 0, 0),
('country.somalia', 'vocabulary', 0, 0),
('country.southafrica', 'vocabulary', 0, 0),
('country.southgeorgia', 'vocabulary', 0, 0),
('country.southkorea', 'vocabulary', 0, 0),
('country.southsudan', 'vocabulary', 0, 0),
('country.spain', 'vocabulary', 0, 0),
('country.srilanka', 'vocabulary', 0, 0),
('country.sudan', 'vocabulary', 0, 0),
('country.suriname', 'vocabulary', 0, 0),
('country.svalbard', 'vocabulary', 0, 0),
('country.swaziland', 'vocabulary', 0, 0),
('country.sweden', 'vocabulary', 0, 0),
('country.switzerland', 'vocabulary', 0, 0),
('country.syria', 'vocabulary', 0, 0),
('country.taiwan', 'vocabulary', 0, 0),
('country.tajikistan', 'vocabulary', 0, 0),
('country.tanzania', 'vocabulary', 0, 0),
('country.thailand', 'vocabulary', 0, 0),
('country.timorleste', 'vocabulary', 0, 0),
('country.togo', 'vocabulary', 0, 0),
('country.tokelau', 'vocabulary', 0, 0),
('country.tonga', 'vocabulary', 0, 0),
('country.trinidadtobago', 'vocabulary', 0, 0),
('country.tunisia', 'vocabulary', 0, 0),
('country.turkey', 'vocabulary', 0, 0),
('country.turkmenistan', 'vocabulary', 0, 0),
('country.turkscaicos', 'vocabulary', 0, 0),
('country.tuvalu', 'vocabulary', 0, 0),
('country.uganda', 'vocabulary', 0, 0),
('country.ukraine', 'vocabulary', 0, 0),
('country.unitedarabemirates', 'vocabulary', 0, 0),
('country.unitedkingdom', 'vocabulary', 0, 0),
('country.unitedstatesamerica', 'vocabulary', 0, 0),
('country.uruguay', 'vocabulary', 0, 0),
('country.usvirginislands', 'vocabulary', 0, 0),
('country.uzbekistan', 'vocabulary', 0, 0),
('country.vanuatu', 'vocabulary', 0, 0),
('country.vatican', 'vocabulary', 0, 0),
('country.venezuela', 'vocabulary', 0, 0),
('country.vietnam', 'vocabulary', 0, 0),
('country.wallisfutuna', 'vocabulary', 0, 0),
('country.westernsahara', 'vocabulary', 0, 0),
('country.yemen', 'vocabulary', 0, 0),
('country.zambia', 'vocabulary', 0, 0),
('country.zimbabwe', 'vocabulary', 0, 0),
('file.type.audio', 'core', 0, 0),
('file.type.document', 'core', 0, 0),
('file.type.image', 'core', 0, 0),
('file.type.other', 'core', 0, 0),
('find.gotofind', 'core', 0, 0),
('form.select.optional', 'core', 0, 0),
('form.select.required', 'core', 0, 0),
('format.address', 'core', 0, 0),
('format.address.city', 'core', 0, 0),
('format.address.country', 'core', 0, 0),
('format.address.street', 'core', 0, 0),
('format.blob', 'core', 0, 0),
('format.boolean', 'core', 0, 0),
('format.classification.class', 'core', 0, 0),
('format.classification.classified', 'core', 0, 0),
('format.colour', 'core', 0, 0),
('format.date', 'core', 0, 0),
('format.datetime', 'core', 0, 0),
('format.dating', 'core', 0, 0),
('format.dating.dated', 'core', 0, 0),
('format.dating.period', 'core', 0, 0),
('format.dating.year', 'core', 0, 0),
('format.decimal', 'core', 0, 0),
('format.description.described', 'core', 0, 0),
('format.description.text', 'core', 0, 0),
('format.distance', 'core', 0, 0),
('format.email', 'core', 0, 0),
('format.event', 'core', 0, 0),
('format.file', 'core', 0, 0),
('format.fileversion', 'core', 0, 0),
('format.fileversion.created', 'core', 0, 0),
('format.fileversion.creator', 'core', 0, 0),
('format.fileversion.expires', 'core', 0, 0),
('format.fileversion.modified', 'core', 0, 0),
('format.fileversion.modifier', 'core', 0, 0),
('format.fileversion.name', 'core', 0, 0),
('format.fileversion.sequence', 'core', 0, 0),
('format.fileversion.string', 'core', 0, 0),
('format.float', 'core', 0, 0),
('format.geometry', 'core', 0, 0),
('format.html', 'core', 0, 0),
('format.identifier', 'core', 0, 0),
('format.image', 'core', 0, 0),
('format.integer', 'core', 0, 0),
('format.item', 'core', 0, 0),
('format.key', 'core', 0, 0),
('format.localtext', 'core', 0, 0),
('format.markdown', 'core', 0, 0),
('format.mass', 'core', 0, 0),
('format.module', 'core', 0, 0),
('format.money', 'core', 0, 0),
('format.ordinaldate', 'core', 0, 0),
('format.password', 'core', 0, 0),
('format.percent', 'core', 0, 0),
('format.recipient', 'core', 0, 0),
('format.recipient.read_on', 'core', 0, 0),
('format.recipient.sent_to', 'core', 0, 0),
('format.recipient.status', 'core', 0, 0),
('format.richtext', 'core', 0, 0),
('format.search', 'core', 0, 0),
('format.shortlocaltext', 'core', 0, 0),
('format.shorttext', 'core', 0, 0),
('format.string', 'core', 0, 0),
('format.telephone', 'core', 0, 0),
('format.text', 'core', 0, 0),
('format.time', 'core', 0, 0),
('format.url', 'core', 0, 0),
('format.weekdate', 'core', 0, 0),
('format.wkt', 'core', 0, 0),
('format.year', 'core', 0, 0),
('format.yearmonth', 'core', 0, 0),
('format.yearspan', 'core', 0, 0),
('format.yearweek', 'core', 0, 0),
('fragment.blob', 'core', 0, 0),
('fragment.boolean', 'core', 0, 0),
('fragment.date', 'core', 0, 0),
('fragment.datetime', 'core', 0, 0),
('fragment.decimal', 'core', 0, 0),
('fragment.float', 'core', 0, 0),
('fragment.geometry', 'core', 0, 0),
('fragment.integer', 'core', 0, 0),
('fragment.item', 'core', 0, 0),
('fragment.object', 'core', 0, 0),
('fragment.string', 'core', 0, 0),
('fragment.text', 'core', 0, 0),
('fragment.time', 'core', 0, 0),
('language.abkhazian', 'vocabulary', 0, 0),
('language.achinese', 'vocabulary', 0, 0),
('language.acoli', 'vocabulary', 0, 0),
('language.adangme', 'vocabulary', 0, 0),
('language.adyghe', 'vocabulary', 0, 0),
('language.afar', 'vocabulary', 0, 0),
('language.afrihili', 'vocabulary', 0, 0),
('language.afrikaans', 'vocabulary', 0, 0),
('language.aghem', 'vocabulary', 0, 0),
('language.ainu', 'vocabulary', 0, 0),
('language.akan', 'vocabulary', 0, 0),
('language.akkadian', 'vocabulary', 0, 0),
('language.akoose', 'vocabulary', 0, 0),
('language.alabama', 'vocabulary', 0, 0),
('language.albanian', 'vocabulary', 0, 0),
('language.albanian.gheg', 'vocabulary', 0, 0),
('language.aleut', 'vocabulary', 0, 0),
('language.altai.southern', 'vocabulary', 0, 0),
('language.amharic', 'vocabulary', 0, 0),
('language.angika', 'vocabulary', 0, 0),
('language.aonaga', 'vocabulary', 0, 0),
('language.arabic', 'vocabulary', 0, 0),
('language.arabic.algerian', 'vocabulary', 0, 0),
('language.arabic.chadian', 'vocabulary', 0, 0),
('language.arabic.egyptian', 'vocabulary', 0, 0),
('language.arabic.modern', 'vocabulary', 0, 0),
('language.arabic.moroccan', 'vocabulary', 0, 0),
('language.arabic.tunisian', 'vocabulary', 0, 0),
('language.aragonese', 'vocabulary', 0, 0),
('language.aramaic', 'vocabulary', 0, 0),
('language.aramaic.samaritan', 'vocabulary', 0, 0),
('language.araona', 'vocabulary', 0, 0),
('language.arapaho', 'vocabulary', 0, 0),
('language.arawak', 'vocabulary', 0, 0),
('language.armenian', 'vocabulary', 0, 0),
('language.aromanian', 'vocabulary', 0, 0),
('language.arpitan', 'vocabulary', 0, 0),
('language.assamese', 'vocabulary', 0, 0),
('language.asturian', 'vocabulary', 0, 0),
('language.asu', 'vocabulary', 0, 0),
('language.atsam', 'vocabulary', 0, 0),
('language.avaric', 'vocabulary', 0, 0),
('language.avestan', 'vocabulary', 0, 0),
('language.awadhi', 'vocabulary', 0, 0),
('language.aymara', 'vocabulary', 0, 0),
('language.azerbaijani', 'vocabulary', 0, 0),
('language.badaga', 'vocabulary', 0, 0),
('language.bafia', 'vocabulary', 0, 0),
('language.bafut', 'vocabulary', 0, 0),
('language.bakhtiari', 'vocabulary', 0, 0),
('language.balinese', 'vocabulary', 0, 0),
('language.balochi.western', 'vocabulary', 0, 0),
('language.baluchi', 'vocabulary', 0, 0),
('language.bambara', 'vocabulary', 0, 0),
('language.bamun', 'vocabulary', 0, 0),
('language.banjar', 'vocabulary', 0, 0),
('language.basaa', 'vocabulary', 0, 0),
('language.bashkir', 'vocabulary', 0, 0),
('language.basque', 'vocabulary', 0, 0),
('language.bataktoba', 'vocabulary', 0, 0),
('language.bavarian', 'vocabulary', 0, 0),
('language.beja', 'vocabulary', 0, 0),
('language.belarusian', 'vocabulary', 0, 0),
('language.bemba', 'vocabulary', 0, 0),
('language.bena', 'vocabulary', 0, 0),
('language.bengali', 'vocabulary', 0, 0),
('language.betawi', 'vocabulary', 0, 0),
('language.bhojpuri', 'vocabulary', 0, 0),
('language.bikol', 'vocabulary', 0, 0),
('language.bini', 'vocabulary', 0, 0),
('language.bishnupriya', 'vocabulary', 0, 0),
('language.bislama', 'vocabulary', 0, 0),
('language.blin', 'vocabulary', 0, 0),
('language.blissymbols', 'vocabulary', 0, 0),
('language.bodo', 'vocabulary', 0, 0),
('language.bosnian', 'vocabulary', 0, 0),
('language.brahui', 'vocabulary', 0, 0),
('language.braj', 'vocabulary', 0, 0),
('language.breton', 'vocabulary', 0, 0),
('language.buginese', 'vocabulary', 0, 0),
('language.bulgarian', 'vocabulary', 0, 0),
('language.bulu', 'vocabulary', 0, 0),
('language.buriat', 'vocabulary', 0, 0),
('language.burmese', 'vocabulary', 0, 0),
('language.caddo', 'vocabulary', 0, 0),
('language.cantonese', 'vocabulary', 0, 0),
('language.capiznon', 'vocabulary', 0, 0),
('language.carib', 'vocabulary', 0, 0),
('language.catalan', 'vocabulary', 0, 0),
('language.cayuga', 'vocabulary', 0, 0),
('language.cebuano', 'vocabulary', 0, 0),
('language.chagatai', 'vocabulary', 0, 0),
('language.chamorro', 'vocabulary', 0, 0),
('language.chechen', 'vocabulary', 0, 0),
('language.cherokee', 'vocabulary', 0, 0),
('language.cheyenne', 'vocabulary', 0, 0),
('language.chibcha', 'vocabulary', 0, 0),
('language.chiga', 'vocabulary', 0, 0),
('language.chiini.koyra', 'vocabulary', 0, 0),
('language.chinese', 'vocabulary', 0, 0),
('language.chinese.gan', 'vocabulary', 0, 0),
('language.chinese.hakka', 'vocabulary', 0, 0),
('language.chinese.literary', 'vocabulary', 0, 0),
('language.chinese.minnan', 'vocabulary', 0, 0),
('language.chinese.simplified', 'vocabulary', 0, 0),
('language.chinese.traditional', 'vocabulary', 0, 0),
('language.chinese.wu', 'vocabulary', 0, 0),
('language.chinese.xiang', 'vocabulary', 0, 0),
('language.chipewyan', 'vocabulary', 0, 0),
('language.choctaw', 'vocabulary', 0, 0),
('language.chuukese', 'vocabulary', 0, 0),
('language.chuvash', 'vocabulary', 0, 0),
('language.colognian', 'vocabulary', 0, 0),
('language.comorian', 'vocabulary', 0, 0),
('language.coptic', 'vocabulary', 0, 0),
('language.cornish', 'vocabulary', 0, 0),
('language.corsican', 'vocabulary', 0, 0),
('language.cree', 'vocabulary', 0, 0),
('language.creek', 'vocabulary', 0, 0),
('language.creole.haitian', 'vocabulary', 0, 0),
('language.croatian', 'vocabulary', 0, 0),
('language.czech', 'vocabulary', 0, 0),
('language.dakota', 'vocabulary', 0, 0),
('language.danish', 'vocabulary', 0, 0),
('language.dargwa', 'vocabulary', 0, 0),
('language.dari.zoroastrian', 'vocabulary', 0, 0),
('language.dazaga', 'vocabulary', 0, 0),
('language.delaware', 'vocabulary', 0, 0),
('language.dinka', 'vocabulary', 0, 0),
('language.divehi', 'vocabulary', 0, 0),
('language.dogri', 'vocabulary', 0, 0),
('language.dogrib', 'vocabulary', 0, 0),
('language.duala', 'vocabulary', 0, 0),
('language.dusun.central', 'vocabulary', 0, 0),
('language.dutch', 'vocabulary', 0, 0),
('language.dutch.middle', 'vocabulary', 0, 0),
('language.dyula', 'vocabulary', 0, 0),
('language.dzongkha', 'vocabulary', 0, 0),
('language.efik', 'vocabulary', 0, 0),
('language.egyptian.ancient', 'vocabulary', 0, 0),
('language.ekajuk', 'vocabulary', 0, 0),
('language.elamite', 'vocabulary', 0, 0),
('language.embu', 'vocabulary', 0, 0),
('language.emilian', 'vocabulary', 0, 0),
('language.english', 'vocabulary', 0, 0),
('language.english.american', 'vocabulary', 0, 0),
('language.english.australian', 'vocabulary', 0, 0),
('language.english.british', 'vocabulary', 0, 0),
('language.english.canadian', 'vocabulary', 0, 0),
('language.english.jamaicancreole ', 'vocabulary', 0, 0),
('language.english.middle', 'vocabulary', 0, 0),
('language.english.old', 'vocabulary', 0, 0),
('language.erzya', 'vocabulary', 0, 0),
('language.esperanto', 'vocabulary', 0, 0),
('language.estonian', 'vocabulary', 0, 0),
('language.ewe', 'vocabulary', 0, 0),
('language.ewondo', 'vocabulary', 0, 0),
('language.extremaduran', 'vocabulary', 0, 0),
('language.fang', 'vocabulary', 0, 0),
('language.fanti', 'vocabulary', 0, 0),
('language.faroese', 'vocabulary', 0, 0),
('language.fijian', 'vocabulary', 0, 0),
('language.filipino', 'vocabulary', 0, 0),
('language.finnish', 'vocabulary', 0, 0),
('language.finnish.tornedalen', 'vocabulary', 0, 0),
('language.flemish', 'vocabulary', 0, 0),
('language.flemish.west', 'vocabulary', 0, 0),
('language.fon', 'vocabulary', 0, 0),
('language.frafra', 'vocabulary', 0, 0),
('language.franconian.main', 'vocabulary', 0, 0),
('language.french', 'vocabulary', 0, 0),
('language.french.cajun', 'vocabulary', 0, 0),
('language.french.canadian', 'vocabulary', 0, 0),
('language.french.middle', 'vocabulary', 0, 0),
('language.french.old', 'vocabulary', 0, 0),
('language.french.swiss', 'vocabulary', 0, 0),
('language.frisian.eastern', 'vocabulary', 0, 0),
('language.frisian.northern', 'vocabulary', 0, 0),
('language.frisian.saterland', 'vocabulary', 0, 0),
('language.frisian.western', 'vocabulary', 0, 0),
('language.friulian', 'vocabulary', 0, 0),
('language.fulah', 'vocabulary', 0, 0),
('language.ga', 'vocabulary', 0, 0),
('language.gaelic.scottish', 'vocabulary', 0, 0),
('language.gagauz', 'vocabulary', 0, 0),
('language.galician', 'vocabulary', 0, 0),
('language.ganda', 'vocabulary', 0, 0),
('language.gayo', 'vocabulary', 0, 0),
('language.gbaya', 'vocabulary', 0, 0),
('language.geez', 'vocabulary', 0, 0),
('language.georgian', 'vocabulary', 0, 0),
('language.german', 'vocabulary', 0, 0),
('language.german.austrian', 'vocabulary', 0, 0),
('language.german.low', 'vocabulary', 0, 0),
('language.german.middlehigh', 'vocabulary', 0, 0),
('language.german.oldhigh', 'vocabulary', 0, 0),
('language.german.palatine', 'vocabulary', 0, 0),
('language.german.pennsylvania', 'vocabulary', 0, 0),
('language.german.swiss', 'vocabulary', 0, 0),
('language.german.swisshigh', 'vocabulary', 0, 0),
('language.ghomala', 'vocabulary', 0, 0),
('language.gilaki', 'vocabulary', 0, 0),
('language.gilbertese', 'vocabulary', 0, 0),
('language.gondi', 'vocabulary', 0, 0),
('language.gorontalo', 'vocabulary', 0, 0),
('language.gothic', 'vocabulary', 0, 0),
('language.grebo', 'vocabulary', 0, 0),
('language.greek', 'vocabulary', 0, 0),
('language.greek.ancient', 'vocabulary', 0, 0),
('language.guarani', 'vocabulary', 0, 0),
('language.gujarati', 'vocabulary', 0, 0),
('language.gusii', 'vocabulary', 0, 0),
('language.gwichin', 'vocabulary', 0, 0),
('language.haida', 'vocabulary', 0, 0),
('language.hausa', 'vocabulary', 0, 0),
('language.hawaiian', 'vocabulary', 0, 0),
('language.hebrew', 'vocabulary', 0, 0),
('language.herero', 'vocabulary', 0, 0),
('language.hiligaynon', 'vocabulary', 0, 0),
('language.hindi', 'vocabulary', 0, 0),
('language.hindi.fiji', 'vocabulary', 0, 0),
('language.hittite', 'vocabulary', 0, 0),
('language.hmong', 'vocabulary', 0, 0),
('language.hungarian', 'vocabulary', 0, 0),
('language.hupa', 'vocabulary', 0, 0),
('language.iban', 'vocabulary', 0, 0),
('language.ibibio', 'vocabulary', 0, 0),
('language.icelandic', 'vocabulary', 0, 0),
('language.ido', 'vocabulary', 0, 0),
('language.igbo', 'vocabulary', 0, 0),
('language.iloko', 'vocabulary', 0, 0),
('language.indonesian', 'vocabulary', 0, 0),
('language.ingrian', 'vocabulary', 0, 0),
('language.ingush', 'vocabulary', 0, 0),
('language.interlingua', 'vocabulary', 0, 0),
('language.interlingue', 'vocabulary', 0, 0),
('language.inuktitut', 'vocabulary', 0, 0),
('language.inupiaq', 'vocabulary', 0, 0),
('language.irish', 'vocabulary', 0, 0),
('language.irish.middle', 'vocabulary', 0, 0),
('language.irish.old', 'vocabulary', 0, 0),
('language.italian', 'vocabulary', 0, 0),
('language.japanese', 'vocabulary', 0, 0),
('language.jargon.chinook', 'vocabulary', 0, 0),
('language.javanese', 'vocabulary', 0, 0),
('language.jju', 'vocabulary', 0, 0),
('language.jolafonyi', 'vocabulary', 0, 0),
('language.judeoarabic', 'vocabulary', 0, 0),
('language.judeopersian', 'vocabulary', 0, 0),
('language.jutish', 'vocabulary', 0, 0),
('language.kabardian', 'vocabulary', 0, 0),
('language.kabuverdianu', 'vocabulary', 0, 0),
('language.kabyle', 'vocabulary', 0, 0),
('language.kachin', 'vocabulary', 0, 0),
('language.kaingang', 'vocabulary', 0, 0),
('language.kako', 'vocabulary', 0, 0),
('language.kalaallisut', 'vocabulary', 0, 0),
('language.kalenjin', 'vocabulary', 0, 0),
('language.kalmyk', 'vocabulary', 0, 0),
('language.kamba', 'vocabulary', 0, 0),
('language.kanembu', 'vocabulary', 0, 0),
('language.kannada', 'vocabulary', 0, 0),
('language.kanuri', 'vocabulary', 0, 0),
('language.karachaybalkar', 'vocabulary', 0, 0),
('language.karakalpak', 'vocabulary', 0, 0),
('language.karelian', 'vocabulary', 0, 0),
('language.kashmiri', 'vocabulary', 0, 0),
('language.kashubian', 'vocabulary', 0, 0),
('language.kawi', 'vocabulary', 0, 0),
('language.kazakh', 'vocabulary', 0, 0),
('language.kenyang', 'vocabulary', 0, 0),
('language.khasi', 'vocabulary', 0, 0),
('language.khmer', 'vocabulary', 0, 0),
('language.khotanese', 'vocabulary', 0, 0),
('language.khowar', 'vocabulary', 0, 0),
('language.kiche', 'vocabulary', 0, 0),
('language.kikuyu', 'vocabulary', 0, 0),
('language.kimbundu', 'vocabulary', 0, 0),
('language.kinaraya', 'vocabulary', 0, 0),
('language.kinyarwanda', 'vocabulary', 0, 0),
('language.kirmanjki', 'vocabulary', 0, 0),
('language.klingon', 'vocabulary', 0, 0),
('language.kom', 'vocabulary', 0, 0),
('language.komi', 'vocabulary', 0, 0),
('language.komi.permyak', 'vocabulary', 0, 0),
('language.kongo', 'vocabulary', 0, 0),
('language.konkani', 'vocabulary', 0, 0),
('language.konkani.goan', 'vocabulary', 0, 0),
('language.korean', 'vocabulary', 0, 0),
('language.koro', 'vocabulary', 0, 0),
('language.kosraean', 'vocabulary', 0, 0),
('language.kotava', 'vocabulary', 0, 0),
('language.kpelle', 'vocabulary', 0, 0),
('language.krio', 'vocabulary', 0, 0),
('language.kuanyama', 'vocabulary', 0, 0),
('language.kumyk', 'vocabulary', 0, 0),
('language.kurdish', 'vocabulary', 0, 0),
('language.kurdish.central', 'vocabulary', 0, 0),
('language.kurukh', 'vocabulary', 0, 0),
('language.kutenai', 'vocabulary', 0, 0),
('language.kwasio', 'vocabulary', 0, 0),
('language.kyrgyz', 'vocabulary', 0, 0),
('language.ladino', 'vocabulary', 0, 0),
('language.lahnda', 'vocabulary', 0, 0),
('language.lakota', 'vocabulary', 0, 0),
('language.lamba', 'vocabulary', 0, 0),
('language.langi', 'vocabulary', 0, 0),
('language.lao', 'vocabulary', 0, 0),
('language.latgalian', 'vocabulary', 0, 0),
('language.latin', 'vocabulary', 0, 0),
('language.latvian', 'vocabulary', 0, 0),
('language.laz', 'vocabulary', 0, 0),
('language.lezghian', 'vocabulary', 0, 0),
('language.ligurian', 'vocabulary', 0, 0),
('language.limburgish', 'vocabulary', 0, 0),
('language.lingala', 'vocabulary', 0, 0),
('language.linguafranca.nova', 'vocabulary', 0, 0),
('language.lithuanian', 'vocabulary', 0, 0),
('language.livonian', 'vocabulary', 0, 0),
('language.lojban', 'vocabulary', 0, 0),
('language.lombard', 'vocabulary', 0, 0),
('language.lozi', 'vocabulary', 0, 0),
('language.luba.katanga', 'vocabulary', 0, 0),
('language.luba.lulua', 'vocabulary', 0, 0),
('language.luiseno', 'vocabulary', 0, 0),
('language.lunda', 'vocabulary', 0, 0),
('language.luo', 'vocabulary', 0, 0),
('language.luri.northern', 'vocabulary', 0, 0),
('language.luxembourgish', 'vocabulary', 0, 0),
('language.luyia', 'vocabulary', 0, 0),
('language.maba', 'vocabulary', 0, 0),
('language.macedonian', 'vocabulary', 0, 0),
('language.machame', 'vocabulary', 0, 0),
('language.madurese', 'vocabulary', 0, 0),
('language.mafa', 'vocabulary', 0, 0),
('language.magahi', 'vocabulary', 0, 0),
('language.maithili', 'vocabulary', 0, 0),
('language.makasar', 'vocabulary', 0, 0),
('language.makhuwameetto', 'vocabulary', 0, 0),
('language.makonde', 'vocabulary', 0, 0),
('language.malagasy', 'vocabulary', 0, 0),
('language.malay', 'vocabulary', 0, 0),
('language.malayalam', 'vocabulary', 0, 0),
('language.maltese', 'vocabulary', 0, 0),
('language.manchu', 'vocabulary', 0, 0),
('language.mandar', 'vocabulary', 0, 0),
('language.mandingo', 'vocabulary', 0, 0),
('language.manipuri', 'vocabulary', 0, 0),
('language.manx', 'vocabulary', 0, 0),
('language.maori', 'vocabulary', 0, 0),
('language.mapuche', 'vocabulary', 0, 0),
('language.marathi', 'vocabulary', 0, 0),
('language.mari', 'vocabulary', 0, 0),
('language.mari.western', 'vocabulary', 0, 0),
('language.marshallese', 'vocabulary', 0, 0),
('language.marwari', 'vocabulary', 0, 0),
('language.masai', 'vocabulary', 0, 0),
('language.mazanderani', 'vocabulary', 0, 0),
('language.medumba', 'vocabulary', 0, 0),
('language.mende', 'vocabulary', 0, 0),
('language.mentawai', 'vocabulary', 0, 0),
('language.meru', 'vocabulary', 0, 0),
('language.meta', 'vocabulary', 0, 0),
('language.micmac', 'vocabulary', 0, 0),
('language.minangkabau', 'vocabulary', 0, 0),
('language.mingrelian', 'vocabulary', 0, 0),
('language.mirandese', 'vocabulary', 0, 0),
('language.mizo', 'vocabulary', 0, 0),
('language.mohawk', 'vocabulary', 0, 0),
('language.moksha', 'vocabulary', 0, 0),
('language.moldavian', 'vocabulary', 0, 0),
('language.mongo', 'vocabulary', 0, 0),
('language.mongolian', 'vocabulary', 0, 0),
('language.morisyen', 'vocabulary', 0, 0),
('language.mossi', 'vocabulary', 0, 0),
('language.motu.hiri', 'vocabulary', 0, 0),
('language.multiple', 'vocabulary', 0, 0),
('language.mundang', 'vocabulary', 0, 0),
('language.myene', 'vocabulary', 0, 0),
('language.nama', 'vocabulary', 0, 0),
('language.nauru', 'vocabulary', 0, 0),
('language.navajo', 'vocabulary', 0, 0),
('language.ndebele.north', 'vocabulary', 0, 0),
('language.ndebele.south', 'vocabulary', 0, 0),
('language.ndonga', 'vocabulary', 0, 0),
('language.neapolitan', 'vocabulary', 0, 0),
('language.nepali', 'vocabulary', 0, 0),
('language.newari', 'vocabulary', 0, 0),
('language.newari.classical', 'vocabulary', 0, 0),
('language.ngambay', 'vocabulary', 0, 0),
('language.ngiemboon', 'vocabulary', 0, 0),
('language.ngomba', 'vocabulary', 0, 0),
('language.nheengatu', 'vocabulary', 0, 0),
('language.nias', 'vocabulary', 0, 0),
('language.niuean', 'vocabulary', 0, 0),
('language.nko', 'vocabulary', 0, 0),
('language.nogai', 'vocabulary', 0, 0),
('language.none', 'vocabulary', 0, 0),
('language.norse.old', 'vocabulary', 0, 0),
('language.northern sami', 'vocabulary', 0, 0),
('language.norwegian', 'vocabulary', 0, 0),
('language.norwegian.bokmål', 'vocabulary', 0, 0),
('language.norwegian.nynorsk', 'vocabulary', 0, 0),
('language.novial', 'vocabulary', 0, 0),
('language.nuer', 'vocabulary', 0, 0),
('language.nyamwezi', 'vocabulary', 0, 0),
('language.nyanja', 'vocabulary', 0, 0),
('language.nyankole', 'vocabulary', 0, 0),
('language.nyoro', 'vocabulary', 0, 0),
('language.nzima', 'vocabulary', 0, 0),
('language.occitan', 'vocabulary', 0, 0),
('language.ojibwa', 'vocabulary', 0, 0),
('language.oriya', 'vocabulary', 0, 0),
('language.oromo', 'vocabulary', 0, 0),
('language.osage', 'vocabulary', 0, 0),
('language.ossetic', 'vocabulary', 0, 0),
('language.pahlavi', 'vocabulary', 0, 0),
('language.palauan', 'vocabulary', 0, 0),
('language.pali', 'vocabulary', 0, 0),
('language.pampanga', 'vocabulary', 0, 0),
('language.pangasinan', 'vocabulary', 0, 0),
('language.papiamento', 'vocabulary', 0, 0),
('language.pashto', 'vocabulary', 0, 0),
('language.persian', 'vocabulary', 0, 0),
('language.persian.old', 'vocabulary', 0, 0),
('language.phoenician', 'vocabulary', 0, 0),
('language.picard', 'vocabulary', 0, 0),
('language.piedmontese', 'vocabulary', 0, 0),
('language.pisin.tok', 'vocabulary', 0, 0),
('language.plautdietsch', 'vocabulary', 0, 0),
('language.pohnpeian', 'vocabulary', 0, 0),
('language.polish', 'vocabulary', 0, 0),
('language.pontic', 'vocabulary', 0, 0),
('language.portuguese', 'vocabulary', 0, 0),
('language.portuguese.brazilian', 'vocabulary', 0, 0),
('language.portuguese.european', 'vocabulary', 0, 0),
('language.provençal.old', 'vocabulary', 0, 0),
('language.prussian', 'vocabulary', 0, 0),
('language.punjabi', 'vocabulary', 0, 0),
('language.quechua', 'vocabulary', 0, 0),
('language.quichua.chimborazohighland', 'vocabulary', 0, 0),
('language.rajasthani', 'vocabulary', 0, 0),
('language.rapanui', 'vocabulary', 0, 0),
('language.rarotongan', 'vocabulary', 0, 0),
('language.riffian', 'vocabulary', 0, 0),
('language.romagnol', 'vocabulary', 0, 0),
('language.romanian', 'vocabulary', 0, 0),
('language.romansh', 'vocabulary', 0, 0),
('language.romany', 'vocabulary', 0, 0),
('language.rombo', 'vocabulary', 0, 0),
('language.root', 'vocabulary', 0, 0),
('language.rotuman', 'vocabulary', 0, 0),
('language.roviana', 'vocabulary', 0, 0),
('language.rundi', 'vocabulary', 0, 0),
('language.russian', 'vocabulary', 0, 0),
('language.rusyn', 'vocabulary', 0, 0),
('language.rwa', 'vocabulary', 0, 0),
('language.saho', 'vocabulary', 0, 0),
('language.sakha', 'vocabulary', 0, 0),
('language.samburu', 'vocabulary', 0, 0),
('language.sami.inari', 'vocabulary', 0, 0),
('language.sami.lule', 'vocabulary', 0, 0),
('language.sami.skolt', 'vocabulary', 0, 0),
('language.sami.southern', 'vocabulary', 0, 0),
('language.samoan', 'vocabulary', 0, 0),
('language.samogitian', 'vocabulary', 0, 0),
('language.sandawe', 'vocabulary', 0, 0),
('language.sango', 'vocabulary', 0, 0),
('language.sangu', 'vocabulary', 0, 0),
('language.sanskrit', 'vocabulary', 0, 0),
('language.santali', 'vocabulary', 0, 0),
('language.sardinian', 'vocabulary', 0, 0),
('language.sardinian.sassarese', 'vocabulary', 0, 0),
('language.sasak', 'vocabulary', 0, 0),
('language.saurashtra', 'vocabulary', 0, 0),
('language.saxon.low', 'vocabulary', 0, 0),
('language.scots', 'vocabulary', 0, 0),
('language.selayar', 'vocabulary', 0, 0),
('language.selkup', 'vocabulary', 0, 0),
('language.sena', 'vocabulary', 0, 0),
('language.seneca', 'vocabulary', 0, 0),
('language.senni.koyraboro', 'vocabulary', 0, 0),
('language.serbian', 'vocabulary', 0, 0),
('language.serbocroatian', 'vocabulary', 0, 0),
('language.serer', 'vocabulary', 0, 0),
('language.seri', 'vocabulary', 0, 0),
('language.shambala', 'vocabulary', 0, 0),
('language.shan', 'vocabulary', 0, 0),
('language.shona', 'vocabulary', 0, 0),
('language.sicilian', 'vocabulary', 0, 0),
('language.sidamo', 'vocabulary', 0, 0),
('language.siksika', 'vocabulary', 0, 0),
('language.silesian', 'vocabulary', 0, 0),
('language.silesian.lower', 'vocabulary', 0, 0),
('language.sindhi', 'vocabulary', 0, 0),
('language.sinhala', 'vocabulary', 0, 0),
('language.slave', 'vocabulary', 0, 0),
('language.slavic.church', 'vocabulary', 0, 0),
('language.slovak', 'vocabulary', 0, 0),
('language.slovenian', 'vocabulary', 0, 0),
('language.soga', 'vocabulary', 0, 0),
('language.sogdien', 'vocabulary', 0, 0),
('language.somali', 'vocabulary', 0, 0),
('language.soninke', 'vocabulary', 0, 0),
('language.sorbian.lower', 'vocabulary', 0, 0),
('language.sorbian.upper', 'vocabulary', 0, 0),
('language.sotho.northern', 'vocabulary', 0, 0),
('language.sotho.southern', 'vocabulary', 0, 0),
('language.southern kurdish', 'vocabulary', 0, 0),
('language.spanish', 'vocabulary', 0, 0),
('language.spanish.european', 'vocabulary', 0, 0),
('Language.spanish.latinamerican', 'vocabulary', 0, 0),
('language.spanish.mexican', 'vocabulary', 0, 0),
('language.sukuma', 'vocabulary', 0, 0),
('language.sumerian', 'vocabulary', 0, 0),
('language.sundanese', 'vocabulary', 0, 0),
('language.susu', 'vocabulary', 0, 0),
('language.swahili', 'vocabulary', 0, 0),
('language.swahili.congo', 'vocabulary', 0, 0),
('language.swati', 'vocabulary', 0, 0),
('language.swedish', 'vocabulary', 0, 0),
('language.syriac', 'vocabulary', 0, 0),
('language.syriac.classical', 'vocabulary', 0, 0),
('language.tachelhit', 'vocabulary', 0, 0),
('language.tagalog', 'vocabulary', 0, 0),
('language.tahitian', 'vocabulary', 0, 0),
('language.taita', 'vocabulary', 0, 0),
('language.tajik', 'vocabulary', 0, 0),
('language.talysh', 'vocabulary', 0, 0),
('language.tamashek', 'vocabulary', 0, 0),
('language.tamazight.centralatlas', 'vocabulary', 0, 0),
('language.tamazight.standardmoroccan', 'vocabulary', 0, 0),
('language.tamil', 'vocabulary', 0, 0),
('language.taroko', 'vocabulary', 0, 0),
('language.tasawaq', 'vocabulary', 0, 0),
('language.tat.muslim', 'vocabulary', 0, 0),
('language.tatar', 'vocabulary', 0, 0),
('language.telugu', 'vocabulary', 0, 0),
('language.tereno', 'vocabulary', 0, 0),
('language.teso', 'vocabulary', 0, 0),
('language.tetum', 'vocabulary', 0, 0),
('language.thai', 'vocabulary', 0, 0),
('language.tibetan', 'vocabulary', 0, 0),
('language.tigre', 'vocabulary', 0, 0),
('language.tigrinya', 'vocabulary', 0, 0),
('language.timne', 'vocabulary', 0, 0),
('language.tiv', 'vocabulary', 0, 0),
('language.tlingit', 'vocabulary', 0, 0),
('language.tokelau', 'vocabulary', 0, 0),
('language.tonga.nyasa', 'vocabulary', 0, 0),
('language.tongan', 'vocabulary', 0, 0),
('language.tongo.sranan', 'vocabulary', 0, 0),
('language.tsakhur', 'vocabulary', 0, 0),
('language.tsakonian', 'vocabulary', 0, 0),
('language.tsimshian', 'vocabulary', 0, 0),
('language.tsonga', 'vocabulary', 0, 0),
('language.tswana', 'vocabulary', 0, 0),
('language.tulu', 'vocabulary', 0, 0),
('language.tumbuka', 'vocabulary', 0, 0),
('language.turkish', 'vocabulary', 0, 0),
('language.turkish.crimean', 'vocabulary', 0, 0),
('language.turkish.ottoman', 'vocabulary', 0, 0),
('language.turkmen', 'vocabulary', 0, 0),
('language.turoyo', 'vocabulary', 0, 0),
('language.tuvalu', 'vocabulary', 0, 0),
('language.tuvinian', 'vocabulary', 0, 0),
('language.twi', 'vocabulary', 0, 0),
('language.tyap', 'vocabulary', 0, 0),
('language.udmurt', 'vocabulary', 0, 0),
('language.ugaritic', 'vocabulary', 0, 0),
('language.ukrainian', 'vocabulary', 0, 0),
('language.umbundu', 'vocabulary', 0, 0),
('language.unknown', 'vocabulary', 0, 0),
('language.urdu', 'vocabulary', 0, 0),
('language.uyghur', 'vocabulary', 0, 0),
('language.uzbek', 'vocabulary', 0, 0),
('language.vai', 'vocabulary', 0, 0),
('language.venda', 'vocabulary', 0, 0),
('language.venetian', 'vocabulary', 0, 0),
('language.veps', 'vocabulary', 0, 0),
('language.vietnamese', 'vocabulary', 0, 0),
('language.volapük', 'vocabulary', 0, 0),
('language.võro', 'vocabulary', 0, 0),
('language.votic', 'vocabulary', 0, 0),
('language.vunjo', 'vocabulary', 0, 0),
('language.walloon', 'vocabulary', 0, 0),
('language.walser', 'vocabulary', 0, 0),
('language.waray', 'vocabulary', 0, 0),
('language.warlpiri', 'vocabulary', 0, 0),
('language.washo', 'vocabulary', 0, 0),
('language.wayuu', 'vocabulary', 0, 0),
('language.welsh', 'vocabulary', 0, 0),
('language.wolaytta', 'vocabulary', 0, 0),
('language.wolof', 'vocabulary', 0, 0),
('language.xhosa', 'vocabulary', 0, 0),
('language.yangben', 'vocabulary', 0, 0),
('language.yao', 'vocabulary', 0, 0),
('language.yapese', 'vocabulary', 0, 0),
('language.yemba', 'vocabulary', 0, 0),
('language.yi.sichuan', 'vocabulary', 0, 0),
('language.yiddish', 'vocabulary', 0, 0),
('language.yoruba', 'vocabulary', 0, 0),
('language.yupik.central', 'vocabulary', 0, 0),
('language.zapotec', 'vocabulary', 0, 0),
('language.zarma', 'vocabulary', 0, 0),
('language.zaza', 'vocabulary', 0, 0),
('language.zeelandic', 'vocabulary', 0, 0),
('language.zenaga', 'vocabulary', 0, 0),
('language.zhuang', 'vocabulary', 0, 0),
('language.zulu', 'vocabulary', 0, 0),
('language.zuni', 'vocabulary', 0, 0),
('length.kilometre', 'vocabulary', 0, 0),
('length.metre', 'vocabulary', 0, 0),
('length.micrometre', 'vocabulary', 0, 0),
('length.millimetre', 'vocabulary', 0, 0),
('length.nanometre', 'vocabulary', 0, 0),
('map.layer.aerial', 'core', 0, 0),
('map.layer.aerial.labels', 'core', 0, 0),
('map.layer.bing.aerial', 'core', 0, 0),
('map.layer.bing.aerialwithlabels', 'core', 0, 0),
('map.layer.bing.road', 'core', 0, 0),
('map.layer.road', 'core', 0, 0),
('map.legend.max', 'core', 0, 0),
('map.legend.min', 'core', 0, 0),
('map.source.bing', 'core', 0, 0),
('map.source.kfs', 'core', 0, 0),
('map.style.choropleth', 'core', 0, 0),
('map.style.distribution', 'core', 0, 0),
('map.style.none', 'core', 0, 0),
('mass.gram', 'vocabulary', 0, 0),
('mass.kilogram', 'vocabulary', 0, 0),
('mass.microgram', 'vocabulary', 0, 0),
('mass.milligram', 'vocabulary', 0, 0),
('mass.tonne', 'vocabulary', 0, 0),
('module.campaign', 'core', 0, 0),
('module.file', 'core', 0, 0),
('module.find', 'core', 0, 0),
('module.image', 'core', 0, 0),
('module.location', 'core', 0, 0),
('property.address', 'core', 0, 0),
('property.avatar', 'core', 0, 0),
('property.city', 'core', 0, 0),
('property.content', 'core', 0, 0),
('property.country', 'core', 0, 0),
('property.dateofbirth', 'core', 0, 0),
('property.id', 'core', 0, 0),
('property.initials', 'core', 0, 0),
('property.language', 'core', 0, 0),
('property.length', 'core', 0, 0),
('property.logo', 'core', 0, 0),
('property.module', 'core', 0, 0),
('property.name', 'core', 0, 0),
('property.phone', 'core', 0, 0),
('property.street', 'core', 0, 0),
('property.title', 'core', 0, 0),
('schema.file', 'core', 0, 0),
('search.placeholder', 'core', 0, 0),
('site.brand', 'core', 0, 0),
('site.welcome', 'core', 0, 0),
('spatial.crs.wgs84', 'vocabulary', 0, 0),
('spatial.format.geojson', 'vocabulary', 0, 0),
('spatial.format.gpx', 'vocabulary', 0, 0),
('spatial.format.wkt', 'vocabulary', 0, 0),
('translation.domain.core', 'core', 0, 0),
('translation.domain.user', 'core', 0, 0),
('translation.domain.vocabulary', 'core', 0, 0),
('translation.role.default', 'core', 0, 0),
('translation.role.description', 'core', 0, 0),
('translation.role.from', 'core', 0, 0),
('translation.role.negative', 'core', 0, 0),
('translation.role.official', 'core', 0, 0),
('translation.role.opposite', 'core', 0, 0),
('translation.role.positive', 'core', 0, 0),
('translation.role.resource', 'core', 0, 0),
('translation.role.title', 'core', 0, 0),
('translation.role.to', 'core', 0, 0),
('user.greeting', 'user', 0, 1),
('user.menu.edit', 'user', 0, 0),
('user.menu.home', 'core', 0, 0),
('user.menu.list', 'user', 0, 0),
('user.menu.login', 'user', 0, 0),
('user.menu.logout', 'user', 0, 0),
('user.menu.password', 'user', 0, 0),
('user.menu.register', 'user', 0, 0),
('user.menu.view', 'user', 0, 0),
('vocabulary.country', 'core', 0, 0),
('vocabulary.distance', 'core', 0, 0),
('vocabulary.language', 'core', 0, 0),
('vocabulary.mass', 'core', 0, 0),
('vocabulary.spatial.crs', 'core', 0, 0),
('vocabulary.spatial.format', 'core', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_domain`
--

CREATE TABLE `ark_translation_domain` (
  `domain` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_domain`
--

INSERT INTO `ark_translation_domain` (`domain`, `keyword`) VALUES
('core', 'translation.domain.core'),
('user', 'translation.domain.user'),
('vocabulary', 'translation.domain.vocabulary');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_language`
--

CREATE TABLE `ark_translation_language` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `markup` tinyint(1) NOT NULL DEFAULT 0,
  `vocabulary` tinyint(1) NOT NULL DEFAULT 0,
  `text` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_language`
--

INSERT INTO `ark_translation_language` (`language`, `markup`, `vocabulary`, `text`) VALUES
('en', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_message`
--

CREATE TABLE `ark_translation_message` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_message`
--

INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'core.action.approve', 'default', 'Approve', ''),
('en', 'core.action.cancel', 'default', 'Cancel', ''),
('en', 'core.action.edit', 'default', 'edit', NULL),
('en', 'core.action.register', 'default', 'Register', ''),
('en', 'core.action.select', 'default', 'Select Action', ''),
('en', 'core.action.suspend', 'default', 'Suspend', ''),
('en', 'core.action.view', 'default', 'View', ''),
('en', 'core.action.view1', 'default', 'View', ''),
('en', 'core.actor', 'resource', 'actors', NULL),
('en', 'core.actor.address', 'default', 'Address', ''),
('en', 'core.actor.avatar', 'default', 'Photo', ''),
('en', 'core.actor.biography', 'default', 'Biography', ''),
('en', 'core.actor.class.institution', 'default', 'core.actor.type.institution', NULL),
('en', 'core.actor.class.museum', 'default', 'Museum', NULL),
('en', 'core.actor.class.person', 'default', 'core.actor.type.person', NULL),
('en', 'core.actor.email', 'default', 'E-mail', ''),
('en', 'core.actor.event.registered', 'default', 'Registered', ''),
('en', 'core.actor.format', 'default', 'Actor Format', NULL),
('en', 'core.actor.fullname', 'default', 'Name', NULL),
('en', 'core.actor.id', 'default', 'Actor ID', NULL),
('en', 'core.actor.initials', 'default', 'Initials', ''),
('en', 'core.actor.institution', 'default', 'Institution', NULL),
('en', 'core.actor.license', 'default', 'Photo License', ''),
('en', 'core.actor.module', 'default', 'Actor', NULL),
('en', 'core.actor.person', 'default', 'Person', NULL),
('en', 'core.actor.schema', 'default', 'Actor', NULL),
('en', 'core.actor.shortname', 'default', 'Short Name', NULL),
('en', 'core.actor.telephone', 'default', 'Telephone', ''),
('en', 'core.actor.visibility', 'default', 'Privacy', ''),
('en', 'core.admin', 'resource', 'admin', ''),
('en', 'core.admin.user.register', 'default', 'Register a new user', ''),
('en', 'core.blank', 'default', '', NULL),
('en', 'core.button.apply', 'default', 'Apply', ''),
('en', 'core.button.change', 'default', 'Change', ''),
('en', 'core.button.clone', 'default', 'Clone', ''),
('en', 'core.button.save', 'default', 'Save', NULL),
('en', 'core.button.search', 'default', 'Search', NULL),
('en', 'core.button.select', 'default', 'Select', ''),
('en', 'core.button.send', 'default', 'Send', ''),
('en', 'core.event.class.viewed', 'default', 'Viewed', ''),
('en', 'core.event.edited', 'default', 'Edited', NULL),
('en', 'core.events', 'resource', 'events', NULL),
('en', 'core.file', 'resource', 'files', NULL),
('en', 'core.file.class.audio', 'default', 'core.file.type.audio', NULL),
('en', 'core.file.class.document', 'default', 'core.file.type.document', NULL),
('en', 'core.file.class.image', 'default', 'core.file.type.image', NULL),
('en', 'core.file.class.other', 'default', 'core.file.type.other', NULL),
('en', 'core.file.class.text', 'default', 'core.file.type.text', NULL),
('en', 'core.file.class.video', 'default', 'core.file.type.video', NULL),
('en', 'core.file.status.checkedin', 'default', 'core.file.status.checkedin', NULL),
('en', 'core.file.status.checkedout', 'default', 'core.file.status.checkedout', NULL),
('en', 'core.file.status.expired', 'default', 'core.file.status.expired', NULL),
('en', 'core.file.status.locked', 'default', 'core.file.status.locked', NULL),
('en', 'core.file.status.new', 'default', 'core.file.status.new', NULL),
('en', 'core.file.type.text', 'default', 'Text File', NULL),
('en', 'core.file.type.video', 'default', 'Video File', NULL),
('en', 'core.license.cc0', 'default', 'CC0: No rights reserved.', ''),
('en', 'core.license.ccbyncsa', 'default', 'CC BY-NC-SA: Attribution, Non-Commercial, Share-Alike', ''),
('en', 'core.license.ccbysa', 'default', 'CC BY-SA: Attribution, Share-Alike', ''),
('en', 'core.message', 'resource', 'messages', NULL),
('en', 'core.message.allmessages', 'default', 'See Older Notifications', NULL),
('en', 'core.message.class', 'default', 'Type', NULL),
('en', 'core.message.class.notification', 'default', 'Notification', NULL),
('en', 'core.message.messages', 'default', 'Notifications', NULL),
('en', 'core.message.messages.new', 'default', 'New Notifications', NULL),
('en', 'core.message.newmessages', 'default', 'new messages', ''),
('en', 'core.message.notification.body', 'default', 'Notification', NULL),
('en', 'core.message.notification.event', 'default', 'Event', NULL),
('en', 'core.message.notshown', 'default', 'message(s) not shown', ''),
('en', 'core.message.sender', 'default', 'From', 'Fra'),
('en', 'core.message.sent_at', 'default', 'Date', NULL),
('en', 'core.placeholder', 'default', '-', NULL),
('en', 'core.profile', 'default', 'Profile', ''),
('en', 'core.profile', 'resource', 'profile', ''),
('en', 'core.profiles', 'resource', 'profiles', ''),
('en', 'core.security.user.status', 'default', 'Status', ''),
('en', 'core.security.user.status.disabled', 'default', 'Disabled', ''),
('en', 'core.security.user.status.enabled', 'default', 'Enabled', ''),
('en', 'core.security.user.status.expired', 'default', 'Expired', ''),
('en', 'core.security.user.status.locked', 'default', 'Locked', ''),
('en', 'core.security.user.status.registered', 'default', 'Registered', ''),
('en', 'core.security.user.status.verified', 'default', 'Verified', ''),
('en', 'core.user', 'resource', 'users', ''),
('en', 'core.user.actions', 'default', 'Actions', ''),
('en', 'core.user.agree', 'default', 'I agree to abide by the site Terms and Conditions.', ''),
('en', 'core.user.email', 'default', 'Email', ''),
('en', 'core.user.email.repeat', 'default', 'Repeat Email', ''),
('en', 'core.user.level', 'default', 'Level', ''),
('en', 'core.user.login', 'default', 'Login', ''),
('en', 'core.user.login.heading', 'default', 'Login', ''),
('en', 'core.user.login.notregistered', 'default', 'Not registered as a user?', ''),
('en', 'core.user.login.register', 'default', 'Register here.', ''),
('en', 'core.user.name', 'default', 'User Name', NULL),
('en', 'core.user.password', 'default', 'Password', ''),
('en', 'core.user.password.change', 'default', 'Change Password', ''),
('en', 'core.user.password.change', 'success', 'You have successfully changed your password.', ''),
('en', 'core.user.password.current', 'default', 'Current Password', ''),
('en', 'core.user.password.forgot', 'default', 'Forgotten Password?', NULL),
('en', 'core.user.password.new', 'default', 'New Password', ''),
('en', 'core.user.password.repeat', 'default', 'Repeat Password', ''),
('en', 'core.user.password.set', 'default', 'Set Password', ''),
('en', 'core.user.profile', 'default', 'Profile', ''),
('en', 'core.user.register', 'default', 'Register', ''),
('en', 'core.user.register', 'success', 'Your user registration has been submitted. Please verify your email address and wait for your user profile to be reviewed and approved.', ''),
('en', 'core.user.register.existing', 'default', 'Already have an account?', ''),
('en', 'core.user.register.faq', 'default', 'FAQ', ''),
('en', 'core.user.register.heading', 'default', 'Register as a new user.', ''),
('en', 'core.user.register.loggedin', 'default', 'Hello, %name%. You are already registered and signed in.', ''),
('en', 'core.user.register.login', 'default', 'Sign in here.', ''),
('en', 'core.user.register.logout', 'default', 'Sign out.', ''),
('en', 'core.user.reset', 'default', 'Reset', ''),
('en', 'core.user.reset.heading', 'default', 'Reset User', ''),
('en', 'core.user.reset.notregistered', 'default', 'Not a registered user?', ''),
('en', 'core.user.reset.register', 'default', 'Register here.', ''),
('en', 'core.user.reset.reset', 'default', 'Enter your username to request a password reset or to unlock your account.', ''),
('en', 'core.user.role', 'default', 'User Role', ''),
('en', 'core.user.role.add', 'default', 'Add User Role', ''),
('en', 'core.user.role.expiry', 'default', 'Expiry Date', ''),
('en', 'core.user.terms', 'default', 'Terms and Conditions', ''),
('en', 'core.user.terms.agree', 'default', 'I agree to the Terms and Conditions for using ARK.', ''),
('en', 'core.user.terms.v1', 'default', '<H2>Terms and Conditions</H2><P>v1.0 dated 1 June 2017</P><P>Lorem Ipsem...</P>', ''),
('en', 'core.user.username', 'default', 'Username', ''),
('en', 'core.users', 'resource', 'users', ''),
('en', 'core.visibility.private', 'default', 'Private', ''),
('en', 'core.visibility.public', 'default', 'Public', ''),
('en', 'core.visibility.restricted', 'default', 'Restricted', ''),
('en', 'core.widget.comments', 'default', 'Message For Museum', ''),
('en', 'core.widget.send', 'default', 'Send', ''),
('en', 'core.widget.submit', 'default', 'Submit', ''),
('en', 'core.workflow.action', 'default', 'Actions', ''),
('en', 'core.workflow.role', 'default', 'Role', ''),
('en', 'core.workflow.role.admin', 'default', 'Administrator', ''),
('en', 'core.workflow.role.anon', 'default', 'Anonymous', ''),
('en', 'core.workflow.role.user', 'default', 'Researcher', ''),
('en', 'country.afghanistan', 'default', 'Afghanistan ', NULL),
('en', 'country.alandislands', 'default', 'Åland Islands ', NULL),
('en', 'country.albania', 'default', 'Albania ', NULL),
('en', 'country.algeria', 'default', 'Algeria ', NULL),
('en', 'country.americansamoa', 'default', 'American Samoa ', NULL),
('en', 'country.andorra', 'default', 'Andorra ', NULL),
('en', 'country.angola', 'default', 'Angola ', NULL),
('en', 'country.anguilla', 'default', 'Anguilla ', NULL),
('en', 'country.antarctica', 'default', 'Antarctica ', NULL),
('en', 'country.antigua', 'default', 'Antigua and Barbuda ', NULL),
('en', 'country.argentina', 'default', 'Argentina ', NULL),
('en', 'country.armenia', 'default', 'Armenia ', NULL),
('en', 'country.aruba', 'default', 'Aruba ', NULL),
('en', 'country.australia', 'default', 'Australia ', NULL),
('en', 'country.austria', 'default', 'Austria ', NULL),
('en', 'country.azerbaijan', 'default', 'Azerbaijan ', NULL),
('en', 'country.bahamas', 'default', 'Bahamas ', NULL),
('en', 'country.bahrain', 'default', 'Bahrain ', NULL),
('en', 'country.bangladesh', 'default', 'Bangladesh ', NULL),
('en', 'country.barbados', 'default', 'Barbados ', NULL),
('en', 'country.belarus', 'default', 'Belarus ', NULL),
('en', 'country.belgium', 'default', 'Belgium ', NULL),
('en', 'country.belize', 'default', 'Belize ', NULL),
('en', 'country.benin', 'default', 'Benin ', NULL),
('en', 'country.bermuda', 'default', 'Bermuda ', NULL),
('en', 'country.bhutan', 'default', 'Bhutan ', NULL),
('en', 'country.bolivia', 'default', 'Bolivia', NULL),
('en', 'country.bonaire', 'default', 'Bonaire, Sint Eustatius and Saba ', NULL),
('en', 'country.bosniaherzegovina', 'default', 'Bosnia and Herzegovina ', NULL),
('en', 'country.botswana', 'default', 'Botswana ', NULL),
('en', 'country.brazil', 'default', 'Brazil ', NULL),
('en', 'country.britishvirginislands', 'default', 'British Virgin Islands', NULL),
('en', 'country.brunei', 'default', 'Brunei Darussalam ', NULL),
('en', 'country.bulgaria', 'default', 'Bulgaria ', NULL),
('en', 'country.burkinafaso', 'default', 'Burkina Faso ', NULL),
('en', 'country.burundi', 'default', 'Burundi ', NULL),
('en', 'country.caboverde', 'default', 'Cabo Verde ', NULL),
('en', 'country.cambodia', 'default', 'Cambodia ', NULL),
('en', 'country.cameroon', 'default', 'Cameroon ', NULL),
('en', 'country.canada', 'default', 'Canada ', NULL),
('en', 'country.caymanislands', 'default', 'Cayman Islands ', NULL),
('en', 'country.centralafricanrepublic', 'default', 'Central African Republic ', NULL),
('en', 'country.chad', 'default', 'Chad ', NULL),
('en', 'country.chile', 'default', 'Chile ', NULL),
('en', 'country.china', 'default', 'China ', NULL),
('en', 'country.christmasisland', 'default', 'Christmas Island ', NULL),
('en', 'country.cocosislands', 'default', 'Cocos (Keeling) Islands ', NULL),
('en', 'country.colombia', 'default', 'Colombia ', NULL),
('en', 'country.comoros', 'default', 'Comoros ', NULL),
('en', 'country.congo', 'default', 'Congo ', NULL),
('en', 'country.cookislands', 'default', 'Cook Islands ', NULL),
('en', 'country.costarica', 'default', 'Costa Rica ', NULL),
('en', 'country.cotedivoire', 'default', 'Côte d\'Ivoire ', NULL),
('en', 'country.croatia', 'default', 'Croatia ', NULL),
('en', 'country.cuba', 'default', 'Cuba ', NULL),
('en', 'country.curacao', 'default', 'Curaçao ', NULL),
('en', 'country.cyprus', 'default', 'Cyprus ', NULL),
('en', 'country.czechrepublic', 'default', 'Czech Republic ', NULL),
('en', 'country.democraticrepubliccongo', 'default', 'Democratic Republic of the Congo ', NULL),
('en', 'country.denmark', 'default', 'Denmark ', NULL),
('en', 'country.djibouti', 'default', 'Djibouti ', NULL),
('en', 'country.dominica', 'default', 'Dominica ', NULL),
('en', 'country.dominicanrepublic', 'default', 'Dominican Republic ', NULL),
('en', 'country.ecuador', 'default', 'Ecuador ', NULL),
('en', 'country.egypt', 'default', 'Egypt ', NULL),
('en', 'country.elsalvador', 'default', 'El Salvador ', NULL),
('en', 'country.equatorialguinea', 'default', 'Equatorial Guinea ', NULL),
('en', 'country.eritrea', 'default', 'Eritrea ', NULL),
('en', 'country.estonia', 'default', 'Estonia ', NULL),
('en', 'country.ethiopia', 'default', 'Ethiopia ', NULL),
('en', 'country.falklandislands', 'default', 'Falkland Islands', NULL),
('en', 'country.faroeislands', 'default', 'Faroe Islands ', NULL),
('en', 'country.fiji', 'default', 'Fiji ', NULL),
('en', 'country.finland', 'default', 'Finland ', NULL),
('en', 'country.france', 'default', 'France ', NULL),
('en', 'country.frenchguiana', 'default', 'French Guiana ', NULL),
('en', 'country.frenchpolynesia', 'default', 'French Polynesia ', NULL),
('en', 'country.gabon', 'default', 'Gabon ', NULL),
('en', 'country.gambia', 'default', 'Gambia ', NULL),
('en', 'country.georgia', 'default', 'Georgia ', NULL),
('en', 'country.germany', 'default', 'Germany ', NULL),
('en', 'country.ghana', 'default', 'Ghana ', NULL),
('en', 'country.gibraltar', 'default', 'Gibraltar ', NULL),
('en', 'country.greece', 'default', 'Greece ', NULL),
('en', 'country.greenland', 'default', 'Greenland ', NULL),
('en', 'country.grenada', 'default', 'Grenada ', NULL),
('en', 'country.guadeloupe', 'default', 'Guadeloupe ', NULL),
('en', 'country.guam', 'default', 'Guam ', NULL),
('en', 'country.guatemala', 'default', 'Guatemala ', NULL),
('en', 'country.guernsey', 'default', 'Guernsey ', NULL),
('en', 'country.guinea', 'default', 'Guinea ', NULL),
('en', 'country.guinea-bissau', 'default', 'Guinea-Bissau ', NULL),
('en', 'country.guyana', 'default', 'Guyana ', NULL),
('en', 'country.haiti', 'default', 'Haiti ', NULL),
('en', 'country.honduras', 'default', 'Honduras ', NULL),
('en', 'country.hongkong', 'default', 'Hong Kong ', NULL),
('en', 'country.hungary', 'default', 'Hungary ', NULL),
('en', 'country.iceland', 'default', 'Iceland ', NULL),
('en', 'country.india', 'default', 'India ', NULL),
('en', 'country.indonesia', 'default', 'Indonesia ', NULL),
('en', 'country.iran', 'default', 'Iran', NULL),
('en', 'country.iraq', 'default', 'Iraq ', NULL),
('en', 'country.ireland', 'default', 'Ireland ', NULL),
('en', 'country.isleofman', 'default', 'Isle of Man ', NULL),
('en', 'country.israel', 'default', 'Israel ', NULL),
('en', 'country.italy', 'default', 'Italy ', NULL),
('en', 'country.jamaica', 'default', 'Jamaica ', NULL),
('en', 'country.japan', 'default', 'Japan ', NULL),
('en', 'country.jersey', 'default', 'Jersey ', NULL),
('en', 'country.jordan', 'default', 'Jordan ', NULL),
('en', 'country.kazakhstan', 'default', 'Kazakhstan ', NULL),
('en', 'country.kenya', 'default', 'Kenya ', NULL),
('en', 'country.kiribati', 'default', 'Kiribati ', NULL),
('en', 'country.kuwait', 'default', 'Kuwait ', NULL),
('en', 'country.kyrgyzstan', 'default', 'Kyrgyzstan ', NULL),
('en', 'country.lao', 'default', 'Lao', NULL),
('en', 'country.latvia', 'default', 'Latvia ', NULL),
('en', 'country.lebanon', 'default', 'Lebanon ', NULL),
('en', 'country.lesotho', 'default', 'Lesotho ', NULL),
('en', 'country.liberia', 'default', 'Liberia ', NULL),
('en', 'country.libya', 'default', 'Libya ', NULL),
('en', 'country.liechtenstein', 'default', 'Liechtenstein ', NULL),
('en', 'country.lithuania', 'default', 'Lithuania ', NULL),
('en', 'country.luxembourg', 'default', 'Luxembourg ', NULL),
('en', 'country.macao', 'default', 'Macao ', NULL),
('en', 'country.macedonia', 'default', 'Macedonia', NULL),
('en', 'country.madagascar', 'default', 'Madagascar ', NULL),
('en', 'country.malawi', 'default', 'Malawi ', NULL),
('en', 'country.malaysia', 'default', 'Malaysia ', NULL),
('en', 'country.maldives', 'default', 'Maldives ', NULL),
('en', 'country.mali', 'default', 'Mali ', NULL),
('en', 'country.malta', 'default', 'Malta ', NULL),
('en', 'country.marshallislands', 'default', 'Marshall Islands ', NULL),
('en', 'country.martinique', 'default', 'Martinique ', NULL),
('en', 'country.mauritania', 'default', 'Mauritania ', NULL),
('en', 'country.mauritius', 'default', 'Mauritius ', NULL),
('en', 'country.mayotte', 'default', 'Mayotte ', NULL),
('en', 'country.mexico', 'default', 'Mexico ', NULL),
('en', 'country.micronesia', 'default', 'Micronesia', NULL),
('en', 'country.moldova', 'default', 'Moldova', NULL),
('en', 'country.monaco', 'default', 'Monaco ', NULL),
('en', 'country.mongolia', 'default', 'Mongolia ', NULL),
('en', 'country.montenegro', 'default', 'Montenegro ', NULL),
('en', 'country.montserrat', 'default', 'Montserrat ', NULL),
('en', 'country.morocco', 'default', 'Morocco ', NULL),
('en', 'country.mozambique', 'default', 'Mozambique ', NULL),
('en', 'country.myanmar', 'default', 'Myanmar ', NULL),
('en', 'country.namibia', 'default', 'Namibia ', NULL),
('en', 'country.nauru', 'default', 'Nauru ', NULL),
('en', 'country.nepal', 'default', 'Nepal ', NULL),
('en', 'country.netherlands', 'default', 'Netherlands ', NULL),
('en', 'country.newcaledonia', 'default', 'New Caledonia ', NULL),
('en', 'country.newzealand', 'default', 'New Zealand ', NULL),
('en', 'country.nicaragua', 'default', 'Nicaragua ', NULL),
('en', 'country.niger', 'default', 'Niger ', NULL),
('en', 'country.nigeria', 'default', 'Nigeria ', NULL),
('en', 'country.niue', 'default', 'Niue ', NULL),
('en', 'country.norfolkisland', 'default', 'Norfolk Island ', NULL),
('en', 'country.northernmarianaislands', 'default', 'Northern Mariana Islands ', NULL),
('en', 'country.northkorea', 'default', 'North Korea', NULL),
('en', 'country.norway', 'default', 'Norway ', NULL),
('en', 'country.oman', 'default', 'Oman ', NULL),
('en', 'country.pakistan', 'default', 'Pakistan ', NULL),
('en', 'country.palau', 'default', 'Palau ', NULL),
('en', 'country.palestine', 'default', 'Palestine', NULL),
('en', 'country.panama', 'default', 'Panama ', NULL),
('en', 'country.papuanewguinea', 'default', 'Papua New Guinea ', NULL),
('en', 'country.paraguay', 'default', 'Paraguay ', NULL),
('en', 'country.peru', 'default', 'Peru ', NULL),
('en', 'country.philippines', 'default', 'Philippines ', NULL),
('en', 'country.pitcairn', 'default', 'Pitcairn ', NULL),
('en', 'country.poland', 'default', 'Poland ', NULL),
('en', 'country.portugal', 'default', 'Portugal ', NULL),
('en', 'country.puertorico', 'default', 'Puerto Rico ', NULL),
('en', 'country.qatar', 'default', 'Qatar ', NULL),
('en', 'country.reunion', 'default', 'Réunion ', NULL),
('en', 'country.romania', 'default', 'Romania ', NULL),
('en', 'country.russia', 'default', 'Russia', NULL),
('en', 'country.rwanda', 'default', 'Rwanda ', NULL),
('en', 'country.saintbarthelemy', 'default', 'Saint Barthélemy ', NULL),
('en', 'country.sainthelena', 'default', 'Saint Helena, Ascension and Tristan da Cunha ', NULL),
('en', 'country.saintkitts', 'default', 'Saint Kitts and Nevis ', NULL),
('en', 'country.saintlucia', 'default', 'Saint Lucia ', NULL),
('en', 'country.saintmartin', 'default', 'Saint Martin', NULL),
('en', 'country.saintpierremiquelon', 'default', 'Saint Pierre and Miquelon ', NULL),
('en', 'country.saintvincent', 'default', 'Saint Vincent and the Grenadines ', NULL),
('en', 'country.samoa', 'default', 'Samoa ', NULL),
('en', 'country.sanmarino', 'default', 'San Marino ', NULL),
('en', 'country.saotome', 'default', 'Sao Tome and Principe ', NULL),
('en', 'country.saudiarabia', 'default', 'Saudi Arabia ', NULL),
('en', 'country.senegal', 'default', 'Senegal ', NULL),
('en', 'country.serbia', 'default', 'Serbia ', NULL),
('en', 'country.seychelles', 'default', 'Seychelles ', NULL),
('en', 'country.sierraleone', 'default', 'Sierra Leone ', NULL),
('en', 'country.singapore', 'default', 'Singapore ', NULL),
('en', 'country.sintmaarten', 'default', 'Sint Maarten', NULL),
('en', 'country.slovakia', 'default', 'Slovakia ', NULL),
('en', 'country.slovenia', 'default', 'Slovenia ', NULL),
('en', 'country.solomonislands', 'default', 'Solomon Islands ', NULL),
('en', 'country.somalia', 'default', 'Somalia ', NULL),
('en', 'country.southafrica', 'default', 'South Africa ', NULL),
('en', 'country.southgeorgia', 'default', 'South Georgia and the South Sandwich Islands ', NULL),
('en', 'country.southkorea', 'default', 'South Korea', NULL),
('en', 'country.southsudan', 'default', 'South Sudan ', NULL),
('en', 'country.spain', 'default', 'Spain ', NULL),
('en', 'country.srilanka', 'default', 'Sri Lanka ', NULL),
('en', 'country.sudan', 'default', 'Sudan ', NULL),
('en', 'country.suriname', 'default', 'Suriname ', NULL),
('en', 'country.svalbard', 'default', 'Svalbard and Jan Mayen ', NULL),
('en', 'country.swaziland', 'default', 'Swaziland ', NULL),
('en', 'country.sweden', 'default', 'Sweden ', NULL),
('en', 'country.switzerland', 'default', 'Switzerland ', NULL),
('en', 'country.syria', 'default', 'Syrian Arab Republic ', NULL),
('en', 'country.taiwan', 'default', 'Taiwan', NULL),
('en', 'country.tajikistan', 'default', 'Tajikistan ', NULL),
('en', 'country.tanzania', 'default', 'Tanzania', NULL),
('en', 'country.thailand', 'default', 'Thailand ', NULL),
('en', 'country.timorleste', 'default', 'Timor-Leste ', NULL),
('en', 'country.togo', 'default', 'Togo ', NULL),
('en', 'country.tokelau', 'default', 'Tokelau ', NULL),
('en', 'country.tonga', 'default', 'Tonga ', NULL),
('en', 'country.trinidadtobago', 'default', 'Trinidad and Tobago ', NULL),
('en', 'country.tunisia', 'default', 'Tunisia ', NULL),
('en', 'country.turkey', 'default', 'Turkey ', NULL),
('en', 'country.turkmenistan', 'default', 'Turkmenistan ', NULL),
('en', 'country.turkscaicos', 'default', 'Turks and Caicos Islands ', NULL),
('en', 'country.tuvalu', 'default', 'Tuvalu ', NULL),
('en', 'country.uganda', 'default', 'Uganda ', NULL),
('en', 'country.ukraine', 'default', 'Ukraine ', NULL),
('en', 'country.unitedarabemirates', 'default', 'United Arab Emirates ', NULL),
('en', 'country.unitedkingdom', 'default', 'United Kingdom', NULL),
('en', 'country.unitedstatesamerica', 'default', 'United States of America ', NULL),
('en', 'country.uruguay', 'default', 'Uruguay ', NULL),
('en', 'country.usvirginislands', 'default', 'US Virgin Islands', NULL),
('en', 'country.uzbekistan', 'default', 'Uzbekistan ', NULL),
('en', 'country.vanuatu', 'default', 'Vanuatu ', NULL),
('en', 'country.vatican', 'default', 'Holy See ', NULL),
('en', 'country.venezuela', 'default', 'Venezuela', NULL),
('en', 'country.vietnam', 'default', 'Viet Nam ', NULL),
('en', 'country.wallisfutuna', 'default', 'Wallis and Futuna ', NULL),
('en', 'country.westernsahara', 'default', 'Western Sahara ', NULL),
('en', 'country.yemen', 'default', 'Yemen ', NULL),
('en', 'country.zambia', 'default', 'Zambia ', NULL),
('en', 'country.zimbabwe', 'default', 'Zimbabwe ', NULL),
('en', 'dime.about', 'default', 'About', NULL),
('en', 'dime.about', 'resource', 'about', NULL),
('en', 'dime.about.background', 'default', 'Background for DIME', NULL),
('en', 'dime.about.groups', 'default', 'Detectorist Associations', NULL),
('en', 'dime.about.hevn', 'default', 'What is DIME?', NULL),
('en', 'dime.about.hevntext', 'default', 'DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.', NULL),
('en', 'dime.about.instructions', 'default', 'Instructions', NULL),
('en', 'dime.about.museums', 'default', 'Participating Museums', NULL),
('en', 'dime.about.partners', 'default', 'Partners', NULL),
('en', 'dime.action.approve', 'default', 'Approve', ''),
('en', 'dime.action.cancel', 'default', 'Cancel', ''),
('en', 'dime.action.delete', 'default', 'Delete', ''),
('en', 'dime.action.edit', 'default', 'edit', NULL),
('en', 'dime.action.record', 'default', 'Record', 'Record'),
('en', 'dime.action.register', 'default', 'Register', ''),
('en', 'dime.action.report', 'default', 'Report', 'Report'),
('en', 'dime.action.suspend', 'default', 'Suspend', ''),
('en', 'dime.action.view', 'default', 'View', ''),
('en', 'dime.actions', 'default', 'Action', 'Action'),
('en', 'dime.actor.municipalities', 'default', 'Municipalities', NULL),
('en', 'dime.actor.participating', 'default', 'DIME Participant', ''),
('en', 'dime.admin.users', 'default', 'Administer Users', ''),
('en', 'dime.admin.users.register', 'default', 'Register Users', ''),
('en', 'dime.background', 'default', 'Background', NULL),
('en', 'dime.background', 'resource', 'background', NULL),
('en', 'dime.claim', 'resource', 'claim', ''),
('en', 'dime.confirm', 'default', 'Confirm', ''),
('en', 'dime.controls', 'default', 'Go', ''),
('en', 'dime.copyright', 'default', 'Copyright © 2013-2017 Arkæologisk IT, Aarhus University', NULL),
('en', 'dime.credits', 'default', 'Data modelling and support: Carsten Risager | Design: Casper Skaaning Anderson | Implementation: L ~ P Archaeology', NULL),
('en', 'dime.denmark.admin', 'default', 'Danish Administration Units', ''),
('en', 'dime.denmark.municipality', 'default', 'Municipalities', NULL),
('en', 'dime.denmark.region', 'default', 'Danish Regions', ''),
('en', 'dime.detector', 'default', 'Detecting', NULL),
('en', 'dime.detector', 'resource', 'detecting', NULL),
('en', 'dime.exhibits', 'default', 'Exhibits', NULL),
('en', 'dime.exhibits', 'resource', 'exhibits', NULL),
('en', 'dime.exhibits.forests', 'default', 'Gold and Green Forests', NULL),
('en', 'dime.exhibits.weapons', 'default', 'Weapons in the Bronze Age', NULL),
('en', 'dime.find', 'default', 'Find', NULL),
('en', 'dime.find', 'resource', 'finds', NULL),
('en', 'dime.find.add', 'default', 'Add Find', NULL),
('en', 'dime.find.add', 'success', 'The find was successfully added.', ''),
('en', 'dime.find.artefact', 'default', 'Artefact', ''),
('en', 'dime.find.case', 'default', 'Case Number', ''),
('en', 'dime.find.case', 'help', 'A museum\'s case number usually consists of an acronym followed by file number, for example. MOM18640). The responsible museum can provide you with a registration number if they have already registered the relevant venue.', ''),
('en', 'dime.find.class', 'default', 'Type', 'DIME Find Type'),
('en', 'dime.find.classification', 'default', 'Classification', NULL),
('en', 'dime.find.classify', 'default', 'Classify', ''),
('en', 'dime.find.condition', 'default', 'Condition', NULL),
('en', 'dime.find.condition.fragmented', 'default', 'Fragmented', NULL),
('en', 'dime.find.condition.modified', 'default', 'Modified', NULL),
('en', 'dime.find.condition.unfinished', 'default', 'Unfinished', NULL),
('en', 'dime.find.condition.whole', 'default', 'Whole', NULL),
('en', 'dime.find.coordinates', 'default', 'Coordinates', ''),
('en', 'dime.find.custodian', 'default', 'Custodian', NULL),
('en', 'dime.find.custody', 'default', 'Custody', NULL),
('en', 'dime.find.custody.destroyed', 'default', 'destroyed', NULL),
('en', 'dime.find.custody.discarded', 'default', 'discarded', NULL),
('en', 'dime.find.custody.held', 'default', 'held', NULL),
('en', 'dime.find.custody.lost', 'default', 'Lost', NULL),
('en', 'dime.find.custody.requested', 'default', 'requested', NULL),
('en', 'dime.find.custody.sent', 'default', 'sent', NULL),
('en', 'dime.find.dating', 'default', 'Dating', NULL),
('en', 'dime.find.dating', 'help', 'Here you have two input options:\r\n\r\n1) In the drop down menu, you can specify a date period (eg Viking Period) or enter \'undated\' if you are unsure about the date.\r\n2) In the Advanced Dates menu you can specify a start and end date both as a period or year number. It is important that you specify BOTH start and end dates. For example, if you have found a coin from 1687 you indicate 1687 in both fields.', NULL),
('en', 'dime.find.description', 'default', 'Description', NULL),
('en', 'dime.find.event', 'default', 'Event', ''),
('en', 'dime.find.event.accessioned', 'default', 'Accessioned', ''),
('en', 'dime.find.event.classified', 'default', 'Classified', NULL),
('en', 'dime.find.event.deleted', 'default', 'Deleted', ''),
('en', 'dime.find.event.edited', 'default', 'Edited', NULL),
('en', 'dime.find.event.recorded', 'default', 'Recorded', ''),
('en', 'dime.find.event.reported', 'default', 'Reported', NULL),
('en', 'dime.find.event.validated', 'default', 'Validated', NULL),
('en', 'dime.find.filters', 'default', 'Filters', NULL),
('en', 'dime.find.finddate', 'default', 'Find Date', NULL),
('en', 'dime.find.finddate', 'help', 'Enter the date of when you actually found the item you want to register.', NULL),
('en', 'dime.find.finder', 'default', 'Detectorist', NULL),
('en', 'dime.find.finder_id', 'default', 'Find num. / X num.', NULL),
('en', 'dime.find.finder_id', 'help', 'To help the museum to record your finds, it is recommended that you enter a unique number for your find (the same number as you write on the find). NOTE! If you have received a find number from the museum then enter this.', NULL),
('en', 'dime.find.finder_place', 'default', 'Find spot', NULL),
('en', 'dime.find.finder_place', 'help', 'Enter the site / find site name, either what you or the museum uses.', NULL),
('en', 'dime.find.id', 'default', 'DIME ID', NULL),
('en', 'dime.find.images', 'default', 'Photos', ''),
('en', 'dime.find.images', 'help', 'To be useful to others:\r\n1) The finds have been cleaned (take care of the item!)\r\n2) There must be a scale next to the find (e.g., a ruler)\r\nTo see how to look here: // link to tutorial //', ''),
('en', 'dime.find.issuer', 'default', 'Issuer', ''),
('en', 'dime.find.length', 'default', 'Maximum Dimension', NULL),
('en', 'dime.find.location', 'default', 'Location', NULL),
('en', 'dime.find.location.decimal', 'default', 'Decimal (WGS84)', NULL),
('en', 'dime.find.location.utm', 'default', 'UTM', NULL),
('en', 'dime.find.material', 'default', 'Material', 'DIME Find Material'),
('en', 'dime.find.material.secondary', 'default', 'Secondary Material(s)', 'DIME Find Secondary Material(s)'),
('en', 'dime.find.metadata', 'default', 'ID', ''),
('en', 'dime.find.mint', 'default', 'Mint', ''),
('en', 'dime.find.municipality', 'default', 'Municipality', NULL),
('en', 'dime.find.museum_id', 'default', 'Museum Find ID', NULL),
('en', 'dime.find.owner', 'default', 'Owner', NULL),
('en', 'dime.find.period', 'default', 'Period', NULL),
('en', 'dime.find.period.end', 'default', 'End Period', 'DIME Find Period End'),
('en', 'dime.find.period.start', 'default', 'Period', 'DIME Find Period Start'),
('en', 'dime.find.photo', 'default', 'Photos', ''),
('en', 'dime.find.process', 'default', 'Status', NULL),
('en', 'dime.find.process.accessioned', 'default', 'Accessioned', NULL),
('en', 'dime.find.process.assessed', 'default', 'Assessed', NULL),
('en', 'dime.find.process.deleted', 'default', 'Deleted', NULL),
('en', 'dime.find.process.evaluated', 'default', 'Evaluated', NULL),
('en', 'dime.find.process.inactive', 'default', 'Inactive', NULL),
('en', 'dime.find.process.recorded', 'default', 'Recorded', NULL),
('en', 'dime.find.process.rejected', 'default', 'Rejected', NULL),
('en', 'dime.find.process.released', 'default', 'Released', NULL),
('en', 'dime.find.process.reported', 'default', 'Reported', NULL),
('en', 'dime.find.process.validated', 'default', 'Validated', NULL),
('en', 'dime.find.query.set', 'default', 'Your search found %items% finds.', ''),
('en', 'dime.find.recipient', 'default', 'Recipient', NULL),
('en', 'dime.find.save', 'default', 'Save', 'DIME Find Save button'),
('en', 'dime.find.search', 'default', 'Search Finds', NULL),
('en', 'dime.find.secondary.ceramic', 'default', 'Ceramic', ''),
('en', 'dime.find.secondary.enamel', 'default', 'Enamel', NULL),
('en', 'dime.find.secondary.gilded', 'default', 'Gilded', NULL),
('en', 'dime.find.secondary.glass', 'default', 'Glass', NULL),
('en', 'dime.find.secondary.iron', 'default', 'Iron', NULL),
('en', 'dime.find.secondary.looped', 'default', 'Looped', ''),
('en', 'dime.find.secondary.niello', 'default', 'Niello', NULL),
('en', 'dime.find.secondary.organic', 'default', 'Organic', NULL),
('en', 'dime.find.secondary.other', 'default', 'Other', NULL),
('en', 'dime.find.secondary.stone', 'default', 'Stone', NULL),
('en', 'dime.find.secondary.tinned', 'default', 'Tinned', NULL),
('en', 'dime.find.status', 'default', 'Status', ''),
('en', 'dime.find.subtype', 'default', 'Subtype', 'DIME Find Subtype'),
('en', 'dime.find.subtype.accessory.bell', 'default', 'Bell', NULL),
('en', 'dime.find.subtype.accessory.brooch', 'default', 'Brooch / Emblem', NULL),
('en', 'dime.find.subtype.accessory.buckle', 'default', 'Buckle (Buckle, shoe pænde etc.).', NULL),
('en', 'dime.find.subtype.accessory.button', 'default', 'Button', NULL),
('en', 'dime.find.subtype.accessory.button.bar', 'default', 'Bar Button', NULL),
('en', 'dime.find.subtype.accessory.button.other', 'default', 'Other type button (specify in description field)', NULL),
('en', 'dime.find.subtype.accessory.button.round', 'default', 'Alm. round, half-round or disc-shaped button sewing', NULL),
('en', 'dime.find.subtype.accessory.button.stud', 'default', 'Stud Button', NULL),
('en', 'dime.find.subtype.accessory.fitting', 'default', 'Fittings', NULL),
('en', 'dime.find.subtype.accessory.fitting.belt', 'default', 'Belt end fitting', NULL),
('en', 'dime.find.subtype.accessory.fitting.other', 'default', 'Other type fittings (specify in description field)', NULL),
('en', 'dime.find.subtype.accessory.fitting.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.accessory.hook', 'default', 'Hook / Malle', NULL),
('en', 'dime.find.subtype.accessory.jewelery', 'default', 'Jewelery', NULL),
('en', 'dime.find.subtype.accessory.jewelery.bracelet', 'default', 'Bangle / Bracelet', NULL),
('en', 'dime.find.subtype.accessory.jewelery.bracteate', 'default', 'Bracteate', NULL),
('en', 'dime.find.subtype.accessory.jewelery.earring', 'default', 'Earring', NULL),
('en', 'dime.find.subtype.accessory.jewelery.necklace', 'default', 'Necklace - collar, ring, or chain', NULL),
('en', 'dime.find.subtype.accessory.jewelery.other', 'default', 'Other jewelry (specify in description field)', NULL),
('en', 'dime.find.subtype.accessory.jewelery.pasyning', 'default', 'Påsyningsblik?', NULL),
('en', 'dime.find.subtype.accessory.jewelery.pearl', 'default', 'Pearl', NULL),
('en', 'dime.find.subtype.accessory.jewelery.pendant', 'default', 'Pendant / Amulet', NULL),
('en', 'dime.find.subtype.accessory.jewelery.ring', 'default', 'Finger ring', NULL),
('en', 'dime.find.subtype.accessory.lace', 'default', 'Lace End', NULL),
('en', 'dime.find.subtype.accessory.medal', 'default', 'Medal / Order', NULL),
('en', 'dime.find.subtype.accessory.other', 'default', 'Other costume accessories (specify in description field)', NULL),
('en', 'dime.find.subtype.accessory.pilgrim', 'default', 'Pilgrim Badge', NULL),
('en', 'dime.find.subtype.accessory.pin', 'default', 'Clothes pin', NULL),
('en', 'dime.find.subtype.accessory.tutulus', 'default', 'Tutulus', NULL),
('en', 'dime.find.subtype.accessory.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.coin.danish', 'default', 'Danish medieval coins', NULL),
('en', 'dime.find.subtype.coin.danish.civilwar', 'default', 'Danish civil war coin (1242-1380)', NULL),
('en', 'dime.find.subtype.coin.danish.early', 'default', 'Danish early middaldermønt (1067-1241)', NULL),
('en', 'dime.find.subtype.coin.danish.hvide', 'default', 'White', NULL),
('en', 'dime.find.subtype.coin.danish.klipping', 'default', 'Klipping', NULL),
('en', 'dime.find.subtype.coin.danish.other', 'default', 'Other Danish medieval coin (specify in description field)', NULL),
('en', 'dime.find.subtype.coin.danish.søsling', 'default', 'Søsling', NULL),
('en', 'dime.find.subtype.coin.danish.sterling', 'default', 'Copper Sterling', NULL),
('en', 'dime.find.subtype.coin.foreign', 'default', 'Medieval foreign coin (1067-1535)', NULL),
('en', 'dime.find.subtype.coin.foreign.hohlpfennig', 'default', 'Hohlpfennigs (Bracteate)', NULL),
('en', 'dime.find.subtype.coin.foreign.hvide', 'default', 'North German White', NULL),
('en', 'dime.find.subtype.coin.foreign.other', 'default', 'Other foreign medieval coin (specify in description field)', NULL),
('en', 'dime.find.subtype.coin.foreign.sterling', 'default', 'English Sterling', NULL),
('en', 'dime.find.subtype.coin.foreign.tournois', 'default', 'French Tournois', NULL),
('en', 'dime.find.subtype.coin.jeton', 'default', 'Jeton / Trade Token', NULL),
('en', 'dime.find.subtype.coin.modern', 'default', 'Modern coins (after 1535)', NULL),
('en', 'dime.find.subtype.coin.modern.danish', 'default', 'Modern Danish coin (after 1535)', NULL),
('en', 'dime.find.subtype.coin.modern.foreign', 'default', 'Modern foreign coin (after 1535)', NULL),
('en', 'dime.find.subtype.coin.other', 'default', 'Other coin (specify in description field)', NULL),
('en', 'dime.find.subtype.coin.roman', 'default', 'Roman / Byzantine coin', NULL),
('en', 'dime.find.subtype.coin.roman.aureus', 'default', 'Aureus', NULL),
('en', 'dime.find.subtype.coin.roman.denarius', 'default', 'Denarius', NULL),
('en', 'dime.find.subtype.coin.roman.other', 'default', 'Other Roman / Byzantine coin (specify in description field)', NULL),
('en', 'dime.find.subtype.coin.roman.sestertius', 'default', 'Sestertius', NULL),
('en', 'dime.find.subtype.coin.roman.siliqua', 'default', 'Siliqua', NULL),
('en', 'dime.find.subtype.coin.roman.solidus', 'default', 'Solidus', NULL),
('en', 'dime.find.subtype.coin.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.coin.viking', 'default', 'Viking Coin', NULL),
('en', 'dime.find.subtype.coin.viking.byzantine', 'default', 'Byzantine coins', NULL),
('en', 'dime.find.subtype.coin.viking.carolingian', 'default', 'Other Carolingian coin', NULL),
('en', 'dime.find.subtype.coin.viking.denarius', 'default', 'Carolingian denarius', NULL),
('en', 'dime.find.subtype.coin.viking.dirham', 'default', 'Dirham', NULL),
('en', 'dime.find.subtype.coin.viking.english', 'default', 'Other English coin', NULL),
('en', 'dime.find.subtype.coin.viking.german', 'default', 'Other German coin', NULL),
('en', 'dime.find.subtype.coin.viking.nordic', 'default', 'Danish / Nordic Coin', NULL),
('en', 'dime.find.subtype.coin.viking.other', 'default', 'Other Viking coin (specify in description field)', NULL),
('en', 'dime.find.subtype.coin.viking.penny', 'default', 'English penny', NULL),
('en', 'dime.find.subtype.coin.viking.phennig', 'default', 'German phennig', NULL),
('en', 'dime.find.subtype.coin.viking.sceat', 'default', 'Sceat', NULL),
('en', 'dime.find.subtype.fibula.beak', 'default', 'Beak fibula', NULL),
('en', 'dime.find.subtype.fibula.bird.above', 'default', 'Bird fibula (top view)', NULL),
('en', 'dime.find.subtype.fibula.bird.profile', 'default', 'Bird-shaped fibula (Early medieval - small bird in profile)', NULL),
('en', 'dime.find.subtype.fibula.bow', 'default', 'Bow fibula', NULL),
('en', 'dime.find.subtype.fibula.bow.ball', 'default', 'Hard cast ball fibula (Pre- Roman Iron Age)', NULL),
('en', 'dime.find.subtype.fibula.bow.band', 'default', 'Wide band-shaped bow fibulas (Roman Iron Age - Almgr. V)', NULL),
('en', 'dime.find.subtype.fibula.bow.bilateral', 'default', 'Bilateral fibulas with two combs (Early Roman Iron Age - Almgr. I-IV)', NULL),
('en', 'dime.find.subtype.fibula.bow.button', 'default', 'Back button fibula', NULL),
('en', 'dime.find.subtype.fibula.bow.cross', 'default', 'Cross shaped fibula', NULL),
('en', 'dime.find.subtype.fibula.bow.foot', 'default', 'Bow fibulas with enclosed foot including Nydam fibulas (Late Roman Iron Age - Almgr. VI)', NULL),
('en', 'dime.find.subtype.fibula.bow.high', 'default', 'Bow fibulas high needle holder (Late Roman Iron Age - Almgr. VII)', NULL),
('en', 'dime.find.subtype.fibula.bow.other', 'default', 'Other bow fibula (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.bow.relief', 'default', 'Relief fibula', NULL),
('en', 'dime.find.subtype.fibula.bowl', 'default', 'Bowl Fibula', NULL),
('en', 'dime.find.subtype.fibula.bowl.animal', 'default', 'Animal Shaped Bowl fibula', NULL),
('en', 'dime.find.subtype.fibula.bowl.circular', 'default', 'Circular Bowl fibula', NULL),
('en', 'dime.find.subtype.fibula.bowl.large', 'default', 'Large oval Bowl fibula (greater than 7.5 cm)', NULL),
('en', 'dime.find.subtype.fibula.bowl.other', 'default', 'Other bowl fibula (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.bowl.small', 'default', 'Small Oval Bowl fibula (less than 7.5 cm)', NULL),
('en', 'dime.find.subtype.fibula.circular', 'default', 'Circular fibula without enamel / casing', NULL),
('en', 'dime.find.subtype.fibula.circular.large', 'default', 'Large vaulted circular fibula (diameter of> 4 cm)', NULL),
('en', 'dime.find.subtype.fibula.circular.other', 'default', 'Other circular fibula (specify in description box)', NULL),
('en', 'dime.find.subtype.fibula.circular.small', 'default', 'Small vaulted circular fibula (diameter <4 cm)', NULL),
('en', 'dime.find.subtype.fibula.circular.tin', 'default', 'Circular tin fibula (early Middle Ages)', NULL),
('en', 'dime.find.subtype.fibula.enamel', 'default', 'Enamel fibula / FIbula with setting', NULL),
('en', 'dime.find.subtype.fibula.enamel.central', 'default', 'Fibula with central casing', NULL),
('en', 'dime.find.subtype.fibula.enamel.cross', 'default', 'Cross enamel fibula', NULL),
('en', 'dime.find.subtype.fibula.enamel.multiple', 'default', 'Fibula with several settings', NULL),
('en', 'dime.find.subtype.fibula.enamel.other', 'default', 'Other enamel fibula / FIbula with setting (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.equalarm', 'default', 'Equal arm fibula', NULL),
('en', 'dime.find.subtype.fibula.equalarm.large', 'default', 'Large equal arm fibula (Viking)', NULL),
('en', 'dime.find.subtype.fibula.equalarm.other', 'default', 'Other type equal arm fibula (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.equalarm.small', 'default', 'Small equal arm fibula (Germanic Iron Age)', NULL),
('en', 'dime.find.subtype.fibula.healing', 'default', 'Animal healing fibula (Urnes fibula and Lamb of God)', NULL),
('en', 'dime.find.subtype.fibula.healing.aalborg', 'default', 'Animal healing fibula of Aalborg type (Lamb of God without cross)', NULL),
('en', 'dime.find.subtype.fibula.healing.lamb', 'default', 'Lamb of God fibula / Agnus Dei fibula', NULL),
('en', 'dime.find.subtype.fibula.healing.other', 'default', 'Other Animal healing fibula (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.healing.urnes', 'default', 'Urnes fibula', NULL),
('en', 'dime.find.subtype.fibula.other', 'default', 'Other type fibula / brooches (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.plate', 'default', 'Plate fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.bird', 'default', 'Large bird-shaped plate fibula (Early Germanic Iron Age)', NULL),
('en', 'dime.find.subtype.fibula.plate.circular', 'default', 'Circular plate fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.coin', 'default', 'Coin fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.horse', 'default', 'Horse Shaped plate fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.other', 'default', 'Other plate fibula (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.plate.oval', 'default', 'Oval plate fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.råhede', 'default', 'Råhede fibula (cruciform plate Fibel)', NULL),
('en', 'dime.find.subtype.fibula.plate.rectangular', 'default', 'Rectangular plate fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.ship', 'default', 'Ship-shaped fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.snake', 'default', 'S-shaped snake plate fibula?', NULL),
('en', 'dime.find.subtype.fibula.plate.swastika', 'default', 'swastika fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.tongue', 'default', 'Tongue-shaped fibula', NULL),
('en', 'dime.find.subtype.fibula.plate.valkyrie', 'default', 'Valkyrie fibula', NULL),
('en', 'dime.find.subtype.fibula.ring', 'default', 'Medieval ring brooches', NULL),
('en', 'dime.find.subtype.fibula.ring.circular', 'default', 'Circular ring brooches', NULL),
('en', 'dime.find.subtype.fibula.ring.heart', 'default', 'Heart-shaped ring brooches', NULL),
('en', 'dime.find.subtype.fibula.ring.other', 'default', 'Other Type medieval ring brooches', NULL),
('en', 'dime.find.subtype.fibula.ring.star', 'default', 'Star-shaped ring brooches', NULL),
('en', 'dime.find.subtype.fibula.trilobal', 'default', 'Trilobal fibula', NULL),
('en', 'dime.find.subtype.fibula.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.fibula.viking', 'default', 'Other Viking fibula / brooch', NULL),
('en', 'dime.find.subtype.fibula.viking.other', 'default', 'Other Viking fibula / costume buckle (specify in description field)', NULL),
('en', 'dime.find.subtype.fibula.viking.rhombic', 'default', 'Rhombic fibula', NULL),
('en', 'dime.find.subtype.fibula.viking.ring', 'default', 'Ring Brooch / Ringed Pin', NULL),
('en', 'dime.find.subtype.fibula.viking.roof', 'default', 'Hjalti-shaped / roof-shaped fibula', NULL),
('en', 'dime.find.subtype.filbula.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.metal.ingot', 'default', 'Ingot', NULL),
('en', 'dime.find.subtype.metal.mold', 'default', 'Mold / Melting Pot', NULL),
('en', 'dime.find.subtype.metal.other', 'default', 'Other production waste / metal scrap / raw materials (specify in description field)', NULL),
('en', 'dime.find.subtype.metal.rest', 'default', 'Casting Rest', NULL),
('en', 'dime.find.subtype.metal.slag', 'default', 'Slag', NULL),
('en', 'dime.find.subtype.metal.tin', 'default', 'Tin Fragment', NULL),
('en', 'dime.find.subtype.metal.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.military.ammunition', 'default', 'Munition (musket ball / Garnet / shotshell / cannon balls)', NULL),
('en', 'dime.find.subtype.military.armor', 'default', 'Armor / Chainmail', NULL),
('en', 'dime.find.subtype.military.arrow', 'default', 'Arrowhead / Armbrøstbolt', NULL),
('en', 'dime.find.subtype.military.firearm', 'default', 'Firearms', NULL),
('en', 'dime.find.subtype.military.fitting', 'default', 'Fittings', NULL),
('en', 'dime.find.subtype.military.fitting.other', 'default', 'Other type bracket (specify in description field)', NULL),
('en', 'dime.find.subtype.military.fitting.sheath', 'default', 'Sheath Brackets', NULL),
('en', 'dime.find.subtype.military.fitting.uniform', 'default', 'Order / Uniform Bracket', NULL),
('en', 'dime.find.subtype.military.helmet', 'default', 'Helmet', NULL),
('en', 'dime.find.subtype.military.melee', 'default', 'Stroke / Stick Weapons', NULL),
('en', 'dime.find.subtype.military.melee.axe', 'default', 'Ax / celt / pålstav', NULL),
('en', 'dime.find.subtype.military.melee.blunt', 'default', 'Blunt weapons (clubs, maces, hammers, staves, flails, etc)', NULL),
('en', 'dime.find.subtype.military.melee.knife', 'default', 'Dagger', NULL),
('en', 'dime.find.subtype.military.melee.other', 'default', 'Other type of impact / stabbing weapon (specify in description field)', NULL),
('en', 'dime.find.subtype.military.melee.pointed', 'default', 'Lance / spear', NULL),
('en', 'dime.find.subtype.military.melee.sword', 'default', 'Sword / Sabel (blade or handle)', NULL),
('en', 'dime.find.subtype.military.other', 'default', 'Other weapons / militaria (specify in description field)', NULL),
('en', 'dime.find.subtype.military.shield', 'default', 'Shield', NULL),
('en', 'dime.find.subtype.military.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.tool.equestrian', 'default', 'Riding / Harness (track, horseshoes, bridle, etc)', NULL),
('en', 'dime.find.subtype.tool.equestrian.bell', 'default', 'Bell / rattle', NULL),
('en', 'dime.find.subtype.tool.equestrian.bridle', 'default', 'Hovedtøjsdele (bridle / bidselbeslag, remfordeler, etc.)', NULL),
('en', 'dime.find.subtype.tool.equestrian.cheek', 'default', 'Rattle glance? Cheek piece?', NULL),
('en', 'dime.find.subtype.tool.equestrian.other', 'default', 'Other riding / harness (specify in description box)', NULL),
('en', 'dime.find.subtype.tool.equestrian.shoe', 'default', 'Horseshoe', NULL),
('en', 'dime.find.subtype.tool.equestrian.stirrup', 'default', 'Stirrup / stirrup bracket', NULL),
('en', 'dime.find.subtype.tool.equestrian.tack', 'default', 'Track?', NULL),
('en', 'dime.find.subtype.tool.house', 'default', 'Housekeeping / Table and cookware / Interior', NULL),
('en', 'dime.find.subtype.tool.house.crockery', 'default', 'Plate / dish / bowl', NULL),
('en', 'dime.find.subtype.tool.house.cutlery', 'default', 'Flatware / Cutlery (table knives, forks, spoons)', NULL),
('en', 'dime.find.subtype.tool.house.fixtures', 'default', 'Furniture / bo bracket / handles / decorative rivets', NULL),
('en', 'dime.find.subtype.tool.house.key', 'default', 'Key', NULL),
('en', 'dime.find.subtype.tool.house.knife', 'default', 'Knife (blade knife, handle bracket, knife scabbard fittings, etc)', NULL),
('en', 'dime.find.subtype.tool.house.light', 'default', 'Candlestick / lamp', NULL),
('en', 'dime.find.subtype.tool.house.lock', 'default', 'Lock', NULL),
('en', 'dime.find.subtype.tool.house.other', 'default', 'Other \"Housekeeping / table and cookware / interior\" (Enter the description field)', NULL),
('en', 'dime.find.subtype.tool.house.pot', 'default', 'Malm pot', NULL),
('en', 'dime.find.subtype.tool.house.scissors', 'default', 'Scissors', NULL),
('en', 'dime.find.subtype.tool.house.striker', 'default', 'Fire-steel', NULL),
('en', 'dime.find.subtype.tool.measure', 'default', 'Safety Metal / Scales and weights', NULL),
('en', 'dime.find.subtype.tool.measure.clip', 'default', 'Cut silver / gold fragment (not coin fragments)', NULL),
('en', 'dime.find.subtype.tool.measure.ingot', 'default', 'Ingot', NULL),
('en', 'dime.find.subtype.tool.measure.scale', 'default', 'Scales', NULL),
('en', 'dime.find.subtype.tool.measure.weight', 'default', 'Weights', NULL),
('en', 'dime.find.subtype.tool.other', 'default', 'Other tool / tools (specify in description field)', NULL),
('en', 'dime.find.subtype.tool.textile', 'default', 'Tools for textile work', NULL),
('en', 'dime.find.subtype.tool.textile.case', 'default', 'Needle Case', NULL),
('en', 'dime.find.subtype.tool.textile.needle', 'default', 'Needle', NULL),
('en', 'dime.find.subtype.tool.textile.scissors', 'default', 'Scissors', NULL),
('en', 'dime.find.subtype.tool.textile.thimble', 'default', 'Thimble', NULL),
('en', 'dime.find.subtype.tool.textile.whorl', 'default', 'Spindle whorl', NULL);
INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'dime.find.subtype.tool.toilet', 'default', 'Toilet equipment (comb, razor, tweezers)', NULL),
('en', 'dime.find.subtype.tool.toilet.comb', 'default', 'comb', NULL),
('en', 'dime.find.subtype.tool.toilet.ear', 'default', 'Ear spoon', NULL),
('en', 'dime.find.subtype.tool.toilet.other', 'default', 'Other toilet equipment (specify in description field)', NULL),
('en', 'dime.find.subtype.tool.toilet.razor', 'default', 'razor', NULL),
('en', 'dime.find.subtype.tool.toilet.tweezers', 'default', 'Tweezers', NULL),
('en', 'dime.find.subtype.tool.toy', 'default', 'Toy / Spillerekvisiter (tin soldier, playing piece, etc.)', NULL),
('en', 'dime.find.subtype.tool.toy.counter', 'default', 'play Brik', NULL),
('en', 'dime.find.subtype.tool.toy.dice', 'default', 'Dice', NULL),
('en', 'dime.find.subtype.tool.toy.other', 'default', 'Other toys / games Prop (insert in the description field)', NULL),
('en', 'dime.find.subtype.tool.unknown', 'default', 'Unknown', ''),
('en', 'dime.find.subtype.tool.work', 'default', 'Agricultural Equipment / Tools / Crafts Article', NULL),
('en', 'dime.find.subtype.tool.work.axe', 'default', 'Axe / celt / pålstav', NULL),
('en', 'dime.find.subtype.tool.work.chisel', 'default', 'Chisel / punch', NULL),
('en', 'dime.find.subtype.tool.work.drill', 'default', 'Awl / drill', NULL),
('en', 'dime.find.subtype.tool.work.fitting', 'default', 'Fitting', NULL),
('en', 'dime.find.subtype.tool.work.hammer', 'default', 'Hammer', NULL),
('en', 'dime.find.subtype.tool.work.knife', 'default', 'Knife (blade knife, handle bracket, knife scabbard fittings, etc)', NULL),
('en', 'dime.find.subtype.tool.work.nail', 'default', 'Nail / screw / spasm', NULL),
('en', 'dime.find.subtype.tool.work.other', 'default', 'Other agricultural equipment / tools / crafts article (specify in description field)', NULL),
('en', 'dime.find.subtype.tool.work.pliars', 'default', 'Pliars', NULL),
('en', 'dime.find.subtype.tool.work.rivet', 'default', 'Rivet / clinker nail / Rivet Plate', NULL),
('en', 'dime.find.subtype.tool.work.sickle', 'default', 'Scythe / Sickle', NULL),
('en', 'dime.find.subtype.tool.writing', 'default', 'Articles - Religion and Communications', NULL),
('en', 'dime.find.subtype.tool.writing.bylamulet', 'default', 'Blyamulet', NULL),
('en', 'dime.find.subtype.tool.writing.clasp', 'default', 'Book clasp', NULL),
('en', 'dime.find.subtype.tool.writing.guldgubbe', 'default', 'Guldgubbe', NULL),
('en', 'dime.find.subtype.tool.writing.runebrev', 'default', 'Rune Letter', NULL),
('en', 'dime.find.subtype.tool.writing.seal', 'default', 'seal', NULL),
('en', 'dime.find.subtype.tool.writing.stamp', 'default', 'Seal Stamps / Signet', NULL),
('en', 'dime.find.subtype.tool.writing.stylus', 'default', 'Stylus', NULL),
('en', 'dime.find.treasure', 'default', 'Treasure', NULL),
('en', 'dime.find.type.accessory', 'default', 'Jewelery / Costume Accessories', NULL),
('en', 'dime.find.type.coin', 'default', 'Coin', NULL),
('en', 'dime.find.type.fibula', 'default', 'Fibula / Suit Buckle', NULL),
('en', 'dime.find.type.metal', 'default', 'Production Waste / Scrap Metal', NULL),
('en', 'dime.find.type.military', 'default', 'Weapons / Militaria', NULL),
('en', 'dime.find.type.tool', 'default', 'Equipment / Tools', NULL),
('en', 'dime.find.update', 'default', 'Update', ''),
('en', 'dime.find.update', 'success', 'The find was successfully updated.', ''),
('en', 'dime.find.weight', 'default', 'Weight', 'Core Property Weight'),
('en', 'dime.home', 'default', 'Home', NULL),
('en', 'dime.home', 'resource', 'home', NULL),
('en', 'dime.home.alarm', 'default', 'Notifications', NULL),
('en', 'dime.home.faq', 'default', '<dl>\\n<dt>What is DIME?</dt>\\n<dd>DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Why should I use DIME?</dt>\\n<dd>DIME allows faster processing of your finds in cooperation with the museum, and gives you an overview of your finds and collection.</dd>\\n<dd>&nbsp;</dd\\n<dt>What finds can be added to DIME? </dt>\\n<dd>All detector finds (not only Danefæ) can added to DIME.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Can others see my find locations?</dt>\\n<dd>No! Find locations and other private information are only visible for museum archaeologists and researchers with special access.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Is there a DIME app?</dt>\\n<dd>An app for recording in the field is under development.</dd>\\n</dl>', NULL),
('en', 'dime.home.hvert', 'default', 'Every year, the metal detector users across the country thousands of objects from antiquity, middelal-there and later periods. Metal objects are part of our common cultural heritage and important pieces in the history of Denmark. DIME provides information about the finds for the benefit of present and subsequent generatione', NULL),
('en', 'dime.home.welcome', 'default', 'Welcome %name%', NULL),
('en', 'dime.kommune.aabenraa', 'default', 'Aabenraa', NULL),
('en', 'dime.kommune.aabenraa', 'official', 'Aabenraa Municipality', NULL),
('en', 'dime.kommune.aalborg', 'default', 'Aalborg', NULL),
('en', 'dime.kommune.aalborg', 'official', 'Aalborg Municipality', NULL),
('en', 'dime.kommune.aero', 'default', 'Ærø', NULL),
('en', 'dime.kommune.aero', 'official', 'Ærø Municipality', NULL),
('en', 'dime.kommune.albertslund', 'default', 'Albertslund', NULL),
('en', 'dime.kommune.albertslund', 'official', 'Albertslund Municipality', NULL),
('en', 'dime.kommune.allerod', 'default', 'Allerød', NULL),
('en', 'dime.kommune.allerod', 'official', 'Allerød Municipality', NULL),
('en', 'dime.kommune.arhus', 'default', 'Århus', NULL),
('en', 'dime.kommune.arhus', 'official', 'Århus Municipality', NULL),
('en', 'dime.kommune.assens', 'default', 'Assens', NULL),
('en', 'dime.kommune.assens', 'official', 'Assens Municipality', NULL),
('en', 'dime.kommune.ballerup', 'default', 'Ballerup', NULL),
('en', 'dime.kommune.ballerup', 'official', 'Ballerup Municipality', NULL),
('en', 'dime.kommune.billund', 'default', 'Billund', NULL),
('en', 'dime.kommune.billund', 'official', 'Billund Municipality', NULL),
('en', 'dime.kommune.bornholm', 'default', 'Bornholm', NULL),
('en', 'dime.kommune.bornholm', 'official', 'Bornholms Municipality', NULL),
('en', 'dime.kommune.brondby', 'default', 'Brøndby', NULL),
('en', 'dime.kommune.brondby', 'official', 'Brøndby Municipality', NULL),
('en', 'dime.kommune.bronderslev', 'default', 'Brønderslev', NULL),
('en', 'dime.kommune.bronderslev', 'official', 'Brønderslev Municipality', NULL),
('en', 'dime.kommune.dragor', 'default', 'Dragør', NULL),
('en', 'dime.kommune.dragor', 'official', 'Dragør Municipality', NULL),
('en', 'dime.kommune.egedal', 'default', 'Egedal', NULL),
('en', 'dime.kommune.egedal', 'official', 'Egedal Municipality', NULL),
('en', 'dime.kommune.esbjerg', 'default', 'Esbjerg', NULL),
('en', 'dime.kommune.esbjerg', 'official', 'Esbjerg Municipality', NULL),
('en', 'dime.kommune.faaborgmidtfyn', 'default', 'Faaborg-Midtfyn', NULL),
('en', 'dime.kommune.faaborgmidtfyn', 'official', 'Faaborg-Midtfyn Municipality', NULL),
('en', 'dime.kommune.fano', 'default', 'Fanø', NULL),
('en', 'dime.kommune.fano', 'official', 'Fanø Municipality', NULL),
('en', 'dime.kommune.favrskov', 'default', 'Favrskov', NULL),
('en', 'dime.kommune.favrskov', 'official', 'Favrskov Municipality', NULL),
('en', 'dime.kommune.faxe', 'default', 'Faxe', NULL),
('en', 'dime.kommune.faxe', 'official', 'Faxe Municipality', NULL),
('en', 'dime.kommune.fredensborg', 'default', 'Fredensborg', NULL),
('en', 'dime.kommune.fredensborg', 'official', 'Fredensborg Municipality', NULL),
('en', 'dime.kommune.fredericia', 'default', 'Fredericia', NULL),
('en', 'dime.kommune.fredericia', 'official', 'Fredericia Municipality', NULL),
('en', 'dime.kommune.frederiksbeg', 'default', 'Frederiksbeg', NULL),
('en', 'dime.kommune.frederiksbeg', 'official', 'Frederiksberg Municipality', NULL),
('en', 'dime.kommune.frederikshavn', 'default', 'Frederikshavn', NULL),
('en', 'dime.kommune.frederikshavn', 'official', 'Frederikshavn Municipality', NULL),
('en', 'dime.kommune.frederikssund', 'default', 'Frederikssund', NULL),
('en', 'dime.kommune.frederikssund', 'official', 'Frederikssund Municipality', NULL),
('en', 'dime.kommune.fureso', 'default', 'Furesø', NULL),
('en', 'dime.kommune.fureso', 'official', 'Furesø Municipality', NULL),
('en', 'dime.kommune.gentofte', 'default', 'Gentofte', NULL),
('en', 'dime.kommune.gentofte', 'official', 'Gentofte Municipality', NULL),
('en', 'dime.kommune.gladsaxe', 'default', 'Gladsaxe', NULL),
('en', 'dime.kommune.gladsaxe', 'official', 'Gladsaxe Municipality', NULL),
('en', 'dime.kommune.glostrup', 'default', 'Glostrup', NULL),
('en', 'dime.kommune.glostrup', 'official', 'Glostrup Municipality', NULL),
('en', 'dime.kommune.greve', 'default', 'Greve', NULL),
('en', 'dime.kommune.greve', 'official', 'Greve Municipality', NULL),
('en', 'dime.kommune.gribskov', 'default', 'Gribskov', NULL),
('en', 'dime.kommune.gribskov', 'official', 'Gribskov Municipality', NULL),
('en', 'dime.kommune.guldborgsund', 'default', 'Guldborgsund', NULL),
('en', 'dime.kommune.guldborgsund', 'official', 'Guldborgsund Municipality', NULL),
('en', 'dime.kommune.haderslev', 'default', 'Haderslev', NULL),
('en', 'dime.kommune.haderslev', 'official', 'Haderslev Municipality', NULL),
('en', 'dime.kommune.halsnaes', 'default', 'Halsnæs', NULL),
('en', 'dime.kommune.halsnaes', 'official', 'Halsnæs Municipality', NULL),
('en', 'dime.kommune.hedensted', 'default', 'Hedensted', NULL),
('en', 'dime.kommune.hedensted', 'official', 'Hedensted Municipality', NULL),
('en', 'dime.kommune.helsingor', 'default', 'Helsingør', NULL),
('en', 'dime.kommune.helsingor', 'official', 'Helsingør Municipality', NULL),
('en', 'dime.kommune.herlev', 'default', 'Herlev', NULL),
('en', 'dime.kommune.herlev', 'official', 'Herlev Municipality', NULL),
('en', 'dime.kommune.herning', 'default', 'Herning', NULL),
('en', 'dime.kommune.herning', 'official', 'Herning Municipality', NULL),
('en', 'dime.kommune.hillerod', 'default', 'Hillerød', NULL),
('en', 'dime.kommune.hillerod', 'official', 'Hillerød Municipality', NULL),
('en', 'dime.kommune.hjorring', 'default', 'Hjørring', NULL),
('en', 'dime.kommune.hjorring', 'official', 'Hjørring Municipality', NULL),
('en', 'dime.kommune.hojetaastrup', 'default', 'Høje-Taastrup', NULL),
('en', 'dime.kommune.hojetaastrup', 'official', 'Høje-Taastrup Municipality', NULL),
('en', 'dime.kommune.holbaek', 'default', 'Holbæk', NULL),
('en', 'dime.kommune.holbaek', 'official', 'Holbæk Municipality', NULL),
('en', 'dime.kommune.holstebro', 'default', 'Holstebro', NULL),
('en', 'dime.kommune.holstebro', 'official', 'Holstebro Municipality', NULL),
('en', 'dime.kommune.horsens', 'default', 'Horsens', NULL),
('en', 'dime.kommune.horsens', 'official', 'Horsens Municipality', NULL),
('en', 'dime.kommune.horsholm', 'default', 'Hørsholm', NULL),
('en', 'dime.kommune.horsholm', 'official', 'Hørsholm Municipality', NULL),
('en', 'dime.kommune.hvidovre', 'default', 'Hvidovre', NULL),
('en', 'dime.kommune.hvidovre', 'official', 'Hvidovre Municipality', NULL),
('en', 'dime.kommune.ikastbrande', 'default', 'Ikast-Brande', NULL),
('en', 'dime.kommune.ikastbrande', 'official', 'Ikast-Brande Municipality', NULL),
('en', 'dime.kommune.ishoj', 'default', 'Ishøj', NULL),
('en', 'dime.kommune.ishoj', 'official', 'Ishøj Municipality', NULL),
('en', 'dime.kommune.jammerbugt', 'default', 'Jammerbugt', NULL),
('en', 'dime.kommune.jammerbugt', 'official', 'Jammerbugt Municipality', NULL),
('en', 'dime.kommune.kalundborg', 'default', 'Kalundborg', NULL),
('en', 'dime.kommune.kalundborg', 'official', 'Kalundborg Municipality', NULL),
('en', 'dime.kommune.kerteminde', 'default', 'Kerteminde', NULL),
('en', 'dime.kommune.kerteminde', 'official', 'Kerteminde Municipality', NULL),
('en', 'dime.kommune.kobenhavn', 'default', 'Copenhagen', NULL),
('en', 'dime.kommune.kobenhavn', 'official', 'Copenhagen Municipality', NULL),
('en', 'dime.kommune.koge', 'default', 'Køge', NULL),
('en', 'dime.kommune.koge', 'official', 'Køge Municipality', NULL),
('en', 'dime.kommune.kolding', 'default', 'Kolding', NULL),
('en', 'dime.kommune.kolding', 'official', 'Kolding Municipality', NULL),
('en', 'dime.kommune.laeso', 'default', 'Læsø', NULL),
('en', 'dime.kommune.laeso', 'official', 'Læsø Municipality', NULL),
('en', 'dime.kommune.langeland', 'default', 'Langeland', NULL),
('en', 'dime.kommune.langeland', 'official', 'Langeland Municipality', NULL),
('en', 'dime.kommune.lejre', 'default', 'Lejre', NULL),
('en', 'dime.kommune.lejre', 'official', 'Lejre Municipality', NULL),
('en', 'dime.kommune.lemvig', 'default', 'Lemvig', NULL),
('en', 'dime.kommune.lemvig', 'official', 'Lemvig Municipality', NULL),
('en', 'dime.kommune.lolland', 'default', 'Lolland', NULL),
('en', 'dime.kommune.lolland', 'official', 'Lolland Municipality', NULL),
('en', 'dime.kommune.lyngbytaarbaek', 'default', 'Lyngby-Taarbæk', NULL),
('en', 'dime.kommune.lyngbytaarbaek', 'official', 'Lyngby-Taarbæk Municipality', NULL),
('en', 'dime.kommune.mariagerfjord', 'default', 'Mariagerfjord', NULL),
('en', 'dime.kommune.mariagerfjord', 'official', 'Mariagerfjord Municipality', NULL),
('en', 'dime.kommune.middelfart', 'default', 'Middelfart', NULL),
('en', 'dime.kommune.middelfart', 'official', 'Middelfart Municipality', NULL),
('en', 'dime.kommune.morso', 'default', 'Morsø', NULL),
('en', 'dime.kommune.morso', 'official', 'Morsø Municipality', NULL),
('en', 'dime.kommune.naestved', 'default', 'Næstved', NULL),
('en', 'dime.kommune.naestved', 'official', 'Næstved Municipality', NULL),
('en', 'dime.kommune.norddjurs', 'default', 'Norddjurs', NULL),
('en', 'dime.kommune.norddjurs', 'official', 'Norddjurs Municipality', NULL),
('en', 'dime.kommune.nordfyns', 'default', 'Nordfyns', NULL),
('en', 'dime.kommune.nordfyns', 'official', 'Nordfyns Municipality', NULL),
('en', 'dime.kommune.nyborg', 'default', 'Nyborg', NULL),
('en', 'dime.kommune.nyborg', 'official', 'Nyborg Municipality', NULL),
('en', 'dime.kommune.odder', 'default', 'Odder', NULL),
('en', 'dime.kommune.odder', 'official', 'Odder Municipality', NULL),
('en', 'dime.kommune.odense', 'default', 'Odense', NULL),
('en', 'dime.kommune.odense', 'official', 'Odense Municipality', NULL),
('en', 'dime.kommune.odsherred', 'default', 'Odsherred', NULL),
('en', 'dime.kommune.odsherred', 'official', 'Odsherred Municipality', NULL),
('en', 'dime.kommune.randers', 'default', 'Randers', NULL),
('en', 'dime.kommune.randers', 'official', 'Randers Municipality', NULL),
('en', 'dime.kommune.rebild', 'default', 'Rebild', NULL),
('en', 'dime.kommune.rebild', 'official', 'Rebild Municipality', NULL),
('en', 'dime.kommune.ringkobingskjern', 'default', 'Ringkøbing-Skjern', NULL),
('en', 'dime.kommune.ringkobingskjern', 'official', 'Ringkøbing-Skjern Municipality', NULL),
('en', 'dime.kommune.ringsted', 'default', 'Ringsted', NULL),
('en', 'dime.kommune.ringsted', 'official', 'Ringsted Municipality', NULL),
('en', 'dime.kommune.rodovre', 'default', 'Rødovre', NULL),
('en', 'dime.kommune.rodovre', 'official', 'Rødovre Municipality', NULL),
('en', 'dime.kommune.roskilde', 'default', 'Roskilde', NULL),
('en', 'dime.kommune.roskilde', 'official', 'Roskilde Municipality', NULL),
('en', 'dime.kommune.rudersdal', 'default', 'Rudersdal', NULL),
('en', 'dime.kommune.rudersdal', 'official', 'Rudersdal Municipality', NULL),
('en', 'dime.kommune.samso', 'default', 'Samsø', NULL),
('en', 'dime.kommune.samso', 'official', 'Samsø Municipality', NULL),
('en', 'dime.kommune.silkeborg', 'default', 'Silkeborg', NULL),
('en', 'dime.kommune.silkeborg', 'official', 'Silkeborg Municipality', NULL),
('en', 'dime.kommune.skanderborg', 'default', 'Skanderborg', NULL),
('en', 'dime.kommune.skanderborg', 'official', 'Skanderborg Municipality', NULL),
('en', 'dime.kommune.skive', 'default', 'Skive', NULL),
('en', 'dime.kommune.skive', 'official', 'Skive Municipality', NULL),
('en', 'dime.kommune.slagelse', 'default', 'Slagelse', NULL),
('en', 'dime.kommune.slagelse', 'official', 'Slagelse Municipality', NULL),
('en', 'dime.kommune.solrod', 'default', 'Solrød', NULL),
('en', 'dime.kommune.solrod', 'official', 'Solrød Municipality', NULL),
('en', 'dime.kommune.sonderborg', 'default', 'Sønderborg', NULL),
('en', 'dime.kommune.sonderborg', 'official', 'Sønderborg Municipality', NULL),
('en', 'dime.kommune.soro', 'default', 'Sorø', NULL),
('en', 'dime.kommune.soro', 'official', 'Sorø Municipality', NULL),
('en', 'dime.kommune.stevns', 'default', 'Stevns', NULL),
('en', 'dime.kommune.stevns', 'official', 'Stevns Municipality', NULL),
('en', 'dime.kommune.struer', 'default', 'Struer', NULL),
('en', 'dime.kommune.struer', 'official', 'Struer Municipality', NULL),
('en', 'dime.kommune.svendborg', 'default', 'Svendborg', NULL),
('en', 'dime.kommune.svendborg', 'official', 'Svendborg Municipality', NULL),
('en', 'dime.kommune.syddjurs', 'default', 'Syddjurs', NULL),
('en', 'dime.kommune.syddjurs', 'official', 'Syddjurs Municipality', NULL),
('en', 'dime.kommune.tarnby', 'default', 'Tårnby', NULL),
('en', 'dime.kommune.tarnby', 'official', 'Tårnby Municipality', NULL),
('en', 'dime.kommune.thisted', 'default', 'Thisted', NULL),
('en', 'dime.kommune.thisted', 'official', 'Thisted Municipality', NULL),
('en', 'dime.kommune.tonder', 'default', 'Tønder', NULL),
('en', 'dime.kommune.tonder', 'official', 'Tønder Municipality', NULL),
('en', 'dime.kommune.vallensbaek', 'default', 'Vallensbæk', NULL),
('en', 'dime.kommune.vallensbaek', 'official', 'Vallensbæk Municipality', NULL),
('en', 'dime.kommune.varde', 'default', 'Varde', NULL),
('en', 'dime.kommune.varde', 'official', 'Varde Municipality', NULL),
('en', 'dime.kommune.vejen', 'default', 'Vejen', NULL),
('en', 'dime.kommune.vejen', 'official', 'Vejen Municipality', NULL),
('en', 'dime.kommune.vejle', 'default', 'Vejle', NULL),
('en', 'dime.kommune.vejle', 'official', 'Vejle Municipality', NULL),
('en', 'dime.kommune.vesthimmerland', 'default', 'Vesthimmerland', NULL),
('en', 'dime.kommune.vesthimmerland', 'official', 'Vesthimmerlands Municipality', NULL),
('en', 'dime.kommune.viborg', 'default', 'Viborg', NULL),
('en', 'dime.kommune.viborg', 'official', 'Viborg Municipality', NULL),
('en', 'dime.kommune.vordingborg', 'default', 'Vordingborg', NULL),
('en', 'dime.kommune.vordingborg', 'official', 'Vordingborg Municipality', NULL),
('en', 'dime.krogager', 'default', 'KrogagerFonden', NULL),
('en', 'dime.map.layer.foraar', 'default', 'Foraar Layer', NULL),
('en', 'dime.map.layer.skaermkort', 'default', 'Skaermkort', NULL),
('en', 'dime.material', 'default', 'DIME Material', ''),
('en', 'dime.material.aluminium', 'default', 'Aluminium', NULL),
('en', 'dime.material.ceramic', 'default', 'Ceramic', ''),
('en', 'dime.material.copper', 'default', 'Copper', NULL),
('en', 'dime.material.copperalloy', 'default', 'Copper Alloy', NULL),
('en', 'dime.material.glass', 'default', 'Glass', ''),
('en', 'dime.material.gold', 'default', 'Gold', NULL),
('en', 'dime.material.iron', 'default', 'Iron', NULL),
('en', 'dime.material.lead', 'default', 'Lead', NULL),
('en', 'dime.material.othermetal', 'default', 'Other Metal', NULL),
('en', 'dime.material.silver', 'default', 'Silver', NULL),
('en', 'dime.material.stone', 'default', 'Stone', ''),
('en', 'dime.material.tin', 'default', 'Tin', NULL),
('en', 'dime.metaldetector', 'default', 'Metal Detecting In Denmark', NULL),
('en', 'dime.news', 'default', 'News', NULL),
('en', 'dime.news', 'resource', 'news', NULL),
('en', 'dime.period', 'default', 'Period', NULL),
('en', 'dime.period.absolutism', 'default', 'Absolutism', NULL),
('en', 'dime.period.bronze', 'default', 'Bronze Age', NULL),
('en', 'dime.period.bronze.1', 'default', 'Bronze Age Period 1', NULL),
('en', 'dime.period.bronze.2', 'default', 'Bronze Age Period 2', NULL),
('en', 'dime.period.bronze.3', 'default', 'Bronze Age Period 3', NULL),
('en', 'dime.period.bronze.4', 'default', 'Bronze Age Period 4', NULL),
('en', 'dime.period.bronze.5', 'default', 'Bronze Age Period 5', NULL),
('en', 'dime.period.bronze.6', 'default', 'Bronze Age Period 6', NULL),
('en', 'dime.period.bronze.early', 'default', 'Early Bronze Age', NULL),
('en', 'dime.period.bronze.late', 'default', 'Late Bronze Age', NULL),
('en', 'dime.period.historic', 'default', 'Historic Age', NULL),
('en', 'dime.period.industrial', 'default', 'Industrial Age', NULL),
('en', 'dime.period.interwar', 'default', 'Interwar Years', NULL),
('en', 'dime.period.iron', 'default', 'Iron Age', NULL),
('en', 'dime.period.iron.early', 'default', 'Early Iron Age', NULL),
('en', 'dime.period.iron.germainic', 'default', 'Germanic Iron Age', NULL),
('en', 'dime.period.iron.germainic.early', 'default', 'Early Germanic Iron Age', NULL),
('en', 'dime.period.iron.germainic.late', 'default', 'Late Germanic Iron Age', NULL),
('en', 'dime.period.iron.late', 'default', 'Late Iron Age', NULL),
('en', 'dime.period.iron.preroman', 'default', 'Pre-Roman Iron Age', NULL),
('en', 'dime.period.iron.preroman.early', 'default', 'Early Pre-Roman Iron Age', NULL),
('en', 'dime.period.iron.preroman.late', 'default', 'Late Pre-Roman Iron Age', NULL),
('en', 'dime.period.iron.preroman.middle', 'default', 'Middle Pre-Roman Iron Age', NULL),
('en', 'dime.period.iron.roman', 'default', 'Roman Iron Age', NULL),
('en', 'dime.period.iron.roman.early', 'default', 'Early Roman Iron Age', NULL),
('en', 'dime.period.iron.roman.early.b1', 'default', 'Early Roman Iron Age B1', NULL),
('en', 'dime.period.iron.roman.early.b2', 'default', 'Early Roman Iron Age B2', NULL),
('en', 'dime.period.iron.roman.late', 'default', 'Late Roman Iron Age', NULL),
('en', 'dime.period.iron.roman.late.c1', 'default', 'Late Roman Iron Age C1', NULL),
('en', 'dime.period.iron.roman.late.c2', 'default', 'Late Roman Iron Age C2', NULL),
('en', 'dime.period.iron.roman.late.c3', 'default', 'Late Roman Iron Age C3', NULL),
('en', 'dime.period.medieval', 'default', 'Medieval', NULL),
('en', 'dime.period.medieval.early', 'default', 'Early Medieval', NULL),
('en', 'dime.period.medieval.high', 'default', 'High Medieval', NULL),
('en', 'dime.period.medieval.late', 'default', 'Late Medieval', NULL),
('en', 'dime.period.mesolithic', 'default', 'Mesolithic', NULL),
('en', 'dime.period.modern', 'default', 'Modern Age', NULL),
('en', 'dime.period.neolithic', 'default', 'Neolithic', NULL),
('en', 'dime.period.palaeolithic', 'default', 'Palaeolithic', NULL),
('en', 'dime.period.prehistoric', 'default', 'Prehistoric', ''),
('en', 'dime.period.reformation', 'default', 'Reformation', NULL),
('en', 'dime.period.stone', 'default', 'Stone Age', NULL),
('en', 'dime.period.undated', 'default', 'Undated', NULL),
('en', 'dime.period.viking', 'default', 'Viking Age', NULL),
('en', 'dime.period.viking.early', 'default', 'Early Viking Age', NULL),
('en', 'dime.period.viking.late', 'default', 'Late Viking Age', NULL),
('en', 'dime.period.viking.medieval', 'default', 'Viking / Early Medieval ', NULL),
('en', 'dime.period.welfare', 'default', 'Welfare Age', NULL),
('en', 'dime.period.ww1', 'default', 'First World War', NULL),
('en', 'dime.period.ww2', 'default', 'Second World War', NULL),
('en', 'dime.profile', 'default', 'Profile', ''),
('en', 'dime.profile', 'resource', 'profile', ''),
('en', 'dime.profiles', 'resource', 'profiles', ''),
('en', 'dime.region.hovedstaden', 'default', 'Capital', NULL),
('en', 'dime.region.hovedstaden', 'official', 'Capital Region', NULL),
('en', 'dime.region.midtjylland', 'default', 'Central', NULL),
('en', 'dime.region.midtjylland', 'official', 'Central Region', NULL),
('en', 'dime.region.nordjylland', 'default', 'North', NULL),
('en', 'dime.region.nordjylland', 'official', 'North Region', NULL),
('en', 'dime.region.sjaelland', 'default', 'Zealand', NULL),
('en', 'dime.region.sjaelland', 'official', 'Zealand Region', NULL),
('en', 'dime.region.syddanmark', 'default', 'South', NULL),
('en', 'dime.region.syddanmark', 'official', 'South Region', NULL),
('en', 'dime.register.contact', 'default', 'Er du ansat ved et museum og vil have adgang til DIME museumsmodul til registrering af detektorfund kontakt admin: XXXXXXMuseum access to DIME. If you are you employed at a museum and need access to DIME please contact the administrator: XXXXXX', ''),
('en', 'dime.register.faq', 'default', 'FAQ', ''),
('en', 'dime.research', 'default', 'Research', NULL),
('en', 'dime.research', 'resource', 'research', NULL),
('en', 'dime.role.admin', 'default', 'Administrator', ''),
('en', 'dime.role.anon', 'default', 'Anonymous', ''),
('en', 'dime.role.appraiser', 'default', 'Appraiser', ''),
('en', 'dime.role.curator', 'default', 'Curator', ''),
('en', 'dime.role.detectorist', 'default', 'Detectorist', ''),
('en', 'dime.role.registrar', 'default', 'Registrar', ''),
('en', 'dime.role.researcher', 'default', 'Researcher', ''),
('en', 'dime.save', 'default', 'Save', NULL),
('en', 'dime.schema.find', 'default', 'Find', NULL),
('en', 'dime.schema.image', 'default', 'Image', NULL),
('en', 'dime.schema.location', 'default', 'Location', NULL),
('en', 'dime.search', 'default', 'Search', NULL),
('en', 'dime.search.finds.mine', 'default', 'My Finds', NULL),
('en', 'dime.supportedby', 'default', 'supported by', NULL),
('en', 'dime.treasure', 'default', 'Treasure Trove', NULL),
('en', 'dime.treasure', 'resource', 'treasure', NULL),
('en', 'dime.treasure.appraisal', 'default', 'Under Appraisal', NULL),
('en', 'dime.treasure.not', 'default', 'Not Treasure Trove', NULL),
('en', 'dime.treasure.pending', 'default', 'Pending Assessment', NULL),
('en', 'dime.treasure.treasure', 'default', 'Treasure Trove', NULL),
('en', 'dime.user.actor.museum', 'default', 'Associated Museum', ''),
('en', 'dime.user.detectorist.id', 'default', 'Detectorist ID', ''),
('en', 'dime.user.login', 'default', 'Login', NULL),
('en', 'dime.user.name', 'default', 'User Name', NULL),
('en', 'dime.user.password', 'default', 'Password', NULL),
('en', 'dime.user.password.forgot', 'default', 'Forgotten Password?', NULL),
('en', 'dime.user.profile', 'default', 'Profile', ''),
('en', 'dime.user.register', 'default', 'New User?', NULL),
('en', 'dime.user.register', 'success', 'Your DIME registration has been successful. You will shortly receive an email with a link to verify your account and enable full access. Until your account is verified you will only be able to record finds and not submit them for Danefae assessment.', ''),
('en', 'dime.user.terms', 'default', 'Terms and Conditions', ''),
('en', 'dime.user.terms.v1', 'default', '<H2>Terms and Conditions</H2><P>v1.0 dated 1 June 2017</P><P>Lorem Ipsem...</P>', ''),
('en', 'dime.user.update', 'success', 'User successfully updated.', ''),
('en', 'file.type.audio', 'default', 'Audio File', NULL),
('en', 'file.type.document', 'default', 'Document File', NULL),
('en', 'file.type.image', 'default', 'Image File', NULL),
('en', 'file.type.other', 'default', 'Other File', NULL),
('en', 'find.gotofind', 'default', 'View Find Record', NULL),
('en', 'form.select.optional', 'default', 'optional', NULL),
('en', 'form.select.required', 'default', 'required', NULL),
('en', 'format.address', 'default', 'Address Format', NULL),
('en', 'format.blob', 'default', 'Blob Format', NULL),
('en', 'format.boolean', 'default', 'Boolean Format', NULL),
('en', 'format.colour', 'default', 'Colour Format', NULL),
('en', 'format.date', 'default', 'Date Format', NULL),
('en', 'format.datetime', 'default', 'DateTime Format', NULL),
('en', 'format.decimal', 'default', 'Decimal Format', NULL),
('en', 'format.email', 'default', 'Email Format', NULL),
('en', 'format.float', 'default', 'Float Format', NULL),
('en', 'format.html', 'default', 'HTML Format', NULL),
('en', 'format.identifier', 'default', 'Identifier Format', NULL),
('en', 'format.integer', 'default', 'Integer Format', NULL),
('en', 'format.item', 'default', 'Item Format', NULL),
('en', 'format.key', 'default', 'Key Format', NULL),
('en', 'format.markdown', 'default', 'Markdown Format', NULL),
('en', 'format.module', 'default', 'Module Format', NULL),
('en', 'format.money', 'default', 'Money Format', NULL),
('en', 'format.ordinaldate', 'default', 'Ordinal Date Format', NULL),
('en', 'format.password', 'default', 'Password', NULL),
('en', 'format.percent', 'default', 'Percent', NULL),
('en', 'format.richtext', 'default', 'Rich Text', NULL),
('en', 'format.search', 'default', 'Search Format', NULL),
('en', 'format.shorttext', 'default', 'Short Text  Format', NULL),
('en', 'format.string', 'default', 'String Format', NULL),
('en', 'format.telephone', 'default', 'Telephone Format', NULL),
('en', 'format.text', 'default', 'Text Format', NULL),
('en', 'format.time', 'default', 'Time Format', NULL),
('en', 'format.url', 'default', 'URL Format', NULL),
('en', 'format.weekdate', 'default', 'Week Date Format', NULL),
('en', 'format.yearmonth', 'default', 'Year Month Format', NULL),
('en', 'format.yearweek', 'default', 'Year Week Format', NULL),
('en', 'fragment.blob', 'default', 'Blob Fragment', NULL),
('en', 'fragment.boolean', 'default', 'Boolean Fragment', NULL),
('en', 'fragment.date', 'default', 'Date Fragment', NULL),
('en', 'fragment.datetime', 'default', 'DateTime Fragment', NULL),
('en', 'fragment.decimal', 'default', 'Decimal Fragment', NULL),
('en', 'fragment.float', 'default', 'Float Fragment', NULL),
('en', 'fragment.geometry', 'default', 'Geometry Fragment', NULL),
('en', 'fragment.integer', 'default', 'Integer Fragment', NULL),
('en', 'fragment.item', 'default', 'Item Fragment', NULL),
('en', 'fragment.object', 'default', 'Object Fragment', NULL),
('en', 'fragment.string', 'default', 'String Fragment', NULL),
('en', 'fragment.text', 'default', 'Text Fragment', NULL),
('en', 'fragment.time', 'default', 'Time Fragment', NULL),
('en', 'language.abkhazian', 'default', 'Abkhazian', NULL),
('en', 'language.achinese', 'default', 'Achinese', NULL),
('en', 'language.acoli', 'default', 'Acoli', NULL),
('en', 'language.adangme', 'default', 'Adangme', NULL),
('en', 'language.adyghe', 'default', 'Adyghe', NULL),
('en', 'language.afar', 'default', 'Afar', NULL),
('en', 'language.afrihili', 'default', 'Afrihili', NULL),
('en', 'language.afrikaans', 'default', 'Afrikaans', NULL),
('en', 'language.aghem', 'default', 'Aghem', NULL),
('en', 'language.ainu', 'default', 'Ainu', NULL),
('en', 'language.akan', 'default', 'Akan', NULL),
('en', 'language.akkadian', 'default', 'Akkadian', NULL),
('en', 'language.akoose', 'default', 'Akoose', NULL),
('en', 'language.alabama', 'default', 'Alabama', NULL),
('en', 'language.albanian', 'default', 'Albanian', NULL),
('en', 'language.albanian.gheg', 'default', 'Gheg Albanian', NULL),
('en', 'language.aleut', 'default', 'Aleut', NULL),
('en', 'language.altai.southern', 'default', 'Southern Altai', NULL),
('en', 'language.amharic', 'default', 'Amharic', NULL),
('en', 'language.angika', 'default', 'Angika', NULL),
('en', 'language.aonaga', 'default', 'Ao Naga', NULL),
('en', 'language.arabic', 'default', 'Arabic', NULL),
('en', 'language.arabic.algerian', 'default', 'Algerian Arabic', NULL),
('en', 'language.arabic.chadian', 'default', 'Chadian Arabic', NULL),
('en', 'language.arabic.egyptian', 'default', 'Egyptian Arabic', NULL),
('en', 'language.arabic.modern', 'default', 'Modern Standard Arabic', NULL),
('en', 'language.arabic.moroccan', 'default', 'Moroccan Arabic', NULL),
('en', 'language.arabic.tunisian', 'default', 'Tunisian Arabic', NULL),
('en', 'language.aragonese', 'default', 'Aragonese', NULL),
('en', 'language.aramaic', 'default', 'Aramaic', NULL),
('en', 'language.aramaic.samaritan', 'default', 'Samaritan Aramaic', NULL),
('en', 'language.araona', 'default', 'Araona', NULL),
('en', 'language.arapaho', 'default', 'Arapaho', NULL),
('en', 'language.arawak', 'default', 'Arawak', NULL),
('en', 'language.armenian', 'default', 'Armenian', NULL),
('en', 'language.aromanian', 'default', 'Aromanian', NULL),
('en', 'language.arpitan', 'default', 'Arpitan', NULL),
('en', 'language.assamese', 'default', 'Assamese', NULL),
('en', 'language.asturian', 'default', 'Asturian', NULL),
('en', 'language.asu', 'default', 'Asu', NULL),
('en', 'language.atsam', 'default', 'Atsam', NULL),
('en', 'language.avaric', 'default', 'Avaric', NULL),
('en', 'language.avestan', 'default', 'Avestan', NULL),
('en', 'language.awadhi', 'default', 'Awadhi', NULL),
('en', 'language.aymara', 'default', 'Aymara', NULL),
('en', 'language.azerbaijani', 'default', 'Azerbaijani', NULL),
('en', 'language.badaga', 'default', 'Badaga', NULL),
('en', 'language.bafia', 'default', 'Bafia', NULL),
('en', 'language.bafut', 'default', 'Bafut', NULL),
('en', 'language.bakhtiari', 'default', 'Bakhtiari', NULL),
('en', 'language.balinese', 'default', 'Balinese', NULL),
('en', 'language.balochi.western', 'default', 'Western Balochi', NULL),
('en', 'language.baluchi', 'default', 'Baluchi', NULL),
('en', 'language.bambara', 'default', 'Bambara', NULL),
('en', 'language.bamun', 'default', 'Bamun', NULL),
('en', 'language.banjar', 'default', 'Banjar', NULL),
('en', 'language.basaa', 'default', 'Basaa', NULL),
('en', 'language.bashkir', 'default', 'Bashkir', NULL),
('en', 'language.basque', 'default', 'Basque', NULL),
('en', 'language.bataktoba', 'default', 'Batak Toba', NULL),
('en', 'language.bavarian', 'default', 'Bavarian', NULL),
('en', 'language.beja', 'default', 'Beja', NULL),
('en', 'language.belarusian', 'default', 'Belarusian', NULL),
('en', 'language.bemba', 'default', 'Bemba', NULL),
('en', 'language.bena', 'default', 'Bena', NULL),
('en', 'language.bengali', 'default', 'Bengali', NULL),
('en', 'language.betawi', 'default', 'Betawi', NULL),
('en', 'language.bhojpuri', 'default', 'Bhojpuri', NULL),
('en', 'language.bikol', 'default', 'Bikol', NULL),
('en', 'language.bini', 'default', 'Bini', NULL),
('en', 'language.bishnupriya', 'default', 'Bishnupriya', NULL),
('en', 'language.bislama', 'default', 'Bislama', NULL),
('en', 'language.blin', 'default', 'Blin', NULL),
('en', 'language.blissymbols', 'default', 'Blissymbols', NULL),
('en', 'language.bodo', 'default', 'Bodo', NULL),
('en', 'language.bosnian', 'default', 'Bosnian', NULL),
('en', 'language.brahui', 'default', 'Brahui', NULL),
('en', 'language.braj', 'default', 'Braj', NULL),
('en', 'language.breton', 'default', 'Breton', NULL),
('en', 'language.buginese', 'default', 'Buginese', NULL),
('en', 'language.bulgarian', 'default', 'Bulgarian', NULL),
('en', 'language.bulu', 'default', 'Bulu', NULL),
('en', 'language.buriat', 'default', 'Buriat', NULL),
('en', 'language.burmese', 'default', 'Burmese', NULL),
('en', 'language.caddo', 'default', 'Caddo', NULL),
('en', 'language.cantonese', 'default', 'Cantonese', NULL),
('en', 'language.capiznon', 'default', 'Capiznon', NULL),
('en', 'language.carib', 'default', 'Carib', NULL),
('en', 'language.catalan', 'default', 'Catalan', NULL),
('en', 'language.cayuga', 'default', 'Cayuga', NULL),
('en', 'language.cebuano', 'default', 'Cebuano', NULL),
('en', 'language.chagatai', 'default', 'Chagatai', NULL),
('en', 'language.chamorro', 'default', 'Chamorro', NULL),
('en', 'language.chechen', 'default', 'Chechen', NULL),
('en', 'language.cherokee', 'default', 'Cherokee', NULL),
('en', 'language.cheyenne', 'default', 'Cheyenne', NULL),
('en', 'language.chibcha', 'default', 'Chibcha', NULL),
('en', 'language.chiga', 'default', 'Chiga', NULL),
('en', 'language.chiini.koyra', 'default', 'Koyra Chiini', NULL),
('en', 'language.chinese', 'default', 'Chinese', NULL),
('en', 'language.chinese.gan', 'default', 'Gan Chinese', NULL),
('en', 'language.chinese.hakka', 'default', 'Hakka Chinese', NULL),
('en', 'language.chinese.literary', 'default', 'Literary Chinese', NULL),
('en', 'language.chinese.minnan', 'default', 'Min Nan Chinese', NULL),
('en', 'language.chinese.simplified', 'default', 'Simplified Chinese', NULL),
('en', 'language.chinese.traditional', 'default', 'Traditional Chinese', NULL),
('en', 'language.chinese.wu', 'default', 'Wu Chinese', NULL),
('en', 'language.chinese.xiang', 'default', 'Xiang Chinese', NULL),
('en', 'language.chipewyan', 'default', 'Chipewyan', NULL),
('en', 'language.choctaw', 'default', 'Choctaw', NULL),
('en', 'language.chuukese', 'default', 'Chuukese', NULL),
('en', 'language.chuvash', 'default', 'Chuvash', NULL),
('en', 'language.colognian', 'default', 'Colognian', NULL),
('en', 'language.comorian', 'default', 'Comorian', NULL),
('en', 'language.coptic', 'default', 'Coptic', NULL),
('en', 'language.cornish', 'default', 'Cornish', NULL),
('en', 'language.corsican', 'default', 'Corsican', NULL),
('en', 'language.cree', 'default', 'Cree', NULL),
('en', 'language.creek', 'default', 'Creek', NULL),
('en', 'language.creole.haitian', 'default', 'Haitian Creole', NULL),
('en', 'language.croatian', 'default', 'Croatian', NULL),
('en', 'language.czech', 'default', 'Czech', NULL),
('en', 'language.dakota', 'default', 'Dakota', NULL),
('en', 'language.danish', 'default', 'Danish', NULL),
('en', 'language.dargwa', 'default', 'Dargwa', NULL),
('en', 'language.dari.zoroastrian', 'default', 'Zoroastrian Dari', NULL),
('en', 'language.dazaga', 'default', 'Dazaga', NULL),
('en', 'language.delaware', 'default', 'Delaware', NULL),
('en', 'language.dinka', 'default', 'Dinka', NULL),
('en', 'language.divehi', 'default', 'Divehi', NULL),
('en', 'language.dogri', 'default', 'Dogri', NULL),
('en', 'language.dogrib', 'default', 'Dogrib', NULL),
('en', 'language.duala', 'default', 'Duala', NULL),
('en', 'language.dusun.central', 'default', 'Central Dusun', NULL),
('en', 'language.dutch', 'default', 'Dutch', NULL),
('en', 'language.dutch.middle', 'default', 'Middle Dutch', NULL),
('en', 'language.dyula', 'default', 'Dyula', NULL),
('en', 'language.dzongkha', 'default', 'Dzongkha', NULL),
('en', 'language.efik', 'default', 'Efik', NULL),
('en', 'language.egyptian.ancient', 'default', 'Ancient Egyptian', NULL),
('en', 'language.ekajuk', 'default', 'Ekajuk', NULL),
('en', 'language.elamite', 'default', 'Elamite', NULL),
('en', 'language.embu', 'default', 'Embu', NULL),
('en', 'language.emilian', 'default', 'Emilian', NULL),
('en', 'language.english', 'default', 'English', NULL),
('en', 'language.english.american', 'default', 'American English', NULL),
('en', 'language.english.australian', 'default', 'Australian English', NULL),
('en', 'language.english.british', 'default', 'British English', NULL),
('en', 'language.english.canadian', 'default', 'Canadian English', NULL),
('en', 'language.english.jamaicancreole ', 'default', 'Jamaican Creole English', NULL),
('en', 'language.english.middle', 'default', 'Middle English', NULL),
('en', 'language.english.old', 'default', 'Old English', NULL),
('en', 'language.erzya', 'default', 'Erzya', NULL),
('en', 'language.esperanto', 'default', 'Esperanto', NULL),
('en', 'language.estonian', 'default', 'Estonian', NULL),
('en', 'language.ewe', 'default', 'Ewe', NULL),
('en', 'language.ewondo', 'default', 'Ewondo', NULL),
('en', 'language.extremaduran', 'default', 'Extremaduran', NULL),
('en', 'language.fang', 'default', 'Fang', NULL),
('en', 'language.fanti', 'default', 'Fanti', NULL),
('en', 'language.faroese', 'default', 'Faroese', NULL),
('en', 'language.fijian', 'default', 'Fijian', NULL),
('en', 'language.filipino', 'default', 'Filipino', NULL),
('en', 'language.finnish', 'default', 'Finnish', NULL),
('en', 'language.finnish.tornedalen', 'default', 'Tornedalen Finnish', NULL),
('en', 'language.flemish', 'default', 'Flemish', NULL),
('en', 'language.flemish.west', 'default', 'West Flemish', NULL),
('en', 'language.fon', 'default', 'Fon', NULL),
('en', 'language.frafra', 'default', 'Frafra', NULL),
('en', 'language.franconian.main', 'default', 'Main-Franconian', NULL),
('en', 'language.french', 'default', 'French', NULL),
('en', 'language.french.cajun', 'default', 'Cajun French', NULL),
('en', 'language.french.canadian', 'default', 'Canadian French', NULL),
('en', 'language.french.middle', 'default', 'Middle French', NULL),
('en', 'language.french.old', 'default', 'Old French', NULL),
('en', 'language.french.swiss', 'default', 'Swiss French', NULL),
('en', 'language.frisian.eastern', 'default', 'Eastern Frisian', NULL),
('en', 'language.frisian.northern', 'default', 'Northern Frisian', NULL),
('en', 'language.frisian.saterland', 'default', 'Saterland Frisian', NULL),
('en', 'language.frisian.western', 'default', 'Western Frisian', NULL),
('en', 'language.friulian', 'default', 'Friulian', NULL),
('en', 'language.fulah', 'default', 'Fulah', NULL),
('en', 'language.ga', 'default', 'Ga', NULL),
('en', 'language.gaelic.scottish', 'default', 'Scottish Gaelic', NULL),
('en', 'language.gagauz', 'default', 'Gagauz', NULL),
('en', 'language.galician', 'default', 'Galician', NULL),
('en', 'language.ganda', 'default', 'Ganda', NULL),
('en', 'language.gayo', 'default', 'Gayo', NULL),
('en', 'language.gbaya', 'default', 'Gbaya', NULL),
('en', 'language.geez', 'default', 'Geez', NULL),
('en', 'language.georgian', 'default', 'Georgian', NULL),
('en', 'language.german', 'default', 'German', NULL),
('en', 'language.german.austrian', 'default', 'Austrian German', NULL),
('en', 'language.german.low', 'default', 'Low German', NULL),
('en', 'language.german.middlehigh', 'default', 'Middle High German', NULL),
('en', 'language.german.oldhigh', 'default', 'Old High German', NULL),
('en', 'language.german.palatine', 'default', 'Palatine German', NULL),
('en', 'language.german.pennsylvania', 'default', 'Pennsylvania German', NULL),
('en', 'language.german.swiss', 'default', 'Swiss German', NULL),
('en', 'language.german.swisshigh', 'default', 'Swiss High German', NULL),
('en', 'language.ghomala', 'default', 'Ghomala', NULL),
('en', 'language.gilaki', 'default', 'Gilaki', NULL),
('en', 'language.gilbertese', 'default', 'Gilbertese', NULL),
('en', 'language.gondi', 'default', 'Gondi', NULL),
('en', 'language.gorontalo', 'default', 'Gorontalo', NULL),
('en', 'language.gothic', 'default', 'Gothic', NULL),
('en', 'language.grebo', 'default', 'Grebo', NULL),
('en', 'language.greek', 'default', 'Greek', NULL),
('en', 'language.greek.ancient', 'default', 'Ancient Greek', NULL),
('en', 'language.guarani', 'default', 'Guarani', NULL),
('en', 'language.gujarati', 'default', 'Gujarati', NULL),
('en', 'language.gusii', 'default', 'Gusii', NULL),
('en', 'language.gwichin', 'default', 'Gwichʼin', NULL),
('en', 'language.haida', 'default', 'Haida', NULL),
('en', 'language.hausa', 'default', 'Hausa', NULL),
('en', 'language.hawaiian', 'default', 'Hawaiian', NULL),
('en', 'language.hebrew', 'default', 'Hebrew', NULL),
('en', 'language.herero', 'default', 'Herero', NULL),
('en', 'language.hiligaynon', 'default', 'Hiligaynon', NULL),
('en', 'language.hindi', 'default', 'Hindi', NULL),
('en', 'language.hindi.fiji', 'default', 'Fiji Hindi', NULL),
('en', 'language.hittite', 'default', 'Hittite', NULL),
('en', 'language.hmong', 'default', 'Hmong', NULL),
('en', 'language.hungarian', 'default', 'Hungarian', NULL),
('en', 'language.hupa', 'default', 'Hupa', NULL),
('en', 'language.iban', 'default', 'Iban', NULL),
('en', 'language.ibibio', 'default', 'Ibibio', NULL),
('en', 'language.icelandic', 'default', 'Icelandic', NULL),
('en', 'language.ido', 'default', 'Ido', NULL),
('en', 'language.igbo', 'default', 'Igbo', NULL),
('en', 'language.iloko', 'default', 'Iloko', NULL),
('en', 'language.indonesian', 'default', 'Indonesian', NULL),
('en', 'language.ingrian', 'default', 'Ingrian', NULL),
('en', 'language.ingush', 'default', 'Ingush', NULL),
('en', 'language.interlingua', 'default', 'Interlingua', NULL),
('en', 'language.interlingue', 'default', 'Interlingue', NULL),
('en', 'language.inuktitut', 'default', 'Inuktitut', NULL),
('en', 'language.inupiaq', 'default', 'Inupiaq', NULL),
('en', 'language.irish', 'default', 'Irish', NULL),
('en', 'language.irish.middle', 'default', 'Middle Irish', NULL),
('en', 'language.irish.old', 'default', 'Old Irish', NULL),
('en', 'language.italian', 'default', 'Italian', NULL),
('en', 'language.japanese', 'default', 'Japanese', NULL),
('en', 'language.jargon.chinook', 'default', 'Chinook Jargon', NULL),
('en', 'language.javanese', 'default', 'Javanese', NULL),
('en', 'language.jju', 'default', 'Jju', NULL),
('en', 'language.jolafonyi', 'default', 'Jola-Fonyi', NULL),
('en', 'language.judeoarabic', 'default', 'Judeo-Arabic', NULL),
('en', 'language.judeopersian', 'default', 'Judeo-Persian', NULL),
('en', 'language.jutish', 'default', 'Jutish', NULL),
('en', 'language.kabardian', 'default', 'Kabardian', NULL),
('en', 'language.kabuverdianu', 'default', 'Kabuverdianu', NULL),
('en', 'language.kabyle', 'default', 'Kabyle', NULL),
('en', 'language.kachin', 'default', 'Kachin', NULL),
('en', 'language.kaingang', 'default', 'Kaingang', NULL),
('en', 'language.kako', 'default', 'Kako', NULL),
('en', 'language.kalaallisut', 'default', 'Kalaallisut', NULL),
('en', 'language.kalenjin', 'default', 'Kalenjin', NULL),
('en', 'language.kalmyk', 'default', 'Kalmyk', NULL),
('en', 'language.kamba', 'default', 'Kamba', NULL),
('en', 'language.kanembu', 'default', 'Kanembu', NULL),
('en', 'language.kannada', 'default', 'Kannada', NULL),
('en', 'language.kanuri', 'default', 'Kanuri', NULL),
('en', 'language.karachaybalkar', 'default', 'Karachay-Balkar', NULL),
('en', 'language.karakalpak', 'default', 'Kara-Kalpak', NULL),
('en', 'language.karelian', 'default', 'Karelian', NULL),
('en', 'language.kashmiri', 'default', 'Kashmiri', NULL),
('en', 'language.kashubian', 'default', 'Kashubian', NULL),
('en', 'language.kawi', 'default', 'Kawi', NULL),
('en', 'language.kazakh', 'default', 'Kazakh', NULL),
('en', 'language.kenyang', 'default', 'Kenyang', NULL),
('en', 'language.khasi', 'default', 'Khasi', NULL),
('en', 'language.khmer', 'default', 'Khmer', NULL),
('en', 'language.khotanese', 'default', 'Khotanese', NULL),
('en', 'language.khowar', 'default', 'Khowar', NULL),
('en', 'language.kiche', 'default', 'Kʼicheʼ', NULL),
('en', 'language.kikuyu', 'default', 'Kikuyu', NULL),
('en', 'language.kimbundu', 'default', 'Kimbundu', NULL),
('en', 'language.kinaraya', 'default', 'Kinaray-a', NULL),
('en', 'language.kinyarwanda', 'default', 'Kinyarwanda', NULL),
('en', 'language.kirmanjki', 'default', 'Kirmanjki', NULL),
('en', 'language.klingon', 'default', 'Klingon', NULL),
('en', 'language.kom', 'default', 'Kom', NULL),
('en', 'language.komi', 'default', 'Komi', NULL),
('en', 'language.komi.permyak', 'default', 'Komi-Permyak', NULL),
('en', 'language.kongo', 'default', 'Kongo', NULL),
('en', 'language.konkani', 'default', 'Konkani', NULL),
('en', 'language.konkani.goan', 'default', 'Goan Konkani', NULL),
('en', 'language.korean', 'default', 'Korean', NULL),
('en', 'language.koro', 'default', 'Koro', NULL),
('en', 'language.kosraean', 'default', 'Kosraean', NULL),
('en', 'language.kotava', 'default', 'Kotava', NULL),
('en', 'language.kpelle', 'default', 'Kpelle', NULL),
('en', 'language.krio', 'default', 'Krio', NULL),
('en', 'language.kuanyama', 'default', 'Kuanyama', NULL),
('en', 'language.kumyk', 'default', 'Kumyk', NULL),
('en', 'language.kurdish', 'default', 'Kurdish', NULL),
('en', 'language.kurdish.central', 'default', 'Central Kurdish', NULL),
('en', 'language.kurukh', 'default', 'Kurukh', NULL),
('en', 'language.kutenai', 'default', 'Kutenai', NULL),
('en', 'language.kwasio', 'default', 'Kwasio', NULL),
('en', 'language.kyrgyz', 'default', 'Kyrgyz', NULL),
('en', 'language.ladino', 'default', 'Ladino', NULL),
('en', 'language.lahnda', 'default', 'Lahnda', NULL),
('en', 'language.lakota', 'default', 'Lakota', NULL),
('en', 'language.lamba', 'default', 'Lamba', NULL),
('en', 'language.langi', 'default', 'Langi', NULL),
('en', 'language.lao', 'default', 'Lao', NULL),
('en', 'language.latgalian', 'default', 'Latgalian', NULL),
('en', 'language.latin', 'default', 'Latin', NULL),
('en', 'language.latvian', 'default', 'Latvian', NULL),
('en', 'language.laz', 'default', 'Laz', NULL),
('en', 'language.lezghian', 'default', 'Lezghian', NULL),
('en', 'language.ligurian', 'default', 'Ligurian', NULL),
('en', 'language.limburgish', 'default', 'Limburgish', NULL),
('en', 'language.lingala', 'default', 'Lingala', NULL),
('en', 'language.linguafranca.nova', 'default', 'Lingua Franca Nova', NULL),
('en', 'language.lithuanian', 'default', 'Lithuanian', NULL),
('en', 'language.livonian', 'default', 'Livonian', NULL),
('en', 'language.lojban', 'default', 'Lojban', NULL),
('en', 'language.lombard', 'default', 'Lombard', NULL),
('en', 'language.lozi', 'default', 'Lozi', NULL),
('en', 'language.luba.katanga', 'default', 'Luba-Katanga', NULL),
('en', 'language.luba.lulua', 'default', 'Luba-Lulua', NULL),
('en', 'language.luiseno', 'default', 'Luiseno', NULL),
('en', 'language.lunda', 'default', 'Lunda', NULL),
('en', 'language.luo', 'default', 'Luo', NULL),
('en', 'language.luri.northern', 'default', 'Northern Luri', NULL),
('en', 'language.luxembourgish', 'default', 'Luxembourgish', NULL),
('en', 'language.luyia', 'default', 'Luyia', NULL),
('en', 'language.maba', 'default', 'Maba', NULL),
('en', 'language.macedonian', 'default', 'Macedonian', NULL),
('en', 'language.machame', 'default', 'Machame', NULL),
('en', 'language.madurese', 'default', 'Madurese', NULL),
('en', 'language.mafa', 'default', 'Mafa', NULL),
('en', 'language.magahi', 'default', 'Magahi', NULL),
('en', 'language.maithili', 'default', 'Maithili', NULL),
('en', 'language.makasar', 'default', 'Makasar', NULL),
('en', 'language.makhuwameetto', 'default', 'Makhuwa-Meetto', NULL),
('en', 'language.makonde', 'default', 'Makonde', NULL),
('en', 'language.malagasy', 'default', 'Malagasy', NULL),
('en', 'language.malay', 'default', 'Malay', NULL),
('en', 'language.malayalam', 'default', 'Malayalam', NULL),
('en', 'language.maltese', 'default', 'Maltese', NULL),
('en', 'language.manchu', 'default', 'Manchu', NULL),
('en', 'language.mandar', 'default', 'Mandar', NULL),
('en', 'language.mandingo', 'default', 'Mandingo', NULL),
('en', 'language.manipuri', 'default', 'Manipuri', NULL),
('en', 'language.manx', 'default', 'Manx', NULL),
('en', 'language.maori', 'default', 'Maori', NULL),
('en', 'language.mapuche', 'default', 'Mapuche', NULL),
('en', 'language.marathi', 'default', 'Marathi', NULL),
('en', 'language.mari', 'default', 'Mari', NULL),
('en', 'language.mari.western', 'default', 'Western Mari', NULL),
('en', 'language.marshallese', 'default', 'Marshallese', NULL),
('en', 'language.marwari', 'default', 'Marwari', NULL),
('en', 'language.masai', 'default', 'Masai', NULL),
('en', 'language.mazanderani', 'default', 'Mazanderani', NULL),
('en', 'language.medumba', 'default', 'Medumba', NULL),
('en', 'language.mende', 'default', 'Mende', NULL),
('en', 'language.mentawai', 'default', 'Mentawai', NULL),
('en', 'language.meru', 'default', 'Meru', NULL),
('en', 'language.meta', 'default', 'Meta', NULL),
('en', 'language.micmac', 'default', 'Micmac', NULL),
('en', 'language.minangkabau', 'default', 'Minangkabau', NULL),
('en', 'language.mingrelian', 'default', 'Mingrelian', NULL),
('en', 'language.mirandese', 'default', 'Mirandese', NULL),
('en', 'language.mizo', 'default', 'Mizo', NULL),
('en', 'language.mohawk', 'default', 'Mohawk', NULL),
('en', 'language.moksha', 'default', 'Moksha', NULL),
('en', 'language.moldavian', 'default', 'Moldavian', NULL),
('en', 'language.mongo', 'default', 'Mongo', NULL),
('en', 'language.mongolian', 'default', 'Mongolian', NULL);
INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'language.morisyen', 'default', 'Morisyen', NULL),
('en', 'language.mossi', 'default', 'Mossi', NULL),
('en', 'language.motu.hiri', 'default', 'Hiri Motu', NULL),
('en', 'language.multiple', 'default', 'Multiple Languages', NULL),
('en', 'language.mundang', 'default', 'Mundang', NULL),
('en', 'language.myene', 'default', 'Myene', NULL),
('en', 'language.nama', 'default', 'Nama', NULL),
('en', 'language.nauru', 'default', 'Nauru', NULL),
('en', 'language.navajo', 'default', 'Navajo', NULL),
('en', 'language.ndebele.north', 'default', 'North Ndebele', NULL),
('en', 'language.ndebele.south', 'default', 'South Ndebele', NULL),
('en', 'language.ndonga', 'default', 'Ndonga', NULL),
('en', 'language.neapolitan', 'default', 'Neapolitan', NULL),
('en', 'language.nepali', 'default', 'Nepali', NULL),
('en', 'language.newari', 'default', 'Newari', NULL),
('en', 'language.newari.classical', 'default', 'Classical Newari', NULL),
('en', 'language.ngambay', 'default', 'Ngambay', NULL),
('en', 'language.ngiemboon', 'default', 'Ngiemboon', NULL),
('en', 'language.ngomba', 'default', 'Ngomba', NULL),
('en', 'language.nheengatu', 'default', 'Nheengatu', NULL),
('en', 'language.nias', 'default', 'Nias', NULL),
('en', 'language.niuean', 'default', 'Niuean', NULL),
('en', 'language.nko', 'default', 'N’Ko', NULL),
('en', 'language.nogai', 'default', 'Nogai', NULL),
('en', 'language.none', 'default', 'No linguistic content', NULL),
('en', 'language.norse.old', 'default', 'Old Norse', NULL),
('en', 'language.northern sami', 'default', 'Northern Sami', NULL),
('en', 'language.norwegian', 'default', 'Norwegian', NULL),
('en', 'language.norwegian.bokmål', 'default', 'Norwegian Bokmål', NULL),
('en', 'language.norwegian.nynorsk', 'default', 'Norwegian Nynorsk', NULL),
('en', 'language.novial', 'default', 'Novial', NULL),
('en', 'language.nuer', 'default', 'Nuer', NULL),
('en', 'language.nyamwezi', 'default', 'Nyamwezi', NULL),
('en', 'language.nyanja', 'default', 'Nyanja', NULL),
('en', 'language.nyankole', 'default', 'Nyankole', NULL),
('en', 'language.nyoro', 'default', 'Nyoro', NULL),
('en', 'language.nzima', 'default', 'Nzima', NULL),
('en', 'language.occitan', 'default', 'Occitan', NULL),
('en', 'language.ojibwa', 'default', 'Ojibwa', NULL),
('en', 'language.oriya', 'default', 'Oriya', NULL),
('en', 'language.oromo', 'default', 'Oromo', NULL),
('en', 'language.osage', 'default', 'Osage', NULL),
('en', 'language.ossetic', 'default', 'Ossetic', NULL),
('en', 'language.pahlavi', 'default', 'Pahlavi', NULL),
('en', 'language.palauan', 'default', 'Palauan', NULL),
('en', 'language.pali', 'default', 'Pali', NULL),
('en', 'language.pampanga', 'default', 'Pampanga', NULL),
('en', 'language.pangasinan', 'default', 'Pangasinan', NULL),
('en', 'language.papiamento', 'default', 'Papiamento', NULL),
('en', 'language.pashto', 'default', 'Pashto', NULL),
('en', 'language.persian', 'default', 'Persian', NULL),
('en', 'language.persian.old', 'default', 'Old Persian', NULL),
('en', 'language.phoenician', 'default', 'Phoenician', NULL),
('en', 'language.picard', 'default', 'Picard', NULL),
('en', 'language.piedmontese', 'default', 'Piedmontese', NULL),
('en', 'language.pisin.tok', 'default', 'Tok Pisin', NULL),
('en', 'language.plautdietsch', 'default', 'Plautdietsch', NULL),
('en', 'language.pohnpeian', 'default', 'Pohnpeian', NULL),
('en', 'language.polish', 'default', 'Polish', NULL),
('en', 'language.pontic', 'default', 'Pontic', NULL),
('en', 'language.portuguese', 'default', 'Portuguese', NULL),
('en', 'language.portuguese.brazilian', 'default', 'Brazilian Portuguese', NULL),
('en', 'language.portuguese.european', 'default', 'European Portuguese', NULL),
('en', 'language.provençal.old', 'default', 'Old Provençal', NULL),
('en', 'language.prussian', 'default', 'Prussian', NULL),
('en', 'language.punjabi', 'default', 'Punjabi', NULL),
('en', 'language.quechua', 'default', 'Quechua', NULL),
('en', 'language.quichua.chimborazohighland', 'default', 'Chimborazo Highland Quichua', NULL),
('en', 'language.rajasthani', 'default', 'Rajasthani', NULL),
('en', 'language.rapanui', 'default', 'Rapanui', NULL),
('en', 'language.rarotongan', 'default', 'Rarotongan', NULL),
('en', 'language.riffian', 'default', 'Riffian', NULL),
('en', 'language.romagnol', 'default', 'Romagnol', NULL),
('en', 'language.romanian', 'default', 'Romanian', NULL),
('en', 'language.romansh', 'default', 'Romansh', NULL),
('en', 'language.romany', 'default', 'Romany', NULL),
('en', 'language.rombo', 'default', 'Rombo', NULL),
('en', 'language.root', 'default', 'Root', NULL),
('en', 'language.rotuman', 'default', 'Rotuman', NULL),
('en', 'language.roviana', 'default', 'Roviana', NULL),
('en', 'language.rundi', 'default', 'Rundi', NULL),
('en', 'language.russian', 'default', 'Russian', NULL),
('en', 'language.rusyn', 'default', 'Rusyn', NULL),
('en', 'language.rwa', 'default', 'Rwa', NULL),
('en', 'language.saho', 'default', 'Saho', NULL),
('en', 'language.sakha', 'default', 'Sakha', NULL),
('en', 'language.samburu', 'default', 'Samburu', NULL),
('en', 'language.sami.inari', 'default', 'Inari Sami', NULL),
('en', 'language.sami.lule', 'default', 'Lule Sami', NULL),
('en', 'language.sami.skolt', 'default', 'Skolt Sami', NULL),
('en', 'language.sami.southern', 'default', 'Southern Sami', NULL),
('en', 'language.samoan', 'default', 'Samoan', NULL),
('en', 'language.samogitian', 'default', 'Samogitian', NULL),
('en', 'language.sandawe', 'default', 'Sandawe', NULL),
('en', 'language.sango', 'default', 'Sango', NULL),
('en', 'language.sangu', 'default', 'Sangu', NULL),
('en', 'language.sanskrit', 'default', 'Sanskrit', NULL),
('en', 'language.santali', 'default', 'Santali', NULL),
('en', 'language.sardinian', 'default', 'Sardinian', NULL),
('en', 'language.sardinian.sassarese', 'default', 'Sassarese Sardinian', NULL),
('en', 'language.sasak', 'default', 'Sasak', NULL),
('en', 'language.saurashtra', 'default', 'Saurashtra', NULL),
('en', 'language.saxon.low', 'default', 'Low Saxon', NULL),
('en', 'language.scots', 'default', 'Scots', NULL),
('en', 'language.selayar', 'default', 'Selayar', NULL),
('en', 'language.selkup', 'default', 'Selkup', NULL),
('en', 'language.sena', 'default', 'Sena', NULL),
('en', 'language.seneca', 'default', 'Seneca', NULL),
('en', 'language.senni.koyraboro', 'default', 'Koyraboro Senni', NULL),
('en', 'language.serbian', 'default', 'Serbian', NULL),
('en', 'language.serbocroatian', 'default', 'Serbo-Croatian', NULL),
('en', 'language.serer', 'default', 'Serer', NULL),
('en', 'language.seri', 'default', 'Seri', NULL),
('en', 'language.shambala', 'default', 'Shambala', NULL),
('en', 'language.shan', 'default', 'Shan', NULL),
('en', 'language.shona', 'default', 'Shona', NULL),
('en', 'language.sicilian', 'default', 'Sicilian', NULL),
('en', 'language.sidamo', 'default', 'Sidamo', NULL),
('en', 'language.siksika', 'default', 'Siksika', NULL),
('en', 'language.silesian', 'default', 'Silesian', NULL),
('en', 'language.silesian.lower', 'default', 'Lower Silesian', NULL),
('en', 'language.sindhi', 'default', 'Sindhi', NULL),
('en', 'language.sinhala', 'default', 'Sinhala', NULL),
('en', 'language.slave', 'default', 'Slave', NULL),
('en', 'language.slavic.church', 'default', 'Church Slavic', NULL),
('en', 'language.slovak', 'default', 'Slovak', NULL),
('en', 'language.slovenian', 'default', 'Slovenian', NULL),
('en', 'language.soga', 'default', 'Soga', NULL),
('en', 'language.sogdien', 'default', 'Sogdien', NULL),
('en', 'language.somali', 'default', 'Somali', NULL),
('en', 'language.soninke', 'default', 'Soninke', NULL),
('en', 'language.sorbian.lower', 'default', 'Lower Sorbian', NULL),
('en', 'language.sorbian.upper', 'default', 'Upper Sorbian', NULL),
('en', 'language.sotho.northern', 'default', 'Northern Sotho', NULL),
('en', 'language.sotho.southern', 'default', 'Southern Sotho', NULL),
('en', 'language.southern kurdish', 'default', 'Southern Kurdish', NULL),
('en', 'language.spanish', 'default', 'Spanish', NULL),
('en', 'language.spanish.european', 'default', 'European Spanish', NULL),
('en', 'Language.spanish.latinamerican', 'default', 'Latin American Spanish', NULL),
('en', 'language.spanish.mexican', 'default', 'Mexican Spanish', NULL),
('en', 'language.sukuma', 'default', 'Sukuma', NULL),
('en', 'language.sumerian', 'default', 'Sumerian', NULL),
('en', 'language.sundanese', 'default', 'Sundanese', NULL),
('en', 'language.susu', 'default', 'Susu', NULL),
('en', 'language.swahili', 'default', 'Swahili', NULL),
('en', 'language.swahili.congo', 'default', 'Congo Swahili', NULL),
('en', 'language.swati', 'default', 'Swati', NULL),
('en', 'language.swedish', 'default', 'Swedish', NULL),
('en', 'language.syriac', 'default', 'Syriac', NULL),
('en', 'language.syriac.classical', 'default', 'Classical Syriac', NULL),
('en', 'language.tachelhit', 'default', 'Tachelhit', NULL),
('en', 'language.tagalog', 'default', 'Tagalog', NULL),
('en', 'language.tahitian', 'default', 'Tahitian', NULL),
('en', 'language.taita', 'default', 'Taita', NULL),
('en', 'language.tajik', 'default', 'Tajik', NULL),
('en', 'language.talysh', 'default', 'Talysh', NULL),
('en', 'language.tamashek', 'default', 'Tamashek', NULL),
('en', 'language.tamazight.centralatlas', 'default', 'Central Atlas Tamazight', NULL),
('en', 'language.tamazight.standardmoroccan', 'default', 'Standard Moroccan Tamazight', NULL),
('en', 'language.tamil', 'default', 'Tamil', NULL),
('en', 'language.taroko', 'default', 'Taroko', NULL),
('en', 'language.tasawaq', 'default', 'Tasawaq', NULL),
('en', 'language.tat.muslim', 'default', 'Muslim Tat', NULL),
('en', 'language.tatar', 'default', 'Tatar', NULL),
('en', 'language.telugu', 'default', 'Telugu', NULL),
('en', 'language.tereno', 'default', 'Tereno', NULL),
('en', 'language.teso', 'default', 'Teso', NULL),
('en', 'language.tetum', 'default', 'Tetum', NULL),
('en', 'language.thai', 'default', 'Thai', NULL),
('en', 'language.tibetan', 'default', 'Tibetan', NULL),
('en', 'language.tigre', 'default', 'Tigre', NULL),
('en', 'language.tigrinya', 'default', 'Tigrinya', NULL),
('en', 'language.timne', 'default', 'Timne', NULL),
('en', 'language.tiv', 'default', 'Tiv', NULL),
('en', 'language.tlingit', 'default', 'Tlingit', NULL),
('en', 'language.tokelau', 'default', 'Tokelau', NULL),
('en', 'language.tonga.nyasa', 'default', 'Nyasa Tonga', NULL),
('en', 'language.tongan', 'default', 'Tongan', NULL),
('en', 'language.tongo.sranan', 'default', 'Sranan Tongo', NULL),
('en', 'language.tsakhur', 'default', 'Tsakhur', NULL),
('en', 'language.tsakonian', 'default', 'Tsakonian', NULL),
('en', 'language.tsimshian', 'default', 'Tsimshian', NULL),
('en', 'language.tsonga', 'default', 'Tsonga', NULL),
('en', 'language.tswana', 'default', 'Tswana', NULL),
('en', 'language.tulu', 'default', 'Tulu', NULL),
('en', 'language.tumbuka', 'default', 'Tumbuka', NULL),
('en', 'language.turkish', 'default', 'Turkish', NULL),
('en', 'language.turkish.crimean', 'default', 'Crimean Turkish', NULL),
('en', 'language.turkish.ottoman', 'default', 'Ottoman Turkish', NULL),
('en', 'language.turkmen', 'default', 'Turkmen', NULL),
('en', 'language.turoyo', 'default', 'Turoyo', NULL),
('en', 'language.tuvalu', 'default', 'Tuvalu', NULL),
('en', 'language.tuvinian', 'default', 'Tuvinian', NULL),
('en', 'language.twi', 'default', 'Twi', NULL),
('en', 'language.tyap', 'default', 'Tyap', NULL),
('en', 'language.udmurt', 'default', 'Udmurt', NULL),
('en', 'language.ugaritic', 'default', 'Ugaritic', NULL),
('en', 'language.ukrainian', 'default', 'Ukrainian', NULL),
('en', 'language.umbundu', 'default', 'Umbundu', NULL),
('en', 'language.unknown', 'default', 'Unknown Language', NULL),
('en', 'language.urdu', 'default', 'Urdu', NULL),
('en', 'language.uyghur', 'default', 'Uyghur', NULL),
('en', 'language.uzbek', 'default', 'Uzbek', NULL),
('en', 'language.vai', 'default', 'Vai', NULL),
('en', 'language.venda', 'default', 'Venda', NULL),
('en', 'language.venetian', 'default', 'Venetian', NULL),
('en', 'language.veps', 'default', 'Veps', NULL),
('en', 'language.vietnamese', 'default', 'Vietnamese', NULL),
('en', 'language.volapük', 'default', 'Volapük', NULL),
('en', 'language.võro', 'default', 'Võro', NULL),
('en', 'language.votic', 'default', 'Votic', NULL),
('en', 'language.vunjo', 'default', 'Vunjo', NULL),
('en', 'language.walloon', 'default', 'Walloon', NULL),
('en', 'language.walser', 'default', 'Walser', NULL),
('en', 'language.waray', 'default', 'Waray', NULL),
('en', 'language.warlpiri', 'default', 'Warlpiri', NULL),
('en', 'language.washo', 'default', 'Washo', NULL),
('en', 'language.wayuu', 'default', 'Wayuu', NULL),
('en', 'language.welsh', 'default', 'Welsh', NULL),
('en', 'language.wolaytta', 'default', 'Wolaytta', NULL),
('en', 'language.wolof', 'default', 'Wolof', NULL),
('en', 'language.xhosa', 'default', 'Xhosa', NULL),
('en', 'language.yangben', 'default', 'Yangben', NULL),
('en', 'language.yao', 'default', 'Yao', NULL),
('en', 'language.yapese', 'default', 'Yapese', NULL),
('en', 'language.yemba', 'default', 'Yemba', NULL),
('en', 'language.yi.sichuan', 'default', 'Sichuan Yi', NULL),
('en', 'language.yiddish', 'default', 'Yiddish', NULL),
('en', 'language.yoruba', 'default', 'Yoruba', NULL),
('en', 'language.yupik.central', 'default', 'Central Yupik', NULL),
('en', 'language.zapotec', 'default', 'Zapotec', NULL),
('en', 'language.zarma', 'default', 'Zarma', NULL),
('en', 'language.zaza', 'default', 'Zaza', NULL),
('en', 'language.zeelandic', 'default', 'Zeelandic', NULL),
('en', 'language.zenaga', 'default', 'Zenaga', NULL),
('en', 'language.zhuang', 'default', 'Zhuang', NULL),
('en', 'language.zulu', 'default', 'Zulu', NULL),
('en', 'language.zuni', 'default', 'Zuni', NULL),
('en', 'length.kilometre', 'default', 'kilometre', NULL),
('en', 'length.metre', 'default', 'metre', NULL),
('en', 'length.micrometre', 'default', 'micrometre', NULL),
('en', 'length.millimetre', 'default', 'millimetre', NULL),
('en', 'length.nanometre', 'default', 'nanometre', NULL),
('en', 'map.layer.aerial', 'default', 'Satellite', NULL),
('en', 'map.layer.aerial.labels', 'default', 'Satellite with labels', NULL),
('en', 'map.layer.bing.aerial', 'default', 'Bing Aerial', NULL),
('en', 'map.layer.bing.aerialwithlabels', 'default', 'Aerial View with Labels', NULL),
('en', 'map.layer.bing.road', 'default', 'Bing Roads', NULL),
('en', 'map.layer.road', 'default', 'Road', NULL),
('en', 'map.legend.max', 'default', 'Max', NULL),
('en', 'map.legend.min', 'default', 'Min', NULL),
('en', 'map.style.choropleth', 'default', 'Municipality', NULL),
('en', 'map.style.distribution', 'default', 'Distribution', NULL),
('en', 'map.style.none', 'default', 'None', NULL),
('en', 'mass.gram', 'default', 'gram', NULL),
('en', 'mass.kilogram', 'default', 'kilogram', NULL),
('en', 'mass.microgram', 'default', 'microgram', NULL),
('en', 'mass.milligram', 'default', 'milligram', NULL),
('en', 'mass.tonne', 'default', 'tonne', NULL),
('en', 'module.campaign', 'default', 'Campaign', NULL),
('en', 'module.file', 'default', 'File', NULL),
('en', 'module.find', 'default', 'Find', NULL),
('en', 'module.image', 'default', 'Image', NULL),
('en', 'module.location', 'default', 'Location', NULL),
('en', 'property.address', 'default', 'Address', NULL),
('en', 'property.avatar', 'default', 'Avatar', NULL),
('en', 'property.city', 'default', 'City', NULL),
('en', 'property.content', 'default', 'Content', NULL),
('en', 'property.country', 'default', 'Country', NULL),
('en', 'property.dateofbirth', 'default', 'Date of Birth', NULL),
('en', 'property.id', 'default', 'ID', NULL),
('en', 'property.initials', 'default', 'Initials', NULL),
('en', 'property.language', 'default', 'Language', NULL),
('en', 'property.length', 'default', 'Length', 'Core Property Length'),
('en', 'property.logo', 'default', 'Logo', NULL),
('en', 'property.module', 'default', 'Module', NULL),
('en', 'property.name', 'default', 'Name', NULL),
('en', 'property.phone', 'default', 'Phone', NULL),
('en', 'property.street', 'default', 'Street', NULL),
('en', 'property.title', 'default', 'Title', NULL),
('en', 'schema.file', 'default', 'File', NULL),
('en', 'search.placeholder', 'default', 'Free Text Search', NULL),
('en', 'site.brand', 'default', 'ARK', NULL),
('en', 'site.welcome', 'default', 'Welcome to ARK.', NULL),
('en', 'spatial.crs.wgs84', 'default', 'crs.wgs84', NULL),
('en', 'test.test', 'default', 'text text', 'notes notes'),
('en', 'user.greeting', 'default', 'Logged In As %name%', NULL),
('en', 'user.menu.edit', 'default', 'Edit your profile', NULL),
('en', 'user.menu.home', 'default', 'My Home', NULL),
('en', 'user.menu.list', 'default', 'List users', NULL),
('en', 'user.menu.login', 'default', 'Sign in', NULL),
('en', 'user.menu.logout', 'default', 'Sign out', NULL),
('en', 'user.menu.password', 'default', 'Change your password', NULL),
('en', 'user.menu.register', 'default', 'Create account', NULL),
('en', 'user.menu.view', 'default', 'View your profile', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_parameter`
--

CREATE TABLE `ark_translation_parameter` (
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_parameter`
--

INSERT INTO `ark_translation_parameter` (`keyword`, `parameter`) VALUES
('user.greeting', 'name');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_role`
--

CREATE TABLE `ark_translation_role` (
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_role`
--

INSERT INTO `ark_translation_role` (`role`, `keyword`, `description`) VALUES
('button', NULL, 'UI Button'),
('check', NULL, 'UI Checkbox'),
('column', NULL, 'UI Column'),
('danger', NULL, 'Danger flash message'),
('default', 'translation.role.default', 'Default translation'),
('description', 'translation.role.description', 'A description of the keyword'),
('error', NULL, 'Error flash message'),
('from', 'translation.role.from', 'The start of a range'),
('group', NULL, 'UI Group'),
('help', NULL, 'Help Text'),
('info', NULL, 'Information flash message'),
('listbox', NULL, 'UI List Box'),
('menu', NULL, 'UI Menu'),
('negative', 'translation.role.negative', 'The negative of the keyword'),
('official', 'translation.role.official', 'The official name or title'),
('opposite', 'translation.role.opposite', 'The opposite of the keyword'),
('positive', 'translation.role.positive', 'The positive of the keyword'),
('progress', NULL, 'UI Progress Bar'),
('radio', NULL, 'Ui Radio Button'),
('range', NULL, 'Name of a range'),
('resource', 'translation.role.resource', 'URL Resource translation'),
('row', NULL, 'UI Row'),
('slider', NULL, 'UI Slider'),
('spinbox', NULL, 'UI Spin Box'),
('status', NULL, 'UI Status'),
('success', NULL, 'Success flash message'),
('tab', NULL, 'UI Tab'),
('textbox', NULL, 'UI Text Box'),
('title', 'translation.role.title', 'The title of the keyword'),
('to', 'translation.role.to', 'The end of a range'),
('toolbar', NULL, 'UI Tool Bar'),
('tooltip', NULL, 'UI Tool Tip'),
('warning', NULL, 'Warning flash message');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_cell`
--

CREATE TABLE `ark_view_cell` (
  `grp` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int(11) NOT NULL,
  `col` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `map` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_schema` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `label` tinyint(1) DEFAULT NULL,
  `help` tinyint(1) NOT NULL DEFAULT 0,
  `placeholder` tinyint(1) DEFAULT NULL,
  `choices` tinyint(1) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sanitise` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `pattern` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_cell`
--

INSERT INTO `ark_view_cell` (`grp`, `class`, `row`, `col`, `seq`, `element`, `name`, `map`, `vocabulary`, `action_schema`, `action`, `view`, `edit`, `keyword`, `width`, `label`, `help`, `placeholder`, `choices`, `required`, `mode`, `sanitise`, `visible`, `pattern`, `display`, `value`, `parameter`, `format`, `data`, `enabled`, `deprecated`, `template`, `options`) VALUES
('core_admin_user', '', 0, 0, 2, 'core_form_user_password_set', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_admin_user', '', 0, 0, 4, 'core_form_user_role_add', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_admin_user_list', '', 0, 0, 0, 'core_form_user_filter', 'filter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_admin_user_list', '', 0, 0, 2, 'core_table_user', 'users', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 'view', NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_admin_user_list', '', 0, 0, 4, 'core_workflow_action', 'actions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_action_select', '', 0, 0, 2, 'core_widget_submit', 'apply', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.save', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_actor_item', '', 0, 0, 0, 'core_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_actor_item', '', 0, 0, 1, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_actor_item', '', 0, 0, 2, 'core_actor_shortname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_admin_user_register', '', 0, 0, 0, 'core_user_credentials', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_admin_user_register', '', 0, 0, 2, 'core_user_register_actor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_admin_user_register', '', 0, 0, 4, 'core_user_role', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_admin_user_register', '', 0, 0, 6, 'core_widget_submit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.register', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 0, 'core_file_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 1, 'core_file_class', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 2, 'core_file_mediatype', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 3, 'core_file_title', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 4, 'core_file_status', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 0, 5, 'core_file_description', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_file_item', '', 0, 1, 1, 'core_widget_submit', 'save', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.save', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_message_item', '', 0, 0, 0, 'core_message_class', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_message_item', '', 0, 0, 1, 'core_message_sender', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_message_item', '', 0, 0, 2, 'core_message_sent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_message_item', '', 0, 0, 3, 'core_message_event', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_profile_view', '', 0, 0, 0, 'core_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_profile_view', '', 0, 0, 2, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_profile_view', '', 0, 0, 8, 'core_actor_biography', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_profile_view', '', 0, 1, 2, 'core_actor_avatar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_filter', '', 0, 0, 0, 'core_widget_choice', 'status', NULL, 'core.security.user.status', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '{\"attr\": {\"style\": \"width:95%\"}}'),
('core_form_user_filter', '', 0, 2, 0, 'core_widget_submit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.select', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_login', '', 0, 0, 0, 'core_widget_username', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_login', '', 0, 0, 2, 'core_widget_password', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_login', '', 0, 0, 4, 'core_widget_submit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.login', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_password_change', '', 0, 0, 0, 'core_widget_password', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.password.current', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_password_change', '', 0, 0, 2, 'core_widget_password_confirm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_password_change', '', 0, 0, 4, 'core_widget_submit', 'save', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.change', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_password_set', '', 0, 0, 0, 'core_widget_password_confirm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_password_set', '', 0, 0, 2, 'core_widget_submit', 'password_set', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.save', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_register', '', 0, 0, 0, 'core_user_credentials', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_register', '', 0, 0, 2, 'core_user_actor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_register', '', 0, 0, 4, 'core_user_role', NULL, NULL, 'core.workflow.role', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_register', '', 0, 0, 8, 'core_widget_submit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.register', NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_register', '', 0, 2, 0, 'core_widget_textarea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.register.faq', NULL, 1, 0, 1, NULL, NULL, 'view', 'redact', 1, NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_reset', '', 0, 0, 0, 'core_widget_username', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_reset', '', 0, 0, 4, 'core_widget_submit', 'reset', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.reset', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_role_add', '', 0, 0, 0, 'core_widget_choice', 'role_add', NULL, NULL, NULL, NULL, NULL, NULL, 'core.workflow.role', NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_role_add', '', 0, 0, 6, 'core_widget_date', 'expiry', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.role.expiry', NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_user_role_add', '', 0, 0, 10, 'core_widget_submit', 'role', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.save', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_workflow_action', '', 0, 0, 0, 'core_widget_choice', 'actions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_form_workflow_action', '', 0, 0, 2, 'core_widget_submit', 'apply', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.apply', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_message_page', '', 1, 0, 0, 'core_table_message', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_message_page', '', 1, 1, 0, 'core_form_message_item', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_page_view', '', 0, 0, 0, 'core_page_content', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_profile_list_page', '', 0, 0, 0, 'core_table_profile', 'actors', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 'view', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_profile_page', '', 0, 0, 0, 'core_form_profile_view', 'actor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, 'view', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_actor', '', 0, 0, 0, 'core_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_actor', '', 0, 0, 1, 'core_actor_class', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_actor', '', 0, 0, 2, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_message', '', 0, 0, 0, 'core_message_class', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_message', '', 0, 0, 1, 'core_message_sender', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_message', '', 0, 0, 2, 'core_message_sent', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_message', '', 0, 0, 3, 'core_message_event', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_profile', '', 0, 0, 0, 'core_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_profile', '', 0, 0, 2, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_user', '', 0, 0, 0, 'core_widget_static', 'username', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.username', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_user', '', 0, 0, 2, 'core_widget_static', 'name', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.name', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_user', '', 0, 0, 4, 'core_widget_static', 'level', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.level', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_table_user', '', 0, 0, 6, 'core_widget_static', 'status', NULL, NULL, NULL, NULL, NULL, NULL, 'core.security.user.status', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 2, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 4, 'core_actor_shortname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 6, 'core_actor_initials', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 8, 'core_actor_address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 10, 'core_actor_telephone', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 18, 'core_actor_biography', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_actor', '', 0, 0, 20, 'core_actor_avatar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_credentials', '', 0, 0, 0, 'core_widget_username', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_credentials', '', 0, 0, 2, 'core_widget_email', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_credentials', '', 0, 0, 4, 'core_widget_password_confirm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_profile', '', 1, 1, 0, 'core_form_user_password_change', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_register_actor', '', 0, 0, 0, 'core_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_register_actor', '', 0, 0, 2, 'core_actor_address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_register_actor', '', 0, 0, 4, 'core_actor_telephone', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_role', '', 0, 0, 0, 'core_widget_choice', 'role', NULL, NULL, NULL, NULL, NULL, NULL, 'core.workflow.role', NULL, 1, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_user_role', '', 0, 0, 6, 'core_widget_date', 'expiry', NULL, NULL, NULL, NULL, NULL, NULL, 'core.user.role.expiry', NULL, 1, 0, NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_workflow_action', '', 0, 0, 0, 'core_widget_choice', 'actions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, NULL, NULL, 'redact', 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL),
('core_workflow_action', '', 0, 0, 2, 'core_widget_submit', 'apply', NULL, NULL, NULL, NULL, NULL, NULL, 'core.button.apply', NULL, 0, 0, NULL, NULL, NULL, NULL, 'redact', 1, NULL, NULL, 'active', NULL, NULL, NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_element`
--

CREATE TABLE `ark_view_element` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_element`
--

INSERT INTO `ark_view_element` (`element`, `type`) VALUES
('core_actor_address', 'field'),
('core_actor_avatar', 'field'),
('core_actor_biography', 'field'),
('core_actor_class', 'field'),
('core_actor_email', 'field'),
('core_actor_fullname', 'field'),
('core_actor_id', 'field'),
('core_actor_initials', 'field'),
('core_actor_shortname', 'field'),
('core_actor_status', 'field'),
('core_actor_telephone', 'field'),
('core_file_class', 'field'),
('core_file_description', 'field'),
('core_file_id', 'field'),
('core_file_mediatype', 'field'),
('core_file_status', 'field'),
('core_file_title', 'field'),
('core_file_versions', 'field'),
('core_message_class', 'field'),
('core_message_event', 'field'),
('core_message_id', 'field'),
('core_message_sender', 'field'),
('core_message_sent', 'field'),
('core_page_content', 'field'),
('core_user_terms', 'field'),
('core_form_action_select', 'form'),
('core_form_actor_item', 'form'),
('core_form_admin_user_register', 'form'),
('core_form_file_item', 'form'),
('core_form_message_item', 'form'),
('core_form_profile_view', 'form'),
('core_form_user_filter', 'form'),
('core_form_user_login', 'form'),
('core_form_user_password_change', 'form'),
('core_form_user_password_set', 'form'),
('core_form_user_register', 'form'),
('core_form_user_reset', 'form'),
('core_form_user_role_add', 'form'),
('core_form_workflow_action', 'form'),
('core_admin', 'grid'),
('core_admin_user', 'grid'),
('core_admin_user_list', 'grid'),
('core_home_page', 'grid'),
('core_message_page', 'grid'),
('core_page_view', 'grid'),
('core_profile_list_page', 'grid'),
('core_profile_page', 'grid'),
('core_site_footer', 'grid'),
('core_site_header', 'grid'),
('core_site_sidebar', 'grid'),
('core_user_actor', 'grid'),
('core_user_credentials', 'grid'),
('core_user_profile', 'grid'),
('core_user_register_actor', 'grid'),
('core_user_role', 'grid'),
('core_workflow_action', 'grid'),
('just_parking', 'grid'),
('core_nav_header', 'nav'),
('core_nav_home', 'nav'),
('core_nav_sidebar', 'nav'),
('core_page_admin', 'page'),
('core_page_admin_user', 'page'),
('core_page_admin_user_list', 'page'),
('core_page_admin_user_register', 'page'),
('core_page_home', 'page'),
('core_page_message', 'page'),
('core_page_messages', 'page'),
('core_page_news', 'page'),
('core_page_profile', 'page'),
('core_page_profiles', 'page'),
('core_page_static', 'page'),
('core_page_user_confirm', 'page'),
('core_page_user_login', 'page'),
('core_page_user_profile', 'page'),
('core_page_user_register', 'page'),
('core_page_user_reset', 'page'),
('core_table_actor', 'table'),
('core_table_file', 'table'),
('core_table_message', 'table'),
('core_table_profile', 'table'),
('core_table_user', 'table'),
('core_widget_button', 'widget'),
('core_widget_checkbox', 'widget'),
('core_widget_choice', 'widget'),
('core_widget_date', 'widget'),
('core_widget_dateinterval', 'widget'),
('core_widget_datetime', 'widget'),
('core_widget_email', 'widget'),
('core_widget_email_confirm', 'widget'),
('core_widget_monthday', 'widget'),
('core_widget_password', 'widget'),
('core_widget_password_confirm', 'widget'),
('core_widget_role', 'widget'),
('core_widget_selected', 'widget'),
('core_widget_static', 'widget'),
('core_widget_submit', 'widget'),
('core_widget_submit_recaptcha', 'widget'),
('core_widget_terms', 'widget'),
('core_widget_textarea', 'widget'),
('core_widget_time', 'widget'),
('core_widget_username', 'widget');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_field`
--

CREATE TABLE `ark_view_field` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `parameter` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_field`
--

INSERT INTO `ark_view_field` (`element`, `schma`, `class`, `attribute`, `keyword`, `display`, `value`, `parameter`, `format`, `template`, `form_type`, `form_options`) VALUES
('core_actor_address', 'core.actor', 'actor', 'address', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_avatar', 'core.actor', 'actor', 'avatar', NULL, NULL, 'active', NULL, NULL, 'blocks/avatar.html.twig', NULL, ''),
('core_actor_biography', 'core.actor', 'actor', 'biography', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_class', 'core.actor', 'actor', 'class', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_email', 'core.actor', 'actor', 'email', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_fullname', 'core.actor', 'actor', 'fullname', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_id', 'core.actor', 'actor', 'id', NULL, NULL, 'readonly', NULL, NULL, NULL, NULL, ''),
('core_actor_initials', 'core.actor', 'actor', 'initials', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_shortname', 'core.actor', 'actor', 'shortname', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_status', 'core.actor', 'person', 'status', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_actor_telephone', 'core.actor', 'actor', 'telephone', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_class', 'core.file', 'file', 'class', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_description', 'core.file', 'file', 'description', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_id', 'core.file', 'file', 'id', NULL, NULL, 'readonly', NULL, NULL, NULL, NULL, ''),
('core_file_mediatype', 'core.file', 'file', 'mediatype', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_status', 'core.file', 'file', 'status', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_title', 'core.file', 'file', 'title', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_file_versions', 'core.file', 'file', 'versions', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_message_class', 'core.message', 'message', 'class', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_message_event', 'core.message', 'notification', 'event', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_message_id', 'core.message', 'message', 'id', NULL, NULL, 'readonly', NULL, NULL, NULL, NULL, ''),
('core_message_sender', 'core.message', 'message', 'sender', NULL, 'fullname', 'readonly', NULL, NULL, NULL, NULL, ''),
('core_message_sent', 'core.message', 'message', 'sent', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_page_content', 'core.page', 'page', 'content', NULL, NULL, 'active', NULL, NULL, NULL, NULL, ''),
('core_user_terms', 'core.actor', 'person', 'terms', NULL, NULL, 'active', NULL, NULL, NULL, 'ARK\\Form\\Type\\UserTermsPropertyType', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_form`
--

CREATE TABLE `ark_view_form` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_form`
--

INSERT INTO `ark_view_form` (`element`, `action`, `keyword`, `name`, `mode`, `method`, `template`, `form_type`) VALUES
('core_form_action_select', NULL, 'core.action.select', 'actions', NULL, NULL, NULL, NULL),
('core_form_actor_item', NULL, NULL, 'actor_item', NULL, NULL, NULL, NULL),
('core_form_admin_user_register', NULL, 'core.admin.user.register', 'user', NULL, NULL, NULL, NULL),
('core_form_file_item', NULL, NULL, 'item', 'edit', NULL, NULL, NULL),
('core_form_message_item', NULL, NULL, 'message', 'view', NULL, 'layouts/message.html.twig', NULL),
('core_form_profile_view', NULL, NULL, 'actor', NULL, NULL, NULL, NULL),
('core_form_user_filter', NULL, NULL, 'filter', NULL, NULL, NULL, NULL),
('core_form_user_login', 'user.check', NULL, NULL, NULL, 'POST', 'user/layouts/login.html.twig', NULL),
('core_form_user_password_change', NULL, 'core.user.password.change', 'password_change', NULL, NULL, NULL, NULL),
('core_form_user_password_set', NULL, 'core.user.password.set', 'password_set', NULL, NULL, NULL, NULL),
('core_form_user_register', NULL, NULL, NULL, NULL, NULL, 'user/layouts/register.html.twig', NULL),
('core_form_user_reset', NULL, NULL, NULL, NULL, NULL, 'user/layouts/reset.html.twig', NULL),
('core_form_user_role_add', NULL, 'core.user.role.add', 'role_add', NULL, NULL, NULL, NULL),
('core_form_workflow_action', NULL, 'core.workflow.action', 'action', NULL, NULL, 'layouts/action.html.twig', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_group`
--

CREATE TABLE `ark_view_group` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_group`
--

INSERT INTO `ark_view_group` (`element`, `keyword`, `name`, `mode`, `template`, `form_type`) VALUES
('core_admin', NULL, NULL, NULL, NULL, NULL),
('core_admin_user', NULL, NULL, NULL, NULL, NULL),
('core_admin_user_list', NULL, NULL, NULL, NULL, NULL),
('core_home_page', NULL, NULL, NULL, NULL, NULL),
('core_message_page', NULL, NULL, NULL, NULL, NULL),
('core_page_view', 'core.profile', NULL, NULL, NULL, NULL),
('core_profile_list_page', NULL, NULL, 'view', NULL, NULL),
('core_profile_page', NULL, NULL, 'view', NULL, NULL),
('core_site_footer', NULL, NULL, NULL, NULL, NULL),
('core_site_header', NULL, NULL, NULL, NULL, NULL),
('core_site_sidebar', NULL, NULL, NULL, NULL, NULL),
('core_user_actor', NULL, 'actor', NULL, NULL, NULL),
('core_user_credentials', NULL, 'credentials', NULL, NULL, NULL),
('core_user_profile', NULL, NULL, NULL, NULL, NULL),
('core_user_register_actor', NULL, 'actor', NULL, NULL, NULL),
('core_user_role', NULL, 'role', NULL, NULL, NULL),
('core_workflow_action', 'core.workflow.action', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_nav`
--

CREATE TABLE `ark_view_nav` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seq` int(11) NOT NULL DEFAULT 0,
  `level` int(11) DEFAULT NULL,
  `seperator` tinyint(1) NOT NULL DEFAULT 0,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(2038) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_nav`
--

INSERT INTO `ark_view_nav` (`element`, `parent`, `keyword`, `seq`, `level`, `seperator`, `icon`, `route`, `template`, `uri`) VALUES
('core_nav_header', NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL),
('core_nav_home', 'core_nav_header', NULL, 0, 2, 0, NULL, 'home', NULL, NULL),
('core_nav_sidebar', NULL, NULL, 0, 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_page`
--

CREATE TABLE `ark_view_page` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edit` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'view',
  `visibility` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_page`
--

INSERT INTO `ark_view_page` (`element`, `header`, `sidebar`, `content`, `footer`, `view`, `edit`, `keyword`, `mode`, `visibility`, `template`) VALUES
('core_page_admin', 'core_site_header', 'core_site_sidebar', 'core_admin', 'core_site_footer', 'core.admin', 'core.admin', NULL, 'edit', 'restricted', NULL),
('core_page_admin_user', 'core_site_header', 'core_site_sidebar', 'core_admin_user', 'core_site_footer', 'core.admin.user', 'core.admin.user', NULL, 'edit', 'restricted', NULL),
('core_page_admin_user_list', 'core_site_header', 'core_site_sidebar', 'core_admin_user_list', 'core_site_footer', 'core.admin.user', 'core.admin.user', NULL, 'edit', 'restricted', NULL),
('core_page_admin_user_register', 'core_site_header', 'core_site_sidebar', 'core_form_admin_user_register', 'core_site_footer', 'core.admin.user', 'core.admin.user', NULL, 'edit', 'restricted', NULL),
('core_page_home', 'core_site_header', 'core_site_sidebar', 'core_home_page', 'core_site_footer', NULL, NULL, NULL, 'view', 'public', NULL),
('core_page_message', 'core_site_header', 'core_site_sidebar', 'core_message_page', 'core_site_footer', 'core.message.read', 'core.message.update', NULL, 'edit', 'restricted', NULL),
('core_page_messages', 'core_site_header', 'core_site_sidebar', 'core_message_page', 'core_site_footer', 'core.message.read', 'core.message.update', NULL, 'edit', 'restricted', NULL),
('core_page_news', 'core_site_header', 'core_site_sidebar', NULL, 'core_site_footer', NULL, NULL, NULL, 'view', 'public', NULL),
('core_page_profile', 'core_site_header', 'core_site_sidebar', 'core_profile_page', 'core_site_footer', NULL, NULL, NULL, 'edit', 'restricted', NULL),
('core_page_profiles', 'core_site_header', 'core_site_sidebar', 'core_profile_list_page', 'core_site_footer', NULL, NULL, NULL, 'edit', 'restricted', NULL),
('core_page_static', 'core_site_header', 'core_site_sidebar', NULL, 'core_site_footer', 'core.page.read', 'core.page.update', NULL, 'view', 'public', 'pages/static.html.twig'),
('core_page_user_confirm', 'core_site_header', 'core_site_sidebar', NULL, 'core_site_footer', NULL, NULL, NULL, 'edit', 'public', NULL),
('core_page_user_login', 'core_site_header', 'core_site_sidebar', 'core_form_user_login', 'core_site_footer', NULL, NULL, NULL, 'edit', 'public', NULL),
('core_page_user_profile', 'core_site_header', 'core_site_sidebar', 'core_user_profile', 'core_site_footer', 'core.actor.read', 'core.actor.update', NULL, 'edit', 'restricted', NULL),
('core_page_user_register', 'core_site_header', 'core_site_sidebar', 'core_form_user_register', 'core_site_footer', NULL, NULL, NULL, 'edit', 'public', NULL),
('core_page_user_reset', 'core_site_header', 'core_site_sidebar', 'core_form_user_reset', 'core_site_footer', NULL, NULL, NULL, 'edit', 'public', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_table`
--

CREATE TABLE `ark_view_table` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` tinyint(1) NOT NULL DEFAULT 1,
  `header` tinyint(1) NOT NULL DEFAULT 1,
  `footer` tinyint(1) NOT NULL DEFAULT 0,
  `sortable` tinyint(1) NOT NULL DEFAULT 1,
  `searchable` tinyint(1) NOT NULL DEFAULT 1,
  `row` tinyint(1) NOT NULL DEFAULT 1,
  `list` tinyint(1) NOT NULL DEFAULT 0,
  `card` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail` tinyint(1) NOT NULL DEFAULT 0,
  `view` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'row',
  `image` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `export` tinyint(1) NOT NULL DEFAULT 1,
  `columns` tinyint(1) NOT NULL DEFAULT 1,
  `pagination` int(11) DEFAULT NULL,
  `selection` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classes` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(2038) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_table`
--

INSERT INTO `ark_view_table` (`element`, `keyword`, `mode`, `caption`, `header`, `footer`, `sortable`, `searchable`, `row`, `list`, `card`, `thumbnail`, `view`, `image`, `export`, `columns`, `pagination`, `selection`, `classes`, `template`, `url`) VALUES
('core_table_actor', NULL, 'view', 0, 1, 0, 1, 1, 1, 0, 1, 0, 'row', 'avatar', 1, 1, NULL, NULL, 'table bootstrap-table table-hover', NULL, NULL),
('core_table_file', NULL, 'view', 0, 1, 0, 1, 1, 1, 0, 1, 0, 'row', NULL, 1, 1, NULL, NULL, 'table bootstrap-table table-hover', NULL, NULL),
('core_table_message', NULL, 'view', 0, 1, 0, 1, 1, 1, 0, 0, 0, 'row', NULL, 1, 1, NULL, NULL, 'table bootstrap-table table-hover', NULL, NULL),
('core_table_profile', 'core.profiles', 'view', 0, 1, 0, 1, 1, 1, 0, 1, 0, 'row', 'avatar', 1, 1, NULL, NULL, 'table bootstrap-table table-hover', NULL, NULL),
('core_table_user', NULL, 'view', 0, 1, 0, 1, 1, 1, 0, 0, 0, 'row', NULL, 1, 1, NULL, 'multiple', 'table bootstrap-table table-hover', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_tree`
--

CREATE TABLE `ark_view_tree` (
  `id` int(11) NOT NULL,
  `ancestor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descendant` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_type`
--

CREATE TABLE `ark_view_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout` tinyint(1) NOT NULL DEFAULT 0,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_type`
--

INSERT INTO `ark_view_type` (`type`, `keyword`, `layout`, `class`, `form_type`, `template`) VALUES
('field', NULL, 0, 'ARK\\View\\Field', 'ARK\\Form\\Type\\SimplePropertyType', 'layouts/field.html.twig'),
('form', NULL, 1, 'ARK\\View\\Form', 'ARK\\Form\\Type\\SimplePropertyType', 'layouts/grid.html.twig'),
('grid', NULL, 1, 'ARK\\View\\Grid', 'ARK\\Form\\Type\\SimplePropertyType', 'layouts/grid.html.twig'),
('nav', NULL, 0, 'ARK\\View\\Nav', NULL, 'blocks/nav.html.twig'),
('page', NULL, 0, 'ARK\\View\\Page', NULL, 'pages/page.html.twig'),
('table', NULL, 1, 'ARK\\View\\Table', 'ARK\\Form\\Type\\SimplePropertyType', 'layouts/table.html.twig'),
('widget', NULL, 0, 'ARK\\View\\Widget', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', 'layouts/widget.html.twig');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_widget`
--

CREATE TABLE `ark_view_widget` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choices` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_widget`
--

INSERT INTO `ark_view_widget` (`element`, `keyword`, `name`, `choices`, `template`, `form_type`, `form_options`) VALUES
('core_widget_button', NULL, 'button', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', ''),
('core_widget_checkbox', NULL, 'checkbox', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', ''),
('core_widget_choice', NULL, 'choice', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', ''),
('core_widget_date', NULL, 'date', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', '{\"widget\": \"single_text\",\"html5\": false, \"attr\": {\"class\": \"datepicker\"}}'),
('core_widget_dateinterval', NULL, 'dateinterval', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateIntervalType', ''),
('core_widget_datetime', NULL, 'datetime', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateTimeType', '{\"widget\": \"single_text\",\"html5\": false, \"attr\": {\"class\": \"datetimepicker\"}}'),
('core_widget_email', 'core.user.email', 'email', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType', ''),
('core_widget_email_confirm', 'core.user.email', 'email', NULL, NULL, 'ARK\\Form\\Type\\RepeatedEmailType', ''),
('core_widget_monthday', NULL, 'monthday', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\BirthdayType', ''),
('core_widget_password', 'core.user.password', '_password', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\PasswordType', ''),
('core_widget_password_confirm', 'core.user.password', 'password', NULL, NULL, 'ARK\\Form\\Type\\RepeatedPasswordType', ''),
('core_widget_selected', NULL, 'selected', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\HiddenType', ''),
('core_widget_static', NULL, 'static', NULL, NULL, 'ARK\\Form\\Type\\StaticType', ''),
('core_widget_submit', 'core.widget.submit', 'submit', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', ''),
('core_widget_submit_recaptcha', 'core.widget.submit', 'submit', NULL, NULL, 'ARK\\Form\\Type\\RecaptchaSubmitType', ''),
('core_widget_terms', NULL, 'terms', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', ''),
('core_widget_textarea', NULL, 'textarea', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', ''),
('core_widget_time', NULL, 'time', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', '{\"widget\": \"single_text\",\"html5\": false, \"attr\": {\"class\": \"timepicker\"}}'),
('core_widget_username', 'core.user.username', '_username', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary`
--

CREATE TABLE `ark_vocabulary` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT 1,
  `transitions` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary`
--

INSERT INTO `ark_vocabulary` (`concept`, `type`, `keyword`, `source`, `closed`, `transitions`, `enabled`, `deprecated`, `description`) VALUES
('core.actor.class', 'list', 'core.actor.class', 'ARK Core', 1, 0, 1, 0, 'Actor Class'),
('core.event.class', 'list', 'core.event.class', 'ARK Core', 1, 0, 1, 0, 'Event Class'),
('core.file.class', 'list', 'core.file.class', 'ARK Core', 1, 0, 1, 0, 'File Class'),
('core.file.status', 'list', 'core.file.status', 'ARK Core', 1, 0, 1, 0, 'File Status'),
('core.form.modus', 'list', 'core.form.mode', 'ARK Core', 1, 0, 1, 0, 'Form field modes'),
('core.item.status', 'list', 'core.item.status', 'ARK Core', 1, 0, 1, 0, 'Item Status'),
('core.license', 'list', 'core.file.class', 'ARK Core', 1, 0, 1, 0, 'File License'),
('core.message.class', 'list', 'core.message.class', 'ARK Core', 1, 0, 1, 0, 'Message Class'),
('core.message.recipient.status', 'list', 'core.message.recipient.status', 'ARK Core', 1, 0, 1, 0, 'Message Recipient Status'),
('core.message.status', 'list', 'core.message.status', 'ARK Core', 1, 0, 1, 0, 'Message Status'),
('core.security.user.status', 'list', 'core.security.user.status', 'ARK Core', 1, 0, 1, 0, 'Security User Status'),
('core.user.terms', 'list', 'core.user.terms', 'ARK Core', 1, 0, 1, 0, 'User Terms and Conditions'),
('core.visibility', 'list', 'core.visibility', 'ARK Core', 1, 0, 1, 0, 'Data Visibility'),
('core.workflow.role', 'list', 'core.workflow.role', 'ARK Core', 1, 0, 1, 0, 'Workflow Roles'),
('country', 'list', 'vocabulary.country', 'ISO3166', 1, 0, 1, 0, 'ISO Country Codes'),
('distance', 'list', 'vocabulary.distance', 'SI', 1, 0, 1, 0, 'SI Distance Units'),
('language', 'list', 'vocabulary.language', 'ISO639', 1, 0, 1, 0, 'ISO Language Codes'),
('mass', 'list', 'vocabulary.mass', 'SI', 1, 0, 1, 0, 'SI Mass Units'),
('mediatype', 'list', 'core.vocabulary.mediatype', 'IANA', 1, 0, 1, 0, 'IANA Mediatypes as defined by RFC'),
('spatial.crs', 'list', 'vocabulary.spatial.crs', 'EPSG', 1, 0, 1, 0, 'Coordinate Reference System'),
('spatial.format', 'list', 'vocabulary.spatial.format', 'ARK Core', 1, 0, 1, 0, 'Spatial data formats');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_parameter`
--

CREATE TABLE `ark_vocabulary_parameter` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_parameter`
--

INSERT INTO `ark_vocabulary_parameter` (`concept`, `term`, `name`, `type`, `value`) VALUES
('core.actor.class', 'institution', 'entity', 'string', 'ARK\\Actor\\Institution'),
('core.actor.class', 'person', 'entity', 'string', 'ARK\\Actor\\Person'),
('core.file.class', 'audio', 'entity', 'string', 'ARK\\File\\Audio'),
('core.file.class', 'document', 'entity', 'string', 'ARK\\File\\Document'),
('core.file.class', 'image', 'entity', 'string', 'ARK\\File\\Image'),
('core.file.class', 'other', 'entity', 'string', 'ARK\\File\\File'),
('core.file.class', 'text', 'entity', 'string', 'ARK\\File\\Text'),
('core.file.class', 'video', 'entity', 'string', 'ARK\\File\\Video'),
('core.license', 'cc0', 'url', 'string', 'https://creativecommons.org/publicdomain/zero/1.0/'),
('core.license', 'ccbyncsa', 'url', 'string', 'https://creativecommons.org/licenses/by-nc-sa/4.0/'),
('core.license', 'ccbysa', 'url', 'string', 'https://creativecommons.org/licenses/by-sa/4.0/'),
('core.message.class', 'mail', 'entity', 'string', 'ARK\\Message\\Mail'),
('core.message.class', 'notification', 'entity', 'string', 'ARK\\Message\\Notification');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_related`
--

CREATE TABLE `ark_vocabulary_related` (
  `from_concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relation` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_related`
--

INSERT INTO `ark_vocabulary_related` (`from_concept`, `from_term`, `to_concept`, `to_term`, `relation`, `parameter`, `depth`) VALUES
('core.item.status', 'allocated', 'core.item.status', 'deleted', 'transition', 'delete', 0),
('core.item.status', 'allocated', 'core.item.status', 'registered', 'transition', 'register', 0),
('core.item.status', 'allocated', 'core.item.status', 'void', 'transition', 'void', 0),
('core.item.status', 'registered', 'core.item.status', 'deleted', 'transition', 'delete', 0),
('core.item.status', 'registered', 'core.item.status', 'void', 'transition', 'void', 0),
('core.item.status', 'void', 'core.item.status', 'allocated', 'transition', 'allocate', 0),
('core.item.status', 'void', 'core.item.status', 'deleted', 'transition', 'delete', 0),
('core.item.status', 'void', 'core.item.status', 'registered', 'transition', 'register', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_relation`
--

CREATE TABLE `ark_vocabulary_relation` (
  `relation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notation` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipricol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipricol_notation` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equivalence` tinyint(1) NOT NULL DEFAULT 0,
  `hierarchy` tinyint(1) NOT NULL DEFAULT 0,
  `associative` tinyint(1) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_relation`
--

INSERT INTO `ark_vocabulary_relation` (`relation`, `notation`, `recipricol`, `recipricol_notation`, `equivalence`, `hierarchy`, `associative`, `description`) VALUES
('broader', 'BT', 'narrower', 'NT', 0, 1, 0, 'The \'Has A\' parent/child hierarchy relationship'),
('class', 'BTI', 'instance', 'NTI', 0, 1, 0, 'The \'Is A\' class/instance hierarchy relationship.'),
('related', 'RT', 'related', 'RT', 0, 0, 1, 'Related terms that are neither equivalent or hierarchical.'),
('sequence', 'RTS', '', '', 0, 0, 1, 'Related terms where one term follows another in a list.'),
('transition', 'RTT', '', '', 0, 0, 1, 'Related terms where one term follows another, i.e. a sequence or change of state.'),
('usedfor', 'UF', 'use', 'U', 1, 0, 0, 'Leads from the preferred entry term to the\\nnon-preferred term(s).'),
('whole', 'BTP', 'part', 'NTP', 0, 1, 0, 'The \'Part Of\' whole/part hierarchy relationship.');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_term`
--

CREATE TABLE `ark_vocabulary_term` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `root` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_term`
--

INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `keyword`, `alias`, `is_default`, `root`, `enabled`, `deprecated`, `description`) VALUES
('core.actor.class', 'institution', 'core.actor.class.institution', '', 0, 0, 1, 0, ''),
('core.actor.class', 'museum', 'core.actor.class.museum', '', 0, 0, 1, 0, ''),
('core.actor.class', 'person', 'core.actor.class.person', '', 0, 0, 1, 0, ''),
('core.event.class', 'accessioned', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'activated', 'core.actor.event.activated', '', 0, 0, 0, 0, ''),
('core.event.class', 'agreed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'annotated', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'appraised', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'approved', 'core.actor.event.approved', '', 0, 0, 0, 0, ''),
('core.event.class', 'assessed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'cancelled', 'core.actor.event.cancelled', '', 0, 0, 0, 0, ''),
('core.event.class', 'cited', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'classified', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'commented', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'conserved', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'contacted', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'dated', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'declined', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'deleted', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'described', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'destroyed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'disagreed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'discarded', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'edited', 'core.event.edited', '', 0, 0, 0, 0, ''),
('core.event.class', 'evaluated', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'exported', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'followed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'identified', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'liked', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'loaned', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'locked', 'core.user', '', 0, 0, 0, 0, ''),
('core.event.class', 'lost', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'notified', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'published', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'received', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'recorded', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'recovered', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'redacted', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'referred', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'registered', 'core.actor.event.registered', '', 0, 0, 0, 0, ''),
('core.event.class', 'rejected', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'released', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'reported', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'requested', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'restored', 'core.actor.event.restored', '', 0, 0, 0, 0, ''),
('core.event.class', 'rewarded', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'sent', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'shared', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'subscribed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'suppressed', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'suspended', 'core.actor.event.suspended', '', 0, 0, 0, 0, ''),
('core.event.class', 'transferred', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'unlocked', 'core.user.agree', '', 0, 0, 0, 0, ''),
('core.event.class', 'validated', NULL, '', 0, 0, 0, 0, ''),
('core.event.class', 'viewed', 'core.event.class.viewed', '', 0, 0, 0, 0, ''),
('core.event.class', 'withdrawn', NULL, '', 0, 0, 0, 0, ''),
('core.file.class', 'audio', 'core.file.class.audio', '', 0, 0, 1, 0, ''),
('core.file.class', 'document', 'core.file.class.document', '', 0, 0, 1, 0, ''),
('core.file.class', 'image', 'core.file.class.image', '', 0, 0, 1, 0, ''),
('core.file.class', 'other', 'core.file.class.other', '', 0, 0, 1, 0, ''),
('core.file.class', 'text', 'core.file.class.text', '', 0, 0, 1, 0, ''),
('core.file.class', 'video', 'core.file.class.video', '', 0, 0, 1, 0, ''),
('core.file.status', 'checkedin', 'core.file.status.checkedin', '', 0, 0, 1, 0, ''),
('core.file.status', 'checkedout', 'core.file.status.checkedout', '', 0, 0, 1, 0, ''),
('core.file.status', 'expired', 'core.file.status.expired', '', 0, 0, 1, 0, ''),
('core.file.status', 'locked', 'core.file.status.locked', '', 0, 0, 1, 0, ''),
('core.file.status', 'new', 'core.file.status.new', '', 0, 0, 1, 0, ''),
('core.form.modus', 'active', 'core.form.mode.active', '', 0, 0, 1, 0, 'Form field is editable.'),
('core.form.modus', 'disabled', 'core.form.mode.disabled', '', 0, 0, 1, 0, 'Form field is Disabled.'),
('core.form.modus', 'hidden', 'core.form.mode.hidden', '', 0, 0, 1, 0, 'Form field is Hidden'),
('core.form.modus', 'readonly', 'core.form.mode.readonly', '', 0, 0, 1, 0, 'Form field is Readonly.'),
('core.form.modus', 'static', 'core.form.mode.static', '', 0, 0, 1, 0, 'Field is displayed but not as a form element.'),
('core.item.status', 'allocated', 'core.item.status.allocated', '', 0, 0, 1, 0, ''),
('core.item.status', 'deleted', 'core.item.status.deleted', '', 0, 0, 1, 0, ''),
('core.item.status', 'registered', 'core.item.status.registered', '', 0, 0, 1, 0, ''),
('core.item.status', 'void', 'core.item.status.void', '', 0, 0, 1, 0, ''),
('core.license', 'cc0', 'core.license.cc0', 'CC0', 0, 0, 1, 0, ''),
('core.license', 'ccbyncsa', 'core.license.ccbyncsa', 'CC BY-NC-SA', 1, 0, 1, 0, ''),
('core.license', 'ccbysa', 'core.license.ccbysa', 'CC BY-SA', 0, 0, 1, 0, ''),
('core.message.class', 'mail', 'core.message.class.mail', '', 0, 0, 1, 0, ''),
('core.message.class', 'notification', 'core.message.class.notification', '', 0, 0, 1, 0, ''),
('core.message.recipient.status', 'discarded', 'core.message.recipient.status.discarded', '', 0, 0, 1, 0, ''),
('core.message.recipient.status', 'read', 'core.message.recipient.status.read', '', 0, 0, 1, 0, ''),
('core.message.recipient.status', 'unread', 'core.message.recipient.status.unread', '', 1, 0, 1, 0, ''),
('core.message.status', 'draft', 'core.message.status.draft', '', 0, 0, 1, 0, ''),
('core.message.status', 'read', 'core.message.status.read', '', 0, 0, 1, 0, ''),
('core.message.status', 'sent', 'core.message.status.sent', '', 0, 0, 1, 0, ''),
('core.security.user.status', 'disabled', 'core.security.user.status.disabled', '', 0, 0, 1, 0, ''),
('core.security.user.status', 'enabled', 'core.security.user.status.enabled', '', 0, 0, 1, 0, ''),
('core.security.user.status', 'expired', 'core.security.user.status.expired', '', 0, 0, 1, 0, ''),
('core.security.user.status', 'locked', 'core.security.user.status.locked', '', 0, 0, 1, 0, ''),
('core.security.user.status', 'registered', 'core.security.user.status.registered', '', 1, 0, 1, 0, ''),
('core.security.user.status', 'verified', 'core.security.user.status.verified', '', 0, 0, 1, 0, ''),
('core.user.terms', 'v1', 'core.user.terms.v1', '', 1, 0, 1, 0, ''),
('core.visibility', 'private', 'core.visibility.private', '', 1, 0, 1, 0, ''),
('core.visibility', 'public', 'core.visibility.public', '', 0, 0, 1, 0, ''),
('core.visibility', 'restricted', 'core.visibility.restricted', '', 0, 0, 1, 0, ''),
('core.workflow.role', 'admin', 'core.workflow.role.admin', '', 0, 0, 1, 0, ''),
('core.workflow.role', 'anonymous', 'core.workflow.role.anon', '', 0, 0, 1, 0, ''),
('core.workflow.role', 'sysadmin', 'core.workflow.role.sysadmin', '', 0, 0, 1, 0, ''),
('core.workflow.role', 'user', 'core.workflow.role.user', '', 0, 0, 1, 0, ''),
('country', 'AD', 'country.andorra', 'andorra', 0, 0, 1, 0, ''),
('country', 'AE', 'country.unitedarabemirates', 'unitedarabemirates', 0, 0, 1, 0, ''),
('country', 'AF', 'country.afghanistan', 'afghanistan', 0, 0, 1, 0, ''),
('country', 'AG', 'country.antigua', 'antigua', 0, 0, 1, 0, ''),
('country', 'AI', 'country.anguilla', 'anguilla', 0, 0, 1, 0, ''),
('country', 'AL', 'country.albania', 'albania', 0, 0, 1, 0, ''),
('country', 'AM', 'country.armenia', 'armenia', 0, 0, 1, 0, ''),
('country', 'AO', 'country.angola', 'angola', 0, 0, 1, 0, ''),
('country', 'AQ', 'country.antarctica', 'antarctica', 0, 0, 1, 0, ''),
('country', 'AR', 'country.argentina', 'argentina', 0, 0, 1, 0, ''),
('country', 'AS', 'country.americansamoa', 'americansamoa', 0, 0, 1, 0, ''),
('country', 'AT', 'country.austria', 'austria', 0, 0, 1, 0, ''),
('country', 'AU', 'country.australia', 'australia', 0, 0, 1, 0, ''),
('country', 'AW', 'country.aruba', 'aruba', 0, 0, 1, 0, ''),
('country', 'AX', 'country.alandislands', 'alandislands', 0, 0, 1, 0, ''),
('country', 'AZ', 'country.azerbaijan', 'azerbaijan', 0, 0, 1, 0, ''),
('country', 'BA', 'country.bosniaherzegovina', 'bosniaherzegovina', 0, 0, 1, 0, ''),
('country', 'BB', 'country.barbados', 'barbados', 0, 0, 1, 0, ''),
('country', 'BD', 'country.bangladesh', 'bangladesh', 0, 0, 1, 0, ''),
('country', 'BE', 'country.belgium', 'belgium', 0, 0, 1, 0, ''),
('country', 'BF', 'country.burkinafaso', 'burkinafaso', 0, 0, 1, 0, ''),
('country', 'BG', 'country.bulgaria', 'bulgaria', 0, 0, 1, 0, ''),
('country', 'BH', 'country.bahrain', 'bahrain', 0, 0, 1, 0, ''),
('country', 'BI', 'country.burundi', 'burundi', 0, 0, 1, 0, ''),
('country', 'BJ', 'country.benin', 'benin', 0, 0, 1, 0, ''),
('country', 'BL', 'country.saintbarthelemy', 'saintbarthelemy', 0, 0, 1, 0, ''),
('country', 'BM', 'country.bermuda', 'bermuda', 0, 0, 1, 0, ''),
('country', 'BN', 'country.brunei', 'brunei', 0, 0, 1, 0, ''),
('country', 'BO', 'country.bolivia', 'bolivia', 0, 0, 1, 0, ''),
('country', 'BQ', 'country.bonaire', 'bonaire', 0, 0, 1, 0, ''),
('country', 'BR', 'country.brazil', 'brazil', 0, 0, 1, 0, ''),
('country', 'BS', 'country.bahamas', 'bahamas', 0, 0, 1, 0, ''),
('country', 'BT', 'country.bhutan', 'bhutan', 0, 0, 1, 0, ''),
('country', 'BW', 'country.botswana', 'botswana', 0, 0, 1, 0, ''),
('country', 'BY', 'country.belarus', 'belarus', 0, 0, 1, 0, ''),
('country', 'BZ', 'country.belize', 'belize', 0, 0, 1, 0, ''),
('country', 'CA', 'country.canada', 'canada', 0, 0, 1, 0, ''),
('country', 'CC', 'country.cocosislands', 'cocosislands', 0, 0, 1, 0, ''),
('country', 'CD', 'country.democraticrepubliccongo', 'democraticrepubliccongo', 0, 0, 1, 0, ''),
('country', 'CF', 'country.centralafricanrepublic', 'centralafricanrepublic', 0, 0, 1, 0, ''),
('country', 'CG', 'country.congo', 'congo', 0, 0, 1, 0, ''),
('country', 'CH', 'country.switzerland', 'switzerland', 0, 0, 1, 0, ''),
('country', 'CI', 'country.cotedivoire', 'cotedivoire', 0, 0, 1, 0, ''),
('country', 'CK', 'country.cookislands', 'cookislands', 0, 0, 1, 0, ''),
('country', 'CL', 'country.chile', 'chile', 0, 0, 1, 0, ''),
('country', 'CM', 'country.cameroon', 'cameroon', 0, 0, 1, 0, ''),
('country', 'CN', 'country.china', 'china', 0, 0, 1, 0, ''),
('country', 'CO', 'country.colombia', 'colombia', 0, 0, 1, 0, ''),
('country', 'CR', 'country.costarica', 'costarica', 0, 0, 1, 0, ''),
('country', 'CU', 'country.cuba', 'cuba', 0, 0, 1, 0, ''),
('country', 'CV', 'country.caboverde', 'caboverde', 0, 0, 1, 0, ''),
('country', 'CW', 'country.curacao', 'curacao', 0, 0, 1, 0, ''),
('country', 'CX', 'country.christmasisland', 'christmasisland', 0, 0, 1, 0, ''),
('country', 'CY', 'country.cyprus', 'cyprus', 0, 0, 1, 0, ''),
('country', 'CZ', 'country.czechrepublic', 'czechrepublic', 0, 0, 1, 0, ''),
('country', 'DE', 'country.germany', 'germany', 0, 0, 1, 0, ''),
('country', 'DJ', 'country.djibouti', 'djibouti', 0, 0, 1, 0, ''),
('country', 'DK', 'country.denmark', 'denmark', 1, 0, 1, 0, ''),
('country', 'DM', 'country.dominica', 'dominica', 0, 0, 1, 0, ''),
('country', 'DO', 'country.dominicanrepublic', 'dominicanrepublic', 0, 0, 1, 0, ''),
('country', 'DZ', 'country.algeria', 'algeria', 0, 0, 1, 0, ''),
('country', 'EC', 'country.ecuador', 'ecuador', 0, 0, 1, 0, ''),
('country', 'EE', 'country.estonia', 'estonia', 0, 0, 1, 0, ''),
('country', 'EG', 'country.egypt', 'egypt', 0, 0, 1, 0, ''),
('country', 'EH', 'country.westernsahara', 'westernsahara', 0, 0, 1, 0, ''),
('country', 'ER', 'country.eritrea', 'eritrea', 0, 0, 1, 0, ''),
('country', 'ES', 'country.spain', 'spain', 0, 0, 1, 0, ''),
('country', 'ET', 'country.ethiopia', 'ethiopia', 0, 0, 1, 0, ''),
('country', 'FI', 'country.finland', 'finland', 0, 0, 1, 0, ''),
('country', 'FJ', 'country.fiji', 'fiji', 0, 0, 1, 0, ''),
('country', 'FK', 'country.falklandislands', 'falklandislands', 0, 0, 1, 0, ''),
('country', 'FM', 'country.micronesia', 'micronesia', 0, 0, 1, 0, ''),
('country', 'FO', 'country.faroeislands', 'faroeislands', 0, 0, 1, 0, ''),
('country', 'FR', 'country.france', 'france', 0, 0, 1, 0, ''),
('country', 'GA', 'country.gabon', 'gabon', 0, 0, 1, 0, ''),
('country', 'GB', 'country.unitedkingdom', 'unitedkingdom', 0, 0, 1, 0, ''),
('country', 'GD', 'country.grenada', 'grenada', 0, 0, 1, 0, ''),
('country', 'GE', 'country.georgia', 'georgia', 0, 0, 1, 0, ''),
('country', 'GF', 'country.frenchguiana', 'frenchguiana', 0, 0, 1, 0, ''),
('country', 'GG', 'country.guernsey', 'guernsey', 0, 0, 1, 0, ''),
('country', 'GH', 'country.ghana', 'ghana', 0, 0, 1, 0, ''),
('country', 'GI', 'country.gibraltar', 'gibraltar', 0, 0, 1, 0, ''),
('country', 'GL', 'country.greenland', 'greenland', 0, 0, 1, 0, ''),
('country', 'GM', 'country.gambia', 'gambia', 0, 0, 1, 0, ''),
('country', 'GN', 'country.guinea', 'guinea', 0, 0, 1, 0, ''),
('country', 'GP', 'country.guadeloupe', 'guadeloupe', 0, 0, 1, 0, ''),
('country', 'GQ', 'country.equatorialguinea', 'equatorialguinea', 0, 0, 1, 0, ''),
('country', 'GR', 'country.greece', 'greece', 0, 0, 1, 0, ''),
('country', 'GS', 'country.southgeorgia', 'southgeorgia', 0, 0, 1, 0, ''),
('country', 'GT', 'country.guatemala', 'guatemala', 0, 0, 1, 0, ''),
('country', 'GU', 'country.guam', 'guam', 0, 0, 1, 0, ''),
('country', 'GW', 'country.guinea-bissau', 'guinea-bissau', 0, 0, 1, 0, ''),
('country', 'GY', 'country.guyana', 'guyana', 0, 0, 1, 0, ''),
('country', 'HK', 'country.hongkong', 'hongkong', 0, 0, 1, 0, ''),
('country', 'HN', 'country.honduras', 'honduras', 0, 0, 1, 0, ''),
('country', 'HR', 'country.croatia', 'croatia', 0, 0, 1, 0, ''),
('country', 'HT', 'country.haiti', 'haiti', 0, 0, 1, 0, ''),
('country', 'HU', 'country.hungary', 'hungary', 0, 0, 1, 0, ''),
('country', 'ID', 'country.indonesia', 'indonesia', 0, 0, 1, 0, ''),
('country', 'IE', 'country.ireland', 'ireland', 0, 0, 1, 0, ''),
('country', 'IL', 'country.israel', 'israel', 0, 0, 1, 0, ''),
('country', 'IM', 'country.isleofman', 'isleofman', 0, 0, 1, 0, ''),
('country', 'IN', 'country.india', 'india', 0, 0, 1, 0, ''),
('country', 'IQ', 'country.iraq', 'iraq', 0, 0, 1, 0, ''),
('country', 'IR', 'country.iran', 'iran', 0, 0, 1, 0, ''),
('country', 'IS', 'country.iceland', 'iceland', 0, 0, 1, 0, ''),
('country', 'IT', 'country.italy', 'italy', 0, 0, 1, 0, ''),
('country', 'JE', 'country.jersey', 'jersey', 0, 0, 1, 0, ''),
('country', 'JM', 'country.jamaica', 'jamaica', 0, 0, 1, 0, ''),
('country', 'JO', 'country.jordan', 'jordan', 0, 0, 1, 0, ''),
('country', 'JP', 'country.japan', 'japan', 0, 0, 1, 0, ''),
('country', 'KE', 'country.kenya', 'kenya', 0, 0, 1, 0, ''),
('country', 'KG', 'country.kyrgyzstan', 'kyrgyzstan', 0, 0, 1, 0, ''),
('country', 'KH', 'country.cambodia', 'cambodia', 0, 0, 1, 0, ''),
('country', 'KI', 'country.kiribati', 'kiribati', 0, 0, 1, 0, ''),
('country', 'KM', 'country.comoros', 'comoros', 0, 0, 1, 0, ''),
('country', 'KN', 'country.saintkitts', 'saintkitts', 0, 0, 1, 0, ''),
('country', 'KP', 'country.northkorea', 'northkorea', 0, 0, 1, 0, ''),
('country', 'KR', 'country.southkorea', 'southkorea', 0, 0, 1, 0, ''),
('country', 'KW', 'country.kuwait', 'kuwait', 0, 0, 1, 0, ''),
('country', 'KY', 'country.caymanislands', 'caymanislands', 0, 0, 1, 0, ''),
('country', 'KZ', 'country.kazakhstan', 'kazakhstan', 0, 0, 1, 0, ''),
('country', 'LA', 'country.lao', 'lao', 0, 0, 1, 0, ''),
('country', 'LB', 'country.lebanon', 'lebanon', 0, 0, 1, 0, ''),
('country', 'LC', 'country.saintlucia', 'saintlucia', 0, 0, 1, 0, ''),
('country', 'LI', 'country.liechtenstein', 'liechtenstein', 0, 0, 1, 0, ''),
('country', 'LK', 'country.srilanka', 'srilanka', 0, 0, 1, 0, ''),
('country', 'LR', 'country.liberia', 'liberia', 0, 0, 1, 0, ''),
('country', 'LS', 'country.lesotho', 'lesotho', 0, 0, 1, 0, ''),
('country', 'LT', 'country.lithuania', 'lithuania', 0, 0, 1, 0, ''),
('country', 'LU', 'country.luxembourg', 'luxembourg', 0, 0, 1, 0, ''),
('country', 'LV', 'country.latvia', 'latvia', 0, 0, 1, 0, ''),
('country', 'LY', 'country.libya', 'libya', 0, 0, 1, 0, ''),
('country', 'MA', 'country.morocco', 'morocco', 0, 0, 1, 0, ''),
('country', 'MC', 'country.monaco', 'monaco', 0, 0, 1, 0, ''),
('country', 'MD', 'country.moldova', 'moldova', 0, 0, 1, 0, ''),
('country', 'ME', 'country.montenegro', 'montenegro', 0, 0, 1, 0, ''),
('country', 'MF', 'country.saintmartin', 'saintmartin', 0, 0, 1, 0, ''),
('country', 'MG', 'country.madagascar', 'madagascar', 0, 0, 1, 0, ''),
('country', 'MH', 'country.marshallislands', 'marshallislands', 0, 0, 1, 0, ''),
('country', 'MK', 'country.macedonia', 'macedonia', 0, 0, 1, 0, ''),
('country', 'ML', 'country.mali', 'mali', 0, 0, 1, 0, ''),
('country', 'MM', 'country.myanmar', 'myanmar', 0, 0, 1, 0, ''),
('country', 'MN', 'country.mongolia', 'mongolia', 0, 0, 1, 0, ''),
('country', 'MO', 'country.macao', 'macao', 0, 0, 1, 0, ''),
('country', 'MP', 'country.northernmarianaislands', 'northernmarianaislands', 0, 0, 1, 0, ''),
('country', 'MQ', 'country.martinique', 'martinique', 0, 0, 1, 0, ''),
('country', 'MR', 'country.mauritania', 'mauritania', 0, 0, 1, 0, ''),
('country', 'MS', 'country.montserrat', 'montserrat', 0, 0, 1, 0, ''),
('country', 'MT', 'country.malta', 'malta', 0, 0, 1, 0, ''),
('country', 'MU', 'country.mauritius', 'mauritius', 0, 0, 1, 0, ''),
('country', 'MV', 'country.maldives', 'maldives', 0, 0, 1, 0, ''),
('country', 'MW', 'country.malawi', 'malawi', 0, 0, 1, 0, ''),
('country', 'MX', 'country.mexico', 'mexico', 0, 0, 1, 0, ''),
('country', 'MY', 'country.malaysia', 'malaysia', 0, 0, 1, 0, ''),
('country', 'MZ', 'country.mozambique', 'mozambique', 0, 0, 1, 0, ''),
('country', 'NA', 'country.namibia', 'namibia', 0, 0, 1, 0, ''),
('country', 'NC', 'country.newcaledonia', 'newcaledonia', 0, 0, 1, 0, ''),
('country', 'NE', 'country.niger', 'niger', 0, 0, 1, 0, ''),
('country', 'NF', 'country.norfolkisland', 'norfolkisland', 0, 0, 1, 0, ''),
('country', 'NG', 'country.nigeria', 'nigeria', 0, 0, 1, 0, ''),
('country', 'NI', 'country.nicaragua', 'nicaragua', 0, 0, 1, 0, ''),
('country', 'NL', 'country.netherlands', 'netherlands', 0, 0, 1, 0, ''),
('country', 'NO', 'country.norway', 'norway', 0, 0, 1, 0, ''),
('country', 'NP', 'country.nepal', 'nepal', 0, 0, 1, 0, ''),
('country', 'NR', 'country.nauru', 'nauru', 0, 0, 1, 0, ''),
('country', 'NU', 'country.niue', 'niue', 0, 0, 1, 0, ''),
('country', 'NZ', 'country.newzealand', 'newzealand', 0, 0, 1, 0, ''),
('country', 'OM', 'country.oman', 'oman', 0, 0, 1, 0, ''),
('country', 'PA', 'country.panama', 'panama', 0, 0, 1, 0, ''),
('country', 'PE', 'country.peru', 'peru', 0, 0, 1, 0, ''),
('country', 'PF', 'country.frenchpolynesia', 'frenchpolynesia', 0, 0, 1, 0, ''),
('country', 'PG', 'country.papuanewguinea', 'papuanewguinea', 0, 0, 1, 0, ''),
('country', 'PH', 'country.philippines', 'philippines', 0, 0, 1, 0, ''),
('country', 'PK', 'country.pakistan', 'pakistan', 0, 0, 1, 0, ''),
('country', 'PL', 'country.poland', 'poland', 0, 0, 1, 0, ''),
('country', 'PM', 'country.saintpierremiquelon', 'saintpierremiquelon', 0, 0, 1, 0, ''),
('country', 'PN', 'country.pitcairn', 'pitcairn', 0, 0, 1, 0, ''),
('country', 'PR', 'country.puertorico', 'puertorico', 0, 0, 1, 0, ''),
('country', 'PS', 'country.palestine', 'palestine', 0, 0, 1, 0, ''),
('country', 'PT', 'country.portugal', 'portugal', 0, 0, 1, 0, ''),
('country', 'PW', 'country.palau', 'palau', 0, 0, 1, 0, ''),
('country', 'PY', 'country.paraguay', 'paraguay', 0, 0, 1, 0, ''),
('country', 'QA', 'country.qatar', 'qatar', 0, 0, 1, 0, ''),
('country', 'RE', 'country.reunion', 'reunion', 0, 0, 1, 0, ''),
('country', 'RO', 'country.romania', 'romania', 0, 0, 1, 0, ''),
('country', 'RS', 'country.serbia', 'serbia', 0, 0, 1, 0, ''),
('country', 'RU', 'country.russia', 'russia', 0, 0, 1, 0, ''),
('country', 'RW', 'country.rwanda', 'rwanda', 0, 0, 1, 0, ''),
('country', 'SA', 'country.saudiarabia', 'saudiarabia', 0, 0, 1, 0, ''),
('country', 'SB', 'country.solomonislands', 'solomonislands', 0, 0, 1, 0, ''),
('country', 'SC', 'country.seychelles', 'seychelles', 0, 0, 1, 0, ''),
('country', 'SD', 'country.sudan', 'sudan', 0, 0, 1, 0, ''),
('country', 'SE', 'country.sweden', 'sweden', 0, 0, 1, 0, ''),
('country', 'SG', 'country.singapore', 'singapore', 0, 0, 1, 0, ''),
('country', 'SH', 'country.sainthelena', 'sainthelena', 0, 0, 1, 0, ''),
('country', 'SI', 'country.slovenia', 'slovenia', 0, 0, 1, 0, ''),
('country', 'SJ', 'country.svalbard', 'svalbard', 0, 0, 1, 0, ''),
('country', 'SK', 'country.slovakia', 'slovakia', 0, 0, 1, 0, ''),
('country', 'SL', 'country.sierraleone', 'sierraleone', 0, 0, 1, 0, ''),
('country', 'SM', 'country.sanmarino', 'sanmarino', 0, 0, 1, 0, ''),
('country', 'SN', 'country.senegal', 'senegal', 0, 0, 1, 0, ''),
('country', 'SO', 'country.somalia', 'somalia', 0, 0, 1, 0, ''),
('country', 'SR', 'country.suriname', 'suriname', 0, 0, 1, 0, ''),
('country', 'SS', 'country.southsudan', 'southsudan', 0, 0, 1, 0, ''),
('country', 'ST', 'country.saotome', 'saotome', 0, 0, 1, 0, ''),
('country', 'SV', 'country.elsalvador', 'elsalvador', 0, 0, 1, 0, ''),
('country', 'SX', 'country.sintmaarten', 'sintmaarten', 0, 0, 1, 0, ''),
('country', 'SY', 'country.syria', 'syria', 0, 0, 1, 0, ''),
('country', 'SZ', 'country.swaziland', 'swaziland', 0, 0, 1, 0, ''),
('country', 'TC', 'country.turkscaicos', 'turkscaicos', 0, 0, 1, 0, ''),
('country', 'TD', 'country.chad', 'chad', 0, 0, 1, 0, ''),
('country', 'TG', 'country.togo', 'togo', 0, 0, 1, 0, ''),
('country', 'TH', 'country.thailand', 'thailand', 0, 0, 1, 0, ''),
('country', 'TJ', 'country.tajikistan', 'tajikistan', 0, 0, 1, 0, ''),
('country', 'TK', 'country.tokelau', 'tokelau', 0, 0, 1, 0, ''),
('country', 'TL', 'country.timorleste', 'timorleste', 0, 0, 1, 0, ''),
('country', 'TM', 'country.turkmenistan', 'turkmenistan', 0, 0, 1, 0, ''),
('country', 'TN', 'country.tunisia', 'tunisia', 0, 0, 1, 0, ''),
('country', 'TO', 'country.tonga', 'tonga', 0, 0, 1, 0, ''),
('country', 'TR', 'country.turkey', 'turkey', 0, 0, 1, 0, ''),
('country', 'TT', 'country.trinidadtobago', 'trinidadtobago', 0, 0, 1, 0, ''),
('country', 'TV', 'country.tuvalu', 'tuvalu', 0, 0, 1, 0, ''),
('country', 'TW', 'country.taiwan', 'taiwan', 0, 0, 1, 0, ''),
('country', 'TZ', 'country.tanzania', 'tanzania', 0, 0, 1, 0, ''),
('country', 'UA', 'country.ukraine', 'ukraine', 0, 0, 1, 0, ''),
('country', 'UG', 'country.uganda', 'uganda', 0, 0, 1, 0, ''),
('country', 'US', 'country.unitedstatesamerica', 'unitedstatesamerica', 0, 0, 1, 0, ''),
('country', 'UY', 'country.uruguay', 'uruguay', 0, 0, 1, 0, ''),
('country', 'UZ', 'country.uzbekistan', 'uzbekistan', 0, 0, 1, 0, ''),
('country', 'VA', 'country.vatican', 'vatican', 0, 0, 1, 0, ''),
('country', 'VC', 'country.saintvincent', 'saintvincent', 0, 0, 1, 0, ''),
('country', 'VE', 'country.venezuela', 'venezuela', 0, 0, 1, 0, ''),
('country', 'VG', 'country.britishvirginislands', 'britishvirginislands', 0, 0, 1, 0, ''),
('country', 'VI', 'country.usvirginislands', 'usvirginislands', 0, 0, 1, 0, ''),
('country', 'VN', 'country.vietnam', 'vietnam', 0, 0, 1, 0, ''),
('country', 'VU', 'country.vanuatu', 'vanuatu', 0, 0, 1, 0, ''),
('country', 'WF', 'country.wallisfutuna', 'wallisfutuna', 0, 0, 1, 0, ''),
('country', 'WS', 'country.samoa', 'samoa', 0, 0, 1, 0, ''),
('country', 'YE', 'country.yemen', 'yemen', 0, 0, 1, 0, ''),
('country', 'YT', 'country.mayotte', 'mayotte', 0, 0, 1, 0, ''),
('country', 'ZA', 'country.southafrica', 'southafrica', 0, 0, 1, 0, ''),
('country', 'ZM', 'country.zambia', 'zambia', 0, 0, 1, 0, ''),
('country', 'ZW', 'country.zimbabwe', 'zimbabwe', 0, 0, 1, 0, ''),
('distance', 'km', 'length.kilometre', 'kilometre', 0, 0, 1, 0, ''),
('distance', 'm', 'length.metre', 'metre', 0, 0, 1, 0, ''),
('distance', 'mm', 'length.millimetre', 'millimetre', 1, 0, 1, 0, ''),
('distance', 'nm', 'length.nanometre', 'nanometre', 0, 0, 1, 0, ''),
('distance', 'µm', 'length.micrometre', 'nanometre', 0, 0, 1, 0, ''),
('language', 'aa', 'language.afar', 'afar', 0, 0, 1, 0, ''),
('language', 'ab', 'language.abkhazian', 'abkhazian', 0, 0, 1, 0, ''),
('language', 'ace', 'language.achinese', 'achinese', 0, 0, 1, 0, ''),
('language', 'ach', 'language.acoli', 'acoli', 0, 0, 1, 0, ''),
('language', 'ada', 'language.adangme', 'adangme', 0, 0, 1, 0, ''),
('language', 'ady', 'language.adyghe', 'adyghe', 0, 0, 1, 0, ''),
('language', 'ae', 'language.avestan', 'avestan', 0, 0, 1, 0, ''),
('language', 'aeb', 'language.arabic.tunisian', 'arabic.tunisian', 0, 0, 1, 0, ''),
('language', 'af', 'language.afrikaans', 'afrikaans', 0, 0, 1, 0, ''),
('language', 'afh', 'language.afrihili', 'afrihili', 0, 0, 1, 0, ''),
('language', 'agq', 'language.aghem', 'aghem', 0, 0, 1, 0, ''),
('language', 'ain', 'language.ainu', 'ainu', 0, 0, 1, 0, ''),
('language', 'ak', 'language.akan', 'akan', 0, 0, 1, 0, ''),
('language', 'akk', 'language.akkadian', 'akkadian', 0, 0, 1, 0, ''),
('language', 'akz', 'language.alabama', 'alabama', 0, 0, 1, 0, ''),
('language', 'ale', 'language.aleut', 'aleut', 0, 0, 1, 0, ''),
('language', 'aln', 'language.albanian.gheg', 'albanian.gheg', 0, 0, 1, 0, ''),
('language', 'alt', 'language.altai.southern', 'altai.southern', 0, 0, 1, 0, ''),
('language', 'am', 'language.amharic', 'amharic', 0, 0, 1, 0, ''),
('language', 'an', 'language.aragonese', 'aragonese', 0, 0, 1, 0, ''),
('language', 'ang', 'language.english.old', 'english.old', 0, 0, 1, 0, ''),
('language', 'anp', 'language.angika', 'angika', 0, 0, 1, 0, ''),
('language', 'ar', 'language.arabic', 'arabic', 0, 0, 1, 0, ''),
('language', 'ar-001', 'language.arabic.modern', 'arabic.modern', 0, 0, 1, 0, ''),
('language', 'arc', 'language.aramaic', 'aramaic', 0, 0, 1, 0, ''),
('language', 'arn', 'language.mapuche', 'mapuche', 0, 0, 1, 0, ''),
('language', 'aro', 'language.araona', 'araona', 0, 0, 1, 0, ''),
('language', 'arp', 'language.arapaho', 'arapaho', 0, 0, 1, 0, ''),
('language', 'arq', 'language.arabic.algerian', 'arabic.algerian', 0, 0, 1, 0, ''),
('language', 'arw', 'language.arawak', 'arawak', 0, 0, 1, 0, ''),
('language', 'ary', 'language.arabic.moroccan', 'arabic.moroccan', 0, 0, 1, 0, ''),
('language', 'arz', 'language.arabic.egyptian', 'arabic.egyptian', 0, 0, 1, 0, ''),
('language', 'as', 'language.assamese', 'assamese', 0, 0, 1, 0, ''),
('language', 'asa', 'language.asu', 'asu', 0, 0, 1, 0, ''),
('language', 'ast', 'language.asturian', 'asturian', 0, 0, 1, 0, ''),
('language', 'av', 'language.avaric', 'avaric', 0, 0, 1, 0, ''),
('language', 'avk', 'language.kotava', 'kotava', 0, 0, 1, 0, ''),
('language', 'awa', 'language.awadhi', 'awadhi', 0, 0, 1, 0, ''),
('language', 'ay', 'language.aymara', 'aymara', 0, 0, 1, 0, ''),
('language', 'az', 'language.azerbaijani', 'azerbaijani', 0, 0, 1, 0, ''),
('language', 'ba', 'language.bashkir', 'bashkir', 0, 0, 1, 0, ''),
('language', 'bal', 'language.baluchi', 'baluchi', 0, 0, 1, 0, ''),
('language', 'ban', 'language.balinese', 'balinese', 0, 0, 1, 0, ''),
('language', 'bar', 'language.bavarian', 'bavarian', 0, 0, 1, 0, ''),
('language', 'bas', 'language.basaa', 'basaa', 0, 0, 1, 0, ''),
('language', 'bax', 'language.bamun', 'bamun', 0, 0, 1, 0, ''),
('language', 'bbc', 'language.bataktoba', 'bataktoba', 0, 0, 1, 0, ''),
('language', 'bbj', 'language.ghomala', 'ghomala', 0, 0, 1, 0, ''),
('language', 'be', 'language.belarusian', 'belarusian', 0, 0, 1, 0, ''),
('language', 'bej', 'language.beja', 'beja', 0, 0, 1, 0, ''),
('language', 'bem', 'language.bemba', 'bemba', 0, 0, 1, 0, ''),
('language', 'bew', 'language.betawi', 'betawi', 0, 0, 1, 0, ''),
('language', 'bez', 'language.bena', 'bena', 0, 0, 1, 0, ''),
('language', 'bfd', 'language.bafut', 'bafut', 0, 0, 1, 0, ''),
('language', 'bfq', 'language.badaga', 'badaga', 0, 0, 1, 0, ''),
('language', 'bg', 'language.bulgarian', 'bulgarian', 0, 0, 1, 0, ''),
('language', 'bgn', 'language.balochi.western', 'balochi.western', 0, 0, 1, 0, ''),
('language', 'bho', 'language.bhojpuri', 'bhojpuri', 0, 0, 1, 0, ''),
('language', 'bi', 'language.bislama', 'bislama', 0, 0, 1, 0, ''),
('language', 'bik', 'language.bikol', 'bikol', 0, 0, 1, 0, ''),
('language', 'bin', 'language.bini', 'bini', 0, 0, 1, 0, ''),
('language', 'bjn', 'language.banjar', 'banjar', 0, 0, 1, 0, ''),
('language', 'bkm', 'language.kom', 'kom', 0, 0, 1, 0, ''),
('language', 'bla', 'language.siksika', 'siksika', 0, 0, 1, 0, ''),
('language', 'bm', 'language.bambara', 'bambara', 0, 0, 1, 0, ''),
('language', 'bn', 'language.bengali', 'bengali', 0, 0, 1, 0, ''),
('language', 'bo', 'language.tibetan', 'tibetan', 0, 0, 1, 0, ''),
('language', 'bpy', 'language.bishnupriya', 'bishnupriya', 0, 0, 1, 0, ''),
('language', 'bqi', 'language.bakhtiari', 'bakhtiari', 0, 0, 1, 0, ''),
('language', 'br', 'language.breton', 'breton', 0, 0, 1, 0, ''),
('language', 'bra', 'language.braj', 'braj', 0, 0, 1, 0, ''),
('language', 'brh', 'language.brahui', 'brahui', 0, 0, 1, 0, ''),
('language', 'brx', 'language.bodo', 'bodo', 0, 0, 1, 0, ''),
('language', 'bs', 'language.bosnian', 'bosnian', 0, 0, 1, 0, ''),
('language', 'bss', 'language.akoose', 'akoose', 0, 0, 1, 0, ''),
('language', 'bua', 'language.buriat', 'buriat', 0, 0, 1, 0, ''),
('language', 'bug', 'language.buginese', 'buginese', 0, 0, 1, 0, ''),
('language', 'bum', 'language.bulu', 'bulu', 0, 0, 1, 0, ''),
('language', 'byn', 'language.blin', 'blin', 0, 0, 1, 0, ''),
('language', 'byv', 'language.medumba', 'medumba', 0, 0, 1, 0, ''),
('language', 'ca', 'language.catalan', 'catalan', 0, 0, 1, 0, ''),
('language', 'cad', 'language.caddo', 'caddo', 0, 0, 1, 0, ''),
('language', 'car', 'language.carib', 'carib', 0, 0, 1, 0, ''),
('language', 'cay', 'language.cayuga', 'cayuga', 0, 0, 1, 0, ''),
('language', 'cch', 'language.atsam', 'atsam', 0, 0, 1, 0, ''),
('language', 'ce', 'language.chechen', 'chechen', 0, 0, 1, 0, ''),
('language', 'ceb', 'language.cebuano', 'cebuano', 0, 0, 1, 0, ''),
('language', 'cgg', 'language.chiga', 'chiga', 0, 0, 1, 0, ''),
('language', 'ch', 'language.chamorro', 'chamorro', 0, 0, 1, 0, ''),
('language', 'chb', 'language.chibcha', 'chibcha', 0, 0, 1, 0, ''),
('language', 'chg', 'language.chagatai', 'chagatai', 0, 0, 1, 0, ''),
('language', 'chk', 'language.chuukese', 'chuukese', 0, 0, 1, 0, ''),
('language', 'chm', 'language.mari', 'mari', 0, 0, 1, 0, ''),
('language', 'chn', 'language.jargon.chinook', 'jargon.chinook', 0, 0, 1, 0, ''),
('language', 'cho', 'language.choctaw', 'choctaw', 0, 0, 1, 0, ''),
('language', 'chp', 'language.chipewyan', 'chipewyan', 0, 0, 1, 0, ''),
('language', 'chr', 'language.cherokee', 'cherokee', 0, 0, 1, 0, ''),
('language', 'chy', 'language.cheyenne', 'cheyenne', 0, 0, 1, 0, ''),
('language', 'ckb', 'language.kurdish.central', 'kurdish.central', 0, 0, 1, 0, ''),
('language', 'co', 'language.corsican', 'corsican', 0, 0, 1, 0, ''),
('language', 'cop', 'language.coptic', 'coptic', 0, 0, 1, 0, ''),
('language', 'cps', 'language.capiznon', 'capiznon', 0, 0, 1, 0, ''),
('language', 'cr', 'language.cree', 'cree', 0, 0, 1, 0, ''),
('language', 'crh', 'language.turkish.crimean', 'turkish.crimean', 0, 0, 1, 0, ''),
('language', 'cs', 'language.czech', 'czech', 0, 0, 1, 0, ''),
('language', 'csb', 'language.kashubian', 'kashubian', 0, 0, 1, 0, ''),
('language', 'cu', 'language.slavic.church', 'slavic.church', 0, 0, 1, 0, ''),
('language', 'cv', 'language.chuvash', 'chuvash', 0, 0, 1, 0, ''),
('language', 'cy', 'language.welsh', 'welsh', 0, 0, 1, 0, ''),
('language', 'da', 'language.danish', 'danish', 0, 0, 1, 0, ''),
('language', 'dak', 'language.dakota', 'dakota', 0, 0, 1, 0, ''),
('language', 'dar', 'language.dargwa', 'dargwa', 0, 0, 1, 0, ''),
('language', 'dav', 'language.taita', 'taita', 0, 0, 1, 0, ''),
('language', 'de', 'language.german', 'german', 0, 0, 1, 0, ''),
('language', 'de-AT', 'language.german.austrian', 'german.austrian', 0, 0, 1, 0, ''),
('language', 'de-CH', 'language.german.swisshigh', 'german.swisshigh', 0, 0, 1, 0, ''),
('language', 'del', 'language.delaware', 'delaware', 0, 0, 1, 0, ''),
('language', 'den', 'language.slave', 'slave', 0, 0, 1, 0, ''),
('language', 'dgr', 'language.dogrib', 'dogrib', 0, 0, 1, 0, ''),
('language', 'din', 'language.dinka', 'dinka', 0, 0, 1, 0, ''),
('language', 'dje', 'language.zarma', 'zarma', 0, 0, 1, 0, ''),
('language', 'doi', 'language.dogri', 'dogri', 0, 0, 1, 0, ''),
('language', 'dsb', 'language.sorbian.lower', 'sorbian.lower', 0, 0, 1, 0, ''),
('language', 'dtp', 'language.dusun.central', 'dusun.central', 0, 0, 1, 0, ''),
('language', 'dua', 'language.duala', 'duala', 0, 0, 1, 0, ''),
('language', 'dum', 'language.dutch.middle', 'dutch.middle', 0, 0, 1, 0, ''),
('language', 'dv', 'language.divehi', 'divehi', 0, 0, 1, 0, ''),
('language', 'dyo', 'language.jolafonyi', 'jolafonyi', 0, 0, 1, 0, ''),
('language', 'dyu', 'language.dyula', 'dyula', 0, 0, 1, 0, ''),
('language', 'dz', 'language.dzongkha', 'dzongkha', 0, 0, 1, 0, ''),
('language', 'dzg', 'language.dazaga', 'dazaga', 0, 0, 1, 0, ''),
('language', 'ebu', 'language.embu', 'embu', 0, 0, 1, 0, ''),
('language', 'ee', 'language.ewe', 'ewe', 0, 0, 1, 0, ''),
('language', 'efi', 'language.efik', 'efik', 0, 0, 1, 0, ''),
('language', 'egl', 'language.emilian', 'emilian', 0, 0, 1, 0, ''),
('language', 'egy', 'language.egyptian.ancient', 'egyptian.ancient', 0, 0, 1, 0, ''),
('language', 'eka', 'language.ekajuk', 'ekajuk', 0, 0, 1, 0, ''),
('language', 'el', 'language.greek', 'greek', 0, 0, 1, 0, ''),
('language', 'elx', 'language.elamite', 'elamite', 0, 0, 1, 0, ''),
('language', 'en', 'language.english', 'english', 0, 0, 1, 0, ''),
('language', 'en-AU', 'language.english.australian', 'english.australian', 0, 0, 1, 0, ''),
('language', 'en-CA', 'language.english.canadian', 'english.canadian', 0, 0, 1, 0, ''),
('language', 'en-GB', 'language.english.british', 'english.british', 0, 0, 1, 0, ''),
('language', 'en-US', 'language.english.american', 'english.american', 0, 0, 1, 0, ''),
('language', 'enm', 'language.english.middle', 'english.middle', 0, 0, 1, 0, ''),
('language', 'eo', 'language.esperanto', 'esperanto', 0, 0, 1, 0, ''),
('language', 'es', 'language.spanish', 'spanish', 0, 0, 1, 0, ''),
('language', 'es-419', 'Language.spanish.latinamerican', 'spanish.latinamerican', 0, 0, 1, 0, ''),
('language', 'es-ES', 'language.spanish.european', 'spanish.european', 0, 0, 1, 0, ''),
('language', 'es-MX', 'language.spanish.mexican', 'spanish.mexican', 0, 0, 1, 0, ''),
('language', 'esu', 'language.yupik.central', 'yupik.central', 0, 0, 1, 0, ''),
('language', 'et', 'language.estonian', 'estonian', 0, 0, 1, 0, ''),
('language', 'eu', 'language.basque', 'basque', 0, 0, 1, 0, ''),
('language', 'ewo', 'language.ewondo', 'ewondo', 0, 0, 1, 0, ''),
('language', 'ext', 'language.extremaduran', 'extremaduran', 0, 0, 1, 0, ''),
('language', 'fa', 'language.persian', 'persian', 0, 0, 1, 0, ''),
('language', 'fan', 'language.fang', 'fang', 0, 0, 1, 0, ''),
('language', 'fat', 'language.fanti', 'fanti', 0, 0, 1, 0, ''),
('language', 'ff', 'language.fulah', 'fulah', 0, 0, 1, 0, ''),
('language', 'fi', 'language.finnish', 'finnish', 0, 0, 1, 0, ''),
('language', 'fil', 'language.filipino', 'filipino', 0, 0, 1, 0, ''),
('language', 'fit', 'language.finnish.tornedalen', 'finnish.tornedalen', 0, 0, 1, 0, ''),
('language', 'fj', 'language.fijian', 'fijian', 0, 0, 1, 0, ''),
('language', 'fo', 'language.faroese', 'faroese', 0, 0, 1, 0, ''),
('language', 'fon', 'language.fon', 'fon', 0, 0, 1, 0, ''),
('language', 'fr', 'language.french', 'french', 0, 0, 1, 0, ''),
('language', 'fr-CA', 'language.french.canadian', 'french.canadian', 0, 0, 1, 0, ''),
('language', 'fr-CH', 'language.french.swiss', 'french.swiss', 0, 0, 1, 0, ''),
('language', 'frc', 'language.french.cajun', 'french.cajun', 0, 0, 1, 0, ''),
('language', 'frm', 'language.french.middle', 'french.middle', 0, 0, 1, 0, ''),
('language', 'fro', 'language.french.old', 'french.old', 0, 0, 1, 0, ''),
('language', 'frp', 'language.arpitan', 'arpitan', 0, 0, 1, 0, ''),
('language', 'frr', 'language.frisian.northern', 'frisian.northern', 0, 0, 1, 0, ''),
('language', 'frs', 'language.frisian.eastern', 'frisian.eastern', 0, 0, 1, 0, ''),
('language', 'fur', 'language.friulian', 'friulian', 0, 0, 1, 0, ''),
('language', 'fy', 'language.frisian.western', 'frisian.western', 0, 0, 1, 0, ''),
('language', 'ga', 'language.irish', 'irish', 0, 0, 1, 0, ''),
('language', 'gaa', 'language.ga', 'ga', 0, 0, 1, 0, ''),
('language', 'gag', 'language.gagauz', 'gagauz', 0, 0, 1, 0, ''),
('language', 'gan', 'language.chinese.gan', 'chinese.gan', 0, 0, 1, 0, ''),
('language', 'gay', 'language.gayo', 'gayo', 0, 0, 1, 0, ''),
('language', 'gba', 'language.gbaya', 'gbaya', 0, 0, 1, 0, ''),
('language', 'gbz', 'language.dari.zoroastrian', 'dari.zoroastrian', 0, 0, 1, 0, ''),
('language', 'gd', 'language.gaelic.scottish', 'gaelic.scottish', 0, 0, 1, 0, ''),
('language', 'gez', 'language.geez', 'geez', 0, 0, 1, 0, ''),
('language', 'gil', 'language.gilbertese', 'gilbertese', 0, 0, 1, 0, ''),
('language', 'gl', 'language.galician', 'galician', 0, 0, 1, 0, ''),
('language', 'glk', 'language.gilaki', 'gilaki', 0, 0, 1, 0, ''),
('language', 'gmh', 'language.german.middlehigh', 'german.middlehigh', 0, 0, 1, 0, ''),
('language', 'gn', 'language.guarani', 'guarani', 0, 0, 1, 0, ''),
('language', 'goh', 'language.german.oldhigh', 'german.oldhigh', 0, 0, 1, 0, ''),
('language', 'gom', 'language.konkani.goan', 'konkani.goan', 0, 0, 1, 0, ''),
('language', 'gon', 'language.gondi', 'gondi', 0, 0, 1, 0, ''),
('language', 'gor', 'language.gorontalo', 'gorontalo', 0, 0, 1, 0, ''),
('language', 'got', 'language.gothic', 'gothic', 0, 0, 1, 0, ''),
('language', 'grb', 'language.grebo', 'grebo', 0, 0, 1, 0, ''),
('language', 'grc', 'language.greek.ancient', 'greek.ancient', 0, 0, 1, 0, ''),
('language', 'gsw', 'language.german.swiss', 'german.swiss', 0, 0, 1, 0, ''),
('language', 'gu', 'language.gujarati', 'gujarati', 0, 0, 1, 0, ''),
('language', 'guc', 'language.wayuu', 'wayuu', 0, 0, 1, 0, ''),
('language', 'gur', 'language.frafra', 'frafra', 0, 0, 1, 0, ''),
('language', 'guz', 'language.gusii', 'gusii', 0, 0, 1, 0, ''),
('language', 'gv', 'language.manx', 'manx', 0, 0, 1, 0, ''),
('language', 'gwi', 'language.gwichin', 'gwichin', 0, 0, 1, 0, ''),
('language', 'ha', 'language.hausa', 'hausa', 0, 0, 1, 0, ''),
('language', 'hai', 'language.haida', 'haida', 0, 0, 1, 0, ''),
('language', 'hak', 'language.chinese.hakka', 'chinese.hakka', 0, 0, 1, 0, ''),
('language', 'haw', 'language.hawaiian', 'hawaiian', 0, 0, 1, 0, ''),
('language', 'he', 'language.hebrew', 'hebrew', 0, 0, 1, 0, ''),
('language', 'hi', 'language.hindi', 'hindi', 0, 0, 1, 0, ''),
('language', 'hif', 'language.hindi.fiji', 'hindi.fiji', 0, 0, 1, 0, ''),
('language', 'hil', 'language.hiligaynon', 'hiligaynon', 0, 0, 1, 0, ''),
('language', 'hit', 'language.hittite', 'hittite', 0, 0, 1, 0, ''),
('language', 'hmn', 'language.hmong', 'hmong', 0, 0, 1, 0, ''),
('language', 'ho', 'language.motu.hiri', 'motu.hiri', 0, 0, 1, 0, ''),
('language', 'hr', 'language.croatian', 'croatian', 0, 0, 1, 0, ''),
('language', 'hsb', 'language.sorbian.upper', 'sorbian.upper', 0, 0, 1, 0, ''),
('language', 'hsn', 'language.chinese.xiang', 'chinese.xiang', 0, 0, 1, 0, ''),
('language', 'ht', 'language.creole.haitian', 'creole.haitian', 0, 0, 1, 0, ''),
('language', 'hu', 'language.hungarian', 'hungarian', 0, 0, 1, 0, ''),
('language', 'hup', 'language.hupa', 'hupa', 0, 0, 1, 0, ''),
('language', 'hy', 'language.armenian', 'armenian', 0, 0, 1, 0, ''),
('language', 'hz', 'language.herero', 'herero', 0, 0, 1, 0, ''),
('language', 'ia', 'language.interlingua', 'interlingua', 0, 0, 1, 0, ''),
('language', 'iba', 'language.iban', 'iban', 0, 0, 1, 0, ''),
('language', 'ibb', 'language.ibibio', 'ibibio', 0, 0, 1, 0, ''),
('language', 'id', 'language.indonesian', 'indonesian', 0, 0, 1, 0, ''),
('language', 'ie', 'language.interlingue', 'interlingue', 0, 0, 1, 0, ''),
('language', 'ig', 'language.igbo', 'igbo', 0, 0, 1, 0, ''),
('language', 'ii', 'language.yi.sichuan', 'yi.sichuan', 0, 0, 1, 0, ''),
('language', 'ik', 'language.inupiaq', 'inupiaq', 0, 0, 1, 0, ''),
('language', 'ilo', 'language.iloko', 'iloko', 0, 0, 1, 0, ''),
('language', 'inh', 'language.ingush', 'ingush', 0, 0, 1, 0, ''),
('language', 'io', 'language.ido', 'ido', 0, 0, 1, 0, ''),
('language', 'is', 'language.icelandic', 'icelandic', 0, 0, 1, 0, ''),
('language', 'it', 'language.italian', 'italian', 0, 0, 1, 0, ''),
('language', 'iu', 'language.inuktitut', 'inuktitut', 0, 0, 1, 0, ''),
('language', 'izh', 'language.ingrian', 'ingrian', 0, 0, 1, 0, ''),
('language', 'ja', 'language.japanese', 'japanese', 0, 0, 1, 0, ''),
('language', 'jam', 'language.english.jamaicancreole ', 'english.jamaicancreole ', 0, 0, 1, 0, ''),
('language', 'jbo', 'language.lojban', 'lojban', 0, 0, 1, 0, ''),
('language', 'jgo', 'language.ngomba', 'ngomba', 0, 0, 1, 0, ''),
('language', 'jmc', 'language.machame', 'machame', 0, 0, 1, 0, ''),
('language', 'jpr', 'language.judeopersian', 'judeopersian', 0, 0, 1, 0, ''),
('language', 'jrb', 'language.judeoarabic', 'judeoarabic', 0, 0, 1, 0, ''),
('language', 'jut', 'language.jutish', 'jutish', 0, 0, 1, 0, ''),
('language', 'jv', 'language.javanese', 'javanese', 0, 0, 1, 0, ''),
('language', 'ka', 'language.georgian', 'georgian', 0, 0, 1, 0, ''),
('language', 'kaa', 'language.karakalpak', 'karakalpak', 0, 0, 1, 0, ''),
('language', 'kab', 'language.kabyle', 'kabyle', 0, 0, 1, 0, ''),
('language', 'kac', 'language.kachin', 'kachin', 0, 0, 1, 0, ''),
('language', 'kaj', 'language.jju', 'jju', 0, 0, 1, 0, ''),
('language', 'kam', 'language.kamba', 'kamba', 0, 0, 1, 0, ''),
('language', 'kaw', 'language.kawi', 'kawi', 0, 0, 1, 0, ''),
('language', 'kbd', 'language.kabardian', 'kabardian', 0, 0, 1, 0, ''),
('language', 'kbl', 'language.kanembu', 'kanembu', 0, 0, 1, 0, ''),
('language', 'kcg', 'language.tyap', 'tyap', 0, 0, 1, 0, ''),
('language', 'kde', 'language.makonde', 'makonde', 0, 0, 1, 0, ''),
('language', 'kea', 'language.kabuverdianu', 'kabuverdianu', 0, 0, 1, 0, ''),
('language', 'ken', 'language.kenyang', 'kenyang', 0, 0, 1, 0, ''),
('language', 'kfo', 'language.koro', 'koro', 0, 0, 1, 0, ''),
('language', 'kg', 'language.kongo', 'kongo', 0, 0, 1, 0, ''),
('language', 'kgp', 'language.kaingang', 'kaingang', 0, 0, 1, 0, ''),
('language', 'kha', 'language.khasi', 'khasi', 0, 0, 1, 0, ''),
('language', 'kho', 'language.khotanese', 'khotanese', 0, 0, 1, 0, ''),
('language', 'khq', 'language.chiini.koyra', 'chiini.koyra', 0, 0, 1, 0, ''),
('language', 'khw', 'language.khowar', 'khowar', 0, 0, 1, 0, ''),
('language', 'ki', 'language.kikuyu', 'kikuyu', 0, 0, 1, 0, ''),
('language', 'kiu', 'language.kirmanjki', 'kirmanjki', 0, 0, 1, 0, ''),
('language', 'kj', 'language.kuanyama', 'kuanyama', 0, 0, 1, 0, ''),
('language', 'kk', 'language.kazakh', 'kazakh', 0, 0, 1, 0, ''),
('language', 'kkj', 'language.kako', 'kako', 0, 0, 1, 0, ''),
('language', 'kl', 'language.kalaallisut', 'kalaallisut', 0, 0, 1, 0, ''),
('language', 'kln', 'language.kalenjin', 'kalenjin', 0, 0, 1, 0, ''),
('language', 'km', 'language.khmer', 'khmer', 0, 0, 1, 0, ''),
('language', 'kmb', 'language.kimbundu', 'kimbundu', 0, 0, 1, 0, ''),
('language', 'kn', 'language.kannada', 'kannada', 0, 0, 1, 0, ''),
('language', 'ko', 'language.korean', 'korean', 0, 0, 1, 0, ''),
('language', 'koi', 'language.komi.permyak', 'komi.permyak', 0, 0, 1, 0, ''),
('language', 'kok', 'language.konkani', 'konkani', 0, 0, 1, 0, ''),
('language', 'kos', 'language.kosraean', 'kosraean', 0, 0, 1, 0, ''),
('language', 'kpe', 'language.kpelle', 'kpelle', 0, 0, 1, 0, ''),
('language', 'kr', 'language.kanuri', 'kanuri', 0, 0, 1, 0, ''),
('language', 'krc', 'language.karachaybalkar', 'karachaybalkar', 0, 0, 1, 0, ''),
('language', 'kri', 'language.krio', 'krio', 0, 0, 1, 0, ''),
('language', 'krj', 'language.kinaraya', 'kinaraya', 0, 0, 1, 0, ''),
('language', 'krl', 'language.karelian', 'karelian', 0, 0, 1, 0, ''),
('language', 'kru', 'language.kurukh', 'kurukh', 0, 0, 1, 0, ''),
('language', 'ks', 'language.kashmiri', 'kashmiri', 0, 0, 1, 0, ''),
('language', 'ksb', 'language.shambala', 'shambala', 0, 0, 1, 0, ''),
('language', 'ksf', 'language.bafia', 'bafia', 0, 0, 1, 0, ''),
('language', 'ksh', 'language.colognian', 'colognian', 0, 0, 1, 0, ''),
('language', 'ku', 'language.kurdish', 'kurdish', 0, 0, 1, 0, ''),
('language', 'kum', 'language.kumyk', 'kumyk', 0, 0, 1, 0, ''),
('language', 'kut', 'language.kutenai', 'kutenai', 0, 0, 1, 0, ''),
('language', 'kv', 'language.komi', 'komi', 0, 0, 1, 0, ''),
('language', 'kw', 'language.cornish', 'cornish', 0, 0, 1, 0, ''),
('language', 'ky', 'language.kyrgyz', 'kyrgyz', 0, 0, 1, 0, ''),
('language', 'la', 'language.latin', 'latin', 0, 0, 1, 0, ''),
('language', 'lad', 'language.ladino', 'ladino', 0, 0, 1, 0, ''),
('language', 'lag', 'language.langi', 'langi', 0, 0, 1, 0, ''),
('language', 'lah', 'language.lahnda', 'lahnda', 0, 0, 1, 0, ''),
('language', 'lam', 'language.lamba', 'lamba', 0, 0, 1, 0, ''),
('language', 'lb', 'language.luxembourgish', 'luxembourgish', 0, 0, 1, 0, ''),
('language', 'lez', 'language.lezghian', 'lezghian', 0, 0, 1, 0, ''),
('language', 'lfn', 'language.linguafranca.nova', 'linguafranca.nova', 0, 0, 1, 0, ''),
('language', 'lg', 'language.ganda', 'ganda', 0, 0, 1, 0, ''),
('language', 'li', 'language.limburgish', 'limburgish', 0, 0, 1, 0, ''),
('language', 'lij', 'language.ligurian', 'ligurian', 0, 0, 1, 0, ''),
('language', 'liv', 'language.livonian', 'livonian', 0, 0, 1, 0, ''),
('language', 'lkt', 'language.lakota', 'lakota', 0, 0, 1, 0, ''),
('language', 'lmo', 'language.lombard', 'lombard', 0, 0, 1, 0, ''),
('language', 'ln', 'language.lingala', 'lingala', 0, 0, 1, 0, ''),
('language', 'lo', 'language.lao', 'lao', 0, 0, 1, 0, ''),
('language', 'lol', 'language.mongo', 'mongo', 0, 0, 1, 0, ''),
('language', 'loz', 'language.lozi', 'lozi', 0, 0, 1, 0, ''),
('language', 'lrc', 'language.luri.northern', 'luri.northern', 0, 0, 1, 0, ''),
('language', 'lt', 'language.lithuanian', 'lithuanian', 0, 0, 1, 0, ''),
('language', 'ltg', 'language.latgalian', 'latgalian', 0, 0, 1, 0, ''),
('language', 'lu', 'language.luba.katanga', 'luba.katanga', 0, 0, 1, 0, ''),
('language', 'lua', 'language.luba.lulua', 'luba.lulua', 0, 0, 1, 0, ''),
('language', 'lui', 'language.luiseno', 'luiseno', 0, 0, 1, 0, ''),
('language', 'lun', 'language.lunda', 'lunda', 0, 0, 1, 0, ''),
('language', 'luo', 'language.luo', 'luo', 0, 0, 1, 0, ''),
('language', 'lus', 'language.mizo', 'mizo', 0, 0, 1, 0, ''),
('language', 'luy', 'language.luyia', 'luyia', 0, 0, 1, 0, ''),
('language', 'lv', 'language.latvian', 'latvian', 0, 0, 1, 0, ''),
('language', 'lzh', 'language.chinese.literary', 'chinese.literary', 0, 0, 1, 0, ''),
('language', 'lzz', 'language.laz', 'laz', 0, 0, 1, 0, ''),
('language', 'mad', 'language.madurese', 'madurese', 0, 0, 1, 0, ''),
('language', 'maf', 'language.mafa', 'mafa', 0, 0, 1, 0, ''),
('language', 'mag', 'language.magahi', 'magahi', 0, 0, 1, 0, ''),
('language', 'mai', 'language.maithili', 'maithili', 0, 0, 1, 0, ''),
('language', 'mak', 'language.makasar', 'makasar', 0, 0, 1, 0, ''),
('language', 'man', 'language.mandingo', 'mandingo', 0, 0, 1, 0, ''),
('language', 'mas', 'language.masai', 'masai', 0, 0, 1, 0, ''),
('language', 'mde', 'language.maba', 'maba', 0, 0, 1, 0, ''),
('language', 'mdf', 'language.moksha', 'moksha', 0, 0, 1, 0, ''),
('language', 'mdr', 'language.mandar', 'mandar', 0, 0, 1, 0, ''),
('language', 'men', 'language.mende', 'mende', 0, 0, 1, 0, ''),
('language', 'mer', 'language.meru', 'meru', 0, 0, 1, 0, ''),
('language', 'mfe', 'language.morisyen', 'morisyen', 0, 0, 1, 0, ''),
('language', 'mg', 'language.malagasy', 'malagasy', 0, 0, 1, 0, ''),
('language', 'mga', 'language.irish.middle', 'irish.middle', 0, 0, 1, 0, ''),
('language', 'mgh', 'language.makhuwameetto', 'makhuwameetto', 0, 0, 1, 0, ''),
('language', 'mgo', 'language.meta', 'meta', 0, 0, 1, 0, ''),
('language', 'mh', 'language.marshallese', 'marshallese', 0, 0, 1, 0, ''),
('language', 'mi', 'language.maori', 'maori', 0, 0, 1, 0, ''),
('language', 'mic', 'language.micmac', 'micmac', 0, 0, 1, 0, ''),
('language', 'min', 'language.minangkabau', 'minangkabau', 0, 0, 1, 0, ''),
('language', 'mk', 'language.macedonian', 'macedonian', 0, 0, 1, 0, ''),
('language', 'ml', 'language.malayalam', 'malayalam', 0, 0, 1, 0, ''),
('language', 'mn', 'language.mongolian', 'mongolian', 0, 0, 1, 0, ''),
('language', 'mnc', 'language.manchu', 'manchu', 0, 0, 1, 0, ''),
('language', 'mni', 'language.manipuri', 'manipuri', 0, 0, 1, 0, ''),
('language', 'moh', 'language.mohawk', 'mohawk', 0, 0, 1, 0, ''),
('language', 'mos', 'language.mossi', 'mossi', 0, 0, 1, 0, ''),
('language', 'mr', 'language.marathi', 'marathi', 0, 0, 1, 0, ''),
('language', 'mrj', 'language.mari.western', 'mari.western', 0, 0, 1, 0, ''),
('language', 'ms', 'language.malay', 'malay', 0, 0, 1, 0, ''),
('language', 'mt', 'language.maltese', 'maltese', 0, 0, 1, 0, ''),
('language', 'mua', 'language.mundang', 'mundang', 0, 0, 1, 0, ''),
('language', 'mul', 'language.multiple', 'multiple', 0, 0, 1, 0, ''),
('language', 'mus', 'language.creek', 'creek', 0, 0, 1, 0, ''),
('language', 'mwl', 'language.mirandese', 'mirandese', 0, 0, 1, 0, ''),
('language', 'mwr', 'language.marwari', 'marwari', 0, 0, 1, 0, ''),
('language', 'mwv', 'language.mentawai', 'mentawai', 0, 0, 1, 0, ''),
('language', 'my', 'language.burmese', 'burmese', 0, 0, 1, 0, ''),
('language', 'mye', 'language.myene', 'myene', 0, 0, 1, 0, ''),
('language', 'myv', 'language.erzya', 'erzya', 0, 0, 1, 0, ''),
('language', 'mzn', 'language.mazanderani', 'mazanderani', 0, 0, 1, 0, ''),
('language', 'na', 'language.nauru', 'nauru', 0, 0, 1, 0, ''),
('language', 'nan', 'language.chinese.minnan', 'chinese.minnan', 0, 0, 1, 0, ''),
('language', 'nap', 'language.neapolitan', 'neapolitan', 0, 0, 1, 0, ''),
('language', 'naq', 'language.nama', 'nama', 0, 0, 1, 0, ''),
('language', 'nb', 'language.norwegian.bokmål', 'norwegian.bokmål', 0, 0, 1, 0, ''),
('language', 'nd', 'language.ndebele.north', 'ndebele.north', 0, 0, 1, 0, ''),
('language', 'nds', 'language.german.low', 'german.low', 0, 0, 1, 0, ''),
('language', 'nds-NL', 'language.saxon.low', 'saxon.low', 0, 0, 1, 0, ''),
('language', 'ne', 'language.nepali', 'nepali', 0, 0, 1, 0, ''),
('language', 'new', 'language.newari', 'newari', 0, 0, 1, 0, ''),
('language', 'ng', 'language.ndonga', 'ndonga', 0, 0, 1, 0, ''),
('language', 'nia', 'language.nias', 'nias', 0, 0, 1, 0, ''),
('language', 'niu', 'language.niuean', 'niuean', 0, 0, 1, 0, ''),
('language', 'njo', 'language.aonaga', 'aonaga', 0, 0, 1, 0, ''),
('language', 'nl', 'language.dutch', 'dutch', 0, 0, 1, 0, '');
INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `keyword`, `alias`, `is_default`, `root`, `enabled`, `deprecated`, `description`) VALUES
('language', 'nl-BE', 'language.flemish', 'flemish', 0, 0, 1, 0, ''),
('language', 'nmg', 'language.kwasio', 'kwasio', 0, 0, 1, 0, ''),
('language', 'nn', 'language.norwegian.nynorsk', 'norwegian.nynorsk', 0, 0, 1, 0, ''),
('language', 'nnh', 'language.ngiemboon', 'ngiemboon', 0, 0, 1, 0, ''),
('language', 'no', 'language.norwegian', 'norwegian', 0, 0, 1, 0, ''),
('language', 'nog', 'language.nogai', 'nogai', 0, 0, 1, 0, ''),
('language', 'non', 'language.norse.old', 'norse.old', 0, 0, 1, 0, ''),
('language', 'nov', 'language.novial', 'novial', 0, 0, 1, 0, ''),
('language', 'nqo', 'language.nko', 'nko', 0, 0, 1, 0, ''),
('language', 'nr', 'language.ndebele.south', 'ndebele.south', 0, 0, 1, 0, ''),
('language', 'nso', 'language.sotho.northern', 'sotho.northern', 0, 0, 1, 0, ''),
('language', 'nus', 'language.nuer', 'nuer', 0, 0, 1, 0, ''),
('language', 'nv', 'language.navajo', 'navajo', 0, 0, 1, 0, ''),
('language', 'nwc', 'language.newari.classical', 'newari.classical', 0, 0, 1, 0, ''),
('language', 'ny', 'language.nyanja', 'nyanja', 0, 0, 1, 0, ''),
('language', 'nym', 'language.nyamwezi', 'nyamwezi', 0, 0, 1, 0, ''),
('language', 'nyn', 'language.nyankole', 'nyankole', 0, 0, 1, 0, ''),
('language', 'nyo', 'language.nyoro', 'nyoro', 0, 0, 1, 0, ''),
('language', 'nzi', 'language.nzima', 'nzima', 0, 0, 1, 0, ''),
('language', 'oc', 'language.occitan', 'occitan', 0, 0, 1, 0, ''),
('language', 'oj', 'language.ojibwa', 'ojibwa', 0, 0, 1, 0, ''),
('language', 'om', 'language.oromo', 'oromo', 0, 0, 1, 0, ''),
('language', 'or', 'language.oriya', 'oriya', 0, 0, 1, 0, ''),
('language', 'os', 'language.ossetic', 'ossetic', 0, 0, 1, 0, ''),
('language', 'osa', 'language.osage', 'osage', 0, 0, 1, 0, ''),
('language', 'ota', 'language.turkish.ottoman', 'turkish.ottoman', 0, 0, 1, 0, ''),
('language', 'pa', 'language.punjabi', 'punjabi', 0, 0, 1, 0, ''),
('language', 'pag', 'language.pangasinan', 'pangasinan', 0, 0, 1, 0, ''),
('language', 'pal', 'language.pahlavi', 'pahlavi', 0, 0, 1, 0, ''),
('language', 'pam', 'language.pampanga', 'pampanga', 0, 0, 1, 0, ''),
('language', 'pap', 'language.papiamento', 'papiamento', 0, 0, 1, 0, ''),
('language', 'pau', 'language.palauan', 'palauan', 0, 0, 1, 0, ''),
('language', 'pcd', 'language.picard', 'picard', 0, 0, 1, 0, ''),
('language', 'pdc', 'language.german.pennsylvania', 'german.pennsylvania', 0, 0, 1, 0, ''),
('language', 'pdt', 'language.plautdietsch', 'plautdietsch', 0, 0, 1, 0, ''),
('language', 'peo', 'language.persian.old', 'persian.old', 0, 0, 1, 0, ''),
('language', 'pfl', 'language.german.palatine', 'german.palatine', 0, 0, 1, 0, ''),
('language', 'phn', 'language.phoenician', 'phoenician', 0, 0, 1, 0, ''),
('language', 'pi', 'language.pali', 'pali', 0, 0, 1, 0, ''),
('language', 'pl', 'language.polish', 'polish', 0, 0, 1, 0, ''),
('language', 'pms', 'language.piedmontese', 'piedmontese', 0, 0, 1, 0, ''),
('language', 'pnt', 'language.pontic', 'pontic', 0, 0, 1, 0, ''),
('language', 'pon', 'language.pohnpeian', 'pohnpeian', 0, 0, 1, 0, ''),
('language', 'prg', 'language.prussian', 'prussian', 0, 0, 1, 0, ''),
('language', 'pro', 'language.provençal.old', 'provençal.old', 0, 0, 1, 0, ''),
('language', 'ps', 'language.pashto', 'pashto', 0, 0, 1, 0, ''),
('language', 'pt', 'language.portuguese', 'portuguese', 0, 0, 1, 0, ''),
('language', 'pt-BR', 'language.portuguese.brazilian', 'portuguese.brazilian', 0, 0, 1, 0, ''),
('language', 'pt-PT', 'language.portuguese.european', 'portuguese.european', 0, 0, 1, 0, ''),
('language', 'qu', 'language.quechua', 'quechua', 0, 0, 1, 0, ''),
('language', 'quc', 'language.kiche', 'kiche', 0, 0, 1, 0, ''),
('language', 'qug', 'language.quichua.chimborazohighland', 'quichua.chimborazohighland', 0, 0, 1, 0, ''),
('language', 'raj', 'language.rajasthani', 'rajasthani', 0, 0, 1, 0, ''),
('language', 'rap', 'language.rapanui', 'rapanui', 0, 0, 1, 0, ''),
('language', 'rar', 'language.rarotongan', 'rarotongan', 0, 0, 1, 0, ''),
('language', 'rgn', 'language.romagnol', 'romagnol', 0, 0, 1, 0, ''),
('language', 'rif', 'language.riffian', 'riffian', 0, 0, 1, 0, ''),
('language', 'rm', 'language.romansh', 'romansh', 0, 0, 1, 0, ''),
('language', 'rn', 'language.rundi', 'rundi', 0, 0, 1, 0, ''),
('language', 'ro', 'language.romanian', 'romanian', 0, 0, 1, 0, ''),
('language', 'ro-MD', 'language.moldavian', 'moldavian', 0, 0, 1, 0, ''),
('language', 'rof', 'language.rombo', 'rombo', 0, 0, 1, 0, ''),
('language', 'rom', 'language.romany', 'romany', 0, 0, 1, 0, ''),
('language', 'root', 'language.root', 'root', 0, 0, 1, 0, ''),
('language', 'rtm', 'language.rotuman', 'rotuman', 0, 0, 1, 0, ''),
('language', 'ru', 'language.russian', 'russian', 0, 0, 1, 0, ''),
('language', 'rue', 'language.rusyn', 'rusyn', 0, 0, 1, 0, ''),
('language', 'rug', 'language.roviana', 'roviana', 0, 0, 1, 0, ''),
('language', 'rup', 'language.aromanian', 'aromanian', 0, 0, 1, 0, ''),
('language', 'rw', 'language.kinyarwanda', 'kinyarwanda', 0, 0, 1, 0, ''),
('language', 'rwk', 'language.rwa', 'rwa', 0, 0, 1, 0, ''),
('language', 'sa', 'language.sanskrit', 'sanskrit', 0, 0, 1, 0, ''),
('language', 'sad', 'language.sandawe', 'sandawe', 0, 0, 1, 0, ''),
('language', 'sah', 'language.sakha', 'sakha', 0, 0, 1, 0, ''),
('language', 'sam', 'language.aramaic.samaritan', 'aramaic.samaritan', 0, 0, 1, 0, ''),
('language', 'saq', 'language.samburu', 'samburu', 0, 0, 1, 0, ''),
('language', 'sas', 'language.sasak', 'sasak', 0, 0, 1, 0, ''),
('language', 'sat', 'language.santali', 'santali', 0, 0, 1, 0, ''),
('language', 'saz', 'language.saurashtra', 'saurashtra', 0, 0, 1, 0, ''),
('language', 'sba', 'language.ngambay', 'ngambay', 0, 0, 1, 0, ''),
('language', 'sbp', 'language.sangu', 'sangu', 0, 0, 1, 0, ''),
('language', 'sc', 'language.sardinian', 'sardinian', 0, 0, 1, 0, ''),
('language', 'scn', 'language.sicilian', 'sicilian', 0, 0, 1, 0, ''),
('language', 'sco', 'language.scots', 'scots', 0, 0, 1, 0, ''),
('language', 'sd', 'language.sindhi', 'sindhi', 0, 0, 1, 0, ''),
('language', 'sdc', 'language.sardinian.sassarese', 'sardinian.sassarese', 0, 0, 1, 0, ''),
('language', 'sdh', 'language.southern kurdish', 'southern kurdish', 0, 0, 1, 0, ''),
('language', 'se', 'language.northern sami', 'northern sami', 0, 0, 1, 0, ''),
('language', 'see', 'language.seneca', 'seneca', 0, 0, 1, 0, ''),
('language', 'seh', 'language.sena', 'sena', 0, 0, 1, 0, ''),
('language', 'sei', 'language.seri', 'seri', 0, 0, 1, 0, ''),
('language', 'sel', 'language.selkup', 'selkup', 0, 0, 1, 0, ''),
('language', 'ses', 'language.senni.koyraboro', 'senni.koyraboro', 0, 0, 1, 0, ''),
('language', 'sg', 'language.sango', 'sango', 0, 0, 1, 0, ''),
('language', 'sga', 'language.irish.old', 'irish.old', 0, 0, 1, 0, ''),
('language', 'sgs', 'language.samogitian', 'samogitian', 0, 0, 1, 0, ''),
('language', 'sh', 'language.serbocroatian', 'serbocroatian', 0, 0, 1, 0, ''),
('language', 'shi', 'language.tachelhit', 'tachelhit', 0, 0, 1, 0, ''),
('language', 'shn', 'language.shan', 'shan', 0, 0, 1, 0, ''),
('language', 'shu', 'language.arabic.chadian', 'arabic.chadian', 0, 0, 1, 0, ''),
('language', 'si', 'language.sinhala', 'sinhala', 0, 0, 1, 0, ''),
('language', 'sid', 'language.sidamo', 'sidamo', 0, 0, 1, 0, ''),
('language', 'sk', 'language.slovak', 'slovak', 0, 0, 1, 0, ''),
('language', 'sl', 'language.slovenian', 'slovenian', 0, 0, 1, 0, ''),
('language', 'sli', 'language.silesian.lower', 'silesian.lower', 0, 0, 1, 0, ''),
('language', 'sly', 'language.selayar', 'selayar', 0, 0, 1, 0, ''),
('language', 'sm', 'language.samoan', 'samoan', 0, 0, 1, 0, ''),
('language', 'sma', 'language.sami.southern', 'sami.southern', 0, 0, 1, 0, ''),
('language', 'smj', 'language.sami.lule', 'sami.lule', 0, 0, 1, 0, ''),
('language', 'smn', 'language.sami.inari', 'sami.inari', 0, 0, 1, 0, ''),
('language', 'sms', 'language.sami.skolt', 'sami.skolt', 0, 0, 1, 0, ''),
('language', 'sn', 'language.shona', 'shona', 0, 0, 1, 0, ''),
('language', 'snk', 'language.soninke', 'soninke', 0, 0, 1, 0, ''),
('language', 'so', 'language.somali', 'somali', 0, 0, 1, 0, ''),
('language', 'sog', 'language.sogdien', 'sogdien', 0, 0, 1, 0, ''),
('language', 'sq', 'language.albanian', 'albanian', 0, 0, 1, 0, ''),
('language', 'sr', 'language.serbian', 'serbian', 0, 0, 1, 0, ''),
('language', 'srn', 'language.tongo.sranan', 'tongo.sranan', 0, 0, 1, 0, ''),
('language', 'srr', 'language.serer', 'serer', 0, 0, 1, 0, ''),
('language', 'ss', 'language.swati', 'swati', 0, 0, 1, 0, ''),
('language', 'ssy', 'language.saho', 'saho', 0, 0, 1, 0, ''),
('language', 'st', 'language.sotho.southern', 'sotho.southern', 0, 0, 1, 0, ''),
('language', 'stq', 'language.frisian.saterland', 'frisian.saterland', 0, 0, 1, 0, ''),
('language', 'su', 'language.sundanese', 'sundanese', 0, 0, 1, 0, ''),
('language', 'suk', 'language.sukuma', 'sukuma', 0, 0, 1, 0, ''),
('language', 'sus', 'language.susu', 'susu', 0, 0, 1, 0, ''),
('language', 'sux', 'language.sumerian', 'sumerian', 0, 0, 1, 0, ''),
('language', 'sv', 'language.swedish', 'swedish', 0, 0, 1, 0, ''),
('language', 'sw', 'language.swahili', 'swahili', 0, 0, 1, 0, ''),
('language', 'sw-CD', 'language.swahili.congo', 'swahili.congo', 0, 0, 1, 0, ''),
('language', 'swb', 'language.comorian', 'comorian', 0, 0, 1, 0, ''),
('language', 'syc', 'language.syriac.classical', 'syriac.classical', 0, 0, 1, 0, ''),
('language', 'syr', 'language.syriac', 'syriac', 0, 0, 1, 0, ''),
('language', 'szl', 'language.silesian', 'silesian', 0, 0, 1, 0, ''),
('language', 'ta', 'language.tamil', 'tamil', 0, 0, 1, 0, ''),
('language', 'tcy', 'language.tulu', 'tulu', 0, 0, 1, 0, ''),
('language', 'te', 'language.telugu', 'telugu', 0, 0, 1, 0, ''),
('language', 'tem', 'language.timne', 'timne', 0, 0, 1, 0, ''),
('language', 'teo', 'language.teso', 'teso', 0, 0, 1, 0, ''),
('language', 'ter', 'language.tereno', 'tereno', 0, 0, 1, 0, ''),
('language', 'tet', 'language.tetum', 'tetum', 0, 0, 1, 0, ''),
('language', 'tg', 'language.tajik', 'tajik', 0, 0, 1, 0, ''),
('language', 'th', 'language.thai', 'thai', 0, 0, 1, 0, ''),
('language', 'ti', 'language.tigrinya', 'tigrinya', 0, 0, 1, 0, ''),
('language', 'tig', 'language.tigre', 'tigre', 0, 0, 1, 0, ''),
('language', 'tiv', 'language.tiv', 'tiv', 0, 0, 1, 0, ''),
('language', 'tk', 'language.turkmen', 'turkmen', 0, 0, 1, 0, ''),
('language', 'tkl', 'language.tokelau', 'tokelau', 0, 0, 1, 0, ''),
('language', 'tkr', 'language.tsakhur', 'tsakhur', 0, 0, 1, 0, ''),
('language', 'tl', 'language.tagalog', 'tagalog', 0, 0, 1, 0, ''),
('language', 'tlh', 'language.klingon', 'klingon', 0, 0, 1, 0, ''),
('language', 'tli', 'language.tlingit', 'tlingit', 0, 0, 1, 0, ''),
('language', 'tly', 'language.talysh', 'talysh', 0, 0, 1, 0, ''),
('language', 'tmh', 'language.tamashek', 'tamashek', 0, 0, 1, 0, ''),
('language', 'tn', 'language.tswana', 'tswana', 0, 0, 1, 0, ''),
('language', 'to', 'language.tongan', 'tongan', 0, 0, 1, 0, ''),
('language', 'tog', 'language.tonga.nyasa', 'tonga.nyasa', 0, 0, 1, 0, ''),
('language', 'tpi', 'language.pisin.tok', 'pisin.tok', 0, 0, 1, 0, ''),
('language', 'tr', 'language.turkish', 'turkish', 0, 0, 1, 0, ''),
('language', 'tru', 'language.turoyo', 'turoyo', 0, 0, 1, 0, ''),
('language', 'trv', 'language.taroko', 'taroko', 0, 0, 1, 0, ''),
('language', 'ts', 'language.tsonga', 'tsonga', 0, 0, 1, 0, ''),
('language', 'tsd', 'language.tsakonian', 'tsakonian', 0, 0, 1, 0, ''),
('language', 'tsi', 'language.tsimshian', 'tsimshian', 0, 0, 1, 0, ''),
('language', 'tt', 'language.tatar', 'tatar', 0, 0, 1, 0, ''),
('language', 'ttt', 'language.tat.muslim', 'tat.muslim', 0, 0, 1, 0, ''),
('language', 'tum', 'language.tumbuka', 'tumbuka', 0, 0, 1, 0, ''),
('language', 'tvl', 'language.tuvalu', 'tuvalu', 0, 0, 1, 0, ''),
('language', 'tw', 'language.twi', 'twi', 0, 0, 1, 0, ''),
('language', 'twq', 'language.tasawaq', 'tasawaq', 0, 0, 1, 0, ''),
('language', 'ty', 'language.tahitian', 'tahitian', 0, 0, 1, 0, ''),
('language', 'tyv', 'language.tuvinian', 'tuvinian', 0, 0, 1, 0, ''),
('language', 'tzm', 'language.tamazight.centralatlas', 'tamazight.centralatlas', 0, 0, 1, 0, ''),
('language', 'udm', 'language.udmurt', 'udmurt', 0, 0, 1, 0, ''),
('language', 'ug', 'language.uyghur', 'uyghur', 0, 0, 1, 0, ''),
('language', 'uga', 'language.ugaritic', 'ugaritic', 0, 0, 1, 0, ''),
('language', 'uk', 'language.ukrainian', 'ukrainian', 0, 0, 1, 0, ''),
('language', 'umb', 'language.umbundu', 'umbundu', 0, 0, 1, 0, ''),
('language', 'und', 'language.unknown', 'unknown', 0, 0, 1, 0, ''),
('language', 'ur', 'language.urdu', 'urdu', 0, 0, 1, 0, ''),
('language', 'uz', 'language.uzbek', 'uzbek', 0, 0, 1, 0, ''),
('language', 'vai', 'language.vai', 'vai', 0, 0, 1, 0, ''),
('language', 've', 'language.venda', 'venda', 0, 0, 1, 0, ''),
('language', 'vec', 'language.venetian', 'venetian', 0, 0, 1, 0, ''),
('language', 'vep', 'language.veps', 'veps', 0, 0, 1, 0, ''),
('language', 'vi', 'language.vietnamese', 'vietnamese', 0, 0, 1, 0, ''),
('language', 'vls', 'language.flemish.west', 'flemish.west', 0, 0, 1, 0, ''),
('language', 'vmf', 'language.franconian.main', 'franconian.main', 0, 0, 1, 0, ''),
('language', 'vo', 'language.volapük', 'volapük', 0, 0, 1, 0, ''),
('language', 'vot', 'language.votic', 'votic', 0, 0, 1, 0, ''),
('language', 'vro', 'language.võro', 'võro', 0, 0, 1, 0, ''),
('language', 'vun', 'language.vunjo', 'vunjo', 0, 0, 1, 0, ''),
('language', 'wa', 'language.walloon', 'walloon', 0, 0, 1, 0, ''),
('language', 'wae', 'language.walser', 'walser', 0, 0, 1, 0, ''),
('language', 'wal', 'language.wolaytta', 'wolaytta', 0, 0, 1, 0, ''),
('language', 'war', 'language.waray', 'waray', 0, 0, 1, 0, ''),
('language', 'was', 'language.washo', 'washo', 0, 0, 1, 0, ''),
('language', 'wbp', 'language.warlpiri', 'warlpiri', 0, 0, 1, 0, ''),
('language', 'wo', 'language.wolof', 'wolof', 0, 0, 1, 0, ''),
('language', 'wuu', 'language.chinese.wu', 'chinese.wu', 0, 0, 1, 0, ''),
('language', 'xal', 'language.kalmyk', 'kalmyk', 0, 0, 1, 0, ''),
('language', 'xh', 'language.xhosa', 'xhosa', 0, 0, 1, 0, ''),
('language', 'xmf', 'language.mingrelian', 'mingrelian', 0, 0, 1, 0, ''),
('language', 'xog', 'language.soga', 'soga', 0, 0, 1, 0, ''),
('language', 'yao', 'language.yao', 'yao', 0, 0, 1, 0, ''),
('language', 'yap', 'language.yapese', 'yapese', 0, 0, 1, 0, ''),
('language', 'yav', 'language.yangben', 'yangben', 0, 0, 1, 0, ''),
('language', 'ybb', 'language.yemba', 'yemba', 0, 0, 1, 0, ''),
('language', 'yi', 'language.yiddish', 'yiddish', 0, 0, 1, 0, ''),
('language', 'yo', 'language.yoruba', 'yoruba', 0, 0, 1, 0, ''),
('language', 'yrl', 'language.nheengatu', 'nheengatu', 0, 0, 1, 0, ''),
('language', 'yue', 'language.cantonese', 'cantonese', 0, 0, 1, 0, ''),
('language', 'za', 'language.zhuang', 'zhuang', 0, 0, 1, 0, ''),
('language', 'zap', 'language.zapotec', 'zapotec', 0, 0, 1, 0, ''),
('language', 'zbl', 'language.blissymbols', 'blissymbols', 0, 0, 1, 0, ''),
('language', 'zea', 'language.zeelandic', 'zeelandic', 0, 0, 1, 0, ''),
('language', 'zen', 'language.zenaga', 'zenaga', 0, 0, 1, 0, ''),
('language', 'zgh', 'language.tamazight.standardmoroccan', 'tamazight.standardmoroccan', 0, 0, 1, 0, ''),
('language', 'zh', 'language.chinese', 'chinese', 0, 0, 1, 0, ''),
('language', 'zh-Hans', 'language.chinese.simplified', 'chinese.simplified', 0, 0, 1, 0, ''),
('language', 'zh-Hant', 'language.chinese.traditional', 'chinese.traditional', 0, 0, 1, 0, ''),
('language', 'zu', 'language.zulu', 'zulu', 0, 0, 1, 0, ''),
('language', 'zun', 'language.zuni', 'zuni', 0, 0, 1, 0, ''),
('language', 'zxx', 'language.none', 'none', 0, 0, 1, 0, ''),
('language', 'zza', 'language.zaza', 'zaza', 0, 0, 1, 0, ''),
('mass', 'g', 'mass.gram', 'gram', 1, 0, 1, 0, ''),
('mass', 'kg', 'mass.kilogram', 'kilogram', 0, 0, 1, 0, ''),
('mass', 'mg', 'mass.milligram', 'milligram', 0, 0, 1, 0, ''),
('mass', 't', 'mass.tonne', 'tonne', 0, 0, 1, 0, ''),
('mass', 'µg', 'mass.microgram', 'microgram', 0, 0, 1, 0, ''),
('mediatype', 'image/jpeg', 'core.mediatype.image.jpeg', 'jpeg', 0, 0, 1, 0, ''),
('mediatype', 'image/png', 'core.mediatype.image.png', 'png', 0, 0, 1, 0, ''),
('mediatype', 'text/html', 'core.mediatype.text.html', 'html', 0, 0, 1, 0, ''),
('mediatype', 'text/plain', 'core.mediatype.text.plain', 'plain', 0, 0, 1, 0, ''),
('spatial.crs', '4326', 'spatial.crs.wgs84', 'WGS84', 0, 0, 1, 0, ''),
('spatial.format', 'geojson', 'spatial.format.geojson', '', 0, 0, 1, 0, ''),
('spatial.format', 'gpx', 'spatial.format.gpx', '', 0, 0, 1, 0, ''),
('spatial.format', 'wkt', 'spatial.format.wkt', '', 0, 0, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_type`
--

CREATE TABLE `ark_vocabulary_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equivalence` tinyint(1) NOT NULL DEFAULT 0,
  `hierarchy` tinyint(1) NOT NULL DEFAULT 0,
  `association` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `deprecated` tinyint(1) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_type`
--

INSERT INTO `ark_vocabulary_type` (`type`, `keyword`, `equivalence`, `hierarchy`, `association`, `enabled`, `deprecated`, `description`) VALUES
('list', 'core.vocabulary.type.list', 0, 0, 0, 1, 0, 'A list of valid terms'),
('ring', 'core.vocabulary.type.ring', 1, 0, 0, 0, 0, 'A list of equivalent terms'),
('taxonomy', 'core.vocabulary.type.taxonomy', 0, 1, 0, 1, 0, 'A hierarchy of related terms'),
('thesaurus', 'core.vocabulary.type.thesaurus', 1, 1, 1, 0, 0, 'A collection of related terms');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_action`
--

CREATE TABLE `ark_workflow_action` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_term` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_permission` tinyint(1) NOT NULL DEFAULT 0,
  `default_agency` tinyint(1) NOT NULL DEFAULT 0,
  `default_allowance` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_action`
--

INSERT INTO `ark_workflow_action` (`schma`, `action`, `event_vocabulary`, `event_term`, `keyword`, `agent`, `default_permission`, `default_agency`, `default_allowance`, `enabled`, `description`) VALUES
('core.actor', 'activate', 'core.event.class', 'activated', 'core.action.activate', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'approve', 'core.event.class', 'approved', 'core.action.approve', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'cancel', 'core.event.class', 'cancelled', 'core.action.cancel', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'edit', 'core.event.class', 'edited', 'core.action.edit', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'lock', 'core.event.class', 'locked', 'core.action.activate', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'register', 'core.event.class', 'registered', 'core.action.register', NULL, 1, 1, 1, 1, NULL),
('core.actor', 'restore', 'core.event.class', 'restored', 'core.action.restore', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'suspend', 'core.event.class', 'suspended', 'core.action.suspend', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'unlock', 'core.event.class', 'unlocked', 'core.action.activate', NULL, 0, 1, 0, 1, NULL),
('core.actor', 'view', 'core.event.class', 'viewed', 'core.action.view', NULL, 0, 1, 0, 1, NULL),
('core.event', 'edit', 'core.event.class', 'edited', 'core.action.edit', NULL, 0, 1, 0, 1, NULL),
('core.event', 'view', 'core.event.class', 'viewed', 'core.action.view', NULL, 0, 1, 0, 1, NULL),
('core.file', 'edit', 'core.event.class', 'edited', 'core.action.edit', NULL, 0, 1, 0, 1, NULL),
('core.file', 'view', 'core.event.class', 'viewed', 'core.action.view', NULL, 0, 1, 0, 1, NULL),
('core.message', 'edit', 'core.event.class', 'edited', 'core.action.edit', NULL, 0, 1, 0, 1, NULL),
('core.message', 'view', 'core.event.class', 'viewed', 'core.action.view', NULL, 0, 1, 0, 1, NULL),
('core.page', 'edit', 'core.event.class', 'edited', 'core.action.edit', NULL, 0, 1, 0, 1, NULL),
('core.page', 'view', 'core.event.class', 'viewed', 'core.action.view', NULL, 1, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_agency`
--

CREATE TABLE `ark_workflow_agency` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition_attribute` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'eq',
  `condition_operator` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_value` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_allow`
--

CREATE TABLE `ark_workflow_allow` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'is'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_allow`
--

INSERT INTO `ark_workflow_allow` (`schma`, `action`, `role`, `operator`) VALUES
('core.actor', 'activate', 'admin', 'is'),
('core.actor', 'activate', 'sysadmin', 'is'),
('core.actor', 'approve', 'admin', 'is'),
('core.actor', 'approve', 'sysadmin', 'is'),
('core.actor', 'cancel', 'admin', 'is'),
('core.actor', 'cancel', 'sysadmin', 'is'),
('core.actor', 'edit', 'admin', 'is'),
('core.actor', 'edit', 'sysadmin', 'is'),
('core.actor', 'restore', 'admin', 'is'),
('core.actor', 'restore', 'sysadmin', 'is'),
('core.actor', 'suspend', 'admin', 'is'),
('core.actor', 'suspend', 'sysadmin', 'is'),
('core.actor', 'view', 'admin', 'is'),
('core.actor', 'view', 'anonymous', 'is'),
('core.actor', 'view', 'sysadmin', 'is'),
('core.actor', 'view', 'user', 'is'),
('core.page', 'edit', 'admin', 'is'),
('core.page', 'edit', 'sysadmin', 'is'),
('core.page', 'view', 'admin', 'is'),
('core.page', 'view', 'anonymous', 'is'),
('core.page', 'view', 'sysadmin', 'is'),
('core.page', 'view', 'user', 'is');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_condition`
--

CREATE TABLE `ark_workflow_condition` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grp` int(11) NOT NULL DEFAULT 0,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'eq',
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_condition`
--

INSERT INTO `ark_workflow_condition` (`schma`, `action`, `class`, `attribute`, `grp`, `operator`, `value`) VALUES
('core.actor', 'approve', 'person', 'status', 0, 'eq', 'registered'),
('core.actor', 'approve', 'person', 'status', 1, 'eq', 'verified'),
('core.actor', 'lock', 'person', 'status', 0, 'eq', 'approved'),
('core.actor', 'suspend', 'person', 'status', 0, 'eq', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_grant`
--

CREATE TABLE `ark_workflow_grant` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_grant`
--

INSERT INTO `ark_workflow_grant` (`role`, `permission`) VALUES
('admin', 'core.actor.read'),
('admin', 'core.actor.update'),
('admin', 'core.admin'),
('admin', 'core.admin.user'),
('admin', 'core.message.read'),
('admin', 'core.message.update'),
('anonymous', 'core.actor.read'),
('anonymous', 'core.page.read'),
('anonymous', 'core.user.confirm'),
('anonymous', 'core.user.login'),
('anonymous', 'core.user.register'),
('anonymous', 'core.user.reset'),
('sysadmin', 'core.actor.read'),
('sysadmin', 'core.actor.update'),
('sysadmin', 'core.admin'),
('sysadmin', 'core.admin.system'),
('sysadmin', 'core.admin.user'),
('sysadmin', 'core.message.read'),
('sysadmin', 'core.message.update'),
('user', 'core.actor.read'),
('user', 'core.actor.update'),
('user', 'core.file.read'),
('user', 'core.message.read'),
('user', 'core.message.update');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_notify`
--

CREATE TABLE `ark_workflow_notify` (
  `id` int(11) NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_notify`
--

INSERT INTO `ark_workflow_notify` (`id`, `schma`, `action`, `class`, `attribute`, `role`, `keyword`) VALUES
(1, 'core.actor', 'register', 'person', NULL, 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_permission`
--

CREATE TABLE `ark_workflow_permission` (
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_permission`
--

INSERT INTO `ark_workflow_permission` (`permission`, `keyword`, `enabled`, `description`) VALUES
('core.actor.create', NULL, 1, NULL),
('core.actor.delete', NULL, 1, NULL),
('core.actor.read', NULL, 1, NULL),
('core.actor.register', NULL, 1, NULL),
('core.actor.update', NULL, 1, NULL),
('core.admin', NULL, 1, NULL),
('core.admin.system', NULL, 1, NULL),
('core.admin.user', NULL, 1, NULL),
('core.event.create', NULL, 1, NULL),
('core.event.delete', NULL, 1, NULL),
('core.event.read', NULL, 1, NULL),
('core.event.update', NULL, 1, NULL),
('core.file.create', NULL, 1, NULL),
('core.file.delete', NULL, 1, NULL),
('core.file.read', NULL, 1, NULL),
('core.file.update', NULL, 1, NULL),
('core.message.create', NULL, 1, NULL),
('core.message.delete', NULL, 1, NULL),
('core.message.read', NULL, 1, NULL),
('core.message.update', NULL, 1, NULL),
('core.page.create', NULL, 1, NULL),
('core.page.delete', NULL, 1, NULL),
('core.page.read', NULL, 1, NULL),
('core.page.update', NULL, 1, NULL),
('core.user.confirm', NULL, 1, NULL),
('core.user.login', NULL, 1, NULL),
('core.user.logout', NULL, 1, NULL),
('core.user.register', NULL, 1, NULL),
('core.user.reset', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_role`
--

CREATE TABLE `ark_workflow_role` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_for` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_role`
--

INSERT INTO `ark_workflow_role` (`role`, `keyword`, `agent_for`, `level`, `enabled`) VALUES
('admin', 'core.workflow.role.admin', NULL, 'ROLE_ADMIN', 1),
('anonymous', 'core.workflow.role.anon', NULL, 'ROLE_ANON', 1),
('sysadmin', 'core.workflow.role.admin', NULL, 'ROLE_SUPER_ADMIN', 1),
('user', 'core.workflow.role.user', NULL, 'ROLE_USER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_trigger`
--

CREATE TABLE `ark_workflow_trigger` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_update`
--

CREATE TABLE `ark_workflow_update` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actor` tinyint(1) DEFAULT NULL,
  `subject` tinyint(1) DEFAULT NULL,
  `clear` tinyint(1) DEFAULT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_workflow_update`
--

INSERT INTO `ark_workflow_update` (`schma`, `action`, `class`, `attribute`, `source`, `actor`, `subject`, `clear`, `term`, `id`) VALUES
('core.actor', 'approve', 'person', 'status', NULL, NULL, NULL, NULL, 'approved', NULL),
('core.actor', 'cancel', 'person', 'status', NULL, NULL, NULL, NULL, 'closed', NULL),
('core.actor', 'lock', 'person', 'status', NULL, NULL, NULL, NULL, 'locked', NULL),
('core.actor', 'register', 'person', 'status', NULL, NULL, NULL, NULL, 'registered', NULL),
('core.actor', 'suspend', 'person', 'status', NULL, NULL, NULL, NULL, 'suspended', NULL),
('core.actor', 'unlock', 'person', 'status', NULL, NULL, NULL, NULL, 'approved', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_dataclass`
--
ALTER TABLE `ark_dataclass`
  ADD PRIMARY KEY (`dataclass`),
  ADD KEY `datatype_foreign` (`datatype`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `parameter_foreign` (`parameter_vocabulary`),
  ADD KEY `format_foreign` (`format_vocabulary`);

--
-- Indexes for table `ark_dataclass_attribute`
--
ALTER TABLE `ark_dataclass_attribute`
  ADD PRIMARY KEY (`parent`,`attribute`),
  ADD KEY `vocabulary_foreign` (`vocabulary`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `dataclass_foreign` (`dataclass`),
  ADD KEY `parent_foreign` (`parent`);

--
-- Indexes for table `ark_dataclass_blob`
--
ALTER TABLE `ark_dataclass_blob`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_boolean`
--
ALTER TABLE `ark_dataclass_boolean`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_date`
--
ALTER TABLE `ark_dataclass_date`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_datetime`
--
ALTER TABLE `ark_dataclass_datetime`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_decimal`
--
ALTER TABLE `ark_dataclass_decimal`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_float`
--
ALTER TABLE `ark_dataclass_float`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_integer`
--
ALTER TABLE `ark_dataclass_integer`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_item`
--
ALTER TABLE `ark_dataclass_item`
  ADD PRIMARY KEY (`dataclass`),
  ADD KEY `module_foreign` (`module`);

--
-- Indexes for table `ark_dataclass_object`
--
ALTER TABLE `ark_dataclass_object`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_spatial`
--
ALTER TABLE `ark_dataclass_spatial`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_string`
--
ALTER TABLE `ark_dataclass_string`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_text`
--
ALTER TABLE `ark_dataclass_text`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_time`
--
ALTER TABLE `ark_dataclass_time`
  ADD PRIMARY KEY (`dataclass`);

--
-- Indexes for table `ark_dataclass_type`
--
ALTER TABLE `ark_dataclass_type`
  ADD PRIMARY KEY (`datatype`),
  ADD KEY `format_foreign` (`format_vocabulary`),
  ADD KEY `parameter_foreign` (`parameter_vocabulary`),
  ADD KEY `datatype_foreign` (`keyword`);

--
-- Indexes for table `ark_instance`
--
ALTER TABLE `ark_instance`
  ADD PRIMARY KEY (`instance`);

--
-- Indexes for table `ark_instance_route`
--
ALTER TABLE `ark_instance_route`
  ADD PRIMARY KEY (`instance`,`route`),
  ADD KEY `route_foreign` (`route`),
  ADD KEY `instance_foreign` (`instance`);

--
-- Indexes for table `ark_instance_schema`
--
ALTER TABLE `ark_instance_schema`
  ADD PRIMARY KEY (`instance`,`schma`),
  ADD KEY `schema_foreign` (`schma`),
  ADD KEY `instance_foreign` (`instance`);

--
-- Indexes for table `ark_map`
--
ALTER TABLE `ark_map`
  ADD PRIMARY KEY (`map`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_map_layer`
--
ALTER TABLE `ark_map_layer`
  ADD PRIMARY KEY (`source`,`layer`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `source_foreign` (`source`);

--
-- Indexes for table `ark_map_legend`
--
ALTER TABLE `ark_map_legend`
  ADD PRIMARY KEY (`map`,`source`,`layer`),
  ADD UNIQUE KEY `sequence_unique` (`map`,`source`,`layer`,`seq`),
  ADD KEY `layer_foreign` (`source`,`layer`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `map_foreign` (`map`);

--
-- Indexes for table `ark_map_source`
--
ALTER TABLE `ark_map_source`
  ADD PRIMARY KEY (`source`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_module`
--
ALTER TABLE `ark_module`
  ADD PRIMARY KEY (`module`),
  ADD UNIQUE KEY `tbl_unique` (`tbl`),
  ADD UNIQUE KEY `classname_unique` (`classname`),
  ADD UNIQUE KEY `resource_unique` (`resource`),
  ADD UNIQUE KEY `entity_unique` (`entity`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_route`
--
ALTER TABLE `ark_route`
  ADD PRIMARY KEY (`route`),
  ADD KEY `page_foreign` (`page`),
  ADD KEY `redirect_foreign` (`redirect`);

--
-- Indexes for table `ark_route_parameter`
--
ALTER TABLE `ark_route_parameter`
  ADD PRIMARY KEY (`route`,`parameter`),
  ADD KEY `IDX_7B0087752C42079` (`route`);

--
-- Indexes for table `ark_schema`
--
ALTER TABLE `ark_schema`
  ADD PRIMARY KEY (`schma`),
  ADD KEY `module` (`module`),
  ADD KEY `vocabulary_foreign` (`vocabulary`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `new_foreign` (`new`),
  ADD KEY `remove_foreign` (`remove`),
  ADD KEY `edit_foreign` (`edit`),
  ADD KEY `view_foreign` (`view`),
  ADD KEY `event_foreign` (`event`);

--
-- Indexes for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD PRIMARY KEY (`schma`,`class`,`association`),
  ADD KEY `inverse_foreign` (`inverse`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `schema_foreign` (`schma`),
  ADD KEY `schema1_foreign` (`schema1`),
  ADD KEY `schema2_foreign` (`schema2`);

--
-- Indexes for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD PRIMARY KEY (`schma`,`class`,`attribute`),
  ADD KEY `dataclass_foreign` (`dataclass`),
  ADD KEY `vocabulary_foreign` (`vocabulary`),
  ADD KEY `view_foreign` (`view`),
  ADD KEY `edit_foreign` (`edit`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `schema_foreign` (`schma`);

--
-- Indexes for table `ark_schema_item`
--
ALTER TABLE `ark_schema_item`
  ADD PRIMARY KEY (`attribute`),
  ADD KEY `dataclass_foreign` (`dataclass`),
  ADD KEY `vocabulary_foreign` (`vocabulary`);

--
-- Indexes for table `ark_translation`
--
ALTER TABLE `ark_translation`
  ADD PRIMARY KEY (`keyword`),
  ADD KEY `domain_foreign` (`domain`);

--
-- Indexes for table `ark_translation_domain`
--
ALTER TABLE `ark_translation_domain`
  ADD PRIMARY KEY (`domain`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_translation_language`
--
ALTER TABLE `ark_translation_language`
  ADD PRIMARY KEY (`language`);

--
-- Indexes for table `ark_translation_message`
--
ALTER TABLE `ark_translation_message`
  ADD PRIMARY KEY (`language`,`keyword`,`role`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `language_foreign` (`language`),
  ADD KEY `role_foreign` (`role`);

--
-- Indexes for table `ark_translation_parameter`
--
ALTER TABLE `ark_translation_parameter`
  ADD PRIMARY KEY (`keyword`,`parameter`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_translation_role`
--
ALTER TABLE `ark_translation_role`
  ADD PRIMARY KEY (`role`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_cell`
--
ALTER TABLE `ark_view_cell`
  ADD PRIMARY KEY (`grp`,`class`,`row`,`col`,`seq`),
  ADD KEY `element_foreign` (`element`),
  ADD KEY `map_foreign` (`map`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `vocabulary_foreign` (`vocabulary`),
  ADD KEY `grp_foreign` (`grp`),
  ADD KEY `view_foreign` (`view`),
  ADD KEY `edit_foreign` (`edit`),
  ADD KEY `action_foreign` (`action_schema`,`action`);

--
-- Indexes for table `ark_view_element`
--
ALTER TABLE `ark_view_element`
  ADD PRIMARY KEY (`element`),
  ADD KEY `type_foreign` (`type`);

--
-- Indexes for table `ark_view_field`
--
ALTER TABLE `ark_view_field`
  ADD PRIMARY KEY (`element`),
  ADD KEY `attribute_foreign` (`schma`,`class`,`attribute`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_form`
--
ALTER TABLE `ark_view_form`
  ADD PRIMARY KEY (`element`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `route_foreign` (`action`);

--
-- Indexes for table `ark_view_group`
--
ALTER TABLE `ark_view_group`
  ADD PRIMARY KEY (`element`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_nav`
--
ALTER TABLE `ark_view_nav`
  ADD PRIMARY KEY (`element`),
  ADD UNIQUE KEY `sequence_unique` (`parent`,`seq`),
  ADD KEY `parent_foreign` (`parent`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_page`
--
ALTER TABLE `ark_view_page`
  ADD PRIMARY KEY (`element`),
  ADD KEY `navbar_foreign` (`header`),
  ADD KEY `sidebar_foreign` (`sidebar`),
  ADD KEY `content_foreign` (`content`),
  ADD KEY `footer_foreign` (`footer`),
  ADD KEY `view_foreign` (`view`),
  ADD KEY `edit_foreign` (`edit`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_table`
--
ALTER TABLE `ark_view_table`
  ADD PRIMARY KEY (`element`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depth` (`depth`),
  ADD KEY `ancestor_foreign` (`ancestor`),
  ADD KEY `descendent_foreign` (`descendant`);

--
-- Indexes for table `ark_view_type`
--
ALTER TABLE `ark_view_type`
  ADD PRIMARY KEY (`type`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_view_widget`
--
ALTER TABLE `ark_view_widget`
  ADD PRIMARY KEY (`element`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_vocabulary`
--
ALTER TABLE `ark_vocabulary`
  ADD PRIMARY KEY (`concept`),
  ADD KEY `type_foreign` (`type`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_vocabulary_parameter`
--
ALTER TABLE `ark_vocabulary_parameter`
  ADD PRIMARY KEY (`concept`,`term`,`name`),
  ADD KEY `term_foreign` (`concept`,`term`);

--
-- Indexes for table `ark_vocabulary_related`
--
ALTER TABLE `ark_vocabulary_related`
  ADD PRIMARY KEY (`from_concept`,`from_term`,`to_concept`,`to_term`),
  ADD KEY `relation_foreign` (`relation`),
  ADD KEY `from_foreign` (`from_concept`,`from_term`),
  ADD KEY `to_foreign` (`to_concept`,`to_term`);

--
-- Indexes for table `ark_vocabulary_relation`
--
ALTER TABLE `ark_vocabulary_relation`
  ADD PRIMARY KEY (`relation`);

--
-- Indexes for table `ark_vocabulary_term`
--
ALTER TABLE `ark_vocabulary_term`
  ADD PRIMARY KEY (`concept`,`term`),
  ADD UNIQUE KEY `keyword_unique` (`keyword`),
  ADD KEY `concept_foreign` (`concept`);

--
-- Indexes for table `ark_vocabulary_type`
--
ALTER TABLE `ark_vocabulary_type`
  ADD PRIMARY KEY (`type`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_workflow_action`
--
ALTER TABLE `ark_workflow_action`
  ADD PRIMARY KEY (`schma`,`action`),
  ADD KEY `schema_foreign` (`schma`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `event_foreign` (`event_vocabulary`,`event_term`);

--
-- Indexes for table `ark_workflow_agency`
--
ALTER TABLE `ark_workflow_agency`
  ADD PRIMARY KEY (`schma`,`action`,`class`,`attribute`),
  ADD KEY `attribute_foreign` (`schma`,`class`,`attribute`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `condition_foreign` (`schma`,`class`,`condition_attribute`);

--
-- Indexes for table `ark_workflow_allow`
--
ALTER TABLE `ark_workflow_allow`
  ADD PRIMARY KEY (`schma`,`action`,`role`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `schema_foreign` (`schma`),
  ADD KEY `role_foreign` (`role`);

--
-- Indexes for table `ark_workflow_condition`
--
ALTER TABLE `ark_workflow_condition`
  ADD PRIMARY KEY (`schma`,`action`,`class`,`attribute`,`grp`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `attribute_foreign` (`schma`,`class`,`attribute`);

--
-- Indexes for table `ark_workflow_grant`
--
ALTER TABLE `ark_workflow_grant`
  ADD PRIMARY KEY (`role`,`permission`),
  ADD KEY `role_foreign` (`role`),
  ADD KEY `permission_foreign` (`permission`);

--
-- Indexes for table `ark_workflow_notify`
--
ALTER TABLE `ark_workflow_notify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_foreign` (`schma`,`class`,`attribute`),
  ADD KEY `keyword_foreign` (`keyword`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `role_foreign` (`role`);

--
-- Indexes for table `ark_workflow_permission`
--
ALTER TABLE `ark_workflow_permission`
  ADD PRIMARY KEY (`permission`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_workflow_role`
--
ALTER TABLE `ark_workflow_role`
  ADD PRIMARY KEY (`role`),
  ADD KEY `keyword_foreign` (`keyword`);

--
-- Indexes for table `ark_workflow_trigger`
--
ALTER TABLE `ark_workflow_trigger`
  ADD PRIMARY KEY (`schma`,`action`,`trigger_schma`,`trigger_action`),
  ADD KEY `schema_foreign` (`schma`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `trigger_foreign` (`trigger_schma`,`trigger_action`);

--
-- Indexes for table `ark_workflow_update`
--
ALTER TABLE `ark_workflow_update`
  ADD PRIMARY KEY (`schma`,`action`,`class`,`attribute`),
  ADD KEY `schema_foreign` (`schma`,`class`,`attribute`),
  ADD KEY `action_foreign` (`schma`,`action`),
  ADD KEY `source_foreign` (`schma`,`class`,`source`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ark_workflow_notify`
--
ALTER TABLE `ark_workflow_notify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_dataclass`
--
ALTER TABLE `ark_dataclass`
  ADD CONSTRAINT `dataclass_datatype_constraint` FOREIGN KEY (`datatype`) REFERENCES `ark_dataclass_type` (`datatype`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_format_constraint` FOREIGN KEY (`format_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_parameter_constraint` FOREIGN KEY (`parameter_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_attribute`
--
ALTER TABLE `ark_dataclass_attribute`
  ADD CONSTRAINT `dataclass_attribute_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_attribute_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_attribute_parent_constraint` FOREIGN KEY (`parent`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_attribute_vocabulary_constraint` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_blob`
--
ALTER TABLE `ark_dataclass_blob`
  ADD CONSTRAINT `dataclass_blob_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_boolean`
--
ALTER TABLE `ark_dataclass_boolean`
  ADD CONSTRAINT `dataclass_boolean_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_date`
--
ALTER TABLE `ark_dataclass_date`
  ADD CONSTRAINT `dataclass_date_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_datetime`
--
ALTER TABLE `ark_dataclass_datetime`
  ADD CONSTRAINT `dataclass_datetime_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_decimal`
--
ALTER TABLE `ark_dataclass_decimal`
  ADD CONSTRAINT `dataclass_decimal_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_float`
--
ALTER TABLE `ark_dataclass_float`
  ADD CONSTRAINT `dataclass_float_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_integer`
--
ALTER TABLE `ark_dataclass_integer`
  ADD CONSTRAINT `dataclass_integer_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_item`
--
ALTER TABLE `ark_dataclass_item`
  ADD CONSTRAINT `dataclass_item_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_item_module_constraint` FOREIGN KEY (`module`) REFERENCES `ark_module` (`module`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_object`
--
ALTER TABLE `ark_dataclass_object`
  ADD CONSTRAINT `dataclass_object_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_spatial`
--
ALTER TABLE `ark_dataclass_spatial`
  ADD CONSTRAINT `dataclass_spatial_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_string`
--
ALTER TABLE `ark_dataclass_string`
  ADD CONSTRAINT `dataclass_string_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_text`
--
ALTER TABLE `ark_dataclass_text`
  ADD CONSTRAINT `dataclass_text_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_time`
--
ALTER TABLE `ark_dataclass_time`
  ADD CONSTRAINT `dataclass_time_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_dataclass_type`
--
ALTER TABLE `ark_dataclass_type`
  ADD CONSTRAINT `dataclass_type_format_constraint` FOREIGN KEY (`format_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_type_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `dataclass_type_parameter_constraint` FOREIGN KEY (`parameter_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_instance_route`
--
ALTER TABLE `ark_instance_route`
  ADD CONSTRAINT `instance_route_instance_constraint` FOREIGN KEY (`instance`) REFERENCES `ark_instance` (`instance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instance_route_route_constraint` FOREIGN KEY (`route`) REFERENCES `ark_route` (`route`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_instance_schema`
--
ALTER TABLE `ark_instance_schema`
  ADD CONSTRAINT `instance_schema_instance_constraint` FOREIGN KEY (`instance`) REFERENCES `ark_instance` (`instance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `instance_schema_schema_constraint` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_map`
--
ALTER TABLE `ark_map`
  ADD CONSTRAINT `map_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_map_layer`
--
ALTER TABLE `ark_map_layer`
  ADD CONSTRAINT `map_layer_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `map_layer_source_constraint` FOREIGN KEY (`source`) REFERENCES `ark_map_source` (`source`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_map_legend`
--
ALTER TABLE `ark_map_legend`
  ADD CONSTRAINT `map_legend_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `map_legend_layer_constraint` FOREIGN KEY (`source`,`layer`) REFERENCES `ark_map_layer` (`source`, `layer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `map_legend_map_constraint` FOREIGN KEY (`map`) REFERENCES `ark_map` (`map`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_map_source`
--
ALTER TABLE `ark_map_source`
  ADD CONSTRAINT `map_source_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_module`
--
ALTER TABLE `ark_module`
  ADD CONSTRAINT `module_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_route`
--
ALTER TABLE `ark_route`
  ADD CONSTRAINT `route_page_constraint` FOREIGN KEY (`page`) REFERENCES `ark_view_page` (`element`) ON UPDATE CASCADE,
  ADD CONSTRAINT `route_redirect_constraint` FOREIGN KEY (`redirect`) REFERENCES `ark_route` (`route`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_route_parameter`
--
ALTER TABLE `ark_route_parameter`
  ADD CONSTRAINT `route_constraint` FOREIGN KEY (`route`) REFERENCES `ark_route` (`route`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema`
--
ALTER TABLE `ark_schema`
  ADD CONSTRAINT `schema_edit_constraint` FOREIGN KEY (`edit`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_event_constraint` FOREIGN KEY (`event`) REFERENCES `ark_vocabulary` (`concept`),
  ADD CONSTRAINT `schema_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_module_constraint` FOREIGN KEY (`module`) REFERENCES `ark_module` (`module`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_new_constraint` FOREIGN KEY (`new`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_remove_constraint` FOREIGN KEY (`remove`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_view_constraint` FOREIGN KEY (`view`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_vocabulary_constraint` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD CONSTRAINT `schema_association_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_association_schema1_constraint` FOREIGN KEY (`schema1`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_association_schema2_constraint` FOREIGN KEY (`schema2`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_association_schema_constraint` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD CONSTRAINT `schema_attribute_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_attribute_edit_constraint` FOREIGN KEY (`edit`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_attribute_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_attribute_schema_constraint` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_attribute_view_constraint` FOREIGN KEY (`view`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_attribute_vocabulary_constraint` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_item`
--
ALTER TABLE `ark_schema_item`
  ADD CONSTRAINT `schema_item_dataclass_constraint` FOREIGN KEY (`dataclass`) REFERENCES `ark_dataclass` (`dataclass`) ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_item_vocabulary_constraint` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation`
--
ALTER TABLE `ark_translation`
  ADD CONSTRAINT `translation_domain_constraint` FOREIGN KEY (`domain`) REFERENCES `ark_translation_domain` (`domain`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_domain`
--
ALTER TABLE `ark_translation_domain`
  ADD CONSTRAINT `translation_domain_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_message`
--
ALTER TABLE `ark_translation_message`
  ADD CONSTRAINT `translation_message_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `translation_message_language_constraint` FOREIGN KEY (`language`) REFERENCES `ark_translation_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `translation_message_role_constraint` FOREIGN KEY (`role`) REFERENCES `ark_translation_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_parameter`
--
ALTER TABLE `ark_translation_parameter`
  ADD CONSTRAINT `translation_parameter_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_role`
--
ALTER TABLE `ark_translation_role`
  ADD CONSTRAINT `translation_role_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_cell`
--
ALTER TABLE `ark_view_cell`
  ADD CONSTRAINT `view_cell_action_constraint` FOREIGN KEY (`action_schema`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_edit_constraint` FOREIGN KEY (`edit`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_group_constraint` FOREIGN KEY (`grp`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_map_constraint` FOREIGN KEY (`map`) REFERENCES `ark_map` (`map`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_view_constraint` FOREIGN KEY (`view`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_cell_vocabulary_constraint` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_element`
--
ALTER TABLE `ark_view_element`
  ADD CONSTRAINT `view_element_type_constraint` FOREIGN KEY (`type`) REFERENCES `ark_view_type` (`type`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_field`
--
ALTER TABLE `ark_view_field`
  ADD CONSTRAINT `view_field_attribute_constraint` FOREIGN KEY (`schma`,`class`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_field_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_field_keyword` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_form`
--
ALTER TABLE `ark_view_form`
  ADD CONSTRAINT `view_form_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_form_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `view_form_route_constraint` FOREIGN KEY (`action`) REFERENCES `ark_route` (`route`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_group`
--
ALTER TABLE `ark_view_group`
  ADD CONSTRAINT `view_group_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_group_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_nav`
--
ALTER TABLE `ark_view_nav`
  ADD CONSTRAINT `view_nav_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_nav_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `view_nav_parent_constraint` FOREIGN KEY (`parent`) REFERENCES `ark_view_nav` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_page`
--
ALTER TABLE `ark_view_page`
  ADD CONSTRAINT `view_page_content_constraint` FOREIGN KEY (`content`) REFERENCES `ark_view_element` (`element`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_edit_constraint` FOREIGN KEY (`edit`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_footer_constraint` FOREIGN KEY (`footer`) REFERENCES `ark_view_element` (`element`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_header_constraint` FOREIGN KEY (`header`) REFERENCES `ark_view_element` (`element`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_sidebar_constraint` FOREIGN KEY (`sidebar`) REFERENCES `ark_view_element` (`element`) ON UPDATE CASCADE,
  ADD CONSTRAINT `view_page_view_constraint` FOREIGN KEY (`view`) REFERENCES `ark_workflow_permission` (`permission`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_table`
--
ALTER TABLE `ark_view_table`
  ADD CONSTRAINT `view_table_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viewtable_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  ADD CONSTRAINT `view_tree_ancestor_constraint` FOREIGN KEY (`ancestor`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_tree_descendent_constraint` FOREIGN KEY (`descendant`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_type`
--
ALTER TABLE `ark_view_type`
  ADD CONSTRAINT `view_type_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_widget`
--
ALTER TABLE `ark_view_widget`
  ADD CONSTRAINT `view_widget_element_constraint` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_widget_keyword_contraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary`
--
ALTER TABLE `ark_vocabulary`
  ADD CONSTRAINT `vocabulary_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `vocabulary_type_constraint` FOREIGN KEY (`type`) REFERENCES `ark_vocabulary_type` (`type`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_parameter`
--
ALTER TABLE `ark_vocabulary_parameter`
  ADD CONSTRAINT `vocabulary_parameter_term_constraint` FOREIGN KEY (`concept`,`term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_related`
--
ALTER TABLE `ark_vocabulary_related`
  ADD CONSTRAINT `vocabulary_related_from_constraint` FOREIGN KEY (`from_concept`,`from_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vocabulary_related_relation_constraint` FOREIGN KEY (`relation`) REFERENCES `ark_vocabulary_relation` (`relation`) ON DELETE CASCADE,
  ADD CONSTRAINT `vocabulary_related_to_constraint` FOREIGN KEY (`to_concept`,`to_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_term`
--
ALTER TABLE `ark_vocabulary_term`
  ADD CONSTRAINT `vocabulary_term_concept_constraint` FOREIGN KEY (`concept`) REFERENCES `ark_vocabulary` (`concept`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vocabulary_term_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_type`
--
ALTER TABLE `ark_vocabulary_type`
  ADD CONSTRAINT `vocabulary_type_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_action`
--
ALTER TABLE `ark_workflow_action`
  ADD CONSTRAINT `workflow_action_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_action_schema_constraint` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_action_term_constraint` FOREIGN KEY (`event_vocabulary`,`event_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_agency`
--
ALTER TABLE `ark_workflow_agency`
  ADD CONSTRAINT `workflow_agency_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_agency_attribute_constraint` FOREIGN KEY (`schma`,`class`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_agency_condition_constraint` FOREIGN KEY (`schma`,`class`,`condition_attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_allow`
--
ALTER TABLE `ark_workflow_allow`
  ADD CONSTRAINT `workflow_allow_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_allow_role_constraint` FOREIGN KEY (`role`) REFERENCES `ark_workflow_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_condition`
--
ALTER TABLE `ark_workflow_condition`
  ADD CONSTRAINT `workflow_condition_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_condition_attribute_constraint` FOREIGN KEY (`schma`,`class`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_grant`
--
ALTER TABLE `ark_workflow_grant`
  ADD CONSTRAINT `workflow_grant_permission_constraint` FOREIGN KEY (`permission`) REFERENCES `ark_workflow_permission` (`permission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_grant_role_constraint` FOREIGN KEY (`role`) REFERENCES `ark_workflow_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_notify`
--
ALTER TABLE `ark_workflow_notify`
  ADD CONSTRAINT `workflow_notify_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_notify_attribute_constraint` FOREIGN KEY (`schma`,`class`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_notify_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_notify_role_constraint` FOREIGN KEY (`role`) REFERENCES `ark_workflow_role` (`role`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_permission`
--
ALTER TABLE `ark_workflow_permission`
  ADD CONSTRAINT `workflow_permission_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_role`
--
ALTER TABLE `ark_workflow_role`
  ADD CONSTRAINT `workflow_role_keyword_constraint` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_trigger`
--
ALTER TABLE `ark_workflow_trigger`
  ADD CONSTRAINT `workflow_trigger_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_trigger_trigger_constraint` FOREIGN KEY (`trigger_schma`,`trigger_action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_update`
--
ALTER TABLE `ark_workflow_update`
  ADD CONSTRAINT `workflow_update_action_constraint` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_update_agency_constraint` FOREIGN KEY (`schma`,`class`,`source`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_update_attribute_constraint` FOREIGN KEY (`schma`,`class`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `class`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;