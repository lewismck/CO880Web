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
-- Table structure for table `action`
--

DROP TABLE IF EXISTS `action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consequence` int(11) DEFAULT NULL,
  PRIMARY KEY (`ac_id`),
  KEY `consequence` (`consequence`),
  CONSTRAINT `action_ibfk_1` FOREIGN KEY (`consequence`) REFERENCES `action_consequence` (`con_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action`
--

LOCK TABLES `action` WRITE;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` VALUES (1,'cries in front of','starts to bow their head, lips quivering, eyes welling up, and begins to sob','sad',1),(2,'drinks coffee with','enjoys a cup of damn fine freshly brewed coffee','pleasant',2),(3,'hallucinates BOB in front of','Begins to stammer and point into thin air, then starts screaming','terrifying',3),(4,'murders','poisons with a blow dart','scary',4),(5,'stalks','begins following and cataloguing the movements and interactions of','creepy',5),(6,'considers the dog park near','considers the existence and purpose of the dog park, this is a thought crime, and is shocking to','spooky',6),(7,'listens to the Postal Service with','puts on records by the Postal Service and enjoys them with','nice',7),(8,'goes on a roadtrip with','hits the road, with some nice music and no real destination in mind with','exciting',8),(9,'chases','relentlessly runs after','scary',9),(10,'has a surreal dream involving','dreams something dark and mysterious featuring','spooky',10),(11,'enters the Black Lodge with','following clues and cryptic messages discovers an entrance to the Black Lodge with','spooky',11),(12,'is run over by','Hit by a truck whilst crossing the road and instantly killed','horrifying',12),(13,'goes exploring in the woods','heads into the woods in a spirit of adventure','exciting',13),(14,'buys a lottery ticket','purchases a ticket in the small stakes local lottery','exciting',14);
/*!40000 ALTER TABLE `action` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-02  9:24:49
