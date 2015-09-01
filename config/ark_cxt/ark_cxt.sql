-- MySQL dump 10.13  Distrib 5.5.29, for osx10.6 (i386)
--
-- Host: localhost    Database: sgl_cxt1_1
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
-- Table structure for table `cor_lut_actiontype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_actiontype` (
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
INSERT INTO `cor_lut_actiontype` VALUES (1,'issuedto','cor',0,'2005-11-09 00:00:00'),(2,'compiledby','cor',2,'2006-05-07 15:20:21'),(3,'checkedby','cor',2,'2006-05-07 15:35:21'),(4,'directedby','cor',4,'2006-06-06 07:53:00'),(5,'supervisedby','cor',4,'2006-06-06 07:54:00'),(8,'takenby','gph',4,'2006-06-06 00:00:00'),(6,'drawnby','pln',4,'2005-11-18 00:00:00'),(7,'scannedby','pln',4,'2005-11-18 00:00:00'),(9,'interpretedby','cor',0,'0000-00-00 00:00:00'),(10,'notedby','ael',4,'2007-06-15 00:00:00'),(11,'restoredby','ael',4,'2007-06-15 00:00:00'),(12,'registeredby','ael',4,'2007-06-15 00:00:00'),(13,'sgrnarrativeby','sgr',2,'2010-11-30 15:14:37'),(14,'datingnarrativeby','sgr',2,'2010-12-01 15:13:08'),(15,'grpnarrativeby','grp',2,'2011-08-31 19:45:24'),(16,'grpdatingnarrativeby','grp',2,'2011-08-31 19:49:07');
/*!40000 ALTER TABLE `cor_lut_actiontype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_areatype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_areatype` (
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
INSERT INTO `cor_lut_areatype` VALUES (1,'area',2,'2005-11-14 00:00:00'),(2,'subarea',2,'2005-11-14 00:00:00'),(3,'gridsquare',2,'2005-11-14 00:00:00'),(4,'trench',4,'2006-06-08 00:00:00'),(5,'zone',4,'2006-06-08 08:33:26'),(6,'sector',4,'2006-06-08 00:00:00');
/*!40000 ALTER TABLE `cor_lut_areatype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_attribute`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attributetype` int(11) NOT NULL DEFAULT '0',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=375 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_attribute`
--

LOCK TABLES `cor_lut_attribute` WRITE;
/*!40000 ALTER TABLE `cor_lut_attribute` DISABLE KEYS */;
INSERT INTO `cor_lut_attribute` VALUES (1,'datcmp',1,'cor',2,'2006-05-23 00:00:00'),(2,'chkd',1,'cor',2,'0000-00-00 00:00:00'),(3,'not_exc',1,'cor',4,'2006-06-07 00:00:00'),(4,'part_exc',1,'cor',4,'2006-06-07 00:00:00'),(5,'exc',1,'cor',4,'2006-06-07 00:00:00'),(6,'waterlogged',3,'smp',1,'2008-06-13 00:00:00'),(7,'moist',3,'smp',1,'2008-06-13 00:00:00'),(8,'dry',3,'smp',1,'2008-06-13 00:00:00'),(9,'rootaction',4,'smp',1,'2008-06-13 00:00:00'),(10,'mixturewithoverburden',4,'smp',2,'0000-00-00 00:00:00'),(11,'othercontext',4,'smp',2,'0000-00-00 00:00:00'),(12,'modernintrusions',4,'smp',2,'0000-00-00 00:00:00'),(13,'<5%',5,'smp',2,'0000-00-00 00:00:00'),(14,'5-20%',5,'smp',2,'0000-00-00 00:00:00'),(15,'20-40%',5,'smp',2,'0000-00-00 00:00:00'),(16,'40-60%',5,'smp',2,'0000-00-00 00:00:00'),(17,'60-80%',5,'smp',2,'0000-00-00 00:00:00'),(18,'80-100%',5,'smp',2,'0000-00-00 00:00:00'),(35,'glass',2,'cxt',2,'2008-06-24 12:54:19'),(34,'bone',2,'cxt',2,'2008-06-24 00:00:00'),(33,'pot',2,'cxt',2,'2008-06-24 12:54:19'),(32,'nofinds',2,'cxt',2,'2008-06-24 00:00:00'),(26,'radiocarbon',7,'smp',2,'0000-00-00 00:00:00'),(27,'controlsediment',7,'smp',2,'0000-00-00 00:00:00'),(28,'parasites',7,'smp',2,'0000-00-00 00:00:00'),(29,'insects',7,'smp',2,'0000-00-00 00:00:00'),(30,'pollen',7,'smp',2,'0000-00-00 00:00:00'),(31,'diatoms',7,'smp',2,'0000-00-00 00:00:00'),(36,'metal',2,'cxt',2,'2008-06-24 00:00:00'),(37,'cbm',2,'cxt',2,'2008-06-24 12:54:19'),(38,'flint',2,'cxt',2,'2008-06-24 00:00:00'),(39,'wood',2,'cxt',2,'2008-06-24 12:54:19'),(40,'leather',2,'cxt',2,'2008-06-24 00:00:00'),(41,'other',2,'cxt',2,'2008-06-24 12:54:19'),(42,'noconatm',4,'smp',2,'2008-06-26 00:00:00'),(43,'site',8,'smp',1,'2008-06-26 00:00:00'),(44,'cambridge',8,'smp',1,'2008-06-26 00:00:00'),(45,'processed',8,'smp',1,'2008-06-26 00:00:00'),(46,'retained',8,'smp',1,'2008-06-26 00:00:00'),(73,'kubi',13,'smp',4,'0000-00-00 00:00:00'),(72,'ecospec',13,'smp',4,'0000-00-00 00:00:00'),(71,'ecorec',13,'smp',4,'0000-00-00 00:00:00'),(70,'waterlogged',13,'smp',4,'0000-00-00 00:00:00'),(69,'monolith',13,'smp',4,'0000-00-00 00:00:00'),(68,'skeleton',13,'smp',4,'0000-00-00 00:00:00'),(67,'genbulk',13,'smp',4,'0000-00-00 00:00:00'),(54,'low',10,'smp',1,'2008-06-26 00:00:00'),(55,'medium',10,'smp',1,'2008-06-26 00:00:00'),(56,'high',10,'smp',1,'2008-06-26 00:00:00'),(57,'drying',11,'smp',1,'2008-06-26 00:00:00'),(58,'bagged',11,'smp',1,'2008-06-26 00:00:00'),(59,'processed',11,'smp',1,'2008-06-26 00:00:00'),(60,'drying',12,'smp',1,'2008-06-26 00:00:00'),(61,'bagged',12,'smp',1,'2008-06-26 00:00:00'),(62,'processed',12,'smp',1,'2008-06-26 00:00:00'),(66,'cremation',13,'smp',4,'0000-00-00 00:00:00'),(64,'boneextracted',8,'smp',1,'2008-06-26 00:00:00'),(65,'residuesorted',8,'smp',1,'2008-06-26 00:00:00'),(74,'soilchem',13,'smp',4,'0000-00-00 00:00:00'),(75,'snails',13,'smp',4,'0000-00-00 00:00:00'),(76,'pollen',13,'smp',4,'0000-00-00 00:00:00'),(77,'spec',13,'smp',4,'0000-00-00 00:00:00'),(78,'missing',8,'smp',4,'0000-00-00 00:00:00'),(79,'datmissing',8,'smp',4,'0000-00-00 00:00:00'),(80,'void',8,'smp',4,'0000-00-00 00:00:00'),(81,'extern',8,'smp',4,'0000-00-00 00:00:00'),(82,'natural',14,'cxt',1,'2009-11-06 00:00:00'),(83,'modern',14,'cxt',1,'2009-11-10 15:35:34'),(84,'earlypm',14,'cxt',1,'2009-11-10 15:35:34'),(85,'romii',14,'cxt',1,'2009-11-10 15:35:34'),(86,'latepm',14,'cxt',1,'2009-11-10 15:35:34'),(87,'pmsoils',14,'cxt',1,'2009-11-10 15:35:35'),(88,'romani',14,'cxt',1,'2009-11-10 15:35:36'),(89,'prerom',14,'cxt',1,'2009-11-10 15:35:54'),(90,'notproc',8,'smp',4,'0000-00-00 00:00:00'),(91,'lghfrac_rec',15,'smp',2,'2009-11-06 00:00:00'),(92,'hfass',15,'smp',2,'2009-11-06 00:00:00'),(93,'cambridge',16,'smp',2,'2009-12-02 00:00:00'),(94,'externalspec',16,'smp',2,'2009-12-02 00:00:00'),(95,'noflotlocn',16,'smp',2,'2009-12-02 00:00:00'),(96,'charcoal',17,'smp',2,'2009-12-02 00:00:00'),(97,'hrboneinhum',17,'smp',2,'2009-12-02 00:00:00'),(98,'hrbonecrem2to4',17,'smp',2,'2009-12-02 00:00:00'),(99,'hrbonecremgt4',17,'smp',2,'2009-12-02 00:00:00'),(100,'plantrems',7,'smp',2,'2009-12-02 00:00:00'),(101,'burial',18,'sgr',2,'2009-12-08 00:00:00'),(102,'cremation',18,'sgr',2,'2009-12-08 00:00:00'),(103,'posscrem',18,'sgr',2,'2009-12-02 00:00:00'),(104,'pit',18,'sgr',2,'2009-12-09 00:00:00'),(105,'lead',19,'',2,'2010-10-22 16:19:00'),(106,'copper',19,'',2,'2010-10-22 16:19:00'),(107,'iron',19,'',2,'2010-10-22 16:19:00'),(108,'ceramic',19,'',2,'2010-10-22 16:19:00'),(109,'stone',19,'',2,'2010-10-22 16:19:00'),(110,'ivory',19,'',2,'2010-10-22 16:19:00'),(111,'fibre',19,'',2,'2010-10-22 16:19:00'),(112,'samp',19,'',2,'2010-10-22 16:19:00'),(113,'rivet',20,'',2,'2010-10-22 16:19:00'),(114,'waste',20,'',2,'2010-10-22 16:19:00'),(115,'coin',20,'',2,'2010-10-22 16:19:00'),(116,'vessel',20,'',2,'2010-10-22 16:19:00'),(117,'shoe',20,'',2,'2010-10-22 16:19:00'),(118,'spindle',20,'',2,'2010-10-22 16:19:00'),(119,'stud',20,'',2,'2010-10-22 16:19:00'),(120,'slag',20,'',2,'2010-10-22 16:19:00'),(121,'buck',20,'',2,'2010-10-22 16:19:00'),(122,'staple',20,'',2,'2010-10-22 16:19:00'),(123,'knife',20,'',2,'2010-10-22 16:19:00'),(124,'mount',20,'',2,'2010-10-22 16:19:00'),(125,'handle',20,'',2,'2010-10-22 16:19:00'),(126,'ring',20,'',2,'2010-10-22 16:19:00'),(127,'strap',20,'',2,'2010-10-22 16:19:00'),(128,'wire',20,'',2,'2010-10-22 16:19:00'),(129,'key',20,'',2,'2010-10-22 16:19:00'),(130,'nail',20,'',2,'2010-10-22 16:19:00'),(131,'chis',20,'',2,'2010-10-22 16:19:00'),(132,'hosh',20,'',2,'2010-10-22 16:19:00'),(133,'hinge',20,'',2,'2010-10-22 16:19:00'),(134,'bracket',20,'',2,'2010-10-22 16:19:00'),(135,'bead',20,'',2,'2010-10-22 16:19:00'),(136,'barr',20,'',2,'2010-10-22 16:19:00'),(137,'chap',20,'',2,'2010-10-22 16:19:00'),(138,'pin',20,'',2,'2010-10-22 16:19:00'),(139,'butt',20,'',2,'2010-10-22 16:19:00'),(140,'patc',20,'',2,'2010-10-22 16:19:00'),(141,'bottle',20,'',2,'2010-10-22 16:19:00'),(142,'cup',20,'',2,'2010-10-22 16:19:00'),(143,'window',20,'',2,'2010-10-22 16:19:00'),(144,'jar',20,'',2,'2010-10-22 16:19:00'),(145,'tessera',20,'',2,'2010-10-22 16:19:00'),(146,'beaker',20,'',2,'2010-10-22 16:19:00'),(147,'phial',20,'',2,'2010-10-22 16:19:00'),(148,'tumb',20,'',2,'2010-10-22 16:19:00'),(149,'hone',20,'',2,'2010-10-22 16:19:00'),(150,'pinb',20,'',2,'2010-10-22 16:19:00'),(151,'comb',20,'',2,'2010-10-22 16:19:00'),(152,'awl',20,'',2,'2010-10-22 16:19:00'),(153,'pipe',20,'',2,'2010-10-22 16:19:00'),(154,'wigc',20,'',2,'2010-10-22 16:19:00'),(155,'sam',20,'',2,'2010-10-22 16:19:00'),(156,'lamp',20,'',2,'2010-10-22 16:19:00'),(157,'walt',20,'',2,'2010-10-22 16:19:00'),(158,'flor',20,'',2,'2010-10-22 16:19:00'),(159,'blot',20,'',2,'2010-10-22 16:19:00'),(160,'bowl',20,'',2,'2010-10-22 16:19:00'),(161,'brush',20,'',2,'2010-10-22 16:19:00'),(162,'plug',20,'',2,'2010-10-22 16:19:00'),(163,'badg',20,'',2,'2010-10-22 16:19:00'),(164,'stpe',20,'',2,'2010-10-22 16:19:00'),(165,'drhk',20,'',2,'2010-10-22 16:19:00'),(166,'weig',20,'',2,'2010-10-22 16:19:00'),(167,'clos',20,'',2,'2010-10-22 16:19:00'),(168,'came',20,'',2,'2010-10-22 16:19:00'),(169,'shot',20,'',2,'2010-10-22 16:19:00'),(170,'flask',20,'',2,'2010-10-22 16:19:00'),(171,'ferr',20,'',2,'2010-10-22 16:19:00'),(172,'rove',20,'',2,'2010-10-22 16:19:00'),(173,'padl',20,'',2,'2010-10-22 16:19:00'),(174,'jug',20,'',2,'2010-10-22 16:19:00'),(175,'coun',20,'',2,'2010-10-22 16:19:00'),(176,'alle',20,'',2,'2010-10-22 16:19:00'),(177,'toot',20,'',2,'2010-10-22 16:19:00'),(178,'spoo',20,'',2,'2010-10-22 16:19:00'),(179,'gufl',20,'',2,'2010-10-22 16:19:00'),(180,'figu',20,'',2,'2010-10-22 16:19:00'),(181,'lock',20,'',2,'2010-10-22 16:19:00'),(182,'sbox',20,'',2,'2010-10-22 16:19:00'),(183,'brak',20,'',2,'2010-10-22 16:19:00'),(184,'broo',20,'',2,'2010-10-22 16:19:00'),(185,'chat',20,'',2,'2010-10-22 16:19:00'),(186,'quern',20,'',2,'2010-10-22 16:19:00'),(187,'tile',20,'',2,'2010-10-22 16:19:00'),(188,'stft',20,'',2,'2010-10-22 16:19:00'),(189,'ladl',20,'',2,'2010-10-22 16:19:00'),(190,'cloth',20,'',2,'2010-10-22 16:19:00'),(191,'patt',20,'',2,'2010-10-22 16:19:00'),(192,'cruc',20,'',2,'2010-10-22 16:19:00'),(193,'morm',20,'',2,'2010-10-22 16:19:00'),(194,'inly',20,'',2,'2010-10-22 16:19:00'),(195,'roman',21,'',2,'2010-10-22 16:19:00'),(196,'postmed',21,'',2,'2010-10-22 16:19:00'),(197,'ph',21,'',2,'2010-10-22 16:19:00'),(198,'medieval',21,'',2,'2010-10-22 16:19:00'),(199,'bone',19,'rgf',2,'2008-06-24 00:00:00'),(200,'glass',19,'rgf',2,'2008-06-24 00:00:00'),(201,'flint',19,'rgf',2,'2008-06-24 00:00:00'),(202,'wood',19,'rgf',2,'2008-06-24 00:00:00'),(203,'leather',19,'rgf',2,'2008-06-24 00:00:00'),(204,'zzz',20,'',2,'2010-10-22 16:19:00'),(205,'whole',22,'',2,'2010-10-22 16:19:00'),(206,'half',22,'',2,'2010-10-22 16:19:00'),(207,'displayable',23,'',2,'2010-10-22 16:19:00'),(208,'palaeochannel',18,'cor',71,'2010-11-30 17:00:09'),(209,'reccomplete',1,'cxt',4,'0000-00-00 00:00:00'),(210,'ddebris',24,'cxt',4,'2008-10-08 00:00:00'),(211,'ditch',24,'cxt',4,'2008-10-08 00:00:00'),(212,'cremation',24,'cxt',4,'0000-00-00 00:00:00'),(213,'cellar',24,'cxt',4,'0000-00-00 00:00:00'),(214,'consdebris',24,'cxt',4,'0000-00-00 00:00:00'),(215,'coffin',24,'cxt',4,'0000-00-00 00:00:00'),(216,'ddebris2',24,'cxt',4,'2008-10-08 00:00:00'),(217,'exbank',24,'cxt',4,'2008-10-08 00:00:00'),(218,'excult',24,'cxt',4,'2008-10-08 00:00:00'),(219,'exdump',24,'cxt',4,'2008-10-08 00:00:00'),(220,'exmetal',24,'cxt',4,'2008-10-08 00:00:00'),(221,'exocc',24,'cxt',4,'2008-10-08 00:00:00'),(222,'pasture',24,'cxt',4,'2008-10-08 00:00:00'),(223,'exrevet',24,'cxt',4,'2008-10-08 00:00:00'),(224,'exsur',24,'cxt',4,'2008-10-08 00:00:00'),(225,'external',24,'cxt',4,'2008-10-08 00:00:00'),(226,'furnace',24,'cxt',4,'2008-10-08 00:00:00'),(227,'floor',24,'cxt',4,'2008-10-08 00:00:00'),(228,'gravecut',24,'cxt',4,'2008-10-08 00:00:00'),(229,'grave',24,'cxt',4,'2008-10-08 00:00:00'),(230,'hearth',24,'cxt',4,'2008-10-08 00:00:00'),(231,'mechanical',24,'cxt',4,'2008-10-08 00:00:00'),(232,'makeup',24,'cxt',4,'2008-10-08 00:00:00'),(233,'natural',24,'cxt',4,'2008-10-08 00:00:00'),(234,'natwind',24,'cxt',4,'2008-10-08 00:00:00'),(235,'natchannel',24,'cxt',4,'2008-10-08 00:00:00'),(236,'naterosion',24,'cxt',4,'2008-10-08 00:00:00'),(237,'natforeshore',24,'cxt',4,'2008-10-08 00:00:00'),(238,'natmarsh',24,'cxt',4,'2008-10-08 00:00:00'),(239,'natoverbank',24,'cxt',4,'2008-10-08 00:00:00'),(240,'natsoil',24,'cxt',4,'2008-10-08 00:00:00'),(241,'occdebris',24,'cxt',4,'2008-10-08 00:00:00'),(242,'pit',24,'cxt',4,'2008-10-08 00:00:00'),(243,'pitcess',24,'cxt',4,'2008-10-08 00:00:00'),(244,'pitcooking',24,'cxt',4,'2008-10-08 00:00:00'),(245,'pitossuary',24,'cxt',4,'2008-10-08 00:00:00'),(246,'pitquarry',24,'cxt',4,'2008-10-08 00:00:00'),(247,'pitrefuse',24,'cxt',4,'2008-10-08 00:00:00'),(248,'posstruct',24,'cxt',4,'2008-10-08 00:00:00'),(249,'pitstorage',24,'cxt',4,'2008-10-08 00:00:00'),(250,'roofceil',24,'cxt',4,'2008-10-08 00:00:00'),(251,'structcut',24,'cxt',4,'2008-10-08 00:00:00'),(252,'surerosion',24,'cxt',4,'2008-10-08 00:00:00'),(253,'skeleton',24,'cxt',4,'2008-10-08 00:00:00'),(254,'nonstructcut',24,'cxt',4,'2008-10-08 00:00:00'),(255,'structopening',24,'cxt',4,'2008-10-08 00:00:00'),(256,'posthole',24,'cxt',4,'2008-10-08 00:00:00'),(257,'structtimb',24,'cxt',4,'2008-10-08 00:00:00'),(258,'sump',24,'cxt',4,'2008-10-08 00:00:00'),(259,'tree',24,'cxt',4,'2008-10-08 00:00:00'),(260,'timber',24,'cxt',4,'2008-10-08 00:00:00'),(261,'well',24,'cxt',4,'2008-10-08 00:00:00'),(262,'wall',24,'cxt',4,'2008-10-08 00:00:00'),(263,'workedstone',24,'cxt',4,'2008-10-08 00:00:00'),(264,'unknown',24,'cxt',4,'2008-10-08 00:00:00'),(265,'soakaway',18,'cor',71,'2011-01-13 18:26:55'),(266,'layer',18,'cor',71,'2011-01-18 14:14:50'),(267,'masonry',18,'cor',71,'2011-01-31 11:59:12'),(268,'linear',18,'cor',71,'2011-01-31 12:00:20'),(269,'drain',18,'cor',71,'2011-02-02 15:20:03'),(270,'posthole_1',18,'cor',71,'2011-02-14 12:07:17'),(271,'fragment',22,'cor',2,'2011-11-24 14:31:47'),(272,'preromanxxad50',26,'cor',2,'2011-12-08 12:00:11'),(273,'romaniad50ad120',26,'cor',2,'2011-12-08 12:03:00'),(274,'romaniiad120ad160',26,'cor',2,'2011-12-08 12:03:40'),(275,'romaniiiad160ad250',26,'cor',2,'2011-12-08 12:05:57'),(276,'romanivad250ad400',26,'cor',2,'2011-12-08 12:06:28'),(277,'medievalad400ad1480',26,'cor',2,'2011-12-08 12:08:51'),(278,'postmedievalad1480ad1600',26,'cor',2,'2011-12-08 12:09:52'),(279,'postmedievaliiad1600ad1690',26,'cor',2,'2011-12-08 12:10:37'),(280,'postmedievaliiiad1690ad1800',26,'cor',2,'2011-12-08 12:11:15'),(281,'postmedievalivad1800ad1901',26,'cor',2,'2011-12-08 12:11:59'),(288,'cud',28,'',91,'2014-02-07 17:37:44'),(289,'d',28,'',91,'2014-02-07 17:37:44'),(290,'c',28,'',91,'2014-02-07 17:37:44'),(291,'cu',28,'',91,'2014-02-07 17:37:44'),(292,'ud',28,'',91,'2014-02-07 17:37:44'),(293,'u',28,'',91,'2014-02-07 17:37:44'),(294,'cd',28,'',91,'2014-02-07 17:37:44'),(295,'ec',18,'',91,'2014-02-07 17:40:05'),(296,'p',18,'',91,'2014-02-07 17:40:05'),(297,'th',18,'',91,'2014-02-07 17:40:05'),(298,'wa',18,'',91,'2014-02-07 17:40:05'),(299,'pq',18,'',91,'2014-02-07 17:40:05'),(300,'n',18,'',91,'2014-02-07 17:40:05'),(301,'ds',18,'',91,'2014-02-07 17:40:05'),(302,'oc',18,'',91,'2014-02-07 17:40:05'),(303,'xx',18,'',91,'2014-02-07 17:40:05'),(304,'db',18,'',91,'2014-02-07 17:40:06'),(305,'eo',18,'',91,'2014-02-07 17:40:06'),(306,'em',18,'',91,'2014-02-07 17:40:06'),(307,'sn',18,'',91,'2014-02-07 17:40:06'),(308,'mu',18,'',91,'2014-02-07 17:40:06'),(309,'he',18,'',91,'2014-02-07 17:40:06'),(310,'es',18,'',91,'2014-02-07 17:40:06'),(311,'ed',18,'',91,'2014-02-07 17:40:06'),(312,'s',18,'',91,'2014-02-07 17:40:06'),(313,'so',18,'',91,'2014-02-07 17:40:06'),(314,'fl',18,'',91,'2014-02-07 17:40:06'),(315,'eb',18,'',91,'2014-02-07 17:40:06'),(316,'d',18,'',91,'2014-02-07 17:40:06'),(317,'g',18,'',91,'2014-02-07 17:40:06'),(318,'sk',18,'',91,'2014-02-07 17:40:06'),(319,'ps',18,'',91,'2014-02-07 17:40:06'),(320,'sp',18,'',91,'2014-02-07 17:40:06'),(321,'pr',18,'',91,'2014-02-07 17:40:06'),(322,'ec',27,'',91,'2014-02-12 16:19:25'),(323,'p',27,'',91,'2014-02-12 16:19:26'),(324,'th',27,'',91,'2014-02-12 16:19:26'),(325,'wa',27,'',91,'2014-02-12 16:19:26'),(326,'pq',27,'',91,'2014-02-12 16:19:26'),(327,'n',27,'',91,'2014-02-12 16:19:26'),(328,'ds',27,'',91,'2014-02-12 16:19:26'),(329,'oc',27,'',91,'2014-02-12 16:19:26'),(330,'xx',27,'',91,'2014-02-12 16:19:26'),(331,'db',27,'',91,'2014-02-12 16:19:26'),(332,'eo',27,'',91,'2014-02-12 16:19:26'),(333,'em',27,'',91,'2014-02-12 16:19:26'),(334,'sn',27,'',91,'2014-02-12 16:19:26'),(335,'mu',27,'',91,'2014-02-12 16:19:26'),(336,'he',27,'',91,'2014-02-12 16:19:26'),(337,'es',27,'',91,'2014-02-12 16:19:26'),(338,'ed',27,'',91,'2014-02-12 16:19:26'),(339,'s',27,'',91,'2014-02-12 16:19:26'),(340,'so',27,'',91,'2014-02-12 16:19:26'),(341,'fl',27,'',91,'2014-02-12 16:19:26'),(342,'eb',27,'',91,'2014-02-12 16:19:26'),(343,'d',27,'',91,'2014-02-12 16:19:26'),(344,'g',27,'',91,'2014-02-12 16:19:26'),(345,'sk',27,'',91,'2014-02-12 16:19:26'),(346,'ps',27,'',91,'2014-02-12 16:19:26'),(347,'sp',27,'',91,'2014-02-12 16:19:26'),(348,'pr',27,'',91,'2014-02-12 16:19:26'),(349,'anbo',2,'',91,'2014-02-13 18:38:19'),(350,'ctp',2,'',91,'2014-02-13 18:38:19'),(351,'fe',2,'',91,'2014-02-13 18:38:19'),(352,'skel',2,'',91,'2014-02-13 18:38:19'),(353,'daub',2,'',91,'2014-02-13 18:38:19'),(354,'cu',2,'',91,'2014-02-13 18:38:19'),(355,'stone',2,'',91,'2014-02-13 18:47:24'),(356,'worked_bone',2,'',91,'2014-02-13 18:47:24'),(357,'shell',2,'',91,'2014-02-13 18:47:24'),(358,'pb',2,'',91,'2014-02-13 18:47:24'),(359,'slag',2,'',91,'2014-02-13 18:47:24'),(360,'humanbone',2,'',91,'2014-02-13 18:47:24'),(361,'mod',29,'',91,'2014-02-19 13:27:16'),(362,'m1',29,'',91,'2014-02-19 13:27:17'),(363,'m3',29,'',91,'2014-02-19 13:27:17'),(364,'pm1',29,'',91,'2014-02-19 13:27:17'),(365,'m5',29,'',91,'2014-02-19 13:27:17'),(366,'m4',29,'',91,'2014-02-19 13:27:17'),(367,'m2',29,'',91,'2014-02-19 13:27:17'),(368,'pm2',29,'',91,'2014-02-19 13:27:17'),(369,'sn',29,'',91,'2014-02-19 13:27:17'),(370,'ia',29,'',91,'2014-02-19 13:27:17'),(371,'mia',29,'',91,'2014-02-19 13:27:17'),(372,'rb??',29,'',91,'2014-02-19 13:27:18'),(373,'lsax',29,'',91,'2014-02-19 13:27:18'),(374,'rb',29,'',91,'2014-02-19 13:27:18');
/*!40000 ALTER TABLE `cor_lut_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_attributetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_attributetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attributetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_attributetype`
--

LOCK TABLES `cor_lut_attributetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_attributetype` DISABLE KEYS */;
INSERT INTO `cor_lut_attributetype` VALUES (1,'recflag','cor',2,'2006-05-23 00:00:00'),(2,'findtype','cxt',1,'0000-00-00 00:00:00'),(3,'samplecondition','smp',75,'2008-06-13 08:07:14'),(4,'contamination','smp',75,'2008-06-13 09:47:11'),(5,'samplesize','smp',75,'2008-06-13 10:09:14'),(7,'subsamples','smp',78,'2008-06-13 14:46:42'),(8,'samplestatus','smp',78,'2008-06-13 14:46:42'),(13,'sampletype','smp',4,'0000-00-00 00:00:00'),(10,'priority','smp',78,'2008-06-13 14:46:42'),(11,'hfstatus','smp',78,'2008-06-13 14:46:42'),(12,'lfstatus','smp',78,'2008-06-13 14:46:42'),(14,'provperiod','cxt',1,'2009-11-06 00:00:00'),(15,'smpflag','smp',2,'2009-11-06 00:00:00'),(16,'lflocn','smp',2,'2009-12-02 00:00:00'),(17,'hfextrac','smp',2,'2009-12-02 00:00:00'),(18,'basicinterp','sgr',2,'2009-12-08 00:00:00'),(19,'objectmaterial','rgf',2,'2010-10-22 16:39:41'),(20,'objectinterptype','rgf',2,'2010-10-22 16:40:41'),(21,'objectperiod','rgf',2,'2010-10-22 16:54:38'),(22,'objectcompleteness','rgf',2,'2010-10-22 17:08:16'),(23,'objectdisplay','rgf',2,'2010-10-22 17:08:48'),(27,'cxtbasicinterp','cxt',4,'2010-12-09 00:00:00'),(29,'spotdate','cxt',123,'2014-02-19 13:14:03'),(26,'grpphase','grp',2,'2011-12-08 11:58:23'),(28,'process','cxt',0,'2013-12-20 00:00:00');
/*!40000 ALTER TABLE `cor_lut_attributetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_datetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_datetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_datetype`
--

LOCK TABLES `cor_lut_datetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_datetype` DISABLE KEYS */;
INSERT INTO `cor_lut_datetype` VALUES (1,'issuedon','cor',0,'2005-11-09 00:00:00'),(2,'compiledon','cor',2,'2006-05-07 15:55:21'),(3,'excavatedon','cor',4,'2006-06-06 07:52:30'),(4,'takenon','gph',4,'2006-06-06 00:00:00'),(5,'drawnon','pln',2,'2005-11-21 00:00:00'),(6,'interpretedon','cor',0,'0000-00-00 00:00:00'),(8,'registeredon','ael',4,'2007-06-15 00:00:00'),(9,'sgrnarrativeon','sgr',2,'2010-11-30 15:15:00'),(10,'datingnarrativeon','sgr',2,'2010-12-01 15:12:37'),(11,'grpnarrativeon','grp',2,'2011-08-31 19:46:16'),(12,'grpdatingnarrativeon','grp',2,'2011-08-31 19:49:35');
/*!40000 ALTER TABLE `cor_lut_datetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_filetype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_filetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filetype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_filetype`
--

LOCK TABLES `cor_lut_filetype` WRITE;
/*!40000 ALTER TABLE `cor_lut_filetype` DISABLE KEYS */;
INSERT INTO `cor_lut_filetype` VALUES (1,'images','',1,'2011-02-03 13:47:41'),(2,'cxtsheet','',123,'2013-12-20 00:00:00'),(3,'section','sec',91,'2014-02-21 12:00:41');
/*!40000 ALTER TABLE `cor_lut_filetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_numbertype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_numbertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numbertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `module` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `qualifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_lut_numbertype`
--

LOCK TABLES `cor_lut_numbertype` WRITE;
/*!40000 ALTER TABLE `cor_lut_numbertype` DISABLE KEYS */;
INSERT INTO `cor_lut_numbertype` VALUES (1,'rims','','unit',2,'2006-06-09 00:00:00'),(2,'handles','','unit',2,'2006-06-09 00:00:00'),(3,'bases','','unit',4,'2006-06-10 00:00:00'),(4,'walls','','unit',4,'2006-06-10 00:00:00'),(5,'total','','unit',4,'2006-06-10 00:00:00'),(6,'volume','smp','',75,'2008-06-13 10:04:33'),(7,'hf_numofbags','smp','',75,'2008-06-13 10:04:33'),(8,'lf_numofbags','smp','',75,'2008-06-13 10:04:33');
/*!40000 ALTER TABLE `cor_lut_numbertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_spanlabel`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_spanlabel` (
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
INSERT INTO `cor_lut_spanlabel` VALUES (1,1,'cor','cut',2,'2006-05-11 00:00:00'),(2,1,'cor','cover',2,'2006-05-11 00:00:00'),(3,1,'cor','abutt',2,'2006-05-11 00:00:00'),(4,1,'cor','fill',1,'2006-05-12 00:00:00');
/*!40000 ALTER TABLE `cor_lut_spanlabel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_spantype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_spantype` (
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
INSERT INTO `cor_lut_spantype` VALUES (1,'tvector','','',2,'2006-05-10 00:00:00',''),(2,'sameas','','',2,'2006-05-10 00:00:00',''),(3,'relatedto','','',4,'2006-06-06 00:00:00',''),(4,'reuse_this_type','','',2,'0000-00-00 00:00:00',''),(5,'shrgeom','','',91,'2014-02-12 17:36:54','cxt'),(6,'sgr_matrix','','',123,'2014-02-19 13:56:39','sgr');
/*!40000 ALTER TABLE `cor_lut_spantype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_lut_txttype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_lut_txttype` (
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
INSERT INTO `cor_lut_txttype` VALUES (11,'interp','cor',2,'2005-11-15 00:00:00'),(10,'short_desc','cor',2,'2005-11-21 00:00:00'),(9,'compac','cxt',2,'2005-11-14 00:00:00'),(5,'colour','cxt',2,'2005-11-14 00:00:00'),(6,'compo','cxt',2,'2005-11-14 00:00:00'),(8,'dims','cxt',2,'2005-11-18 00:00:00'),(17,'orient','cxt',2,'2005-11-18 00:00:00'),(28,'definition','cxt',4,'2006-06-06 08:08:00'),(34,'desc','cxt',4,'2006-06-06 00:00:00'),(35,'observ','cxt',4,'2006-06-06 00:00:00'),(36,'excavtech','cxt',4,'2006-06-06 00:00:00'),(85,'bond','cxt',4,'2008-03-05 00:00:00'),(84,'sizemat','cxt',4,'2008-03-05 00:00:00'),(40,'finish','cxt',4,'2006-06-06 00:00:00'),(83,'truncation','cxt',4,'2008-03-05 00:00:00'),(82,'inclination','cxt',4,'2008-03-05 00:00:00'),(81,'base','cxt',4,'2008-03-05 00:00:00'),(80,'bosbase','cxt',4,'2008-03-05 00:00:00'),(79,'sides','cxt',4,'2008-03-05 00:00:00'),(78,'bostop','cxt',4,'2008-03-05 00:00:00'),(57,'inclusions','cxt',4,'2006-06-07 00:00:00'),(76,'shape','cxt',4,'2008-03-05 00:00:00'),(77,'corners','cxt',4,'2008-03-05 00:00:00'),(67,'name','abk',4,'2007-05-15 00:00:00'),(68,'initials','abk',4,'2007-05-17 00:00:00'),(70,'material','cxt',4,'2007-06-15 00:00:00'),(88,'bondmat','cxt',4,'2008-03-05 00:00:00'),(86,'form','cxt',4,'2008-03-05 00:00:00'),(87,'dirface','cxt',4,'2008-03-05 00:00:00'),(89,'smpques','smp',2,'2008-06-16 12:17:25'),(90,'abody','cxt',4,'2008-06-18 00:00:00'),(91,'ahead','cxt',4,'2008-06-18 00:00:00'),(92,'ararm','cxt',4,'2008-06-18 00:00:00'),(93,'alarm','cxt',4,'2008-06-18 00:00:00'),(94,'arleg','cxt',4,'2008-06-18 00:00:00'),(95,'alleg','cxt',4,'2008-06-18 00:00:00'),(96,'afeet','cxt',4,'2008-06-18 00:00:00'),(97,'degen','cxt',4,'2008-06-18 00:00:00'),(98,'state','cxt',4,'2008-06-18 00:00:00'),(99,'smp_cxt_desc','smp',2,'2008-06-25 00:00:00'),(100,'contam_desc','smp',2,'2008-06-25 00:00:00'),(101,'type','cxt',4,'2008-06-25 00:00:00'),(102,'setting','cxt',4,'2008-06-25 00:00:00'),(103,'cross','cxt',4,'2008-06-25 00:00:00'),(104,'cond','cxt',4,'2008-06-25 00:00:00'),(105,'conv','cxt',4,'2008-06-25 00:00:00'),(106,'tmarks','cxt',4,'2008-06-25 00:00:00'),(107,'jfit','cxt',4,'2008-06-25 00:00:00'),(108,'imarks','cxt',4,'2008-06-25 00:00:00'),(109,'streat','cxt',4,'2008-06-25 00:00:00'),(110,'direction','sph',2,'2008-06-25 00:00:00'),(111,'scale','sph',2,'2008-06-24 12:54:19'),(112,'statusnotes','smp',2,'2008-06-24 12:54:19'),(113,'typenotes','smp',2,'2008-06-24 12:54:19'),(114,'xrayid','rgf',2,'2010-10-22 16:43:04'),(115,'objectcomments','rgf',2,'2010-10-22 16:48:26'),(116,'sgrnarrative','sgr',2,'2010-11-30 15:14:10'),(117,'plancxt','sgr',2,'0000-00-00 00:00:00'),(118,'datingnarrative','sgr',2,'2010-12-01 15:12:13'),(119,'grpnarrative','grp',2,'2011-08-31 19:43:42'),(120,'grpdatingnarrative','grp',2,'2011-08-31 19:47:37');
/*!40000 ALTER TABLE `cor_lut_txttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_alias`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_tbl_alias` (
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
) ENGINE=MyISAM AUTO_INCREMENT=524 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_alias`
--

LOCK TABLES `cor_tbl_alias` WRITE;
/*!40000 ALTER TABLE `cor_tbl_alias` DISABLE KEYS */;
INSERT INTO `cor_tbl_alias` (alias, aliastype, language,itemkey,itemvalue,cre_by,cre_on) VALUES ('Context',1,'en','cor_tbl_module','10',91,'2013-11-28 16:57:57'),
('Section',1,'en','cor_tbl_module','12',91,'2013-11-28 17:03:27'),
('Site Photo',1,'en','cor_tbl_module','3',91,'2013-11-28 17:03:27'),
('Plan',1,'en','cor_tbl_module','4',91,'2013-11-28 17:03:27'),
('Address Book',1,'en','cor_tbl_module','5',91,'2013-11-28 17:03:27'),
('Sample',1,'en','cor_tbl_module','6',91,'2013-11-28 17:03:27'),
('Special Find',1,'en','cor_tbl_module','7',91,'2013-11-28 17:03:27'),
('Sub Group',1,'en','cor_tbl_module','8',91,'2013-11-28 17:03:27'),
('Registered Find',1,'en','cor_tbl_module','9',91,'2013-11-28 17:03:27'),
('Core',1,'en','cor_tbl_module','1',91,'2013-11-28 17:03:27'),
('Groups',1,'en','cor_tbl_module','11',91,'2013-11-28 17:03:27'),
('Users',1,'en','cor_tbl_sgrp','1',91,'2013-11-28 17:05:32'),
('Admins',1,'en','cor_tbl_sgrp','2',91,'2013-11-28 17:05:32'),
('Cut',1,'en','cxt_lut_cxttype','1',91,'2013-11-29 12:18:15'),
('Fill',1,'en','cxt_lut_cxttype','2',91,'2013-11-29 12:18:15'),
('Masonry',1,'en','cxt_lut_cxttype','3',91,'2013-11-29 12:18:15'),
('Skeleton',1,'en','cxt_lut_cxttype','4',91,'2013-11-29 12:18:15'),
('Timber',1,'en','cxt_lut_cxttype','5',91,'2013-11-29 12:18:15'),
('Void',1,'en','cxt_lut_cxttype','7',91,'2013-11-29 12:18:15'),
('Created By',1,'en','cor_tbl_col','1',91,'2013-11-29 13:36:43'),
('Created On',1,'en','cor_tbl_col','2',91,'2013-11-29 13:36:43'),
('Context Code',1,'en','cor_tbl_col','3',91,'2013-11-29 13:36:43'),
('Type',1,'en','cor_tbl_col','4',91,'2013-11-29 13:36:43'),
('type',1,'en','cor_tbl_col','5',91,'2013-11-29 13:36:43'),
('Type',1,'en','cor_tbl_col','6',91,'2013-11-29 13:36:43'),
('Issued to',1,'en','cor_lut_actiontype','1',1,'2006-12-06 11:00:25'),
('Compiled by',1,'en','cor_lut_actiontype','2',1,'2006-12-06 11:00:25'),
('Checked by',1,'en','cor_lut_actiontype','3',1,'2006-12-06 11:00:25'),
('Director',1,'en','cor_lut_actiontype','4',1,'2006-12-06 11:00:25'),
('Supervisor',1,'en','cor_lut_actiontype','5',1,'2006-12-06 11:00:25'),
('Taken By',1,'en','cor_lut_actiontype','8',1,'2006-12-06 11:00:25'),
('Drawn By',1,'en','cor_lut_actiontype','6',1,'2006-12-06 11:00:25'),
('Scanned By',1,'en','cor_lut_actiontype','7',1,'2006-12-06 11:00:25'),
('Interpreted by',1,'en','cor_lut_actiontype','9',1,'2006-12-06 11:00:25'),
('Sub Area',1,'en','cor_lut_areatype','2',1,'2006-12-06 11:02:41'),
('Grid Square',1,'en','cor_lut_areatype','3',1,'2006-12-06 11:02:41'),
('Trench',1,'en','cor_lut_areatype','4',1,'2006-12-06 11:02:41'),
('Record Status Flag',1,'en','cor_lut_attributetype','1',1,'2006-12-06 11:07:22'),
('Findtype',1,'en','cor_lut_attributetype','2',1,'2006-12-06 11:07:22'),
('Issued on',1,'en','cor_lut_datetype','1',1,'2006-12-06 11:08:58'),
('Compiled on',1,'en','cor_lut_datetype','2',1,'2006-12-06 11:08:58'),
('Date of Excavation',1,'en','cor_lut_datetype','3',1,'2006-12-06 11:08:58'),
('Taken On',1,'en','cor_lut_datetype','4',1,'2006-12-06 11:08:58'),
('Drawn On',1,'en','cor_lut_datetype','5',1,'2006-12-06 11:08:58'),
('Interpreted on',1,'en','cor_lut_datetype','6',1,'2006-12-06 11:08:58'),
('OGR (Shapefiles)',1,'en','cor_lut_mapconnectiontype','4',1,'2006-12-06 11:11:01'),
('PostGIS',1,'en','cor_lut_mapconnectiontype','7',1,'2006-12-06 11:11:01'),
('WMS',1,'en','cor_lut_mapconnectiontype','5',1,'2006-12-06 11:11:01'),
('Raster',1,'en','cor_lut_mapconnectiontype','0',1,'2006-12-06 11:11:01'),
('Temporal Vector',1,'en','cor_lut_spantype','1',1,'2006-12-06 11:23:17'),
('Equal To',1,'en','cor_lut_spantype','2',1,'2006-12-06 11:23:17'),
('Bonds With',1,'en','cor_lut_spantype','3',1,'2006-12-06 11:23:17'),
('Interpretation',1,'en','cor_lut_txttype','1',1,'2006-12-06 11:24:58'),
('Short Description',1,'en','cor_lut_txttype','2',1,'2006-12-06 11:24:58'),
('Compaction',1,'en','cor_lut_txttype','4',1,'2006-12-06 11:24:58'),
('Colour',1,'en','cor_lut_txttype','5',1,'2006-12-06 11:24:58'),
('Composition',1,'en','cor_lut_txttype','6',1,'2006-12-06 11:24:58'),
('Dimensions',1,'en','cor_lut_txttype','8',1,'2006-12-06 11:24:58'),
('Orientation',1,'en','cor_lut_txttype','17',1,'2006-12-06 11:24:58'),
('Form',1,'en','cor_lut_txttype','30',1,'2006-12-06 11:24:58'),
('Description',1,'en','cor_lut_txttype','34',1,'2006-12-06 11:24:58'),
('Other Comments',1,'en','cor_lut_txttype','35',1,'2006-12-06 11:24:58'),
('Method/Conditions',1,'en','cor_lut_txttype','36',1,'2006-12-06 11:24:58'),
('Finish of stones',1,'en','cor_lut_txttype','40',1,'2006-12-06 11:24:58'),
('Inclusions',1,'en','cor_lut_txttype','57',1,'2006-12-06 11:24:58'),
('Bonding material',1,'en','cor_lut_txttype','88',4,'2008-03-05 00:00:00'),
('Direction of face(s)',1,'en','cor_lut_txttype','87',4,'2008-03-05 00:00:00'),
('Form',1,'en','cor_lut_txttype','86',4,'2008-03-05 00:00:00'),
('Coursing/bond',1,'en','cor_lut_txttype','85',4,'2008-03-05 00:00:00'),
('Size of materials',1,'en','cor_lut_txttype','84',4,'2008-03-05 00:00:00'),
('Truncation',1,'en','cor_lut_txttype','83',4,'2008-03-05 00:00:00'),
('Name',1,'en','cor_lut_txttype','67',4,'2007-05-15 00:00:00'),
('Initials',1,'en','cor_lut_txttype','68',4,'2007-05-17 00:00:00'),
('Inclination',1,'en','cor_lut_txttype','82',4,'2008-03-05 00:00:00'),
('Base',1,'en','cor_lut_txttype','81',4,'2008-03-05 00:00:00'),
('Registered By',1,'en','cor_lut_actiontype','12',4,'2007-06-15 00:00:00'),
('Registered On',1,'en','cor_lut_datetype','8',4,'2007-06-15 00:00:00'),
('Break of slope- Base',1,'en','cor_lut_txttype','80',4,'2008-03-05 00:00:00'),
('Materials',1,'en','cor_lut_txttype','70',4,'2007-06-15 00:00:00'),
('Sides',1,'en','cor_lut_txttype','79',4,'2008-03-05 00:00:00'),
('Break of slope- Top',1,'en','cor_lut_txttype','78',4,'2008-03-05 00:00:00'),
('Corners',1,'en','cor_lut_txttype','77',4,'2008-03-05 00:00:00'),
('Shape in plan',1,'en','cor_lut_txttype','76',4,'2008-03-05 00:00:00'),
('Condition',1,'en','cor_lut_attributetype','3',75,'2008-06-13 08:07:14'),
('Contamination',1,'en','cor_lut_attributetype','4',75,'2008-06-13 09:47:11'),
('Volume',1,'en','cor_lut_numbertype','6',75,'2008-06-13 10:04:33'),
('Sample Size',1,'en','cor_lut_attributetype','5',75,'2008-06-13 10:09:14'),
('Attitude of right arm, location of right hand',1,'en','cor_lut_txttype','92',4,'2008-06-18 00:00:00'),
('Attitude of head',1,'en','cor_lut_txttype','91',4,'2008-06-18 00:00:00'),
('Attitude of body',1,'en','cor_lut_txttype','90',4,'2008-06-18 00:00:00'),
('Questions About Sample (What do you want to know about the deposit)',1,'en','cor_lut_txttype','89',2,'2008-06-16 00:00:00'),
('Subsamples Required?',1,'en','cor_lut_attributetype','7',78,'2008-06-13 14:46:42'),
('Attitude of left arm, location of left hand',1,'en','cor_lut_txttype','93',4,'2008-06-18 00:00:00'),
('Attitude of right leg',1,'en','cor_lut_txttype','94',4,'2008-06-18 00:00:00'),
('Attitude of left leg',1,'en','cor_lut_txttype','95',4,'2008-06-18 00:00:00'),
('Attitude of feet',1,'en','cor_lut_txttype','96',4,'2008-06-18 00:00:00'),
('Extent of in situ bone degeneration',1,'en','cor_lut_txttype','97',4,'2008-06-18 00:00:00'),
('State of bone after lifting',1,'en','cor_lut_txttype','98',4,'2008-06-18 00:00:00'),
('Type',1,'en','cor_lut_txttype','99',2,'2008-06-25 00:00:00'),
('Other Contamination:',1,'en','cor_lut_txttype','100',2,'2008-06-25 00:00:00'),
('Type',1,'en','cor_lut_txttype','101',4,'2008-06-25 00:00:00'),
('Setting',1,'en','cor_lut_txttype','102',4,'2008-06-25 00:00:00'),
('Cross-Section',1,'en','cor_lut_txttype','103',4,'2008-06-25 00:00:00'),
('Condition',1,'en','cor_lut_txttype','104',4,'2008-06-25 00:00:00'),
('Conversion',1,'en','cor_lut_txttype','105',4,'2008-06-25 00:00:00'),
('Tool Marks',1,'en','cor_lut_txttype','106',4,'2008-06-25 00:00:00'),
('Joints and Fittings',1,'en','cor_lut_txttype','107',4,'2008-06-25 00:00:00'),
('Intentional Marks',1,'en','cor_lut_txttype','108',4,'0000-00-00 00:00:00'),
('Surface Treatment',1,'en','cor_lut_txttype','109',4,'2008-06-25 00:00:00'),
('Direction',1,'en','cor_lut_txttype','110',2,'2008-06-25 00:00:00'),
('Scale',1,'en','cor_lut_txttype','111',2,'2008-06-24 12:54:19'),
('Sample Status',1,'en','cor_lut_attributetype','8',1,'2008-03-05 00:00:00'),
('Status Notes',1,'en','cor_lut_txttype','112',1,'2008-03-05 00:00:00'),
('Type Notes',1,'en','cor_lut_txttype','113',1,'2008-03-05 00:00:00'),
('Action',1,'en','cor_lut_attributetype','9',1,'2008-03-05 00:00:00'),
('Priority',1,'en','cor_lut_attributetype','10',1,'2008-03-05 00:00:00'),
('Number of Bags',1,'en','cor_lut_numbertype','7',1,'2008-03-05 00:00:00'),
('Number of Bags',1,'en','cor_lut_numbertype','8',1,'2008-03-05 00:00:00'),
('Status',1,'en','cor_lut_attributetype','12',1,'2008-03-05 00:00:00'),
('Status',1,'en','cor_lut_attributetype','11',1,'2008-03-05 00:00:00'),
('Plan Context',1,'en','cor_lut_txttype','117',4,'2008-10-21 00:00:00'),
('Sample Type',1,'en','cor_lut_attributetype','13',4,'0000-00-00 00:00:00'),
('Provisional Period',1,'en','cor_lut_attributetype','14',1,'2009-11-06 00:00:00'),
('Location',1,'en','cor_lut_attributetype','16',2,'2009-12-02 00:00:00'),
('Materials Extracted',1,'en','cor_lut_attributetype','17',2,'2009-12-02 00:00:00'),
('Basic Interp.',1,'en','cor_lut_attributetype','18',2,'2009-12-08 00:00:00'),
('Object Material',1,'en','cor_lut_attributetype','19',2,'2010-10-22 16:39:41'),
('Object Type',1,'en','cor_lut_attributetype','20',2,'2010-10-22 16:40:41'),
('Xray ID',1,'en','cor_lut_txttype','114',2,'2010-10-22 16:43:04'),
('Comments',1,'en','cor_lut_txttype','115',2,'2010-10-22 16:48:26'),
('Object Period',1,'en','cor_lut_attributetype','21',2,'2010-10-22 16:54:38'),
('Completeness',1,'en','cor_lut_attributetype','22',2,'2010-10-22 17:08:16'),
('Diplay',1,'en','cor_lut_attributetype','23',2,'2010-10-22 17:08:48'),
('Subgroup Narrative',1,'en','cor_lut_txttype','116',2,'2010-11-30 15:14:10'),
('Author',1,'en','cor_lut_actiontype','13',2,'2010-11-30 15:14:37'),
('Date',1,'en','cor_lut_datetype','9',2,'2010-11-30 15:15:00'),
('Dating Narrative',1,'en','cor_lut_txttype','118',2,'2010-12-01 15:12:13'),
('Date',1,'en','cor_lut_datetype','10',2,'2010-12-01 15:12:37'),
('Author',1,'en','cor_lut_actiontype','14',2,'2010-12-01 15:13:08'),
('Image',1,'en','cor_lut_filetype','1',2,'2011-08-25 22:36:56'),
('Group Description',1,'en','cor_lut_txttype','119',2,'2011-08-31 19:43:42'),
('Group Text Author',1,'en','cor_lut_actiontype','15',2,'2011-08-31 19:45:24'),
('Date',1,'en','cor_lut_datetype','11',2,'2011-08-31 19:46:16'),
('Group Dating Info',1,'en','cor_lut_txttype','120',2,'2011-08-31 19:47:37'),
('Dating Info Author',1,'en','cor_lut_actiontype','16',2,'2011-08-31 19:49:07'),
('Dating Info Added On',1,'en','cor_lut_datetype','12',2,'2011-08-31 19:49:35'),
('Phase',1,'en','cor_lut_attributetype','26',2,'2011-12-08 11:58:23'),
('Basic Interpretation',1,'en','cor_lut_attributetype','27',78,'2013-07-05 11:41:24'),
('Data Entry Complete',1,'en','cor_lut_attribute','1',1,'2006-12-06 11:04:35'),
('Record Checked',1,'en','cor_lut_attribute','2',1,'2006-12-06 11:04:35'),
('Not Excavated',1,'en','cor_lut_attribute','3',1,'2006-12-06 11:04:35'),
('Partially Excavated',1,'en','cor_lut_attribute','4',1,'2006-12-06 11:04:35'),
('Excavated',1,'en','cor_lut_attribute','5',1,'2006-12-06 11:04:35'),
('Waterlogged',1,'en','cor_lut_attribute','6',2,'2008-06-13 08:07:14'),
('Moist',1,'en','cor_lut_attribute','7',2,'2008-06-13 08:07:14'),
('Dry',1,'en','cor_lut_attribute','8',2,'2008-06-13 08:07:14'),
('Root Action',1,'en','cor_lut_attribute','9',2,'2008-06-13 08:07:14'),
('Mixture with overburden',1,'en','cor_lut_attribute','10',2,'2008-06-13 08:07:14'),
('Other context',1,'en','cor_lut_attribute','11',2,'2008-06-13 08:07:14'),
('Modern Intrusions',1,'en','cor_lut_attribute','12',2,'2008-06-13 08:07:14'),
('<5pc',1,'en','cor_lut_attribute','13',2,'2008-06-13 08:07:14'),
('5-20pc',1,'en','cor_lut_attribute','14',2,'2008-06-13 08:07:14'),
('20-40pc',1,'en','cor_lut_attribute','15',2,'2008-06-13 08:07:14'),
('40-60pc',1,'en','cor_lut_attribute','16',2,'2008-06-13 08:07:14'),
('60-80pc',1,'en','cor_lut_attribute','17',2,'2008-06-13 08:07:14'),
('80-100pc',1,'en','cor_lut_attribute','18',2,'2008-06-13 08:07:14'),
('Radiocarbon',1,'en','cor_lut_attribute','26',78,'2008-06-13 14:46:42'),
('Control Sediment',1,'en','cor_lut_attribute','27',78,'2008-06-13 14:46:42'),
('Parasites',1,'en','cor_lut_attribute','28',78,'2008-06-13 14:46:42'),
('Insects',1,'en','cor_lut_attribute','29',78,'2008-06-13 14:46:42'),
('Pollen',1,'en','cor_lut_attribute','30',78,'2008-06-13 14:46:42'),
('Diatoms',1,'en','cor_lut_attribute','31',78,'2008-06-13 14:46:42'),
('None',1,'en','cor_lut_attribute','32',2,'2008-06-24 00:00:00'),
('Pot',1,'en','cor_lut_attribute','33',2,'2008-06-24 12:54:19'),
('Bone',1,'en','cor_lut_attribute','34',2,'2008-06-24 00:00:00'),
('Glass',1,'en','cor_lut_attribute','35',2,'2008-06-24 12:54:19'),
('CBM',1,'en','cor_lut_attribute','37',2,'2008-06-24 00:00:00'),
('Metal',1,'en','cor_lut_attribute','36',2,'2008-06-24 12:54:19'),
('Flint',1,'en','cor_lut_attribute','38',2,'2008-06-24 12:54:19'),
('Wood',1,'en','cor_lut_attribute','39',2,'2008-06-24 00:00:00'),
('Leather',1,'en','cor_lut_attribute','40',2,'2008-06-24 12:54:19'),
('Other (add to descr)',1,'en','cor_lut_attribute','41',2,'2008-06-24 00:00:00'),
('No Contamination',1,'en','cor_lut_attribute','42',2,'2008-06-25 00:00:00'),
('on Site',1,'en','cor_lut_attribute','43',1,'2008-03-05 00:00:00'),
('Retained',1,'en','cor_lut_attribute','46',1,'2008-03-05 00:00:00'),
('Processed',1,'en','cor_lut_attribute','45',1,'2008-03-05 00:00:00'),
('in Cambridge',1,'en','cor_lut_attribute','44',1,'2008-03-05 00:00:00'),
('Kubiena',1,'en','cor_lut_attribute','73',4,'0000-00-00 00:00:00'),
('Specific Ecofact',1,'en','cor_lut_attribute','72',4,'0000-00-00 00:00:00'),
('Ecofact Recovery',1,'en','cor_lut_attribute','71',4,'0000-00-00 00:00:00'),
('Waterlogged',1,'en','cor_lut_attribute','70',4,'0000-00-00 00:00:00'),
('Monolith',1,'en','cor_lut_attribute','69',4,'0000-00-00 00:00:00'),
('Skeleton Recovery',1,'en','cor_lut_attribute','68',4,'0000-00-00 00:00:00'),
('General Bulk',1,'en','cor_lut_attribute','67',4,'0000-00-00 00:00:00'),
('Low',1,'en','cor_lut_attribute','54',1,'2008-03-05 00:00:00'),
('Medium',1,'en','cor_lut_attribute','55',1,'2008-03-05 00:00:00'),
('High',1,'en','cor_lut_attribute','56',1,'2008-03-05 00:00:00'),
('Drying',1,'en','cor_lut_attribute','57',1,'2008-03-05 00:00:00'),
('Bagged',1,'en','cor_lut_attribute','58',1,'2008-03-05 00:00:00'),
('Processed',1,'en','cor_lut_attribute','59',1,'2008-03-05 00:00:00'),
('Drying',1,'en','cor_lut_attribute','60',1,'2008-03-05 00:00:00'),
('Bagged',1,'en','cor_lut_attribute','61',1,'2008-03-05 00:00:00'),
('Processed',1,'en','cor_lut_attribute','62',1,'2008-03-05 00:00:00'),
('Cremation',1,'en','cor_lut_attribute','66',4,'0000-00-00 00:00:00'),
('Bone Extracted',1,'en','cor_lut_attribute','64',1,'2008-03-05 00:00:00'),
('Residue Sorted',1,'en','cor_lut_attribute','65',1,'2008-03-05 00:00:00'),
('Soil Chemistry',1,'en','cor_lut_attribute','74',4,'0000-00-00 00:00:00'),
('Snails',1,'en','cor_lut_attribute','75',4,'0000-00-00 00:00:00'),
('Pollen',1,'en','cor_lut_attribute','76',4,'0000-00-00 00:00:00'),
('Special',1,'en','cor_lut_attribute','77',4,'0000-00-00 00:00:00'),
('Missing',1,'en','cor_lut_attribute','78',4,'0000-00-00 00:00:00'),
('Data Missing',1,'en','cor_lut_attribute','79',4,'0000-00-00 00:00:00'),
('Void',1,'en','cor_lut_attribute','80',4,'0000-00-00 00:00:00'),
('with External',1,'en','cor_lut_attribute','81',4,'0000-00-00 00:00:00'),
('Natural',1,'en','cor_lut_attribute','82',1,'2009-11-06 00:00:00'),
('Modern',1,'en','cor_lut_attribute','83',1,'2009-11-10 15:35:34'),
('Early PM',1,'en','cor_lut_attribute','84',1,'2009-11-10 15:35:34'),
('Roman I',1,'en','cor_lut_attribute','85',1,'2009-11-10 15:35:34'),
('Late PM',1,'en','cor_lut_attribute','86',1,'2009-11-10 15:35:34'),
('PM Soils',1,'en','cor_lut_attribute','87',1,'2009-11-10 15:35:35'),
('Roman II',1,'en','cor_lut_attribute','88',1,'2009-11-10 15:35:36'),
('Pre-Roman',1,'en','cor_lut_attribute','89',1,'2009-11-10 15:35:54'),
('Not Processed',1,'en','cor_lut_attribute','90',2,'2009-11-06 00:00:00'),
('yes',5,'en','cor_lut_attribute','91',2,'2009-11-06 00:00:00'),
('no',6,'en','cor_lut_attribute','91',2,'2009-11-06 00:00:00'),
('Flot Recovered',1,'en','cor_lut_attribute','91',2,'2009-11-06 00:00:00'),
('LP Cambridge',1,'en','cor_lut_attribute','93',2,'2009-12-02 00:00:00'),
('AEA',1,'en','cor_lut_attribute','94',2,'2009-12-02 00:00:00'),
('N/A',1,'en','cor_lut_attribute','95',2,'2009-12-02 00:00:00'),
('Yes',5,'en','cor_lut_attribute','92',2,'2009-12-02 00:00:00'),
('No',6,'en','cor_lut_attribute','92',2,'2009-12-02 00:00:00'),
('Assessed?',1,'en','cor_lut_attribute','92',2,'2009-12-02 00:00:00'),
('Charcoal',1,'en','cor_lut_attribute','96',2,'2009-12-02 00:00:00'),
('Human Bone - Inhumation',1,'en','cor_lut_attribute','97',2,'2009-12-02 00:00:00'),
('Human Bone - Cremation 2mm to 4mm',1,'en','cor_lut_attribute','98',2,'2009-12-02 00:00:00'),
('Human Bone - Cremation > 4mm',1,'en','cor_lut_attribute','99',2,'2009-12-02 00:00:00'),
('Plant Remains',1,'en','cor_lut_attribute','100',2,'2009-12-02 00:00:00'),
('Burial',1,'en','cor_lut_attribute','101',2,'2009-12-08 00:00:00'),
('Cremation',1,'en','cor_lut_attribute','102',2,'2009-12-08 00:00:00'),
('Poss? Cremation',1,'en','cor_lut_attribute','103',2,'2009-12-09 00:00:00'),
('Pit',1,'en','cor_lut_attribute','104',2,'2009-12-09 00:00:00'),
('Lead',1,'en','cor_lut_attribute','105',2,'2010-10-22 16:19:00'),
('Copper',1,'en','cor_lut_attribute','106',2,'2010-10-22 16:19:00'),
('Iron',1,'en','cor_lut_attribute','107',2,'2010-10-22 16:19:00'),
('Ceramic',1,'en','cor_lut_attribute','108',2,'2010-10-22 16:19:00'),
('Stone',1,'en','cor_lut_attribute','109',2,'2010-10-22 16:19:00'),
('Ivory',1,'en','cor_lut_attribute','110',2,'2010-10-22 16:19:00'),
('Fibre',1,'en','cor_lut_attribute','111',2,'2010-10-22 16:19:00'),
('samP',1,'en','cor_lut_attribute','112',2,'2010-10-22 16:19:00'),
('Rivet',1,'en','cor_lut_attribute','113',2,'2010-10-22 16:19:00'),
('Waste',1,'en','cor_lut_attribute','114',2,'2010-10-22 16:19:00'),
('Coin',1,'en','cor_lut_attribute','115',2,'2010-10-22 16:19:00'),
('Vessel',1,'en','cor_lut_attribute','116',2,'2010-10-22 16:19:00'),
('Shoe',1,'en','cor_lut_attribute','117',2,'2010-10-22 16:19:00'),
('Spindle',1,'en','cor_lut_attribute','118',2,'2010-10-22 16:19:00'),
('Stud',1,'en','cor_lut_attribute','119',2,'2010-10-22 16:19:00'),
('Slag',1,'en','cor_lut_attribute','120',2,'2010-10-22 16:19:00'),
('Buckle',1,'en','cor_lut_attribute','121',2,'2010-10-22 16:19:00'),
('Staple',1,'en','cor_lut_attribute','122',2,'2010-10-22 16:19:00'),
('Knife',1,'en','cor_lut_attribute','123',2,'2010-10-22 16:19:00'),
('Mount',1,'en','cor_lut_attribute','124',2,'2010-10-22 16:19:00'),
('Handle',1,'en','cor_lut_attribute','125',2,'2010-10-22 16:19:00'),
('Ring',1,'en','cor_lut_attribute','126',2,'2010-10-22 16:19:00'),
('Strap',1,'en','cor_lut_attribute','127',2,'2010-10-22 16:19:00'),
('Wire',1,'en','cor_lut_attribute','128',2,'2010-10-22 16:19:00'),
('Key',1,'en','cor_lut_attribute','129',2,'2010-10-22 16:19:00'),
('Nail',1,'en','cor_lut_attribute','130',2,'2010-10-22 16:19:00'),
('Chisel',1,'en','cor_lut_attribute','131',2,'2010-10-22 16:19:00'),
('Horse Shoe',1,'en','cor_lut_attribute','132',2,'2010-10-22 16:19:00'),
('Hinge',1,'en','cor_lut_attribute','133',2,'2010-10-22 16:19:00'),
('Bracelet',1,'en','cor_lut_attribute','134',2,'2010-10-22 16:19:00'),
('Bead',1,'en','cor_lut_attribute','135',2,'2010-10-22 16:19:00'),
('Barrel',1,'en','cor_lut_attribute','136',2,'2010-10-22 16:19:00'),
('Chape',1,'en','cor_lut_attribute','137',2,'2010-10-22 16:19:00'),
('Pin',1,'en','cor_lut_attribute','138',2,'2010-10-22 16:19:00'),
('Button',1,'en','cor_lut_attribute','139',2,'2010-10-22 16:19:00'),
('Patch',1,'en','cor_lut_attribute','140',2,'2010-10-22 16:19:00'),
('Bottle',1,'en','cor_lut_attribute','141',2,'2010-10-22 16:19:00'),
('Cup',1,'en','cor_lut_attribute','142',2,'2010-10-22 16:19:00'),
('Window',1,'en','cor_lut_attribute','143',2,'2010-10-22 16:19:00'),
('Jar',1,'en','cor_lut_attribute','144',2,'2010-10-22 16:19:00'),
('Tessera',1,'en','cor_lut_attribute','145',2,'2010-10-22 16:19:00'),
('Beaker',1,'en','cor_lut_attribute','146',2,'2010-10-22 16:19:00'),
('Phial',1,'en','cor_lut_attribute','147',2,'2010-10-22 16:19:00'),
('Tumbler',1,'en','cor_lut_attribute','148',2,'2010-10-22 16:19:00'),
('Hone',1,'en','cor_lut_attribute','149',2,'2010-10-22 16:19:00'),
('Pinners Bone',1,'en','cor_lut_attribute','150',2,'2010-10-22 16:19:00'),
('Comb',1,'en','cor_lut_attribute','151',2,'2010-10-22 16:19:00'),
('Awl',1,'en','cor_lut_attribute','152',2,'2010-10-22 16:19:00'),
('Tobacco Pipe',1,'en','cor_lut_attribute','153',2,'2010-10-22 16:19:00'),
('Wig Curler',1,'en','cor_lut_attribute','154',2,'2010-10-22 16:19:00'),
('Samian',1,'en','cor_lut_attribute','155',2,'2010-10-22 16:19:00'),
('Lamp',1,'en','cor_lut_attribute','156',2,'2010-10-22 16:19:00'),
('Wall Tile',1,'en','cor_lut_attribute','157',2,'2010-10-22 16:19:00'),
('Floor Tile',1,'en','cor_lut_attribute','158',2,'2010-10-22 16:19:00'),
('Bolt',1,'en','cor_lut_attribute','159',2,'2010-10-22 16:19:00'),
('Bowl',1,'en','cor_lut_attribute','160',2,'2010-10-22 16:19:00'),
('Brush',1,'en','cor_lut_attribute','161',2,'2010-10-22 16:19:00'),
('Plug',1,'en','cor_lut_attribute','162',2,'2010-10-22 16:19:00'),
('Badge',1,'en','cor_lut_attribute','163',2,'2010-10-22 16:19:00'),
('Strap end (or belt chape)',1,'en','cor_lut_attribute','164',2,'2010-10-22 16:19:00'),
('Dress Hook',1,'en','cor_lut_attribute','165',2,'2010-10-22 16:19:00'),
('Weight',1,'en','cor_lut_attribute','166',2,'2010-10-22 16:19:00'),
('Cloth Seal',1,'en','cor_lut_attribute','167',2,'2010-10-22 16:19:00'),
('Came',1,'en','cor_lut_attribute','168',2,'2010-10-22 16:19:00'),
('Shot',1,'en','cor_lut_attribute','169',2,'2010-10-22 16:19:00'),
('Flask',1,'en','cor_lut_attribute','170',2,'2010-10-22 16:19:00'),
('Ferrule',1,'en','cor_lut_attribute','171',2,'2010-10-22 16:19:00'),
('Rove',1,'en','cor_lut_attribute','172',2,'2010-10-22 16:19:00'),
('Padlock',1,'en','cor_lut_attribute','173',2,'2010-10-22 16:19:00'),
('Jug',1,'en','cor_lut_attribute','174',2,'2010-10-22 16:19:00'),
('Counter',1,'en','cor_lut_attribute','175',2,'2010-10-22 16:19:00'),
('Alley',1,'en','cor_lut_attribute','176',2,'2010-10-22 16:19:00'),
('Toothbrush',1,'en','cor_lut_attribute','177',2,'2010-10-22 16:19:00'),
('Spoon',1,'en','cor_lut_attribute','178',2,'2010-10-22 16:19:00'),
('Gun Flint',1,'en','cor_lut_attribute','179',2,'2010-10-22 16:19:00'),
('Figurine',1,'en','cor_lut_attribute','180',2,'2010-10-22 16:19:00'),
('Lock',1,'en','cor_lut_attribute','181',2,'2010-10-22 16:19:00'),
('Seal Box',1,'en','cor_lut_attribute','182',2,'2010-10-22 16:19:00'),
('Bracket',1,'en','cor_lut_attribute','183',2,'2010-10-22 16:19:00'),
('Brooch',1,'en','cor_lut_attribute','184',2,'2010-10-22 16:19:00'),
('Chatelaine',1,'en','cor_lut_attribute','185',2,'2010-10-22 16:19:00'),
('Quern',1,'en','cor_lut_attribute','186',2,'2010-10-22 16:19:00'),
('Tile',1,'en','cor_lut_attribute','187',2,'2010-10-22 16:19:00'),
('Structural Fitting',1,'en','cor_lut_attribute','188',2,'2010-10-22 16:19:00'),
('Ladle',1,'en','cor_lut_attribute','189',2,'2010-10-22 16:19:00'),
('Cloth',1,'en','cor_lut_attribute','190',2,'2010-10-22 16:19:00'),
('Patten',1,'en','cor_lut_attribute','191',2,'2010-10-22 16:19:00'),
('Crucible',1,'en','cor_lut_attribute','192',2,'2010-10-22 16:19:00'),
('Mortuarium (Ceramic)',1,'en','cor_lut_attribute','193',2,'2010-10-22 16:19:00'),
('Inlay',1,'en','cor_lut_attribute','194',2,'2010-10-22 16:19:00'),
('Roman',1,'en','cor_lut_attribute','195',2,'2010-10-22 16:19:00'),
('Post Medieval',1,'en','cor_lut_attribute','196',2,'2010-10-22 16:19:00'),
('PH',1,'en','cor_lut_attribute','197',2,'2010-10-22 16:19:00'),
('Medieval',1,'en','cor_lut_attribute','198',2,'2010-10-22 16:19:00'),
('Bone',1,'en','cor_lut_attribute','199',2,'0000-00-00 00:00:00'),
('Glass',1,'en','cor_lut_attribute','200',2,'0000-00-00 00:00:00'),
('Flint',1,'en','cor_lut_attribute','201',2,'0000-00-00 00:00:00'),
('Wood',1,'en','cor_lut_attribute','202',2,'0000-00-00 00:00:00'),
('Leather',1,'en','cor_lut_attribute','203',2,'0000-00-00 00:00:00'),
('Object',1,'en','cor_lut_attribute','204',2,'2010-10-22 16:19:00'),
('Whole',1,'en','cor_lut_attribute','205',2,'2010-10-22 16:19:00'),
('Half',1,'en','cor_lut_attribute','206',2,'2010-10-22 16:19:00'),
('Displayable',1,'en','cor_lut_attribute','207',2,'2010-10-22 16:19:00'),
('Palaeochannel',1,'en','cor_lut_attribute','208',71,'2010-11-30 17:00:09'),
('Record Complete',1,'en','cor_lut_attribute','209',4,'2010-12-10 00:00:00'),
('yes',5,'en','cor_lut_attribute','209',4,'0000-00-00 00:00:00'),
('no',6,'en','cor_lut_attribute','209',4,'2010-12-10 00:00:00'),
('CR - Cremation Burial',1,'en','cor_lut_attribute','212',4,'2008-10-08 00:00:00'),
('CE - Cellar, Basement, etc.',1,'en','cor_lut_attribute','213',4,'2008-10-08 00:00:00'),
('CD - Construction Debris',1,'en','cor_lut_attribute','214',4,'2008-10-08 00:00:00'),
('C - Coffin',1,'en','cor_lut_attribute','215',4,'2008-10-08 00:00:00'),
('D - Ditch, Drain, Gully, etc.',1,'en','cor_lut_attribute','211',4,'2008-10-08 00:00:00'),
('DB - Destruction Debris (Redeposited)',1,'en','cor_lut_attribute','210',4,'2008-10-08 00:00:00'),
('DS - Destruction Debris (in situ)',1,'en','cor_lut_attribute','216',4,'2008-10-08 00:00:00'),
('EB - External Bank',1,'en','cor_lut_attribute','217',4,'2008-10-08 00:00:00'),
('EC - External Cultivation',1,'en','cor_lut_attribute','218',4,'2008-10-08 00:00:00'),
('ED - External Dump',1,'en','cor_lut_attribute','219',4,'2008-10-08 00:00:00'),
('EM - External Metalling, Cobbling, etc.',1,'en','cor_lut_attribute','220',4,'2008-10-08 00:00:00'),
('EO - External Occupation',1,'en','cor_lut_attribute','221',4,'2008-10-08 00:00:00'),
('EP - External Pasture, Parkland',1,'en','cor_lut_attribute','222',4,'2008-10-08 00:00:00'),
('ER - External Revetment',1,'en','cor_lut_attribute','223',4,'2008-10-08 00:00:00'),
('ES - External Surface (No Cultivation)',1,'en','cor_lut_attribute','224',4,'2008-10-08 00:00:00'),
('EU - External (Unspecified)',1,'en','cor_lut_attribute','225',4,'2008-10-08 00:00:00'),
('F - Furnace, Oven, Kiln, Fireplace, etc.',1,'en','cor_lut_attribute','226',4,'2008-10-08 00:00:00'),
('FL - Floor',1,'en','cor_lut_attribute','227',4,'2008-10-08 00:00:00'),
('G - Grave',1,'en','cor_lut_attribute','228',4,'2008-10-08 00:00:00'),
('GM - Grave (Multiple Occupancy)',1,'en','cor_lut_attribute','229',4,'2008-10-08 00:00:00'),
('HE - Hearth',1,'en','cor_lut_attribute','230',4,'2008-10-08 00:00:00'),
('ME - Mechanical Fixtures/Fittings',1,'en','cor_lut_attribute','231',4,'2008-10-08 00:00:00'),
('MU - Make-up, Levelling',1,'en','cor_lut_attribute','232',4,'2008-10-08 00:00:00'),
('N - Natural Strata (Unspecified)',1,'en','cor_lut_attribute','233',4,'2008-10-08 00:00:00'),
('NA - Natural Wind-Blown Deposit',1,'en','cor_lut_attribute','234',4,'2008-10-08 00:00:00'),
('NC - Natural Alluvial Channel Deposit',1,'en','cor_lut_attribute','235',4,'2008-10-08 00:00:00'),
('NE - Natural Erosional Feature',1,'en','cor_lut_attribute','236',4,'2008-10-08 00:00:00'),
('NF - Natural Foreshore Deposit',1,'en','cor_lut_attribute','237',4,'2008-10-08 00:00:00'),
('NM - Natural Marsh Deposit',1,'en','cor_lut_attribute','238',4,'2008-10-08 00:00:00'),
('NO - Natural Alluvial Overbank',1,'en','cor_lut_attribute','239',4,'2008-10-08 00:00:00'),
('NS - Natural Soil (Unspecified)',1,'en','cor_lut_attribute','240',4,'2008-10-08 00:00:00'),
('OC - Occupation Debris',1,'en','cor_lut_attribute','241',4,'2008-10-08 00:00:00'),
('P - Pit (Unspecified)',1,'en','cor_lut_attribute','242',4,'2008-10-08 00:00:00'),
('PC - Pit Cess',1,'en','cor_lut_attribute','243',4,'2008-10-08 00:00:00'),
('PK - Pit Cooking',1,'en','cor_lut_attribute','244',4,'2008-10-08 00:00:00'),
('PO - Pit Ossuary',1,'en','cor_lut_attribute','245',4,'2008-10-08 00:00:00'),
('PQ - Pit Quarry',1,'en','cor_lut_attribute','246',4,'2008-10-08 00:00:00'),
('PR - Pit Refuse',1,'en','cor_lut_attribute','247',4,'2008-10-08 00:00:00'),
('PS - Positive Structural (Not Walls)',1,'en','cor_lut_attribute','248',4,'2008-10-08 00:00:00'),
('PT - Pit Storage',1,'en','cor_lut_attribute','249',4,'2008-10-08 00:00:00'),
('RO - Roof, Ceiling',1,'en','cor_lut_attribute','250',4,'2008-10-08 00:00:00'),
('S - Structural Cut',1,'en','cor_lut_attribute','251',4,'2008-10-08 00:00:00'),
('SE - Surface Erosion (Interface or Cut)',1,'en','cor_lut_attribute','252',4,'2008-10-08 00:00:00'),
('SK - Skeleton',1,'en','cor_lut_attribute','253',4,'2008-10-08 00:00:00'),
('SN - Non-Structural Cut',1,'en','cor_lut_attribute','254',4,'2008-10-08 00:00:00'),
('SO - Structural Opening',1,'en','cor_lut_attribute','255',4,'2008-10-08 00:00:00'),
('SP - Structural Cut (Post-hole)',1,'en','cor_lut_attribute','256',4,'2008-10-08 00:00:00'),
('ST - Structural Timber',1,'en','cor_lut_attribute','257',4,'2008-10-08 00:00:00'),
('SU - Sump - Water Collection Pit',1,'en','cor_lut_attribute','258',4,'2008-10-08 00:00:00'),
('TH - Tree Hole/Bole',1,'en','cor_lut_attribute','259',4,'2008-10-08 00:00:00'),
('TI - Timber Not in situ',1,'en','cor_lut_attribute','260',4,'2008-10-08 00:00:00'),
('W - Well',1,'en','cor_lut_attribute','261',4,'2008-10-08 00:00:00'),
('WA - Wall, Sill',1,'en','cor_lut_attribute','262',4,'2008-10-08 00:00:00'),
('WS - Worked Stone Not in situe',1,'en','cor_lut_attribute','263',4,'2008-10-08 00:00:00'),
('XX - Unknown/Unspecified',1,'en','cor_lut_attribute','264',4,'2008-10-08 00:00:00'),
('Soakaway',1,'en','cor_lut_attribute','265',71,'2011-01-13 18:26:55'),
('Layer',1,'en','cor_lut_attribute','266',71,'2011-01-18 14:14:50'),
('Masonry',1,'en','cor_lut_attribute','267',71,'2011-01-31 11:59:12'),
('Linear',1,'en','cor_lut_attribute','268',71,'2011-01-31 12:00:20'),
('Drain',1,'en','cor_lut_attribute','269',71,'2011-02-02 15:20:03'),
('Post-hole',1,'en','cor_lut_attribute','270',71,'2011-02-14 12:07:17'),
('Roman I AD50-AD120',1,'en','cor_lut_attribute','273',2,'2011-12-08 12:03:00'),
('Fragment',1,'en','cor_lut_attribute','271',2,'2011-11-24 14:31:47'),
('Pre-Roman xx-AD50',1,'en','cor_lut_attribute','272',2,'2011-12-08 12:00:11'),
('Roman II AD120-AD160',1,'en','cor_lut_attribute','274',2,'2011-12-08 12:03:40'),
('Roman III AD160-AD250',1,'en','cor_lut_attribute','275',2,'2011-12-08 12:05:57'),
('Roman IV AD250-AD400',1,'en','cor_lut_attribute','276',2,'2011-12-08 12:06:28'),
('Medieval AD400-AD1480',1,'en','cor_lut_attribute','277',2,'2011-12-08 12:08:51'),
('Post Medieval AD1480-AD1600',1,'en','cor_lut_attribute','278',2,'2011-12-08 12:09:52'),
('Post Medieval II AD1600-AD1690',1,'en','cor_lut_attribute','279',2,'2011-12-08 12:10:37'),
('Post Medieval III AD1690-AD1800',1,'en','cor_lut_attribute','280',2,'2011-12-08 12:11:15'),
('Post Medieval IV AD1800-AD1901',1,'en','cor_lut_attribute','281',2,'2011-12-08 12:11:59'),
('Deposit',1,'en','cxt_lut_cxttype','8',123,'2013-12-18 21:26:33'),
('Object',0,'en','rgf_lut_rgftype','1',123,'2013-12-18 22:14:42'),
('Coin',0,'en','rgf_lut_rgftype','2',123,'2013-12-18 22:14:53'),
('C - Creation',0,'en','cor_lut_attribute','282',123,'2013-12-20 00:00:00'),
('Process',1,'en','cor_lut_attributetype','28',123,'2013-12-20 00:00:00'),
('Context Sheet',1,'en','cor_lut_filetype','2',123,'2013-12-20 00:00:00'),
('CU - Creation/Use',1,'en','cor_lut_attribute','283',123,'2013-12-20 00:00:00'),
('U - Use',1,'en','cor_lut_attribute','284',123,'2013-12-20 00:00:00'),
('UD - Use/Destruction',1,'en','cor_lut_attribute','285',123,'2013-12-20 00:00:00'),
('CUD - Creation/Use/Destruction',1,'en','cor_lut_attribute','287',123,'2013-12-20 00:00:00'),
('CUD',1,'en','cor_lut_attribute','288',91,'2014-02-07 17:37:44'),
('D',1,'en','cor_lut_attribute','289',91,'2014-02-07 17:37:44'),
('C',1,'en','cor_lut_attribute','290',91,'2014-02-07 17:37:44'),
('CU',1,'en','cor_lut_attribute','291',91,'2014-02-07 17:37:44'),
('UD',1,'en','cor_lut_attribute','292',91,'2014-02-07 17:37:44'),
('U',1,'en','cor_lut_attribute','293',91,'2014-02-07 17:37:44'),
('CD',1,'en','cor_lut_attribute','294',91,'2014-02-07 17:37:44'),
('EC',1,'en','cor_lut_attribute','295',91,'2014-02-07 17:40:05'),
('P',1,'en','cor_lut_attribute','296',91,'2014-02-07 17:40:05'),
('TH',1,'en','cor_lut_attribute','297',91,'2014-02-07 17:40:05'),
('WA',1,'en','cor_lut_attribute','298',91,'2014-02-07 17:40:05'),
('PQ',1,'en','cor_lut_attribute','299',91,'2014-02-07 17:40:05'),
('N',1,'en','cor_lut_attribute','300',91,'2014-02-07 17:40:05'),
('DS',1,'en','cor_lut_attribute','301',91,'2014-02-07 17:40:05'),
('OC',1,'en','cor_lut_attribute','302',91,'2014-02-07 17:40:05'),
('XX',1,'en','cor_lut_attribute','303',91,'2014-02-07 17:40:05'),
('DB',1,'en','cor_lut_attribute','304',91,'2014-02-07 17:40:06'),
('EO',1,'en','cor_lut_attribute','305',91,'2014-02-07 17:40:06'),
('EM',1,'en','cor_lut_attribute','306',91,'2014-02-07 17:40:06'),
('SN',1,'en','cor_lut_attribute','307',91,'2014-02-07 17:40:06'),
('MU',1,'en','cor_lut_attribute','308',91,'2014-02-07 17:40:06'),
('HE',1,'en','cor_lut_attribute','309',91,'2014-02-07 17:40:06'),
('ES',1,'en','cor_lut_attribute','310',91,'2014-02-07 17:40:06'),
('ED',1,'en','cor_lut_attribute','311',91,'2014-02-07 17:40:06'),
('S',1,'en','cor_lut_attribute','312',91,'2014-02-07 17:40:06'),
('SO',1,'en','cor_lut_attribute','313',91,'2014-02-07 17:40:06'),
('FL',1,'en','cor_lut_attribute','314',91,'2014-02-07 17:40:06'),
('EB',1,'en','cor_lut_attribute','315',91,'2014-02-07 17:40:06'),
('D',1,'en','cor_lut_attribute','316',91,'2014-02-07 17:40:06'),
('G',1,'en','cor_lut_attribute','317',91,'2014-02-07 17:40:06'),
('SK',1,'en','cor_lut_attribute','318',91,'2014-02-07 17:40:06'),
('PS',1,'en','cor_lut_attribute','319',91,'2014-02-07 17:40:06'),
('SP',1,'en','cor_lut_attribute','320',91,'2014-02-07 17:40:06'),
('PR',1,'en','cor_lut_attribute','321',91,'2014-02-07 17:40:06'),
('EC',1,'en','cor_lut_attribute','322',91,'2014-02-12 16:19:25'),
('P',1,'en','cor_lut_attribute','323',91,'2014-02-12 16:19:26'),
('TH',1,'en','cor_lut_attribute','324',91,'2014-02-12 16:19:26'),
('WA',1,'en','cor_lut_attribute','325',91,'2014-02-12 16:19:26'),
('PQ',1,'en','cor_lut_attribute','326',91,'2014-02-12 16:19:26'),
('N',1,'en','cor_lut_attribute','327',91,'2014-02-12 16:19:26'),
('DS',1,'en','cor_lut_attribute','328',91,'2014-02-12 16:19:26'),
('OC',1,'en','cor_lut_attribute','329',91,'2014-02-12 16:19:26'),
('XX',1,'en','cor_lut_attribute','330',91,'2014-02-12 16:19:26'),
('DB',1,'en','cor_lut_attribute','331',91,'2014-02-12 16:19:26'),
('EO',1,'en','cor_lut_attribute','332',91,'2014-02-12 16:19:26'),
('EM',1,'en','cor_lut_attribute','333',91,'2014-02-12 16:19:26'),
('SN',1,'en','cor_lut_attribute','334',91,'2014-02-12 16:19:26'),
('MU',1,'en','cor_lut_attribute','335',91,'2014-02-12 16:19:26'),
('HE',1,'en','cor_lut_attribute','336',91,'2014-02-12 16:19:26'),
('ES',1,'en','cor_lut_attribute','337',91,'2014-02-12 16:19:26'),
('ED',1,'en','cor_lut_attribute','338',91,'2014-02-12 16:19:26'),
('S',1,'en','cor_lut_attribute','339',91,'2014-02-12 16:19:26'),
('SO',1,'en','cor_lut_attribute','340',91,'2014-02-12 16:19:26'),
('FL',1,'en','cor_lut_attribute','341',91,'2014-02-12 16:19:26'),
('EB',1,'en','cor_lut_attribute','342',91,'2014-02-12 16:19:26'),
('D',1,'en','cor_lut_attribute','343',91,'2014-02-12 16:19:26'),
('G',1,'en','cor_lut_attribute','344',91,'2014-02-12 16:19:26'),
('SK',1,'en','cor_lut_attribute','345',91,'2014-02-12 16:19:26'),
('PS',1,'en','cor_lut_attribute','346',91,'2014-02-12 16:19:26'),
('SP',1,'en','cor_lut_attribute','347',91,'2014-02-12 16:19:26'),
('PR',1,'en','cor_lut_attribute','348',91,'2014-02-12 16:19:26'),
('ShareGeom',1,'en','cor_lut_spantype','5',91,'2014-02-12 17:36:54'),
('Layer',1,'en','cxt_lut_cxttype','9',0,'0000-00-00 00:00:00'),
('Animal Bone',1,'en','cor_lut_attribute','349',91,'2014-02-13 18:38:19'),
('CTP',1,'en','cor_lut_attribute','350',91,'2014-02-13 18:38:19'),
('Fe Obj',1,'en','cor_lut_attribute','351',91,'2014-02-13 18:38:19'),
('skel',1,'en','cor_lut_attribute','352',91,'2014-02-13 18:38:19'),
('Daub',1,'en','cor_lut_attribute','353',91,'2014-02-13 18:38:19'),
('Cu Obj',1,'en','cor_lut_attribute','354',91,'2014-02-13 18:38:19'),
('Stone',1,'en','cor_lut_attribute','355',91,'2014-02-13 18:47:24'),
('Worked_bone',1,'en','cor_lut_attribute','356',91,'2014-02-13 18:47:24'),
('Shell',1,'en','cor_lut_attribute','357',91,'2014-02-13 18:47:24'),
('pb',1,'en','cor_lut_attribute','358',91,'2014-02-13 18:47:24'),
('slag',1,'en','cor_lut_attribute','359',91,'2014-02-13 18:47:24'),
('Human bone',1,'en','cor_lut_attribute','360',91,'2014-02-13 18:47:24'),
('Spot Date',1,'en','cor_lut_attributetype','29',123,'2014-02-19 13:16:46'),
('MOD AD1800+',1,'en','cor_lut_attribute','361',91,'2014-02-19 13:27:17'),
('M1 AD1070-1125',1,'en','cor_lut_attribute','362',91,'2014-02-19 13:27:17'),
('M3 AD1200-1300',1,'en','cor_lut_attribute','363',91,'2014-02-19 13:27:17'),
('PM1 AD1550-1720',1,'en','cor_lut_attribute','364',91,'2014-02-19 13:27:17'),
('M5 AD1470-1550',1,'en','cor_lut_attribute','365',91,'2014-02-19 13:27:17'),
('M4 AD1300-1470',1,'en','cor_lut_attribute','366',91,'2014-02-19 13:27:17'),
('M2 AD1125-1200',1,'en','cor_lut_attribute','367',91,'2014-02-19 13:27:17'),
('PM2 AD1700-1800',1,'en','cor_lut_attribute','368',91,'2014-02-19 13:27:17'),
('SN AD1000-1070',1,'en','cor_lut_attribute','369',91,'2014-02-19 13:27:17'),
('IA',1,'en','cor_lut_attribute','370',91,'2014-02-19 13:27:17'),
('MIA',1,'en','cor_lut_attribute','371',91,'2014-02-19 13:27:17'),
('RB??',1,'en','cor_lut_attribute','372',91,'2014-02-19 13:27:18'),
('LSAX',1,'en','cor_lut_attribute','373',91,'2014-02-19 13:27:18'),
('RB',1,'en','cor_lut_attribute','374',91,'2014-02-19 13:27:18'),
('Section',1,'en','cor_lut_filetype','3',91,'2014-02-21 12:00:41');
/*!40000 ALTER TABLE `cor_tbl_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_col`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_tbl_col` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_col`
--

LOCK TABLES `cor_tbl_col` WRITE;
/*!40000 ALTER TABLE `cor_tbl_col` DISABLE KEYS */;
INSERT INTO `cor_tbl_col` VALUES (4,'cxttype','The column holding the context type',4,'2007-01-15 00:00:00'),(6,'rgftype','The column on rgf_tbl_rfg holding the rgf type',1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_col` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_filter`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_tbl_filter` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `filter` text CHARACTER SET utf8 NOT NULL,
  `type` varchar(6) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nname` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sgrp` int(3) NOT NULL DEFAULT '0',
  `cre_by` char(3) NOT NULL DEFAULT '',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_filter`
--

LOCK TABLES `cor_tbl_filter` WRITE;
/*!40000 ALTER TABLE `cor_tbl_filter` DISABLE KEYS */;
INSERT INTO `cor_tbl_filter` VALUES (33,'a:2:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"3\";s:5:\"ktype\";s:3:\"all\";}}','set','All photos',0,'4','2011-06-24 15:41:36'),(35,'a:4:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";}s:5:\"nname\";s:9:\"Subgroups\";s:6:\"cre_by\";s:1:\"2\";}','set','SGRs',1,'2','2011-06-28 17:50:32'),(37,'a:2:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"9\";s:5:\"ktype\";s:3:\"all\";}}','set','All Reg Finds',0,'2','2011-08-25 21:29:28'),(47,'a:5:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"7\";s:5:\"ktype\";s:3:\"all\";}s:5:\"nname\";s:17:\"Als Special Finds\";s:6:\"cre_by\";s:1:\"2\";i:1;a:3:{s:5:\"ftype\";s:3:\"ftx\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"src\";s:5:\"shale\";}}','set','Shale Objects',0,'2','2011-08-25 21:42:40'),(58,'a:3:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"101\";s:2:\"bv\";s:1:\"1\";}}','set','Burial Subgroups',1,'2','2011-11-24 11:28:17'),(45,'a:2:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"7\";s:5:\"ktype\";s:3:\"all\";}}','set','All Special Finds',0,'2','2011-08-25 21:39:05'),(54,'a:2:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"1\";s:5:\"ktype\";s:3:\"all\";}}','set','CXTs',0,'2','2011-08-29 19:50:00'),(56,'a:2:{s:10:\"sort_order\";b:0;i:0;a:6:{s:5:\"ftype\";s:3:\"atr\";s:2:\"bv\";s:1:\"1\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:1:\"1\";s:3:\"atr\";s:3:\"209\";}}','set','Completed CXTs',0,'2','2011-08-30 16:51:51'),(57,'a:2:{s:10:\"sort_order\";b:0;i:0;a:6:{s:5:\"ftype\";s:3:\"atr\";s:2:\"bv\";s:1:\"1\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:1:\"1\";s:3:\"atr\";s:3:\"209\";}}','set','Completed CXTs',0,'2','2011-08-30 16:51:52'),(52,'a:3:{s:10:\"sort_order\";b:0;i:0;a:6:{s:5:\"ftype\";s:3:\"atr\";s:2:\"bv\";s:1:\"1\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:1:\"1\";s:3:\"atr\";s:1:\"1\";}i:1;a:4:{s:5:\"ftype\";s:3:\"key\";s:12:\"set_operator\";s:9:\"intersect\";s:3:\"key\";s:1:\"1\";s:5:\"ktype\";s:3:\"all\";}}','set','Compl. CXTs',0,'2','2011-08-25 23:16:21'),(59,'a:3:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"102\";s:2:\"bv\";s:1:\"1\";}}','set','Cremation Subgroups',1,'2','2011-11-24 13:32:44'),(60,'a:10:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"102\";s:2:\"bv\";s:1:\"1\";}s:5:\"nname\";s:19:\"Cremation Subgroups\";s:6:\"cre_by\";s:1:\"2\";s:9:\"feed_mode\";s:3:\"RSS\";s:5:\"limit\";i:25;s:9:\"feedtitle\";s:23:\"All Cremation Subgroups\";s:8:\"feeddesc\";s:30:\"A feed for cremation subgroups\";s:13:\"feeddisp_mode\";s:5:\"table\";}','feed','All Cremation Subgroups',0,'2','2012-09-25 18:35:43'),(61,'a:10:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"102\";s:2:\"bv\";s:1:\"1\";}s:5:\"nname\";s:19:\"Cremation Subgroups\";s:6:\"cre_by\";s:1:\"2\";s:9:\"feed_mode\";s:3:\"RSS\";s:5:\"limit\";i:25;s:9:\"feedtitle\";s:19:\"Cremation Subgroups\";s:8:\"feeddesc\";s:23:\"all cremation subgroups\";s:13:\"feeddisp_mode\";s:5:\"table\";}','feed','Cremation Subgroups',0,'2','2012-09-25 18:39:27'),(62,'a:10:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"102\";s:2:\"bv\";s:1:\"1\";}s:5:\"nname\";s:19:\"Cremation Subgroups\";s:6:\"cre_by\";s:1:\"2\";s:9:\"feed_mode\";s:3:\"RSS\";s:5:\"limit\";i:25;s:9:\"feedtitle\";s:4:\"blah\";s:8:\"feeddesc\";s:4:\"blah\";s:13:\"feeddisp_mode\";s:5:\"table\";}','feed','blah',0,'2','2012-09-25 18:43:14'),(63,'a:10:{s:10:\"sort_order\";b:0;i:0;a:4:{s:5:\"ftype\";s:3:\"key\";s:3:\"key\";s:1:\"8\";s:5:\"ktype\";s:3:\"all\";s:12:\"set_operator\";s:9:\"intersect\";}i:1;a:6:{s:5:\"ftype\";s:3:\"atr\";s:12:\"set_operator\";s:9:\"intersect\";s:10:\"op_display\";s:7:\"fauxdex\";s:7:\"atrtype\";s:2:\"18\";s:3:\"atr\";s:3:\"102\";s:2:\"bv\";s:1:\"1\";}s:5:\"nname\";s:19:\"Cremation Subgroups\";s:6:\"cre_by\";s:1:\"2\";s:9:\"feed_mode\";s:3:\"RSS\";s:5:\"limit\";i:25;s:9:\"feedtitle\";s:3:\"bla\";s:8:\"feeddesc\";s:3:\"bla\";s:13:\"feeddisp_mode\";s:5:\"table\";}','feed','bla',0,'2','2012-09-25 18:54:30');
/*!40000 ALTER TABLE `cor_tbl_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_markup`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_tbl_markup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nname` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `markup` text COLLATE utf8_unicode_ci NOT NULL,
  `mod_short` text COLLATE utf8_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '1',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=665 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_markup`
--

LOCK TABLES `cor_tbl_markup` WRITE;
/*!40000 ALTER TABLE `cor_tbl_markup` DISABLE KEYS */;
INSERT INTO `cor_tbl_markup` VALUES (88,'cxts','Contexts','cxt','en','Markup for showing contexts linked to other records in the xmi viewer',4,'2007-05-17 00:00:00'),(89,'site_photo','Site Photos','sph','en','Markup for displaying Site Photo',2,'2009-11-11 14:05:15'),(91,'interp','Interpretation','cxt','en','Markup for labelling the interpretation',4,'2007-05-17 00:00:00'),(92,'plan','Plan','pln','en','Markup for the micro viewer displaying drawn plans',4,'2007-05-18 00:00:00'),(97,'matrix','Stratigraphic Matrix','cxt','en','Markup for the display of the stratigraphic matrix',4,'2007-06-06 00:00:00'),(98,'othermatrix','Same as','cxt','en','Markup for displaying additional stratigraphic relationships not present in the matrix',2,'2009-11-11 14:06:04'),(99,'photo','Photos','sph','en','For displaying of photos for finds/arch elements, etc (ie anything not site photos or geophotos)',4,'2007-06-15 00:00:00'),(100,'note','Notes','spf','en','Notes for objects and architectural elements',4,'2007-06-15 00:00:00'),(103,'cxt_reg_instructions','Be careful when you are inputting stuff here','cxt','en','Markup for Context Instructions',4,'2007-06-15 00:00:00'),(104,'samplecondition','Condition of Deposit','smp','en','label for sample condition sf',75,'2008-06-13 09:11:07'),(105,'volume','Original Sample Volume','smp','en','label for volume subform',2,'2009-11-13 12:35:32'),(106,'samplequestions','Original Sample Questions','smp','en','label for questions subform',2,'2009-11-13 12:32:47'),(110,'samples','Samples','smp','en','label for samples',2,'2008-06-16 00:00:00'),(107,'subsamples_boolean','Subsample?','smp','en','label for subsample form',78,'2008-06-13 15:01:17'),(111,'objects','Objects','spf','en','A title for the special find xmi viewer',4,'2008-06-18 00:00:00'),(112,'smp_cxt_desc','Context Type (brief description)','smp','en','For a brief description of the context for sample sheets',2,'2008-06-25 00:00:00'),(113,'samplecontam','Sample contamination','smp','en','A label for the sample contamination sf',2,'2008-06-25 00:00:00'),(114,'samplevolprop','Sample size as proportion of deposit','smp','en','Label for sample proportion sf',2,'2008-06-25 00:00:00'),(115,'samplecontamdesc','Describe other contamination','smp','en','Label for othe contamination of sample description',2,'2008-06-25 00:00:00'),(116,'sphmeta','Photo Record Details','sph','en','A label to express the idea of sph meta info',2,'2008-07-01 00:00:00'),(117,'foundin','From Context','smp','en','A label for objects found in a context',2,'2008-07-02 00:00:00'),(118,'samplestatus','Sample Status','smp','en','markup for sample status',78,'2008-08-12 11:34:24'),(120,'notes','Processing Notes','smp','en','markup for notes form',2,'2009-11-13 12:35:01'),(121,'hf_numofbags','Number of Bags (Heavy Frac)','smp','en','labels for hf_numofbags',78,'2008-08-12 12:44:39'),(122,'lf_numofbags','Number of Bags (Light Frac)','smp','en','label for lf_numofbags',78,'2008-08-12 12:44:56'),(123,'numofbags','Number of Bags','smp','en','label for bag number',78,'2008-08-12 12:52:44'),(124,'fractionstatus','Fraction Status','smp','en','label for fraction status',78,'2008-08-12 12:51:59'),(162,'provperiod','Period (provis.)','cxt','en','Label for prov period sf',2,'2009-11-11 13:14:29'),(165,'lghfrac','Light Fraction','smp','en','Label for sf frame',2,'2009-11-13 12:27:38'),(166,'hvyfrac','Heavy Fraction','smp','en','Label for an sf frame',2,'2009-11-13 12:28:19'),(167,'smpdesc','Field Soil Description','smp','en','Label for sample sf',2,'2009-11-13 12:31:14'),(176,'basicinterp','Basic Interp.','cxt','en','Label for the basic interpretation',2,'2009-12-08 15:24:36'),(177,'sgrmatrix','Sub Group Matrix','sgr','en','Label for the subgroup matrix',2,'2009-12-08 15:25:09'),(179,'subgroup','Sub-group','sgr','en','Label for an xmi to subgroup sf',2,'2009-12-10 15:51:18'),(189,'rgfbasicinterp','Registered Find Basics','rgf','en','Label for the RGF mod',2,'2010-10-22 17:30:00'),(190,'rgfxmicxt','From Context','rgf','en','Label for reg finds',2,'2010-10-22 17:40:40'),(191,'rgfdispchars','Display Characteristics','rgf','en','Label for Reg finds',2,'2010-10-23 13:11:25'),(192,'xrayid','X-Ray ID','rgf','en','Label for rgf\'s',2,'2010-10-23 14:06:37'),(193,'rgfxmispf','Linked Special Finds','rgf','en','Label for rgf',2,'2010-10-23 14:48:02'),(194,'rgfcomment','Comments','rgf','en','Label for rgfs',2,'2010-10-23 14:59:35'),(195,'linkedrgfs','Reg. Finds','rgf','en','Label for SPFs',2,'2010-10-23 18:07:50'),(196,'sgrnarrative','Subgroup Narrative Text','sgr','en','A label for the Subgroups',2,'2010-11-30 15:16:14'),(207,'plancxt','Plan Context','pln','en','A label for subgroups',2,'2010-11-30 16:58:27'),(210,'datingnarrative','Dating Narrative','sgr','en','Label for SGRs',2,'2010-12-01 15:16:33'),(582,'basicinfo','Basic Information','sgr','en','Frame for basic information',4,'2011-06-23 17:12:33'),(583,'meta','Record Details','cxt','en','A record meta label',4,'2011-06-23 17:33:34'),(586,'sgr_plan','Subgroup Plan','sgr','en','A label for the SGR plan SF',2,'2011-08-25 22:16:33'),(591,'sgrs','Sub Groups','grp','en','A label for the GRP module',2,'2011-08-31 19:24:46'),(592,'grpmatrix','Group Matrix','grp','en','A label for the GRP module',2,'2011-08-31 19:26:59'),(593,'grpdatingnarrative','Dating Information','grp','en','A label for the GRP module',2,'2011-08-31 19:27:45'),(594,'grpnarrative','Group Description','grp','en','A label for the GRP module',2,'2011-08-31 19:28:10'),(595,'cxt_plan','Plan','cxt','en','A label for the CXT module',2,'2011-08-31 21:05:24'),(596,'group','Group','grp','en','A label for Group subforms',2,'2011-11-24 11:45:16'),(597,'phase','Phase','grp','en','A label for group phasing',2,'2011-12-08 12:04:21'),(614,'filterabk','Addressbook','abk','en','filter name',91,'2013-12-18 22:15:48'),(616,'filtercxt','Contexts','cxt','en','context filter name',91,'2014-02-13 15:33:26'),(625,'contextprocess','Process','cxt','en','title for Process subform',91,'2013-12-20 12:11:16'),(637,'cxtsheet','Context Sheet','cxt','en','tile for sf_file for context pdfs',91,'2014-02-10 19:22:02'),(638,'prntcontext','Parent Context','cxt','en','A context link that will provide spatial data where none is available',91,'2014-02-12 11:12:24'),(639,'contextassesment','Basic Interpretation and Process','cxt','en','title for a box containing the Basic Interp. code and the Process code',91,'2014-02-12 17:49:43'),(640,'shrgeom','Parent Context','cxt','en','Title to link to geometry',91,'2014-02-12 17:51:01'),(641,'filtergrp','Groups','grp','en','Filter Groups',91,'2014-02-13 15:33:55'),(642,'filtersgr','Sub Groups','sgr','en','Filter Subgroups',91,'2014-02-13 15:34:24'),(643,'filtersmp','Samples','smp','en','Filter Samples',91,'2014-02-13 15:34:49'),(644,'ftr_find_type','Find','cxt','en','Filter contexts based on finds',91,'2014-02-13 17:49:23'),(665,'spotdate','Spot Date','cxt','en','title fro spotdate sf',91,'2014-02-19 13:22:40');
/*!40000 ALTER TABLE `cor_tbl_markup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_tbl_module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cor_tbl_module` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `itemkey` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `shortform` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(3) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_tbl_module`
--

LOCK TABLES `cor_tbl_module` WRITE;
/*!40000 ALTER TABLE `cor_tbl_module` DISABLE KEYS */;
INSERT INTO `cor_tbl_module` VALUES (3,'sph_cd','mod_sph','sph','The Site Photo module',1,'2006-06-03 00:00:00'),(4,'pln_cd','mod_pln','pln','The Planning module',1,'2006-06-03 00:00:00'),(5,'abk_cd','mod_abk','abk','The Address Book Module',1,'2008-01-16 00:00:00'),(6,'smp_cd','mod_smp','smp','The Sample Module',1,'2008-01-16 00:00:00'),(7,'spf_cd','mod_spf','spf','The Special Finds Module',1,'2008-06-18 00:00:00'),(8,'sgr_cd','mod_sgr','sgr','The subroup module',1,'2009-12-08 00:00:00'),(9,'rgf_cd','mod_rgf','rgf','The Registered Finds Module',1,'0000-00-00 00:00:00'),(10,'cxt_cd','mod_cxt','cxt','A core module for adding markup and aliases',1,'2011-06-23 00:00:00'),(11,'grp_cd','mod_grp','grp','The Group module',1,'2011-08-30 00:00:00'),(12,'sec_cd','mod_sec','sec','The Sections module',1,'2011-08-30 00:00:00');
/*!40000 ALTER TABLE `cor_tbl_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxt_lut_cxttype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cxt_lut_cxttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cxttype` varchar(255) NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxt_lut_cxttype`
--

LOCK TABLES `cxt_lut_cxttype` WRITE;
/*!40000 ALTER TABLE `cxt_lut_cxttype` DISABLE KEYS */;
INSERT INTO `cxt_lut_cxttype` VALUES (1,'Cut',4,'2008-03-05 00:00:00'),(2,'Fill',4,'2008-03-05 00:00:00'),(3,'Masonry',4,'2008-03-05 00:00:00'),(4,'Skeleton',4,'2008-03-10 00:00:00'),(5,'Timber',4,'2008-06-25 00:00:00'),(7,'void',0,'0000-00-00 00:00:00'),(8,'Deposit',123,'2013-12-18 21:23:52'),(9,'Layer',123,'2014-02-13 00:00:00');
/*!40000 ALTER TABLE `cxt_lut_cxttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxt_phases`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cxt_phases` (
  `ste_cd` varchar(255) NOT NULL DEFAULT '',
  `cxt_no` varchar(255) NOT NULL DEFAULT '',
  `cxt_cd` varchar(255) NOT NULL DEFAULT '',
  `nname` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxt_phases`
--

LOCK TABLES `cxt_phases` WRITE;
/*!40000 ALTER TABLE `cxt_phases` DISABLE KEYS */;
/*!40000 ALTER TABLE `cxt_phases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxt_strat_rels`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cxt_strat_rels` (
  `uid` varchar(255) NOT NULL DEFAULT '',
  `ste_cd` varchar(255) NOT NULL DEFAULT '',
  `cxt_no` varchar(255) NOT NULL DEFAULT '',
  `beg` varchar(255) NOT NULL DEFAULT '',
  `end` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxt_strat_rels`
--

LOCK TABLES `cxt_strat_rels` WRITE;
/*!40000 ALTER TABLE `cxt_strat_rels` DISABLE KEYS */;
/*!40000 ALTER TABLE `cxt_strat_rels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cxt_tbl_cxt`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `cxt_tbl_cxt` (
  `cxt_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cxt_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cxttype` int(3) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cxt_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cxt_tbl_cxt`
--

LOCK TABLES `cxt_tbl_cxt` WRITE;
/*!40000 ALTER TABLE `cxt_tbl_cxt` DISABLE KEYS */;
/*!40000 ALTER TABLE `cxt_tbl_cxt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grp_tbl_grp`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `grp_tbl_grp` (
  `grp_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `grp_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`grp_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grp_tbl_grp`
--

LOCK TABLES `grp_tbl_grp` WRITE;
/*!40000 ALTER TABLE `grp_tbl_grp` DISABLE KEYS */;
/*!40000 ALTER TABLE `grp_tbl_grp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pln_tbl_pln`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `pln_tbl_pln` (
  `pln_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pln_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pln_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pln_tbl_pln`
--

LOCK TABLES `pln_tbl_pln` WRITE;
/*!40000 ALTER TABLE `pln_tbl_pln` DISABLE KEYS */;
/*!40000 ALTER TABLE `pln_tbl_pln` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rgf_lut_rgftype`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `rgf_lut_rgftype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rgftype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cre_by` int(11) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This lookup table supplys different types of text to be link';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rgf_lut_rgftype`
--

LOCK TABLES `rgf_lut_rgftype` WRITE;
/*!40000 ALTER TABLE `rgf_lut_rgftype` DISABLE KEYS */;
INSERT INTO `rgf_lut_rgftype` VALUES (1,'object',2,'0000-00-00 00:00:00'),(2,'coin',2,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `rgf_lut_rgftype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rgf_tbl_rgf`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `rgf_tbl_rgf` (
  `rgf_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rgf_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `rgftype` int(3) NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rgf_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rgf_tbl_rgf`
--

LOCK TABLES `rgf_tbl_rgf` WRITE;
/*!40000 ALTER TABLE `rgf_tbl_rgf` DISABLE KEYS */;
/*!40000 ALTER TABLE `rgf_tbl_rgf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sec_tbl_sec`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `sec_tbl_sec` (
  `sec_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sec_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sec_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sec_tbl_sec`
--

LOCK TABLES `sec_tbl_sec` WRITE;
/*!40000 ALTER TABLE `sec_tbl_sec` DISABLE KEYS */;
INSERT INTO `sec_tbl_sec` VALUES ('HGI11_1',1,'HGI11',91,'2014-02-21 12:04:28'),('HGI11_2',2,'HGI11',91,'2014-02-21 12:05:41'),('HGI11_3',3,'HGI11',91,'2014-02-21 12:09:30'),('HGI11_4',4,'HGI11',91,'2014-02-21 12:09:36'),('HGI11_31',31,'HGI11',91,'2014-02-21 12:19:56');
/*!40000 ALTER TABLE `sec_tbl_sec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sgr_tbl_sgr`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `sgr_tbl_sgr` (
  `sgr_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sgr_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sgr_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sgr_tbl_sgr`
--

LOCK TABLES `sgr_tbl_sgr` WRITE;
/*!40000 ALTER TABLE `sgr_tbl_sgr` DISABLE KEYS */;
/*!40000 ALTER TABLE `sgr_tbl_sgr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smp_tbl_smp`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `smp_tbl_smp` (
  `smp_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `smp_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`smp_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smp_tbl_smp`
--

LOCK TABLES `smp_tbl_smp` WRITE;
/*!40000 ALTER TABLE `smp_tbl_smp` DISABLE KEYS */;
/*!40000 ALTER TABLE `smp_tbl_smp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sph_tbl_sph`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `sph_tbl_sph` (
  `sph_cd` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sph_no` int(10) NOT NULL DEFAULT '0',
  `ste_cd` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cre_by` int(4) NOT NULL DEFAULT '0',
  `cre_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sph_cd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sph_tbl_sph`
--

LOCK TABLES `sph_tbl_sph` WRITE;
/*!40000 ALTER TABLE `sph_tbl_sph` DISABLE KEYS */;
/*!40000 ALTER TABLE `sph_tbl_sph` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-27 18:17:48
