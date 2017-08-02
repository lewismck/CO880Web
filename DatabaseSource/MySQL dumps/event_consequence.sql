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
-- Table structure for table `event_consequence`
--

DROP TABLE IF EXISTS `event_consequence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_consequence` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `brief` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_desc` text COLLATE utf8_unicode_ci,
  `tone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`con_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_consequence_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_consequence`
--

LOCK TABLES `event_consequence` WRITE;
/*!40000 ALTER TABLE `event_consequence` DISABLE KEYS */;
INSERT INTO `event_consequence` VALUES (1,3,'Out of town investigators arrive and everyone is a suspect','an FBI agent is called from out of town to aid in the investigation, murder is suspected and everyone\'s secrets are at risk as they\'re placed under scrutiny of the law','unsettling'),(3,5,'More police arrive in town from all accross the country','as police presence increases and scrutiny on the locals rises, the atmosphere becomes unpleasant','unsettling'),(4,6,'the sawmill is burned to the ground overnight, the town is shocked','The sawmill is set ablaze late at night and burns throroughly before any authorities can arrive. It seems no one was harmed, but the mill is no more and there\'s little evidence','shocking'),(5,7,'the expeted frontrunner is elected','everybody expected them to win, why wouldn\'t they, they were the best choice','unsurprising'),(6,8,'several locals go missing in the mists','with the fog this thick, several locals are not accounted for','sad'),(7,9,'around town people are bemused by the sounds','people struggle to locate the source of the sound, it seems ever present and is hard to pin down','spooky'),(8,10,'the storm arrives, bringing hammering rain and deafening thunder','thunder and lightening deafen and blind the residents who look into the storm','scary');
/*!40000 ALTER TABLE `event_consequence` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-02  9:25:59
