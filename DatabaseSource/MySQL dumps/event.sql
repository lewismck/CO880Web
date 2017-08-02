-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: dragon.kent.ac.uk    Database: lam54
-- ------------------------------------------------------
-- Server version	5.5.55-0ubuntu0.14.04.1

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
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `brief` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `consequence` (`consequence`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `event_consequence` (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (3,'The body of a local is found','The discovery of a body sparks an investigation involving the FBI and the local Sherrifs, unsettling the whole town.','unsettling',1),(5,'A town wide drug smuggling operation is revealed','A border crossing drug dealing empire is uncovered, probably involving several local businesses and prominent figures','surprising',3),(6,'A plot to burn down the Sawmill is hatched','An unknown group, or possibly a lone actor has begun to work on a way to burn down the local saw mill, perhaps for insurance or revenge','exciting',4),(7,'a local election is held','an election is held to elect new local council members','surprising',5),(8,'a creeping fog rolls into town','a thick, creeping fog that severly limits vision swallows the town','creepy',6),(9,'static sounds emenate from all electrical sockets','all sources of electricity emanate a strange, clicking and buzzing static sound for no discernible reason','weird',7),(10,'A storm looms on the horizon','black clouds and lightening can be seen in the distance, heading towards town','ominous',8);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-02  9:26:11
