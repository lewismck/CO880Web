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
-- Table structure for table `action_consequence`
--

DROP TABLE IF EXISTS `action_consequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_consequence` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `ac_id` int(11) DEFAULT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`con_id`),
  KEY `ac_id` (`ac_id`),
  CONSTRAINT `action_consequence_ibfk_1` FOREIGN KEY (`ac_id`) REFERENCES `action` (`ac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_consequence`
--

LOCK TABLES `action_consequence` WRITE;
/*!40000 ALTER TABLE `action_consequence` DISABLE KEYS */;
INSERT INTO `action_consequence` VALUES (1,1,'is embarassed after being seen to cry by','they stammer and try to stop themselves from sobbing','awkawrd'),(2,2,'becomes friends with','the time spent together is pleasant and the two develop a friendship','pleasant'),(3,3,'comes around after hallucinating, but is too terrified to talk to','after hallucinating they are unable to speak coherently and keep looking around somewhat erraticaly, unsettling','spooky'),(4,4,'has to hide the body of','searches for somewhere to dispose of the body, is worried about getting caught with','unsettling'),(5,5,'becomes infatuated with','continues to obsess over and follow','creepy');
/*!40000 ALTER TABLE `action_consequence` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-11 14:27:14
