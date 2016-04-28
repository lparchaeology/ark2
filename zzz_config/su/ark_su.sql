-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Server version: 5.5.9
-- PHP Version: 5.3.5

--
-- Database: `ark`
--

-- --------------------------------------------------------
--
-- Table structure and data for the Stratigraphic Unit ARK set-up
-- Compatible with ARK v1.0
-- ---------------------------------------------------
-- FIRST WE WILL ADD ALL THE RELEVANT MODULE INFORMATION AND TABLES
-- ---------------------------------------------------

--
-- Dumping data for table `cor_tbl_module`
--

INSERT INTO `cor_tbl_module` VALUES(3, 'cxt_cd', 'mod_cxt', 'cxt', 'The context module', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(4, 'sph_cd', 'mod_sph', 'sph', 'The Site Photo module', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(5, 'pln_cd', 'mod_pln', 'pln', 'The Planning module', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(6, 'gph_cd', 'mod_gph', 'gph', 'The Geophoto module', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(7, 'ael_cd', 'mod_ael', 'ael', 'The module for recording architectural elements', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(8, 'spf_cd', 'mod_spf', 'spf', 'The Special Finds module', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_module` VALUES(9, 'cns_cd', 'mod_cns', 'cns', 'The coins module', 1, '2011-07-22 00:00:00');

--
-- And add the cxttype column heading to the cor_tbl_col
--

INSERT INTO `cor_tbl_col` VALUES(2, 'cxttype', 'The column holding the context type', 1, '2011-07-22 00:00:00');


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
-- Table structure for table `cxt_lut_cxttype`
--

CREATE TABLE `cxt_lut_cxttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cxttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cxt_lut_cxttype`
--

INSERT INTO `cxt_lut_cxttype` VALUES(1, 'SU', 1, '2011-07-22 00:00:00');
INSERT INTO `cxt_lut_cxttype` VALUES(2, 'SSU', 1, '2011-07-22 00:00:00');
INSERT INTO `cxt_lut_cxttype` VALUES(3, 'HRU', 1, '2011-07-22 00:00:00');

--
-- Table structure for table `ael_tbl_ael`
--

CREATE TABLE `ael_tbl_ael` (
  `ael_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ael_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ael_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `spf_tbl_spf`
--

CREATE TABLE `spf_tbl_spf` (
  `spf_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `spf_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`spf_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `cns_tbl_cns`
--

CREATE TABLE `cns_tbl_cns` (
  `cns_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cns_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cns_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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


--
-- Table structure for table `gph_tbl_gph`
--

CREATE TABLE `gph_tbl_gph` (
  `gph_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `gph_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`gph_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ---------------------------------------------------
-- NOW ADD RELEVANT ENTRIES TO THE LOOKUP TABLES
-- ---------------------------------------------------

--
-- Dumping data for table `cor_lut_actiontype`
--

INSERT INTO `cor_lut_actiontype` VALUES(1, 'issuedto', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(2, 'compiledby', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(3, 'checkedby', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(4, 'directedby', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(5, 'supervisedby', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(8, 'takenby', 'gph', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(6, 'drawnby', 'pln', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(7, 'scannedby', 'pln', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(9, 'interpretedby', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(10, 'notedby', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(11, 'restoredby', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(12, 'registeredby', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_actiontype` VALUES(14, 'recordedby', 'fld', 1, '2011-07-22 00:00:00');


--
-- Dumping data for table `cor_lut_attribute`
--

INSERT INTO `cor_lut_attribute` VALUES(1, 'datcmp', 1, 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(2, 'chkd', 1, 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(3, 'not_exc', 1, 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(4, 'part_exc', 1, 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(5, 'exc', 1, 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(10, 'irs', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(9, 'thnwalled', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(8, 'blkglaze', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(11, 'sgrs', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(12, 'ars', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(13, 'cwares', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(14, 'acwares', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(15, 'cwares', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(16, 'ramph', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(17, 'rlamps', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(18, 'rother', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(19, 'rpaint', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(20, 'forware', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(21, 'sprsglazed', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(22, 'leadglazed', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(23, 'tinglazed', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(24, 'sgraffito', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(25, 'mcwares', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(26, 'mtesti', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(27, 'mlamps', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(28, 'medother', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(29, 'moderncer', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(42, 'mcws', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(44, 'medanf', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(45, 'dolium', 3, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(46, 'major', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(47, 'minor', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(48, 'surface', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(49, 'chemical', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(50, 'biological', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(51, 'repair', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(52, 'accretions', 4, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(53, 'good', 5, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(54, 'fair', 5, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(55, 'poor', 5, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(56, 'unacceptable', 5, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(57, 'none', 6, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(58, 'clean', 6, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(59, 'mount', 6, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(60, 'conserve', 6, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(61, '1', 7, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(62, '2', 7, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(63, '3', 7, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(64, '4', 7, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(65, '5', 7, 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(66, 'male', 8, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(67, 'female', 8, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(68, 'indeterminate', 8, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(69, 'undeterminable', 8, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(70, 'infant', 9, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(71, 'child', 9, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(72, 'juvenile', 9, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(73, 'adult', 9, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(74, 'primary', 10, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(75, 'secondary', 10, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(76, 'disturbed', 10, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(77, 'reduction', 10, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(78, 'supine', 11, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(79, 'prone', 11, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(80, 'lateralsn', 11, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(81, 'lateraldx', 11, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(82, 'other', 11, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(83, 'temporoconn', 12, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(84, 'temporodisc', 12, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(85, 'temporoabs', 12, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(86, 'cranioconn', 13, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(87, 'craniodisc', 13, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(88, 'cranioabs', 13, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(89, 'atlanteconn', 14, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(90, 'atlantedisc', 14, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(91, 'atlanteabs', 14, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(92, 'epistoconn', 15, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(93, 'epistodisc', 15, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(94, 'epistoabs', 15, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(95, 'thorax', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(96, 'sternum', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(97, 'pelvis', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(98, 'knee', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(99, 'ankle', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(100, 'clavicle', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(101, 'scapula', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(102, 'humerus', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(103, 'femur', 16, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(104, 'emptyspace', 17, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(105, 'fullspace', 17, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(106, 'other', 17, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(107, 'conn', 18, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(108, 'disconn', 18, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(109, 'abs', 18, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(110, 'conn', 19, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(111, 'disconn', 19, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(112, 'abs', 19, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(113, 'conn', 20, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(114, 'disconn', 20, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(115, 'abs', 20, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(116, 'conn', 21, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(117, 'disconn', 21, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(118, 'abs', 21, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(119, 'conn', 22, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(120, 'disconn', 22, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(121, 'abs', 22, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(122, 'conn', 23, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(123, 'disconn', 23, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(124, 'abs', 23, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(125, 'conn', 24, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(126, 'disconn', 24, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(127, 'abs', 24, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(128, 'conn', 25, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(129, 'disconn', 25, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(130, 'abs', 25, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(131, 'conn', 26, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(132, 'disconn', 26, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(133, 'abs', 26, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(134, 'conn', 27, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(135, 'disconn', 27, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(136, 'abs', 27, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(137, 'conn', 28, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(138, 'disconn', 28, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(139, 'abs', 28, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(140, 'conn', 29, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(141, 'disconn', 29, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(142, 'abs', 29, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(143, 'conn', 30, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(144, 'disconn', 30, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(145, 'abs', 30, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(146, 'conn', 31, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(147, 'disconn', 31, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(148, 'abs', 31, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(149, 'conn', 32, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(150, 'disconn', 32, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(151, 'abs', 32, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(152, 'conn', 33, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(153, 'disconn', 33, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(154, 'abs', 33, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(155, 'conn', 34, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(156, 'disconn', 34, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(157, 'abs', 34, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(158, 'conn', 35, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(159, 'disconn', 35, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(160, 'abs', 35, 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attribute` VALUES(161, 'romanglaze', 3, 'cxt', 1, '2011-07-22 00:00:00');


--
-- Dumping data for table `cor_lut_attributetype`
--

INSERT INTO `cor_lut_attributetype` VALUES(1, 'recflag', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(3, 'certype', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(4, 'damage', 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(5, 'condition', 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(6, 'work', 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(7, 'priority', 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(8, 'hrusex', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(9, 'hruage', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(10, 'hrudeposition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(11, 'hruposition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(12, 'temporo', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(13, 'cranio', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(14, 'atlante', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(15, 'epistrofeo', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(16, 'effectsdecomp', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(17, 'decomposition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(18, 'cervical', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(19, 'dishandsx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(20, 'dishanddx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(21, 'disfootsx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(22, 'disfootdx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(23, 'scapulasx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(24, 'scapuladx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(25, 'atlanto', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(26, 'lumbar', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(27, 'lumsacrum', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(28, 'sacrumsx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(29, 'sacrumdx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(30, 'kneesx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(31, 'kneedx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(32, 'anklesx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(33, 'ankledx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(34, 'tarsalsx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_attributetype` VALUES(35, 'tarsaldx', 'cxt', 1, '2011-07-22 00:00:00');


--
-- Dumping data for table `cor_lut_datetype`
--

INSERT INTO `cor_lut_datetype` VALUES(1, 'issuedon', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(2, 'compiledon', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(3, 'excavatedon', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(4, 'takenon', 'gph', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(5, 'drawnon', 'pln', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(6, 'interpretedon', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(7, 'notedon', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(8, 'registeredon', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_datetype` VALUES(9, 'recordedon', 'fld', 1, '2011-07-22 00:00:00');


INSERT INTO `cor_lut_filetype` VALUES(1, 'images', 1, '2011-02-03 13:47:41');



--
-- Dumping data for table `cor_lut_numbertype`
--

INSERT INTO `cor_lut_numbertype` VALUES(5, 'total', 'cxt', 'unit', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_numbertype` VALUES(6, 'clavicle', 'cxt', 'unit', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_numbertype` VALUES(7, 'humerus', 'cxt', 'unit', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_numbertype` VALUES(8, 'radius', 'cxt', 'unit', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_numbertype` VALUES(9, 'tibia', 'cxt', 'unit', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_numbertype` VALUES(10, 'femur', 'cxt', 'unit', 1, '2011-07-22 00:00:00');

--
-- Dumping data for table `cor_lut_spanlabel`
--

INSERT INTO `cor_lut_spanlabel` VALUES(1, 1, 'cor', 'cut', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spanlabel` VALUES(2, 1, 'cor', 'cover', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spanlabel` VALUES(3, 1, 'cor', 'abutt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spanlabel` VALUES(4, 1, 'cor', 'fill', 1, '2011-07-22 00:00:00');


--
-- Dumping data for table `cor_lut_spantype`
--

INSERT INTO `cor_lut_spantype` VALUES(1, 'tvector', '', '', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spantype` VALUES(2, 'sameas', '', '', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spantype` VALUES(3, 'relatedto', '', '', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spantype` VALUES(4, 'comparanda', '', '', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spantype` VALUES(5, 'aelcomparanda', 'For ael comparanda', '', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_spantype` VALUES(6, 'daterange', 'For date range for SUs', '', 1, '2011-07-22 00:00:00');


--
-- Dumping data for table `cor_lut_txttype`
--

INSERT INTO `cor_lut_txttype` VALUES(1, 'interp', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(2, 'short_desc', 'cor', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(4, 'compac', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(5, 'colour', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(6, 'compo', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(8, 'dims', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(17, 'orient', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(28, 'definition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(29, 'critofdistinction', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(30, 'formation', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(31, 'geocomponents', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(32, 'orgcomponents', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(33, 'artcomponents', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(34, 'desc', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(35, 'observ', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(36, 'excavtech', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(37, 'conservation', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(38, 'static', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(39, 'tech', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(40, 'finition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(41, 'reuse', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(42, 'miseenoeuvre', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(43, 'chronoelem', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(44, 'interp_date', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(45, 'interp_period', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(46, 'phase', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(47, 'strat_reliability', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(48, 'num_courses', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(49, 'mortar', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(50, 'bricks', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(51, 'h_mortar', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(52, 'cons_mortar', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(53, 'h_courses', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(54, 'col_ssu', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(55, 'h_5courses', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(56, 'aggregates', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(57, 'inclusions', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(58, 'totlength', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(59, 'wshould', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(60, 'lspine', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(61, 'wpelvis', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(62, 'condition', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(63, 'posn_cranium', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(64, 'posn_arm', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(65, 'posn_leg', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(66, 'pospelvis', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(69, 'sutype', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(70, 'material', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(71, 'cons_int', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(72, 'note', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(73, 'stone', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(74, 'sex', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(75, 'age', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(76, 'denomination', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(77, 'obverse', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(78, 'reverse', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(79, 'diameter', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(80, 'weight', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(81, 'metal', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(82, 'date', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(83, 'amount', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(84, 'length', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(85, 'height', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(86, 'width', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(87, 'depth', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(88, 'slength', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(89, 'thick', 'ael', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(90, 'storage', 'spf', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(91, 'gravetype', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(92, 'gravecover', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(93, 'sexdiagnostic', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(94, 'agediagnostic', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(95, 'deposnature', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(96, 'assocfinds', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(97, 'posn_observations', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(99, 'uppersx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(100, 'handsx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(101, 'upperdx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(102, 'handdx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(103, 'lowersx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(104, 'lowerdx', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(105, 'deposprocesses', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(106, 'causecompression', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(107, 'thorax', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(108, 'sunkensternum', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(109, 'pelvis', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(110, 'kneedecomp', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(111, 'ankledecomp', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(112, 'vertclavicle', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(113, 'obscapula', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(114, 'medhumerus', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(115, 'latfemur', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(116, 'reference', 'cns', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(117, 'd13c', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(118, 'd15n', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(119, 'yield', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(120, 'cnratio', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(121, 'radiocarbon', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(122, 'potterynotes', 'cxt', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_lut_txttype` VALUES(123, 'mint', 'cns', 1, '2011-07-22 00:00:00');


-- ----------------------------------------
-- NOW WE WILL ADD THE RELEVANT ALIAS FOR ALL OF THE ABOVE
-- -----------------------------------------

--
-- Dumping data for table `cor_tbl_alias`
--

INSERT INTO `cor_tbl_alias` VALUES(0, 'Issued to', 1, 'en', 'cor_lut_actiontype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Compiled by', 1, 'en', 'cor_lut_actiontype', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Checked by', 1, 'en', 'cor_lut_actiontype', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Director', 1, 'en', 'cor_lut_actiontype', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Supervisor', 1, 'en', 'cor_lut_actiontype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Taken By', 1, 'en', 'cor_lut_actiontype', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Drawn By', 1, 'en', 'cor_lut_actiontype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Interpreted by', 1, 'en', 'cor_lut_actiontype', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Data Entry Complete', 1, 'en', 'cor_lut_attribute', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Record Checked', 1, 'en', 'cor_lut_attribute', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Not Excavated', 1, 'en', 'cor_lut_attribute', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Partially Excavated', 1, 'en', 'cor_lut_attribute', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Excavated', 1, 'en', 'cor_lut_attribute', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Italian Red Slip', 1, 'en', 'cor_lut_attribute', '10', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Thin Walled', 1, 'en', 'cor_lut_attribute', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Black Glaze', 1, 'en', 'cor_lut_attribute', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- South Gaul Red Slip', 1, 'en', 'cor_lut_attribute', '11', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- African Red Slip', 1, 'en', 'cor_lut_attribute', '12', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Coarse Wares', 1, 'en', 'cor_lut_attribute', '13', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- African Cooking Wares', 1, 'en', 'cor_lut_attribute', '14', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Cooking Wares', 1, 'en', 'cor_lut_attribute', '15', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Amphorae', 1, 'en', 'cor_lut_attribute', '16', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Lamps', 1, 'en', 'cor_lut_attribute', '17', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Other', 1, 'en', 'cor_lut_attribute', '18', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Red Painted', 1, 'en', 'cor_lut_attribute', '19', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Forum Ware', 1, 'en', 'cor_lut_attribute', '20', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Sparse Glazed', 1, 'en', 'cor_lut_attribute', '21', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Lead-based Glazed', 1, 'en', 'cor_lut_attribute', '22', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Tin-based Glazed', 1, 'en', 'cor_lut_attribute', '23', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Sgraffito Tirennico', 1, 'en', 'cor_lut_attribute', '24', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Cooking Wares', 1, 'en', 'cor_lut_attribute', '25', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Testi', 1, 'en', 'cor_lut_attribute', '26', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Lamps', 1, 'en', 'cor_lut_attribute', '27', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Other', 1, 'en', 'cor_lut_attribute', '28', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Modern Ceramics', 1, 'en', 'cor_lut_attribute', '29', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Coarse Ware', 1, 'en', 'cor_lut_attribute', '42', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Record Status', 1, 'en', 'cor_lut_attributetype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Issued on', 1, 'en', 'cor_lut_datetype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Compiled on', 1, 'en', 'cor_lut_datetype', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Date of Excavation', 1, 'en', 'cor_lut_datetype', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Taken On', 1, 'en', 'cor_lut_datetype', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Drawn On', 1, 'en', 'cor_lut_datetype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Interpreted on', 1, 'en', 'cor_lut_datetype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Total', 1, 'en', 'cor_lut_numbertype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Cuts', 1, 'en', 'cor_lut_spanlabel', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Covers', 1, 'en', 'cor_lut_spanlabel', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Abuts', 1, 'en', 'cor_lut_spanlabel', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Fills', 1, 'en', 'cor_lut_spanlabel', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Cut By', 2, 'en', 'cor_lut_spanlabel', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Is Covered By', 2, 'en', 'cor_lut_spanlabel', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Is Abutted By', 2, 'en', 'cor_lut_spanlabel', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Filled By', 2, 'en', 'cor_lut_spanlabel', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Temporal Vector', 1, 'en', 'cor_lut_spantype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Equal To', 1, 'en', 'cor_lut_spantype', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Bonds With', 1, 'en', 'cor_lut_spantype', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Interpretation', 1, 'en', 'cor_lut_txttype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Short Description', 1, 'en', 'cor_lut_txttype', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Compaction', 1, 'en', 'cor_lut_txttype', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Colour', 1, 'en', 'cor_lut_txttype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Composition', 1, 'en', 'cor_lut_txttype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Dimensions', 1, 'en', 'cor_lut_txttype', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Orientation', 1, 'en', 'cor_lut_txttype', '17', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Definition', 1, 'en', 'cor_lut_txttype', '28', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Criteria of Distinction', 1, 'en', 'cor_lut_txttype', '29', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Formation', 1, 'en', 'cor_lut_txttype', '30', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Geological Components', 1, 'en', 'cor_lut_txttype', '31', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Organic Components', 1, 'en', 'cor_lut_txttype', '32', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Artificial Components', 1, 'en', 'cor_lut_txttype', '33', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Description', 1, 'en', 'cor_lut_txttype', '34', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Observations', 1, 'en', 'cor_lut_txttype', '35', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Excavation Technique', 1, 'en', 'cor_lut_txttype', '36', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'State of Conservation', 1, 'en', 'cor_lut_txttype', '37', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Static Function', 1, 'en', 'cor_lut_txttype', '38', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Technique', 1, 'en', 'cor_lut_txttype', '39', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Finish', 1, 'en', 'cor_lut_txttype', '40', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Reuse', 1, 'en', 'cor_lut_txttype', '41', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Mise en Oeuvre', 1, 'en', 'cor_lut_txttype', '42', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Chronological Elements', 1, 'en', 'cor_lut_txttype', '43', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Date', 1, 'en', 'cor_lut_txttype', '44', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Period', 1, 'en', 'cor_lut_txttype', '45', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Phase', 1, 'en', 'cor_lut_txttype', '46', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Stratigraphic Reliability', 1, 'en', 'cor_lut_txttype', '47', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Number of Courses', 1, 'en', 'cor_lut_txttype', '48', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Type of Mortar', 1, 'en', 'cor_lut_txttype', '49', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Description of Brick/Tile', 1, 'en', 'cor_lut_txttype', '50', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Height of Mortar Beds (cm)', 1, 'en', 'cor_lut_txttype', '51', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Consistency and Colour of Mortar', 1, 'en', 'cor_lut_txttype', '52', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Height of Courses (cm)', 1, 'en', 'cor_lut_txttype', '53', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Colour of SSU', 1, 'en', 'cor_lut_txttype', '54', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Height of 5 Courses (cm)', 1, 'en', 'cor_lut_txttype', '55', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Aggregates', 1, 'en', 'cor_lut_txttype', '56', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Inclusions', 1, 'en', 'cor_lut_txttype', '57', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Length of skeleton', 1, 'en', 'cor_lut_txttype', '58', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Width of Shoulders', 1, 'en', 'cor_lut_txttype', '59', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Length of Spine', 1, 'en', 'cor_lut_txttype', '60', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Width of Pelvis', 1, 'en', 'cor_lut_txttype', '61', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Condition of Bones', 1, 'en', 'cor_lut_txttype', '62', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Position of Cranium', 1, 'en', 'cor_lut_txttype', '63', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Position of Arms', 1, 'en', 'cor_lut_txttype', '64', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Position of Legs', 1, 'en', 'cor_lut_txttype', '65', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Position of Pelvis', 1, 'en', 'cor_lut_txttype', '66', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Context', 1, 'en', 'cor_tbl_module', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Site Photo', 1, 'en', 'cor_tbl_module', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Plan', 1, 'en', 'cor_tbl_module', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Geophoto', 1, 'en', 'cor_tbl_module', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'HRU', 1, 'en', 'cxt_lut_cxttype', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'SU', 1, 'en', 'cxt_lut_cxttype', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'SSU', 1, 'en', 'cxt_lut_cxttype', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Context Type', 1, 'en', 'cor_tbl_col', '2', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'SU Type', 1, 'en', 'cor_lut_txttype', '69', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Arch. Element', 1, 'en', 'cor_tbl_module', '7', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Registered By', 1, 'en', 'cor_lut_actiontype', '12', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Registered On', 1, 'en', 'cor_lut_datetype', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Restorer', 1, 'en', 'cor_lut_actiontype', '11', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Noted By', 1, 'en', 'cor_lut_actiontype', '10', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Material', 1, 'en', 'cor_lut_txttype', '70', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Conservation Interventions', 1, 'en', 'cor_lut_txttype', '71', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Notes', 1, 'en', 'cor_lut_txttype', '72', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Object', 1, 'en', 'cor_tbl_module', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Noted On', 1, 'en', 'cor_lut_datetype', '7', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Description of Stone', 1, 'en', 'cor_lut_txttype', '73', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sex', 1, 'en', 'cor_lut_txttype', '74', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Age', 1, 'en', 'cor_lut_txttype', '75', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medieval- Amphorae', 1, 'en', 'cor_lut_attribute', '44', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Dolium', 1, 'en', 'cor_lut_attribute', '45', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Denomination', 1, 'en', 'cor_lut_txttype', '76', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Obverse', 1, 'en', 'cor_lut_txttype', '77', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Reverse', 1, 'en', 'cor_lut_txttype', '78', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Diameter', 1, 'en', 'cor_lut_txttype', '79', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Weight', 1, 'en', 'cor_lut_txttype', '80', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Metal', 1, 'en', 'cor_lut_txttype', '81', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Coin', 1, 'en', 'cor_tbl_module', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Date', 1, 'en', 'cor_lut_txttype', '82', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'English', 1, 'en', 'cor_lut_language', '1', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '', 1, 'en', 'cor_lut_spantype', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Amount', 1, 'en', 'cor_lut_txttype', '83', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Length', 1, 'en', 'cor_lut_txttype', '84', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Height', 1, 'en', 'cor_lut_txttype', '85', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Width', 1, 'en', 'cor_lut_txttype', '86', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Depth', 1, 'en', 'cor_lut_txttype', '87', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Side Length (Triangle)', 1, 'en', 'cor_lut_txttype', '88', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Thickness', 1, 'en', 'cor_lut_txttype', '89', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Storage Requirement', 1, 'en', 'cor_lut_txttype', '90', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Major structural damage', 1, 'en', 'cor_lut_attribute', '46', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Minor structural damage', 1, 'en', 'cor_lut_attribute', '47', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Surface damage', 1, 'en', 'cor_lut_attribute', '48', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Chemical detioration', 1, 'en', 'cor_lut_attribute', '49', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Biological infestation', 1, 'en', 'cor_lut_attribute', '50', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Old/sub-standard repair', 1, 'en', 'cor_lut_attribute', '51', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Accretions', 1, 'en', 'cor_lut_attribute', '52', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Damage', 1, 'en', 'cor_lut_attributetype', '4', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Good', 1, 'en', 'cor_lut_attribute', '53', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Fair', 1, 'en', 'cor_lut_attribute', '54', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Poor', 1, 'en', 'cor_lut_attribute', '55', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Unacceptable', 1, 'en', 'cor_lut_attribute', '56', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Overall Condition Assessment', 1, 'en', 'cor_lut_attributetype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'None', 1, 'en', 'cor_lut_attribute', '57', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Clean', 1, 'en', 'cor_lut_attribute', '58', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Mount', 1, 'en', 'cor_lut_attribute', '59', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Treat/Conserve', 1, 'en', 'cor_lut_attribute', '60', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Further Conservation Work Required', 1, 'en', 'cor_lut_attributetype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Priority', 1, 'en', 'cor_lut_attributetype', '7', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Ceramic Type', 1, 'en', 'cor_lut_attributetype', '3', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '1', 1, 'en', 'cor_lut_attribute', '61', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '2', 1, 'en', 'cor_lut_attribute', '62', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '3', 1, 'en', 'cor_lut_attribute', '63', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '4', 1, 'en', 'cor_lut_attribute', '64', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, '5', 1, 'en', 'cor_lut_attribute', '65', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, ' ', 1, 'en', 'cor_lut_spantype', '5', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Type of Grave', 1, 'en', 'cor_lut_txttype', '91', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Type of Grave Cover', 1, 'en', 'cor_lut_txttype', '92', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sex- Diagnostic Criteria', 1, 'en', 'cor_lut_txttype', '93', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Age- Diagnostic Criteria', 1, 'en', 'cor_lut_txttype', '94', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Nature of disturbance', 1, 'en', 'cor_lut_txttype', '95', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sex', 1, 'en', 'cor_lut_attributetype', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Age', 1, 'en', 'cor_lut_attributetype', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Male', 1, 'en', 'cor_lut_attribute', '66', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Female', 1, 'en', 'cor_lut_attribute', '67', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Indeterminate', 1, 'en', 'cor_lut_attribute', '68', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Undeterminable', 1, 'en', 'cor_lut_attribute', '69', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Infant (0-2 years)', 1, 'en', 'cor_lut_attribute', '70', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Child (3-10 years)', 1, 'en', 'cor_lut_attribute', '71', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Juvenile (10-18 years)', 1, 'en', 'cor_lut_attribute', '72', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Adult', 1, 'en', 'cor_lut_attribute', '73', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Deposition Type', 1, 'en', 'cor_lut_attributetype', '10', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Primary', 1, 'en', 'cor_lut_attribute', '74', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Secondary', 1, 'en', 'cor_lut_attribute', '75', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Disturbed Primary', 1, 'en', 'cor_lut_attribute', '76', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Reduction', 1, 'en', 'cor_lut_attribute', '77', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Associated Finds', 1, 'en', 'cor_lut_txttype', '96', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Observations', 1, 'en', 'cor_lut_txttype', '97', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Supine', 1, 'en', 'cor_lut_attribute', '78', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Prone', 1, 'en', 'cor_lut_attribute', '79', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lateral sn', 1, 'en', 'cor_lut_attribute', '80', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lateral dx', 1, 'en', 'cor_lut_attribute', '81', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Other', 1, 'en', 'cor_lut_attribute', '82', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '83', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '84', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '85', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '86', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '87', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '88', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '89', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '90', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '91', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '92', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '93', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '94', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Ligaments: Temporo-Mandibolare', 1, 'en', 'cor_lut_attributetype', '12', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Ligaments: Cranio-Atlante', 1, 'en', 'cor_lut_attributetype', '13', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Ligaments: Atlante-Epistrofeo', 1, 'en', 'cor_lut_attributetype', '14', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Ligaments: Epistrofeo-C3', 1, 'en', 'cor_lut_attributetype', '15', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Position of skeleton', 1, 'en', 'cor_lut_attributetype', '11', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Upper (sx)', 1, 'en', 'cor_lut_txttype', '99', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Hand (sx)', 1, 'en', 'cor_lut_txttype', '100', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Upper (dx)', 1, 'en', 'cor_lut_txttype', '101', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Hand (dx)', 1, 'en', 'cor_lut_txttype', '102', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Lower (sx)', 1, 'en', 'cor_lut_txttype', '103', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Limbs: Lower (dx)', 1, 'en', 'cor_lut_txttype', '104', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Effects of decomposition or compression', 1, 'en', 'cor_lut_attributetype', '16', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Decomposition', 1, 'en', 'cor_lut_attributetype', '17', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Opening of the thorax', 1, 'en', 'cor_lut_attribute', '95', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sunken sternum', 1, 'en', 'cor_lut_attribute', '96', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Pelvis', 1, 'en', 'cor_lut_attribute', '97', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Knee-caps', 1, 'en', 'cor_lut_attribute', '98', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Anklebones', 1, 'en', 'cor_lut_attribute', '99', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Verticalization of clavicle', 1, 'en', 'cor_lut_attribute', '100', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Oblique scapula', 1, 'en', 'cor_lut_attribute', '101', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medial rotation of humerus', 1, 'en', 'cor_lut_attribute', '102', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lateral rotation of femur', 1, 'en', 'cor_lut_attribute', '103', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'In empty space', 1, 'en', 'cor_lut_attribute', '104', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'In full space', 1, 'en', 'cor_lut_attribute', '105', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Other', 1, 'en', 'cor_lut_attribute', '106', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Bones significantly disturbed by depositional processes', 1, 'en', 'cor_lut_txttype', '105', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Cause of compression', 1, 'en', 'cor_lut_txttype', '106', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Clavicle (cm)', 1, 'en', 'cor_lut_numbertype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Humerus (cm)', 1, 'en', 'cor_lut_numbertype', '7', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Radius (cm)', 1, 'en', 'cor_lut_numbertype', '8', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Tibia (cm)', 1, 'en', 'cor_lut_numbertype', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Femur (cm)', 1, 'en', 'cor_lut_numbertype', '10', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '122', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '107', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '108', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '109', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '110', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '111', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '112', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '113', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '114', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '115', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '116', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '117', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '118', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '119', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '120', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '121', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '123', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '124', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '125', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '126', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '127', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '128', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '129', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '130', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '131', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '132', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '133', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '134', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '135', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '136', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '137', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '138', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '139', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '140', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '141', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '142', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '143', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '144', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '145', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '146', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '147', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '148', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '149', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '150', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '151', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '152', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '153', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '154', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '155', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '156', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '157', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'connected', 1, 'en', 'cor_lut_attribute', '158', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'disconnected', 1, 'en', 'cor_lut_attribute', '159', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'absent', 1, 'en', 'cor_lut_attribute', '160', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Cervical column', 1, 'en', 'cor_lut_attributetype', '18', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Distal part of the hand (sx)', 1, 'en', 'cor_lut_attributetype', '19', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Distal part of the hand (dx)', 1, 'en', 'cor_lut_attributetype', '20', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Distal part of the foot (sx)', 1, 'en', 'cor_lut_attributetype', '21', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Distal part of the foot (dx)', 1, 'en', 'cor_lut_attributetype', '22', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Scapula-humerus joint (sx)', 1, 'en', 'cor_lut_attributetype', '23', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Scapula-humerus joint (dx)', 1, 'en', 'cor_lut_attributetype', '24', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Atlanto-occipital', 1, 'en', 'cor_lut_attributetype', '25', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lumbar column', 1, 'en', 'cor_lut_attributetype', '26', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lumbar-sacrum', 1, 'en', 'cor_lut_attributetype', '27', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sacrum-iliac (sx)', 1, 'en', 'cor_lut_attributetype', '28', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sacrum-iliac (dx)', 1, 'en', 'cor_lut_attributetype', '29', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Knee-cap (sx)', 1, 'en', 'cor_lut_attributetype', '30', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Knee-cap (dx)', 1, 'en', 'cor_lut_attributetype', '31', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Anklebones (sx)', 1, 'en', 'cor_lut_attributetype', '32', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Anklebones (dx)', 1, 'en', 'cor_lut_attributetype', '33', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Tarsals (sx)', 1, 'en', 'cor_lut_attributetype', '34', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Tarsals (dx)', 1, 'en', 'cor_lut_attributetype', '35', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Opening of the thorax', 1, 'en', 'cor_lut_txttype', '107', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Sunken sternum', 1, 'en', 'cor_lut_txttype', '108', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Pelvis', 1, 'en', 'cor_lut_txttype', '109', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Knee-caps', 1, 'en', 'cor_lut_txttype', '110', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Anklebones', 1, 'en', 'cor_lut_txttype', '111', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Verticalization of clavicle', 1, 'en', 'cor_lut_txttype', '112', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Oblique scapula', 1, 'en', 'cor_lut_txttype', '113', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Medial rotation of humerus', 1, 'en', 'cor_lut_txttype', '114', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Lateral rotation of femur', 1, 'en', 'cor_lut_txttype', '115', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Reference', 1, 'en', 'cor_lut_txttype', '116', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Group', 1, 'en', 'cor_tbl_module', '12', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Pottery Date Range', 1, 'en', 'cor_lut_spantype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Roman- Glaze', 1, 'en', 'cor_lut_attribute', '161', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'From', 4, 'en', 'cor_lut_spantype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'To', 3, 'en', 'cor_lut_spantype', '6', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Spot-dating Notes', 1, 'en', 'cor_lut_txttype', '122', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Mint', 1, 'en', 'cor_lut_txttype', '123', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Site', 1, 'en', 'cor_tbl_module', '13', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Recorded by', 1, 'en', 'cor_lut_actiontype', '14', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Recorded on', 1, 'en', 'cor_lut_datetype', '9', 1, '2011-07-22 00:00:00');
INSERT INTO `cor_tbl_alias` VALUES(0, 'Images', 1, 'en', 'cor_lut_filetype', '1', 1, '2011-07-22 00:00:00');


-- ----------------------------------------
-- NOW WE WILL ADD THE RELEVANT MARKUP FOR THIS CONFIGURATION
-- -----------------------------------------

--
-- Dumping data for table `cor_tbl_markup`
--

INSERT INTO `cor_tbl_markup` VALUES(0, 'cxtmeta', 'Record Details', 'cxt', 'en', 'A label to express the idea of cxt meta info', 2, '2006-05-15 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'cxts', 'Linked Records', 'cxt', 'en', 'Markup for showing contexts linked to other records in the xmi viewer', 4, '2007-05-17 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'site_photo', 'Site Photo', 'sph', 'en', 'Markup for displaying Site Photo', 4, '2007-05-17 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'interp', 'Interpretation', 'cxt', 'en', 'Markup for labelling the interpretation', 4, '2007-05-17 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'plan', 'Plan', 'pln', 'en', 'Markup for the micro viewer displaying drawn plans', 4, '2007-05-18 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'geophoto', 'Geophoto', 'gph', 'en', 'Markup used when displaying the Geophoto in the micro view', 4, '2007-05-18 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'matrix', 'Stratigraphic Matrix', 'cxt', 'en', 'Markup for the display of the stratigraphic matrix', 4, '2007-06-06 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'othermatrix', 'Other Stratigraphic Relationships', 'cxt', 'en', 'Markup for displaying additional stratigraphic relationships not present in the matrix', 4, '2007-06-06 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'photo', 'Photos', 'sph', 'en', 'For displaying of photos for finds/arch elements, etc (ie anything not site photos or geophotos)', 4, '2007-06-15 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'materi', 'Materials Inventory', 'cxt', 'en', 'The heading of teh Materials Inventory subform', 4, '2008-05-27 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'objects', 'Objects', 'spf', 'en', 'Objects', 4, '2008-05-28 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'elements', 'Architectural Elements', 'ael', 'en', 'Architectural Elements markup for subforms', 4, '2008-05-28 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'coins', 'Coins', 'cns', 'en', 'Coins markup for subforms', 4, '2008-05-28 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'ceramic', 'Ceramic Inventory', 'cxt', 'en', 'The header for the ceramic inventory', 4, '2008-06-03 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'comparanda', 'Comparanda', 'spf', 'en', 'Heading for comparanda of objects', 4, '2008-06-04 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'cond', 'Overall Condition Assessment', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'cons', 'Conservation', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'damage', 'Damage', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'further_work', 'Further Conservation Work Required', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'priority', 'Priority', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'storage', 'Storage', 'spf', 'en', 'Used in spf module', 4, '2008-07-14 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'cxtstrat', 'Stratigraphic Relationships', 'cxt', 'en', '', 4, '0000-00-00 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'basicinfo', 'Basic Information', 'cxt', 'en', '', 4, '0000-00-00 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'position', 'Position', 'cxt', 'en', 'For position frame for HRUs', 4, '0000-00-00 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'decomp', 'Decomposition and Compression', 'cxt', 'en', 'For hru decomp frame', 4, '0000-00-00 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'measure', 'Measures', 'cxt', 'en', 'For measures frame', 4, '0000-00-00 00:00:00');
INSERT INTO `cor_tbl_markup` VALUES(0, 'articulation', 'Articulation', 'cxt', 'en', 'HRU articulation frame', 4, '0000-00-00 00:00:00');
