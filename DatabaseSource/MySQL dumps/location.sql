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
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`loc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'the coffee shop','a cheap place to get coffee','low rent, New York coffee joint with booths and plastic covered seats'),(2,'Ennet House Drug and Alcohol Recovery centre','a rehabilitation centre','located near the Enfield Tennis Academy and home to all manner of recovering addicts, was once the scene of a shootout'),(3,'The Double R Diner','a small local diner, serves coffee and pie','local diner, known for coffee and cherry pie.'),(4,'Ghostwood National Forest','Forest surrounding a small town, known for strange occurences','known for strange occurences and unusual places, like Owl Cave and the Black Lodge'),(5,'The Great Northern Hotel','a large hotel with a rustic vibe','wood panelled walls and native american statues are common in the enormous hotel, as are strange occurences'),(6,'Owl Cave','Known for many owls inhabiting it','filled with ancient native American petroglyphs, contains a map behind a wall moved by a hidden mechanism'),(7,'The Dog Park','The Dog Park is host to the meetings of hooded figures.','You should not think about the Dog Park. Considering the existence of the Dog Park is a thought crime.'),(8,'The Black Lodge','Mysterious other wordly maze','Mysterious other worldly maze, host to many Twin Peaks residents'),(9,'the Town Hall','gathering place for bake sales and local politics','wood and plastic panelled building, with creaky chairs and folding tables inside');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-02  9:30:24
