-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2015 at 05:48 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ark1_2_context`
--

-- --------------------------------------------------------

--
-- Table structure for table `abk_lut_abktype`
--

CREATE TABLE `abk_lut_abktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abktype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `abk_lut_abktype`
--

INSERT INTO `abk_lut_abktype` (`id`, `abktype`, `cre_by`, `cre_on`) VALUES
(1, 'people', 4, '2007-05-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `abk_tbl_abk`
--

CREATE TABLE `abk_tbl_abk` (
  `abk_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abk_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abktype` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`abk_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `abk_tbl_abk`
--

INSERT INTO `abk_tbl_abk` (`abk_cd`, `abk_no`, `ste_cd`, `abktype`, `cre_by`, `cre_on`) VALUES
('ARK_1', 1, 'ARK', 1, 1, '2013-11-29 17:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_actiontype`
--

CREATE TABLE `cor_lut_actiontype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actiontype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lookup table supplies types of actions' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cor_lut_actiontype`
--

INSERT INTO `cor_lut_actiontype` (`id`, `actiontype`, `module`, `cre_by`, `cre_on`) VALUES
(1, 'issuedto', 'cor', 0, '2005-11-09 00:00:00'),
(2, 'compiledby', 'cor', 2, '2006-05-07 15:20:21'),
(3, 'checkedby', 'cor', 2, '2006-05-07 15:35:21'),
(4, 'directedby', 'cor', 4, '2006-06-06 07:53:00'),
(5, 'supervisedby', 'cor', 4, '2006-06-06 07:54:00'),
(8, 'takenby', 'gph', 4, '2006-06-06 00:00:00'),
(6, 'drawnby', 'pln', 4, '2005-11-18 00:00:00'),
(7, 'scannedby', 'pln', 4, '2005-11-18 00:00:00'),
(9, 'interpretedby', 'cor', 0, '0000-00-00 00:00:00'),
(10, 'notedby', 'ael', 4, '2007-06-15 00:00:00'),
(11, 'restoredby', 'ael', 4, '2007-06-15 00:00:00'),
(12, 'registeredby', 'ael', 4, '2007-06-15 00:00:00'),
(13, 'sgrnarrativeby', 'sgr', 2, '2010-11-30 15:14:37'),
(14, 'datingnarrativeby', 'sgr', 2, '2010-12-01 15:13:08'),
(15, 'grpnarrativeby', 'grp', 2, '2011-08-31 19:45:24'),
(16, 'grpdatingnarrativeby', 'grp', 2, '2011-08-31 19:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_aliastype`
--

CREATE TABLE `cor_lut_aliastype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aliastype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cor_lut_aliastype`
--

INSERT INTO `cor_lut_aliastype` (`id`, `aliastype`, `cre_by`, `cre_on`) VALUES
(1, 'normal', 1, '2006-08-31 00:00:00'),
(2, 'against', 1, '2006-08-31 00:00:00'),
(3, 'boolean_true', 2, '2009-11-06 00:00:00'),
(4, 'boolean_false', 2, '2009-11-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_areatype`
--

CREATE TABLE `cor_lut_areatype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areatype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cor_lut_areatype`
--

INSERT INTO `cor_lut_areatype` (`id`, `areatype`, `cre_by`, `cre_on`) VALUES
(1, 'area', 2, '2005-11-14 00:00:00'),
(2, 'subarea', 2, '2005-11-14 00:00:00'),
(3, 'gridsquare', 2, '2005-11-14 00:00:00'),
(4, 'trench', 4, '2006-06-08 00:00:00'),
(5, 'zone', 4, '2006-06-08 08:33:26'),
(6, 'sector', 4, '2006-06-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_attribute`
--

CREATE TABLE `cor_lut_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attributetype` int(11) NOT NULL DEFAULT '0',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=382 ;

--
-- Dumping data for table `cor_lut_attribute`
--

INSERT INTO `cor_lut_attribute` (`id`, `attribute`, `attributetype`, `module`, `cre_by`, `cre_on`) VALUES
(315, 'mapbox', 34, 'cor', 127, '2015-01-15 12:51:39'),
(316, 'localhost', 34, 'cor', 127, '2015-01-15 12:53:21'),
(317, 'wms', 33, 'cor', 127, '2015-01-15 12:54:01'),
(318, 'wfs', 33, 'cor', 127, '2015-01-15 12:54:36'),
(319, 'tilejson', 33, 'cor', 127, '2015-01-15 12:55:23'),
(320, 'geojson', 33, 'cor', 127, '2015-01-15 12:56:45'),
(321, 'epsg:4326', 32, 'cor', 127, '2015-01-15 12:57:22'),
(322, 'epsg:900913', 32, 'cor', 127, '2015-01-15 12:57:22'),
(1, 'datcmp', 1, 'cor', 2, '2006-05-23 00:00:00'),
(2, 'chkd', 1, 'cor', 2, '0000-00-00 00:00:00'),
(3, 'not_exc', 1, 'cor', 4, '2006-06-07 00:00:00'),
(4, 'part_exc', 1, 'cor', 4, '2006-06-07 00:00:00'),
(5, 'exc', 1, 'cor', 4, '2006-06-07 00:00:00'),
(6, 'waterlogged', 3, 'smp', 1, '2008-06-13 00:00:00'),
(7, 'moist', 3, 'smp', 1, '2008-06-13 00:00:00'),
(8, 'dry', 3, 'smp', 1, '2008-06-13 00:00:00'),
(9, 'rootaction', 4, 'smp', 1, '2008-06-13 00:00:00'),
(10, 'mixturewithoverburden', 4, 'smp', 2, '0000-00-00 00:00:00'),
(11, 'othercontext', 4, 'smp', 2, '0000-00-00 00:00:00'),
(12, 'modernintrusions', 4, 'smp', 2, '0000-00-00 00:00:00'),
(13, '<5%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(14, '5-20%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(15, '20-40%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(16, '40-60%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(17, '60-80%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(18, '80-100%', 5, 'smp', 2, '0000-00-00 00:00:00'),
(35, 'glass', 2, 'cxt', 2, '2008-06-24 12:54:19'),
(34, 'bone', 2, 'cxt', 2, '2008-06-24 00:00:00'),
(33, 'pot', 2, 'cxt', 2, '2008-06-24 12:54:19'),
(32, 'nofinds', 2, 'cxt', 2, '2008-06-24 00:00:00'),
(26, 'radiocarbon', 7, 'smp', 2, '0000-00-00 00:00:00'),
(27, 'controlsediment', 7, 'smp', 2, '0000-00-00 00:00:00'),
(28, 'parasites', 7, 'smp', 2, '0000-00-00 00:00:00'),
(29, 'insects', 7, 'smp', 2, '0000-00-00 00:00:00'),
(30, 'pollen', 7, 'smp', 2, '0000-00-00 00:00:00'),
(31, 'diatoms', 7, 'smp', 2, '0000-00-00 00:00:00'),
(36, 'metal', 2, 'cxt', 2, '2008-06-24 00:00:00'),
(37, 'cbm', 2, 'cxt', 2, '2008-06-24 12:54:19'),
(38, 'flint', 2, 'cxt', 2, '2008-06-24 00:00:00'),
(39, 'wood', 2, 'cxt', 2, '2008-06-24 12:54:19'),
(40, 'leather', 2, 'cxt', 2, '2008-06-24 00:00:00'),
(41, 'other', 2, 'cxt', 2, '2008-06-24 12:54:19'),
(42, 'noconatm', 4, 'smp', 2, '2008-06-26 00:00:00'),
(43, 'site', 8, 'smp', 1, '2008-06-26 00:00:00'),
(44, 'cambridge', 8, 'smp', 1, '2008-06-26 00:00:00'),
(45, 'processed', 8, 'smp', 1, '2008-06-26 00:00:00'),
(46, 'retained', 8, 'smp', 1, '2008-06-26 00:00:00'),
(73, 'kubi', 13, 'smp', 4, '0000-00-00 00:00:00'),
(72, 'ecospec', 13, 'smp', 4, '0000-00-00 00:00:00'),
(71, 'ecorec', 13, 'smp', 4, '0000-00-00 00:00:00'),
(70, 'waterlogged', 13, 'smp', 4, '0000-00-00 00:00:00'),
(69, 'monolith', 13, 'smp', 4, '0000-00-00 00:00:00'),
(68, 'skeleton', 13, 'smp', 4, '0000-00-00 00:00:00'),
(67, 'genbulk', 13, 'smp', 4, '0000-00-00 00:00:00'),
(54, 'low', 10, 'smp', 1, '2008-06-26 00:00:00'),
(55, 'medium', 10, 'smp', 1, '2008-06-26 00:00:00'),
(56, 'high', 10, 'smp', 1, '2008-06-26 00:00:00'),
(57, 'drying', 11, 'smp', 1, '2008-06-26 00:00:00'),
(58, 'bagged', 11, 'smp', 1, '2008-06-26 00:00:00'),
(59, 'processed', 11, 'smp', 1, '2008-06-26 00:00:00'),
(60, 'drying', 12, 'smp', 1, '2008-06-26 00:00:00'),
(61, 'bagged', 12, 'smp', 1, '2008-06-26 00:00:00'),
(62, 'processed', 12, 'smp', 1, '2008-06-26 00:00:00'),
(66, 'cremation', 13, 'smp', 4, '0000-00-00 00:00:00'),
(64, 'boneextracted', 8, 'smp', 1, '2008-06-26 00:00:00'),
(65, 'residuesorted', 8, 'smp', 1, '2008-06-26 00:00:00'),
(74, 'soilchem', 13, 'smp', 4, '0000-00-00 00:00:00'),
(75, 'snails', 13, 'smp', 4, '0000-00-00 00:00:00'),
(76, 'pollen', 13, 'smp', 4, '0000-00-00 00:00:00'),
(77, 'spec', 13, 'smp', 4, '0000-00-00 00:00:00'),
(78, 'missing', 8, 'smp', 4, '0000-00-00 00:00:00'),
(79, 'datmissing', 8, 'smp', 4, '0000-00-00 00:00:00'),
(80, 'void', 8, 'smp', 4, '0000-00-00 00:00:00'),
(81, 'extern', 8, 'smp', 4, '0000-00-00 00:00:00'),
(82, 'natural', 14, 'cxt', 1, '2009-11-06 00:00:00'),
(83, 'modern', 14, 'cxt', 1, '2009-11-10 15:35:34'),
(84, 'earlypm', 14, 'cxt', 1, '2009-11-10 15:35:34'),
(85, 'romii', 14, 'cxt', 1, '2009-11-10 15:35:34'),
(86, 'latepm', 14, 'cxt', 1, '2009-11-10 15:35:34'),
(87, 'pmsoils', 14, 'cxt', 1, '2009-11-10 15:35:35'),
(88, 'romani', 14, 'cxt', 1, '2009-11-10 15:35:36'),
(89, 'prerom', 14, 'cxt', 1, '2009-11-10 15:35:54'),
(90, 'notproc', 8, 'smp', 4, '0000-00-00 00:00:00'),
(91, 'lghfrac_rec', 15, 'smp', 2, '2009-11-06 00:00:00'),
(92, 'hfass', 15, 'smp', 2, '2009-11-06 00:00:00'),
(93, 'cambridge', 16, 'smp', 2, '2009-12-02 00:00:00'),
(94, 'externalspec', 16, 'smp', 2, '2009-12-02 00:00:00'),
(95, 'noflotlocn', 16, 'smp', 2, '2009-12-02 00:00:00'),
(96, 'charcoal', 17, 'smp', 2, '2009-12-02 00:00:00'),
(97, 'hrboneinhum', 17, 'smp', 2, '2009-12-02 00:00:00'),
(98, 'hrbonecrem2to4', 17, 'smp', 2, '2009-12-02 00:00:00'),
(99, 'hrbonecremgt4', 17, 'smp', 2, '2009-12-02 00:00:00'),
(100, 'plantrems', 7, 'smp', 2, '2009-12-02 00:00:00'),
(101, 'burial', 18, 'sgr', 2, '2009-12-08 00:00:00'),
(102, 'cremation', 18, 'sgr', 2, '2009-12-08 00:00:00'),
(103, 'posscrem', 18, 'sgr', 2, '2009-12-02 00:00:00'),
(104, 'pit', 18, 'sgr', 2, '2009-12-09 00:00:00'),
(105, 'lead', 19, '', 2, '2010-10-22 16:19:00'),
(106, 'copper', 19, '', 2, '2010-10-22 16:19:00'),
(107, 'iron', 19, '', 2, '2010-10-22 16:19:00'),
(108, 'ceramic', 19, '', 2, '2010-10-22 16:19:00'),
(109, 'stone', 19, '', 2, '2010-10-22 16:19:00'),
(110, 'ivory', 19, '', 2, '2010-10-22 16:19:00'),
(111, 'fibre', 19, '', 2, '2010-10-22 16:19:00'),
(112, 'samp', 19, '', 2, '2010-10-22 16:19:00'),
(113, 'rivet', 20, '', 2, '2010-10-22 16:19:00'),
(114, 'waste', 20, '', 2, '2010-10-22 16:19:00'),
(115, 'coin', 20, '', 2, '2010-10-22 16:19:00'),
(116, 'vessel', 20, '', 2, '2010-10-22 16:19:00'),
(117, 'shoe', 20, '', 2, '2010-10-22 16:19:00'),
(118, 'spindle', 20, '', 2, '2010-10-22 16:19:00'),
(119, 'stud', 20, '', 2, '2010-10-22 16:19:00'),
(120, 'slag', 20, '', 2, '2010-10-22 16:19:00'),
(121, 'buck', 20, '', 2, '2010-10-22 16:19:00'),
(122, 'staple', 20, '', 2, '2010-10-22 16:19:00'),
(123, 'knife', 20, '', 2, '2010-10-22 16:19:00'),
(124, 'mount', 20, '', 2, '2010-10-22 16:19:00'),
(125, 'handle', 20, '', 2, '2010-10-22 16:19:00'),
(126, 'ring', 20, '', 2, '2010-10-22 16:19:00'),
(127, 'strap', 20, '', 2, '2010-10-22 16:19:00'),
(128, 'wire', 20, '', 2, '2010-10-22 16:19:00'),
(129, 'key', 20, '', 2, '2010-10-22 16:19:00'),
(130, 'nail', 20, '', 2, '2010-10-22 16:19:00'),
(131, 'chis', 20, '', 2, '2010-10-22 16:19:00'),
(132, 'hosh', 20, '', 2, '2010-10-22 16:19:00'),
(133, 'hinge', 20, '', 2, '2010-10-22 16:19:00'),
(134, 'bracket', 20, '', 2, '2010-10-22 16:19:00'),
(135, 'bead', 20, '', 2, '2010-10-22 16:19:00'),
(136, 'barr', 20, '', 2, '2010-10-22 16:19:00'),
(137, 'chap', 20, '', 2, '2010-10-22 16:19:00'),
(138, 'pin', 20, '', 2, '2010-10-22 16:19:00'),
(139, 'butt', 20, '', 2, '2010-10-22 16:19:00'),
(140, 'patc', 20, '', 2, '2010-10-22 16:19:00'),
(141, 'bottle', 20, '', 2, '2010-10-22 16:19:00'),
(142, 'cup', 20, '', 2, '2010-10-22 16:19:00'),
(143, 'window', 20, '', 2, '2010-10-22 16:19:00'),
(144, 'jar', 20, '', 2, '2010-10-22 16:19:00'),
(145, 'tessera', 20, '', 2, '2010-10-22 16:19:00'),
(146, 'beaker', 20, '', 2, '2010-10-22 16:19:00'),
(147, 'phial', 20, '', 2, '2010-10-22 16:19:00'),
(148, 'tumb', 20, '', 2, '2010-10-22 16:19:00'),
(149, 'hone', 20, '', 2, '2010-10-22 16:19:00'),
(150, 'pinb', 20, '', 2, '2010-10-22 16:19:00'),
(151, 'comb', 20, '', 2, '2010-10-22 16:19:00'),
(152, 'awl', 20, '', 2, '2010-10-22 16:19:00'),
(153, 'pipe', 20, '', 2, '2010-10-22 16:19:00'),
(154, 'wigc', 20, '', 2, '2010-10-22 16:19:00'),
(155, 'sam', 20, '', 2, '2010-10-22 16:19:00'),
(156, 'lamp', 20, '', 2, '2010-10-22 16:19:00'),
(157, 'walt', 20, '', 2, '2010-10-22 16:19:00'),
(158, 'flor', 20, '', 2, '2010-10-22 16:19:00'),
(159, 'blot', 20, '', 2, '2010-10-22 16:19:00'),
(160, 'bowl', 20, '', 2, '2010-10-22 16:19:00'),
(161, 'brush', 20, '', 2, '2010-10-22 16:19:00'),
(162, 'plug', 20, '', 2, '2010-10-22 16:19:00'),
(163, 'badg', 20, '', 2, '2010-10-22 16:19:00'),
(164, 'stpe', 20, '', 2, '2010-10-22 16:19:00'),
(165, 'drhk', 20, '', 2, '2010-10-22 16:19:00'),
(166, 'weig', 20, '', 2, '2010-10-22 16:19:00'),
(167, 'clos', 20, '', 2, '2010-10-22 16:19:00'),
(168, 'came', 20, '', 2, '2010-10-22 16:19:00'),
(169, 'shot', 20, '', 2, '2010-10-22 16:19:00'),
(170, 'flask', 20, '', 2, '2010-10-22 16:19:00'),
(171, 'ferr', 20, '', 2, '2010-10-22 16:19:00'),
(172, 'rove', 20, '', 2, '2010-10-22 16:19:00'),
(173, 'padl', 20, '', 2, '2010-10-22 16:19:00'),
(174, 'jug', 20, '', 2, '2010-10-22 16:19:00'),
(175, 'coun', 20, '', 2, '2010-10-22 16:19:00'),
(176, 'alle', 20, '', 2, '2010-10-22 16:19:00'),
(177, 'toot', 20, '', 2, '2010-10-22 16:19:00'),
(178, 'spoo', 20, '', 2, '2010-10-22 16:19:00'),
(179, 'gufl', 20, '', 2, '2010-10-22 16:19:00'),
(180, 'figu', 20, '', 2, '2010-10-22 16:19:00'),
(181, 'lock', 20, '', 2, '2010-10-22 16:19:00'),
(182, 'sbox', 20, '', 2, '2010-10-22 16:19:00'),
(183, 'brak', 20, '', 2, '2010-10-22 16:19:00'),
(184, 'broo', 20, '', 2, '2010-10-22 16:19:00'),
(185, 'chat', 20, '', 2, '2010-10-22 16:19:00'),
(186, 'quern', 20, '', 2, '2010-10-22 16:19:00'),
(187, 'tile', 20, '', 2, '2010-10-22 16:19:00'),
(188, 'stft', 20, '', 2, '2010-10-22 16:19:00'),
(189, 'ladl', 20, '', 2, '2010-10-22 16:19:00'),
(190, 'cloth', 20, '', 2, '2010-10-22 16:19:00'),
(191, 'patt', 20, '', 2, '2010-10-22 16:19:00'),
(192, 'cruc', 20, '', 2, '2010-10-22 16:19:00'),
(193, 'morm', 20, '', 2, '2010-10-22 16:19:00'),
(194, 'inly', 20, '', 2, '2010-10-22 16:19:00'),
(195, 'roman', 21, '', 2, '2010-10-22 16:19:00'),
(196, 'postmed', 21, '', 2, '2010-10-22 16:19:00'),
(197, 'ph', 21, '', 2, '2010-10-22 16:19:00'),
(198, 'medieval', 21, '', 2, '2010-10-22 16:19:00'),
(199, 'bone', 19, 'rgf', 2, '2008-06-24 00:00:00'),
(200, 'glass', 19, 'rgf', 2, '2008-06-24 00:00:00'),
(201, 'flint', 19, 'rgf', 2, '2008-06-24 00:00:00'),
(202, 'wood', 19, 'rgf', 2, '2008-06-24 00:00:00'),
(203, 'leather', 19, 'rgf', 2, '2008-06-24 00:00:00'),
(204, 'zzz', 20, '', 2, '2010-10-22 16:19:00'),
(205, 'whole', 22, '', 2, '2010-10-22 16:19:00'),
(206, 'half', 22, '', 2, '2010-10-22 16:19:00'),
(207, 'displayable', 23, '', 2, '2010-10-22 16:19:00'),
(208, 'palaeochannel', 18, 'cor', 71, '2010-11-30 17:00:09'),
(209, 'reccomplete', 1, 'cxt', 4, '0000-00-00 00:00:00'),
(210, 'ddebris', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(211, 'ditch', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(212, 'cremation', 24, 'cxt', 4, '0000-00-00 00:00:00'),
(213, 'cellar', 24, 'cxt', 4, '0000-00-00 00:00:00'),
(214, 'consdebris', 24, 'cxt', 4, '0000-00-00 00:00:00'),
(215, 'coffin', 24, 'cxt', 4, '0000-00-00 00:00:00'),
(216, 'ddebris2', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(217, 'exbank', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(218, 'excult', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(219, 'exdump', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(220, 'exmetal', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(221, 'exocc', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(222, 'pasture', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(223, 'exrevet', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(224, 'exsur', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(225, 'external', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(226, 'furnace', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(227, 'floor', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(228, 'gravecut', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(229, 'grave', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(230, 'hearth', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(231, 'mechanical', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(232, 'makeup', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(233, 'natural', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(234, 'natwind', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(235, 'natchannel', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(236, 'naterosion', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(237, 'natforeshore', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(238, 'natmarsh', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(239, 'natoverbank', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(240, 'natsoil', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(241, 'occdebris', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(242, 'pit', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(243, 'pitcess', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(244, 'pitcooking', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(245, 'pitossuary', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(246, 'pitquarry', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(247, 'pitrefuse', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(248, 'posstruct', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(249, 'pitstorage', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(250, 'roofceil', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(251, 'structcut', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(252, 'surerosion', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(253, 'skeleton', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(254, 'nonstructcut', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(255, 'structopening', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(256, 'posthole', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(257, 'structtimb', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(258, 'sump', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(259, 'tree', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(260, 'timber', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(261, 'well', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(262, 'wall', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(263, 'workedstone', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(264, 'unknown', 24, 'cxt', 4, '2008-10-08 00:00:00'),
(265, 'soakaway', 18, 'cor', 71, '2011-01-13 18:26:55'),
(266, 'layer', 18, 'cor', 71, '2011-01-18 14:14:50'),
(267, 'masonry', 18, 'cor', 71, '2011-01-31 11:59:12'),
(268, 'linear', 18, 'cor', 71, '2011-01-31 12:00:20'),
(269, 'drain', 18, 'cor', 71, '2011-02-02 15:20:03'),
(270, 'posthole_1', 18, 'cor', 71, '2011-02-14 12:07:17'),
(271, 'fragment', 22, 'cor', 2, '2011-11-24 14:31:47'),
(272, 'preromanxxad50', 26, 'cor', 2, '2011-12-08 12:00:11'),
(273, 'romaniad50ad120', 26, 'cor', 2, '2011-12-08 12:03:00'),
(274, 'romaniiad120ad160', 26, 'cor', 2, '2011-12-08 12:03:40'),
(275, 'romaniiiad160ad250', 26, 'cor', 2, '2011-12-08 12:05:57'),
(276, 'romanivad250ad400', 26, 'cor', 2, '2011-12-08 12:06:28'),
(277, 'medievalad400ad1480', 26, 'cor', 2, '2011-12-08 12:08:51'),
(278, 'postmedievalad1480ad1600', 26, 'cor', 2, '2011-12-08 12:09:52'),
(279, 'postmedievaliiad1600ad1690', 26, 'cor', 2, '2011-12-08 12:10:37'),
(280, 'postmedievaliiiad1690ad1800', 26, 'cor', 2, '2011-12-08 12:11:15'),
(281, 'postmedievalivad1800ad1901', 26, 'cor', 2, '2011-12-08 12:11:59'),
(288, 'cud', 28, '', 91, '2014-02-07 17:37:44'),
(289, 'd', 28, '', 91, '2014-02-07 17:37:44'),
(290, 'c', 28, '', 91, '2014-02-07 17:37:44'),
(291, 'cu', 28, '', 91, '2014-02-07 17:37:44'),
(292, 'ud', 28, '', 91, '2014-02-07 17:37:44'),
(293, 'u', 28, '', 91, '2014-02-07 17:37:44'),
(294, 'cd', 28, '', 91, '2014-02-07 17:37:44'),
(295, 'ec', 18, '', 91, '2014-02-07 17:40:05'),
(296, 'p', 18, '', 91, '2014-02-07 17:40:05'),
(297, 'th', 18, '', 91, '2014-02-07 17:40:05'),
(298, 'wa', 18, '', 91, '2014-02-07 17:40:05'),
(299, 'pq', 18, '', 91, '2014-02-07 17:40:05'),
(300, 'n', 18, '', 91, '2014-02-07 17:40:05'),
(301, 'ds', 18, '', 91, '2014-02-07 17:40:05'),
(302, 'oc', 18, '', 91, '2014-02-07 17:40:05'),
(303, 'xx', 18, '', 91, '2014-02-07 17:40:05'),
(304, 'db', 18, '', 91, '2014-02-07 17:40:06'),
(305, 'eo', 18, '', 91, '2014-02-07 17:40:06'),
(306, 'em', 18, '', 91, '2014-02-07 17:40:06'),
(307, 'sn', 18, '', 91, '2014-02-07 17:40:06'),
(308, 'mu', 18, '', 91, '2014-02-07 17:40:06'),
(309, 'he', 18, '', 91, '2014-02-07 17:40:06'),
(310, 'es', 18, '', 91, '2014-02-07 17:40:06'),
(311, 'ed', 18, '', 91, '2014-02-07 17:40:06'),
(312, 's', 18, '', 91, '2014-02-07 17:40:06'),
(313, 'so', 18, '', 91, '2014-02-07 17:40:06'),
(314, 'fl', 18, '', 91, '2014-02-07 17:40:06'),
(323, 'd', 18, '', 91, '2014-02-07 17:40:06'),
(324, 'g', 18, '', 91, '2014-02-07 17:40:06'),
(325, 'sk', 18, '', 91, '2014-02-07 17:40:06'),
(326, 'ps', 18, '', 91, '2014-02-07 17:40:06'),
(327, 'sp', 18, '', 91, '2014-02-07 17:40:06'),
(328, 'pr', 18, '', 91, '2014-02-07 17:40:06'),
(329, 'ec', 27, '', 91, '2014-02-12 16:19:25'),
(330, 'p', 27, '', 91, '2014-02-12 16:19:26'),
(331, 'th', 27, '', 91, '2014-02-12 16:19:26'),
(332, 'wa', 27, '', 91, '2014-02-12 16:19:26'),
(333, 'pq', 27, '', 91, '2014-02-12 16:19:26'),
(334, 'n', 27, '', 91, '2014-02-12 16:19:26'),
(335, 'ds', 27, '', 91, '2014-02-12 16:19:26'),
(336, 'oc', 27, '', 91, '2014-02-12 16:19:26'),
(337, 'xx', 27, '', 91, '2014-02-12 16:19:26'),
(338, 'db', 27, '', 91, '2014-02-12 16:19:26'),
(339, 'eo', 27, '', 91, '2014-02-12 16:19:26'),
(340, 'em', 27, '', 91, '2014-02-12 16:19:26'),
(341, 'sn', 27, '', 91, '2014-02-12 16:19:26'),
(342, 'mu', 27, '', 91, '2014-02-12 16:19:26'),
(343, 'he', 27, '', 91, '2014-02-12 16:19:26'),
(344, 'es', 27, '', 91, '2014-02-12 16:19:26'),
(345, 'ed', 27, '', 91, '2014-02-12 16:19:26'),
(346, 's', 27, '', 91, '2014-02-12 16:19:26'),
(347, 'so', 27, '', 91, '2014-02-12 16:19:26'),
(348, 'fl', 27, '', 91, '2014-02-12 16:19:26'),
(349, 'eb', 27, '', 91, '2014-02-12 16:19:26'),
(350, 'd', 27, '', 91, '2014-02-12 16:19:26'),
(351, 'g', 27, '', 91, '2014-02-12 16:19:26'),
(352, 'sk', 27, '', 91, '2014-02-12 16:19:26'),
(353, 'ps', 27, '', 91, '2014-02-12 16:19:26'),
(354, 'sp', 27, '', 91, '2014-02-12 16:19:26'),
(355, 'pr', 27, '', 91, '2014-02-12 16:19:26'),
(356, 'anbo', 2, '', 91, '2014-02-13 18:38:19'),
(357, 'ctp', 2, '', 91, '2014-02-13 18:38:19'),
(358, 'fe', 2, '', 91, '2014-02-13 18:38:19'),
(359, 'skel', 2, '', 91, '2014-02-13 18:38:19'),
(360, 'daub', 2, '', 91, '2014-02-13 18:38:19'),
(361, 'cu', 2, '', 91, '2014-02-13 18:38:19'),
(362, 'stone', 2, '', 91, '2014-02-13 18:47:24'),
(363, 'worked_bone', 2, '', 91, '2014-02-13 18:47:24'),
(364, 'shell', 2, '', 91, '2014-02-13 18:47:24'),
(365, 'pb', 2, '', 91, '2014-02-13 18:47:24'),
(366, 'slag', 2, '', 91, '2014-02-13 18:47:24'),
(367, 'humanbone', 2, '', 91, '2014-02-13 18:47:24'),
(368, 'mod', 29, '', 91, '2014-02-19 13:27:16'),
(369, 'm1', 29, '', 91, '2014-02-19 13:27:17'),
(370, 'm3', 29, '', 91, '2014-02-19 13:27:17'),
(371, 'pm1', 29, '', 91, '2014-02-19 13:27:17'),
(372, 'm5', 29, '', 91, '2014-02-19 13:27:17'),
(373, 'm4', 29, '', 91, '2014-02-19 13:27:17'),
(374, 'm2', 29, '', 91, '2014-02-19 13:27:17'),
(375, 'pm2', 29, '', 91, '2014-02-19 13:27:17'),
(376, 'sn', 29, '', 91, '2014-02-19 13:27:17'),
(377, 'ia', 29, '', 91, '2014-02-19 13:27:17'),
(378, 'mia', 29, '', 91, '2014-02-19 13:27:17'),
(379, 'rb??', 29, '', 91, '2014-02-19 13:27:18'),
(380, 'lsax', 29, '', 91, '2014-02-19 13:27:18'),
(381, 'rb', 29, '', 91, '2014-02-19 13:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_attributetype`
--

CREATE TABLE `cor_lut_attributetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=35 ;

--
-- Dumping data for table `cor_lut_attributetype`
--

INSERT INTO `cor_lut_attributetype` (`id`, `attributetype`, `module`, `cre_by`, `cre_on`) VALUES
(32, 'projection', 'cor', 127, '2015-01-15 12:40:19'),
(33, 'layerformat', 'cor', 127, '2015-01-15 12:41:19'),
(34, 'servertype', 'cor', 127, '2015-01-15 12:41:43'),
(1, 'recflag', 'cor', 2, '2006-05-23 00:00:00'),
(2, 'findtype', 'cxt', 1, '0000-00-00 00:00:00'),
(3, 'samplecondition', 'smp', 75, '2008-06-13 08:07:14'),
(4, 'contamination', 'smp', 75, '2008-06-13 09:47:11'),
(5, 'samplesize', 'smp', 75, '2008-06-13 10:09:14'),
(7, 'subsamples', 'smp', 78, '2008-06-13 14:46:42'),
(8, 'samplestatus', 'smp', 78, '2008-06-13 14:46:42'),
(13, 'sampletype', 'smp', 4, '0000-00-00 00:00:00'),
(10, 'priority', 'smp', 78, '2008-06-13 14:46:42'),
(11, 'hfstatus', 'smp', 78, '2008-06-13 14:46:42'),
(12, 'lfstatus', 'smp', 78, '2008-06-13 14:46:42'),
(14, 'provperiod', 'cxt', 1, '2009-11-06 00:00:00'),
(15, 'smpflag', 'smp', 2, '2009-11-06 00:00:00'),
(16, 'lflocn', 'smp', 2, '2009-12-02 00:00:00'),
(17, 'hfextrac', 'smp', 2, '2009-12-02 00:00:00'),
(18, 'basicinterp', 'sgr', 2, '2009-12-08 00:00:00'),
(19, 'objectmaterial', 'rgf', 2, '2010-10-22 16:39:41'),
(20, 'objectinterptype', 'rgf', 2, '2010-10-22 16:40:41'),
(21, 'objectperiod', 'rgf', 2, '2010-10-22 16:54:38'),
(22, 'objectcompleteness', 'rgf', 2, '2010-10-22 17:08:16'),
(23, 'objectdisplay', 'rgf', 2, '2010-10-22 17:08:48'),
(27, 'cxtbasicinterp', 'cxt', 4, '2010-12-09 00:00:00'),
(29, 'spotdate', 'cxt', 123, '2014-02-19 13:14:03'),
(26, 'grpphase', 'grp', 2, '2011-12-08 11:58:23'),
(28, 'process', 'cxt', 0, '2013-12-20 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_booltype`
--

CREATE TABLE `cor_lut_booltype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booltype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_datetype`
--

CREATE TABLE `cor_lut_datetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cor_lut_datetype`
--

INSERT INTO `cor_lut_datetype` (`id`, `datetype`, `module`, `cre_by`, `cre_on`) VALUES
(1, 'issuedon', 'cor', 0, '2005-11-09 00:00:00'),
(2, 'compiledon', 'cor', 2, '2006-05-07 15:55:21'),
(3, 'excavatedon', 'cor', 4, '2006-06-06 07:52:30'),
(4, 'takenon', 'gph', 4, '2006-06-06 00:00:00'),
(5, 'drawnon', 'pln', 2, '2005-11-21 00:00:00'),
(6, 'interpretedon', 'cor', 0, '0000-00-00 00:00:00'),
(8, 'registeredon', 'ael', 4, '2007-06-15 00:00:00'),
(9, 'sgrnarrativeon', 'sgr', 2, '2010-11-30 15:15:00'),
(10, 'datingnarrativeon', 'sgr', 2, '2010-12-01 15:12:37'),
(11, 'grpnarrativeon', 'grp', 2, '2011-08-31 19:46:16'),
(12, 'grpdatingnarrativeon', 'grp', 2, '2011-08-31 19:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_file`
--

CREATE TABLE `cor_lut_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uri` text COLLATE utf8_unicode_ci,
  `filetype` int(11) NOT NULL DEFAULT '0',
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `batch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_filetype`
--

CREATE TABLE `cor_lut_filetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filetype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cor_lut_filetype`
--

INSERT INTO `cor_lut_filetype` (`id`, `filetype`, `module`, `cre_by`, `cre_on`) VALUES
(1, 'images', '', 1, '2011-02-03 13:47:41'),
(2, 'cxtsheet', '', 123, '2013-12-20 00:00:00'),
(3, 'section', 'sec', 91, '2014-02-21 12:00:41');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_language`
--

CREATE TABLE `cor_lut_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cor_lut_language`
--

INSERT INTO `cor_lut_language` (`id`, `language`, `cre_by`, `cre_on`) VALUES
(1, 'en', 1, '2006-08-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_mapconnectiontype`
--

CREATE TABLE `cor_lut_mapconnectiontype` (
  `id` int(11) NOT NULL DEFAULT '0',
  `mapconnectiontype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cor_lut_mapconnectiontype`
--

INSERT INTO `cor_lut_mapconnectiontype` (`id`, `mapconnectiontype`, `cre_by`, `cre_on`) VALUES
(4, 'MS_OGR', 0, '0000-00-00 00:00:00'),
(7, 'MS_POSTGIS', 0, '0000-00-00 00:00:00'),
(5, 'MS_WMS', 0, '0000-00-00 00:00:00'),
(0, 'MS_INLINE', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_mapgeomtype`
--

CREATE TABLE `cor_lut_mapgeomtype` (
  `id` int(11) NOT NULL DEFAULT '0',
  `mapgeomtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cor_lut_mapgeomtype`
--

INSERT INTO `cor_lut_mapgeomtype` (`id`, `mapgeomtype`, `cre_by`, `cre_on`) VALUES
(1, 'Line', 0, '0000-00-00 00:00:00'),
(2, 'Polygon', 0, '0000-00-00 00:00:00'),
(3, 'Circle', 0, '0000-00-00 00:00:00'),
(4, 'Annotation', 0, '0000-00-00 00:00:00'),
(0, 'Point', 0, '0000-00-00 00:00:00'),
(5, 'Raster', 0, '0000-00-00 00:00:00'),
(6, 'Query', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_numbertype`
--

CREATE TABLE `cor_lut_numbertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qualifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `cor_lut_numbertype`
--

INSERT INTO `cor_lut_numbertype` (`id`, `numbertype`, `module`, `qualifier`, `cre_by`, `cre_on`) VALUES
(1, 'zoomlevel', '', '', 1, '2015-07-14 12:39:38'),
(2, 'rims', '', 'unit', 2, '2006-06-09 00:00:00'),
(3, 'handles', '', 'unit', 2, '2006-06-09 00:00:00'),
(4, 'bases', '', 'unit', 4, '2006-06-10 00:00:00'),
(5, 'walls', '', 'unit', 4, '2006-06-10 00:00:00'),
(6, 'total', '', 'unit', 4, '2006-06-10 00:00:00'),
(7, 'volume', 'smp', '', 75, '2008-06-13 10:04:33'),
(8, 'hf_numofbags', 'smp', '', 75, '2008-06-13 10:04:33'),
(9, 'lf_numofbags', 'smp', '', 75, '2008-06-13 10:04:33');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_place`
--

CREATE TABLE `cor_lut_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `placetype` int(11) NOT NULL DEFAULT '0',
  `layername` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Layername within the mapobject',
  `layerid` int(11) NOT NULL DEFAULT '0' COMMENT 'This is the unique id in the layer',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `place` (`place`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_placetype`
--

CREATE TABLE `cor_lut_placetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_spanlabel`
--

CREATE TABLE `cor_lut_spanlabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` int(3) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spanlabel` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cor_lut_spanlabel`
--

INSERT INTO `cor_lut_spanlabel` (`id`, `spantype`, `typemod`, `spanlabel`, `cre_by`, `cre_on`) VALUES
(1, 1, 'cor', 'cut', 2, '2006-05-11 00:00:00'),
(2, 1, 'cor', 'cover', 2, '2006-05-11 00:00:00'),
(3, 1, 'cor', 'abutt', 2, '2006-05-11 00:00:00'),
(4, 1, 'cor', 'fill', 1, '2006-05-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_spantype`
--

CREATE TABLE `cor_lut_spantype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `evaluation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cor_lut_spantype`
--

INSERT INTO `cor_lut_spantype` (`id`, `spantype`, `meta`, `evaluation`, `cre_by`, `cre_on`, `module`) VALUES
(1, 'tvector', '', '', 2, '2006-05-10 00:00:00', ''),
(2, 'sameas', '', '', 2, '2006-05-10 00:00:00', ''),
(3, 'relatedto', '', '', 4, '2006-06-06 00:00:00', ''),
(4, 'reuse_this_type', '', '', 2, '0000-00-00 00:00:00', ''),
(5, 'shrgeom', '', '', 91, '2014-02-12 17:36:54', 'cxt'),
(6, 'sgr_matrix', '', '', 123, '2014-02-19 13:56:39', 'sgr');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lut_txttype`
--

CREATE TABLE `cor_lut_txttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=137 ;

--
-- Dumping data for table `cor_lut_txttype`
--

INSERT INTO `cor_lut_txttype` (`id`, `txttype`, `module`, `cre_by`, `cre_on`) VALUES
(4, 'initials', 'abk', 1, '2007-05-17 00:00:00'),
(3, 'name', 'abk', 1, '2007-05-15 00:00:00'),
(2, 'short_desc', 'cor', 1, '2005-11-21 00:00:00'),
(1, 'interp', 'cor', 1, '2005-11-15 00:00:00'),
(132, 'layerstyle', 'cor', 127, '2015-01-15 12:42:17'),
(133, 'layeruri', 'cor', 127, '2015-01-15 12:42:48'),
(134, 'mapcenter', 'cor', 127, '2015-01-15 12:43:14'),
(135, 'remotename', 'cor', 127, '2015-01-15 12:43:58'),
(136, 'map_name', 'cor', 127, '2015-01-15 12:44:45'),
(11, 'interp', 'cor', 2, '2005-11-15 00:00:00'),
(10, 'short_desc', 'cor', 2, '2005-11-21 00:00:00'),
(9, 'compac', 'cxt', 2, '2005-11-14 00:00:00'),
(5, 'colour', 'cxt', 2, '2005-11-14 00:00:00'),
(6, 'compo', 'cxt', 2, '2005-11-14 00:00:00'),
(8, 'dims', 'cxt', 2, '2005-11-18 00:00:00'),
(17, 'orient', 'cxt', 2, '2005-11-18 00:00:00'),
(28, 'definition', 'cxt', 4, '2006-06-06 08:08:00'),
(34, 'desc', 'cxt', 4, '2006-06-06 00:00:00'),
(35, 'observ', 'cxt', 4, '2006-06-06 00:00:00'),
(36, 'excavtech', 'cxt', 4, '2006-06-06 00:00:00'),
(85, 'bond', 'cxt', 4, '2008-03-05 00:00:00'),
(84, 'sizemat', 'cxt', 4, '2008-03-05 00:00:00'),
(40, 'finish', 'cxt', 4, '2006-06-06 00:00:00'),
(83, 'truncation', 'cxt', 4, '2008-03-05 00:00:00'),
(82, 'inclination', 'cxt', 4, '2008-03-05 00:00:00'),
(81, 'base', 'cxt', 4, '2008-03-05 00:00:00'),
(80, 'bosbase', 'cxt', 4, '2008-03-05 00:00:00'),
(79, 'sides', 'cxt', 4, '2008-03-05 00:00:00'),
(78, 'bostop', 'cxt', 4, '2008-03-05 00:00:00'),
(57, 'inclusions', 'cxt', 4, '2006-06-07 00:00:00'),
(76, 'shape', 'cxt', 4, '2008-03-05 00:00:00'),
(77, 'corners', 'cxt', 4, '2008-03-05 00:00:00'),
(67, 'name', 'abk', 4, '2007-05-15 00:00:00'),
(68, 'initials', 'abk', 4, '2007-05-17 00:00:00'),
(70, 'material', 'cxt', 4, '2007-06-15 00:00:00'),
(88, 'bondmat', 'cxt', 4, '2008-03-05 00:00:00'),
(86, 'form', 'cxt', 4, '2008-03-05 00:00:00'),
(87, 'dirface', 'cxt', 4, '2008-03-05 00:00:00'),
(89, 'smpques', 'smp', 2, '2008-06-16 12:17:25'),
(90, 'abody', 'cxt', 4, '2008-06-18 00:00:00'),
(91, 'ahead', 'cxt', 4, '2008-06-18 00:00:00'),
(92, 'ararm', 'cxt', 4, '2008-06-18 00:00:00'),
(93, 'alarm', 'cxt', 4, '2008-06-18 00:00:00'),
(94, 'arleg', 'cxt', 4, '2008-06-18 00:00:00'),
(95, 'alleg', 'cxt', 4, '2008-06-18 00:00:00'),
(96, 'afeet', 'cxt', 4, '2008-06-18 00:00:00'),
(97, 'degen', 'cxt', 4, '2008-06-18 00:00:00'),
(98, 'state', 'cxt', 4, '2008-06-18 00:00:00'),
(99, 'smp_cxt_desc', 'smp', 2, '2008-06-25 00:00:00'),
(100, 'contam_desc', 'smp', 2, '2008-06-25 00:00:00'),
(101, 'type', 'cxt', 4, '2008-06-25 00:00:00'),
(102, 'setting', 'cxt', 4, '2008-06-25 00:00:00'),
(103, 'cross', 'cxt', 4, '2008-06-25 00:00:00'),
(104, 'cond', 'cxt', 4, '2008-06-25 00:00:00'),
(105, 'conv', 'cxt', 4, '2008-06-25 00:00:00'),
(106, 'tmarks', 'cxt', 4, '2008-06-25 00:00:00'),
(107, 'jfit', 'cxt', 4, '2008-06-25 00:00:00'),
(108, 'imarks', 'cxt', 4, '2008-06-25 00:00:00'),
(109, 'streat', 'cxt', 4, '2008-06-25 00:00:00'),
(110, 'direction', 'sph', 2, '2008-06-25 00:00:00'),
(111, 'scale', 'sph', 2, '2008-06-24 12:54:19'),
(112, 'statusnotes', 'smp', 2, '2008-06-24 12:54:19'),
(113, 'typenotes', 'smp', 2, '2008-06-24 12:54:19'),
(114, 'xrayid', 'rgf', 2, '2010-10-22 16:43:04'),
(115, 'objectcomments', 'rgf', 2, '2010-10-22 16:48:26'),
(116, 'sgrnarrative', 'sgr', 2, '2010-11-30 15:14:10'),
(117, 'plancxt', 'sgr', 2, '0000-00-00 00:00:00'),
(118, 'datingnarrative', 'sgr', 2, '2010-12-01 15:12:13'),
(119, 'grpnarrative', 'grp', 2, '2011-08-31 19:43:42'),
(120, 'grpdatingnarrative', 'grp', 2, '2011-08-31 19:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_applications`
--

CREATE TABLE `cor_lvu_applications` (
  `application_id` int(11) DEFAULT '0',
  `application_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `application_id_idx` (`application_id`),
  UNIQUE KEY `define_name_i_idx` (`application_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_applications`
--

INSERT INTO `cor_lvu_applications` (`application_id`, `application_define_name`) VALUES
(1, 'ARK');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_applications_seq`
--

CREATE TABLE `cor_lvu_applications_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_areas`
--

CREATE TABLE `cor_lvu_areas` (
  `area_id` int(11) DEFAULT '0',
  `application_id` int(11) DEFAULT '0',
  `area_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `area_id_idx` (`area_id`),
  UNIQUE KEY `define_name_i_idx` (`application_id`,`area_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_areas`
--

INSERT INTO `cor_lvu_areas` (`area_id`, `application_id`, `area_define_name`) VALUES
(1, 1, 'USER_ADMIN'),
(2, 1, 'DATA_ENTRY'),
(3, 1, 'DATA_VIEW'),
(4, 1, 'MICRO_VIEW'),
(5, 1, 'MAP_VIEW'),
(6, 1, 'IMPORT'),
(7, 1, 'USER_HOME');

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_areas_seq`
--

CREATE TABLE `cor_lvu_areas_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_area_admin_areas`
--

CREATE TABLE `cor_lvu_area_admin_areas` (
  `area_id` int(11) DEFAULT '0',
  `perm_user_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`area_id`,`perm_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_grouprights`
--

CREATE TABLE `cor_lvu_grouprights` (
  `group_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_grouprights`
--

INSERT INTO `cor_lvu_grouprights` (`group_id`, `right_id`, `right_level`) VALUES
(1, 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_groups`
--

CREATE TABLE `cor_lvu_groups` (
  `group_id` int(11) DEFAULT '0',
  `group_type` int(11) DEFAULT '0',
  `group_define_name` varchar(32) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `owner_user_id` int(11) DEFAULT '0',
  `owner_group_id` int(11) DEFAULT '0',
  UNIQUE KEY `group_id_idx` (`group_id`),
  UNIQUE KEY `define_name_i_idx` (`group_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_groups`
--

INSERT INTO `cor_lvu_groups` (`group_id`, `group_type`, `group_define_name`, `is_active`, `owner_user_id`, `owner_group_id`) VALUES
(1, 1, 'USERS', 1, 1, 1),
(2, 1, 'ADMINS', 1, 1, 1),
(3, 1, 'PUBLIC', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_groups_seq`
--

CREATE TABLE `cor_lvu_groups_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_groupusers`
--

CREATE TABLE `cor_lvu_groupusers` (
  `perm_user_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_groupusers`
--

INSERT INTO `cor_lvu_groupusers` (`perm_user_id`, `group_id`) VALUES
(42, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_group_subgroups`
--

CREATE TABLE `cor_lvu_group_subgroups` (
  `group_id` int(11) DEFAULT '0',
  `subgroup_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`subgroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_group_subgroups`
--

INSERT INTO `cor_lvu_group_subgroups` (`group_id`, `subgroup_id`) VALUES
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_perm_users`
--

CREATE TABLE `cor_lvu_perm_users` (
  `perm_user_id` int(11) DEFAULT '0',
  `auth_user_id` varchar(32) DEFAULT NULL,
  `auth_container_name` varchar(32) DEFAULT NULL,
  `perm_type` int(11) DEFAULT '0',
  UNIQUE KEY `perm_user_id_idx` (`perm_user_id`),
  UNIQUE KEY `auth_id_i_idx` (`auth_user_id`,`auth_container_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_perm_users`
--

INSERT INTO `cor_lvu_perm_users` (`perm_user_id`, `auth_user_id`, `auth_container_name`, `perm_type`) VALUES
(42, '1', 'ARK_USERS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_perm_users_seq`
--

CREATE TABLE `cor_lvu_perm_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `cor_lvu_perm_users_seq`
--

INSERT INTO `cor_lvu_perm_users_seq` (`sequence`) VALUES
(89);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_rights`
--

CREATE TABLE `cor_lvu_rights` (
  `right_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `right_define_name` varchar(32) DEFAULT NULL,
  `has_implied` tinyint(1) DEFAULT '1',
  UNIQUE KEY `right_id_idx` (`right_id`),
  UNIQUE KEY `define_name_i_idx` (`area_id`,`right_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_rights`
--

INSERT INTO `cor_lvu_rights` (`right_id`, `area_id`, `right_define_name`, `has_implied`) VALUES
(1, 1, 'VIEW', 0),
(2, 1, 'EDIT', 0),
(11, 6, 'IMPORT_VIEW', 0),
(12, 6, 'IMPORT_EDIT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_rights_seq`
--

CREATE TABLE `cor_lvu_rights_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_right_implied`
--

CREATE TABLE `cor_lvu_right_implied` (
  `right_id` int(11) DEFAULT '0',
  `implied_right_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`right_id`,`implied_right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_translations`
--

CREATE TABLE `cor_lvu_translations` (
  `translation_id` int(11) DEFAULT '0',
  `section_id` int(11) DEFAULT '0',
  `section_type` int(11) DEFAULT '0',
  `language_id` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `description` varchar(32) DEFAULT NULL,
  UNIQUE KEY `translation_id_idx` (`translation_id`),
  UNIQUE KEY `translation_i_idx` (`section_id`,`section_type`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_translations_seq`
--

CREATE TABLE `cor_lvu_translations_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_userrights`
--

CREATE TABLE `cor_lvu_userrights` (
  `perm_user_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_lvu_userrights`
--

INSERT INTO `cor_lvu_userrights` (`perm_user_id`, `right_id`, `right_level`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 2, 1),
(1, 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_users`
--

CREATE TABLE `cor_lvu_users` (
  `auth_user_id` varchar(32) DEFAULT NULL,
  `handle` varchar(32) DEFAULT NULL,
  `passwd` varchar(32) DEFAULT NULL,
  `owner_user_id` int(11) DEFAULT '0',
  `owner_group_id` int(11) DEFAULT '0',
  `lastlogin` datetime DEFAULT '1970-01-01 00:00:00',
  `is_active` tinyint(1) DEFAULT '1',
  UNIQUE KEY `auth_user_id_idx` (`auth_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_lvu_users_seq`
--

CREATE TABLE `cor_lvu_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `cor_lvu_users_seq`
--

INSERT INTO `cor_lvu_users_seq` (`sequence`) VALUES
(42);

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_action`
--

CREATE TABLE `cor_tbl_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actiontype` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actor_itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actor_itemvalue` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cor_tbl_action`
--

INSERT INTO `cor_tbl_action` (`id`, `actiontype`, `itemkey`, `itemvalue`, `actor_itemkey`, `actor_itemvalue`, `cre_by`, `cre_on`) VALUES
(1, 1, 'cxt_cd', 'ARK_1', 'abk_cd', 'ARK_1', 1, '2015-07-14 14:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_alias`
--

CREATE TABLE `cor_tbl_alias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `aliastype` int(11) NOT NULL DEFAULT '0',
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2793 ;

--
-- Dumping data for table `cor_tbl_alias`
--

INSERT INTO `cor_tbl_alias` (`id`, `alias`, `aliastype`, `language`, `itemkey`, `itemvalue`, `cre_by`, `cre_on`) VALUES
(1, 'Address Book', 1, 'en', 'cor_tbl_module', '2', 1, '2013-11-28 17:03:27'),
(2, 'Users', 1, 'en', 'cor_tbl_sgrp', '1', 1, '2013-11-28 17:05:32'),
(3, 'Admins', 1, 'en', 'cor_tbl_sgrp', '2', 1, '2013-11-28 17:05:32'),
(4, 'Created By', 1, 'en', 'cor_tbl_col', '1', 1, '2013-11-29 13:36:43'),
(5, 'Created On', 1, 'en', 'cor_tbl_col', '2', 1, '2013-11-29 13:36:43'),
(6, 'Type', 1, 'en', 'cor_tbl_col', '3', 1, '2013-11-29 13:36:43'),
(7, 'Sub Area', 1, 'en', 'cor_lut_areatype', '2', 1, '2006-12-06 11:02:41'),
(8, 'Grid Square', 1, 'en', 'cor_lut_areatype', '3', 1, '2006-12-06 11:02:41'),
(9, 'Trench', 1, 'en', 'cor_lut_areatype', '4', 1, '2006-12-06 11:02:41'),
(10, 'OGR (Shapefiles)', 1, 'en', 'cor_lut_mapconnectiontype', '4', 1, '2006-12-06 11:11:01'),
(11, 'PostGIS', 1, 'en', 'cor_lut_mapconnectiontype', '7', 1, '2006-12-06 11:11:01'),
(12, 'WMS', 1, 'en', 'cor_lut_mapconnectiontype', '5', 1, '2006-12-06 11:11:01'),
(13, 'Raster', 1, 'en', 'cor_lut_mapconnectiontype', '0', 1, '2006-12-06 11:11:01'),
(14, 'People', 1, 'en', 'abk_lut_abktype', '1', 1, '2014-02-20 12:38:45'),
(15, 'Name', 1, 'en', 'cor_lut_txttype', '3', 1, '2014-02-20 17:25:25'),
(16, 'Initials', 1, 'en', 'cor_lut_txttype', '4', 1, '2014-02-20 17:23:11'),
(1203, 'Zoom Level', 1, 'en', 'cor_lut_numbertype', '1', 127, '2015-01-15 12:34:15'),
(1204, 'Projection', 1, 'en', 'cor_lut_attributetype', '32', 127, '2015-01-15 12:40:19'),
(1205, 'Layer Format', 1, 'en', 'cor_lut_attributetype', '33', 127, '2015-01-15 12:41:19'),
(1206, 'Server Type', 1, 'en', 'cor_lut_attributetype', '34', 127, '2015-01-15 12:41:43'),
(1207, 'Style', 1, 'en', 'cor_lut_txttype', '132', 127, '2015-01-15 12:42:17'),
(1208, 'Layer Source', 1, 'en', 'cor_lut_txttype', '133', 127, '2015-01-15 12:42:48'),
(1209, 'Map Centre', 1, 'en', 'cor_lut_txttype', '134', 127, '2015-01-15 12:43:14'),
(1210, 'Layer Name on Server (if required)', 1, 'en', 'cor_lut_txttype', '135', 127, '2015-01-15 12:43:58'),
(1211, 'Name', 1, 'en', 'cor_lut_txttype', '136', 127, '2015-01-15 12:44:45'),
(1219, 'MapBox', 1, 'en', 'cor_lut_attribute', '315', 127, '2015-01-15 12:51:39'),
(1220, 'Local Host', 1, 'en', 'cor_lut_attribute', '316', 127, '2015-01-15 12:53:21'),
(1221, 'wms', 1, 'en', 'cor_lut_attribute', '317', 127, '2015-01-15 12:54:01'),
(1222, 'wfs', 1, 'en', 'cor_lut_attribute', '318', 127, '2015-01-15 12:54:36'),
(1223, 'tilejson', 1, 'en', 'cor_lut_attribute', '319', 127, '2015-01-15 12:55:23'),
(1224, 'geojson', 1, 'en', 'cor_lut_attribute', '320', 127, '2015-01-15 12:56:45'),
(1225, 'EPSG:4326', 1, 'en', 'cor_lut_attribute', '321', 127, '2015-01-15 12:57:22'),
(1226, 'EPSG:900913', 1, 'en', 'cor_lut_attribute', '322', 127, '2015-01-15 12:57:22'),
(2735, 'OC', 1, 'en', 'cor_lut_attribute', '337', 91, '2014-02-12 16:19:26'),
(2734, 'DS', 1, 'en', 'cor_lut_attribute', '336', 91, '2014-02-12 16:19:26'),
(2732, 'PQ', 1, 'en', 'cor_lut_attribute', '334', 91, '2014-02-12 16:19:26'),
(2733, 'N', 1, 'en', 'cor_lut_attribute', '335', 91, '2014-02-12 16:19:26'),
(2731, 'WA', 1, 'en', 'cor_lut_attribute', '333', 91, '2014-02-12 16:19:26'),
(2729, 'P', 1, 'en', 'cor_lut_attribute', '331', 91, '2014-02-12 16:19:26'),
(2730, 'TH', 1, 'en', 'cor_lut_attribute', '332', 91, '2014-02-12 16:19:26'),
(2728, 'EC', 1, 'en', 'cor_lut_attribute', '330', 91, '2014-02-12 16:19:25'),
(2726, 'SP', 1, 'en', 'cor_lut_attribute', '328', 91, '2014-02-07 17:40:06'),
(2727, 'PR', 1, 'en', 'cor_lut_attribute', '329', 91, '2014-02-07 17:40:06'),
(2725, 'PS', 1, 'en', 'cor_lut_attribute', '327', 91, '2014-02-07 17:40:06'),
(2723, 'G', 1, 'en', 'cor_lut_attribute', '325', 91, '2014-02-07 17:40:06'),
(2724, 'SK', 1, 'en', 'cor_lut_attribute', '326', 91, '2014-02-07 17:40:06'),
(2722, 'D', 1, 'en', 'cor_lut_attribute', '324', 91, '2014-02-07 17:40:06'),
(2720, 'FL', 1, 'en', 'cor_lut_attribute', '314', 91, '2014-02-07 17:40:06'),
(2721, 'EB', 1, 'en', 'cor_lut_attribute', '323', 91, '2014-02-07 17:40:06'),
(2719, 'SO', 1, 'en', 'cor_lut_attribute', '313', 91, '2014-02-07 17:40:06'),
(2717, 'ED', 1, 'en', 'cor_lut_attribute', '311', 91, '2014-02-07 17:40:06'),
(2718, 'S', 1, 'en', 'cor_lut_attribute', '312', 91, '2014-02-07 17:40:06'),
(2715, 'HE', 1, 'en', 'cor_lut_attribute', '309', 91, '2014-02-07 17:40:06'),
(2716, 'ES', 1, 'en', 'cor_lut_attribute', '310', 91, '2014-02-07 17:40:06'),
(2713, 'SN', 1, 'en', 'cor_lut_attribute', '307', 91, '2014-02-07 17:40:06'),
(2714, 'MU', 1, 'en', 'cor_lut_attribute', '308', 91, '2014-02-07 17:40:06'),
(2711, 'EO', 1, 'en', 'cor_lut_attribute', '305', 91, '2014-02-07 17:40:06'),
(2712, 'EM', 1, 'en', 'cor_lut_attribute', '306', 91, '2014-02-07 17:40:06'),
(2709, 'XX', 1, 'en', 'cor_lut_attribute', '303', 91, '2014-02-07 17:40:05'),
(2710, 'DB', 1, 'en', 'cor_lut_attribute', '304', 91, '2014-02-07 17:40:06'),
(2708, 'OC', 1, 'en', 'cor_lut_attribute', '302', 91, '2014-02-07 17:40:05'),
(2707, 'DS', 1, 'en', 'cor_lut_attribute', '301', 91, '2014-02-07 17:40:05'),
(2705, 'PQ', 1, 'en', 'cor_lut_attribute', '299', 91, '2014-02-07 17:40:05'),
(2706, 'N', 1, 'en', 'cor_lut_attribute', '300', 91, '2014-02-07 17:40:05'),
(2704, 'WA', 1, 'en', 'cor_lut_attribute', '298', 91, '2014-02-07 17:40:05'),
(2702, 'P', 1, 'en', 'cor_lut_attribute', '296', 91, '2014-02-07 17:40:05'),
(2703, 'TH', 1, 'en', 'cor_lut_attribute', '297', 91, '2014-02-07 17:40:05'),
(2700, 'CD', 1, 'en', 'cor_lut_attribute', '294', 91, '2014-02-07 17:37:44'),
(2701, 'EC', 1, 'en', 'cor_lut_attribute', '295', 91, '2014-02-07 17:40:05'),
(2698, 'UD', 1, 'en', 'cor_lut_attribute', '292', 91, '2014-02-07 17:37:44'),
(2699, 'U', 1, 'en', 'cor_lut_attribute', '293', 91, '2014-02-07 17:37:44'),
(2697, 'CU', 1, 'en', 'cor_lut_attribute', '291', 91, '2014-02-07 17:37:44'),
(2695, 'D', 1, 'en', 'cor_lut_attribute', '289', 91, '2014-02-07 17:37:44'),
(2696, 'C', 1, 'en', 'cor_lut_attribute', '290', 91, '2014-02-07 17:37:44'),
(2694, 'CUD', 1, 'en', 'cor_lut_attribute', '288', 91, '2014-02-07 17:37:44'),
(2693, 'CUD - Creation/Use/Destruction', 1, 'en', 'cor_lut_attribute', '287', 123, '2013-12-20 00:00:00'),
(2691, 'U - Use', 1, 'en', 'cor_lut_attribute', '284', 123, '2013-12-20 00:00:00'),
(2692, 'UD - Use/Destruction', 1, 'en', 'cor_lut_attribute', '285', 123, '2013-12-20 00:00:00'),
(2690, 'CU - Creation/Use', 1, 'en', 'cor_lut_attribute', '283', 123, '2013-12-20 00:00:00'),
(2689, 'Context Sheet', 1, 'en', 'cor_lut_filetype', '2', 123, '2013-12-20 00:00:00'),
(2687, 'C - Creation', 0, 'en', 'cor_lut_attribute', '282', 123, '2013-12-20 00:00:00'),
(2688, 'Process', 1, 'en', 'cor_lut_attributetype', '28', 123, '2013-12-20 00:00:00'),
(2685, 'Object', 1, 'en', 'rgf_lut_rgftype', '1', 123, '2013-12-18 22:14:42'),
(2686, 'Coin', 1, 'en', 'rgf_lut_rgftype', '2', 123, '2013-12-18 22:14:53'),
(2684, 'Deposit', 1, 'en', 'cxt_lut_cxttype', '6', 123, '2013-12-18 21:26:33'),
(2683, 'Post Medieval IV AD1800-AD1901', 1, 'en', 'cor_lut_attribute', '281', 2, '2011-12-08 12:11:59'),
(2682, 'Post Medieval III AD1690-AD1800', 1, 'en', 'cor_lut_attribute', '280', 2, '2011-12-08 12:11:15'),
(2681, 'Post Medieval II AD1600-AD1690', 1, 'en', 'cor_lut_attribute', '279', 2, '2011-12-08 12:10:37'),
(2680, 'Post Medieval AD1480-AD1600', 1, 'en', 'cor_lut_attribute', '278', 2, '2011-12-08 12:09:52'),
(2679, 'Medieval AD400-AD1480', 1, 'en', 'cor_lut_attribute', '277', 2, '2011-12-08 12:08:51'),
(2678, 'Roman IV AD250-AD400', 1, 'en', 'cor_lut_attribute', '276', 2, '2011-12-08 12:06:28'),
(2677, 'Roman III AD160-AD250', 1, 'en', 'cor_lut_attribute', '275', 2, '2011-12-08 12:05:57'),
(2676, 'Roman II AD120-AD160', 1, 'en', 'cor_lut_attribute', '274', 2, '2011-12-08 12:03:40'),
(2675, 'Pre-Roman xx-AD50', 1, 'en', 'cor_lut_attribute', '272', 2, '2011-12-08 12:00:11'),
(2674, 'Fragment', 1, 'en', 'cor_lut_attribute', '271', 2, '2011-11-24 14:31:47'),
(2673, 'Roman I AD50-AD120', 1, 'en', 'cor_lut_attribute', '273', 2, '2011-12-08 12:03:00'),
(2672, 'Post-hole', 1, 'en', 'cor_lut_attribute', '270', 71, '2011-02-14 12:07:17'),
(2671, 'Drain', 1, 'en', 'cor_lut_attribute', '269', 71, '2011-02-02 15:20:03'),
(2670, 'Linear', 1, 'en', 'cor_lut_attribute', '268', 71, '2011-01-31 12:00:20'),
(2668, 'Layer', 1, 'en', 'cor_lut_attribute', '266', 71, '2011-01-18 14:14:50'),
(2669, 'Masonry', 1, 'en', 'cor_lut_attribute', '267', 71, '2011-01-31 11:59:12'),
(2667, 'Soakaway', 1, 'en', 'cor_lut_attribute', '265', 71, '2011-01-13 18:26:55'),
(2666, 'XX - Unknown/Unspecified', 1, 'en', 'cor_lut_attribute', '264', 4, '2008-10-08 00:00:00'),
(2665, 'WS - Worked Stone Not in situe', 1, 'en', 'cor_lut_attribute', '263', 4, '2008-10-08 00:00:00'),
(2664, 'WA - Wall, Sill', 1, 'en', 'cor_lut_attribute', '262', 4, '2008-10-08 00:00:00'),
(2663, 'W - Well', 1, 'en', 'cor_lut_attribute', '261', 4, '2008-10-08 00:00:00'),
(2662, 'TI - Timber Not in situ', 1, 'en', 'cor_lut_attribute', '260', 4, '2008-10-08 00:00:00'),
(2661, 'TH - Tree Hole/Bole', 1, 'en', 'cor_lut_attribute', '259', 4, '2008-10-08 00:00:00'),
(2660, 'SU - Sump - Water Collection Pit', 1, 'en', 'cor_lut_attribute', '258', 4, '2008-10-08 00:00:00'),
(2659, 'ST - Structural Timber', 1, 'en', 'cor_lut_attribute', '257', 4, '2008-10-08 00:00:00'),
(2658, 'SP - Structural Cut (Post-hole)', 1, 'en', 'cor_lut_attribute', '256', 4, '2008-10-08 00:00:00'),
(2657, 'SO - Structural Opening', 1, 'en', 'cor_lut_attribute', '255', 4, '2008-10-08 00:00:00'),
(2656, 'SN - Non-Structural Cut', 1, 'en', 'cor_lut_attribute', '254', 4, '2008-10-08 00:00:00'),
(2655, 'SK - Skeleton', 1, 'en', 'cor_lut_attribute', '253', 4, '2008-10-08 00:00:00'),
(2654, 'SE - Surface Erosion (Interface or Cut)', 1, 'en', 'cor_lut_attribute', '252', 4, '2008-10-08 00:00:00'),
(2653, 'S - Structural Cut', 1, 'en', 'cor_lut_attribute', '251', 4, '2008-10-08 00:00:00'),
(2652, 'RO - Roof, Ceiling', 1, 'en', 'cor_lut_attribute', '250', 4, '2008-10-08 00:00:00'),
(2651, 'PT - Pit Storage', 1, 'en', 'cor_lut_attribute', '249', 4, '2008-10-08 00:00:00'),
(2650, 'PS - Positive Structural (Not Walls)', 1, 'en', 'cor_lut_attribute', '248', 4, '2008-10-08 00:00:00'),
(2649, 'PR - Pit Refuse', 1, 'en', 'cor_lut_attribute', '247', 4, '2008-10-08 00:00:00'),
(2648, 'PQ - Pit Quarry', 1, 'en', 'cor_lut_attribute', '246', 4, '2008-10-08 00:00:00'),
(2647, 'PO - Pit Ossuary', 1, 'en', 'cor_lut_attribute', '245', 4, '2008-10-08 00:00:00'),
(2646, 'PK - Pit Cooking', 1, 'en', 'cor_lut_attribute', '244', 4, '2008-10-08 00:00:00'),
(2645, 'PC - Pit Cess', 1, 'en', 'cor_lut_attribute', '243', 4, '2008-10-08 00:00:00'),
(2644, 'P - Pit (Unspecified)', 1, 'en', 'cor_lut_attribute', '242', 4, '2008-10-08 00:00:00'),
(2643, 'OC - Occupation Debris', 1, 'en', 'cor_lut_attribute', '241', 4, '2008-10-08 00:00:00'),
(2642, 'NS - Natural Soil (Unspecified)', 1, 'en', 'cor_lut_attribute', '240', 4, '2008-10-08 00:00:00'),
(2641, 'NO - Natural Alluvial Overbank', 1, 'en', 'cor_lut_attribute', '239', 4, '2008-10-08 00:00:00'),
(2640, 'NM - Natural Marsh Deposit', 1, 'en', 'cor_lut_attribute', '238', 4, '2008-10-08 00:00:00'),
(2639, 'NF - Natural Foreshore Deposit', 1, 'en', 'cor_lut_attribute', '237', 4, '2008-10-08 00:00:00'),
(2638, 'NE - Natural Erosional Feature', 1, 'en', 'cor_lut_attribute', '236', 4, '2008-10-08 00:00:00'),
(2637, 'NC - Natural Alluvial Channel Deposit', 1, 'en', 'cor_lut_attribute', '235', 4, '2008-10-08 00:00:00'),
(2636, 'NA - Natural Wind-Blown Deposit', 1, 'en', 'cor_lut_attribute', '234', 4, '2008-10-08 00:00:00'),
(2635, 'N - Natural Strata (Unspecified)', 1, 'en', 'cor_lut_attribute', '233', 4, '2008-10-08 00:00:00'),
(2634, 'MU - Make-up, Levelling', 1, 'en', 'cor_lut_attribute', '232', 4, '2008-10-08 00:00:00'),
(2633, 'ME - Mechanical Fixtures/Fittings', 1, 'en', 'cor_lut_attribute', '231', 4, '2008-10-08 00:00:00'),
(2632, 'HE - Hearth', 1, 'en', 'cor_lut_attribute', '230', 4, '2008-10-08 00:00:00'),
(2631, 'GM - Grave (Multiple Occupancy)', 1, 'en', 'cor_lut_attribute', '229', 4, '2008-10-08 00:00:00'),
(2629, 'FL - Floor', 1, 'en', 'cor_lut_attribute', '227', 4, '2008-10-08 00:00:00'),
(2630, 'G - Grave', 1, 'en', 'cor_lut_attribute', '228', 4, '2008-10-08 00:00:00'),
(2628, 'F - Furnace, Oven, Kiln, Fireplace, etc.', 1, 'en', 'cor_lut_attribute', '226', 4, '2008-10-08 00:00:00'),
(2627, 'EU - External (Unspecified)', 1, 'en', 'cor_lut_attribute', '225', 4, '2008-10-08 00:00:00'),
(2626, 'ES - External Surface (No Cultivation)', 1, 'en', 'cor_lut_attribute', '224', 4, '2008-10-08 00:00:00'),
(2625, 'ER - External Revetment', 1, 'en', 'cor_lut_attribute', '223', 4, '2008-10-08 00:00:00'),
(2624, 'EP - External Pasture, Parkland', 1, 'en', 'cor_lut_attribute', '222', 4, '2008-10-08 00:00:00'),
(2623, 'EO - External Occupation', 1, 'en', 'cor_lut_attribute', '221', 4, '2008-10-08 00:00:00'),
(2622, 'EM - External Metalling, Cobbling, etc.', 1, 'en', 'cor_lut_attribute', '220', 4, '2008-10-08 00:00:00'),
(2621, 'ED - External Dump', 1, 'en', 'cor_lut_attribute', '219', 4, '2008-10-08 00:00:00'),
(2620, 'EC - External Cultivation', 1, 'en', 'cor_lut_attribute', '218', 4, '2008-10-08 00:00:00'),
(2619, 'EB - External Bank', 1, 'en', 'cor_lut_attribute', '217', 4, '2008-10-08 00:00:00'),
(2618, 'DS - Destruction Debris (in situ)', 1, 'en', 'cor_lut_attribute', '216', 4, '2008-10-08 00:00:00'),
(2617, 'DB - Destruction Debris (Redeposited)', 1, 'en', 'cor_lut_attribute', '210', 4, '2008-10-08 00:00:00'),
(2616, 'D - Ditch, Drain, Gully, etc.', 1, 'en', 'cor_lut_attribute', '211', 4, '2008-10-08 00:00:00'),
(2615, 'C - Coffin', 1, 'en', 'cor_lut_attribute', '215', 4, '2008-10-08 00:00:00'),
(2614, 'CD - Construction Debris', 1, 'en', 'cor_lut_attribute', '214', 4, '2008-10-08 00:00:00'),
(2613, 'CE - Cellar, Basement, etc.', 1, 'en', 'cor_lut_attribute', '213', 4, '2008-10-08 00:00:00'),
(2612, 'CR - Cremation Burial', 1, 'en', 'cor_lut_attribute', '212', 4, '2008-10-08 00:00:00'),
(2610, 'yes', 5, 'en', 'cor_lut_attribute', '209', 4, '0000-00-00 00:00:00'),
(2611, 'no', 6, 'en', 'cor_lut_attribute', '209', 4, '2010-12-10 00:00:00'),
(2609, 'Record Complete', 1, 'en', 'cor_lut_attribute', '209', 4, '2010-12-10 00:00:00'),
(2608, 'Palaeochannel', 1, 'en', 'cor_lut_attribute', '208', 71, '2010-11-30 17:00:09'),
(2607, 'Displayable', 1, 'en', 'cor_lut_attribute', '207', 2, '2010-10-22 16:19:00'),
(2606, 'Half', 1, 'en', 'cor_lut_attribute', '206', 2, '2010-10-22 16:19:00'),
(2604, 'Object', 1, 'en', 'cor_lut_attribute', '204', 2, '2010-10-22 16:19:00'),
(2605, 'Whole', 1, 'en', 'cor_lut_attribute', '205', 2, '2010-10-22 16:19:00'),
(2602, 'Wood', 1, 'en', 'cor_lut_attribute', '202', 2, '0000-00-00 00:00:00'),
(2603, 'Leather', 1, 'en', 'cor_lut_attribute', '203', 2, '0000-00-00 00:00:00'),
(2601, 'Flint', 1, 'en', 'cor_lut_attribute', '201', 2, '0000-00-00 00:00:00'),
(2599, 'Bone', 1, 'en', 'cor_lut_attribute', '199', 2, '0000-00-00 00:00:00'),
(2600, 'Glass', 1, 'en', 'cor_lut_attribute', '200', 2, '0000-00-00 00:00:00'),
(2598, 'Medieval', 1, 'en', 'cor_lut_attribute', '198', 2, '2010-10-22 16:19:00'),
(2597, 'PH', 1, 'en', 'cor_lut_attribute', '197', 2, '2010-10-22 16:19:00'),
(2595, 'Roman', 1, 'en', 'cor_lut_attribute', '195', 2, '2010-10-22 16:19:00'),
(2596, 'Post Medieval', 1, 'en', 'cor_lut_attribute', '196', 2, '2010-10-22 16:19:00'),
(2594, 'Inlay', 1, 'en', 'cor_lut_attribute', '194', 2, '2010-10-22 16:19:00'),
(2593, 'Mortuarium (Ceramic)', 1, 'en', 'cor_lut_attribute', '193', 2, '2010-10-22 16:19:00'),
(2592, 'Crucible', 1, 'en', 'cor_lut_attribute', '192', 2, '2010-10-22 16:19:00'),
(2591, 'Patten', 1, 'en', 'cor_lut_attribute', '191', 2, '2010-10-22 16:19:00'),
(2589, 'Ladle', 1, 'en', 'cor_lut_attribute', '189', 2, '2010-10-22 16:19:00'),
(2590, 'Cloth', 1, 'en', 'cor_lut_attribute', '190', 2, '2010-10-22 16:19:00'),
(2588, 'Structural Fitting', 1, 'en', 'cor_lut_attribute', '188', 2, '2010-10-22 16:19:00'),
(2587, 'Tile', 1, 'en', 'cor_lut_attribute', '187', 2, '2010-10-22 16:19:00'),
(2586, 'Quern', 1, 'en', 'cor_lut_attribute', '186', 2, '2010-10-22 16:19:00'),
(2585, 'Chatelaine', 1, 'en', 'cor_lut_attribute', '185', 2, '2010-10-22 16:19:00'),
(2583, 'Bracket', 1, 'en', 'cor_lut_attribute', '183', 2, '2010-10-22 16:19:00'),
(2584, 'Brooch', 1, 'en', 'cor_lut_attribute', '184', 2, '2010-10-22 16:19:00'),
(2582, 'Seal Box', 1, 'en', 'cor_lut_attribute', '182', 2, '2010-10-22 16:19:00'),
(2581, 'Lock', 1, 'en', 'cor_lut_attribute', '181', 2, '2010-10-22 16:19:00'),
(2580, 'Figurine', 1, 'en', 'cor_lut_attribute', '180', 2, '2010-10-22 16:19:00'),
(2579, 'Gun Flint', 1, 'en', 'cor_lut_attribute', '179', 2, '2010-10-22 16:19:00'),
(2578, 'Spoon', 1, 'en', 'cor_lut_attribute', '178', 2, '2010-10-22 16:19:00'),
(2577, 'Toothbrush', 1, 'en', 'cor_lut_attribute', '177', 2, '2010-10-22 16:19:00'),
(2576, 'Alley', 1, 'en', 'cor_lut_attribute', '176', 2, '2010-10-22 16:19:00'),
(2575, 'Counter', 1, 'en', 'cor_lut_attribute', '175', 2, '2010-10-22 16:19:00'),
(2574, 'Jug', 1, 'en', 'cor_lut_attribute', '174', 2, '2010-10-22 16:19:00'),
(2573, 'Padlock', 1, 'en', 'cor_lut_attribute', '173', 2, '2010-10-22 16:19:00'),
(2572, 'Rove', 1, 'en', 'cor_lut_attribute', '172', 2, '2010-10-22 16:19:00'),
(2571, 'Ferrule', 1, 'en', 'cor_lut_attribute', '171', 2, '2010-10-22 16:19:00'),
(2570, 'Flask', 1, 'en', 'cor_lut_attribute', '170', 2, '2010-10-22 16:19:00'),
(2568, 'Came', 1, 'en', 'cor_lut_attribute', '168', 2, '2010-10-22 16:19:00'),
(2569, 'Shot', 1, 'en', 'cor_lut_attribute', '169', 2, '2010-10-22 16:19:00'),
(2566, 'Weight', 1, 'en', 'cor_lut_attribute', '166', 2, '2010-10-22 16:19:00'),
(2567, 'Cloth Seal', 1, 'en', 'cor_lut_attribute', '167', 2, '2010-10-22 16:19:00'),
(2565, 'Dress Hook', 1, 'en', 'cor_lut_attribute', '165', 2, '2010-10-22 16:19:00'),
(2564, 'Strap end (or belt chape)', 1, 'en', 'cor_lut_attribute', '164', 2, '2010-10-22 16:19:00'),
(2563, 'Badge', 1, 'en', 'cor_lut_attribute', '163', 2, '2010-10-22 16:19:00'),
(2562, 'Plug', 1, 'en', 'cor_lut_attribute', '162', 2, '2010-10-22 16:19:00'),
(2561, 'Brush', 1, 'en', 'cor_lut_attribute', '161', 2, '2010-10-22 16:19:00'),
(2560, 'Bowl', 1, 'en', 'cor_lut_attribute', '160', 2, '2010-10-22 16:19:00'),
(2559, 'Bolt', 1, 'en', 'cor_lut_attribute', '159', 2, '2010-10-22 16:19:00'),
(2557, 'Wall Tile', 1, 'en', 'cor_lut_attribute', '157', 2, '2010-10-22 16:19:00'),
(2558, 'Floor Tile', 1, 'en', 'cor_lut_attribute', '158', 2, '2010-10-22 16:19:00'),
(2556, 'Lamp', 1, 'en', 'cor_lut_attribute', '156', 2, '2010-10-22 16:19:00'),
(2555, 'Samian', 1, 'en', 'cor_lut_attribute', '155', 2, '2010-10-22 16:19:00'),
(2554, 'Wig Curler', 1, 'en', 'cor_lut_attribute', '154', 2, '2010-10-22 16:19:00'),
(2553, 'Tobacco Pipe', 1, 'en', 'cor_lut_attribute', '153', 2, '2010-10-22 16:19:00'),
(2551, 'Comb', 1, 'en', 'cor_lut_attribute', '151', 2, '2010-10-22 16:19:00'),
(2552, 'Awl', 1, 'en', 'cor_lut_attribute', '152', 2, '2010-10-22 16:19:00'),
(2550, 'Pinners Bone', 1, 'en', 'cor_lut_attribute', '150', 2, '2010-10-22 16:19:00'),
(2548, 'Tumbler', 1, 'en', 'cor_lut_attribute', '148', 2, '2010-10-22 16:19:00'),
(2549, 'Hone', 1, 'en', 'cor_lut_attribute', '149', 2, '2010-10-22 16:19:00'),
(2547, 'Phial', 1, 'en', 'cor_lut_attribute', '147', 2, '2010-10-22 16:19:00'),
(2546, 'Beaker', 1, 'en', 'cor_lut_attribute', '146', 2, '2010-10-22 16:19:00'),
(2544, 'Jar', 1, 'en', 'cor_lut_attribute', '144', 2, '2010-10-22 16:19:00'),
(2545, 'Tessera', 1, 'en', 'cor_lut_attribute', '145', 2, '2010-10-22 16:19:00'),
(2543, 'Window', 1, 'en', 'cor_lut_attribute', '143', 2, '2010-10-22 16:19:00'),
(2542, 'Cup', 1, 'en', 'cor_lut_attribute', '142', 2, '2010-10-22 16:19:00'),
(2541, 'Bottle', 1, 'en', 'cor_lut_attribute', '141', 2, '2010-10-22 16:19:00'),
(2540, 'Patch', 1, 'en', 'cor_lut_attribute', '140', 2, '2010-10-22 16:19:00'),
(2539, 'Button', 1, 'en', 'cor_lut_attribute', '139', 2, '2010-10-22 16:19:00'),
(2538, 'Pin', 1, 'en', 'cor_lut_attribute', '138', 2, '2010-10-22 16:19:00'),
(2537, 'Chape', 1, 'en', 'cor_lut_attribute', '137', 2, '2010-10-22 16:19:00'),
(2536, 'Barrel', 1, 'en', 'cor_lut_attribute', '136', 2, '2010-10-22 16:19:00'),
(2535, 'Bead', 1, 'en', 'cor_lut_attribute', '135', 2, '2010-10-22 16:19:00'),
(2534, 'Bracelet', 1, 'en', 'cor_lut_attribute', '134', 2, '2010-10-22 16:19:00'),
(2533, 'Hinge', 1, 'en', 'cor_lut_attribute', '133', 2, '2010-10-22 16:19:00'),
(2531, 'Chisel', 1, 'en', 'cor_lut_attribute', '131', 2, '2010-10-22 16:19:00'),
(2532, 'Horse Shoe', 1, 'en', 'cor_lut_attribute', '132', 2, '2010-10-22 16:19:00'),
(2530, 'Nail', 1, 'en', 'cor_lut_attribute', '130', 2, '2010-10-22 16:19:00'),
(2528, 'Wire', 1, 'en', 'cor_lut_attribute', '128', 2, '2010-10-22 16:19:00'),
(2529, 'Key', 1, 'en', 'cor_lut_attribute', '129', 2, '2010-10-22 16:19:00'),
(2527, 'Strap', 1, 'en', 'cor_lut_attribute', '127', 2, '2010-10-22 16:19:00'),
(2526, 'Ring', 1, 'en', 'cor_lut_attribute', '126', 2, '2010-10-22 16:19:00'),
(2525, 'Handle', 1, 'en', 'cor_lut_attribute', '125', 2, '2010-10-22 16:19:00'),
(2524, 'Mount', 1, 'en', 'cor_lut_attribute', '124', 2, '2010-10-22 16:19:00'),
(2523, 'Knife', 1, 'en', 'cor_lut_attribute', '123', 2, '2010-10-22 16:19:00'),
(2522, 'Staple', 1, 'en', 'cor_lut_attribute', '122', 2, '2010-10-22 16:19:00'),
(2520, 'Slag', 1, 'en', 'cor_lut_attribute', '120', 2, '2010-10-22 16:19:00'),
(2521, 'Buckle', 1, 'en', 'cor_lut_attribute', '121', 2, '2010-10-22 16:19:00'),
(2519, 'Stud', 1, 'en', 'cor_lut_attribute', '119', 2, '2010-10-22 16:19:00'),
(2517, 'Shoe', 1, 'en', 'cor_lut_attribute', '117', 2, '2010-10-22 16:19:00'),
(2518, 'Spindle', 1, 'en', 'cor_lut_attribute', '118', 2, '2010-10-22 16:19:00'),
(2516, 'Vessel', 1, 'en', 'cor_lut_attribute', '116', 2, '2010-10-22 16:19:00'),
(2515, 'Coin', 1, 'en', 'cor_lut_attribute', '115', 2, '2010-10-22 16:19:00'),
(2514, 'Waste', 1, 'en', 'cor_lut_attribute', '114', 2, '2010-10-22 16:19:00'),
(2513, 'Rivet', 1, 'en', 'cor_lut_attribute', '113', 2, '2010-10-22 16:19:00'),
(2511, 'Fibre', 1, 'en', 'cor_lut_attribute', '111', 2, '2010-10-22 16:19:00'),
(2512, 'samP', 1, 'en', 'cor_lut_attribute', '112', 2, '2010-10-22 16:19:00'),
(2510, 'Ivory', 1, 'en', 'cor_lut_attribute', '110', 2, '2010-10-22 16:19:00'),
(2508, 'Ceramic', 1, 'en', 'cor_lut_attribute', '108', 2, '2010-10-22 16:19:00'),
(2509, 'Stone', 1, 'en', 'cor_lut_attribute', '109', 2, '2010-10-22 16:19:00'),
(2507, 'Iron', 1, 'en', 'cor_lut_attribute', '107', 2, '2010-10-22 16:19:00'),
(2505, 'Lead', 1, 'en', 'cor_lut_attribute', '105', 2, '2010-10-22 16:19:00'),
(2506, 'Copper', 1, 'en', 'cor_lut_attribute', '106', 2, '2010-10-22 16:19:00'),
(2504, 'Pit', 1, 'en', 'cor_lut_attribute', '104', 2, '2009-12-09 00:00:00'),
(2502, 'Cremation', 1, 'en', 'cor_lut_attribute', '102', 2, '2009-12-08 00:00:00'),
(2503, 'Poss? Cremation', 1, 'en', 'cor_lut_attribute', '103', 2, '2009-12-09 00:00:00'),
(2501, 'Burial', 1, 'en', 'cor_lut_attribute', '101', 2, '2009-12-08 00:00:00'),
(2500, 'Plant Remains', 1, 'en', 'cor_lut_attribute', '100', 2, '2009-12-02 00:00:00'),
(2499, 'Human Bone - Cremation > 4mm', 1, 'en', 'cor_lut_attribute', '99', 2, '2009-12-02 00:00:00'),
(2498, 'Human Bone - Cremation 2mm to 4mm', 1, 'en', 'cor_lut_attribute', '98', 2, '2009-12-02 00:00:00'),
(2497, 'Human Bone - Inhumation', 1, 'en', 'cor_lut_attribute', '97', 2, '2009-12-02 00:00:00'),
(2496, 'Charcoal', 1, 'en', 'cor_lut_attribute', '96', 2, '2009-12-02 00:00:00'),
(2495, 'Assessed?', 1, 'en', 'cor_lut_attribute', '92', 2, '2009-12-02 00:00:00'),
(2494, 'No', 6, 'en', 'cor_lut_attribute', '92', 2, '2009-12-02 00:00:00'),
(2492, 'N/A', 1, 'en', 'cor_lut_attribute', '95', 2, '2009-12-02 00:00:00'),
(2493, 'Yes', 5, 'en', 'cor_lut_attribute', '92', 2, '2009-12-02 00:00:00'),
(2491, 'AEA', 1, 'en', 'cor_lut_attribute', '94', 2, '2009-12-02 00:00:00'),
(2490, 'LP Cambridge', 1, 'en', 'cor_lut_attribute', '93', 2, '2009-12-02 00:00:00'),
(2489, 'Flot Recovered', 1, 'en', 'cor_lut_attribute', '91', 2, '2009-11-06 00:00:00'),
(2488, 'no', 6, 'en', 'cor_lut_attribute', '91', 2, '2009-11-06 00:00:00'),
(2487, 'yes', 5, 'en', 'cor_lut_attribute', '91', 2, '2009-11-06 00:00:00'),
(2486, 'Not Processed', 1, 'en', 'cor_lut_attribute', '90', 2, '2009-11-06 00:00:00'),
(2485, 'Pre-Roman', 1, 'en', 'cor_lut_attribute', '89', 1, '2009-11-10 15:35:54'),
(2484, 'Roman II', 1, 'en', 'cor_lut_attribute', '88', 1, '2009-11-10 15:35:36'),
(2483, 'PM Soils', 1, 'en', 'cor_lut_attribute', '87', 1, '2009-11-10 15:35:35'),
(2482, 'Late PM', 1, 'en', 'cor_lut_attribute', '86', 1, '2009-11-10 15:35:34'),
(2481, 'Roman I', 1, 'en', 'cor_lut_attribute', '85', 1, '2009-11-10 15:35:34'),
(2480, 'Early PM', 1, 'en', 'cor_lut_attribute', '84', 1, '2009-11-10 15:35:34'),
(2479, 'Modern', 1, 'en', 'cor_lut_attribute', '83', 1, '2009-11-10 15:35:34'),
(2478, 'Natural', 1, 'en', 'cor_lut_attribute', '82', 1, '2009-11-06 00:00:00'),
(2477, 'with External', 1, 'en', 'cor_lut_attribute', '81', 4, '0000-00-00 00:00:00'),
(2476, 'Void', 1, 'en', 'cor_lut_attribute', '80', 4, '0000-00-00 00:00:00'),
(2475, 'Data Missing', 1, 'en', 'cor_lut_attribute', '79', 4, '0000-00-00 00:00:00'),
(2473, 'Special', 1, 'en', 'cor_lut_attribute', '77', 4, '0000-00-00 00:00:00'),
(2474, 'Missing', 1, 'en', 'cor_lut_attribute', '78', 4, '0000-00-00 00:00:00'),
(2472, 'Pollen', 1, 'en', 'cor_lut_attribute', '76', 4, '0000-00-00 00:00:00'),
(2471, 'Snails', 1, 'en', 'cor_lut_attribute', '75', 4, '0000-00-00 00:00:00'),
(2470, 'Soil Chemistry', 1, 'en', 'cor_lut_attribute', '74', 4, '0000-00-00 00:00:00'),
(2469, 'Residue Sorted', 1, 'en', 'cor_lut_attribute', '65', 1, '2008-03-05 00:00:00'),
(2468, 'Bone Extracted', 1, 'en', 'cor_lut_attribute', '64', 1, '2008-03-05 00:00:00'),
(2467, 'Cremation', 1, 'en', 'cor_lut_attribute', '66', 4, '0000-00-00 00:00:00'),
(2466, 'Processed', 1, 'en', 'cor_lut_attribute', '62', 1, '2008-03-05 00:00:00'),
(2465, 'Bagged', 1, 'en', 'cor_lut_attribute', '61', 1, '2008-03-05 00:00:00'),
(2464, 'Drying', 1, 'en', 'cor_lut_attribute', '60', 1, '2008-03-05 00:00:00'),
(2463, 'Processed', 1, 'en', 'cor_lut_attribute', '59', 1, '2008-03-05 00:00:00'),
(2462, 'Bagged', 1, 'en', 'cor_lut_attribute', '58', 1, '2008-03-05 00:00:00'),
(2461, 'Drying', 1, 'en', 'cor_lut_attribute', '57', 1, '2008-03-05 00:00:00'),
(2460, 'High', 1, 'en', 'cor_lut_attribute', '56', 1, '2008-03-05 00:00:00'),
(2459, 'Medium', 1, 'en', 'cor_lut_attribute', '55', 1, '2008-03-05 00:00:00'),
(2458, 'Low', 1, 'en', 'cor_lut_attribute', '54', 1, '2008-03-05 00:00:00'),
(2457, 'General Bulk', 1, 'en', 'cor_lut_attribute', '67', 4, '0000-00-00 00:00:00'),
(2456, 'Skeleton Recovery', 1, 'en', 'cor_lut_attribute', '68', 4, '0000-00-00 00:00:00'),
(2454, 'Waterlogged', 1, 'en', 'cor_lut_attribute', '70', 4, '0000-00-00 00:00:00'),
(2455, 'Monolith', 1, 'en', 'cor_lut_attribute', '69', 4, '0000-00-00 00:00:00'),
(2453, 'Ecofact Recovery', 1, 'en', 'cor_lut_attribute', '71', 4, '0000-00-00 00:00:00'),
(2452, 'Specific Ecofact', 1, 'en', 'cor_lut_attribute', '72', 4, '0000-00-00 00:00:00'),
(2451, 'Kubiena', 1, 'en', 'cor_lut_attribute', '73', 4, '0000-00-00 00:00:00'),
(2450, 'in Cambridge', 1, 'en', 'cor_lut_attribute', '44', 1, '2008-03-05 00:00:00'),
(2448, 'Retained', 1, 'en', 'cor_lut_attribute', '46', 1, '2008-03-05 00:00:00'),
(2449, 'Processed', 1, 'en', 'cor_lut_attribute', '45', 1, '2008-03-05 00:00:00'),
(2447, 'on Site', 1, 'en', 'cor_lut_attribute', '43', 1, '2008-03-05 00:00:00'),
(2445, 'Other (add to descr)', 1, 'en', 'cor_lut_attribute', '41', 2, '2008-06-24 00:00:00'),
(2446, 'No Contamination', 1, 'en', 'cor_lut_attribute', '42', 2, '2008-06-25 00:00:00'),
(2444, 'Leather', 1, 'en', 'cor_lut_attribute', '40', 2, '2008-06-24 12:54:19'),
(2443, 'Wood', 1, 'en', 'cor_lut_attribute', '39', 2, '2008-06-24 00:00:00'),
(2442, 'Flint', 1, 'en', 'cor_lut_attribute', '38', 2, '2008-06-24 12:54:19'),
(2440, 'CBM', 1, 'en', 'cor_lut_attribute', '37', 2, '2008-06-24 00:00:00'),
(2441, 'Metal', 1, 'en', 'cor_lut_attribute', '36', 2, '2008-06-24 12:54:19'),
(2439, 'Glass', 1, 'en', 'cor_lut_attribute', '35', 2, '2008-06-24 12:54:19'),
(2438, 'Bone', 1, 'en', 'cor_lut_attribute', '34', 2, '2008-06-24 00:00:00'),
(2437, 'Pot', 1, 'en', 'cor_lut_attribute', '33', 2, '2008-06-24 12:54:19'),
(2436, 'None', 1, 'en', 'cor_lut_attribute', '32', 2, '2008-06-24 00:00:00'),
(2434, 'Pollen', 1, 'en', 'cor_lut_attribute', '30', 78, '2008-06-13 14:46:42'),
(2435, 'Diatoms', 1, 'en', 'cor_lut_attribute', '31', 78, '2008-06-13 14:46:42'),
(2433, 'Insects', 1, 'en', 'cor_lut_attribute', '29', 78, '2008-06-13 14:46:42'),
(2432, 'Parasites', 1, 'en', 'cor_lut_attribute', '28', 78, '2008-06-13 14:46:42'),
(2431, 'Control Sediment', 1, 'en', 'cor_lut_attribute', '27', 78, '2008-06-13 14:46:42'),
(2430, 'Radiocarbon', 1, 'en', 'cor_lut_attribute', '26', 78, '2008-06-13 14:46:42'),
(2429, '80-100pc', 1, 'en', 'cor_lut_attribute', '18', 2, '2008-06-13 08:07:14'),
(2428, '60-80pc', 1, 'en', 'cor_lut_attribute', '17', 2, '2008-06-13 08:07:14'),
(2427, '40-60pc', 1, 'en', 'cor_lut_attribute', '16', 2, '2008-06-13 08:07:14'),
(2426, '20-40pc', 1, 'en', 'cor_lut_attribute', '15', 2, '2008-06-13 08:07:14'),
(2425, '5-20pc', 1, 'en', 'cor_lut_attribute', '14', 2, '2008-06-13 08:07:14'),
(2424, '<5pc', 1, 'en', 'cor_lut_attribute', '13', 2, '2008-06-13 08:07:14'),
(2423, 'Modern Intrusions', 1, 'en', 'cor_lut_attribute', '12', 2, '2008-06-13 08:07:14'),
(2422, 'Other context', 1, 'en', 'cor_lut_attribute', '11', 2, '2008-06-13 08:07:14'),
(2420, 'Root Action', 1, 'en', 'cor_lut_attribute', '9', 2, '2008-06-13 08:07:14'),
(2421, 'Mixture with overburden', 1, 'en', 'cor_lut_attribute', '10', 2, '2008-06-13 08:07:14'),
(2419, 'Dry', 1, 'en', 'cor_lut_attribute', '8', 2, '2008-06-13 08:07:14'),
(2418, 'Moist', 1, 'en', 'cor_lut_attribute', '7', 2, '2008-06-13 08:07:14'),
(2416, 'Excavated', 1, 'en', 'cor_lut_attribute', '5', 1, '2006-12-06 11:04:35'),
(2417, 'Waterlogged', 1, 'en', 'cor_lut_attribute', '6', 2, '2008-06-13 08:07:14'),
(2415, 'Partially Excavated', 1, 'en', 'cor_lut_attribute', '4', 1, '2006-12-06 11:04:35'),
(2414, 'Not Excavated', 1, 'en', 'cor_lut_attribute', '3', 1, '2006-12-06 11:04:35'),
(2413, 'Record Checked', 1, 'en', 'cor_lut_attribute', '2', 1, '2006-12-06 11:04:35'),
(2412, 'Data Entry Complete', 1, 'en', 'cor_lut_attribute', '1', 1, '2006-12-06 11:04:35'),
(2410, 'Phase', 1, 'en', 'cor_lut_attributetype', '26', 2, '2011-12-08 11:58:23'),
(2411, 'Basic Interpretation', 1, 'en', 'cor_lut_attributetype', '27', 78, '2013-07-05 11:41:24'),
(2409, 'Dating Info Added On', 1, 'en', 'cor_lut_datetype', '12', 2, '2011-08-31 19:49:35'),
(2408, 'Dating Info Author', 1, 'en', 'cor_lut_actiontype', '16', 2, '2011-08-31 19:49:07'),
(2406, 'Date', 1, 'en', 'cor_lut_datetype', '11', 2, '2011-08-31 19:46:16'),
(2407, 'Group Dating Info', 1, 'en', 'cor_lut_txttype', '120', 2, '2011-08-31 19:47:37'),
(2405, 'Group Text Author', 1, 'en', 'cor_lut_actiontype', '15', 2, '2011-08-31 19:45:24'),
(2404, 'Group Description', 1, 'en', 'cor_lut_txttype', '119', 2, '2011-08-31 19:43:42'),
(2402, 'Author', 1, 'en', 'cor_lut_actiontype', '14', 2, '2010-12-01 15:13:08'),
(2403, 'Image', 1, 'en', 'cor_lut_filetype', '1', 2, '2011-08-25 22:36:56'),
(2401, 'Date', 1, 'en', 'cor_lut_datetype', '10', 2, '2010-12-01 15:12:37'),
(2400, 'Dating Narrative', 1, 'en', 'cor_lut_txttype', '118', 2, '2010-12-01 15:12:13'),
(2398, 'Author', 1, 'en', 'cor_lut_actiontype', '13', 2, '2010-11-30 15:14:37'),
(2399, 'Date', 1, 'en', 'cor_lut_datetype', '9', 2, '2010-11-30 15:15:00'),
(2397, 'Subgroup Narrative', 1, 'en', 'cor_lut_txttype', '116', 2, '2010-11-30 15:14:10'),
(2396, 'Diplay', 1, 'en', 'cor_lut_attributetype', '23', 2, '2010-10-22 17:08:48'),
(2395, 'Completeness', 1, 'en', 'cor_lut_attributetype', '22', 2, '2010-10-22 17:08:16'),
(2394, 'Object Period', 1, 'en', 'cor_lut_attributetype', '21', 2, '2010-10-22 16:54:38'),
(2392, 'Xray ID', 1, 'en', 'cor_lut_txttype', '114', 2, '2010-10-22 16:43:04'),
(2393, 'Comments', 1, 'en', 'cor_lut_txttype', '115', 2, '2010-10-22 16:48:26'),
(2391, 'Object Type', 1, 'en', 'cor_lut_attributetype', '20', 2, '2010-10-22 16:40:41'),
(2390, 'Object Material', 1, 'en', 'cor_lut_attributetype', '19', 2, '2010-10-22 16:39:41'),
(2389, 'Basic Interp.', 1, 'en', 'cor_lut_attributetype', '18', 2, '2009-12-08 00:00:00'),
(2388, 'Materials Extracted', 1, 'en', 'cor_lut_attributetype', '17', 2, '2009-12-02 00:00:00'),
(2387, 'Location', 1, 'en', 'cor_lut_attributetype', '16', 2, '2009-12-02 00:00:00'),
(2385, 'Sample Type', 1, 'en', 'cor_lut_attributetype', '13', 4, '0000-00-00 00:00:00'),
(2386, 'Provisional Period', 1, 'en', 'cor_lut_attributetype', '14', 1, '2009-11-06 00:00:00'),
(2384, 'Plan Context', 1, 'en', 'cor_lut_txttype', '117', 4, '2008-10-21 00:00:00'),
(2383, 'Status', 1, 'en', 'cor_lut_attributetype', '11', 1, '2008-03-05 00:00:00'),
(2382, 'Status', 1, 'en', 'cor_lut_attributetype', '12', 1, '2008-03-05 00:00:00'),
(2381, 'Number of Bags', 1, 'en', 'cor_lut_numbertype', '9', 1, '2008-03-05 00:00:00'),
(2380, 'Number of Bags', 1, 'en', 'cor_lut_numbertype', '8', 1, '2008-03-05 00:00:00'),
(2379, 'Priority', 1, 'en', 'cor_lut_attributetype', '10', 1, '2008-03-05 00:00:00'),
(2377, 'Type Notes', 1, 'en', 'cor_lut_txttype', '113', 1, '2008-03-05 00:00:00'),
(2378, 'Action', 1, 'en', 'cor_lut_attributetype', '9', 1, '2008-03-05 00:00:00'),
(2375, 'Sample Status', 1, 'en', 'cor_lut_attributetype', '8', 1, '2008-03-05 00:00:00'),
(2376, 'Status Notes', 1, 'en', 'cor_lut_txttype', '112', 1, '2008-03-05 00:00:00'),
(2374, 'Scale', 1, 'en', 'cor_lut_txttype', '111', 2, '2008-06-24 12:54:19'),
(2373, 'Direction', 1, 'en', 'cor_lut_txttype', '110', 2, '2008-06-25 00:00:00'),
(2372, 'Surface Treatment', 1, 'en', 'cor_lut_txttype', '109', 4, '2008-06-25 00:00:00'),
(2371, 'Intentional Marks', 1, 'en', 'cor_lut_txttype', '108', 4, '0000-00-00 00:00:00'),
(2370, 'Joints and Fittings', 1, 'en', 'cor_lut_txttype', '107', 4, '2008-06-25 00:00:00'),
(2369, 'Tool Marks', 1, 'en', 'cor_lut_txttype', '106', 4, '2008-06-25 00:00:00'),
(2368, 'Conversion', 1, 'en', 'cor_lut_txttype', '105', 4, '2008-06-25 00:00:00'),
(2367, 'Condition', 1, 'en', 'cor_lut_txttype', '104', 4, '2008-06-25 00:00:00'),
(2366, 'Cross-Section', 1, 'en', 'cor_lut_txttype', '103', 4, '2008-06-25 00:00:00'),
(2365, 'Setting', 1, 'en', 'cor_lut_txttype', '102', 4, '2008-06-25 00:00:00'),
(2364, 'Type', 1, 'en', 'cor_lut_txttype', '101', 4, '2008-06-25 00:00:00'),
(2363, 'Other Contamination:', 1, 'en', 'cor_lut_txttype', '100', 2, '2008-06-25 00:00:00'),
(2362, 'Type', 1, 'en', 'cor_lut_txttype', '99', 2, '2008-06-25 00:00:00'),
(2361, 'State of bone after lifting', 1, 'en', 'cor_lut_txttype', '98', 4, '2008-06-18 00:00:00'),
(2360, 'Extent of in situ bone degeneration', 1, 'en', 'cor_lut_txttype', '97', 4, '2008-06-18 00:00:00'),
(2359, 'Attitude of feet', 1, 'en', 'cor_lut_txttype', '96', 4, '2008-06-18 00:00:00'),
(2358, 'Attitude of left leg', 1, 'en', 'cor_lut_txttype', '95', 4, '2008-06-18 00:00:00'),
(2357, 'Attitude of right leg', 1, 'en', 'cor_lut_txttype', '94', 4, '2008-06-18 00:00:00'),
(2356, 'Attitude of left arm, location of left hand', 1, 'en', 'cor_lut_txttype', '93', 4, '2008-06-18 00:00:00'),
(2355, 'Subsamples Required?', 1, 'en', 'cor_lut_attributetype', '7', 78, '2008-06-13 14:46:42'),
(2354, 'Questions About Sample (What do you want to know about the deposit)', 1, 'en', 'cor_lut_txttype', '89', 2, '2008-06-16 00:00:00'),
(2353, 'Attitude of body', 1, 'en', 'cor_lut_txttype', '90', 4, '2008-06-18 00:00:00'),
(2352, 'Attitude of head', 1, 'en', 'cor_lut_txttype', '91', 4, '2008-06-18 00:00:00'),
(2351, 'Attitude of right arm, location of right hand', 1, 'en', 'cor_lut_txttype', '92', 4, '2008-06-18 00:00:00'),
(2350, 'Sample Size', 1, 'en', 'cor_lut_attributetype', '5', 75, '2008-06-13 10:09:14'),
(2349, 'Volume', 1, 'en', 'cor_lut_numbertype', '7', 75, '2008-06-13 10:04:33'),
(2348, 'Contamination', 1, 'en', 'cor_lut_attributetype', '4', 75, '2008-06-13 09:47:11'),
(2347, 'Condition', 1, 'en', 'cor_lut_attributetype', '3', 75, '2008-06-13 08:07:14'),
(2346, 'Shape in plan', 1, 'en', 'cor_lut_txttype', '76', 4, '2008-03-05 00:00:00'),
(2345, 'Corners', 1, 'en', 'cor_lut_txttype', '77', 4, '2008-03-05 00:00:00'),
(2344, 'Break of slope- Top', 1, 'en', 'cor_lut_txttype', '78', 4, '2008-03-05 00:00:00'),
(2343, 'Sides', 1, 'en', 'cor_lut_txttype', '79', 4, '2008-03-05 00:00:00'),
(2342, 'Materials', 1, 'en', 'cor_lut_txttype', '70', 4, '2007-06-15 00:00:00'),
(2341, 'Break of slope- Base', 1, 'en', 'cor_lut_txttype', '80', 4, '2008-03-05 00:00:00'),
(2340, 'Registered On', 1, 'en', 'cor_lut_datetype', '8', 4, '2007-06-15 00:00:00'),
(2339, 'Registered By', 1, 'en', 'cor_lut_actiontype', '12', 4, '2007-06-15 00:00:00'),
(2338, 'Base', 1, 'en', 'cor_lut_txttype', '81', 4, '2008-03-05 00:00:00'),
(2337, 'Inclination', 1, 'en', 'cor_lut_txttype', '82', 4, '2008-03-05 00:00:00'),
(2336, 'Initials', 1, 'en', 'cor_lut_txttype', '68', 4, '2007-05-17 00:00:00'),
(2335, 'Name', 1, 'en', 'cor_lut_txttype', '67', 4, '2007-05-15 00:00:00'),
(2334, 'Truncation', 1, 'en', 'cor_lut_txttype', '83', 4, '2008-03-05 00:00:00'),
(2333, 'Size of materials', 1, 'en', 'cor_lut_txttype', '84', 4, '2008-03-05 00:00:00'),
(2332, 'Coursing/bond', 1, 'en', 'cor_lut_txttype', '85', 4, '2008-03-05 00:00:00'),
(2331, 'Form', 1, 'en', 'cor_lut_txttype', '86', 4, '2008-03-05 00:00:00'),
(2330, 'Direction of face(s)', 1, 'en', 'cor_lut_txttype', '87', 4, '2008-03-05 00:00:00'),
(2329, 'Bonding material', 1, 'en', 'cor_lut_txttype', '88', 4, '2008-03-05 00:00:00'),
(2328, 'Inclusions', 1, 'en', 'cor_lut_txttype', '57', 1, '2006-12-06 11:24:58'),
(2327, 'Finish of stones', 1, 'en', 'cor_lut_txttype', '40', 1, '2006-12-06 11:24:58'),
(2326, 'Method/Conditions', 1, 'en', 'cor_lut_txttype', '36', 1, '2006-12-06 11:24:58'),
(2325, 'Other Comments', 1, 'en', 'cor_lut_txttype', '35', 1, '2006-12-06 11:24:58'),
(2324, 'Description', 1, 'en', 'cor_lut_txttype', '34', 1, '2006-12-06 11:24:58'),
(2323, 'Form', 1, 'en', 'cor_lut_txttype', '30', 1, '2006-12-06 11:24:58'),
(2322, 'Orientation', 1, 'en', 'cor_lut_txttype', '17', 1, '2006-12-06 11:24:58'),
(2321, 'Dimensions', 1, 'en', 'cor_lut_txttype', '8', 1, '2006-12-06 11:24:58'),
(2320, 'Composition', 1, 'en', 'cor_lut_txttype', '6', 1, '2006-12-06 11:24:58'),
(2319, 'Colour', 1, 'en', 'cor_lut_txttype', '5', 1, '2006-12-06 11:24:58'),
(2318, 'Compaction', 1, 'en', 'cor_lut_txttype', '4', 1, '2006-12-06 11:24:58'),
(2317, 'Short Description', 1, 'en', 'cor_lut_txttype', '2', 1, '2006-12-06 11:24:58'),
(2316, 'Interpretation', 1, 'en', 'cor_lut_txttype', '1', 1, '2006-12-06 11:24:58'),
(2315, 'Bonds With', 1, 'en', 'cor_lut_spantype', '3', 1, '2006-12-06 11:23:17'),
(2314, 'Equal To', 1, 'en', 'cor_lut_spantype', '2', 1, '2006-12-06 11:23:17'),
(2313, 'Temporal Vector', 1, 'en', 'cor_lut_spantype', '1', 1, '2006-12-06 11:23:17'),
(2312, 'Raster', 1, 'en', 'cor_lut_mapconnectiontype', '0', 1, '2006-12-06 11:11:01'),
(2311, 'WMS', 1, 'en', 'cor_lut_mapconnectiontype', '5', 1, '2006-12-06 11:11:01'),
(2310, 'PostGIS', 1, 'en', 'cor_lut_mapconnectiontype', '7', 1, '2006-12-06 11:11:01'),
(2309, 'OGR (Shapefiles)', 1, 'en', 'cor_lut_mapconnectiontype', '4', 1, '2006-12-06 11:11:01'),
(2308, 'Interpreted on', 1, 'en', 'cor_lut_datetype', '6', 1, '2006-12-06 11:08:58'),
(2307, 'Drawn On', 1, 'en', 'cor_lut_datetype', '5', 1, '2006-12-06 11:08:58'),
(2306, 'Taken On', 1, 'en', 'cor_lut_datetype', '4', 1, '2006-12-06 11:08:58'),
(2305, 'Date of Excavation', 1, 'en', 'cor_lut_datetype', '3', 1, '2006-12-06 11:08:58'),
(2304, 'Compiled on', 1, 'en', 'cor_lut_datetype', '2', 1, '2006-12-06 11:08:58'),
(2303, 'Issued on', 1, 'en', 'cor_lut_datetype', '1', 1, '2006-12-06 11:08:58'),
(2302, 'Findtype', 1, 'en', 'cor_lut_attributetype', '2', 1, '2006-12-06 11:07:22'),
(2301, 'Record Status Flag', 1, 'en', 'cor_lut_attributetype', '1', 1, '2006-12-06 11:07:22'),
(2300, 'Trench', 1, 'en', 'cor_lut_areatype', '4', 1, '2006-12-06 11:02:41'),
(2299, 'Grid Square', 1, 'en', 'cor_lut_areatype', '3', 1, '2006-12-06 11:02:41'),
(2298, 'Sub Area', 1, 'en', 'cor_lut_areatype', '2', 1, '2006-12-06 11:02:41'),
(2297, 'Interpreted by', 1, 'en', 'cor_lut_actiontype', '9', 1, '2006-12-06 11:00:25'),
(2296, 'Scanned By', 1, 'en', 'cor_lut_actiontype', '7', 1, '2006-12-06 11:00:25'),
(2295, 'Drawn By', 1, 'en', 'cor_lut_actiontype', '6', 1, '2006-12-06 11:00:25'),
(2294, 'Taken By', 1, 'en', 'cor_lut_actiontype', '8', 1, '2006-12-06 11:00:25'),
(2293, 'Supervisor', 1, 'en', 'cor_lut_actiontype', '5', 1, '2006-12-06 11:00:25'),
(2292, 'Director', 1, 'en', 'cor_lut_actiontype', '4', 1, '2006-12-06 11:00:25'),
(2291, 'Checked by', 1, 'en', 'cor_lut_actiontype', '3', 1, '2006-12-06 11:00:25'),
(2290, 'Compiled by', 1, 'en', 'cor_lut_actiontype', '2', 1, '2006-12-06 11:00:25'),
(2289, 'Issued to', 1, 'en', 'cor_lut_actiontype', '1', 1, '2006-12-06 11:00:25'),
(2288, 'Type', 1, 'en', 'cor_tbl_col', '6', 91, '2013-11-29 13:36:43'),
(2287, 'type', 1, 'en', 'cor_tbl_col', '5', 91, '2013-11-29 13:36:43'),
(2286, 'Type', 1, 'en', 'cor_tbl_col', '4', 91, '2013-11-29 13:36:43'),
(2285, 'Context Code', 1, 'en', 'cor_tbl_col', '3', 91, '2013-11-29 13:36:43'),
(2284, 'Created On', 1, 'en', 'cor_tbl_col', '2', 91, '2013-11-29 13:36:43'),
(2283, 'Created By', 1, 'en', 'cor_tbl_col', '1', 91, '2013-11-29 13:36:43'),
(2282, 'Timber', 1, 'en', 'cxt_lut_cxttype', '5', 91, '2013-11-29 12:18:15'),
(2281, 'Skeleton', 1, 'en', 'cxt_lut_cxttype', '4', 91, '2013-11-29 12:18:15'),
(2280, 'Masonry', 1, 'en', 'cxt_lut_cxttype', '3', 91, '2013-11-29 12:18:15'),
(2279, 'Fill', 1, 'en', 'cxt_lut_cxttype', '2', 91, '2013-11-29 12:18:15'),
(2278, 'Cut', 1, 'en', 'cxt_lut_cxttype', '1', 91, '2013-11-29 12:18:15'),
(2277, 'Admins', 1, 'en', 'cor_tbl_sgrp', '2', 91, '2013-11-28 17:05:32'),
(2276, 'Users', 1, 'en', 'cor_tbl_sgrp', '1', 91, '2013-11-28 17:05:32'),
(2275, 'Groups', 1, 'en', 'cor_tbl_module', '11', 91, '2013-11-28 17:03:27'),
(2274, 'Core', 1, 'en', 'cor_tbl_module', '1', 91, '2013-11-28 17:03:27'),
(2273, 'Registered Find', 1, 'en', 'cor_tbl_module', '9', 91, '2013-11-28 17:03:27'),
(2272, 'Sub Group', 1, 'en', 'cor_tbl_module', '8', 91, '2013-11-28 17:03:27'),
(2271, 'Special Find', 1, 'en', 'cor_tbl_module', '7', 91, '2013-11-28 17:03:27'),
(2270, 'Sample', 1, 'en', 'cor_tbl_module', '6', 91, '2013-11-28 17:03:27'),
(2269, 'Address Book', 1, 'en', 'cor_tbl_module', '5', 91, '2013-11-28 17:03:27'),
(2268, 'Plan', 1, 'en', 'cor_tbl_module', '4', 91, '2013-11-28 17:03:27'),
(2267, 'Site Photo', 1, 'en', 'cor_tbl_module', '3', 91, '2013-11-28 17:03:27'),
(2266, 'Section', 1, 'en', 'cor_tbl_module', '12', 91, '2013-11-28 17:03:27'),
(2265, 'Context', 1, 'en', 'cor_tbl_module', '10', 91, '2013-11-28 16:57:57'),
(2736, 'XX', 1, 'en', 'cor_lut_attribute', '346', 91, '2014-02-12 16:19:26'),
(2737, 'DB', 1, 'en', 'cor_lut_attribute', '347', 91, '2014-02-12 16:19:26'),
(2738, 'EO', 1, 'en', 'cor_lut_attribute', '348', 91, '2014-02-12 16:19:26'),
(2739, 'EM', 1, 'en', 'cor_lut_attribute', '349', 91, '2014-02-12 16:19:26'),
(2740, 'SN', 1, 'en', 'cor_lut_attribute', '350', 91, '2014-02-12 16:19:26'),
(2741, 'MU', 1, 'en', 'cor_lut_attribute', '351', 91, '2014-02-12 16:19:26'),
(2742, 'HE', 1, 'en', 'cor_lut_attribute', '352', 91, '2014-02-12 16:19:26'),
(2743, 'ES', 1, 'en', 'cor_lut_attribute', '353', 91, '2014-02-12 16:19:26'),
(2744, 'ED', 1, 'en', 'cor_lut_attribute', '354', 91, '2014-02-12 16:19:26'),
(2745, 'S', 1, 'en', 'cor_lut_attribute', '355', 91, '2014-02-12 16:19:26'),
(2746, 'SO', 1, 'en', 'cor_lut_attribute', '356', 91, '2014-02-12 16:19:26'),
(2747, 'FL', 1, 'en', 'cor_lut_attribute', '357', 91, '2014-02-12 16:19:26'),
(2748, 'EB', 1, 'en', 'cor_lut_attribute', '358', 91, '2014-02-12 16:19:26'),
(2749, 'D', 1, 'en', 'cor_lut_attribute', '359', 91, '2014-02-12 16:19:26'),
(2750, 'G', 1, 'en', 'cor_lut_attribute', '360', 91, '2014-02-12 16:19:26'),
(2751, 'SK', 1, 'en', 'cor_lut_attribute', '361', 91, '2014-02-12 16:19:26'),
(2752, 'PS', 1, 'en', 'cor_lut_attribute', '362', 91, '2014-02-12 16:19:26'),
(2753, 'SP', 1, 'en', 'cor_lut_attribute', '363', 91, '2014-02-12 16:19:26'),
(2754, 'PR', 1, 'en', 'cor_lut_attribute', '364', 91, '2014-02-12 16:19:26'),
(2755, 'ShareGeom', 1, 'en', 'cor_lut_spantype', '5', 91, '2014-02-12 17:36:54'),
(2756, 'Animal Bone', 1, 'en', 'cor_lut_attribute', '365', 91, '2014-02-13 18:38:19'),
(2757, 'CTP', 1, 'en', 'cor_lut_attribute', '366', 91, '2014-02-13 18:38:19'),
(2758, 'Fe Obj', 1, 'en', 'cor_lut_attribute', '367', 91, '2014-02-13 18:38:19'),
(2759, 'skel', 1, 'en', 'cor_lut_attribute', '368', 91, '2014-02-13 18:38:19'),
(2760, 'Daub', 1, 'en', 'cor_lut_attribute', '369', 91, '2014-02-13 18:38:19'),
(2761, 'Cu Obj', 1, 'en', 'cor_lut_attribute', '370', 91, '2014-02-13 18:38:19'),
(2762, 'Stone', 1, 'en', 'cor_lut_attribute', '371', 91, '2014-02-13 18:47:24'),
(2763, 'Worked_bone', 1, 'en', 'cor_lut_attribute', '372', 91, '2014-02-13 18:47:24'),
(2764, 'Shell', 1, 'en', 'cor_lut_attribute', '373', 91, '2014-02-13 18:47:24'),
(2765, 'pb', 1, 'en', 'cor_lut_attribute', '374', 91, '2014-02-13 18:47:24'),
(2766, 'slag', 1, 'en', 'cor_lut_attribute', '375', 91, '2014-02-13 18:47:24'),
(2767, 'Human bone', 1, 'en', 'cor_lut_attribute', '376', 91, '2014-02-13 18:47:24'),
(2768, 'Spot Date', 1, 'en', 'cor_lut_attributetype', '29', 123, '2014-02-19 13:16:46'),
(2769, 'MOD AD1800+', 1, 'en', 'cor_lut_attribute', '377', 91, '2014-02-19 13:27:17'),
(2770, 'M1 AD1070-1125', 1, 'en', 'cor_lut_attribute', '378', 91, '2014-02-19 13:27:17'),
(2771, 'M3 AD1200-1300', 1, 'en', 'cor_lut_attribute', '379', 91, '2014-02-19 13:27:17'),
(2772, 'PM1 AD1550-1720', 1, 'en', 'cor_lut_attribute', '380', 91, '2014-02-19 13:27:17'),
(2773, 'M5 AD1470-1550', 1, 'en', 'cor_lut_attribute', '381', 91, '2014-02-19 13:27:17'),
(2774, 'M4 AD1300-1470', 1, 'en', 'cor_lut_attribute', '382', 91, '2014-02-19 13:27:17'),
(2775, 'M2 AD1125-1200', 1, 'en', 'cor_lut_attribute', '383', 91, '2014-02-19 13:27:17'),
(2776, 'PM2 AD1700-1800', 1, 'en', 'cor_lut_attribute', '384', 91, '2014-02-19 13:27:17'),
(2777, 'SN AD1000-1070', 1, 'en', 'cor_lut_attribute', '385', 91, '2014-02-19 13:27:17'),
(2778, 'IA', 1, 'en', 'cor_lut_attribute', '386', 91, '2014-02-19 13:27:17'),
(2779, 'MIA', 1, 'en', 'cor_lut_attribute', '387', 91, '2014-02-19 13:27:17'),
(2780, 'RB??', 1, 'en', 'cor_lut_attribute', '388', 91, '2014-02-19 13:27:18'),
(2781, 'LSAX', 1, 'en', 'cor_lut_attribute', '389', 91, '2014-02-19 13:27:18'),
(2782, 'RB', 1, 'en', 'cor_lut_attribute', '390', 91, '2014-02-19 13:27:18'),
(2783, 'Section', 1, 'en', 'cor_lut_filetype', '3', 91, '2014-02-21 12:00:41');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_attribute`
--

CREATE TABLE `cor_tbl_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `boolean` tinyint(4) NOT NULL DEFAULT '1',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cor_tbl_attribute`
--

INSERT INTO `cor_tbl_attribute` (`id`, `attribute`, `itemkey`, `itemvalue`, `boolean`, `cre_by`, `cre_on`) VALUES
(1, 318, 'cor_tbl_map', '1', 1, 127, '2015-07-14 12:38:49'),
(2, 83, 'cxt_cd', 'ARK_1', 1, 1, '2015-07-14 14:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_bool`
--

CREATE TABLE `cor_tbl_bool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booltype` int(11) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bool` tinyint(4) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_cmap`
--

CREATE TABLE `cor_tbl_cmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sourcedb` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stecd` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `import_cre_by` int(11) NOT NULL DEFAULT '0',
  `import_cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_cmap_data`
--

CREATE TABLE `cor_tbl_cmap_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmap` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sourcedata` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sourcelocation` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mapto_tbl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mapto_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapto_classtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mapto_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_cmap_structure`
--

CREATE TABLE `cor_tbl_cmap_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmap` int(11) NOT NULL DEFAULT '0',
  `tbl` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  `class` varchar(50) NOT NULL DEFAULT '',
  `uid_col` varchar(255) NOT NULL DEFAULT '',
  `itemkey` varchar(50) NOT NULL DEFAULT '',
  `raw_itemval_tbl` varchar(255) NOT NULL DEFAULT 'FALSE',
  `raw_itemval_col` varchar(255) NOT NULL DEFAULT '',
  `raw_itemval_join_col` varchar(255) NOT NULL DEFAULT 'FALSE',
  `tbl_itemval_join_col` varchar(255) NOT NULL DEFAULT 'FALSE',
  `type` varchar(50) NOT NULL DEFAULT '',
  `lang` varchar(50) NOT NULL DEFAULT '',
  `true` varchar(255) NOT NULL DEFAULT '',
  `false` varchar(255) NOT NULL DEFAULT '',
  `notset` varchar(255) NOT NULL DEFAULT '',
  `lut_tbl` varchar(255) NOT NULL DEFAULT '',
  `lut_idcol` varchar(255) NOT NULL DEFAULT '',
  `lut_valcol` varchar(255) NOT NULL DEFAULT '',
  `end_source_col` varchar(255) NOT NULL DEFAULT '',
  `xmi_itemkey` varchar(10) NOT NULL DEFAULT '',
  `xmi_itemval_col` varchar(100) NOT NULL DEFAULT '',
  `raw_stecd_tbl` varchar(255) NOT NULL DEFAULT '',
  `raw_stecd_col` varchar(255) NOT NULL DEFAULT '',
  `raw_stecd_join_col` varchar(255) NOT NULL DEFAULT '',
  `tbl_stecd_join_col` varchar(255) NOT NULL DEFAULT '',
  `ark_mod` char(3) NOT NULL DEFAULT '',
  `log` char(3) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_col`
--

CREATE TABLE `cor_tbl_col` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cor_tbl_col`
--

INSERT INTO `cor_tbl_col` (`id`, `dbname`, `description`, `cre_by`, `cre_on`) VALUES
(1, 'created_by', 'This holds the user id of the person who created this record', 1, '0000-00-00 00:00:00'),
(2, 'created_on', 'This column holds the date that the record was created', 1, '0000-00-00 00:00:00'),
(3, 'abktype', 'The column holding the addressbook type', 1, '2007-01-15 00:00:00'),
(4, 'cxttype', 'The column holding the context type', 4, '2007-01-15 00:00:00'),
(6, 'rgftype', 'The column on rgf_tbl_rfg holding the rgf type', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_date`
--

CREATE TABLE `cor_tbl_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cor_tbl_date`
--

INSERT INTO `cor_tbl_date` (`id`, `datetype`, `itemkey`, `itemvalue`, `date`, `cre_by`, `cre_on`) VALUES
(1, 1, 'cxt_cd', 'ARK_1', '2015-07-14 00:00:00', 1, '2015-07-14 14:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_file`
--

CREATE TABLE `cor_tbl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `txt` (`file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows fragments of dataclass file to be linked t' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_filter`
--

CREATE TABLE `cor_tbl_filter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filter` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(6) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nname` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sgrp` int(3) NOT NULL DEFAULT '0',
  `cre_by` char(3) NOT NULL DEFAULT '',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `cor_tbl_filter`
--

INSERT INTO `cor_tbl_filter` (`id`, `filter`, `type`, `nname`, `sgrp`, `cre_by`, `cre_on`) VALUES
(33, 'a:2:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"3";s:5:"ktype";s:3:"all";}}', 'set', 'All photos', 0, '4', '2011-06-24 15:41:36'),
(35, 'a:4:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";}s:5:"nname";s:9:"Subgroups";s:6:"cre_by";s:1:"2";}', 'set', 'SGRs', 1, '2', '2011-06-28 17:50:32'),
(37, 'a:2:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"9";s:5:"ktype";s:3:"all";}}', 'set', 'All Reg Finds', 0, '2', '2011-08-25 21:29:28'),
(47, 'a:5:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"7";s:5:"ktype";s:3:"all";}s:5:"nname";s:17:"Als Special Finds";s:6:"cre_by";s:1:"2";i:1;a:3:{s:5:"ftype";s:3:"ftx";s:12:"set_operator";s:9:"intersect";s:3:"src";s:5:"shale";}}', 'set', 'Shale Objects', 0, '2', '2011-08-25 21:42:40'),
(58, 'a:3:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"101";s:2:"bv";s:1:"1";}}', 'set', 'Burial Subgroups', 1, '2', '2011-11-24 11:28:17'),
(45, 'a:2:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"7";s:5:"ktype";s:3:"all";}}', 'set', 'All Special Finds', 0, '2', '2011-08-25 21:39:05'),
(54, 'a:2:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"1";s:5:"ktype";s:3:"all";}}', 'set', 'CXTs', 0, '2', '2011-08-29 19:50:00'),
(56, 'a:2:{s:10:"sort_order";b:0;i:0;a:6:{s:5:"ftype";s:3:"atr";s:2:"bv";s:1:"1";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:1:"1";s:3:"atr";s:3:"209";}}', 'set', 'Completed CXTs', 0, '2', '2011-08-30 16:51:51'),
(57, 'a:2:{s:10:"sort_order";b:0;i:0;a:6:{s:5:"ftype";s:3:"atr";s:2:"bv";s:1:"1";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:1:"1";s:3:"atr";s:3:"209";}}', 'set', 'Completed CXTs', 0, '2', '2011-08-30 16:51:52'),
(52, 'a:3:{s:10:"sort_order";b:0;i:0;a:6:{s:5:"ftype";s:3:"atr";s:2:"bv";s:1:"1";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:1:"1";s:3:"atr";s:1:"1";}i:1;a:4:{s:5:"ftype";s:3:"key";s:12:"set_operator";s:9:"intersect";s:3:"key";s:1:"1";s:5:"ktype";s:3:"all";}}', 'set', 'Compl. CXTs', 0, '2', '2011-08-25 23:16:21'),
(59, 'a:3:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"102";s:2:"bv";s:1:"1";}}', 'set', 'Cremation Subgroups', 1, '2', '2011-11-24 13:32:44'),
(60, 'a:10:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"102";s:2:"bv";s:1:"1";}s:5:"nname";s:19:"Cremation Subgroups";s:6:"cre_by";s:1:"2";s:9:"feed_mode";s:3:"RSS";s:5:"limit";i:25;s:9:"feedtitle";s:23:"All Cremation Subgroups";s:8:"feeddesc";s:30:"A feed for cremation subgroups";s:13:"feeddisp_mode";s:5:"table";}', 'feed', 'All Cremation Subgroups', 0, '2', '2012-09-25 18:35:43'),
(61, 'a:10:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"102";s:2:"bv";s:1:"1";}s:5:"nname";s:19:"Cremation Subgroups";s:6:"cre_by";s:1:"2";s:9:"feed_mode";s:3:"RSS";s:5:"limit";i:25;s:9:"feedtitle";s:19:"Cremation Subgroups";s:8:"feeddesc";s:23:"all cremation subgroups";s:13:"feeddisp_mode";s:5:"table";}', 'feed', 'Cremation Subgroups', 0, '2', '2012-09-25 18:39:27'),
(62, 'a:10:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"102";s:2:"bv";s:1:"1";}s:5:"nname";s:19:"Cremation Subgroups";s:6:"cre_by";s:1:"2";s:9:"feed_mode";s:3:"RSS";s:5:"limit";i:25;s:9:"feedtitle";s:4:"blah";s:8:"feeddesc";s:4:"blah";s:13:"feeddisp_mode";s:5:"table";}', 'feed', 'blah', 0, '2', '2012-09-25 18:43:14'),
(63, 'a:10:{s:10:"sort_order";b:0;i:0;a:4:{s:5:"ftype";s:3:"key";s:3:"key";s:1:"8";s:5:"ktype";s:3:"all";s:12:"set_operator";s:9:"intersect";}i:1;a:6:{s:5:"ftype";s:3:"atr";s:12:"set_operator";s:9:"intersect";s:10:"op_display";s:7:"fauxdex";s:7:"atrtype";s:2:"18";s:3:"atr";s:3:"102";s:2:"bv";s:1:"1";}s:5:"nname";s:19:"Cremation Subgroups";s:6:"cre_by";s:1:"2";s:9:"feed_mode";s:3:"RSS";s:5:"limit";i:25;s:9:"feedtitle";s:3:"bla";s:8:"feeddesc";s:3:"bla";s:13:"feeddisp_mode";s:5:"table";}', 'feed', 'bla', 0, '2', '2012-09-25 18:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_log`
--

CREATE TABLE `cor_tbl_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `refid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vars` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A table to log different types of event' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_map`
--

CREATE TABLE `cor_tbl_map` (
  `id` int(11) unsigned NOT NULL,
  `ste_cd` varchar(30) NOT NULL DEFAULT '',
  `map_cd` varchar(30) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL,
  `cre_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cor_tbl_map`
--

INSERT INTO `cor_tbl_map` (`id`, `ste_cd`, `map_cd`, `cre_by`, `cre_on`) VALUES
(1, 'MNO12', '1', 127, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_maplayer`
--

CREATE TABLE `cor_tbl_maplayer` (
  `id` int(5) NOT NULL,
  `map` int(5) NOT NULL,
  `cre_by` int(5) NOT NULL,
  `cre_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_markup`
--

CREATE TABLE `cor_tbl_markup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `markup` text COLLATE utf8_unicode_ci NOT NULL,
  `mod_short` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=674 ;

--
-- Dumping data for table `cor_tbl_markup`
--

INSERT INTO `cor_tbl_markup` (`id`, `nname`, `markup`, `mod_short`, `language`, `description`, `cre_by`, `cre_on`) VALUES
(1, 'ark', 'ARK', 'cor', 'en', 'name of ARK if it is not set', 1, '0000-00-00 00:00:00'),
(2, 'andyet', 'An unexplained error has occured', 'cor', 'en', 'andyet, worst of all errors', 1, '0000-00-00 00:00:00'),
(3, 'mediauploader', 'Media Uploader', 'cor', 'en', 'Title for mediauploder overlay', 1, '0000-00-00 00:00:00'),
(4, 'from_comp', 'Local Files', 'cor', 'en', 'tab title for local uploads', 1, '0000-00-00 00:00:00'),
(5, 'from_url', 'Remote URL', 'cor', 'en', 'tab title for remote file uploads', 1, '0000-00-00 00:00:00'),
(6, 'from_ml', 'Media Library', 'cor', 'en', 'tab title for media library uploads', 1, '0000-00-00 00:00:00'),
(7, 'draghere', 'Drag files here to Upload', 'cor', 'en', 'Text for draggable file window', 1, '0000-00-00 00:00:00'),
(8, 'urllabel', 'URL:', 'cor', 'en', 'label for url text box', 1, '0000-00-00 00:00:00'),
(9, 'linkfiles', 'Link Files', 'cor', 'en', 'button text for linking files', 1, '0000-00-00 00:00:00'),
(10, 'tgtmodtype', 'Target Modtype', 'cor', 'en', 'label for target modtype in change modtype sf', 1, '0000-00-00 00:00:00'),
(11, 'change', 'Change', 'cor', 'en', 'Button text for changing mod type', 1, '0000-00-00 00:00:00'),
(12, 'modtypechanged', 'Module type successfully changed', 'cor', 'en', 'message on successful change of modtype', 1, '0000-00-00 00:00:00'),
(13, 'numconflictsfs', 'Number of Conflicts:', 'cor', 'en', 'label for number of conflicts', 1, '0000-00-00 00:00:00'),
(14, 'changewarn', 'After change there are some fields that will no longer \r be available. It is not possible to undo this process.', 'cor', 'en', 'warning for change', 1, '0000-00-00 00:00:00'),
(507, 'extent_err', 'Your extents are not valid. Either you have not entered them correctly using commas (minx,miny,maxx,maxy e.g. -130, 14, -60, 55) or your extents are in the wrong order (e.g. your minx is greater than your miny)', 'cor', 'en', 'error label', 1, '2009-11-09 17:39:21'),
(506, 'scales_instr', 'enter in the format: 100000,50000,25000,10000', 'cor', 'en', 'label', 1, '2009-11-09 18:56:05'),
(505, 'scales_label', 'Scales', 'cor', 'en', 'label', 1, '2009-11-09 16:36:44'),
(503, 'extent_label', 'Extents', 'cor', 'en', 'label', 1, '2009-11-09 16:29:35'),
(504, 'extent_instr', 'enter in the format: minx,miny,maxx,maxy', 'cor', 'en', 'label', 1, '2009-11-09 18:56:25'),
(501, 'mapadmin', 'Mapping Administration', 'cor', 'en', 'label', 1, '2009-11-05 14:18:01'),
(502, 'map_admin_instructions', 'This page is used to configure the mapping within ARK. Here you can setup the mapping to take any number of layers from different sources and choose the order and colour of them. You can then save the configuration for use by your users.', 'cor', 'en', 'lbel', 1, '2009-11-05 14:30:16'),
(494, 'sf_number_incompl', 'No number data has been added', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(495, 'noattr', 'No attribute data has been added', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(496, 'filterspan', 'Search by Date Range', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(497, 'filterpanel', 'Search Tools', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(498, 'search_for', 'Search for a', 'cor', 'en', 'For data entry pages', 1, '0000-00-00 00:00:00'),
(499, 'item', 'item', 'cor', 'en', 'For data entry pages', 1, '0000-00-00 00:00:00'),
(500, 'notset', 'Not set', 'cor', 'en', 'For unset sf_attr_boolean', 1, '0000-00-00 00:00:00'),
(491, 'alifail', 'Alias was not added.', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(492, 'success', 'The new item was added to the control list.  Please reset the form to add additional items.', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(493, 'sf_txt_incompl', 'No text data has been added', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(488, 'attrscss', 'Attribute was added succesfully', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(489, 'attrfail', 'Attribute was not added to control list.', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(490, 'aliscss', 'Alias was added sucessfully!', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(485, 'ifsure', 'If you are certain this is not a duplicate, add the term.', 'cor', 'en', 'for adding to control lists', 4, '0000-00-00 00:00:00'),
(486, 'err_attrtypedontexist', 'This attribute type doesn''t exist.  Please try again.', 'cor', 'en', 'For adding to control lists', 4, '0000-00-00 00:00:00'),
(487, 'failure', 'Your attempt was not successful, please try again.', 'cor', 'en', 'for adding to control lists', 4, '0000-00-00 00:00:00'),
(482, 'similar', 'A similar term already exists in this list', 'cor', 'en', 'for adding to control lists', 4, '0000-00-00 00:00:00'),
(483, 'language', 'language', 'cor', 'en', '', 1, '0000-00-00 00:00:00'),
(484, 'tryotherterm', 'Or try another new term', 'cor', 'en', 'for adding to control lists', 4, '0000-00-00 00:00:00'),
(480, 'resetform', 'Reset Form', 'cor', 'en', 'to reset sf_attr_bytype', 4, '0000-00-00 00:00:00'),
(481, 'newtermlab', 'New term label', 'cor', 'en', 'sf_attr_bytype', 4, '0000-00-00 00:00:00'),
(475, 'ctrllsttitle', 'Add to Control Lists', 'cor', 'en', 'For sf_attr_bytype', 4, '0000-00-00 00:00:00'),
(476, 'choosectrllst', 'Choose a control list:', 'cor', 'en', 'for sf_attr_bytype', 4, '0000-00-00 00:00:00'),
(477, 'ctrllst', 'Control List', 'cor', 'en', 'for sf_attr_bytype', 1, '0000-00-00 00:00:00'),
(478, 'newterm', 'Suggest a new term:', 'cor', 'en', 'for sf_attr_bytype', 1, '0000-00-00 00:00:00'),
(479, 'addterm', 'Add Term', 'cor', 'en', 'for sf_attr_bytype', 4, '0000-00-00 00:00:00'),
(471, 'ste_cd', 'Site code', 'cor', 'en', 'A label for site codes', 1, '0000-00-00 00:00:00'),
(472, 'download', 'Download', 'cor', 'en', 'For downloading photos', 4, '0000-00-00 00:00:00'),
(473, 'file_nav', 'Select a batch or module:', 'cor', 'en', 'For file nav (register)', 4, '0000-00-00 00:00:00'),
(474, 'no_reg_files', 'No files selected!', 'cor', 'en', 'For register', 4, '0000-00-00 00:00:00'),
(469, 'stat_flags', 'Record Status', 'cor', 'en', 'Record status flag label', 1, '0000-00-00 00:00:00'),
(470, 'navigation', 'Go to', 'cor', 'en', 'Label for navigation to a record or other', 1, '0000-00-00 00:00:00'),
(468, 'your', 'Your', 'cor', 'en', 'For the yoursavedstuff subform.', 4, '2011-06-09 15:36:35'),
(467, 'edit', 'edit', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(464, 'batchname', 'Batch Name: ', 'cor', 'en', 'For file upload', 4, '0000-00-00 00:00:00'),
(465, 'module', 'Module', 'cor', 'en', 'For file upload', 4, '0000-00-00 00:00:00'),
(466, 'curuploaddir', 'Current Upload Directory: ', 'cor', 'en', 'For file upload', 4, '0000-00-00 00:00:00'),
(463, 'formupload_instructions', 'To upload files, enter a batch name or module and browse to the upload directory below (/www/htdocs/ark/data/upload).', 'cor', 'en', 'For file upload', 4, '0000-00-00 00:00:00'),
(462, 'totalres', 'Total Results:', 'cor', 'en', 'Markup display the total number of search results', 4, '2011-06-09 15:41:50'),
(460, 'filteractor', 'Search by Actor', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(461, 'num_pages', 'Number of results per page:', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(459, 'filteratt', 'Search by Attribute', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(458, 'filteritem', 'Record Type', 'cor', 'en', 'Label for the filter builder when searching by key', 4, '2011-06-10 17:36:50'),
(455, 'make_filter', 'New Search', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(456, 'publicfilters', 'Common Searches', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(457, 'ftx', 'Free Text Search', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(454, 'clearfilter', 'Clear Search', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(452, 'rerunall', 'Rerun All', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(453, 'filtertype', 'Search Type', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(450, 'filters', 'Search', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(451, 'clearall', 'Clear All', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(448, 'welcome', 'Welcome to ARK, ', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(449, 'user_home', 'User Home', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(442, 'user_admin', 'User Administration Home', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(443, 'adduser', 'Add a User', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(444, 'edituser', 'Edit a User', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(445, 'view', 'view', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(446, 'qed', 'edit', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(447, 'choose_lang', 'Choose a language', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(438, 'regabk', 'Address Book', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(439, 'uplfile', 'Upload File', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(440, 'frm_select', 'Please select an option from the left.', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(441, 'data_entry', 'Data Entry Home', 'cor', 'en', '', 4, '0000-00-00 00:00:00'),
(437, 'savedfilters', 'Saved Searches', 'cor', 'en', 'For the mysavedstuff subform in search and user home pages.', 4, '2011-06-09 15:36:21'),
(436, 'files', 'Files', 'cor', 'en', 'It''s some markup for files.', 4, '2008-07-16 00:00:00'),
(435, 'dvlp_filters', 'Make a New Search', 'cor', 'en', 'For the filter building subform.', 4, '2011-06-09 15:37:16'),
(434, 'edtalias', 'Edit Alias', 'cor', 'en', 'For the alias admin options', 4, '2011-06-09 15:31:59'),
(432, 'noxmi', 'No Linked Records', 'cor', 'en', 'Markup for items missing an xmi link', 4, '2008-05-27 00:00:00'),
(433, 'micro_view_forms', 'Record View', 'cor', 'en', 'Heading of micro viewing forms', 4, '2008-06-03 00:00:00'),
(431, 'note', 'Notes', 'cor', 'en', 'Notes for objects and architectural elements', 4, '2007-06-15 00:00:00'),
(430, 'no_interps', 'No Interpretations', 'cor', 'en', 'Markup for indicating there are no interpretations available', 4, '2007-06-06 00:00:00'),
(428, 'home', 'Home', 'cor', 'en', 'Markup for the home page of various sections', 4, '2007-05-17 00:00:00'),
(429, 'spat_data', 'Spatial Data', 'cor', 'en', 'Markup identifying the spatial data panel in the micro view', 4, '2007-05-21 00:00:00'),
(427, 'space', '&nbsp;', 'cor', 'en', 'A non-breaking space when no markup is required', 4, '2007-05-17 00:00:00'),
(426, 'notinauthitems', 'Not in Auth Items', 'cor', 'en', 'Displayed when field is not in auth items.', 4, '2007-05-17 00:00:00'),
(425, 'nofilters', 'No search filters are set, please add a new search filter', 'cor', 'en', 'A message to say that no filters are set', 2, '2006-12-08 00:00:00'),
(421, 'options', 'Options', 'cor', 'en', 'Label for the options column of a table', 1, '0000-00-00 00:00:00'),
(422, 'viewmsg', 'View Record', 'cor', 'en', 'Message for linking out to the record view option', 2, '2006-12-08 00:00:00'),
(423, 'score', 'Relevancy score', 'cor', 'en', 'MArkup for hte relevancy score', 2, '2006-12-08 00:00:00'),
(424, 'norec', 'Your search did not return any results', 'cor', 'en', 'A message to display when the result set is empty', 2, '2006-12-08 00:00:00'),
(420, 'vwmap', 'View as Map', 'cor', 'en', 'Used to give options for results view', 4, '2007-01-15 00:00:00'),
(418, 'vwtbl', 'View as Table', 'cor', 'en', 'To view results as a table', 4, '2007-01-15 00:00:00'),
(419, 'vwcht', 'View as Chat', 'cor', 'en', 'Used to give options for results view', 4, '2007-01-15 00:00:00'),
(417, 'expxml', 'Export as XML', 'cor', 'en', 'To export data as XML', 4, '2007-01-15 00:00:00'),
(415, 'search', 'Search', 'cor', 'en', 'Search', 4, '2007-01-15 00:00:00'),
(416, 'expcsv', 'Export as CSV', 'cor', 'en', 'Exports the results as comma separated values', 4, '2007-01-15 00:00:00'),
(413, 'view_regist', 'Register Viewer', 'cor', 'en', 'Alias of the register viewer', 2, '2006-06-03 00:00:00'),
(414, 'nextrec', 'Next Record', 'cor', 'en', 'A lable for the next record', 2, '2006-06-03 00:00:00'),
(412, 'regist', 'Register', 'cor', 'en', 'Alias of the register entry from', 2, '2006-06-03 00:00:00'),
(409, 'accena', 'Account enabled', 'cor', 'en', 'A message for handling User Admin', 2, '2006-06-01 00:00:00'),
(410, 'accdis', 'Account disabled', 'cor', 'en', 'A message for handling User Admin', 2, '2006-06-01 00:00:00'),
(411, 'detfrm', 'Form', 'cor', 'en', 'Alias of the detailed data entry form', 2, '2006-06-03 00:00:00'),
(408, 'enable', 'Enable / Disable user account', 'cor', 'en', 'A message for handling User Admin', 2, '2006-06-01 00:00:00'),
(406, 'err_nouid', 'No user id has been set.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-06-01 00:00:00'),
(407, 'err_duprel', 'That is a duplicate relationship, it can''t be added.', 'cor', 'en', 'A generic error message', 2, '2006-06-01 00:00:00'),
(404, 'cpw', 'Confirm password', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(405, 'err_nosgrp', 'No security group has been set.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-06-01 00:00:00'),
(403, 'pw', 'Password', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(402, 'email', 'eMail', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(400, 'lname', 'Last name', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(401, 'init', 'Initials', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(399, 'fname', 'First name', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(398, 'uname', 'Username', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(395, 'change_pw', 'Change Password', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(396, 'edt_sgrps', 'Edit ''S-Groups''', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(397, 'edt_user', 'Edit User', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-30 00:00:00'),
(391, 'addusr_newid', 'The new user account has been successfuly created. Make a note of the new username. The new username is:', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(392, 'err_nopw', 'No password was set.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(393, 'err_nocpw', 'No confirmation password was set', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(394, 'err_pwmatch', 'The password and confirmation password do NOT match.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-31 00:00:00'),
(390, 'data_view_forms', 'Search', 'cor', 'en', 'Data viewing forms', 1, '2006-05-31 00:00:00'),
(389, 'addusr_sucs', 'The new user was successfuly created. To activate the account please contact a system administrator.', 'cor', 'en', 'A message for handling User Admin', 1, '0000-00-00 00:00:00'),
(388, 'adusrl_instructions', 'All fields must be filled in.\r\n\r\n\r\nThe new user account will be created enabled.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-30 00:00:00'),
(387, 'addusr_instructions', 'All fields must be filled in. Please check to make sure that you are not accidentally creating a duplicate user.\r\n\r\n\r\nThe new user account will be created disabled. In order to activate the account, the account must be edited by a system administrator.', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-30 00:00:00'),
(385, 'err_noemail', 'No email was set.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(386, 'create_user', 'Create User', 'cor', 'en', 'A message for handling User Admin', 2, '2006-05-30 00:00:00'),
(383, 'err_noinit', 'No ''intials'' were set.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(384, 'err_dupinit', 'Those initials already exist', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(380, 'err_dupuname', 'That username already exists.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(381, 'err_nofname', 'No first name was set.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(382, 'err_nolname', 'No last name was set.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(377, 'err_noflagid', 'No status flag id is set', 'cor', 'en', 'Error for handling record status flags', 2, '2006-05-23 00:00:00'),
(378, 'help', 'Help', 'cor', 'en', 'For the help navigation.', 4, '2011-06-09 15:30:52'),
(379, 'err_nouname', 'No username was set.', 'cor', 'en', 'An error for handling User Admin errors', 2, '2006-05-30 00:00:00'),
(375, 'notdigitised', 'This item has no spatial data attached at the moment ', 'cor', 'en', 'A message to show if theres is no spatial data', 1, '2006-05-23 14:25:00'),
(376, 'datatoolbox', 'Data Toolbox', 'cor', 'en', 'A header for the data toolbox area', 2, '2006-05-23 00:00:00'),
(373, 'err_nodateid', 'No specific date type has been specified.', 'cor', 'en', 'An error message for date types', 2, '2006-05-15 00:00:00'),
(374, 'forms', 'Data Entry', 'cor', 'en', 'A label for a list of forms', 2, '0000-00-00 00:00:00'),
(372, 'err_noactionid', 'No specific action id has been specified.', 'cor', 'en', 'An error message for actions', 2, '2006-05-15 00:00:00'),
(371, 'err_noactiontypeid', 'No action has been specified.', 'cor', 'en', 'An error message for actions', 2, '2006-05-15 00:00:00'),
(370, 'err_noactorid', 'No actor (team member) id has been specified.', 'cor', 'en', 'An error message for handling actors', 2, '2006-05-15 00:00:00'),
(368, 'go', 'go', 'cor', 'en', 'The word go which may be used for buttons', 2, '2006-05-08 17:30:12'),
(369, 'desc', 'Description', 'cor', 'en', 'A label to express the idea of text based description', 2, '2006-05-15 00:00:00'),
(367, 'reset', 'reset', 'cor', 'en', 'The word reset which may be used for buttons', 2, '2006-05-08 17:30:12'),
(366, 'lut_duplicate', 'The following list of possible duplicate entries exist in this lookup table. Please be careful not to add duplicate entries.\r\n\r\n$mkv_dup_str\r\n\r\n', 'cor', 'en', 'Warning message about duplicates with a list of possible duplicates', 2, '2006-05-16 00:00:00'),
(365, 'frm_confirm_lutadd', 'To confirm the addition of ''$mkv_item'' to the lookup table click "$mkv_submit_label" or to use an existing value click "$mkv_reset".<br />\r\n<form action="$mkv_action">\r\n$mkv_hidden\r\n<input type="submit" value="$mkv_submit_label" class="clean_but" />\r\n</form>\r\n<form action="$mkv_action">\r\n$mkv_reset_hidden\r\n<input type="submit" value="$mkv_reset" class="clean_but" />\r\n</form>', 'cor', 'en', 'A confirmation form for adding to luts', 2, '2006-05-15 00:00:00'),
(364, 'err_nospanid', 'No span id number has been specified.', 'cor', 'en', 'An error message for handling tvectors', 2, '2006-05-15 00:00:00'),
(363, 'totalpages', 'Total Pages: ', 'cor', 'en', 'For the total number of results pages', 4, '2011-06-09 15:41:58'),
(362, 'err_nofindtype', 'Either no find type was selected or the findtype selected is not valid.', 'cor', 'en', 'An error message for handling finds', 2, '2006-05-15 00:00:00'),
(361, 'finds', 'Finds', 'cor', 'en', 'A label to display in forms for finds', 2, '2006-05-15 00:00:00'),
(360, 'err_spnlablinvalid', 'The relationship type you selected is not possible to the contexts you selected.', 'cor', 'en', 'Testing', 2, '2006-05-12 00:00:00'),
(359, 'err_tvectlab', 'There is an error with the label you are trying to add to this matrix relationship. This must be a number and it must be entered in the label list.', 'cor', 'en', 'Error message for tvector beginning', 2, '2006-05-11 00:00:00'),
(358, 'err_tvectendinvalid', 'There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be a valid context number in this site code. Check that context has been issued.', 'cor', 'en', 'Error message for tvector beginning', 2, '2006-05-11 00:00:00'),
(357, 'err_tvectbeginvalid', 'There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be a valid context number in this site code. Check that context has been issued.', 'cor', 'en', 'Error message for tvector beginning', 2, '2006-05-11 00:00:00'),
(356, 'err_tvectend', 'There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be set, it may only be numbers and it must be a valid context in this site code.', 'cor', 'en', 'Error message for tvector beginning', 2, '2006-05-11 00:00:00'),
(355, 'err_tvectbeg', 'There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be set, it may only be numbers and it must be a valid context in this site code.', 'cor', 'en', 'Error message for tvector beginning', 2, '2006-05-11 00:00:00'),
(354, 'err_notxtid', 'The text id was not set', 'cor', 'en', 'Error message useful when handling attributes of a text', 2, '2006-05-08 05:30:12'),
(353, 'err_dategen', 'There was an error getting the date', 'cor', 'en', 'Error message to use with dates', 2, '2006-05-08 05:30:12'),
(352, 'err_noorigby', 'The value "record author" was not set', 'cor', 'en', 'Error message to use when no author has been set', 2, '2006-05-08 17:30:12'),
(351, 'err_nocxttype', 'The value "context type" was not set', 'cor', 'en', 'Error message to use when no context type value was set', 2, '2006-05-08 17:30:12'),
(350, 'err_notxt', 'The value "txt" was not set', 'cor', 'en', 'Error message to use when no txt value was set', 2, '2006-05-08 17:30:12'),
(349, 'err_nocxtno', 'The value "context number" was not set', 'cor', 'en', 'Error message to use when no cxt_no value was set', 2, '2006-05-08 17:30:12'),
(348, 'add', 'add', 'cor', 'en', 'The word add which may be used for buttons', 2, '2006-05-08 17:30:12'),
(347, 'savedesc', 'Save description', 'cor', 'en', 'A lable for description forms', 2, '2006-05-08 17:32:12'),
(346, 'save', 'save', 'cor', 'en', 'The word save which may be used for buttons', 2, '2006-05-08 17:30:12'),
(345, 'aliasadminoptions', 'Alias Administration', 'cor', 'en', 'For the left panel header of the alias admin home.', 4, '2011-06-09 15:32:17'),
(508, 'scales_err', 'You have a problem with your scales. Please fill them in using commas (e.g. 25000,10000,5000,1000)', 'cor', 'en', 'scales err', 1, '2009-11-09 18:52:46'),
(509, 'progress_step', 'Step: ', 'cor', 'en', 'label', 1, '2009-11-12 15:40:48'),
(510, 'progress_finish', 'Finished', 'cor', 'en', 'label', 1, '2009-11-12 16:47:37'),
(511, 'mapsave_instr', 'Please enter the following details to save your map', 'cor', 'en', 'label', 1, '2009-11-23 17:50:10'),
(512, 'map_name', 'Name of Map:', 'cor', 'en', 'label', 1, '2009-11-23 17:50:36'),
(513, 'map_comments', 'Comments:', 'cor', 'en', 'label', 1, '2009-11-23 17:51:00'),
(514, 'map_tools', 'Tools', 'cor', 'en', 'label', 1, '2009-11-25 14:36:15'),
(515, 'map_restart', 'Restart', 'cor', 'en', 'label', 1, '2009-11-25 14:36:36'),
(516, 'map_mapsize', 'Map Size', 'cor', 'en', 'size label', 1, '2009-11-25 14:53:01'),
(517, 'map_small', 'small', 'cor', 'en', 'label', 1, '2009-11-25 14:37:27'),
(518, 'map_medium', 'medium', 'cor', 'en', 'label', 1, '2009-11-25 14:37:43'),
(519, 'map_large', 'large', 'cor', 'en', 'label', 1, '2009-11-25 14:37:57'),
(520, 'map_export', 'Export Tools', 'cor', 'en', 'label', 1, '2009-11-25 15:03:16'),
(521, 'map_exportpdf', 'Export to PDF', 'cor', 'en', 'label', 1, '2009-11-25 15:03:33'),
(522, 'map_savemap', 'Save Map', 'cor', 'en', 'label', 1, '2009-11-25 15:03:51'),
(523, 'savesuccessful', 'Save Successful', 'cor', 'en', 'label', 1, '2009-11-25 16:12:18'),
(524, 'saveproblem', 'There was a problem saving: ', 'cor', 'en', 'label', 1, '2009-11-25 16:12:45'),
(525, 'map_public', 'Allow all users to load the map?', 'cor', 'en', 'label', 1, '2009-11-25 17:01:03'),
(526, 'map_choose', 'Load New Map', 'cor', 'en', 'label', 1, '2009-11-25 17:12:50'),
(527, 'map_preconf', 'Public Maps', 'cor', 'en', 'label', 1, '2009-11-25 17:15:52'),
(528, 'map_savedmaps', 'Your Saved Maps', 'cor', 'en', 'label', 1, '2009-11-25 17:16:36'),
(529, 'map_creby', 'Created By', 'cor', 'en', 'label', 1, '2009-11-25 17:16:56'),
(530, 'delete', 'DELETE', 'cor', 'en', 'labels', 4, '2011-06-09 16:17:10'),
(531, 'delete_successful', 'Delete Successful', 'cor', 'en', 'label', 1, '2009-11-25 18:19:27'),
(532, 'map_choose_title', 'Please choose a map below', 'cor', 'en', 'header', 4, '2011-06-10 16:53:41'),
(533, 'build_map', 'Configure a Map', 'cor', 'en', 'label', 1, '2009-11-26 10:31:05'),
(534, 'files_uploaded', 'files uploaded successfully!', 'cor', 'en', 'for file uploads', 4, '0000-00-00 00:00:00'),
(535, 'importoptions', 'Import', 'cor', 'en', 'For the home of the import options.', 4, '2011-06-09 15:32:37'),
(536, 'logout', 'Logout', 'cor', 'en', 'For logout navigation in top right.', 4, '2011-06-09 15:31:20'),
(537, 'infinity', 'view all', 'cor', 'en', 'For viewing all search results', 4, '2011-06-09 15:40:03'),
(538, 'markupadminoptions', 'Markup Administration', 'cor', 'en', 'For the left panel of the markup admin pages.', 4, '2011-06-09 15:31:35'),
(539, 'user', 'User', 'cor', 'en', 'For the left panel labels in the user admin pages.', 4, '2011-06-09 15:44:51'),
(540, 'chgtype', 'type', 'cor', 'en', 'For changing the modtype', 4, '2011-06-09 16:14:34'),
(541, 'chgkey', 'number', 'cor', 'en', 'For changing the item value', 4, '2011-06-09 16:18:53'),
(542, 'changemod', 'Change the Item Type', 'cor', 'en', 'For title of change modtype button', 4, '2011-06-09 16:17:45'),
(543, 'changeval', 'Change the Record Number', 'cor', 'en', 'For changing the itemkey', 4, '2011-06-09 16:18:06'),
(544, 'addctrllst', 'Admin Tools- Add to control lists', 'cor', 'en', 'For a button to add to control lists in data entry, micro view', 4, '2011-06-09 16:19:23'),
(545, 'arkname', 'ARK', 'cor', 'en', 'Markup for the index page of this instance of ark', 4, '2011-06-24 11:15:52'),
(546, 'csv', 'CSV', 'cor', 'en', 'Label for downloading a CSV of search results.', 4, '2011-06-10 12:46:36'),
(547, 'curmodtype', 'Current Type: ', 'cor', 'en', 'For changing modtypes subform', 4, '2011-06-10 16:08:27'),
(548, 'reclabel', 'Record', 'cor', 'en', 'For changing modtypes subform', 4, '2011-06-10 16:09:35'),
(549, 'novalue', 'No records attached.', 'cor', 'en', 'For an xmi subform with no records attached.', 4, '2011-06-10 16:16:59'),
(550, 'mapview', 'Map View', 'cor', 'en', 'For the left panel of the map view', 4, '2011-06-10 16:47:48'),
(551, 'map', 'Map', 'cor', 'en', 'For the left panel options in the map view', 4, '2011-06-10 16:48:04'),
(552, 'map_configure', 'Please configure a map below', 'cor', 'en', 'A message for the map admin tools', 4, '2011-06-10 16:53:09'),
(553, 'vwtext', 'View as Text', 'cor', 'en', 'Hover text for text display of search results', 4, '2011-06-10 16:55:48'),
(554, 'vwthumb', 'View as Thumbnails', 'cor', 'en', 'Hover text for thumbs display of search results', 4, '2011-06-10 16:55:54'),
(555, 'configfields', 'Configure visible fields', 'cor', 'en', 'Hover text for tools to configure fields in search results', 4, '2011-06-10 17:08:00'),
(556, 'vwall', 'View Full Records (Print View)', 'cor', 'en', 'Hover text for displaying all full records for printing', 4, '2011-06-10 17:08:49'),
(557, 'table', 'table', 'cor', 'en', 'Header of table view of search results', 4, '2011-06-10 17:09:28'),
(558, 'text', 'text', 'cor', 'en', 'Header of text view of search results', 4, '2011-06-10 17:10:09'),
(559, 'thumb', 'thumbs', 'cor', 'en', 'header for thumbs view of search results', 4, '2011-06-10 17:10:56'),
(560, 'nofile', 'No files attached to this record', 'cor', 'en', 'Message when no files present in a sf_file', 4, '2011-06-10 17:13:31'),
(561, 'filterkey', 'Search by Record Type', 'cor', 'en', 'Search label for key type filter', 4, '2011-06-10 17:35:51'),
(562, 'projection_label', 'Projection', 'cor', 'en', 'A label for projection in the map admin pages', 4, '2011-06-15 13:19:29'),
(563, 'projection_instr', 'The variables for the projection dropdown are set in the sf_conf', 'cor', 'en', 'Instructions for projections in map admin', 4, '2011-06-15 13:20:32'),
(564, 'OSM_label', 'Use OpenStreetMap as a background?', 'cor', 'en', 'Label for map admin of open streemap', 4, '2011-06-15 13:21:12'),
(565, 'osm_instr', 'Click this if you want an openstreetmap backdrop. <i>NOTE: your other WMS server will need to support the EPSG:900913 projection.</i>', 'cor', 'en', 'Instructions regarding open streetmap', 4, '2011-06-15 13:21:51'),
(566, 'gmap_api_key_label', 'Google Maps API key (if available)', 'cor', 'en', 'Label for the API for google maps', 4, '2011-06-15 13:22:59'),
(567, 'gmap_api_key_instr', 'Please supply your GMap Api Key if you want a Google Maps backdrop. <i>NOTE: your other WMS server will need to support the EPSG:900913 projection.</i>', 'cor', 'en', 'Instructions for insertion of gmap API key', 4, '2011-06-15 13:25:18'),
(568, 'url_label', 'WMS URL', 'cor', 'en', 'For the map admin pages', 4, '2011-06-15 14:03:00'),
(569, 'url_instr', 'URL for the WMS server. <i>NOTE: the url options are set in the sf_conf</i>', 'cor', 'en', 'For mapping admin', 4, '2011-06-15 14:03:53'),
(570, 'getcap_err', 'There appears to be an error with the WMS server you are attempting to access - please check the URL you have set in the sf_conf_baselayer. If it is still not working the server maybe currently offline.', 'cor', 'en', 'An error message for failed map admin setup.', 4, '2011-06-15 14:09:52'),
(571, 'legend_admin_instr', 'Choose which layers you want in your map', 'cor', 'en', 'For map admin pages', 4, '2011-06-15 14:14:47'),
(572, 'nosuggestions', 'No Suggestions', 'cor', 'en', 'Used in the livesearch suggestion script', 4, '2011-06-15 16:11:04'),
(573, 'no_spat_results', 'No spatial results for this search.', 'cor', 'en', 'A message for a spatial search result with no spatial data.', 4, '2011-06-15 17:59:30'),
(574, 'papersize', 'Paper Size', 'cor', 'en', 'Selector for paper size of map download', 4, '2011-06-16 10:54:20'),
(575, 'dl', 'Download', 'cor', 'en', 'A download link for overlays', 4, '2011-06-16 10:54:33'),
(576, 'dlsucs', 'Download Success!', 'cor', 'en', 'Successful generation of a map for download', 4, '2011-06-16 10:54:58'),
(577, 'useradminoptions', 'User Administration', 'cor', 'en', 'A header for the left panel of user admin', 4, '2011-06-23 15:50:06'),
(578, 'userconfigfields', 'Configure Fields', 'cor', 'en', 'A label for sf_userconfigfields', 1, '2011-01-18 18:06:31'),
(579, 'addfield', 'Select a new field to add to the view.', 'cor', 'en', 'Label for sf_userconfigfields', 1, '2011-01-19 12:43:28'),
(580, 'fieldconfiginfo', 'This form allows you to add and remove fields from the current view. In order to remove a field, click the minus sign at the left hand side of the table below. In order to add fields, use the form provided below the table.', 'cor', 'en', 'Label foe sf_userconfigfields', 1, '2011-01-19 12:46:23'),
(581, 'resetresultsinfo', 'In order to reset this view to the standard configuration, please use the reset button.', 'cor', 'en', 'Label for the sf_userconfigfields', 1, '2011-01-19 16:44:19'),
(584, 'rss', 'RSS', 'cor', 'en', 'Label for RSS export from search results', 4, '2011-06-28 17:15:47'),
(585, 'rssexport', 'Export RSS feed of results', 'cor', 'en', 'Hover text for RSS export button', 4, '2011-06-28 17:17:04'),
(587, 'filterattridx', 'Filter by attribute', 'cor', 'en', 'Label for filters', 2, '2011-08-25 23:17:16'),
(588, 'atr', 'Attribute', 'cor', 'en', 'Label for filters', 2, '2011-08-25 23:18:08'),
(589, 'err_notauthforedit', 'You are not authorised to edit the database.', 'cor', 'en', 'A generic cor label', 2, '2011-08-30 14:28:58'),
(590, 'all', 'All', 'cor', 'en', 'A label used by the fauxdex attribute search', 2, '2011-08-30 16:52:23'),
(598, 'waitmsg', 'Please wait, the export may take a few minutes', 'cor', 'en', 'label for export form', 78, '2013-07-05 11:56:30'),
(298, 'navigation', 'Go to', 'cor', 'en', 'Label for navigation to a record or other', 1, '0000-00-00 00:00:00'),
(302, 'file_nav', 'Select a batch or module:', 'cor', 'en', 'For file nav (register)', 4, '0000-00-00 00:00:00'),
(599, 'navigation', 'Go to', 'cor', 'en', 'Label for navigation to a record or other', 1, '0000-00-00 00:00:00'),
(600, 'file_nav', 'Select a batch or module:', 'cor', 'en', 'For file nav (register)', 4, '0000-00-00 00:00:00'),
(601, 'userhomenav', 'home', 'cor', 'en', 'Markup for user home navigation', 1, '2012-03-19 14:55:53'),
(602, 'usersnav', 'user admin', 'cor', 'en', 'Markup for user admin navigation', 1, '2012-03-19 14:56:38'),
(603, 'dataentrynav', 'data entry', 'cor', 'en', 'Markup for data entry navigation', 1, '2012-03-19 14:56:55'),
(604, 'searchnav', 'search', 'cor', 'en', 'Markup for search navigation', 1, '2012-03-19 14:57:11'),
(605, 'recordviewnav', 'record view', 'cor', 'en', 'Markup for micro view navigation', 1, '2012-03-19 14:57:33'),
(606, 'aliasnav', 'alias', 'cor', 'en', 'Markup for alias admin navigation', 91, '2014-02-06 18:34:12'),
(607, 'markupnav', 'markup', 'cor', 'en', 'Markup for markup admin navigation', 91, '2014-02-06 18:34:34'),
(608, 'importnav', 'import', 'cor', 'en', 'Markup for import page navigation', 1, '2012-03-19 14:58:47'),
(609, 'register', 'register', 'cor', 'en', 'register for data entry pages', 91, '2013-11-28 17:23:14'),
(610, 'noregisterdatayet', 'No records entered', 'cor', 'en', 'markup for empty register', 91, '2013-11-29 19:17:21'),
(612, 'splash', 'Welcome to ARK! The default user is ''doe_jd'' with password ''janedoe'' ', 'cor', 'en', 'splash for front', 91, '2013-12-18 21:12:44'),
(613, 'updatesucc', 'Update Successful!', 'cor', 'en', 'successful update message', 91, '2013-12-18 21:44:24'),
(615, 'filtersit', 'Site', 'cor', 'en', 'site filter', 91, '2013-12-18 22:16:18'),
(617, 'dvlp_searchitems', 'Search', 'cor', 'en', 'title for item searches', 91, '2013-12-18 22:22:18'),
(618, 'dvlp_searchcriteria', 'Criteria', 'cor', 'en', 'title for search criteria', 91, '2013-12-18 22:22:47'),
(619, 'nofiles', 'No Files Attached', 'cor', 'en', 'text for file subform when no files attached', 91, '2013-12-20 11:33:54'),
(620, 'batch_instructions_pt1', 'This will guide you through uploading a batch of files to the ARK', 'cor', 'en', 'text for file uploader', 91, '2013-12-20 11:57:31'),
(621, 'batch_uploadbyurl', 'Upload Batch by URL', 'cor', 'en', 'batch upload button text', 91, '2013-12-20 11:58:10'),
(622, 'batchurl', 'Batch URL:', 'cor', 'en', 'explanatory notes for url box', 91, '2013-12-20 11:59:13'),
(623, 'fu_autoreg', 'Auto-register', 'cor', 'en', 'text for auto-register button for files', 91, '2013-12-20 12:01:04'),
(624, 'beingthumbed', 'Creating Thumbnail', 'cor', 'en', 'text for overlay processing', 91, '2013-12-20 12:06:57'),
(626, 'pattern', 'Pattern', 'cor', 'en', 'notes for pattern field', 91, '2013-12-20 12:13:51'),
(627, 'nopattern', 'No Pattern Selected', 'cor', 'en', 'message when pattern is not set', 91, '2013-12-20 12:14:25'),
(628, 'batch_uploadfromfolder', 'Upload From Folder', 'cor', 'en', 'Text for folder batch upload button', 91, '2013-12-20 12:32:35'),
(629, 'uploadthisdir', 'Use this Directory', 'cor', 'en', 'text for upload choose folder button', 91, '2013-12-20 12:33:24'),
(630, 'back', 'Back', 'cor', 'en', 'text for back button', 91, '2013-12-20 12:34:12'),
(631, 'runliveadd', 'ADD', 'cor', 'en', 'text for run live upload button', 91, '2013-12-20 12:34:53'),
(632, 'liveaddresults', 'Live Add Results', 'cor', 'en', 'title text for live upload results', 91, '2013-12-20 12:35:38'),
(633, 'modtype', 'Type', 'cor', 'en', 'Type of module prompt', 91, '2013-12-20 13:27:19'),
(634, 'err_recwasdel', 'Record Deleted!', 'cor', 'en', 'message on successful deletion of record', 91, '2013-12-20 14:41:05'),
(635, 'mapadminnav', 'Map admin', 'cor', 'en', 'markup for map admin tab', 91, '2014-02-06 18:33:24'),
(636, 'mapviewnav', 'Map', 'cor', 'en', 'map tab', 91, '2014-02-13 17:48:38'),
(645, 'uploadsuccess', 'Upload Successful\r\n', 'cor', 'en', 'message returned by single file upload popup', 91, '2014-02-17 12:52:56'),
(646, 'linksuccess', 'File linked to ', 'cor', 'en', 'message returned by file upload popup window', 91, '2014-02-17 12:42:33'),
(647, 'filterabk', 'Addressbook Filter', 'abk', 'en', 'Label for address book filter', 91, '2014-02-17 12:42:33'),
(648, 'filtername', 'Search by Name', 'abk', 'en', 'message returned by file upload popup window', 91, '2014-02-17 12:42:33'),
(649, 'issuenext', 'Issue next', 'cor', 'en', 'shown in register for auto incrementing numbers', 91, '2014-02-17 12:42:33'),
(656, 'filetype', 'File Type', 'cor', 'en', 'label for filetype in upload', 91, '2014-02-21 12:01:13'),
(657, 'dryrunresults', 'Dry Run Results', 'cor', 'en', 'Title for upload dry run page', 91, '2014-02-21 12:02:20'),
(658, 'batch_instructions_step2', 'Step 2\r\n', 'cor', 'en', 'Step 2 of upload', 91, '2014-02-21 12:06:40'),
(659, 'draghere', 'Drag Here', 'cor', 'en', 'media uploader instructions', 91, '2014-02-21 12:21:10'),
(660, 'media_uploader', 'Media Uploader', 'cor', 'en', 'Media Uploader Title', 91, '2014-02-21 12:21:45'),
(661, 'from_comp', 'From Computer', 'cor', 'en', 'media uploader option from computer', 91, '2014-02-21 12:22:16'),
(662, 'from_url', 'From Remote URL', 'cor', 'en', 'media uploader option from remote URL', 91, '2014-02-21 12:22:53'),
(663, 'from_ml', 'From Media Library', 'cor', 'en', 'media uploader option from media library', 91, '2014-02-21 12:24:19'),
(664, 'section', 'Section', 'cor', 'en', 'Section file sf title', 91, '2014-02-21 12:27:43'),
(88, 'cxts', 'Contexts', 'cxt', 'en', 'Markup for showing contexts linked to other records in the xmi viewer', 4, '2007-05-17 00:00:00'),
(89, 'site_photo', 'Site Photos', 'sph', 'en', 'Markup for displaying Site Photo', 2, '2009-11-11 14:05:15'),
(91, 'interp', 'Interpretation', 'cxt', 'en', 'Markup for labelling the interpretation', 4, '2007-05-17 00:00:00'),
(92, 'plan', 'Plan', 'pln', 'en', 'Markup for the micro viewer displaying drawn plans', 4, '2007-05-18 00:00:00'),
(97, 'matrix', 'Stratigraphic Matrix', 'cxt', 'en', 'Markup for the display of the stratigraphic matrix', 4, '2007-06-06 00:00:00'),
(98, 'othermatrix', 'Same as', 'cxt', 'en', 'Markup for displaying additional stratigraphic relationships not present in the matrix', 2, '2009-11-11 14:06:04'),
(99, 'photo', 'Photos', 'sph', 'en', 'For displaying of photos for finds/arch elements, etc (ie anything not site photos or geophotos)', 4, '2007-06-15 00:00:00'),
(100, 'note', 'Notes', 'spf', 'en', 'Notes for objects and architectural elements', 4, '2007-06-15 00:00:00'),
(103, 'cxt_reg_instructions', 'Be careful when you are inputting stuff here', 'cxt', 'en', 'Markup for Context Instructions', 4, '2007-06-15 00:00:00'),
(104, 'samplecondition', 'Condition of Deposit', 'smp', 'en', 'label for sample condition sf', 75, '2008-06-13 09:11:07'),
(105, 'volume', 'Original Sample Volume', 'smp', 'en', 'label for volume subform', 2, '2009-11-13 12:35:32'),
(106, 'samplequestions', 'Original Sample Questions', 'smp', 'en', 'label for questions subform', 2, '2009-11-13 12:32:47'),
(110, 'samples', 'Samples', 'smp', 'en', 'label for samples', 2, '2008-06-16 00:00:00'),
(107, 'subsamples_boolean', 'Subsample?', 'smp', 'en', 'label for subsample form', 78, '2008-06-13 15:01:17'),
(111, 'objects', 'Objects', 'spf', 'en', 'A title for the special find xmi viewer', 4, '2008-06-18 00:00:00'),
(112, 'smp_cxt_desc', 'Context Type (brief description)', 'smp', 'en', 'For a brief description of the context for sample sheets', 2, '2008-06-25 00:00:00'),
(113, 'samplecontam', 'Sample contamination', 'smp', 'en', 'A label for the sample contamination sf', 2, '2008-06-25 00:00:00'),
(114, 'samplevolprop', 'Sample size as proportion of deposit', 'smp', 'en', 'Label for sample proportion sf', 2, '2008-06-25 00:00:00'),
(115, 'samplecontamdesc', 'Describe other contamination', 'smp', 'en', 'Label for othe contamination of sample description', 2, '2008-06-25 00:00:00'),
(116, 'sphmeta', 'Photo Record Details', 'sph', 'en', 'A label to express the idea of sph meta info', 2, '2008-07-01 00:00:00'),
(117, 'foundin', 'From Context', 'smp', 'en', 'A label for objects found in a context', 2, '2008-07-02 00:00:00'),
(118, 'samplestatus', 'Sample Status', 'smp', 'en', 'markup for sample status', 78, '2008-08-12 11:34:24'),
(120, 'notes', 'Processing Notes', 'smp', 'en', 'markup for notes form', 2, '2009-11-13 12:35:01'),
(121, 'hf_numofbags', 'Number of Bags (Heavy Frac)', 'smp', 'en', 'labels for hf_numofbags', 78, '2008-08-12 12:44:39'),
(122, 'lf_numofbags', 'Number of Bags (Light Frac)', 'smp', 'en', 'label for lf_numofbags', 78, '2008-08-12 12:44:56'),
(123, 'numofbags', 'Number of Bags', 'smp', 'en', 'label for bag number', 78, '2008-08-12 12:52:44'),
(124, 'fractionstatus', 'Fraction Status', 'smp', 'en', 'label for fraction status', 78, '2008-08-12 12:51:59'),
(162, 'provperiod', 'Period (provis.)', 'cxt', 'en', 'Label for prov period sf', 2, '2009-11-11 13:14:29'),
(165, 'lghfrac', 'Light Fraction', 'smp', 'en', 'Label for sf frame', 2, '2009-11-13 12:27:38'),
(166, 'hvyfrac', 'Heavy Fraction', 'smp', 'en', 'Label for an sf frame', 2, '2009-11-13 12:28:19'),
(167, 'smpdesc', 'Field Soil Description', 'smp', 'en', 'Label for sample sf', 2, '2009-11-13 12:31:14'),
(176, 'basicinterp', 'Basic Interp.', 'cxt', 'en', 'Label for the basic interpretation', 2, '2009-12-08 15:24:36'),
(177, 'sgrmatrix', 'Sub Group Matrix', 'sgr', 'en', 'Label for the subgroup matrix', 2, '2009-12-08 15:25:09'),
(179, 'subgroup', 'Sub-group', 'sgr', 'en', 'Label for an xmi to subgroup sf', 2, '2009-12-10 15:51:18'),
(189, 'rgfbasicinterp', 'Registered Find Basics', 'rgf', 'en', 'Label for the RGF mod', 2, '2010-10-22 17:30:00'),
(190, 'rgfxmicxt', 'From Context', 'rgf', 'en', 'Label for reg finds', 2, '2010-10-22 17:40:40'),
(191, 'rgfdispchars', 'Display Characteristics', 'rgf', 'en', 'Label for Reg finds', 2, '2010-10-23 13:11:25'),
(192, 'xrayid', 'X-Ray ID', 'rgf', 'en', 'Label for rgf''s', 2, '2010-10-23 14:06:37'),
(193, 'rgfxmispf', 'Linked Special Finds', 'rgf', 'en', 'Label for rgf', 2, '2010-10-23 14:48:02'),
(194, 'rgfcomment', 'Comments', 'rgf', 'en', 'Label for rgfs', 2, '2010-10-23 14:59:35'),
(195, 'linkedrgfs', 'Reg. Finds', 'rgf', 'en', 'Label for SPFs', 2, '2010-10-23 18:07:50'),
(196, 'sgrnarrative', 'Subgroup Narrative Text', 'sgr', 'en', 'A label for the Subgroups', 2, '2010-11-30 15:16:14'),
(207, 'plancxt', 'Plan Context', 'pln', 'en', 'A label for subgroups', 2, '2010-11-30 16:58:27'),
(210, 'datingnarrative', 'Dating Narrative', 'sgr', 'en', 'Label for SGRs', 2, '2010-12-01 15:16:33'),
(582, 'basicinfo', 'Basic Information', 'sgr', 'en', 'Frame for basic information', 4, '2011-06-23 17:12:33'),
(583, 'meta', 'Record Details', 'cxt', 'en', 'A record meta label', 4, '2011-06-23 17:33:34'),
(586, 'sgr_plan', 'Subgroup Plan', 'sgr', 'en', 'A label for the SGR plan SF', 2, '2011-08-25 22:16:33'),
(591, 'sgrs', 'Sub Groups', 'grp', 'en', 'A label for the GRP module', 2, '2011-08-31 19:24:46'),
(592, 'grpmatrix', 'Group Matrix', 'grp', 'en', 'A label for the GRP module', 2, '2011-08-31 19:26:59'),
(593, 'grpdatingnarrative', 'Dating Information', 'grp', 'en', 'A label for the GRP module', 2, '2011-08-31 19:27:45'),
(594, 'grpnarrative', 'Group Description', 'grp', 'en', 'A label for the GRP module', 2, '2011-08-31 19:28:10'),
(595, 'cxt_plan', 'Plan', 'cxt', 'en', 'A label for the CXT module', 2, '2011-08-31 21:05:24'),
(596, 'group', 'Group', 'grp', 'en', 'A label for Group subforms', 2, '2011-11-24 11:45:16'),
(597, 'phase', 'Phase', 'grp', 'en', 'A label for group phasing', 2, '2011-12-08 12:04:21'),
(614, 'filterabk', 'Addressbook', 'abk', 'en', 'filter name', 91, '2013-12-18 22:15:48'),
(616, 'filtercxt', 'Contexts', 'cxt', 'en', 'context filter name', 91, '2014-02-13 15:33:26'),
(625, 'contextprocess', 'Process', 'cxt', 'en', 'title for Process subform', 91, '2013-12-20 12:11:16'),
(637, 'cxtsheet', 'Context Sheet', 'cxt', 'en', 'tile for sf_file for context pdfs', 91, '2014-02-10 19:22:02'),
(638, 'prntcontext', 'Parent Context', 'cxt', 'en', 'A context link that will provide spatial data where none is available', 91, '2014-02-12 11:12:24'),
(639, 'contextassesment', 'Basic Interpretation and Process', 'cxt', 'en', 'title for a box containing the Basic Interp. code and the Process code', 91, '2014-02-12 17:49:43'),
(640, 'shrgeom', 'Parent Context', 'cxt', 'en', 'Title to link to geometry', 91, '2014-02-12 17:51:01'),
(641, 'filtergrp', 'Groups', 'grp', 'en', 'Filter Groups', 91, '2014-02-13 15:33:55'),
(642, 'filtersgr', 'Sub Groups', 'sgr', 'en', 'Filter Subgroups', 91, '2014-02-13 15:34:24'),
(643, 'filtersmp', 'Samples', 'smp', 'en', 'Filter Samples', 91, '2014-02-13 15:34:49'),
(644, 'ftr_find_type', 'Find', 'cxt', 'en', 'Filter contexts based on finds', 91, '2014-02-13 17:49:23'),
(665, 'spotdate', 'Spot Date', 'cxt', 'en', 'title fro spotdate sf', 91, '2014-02-19 13:22:40'),
(666, 'filterperiod', 'Period', 'cor', 'en', 'text for filterperiod', 1, '0000-00-00 00:00:00'),
(667, 'reccomplete', 'Complete Records', 'cxt', 'en', 'filter prompt for completed records', 1, '2015-07-14 00:00:00'),
(668, 'reccompleteno', 'Incomplete Records', 'cxt', 'en', 'filter prompt for completed records', 1, '2015-07-14 00:00:00'),
(669, 'filterpln', 'Plans', 'pln', 'en', 'prompt for plan filter', 1, '2015-07-14 00:00:00'),
(670, 'filtersmp', 'Samples', 'smp', 'en', 'prompt for samples filter', 1, '2015-07-14 00:00:00'),
(671, 'filterrgf', 'Registered Finds', 'rgf', 'en', 'filter prompt for registered finds', 1, '2015-07-14 00:00:00'),
(672, 'filtersph', 'Site Photos', 'sph', 'en', 'prompt for Site Photos', 1, '2015-07-14 00:00:00'),
(673, 'filtersec', 'Sections', 'sec', 'en', 'filter prompt for Sections', 1, '2015-07-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_module`
--

CREATE TABLE `cor_tbl_module` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shortform` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(3) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cor_tbl_module`
--

INSERT INTO `cor_tbl_module` (`id`, `itemkey`, `name`, `shortform`, `description`, `cre_by`, `cre_on`) VALUES
(2, 'abk_cd', 'mod_abk', 'abk', 'The Address Book Module', 1, '2008-01-16 00:00:00'),
(1, 'cor_cd', 'mod_cor', 'cor', 'A core module for adding markup and aliases', 4, '2011-06-23 00:00:00'),
(3, 'sph_cd', 'mod_sph', 'sph', 'The Site Photo module', 1, '2006-06-03 00:00:00'),
(4, 'pln_cd', 'mod_pln', 'pln', 'The Planning module', 1, '2006-06-03 00:00:00'),
(5, 'abk_cd', 'mod_abk', 'abk', 'The Address Book Module', 1, '2008-01-16 00:00:00'),
(6, 'smp_cd', 'mod_smp', 'smp', 'The Sample Module', 1, '2008-01-16 00:00:00'),
(7, 'spf_cd', 'mod_spf', 'spf', 'The Special Finds Module', 1, '2008-06-18 00:00:00'),
(8, 'sgr_cd', 'mod_sgr', 'sgr', 'The subroup module', 1, '2009-12-08 00:00:00'),
(9, 'rgf_cd', 'mod_rgf', 'rgf', 'The Registered Finds Module', 1, '0000-00-00 00:00:00'),
(10, 'cxt_cd', 'mod_cxt', 'cxt', 'A core module for adding markup and aliases', 1, '2011-06-23 00:00:00'),
(11, 'grp_cd', 'mod_grp', 'grp', 'The Group module', 1, '2011-08-30 00:00:00'),
(12, 'sec_cd', 'mod_sec', 'sec', 'The Sections module', 1, '2011-08-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_number`
--

CREATE TABLE `cor_tbl_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` int(11) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemkey` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fragtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fragid` int(5) NOT NULL DEFAULT '0',
  `number` double NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cor_tbl_number`
--

INSERT INTO `cor_tbl_number` (`id`, `numbertype`, `typemod`, `itemkey`, `itemvalue`, `fragtype`, `fragid`, `number`, `cre_by`, `cre_on`) VALUES
(1, 9, '', 'cor_tbl_ma', '1', '', 0, 7, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_sgrp`
--

CREATE TABLE `cor_tbl_sgrp` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sgrp` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A table of security groups' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cor_tbl_sgrp`
--

INSERT INTO `cor_tbl_sgrp` (`id`, `sgrp`, `cre_by`, `cre_on`) VALUES
(1, 'users', 1, '2005-11-08 00:00:00'),
(2, 'admins', 2, '2005-11-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_span`
--

CREATE TABLE `cor_tbl_span` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` int(11) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemkey` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `beg` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `end` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_spanattr`
--

CREATE TABLE `cor_tbl_spanattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `span` int(10) NOT NULL DEFAULT '0',
  `spanlabel` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible attributing of text fragments' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_ste`
--

CREATE TABLE `cor_tbl_ste` (
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_txt`
--

CREATE TABLE `cor_tbl_txt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txttype` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `txt` longtext COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `txt` (`txt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cor_tbl_txt`
--

INSERT INTO `cor_tbl_txt` (`id`, `txttype`, `itemkey`, `itemvalue`, `txt`, `language`, `cre_by`, `cre_on`) VALUES
(1, 3, 'abk_cd', 'ARK_1', 'Jane Doe', 'en', 1, '2014-02-20 18:43:38'),
(2, 4, 'abk_cd', 'ARK_1', 'JD', 'en', 1, '2014-02-20 18:43:38'),
(3, 134, 'cor_tbl_map', '1', '[-8477.4,6712033.8]', 'en', 127, '2015-07-14 12:38:49'),
(4, 2, 'cxt_cd', 'ARK_1', 'Topsoil', 'en', 1, '2015-07-14 14:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_users`
--

CREATE TABLE `cor_tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initials` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sfilter` int(11) NOT NULL DEFAULT '0',
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_enabled` tinyint(4) NOT NULL DEFAULT '1',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cor_tbl_users`
--

INSERT INTO `cor_tbl_users` (`id`, `username`, `password`, `firstname`, `lastname`, `initials`, `sfilter`, `email`, `account_enabled`, `cre_by`, `cre_on`) VALUES
(1, 'doe_jd', 'a8c0d2a9d332574951a8e4a0af7d516f', 'Jane', 'Doe', 'JD', 0, 'support@lparchaeology.com', 1, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_wmc`
--

CREATE TABLE `cor_tbl_wmc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comments` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `wmc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `scales` text COLLATE utf8_unicode_ci NOT NULL,
  `extents` text COLLATE utf8_unicode_ci NOT NULL,
  `projection` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `zoom` int(11) NOT NULL DEFAULT '0',
  `legend_array` text COLLATE utf8_unicode_ci NOT NULL,
  `OSM` int(11) NOT NULL DEFAULT '0',
  `gmap_api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `public` tinyint(4) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `txt` (`wmc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_wwwpages`
--

CREATE TABLE `cor_tbl_wwwpages` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sortposs` int(3) NOT NULL DEFAULT '0',
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sgrp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `navname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `navlinkvars` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `defaultvars` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(3) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `cor_tbl_wwwpages`
--

INSERT INTO `cor_tbl_wwwpages` (`id`, `name`, `title`, `sortposs`, `file`, `sgrp`, `navname`, `navlinkvars`, `defaultvars`, `cre_by`, `cre_on`) VALUES
(1, 'User Home', 'User Home Page', 1, 'user_home.php', '3', 'home', '?view=home', 'pownergrp|1,default_view|home,cur_page|user_home,cur_code_dir|php/user_home/', 2, '2005-11-08 00:00:00'),
(2, 'Data Entry', 'Data Entry', 3, 'data_entry.php', '1', 'data entry', '?view=home', 'pownergrp|1,default_view|home,cur_page|data_entry,cur_code_dir|php/data_entry/', 2, '2005-11-08 00:00:00'),
(3, 'User Admin', 'User Admin', 2, 'user_admin.php', '2', 'users', '?view=home', 'cur_code_dir|php/user_admin/', 2, '2006-05-26 00:00:00'),
(4, 'Data Viewing', 'Data Viewing', 4, 'data_view.php', '3', 'search', '?view=standard', 'pownergrp|1,default_view|home,cur_page|data_view,cur_code_dir|php/data_view/', 1, '2006-05-31 00:00:00'),
(7, 'micro_view', 'Micro Viewer', 5, 'micro_view.php', '3', 'record view', '?view=home', 'default_view|home,cur_page|micro_view,cur_code_dir|php/micro_view/', 2, '2006-06-06 00:00:00'),
(8, 'map_view', 'Map Viewer', 6, 'map_view.php', '3', 'map view', '?view=home', 'default_view|home,cur_page|map_view,cur_code_dir|php/map_view/', 1, '2006-09-11 00:00:00'),
(9, 'import_tools', 'Import Tools', 8, 'import.php', '2', 'import', '?view=home', 'default_view|home,cur_page|import_tools,cur_code_dir|php/import/', 4, '2007-05-18 00:00:00'),
(10, 'login', 'Login', 7, 'index.php', '3', 'login', '', '', 4, '2007-05-18 00:00:00'),
(11, 'alias_admin', 'Alias Admin', 8, 'alias_admin.php', '2', 'aliases', '?view=home', 'default_view|home,cur_page|alias_admin,cur_code_dir|php/alias_admin/', 4, '2007-05-18 00:00:00'),
(12, 'markup_admin', 'Markup Admin', 8, 'markup_admin.php', '2', 'markup', '?view=home', 'default_view|home,cur_page|markup_admin,cur_code_dir|php/markup_admin/', 4, '2007-05-18 00:00:00'),
(13, 'overlay_holder', 'Overlay', 10, 'overlay_holder.php', '3', 'Overlay', '?view=home', 'default_view|home,cur_page|overlay_holder,cur_code_dir|php/overlay_holder/', 1, '2006-06-06 00:00:00'),
(14, 'map_admin', 'Map Admin', 7, 'map_admin.php', '2', 'map admin', '?view=home', 'default_view|home,cur_page|map_admin,cur_code_dir|php/map_admin/', 4, '2007-05-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cor_tbl_xmi`
--

CREATE TABLE `cor_tbl_xmi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `xmi_itemkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `xmi_itemvalue` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cxt_lut_cxttype`
--

CREATE TABLE `cxt_lut_cxttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cxttype` varchar(255) NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `cxt_lut_cxttype`
--

INSERT INTO `cxt_lut_cxttype` (`id`, `cxttype`, `cre_by`, `cre_on`) VALUES
(1, 'Cut', 1, '2008-03-05 00:00:00'),
(2, 'Fill', 1, '2008-03-05 00:00:00'),
(3, 'Masonry', 1, '2008-03-05 00:00:00'),
(4, 'Skeleton', 1, '2008-03-10 00:00:00'),
(5, 'Timber', 1, '2008-06-25 00:00:00'),
(6, 'Deposit', 1, '2013-12-18 21:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `cxt_phases`
--

CREATE TABLE `cxt_phases` (
  `ste_cd` varchar(255) NOT NULL DEFAULT '',
  `cxt_no` varchar(255) NOT NULL DEFAULT '',
  `cxt_cd` varchar(255) NOT NULL DEFAULT '',
  `nname` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cxt_strat_rels`
--

CREATE TABLE `cxt_strat_rels` (
  `uid` varchar(255) NOT NULL DEFAULT '',
  `ste_cd` varchar(255) NOT NULL DEFAULT '',
  `cxt_no` varchar(255) NOT NULL DEFAULT '',
  `beg` varchar(255) NOT NULL DEFAULT '',
  `end` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cxt_tbl_cxt`
--

CREATE TABLE `cxt_tbl_cxt` (
  `cxt_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cxt_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cxttype` int(3) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cxt_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cxt_tbl_cxt`
--

INSERT INTO `cxt_tbl_cxt` (`cxt_cd`, `cxt_no`, `ste_cd`, `cxttype`, `cre_by`, `cre_on`) VALUES
('ARK_1', 1, 'ARK', 2, 1, '2015-07-14 14:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `grp_tbl_grp`
--

CREATE TABLE `grp_tbl_grp` (
  `grp_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `grp_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`grp_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pln_tbl_pln`
--

CREATE TABLE `pln_tbl_pln` (
  `pln_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pln_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pln_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rgf_lut_rgftype`
--

CREATE TABLE `rgf_lut_rgftype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rgftype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rgf_lut_rgftype`
--

INSERT INTO `rgf_lut_rgftype` (`id`, `rgftype`, `cre_by`, `cre_on`) VALUES
(1, 'object', 2, '0000-00-00 00:00:00'),
(2, 'coin', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rgf_tbl_rgf`
--

CREATE TABLE `rgf_tbl_rgf` (
  `rgf_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rgf_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `rgftype` int(3) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rgf_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sec_tbl_sec`
--

CREATE TABLE `sec_tbl_sec` (
  `sec_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sec_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sec_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sec_tbl_sec`
--

INSERT INTO `sec_tbl_sec` (`sec_cd`, `sec_no`, `ste_cd`, `cre_by`, `cre_on`) VALUES
('HGI11_1', 1, 'HGI11', 91, '2014-02-21 12:04:28'),
('HGI11_2', 2, 'HGI11', 91, '2014-02-21 12:05:41'),
('HGI11_3', 3, 'HGI11', 91, '2014-02-21 12:09:30'),
('HGI11_4', 4, 'HGI11', 91, '2014-02-21 12:09:36'),
('HGI11_31', 31, 'HGI11', 91, '2014-02-21 12:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `sgr_tbl_sgr`
--

CREATE TABLE `sgr_tbl_sgr` (
  `sgr_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sgr_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sgr_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smp_tbl_smp`
--

CREATE TABLE `smp_tbl_smp` (
  `smp_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `smp_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`smp_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sph_tbl_sph`
--

CREATE TABLE `sph_tbl_sph` (
  `sph_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sph_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sph_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
