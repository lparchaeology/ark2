-- MySQL dump 10.13  Distrib 5.5.29, for osx10.6 (i386)
--
-- Host: localhost    Database: arkv1_1
-- ------------------------------------------------------
-- Server version	5.5.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abk_lut_abktype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abk_lut_abktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abktype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abk_lut_abktype`
--

LOCK TABLES `abk_lut_abktype` WRITE;
/*!40000 ALTER TABLE `abk_lut_abktype` DISABLE KEYS */;
INSERT INTO `abk_lut_abktype` VALUES (1,'people',4,'2007-05-15 00:00:00');
/*!40000 ALTER TABLE `abk_lut_abktype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `abk_tbl_abk`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abk_tbl_abk` (
  `abk_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abk_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abktype` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`abk_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abk_tbl_abk`
--

LOCK TABLES `abk_tbl_abk` WRITE;
/*!40000 ALTER TABLE `abk_tbl_abk` DISABLE KEYS */;
INSERT INTO `abk_tbl_abk` VALUES ('ARK_1',1,'ARK',1,1,'2013-11-29 17:40:05');
/*!40000 ALTER TABLE `abk_tbl_abk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_actiontype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_actiontype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actiontype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lookup table supplies types of actions';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_actiontype`
--

LOCK TABLES `cor_lut_actiontype` WRITE;
/*!40000 ALTER TABLE `cor_lut_actiontype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_actiontype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_aliastype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_aliastype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aliastype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_aliastype`
--

LOCK TABLES `cor_lut_aliastype` WRITE;
/*!40000 ALTER TABLE `cor_lut_aliastype` DISABLE KEYS */;
INSERT INTO `cor_lut_aliastype` VALUES (1,'normal',1,'2006-08-31 00:00:00'),(2,'against',1,'2006-08-31 00:00:00'),(3,'boolean_true',2,'2009-11-06 00:00:00'),(4,'boolean_false',2,'2009-11-06 00:00:00');
/*!40000 ALTER TABLE `cor_lut_aliastype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_areatype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_areatype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areatype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_areatype`
--

LOCK TABLES `cor_lut_areatype` WRITE;
/*!40000 ALTER TABLE `cor_lut_areatype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_areatype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_attribute`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attributetype` int(11) NOT NULL DEFAULT '0',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_attribute`
--

LOCK TABLES `cor_lut_attribute` WRITE;
/*!40000 ALTER TABLE `cor_lut_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_attributetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_attributetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_attributetype`
--

LOCK TABLES `cor_lut_attributetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_attributetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_attributetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_booltype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_booltype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booltype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_booltype`
--

LOCK TABLES `cor_lut_booltype` WRITE;
/*!40000 ALTER TABLE `cor_lut_booltype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_booltype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_datetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_datetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_datetype`
--

LOCK TABLES `cor_lut_datetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_datetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_datetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_file`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_file`
--

LOCK TABLES `cor_lut_file` WRITE;
/*!40000 ALTER TABLE `cor_lut_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_filetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_filetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filetype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_filetype`
--

LOCK TABLES `cor_lut_filetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_filetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_filetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_language`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_language`
--

LOCK TABLES `cor_lut_language` WRITE;
/*!40000 ALTER TABLE `cor_lut_language` DISABLE KEYS */;
INSERT INTO `cor_lut_language` VALUES (1,'en',1,'2006-08-31 00:00:00');
/*!40000 ALTER TABLE `cor_lut_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_mapconnectiontype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_mapconnectiontype` (
  `id` int(11) NOT NULL DEFAULT '0',
  `mapconnectiontype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_mapconnectiontype`
--

LOCK TABLES `cor_lut_mapconnectiontype` WRITE;
/*!40000 ALTER TABLE `cor_lut_mapconnectiontype` DISABLE KEYS */;
INSERT INTO `cor_lut_mapconnectiontype` VALUES (4,'MS_OGR',0,'0000-00-00 00:00:00'),(7,'MS_POSTGIS',0,'0000-00-00 00:00:00'),(5,'MS_WMS',0,'0000-00-00 00:00:00'),(0,'MS_INLINE',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cor_lut_mapconnectiontype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_mapgeomtype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_mapgeomtype` (
  `id` int(11) NOT NULL DEFAULT '0',
  `mapgeomtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_mapgeomtype`
--

LOCK TABLES `cor_lut_mapgeomtype` WRITE;
/*!40000 ALTER TABLE `cor_lut_mapgeomtype` DISABLE KEYS */;
INSERT INTO `cor_lut_mapgeomtype` VALUES (1,'Line',0,'0000-00-00 00:00:00'),(2,'Polygon',0,'0000-00-00 00:00:00'),(3,'Circle',0,'0000-00-00 00:00:00'),(4,'Annotation',0,'0000-00-00 00:00:00'),(0,'Point',0,'0000-00-00 00:00:00'),(5,'Raster',0,'0000-00-00 00:00:00'),(6,'Query',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cor_lut_mapgeomtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_numbertype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_numbertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qualifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_numbertype`
--

LOCK TABLES `cor_lut_numbertype` WRITE;
/*!40000 ALTER TABLE `cor_lut_numbertype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_numbertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_place`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_place`
--

LOCK TABLES `cor_lut_place` WRITE;
/*!40000 ALTER TABLE `cor_lut_place` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_placetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_placetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_placetype`
--

LOCK TABLES `cor_lut_placetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_placetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_placetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_spanlabel`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_spanlabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` int(3) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spanlabel` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_spanlabel`
--

LOCK TABLES `cor_lut_spanlabel` WRITE;
/*!40000 ALTER TABLE `cor_lut_spanlabel` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_spanlabel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_spantype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_spantype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `evaluation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_spantype`
--

LOCK TABLES `cor_lut_spantype` WRITE;
/*!40000 ALTER TABLE `cor_lut_spantype` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lut_spantype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_txttype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lut_txttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_txttype`
--

LOCK TABLES `cor_lut_txttype` WRITE;
/*!40000 ALTER TABLE `cor_lut_txttype` DISABLE KEYS */;
INSERT INTO `cor_lut_txttype` VALUES (4,'initials','abk',1,'2007-05-17 00:00:00'),(3,'name','abk',1,'2007-05-15 00:00:00'),(2,'short_desc','cor',1,'2005-11-21 00:00:00'),(1,'interp','cor',1,'2005-11-15 00:00:00');
/*!40000 ALTER TABLE `cor_lut_txttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_applications`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_applications` (
  `application_id` int(11) DEFAULT '0',
  `application_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `application_id_idx` (`application_id`),
  UNIQUE KEY `define_name_i_idx` (`application_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_applications`
--

LOCK TABLES `cor_lvu_applications` WRITE;
/*!40000 ALTER TABLE `cor_lvu_applications` DISABLE KEYS */;
INSERT INTO `cor_lvu_applications` VALUES (1,'ARK');
/*!40000 ALTER TABLE `cor_lvu_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_applications_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_applications_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_applications_seq`
--

LOCK TABLES `cor_lvu_applications_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_applications_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_applications_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_area_admin_areas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_area_admin_areas` (
  `area_id` int(11) DEFAULT '0',
  `perm_user_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`area_id`,`perm_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_area_admin_areas`
--

LOCK TABLES `cor_lvu_area_admin_areas` WRITE;
/*!40000 ALTER TABLE `cor_lvu_area_admin_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_area_admin_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_areas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_areas` (
  `area_id` int(11) DEFAULT '0',
  `application_id` int(11) DEFAULT '0',
  `area_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `area_id_idx` (`area_id`),
  UNIQUE KEY `define_name_i_idx` (`application_id`,`area_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_areas`
--

LOCK TABLES `cor_lvu_areas` WRITE;
/*!40000 ALTER TABLE `cor_lvu_areas` DISABLE KEYS */;
INSERT INTO `cor_lvu_areas` VALUES (1,1,'USER_ADMIN'),(2,1,'DATA_ENTRY'),(3,1,'DATA_VIEW'),(4,1,'MICRO_VIEW'),(5,1,'MAP_VIEW'),(6,1,'IMPORT'),(7,1,'USER_HOME');
/*!40000 ALTER TABLE `cor_lvu_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_areas_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_areas_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_areas_seq`
--

LOCK TABLES `cor_lvu_areas_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_areas_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_areas_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_group_subgroups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_group_subgroups` (
  `group_id` int(11) DEFAULT '0',
  `subgroup_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`subgroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_group_subgroups`
--

LOCK TABLES `cor_lvu_group_subgroups` WRITE;
/*!40000 ALTER TABLE `cor_lvu_group_subgroups` DISABLE KEYS */;
INSERT INTO `cor_lvu_group_subgroups` VALUES (1,3),(2,1);
/*!40000 ALTER TABLE `cor_lvu_group_subgroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_grouprights`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_grouprights` (
  `group_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_grouprights`
--

LOCK TABLES `cor_lvu_grouprights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_grouprights` DISABLE KEYS */;
INSERT INTO `cor_lvu_grouprights` VALUES (1,11,3);
/*!40000 ALTER TABLE `cor_lvu_grouprights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_groups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_groups`
--

LOCK TABLES `cor_lvu_groups` WRITE;
/*!40000 ALTER TABLE `cor_lvu_groups` DISABLE KEYS */;
INSERT INTO `cor_lvu_groups` VALUES (1,1,'USERS',1,1,1),(2,1,'ADMINS',1,1,1),(3,1,'PUBLIC',1,1,1);
/*!40000 ALTER TABLE `cor_lvu_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_groups_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_groups_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_groups_seq`
--

LOCK TABLES `cor_lvu_groups_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_groups_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_groups_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_groupusers`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_groupusers` (
  `perm_user_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_groupusers`
--

LOCK TABLES `cor_lvu_groupusers` WRITE;
/*!40000 ALTER TABLE `cor_lvu_groupusers` DISABLE KEYS */;
INSERT INTO `cor_lvu_groupusers` VALUES (42,2);
/*!40000 ALTER TABLE `cor_lvu_groupusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_perm_users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_perm_users` (
  `perm_user_id` int(11) DEFAULT '0',
  `auth_user_id` varchar(32) DEFAULT NULL,
  `auth_container_name` varchar(32) DEFAULT NULL,
  `perm_type` int(11) DEFAULT '0',
  UNIQUE KEY `perm_user_id_idx` (`perm_user_id`),
  UNIQUE KEY `auth_id_i_idx` (`auth_user_id`,`auth_container_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_perm_users`
--

LOCK TABLES `cor_lvu_perm_users` WRITE;
/*!40000 ALTER TABLE `cor_lvu_perm_users` DISABLE KEYS */;
INSERT INTO `cor_lvu_perm_users` VALUES (42,'1','ARK_USERS',1);
/*!40000 ALTER TABLE `cor_lvu_perm_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_perm_users_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_perm_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_perm_users_seq`
--

LOCK TABLES `cor_lvu_perm_users_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_perm_users_seq` DISABLE KEYS */;
INSERT INTO `cor_lvu_perm_users_seq` VALUES (89);
/*!40000 ALTER TABLE `cor_lvu_perm_users_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_right_implied`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_right_implied` (
  `right_id` int(11) DEFAULT '0',
  `implied_right_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`right_id`,`implied_right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_right_implied`
--

LOCK TABLES `cor_lvu_right_implied` WRITE;
/*!40000 ALTER TABLE `cor_lvu_right_implied` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_right_implied` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_rights`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_rights` (
  `right_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `right_define_name` varchar(32) DEFAULT NULL,
  `has_implied` tinyint(1) DEFAULT '1',
  UNIQUE KEY `right_id_idx` (`right_id`),
  UNIQUE KEY `define_name_i_idx` (`area_id`,`right_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_rights`
--

LOCK TABLES `cor_lvu_rights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_rights` DISABLE KEYS */;
INSERT INTO `cor_lvu_rights` VALUES (1,1,'VIEW',0),(2,1,'EDIT',0),(11,6,'IMPORT_VIEW',0),(12,6,'IMPORT_EDIT',0);
/*!40000 ALTER TABLE `cor_lvu_rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_rights_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_rights_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_rights_seq`
--

LOCK TABLES `cor_lvu_rights_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_rights_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_rights_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_translations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_translations`
--

LOCK TABLES `cor_lvu_translations` WRITE;
/*!40000 ALTER TABLE `cor_lvu_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_translations_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_translations_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_translations_seq`
--

LOCK TABLES `cor_lvu_translations_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_translations_seq` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_translations_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_userrights`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_userrights` (
  `perm_user_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_userrights`
--

LOCK TABLES `cor_lvu_userrights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_userrights` DISABLE KEYS */;
INSERT INTO `cor_lvu_userrights` VALUES (1,1,1),(1,2,1),(2,2,1),(1,11,3);
/*!40000 ALTER TABLE `cor_lvu_userrights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_users`
--

LOCK TABLES `cor_lvu_users` WRITE;
/*!40000 ALTER TABLE `cor_lvu_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_lvu_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lvu_users_seq`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_lvu_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lvu_users_seq`
--

LOCK TABLES `cor_lvu_users_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_users_seq` DISABLE KEYS */;
INSERT INTO `cor_lvu_users_seq` VALUES (42);
/*!40000 ALTER TABLE `cor_lvu_users_seq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_action`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_action`
--

LOCK TABLES `cor_tbl_action` WRITE;
/*!40000 ALTER TABLE `cor_tbl_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_alias`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_alias`
--

LOCK TABLES `cor_tbl_alias` WRITE;
/*!40000 ALTER TABLE `cor_tbl_alias` DISABLE KEYS */;
INSERT INTO `cor_tbl_alias` VALUES (1,'Address Book',1,'en','cor_tbl_module','2',1,'2013-11-28 17:03:27'),(2,'Users',1,'en','cor_tbl_sgrp','1',1,'2013-11-28 17:05:32'),(3,'Admins',1,'en','cor_tbl_sgrp','2',1,'2013-11-28 17:05:32'),(4,'Created By',1,'en','cor_tbl_col','1',1,'2013-11-29 13:36:43'),(5,'Created On',1,'en','cor_tbl_col','2',1,'2013-11-29 13:36:43'),(6,'Type',1,'en','cor_tbl_col','3',1,'2013-11-29 13:36:43'),(7,'Sub Area',1,'en','cor_lut_areatype','2',1,'2006-12-06 11:02:41'),(8,'Grid Square',1,'en','cor_lut_areatype','3',1,'2006-12-06 11:02:41'),(9,'Trench',1,'en','cor_lut_areatype','4',1,'2006-12-06 11:02:41'),(10,'OGR (Shapefiles)',1,'en','cor_lut_mapconnectiontype','4',1,'2006-12-06 11:11:01'),(11,'PostGIS',1,'en','cor_lut_mapconnectiontype','7',1,'2006-12-06 11:11:01'),(12,'WMS',1,'en','cor_lut_mapconnectiontype','5',1,'2006-12-06 11:11:01'),(13,'Raster',1,'en','cor_lut_mapconnectiontype','0',1,'2006-12-06 11:11:01'),(14,'People',1,'en','abk_lut_abktype','1',1,'2014-02-20 12:38:45'),(15,'Name',1,'en','cor_lut_txttype','3',1,'2014-02-20 17:25:25'),(16,'Initials',1,'en','cor_lut_txttype','4',1,'2014-02-20 17:23:11');
/*!40000 ALTER TABLE `cor_tbl_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_attribute`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `boolean` tinyint(4) NOT NULL DEFAULT '1',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_attribute`
--

LOCK TABLES `cor_tbl_attribute` WRITE;
/*!40000 ALTER TABLE `cor_tbl_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_bool`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_bool`
--

LOCK TABLES `cor_tbl_bool` WRITE;
/*!40000 ALTER TABLE `cor_tbl_bool` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_bool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_cmap`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_cmap`
--

LOCK TABLES `cor_tbl_cmap` WRITE;
/*!40000 ALTER TABLE `cor_tbl_cmap` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_cmap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_cmap_data`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_cmap_data`
--

LOCK TABLES `cor_tbl_cmap_data` WRITE;
/*!40000 ALTER TABLE `cor_tbl_cmap_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_cmap_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_cmap_structure`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_cmap_structure`
--

LOCK TABLES `cor_tbl_cmap_structure` WRITE;
/*!40000 ALTER TABLE `cor_tbl_cmap_structure` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_cmap_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_col`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_col` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_col`
--

LOCK TABLES `cor_tbl_col` WRITE;
/*!40000 ALTER TABLE `cor_tbl_col` DISABLE KEYS */;
INSERT INTO `cor_tbl_col` VALUES (1,'created_by','This holds the user id of the person who created this record',1,'0000-00-00 00:00:00'),(2,'created_on','This column holds the date that the record was created',1,'0000-00-00 00:00:00'),(3,'abktype','The column holding the addressbook type',1,'2007-01-15 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_col` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_date`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` int(11) NOT NULL DEFAULT '0',
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_date`
--

LOCK TABLES `cor_tbl_date` WRITE;
/*!40000 ALTER TABLE `cor_tbl_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_file`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `txt` (`file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows fragments of dataclass file to be linked t';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_file`
--

LOCK TABLES `cor_tbl_file` WRITE;
/*!40000 ALTER TABLE `cor_tbl_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_filter`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_filter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filter` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(6) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nname` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sgrp` int(3) NOT NULL DEFAULT '0',
  `cre_by` char(3) NOT NULL DEFAULT '',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_filter`
--

LOCK TABLES `cor_tbl_filter` WRITE;
/*!40000 ALTER TABLE `cor_tbl_filter` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `refid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vars` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A table to log different types of event';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_log`
--

LOCK TABLES `cor_tbl_log` WRITE;
/*!40000 ALTER TABLE `cor_tbl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_markup`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=650 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_markup`
--

LOCK TABLES `cor_tbl_markup` WRITE;
/*!40000 ALTER TABLE `cor_tbl_markup` DISABLE KEYS */;
INSERT INTO `cor_tbl_markup` VALUES (1,'ark','ARK', 'cor', 'en','name of ARK if it is not set',1,'0000-00-00 00:00:00'),(2,'andyet','An unexplained error has occured', 'cor', 'en','andyet, worst of all errors',1,'0000-00-00 00:00:00'),(3,'mediauploader','Media Uploader', 'cor', 'en','Title for mediauploder overlay',1,'0000-00-00 00:00:00'),(4,'from_comp','Local Files', 'cor', 'en','tab title for local uploads',1,'0000-00-00 00:00:00'),(5,'from_url','Remote URL', 'cor', 'en','tab title for remote file uploads',1,'0000-00-00 00:00:00'),(6,'from_ml','Media Library', 'cor', 'en','tab title for media library uploads',1,'0000-00-00 00:00:00'),(7,'draghere','Drag files here to Upload', 'cor', 'en','Text for draggable file window',1,'0000-00-00 00:00:00'),(8,'urllabel','URL:', 'cor', 'en','label for url text box',1,'0000-00-00 00:00:00'),(9,'linkfiles','Link Files', 'cor', 'en','button text for linking files',1,'0000-00-00 00:00:00'),(10,'tgtmodtype','Target Modtype', 'cor', 'en','label for target modtype in change modtype sf',1,'0000-00-00 00:00:00'),(11,'change','Change', 'cor', 'en','Button text for changing mod type',1,'0000-00-00 00:00:00'),(12,'modtypechanged','Module type successfully changed', 'cor', 'en','message on successful change of modtype',1,'0000-00-00 00:00:00'),(507,'extent_err','Your extents are not valid. Either you have not entered them correctly using commas (minx,miny,maxx,maxy e.g. -130, 14, -60, 55) or your extents are in the wrong order (e.g. your minx is greater than your miny)','cor','en','error label',1,'2009-11-09 17:39:21'),(506,'scales_instr','enter in the format: 100000,50000,25000,10000','cor','en','label',1,'2009-11-09 18:56:05'),(505,'scales_label','Scales','cor','en','label',1,'2009-11-09 16:36:44'),(503,'extent_label','Extents','cor','en','label',1,'2009-11-09 16:29:35'),(504,'extent_instr','enter in the format: minx,miny,maxx,maxy','cor','en','label',1,'2009-11-09 18:56:25'),(501,'mapadmin','Mapping Administration','cor','en','label',1,'2009-11-05 14:18:01'),(502,'map_admin_instructions','This page is used to configure the mapping within ARK. Here you can setup the mapping to take any number of layers from different sources and choose the order and colour of them. You can then save the configuration for use by your users.','cor','en','lbel',1,'2009-11-05 14:30:16'),(494,'sf_number_incompl','No number data has been added','cor','en','',4,'0000-00-00 00:00:00'),(495,'noattr','No attribute data has been added','cor','en','',4,'0000-00-00 00:00:00'),(496,'filterspan','Search by Date Range','cor','en','',4,'0000-00-00 00:00:00'),(497,'filterpanel','Search Tools','cor','en','',4,'0000-00-00 00:00:00'),(498,'search_for','Search for a','cor','en','For data entry pages',1,'0000-00-00 00:00:00'),(499,'item','item','cor','en','For data entry pages',1,'0000-00-00 00:00:00'),(500,'notset','Not set','cor','en','For unset sf_attr_boolean',1,'0000-00-00 00:00:00'),(491,'alifail','Alias was not added.','cor','en','',4,'0000-00-00 00:00:00'),(492,'success','The new item was added to the control list.  Please reset the form to add additional items.','cor','en','',4,'0000-00-00 00:00:00'),(493,'sf_txt_incompl','No text data has been added','cor','en','',4,'0000-00-00 00:00:00'),(488,'attrscss','Attribute was added succesfully','cor','en','',4,'0000-00-00 00:00:00'),(489,'attrfail','Attribute was not added to control list.','cor','en','',4,'0000-00-00 00:00:00'),(490,'aliscss','Alias was added sucessfully!','cor','en','',4,'0000-00-00 00:00:00'),(485,'ifsure','If you are certain this is not a duplicate, add the term.','cor','en','for adding to control lists',4,'0000-00-00 00:00:00'),(486,'err_attrtypedontexist','This attribute type doesn\'t exist.  Please try again.','cor','en','For adding to control lists',4,'0000-00-00 00:00:00'),(487,'failure','Your attempt was not successful, please try again.','cor','en','for adding to control lists',4,'0000-00-00 00:00:00'),(482,'similar','A similar term already exists in this list','cor','en','for adding to control lists',4,'0000-00-00 00:00:00'),(483,'language','language','cor','en','',1,'0000-00-00 00:00:00'),(484,'tryotherterm','Or try another new term','cor','en','for adding to control lists',4,'0000-00-00 00:00:00'),(480,'resetform','Reset Form','cor','en','to reset sf_attr_bytype',4,'0000-00-00 00:00:00'),(481,'newtermlab','New term label','cor','en','sf_attr_bytype',4,'0000-00-00 00:00:00'),(475,'ctrllsttitle','Add to Control Lists','cor','en','For sf_attr_bytype',4,'0000-00-00 00:00:00'),(476,'choosectrllst','Choose a control list:','cor','en','for sf_attr_bytype',4,'0000-00-00 00:00:00'),(477,'ctrllst','Control List','cor','en','for sf_attr_bytype',1,'0000-00-00 00:00:00'),(478,'newterm','Suggest a new term:','cor','en','for sf_attr_bytype',1,'0000-00-00 00:00:00'),(479,'addterm','Add Term','cor','en','for sf_attr_bytype',4,'0000-00-00 00:00:00'),(471,'ste_cd','Site code','cor','en','A label for site codes',1,'0000-00-00 00:00:00'),(472,'download','Download','cor','en','For downloading photos',4,'0000-00-00 00:00:00'),(473,'file_nav','Select a batch or module:','cor','en','For file nav (register)',4,'0000-00-00 00:00:00'),(474,'no_reg_files','No files selected!','cor','en','For register',4,'0000-00-00 00:00:00'),(469,'stat_flags','Record Status','cor','en','Record status flag label',1,'0000-00-00 00:00:00'),(470,'navigation','Go to','cor','en','Label for navigation to a record or other',1,'0000-00-00 00:00:00'),(468,'your','Your','cor','en','For the yoursavedstuff subform.',4,'2011-06-09 15:36:35'),(467,'edit','edit','cor','en','',4,'0000-00-00 00:00:00'),(464,'batchname','Batch Name: ','cor','en','For file upload',4,'0000-00-00 00:00:00'),(465,'module','Module','cor','en','For file upload',4,'0000-00-00 00:00:00'),(466,'curuploaddir','Current Upload Directory: ','cor','en','For file upload',4,'0000-00-00 00:00:00'),(463,'formupload_instructions','To upload files, enter a batch name or module and browse to the upload directory below (/www/htdocs/ark/data/upload).','cor','en','For file upload',4,'0000-00-00 00:00:00'),(462,'totalres','Total Results:','cor','en','Markup display the total number of search results',4,'2011-06-09 15:41:50'),(460,'filteractor','Search by Actor','cor','en','',4,'0000-00-00 00:00:00'),(461,'num_pages','Number of results per page:','cor','en','',4,'0000-00-00 00:00:00'),(459,'filteratt','Search by Attribute','cor','en','',4,'0000-00-00 00:00:00'),(458,'filteritem','Record Type','cor','en','Label for the filter builder when searching by key',4,'2011-06-10 17:36:50'),(455,'make_filter','New Search','cor','en','',4,'0000-00-00 00:00:00'),(456,'publicfilters','Common Searches','cor','en','',4,'0000-00-00 00:00:00'),(457,'ftx','Free Text Search','cor','en','',4,'0000-00-00 00:00:00'),(454,'clearfilter','Clear Search','cor','en','',4,'0000-00-00 00:00:00'),(452,'rerunall','Rerun All','cor','en','',4,'0000-00-00 00:00:00'),(453,'filtertype','Search Type','cor','en','',4,'0000-00-00 00:00:00'),(450,'filters','Search','cor','en','',4,'0000-00-00 00:00:00'),(451,'clearall','Clear All','cor','en','',4,'0000-00-00 00:00:00'),(448,'welcome','Welcome to ARK, ','cor','en','',4,'0000-00-00 00:00:00'),(449,'user_home','User Home','cor','en','',4,'0000-00-00 00:00:00'),(442,'user_admin','User Administration Home','cor','en','',4,'0000-00-00 00:00:00'),(443,'adduser','Add a User','cor','en','',4,'0000-00-00 00:00:00'),(444,'edituser','Edit a User','cor','en','',4,'0000-00-00 00:00:00'),(445,'view','view','cor','en','',4,'0000-00-00 00:00:00'),(446,'qed','edit','cor','en','',4,'0000-00-00 00:00:00'),(447,'choose_lang','Choose a language','cor','en','',4,'0000-00-00 00:00:00'),(438,'regabk','Address Book','cor','en','',4,'0000-00-00 00:00:00'),(439,'uplfile','Upload File','cor','en','',4,'0000-00-00 00:00:00'),(440,'frm_select','Please select an option from the left.','cor','en','',4,'0000-00-00 00:00:00'),(441,'data_entry','Data Entry Home','cor','en','',4,'0000-00-00 00:00:00'),(437,'savedfilters','Saved Searches','cor','en','For the mysavedstuff subform in search and user home pages.',4,'2011-06-09 15:36:21'),(436,'files','Files','cor','en','It\'s some markup for files.',4,'2008-07-16 00:00:00'),(435,'dvlp_filters','Make a New Search','cor','en','For the filter building subform.',4,'2011-06-09 15:37:16'),(434,'edtalias','Edit Alias','cor','en','For the alias admin options',4,'2011-06-09 15:31:59'),(432,'noxmi','No Linked Records','cor','en','Markup for items missing an xmi link',4,'2008-05-27 00:00:00'),(433,'micro_view_forms','Record View','cor','en','Heading of micro viewing forms',4,'2008-06-03 00:00:00'),(431,'note','Notes','cor','en','Notes for objects and architectural elements',4,'2007-06-15 00:00:00'),(430,'no_interps','No Interpretations','cor','en','Markup for indicating there are no interpretations available',4,'2007-06-06 00:00:00'),(428,'home','Home','cor','en','Markup for the home page of various sections',4,'2007-05-17 00:00:00'),(429,'spat_data','Spatial Data','cor','en','Markup identifying the spatial data panel in the micro view',4,'2007-05-21 00:00:00'),(427,'space','&nbsp;','cor','en','A non-breaking space when no markup is required',4,'2007-05-17 00:00:00'),(426,'notinauthitems','Not in Auth Items','cor','en','Displayed when field is not in auth items.',4,'2007-05-17 00:00:00'),(425,'nofilters','No search filters are set, please add a new search filter','cor','en','A message to say that no filters are set',2,'2006-12-08 00:00:00'),(421,'options','Options','cor','en','Label for the options column of a table',1,'0000-00-00 00:00:00'),(422,'viewmsg','View Record','cor','en','Message for linking out to the record view option',2,'2006-12-08 00:00:00'),(423,'score','Relevancy score','cor','en','MArkup for hte relevancy score',2,'2006-12-08 00:00:00'),(424,'norec','Your search did not return any results','cor','en','A message to display when the result set is empty',2,'2006-12-08 00:00:00'),(420,'vwmap','View as Map','cor','en','Used to give options for results view',4,'2007-01-15 00:00:00'),(418,'vwtbl','View as Table','cor','en','To view results as a table',4,'2007-01-15 00:00:00'),(419,'vwcht','View as Chat','cor','en','Used to give options for results view',4,'2007-01-15 00:00:00'),(417,'expxml','Export as XML','cor','en','To export data as XML',4,'2007-01-15 00:00:00'),(415,'search','Search','cor','en','Search',4,'2007-01-15 00:00:00'),(416,'expcsv','Export as CSV','cor','en','Exports the results as comma separated values',4,'2007-01-15 00:00:00'),(413,'view_regist','Register Viewer','cor','en','Alias of the register viewer',2,'2006-06-03 00:00:00'),(414,'nextrec','Next Record','cor','en','A lable for the next record',2,'2006-06-03 00:00:00'),(412,'regist','Register','cor','en','Alias of the register entry from',2,'2006-06-03 00:00:00'),(409,'accena','Account enabled','cor','en','A message for handling User Admin',2,'2006-06-01 00:00:00'),(410,'accdis','Account disabled','cor','en','A message for handling User Admin',2,'2006-06-01 00:00:00'),(411,'detfrm','Form','cor','en','Alias of the detailed data entry form',2,'2006-06-03 00:00:00'),(408,'enable','Enable / Disable user account','cor','en','A message for handling User Admin',2,'2006-06-01 00:00:00'),(406,'err_nouid','No user id has been set.','cor','en','A message for handling User Admin',2,'2006-06-01 00:00:00'),(407,'err_duprel','That is a duplicate relationship, it can\'t be added.','cor','en','A generic error message',2,'2006-06-01 00:00:00'),(404,'cpw','Confirm password','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(405,'err_nosgrp','No security group has been set.','cor','en','A message for handling User Admin',2,'2006-06-01 00:00:00'),(403,'pw','Password','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(402,'email','eMail','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(400,'lname','Last name','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(401,'init','Initials','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(399,'fname','First name','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(398,'uname','Username','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(395,'change_pw','Change Password','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(396,'edt_sgrps','Edit \'S-Groups\'','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(397,'edt_user','Edit User','cor','en','A message for handling User Admin',2,'2006-05-30 00:00:00'),(391,'addusr_newid','The new user account has been successfuly created. Make a note of the new username. The new username is:','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(392,'err_nopw','No password was set.','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(393,'err_nocpw','No confirmation password was set','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(394,'err_pwmatch','The password and confirmation password do NOT match.','cor','en','A message for handling User Admin',2,'2006-05-31 00:00:00'),(390,'data_view_forms','Search','cor','en','Data viewing forms',1,'2006-05-31 00:00:00'),(389,'addusr_sucs','The new user was successfuly created. To activate the account please contact a system administrator.','cor','en','A message for handling User Admin',1,'0000-00-00 00:00:00'),(388,'adusrl_instructions','All fields must be filled in.\r\n\r\n\r\nThe new user account will be created enabled.','cor','en','A message for handling User Admin',2,'2006-05-30 00:00:00'),(387,'addusr_instructions','All fields must be filled in. Please check to make sure that you are not accidentally creating a duplicate user.\r\n\r\n\r\nThe new user account will be created disabled. In order to activate the account, the account must be edited by a system administrator.','cor','en','A message for handling User Admin',2,'2006-05-30 00:00:00'),(385,'err_noemail','No email was set.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(386,'create_user','Create User','cor','en','A message for handling User Admin',2,'2006-05-30 00:00:00'),(383,'err_noinit','No \'intials\' were set.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(384,'err_dupinit','Those initials already exist','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(380,'err_dupuname','That username already exists.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(381,'err_nofname','No first name was set.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(382,'err_nolname','No last name was set.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(377,'err_noflagid','No status flag id is set','cor','en','Error for handling record status flags',2,'2006-05-23 00:00:00'),(378,'help','Help','cor','en','For the help navigation.',4,'2011-06-09 15:30:52'),(379,'err_nouname','No username was set.','cor','en','An error for handling User Admin errors',2,'2006-05-30 00:00:00'),(375,'notdigitised','This item has no spatial data attached at the moment ','cor','en','A message to show if theres is no spatial data',1,'2006-05-23 14:25:00'),(376,'datatoolbox','Data Toolbox','cor','en','A header for the data toolbox area',2,'2006-05-23 00:00:00'),(373,'err_nodateid','No specific date type has been specified.','cor','en','An error message for date types',2,'2006-05-15 00:00:00'),(374,'forms','Data Entry','cor','en','A label for a list of forms',2,'0000-00-00 00:00:00'),(372,'err_noactionid','No specific action id has been specified.','cor','en','An error message for actions',2,'2006-05-15 00:00:00'),(371,'err_noactiontypeid','No action has been specified.','cor','en','An error message for actions',2,'2006-05-15 00:00:00'),(370,'err_noactorid','No actor (team member) id has been specified.','cor','en','An error message for handling actors',2,'2006-05-15 00:00:00'),(368,'go','go','cor','en','The word go which may be used for buttons',2,'2006-05-08 17:30:12'),(369,'desc','Description','cor','en','A label to express the idea of text based description',2,'2006-05-15 00:00:00'),(367,'reset','reset','cor','en','The word reset which may be used for buttons',2,'2006-05-08 17:30:12'),(366,'lut_duplicate','The following list of possible duplicate entries exist in this lookup table. Please be careful not to add duplicate entries.\r\n\r\n$mkv_dup_str\r\n\r\n','cor','en','Warning message about duplicates with a list of possible duplicates',2,'2006-05-16 00:00:00'),(365,'frm_confirm_lutadd','To confirm the addition of \'$mkv_item\' to the lookup table click \"$mkv_submit_label\" or to use an existing value click \"$mkv_reset\".<br />\r\n<form action=\"$mkv_action\">\r\n$mkv_hidden\r\n<input type=\"submit\" value=\"$mkv_submit_label\" class=\"clean_but\" />\r\n</form>\r\n<form action=\"$mkv_action\">\r\n$mkv_reset_hidden\r\n<input type=\"submit\" value=\"$mkv_reset\" class=\"clean_but\" />\r\n</form>','cor','en','A confirmation form for adding to luts',2,'2006-05-15 00:00:00'),(364,'err_nospanid','No span id number has been specified.','cor','en','An error message for handling tvectors',2,'2006-05-15 00:00:00'),(363,'totalpages','Total Pages: ','cor','en','For the total number of results pages',4,'2011-06-09 15:41:58'),(362,'err_nofindtype','Either no find type was selected or the findtype selected is not valid.','cor','en','An error message for handling finds',2,'2006-05-15 00:00:00'),(361,'finds','Finds','cor','en','A label to display in forms for finds',2,'2006-05-15 00:00:00'),(360,'err_spnlablinvalid','The relationship type you selected is not possible to the contexts you selected.','cor','en','Testing',2,'2006-05-12 00:00:00'),(359,'err_tvectlab','There is an error with the label you are trying to add to this matrix relationship. This must be a number and it must be entered in the label list.','cor','en','Error message for tvector beginning',2,'2006-05-11 00:00:00'),(358,'err_tvectendinvalid','There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be a valid context number in this site code. Check that context has been issued.','cor','en','Error message for tvector beginning',2,'2006-05-11 00:00:00'),(357,'err_tvectbeginvalid','There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be a valid context number in this site code. Check that context has been issued.','cor','en','Error message for tvector beginning',2,'2006-05-11 00:00:00'),(356,'err_tvectend','There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be set, it may only be numbers and it must be a valid context in this site code.','cor','en','Error message for tvector beginning',2,'2006-05-11 00:00:00'),(355,'err_tvectbeg','There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be set, it may only be numbers and it must be a valid context in this site code.','cor','en','Error message for tvector beginning',2,'2006-05-11 00:00:00'),(354,'err_notxtid','The text id was not set','cor','en','Error message useful when handling attributes of a text',2,'2006-05-08 05:30:12'),(353,'err_dategen','There was an error getting the date','cor','en','Error message to use with dates',2,'2006-05-08 05:30:12'),(352,'err_noorigby','The value \"record author\" was not set','cor','en','Error message to use when no author has been set',2,'2006-05-08 17:30:12'),(351,'err_nocxttype','The value \"context type\" was not set','cor','en','Error message to use when no context type value was set',2,'2006-05-08 17:30:12'),(350,'err_notxt','The value \"txt\" was not set','cor','en','Error message to use when no txt value was set',2,'2006-05-08 17:30:12'),(349,'err_nocxtno','The value \"context number\" was not set','cor','en','Error message to use when no cxt_no value was set',2,'2006-05-08 17:30:12'),(348,'add','add','cor','en','The word add which may be used for buttons',2,'2006-05-08 17:30:12'),(347,'savedesc','Save description','cor','en','A lable for description forms',2,'2006-05-08 17:32:12'),(346,'save','save','cor','en','The word save which may be used for buttons',2,'2006-05-08 17:30:12'),(345,'aliasadminoptions','Alias Administration','cor','en','For the left panel header of the alias admin home.',4,'2011-06-09 15:32:17'),(508,'scales_err','You have a problem with your scales. Please fill them in using commas (e.g. 25000,10000,5000,1000)','cor','en','scales err',1,'2009-11-09 18:52:46'),(509,'progress_step','Step: ','cor','en','label',1,'2009-11-12 15:40:48'),(510,'progress_finish','Finished','cor','en','label',1,'2009-11-12 16:47:37'),(511,'mapsave_instr','Please enter the following details to save your map','cor','en','label',1,'2009-11-23 17:50:10'),(512,'map_name','Name of Map:','cor','en','label',1,'2009-11-23 17:50:36'),(513,'map_comments','Comments:','cor','en','label',1,'2009-11-23 17:51:00'),(514,'map_tools','Tools','cor','en','label',1,'2009-11-25 14:36:15'),(515,'map_restart','Restart','cor','en','label',1,'2009-11-25 14:36:36'),(516,'map_mapsize','Map Size','cor','en','size label',1,'2009-11-25 14:53:01'),(517,'map_small','small','cor','en','label',1,'2009-11-25 14:37:27'),(518,'map_medium','medium','cor','en','label',1,'2009-11-25 14:37:43'),(519,'map_large','large','cor','en','label',1,'2009-11-25 14:37:57'),(520,'map_export','Export Tools','cor','en','label',1,'2009-11-25 15:03:16'),(521,'map_exportpdf','Export to PDF','cor','en','label',1,'2009-11-25 15:03:33'),(522,'map_savemap','Save Map','cor','en','label',1,'2009-11-25 15:03:51'),(523,'savesuccessful','Save Successful','cor','en','label',1,'2009-11-25 16:12:18'),(524,'saveproblem','There was a problem saving: ','cor','en','label',1,'2009-11-25 16:12:45'),(525,'map_public','Allow all users to load the map?','cor','en','label',1,'2009-11-25 17:01:03'),(526,'map_choose','Load New Map','cor','en','label',1,'2009-11-25 17:12:50'),(527,'map_preconf','Public Maps','cor','en','label',1,'2009-11-25 17:15:52'),(528,'map_savedmaps','Your Saved Maps','cor','en','label',1,'2009-11-25 17:16:36'),(529,'map_creby','Created By','cor','en','label',1,'2009-11-25 17:16:56'),(530,'delete','DELETE','cor','en','labels',4,'2011-06-09 16:17:10'),(531,'delete_successful','Delete Successful','cor','en','label',1,'2009-11-25 18:19:27'),(532,'map_choose_title','Please choose a map below','cor','en','header',4,'2011-06-10 16:53:41'),(533,'build_map','Configure a Map','cor','en','label',1,'2009-11-26 10:31:05'),(534,'files_uploaded','files uploaded successfully!','cor','en','for file uploads',4,'0000-00-00 00:00:00'),(535,'importoptions','Import','cor','en','For the home of the import options.',4,'2011-06-09 15:32:37'),(536,'logout','Logout','cor','en','For logout navigation in top right.',4,'2011-06-09 15:31:20'),(537,'infinity','view all','cor','en','For viewing all search results',4,'2011-06-09 15:40:03'),(538,'markupadminoptions','Markup Administration','cor','en','For the left panel of the markup admin pages.',4,'2011-06-09 15:31:35'),(539,'user','User','cor','en','For the left panel labels in the user admin pages.',4,'2011-06-09 15:44:51'),(540,'chgtype','type','cor','en','For changing the modtype',4,'2011-06-09 16:14:34'),(541,'chgkey','number','cor','en','For changing the item value',4,'2011-06-09 16:18:53'),(542,'changemod','Change the Item Type','cor','en','For title of change modtype button',4,'2011-06-09 16:17:45'),(543,'changeval','Change the Record Number','cor','en','For changing the itemkey',4,'2011-06-09 16:18:06'),(544,'addctrllst','Admin Tools- Add to control lists','cor','en','For a button to add to control lists in data entry, micro view',4,'2011-06-09 16:19:23'),(545,'arkname','ARK','cor','en','Markup for the index page of this instance of ark',4,'2011-06-24 11:15:52'),(546,'csv','CSV','cor','en','Label for downloading a CSV of search results.',4,'2011-06-10 12:46:36'),(547,'curmodtype','Current Type: ','cor','en','For changing modtypes subform',4,'2011-06-10 16:08:27'),(548,'reclabel','Record','cor','en','For changing modtypes subform',4,'2011-06-10 16:09:35'),(549,'novalue','No records attached.','cor','en','For an xmi subform with no records attached.',4,'2011-06-10 16:16:59'),(550,'mapview','Map View','cor','en','For the left panel of the map view',4,'2011-06-10 16:47:48'),(551,'map','Map','cor','en','For the left panel options in the map view',4,'2011-06-10 16:48:04'),(552,'map_configure','Please configure a map below','cor','en','A message for the map admin tools',4,'2011-06-10 16:53:09'),(553,'vwtext','View as Text','cor','en','Hover text for text display of search results',4,'2011-06-10 16:55:48'),(554,'vwthumb','View as Thumbnails','cor','en','Hover text for thumbs display of search results',4,'2011-06-10 16:55:54'),(555,'configfields','Configure visible fields','cor','en','Hover text for tools to configure fields in search results',4,'2011-06-10 17:08:00'),(556,'vwall','View Full Records (Print View)','cor','en','Hover text for displaying all full records for printing',4,'2011-06-10 17:08:49'),(557,'table','table','cor','en','Header of table view of search results',4,'2011-06-10 17:09:28'),(558,'text','text','cor','en','Header of text view of search results',4,'2011-06-10 17:10:09'),(559,'thumb','thumbs','cor','en','header for thumbs view of search results',4,'2011-06-10 17:10:56'),(560,'nofile','No files attached to this record','cor','en','Message when no files present in a sf_file',4,'2011-06-10 17:13:31'),(561,'filterkey','Search by Record Type','cor','en','Search label for key type filter',4,'2011-06-10 17:35:51'),(562,'projection_label','Projection','cor','en','A label for projection in the map admin pages',4,'2011-06-15 13:19:29'),(563,'projection_instr','The variables for the projection dropdown are set in the sf_conf','cor','en','Instructions for projections in map admin',4,'2011-06-15 13:20:32'),(564,'OSM_label','Use OpenStreetMap as a background?','cor','en','Label for map admin of open streemap',4,'2011-06-15 13:21:12'),(565,'osm_instr','Click this if you want an openstreetmap backdrop. <i>NOTE: your other WMS server will need to support the EPSG:900913 projection.</i>','cor','en','Instructions regarding open streetmap',4,'2011-06-15 13:21:51'),(566,'gmap_api_key_label','Google Maps API key (if available)','cor','en','Label for the API for google maps',4,'2011-06-15 13:22:59'),(567,'gmap_api_key_instr','Please supply your GMap Api Key if you want a Google Maps backdrop. <i>NOTE: your other WMS server will need to support the EPSG:900913 projection.</i>','cor','en','Instructions for insertion of gmap API key',4,'2011-06-15 13:25:18'),(568,'url_label','WMS URL','cor','en','For the map admin pages',4,'2011-06-15 14:03:00'),(569,'url_instr','URL for the WMS server. <i>NOTE: the url options are set in the sf_conf</i>','cor','en','For mapping admin',4,'2011-06-15 14:03:53'),(570,'getcap_err','There appears to be an error with the WMS server you are attempting to access - please check the URL you have set in the sf_conf_baselayer. If it is still not working the server maybe currently offline.','cor','en','An error message for failed map admin setup.',4,'2011-06-15 14:09:52'),(571,'legend_admin_instr','Choose which layers you want in your map','cor','en','For map admin pages',4,'2011-06-15 14:14:47'),(572,'nosuggestions','No Suggestions','cor','en','Used in the livesearch suggestion script',4,'2011-06-15 16:11:04'),(573,'no_spat_results','No spatial results for this search.','cor','en','A message for a spatial search result with no spatial data.',4,'2011-06-15 17:59:30'),(574,'papersize','Paper Size','cor','en','Selector for paper size of map download',4,'2011-06-16 10:54:20'),(575,'dl','Download','cor','en','A download link for overlays',4,'2011-06-16 10:54:33'),(576,'dlsucs','Download Success!','cor','en','Successful generation of a map for download',4,'2011-06-16 10:54:58'),(577,'useradminoptions','User Administration','cor','en','A header for the left panel of user admin',4,'2011-06-23 15:50:06'),(578,'userconfigfields','Configure Fields','cor','en','A label for sf_userconfigfields',1,'2011-01-18 18:06:31'),(579,'addfield','Select a new field to add to the view.','cor','en','Label for sf_userconfigfields',1,'2011-01-19 12:43:28'),(580,'fieldconfiginfo','This form allows you to add and remove fields from the current view. In order to remove a field, click the minus sign at the left hand side of the table below. In order to add fields, use the form provided below the table.','cor','en','Label foe sf_userconfigfields',1,'2011-01-19 12:46:23'),(581,'resetresultsinfo','In order to reset this view to the standard configuration, please use the reset button.','cor','en','Label for the sf_userconfigfields',1,'2011-01-19 16:44:19'),(584,'rss','RSS','cor','en','Label for RSS export from search results',4,'2011-06-28 17:15:47'),(585,'rssexport','Export RSS feed of results','cor','en','Hover text for RSS export button',4,'2011-06-28 17:17:04'),(587,'filterattridx','Filter by attribute','cor','en','Label for filters',2,'2011-08-25 23:17:16'),(588,'atr','Attribute','cor','en','Label for filters',2,'2011-08-25 23:18:08'),(589,'err_notauthforedit','You are not authorised to edit the database.','cor','en','A generic cor label',2,'2011-08-30 14:28:58'),(590,'all','All','cor','en','A label used by the fauxdex attribute search',2,'2011-08-30 16:52:23'),(598,'waitmsg','Please wait, the export may take a few minutes','cor','en','label for export form',78,'2013-07-05 11:56:30'),(298,'navigation','Go to','cor','en','Label for navigation to a record or other',1,'0000-00-00 00:00:00'),(302,'file_nav','Select a batch or module:','cor','en','For file nav (register)',4,'0000-00-00 00:00:00'),(599,'navigation','Go to','cor','en','Label for navigation to a record or other',1,'0000-00-00 00:00:00'),(600,'file_nav','Select a batch or module:','cor','en','For file nav (register)',4,'0000-00-00 00:00:00'),(601,'userhomenav','home','cor','en','Markup for user home navigation',1,'2012-03-19 14:55:53'),(602,'usersnav','user admin','cor','en','Markup for user admin navigation',1,'2012-03-19 14:56:38'),(603,'dataentrynav','data entry','cor','en','Markup for data entry navigation',1,'2012-03-19 14:56:55'),(604,'searchnav','search','cor','en','Markup for search navigation',1,'2012-03-19 14:57:11'),(605,'recordviewnav','record view','cor','en','Markup for micro view navigation',1,'2012-03-19 14:57:33'),(606,'aliasnav','alias','cor','en','Markup for alias admin navigation',91,'2014-02-06 18:34:12'),(607,'markupnav','markup','cor','en','Markup for markup admin navigation',91,'2014-02-06 18:34:34'),(608,'importnav','import','cor','en','Markup for import page navigation',1,'2012-03-19 14:58:47'),(609,'register','register','cor','en','register for data entry pages',91,'2013-11-28 17:23:14'),(610,'noregisterdatayet','No records entered','cor','en','markup for empty register',91,'2013-11-29 19:17:21'),(612,'splash','Welcome to ARK! The default user is \'doe_jd\' with password \'janedoe\' ','cor','en','splash for front',91,'2013-12-18 21:12:44'),(613,'updatesucc','Update Successful!','cor','en','successful update message',91,'2013-12-18 21:44:24'),(615,'filtersit','Site','cor','en','site filter',91,'2013-12-18 22:16:18'),(617,'dvlp_searchitems','Search','cor','en','title for item searches',91,'2013-12-18 22:22:18'),(618,'dvlp_searchcriteria','Criteria','cor','en','title for search criteria',91,'2013-12-18 22:22:47'),(619,'nofiles','No Files Attached','cor','en','text for file subform when no files attached',91,'2013-12-20 11:33:54'),(620,'batch_instructions_pt1','This will guide you through uploading a batch of files to the ARK','cor','en','text for file uploader',91,'2013-12-20 11:57:31'),(621,'batch_uploadbyurl','Upload Batch by URL','cor','en','batch upload button text',91,'2013-12-20 11:58:10'),(622,'batchurl','Batch URL:','cor','en','explanatory notes for url box',91,'2013-12-20 11:59:13'),(623,'fu_autoreg','Auto-register','cor','en','text for auto-register button for files',91,'2013-12-20 12:01:04'),(624,'beingthumbed','Creating Thumbnail','cor','en','text for overlay processing',91,'2013-12-20 12:06:57'),(626,'pattern','Pattern','cor','en','notes for pattern field',91,'2013-12-20 12:13:51'),(627,'nopattern','No Pattern Selected','cor','en','message when pattern is not set',91,'2013-12-20 12:14:25'),(628,'batch_uploadfromfolder','Upload From Folder','cor','en','Text for folder batch upload button',91,'2013-12-20 12:32:35'),(629,'uploadthisdir','Use this Directory','cor','en','text for upload choose folder button',91,'2013-12-20 12:33:24'),(630,'back','Back','cor','en','text for back button',91,'2013-12-20 12:34:12'),(631,'runliveadd','ADD','cor','en','text for run live upload button',91,'2013-12-20 12:34:53'),(632,'liveaddresults','Live Add Results','cor','en','title text for live upload results',91,'2013-12-20 12:35:38'),(633,'modtype','Type','cor','en','Type of module prompt',91,'2013-12-20 13:27:19'),(634,'err_recwasdel','Record Deleted!','cor','en','message on successful deletion of record',91,'2013-12-20 14:41:05'),(635,'mapadminnav','Map admin','cor','en','markup for map admin tab',91,'2014-02-06 18:33:24'),(636,'mapviewnav','Map','cor','en','map tab',91,'2014-02-13 17:48:38'),(645,'uploadsuccess','Upload Successful\r\n','cor','en','message returned by single file upload popup',91,'2014-02-17 12:52:56'),(646,'linksuccess','File linked to ','cor','en','message returned by file upload popup window',91,'2014-02-17 12:42:33'),(647,'filterabk','Addressbook Filter','abk','en','Label for address book filter',91,'2014-02-17 12:42:33'),(648,'filtername','Search by Name','abk','en','message returned by file upload popup window',91,'2014-02-17 12:42:33'),(649,'issuenext','Issue next','cor','en','shown in register for auto incrementing numbers',91,'2014-02-17 12:42:33'),(656,'filetype','File Type','cor','en','label for filetype in upload',91,'2014-02-21 12:01:13'),(657,'dryrunresults','Dry Run Results','cor','en','Title for upload dry run page',91,'2014-02-21 12:02:20'),(658,'batch_instructions_step2','Step 2\r\n','cor','en','Step 2 of upload',91,'2014-02-21 12:06:40'),(659,'draghere','Drag Here','cor','en','media uploader instructions',91,'2014-02-21 12:21:10'),(660,'media_uploader','Media Uploader','cor','en','Media Uploader Title',91,'2014-02-21 12:21:45'),(661,'from_comp','From Computer','cor','en','media uploader option from computer',91,'2014-02-21 12:22:16'),(662,'from_url','From Remote URL','cor','en','media uploader option from remote URL',91,'2014-02-21 12:22:53'),(663,'from_ml','From Media Library','cor','en','media uploader option from media library',91,'2014-02-21 12:24:19'),(664,'section','Section','cor','en','Section file sf title',91,'2014-02-21 12:27:43');
/*!40000 ALTER TABLE `cor_tbl_markup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_module` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shortform` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(3) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_module`
--

LOCK TABLES `cor_tbl_module` WRITE;
/*!40000 ALTER TABLE `cor_tbl_module` DISABLE KEYS */;
INSERT INTO `cor_tbl_module` VALUES (2,'abk_cd','mod_abk','abk','The Address Book Module',1,'2008-01-16 00:00:00'),(1,'cor_cd','mod_cor','cor','A core module for adding markup and aliases',4,'2011-06-23 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_number`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_number`
--

LOCK TABLES `cor_tbl_number` WRITE;
/*!40000 ALTER TABLE `cor_tbl_number` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_sgrp`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_sgrp` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sgrp` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A table of security groups';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_sgrp`
--

LOCK TABLES `cor_tbl_sgrp` WRITE;
/*!40000 ALTER TABLE `cor_tbl_sgrp` DISABLE KEYS */;
INSERT INTO `cor_tbl_sgrp` VALUES (1,'users',1,'2005-11-08 00:00:00'),(2,'admins',2,'2005-11-08 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_sgrp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_span`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_span`
--

LOCK TABLES `cor_tbl_span` WRITE;
/*!40000 ALTER TABLE `cor_tbl_span` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_span` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_spanattr`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_spanattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `span` int(10) NOT NULL DEFAULT '0',
  `spanlabel` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible attributing of text fragments';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_spanattr`
--

LOCK TABLES `cor_tbl_spanattr` WRITE;
/*!40000 ALTER TABLE `cor_tbl_spanattr` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_spanattr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_ste`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_ste` (
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_ste`
--

LOCK TABLES `cor_tbl_ste` WRITE;
/*!40000 ALTER TABLE `cor_tbl_ste` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_ste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_txt`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_txt`
--

LOCK TABLES `cor_tbl_txt` WRITE;
/*!40000 ALTER TABLE `cor_tbl_txt` DISABLE KEYS */;
INSERT INTO `cor_tbl_txt` VALUES (1,3,'abk_cd','ARK_1','Jane Doe','en',1,'2014-02-20 18:43:38'),(2,4,'abk_cd','ARK_1','JD','en',1,'2014-02-20 18:43:38');
/*!40000 ALTER TABLE `cor_tbl_txt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_users`
--

LOCK TABLES `cor_tbl_users` WRITE;
/*!40000 ALTER TABLE `cor_tbl_users` DISABLE KEYS */;
INSERT INTO `cor_tbl_users` VALUES (1,'doe_jd','a8c0d2a9d332574951a8e4a0af7d516f','Jane','Doe','JD',0,'support@lparchaeology.com',1,0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_wmc`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_wmc`
--

LOCK TABLES `cor_tbl_wmc` WRITE;
/*!40000 ALTER TABLE `cor_tbl_wmc` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_wmc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_wwwpages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_wwwpages`
--

LOCK TABLES `cor_tbl_wwwpages` WRITE;
/*!40000 ALTER TABLE `cor_tbl_wwwpages` DISABLE KEYS */;
INSERT INTO `cor_tbl_wwwpages` VALUES (1,'User Home','User Home Page',1,'user_home.php','3','home','?view=home','pownergrp|1,default_view|home,cur_page|user_home,cur_code_dir|php/user_home/',2,'2005-11-08 00:00:00'),(2,'Data Entry','Data Entry',3,'data_entry.php','1','data entry','?view=home','pownergrp|1,default_view|home,cur_page|data_entry,cur_code_dir|php/data_entry/',2,'2005-11-08 00:00:00'),(3,'User Admin','User Admin',2,'user_admin.php','2','users','?view=home','cur_code_dir|php/user_admin/',2,'2006-05-26 00:00:00'),(4,'Data Viewing','Data Viewing',4,'data_view.php','3','search','?view=standard','pownergrp|1,default_view|home,cur_page|data_view,cur_code_dir|php/data_view/',1,'2006-05-31 00:00:00'),(7,'micro_view','Micro Viewer',5,'micro_view.php','3','record view','?view=home','default_view|home,cur_page|micro_view,cur_code_dir|php/micro_view/',2,'2006-06-06 00:00:00'),(8,'map_view','Map Viewer',6,'map_view.php','3','map view','?view=home','default_view|home,cur_page|map_view,cur_code_dir|php/map_view/',1,'2006-09-11 00:00:00'),(9,'import_tools','Import Tools',8,'import.php','2','import','?view=home','default_view|home,cur_page|import_tools,cur_code_dir|php/import/',4,'2007-05-18 00:00:00'),(10,'login','Login',7,'index.php','3','login','','',4,'2007-05-18 00:00:00'),(11,'alias_admin','Alias Admin',8,'alias_admin.php','2','aliases','?view=home','default_view|home,cur_page|alias_admin,cur_code_dir|php/alias_admin/',4,'2007-05-18 00:00:00'),(12,'markup_admin','Markup Admin',8,'markup_admin.php','2','markup','?view=home','default_view|home,cur_page|markup_admin,cur_code_dir|php/markup_admin/',4,'2007-05-18 00:00:00'),(13,'overlay_holder','Overlay',10,'overlay_holder.php','3','Overlay','?view=home','default_view|home,cur_page|overlay_holder,cur_code_dir|php/overlay_holder/',1,'2006-06-06 00:00:00'),(14,'map_admin','Map Admin',7,'map_admin.php','2','map admin','?view=home','default_view|home,cur_page|map_admin,cur_code_dir|php/map_admin/',4,'2007-05-18 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_wwwpages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_xmi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cor_tbl_xmi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `xmi_itemkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `xmi_itemvalue` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_xmi`
--

LOCK TABLES `cor_tbl_xmi` WRITE;
/*!40000 ALTER TABLE `cor_tbl_xmi` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_tbl_xmi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-27 18:06:20
