-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2017 at 10:26 PM
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
-- Table structure for table `ark_datatype`
--

CREATE TABLE `ark_datatype` (
  `datatype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object` tinyint(1) NOT NULL DEFAULT '0',
  `compound` tinyint(1) NOT NULL DEFAULT '1',
  `storage_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_size` int(11) DEFAULT NULL,
  `spanable` tinyint(1) NOT NULL DEFAULT '1',
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_type_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_datatype`
--

INSERT INTO `ark_datatype` (`datatype`, `object`, `compound`, `storage_type`, `storage_size`, `spanable`, `value_name`, `value_form_class`, `parameter_name`, `parameter_vocabulary`, `parameter_form_class`, `format_name`, `format_vocabulary`, `format_form_class`, `model_table`, `model_class`, `data_table`, `data_class`, `form_type_class`, `enabled`, `deprecated`, `keyword`) VALUES
('blob', 0, 1, 'blob', NULL, 0, 'blob', NULL, NULL, NULL, NULL, 'mediatype', 'mediatype', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 'ark_format_blob', 'ARK\\Model\\Format\\BlobFormat', 'ark_fragment_blob', 'ARK\\Model\\Fragment\\BlobFragment', NULL, 0, 0, 'core.datatype.blob'),
('boolean', 0, 0, 'boolean', NULL, 0, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_boolean', 'ARK\\Model\\Format\\BooleanFormat', 'ark_fragment_boolean', 'ARK\\Model\\Fragment\\BooleanFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.boolean'),
('date', 0, 0, 'date', NULL, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_datetime', 'ARK\\Model\\Format\\DateFormat', 'ark_fragment_date', 'ARK\\Model\\Fragment\\DateFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.date'),
('datetime', 0, 0, 'datetime', NULL, 1, 'datetime', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateTimeType', 'timezone', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, 'ark_format_datetime', 'ARK\\Model\\Format\\DateTimeFormat', 'ark_fragment_datetime', 'ARK\\Model\\Fragment\\DateTimeFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.datetime'),
('decimal', 0, 0, 'string', 200, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_decimal', 'ARK\\Model\\Format\\DecimalFormat', 'ark_fragment_decimal', 'ARK\\Model\\Fragment\\DecimalFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.decimal'),
('float', 0, 0, 'float', NULL, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_float', 'ARK\\Model\\Format\\FloatFormat', 'ark_fragment_float', 'ARK\\Model\\Fragment\\FloatFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.float'),
('integer', 0, 0, 'integer', NULL, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_integer', 'ARK\\Model\\Format\\IntegerFormat', 'ark_fragment_integer', 'ARK\\Model\\Fragment\\IntegerFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.integer'),
('item', 0, 1, 'string', 30, 1, 'item', NULL, 'module', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, 'ark_format_item', 'ARK\\Model\\Format\\ItemFormat', 'ark_fragment_item', 'ARK\\Model\\Fragment\\ItemFragment', 'ARK\\Form\\Type\\ItemType', 1, 0, 'core.datatype.item'),
('object', 1, 0, 'integer', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_object', 'ARK\\Model\\Format\\ObjectFormat', 'ark_fragment_object', 'ARK\\Model\\Fragment\\ObjectFragment', 'ARK\\Form\\Type\\PropertyType', 1, 0, 'core.datatype.object'),
('spatial', 0, 1, 'string', 1431655765, 0, 'geometry', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 'srid', 'spatial.crs', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 'format', 'spatial.format', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', 'ark_format_spatial', 'ARK\\Model\\Format\\SpatialFormat', 'ark_fragment_spatial', 'ARK\\Model\\Fragment\\SpatialFragment', 'ARK\\Form\\Type\\WktType', 1, 0, 'core.datatype.spatial'),
('string', 0, 0, 'string', 4000, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_string', 'ARK\\Model\\Format\\StringFormat', 'ark_fragment_string', 'ARK\\Model\\Fragment\\StringFragment', 'ARK\\Form\\Type\\ScalarFormType', 1, 0, 'core.datatype.string'),
('text', 0, 1, 'string', 1431655765, 0, 'content', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', 'language', 'language', NULL, 'mimetype', 'mediatype', NULL, 'ark_format_text', 'ARK\\Model\\Format\\TextFormat', 'ark_fragment_text', 'ARK\\Model\\Fragment\\TextFragment', 'ARK\\Form\\Type\\LocalTextType', 1, 0, 'core.datatype.text'),
('time', 0, 0, 'time', NULL, 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', NULL, NULL, NULL, NULL, NULL, NULL, 'ark_format_datetime', 'ARK\\Model\\Format\\TimeFormat', 'ark_fragment_time', 'ARK\\Model\\Fragment\\TimeFragment', 'ARK\\Form\\Type\\ScalarFormType', 0, 0, 'core.datatype.time');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format`
--

CREATE TABLE `ark_format` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datatype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format_form_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `ark_format` (`format`, `datatype`, `entity`, `value_name`, `value_form_class`, `parameter_name`, `parameter_vocabulary`, `parameter_form_class`, `format_name`, `format_vocabulary`, `format_form_class`, `form_type_class`, `object`, `array`, `multiple`, `sortable`, `searchable`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'item', 'ARK\\Actor\\Actor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 'format.actor'),
('address', 'object', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, 1, 0, 'format.address'),
('blob', 'blob', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 'format.blob'),
('boolean', 'boolean', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.boolean'),
('color', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.colour'),
('date', 'date', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.date'),
('datetime', 'datetime', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.datetime'),
('decimal', 'decimal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.decimal'),
('distance', 'decimal', NULL, NULL, NULL, 'unit', 'distance', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.distance'),
('email', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.email'),
('event', 'object', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, 1, 0, 'format.event'),
('file', 'item', 'ARK\\File\\File', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 'format.file'),
('fileversion', 'object', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ARK\\Form\\Type\\FileVersionType', 1, 0, 0, 0, 1, 1, 0, 'format.fileversion'),
('float', 'float', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.float'),
('html', 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1, 0, 'format.html'),
('identifier', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.identifier'),
('integer', 'integer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.integer'),
('item', 'item', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 'format.item'),
('key', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.key'),
('markdown', 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1, 0, 'format.markdown'),
('mass', 'decimal', NULL, NULL, NULL, 'unit', 'mass', 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.mass'),
('module', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 1, 0, 'format.module'),
('money', 'decimal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.money'),
('ordinaldate', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.ordinaldate'),
('password', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.password'),
('percent', 'float', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.percent'),
('plaintext', 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1, 0, 'format.localtext'),
('recipient', 'object', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 1, 1, 0, 'format.recipient'),
('richtext', 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1, 0, 'format.richtext'),
('shorttext', 'text', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 1, 0, 'format.shortlocaltext'),
('spatial', 'spatial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.geometry'),
('string', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.string'),
('telephone', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.telephone'),
('term', 'string', 'ARK\\Vocabulary\\Term', 'term', 'ARK\\Form\\Type\\TermChoiceType', 'concept', NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, 'ARK\\Form\\Type\\VocabularyFormType', 0, 0, 0, 1, 1, 1, 0, 'format.identifier'),
('time', 'time', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.time'),
('url', 'text', NULL, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 1, 1, 1, 0, 'format.url'),
('weekdate', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.weekdate'),
('wkt', 'spatial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1, 1, 0, 'format.wkt'),
('yearmonth', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.yearmonth'),
('yearweek', 'string', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, 1, 0, 'format.yearweek');

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
('address', 'city', 1, 'plaintext', NULL, 0, 1, 1, 1, 0, 1, 0, 'format.address.city'),
('address', 'country', 2, 'term', 'country', 0, 1, 1, 1, 0, 1, 0, 'format.address.country'),
('address', 'street', 0, 'plaintext', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.address.street'),
('event', 'by', 0, 'actor', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.event.by'),
('event', 'on', 1, 'datetime', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.event.on'),
('fileversion', 'created', 3, 'event', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.created'),
('fileversion', 'expires', 5, 'datetime', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.expires'),
('fileversion', 'modified', 4, 'event', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.modified'),
('fileversion', 'name', 1, 'string', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.name'),
('fileversion', 'sequence', 0, 'integer', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.sequence'),
('fileversion', 'version', 2, 'string', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.fileversion.string'),
('recipient', 'read_on', 1, 'datetime', NULL, 0, 1, 1, 1, 0, 1, 0, 'format.recipient.read_on'),
('recipient', 'sent_to', 0, 'actor', NULL, 1, 1, 1, 1, 0, 1, 0, 'format.recipient.sent_to');

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
('actor', 'actor'),
('file', 'file');

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
('mass'),
('recipient');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_spatial`
--

CREATE TABLE `ark_format_spatial` (
  `format` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

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

--
-- Dumping data for table `ark_instance`
--

INSERT INTO `ark_instance` (`instance`, `enabled`, `deprecated`) VALUES
('dime', 1, 0);

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

--
-- Dumping data for table `ark_instance_schema`
--

INSERT INTO `ark_instance_schema` (`instance`, `schma`, `enabled`, `deprecated`) VALUES
('dime', 'core.actor', 1, 0),
('dime', 'core.file', 1, 0),
('dime', 'core.message', 1, 0),
('dime', 'core.page', 1, 0),
('dime', 'dime.find', 1, 0),
('dime', 'dime.image', 1, 0),
('dime', 'dime.locality', 1, 0);

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

--
-- Dumping data for table `ark_map`
--

INSERT INTO `ark_map` (`map`, `draggable`, `zoomable`, `clickable`, `options`, `keyword`) VALUES
('dime_map_public', 1, 1, 1, '', 'dime.map.public'),
('dime_map_user', 1, 1, 1, '', 'dime.map.user');

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
('bing', 'road', 'Road', '', '', '', 'map.layer.bing.road'),
('kortforsyningen', 'foraar', 'orto_foraar', 'http://kortforsyningen.kms.dk/service?servicename=orto_foraar&service=WMS', '', '{\"LAYERS\": \"orto_foraar\", \"VERSION\": \"1.1.1\", \"FORMAT\": \"image/png\", \"TILED\": true}', 'dime.map.layer.foraar'),
('kortforsyningen', 'skaermkort', 'topo_skaermkort', 'http://kortforsyningen.kms.dk/service?servicename=topo_skaermkort&service=WMS', '', '{\"LAYERS\": \"topo_skaermkort\", \"VERSION\": \"1.1.1\", \"FORMAT\": \"image/png\", \"TILED\": true }', 'dime.map.layer.skaermkort');

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

--
-- Dumping data for table `ark_map_legend`
--

INSERT INTO `ark_map_legend` (`map`, `source`, `layer`, `seq`, `is_default`, `enabled`, `visible`, `options`, `keyword`) VALUES
('dime_map_public', 'bing', 'aerial', 2, 0, 1, 0, '', ''),
('dime_map_public', 'bing', 'aerialwithlabels', 1, 1, 1, 1, '', ''),
('dime_map_public', 'bing', 'road', 3, 0, 1, 0, '', ''),
('dime_map_public', 'kortforsyningen', 'foraar', 4, 0, 1, 0, '', ''),
('dime_map_public', 'kortforsyningen', 'skaermkort', 5, 0, 1, 0, '', ''),
('dime_map_user', 'bing', 'aerial', 2, 0, 1, 0, '', ''),
('dime_map_user', 'bing', 'aerialwithlabels', 1, 1, 1, 1, '', ''),
('dime_map_user', 'bing', 'road', 3, 0, 1, 0, '', ''),
('dime_map_user', 'kortforsyningen', 'foraar', 4, 0, 1, 0, '', ''),
('dime_map_user', 'kortforsyningen', 'skaermkort', 5, 0, 1, 0, '', '');

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
  `ticket_expiry` timestamp NULL DEFAULT NULL,
  `options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_map_source`
--

INSERT INTO `ark_map_source` (`source`, `type`, `subtype`, `format`, `view_class`, `ticket`, `ticket_expiry`, `options`, `keyword`) VALUES
('bing', 'raster', 'tile', 'bing', 'BingMaps', 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3', NULL, '', 'map.source.bing'),
('kortforsyningen', 'raster', 'tile', 'wms', 'TileWMS', '', NULL, '', 'map.source.kfs');

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
('actor', 'actors', 'ARK', 'ARK\\Actor', 'Actor', 'ARK\\Actor\\Actor', 'ark_item_actor', 1, 1, 0, 'module.actor'),
('event', 'events', 'ARK', 'ARK\\Workflow', 'Event', 'ARK\\Workflow\\Event', 'ark_item_event', 1, 1, 0, 'module.event'),
('file', 'files', 'ARK', 'ARK\\File', 'File', 'ARK\\File\\File', 'ark_item_file', 1, 1, 0, 'module.file'),
('find', 'finds', 'DIME', 'DIME\\Entity', 'Find', 'DIME\\Entity\\Find', 'ark_item_find', 0, 1, 0, 'dime.find'),
('image', 'images', 'DIME', 'DIME\\Entity', 'Image', 'DIME\\Entity\\Image', 'ark_item_image', 0, 1, 0, 'dime.image'),
('locality', 'localities', 'DIME', 'DIME\\Entity', 'Locality', 'DIME\\Entity\\Locality', 'ark_item_locality', 0, 1, 0, 'dime.locality'),
('message', 'messages', 'ARK', 'ARK\\Message', 'Message', 'ARK\\Message\\Message', 'ark_item_message', 1, 1, 0, 'module.message'),
('page', 'page', 'ARK', 'ARK\\Entity', 'Page', 'ARK\\Entity\\Page', 'ark_item_page', 1, 1, 0, 'module.page');

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_access`
--

CREATE TABLE `ark_rbac_access` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_rbac_access`
--

INSERT INTO `ark_rbac_access` (`role`, `permission`) VALUES
('admin', 'dime_view_find'),
('anon', 'dime_view_find'),
('appraiser', 'dime_view_find'),
('curator', 'dime_view_find'),
('detectorist', 'dime_view_find'),
('registrar', 'dime_view_find'),
('researcher', 'dime_view_find'),
('admin', 'dime_view_finder'),
('appraiser', 'dime_view_finder'),
('curator', 'dime_view_finder'),
('detectorist', 'dime_view_finder'),
('registrar', 'dime_view_finder'),
('researcher', 'dime_view_finder'),
('admin', 'dime_view_location'),
('appraiser', 'dime_view_location'),
('curator', 'dime_view_location'),
('detectorist', 'dime_view_location'),
('registrar', 'dime_view_location'),
('researcher', 'dime_view_location');

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_permission`
--

CREATE TABLE `ark_rbac_permission` (
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_rbac_permission`
--

INSERT INTO `ark_rbac_permission` (`permission`, `enabled`, `keyword`) VALUES
('dime_view_find', 1, ''),
('dime_view_finder', 1, ''),
('dime_view_location', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_rbac_role`
--

CREATE TABLE `ark_rbac_role` (
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_rbac_role`
--

INSERT INTO `ark_rbac_role` (`role`, `enabled`, `keyword`) VALUES
('admin', 1, 'dime.role.admin'),
('anon', 1, 'dime.role.anon'),
('appraiser', 1, 'dime.role.appraiser'),
('curator', 1, 'dime.role.curator'),
('detectorist', 1, 'dime.role.detectorist'),
('registrar', 1, 'dime.role.registrar'),
('researcher', 1, 'dime.role.reasearcher');

-- --------------------------------------------------------

--
-- Table structure for table `ark_route`
--

CREATE TABLE `ark_route` (
  `route` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_get` tinyint(1) NOT NULL DEFAULT '1',
  `can_post` tinyint(1) NOT NULL DEFAULT '0',
  `controller` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_route`
--

INSERT INTO `ark_route` (`route`, `path`, `can_get`, `can_post`, `controller`, `page`) VALUES
('find.list', '/fund', 1, 0, 'DIME\\Controller\\FindListController', NULL),
('find.view', '/fund/{itemSlug}', 1, 1, 'DIME\\Controller\\FindViewController', 'dime_page_find'),
('front', '/', 1, 0, 'DIME\\Controller\\FrontPageController', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema`
--

CREATE TABLE `ark_schema` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `generator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entities` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema`
--

INSERT INTO `ark_schema` (`schma`, `module`, `generator`, `sequence`, `type`, `vocabulary`, `entities`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'actor', 'sequence', 'id', 'type', 'core.actor.type', 1, 1, 0, 'core.actor'),
('core.event', 'event', 'sequence', 'id', NULL, NULL, 0, 1, 0, 'core.event'),
('core.file', 'file', 'sequence', NULL, 'type', 'core.file.type', 1, 1, 0, 'core.file'),
('core.message', 'message', 'sequence', 'id', 'type', 'core.message.type', 1, 1, 0, 'core.message'),
('core.page', 'page', 'sequence', NULL, NULL, NULL, 0, 1, 0, 'core.page'),
('dime.find', 'find', 'sequence', 'id', 'type', 'dime.find.type', 0, 1, 0, 'dime.find'),
('dime.image', 'image', 'sequence', 'id', NULL, NULL, 0, 1, 0, 'dime.image'),
('dime.locality', 'locality', 'sequence', 'id', NULL, NULL, 0, 1, 0, 'dime.locality');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_association`
--

CREATE TABLE `ark_schema_association` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schema1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` int(11) NOT NULL,
  `inverse` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schema2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inverse_degree` int(11) NOT NULL,
  `bidirectional` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_schema_association`
--

INSERT INTO `ark_schema_association` (`schma`, `type`, `association`, `module1`, `schema1`, `degree`, `inverse`, `module2`, `schema2`, `inverse_degree`, `bidirectional`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'actor', 'messages', 'actor', 'core.actor', 0, 'recipients', 'message', 'core.message', 0, 0, 1, 0, ''),
('core.message', 'message', 'finds', 'message', 'core.message', 0, 'messages', 'actor', 'core.actor', 0, 1, 1, 0, ''),
('core.message', 'message', 'recipients', 'message', 'core.message', 0, 'messages', 'actor', 'core.actor', 0, 1, 1, 0, ''),
('dime.find', 'find', 'messages', 'find', 'dime.find', 0, 'finds', 'message', 'core.message', 0, 0, 1, 0, '');

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
('core.actor', 'actor', 'fullname', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.fullname'),
('core.actor', 'actor', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.id'),
('core.actor', 'actor', 'shortname', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.shortname'),
('core.actor', 'actor', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.type'),
('core.actor', 'museum', 'kommuner', 'term', 'dime.denmark.kommune', 0, 0, 1, 0, 1, 0, 'dime.actor.kommuner'),
('core.event', 'event', 'agent', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'core.event.agent'),
('core.event', 'event', 'event', 'term', NULL, 1, 1, 1, 0, 1, 0, 'core.event.event'),
('core.event', 'event', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.event.id'),
('core.event', 'event', 'occurred', 'datetime', NULL, 1, 1, 1, 0, 1, 0, 'core.event.occurred'),
('core.event', 'event', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.event.type'),
('core.file', 'file', 'description', 'plaintext', NULL, 0, 1, 1, 0, 1, 0, 'core.file.description'),
('core.file', 'file', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.id'),
('core.file', 'file', 'mediatype', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.file.mediatype'),
('core.file', 'file', 'status', 'term', 'core.file.status', 1, 1, 1, 0, 1, 0, 'core.file.status'),
('core.file', 'file', 'title', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'core.file.title'),
('core.file', 'file', 'type', 'term', 'core.file.type', 1, 1, 1, 0, 1, 0, 'core.file.type'),
('core.file', 'file', 'versions', 'fileversion', NULL, 1, 0, 1, 0, 1, 0, 'core.file.versions'),
('core.message', 'mail', 'attachments', 'file', NULL, 0, 0, 1, 0, 1, 0, 'core.message.mail.attachments'),
('core.message', 'mail', 'body', 'plaintext', NULL, 1, 1, 1, 0, 1, 0, 'core.message.mail.body'),
('core.message', 'mail', 'subject', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'core.message.mail.subject'),
('core.message', 'message', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.message.id'),
('core.message', 'message', 'recipients', 'actor', NULL, 1, 0, 1, 0, 1, 0, 'core.message.recipients'),
('core.message', 'message', 'sender', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'core.message.sender'),
('core.message', 'message', 'sent', 'datetime', NULL, 1, 1, 1, 0, 1, 0, 'core.message.sent_at'),
('core.message', 'message', 'type', 'identifier', 'core.message.type', 1, 1, 1, 0, 1, 0, 'core.message.type'),
('core.message', 'notification', 'event', 'item', NULL, 1, 1, 1, 0, 1, 0, 'core.message.notification.event'),
('core.page', 'page', 'content', 'html', NULL, 1, 1, 1, 0, 1, 0, 'property.content'),
('core.page', 'page', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'core.page.id'),
('dime.find', 'find', 'condition', 'term', 'dime.find.condition', 0, 1, 1, 0, 1, 0, 'dime.find.condition'),
('dime.find', 'find', 'custodian', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.custodian'),
('dime.find', 'find', 'custody', 'term', 'dime.find.custody', 1, 1, 1, 0, 1, 0, 'dime.find.custody'),
('dime.find', 'find', 'description', 'plaintext', NULL, 0, 1, 1, 0, 1, 0, 'property.description'),
('dime.find', 'find', 'finddate', 'date', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.finddate'),
('dime.find', 'find', 'finder', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.finder'),
('dime.find', 'find', 'finder_id', 'identifier', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.finderid'),
('dime.find', 'find', 'findpoint', 'spatial', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.findpoint'),
('dime.find', 'find', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.id'),
('dime.find', 'find', 'image', 'string', NULL, 1, 0, 1, 1, 1, 0, 'dime.find.images'),
('dime.find', 'find', 'kommune', 'term', 'dime.denmark.kommune', 1, 1, 1, 0, 1, 0, 'dime.find.kommune'),
('dime.find', 'find', 'length', 'distance', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.length'),
('dime.find', 'find', 'material', 'term', 'dime.material', 1, 1, 1, 0, 1, 0, 'dime.find.material'),
('dime.find', 'find', 'museum', 'item', NULL, 1, 1, 1, 0, 1, 0, 'dime.actor.type.museum'),
('dime.find', 'find', 'owner', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.owner'),
('dime.find', 'find', 'period_end', 'term', 'dime.period', 0, 1, 1, 0, 1, 0, 'dime.find.period.end'),
('dime.find', 'find', 'period_start', 'term', 'dime.period', 0, 1, 1, 0, 1, 0, 'dime.find.period.start'),
('dime.find', 'find', 'process', 'term', 'dime.find.process', 1, 1, 1, 0, 1, 0, 'dime.find.process'),
('dime.find', 'find', 'recipient', 'actor', NULL, 0, 1, 1, 0, 1, 0, 'dime.find.recipient'),
('dime.find', 'find', 'recorder', 'actor', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.recorder'),
('dime.find', 'find', 'registered_id', 'identifier', NULL, 0, 1, 1, 0, 1, 0, 'property.registeredid'),
('dime.find', 'find', 'secondary', 'term', 'dime.find.secondary', 0, 0, 1, 0, 1, 0, 'dime.find.material.secondary'),
('dime.find', 'find', 'subtype', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.find.subtype'),
('dime.find', 'find', 'treasure', 'term', 'dime.treasure', 1, 1, 1, 0, 1, 0, 'dime.find.treasure'),
('dime.find', 'find', 'type', 'term', 'dime.find.type', 1, 1, 1, 0, 1, 0, 'dime.find.type'),
('dime.find', 'find', 'visibility', 'term', 'dime.find.visibility', 1, 1, 1, 0, 1, 0, 'dime.find.visibility'),
('dime.find', 'find', 'weight', 'mass', NULL, 0, 1, 1, 0, 1, 0, 'property.weight'),
('dime.image', 'image', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('dime.locality', 'locality', 'id', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.id'),
('dime.locality', 'locality', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.name'),
('dime.locality', 'locality', 'type', 'identifier', NULL, 1, 1, 1, 0, 1, 0, 'dime.locality.type');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

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
-- Table structure for table `ark_schema_permission`
--

CREATE TABLE `ark_schema_permission` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_schema_permission`
--

INSERT INTO `ark_schema_permission` (`schma`, `type`, `attribute`, `permission`) VALUES
('dime.find', 'find', 'finder', 'dime_view_finder'),
('dime.find', 'find', 'finder_id', 'dime_view_finder'),
('dime.find', 'find', 'findpoint', 'dime_view_location');

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
('core.actor', 'dime', 0, 0),
('core.actor.institution', 'core', 0, 0),
('core.actor.person', 'core', 0, 0),
('core.events', 'dime', 0, 0),
('core.file', 'dime', 0, 0),
('core.message', 'dime', 0, 0),
('core.message.notification.body', 'core', 0, 0),
('core.message.notification.event', 'dime', 0, 0),
('core.message.sender', 'core', 0, 0),
('core.message.sent_at', 'core', 0, 0),
('core.message.type', 'core', 0, 0),
('core.message.type.notification', 'dime', 0, 0),
('dime.about', 'dime', 0, 0),
('dime.about.background', 'dime', 0, 0),
('dime.about.groups', 'dime', 0, 0),
('dime.about.hevn', 'dime', 0, 0),
('dime.about.hevntext', 'dime', 0, 0),
('dime.about.instructions', 'dime', 0, 0),
('dime.about.museums', 'dime', 0, 0),
('dime.about.partners', 'dime', 0, 0),
('dime.action.record', 'dime', 0, 0),
('dime.action.report', 'dime', 0, 0),
('dime.actions', 'dime', 0, 0),
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
  `markup` tinyint(1) NOT NULL DEFAULT '0',
  `vocabulary` tinyint(1) NOT NULL DEFAULT '0',
  `text` tinyint(1) NOT NULL DEFAULT '0'
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
  `notes` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_translation_message`
--

INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('da', 'core.actor', 'resource', 'aktører', ''),
('da', 'core.events', 'resource', 'begivenheder', ''),
('da', 'core.file', 'resource', 'filer', ''),
('da', 'core.message', 'resource', 'beskeder', ''),
('da', 'core.message.notification.body', 'default', 'Notifikation', 'Notifikation'),
('da', 'core.message.notification.event', 'default', 'Begivenhed', ''),
('da', 'core.message.sender', 'default', 'Fra', 'Fra'),
('da', 'core.message.sent_at', 'default', 'Dato', 'Dato'),
('da', 'core.message.type', 'default', 'Type', 'Type'),
('da', 'core.message.type.notification', 'default', 'Notifikation', ''),
('da', 'dime.about', 'default', 'Om DIME', ''),
('da', 'dime.about.background', 'default', 'Baggrund for DIME', ''),
('da', 'dime.about.groups', 'default', 'Detektorforeninger', ''),
('da', 'dime.about.hevn', 'default', 'Hvem Er DIME?', ''),
('da', 'dime.about.hevntext', 'default', 'DIME er en fællesportal for detektorbrugere og Danske museer, der kan bruges af alle.', ''),
('da', 'dime.about.instructions', 'default', 'Vejledning', ''),
('da', 'dime.about.museums', 'default', 'Deltagende Museer', ''),
('da', 'dime.about.partners', 'default', 'Samarbejdspartnere', ''),
('da', 'dime.action.record', 'default', 'Optage', 'Optage'),
('da', 'dime.action.report', 'default', 'Berette', 'berette'),
('da', 'dime.actions', 'default', 'Handling', 'Handling'),
('da', 'dime.actor.fullname', 'default', 'Navn', ''),
('da', 'dime.actor.id', 'default', 'Aktører ID', ''),
('da', 'dime.actor.kommuner', 'default', 'Kommuner', ''),
('da', 'dime.actor.shortname', 'default', 'Kort Navn', ''),
('da', 'dime.actor.type', 'default', 'Type', ''),
('da', 'dime.background', 'default', 'Baggrund', ''),
('da', 'dime.background', 'resource', 'baggrund', ''),
('da', 'dime.copyright', 'default', 'Copyright © 2013-2017 Arkæologisk IT, Aarhus Universitet', ''),
('da', 'dime.credits', 'default', 'Datastruktur og support: Carsten Risager | Design: Casper Skaaning Andersen | Udvikling: L ~ P Archaeology', ''),
('da', 'dime.denmark.kommune', 'default', 'Kommune', ''),
('da', 'dime.detector', 'default', 'Metaldetektorbrug & Danefæ', ''),
('da', 'dime.detector', 'resource', 'detektering', ''),
('da', 'dime.exhibits', 'default', 'Digitale Udstillinger', ''),
('da', 'dime.exhibits', 'resource', 'udstiller', ''),
('da', 'dime.exhibits.forests', 'default', 'Guld og Grønne Skove', ''),
('da', 'dime.exhibits.weapons', 'default', 'Våben i Bronzealder', ''),
('da', 'dime.find', 'default', 'Fund', ''),
('da', 'dime.find', 'resource', 'fund', ''),
('da', 'dime.find.add', 'default', 'Opret Fund', ''),
('da', 'dime.find.condition', 'default', 'Bevaring', ''),
('da', 'dime.find.condition.modified', 'default', 'Modificeret', ''),
('da', 'dime.find.condition.unfinished', 'default', 'Ufærdige', ''),
('da', 'dime.find.finddate', 'default', 'Vælg Dato', ''),
('da', 'dime.find.finderid', 'default', 'Fund ID', ''),
('da', 'dime.find.findpoint', 'default', 'Koordinater', ''),
('da', 'dime.find.id', 'default', 'DIME ID', ''),
('da', 'dime.find.kommune', 'default', 'Kommune', ''),
('da', 'dime.find.length', 'default', 'Maksimal Dimension', ''),
('da', 'dime.find.material', 'default', 'Materiale', ''),
('da', 'dime.find.material.secondary', 'default', 'Sekundært Materiale(r)', ''),
('da', 'dime.find.period.end', 'default', 'Periode Slut', ''),
('da', 'dime.find.period.start', 'default', 'Periode', ''),
('da', 'dime.find.search', 'default', 'Søg Fund', ''),
('da', 'dime.find.treasure', 'default', 'Danefæ', ''),
('da', 'dime.find.type', 'default', 'Type', ''),
('da', 'dime.home', 'default', 'Hjem', ''),
('da', 'dime.home', 'resource', 'hjem', ''),
('da', 'dime.home.alarm', 'default', 'Underretninger', ''),
('da', 'dime.home.faq', 'default', '<dl>\\n<dt>Hvem Er DIME?</dt>\\n<dd>DIME er en fællesportal for detektorbrugere og Danske museer, der kan bruges af alle.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Hvorfor skal jeg bruge dime?</dt>\\n<dd>DIME muliggør en hurtigere behandling af dinefund i samarbejde med museet og giver dig overblik over dine fund og fundpladser.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Hvilke fund skal/kan uploades i DIME?</dt>\\n<dd>Alle detektorfund (ikke kun Danefæ) kan uploades i DIME.</dd>\\n<dd>&nbsp;</dd>\\n<dt>Kan andre se mine fundsteder?</dt>\\n<dd>Nej! Fundsteder og privatoplysninger er kunsynlige for museumsarkæologer og forskere med særlig adgang</dd>\\n<dd>&nbsp;</dd>\\n<dt>Findes der en dime-app?</dt>\\n<dd>En app-løsning til registrering i marken er under udvikling.</dd>\\n</dl>', ''),
('da', 'dime.home.hvert', 'default', 'Hvert år finder metaldetektorbrugere landet over tusindevis af genstande fra oldtid, middelal-der og senere perioder. Metalgenstandene er en del af vores fælles kulturarv og vigtige brikker i Danmarkshistorien. DIME sikrer oplysninger om fundene til gavn for nulevende og efterføl- gende generatione', ''),
('da', 'dime.home.welcome', 'default', 'Velkommen %name%', ''),
('da', 'dime.krogager', 'default', 'KrogagerFonden', ''),
('da', 'dime.locality', 'default', 'Lokalitet', ''),
('da', 'dime.locality', 'resource', 'lokalitet', ''),
('da', 'dime.locality.add', 'default', 'Opret Lokalitet', ''),
('da', 'dime.locality.id', 'default', 'DIME ID', ''),
('da', 'dime.locality.search', 'default', 'Søg Lokalitet', ''),
('da', 'dime.locality.type', 'default', 'Type', ''),
('da', 'dime.material', 'default', 'Materiale', ''),
('da', 'dime.material.silver', 'default', 'Silver Test', ''),
('da', 'dime.metaldetector', 'default', 'Metaldetektorbrug I Danmark', ''),
('da', 'dime.news', 'default', 'Nyheder', ''),
('da', 'dime.news', 'resource', 'nyheder', ''),
('da', 'dime.period', 'default', 'Periode', ''),
('da', 'dime.research', 'default', 'Forskning', ''),
('da', 'dime.research', 'resource', 'forskning', ''),
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
('en', 'core.actor', 'resource', 'actors', ''),
('en', 'core.actor.institution', 'default', 'Institution', ''),
('en', 'core.actor.person', 'default', 'Person', ''),
('en', 'core.events', 'resource', 'events', ''),
('en', 'core.file', 'resource', 'files', ''),
('en', 'core.message', 'resource', 'messages', ''),
('en', 'core.message.notification.body', 'default', 'Notification', ''),
('en', 'core.message.notification.event', 'default', 'Event', ''),
('en', 'core.message.sender', 'default', 'From', 'Fra'),
('en', 'core.message.sent_at', 'default', 'Date', ''),
('en', 'core.message.type', 'default', 'Type', ''),
('en', 'core.message.type.notification', 'default', 'Notification', ''),
('en', 'dime.about', 'default', 'About', ''),
('en', 'dime.about', 'resource', 'about', ''),
('en', 'dime.about.background', 'default', 'Background for DIME', ''),
('en', 'dime.about.groups', 'default', 'Detectorist Associations', ''),
('en', 'dime.about.hevn', 'default', 'What is DIME?', ''),
('en', 'dime.about.hevntext', 'default', 'DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.', ''),
('en', 'dime.about.instructions', 'default', 'Instructions', ''),
('en', 'dime.about.museums', 'default', 'Participating Museums', ''),
('en', 'dime.about.partners', 'default', 'Partners', ''),
('en', 'dime.action.record', 'default', 'Record', 'Record'),
('en', 'dime.action.report', 'default', 'Report', 'Report'),
('en', 'dime.actions', 'default', 'Action', 'Action'),
('en', 'dime.actor.fullname', 'default', 'Name', ''),
('en', 'dime.actor.id', 'default', 'Actor ID', ''),
('en', 'dime.actor.kommuner', 'default', 'Municipalities', ''),
('en', 'dime.actor.shortname', 'default', 'Short Name', ''),
('en', 'dime.actor.type', 'default', 'Type', ''),
('en', 'dime.association.campaigns', 'default', 'Campaigns', ''),
('en', 'dime.background', 'default', 'Background', ''),
('en', 'dime.background', 'resource', 'background', ''),
('en', 'dime.campaign', 'default', 'Campaign', ''),
('en', 'dime.copyright', 'default', 'Copyright © 2013-2017 Arkæologisk IT, Aarhus University', ''),
('en', 'dime.credits', 'default', 'Data modelling and support: Carsten Risager | Design: Casper Skaaning Anderson | Implementation: L ~ P Archaeology', ''),
('en', 'dime.denmark.kommune', 'default', 'Municipalities', ''),
('en', 'dime.detector', 'default', 'Detecting', ''),
('en', 'dime.detector', 'resource', 'detecting', ''),
('en', 'dime.exhibits', 'default', 'Exhibits', ''),
('en', 'dime.exhibits', 'resource', 'exhibits', ''),
('en', 'dime.exhibits.forests', 'default', 'Gold and Green Forests', ''),
('en', 'dime.exhibits.weapons', 'default', 'Weapons in the Bronze Age', ''),
('en', 'dime.find', 'default', 'Find', ''),
('en', 'dime.find', 'resource', 'finds', ''),
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
('en', 'dime.home', 'resource', 'home', ''),
('en', 'dime.home.alarm', 'default', 'Notifications', ''),
('en', 'dime.home.faq', 'default', '<dl>\\n\\n<dt>What is DIME?</dt>\\n<dd>DIME is a shared portal for detectorists and Danish museums that can be accessed by everyone.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Why should I use DIME?</dt>\\n<dd>DIME allows faster processing of your finds in cooperation with the museum, and gives you an overview of your finds and collection.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>What finds can be added to DIME? </dt>\\n<dd>All detector finds (not only Danefæ) can added to DIME.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Can others see my find locations?</dt>\\n<dd>No! Find locations and other private information are only visible for museum archaeologists and researchers with special access.</dd>\\n<dd>&nbsp;</dd>\\n\\n<dt>Is there a DIME app?</dt>\\n<dd>An app for recording in the field is under development.</dd>\\n\\n</dl>', ''),
('en', 'dime.home.hvert', 'default', 'Every year, the metal detector users across the country thousands of objects from antiquity, middelal-there and later periods. Metal objects are part of our common cultural heritage and important pieces in the history of Denmark. DIME provides information about the finds for the benefit of present and subsequent generatione', ''),
('en', 'dime.home.welcome', 'default', 'Welcome %user%', ''),
('en', 'dime.krogager', 'default', 'KrogagerFonden', ''),
('en', 'dime.locality', 'default', 'Locality', ''),
('en', 'dime.locality', 'resource', 'localities', ''),
('en', 'dime.locality.add', 'default', 'Add Locality', ''),
('en', 'dime.locality.id', 'default', 'DIME ID', ''),
('en', 'dime.locality.search', 'default', 'Search Localities', ''),
('en', 'dime.locality.type', 'default', 'Type', ''),
('en', 'dime.material', 'default', 'Material', ''),
('en', 'dime.material.silver', 'default', 'Silver Test1', ''),
('en', 'dime.metaldetector', 'default', 'Metal Detecting In Denmark', ''),
('en', 'dime.news', 'default', 'News', ''),
('en', 'dime.news', 'resource', 'news', ''),
('en', 'dime.period', 'default', 'Period', ''),
('en', 'dime.research', 'default', 'Research', ''),
('en', 'dime.research', 'resource', 'research', ''),
('en', 'dime.save', 'default', 'Save', ''),
('en', 'dime.schema.find', 'default', 'Find', ''),
('en', 'dime.schema.image', 'default', 'Image', ''),
('en', 'dime.schema.location', 'default', 'Location', ''),
('en', 'dime.search', 'default', 'Search', ''),
('en', 'dime.search.finds.mine', 'default', 'My Finds', ''),
('en', 'dime.supportedby', 'default', 'supported by', ''),
('en', 'dime.treasure', 'default', 'Treasure Trove', ''),
('en', 'dime.treasure', 'resource', 'treasure', ''),
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
('resource', 'translation.role.resource', 'URL Resource translation'),
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
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_element`
--

INSERT INTO `ark_view_element` (`element`, `type`, `class`, `template`, `enabled`, `deprecated`, `keyword`) VALUES
('core_file_description', 'field', '', '', 1, 0, NULL),
('core_file_id', 'field', '', '', 1, 0, NULL),
('core_file_item', 'grid', '', '', 1, 0, NULL),
('core_file_list', 'table', '', '', 1, 0, NULL),
('core_file_mediatype', 'field', '', '', 1, 0, NULL),
('core_file_status', 'field', '', '', 1, 0, NULL),
('core_file_title', 'field', '', '', 1, 0, NULL),
('core_file_type', 'field', '', '', 1, 0, NULL),
('core_file_versions', 'field', '', '', 1, 0, NULL),
('core_message_event', 'field', '', '', 1, 0, NULL),
('core_message_id', 'field', '', '', 1, 0, NULL),
('core_message_item', 'grid', '', '', 1, 0, NULL),
('core_message_list', 'table', '', '', 1, 0, NULL),
('core_message_sender', 'field', '', '', 1, 0, NULL),
('core_message_sent_at', 'field', '', '', 1, 0, NULL),
('core_message_type', 'field', '', '', 1, 0, NULL),
('core_page_content', 'field', '', '', 1, 0, 'property.content'),
('core_page_static', 'page', '', '', 1, 0, NULL),
('core_page_view', 'grid', '', '', 1, 0, NULL),
('dime_actor_fullname', 'field', '', '', 1, 0, NULL),
('dime_actor_id', 'field', '', '', 1, 0, NULL),
('dime_actor_item', 'grid', '', '', 1, 0, NULL),
('dime_actor_kommuner', 'field', '', '', 1, 0, NULL),
('dime_actor_list', 'table', '', '', 1, 0, NULL),
('dime_actor_shortname', 'field', '', '', 1, 0, NULL),
('dime_actor_type', 'field', '', '', 1, 0, NULL),
('dime_find_actions', 'widget', '', '', 1, 0, 'dime.actions'),
('dime_find_add', 'grid', '', '', 1, 0, NULL),
('dime_find_condition', 'field', '', '', 1, 0, NULL),
('dime_find_description', 'field', '', '', 1, 0, NULL),
('dime_find_details', 'grid', '', '', 1, 0, NULL),
('dime_find_edit', 'grid', '', '', 1, 0, NULL),
('dime_find_event', 'grid', '', '', 1, 0, NULL),
('dime_find_filter', 'grid', '', '', 1, 0, 'dime.find.filter'),
('dime_find_filter_kommune', 'widget', '', '', 1, 0, NULL),
('dime_find_filter_material', 'widget', '', '', 1, 0, NULL),
('dime_find_filter_period', 'widget', '', '', 1, 0, NULL),
('dime_find_filter_type', 'widget', '', '', 1, 0, NULL),
('dime_find_finddate', 'field', '', '', 1, 0, NULL),
('dime_find_finder_id', 'field', '', '', 1, 0, NULL),
('dime_find_findpoint', 'field', '', 'blocks/mappick.html.twig', 1, 0, NULL),
('dime_find_id', 'field', '', '', 1, 0, NULL),
('dime_find_image', 'field', '', 'blocks/carouselfield.html.twig', 1, 0, NULL),
('dime_find_item', 'grid', '', '', 1, 0, NULL),
('dime_find_kommune', 'field', '', '', 1, 0, NULL),
('dime_find_length', 'field', '', '', 1, 0, NULL),
('dime_find_list', 'table', '', '', 1, 0, NULL),
('dime_find_map', 'grid', '', 'blocks/map.html.twig', 1, 0, NULL),
('dime_find_material', 'field', '', '', 1, 0, NULL),
('dime_find_museum', 'field', '', '', 1, 0, NULL),
('dime_find_period_end', 'field', '', '', 1, 0, NULL),
('dime_find_period_start', 'field', '', '', 1, 0, NULL),
('dime_find_process', 'grid', '', '', 1, 0, NULL),
('dime_find_registered_id', 'field', '', '', 1, 0, NULL),
('dime_find_search', 'grid', '', '', 1, 0, NULL),
('dime_find_secondary', 'field', '', '', 1, 0, NULL),
('dime_find_subtype', 'field', '', '', 1, 0, NULL),
('dime_find_treasure', 'field', '', '', 1, 0, NULL),
('dime_find_type', 'field', '', '', 1, 0, NULL),
('dime_find_weight', 'field', '', '', 1, 0, NULL),
('dime_front_page', 'grid', '', 'layouts/front.html.twig', 1, 0, NULL),
('dime_home_action', 'grid', '', 'blocks/homeaction.html.twig', 1, 0, NULL),
('dime_home_page', 'grid', '', '', 1, 0, NULL),
('dime_locality_id', 'field', '', '', 1, 0, NULL),
('dime_locality_item', 'grid', '', '', 1, 0, NULL),
('dime_locality_list', 'table', '', '', 1, 0, NULL),
('dime_locality_type', 'field', '', '', 1, 0, NULL),
('dime_message_page', 'grid', '', '', 1, 0, NULL),
('dime_nav_add', 'nav', '', '', 1, 0, NULL),
('dime_nav_add_find', 'nav', '', '', 1, 0, NULL),
('dime_nav_add_locality', 'nav', '', '', 1, 0, NULL),
('dime_nav_list', 'nav', '', '', 1, 0, NULL),
('dime_nav_list_find', 'nav', '', '', 1, 0, NULL),
('dime_nav_list_locality', 'nav', '', '', 1, 0, NULL),
('dime_nav_sidebar', 'nav', '', '', 1, 0, NULL),
('dime_page_find', 'page', '', '', 1, 0, NULL),
('dime_page_find_search', 'page', '', '', 1, 0, NULL),
('dime_page_locality', 'page', '', '', 1, 0, NULL),
('dime_page_locality_list', 'page', '', '', 1, 0, NULL),
('dime_page_messages', 'page', '', '', 1, 0, NULL),
('dime_save', 'widget', '', '', 1, 0, 'dime.save'),
('dime_search', 'widget', '', '', 1, 0, 'dime.search');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_field`
--

CREATE TABLE `ark_view_field` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` tinyint(1) NOT NULL DEFAULT '1',
  `value` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `parameter` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_field`
--

INSERT INTO `ark_view_field` (`element`, `schma`, `item_type`, `attribute`, `label`, `value`, `parameter`, `format`, `form_type_class`, `form_options`) VALUES
('core_file_description', 'core.file', 'file', 'description', 1, 'active', NULL, NULL, NULL, ''),
('core_file_id', 'core.file', 'file', 'id', 1, 'readonly', NULL, NULL, NULL, ''),
('core_file_mediatype', 'core.file', 'file', 'mediatype', 1, 'active', NULL, NULL, NULL, ''),
('core_file_status', 'core.file', 'file', 'status', 1, 'active', NULL, NULL, NULL, ''),
('core_file_title', 'core.file', 'file', 'title', 1, 'active', NULL, NULL, NULL, ''),
('core_file_type', 'core.file', 'file', 'type', 1, 'active', NULL, NULL, NULL, ''),
('core_file_versions', 'core.file', 'file', 'versions', 1, 'active', NULL, NULL, NULL, ''),
('core_message_event', 'core.message', 'notification', 'event', 1, 'active', NULL, NULL, NULL, ''),
('core_message_id', 'core.message', 'message', 'id', 1, 'active', NULL, NULL, NULL, ''),
('core_message_sender', 'core.message', 'message', 'sender', 1, 'active', NULL, NULL, NULL, ''),
('core_message_sent_at', 'core.message', 'message', 'sent', 1, 'active', NULL, NULL, NULL, ''),
('core_message_type', 'core.message', 'message', 'type', 1, 'active', NULL, NULL, NULL, ''),
('core_page_content', 'core.page', 'page', 'content', 1, 'active', NULL, NULL, NULL, ''),
('dime_actor_fullname', 'core.actor', 'actor', 'fullname', 1, 'active', NULL, NULL, NULL, ''),
('dime_actor_id', 'core.actor', 'actor', 'id', 1, 'active', NULL, NULL, NULL, ''),
('dime_actor_kommuner', 'core.actor', 'museum', 'kommuner', 1, 'active', NULL, NULL, NULL, ''),
('dime_actor_shortname', 'core.actor', 'actor', 'shortname', 1, 'active', NULL, NULL, NULL, ''),
('dime_actor_type', 'core.actor', 'actor', 'type', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_condition', 'dime.find', 'find', 'condition', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_description', 'dime.find', 'find', 'description', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_finddate', 'dime.find', 'find', 'finddate', 1, 'active', NULL, NULL, NULL, '{\"widget\": \"picker\"}'),
('dime_find_finder_id', 'dime.find', 'find', 'finder_id', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_findpoint', 'dime.find', 'find', 'findpoint', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_id', 'dime.find', 'find', 'id', 1, 'readonly', NULL, NULL, NULL, ''),
('dime_find_image', 'dime.find', 'find', 'image', 1, 'active', NULL, NULL, 'ARK\\Form\\Type\\CarouselType', ''),
('dime_find_kommune', 'dime.find', 'find', 'kommune', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_length', 'dime.find', 'find', 'length', 1, 'active', 'hidden', NULL, NULL, ''),
('dime_find_material', 'dime.find', 'find', 'material', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_museum', 'dime.find', 'find', 'museum', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_period_end', 'dime.find', 'find', 'period_end', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_period_start', 'dime.find', 'find', 'period_start', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_registered_id', 'dime.find', 'find', 'registered_id', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_secondary', 'dime.find', 'find', 'secondary', 1, 'active', NULL, NULL, NULL, '{\"multiple\":true, \"expanded\": \"true\"}'),
('dime_find_subtype', 'dime.find', 'find', 'subtype', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_treasure', 'dime.find', 'find', 'treasure', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_type', 'dime.find', 'find', 'type', 1, 'active', NULL, NULL, NULL, ''),
('dime_find_weight', 'dime.find', 'find', 'weight', 1, 'active', 'hidden', NULL, NULL, ''),
('dime_locality_id', 'dime.locality', 'locality', 'id', 1, 'readonliy', NULL, NULL, NULL, ''),
('dime_locality_type', 'dime.locality', 'locality', 'type', 1, 'active', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_grid`
--

CREATE TABLE `ark_view_grid` (
  `layout` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `row` int(11) NOT NULL,
  `col` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` tinyint(1) DEFAULT NULL,
  `value` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameter` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_view_grid`
--

INSERT INTO `ark_view_grid` (`layout`, `row`, `col`, `seq`, `item_type`, `element`, `map`, `label`, `value`, `parameter`, `format`, `required`, `enabled`, `deprecated`, `form_options`) VALUES
('core_file_item', 0, 0, 0, '', 'core_file_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 0, 1, '', 'core_file_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 0, 2, '', 'core_file_mediatype', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 0, 3, '', 'core_file_title', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 0, 4, '', 'core_file_status', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 0, 5, '', 'core_file_description', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_item', 0, 1, 1, '', 'dime_save', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_list', 0, 0, 0, '', 'core_file_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_file_list', 0, 0, 1, '', 'core_file_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('core_message_item', 0, 0, 0, '', 'core_message_type', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_item', 0, 0, 1, '', 'core_message_sender', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_item', 0, 0, 2, '', 'core_message_sent_at', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_item', 0, 0, 3, '', 'core_message_event', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_list', 0, 0, 0, '', 'core_message_type', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_list', 0, 0, 1, '', 'core_message_sender', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_list', 0, 0, 2, '', 'core_message_sent_at', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_message_list', 0, 0, 3, '', 'core_message_event', NULL, NULL, 'static', NULL, NULL, NULL, 1, 0, NULL),
('core_page_view', 0, 0, 0, '', 'core_page_content', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_item', 0, 0, 0, '', 'dime_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_item', 0, 0, 1, '', 'dime_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_item', 0, 0, 2, '', 'dime_actor_shortname', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_item', 0, 0, 3, '', 'dime_actor_kommuner', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_list', 0, 0, 0, '', 'dime_actor_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_list', 0, 0, 1, '', 'dime_actor_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_actor_list', 0, 0, 2, '', 'dime_actor_fullname', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_add', 0, 0, 0, '', 'dime_find_event', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_add', 0, 1, 0, '', 'dime_find_details', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 0, '', 'dime_find_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 2, '', 'dime_find_period_start', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 4, '', 'dime_find_material', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 5, '', 'dime_find_secondary', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 6, '', 'dime_find_condition', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 7, '', 'dime_find_weight', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 8, '', 'dime_find_length', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_details', 0, 0, 9, '', 'dime_find_description', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_edit', 0, 0, 0, '', 'dime_find_event', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_edit', 0, 1, 0, '', 'dime_find_details', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 0, '', 'dime_find_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 2, '', 'dime_find_finder_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 3, '', 'dime_find_finddate', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 4, '', 'dime_find_findpoint', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 6, '', 'dime_find_kommune', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 7, '', 'dime_find_museum', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_event', 0, 0, 8, '', 'dime_find_treasure', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_filter', 0, 0, 0, '', 'dime_find_filter_kommune', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_filter', 0, 1, 0, '', 'dime_find_filter_type', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_filter', 0, 2, 0, '', 'dime_find_filter_period', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_filter', 0, 3, 0, '', 'dime_find_filter_material', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_filter', 0, 4, 0, '', 'dime_search', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_item', 0, 0, 0, '', 'dime_find_event', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_item', 0, 0, 1, '', 'dime_find_image', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_item', 0, 1, 0, '', 'dime_find_details', NULL, 0, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_item', 0, 1, 1, '', 'dime_find_process', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_list', 0, 0, 0, '', 'dime_find_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_list', 0, 0, 1, '', 'dime_find_finder_id', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_list', 0, 0, 2, '', 'dime_find_type', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_list', 0, 0, 4, '', 'dime_find_material', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_map', 0, 0, 0, '', 'dime_find_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_map', 0, 0, 1, '', 'dime_find_findpoint', NULL, NULL, 'readonly', NULL, NULL, NULL, 1, 0, NULL),
('dime_find_process', 0, 0, 0, '', 'dime_find_actions', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_process', 0, 0, 1, '', 'dime_save', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_search', 0, 0, 0, '', 'dime_find_filter', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_search', 1, 0, 0, '', 'dime_find_list', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_find_search', 1, 1, 0, '', 'dime_find_map', 'dime_map_public', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_front_page', 0, 0, 0, '', 'dime_find_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_front_page', 0, 0, 1, '', 'dime_find_finder_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_front_page', 0, 0, 2, '', 'dime_find_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_front_page', 0, 0, 4, '', 'dime_find_material', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_home_page', 0, 0, 0, '', 'dime_home_action', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_home_page', 1, 0, 0, '', 'dime_find_list', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_home_page', 1, 1, 0, '', 'dime_find_map', 'dime_map_user', NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_locality_item', 0, 0, 0, '', 'dime_locality_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_locality_item', 0, 0, 1, '', 'dime_locality_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_locality_item', 0, 1, 1, '', 'dime_save', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_locality_list', 0, 0, 0, '', 'dime_locality_id', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_locality_list', 0, 0, 1, '', 'dime_locality_type', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_message_page', 0, 0, 0, '', 'core_message_list', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
('dime_message_page', 0, 1, 0, '', 'core_message_item', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_layout`
--

CREATE TABLE `ark_view_layout` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_mode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_layout`
--

INSERT INTO `ark_view_layout` (`element`, `schma`, `item_type`, `form_mode`) VALUES
('core_file_item', NULL, NULL, 'edit'),
('core_file_list', NULL, NULL, NULL),
('core_message_item', 'core.message', NULL, 'view'),
('core_message_list', NULL, NULL, 'view'),
('core_page_view', NULL, NULL, NULL),
('dime_actor_item', NULL, NULL, 'edit'),
('dime_actor_list', NULL, NULL, 'view'),
('dime_find_add', NULL, NULL, NULL),
('dime_find_details', NULL, NULL, NULL),
('dime_find_edit', NULL, NULL, NULL),
('dime_find_event', NULL, NULL, NULL),
('dime_find_filter', NULL, NULL, 'edit'),
('dime_find_item', NULL, NULL, 'edit'),
('dime_find_list', NULL, NULL, 'view'),
('dime_find_map', NULL, NULL, NULL),
('dime_find_process', NULL, NULL, NULL),
('dime_find_search', NULL, NULL, NULL),
('dime_front_page', 'dime.find', NULL, NULL),
('dime_home_action', NULL, NULL, NULL),
('dime_home_page', NULL, NULL, NULL),
('dime_locality_item', NULL, NULL, 'edit'),
('dime_locality_list', NULL, NULL, 'view'),
('dime_message_page', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_nav`
--

CREATE TABLE `ark_view_nav` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seq` int(11) NOT NULL DEFAULT '0',
  `level` int(11) DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(2038) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seperator` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_nav`
--

INSERT INTO `ark_view_nav` (`element`, `parent`, `seq`, `level`, `icon`, `route`, `uri`, `seperator`, `enabled`) VALUES
('dime_nav_add', 'dime_nav_sidebar', 0, 2, NULL, NULL, NULL, 0, 1),
('dime_nav_add_find', 'dime_nav_add', 0, 3, NULL, 'find.add', NULL, 0, 1),
('dime_nav_add_locality', 'dime_nav_add', 1, 3, NULL, 'locality.add', NULL, 0, 1),
('dime_nav_list', 'dime_nav_sidebar', 1, 2, NULL, NULL, NULL, 0, 1),
('dime_nav_list_find', 'dime_nav_list', 0, 3, NULL, 'find.list', NULL, 0, 1),
('dime_nav_list_locality', 'dime_nav_list', 1, 3, NULL, 'locality.list', NULL, 0, 1),
('dime_nav_sidebar', NULL, 0, 1, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_page`
--

CREATE TABLE `ark_view_page` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'view',
  `content` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `navbar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sidebar` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_page`
--

INSERT INTO `ark_view_page` (`element`, `mode`, `content`, `footer`, `navbar`, `sidebar`, `template`) VALUES
('dime_page_find', 'edit', 'dime_find_item', NULL, NULL, 'dime_nav_sidebar', NULL),
('dime_page_find_search', 'view', 'dime_find_search', NULL, NULL, 'dime_nav_sidebar', NULL),
('dime_page_locality', 'edit', 'dime_locality_item', NULL, NULL, 'dime_nav_sidebar', NULL),
('dime_page_locality_list', 'view', 'dime_locality_list', NULL, NULL, 'dime_nav_sidebar', NULL),
('dime_page_messages', 'view', 'dime_message_page', NULL, NULL, 'dime_nav_sidebar', NULL);

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

--
-- Dumping data for table `ark_view_tree`
--

INSERT INTO `ark_view_tree` (`id`, `ancestor`, `descendant`, `depth`) VALUES
(1, 'dime_nav_sidebar', 'dime_nav_sidebar', 0),
(2, 'dime_nav_add', 'dime_nav_add', 0),
(3, 'dime_nav_sidebar', 'dime_nav_add', 1),
(4, 'dime_nav_list', 'dime_nav_list', 0),
(5, 'dime_nav_sidebar', 'dime_nav_list', 1),
(6, 'dime_nav_add_find', 'dime_nav_add_find', 0),
(7, 'dime_nav_add', 'dime_nav_add_find', 1),
(8, 'dime_nav_sidebar', 'dime_nav_add_find', 2),
(9, 'dime_nav_add_locality', 'dime_nav_add_locality', 0),
(10, 'dime_nav_add', 'dime_nav_add_locality', 1),
(11, 'dime_nav_sidebar', 'dime_nav_add_locality', 2),
(12, 'dime_nav_list_locality', 'dime_nav_list_locality', 0),
(13, 'dime_nav_list', 'dime_nav_list_locality', 1),
(14, 'dime_nav_sidebar', 'dime_nav_list_locality', 2),
(15, 'dime_nav_list_find', 'dime_nav_list_find', 0),
(16, 'dime_nav_list', 'dime_nav_list_find', 1),
(17, 'dime_nav_sidebar', 'dime_nav_list_find', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_type`
--

CREATE TABLE `ark_view_type` (
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` tinyint(1) NOT NULL DEFAULT '0',
  `form_type_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_view_type`
--

INSERT INTO `ark_view_type` (`type`, `class`, `layout`, `form_type_class`, `template`, `keyword`) VALUES
('field', 'ARK\\View\\Field', 0, 'ARK\\Form\\Type\\PropertyType', 'layouts/field.html.twig', ''),
('grid', 'ARK\\View\\Grid', 1, 'ARK\\Form\\Type\\SimpleFormType', 'layouts/grid.html.twig', ''),
('nav', 'ARK\\View\\Nav', 0, NULL, 'blocks/nav.html.twig', ''),
('page', 'ARK\\View\\Page', 0, NULL, 'pages/page.html.twig', ''),
('tabbed', 'ARK\\View\\Tabbed', 1, 'ARK\\Form\\Type\\SimpleFormType', 'layouts/tabbed.html.twig', ''),
('table', 'ARK\\View\\Table', 1, 'ARK\\Form\\Type\\SimpleFormType', 'layouts/table.html.twig', ''),
('widget', 'ARK\\View\\Widget', 1, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', 'layouts/field.html.twig', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_widget`
--

CREATE TABLE `ark_view_widget` (
  `element` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` tinyint(1) NOT NULL DEFAULT '1',
  `vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_type_class` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_options` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ark_view_widget`
--

INSERT INTO `ark_view_widget` (`element`, `label`, `vocabulary`, `form_type_class`, `form_options`) VALUES
('dime_find_actions', 1, NULL, 'ARK\\Form\\Type\\TermChoiceType', ''),
('dime_find_filter_kommune', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', '{\"vocabulary\": \"dime.denmark.kommune\", \"multiple\":true, \"placeholder\": \"dime.filter.bycommune\"}'),
('dime_find_filter_material', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', '{\"vocabulary\": \"dime.material\", \"multiple\":true, \"placeholder\": \"dime.filter.bymaterial\"}'),
('dime_find_filter_period', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', '{\"vocabulary\": \"dime.denmark.kommune\", \"multiple\":true, \"placeholder\": \"dime.filter.byperiod\"}'),
('dime_find_filter_type', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType', '{\"vocabulary\": \"dime.period\", \"multiple\":true, \"placeholder\": \"dime.filter.bytype\"}'),
('dime_save', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', ''),
('dime_search', 1, NULL, 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', '');

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
('core.actor.event', 'list', 'ARK Core', 1, 0, 1, 0, 'core.actor.event', 'Actor Event'),
('core.actor.type', 'list', 'ARK Core', 1, 0, 1, 0, 'core.actor.type', 'Actor Type'),
('core.file.status', 'list', 'ARK Core', 1, 0, 1, 0, 'core.file.status', 'File Status'),
('core.file.type', 'list', 'ARK Core', 1, 0, 1, 0, 'core.file.type', 'File Type'),
('core.item.status', 'list', 'ARK Core', 1, 0, 1, 0, 'core.item.status', 'Item Status'),
('core.message.status', 'list', 'ARK Core', 1, 0, 1, 0, 'core.message.status', 'Message Status'),
('core.message.type', 'list', 'ARK Core', 1, 0, 1, 0, 'core.message.type', 'Message Type'),
('country', 'list', 'ISO3166', 1, 0, 1, 0, 'vocabulary.country', 'ISO Country Codes'),
('dime.denmark.admin', 'taxonomy', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.denmark.admin', 'Danish NUTS and LAU Administrative Unit Hierarchy'),
('dime.denmark.kommune', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.denmark.kommune', 'Danish LAU-1 Kommune (Municipality) List'),
('dime.denmark.region', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.denmark.region', 'Danish NUTS2 Region List'),
('dime.find.condition', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.find.condition', 'DIME Find Condition'),
('dime.find.custody', 'list', 'DIME', 1, 0, 1, 0, 'dime.find.custody', 'DIME Find Custody'),
('dime.find.event', 'list', 'DIME', 1, 0, 1, 0, 'dime.find.event', 'DIME Find Event'),
('dime.find.process', 'list', 'DIME', 1, 0, 1, 0, 'dime.find.process', 'DIME Find Process'),
('dime.find.secondary', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.find.secondary', 'DIME Secondary Materials List'),
('dime.find.type', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.type', 'DIME Find Type'),
('dime.find.visibility', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.find.visibility', 'DIME Find Visibility'),
('dime.material', 'list', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.material', 'DIME Material List'),
('dime.period', 'taxonomy', 'DIME', 1, 0, 1, 0, 'vocabulary.dime.period', 'DIME Period Taxonomy'),
('dime.treasure', 'list', 'DIME', 1, 1, 1, 0, 'vocabulary.dime.treasure', 'DIME Treasure Status'),
('distance', 'list', 'SI', 1, 0, 1, 0, 'vocabulary.distance', 'SI Distance Units'),
('language', 'list', 'ISO639', 1, 0, 1, 0, 'vocabulary.language', 'ISO Language Codes'),
('mass', 'list', 'SI', 1, 0, 1, 0, 'vocabulary.mass', 'SI Mass Units'),
('mediatype', 'list', 'IANA', 1, 0, 1, 0, 'vocabulary.mediatype', 'IANA Mediatypes as defined by RFC'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_vocabulary_parameter`
--

INSERT INTO `ark_vocabulary_parameter` (`concept`, `term`, `name`, `type`, `value`) VALUES
('core.actor.type', 'institution', 'classname', 'string', 'ARK\\Actor\\Institution'),
('core.actor.type', 'museum', 'classname', 'string', 'ARK\\Actor\\Museum'),
('core.actor.type', 'person', 'classname', 'string', 'ARK\\Actor\\Person'),
('core.file.type', 'audio', 'classname', 'string', 'ARK\\File\\Audio'),
('core.file.type', 'document', 'classname', 'string', 'ARK\\File\\Document'),
('core.file.type', 'image', 'classname', 'string', 'ARK\\File\\Image'),
('core.file.type', 'other', 'classname', 'string', 'ARK\\File\\File'),
('core.file.type', 'text', 'classname', 'string', 'ARK\\File\\Text'),
('core.file.type', 'video', 'classname', 'string', 'ARK\\File\\Video'),
('core.message.type', 'mail', 'classname', 'string', 'ARK\\Message\\Mail'),
('core.message.type', 'notification', 'classname', 'string', 'ARK\\Message\\Notification'),
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
('core.item.status', 'void', 'core.item.status', 'registered', 'transition', 'register', 0),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK01', 'broader', '', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK02', 'broader', '', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK03', 'broader', '', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK04', 'broader', '', 2),
('dime.denmark.admin', 'DK', 'dime.denmark.region', 'DK05', 'broader', '', 2),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '101', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '147', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '151', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '153', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '155', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '157', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '159', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '161', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '163', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '165', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '167', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '169', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '173', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '175', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '183', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '185', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '187', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '190', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '201', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '210', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '217', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '219', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '223', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '230', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '240', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '250', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '260', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '270', 'broader', '', 3),
('dime.denmark.region', 'DK01', 'dime.denmark.kommune', '400', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '253', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '259', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '265', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '269', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '306', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '316', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '320', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '326', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '329', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '330', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '336', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '340', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '350', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '360', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '370', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '376', 'broader', '', 3),
('dime.denmark.region', 'DK02', 'dime.denmark.kommune', '390', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '410', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '420', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '430', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '440', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '450', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '461', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '479', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '480', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '482', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '492', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '510', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '530', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '540', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '550', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '561', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '563', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '573', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '575', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '580', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '607', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '621', 'broader', '', 3),
('dime.denmark.region', 'DK03', 'dime.denmark.kommune', '630', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '615', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '657', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '661', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '665', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '671', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '706', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '707', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '710', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '727', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '730', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '740', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '741', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '746', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '751', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '756', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '760', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '766', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '779', 'broader', '', 3),
('dime.denmark.region', 'DK04', 'dime.denmark.kommune', '791', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '773', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '787', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '810', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '813', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '820', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '825', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '840', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '846', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '849', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '851', 'broader', '', 3),
('dime.denmark.region', 'DK05', 'dime.denmark.kommune', '860', 'broader', '', 3),
('dime.find.custody', 'destroyed', 'dime.find.custody', 'held', 'transition', 'recover', 0),
('dime.find.custody', 'discarded', 'dime.find.custody', 'held', 'transition', 'recover', 0),
('dime.find.custody', 'held', 'dime.find.custody', 'destroyed', 'transition', 'destroy', 0),
('dime.find.custody', 'held', 'dime.find.custody', 'discarded', 'transition', 'discard', 0),
('dime.find.custody', 'held', 'dime.find.custody', 'lost', 'transition', 'lose', 0),
('dime.find.custody', 'held', 'dime.find.custody', 'requested', 'transition', 'request', 0),
('dime.find.custody', 'held', 'dime.find.custody', 'sent', 'transition', 'send', 0),
('dime.find.custody', 'lost', 'dime.find.custody', 'held', 'transition', 'recover', 0),
('dime.find.custody', 'requested', 'dime.find.custody', 'held', 'transition', 'decline', 0),
('dime.find.custody', 'requested', 'dime.find.custody', 'sent', 'transition', 'send', 0),
('dime.find.custody', 'sent', 'dime.find.custody', 'held', 'transition', 'receive', 0),
('dime.find.process', 'assessed', 'dime.find.process', 'accessioned', 'transition', 'accession', 0),
('dime.find.process', 'assessed', 'dime.find.process', 'released', 'transition', 'release', 0),
('dime.find.process', 'evaluated', 'dime.find.process', 'accessioned', 'transition', 'accession', 0),
('dime.find.process', 'evaluated', 'dime.find.process', 'assessed', 'transition', 'assess', 0),
('dime.find.process', 'evaluated', 'dime.find.process', 'released', 'transition', 'release', 0),
('dime.find.process', 'recorded', 'dime.find.process', 'deleted', 'transition', 'delete', 0),
('dime.find.process', 'recorded', 'dime.find.process', 'inactive', 'transition', 'report', 0),
('dime.find.process', 'recorded', 'dime.find.process', 'reported', 'transition', 'report', 0),
('dime.find.process', 'rejected', 'dime.find.process', 'deleted', 'transition', 'delete', 0),
('dime.find.process', 'reported', 'dime.find.process', 'deleted', 'transition', 'delete', 0),
('dime.find.process', 'reported', 'dime.find.process', 'rejected', 'transition', 'reject', 0),
('dime.find.process', 'reported', 'dime.find.process', 'validated', 'transition', 'validate', 0),
('dime.find.process', 'validated', 'dime.find.process', 'evaluated', 'transition', 'evaluate', 0),
('dime.period', 'AXXX', 'dime.period', 'AMXX', 'broader', '', 2),
('dime.period', 'AXXX', 'dime.period', 'AXXX', 'broader', '', 1),
('dime.period', 'AXXX', 'dime.period', 'AYXX', 'broader', '', 2),
('dime.period', 'AXXX', 'dime.period', 'PALEO', 'broader', '', 2),
('dime.period', 'BÆXX', 'dime.period', 'BÆX1', 'broader', '', 3),
('dime.period', 'BÆXX', 'dime.period', 'BÆX2', 'broader', '', 3),
('dime.period', 'BÆXX', 'dime.period', 'BÆX3', 'broader', '', 3),
('dime.period', 'BXXX', 'dime.period', 'BÆXX', 'broader', '', 2),
('dime.period', 'BXXX', 'dime.period', 'BXXX', 'broader', '', 1),
('dime.period', 'BXXX', 'dime.period', 'BYXX', 'broader', '', 2),
('dime.period', 'BYXX', 'dime.period', 'BYX4', 'broader', '', 3),
('dime.period', 'BYXX', 'dime.period', 'BYX5', 'broader', '', 3),
('dime.period', 'BYXX', 'dime.period', 'BYX6', 'broader', '', 3),
('dime.period', 'CÆFX', 'dime.period', 'CÆFÆ', 'broader', '', 4),
('dime.period', 'CÆFX', 'dime.period', 'CÆFM', 'broader', '', 4),
('dime.period', 'CÆFX', 'dime.period', 'CÆFY', 'broader', '', 4),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRA', 'broader', '', 5),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRB', 'broader', '', 5),
('dime.period', 'CÆRX', 'dime.period', 'CÆRÆ', 'broader', '', 4),
('dime.period', 'CÆRX', 'dime.period', 'CÆRY', 'broader', '', 4),
('dime.period', 'CÆRY', 'dime.period', 'CÆRC', 'broader', '', 5),
('dime.period', 'CÆRY', 'dime.period', 'CÆRD', 'broader', '', 5),
('dime.period', 'CÆRY', 'dime.period', 'CÆRE', 'broader', '', 5),
('dime.period', 'CÆXX', 'dime.period', 'CÆFX', 'broader', '', 3),
('dime.period', 'CÆXX', 'dime.period', 'CÆRX', 'broader', '', 3),
('dime.period', 'CXXX', 'dime.period', 'CÆXX', 'broader', '', 2),
('dime.period', 'CXXX', 'dime.period', 'CXXX', 'broader', '', 1),
('dime.period', 'CXXX', 'dime.period', 'CYVX', 'broader', '', 2),
('dime.period', 'CXXX', 'dime.period', 'CYXX', 'broader', '', 2),
('dime.period', 'CYGX', 'dime.period', 'CYGÆ', 'broader', '', 4),
('dime.period', 'CYGX', 'dime.period', 'CYGY', 'broader', '', 4),
('dime.period', 'CYVX', 'dime.period', 'CYVÆ', 'broader', '', 4),
('dime.period', 'CYVX', 'dime.period', 'CYVY', 'broader', '', 4),
('dime.period', 'CYXX', 'dime.period', 'CYGX', 'broader', '', 3),
('dime.period', 'DXXX', 'dime.period', 'DÆXX', 'broader', '', 3),
('dime.period', 'DXXX', 'dime.period', 'DYX3', 'broader', '', 3),
('dime.period', 'DXXX', 'dime.period', 'DYX4', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FÆXX', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FMIN', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FMV1', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FMV2', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FMVM', 'broader', '', 3),
('dime.period', 'FXXX', 'dime.period', 'FYXX', 'broader', '', 3),
('dime.period', 'HXXX', 'dime.period', 'DXXX', 'broader', '', 2),
('dime.period', 'HXXX', 'dime.period', 'EXXX', 'broader', '', 2),
('dime.period', 'HXXX', 'dime.period', 'FXXX', 'broader', '', 2),
('dime.period', 'HXXX', 'dime.period', 'HXXX', 'broader', '', 1),
('dime.period', 'XXXX', 'dime.period', 'XXXX', 'broader', '', 1),
('dime.treasure', 'appraisal', 'dime.treasure', 'not', 'transition', 'assess', 0),
('dime.treasure', 'appraisal', 'dime.treasure', 'treasure', 'transition', 'assess', 0),
('dime.treasure', 'pending', 'dime.treasure', 'appraisal', 'transition', 'evaluate', 0),
('dime.treasure', 'pending', 'dime.treasure', 'not', 'transition', 'evaluate', 0);

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
('core.actor.event', 'activated', '', 0, 0, 0, 'core.actor.event.activated', ''),
('core.actor.event', 'approved', '', 0, 0, 0, 'core.actor.event.approved', ''),
('core.actor.event', 'cancelled', '', 0, 0, 0, 'core.actor.event.cancelled', ''),
('core.actor.event', 'registered', '', 0, 0, 0, 'core.actor.event.registered', ''),
('core.actor.event', 'restored', '', 0, 0, 0, 'core.actor.event.restored', ''),
('core.actor.event', 'suspended', '', 0, 0, 0, 'core.actor.event.suspended', ''),
('core.actor.type', 'institution', '', 0, 1, 0, 'dime.actor.type.institution', ''),
('core.actor.type', 'museum', '', 0, 1, 0, 'dime.actor.type.museum', ''),
('core.actor.type', 'person', '', 0, 1, 0, 'dime.actor.type.person', ''),
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
('core.message.status', 'draft', '', 0, 1, 0, 'core.message.status.draft', ''),
('core.message.status', 'read', '', 0, 1, 0, 'core.message.status.read', ''),
('core.message.status', 'sent', '', 0, 1, 0, 'core.message.status.sent', ''),
('core.message.type', 'mail', '', 0, 1, 0, 'core.message.type.mail', ''),
('core.message.type', 'notification', '', 0, 1, 0, 'core.message.type.notification', ''),
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
('dime.denmark.admin', 'DK', 'denmark', 0, 1, 0, 'dime.denmark.admin.denmark', ''),
('dime.denmark.kommune', '101', 'kobenhavn', 0, 1, 0, 'dime.kommune.kobenhavn', ''),
('dime.denmark.kommune', '147', 'frederiksbeg', 0, 1, 0, 'dime.kommune.frederiksbeg', ''),
('dime.denmark.kommune', '151', 'ballerup', 0, 1, 0, 'dime.kommune.ballerup', ''),
('dime.denmark.kommune', '153', 'brondby', 0, 1, 0, 'dime.kommune.brondby', ''),
('dime.denmark.kommune', '155', 'dragor', 0, 1, 0, 'dime.kommune.dragor', ''),
('dime.denmark.kommune', '157', 'gentofte', 0, 1, 0, 'dime.kommune.gentofte', ''),
('dime.denmark.kommune', '159', 'gladsaxe', 0, 1, 0, 'dime.kommune.gladsaxe', ''),
('dime.denmark.kommune', '161', 'glostrup', 0, 1, 0, 'dime.kommune.glostrup', ''),
('dime.denmark.kommune', '163', 'herlev', 0, 1, 0, 'dime.kommune.herlev', ''),
('dime.denmark.kommune', '165', 'albertslund', 0, 1, 0, 'dime.kommune.albertslund', ''),
('dime.denmark.kommune', '167', 'hvidovre', 0, 1, 0, 'dime.kommune.hvidovre', ''),
('dime.denmark.kommune', '169', 'hojetaastrup', 0, 1, 0, 'dime.kommune.hojetaastrup', ''),
('dime.denmark.kommune', '173', 'lyngbytaarbaek', 0, 1, 0, 'dime.kommune.lyngbytaarbaek', ''),
('dime.denmark.kommune', '175', 'rodovre', 0, 1, 0, 'dime.kommune.rodovre', ''),
('dime.denmark.kommune', '183', 'ishoj', 0, 1, 0, 'dime.kommune.ishoj', ''),
('dime.denmark.kommune', '185', 'tarnby', 0, 1, 0, 'dime.kommune.tarnby', ''),
('dime.denmark.kommune', '187', 'vallensbaek', 0, 1, 0, 'dime.kommune.vallensbaek', ''),
('dime.denmark.kommune', '190', 'fureso', 0, 1, 0, 'dime.kommune.fureso', ''),
('dime.denmark.kommune', '201', 'allerod', 0, 1, 0, 'dime.kommune.allerod', ''),
('dime.denmark.kommune', '210', 'fredensborg', 0, 1, 0, 'dime.kommune.fredensborg', ''),
('dime.denmark.kommune', '217', 'helsingor', 0, 1, 0, 'dime.kommune.helsingor', ''),
('dime.denmark.kommune', '219', 'hillerod', 0, 1, 0, 'dime.kommune.hillerod', ''),
('dime.denmark.kommune', '223', 'horsholm', 0, 1, 0, 'dime.kommune.horsholm', ''),
('dime.denmark.kommune', '230', 'rudersdal', 0, 1, 0, 'dime.kommune.rudersdal', ''),
('dime.denmark.kommune', '240', 'egedal', 0, 1, 0, 'dime.kommune.egedal', ''),
('dime.denmark.kommune', '250', 'frederikssund', 0, 1, 0, 'dime.kommune.frederikssund', ''),
('dime.denmark.kommune', '253', 'greve', 0, 1, 0, 'dime.kommune.greve', ''),
('dime.denmark.kommune', '259', 'koge', 0, 1, 0, 'dime.kommune.koge', ''),
('dime.denmark.kommune', '260', 'halsnaes', 0, 1, 0, 'dime.kommune.halsnaes', ''),
('dime.denmark.kommune', '265', 'roskilde', 0, 1, 0, 'dime.kommune.roskilde', ''),
('dime.denmark.kommune', '269', 'solrod', 0, 1, 0, 'dime.kommune.solrod', ''),
('dime.denmark.kommune', '270', 'gribskov', 0, 1, 0, 'dime.kommune.gribskov', ''),
('dime.denmark.kommune', '306', 'odsherred', 0, 1, 0, 'dime.kommune.odsherred', ''),
('dime.denmark.kommune', '316', 'holbaek', 0, 1, 0, 'dime.kommune.holbaek', ''),
('dime.denmark.kommune', '320', 'faxe', 0, 1, 0, 'dime.kommune.faxe', ''),
('dime.denmark.kommune', '326', 'kalundborg', 0, 1, 0, 'dime.kommune.kalundborg', ''),
('dime.denmark.kommune', '329', 'ringsted', 0, 1, 0, 'dime.kommune.ringsted', ''),
('dime.denmark.kommune', '330', 'slagelse', 0, 1, 0, 'dime.kommune.slagelse', ''),
('dime.denmark.kommune', '336', 'stevns', 0, 1, 0, 'dime.kommune.stevns', ''),
('dime.denmark.kommune', '340', 'soro', 0, 1, 0, 'dime.kommune.soro', ''),
('dime.denmark.kommune', '350', 'lejre', 0, 1, 0, 'dime.kommune.lejre', ''),
('dime.denmark.kommune', '360', 'lolland', 0, 1, 0, 'dime.kommune.lolland', ''),
('dime.denmark.kommune', '370', 'naestved', 0, 1, 0, 'dime.kommune.naestved', ''),
('dime.denmark.kommune', '376', 'guldborgsund', 0, 1, 0, 'dime.kommune.guldborgsund', ''),
('dime.denmark.kommune', '390', 'vordingborg', 0, 1, 0, 'dime.kommune.vordingborg', ''),
('dime.denmark.kommune', '400', 'bornholm', 0, 1, 0, 'dime.kommune.bornholm', ''),
('dime.denmark.kommune', '410', 'middelfart', 0, 1, 0, 'dime.kommune.middelfart', ''),
('dime.denmark.kommune', '420', 'assens', 0, 1, 0, 'dime.kommune.assens', ''),
('dime.denmark.kommune', '430', 'faaborgmidtfyn', 0, 1, 0, 'dime.kommune.faaborgmidtfyn', ''),
('dime.denmark.kommune', '440', 'kerteminde', 0, 1, 0, 'dime.kommune.kerteminde', ''),
('dime.denmark.kommune', '450', 'nyborg', 0, 1, 0, 'dime.kommune.nyborg', ''),
('dime.denmark.kommune', '461', 'odense', 0, 1, 0, 'dime.kommune.odense', ''),
('dime.denmark.kommune', '479', 'svendborg', 0, 1, 0, 'dime.kommune.svendborg', ''),
('dime.denmark.kommune', '480', 'nordfyns', 0, 1, 0, 'dime.kommune.nordfyns', ''),
('dime.denmark.kommune', '482', 'langeland', 0, 1, 0, 'dime.kommune.langeland', ''),
('dime.denmark.kommune', '492', 'aero', 0, 1, 0, 'dime.kommune.aero', ''),
('dime.denmark.kommune', '510', 'haderslev', 0, 1, 0, 'dime.kommune.haderslev', ''),
('dime.denmark.kommune', '530', 'billund', 0, 1, 0, 'dime.kommune.billund', ''),
('dime.denmark.kommune', '540', 'sonderborg', 0, 1, 0, 'dime.kommune.sonderborg', ''),
('dime.denmark.kommune', '550', 'tonder', 0, 1, 0, 'dime.kommune.tonder', ''),
('dime.denmark.kommune', '561', 'esbjerg', 0, 1, 0, 'dime.kommune.esbjerg', ''),
('dime.denmark.kommune', '563', 'fano', 0, 1, 0, 'dime.kommune.fano', ''),
('dime.denmark.kommune', '573', 'varde', 0, 1, 0, 'dime.kommune.varde', ''),
('dime.denmark.kommune', '575', 'vejen', 0, 1, 0, 'dime.kommune.vejen', ''),
('dime.denmark.kommune', '580', 'aabenraa', 0, 1, 0, 'dime.kommune.aabenraa', ''),
('dime.denmark.kommune', '607', 'fredericia', 0, 1, 0, 'dime.kommune.fredericia', ''),
('dime.denmark.kommune', '615', 'horsens', 0, 1, 0, 'dime.kommune.horsens', ''),
('dime.denmark.kommune', '621', 'kolding', 0, 1, 0, 'dime.kommune.kolding', ''),
('dime.denmark.kommune', '630', 'vejle', 0, 1, 0, 'dime.kommune.vejle', ''),
('dime.denmark.kommune', '657', 'herning', 0, 1, 0, 'dime.kommune.herning', ''),
('dime.denmark.kommune', '661', 'holstebro', 0, 1, 0, 'dime.kommune.holstebro', ''),
('dime.denmark.kommune', '665', 'lemvig', 0, 1, 0, 'dime.kommune.lemvig', ''),
('dime.denmark.kommune', '671', 'struer', 0, 1, 0, 'dime.kommune.struer', ''),
('dime.denmark.kommune', '706', 'syddjurs', 0, 1, 0, 'dime.kommune.syddjurs', ''),
('dime.denmark.kommune', '707', 'norddjurs', 0, 1, 0, 'dime.kommune.norddjurs', ''),
('dime.denmark.kommune', '710', 'favrskov', 0, 1, 0, 'dime.kommune.favrskov', ''),
('dime.denmark.kommune', '727', 'odder', 0, 1, 0, 'dime.kommune.odder', ''),
('dime.denmark.kommune', '730', 'randers', 0, 1, 0, 'dime.kommune.randers', ''),
('dime.denmark.kommune', '740', 'silkeborg', 0, 1, 0, 'dime.kommune.silkeborg', ''),
('dime.denmark.kommune', '741', 'samso', 0, 1, 0, 'dime.kommune.samso', ''),
('dime.denmark.kommune', '746', 'skanderborg', 0, 1, 0, 'dime.kommune.skanderborg', ''),
('dime.denmark.kommune', '751', 'arhus', 0, 1, 0, 'dime.kommune.arhus', ''),
('dime.denmark.kommune', '756', 'ikastbrande', 0, 1, 0, 'dime.kommune.ikastbrande', ''),
('dime.denmark.kommune', '760', 'ringkobingskjern', 0, 1, 0, 'dime.kommune.ringkobingskjern', ''),
('dime.denmark.kommune', '766', 'hedensted', 0, 1, 0, 'dime.kommune.hedensted', ''),
('dime.denmark.kommune', '773', 'morso', 0, 1, 0, 'dime.kommune.morso', ''),
('dime.denmark.kommune', '779', 'skive', 0, 1, 0, 'dime.kommune.skive', ''),
('dime.denmark.kommune', '787', 'thisted', 0, 1, 0, 'dime.kommune.thisted', ''),
('dime.denmark.kommune', '791', 'viborg', 0, 1, 0, 'dime.kommune.viborg', ''),
('dime.denmark.kommune', '810', 'bronderslev', 0, 1, 0, 'dime.kommune.bronderslev', ''),
('dime.denmark.kommune', '813', 'frederikshavn', 0, 1, 0, 'dime.kommune.frederikshavn', ''),
('dime.denmark.kommune', '820', 'vesthimmerland', 0, 1, 0, 'dime.kommune.vesthimmerland', ''),
('dime.denmark.kommune', '825', 'laeso', 0, 1, 0, 'dime.kommune.laeso', ''),
('dime.denmark.kommune', '840', 'rebild', 0, 1, 0, 'dime.kommune.rebild', ''),
('dime.denmark.kommune', '846', 'mariagerfjord', 0, 1, 0, 'dime.kommune.mariagerfjord', ''),
('dime.denmark.kommune', '849', 'jammerbugt', 0, 1, 0, 'dime.kommune.jammerbugt', ''),
('dime.denmark.kommune', '851', 'aalborg', 0, 1, 0, 'dime.kommune.aalborg', ''),
('dime.denmark.kommune', '860', 'hjorring', 0, 1, 0, 'dime.kommune.hjorring', ''),
('dime.denmark.region', 'DK01', 'hovedstaden', 0, 1, 0, 'dime.region.hovedstaden', ''),
('dime.denmark.region', 'DK02', 'sjaelland', 0, 1, 0, 'dime.region.sjaelland', ''),
('dime.denmark.region', 'DK03', 'syddanmark', 0, 1, 0, 'dime.region.syddanmark', ''),
('dime.denmark.region', 'DK04', 'midtjylland', 0, 1, 0, 'dime.region.midtjylland', ''),
('dime.denmark.region', 'DK05', 'nordjylland', 0, 1, 0, 'dime.region.nordjylland', ''),
('dime.find.condition', 'fragmented', '', 0, 1, 0, 'dime.find.condition.fragmented', ''),
('dime.find.condition', 'modified', '', 0, 1, 0, 'dime.find.condition.modified', ''),
('dime.find.condition', 'unfinished', '', 0, 1, 0, 'dime.find.condition.unfinished', ''),
('dime.find.condition', 'whole', '', 0, 1, 0, 'dime.find.condition.whole', ''),
('dime.find.custody', 'destroyed', '', 0, 1, 0, 'dime.find.custody.destroyed', ''),
('dime.find.custody', 'discarded', '', 0, 1, 0, 'dime.find.custody.discarded', ''),
('dime.find.custody', 'held', '', 1, 1, 0, 'dime.find.custody.held', ''),
('dime.find.custody', 'lost', '', 0, 1, 0, 'dime.find.custody.lost', ''),
('dime.find.custody', 'requested', '', 0, 1, 0, 'dime.find.custody.requested', ''),
('dime.find.custody', 'sent', '', 0, 1, 0, 'dime.find.custody.sent', ''),
('dime.find.event', 'accessioned', '', 0, 0, 0, 'dime.find.event.accessioned', ''),
('dime.find.event', 'agreed', '', 0, 0, 0, 'dime.find.event.agreed', ''),
('dime.find.event', 'annotated', '', 0, 0, 0, 'dime.find.event.annotated', ''),
('dime.find.event', 'appraised', '', 0, 0, 0, 'dime.find.event.appraised', ''),
('dime.find.event', 'assessed', '', 0, 0, 0, 'dime.find.event.assessed', ''),
('dime.find.event', 'cited', '', 0, 0, 0, 'dime.find.event.cited', ''),
('dime.find.event', 'commented', '', 0, 0, 0, 'dime.find.event.commented', ''),
('dime.find.event', 'conserved', '', 0, 0, 0, 'dime.find.event.conserved', ''),
('dime.find.event', 'contacted', '', 0, 0, 0, 'dime.find.event.contacted', ''),
('dime.find.event', 'declined', '', 0, 0, 0, 'dime.find.event.declined', ''),
('dime.find.event', 'deleted', '', 0, 0, 0, 'dime.find.event.deleted', ''),
('dime.find.event', 'destroyed', '', 0, 0, 0, 'dime.find.event.destroyed', ''),
('dime.find.event', 'disagreed', '', 0, 0, 0, 'dime.find.event.disagreed', ''),
('dime.find.event', 'discarded', '', 0, 0, 0, 'dime.find.event.discarded', ''),
('dime.find.event', 'edited', '', 0, 0, 0, 'dime.find.event.edited', ''),
('dime.find.event', 'evaluated', '', 0, 0, 0, 'dime.find.event.evaluated', ''),
('dime.find.event', 'exported', '', 0, 0, 0, 'dime.find.event.exported', ''),
('dime.find.event', 'followed', '', 0, 0, 0, 'dime.find.event.followed', ''),
('dime.find.event', 'identified', '', 0, 0, 0, 'dime.find.event.identified', ''),
('dime.find.event', 'liked', '', 0, 0, 0, 'dime.find.event.liked', ''),
('dime.find.event', 'loaned', '', 0, 0, 0, 'dime.find.event.loaned', ''),
('dime.find.event', 'lost', '', 0, 0, 0, 'dime.find.event.lost', ''),
('dime.find.event', 'notified', '', 0, 0, 0, 'dime.find.event.notified', ''),
('dime.find.event', 'published', '', 0, 0, 0, 'dime.find.event.published', ''),
('dime.find.event', 'received', '', 0, 0, 0, 'dime.find.event.received', ''),
('dime.find.event', 'recorded', '', 0, 0, 0, 'dime.find.event.recorded', ''),
('dime.find.event', 'recovered', '', 0, 0, 0, 'dime.find.event.recovered', ''),
('dime.find.event', 'redacted', '', 0, 0, 0, 'dime.find.event.redacted', ''),
('dime.find.event', 'referred', '', 0, 0, 0, 'dime.find.event.referred', ''),
('dime.find.event', 'rejected', '', 0, 0, 0, 'dime.find.event.rejected', ''),
('dime.find.event', 'released', '', 0, 0, 0, 'dime.find.event.released', ''),
('dime.find.event', 'reported', '', 0, 0, 0, 'dime.find.event.reported', ''),
('dime.find.event', 'requested', '', 0, 0, 0, 'dime.find.event.requested', ''),
('dime.find.event', 'rewarded', '', 0, 0, 0, 'dime.find.event.rewarded', ''),
('dime.find.event', 'sent', '', 0, 0, 0, 'dime.find.event.sent', ''),
('dime.find.event', 'shared', '', 0, 0, 0, 'dime.find.event.shared', ''),
('dime.find.event', 'subscribed', '', 0, 0, 0, 'dime.find.event.subscribed', ''),
('dime.find.event', 'suppressed', '', 0, 0, 0, 'dime.find.event.suppressed', ''),
('dime.find.event', 'transferred', '', 0, 0, 0, 'dime.find.event.transferred', ''),
('dime.find.event', 'validated', '', 0, 0, 0, 'dime.find.event.validated', ''),
('dime.find.event', 'withdrawn', '', 0, 0, 0, 'dime.find.event.withdrawn', ''),
('dime.find.process', 'accessioned', '', 0, 1, 0, 'dime.find.process.accessioned', ''),
('dime.find.process', 'assessed', '', 0, 1, 0, 'dime.find.process.assessed', ''),
('dime.find.process', 'deleted', '', 0, 1, 0, 'dime.find.process.deleted', ''),
('dime.find.process', 'evaluated', '', 0, 1, 0, 'dime.find.process.evaluated', ''),
('dime.find.process', 'inactive', '', 0, 1, 0, 'dime.find.process.inactive', ''),
('dime.find.process', 'recorded', '', 1, 1, 0, 'dime.find.process.recorded', ''),
('dime.find.process', 'rejected', '', 0, 1, 0, 'dime.find.process.rejected', ''),
('dime.find.process', 'released', '', 0, 1, 0, 'dime.find.process.released', ''),
('dime.find.process', 'reported', '', 0, 1, 0, 'dime.find.process.reported', ''),
('dime.find.process', 'validated', '', 0, 1, 0, 'dime.find.process.validated', ''),
('dime.find.secondary', 'enamel', '', 0, 1, 0, 'dime.find.secondary.enamel', ''),
('dime.find.secondary', 'gilded', '', 0, 1, 0, 'dime.find.secondary.gilded', ''),
('dime.find.secondary', 'glass', '', 0, 1, 0, 'dime.find.secondary.glass', ''),
('dime.find.secondary', 'iron', '', 0, 1, 0, 'dime.find.secondary.iron', ''),
('dime.find.secondary', 'niello', '', 0, 1, 0, 'dime.find.secondary.niello', ''),
('dime.find.secondary', 'organic', '', 0, 1, 0, 'dime.find.secondary.organic', ''),
('dime.find.secondary', 'stone', '', 0, 1, 0, 'dime.find.secondary.stone', ''),
('dime.find.secondary', 'tinned', '', 0, 1, 0, 'dime.dime.secondary.tinned', ''),
('dime.find.secondary', 'zz', 'other', 0, 1, 0, 'dime.dime.secondary.other', ''),
('dime.find.type', 'accessory', '', 0, 1, 0, 'dime.find.type.accessory', ''),
('dime.find.type', 'coin', '', 0, 1, 0, 'dime.find.type.coin', ''),
('dime.find.type', 'fibula', '', 0, 1, 0, 'dime.find.type.fibula', ''),
('dime.find.type', 'military', '', 0, 1, 0, 'dime.find.type.military', ''),
('dime.find.type', 'tool', '', 0, 1, 0, 'dime.find.type.tool', ''),
('dime.find.type', 'waste', '', 0, 1, 0, 'dime.find.type.waste', ''),
('dime.find.visibility', 'private', '', 0, 1, 0, 'dime.find.visibility.private', ''),
('dime.find.visibility', 'public', '', 0, 1, 0, 'dime.find.visibility.public', ''),
('dime.find.visibility', 'restricted', '', 0, 1, 0, 'dime.find.visibility.restricted', ''),
('dime.material', 'ag', 'silver', 0, 1, 0, 'dime.material.silver', ''),
('dime.material', 'al', 'aluminium', 0, 1, 0, 'dime.material.aluminium', ''),
('dime.material', 'au', 'gold', 0, 1, 0, 'dime.material.gold', ''),
('dime.material', 'cu', 'copper', 0, 1, 0, 'dime.material.copper', ''),
('dime.material', 'cual', 'copperalloy', 0, 1, 0, 'dime.material.copperalloy', ''),
('dime.material', 'fe', 'iron', 0, 1, 0, 'dime.material.iron', ''),
('dime.material', 'pb', 'lead', 0, 1, 0, 'dime.material.lead', ''),
('dime.material', 'sa', 'tin', 0, 1, 0, 'dime.material.tin', ''),
('dime.material', 'xx', 'othermetal', 0, 1, 0, 'dime.material.othermetal', ''),
('dime.period', 'AMXX', 'mesolithic', 0, 1, 0, 'dime.period.mesolithic', 'Mesolithic'),
('dime.period', 'AXXX', 'stone', 0, 1, 0, 'dime.period.stone', 'Stone Age'),
('dime.period', 'AYXX', 'neolithic', 0, 1, 0, 'dime.period.neolithic', 'Neolithic'),
('dime.period', 'BÆX1', 'bronze.1', 0, 1, 0, 'dime.period.bronze.1', 'Bronze Age Period 1'),
('dime.period', 'BÆX2', 'bronze.2', 0, 1, 0, 'dime.period.bronze.2', 'Bronze Age Period 2'),
('dime.period', 'BÆX3', 'bronze.3', 0, 1, 0, 'dime.period.bronze.3', 'Bronze Age Period 3'),
('dime.period', 'BÆXX', 'bronze.early', 0, 1, 0, 'dime.period.bronze.early', 'Early Bronze Age'),
('dime.period', 'BXXX', 'bronze', 0, 1, 0, 'dime.period.bronze', 'Bronze Age'),
('dime.period', 'BYX4', 'bronze.4', 0, 1, 0, 'dime.period.bronze.4', 'Bronze Age Period 4'),
('dime.period', 'BYX5', 'bronze.5', 0, 1, 0, 'dime.period.bronze.5', 'Bronze Age Period 5'),
('dime.period', 'BYX6', 'bronze.6', 0, 1, 0, 'dime.period.bronze.6', 'Bronze Age Period 6'),
('dime.period', 'BYXX', 'bronze.late', 0, 1, 0, 'dime.period.bronze.late', 'Late Bronze Age'),
('dime.period', 'CÆFÆ', 'iron.preroman.early', 0, 1, 0, 'dime.period.iron.preroman.early', 'Early Pre-Roman Iron Age'),
('dime.period', 'CÆFM', 'iron.preroman.middle', 0, 1, 0, 'dime.period.iron.preroman.middle', 'Middle Pre-Roman Iron Age'),
('dime.period', 'CÆFX', 'iron.preroman', 0, 1, 0, 'dime.period.iron.preroman', 'Pre-Roman Iron Age'),
('dime.period', 'CÆFY', 'iron.preroman.late', 0, 1, 0, 'dime.period.iron.preroman.late', 'Late Pre-Roman Iron Age'),
('dime.period', 'CÆRA', 'iron.roman.early.b1', 0, 1, 0, 'dime.period.iron.roman.early.b1', 'Early Roman Iron Age B1'),
('dime.period', 'CÆRÆ', 'iron.roman.early', 0, 1, 0, 'dime.period.iron.roman.early', 'Early Roman Iron Age'),
('dime.period', 'CÆRB', 'iron.roman.early.b2', 0, 1, 0, 'dime.period.iron.roman.early.b2', 'Early Roman Iron Age B2'),
('dime.period', 'CÆRC', 'iron.roman.late.c1', 0, 1, 0, 'dime.period.iron.roman.late.c1', 'Late Roman Iron Age C1'),
('dime.period', 'CÆRD', 'iron.roman.late.c2', 0, 1, 0, 'dime.period.iron.roman.late.c2', 'Late Roman Iron Age C2'),
('dime.period', 'CÆRE', 'iron.roman.late.c3', 0, 1, 0, 'dime.period.iron.roman.late.c3', 'Late Roman Iron Age C3'),
('dime.period', 'CÆRX', 'iron.roman', 0, 1, 0, 'dime.period.iron.roman', 'Roman Iron Age'),
('dime.period', 'CÆRY', 'iron.roman.late', 0, 1, 0, 'dime.period.iron.roman.late', 'Late Roman Iron Age'),
('dime.period', 'CÆXX', 'iron.early', 0, 1, 0, 'dime.period.iron.early', 'Early Iron Age'),
('dime.period', 'CXXX', 'iron', 0, 1, 0, 'dime.period.iron', 'Iron Age'),
('dime.period', 'CYGÆ', 'iron.germainic.early', 0, 1, 0, 'dime.period.iron.germainic.early', 'Early Germanic Iron Age'),
('dime.period', 'CYGX', 'iron.germainic', 0, 1, 0, 'dime.period.iron.germainic', 'Germanic Iron Age'),
('dime.period', 'CYGY', 'iron.germainic.late', 0, 1, 0, 'dime.period.iron.germainic.late', 'Late Germanic Iron Age'),
('dime.period', 'CYVÆ', 'viking.early', 0, 1, 0, 'dime.period.viking.early', 'Early Viking Age'),
('dime.period', 'CYVX', 'viking', 0, 1, 0, 'dime.period.viking', 'Viking Age'),
('dime.period', 'CYVY', 'viking.late', 0, 1, 0, 'dime.period.viking.late', 'Late Viking Age'),
('dime.period', 'CYXX', 'iron.late', 0, 1, 0, 'dime.period.iron.late', 'Late Iron Age'),
('dime.period', 'DÆXX', 'medieval.early', 0, 1, 0, 'dime.period.medieval.early', 'Early Medieval'),
('dime.period', 'DXXX', 'medieval', 0, 1, 0, 'dime.period.medieval', 'Medieval'),
('dime.period', 'DYX3', 'medieval.high', 0, 1, 0, 'dime.period.medieval.high', 'High Medieval'),
('dime.period', 'DYX4', 'medieval.late', 0, 1, 0, 'dime.period.medieval.late', 'Late Medieval'),
('dime.period', 'EXXX', 'reformation', 0, 1, 0, 'dime.period.reformation', 'Reformation'),
('dime.period', 'FÆXX', 'absolutism', 0, 1, 0, 'dime.period.absolutism', 'Absolutism'),
('dime.period', 'FMIN', 'industrial', 0, 1, 0, 'dime.period.industrial', 'Industrial Age'),
('dime.period', 'FMV1', 'ww1', 0, 1, 0, 'dime.period.ww1', 'First World War'),
('dime.period', 'FMV2', 'ww2', 0, 1, 0, 'dime.period.ww2', 'Second World War'),
('dime.period', 'FMVM', 'interwar', 0, 1, 0, 'dime.period.interwar', 'Interwar Years'),
('dime.period', 'FXXX', 'modern', 0, 1, 0, 'dime.period.modern', 'Modern Age'),
('dime.period', 'FYXX', 'welfare', 0, 1, 0, 'dime.period.welfare', 'Welfare Age'),
('dime.period', 'HXXX', 'historic', 0, 1, 0, 'dime.period.historic', 'Historic Age'),
('dime.period', 'PALEO', 'palaeolithic', 0, 1, 0, 'dime.period.palaeolithic', 'Palaeolithic'),
('dime.period', 'VEM', 'viking.medieval', 0, 1, 0, 'dime.period.viking.medieval', 'Viking / Early Medieval '),
('dime.period', 'XXXX', 'undated', 0, 1, 0, 'dime.period.undated', 'Undated'),
('dime.treasure', 'appraisal', '', 0, 1, 0, 'dime.treasure.appraisal', ''),
('dime.treasure', 'not', '', 0, 1, 0, 'dime.treasure.not', ''),
('dime.treasure', 'pending', '', 1, 1, 0, 'dime.treasure.pending', ''),
('dime.treasure', 'treasure', '', 0, 1, 0, 'dime.treasure.treasure', ''),
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
('language', 'gag', 'gagauz', 0, 1, 0, 'language.gagauz', '');
INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `root`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
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
('language', 'srn', 'tongo.sranan', 0, 1, 0, 'language.tongo.sranan', ''),
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
('da', 'vocabulary', 'dime.treasure.appraisal', 'default', 'Vurdering', ''),
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
('en', 'vocabulary', 'dime.treasure.appraisal', 'default', 'Appraisal', ''),
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

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_action`
--

CREATE TABLE `ark_workflow_action` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_vocabulary` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_term` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_permission` tinyint(1) NOT NULL DEFAULT '0',
  `default_agency` tinyint(1) NOT NULL DEFAULT '0',
  `default_condition` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_action`
--

INSERT INTO `ark_workflow_action` (`schma`, `action`, `event_vocabulary`, `event_term`, `agent`, `default_permission`, `default_agency`, `default_condition`, `enabled`, `keyword`) VALUES
('core.actor', 'activate', 'core.actor.event', 'activated', NULL, 0, 0, 0, 1, 'dime.action.activate'),
('core.actor', 'approve', 'core.actor.event', 'approved', NULL, 0, 0, 0, 1, 'dime.action.approve'),
('core.actor', 'cancel', 'core.actor.event', 'cancelled', NULL, 0, 0, 0, 1, 'dime.action.cancel'),
('core.actor', 'register', 'core.actor.event', 'registered', 'registrar', 0, 0, 0, 1, 'dime.action.register'),
('core.actor', 'restore', 'core.actor.event', 'restored', NULL, 0, 0, 0, 1, 'dime.action.restore'),
('core.actor', 'suspend', 'core.actor.event', 'suspended', NULL, 0, 0, 0, 1, 'dime.action.suspend'),
('dime.find', 'accession', 'dime.find.event', 'accessioned', NULL, 0, 0, 0, 1, 'dime.action.accession'),
('dime.find', 'agree', 'dime.find.event', 'agreed', NULL, 0, 0, 0, 1, 'dime.action.agree'),
('dime.find', 'annotate', 'dime.find.event', 'annotated', NULL, 0, 0, 0, 1, 'dime.action.annotate'),
('dime.find', 'appraise', 'dime.find.event', 'appraised', 'appraiser', 0, 0, 0, 1, 'dime.action.appraise'),
('dime.find', 'assess', 'dime.find.event', 'assessed', 'assessor', 0, 0, 0, 1, 'dime.action.assess'),
('dime.find', 'cite', 'dime.find.event', 'cited', NULL, 0, 0, 0, 1, 'dime.action.cite'),
('dime.find', 'comment', 'dime.find.event', 'commented', NULL, 0, 0, 0, 1, 'dime.action.comment'),
('dime.find', 'conserve', 'dime.find.event', 'conserved', NULL, 0, 0, 0, 1, 'dime.action.conserve'),
('dime.find', 'contact', 'dime.find.event', 'contacted', NULL, 0, 0, 0, 1, 'dime.action.contact'),
('dime.find', 'decline', 'dime.find.event', 'declined', NULL, 0, 0, 0, 1, 'dime.action.decline'),
('dime.find', 'delete', 'dime.find.event', 'deleted', NULL, 0, 0, 0, 1, 'dime.action.delete'),
('dime.find', 'destroy', 'dime.find.event', 'destroyed', NULL, 0, 0, 0, 1, 'dime.action.destroy'),
('dime.find', 'disagree', 'dime.find.event', 'disagreed', NULL, 0, 0, 0, 1, 'dime.action.disagree'),
('dime.find', 'discard', 'dime.find.event', 'discarded', NULL, 0, 0, 0, 1, 'dime.action.discard'),
('dime.find', 'edit', 'dime.find.event', 'edited', NULL, 0, 1, 1, 1, 'dime.action.edit'),
('dime.find', 'evaluate', 'dime.find.event', 'evaluated', NULL, 0, 0, 0, 1, 'dime.action.evaluate'),
('dime.find', 'export', 'dime.find.event', 'exported', NULL, 0, 0, 0, 1, 'dime.action.export'),
('dime.find', 'follow', 'dime.find.event', 'followed', NULL, 0, 0, 0, 1, 'dime.action.follow'),
('dime.find', 'identify', 'dime.find.event', 'identified', NULL, 0, 0, 0, 1, 'dime.action.identify'),
('dime.find', 'like', 'dime.find.event', 'liked', NULL, 0, 0, 0, 1, 'dime.action.like'),
('dime.find', 'loan', 'dime.find.event', 'loaned', NULL, 0, 0, 0, 1, 'dime.action.loan'),
('dime.find', 'lose', 'dime.find.event', 'lost', NULL, 0, 0, 0, 1, 'dime.action.lose'),
('dime.find', 'notify', 'dime.find.event', 'notified', NULL, 0, 0, 0, 1, 'dime.action.notify'),
('dime.find', 'publish', 'dime.find.event', 'published', NULL, 0, 0, 0, 1, 'dime.action.publish'),
('dime.find', 'receive', 'dime.find.event', 'received', NULL, 0, 0, 0, 1, 'dime.action.receive'),
('dime.find', 'record', 'dime.find.event', 'recorded', 'recorder', 1, 1, 1, 1, 'dime.action.record'),
('dime.find', 'recover', 'dime.find.event', 'recovered', NULL, 0, 0, 0, 1, 'dime.action.recover'),
('dime.find', 'redact', 'dime.find.event', 'redacted', NULL, 0, 0, 0, 1, 'dime.action.redact'),
('dime.find', 'refer', 'dime.find.event', 'referred', NULL, 0, 0, 0, 1, 'dime.action.refer'),
('dime.find', 'reject', 'dime.find.event', 'rejected', NULL, 0, 0, 0, 1, 'dime.action.reject'),
('dime.find', 'release', 'dime.find.event', 'released', NULL, 0, 0, 0, 1, 'dime.action.release'),
('dime.find', 'report', 'dime.find.event', 'reported', 'reporter', 1, 0, 0, 1, 'dime.action.report'),
('dime.find', 'request', 'dime.find.event', 'requested', NULL, 0, 0, 0, 1, 'dime.action.request'),
('dime.find', 'reward', 'dime.find.event', 'rewarded', NULL, 0, 0, 0, 1, 'dime.action.reward'),
('dime.find', 'send', 'dime.find.event', 'sent', NULL, 0, 0, 0, 1, 'dime.action.send'),
('dime.find', 'share', 'dime.find.event', 'shared', NULL, 0, 0, 0, 1, 'dime.action.share'),
('dime.find', 'subscribe', 'dime.find.event', 'subscribed', NULL, 0, 0, 0, 1, 'dime.action.subscribe'),
('dime.find', 'suppress', 'dime.find.event', 'suppressed', NULL, 0, 0, 0, 1, 'dime.action.suppress'),
('dime.find', 'transfer', 'dime.find.event', 'transferred', NULL, 0, 0, 0, 1, 'dime.action.transfer'),
('dime.find', 'validate', 'dime.find.event', 'validated', NULL, 0, 0, 0, 1, 'dime.action.validate'),
('dime.find', 'withdraw', 'dime.find.event', 'withdrawn', NULL, 0, 0, 0, 1, 'dime.action.withdraw');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_agency`
--

CREATE TABLE `ark_workflow_agency` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'eq'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_agency`
--

INSERT INTO `ark_workflow_agency` (`schma`, `action`, `type`, `attribute`, `operator`) VALUES
('dime.find', 'accession', 'find', 'custodian', 'is'),
('dime.find', 'conserve', 'find', 'custodian', 'is'),
('dime.find', 'decline', 'find', 'custodian', 'is'),
('dime.find', 'destroy', 'find', 'custodian', 'is'),
('dime.find', 'discard', 'find', 'owner', 'is'),
('dime.find', 'loan', 'find', 'owner', 'is'),
('dime.find', 'lose', 'find', 'custodian', 'is'),
('dime.find', 'publish', 'find', 'owner', 'is'),
('dime.find', 'receive', 'find', 'recipient', 'is'),
('dime.find', 'recover', 'find', 'custodian', 'is'),
('dime.find', 'recover', 'find', 'owner', 'is'),
('dime.find', 'redact', 'find', 'owner', 'is'),
('dime.find', 'report', 'find', 'custodian', 'is'),
('dime.find', 'report', 'find', 'finder', 'is'),
('dime.find', 'report', 'find', 'owner', 'is'),
('dime.find', 'request', 'find', 'custodian', 'not'),
('dime.find', 'send', 'find', 'custodian', 'is'),
('dime.find', 'suppress', 'find', 'owner', 'is'),
('dime.find', 'transfer', 'find', 'owner', 'is'),
('dime.find', 'withdraw', 'find', 'recipient', 'is');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_condition`
--

CREATE TABLE `ark_workflow_condition` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grp` int(11) NOT NULL DEFAULT '0',
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'eq',
  `value` varchar(4000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_condition`
--

INSERT INTO `ark_workflow_condition` (`schma`, `action`, `type`, `attribute`, `grp`, `operator`, `value`) VALUES
('dime.find', 'accession', 'find', 'process', 0, 'eq', 'dime.process.assessed'),
('dime.find', 'accession', 'find', 'process', 1, 'eq', 'dime.process.appraised'),
('dime.find', 'appraise', 'find', 'process', 0, 'eq', 'dime.process.assessed'),
('dime.find', 'appraise', 'find', 'treasure', 0, 'eq', 'dime.treasure.appraisal'),
('dime.find', 'assess', 'find', 'process', 0, 'eq', 'dime.process.validated'),
('dime.find', 'assess', 'find', 'treasure', 0, 'eq', 'dime.treasure.pending'),
('dime.find', 'conserve', 'find', 'custody', 0, 'eq', 'dime.custody.held'),
('dime.find', 'decline', 'find', 'custody', 0, 'eq', 'dime.custody.requested'),
('dime.find', 'discard', 'find', 'process', 0, 'eq', 'dime.process.recorded'),
('dime.find', 'discard', 'find', 'process', 1, 'eq', 'dime.process.accessioned'),
('dime.find', 'discard', 'find', 'process', 2, 'eq', 'dime.process.released'),
('dime.find', 'loan', 'find', 'process', 1, 'eq', 'dime.process.accessioned'),
('dime.find', 'loan', 'find', 'process', 2, 'eq', 'dime.process.released'),
('dime.find', 'receive', 'find', 'custody', 0, 'eq', 'dime.custody.sent'),
('dime.find', 'recover', 'find', 'custody', 0, 'eq', 'dime.custody.lost'),
('dime.find', 'recover', 'find', 'custody', 1, 'eq', 'dime.custody.discarded'),
('dime.find', 'recover', 'find', 'custody', 3, 'eq', 'dime.custody.destroyed'),
('dime.find', 'reject', 'find', 'process', 0, 'eq', 'dime.process.reported'),
('dime.find', 'release', 'find', 'process', 0, 'eq', 'dime.process.assessed'),
('dime.find', 'release', 'find', 'process', 1, 'eq', 'dime.process.appraised'),
('dime.find', 'report', 'find', 'process', 0, 'eq', 'dime.process.recorded'),
('dime.find', 'request', 'find', 'custody', 0, 'eq', 'dime.custody.held'),
('dime.find', 'reward', 'find', 'process', 0, 'eq', 'dime.process.appraised'),
('dime.find', 'reward', 'find', 'treasure', 0, 'eq', 'dime.treasure.treasure'),
('dime.find', 'send', 'find', 'custody', 0, 'eq', 'dime.custody.held'),
('dime.find', 'validate', 'find', 'process', 0, 'eq', 'dime.process.reported'),
('dime.find', 'withdraw', 'find', 'custody', 0, 'eq', 'dime.custody.requested');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_notify`
--

CREATE TABLE `ark_workflow_notify` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_notify`
--

INSERT INTO `ark_workflow_notify` (`schma`, `action`, `type`, `attribute`, `keyword`) VALUES
('dime.find', 'accession', 'find', 'finder', ''),
('dime.find', 'accession', 'find', 'museum', ''),
('dime.find', 'accession', 'find', 'owner', ''),
('dime.find', 'appraise', 'find', 'finder', ''),
('dime.find', 'appraise', 'find', 'museum', ''),
('dime.find', 'appraise', 'find', 'owner', ''),
('dime.find', 'assess', 'find', 'custodian', ''),
('dime.find', 'assess', 'find', 'finder', ''),
('dime.find', 'assess', 'find', 'owner', ''),
('dime.find', 'conserve', 'find', 'finder', ''),
('dime.find', 'conserve', 'find', 'owner', ''),
('dime.find', 'decline', 'find', 'owner', ''),
('dime.find', 'decline', 'find', 'recipient', ''),
('dime.find', 'delete', 'find', 'finder', ''),
('dime.find', 'delete', 'find', 'owner', ''),
('dime.find', 'destroy', 'find', 'custodian', ''),
('dime.find', 'destroy', 'find', 'owner', ''),
('dime.find', 'discard', 'find', 'custodian', ''),
('dime.find', 'discard', 'find', 'owner', ''),
('dime.find', 'loan', 'find', 'custodian', ''),
('dime.find', 'loan', 'find', 'owner', ''),
('dime.find', 'lose', 'find', 'custodian', ''),
('dime.find', 'lose', 'find', 'owner', ''),
('dime.find', 'receive', 'find', 'custodian', ''),
('dime.find', 'receive', 'find', 'owner', ''),
('dime.find', 'record', 'find', 'finder', ''),
('dime.find', 'recover', 'find', 'custodian', ''),
('dime.find', 'recover', 'find', 'owner', ''),
('dime.find', 'reject', 'find', 'custodian', ''),
('dime.find', 'reject', 'find', 'finder', ''),
('dime.find', 'reject', 'find', 'owner', ''),
('dime.find', 'release', 'find', 'finder', ''),
('dime.find', 'release', 'find', 'museum', ''),
('dime.find', 'release', 'find', 'owner', ''),
('dime.find', 'report', 'find', 'custodian', ''),
('dime.find', 'report', 'find', 'finder', ''),
('dime.find', 'report', 'find', 'museum', ''),
('dime.find', 'report', 'find', 'owner', ''),
('dime.find', 'request', 'find', 'custodian', ''),
('dime.find', 'request', 'find', 'owner', ''),
('dime.find', 'reward', 'find', 'finder', ''),
('dime.find', 'reward', 'find', 'museum', ''),
('dime.find', 'send', 'find', 'owner', ''),
('dime.find', 'send', 'find', 'recipient', ''),
('dime.find', 'transfer', 'find', 'custodian', ''),
('dime.find', 'transfer', 'find', 'owner', ''),
('dime.find', 'validate', 'find', 'custodian', ''),
('dime.find', 'validate', 'find', 'finder', ''),
('dime.find', 'validate', 'find', 'owner', ''),
('dime.find', 'withdraw', 'find', 'custodian', ''),
('dime.find', 'withdraw', 'find', 'owner', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_permission`
--

CREATE TABLE `ark_workflow_permission` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'is'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_permission`
--

INSERT INTO `ark_workflow_permission` (`schma`, `action`, `role`, `operator`) VALUES
('core.actor', 'activate', 'admin', 'is'),
('core.actor', 'activate', 'registrar', 'is'),
('core.actor', 'approve', 'admin', 'is'),
('core.actor', 'approve', 'registrar', 'is'),
('core.actor', 'cancel', 'admin', 'is'),
('core.actor', 'cancel', 'registrar', 'is'),
('core.actor', 'restore', 'admin', 'is'),
('core.actor', 'restore', 'registrar', 'is'),
('core.actor', 'suspend', 'admin', 'is'),
('core.actor', 'suspend', 'registrar', 'is'),
('dime.find', 'accession', 'appraiser', 'is'),
('dime.find', 'accession', 'curator', 'is'),
('dime.find', 'accession', 'registrar', 'is'),
('dime.find', 'appraise', 'appraiser', 'is'),
('dime.find', 'assess', 'curator', 'is'),
('dime.find', 'assess', 'registrar', 'is'),
('dime.find', 'conserve', 'appraiser', 'is'),
('dime.find', 'conserve', 'curator', 'is'),
('dime.find', 'conserve', 'registrar', 'is'),
('dime.find', 'delete', 'admin', 'is'),
('dime.find', 'delete', 'detectorist', 'is'),
('dime.find', 'delete', 'registrar', 'is'),
('dime.find', 'edit', 'admin', 'is'),
('dime.find', 'edit', 'detectorist', 'is'),
('dime.find', 'edit', 'registrar', 'is'),
('dime.find', 'reject', 'registrar', 'is'),
('dime.find', 'release', 'appraiser', 'is'),
('dime.find', 'release', 'registrar', 'is'),
('dime.find', 'reward', 'appraiser', 'is'),
('dime.find', 'validate', 'registrar', 'is');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_trigger`
--

CREATE TABLE `ark_workflow_trigger` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trigger_action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_trigger`
--

INSERT INTO `ark_workflow_trigger` (`schma`, `action`, `trigger_schma`, `trigger_action`) VALUES
('dime.find', 'assess', 'dime.find', 'send'),
('dime.find', 'release', 'dime.find', 'send');

-- --------------------------------------------------------

--
-- Table structure for table `ark_workflow_update`
--

CREATE TABLE `ark_workflow_update` (
  `schma` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `ark_workflow_update`
--

INSERT INTO `ark_workflow_update` (`schma`, `action`, `type`, `attribute`) VALUES
('dime.find', 'receive', 'find', 'custodian'),
('dime.find', 'record', 'find', 'custodian'),
('dime.find', 'decline', 'find', 'custody'),
('dime.find', 'destroy', 'find', 'custody'),
('dime.find', 'discard', 'find', 'custody'),
('dime.find', 'lose', 'find', 'custody'),
('dime.find', 'receive', 'find', 'custody'),
('dime.find', 'record', 'find', 'custody'),
('dime.find', 'recover', 'find', 'custody'),
('dime.find', 'request', 'find', 'custody'),
('dime.find', 'send', 'find', 'custody'),
('dime.find', 'withdraw', 'find', 'custody'),
('dime.find', 'record', 'find', 'finder'),
('dime.find', 'accession', 'find', 'owner'),
('dime.find', 'record', 'find', 'owner'),
('dime.find', 'transfer', 'find', 'owner'),
('dime.find', 'accession', 'find', 'process'),
('dime.find', 'appraise', 'find', 'process'),
('dime.find', 'assess', 'find', 'process'),
('dime.find', 'delete', 'find', 'process'),
('dime.find', 'record', 'find', 'process'),
('dime.find', 'reject', 'find', 'process'),
('dime.find', 'release', 'find', 'process'),
('dime.find', 'report', 'find', 'process'),
('dime.find', 'validate', 'find', 'process'),
('dime.find', 'decline', 'find', 'recipient'),
('dime.find', 'receive', 'find', 'recipient'),
('dime.find', 'request', 'find', 'recipient'),
('dime.find', 'send', 'find', 'recipient'),
('dime.find', 'withdraw', 'find', 'recipient'),
('dime.find', 'appraise', 'find', 'treasure'),
('dime.find', 'assess', 'find', 'treasure'),
('dime.find', 'record', 'find', 'treasure');

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
  ADD KEY `schma` (`schma`);

--
-- Indexes for table `ark_map`
--
ALTER TABLE `ark_map`
  ADD PRIMARY KEY (`map`);

--
-- Indexes for table `ark_map_layer`
--
ALTER TABLE `ark_map_layer`
  ADD PRIMARY KEY (`source`,`layer`);

--
-- Indexes for table `ark_map_legend`
--
ALTER TABLE `ark_map_legend`
  ADD PRIMARY KEY (`map`,`source`,`layer`),
  ADD UNIQUE KEY `sequence` (`map`,`source`,`layer`,`seq`) USING BTREE,
  ADD KEY `legend_layer` (`source`,`layer`);

--
-- Indexes for table `ark_map_source`
--
ALTER TABLE `ark_map_source`
  ADD PRIMARY KEY (`source`);

--
-- Indexes for table `ark_module`
--
ALTER TABLE `ark_module`
  ADD PRIMARY KEY (`module`),
  ADD UNIQUE KEY `tbl` (`tbl`),
  ADD UNIQUE KEY `classname` (`classname`),
  ADD UNIQUE KEY `resource` (`resource`),
  ADD UNIQUE KEY `entity` (`entity`);

--
-- Indexes for table `ark_rbac_access`
--
ALTER TABLE `ark_rbac_access`
  ADD PRIMARY KEY (`role`,`permission`),
  ADD KEY `permission` (`permission`);

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
  ADD KEY `module` (`module`),
  ADD KEY `type_vocabulary` (`vocabulary`);

--
-- Indexes for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD PRIMARY KEY (`schma`,`type`,`association`) USING BTREE,
  ADD KEY `inverse_schema` (`inverse`),
  ADD KEY `module1` (`module1`,`schema1`),
  ADD KEY `module2` (`module2`,`schema2`);

--
-- Indexes for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD PRIMARY KEY (`schma`,`type`,`attribute`) USING BTREE,
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`);

--
-- Indexes for table `ark_schema_item`
--
ALTER TABLE `ark_schema_item`
  ADD PRIMARY KEY (`attribute`) USING BTREE,
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`);

--
-- Indexes for table `ark_schema_permission`
--
ALTER TABLE `ark_schema_permission`
  ADD PRIMARY KEY (`schma`,`type`,`attribute`,`permission`),
  ADD KEY `permission` (`permission`);

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
  ADD KEY `type` (`type`);

--
-- Indexes for table `ark_view_field`
--
ALTER TABLE `ark_view_field`
  ADD PRIMARY KEY (`element`),
  ADD KEY `schma` (`schma`),
  ADD KEY `schma_2` (`schma`,`item_type`,`attribute`);

--
-- Indexes for table `ark_view_grid`
--
ALTER TABLE `ark_view_grid`
  ADD PRIMARY KEY (`layout`,`item_type`,`row`,`col`,`seq`),
  ADD KEY `child` (`element`),
  ADD KEY `map` (`map`);

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
  ADD UNIQUE KEY `parent` (`parent`,`seq`);

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
  ADD KEY `descendent` (`descendant`);

--
-- Indexes for table `ark_view_type`
--
ALTER TABLE `ark_view_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `ark_view_widget`
--
ALTER TABLE `ark_view_widget`
  ADD PRIMARY KEY (`element`),
  ADD KEY `ark_view_widget_ibfk_1` (`vocabulary`);

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
-- Indexes for table `ark_workflow_action`
--
ALTER TABLE `ark_workflow_action`
  ADD PRIMARY KEY (`schma`,`action`),
  ADD KEY `event_vocabulary` (`event_vocabulary`,`event_term`);

--
-- Indexes for table `ark_workflow_agency`
--
ALTER TABLE `ark_workflow_agency`
  ADD PRIMARY KEY (`schma`,`action`,`type`,`attribute`),
  ADD KEY `schma` (`schma`,`type`,`attribute`);

--
-- Indexes for table `ark_workflow_condition`
--
ALTER TABLE `ark_workflow_condition`
  ADD PRIMARY KEY (`schma`,`action`,`type`,`attribute`,`grp`),
  ADD KEY `schma` (`schma`,`type`,`attribute`);

--
-- Indexes for table `ark_workflow_notify`
--
ALTER TABLE `ark_workflow_notify`
  ADD PRIMARY KEY (`schma`,`action`,`type`,`attribute`),
  ADD KEY `schma` (`schma`,`type`,`attribute`);

--
-- Indexes for table `ark_workflow_permission`
--
ALTER TABLE `ark_workflow_permission`
  ADD PRIMARY KEY (`schma`,`action`,`role`),
  ADD KEY `schma` (`schma`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `ark_workflow_trigger`
--
ALTER TABLE `ark_workflow_trigger`
  ADD PRIMARY KEY (`schma`,`action`,`trigger_schma`,`trigger_action`),
  ADD KEY `schma` (`schma`),
  ADD KEY `trigger_schma` (`trigger_schma`,`trigger_action`);

--
-- Indexes for table `ark_workflow_update`
--
ALTER TABLE `ark_workflow_update`
  ADD PRIMARY KEY (`schma`,`action`,`type`,`attribute`),
  ADD KEY `schma` (`schma`,`type`,`attribute`);

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
-- AUTO_INCREMENT for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
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
  ADD CONSTRAINT `ark_instance_schema_ibfk_2` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `ark_rbac_access`
--
ALTER TABLE `ark_rbac_access`
  ADD CONSTRAINT `ark_rbac_access_ibfk_1` FOREIGN KEY (`role`) REFERENCES `ark_rbac_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_rbac_access_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `ark_rbac_permission` (`permission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_route`
--
ALTER TABLE `ark_route`
  ADD CONSTRAINT `ark_route_ibfk_1` FOREIGN KEY (`page`) REFERENCES `ark_view_page` (`element`);

--
-- Constraints for table `ark_schema`
--
ALTER TABLE `ark_schema`
  ADD CONSTRAINT `ark_schema_ibfk_1` FOREIGN KEY (`module`) REFERENCES `ark_module` (`module`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_ibfk_2` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_association`
--
ALTER TABLE `ark_schema_association`
  ADD CONSTRAINT `ark_schema_association_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_association_ibfk_3` FOREIGN KEY (`module1`,`schema1`) REFERENCES `ark_schema` (`module`, `schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_association_ibfk_4` FOREIGN KEY (`module2`,`schema2`) REFERENCES `ark_schema` (`module`, `schma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_attribute`
--
ALTER TABLE `ark_schema_attribute`
  ADD CONSTRAINT `ark_schema_attribute_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_attribute_ibfk_2` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_attribute_ibfk_3` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_schema_permission`
--
ALTER TABLE `ark_schema_permission`
  ADD CONSTRAINT `ark_schema_permission_ibfk_1` FOREIGN KEY (`schma`,`type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_permission_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `ark_rbac_permission` (`permission`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `ark_view_field`
--
ALTER TABLE `ark_view_field`
  ADD CONSTRAINT `ark_view_field_ibfk_1` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_field_ibfk_2` FOREIGN KEY (`schma`,`item_type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_grid`
--
ALTER TABLE `ark_view_grid`
  ADD CONSTRAINT `ark_view_grid_ibfk_1` FOREIGN KEY (`layout`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_grid_ibfk_2` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_grid_ibfk_3` FOREIGN KEY (`map`) REFERENCES `ark_map` (`map`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_layout`
--
ALTER TABLE `ark_view_layout`
  ADD CONSTRAINT `ark_view_layout_ibfk_1` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_layout_ibfk_2` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `content_element` FOREIGN KEY (`content`) REFERENCES `ark_view_layout` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `element` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `footer_element` FOREIGN KEY (`footer`) REFERENCES `ark_view_layout` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `navbar_element` FOREIGN KEY (`navbar`) REFERENCES `ark_view_nav` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sidebar_element` FOREIGN KEY (`sidebar`) REFERENCES `ark_view_nav` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_tree`
--
ALTER TABLE `ark_view_tree`
  ADD CONSTRAINT `ark_view_tree_ibfk_1` FOREIGN KEY (`ancestor`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_tree_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_view_widget`
--
ALTER TABLE `ark_view_widget`
  ADD CONSTRAINT `ark_view_widget_ibfk_1` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_widget_ibfk_2` FOREIGN KEY (`element`) REFERENCES `ark_view_element` (`element`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_1` FOREIGN KEY (`from_concept`,`from_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_2` FOREIGN KEY (`to_concept`,`to_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_related_ibfk_3` FOREIGN KEY (`relation`) REFERENCES `ark_vocabulary_relation` (`relation`) ON DELETE CASCADE;

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

--
-- Constraints for table `ark_workflow_action`
--
ALTER TABLE `ark_workflow_action`
  ADD CONSTRAINT `ark_workflow_action_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_action_ibfk_2` FOREIGN KEY (`event_vocabulary`,`event_term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_agency`
--
ALTER TABLE `ark_workflow_agency`
  ADD CONSTRAINT `ark_workflow_agency_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_agency_ibfk_2` FOREIGN KEY (`schma`,`type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_condition`
--
ALTER TABLE `ark_workflow_condition`
  ADD CONSTRAINT `ark_workflow_condition_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_condition_ibfk_2` FOREIGN KEY (`schma`,`type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_notify`
--
ALTER TABLE `ark_workflow_notify`
  ADD CONSTRAINT `ark_workflow_notify_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_notify_ibfk_2` FOREIGN KEY (`schma`,`type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_permission`
--
ALTER TABLE `ark_workflow_permission`
  ADD CONSTRAINT `ark_workflow_permission_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_permission_ibfk_2` FOREIGN KEY (`role`) REFERENCES `ark_rbac_role` (`role`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_trigger`
--
ALTER TABLE `ark_workflow_trigger`
  ADD CONSTRAINT `ark_workflow_trigger_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_trigger_ibfk_2` FOREIGN KEY (`trigger_schma`,`trigger_action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_workflow_update`
--
ALTER TABLE `ark_workflow_update`
  ADD CONSTRAINT `ark_workflow_update_ibfk_1` FOREIGN KEY (`schma`,`action`) REFERENCES `ark_workflow_action` (`schma`, `action`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_workflow_update_ibfk_2` FOREIGN KEY (`schma`,`type`,`attribute`) REFERENCES `ark_schema_attribute` (`schma`, `type`, `attribute`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
