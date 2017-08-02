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
-- Table structure for table `s_character`
--

DROP TABLE IF EXISTS `s_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `s_character` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `c_desc` int(11) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  KEY `s_character` (`c_desc`),
  CONSTRAINT `s_character_ibfk_1` FOREIGN KEY (`c_desc`) REFERENCES `character_desc` (`desc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_character`
--

LOCK TABLES `s_character` WRITE;
/*!40000 ALTER TABLE `s_character` DISABLE KEYS */;
INSERT INTO `s_character` VALUES (1,'Kate','Gompert','f',1),(2,'George','Costanza','m',2),(3,'Dale','Cooper','m',3),(4,'Harry','Truman','m',4),(5,'Laura','Palmer','f',5),(6,'Leland','Palmer','m',6),(7,'Benjamin','Horne','m',7),(8,'Audrey','Horne','f',8),(9,'Log','Lady','f',9),(10,'Dr. Lawrence','Jacoby','m',10),(11,'The Sherrif\'s Secret Police',' ','?',11),(12,'The Glow Cloud',' ','?',12),(13,'Bobby','Briggs','M',13);
/*!40000 ALTER TABLE `s_character` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-02  9:30:54
