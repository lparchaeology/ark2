-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2017 at 10:24 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mno12_ark_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `ark_config_error`
--

CREATE TABLE `ark_config_error` (
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_config_flash`
--

CREATE TABLE `ark_config_flash` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_config_thumbnail`
--

CREATE TABLE `ark_config_thumbnail` (
  `profile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max` int(11) NOT NULL,
  `min` int(11) DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_datatype`
--

CREATE TABLE `ark_datatype` (
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object` tinyint(1) NOT NULL DEFAULT '0',
  `compound` tinyint(1) NOT NULL DEFAULT '1',
  `storage_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_size` int(11) DEFAULT NULL,
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spanable` tinyint(1) NOT NULL DEFAULT '1',
  `model_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_datatype`
--

INSERT INTO `ark_datatype` (`datatype`, `format_vocabulary`, `parameter_vocabulary`, `object`, `compound`, `storage_type`, `storage_size`, `value_name`, `format_name`, `parameter_name`, `spanable`, `model_table`, `model_class`, `data_table`, `data_class`, `form_class`, `enabled`, `deprecated`, `keyword`) VALUES
('blob', 'mediatype', NULL, 0, 1, 'blob', NULL, 'blob', 'mediatype', NULL, 0, 'ark_format_blob', 'ARK\\Model\\Format\\BlobFormat', 'ark_fragment_blob', 'ARK\\Model\\Fragment\\BlobFragment', '', 0, 0, 'core.datatype.blob'),
('boolean', NULL, NULL, 0, 0, 'boolean', NULL, NULL, NULL, NULL, 0, 'ark_format_boolean', 'ARK\\Model\\Format\\BooleanFormat', 'ark_fragment_boolean', 'ARK\\Model\\Fragment\\BooleanFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', 1, 0, 'core.datatype.boolean'),
('date', NULL, NULL, 0, 0, 'date', NULL, NULL, NULL, NULL, 1, 'ark_format_datetime', 'ARK\\Model\\Format\\DateFormat', 'ark_fragment_date', 'ARK\\Model\\Fragment\\DateFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', 1, 0, 'core.datatype.date'),
('datetime', NULL, NULL, 0, 0, 'datetime', NULL, NULL, NULL, NULL, 1, 'ark_format_datetime', 'ARK\\Model\\Format\\DateTimeFormat', 'ark_fragment_datetime', 'ARK\\Model\\Fragment\\DateTimeFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateTimeType', 1, 0, 'core.datatype.datetime'),
('decimal', NULL, NULL, 0, 0, 'string', 200, NULL, NULL, NULL, 1, 'ark_format_decimal', 'ARK\\Model\\Format\\DecimalFormat', 'ark_fragment_decimal', 'ARK\\Model\\Fragment\\DecimalFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 1, 0, 'core.datatype.decimal'),
('float', NULL, NULL, 0, 0, 'float', NULL, NULL, NULL, NULL, 1, 'ark_format_float', 'ARK\\Model\\Format\\FloatFormat', 'ark_fragment_float', 'ARK\\Model\\Fragment\\FloatFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 1, 0, 'core.datatype.float'),
('integer', NULL, NULL, 0, 0, 'integer', NULL, NULL, NULL, NULL, 1, 'ark_format_integer', 'ARK\\Model\\Format\\IntegerFormat', 'ark_fragment_integer', 'ARK\\Model\\Fragment\\IntegerFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', 1, 0, 'core.datatype.integer'),
('item', NULL, NULL, 0, 1, 'string', 30, 'item', NULL, 'module', 1, 'ark_format_item', 'ARK\\Model\\Format\\ItemFormat', 'ark_fragment_item', 'ARK\\Model\\Fragment\\ItemFragment', '', 1, 0, 'core.datatype.item'),
('object', NULL, NULL, 1, 0, 'integer', 0, NULL, NULL, NULL, 0, 'ark_format_object', 'ARK\\Model\\Format\\ObjectFormat', 'ark_fragment_object', 'ARK\\Model\\Fragment\\ObjectFragment', '', 1, 0, 'core.datatype.object'),
('spatial', 'spatial.format', 'spatial.crs', 0, 1, 'string', 1431655765, 'geometry', 'format', 'srid', 0, 'ark_format_spatial', 'ARK\\Model\\Format\\SpatialFormat', 'ark_fragment_spatial', 'ARK\\Model\\Fragment\\SpatialFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 1, 0, 'core.datatype.spatial'),
('string', NULL, NULL, 0, 0, 'string', 4000, NULL, NULL, NULL, 1, 'ark_format_string', 'ARK\\Model\\Format\\StringFormat', 'ark_fragment_string', 'ARK\\Model\\Fragment\\StringFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 1, 0, 'core.datatype.string'),
('text', 'mediatype', 'language', 0, 1, 'string', 1431655765, 'content', 'mimetype', 'language', 0, 'ark_format_text', 'ARK\\Model\\Format\\TextFormat', 'ark_fragment_text', 'ARK\\Model\\Fragment\\TextFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextAreaType', 1, 0, 'core.datatype.text'),
('time', NULL, NULL, 0, 0, 'time', NULL, NULL, NULL, NULL, 1, 'ark_format_datetime', 'ARK\\Model\\Format\\TimeFormat', 'ark_fragment_time', 'ARK\\Model\\Fragment\\TimeFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', 0, 0, 'core.datatype.time');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format`
--

CREATE TABLE `ark_format` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object` tinyint(1) NOT NULL DEFAULT '0',
  `array` tinyint(1) NOT NULL DEFAULT '0',
  `multiple` tinyint(1) NOT NULL DEFAULT '0',
  `sortable` tinyint(1) NOT NULL DEFAULT '1',
  `searchable` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format`
--

INSERT INTO `ark_format` (`format`, `datatype`, `parameter_vocabulary`, `format_vocabulary`, `value_name`, `parameter_name`, `format_name`, `input`, `object`, `array`, `multiple`, `sortable`, `searchable`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'item', NULL, NULL, NULL, NULL, NULL, 'select', 0, 0, 0, 0, 0, 1, 0, 'format.actor'),
('address', 'object', NULL, NULL, NULL, NULL, NULL, '', 1, 0, 0, 0, 1, 1, 0, 'format.address'),
('blob', 'blob', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, 0, 1, 0, 'format.blob'),
('boolean', 'boolean', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 1, 1, 1, 0, 'format.boolean'),
('color', 'string', NULL, NULL, NULL, NULL, NULL, 'color', 0, 0, 0, 1, 1, 1, 0, 'format.colour'),
('date', 'date', NULL, NULL, NULL, NULL, NULL, 'date', 0, 0, 0, 1, 1, 1, 0, 'format.date'),
('datetime', 'datetime', NULL, NULL, NULL, NULL, NULL, 'date', 0, 0, 0, 1, 1, 1, 0, 'format.datetime'),
('decimal', 'decimal', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.decimal'),
('distance', 'decimal', 'distance', NULL, 'measurement', 'unit', NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.distance'),
('email', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.email'),
('event', 'object', NULL, NULL, NULL, NULL, NULL, '', 1, 0, 0, 0, 1, 1, 0, 'format.event'),
('fileversion', 'object', NULL, NULL, NULL, NULL, NULL, '', 1, 0, 0, 0, 1, 1, 0, 'format.fileversion'),
('float', 'float', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.float'),
('html', 'text', NULL, NULL, NULL, NULL, NULL, 'textarea', 1, 0, 1, 1, 1, 1, 0, 'format.html'),
('identifier', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.identifier'),
('integer', 'integer', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.integer'),
('item', 'item', NULL, NULL, NULL, NULL, NULL, 'select', 0, 0, 0, 0, 0, 1, 0, 'format.item'),
('key', 'string', NULL, NULL, NULL, NULL, NULL, 'select', 0, 0, 0, 1, 1, 1, 0, 'format.key'),
('markdown', 'text', NULL, NULL, NULL, NULL, NULL, 'textarea', 1, 0, 1, 1, 1, 1, 0, 'format.markdown'),
('mass', 'decimal', 'mass', NULL, 'measurement', 'unit', NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.mass'),
('module', 'string', NULL, NULL, NULL, NULL, NULL, 'select', 0, 0, 0, 0, 0, 1, 0, 'format.module'),
('money', 'decimal', NULL, NULL, NULL, NULL, NULL, 'date', 0, 0, 0, 1, 1, 1, 0, 'format.money'),
('ordinaldate', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.ordinaldate'),
('password', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.password'),
('percent', 'float', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.percent'),
('plaintext', 'text', NULL, NULL, NULL, NULL, NULL, 'textarea', 1, 0, 1, 1, 1, 1, 0, 'format.localtext'),
('richtext', 'text', NULL, NULL, NULL, NULL, NULL, 'textarea', 1, 0, 1, 1, 1, 1, 0, 'format.richtext'),
('shorttext', 'text', NULL, NULL, NULL, NULL, NULL, 'text', 1, 0, 1, 1, 1, 1, 0, 'format.shortlocaltext'),
('spatial', 'spatial', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.geometry'),
('string', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.string'),
('telephone', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.telephone'),
('time', 'time', NULL, NULL, NULL, NULL, NULL, 'date', 0, 0, 0, 1, 1, 1, 0, 'format.time'),
('url', 'text', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 1, 1, 1, 1, 0, 'format.url'),
('weekdate', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.weekdate'),
('wkt', 'spatial', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 0, 1, 1, 0, 'format.wkt'),
('yearmonth', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.yearmonth'),
('yearweek', 'string', NULL, NULL, NULL, NULL, NULL, 'text', 0, 0, 0, 1, 1, 1, 0, 'format.yearweek');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_attribute`
--

CREATE TABLE `ark_format_attribute` (
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `root` tinyint(1) NOT NULL DEFAULT '0',
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_attribute`
--

INSERT INTO `ark_format_attribute` (`parent`, `attribute`, `vocabulary`, `format`, `sequence`, `root`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('address', 'city', NULL, 'plaintext', 1, 0, 1, 1, 1, 0, 1, 0, 'format.address.city'),
('address', 'country', 'country', 'identifier', 2, 0, 1, 1, 1, 0, 1, 0, 'format.address.country'),
('address', 'street', NULL, 'plaintext', 0, 1, 1, 1, 1, 0, 1, 0, 'format.address.street'),
('event', 'by', NULL, 'actor', 0, 1, 1, 1, 1, 0, 1, 0, 'format.event.by'),
('event', 'on', NULL, 'datetime', 1, 1, 1, 1, 1, 0, 1, 0, 'format.event.on'),
('fileversion', 'created', NULL, 'event', 3, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.created'),
('fileversion', 'expires', NULL, 'datetime', 5, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.expires'),
('fileversion', 'modified', NULL, 'event', 4, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.modified'),
('fileversion', 'name', NULL, 'string', 1, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.name'),
('fileversion', 'sequence', NULL, 'integer', 0, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.sequence'),
('fileversion', 'version', NULL, 'string', 2, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.string');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_blob`
--

CREATE TABLE `ark_format_blob` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_blob`
--

INSERT INTO `ark_format_blob` (`format`) VALUES
('blob');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_boolean`
--

CREATE TABLE `ark_format_boolean` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_boolean`
--

INSERT INTO `ark_format_boolean` (`format`) VALUES
('boolean');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_datetime`
--

CREATE TABLE `ark_format_datetime` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unicode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_datetime`
--

INSERT INTO `ark_format_datetime` (`format`, `pattern`, `unicode`) VALUES
('date', '^([0-9]{4})(-)(1[0-2]|0[1-9])\\\\2(3[01]|0[1-9]|[12][0-9])$', ''),
('datetime', '^([0-9]{4})-(1[0-2]|0[1-9])-(3[01]|0[1-9]|[12][0-9])T(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])$', ''),
('ordinaldate', '^([0-9]{4})-(36[0-6]|3[0-5][0-9]|[12][0-9]{2}|0[1-9][0-9]|00[1-9])$', ''),
('time', '^(2[0-3]|[01][0-9]):([0-5][0-9])$', ''),
('weekdate', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])-([1-7])$', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_decimal`
--

CREATE TABLE `ark_format_decimal` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prec` int(11) NOT NULL DEFAULT '200',
  `scale` int(11) NOT NULL DEFAULT '0',
  `minimum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT '0',
  `maximum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_of` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_decimal`
--

INSERT INTO `ark_format_decimal` (`format`, `prec`, `scale`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`) VALUES
('decimal', 100, 100, NULL, 0, NULL, 0, ''),
('mass', 100, 100, NULL, 0, NULL, 0, ''),
('money', 198, 2, NULL, 0, NULL, 0, '0.01');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_float`
--

CREATE TABLE `ark_format_float` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` double DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT '0',
  `maximum` double DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_of` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_float`
--

INSERT INTO `ark_format_float` (`format`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`) VALUES
('float', NULL, 0, NULL, 0, NULL),
('percent', 0, 0, 100, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_integer`
--

CREATE TABLE `ark_format_integer` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimum` int(11) DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL DEFAULT '0',
  `maximum` int(11) DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL DEFAULT '0',
  `multiple_of` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_integer`
--

INSERT INTO `ark_format_integer` (`format`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`) VALUES
('integer', -2147483648, 0, 2147483647, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_item`
--

CREATE TABLE `ark_format_item` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_item`
--

INSERT INTO `ark_format_item` (`format`, `module`) VALUES
('item', NULL),
('actor', 'actor');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_object`
--

CREATE TABLE `ark_format_object` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_object`
--

INSERT INTO `ark_format_object` (`format`) VALUES
('address'),
('distance'),
('mass');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_spatial`
--

CREATE TABLE `ark_format_spatial` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_spatial`
--

INSERT INTO `ark_format_spatial` (`format`) VALUES
('spatial'),
('wkt');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_string`
--

CREATE TABLE `ark_format_string` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_string`
--

INSERT INTO `ark_format_string` (`format`, `pattern`, `min_length`, `max_length`, `default_size`) VALUES
('color', '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$', 4, 7, 10),
('email', '^(?!^.{254})(([^@]+)@([^@]+))$', 3, 254, 30),
('identifier', '^(\\w{1,30})$', 1, 30, 30),
('key', '^(\\w{1,50})$', 1, 50, 50),
('module', '^(\\w{1,3})$', 3, 3, 3),
('telephone', '^([0-9+\\(\\)#\\.\\s\\/x-]+)$', 1, 30, 30),
('yearmonth', '^([0-9]{4})-(1[0-2]|0[1-9])$', 6, 7, 7),
('yearweek', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])$', 7, 8, 8);

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_text`
--

CREATE TABLE `ark_format_text` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mimetype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_text`
--

INSERT INTO `ark_format_text` (`format`, `mimetype`, `min_length`, `max_length`, `default_size`) VALUES
('html', 'text/html', 1, 1431655765, 30),
('markdown', 'text/markdown', 1, 1431655765, 30),
('plaintext', 'text/plain', 1, 1431655765, 30),
('richtext', 'text/richtext', 1, 1431655765, 30),
('shorttext', 'text/plain', 1, 100, 30),
('url', 'text/url', 1, 2083, 50);

-- --------------------------------------------------------

--
-- Table structure for table `ark_instance`
--

CREATE TABLE `ark_instance` (
  `instance` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_instance_schema`
--

CREATE TABLE `ark_instance_schema` (
  `instance` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_map`
--

CREATE TABLE `ark_map` (
  `map` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `draggable` tinyint(1) NOT NULL DEFAULT '1',
  `zoomable` tinyint(1) NOT NULL DEFAULT '1',
  `clickable` tinyint(1) NOT NULL DEFAULT '1',
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_layer`
--

CREATE TABLE `ark_map_layer` (
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layer` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_map_layer`
--

INSERT INTO `ark_map_layer` (`source`, `layer`, `source_name`, `url`, `options`, `parameters`, `keyword`) VALUES
('bing', 'aerial', 'Aerial', '', '', '', 'map.layer.bing.aerial'),
('bing', 'aerialwithlabels', 'AerialWithLabels', '', '', '', 'map.layer.bing.aerialwithlabels'),
('bing', 'road', 'Road', '', '', '', 'map.layer.bing.road');

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_legend`
--

CREATE TABLE `ark_map_legend` (
  `map` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layer` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_map_source`
--

CREATE TABLE `ark_map_source` (
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_expiry` datetime DEFAULT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_module`
--

CREATE TABLE `ark_module` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `classname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_module`
--

INSERT INTO `ark_module` (`module`, `resource`, `project`, `namespace`, `entity`, `classname`, `tbl`, `core`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'actors', 'ARK', 'ARK\\Entity', 'Actor', 'ARK\\Entity\\Actor', 'ark_item_actor', 1, 1, 0, 'module.actor'),
('context', 'contexts', 'ARK', 'ARK\\Entity', 'Context', 'ARK\\Entity\\Context', 'ark_item_context', 0, 1, 0, 'module.context'),
('file', 'files', 'ARK', 'ARK\\File', 'File', 'ARK\\File\\File', 'ark_item_file', 1, 1, 0, 'module.file'),
('find', 'finds', 'ARK', 'ARK\\Entity', 'Find', 'ARK\\Entity\\Find', 'ark_item_find', 0, 1, 0, 'module.find'),
('group', 'groups', 'ARK', 'ARK\\Entity', 'Group', 'ARK\\Entity\\Group', 'ark_item_group', 0, 1, 0, 'module.group'),
('page', '', 'ARK', 'ARK\\Entity', 'Page', 'ARK\\Entity\\Page', 'ark_item_page', 1, 1, 0, 'module.page'),
('photo', 'photos', 'ARK', 'ARK\\Entity', 'Photo', 'ARK\\Entity\\Photo', 'ark_item_photo', 0, 1, 0, 'module.photo'),
('plan', 'plans', 'ARK', 'ARK\\Entity', 'Plan', 'ARK\\Entity\\Plan', 'ark_item_plan', 0, 1, 0, 'module.plan'),
('sample', 'samples', 'ARK', 'ARK\\Entity', 'Sample', 'ARK\\Entity\\Sample', 'ark_item_sample', 0, 1, 0, 'module.sample'),
('section', 'sections', 'ARK', 'ARK\\Entity', 'Section', 'ARK\\Entity\\Section', 'ark_item_section', 0, 1, 0, 'module.section'),
('site', 'sites', 'ARK', 'ARK\\Entity', 'Site', 'ARK\\Entity\\Site', 'ark_item_site', 1, 1, 0, 'module.site'),
('subgroup', 'subgroups', 'ARK', 'ARK\\Entity', 'Subgroup', 'ARK\\Entity\\Subgroup', 'ark_item_subgroup', 0, 1, 0, 'module.subgroup'),
('timber', 'timbers', 'ARK', 'ARK\\Entity', 'Timber', 'ARK\\Entity\\Timber', 'ark_item_timber', 0, 1, 0, 'module.timber');

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_action`
--

CREATE TABLE `ark_rbac_action` (
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_permission`
--

CREATE TABLE `ark_rbac_permission` (
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_role`
--

CREATE TABLE `ark_rbac_role` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_role_action`
--

CREATE TABLE `ark_rbac_role_action` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_role_permission`
--

CREATE TABLE `ark_rbac_role_permission` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_route`
--

CREATE TABLE `ark_route` (
  `route` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `controller` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_route`
--

INSERT INTO `ark_route` (`route`, `method`, `path`, `controller`, `page`, `enabled`) VALUES
('core.about', 'GET', '/about', 'ARK\\Controller\\StaticPageController', 'core_page_static', 1),
('core.home', 'GET', '/', 'ARK\\Controller\\StaticPageController', 'core_page_static', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema`
--

CREATE TABLE `ark_schema` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generator` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_entities` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema`
--

INSERT INTO `ark_schema` (`schma`, `module`, `generator`, `sequence`, `type`, `type_vocabulary`, `type_entities`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'actor', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 'type', 'core.actor.type', 1, 1, 0, 'core.actor'),
('core.file', 'file', 'ARK\\ORM\\Id\\IdentityGenerator', NULL, 'type', 'core.file.type', 1, 1, 0, 'core.file'),
('core.page', 'page', '', '', '', '', 0, 1, 0, 'core.page'),
('mno12.context', 'context', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 'type', 'mno12.context.type', 0, 1, 0, 'mno12.context.schema'),
('mno12.find', 'find', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 'type', 'mno12.find.type', 0, 1, 0, 'mno12.find.schema'),
('mno12.group', 'group', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.group.schema'),
('mno12.photo', 'photo', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.photo.schema'),
('mno12.plan', 'plan', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.plan.schema'),
('mno12.sample', 'sample', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.sample.schema'),
('mno12.section', 'section', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.section.schema'),
('mno12.subgroup', 'subgroup', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.subgroup.schema'),
('mno12.timber', 'timber', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'mno12.timber.schema');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_association`
--

CREATE TABLE `ark_schema_association` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inverse` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` int(11) NOT NULL,
  `inverse_degree` int(11) NOT NULL,
  `bidirectional` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_attribute`
--

CREATE TABLE `ark_schema_attribute` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_attribute`
--

INSERT INTO `ark_schema_attribute` (`schma`, `type`, `attribute`, `format`, `vocabulary`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.actor.id'),
('core.actor', '', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.actor.type'),
('core.file', '', 'description', 'plaintext', NULL, 0, 1, 1, 0, 1, 0, 'core.file.description'),
('core.file', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.id'),
('core.file', '', 'mediatype', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.mediatype'),
('core.file', '', 'status', 'identifier', 'core.file.status', 1, 1, 1, 0, 1, 0, 'core.file.status'),
('core.file', '', 'title', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'core.file.title'),
('core.file', '', 'type', 'identifier', 'core.file.type', 1, 1, 1, 0, 1, 0, 'core.file.type'),
('core.file', '', 'versions', 'fileversion', NULL, 1, 0, 1, 0, 1, 0, 'core.file.versions'),
('core.page', '', 'content', 'html', NULL, 1, 1, 1, 0, 1, 0, 'property.content'),
('core.page', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.page.id');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_item`
--

CREATE TABLE `ark_schema_item` (
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_item`
--

INSERT INTO `ark_schema_item` (`attribute`, `format`, `vocabulary`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.id'),
('index', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.index'),
('label', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.label'),
('module', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.module'),
('schema', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.module'),
('status', 'identifier', 'core.item.status', 1, 1, 1, 0, 1, 0, 'core.item.status'),
('type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.item.type');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation`
--

CREATE TABLE `ark_translation` (
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_plural` tinyint(1) NOT NULL DEFAULT '0',
  `has_parameters` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation`
--

INSERT INTO `ark_translation` (`keyword`, `domain`, `is_plural`, `has_parameters`) VALUES
('association.contact', 'core', 0, 0),
('core.actor.institution', 'core', 0, 0),
('core.actor.person', 'core', 0, 0),
('core.nav.dashboard', 'core', 0, 0),
('core.nav.records', 'core', 0, 0),
('core.nav.user.login', 'core', 0, 0),
('file.type.audio', 'core', 0, 0),
('file.type.document', 'core', 0, 0),
('file.type.image', 'core', 0, 0),
('file.type.other', 'core', 0, 0),
('file.type.text', 'core', 0, 0),
('file.type.video', 'core', 0, 0),
('form.select.optional', 'core', 0, 0),
('form.select.required', 'core', 0, 0),
('format.actor', 'core', 0, 0),
('format.address', 'core', 0, 0),
('format.blob', 'core', 0, 0),
('format.boolean', 'core', 0, 0),
('format.colour', 'core', 0, 0),
('format.date', 'core', 0, 0),
('format.datetime', 'core', 0, 0),
('format.decimal', 'core', 0, 0),
('format.email', 'core', 0, 0),
('format.float', 'core', 0, 0),
('format.html', 'core', 0, 0),
('format.identifier', 'core', 0, 0),
('format.integer', 'core', 0, 0),
('format.item', 'core', 0, 0),
('format.key', 'core', 0, 0),
('format.markdown', 'core', 0, 0),
('format.module', 'core', 0, 0),
('format.money', 'core', 0, 0),
('format.ordinaldate', 'core', 0, 0),
('format.password', 'core', 0, 0),
('format.percent', 'core', 0, 0),
('format.richtext', 'core', 0, 0),
('format.search', 'core', 0, 0),
('format.shorttext', 'core', 0, 0),
('format.string', 'core', 0, 0),
('format.telephone', 'core', 0, 0),
('format.text', 'core', 0, 0),
('format.time', 'core', 0, 0),
('format.url', 'core', 0, 0),
('format.weekdate', 'core', 0, 0),
('format.yearmonth', 'core', 0, 0),
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
('map.layer.aerial', 'core', 0, 0),
('map.layer.aerial.labels', 'core', 0, 0),
('map.layer.road', 'core', 0, 0),
('map.style.choropleth', 'core', 0, 0),
('map.style.distribution', 'core', 0, 0),
('module.actor', 'core', 0, 0),
('module.file', 'core', 0, 0),
('module.page', 'core', 0, 0),
('property.address', 'core', 0, 0),
('property.avatar', 'core', 0, 0),
('property.city', 'core', 0, 0),
('property.content', 'core', 0, 0),
('property.country', 'core', 0, 0),
('property.dateofbirth', 'core', 0, 0),
('property.description', 'core', 0, 0),
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
('property.weight', 'core', 0, 0),
('schema.actor', 'core', 0, 0),
('schema.file', 'core', 0, 0),
('schema.page', 'core', 0, 0),
('search.placeholder', 'core', 0, 0),
('site.brand', 'core', 0, 0),
('site.welcome', 'core', 0, 0),
('user.greeting', 'user', 0, 1),
('user.menu.edit', 'user', 0, 0),
('user.menu.home', 'user', 0, 0),
('user.menu.list', 'user', 0, 0),
('user.menu.login', 'user', 0, 0),
('user.menu.logout', 'user', 0, 0),
('user.menu.password', 'user', 0, 0),
('user.menu.register', 'user', 0, 0),
('user.menu.view', 'user', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_domain`
--

CREATE TABLE `ark_translation_domain` (
  `domain` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_domain`
--

INSERT INTO `ark_translation_domain` (`domain`, `keyword`) VALUES
('alias', 'translation.domain.alias'),
('core', 'translation.domain.core'),
('markup', 'translation.domain.markup'),
('user', 'translation.domain.user'),
('vocabulary', 'translation.domain.vocabulary');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_language`
--

CREATE TABLE `ark_translation_language` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `markup` tinyint(1) NOT NULL DEFAULT '0',
  `vocabulary` tinyint(1) NOT NULL DEFAULT '0',
  `text` tinyint(1) NOT NULL DEFAULT '0'
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
  `notes` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_message`
--

INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'association.contact', 'default', 'Contact', ''),
('en', 'core.actor.institution', 'default', 'Institution', ''),
('en', 'core.actor.person', 'default', 'Person', ''),
('en', 'core.nav.dashboard', 'default', 'Dashboard', NULL),
('en', 'core.nav.records', 'default', 'Records', NULL),
('en', 'core.nav.user.login', 'default', 'Login', NULL),
('en', 'file.type.audio', 'default', 'Audio File', ''),
('en', 'file.type.document', 'default', 'Document File', ''),
('en', 'file.type.image', 'default', 'Image File', ''),
('en', 'file.type.other', 'default', 'Other File', ''),
('en', 'file.type.text', 'default', 'Text File', ''),
('en', 'file.type.video', 'default', 'Video File', ''),
('en', 'form.select.optional', 'default', 'optional', ''),
('en', 'form.select.required', 'default', 'required', ''),
('en', 'format.actor', 'default', 'Actor Format', ''),
('en', 'format.address', 'default', 'Address Format', ''),
('en', 'format.blob', 'default', 'Blob Format', ''),
('en', 'format.boolean', 'default', 'Boolean Format', ''),
('en', 'format.colour', 'default', 'Colour Format', ''),
('en', 'format.date', 'default', 'Date Format', ''),
('en', 'format.datetime', 'default', 'DateTime Format', ''),
('en', 'format.decimal', 'default', 'Decimal Format', ''),
('en', 'format.email', 'default', 'Email Format', ''),
('en', 'format.float', 'default', 'Float Format', ''),
('en', 'format.html', 'default', 'HTML Format', ''),
('en', 'format.identifier', 'default', 'Identifier Format', ''),
('en', 'format.integer', 'default', 'Integer Format', ''),
('en', 'format.item', 'default', 'Item Format', ''),
('en', 'format.key', 'default', 'Key Format', ''),
('en', 'format.markdown', 'default', 'Markdown Format', ''),
('en', 'format.module', 'default', 'Module Format', ''),
('en', 'format.money', 'default', 'Money Format', ''),
('en', 'format.ordinaldate', 'default', 'Ordinal Date Format', ''),
('en', 'format.password', 'default', 'Password', ''),
('en', 'format.percent', 'default', 'Percent', ''),
('en', 'format.richtext', 'default', 'Rich Text', ''),
('en', 'format.search', 'default', 'Search Format', ''),
('en', 'format.shorttext', 'default', 'Short Text  Format', ''),
('en', 'format.string', 'default', 'String Format', ''),
('en', 'format.telephone', 'default', 'Telephone Format', ''),
('en', 'format.text', 'default', 'Text Format', ''),
('en', 'format.time', 'default', 'Time Format', ''),
('en', 'format.url', 'default', 'URL Format', ''),
('en', 'format.weekdate', 'default', 'Week Date Format', ''),
('en', 'format.yearmonth', 'default', 'Year Month Format', ''),
('en', 'format.yearweek', 'default', 'Year Week Format', ''),
('en', 'fragment.blob', 'default', 'Blob Fragment', ''),
('en', 'fragment.boolean', 'default', 'Boolean Fragment', ''),
('en', 'fragment.date', 'default', 'Date Fragment', ''),
('en', 'fragment.datetime', 'default', 'DateTime Fragment', ''),
('en', 'fragment.decimal', 'default', 'Decimal Fragment', ''),
('en', 'fragment.float', 'default', 'Float Fragment', ''),
('en', 'fragment.geometry', 'default', 'Geometry Fragment', ''),
('en', 'fragment.integer', 'default', 'Integer Fragment', ''),
('en', 'fragment.item', 'default', 'Item Fragment', ''),
('en', 'fragment.object', 'default', 'Object Fragment', ''),
('en', 'fragment.string', 'default', 'String Fragment', ''),
('en', 'fragment.text', 'default', 'Text Fragment', ''),
('en', 'fragment.time', 'default', 'Time Fragment', ''),
('en', 'map.layer.aerial', 'default', 'Satellite', ''),
('en', 'map.layer.aerial.labels', 'default', 'Satellite with labels', ''),
('en', 'map.layer.road', 'default', 'Road', ''),
('en', 'map.style.choropleth', 'default', 'Choropleth', ''),
('en', 'map.style.distribution', 'default', 'Distribution', ''),
('en', 'module.actor', 'default', 'Actor', ''),
('en', 'module.file', 'default', 'File', ''),
('en', 'module.page', 'default', 'Page', ''),
('en', 'property.address', 'default', 'Address', ''),
('en', 'property.avatar', 'default', 'Avatar', ''),
('en', 'property.city', 'default', 'City', ''),
('en', 'property.content', 'default', 'Content', ''),
('en', 'property.country', 'default', 'Country', ''),
('en', 'property.dateofbirth', 'default', 'Date of Birth', ''),
('en', 'property.description', 'default', 'Description', ''),
('en', 'property.id', 'default', 'ID', ''),
('en', 'property.initials', 'default', 'Initials', ''),
('en', 'property.language', 'default', 'Language', ''),
('en', 'property.length', 'default', 'Length', 'Core Property Length'),
('en', 'property.logo', 'default', 'Logo', ''),
('en', 'property.module', 'default', 'Module', ''),
('en', 'property.name', 'default', 'Name', ''),
('en', 'property.phone', 'default', 'Phone', ''),
('en', 'property.street', 'default', 'Street', ''),
('en', 'property.title', 'default', 'Title', ''),
('en', 'property.weight', 'default', 'Weight', 'Core Property Weight'),
('en', 'schema.actor', 'default', 'Actor', ''),
('en', 'schema.file', 'default', 'File', ''),
('en', 'schema.page', 'default', 'Page', ''),
('en', 'search.placeholder', 'default', 'Free Text Search', ''),
('en', 'site.brand', 'default', 'ARK', ''),
('en', 'site.welcome', 'default', 'Welcome to ARK.', ''),
('en', 'user.greeting', 'default', 'Logged In as %name%', ''),
('en', 'user.menu.edit', 'default', 'Edit your profile', ''),
('en', 'user.menu.home', 'default', 'My Home', ''),
('en', 'user.menu.list', 'default', 'List users', ''),
('en', 'user.menu.login', 'default', 'Sign in', ''),
('en', 'user.menu.logout', 'default', 'Sign out', ''),
('en', 'user.menu.password', 'default', 'Change your password', ''),
('en', 'user.menu.register', 'default', 'Create account', ''),
('en', 'user.menu.view', 'default', 'View your profile', '');

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
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_role`
--

INSERT INTO `ark_translation_role` (`role`, `keyword`, `description`) VALUES
('button', '', 'UI Button'),
('check', '', 'UI Checkbox'),
('column', '', 'UI Column'),
('default', 'translation.role.default', 'Default translation'),
('description', 'translation.role.description', 'A description of the keyword'),
('from', 'translation.role.from', 'The start of a range'),
('group', '', 'UI Group'),
('listbox', '', 'UI List Box'),
('menu', '', 'UI Menu'),
('negative', 'translation.role.negative', 'The negative of the keyword'),
('official', 'translation.role.official', 'The official name or title'),
('opposite', 'translation.role.opposite', 'The opposite of the keyword'),
('positive', 'translation.role.positive', 'The positive of the keyword'),
('progress', '', 'UI Progress Bar'),
('radio', '', 'Ui Radio Button'),
('range', '', 'Name of a range'),
('row', '', 'UI Row'),
('slider', '', 'UI Slider'),
('spinbox', '', 'UI Spin Box'),
('status', '', 'UI Status'),
('tab', '', 'UI Tab'),
('textbox', '', 'UI Text Box'),
('title', 'translation.role.title', 'The title of the keyword'),
('to', 'translation.role.to', 'The end of a range'),
('toolbar', '', 'UI Tool Bar'),
('tooltip', '', 'UI Tool Tip');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_element`
--

CREATE TABLE `ark_view_element` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_element`
--

INSERT INTO `ark_view_element` (`element`, `type`, `class`, `template`, `hidden`, `enabled`, `deprecated`, `keyword`) VALUES
('cor_nav_actions', 'nav', '', '', 0, 1, 0, 'core.nav.actions'),
('core_actor_id', 'field', '', '', 0, 1, 0, NULL),
('core_actor_type', 'field', '', '', 0, 1, 0, NULL),
('core_file_description', 'field', '', '', 0, 1, 0, NULL),
('core_file_id', 'field', '', '', 0, 1, 0, NULL),
('core_file_item', 'grid', '', '', 0, 1, 0, NULL),
('core_file_list', 'table', '', '', 0, 1, 0, NULL),
('core_file_mediatype', 'field', '', '', 0, 1, 0, NULL),
('core_file_status', 'field', '', '', 0, 1, 0, NULL),
('core_file_title', 'field', '', '', 0, 1, 0, NULL),
('core_file_type', 'field', '', '', 0, 1, 0, NULL),
('core_file_versions', 'field', '', '', 0, 1, 0, NULL),
('core_nav_dashboard', 'nav', '', '', 0, 1, 0, 'core.nav.dashboard'),
('core_nav_navbar', 'nav', '', 'blocks/navbar.html.twig', 0, 1, 0, NULL),
('core_nav_records', 'nav', '', '', 0, 1, 0, 'core.nav.records'),
('core_nav_user', 'nav', '', '', 0, 1, 0, 'core.nav.user'),
('core_nav_user_login', 'nav', '', '', 0, 1, 0, 'core.nav.user.login'),
('core_nav_user_register', 'nav', '', '', 0, 1, 0, 'core.nav.user.register'),
('core_page_content', 'field', '', '', 0, 1, 0, 'property.content'),
('core_page_static', 'page', '', '', 0, 1, 0, ''),
('core_page_view', 'grid', '', '', 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_field`
--

CREATE TABLE `ark_view_field` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_field`
--

INSERT INTO `ark_view_field` (`element`, `schma`, `item_type`, `attribute`, `form_type`, `form_options`, `editable`) VALUES
('core_actor_id', 'core.actor', '', 'id', 'ARK\\Form\\Type\\IdType', '', 1),
('core_actor_type', 'core.actor', '', 'type', '', '', 1),
('core_file_description', 'core.file', '', 'description', 'ARK\\Form\\Type\\LocalMultilineTextType', '', 1),
('core_file_id', 'core.file', '', 'id', 'ARK\\Form\\Type\\IdType', '', 1),
('core_file_mediatype', 'core.file', '', 'mediatype', '', '', 1),
('core_file_status', 'core.file', '', 'status', '', '', 1),
('core_file_title', 'core.file', '', 'title', 'ARK\\Form\\Type\\LocalTextType', '', 1),
('core_file_type', 'core.file', '', 'type', '', '', 1),
('core_file_versions', 'core.file', '', 'versions', 'ARK\\Form\\Type\\FileVersionType', '', 1),
('core_page_content', 'core.page', '', 'content', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_grid`
--

CREATE TABLE `ark_view_grid` (
  `layout` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int(11) NOT NULL,
  `col` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `cell` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int(11) DEFAULT NULL,
  `label` tinyint(1) NOT NULL DEFAULT '1',
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_grid`
--

INSERT INTO `ark_view_grid` (`layout`, `item_type`, `row`, `col`, `seq`, `cell`, `map`, `form_options`, `width`, `label`, `editable`, `hidden`, `enabled`, `deprecated`) VALUES
('core_actor_item', '', 0, 0, 0, 'core_actor_id', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_actor_list', '', 0, 0, 0, 'core_actor_id', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 0, 'core_file_id', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 1, 'core_file_type', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 2, 'core_file_mediatype', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 3, 'core_file_title', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 4, 'core_file_status', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_item', '', 0, 0, 5, 'core_file_description', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_list', '', 0, 0, 0, 'core_file_id', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_file_list', '', 0, 0, 2, 'core_file_type', NULL, '', NULL, 1, 1, 0, 1, 0),
('core_page_view', '', 0, 0, 0, 'core_page_content', NULL, '', NULL, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_layout`
--

CREATE TABLE `ark_view_layout` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_root` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_layout`
--

INSERT INTO `ark_view_layout` (`element`, `schma`, `item_type`, `form_root`) VALUES
('core_actor_item', NULL, NULL, 1),
('core_actor_list', NULL, NULL, 0),
('core_file_item', NULL, NULL, 1),
('core_file_list', NULL, NULL, 0),
('core_page_view', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_nav`
--

CREATE TABLE `ark_view_nav` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(2038) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seperator` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_nav`
--

INSERT INTO `ark_view_nav` (`element`, `parent`, `icon`, `route`, `uri`, `seperator`, `enabled`) VALUES
('core_nav_dashboard', 'core_nav_navbar', '', 'dashboard', '', 0, 1),
('core_nav_navbar', NULL, '', '', '', 0, 1),
('core_nav_records', 'core_nav_navbar', '', 'records', '', 0, 1),
('core_nav_user', 'core_nav_navbar', 'images/icons/user.png', '', '', 0, 1),
('core_nav_user_login', 'core_nav_user', '', 'user.login', '', 0, 1),
('core_nav_user_register', 'core_nav_user_register', '', 'user.register', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_page`
--

CREATE TABLE `ark_view_page` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `navbar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_page`
--

INSERT INTO `ark_view_page` (`element`, `content`, `footer`, `navbar`, `sidebar`) VALUES
('core_page_static', 'core_page_view', NULL, 'core_nav_navbar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_tree`
--

CREATE TABLE `ark_view_tree` (
  `id` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `ancestor` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descendent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_type`
--

CREATE TABLE `ark_view_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` tinyint(1) NOT NULL DEFAULT '0',
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_type`
--

INSERT INTO `ark_view_type` (`type`, `class`, `layout`, `form_type`, `template`, `keyword`) VALUES
('field', 'ARK\\View\\Field', 0, 'ARK\\Form\\Type\\PropertyType', 'layouts/field.html.twig', ''),
('grid', 'ARK\\View\\Grid', 1, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 'layouts/grid.html.twig', ''),
('nav', 'ARK\\View\\Nav', 0, '', 'blocks/nav.html.twig', ''),
('page', 'ARK\\View\\Page', 0, '', 'pages/page.html.twig', ''),
('tabbed', 'ARK\\View\\Tabbed', 1, '', 'layouts/tabbed.html.twig', ''),
('table', 'ARK\\View\\Table', 1, '', 'layouts/table.html.twig', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary`
--

CREATE TABLE `ark_vocabulary` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '1',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary`
--

INSERT INTO `ark_vocabulary` (`concept`, `type`, `source`, `closed`, `workflow`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('core.actor.type', 'list', 'ARK Core', 1, 0, 1, 0, 'core.actor.type', 'Actor Type'),
('core.file.status', 'list', 'ARK Core', 1, 0, 1, 0, 'vocabulary.file.status', 'File Status'),
('core.file.type', 'list', 'ARK Core', 1, 0, 1, 0, 'vocabulary.file.type', 'File Type'),
('core.item.status', 'list', 'ARK Core', 1, 0, 1, 0, 'core.item.status', 'Item Status'),
('country', 'list', 'ISO3166', 1, 0, 1, 0, 'vocabulary.country', 'ISO Country Codes'),
('distance', 'list', 'SI', 1, 0, 1, 0, 'vocabulary.distance', 'SI Distance Units'),
('language', 'list', 'ISO639', 1, 0, 1, 0, 'vocabulary.language', 'ISO Language Codes'),
('mass', 'list', 'SI', 1, 0, 1, 0, 'vocabulary.mass', 'SI Mass Units'),
('mediatype', 'list', 'IANA', 1, 0, 1, 0, 'vocabulary.mediatype', 'IANA Mediatypes as defined by RFC'),
('mno12.contamination', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.contamination', ''),
('mno12.context.type', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.context.type', ''),
('mno12.cxtbasicinterp', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.cxtbasicinterp', ''),
('mno12.facing', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.facing', ''),
('mno12.find.type', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.find.type', ''),
('mno12.findtype', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.findtype', ''),
('mno12.hfextrac', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.hfextrac', ''),
('mno12.hfstatus', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.hfstatus', ''),
('mno12.layerformat', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.layerformat', ''),
('mno12.lflocn', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.lflocn', ''),
('mno12.lfstatus', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.lfstatus', ''),
('mno12.objectcompleteness', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.objectcompleteness', ''),
('mno12.objectdisplay', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.objectdisplay', ''),
('mno12.objectinterptype', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.objectinterptype', ''),
('mno12.objectmaterial', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.objectmaterial', ''),
('mno12.objectperiod', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.objectperiod', ''),
('mno12.phase', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.phase', ''),
('mno12.priority', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.priority', ''),
('mno12.process', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.process', ''),
('mno12.projection', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.projection', ''),
('mno12.provperiod', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.provperiod', ''),
('mno12.recflag', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.recflag', ''),
('mno12.recordstatus', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.recordstatus', ''),
('mno12.reuseattr', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.reuseattr', ''),
('mno12.samplecondition', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.samplecondition', ''),
('mno12.samplesize', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.samplesize', ''),
('mno12.samplestatus', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.samplestatus', ''),
('mno12.sampletype', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.sampletype', ''),
('mno12.scale', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.scale', ''),
('mno12.scalebar', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.scalebar', ''),
('mno12.servertype', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.servertype', ''),
('mno12.smpflag', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.smpflag', ''),
('mno12.smpposition', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.smpposition', ''),
('mno12.subsamples', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.subsamples', ''),
('mno12.tmbrxsec', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.tmbrxsec', ''),
('mno12.tmbstatus', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.tmbstatus', ''),
('mno12.toponymattr', 'list', 'ARK 1.2', 1, 0, 1, 0, 'mno12.toponymattr', ''),
('spatial.crs', 'list', 'EPSG', 1, 0, 1, 0, 'vocabulary.spatial.crs', 'Coordinate Reference System'),
('spatial.format', 'list', 'ARK Core', 1, 0, 1, 0, 'vocabulary.spatial.format', 'Spatial data formats');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_collected`
--

CREATE TABLE `ark_vocabulary_collected` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_collection`
--

CREATE TABLE `ark_vocabulary_collection` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('core.actor.type', 'institution', 'classname', 'string', 'ARK\\Entity\\Actor\\Institution'),
('core.actor.type', 'museum', 'classname', 'string', 'ARK\\Entity\\Actor\\Museum'),
('core.actor.type', 'person', 'classname', 'string', 'ARK\\Entity\\Actor\\Person'),
('core.file.type', 'audio', 'classname', 'string', 'ARK\\File\\Audio'),
('core.file.type', 'document', 'classname', 'string', 'ARK\\File\\Document'),
('core.file.type', 'image', 'classname', 'string', 'ARK\\File\\Image'),
('core.file.type', 'other', 'classname', 'string', 'ARK\\File\\File'),
('core.file.type', 'text', 'classname', 'string', 'ARK\\File\\Text'),
('core.file.type', 'video', 'classname', 'string', 'ARK\\File\\Video');

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
  `equivalence` tinyint(1) NOT NULL DEFAULT '0',
  `hierarchy` tinyint(1) NOT NULL DEFAULT '0',
  `associative` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
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
  `alias` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `root` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_term`
--

INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `root`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('core.actor.type', 'institution', '', 0, 1, 0, 'core.actor.type.institution', ''),
('core.actor.type', 'person', '', 0, 1, 0, 'core.actor.type.person', ''),
('core.file.status', 'checkedin', '', 0, 1, 0, 'core.file.status.checkedin', ''),
('core.file.status', 'checkedout', '', 0, 1, 0, 'core.file.status.checkedout', ''),
('core.file.status', 'expired', '', 0, 1, 0, 'core.file.status.expired', ''),
('core.file.status', 'locked', '', 0, 1, 0, 'core.file.status.locked', ''),
('core.file.status', 'new', '', 0, 1, 0, 'core.file.status.new', ''),
('core.file.type', 'audio', '', 0, 1, 0, 'core.file.type.audio', ''),
('core.file.type', 'document', '', 0, 1, 0, 'core.file.type.document', ''),
('core.file.type', 'image', '', 0, 1, 0, 'core.file.type.image', ''),
('core.file.type', 'other', '', 0, 1, 0, 'core.file.type.other', ''),
('core.file.type', 'text', '', 0, 1, 0, 'core.file.type.text', ''),
('core.file.type', 'video', '', 0, 1, 0, 'core.file.type.video', ''),
('core.item.status', 'allocated', '', 0, 1, 0, 'core.item.status.allocated', ''),
('core.item.status', 'deleted', '', 0, 1, 0, 'core.item.status.deleted', ''),
('core.item.status', 'registered', '', 0, 1, 0, 'core.item.status.registered', ''),
('core.item.status', 'void', '', 0, 1, 0, 'core.item.status.void', ''),
('country', 'AD ', 'andorra', 0, 1, 0, 'country.andorra', ''),
('country', 'AE ', 'unitedarabemirates', 0, 1, 0, 'country.unitedarabemirates', ''),
('country', 'AF ', 'afghanistan', 0, 1, 0, 'country.afghanistan', ''),
('country', 'AG ', 'antigua', 0, 1, 0, 'country.antigua', ''),
('country', 'AI ', 'anguilla', 0, 1, 0, 'country.anguilla', ''),
('country', 'AL ', 'albania', 0, 1, 0, 'country.albania', ''),
('country', 'AM ', 'armenia', 0, 1, 0, 'country.armenia', ''),
('country', 'AO ', 'angola', 0, 1, 0, 'country.angola', ''),
('country', 'AQ ', 'antarctica', 0, 1, 0, 'country.antarctica', ''),
('country', 'AR ', 'argentina', 0, 1, 0, 'country.argentina', ''),
('country', 'AS ', 'americansamoa', 0, 1, 0, 'country.americansamoa', ''),
('country', 'AT ', 'austria', 0, 1, 0, 'country.austria', ''),
('country', 'AU ', 'australia', 0, 1, 0, 'country.australia', ''),
('country', 'AW ', 'aruba', 0, 1, 0, 'country.aruba', ''),
('country', 'AX ', 'alandislands', 0, 1, 0, 'country.alandislands', ''),
('country', 'AZ ', 'azerbaijan', 0, 1, 0, 'country.azerbaijan', ''),
('country', 'BA ', 'bosniaherzegovina', 0, 1, 0, 'country.bosniaherzegovina', ''),
('country', 'BB ', 'barbados', 0, 1, 0, 'country.barbados', ''),
('country', 'BD ', 'bangladesh', 0, 1, 0, 'country.bangladesh', ''),
('country', 'BE ', 'belgium', 0, 1, 0, 'country.belgium', ''),
('country', 'BF ', 'burkinafaso', 0, 1, 0, 'country.burkinafaso', ''),
('country', 'BG ', 'bulgaria', 0, 1, 0, 'country.bulgaria', ''),
('country', 'BH ', 'bahrain', 0, 1, 0, 'country.bahrain', ''),
('country', 'BI ', 'burundi', 0, 1, 0, 'country.burundi', ''),
('country', 'BJ ', 'benin', 0, 1, 0, 'country.benin', ''),
('country', 'BL ', 'saintbarthelemy', 0, 1, 0, 'country.saintbarthelemy', ''),
('country', 'BM ', 'bermuda', 0, 1, 0, 'country.bermuda', ''),
('country', 'BN ', 'brunei', 0, 1, 0, 'country.brunei', ''),
('country', 'BO ', 'bolivia', 0, 1, 0, 'country.bolivia', ''),
('country', 'BQ ', 'bonaire', 0, 1, 0, 'country.bonaire', ''),
('country', 'BR ', 'brazil', 0, 1, 0, 'country.brazil', ''),
('country', 'BS ', 'bahamas', 0, 1, 0, 'country.bahamas', ''),
('country', 'BT ', 'bhutan', 0, 1, 0, 'country.bhutan', ''),
('country', 'BW ', 'botswana', 0, 1, 0, 'country.botswana', ''),
('country', 'BY ', 'belarus', 0, 1, 0, 'country.belarus', ''),
('country', 'BZ ', 'belize', 0, 1, 0, 'country.belize', ''),
('country', 'CA ', 'canada', 0, 1, 0, 'country.canada', ''),
('country', 'CC ', 'cocosislands', 0, 1, 0, 'country.cocosislands', ''),
('country', 'CD ', 'democraticrepubliccongo', 0, 1, 0, 'country.democraticrepubliccongo', ''),
('country', 'CF ', 'centralafricanrepublic', 0, 1, 0, 'country.centralafricanrepublic', ''),
('country', 'CG ', 'congo', 0, 1, 0, 'country.congo', ''),
('country', 'CH ', 'switzerland', 0, 1, 0, 'country.switzerland', ''),
('country', 'CI ', 'cotedivoire', 0, 1, 0, 'country.cotedivoire', ''),
('country', 'CK ', 'cookislands', 0, 1, 0, 'country.cookislands', ''),
('country', 'CL ', 'chile', 0, 1, 0, 'country.chile', ''),
('country', 'CM ', 'cameroon', 0, 1, 0, 'country.cameroon', ''),
('country', 'CN ', 'china', 0, 1, 0, 'country.china', ''),
('country', 'CO ', 'colombia', 0, 1, 0, 'country.colombia', ''),
('country', 'CR ', 'costarica', 0, 1, 0, 'country.costarica', ''),
('country', 'CU ', 'cuba', 0, 1, 0, 'country.cuba', ''),
('country', 'CV ', 'caboverde', 0, 1, 0, 'country.caboverde', ''),
('country', 'CW ', 'curacao', 0, 1, 0, 'country.curacao', ''),
('country', 'CX ', 'christmasisland', 0, 1, 0, 'country.christmasisland', ''),
('country', 'CY ', 'cyprus', 0, 1, 0, 'country.cyprus', ''),
('country', 'CZ ', 'czechrepublic', 0, 1, 0, 'country.czechrepublic', ''),
('country', 'DE ', 'germany', 0, 1, 0, 'country.germany', ''),
('country', 'DJ ', 'djibouti', 0, 1, 0, 'country.djibouti', ''),
('country', 'DK ', 'denmark', 0, 1, 0, 'country.denmark', ''),
('country', 'DM ', 'dominica', 0, 1, 0, 'country.dominica', ''),
('country', 'DO ', 'dominicanrepublic', 0, 1, 0, 'country.dominicanrepublic', ''),
('country', 'DZ ', 'algeria', 0, 1, 0, 'country.algeria', ''),
('country', 'EC ', 'ecuador', 0, 1, 0, 'country.ecuador', ''),
('country', 'EE ', 'estonia', 0, 1, 0, 'country.estonia', ''),
('country', 'EG ', 'egypt', 0, 1, 0, 'country.egypt', ''),
('country', 'EH ', 'westernsahara', 0, 1, 0, 'country.westernsahara', ''),
('country', 'ER ', 'eritrea', 0, 1, 0, 'country.eritrea', ''),
('country', 'ES ', 'spain', 0, 1, 0, 'country.spain', ''),
('country', 'ET ', 'ethiopia', 0, 1, 0, 'country.ethiopia', ''),
('country', 'FI ', 'finland', 0, 1, 0, 'country.finland', ''),
('country', 'FJ ', 'fiji', 0, 1, 0, 'country.fiji', ''),
('country', 'FK ', 'falklandislands', 0, 1, 0, 'country.falklandislands', ''),
('country', 'FM ', 'micronesia', 0, 1, 0, 'country.micronesia', ''),
('country', 'FO ', 'faroeislands', 0, 1, 0, 'country.faroeislands', ''),
('country', 'FR ', 'france', 0, 1, 0, 'country.france', ''),
('country', 'GA ', 'gabon', 0, 1, 0, 'country.gabon', ''),
('country', 'GB ', 'unitedkingdom', 0, 1, 0, 'country.unitedkingdom', ''),
('country', 'GD ', 'grenada', 0, 1, 0, 'country.grenada', ''),
('country', 'GE ', 'georgia', 0, 1, 0, 'country.georgia', ''),
('country', 'GF ', 'frenchguiana', 0, 1, 0, 'country.frenchguiana', ''),
('country', 'GG ', 'guernsey', 0, 1, 0, 'country.guernsey', ''),
('country', 'GH ', 'ghana', 0, 1, 0, 'country.ghana', ''),
('country', 'GI ', 'gibraltar', 0, 1, 0, 'country.gibraltar', ''),
('country', 'GL ', 'greenland', 0, 1, 0, 'country.greenland', ''),
('country', 'GM ', 'gambia', 0, 1, 0, 'country.gambia', ''),
('country', 'GN ', 'guinea', 0, 1, 0, 'country.guinea', ''),
('country', 'GP ', 'guadeloupe', 0, 1, 0, 'country.guadeloupe', ''),
('country', 'GQ ', 'equatorialguinea', 0, 1, 0, 'country.equatorialguinea', ''),
('country', 'GR ', 'greece', 0, 1, 0, 'country.greece', ''),
('country', 'GS ', 'southgeorgia', 0, 1, 0, 'country.southgeorgia', ''),
('country', 'GT ', 'guatemala', 0, 1, 0, 'country.guatemala', ''),
('country', 'GU ', 'guam', 0, 1, 0, 'country.guam', ''),
('country', 'GW ', 'guinea-bissau', 0, 1, 0, 'country.guinea-bissau', ''),
('country', 'GY ', 'guyana', 0, 1, 0, 'country.guyana', ''),
('country', 'HK ', 'hongkong', 0, 1, 0, 'country.hongkong', ''),
('country', 'HN ', 'honduras', 0, 1, 0, 'country.honduras', ''),
('country', 'HR ', 'croatia', 0, 1, 0, 'country.croatia', ''),
('country', 'HT ', 'haiti', 0, 1, 0, 'country.haiti', ''),
('country', 'HU ', 'hungary', 0, 1, 0, 'country.hungary', ''),
('country', 'ID ', 'indonesia', 0, 1, 0, 'country.indonesia', ''),
('country', 'IE ', 'ireland', 0, 1, 0, 'country.ireland', ''),
('country', 'IL ', 'israel', 0, 1, 0, 'country.israel', ''),
('country', 'IM ', 'isleofman', 0, 1, 0, 'country.isleofman', ''),
('country', 'IN ', 'india', 0, 1, 0, 'country.india', ''),
('country', 'IQ ', 'iraq', 0, 1, 0, 'country.iraq', ''),
('country', 'IR ', 'iran', 0, 1, 0, 'country.iran', ''),
('country', 'IS ', 'iceland', 0, 1, 0, 'country.iceland', ''),
('country', 'IT ', 'italy', 0, 1, 0, 'country.italy', ''),
('country', 'JE ', 'jersey', 0, 1, 0, 'country.jersey', ''),
('country', 'JM ', 'jamaica', 0, 1, 0, 'country.jamaica', ''),
('country', 'JO ', 'jordan', 0, 1, 0, 'country.jordan', ''),
('country', 'JP ', 'japan', 0, 1, 0, 'country.japan', ''),
('country', 'KE ', 'kenya', 0, 1, 0, 'country.kenya', ''),
('country', 'KG ', 'kyrgyzstan', 0, 1, 0, 'country.kyrgyzstan', ''),
('country', 'KH ', 'cambodia', 0, 1, 0, 'country.cambodia', ''),
('country', 'KI ', 'kiribati', 0, 1, 0, 'country.kiribati', ''),
('country', 'KM ', 'comoros', 0, 1, 0, 'country.comoros', ''),
('country', 'KN ', 'saintkitts', 0, 1, 0, 'country.saintkitts', ''),
('country', 'KP ', 'northkorea', 0, 1, 0, 'country.northkorea', ''),
('country', 'KR ', 'southkorea', 0, 1, 0, 'country.southkorea', ''),
('country', 'KW ', 'kuwait', 0, 1, 0, 'country.kuwait', ''),
('country', 'KY ', 'caymanislands', 0, 1, 0, 'country.caymanislands', ''),
('country', 'KZ ', 'kazakhstan', 0, 1, 0, 'country.kazakhstan', ''),
('country', 'LA ', 'lao', 0, 1, 0, 'country.lao', ''),
('country', 'LB ', 'lebanon', 0, 1, 0, 'country.lebanon', ''),
('country', 'LC ', 'saintlucia', 0, 1, 0, 'country.saintlucia', ''),
('country', 'LI ', 'liechtenstein', 0, 1, 0, 'country.liechtenstein', ''),
('country', 'LK ', 'srilanka', 0, 1, 0, 'country.srilanka', ''),
('country', 'LR ', 'liberia', 0, 1, 0, 'country.liberia', ''),
('country', 'LS ', 'lesotho', 0, 1, 0, 'country.lesotho', ''),
('country', 'LT ', 'lithuania', 0, 1, 0, 'country.lithuania', ''),
('country', 'LU ', 'luxembourg', 0, 1, 0, 'country.luxembourg', ''),
('country', 'LV ', 'latvia', 0, 1, 0, 'country.latvia', ''),
('country', 'LY ', 'libya', 0, 1, 0, 'country.libya', ''),
('country', 'MA ', 'morocco', 0, 1, 0, 'country.morocco', ''),
('country', 'MC ', 'monaco', 0, 1, 0, 'country.monaco', ''),
('country', 'MD ', 'moldova', 0, 1, 0, 'country.moldova', ''),
('country', 'ME ', 'montenegro', 0, 1, 0, 'country.montenegro', ''),
('country', 'MF ', 'saintmartin', 0, 1, 0, 'country.saintmartin', ''),
('country', 'MG ', 'madagascar', 0, 1, 0, 'country.madagascar', ''),
('country', 'MH ', 'marshallislands', 0, 1, 0, 'country.marshallislands', ''),
('country', 'MK ', 'macedonia', 0, 1, 0, 'country.macedonia', ''),
('country', 'ML ', 'mali', 0, 1, 0, 'country.mali', ''),
('country', 'MM ', 'myanmar', 0, 1, 0, 'country.myanmar', ''),
('country', 'MN ', 'mongolia', 0, 1, 0, 'country.mongolia', ''),
('country', 'MO ', 'macao', 0, 1, 0, 'country.macao', ''),
('country', 'MP ', 'northernmarianaislands', 0, 1, 0, 'country.northernmarianaislands', ''),
('country', 'MQ ', 'martinique', 0, 1, 0, 'country.martinique', ''),
('country', 'MR ', 'mauritania', 0, 1, 0, 'country.mauritania', ''),
('country', 'MS ', 'montserrat', 0, 1, 0, 'country.montserrat', ''),
('country', 'MT ', 'malta', 0, 1, 0, 'country.malta', ''),
('country', 'MU ', 'mauritius', 0, 1, 0, 'country.mauritius', ''),
('country', 'MV ', 'maldives', 0, 1, 0, 'country.maldives', ''),
('country', 'MW ', 'malawi', 0, 1, 0, 'country.malawi', ''),
('country', 'MX ', 'mexico', 0, 1, 0, 'country.mexico', ''),
('country', 'MY ', 'malaysia', 0, 1, 0, 'country.malaysia', ''),
('country', 'MZ ', 'mozambique', 0, 1, 0, 'country.mozambique', ''),
('country', 'NA ', 'namibia', 0, 1, 0, 'country.namibia', ''),
('country', 'NC ', 'newcaledonia', 0, 1, 0, 'country.newcaledonia', ''),
('country', 'NE ', 'niger', 0, 1, 0, 'country.niger', ''),
('country', 'NF ', 'norfolkisland', 0, 1, 0, 'country.norfolkisland', ''),
('country', 'NG ', 'nigeria', 0, 1, 0, 'country.nigeria', ''),
('country', 'NI ', 'nicaragua', 0, 1, 0, 'country.nicaragua', ''),
('country', 'NL ', 'netherlands', 0, 1, 0, 'country.netherlands', ''),
('country', 'NO ', 'norway', 0, 1, 0, 'country.norway', ''),
('country', 'NP ', 'nepal', 0, 1, 0, 'country.nepal', ''),
('country', 'NR ', 'nauru', 0, 1, 0, 'country.nauru', ''),
('country', 'NU ', 'niue', 0, 1, 0, 'country.niue', ''),
('country', 'NZ ', 'newzealand', 0, 1, 0, 'country.newzealand', ''),
('country', 'OM ', 'oman', 0, 1, 0, 'country.oman', ''),
('country', 'PA ', 'panama', 0, 1, 0, 'country.panama', ''),
('country', 'PE ', 'peru', 0, 1, 0, 'country.peru', ''),
('country', 'PF ', 'frenchpolynesia', 0, 1, 0, 'country.frenchpolynesia', ''),
('country', 'PG ', 'papuanewguinea', 0, 1, 0, 'country.papuanewguinea', ''),
('country', 'PH ', 'philippines', 0, 1, 0, 'country.philippines', ''),
('country', 'PK ', 'pakistan', 0, 1, 0, 'country.pakistan', ''),
('country', 'PL ', 'poland', 0, 1, 0, 'country.poland', ''),
('country', 'PM ', 'saintpierremiquelon', 0, 1, 0, 'country.saintpierremiquelon', ''),
('country', 'PN ', 'pitcairn', 0, 1, 0, 'country.pitcairn', ''),
('country', 'PR ', 'puertorico', 0, 1, 0, 'country.puertorico', ''),
('country', 'PS ', 'palestine', 0, 1, 0, 'country.palestine', ''),
('country', 'PT ', 'portugal', 0, 1, 0, 'country.portugal', ''),
('country', 'PW ', 'palau', 0, 1, 0, 'country.palau', ''),
('country', 'PY ', 'paraguay', 0, 1, 0, 'country.paraguay', ''),
('country', 'QA ', 'qatar', 0, 1, 0, 'country.qatar', ''),
('country', 'RE ', 'reunion', 0, 1, 0, 'country.reunion', ''),
('country', 'RO ', 'romania', 0, 1, 0, 'country.romania', ''),
('country', 'RS ', 'serbia', 0, 1, 0, 'country.serbia', ''),
('country', 'RU ', 'russia', 0, 1, 0, 'country.russia', ''),
('country', 'RW ', 'rwanda', 0, 1, 0, 'country.rwanda', ''),
('country', 'SA ', 'saudiarabia', 0, 1, 0, 'country.saudiarabia', ''),
('country', 'SB ', 'solomonislands', 0, 1, 0, 'country.solomonislands', ''),
('country', 'SC ', 'seychelles', 0, 1, 0, 'country.seychelles', ''),
('country', 'SD ', 'sudan', 0, 1, 0, 'country.sudan', ''),
('country', 'SE ', 'sweden', 0, 1, 0, 'country.sweden', ''),
('country', 'SG ', 'singapore', 0, 1, 0, 'country.singapore', ''),
('country', 'SH ', 'sainthelena', 0, 1, 0, 'country.sainthelena', ''),
('country', 'SI ', 'slovenia', 0, 1, 0, 'country.slovenia', ''),
('country', 'SJ ', 'svalbard', 0, 1, 0, 'country.svalbard', ''),
('country', 'SK ', 'slovakia', 0, 1, 0, 'country.slovakia', ''),
('country', 'SL ', 'sierraleone', 0, 1, 0, 'country.sierraleone', ''),
('country', 'SM ', 'sanmarino', 0, 1, 0, 'country.sanmarino', ''),
('country', 'SN ', 'senegal', 0, 1, 0, 'country.senegal', ''),
('country', 'SO ', 'somalia', 0, 1, 0, 'country.somalia', ''),
('country', 'SR ', 'suriname', 0, 1, 0, 'country.suriname', ''),
('country', 'SS ', 'southsudan', 0, 1, 0, 'country.southsudan', ''),
('country', 'ST ', 'saotome', 0, 1, 0, 'country.saotome', ''),
('country', 'SV ', 'elsalvador', 0, 1, 0, 'country.elsalvador', ''),
('country', 'SX ', 'sintmaarten', 0, 1, 0, 'country.sintmaarten', ''),
('country', 'SY ', 'syria', 0, 1, 0, 'country.syria', ''),
('country', 'SZ ', 'swaziland', 0, 1, 0, 'country.swaziland', ''),
('country', 'TC ', 'turkscaicos', 0, 1, 0, 'country.turkscaicos', ''),
('country', 'TD ', 'chad', 0, 1, 0, 'country.chad', ''),
('country', 'TG ', 'togo', 0, 1, 0, 'country.togo', ''),
('country', 'TH ', 'thailand', 0, 1, 0, 'country.thailand', ''),
('country', 'TJ ', 'tajikistan', 0, 1, 0, 'country.tajikistan', ''),
('country', 'TK ', 'tokelau', 0, 1, 0, 'country.tokelau', ''),
('country', 'TL ', 'timorleste', 0, 1, 0, 'country.timorleste', ''),
('country', 'TM ', 'turkmenistan', 0, 1, 0, 'country.turkmenistan', ''),
('country', 'TN ', 'tunisia', 0, 1, 0, 'country.tunisia', ''),
('country', 'TO ', 'tonga', 0, 1, 0, 'country.tonga', ''),
('country', 'TR ', 'turkey', 0, 1, 0, 'country.turkey', ''),
('country', 'TT ', 'trinidadtobago', 0, 1, 0, 'country.trinidadtobago', ''),
('country', 'TV ', 'tuvalu', 0, 1, 0, 'country.tuvalu', ''),
('country', 'TW ', 'taiwan', 0, 1, 0, 'country.taiwan', ''),
('country', 'TZ ', 'tanzania', 0, 1, 0, 'country.tanzania', ''),
('country', 'UA ', 'ukraine', 0, 1, 0, 'country.ukraine', ''),
('country', 'UG ', 'uganda', 0, 1, 0, 'country.uganda', ''),
('country', 'US ', 'unitedstatesamerica', 0, 1, 0, 'country.unitedstatesamerica', ''),
('country', 'UY ', 'uruguay', 0, 1, 0, 'country.uruguay', ''),
('country', 'UZ ', 'uzbekistan', 0, 1, 0, 'country.uzbekistan', ''),
('country', 'VA ', 'vatican', 0, 1, 0, 'country.vatican', ''),
('country', 'VC ', 'saintvincent', 0, 1, 0, 'country.saintvincent', ''),
('country', 'VE ', 'venezuela', 0, 1, 0, 'country.venezuela', ''),
('country', 'VG ', 'britishvirginislands', 0, 1, 0, 'country.britishvirginislands', ''),
('country', 'VI ', 'usvirginislands', 0, 1, 0, 'country.usvirginislands', ''),
('country', 'VN ', 'vietnam', 0, 1, 0, 'country.vietnam', ''),
('country', 'VU ', 'vanuatu', 0, 1, 0, 'country.vanuatu', ''),
('country', 'WF ', 'wallisfutuna', 0, 1, 0, 'country.wallisfutuna', ''),
('country', 'WS ', 'samoa', 0, 1, 0, 'country.samoa', ''),
('country', 'YE ', 'yemen', 0, 1, 0, 'country.yemen', ''),
('country', 'YT ', 'mayotte', 0, 1, 0, 'country.mayotte', ''),
('country', 'ZA ', 'southafrica', 0, 1, 0, 'country.southafrica', ''),
('country', 'ZM ', 'zambia', 0, 1, 0, 'country.zambia', ''),
('country', 'ZW ', 'zimbabwe', 0, 1, 0, 'country.zimbabwe', ''),
('distance', 'km', 'kilometre', 0, 1, 0, 'length.kilometre', ''),
('distance', 'm', 'metre', 0, 1, 0, 'length.metre', ''),
('distance', 'mm', 'millimetre', 0, 1, 0, 'length.millimetre', ''),
('distance', 'nm', 'nanometre', 0, 1, 0, 'length.nanometre', ''),
('distance', 'µm', 'nanometre', 0, 1, 0, 'length.micrometre', ''),
('language', 'aa', 'afar', 0, 1, 0, 'language.afar', ''),
('language', 'ab', 'abkhazian', 0, 1, 0, 'language.abkhazian', ''),
('language', 'ace', 'achinese', 0, 1, 0, 'language.achinese', ''),
('language', 'ach', 'acoli', 0, 1, 0, 'language.acoli', ''),
('language', 'ada', 'adangme', 0, 1, 0, 'language.adangme', ''),
('language', 'ady', 'adyghe', 0, 1, 0, 'language.adyghe', ''),
('language', 'ae', 'avestan', 0, 1, 0, 'language.avestan', ''),
('language', 'aeb', 'arabic.tunisian', 0, 1, 0, 'language.arabic.tunisian', ''),
('language', 'af', 'afrikaans', 0, 1, 0, 'language.afrikaans', ''),
('language', 'afh', 'afrihili', 0, 1, 0, 'language.afrihili', ''),
('language', 'agq', 'aghem', 0, 1, 0, 'language.aghem', ''),
('language', 'ain', 'ainu', 0, 1, 0, 'language.ainu', ''),
('language', 'ak', 'akan', 0, 1, 0, 'language.akan', ''),
('language', 'akk', 'akkadian', 0, 1, 0, 'language.akkadian', ''),
('language', 'akz', 'alabama', 0, 1, 0, 'language.alabama', ''),
('language', 'ale', 'aleut', 0, 1, 0, 'language.aleut', ''),
('language', 'aln', 'albanian.gheg', 0, 1, 0, 'language.albanian.gheg', ''),
('language', 'alt', 'altai.southern', 0, 1, 0, 'language.altai.southern', ''),
('language', 'am', 'amharic', 0, 1, 0, 'language.amharic', ''),
('language', 'an', 'aragonese', 0, 1, 0, 'language.aragonese', ''),
('language', 'ang', 'english.old', 0, 1, 0, 'language.english.old', ''),
('language', 'anp', 'angika', 0, 1, 0, 'language.angika', ''),
('language', 'ar', 'arabic', 0, 1, 0, 'language.arabic', ''),
('language', 'ar-001', 'arabic.modern', 0, 1, 0, 'language.arabic.modern', ''),
('language', 'arc', 'aramaic', 0, 1, 0, 'language.aramaic', ''),
('language', 'arn', 'mapuche', 0, 1, 0, 'language.mapuche', ''),
('language', 'aro', 'araona', 0, 1, 0, 'language.araona', ''),
('language', 'arp', 'arapaho', 0, 1, 0, 'language.arapaho', ''),
('language', 'arq', 'arabic.algerian', 0, 1, 0, 'language.arabic.algerian', ''),
('language', 'arw', 'arawak', 0, 1, 0, 'language.arawak', ''),
('language', 'ary', 'arabic.moroccan', 0, 1, 0, 'language.arabic.moroccan', ''),
('language', 'arz', 'arabic.egyptian', 0, 1, 0, 'language.arabic.egyptian', ''),
('language', 'as', 'assamese', 0, 1, 0, 'language.assamese', ''),
('language', 'asa', 'asu', 0, 1, 0, 'language.asu', ''),
('language', 'ast', 'asturian', 0, 1, 0, 'language.asturian', ''),
('language', 'av', 'avaric', 0, 1, 0, 'language.avaric', ''),
('language', 'avk', 'kotava', 0, 1, 0, 'language.kotava', ''),
('language', 'awa', 'awadhi', 0, 1, 0, 'language.awadhi', ''),
('language', 'ay', 'aymara', 0, 1, 0, 'language.aymara', ''),
('language', 'az', 'azerbaijani', 0, 1, 0, 'language.azerbaijani', ''),
('language', 'ba', 'bashkir', 0, 1, 0, 'language.bashkir', ''),
('language', 'bal', 'baluchi', 0, 1, 0, 'language.baluchi', ''),
('language', 'ban', 'balinese', 0, 1, 0, 'language.balinese', ''),
('language', 'bar', 'bavarian', 0, 1, 0, 'language.bavarian', ''),
('language', 'bas', 'basaa', 0, 1, 0, 'language.basaa', ''),
('language', 'bax', 'bamun', 0, 1, 0, 'language.bamun', ''),
('language', 'bbc', 'bataktoba', 0, 1, 0, 'language.bataktoba', ''),
('language', 'bbj', 'ghomala', 0, 1, 0, 'language.ghomala', ''),
('language', 'be', 'belarusian', 0, 1, 0, 'language.belarusian', ''),
('language', 'bej', 'beja', 0, 1, 0, 'language.beja', ''),
('language', 'bem', 'bemba', 0, 1, 0, 'language.bemba', ''),
('language', 'bew', 'betawi', 0, 1, 0, 'language.betawi', ''),
('language', 'bez', 'bena', 0, 1, 0, 'language.bena', ''),
('language', 'bfd', 'bafut', 0, 1, 0, 'language.bafut', ''),
('language', 'bfq', 'badaga', 0, 1, 0, 'language.badaga', ''),
('language', 'bg', 'bulgarian', 0, 1, 0, 'language.bulgarian', ''),
('language', 'bgn', 'balochi.western', 0, 1, 0, 'language.balochi.western', ''),
('language', 'bho', 'bhojpuri', 0, 1, 0, 'language.bhojpuri', ''),
('language', 'bi', 'bislama', 0, 1, 0, 'language.bislama', ''),
('language', 'bik', 'bikol', 0, 1, 0, 'language.bikol', ''),
('language', 'bin', 'bini', 0, 1, 0, 'language.bini', ''),
('language', 'bjn', 'banjar', 0, 1, 0, 'language.banjar', ''),
('language', 'bkm', 'kom', 0, 1, 0, 'language.kom', ''),
('language', 'bla', 'siksika', 0, 1, 0, 'language.siksika', ''),
('language', 'bm', 'bambara', 0, 1, 0, 'language.bambara', ''),
('language', 'bn', 'bengali', 0, 1, 0, 'language.bengali', ''),
('language', 'bo', 'tibetan', 0, 1, 0, 'language.tibetan', ''),
('language', 'bpy', 'bishnupriya', 0, 1, 0, 'language.bishnupriya', ''),
('language', 'bqi', 'bakhtiari', 0, 1, 0, 'language.bakhtiari', ''),
('language', 'br', 'breton', 0, 1, 0, 'language.breton', ''),
('language', 'bra', 'braj', 0, 1, 0, 'language.braj', ''),
('language', 'brh', 'brahui', 0, 1, 0, 'language.brahui', ''),
('language', 'brx', 'bodo', 0, 1, 0, 'language.bodo', ''),
('language', 'bs', 'bosnian', 0, 1, 0, 'language.bosnian', ''),
('language', 'bss', 'akoose', 0, 1, 0, 'language.akoose', ''),
('language', 'bua', 'buriat', 0, 1, 0, 'language.buriat', ''),
('language', 'bug', 'buginese', 0, 1, 0, 'language.buginese', ''),
('language', 'bum', 'bulu', 0, 1, 0, 'language.bulu', ''),
('language', 'byn', 'blin', 0, 1, 0, 'language.blin', ''),
('language', 'byv', 'medumba', 0, 1, 0, 'language.medumba', ''),
('language', 'ca', 'catalan', 0, 1, 0, 'language.catalan', ''),
('language', 'cad', 'caddo', 0, 1, 0, 'language.caddo', ''),
('language', 'car', 'carib', 0, 1, 0, 'language.carib', ''),
('language', 'cay', 'cayuga', 0, 1, 0, 'language.cayuga', ''),
('language', 'cch', 'atsam', 0, 1, 0, 'language.atsam', ''),
('language', 'ce', 'chechen', 0, 1, 0, 'language.chechen', ''),
('language', 'ceb', 'cebuano', 0, 1, 0, 'language.cebuano', ''),
('language', 'cgg', 'chiga', 0, 1, 0, 'language.chiga', ''),
('language', 'ch', 'chamorro', 0, 1, 0, 'language.chamorro', ''),
('language', 'chb', 'chibcha', 0, 1, 0, 'language.chibcha', ''),
('language', 'chg', 'chagatai', 0, 1, 0, 'language.chagatai', ''),
('language', 'chk', 'chuukese', 0, 1, 0, 'language.chuukese', ''),
('language', 'chm', 'mari', 0, 1, 0, 'language.mari', ''),
('language', 'chn', 'jargon.chinook', 0, 1, 0, 'language.jargon.chinook', ''),
('language', 'cho', 'choctaw', 0, 1, 0, 'language.choctaw', ''),
('language', 'chp', 'chipewyan', 0, 1, 0, 'language.chipewyan', ''),
('language', 'chr', 'cherokee', 0, 1, 0, 'language.cherokee', ''),
('language', 'chy', 'cheyenne', 0, 1, 0, 'language.cheyenne', ''),
('language', 'ckb', 'kurdish.central', 0, 1, 0, 'language.kurdish.central', ''),
('language', 'co', 'corsican', 0, 1, 0, 'language.corsican', ''),
('language', 'cop', 'coptic', 0, 1, 0, 'language.coptic', ''),
('language', 'cps', 'capiznon', 0, 1, 0, 'language.capiznon', ''),
('language', 'cr', 'cree', 0, 1, 0, 'language.cree', ''),
('language', 'crh', 'turkish.crimean', 0, 1, 0, 'language.turkish.crimean', ''),
('language', 'cs', 'czech', 0, 1, 0, 'language.czech', ''),
('language', 'csb', 'kashubian', 0, 1, 0, 'language.kashubian', ''),
('language', 'cu', 'slavic.church', 0, 1, 0, 'language.slavic.church', ''),
('language', 'cv', 'chuvash', 0, 1, 0, 'language.chuvash', ''),
('language', 'cy', 'welsh', 0, 1, 0, 'language.welsh', ''),
('language', 'da', 'danish', 0, 1, 0, 'language.danish', ''),
('language', 'dak', 'dakota', 0, 1, 0, 'language.dakota', ''),
('language', 'dar', 'dargwa', 0, 1, 0, 'language.dargwa', ''),
('language', 'dav', 'taita', 0, 1, 0, 'language.taita', ''),
('language', 'de', 'german', 0, 1, 0, 'language.german', ''),
('language', 'de-AT', 'german.austrian', 0, 1, 0, 'language.german.austrian', ''),
('language', 'de-CH', 'german.swisshigh', 0, 1, 0, 'language.german.swisshigh', ''),
('language', 'del', 'delaware', 0, 1, 0, 'language.delaware', ''),
('language', 'den', 'slave', 0, 1, 0, 'language.slave', ''),
('language', 'dgr', 'dogrib', 0, 1, 0, 'language.dogrib', ''),
('language', 'din', 'dinka', 0, 1, 0, 'language.dinka', ''),
('language', 'dje', 'zarma', 0, 1, 0, 'language.zarma', ''),
('language', 'doi', 'dogri', 0, 1, 0, 'language.dogri', ''),
('language', 'dsb', 'sorbian.lower', 0, 1, 0, 'language.sorbian.lower', ''),
('language', 'dtp', 'dusun.central', 0, 1, 0, 'language.dusun.central', ''),
('language', 'dua', 'duala', 0, 1, 0, 'language.duala', ''),
('language', 'dum', 'dutch.middle', 0, 1, 0, 'language.dutch.middle', ''),
('language', 'dv', 'divehi', 0, 1, 0, 'language.divehi', ''),
('language', 'dyo', 'jolafonyi', 0, 1, 0, 'language.jolafonyi', ''),
('language', 'dyu', 'dyula', 0, 1, 0, 'language.dyula', ''),
('language', 'dz', 'dzongkha', 0, 1, 0, 'language.dzongkha', ''),
('language', 'dzg', 'dazaga', 0, 1, 0, 'language.dazaga', ''),
('language', 'ebu', 'embu', 0, 1, 0, 'language.embu', ''),
('language', 'ee', 'ewe', 0, 1, 0, 'language.ewe', ''),
('language', 'efi', 'efik', 0, 1, 0, 'language.efik', ''),
('language', 'egl', 'emilian', 0, 1, 0, 'language.emilian', ''),
('language', 'egy', 'egyptian.ancient', 0, 1, 0, 'language.egyptian.ancient', ''),
('language', 'eka', 'ekajuk', 0, 1, 0, 'language.ekajuk', ''),
('language', 'el', 'greek', 0, 1, 0, 'language.greek', ''),
('language', 'elx', 'elamite', 0, 1, 0, 'language.elamite', ''),
('language', 'en', 'english', 0, 1, 0, 'language.english', ''),
('language', 'en-AU', 'english.australian', 0, 1, 0, 'language.english.australian', ''),
('language', 'en-CA', 'english.canadian', 0, 1, 0, 'language.english.canadian', ''),
('language', 'en-GB', 'english.british', 0, 1, 0, 'language.english.british', ''),
('language', 'en-US', 'english.american', 0, 1, 0, 'language.english.american', ''),
('language', 'enm', 'english.middle', 0, 1, 0, 'language.english.middle', ''),
('language', 'eo', 'esperanto', 0, 1, 0, 'language.esperanto', ''),
('language', 'es', 'spanish', 0, 1, 0, 'language.spanish', ''),
('language', 'es-419', 'spanish.latinamerican', 0, 1, 0, 'Language.spanish.latinamerican', ''),
('language', 'es-ES', 'spanish.european', 0, 1, 0, 'language.spanish.european', ''),
('language', 'es-MX', 'spanish.mexican', 0, 1, 0, 'language.spanish.mexican', ''),
('language', 'esu', 'yupik.central', 0, 1, 0, 'language.yupik.central', ''),
('language', 'et', 'estonian', 0, 1, 0, 'language.estonian', ''),
('language', 'eu', 'basque', 0, 1, 0, 'language.basque', ''),
('language', 'ewo', 'ewondo', 0, 1, 0, 'language.ewondo', ''),
('language', 'ext', 'extremaduran', 0, 1, 0, 'language.extremaduran', ''),
('language', 'fa', 'persian', 0, 1, 0, 'language.persian', ''),
('language', 'fan', 'fang', 0, 1, 0, 'language.fang', ''),
('language', 'fat', 'fanti', 0, 1, 0, 'language.fanti', ''),
('language', 'ff', 'fulah', 0, 1, 0, 'language.fulah', ''),
('language', 'fi', 'finnish', 0, 1, 0, 'language.finnish', ''),
('language', 'fil', 'filipino', 0, 1, 0, 'language.filipino', ''),
('language', 'fit', 'finnish.tornedalen', 0, 1, 0, 'language.finnish.tornedalen', ''),
('language', 'fj', 'fijian', 0, 1, 0, 'language.fijian', ''),
('language', 'fo', 'faroese', 0, 1, 0, 'language.faroese', ''),
('language', 'fon', 'fon', 0, 1, 0, 'language.fon', ''),
('language', 'fr', 'french', 0, 1, 0, 'language.french', ''),
('language', 'fr-CA', 'french.canadian', 0, 1, 0, 'language.french.canadian', ''),
('language', 'fr-CH', 'french.swiss', 0, 1, 0, 'language.french.swiss', ''),
('language', 'frc', 'french.cajun', 0, 1, 0, 'language.french.cajun', ''),
('language', 'frm', 'french.middle', 0, 1, 0, 'language.french.middle', ''),
('language', 'fro', 'french.old', 0, 1, 0, 'language.french.old', ''),
('language', 'frp', 'arpitan', 0, 1, 0, 'language.arpitan', ''),
('language', 'frr', 'frisian.northern', 0, 1, 0, 'language.frisian.northern', ''),
('language', 'frs', 'frisian.eastern', 0, 1, 0, 'language.frisian.eastern', ''),
('language', 'fur', 'friulian', 0, 1, 0, 'language.friulian', ''),
('language', 'fy', 'frisian.western', 0, 1, 0, 'language.frisian.western', ''),
('language', 'ga', 'irish', 0, 1, 0, 'language.irish', ''),
('language', 'gaa', 'ga', 0, 1, 0, 'language.ga', ''),
('language', 'gag', 'gagauz', 0, 1, 0, 'language.gagauz', ''),
('language', 'gan', 'chinese.gan', 0, 1, 0, 'language.chinese.gan', ''),
('language', 'gay', 'gayo', 0, 1, 0, 'language.gayo', ''),
('language', 'gba', 'gbaya', 0, 1, 0, 'language.gbaya', ''),
('language', 'gbz', 'dari.zoroastrian', 0, 1, 0, 'language.dari.zoroastrian', ''),
('language', 'gd', 'gaelic.scottish', 0, 1, 0, 'language.gaelic.scottish', ''),
('language', 'gez', 'geez', 0, 1, 0, 'language.geez', ''),
('language', 'gil', 'gilbertese', 0, 1, 0, 'language.gilbertese', ''),
('language', 'gl', 'galician', 0, 1, 0, 'language.galician', ''),
('language', 'glk', 'gilaki', 0, 1, 0, 'language.gilaki', ''),
('language', 'gmh', 'german.middlehigh', 0, 1, 0, 'language.german.middlehigh', ''),
('language', 'gn', 'guarani', 0, 1, 0, 'language.guarani', ''),
('language', 'goh', 'german.oldhigh', 0, 1, 0, 'language.german.oldhigh', ''),
('language', 'gom', 'konkani.goan', 0, 1, 0, 'language.konkani.goan', ''),
('language', 'gon', 'gondi', 0, 1, 0, 'language.gondi', ''),
('language', 'gor', 'gorontalo', 0, 1, 0, 'language.gorontalo', ''),
('language', 'got', 'gothic', 0, 1, 0, 'language.gothic', ''),
('language', 'grb', 'grebo', 0, 1, 0, 'language.grebo', ''),
('language', 'grc', 'greek.ancient', 0, 1, 0, 'language.greek.ancient', ''),
('language', 'gsw', 'german.swiss', 0, 1, 0, 'language.german.swiss', ''),
('language', 'gu', 'gujarati', 0, 1, 0, 'language.gujarati', ''),
('language', 'guc', 'wayuu', 0, 1, 0, 'language.wayuu', ''),
('language', 'gur', 'frafra', 0, 1, 0, 'language.frafra', ''),
('language', 'guz', 'gusii', 0, 1, 0, 'language.gusii', ''),
('language', 'gv', 'manx', 0, 1, 0, 'language.manx', ''),
('language', 'gwi', 'gwichin', 0, 1, 0, 'language.gwichin', ''),
('language', 'ha', 'hausa', 0, 1, 0, 'language.hausa', ''),
('language', 'hai', 'haida', 0, 1, 0, 'language.haida', ''),
('language', 'hak', 'chinese.hakka', 0, 1, 0, 'language.chinese.hakka', ''),
('language', 'haw', 'hawaiian', 0, 1, 0, 'language.hawaiian', ''),
('language', 'he', 'hebrew', 0, 1, 0, 'language.hebrew', ''),
('language', 'hi', 'hindi', 0, 1, 0, 'language.hindi', ''),
('language', 'hif', 'hindi.fiji', 0, 1, 0, 'language.hindi.fiji', ''),
('language', 'hil', 'hiligaynon', 0, 1, 0, 'language.hiligaynon', ''),
('language', 'hit', 'hittite', 0, 1, 0, 'language.hittite', ''),
('language', 'hmn', 'hmong', 0, 1, 0, 'language.hmong', ''),
('language', 'ho', 'motu.hiri', 0, 1, 0, 'language.motu.hiri', ''),
('language', 'hr', 'croatian', 0, 1, 0, 'language.croatian', ''),
('language', 'hsb', 'sorbian.upper', 0, 1, 0, 'language.sorbian.upper', ''),
('language', 'hsn', 'chinese.xiang', 0, 1, 0, 'language.chinese.xiang', ''),
('language', 'ht', 'creole.haitian', 0, 1, 0, 'language.creole.haitian', ''),
('language', 'hu', 'hungarian', 0, 1, 0, 'language.hungarian', ''),
('language', 'hup', 'hupa', 0, 1, 0, 'language.hupa', ''),
('language', 'hy', 'armenian', 0, 1, 0, 'language.armenian', ''),
('language', 'hz', 'herero', 0, 1, 0, 'language.herero', ''),
('language', 'ia', 'interlingua', 0, 1, 0, 'language.interlingua', ''),
('language', 'iba', 'iban', 0, 1, 0, 'language.iban', ''),
('language', 'ibb', 'ibibio', 0, 1, 0, 'language.ibibio', ''),
('language', 'id', 'indonesian', 0, 1, 0, 'language.indonesian', ''),
('language', 'ie', 'interlingue', 0, 1, 0, 'language.interlingue', ''),
('language', 'ig', 'igbo', 0, 1, 0, 'language.igbo', ''),
('language', 'ii', 'yi.sichuan', 0, 1, 0, 'language.yi.sichuan', ''),
('language', 'ik', 'inupiaq', 0, 1, 0, 'language.inupiaq', ''),
('language', 'ilo', 'iloko', 0, 1, 0, 'language.iloko', ''),
('language', 'inh', 'ingush', 0, 1, 0, 'language.ingush', ''),
('language', 'io', 'ido', 0, 1, 0, 'language.ido', ''),
('language', 'is', 'icelandic', 0, 1, 0, 'language.icelandic', ''),
('language', 'it', 'italian', 0, 1, 0, 'language.italian', ''),
('language', 'iu', 'inuktitut', 0, 1, 0, 'language.inuktitut', ''),
('language', 'izh', 'ingrian', 0, 1, 0, 'language.ingrian', ''),
('language', 'ja', 'japanese', 0, 1, 0, 'language.japanese', ''),
('language', 'jam', 'english.jamaicancreole ', 0, 1, 0, 'language.english.jamaicancreole ', ''),
('language', 'jbo', 'lojban', 0, 1, 0, 'language.lojban', ''),
('language', 'jgo', 'ngomba', 0, 1, 0, 'language.ngomba', ''),
('language', 'jmc', 'machame', 0, 1, 0, 'language.machame', ''),
('language', 'jpr', 'judeopersian', 0, 1, 0, 'language.judeopersian', ''),
('language', 'jrb', 'judeoarabic', 0, 1, 0, 'language.judeoarabic', ''),
('language', 'jut', 'jutish', 0, 1, 0, 'language.jutish', ''),
('language', 'jv', 'javanese', 0, 1, 0, 'language.javanese', ''),
('language', 'ka', 'georgian', 0, 1, 0, 'language.georgian', ''),
('language', 'kaa', 'karakalpak', 0, 1, 0, 'language.karakalpak', ''),
('language', 'kab', 'kabyle', 0, 1, 0, 'language.kabyle', ''),
('language', 'kac', 'kachin', 0, 1, 0, 'language.kachin', ''),
('language', 'kaj', 'jju', 0, 1, 0, 'language.jju', ''),
('language', 'kam', 'kamba', 0, 1, 0, 'language.kamba', ''),
('language', 'kaw', 'kawi', 0, 1, 0, 'language.kawi', ''),
('language', 'kbd', 'kabardian', 0, 1, 0, 'language.kabardian', ''),
('language', 'kbl', 'kanembu', 0, 1, 0, 'language.kanembu', ''),
('language', 'kcg', 'tyap', 0, 1, 0, 'language.tyap', ''),
('language', 'kde', 'makonde', 0, 1, 0, 'language.makonde', ''),
('language', 'kea', 'kabuverdianu', 0, 1, 0, 'language.kabuverdianu', ''),
('language', 'ken', 'kenyang', 0, 1, 0, 'language.kenyang', ''),
('language', 'kfo', 'koro', 0, 1, 0, 'language.koro', ''),
('language', 'kg', 'kongo', 0, 1, 0, 'language.kongo', ''),
('language', 'kgp', 'kaingang', 0, 1, 0, 'language.kaingang', ''),
('language', 'kha', 'khasi', 0, 1, 0, 'language.khasi', ''),
('language', 'kho', 'khotanese', 0, 1, 0, 'language.khotanese', ''),
('language', 'khq', 'chiini.koyra', 0, 1, 0, 'language.chiini.koyra', ''),
('language', 'khw', 'khowar', 0, 1, 0, 'language.khowar', ''),
('language', 'ki', 'kikuyu', 0, 1, 0, 'language.kikuyu', ''),
('language', 'kiu', 'kirmanjki', 0, 1, 0, 'language.kirmanjki', ''),
('language', 'kj', 'kuanyama', 0, 1, 0, 'language.kuanyama', ''),
('language', 'kk', 'kazakh', 0, 1, 0, 'language.kazakh', ''),
('language', 'kkj', 'kako', 0, 1, 0, 'language.kako', ''),
('language', 'kl', 'kalaallisut', 0, 1, 0, 'language.kalaallisut', ''),
('language', 'kln', 'kalenjin', 0, 1, 0, 'language.kalenjin', ''),
('language', 'km', 'khmer', 0, 1, 0, 'language.khmer', ''),
('language', 'kmb', 'kimbundu', 0, 1, 0, 'language.kimbundu', ''),
('language', 'kn', 'kannada', 0, 1, 0, 'language.kannada', ''),
('language', 'ko', 'korean', 0, 1, 0, 'language.korean', ''),
('language', 'koi', 'komi.permyak', 0, 1, 0, 'language.komi.permyak', ''),
('language', 'kok', 'konkani', 0, 1, 0, 'language.konkani', ''),
('language', 'kos', 'kosraean', 0, 1, 0, 'language.kosraean', ''),
('language', 'kpe', 'kpelle', 0, 1, 0, 'language.kpelle', ''),
('language', 'kr', 'kanuri', 0, 1, 0, 'language.kanuri', ''),
('language', 'krc', 'karachaybalkar', 0, 1, 0, 'language.karachaybalkar', ''),
('language', 'kri', 'krio', 0, 1, 0, 'language.krio', ''),
('language', 'krj', 'kinaraya', 0, 1, 0, 'language.kinaraya', ''),
('language', 'krl', 'karelian', 0, 1, 0, 'language.karelian', ''),
('language', 'kru', 'kurukh', 0, 1, 0, 'language.kurukh', ''),
('language', 'ks', 'kashmiri', 0, 1, 0, 'language.kashmiri', ''),
('language', 'ksb', 'shambala', 0, 1, 0, 'language.shambala', ''),
('language', 'ksf', 'bafia', 0, 1, 0, 'language.bafia', ''),
('language', 'ksh', 'colognian', 0, 1, 0, 'language.colognian', ''),
('language', 'ku', 'kurdish', 0, 1, 0, 'language.kurdish', ''),
('language', 'kum', 'kumyk', 0, 1, 0, 'language.kumyk', ''),
('language', 'kut', 'kutenai', 0, 1, 0, 'language.kutenai', ''),
('language', 'kv', 'komi', 0, 1, 0, 'language.komi', ''),
('language', 'kw', 'cornish', 0, 1, 0, 'language.cornish', ''),
('language', 'ky', 'kyrgyz', 0, 1, 0, 'language.kyrgyz', ''),
('language', 'la', 'latin', 0, 1, 0, 'language.latin', ''),
('language', 'lad', 'ladino', 0, 1, 0, 'language.ladino', ''),
('language', 'lag', 'langi', 0, 1, 0, 'language.langi', ''),
('language', 'lah', 'lahnda', 0, 1, 0, 'language.lahnda', ''),
('language', 'lam', 'lamba', 0, 1, 0, 'language.lamba', ''),
('language', 'lb', 'luxembourgish', 0, 1, 0, 'language.luxembourgish', ''),
('language', 'lez', 'lezghian', 0, 1, 0, 'language.lezghian', ''),
('language', 'lfn', 'linguafranca.nova', 0, 1, 0, 'language.linguafranca.nova', ''),
('language', 'lg', 'ganda', 0, 1, 0, 'language.ganda', ''),
('language', 'li', 'limburgish', 0, 1, 0, 'language.limburgish', ''),
('language', 'lij', 'ligurian', 0, 1, 0, 'language.ligurian', ''),
('language', 'liv', 'livonian', 0, 1, 0, 'language.livonian', ''),
('language', 'lkt', 'lakota', 0, 1, 0, 'language.lakota', ''),
('language', 'lmo', 'lombard', 0, 1, 0, 'language.lombard', ''),
('language', 'ln', 'lingala', 0, 1, 0, 'language.lingala', ''),
('language', 'lo', 'lao', 0, 1, 0, 'language.lao', ''),
('language', 'lol', 'mongo', 0, 1, 0, 'language.mongo', ''),
('language', 'loz', 'lozi', 0, 1, 0, 'language.lozi', ''),
('language', 'lrc', 'luri.northern', 0, 1, 0, 'language.luri.northern', ''),
('language', 'lt', 'lithuanian', 0, 1, 0, 'language.lithuanian', ''),
('language', 'ltg', 'latgalian', 0, 1, 0, 'language.latgalian', ''),
('language', 'lu', 'luba.katanga', 0, 1, 0, 'language.luba.katanga', ''),
('language', 'lua', 'luba.lulua', 0, 1, 0, 'language.luba.lulua', ''),
('language', 'lui', 'luiseno', 0, 1, 0, 'language.luiseno', ''),
('language', 'lun', 'lunda', 0, 1, 0, 'language.lunda', ''),
('language', 'luo', 'luo', 0, 1, 0, 'language.luo', ''),
('language', 'lus', 'mizo', 0, 1, 0, 'language.mizo', ''),
('language', 'luy', 'luyia', 0, 1, 0, 'language.luyia', ''),
('language', 'lv', 'latvian', 0, 1, 0, 'language.latvian', ''),
('language', 'lzh', 'chinese.literary', 0, 1, 0, 'language.chinese.literary', ''),
('language', 'lzz', 'laz', 0, 1, 0, 'language.laz', ''),
('language', 'mad', 'madurese', 0, 1, 0, 'language.madurese', ''),
('language', 'maf', 'mafa', 0, 1, 0, 'language.mafa', ''),
('language', 'mag', 'magahi', 0, 1, 0, 'language.magahi', ''),
('language', 'mai', 'maithili', 0, 1, 0, 'language.maithili', ''),
('language', 'mak', 'makasar', 0, 1, 0, 'language.makasar', ''),
('language', 'man', 'mandingo', 0, 1, 0, 'language.mandingo', ''),
('language', 'mas', 'masai', 0, 1, 0, 'language.masai', ''),
('language', 'mde', 'maba', 0, 1, 0, 'language.maba', ''),
('language', 'mdf', 'moksha', 0, 1, 0, 'language.moksha', ''),
('language', 'mdr', 'mandar', 0, 1, 0, 'language.mandar', ''),
('language', 'men', 'mende', 0, 1, 0, 'language.mende', ''),
('language', 'mer', 'meru', 0, 1, 0, 'language.meru', ''),
('language', 'mfe', 'morisyen', 0, 1, 0, 'language.morisyen', ''),
('language', 'mg', 'malagasy', 0, 1, 0, 'language.malagasy', ''),
('language', 'mga', 'irish.middle', 0, 1, 0, 'language.irish.middle', ''),
('language', 'mgh', 'makhuwameetto', 0, 1, 0, 'language.makhuwameetto', ''),
('language', 'mgo', 'meta', 0, 1, 0, 'language.meta', ''),
('language', 'mh', 'marshallese', 0, 1, 0, 'language.marshallese', ''),
('language', 'mi', 'maori', 0, 1, 0, 'language.maori', ''),
('language', 'mic', 'micmac', 0, 1, 0, 'language.micmac', ''),
('language', 'min', 'minangkabau', 0, 1, 0, 'language.minangkabau', ''),
('language', 'mk', 'macedonian', 0, 1, 0, 'language.macedonian', ''),
('language', 'ml', 'malayalam', 0, 1, 0, 'language.malayalam', ''),
('language', 'mn', 'mongolian', 0, 1, 0, 'language.mongolian', ''),
('language', 'mnc', 'manchu', 0, 1, 0, 'language.manchu', ''),
('language', 'mni', 'manipuri', 0, 1, 0, 'language.manipuri', ''),
('language', 'moh', 'mohawk', 0, 1, 0, 'language.mohawk', ''),
('language', 'mos', 'mossi', 0, 1, 0, 'language.mossi', ''),
('language', 'mr', 'marathi', 0, 1, 0, 'language.marathi', ''),
('language', 'mrj', 'mari.western', 0, 1, 0, 'language.mari.western', ''),
('language', 'ms', 'malay', 0, 1, 0, 'language.malay', ''),
('language', 'mt', 'maltese', 0, 1, 0, 'language.maltese', ''),
('language', 'mua', 'mundang', 0, 1, 0, 'language.mundang', ''),
('language', 'mul', 'multiple', 0, 1, 0, 'language.multiple', ''),
('language', 'mus', 'creek', 0, 1, 0, 'language.creek', ''),
('language', 'mwl', 'mirandese', 0, 1, 0, 'language.mirandese', ''),
('language', 'mwr', 'marwari', 0, 1, 0, 'language.marwari', ''),
('language', 'mwv', 'mentawai', 0, 1, 0, 'language.mentawai', ''),
('language', 'my', 'burmese', 0, 1, 0, 'language.burmese', ''),
('language', 'mye', 'myene', 0, 1, 0, 'language.myene', ''),
('language', 'myv', 'erzya', 0, 1, 0, 'language.erzya', ''),
('language', 'mzn', 'mazanderani', 0, 1, 0, 'language.mazanderani', ''),
('language', 'na', 'nauru', 0, 1, 0, 'language.nauru', ''),
('language', 'nan', 'chinese.minnan', 0, 1, 0, 'language.chinese.minnan', ''),
('language', 'nap', 'neapolitan', 0, 1, 0, 'language.neapolitan', ''),
('language', 'naq', 'nama', 0, 1, 0, 'language.nama', ''),
('language', 'nb', 'norwegian.bokmål', 0, 1, 0, 'language.norwegian.bokmål', ''),
('language', 'nd', 'ndebele.north', 0, 1, 0, 'language.ndebele.north', ''),
('language', 'nds', 'german.low', 0, 1, 0, 'language.german.low', ''),
('language', 'nds-NL', 'saxon.low', 0, 1, 0, 'language.saxon.low', ''),
('language', 'ne', 'nepali', 0, 1, 0, 'language.nepali', ''),
('language', 'new', 'newari', 0, 1, 0, 'language.newari', ''),
('language', 'ng', 'ndonga', 0, 1, 0, 'language.ndonga', ''),
('language', 'nia', 'nias', 0, 1, 0, 'language.nias', ''),
('language', 'niu', 'niuean', 0, 1, 0, 'language.niuean', ''),
('language', 'njo', 'aonaga', 0, 1, 0, 'language.aonaga', ''),
('language', 'nl', 'dutch', 0, 1, 0, 'language.dutch', ''),
('language', 'nl-BE', 'flemish', 0, 1, 0, 'language.flemish', ''),
('language', 'nmg', 'kwasio', 0, 1, 0, 'language.kwasio', ''),
('language', 'nn', 'norwegian.nynorsk', 0, 1, 0, 'language.norwegian.nynorsk', ''),
('language', 'nnh', 'ngiemboon', 0, 1, 0, 'language.ngiemboon', ''),
('language', 'no', 'norwegian', 0, 1, 0, 'language.norwegian', ''),
('language', 'nog', 'nogai', 0, 1, 0, 'language.nogai', ''),
('language', 'non', 'norse.old', 0, 1, 0, 'language.norse.old', ''),
('language', 'nov', 'novial', 0, 1, 0, 'language.novial', ''),
('language', 'nqo', 'nko', 0, 1, 0, 'language.nko', ''),
('language', 'nr', 'ndebele.south', 0, 1, 0, 'language.ndebele.south', ''),
('language', 'nso', 'sotho.northern', 0, 1, 0, 'language.sotho.northern', ''),
('language', 'nus', 'nuer', 0, 1, 0, 'language.nuer', ''),
('language', 'nv', 'navajo', 0, 1, 0, 'language.navajo', ''),
('language', 'nwc', 'newari.classical', 0, 1, 0, 'language.newari.classical', ''),
('language', 'ny', 'nyanja', 0, 1, 0, 'language.nyanja', ''),
('language', 'nym', 'nyamwezi', 0, 1, 0, 'language.nyamwezi', ''),
('language', 'nyn', 'nyankole', 0, 1, 0, 'language.nyankole', ''),
('language', 'nyo', 'nyoro', 0, 1, 0, 'language.nyoro', ''),
('language', 'nzi', 'nzima', 0, 1, 0, 'language.nzima', ''),
('language', 'oc', 'occitan', 0, 1, 0, 'language.occitan', ''),
('language', 'oj', 'ojibwa', 0, 1, 0, 'language.ojibwa', ''),
('language', 'om', 'oromo', 0, 1, 0, 'language.oromo', ''),
('language', 'or', 'oriya', 0, 1, 0, 'language.oriya', ''),
('language', 'os', 'ossetic', 0, 1, 0, 'language.ossetic', ''),
('language', 'osa', 'osage', 0, 1, 0, 'language.osage', ''),
('language', 'ota', 'turkish.ottoman', 0, 1, 0, 'language.turkish.ottoman', ''),
('language', 'pa', 'punjabi', 0, 1, 0, 'language.punjabi', ''),
('language', 'pag', 'pangasinan', 0, 1, 0, 'language.pangasinan', ''),
('language', 'pal', 'pahlavi', 0, 1, 0, 'language.pahlavi', ''),
('language', 'pam', 'pampanga', 0, 1, 0, 'language.pampanga', ''),
('language', 'pap', 'papiamento', 0, 1, 0, 'language.papiamento', ''),
('language', 'pau', 'palauan', 0, 1, 0, 'language.palauan', ''),
('language', 'pcd', 'picard', 0, 1, 0, 'language.picard', ''),
('language', 'pdc', 'german.pennsylvania', 0, 1, 0, 'language.german.pennsylvania', ''),
('language', 'pdt', 'plautdietsch', 0, 1, 0, 'language.plautdietsch', ''),
('language', 'peo', 'persian.old', 0, 1, 0, 'language.persian.old', ''),
('language', 'pfl', 'german.palatine', 0, 1, 0, 'language.german.palatine', ''),
('language', 'phn', 'phoenician', 0, 1, 0, 'language.phoenician', ''),
('language', 'pi', 'pali', 0, 1, 0, 'language.pali', ''),
('language', 'pl', 'polish', 0, 1, 0, 'language.polish', ''),
('language', 'pms', 'piedmontese', 0, 1, 0, 'language.piedmontese', ''),
('language', 'pnt', 'pontic', 0, 1, 0, 'language.pontic', ''),
('language', 'pon', 'pohnpeian', 0, 1, 0, 'language.pohnpeian', ''),
('language', 'prg', 'prussian', 0, 1, 0, 'language.prussian', ''),
('language', 'pro', 'provençal.old', 0, 1, 0, 'language.provençal.old', ''),
('language', 'ps', 'pashto', 0, 1, 0, 'language.pashto', ''),
('language', 'pt', 'portuguese', 0, 1, 0, 'language.portuguese', ''),
('language', 'pt-BR', 'portuguese.brazilian', 0, 1, 0, 'language.portuguese.brazilian', ''),
('language', 'pt-PT', 'portuguese.european', 0, 1, 0, 'language.portuguese.european', ''),
('language', 'qu', 'quechua', 0, 1, 0, 'language.quechua', ''),
('language', 'quc', 'kiche', 0, 1, 0, 'language.kiche', ''),
('language', 'qug', 'quichua.chimborazohighland', 0, 1, 0, 'language.quichua.chimborazohighland', ''),
('language', 'raj', 'rajasthani', 0, 1, 0, 'language.rajasthani', ''),
('language', 'rap', 'rapanui', 0, 1, 0, 'language.rapanui', ''),
('language', 'rar', 'rarotongan', 0, 1, 0, 'language.rarotongan', ''),
('language', 'rgn', 'romagnol', 0, 1, 0, 'language.romagnol', ''),
('language', 'rif', 'riffian', 0, 1, 0, 'language.riffian', ''),
('language', 'rm', 'romansh', 0, 1, 0, 'language.romansh', ''),
('language', 'rn', 'rundi', 0, 1, 0, 'language.rundi', ''),
('language', 'ro', 'romanian', 0, 1, 0, 'language.romanian', ''),
('language', 'ro-MD', 'moldavian', 0, 1, 0, 'language.moldavian', ''),
('language', 'rof', 'rombo', 0, 1, 0, 'language.rombo', ''),
('language', 'rom', 'romany', 0, 1, 0, 'language.romany', ''),
('language', 'root', 'root', 0, 1, 0, 'language.root', ''),
('language', 'rtm', 'rotuman', 0, 1, 0, 'language.rotuman', ''),
('language', 'ru', 'russian', 0, 1, 0, 'language.russian', ''),
('language', 'rue', 'rusyn', 0, 1, 0, 'language.rusyn', ''),
('language', 'rug', 'roviana', 0, 1, 0, 'language.roviana', ''),
('language', 'rup', 'aromanian', 0, 1, 0, 'language.aromanian', ''),
('language', 'rw', 'kinyarwanda', 0, 1, 0, 'language.kinyarwanda', ''),
('language', 'rwk', 'rwa', 0, 1, 0, 'language.rwa', ''),
('language', 'sa', 'sanskrit', 0, 1, 0, 'language.sanskrit', ''),
('language', 'sad', 'sandawe', 0, 1, 0, 'language.sandawe', ''),
('language', 'sah', 'sakha', 0, 1, 0, 'language.sakha', ''),
('language', 'sam', 'aramaic.samaritan', 0, 1, 0, 'language.aramaic.samaritan', ''),
('language', 'saq', 'samburu', 0, 1, 0, 'language.samburu', ''),
('language', 'sas', 'sasak', 0, 1, 0, 'language.sasak', ''),
('language', 'sat', 'santali', 0, 1, 0, 'language.santali', ''),
('language', 'saz', 'saurashtra', 0, 1, 0, 'language.saurashtra', ''),
('language', 'sba', 'ngambay', 0, 1, 0, 'language.ngambay', ''),
('language', 'sbp', 'sangu', 0, 1, 0, 'language.sangu', ''),
('language', 'sc', 'sardinian', 0, 1, 0, 'language.sardinian', ''),
('language', 'scn', 'sicilian', 0, 1, 0, 'language.sicilian', ''),
('language', 'sco', 'scots', 0, 1, 0, 'language.scots', ''),
('language', 'sd', 'sindhi', 0, 1, 0, 'language.sindhi', ''),
('language', 'sdc', 'sardinian.sassarese', 0, 1, 0, 'language.sardinian.sassarese', ''),
('language', 'sdh', 'southern kurdish', 0, 1, 0, 'language.southern kurdish', ''),
('language', 'se', 'northern sami', 0, 1, 0, 'language.northern sami', ''),
('language', 'see', 'seneca', 0, 1, 0, 'language.seneca', ''),
('language', 'seh', 'sena', 0, 1, 0, 'language.sena', ''),
('language', 'sei', 'seri', 0, 1, 0, 'language.seri', ''),
('language', 'sel', 'selkup', 0, 1, 0, 'language.selkup', ''),
('language', 'ses', 'senni.koyraboro', 0, 1, 0, 'language.senni.koyraboro', ''),
('language', 'sg', 'sango', 0, 1, 0, 'language.sango', ''),
('language', 'sga', 'irish.old', 0, 1, 0, 'language.irish.old', ''),
('language', 'sgs', 'samogitian', 0, 1, 0, 'language.samogitian', ''),
('language', 'sh', 'serbocroatian', 0, 1, 0, 'language.serbocroatian', ''),
('language', 'shi', 'tachelhit', 0, 1, 0, 'language.tachelhit', ''),
('language', 'shn', 'shan', 0, 1, 0, 'language.shan', ''),
('language', 'shu', 'arabic.chadian', 0, 1, 0, 'language.arabic.chadian', ''),
('language', 'si', 'sinhala', 0, 1, 0, 'language.sinhala', ''),
('language', 'sid', 'sidamo', 0, 1, 0, 'language.sidamo', ''),
('language', 'sk', 'slovak', 0, 1, 0, 'language.slovak', ''),
('language', 'sl', 'slovenian', 0, 1, 0, 'language.slovenian', ''),
('language', 'sli', 'silesian.lower', 0, 1, 0, 'language.silesian.lower', ''),
('language', 'sly', 'selayar', 0, 1, 0, 'language.selayar', ''),
('language', 'sm', 'samoan', 0, 1, 0, 'language.samoan', ''),
('language', 'sma', 'sami.southern', 0, 1, 0, 'language.sami.southern', ''),
('language', 'smj', 'sami.lule', 0, 1, 0, 'language.sami.lule', ''),
('language', 'smn', 'sami.inari', 0, 1, 0, 'language.sami.inari', ''),
('language', 'sms', 'sami.skolt', 0, 1, 0, 'language.sami.skolt', ''),
('language', 'sn', 'shona', 0, 1, 0, 'language.shona', ''),
('language', 'snk', 'soninke', 0, 1, 0, 'language.soninke', ''),
('language', 'so', 'somali', 0, 1, 0, 'language.somali', ''),
('language', 'sog', 'sogdien', 0, 1, 0, 'language.sogdien', ''),
('language', 'sq', 'albanian', 0, 1, 0, 'language.albanian', ''),
('language', 'sr', 'serbian', 0, 1, 0, 'language.serbian', ''),
('language', 'srn', 'tongo.sranan', 0, 1, 0, 'language.tongo.sranan', '');
INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `root`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('language', 'srr', 'serer', 0, 1, 0, 'language.serer', ''),
('language', 'ss', 'swati', 0, 1, 0, 'language.swati', ''),
('language', 'ssy', 'saho', 0, 1, 0, 'language.saho', ''),
('language', 'st', 'sotho.southern', 0, 1, 0, 'language.sotho.southern', ''),
('language', 'stq', 'frisian.saterland', 0, 1, 0, 'language.frisian.saterland', ''),
('language', 'su', 'sundanese', 0, 1, 0, 'language.sundanese', ''),
('language', 'suk', 'sukuma', 0, 1, 0, 'language.sukuma', ''),
('language', 'sus', 'susu', 0, 1, 0, 'language.susu', ''),
('language', 'sux', 'sumerian', 0, 1, 0, 'language.sumerian', ''),
('language', 'sv', 'swedish', 0, 1, 0, 'language.swedish', ''),
('language', 'sw', 'swahili', 0, 1, 0, 'language.swahili', ''),
('language', 'sw-CD', 'swahili.congo', 0, 1, 0, 'language.swahili.congo', ''),
('language', 'swb', 'comorian', 0, 1, 0, 'language.comorian', ''),
('language', 'syc', 'syriac.classical', 0, 1, 0, 'language.syriac.classical', ''),
('language', 'syr', 'syriac', 0, 1, 0, 'language.syriac', ''),
('language', 'szl', 'silesian', 0, 1, 0, 'language.silesian', ''),
('language', 'ta', 'tamil', 0, 1, 0, 'language.tamil', ''),
('language', 'tcy', 'tulu', 0, 1, 0, 'language.tulu', ''),
('language', 'te', 'telugu', 0, 1, 0, 'language.telugu', ''),
('language', 'tem', 'timne', 0, 1, 0, 'language.timne', ''),
('language', 'teo', 'teso', 0, 1, 0, 'language.teso', ''),
('language', 'ter', 'tereno', 0, 1, 0, 'language.tereno', ''),
('language', 'tet', 'tetum', 0, 1, 0, 'language.tetum', ''),
('language', 'tg', 'tajik', 0, 1, 0, 'language.tajik', ''),
('language', 'th', 'thai', 0, 1, 0, 'language.thai', ''),
('language', 'ti', 'tigrinya', 0, 1, 0, 'language.tigrinya', ''),
('language', 'tig', 'tigre', 0, 1, 0, 'language.tigre', ''),
('language', 'tiv', 'tiv', 0, 1, 0, 'language.tiv', ''),
('language', 'tk', 'turkmen', 0, 1, 0, 'language.turkmen', ''),
('language', 'tkl', 'tokelau', 0, 1, 0, 'language.tokelau', ''),
('language', 'tkr', 'tsakhur', 0, 1, 0, 'language.tsakhur', ''),
('language', 'tl', 'tagalog', 0, 1, 0, 'language.tagalog', ''),
('language', 'tlh', 'klingon', 0, 1, 0, 'language.klingon', ''),
('language', 'tli', 'tlingit', 0, 1, 0, 'language.tlingit', ''),
('language', 'tly', 'talysh', 0, 1, 0, 'language.talysh', ''),
('language', 'tmh', 'tamashek', 0, 1, 0, 'language.tamashek', ''),
('language', 'tn', 'tswana', 0, 1, 0, 'language.tswana', ''),
('language', 'to', 'tongan', 0, 1, 0, 'language.tongan', ''),
('language', 'tog', 'tonga.nyasa', 0, 1, 0, 'language.tonga.nyasa', ''),
('language', 'tpi', 'pisin.tok', 0, 1, 0, 'language.pisin.tok', ''),
('language', 'tr', 'turkish', 0, 1, 0, 'language.turkish', ''),
('language', 'tru', 'turoyo', 0, 1, 0, 'language.turoyo', ''),
('language', 'trv', 'taroko', 0, 1, 0, 'language.taroko', ''),
('language', 'ts', 'tsonga', 0, 1, 0, 'language.tsonga', ''),
('language', 'tsd', 'tsakonian', 0, 1, 0, 'language.tsakonian', ''),
('language', 'tsi', 'tsimshian', 0, 1, 0, 'language.tsimshian', ''),
('language', 'tt', 'tatar', 0, 1, 0, 'language.tatar', ''),
('language', 'ttt', 'tat.muslim', 0, 1, 0, 'language.tat.muslim', ''),
('language', 'tum', 'tumbuka', 0, 1, 0, 'language.tumbuka', ''),
('language', 'tvl', 'tuvalu', 0, 1, 0, 'language.tuvalu', ''),
('language', 'tw', 'twi', 0, 1, 0, 'language.twi', ''),
('language', 'twq', 'tasawaq', 0, 1, 0, 'language.tasawaq', ''),
('language', 'ty', 'tahitian', 0, 1, 0, 'language.tahitian', ''),
('language', 'tyv', 'tuvinian', 0, 1, 0, 'language.tuvinian', ''),
('language', 'tzm', 'tamazight.centralatlas', 0, 1, 0, 'language.tamazight.centralatlas', ''),
('language', 'udm', 'udmurt', 0, 1, 0, 'language.udmurt', ''),
('language', 'ug', 'uyghur', 0, 1, 0, 'language.uyghur', ''),
('language', 'uga', 'ugaritic', 0, 1, 0, 'language.ugaritic', ''),
('language', 'uk', 'ukrainian', 0, 1, 0, 'language.ukrainian', ''),
('language', 'umb', 'umbundu', 0, 1, 0, 'language.umbundu', ''),
('language', 'und', 'unknown', 0, 1, 0, 'language.unknown', ''),
('language', 'ur', 'urdu', 0, 1, 0, 'language.urdu', ''),
('language', 'uz', 'uzbek', 0, 1, 0, 'language.uzbek', ''),
('language', 'vai', 'vai', 0, 1, 0, 'language.vai', ''),
('language', 've', 'venda', 0, 1, 0, 'language.venda', ''),
('language', 'vec', 'venetian', 0, 1, 0, 'language.venetian', ''),
('language', 'vep', 'veps', 0, 1, 0, 'language.veps', ''),
('language', 'vi', 'vietnamese', 0, 1, 0, 'language.vietnamese', ''),
('language', 'vls', 'flemish.west', 0, 1, 0, 'language.flemish.west', ''),
('language', 'vmf', 'franconian.main', 0, 1, 0, 'language.franconian.main', ''),
('language', 'vo', 'volapük', 0, 1, 0, 'language.volapük', ''),
('language', 'vot', 'votic', 0, 1, 0, 'language.votic', ''),
('language', 'vro', 'võro', 0, 1, 0, 'language.võro', ''),
('language', 'vun', 'vunjo', 0, 1, 0, 'language.vunjo', ''),
('language', 'wa', 'walloon', 0, 1, 0, 'language.walloon', ''),
('language', 'wae', 'walser', 0, 1, 0, 'language.walser', ''),
('language', 'wal', 'wolaytta', 0, 1, 0, 'language.wolaytta', ''),
('language', 'war', 'waray', 0, 1, 0, 'language.waray', ''),
('language', 'was', 'washo', 0, 1, 0, 'language.washo', ''),
('language', 'wbp', 'warlpiri', 0, 1, 0, 'language.warlpiri', ''),
('language', 'wo', 'wolof', 0, 1, 0, 'language.wolof', ''),
('language', 'wuu', 'chinese.wu', 0, 1, 0, 'language.chinese.wu', ''),
('language', 'xal', 'kalmyk', 0, 1, 0, 'language.kalmyk', ''),
('language', 'xh', 'xhosa', 0, 1, 0, 'language.xhosa', ''),
('language', 'xmf', 'mingrelian', 0, 1, 0, 'language.mingrelian', ''),
('language', 'xog', 'soga', 0, 1, 0, 'language.soga', ''),
('language', 'yao', 'yao', 0, 1, 0, 'language.yao', ''),
('language', 'yap', 'yapese', 0, 1, 0, 'language.yapese', ''),
('language', 'yav', 'yangben', 0, 1, 0, 'language.yangben', ''),
('language', 'ybb', 'yemba', 0, 1, 0, 'language.yemba', ''),
('language', 'yi', 'yiddish', 0, 1, 0, 'language.yiddish', ''),
('language', 'yo', 'yoruba', 0, 1, 0, 'language.yoruba', ''),
('language', 'yrl', 'nheengatu', 0, 1, 0, 'language.nheengatu', ''),
('language', 'yue', 'cantonese', 0, 1, 0, 'language.cantonese', ''),
('language', 'za', 'zhuang', 0, 1, 0, 'language.zhuang', ''),
('language', 'zap', 'zapotec', 0, 1, 0, 'language.zapotec', ''),
('language', 'zbl', 'blissymbols', 0, 1, 0, 'language.blissymbols', ''),
('language', 'zea', 'zeelandic', 0, 1, 0, 'language.zeelandic', ''),
('language', 'zen', 'zenaga', 0, 1, 0, 'language.zenaga', ''),
('language', 'zgh', 'tamazight.standardmoroccan', 0, 1, 0, 'language.tamazight.standardmoroccan', ''),
('language', 'zh', 'chinese', 0, 1, 0, 'language.chinese', ''),
('language', 'zh-Hans', 'chinese.simplified', 0, 1, 0, 'language.chinese.simplified', ''),
('language', 'zh-Hant', 'chinese.traditional', 0, 1, 0, 'language.chinese.traditional', ''),
('language', 'zu', 'zulu', 0, 1, 0, 'language.zulu', ''),
('language', 'zun', 'zuni', 0, 1, 0, 'language.zuni', ''),
('language', 'zxx', 'none', 0, 1, 0, 'language.none', ''),
('language', 'zza', 'zaza', 0, 1, 0, 'language.zaza', ''),
('mass', 'g', 'gram', 0, 1, 0, 'mass.gram', ''),
('mass', 'kg', 'kilogram', 0, 1, 0, 'mass.kilogram', ''),
('mass', 'mg', 'milligram', 0, 1, 0, 'mass.milligram', ''),
('mass', 't', 'tonne', 0, 1, 0, 'mass.tonne', ''),
('mass', 'µg', 'microgram', 0, 1, 0, 'mass.microgram', ''),
('mediatype', 'text/html', '', 0, 1, 0, 'mediatype.text.html', ''),
('mediatype', 'text/plain', 'plain', 0, 1, 0, 'mediatype.text.plain', ''),
('mno12.contamination', 'mixturewithoverburden', '', 0, 1, 0, 'mno12.contamination.mixturewithoverburden', ''),
('mno12.contamination', 'modernintrusions', '', 0, 1, 0, 'mno12.contamination.modernintrusions', ''),
('mno12.contamination', 'noconatm', '', 0, 1, 0, 'mno12.contamination.noconatm', ''),
('mno12.contamination', 'othercontext', '', 0, 1, 0, 'mno12.contamination.othercontext', ''),
('mno12.contamination', 'otherspecifybelow', '', 0, 1, 0, 'mno12.contamination.otherspecifybelow', ''),
('mno12.contamination', 'rootaction', '', 0, 1, 0, 'mno12.contamination.rootaction', ''),
('mno12.context.type', 'cut', '', 0, 1, 0, 'mno12.context.type.cut', ''),
('mno12.context.type', 'fill', '', 0, 1, 0, 'mno12.context.type.fill', ''),
('mno12.context.type', 'masonry', '', 0, 1, 0, 'mno12.context.type.masonry', ''),
('mno12.context.type', 'skeleton', '', 0, 1, 0, 'mno12.context.type.skeleton', ''),
('mno12.context.type', 'timber', '', 0, 1, 0, 'mno12.context.type.timber', ''),
('mno12.context.type', 'void', '', 0, 1, 0, 'mno12.context.type.void', ''),
('mno12.cxtbasicinterp', 'cellar', '', 0, 1, 0, 'mno12.cxtbasicinterp.cellar', ''),
('mno12.cxtbasicinterp', 'coffin', '', 0, 1, 0, 'mno12.cxtbasicinterp.coffin', ''),
('mno12.cxtbasicinterp', 'consdebris', '', 0, 1, 0, 'mno12.cxtbasicinterp.consdebris', ''),
('mno12.cxtbasicinterp', 'cremation', '', 0, 1, 0, 'mno12.cxtbasicinterp.cremation', ''),
('mno12.cxtbasicinterp', 'ddebris', '', 0, 1, 0, 'mno12.cxtbasicinterp.ddebris', ''),
('mno12.cxtbasicinterp', 'ddebris2', '', 0, 1, 0, 'mno12.cxtbasicinterp.ddebris2', ''),
('mno12.cxtbasicinterp', 'ditch', '', 0, 1, 0, 'mno12.cxtbasicinterp.ditch', ''),
('mno12.cxtbasicinterp', 'exbank', '', 0, 1, 0, 'mno12.cxtbasicinterp.exbank', ''),
('mno12.cxtbasicinterp', 'excult', '', 0, 1, 0, 'mno12.cxtbasicinterp.excult', ''),
('mno12.cxtbasicinterp', 'exdump', '', 0, 1, 0, 'mno12.cxtbasicinterp.exdump', ''),
('mno12.cxtbasicinterp', 'exmetal', '', 0, 1, 0, 'mno12.cxtbasicinterp.exmetal', ''),
('mno12.cxtbasicinterp', 'exocc', '', 0, 1, 0, 'mno12.cxtbasicinterp.exocc', ''),
('mno12.cxtbasicinterp', 'exrevet', '', 0, 1, 0, 'mno12.cxtbasicinterp.exrevet', ''),
('mno12.cxtbasicinterp', 'exsur', '', 0, 1, 0, 'mno12.cxtbasicinterp.exsur', ''),
('mno12.cxtbasicinterp', 'external', '', 0, 1, 0, 'mno12.cxtbasicinterp.external', ''),
('mno12.cxtbasicinterp', 'floor', '', 0, 1, 0, 'mno12.cxtbasicinterp.floor', ''),
('mno12.cxtbasicinterp', 'furnace', '', 0, 1, 0, 'mno12.cxtbasicinterp.furnace', ''),
('mno12.cxtbasicinterp', 'grave', '', 0, 1, 0, 'mno12.cxtbasicinterp.grave', ''),
('mno12.cxtbasicinterp', 'gravecut', '', 0, 1, 0, 'mno12.cxtbasicinterp.gravecut', ''),
('mno12.cxtbasicinterp', 'hearth', '', 0, 1, 0, 'mno12.cxtbasicinterp.hearth', ''),
('mno12.cxtbasicinterp', 'makeup', '', 0, 1, 0, 'mno12.cxtbasicinterp.makeup', ''),
('mno12.cxtbasicinterp', 'mechanical', '', 0, 1, 0, 'mno12.cxtbasicinterp.mechanical', ''),
('mno12.cxtbasicinterp', 'natchannel', '', 0, 1, 0, 'mno12.cxtbasicinterp.natchannel', ''),
('mno12.cxtbasicinterp', 'naterosion', '', 0, 1, 0, 'mno12.cxtbasicinterp.naterosion', ''),
('mno12.cxtbasicinterp', 'natforeshore', '', 0, 1, 0, 'mno12.cxtbasicinterp.natforeshore', ''),
('mno12.cxtbasicinterp', 'natmarsh', '', 0, 1, 0, 'mno12.cxtbasicinterp.natmarsh', ''),
('mno12.cxtbasicinterp', 'natoverbank', '', 0, 1, 0, 'mno12.cxtbasicinterp.natoverbank', ''),
('mno12.cxtbasicinterp', 'natsoil', '', 0, 1, 0, 'mno12.cxtbasicinterp.natsoil', ''),
('mno12.cxtbasicinterp', 'natural', '', 0, 1, 0, 'mno12.cxtbasicinterp.natural', ''),
('mno12.cxtbasicinterp', 'natwind', '', 0, 1, 0, 'mno12.cxtbasicinterp.natwind', ''),
('mno12.cxtbasicinterp', 'nonstructcut', '', 0, 1, 0, 'mno12.cxtbasicinterp.nonstructcut', ''),
('mno12.cxtbasicinterp', 'occdebris', '', 0, 1, 0, 'mno12.cxtbasicinterp.occdebris', ''),
('mno12.cxtbasicinterp', 'pasture', '', 0, 1, 0, 'mno12.cxtbasicinterp.pasture', ''),
('mno12.cxtbasicinterp', 'pit', '', 0, 1, 0, 'mno12.cxtbasicinterp.pit', ''),
('mno12.cxtbasicinterp', 'pitcess', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitcess', ''),
('mno12.cxtbasicinterp', 'pitcooking', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitcooking', ''),
('mno12.cxtbasicinterp', 'pitossuary', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitossuary', ''),
('mno12.cxtbasicinterp', 'pitquarry', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitquarry', ''),
('mno12.cxtbasicinterp', 'pitrefuse', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitrefuse', ''),
('mno12.cxtbasicinterp', 'pitstorage', '', 0, 1, 0, 'mno12.cxtbasicinterp.pitstorage', ''),
('mno12.cxtbasicinterp', 'posstruct', '', 0, 1, 0, 'mno12.cxtbasicinterp.posstruct', ''),
('mno12.cxtbasicinterp', 'posthole', '', 0, 1, 0, 'mno12.cxtbasicinterp.posthole', ''),
('mno12.cxtbasicinterp', 'roofceil', '', 0, 1, 0, 'mno12.cxtbasicinterp.roofceil', ''),
('mno12.cxtbasicinterp', 'skeleton', '', 0, 1, 0, 'mno12.cxtbasicinterp.skeleton', ''),
('mno12.cxtbasicinterp', 'structcut', '', 0, 1, 0, 'mno12.cxtbasicinterp.structcut', ''),
('mno12.cxtbasicinterp', 'structopening', '', 0, 1, 0, 'mno12.cxtbasicinterp.structopening', ''),
('mno12.cxtbasicinterp', 'structtimb', '', 0, 1, 0, 'mno12.cxtbasicinterp.structtimb', ''),
('mno12.cxtbasicinterp', 'sump', '', 0, 1, 0, 'mno12.cxtbasicinterp.sump', ''),
('mno12.cxtbasicinterp', 'surerosion', '', 0, 1, 0, 'mno12.cxtbasicinterp.surerosion', ''),
('mno12.cxtbasicinterp', 'timber', '', 0, 1, 0, 'mno12.cxtbasicinterp.timber', ''),
('mno12.cxtbasicinterp', 'tree', '', 0, 1, 0, 'mno12.cxtbasicinterp.tree', ''),
('mno12.cxtbasicinterp', 'unknown', '', 0, 1, 0, 'mno12.cxtbasicinterp.unknown', ''),
('mno12.cxtbasicinterp', 'wall', '', 0, 1, 0, 'mno12.cxtbasicinterp.wall', ''),
('mno12.cxtbasicinterp', 'well', '', 0, 1, 0, 'mno12.cxtbasicinterp.well', ''),
('mno12.cxtbasicinterp', 'workedstone', '', 0, 1, 0, 'mno12.cxtbasicinterp.workedstone', ''),
('mno12.facing', 'e', '', 0, 1, 0, 'mno12.facing.e', ''),
('mno12.facing', 'ese', '', 0, 1, 0, 'mno12.facing.ese', ''),
('mno12.facing', 'n', '', 0, 1, 0, 'mno12.facing.n', ''),
('mno12.facing', 'na_1', '', 0, 1, 0, 'mno12.facing.na_1', ''),
('mno12.facing', 'ne', '', 0, 1, 0, 'mno12.facing.ne', ''),
('mno12.facing', 'nw', '', 0, 1, 0, 'mno12.facing.nw', ''),
('mno12.facing', 's', '', 0, 1, 0, 'mno12.facing.s', ''),
('mno12.facing', 'se', '', 0, 1, 0, 'mno12.facing.se', ''),
('mno12.facing', 'sse', '', 0, 1, 0, 'mno12.facing.sse', ''),
('mno12.facing', 'sw', '', 0, 1, 0, 'mno12.facing.sw', ''),
('mno12.facing', 'w', '', 0, 1, 0, 'mno12.facing.w', ''),
('mno12.find.type', 'coin', '', 0, 1, 0, 'mno12.find.type.coin', ''),
('mno12.find.type', 'object', '', 0, 1, 0, 'mno12.find.type.object', ''),
('mno12.findtype', 'bone', '', 0, 1, 0, 'mno12.findtype.bone', ''),
('mno12.findtype', 'brick', '', 0, 1, 0, 'mno12.findtype.brick', ''),
('mno12.findtype', 'bricksample', '', 0, 1, 0, 'mno12.findtype.bricksample', ''),
('mno12.findtype', 'cbm', '', 0, 1, 0, 'mno12.findtype.cbm', ''),
('mno12.findtype', 'cement', '', 0, 1, 0, 'mno12.findtype.cement', ''),
('mno12.findtype', 'charcoal1', '', 0, 1, 0, 'mno12.findtype.charcoal1', ''),
('mno12.findtype', 'clayhaircurlers', '', 0, 1, 0, 'mno12.findtype.clayhaircurlers', ''),
('mno12.findtype', 'crucible', '', 0, 1, 0, 'mno12.findtype.crucible', ''),
('mno12.findtype', 'ctp', '', 0, 1, 0, 'mno12.findtype.ctp', ''),
('mno12.findtype', 'feobj', '', 0, 1, 0, 'mno12.findtype.feobj', ''),
('mno12.findtype', 'flint', '', 0, 1, 0, 'mno12.findtype.flint', ''),
('mno12.findtype', 'glass', '', 0, 1, 0, 'mno12.findtype.glass', ''),
('mno12.findtype', 'leather', '', 0, 1, 0, 'mno12.findtype.leather', ''),
('mno12.findtype', 'marble', '', 0, 1, 0, 'mno12.findtype.marble', ''),
('mno12.findtype', 'metal', '', 0, 1, 0, 'mno12.findtype.metal', ''),
('mno12.findtype', 'mortar', '', 0, 1, 0, 'mno12.findtype.mortar', ''),
('mno12.findtype', 'nofinds', '', 0, 1, 0, 'mno12.findtype.nofinds', ''),
('mno12.findtype', 'other', '', 0, 1, 0, 'mno12.findtype.other', ''),
('mno12.findtype', 'pot', '', 0, 1, 0, 'mno12.findtype.pot', ''),
('mno12.findtype', 'slag1', '', 0, 1, 0, 'mno12.findtype.slag1', ''),
('mno12.findtype', 'tile1', '', 0, 1, 0, 'mno12.findtype.tile1', ''),
('mno12.findtype', 'timber', '', 0, 1, 0, 'mno12.findtype.timber', ''),
('mno12.findtype', 'wood', '', 0, 1, 0, 'mno12.findtype.wood', ''),
('mno12.findtype', 'workedbone', '', 0, 1, 0, 'mno12.findtype.workedbone', ''),
('mno12.findtype', 'workedstone1', '', 0, 1, 0, 'mno12.findtype.workedstone1', ''),
('mno12.hfextrac', 'charcoal', '', 0, 1, 0, 'mno12.hfextrac.charcoal', ''),
('mno12.hfextrac', 'hrbonecrem2to4', '', 0, 1, 0, 'mno12.hfextrac.hrbonecrem2to4', ''),
('mno12.hfextrac', 'hrbonecremgt4', '', 0, 1, 0, 'mno12.hfextrac.hrbonecremgt4', ''),
('mno12.hfextrac', 'hrboneinhum', '', 0, 1, 0, 'mno12.hfextrac.hrboneinhum', ''),
('mno12.hfstatus', 'bagged', '', 0, 1, 0, 'mno12.hfstatus.bagged', ''),
('mno12.hfstatus', 'drying', '', 0, 1, 0, 'mno12.hfstatus.drying', ''),
('mno12.hfstatus', 'processed', '', 0, 1, 0, 'mno12.hfstatus.processed', ''),
('mno12.layerformat', 'geojson', '', 0, 1, 0, 'mno12.layerformat.geojson', ''),
('mno12.layerformat', 'tilejson', '', 0, 1, 0, 'mno12.layerformat.tilejson', ''),
('mno12.layerformat', 'wfs', '', 0, 1, 0, 'mno12.layerformat.wfs', ''),
('mno12.layerformat', 'wms', '', 0, 1, 0, 'mno12.layerformat.wms', ''),
('mno12.lflocn', 'areae', '', 0, 1, 0, 'mno12.lflocn.areae', ''),
('mno12.lflocn', 'cambridge', '', 0, 1, 0, 'mno12.lflocn.cambridge', ''),
('mno12.lflocn', 'externalspec', '', 0, 1, 0, 'mno12.lflocn.externalspec', ''),
('mno12.lflocn', 'noflotlocn', '', 0, 1, 0, 'mno12.lflocn.noflotlocn', ''),
('mno12.lfstatus', 'bagged', '', 0, 1, 0, 'mno12.lfstatus.bagged', ''),
('mno12.lfstatus', 'drying', '', 0, 1, 0, 'mno12.lfstatus.drying', ''),
('mno12.lfstatus', 'processed', '', 0, 1, 0, 'mno12.lfstatus.processed', ''),
('mno12.objectcompleteness', 'half', '', 0, 1, 0, 'mno12.objectcompleteness.half', ''),
('mno12.objectcompleteness', 'whole', '', 0, 1, 0, 'mno12.objectcompleteness.whole', ''),
('mno12.objectdisplay', 'displayable', '', 0, 1, 0, 'mno12.objectdisplay.displayable', ''),
('mno12.objectinterptype', 'alle', '', 0, 1, 0, 'mno12.objectinterptype.alle', ''),
('mno12.objectinterptype', 'awl', '', 0, 1, 0, 'mno12.objectinterptype.awl', ''),
('mno12.objectinterptype', 'badg', '', 0, 1, 0, 'mno12.objectinterptype.badg', ''),
('mno12.objectinterptype', 'barr', '', 0, 1, 0, 'mno12.objectinterptype.barr', ''),
('mno12.objectinterptype', 'bead', '', 0, 1, 0, 'mno12.objectinterptype.bead', ''),
('mno12.objectinterptype', 'beaker', '', 0, 1, 0, 'mno12.objectinterptype.beaker', ''),
('mno12.objectinterptype', 'blot', '', 0, 1, 0, 'mno12.objectinterptype.blot', ''),
('mno12.objectinterptype', 'bottle', '', 0, 1, 0, 'mno12.objectinterptype.bottle', ''),
('mno12.objectinterptype', 'bowl', '', 0, 1, 0, 'mno12.objectinterptype.bowl', ''),
('mno12.objectinterptype', 'bracket', '', 0, 1, 0, 'mno12.objectinterptype.bracket', ''),
('mno12.objectinterptype', 'brak', '', 0, 1, 0, 'mno12.objectinterptype.brak', ''),
('mno12.objectinterptype', 'broo', '', 0, 1, 0, 'mno12.objectinterptype.broo', ''),
('mno12.objectinterptype', 'brush', '', 0, 1, 0, 'mno12.objectinterptype.brush', ''),
('mno12.objectinterptype', 'buck', '', 0, 1, 0, 'mno12.objectinterptype.buck', ''),
('mno12.objectinterptype', 'butt', '', 0, 1, 0, 'mno12.objectinterptype.butt', ''),
('mno12.objectinterptype', 'came', '', 0, 1, 0, 'mno12.objectinterptype.came', ''),
('mno12.objectinterptype', 'chap', '', 0, 1, 0, 'mno12.objectinterptype.chap', ''),
('mno12.objectinterptype', 'chat', '', 0, 1, 0, 'mno12.objectinterptype.chat', ''),
('mno12.objectinterptype', 'chis', '', 0, 1, 0, 'mno12.objectinterptype.chis', ''),
('mno12.objectinterptype', 'clos', '', 0, 1, 0, 'mno12.objectinterptype.clos', ''),
('mno12.objectinterptype', 'cloth', '', 0, 1, 0, 'mno12.objectinterptype.cloth', ''),
('mno12.objectinterptype', 'coin', '', 0, 1, 0, 'mno12.objectinterptype.coin', ''),
('mno12.objectinterptype', 'comb', '', 0, 1, 0, 'mno12.objectinterptype.comb', ''),
('mno12.objectinterptype', 'coun', '', 0, 1, 0, 'mno12.objectinterptype.coun', ''),
('mno12.objectinterptype', 'cruc', '', 0, 1, 0, 'mno12.objectinterptype.cruc', ''),
('mno12.objectinterptype', 'cup', '', 0, 1, 0, 'mno12.objectinterptype.cup', ''),
('mno12.objectinterptype', 'drhk', '', 0, 1, 0, 'mno12.objectinterptype.drhk', ''),
('mno12.objectinterptype', 'ferr', '', 0, 1, 0, 'mno12.objectinterptype.ferr', ''),
('mno12.objectinterptype', 'figu', '', 0, 1, 0, 'mno12.objectinterptype.figu', ''),
('mno12.objectinterptype', 'flask', '', 0, 1, 0, 'mno12.objectinterptype.flask', ''),
('mno12.objectinterptype', 'flor', '', 0, 1, 0, 'mno12.objectinterptype.flor', ''),
('mno12.objectinterptype', 'gufl', '', 0, 1, 0, 'mno12.objectinterptype.gufl', ''),
('mno12.objectinterptype', 'handle', '', 0, 1, 0, 'mno12.objectinterptype.handle', ''),
('mno12.objectinterptype', 'hinge', '', 0, 1, 0, 'mno12.objectinterptype.hinge', ''),
('mno12.objectinterptype', 'hone', '', 0, 1, 0, 'mno12.objectinterptype.hone', ''),
('mno12.objectinterptype', 'hosh', '', 0, 1, 0, 'mno12.objectinterptype.hosh', ''),
('mno12.objectinterptype', 'inly', '', 0, 1, 0, 'mno12.objectinterptype.inly', ''),
('mno12.objectinterptype', 'jar', '', 0, 1, 0, 'mno12.objectinterptype.jar', ''),
('mno12.objectinterptype', 'jug', '', 0, 1, 0, 'mno12.objectinterptype.jug', ''),
('mno12.objectinterptype', 'key', '', 0, 1, 0, 'mno12.objectinterptype.key', ''),
('mno12.objectinterptype', 'knife', '', 0, 1, 0, 'mno12.objectinterptype.knife', ''),
('mno12.objectinterptype', 'ladl', '', 0, 1, 0, 'mno12.objectinterptype.ladl', ''),
('mno12.objectinterptype', 'lamp', '', 0, 1, 0, 'mno12.objectinterptype.lamp', ''),
('mno12.objectinterptype', 'lock', '', 0, 1, 0, 'mno12.objectinterptype.lock', ''),
('mno12.objectinterptype', 'morm', '', 0, 1, 0, 'mno12.objectinterptype.morm', ''),
('mno12.objectinterptype', 'mount', '', 0, 1, 0, 'mno12.objectinterptype.mount', ''),
('mno12.objectinterptype', 'nail', '', 0, 1, 0, 'mno12.objectinterptype.nail', ''),
('mno12.objectinterptype', 'padl', '', 0, 1, 0, 'mno12.objectinterptype.padl', ''),
('mno12.objectinterptype', 'patc', '', 0, 1, 0, 'mno12.objectinterptype.patc', ''),
('mno12.objectinterptype', 'patt', '', 0, 1, 0, 'mno12.objectinterptype.patt', ''),
('mno12.objectinterptype', 'phial', '', 0, 1, 0, 'mno12.objectinterptype.phial', ''),
('mno12.objectinterptype', 'pin', '', 0, 1, 0, 'mno12.objectinterptype.pin', ''),
('mno12.objectinterptype', 'pinb', '', 0, 1, 0, 'mno12.objectinterptype.pinb', ''),
('mno12.objectinterptype', 'pipe', '', 0, 1, 0, 'mno12.objectinterptype.pipe', ''),
('mno12.objectinterptype', 'plug', '', 0, 1, 0, 'mno12.objectinterptype.plug', ''),
('mno12.objectinterptype', 'quern', '', 0, 1, 0, 'mno12.objectinterptype.quern', ''),
('mno12.objectinterptype', 'ring', '', 0, 1, 0, 'mno12.objectinterptype.ring', ''),
('mno12.objectinterptype', 'rivet', '', 0, 1, 0, 'mno12.objectinterptype.rivet', ''),
('mno12.objectinterptype', 'rove', '', 0, 1, 0, 'mno12.objectinterptype.rove', ''),
('mno12.objectinterptype', 'sam', '', 0, 1, 0, 'mno12.objectinterptype.sam', ''),
('mno12.objectinterptype', 'sbox', '', 0, 1, 0, 'mno12.objectinterptype.sbox', ''),
('mno12.objectinterptype', 'shoe', '', 0, 1, 0, 'mno12.objectinterptype.shoe', ''),
('mno12.objectinterptype', 'shot', '', 0, 1, 0, 'mno12.objectinterptype.shot', ''),
('mno12.objectinterptype', 'slag', '', 0, 1, 0, 'mno12.objectinterptype.slag', ''),
('mno12.objectinterptype', 'spindle', '', 0, 1, 0, 'mno12.objectinterptype.spindle', ''),
('mno12.objectinterptype', 'spoo', '', 0, 1, 0, 'mno12.objectinterptype.spoo', ''),
('mno12.objectinterptype', 'staple', '', 0, 1, 0, 'mno12.objectinterptype.staple', ''),
('mno12.objectinterptype', 'stft', '', 0, 1, 0, 'mno12.objectinterptype.stft', ''),
('mno12.objectinterptype', 'stpe', '', 0, 1, 0, 'mno12.objectinterptype.stpe', ''),
('mno12.objectinterptype', 'strap', '', 0, 1, 0, 'mno12.objectinterptype.strap', ''),
('mno12.objectinterptype', 'stud', '', 0, 1, 0, 'mno12.objectinterptype.stud', ''),
('mno12.objectinterptype', 'tessera', '', 0, 1, 0, 'mno12.objectinterptype.tessera', ''),
('mno12.objectinterptype', 'tile', '', 0, 1, 0, 'mno12.objectinterptype.tile', ''),
('mno12.objectinterptype', 'toot', '', 0, 1, 0, 'mno12.objectinterptype.toot', ''),
('mno12.objectinterptype', 'tumb', '', 0, 1, 0, 'mno12.objectinterptype.tumb', ''),
('mno12.objectinterptype', 'vessel', '', 0, 1, 0, 'mno12.objectinterptype.vessel', ''),
('mno12.objectinterptype', 'walt', '', 0, 1, 0, 'mno12.objectinterptype.walt', ''),
('mno12.objectinterptype', 'waste', '', 0, 1, 0, 'mno12.objectinterptype.waste', ''),
('mno12.objectinterptype', 'weig', '', 0, 1, 0, 'mno12.objectinterptype.weig', ''),
('mno12.objectinterptype', 'wigc', '', 0, 1, 0, 'mno12.objectinterptype.wigc', ''),
('mno12.objectinterptype', 'window', '', 0, 1, 0, 'mno12.objectinterptype.window', ''),
('mno12.objectinterptype', 'wire', '', 0, 1, 0, 'mno12.objectinterptype.wire', ''),
('mno12.objectinterptype', 'zzz', '', 0, 1, 0, 'mno12.objectinterptype.zzz', ''),
('mno12.objectmaterial', 'bone', '', 0, 1, 0, 'mno12.objectmaterial.bone', ''),
('mno12.objectmaterial', 'ceramic', '', 0, 1, 0, 'mno12.objectmaterial.ceramic', ''),
('mno12.objectmaterial', 'copper', '', 0, 1, 0, 'mno12.objectmaterial.copper', ''),
('mno12.objectmaterial', 'fibre', '', 0, 1, 0, 'mno12.objectmaterial.fibre', ''),
('mno12.objectmaterial', 'flint', '', 0, 1, 0, 'mno12.objectmaterial.flint', ''),
('mno12.objectmaterial', 'glass', '', 0, 1, 0, 'mno12.objectmaterial.glass', ''),
('mno12.objectmaterial', 'iron', '', 0, 1, 0, 'mno12.objectmaterial.iron', ''),
('mno12.objectmaterial', 'ivory', '', 0, 1, 0, 'mno12.objectmaterial.ivory', ''),
('mno12.objectmaterial', 'lead', '', 0, 1, 0, 'mno12.objectmaterial.lead', ''),
('mno12.objectmaterial', 'leather', '', 0, 1, 0, 'mno12.objectmaterial.leather', ''),
('mno12.objectmaterial', 'samp', '', 0, 1, 0, 'mno12.objectmaterial.samp', ''),
('mno12.objectmaterial', 'stone', '', 0, 1, 0, 'mno12.objectmaterial.stone', ''),
('mno12.objectmaterial', 'wood', '', 0, 1, 0, 'mno12.objectmaterial.wood', ''),
('mno12.objectperiod', 'medieval', '', 0, 1, 0, 'mno12.objectperiod.medieval', ''),
('mno12.objectperiod', 'ph', '', 0, 1, 0, 'mno12.objectperiod.ph', ''),
('mno12.objectperiod', 'postmed', '', 0, 1, 0, 'mno12.objectperiod.postmed', ''),
('mno12.objectperiod', 'roman', '', 0, 1, 0, 'mno12.objectperiod.roman', ''),
('mno12.phase', 'phase1', '', 0, 1, 0, 'mno12.phase.phase1', ''),
('mno12.phase', 'phase2', '', 0, 1, 0, 'mno12.phase.phase2', ''),
('mno12.phase', 'phase3', '', 0, 1, 0, 'mno12.phase.phase3', ''),
('mno12.phase', 'phase4', '', 0, 1, 0, 'mno12.phase.phase4', ''),
('mno12.priority', 'high', '', 0, 1, 0, 'mno12.priority.high', ''),
('mno12.priority', 'low', '', 0, 1, 0, 'mno12.priority.low', ''),
('mno12.priority', 'medium', '', 0, 1, 0, 'mno12.priority.medium', ''),
('mno12.process', 'c', '', 0, 1, 0, 'mno12.process.c', ''),
('mno12.process', 'cu', '', 0, 1, 0, 'mno12.process.cu', ''),
('mno12.process', 'cud', '', 0, 1, 0, 'mno12.process.cud', ''),
('mno12.process', 'd', '', 0, 1, 0, 'mno12.process.d', ''),
('mno12.process', 'u', '', 0, 1, 0, 'mno12.process.u', ''),
('mno12.process', 'ud', '', 0, 1, 0, 'mno12.process.ud', ''),
('mno12.projection', 'epsgto4326', '', 0, 1, 0, 'mno12.projection.epsgto4326', ''),
('mno12.projection', 'epsgto900913', '', 0, 1, 0, 'mno12.projection.epsgto900913', ''),
('mno12.provperiod', 'earlypm', '', 0, 1, 0, 'mno12.provperiod.earlypm', ''),
('mno12.provperiod', 'latepm', '', 0, 1, 0, 'mno12.provperiod.latepm', ''),
('mno12.provperiod', 'modern', '', 0, 1, 0, 'mno12.provperiod.modern', ''),
('mno12.provperiod', 'natural', '', 0, 1, 0, 'mno12.provperiod.natural', ''),
('mno12.provperiod', 'pmsoils', '', 0, 1, 0, 'mno12.provperiod.pmsoils', ''),
('mno12.provperiod', 'prerom', '', 0, 1, 0, 'mno12.provperiod.prerom', ''),
('mno12.provperiod', 'romani', '', 0, 1, 0, 'mno12.provperiod.romani', ''),
('mno12.provperiod', 'romii', '', 0, 1, 0, 'mno12.provperiod.romii', ''),
('mno12.recflag', 'chkd', '', 0, 1, 0, 'mno12.recflag.chkd', ''),
('mno12.recflag', 'datcmp', '', 0, 1, 0, 'mno12.recflag.datcmp', ''),
('mno12.recflag', 'exc', '', 0, 1, 0, 'mno12.recflag.exc', ''),
('mno12.recflag', 'notexc', '', 0, 1, 0, 'mno12.recflag.notexc', ''),
('mno12.recflag', 'partexc', '', 0, 1, 0, 'mno12.recflag.partexc', ''),
('mno12.recflag', 'reccomplete', '', 0, 1, 0, 'mno12.recflag.reccomplete', ''),
('mno12.recordstatus', 'deleted', '', 0, 1, 0, 'mno12.recordstatus.deleted', ''),
('mno12.recordstatus', 'issued', '', 0, 1, 0, 'mno12.recordstatus.issued', ''),
('mno12.recordstatus', 'registered', '', 0, 1, 0, 'mno12.recordstatus.registered', ''),
('mno12.recordstatus', 'unallocated', '', 0, 1, 0, 'mno12.recordstatus.unallocated', ''),
('mno12.recordstatus', 'voided', '', 0, 1, 0, 'mno12.recordstatus.voided', ''),
('mno12.reuseattr', 'no', '', 0, 1, 0, 'mno12.reuseattr.no', ''),
('mno12.reuseattr', 'unknown1', '', 0, 1, 0, 'mno12.reuseattr.unknown1', ''),
('mno12.reuseattr', 'yes', '', 0, 1, 0, 'mno12.reuseattr.yes', ''),
('mno12.samplecondition', 'dry', '', 0, 1, 0, 'mno12.samplecondition.dry', ''),
('mno12.samplecondition', 'moist', '', 0, 1, 0, 'mno12.samplecondition.moist', ''),
('mno12.samplecondition', 'waterlogged', '', 0, 1, 0, 'mno12.samplecondition.waterlogged', ''),
('mno12.samplesize', '20to40pcnt', '', 0, 1, 0, 'mno12.samplesize.20to40pcnt', ''),
('mno12.samplesize', '40to60pcnt', '', 0, 1, 0, 'mno12.samplesize.40to60pcnt', ''),
('mno12.samplesize', '5to20pcnt', '', 0, 1, 0, 'mno12.samplesize.5to20pcnt', ''),
('mno12.samplesize', '60to80pcnt', '', 0, 1, 0, 'mno12.samplesize.60to80pcnt', ''),
('mno12.samplesize', '80to100pcnt', '', 0, 1, 0, 'mno12.samplesize.80to100pcnt', ''),
('mno12.samplesize', 'lt5pcnt', '', 0, 1, 0, 'mno12.samplesize.lt5pcnt', ''),
('mno12.samplestatus', 'boneextracted', '', 0, 1, 0, 'mno12.samplestatus.boneextracted', ''),
('mno12.samplestatus', 'cambridge', '', 0, 1, 0, 'mno12.samplestatus.cambridge', ''),
('mno12.samplestatus', 'datmissing', '', 0, 1, 0, 'mno12.samplestatus.datmissing', ''),
('mno12.samplestatus', 'extern', '', 0, 1, 0, 'mno12.samplestatus.extern', ''),
('mno12.samplestatus', 'missing', '', 0, 1, 0, 'mno12.samplestatus.missing', ''),
('mno12.samplestatus', 'notproc', '', 0, 1, 0, 'mno12.samplestatus.notproc', ''),
('mno12.samplestatus', 'processed', '', 0, 1, 0, 'mno12.samplestatus.processed', ''),
('mno12.samplestatus', 'residuesorted', '', 0, 1, 0, 'mno12.samplestatus.residuesorted', ''),
('mno12.samplestatus', 'retained', '', 0, 1, 0, 'mno12.samplestatus.retained', ''),
('mno12.samplestatus', 'site', '', 0, 1, 0, 'mno12.samplestatus.site', ''),
('mno12.samplestatus', 'void', '', 0, 1, 0, 'mno12.samplestatus.void', ''),
('mno12.sampletype', 'cremation', '', 0, 1, 0, 'mno12.sampletype.cremation', ''),
('mno12.sampletype', 'ecorec', '', 0, 1, 0, 'mno12.sampletype.ecorec', ''),
('mno12.sampletype', 'ecospec', '', 0, 1, 0, 'mno12.sampletype.ecospec', ''),
('mno12.sampletype', 'genbulk', '', 0, 1, 0, 'mno12.sampletype.genbulk', ''),
('mno12.sampletype', 'kubi', '', 0, 1, 0, 'mno12.sampletype.kubi', ''),
('mno12.sampletype', 'monolith', '', 0, 1, 0, 'mno12.sampletype.monolith', ''),
('mno12.sampletype', 'pollen', '', 0, 1, 0, 'mno12.sampletype.pollen', ''),
('mno12.sampletype', 'skeleton', '', 0, 1, 0, 'mno12.sampletype.skeleton', ''),
('mno12.sampletype', 'snails', '', 0, 1, 0, 'mno12.sampletype.snails', ''),
('mno12.sampletype', 'soilchem', '', 0, 1, 0, 'mno12.sampletype.soilchem', ''),
('mno12.sampletype', 'spec', '', 0, 1, 0, 'mno12.sampletype.spec', ''),
('mno12.sampletype', 'waterlogged', '', 0, 1, 0, 'mno12.sampletype.waterlogged', ''),
('mno12.scale', '1to11', '', 0, 1, 0, 'mno12.scale.1to11', ''),
('mno12.scale', '1to5', '', 0, 1, 0, 'mno12.scale.1to5', ''),
('mno12.scale', 'ratio1to10', '', 0, 1, 0, 'mno12.scale.ratio1to10', ''),
('mno12.scale', 'ratio1to20', '', 0, 1, 0, 'mno12.scale.ratio1to20', ''),
('mno12.scalebar', '02m', '', 0, 1, 0, 'mno12.scalebar.02m', ''),
('mno12.scalebar', '02m02m', '', 0, 1, 0, 'mno12.scalebar.02m02m', ''),
('mno12.scalebar', '02m05m', '', 0, 1, 0, 'mno12.scalebar.02m05m', ''),
('mno12.scalebar', '02m05m1m', '', 0, 1, 0, 'mno12.scalebar.02m05m1m', ''),
('mno12.scalebar', '02m1m', '', 0, 1, 0, 'mno12.scalebar.02m1m', ''),
('mno12.scalebar', '03m', '', 0, 1, 0, 'mno12.scalebar.03m', ''),
('mno12.scalebar', '03m02m', '', 0, 1, 0, 'mno12.scalebar.03m02m', ''),
('mno12.scalebar', '03m05m', '', 0, 1, 0, 'mno12.scalebar.03m05m', ''),
('mno12.scalebar', '03m1m', '', 0, 1, 0, 'mno12.scalebar.03m1m', ''),
('mno12.scalebar', '05m', '', 0, 1, 0, 'mno12.scalebar.05m', ''),
('mno12.scalebar', '05m02', '', 0, 1, 0, 'mno12.scalebar.05m02', ''),
('mno12.scalebar', '05m02m', '', 0, 1, 0, 'mno12.scalebar.05m02m', ''),
('mno12.scalebar', '1m', '', 0, 1, 0, 'mno12.scalebar.1m', ''),
('mno12.scalebar', '1m03m', '', 0, 1, 0, 'mno12.scalebar.1m03m', ''),
('mno12.scalebar', '1m05m', '', 0, 1, 0, 'mno12.scalebar.1m05m', ''),
('mno12.scalebar', '1m1m', '', 0, 1, 0, 'mno12.scalebar.1m1m', ''),
('mno12.scalebar', '2m', '', 0, 1, 0, 'mno12.scalebar.2m', ''),
('mno12.scalebar', 'na', '', 0, 1, 0, 'mno12.scalebar.na', ''),
('mno12.scalebar', 'ratio1to1', '', 0, 1, 0, 'mno12.scalebar.ratio1to1', ''),
('mno12.servertype', 'localhost', '', 0, 1, 0, 'mno12.servertype.localhost', ''),
('mno12.servertype', 'mapbox', '', 0, 1, 0, 'mno12.servertype.mapbox', ''),
('mno12.smpflag', 'hfass', '', 0, 1, 0, 'mno12.smpflag.hfass', ''),
('mno12.smpflag', 'lghfracrec', '', 0, 1, 0, 'mno12.smpflag.lghfracrec', ''),
('mno12.subsamples', 'controlsediment', '', 0, 1, 0, 'mno12.subsamples.controlsediment', ''),
('mno12.subsamples', 'diatoms', '', 0, 1, 0, 'mno12.subsamples.diatoms', ''),
('mno12.subsamples', 'insects', '', 0, 1, 0, 'mno12.subsamples.insects', ''),
('mno12.subsamples', 'otherspecifybelow1', '', 0, 1, 0, 'mno12.subsamples.otherspecifybelow1', ''),
('mno12.subsamples', 'parasites', '', 0, 1, 0, 'mno12.subsamples.parasites', ''),
('mno12.subsamples', 'plantrems', '', 0, 1, 0, 'mno12.subsamples.plantrems', ''),
('mno12.subsamples', 'pollen', '', 0, 1, 0, 'mno12.subsamples.pollen', ''),
('mno12.subsamples', 'radiocarbon', '', 0, 1, 0, 'mno12.subsamples.radiocarbon', ''),
('mno12.tmbrxsec', 'bark', '', 0, 1, 0, 'mno12.tmbrxsec.bark', ''),
('mno12.tmbrxsec', 'knotty', '', 0, 1, 0, 'mno12.tmbrxsec.knotty', ''),
('mno12.tmbrxsec', 'sapwood', '', 0, 1, 0, 'mno12.tmbrxsec.sapwood', ''),
('mno12.tmbrxsec', 'strgrain', '', 0, 1, 0, 'mno12.tmbrxsec.strgrain', ''),
('mno12.tmbstatus', 'discarded', '', 0, 1, 0, 'mno12.tmbstatus.discarded', ''),
('mno12.tmbstatus', 'lost', '', 0, 1, 0, 'mno12.tmbstatus.lost', ''),
('mno12.tmbstatus', 'void', '', 0, 1, 0, 'mno12.tmbstatus.void', ''),
('mno12.toponymattr', 'areaa', '', 0, 1, 0, 'mno12.toponymattr.areaa', ''),
('mno12.toponymattr', 'areab', '', 0, 1, 0, 'mno12.toponymattr.areab', ''),
('mno12.toponymattr', 'areac', '', 0, 1, 0, 'mno12.toponymattr.areac', ''),
('mno12.toponymattr', 'aread', '', 0, 1, 0, 'mno12.toponymattr.aread', ''),
('mno12.toponymattr', 'areae1', '', 0, 1, 0, 'mno12.toponymattr.areae1', ''),
('mno12.toponymattr', 'areaf', '', 0, 1, 0, 'mno12.toponymattr.areaf', ''),
('mno12.toponymattr', 'areag', '', 0, 1, 0, 'mno12.toponymattr.areag', ''),
('mno12.toponymattr', 'cranebase', '', 0, 1, 0, 'mno12.toponymattr.cranebase', ''),
('mno12.toponymattr', 'gp1', '', 0, 1, 0, 'mno12.toponymattr.gp1', ''),
('mno12.toponymattr', 'gp2', '', 0, 1, 0, 'mno12.toponymattr.gp2', ''),
('mno12.toponymattr', 'sewer', '', 0, 1, 0, 'mno12.toponymattr.sewer', ''),
('mno12.toponymattr', 'tp1', '', 0, 1, 0, 'mno12.toponymattr.tp1', ''),
('mno12.toponymattr', 'tp2', '', 0, 1, 0, 'mno12.toponymattr.tp2', ''),
('mno12.toponymattr', 'tp3', '', 0, 1, 0, 'mno12.toponymattr.tp3', ''),
('mno12.toponymattr', 'tp4', '', 0, 1, 0, 'mno12.toponymattr.tp4', ''),
('mno12.toponymattr', 'tp5', '', 0, 1, 0, 'mno12.toponymattr.tp5', ''),
('mno12.toponymattr', 'tunnel', '', 0, 1, 0, 'mno12.toponymattr.tunnel', ''),
('mno12.toponymattr', 'ukpn', '', 0, 1, 0, 'mno12.toponymattr.ukpn', ''),
('spatial.crs', 'EPSG:4326', 'WGS84', 0, 1, 0, 'crs.wgs84', ''),
('spatial.format', 'geojson', '', 0, 1, 0, 'spatial.format.geojson', ''),
('spatial.format', 'gpx', '', 0, 1, 0, 'spatial.format.gpx', ''),
('spatial.format', 'wkt', '', 0, 1, 0, 'spatial.format.wkt', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_translation`
--

CREATE TABLE `ark_vocabulary_translation` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_translation`
--

INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'vocabulary', 'core.actor.type.institution', 'default', 'core.actor.type.institution', ''),
('en', 'vocabulary', 'core.actor.type.person', 'default', 'core.actor.type.person', ''),
('en', 'vocabulary', 'core.file.status.checkedin', 'default', 'core.file.status.checkedin', ''),
('en', 'vocabulary', 'core.file.status.checkedout', 'default', 'core.file.status.checkedout', ''),
('en', 'vocabulary', 'core.file.status.expired', 'default', 'core.file.status.expired', ''),
('en', 'vocabulary', 'core.file.status.locked', 'default', 'core.file.status.locked', ''),
('en', 'vocabulary', 'core.file.status.new', 'default', 'core.file.status.new', ''),
('en', 'vocabulary', 'core.file.type.audio', 'default', 'core.file.type.audio', ''),
('en', 'vocabulary', 'core.file.type.document', 'default', 'core.file.type.document', ''),
('en', 'vocabulary', 'core.file.type.image', 'default', 'core.file.type.image', ''),
('en', 'vocabulary', 'core.file.type.other', 'default', 'core.file.type.other', ''),
('en', 'vocabulary', 'core.file.type.text', 'default', 'core.file.type.text', ''),
('en', 'vocabulary', 'core.file.type.video', 'default', 'core.file.type.video', ''),
('en', 'vocabulary', 'country.afghanistan', 'default', 'Afghanistan ', ''),
('en', 'vocabulary', 'country.alandislands', 'default', 'Åland Islands ', ''),
('en', 'vocabulary', 'country.albania', 'default', 'Albania ', ''),
('en', 'vocabulary', 'country.algeria', 'default', 'Algeria ', ''),
('en', 'vocabulary', 'country.americansamoa', 'default', 'American Samoa ', ''),
('en', 'vocabulary', 'country.andorra', 'default', 'Andorra ', ''),
('en', 'vocabulary', 'country.angola', 'default', 'Angola ', ''),
('en', 'vocabulary', 'country.anguilla', 'default', 'Anguilla ', ''),
('en', 'vocabulary', 'country.antarctica', 'default', 'Antarctica ', ''),
('en', 'vocabulary', 'country.antigua', 'default', 'Antigua and Barbuda ', ''),
('en', 'vocabulary', 'country.argentina', 'default', 'Argentina ', ''),
('en', 'vocabulary', 'country.armenia', 'default', 'Armenia ', ''),
('en', 'vocabulary', 'country.aruba', 'default', 'Aruba ', ''),
('en', 'vocabulary', 'country.australia', 'default', 'Australia ', ''),
('en', 'vocabulary', 'country.austria', 'default', 'Austria ', ''),
('en', 'vocabulary', 'country.azerbaijan', 'default', 'Azerbaijan ', ''),
('en', 'vocabulary', 'country.bahamas', 'default', 'Bahamas ', ''),
('en', 'vocabulary', 'country.bahrain', 'default', 'Bahrain ', ''),
('en', 'vocabulary', 'country.bangladesh', 'default', 'Bangladesh ', ''),
('en', 'vocabulary', 'country.barbados', 'default', 'Barbados ', ''),
('en', 'vocabulary', 'country.belarus', 'default', 'Belarus ', ''),
('en', 'vocabulary', 'country.belgium', 'default', 'Belgium ', ''),
('en', 'vocabulary', 'country.belize', 'default', 'Belize ', ''),
('en', 'vocabulary', 'country.benin', 'default', 'Benin ', ''),
('en', 'vocabulary', 'country.bermuda', 'default', 'Bermuda ', ''),
('en', 'vocabulary', 'country.bhutan', 'default', 'Bhutan ', ''),
('en', 'vocabulary', 'country.bolivia', 'default', 'Bolivia', ''),
('en', 'vocabulary', 'country.bonaire', 'default', 'Bonaire, Sint Eustatius and Saba ', ''),
('en', 'vocabulary', 'country.bosniaherzegovina', 'default', 'Bosnia and Herzegovina ', ''),
('en', 'vocabulary', 'country.botswana', 'default', 'Botswana ', ''),
('en', 'vocabulary', 'country.brazil', 'default', 'Brazil ', ''),
('en', 'vocabulary', 'country.britishvirginislands', 'default', 'British Virgin Islands', ''),
('en', 'vocabulary', 'country.brunei', 'default', 'Brunei Darussalam ', ''),
('en', 'vocabulary', 'country.bulgaria', 'default', 'Bulgaria ', ''),
('en', 'vocabulary', 'country.burkinafaso', 'default', 'Burkina Faso ', ''),
('en', 'vocabulary', 'country.burundi', 'default', 'Burundi ', ''),
('en', 'vocabulary', 'country.caboverde', 'default', 'Cabo Verde ', ''),
('en', 'vocabulary', 'country.cambodia', 'default', 'Cambodia ', ''),
('en', 'vocabulary', 'country.cameroon', 'default', 'Cameroon ', ''),
('en', 'vocabulary', 'country.canada', 'default', 'Canada ', ''),
('en', 'vocabulary', 'country.caymanislands', 'default', 'Cayman Islands ', ''),
('en', 'vocabulary', 'country.centralafricanrepublic', 'default', 'Central African Republic ', ''),
('en', 'vocabulary', 'country.chad', 'default', 'Chad ', ''),
('en', 'vocabulary', 'country.chile', 'default', 'Chile ', ''),
('en', 'vocabulary', 'country.china', 'default', 'China ', ''),
('en', 'vocabulary', 'country.christmasisland', 'default', 'Christmas Island ', ''),
('en', 'vocabulary', 'country.cocosislands', 'default', 'Cocos (Keeling) Islands ', ''),
('en', 'vocabulary', 'country.colombia', 'default', 'Colombia ', ''),
('en', 'vocabulary', 'country.comoros', 'default', 'Comoros ', ''),
('en', 'vocabulary', 'country.congo', 'default', 'Congo ', ''),
('en', 'vocabulary', 'country.cookislands', 'default', 'Cook Islands ', ''),
('en', 'vocabulary', 'country.costarica', 'default', 'Costa Rica ', ''),
('en', 'vocabulary', 'country.cotedivoire', 'default', 'Côte d\'Ivoire ', ''),
('en', 'vocabulary', 'country.croatia', 'default', 'Croatia ', ''),
('en', 'vocabulary', 'country.cuba', 'default', 'Cuba ', ''),
('en', 'vocabulary', 'country.curacao', 'default', 'Curaçao ', ''),
('en', 'vocabulary', 'country.cyprus', 'default', 'Cyprus ', ''),
('en', 'vocabulary', 'country.czechrepublic', 'default', 'Czech Republic ', ''),
('en', 'vocabulary', 'country.democraticrepubliccongo', 'default', 'Democratic Republic of the Congo ', ''),
('en', 'vocabulary', 'country.denmark', 'default', 'Denmark ', ''),
('en', 'vocabulary', 'country.djibouti', 'default', 'Djibouti ', ''),
('en', 'vocabulary', 'country.dominica', 'default', 'Dominica ', ''),
('en', 'vocabulary', 'country.dominicanrepublic', 'default', 'Dominican Republic ', ''),
('en', 'vocabulary', 'country.ecuador', 'default', 'Ecuador ', ''),
('en', 'vocabulary', 'country.egypt', 'default', 'Egypt ', ''),
('en', 'vocabulary', 'country.elsalvador', 'default', 'El Salvador ', ''),
('en', 'vocabulary', 'country.equatorialguinea', 'default', 'Equatorial Guinea ', ''),
('en', 'vocabulary', 'country.eritrea', 'default', 'Eritrea ', ''),
('en', 'vocabulary', 'country.estonia', 'default', 'Estonia ', ''),
('en', 'vocabulary', 'country.ethiopia', 'default', 'Ethiopia ', ''),
('en', 'vocabulary', 'country.falklandislands', 'default', 'Falkland Islands', ''),
('en', 'vocabulary', 'country.faroeislands', 'default', 'Faroe Islands ', ''),
('en', 'vocabulary', 'country.fiji', 'default', 'Fiji ', ''),
('en', 'vocabulary', 'country.finland', 'default', 'Finland ', ''),
('en', 'vocabulary', 'country.france', 'default', 'France ', ''),
('en', 'vocabulary', 'country.frenchguiana', 'default', 'French Guiana ', ''),
('en', 'vocabulary', 'country.frenchpolynesia', 'default', 'French Polynesia ', ''),
('en', 'vocabulary', 'country.gabon', 'default', 'Gabon ', ''),
('en', 'vocabulary', 'country.gambia', 'default', 'Gambia ', ''),
('en', 'vocabulary', 'country.georgia', 'default', 'Georgia ', ''),
('en', 'vocabulary', 'country.germany', 'default', 'Germany ', ''),
('en', 'vocabulary', 'country.ghana', 'default', 'Ghana ', ''),
('en', 'vocabulary', 'country.gibraltar', 'default', 'Gibraltar ', ''),
('en', 'vocabulary', 'country.greece', 'default', 'Greece ', ''),
('en', 'vocabulary', 'country.greenland', 'default', 'Greenland ', ''),
('en', 'vocabulary', 'country.grenada', 'default', 'Grenada ', ''),
('en', 'vocabulary', 'country.guadeloupe', 'default', 'Guadeloupe ', ''),
('en', 'vocabulary', 'country.guam', 'default', 'Guam ', ''),
('en', 'vocabulary', 'country.guatemala', 'default', 'Guatemala ', ''),
('en', 'vocabulary', 'country.guernsey', 'default', 'Guernsey ', ''),
('en', 'vocabulary', 'country.guinea', 'default', 'Guinea ', ''),
('en', 'vocabulary', 'country.guinea-bissau', 'default', 'Guinea-Bissau ', ''),
('en', 'vocabulary', 'country.guyana', 'default', 'Guyana ', ''),
('en', 'vocabulary', 'country.haiti', 'default', 'Haiti ', ''),
('en', 'vocabulary', 'country.honduras', 'default', 'Honduras ', ''),
('en', 'vocabulary', 'country.hongkong', 'default', 'Hong Kong ', ''),
('en', 'vocabulary', 'country.hungary', 'default', 'Hungary ', ''),
('en', 'vocabulary', 'country.iceland', 'default', 'Iceland ', ''),
('en', 'vocabulary', 'country.india', 'default', 'India ', ''),
('en', 'vocabulary', 'country.indonesia', 'default', 'Indonesia ', ''),
('en', 'vocabulary', 'country.iran', 'default', 'Iran', ''),
('en', 'vocabulary', 'country.iraq', 'default', 'Iraq ', ''),
('en', 'vocabulary', 'country.ireland', 'default', 'Ireland ', ''),
('en', 'vocabulary', 'country.isleofman', 'default', 'Isle of Man ', ''),
('en', 'vocabulary', 'country.israel', 'default', 'Israel ', ''),
('en', 'vocabulary', 'country.italy', 'default', 'Italy ', ''),
('en', 'vocabulary', 'country.jamaica', 'default', 'Jamaica ', ''),
('en', 'vocabulary', 'country.japan', 'default', 'Japan ', ''),
('en', 'vocabulary', 'country.jersey', 'default', 'Jersey ', ''),
('en', 'vocabulary', 'country.jordan', 'default', 'Jordan ', ''),
('en', 'vocabulary', 'country.kazakhstan', 'default', 'Kazakhstan ', ''),
('en', 'vocabulary', 'country.kenya', 'default', 'Kenya ', ''),
('en', 'vocabulary', 'country.kiribati', 'default', 'Kiribati ', ''),
('en', 'vocabulary', 'country.kuwait', 'default', 'Kuwait ', ''),
('en', 'vocabulary', 'country.kyrgyzstan', 'default', 'Kyrgyzstan ', ''),
('en', 'vocabulary', 'country.lao', 'default', 'Lao', ''),
('en', 'vocabulary', 'country.latvia', 'default', 'Latvia ', ''),
('en', 'vocabulary', 'country.lebanon', 'default', 'Lebanon ', ''),
('en', 'vocabulary', 'country.lesotho', 'default', 'Lesotho ', ''),
('en', 'vocabulary', 'country.liberia', 'default', 'Liberia ', ''),
('en', 'vocabulary', 'country.libya', 'default', 'Libya ', ''),
('en', 'vocabulary', 'country.liechtenstein', 'default', 'Liechtenstein ', ''),
('en', 'vocabulary', 'country.lithuania', 'default', 'Lithuania ', ''),
('en', 'vocabulary', 'country.luxembourg', 'default', 'Luxembourg ', ''),
('en', 'vocabulary', 'country.macao', 'default', 'Macao ', ''),
('en', 'vocabulary', 'country.macedonia', 'default', 'Macedonia', ''),
('en', 'vocabulary', 'country.madagascar', 'default', 'Madagascar ', ''),
('en', 'vocabulary', 'country.malawi', 'default', 'Malawi ', ''),
('en', 'vocabulary', 'country.malaysia', 'default', 'Malaysia ', ''),
('en', 'vocabulary', 'country.maldives', 'default', 'Maldives ', ''),
('en', 'vocabulary', 'country.mali', 'default', 'Mali ', ''),
('en', 'vocabulary', 'country.malta', 'default', 'Malta ', ''),
('en', 'vocabulary', 'country.marshallislands', 'default', 'Marshall Islands ', ''),
('en', 'vocabulary', 'country.martinique', 'default', 'Martinique ', ''),
('en', 'vocabulary', 'country.mauritania', 'default', 'Mauritania ', ''),
('en', 'vocabulary', 'country.mauritius', 'default', 'Mauritius ', ''),
('en', 'vocabulary', 'country.mayotte', 'default', 'Mayotte ', ''),
('en', 'vocabulary', 'country.mexico', 'default', 'Mexico ', ''),
('en', 'vocabulary', 'country.micronesia', 'default', 'Micronesia', ''),
('en', 'vocabulary', 'country.moldova', 'default', 'Moldova', ''),
('en', 'vocabulary', 'country.monaco', 'default', 'Monaco ', ''),
('en', 'vocabulary', 'country.mongolia', 'default', 'Mongolia ', ''),
('en', 'vocabulary', 'country.montenegro', 'default', 'Montenegro ', ''),
('en', 'vocabulary', 'country.montserrat', 'default', 'Montserrat ', ''),
('en', 'vocabulary', 'country.morocco', 'default', 'Morocco ', ''),
('en', 'vocabulary', 'country.mozambique', 'default', 'Mozambique ', ''),
('en', 'vocabulary', 'country.myanmar', 'default', 'Myanmar ', ''),
('en', 'vocabulary', 'country.namibia', 'default', 'Namibia ', ''),
('en', 'vocabulary', 'country.nauru', 'default', 'Nauru ', ''),
('en', 'vocabulary', 'country.nepal', 'default', 'Nepal ', ''),
('en', 'vocabulary', 'country.netherlands', 'default', 'Netherlands ', ''),
('en', 'vocabulary', 'country.newcaledonia', 'default', 'New Caledonia ', ''),
('en', 'vocabulary', 'country.newzealand', 'default', 'New Zealand ', ''),
('en', 'vocabulary', 'country.nicaragua', 'default', 'Nicaragua ', ''),
('en', 'vocabulary', 'country.niger', 'default', 'Niger ', ''),
('en', 'vocabulary', 'country.nigeria', 'default', 'Nigeria ', ''),
('en', 'vocabulary', 'country.niue', 'default', 'Niue ', ''),
('en', 'vocabulary', 'country.norfolkisland', 'default', 'Norfolk Island ', ''),
('en', 'vocabulary', 'country.northernmarianaislands', 'default', 'Northern Mariana Islands ', ''),
('en', 'vocabulary', 'country.northkorea', 'default', 'North Korea', ''),
('en', 'vocabulary', 'country.norway', 'default', 'Norway ', ''),
('en', 'vocabulary', 'country.oman', 'default', 'Oman ', ''),
('en', 'vocabulary', 'country.pakistan', 'default', 'Pakistan ', ''),
('en', 'vocabulary', 'country.palau', 'default', 'Palau ', ''),
('en', 'vocabulary', 'country.palestine', 'default', 'Palestine', ''),
('en', 'vocabulary', 'country.panama', 'default', 'Panama ', ''),
('en', 'vocabulary', 'country.papuanewguinea', 'default', 'Papua New Guinea ', ''),
('en', 'vocabulary', 'country.paraguay', 'default', 'Paraguay ', ''),
('en', 'vocabulary', 'country.peru', 'default', 'Peru ', ''),
('en', 'vocabulary', 'country.philippines', 'default', 'Philippines ', ''),
('en', 'vocabulary', 'country.pitcairn', 'default', 'Pitcairn ', ''),
('en', 'vocabulary', 'country.poland', 'default', 'Poland ', ''),
('en', 'vocabulary', 'country.portugal', 'default', 'Portugal ', ''),
('en', 'vocabulary', 'country.puertorico', 'default', 'Puerto Rico ', ''),
('en', 'vocabulary', 'country.qatar', 'default', 'Qatar ', ''),
('en', 'vocabulary', 'country.reunion', 'default', 'Réunion ', ''),
('en', 'vocabulary', 'country.romania', 'default', 'Romania ', ''),
('en', 'vocabulary', 'country.russia', 'default', 'Russia', ''),
('en', 'vocabulary', 'country.rwanda', 'default', 'Rwanda ', ''),
('en', 'vocabulary', 'country.saintbarthelemy', 'default', 'Saint Barthélemy ', ''),
('en', 'vocabulary', 'country.sainthelena', 'default', 'Saint Helena, Ascension and Tristan da Cunha ', ''),
('en', 'vocabulary', 'country.saintkitts', 'default', 'Saint Kitts and Nevis ', ''),
('en', 'vocabulary', 'country.saintlucia', 'default', 'Saint Lucia ', ''),
('en', 'vocabulary', 'country.saintmartin', 'default', 'Saint Martin', ''),
('en', 'vocabulary', 'country.saintpierremiquelon', 'default', 'Saint Pierre and Miquelon ', ''),
('en', 'vocabulary', 'country.saintvincent', 'default', 'Saint Vincent and the Grenadines ', ''),
('en', 'vocabulary', 'country.samoa', 'default', 'Samoa ', ''),
('en', 'vocabulary', 'country.sanmarino', 'default', 'San Marino ', ''),
('en', 'vocabulary', 'country.saotome', 'default', 'Sao Tome and Principe ', ''),
('en', 'vocabulary', 'country.saudiarabia', 'default', 'Saudi Arabia ', ''),
('en', 'vocabulary', 'country.senegal', 'default', 'Senegal ', ''),
('en', 'vocabulary', 'country.serbia', 'default', 'Serbia ', ''),
('en', 'vocabulary', 'country.seychelles', 'default', 'Seychelles ', ''),
('en', 'vocabulary', 'country.sierraleone', 'default', 'Sierra Leone ', ''),
('en', 'vocabulary', 'country.singapore', 'default', 'Singapore ', ''),
('en', 'vocabulary', 'country.sintmaarten', 'default', 'Sint Maarten', ''),
('en', 'vocabulary', 'country.slovakia', 'default', 'Slovakia ', ''),
('en', 'vocabulary', 'country.slovenia', 'default', 'Slovenia ', ''),
('en', 'vocabulary', 'country.solomonislands', 'default', 'Solomon Islands ', ''),
('en', 'vocabulary', 'country.somalia', 'default', 'Somalia ', ''),
('en', 'vocabulary', 'country.southafrica', 'default', 'South Africa ', ''),
('en', 'vocabulary', 'country.southgeorgia', 'default', 'South Georgia and the South Sandwich Islands ', ''),
('en', 'vocabulary', 'country.southkorea', 'default', 'South Korea', ''),
('en', 'vocabulary', 'country.southsudan', 'default', 'South Sudan ', ''),
('en', 'vocabulary', 'country.spain', 'default', 'Spain ', ''),
('en', 'vocabulary', 'country.srilanka', 'default', 'Sri Lanka ', ''),
('en', 'vocabulary', 'country.sudan', 'default', 'Sudan ', ''),
('en', 'vocabulary', 'country.suriname', 'default', 'Suriname ', ''),
('en', 'vocabulary', 'country.svalbard', 'default', 'Svalbard and Jan Mayen ', ''),
('en', 'vocabulary', 'country.swaziland', 'default', 'Swaziland ', ''),
('en', 'vocabulary', 'country.sweden', 'default', 'Sweden ', ''),
('en', 'vocabulary', 'country.switzerland', 'default', 'Switzerland ', ''),
('en', 'vocabulary', 'country.syria', 'default', 'Syrian Arab Republic ', ''),
('en', 'vocabulary', 'country.taiwan', 'default', 'Taiwan', ''),
('en', 'vocabulary', 'country.tajikistan', 'default', 'Tajikistan ', ''),
('en', 'vocabulary', 'country.tanzania', 'default', 'Tanzania', ''),
('en', 'vocabulary', 'country.thailand', 'default', 'Thailand ', ''),
('en', 'vocabulary', 'country.timorleste', 'default', 'Timor-Leste ', ''),
('en', 'vocabulary', 'country.togo', 'default', 'Togo ', ''),
('en', 'vocabulary', 'country.tokelau', 'default', 'Tokelau ', ''),
('en', 'vocabulary', 'country.tonga', 'default', 'Tonga ', ''),
('en', 'vocabulary', 'country.trinidadtobago', 'default', 'Trinidad and Tobago ', ''),
('en', 'vocabulary', 'country.tunisia', 'default', 'Tunisia ', ''),
('en', 'vocabulary', 'country.turkey', 'default', 'Turkey ', ''),
('en', 'vocabulary', 'country.turkmenistan', 'default', 'Turkmenistan ', ''),
('en', 'vocabulary', 'country.turkscaicos', 'default', 'Turks and Caicos Islands ', ''),
('en', 'vocabulary', 'country.tuvalu', 'default', 'Tuvalu ', ''),
('en', 'vocabulary', 'country.uganda', 'default', 'Uganda ', ''),
('en', 'vocabulary', 'country.ukraine', 'default', 'Ukraine ', ''),
('en', 'vocabulary', 'country.unitedarabemirates', 'default', 'United Arab Emirates ', ''),
('en', 'vocabulary', 'country.unitedkingdom', 'default', 'United Kingdom', ''),
('en', 'vocabulary', 'country.unitedstatesamerica', 'default', 'United States of America ', ''),
('en', 'vocabulary', 'country.uruguay', 'default', 'Uruguay ', ''),
('en', 'vocabulary', 'country.usvirginislands', 'default', 'US Virgin Islands', ''),
('en', 'vocabulary', 'country.uzbekistan', 'default', 'Uzbekistan ', ''),
('en', 'vocabulary', 'country.vanuatu', 'default', 'Vanuatu ', ''),
('en', 'vocabulary', 'country.vatican', 'default', 'Holy See ', ''),
('en', 'vocabulary', 'country.venezuela', 'default', 'Venezuela', ''),
('en', 'vocabulary', 'country.vietnam', 'default', 'Viet Nam ', ''),
('en', 'vocabulary', 'country.wallisfutuna', 'default', 'Wallis and Futuna ', ''),
('en', 'vocabulary', 'country.westernsahara', 'default', 'Western Sahara ', ''),
('en', 'vocabulary', 'country.yemen', 'default', 'Yemen ', ''),
('en', 'vocabulary', 'country.zambia', 'default', 'Zambia ', ''),
('en', 'vocabulary', 'country.zimbabwe', 'default', 'Zimbabwe ', ''),
('en', 'vocabulary', 'crs.wgs84', 'default', 'crs.wgs84', ''),
('en', 'vocabulary', 'language.abkhazian', 'default', 'Abkhazian', ''),
('en', 'vocabulary', 'language.achinese', 'default', 'Achinese', ''),
('en', 'vocabulary', 'language.acoli', 'default', 'Acoli', ''),
('en', 'vocabulary', 'language.adangme', 'default', 'Adangme', ''),
('en', 'vocabulary', 'language.adyghe', 'default', 'Adyghe', ''),
('en', 'vocabulary', 'language.afar', 'default', 'Afar', ''),
('en', 'vocabulary', 'language.afrihili', 'default', 'Afrihili', ''),
('en', 'vocabulary', 'language.afrikaans', 'default', 'Afrikaans', ''),
('en', 'vocabulary', 'language.aghem', 'default', 'Aghem', ''),
('en', 'vocabulary', 'language.ainu', 'default', 'Ainu', ''),
('en', 'vocabulary', 'language.akan', 'default', 'Akan', ''),
('en', 'vocabulary', 'language.akkadian', 'default', 'Akkadian', ''),
('en', 'vocabulary', 'language.akoose', 'default', 'Akoose', ''),
('en', 'vocabulary', 'language.alabama', 'default', 'Alabama', ''),
('en', 'vocabulary', 'language.albanian', 'default', 'Albanian', ''),
('en', 'vocabulary', 'language.albanian.gheg', 'default', 'Gheg Albanian', ''),
('en', 'vocabulary', 'language.aleut', 'default', 'Aleut', ''),
('en', 'vocabulary', 'language.altai.southern', 'default', 'Southern Altai', ''),
('en', 'vocabulary', 'language.amharic', 'default', 'Amharic', ''),
('en', 'vocabulary', 'language.angika', 'default', 'Angika', ''),
('en', 'vocabulary', 'language.aonaga', 'default', 'Ao Naga', ''),
('en', 'vocabulary', 'language.arabic', 'default', 'Arabic', ''),
('en', 'vocabulary', 'language.arabic.algerian', 'default', 'Algerian Arabic', ''),
('en', 'vocabulary', 'language.arabic.chadian', 'default', 'Chadian Arabic', ''),
('en', 'vocabulary', 'language.arabic.egyptian', 'default', 'Egyptian Arabic', ''),
('en', 'vocabulary', 'language.arabic.modern', 'default', 'Modern Standard Arabic', ''),
('en', 'vocabulary', 'language.arabic.moroccan', 'default', 'Moroccan Arabic', ''),
('en', 'vocabulary', 'language.arabic.tunisian', 'default', 'Tunisian Arabic', ''),
('en', 'vocabulary', 'language.aragonese', 'default', 'Aragonese', ''),
('en', 'vocabulary', 'language.aramaic', 'default', 'Aramaic', ''),
('en', 'vocabulary', 'language.aramaic.samaritan', 'default', 'Samaritan Aramaic', ''),
('en', 'vocabulary', 'language.araona', 'default', 'Araona', ''),
('en', 'vocabulary', 'language.arapaho', 'default', 'Arapaho', ''),
('en', 'vocabulary', 'language.arawak', 'default', 'Arawak', ''),
('en', 'vocabulary', 'language.armenian', 'default', 'Armenian', ''),
('en', 'vocabulary', 'language.aromanian', 'default', 'Aromanian', ''),
('en', 'vocabulary', 'language.arpitan', 'default', 'Arpitan', ''),
('en', 'vocabulary', 'language.assamese', 'default', 'Assamese', ''),
('en', 'vocabulary', 'language.asturian', 'default', 'Asturian', ''),
('en', 'vocabulary', 'language.asu', 'default', 'Asu', ''),
('en', 'vocabulary', 'language.atsam', 'default', 'Atsam', ''),
('en', 'vocabulary', 'language.avaric', 'default', 'Avaric', ''),
('en', 'vocabulary', 'language.avestan', 'default', 'Avestan', ''),
('en', 'vocabulary', 'language.awadhi', 'default', 'Awadhi', ''),
('en', 'vocabulary', 'language.aymara', 'default', 'Aymara', ''),
('en', 'vocabulary', 'language.azerbaijani', 'default', 'Azerbaijani', ''),
('en', 'vocabulary', 'language.badaga', 'default', 'Badaga', ''),
('en', 'vocabulary', 'language.bafia', 'default', 'Bafia', ''),
('en', 'vocabulary', 'language.bafut', 'default', 'Bafut', ''),
('en', 'vocabulary', 'language.bakhtiari', 'default', 'Bakhtiari', ''),
('en', 'vocabulary', 'language.balinese', 'default', 'Balinese', ''),
('en', 'vocabulary', 'language.balochi.western', 'default', 'Western Balochi', ''),
('en', 'vocabulary', 'language.baluchi', 'default', 'Baluchi', ''),
('en', 'vocabulary', 'language.bambara', 'default', 'Bambara', ''),
('en', 'vocabulary', 'language.bamun', 'default', 'Bamun', ''),
('en', 'vocabulary', 'language.banjar', 'default', 'Banjar', ''),
('en', 'vocabulary', 'language.basaa', 'default', 'Basaa', ''),
('en', 'vocabulary', 'language.bashkir', 'default', 'Bashkir', ''),
('en', 'vocabulary', 'language.basque', 'default', 'Basque', ''),
('en', 'vocabulary', 'language.bataktoba', 'default', 'Batak Toba', ''),
('en', 'vocabulary', 'language.bavarian', 'default', 'Bavarian', ''),
('en', 'vocabulary', 'language.beja', 'default', 'Beja', ''),
('en', 'vocabulary', 'language.belarusian', 'default', 'Belarusian', ''),
('en', 'vocabulary', 'language.bemba', 'default', 'Bemba', ''),
('en', 'vocabulary', 'language.bena', 'default', 'Bena', ''),
('en', 'vocabulary', 'language.bengali', 'default', 'Bengali', ''),
('en', 'vocabulary', 'language.betawi', 'default', 'Betawi', ''),
('en', 'vocabulary', 'language.bhojpuri', 'default', 'Bhojpuri', ''),
('en', 'vocabulary', 'language.bikol', 'default', 'Bikol', ''),
('en', 'vocabulary', 'language.bini', 'default', 'Bini', ''),
('en', 'vocabulary', 'language.bishnupriya', 'default', 'Bishnupriya', ''),
('en', 'vocabulary', 'language.bislama', 'default', 'Bislama', ''),
('en', 'vocabulary', 'language.blin', 'default', 'Blin', ''),
('en', 'vocabulary', 'language.blissymbols', 'default', 'Blissymbols', ''),
('en', 'vocabulary', 'language.bodo', 'default', 'Bodo', ''),
('en', 'vocabulary', 'language.bosnian', 'default', 'Bosnian', ''),
('en', 'vocabulary', 'language.brahui', 'default', 'Brahui', ''),
('en', 'vocabulary', 'language.braj', 'default', 'Braj', ''),
('en', 'vocabulary', 'language.breton', 'default', 'Breton', ''),
('en', 'vocabulary', 'language.buginese', 'default', 'Buginese', ''),
('en', 'vocabulary', 'language.bulgarian', 'default', 'Bulgarian', ''),
('en', 'vocabulary', 'language.bulu', 'default', 'Bulu', ''),
('en', 'vocabulary', 'language.buriat', 'default', 'Buriat', ''),
('en', 'vocabulary', 'language.burmese', 'default', 'Burmese', ''),
('en', 'vocabulary', 'language.caddo', 'default', 'Caddo', ''),
('en', 'vocabulary', 'language.cantonese', 'default', 'Cantonese', ''),
('en', 'vocabulary', 'language.capiznon', 'default', 'Capiznon', ''),
('en', 'vocabulary', 'language.carib', 'default', 'Carib', ''),
('en', 'vocabulary', 'language.catalan', 'default', 'Catalan', ''),
('en', 'vocabulary', 'language.cayuga', 'default', 'Cayuga', ''),
('en', 'vocabulary', 'language.cebuano', 'default', 'Cebuano', ''),
('en', 'vocabulary', 'language.chagatai', 'default', 'Chagatai', ''),
('en', 'vocabulary', 'language.chamorro', 'default', 'Chamorro', ''),
('en', 'vocabulary', 'language.chechen', 'default', 'Chechen', ''),
('en', 'vocabulary', 'language.cherokee', 'default', 'Cherokee', ''),
('en', 'vocabulary', 'language.cheyenne', 'default', 'Cheyenne', ''),
('en', 'vocabulary', 'language.chibcha', 'default', 'Chibcha', ''),
('en', 'vocabulary', 'language.chiga', 'default', 'Chiga', ''),
('en', 'vocabulary', 'language.chiini.koyra', 'default', 'Koyra Chiini', ''),
('en', 'vocabulary', 'language.chinese', 'default', 'Chinese', ''),
('en', 'vocabulary', 'language.chinese.gan', 'default', 'Gan Chinese', ''),
('en', 'vocabulary', 'language.chinese.hakka', 'default', 'Hakka Chinese', ''),
('en', 'vocabulary', 'language.chinese.literary', 'default', 'Literary Chinese', ''),
('en', 'vocabulary', 'language.chinese.minnan', 'default', 'Min Nan Chinese', ''),
('en', 'vocabulary', 'language.chinese.simplified', 'default', 'Simplified Chinese', ''),
('en', 'vocabulary', 'language.chinese.traditional', 'default', 'Traditional Chinese', ''),
('en', 'vocabulary', 'language.chinese.wu', 'default', 'Wu Chinese', ''),
('en', 'vocabulary', 'language.chinese.xiang', 'default', 'Xiang Chinese', ''),
('en', 'vocabulary', 'language.chipewyan', 'default', 'Chipewyan', ''),
('en', 'vocabulary', 'language.choctaw', 'default', 'Choctaw', ''),
('en', 'vocabulary', 'language.chuukese', 'default', 'Chuukese', ''),
('en', 'vocabulary', 'language.chuvash', 'default', 'Chuvash', ''),
('en', 'vocabulary', 'language.colognian', 'default', 'Colognian', ''),
('en', 'vocabulary', 'language.comorian', 'default', 'Comorian', ''),
('en', 'vocabulary', 'language.coptic', 'default', 'Coptic', ''),
('en', 'vocabulary', 'language.cornish', 'default', 'Cornish', ''),
('en', 'vocabulary', 'language.corsican', 'default', 'Corsican', ''),
('en', 'vocabulary', 'language.cree', 'default', 'Cree', ''),
('en', 'vocabulary', 'language.creek', 'default', 'Creek', ''),
('en', 'vocabulary', 'language.creole.haitian', 'default', 'Haitian Creole', ''),
('en', 'vocabulary', 'language.croatian', 'default', 'Croatian', ''),
('en', 'vocabulary', 'language.czech', 'default', 'Czech', ''),
('en', 'vocabulary', 'language.dakota', 'default', 'Dakota', ''),
('en', 'vocabulary', 'language.danish', 'default', 'Danish', ''),
('en', 'vocabulary', 'language.dargwa', 'default', 'Dargwa', ''),
('en', 'vocabulary', 'language.dari.zoroastrian', 'default', 'Zoroastrian Dari', ''),
('en', 'vocabulary', 'language.dazaga', 'default', 'Dazaga', ''),
('en', 'vocabulary', 'language.delaware', 'default', 'Delaware', ''),
('en', 'vocabulary', 'language.dinka', 'default', 'Dinka', ''),
('en', 'vocabulary', 'language.divehi', 'default', 'Divehi', ''),
('en', 'vocabulary', 'language.dogri', 'default', 'Dogri', ''),
('en', 'vocabulary', 'language.dogrib', 'default', 'Dogrib', ''),
('en', 'vocabulary', 'language.duala', 'default', 'Duala', ''),
('en', 'vocabulary', 'language.dusun.central', 'default', 'Central Dusun', ''),
('en', 'vocabulary', 'language.dutch', 'default', 'Dutch', ''),
('en', 'vocabulary', 'language.dutch.middle', 'default', 'Middle Dutch', ''),
('en', 'vocabulary', 'language.dyula', 'default', 'Dyula', ''),
('en', 'vocabulary', 'language.dzongkha', 'default', 'Dzongkha', ''),
('en', 'vocabulary', 'language.efik', 'default', 'Efik', ''),
('en', 'vocabulary', 'language.egyptian.ancient', 'default', 'Ancient Egyptian', ''),
('en', 'vocabulary', 'language.ekajuk', 'default', 'Ekajuk', ''),
('en', 'vocabulary', 'language.elamite', 'default', 'Elamite', ''),
('en', 'vocabulary', 'language.embu', 'default', 'Embu', ''),
('en', 'vocabulary', 'language.emilian', 'default', 'Emilian', ''),
('en', 'vocabulary', 'language.english', 'default', 'English', ''),
('en', 'vocabulary', 'language.english.american', 'default', 'American English', ''),
('en', 'vocabulary', 'language.english.australian', 'default', 'Australian English', ''),
('en', 'vocabulary', 'language.english.british', 'default', 'British English', ''),
('en', 'vocabulary', 'language.english.canadian', 'default', 'Canadian English', ''),
('en', 'vocabulary', 'language.english.jamaicancreole ', 'default', 'Jamaican Creole English', ''),
('en', 'vocabulary', 'language.english.middle', 'default', 'Middle English', ''),
('en', 'vocabulary', 'language.english.old', 'default', 'Old English', ''),
('en', 'vocabulary', 'language.erzya', 'default', 'Erzya', ''),
('en', 'vocabulary', 'language.esperanto', 'default', 'Esperanto', ''),
('en', 'vocabulary', 'language.estonian', 'default', 'Estonian', ''),
('en', 'vocabulary', 'language.ewe', 'default', 'Ewe', ''),
('en', 'vocabulary', 'language.ewondo', 'default', 'Ewondo', ''),
('en', 'vocabulary', 'language.extremaduran', 'default', 'Extremaduran', ''),
('en', 'vocabulary', 'language.fang', 'default', 'Fang', ''),
('en', 'vocabulary', 'language.fanti', 'default', 'Fanti', ''),
('en', 'vocabulary', 'language.faroese', 'default', 'Faroese', ''),
('en', 'vocabulary', 'language.fijian', 'default', 'Fijian', ''),
('en', 'vocabulary', 'language.filipino', 'default', 'Filipino', ''),
('en', 'vocabulary', 'language.finnish', 'default', 'Finnish', ''),
('en', 'vocabulary', 'language.finnish.tornedalen', 'default', 'Tornedalen Finnish', ''),
('en', 'vocabulary', 'language.flemish', 'default', 'Flemish', ''),
('en', 'vocabulary', 'language.flemish.west', 'default', 'West Flemish', ''),
('en', 'vocabulary', 'language.fon', 'default', 'Fon', ''),
('en', 'vocabulary', 'language.frafra', 'default', 'Frafra', ''),
('en', 'vocabulary', 'language.franconian.main', 'default', 'Main-Franconian', ''),
('en', 'vocabulary', 'language.french', 'default', 'French', ''),
('en', 'vocabulary', 'language.french.cajun', 'default', 'Cajun French', ''),
('en', 'vocabulary', 'language.french.canadian', 'default', 'Canadian French', ''),
('en', 'vocabulary', 'language.french.middle', 'default', 'Middle French', ''),
('en', 'vocabulary', 'language.french.old', 'default', 'Old French', ''),
('en', 'vocabulary', 'language.french.swiss', 'default', 'Swiss French', ''),
('en', 'vocabulary', 'language.frisian.eastern', 'default', 'Eastern Frisian', ''),
('en', 'vocabulary', 'language.frisian.northern', 'default', 'Northern Frisian', ''),
('en', 'vocabulary', 'language.frisian.saterland', 'default', 'Saterland Frisian', ''),
('en', 'vocabulary', 'language.frisian.western', 'default', 'Western Frisian', ''),
('en', 'vocabulary', 'language.friulian', 'default', 'Friulian', ''),
('en', 'vocabulary', 'language.fulah', 'default', 'Fulah', ''),
('en', 'vocabulary', 'language.ga', 'default', 'Ga', ''),
('en', 'vocabulary', 'language.gaelic.scottish', 'default', 'Scottish Gaelic', ''),
('en', 'vocabulary', 'language.gagauz', 'default', 'Gagauz', ''),
('en', 'vocabulary', 'language.galician', 'default', 'Galician', ''),
('en', 'vocabulary', 'language.ganda', 'default', 'Ganda', ''),
('en', 'vocabulary', 'language.gayo', 'default', 'Gayo', ''),
('en', 'vocabulary', 'language.gbaya', 'default', 'Gbaya', ''),
('en', 'vocabulary', 'language.geez', 'default', 'Geez', ''),
('en', 'vocabulary', 'language.georgian', 'default', 'Georgian', ''),
('en', 'vocabulary', 'language.german', 'default', 'German', ''),
('en', 'vocabulary', 'language.german.austrian', 'default', 'Austrian German', ''),
('en', 'vocabulary', 'language.german.low', 'default', 'Low German', ''),
('en', 'vocabulary', 'language.german.middlehigh', 'default', 'Middle High German', ''),
('en', 'vocabulary', 'language.german.oldhigh', 'default', 'Old High German', ''),
('en', 'vocabulary', 'language.german.palatine', 'default', 'Palatine German', ''),
('en', 'vocabulary', 'language.german.pennsylvania', 'default', 'Pennsylvania German', ''),
('en', 'vocabulary', 'language.german.swiss', 'default', 'Swiss German', ''),
('en', 'vocabulary', 'language.german.swisshigh', 'default', 'Swiss High German', ''),
('en', 'vocabulary', 'language.ghomala', 'default', 'Ghomala', ''),
('en', 'vocabulary', 'language.gilaki', 'default', 'Gilaki', ''),
('en', 'vocabulary', 'language.gilbertese', 'default', 'Gilbertese', ''),
('en', 'vocabulary', 'language.gondi', 'default', 'Gondi', ''),
('en', 'vocabulary', 'language.gorontalo', 'default', 'Gorontalo', ''),
('en', 'vocabulary', 'language.gothic', 'default', 'Gothic', ''),
('en', 'vocabulary', 'language.grebo', 'default', 'Grebo', ''),
('en', 'vocabulary', 'language.greek', 'default', 'Greek', ''),
('en', 'vocabulary', 'language.greek.ancient', 'default', 'Ancient Greek', ''),
('en', 'vocabulary', 'language.guarani', 'default', 'Guarani', ''),
('en', 'vocabulary', 'language.gujarati', 'default', 'Gujarati', ''),
('en', 'vocabulary', 'language.gusii', 'default', 'Gusii', ''),
('en', 'vocabulary', 'language.gwichin', 'default', 'Gwichʼin', ''),
('en', 'vocabulary', 'language.haida', 'default', 'Haida', ''),
('en', 'vocabulary', 'language.hausa', 'default', 'Hausa', ''),
('en', 'vocabulary', 'language.hawaiian', 'default', 'Hawaiian', ''),
('en', 'vocabulary', 'language.hebrew', 'default', 'Hebrew', ''),
('en', 'vocabulary', 'language.herero', 'default', 'Herero', ''),
('en', 'vocabulary', 'language.hiligaynon', 'default', 'Hiligaynon', ''),
('en', 'vocabulary', 'language.hindi', 'default', 'Hindi', ''),
('en', 'vocabulary', 'language.hindi.fiji', 'default', 'Fiji Hindi', ''),
('en', 'vocabulary', 'language.hittite', 'default', 'Hittite', ''),
('en', 'vocabulary', 'language.hmong', 'default', 'Hmong', ''),
('en', 'vocabulary', 'language.hungarian', 'default', 'Hungarian', ''),
('en', 'vocabulary', 'language.hupa', 'default', 'Hupa', ''),
('en', 'vocabulary', 'language.iban', 'default', 'Iban', ''),
('en', 'vocabulary', 'language.ibibio', 'default', 'Ibibio', ''),
('en', 'vocabulary', 'language.icelandic', 'default', 'Icelandic', ''),
('en', 'vocabulary', 'language.ido', 'default', 'Ido', ''),
('en', 'vocabulary', 'language.igbo', 'default', 'Igbo', ''),
('en', 'vocabulary', 'language.iloko', 'default', 'Iloko', ''),
('en', 'vocabulary', 'language.indonesian', 'default', 'Indonesian', ''),
('en', 'vocabulary', 'language.ingrian', 'default', 'Ingrian', ''),
('en', 'vocabulary', 'language.ingush', 'default', 'Ingush', ''),
('en', 'vocabulary', 'language.interlingua', 'default', 'Interlingua', ''),
('en', 'vocabulary', 'language.interlingue', 'default', 'Interlingue', ''),
('en', 'vocabulary', 'language.inuktitut', 'default', 'Inuktitut', ''),
('en', 'vocabulary', 'language.inupiaq', 'default', 'Inupiaq', ''),
('en', 'vocabulary', 'language.irish', 'default', 'Irish', ''),
('en', 'vocabulary', 'language.irish.middle', 'default', 'Middle Irish', ''),
('en', 'vocabulary', 'language.irish.old', 'default', 'Old Irish', ''),
('en', 'vocabulary', 'language.italian', 'default', 'Italian', ''),
('en', 'vocabulary', 'language.japanese', 'default', 'Japanese', ''),
('en', 'vocabulary', 'language.jargon.chinook', 'default', 'Chinook Jargon', ''),
('en', 'vocabulary', 'language.javanese', 'default', 'Javanese', ''),
('en', 'vocabulary', 'language.jju', 'default', 'Jju', ''),
('en', 'vocabulary', 'language.jolafonyi', 'default', 'Jola-Fonyi', ''),
('en', 'vocabulary', 'language.judeoarabic', 'default', 'Judeo-Arabic', ''),
('en', 'vocabulary', 'language.judeopersian', 'default', 'Judeo-Persian', ''),
('en', 'vocabulary', 'language.jutish', 'default', 'Jutish', ''),
('en', 'vocabulary', 'language.kabardian', 'default', 'Kabardian', ''),
('en', 'vocabulary', 'language.kabuverdianu', 'default', 'Kabuverdianu', ''),
('en', 'vocabulary', 'language.kabyle', 'default', 'Kabyle', ''),
('en', 'vocabulary', 'language.kachin', 'default', 'Kachin', ''),
('en', 'vocabulary', 'language.kaingang', 'default', 'Kaingang', ''),
('en', 'vocabulary', 'language.kako', 'default', 'Kako', ''),
('en', 'vocabulary', 'language.kalaallisut', 'default', 'Kalaallisut', ''),
('en', 'vocabulary', 'language.kalenjin', 'default', 'Kalenjin', ''),
('en', 'vocabulary', 'language.kalmyk', 'default', 'Kalmyk', ''),
('en', 'vocabulary', 'language.kamba', 'default', 'Kamba', ''),
('en', 'vocabulary', 'language.kanembu', 'default', 'Kanembu', ''),
('en', 'vocabulary', 'language.kannada', 'default', 'Kannada', ''),
('en', 'vocabulary', 'language.kanuri', 'default', 'Kanuri', ''),
('en', 'vocabulary', 'language.karachaybalkar', 'default', 'Karachay-Balkar', ''),
('en', 'vocabulary', 'language.karakalpak', 'default', 'Kara-Kalpak', ''),
('en', 'vocabulary', 'language.karelian', 'default', 'Karelian', ''),
('en', 'vocabulary', 'language.kashmiri', 'default', 'Kashmiri', ''),
('en', 'vocabulary', 'language.kashubian', 'default', 'Kashubian', ''),
('en', 'vocabulary', 'language.kawi', 'default', 'Kawi', ''),
('en', 'vocabulary', 'language.kazakh', 'default', 'Kazakh', ''),
('en', 'vocabulary', 'language.kenyang', 'default', 'Kenyang', ''),
('en', 'vocabulary', 'language.khasi', 'default', 'Khasi', ''),
('en', 'vocabulary', 'language.khmer', 'default', 'Khmer', ''),
('en', 'vocabulary', 'language.khotanese', 'default', 'Khotanese', ''),
('en', 'vocabulary', 'language.khowar', 'default', 'Khowar', ''),
('en', 'vocabulary', 'language.kiche', 'default', 'Kʼicheʼ', ''),
('en', 'vocabulary', 'language.kikuyu', 'default', 'Kikuyu', ''),
('en', 'vocabulary', 'language.kimbundu', 'default', 'Kimbundu', ''),
('en', 'vocabulary', 'language.kinaraya', 'default', 'Kinaray-a', ''),
('en', 'vocabulary', 'language.kinyarwanda', 'default', 'Kinyarwanda', ''),
('en', 'vocabulary', 'language.kirmanjki', 'default', 'Kirmanjki', ''),
('en', 'vocabulary', 'language.klingon', 'default', 'Klingon', ''),
('en', 'vocabulary', 'language.kom', 'default', 'Kom', ''),
('en', 'vocabulary', 'language.komi', 'default', 'Komi', ''),
('en', 'vocabulary', 'language.komi.permyak', 'default', 'Komi-Permyak', ''),
('en', 'vocabulary', 'language.kongo', 'default', 'Kongo', ''),
('en', 'vocabulary', 'language.konkani', 'default', 'Konkani', ''),
('en', 'vocabulary', 'language.konkani.goan', 'default', 'Goan Konkani', ''),
('en', 'vocabulary', 'language.korean', 'default', 'Korean', ''),
('en', 'vocabulary', 'language.koro', 'default', 'Koro', ''),
('en', 'vocabulary', 'language.kosraean', 'default', 'Kosraean', ''),
('en', 'vocabulary', 'language.kotava', 'default', 'Kotava', ''),
('en', 'vocabulary', 'language.kpelle', 'default', 'Kpelle', ''),
('en', 'vocabulary', 'language.krio', 'default', 'Krio', ''),
('en', 'vocabulary', 'language.kuanyama', 'default', 'Kuanyama', ''),
('en', 'vocabulary', 'language.kumyk', 'default', 'Kumyk', ''),
('en', 'vocabulary', 'language.kurdish', 'default', 'Kurdish', ''),
('en', 'vocabulary', 'language.kurdish.central', 'default', 'Central Kurdish', ''),
('en', 'vocabulary', 'language.kurukh', 'default', 'Kurukh', ''),
('en', 'vocabulary', 'language.kutenai', 'default', 'Kutenai', ''),
('en', 'vocabulary', 'language.kwasio', 'default', 'Kwasio', ''),
('en', 'vocabulary', 'language.kyrgyz', 'default', 'Kyrgyz', ''),
('en', 'vocabulary', 'language.ladino', 'default', 'Ladino', ''),
('en', 'vocabulary', 'language.lahnda', 'default', 'Lahnda', ''),
('en', 'vocabulary', 'language.lakota', 'default', 'Lakota', ''),
('en', 'vocabulary', 'language.lamba', 'default', 'Lamba', ''),
('en', 'vocabulary', 'language.langi', 'default', 'Langi', ''),
('en', 'vocabulary', 'language.lao', 'default', 'Lao', ''),
('en', 'vocabulary', 'language.latgalian', 'default', 'Latgalian', ''),
('en', 'vocabulary', 'language.latin', 'default', 'Latin', ''),
('en', 'vocabulary', 'language.latvian', 'default', 'Latvian', ''),
('en', 'vocabulary', 'language.laz', 'default', 'Laz', ''),
('en', 'vocabulary', 'language.lezghian', 'default', 'Lezghian', ''),
('en', 'vocabulary', 'language.ligurian', 'default', 'Ligurian', ''),
('en', 'vocabulary', 'language.limburgish', 'default', 'Limburgish', ''),
('en', 'vocabulary', 'language.lingala', 'default', 'Lingala', ''),
('en', 'vocabulary', 'language.linguafranca.nova', 'default', 'Lingua Franca Nova', ''),
('en', 'vocabulary', 'language.lithuanian', 'default', 'Lithuanian', ''),
('en', 'vocabulary', 'language.livonian', 'default', 'Livonian', ''),
('en', 'vocabulary', 'language.lojban', 'default', 'Lojban', ''),
('en', 'vocabulary', 'language.lombard', 'default', 'Lombard', ''),
('en', 'vocabulary', 'language.lozi', 'default', 'Lozi', ''),
('en', 'vocabulary', 'language.luba.katanga', 'default', 'Luba-Katanga', ''),
('en', 'vocabulary', 'language.luba.lulua', 'default', 'Luba-Lulua', ''),
('en', 'vocabulary', 'language.luiseno', 'default', 'Luiseno', ''),
('en', 'vocabulary', 'language.lunda', 'default', 'Lunda', ''),
('en', 'vocabulary', 'language.luo', 'default', 'Luo', ''),
('en', 'vocabulary', 'language.luri.northern', 'default', 'Northern Luri', ''),
('en', 'vocabulary', 'language.luxembourgish', 'default', 'Luxembourgish', ''),
('en', 'vocabulary', 'language.luyia', 'default', 'Luyia', ''),
('en', 'vocabulary', 'language.maba', 'default', 'Maba', ''),
('en', 'vocabulary', 'language.macedonian', 'default', 'Macedonian', ''),
('en', 'vocabulary', 'language.machame', 'default', 'Machame', ''),
('en', 'vocabulary', 'language.madurese', 'default', 'Madurese', ''),
('en', 'vocabulary', 'language.mafa', 'default', 'Mafa', ''),
('en', 'vocabulary', 'language.magahi', 'default', 'Magahi', ''),
('en', 'vocabulary', 'language.maithili', 'default', 'Maithili', ''),
('en', 'vocabulary', 'language.makasar', 'default', 'Makasar', ''),
('en', 'vocabulary', 'language.makhuwameetto', 'default', 'Makhuwa-Meetto', ''),
('en', 'vocabulary', 'language.makonde', 'default', 'Makonde', ''),
('en', 'vocabulary', 'language.malagasy', 'default', 'Malagasy', ''),
('en', 'vocabulary', 'language.malay', 'default', 'Malay', ''),
('en', 'vocabulary', 'language.malayalam', 'default', 'Malayalam', ''),
('en', 'vocabulary', 'language.maltese', 'default', 'Maltese', ''),
('en', 'vocabulary', 'language.manchu', 'default', 'Manchu', ''),
('en', 'vocabulary', 'language.mandar', 'default', 'Mandar', ''),
('en', 'vocabulary', 'language.mandingo', 'default', 'Mandingo', ''),
('en', 'vocabulary', 'language.manipuri', 'default', 'Manipuri', ''),
('en', 'vocabulary', 'language.manx', 'default', 'Manx', ''),
('en', 'vocabulary', 'language.maori', 'default', 'Maori', ''),
('en', 'vocabulary', 'language.mapuche', 'default', 'Mapuche', ''),
('en', 'vocabulary', 'language.marathi', 'default', 'Marathi', ''),
('en', 'vocabulary', 'language.mari', 'default', 'Mari', ''),
('en', 'vocabulary', 'language.mari.western', 'default', 'Western Mari', ''),
('en', 'vocabulary', 'language.marshallese', 'default', 'Marshallese', ''),
('en', 'vocabulary', 'language.marwari', 'default', 'Marwari', ''),
('en', 'vocabulary', 'language.masai', 'default', 'Masai', ''),
('en', 'vocabulary', 'language.mazanderani', 'default', 'Mazanderani', ''),
('en', 'vocabulary', 'language.medumba', 'default', 'Medumba', ''),
('en', 'vocabulary', 'language.mende', 'default', 'Mende', ''),
('en', 'vocabulary', 'language.mentawai', 'default', 'Mentawai', ''),
('en', 'vocabulary', 'language.meru', 'default', 'Meru', ''),
('en', 'vocabulary', 'language.meta', 'default', 'Meta', ''),
('en', 'vocabulary', 'language.micmac', 'default', 'Micmac', ''),
('en', 'vocabulary', 'language.minangkabau', 'default', 'Minangkabau', ''),
('en', 'vocabulary', 'language.mingrelian', 'default', 'Mingrelian', ''),
('en', 'vocabulary', 'language.mirandese', 'default', 'Mirandese', ''),
('en', 'vocabulary', 'language.mizo', 'default', 'Mizo', ''),
('en', 'vocabulary', 'language.mohawk', 'default', 'Mohawk', ''),
('en', 'vocabulary', 'language.moksha', 'default', 'Moksha', ''),
('en', 'vocabulary', 'language.moldavian', 'default', 'Moldavian', ''),
('en', 'vocabulary', 'language.mongo', 'default', 'Mongo', ''),
('en', 'vocabulary', 'language.mongolian', 'default', 'Mongolian', ''),
('en', 'vocabulary', 'language.morisyen', 'default', 'Morisyen', ''),
('en', 'vocabulary', 'language.mossi', 'default', 'Mossi', ''),
('en', 'vocabulary', 'language.motu.hiri', 'default', 'Hiri Motu', ''),
('en', 'vocabulary', 'language.multiple', 'default', 'Multiple Languages', ''),
('en', 'vocabulary', 'language.mundang', 'default', 'Mundang', ''),
('en', 'vocabulary', 'language.myene', 'default', 'Myene', ''),
('en', 'vocabulary', 'language.nama', 'default', 'Nama', ''),
('en', 'vocabulary', 'language.nauru', 'default', 'Nauru', ''),
('en', 'vocabulary', 'language.navajo', 'default', 'Navajo', ''),
('en', 'vocabulary', 'language.ndebele.north', 'default', 'North Ndebele', ''),
('en', 'vocabulary', 'language.ndebele.south', 'default', 'South Ndebele', ''),
('en', 'vocabulary', 'language.ndonga', 'default', 'Ndonga', ''),
('en', 'vocabulary', 'language.neapolitan', 'default', 'Neapolitan', ''),
('en', 'vocabulary', 'language.nepali', 'default', 'Nepali', ''),
('en', 'vocabulary', 'language.newari', 'default', 'Newari', ''),
('en', 'vocabulary', 'language.newari.classical', 'default', 'Classical Newari', ''),
('en', 'vocabulary', 'language.ngambay', 'default', 'Ngambay', ''),
('en', 'vocabulary', 'language.ngiemboon', 'default', 'Ngiemboon', ''),
('en', 'vocabulary', 'language.ngomba', 'default', 'Ngomba', ''),
('en', 'vocabulary', 'language.nheengatu', 'default', 'Nheengatu', ''),
('en', 'vocabulary', 'language.nias', 'default', 'Nias', ''),
('en', 'vocabulary', 'language.niuean', 'default', 'Niuean', ''),
('en', 'vocabulary', 'language.nko', 'default', 'N’Ko', ''),
('en', 'vocabulary', 'language.nogai', 'default', 'Nogai', ''),
('en', 'vocabulary', 'language.none', 'default', 'No linguistic content', ''),
('en', 'vocabulary', 'language.norse.old', 'default', 'Old Norse', ''),
('en', 'vocabulary', 'language.northern sami', 'default', 'Northern Sami', ''),
('en', 'vocabulary', 'language.norwegian', 'default', 'Norwegian', ''),
('en', 'vocabulary', 'language.norwegian.bokmål', 'default', 'Norwegian Bokmål', ''),
('en', 'vocabulary', 'language.norwegian.nynorsk', 'default', 'Norwegian Nynorsk', ''),
('en', 'vocabulary', 'language.novial', 'default', 'Novial', ''),
('en', 'vocabulary', 'language.nuer', 'default', 'Nuer', ''),
('en', 'vocabulary', 'language.nyamwezi', 'default', 'Nyamwezi', ''),
('en', 'vocabulary', 'language.nyanja', 'default', 'Nyanja', ''),
('en', 'vocabulary', 'language.nyankole', 'default', 'Nyankole', ''),
('en', 'vocabulary', 'language.nyoro', 'default', 'Nyoro', ''),
('en', 'vocabulary', 'language.nzima', 'default', 'Nzima', ''),
('en', 'vocabulary', 'language.occitan', 'default', 'Occitan', ''),
('en', 'vocabulary', 'language.ojibwa', 'default', 'Ojibwa', ''),
('en', 'vocabulary', 'language.oriya', 'default', 'Oriya', ''),
('en', 'vocabulary', 'language.oromo', 'default', 'Oromo', ''),
('en', 'vocabulary', 'language.osage', 'default', 'Osage', ''),
('en', 'vocabulary', 'language.ossetic', 'default', 'Ossetic', ''),
('en', 'vocabulary', 'language.pahlavi', 'default', 'Pahlavi', ''),
('en', 'vocabulary', 'language.palauan', 'default', 'Palauan', ''),
('en', 'vocabulary', 'language.pali', 'default', 'Pali', ''),
('en', 'vocabulary', 'language.pampanga', 'default', 'Pampanga', ''),
('en', 'vocabulary', 'language.pangasinan', 'default', 'Pangasinan', ''),
('en', 'vocabulary', 'language.papiamento', 'default', 'Papiamento', ''),
('en', 'vocabulary', 'language.pashto', 'default', 'Pashto', ''),
('en', 'vocabulary', 'language.persian', 'default', 'Persian', ''),
('en', 'vocabulary', 'language.persian.old', 'default', 'Old Persian', ''),
('en', 'vocabulary', 'language.phoenician', 'default', 'Phoenician', ''),
('en', 'vocabulary', 'language.picard', 'default', 'Picard', ''),
('en', 'vocabulary', 'language.piedmontese', 'default', 'Piedmontese', ''),
('en', 'vocabulary', 'language.pisin.tok', 'default', 'Tok Pisin', ''),
('en', 'vocabulary', 'language.plautdietsch', 'default', 'Plautdietsch', ''),
('en', 'vocabulary', 'language.pohnpeian', 'default', 'Pohnpeian', ''),
('en', 'vocabulary', 'language.polish', 'default', 'Polish', ''),
('en', 'vocabulary', 'language.pontic', 'default', 'Pontic', ''),
('en', 'vocabulary', 'language.portuguese', 'default', 'Portuguese', ''),
('en', 'vocabulary', 'language.portuguese.brazilian', 'default', 'Brazilian Portuguese', ''),
('en', 'vocabulary', 'language.portuguese.european', 'default', 'European Portuguese', ''),
('en', 'vocabulary', 'language.provençal.old', 'default', 'Old Provençal', ''),
('en', 'vocabulary', 'language.prussian', 'default', 'Prussian', ''),
('en', 'vocabulary', 'language.punjabi', 'default', 'Punjabi', ''),
('en', 'vocabulary', 'language.quechua', 'default', 'Quechua', ''),
('en', 'vocabulary', 'language.quichua.chimborazohighland', 'default', 'Chimborazo Highland Quichua', ''),
('en', 'vocabulary', 'language.rajasthani', 'default', 'Rajasthani', ''),
('en', 'vocabulary', 'language.rapanui', 'default', 'Rapanui', ''),
('en', 'vocabulary', 'language.rarotongan', 'default', 'Rarotongan', ''),
('en', 'vocabulary', 'language.riffian', 'default', 'Riffian', ''),
('en', 'vocabulary', 'language.romagnol', 'default', 'Romagnol', ''),
('en', 'vocabulary', 'language.romanian', 'default', 'Romanian', ''),
('en', 'vocabulary', 'language.romansh', 'default', 'Romansh', ''),
('en', 'vocabulary', 'language.romany', 'default', 'Romany', ''),
('en', 'vocabulary', 'language.rombo', 'default', 'Rombo', ''),
('en', 'vocabulary', 'language.root', 'default', 'Root', ''),
('en', 'vocabulary', 'language.rotuman', 'default', 'Rotuman', ''),
('en', 'vocabulary', 'language.roviana', 'default', 'Roviana', ''),
('en', 'vocabulary', 'language.rundi', 'default', 'Rundi', ''),
('en', 'vocabulary', 'language.russian', 'default', 'Russian', ''),
('en', 'vocabulary', 'language.rusyn', 'default', 'Rusyn', ''),
('en', 'vocabulary', 'language.rwa', 'default', 'Rwa', ''),
('en', 'vocabulary', 'language.saho', 'default', 'Saho', ''),
('en', 'vocabulary', 'language.sakha', 'default', 'Sakha', ''),
('en', 'vocabulary', 'language.samburu', 'default', 'Samburu', ''),
('en', 'vocabulary', 'language.sami.inari', 'default', 'Inari Sami', ''),
('en', 'vocabulary', 'language.sami.lule', 'default', 'Lule Sami', ''),
('en', 'vocabulary', 'language.sami.skolt', 'default', 'Skolt Sami', '');
INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'vocabulary', 'language.sami.southern', 'default', 'Southern Sami', ''),
('en', 'vocabulary', 'language.samoan', 'default', 'Samoan', ''),
('en', 'vocabulary', 'language.samogitian', 'default', 'Samogitian', ''),
('en', 'vocabulary', 'language.sandawe', 'default', 'Sandawe', ''),
('en', 'vocabulary', 'language.sango', 'default', 'Sango', ''),
('en', 'vocabulary', 'language.sangu', 'default', 'Sangu', ''),
('en', 'vocabulary', 'language.sanskrit', 'default', 'Sanskrit', ''),
('en', 'vocabulary', 'language.santali', 'default', 'Santali', ''),
('en', 'vocabulary', 'language.sardinian', 'default', 'Sardinian', ''),
('en', 'vocabulary', 'language.sardinian.sassarese', 'default', 'Sassarese Sardinian', ''),
('en', 'vocabulary', 'language.sasak', 'default', 'Sasak', ''),
('en', 'vocabulary', 'language.saurashtra', 'default', 'Saurashtra', ''),
('en', 'vocabulary', 'language.saxon.low', 'default', 'Low Saxon', ''),
('en', 'vocabulary', 'language.scots', 'default', 'Scots', ''),
('en', 'vocabulary', 'language.selayar', 'default', 'Selayar', ''),
('en', 'vocabulary', 'language.selkup', 'default', 'Selkup', ''),
('en', 'vocabulary', 'language.sena', 'default', 'Sena', ''),
('en', 'vocabulary', 'language.seneca', 'default', 'Seneca', ''),
('en', 'vocabulary', 'language.senni.koyraboro', 'default', 'Koyraboro Senni', ''),
('en', 'vocabulary', 'language.serbian', 'default', 'Serbian', ''),
('en', 'vocabulary', 'language.serbocroatian', 'default', 'Serbo-Croatian', ''),
('en', 'vocabulary', 'language.serer', 'default', 'Serer', ''),
('en', 'vocabulary', 'language.seri', 'default', 'Seri', ''),
('en', 'vocabulary', 'language.shambala', 'default', 'Shambala', ''),
('en', 'vocabulary', 'language.shan', 'default', 'Shan', ''),
('en', 'vocabulary', 'language.shona', 'default', 'Shona', ''),
('en', 'vocabulary', 'language.sicilian', 'default', 'Sicilian', ''),
('en', 'vocabulary', 'language.sidamo', 'default', 'Sidamo', ''),
('en', 'vocabulary', 'language.siksika', 'default', 'Siksika', ''),
('en', 'vocabulary', 'language.silesian', 'default', 'Silesian', ''),
('en', 'vocabulary', 'language.silesian.lower', 'default', 'Lower Silesian', ''),
('en', 'vocabulary', 'language.sindhi', 'default', 'Sindhi', ''),
('en', 'vocabulary', 'language.sinhala', 'default', 'Sinhala', ''),
('en', 'vocabulary', 'language.slave', 'default', 'Slave', ''),
('en', 'vocabulary', 'language.slavic.church', 'default', 'Church Slavic', ''),
('en', 'vocabulary', 'language.slovak', 'default', 'Slovak', ''),
('en', 'vocabulary', 'language.slovenian', 'default', 'Slovenian', ''),
('en', 'vocabulary', 'language.soga', 'default', 'Soga', ''),
('en', 'vocabulary', 'language.sogdien', 'default', 'Sogdien', ''),
('en', 'vocabulary', 'language.somali', 'default', 'Somali', ''),
('en', 'vocabulary', 'language.soninke', 'default', 'Soninke', ''),
('en', 'vocabulary', 'language.sorbian.lower', 'default', 'Lower Sorbian', ''),
('en', 'vocabulary', 'language.sorbian.upper', 'default', 'Upper Sorbian', ''),
('en', 'vocabulary', 'language.sotho.northern', 'default', 'Northern Sotho', ''),
('en', 'vocabulary', 'language.sotho.southern', 'default', 'Southern Sotho', ''),
('en', 'vocabulary', 'language.southern kurdish', 'default', 'Southern Kurdish', ''),
('en', 'vocabulary', 'language.spanish', 'default', 'Spanish', ''),
('en', 'vocabulary', 'language.spanish.european', 'default', 'European Spanish', ''),
('en', 'vocabulary', 'Language.spanish.latinamerican', 'default', 'Latin American Spanish', ''),
('en', 'vocabulary', 'language.spanish.mexican', 'default', 'Mexican Spanish', ''),
('en', 'vocabulary', 'language.sukuma', 'default', 'Sukuma', ''),
('en', 'vocabulary', 'language.sumerian', 'default', 'Sumerian', ''),
('en', 'vocabulary', 'language.sundanese', 'default', 'Sundanese', ''),
('en', 'vocabulary', 'language.susu', 'default', 'Susu', ''),
('en', 'vocabulary', 'language.swahili', 'default', 'Swahili', ''),
('en', 'vocabulary', 'language.swahili.congo', 'default', 'Congo Swahili', ''),
('en', 'vocabulary', 'language.swati', 'default', 'Swati', ''),
('en', 'vocabulary', 'language.swedish', 'default', 'Swedish', ''),
('en', 'vocabulary', 'language.syriac', 'default', 'Syriac', ''),
('en', 'vocabulary', 'language.syriac.classical', 'default', 'Classical Syriac', ''),
('en', 'vocabulary', 'language.tachelhit', 'default', 'Tachelhit', ''),
('en', 'vocabulary', 'language.tagalog', 'default', 'Tagalog', ''),
('en', 'vocabulary', 'language.tahitian', 'default', 'Tahitian', ''),
('en', 'vocabulary', 'language.taita', 'default', 'Taita', ''),
('en', 'vocabulary', 'language.tajik', 'default', 'Tajik', ''),
('en', 'vocabulary', 'language.talysh', 'default', 'Talysh', ''),
('en', 'vocabulary', 'language.tamashek', 'default', 'Tamashek', ''),
('en', 'vocabulary', 'language.tamazight.centralatlas', 'default', 'Central Atlas Tamazight', ''),
('en', 'vocabulary', 'language.tamazight.standardmoroccan', 'default', 'Standard Moroccan Tamazight', ''),
('en', 'vocabulary', 'language.tamil', 'default', 'Tamil', ''),
('en', 'vocabulary', 'language.taroko', 'default', 'Taroko', ''),
('en', 'vocabulary', 'language.tasawaq', 'default', 'Tasawaq', ''),
('en', 'vocabulary', 'language.tat.muslim', 'default', 'Muslim Tat', ''),
('en', 'vocabulary', 'language.tatar', 'default', 'Tatar', ''),
('en', 'vocabulary', 'language.telugu', 'default', 'Telugu', ''),
('en', 'vocabulary', 'language.tereno', 'default', 'Tereno', ''),
('en', 'vocabulary', 'language.teso', 'default', 'Teso', ''),
('en', 'vocabulary', 'language.tetum', 'default', 'Tetum', ''),
('en', 'vocabulary', 'language.thai', 'default', 'Thai', ''),
('en', 'vocabulary', 'language.tibetan', 'default', 'Tibetan', ''),
('en', 'vocabulary', 'language.tigre', 'default', 'Tigre', ''),
('en', 'vocabulary', 'language.tigrinya', 'default', 'Tigrinya', ''),
('en', 'vocabulary', 'language.timne', 'default', 'Timne', ''),
('en', 'vocabulary', 'language.tiv', 'default', 'Tiv', ''),
('en', 'vocabulary', 'language.tlingit', 'default', 'Tlingit', ''),
('en', 'vocabulary', 'language.tokelau', 'default', 'Tokelau', ''),
('en', 'vocabulary', 'language.tonga.nyasa', 'default', 'Nyasa Tonga', ''),
('en', 'vocabulary', 'language.tongan', 'default', 'Tongan', ''),
('en', 'vocabulary', 'language.tongo.sranan', 'default', 'Sranan Tongo', ''),
('en', 'vocabulary', 'language.tsakhur', 'default', 'Tsakhur', ''),
('en', 'vocabulary', 'language.tsakonian', 'default', 'Tsakonian', ''),
('en', 'vocabulary', 'language.tsimshian', 'default', 'Tsimshian', ''),
('en', 'vocabulary', 'language.tsonga', 'default', 'Tsonga', ''),
('en', 'vocabulary', 'language.tswana', 'default', 'Tswana', ''),
('en', 'vocabulary', 'language.tulu', 'default', 'Tulu', ''),
('en', 'vocabulary', 'language.tumbuka', 'default', 'Tumbuka', ''),
('en', 'vocabulary', 'language.turkish', 'default', 'Turkish', ''),
('en', 'vocabulary', 'language.turkish.crimean', 'default', 'Crimean Turkish', ''),
('en', 'vocabulary', 'language.turkish.ottoman', 'default', 'Ottoman Turkish', ''),
('en', 'vocabulary', 'language.turkmen', 'default', 'Turkmen', ''),
('en', 'vocabulary', 'language.turoyo', 'default', 'Turoyo', ''),
('en', 'vocabulary', 'language.tuvalu', 'default', 'Tuvalu', ''),
('en', 'vocabulary', 'language.tuvinian', 'default', 'Tuvinian', ''),
('en', 'vocabulary', 'language.twi', 'default', 'Twi', ''),
('en', 'vocabulary', 'language.tyap', 'default', 'Tyap', ''),
('en', 'vocabulary', 'language.udmurt', 'default', 'Udmurt', ''),
('en', 'vocabulary', 'language.ugaritic', 'default', 'Ugaritic', ''),
('en', 'vocabulary', 'language.ukrainian', 'default', 'Ukrainian', ''),
('en', 'vocabulary', 'language.umbundu', 'default', 'Umbundu', ''),
('en', 'vocabulary', 'language.unknown', 'default', 'Unknown Language', ''),
('en', 'vocabulary', 'language.urdu', 'default', 'Urdu', ''),
('en', 'vocabulary', 'language.uyghur', 'default', 'Uyghur', ''),
('en', 'vocabulary', 'language.uzbek', 'default', 'Uzbek', ''),
('en', 'vocabulary', 'language.vai', 'default', 'Vai', ''),
('en', 'vocabulary', 'language.venda', 'default', 'Venda', ''),
('en', 'vocabulary', 'language.venetian', 'default', 'Venetian', ''),
('en', 'vocabulary', 'language.veps', 'default', 'Veps', ''),
('en', 'vocabulary', 'language.vietnamese', 'default', 'Vietnamese', ''),
('en', 'vocabulary', 'language.volapük', 'default', 'Volapük', ''),
('en', 'vocabulary', 'language.võro', 'default', 'Võro', ''),
('en', 'vocabulary', 'language.votic', 'default', 'Votic', ''),
('en', 'vocabulary', 'language.vunjo', 'default', 'Vunjo', ''),
('en', 'vocabulary', 'language.walloon', 'default', 'Walloon', ''),
('en', 'vocabulary', 'language.walser', 'default', 'Walser', ''),
('en', 'vocabulary', 'language.waray', 'default', 'Waray', ''),
('en', 'vocabulary', 'language.warlpiri', 'default', 'Warlpiri', ''),
('en', 'vocabulary', 'language.washo', 'default', 'Washo', ''),
('en', 'vocabulary', 'language.wayuu', 'default', 'Wayuu', ''),
('en', 'vocabulary', 'language.welsh', 'default', 'Welsh', ''),
('en', 'vocabulary', 'language.wolaytta', 'default', 'Wolaytta', ''),
('en', 'vocabulary', 'language.wolof', 'default', 'Wolof', ''),
('en', 'vocabulary', 'language.xhosa', 'default', 'Xhosa', ''),
('en', 'vocabulary', 'language.yangben', 'default', 'Yangben', ''),
('en', 'vocabulary', 'language.yao', 'default', 'Yao', ''),
('en', 'vocabulary', 'language.yapese', 'default', 'Yapese', ''),
('en', 'vocabulary', 'language.yemba', 'default', 'Yemba', ''),
('en', 'vocabulary', 'language.yi.sichuan', 'default', 'Sichuan Yi', ''),
('en', 'vocabulary', 'language.yiddish', 'default', 'Yiddish', ''),
('en', 'vocabulary', 'language.yoruba', 'default', 'Yoruba', ''),
('en', 'vocabulary', 'language.yupik.central', 'default', 'Central Yupik', ''),
('en', 'vocabulary', 'language.zapotec', 'default', 'Zapotec', ''),
('en', 'vocabulary', 'language.zarma', 'default', 'Zarma', ''),
('en', 'vocabulary', 'language.zaza', 'default', 'Zaza', ''),
('en', 'vocabulary', 'language.zeelandic', 'default', 'Zeelandic', ''),
('en', 'vocabulary', 'language.zenaga', 'default', 'Zenaga', ''),
('en', 'vocabulary', 'language.zhuang', 'default', 'Zhuang', ''),
('en', 'vocabulary', 'language.zulu', 'default', 'Zulu', ''),
('en', 'vocabulary', 'language.zuni', 'default', 'Zuni', ''),
('en', 'vocabulary', 'length.kilometre', 'default', 'kilometre', ''),
('en', 'vocabulary', 'length.metre', 'default', 'metre', ''),
('en', 'vocabulary', 'length.micrometre', 'default', 'micrometre', ''),
('en', 'vocabulary', 'length.millimetre', 'default', 'millimetre', ''),
('en', 'vocabulary', 'length.nanometre', 'default', 'nanometre', ''),
('en', 'vocabulary', 'mass.gram', 'default', 'gram', ''),
('en', 'vocabulary', 'mass.kilogram', 'default', 'kilogram', ''),
('en', 'vocabulary', 'mass.microgram', 'default', 'microgram', ''),
('en', 'vocabulary', 'mass.milligram', 'default', 'milligram', ''),
('en', 'vocabulary', 'mass.tonne', 'default', 'tonne', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_type`
--

CREATE TABLE `ark_vocabulary_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equivalence` tinyint(1) NOT NULL DEFAULT '0',
  `hierarchy` tinyint(1) NOT NULL DEFAULT '0',
  `association` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_type`
--

INSERT INTO `ark_vocabulary_type` (`type`, `equivalence`, `hierarchy`, `association`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('list', 0, 0, 0, 1, 0, 'vocabulary.type.list', 'A list of valid terms'),
('ring', 1, 0, 0, 0, 0, 'vocabulary.type.ring', 'A list of equivalent terms'),
('taxonomy', 0, 1, 0, 1, 0, 'vocabulary.type.taxonomy', 'A hierarchy of related terms'),
('thesaurus', 1, 1, 1, 0, 0, 'vocabulary.type.thesaurus', 'A collection of related terms');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ark_config_error`
--
ALTER TABLE `ark_config_error`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `ark_config_flash`
--
ALTER TABLE `ark_config_flash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ark_config_thumbnail`
--
ALTER TABLE `ark_config_thumbnail`
  ADD PRIMARY KEY (`profile`);

--
-- Indexes for table `ark_datatype`
--
ALTER TABLE `ark_datatype`
  ADD PRIMARY KEY (`datatype`),
  ADD KEY `format_vocabulary` (`format_vocabulary`),
  ADD KEY `parameter_vocabulary` (`parameter_vocabulary`);

--
-- Indexes for table `ark_format`
--
ALTER TABLE `ark_format`
  ADD PRIMARY KEY (`format`),
  ADD KEY `fragment_type` (`datatype`),
  ADD KEY `parameter_vocabulary` (`parameter_vocabulary`),
  ADD KEY `format_vocabulary` (`format_vocabulary`);

--
-- Indexes for table `ark_format_attribute`
--
ALTER TABLE `ark_format_attribute`
  ADD PRIMARY KEY (`parent`,`attribute`),
  ADD KEY `vocabulary` (`vocabulary`),
  ADD KEY `format` (`format`),
  ADD KEY `IDX_489D0B203D8E604F` (`parent`);

--
-- Indexes for table `ark_format_blob`
--
ALTER TABLE `ark_format_blob`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_boolean`
--
ALTER TABLE `ark_format_boolean`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_datetime`
--
ALTER TABLE `ark_format_datetime`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_decimal`
--
ALTER TABLE `ark_format_decimal`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_float`
--
ALTER TABLE `ark_format_float`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_integer`
--
ALTER TABLE `ark_format_integer`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_item`
--
ALTER TABLE `ark_format_item`
  ADD PRIMARY KEY (`format`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `ark_format_object`
--
ALTER TABLE `ark_format_object`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_spatial`
--
ALTER TABLE `ark_format_spatial`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_text`
--
ALTER TABLE `ark_format_text`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_instance`
--
ALTER TABLE `ark_instance`
  ADD PRIMARY KEY (`instance`);

--
-- Indexes for table `ark_instance_schema`
--
ALTER TABLE `ark_instance_schema`
  ADD PRIMARY KEY (`instance`,`schma`),
  ADD KEY `schma` (`schma`),
  ADD KEY `IDX_63EF5444230B1DE` (`instance`);

--
-- Indexes for table `ark_map`
--
ALTER TABLE `ark_map`
  ADD PRIMARY KEY (`map`);

--
-- Indexes for table `ark_map_layer`
--
ALTER TABLE `ark_map_layer`
  ADD PRIMARY KEY (`source`,`layer`),
  ADD KEY `IDX_ADAEEC535F8A7F73` (`source`);

--
-- Indexes for table `ark_map_legend`
--
ALTER TABLE `ark_map_legend`
  ADD PRIMARY KEY (`map`,`source`,`layer`),
  ADD UNIQUE KEY `sequence` (`map`,`source`,`layer`,`seq`),
  ADD KEY `legend_layer` (`source`,`layer`),
  ADD KEY `IDX_C9233F5F93ADAABB` (`map`);

--
-- Indexes for table `ark_map_source`
--
ALTER TABLE `ark_map_source`
  ADD PRIMARY KEY (`source`);

--
-- Indexes for table `ark_module`
--
ALTER TABLE `ark_module`
  ADD PRIMARY KEY (`module`);

--
-- Indexes for table `ark_rbac_action`
--
ALTER TABLE `ark_rbac_action`
  ADD PRIMARY KEY (`action`);

--
-- Indexes for table `ark_rbac_permission`
--
ALTER TABLE `ark_rbac_permission`
  ADD PRIMARY KEY (`permission`);

--
-- Indexes for table `ark_rbac_role`
--
ALTER TABLE `ark_rbac_role`
  ADD PRIMARY KEY (`role`);

--
-- Indexes for table `ark_rbac_role_action`
--
ALTER TABLE `ark_rbac_role_action`
  ADD PRIMARY KEY (`role`,`action`),
  ADD KEY `permission` (`action`),
  ADD KEY `IDX_652200657698A6A` (`role`);

--
-- Indexes for table `ark_rbac_role_permission`
--
ALTER TABLE `ark_rbac_role_permission`
  ADD PRIMARY KEY (`role`,`permission`),
  ADD KEY `permission` (`permission`),
  ADD KEY `IDX_EC1096CF57698A6A` (`role`);

--
-- Indexes for table `ark_route`
--
ALTER TABLE `ark_route`
  ADD PRIMARY KEY (`route`),
  ADD KEY `page` (`page`);

--
-- Indexes for table `ark_schema`
--
ALTER TABLE `ark_schema`
  ADD PRIMARY KEY (`schma`),
  ADD KEY `module` (`module`);

--
-- Indexes for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD PRIMARY KEY (`schma`,`type`,`association`),
  ADD KEY `inverse_schema` (`inverse`),
  ADD KEY `IDX_39AF30E1FDE1EB53` (`schma`);

--
-- Indexes for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD PRIMARY KEY (`schma`,`type`,`attribute`),
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`),
  ADD KEY `IDX_A53B51DEFDE1EB53` (`schma`);

--
-- Indexes for table `ark_schema_item`
--
ALTER TABLE `ark_schema_item`
  ADD PRIMARY KEY (`attribute`),
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`);

--
-- Indexes for table `ark_translation`
--
ALTER TABLE `ark_translation`
  ADD PRIMARY KEY (`keyword`),
  ADD KEY `domain` (`domain`);

--
-- Indexes for table `ark_translation_domain`
--
ALTER TABLE `ark_translation_domain`
  ADD PRIMARY KEY (`domain`);

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
  ADD KEY `keyword` (`keyword`),
  ADD KEY `role` (`role`),
  ADD KEY `IDX_725771B1D4DB71B5` (`language`);

--
-- Indexes for table `ark_translation_parameter`
--
ALTER TABLE `ark_translation_parameter`
  ADD PRIMARY KEY (`keyword`,`parameter`),
  ADD KEY `IDX_7E35DE3C5A93713B` (`keyword`);

--
-- Indexes for table `ark_translation_role`
--
ALTER TABLE `ark_translation_role`
  ADD PRIMARY KEY (`role`);

--
-- Indexes for table `ark_view_element`
--
ALTER TABLE `ark_view_element`
  ADD PRIMARY KEY (`element`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ark_view_field`
--
ALTER TABLE `ark_view_field`
  ADD PRIMARY KEY (`element`),
  ADD KEY `schma` (`schma`);

--
-- Indexes for table `ark_view_grid`
--
ALTER TABLE `ark_view_grid`
  ADD PRIMARY KEY (`layout`,`item_type`,`row`,`col`,`seq`),
  ADD KEY `child` (`cell`),
  ADD KEY `map` (`map`),
  ADD KEY `IDX_1919974E3A3A6BE2` (`layout`);

--
-- Indexes for table `ark_view_layout`
--
ALTER TABLE `ark_view_layout`
  ADD PRIMARY KEY (`element`),
  ADD KEY `schma` (`schma`);

--
-- Indexes for table `ark_view_nav`
--
ALTER TABLE `ark_view_nav`
  ADD PRIMARY KEY (`element`),
  ADD KEY `ark_view_nav_ibfk_2` (`parent`);

--
-- Indexes for table `ark_view_page`
--
ALTER TABLE `ark_view_page`
  ADD PRIMARY KEY (`element`),
  ADD KEY `navbar_element` (`navbar`),
  ADD KEY `sidebar_element` (`sidebar`),
  ADD KEY `content_element` (`content`),
  ADD KEY `footer_element` (`footer`);

--
-- Indexes for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depth` (`depth`),
  ADD KEY `ancestor` (`ancestor`),
  ADD KEY `descendent` (`descendent`);

--
-- Indexes for table `ark_view_type`
--
ALTER TABLE `ark_view_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `ark_vocabulary`
--
ALTER TABLE `ark_vocabulary`
  ADD PRIMARY KEY (`concept`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `ark_vocabulary_collected`
--
ALTER TABLE `ark_vocabulary_collected`
  ADD PRIMARY KEY (`concept`,`collection`,`term`);

--
-- Indexes for table `ark_vocabulary_collection`
--
ALTER TABLE `ark_vocabulary_collection`
  ADD PRIMARY KEY (`concept`,`collection`);

--
-- Indexes for table `ark_vocabulary_parameter`
--
ALTER TABLE `ark_vocabulary_parameter`
  ADD PRIMARY KEY (`concept`,`term`,`name`),
  ADD KEY `concept` (`concept`,`term`);

--
-- Indexes for table `ark_vocabulary_related`
--
ALTER TABLE `ark_vocabulary_related`
  ADD PRIMARY KEY (`from_concept`,`from_term`,`to_concept`,`to_term`),
  ADD KEY `relation` (`relation`),
  ADD KEY `from_term` (`from_concept`,`from_term`),
  ADD KEY `to_term` (`to_concept`,`to_term`);

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
  ADD UNIQUE KEY `keyword` (`keyword`),
  ADD KEY `IDX_33B2DCCE74A6050` (`concept`);

--
-- Indexes for table `ark_vocabulary_translation`
--
ALTER TABLE `ark_vocabulary_translation`
  ADD PRIMARY KEY (`language`,`domain`,`keyword`,`role`),
  ADD KEY `keyword` (`keyword`),
  ADD KEY `domain` (`domain`),
  ADD KEY `role` (`role`),
  ADD KEY `IDX_DAC75EEFD4DB71B5` (`language`);

--
-- Indexes for table `ark_vocabulary_type`
--
ALTER TABLE `ark_vocabulary_type`
  ADD PRIMARY KEY (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_config_flash`
--
ALTER TABLE `ark_config_flash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_datatype`
--
ALTER TABLE `ark_datatype`
  ADD CONSTRAINT `ark_datatype_ibfk_1` FOREIGN KEY (`format_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_datatype_ibfk_2` FOREIGN KEY (`parameter_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_format`
--
ALTER TABLE `ark_format`
  ADD CONSTRAINT `ark_format_ibfk_1` FOREIGN KEY (`datatype`) REFERENCES `ark_datatype` (`datatype`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_format_ibfk_2` FOREIGN KEY (`parameter_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_format_ibfk_3` FOREIGN KEY (`format_vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_attribute`
--
ALTER TABLE `ark_format_attribute`
  ADD CONSTRAINT `ark_format_attribute_ibfk_2` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_format_attribute_ibfk_3` FOREIGN KEY (`parent`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_format_attribute_ibfk_4` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_blob`
--
ALTER TABLE `ark_format_blob`
  ADD CONSTRAINT `ark_format_blob_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_boolean`
--
ALTER TABLE `ark_format_boolean`
  ADD CONSTRAINT `ark_format_boolean_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_datetime`
--
ALTER TABLE `ark_format_datetime`
  ADD CONSTRAINT `ark_format_datetime_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_decimal`
--
ALTER TABLE `ark_format_decimal`
  ADD CONSTRAINT `ark_format_decimal_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_float`
--
ALTER TABLE `ark_format_float`
  ADD CONSTRAINT `ark_format_float_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_integer`
--
ALTER TABLE `ark_format_integer`
  ADD CONSTRAINT `ark_format_integer_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_item`
--
ALTER TABLE `ark_format_item`
  ADD CONSTRAINT `ark_format_item_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_format_item_ibfk_2` FOREIGN KEY (`module`) REFERENCES `ark_module` (`module`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_object`
--
ALTER TABLE `ark_format_object`
  ADD CONSTRAINT `ark_format_object_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_spatial`
--
ALTER TABLE `ark_format_spatial`
  ADD CONSTRAINT `ark_format_spatial_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD CONSTRAINT `ark_format_string_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_text`
--
ALTER TABLE `ark_format_text`
  ADD CONSTRAINT `ark_format_text_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_instance_schema`
--
ALTER TABLE `ark_instance_schema`
  ADD CONSTRAINT `ark_instance_schema_ibfk_1` FOREIGN KEY (`instance`) REFERENCES `ark_instance` (`instance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_instance_schema_ibfk_2` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_map_layer`
--
ALTER TABLE `ark_map_layer`
  ADD CONSTRAINT `ark_map_layer_ibfk_1` FOREIGN KEY (`source`) REFERENCES `ark_map_source` (`source`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_map_legend`
--
ALTER TABLE `ark_map_legend`
  ADD CONSTRAINT `legend_layer` FOREIGN KEY (`source`,`layer`) REFERENCES `ark_map_layer` (`source`, `layer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `legend_map` FOREIGN KEY (`map`) REFERENCES `ark_map` (`map`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_rbac_role_action`
--
ALTER TABLE `ark_rbac_role_action`
  ADD CONSTRAINT `ark_rbac_role_action_ibfk_1` FOREIGN KEY (`role`) REFERENCES `ark_rbac_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_rbac_role_action_ibfk_2` FOREIGN KEY (`action`) REFERENCES `ark_rbac_action` (`action`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_rbac_role_permission`
--
ALTER TABLE `ark_rbac_role_permission`
  ADD CONSTRAINT `ark_rbac_role_permission_ibfk_1` FOREIGN KEY (`role`) REFERENCES `ark_rbac_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_rbac_role_permission_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `ark_rbac_permission` (`permission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_route`
--
ALTER TABLE `ark_route`
  ADD CONSTRAINT `ark_route_ibfk_1` FOREIGN KEY (`page`) REFERENCES `ark_view_page` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema`
--
ALTER TABLE `ark_schema`
  ADD CONSTRAINT `ark_schema_ibfk_1` FOREIGN KEY (`module`) REFERENCES `ark_module` (`module`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD CONSTRAINT `ark_schema_association_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_association_ibfk_2` FOREIGN KEY (`inverse`) REFERENCES `ark_schema` (`schma`);

--
-- Constraints for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD CONSTRAINT `ark_schema_attribute_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_attribute_ibfk_2` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_attribute_ibfk_3` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation`
--
ALTER TABLE `ark_translation`
  ADD CONSTRAINT `ark_translation_ibfk_1` FOREIGN KEY (`domain`) REFERENCES `ark_translation_domain` (`domain`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_message`
--
ALTER TABLE `ark_translation_message`
  ADD CONSTRAINT `ark_translation_message_ibfk_1` FOREIGN KEY (`language`) REFERENCES `ark_translation_language` (`language`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_translation_message_ibfk_2` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_translation_message_ibfk_3` FOREIGN KEY (`role`) REFERENCES `ark_translation_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_translation_parameter`
--
ALTER TABLE `ark_translation_parameter`
  ADD CONSTRAINT `ark_translation_parameter_ibfk_1` FOREIGN KEY (`keyword`) REFERENCES `ark_translation` (`keyword`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_element`
--
ALTER TABLE `ark_view_element`
  ADD CONSTRAINT `ark_view_element_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_view_type` (`type`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_grid`
--
ALTER TABLE `ark_view_grid`
  ADD CONSTRAINT `ark_view_grid_ibfk_1` FOREIGN KEY (`layout`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_grid_ibfk_2` FOREIGN KEY (`cell`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_grid_ibfk_3` FOREIGN KEY (`map`) REFERENCES `ark_map` (`map`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_nav`
--
ALTER TABLE `ark_view_nav`
  ADD CONSTRAINT `ark_view_nav_ibfk_1` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_nav_ibfk_2` FOREIGN KEY (`parent`) REFERENCES `ark_view_nav` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_page`
--
ALTER TABLE `ark_view_page`
  ADD CONSTRAINT `content_element` FOREIGN KEY (`content`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `element` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `footer_element` FOREIGN KEY (`footer`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `navbar_element` FOREIGN KEY (`navbar`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sidebar_element` FOREIGN KEY (`sidebar`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  ADD CONSTRAINT `ark_view_tree_ibfk_1` FOREIGN KEY (`ancestor`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_tree_ibfk_2` FOREIGN KEY (`descendent`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary`
--
ALTER TABLE `ark_vocabulary`
  ADD CONSTRAINT `ark_vocabulary_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_vocabulary_type` (`type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_parameter`
--
ALTER TABLE `ark_vocabulary_parameter`
  ADD CONSTRAINT `ark_vocabulary_parameter_ibfk_1` FOREIGN KEY (`concept`,`term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_related`
--
ALTER TABLE `ark_vocabulary_related`
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_1` FOREIGN KEY (`from_concept`,`from_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_2` FOREIGN KEY (`to_concept`,`to_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_3` FOREIGN KEY (`relation`) REFERENCES `ark_vocabulary_relation` (`relation`);

--
-- Constraints for table `ark_vocabulary_term`
--
ALTER TABLE `ark_vocabulary_term`
  ADD CONSTRAINT `ark_vocabulary_term_ibfk_1` FOREIGN KEY (`concept`) REFERENCES `ark_vocabulary` (`concept`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_translation`
--
ALTER TABLE `ark_vocabulary_translation`
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_1` FOREIGN KEY (`keyword`) REFERENCES `ark_vocabulary_term` (`keyword`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_2` FOREIGN KEY (`language`) REFERENCES `ark_translation_language` (`language`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_3` FOREIGN KEY (`domain`) REFERENCES `ark_translation_domain` (`domain`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_4` FOREIGN KEY (`role`) REFERENCES `ark_translation_role` (`role`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
