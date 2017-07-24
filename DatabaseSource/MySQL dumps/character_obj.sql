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
-- Table structure for table `character_obj`
--

DROP TABLE IF EXISTS `character_obj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `character_obj` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `charObj` text COLLATE utf8_unicode_ci NOT NULL,
  `story_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `character_obj_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `good_story` (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `character_obj`
--

LOCK TABLES `character_obj` WRITE;
/*!40000 ALTER TABLE `character_obj` DISABLE KEYS */;
INSERT INTO `character_obj` VALUES (1,'O:6:\"Person\":8:{s:7:\"isAlive\";b:1;s:2:\"id\";s:1:\"7\";s:9:\"firstname\";s:8:\"Benjamin\";s:8:\"lastname\";s:5:\"Horne\";s:6:\"gender\";s:1:\"m\";s:6:\"descID\";s:1:\"7\";s:3:\"age\";s:2:\"47\";s:10:\"temperment\";s:58:\"Wealthy business owner, proprietor of Great Northern Hotel\";}',NULL),(2,'O:6:\"Person\":8:{s:7:\"isAlive\";b:1;s:2:\"id\";s:1:\"4\";s:9:\"firstname\";s:5:\"Harry\";s:8:\"lastname\";s:6:\"Truman\";s:6:\"gender\";s:1:\"m\";s:6:\"descID\";s:1:\"4\";s:3:\"age\";s:2:\"37\";s:10:\"temperment\";s:50:\"Respected sheriff, head of local police department\";}',NULL);
/*!40000 ALTER TABLE `character_obj` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-11 14:28:32
