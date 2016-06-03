-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2017 at 01:32 PM
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
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_config_flash`
--

CREATE TABLE `ark_config_flash` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `profile` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `max` int(11) NOT NULL,
  `min` int(11) DEFAULT NULL,
  `mode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `input` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `object` tinyint(1) NOT NULL DEFAULT '0',
  `array` tinyint(1) NOT NULL DEFAULT '0',
  `sortable` tinyint(1) NOT NULL DEFAULT '1',
  `searchable` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
('email', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.email'),
('float', 'float', 'text', 0, 0, 1, 1, 1, 0, 'format.float'),
('geometry', 'geometry', '', 0, 0, 0, 1, 1, 0, 'format.geometry'),
('html', 'text', 'textarea', 0, 0, 1, 1, 1, 0, 'format.html'),
('identifier', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.identifier'),
('integer', 'integer', 'text', 0, 0, 1, 1, 1, 0, 'format.integer'),
('item', 'item', 'select', 0, 0, 0, 0, 1, 0, 'format.item'),
('key', 'string', 'select', 0, 0, 1, 1, 1, 0, 'format.key'),
('markdown', 'text', 'textarea', 0, 0, 1, 1, 1, 0, 'format.markdown'),
('module', 'string', 'select', 0, 0, 0, 0, 1, 0, 'format.module'),
('money', 'decimal', 'date', 0, 0, 1, 1, 1, 0, 'format.money'),
('ordinaldate', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.ordinaldate'),
('password', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.password'),
('percent', 'float', 'text', 0, 0, 1, 1, 1, 0, 'format.percent'),
('richtext', 'text', 'textarea', 0, 0, 1, 1, 1, 0, 'format.richtext'),
('search', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.search'),
('shorttext', 'text', 'text', 0, 0, 1, 1, 1, 0, 'format.shorttext'),
('string', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.string'),
('telephone', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.telephone'),
('text', 'text', 'textarea', 0, 0, 1, 1, 1, 0, 'format.text'),
('time', 'time', 'date', 0, 0, 1, 1, 1, 0, 'format.time'),
('url', 'text', 'text', 0, 0, 1, 1, 1, 0, 'format.url'),
('weekdate', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.weekdate'),
('yearmonth', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.yearmonth'),
('yearweek', 'string', 'text', 0, 0, 1, 1, 1, 0, 'format.yearweek');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_blob`
--

CREATE TABLE `ark_format_blob` (
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unicode` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prec` int(11) NOT NULL DEFAULT '200',
  `scale` int(11) NOT NULL,
  `minimum` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
  `multiple_of` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_decimal`
--

INSERT INTO `ark_format_decimal` (`format`, `prec`, `scale`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`) VALUES
('money', 198, 2, NULL, 0, NULL, 0, '0.01');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_float`
--

CREATE TABLE `ark_format_float` (
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `minimum` double DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` double DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
  `multiple_of` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_float`
--

INSERT INTO `ark_format_float` (`format`, `minimum`, `exclusive_minimum`, `maximum`, `exclusive_maximum`, `multiple_of`) VALUES
('float', NULL, 0, NULL, 0, NULL),
('percent', 0, 0, 100, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_geometry`
--

CREATE TABLE `ark_format_geometry` (
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_geometry`
--

INSERT INTO `ark_format_geometry` (`format`) VALUES
('geometry');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_integer`
--

CREATE TABLE `ark_format_integer` (
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `minimum` int(11) DEFAULT NULL,
  `exclusive_minimum` tinyint(1) NOT NULL,
  `maximum` int(11) DEFAULT NULL,
  `exclusive_maximum` tinyint(1) NOT NULL,
  `multiple_of` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_object`
--

INSERT INTO `ark_format_object` (`format`) VALUES
('address');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_property`
--

CREATE TABLE `ark_format_property` (
  `object` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `root` tinyint(1) NOT NULL DEFAULT '0',
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_property`
--

INSERT INTO `ark_format_property` (`object`, `property`, `sequence`, `format`, `vocabulary`, `root`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('address', 'city', 1, 'text', NULL, 0, 1, 1, 1, 0, 1, 0, 'property.city'),
('address', 'country', 2, 'identifier', 'country', 0, 1, 1, 1, 0, 1, 0, 'property.country'),
('address', 'street', 0, 'text', NULL, 1, 1, 1, 1, 0, 1, 0, 'property.street');

-- --------------------------------------------------------

--
-- Table structure for table `ark_format_string`
--

CREATE TABLE `ark_format_string` (
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pattern` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `min_length` int(11) NOT NULL,
  `max_length` int(11) NOT NULL,
  `default_size` int(11) NOT NULL,
  `spellcheck` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_format_string`
--

INSERT INTO `ark_format_string` (`format`, `pattern`, `min_length`, `max_length`, `default_size`, `spellcheck`) VALUES
('color', '^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$', 4, 7, 10, 0),
('email', '^(?!^.{254})(([^@]+)@([^@]+))$', 3, 254, 30, 0),
('html', '', 1, 1431655765, 30, 1),
('identifier', '^(\\w{1,30})$', 1, 30, 30, 0),
('key', '^(\\w{1,50})$', 1, 50, 50, 0),
('markdown', '', 1, 1431655765, 30, 1),
('module', '^(\\w{1,3})$', 3, 3, 3, 0),
('password', '', 1, 255, 30, 0),
('richtext', '', 1, 1431655765, 30, 1),
('search', '', 3, 100, 30, 0),
('shorttext', '', 1, 100, 30, 1),
('string', '', 1, 1431655765, 30, 1),
('telephone', '^([0-9+\\(\\)#\\.\\s\\/x-]+)$', 1, 30, 30, 0),
('text', '', 1, 1431655765, 30, 1),
('url', '', 1, 2083, 50, 0),
('yearmonth', '^([0-9]{4})-(1[0-2]|0[1-9])$', 6, 7, 7, 0),
('yearweek', '^([0-9]{4})-W(5[0-3]|[1-4][0-9]|0[1-9])$', 7, 8, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_property`
--

CREATE TABLE `ark_fragment_property` (
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_property`
--

INSERT INTO `ark_fragment_property` (`type`, `property`, `field`, `format`, `vocabulary`, `enabled`, `deprecated`, `keyword`) VALUES
('item', 'id', 'value', 'identifier', NULL, 1, 0, 'property.id'),
('item', 'module', 'parameter', 'module', NULL, 1, 0, 'property.module'),
('text', 'content', 'value', 'text', NULL, 1, 0, 'property.content'),
('text', 'language', 'paramater', 'identifier', 'language', 1, 0, 'property.language');

-- --------------------------------------------------------

--
-- Table structure for table `ark_fragment_type`
--

CREATE TABLE `ark_fragment_type` (
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `format_class` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_fragment_type`
--

INSERT INTO `ark_fragment_type` (`type`, `format_class`, `tbl`, `enabled`, `deprecated`, `keyword`) VALUES
('blob', 'ARK\\Model\\Format\\BlobFormat', 'ark_fragment_blob', 1, 0, 'fragment.blob'),
('boolean', 'ARK\\Model\\Format\\BooleanFormat', 'ark_fragment_boolean', 1, 0, 'fragment.boolean'),
('date', 'ARK\\Model\\Format\\DateFormat', 'ark_fragment_date', 1, 0, 'fragment.date'),
('datetime', 'ARK\\Model\\Format\\DateTimeFormat', 'ark_fragment_datetime', 1, 0, 'fragment.datetime'),
('decimal', 'ARK\\Model\\Format\\DecimalFormat', 'ark_fragment_decimal', 1, 0, 'fragment.decimal'),
('float', 'ARK\\Model\\Format\\FloatFormat', 'ark_fragment_float', 1, 0, 'fragment.float'),
('geometry', 'ARK\\Model\\Format\\GeometryFormat', 'ark_fragment_geometry', 1, 0, 'fragment.geometry'),
('integer', 'ARK\\Model\\Format\\IntegerFormat', 'ark_fragment_integer', 1, 0, 'fragment.integer'),
('item', 'ARK\\Model\\Format\\ItemFormat', 'ark_fragment_item', 1, 0, 'fragment.item'),
('object', 'ARK\\Model\\Format\\ObjectFormat', 'ark_fragment_object', 1, 0, 'fragment.object'),
('string', 'ARK\\Model\\Format\\StringFormat', 'ark_fragment_string', 1, 0, 'fragment.string'),
('text', 'ARK\\Model\\Format\\TextFormat', 'ark_fragment_text', 1, 0, 'fragment.text'),
('time', 'ARK\\Model\\Format\\TimeFormat', 'ark_fragment_time', 1, 0, 'fragment.time');

-- --------------------------------------------------------

--
-- Table structure for table `ark_module`
--

CREATE TABLE `ark_module` (
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `resource` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tbl` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `core` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL,
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_module`
--

INSERT INTO `ark_module` (`module`, `resource`, `tbl`, `core`, `enabled`, `deprecated`, `keyword`) VALUES
('actor', 'actors', 'ark_item_actor', 1, 1, 0, 'module.actor'),
('campaign', 'campaigns', 'ark_item_campaign', 0, 1, 0, 'module.campaign'),
('file', 'files', 'ark_item_file', 1, 1, 0, 'module.file'),
('find', 'finds', 'ark_item_find', 0, 1, 0, 'module.find'),
('image', 'images', 'ark_item_image', 0, 1, 0, 'module.image'),
('location', 'locations', 'ark_item_location', 0, 1, 0, 'module.location');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema`
--

CREATE TABLE `ark_schema` (
  `schma` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `generator` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_subtypes` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_schema`
--

INSERT INTO `ark_schema` (`schma`, `module`, `entity`, `generator`, `sequence`, `use_subtypes`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'actor', 'ARK\\Model\\Actor', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 1, 1, 0, 'schema.actor'),
('core.file', 'file', 'ARK\\File\\File', 'ARK\\ORM\\Id\\IdentityGenerator', '', 1, 1, 0, 'schema.file'),
('dime.campaign', 'campaign', 'DIME\\Model\\Campaign', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 0, 1, 0, 'dime.campaign'),
('dime.find', 'find', 'DIME\\Model\\Find', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 0, 1, 0, 'dime.schema.find'),
('dime.image', 'image', 'DIME\\Model\\Image', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 0, 1, 0, 'dime.schema.image'),
('dime.location', 'location', 'DIME\\Model\\Location', 'ARK\\Model\\Entity\\ItemSequenceGenerator', 'id', 0, 1, 0, 'dime.schema.location');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_association`
--

CREATE TABLE `ark_schema_association` (
  `schma` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `association` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `degree` int(11) NOT NULL,
  `inverse` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inverse_degree` int(11) NOT NULL,
  `bidirectional` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_schema_association`
--

INSERT INTO `ark_schema_association` (`schma`, `subtype`, `association`, `degree`, `inverse`, `inverse_degree`, `bidirectional`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'institution', 'contact', 0, 'core.actor', 1, 0, 1, 0, 'association.contact'),
('dime.location', '', 'campaigns', 1, 'dime.campaign', 0, 1, 1, 0, 'dime.association.campaigns');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_property`
--

CREATE TABLE `ark_schema_property` (
  `schma` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `vocabulary` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `minimum` int(11) NOT NULL DEFAULT '0',
  `maximum` int(11) NOT NULL DEFAULT '1',
  `unique_values` int(11) NOT NULL DEFAULT '1',
  `additional_values` int(11) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_schema_property`
--

INSERT INTO `ark_schema_property` (`schma`, `subtype`, `property`, `format`, `vocabulary`, `minimum`, `maximum`, `unique_values`, `additional_values`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', '', 'address', 'address', NULL, 0, 0, 1, 0, 1, 0, 'property.address'),
('core.actor', '', 'initials', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.initials'),
('core.actor', '', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('core.actor', '', 'telephone', 'telephone', NULL, 0, 1, 1, 0, 1, 0, 'property.phone'),
('core.actor', 'institution', 'logo', 'blob', NULL, 0, 1, 1, 0, 1, 0, 'property.logo'),
('core.actor', 'person', 'avatar', 'blob', NULL, 0, 1, 1, 0, 1, 0, 'property.avatar'),
('core.actor', 'person', 'dateofbirth', 'date', NULL, 0, 1, 1, 0, 1, 0, 'property.dateofbirth'),
('core.file', '', 'description', 'text', NULL, 0, 1, 1, 0, 1, 0, 'property.description'),
('core.file', '', 'title', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.title'),
('dime.campaign', '', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('dime.find', '', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('dime.image', '', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name'),
('dime.location', '', 'name', 'shorttext', NULL, 1, 1, 1, 0, 1, 0, 'property.name');

-- --------------------------------------------------------

--
-- Table structure for table `ark_schema_subtype`
--

CREATE TABLE `ark_schema_subtype` (
  `schma` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `entity` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_schema_subtype`
--

INSERT INTO `ark_schema_subtype` (`schma`, `subtype`, `entity`, `enabled`, `deprecated`, `keyword`) VALUES
('core.actor', 'institution', 'ARK\\Model\\Actor\\Institution', 1, 0, 'core.actor.institution'),
('core.actor', 'person', 'ARK\\Model\\Actor\\Person', 1, 0, 'core.actor.person'),
('core.file', 'audio', 'ARK\\File\\AudioFile', 1, 0, 'file.type.audio'),
('core.file', 'document', 'ARK\\File\\DocumentFile', 1, 0, 'file.type.document'),
('core.file', 'image', 'ARK\\File\\Image', 1, 0, 'file.type.image'),
('core.file', 'other', 'ARK\\File\\OtherFile', 1, 0, 'file.type.other'),
('core.file', 'text', 'ARK\\File\\TextFile', 1, 0, 'file.type.text'),
('core.file', 'video', 'ARK\\File\\VideoFile', 1, 0, 'file.type.video');

-- --------------------------------------------------------

--
-- Table structure for table `ark_translation`
--

CREATE TABLE `ark_translation` (
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `is_plural` tinyint(1) NOT NULL DEFAULT '0',
  `has_parameters` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_translation`
--

INSERT INTO `ark_translation` (`keyword`, `domain`, `is_plural`, `has_parameters`) VALUES
('association.contact', 'core', 0, 0),
('core.actor.institution', 'core', 0, 0),
('core.actor.person', 'core', 0, 0),
('dime.association.campaigns', 'dime', 0, 0),
('dime.campaign', 'dime', 0, 0),
('dime.schema.find', 'dime', 0, 0),
('dime.schema.image', 'dime', 0, 0),
('dime.schema.location', 'dime', 0, 0),
('file.type.audio', 'core', 0, 0),
('file.type.document', 'core', 0, 0),
('file.type.image', 'core', 0, 0),
('file.type.other', 'core', 0, 0),
('file.type.text', 'core', 0, 0),
('file.type.video', 'core', 0, 0),
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
('property.logo', 'core', 0, 0),
('property.module', 'core', 0, 0),
('property.name', 'core', 0, 0),
('property.phone', 'core', 0, 0),
('property.street', 'core', 0, 0),
('property.title', 'core', 0, 0),
('schema.actor', 'core', 0, 0),
('schema.file', 'core', 0, 0),
('search.placeholder', 'core', 0, 0),
('site.brand', 'core', 0, 0),
('site.welcome', 'core', 0, 0),
('user.greeting', 'user', 0, 1),
('user.menu.edit', 'user', 0, 0),
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
  `domain` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `markup` tinyint(1) NOT NULL,
  `vocabulary` tinyint(1) NOT NULL,
  `text` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_translation_message`
--

INSERT INTO `ark_translation_message` (`language`, `keyword`, `role`, `text`, `notes`) VALUES
('en', 'association.contact', 'default', 'Contact', ''),
('en', 'core.actor.institution', 'default', 'Institution', ''),
('en', 'core.actor.person', 'default', 'Person', ''),
('en', 'dime.association.campaigns', 'default', 'Campaigns', ''),
('en', 'dime.campaign', 'default', 'Campaign', ''),
('en', 'dime.schema.find', 'default', 'Find', ''),
('en', 'dime.schema.image', 'default', 'Image', ''),
('en', 'dime.schema.location', 'default', 'Location', ''),
('en', 'file.type.audio', 'default', 'Audio File', ''),
('en', 'file.type.document', 'default', 'Document File', ''),
('en', 'file.type.image', 'default', 'Image File', ''),
('en', 'file.type.other', 'default', 'Other File', ''),
('en', 'file.type.text', 'default', 'Text File', ''),
('en', 'file.type.video', 'default', 'Video File', ''),
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
('en', 'property.logo', 'default', 'Logo', ''),
('en', 'property.module', 'default', 'Module', ''),
('en', 'property.name', 'default', 'Name', ''),
('en', 'property.phone', 'default', 'Phone', ''),
('en', 'property.street', 'default', 'Street', ''),
('en', 'property.title', 'default', 'Title', ''),
('en', 'schema.actor', 'default', 'Actor', ''),
('en', 'schema.file', 'default', 'File', ''),
('en', 'search.placeholder', 'default', 'Search...', ''),
('en', 'site.brand', 'default', 'DIME', ''),
('en', 'site.welcome', 'default', 'Welcome to DIME.', ''),
('en', 'user.greeting', 'default', 'Hello, %name%!', ''),
('en', 'user.menu.edit', 'default', 'Edit your profile', ''),
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
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `parameter` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `element` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `schma` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `form` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_element_type`
--

CREATE TABLE `ark_view_element_type` (
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `is_group` tinyint(1) NOT NULL DEFAULT '0',
  `tbl` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_view_group`
--

CREATE TABLE `ark_view_group` (
  `element` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `row` int(11) NOT NULL,
  `col` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `modtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `child` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary`
--

CREATE TABLE `ark_vocabulary` (
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_vocabulary`
--

INSERT INTO `ark_vocabulary` (`concept`, `type`, `source`, `closed`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
('country', 'list', 'ISO3166', 1, 1, 0, 'vocabulary.country', 'ISO Country Codes'),
('dime.period', 'taxonomy', 'DIME', 1, 1, 0, 'vocabulary.dime.period', 'DIME Period Taxonomy'),
('language', 'list', 'ISO639', 1, 1, 0, 'vocabulary.language', 'ISO Language Codes');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_collected`
--

CREATE TABLE `ark_vocabulary_collected` (
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `collection` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `seq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `collection` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `label` text COLLATE utf8_unicode_ci NOT NULL,
  `ordered` tinyint(1) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_meta`
--

CREATE TABLE `ark_vocabulary_meta` (
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_meta`
--

INSERT INTO `ark_vocabulary_meta` (`concept`, `term`, `property`, `type`, `value`) VALUES
('dime.period', 'AÆAX', 'year_from', 'int', '-10500'),
('dime.period', 'AÆAX', 'year_to', 'int', '-9000'),
('dime.period', 'AÆBX', 'year_from', 'int', '-11000'),
('dime.period', 'AÆBX', 'year_to', 'int', '-10500'),
('dime.period', 'AÆEÆ', 'year_from', 'int', '-5400'),
('dime.period', 'AÆEÆ', 'year_to', 'int', '-4800'),
('dime.period', 'AÆEM', 'year_from', 'int', '-4800'),
('dime.period', 'AÆEM', 'year_to', 'int', '-4300'),
('dime.period', 'AÆEX', 'year_from', 'int', '-5400'),
('dime.period', 'AÆEX', 'year_to', 'int', '-3900'),
('dime.period', 'AÆEY', 'year_from', 'int', '-4300'),
('dime.period', 'AÆEY', 'year_to', 'int', '-3900'),
('dime.period', 'AÆFX', 'year_from', 'int', '-12000'),
('dime.period', 'AÆFX', 'year_to', 'int', '-11000'),
('dime.period', 'AÆHX', 'year_from', 'int', '-12800'),
('dime.period', 'AÆHX', 'year_to', 'int', '-12000'),
('dime.period', 'AÆKÆ', 'year_from', 'int', '-6400'),
('dime.period', 'AÆKÆ', 'year_to', 'int', '-6000'),
('dime.period', 'AÆKM', 'year_from', 'int', '-6000'),
('dime.period', 'AÆKM', 'year_to', 'int', '-5700'),
('dime.period', 'AÆKX', 'year_from', 'int', '-6400'),
('dime.period', 'AÆKX', 'year_to', 'int', '-5400'),
('dime.period', 'AÆKY', 'year_from', 'int', '-5700'),
('dime.period', 'AÆKY', 'year_to', 'int', '-5400'),
('dime.period', 'AÆMÆ', 'year_from', 'int', '-9000'),
('dime.period', 'AÆMÆ', 'year_to', 'int', '-7800'),
('dime.period', 'AÆMM', 'year_from', 'int', '-7800'),
('dime.period', 'AÆMM', 'year_to', 'int', '-7000'),
('dime.period', 'AÆMX', 'year_from', 'int', '-9000'),
('dime.period', 'AÆMX', 'year_to', 'int', '-6400'),
('dime.period', 'AÆMY', 'year_from', 'int', '-7000'),
('dime.period', 'AÆMY', 'year_to', 'int', '-6400'),
('dime.period', 'AÆPÆ', 'year_from', 'int', '-250000'),
('dime.period', 'AÆPÆ', 'year_to', 'int', '-150000'),
('dime.period', 'AÆPM', 'year_from', 'int', '-150000'),
('dime.period', 'AÆPM', 'year_to', 'int', '-70000'),
('dime.period', 'AÆPY', 'year_from', 'int', '-70000'),
('dime.period', 'AÆPY', 'year_to', 'int', '-9000'),
('dime.period', 'AMXX', 'year_from', 'int', '-9000'),
('dime.period', 'AMXX', 'year_to', 'int', '-3900'),
('dime.period', 'ATM1', 'year_from', 'int', '-3300'),
('dime.period', 'ATM1', 'year_to', 'int', '-3100'),
('dime.period', 'ATM2', 'year_from', 'int', '-3100'),
('dime.period', 'ATM2', 'year_to', 'int', '-3000'),
('dime.period', 'ATM3', 'year_from', 'int', '-3000'),
('dime.period', 'ATM3', 'year_to', 'int', '-2900'),
('dime.period', 'ATM4', 'year_from', 'int', '-3000'),
('dime.period', 'ATM4', 'year_to', 'int', '-2900'),
('dime.period', 'ATM5', 'year_from', 'int', '-2900'),
('dime.period', 'ATM5', 'year_to', 'int', '-2800'),
('dime.period', 'ATNA', 'year_from', 'int', '-3900'),
('dime.period', 'ATNA', 'year_to', 'int', '-3700'),
('dime.period', 'ATNB', 'year_from', 'int', '-3700'),
('dime.period', 'ATNB', 'year_to', 'int', '-3500'),
('dime.period', 'ATNC', 'year_from', 'int', '-3500'),
('dime.period', 'ATNC', 'year_to', 'int', '-3300'),
('dime.period', 'AXXX', 'year_from', 'int', '-250000'),
('dime.period', 'AXXX', 'year_to', 'int', '-1700'),
('dime.period', 'AYEÆ', 'year_from', 'int', '-2800'),
('dime.period', 'AYEÆ', 'year_to', 'int', '-2600'),
('dime.period', 'AYEM', 'year_from', 'int', '-2600'),
('dime.period', 'AYEM', 'year_to', 'int', '-2450'),
('dime.period', 'AYEX', 'year_from', 'int', '-2800'),
('dime.period', 'AYEX', 'year_to', 'int', '-2350'),
('dime.period', 'AYEY', 'year_from', 'int', '-2450'),
('dime.period', 'AYEY', 'year_to', 'int', '-2350'),
('dime.period', 'AYGX', 'year_from', 'int', '-2900'),
('dime.period', 'AYGX', 'year_to', 'int', '-2600'),
('dime.period', 'AYKX', 'year_from', 'int', '-2350'),
('dime.period', 'AYKX', 'year_to', 'int', '-1950'),
('dime.period', 'AYSÆ', 'year_from', 'int', '-2350'),
('dime.period', 'AYSÆ', 'year_to', 'int', '-1950'),
('dime.period', 'AYSX', 'year_from', 'int', '-2350'),
('dime.period', 'AYSX', 'year_to', 'int', '-1700'),
('dime.period', 'AYSY', 'year_from', 'int', '-1950'),
('dime.period', 'AYSY', 'year_to', 'int', '-1700'),
('dime.period', 'AYTÆ', 'year_from', 'int', '-3900'),
('dime.period', 'AYTÆ', 'year_to', 'int', '-3300'),
('dime.period', 'AYTM', 'year_from', 'int', '-3300'),
('dime.period', 'AYTM', 'year_to', 'int', '-2800'),
('dime.period', 'AYTX', 'year_from', 'int', '-3900'),
('dime.period', 'AYTX', 'year_to', 'int', '-2800'),
('dime.period', 'AYXX', 'year_from', 'int', '-3900'),
('dime.period', 'AYXX', 'year_to', 'int', '-1700'),
('dime.period', 'BÆX1', 'year_from', 'int', '-1700'),
('dime.period', 'BÆX1', 'year_to', 'int', '-1500'),
('dime.period', 'BÆX2', 'year_from', 'int', '-1500'),
('dime.period', 'BÆX2', 'year_to', 'int', '-1300'),
('dime.period', 'BÆX3', 'year_from', 'int', '-1300'),
('dime.period', 'BÆX3', 'year_to', 'int', '-1100'),
('dime.period', 'BÆXX', 'year_from', 'int', '-1700'),
('dime.period', 'BÆXX', 'year_to', 'int', '-1100'),
('dime.period', 'BXXX', 'year_from', 'int', '-1700'),
('dime.period', 'BXXX', 'year_to', 'int', '-500'),
('dime.period', 'BYX4', 'year_from', 'int', '-1100'),
('dime.period', 'BYX4', 'year_to', 'int', '-900'),
('dime.period', 'BYX5', 'year_from', 'int', '-900'),
('dime.period', 'BYX5', 'year_to', 'int', '-700'),
('dime.period', 'BYX6', 'year_from', 'int', '-700'),
('dime.period', 'BYX6', 'year_to', 'int', '-500'),
('dime.period', 'BYXX', 'year_from', 'int', '-1100'),
('dime.period', 'BYXX', 'year_to', 'int', '-500'),
('dime.period', 'CÆFÆ', 'year_from', 'int', '-500'),
('dime.period', 'CÆFÆ', 'year_to', 'int', '-400'),
('dime.period', 'CÆFM', 'year_from', 'int', '-400'),
('dime.period', 'CÆFM', 'year_to', 'int', '-100'),
('dime.period', 'CÆFX', 'year_from', 'int', '-500'),
('dime.period', 'CÆFX', 'year_to', 'int', '0'),
('dime.period', 'CÆFY', 'year_from', 'int', '-100'),
('dime.period', 'CÆFY', 'year_to', 'int', '0'),
('dime.period', 'CÆRA', 'year_from', 'int', '1'),
('dime.period', 'CÆRA', 'year_to', 'int', '70'),
('dime.period', 'CÆRÆ', 'year_from', 'int', '1'),
('dime.period', 'CÆRÆ', 'year_to', 'int', '175'),
('dime.period', 'CÆRB', 'year_from', 'int', '70'),
('dime.period', 'CÆRB', 'year_to', 'int', '175'),
('dime.period', 'CÆRC', 'year_from', 'int', '175'),
('dime.period', 'CÆRC', 'year_to', 'int', '250'),
('dime.period', 'CÆRD', 'year_from', 'int', '250'),
('dime.period', 'CÆRD', 'year_to', 'int', '310'),
('dime.period', 'CÆRE', 'year_from', 'int', '310'),
('dime.period', 'CÆRE', 'year_to', 'int', '375'),
('dime.period', 'CÆRX', 'year_from', 'int', '1'),
('dime.period', 'CÆRX', 'year_to', 'int', '375'),
('dime.period', 'CÆRY', 'year_from', 'int', '175'),
('dime.period', 'CÆRY', 'year_to', 'int', '375'),
('dime.period', 'CÆXX', 'year_from', 'int', '-500'),
('dime.period', 'CÆXX', 'year_to', 'int', '375'),
('dime.period', 'CXXX', 'year_from', 'int', '-500'),
('dime.period', 'CXXX', 'year_to', 'int', '1066'),
('dime.period', 'CYGÆ', 'year_from', 'int', '375'),
('dime.period', 'CYGÆ', 'year_to', 'int', '600'),
('dime.period', 'CYGX', 'year_from', 'int', '375'),
('dime.period', 'CYGX', 'year_to', 'int', '750'),
('dime.period', 'CYGY', 'year_from', 'int', '600'),
('dime.period', 'CYGY', 'year_to', 'int', '750'),
('dime.period', 'CYVÆ', 'year_from', 'int', '750'),
('dime.period', 'CYVÆ', 'year_to', 'int', '900'),
('dime.period', 'CYVX', 'year_from', 'int', '750'),
('dime.period', 'CYVX', 'year_to', 'int', '1066'),
('dime.period', 'CYVY', 'year_from', 'int', '900'),
('dime.period', 'CYVY', 'year_to', 'int', '1066'),
('dime.period', 'CYXX', 'year_from', 'int', '375'),
('dime.period', 'CYXX', 'year_to', 'int', '1066'),
('dime.period', 'DÆX1', 'year_from', 'int', '1067'),
('dime.period', 'DÆX1', 'year_to', 'int', '1199'),
('dime.period', 'DÆX2', 'year_from', 'int', '1200'),
('dime.period', 'DÆX2', 'year_to', 'int', '1299'),
('dime.period', 'DÆXX', 'year_from', 'int', '1067'),
('dime.period', 'DÆXX', 'year_to', 'int', '1299'),
('dime.period', 'DXXX', 'year_from', 'int', '1067'),
('dime.period', 'DXXX', 'year_to', 'int', '1535'),
('dime.period', 'DYX3', 'year_from', 'int', '1300'),
('dime.period', 'DYX3', 'year_to', 'int', '1399'),
('dime.period', 'DYX4', 'year_from', 'int', '1400'),
('dime.period', 'DYX4', 'year_to', 'int', '1499'),
('dime.period', 'DYX5', 'year_from', 'int', '1500'),
('dime.period', 'DYX5', 'year_to', 'int', '1535'),
('dime.period', 'DYXX', 'year_from', 'int', '1300'),
('dime.period', 'DYXX', 'year_to', 'int', '1535'),
('dime.period', 'EXXX', 'year_from', 'int', '1536'),
('dime.period', 'EXXX', 'year_to', 'int', '1660'),
('dime.period', 'FÆXX', 'year_from', 'int', '1661'),
('dime.period', 'FÆXX', 'year_to', 'int', '1799'),
('dime.period', 'FMIN', 'year_from', 'int', '1800'),
('dime.period', 'FMIN', 'year_to', 'int', '1913'),
('dime.period', 'FMV1', 'year_from', 'int', '1914'),
('dime.period', 'FMV1', 'year_to', 'int', '1918'),
('dime.period', 'FMV2', 'year_from', 'int', '1940'),
('dime.period', 'FMV2', 'year_to', 'int', '1945'),
('dime.period', 'FMVM', 'year_from', 'int', '1919'),
('dime.period', 'FMVM', 'year_to', 'int', '1939'),
('dime.period', 'FXXX', 'year_from', 'int', '1661'),
('dime.period', 'FXXX', 'year_to', 'int', '2100'),
('dime.period', 'FYDI', 'year_from', 'int', '1990'),
('dime.period', 'FYDI', 'year_to', 'int', '2100'),
('dime.period', 'FYEL', 'year_from', 'int', '1960'),
('dime.period', 'FYEL', 'year_to', 'int', '1989'),
('dime.period', 'FYVE', 'year_from', 'int', '1946'),
('dime.period', 'FYVE', 'year_to', 'int', '1959'),
('dime.period', 'HXXX', 'year_from', 'int', '1067'),
('dime.period', 'HXXX', 'year_to', 'int', '0'),
('dime.period', 'OXXX', 'year_from', 'int', '-250000'),
('dime.period', 'OXXX', 'year_to', 'int', '1066'),
('dime.period', 'TM1A', 'year_from', 'int', '-3300'),
('dime.period', 'TM1A', 'year_to', 'int', '-3200'),
('dime.period', 'TM1B', 'year_from', 'int', '-3200'),
('dime.period', 'TM1B', 'year_to', 'int', '-3100'),
('dime.period', 'XXXX', 'year_from', 'int', '-250000'),
('dime.period', 'XXXX', 'year_to', 'int', '2100');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_related`
--

CREATE TABLE `ark_vocabulary_related` (
  `from_concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `from_term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `to_concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `to_term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `relation` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_related`
--

INSERT INTO `ark_vocabulary_related` (`from_concept`, `from_term`, `to_concept`, `to_term`, `relation`, `depth`) VALUES
('dime.period', 'AÆEX', 'dime.period', 'AÆEÆ', 'broader', 6),
('dime.period', 'AÆEX', 'dime.period', 'AÆEM', 'broader', 6),
('dime.period', 'AÆEX', 'dime.period', 'AÆEY', 'broader', 6),
('dime.period', 'AÆKX', 'dime.period', 'AÆKÆ', 'broader', 6),
('dime.period', 'AÆKX', 'dime.period', 'AÆKM', 'broader', 6),
('dime.period', 'AÆKX', 'dime.period', 'AÆKY', 'broader', 6),
('dime.period', 'AÆMX', 'dime.period', 'AÆMÆ', 'broader', 6),
('dime.period', 'AÆMX', 'dime.period', 'AÆMM', 'broader', 6),
('dime.period', 'AÆMX', 'dime.period', 'AÆMY', 'broader', 6),
('dime.period', 'AÆPY', 'dime.period', 'AÆAX', 'broader', 5),
('dime.period', 'AÆPY', 'dime.period', 'AÆBX', 'broader', 5),
('dime.period', 'AÆPY', 'dime.period', 'AÆFX', 'broader', 5),
('dime.period', 'AÆPY', 'dime.period', 'AÆHX', 'broader', 5),
('dime.period', 'AMXX', 'dime.period', 'AÆEX', 'broader', 5),
('dime.period', 'AMXX', 'dime.period', 'AÆKX', 'broader', 5),
('dime.period', 'AMXX', 'dime.period', 'AÆMX', 'broader', 5),
('dime.period', 'ATM1', 'dime.period', 'TM1A', 'broader', 8),
('dime.period', 'ATM1', 'dime.period', 'TM1B', 'broader', 8),
('dime.period', 'AYEX', 'dime.period', 'AYEÆ', 'broader', 6),
('dime.period', 'AYEX', 'dime.period', 'AYEM', 'broader', 6),
('dime.period', 'AYEX', 'dime.period', 'AYEY', 'broader', 6),
('dime.period', 'AYSÆ', 'dime.period', 'AYSÆ', 'broader', 6),
('dime.period', 'AYSÆ', 'dime.period', 'AYSY', 'broader', 6),
('dime.period', 'AYTÆ', 'dime.period', 'ATNA', 'broader', 7),
('dime.period', 'AYTÆ', 'dime.period', 'ATNB', 'broader', 7),
('dime.period', 'AYTÆ', 'dime.period', 'ATNC', 'broader', 7),
('dime.period', 'AYTM', 'dime.period', 'ATM1', 'broader', 7),
('dime.period', 'AYTM', 'dime.period', 'ATM2', 'broader', 7),
('dime.period', 'AYTM', 'dime.period', 'ATM3', 'broader', 7),
('dime.period', 'AYTM', 'dime.period', 'ATM4', 'broader', 7),
('dime.period', 'AYTM', 'dime.period', 'ATM5', 'broader', 7),
('dime.period', 'AYTX', 'dime.period', 'AYTÆ', 'broader', 6),
('dime.period', 'AYTX', 'dime.period', 'AYTM', 'broader', 6),
('dime.period', 'AYXX', 'dime.period', 'AYEX', 'broader', 5),
('dime.period', 'AYXX', 'dime.period', 'AYGX', 'broader', 5),
('dime.period', 'AYXX', 'dime.period', 'AYKX', 'broader', 5),
('dime.period', 'AYXX', 'dime.period', 'AYSX', 'broader', 5),
('dime.period', 'AYXX', 'dime.period', 'AYTX', 'broader', 5),
('dime.period', 'BÆXX', 'dime.period', 'BÆX1', 'broader', 5),
('dime.period', 'BÆXX', 'dime.period', 'BÆX2', 'broader', 5),
('dime.period', 'BÆXX', 'dime.period', 'BÆX3', 'broader', 5),
('dime.period', 'BXXX', 'dime.period', 'BÆXX', 'broader', 4),
('dime.period', 'BXXX', 'dime.period', 'BYXX', 'broader', 4),
('dime.period', 'BYXX', 'dime.period', 'BYX4', 'broader', 5),
('dime.period', 'BYXX', 'dime.period', 'BYX5', 'broader', 5),
('dime.period', 'BYXX', 'dime.period', 'BYX6', 'broader', 5),
('dime.period', 'CÆFX', 'dime.period', 'CÆFÆ', 'broader', 6),
('dime.period', 'CÆFX', 'dime.period', 'CÆFM', 'broader', 6),
('dime.period', 'CÆFX', 'dime.period', 'CÆFY', 'broader', 6),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRA', 'broader', 7),
('dime.period', 'CÆRÆ', 'dime.period', 'CÆRB', 'broader', 7),
('dime.period', 'CÆRX', 'dime.period', 'CÆRÆ', 'broader', 6),
('dime.period', 'CÆRX', 'dime.period', 'CÆRY', 'broader', 6),
('dime.period', 'CÆRY', 'dime.period', 'CÆRC', 'broader', 7),
('dime.period', 'CÆRY', 'dime.period', 'CÆRD', 'broader', 7),
('dime.period', 'CÆRY', 'dime.period', 'CÆRE', 'broader', 7),
('dime.period', 'CÆXX', 'dime.period', 'CÆFX', 'broader', 5),
('dime.period', 'CÆXX', 'dime.period', 'CÆRX', 'broader', 5),
('dime.period', 'CXXX', 'dime.period', 'CÆXX', 'broader', 4),
('dime.period', 'CXXX', 'dime.period', 'CYXX', 'broader', 4),
('dime.period', 'CYGX', 'dime.period', 'CYGÆ', 'broader', 6),
('dime.period', 'CYGX', 'dime.period', 'CYGY', 'broader', 6),
('dime.period', 'CYVX', 'dime.period', 'CYVÆ', 'broader', 6),
('dime.period', 'CYVX', 'dime.period', 'CYVY', 'broader', 6),
('dime.period', 'CYXX', 'dime.period', 'CYGX', 'broader', 5),
('dime.period', 'CYXX', 'dime.period', 'CYVX', 'broader', 5),
('dime.period', 'DÆXX', 'dime.period', 'DÆX1', 'broader', 5),
('dime.period', 'DÆXX', 'dime.period', 'DÆX2', 'broader', 5),
('dime.period', 'DXXX', 'dime.period', 'DÆXX', 'broader', 4),
('dime.period', 'DXXX', 'dime.period', 'DYXX', 'broader', 4),
('dime.period', 'DYXX', 'dime.period', 'DYX3', 'broader', 5),
('dime.period', 'DYXX', 'dime.period', 'DYX4', 'broader', 5),
('dime.period', 'DYXX', 'dime.period', 'DYX5', 'broader', 5),
('dime.period', 'FXXX', 'dime.period', 'FÆXX', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FMIN', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FMV1', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FMV2', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FMVM', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FYDI', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FYEL', 'broader', 4),
('dime.period', 'FXXX', 'dime.period', 'FYVE', 'broader', 4),
('dime.period', 'HXXX', 'dime.period', 'FXXX', 'broader', 3),
('dime.period', 'OXXX', 'dime.period', 'AÆPÆ', 'broader', 4),
('dime.period', 'OXXX', 'dime.period', 'AÆPM', 'broader', 4),
('dime.period', 'OXXX', 'dime.period', 'AÆPY', 'broader', 4),
('dime.period', 'OXXX', 'dime.period', 'AMXX', 'broader', 4),
('dime.period', 'OXXX', 'dime.period', 'AXXX', 'broader', 3),
('dime.period', 'OXXX', 'dime.period', 'AYXX', 'broader', 4),
('dime.period', 'OXXX', 'dime.period', 'BXXX', 'broader', 3),
('dime.period', 'OXXX', 'dime.period', 'CXXX', 'broader', 3),
('dime.period', 'OXXX', 'dime.period', 'DXXX', 'broader', 3),
('dime.period', 'OXXX', 'dime.period', 'EXXX', 'broader', 3),
('dime.period', 'XXXX', 'dime.period', 'HXXX', 'broader', 2),
('dime.period', 'XXXX', 'dime.period', 'OXXX', 'broader', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_relation`
--

CREATE TABLE `ark_vocabulary_relation` (
  `relation` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `recipricol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `recipricol_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `equivalence` tinyint(1) NOT NULL DEFAULT '0',
  `hierarchy` tinyint(1) NOT NULL DEFAULT '0',
  `associative` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `deprecated` tinyint(1) NOT NULL DEFAULT '0',
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_term`
--

INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
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
('dime.period', 'AÆAX', 'ahrensburg', 1, 0, 'dime.period.ahrensburg', 'Ahrensburgkultur'),
('dime.period', 'AÆBX', 'bromme', 1, 0, 'dime.period.bromme', 'Brommekultur'),
('dime.period', 'AÆEÆ', 'ertebølle.early', 1, 0, 'dime.period.ertebølle.early', 'Ældre Ertebøllekultur'),
('dime.period', 'AÆEM', 'ertebølle.middle', 1, 0, 'dime.period.ertebølle.middle', 'Mell. Ertebøllekultur'),
('dime.period', 'AÆEX', 'ertebølle', 1, 0, 'dime.period.ertebølle', 'Ertebøllekultur'),
('dime.period', 'AÆEY', 'ertebølle.late', 1, 0, 'dime.period.ertebølle.late', 'Yngre Ertebøllekultur'),
('dime.period', 'AÆFX', 'feder', 1, 0, 'dime.period.feder', 'Federmesser'),
('dime.period', 'AÆHX', 'hamburg', 1, 0, 'dime.period.hamburg', 'Hamburgkultur'),
('dime.period', 'AÆKÆ', 'kongemose.early', 1, 0, 'dime.period.kongemose.early', 'Ældre Kongemosekultur'),
('dime.period', 'AÆKM', 'kongemose.middle', 1, 0, 'dime.period.kongemose.middle', 'Mell. Kongemosekultur'),
('dime.period', 'AÆKX', 'kongemose', 1, 0, 'dime.period.kongemose', 'Kongemosekultur'),
('dime.period', 'AÆKY', 'kongemose.late', 1, 0, 'dime.period.kongemose.late', 'Yngre Kongemosekultur'),
('dime.period', 'AÆMÆ', 'maglemosian.early', 1, 0, 'dime.period.maglemosian.early', 'Ældre Maglemosekultur'),
('dime.period', 'AÆMM', 'maglemosian.middle', 1, 0, 'dime.period.maglemosian.middle', 'Mell. Maglemosekultur'),
('dime.period', 'AÆMX', 'maglemosian', 1, 0, 'dime.period.maglemosian', 'Maglemosekultur'),
('dime.period', 'AÆMY', 'maglemosian.late', 1, 0, 'dime.period.maglemosian.late', 'Yngre Maglemosekultur'),
('dime.period', 'AÆPÆ', 'palaeolithic.early', 1, 0, 'dime.period.palaeolithic.early', 'Ældre Palæolitikum'),
('dime.period', 'AÆPM', 'palaeolithic.middle', 1, 0, 'dime.period.palaeolithic.middle', 'Mellempalæolitikum'),
('dime.period', 'AÆPY', 'palaeolithic.late', 1, 0, 'dime.period.palaeolithic.late', 'Yngre-sen Palæolitikum'),
('dime.period', 'AMXX', 'mesolithic', 1, 0, 'dime.period.mesolithic', 'Mesolitikum'),
('dime.period', 'ATM1', 'funnelbeaker.middle.i', 1, 0, 'dime.period.funnelbeaker.middle.i', 'Mellemneolitisk Tragtbægerkultur I'),
('dime.period', 'ATM2', 'funnelbeaker.middle.ii', 1, 0, 'dime.period.funnelbeaker.middle.ii', 'Mellemneolitisk Tragtbægerkultur II'),
('dime.period', 'ATM3', 'funnelbeaker.middle.iii', 1, 0, 'dime.period.funnelbeaker.middle.iii', 'Mellemneolitisk Tragtbægerkultur III'),
('dime.period', 'ATM4', 'funnelbeaker.middle.iv', 1, 0, 'dime.period.funnelbeaker.middle.iv', 'Mellemneolitisk Tragtbægerkultur IV'),
('dime.period', 'ATM5', 'funnelbeaker.middle.v', 1, 0, 'dime.period.funnelbeaker.middle.v', 'Mellemneolitisk Tragtbægerkultur V'),
('dime.period', 'ATNA', 'funnelbeaker.early.a', 1, 0, 'dime.period.funnelbeaker.early.a', 'Tidligneolitisk Tragtbægerkultur A'),
('dime.period', 'ATNB', 'funnelbeaker.early.b', 1, 0, 'dime.period.funnelbeaker.early.b', 'Tidligneolitisk Tragtbægerkultur B'),
('dime.period', 'ATNC', 'funnelbeaker.early.c', 1, 0, 'dime.period.funnelbeaker.early.c', 'Tidligneolitisk Tragtbægerkultur C'),
('dime.period', 'AXXX', 'stoneage', 1, 0, 'dime.period.stoneage', 'Stenalder'),
('dime.period', 'AYEÆ', 'cordedware.early', 1, 0, 'dime.period.cordedware.early', 'Ældre Enkeltgravskultur'),
('dime.period', 'AYEM', 'cordedware.middle', 1, 0, 'dime.period.cordedware.middle', 'Mell. Enkeltgravskultur'),
('dime.period', 'AYEX', 'cordedware', 1, 0, 'dime.period.cordedware', 'Enkeltgravskultur'),
('dime.period', 'AYEY', 'cordedware.late', 1, 0, 'dime.period.cordedware.late', 'Yngre Enkeltgravskultur'),
('dime.period', 'AYGX', 'pittedware', 1, 0, 'dime.period.pittedware', 'Grubekeramisk kultur'),
('dime.period', 'AYKX', 'bellbeaker', 1, 0, 'dime.period.bellbeaker', 'Klokkebægerkultur'),
('dime.period', 'AYSÆ', 'lateneolithic.early', 1, 0, 'dime.period.lateneolithic.early', 'Ældre Senneolitikum'),
('dime.period', 'AYSX', 'lateneolithic', 1, 0, 'dime.period.lateneolithic', 'Senneolitikum'),
('dime.period', 'AYSY', 'lateneolithic.late', 1, 0, 'dime.period.lateneolithic.late', 'Yngre Senneolitikum'),
('dime.period', 'AYTÆ', 'funnelbeaker.early', 1, 0, 'dime.period.funnelbeaker.early', 'Ældre Tragtbægerkultur'),
('dime.period', 'AYTM', 'funnelbeaker.middle', 1, 0, 'dime.period.funnelbeaker.middle', 'Mellemneolitisk Tragtbægerkultur'),
('dime.period', 'AYTX', 'funnelbeaker', 1, 0, 'dime.period.funnelbeaker', 'Tragtbægerkultur'),
('dime.period', 'AYXX', 'stoneage.early', 1, 0, 'dime.period.stoneage.early', 'Yngre Stenalder'),
('dime.period', 'BÆX1', 'bronze.early.1', 1, 0, 'dime.period.bronze.early.1', 'Ældre Bronzealder per.1'),
('dime.period', 'BÆX2', 'bronze.early.2', 1, 0, 'dime.period.bronze.early.2', 'Ældre Bronzealder per.2'),
('dime.period', 'BÆX3', 'bronze.early.3', 1, 0, 'dime.period.bronze.early.3', 'Ældre Bronzealder per.3'),
('dime.period', 'BÆXX', 'bronze.early', 1, 0, 'dime.period.bronze.early', 'Ældre Bronzealder'),
('dime.period', 'BXXX', 'bronze', 1, 0, 'dime.period.bronze', 'Bronzealder'),
('dime.period', 'BYX4', 'bronze.late.4', 1, 0, 'dime.period.bronze.late.4', 'Yngre Bronzealder per.4'),
('dime.period', 'BYX5', 'bronze.late.5', 1, 0, 'dime.period.bronze.late.5', 'Yngre Bronzealder per.5'),
('dime.period', 'BYX6', 'bronze.late.6', 1, 0, 'dime.period.bronze.late.6', 'Yngre Bronzealder per.6'),
('dime.period', 'BYXX', 'bronze.late', 1, 0, 'dime.period.bronze.late', 'Yngre Bronzealder'),
('dime.period', 'CÆFÆ', 'ironage.preroman.early', 1, 0, 'dime.period.ironage.preroman.early', 'Ældre Førromersk Jernalder (per.1)'),
('dime.period', 'CÆFM', 'ironage.preroman.middle', 1, 0, 'dime.period.ironage.preroman.middle', 'Mell. Førromersk Jernalder (per.2)'),
('dime.period', 'CÆFX', 'ironage.preroman', 1, 0, 'dime.period.ironage.preroman', 'Førromersk Jernalder'),
('dime.period', 'CÆFY', 'ironage.preroman.late', 1, 0, 'dime.period.ironage.preroman.late', 'Yngre Førromersk Jernalder (per.3A)'),
('dime.period', 'CÆRA', 'ironage.roman.early.b1', 1, 0, 'dime.period.ironage.roman.early.b1', 'Ældre Romersk Jernalder, B1'),
('dime.period', 'CÆRÆ', 'ironage.roman.early', 1, 0, 'dime.period.ironage.roman.early', 'Ældre Romersk Jernalder'),
('dime.period', 'CÆRB', 'ironage.roman.early.b2', 1, 0, 'dime.period.ironage.roman.early.b2', 'Ældre Romersk Jernalder, B2'),
('dime.period', 'CÆRC', 'ironage.roman.late.c1', 1, 0, 'dime.period.ironage.roman.late.c1', 'Yngre Romersk Jernalder, C1'),
('dime.period', 'CÆRD', 'ironage.roman.late.c2', 1, 0, 'dime.period.ironage.roman.late.c2', 'Yngre Romersk Jernalder, C2'),
('dime.period', 'CÆRE', 'ironage.roman.late.c3', 1, 0, 'dime.period.ironage.roman.late.c3', 'Yngre Romersk Jernalder, C3'),
('dime.period', 'CÆRX', 'ironage.roman', 1, 0, 'dime.period.ironage.roman', 'Romersk Jernalder'),
('dime.period', 'CÆRY', 'ironage.roman.late', 1, 0, 'dime.period.ironage.roman.late', 'Yngre Romersk Jernalder'),
('dime.period', 'CÆXX', 'ironage.early', 1, 0, 'dime.period.ironage.early', 'Ældre Jernalder'),
('dime.period', 'CXXX', 'ironage', 1, 0, 'dime.period.ironage', 'Jernalder'),
('dime.period', 'CYGÆ', 'ironage.germanic.early', 1, 0, 'dime.period.ironage.germanic.early', 'Ældre Germansk Jernalder'),
('dime.period', 'CYGX', 'ironage.germanic', 1, 0, 'dime.period.ironage.germanic', 'Germansk Jernalder'),
('dime.period', 'CYGY', 'ironage.germanic.late', 1, 0, 'dime.period.ironage.germanic.late', 'Yngre Germansk Jernalder'),
('dime.period', 'CYVÆ', 'viking.early', 1, 0, 'dime.period.viking.early', 'Ældre Vikingetid'),
('dime.period', 'CYVX', 'viking', 1, 0, 'dime.period.viking', 'Vikingetid'),
('dime.period', 'CYVY', 'viking.late', 1, 0, 'dime.period.viking.late', 'Yngre Vikingetid'),
('dime.period', 'CYXX', 'ironage.late', 1, 0, 'dime.period.ironage.late', 'Yngre Jernalder (Germansk jernalder og Vikingetid)'),
('dime.period', 'DÆX1', 'medieval.early.c12th', 1, 0, 'dime.period.medieval.early.c12th', 'Ældre middelalder (1067 - 1100-tal)'),
('dime.period', 'DÆX2', 'medieval.early.c13th', 1, 0, 'dime.period.medieval.early.c13th', 'Ældre middelalder (1200-tal)'),
('dime.period', 'DÆXX', 'medieval.early', 1, 0, 'dime.period.medieval.early', 'Ældre Middelalder (1066 - 1300)'),
('dime.period', 'DXXX', 'medieval', 1, 0, 'dime.period.medieval', 'Middelalder'),
('dime.period', 'DYX3', 'medieval.late.c14th', 1, 0, 'dime.period.medieval.late.c14th', 'Yngre middelalder (1300-tal)'),
('dime.period', 'DYX4', 'medieval.late.c15th', 1, 0, 'dime.period.medieval.late.c15th', 'Yngre middelalder (1400-tal)'),
('dime.period', 'DYX5', 'medieval.late.c16th', 1, 0, 'dime.period.medieval.late.c16th', 'Yngre middelalder (1500-tal)'),
('dime.period', 'DYXX', 'medieval.late', 1, 0, 'dime.period.medieval.late', 'Yngre Middelalder (1250 - 1535)'),
('dime.period', 'EXXX', 'reformation', 1, 0, 'dime.period.reformation', 'Efterreformatorisk tid (1536-1660)'),
('dime.period', 'FÆXX', 'modern.c17th', 1, 0, 'dime.period.modern.c17th', 'Nyere tid, 1600-1700 tallet'),
('dime.period', 'FMIN', 'modern.industrial', 1, 0, 'dime.period.modern.industrial', 'Nyere tid, industrialismen'),
('dime.period', 'FMV1', 'modern.ww1', 1, 0, 'dime.period.modern.ww1', '1914-18, 1. Verdenskrig'),
('dime.period', 'FMV2', 'modern.ww2', 1, 0, 'dime.period.modern.ww2', '1940-45, 2. Verdenskrig'),
('dime.period', 'FMVM', 'modern.interwar', 1, 0, 'dime.period.modern.interwar', '1919-39, Mellemskrigstiden'),
('dime.period', 'FXXX', 'modern', 1, 0, 'dime.period.modern', 'Nyere tid (1661 - )'),
('dime.period', 'FYDI', 'modern.digital', 1, 0, 'dime.period.modern.digital', 'Nyere tid, digital gennembrud'),
('dime.period', 'FYEL', 'modern.electronic', 1, 0, 'dime.period.modern.electronic', 'Nyere tid, elektronisk gennembrud'),
('dime.period', 'FYVE', 'modern.postwar', 1, 0, 'dime.period.modern.postwar', 'Nyere tid, efterkrigstiden'),
('dime.period', 'HXXX', 'historic', 1, 0, 'dime.period.historic', 'Historisk tid (1067 -)'),
('dime.period', 'OXXX', 'prehistoric', 1, 0, 'dime.period.prehistoric', 'Oldtid'),
('dime.period', 'TM1A', 'funnelbeaker.middle.ia', 1, 0, 'dime.period.funnelbeaker.middle.ia', 'Mellemneolitisk Tragtbægerkultur 1A'),
('dime.period', 'TM1B', 'funnelbeaker.middle.ib', 1, 0, 'dime.period.funnelbeaker.middle.ib', 'Mellemneolitisk Tragtbægerkultur 1B'),
('dime.period', 'XXXX', 'undated', 1, 0, 'dime.period.undated', 'Udateret'),
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
('language', 'lb', 'luxembourgish', 1, 0, 'language.luxembourgish', ''),
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
('language', 'nzi', 'nzima', 1, 0, 'language.nzima', '');
INSERT INTO `ark_vocabulary_term` (`concept`, `term`, `alias`, `enabled`, `deprecated`, `keyword`, `description`) VALUES
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
('language', 'zza', 'zaza', 1, 0, 'language.zaza', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_translation`
--

CREATE TABLE `ark_vocabulary_translation` (
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ark_vocabulary_translation`
--

INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
('da', 'vocabulary', 'dime.period.ahrensburg', 'default', 'Ahrensburgkultur', ''),
('da', 'vocabulary', 'dime.period.bellbeaker', 'default', 'Klokkebægerkultur', ''),
('da', 'vocabulary', 'dime.period.bromme', 'default', 'Brommekultur', ''),
('da', 'vocabulary', 'dime.period.bronze', 'default', 'Bronzealder', ''),
('da', 'vocabulary', 'dime.period.bronze.early', 'default', 'Ældre Bronzealder', ''),
('da', 'vocabulary', 'dime.period.bronze.early.1', 'default', 'Ældre Bronzealder per.1', ''),
('da', 'vocabulary', 'dime.period.bronze.early.2', 'default', 'Ældre Bronzealder per.2', ''),
('da', 'vocabulary', 'dime.period.bronze.early.3', 'default', 'Ældre Bronzealder per.3', ''),
('da', 'vocabulary', 'dime.period.bronze.late', 'default', 'Yngre Bronzealder', ''),
('da', 'vocabulary', 'dime.period.bronze.late.4', 'default', 'Yngre Bronzealder per.4', ''),
('da', 'vocabulary', 'dime.period.bronze.late.5', 'default', 'Yngre Bronzealder per.5', ''),
('da', 'vocabulary', 'dime.period.bronze.late.6', 'default', 'Yngre Bronzealder per.6', ''),
('da', 'vocabulary', 'dime.period.cordedware', 'default', 'Enkeltgravskultur', ''),
('da', 'vocabulary', 'dime.period.cordedware.early', 'default', 'Ældre Enkeltgravskultur', ''),
('da', 'vocabulary', 'dime.period.cordedware.late', 'default', 'Yngre Enkeltgravskultur', ''),
('da', 'vocabulary', 'dime.period.cordedware.middle', 'default', 'Mell. Enkeltgravskultur', ''),
('da', 'vocabulary', 'dime.period.ertebølle', 'default', 'Ertebøllekultur', ''),
('da', 'vocabulary', 'dime.period.ertebølle.early', 'default', 'Ældre Ertebøllekultur', ''),
('da', 'vocabulary', 'dime.period.ertebølle.late', 'default', 'Yngre Ertebøllekultur', ''),
('da', 'vocabulary', 'dime.period.ertebølle.middle', 'default', 'Mell. Ertebøllekultur', ''),
('da', 'vocabulary', 'dime.period.feder', 'default', 'Federmesser', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker', 'default', 'Tragtbægerkultur', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.early', 'default', 'Ældre Tragtbægerkultur', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.early.a', 'default', 'Tidligneolitisk Tragtbægerkultur A', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.early.b', 'default', 'Tidligneolitisk Tragtbægerkultur B', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.early.c', 'default', 'Tidligneolitisk Tragtbægerkultur C', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle', 'default', 'Mellemneolitisk Tragtbægerkultur', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.i', 'default', 'Mellemneolitisk Tragtbægerkultur I', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.ia', 'default', 'Mellemneolitisk Tragtbægerkultur 1A', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.ib', 'default', 'Mellemneolitisk Tragtbægerkultur 1B', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.ii', 'default', 'Mellemneolitisk Tragtbægerkultur II', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.iii', 'default', 'Mellemneolitisk Tragtbægerkultur III', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.iv', 'default', 'Mellemneolitisk Tragtbægerkultur IV', ''),
('da', 'vocabulary', 'dime.period.funnelbeaker.middle.v', 'default', 'Mellemneolitisk Tragtbægerkultur V', ''),
('da', 'vocabulary', 'dime.period.hamburg', 'default', 'Hamburgkultur', ''),
('da', 'vocabulary', 'dime.period.historic', 'default', 'Historisk tid (1067 -)', ''),
('da', 'vocabulary', 'dime.period.ironage', 'default', 'Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.early', 'default', 'Ældre Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.germanic', 'default', 'Germansk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.germanic.early', 'default', 'Ældre Germansk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.germanic.late', 'default', 'Yngre Germansk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.late', 'default', 'Yngre Jernalder (Germansk jernalder og Vikingetid)', ''),
('da', 'vocabulary', 'dime.period.ironage.preroman', 'default', 'Førromersk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.preroman.early', 'default', 'Ældre Førromersk Jernalder (per.1)', ''),
('da', 'vocabulary', 'dime.period.ironage.preroman.late', 'default', 'Yngre Førromersk Jernalder (per.3A)', ''),
('da', 'vocabulary', 'dime.period.ironage.preroman.middle', 'default', 'Mell. Førromersk Jernalder (per.2)', ''),
('da', 'vocabulary', 'dime.period.ironage.roman', 'default', 'Romersk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.early', 'default', 'Ældre Romersk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.early.b1', 'default', 'Ældre Romersk Jernalder, B1', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.early.b2', 'default', 'Ældre Romersk Jernalder, B2', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.late', 'default', 'Yngre Romersk Jernalder', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.late.c1', 'default', 'Yngre Romersk Jernalder, C1', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.late.c2', 'default', 'Yngre Romersk Jernalder, C2', ''),
('da', 'vocabulary', 'dime.period.ironage.roman.late.c3', 'default', 'Yngre Romersk Jernalder, C3', ''),
('da', 'vocabulary', 'dime.period.kongemose', 'default', 'Kongemosekultur', ''),
('da', 'vocabulary', 'dime.period.kongemose.early', 'default', 'Ældre Kongemosekultur', ''),
('da', 'vocabulary', 'dime.period.kongemose.late', 'default', 'Yngre Kongemosekultur', ''),
('da', 'vocabulary', 'dime.period.kongemose.middle', 'default', 'Mell. Kongemosekultur', ''),
('da', 'vocabulary', 'dime.period.lateneolithic', 'default', 'Senneolitikum', ''),
('da', 'vocabulary', 'dime.period.lateneolithic.early', 'default', 'Ældre Senneolitikum', ''),
('da', 'vocabulary', 'dime.period.lateneolithic.late', 'default', 'Yngre Senneolitikum', ''),
('da', 'vocabulary', 'dime.period.maglemosian', 'default', 'Maglemosekultur', ''),
('da', 'vocabulary', 'dime.period.maglemosian.early', 'default', 'Ældre Maglemosekultur', ''),
('da', 'vocabulary', 'dime.period.maglemosian.late', 'default', 'Yngre Maglemosekultur', ''),
('da', 'vocabulary', 'dime.period.maglemosian.middle', 'default', 'Mell. Maglemosekultur', ''),
('da', 'vocabulary', 'dime.period.medieval', 'default', 'Middelalder', ''),
('da', 'vocabulary', 'dime.period.medieval.early', 'default', 'Ældre Middelalder (1066 - 1300)', ''),
('da', 'vocabulary', 'dime.period.medieval.early.c12th', 'default', 'Ældre middelalder (1067 - 1100-tal)', ''),
('da', 'vocabulary', 'dime.period.medieval.early.c13th', 'default', 'Ældre middelalder (1200-tal)', ''),
('da', 'vocabulary', 'dime.period.medieval.late', 'default', 'Yngre Middelalder (1250 - 1535)', ''),
('da', 'vocabulary', 'dime.period.medieval.late.c14th', 'default', 'Yngre middelalder (1300-tal)', ''),
('da', 'vocabulary', 'dime.period.medieval.late.c15th', 'default', 'Yngre middelalder (1400-tal)', ''),
('da', 'vocabulary', 'dime.period.medieval.late.c16th', 'default', 'Yngre middelalder (1500-tal)', ''),
('da', 'vocabulary', 'dime.period.mesolithic', 'default', 'Mesolitikum', ''),
('da', 'vocabulary', 'dime.period.modern', 'default', 'Nyere tid (1661 - )', ''),
('da', 'vocabulary', 'dime.period.modern.c17th', 'default', 'Nyere tid, 1600-1700 tallet', ''),
('da', 'vocabulary', 'dime.period.modern.digital', 'default', 'Nyere tid, digital gennembrud', ''),
('da', 'vocabulary', 'dime.period.modern.electronic', 'default', 'Nyere tid, elektronisk gennembrud', ''),
('da', 'vocabulary', 'dime.period.modern.industrial', 'default', 'Nyere tid, industrialismen', ''),
('da', 'vocabulary', 'dime.period.modern.interwar', 'default', '1919-39, Mellemskrigstiden', ''),
('da', 'vocabulary', 'dime.period.modern.postwar', 'default', 'Nyere tid, efterkrigstiden', ''),
('da', 'vocabulary', 'dime.period.modern.ww1', 'default', '1914-18, 1. Verdenskrig', ''),
('da', 'vocabulary', 'dime.period.modern.ww2', 'default', '1940-45, 2. Verdenskrig', ''),
('da', 'vocabulary', 'dime.period.palaeolithic.early', 'default', 'Ældre Palæolitikum', ''),
('da', 'vocabulary', 'dime.period.palaeolithic.late', 'default', 'Yngre-sen Palæolitikum', ''),
('da', 'vocabulary', 'dime.period.palaeolithic.middle', 'default', 'Mellempalæolitikum', ''),
('da', 'vocabulary', 'dime.period.pittedware', 'default', 'Grubekeramisk kultur', ''),
('da', 'vocabulary', 'dime.period.prehistoric', 'default', 'Oldtid', ''),
('da', 'vocabulary', 'dime.period.reformation', 'default', 'Efterreformatorisk tid (1536-1660)', ''),
('da', 'vocabulary', 'dime.period.stoneage', 'default', 'Stenalder', ''),
('da', 'vocabulary', 'dime.period.stoneage.early', 'default', 'Yngre Stenalder', ''),
('da', 'vocabulary', 'dime.period.undated', 'default', 'Udateret', ''),
('da', 'vocabulary', 'dime.period.viking', 'default', 'Vikingetid', ''),
('da', 'vocabulary', 'dime.period.viking.early', 'default', 'Ældre Vikingetid', ''),
('da', 'vocabulary', 'dime.period.viking.late', 'default', 'Yngre Vikingetid', ''),
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
('en', 'vocabulary', 'language.mapuche', 'default', 'Mapuche', '');
INSERT INTO `ark_vocabulary_translation` (`language`, `domain`, `keyword`, `role`, `text`, `notes`) VALUES
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
('en', 'vocabulary', 'language.zuni', 'default', 'Zuni', '');

-- --------------------------------------------------------

--
-- Table structure for table `ark_vocabulary_type`
--

CREATE TABLE `ark_vocabulary_type` (
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `equivalence` tinyint(1) NOT NULL,
  `hierarchy` tinyint(1) NOT NULL,
  `association` tinyint(1) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `deprecated` tinyint(1) NOT NULL,
  `keyword` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `layout_role` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page`
--

CREATE TABLE `cor_conf_page` (
  `page` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `sgrp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `code_dir` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nav_seq` int(11) NOT NULL,
  `navname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nav_link_vars` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_conf_page_layout`
--

CREATE TABLE `cor_conf_page_layout` (
  `page` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `layout_role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `layout` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dime_period`
--

CREATE TABLE `dime_period` (
  `concept` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `term` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `depth` int(11) NOT NULL,
  `from_year` int(11) NOT NULL,
  `to_year` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Indexes for table `ark_format_geometry`
--
ALTER TABLE `ark_format_geometry`
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
-- Indexes for table `ark_format_property`
--
ALTER TABLE `ark_format_property`
  ADD PRIMARY KEY (`object`,`property`),
  ADD KEY `vocabulary` (`vocabulary`),
  ADD KEY `format` (`format`);

--
-- Indexes for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD PRIMARY KEY (`format`);

--
-- Indexes for table `ark_fragment_property`
--
ALTER TABLE `ark_fragment_property`
  ADD PRIMARY KEY (`type`,`property`),
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`);

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
  ADD PRIMARY KEY (`schma`,`subtype`,`association`) USING BTREE,
  ADD KEY `inverse_schema` (`inverse`);

--
-- Indexes for table `ark_schema_property`
--
ALTER TABLE `ark_schema_property`
  ADD PRIMARY KEY (`schma`,`subtype`,`property`) USING BTREE,
  ADD KEY `format` (`format`),
  ADD KEY `vocabulary` (`vocabulary`);

--
-- Indexes for table `ark_schema_subtype`
--
ALTER TABLE `ark_schema_subtype`
  ADD PRIMARY KEY (`schma`,`subtype`);

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
-- Indexes for table `ark_view_element_type`
--
ALTER TABLE `ark_view_element_type`
  ADD PRIMARY KEY (`type`);

--
-- Indexes for table `ark_view_group`
--
ALTER TABLE `ark_view_group`
  ADD PRIMARY KEY (`element`,`modtype`,`row`,`col`,`seq`);

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
-- Indexes for table `ark_vocabulary_meta`
--
ALTER TABLE `ark_vocabulary_meta`
  ADD PRIMARY KEY (`concept`,`term`,`property`),
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
  ADD CONSTRAINT `ark_format_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_fragment_type` (`type`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `ark_format_datetime_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE;

--
-- Constraints for table `ark_format_decimal`
--
ALTER TABLE `ark_format_decimal`
  ADD CONSTRAINT `ark_format_decimal_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE;

--
-- Constraints for table `ark_format_float`
--
ALTER TABLE `ark_format_float`
  ADD CONSTRAINT `ark_format_float_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE;

--
-- Constraints for table `ark_format_geometry`
--
ALTER TABLE `ark_format_geometry`
  ADD CONSTRAINT `ark_format_geometry_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_format_integer`
--
ALTER TABLE `ark_format_integer`
  ADD CONSTRAINT `ark_format_integer_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE;

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
-- Constraints for table `ark_format_property`
--
ALTER TABLE `ark_format_property`
  ADD CONSTRAINT `ark_format_property_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE,
  ADD CONSTRAINT `ark_format_property_ibfk_2` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`);

--
-- Constraints for table `ark_format_string`
--
ALTER TABLE `ark_format_string`
  ADD CONSTRAINT `ark_format_string_ibfk_1` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`) ON DELETE CASCADE;

--
-- Constraints for table `ark_fragment_property`
--
ALTER TABLE `ark_fragment_property`
  ADD CONSTRAINT `ark_fragment_property_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_fragment_type` (`type`),
  ADD CONSTRAINT `ark_fragment_property_ibfk_2` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`),
  ADD CONSTRAINT `ark_fragment_property_ibfk_3` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`);

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
-- Constraints for table `ark_schema_property`
--
ALTER TABLE `ark_schema_property`
  ADD CONSTRAINT `ark_schema_property_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_schema_property_ibfk_2` FOREIGN KEY (`format`) REFERENCES `ark_format` (`format`),
  ADD CONSTRAINT `ark_schema_property_ibfk_3` FOREIGN KEY (`vocabulary`) REFERENCES `ark_vocabulary` (`concept`);

--
-- Constraints for table `ark_schema_subtype`
--
ALTER TABLE `ark_schema_subtype`
  ADD CONSTRAINT `ark_schema_subtype_ibfk_1` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `ark_view_element_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_view_element_type` (`type`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ark_view_element_ibfk_2` FOREIGN KEY (`schma`) REFERENCES `ark_schema` (`schma`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary`
--
ALTER TABLE `ark_vocabulary`
  ADD CONSTRAINT `ark_vocabulary_ibfk_1` FOREIGN KEY (`type`) REFERENCES `ark_vocabulary_type` (`type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ark_vocabulary_meta`
--
ALTER TABLE `ark_vocabulary_meta`
  ADD CONSTRAINT `ark_vocabulary_meta_ibfk_1` FOREIGN KEY (`concept`,`term`) REFERENCES `ark_vocabulary_term` (`concept`, `term`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `ark_vocabulary_term_ibfk_1` FOREIGN KEY (`concept`) REFERENCES `ark_vocabulary` (`concept`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ark_vocabulary_translation`
--
ALTER TABLE `ark_vocabulary_translation`
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_1` FOREIGN KEY (`keyword`) REFERENCES `ark_vocabulary_term` (`keyword`) ON DELETE CASCADE,
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_2` FOREIGN KEY (`language`) REFERENCES `ark_translation_language` (`language`),
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_3` FOREIGN KEY (`domain`) REFERENCES `ark_translation_domain` (`domain`),
  ADD CONSTRAINT `ark_vocabulary_translation_ibfk_4` FOREIGN KEY (`role`) REFERENCES `ark_translation_role` (`role`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
