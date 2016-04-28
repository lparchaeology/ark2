# ************************************************************
# Sequel Pro SQL dump
# Version 4325
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: ark1_2
# Generation Time: 2015-07-14 10:38:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table abk_lut_abktype
# ------------------------------------------------------------

CREATE TABLE `abk_lut_abktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abktype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `abk_lut_abktype` WRITE;
/*!40000 ALTER TABLE `abk_lut_abktype` DISABLE KEYS */;

INSERT INTO `abk_lut_abktype` (`id`, `abktype`, `cre_by`, `cre_on`)
VALUES
	(1,'people',4,'2007-05-15 00:00:00');

/*!40000 ALTER TABLE `abk_lut_abktype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table abk_tbl_abk
# ------------------------------------------------------------

CREATE TABLE `abk_tbl_abk` (
  `abk_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abk_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `abktype` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`abk_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `abk_tbl_abk` WRITE;
/*!40000 ALTER TABLE `abk_tbl_abk` DISABLE KEYS */;

INSERT INTO `abk_tbl_abk` (`abk_cd`, `abk_no`, `ste_cd`, `abktype`, `cre_by`, `cre_on`)
VALUES
	('ARK_1',1,'ARK',1,1,'2013-11-29 17:40:05');

/*!40000 ALTER TABLE `abk_tbl_abk` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_actiontype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_actiontype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actiontype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lookup table supplies types of actions';



# Dump of table cor_lut_aliastype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_aliastype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aliastype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_lut_aliastype` WRITE;
/*!40000 ALTER TABLE `cor_lut_aliastype` DISABLE KEYS */;

INSERT INTO `cor_lut_aliastype` (`id`, `aliastype`, `cre_by`, `cre_on`)
VALUES
	(1,'normal',1,'2006-08-31 00:00:00'),
	(2,'against',1,'2006-08-31 00:00:00'),
	(3,'boolean_true',2,'2009-11-06 00:00:00'),
	(4,'boolean_false',2,'2009-11-06 00:00:00');

/*!40000 ALTER TABLE `cor_lut_aliastype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_areatype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_areatype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areatype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_attribute
# ------------------------------------------------------------

CREATE TABLE `cor_lut_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attributetype` int(11) NOT NULL DEFAULT '0',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';

LOCK TABLES `cor_lut_attribute` WRITE;
/*!40000 ALTER TABLE `cor_lut_attribute` DISABLE KEYS */;

INSERT INTO `cor_lut_attribute` (`id`, `attribute`, `attributetype`, `module`, `cre_by`, `cre_on`)
VALUES
	(1,'mapbox',3,'cor',127,'2015-01-15 12:51:39'),
	(2,'localhost',3,'cor',127,'2015-01-15 12:53:21'),
	(3,'wms',2,'cor',127,'2015-01-15 12:54:01'),
	(4,'wfs',2,'cor',127,'2015-01-15 12:54:36'),
	(5,'tilejson',2,'cor',127,'2015-01-15 12:55:23'),
	(6,'geojson',2,'cor',127,'2015-01-15 12:56:45'),
	(7,'epsg:4326',1,'cor',127,'2015-01-15 12:57:22'),
	(8,'epsg:900913',1,'cor',127,'2015-01-15 12:57:22');

/*!40000 ALTER TABLE `cor_lut_attribute` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_attributetype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_attributetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';

LOCK TABLES `cor_lut_attributetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_attributetype` DISABLE KEYS */;

INSERT INTO `cor_lut_attributetype` (`id`, `attributetype`, `module`, `cre_by`, `cre_on`)
VALUES
	(1,'projection','map',127,'2015-01-15 12:40:19'),
	(2,'layerformat','map',127,'2015-01-15 12:41:19'),
	(3,'servertype','map',127,'2015-01-15 12:41:43');

/*!40000 ALTER TABLE `cor_lut_attributetype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_booltype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_booltype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booltype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_datetype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_datetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_file
# ------------------------------------------------------------

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



# Dump of table cor_lut_filetype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_filetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filetype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table cor_lut_language
# ------------------------------------------------------------

CREATE TABLE `cor_lut_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_lut_language` WRITE;
/*!40000 ALTER TABLE `cor_lut_language` DISABLE KEYS */;

INSERT INTO `cor_lut_language` (`id`, `language`, `cre_by`, `cre_on`)
VALUES
	(1,'en',1,'2006-08-31 00:00:00');

/*!40000 ALTER TABLE `cor_lut_language` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_numbertype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_numbertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qualifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';

LOCK TABLES `cor_lut_numbertype` WRITE;
/*!40000 ALTER TABLE `cor_lut_numbertype` DISABLE KEYS */;

INSERT INTO `cor_lut_numbertype` (`id`, `numbertype`, `module`, `qualifier`, `cre_by`, `cre_on`)
VALUES
	(1,'zoomlevel','map','',1,'2015-07-14 10:20:06');

/*!40000 ALTER TABLE `cor_lut_numbertype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lut_place
# ------------------------------------------------------------

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



# Dump of table cor_lut_placetype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_placetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_spanlabel
# ------------------------------------------------------------

CREATE TABLE `cor_lut_spanlabel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` int(3) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `spanlabel` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_spantype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_spantype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `meta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `evaluation` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `module` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';



# Dump of table cor_lut_txttype
# ------------------------------------------------------------

CREATE TABLE `cor_lut_txttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';

LOCK TABLES `cor_lut_txttype` WRITE;
/*!40000 ALTER TABLE `cor_lut_txttype` DISABLE KEYS */;

INSERT INTO `cor_lut_txttype` (`id`, `txttype`, `module`, `cre_by`, `cre_on`)
VALUES
	(4,'initials','abk',1,'2007-05-17 00:00:00'),
	(3,'name','abk',1,'2007-05-15 00:00:00'),
	(2,'short_desc','cor',1,'2005-11-21 00:00:00'),
	(1,'interp','cor',1,'2005-11-15 00:00:00'),
	(5,'layerstyle','cor',127,'2015-01-15 12:42:17'),
	(6,'layeruri','cor',127,'2015-01-15 12:42:48'),
	(7,'mapcenter','cor',127,'2015-01-15 12:43:14'),
	(8,'remotename','cor',127,'2015-01-15 12:43:58'),
	(9,'map_name','cor',127,'2015-01-15 12:44:45');

/*!40000 ALTER TABLE `cor_lut_txttype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_applications
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_applications` (
  `application_id` int(11) DEFAULT '0',
  `application_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `application_id_idx` (`application_id`),
  UNIQUE KEY `define_name_i_idx` (`application_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_applications` WRITE;
/*!40000 ALTER TABLE `cor_lvu_applications` DISABLE KEYS */;

INSERT INTO `cor_lvu_applications` (`application_id`, `application_define_name`)
VALUES
	(1,'ARK');

/*!40000 ALTER TABLE `cor_lvu_applications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_applications_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_applications_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_area_admin_areas
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_area_admin_areas` (
  `area_id` int(11) DEFAULT '0',
  `perm_user_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`area_id`,`perm_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_areas
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_areas` (
  `area_id` int(11) DEFAULT '0',
  `application_id` int(11) DEFAULT '0',
  `area_define_name` varchar(32) DEFAULT NULL,
  UNIQUE KEY `area_id_idx` (`area_id`),
  UNIQUE KEY `define_name_i_idx` (`application_id`,`area_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_areas` WRITE;
/*!40000 ALTER TABLE `cor_lvu_areas` DISABLE KEYS */;

INSERT INTO `cor_lvu_areas` (`area_id`, `application_id`, `area_define_name`)
VALUES
	(1,1,'USER_ADMIN'),
	(2,1,'DATA_ENTRY'),
	(3,1,'DATA_VIEW'),
	(4,1,'MICRO_VIEW'),
	(5,1,'MAP_VIEW'),
	(6,1,'IMPORT'),
	(7,1,'USER_HOME');

/*!40000 ALTER TABLE `cor_lvu_areas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_areas_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_areas_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_group_subgroups
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_group_subgroups` (
  `group_id` int(11) DEFAULT '0',
  `subgroup_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`subgroup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_group_subgroups` WRITE;
/*!40000 ALTER TABLE `cor_lvu_group_subgroups` DISABLE KEYS */;

INSERT INTO `cor_lvu_group_subgroups` (`group_id`, `subgroup_id`)
VALUES
	(1,3),
	(2,1);

/*!40000 ALTER TABLE `cor_lvu_group_subgroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_grouprights
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_grouprights` (
  `group_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`group_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_grouprights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_grouprights` DISABLE KEYS */;

INSERT INTO `cor_lvu_grouprights` (`group_id`, `right_id`, `right_level`)
VALUES
	(1,11,3);

/*!40000 ALTER TABLE `cor_lvu_grouprights` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_groups
# ------------------------------------------------------------

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

LOCK TABLES `cor_lvu_groups` WRITE;
/*!40000 ALTER TABLE `cor_lvu_groups` DISABLE KEYS */;

INSERT INTO `cor_lvu_groups` (`group_id`, `group_type`, `group_define_name`, `is_active`, `owner_user_id`, `owner_group_id`)
VALUES
	(1,1,'USERS',1,1,1),
	(2,1,'ADMINS',1,1,1),
	(3,1,'PUBLIC',1,1,1),
	(4,1,'SUPERVISORS',1,1,1);

/*!40000 ALTER TABLE `cor_lvu_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_groups_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_groups_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_groupusers
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_groupusers` (
  `perm_user_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_groupusers` WRITE;
/*!40000 ALTER TABLE `cor_lvu_groupusers` DISABLE KEYS */;

INSERT INTO `cor_lvu_groupusers` (`perm_user_id`, `group_id`)
VALUES
	(42,2);

/*!40000 ALTER TABLE `cor_lvu_groupusers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_perm_users
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_perm_users` (
  `perm_user_id` int(11) DEFAULT '0',
  `auth_user_id` varchar(32) DEFAULT NULL,
  `auth_container_name` varchar(32) DEFAULT NULL,
  `perm_type` int(11) DEFAULT '0',
  UNIQUE KEY `perm_user_id_idx` (`perm_user_id`),
  UNIQUE KEY `auth_id_i_idx` (`auth_user_id`,`auth_container_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_perm_users` WRITE;
/*!40000 ALTER TABLE `cor_lvu_perm_users` DISABLE KEYS */;

INSERT INTO `cor_lvu_perm_users` (`perm_user_id`, `auth_user_id`, `auth_container_name`, `perm_type`)
VALUES
	(42,'1','ARK_USERS',1);

/*!40000 ALTER TABLE `cor_lvu_perm_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_perm_users_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_perm_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_perm_users_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_perm_users_seq` DISABLE KEYS */;

INSERT INTO `cor_lvu_perm_users_seq` (`sequence`)
VALUES
	(89);

/*!40000 ALTER TABLE `cor_lvu_perm_users_seq` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_right_implied
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_right_implied` (
  `right_id` int(11) DEFAULT '0',
  `implied_right_id` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`right_id`,`implied_right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_rights
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_rights` (
  `right_id` int(11) DEFAULT '0',
  `area_id` int(11) DEFAULT '0',
  `right_define_name` varchar(32) DEFAULT NULL,
  `has_implied` tinyint(1) DEFAULT '1',
  UNIQUE KEY `right_id_idx` (`right_id`),
  UNIQUE KEY `define_name_i_idx` (`area_id`,`right_define_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_rights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_rights` DISABLE KEYS */;

INSERT INTO `cor_lvu_rights` (`right_id`, `area_id`, `right_define_name`, `has_implied`)
VALUES
	(1,1,'VIEW',0),
	(2,1,'EDIT',0),
	(11,6,'IMPORT_VIEW',0),
	(12,6,'IMPORT_EDIT',0);

/*!40000 ALTER TABLE `cor_lvu_rights` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_rights_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_rights_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_translations
# ------------------------------------------------------------

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



# Dump of table cor_lvu_translations_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_translations_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table cor_lvu_userrights
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_userrights` (
  `perm_user_id` int(11) DEFAULT '0',
  `right_id` int(11) DEFAULT '0',
  `right_level` int(11) DEFAULT '0',
  UNIQUE KEY `id_i_idx` (`perm_user_id`,`right_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_userrights` WRITE;
/*!40000 ALTER TABLE `cor_lvu_userrights` DISABLE KEYS */;

INSERT INTO `cor_lvu_userrights` (`perm_user_id`, `right_id`, `right_level`)
VALUES
	(1,1,1),
	(1,2,1),
	(2,2,1),
	(1,11,3);

/*!40000 ALTER TABLE `cor_lvu_userrights` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_lvu_users
# ------------------------------------------------------------

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



# Dump of table cor_lvu_users_seq
# ------------------------------------------------------------

CREATE TABLE `cor_lvu_users_seq` (
  `sequence` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `cor_lvu_users_seq` WRITE;
/*!40000 ALTER TABLE `cor_lvu_users_seq` DISABLE KEYS */;

INSERT INTO `cor_lvu_users_seq` (`sequence`)
VALUES
	(42);

/*!40000 ALTER TABLE `cor_lvu_users_seq` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_action
# ------------------------------------------------------------

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



# Dump of table cor_tbl_alias
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_alias` WRITE;
/*!40000 ALTER TABLE `cor_tbl_alias` DISABLE KEYS */;

INSERT INTO `cor_tbl_alias` (`id`, `alias`, `aliastype`, `language`, `itemkey`, `itemvalue`, `cre_by`, `cre_on`)
VALUES
	(1,'Address Book',1,'en','cor_tbl_module','2',1,'2013-11-28 17:03:27'),
	(2,'Users',1,'en','cor_tbl_sgrp','1',1,'2013-11-28 17:05:32'),
	(3,'Admins',1,'en','cor_tbl_sgrp','2',1,'2013-11-28 17:05:32'),
	(4,'Created By',1,'en','cor_tbl_col','1',1,'2013-11-29 13:36:43'),
	(5,'Created On',1,'en','cor_tbl_col','2',1,'2013-11-29 13:36:43'),
	(6,'Type',1,'en','cor_tbl_col','3',1,'2013-11-29 13:36:43'),
	(7,'Sub Area',1,'en','cor_lut_areatype','2',1,'2006-12-06 11:02:41'),
	(8,'Grid Square',1,'en','cor_lut_areatype','3',1,'2006-12-06 11:02:41'),
	(9,'Trench',1,'en','cor_lut_areatype','4',1,'2006-12-06 11:02:41'),
	(10,'OGR (Shapefiles)',1,'en','cor_lut_mapconnectiontype','4',1,'2006-12-06 11:11:01'),
	(11,'PostGIS',1,'en','cor_lut_mapconnectiontype','7',1,'2006-12-06 11:11:01'),
	(12,'WMS',1,'en','cor_lut_mapconnectiontype','5',1,'2006-12-06 11:11:01'),
	(13,'Raster',1,'en','cor_lut_mapconnectiontype','0',1,'2006-12-06 11:11:01'),
	(14,'People',1,'en','abk_lut_abktype','1',1,'2014-02-20 12:38:45'),
	(15,'Name',1,'en','cor_lut_txttype','3',1,'2014-02-20 17:25:25'),
	(16,'Initials',1,'en','cor_lut_txttype','4',1,'2014-02-20 17:23:11'),
	(17,'Zoom Level',1,'en','cor_lut_numbertype','1',127,'2015-01-15 12:34:15'),
	(18,'Projection',1,'en','cor_lut_attributetype','1',127,'2015-01-15 12:40:19'),
	(19,'Layer Format',1,'en','cor_lut_attributetype','2',127,'2015-01-15 12:41:19'),
	(20,'Server Type',1,'en','cor_lut_attributetype','3',127,'2015-01-15 12:41:43'),
	(21,'Style',1,'en','cor_lut_txttype','5',127,'2015-01-15 12:42:17'),
	(22,'Layer Source',1,'en','cor_lut_txttype','6',127,'2015-01-15 12:42:48'),
	(23,'Map Centre',1,'en','cor_lut_txttype','7',127,'2015-01-15 12:43:14'),
	(24,'Layer Name on Server (if required)',1,'en','cor_lut_txttype','8',127,'2015-01-15 12:43:58'),
	(25,'Name',1,'en','cor_lut_txttype','9',127,'2015-01-15 12:44:45'),
	(26,'MapBox',1,'en','cor_lut_attribute','315',127,'2015-01-15 12:51:39'),
	(27,'Local Host',1,'en','cor_lut_attribute','316',127,'2015-01-15 12:53:21'),
	(28,'wms',1,'en','cor_lut_attribute','317',127,'2015-01-15 12:54:01'),
	(29,'wfs',1,'en','cor_lut_attribute','318',127,'2015-01-15 12:54:36'),
	(30,'tilejson',1,'en','cor_lut_attribute','319',127,'2015-01-15 12:55:23'),
	(31,'geojson',1,'en','cor_lut_attribute','320',127,'2015-01-15 12:56:45'),
	(32,'EPSG:4326',1,'en','cor_lut_attribute','321',127,'2015-01-15 12:57:22'),
	(33,'EPSG:900913',1,'en','cor_lut_attribute','322',127,'2015-01-15 12:57:22');

/*!40000 ALTER TABLE `cor_tbl_alias` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_attribute
# ------------------------------------------------------------

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

LOCK TABLES `cor_tbl_attribute` WRITE;
/*!40000 ALTER TABLE `cor_tbl_attribute` DISABLE KEYS */;

INSERT INTO `cor_tbl_attribute` (`id`, `attribute`, `itemkey`, `itemvalue`, `boolean`, `cre_by`, `cre_on`)
VALUES
	(1,8,'cor_tbl_map','1',1,127,'2015-07-14 09:58:50');

/*!40000 ALTER TABLE `cor_tbl_attribute` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_bool
# ------------------------------------------------------------

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



# Dump of table cor_tbl_cmap
# ------------------------------------------------------------

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



# Dump of table cor_tbl_cmap_data
# ------------------------------------------------------------

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



# Dump of table cor_tbl_cmap_structure
# ------------------------------------------------------------

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



# Dump of table cor_tbl_col
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_col` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_col` WRITE;
/*!40000 ALTER TABLE `cor_tbl_col` DISABLE KEYS */;

INSERT INTO `cor_tbl_col` (`id`, `dbname`, `description`, `cre_by`, `cre_on`)
VALUES
	(1,'created_by','This holds the user id of the person who created this record',1,'0000-00-00 00:00:00'),
	(2,'created_on','This column holds the date that the record was created',1,'0000-00-00 00:00:00'),
	(3,'abktype','The column holding the addressbook type',1,'2007-01-15 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_col` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_date
# ------------------------------------------------------------

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



# Dump of table cor_tbl_file
# ------------------------------------------------------------

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



# Dump of table cor_tbl_filter
# ------------------------------------------------------------

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



# Dump of table cor_tbl_log
# ------------------------------------------------------------

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



# Dump of table cor_tbl_map
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_map` (
  `id` int(11) unsigned NOT NULL,
  `ste_cd` varchar(30) NOT NULL DEFAULT '',
  `map_cd` varchar(30) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL,
  `cre_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `cor_tbl_map` WRITE;
/*!40000 ALTER TABLE `cor_tbl_map` DISABLE KEYS */;

INSERT INTO `cor_tbl_map` (`id`, `ste_cd`, `map_cd`, `cre_by`, `cre_on`)
VALUES
	(1,'MNO12','1',127,0);

/*!40000 ALTER TABLE `cor_tbl_map` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_maplayer
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_maplayer` (
  `id` int(5) NOT NULL,
  `map` int(5) NOT NULL,
  `cre_by` int(5) NOT NULL,
  `cre_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table cor_tbl_markup
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_markup` WRITE;
/*!40000 ALTER TABLE `cor_tbl_markup` DISABLE KEYS */;

INSERT INTO `cor_tbl_markup` (`id`, `nname`, `markup`, `mod_short`, `language`, `description`, `cre_by`, `cre_on`)
VALUES
	(1,'addterm','Add Term','cor','en','for sf_attr_bytype',1,'2015-07-14 10:27:06'),
	(2,'adduser','Add a User','cor','en','',1,'2015-07-14 10:27:06'),
	(3,'addusr_sucs','The new user was successfuly created. To activate the account please contact a system administrator.','cor','en','A message for handling User Admin',1,'2015-07-14 10:27:06'),
	(4,'alifail','Alias was not added.','cor','en','',1,'2015-07-14 10:27:06'),
	(5,'aliscss','Alias was added sucessfully!','cor','en','',1,'2015-07-14 10:27:06'),
	(6,'andyet','No errors were present and YET no query was execut...','','en','A now legendary error message used in the update s...',1,'2015-07-14 10:27:06'),
	(7,'armdelete','PREPARE DELETION','cor','en','A label for delete buttons... danger!',1,'2015-07-14 10:27:06'),
	(8,'attrfail','Attribute was not added to control list.','cor','en','',1,'2015-07-14 10:27:06'),
	(9,'attrscss','Attribute was added succesfully','cor','en','',1,'2015-07-14 10:27:06'),
	(10,'batchname','Batch Name: ','cor','en','For file upload',1,'2015-07-14 10:27:06'),
	(11,'choose_lang','Choose a language','cor','en','',1,'2015-07-14 10:27:06'),
	(12,'choosectrllst','Choose a control list:','cor','en','for sf_attr_bytype',1,'2015-07-14 10:27:06'),
	(13,'clearall','Clear All','cor','en','',1,'2015-07-14 10:27:06'),
	(14,'confirmdel','Click <em>delete</em> to review and confirm deletion of multiple fragments','cor','en','A label used in deletions',1,'2015-07-14 10:27:06'),
	(15,'ctrllst','Control List','cor','en','for sf_attr_bytype',1,'2015-07-14 10:27:06'),
	(16,'ctrllsttitle','Add to Control Lists','cor','en','For sf_attr_bytype',1,'2015-07-14 10:27:06'),
	(17,'curuploaddir','Current Upload Directory: ','cor','en','For file upload',1,'2015-07-14 10:27:06'),
	(18,'delwarn','This record and ALL attached data will be permanently deleted. It is NOT possible to undo this action.<br/><br/>Be careful!','cor','en','A warning message used for deleting entire records',1,'2015-07-14 10:27:06'),
	(19,'edit','edit','cor','en','',1,'2015-07-14 10:27:06'),
	(20,'edituser','Edit a User','cor','en','',1,'2015-07-14 10:27:06'),
	(21,'enter','enter','cor','','',1,'2015-07-14 10:27:06'),
	(22,'err_attrtypedontexist','This attribute type doesn\'t exist. Please try again.','cor','en','For adding to control lists',1,'2015-07-14 10:27:06'),
	(23,'err_delfail','Something went wrong with the delete operation','cor','en','An error used in deletions',1,'2015-07-14 10:27:06'),
	(24,'err_nodelkey','No itemkey was sent for deletion','cor','en','An error used in deletions',1,'2015-07-14 10:27:09'),
	(25,'err_nodelval','No item value was sent for deletion','cor','en','An error used in deletions',1,'2015-07-14 10:27:09'),
	(26,'err_notvalid','The itemkey is not valid','cor','en','An error for invalid itemkeys',1,'2015-07-14 10:27:09'),
	(27,'err_recwasdel','This record was deleted','cor','en','An error used in deletions',1,'2015-07-14 10:27:09'),
	(28,'failure','Your attempt was not successful, please try again.','cor','en','for adding to control lists',1,'2015-07-14 10:27:09'),
	(29,'files_uploaded','files uploaded successfully!','cor','en','for file uploads',1,'2015-07-14 10:27:09'),
	(30,'filteractor','Search by Actor','cor','en','',1,'2015-07-14 10:27:09'),
	(31,'filteratt','Search by Attribute','cor','en','',1,'2015-07-14 10:27:09'),
	(32,'filterpanel','Search Tools','cor','en','',1,'2015-07-14 10:27:09'),
	(33,'filters','Search','cor','en','',1,'2015-07-14 10:27:09'),
	(34,'forms','Data Entry','cor','en','A label for a list of forms',1,'2015-07-14 10:27:09'),
	(35,'formupload_instructions','To upload files, enter a batch name or module and browse to the upload directory below (/www/htdocs/ark/data/upload).','cor','en','For file upload',1,'2015-07-14 10:27:09'),
	(36,'frm_select','Please select an option from the left.','cor','en','',1,'2015-07-14 10:27:09'),
	(37,'ftx','Free Text Search','cor','en','',1,'2015-07-14 10:27:09'),
	(38,'ifsure','If you are certain this is not a duplicate, add the term.','cor','en','for adding to control lists',1,'2015-07-14 10:27:09'),
	(39,'make_filter','New Search','cor','en','',1,'2015-07-14 10:27:09'),
	(40,'module','Module','cor','en','For file upload',1,'2015-07-14 10:27:09'),
	(41,'newterm','Suggest a new term:','cor','en','for sf_attr_bytype',1,'2015-07-14 10:27:09'),
	(42,'newtermlab','New term label','cor','en','sf_attr_bytype',1,'2015-07-14 10:27:09'),
	(43,'no_reg_files','No files selected!','cor','en','For register',1,'2015-07-14 10:27:09'),
	(44,'notset','Not set','cor','en','For unset sf_attr_boolean',1,'2015-07-14 10:27:09'),
	(45,'num_pages','Number of results per page:','cor','en','',1,'2015-07-14 10:27:09'),
	(46,'numfrags','Number of fragments attached to this record','cor','en','A label used in deletions',1,'2015-07-14 10:27:09'),
	(47,'options','Options','cor','en','Label for the options column of a table',1,'2015-07-14 10:27:09'),
	(48,'publicfilters','Common Searches','cor','en','',1,'2015-07-14 10:27:09'),
	(49,'qed','edit','cor','en','',1,'2015-07-14 10:27:09'),
	(50,'rectree','The following tree represents the entire record and all child fragments','','en','A message for sf_dnarecord.php',1,'2015-07-14 10:27:09'),
	(51,'rerunall','Rerun All','cor','en','',1,'2015-07-14 10:27:09'),
	(52,'resetform','Reset Form','cor','en','to reset sf_attr_bytype',1,'2015-07-14 10:27:09'),
	(53,'sf_number_incompl','No number data has been added','cor','en','',1,'2015-07-14 10:27:09'),
	(54,'sf_txt_incompl','No text data has been added','cor','en','',1,'2015-07-14 10:27:09'),
	(55,'similar','A similar term already exists in this list','cor','en','for adding to control lists',1,'2015-07-14 10:27:09'),
	(56,'success','The new item was added to the control list. Please reset the form to add additional items.','cor','en','',1,'2015-07-14 10:27:09'),
	(57,'tryotherterm','Or try another new term','cor','en','for adding to control lists',1,'2015-07-14 10:27:09'),
	(58,'uplfile','Upload File','cor','en','',1,'2015-07-14 10:27:09'),
	(59,'user_admin','User Administration Home','cor','en','',1,'2015-07-14 10:27:09'),
	(60,'user_home','User Home','cor','en','',1,'2015-07-14 10:27:09'),
	(61,'view','view','cor','en','',1,'2015-07-14 10:27:09'),
	(62,'welcome','Welcome to ARK, ','cor','en','',1,'2015-07-14 10:27:09'),
	(63,'pickmap','Choose a map','cor','en','title for the map choosing overlay',1,'2015-07-14 10:27:09'),
	(64,'addThisLayer','Add Layer','cor en','en','text for add layer button',1,'2015-07-14 10:27:09'),
	(65,'newmap','Create new map','cor','en','text for create new map button',1,'2015-07-14 10:27:09'),
	(66,'err_dategen','There was an error getting the date','cor','en','Error message to use with dates',1,'2006-05-08 05:30:12'),
	(67,'err_notxtid','The text id was not set','cor','en','Error message useful when handling attributes of a text',1,'2006-05-08 05:30:12'),
	(68,'add','add','cor','en','The word add which may be used for buttons',1,'2006-05-08 17:30:12'),
	(69,'err_nocxtno','The value \"context number\" was not set','cor','en','Error message to use when no cxt_no value was set',1,'2006-05-08 17:30:12'),
	(70,'err_nocxttype','The value \"context type\" was not set','cor','en','Error message to use when no context type value was set',1,'2006-05-08 17:30:12'),
	(71,'err_noorigby','The value \"record author\" was not set','cor','en','Error message to use when no author has been set',1,'2006-05-08 17:30:12'),
	(72,'err_notxt','The value \"txt\" was not set','cor','en','Error message to use when no txt value was set',1,'2006-05-08 17:30:12'),
	(73,'go','go','cor','en','The word go which may be used for buttons',1,'2006-05-08 17:30:12'),
	(74,'reset','reset','cor','en','The word reset which may be used for buttons',1,'2006-05-08 17:30:12'),
	(75,'save','save','cor','en','The word save which may be used for buttons',1,'2006-05-08 17:30:12'),
	(76,'err_tvectbeg','There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be set, it may only be numbers and it must be a valid context in this site code.','cor','en','Error message for tvector beginning',1,'2006-05-11 00:00:00'),
	(77,'err_tvectbeginvalid','There is an error with the beginning of the matrix relationship you tried to enter (the later value). This must be a valid context number in this site code. Check that context has been issued.','cor','en','Error message for tvector beginning',1,'2006-05-11 00:00:00'),
	(78,'err_tvectend','There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be set, it may only be numbers and it must be a valid context in this site code.','cor','en','Error message for tvector beginning',1,'2006-05-11 00:00:00'),
	(79,'err_tvectendinvalid','There is an error with the end of the matrix relationship you tried to enter (the earlier value). This must be a valid context number in this site code. Check that context has been issued.','cor','en','Error message for tvector beginning',1,'2006-05-11 00:00:00'),
	(80,'err_tvectlab','There is an error with the label you are trying to add to this matrix relationship. This must be a number and it must be entered in the label list.','cor','en','Error message for tvector beginning',1,'2006-05-11 00:00:00'),
	(81,'err_spnlablinvalid','The relationship type you selected is not possible to the contexts you selected.','cor','en','Testing',1,'2006-05-12 00:00:00'),
	(82,'err_nospanid','No span id number has been specified.','cor','en','An error message for handling tvectors',1,'2006-05-15 00:00:00'),
	(83,'datatoolbox','Data Toolbox','cor','en','A header for the data toolbox area',1,'2006-05-23 00:00:00'),
	(84,'notdigitised','This item has no spatial data attached at the moment ','cor','en','A message to show if theres is no spatial data',1,'2006-05-23 14:25:00'),
	(85,'addusr_instructions','All fields must be filled in. Please check to make sure that you are not accidentally creating a duplicate user.\n\n\nThe new user account will be created disabled. In order to activate the account, the account must be edited by a system administrator.','cor','en','A message for handling User Admin',1,'2006-05-30 00:00:00'),
	(86,'adusrl_instructions','All fields must be filled in.\n\n\nThe new user account will be created enabled.','cor','en','A message for handling User Admin',1,'2006-05-30 00:00:00'),
	(87,'create_user','Create User','cor','en','A message for handling User Admin',1,'2006-05-30 00:00:00'),
	(88,'edt_user','Edit User','cor','en','A message for handling User Admin',1,'2006-05-30 00:00:00'),
	(89,'err_dupinit','Those initials already exist','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(90,'err_dupuname','That username already exists.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(91,'err_noemail','No email was set.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(92,'err_nofname','No first name was set.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(93,'err_noinit','No \'intials\' were set.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(94,'err_nolname','No last name was set.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(95,'err_nouname','No username was set.','cor','en','An error for handling User Admin errors',1,'2006-05-30 00:00:00'),
	(96,'addusr_newid','The new user account has been successfuly created. Make a note of the new username. The new username is:','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(97,'change_pw','Change Password','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(98,'cpw','Confirm password','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(99,'edt_sgrps','Edit \'S-Groups\'','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(100,'email','eMail','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(101,'err_nocpw','No confirmation password was set','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(102,'err_nopw','No password was set.','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(103,'err_pwmatch','The password and confirmation password do NOT match.','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(104,'fname','First name','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(105,'init','Initials','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(106,'lname','Last name','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(107,'pw','Password','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(108,'uname','Username','cor','en','A message for handling User Admin',1,'2006-05-31 00:00:00'),
	(109,'accdis','Account disabled','cor','en','A message for handling User Admin',1,'2006-06-01 00:00:00'),
	(110,'accena','Account enabled','cor','en','A message for handling User Admin',1,'2006-06-01 00:00:00'),
	(111,'enable','Enable / Disable user account','cor','en','A message for handling User Admin',1,'2006-06-01 00:00:00'),
	(112,'err_duprel','That is a duplicate relationship, it can\'t be added.','cor','en','A generic error message',1,'2006-06-01 00:00:00'),
	(113,'err_nosgrp','No security group has been set.','cor','en','A message for handling User Admin',1,'2006-06-01 00:00:00'),
	(114,'err_nouid','No user id has been set.','cor','en','A message for handling User Admin',1,'2006-06-01 00:00:00'),
	(115,'detfrm','Form','cor','en','Alias of the detailed data entry form',1,'2006-06-03 00:00:00'),
	(116,'regist','Register','cor','en','Alias of the register entry from',1,'2006-06-03 00:00:00'),
	(117,'nofilters','No search filters are set, please add a new search filter','cor','en','A message to say that no filters are set',1,'2006-12-08 00:00:00'),
	(118,'norec','Your search did not return any results','cor','en','A message to display when the result set is empty',1,'2006-12-08 00:00:00'),
	(119,'score','Relevancy score','cor','en','MArkup for hte relevancy score',1,'2006-12-08 00:00:00'),
	(120,'viewmsg','View Record','cor','en','Message for linking out to the record view option',1,'2006-12-08 00:00:00'),
	(121,'expcsv','Export as CSV','cor','en','Exports the results as comma separated values',1,'2007-01-15 00:00:00'),
	(122,'expxml','Export as XML','cor','en','To export data as XML',1,'2007-01-15 00:00:00'),
	(123,'search','Search','cor','en','Search',1,'2007-01-15 00:00:00'),
	(124,'vwmap','View as Map','cor','en','Used to give options for results view',1,'2007-01-15 00:00:00'),
	(125,'vwtbl','View as Table','cor','en','To view results as a table',1,'2007-01-15 00:00:00'),
	(126,'notinauthitems','Not in Auth Items','cor','en','Displayed when field is not in auth items.',1,'2007-05-17 00:00:00'),
	(127,'space','&nbsp;','cor','en','A non-breaking space when no markup is required',1,'2007-05-17 00:00:00'),
	(128,'no_interps','No Interpretations','cor','en','Markup for indicating there are no interpretations available',1,'2007-06-06 00:00:00'),
	(129,'noxmi','No Linked Records','cor','en','Markup for items missing an xmi link',1,'2008-05-27 00:00:00'),
	(130,'micro_view_forms','Record View','cor','en','Heading of micro viewing forms',1,'2008-06-03 00:00:00'),
	(131,'files','Files','cor','en','It\'s some markup for files.',1,'2008-07-16 00:00:00'),
	(132,'filterstecd','Search By Site Code','cor','en','label for filter',1,'2008-11-12 00:00:00'),
	(133,'filetype','File type','','en','File type',1,'2010-09-25 12:37:57'),
	(134,'upload_method','Upload Method','','en','Upload Method',1,'2010-09-25 15:36:25'),
	(135,'fu_simple','simple','cor','en','Simple file upload',1,'2010-10-02 19:49:58'),
	(136,'fu_autoreg','autoregister','cor','en','Create the moule entry if ID does not exist during the upload',1,'2010-10-02 19:52:05'),
	(137,'fu_links','create links','cor','en','create links',1,'2010-10-02 19:52:50'),
	(138,'fu_linkedonly','linked files only','cor','en','Register only files which match the predefined pattern and ID has been registered before',1,'2010-10-02 19:53:51'),
	(139,'succsreload','RESET','cor','en','Label for sf_modtype',1,'2010-10-04 16:05:29'),
	(140,'err_noconflictres','Admin Error: This SF is missing the var conflict_res_sf which tells the subform where to send users for conflict resolution. You must set this up as per documentation.','cor','en','Label for sf\'s that use conflict resolution',1,'2010-10-04 17:15:34'),
	(141,'currkey','Current Itemkey','cor','en','Label of sf_itemkey',1,'2010-10-11 17:52:41'),
	(142,'tgtkey','Target Itemkey','cor','en','Label of sf_itemkey',1,'2010-10-11 17:53:03'),
	(143,'valchgsuccs','The value was successfuly updated. You should now reload this item.','cor','en','A label for sf_itemval',1,'2010-10-12 17:57:08'),
	(144,'changevalwarn','Warning! Some fragments of data are already attached to this record. These will be transferred to the new item. Look at these in detail before making the change.','cor','en','A label for sf_itemval.',1,'2010-10-12 18:03:29'),
	(145,'waitmsg','Processing your download. Please be patient. This may take up to 5 minutes.','cor','en','A label for the download export.',1,'2010-12-20 14:35:48'),
	(146,'dlsucs','The file was sucessfully created. You can download this using the link below or directly from the data/downloads directory.','cor','en','Label for sf_exportdownload',1,'2010-12-23 16:04:34'),
	(147,'dlinfo','This is going to create a file and then offer you a download. This can only be used for a single module. The data in the exported file will be based on the fields in the current display.','cor','en','Label for sf_exportdownload.php',1,'2010-12-23 16:06:36'),
	(148,'reqfileformat','File format','cor','en','Label for sf_exportdownload',1,'2010-12-23 16:07:03'),
	(149,'exportdownloadcsv','Export data to a file','cor','en','Label for sf_exportdownload',1,'2010-12-23 16:10:59'),
	(150,'prepdl','Prepare file','cor','en','Label for sf_exportdownload',1,'2010-12-23 16:16:32'),
	(151,'problem_string','Problem String','cor','en','Label used by CSV exports',1,'2011-01-06 21:16:26'),
	(152,'problem_item','Problem Item','cor','en','Label used by CSV exports',1,'2011-01-06 21:16:59'),
	(153,'problem_csv_detected','A problem field was detected. This has not prevented the file from being created, but may cause problems when opening this file in some spreadsheet programs. This was caused by your text delimiter occurring within a field.','cor','en','Label used by CSV exporter',1,'2011-01-06 21:41:08'),
	(154,'addfield','Select a new field to add to the view.','cor','en','Label for sf_userconfigfields',1,'2011-01-19 12:43:28'),
	(155,'fieldconfiginfo','This form allows you to add and remove fields from the current view. In order to remove a field, click the minus sign at the left hand side of the table below. In order to add fields, use the form provided below the table.','cor','en','Label foe sf_userconfigfields',1,'2011-01-19 12:46:23'),
	(156,'resetresultsinfo','In order to reset this view to the standard configuration, please use the reset button.','cor','en','Label for the sf_userconfigfields',1,'2011-01-19 16:44:19'),
	(157,'change','Change','cor','en','Markup for change button in change modtype dialogue',1,'2011-02-07 00:00:00'),
	(158,'changewarn','Warning! There some subforms are set up differently for the target type. Look at these in detail before making the change.','cor','en','Markup for change warning when changing modtype',1,'2011-02-07 00:00:00'),
	(159,'conflictwarn','Warning! Conflicted fragments of data WILL be deleted in order to make the change. This cannot be undone.','cor','en','Markup for conflicting fragments warning in change modtype dialogue',1,'2011-02-07 00:00:00'),
	(160,'modtypechanged','The modtype was successfully changed. You must now reset your page view using the button below.','cor','en','Markup displayed when modtype of item is successfully changed in change modtype dialogue',1,'2011-02-07 00:00:00'),
	(161,'numconflictfrags','Number of conflicted fragments','cor','en','Markup for number of conflicting data fragments when changing modtype',1,'2011-02-07 00:00:00'),
	(162,'numconflictsfs','Number of Conflicted Subforms','cor','en','Markup for conflicted subforms in modtype dialogue',1,'2011-02-07 00:00:00'),
	(163,'submit','Submit','cor','en','Markup displayed when modtype of item is successfully changed in change modtype dialogue',1,'2011-02-07 00:00:00'),
	(164,'tgtmodtype','Target Modtype','cor','en','Markup for target modtype in change modtype dialogue',1,'2011-02-07 00:00:00'),
	(165,'all','All','cor','en','label for top of attribute indexed search',1,'2011-06-09 00:00:00'),
	(166,'dl','Download','cor','en','Markup for download dialogue',1,'2011-06-09 00:00:00'),
	(167,'no_file','No files have been added yet','cor','en','Markup appearing when no files in upload direcotry',1,'2011-06-09 00:00:00'),
	(168,'no_files','There are currently no files in the configured upload directory:','cor','en','Markup appearing when no files in upload direcotry',1,'2011-06-09 00:00:00'),
	(169,'exportfeed','Export as feed','cor','en','A label for the feedbuilder',1,'2011-06-09 13:21:39'),
	(170,'prepfeed','Prepare the feed','cor','en','A label for the feed builder',1,'2011-06-09 13:22:21'),
	(171,'help','Help','cor','en','For the help navigation.',1,'2011-06-09 15:30:52'),
	(172,'markupadminoptions','Markup Administration','cor','en','For the left panel of the markup admin pages.',1,'2011-06-09 15:31:35'),
	(173,'edtalias','Edit Alias','cor','en','For the alias admin options',1,'2011-06-09 15:31:59'),
	(174,'edtalias','Edit Alias','cor','en','For the alias admin options',1,'2011-06-09 15:31:59'),
	(175,'aliasadminoptions','Alias Administration','cor','en','For the left panel header of the alias admin home.',1,'2011-06-09 15:32:17'),
	(176,'importoptions','Import','cor','en','For the home of the import options.',1,'2011-06-09 15:32:37'),
	(177,'savedfilters','Saved Searches','cor','en','For the mysavedstuff subform in search and user home pages.',1,'2011-06-09 15:36:21'),
	(178,'your','Your','cor','en','For the yoursavedstuff subform.',1,'2011-06-09 15:36:35'),
	(179,'dvlp_filters','Make a New Search','cor','en','For the filter building subform.',1,'2011-06-09 15:37:16'),
	(180,'infinity','view all','cor','en','For viewing all search results',1,'2011-06-09 15:40:03'),
	(181,'totalres','Total Results:','cor','en','Markup display the total number of search results',1,'2011-06-09 15:41:50'),
	(182,'totalpages','Total Pages: ','cor','en','For the total number of results pages',1,'2011-06-09 15:41:58'),
	(183,'user','User','cor','en','For the left panel labels in the user admin pages.',1,'2011-06-09 15:44:51'),
	(184,'chgtype','type','cor','en','For changing the modtype',1,'2011-06-09 16:14:34'),
	(185,'delete','DELETE','cor','en','labels',1,'2011-06-09 16:17:10'),
	(186,'changemod','Change the Item Type','cor','en','For title of change modtype button',1,'2011-06-09 16:17:45'),
	(187,'changeval','Change the Record Number','cor','en','For changing the itemkey',1,'2011-06-09 16:18:06'),
	(188,'chgkey','number','cor','en','For changing the item value',1,'2011-06-09 16:18:53'),
	(189,'addctrllst','Admin Tools- Add to control lists','cor','en','For a button to add to control lists in data entry, micro view',1,'2011-06-09 16:19:23'),
	(190,'limit','Limit feed to this many records','cor','en','Label for the sf_feedbuilder',1,'2011-06-10 11:06:07'),
	(191,'feedview','Use fields based on the current display mode','cor','en','Label for the sf_feedbuilder',1,'2011-06-10 11:16:25'),
	(192,'feedinfo','This form will make the current result setup available as a feed. The setup includes the filters and the sort order, but the fields used in the feed will be based on the deafult fields for this display mode (table/thumbnail/text) for each module in the feed. The feed will be publicly accessible on the link supplied, although the link may be hard to find, the contents of this feed will not be secured.','cor','en','Information for the feedbuilder',1,'2011-06-10 11:21:05'),
	(193,'feedtitle','Feed title (any name you want to remember this by)','cor','en','Label for sf_feedbuilder',1,'2011-06-10 11:58:06'),
	(194,'csv','CSV','cor','en','Label for downloading a CSV of search results.',1,'2011-06-10 12:46:36'),
	(195,'err_feeddbsave','There was an error saving the feed to the database','cor','en','Label for sf_feedbuilder',1,'2011-06-10 13:28:01'),
	(196,'feedsucs','The feed was sucessfully created. You can view the feed by clicking the link below or by copying and pasting the URL printed below.','cor','en','Label for the sf_feedbuilder',1,'2011-06-10 13:31:59'),
	(197,'feedlink','Feed','cor','en','A label for the sf_feedbuilder',1,'2011-06-10 13:35:32'),
	(198,'err_feeddisp_mode','No disp_mode (table/text/thumb etc) was set for the feed.','cor','en','Label for sf_feedbuilder',1,'2011-06-10 14:27:29'),
	(199,'feeddesc','Feed description','cor','en','Label for sf_feedbuilder',1,'2011-06-10 15:50:20'),
	(200,'err_feeddesc','No feed description was set','cor','en','Label for sf_feedbuilder',1,'2011-06-10 15:50:58'),
	(201,'curmodtype','Current Type: ','cor','en','For changing modtypes subform',1,'2011-06-10 16:08:27'),
	(202,'reclabel','Record','cor','en','For changing modtypes subform',1,'2011-06-10 16:09:35'),
	(203,'novalue','No records attached.','cor','en','For an xmi subform with no records attached.',1,'2011-06-10 16:16:59'),
	(204,'vwtext','View as Text','cor','en','Hover text for text display of search results',1,'2011-06-10 16:55:48'),
	(205,'vwthumb','View as Thumbnails','cor','en','Hover text for thumbs display of search results',1,'2011-06-10 16:55:54'),
	(206,'configfields','Configure visible fields','cor','en','Hover text for tools to configure fields in search results',1,'2011-06-10 17:08:00'),
	(207,'vwall','View Full Records (Print View)','cor','en','Hover text for displaying all full records for printing',1,'2011-06-10 17:08:49'),
	(208,'table','table','cor','en','Header of table view of search results',1,'2011-06-10 17:09:28'),
	(209,'text','text','cor','en','Header of text view of search results',1,'2011-06-10 17:10:09'),
	(210,'thumb','thumbs','cor','en','header for thumbs view of search results',1,'2011-06-10 17:10:56'),
	(211,'nofile','No files attached to this record','cor','en','Message when no files present in a sf_file',1,'2011-06-10 17:13:31'),
	(212,'filteritem','Record Type','cor','en','Label for the filter builder when searching by key',1,'2011-06-10 17:36:50'),
	(213,'nosuggestions','No Suggestions','cor','en','Used in the livesearch suggestion script',1,'2011-06-15 16:11:04'),
	(214,'no_spat_results','No spatial results for this search.','cor','en','A message for a spatial search result with no spatial data.',1,'2011-06-15 17:59:30'),
	(215,'dl','Download','cor','en','A download link for overlays',1,'2011-06-16 10:54:33'),
	(216,'dlsucs','Download Success!','cor','en','Successful generation of a map for download',1,'2011-06-16 10:54:58'),
	(217,'all','All','cor','en','For the filter by attribute to show all of a given attribute',1,'2011-06-24 15:12:30'),
	(218,'filterfindtype','Find Type','cor','en','Label for find type filters.',1,'2011-06-24 15:16:58'),
	(219,'filtercxt','Contexts','cor','en','Label for context filters',1,'2011-06-24 15:22:09'),
	(220,'filterspan','Date Range','cor','en','Label for a date range based filter.',1,'2011-06-24 15:25:07'),
	(221,'rss','RSS','cor','en','Label for RSS export functionality',1,'2011-06-29 14:03:17'),
	(222,'reqfileformat','File format','cor','en','Label for feed file format',1,'2011-07-01 14:03:24'),
	(223,'err_notauthforedit','Sorry, you don\'t have access to enter or edit this data.','cor','en','Label to prevent anon users editing data.',1,'2011-07-01 14:48:14'),
	(224,'anonoverlayaccess','Sorry, you do not have access to these administrator options.','cor','en','Label to alert anon users they cannot have overlays.',1,'2011-07-01 14:51:26'),
	(225,'anonoverlayaccess','Sorry, you do not have access to these administrator options.','cor','en','Label to alert anon users they cannot have overlays.',1,'2011-07-01 14:51:26'),
	(226,'filtertype','Single Record','cor','en','Label for a manual filter',1,'2011-07-01 17:40:20'),
	(227,'no_files','There are currently no files in the upload directory: ','cor','en','A markup displayed when the configured upload directory is empty.',1,'2011-07-16 20:32:46'),
	(228,'from_comp','From Computer','cor','en','label for sf_meejabrowser',1,'2012-03-02 10:55:19'),
	(229,'from_url','From URL','cor','en','label for sf_meejabrowser',1,'2012-03-02 10:55:50'),
	(230,'from_ML','From Media Library','cor','en','label for sf_mediabrowser',1,'2012-03-02 10:56:32'),
	(231,'media_uploader','Media Uploader','cor','en','label for sf_mediabrowser',1,'2012-03-02 11:13:48'),
	(232,'draghere','To upload a file, drag and drop it here or press','cor','en','label for the meeja_browser',1,'2012-03-02 14:53:01'),
	(233,'beingthumbed','is currently being processed and thumbnailed','cor','en','label for sf_mediabrowser',1,'2012-03-02 16:56:57'),
	(234,'uploadsuccess','has been successfully uploaded and thumbnailed','cor','en','label for sf_mediabrowser',1,'2012-03-02 18:18:59'),
	(235,'uploadsuccessnocrunch','has been successfully uploaded but not thumbnailed.','cor','en','labels for sf_mediabrowser',1,'2012-03-02 18:25:32'),
	(236,'linksuccess','has been linked to','cor','en','label for sf_mediabrowser',1,'2012-03-04 09:00:27'),
	(237,'urllabel','URL of Remote File','cor','en','label for sf_mediabrowser',1,'2012-03-05 11:07:08'),
	(238,'urllinking','has been successfully registered with ARK and thumbnailed','cor','en','label for mediabrowser',1,'2012-03-05 13:23:05'),
	(239,'urllinkingnocrunch','has been registered within ARK but not thumbnailed','cor','en','label for sf_mediabrowser',1,'2012-03-05 13:24:22'),
	(240,'linkfiles','Update links','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:12:06'),
	(241,'moreinfo','more info','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:12:35'),
	(242,'lessinfo','less info','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:12:48'),
	(243,'make','Make','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:13:35'),
	(244,'model','Model','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:13:48'),
	(245,'exposuretime','Exposure Time','cor','en','label for sf_mediabrowser used in extract exif data',1,'2012-03-10 10:14:09'),
	(246,'fnumber','F Stop','cor','en','label for sf_mediabrowser used in extract exif data',1,'2012-03-10 10:14:29'),
	(247,'iso','ISO','cor','en','label for sf_mediabrowser used in extract exif data',1,'2012-03-10 10:14:49'),
	(248,'date','Date','cor','en','label for sf_mediabrowser',1,'2012-03-10 10:15:01'),
	(249,'back','Back','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(250,'batch_instructions_a','Auto-Register mode is used when you have a collection of files which you want to add to ARK, but also to create new items to link them to at the same time. This mode is useful if you are uploading a series of plans (for example) that you later want to add metadata to.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(251,'batch_instructions_c','Add and Link mode will examine the filename of each file to see if it matches a pre-defined pattern. If it does then it will add the file to ARK and create a link to the matching item within the database. If no matching item is found then the file will be added to ARK anyway, which can then be manually linked later using the Media Browser.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(252,'batch_instructions_l','Link mode will examine the filename of each file to see if it matches a pre-defined pattern. If it does then it will add the file to ARK and create a link to the matching item within the database. If no matching item is found, then the file will NOT be added to ARK. This mode is usful if you are uploading (for example) a set of photos to be linked to context records that you have already entered in ARK.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(253,'batch_instructions_pt2','or by browsing the server for previously uploaded files:','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(254,'batch_instructions_s','Use the simple mode to easily add files to ARK, without linking them to items.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(255,'batch_instructions_step2','Now choose the method you want to use to upload the files in ','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(256,'dryrunresults','This is the results of an initial dry run of the import. Please look through this table carefully and check that everything will be undertaken as you wish. If you are happy with the results, press the live add button - if not then please press the go back button to make changes.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(257,'liveaddresults','Your batch file upload is complete. Please see the table below for feedback. You may now close the form.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(258,'modtype','Module Type','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(259,'nobatch','You have not chosen a batchname to use for this upload. Please choose one as it will make finding your uploads easier within the Media Browser.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(260,'nofiles','There are currently no files attached to this record ','cor','en','A markup displayed when there are no files attached to a record in sf_file.',1,'2012-03-12 21:44:19'),
	(261,'nofiletype','Please choose a filetype to use for this upload.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(262,'nomodule','Please choose a module to use for this upload.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(263,'nopattern','You have not chosen a pattern to use for the linking.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(264,'nouploadmethod','Please choose a valid upload method to use for this upload.','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(265,'pattern','Regex Pattern','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(266,'runliveadd','RUN LIVE ADD','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(267,'unreadableurl','It would seem the remote URL supplied is unreadable. Please supply a valid URL or ensure the remote server has directory listing enabled','cor','en','label for sf_batchfileupload',1,'2012-03-12 21:44:19'),
	(268,'filename','File Name','cor','en','Markup displayed in media browser more info with file name',1,'2012-03-13 11:51:09'),
	(269,'userhomenav','home','cor','en','Markup for user home navigation',1,'2012-03-19 14:55:53'),
	(270,'usersnav','user admin','cor','en','Markup for user admin navigation',1,'2012-03-19 14:56:38'),
	(271,'dataentrynav','data entry','cor','en','Markup for data entry navigation',1,'2012-03-19 14:56:55'),
	(272,'searchnav','search','cor','en','Markup for search navigation',1,'2012-03-19 14:57:11'),
	(273,'recordviewnav','record view','cor','en','Markup for micro view navigation',1,'2012-03-19 14:57:33'),
	(274,'importnav','import','cor','en','Markup for import page navigation',1,'2012-03-19 14:58:47'),
	(275,'refresh','Refresh','cor','en','Markup for refresh button',1,'2012-03-19 15:43:58'),
	(276,'dvlp_searchitems','Search Records','cor','en','Markup for lpanel heading of standard item filters in data view',1,'2012-03-19 16:33:32'),
	(277,'dvlp_searchcriteria','Search Criteria','cor','en','Markup for lpanel heading of filter criteria in data view',1,'2012-03-19 16:34:29'),
	(278,'filterabk','Search Address Book','cor','en','Markup for filtering address book entries in data view, displayed in lpanel',1,'2012-03-19 16:35:42'),
	(279,'batch_file_upload','Batch File Uploader','cor','en','label for sf_batchfileuploader',1,'2012-03-19 18:15:24'),
	(280,'batchurl','URL of Remote Directory','cor','en','label for sf_batchfileuploader',1,'2012-03-19 18:15:24'),
	(281,'uploadmissing','It seems you are missing an upload directory or a upload URL - please specify this using one of the forms below','cor','en','label for sf_batchfileuploader',1,'2012-03-19 18:15:24'),
	(282,'uploadthisdir','Upload files in this directory','cor','en','label for sf_batchfileuploader',1,'2012-03-19 18:15:24'),
	(283,'batch_uploadbyurl','Upload files from a remote URL','cor','en','label for the batchfileuploader',1,'2012-03-20 10:40:22'),
	(284,'batch_uploadfromfolder','Upload files from a directory on the server','cor','en','label for the batchfileuploader',1,'2012-03-20 10:40:22'),
	(285,'err_modtypefail','Error: the modtype for this record was not successfully changed.','cor','en','Markup displayed when change modtype fails, general message',1,'2012-03-21 12:40:44'),
	(286,'splash','Welcome to the Archaeological Recording Kit (ARK). Please login to begin using ARK','cor','en','Markup for the splash index page',1,'2012-03-23 14:07:02'),
	(287,'batch_instructions_pt1','Files can either be batch uploaded using the remote URL of a folder of files:','cor','en','label for sf_batchfileupload',1,'2012-03-25 06:27:00'),
	(288,'arkname','Metaponto ARK','cor','en','Markup for the index page of this instance of ark',1,'2012-10-17 13:05:58'),
	(289,'noregisterdatayet','No registered data on this module, yet.','cor','en','Label for register',1,'2013-01-30 07:50:21'),
	(290,'updatesucc','Update Successful!','cor','en','message displayed on successful update',1,'2013-10-24 10:16:16'),
	(291,'ste_cd','Code','cor','en','A label for codes',1,'2013-11-27 10:15:16'),
	(292,'mapviewnav','Map','cor','en','Text for map_view navtab ',1,'2013-12-10 07:54:40'),
	(293,'markupnav','markup','cor','en','Markup for markup admin navigation',1,'2014-02-20 08:51:34'),
	(294,'aliasnav','alias','cor','en','Markup for alias admin navigation',1,'2014-02-20 08:57:19'),
	(295,'recsucs','Record Successful','cor','en','message for succesfull changes to db',1,'2014-06-04 17:20:54'),
	(296,'newphoto','Take a Photo','cor','en','upload media button for summary',1,'2014-09-03 09:38:43'),
	(297,'ipadwarning','When prompted choose the \'take photo\' option to us...','cor','en','prompt for upload from ipad tab on media browser',1,'2014-09-03 10:34:17'),
	(298,'addclasstype','Add new Data type','cor','en','prompt for left panel alias admin',1,'2014-09-04 12:17:35'),
	(299,'logout','Switch User','cor','en','For logout navigation in top right.',1,'2014-10-13 16:42:07'),
	(300,'dbimport','Database','cor','en','markup for import left panel',1,'2014-11-20 11:13:42'),
	(301,'jsonimport','JSON/CSV','cor','en','csv option import left panel',1,'2014-11-20 11:15:12'),
	(302,'jsonintromsg','This tool allow you to import data from a text file, the Root of the data is the level at which the objects to be imported repeat, the ark id must be set','cor','en','intro message for file import page',1,'2014-11-20 11:24:07'),
	(303,'currentpath','Current location in data:','cor','en','info text for jsonpage',1,'2014-11-20 11:24:54'),
	(304,'rootpath','Root:','cor','en','info text for jsonpage',1,'2014-11-20 11:25:18'),
	(305,'jsonarkid','ARK ID:','cor','en','info text for jsonpage',1,'2014-11-20 11:25:41'),
	(306,'jsonloading','<img src=\"/metaponto/metsur_ark/skins/arkologik/images/loading.gif\" alt=\"loading.gif\" /><br />LOADING...','cor','en','info text for jsonpage',1,'2014-11-20 11:31:18'),
	(307,'thisisleaf','Not Root','cor','en','info text for jsonpage',1,'2014-11-20 11:48:10'),
	(308,'jsonthisisroot','Make current level root','cor','en','text import button text',1,'2014-11-21 16:02:27'),
	(309,'genjsonimport','Import this','cor','en','text import button text',1,'2014-11-21 16:02:58'),
	(310,'jsonthisisarkid','This is ARK ID','cor','en','text import button text',1,'2014-11-21 16:03:24'),
	(311,'jsonfilter','Filter on this column','cor','en','text import button text',1,'2014-11-21 16:03:46'),
	(312,'jsontoparent','Go Up one level','cor','en','text import button text',1,'2014-11-21 16:04:14'),
	(313,'no_ste_cd','No Site Code (for chains)','cor','en','text import button text',1,'2014-11-21 16:05:13'),
	(314,'regex','Regular Expression','cor','en','text import button text',1,'2014-11-21 16:05:34'),
	(315,'abitraryarkcodes','Start at arbitrary number','cor','en','text import button text',1,'2014-11-21 16:06:27'),
	(316,'abitraryarkcodesstart','Start at','cor','en','abitraryarkcodesstart',1,'2014-11-21 16:06:45'),
	(317,'nothingtoadd','Nothing to Add','cor','en','nothingtoadd message on json upload',1,'2014-11-21 19:04:17'),
	(318,'jsonexplanation','Enter the location of the text file to be imported to ARK (either a url - or a file on this server: try data/uploads/yourfile.csv\n<br />\n.csv and .json files are supported','cor','en','Text for intro to textfile importer',1,'2014-12-18 13:02:58'),
	(319,'itemsfound','items found: ','cor','en','info text for jsonpage',1,'2014-12-18 15:40:02'),
	(320,'first20','(only first 20 displayed)','cor','en','json injestor truncation explaination',1,'2014-12-18 15:40:53'),
	(321,'metaterm','DC: Term','cor','en','markup for metadata syncer',1,'2014-12-19 16:43:09'),
	(322,'arkmetamessage','ARK','cor','en','markup for metadata syncer',1,'2014-12-19 16:43:52'),
	(323,'irodsmetamessage','iRods','cor','en','markup for metadata syncer',1,'2014-12-19 16:45:34'),
	(324,'logintitle','Log in','cor','en','Login text',1,'2015-02-03 12:06:47'),
	(325,'json_remove','Remove','cor','en','text for button to remove set information in json import pages',1,'2015-02-04 18:25:25'),
	(326,'addtocontainer','Pick by Subgroup Number','cor','en','prompt for container add by entering ARK id',1,'2015-02-23 10:45:47'),
	(327,'none','None','cor','en','None',1,'2015-03-19 18:55:18'),
	(328,'themeatiseexplain','Use these button to change how the data is displayed.','cor','en','Explain Themeatise',1,'2015-03-24 11:57:21'),
	(329,'map_add_ark_id','Context Number','cor','en','prompt for cxt number on mapping – needs to be more generic?',1,'2015-04-22 12:49:51'),
	(330,'lock','lock','cor','en','lock (inverse of edit) in sf nav',1,'2015-05-18 17:04:41'),
	(331,'err_formresubmit','form resubmission detected','cor','en','err_formresubmit',1,'2015-05-18 19:51:46'),
	(332,'selectall','Select All','cor','en','selectall button text',1,'2015-05-18 19:59:33'),
	(333,'newabk','Add to address book','abk','en','text for address book toggle on user admin',1,'2015-05-29 13:58:09'),
	(334,'reallydelete','Are you sure you want to delete shape for ','cor','en','map delete interaction confirm dialog',1,'2015-06-02 14:35:16'),
	(335,'arkidnotset','Context number must exist!','cor','en','text on prevention of tool',1,'2015-06-02 14:56:15'),
	(336,'abkregister','Register new ABK record','cor','en','titletext for add ABK button in sf_action',1,'2014-07-15 10:27:00'),
	(337,'addExistingLayer','Existing layer','cor','en','section title for existing layer accordian',1,'2014-07-15 10:27:00'),
	(338,'addnewlayer','Add New Layer','cor','en','Text for link to add layer overlay',1,'2014-07-15 10:27:00'),
	(339,'clear','Clear','cor','en','text for button to clear the working group in grouptool',1,'2014-07-15 10:27:00'),
	(340,'currentlayers','Layers','cor','en','Title for legend in map admin sf',1,'2014-07-15 10:27:00'),
	(341,'dataclassnotsupported','dataclassnotsupported','cor','en','error message',1,'2014-07-15 10:27:00'),
	(342,'duplicate','Ditto','cor','en','duplicate button for sf_addrecord',1,'2014-07-15 10:27:00'),
	(343,'err_feeddesc','Feed Error – No description set','cor','en','',1,'2014-07-15 10:27:00'),
	(344,'err_feeddisp_mode','Feed Error – No display mode set','cor','en','',1,'2014-07-15 10:27:00'),
	(345,'err_feedftr','No Filter Set','cor','en','',1,'2014-07-15 10:27:00'),
	(346,'err_feedlimit','Feed Error - No Limit Set','cor','en','',1,'2014-07-15 10:27:00'),
	(347,'err_feedtitle','Feed Error -No title set','cor','en','',1,'2014-07-15 10:27:00'),
	(348,'err_noconflictres','No form is specified to resolve conflicts this process might generate – please check with your Admin','cor','en','if there is no conflict sf configured this message will be displayed',1,'2014-07-15 10:27:00'),
	(349,'err_nolayers','No Layers','cor','en','tesxt warning when map has no layers',1,'2014-07-15 10:27:00'),
	(350,'err_nosfkey','Subform key not set','cor','en','subform sanity check warning',1,'2014-07-15 10:27:00'),
	(351,'err_nosfval','subform value not set','cor','en','subform sanity check warning',1,'2014-07-15 10:27:00'),
	(352,'err_valchgfail','Update has failed','cor','en','markp displayed if the update fails',1,'2014-07-15 10:27:00'),
	(353,'err_varnotset','Variable not set','cor','en','this has the variable added on the end when it is printed',1,'2014-07-15 10:27:00'),
	(354,'err_varnotvalid','Variable not valid','cor','en','this has the variable added on the end when it is printed',1,'2014-07-15 10:27:00'),
	(355,'false','false','cor','en','\'false\' for boolean switch',1,'2014-07-15 10:27:00'),
	(356,'file_not_accessible','File Not Accessible','cor','en','first stage of import has failed to read file',1,'2014-07-15 10:27:00'),
	(357,'filteradded','Filter Added','cor','en ','',1,'2014-07-15 10:27:00'),
	(358,'filtertxt','Search terms','cor','en','label for search for free text box',1,'2014-07-15 10:27:00'),
	(359,'getcap_err','there appears to be an error with the server url that you have entered','cor','en','text that shows when get capabilities fails for a geospatial server',1,'2014-07-15 10:27:00'),
	(360,'langselector','language','cor','en','label for language dropdown',1,'2014-07-15 10:27:00'),
	(361,'layeredit','Edit Exsiting Layer','cor','en','edit existing layer text for accordian',1,'2014-07-15 10:27:00'),
	(362,'mapsaved','Map Saved!','cor','en','message for success in map admin sf',1,'2014-07-15 10:27:00'),
	(363,'minisrcinst','no key or value sent with this sub form, please check it is configured correctly','cor','en','a helpful hint for the microsearch overlay',1,'2014-07-15 10:27:00'),
	(364,'nohelp','No help available for this term','cor en','','default help text',1,'2014-07-15 10:27:00'),
	(365,'noirodsinfo','iRods connection info not available please contact your administrator','cor','en','error text if irods info is not an array',1,'2014-07-15 10:27:00'),
	(366,'nomaprequested','No map id in request please contact administrator if problem persists','cor','en','no mapid this will not happen if defaults have been set up correctly',1,'2014-07-15 10:27:00'),
	(367,'noplaces','No places attached to this record','cor','en','text displayed when there is no place associated with a record',1,'2014-07-15 10:27:00'),
	(368,'nospat','No spatial data found','cor','en','text for when gen selected gets no result',1,'2014-07-15 10:27:00'),
	(369,'nostecd','No Site Code selected','cor','en','error for batchfileupload',1,'2014-07-15 10:27:00'),
	(370,'problem_rdf_detected','A problem has been detected with the RDF','cor','en','warning for the export function',1,'2014-07-15 10:27:00'),
	(371,'recdelsuc','Delete successful','cor','en','',1,'2014-07-15 10:27:00'),
	(372,'recedtsucs','Edit successful','cor','en','',1,'2014-07-15 10:27:00'),
	(373,'saveas','Save as','cor','en','',1,'2014-07-15 10:27:00'),
	(374,'savemap','Save','cor','en','stext for save button in map admin sf',1,'2014-07-15 10:27:00'),
	(375,'savemapas','Save As','cor en','','prompt the the text box for the new map name',1,'2014-07-15 10:27:00'),
	(376,'serverurl','Map server url','cor','en','label for the server url for adding map',1,'2014-07-15 10:27:00'),
	(377,'srcabk','Search for existing ABK record','cor','en','titletext for search for existing ABK button in sf_action',1,'2014-07-15 10:27:00'),
	(378,'ste','Site Code','cor','en','site code',1,'2014-07-15 10:27:00'),
	(379,'themeatiseexplain','Use these button to change how the data is displayed.','cor','en','explaination for the themeatise sf',1,'2014-07-15 10:27:00'),
	(380,'tlenddate','end','cor','en','end date ',1,'2014-07-15 10:27:00'),
	(381,'traverseto','Traverse to','cor','en','markup for traverse to toggle on data_view',1,'2014-07-15 10:27:00'),
	(382,'true','true','cor','en','\'true\' for boolean switch',1,'2014-07-15 10:27:00'),
	(383,'uploadfailure','Upload has Failed','cor','en','markup for failure in sf_meejabrowser',1,'2014-07-15 10:27:00'),
	(384,'uploadfailureadmin','An admin error has occured','cor','en','markup for an admin error in the mediauplaod javacsript',1,'2014-07-15 10:27:00'),
	(385,'viewbutton','view','cor','en','vext for view button in side panel if not image mode',1,'2014-07-15 10:27:00'),
	(386,'working','Working...','cor','en','text displayed while AJAX is run',1,'2014-07-15 10:27:00');

/*!40000 ALTER TABLE `cor_tbl_markup` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_module
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_module` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shortform` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(3) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_module` WRITE;
/*!40000 ALTER TABLE `cor_tbl_module` DISABLE KEYS */;

INSERT INTO `cor_tbl_module` (`id`, `itemkey`, `name`, `shortform`, `description`, `cre_by`, `cre_on`)
VALUES
	(2,'abk_cd','mod_abk','abk','The Address Book Module',1,'2008-01-16 00:00:00'),
	(1,'cor_cd','mod_cor','cor','A core module for adding markup and aliases',4,'2011-06-23 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_number
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` int(11) NOT NULL DEFAULT '0',
  `typemod` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `itemvalue` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fragtype` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fragid` int(5) NOT NULL DEFAULT '0',
  `number` double NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';

LOCK TABLES `cor_tbl_number` WRITE;
/*!40000 ALTER TABLE `cor_tbl_number` DISABLE KEYS */;

INSERT INTO `cor_tbl_number` (`id`, `numbertype`, `typemod`, `itemkey`, `itemvalue`, `fragtype`, `fragid`, `number`, `cre_by`, `cre_on`)
VALUES
	(1,9,'','cor_tbl_map','1','',0,7,0,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_number` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_sgrp
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_sgrp` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sgrp` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='A table of security groups';

LOCK TABLES `cor_tbl_sgrp` WRITE;
/*!40000 ALTER TABLE `cor_tbl_sgrp` DISABLE KEYS */;

INSERT INTO `cor_tbl_sgrp` (`id`, `sgrp`, `cre_by`, `cre_on`)
VALUES
	(1,'users',1,'2005-11-08 00:00:00'),
	(2,'admins',2,'2005-11-08 00:00:00'),
	(3,'public',1,'0000-00-00 00:00:00'),
	(4,'supervisors',1,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_sgrp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_span
# ------------------------------------------------------------

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



# Dump of table cor_tbl_spanattr
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_spanattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `span` int(10) NOT NULL DEFAULT '0',
  `spanlabel` int(11) NOT NULL DEFAULT '0',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible attributing of text fragments';



# Dump of table cor_tbl_ste
# ------------------------------------------------------------

CREATE TABLE `cor_tbl_ste` (
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table cor_tbl_txt
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table allows extensible text values to be added to cont';

LOCK TABLES `cor_tbl_txt` WRITE;
/*!40000 ALTER TABLE `cor_tbl_txt` DISABLE KEYS */;

INSERT INTO `cor_tbl_txt` (`id`, `txttype`, `itemkey`, `itemvalue`, `txt`, `language`, `cre_by`, `cre_on`)
VALUES
	(1,3,'abk_cd','ARK_1','Jane Doe','en',1,'2014-02-20 18:43:38'),
	(2,4,'abk_cd','ARK_1','JD','en',1,'2014-02-20 18:43:38'),
	(3,134,'cor_tbl_map','1','[-8477.4,6712033.8]','en',127,'2015-07-14 09:58:50');

/*!40000 ALTER TABLE `cor_tbl_txt` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_users
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_users` WRITE;
/*!40000 ALTER TABLE `cor_tbl_users` DISABLE KEYS */;

INSERT INTO `cor_tbl_users` (`id`, `username`, `password`, `firstname`, `lastname`, `initials`, `sfilter`, `email`, `account_enabled`, `cre_by`, `cre_on`)
VALUES
	(1,'doe_jd','a8c0d2a9d332574951a8e4a0af7d516f','Jane','Doe','JD',0,'support@lparchaeology.com',1,0,'0000-00-00 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_wwwpages
# ------------------------------------------------------------

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cor_tbl_wwwpages` WRITE;
/*!40000 ALTER TABLE `cor_tbl_wwwpages` DISABLE KEYS */;

INSERT INTO `cor_tbl_wwwpages` (`id`, `name`, `title`, `sortposs`, `file`, `sgrp`, `navname`, `navlinkvars`, `defaultvars`, `cre_by`, `cre_on`)
VALUES
	(1,'User Home','User Home Page',1,'user_home.php','3','home','?view=home','pownergrp|1,default_view|home,cur_page|user_home,cur_code_dir|php/user_home/',2,'2005-11-08 00:00:00'),
	(2,'Data Entry','Data Entry',3,'data_entry.php','1','data entry','?view=home','pownergrp|1,default_view|home,cur_page|data_entry,cur_code_dir|php/data_entry/',2,'2005-11-08 00:00:00'),
	(3,'User Admin','User Admin',2,'user_admin.php','2','users','?view=home','cur_code_dir|php/user_admin/',2,'2006-05-26 00:00:00'),
	(4,'Data Viewing','Data Viewing',4,'data_view.php','3','search','?view=standard','pownergrp|1,default_view|home,cur_page|data_view,cur_code_dir|php/data_view/',1,'2006-05-31 00:00:00'),
	(7,'micro_view','Micro Viewer',5,'micro_view.php','3','record view','?view=home','default_view|home,cur_page|micro_view,cur_code_dir|php/micro_view/',2,'2006-06-06 00:00:00'),
	(8,'map_view','Map Viewer',6,'map_view.php','3','map view','?view=home','default_view|home,cur_page|map_view,cur_code_dir|php/map_view/',1,'2006-09-11 00:00:00'),
	(9,'import_tools','Import Tools',8,'import.php','2','import','?view=home','default_view|home,cur_page|import_tools,cur_code_dir|php/import/',4,'2007-05-18 00:00:00'),
	(10,'login','Login',7,'index.php','3','login','','',4,'2007-05-18 00:00:00'),
	(11,'alias_admin','Alias Admin',8,'alias_admin.php','2','aliases','?view=home','default_view|home,cur_page|alias_admin,cur_code_dir|php/alias_admin/',4,'2007-05-18 00:00:00'),
	(12,'markup_admin','Markup Admin',8,'markup_admin.php','2','markup','?view=home','default_view|home,cur_page|markup_admin,cur_code_dir|php/markup_admin/',4,'2007-05-18 00:00:00'),
	(13,'overlay_holder','Overlay',10,'overlay_holder.php','3','Overlay','?view=home','default_view|home,cur_page|overlay_holder,cur_code_dir|php/overlay_holder/',1,'2006-06-06 00:00:00'),
	(14,'map_admin','Map Admin',7,'map_admin.php','2','map admin','?view=home','default_view|home,cur_page|map_admin,cur_code_dir|php/map_admin/',4,'2007-05-18 00:00:00');

/*!40000 ALTER TABLE `cor_tbl_wwwpages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cor_tbl_xmi
# ------------------------------------------------------------

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




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
