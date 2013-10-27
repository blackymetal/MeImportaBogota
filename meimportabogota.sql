-- MySQL dump 10.11
--
-- Host: localhost    Database: meimportabogota
-- ------------------------------------------------------
-- Server version	5.0.96

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
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` int(10) default NULL,
  `alias` varchar(255) default NULL,
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acos`
--

LOCK TABLES `acos` WRITE;
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` VALUES (1,NULL,NULL,NULL,'controllers',1,24),(2,1,NULL,NULL,'Users',2,11),(18,1,NULL,NULL,'Reports',12,23),(19,18,NULL,NULL,'admin_index',13,14),(20,18,NULL,NULL,'admin_add',15,16),(21,18,NULL,NULL,'admin_edit',17,18),(22,18,NULL,NULL,'admin_delete',19,20),(23,2,NULL,NULL,'admin_index',3,4),(24,2,NULL,NULL,'admin_add',5,6),(25,2,NULL,NULL,'admin_edit',7,8),(26,2,NULL,NULL,'admin_delete',9,10),(27,18,NULL,NULL,'admin_list_json',21,22);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) default NULL,
  `model` varchar(255) default NULL,
  `foreign_key` int(10) default NULL,
  `alias` varchar(255) default NULL,
  `lft` int(10) default NULL,
  `rght` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros`
--

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` VALUES (1,NULL,'Group',1,'Superusuario',1,4),(5,1,'User',1,NULL,2,3);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL auto_increment,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL default '0',
  `_read` varchar(2) NOT NULL default '0',
  `_update` varchar(2) NOT NULL default '0',
  `_delete` varchar(2) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aros_acos`
--

LOCK TABLES `aros_acos` WRITE;
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` VALUES (1,1,1,'1','1','1','1');
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Superuser',NULL,NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutions`
--

LOCK TABLES `institutions` WRITE;
/*!40000 ALTER TABLE `institutions` DISABLE KEYS */;
INSERT INTO `institutions` VALUES (1,'IDU',NULL,NULL);
/*!40000 ALTER TABLE `institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(10) default NULL,
  `area` text,
  `caseclosed` tinyint(1) default '0',
  `gps` varchar(255) default NULL,
  `modified` datetime default NULL,
  `created` datetime default NULL,
  `lat` double(15,12) default NULL,
  `lng` double(15,12) default NULL,
  `reporttype_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (2,'','4.7673253586497,-74.046828117454;4.7675407480743,-74.046828117454;4.7673253586497,-74.046972804208;4.7675407480743,-74.046972804208',0,'4.767406, 4.767406','2013-10-27 04:09:06','2013-10-27 04:09:06',4.767406000000,-74.046949000000,NULL),(3,'','4.7673253586497,-74.046828117454;4.7675407480743,-74.046828117454;4.7673253586497,-74.046972804208;4.7675407480743,-74.046972804208',0,'4.767406,-74.046949','2013-10-27 04:45:25','2013-10-27 04:45:25',4.767406000000,-74.046949000000,1);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL COMMENT 'pequeña descripción',
  `gps` varchar(255) default NULL,
  `image` varchar(255) default NULL,
  `lat` double(15,12) default NULL,
  `lng` double(15,12) default NULL,
  `reporttype_id` int(11) unsigned default NULL,
  `reconfirmed` int(11) unsigned default '1',
  `email` varchar(255) default NULL,
  `location_id` int(11) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'hueco','4.767406,-74.046949',NULL,4.767486000000,-74.046949000000,1,1,NULL,1,NULL),(2,'hueco2','4.767406000001,-74.046949000001',NULL,4.767706040004,-74.048000000000,1,1,NULL,1,NULL),(3,NULL,NULL,'682720663.jpg',4.767496000000,-74.046969000000,2,1,NULL,NULL,'0000-00-00 00:00:00'),(7,NULL,NULL,'471262866.jpg',4.767406000000,-74.046949000000,1,1,NULL,2,'2013-10-27 04:10:21'),(8,NULL,NULL,'159739224.jpg',4.767406000000,-74.046949000000,1,1,NULL,2,'2013-10-27 04:15:20'),(9,NULL,NULL,'1061542263.jpg',4.767406000000,-74.046949000000,1,1,NULL,2,'2013-10-27 04:16:42'),(10,NULL,'4.767406,-74.046949','1281536839.jpg',4.767406000000,-74.046949000000,1,1,NULL,2,'2013-10-27 04:17:44'),(11,NULL,'4.767406,-74.046949','1911894365.jpg',4.767406000000,-74.046949000000,1,1,NULL,3,'2013-10-27 04:45:25'),(12,NULL,'4.767406,-74.046949','168334213.jpg',4.767406000000,-74.046949000000,1,1,NULL,3,'2013-10-27 04:45:47');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporttypes`
--

DROP TABLE IF EXISTS `reporttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporttypes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `icon` varchar(255) default NULL,
  `institution_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporttypes`
--

LOCK TABLES `reporttypes` WRITE;
/*!40000 ALTER TABLE `reporttypes` DISABLE KEYS */;
INSERT INTO `reporttypes` VALUES (1,'Hueco',NULL,1);
/*!40000 ALTER TABLE `reporttypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `email` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `group_id` int(11) default NULL,
  `active` tinyint(1) default '1',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `institution_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ariel','ariel@ficticio.com','43c4430524d4e16e28aeaf8c6eb9af5cb70a6fea',1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-27  4:46:10
