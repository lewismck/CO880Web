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
  `c1_es` int(11) DEFAULT NULL,
  `c2_es` int(11) DEFAULT NULL,
  `c1_es_desc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `c2_es_desc` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_dead` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invert_c1_c2` int(1) DEFAULT '0',
  `solo_action` int(1) DEFAULT '0',
  PRIMARY KEY (`con_id`),
  KEY `ac_id` (`ac_id`),
  CONSTRAINT `action_consequence_ibfk_1` FOREIGN KEY (`ac_id`) REFERENCES `action` (`ac_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_consequence`
--

LOCK TABLES `action_consequence` WRITE;
/*!40000 ALTER TABLE `action_consequence` DISABLE KEYS */;
INSERT INTO `action_consequence` VALUES (1,1,'is embarassed after being seen to cry by','they stammer and try to stop themselves from sobbing','awkawrd',-1,-1,'embarassed','awkward','x',0,0),(2,2,'becomes friends with','the time spent together is pleasant and the two develop a friendship','pleasant',1,1,'happy','happy','x',0,0),(3,3,'comes around after hallucinating, but is too terrified to talk to','after hallucinating they are unable to speak coherently and keep looking around somewhat erraticaly, unsettling','spooky',-1,-1,'terrified','confused','x',0,0),(4,4,'has to hide the body of','searches for somewhere to dispose of the body, is worried about getting caught with','unsettling',-1,-1,'is worried','is dead','c2',0,0),(5,5,'becomes infatuated with','continues to obsess over and follow','creepy',1,-1,'satisfied','paranoid','x',0,0),(6,6,'is quickly accosted by','is held in place, ready for questioning by the Sherrif\'s Secret Police by','scary',-1,1,'upset','useful','x',0,0),(7,7,'is relaxed and enjoys the time spent with','finds a new appreciation for electro themed indie pop alongside ','pleasant',1,1,'happy','happy','x',0,0),(8,8,'drives into the sunset with','cruises into the sunset, with a nice playlist and','pleasant',1,1,'happy','happy','x',0,0),(9,9,'catches','finally catches and grabs','scary',1,-1,'excited','scared','x',0,0),(10,10,'awakes and can\'t stop thinking about','wakes up sweaty and unable to concentrate, they feel the need to talk to','scary',-1,1,'scared','unaware','x',0,0),(11,11,'is lost in the Black Lodge with','is unable to find a way out of the mysterious labarynthine surroundings','scary',-1,-1,'terrified','terrified','x',0,0),(12,12,'struggles to control the vehicle, then speeds off, leaving','the truck nearly crashes off the road, before it regains control and continues on it\'s way','scary',-2,-1,'is dead','worried','c1',1,0),(13,13,'gets lost','after hours wandering, realises they have no idea of the way out','spooky',-1,-1,'worried','worried','x',0,1),(14,14,'wins the local lottery','collects their winnings and is ecstacic with the outcome','exciting',1,1,'excited','excited','x',0,1);
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

-- Dump completed on 2017-08-02  9:25:10
