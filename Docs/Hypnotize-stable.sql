-- MySQL dump 10.11
--
-- Host: localhost    Database: THP
-- ------------------------------------------------------
-- Server version	5.0.51a-24+lenny4

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
-- Current Database: `THP`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `THP` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `THP`;

--
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `uuid` varchar(36) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$9cYY/oX8NRhdeGt5502Nq.qCgJbBC4pqWrA4JqwaqqCdvWe2tb3My',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

CREATE TABLE `Admin` (
  `id` int(11) NOT NULL auto_increment,
  `standalone` int(11) default NULL,
  `module` text NOT NULL,
  `module_name` text NOT NULL,
  `module_menu_name` text NOT NULL,
  `module_site` text NOT NULL,
  `enable` int(1) NOT NULL default '0',
  `site` text NOT NULL,
  `hidden` int(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (1,1,'','','','Moduler',0,'Moduler'),(2,1,'SInfo','Side innformasjon (Kun Linux)','','',1,''),(3,0,'DVD','DVD informasjons side','DVD','',0,''),(4,0,'Gjestebok','En gjestebok','Gjestebok','',0,''),(5,1,'Siste','Det siste innlegge fra \"Linker\" og \"Gjesteboka\" p&aring; hovedsiden','','',1,''),(6,0,'Linker','En linke side','Linker','',0,''),(7,0,'Mail','Send en mail til administratoren!','Mail::Admin','',0,''),(8,0,'Sok','En enkel lokal s&oslash;ke motor','S&oslash;k','',0,''),(9,0,'','','','Gjestebok',0,'Gjestebok'),(10,0,'','','','Linker',0,'Linker'),(11,NULL,'','','','DVD',0,'DVD'),(12,NULL,'','','','rmcat',0,'rmcat'),(13,NULL,'','',' ','addcat',0,'addcat'),(14,NULL,'','','','setconfig',0,'setconfig'),(15,NULL,'','','','edit',0,'edit'),(16,NULL,'','','','chpass',0,'chpass'),(17,NULL,'','','','editcat',0,'editcat');
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boxes`
--

DROP TABLE IF EXISTS `boxes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `boxes` (
  `id` int(11) NOT NULL auto_increment,
  `site` text NOT NULL,
  `catid` int(11) NOT NULL default '0',
  `position` char(1) NOT NULL default '',
  `headline` text NOT NULL,
  `uheadline` text NOT NULL,
  `sort_id` int(10) default '0',
  `link` text NOT NULL,
  `image` text NOT NULL,
  `module` text NOT NULL,
  `allsites` int(11) default '0',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `boxes`
--

LOCK TABLES `boxes` WRITE;
/*!40000 ALTER TABLE `boxes` DISABLE KEYS */;
INSERT INTO `boxes` VALUES (1,'',0,'','','',2147483647,'','','SInfo',1,''),(3,'DVD',0,'','','',0,'','','DVD',0,''),(4,'Gjestebok',0,'','','',0,'','','Gjestebok',0,''),(5,'Linker',0,'','','',0,'','','Linker',0,''),(6,'Mail',0,'','','',0,'','','Mail',0,''),(7,'0',0,'','','',2147483647,'','','Siste',0,''),(8,'Sok',0,'','','',0,'','','Sok',0,'');
/*!40000 ALTER TABLE `boxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `config` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `pagename` text NOT NULL,
  `maintenance` int(1) NOT NULL default '0',
  `maintenanceip` text NOT NULL,
  `dguestbook` int(1) NOT NULL default '0',
  `dlinks` int(1) NOT NULL default '0',
  `siteurl` text NOT NULL,
  `backend_description` text NOT NULL,
  `backend_language` text NOT NULL,
  `images` text NOT NULL,
  `style` text NOT NULL,
  `smtp_host` varchar(255) default NULL,
  `smtp_port` int(11) default '25',
  `smtp_user` varchar(255) default NULL,
  `smtp_pass` varchar(255) default NULL,
  `smtp_encryption` varchar(10) default NULL,
  `admin_email` varchar(255) default NULL,
  `watermark` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'The Hypnotize Project','The Hypnotize Project',0,'',0,0,'https://','','','/images','default', NULL, 25, NULL, NULL, NULL, NULL, 1);
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dvd`
--

DROP TABLE IF EXISTS `dvd`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dvd` (
  `id` int(11) NOT NULL auto_increment,
  `producers` text NOT NULL,
  `directors` text NOT NULL,
  `manufacturer` text NOT NULL,
  `rating` text NOT NULL,
  `dice` int(11) default NULL,
  `region` int(11) NOT NULL default '0',
  `format` text NOT NULL,
  `genre` text NOT NULL,
  `title` text NOT NULL,
  `actors` text NOT NULL,
  `year` text NOT NULL,
  `subtitles` text NOT NULL,
  `screen` text NOT NULL,
  `languages` text NOT NULL,
  `length` int(11) NOT NULL default '0',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_title` (`title`(50)),
  KEY `idx_year` (`year`(4))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `dvd`
--

LOCK TABLES `dvd` WRITE;
/*!40000 ALTER TABLE `dvd` DISABLE KEYS */;
/*!40000 ALTER TABLE `dvd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `ip` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `mail` text NOT NULL,
  `homepage` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `guestbook`
--

LOCK TABLES `guestbook` WRITE;
/*!40000 ALTER TABLE `guestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `links` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `ip` varchar(100) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `description` text NOT NULL,
  `link` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `site_id` text NOT NULL,
  `sitename` text NOT NULL,
  `sort_id` int(11) default '0',
  `break` int(1) default '0',
  `link` text NOT NULL,
  `hidden` int(1) default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_sort_id` (`sort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-10-30 22:22:03
