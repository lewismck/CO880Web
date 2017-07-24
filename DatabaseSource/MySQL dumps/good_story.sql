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
-- Table structure for table `good_story`
--

DROP TABLE IF EXISTS `good_story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `good_story` (
  `story_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_sequence` text COLLATE utf8_unicode_ci NOT NULL,
  `location_sequence` text COLLATE utf8_unicode_ci NOT NULL,
  `action_sequence` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_story`
--

LOCK TABLES `good_story` WRITE;
/*!40000 ALTER TABLE `good_story` DISABLE KEYS */;
INSERT INTO `good_story` VALUES (1,'5','4','5'),(2,'6','4','5'),(3,'6','3','2'),(4,'6','5','1'),(5,'6','3','5'),(6,'5','5','4'),(7,'3','6','3'),(8,'5','2','4'),(9,'5','4','4'),(10,'5','4','3'),(11,'5','2','5'),(12,'6','1','2'),(13,'5','2','4'),(14,'6','5','4'),(15,'6','4','4'),(16,'6','3','1'),(17,'5','5','1'),(18,'6','6','3'),(19,'6','5','5'),(20,'3','4','5'),(21,'5','1','2'),(22,'5','2','1'),(23,'5','1','5'),(24,'9 9','9 9','9 9'),(25,'6','2','5'),(26,'5','2','2'),(27,'3','5','5'),(28,'6','1','4'),(29,'6','2','1'),(30,'6','3','3'),(31,'5','4','1');
/*!40000 ALTER TABLE `good_story` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-11 14:25:47
