-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 08, 2017 at 10:13 PM
-- Server version: 5.6.34
-- PHP Version: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dime_ark_core`
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

--
-- Dumping data for table `ark_config_flash`
--

INSERT INTO `ark_config_flash` (`id`, `active`, `type`, `language`, `text`) VALUES
(1, 0, 'info', 'en', 'This is a site Information flash message stored in the database.'),
(2, 0, 'warning', 'en', 'This is a site Warning flash message stored in the database.'),
(3, 0, 'danger', 'en', 'This is a site Danger flash message stored in the database.'),
(4, 0, 'success', 'en', 'This is a site Success flash message stored in the database.');

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

--
-- Dumping data for table `ark_config_thumbnail`
--

INSERT INTO `ark_config_thumbnail` (`profile`, `max`, `min`, `mode`, `type`, `keyword`) VALUES
('gallery', 100, 100, 'aspect', 'jpg', 'thumbnail.gallery'),
('preview', 300, NULL, 'aspect', 'jpg', 'thumbnail.preview');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format`
--

CREATE TABLE `ark_format` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object` tinyint(1) NOT NULL DEFAULT '0',
  `array` tinyint(1) NOT NULL DEFAULT '0',
  `sortable` tinyint(1) NOT NULL DEFAULT '1',
  `searchable` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format`
--

INSERT INTO `ark_format` (`format`, `type`, `input`, `object`, `array`, `sortable`, `searchable`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'item', 'select', 0, 0, 0, 0, 1, 0, 'format.actor'),
('address', 'object', '', 1, 0, 0, 1, 1, 0, 'format.address'),
('blob', 'blob', '', 0, 0, 0, 0, 1, 0, 'format.blob'),
('boolean', 'boolean', '', 0, 0, 1, 1, 1, 0, 'format.boolean'),
('color', 'string', 'color', 0, 0, 1, 1, 1, 0, 'format.colour'),
('date', 'date', 'date', 0, 0, 1, 1, 1, 0, 'format.date'),
('datetime', 'datetime', 'date', 0, 0, 1, 1, 1, 0, 'format.datetime'),
('decimal', 'decimal', 'text', 0, 0, 1, 1, 1, 0, 'format.decimal'),
('distance', 'decimal', 'text', 0, 0, 1, 1, 1, 0, 'format.distance'),
('email', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.email'),
('event', 'object', '', 1, 0, 0, 1, 1, 0, 'format.event'),
('fileversion', 'object', '', 1, 0, 0, 1, 1, 0, 'format.fileversion'),
('float', 'float', 'text', 0, 0, 1, 1, 1, 0, 'format.float'),
('geometry', 'wkt', 'text', 0, 0, 1, 1, 1, 0, 'format.geometry'),
('html', 'text', 'textarea', 1, 0, 1, 1, 1, 0, 'format.html'),
('identifier', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.identifier'),
('integer', 'integer', 'text', 0, 0, 1, 1, 1, 0, 'format.integer'),
('item', 'item', 'select', 0, 0, 0, 0, 1, 0, 'format.item'),
('key', 'string', 'select', 0, 0, 1, 1, 1, 0, 'format.key'),
('localtext', 'text', 'textarea', 1, 0, 1, 1, 1, 0, 'format.localtext'),
('markdown', 'text', 'textarea', 1, 0, 1, 1, 1, 0, 'format.markdown'),
('mass', 'decimal', 'text', 0, 0, 1, 1, 1, 0, 'format.mass'),
('module', 'string', 'select', 0, 0, 0, 0, 1, 0, 'format.module'),
('money', 'decimal', 'date', 0, 0, 1, 1, 1, 0, 'format.money'),
('ordinaldate', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.ordinaldate'),
('password', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.password'),
('percent', 'float', 'text', 0, 0, 1, 1, 1, 0, 'format.percent'),
('richtext', 'text', 'textarea', 1, 0, 1, 1, 1, 0, 'format.richtext'),
('search', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.search'),
('shortlocaltext', 'text', 'text', 1, 0, 1, 1, 1, 0, 'format.shortlocaltext'),
('string', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.string'),
('telephone', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.telephone'),
('text', 'text', 'textarea', 0, 0, 1, 1, 1, 0, 'format.text'),
('time', 'time', 'date', 0, 0, 1, 1, 1, 0, 'format.time'),
('url', 'text', 'text', 0, 0, 1, 1, 1, 0, 'format.url'),
('weekdate', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.weekdate'),
('wkt', 'wkt', 'text', 0, 0, 0, 1, 1, 0, 'format.wkt'),
('yearmonth', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.yearmonth'),
('yearweek', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.yearweek');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_attribute`
--

CREATE TABLE `ark_format_attribute` (
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `root` tinyint(1) NOT NULL DEFAULT '0',
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_format_attribute`
--

INSERT INTO `ark_format_attribute` (`parent`, `attribute`, `sequence`, `format`, `vocabulary`, `root`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('address', 'city', 1, 'localtext', NULL, 0, 1, 1, 1, 0, 1, 0, 'format.address.city'),
('address', 'country', 2, 'identifier', 'country', 0, 1, 1, 1, 0, 1, 0, 'format.address.country'),
('address', 'street', 0, 'localtext', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.address.street'),
('distance', 'measurement', 0, 'decimal', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.length.measurement'),
('distance', 'unit', 1, 'identifier', 'distance', 0, 1, 1, 1, 0, 1, 0, 'format.length.unit'),
('event', 'by', 0, 'actor', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.event.by'),
('event', 'on', 1, 'datetime', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.event.on'),
('fileversion', 'created', 3, 'event', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.created'),
('fileversion', 'expires', 5, 'datetime', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.expires'),
('fileversion', 'modified', 4, 'event', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.modified'),
('fileversion', 'name', 1, 'string', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.name'),
('fileversion', 'sequence', 0, 'integer', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.sequence'),
('fileversion', 'version', 2, 'string', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.string'),
('geometry', 'coordinates', 0, 'wkt', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.geometry.wkt'),
('geometry', 'srid', 1, 'identifier', 'crs', 0, 1, 1, 1, 0, 1, 0, 'format.geometry.crs'),
('html', 'content', 1, 'text', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.html.content'),
('html', 'language', 0, 'identifier', 'language', 0, 1, 1, 1, 0, 1, 0, 'format.html.language'),
('item', 'id', 1, 'identifier', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.item.id'),
('item', 'module', 0, 'identifier', NULL, 0, 1, 1, 1, 0, 1, 0, 'format.item.module'),
('localtext', 'content', 1, 'text', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.text.content'),
('localtext', 'language', 0, 'identifier', 'language', 0, 1, 1, 1, 0, 1, 0, 'format.text.language'),
('mass', 'measurement', 0, 'decimal', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.mass.measurement'),
('mass', 'unit', 1, 'identifier', 'mass', 0, 1, 1, 1, 0, 1, 0, 'format.mass.unit'),
('shortlocaltext', 'content', 1, 'text', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.text.content'),
('shortlocaltext', 'language', 0, 'identifier', 'language', 0, 1, 1, 1, 0, 1, 0, 'format.text.language');

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
  `scale` int(11) NOT NULL,
  `minimum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
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
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` double DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
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
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` int(11) DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
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
-- Table structure for table `ark_format_string`
--

CREATE TABLE `ark_format_string` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL,
  `spellcheck` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_format_string`
--

INSERT INTO `ark_format_string` (`format`, `pattern`, `min_length`, `max_length`, `default_size`, `spellcheck`) VALUES
('color', '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$', 4, 7, 10, 0),
('email', '^(?!^.{254})(([^@]+)@([^@]+))$', 3, 254, 30, 0),
('html', '', 1, 1431655765, 30, 1),
('identifier', '^(\\w{1,30})$', 1, 30, 30, 0),
('key', '^(\\w{1,50})$', 1, 50, 50, 0),
('localtext', '', 1, 1431655765, 30, 1),
('markdown', '', 1, 1431655765, 30, 1),
('module', '^(\\w{1,3})$', 3, 3, 3, 0),
('password', '', 1, 255, 30, 0),
('richtext', '', 1, 1431655765, 30, 1),
('search', '', 3, 100, 30, 0),
('shortlocaltext', '', 1, 100, 30, 1),
('string', '', 1, 1431655765, 30, 1),
('telephone', '^([0-9+\\(\\)#\\.\\s\\/x-]+)$', 1, 30, 30, 0),
('text', '', 1, 1431655765, 30, 1),
('url', '', 1, 2083, 50, 0),
('yearmonth', '^([0-9]{4})-(1[0-2]|0[1-9])$', 6, 7, 7, 0),
('yearweek', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])$', 7, 8, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_wkt`
--

CREATE TABLE `ark_format_wkt` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_format_wkt`
--

INSERT INTO `ark_format_wkt` (`format`) VALUES
('geometry'),
('wkt');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_type`
--

CREATE TABLE `ark_fragment_type` (
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `compound` tinyint(1) NOT NULL DEFAULT '0',
  `tbl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_fragment_type`
--

INSERT INTO `ark_fragment_type` (`type`, `compound`, `tbl`, `format_class`, `model_class`, `form_class`, `enabled`, `deprecated`, `keyword`) VALUES
('blob', 0, 'ark_fragment_blob', 'ARK\\Model\\Format\\BlobFormat', 'ARK\\Model\\Fragment\\BlobFragment', '', 1, 0, 'fragment.blob'),
('boolean', 0, 'ark_fragment_boolean', 'ARK\\Model\\Format\\BooleanFormat', 'ARK\\Model\\Fragment\\BooleanFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', 1, 0, 'fragment.boolean'),
('date', 0, 'ark_fragment_date', 'ARK\\Model\\Format\\DateFormat', 'ARK\\Model\\Fragment\\DateFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', 1, 0, 'fragment.date'),
('datetime', 0, 'ark_fragment_datetime', 'ARK\\Model\\Format\\DateTimeFormat', 'ARK\\Model\\Fragment\\DateTimeFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateTimeType', 1, 0, 'fragment.datetime'),
('decimal', 0, 'ark_fragment_decimal', 'ARK\\Model\\Format\\DecimalFormat', 'ARK\\Model\\Fragment\\DecimalFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 1, 0, 'fragment.decimal'),
('float', 0, 'ark_fragment_float', 'ARK\\Model\\Format\\FloatFormat', 'ARK\\Model\\Fragment\\FloatFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 1, 0, 'fragment.float'),
('integer', 0, 'ark_fragment_integer', 'ARK\\Model\\Format\\IntegerFormat', 'ARK\\Model\\Fragment\\IntegerFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', 1, 0, 'fragment.integer'),
('item', 0, 'ark_fragment_item', 'ARK\\Model\\Format\\ItemFormat', 'ARK\\Model\\Fragment\\ItemFragment', '', 1, 0, 'fragment.item'),
('object', 1, 'ark_fragment_object', 'ARK\\Model\\Format\\ObjectFormat', 'ARK\\Model\\Fragment\\ObjectFragment', '', 1, 0, 'fragment.object'),
('string', 0, 'ark_fragment_string', 'ARK\\Model\\Format\\StringFormat', 'ARK\\Model\\Fragment\\StringFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 1, 0, 'fragment.string'),
('text', 0, 'ark_fragment_text', 'ARK\\Model\\Format\\TextFormat', 'ARK\\Model\\Fragment\\TextFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextAreaType', 1, 0, 'fragment.text'),
('time', 0, 'ark_fragment_time', 'ARK\\Model\\Format\\TimeFormat', 'ARK\\Model\\Fragment\\TimeFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', 1, 0, 'fragment.time'),
('wkt', 0, 'ark_fragment_wkt', 'ARK\\Model\\Format\\WktFormat', 'ARK\\Model\\Fragment\\WktFragment', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 1, 0, 'fragment.geometry');

-- --------------------------------------------------------

--
-- Table structure for table `ark_module`
--

CREATE TABLE `ark_module` (
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resource` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namespace` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL,
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_module`
--

INSERT INTO `ark_module` (`module`, `resource`, `namespace`, `entity`, `tbl`, `core`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'aktører', 'ARK', 'ARK\\Entity\\Actor', 'ark_item_actor', 1, 1, 0, 'module.actor'),
('campaign', 'campaigns', 'DIME', 'DIME\\Entity\\Campaign', 'ark_item_campaign', 0, 1, 0, 'dime.campaign'),
('file', 'filer', 'ARK', 'ARK\\File\\File', 'ark_item_file', 1, 1, 0, 'module.file'),
('find', 'fund', 'DIME', 'DIME\\Entity\\Find', 'ark_item_find', 0, 1, 0, 'dime.find'),
('image', 'images', 'DIME', 'DIME\\Entity\\Image', 'ark_item_image', 0, 1, 0, 'dime.image'),
('locality', 'lokalitet', 'DIME', 'DIME\\Entity\\Locality', 'ark_item_locality', 0, 1, 0, 'dime.locality'),
('page', '', 'ARK', 'ARK\\Entity\\Page', 'ark_item_page', 1, 1, 0, 'module.page');

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
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema`
--

INSERT INTO `ark_schema` (`schma`, `module`, `generator`, `sequence`, `type`, `type_vocabulary`, `type_entities`, `enabled`, `deprecated`, `keyword`) VALUES
('core.file', 'file', 'ARK\\ORM\\Id\\IdentityGenerator', NULL, 'type', 'core.file.type', 1, 1, 0, 'core.schema.file'),
('core.page', 'page', '', '', '', '', 0, 1, 0, 'core.schema.page'),
('dime.actor', 'actor', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 'type', 'dime.actor.type', 1, 1, 0, 'dime.schema.actor'),
('dime.campaign', 'campaign', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'dime.schema.campaign'),
('dime.find', 'find', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 'type', 'dime.find.type', 0, 1, 0, 'dime.schema.find'),
('dime.image', 'image', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'dime.schema.image'),
('dime.locality', 'locality', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', NULL, NULL, 0, 1, 0, 'dime.schema.locality');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_association`
--

CREATE TABLE `ark_schema_association` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` int(11) NOT NULL,
  `inverse` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inverse_degree` int(11) NOT NULL,
  `bidirectional` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_association`
--

INSERT INTO `ark_schema_association` (`schma`, `type`, `association`, `degree`, `inverse`, `inverse_degree`, `bidirectional`, `enabled`, `deprecated`, `keyword`) VALUES
('dime.locality', '', 'campaigns', 1, 'dime.campaign', 0, 1, 1, 0, 'dime.association.campaigns');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_schema_attribute`
--

INSERT INTO `ark_schema_attribute` (`schma`, `type`, `attribute`, `format`, `vocabulary`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('core.file', '', 'description', 'localtext', NULL, 0, 1, 1, 0, 1, 0, 'core.file.description'),
('core.file', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.id'),
('core.file', '', 'mediatype', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.mediatype'),
('core.file', '', 'status', 'identifier', 'core.file.status', 1, 1, 1, 0, 1, 0, 'core.file.status'),
('core.file', '', 'title', 'shortlocaltext', NULL, 1, 1, 1, 0, 1, 0, 'core.file.title'),
('core.file', '', 'type', 'identifier', 'core.file.type', 1, 1, 1, 0, 1, 0, 'core.file.type'),
('core.file', '', 'versions', 'fileversion', NULL, 1, 0, 1, 0, 1, 0, 'core.file.versions'),
('core.page', '', 'content', 'html', NULL, 1, 1, 1, 0, 1, 0, 'property.content'),
('core.page', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.page.id'),
('dime.actor', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.id'),
('dime.actor', '', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.type'),
('dime.actor', 'museum', 'fullname', 'shortlocaltext', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.fullname'),
('dime.actor', 'museum', 'kommuner', 'identifier', 'dime.denmark.kommune', 0, 0, 1, 0, 1, 0, 'dime.actor.kommuner'),
('dime.actor', 'museum', 'shortname', 'shortlocaltext', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.shortname'),
('dime.find', '', 'condition', 'identifier', 'dime.find.condition', 0, 1, 1, 0, 1, 0, 'dime.find.condition'),
('dime.find', '', 'description', 'localtext', NULL, 0, 1, 1, 0, 1, 0, 'property.description'),
('dime.find', '', 'finddate', 'date', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.finddate'),
('dime.find', '', 'finder_id', 'identifier', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.finderid'),
('dime.find', '', 'findpoint', 'geometry', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.findpoint'),
('dime.find', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.id'),
('dime.find', '', 'image', 'string', NULL, 1, 0, 1, 1, 1, 0, 'dime.find.images'),
('dime.find', '', 'kommune', 'identifier', 'dime.denmark.kommune', 1, 1, 1, 0, 1, 0, 'dime.find.kommune'),
('dime.find', '', 'length', 'distance', 'distance', 0, 1, 1, 0, 1, 0, 'dime.find.length'),
('dime.find', '', 'material', 'identifier', 'dime.material', 1, 1, 1, 0, 1, 0, 'dime.find.material'),
('dime.find', '', 'museum', 'item', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.type.museum'),
('dime.find', '', 'period_end', 'identifier', 'dime.period', 0, 1, 1, 0, 1, 0, 'dime.find.period.end'),
('dime.find', '', 'period_start', 'identifier', 'dime.period', 0, 1, 1, 0, 1, 0, 'dime.find.period.start'),
('dime.find', '', 'registered_id', 'identifier', NULL, 0, 1, 1, 0, 1, 0, 'property.registeredid'),
('dime.find', '', 'secondary', 'identifier', 'dime.find.secondary', 0, 0, 1, 0, 1, 0, 'dime.find.material.secondary'),
('dime.find', '', 'subtype', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.subtype'),
('dime.find', '', 'treasure', 'identifier', 'dime.treasure', 1, 1, 1, 0, 1, 0, 'dime.find.treasure'),
('dime.find', '', 'type', 'identifier', 'dime.find.type', 1, 1, 1, 0, 1, 0, 'dime.find.type'),
('dime.find', '', 'weight', 'mass', 'mass', 0, 1, 1, 0, 1, 0, 'property.weight'),
('dime.image', '', 'name', 'shortlocaltext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('dime.locality', '', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.id'),
('dime.locality', '', 'name', 'shortlocaltext', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.name'),
('dime.locality', '', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.type');

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
('dime.about', 'dime', 0, 0),
('dime.about.background', 'dime', 0, 0),
('dime.about.groups', 'dime', 0, 0),
('dime.about.hevn', 'dime', 0, 0),
('dime.about.hevntext', 'dime', 0, 0),
('dime.about.instructions', 'dime', 0, 0),
('dime.about.museums', 'dime', 0, 0),
('dime.about.partners', 'dime', 0, 0),
('dime.actor.fullname', 'dime', 0, 0),
('dime.actor.id', 'dime', 0, 0),
('dime.actor.kommuner', 'dime', 0, 0),
('dime.actor.shortname', 'dime', 0, 0),
('dime.actor.type', 'dime', 0, 0),
('dime.association.campaigns', 'dime', 0, 0),
('dime.background', 'dime', 0, 0),
('dime.campaign', 'dime', 0, 0),
('dime.copyright', 'dime', 0, 0),
('dime.credits', 'dime', 0, 0),
('dime.denmark.kommune', 'dime', 0, 0),
('dime.detector', 'dime', 0, 0),
('dime.exhibits', 'dime', 0, 0),
('dime.exhibits.forests', 'dime', 0, 0),
('dime.exhibits.weapons', 'dime', 0, 0),
('dime.find', 'dime', 0, 0),
('dime.find.add', 'dime', 0, 0),
('dime.find.condition', 'dime', 0, 0),
('dime.find.condition.modified', 'dime', 0, 0),
('dime.find.condition.unfinished', 'dime', 0, 0),
('dime.find.finddate', 'dime', 0, 0),
('dime.find.finderid', 'dime', 0, 0),
('dime.find.findpoint', 'dime', 0, 0),
('dime.find.id', 'dime', 0, 0),
('dime.find.kommune', 'dime', 0, 0),
('dime.find.length', 'dime', 0, 0),
('dime.find.material', 'dime', 0, 0),
('dime.find.material.secondary', 'dime', 0, 0),
('dime.find.period.end', 'dime', 0, 0),
('dime.find.period.start', 'dime', 0, 0),
('dime.find.save', 'dime', 0, 0),
('dime.find.search', 'dime', 0, 0),
('dime.find.subtype', 'dime', 0, 0),
('dime.find.treasure', 'dime', 0, 0),
('dime.find.type', 'dime', 0, 0),
('dime.home', 'dime', 0, 0),
('dime.home.alarm', 'dime', 0, 0),
('dime.home.faq', 'dime', 0, 0),
('dime.home.hvert', 'dime', 0, 0),
('dime.home.welcome', 'dime', 0, 0),
('dime.krogager', 'dime', 0, 0),
('dime.locality', 'dime', 0, 0),
('dime.locality.add', 'dime', 0, 0),
('dime.locality.id', 'dime', 0, 0),
('dime.locality.search', 'dime', 0, 0),
('dime.locality.type', 'dime', 0, 0),
('dime.material', 'dime', 0, 0),
('dime.material.silver', 'dime', 0, 0),
('dime.metaldetector', 'dime', 0, 0),
('dime.news', 'dime', 0, 0),
('dime.period', 'dime', 0, 0),
('dime.research', 'dime', 0, 0),
('dime.save', 'dime', 0, 0),
('dime.schema.find', 'dime', 0, 0),
('dime.schema.image', 'dime', 0, 0),
('dime.schema.location', 'dime', 0, 0),
('dime.search', 'dime', 0, 0),
('dime.search.finds.mine', 'dime', 0, 0),
('dime.supportedby', 'dime', 0, 0),
('dime.treasure', 'dime', 0, 0),
('dime.user.login', 'dime', 0, 0),
('dime.user.name', 'dime', 0, 0),
('dime.user.password', 'dime', 0, 0),
('dime.user.password.forgot', 'dime', 0, 0),
('dime.user.register', 'dime', 0, 0),
('file.type.audio', 'core', 0, 0),
('file.type.document', 'core', 0, 0),
('file.type.image', 'core', 0, 0),
('file.type.other', 'core', 0, 0),
('file.type.text', 'core', 0, 0),
('file.type.video', 'core', 0, 0),
('form.select.optional', 'dime', 0, 0),
('form.select.required', 'dime', 0, 0),
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
('lat', 'dime', 0, 0),
('lon', 'dime', 0, 0),
('map.layer.aerial', 'dime', 0, 0),
('map.layer.aerial.labels', 'dime', 0, 0),
('map.layer.foraar', 'dime', 0, 0),
('map.layer.road', 'dime', 0, 0),
('map.layer.skaermkort', 'dime', 0, 0),
('map.style.choropleth', 'dime', 0, 0),
('map.style.distribution', 'dime', 0, 0),
('module.actor', 'core', 0, 0),
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
('search.placeholder', 'core', 0, 0),
('site.brand', 'core', 0, 0),
('site.welcome', 'core', 0, 0),
('test.test', 'dime', 0, 0),
('user.greeting', 'user', 0, 1),
('user.menu.edit', 'user', 0, 0),
('user.menu.home', 'dime', 0, 0),
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
('dime', 'translation.domain.dime'),
('markup', 'translation.domain.markup'),
('user', 'translation.domain.user'),
('vocabulary', 'translation.domain.vocabulary');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_language`
--

CREATE TABLE `ark_translation_language` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `markup` tinyint(1) NOT NULL,
  `vocabulary` tinyint(1) NOT NULL,
  `text` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_language`
--

INSERT INTO `ark_translation_language` (`language`, `markup`, `vocabulary`, `text`) VALUES
('da', 1, 1, 1),
('en', 1, 1, 1),
('en-GB', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation_message`
--

CREATE TABLE `ark_translation_message` (
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_message`
--

INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('da', 'dime.about', 'default', 'Om DIME', ''),
('da', 'dime.about.background', 'default', 'Baggrund for DIME', ''),
('da', 'dime.about.groups', 'default', 'Detektorforeninger', ''),
('da', 'dime.about.hevn', 'default', 'Hvem Er DIME?', ''),
('da', 'dime.about.hevntext', 'default', 'DIME er en fællesportal for detektorbrugere og Danske museer, der kan bruges af alle.', ''),
('da', 'dime.about.instructions', 'default', 'Vejledning', ''),
('da', 'dime.about.museums', 'default', 'Deltagende Museer', ''),
('da', 'dime.about.partners', 'default', 'Samarbejdspartnere', ''),
('da', 'dime.actor.fullname', 'default', 'Navn', ''),
('da', 'dime.actor.id', 'default', 'Aktører ID', ''),
('da', 'dime.actor.kommuner', 'default', 'Kommuner', ''),
('da', 'dime.actor.shortname', 'default', 'Kort Navn', ''),
('da', 'dime.actor.type', 'default', 'Type', ''),
('da', 'dime.background', 'default', 'Baggrund', ''),
('da', 'dime.copyright', 'default', 'Copyright © 2013-2017 Arkæologisk IT, Aarhus Universitet', ''),
('da', 'dime.credits', 'default', 'Datastruktur og support: Carsten Risager | Design: Casper Skaaning Andersen | Udvikling: L ~ P Archaeology', ''),
('da', 'dime.denmark.kommune', 'default', 'Kommune', ''),
('da', 'dime.detector', 'default', 'Metaldetektorbrug & Danefæ', ''),
('da', 'dime.exhibits', 'default', 'Digitale Udstillinger', ''),
('da', 'dime.exhibits.forests', 'default', 'Guld og Grønne Skove', ''),
('da', 'dime.exhibits.weapons', 'default', 'Våben i Bronzealder', ''),
('da', 'dime.find', 'default', 'Fund', ''),
('da', 'dime.find.add', 'default', 'Opret Fund', ''),
('da', 'dime.find.condition', 'default', 'Bevaring', ''),
('da', 'dime.find.condition.modified', 'default', 'Modificeret', ''),
('da', 'dime.find.condition.unfinished', 'default', 'Ufærdige', ''),
('da', 'dime.find.finddate', 'default', 'Vælg Dato', ''),
('da', 'dime.find.finderid', 'default', 'Fund ID', ''),
('da', 'dime.find.findpoint', 'default', 'Koordinater', ''),
('da', 'dime.find.id', 'default', 'DIME ID', ''),
('da', 'dime.find.kommune', 'default', 'Kommune', ''),
('da', 'dime.find.length', 'default', 'Maximal Længde / Diameter', ''),
('da', 'dime.find.material', 'default', 'Materiale', ''),
('da', 'dime.find.material.secondary', 'default', 'Sekundært Materiale(r)', ''),
('da', 'dime.find.period.end', 'default', 'Periode Slut', ''),
('da', 'dime.find.period.start', 'default', 'Periode', ''),
('da', 'dime.find.search', 'default', 'Søg Fund', ''),
('da', 'dime.find.treasure', 'default', 'Danefæ', ''),
('da', 'dime.find.type', 'default', 'Type', ''),
('da', 'dime.home', 'default', 'Hjem', ''),
('da', 'dime.home.alarm', 'default', 'Underretninger', ''),
('da', 'dime.home.faq', 'default', '<dl>\\n\\n<dt>Hvem Er DIME?</dt>\\n<dd>DIME er en fællesportal for detektorbrugere og Danske museer, der kan bruges af alle.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Hvorfor skal jeg bruge dime?</dt>\\n<dd>DIME muliggør en hurtigere behandling af dinefund i samarbejde med museet og giver dig overblik over dine fund og fundpladser.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Hvilke fund skal/kan uploades i DIME?</dt>\\n<dd>Alle detektorfund (ikke kun Danefæ) kan uploades i DIME.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Kan andre se mine fundsteder?</dt>\\n<dd>Nej! Fundsteder og privatoplysninger er kunsynlige for museumsarkæologer og forskere med særlig adgang</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Findes der en dime-app?</dt>\\n<dd>En app-løsning til registrering i marken er under udvikling.</dd>\\n\\n</dl>', ''),
('da', 'dime.home.hvert', 'default', 'Hvert år finder metaldetektorbrugere landet over tusindevis af genstande fra oldtid, middelal-der og senere perioder. Metalgenstandene er en del af vores fælles kulturarv og vigtige brikker i Danmarkshistorien. DIME sikrer oplysninger om fundene til gavn for nulevende og efterføl- gende generatione', ''),
('da', 'dime.home.welcome', 'default', 'Velkommen %name%', ''),
('da', 'dime.krogager', 'default', 'KrogagerFonden', ''),
('da', 'dime.locality', 'default', 'Lokalitet', ''),
('da', 'dime.locality.add', 'default', 'Opret Lokalitet', ''),
('da', 'dime.locality.id', 'default', 'DIME ID', ''),
('da', 'dime.locality.search', 'default', 'Søg Lokalitet', ''),
('da', 'dime.locality.type', 'default', 'Type', ''),
('da', 'dime.material', 'default', 'Materiale', ''),
('da', 'dime.material.silver', 'default', 'Silver Test', ''),
('da', 'dime.metaldetector', 'default', 'Metaldetektorbrug I Danmark', ''),
('da', 'dime.news', 'default', 'Nyheder', ''),
('da', 'dime.period', 'default', 'Periode', ''),
('da', 'dime.research', 'default', 'Forskning', ''),
('da', 'dime.save', 'default', 'Gem', ''),
('da', 'dime.search', 'default', 'Søg', ''),
('da', 'dime.search.finds.mine', 'default', 'Mine Fund', ''),
('da', 'dime.supportedby', 'default', 'støttet af', ''),
('da', 'dime.treasure', 'default', 'Danefæ', ''),
('da', 'dime.user.login', 'default', 'Login', ''),
('da', 'dime.user.name', 'default', 'Brugernavn', ''),
('da', 'dime.user.password', 'default', 'Password', ''),
('da', 'dime.user.password.forgot', 'default', 'Glemt Password?', ''),
('da', 'dime.user.register', 'default', 'Ny Bruger?', ''),
('da', 'form.select.optional', 'default', 'valgfri', ''),
('da', 'form.select.required', 'default', 'påkrævet', ''),
('da', 'lat', 'default', 'Breddegrad', ''),
('da', 'lon', 'default', 'Længde', ''),
('da', 'map.layer.aerial', 'default', 'Satellit', ''),
('da', 'map.layer.aerial.labels', 'default', 'Satellit med etiketter', ''),
('da', 'map.layer.foraar', 'default', 'Foraar', ''),
('da', 'map.layer.road', 'default', 'Vej', ''),
('da', 'map.layer.skaermkort', 'default', 'Skærmkort', ''),
('da', 'map.style.choropleth', 'default', 'Choropleth', ''),
('da', 'map.style.distribution', 'default', 'Fordeling', ''),
('da', 'module.actor', 'default', 'Aktører', ''),
('da', 'module.file', 'default', 'Filer', ''),
('da', 'property.description', 'default', 'Beskrivelse', ''),
('da', 'property.weight', 'default', 'Vægt', ''),
('da', 'search.placeholder', 'default', 'Fritekstsøgning', ''),
('da', 'site.brand', 'default', 'DIME', ''),
('da', 'user.greeting', 'default', 'Logged In %name%', ''),
('da', 'user.menu.edit', 'default', 'Rediger Bruger', ''),
('da', 'user.menu.home', 'default', 'Min Side', ''),
('da', 'user.menu.login', 'default', 'Login', ''),
('en', 'association.contact', 'default', 'Contact', ''),
('en', 'core.actor.institution', 'default', 'Institution', ''),
('en', 'core.actor.person', 'default', 'Person', ''),
('en', 'dime.about', 'default', 'About DIME', ''),
('en', 'dime.about.background', 'default', 'Background for DIME', ''),
('en', 'dime.about.groups', 'default', 'Detectorist Associations', ''),
('en', 'dime.about.hevn', 'default', 'What is DIME?', ''),
('en', 'dime.about.hevntext', 'default', 'DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.', ''),
('en', 'dime.about.instructions', 'default', 'Instructions', ''),
('en', 'dime.about.museums', 'default', 'Participating Museums', ''),
('en', 'dime.about.partners', 'default', 'Partners', ''),
('en', 'dime.actor.fullname', 'default', 'Name', ''),
('en', 'dime.actor.id', 'default', 'Actor ID', ''),
('en', 'dime.actor.kommuner', 'default', 'Municipalities', ''),
('en', 'dime.actor.shortname', 'default', 'Short Name', ''),
('en', 'dime.actor.type', 'default', 'Type', ''),
('en', 'dime.association.campaigns', 'default', 'Campaigns', ''),
('en', 'dime.background', 'default', 'Background', ''),
('en', 'dime.campaign', 'default', 'Campaign', ''),
('en', 'dime.copyright', 'default', 'Copyright © 2013-2017 Arkæologisk IT, Aarhus University', ''),
('en', 'dime.credits', 'default', 'Data modelling and support: Carsten Risager | Design: Casper Skaaning Anderson | Implementation: L ~ P Archaeology', ''),
('en', 'dime.denmark.kommune', 'default', 'Municipalities', ''),
('en', 'dime.detector', 'default', 'Detectorists & Treasure Trove', ''),
('en', 'dime.exhibits', 'default', 'Digital Exhibits', ''),
('en', 'dime.exhibits.forests', 'default', 'Gold and Green Forests', ''),
('en', 'dime.exhibits.weapons', 'default', 'Weapons in the Bronze Age', ''),
('en', 'dime.find', 'default', 'Find', ''),
('en', 'dime.find.add', 'default', 'Add Find', ''),
('en', 'dime.find.condition', 'default', 'Condition', ''),
('en', 'dime.find.condition.modified', 'default', 'Modified', ''),
('en', 'dime.find.condition.unfinished', 'default', 'Unfinished', ''),
('en', 'dime.find.finddate', 'default', 'Find Date', 'DIME Find Find Date'),
('en', 'dime.find.finderid', 'default', 'Find ID', 'DIME Find Finder\'s ID'),
('en', 'dime.find.findpoint', 'default', 'Coordinates', ''),
('en', 'dime.find.id', 'default', 'ID', 'DIME Find ID'),
('en', 'dime.find.kommune', 'default', 'Municipality', ''),
('en', 'dime.find.length', 'default', 'Maximum Dimension', ''),
('en', 'dime.find.material', 'default', 'Material', 'DIME Find Material'),
('en', 'dime.find.material.secondary', 'default', 'Secondary Material(s)', 'DIME Find Secondary Material(s)'),
('en', 'dime.find.period.end', 'default', 'End Period', 'DIME Find Period End'),
('en', 'dime.find.period.start', 'default', 'Period', 'DIME Find Period Start'),
('en', 'dime.find.save', 'default', 'Save', 'DIME Find Save button'),
('en', 'dime.find.search', 'default', 'Search Finds', ''),
('en', 'dime.find.subtype', 'default', 'Subtype', 'DIME Find Subtype'),
('en', 'dime.find.treasure', 'default', 'Treasure', ''),
('en', 'dime.find.type', 'default', 'Type', 'DIME Find Type'),
('en', 'dime.home', 'default', 'Home', ''),
('en', 'dime.home.alarm', 'default', 'Notifications', ''),
('en', 'dime.home.faq', 'default', '<dl>\\n\\n<dt>What is DIME?</dt>\\n<dd>DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Why should I use DIME?</dt>\\n<dd>DIME allows faster processing of your finds in cooperation with the museum, and gives you an overview of your finds and collection.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>What finds can be added to DIME? </dt>\\n<dd>All detector finds (not only Danefæ) can added to DIME.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Can others see my find locations?</dt>\\n<dd>No! Find locations and other private information are only visible for museum archaeologists and researchers with special access.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Is there a DIME app?</dt>\\n<dd>An app for recording in the field is under development.</dd>\\n\\n</dl>', ''),
('en', 'dime.home.hvert', 'default', 'Every year, the metal detector users across the country thousands of objects from antiquity, middelal-there and later periods. Metal objects are part of our common cultural heritage and important pieces in the history of Denmark. DIME provides information about the finds for the benefit of present and subsequent generatione', ''),
('en', 'dime.home.welcome', 'default', 'Welcome %user%', ''),
('en', 'dime.krogager', 'default', 'KrogagerFonden', ''),
('en', 'dime.locality', 'default', 'Locality', ''),
('en', 'dime.locality.add', 'default', 'Add Locality', ''),
('en', 'dime.locality.id', 'default', 'DIME ID', ''),
('en', 'dime.locality.search', 'default', 'Search Localities', ''),
('en', 'dime.locality.type', 'default', 'Type', ''),
('en', 'dime.material', 'default', 'Material', ''),
('en', 'dime.material.silver', 'default', 'Silver Test1', ''),
('en', 'dime.metaldetector', 'default', 'Metal Detecting In Denmark', ''),
('en', 'dime.news', 'default', 'News', ''),
('en', 'dime.period', 'default', 'Period', ''),
('en', 'dime.research', 'default', 'Research', ''),
('en', 'dime.save', 'default', 'Save', ''),
('en', 'dime.schema.find', 'default', 'Find', ''),
('en', 'dime.schema.image', 'default', 'Image', ''),
('en', 'dime.schema.location', 'default', 'Location', ''),
('en', 'dime.search', 'default', 'Search', ''),
('en', 'dime.search.finds.mine', 'default', 'My Finds', ''),
('en', 'dime.supportedby', 'default', 'supported by', ''),
('en', 'dime.treasure', 'default', 'Treasure Trove', ''),
('en', 'dime.user.login', 'default', 'Login', ''),
('en', 'dime.user.name', 'default', 'User Name', ''),
('en', 'dime.user.password', 'default', 'Password', ''),
('en', 'dime.user.password.forgot', 'default', 'Forgotten Password?', ''),
('en', 'dime.user.register', 'default', 'New User?', ''),
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
('en', 'lat', 'default', 'Latitude', ''),
('en', 'lon', 'default', 'Longitude', ''),
('en', 'map.layer.aerial', 'default', 'Satellite', ''),
('en', 'map.layer.aerial.labels', 'default', 'Satellite with labels', ''),
('en', 'map.layer.foraar', 'default', 'Spring', ''),
('en', 'map.layer.road', 'default', 'Road', ''),
('en', 'map.layer.skaermkort', 'default', 'Display Card', ''),
('en', 'map.style.choropleth', 'default', 'Choropleth', ''),
('en', 'map.style.distribution', 'default', 'Distribution', ''),
('en', 'module.actor', 'default', 'Actor', ''),
('en', 'module.campaign', 'default', 'Campaign', ''),
('en', 'module.file', 'default', 'File', ''),
('en', 'module.find', 'default', 'Find', ''),
('en', 'module.image', 'default', 'Image', ''),
('en', 'module.location', 'default', 'Location', ''),
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
('en', 'search.placeholder', 'default', 'Free Text Search', ''),
('en', 'site.brand', 'default', 'DIME', ''),
('en', 'site.welcome', 'default', 'Welcome to DIME.', ''),
('en', 'test.test', 'default', 'text text', 'notes notes'),
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
('dime.home.welcome', 'name'),
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
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form` tinyint(1) NOT NULL DEFAULT '0',
  `form_root` tinyint(1) NOT NULL DEFAULT '0',
  `form_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_element`
--

INSERT INTO `ark_view_element` (`element`, `type`, `schma`, `item_type`, `attribute`, `class`, `template`, `form`, `form_root`, `form_type`, `editable`, `hidden`, `enabled`, `deprecated`, `keyword`) VALUES
('core_file_description', 'field', 'core.file', '', 'description', '', '', 0, 0, 'ARK\\Form\\Type\\LocalMultilineTextType', 1, 0, 1, 0, NULL),
('core_file_id', 'field', 'core.file', '', 'id', '', '', 0, 0, 'ARK\\Form\\Type\\IdType', 1, 0, 1, 0, NULL),
('core_file_item', 'grid', NULL, NULL, NULL, '', '', 0, 1, '', 1, 0, 1, 0, NULL),
('core_file_list', 'table', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('core_file_mediatype', 'field', 'core.file', '', 'mediatype', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('core_file_status', 'field', 'core.file', '', 'status', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('core_file_title', 'field', 'core.file', '', 'title', '', '', 0, 0, 'ARK\\Form\\Type\\LocalTextType', 1, 0, 1, 0, NULL),
('core_file_type', 'field', 'core.file', '', 'type', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('core_file_versions', 'field', 'core.file', '', 'versions', '', '', 0, 0, 'ARK\\Form\\Type\\FileVersionType', 1, 0, 1, 0, NULL),
('core_page_content', 'field', 'core.page', '', 'content', '', '', 0, 0, '', 0, 0, 1, 0, 'property.content'),
('core_page_view', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 0, 0, 1, 0, NULL),
('dime_actor_fullname', 'field', 'dime.actor', 'museum', 'fullname', '', '', 0, 0, 'ARK\\Form\\Type\\LocalTextType', 1, 0, 1, 0, NULL),
('dime_actor_id', 'field', 'dime.actor', '', 'id', '', '', 0, 0, 'ARK\\Form\\Type\\IdType', 1, 0, 1, 0, NULL),
('dime_actor_item', 'grid', NULL, NULL, NULL, '', '', 0, 1, '', 1, 0, 1, 0, NULL),
('dime_actor_kommuner', 'field', 'dime.actor', 'museum', 'kommuner', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_actor_list', 'table', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_actor_shortname', 'field', 'dime.actor', 'museum', 'shortname', '', '', 0, 0, 'ARK\\Form\\Type\\LocalTextType', 1, 0, 1, 0, NULL),
('dime_actor_type', 'field', 'dime.actor', '', 'type', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_action', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_add', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_blank', 'field', 'dime.find', '', '', '', '', 0, 0, '', 0, 0, 1, 0, NULL),
('dime_find_condition', 'field', 'dime.find', '', 'condition', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_coordinates', 'field', 'dime.find', '', 'coordinates', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_description', 'field', 'dime.find', '', 'description', '', '', 0, 0, 'ARK\\Form\\Type\\LocalMultilineTextType', 1, 0, 1, 0, NULL),
('dime_find_details', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_edit', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_event', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_filter', 'grid', NULL, NULL, NULL, '', '', 1, 1, '', 1, 0, 1, 0, 'dime.find.filter'),
('dime_find_filter_kommune', 'field', NULL, NULL, NULL, '', '', 0, 0, 'ARK\\Form\\Type\\VocabularyChoiceType', 1, 0, 1, 0, NULL),
('dime_find_filter_material', 'field', NULL, NULL, NULL, '', '', 0, 0, 'ARK\\Form\\Type\\VocabularyChoiceType', 1, 0, 1, 0, NULL),
('dime_find_filter_period', 'field', NULL, NULL, NULL, '', '', 0, 0, 'ARK\\Form\\Type\\VocabularyChoiceType', 1, 0, 1, 0, NULL),
('dime_find_filter_type', 'field', NULL, NULL, NULL, '', '', 0, 0, 'ARK\\Form\\Type\\VocabularyChoiceType', 1, 0, 1, 0, NULL),
('dime_find_finddate', 'field', 'dime.find', '', 'finddate', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_finder_id', 'field', 'dime.find', '', 'finder_id', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_findpoint', 'field', 'dime.find', '', 'findpoint', '', '', 0, 0, 'ARK\\Form\\Type\\WktType', 1, 0, 1, 0, NULL),
('dime_find_id', 'field', 'dime.find', '', 'id', '', '', 0, 0, 'ARK\\Form\\Type\\IdType', 1, 0, 1, 0, NULL),
('dime_find_image', 'field', 'dime.find', '', 'image', '', 'blocks/carouselfield.html.twig', 0, 0, 'ARK\\Form\\Type\\CarouselType', 1, 0, 1, 0, NULL),
('dime_find_item', 'grid', NULL, NULL, NULL, '', '', 1, 1, '', 1, 0, 1, 0, NULL),
('dime_find_kommune', 'field', 'dime.find', '', 'kommune', '', '', 0, 0, 'ARK\\Form\\Type\\ReadonlyVocabularyType', 1, 0, 1, 0, NULL),
('dime_find_length', 'field', 'dime.find', '', 'length', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_list', 'table', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_map', 'grid', NULL, NULL, NULL, '', 'blocks/map.html.twig', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_mappick', 'grid', NULL, NULL, NULL, '', 'blocks/mappick.html.twig', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_material', 'field', 'dime.find', '', 'material', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_museum', 'field', 'dime.find', '', 'museum', '', '', 0, 0, 'ARK\\Form\\Type\\ItemType', 1, 0, 1, 0, NULL),
('dime_find_period_end', 'field', 'dime.find', '', 'period_end', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_period_start', 'field', 'dime.find', '', 'period_start', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_registered_id', 'field', 'dime.find', '', 'registered_id', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_search', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_secondary', 'field', 'dime.find', '', 'secondary', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_subtype', 'field', 'dime.find', '', 'subtype', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_treasure', 'field', 'dime.find', '', 'treasure', '', '', 0, 0, 'ARK\\Form\\Type\\ReadonlyVocabularyType', 1, 0, 1, 0, NULL),
('dime_find_type', 'field', 'dime.find', '', 'type', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_find_weight', 'field', 'dime.find', '', 'weight', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_front_page', 'grid', 'dime.find', NULL, NULL, '', 'layouts/front.html.twig', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_home_action', 'grid', NULL, NULL, NULL, '', 'blocks/homeaction.html.twig', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_home_page', 'grid', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_locality_id', 'field', 'dime.locality', '', 'id', '', '', 0, 0, 'ARK\\Form\\Type\\IdType', 1, 0, 1, 0, NULL),
('dime_locality_item', 'grid', NULL, NULL, NULL, '', '', 0, 1, '', 1, 0, 1, 0, NULL),
('dime_locality_list', 'table', NULL, NULL, NULL, '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_locality_type', 'field', 'dime.locality', '', 'type', '', '', 0, 0, '', 1, 0, 1, 0, NULL),
('dime_save', 'field', NULL, NULL, NULL, '', '', 0, 0, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', 1, 0, 1, 0, 'dime.save'),
('dime_search', 'field', NULL, NULL, NULL, '', '', 0, 0, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', 1, 0, 1, 0, 'dime.search');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_layout`
--

CREATE TABLE `ark_view_layout` (
  `layout` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int(11) NOT NULL,
  `col` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cell` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` int(11) DEFAULT NULL,
  `label` tinyint(1) NOT NULL DEFAULT '1',
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_view_layout`
--

INSERT INTO `ark_view_layout` (`layout`, `row`, `col`, `seq`, `item_type`, `cell`, `width`, `label`, `editable`, `hidden`, `enabled`, `deprecated`) VALUES
('core_file_item', 0, 0, 0, '', 'core_file_id', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 0, 1, '', 'core_file_type', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 0, 2, '', 'core_file_mediatype', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 0, 3, '', 'core_file_title', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 0, 4, '', 'core_file_status', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 0, 5, '', 'core_file_description', NULL, 1, 1, 0, 1, 0),
('core_file_item', 0, 1, 1, '', 'dime_save', NULL, 1, 1, 0, 1, 0),
('core_file_list', 0, 0, 0, '', 'core_file_id', NULL, 1, 1, 0, 1, 0),
('core_file_list', 0, 0, 2, '', 'core_file_type', NULL, 1, 1, 0, 1, 0),
('core_page_view', 0, 0, 0, '', 'core_page_content', NULL, 1, 1, 0, 1, 0),
('dime_actor_item', 0, 0, 0, '', 'dime_actor_id', NULL, 1, 1, 0, 1, 0),
('dime_actor_item', 0, 0, 1, '', 'dime_actor_fullname', NULL, 1, 1, 0, 1, 0),
('dime_actor_item', 0, 0, 2, '', 'dime_actor_shortname', NULL, 1, 1, 0, 1, 0),
('dime_actor_item', 0, 0, 3, '', 'dime_actor_kommuner', NULL, 1, 1, 0, 1, 0),
('dime_actor_list', 0, 0, 0, '', 'dime_actor_id', NULL, 1, 1, 0, 1, 0),
('dime_actor_list', 0, 0, 1, '', 'dime_actor_type', NULL, 1, 1, 0, 1, 0),
('dime_actor_list', 0, 0, 2, '', 'dime_actor_fullname', NULL, 1, 1, 0, 1, 0),
('dime_find_action', 0, 0, 0, '', 'dime_save', NULL, 1, 1, 0, 1, 0),
('dime_find_add', 0, 0, 0, '', 'dime_find_event', NULL, 1, 1, 0, 1, 0),
('dime_find_add', 0, 1, 0, '', 'dime_find_details', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 0, '', 'dime_find_type', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 2, '', 'dime_find_period_start', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 4, '', 'dime_find_material', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 5, '', 'dime_find_secondary', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 6, '', 'dime_find_condition', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 7, '', 'dime_find_weight', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 8, '', 'dime_find_length', NULL, 1, 1, 0, 1, 0),
('dime_find_details', 0, 0, 9, '', 'dime_find_description', NULL, 1, 1, 0, 1, 0),
('dime_find_edit', 0, 0, 0, '', 'dime_find_event', NULL, 1, 1, 0, 1, 0),
('dime_find_edit', 0, 1, 0, '', 'dime_find_details', NULL, 1, 1, 0, 1, 0),
('dime_find_event', 0, 0, 0, '', 'dime_find_id', NULL, 1, 0, 0, 1, 0),
('dime_find_event', 0, 0, 2, '', 'dime_find_finder_id', NULL, 1, 1, 0, 1, 0),
('dime_find_event', 0, 0, 3, '', 'dime_find_finddate', NULL, 1, 1, 0, 1, 0),
('dime_find_event', 0, 0, 4, '', 'dime_find_mappick', NULL, 1, 1, 0, 1, 0),
('dime_find_event', 0, 0, 6, '', 'dime_find_kommune', NULL, 1, 0, 0, 1, 0),
('dime_find_event', 0, 0, 7, '', 'dime_find_museum', NULL, 1, 0, 0, 1, 0),
('dime_find_event', 0, 0, 8, '', 'dime_find_treasure', NULL, 1, 0, 0, 1, 0),
('dime_find_filter', 0, 0, 0, '', 'dime_find_filter_kommune', NULL, 0, 1, 0, 1, 0),
('dime_find_filter', 0, 1, 0, '', 'dime_find_filter_type', NULL, 0, 1, 0, 1, 0),
('dime_find_filter', 0, 2, 0, '', 'dime_find_filter_period', NULL, 0, 1, 0, 1, 0),
('dime_find_filter', 0, 3, 0, '', 'dime_find_filter_material', NULL, 0, 1, 0, 1, 0),
('dime_find_filter', 0, 4, 0, '', 'dime_search', NULL, 0, 1, 0, 1, 0),
('dime_find_item', 0, 0, 0, '', 'dime_find_event', NULL, 0, 1, 0, 1, 0),
('dime_find_item', 0, 0, 1, '', 'dime_find_image', NULL, 0, 1, 0, 1, 0),
('dime_find_item', 0, 1, 0, '', 'dime_find_details', NULL, 0, 1, 0, 1, 0),
('dime_find_item', 0, 1, 1, '', 'dime_save', NULL, 1, 1, 0, 1, 0),
('dime_find_list', 0, 0, 0, '', 'dime_find_id', NULL, 1, 1, 0, 1, 0),
('dime_find_list', 0, 0, 1, '', 'dime_find_finder_id', NULL, 1, 1, 0, 1, 0),
('dime_find_list', 0, 0, 2, '', 'dime_find_type', NULL, 1, 1, 0, 1, 0),
('dime_find_list', 0, 0, 4, '', 'dime_find_material', NULL, 1, 1, 0, 1, 0),
('dime_find_map', 0, 0, 0, '', 'dime_find_id', NULL, 1, 1, 0, 1, 0),
('dime_find_map', 0, 0, 1, '', 'dime_find_findpoint', NULL, 1, 1, 0, 1, 0),
('dime_find_mappick', 0, 0, 0, '', 'dime_find_findpoint', NULL, 1, 1, 0, 1, 0),
('dime_find_search', 0, 0, 0, '', 'dime_find_filter', NULL, 1, 1, 0, 1, 0),
('dime_find_search', 1, 0, 0, '', 'dime_find_list', NULL, 1, 1, 0, 1, 0),
('dime_find_search', 1, 1, 0, '', 'dime_find_map', NULL, 1, 1, 0, 1, 0),
('dime_front_page', 0, 0, 0, '', 'dime_find_id', NULL, 1, 1, 0, 1, 0),
('dime_front_page', 0, 0, 1, '', 'dime_find_finder_id', NULL, 1, 1, 0, 1, 0),
('dime_front_page', 0, 0, 2, '', 'dime_find_type', NULL, 1, 1, 0, 1, 0),
('dime_front_page', 0, 0, 4, '', 'dime_find_material', NULL, 1, 1, 0, 1, 0),
('dime_home_page', 0, 0, 0, '', 'dime_home_action', NULL, 1, 1, 0, 1, 0),
('dime_home_page', 1, 0, 0, '', 'dime_find_list', NULL, 1, 1, 0, 1, 0),
('dime_home_page', 1, 1, 0, '', 'dime_find_map', NULL, 1, 1, 0, 1, 0),
('dime_locality_item', 0, 0, 0, '', 'dime_locality_id', NULL, 1, 1, 0, 1, 0),
('dime_locality_item', 0, 0, 1, '', 'dime_locality_type', NULL, 1, 1, 0, 1, 0),
('dime_locality_item', 0, 1, 1, '', 'dime_save', NULL, 1, 1, 0, 1, 0),
('dime_locality_list', 0, 0, 0, '', 'dime_locality_id', NULL, 1, 1, 0, 1, 0),
('dime_locality_list', 0, 0, 1, '', 'dime_locality_type', NULL, 1, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_option`
--

CREATE TABLE `ark_view_option` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_option`
--

INSERT INTO `ark_view_option` (`element`, `name`, `type`, `value`) VALUES
('dime_find_condition', 'expanded', 'boolean', 'b:1;'),
('dime_find_filter_kommune', 'label_class', 'null', 'N;'),
('dime_find_filter_kommune', 'multiple', 'boolean', 'b:1;'),
('dime_find_filter_material', 'multiple', 'boolean', 'b:1;'),
('dime_find_filter_period', 'multiple', 'boolean', 'b:1;'),
('dime_find_filter_type', 'multiple', 'boolean', 'b:1;'),
('dime_find_secondary', 'expanded', 'boolean', 'b:1;');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_type`
--

CREATE TABLE `ark_view_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` tinyint(1) NOT NULL DEFAULT '0',
  `form` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_view_type`
--

INSERT INTO `ark_view_type` (`type`, `class`, `layout`, `form`, `template`, `keyword`) VALUES
('field', 'ARK\\View\\Field', 0, 'ARK\\Form\\Type\\PropertyType', 'layouts/field.html.twig', ''),
('grid', 'ARK\\View\\Grid', 1, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 'layouts/grid.html.twig', ''),
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
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary`
--

INSERT INTO `ark_vocabulary` (`concept`, `type`, `source`, `closed`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('core.file.status', 'list', 'ARK Core', 1, 1, 0, 'vocabulary.file.status', 'File Status'),
('core.file.type', 'list', 'ARK Core', 1, 1, 0, 'vocabulary.file.type', 'File Type'),
('country', 'list', 'ISO3166', 1, 1, 0, 'vocabulary.country', 'ISO Country Codes'),
('crs', 'list', 'EPSG', 1, 1, 0, 'vocabulary.crs', 'Coordinate Reference System'),
('dime.actor.type', 'list', 'DIME', 1, 1, 0, 'dime.actor.type', 'DIME Actor Type'),
('dime.denmark.admin', 'taxonomy', 'DIME', 1, 1, 0, 'vocabulary.dime.denmark.admin', 'Danish NUTS and LAU Administrative Unit Hierarchy'),
('dime.denmark.kommune', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.denmark.kommune', 'Danish LAU-1 Kommune (Municipality) List'),
('dime.denmark.region', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.denmark.region', 'Danish NUTS2 Region List'),
('dime.find.condition', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.find.condition', 'DIME Find Condition'),
('dime.find.secondary', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.find.secondary', 'DIME Secondary Materials List'),
('dime.find.type', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.type', 'DIME Find Type'),
('dime.material', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.material', 'DIME Material List'),
('dime.period', 'taxonomy', 'DIME', 1, 1, 0, 'vocabulary.dime.period', 'DIME Period Taxonomy'),
('dime.treasure', 'list', 'DIME', 1, 1, 0, 'vocabulary.dime.treasure', 'DIME Treasure Status'),
('distance', 'list', 'SI', 1, 1, 0, 'vocabulary.distance', 'SI Distance Units'),
('language', 'list', 'ISO639', 1, 1, 0, 'vocabulary.language', 'ISO Language Codes'),
('mass', 'list', 'SI', 1, 1, 0, 'vocabulary.mass', 'SI Mass Units');

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

--
-- Dumping data for table `ark_vocabulary_collected`
--

INSERT INTO `ark_vocabulary_collected` (`concept`, `collection`, `term`, `seq`) VALUES
('dime.period', '', 'XXXX', 95),
('dime.period', 'AÆEX', 'AÆEÆ', 3),
('dime.period', 'AÆEX', 'AÆEM', 4),
('dime.period', 'AÆEX', 'AÆEY', 6),
('dime.period', 'AÆKX', 'AÆKÆ', 9),
('dime.period', 'AÆKX', 'AÆKM', 10),
('dime.period', 'AÆKX', 'AÆKY', 12),
('dime.period', 'AÆMX', 'AÆMÆ', 13),
('dime.period', 'AÆMX', 'AÆMM', 14),
('dime.period', 'AÆMX', 'AÆMY', 16),
('dime.period', 'AÆPY', 'AÆAX', 1),
('dime.period', 'AÆPY', 'AÆBX', 2),
('dime.period', 'AÆPY', 'AÆFX', 7),
('dime.period', 'AÆPY', 'AÆHX', 8),
('dime.period', 'AMXX', 'AÆEX', 5),
('dime.period', 'AMXX', 'AÆKX', 11),
('dime.period', 'AMXX', 'AÆMX', 15),
('dime.period', 'ATM1', 'TM1A', 93),
('dime.period', 'ATM1', 'TM1B', 94),
('dime.period', 'AYEX', 'AYEÆ', 30),
('dime.period', 'AYEX', 'AYEM', 31),
('dime.period', 'AYEX', 'AYEY', 33),
('dime.period', 'AYSÆ', 'AYSÆ', 36),
('dime.period', 'AYSÆ', 'AYSY', 38),
('dime.period', 'AYTÆ', 'ATNA', 26),
('dime.period', 'AYTÆ', 'ATNB', 27),
('dime.period', 'AYTÆ', 'ATNC', 28),
('dime.period', 'AYTM', 'ATM1', 21),
('dime.period', 'AYTM', 'ATM2', 22),
('dime.period', 'AYTM', 'ATM3', 23),
('dime.period', 'AYTM', 'ATM4', 24),
('dime.period', 'AYTM', 'ATM5', 25),
('dime.period', 'AYTX', 'AYTÆ', 39),
('dime.period', 'AYTX', 'AYTM', 40),
('dime.period', 'AYXX', 'AYEX', 32),
('dime.period', 'AYXX', 'AYGX', 34),
('dime.period', 'AYXX', 'AYKX', 35),
('dime.period', 'AYXX', 'AYSX', 37),
('dime.period', 'AYXX', 'AYTX', 41),
('dime.period', 'BÆXX', 'BÆX1', 43),
('dime.period', 'BÆXX', 'BÆX2', 44),
('dime.period', 'BÆXX', 'BÆX3', 45),
('dime.period', 'BXXX', 'BÆXX', 46),
('dime.period', 'BXXX', 'BYXX', 51),
('dime.period', 'BYXX', 'BYX4', 48),
('dime.period', 'BYXX', 'BYX5', 49),
('dime.period', 'BYXX', 'BYX6', 50),
('dime.period', 'CÆFX', 'CÆFÆ', 52),
('dime.period', 'CÆFX', 'CÆFM', 53),
('dime.period', 'CÆFX', 'CÆFY', 55),
('dime.period', 'CÆRÆ', 'CÆRA', 56),
('dime.period', 'CÆRÆ', 'CÆRB', 58),
('dime.period', 'CÆRX', 'CÆRÆ', 57),
('dime.period', 'CÆRX', 'CÆRY', 63),
('dime.period', 'CÆRY', 'CÆRC', 59),
('dime.period', 'CÆRY', 'CÆRD', 60),
('dime.period', 'CÆRY', 'CÆRE', 61),
('dime.period', 'CÆXX', 'CÆFX', 54),
('dime.period', 'CÆXX', 'CÆRX', 62),
('dime.period', 'CXXX', 'CÆXX', 64),
('dime.period', 'CXXX', 'CYXX', 72),
('dime.period', 'CYGX', 'CYGÆ', 66),
('dime.period', 'CYGX', 'CYGY', 68),
('dime.period', 'CYVX', 'CYVÆ', 69),
('dime.period', 'CYVX', 'CYVY', 71),
('dime.period', 'CYXX', 'CYGX', 67),
('dime.period', 'CYXX', 'CYVX', 70),
('dime.period', 'DÆXX', 'DÆX1', 73),
('dime.period', 'DÆXX', 'DÆX2', 74),
('dime.period', 'DXXX', 'DÆXX', 75),
('dime.period', 'DXXX', 'DYXX', 80),
('dime.period', 'DYXX', 'DYX3', 77),
('dime.period', 'DYXX', 'DYX4', 78),
('dime.period', 'DYXX', 'DYX5', 79),
('dime.period', 'FXXX', 'FÆXX', 82),
('dime.period', 'FXXX', 'FMIN', 83),
('dime.period', 'FXXX', 'FMV1', 84),
('dime.period', 'FXXX', 'FMV2', 85),
('dime.period', 'FXXX', 'FMVM', 86),
('dime.period', 'FXXX', 'FYDI', 88),
('dime.period', 'FXXX', 'FYEL', 89),
('dime.period', 'FXXX', 'FYVE', 90),
('dime.period', 'HXXX', 'FXXX', 87),
('dime.period', 'OXXX', 'AÆPÆ', 17),
('dime.period', 'OXXX', 'AÆPM', 18),
('dime.period', 'OXXX', 'AÆPY', 19),
('dime.period', 'OXXX', 'AMXX', 20),
('dime.period', 'OXXX', 'AXXX', 29),
('dime.period', 'OXXX', 'AYXX', 42),
('dime.period', 'OXXX', 'BXXX', 47),
('dime.period', 'OXXX', 'CXXX', 65),
('dime.period', 'OXXX', 'DXXX', 76),
('dime.period', 'OXXX', 'EXXX', 81),
('dime.period', 'XXXX', 'HXXX', 91),
('dime.period', 'XXXX', 'OXXX', 92);

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_collection`
--

CREATE TABLE `ark_vocabulary_collection` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered` tinyint(1) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_vocabulary_parameter`
--

INSERT INTO `ark_vocabulary_parameter` (`concept`, `term`, `name`, `type`, `value`) VALUES
('core.file.type', 'audio', 'entity', 'string', 'ARK\\File\\Audio'),
('core.file.type', 'document', 'entity', 'string', 'ARK\\File\\Document'),
('core.file.type', 'image', 'entity', 'string', 'ARK\\File\\Image'),
('core.file.type', 'other', 'entity', 'string', 'ARK\\File\\File'),
('core.file.type', 'text', 'entity', 'string', 'ARK\\File\\Text'),
('core.file.type', 'video', 'entity', 'string', 'ARK\\File\\Video'),
('dime.period', 'AMXX', 'year_end', 'integer', '-3951'),
('dime.period', 'AMXX', 'year_start', 'integer', '-9000'),
('dime.period', 'AXXX', 'year_end', 'integer', '-1701'),
('dime.period', 'AXXX', 'year_start', 'integer', '-250000'),
('dime.period', 'AYXX', 'year_end', 'integer', '-1701'),
('dime.period', 'AYXX', 'year_start', 'integer', '-3950'),
('dime.period', 'BÆX1', 'year_end', 'integer', '-1501'),
('dime.period', 'BÆX1', 'year_start', 'integer', '-1700'),
('dime.period', 'BÆX2', 'year_end', 'integer', '-1301'),
('dime.period', 'BÆX2', 'year_start', 'integer', '-1500'),
('dime.period', 'BÆX3', 'year_end', 'integer', '-1101'),
('dime.period', 'BÆX3', 'year_start', 'integer', '-1300'),
('dime.period', 'BÆXX', 'year_end', 'integer', '-1101'),
('dime.period', 'BÆXX', 'year_start', 'integer', '-1700'),
('dime.period', 'BXXX', 'year_end', 'integer', '-501'),
('dime.period', 'BXXX', 'year_start', 'integer', '-1700'),
('dime.period', 'BYX4', 'year_end', 'integer', '-901'),
('dime.period', 'BYX4', 'year_start', 'integer', '-1100'),
('dime.period', 'BYX5', 'year_end', 'integer', '-701'),
('dime.period', 'BYX5', 'year_start', 'integer', '-900'),
('dime.period', 'BYX6', 'year_end', 'integer', '-501'),
('dime.period', 'BYX6', 'year_start', 'integer', '-700'),
('dime.period', 'BYXX', 'year_end', 'integer', '-501'),
('dime.period', 'BYXX', 'year_start', 'integer', '-1100'),
('dime.period', 'CÆFÆ', 'year_end', 'integer', '-401'),
('dime.period', 'CÆFÆ', 'year_start', 'integer', '-500'),
('dime.period', 'CÆFM', 'year_end', 'integer', '-101'),
('dime.period', 'CÆFM', 'year_start', 'integer', '-400'),
('dime.period', 'CÆFX', 'year_end', 'integer', '0'),
('dime.period', 'CÆFX', 'year_start', 'integer', '-500'),
('dime.period', 'CÆFY', 'year_end', 'integer', '0'),
('dime.period', 'CÆFY', 'year_start', 'integer', '-100'),
('dime.period', 'CÆRA', 'year_end', 'integer', '69'),
('dime.period', 'CÆRA', 'year_start', 'integer', '1'),
('dime.period', 'CÆRÆ', 'year_end', 'integer', '174'),
('dime.period', 'CÆRÆ', 'year_start', 'integer', '1'),
('dime.period', 'CÆRB', 'year_end', 'integer', '174'),
('dime.period', 'CÆRB', 'year_start', 'integer', '70'),
('dime.period', 'CÆRC', 'year_end', 'integer', '249'),
('dime.period', 'CÆRC', 'year_start', 'integer', '175'),
('dime.period', 'CÆRD', 'year_end', 'integer', '309'),
('dime.period', 'CÆRD', 'year_start', 'integer', '250'),
('dime.period', 'CÆRE', 'year_end', 'integer', '374'),
('dime.period', 'CÆRE', 'year_start', 'integer', '310'),
('dime.period', 'CÆRX', 'year_end', 'integer', '374'),
('dime.period', 'CÆRX', 'year_start', 'integer', '1'),
('dime.period', 'CÆRY', 'year_end', 'integer', '374'),
('dime.period', 'CÆRY', 'year_start', 'integer', '175'),
('dime.period', 'CÆXX', 'year_end', 'integer', '374'),
('dime.period', 'CÆXX', 'year_start', 'integer', '-500'),
('dime.period', 'CXXX', 'year_end', 'integer', '1066'),
('dime.period', 'CXXX', 'year_start', 'integer', '-500'),
('dime.period', 'CYGÆ', 'year_end', 'integer', '549'),
('dime.period', 'CYGÆ', 'year_start', 'integer', '375'),
('dime.period', 'CYGX', 'year_end', 'integer', '749'),
('dime.period', 'CYGX', 'year_start', 'integer', '375'),
('dime.period', 'CYGY', 'year_end', 'integer', '749'),
('dime.period', 'CYGY', 'year_start', 'integer', '549'),
('dime.period', 'CYVÆ', 'year_end', 'integer', '899'),
('dime.period', 'CYVÆ', 'year_start', 'integer', '750'),
('dime.period', 'CYVX', 'year_end', 'integer', '1066'),
('dime.period', 'CYVX', 'year_start', 'integer', '750'),
('dime.period', 'CYVY', 'year_end', 'integer', '1066'),
('dime.period', 'CYVY', 'year_start', 'integer', '900'),
('dime.period', 'CYXX', 'year_end', 'integer', '1066'),
('dime.period', 'CYXX', 'year_start', 'integer', '375'),
('dime.period', 'DÆXX', 'year_end', 'integer', '1199'),
('dime.period', 'DÆXX', 'year_start', 'integer', '1067'),
('dime.period', 'DXXX', 'year_end', 'integer', '1535'),
('dime.period', 'DXXX', 'year_start', 'integer', '1067'),
('dime.period', 'DYX3', 'year_end', 'integer', '1399'),
('dime.period', 'DYX3', 'year_start', 'integer', '1200'),
('dime.period', 'DYX4', 'year_end', 'integer', '1535'),
('dime.period', 'DYX4', 'year_start', 'integer', '1400'),
('dime.period', 'EXXX', 'year_end', 'integer', '1660'),
('dime.period', 'EXXX', 'year_start', 'integer', '1536'),
('dime.period', 'FÆXX', 'year_end', 'integer', '1848'),
('dime.period', 'FÆXX', 'year_start', 'integer', '1661'),
('dime.period', 'FMIN', 'year_end', 'integer', '1913'),
('dime.period', 'FMIN', 'year_start', 'integer', '1849'),
('dime.period', 'FMV1', 'year_end', 'integer', '1918'),
('dime.period', 'FMV1', 'year_start', 'integer', '1914'),
('dime.period', 'FMV2', 'year_end', 'integer', '1945'),
('dime.period', 'FMV2', 'year_start', 'integer', '1940'),
('dime.period', 'FMVM', 'year_end', 'integer', '1939'),
('dime.period', 'FMVM', 'year_start', 'integer', '1919'),
('dime.period', 'FXXX', 'year_start', 'integer', '1661'),
('dime.period', 'FYXX', 'year_start', 'integer', '1946'),
('dime.period', 'HXXX', 'year_start', 'integer', '1067'),
('dime.period', 'PALEO', 'year_end', 'integer', '-9001'),
('dime.period', 'PALEO', 'year_start', 'integer', '-250000'),
('dime.period', 'VEM', 'year_end', 'integer', '1199'),
('dime.period', 'VEM', 'year_start', 'integer', '750');

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
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_related`
--

INSERT INTO `ark_vocabulary_related` (`from_concept`, `from_term`, `to_concept`, `to_term`, `relation`, `depth`) VALUES
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK01', 'broader', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK02', 'broader', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK03', 'broader', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK04', 'broader', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK05', 'broader', 2),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '101', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '147', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '151', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '153', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '155', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '157', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '159', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '161', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '163', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '165', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '167', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '169', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '173', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '175', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '183', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '185', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '187', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '190', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '201', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '210', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '217', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '219', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '223', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '230', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '240', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '250', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '260', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '270', 'broader', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '400', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '253', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '259', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '265', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '269', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '306', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '316', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '320', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '326', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '329', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '330', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '336', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '340', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '350', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '360', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '370', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '376', 'broader', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '390', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '410', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '420', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '430', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '440', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '450', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '461', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '479', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '480', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '482', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '492', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '510', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '530', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '540', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '550', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '561', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '563', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '573', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '575', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '580', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '607', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '621', 'broader', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '630', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '615', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '657', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '661', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '665', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '671', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '706', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '707', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '710', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '727', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '730', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '740', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '741', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '746', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '751', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '756', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '760', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '766', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '779', 'broader', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '791', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '773', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '787', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '810', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '813', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '820', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '825', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '840', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '846', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '849', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '851', 'broader', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '860', 'broader', 3),
('dime.period', 'AXXX', 'dime.period', 'AMXX', 'broader', 2),
('dime.period', 'AXXX', 'dime.period', 'AXXX', 'broader', 1),
('dime.period', 'AXXX', 'dime.period', 'AYXX', 'broader', 2),
('dime.period', 'AXXX', 'dime.period', 'PALEO', 'broader', 2),
('dime.period', 'BÆXX', 'dime.period', 'BÆX1', 'broader', 3),
('dime.period', 'BÆXX', 'dime.period', 'BÆX2', 'broader', 3),
('dime.period', 'BÆXX', 'dime.period', 'BÆX3', 'broader', 3),
('dime.period', 'BXXX', 'dime.period', 'BÆXX', 'broader', 2),
('dime.period', 'BXXX', 'dime.period', 'BXXX', 'broader', 1),
('dime.period', 'BXXX', 'dime.period', 'BYXX', 'broader', 2),
('dime.period', 'BYXX', 'dime.period', 'BYX4', 'broader', 3),
('dime.period', 'BYXX', 'dime.period', 'BYX5', 'broader', 3),
('dime.period', 'BYXX', 'dime.period', 'BYX6', 'broader', 3),
('dime.period', 'CÆFX', 'dime.period', 'CÆFÆ', 'broader', 4),
('dime.period', 'CÆFX', 'dime.period', 'CÆFM', 'broader', 4),
('dime.period', 'CÆFX', 'dime.period', 'CÆFY', 'broader', 4),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRA', 'broader', 5),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRB', 'broader', 5),
('dime.period', 'CÆRX', 'dime.period', 'CÆRÆ', 'broader', 4),
('dime.period', 'CÆRX', 'dime.period', 'CÆRY', 'broader', 4),
('dime.period', 'CÆRY', 'dime.period', 'CÆRC', 'broader', 5),
('dime.period', 'CÆRY', 'dime.period', 'CÆRD', 'broader', 5),
('dime.period', 'CÆRY', 'dime.period', 'CÆRE', 'broader', 5),
('dime.period', 'CÆXX', 'dime.period', 'CÆFX', 'broader', 3),
('dime.period', 'CÆXX', 'dime.period', 'CÆRX', 'broader', 3),
('dime.period', 'CXXX', 'dime.period', 'CÆXX', 'broader', 2),
('dime.period', 'CXXX', 'dime.period', 'CXXX', 'broader', 1),
('dime.period', 'CXXX', 'dime.period', 'CYVX', 'broader', 2),
('dime.period', 'CXXX', 'dime.period', 'CYXX', 'broader', 2),
('dime.period', 'CYGX', 'dime.period', 'CYGÆ', 'broader', 4),
('dime.period', 'CYGX', 'dime.period', 'CYGY', 'broader', 4),
('dime.period', 'CYVX', 'dime.period', 'CYVÆ', 'broader', 4),
('dime.period', 'CYVX', 'dime.period', 'CYVY', 'broader', 4),
('dime.period', 'CYXX', 'dime.period', 'CYGX', 'broader', 3),
('dime.period', 'DXXX', 'dime.period', 'DÆXX', 'broader', 3),
('dime.period', 'DXXX', 'dime.period', 'DYX3', 'broader', 3),
('dime.period', 'DXXX', 'dime.period', 'DYX4', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FÆXX', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FMIN', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FMV1', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FMV2', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FMVM', 'broader', 3),
('dime.period', 'FXXX', 'dime.period', 'FYXX', 'broader', 3),
('dime.period', 'HXXX', 'dime.period', 'DXXX', 'broader', 2),
('dime.period', 'HXXX', 'dime.period', 'EXXX', 'broader', 2),
('dime.period', 'HXXX', 'dime.period', 'FXXX', 'broader', 2),
('dime.period', 'HXXX', 'dime.period', 'HXXX', 'broader', 1),
('dime.period', 'XXXX', 'dime.period', 'XXXX', 'broader', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_relation`
--

CREATE TABLE `ark_vocabulary_relation` (
  `relation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipricol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipricol_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equivalence` tinyint(1) NOT NULL DEFAULT '0',
  `hierarchy` tinyint(1) NOT NULL DEFAULT '0',
  `associative` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_relation`
--

INSERT INTO `ark_vocabulary_relation` (`relation`, `code`, `recipricol`, `recipricol_code`, `equivalence`, `hierarchy`, `associative`, `description`) VALUES
('broader', 'BT', 'narrower', 'NT', 0, 1, 0, 'The \'Has A\' parent/child hierarchy relationship'),
('class', 'BTI', 'instance', 'NTI', 0, 1, 0, 'The \'Is A\' class/instance hierarchy relationship.'),
('related', 'RT', 'related', 'RT', 0, 0, 1, 'Related terms that are neither equivalent or hierarchical.'),
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
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_term`
--

INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('core.file.status', 'checkedin', '', 1, 0, 'core.file.status.checkedin', ''),
('core.file.status', 'checkedout', '', 1, 0, 'core.file.status.checkedout', ''),
('core.file.status', 'expired', '', 1, 0, 'core.file.status.expired', ''),
('core.file.status', 'locked', '', 1, 0, 'core.file.status.locked', ''),
('core.file.status', 'new', '', 1, 0, 'core.file.status.new', ''),
('core.file.type', 'audio', '', 1, 0, 'core.file.type.audio', ''),
('core.file.type', 'document', '', 1, 0, 'core.file.type.document', ''),
('core.file.type', 'image', '', 1, 0, 'core.file.type.image', ''),
('core.file.type', 'other', '', 1, 0, 'core.file.type.other', ''),
('core.file.type', 'text', '', 1, 0, 'core.file.type.text', ''),
('core.file.type', 'video', '', 1, 0, 'core.file.type.video', ''),
('country', 'AD ', 'andorra', 1, 0, 'country.andorra', ''),
('country', 'AE ', 'unitedarabemirates', 1, 0, 'country.unitedarabemirates', ''),
('country', 'AF ', 'afghanistan', 1, 0, 'country.afghanistan', ''),
('country', 'AG ', 'antigua', 1, 0, 'country.antigua', ''),
('country', 'AI ', 'anguilla', 1, 0, 'country.anguilla', ''),
('country', 'AL ', 'albania', 1, 0, 'country.albania', ''),
('country', 'AM ', 'armenia', 1, 0, 'country.armenia', ''),
('country', 'AO ', 'angola', 1, 0, 'country.angola', ''),
('country', 'AQ ', 'antarctica', 1, 0, 'country.antarctica', ''),
('country', 'AR ', 'argentina', 1, 0, 'country.argentina', ''),
('country', 'AS ', 'americansamoa', 1, 0, 'country.americansamoa', ''),
('country', 'AT ', 'austria', 1, 0, 'country.austria', ''),
('country', 'AU ', 'australia', 1, 0, 'country.australia', ''),
('country', 'AW ', 'aruba', 1, 0, 'country.aruba', ''),
('country', 'AX ', 'alandislands', 1, 0, 'country.alandislands', ''),
('country', 'AZ ', 'azerbaijan', 1, 0, 'country.azerbaijan', ''),
('country', 'BA ', 'bosniaherzegovina', 1, 0, 'country.bosniaherzegovina', ''),
('country', 'BB ', 'barbados', 1, 0, 'country.barbados', ''),
('country', 'BD ', 'bangladesh', 1, 0, 'country.bangladesh', ''),
('country', 'BE ', 'belgium', 1, 0, 'country.belgium', ''),
('country', 'BF ', 'burkinafaso', 1, 0, 'country.burkinafaso', ''),
('country', 'BG ', 'bulgaria', 1, 0, 'country.bulgaria', ''),
('country', 'BH ', 'bahrain', 1, 0, 'country.bahrain', ''),
('country', 'BI ', 'burundi', 1, 0, 'country.burundi', ''),
('country', 'BJ ', 'benin', 1, 0, 'country.benin', ''),
('country', 'BL ', 'saintbarthelemy', 1, 0, 'country.saintbarthelemy', ''),
('country', 'BM ', 'bermuda', 1, 0, 'country.bermuda', ''),
('country', 'BN ', 'brunei', 1, 0, 'country.brunei', ''),
('country', 'BO ', 'bolivia', 1, 0, 'country.bolivia', ''),
('country', 'BQ ', 'bonaire', 1, 0, 'country.bonaire', ''),
('country', 'BR ', 'brazil', 1, 0, 'country.brazil', ''),
('country', 'BS ', 'bahamas', 1, 0, 'country.bahamas', ''),
('country', 'BT ', 'bhutan', 1, 0, 'country.bhutan', ''),
('country', 'BW ', 'botswana', 1, 0, 'country.botswana', ''),
('country', 'BY ', 'belarus', 1, 0, 'country.belarus', ''),
('country', 'BZ ', 'belize', 1, 0, 'country.belize', ''),
('country', 'CA ', 'canada', 1, 0, 'country.canada', ''),
('country', 'CC ', 'cocosislands', 1, 0, 'country.cocosislands', ''),
('country', 'CD ', 'democraticrepubliccongo', 1, 0, 'country.democraticrepubliccongo', ''),
('country', 'CF ', 'centralafricanrepublic', 1, 0, 'country.centralafricanrepublic', ''),
('country', 'CG ', 'congo', 1, 0, 'country.congo', ''),
('country', 'CH ', 'switzerland', 1, 0, 'country.switzerland', ''),
('country', 'CI ', 'cotedivoire', 1, 0, 'country.cotedivoire', ''),
('country', 'CK ', 'cookislands', 1, 0, 'country.cookislands', ''),
('country', 'CL ', 'chile', 1, 0, 'country.chile', ''),
('country', 'CM ', 'cameroon', 1, 0, 'country.cameroon', ''),
('country', 'CN ', 'china', 1, 0, 'country.china', ''),
('country', 'CO ', 'colombia', 1, 0, 'country.colombia', ''),
('country', 'CR ', 'costarica', 1, 0, 'country.costarica', ''),
('country', 'CU ', 'cuba', 1, 0, 'country.cuba', ''),
('country', 'CV ', 'caboverde', 1, 0, 'country.caboverde', ''),
('country', 'CW ', 'curacao', 1, 0, 'country.curacao', ''),
('country', 'CX ', 'christmasisland', 1, 0, 'country.christmasisland', ''),
('country', 'CY ', 'cyprus', 1, 0, 'country.cyprus', ''),
('country', 'CZ ', 'czechrepublic', 1, 0, 'country.czechrepublic', ''),
('country', 'DE ', 'germany', 1, 0, 'country.germany', ''),
('country', 'DJ ', 'djibouti', 1, 0, 'country.djibouti', ''),
('country', 'DK ', 'denmark', 1, 0, 'country.denmark', ''),
('country', 'DM ', 'dominica', 1, 0, 'country.dominica', ''),
('country', 'DO ', 'dominicanrepublic', 1, 0, 'country.dominicanrepublic', ''),
('country', 'DZ ', 'algeria', 1, 0, 'country.algeria', ''),
('country', 'EC ', 'ecuador', 1, 0, 'country.ecuador', ''),
('country', 'EE ', 'estonia', 1, 0, 'country.estonia', ''),
('country', 'EG ', 'egypt', 1, 0, 'country.egypt', ''),
('country', 'EH ', 'westernsahara', 1, 0, 'country.westernsahara', ''),
('country', 'ER ', 'eritrea', 1, 0, 'country.eritrea', ''),
('country', 'ES ', 'spain', 1, 0, 'country.spain', ''),
('country', 'ET ', 'ethiopia', 1, 0, 'country.ethiopia', ''),
('country', 'FI ', 'finland', 1, 0, 'country.finland', ''),
('country', 'FJ ', 'fiji', 1, 0, 'country.fiji', ''),
('country', 'FK ', 'falklandislands', 1, 0, 'country.falklandislands', ''),
('country', 'FM ', 'micronesia', 1, 0, 'country.micronesia', ''),
('country', 'FO ', 'faroeislands', 1, 0, 'country.faroeislands', ''),
('country', 'FR ', 'france', 1, 0, 'country.france', ''),
('country', 'GA ', 'gabon', 1, 0, 'country.gabon', ''),
('country', 'GB ', 'unitedkingdom', 1, 0, 'country.unitedkingdom', ''),
('country', 'GD ', 'grenada', 1, 0, 'country.grenada', ''),
('country', 'GE ', 'georgia', 1, 0, 'country.georgia', ''),
('country', 'GF ', 'frenchguiana', 1, 0, 'country.frenchguiana', ''),
('country', 'GG ', 'guernsey', 1, 0, 'country.guernsey', ''),
('country', 'GH ', 'ghana', 1, 0, 'country.ghana', ''),
('country', 'GI ', 'gibraltar', 1, 0, 'country.gibraltar', ''),
('country', 'GL ', 'greenland', 1, 0, 'country.greenland', ''),
('country', 'GM ', 'gambia', 1, 0, 'country.gambia', ''),
('country', 'GN ', 'guinea', 1, 0, 'country.guinea', ''),
('country', 'GP ', 'guadeloupe', 1, 0, 'country.guadeloupe', ''),
('country', 'GQ ', 'equatorialguinea', 1, 0, 'country.equatorialguinea', ''),
('country', 'GR ', 'greece', 1, 0, 'country.greece', ''),
('country', 'GS ', 'southgeorgia', 1, 0, 'country.southgeorgia', ''),
('country', 'GT ', 'guatemala', 1, 0, 'country.guatemala', ''),
('country', 'GU ', 'guam', 1, 0, 'country.guam', ''),
('country', 'GW ', 'guinea-bissau', 1, 0, 'country.guinea-bissau', ''),
('country', 'GY ', 'guyana', 1, 0, 'country.guyana', ''),
('country', 'HK ', 'hongkong', 1, 0, 'country.hongkong', ''),
('country', 'HN ', 'honduras', 1, 0, 'country.honduras', ''),
('country', 'HR ', 'croatia', 1, 0, 'country.croatia', ''),
('country', 'HT ', 'haiti', 1, 0, 'country.haiti', ''),
('country', 'HU ', 'hungary', 1, 0, 'country.hungary', ''),
('country', 'ID ', 'indonesia', 1, 0, 'country.indonesia', ''),
('country', 'IE ', 'ireland', 1, 0, 'country.ireland', ''),
('country', 'IL ', 'israel', 1, 0, 'country.israel', ''),
('country', 'IM ', 'isleofman', 1, 0, 'country.isleofman', ''),
('country', 'IN ', 'india', 1, 0, 'country.india', ''),
('country', 'IQ ', 'iraq', 1, 0, 'country.iraq', ''),
('country', 'IR ', 'iran', 1, 0, 'country.iran', ''),
('country', 'IS ', 'iceland', 1, 0, 'country.iceland', ''),
('country', 'IT ', 'italy', 1, 0, 'country.italy', ''),
('country', 'JE ', 'jersey', 1, 0, 'country.jersey', ''),
('country', 'JM ', 'jamaica', 1, 0, 'country.jamaica', ''),
('country', 'JO ', 'jordan', 1, 0, 'country.jordan', ''),
('country', 'JP ', 'japan', 1, 0, 'country.japan', ''),
('country', 'KE ', 'kenya', 1, 0, 'country.kenya', ''),
('country', 'KG ', 'kyrgyzstan', 1, 0, 'country.kyrgyzstan', ''),
('country', 'KH ', 'cambodia', 1, 0, 'country.cambodia', ''),
('country', 'KI ', 'kiribati', 1, 0, 'country.kiribati', ''),
('country', 'KM ', 'comoros', 1, 0, 'country.comoros', ''),
('country', 'KN ', 'saintkitts', 1, 0, 'country.saintkitts', ''),
('country', 'KP ', 'northkorea', 1, 0, 'country.northkorea', ''),
('country', 'KR ', 'southkorea', 1, 0, 'country.southkorea', ''),
('country', 'KW ', 'kuwait', 1, 0, 'country.kuwait', ''),
('country', 'KY ', 'caymanislands', 1, 0, 'country.caymanislands', ''),
('country', 'KZ ', 'kazakhstan', 1, 0, 'country.kazakhstan', ''),
('country', 'LA ', 'lao', 1, 0, 'country.lao', ''),
('country', 'LB ', 'lebanon', 1, 0, 'country.lebanon', ''),
('country', 'LC ', 'saintlucia', 1, 0, 'country.saintlucia', ''),
('country', 'LI ', 'liechtenstein', 1, 0, 'country.liechtenstein', ''),
('country', 'LK ', 'srilanka', 1, 0, 'country.srilanka', ''),
('country', 'LR ', 'liberia', 1, 0, 'country.liberia', ''),
('country', 'LS ', 'lesotho', 1, 0, 'country.lesotho', ''),
('country', 'LT ', 'lithuania', 1, 0, 'country.lithuania', ''),
('country', 'LU ', 'luxembourg', 1, 0, 'country.luxembourg', ''),
('country', 'LV ', 'latvia', 1, 0, 'country.latvia', ''),
('country', 'LY ', 'libya', 1, 0, 'country.libya', ''),
('country', 'MA ', 'morocco', 1, 0, 'country.morocco', ''),
('country', 'MC ', 'monaco', 1, 0, 'country.monaco', ''),
('country', 'MD ', 'moldova', 1, 0, 'country.moldova', ''),
('country', 'ME ', 'montenegro', 1, 0, 'country.montenegro', ''),
('country', 'MF ', 'saintmartin', 1, 0, 'country.saintmartin', ''),
('country', 'MG ', 'madagascar', 1, 0, 'country.madagascar', ''),
('country', 'MH ', 'marshallislands', 1, 0, 'country.marshallislands', ''),
('country', 'MK ', 'macedonia', 1, 0, 'country.macedonia', ''),
('country', 'ML ', 'mali', 1, 0, 'country.mali', ''),
('country', 'MM ', 'myanmar', 1, 0, 'country.myanmar', ''),
('country', 'MN ', 'mongolia', 1, 0, 'country.mongolia', ''),
('country', 'MO ', 'macao', 1, 0, 'country.macao', ''),
('country', 'MP ', 'northernmarianaislands', 1, 0, 'country.northernmarianaislands', ''),
('country', 'MQ ', 'martinique', 1, 0, 'country.martinique', ''),
('country', 'MR ', 'mauritania', 1, 0, 'country.mauritania', ''),
('country', 'MS ', 'montserrat', 1, 0, 'country.montserrat', ''),
('country', 'MT ', 'malta', 1, 0, 'country.malta', ''),
('country', 'MU ', 'mauritius', 1, 0, 'country.mauritius', ''),
('country', 'MV ', 'maldives', 1, 0, 'country.maldives', ''),
('country', 'MW ', 'malawi', 1, 0, 'country.malawi', ''),
('country', 'MX ', 'mexico', 1, 0, 'country.mexico', ''),
('country', 'MY ', 'malaysia', 1, 0, 'country.malaysia', ''),
('country', 'MZ ', 'mozambique', 1, 0, 'country.mozambique', ''),
('country', 'NA ', 'namibia', 1, 0, 'country.namibia', ''),
('country', 'NC ', 'newcaledonia', 1, 0, 'country.newcaledonia', ''),
('country', 'NE ', 'niger', 1, 0, 'country.niger', ''),
('country', 'NF ', 'norfolkisland', 1, 0, 'country.norfolkisland', ''),
('country', 'NG ', 'nigeria', 1, 0, 'country.nigeria', ''),
('country', 'NI ', 'nicaragua', 1, 0, 'country.nicaragua', ''),
('country', 'NL ', 'netherlands', 1, 0, 'country.netherlands', ''),
('country', 'NO ', 'norway', 1, 0, 'country.norway', ''),
('country', 'NP ', 'nepal', 1, 0, 'country.nepal', ''),
('country', 'NR ', 'nauru', 1, 0, 'country.nauru', ''),
('country', 'NU ', 'niue', 1, 0, 'country.niue', ''),
('country', 'NZ ', 'newzealand', 1, 0, 'country.newzealand', ''),
('country', 'OM ', 'oman', 1, 0, 'country.oman', ''),
('country', 'PA ', 'panama', 1, 0, 'country.panama', ''),
('country', 'PE ', 'peru', 1, 0, 'country.peru', ''),
('country', 'PF ', 'frenchpolynesia', 1, 0, 'country.frenchpolynesia', ''),
('country', 'PG ', 'papuanewguinea', 1, 0, 'country.papuanewguinea', ''),
('country', 'PH ', 'philippines', 1, 0, 'country.philippines', ''),
('country', 'PK ', 'pakistan', 1, 0, 'country.pakistan', ''),
('country', 'PL ', 'poland', 1, 0, 'country.poland', ''),
('country', 'PM ', 'saintpierremiquelon', 1, 0, 'country.saintpierremiquelon', ''),
('country', 'PN ', 'pitcairn', 1, 0, 'country.pitcairn', ''),
('country', 'PR ', 'puertorico', 1, 0, 'country.puertorico', ''),
('country', 'PS ', 'palestine', 1, 0, 'country.palestine', ''),
('country', 'PT ', 'portugal', 1, 0, 'country.portugal', ''),
('country', 'PW ', 'palau', 1, 0, 'country.palau', ''),
('country', 'PY ', 'paraguay', 1, 0, 'country.paraguay', ''),
('country', 'QA ', 'qatar', 1, 0, 'country.qatar', ''),
('country', 'RE ', 'reunion', 1, 0, 'country.reunion', ''),
('country', 'RO ', 'romania', 1, 0, 'country.romania', ''),
('country', 'RS ', 'serbia', 1, 0, 'country.serbia', ''),
('country', 'RU ', 'russia', 1, 0, 'country.russia', ''),
('country', 'RW ', 'rwanda', 1, 0, 'country.rwanda', ''),
('country', 'SA ', 'saudiarabia', 1, 0, 'country.saudiarabia', ''),
('country', 'SB ', 'solomonislands', 1, 0, 'country.solomonislands', ''),
('country', 'SC ', 'seychelles', 1, 0, 'country.seychelles', ''),
('country', 'SD ', 'sudan', 1, 0, 'country.sudan', ''),
('country', 'SE ', 'sweden', 1, 0, 'country.sweden', ''),
('country', 'SG ', 'singapore', 1, 0, 'country.singapore', ''),
('country', 'SH ', 'sainthelena', 1, 0, 'country.sainthelena', ''),
('country', 'SI ', 'slovenia', 1, 0, 'country.slovenia', ''),
('country', 'SJ ', 'svalbard', 1, 0, 'country.svalbard', ''),
('country', 'SK ', 'slovakia', 1, 0, 'country.slovakia', ''),
('country', 'SL ', 'sierraleone', 1, 0, 'country.sierraleone', ''),
('country', 'SM ', 'sanmarino', 1, 0, 'country.sanmarino', ''),
('country', 'SN ', 'senegal', 1, 0, 'country.senegal', ''),
('country', 'SO ', 'somalia', 1, 0, 'country.somalia', ''),
('country', 'SR ', 'suriname', 1, 0, 'country.suriname', ''),
('country', 'SS ', 'southsudan', 1, 0, 'country.southsudan', ''),
('country', 'ST ', 'saotome', 1, 0, 'country.saotome', ''),
('country', 'SV ', 'elsalvador', 1, 0, 'country.elsalvador', ''),
('country', 'SX ', 'sintmaarten', 1, 0, 'country.sintmaarten', ''),
('country', 'SY ', 'syria', 1, 0, 'country.syria', ''),
('country', 'SZ ', 'swaziland', 1, 0, 'country.swaziland', ''),
('country', 'TC ', 'turkscaicos', 1, 0, 'country.turkscaicos', ''),
('country', 'TD ', 'chad', 1, 0, 'country.chad', ''),
('country', 'TG ', 'togo', 1, 0, 'country.togo', ''),
('country', 'TH ', 'thailand', 1, 0, 'country.thailand', ''),
('country', 'TJ ', 'tajikistan', 1, 0, 'country.tajikistan', ''),
('country', 'TK ', 'tokelau', 1, 0, 'country.tokelau', ''),
('country', 'TL ', 'timorleste', 1, 0, 'country.timorleste', ''),
('country', 'TM ', 'turkmenistan', 1, 0, 'country.turkmenistan', ''),
('country', 'TN ', 'tunisia', 1, 0, 'country.tunisia', ''),
('country', 'TO ', 'tonga', 1, 0, 'country.tonga', ''),
('country', 'TR ', 'turkey', 1, 0, 'country.turkey', ''),
('country', 'TT ', 'trinidadtobago', 1, 0, 'country.trinidadtobago', ''),
('country', 'TV ', 'tuvalu', 1, 0, 'country.tuvalu', ''),
('country', 'TW ', 'taiwan', 1, 0, 'country.taiwan', ''),
('country', 'TZ ', 'tanzania', 1, 0, 'country.tanzania', ''),
('country', 'UA ', 'ukraine', 1, 0, 'country.ukraine', ''),
('country', 'UG ', 'uganda', 1, 0, 'country.uganda', ''),
('country', 'US ', 'unitedstatesamerica', 1, 0, 'country.unitedstatesamerica', ''),
('country', 'UY ', 'uruguay', 1, 0, 'country.uruguay', ''),
('country', 'UZ ', 'uzbekistan', 1, 0, 'country.uzbekistan', ''),
('country', 'VA ', 'vatican', 1, 0, 'country.vatican', ''),
('country', 'VC ', 'saintvincent', 1, 0, 'country.saintvincent', ''),
('country', 'VE ', 'venezuela', 1, 0, 'country.venezuela', ''),
('country', 'VG ', 'britishvirginislands', 1, 0, 'country.britishvirginislands', ''),
('country', 'VI ', 'usvirginislands', 1, 0, 'country.usvirginislands', ''),
('country', 'VN ', 'vietnam', 1, 0, 'country.vietnam', ''),
('country', 'VU ', 'vanuatu', 1, 0, 'country.vanuatu', ''),
('country', 'WF ', 'wallisfutuna', 1, 0, 'country.wallisfutuna', ''),
('country', 'WS ', 'samoa', 1, 0, 'country.samoa', ''),
('country', 'YE ', 'yemen', 1, 0, 'country.yemen', ''),
('country', 'YT ', 'mayotte', 1, 0, 'country.mayotte', ''),
('country', 'ZA ', 'southafrica', 1, 0, 'country.southafrica', ''),
('country', 'ZM ', 'zambia', 1, 0, 'country.zambia', ''),
('country', 'ZW ', 'zimbabwe', 1, 0, 'country.zimbabwe', ''),
('crs', '4326', 'WGS84', 1, 0, 'crs.wgs84', ''),
('dime.actor.type', 'institution', '', 1, 0, 'dime.actor.type.institution', ''),
('dime.actor.type', 'museum', '', 1, 0, 'dime.actor.type.museum', ''),
('dime.actor.type', 'person', '', 1, 0, 'dime.actor.type.person', ''),
('dime.denmark.admin', 'DK', 'denmark', 1, 0, 'dime.denmark.admin.denmark', ''),
('dime.denmark.kommune', '101', 'kobenhavn', 1, 0, 'dime.kommune.kobenhavn', ''),
('dime.denmark.kommune', '147', 'frederiksbeg', 1, 0, 'dime.kommune.frederiksbeg', ''),
('dime.denmark.kommune', '151', 'ballerup', 1, 0, 'dime.kommune.ballerup', ''),
('dime.denmark.kommune', '153', 'brondby', 1, 0, 'dime.kommune.brondby', ''),
('dime.denmark.kommune', '155', 'dragor', 1, 0, 'dime.kommune.dragor', ''),
('dime.denmark.kommune', '157', 'gentofte', 1, 0, 'dime.kommune.gentofte', ''),
('dime.denmark.kommune', '159', 'gladsaxe', 1, 0, 'dime.kommune.gladsaxe', ''),
('dime.denmark.kommune', '161', 'glostrup', 1, 0, 'dime.kommune.glostrup', ''),
('dime.denmark.kommune', '163', 'herlev', 1, 0, 'dime.kommune.herlev', ''),
('dime.denmark.kommune', '165', 'albertslund', 1, 0, 'dime.kommune.albertslund', ''),
('dime.denmark.kommune', '167', 'hvidovre', 1, 0, 'dime.kommune.hvidovre', ''),
('dime.denmark.kommune', '169', 'hojetaastrup', 1, 0, 'dime.kommune.hojetaastrup', ''),
('dime.denmark.kommune', '173', 'lyngbytaarbaek', 1, 0, 'dime.kommune.lyngbytaarbaek', ''),
('dime.denmark.kommune', '175', 'rodovre', 1, 0, 'dime.kommune.rodovre', ''),
('dime.denmark.kommune', '183', 'ishoj', 1, 0, 'dime.kommune.ishoj', ''),
('dime.denmark.kommune', '185', 'tarnby', 1, 0, 'dime.kommune.tarnby', ''),
('dime.denmark.kommune', '187', 'vallensbaek', 1, 0, 'dime.kommune.vallensbaek', ''),
('dime.denmark.kommune', '190', 'fureso', 1, 0, 'dime.kommune.fureso', ''),
('dime.denmark.kommune', '201', 'allerod', 1, 0, 'dime.kommune.allerod', ''),
('dime.denmark.kommune', '210', 'fredensborg', 1, 0, 'dime.kommune.fredensborg', ''),
('dime.denmark.kommune', '217', 'helsingor', 1, 0, 'dime.kommune.helsingor', ''),
('dime.denmark.kommune', '219', 'hillerod', 1, 0, 'dime.kommune.hillerod', ''),
('dime.denmark.kommune', '223', 'horsholm', 1, 0, 'dime.kommune.horsholm', ''),
('dime.denmark.kommune', '230', 'rudersdal', 1, 0, 'dime.kommune.rudersdal', ''),
('dime.denmark.kommune', '240', 'egedal', 1, 0, 'dime.kommune.egedal', ''),
('dime.denmark.kommune', '250', 'frederikssund', 1, 0, 'dime.kommune.frederikssund', ''),
('dime.denmark.kommune', '253', 'greve', 1, 0, 'dime.kommune.greve', ''),
('dime.denmark.kommune', '259', 'koge', 1, 0, 'dime.kommune.koge', ''),
('dime.denmark.kommune', '260', 'halsnaes', 1, 0, 'dime.kommune.halsnaes', ''),
('dime.denmark.kommune', '265', 'roskilde', 1, 0, 'dime.kommune.roskilde', ''),
('dime.denmark.kommune', '269', 'solrod', 1, 0, 'dime.kommune.solrod', ''),
('dime.denmark.kommune', '270', 'gribskov', 1, 0, 'dime.kommune.gribskov', ''),
('dime.denmark.kommune', '306', 'odsherred', 1, 0, 'dime.kommune.odsherred', ''),
('dime.denmark.kommune', '316', 'holbaek', 1, 0, 'dime.kommune.holbaek', ''),
('dime.denmark.kommune', '320', 'faxe', 1, 0, 'dime.kommune.faxe', ''),
('dime.denmark.kommune', '326', 'kalundborg', 1, 0, 'dime.kommune.kalundborg', ''),
('dime.denmark.kommune', '329', 'ringsted', 1, 0, 'dime.kommune.ringsted', ''),
('dime.denmark.kommune', '330', 'slagelse', 1, 0, 'dime.kommune.slagelse', ''),
('dime.denmark.kommune', '336', 'stevns', 1, 0, 'dime.kommune.stevns', ''),
('dime.denmark.kommune', '340', 'soro', 1, 0, 'dime.kommune.soro', ''),
('dime.denmark.kommune', '350', 'lejre', 1, 0, 'dime.kommune.lejre', ''),
('dime.denmark.kommune', '360', 'lolland', 1, 0, 'dime.kommune.lolland', ''),
('dime.denmark.kommune', '370', 'naestved', 1, 0, 'dime.kommune.naestved', ''),
('dime.denmark.kommune', '376', 'guldborgsund', 1, 0, 'dime.kommune.guldborgsund', ''),
('dime.denmark.kommune', '390', 'vordingborg', 1, 0, 'dime.kommune.vordingborg', ''),
('dime.denmark.kommune', '400', 'bornholm', 1, 0, 'dime.kommune.bornholm', ''),
('dime.denmark.kommune', '410', 'middelfart', 1, 0, 'dime.kommune.middelfart', ''),
('dime.denmark.kommune', '420', 'assens', 1, 0, 'dime.kommune.assens', ''),
('dime.denmark.kommune', '430', 'faaborgmidtfyn', 1, 0, 'dime.kommune.faaborgmidtfyn', ''),
('dime.denmark.kommune', '440', 'kerteminde', 1, 0, 'dime.kommune.kerteminde', ''),
('dime.denmark.kommune', '450', 'nyborg', 1, 0, 'dime.kommune.nyborg', ''),
('dime.denmark.kommune', '461', 'odense', 1, 0, 'dime.kommune.odense', ''),
('dime.denmark.kommune', '479', 'svendborg', 1, 0, 'dime.kommune.svendborg', ''),
('dime.denmark.kommune', '480', 'nordfyns', 1, 0, 'dime.kommune.nordfyns', ''),
('dime.denmark.kommune', '482', 'langeland', 1, 0, 'dime.kommune.langeland', ''),
('dime.denmark.kommune', '492', 'aero', 1, 0, 'dime.kommune.aero', ''),
('dime.denmark.kommune', '510', 'haderslev', 1, 0, 'dime.kommune.haderslev', ''),
('dime.denmark.kommune', '530', 'billund', 1, 0, 'dime.kommune.billund', ''),
('dime.denmark.kommune', '540', 'sonderborg', 1, 0, 'dime.kommune.sonderborg', ''),
('dime.denmark.kommune', '550', 'tonder', 1, 0, 'dime.kommune.tonder', ''),
('dime.denmark.kommune', '561', 'esbjerg', 1, 0, 'dime.kommune.esbjerg', ''),
('dime.denmark.kommune', '563', 'fano', 1, 0, 'dime.kommune.fano', ''),
('dime.denmark.kommune', '573', 'varde', 1, 0, 'dime.kommune.varde', ''),
('dime.denmark.kommune', '575', 'vejen', 1, 0, 'dime.kommune.vejen', ''),
('dime.denmark.kommune', '580', 'aabenraa', 1, 0, 'dime.kommune.aabenraa', ''),
('dime.denmark.kommune', '607', 'fredericia', 1, 0, 'dime.kommune.fredericia', ''),
('dime.denmark.kommune', '615', 'horsens', 1, 0, 'dime.kommune.horsens', ''),
('dime.denmark.kommune', '621', 'kolding', 1, 0, 'dime.kommune.kolding', ''),
('dime.denmark.kommune', '630', 'vejle', 1, 0, 'dime.kommune.vejle', ''),
('dime.denmark.kommune', '657', 'herning', 1, 0, 'dime.kommune.herning', ''),
('dime.denmark.kommune', '661', 'holstebro', 1, 0, 'dime.kommune.holstebro', ''),
('dime.denmark.kommune', '665', 'lemvig', 1, 0, 'dime.kommune.lemvig', ''),
('dime.denmark.kommune', '671', 'struer', 1, 0, 'dime.kommune.struer', ''),
('dime.denmark.kommune', '706', 'syddjurs', 1, 0, 'dime.kommune.syddjurs', ''),
('dime.denmark.kommune', '707', 'norddjurs', 1, 0, 'dime.kommune.norddjurs', ''),
('dime.denmark.kommune', '710', 'favrskov', 1, 0, 'dime.kommune.favrskov', ''),
('dime.denmark.kommune', '727', 'odder', 1, 0, 'dime.kommune.odder', ''),
('dime.denmark.kommune', '730', 'randers', 1, 0, 'dime.kommune.randers', ''),
('dime.denmark.kommune', '740', 'silkeborg', 1, 0, 'dime.kommune.silkeborg', ''),
('dime.denmark.kommune', '741', 'samso', 1, 0, 'dime.kommune.samso', ''),
('dime.denmark.kommune', '746', 'skanderborg', 1, 0, 'dime.kommune.skanderborg', ''),
('dime.denmark.kommune', '751', 'arhus', 1, 0, 'dime.kommune.arhus', ''),
('dime.denmark.kommune', '756', 'ikastbrande', 1, 0, 'dime.kommune.ikastbrande', ''),
('dime.denmark.kommune', '760', 'ringkobingskjern', 1, 0, 'dime.kommune.ringkobingskjern', ''),
('dime.denmark.kommune', '766', 'hedensted', 1, 0, 'dime.kommune.hedensted', ''),
('dime.denmark.kommune', '773', 'morso', 1, 0, 'dime.kommune.morso', ''),
('dime.denmark.kommune', '779', 'skive', 1, 0, 'dime.kommune.skive', ''),
('dime.denmark.kommune', '787', 'thisted', 1, 0, 'dime.kommune.thisted', ''),
('dime.denmark.kommune', '791', 'viborg', 1, 0, 'dime.kommune.viborg', ''),
('dime.denmark.kommune', '810', 'bronderslev', 1, 0, 'dime.kommune.bronderslev', ''),
('dime.denmark.kommune', '813', 'frederikshavn', 1, 0, 'dime.kommune.frederikshavn', ''),
('dime.denmark.kommune', '820', 'vesthimmerland', 1, 0, 'dime.kommune.vesthimmerland', ''),
('dime.denmark.kommune', '825', 'laeso', 1, 0, 'dime.kommune.laeso', ''),
('dime.denmark.kommune', '840', 'rebild', 1, 0, 'dime.kommune.rebild', ''),
('dime.denmark.kommune', '846', 'mariagerfjord', 1, 0, 'dime.kommune.mariagerfjord', ''),
('dime.denmark.kommune', '849', 'jammerbugt', 1, 0, 'dime.kommune.jammerbugt', ''),
('dime.denmark.kommune', '851', 'aalborg', 1, 0, 'dime.kommune.aalborg', ''),
('dime.denmark.kommune', '860', 'hjorring', 1, 0, 'dime.kommune.hjorring', ''),
('dime.denmark.region', 'DK01', 'hovedstaden', 1, 0, 'dime.region.hovedstaden', ''),
('dime.denmark.region', 'DK02', 'sjaelland', 1, 0, 'dime.region.sjaelland', ''),
('dime.denmark.region', 'DK03', 'syddanmark', 1, 0, 'dime.region.syddanmark', ''),
('dime.denmark.region', 'DK04', 'midtjylland', 1, 0, 'dime.region.midtjylland', ''),
('dime.denmark.region', 'DK05', 'nordjylland', 1, 0, 'dime.region.nordjylland', ''),
('dime.find.condition', 'fragmented', '', 1, 0, 'dime.find.condition.fragmented', ''),
('dime.find.condition', 'modified', '', 1, 0, 'dime.find.condition.modified', ''),
('dime.find.condition', 'unfinished', '', 1, 0, 'dime.find.condition.unfinished', ''),
('dime.find.condition', 'whole', '', 1, 0, 'dime.find.condition.whole', ''),
('dime.find.secondary', 'enamel', '', 1, 0, 'dime.find.secondary.enamel', ''),
('dime.find.secondary', 'gilded', '', 1, 0, 'dime.find.secondary.gilded', ''),
('dime.find.secondary', 'glass', '', 1, 0, 'dime.find.secondary.glass', ''),
('dime.find.secondary', 'iron', '', 1, 0, 'dime.find.secondary.iron', ''),
('dime.find.secondary', 'niello', '', 1, 0, 'dime.find.secondary.niello', ''),
('dime.find.secondary', 'organic', '', 1, 0, 'dime.find.secondary.organic', ''),
('dime.find.secondary', 'stone', '', 1, 0, 'dime.find.secondary.stone', ''),
('dime.find.secondary', 'tinned', '', 1, 0, 'dime.dime.secondary.tinned', ''),
('dime.find.secondary', 'zz', 'other', 1, 0, 'dime.dime.secondary.other', ''),
('dime.find.type', 'accessory', '', 1, 0, 'dime.find.type.accessory', ''),
('dime.find.type', 'coin', '', 1, 0, 'dime.find.type.coin', ''),
('dime.find.type', 'fibula', '', 1, 0, 'dime.find.type.fibula', ''),
('dime.find.type', 'military', '', 1, 0, 'dime.find.type.military', ''),
('dime.find.type', 'tool', '', 1, 0, 'dime.find.type.tool', ''),
('dime.find.type', 'waste', '', 1, 0, 'dime.find.type.waste', ''),
('dime.material', 'ag', 'silver', 1, 0, 'dime.material.silver', ''),
('dime.material', 'al', 'aluminium', 1, 0, 'dime.material.aluminium', ''),
('dime.material', 'au', 'gold', 1, 0, 'dime.material.gold', ''),
('dime.material', 'cu', 'copper', 1, 0, 'dime.material.copper', ''),
('dime.material', 'cual', 'copperalloy', 1, 0, 'dime.material.copperalloy', ''),
('dime.material', 'fe', 'iron', 1, 0, 'dime.material.iron', ''),
('dime.material', 'pb', 'lead', 1, 0, 'dime.material.lead', ''),
('dime.material', 'sa', 'tin', 1, 0, 'dime.material.tin', ''),
('dime.material', 'xx', 'othermetal', 1, 0, 'dime.material.othermetal', ''),
('dime.period', 'AMXX', 'mesolithic', 1, 0, 'dime.period.mesolithic', 'Mesolithic'),
('dime.period', 'AXXX', 'stone', 1, 0, 'dime.period.stone', 'Stone Age'),
('dime.period', 'AYXX', 'neolithic', 1, 0, 'dime.period.neolithic', 'Neolithic'),
('dime.period', 'BÆX1', 'bronze.1', 1, 0, 'dime.period.bronze.1', 'Bronze Age Period 1'),
('dime.period', 'BÆX2', 'bronze.2', 1, 0, 'dime.period.bronze.2', 'Bronze Age Period 2'),
('dime.period', 'BÆX3', 'bronze.3', 1, 0, 'dime.period.bronze.3', 'Bronze Age Period 3'),
('dime.period', 'BÆXX', 'bronze.early', 1, 0, 'dime.period.bronze.early', 'Early Bronze Age'),
('dime.period', 'BXXX', 'bronze', 1, 0, 'dime.period.bronze', 'Bronze Age'),
('dime.period', 'BYX4', 'bronze.4', 1, 0, 'dime.period.bronze.4', 'Bronze Age Period 4'),
('dime.period', 'BYX5', 'bronze.5', 1, 0, 'dime.period.bronze.5', 'Bronze Age Period 5'),
('dime.period', 'BYX6', 'bronze.6', 1, 0, 'dime.period.bronze.6', 'Bronze Age Period 6'),
('dime.period', 'BYXX', 'bronze.late', 1, 0, 'dime.period.bronze.late', 'Late Bronze Age'),
('dime.period', 'CÆFÆ', 'iron.preroman.early', 1, 0, 'dime.period.iron.preroman.early', 'Early Pre-Roman Iron Age'),
('dime.period', 'CÆFM', 'iron.preroman.middle', 1, 0, 'dime.period.iron.preroman.middle', 'Middle Pre-Roman Iron Age'),
('dime.period', 'CÆFX', 'iron.preroman', 1, 0, 'dime.period.iron.preroman', 'Pre-Roman Iron Age'),
('dime.period', 'CÆFY', 'iron.preroman.late', 1, 0, 'dime.period.iron.preroman.late', 'Late Pre-Roman Iron Age'),
('dime.period', 'CÆRA', 'iron.roman.early.b1', 1, 0, 'dime.period.iron.roman.early.b1', 'Early Roman Iron Age B1'),
('dime.period', 'CÆRÆ', 'iron.roman.early', 1, 0, 'dime.period.iron.roman.early', 'Early Roman Iron Age'),
('dime.period', 'CÆRB', 'iron.roman.early.b2', 1, 0, 'dime.period.iron.roman.early.b2', 'Early Roman Iron Age B2'),
('dime.period', 'CÆRC', 'iron.roman.late.c1', 1, 0, 'dime.period.iron.roman.late.c1', 'Late Roman Iron Age C1'),
('dime.period', 'CÆRD', 'iron.roman.late.c2', 1, 0, 'dime.period.iron.roman.late.c2', 'Late Roman Iron Age C2'),
('dime.period', 'CÆRE', 'iron.roman.late.c3', 1, 0, 'dime.period.iron.roman.late.c3', 'Late Roman Iron Age C3'),
('dime.period', 'CÆRX', 'iron.roman', 1, 0, 'dime.period.iron.roman', 'Roman Iron Age'),
('dime.period', 'CÆRY', 'iron.roman.late', 1, 0, 'dime.period.iron.roman.late', 'Late Roman Iron Age'),
('dime.period', 'CÆXX', 'iron.early', 1, 0, 'dime.period.iron.early', 'Early Iron Age'),
('dime.period', 'CXXX', 'iron', 1, 0, 'dime.period.iron', 'Iron Age'),
('dime.period', 'CYGÆ', 'iron.germainic.early', 1, 0, 'dime.period.iron.germainic.early', 'Early Germanic Iron Age'),
('dime.period', 'CYGX', 'iron.germainic', 1, 0, 'dime.period.iron.germainic', 'Germanic Iron Age'),
('dime.period', 'CYGY', 'iron.germainic.late', 1, 0, 'dime.period.iron.germainic.late', 'Late Germanic Iron Age'),
('dime.period', 'CYVÆ', 'viking.early', 1, 0, 'dime.period.viking.early', 'Early Viking Age'),
('dime.period', 'CYVX', 'viking', 1, 0, 'dime.period.viking', 'Viking Age'),
('dime.period', 'CYVY', 'viking.late', 1, 0, 'dime.period.viking.late', 'Late Viking Age'),
('dime.period', 'CYXX', 'iron.late', 1, 0, 'dime.period.iron.late', 'Late Iron Age'),
('dime.period', 'DÆXX', 'medieval.early', 1, 0, 'dime.period.medieval.early', 'Early Medieval'),
('dime.period', 'DXXX', 'medieval', 1, 0, 'dime.period.medieval', 'Medieval'),
('dime.period', 'DYX3', 'medieval.high', 1, 0, 'dime.period.medieval.high', 'High Medieval'),
('dime.period', 'DYX4', 'medieval.late', 1, 0, 'dime.period.medieval.late', 'Late Medieval'),
('dime.period', 'EXXX', 'reformation', 1, 0, 'dime.period.reformation', 'Reformation'),
('dime.period', 'FÆXX', 'absolutism', 1, 0, 'dime.period.absolutism', 'Absolutism'),
('dime.period', 'FMIN', 'industrial', 1, 0, 'dime.period.industrial', 'Industrial Age'),
('dime.period', 'FMV1', 'ww1', 1, 0, 'dime.period.ww1', 'First World War'),
('dime.period', 'FMV2', 'ww2', 1, 0, 'dime.period.ww2', 'Second World War'),
('dime.period', 'FMVM', 'interwar', 1, 0, 'dime.period.interwar', 'Interwar Years'),
('dime.period', 'FXXX', 'modern', 1, 0, 'dime.period.modern', 'Modern Age'),
('dime.period', 'FYXX', 'welfare', 1, 0, 'dime.period.welfare', 'Welfare Age'),
('dime.period', 'HXXX', 'historic', 1, 0, 'dime.period.historic', 'Historic Age'),
('dime.period', 'PALEO', 'palaeolithic', 1, 0, 'dime.period.palaeolithic', 'Palaeolithic'),
('dime.period', 'VEM', 'viking.medieval', 1, 0, 'dime.period.viking.medieval', 'Viking / Early Medieval '),
('dime.period', 'XXXX', 'undated', 1, 0, 'dime.period.undated', 'Undated'),
('dime.treasure', 'assessing', '', 1, 0, 'dime.treasure.assesing', ''),
('dime.treasure', 'not', '', 1, 0, 'dime.treasure.not', ''),
('dime.treasure', 'pending', '', 1, 0, 'dime.treasure.pending', ''),
('dime.treasure', 'treasure', '', 1, 0, 'dime.treasure.treasure', ''),
('distance', 'km', 'kilometre', 1, 0, 'length.kilometre', ''),
('distance', 'm', 'metre', 1, 0, 'length.metre', ''),
('distance', 'mm', 'millimetre', 1, 0, 'length.millimetre', ''),
('distance', 'nm', 'nanometre', 1, 0, 'length.nanometre', ''),
('distance', 'µm', 'nanometre', 1, 0, 'length.micrometre', ''),
('language', 'aa', 'afar', 1, 0, 'language.afar', ''),
('language', 'ab', 'abkhazian', 1, 0, 'language.abkhazian', ''),
('language', 'ace', 'achinese', 1, 0, 'language.achinese', ''),
('language', 'ach', 'acoli', 1, 0, 'language.acoli', ''),
('language', 'ada', 'adangme', 1, 0, 'language.adangme', ''),
('language', 'ady', 'adyghe', 1, 0, 'language.adyghe', ''),
('language', 'ae', 'avestan', 1, 0, 'language.avestan', ''),
('language', 'aeb', 'arabic.tunisian', 1, 0, 'language.arabic.tunisian', ''),
('language', 'af', 'afrikaans', 1, 0, 'language.afrikaans', ''),
('language', 'afh', 'afrihili', 1, 0, 'language.afrihili', ''),
('language', 'agq', 'aghem', 1, 0, 'language.aghem', ''),
('language', 'ain', 'ainu', 1, 0, 'language.ainu', ''),
('language', 'ak', 'akan', 1, 0, 'language.akan', ''),
('language', 'akk', 'akkadian', 1, 0, 'language.akkadian', ''),
('language', 'akz', 'alabama', 1, 0, 'language.alabama', ''),
('language', 'ale', 'aleut', 1, 0, 'language.aleut', ''),
('language', 'aln', 'albanian.gheg', 1, 0, 'language.albanian.gheg', ''),
('language', 'alt', 'altai.southern', 1, 0, 'language.altai.southern', ''),
('language', 'am', 'amharic', 1, 0, 'language.amharic', ''),
('language', 'an', 'aragonese', 1, 0, 'language.aragonese', ''),
('language', 'ang', 'english.old', 1, 0, 'language.english.old', ''),
('language', 'anp', 'angika', 1, 0, 'language.angika', ''),
('language', 'ar', 'arabic', 1, 0, 'language.arabic', ''),
('language', 'ar-001', 'arabic.modern', 1, 0, 'language.arabic.modern', ''),
('language', 'arc', 'aramaic', 1, 0, 'language.aramaic', ''),
('language', 'arn', 'mapuche', 1, 0, 'language.mapuche', ''),
('language', 'aro', 'araona', 1, 0, 'language.araona', ''),
('language', 'arp', 'arapaho', 1, 0, 'language.arapaho', ''),
('language', 'arq', 'arabic.algerian', 1, 0, 'language.arabic.algerian', ''),
('language', 'arw', 'arawak', 1, 0, 'language.arawak', ''),
('language', 'ary', 'arabic.moroccan', 1, 0, 'language.arabic.moroccan', ''),
('language', 'arz', 'arabic.egyptian', 1, 0, 'language.arabic.egyptian', ''),
('language', 'as', 'assamese', 1, 0, 'language.assamese', ''),
('language', 'asa', 'asu', 1, 0, 'language.asu', ''),
('language', 'ast', 'asturian', 1, 0, 'language.asturian', ''),
('language', 'av', 'avaric', 1, 0, 'language.avaric', ''),
('language', 'avk', 'kotava', 1, 0, 'language.kotava', ''),
('language', 'awa', 'awadhi', 1, 0, 'language.awadhi', ''),
('language', 'ay', 'aymara', 1, 0, 'language.aymara', ''),
('language', 'az', 'azerbaijani', 1, 0, 'language.azerbaijani', ''),
('language', 'ba', 'bashkir', 1, 0, 'language.bashkir', ''),
('language', 'bal', 'baluchi', 1, 0, 'language.baluchi', ''),
('language', 'ban', 'balinese', 1, 0, 'language.balinese', ''),
('language', 'bar', 'bavarian', 1, 0, 'language.bavarian', ''),
('language', 'bas', 'basaa', 1, 0, 'language.basaa', ''),
('language', 'bax', 'bamun', 1, 0, 'language.bamun', ''),
('language', 'bbc', 'bataktoba', 1, 0, 'language.bataktoba', ''),
('language', 'bbj', 'ghomala', 1, 0, 'language.ghomala', ''),
('language', 'be', 'belarusian', 1, 0, 'language.belarusian', ''),
('language', 'bej', 'beja', 1, 0, 'language.beja', ''),
('language', 'bem', 'bemba', 1, 0, 'language.bemba', ''),
('language', 'bew', 'betawi', 1, 0, 'language.betawi', ''),
('language', 'bez', 'bena', 1, 0, 'language.bena', ''),
('language', 'bfd', 'bafut', 1, 0, 'language.bafut', ''),
('language', 'bfq', 'badaga', 1, 0, 'language.badaga', ''),
('language', 'bg', 'bulgarian', 1, 0, 'language.bulgarian', ''),
('language', 'bgn', 'balochi.western', 1, 0, 'language.balochi.western', ''),
('language', 'bho', 'bhojpuri', 1, 0, 'language.bhojpuri', ''),
('language', 'bi', 'bislama', 1, 0, 'language.bislama', ''),
('language', 'bik', 'bikol', 1, 0, 'language.bikol', ''),
('language', 'bin', 'bini', 1, 0, 'language.bini', ''),
('language', 'bjn', 'banjar', 1, 0, 'language.banjar', ''),
('language', 'bkm', 'kom', 1, 0, 'language.kom', ''),
('language', 'bla', 'siksika', 1, 0, 'language.siksika', ''),
('language', 'bm', 'bambara', 1, 0, 'language.bambara', ''),
('language', 'bn', 'bengali', 1, 0, 'language.bengali', ''),
('language', 'bo', 'tibetan', 1, 0, 'language.tibetan', ''),
('language', 'bpy', 'bishnupriya', 1, 0, 'language.bishnupriya', ''),
('language', 'bqi', 'bakhtiari', 1, 0, 'language.bakhtiari', ''),
('language', 'br', 'breton', 1, 0, 'language.breton', ''),
('language', 'bra', 'braj', 1, 0, 'language.braj', ''),
('language', 'brh', 'brahui', 1, 0, 'language.brahui', ''),
('language', 'brx', 'bodo', 1, 0, 'language.bodo', ''),
('language', 'bs', 'bosnian', 1, 0, 'language.bosnian', ''),
('language', 'bss', 'akoose', 1, 0, 'language.akoose', ''),
('language', 'bua', 'buriat', 1, 0, 'language.buriat', ''),
('language', 'bug', 'buginese', 1, 0, 'language.buginese', ''),
('language', 'bum', 'bulu', 1, 0, 'language.bulu', ''),
('language', 'byn', 'blin', 1, 0, 'language.blin', ''),
('language', 'byv', 'medumba', 1, 0, 'language.medumba', ''),
('language', 'ca', 'catalan', 1, 0, 'language.catalan', ''),
('language', 'cad', 'caddo', 1, 0, 'language.caddo', ''),
('language', 'car', 'carib', 1, 0, 'language.carib', ''),
('language', 'cay', 'cayuga', 1, 0, 'language.cayuga', ''),
('language', 'cch', 'atsam', 1, 0, 'language.atsam', ''),
('language', 'ce', 'chechen', 1, 0, 'language.chechen', ''),
('language', 'ceb', 'cebuano', 1, 0, 'language.cebuano', ''),
('language', 'cgg', 'chiga', 1, 0, 'language.chiga', ''),
('language', 'ch', 'chamorro', 1, 0, 'language.chamorro', ''),
('language', 'chb', 'chibcha', 1, 0, 'language.chibcha', ''),
('language', 'chg', 'chagatai', 1, 0, 'language.chagatai', ''),
('language', 'chk', 'chuukese', 1, 0, 'language.chuukese', ''),
('language', 'chm', 'mari', 1, 0, 'language.mari', ''),
('language', 'chn', 'jargon.chinook', 1, 0, 'language.jargon.chinook', ''),
('language', 'cho', 'choctaw', 1, 0, 'language.choctaw', ''),
('language', 'chp', 'chipewyan', 1, 0, 'language.chipewyan', ''),
('language', 'chr', 'cherokee', 1, 0, 'language.cherokee', ''),
('language', 'chy', 'cheyenne', 1, 0, 'language.cheyenne', ''),
('language', 'ckb', 'kurdish.central', 1, 0, 'language.kurdish.central', ''),
('language', 'co', 'corsican', 1, 0, 'language.corsican', ''),
('language', 'cop', 'coptic', 1, 0, 'language.coptic', ''),
('language', 'cps', 'capiznon', 1, 0, 'language.capiznon', ''),
('language', 'cr', 'cree', 1, 0, 'language.cree', ''),
('language', 'crh', 'turkish.crimean', 1, 0, 'language.turkish.crimean', ''),
('language', 'cs', 'czech', 1, 0, 'language.czech', ''),
('language', 'csb', 'kashubian', 1, 0, 'language.kashubian', ''),
('language', 'cu', 'slavic.church', 1, 0, 'language.slavic.church', ''),
('language', 'cv', 'chuvash', 1, 0, 'language.chuvash', ''),
('language', 'cy', 'welsh', 1, 0, 'language.welsh', ''),
('language', 'da', 'danish', 1, 0, 'language.danish', ''),
('language', 'dak', 'dakota', 1, 0, 'language.dakota', ''),
('language', 'dar', 'dargwa', 1, 0, 'language.dargwa', ''),
('language', 'dav', 'taita', 1, 0, 'language.taita', ''),
('language', 'de', 'german', 1, 0, 'language.german', ''),
('language', 'de-AT', 'german.austrian', 1, 0, 'language.german.austrian', ''),
('language', 'de-CH', 'german.swisshigh', 1, 0, 'language.german.swisshigh', ''),
('language', 'del', 'delaware', 1, 0, 'language.delaware', ''),
('language', 'den', 'slave', 1, 0, 'language.slave', ''),
('language', 'dgr', 'dogrib', 1, 0, 'language.dogrib', ''),
('language', 'din', 'dinka', 1, 0, 'language.dinka', ''),
('language', 'dje', 'zarma', 1, 0, 'language.zarma', ''),
('language', 'doi', 'dogri', 1, 0, 'language.dogri', ''),
('language', 'dsb', 'sorbian.lower', 1, 0, 'language.sorbian.lower', ''),
('language', 'dtp', 'dusun.central', 1, 0, 'language.dusun.central', ''),
('language', 'dua', 'duala', 1, 0, 'language.duala', ''),
('language', 'dum', 'dutch.middle', 1, 0, 'language.dutch.middle', ''),
('language', 'dv', 'divehi', 1, 0, 'language.divehi', ''),
('language', 'dyo', 'jolafonyi', 1, 0, 'language.jolafonyi', ''),
('language', 'dyu', 'dyula', 1, 0, 'language.dyula', ''),
('language', 'dz', 'dzongkha', 1, 0, 'language.dzongkha', ''),
('language', 'dzg', 'dazaga', 1, 0, 'language.dazaga', ''),
('language', 'ebu', 'embu', 1, 0, 'language.embu', ''),
('language', 'ee', 'ewe', 1, 0, 'language.ewe', ''),
('language', 'efi', 'efik', 1, 0, 'language.efik', ''),
('language', 'egl', 'emilian', 1, 0, 'language.emilian', ''),
('language', 'egy', 'egyptian.ancient', 1, 0, 'language.egyptian.ancient', ''),
('language', 'eka', 'ekajuk', 1, 0, 'language.ekajuk', ''),
('language', 'el', 'greek', 1, 0, 'language.greek', ''),
('language', 'elx', 'elamite', 1, 0, 'language.elamite', ''),
('language', 'en', 'english', 1, 0, 'language.english', ''),
('language', 'en-AU', 'english.australian', 1, 0, 'language.english.australian', ''),
('language', 'en-CA', 'english.canadian', 1, 0, 'language.english.canadian', ''),
('language', 'en-GB', 'english.british', 1, 0, 'language.english.british', ''),
('language', 'en-US', 'english.american', 1, 0, 'language.english.american', ''),
('language', 'enm', 'english.middle', 1, 0, 'language.english.middle', ''),
('language', 'eo', 'esperanto', 1, 0, 'language.esperanto', ''),
('language', 'es', 'spanish', 1, 0, 'language.spanish', ''),
('language', 'es-419', 'spanish.latinamerican', 1, 0, 'Language.spanish.latinamerican', ''),
('language', 'es-ES', 'spanish.european', 1, 0, 'language.spanish.european', ''),
('language', 'es-MX', 'spanish.mexican', 1, 0, 'language.spanish.mexican', ''),
('language', 'esu', 'yupik.central', 1, 0, 'language.yupik.central', ''),
('language', 'et', 'estonian', 1, 0, 'language.estonian', ''),
('language', 'eu', 'basque', 1, 0, 'language.basque', ''),
('language', 'ewo', 'ewondo', 1, 0, 'language.ewondo', ''),
('language', 'ext', 'extremaduran', 1, 0, 'language.extremaduran', ''),
('language', 'fa', 'persian', 1, 0, 'language.persian', ''),
('language', 'fan', 'fang', 1, 0, 'language.fang', ''),
('language', 'fat', 'fanti', 1, 0, 'language.fanti', ''),
('language', 'ff', 'fulah', 1, 0, 'language.fulah', ''),
('language', 'fi', 'finnish', 1, 0, 'language.finnish', ''),
('language', 'fil', 'filipino', 1, 0, 'language.filipino', ''),
('language', 'fit', 'finnish.tornedalen', 1, 0, 'language.finnish.tornedalen', ''),
('language', 'fj', 'fijian', 1, 0, 'language.fijian', ''),
('language', 'fo', 'faroese', 1, 0, 'language.faroese', ''),
('language', 'fon', 'fon', 1, 0, 'language.fon', ''),
('language', 'fr', 'french', 1, 0, 'language.french', ''),
('language', 'fr-CA', 'french.canadian', 1, 0, 'language.french.canadian', ''),
('language', 'fr-CH', 'french.swiss', 1, 0, 'language.french.swiss', ''),
('language', 'frc', 'french.cajun', 1, 0, 'language.french.cajun', ''),
('language', 'frm', 'french.middle', 1, 0, 'language.french.middle', ''),
('language', 'fro', 'french.old', 1, 0, 'language.french.old', ''),
('language', 'frp', 'arpitan', 1, 0, 'language.arpitan', ''),
('language', 'frr', 'frisian.northern', 1, 0, 'language.frisian.northern', ''),
('language', 'frs', 'frisian.eastern', 1, 0, 'language.frisian.eastern', ''),
('language', 'fur', 'friulian', 1, 0, 'language.friulian', ''),
('language', 'fy', 'frisian.western', 1, 0, 'language.frisian.western', ''),
('language', 'ga', 'irish', 1, 0, 'language.irish', ''),
('language', 'gaa', 'ga', 1, 0, 'language.ga', ''),
('language', 'gag', 'gagauz', 1, 0, 'language.gagauz', ''),
('language', 'gan', 'chinese.gan', 1, 0, 'language.chinese.gan', ''),
('language', 'gay', 'gayo', 1, 0, 'language.gayo', ''),
('language', 'gba', 'gbaya', 1, 0, 'language.gbaya', ''),
('language', 'gbz', 'dari.zoroastrian', 1, 0, 'language.dari.zoroastrian', ''),
('language', 'gd', 'gaelic.scottish', 1, 0, 'language.gaelic.scottish', ''),
('language', 'gez', 'geez', 1, 0, 'language.geez', ''),
('language', 'gil', 'gilbertese', 1, 0, 'language.gilbertese', ''),
('language', 'gl', 'galician', 1, 0, 'language.galician', ''),
('language', 'glk', 'gilaki', 1, 0, 'language.gilaki', ''),
('language', 'gmh', 'german.middlehigh', 1, 0, 'language.german.middlehigh', ''),
('language', 'gn', 'guarani', 1, 0, 'language.guarani', ''),
('language', 'goh', 'german.oldhigh', 1, 0, 'language.german.oldhigh', ''),
('language', 'gom', 'konkani.goan', 1, 0, 'language.konkani.goan', ''),
('language', 'gon', 'gondi', 1, 0, 'language.gondi', ''),
('language', 'gor', 'gorontalo', 1, 0, 'language.gorontalo', ''),
('language', 'got', 'gothic', 1, 0, 'language.gothic', ''),
('language', 'grb', 'grebo', 1, 0, 'language.grebo', ''),
('language', 'grc', 'greek.ancient', 1, 0, 'language.greek.ancient', ''),
('language', 'gsw', 'german.swiss', 1, 0, 'language.german.swiss', ''),
('language', 'gu', 'gujarati', 1, 0, 'language.gujarati', ''),
('language', 'guc', 'wayuu', 1, 0, 'language.wayuu', ''),
('language', 'gur', 'frafra', 1, 0, 'language.frafra', ''),
('language', 'guz', 'gusii', 1, 0, 'language.gusii', ''),
('language', 'gv', 'manx', 1, 0, 'language.manx', ''),
('language', 'gwi', 'gwichin', 1, 0, 'language.gwichin', ''),
('language', 'ha', 'hausa', 1, 0, 'language.hausa', ''),
('language', 'hai', 'haida', 1, 0, 'language.haida', ''),
('language', 'hak', 'chinese.hakka', 1, 0, 'language.chinese.hakka', ''),
('language', 'haw', 'hawaiian', 1, 0, 'language.hawaiian', ''),
('language', 'he', 'hebrew', 1, 0, 'language.hebrew', ''),
('language', 'hi', 'hindi', 1, 0, 'language.hindi', ''),
('language', 'hif', 'hindi.fiji', 1, 0, 'language.hindi.fiji', ''),
('language', 'hil', 'hiligaynon', 1, 0, 'language.hiligaynon', ''),
('language', 'hit', 'hittite', 1, 0, 'language.hittite', ''),
('language', 'hmn', 'hmong', 1, 0, 'language.hmong', ''),
('language', 'ho', 'motu.hiri', 1, 0, 'language.motu.hiri', ''),
('language', 'hr', 'croatian', 1, 0, 'language.croatian', ''),
('language', 'hsb', 'sorbian.upper', 1, 0, 'language.sorbian.upper', ''),
('language', 'hsn', 'chinese.xiang', 1, 0, 'language.chinese.xiang', ''),
('language', 'ht', 'creole.haitian', 1, 0, 'language.creole.haitian', ''),
('language', 'hu', 'hungarian', 1, 0, 'language.hungarian', ''),
('language', 'hup', 'hupa', 1, 0, 'language.hupa', ''),
('language', 'hy', 'armenian', 1, 0, 'language.armenian', ''),
('language', 'hz', 'herero', 1, 0, 'language.herero', ''),
('language', 'ia', 'interlingua', 1, 0, 'language.interlingua', ''),
('language', 'iba', 'iban', 1, 0, 'language.iban', ''),
('language', 'ibb', 'ibibio', 1, 0, 'language.ibibio', ''),
('language', 'id', 'indonesian', 1, 0, 'language.indonesian', ''),
('language', 'ie', 'interlingue', 1, 0, 'language.interlingue', ''),
('language', 'ig', 'igbo', 1, 0, 'language.igbo', ''),
('language', 'ii', 'yi.sichuan', 1, 0, 'language.yi.sichuan', ''),
('language', 'ik', 'inupiaq', 1, 0, 'language.inupiaq', ''),
('language', 'ilo', 'iloko', 1, 0, 'language.iloko', ''),
('language', 'inh', 'ingush', 1, 0, 'language.ingush', ''),
('language', 'io', 'ido', 1, 0, 'language.ido', ''),
('language', 'is', 'icelandic', 1, 0, 'language.icelandic', ''),
('language', 'it', 'italian', 1, 0, 'language.italian', ''),
('language', 'iu', 'inuktitut', 1, 0, 'language.inuktitut', ''),
('language', 'izh', 'ingrian', 1, 0, 'language.ingrian', ''),
('language', 'ja', 'japanese', 1, 0, 'language.japanese', ''),
('language', 'jam', 'english.jamaicancreole ', 1, 0, 'language.english.jamaicancreole ', ''),
('language', 'jbo', 'lojban', 1, 0, 'language.lojban', ''),
('language', 'jgo', 'ngomba', 1, 0, 'language.ngomba', ''),
('language', 'jmc', 'machame', 1, 0, 'language.machame', ''),
('language', 'jpr', 'judeopersian', 1, 0, 'language.judeopersian', ''),
('language', 'jrb', 'judeoarabic', 1, 0, 'language.judeoarabic', ''),
('language', 'jut', 'jutish', 1, 0, 'language.jutish', ''),
('language', 'jv', 'javanese', 1, 0, 'language.javanese', ''),
('language', 'ka', 'georgian', 1, 0, 'language.georgian', ''),
('language', 'kaa', 'karakalpak', 1, 0, 'language.karakalpak', ''),
('language', 'kab', 'kabyle', 1, 0, 'language.kabyle', ''),
('language', 'kac', 'kachin', 1, 0, 'language.kachin', ''),
('language', 'kaj', 'jju', 1, 0, 'language.jju', ''),
('language', 'kam', 'kamba', 1, 0, 'language.kamba', ''),
('language', 'kaw', 'kawi', 1, 0, 'language.kawi', ''),
('language', 'kbd', 'kabardian', 1, 0, 'language.kabardian', ''),
('language', 'kbl', 'kanembu', 1, 0, 'language.kanembu', ''),
('language', 'kcg', 'tyap', 1, 0, 'language.tyap', ''),
('language', 'kde', 'makonde', 1, 0, 'language.makonde', ''),
('language', 'kea', 'kabuverdianu', 1, 0, 'language.kabuverdianu', ''),
('language', 'ken', 'kenyang', 1, 0, 'language.kenyang', ''),
('language', 'kfo', 'koro', 1, 0, 'language.koro', ''),
('language', 'kg', 'kongo', 1, 0, 'language.kongo', ''),
('language', 'kgp', 'kaingang', 1, 0, 'language.kaingang', ''),
('language', 'kha', 'khasi', 1, 0, 'language.khasi', ''),
('language', 'kho', 'khotanese', 1, 0, 'language.khotanese', ''),
('language', 'khq', 'chiini.koyra', 1, 0, 'language.chiini.koyra', ''),
('language', 'khw', 'khowar', 1, 0, 'language.khowar', ''),
('language', 'ki', 'kikuyu', 1, 0, 'language.kikuyu', ''),
('language', 'kiu', 'kirmanjki', 1, 0, 'language.kirmanjki', ''),
('language', 'kj', 'kuanyama', 1, 0, 'language.kuanyama', ''),
('language', 'kk', 'kazakh', 1, 0, 'language.kazakh', ''),
('language', 'kkj', 'kako', 1, 0, 'language.kako', ''),
('language', 'kl', 'kalaallisut', 1, 0, 'language.kalaallisut', ''),
('language', 'kln', 'kalenjin', 1, 0, 'language.kalenjin', ''),
('language', 'km', 'khmer', 1, 0, 'language.khmer', ''),
('language', 'kmb', 'kimbundu', 1, 0, 'language.kimbundu', ''),
('language', 'kn', 'kannada', 1, 0, 'language.kannada', ''),
('language', 'ko', 'korean', 1, 0, 'language.korean', ''),
('language', 'koi', 'komi.permyak', 1, 0, 'language.komi.permyak', ''),
('language', 'kok', 'konkani', 1, 0, 'language.konkani', ''),
('language', 'kos', 'kosraean', 1, 0, 'language.kosraean', ''),
('language', 'kpe', 'kpelle', 1, 0, 'language.kpelle', ''),
('language', 'kr', 'kanuri', 1, 0, 'language.kanuri', ''),
('language', 'krc', 'karachaybalkar', 1, 0, 'language.karachaybalkar', ''),
('language', 'kri', 'krio', 1, 0, 'language.krio', ''),
('language', 'krj', 'kinaraya', 1, 0, 'language.kinaraya', ''),
('language', 'krl', 'karelian', 1, 0, 'language.karelian', ''),
('language', 'kru', 'kurukh', 1, 0, 'language.kurukh', ''),
('language', 'ks', 'kashmiri', 1, 0, 'language.kashmiri', ''),
('language', 'ksb', 'shambala', 1, 0, 'language.shambala', ''),
('language', 'ksf', 'bafia', 1, 0, 'language.bafia', ''),
('language', 'ksh', 'colognian', 1, 0, 'language.colognian', ''),
('language', 'ku', 'kurdish', 1, 0, 'language.kurdish', ''),
('language', 'kum', 'kumyk', 1, 0, 'language.kumyk', ''),
('language', 'kut', 'kutenai', 1, 0, 'language.kutenai', ''),
('language', 'kv', 'komi', 1, 0, 'language.komi', ''),
('language', 'kw', 'cornish', 1, 0, 'language.cornish', ''),
('language', 'ky', 'kyrgyz', 1, 0, 'language.kyrgyz', ''),
('language', 'la', 'latin', 1, 0, 'language.latin', ''),
('language', 'lad', 'ladino', 1, 0, 'language.ladino', ''),
('language', 'lag', 'langi', 1, 0, 'language.langi', ''),
('language', 'lah', 'lahnda', 1, 0, 'language.lahnda', ''),
('language', 'lam', 'lamba', 1, 0, 'language.lamba', ''),
('language', 'lb', 'luxembourgish', 1, 0, 'language.luxembourgish', '');
INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('language', 'lez', 'lezghian', 1, 0, 'language.lezghian', ''),
('language', 'lfn', 'linguafranca.nova', 1, 0, 'language.linguafranca.nova', ''),
('language', 'lg', 'ganda', 1, 0, 'language.ganda', ''),
('language', 'li', 'limburgish', 1, 0, 'language.limburgish', ''),
('language', 'lij', 'ligurian', 1, 0, 'language.ligurian', ''),
('language', 'liv', 'livonian', 1, 0, 'language.livonian', ''),
('language', 'lkt', 'lakota', 1, 0, 'language.lakota', ''),
('language', 'lmo', 'lombard', 1, 0, 'language.lombard', ''),
('language', 'ln', 'lingala', 1, 0, 'language.lingala', ''),
('language', 'lo', 'lao', 1, 0, 'language.lao', ''),
('language', 'lol', 'mongo', 1, 0, 'language.mongo', ''),
('language', 'loz', 'lozi', 1, 0, 'language.lozi', ''),
('language', 'lrc', 'luri.northern', 1, 0, 'language.luri.northern', ''),
('language', 'lt', 'lithuanian', 1, 0, 'language.lithuanian', ''),
('language', 'ltg', 'latgalian', 1, 0, 'language.latgalian', ''),
('language', 'lu', 'luba.katanga', 1, 0, 'language.luba.katanga', ''),
('language', 'lua', 'luba.lulua', 1, 0, 'language.luba.lulua', ''),
('language', 'lui', 'luiseno', 1, 0, 'language.luiseno', ''),
('language', 'lun', 'lunda', 1, 0, 'language.lunda', ''),
('language', 'luo', 'luo', 1, 0, 'language.luo', ''),
('language', 'lus', 'mizo', 1, 0, 'language.mizo', ''),
('language', 'luy', 'luyia', 1, 0, 'language.luyia', ''),
('language', 'lv', 'latvian', 1, 0, 'language.latvian', ''),
('language', 'lzh', 'chinese.literary', 1, 0, 'language.chinese.literary', ''),
('language', 'lzz', 'laz', 1, 0, 'language.laz', ''),
('language', 'mad', 'madurese', 1, 0, 'language.madurese', ''),
('language', 'maf', 'mafa', 1, 0, 'language.mafa', ''),
('language', 'mag', 'magahi', 1, 0, 'language.magahi', ''),
('language', 'mai', 'maithili', 1, 0, 'language.maithili', ''),
('language', 'mak', 'makasar', 1, 0, 'language.makasar', ''),
('language', 'man', 'mandingo', 1, 0, 'language.mandingo', ''),
('language', 'mas', 'masai', 1, 0, 'language.masai', ''),
('language', 'mde', 'maba', 1, 0, 'language.maba', ''),
('language', 'mdf', 'moksha', 1, 0, 'language.moksha', ''),
('language', 'mdr', 'mandar', 1, 0, 'language.mandar', ''),
('language', 'men', 'mende', 1, 0, 'language.mende', ''),
('language', 'mer', 'meru', 1, 0, 'language.meru', ''),
('language', 'mfe', 'morisyen', 1, 0, 'language.morisyen', ''),
('language', 'mg', 'malagasy', 1, 0, 'language.malagasy', ''),
('language', 'mga', 'irish.middle', 1, 0, 'language.irish.middle', ''),
('language', 'mgh', 'makhuwameetto', 1, 0, 'language.makhuwameetto', ''),
('language', 'mgo', 'meta', 1, 0, 'language.meta', ''),
('language', 'mh', 'marshallese', 1, 0, 'language.marshallese', ''),
('language', 'mi', 'maori', 1, 0, 'language.maori', ''),
('language', 'mic', 'micmac', 1, 0, 'language.micmac', ''),
('language', 'min', 'minangkabau', 1, 0, 'language.minangkabau', ''),
('language', 'mk', 'macedonian', 1, 0, 'language.macedonian', ''),
('language', 'ml', 'malayalam', 1, 0, 'language.malayalam', ''),
('language', 'mn', 'mongolian', 1, 0, 'language.mongolian', ''),
('language', 'mnc', 'manchu', 1, 0, 'language.manchu', ''),
('language', 'mni', 'manipuri', 1, 0, 'language.manipuri', ''),
('language', 'moh', 'mohawk', 1, 0, 'language.mohawk', ''),
('language', 'mos', 'mossi', 1, 0, 'language.mossi', ''),
('language', 'mr', 'marathi', 1, 0, 'language.marathi', ''),
('language', 'mrj', 'mari.western', 1, 0, 'language.mari.western', ''),
('language', 'ms', 'malay', 1, 0, 'language.malay', ''),
('language', 'mt', 'maltese', 1, 0, 'language.maltese', ''),
('language', 'mua', 'mundang', 1, 0, 'language.mundang', ''),
('language', 'mul', 'multiple', 1, 0, 'language.multiple', ''),
('language', 'mus', 'creek', 1, 0, 'language.creek', ''),
('language', 'mwl', 'mirandese', 1, 0, 'language.mirandese', ''),
('language', 'mwr', 'marwari', 1, 0, 'language.marwari', ''),
('language', 'mwv', 'mentawai', 1, 0, 'language.mentawai', ''),
('language', 'my', 'burmese', 1, 0, 'language.burmese', ''),
('language', 'mye', 'myene', 1, 0, 'language.myene', ''),
('language', 'myv', 'erzya', 1, 0, 'language.erzya', ''),
('language', 'mzn', 'mazanderani', 1, 0, 'language.mazanderani', ''),
('language', 'na', 'nauru', 1, 0, 'language.nauru', ''),
('language', 'nan', 'chinese.minnan', 1, 0, 'language.chinese.minnan', ''),
('language', 'nap', 'neapolitan', 1, 0, 'language.neapolitan', ''),
('language', 'naq', 'nama', 1, 0, 'language.nama', ''),
('language', 'nb', 'norwegian.bokmål', 1, 0, 'language.norwegian.bokmål', ''),
('language', 'nd', 'ndebele.north', 1, 0, 'language.ndebele.north', ''),
('language', 'nds', 'german.low', 1, 0, 'language.german.low', ''),
('language', 'nds-NL', 'saxon.low', 1, 0, 'language.saxon.low', ''),
('language', 'ne', 'nepali', 1, 0, 'language.nepali', ''),
('language', 'new', 'newari', 1, 0, 'language.newari', ''),
('language', 'ng', 'ndonga', 1, 0, 'language.ndonga', ''),
('language', 'nia', 'nias', 1, 0, 'language.nias', ''),
('language', 'niu', 'niuean', 1, 0, 'language.niuean', ''),
('language', 'njo', 'aonaga', 1, 0, 'language.aonaga', ''),
('language', 'nl', 'dutch', 1, 0, 'language.dutch', ''),
('language', 'nl-BE', 'flemish', 1, 0, 'language.flemish', ''),
('language', 'nmg', 'kwasio', 1, 0, 'language.kwasio', ''),
('language', 'nn', 'norwegian.nynorsk', 1, 0, 'language.norwegian.nynorsk', ''),
('language', 'nnh', 'ngiemboon', 1, 0, 'language.ngiemboon', ''),
('language', 'no', 'norwegian', 1, 0, 'language.norwegian', ''),
('language', 'nog', 'nogai', 1, 0, 'language.nogai', ''),
('language', 'non', 'norse.old', 1, 0, 'language.norse.old', ''),
('language', 'nov', 'novial', 1, 0, 'language.novial', ''),
('language', 'nqo', 'nko', 1, 0, 'language.nko', ''),
('language', 'nr', 'ndebele.south', 1, 0, 'language.ndebele.south', ''),
('language', 'nso', 'sotho.northern', 1, 0, 'language.sotho.northern', ''),
('language', 'nus', 'nuer', 1, 0, 'language.nuer', ''),
('language', 'nv', 'navajo', 1, 0, 'language.navajo', ''),
('language', 'nwc', 'newari.classical', 1, 0, 'language.newari.classical', ''),
('language', 'ny', 'nyanja', 1, 0, 'language.nyanja', ''),
('language', 'nym', 'nyamwezi', 1, 0, 'language.nyamwezi', ''),
('language', 'nyn', 'nyankole', 1, 0, 'language.nyankole', ''),
('language', 'nyo', 'nyoro', 1, 0, 'language.nyoro', ''),
('language', 'nzi', 'nzima', 1, 0, 'language.nzima', ''),
('language', 'oc', 'occitan', 1, 0, 'language.occitan', ''),
('language', 'oj', 'ojibwa', 1, 0, 'language.ojibwa', ''),
('language', 'om', 'oromo', 1, 0, 'language.oromo', ''),
('language', 'or', 'oriya', 1, 0, 'language.oriya', ''),
('language', 'os', 'ossetic', 1, 0, 'language.ossetic', ''),
('language', 'osa', 'osage', 1, 0, 'language.osage', ''),
('language', 'ota', 'turkish.ottoman', 1, 0, 'language.turkish.ottoman', ''),
('language', 'pa', 'punjabi', 1, 0, 'language.punjabi', ''),
('language', 'pag', 'pangasinan', 1, 0, 'language.pangasinan', ''),
('language', 'pal', 'pahlavi', 1, 0, 'language.pahlavi', ''),
('language', 'pam', 'pampanga', 1, 0, 'language.pampanga', ''),
('language', 'pap', 'papiamento', 1, 0, 'language.papiamento', ''),
('language', 'pau', 'palauan', 1, 0, 'language.palauan', ''),
('language', 'pcd', 'picard', 1, 0, 'language.picard', ''),
('language', 'pdc', 'german.pennsylvania', 1, 0, 'language.german.pennsylvania', ''),
('language', 'pdt', 'plautdietsch', 1, 0, 'language.plautdietsch', ''),
('language', 'peo', 'persian.old', 1, 0, 'language.persian.old', ''),
('language', 'pfl', 'german.palatine', 1, 0, 'language.german.palatine', ''),
('language', 'phn', 'phoenician', 1, 0, 'language.phoenician', ''),
('language', 'pi', 'pali', 1, 0, 'language.pali', ''),
('language', 'pl', 'polish', 1, 0, 'language.polish', ''),
('language', 'pms', 'piedmontese', 1, 0, 'language.piedmontese', ''),
('language', 'pnt', 'pontic', 1, 0, 'language.pontic', ''),
('language', 'pon', 'pohnpeian', 1, 0, 'language.pohnpeian', ''),
('language', 'prg', 'prussian', 1, 0, 'language.prussian', ''),
('language', 'pro', 'provençal.old', 1, 0, 'language.provençal.old', ''),
('language', 'ps', 'pashto', 1, 0, 'language.pashto', ''),
('language', 'pt', 'portuguese', 1, 0, 'language.portuguese', ''),
('language', 'pt-BR', 'portuguese.brazilian', 1, 0, 'language.portuguese.brazilian', ''),
('language', 'pt-PT', 'portuguese.european', 1, 0, 'language.portuguese.european', ''),
('language', 'qu', 'quechua', 1, 0, 'language.quechua', ''),
('language', 'quc', 'kiche', 1, 0, 'language.kiche', ''),
('language', 'qug', 'quichua.chimborazohighland', 1, 0, 'language.quichua.chimborazohighland', ''),
('language', 'raj', 'rajasthani', 1, 0, 'language.rajasthani', ''),
('language', 'rap', 'rapanui', 1, 0, 'language.rapanui', ''),
('language', 'rar', 'rarotongan', 1, 0, 'language.rarotongan', ''),
('language', 'rgn', 'romagnol', 1, 0, 'language.romagnol', ''),
('language', 'rif', 'riffian', 1, 0, 'language.riffian', ''),
('language', 'rm', 'romansh', 1, 0, 'language.romansh', ''),
('language', 'rn', 'rundi', 1, 0, 'language.rundi', ''),
('language', 'ro', 'romanian', 1, 0, 'language.romanian', ''),
('language', 'ro-MD', 'moldavian', 1, 0, 'language.moldavian', ''),
('language', 'rof', 'rombo', 1, 0, 'language.rombo', ''),
('language', 'rom', 'romany', 1, 0, 'language.romany', ''),
('language', 'root', 'root', 1, 0, 'language.root', ''),
('language', 'rtm', 'rotuman', 1, 0, 'language.rotuman', ''),
('language', 'ru', 'russian', 1, 0, 'language.russian', ''),
('language', 'rue', 'rusyn', 1, 0, 'language.rusyn', ''),
('language', 'rug', 'roviana', 1, 0, 'language.roviana', ''),
('language', 'rup', 'aromanian', 1, 0, 'language.aromanian', ''),
('language', 'rw', 'kinyarwanda', 1, 0, 'language.kinyarwanda', ''),
('language', 'rwk', 'rwa', 1, 0, 'language.rwa', ''),
('language', 'sa', 'sanskrit', 1, 0, 'language.sanskrit', ''),
('language', 'sad', 'sandawe', 1, 0, 'language.sandawe', ''),
('language', 'sah', 'sakha', 1, 0, 'language.sakha', ''),
('language', 'sam', 'aramaic.samaritan', 1, 0, 'language.aramaic.samaritan', ''),
('language', 'saq', 'samburu', 1, 0, 'language.samburu', ''),
('language', 'sas', 'sasak', 1, 0, 'language.sasak', ''),
('language', 'sat', 'santali', 1, 0, 'language.santali', ''),
('language', 'saz', 'saurashtra', 1, 0, 'language.saurashtra', ''),
('language', 'sba', 'ngambay', 1, 0, 'language.ngambay', ''),
('language', 'sbp', 'sangu', 1, 0, 'language.sangu', ''),
('language', 'sc', 'sardinian', 1, 0, 'language.sardinian', ''),
('language', 'scn', 'sicilian', 1, 0, 'language.sicilian', ''),
('language', 'sco', 'scots', 1, 0, 'language.scots', ''),
('language', 'sd', 'sindhi', 1, 0, 'language.sindhi', ''),
('language', 'sdc', 'sardinian.sassarese', 1, 0, 'language.sardinian.sassarese', ''),
('language', 'sdh', 'southern kurdish', 1, 0, 'language.southern kurdish', ''),
('language', 'se', 'northern sami', 1, 0, 'language.northern sami', ''),
('language', 'see', 'seneca', 1, 0, 'language.seneca', ''),
('language', 'seh', 'sena', 1, 0, 'language.sena', ''),
('language', 'sei', 'seri', 1, 0, 'language.seri', ''),
('language', 'sel', 'selkup', 1, 0, 'language.selkup', ''),
('language', 'ses', 'senni.koyraboro', 1, 0, 'language.senni.koyraboro', ''),
('language', 'sg', 'sango', 1, 0, 'language.sango', ''),
('language', 'sga', 'irish.old', 1, 0, 'language.irish.old', ''),
('language', 'sgs', 'samogitian', 1, 0, 'language.samogitian', ''),
('language', 'sh', 'serbocroatian', 1, 0, 'language.serbocroatian', ''),
('language', 'shi', 'tachelhit', 1, 0, 'language.tachelhit', ''),
('language', 'shn', 'shan', 1, 0, 'language.shan', ''),
('language', 'shu', 'arabic.chadian', 1, 0, 'language.arabic.chadian', ''),
('language', 'si', 'sinhala', 1, 0, 'language.sinhala', ''),
('language', 'sid', 'sidamo', 1, 0, 'language.sidamo', ''),
('language', 'sk', 'slovak', 1, 0, 'language.slovak', ''),
('language', 'sl', 'slovenian', 1, 0, 'language.slovenian', ''),
('language', 'sli', 'silesian.lower', 1, 0, 'language.silesian.lower', ''),
('language', 'sly', 'selayar', 1, 0, 'language.selayar', ''),
('language', 'sm', 'samoan', 1, 0, 'language.samoan', ''),
('language', 'sma', 'sami.southern', 1, 0, 'language.sami.southern', ''),
('language', 'smj', 'sami.lule', 1, 0, 'language.sami.lule', ''),
('language', 'smn', 'sami.inari', 1, 0, 'language.sami.inari', ''),
('language', 'sms', 'sami.skolt', 1, 0, 'language.sami.skolt', ''),
('language', 'sn', 'shona', 1, 0, 'language.shona', ''),
('language', 'snk', 'soninke', 1, 0, 'language.soninke', ''),
('language', 'so', 'somali', 1, 0, 'language.somali', ''),
('language', 'sog', 'sogdien', 1, 0, 'language.sogdien', ''),
('language', 'sq', 'albanian', 1, 0, 'language.albanian', ''),
('language', 'sr', 'serbian', 1, 0, 'language.serbian', ''),
('language', 'srn', 'tongo.sranan', 1, 0, 'language.tongo.sranan', ''),
('language', 'srr', 'serer', 1, 0, 'language.serer', ''),
('language', 'ss', 'swati', 1, 0, 'language.swati', ''),
('language', 'ssy', 'saho', 1, 0, 'language.saho', ''),
('language', 'st', 'sotho.southern', 1, 0, 'language.sotho.southern', ''),
('language', 'stq', 'frisian.saterland', 1, 0, 'language.frisian.saterland', ''),
('language', 'su', 'sundanese', 1, 0, 'language.sundanese', ''),
('language', 'suk', 'sukuma', 1, 0, 'language.sukuma', ''),
('language', 'sus', 'susu', 1, 0, 'language.susu', ''),
('language', 'sux', 'sumerian', 1, 0, 'language.sumerian', ''),
('language', 'sv', 'swedish', 1, 0, 'language.swedish', ''),
('language', 'sw', 'swahili', 1, 0, 'language.swahili', ''),
('language', 'sw-CD', 'swahili.congo', 1, 0, 'language.swahili.congo', ''),
('language', 'swb', 'comorian', 1, 0, 'language.comorian', ''),
('language', 'syc', 'syriac.classical', 1, 0, 'language.syriac.classical', ''),
('language', 'syr', 'syriac', 1, 0, 'language.syriac', ''),
('language', 'szl', 'silesian', 1, 0, 'language.silesian', ''),
('language', 'ta', 'tamil', 1, 0, 'language.tamil', ''),
('language', 'tcy', 'tulu', 1, 0, 'language.tulu', ''),
('language', 'te', 'telugu', 1, 0, 'language.telugu', ''),
('language', 'tem', 'timne', 1, 0, 'language.timne', ''),
('language', 'teo', 'teso', 1, 0, 'language.teso', ''),
('language', 'ter', 'tereno', 1, 0, 'language.tereno', ''),
('language', 'tet', 'tetum', 1, 0, 'language.tetum', ''),
('language', 'tg', 'tajik', 1, 0, 'language.tajik', ''),
('language', 'th', 'thai', 1, 0, 'language.thai', ''),
('language', 'ti', 'tigrinya', 1, 0, 'language.tigrinya', ''),
('language', 'tig', 'tigre', 1, 0, 'language.tigre', ''),
('language', 'tiv', 'tiv', 1, 0, 'language.tiv', ''),
('language', 'tk', 'turkmen', 1, 0, 'language.turkmen', ''),
('language', 'tkl', 'tokelau', 1, 0, 'language.tokelau', ''),
('language', 'tkr', 'tsakhur', 1, 0, 'language.tsakhur', ''),
('language', 'tl', 'tagalog', 1, 0, 'language.tagalog', ''),
('language', 'tlh', 'klingon', 1, 0, 'language.klingon', ''),
('language', 'tli', 'tlingit', 1, 0, 'language.tlingit', ''),
('language', 'tly', 'talysh', 1, 0, 'language.talysh', ''),
('language', 'tmh', 'tamashek', 1, 0, 'language.tamashek', ''),
('language', 'tn', 'tswana', 1, 0, 'language.tswana', ''),
('language', 'to', 'tongan', 1, 0, 'language.tongan', ''),
('language', 'tog', 'tonga.nyasa', 1, 0, 'language.tonga.nyasa', ''),
('language', 'tpi', 'pisin.tok', 1, 0, 'language.pisin.tok', ''),
('language', 'tr', 'turkish', 1, 0, 'language.turkish', ''),
('language', 'tru', 'turoyo', 1, 0, 'language.turoyo', ''),
('language', 'trv', 'taroko', 1, 0, 'language.taroko', ''),
('language', 'ts', 'tsonga', 1, 0, 'language.tsonga', ''),
('language', 'tsd', 'tsakonian', 1, 0, 'language.tsakonian', ''),
('language', 'tsi', 'tsimshian', 1, 0, 'language.tsimshian', ''),
('language', 'tt', 'tatar', 1, 0, 'language.tatar', ''),
('language', 'ttt', 'tat.muslim', 1, 0, 'language.tat.muslim', ''),
('language', 'tum', 'tumbuka', 1, 0, 'language.tumbuka', ''),
('language', 'tvl', 'tuvalu', 1, 0, 'language.tuvalu', ''),
('language', 'tw', 'twi', 1, 0, 'language.twi', ''),
('language', 'twq', 'tasawaq', 1, 0, 'language.tasawaq', ''),
('language', 'ty', 'tahitian', 1, 0, 'language.tahitian', ''),
('language', 'tyv', 'tuvinian', 1, 0, 'language.tuvinian', ''),
('language', 'tzm', 'tamazight.centralatlas', 1, 0, 'language.tamazight.centralatlas', ''),
('language', 'udm', 'udmurt', 1, 0, 'language.udmurt', ''),
('language', 'ug', 'uyghur', 1, 0, 'language.uyghur', ''),
('language', 'uga', 'ugaritic', 1, 0, 'language.ugaritic', ''),
('language', 'uk', 'ukrainian', 1, 0, 'language.ukrainian', ''),
('language', 'umb', 'umbundu', 1, 0, 'language.umbundu', ''),
('language', 'und', 'unknown', 1, 0, 'language.unknown', ''),
('language', 'ur', 'urdu', 1, 0, 'language.urdu', ''),
('language', 'uz', 'uzbek', 1, 0, 'language.uzbek', ''),
('language', 'vai', 'vai', 1, 0, 'language.vai', ''),
('language', 've', 'venda', 1, 0, 'language.venda', ''),
('language', 'vec', 'venetian', 1, 0, 'language.venetian', ''),
('language', 'vep', 'veps', 1, 0, 'language.veps', ''),
('language', 'vi', 'vietnamese', 1, 0, 'language.vietnamese', ''),
('language', 'vls', 'flemish.west', 1, 0, 'language.flemish.west', ''),
('language', 'vmf', 'franconian.main', 1, 0, 'language.franconian.main', ''),
('language', 'vo', 'volapük', 1, 0, 'language.volapük', ''),
('language', 'vot', 'votic', 1, 0, 'language.votic', ''),
('language', 'vro', 'võro', 1, 0, 'language.võro', ''),
('language', 'vun', 'vunjo', 1, 0, 'language.vunjo', ''),
('language', 'wa', 'walloon', 1, 0, 'language.walloon', ''),
('language', 'wae', 'walser', 1, 0, 'language.walser', ''),
('language', 'wal', 'wolaytta', 1, 0, 'language.wolaytta', ''),
('language', 'war', 'waray', 1, 0, 'language.waray', ''),
('language', 'was', 'washo', 1, 0, 'language.washo', ''),
('language', 'wbp', 'warlpiri', 1, 0, 'language.warlpiri', ''),
('language', 'wo', 'wolof', 1, 0, 'language.wolof', ''),
('language', 'wuu', 'chinese.wu', 1, 0, 'language.chinese.wu', ''),
('language', 'xal', 'kalmyk', 1, 0, 'language.kalmyk', ''),
('language', 'xh', 'xhosa', 1, 0, 'language.xhosa', ''),
('language', 'xmf', 'mingrelian', 1, 0, 'language.mingrelian', ''),
('language', 'xog', 'soga', 1, 0, 'language.soga', ''),
('language', 'yao', 'yao', 1, 0, 'language.yao', ''),
('language', 'yap', 'yapese', 1, 0, 'language.yapese', ''),
('language', 'yav', 'yangben', 1, 0, 'language.yangben', ''),
('language', 'ybb', 'yemba', 1, 0, 'language.yemba', ''),
('language', 'yi', 'yiddish', 1, 0, 'language.yiddish', ''),
('language', 'yo', 'yoruba', 1, 0, 'language.yoruba', ''),
('language', 'yrl', 'nheengatu', 1, 0, 'language.nheengatu', ''),
('language', 'yue', 'cantonese', 1, 0, 'language.cantonese', ''),
('language', 'za', 'zhuang', 1, 0, 'language.zhuang', ''),
('language', 'zap', 'zapotec', 1, 0, 'language.zapotec', ''),
('language', 'zbl', 'blissymbols', 1, 0, 'language.blissymbols', ''),
('language', 'zea', 'zeelandic', 1, 0, 'language.zeelandic', ''),
('language', 'zen', 'zenaga', 1, 0, 'language.zenaga', ''),
('language', 'zgh', 'tamazight.standardmoroccan', 1, 0, 'language.tamazight.standardmoroccan', ''),
('language', 'zh', 'chinese', 1, 0, 'language.chinese', ''),
('language', 'zh-Hans', 'chinese.simplified', 1, 0, 'language.chinese.simplified', ''),
('language', 'zh-Hant', 'chinese.traditional', 1, 0, 'language.chinese.traditional', ''),
('language', 'zu', 'zulu', 1, 0, 'language.zulu', ''),
('language', 'zun', 'zuni', 1, 0, 'language.zuni', ''),
('language', 'zxx', 'none', 1, 0, 'language.none', ''),
('language', 'zza', 'zaza', 1, 0, 'language.zaza', ''),
('mass', 'g', 'gram', 1, 0, 'mass.gram', ''),
('mass', 'kg', 'kilogram', 1, 0, 'mass.kilogram', ''),
('mass', 'mg', 'milligram', 1, 0, 'mass.milligram', ''),
('mass', 't', 'tonne', 1, 0, 'mass.tonne', ''),
('mass', 'µg', 'microgram', 1, 0, 'mass.microgram', '');

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
('da', 'vocabulary', 'core.file.status.checkedin', 'default', 'core.file.status.checkedin', ''),
('da', 'vocabulary', 'core.file.status.checkedout', 'default', 'core.file.status.checkedout', ''),
('da', 'vocabulary', 'core.file.status.expired', 'default', 'core.file.status.expired', ''),
('da', 'vocabulary', 'core.file.status.locked', 'default', 'core.file.status.locked', ''),
('da', 'vocabulary', 'core.file.status.new', 'default', 'core.file.status.new', ''),
('da', 'vocabulary', 'core.file.type.audio', 'default', 'core.file.type.audio', ''),
('da', 'vocabulary', 'core.file.type.document', 'default', 'core.file.type.document', ''),
('da', 'vocabulary', 'core.file.type.image', 'default', 'core.file.type.image', ''),
('da', 'vocabulary', 'core.file.type.other', 'default', 'core.file.type.other', ''),
('da', 'vocabulary', 'core.file.type.text', 'default', 'core.file.type.text', ''),
('da', 'vocabulary', 'core.file.type.video', 'default', 'core.file.type.video', ''),
('da', 'vocabulary', 'crs.wgs84', 'default', 'crs.wgs84', ''),
('da', 'vocabulary', 'dime.actor.type.institution', 'default', 'dime.actor.type.institution', ''),
('da', 'vocabulary', 'dime.actor.type.museum', 'default', 'Museum', ''),
('da', 'vocabulary', 'dime.actor.type.person', 'default', 'dime.actor.type.person', ''),
('da', 'vocabulary', 'dime.dime.secondary.other', 'default', 'Andet', ''),
('da', 'vocabulary', 'dime.dime.secondary.tinned', 'default', 'Fortinnet', ''),
('da', 'vocabulary', 'dime.find.condition.fragmented', 'default', 'Fragmenteret', ''),
('da', 'vocabulary', 'dime.find.condition.whole', 'default', 'Hel', ''),
('da', 'vocabulary', 'dime.find.secondary.enamel', 'default', 'Emalje', ''),
('da', 'vocabulary', 'dime.find.secondary.gilded', 'default', 'Forgyldt', ''),
('da', 'vocabulary', 'dime.find.secondary.glass', 'default', 'Glas', ''),
('da', 'vocabulary', 'dime.find.secondary.iron', 'default', 'Jern', ''),
('da', 'vocabulary', 'dime.find.secondary.niello', 'default', 'Niello', ''),
('da', 'vocabulary', 'dime.find.secondary.organic', 'default', 'Organisk', ''),
('da', 'vocabulary', 'dime.find.secondary.stone', 'default', 'Sten', ''),
('da', 'vocabulary', 'dime.find.type.accessory', 'default', 'Smykke / Dragttilbehør', ''),
('da', 'vocabulary', 'dime.find.type.coin', 'default', 'Mønt', ''),
('da', 'vocabulary', 'dime.find.type.fibula', 'default', 'Fibula / Dragtspænde', ''),
('da', 'vocabulary', 'dime.find.type.military', 'default', 'Våben / Militaria', ''),
('da', 'vocabulary', 'dime.find.type.tool', 'default', 'Redskab / Værktøj', ''),
('da', 'vocabulary', 'dime.find.type.waste', 'default', 'Produktionsaffald / Metalskrot', ''),
('da', 'vocabulary', 'dime.kommune.aabenraa', 'default', 'Aabenraa', ''),
('da', 'vocabulary', 'dime.kommune.aabenraa', 'official', 'Aabenraa Kommune', ''),
('da', 'vocabulary', 'dime.kommune.aalborg', 'default', 'Aalborg', ''),
('da', 'vocabulary', 'dime.kommune.aalborg', 'official', 'Aalborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.aero', 'default', 'Ærø', ''),
('da', 'vocabulary', 'dime.kommune.aero', 'official', 'Ærø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.albertslund', 'default', 'Albertslund', ''),
('da', 'vocabulary', 'dime.kommune.albertslund', 'official', 'Albertslund Kommune', ''),
('da', 'vocabulary', 'dime.kommune.allerod', 'default', 'Allerød', ''),
('da', 'vocabulary', 'dime.kommune.allerod', 'official', 'Allerød Kommune', ''),
('da', 'vocabulary', 'dime.kommune.arhus', 'default', 'Århus', ''),
('da', 'vocabulary', 'dime.kommune.arhus', 'official', 'Århus Kommune', ''),
('da', 'vocabulary', 'dime.kommune.assens', 'default', 'Assens', ''),
('da', 'vocabulary', 'dime.kommune.assens', 'official', 'Assens Kommune', ''),
('da', 'vocabulary', 'dime.kommune.ballerup', 'default', 'Ballerup', ''),
('da', 'vocabulary', 'dime.kommune.ballerup', 'official', 'Ballerup Kommune', ''),
('da', 'vocabulary', 'dime.kommune.billund', 'default', 'Billund', ''),
('da', 'vocabulary', 'dime.kommune.billund', 'official', 'Billund Kommune', ''),
('da', 'vocabulary', 'dime.kommune.bornholm', 'default', 'Bornholm', ''),
('da', 'vocabulary', 'dime.kommune.bornholm', 'official', 'Bornholms Kommune', ''),
('da', 'vocabulary', 'dime.kommune.brondby', 'default', 'Brøndby', ''),
('da', 'vocabulary', 'dime.kommune.brondby', 'official', 'Brøndby Kommune', ''),
('da', 'vocabulary', 'dime.kommune.bronderslev', 'default', 'Brønderslev', ''),
('da', 'vocabulary', 'dime.kommune.bronderslev', 'official', 'Brønderslev Kommune', ''),
('da', 'vocabulary', 'dime.kommune.dragor', 'default', 'Dragør', ''),
('da', 'vocabulary', 'dime.kommune.dragor', 'official', 'Dragør Kommune', ''),
('da', 'vocabulary', 'dime.kommune.egedal', 'default', 'Egedal', ''),
('da', 'vocabulary', 'dime.kommune.egedal', 'official', 'Egedal Kommune', ''),
('da', 'vocabulary', 'dime.kommune.esbjerg', 'default', 'Esbjerg', ''),
('da', 'vocabulary', 'dime.kommune.esbjerg', 'official', 'Esbjerg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.faaborgmidtfyn', 'default', 'Faaborg-Midtfyn', ''),
('da', 'vocabulary', 'dime.kommune.faaborgmidtfyn', 'official', 'Faaborg-Midtfyn Kommune', ''),
('da', 'vocabulary', 'dime.kommune.fano', 'default', 'Fanø', ''),
('da', 'vocabulary', 'dime.kommune.fano', 'official', 'Fanø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.favrskov', 'default', 'Favrskov', ''),
('da', 'vocabulary', 'dime.kommune.favrskov', 'official', 'Favrskov Kommune', ''),
('da', 'vocabulary', 'dime.kommune.faxe', 'default', 'Faxe', ''),
('da', 'vocabulary', 'dime.kommune.faxe', 'official', 'Faxe Kommune', ''),
('da', 'vocabulary', 'dime.kommune.fredensborg', 'default', 'Fredensborg', ''),
('da', 'vocabulary', 'dime.kommune.fredensborg', 'official', 'Fredensborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.fredericia', 'default', 'Fredericia', ''),
('da', 'vocabulary', 'dime.kommune.fredericia', 'official', 'Fredericia Kommune', ''),
('da', 'vocabulary', 'dime.kommune.frederiksbeg', 'default', 'Frederiksbeg', ''),
('da', 'vocabulary', 'dime.kommune.frederiksbeg', 'official', 'Frederiksberg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.frederikshavn', 'default', 'Frederikshavn', ''),
('da', 'vocabulary', 'dime.kommune.frederikshavn', 'official', 'Frederikshavn Kommune', ''),
('da', 'vocabulary', 'dime.kommune.frederikssund', 'default', 'Frederikssund', ''),
('da', 'vocabulary', 'dime.kommune.frederikssund', 'official', 'Frederikssund Kommune', ''),
('da', 'vocabulary', 'dime.kommune.fureso', 'default', 'Furesø', ''),
('da', 'vocabulary', 'dime.kommune.fureso', 'official', 'Furesø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.gentofte', 'default', 'Gentofte', ''),
('da', 'vocabulary', 'dime.kommune.gentofte', 'official', 'Gentofte Kommune', ''),
('da', 'vocabulary', 'dime.kommune.gladsaxe', 'default', 'Gladsaxe', ''),
('da', 'vocabulary', 'dime.kommune.gladsaxe', 'official', 'Gladsaxe Kommune', ''),
('da', 'vocabulary', 'dime.kommune.glostrup', 'default', 'Glostrup', ''),
('da', 'vocabulary', 'dime.kommune.glostrup', 'official', 'Glostrup Kommune', ''),
('da', 'vocabulary', 'dime.kommune.greve', 'default', 'Greve', ''),
('da', 'vocabulary', 'dime.kommune.greve', 'official', 'Greve Kommune', ''),
('da', 'vocabulary', 'dime.kommune.gribskov', 'default', 'Gribskov', ''),
('da', 'vocabulary', 'dime.kommune.gribskov', 'official', 'Gribskov Kommune', ''),
('da', 'vocabulary', 'dime.kommune.guldborgsund', 'default', 'Guldborgsund', ''),
('da', 'vocabulary', 'dime.kommune.guldborgsund', 'official', 'Guldborgsund Kommune', ''),
('da', 'vocabulary', 'dime.kommune.haderslev', 'default', 'Haderslev', ''),
('da', 'vocabulary', 'dime.kommune.haderslev', 'official', 'Haderslev Kommune', ''),
('da', 'vocabulary', 'dime.kommune.halsnaes', 'default', 'Halsnæs', ''),
('da', 'vocabulary', 'dime.kommune.halsnaes', 'official', 'Halsnæs Kommune', ''),
('da', 'vocabulary', 'dime.kommune.hedensted', 'default', 'Hedensted', ''),
('da', 'vocabulary', 'dime.kommune.hedensted', 'official', 'Hedensted Kommune', ''),
('da', 'vocabulary', 'dime.kommune.helsingor', 'default', 'Helsingør', ''),
('da', 'vocabulary', 'dime.kommune.helsingor', 'official', 'Helsingør Kommune', ''),
('da', 'vocabulary', 'dime.kommune.herlev', 'default', 'Herlev', ''),
('da', 'vocabulary', 'dime.kommune.herlev', 'official', 'Herlev Kommune', ''),
('da', 'vocabulary', 'dime.kommune.herning', 'default', 'Herning', ''),
('da', 'vocabulary', 'dime.kommune.herning', 'official', 'Herning Kommune', ''),
('da', 'vocabulary', 'dime.kommune.hillerod', 'default', 'Hillerød', ''),
('da', 'vocabulary', 'dime.kommune.hillerod', 'official', 'Hillerød Kommune', ''),
('da', 'vocabulary', 'dime.kommune.hjorring', 'default', 'Hjørring', ''),
('da', 'vocabulary', 'dime.kommune.hjorring', 'official', 'Hjørring Kommune', ''),
('da', 'vocabulary', 'dime.kommune.hojetaastrup', 'default', 'Høje-Taastrup', ''),
('da', 'vocabulary', 'dime.kommune.hojetaastrup', 'official', 'Høje-Taastrup Kommune', ''),
('da', 'vocabulary', 'dime.kommune.holbaek', 'default', 'Holbæk', ''),
('da', 'vocabulary', 'dime.kommune.holbaek', 'official', 'Holbæk Kommune', ''),
('da', 'vocabulary', 'dime.kommune.holstebro', 'default', 'Holstebro', ''),
('da', 'vocabulary', 'dime.kommune.holstebro', 'official', 'Holstebro Kommune', ''),
('da', 'vocabulary', 'dime.kommune.horsens', 'default', 'Horsens', ''),
('da', 'vocabulary', 'dime.kommune.horsens', 'official', 'Horsens Kommune', ''),
('da', 'vocabulary', 'dime.kommune.horsholm', 'default', 'Hørsholm', ''),
('da', 'vocabulary', 'dime.kommune.horsholm', 'official', 'Hørsholm Kommune', ''),
('da', 'vocabulary', 'dime.kommune.hvidovre', 'default', 'Hvidovre', ''),
('da', 'vocabulary', 'dime.kommune.hvidovre', 'official', 'Hvidovre Kommune', ''),
('da', 'vocabulary', 'dime.kommune.ikastbrande', 'default', 'Ikast-Brande', ''),
('da', 'vocabulary', 'dime.kommune.ikastbrande', 'official', 'Ikast-Brande Kommune', ''),
('da', 'vocabulary', 'dime.kommune.ishoj', 'default', 'Ishøj', ''),
('da', 'vocabulary', 'dime.kommune.ishoj', 'official', 'Ishøj Kommune', ''),
('da', 'vocabulary', 'dime.kommune.jammerbugt', 'default', 'Jammerbugt', ''),
('da', 'vocabulary', 'dime.kommune.jammerbugt', 'official', 'Jammerbugt Kommune', ''),
('da', 'vocabulary', 'dime.kommune.kalundborg', 'default', 'Kalundborg', ''),
('da', 'vocabulary', 'dime.kommune.kalundborg', 'official', 'Kalundborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.kerteminde', 'default', 'Kerteminde', ''),
('da', 'vocabulary', 'dime.kommune.kerteminde', 'official', 'Kerteminde Kommune', ''),
('da', 'vocabulary', 'dime.kommune.kobenhavn', 'default', 'København', ''),
('da', 'vocabulary', 'dime.kommune.kobenhavn', 'official', 'Københavns Kommune', ''),
('da', 'vocabulary', 'dime.kommune.koge', 'default', 'Køge', ''),
('da', 'vocabulary', 'dime.kommune.koge', 'official', 'Køge Kommune', ''),
('da', 'vocabulary', 'dime.kommune.kolding', 'default', 'Kolding', ''),
('da', 'vocabulary', 'dime.kommune.kolding', 'official', 'Kolding Kommune', ''),
('da', 'vocabulary', 'dime.kommune.laeso', 'default', 'Læsø', ''),
('da', 'vocabulary', 'dime.kommune.laeso', 'official', 'Læsø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.langeland', 'default', 'Langeland', ''),
('da', 'vocabulary', 'dime.kommune.langeland', 'official', 'Langeland Kommune', ''),
('da', 'vocabulary', 'dime.kommune.lejre', 'default', 'Lejre', ''),
('da', 'vocabulary', 'dime.kommune.lejre', 'official', 'Lejre Kommune', ''),
('da', 'vocabulary', 'dime.kommune.lemvig', 'default', 'Lemvig', ''),
('da', 'vocabulary', 'dime.kommune.lemvig', 'official', 'Lemvig Kommune', ''),
('da', 'vocabulary', 'dime.kommune.lolland', 'default', 'Lolland', ''),
('da', 'vocabulary', 'dime.kommune.lolland', 'official', 'Lolland Kommune', ''),
('da', 'vocabulary', 'dime.kommune.lyngbytaarbaek', 'default', 'Lyngby-Taarbæk', ''),
('da', 'vocabulary', 'dime.kommune.lyngbytaarbaek', 'official', 'Lyngby-Taarbæk Kommune', ''),
('da', 'vocabulary', 'dime.kommune.mariagerfjord', 'default', 'Mariagerfjord', ''),
('da', 'vocabulary', 'dime.kommune.mariagerfjord', 'official', 'Mariagerfjord Kommune', ''),
('da', 'vocabulary', 'dime.kommune.middelfart', 'default', 'Middelfart', ''),
('da', 'vocabulary', 'dime.kommune.middelfart', 'official', 'Middelfart Kommune', ''),
('da', 'vocabulary', 'dime.kommune.morso', 'default', 'Morsø', ''),
('da', 'vocabulary', 'dime.kommune.morso', 'official', 'Morsø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.naestved', 'default', 'Næstved', ''),
('da', 'vocabulary', 'dime.kommune.naestved', 'official', 'Næstved Kommune', ''),
('da', 'vocabulary', 'dime.kommune.norddjurs', 'default', 'Norddjurs', ''),
('da', 'vocabulary', 'dime.kommune.norddjurs', 'official', 'Norddjurs Kommune', ''),
('da', 'vocabulary', 'dime.kommune.nordfyns', 'default', 'Nordfyns', ''),
('da', 'vocabulary', 'dime.kommune.nordfyns', 'official', 'Nordfyns Kommune', ''),
('da', 'vocabulary', 'dime.kommune.nyborg', 'default', 'Nyborg', ''),
('da', 'vocabulary', 'dime.kommune.nyborg', 'official', 'Nyborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.odder', 'default', 'Odder', ''),
('da', 'vocabulary', 'dime.kommune.odder', 'official', 'Odder Kommune', ''),
('da', 'vocabulary', 'dime.kommune.odense', 'default', 'Odense', ''),
('da', 'vocabulary', 'dime.kommune.odense', 'official', 'Odense Kommune', ''),
('da', 'vocabulary', 'dime.kommune.odsherred', 'default', 'Odsherred', ''),
('da', 'vocabulary', 'dime.kommune.odsherred', 'official', 'Odsherred Kommune', ''),
('da', 'vocabulary', 'dime.kommune.randers', 'default', 'Randers', ''),
('da', 'vocabulary', 'dime.kommune.randers', 'official', 'Randers Kommune', ''),
('da', 'vocabulary', 'dime.kommune.rebild', 'default', 'Rebild', ''),
('da', 'vocabulary', 'dime.kommune.rebild', 'official', 'Rebild Kommune', ''),
('da', 'vocabulary', 'dime.kommune.ringkobingskjern', 'default', 'Ringkøbing-Skjern', ''),
('da', 'vocabulary', 'dime.kommune.ringkobingskjern', 'official', 'Ringkøbing-Skjern Kommune', ''),
('da', 'vocabulary', 'dime.kommune.ringsted', 'default', 'Ringsted', ''),
('da', 'vocabulary', 'dime.kommune.ringsted', 'official', 'Ringsted Kommune', ''),
('da', 'vocabulary', 'dime.kommune.rodovre', 'default', 'Rødovre', ''),
('da', 'vocabulary', 'dime.kommune.rodovre', 'official', 'Rødovre Kommune', ''),
('da', 'vocabulary', 'dime.kommune.roskilde', 'default', 'Roskilde', ''),
('da', 'vocabulary', 'dime.kommune.roskilde', 'official', 'Roskilde Kommune', ''),
('da', 'vocabulary', 'dime.kommune.rudersdal', 'default', 'Rudersdal', ''),
('da', 'vocabulary', 'dime.kommune.rudersdal', 'official', 'Rudersdal Kommune', ''),
('da', 'vocabulary', 'dime.kommune.samso', 'default', 'Samsø', ''),
('da', 'vocabulary', 'dime.kommune.samso', 'official', 'Samsø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.silkeborg', 'default', 'Silkeborg', ''),
('da', 'vocabulary', 'dime.kommune.silkeborg', 'official', 'Silkeborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.skanderborg', 'default', 'Skanderborg', ''),
('da', 'vocabulary', 'dime.kommune.skanderborg', 'official', 'Skanderborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.skive', 'default', 'Skive', ''),
('da', 'vocabulary', 'dime.kommune.skive', 'official', 'Skive Kommune', ''),
('da', 'vocabulary', 'dime.kommune.slagelse', 'default', 'Slagelse', ''),
('da', 'vocabulary', 'dime.kommune.slagelse', 'official', 'Slagelse Kommune', ''),
('da', 'vocabulary', 'dime.kommune.solrod', 'default', 'Solrød', ''),
('da', 'vocabulary', 'dime.kommune.solrod', 'official', 'Solrød Kommune', ''),
('da', 'vocabulary', 'dime.kommune.sonderborg', 'default', 'Sønderborg', ''),
('da', 'vocabulary', 'dime.kommune.sonderborg', 'official', 'Sønderborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.soro', 'default', 'Sorø', ''),
('da', 'vocabulary', 'dime.kommune.soro', 'official', 'Sorø Kommune', ''),
('da', 'vocabulary', 'dime.kommune.stevns', 'default', 'Stevns', ''),
('da', 'vocabulary', 'dime.kommune.stevns', 'official', 'Stevns Kommune', ''),
('da', 'vocabulary', 'dime.kommune.struer', 'default', 'Struer', ''),
('da', 'vocabulary', 'dime.kommune.struer', 'official', 'Struer Kommune', ''),
('da', 'vocabulary', 'dime.kommune.svendborg', 'default', 'Svendborg', ''),
('da', 'vocabulary', 'dime.kommune.svendborg', 'official', 'Svendborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.syddjurs', 'default', 'Syddjurs', ''),
('da', 'vocabulary', 'dime.kommune.syddjurs', 'official', 'Syddjurs Kommune', ''),
('da', 'vocabulary', 'dime.kommune.tarnby', 'default', 'Tårnby', ''),
('da', 'vocabulary', 'dime.kommune.tarnby', 'official', 'Tårnby Kommune', ''),
('da', 'vocabulary', 'dime.kommune.thisted', 'default', 'Thisted', ''),
('da', 'vocabulary', 'dime.kommune.thisted', 'official', 'Thisted Kommune', ''),
('da', 'vocabulary', 'dime.kommune.tonder', 'default', 'Tønder', ''),
('da', 'vocabulary', 'dime.kommune.tonder', 'official', 'Tønder Kommune', ''),
('da', 'vocabulary', 'dime.kommune.vallensbaek', 'default', 'Vallensbæk', ''),
('da', 'vocabulary', 'dime.kommune.vallensbaek', 'official', 'Vallensbæk Kommune', ''),
('da', 'vocabulary', 'dime.kommune.varde', 'default', 'Varde', ''),
('da', 'vocabulary', 'dime.kommune.varde', 'official', 'Varde Kommune', ''),
('da', 'vocabulary', 'dime.kommune.vejen', 'default', 'Vejen', ''),
('da', 'vocabulary', 'dime.kommune.vejen', 'official', 'Vejen Kommune', ''),
('da', 'vocabulary', 'dime.kommune.vejle', 'default', 'Vejle', ''),
('da', 'vocabulary', 'dime.kommune.vejle', 'official', 'Vejle Kommune', ''),
('da', 'vocabulary', 'dime.kommune.vesthimmerland', 'default', 'Vesthimmerland', ''),
('da', 'vocabulary', 'dime.kommune.vesthimmerland', 'official', 'Vesthimmerlands Kommune', ''),
('da', 'vocabulary', 'dime.kommune.viborg', 'default', 'Viborg', ''),
('da', 'vocabulary', 'dime.kommune.viborg', 'official', 'Viborg Kommune', ''),
('da', 'vocabulary', 'dime.kommune.vordingborg', 'default', 'Vordingborg', ''),
('da', 'vocabulary', 'dime.kommune.vordingborg', 'official', 'Vordingborg Kommune', ''),
('da', 'vocabulary', 'dime.material.aluminium', 'default', 'Aluminium', ''),
('da', 'vocabulary', 'dime.material.copper', 'default', 'Kobber', ''),
('da', 'vocabulary', 'dime.material.copperalloy', 'default', 'Kobberlegering', ''),
('da', 'vocabulary', 'dime.material.gold', 'default', 'Guld', ''),
('da', 'vocabulary', 'dime.material.iron', 'default', 'Jern', ''),
('da', 'vocabulary', 'dime.material.lead', 'default', 'Bly', ''),
('da', 'vocabulary', 'dime.material.othermetal', 'default', 'Andet Metal', ''),
('da', 'vocabulary', 'dime.material.silver', 'default', 'Sølv', ''),
('da', 'vocabulary', 'dime.material.tin', 'default', 'Tin', ''),
('da', 'vocabulary', 'dime.period.absolutism', 'default', 'Enevælde', 'Absolutism'),
('da', 'vocabulary', 'dime.period.bronze', 'default', 'Bronzealder', 'Bronze Age'),
('da', 'vocabulary', 'dime.period.bronze.1', 'default', 'Bronzealder Per. 1', 'Bronze Age Period 1'),
('da', 'vocabulary', 'dime.period.bronze.2', 'default', 'Bronzealder Per. 2', 'Bronze Age Period 2'),
('da', 'vocabulary', 'dime.period.bronze.3', 'default', 'Bronzealder Per 3', 'Bronze Age Period 3'),
('da', 'vocabulary', 'dime.period.bronze.4', 'default', 'Bronzealder Per. 4', 'Bronze Age Period 4'),
('da', 'vocabulary', 'dime.period.bronze.5', 'default', 'Bronzealder Per. 5', 'Bronze Age Period 5'),
('da', 'vocabulary', 'dime.period.bronze.6', 'default', 'Bronzealder Per. 6', 'Bronze Age Period 6'),
('da', 'vocabulary', 'dime.period.bronze.early', 'default', 'Ældre Bronzealder', 'Early Bronze Age'),
('da', 'vocabulary', 'dime.period.bronze.late', 'default', 'Yngre Bronzealder', 'Late Bronze Age'),
('da', 'vocabulary', 'dime.period.historic', 'default', 'Historisk tid', 'Historic Age'),
('da', 'vocabulary', 'dime.period.industrial', 'default', 'Industritid', 'Industrial Age'),
('da', 'vocabulary', 'dime.period.interwar', 'default', 'Mellemskrigstiden', 'Interwar Years'),
('da', 'vocabulary', 'dime.period.iron', 'default', 'Jernalder', 'Iron Age'),
('da', 'vocabulary', 'dime.period.iron.early', 'default', 'Ældre Jernalder', 'Early Iron Age'),
('da', 'vocabulary', 'dime.period.iron.germainic', 'default', 'Germansk Jernalder', 'Germanic Iron Age'),
('da', 'vocabulary', 'dime.period.iron.germainic.early', 'default', 'Ældre Germansk Jernalder', 'Early Germanic Iron Age'),
('da', 'vocabulary', 'dime.period.iron.germainic.late', 'default', 'Yngre Germansk Jernalder', 'Late Germanic Iron Age'),
('da', 'vocabulary', 'dime.period.iron.late', 'default', 'Yngre Jernalder', 'Late Iron Age'),
('da', 'vocabulary', 'dime.period.iron.preroman', 'default', 'Førromersk Jernalder', 'Pre-Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.preroman.early', 'default', 'Ældre Førromersk Jernalder', 'Early Pre-Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.preroman.late', 'default', 'Yngre Førromersk Jernalder', 'Late Pre-Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.preroman.middle', 'default', 'Melllemste Førromersk Jernalder', 'Middle Pre-Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.roman', 'default', 'Romersk Jernalder', 'Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.roman.early', 'default', 'Ældre Romersk Jernalder', 'Early Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.roman.early.b1', 'default', 'Ældre Romersk Jernalder B1', 'Early Roman Iron Age B1'),
('da', 'vocabulary', 'dime.period.iron.roman.early.b2', 'default', 'Ældre Romersk Jernalder B2', 'Early Roman Iron Age B2'),
('da', 'vocabulary', 'dime.period.iron.roman.late', 'default', 'Yngre Romersk Jernalder', 'Late Roman Iron Age'),
('da', 'vocabulary', 'dime.period.iron.roman.late.c1', 'default', 'Yngre Romersk Jernalder C1', 'Late Roman Iron Age C1'),
('da', 'vocabulary', 'dime.period.iron.roman.late.c2', 'default', 'Yngre Romersk Jernalder C2', 'Late Roman Iron Age C2'),
('da', 'vocabulary', 'dime.period.iron.roman.late.c3', 'default', 'Yngre Romersk Jernalder C3', 'Late Roman Iron Age C3'),
('da', 'vocabulary', 'dime.period.medieval', 'default', 'Middelalder', 'Medieval'),
('da', 'vocabulary', 'dime.period.medieval.early', 'default', 'Tidlig Middelalder', 'Early Medieval'),
('da', 'vocabulary', 'dime.period.medieval.high', 'default', 'Højmiddelalder', 'High Medieval'),
('da', 'vocabulary', 'dime.period.medieval.late', 'default', 'Senmiddelalder', 'Late Medieval'),
('da', 'vocabulary', 'dime.period.mesolithic', 'default', 'Mesolitikum', 'Mesolithic'),
('da', 'vocabulary', 'dime.period.modern', 'default', 'Nyere tid', 'Modern Age'),
('da', 'vocabulary', 'dime.period.neolithic', 'default', 'Neolitikum', 'Neolithic'),
('da', 'vocabulary', 'dime.period.palaeolithic', 'default', 'Pælæolitikum', 'Palaeolithic'),
('da', 'vocabulary', 'dime.period.reformation', 'default', 'Efterreformatorisk tid', 'Reformation'),
('da', 'vocabulary', 'dime.period.stone', 'default', 'Stenalder', 'Stone Age'),
('da', 'vocabulary', 'dime.period.undated', 'default', 'Udateret', 'Undated'),
('da', 'vocabulary', 'dime.period.viking', 'default', 'Vikingetid', 'Viking Age'),
('da', 'vocabulary', 'dime.period.viking.early', 'default', 'Ældre Vikingetid', 'Early Viking Age'),
('da', 'vocabulary', 'dime.period.viking.late', 'default', 'Yngre Vikingetid', 'Late Viking Age'),
('da', 'vocabulary', 'dime.period.viking.medieval', 'default', 'Vikingetid / Tidlig Middelalder', 'Viking / Early Medieval '),
('da', 'vocabulary', 'dime.period.welfare', 'default', 'Velfærdssamfundet', 'Welfare Age'),
('da', 'vocabulary', 'dime.period.ww1', 'default', '1. Verdenskrig', 'First World War'),
('da', 'vocabulary', 'dime.period.ww2', 'default', '2. Verdenskrig', 'Second World War'),
('da', 'vocabulary', 'dime.region.hovedstaden', 'default', 'Hovedstaden', ''),
('da', 'vocabulary', 'dime.region.hovedstaden', 'official', 'Region Hovedstaden', ''),
('da', 'vocabulary', 'dime.region.midtjylland', 'default', 'Midtjylland', ''),
('da', 'vocabulary', 'dime.region.midtjylland', 'official', 'Region Midtjylland', ''),
('da', 'vocabulary', 'dime.region.nordjylland', 'default', 'Nordjylland', ''),
('da', 'vocabulary', 'dime.region.nordjylland', 'official', 'Region Nordjylland', ''),
('da', 'vocabulary', 'dime.region.sjaelland', 'default', 'Sjælland', ''),
('da', 'vocabulary', 'dime.region.sjaelland', 'official', 'Region Sjælland', ''),
('da', 'vocabulary', 'dime.region.syddanmark', 'default', 'Syddanmark', ''),
('da', 'vocabulary', 'dime.region.syddanmark', 'official', 'Region Syddanmark', ''),
('da', 'vocabulary', 'dime.treasure.assesing', 'default', 'Vurdere', ''),
('da', 'vocabulary', 'dime.treasure.not', 'default', 'Ikke Danefæ', ''),
('da', 'vocabulary', 'dime.treasure.pending', 'default', 'Verserende', ''),
('da', 'vocabulary', 'dime.treasure.treasure', 'default', 'Danefæ', ''),
('da', 'vocabulary', 'length.kilometre', 'default', 'kilometer', ''),
('da', 'vocabulary', 'length.metre', 'default', 'meter', ''),
('da', 'vocabulary', 'length.micrometre', 'default', 'mikrometer', ''),
('da', 'vocabulary', 'length.millimetre', 'default', 'millimeter', ''),
('da', 'vocabulary', 'length.nanometre', 'default', 'nanometer', ''),
('da', 'vocabulary', 'mass.gram', 'default', 'gram', ''),
('da', 'vocabulary', 'mass.kilogram', 'default', 'kilogram', ''),
('da', 'vocabulary', 'mass.microgram', 'default', 'mikrogram', ''),
('da', 'vocabulary', 'mass.milligram', 'default', 'milligram', ''),
('da', 'vocabulary', 'mass.tonne', 'default', 'ton', ''),
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
('en', 'vocabulary', 'dime.actor.type.institution', 'default', 'dime.actor.type.institution', ''),
('en', 'vocabulary', 'dime.actor.type.museum', 'default', 'Museum', ''),
('en', 'vocabulary', 'dime.actor.type.person', 'default', 'dime.actor.type.person', ''),
('en', 'vocabulary', 'dime.dime.secondary.other', 'default', 'Other', ''),
('en', 'vocabulary', 'dime.dime.secondary.tinned', 'default', 'Tinned', ''),
('en', 'vocabulary', 'dime.find.condition.fragmented', 'default', 'Fragmented', ''),
('en', 'vocabulary', 'dime.find.condition.whole', 'default', 'Whole', ''),
('en', 'vocabulary', 'dime.find.secondary.enamel', 'default', 'Enamel', ''),
('en', 'vocabulary', 'dime.find.secondary.gilded', 'default', 'Gilded', ''),
('en', 'vocabulary', 'dime.find.secondary.glass', 'default', 'Glass', ''),
('en', 'vocabulary', 'dime.find.secondary.iron', 'default', 'Iron', ''),
('en', 'vocabulary', 'dime.find.secondary.niello', 'default', 'Niello', ''),
('en', 'vocabulary', 'dime.find.secondary.organic', 'default', 'Organic', ''),
('en', 'vocabulary', 'dime.find.secondary.stone', 'default', 'Stone', ''),
('en', 'vocabulary', 'dime.find.type.accessory', 'default', 'Jewelery / Costume Accessories', ''),
('en', 'vocabulary', 'dime.find.type.coin', 'default', 'Coin', ''),
('en', 'vocabulary', 'dime.find.type.fibula', 'default', 'Fibula / Suit Buckle', ''),
('en', 'vocabulary', 'dime.find.type.military', 'default', 'Weapons / Militaria', ''),
('en', 'vocabulary', 'dime.find.type.tool', 'default', 'Equipment / Tools', ''),
('en', 'vocabulary', 'dime.find.type.waste', 'default', 'Production Waste / Scrap Metal', ''),
('en', 'vocabulary', 'dime.kommune.aabenraa', 'default', 'Aabenraa', ''),
('en', 'vocabulary', 'dime.kommune.aabenraa', 'official', 'Aabenraa Municipality', ''),
('en', 'vocabulary', 'dime.kommune.aalborg', 'default', 'Aalborg', ''),
('en', 'vocabulary', 'dime.kommune.aalborg', 'official', 'Aalborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.aero', 'default', 'Ærø', ''),
('en', 'vocabulary', 'dime.kommune.aero', 'official', 'Ærø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.albertslund', 'default', 'Albertslund', ''),
('en', 'vocabulary', 'dime.kommune.albertslund', 'official', 'Albertslund Municipality', ''),
('en', 'vocabulary', 'dime.kommune.allerod', 'default', 'Allerød', ''),
('en', 'vocabulary', 'dime.kommune.allerod', 'official', 'Allerød Municipality', ''),
('en', 'vocabulary', 'dime.kommune.arhus', 'default', 'Århus', ''),
('en', 'vocabulary', 'dime.kommune.arhus', 'official', 'Århus Municipality', ''),
('en', 'vocabulary', 'dime.kommune.assens', 'default', 'Assens', ''),
('en', 'vocabulary', 'dime.kommune.assens', 'official', 'Assens Municipality', ''),
('en', 'vocabulary', 'dime.kommune.ballerup', 'default', 'Ballerup', ''),
('en', 'vocabulary', 'dime.kommune.ballerup', 'official', 'Ballerup Municipality', ''),
('en', 'vocabulary', 'dime.kommune.billund', 'default', 'Billund', ''),
('en', 'vocabulary', 'dime.kommune.billund', 'official', 'Billund Municipality', ''),
('en', 'vocabulary', 'dime.kommune.bornholm', 'default', 'Bornholm', ''),
('en', 'vocabulary', 'dime.kommune.bornholm', 'official', 'Bornholms Municipality', ''),
('en', 'vocabulary', 'dime.kommune.brondby', 'default', 'Brøndby', ''),
('en', 'vocabulary', 'dime.kommune.brondby', 'official', 'Brøndby Municipality', ''),
('en', 'vocabulary', 'dime.kommune.bronderslev', 'default', 'Brønderslev', ''),
('en', 'vocabulary', 'dime.kommune.bronderslev', 'official', 'Brønderslev Municipality', ''),
('en', 'vocabulary', 'dime.kommune.dragor', 'default', 'Dragør', ''),
('en', 'vocabulary', 'dime.kommune.dragor', 'official', 'Dragør Municipality', ''),
('en', 'vocabulary', 'dime.kommune.egedal', 'default', 'Egedal', ''),
('en', 'vocabulary', 'dime.kommune.egedal', 'official', 'Egedal Municipality', ''),
('en', 'vocabulary', 'dime.kommune.esbjerg', 'default', 'Esbjerg', ''),
('en', 'vocabulary', 'dime.kommune.esbjerg', 'official', 'Esbjerg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.faaborgmidtfyn', 'default', 'Faaborg-Midtfyn', ''),
('en', 'vocabulary', 'dime.kommune.faaborgmidtfyn', 'official', 'Faaborg-Midtfyn Municipality', ''),
('en', 'vocabulary', 'dime.kommune.fano', 'default', 'Fanø', ''),
('en', 'vocabulary', 'dime.kommune.fano', 'official', 'Fanø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.favrskov', 'default', 'Favrskov', ''),
('en', 'vocabulary', 'dime.kommune.favrskov', 'official', 'Favrskov Municipality', ''),
('en', 'vocabulary', 'dime.kommune.faxe', 'default', 'Faxe', ''),
('en', 'vocabulary', 'dime.kommune.faxe', 'official', 'Faxe Municipality', ''),
('en', 'vocabulary', 'dime.kommune.fredensborg', 'default', 'Fredensborg', ''),
('en', 'vocabulary', 'dime.kommune.fredensborg', 'official', 'Fredensborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.fredericia', 'default', 'Fredericia', ''),
('en', 'vocabulary', 'dime.kommune.fredericia', 'official', 'Fredericia Municipality', ''),
('en', 'vocabulary', 'dime.kommune.frederiksbeg', 'default', 'Frederiksbeg', ''),
('en', 'vocabulary', 'dime.kommune.frederiksbeg', 'official', 'Frederiksberg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.frederikshavn', 'default', 'Frederikshavn', ''),
('en', 'vocabulary', 'dime.kommune.frederikshavn', 'official', 'Frederikshavn Municipality', ''),
('en', 'vocabulary', 'dime.kommune.frederikssund', 'default', 'Frederikssund', ''),
('en', 'vocabulary', 'dime.kommune.frederikssund', 'official', 'Frederikssund Municipality', ''),
('en', 'vocabulary', 'dime.kommune.fureso', 'default', 'Furesø', ''),
('en', 'vocabulary', 'dime.kommune.fureso', 'official', 'Furesø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.gentofte', 'default', 'Gentofte', ''),
('en', 'vocabulary', 'dime.kommune.gentofte', 'official', 'Gentofte Municipality', ''),
('en', 'vocabulary', 'dime.kommune.gladsaxe', 'default', 'Gladsaxe', ''),
('en', 'vocabulary', 'dime.kommune.gladsaxe', 'official', 'Gladsaxe Municipality', ''),
('en', 'vocabulary', 'dime.kommune.glostrup', 'default', 'Glostrup', ''),
('en', 'vocabulary', 'dime.kommune.glostrup', 'official', 'Glostrup Municipality', ''),
('en', 'vocabulary', 'dime.kommune.greve', 'default', 'Greve', ''),
('en', 'vocabulary', 'dime.kommune.greve', 'official', 'Greve Municipality', ''),
('en', 'vocabulary', 'dime.kommune.gribskov', 'default', 'Gribskov', ''),
('en', 'vocabulary', 'dime.kommune.gribskov', 'official', 'Gribskov Municipality', ''),
('en', 'vocabulary', 'dime.kommune.guldborgsund', 'default', 'Guldborgsund', ''),
('en', 'vocabulary', 'dime.kommune.guldborgsund', 'official', 'Guldborgsund Municipality', ''),
('en', 'vocabulary', 'dime.kommune.haderslev', 'default', 'Haderslev', ''),
('en', 'vocabulary', 'dime.kommune.haderslev', 'official', 'Haderslev Municipality', ''),
('en', 'vocabulary', 'dime.kommune.halsnaes', 'default', 'Halsnæs', ''),
('en', 'vocabulary', 'dime.kommune.halsnaes', 'official', 'Halsnæs Municipality', ''),
('en', 'vocabulary', 'dime.kommune.hedensted', 'default', 'Hedensted', '');
INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'vocabulary', 'dime.kommune.hedensted', 'official', 'Hedensted Municipality', ''),
('en', 'vocabulary', 'dime.kommune.helsingor', 'default', 'Helsingør', ''),
('en', 'vocabulary', 'dime.kommune.helsingor', 'official', 'Helsingør Municipality', ''),
('en', 'vocabulary', 'dime.kommune.herlev', 'default', 'Herlev', ''),
('en', 'vocabulary', 'dime.kommune.herlev', 'official', 'Herlev Municipality', ''),
('en', 'vocabulary', 'dime.kommune.herning', 'default', 'Herning', ''),
('en', 'vocabulary', 'dime.kommune.herning', 'official', 'Herning Municipality', ''),
('en', 'vocabulary', 'dime.kommune.hillerod', 'default', 'Hillerød', ''),
('en', 'vocabulary', 'dime.kommune.hillerod', 'official', 'Hillerød Municipality', ''),
('en', 'vocabulary', 'dime.kommune.hjorring', 'default', 'Hjørring', ''),
('en', 'vocabulary', 'dime.kommune.hjorring', 'official', 'Hjørring Municipality', ''),
('en', 'vocabulary', 'dime.kommune.hojetaastrup', 'default', 'Høje-Taastrup', ''),
('en', 'vocabulary', 'dime.kommune.hojetaastrup', 'official', 'Høje-Taastrup Municipality', ''),
('en', 'vocabulary', 'dime.kommune.holbaek', 'default', 'Holbæk', ''),
('en', 'vocabulary', 'dime.kommune.holbaek', 'official', 'Holbæk Municipality', ''),
('en', 'vocabulary', 'dime.kommune.holstebro', 'default', 'Holstebro', ''),
('en', 'vocabulary', 'dime.kommune.holstebro', 'official', 'Holstebro Municipality', ''),
('en', 'vocabulary', 'dime.kommune.horsens', 'default', 'Horsens', ''),
('en', 'vocabulary', 'dime.kommune.horsens', 'official', 'Horsens Municipality', ''),
('en', 'vocabulary', 'dime.kommune.horsholm', 'default', 'Hørsholm', ''),
('en', 'vocabulary', 'dime.kommune.horsholm', 'official', 'Hørsholm Municipality', ''),
('en', 'vocabulary', 'dime.kommune.hvidovre', 'default', 'Hvidovre', ''),
('en', 'vocabulary', 'dime.kommune.hvidovre', 'official', 'Hvidovre Municipality', ''),
('en', 'vocabulary', 'dime.kommune.ikastbrande', 'default', 'Ikast-Brande', ''),
('en', 'vocabulary', 'dime.kommune.ikastbrande', 'official', 'Ikast-Brande Municipality', ''),
('en', 'vocabulary', 'dime.kommune.ishoj', 'default', 'Ishøj', ''),
('en', 'vocabulary', 'dime.kommune.ishoj', 'official', 'Ishøj Municipality', ''),
('en', 'vocabulary', 'dime.kommune.jammerbugt', 'default', 'Jammerbugt', ''),
('en', 'vocabulary', 'dime.kommune.jammerbugt', 'official', 'Jammerbugt Municipality', ''),
('en', 'vocabulary', 'dime.kommune.kalundborg', 'default', 'Kalundborg', ''),
('en', 'vocabulary', 'dime.kommune.kalundborg', 'official', 'Kalundborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.kerteminde', 'default', 'Kerteminde', ''),
('en', 'vocabulary', 'dime.kommune.kerteminde', 'official', 'Kerteminde Municipality', ''),
('en', 'vocabulary', 'dime.kommune.kobenhavn', 'default', 'Copenhagen', ''),
('en', 'vocabulary', 'dime.kommune.kobenhavn', 'official', 'Copenhagen Municipality', ''),
('en', 'vocabulary', 'dime.kommune.koge', 'default', 'Køge', ''),
('en', 'vocabulary', 'dime.kommune.koge', 'official', 'Køge Municipality', ''),
('en', 'vocabulary', 'dime.kommune.kolding', 'default', 'Kolding', ''),
('en', 'vocabulary', 'dime.kommune.kolding', 'official', 'Kolding Municipality', ''),
('en', 'vocabulary', 'dime.kommune.laeso', 'default', 'Læsø', ''),
('en', 'vocabulary', 'dime.kommune.laeso', 'official', 'Læsø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.langeland', 'default', 'Langeland', ''),
('en', 'vocabulary', 'dime.kommune.langeland', 'official', 'Langeland Municipality', ''),
('en', 'vocabulary', 'dime.kommune.lejre', 'default', 'Lejre', ''),
('en', 'vocabulary', 'dime.kommune.lejre', 'official', 'Lejre Municipality', ''),
('en', 'vocabulary', 'dime.kommune.lemvig', 'default', 'Lemvig', ''),
('en', 'vocabulary', 'dime.kommune.lemvig', 'official', 'Lemvig Municipality', ''),
('en', 'vocabulary', 'dime.kommune.lolland', 'default', 'Lolland', ''),
('en', 'vocabulary', 'dime.kommune.lolland', 'official', 'Lolland Municipality', ''),
('en', 'vocabulary', 'dime.kommune.lyngbytaarbaek', 'default', 'Lyngby-Taarbæk', ''),
('en', 'vocabulary', 'dime.kommune.lyngbytaarbaek', 'official', 'Lyngby-Taarbæk Municipality', ''),
('en', 'vocabulary', 'dime.kommune.mariagerfjord', 'default', 'Mariagerfjord', ''),
('en', 'vocabulary', 'dime.kommune.mariagerfjord', 'official', 'Mariagerfjord Municipality', ''),
('en', 'vocabulary', 'dime.kommune.middelfart', 'default', 'Middelfart', ''),
('en', 'vocabulary', 'dime.kommune.middelfart', 'official', 'Middelfart Municipality', ''),
('en', 'vocabulary', 'dime.kommune.morso', 'default', 'Morsø', ''),
('en', 'vocabulary', 'dime.kommune.morso', 'official', 'Morsø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.naestved', 'default', 'Næstved', ''),
('en', 'vocabulary', 'dime.kommune.naestved', 'official', 'Næstved Municipality', ''),
('en', 'vocabulary', 'dime.kommune.norddjurs', 'default', 'Norddjurs', ''),
('en', 'vocabulary', 'dime.kommune.norddjurs', 'official', 'Norddjurs Municipality', ''),
('en', 'vocabulary', 'dime.kommune.nordfyns', 'default', 'Nordfyns', ''),
('en', 'vocabulary', 'dime.kommune.nordfyns', 'official', 'Nordfyns Municipality', ''),
('en', 'vocabulary', 'dime.kommune.nyborg', 'default', 'Nyborg', ''),
('en', 'vocabulary', 'dime.kommune.nyborg', 'official', 'Nyborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.odder', 'default', 'Odder', ''),
('en', 'vocabulary', 'dime.kommune.odder', 'official', 'Odder Municipality', ''),
('en', 'vocabulary', 'dime.kommune.odense', 'default', 'Odense', ''),
('en', 'vocabulary', 'dime.kommune.odense', 'official', 'Odense Municipality', ''),
('en', 'vocabulary', 'dime.kommune.odsherred', 'default', 'Odsherred', ''),
('en', 'vocabulary', 'dime.kommune.odsherred', 'official', 'Odsherred Municipality', ''),
('en', 'vocabulary', 'dime.kommune.randers', 'default', 'Randers', ''),
('en', 'vocabulary', 'dime.kommune.randers', 'official', 'Randers Municipality', ''),
('en', 'vocabulary', 'dime.kommune.rebild', 'default', 'Rebild', ''),
('en', 'vocabulary', 'dime.kommune.rebild', 'official', 'Rebild Municipality', ''),
('en', 'vocabulary', 'dime.kommune.ringkobingskjern', 'default', 'Ringkøbing-Skjern', ''),
('en', 'vocabulary', 'dime.kommune.ringkobingskjern', 'official', 'Ringkøbing-Skjern Municipality', ''),
('en', 'vocabulary', 'dime.kommune.ringsted', 'default', 'Ringsted', ''),
('en', 'vocabulary', 'dime.kommune.ringsted', 'official', 'Ringsted Municipality', ''),
('en', 'vocabulary', 'dime.kommune.rodovre', 'default', 'Rødovre', ''),
('en', 'vocabulary', 'dime.kommune.rodovre', 'official', 'Rødovre Municipality', ''),
('en', 'vocabulary', 'dime.kommune.roskilde', 'default', 'Roskilde', ''),
('en', 'vocabulary', 'dime.kommune.roskilde', 'official', 'Roskilde Municipality', ''),
('en', 'vocabulary', 'dime.kommune.rudersdal', 'default', 'Rudersdal', ''),
('en', 'vocabulary', 'dime.kommune.rudersdal', 'official', 'Rudersdal Municipality', ''),
('en', 'vocabulary', 'dime.kommune.samso', 'default', 'Samsø', ''),
('en', 'vocabulary', 'dime.kommune.samso', 'official', 'Samsø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.silkeborg', 'default', 'Silkeborg', ''),
('en', 'vocabulary', 'dime.kommune.silkeborg', 'official', 'Silkeborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.skanderborg', 'default', 'Skanderborg', ''),
('en', 'vocabulary', 'dime.kommune.skanderborg', 'official', 'Skanderborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.skive', 'default', 'Skive', ''),
('en', 'vocabulary', 'dime.kommune.skive', 'official', 'Skive Municipality', ''),
('en', 'vocabulary', 'dime.kommune.slagelse', 'default', 'Slagelse', ''),
('en', 'vocabulary', 'dime.kommune.slagelse', 'official', 'Slagelse Municipality', ''),
('en', 'vocabulary', 'dime.kommune.solrod', 'default', 'Solrød', ''),
('en', 'vocabulary', 'dime.kommune.solrod', 'official', 'Solrød Municipality', ''),
('en', 'vocabulary', 'dime.kommune.sonderborg', 'default', 'Sønderborg', ''),
('en', 'vocabulary', 'dime.kommune.sonderborg', 'official', 'Sønderborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.soro', 'default', 'Sorø', ''),
('en', 'vocabulary', 'dime.kommune.soro', 'official', 'Sorø Municipality', ''),
('en', 'vocabulary', 'dime.kommune.stevns', 'default', 'Stevns', ''),
('en', 'vocabulary', 'dime.kommune.stevns', 'official', 'Stevns Municipality', ''),
('en', 'vocabulary', 'dime.kommune.struer', 'default', 'Struer', ''),
('en', 'vocabulary', 'dime.kommune.struer', 'official', 'Struer Municipality', ''),
('en', 'vocabulary', 'dime.kommune.svendborg', 'default', 'Svendborg', ''),
('en', 'vocabulary', 'dime.kommune.svendborg', 'official', 'Svendborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.syddjurs', 'default', 'Syddjurs', ''),
('en', 'vocabulary', 'dime.kommune.syddjurs', 'official', 'Syddjurs Municipality', ''),
('en', 'vocabulary', 'dime.kommune.tarnby', 'default', 'Tårnby', ''),
('en', 'vocabulary', 'dime.kommune.tarnby', 'official', 'Tårnby Municipality', ''),
('en', 'vocabulary', 'dime.kommune.thisted', 'default', 'Thisted', ''),
('en', 'vocabulary', 'dime.kommune.thisted', 'official', 'Thisted Municipality', ''),
('en', 'vocabulary', 'dime.kommune.tonder', 'default', 'Tønder', ''),
('en', 'vocabulary', 'dime.kommune.tonder', 'official', 'Tønder Municipality', ''),
('en', 'vocabulary', 'dime.kommune.vallensbaek', 'default', 'Vallensbæk', ''),
('en', 'vocabulary', 'dime.kommune.vallensbaek', 'official', 'Vallensbæk Municipality', ''),
('en', 'vocabulary', 'dime.kommune.varde', 'default', 'Varde', ''),
('en', 'vocabulary', 'dime.kommune.varde', 'official', 'Varde Municipality', ''),
('en', 'vocabulary', 'dime.kommune.vejen', 'default', 'Vejen', ''),
('en', 'vocabulary', 'dime.kommune.vejen', 'official', 'Vejen Municipality', ''),
('en', 'vocabulary', 'dime.kommune.vejle', 'default', 'Vejle', ''),
('en', 'vocabulary', 'dime.kommune.vejle', 'official', 'Vejle Municipality', ''),
('en', 'vocabulary', 'dime.kommune.vesthimmerland', 'default', 'Vesthimmerland', ''),
('en', 'vocabulary', 'dime.kommune.vesthimmerland', 'official', 'Vesthimmerlands Municipality', ''),
('en', 'vocabulary', 'dime.kommune.viborg', 'default', 'Viborg', ''),
('en', 'vocabulary', 'dime.kommune.viborg', 'official', 'Viborg Municipality', ''),
('en', 'vocabulary', 'dime.kommune.vordingborg', 'default', 'Vordingborg', ''),
('en', 'vocabulary', 'dime.kommune.vordingborg', 'official', 'Vordingborg Municipality', ''),
('en', 'vocabulary', 'dime.material.aluminium', 'default', 'Aluminium', ''),
('en', 'vocabulary', 'dime.material.copper', 'default', 'Copper', ''),
('en', 'vocabulary', 'dime.material.copperalloy', 'default', 'Copper Alloy', ''),
('en', 'vocabulary', 'dime.material.gold', 'default', 'Gold', ''),
('en', 'vocabulary', 'dime.material.iron', 'default', 'Iron', ''),
('en', 'vocabulary', 'dime.material.lead', 'default', 'Lead', ''),
('en', 'vocabulary', 'dime.material.othermetal', 'default', 'Other Metal', ''),
('en', 'vocabulary', 'dime.material.silver', 'default', 'Silver', ''),
('en', 'vocabulary', 'dime.material.tin', 'default', 'Tin', ''),
('en', 'vocabulary', 'dime.period.absolutism', 'default', 'Absolutism', ''),
('en', 'vocabulary', 'dime.period.bronze', 'default', 'Bronze Age', ''),
('en', 'vocabulary', 'dime.period.bronze.1', 'default', 'Bronze Age Period 1', ''),
('en', 'vocabulary', 'dime.period.bronze.2', 'default', 'Bronze Age Period 2', ''),
('en', 'vocabulary', 'dime.period.bronze.3', 'default', 'Bronze Age Period 3', ''),
('en', 'vocabulary', 'dime.period.bronze.4', 'default', 'Bronze Age Period 4', ''),
('en', 'vocabulary', 'dime.period.bronze.5', 'default', 'Bronze Age Period 5', ''),
('en', 'vocabulary', 'dime.period.bronze.6', 'default', 'Bronze Age Period 6', ''),
('en', 'vocabulary', 'dime.period.bronze.early', 'default', 'Early Bronze Age', ''),
('en', 'vocabulary', 'dime.period.bronze.late', 'default', 'Late Bronze Age', ''),
('en', 'vocabulary', 'dime.period.historic', 'default', 'Historic Age', ''),
('en', 'vocabulary', 'dime.period.industrial', 'default', 'Industrial Age', ''),
('en', 'vocabulary', 'dime.period.interwar', 'default', 'Interwar Years', ''),
('en', 'vocabulary', 'dime.period.iron', 'default', 'Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.early', 'default', 'Early Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.germainic', 'default', 'Germanic Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.germainic.early', 'default', 'Early Germanic Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.germainic.late', 'default', 'Late Germanic Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.late', 'default', 'Late Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.preroman', 'default', 'Pre-Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.preroman.early', 'default', 'Early Pre-Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.preroman.late', 'default', 'Late Pre-Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.preroman.middle', 'default', 'Middle Pre-Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.roman', 'default', 'Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.roman.early', 'default', 'Early Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.roman.early.b1', 'default', 'Early Roman Iron Age B1', ''),
('en', 'vocabulary', 'dime.period.iron.roman.early.b2', 'default', 'Early Roman Iron Age B2', ''),
('en', 'vocabulary', 'dime.period.iron.roman.late', 'default', 'Late Roman Iron Age', ''),
('en', 'vocabulary', 'dime.period.iron.roman.late.c1', 'default', 'Late Roman Iron Age C1', ''),
('en', 'vocabulary', 'dime.period.iron.roman.late.c2', 'default', 'Late Roman Iron Age C2', ''),
('en', 'vocabulary', 'dime.period.iron.roman.late.c3', 'default', 'Late Roman Iron Age C3', ''),
('en', 'vocabulary', 'dime.period.medieval', 'default', 'Medieval', ''),
('en', 'vocabulary', 'dime.period.medieval.early', 'default', 'Early Medieval', ''),
('en', 'vocabulary', 'dime.period.medieval.high', 'default', 'High Medieval', ''),
('en', 'vocabulary', 'dime.period.medieval.late', 'default', 'Late Medieval', ''),
('en', 'vocabulary', 'dime.period.mesolithic', 'default', 'Mesolithic', ''),
('en', 'vocabulary', 'dime.period.modern', 'default', 'Modern Age', ''),
('en', 'vocabulary', 'dime.period.neolithic', 'default', 'Neolithic', ''),
('en', 'vocabulary', 'dime.period.palaeolithic', 'default', 'Palaeolithic', ''),
('en', 'vocabulary', 'dime.period.reformation', 'default', 'Reformation', ''),
('en', 'vocabulary', 'dime.period.stone', 'default', 'Stone Age', ''),
('en', 'vocabulary', 'dime.period.undated', 'default', 'Undated', ''),
('en', 'vocabulary', 'dime.period.viking', 'default', 'Viking Age', ''),
('en', 'vocabulary', 'dime.period.viking.early', 'default', 'Early Viking Age', ''),
('en', 'vocabulary', 'dime.period.viking.late', 'default', 'Late Viking Age', ''),
('en', 'vocabulary', 'dime.period.viking.medieval', 'default', 'Viking / Early Medieval ', ''),
('en', 'vocabulary', 'dime.period.welfare', 'default', 'Welfare Age', ''),
('en', 'vocabulary', 'dime.period.ww1', 'default', 'First World War', ''),
('en', 'vocabulary', 'dime.period.ww2', 'default', 'Second World War', ''),
('en', 'vocabulary', 'dime.region.hovedstaden', 'default', 'Capital', ''),
('en', 'vocabulary', 'dime.region.hovedstaden', 'official', 'Capital Region', ''),
('en', 'vocabulary', 'dime.region.midtjylland', 'default', 'Central', ''),
('en', 'vocabulary', 'dime.region.midtjylland', 'official', 'Central Region', ''),
('en', 'vocabulary', 'dime.region.nordjylland', 'default', 'North', ''),
('en', 'vocabulary', 'dime.region.nordjylland', 'official', 'North Region', ''),
('en', 'vocabulary', 'dime.region.sjaelland', 'default', 'Zealand', ''),
('en', 'vocabulary', 'dime.region.sjaelland', 'official', 'Zealand Region', ''),
('en', 'vocabulary', 'dime.region.syddanmark', 'default', 'South', ''),
('en', 'vocabulary', 'dime.region.syddanmark', 'official', 'South Region', ''),
('en', 'vocabulary', 'dime.treasure.assesing', 'default', 'Assesing', ''),
('en', 'vocabulary', 'dime.treasure.not', 'default', 'Not Treasure Trove', ''),
('en', 'vocabulary', 'dime.treasure.pending', 'default', 'Pending', ''),
('en', 'vocabulary', 'dime.treasure.treasure', 'default', 'Treasure Trove', ''),
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
('en', 'vocabulary', 'language.sami.skolt', 'default', 'Skolt Sami', ''),
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
('en', 'vocabulary', 'language.slovak', 'default', 'Slovak', '');
INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
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
  `equivalence` tinyint(1) NOT NULL,
  `hierarchy` tinyint(1) NOT NULL,
  `association` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `deprecated` tinyint(1) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_layout_role`
--

CREATE TABLE `cor_conf_layout_role` (
  `layout_role` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page`
--

CREATE TABLE `cor_conf_page` (
  `page` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `sgrp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_dir` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nav_seq` int(11) NOT NULL,
  `navname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nav_link_vars` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page_layout`
--

CREATE TABLE `cor_conf_page_layout` (
  `page` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dime_period`
--

CREATE TABLE `dime_period` (
  `concept` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL,
  `from_year` int(11) NOT NULL,
  `to_year` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dime_period`
--

INSERT INTO `dime_period` (`concept`, `term`, `parent`, `depth`, `from_year`, `to_year`, `description`, `alias`, `keyword`) VALUES
('dime.period', 'AÆAX', 'AÆPY', 5, -10500, -9000, 'Ahrensburgkultur', 'ahrensburg', 'dime.period.ahrensburg'),
('dime.period', 'AÆBX', 'AÆPY', 5, -11000, -10500, 'Brommekultur', 'bromme', 'dime.period.bromme'),
('dime.period', 'AÆEÆ', 'AÆEX', 6, -5400, -4800, 'Ældre Ertebøllekultur', 'ertebølle.early', 'dime.period.ertebølle.early'),
('dime.period', 'AÆEM', 'AÆEX', 6, -4800, -4300, 'Mell. Ertebøllekultur', 'ertebølle.middle', 'dime.period.ertebølle.middle'),
('dime.period', 'AÆEX', 'AMXX', 5, -5400, -3900, 'Ertebøllekultur', 'ertebølle', 'dime.period.ertebølle'),
('dime.period', 'AÆEY', 'AÆEX', 6, -4300, -3900, 'Yngre Ertebøllekultur', 'ertebølle.late', 'dime.period.ertebølle.late'),
('dime.period', 'AÆFX', 'AÆPY', 5, -12000, -11000, 'Federmesser', 'feder', 'dime.period.feder'),
('dime.period', 'AÆHX', 'AÆPY', 5, -12800, -12000, 'Hamburgkultur', 'hamburg', 'dime.period.hamburg'),
('dime.period', 'AÆKÆ', 'AÆKX', 6, -6400, -6000, 'Ældre Kongemosekultur', 'kongemose.early', 'dime.period.kongemose.early'),
('dime.period', 'AÆKM', 'AÆKX', 6, -6000, -5700, 'Mell. Kongemosekultur', 'kongemose.middle', 'dime.period.kongemose.middle'),
('dime.period', 'AÆKX', 'AMXX', 5, -6400, -5400, 'Kongemosekultur', 'kongemose', 'dime.period.kongemose'),
('dime.period', 'AÆKY', 'AÆKX', 6, -5700, -5400, 'Yngre Kongemosekultur', 'kongemose.late', 'dime.period.kongemose.late'),
('dime.period', 'AÆMÆ', 'AÆMX', 6, -9000, -7800, 'Ældre Maglemosekultur', 'maglemosian.early', 'dime.period.maglemosian.early'),
('dime.period', 'AÆMM', 'AÆMX', 6, -7800, -7000, 'Mell. Maglemosekultur', 'maglemosian.middle', 'dime.period.maglemosian.middle'),
('dime.period', 'AÆMX', 'AMXX', 5, -9000, -6400, 'Maglemosekultur', 'maglemosian', 'dime.period.maglemosian'),
('dime.period', 'AÆMY', 'AÆMX', 6, -7000, -6400, 'Yngre Maglemosekultur', 'maglemosian.late', 'dime.period.maglemosian.late'),
('dime.period', 'AÆPÆ', 'OXXX', 4, -250000, -150000, 'Ældre Palæolitikum', 'palaeolithic.early', 'dime.period.palaeolithic.early'),
('dime.period', 'AÆPM', 'OXXX', 4, -150000, -70000, 'Mellempalæolitikum', 'palaeolithic.middle', 'dime.period.palaeolithic.middle'),
('dime.period', 'AÆPY', 'OXXX', 4, -70000, -9000, 'Yngre-sen Palæolitikum', 'palaeolithic.late', 'dime.period.palaeolithic.late'),
('dime.period', 'AMXX', 'OXXX', 4, -9000, -3900, 'Mesolitikum', 'mesolithic', 'dime.period.mesolithic'),
('dime.period', 'ATM1', 'AYTM', 7, -3300, -3100, 'Mellemneolitisk Tragtbægerkultur I', 'funnelbeaker.middle.i', 'dime.period.funnelbeaker.middle.i'),
('dime.period', 'ATM2', 'AYTM', 7, -3100, -3000, 'Mellemneolitisk Tragtbægerkultur II', 'funnelbeaker.middle.ii', 'dime.period.funnelbeaker.middle.ii'),
('dime.period', 'ATM3', 'AYTM', 7, -3000, -2900, 'Mellemneolitisk Tragtbægerkultur III', 'funnelbeaker.middle.iii', 'dime.period.funnelbeaker.middle.iii'),
('dime.period', 'ATM4', 'AYTM', 7, -3000, -2900, 'Mellemneolitisk Tragtbægerkultur IV', 'funnelbeaker.middle.iv', 'dime.period.funnelbeaker.middle.iv'),
('dime.period', 'ATM5', 'AYTM', 7, -2900, -2800, 'Mellemneolitisk Tragtbægerkultur V', 'funnelbeaker.middle.v', 'dime.period.funnelbeaker.middle.v'),
('dime.period', 'ATNA', 'AYTÆ', 7, -3900, -3700, 'Tidligneolitisk Tragtbægerkultur A', 'funnelbeaker.early.a', 'dime.period.funnelbeaker.early.a'),
('dime.period', 'ATNB', 'AYTÆ', 7, -3700, -3500, 'Tidligneolitisk Tragtbægerkultur B', 'funnelbeaker.early.b', 'dime.period.funnelbeaker.early.b'),
('dime.period', 'ATNC', 'AYTÆ', 7, -3500, -3300, 'Tidligneolitisk Tragtbægerkultur C', 'funnelbeaker.early.c', 'dime.period.funnelbeaker.early.c'),
('dime.period', 'AXXX', 'OXXX', 3, -250000, -1700, 'Stenalder', 'stoneage', 'dime.period.stoneage'),
('dime.period', 'AYEÆ', 'AYEX', 6, -2800, -2600, 'Ældre Enkeltgravskultur', 'cordedware.early', 'dime.period.cordedware.early'),
('dime.period', 'AYEM', 'AYEX', 6, -2600, -2450, 'Mell. Enkeltgravskultur', 'cordedware.middle', 'dime.period.cordedware.middle'),
('dime.period', 'AYEX', 'AYXX', 5, -2800, -2350, 'Enkeltgravskultur', 'cordedware', 'dime.period.cordedware'),
('dime.period', 'AYEY', 'AYEX', 6, -2450, -2350, 'Yngre Enkeltgravskultur', 'cordedware.late', 'dime.period.cordedware.late'),
('dime.period', 'AYGX', 'AYXX', 5, -2900, -2600, 'Grubekeramisk kultur', 'pittedware', 'dime.period.pittedware'),
('dime.period', 'AYKX', 'AYXX', 5, -2350, -1950, 'Klokkebægerkultur', 'bellbeaker', 'dime.period.bellbeaker'),
('dime.period', 'AYSÆ', 'AYSÆ', 6, -2350, -1950, 'Ældre Senneolitikum', 'lateneolithic.early', 'dime.period.lateneolithic.early'),
('dime.period', 'AYSX', 'AYXX', 5, -2350, -1700, 'Senneolitikum', 'lateneolithic', 'dime.period.lateneolithic'),
('dime.period', 'AYSY', 'AYSÆ', 6, -1950, -1700, 'Yngre Senneolitikum', 'lateneolithic.late', 'dime.period.lateneolithic.late'),
('dime.period', 'AYTÆ', 'AYTX', 6, -3900, -3300, 'Ældre Tragtbægerkultur', 'funnelbeaker.early', 'dime.period.funnelbeaker.early'),
('dime.period', 'AYTM', 'AYTX', 6, -3300, -2800, 'Mellemneolitisk Tragtbægerkultur', 'funnelbeaker.middle', 'dime.period.funnelbeaker.middle'),
('dime.period', 'AYTX', 'AYXX', 5, -3900, -2800, 'Tragtbægerkultur', 'funnelbeaker', 'dime.period.funnelbeaker'),
('dime.period', 'AYXX', 'OXXX', 4, -3900, -1700, 'Yngre Stenalder', 'stoneage.early', 'dime.period.stoneage.early'),
('dime.period', 'BÆX1', 'BÆXX', 5, -1700, -1500, 'Ældre Bronzealder per.1', 'bronze.early.1', 'dime.period.bronze.early.1'),
('dime.period', 'BÆX2', 'BÆXX', 5, -1500, -1300, 'Ældre Bronzealder per.2', 'bronze.early.2', 'dime.period.bronze.early.2'),
('dime.period', 'BÆX3', 'BÆXX', 5, -1300, -1100, 'Ældre Bronzealder per.3', 'bronze.early.3', 'dime.period.bronze.early.3'),
('dime.period', 'BÆXX', 'BXXX', 4, -1700, -1100, 'Ældre Bronzealder', 'bronze.early', 'dime.period.bronze.early'),
('dime.period', 'BXXX', 'OXXX', 3, -1700, -500, 'Bronzealder', 'bronze', 'dime.period.bronze'),
('dime.period', 'BYX4', 'BYXX', 5, -1100, -900, 'Yngre Bronzealder per.4', 'bronze.late.4', 'dime.period.bronze.late.4'),
('dime.period', 'BYX5', 'BYXX', 5, -900, -700, 'Yngre Bronzealder per.5', 'bronze.late.5', 'dime.period.bronze.late.5'),
('dime.period', 'BYX6', 'BYXX', 5, -700, -500, 'Yngre Bronzealder per.6', 'bronze.late.6', 'dime.period.bronze.late.6'),
('dime.period', 'BYXX', 'BXXX', 4, -1100, -500, 'Yngre Bronzealder', 'bronze.late', 'dime.period.bronze.late'),
('dime.period', 'CÆFÆ', 'CÆFX', 6, -500, -400, 'Ældre Førromersk Jernalder (per.1)', 'ironage.preroman.early', 'dime.period.ironage.preroman.early'),
('dime.period', 'CÆFM', 'CÆFX', 6, -400, -100, 'Mell. Førromersk Jernalder (per.2)', 'ironage.preroman.middle', 'dime.period.ironage.preroman.middle'),
('dime.period', 'CÆFX', 'CÆXX', 5, -500, 0, 'Førromersk Jernalder', 'ironage.preroman', 'dime.period.ironage.preroman'),
('dime.period', 'CÆFY', 'CÆFX', 6, -100, 0, 'Yngre Førromersk Jernalder (per.3A)', 'ironage.preroman.late', 'dime.period.ironage.preroman.late'),
('dime.period', 'CÆRA', 'CÆRÆ', 7, 1, 70, 'Ældre Romersk Jernalder, B1', 'ironage.roman.early.b1', 'dime.period.ironage.roman.early.b1'),
('dime.period', 'CÆRÆ', 'CÆRX', 6, 1, 175, 'Ældre Romersk Jernalder', 'ironage.roman.early', 'dime.period.ironage.roman.early'),
('dime.period', 'CÆRB', 'CÆRÆ', 7, 70, 175, 'Ældre Romersk Jernalder, B2', 'ironage.roman.early.b2', 'dime.period.ironage.roman.early.b2'),
('dime.period', 'CÆRC', 'CÆRY', 7, 175, 250, 'Yngre Romersk Jernalder, C1', 'ironage.roman.late.c1', 'dime.period.ironage.roman.late.c1'),
('dime.period', 'CÆRD', 'CÆRY', 7, 250, 310, 'Yngre Romersk Jernalder, C2', 'ironage.roman.late.c2', 'dime.period.ironage.roman.late.c2'),
('dime.period', 'CÆRE', 'CÆRY', 7, 310, 375, 'Yngre Romersk Jernalder, C3', 'ironage.roman.late.c3', 'dime.period.ironage.roman.late.c3'),
('dime.period', 'CÆRX', 'CÆXX', 5, 1, 375, 'Romersk Jernalder', 'ironage.roman', 'dime.period.ironage.roman'),
('dime.period', 'CÆRY', 'CÆRX', 6, 175, 375, 'Yngre Romersk Jernalder', 'ironage.roman.late', 'dime.period.ironage.roman.late'),
('dime.period', 'CÆXX', 'CXXX', 4, -500, 375, 'Ældre Jernalder', 'ironage.early', 'dime.period.ironage.early'),
('dime.period', 'CXXX', 'OXXX', 3, -500, 1066, 'Jernalder', 'ironage', 'dime.period.ironage'),
('dime.period', 'CYGÆ', 'CYGX', 6, 375, 600, 'Ældre Germansk Jernalder', 'ironage.germanic.early', 'dime.period.ironage.germanic.early'),
('dime.period', 'CYGX', 'CYXX', 5, 375, 750, 'Germansk Jernalder', 'ironage.germanic', 'dime.period.ironage.germanic'),
('dime.period', 'CYGY', 'CYGX', 6, 600, 750, 'Yngre Germansk Jernalder', 'ironage.germanic.late', 'dime.period.ironage.germanic.late'),
('dime.period', 'CYVÆ', 'CYVX', 6, 750, 900, 'Ældre Vikingetid', 'viking.early', 'dime.period.viking.early'),
('dime.period', 'CYVX', 'CYXX', 5, 750, 1066, 'Vikingetid', 'viking', 'dime.period.viking'),
('dime.period', 'CYVY', 'CYVX', 6, 900, 1066, 'Yngre Vikingetid', 'viking.late', 'dime.period.viking.late'),
('dime.period', 'CYXX', 'CXXX', 4, 375, 1066, 'Yngre Jernalder (Germansk jernalder og Vikingetid)', 'ironage.late', 'dime.period.ironage.late'),
('dime.period', 'DÆX1', 'DÆXX', 5, 1067, 1199, 'Ældre middelalder (1067 - 1100-tal)', 'medieval.early.c12th', 'dime.period.medieval.early.c12th'),
('dime.period', 'DÆX2', 'DÆXX', 5, 1200, 1299, 'Ældre middelalder (1200-tal)', 'medieval.early.c13th', 'dime.period.medieval.early.c13th'),
('dime.period', 'DÆXX', 'DXXX', 4, 1067, 1299, 'Ældre Middelalder (1066 - 1300)', 'medieval.early', 'dime.period.medieval.early'),
('dime.period', 'DXXX', 'OXXX', 3, 1067, 1535, 'Middelalder', 'medieval', 'dime.period.medieval'),
('dime.period', 'DYX3', 'DYXX', 5, 1300, 1399, 'Yngre middelalder (1300-tal)', 'medieval.late.c14th', 'dime.period.medieval.late.c14th'),
('dime.period', 'DYX4', 'DYXX', 5, 1400, 1499, 'Yngre middelalder (1400-tal)', 'medieval.late.c15th', 'dime.period.medieval.late.c15th'),
('dime.period', 'DYX5', 'DYXX', 5, 1500, 1535, 'Yngre middelalder (1500-tal)', 'medieval.late.c16th', 'dime.period.medieval.late.c16th'),
('dime.period', 'DYXX', 'DXXX', 4, 1300, 1535, 'Yngre Middelalder (1250 - 1535)', 'medieval.late', 'dime.period.medieval.late'),
('dime.period', 'EXXX', 'OXXX', 3, 1536, 1660, 'Efterreformatorisk tid (1536-1660)', 'reformation', 'dime.period.reformation'),
('dime.period', 'FÆXX', 'FXXX', 4, 1661, 1799, 'Nyere tid, 1600-1700 tallet', 'modern.c17th', 'dime.period.modern.c17th'),
('dime.period', 'FMIN', 'FXXX', 4, 1800, 1913, 'Nyere tid, industrialismen', 'modern.industrial', 'dime.period.modern.industrial'),
('dime.period', 'FMV1', 'FXXX', 4, 1914, 1918, '1914-18, 1. Verdenskrig', 'modern.ww1', 'dime.period.modern.ww1'),
('dime.period', 'FMV2', 'FXXX', 4, 1940, 1945, '1940-45, 2. Verdenskrig', 'modern.ww2', 'dime.period.modern.ww2'),
('dime.period', 'FMVM', 'FXXX', 4, 1919, 1939, '1919-39, Mellemskrigstiden', 'modern.interwar', 'dime.period.modern.interwar'),
('dime.period', 'FXXX', 'HXXX', 3, 1661, 2100, 'Nyere tid (1661 - )', 'modern', 'dime.period.modern'),
('dime.period', 'FYDI', 'FXXX', 4, 1990, 2100, 'Nyere tid, digital gennembrud', 'modern.digital', 'dime.period.modern.digital'),
('dime.period', 'FYEL', 'FXXX', 4, 1960, 1989, 'Nyere tid, elektronisk gennembrud', 'modern.electronic', 'dime.period.modern.electronic'),
('dime.period', 'FYVE', 'FXXX', 4, 1946, 1959, 'Nyere tid, efterkrigstiden', 'modern.postwar', 'dime.period.modern.postwar'),
('dime.period', 'HXXX', 'XXXX', 2, 1067, 0, 'Historisk tid (1067 -)', 'historic', 'dime.period.historic'),
('dime.period', 'OXXX', 'XXXX', 2, -250000, 1066, 'Oldtid', 'prehistoric', 'dime.period.prehistoric'),
('dime.period', 'TM1A', 'ATM1', 8, -3300, -3200, 'Mellemneolitisk Tragtbægerkultur 1A', 'funnelbeaker.middle.ia', 'dime.period.funnelbeaker.middle.ia'),
('dime.period', 'TM1B', 'ATM1', 8, -3200, -3100, 'Mellemneolitisk Tragtbægerkultur 1B', 'funnelbeaker.middle.ib', 'dime.period.funnelbeaker.middle.ib'),
('dime.period', 'XXXX', '', 1, -250000, 2100, 'Udateret', 'undated', 'dime.period.undated');

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
-- Indexes for table `ark_format`
--
ALTER TABLE `ark_format`
  ADD PRIMARY KEY (`format`),
  ADD KEY `fragment_type` (`type`);

--
-- Indexes for table `ark_format_attribute`
--
ALTER TABLE `ark_format_attribute`
  ADD PRIMARY KEY (`parent`,`attribute`),
  ADD KEY `vocabulary` (`vocabulary`),
  ADD KEY `format` (`format`);

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
-- Indexes for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_format_wkt`
--
ALTER TABLE `ark_format_wkt`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_fragment_type`
--
ALTER TABLE `ark_fragment_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `ark_module`
--
ALTER TABLE `ark_module`
  ADD PRIMARY KEY (`module`);

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
  ADD PRIMARY KEY (`schma`,`type`,`association`) USING BTREE,
  ADD KEY `inverse_schema` (`inverse`);

--
-- Indexes for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD PRIMARY KEY (`schma`,`type`,`attribute`) USING BTREE,
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
  ADD KEY `role` (`role`);

--
-- Indexes for table `ark_translation_parameter`
--
ALTER TABLE `ark_translation_parameter`
  ADD PRIMARY KEY (`keyword`,`parameter`);

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
  ADD KEY `type` (`type`),
  ADD KEY `schma` (`schma`);

--
-- Indexes for table `ark_view_layout`
--
ALTER TABLE `ark_view_layout`
  ADD PRIMARY KEY (`layout`,`item_type`,`row`,`col`,`seq`),
  ADD KEY `child` (`cell`);

--
-- Indexes for table `ark_view_option`
--
ALTER TABLE `ark_view_option`
  ADD PRIMARY KEY (`element`,`name`);

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
  ADD KEY `from_term` (`from_concept`,`from_term`) USING BTREE,
  ADD KEY `to_term` (`to_concept`,`to_term`) USING BTREE;

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
  ADD UNIQUE KEY `keyword` (`keyword`);

--
-- Indexes for table `ark_vocabulary_translation`
--
ALTER TABLE `ark_vocabulary_translation`
  ADD PRIMARY KEY (`language`,`domain`,`keyword`,`role`),
  ADD KEY `keyword` (`keyword`),
  ADD KEY `domain` (`domain`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `ark_vocabulary_type`
--
ALTER TABLE `ark_vocabulary_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `cor_conf_layout_role`
--
ALTER TABLE `cor_conf_layout_role`
  ADD PRIMARY KEY (`layout_role`);

--
-- Indexes for table `cor_conf_page`
--
ALTER TABLE `cor_conf_page`
  ADD PRIMARY KEY (`page`);

--
-- Indexes for table `cor_conf_page_layout`
--
ALTER TABLE `cor_conf_page_layout`
  ADD PRIMARY KEY (`page`,`module`,`layout_role`);

--
-- Indexes for table `dime_period`
--
ALTER TABLE `dime_period`
  ADD PRIMARY KEY (`concept`,`term`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ark_config_flash`
--
ALTER TABLE `ark_config_flash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ark_format`
--
ALTER TABLE `ark_format`
  ADD CONSTRAINT `ark_format_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_fragment_type` (`type`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD CONSTRAINT `ark_format_string_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_wkt`
--
ALTER TABLE `ark_format_wkt`
  ADD CONSTRAINT `ark_format_wkt_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `ark_view_element_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_view_type` (`type`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_element_ibfk_2` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_layout`
--
ALTER TABLE `ark_view_layout`
  ADD CONSTRAINT `ark_view_layout_ibfk_1` FOREIGN KEY (`layout`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_layout_ibfk_2` FOREIGN KEY (`cell`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_option`
--
ALTER TABLE `ark_view_option`
  ADD CONSTRAINT `ark_view_option_ibfk_1` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

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
