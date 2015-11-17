-- Progettazione Web 
DROP DATABASE if exists tia; 
CREATE DATABASE tia; 
USE tia; 
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: tia
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `email` varchar(45) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `cognome` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `indirizzo` varchar(45) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES ('admin@terrazzo.com','amministratore','amministratore','admin','2131232132','locale'),('alberto@gmail.com','alberto','mimi','mimi','3323232322','matteotti '),('ale@gmail.com','ale','leoni','ale','3333333333','matteotti 8'),('damiano@hotmail.it','damiano','barone','damiano','3333825717','monti iblei'),('tommaso@hotmail.it','tommaso','zaccone','tommy','2321312312','corso italia');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizze`
--

DROP TABLE IF EXISTS `pizze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizze` (
  `idpizza` int(11) NOT NULL AUTO_INCREMENT,
  `ingredienti` varchar(70) NOT NULL,
  `prezzo` double NOT NULL,
  `nomepizza` varchar(45) NOT NULL,
  PRIMARY KEY (`idpizza`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizze`
--

LOCK TABLES `pizze` WRITE;
/*!40000 ALTER TABLE `pizze` DISABLE KEYS */;
INSERT INTO `pizze` VALUES (21,'pomodoro mozzarella',3,'margherita'),(22,'pomodoro mozzarella',3.5,'margherita'),(23,'pomodoro mozzarella',9,'margherita'),(33,'pomodoro',2.5,'marinara'),(34,'pomodoro',3,'marinara'),(35,'pomodoro',7,'marinara'),(36,'pomodoro mozzarella tonno',3.5,'Tonno'),(37,'pomodoro mozzarella tonno',4,'Tonno'),(38,'pomodoro mozzarella tonno',10,'Tonno'),(42,'pomodoro mozzarella rucola gamberetti salsa rosa',5,'Casuzze'),(43,'pomodoro mozzarella rucola gamberetti salsa rosa',6,'Casuzze'),(44,'pomodoro mozzarella rucola gamberetti salsa rosa',14,'Casuzze'),(45,'pomodoro mozzarella prosciutto crudo ',4,'Crudo'),(46,'pomodoro mozzarella prosciutto crudo ',5,'Crudo'),(47,'pomodoro mozzarella prosciutto crudo ',13,'Crudo'),(48,'mozzarella ciliegino crudo grana',4,'Rustica'),(49,'mozzarella ciliegino crudo grana',5,'Rustica'),(50,'mozzarella ciliegino crudo grana',13,'Rustica'),(51,'mozzarella',3,'Biancaneve'),(52,'mozzarella',4,'Biancaneve'),(53,'mozzarella',12,'Biancaneve'),(54,'pomodoro frutti di mare',6,'Pescatore'),(55,'pomodoro frutti di mare',7,'Pescatore'),(56,'pomodoro frutti di mare',14,'Pescatore'),(57,'pomodoro mozarella gorgonzola salsiccia noci',4.5,'Damiano'),(58,'pomodoro mozarella gorgonzola salsiccia noci',5.5,'Damiano'),(59,'pomodoro mozarella gorgonzola salsiccia noci',13,'Damiano'),(60,'pomodoro mozzarella wurstel uovo',4,'Tedesca'),(61,'pomodoro mozzarella wurstel uovo',5,'Tedesca'),(62,'pomodoro mozzarella wurstel uovo',13,'Tedesca'),(63,'pomodoro mozzarella patatine',4,'Patapizza'),(64,'pomodoro mozzarella patatine',4.5,'Patapizza'),(65,'pomodoro mozzarella patatine',13,'Patapizza'),(66,'mozzarella emmental cipolla carne di cacallo',6,'Scaccione'),(67,'mozzarella emmental cipolla carne di cacallo',7,'Scaccione'),(68,'mozzarella emmental cipolla carne di cacallo',14,'Scaccione');
/*!40000 ALTER TABLE `pizze` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizzeprenotate`
--

DROP TABLE IF EXISTS `pizzeprenotate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizzeprenotate` (
  `idprenotazione` int(11) NOT NULL,
  `idpizza` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpizza`,`idprenotazione`),
  KEY `idpizza_idx` (`idpizza`),
  KEY `idprenotazione` (`idprenotazione`),
  CONSTRAINT `idprenotazione` FOREIGN KEY (`idprenotazione`) REFERENCES `prenotazione` (`idprenotazione`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizzeprenotate`
--

LOCK TABLES `pizzeprenotate` WRITE;
/*!40000 ALTER TABLE `pizzeprenotate` DISABLE KEYS */;
INSERT INTO `pizzeprenotate` VALUES (90,21,2),(91,21,1),(92,21,1),(95,21,5),(98,21,2),(100,21,1),(105,21,1),(93,22,1),(94,22,3),(96,22,3),(97,22,1),(104,22,1),(107,22,1),(95,23,3),(90,33,4),(91,33,2),(98,33,3),(100,33,2),(101,33,1),(103,33,1),(107,33,1),(108,33,1),(94,34,2),(97,34,2),(98,34,1),(99,34,1),(103,34,1),(104,34,1),(106,34,3),(92,35,1),(93,35,3),(97,35,3),(106,35,3),(90,36,1),(91,36,2),(98,36,3),(100,36,1),(101,36,2),(102,36,1),(103,36,1),(108,36,1),(93,37,3),(100,37,2),(107,37,1),(106,38,1),(99,42,3),(102,42,3),(110,42,3),(108,43,1),(108,46,1),(111,56,1),(111,58,1),(109,60,1),(109,65,1);
/*!40000 ALTER TABLE `pizzeprenotate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prenotazione`
--

DROP TABLE IF EXISTS `prenotazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prenotazione` (
  `idprenotazione` int(11) NOT NULL AUTO_INCREMENT,
  `dataprenotazione` datetime NOT NULL,
  `email` varchar(45) NOT NULL,
  `completata` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`idprenotazione`),
  KEY `email_idx` (`email`),
  CONSTRAINT `email` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prenotazione`
--

LOCK TABLES `prenotazione` WRITE;
/*!40000 ALTER TABLE `prenotazione` DISABLE KEYS */;
INSERT INTO `prenotazione` VALUES (90,'2013-10-22 14:00:11','damiano@hotmail.it',''),(91,'2013-10-22 14:00:16','damiano@hotmail.it',''),(92,'2013-10-22 14:22:21','damiano@hotmail.it',''),(93,'2013-10-23 16:36:32','damiano@hotmail.it',''),(94,'2013-10-23 16:45:37','damiano@hotmail.it',''),(95,'2013-10-23 16:55:37','damiano@hotmail.it',''),(96,'2013-10-23 16:56:24','damiano@hotmail.it',''),(97,'2013-10-23 18:32:09','damiano@hotmail.it',''),(98,'2013-10-23 18:47:41','damiano@hotmail.it',''),(99,'2013-11-05 15:35:05','damiano@hotmail.it',''),(100,'2013-11-05 15:39:43','damiano@hotmail.it',''),(101,'2013-11-05 15:44:41','damiano@hotmail.it',''),(102,'2013-11-05 15:44:58','damiano@hotmail.it',''),(103,'2013-11-05 15:45:19','damiano@hotmail.it',''),(104,'2013-11-05 15:46:42','damiano@hotmail.it',''),(105,'2013-11-05 15:48:18','damiano@hotmail.it',''),(106,'2013-11-05 15:54:14','damiano@hotmail.it',''),(107,'2013-11-05 16:19:14','damiano@hotmail.it',''),(108,'2013-11-05 16:57:28','ale@gmail.com','\0'),(109,'2013-11-05 16:57:51','ale@gmail.com','\0'),(110,'2013-11-05 16:58:46','alberto@gmail.com','\0'),(111,'2013-11-05 17:00:29','damiano@hotmail.it','\0');
/*!40000 ALTER TABLE `prenotazione` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-05 17:04:44
