-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: prestashop
-- ------------------------------------------------------
-- Server version	11.4.5-MariaDB-ubu2404

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ps_access`
--

DROP TABLE IF EXISTS `ps_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_access` (
                           `id_profile` int(10) unsigned NOT NULL,
                           `id_tab` int(10) unsigned NOT NULL,
                           `view` int(11) NOT NULL,
                           `add` int(11) NOT NULL,
                           `edit` int(11) NOT NULL,
                           `delete` int(11) NOT NULL,
                           PRIMARY KEY (`id_profile`,`id_tab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_access`
--

LOCK TABLES `ps_access` WRITE;
/*!40000 ALTER TABLE `ps_access` DISABLE KEYS */;
INSERT INTO `ps_access` VALUES (1,0,1,1,1,1),(1,1,1,1,1,1),(1,5,1,1,1,1),(1,7,1,1,1,1),(1,9,1,1,1,1),(1,10,1,1,1,1),(1,11,1,1,1,1),(1,13,1,1,1,1),(1,14,1,1,1,1),(1,15,1,1,1,1),(1,16,1,1,1,1),(1,19,1,1,1,1),(1,20,1,1,1,1),(1,21,1,1,1,1),(1,22,1,1,1,1),(1,23,1,1,1,1),(1,24,1,1,1,1),(1,25,1,1,1,1),(1,26,1,1,1,1),(1,27,1,1,1,1),(1,28,1,1,1,1),(1,29,1,1,1,1),(1,31,1,1,1,1),(1,32,1,1,1,1),(1,33,1,1,1,1),(1,34,1,1,1,1),(1,35,1,1,1,1),(1,36,1,1,1,1),(1,38,1,1,1,1),(1,39,1,1,1,1),(1,40,1,1,1,1),(1,41,1,1,1,1),(1,42,1,1,1,1),(1,44,1,1,1,1),(1,45,1,1,1,1),(1,48,1,1,1,1),(1,50,1,1,1,1),(1,52,1,1,1,1),(1,53,1,1,1,1),(1,54,1,1,1,1),(1,55,1,1,1,1),(1,56,1,1,1,1),(1,57,1,1,1,1),(1,58,1,1,1,1),(1,59,1,1,1,1),(1,61,1,1,1,1),(1,62,1,1,1,1),(1,63,1,1,1,1),(1,66,1,1,1,1),(1,67,1,1,1,1),(1,68,1,1,1,1),(1,69,1,1,1,1),(1,70,1,1,1,1),(1,71,1,1,1,1),(1,73,1,1,1,1),(1,74,1,1,1,1),(1,75,1,1,1,1),(1,76,1,1,1,1),(1,77,1,1,1,1),(1,78,1,1,1,1),(1,80,1,1,1,1),(1,81,1,1,1,1),(1,82,1,1,1,1),(1,83,1,1,1,1),(1,84,1,1,1,1),(1,86,1,1,1,1),(1,87,1,1,1,1),(1,88,1,1,1,1),(1,89,1,1,1,1),(1,92,1,1,1,1),(1,93,1,1,1,1),(1,94,1,1,1,1),(1,95,1,1,1,1),(1,96,1,1,1,1),(1,99,1,1,1,1),(1,100,1,1,1,1),(1,101,1,1,1,1),(1,102,1,1,1,1),(1,103,1,1,1,1),(1,104,1,1,1,1),(1,105,1,1,1,1),(1,106,1,1,1,1),(1,107,1,1,1,1),(2,0,1,1,1,1),(2,1,0,0,0,0),(2,2,0,0,0,0),(2,3,0,0,0,0),(2,4,0,0,0,0),(2,5,0,0,0,0),(2,6,0,0,0,0),(2,7,0,0,0,0),(2,8,0,0,0,0),(2,9,1,1,1,1),(2,10,1,1,1,1),(2,11,1,1,1,1),(2,12,0,0,0,0),(2,13,1,0,1,0),(2,14,1,1,1,1),(2,15,0,0,0,0),(2,16,0,0,0,0),(2,17,0,0,0,0),(2,18,0,0,0,0),(2,19,0,0,0,0),(2,20,1,1,1,1),(2,21,1,1,1,1),(2,22,1,1,1,1),(2,23,1,1,1,1),(2,24,0,0,0,0),(2,25,0,0,0,0),(2,26,0,0,0,0),(2,27,1,1,1,1),(2,28,0,0,0,0),(2,29,0,0,0,0),(2,30,1,1,1,1),(2,31,1,1,1,1),(2,32,1,1,1,1),(2,33,1,1,1,1),(2,34,1,1,1,1),(2,35,1,1,1,1),(2,36,0,0,0,0),(2,37,1,1,1,1),(2,38,1,1,1,1),(2,39,0,0,0,0),(2,40,0,0,0,0),(2,41,0,0,0,0),(2,42,0,0,0,0),(2,43,0,0,0,0),(2,44,0,0,0,0),(2,45,0,0,0,0),(2,46,0,0,0,0),(2,47,0,0,0,0),(2,48,1,1,1,1),(2,49,1,1,1,1),(2,50,0,0,0,0),(2,51,0,0,0,0),(2,52,0,0,0,0),(2,53,0,0,0,0),(2,54,0,0,0,0),(2,55,0,0,0,0),(2,56,0,0,0,0),(2,57,0,0,0,0),(2,58,0,0,0,0),(2,59,0,0,0,0),(2,60,1,0,1,0),(2,61,0,0,0,0),(2,62,0,0,0,0),(2,63,0,0,0,0),(2,64,0,0,0,0),(2,65,0,0,0,0),(2,66,0,0,0,0),(2,67,0,0,0,0),(2,68,0,0,0,0),(2,69,0,0,0,0),(2,70,0,0,0,0),(2,71,0,0,0,0),(2,72,0,0,0,0),(2,73,0,0,0,0),(2,74,0,0,0,0),(2,75,0,0,0,0),(2,76,0,0,0,0),(2,77,0,0,0,0),(2,78,0,0,0,0),(2,79,0,0,0,0),(2,80,0,0,0,0),(2,81,0,0,0,0),(2,82,0,0,0,0),(2,83,0,0,0,0),(2,84,0,0,0,0),(2,85,0,0,0,0),(2,86,0,0,0,0),(2,87,0,0,0,0),(2,88,0,0,0,0),(2,89,0,0,0,0),(2,90,0,0,0,0),(2,91,0,0,0,0),(2,92,0,0,0,0),(2,93,0,0,0,0),(2,94,1,1,1,1),(2,95,1,1,1,1),(2,96,1,1,1,1),(2,97,0,0,0,0),(2,98,0,0,0,0),(2,99,1,1,1,1),(2,100,1,1,1,1),(2,101,0,0,0,0),(2,102,0,0,0,0),(2,103,0,0,0,0),(2,104,0,0,0,0),(2,105,0,0,0,0),(2,106,0,0,0,0),(2,107,0,0,0,0),(3,0,1,1,1,1),(3,1,0,0,0,0),(3,2,0,0,0,0),(3,3,0,0,0,0),(3,4,0,0,0,0),(3,5,1,0,0,0),(3,6,0,0,0,0),(3,7,0,0,0,0),(3,8,0,0,0,0),(3,9,1,1,1,1),(3,10,0,0,0,0),(3,11,0,0,0,0),(3,12,0,0,0,0),(3,13,0,0,0,0),(3,14,0,0,0,0),(3,15,1,0,0,0),(3,16,1,0,0,0),(3,17,0,0,0,0),(3,18,0,0,0,0),(3,19,0,0,0,0),(3,20,0,0,0,0),(3,21,1,1,1,1),(3,22,1,1,1,1),(3,23,0,0,0,0),(3,24,0,0,0,0),(3,25,0,0,0,0),(3,26,0,0,0,0),(3,27,0,0,0,0),(3,28,0,0,0,0),(3,29,0,0,0,0),(3,30,0,0,0,0),(3,31,0,0,0,0),(3,32,0,0,0,0),(3,33,0,0,0,0),(3,34,0,0,0,0),(3,35,0,0,0,0),(3,36,0,0,0,0),(3,37,0,0,0,0),(3,38,0,0,0,0),(3,39,0,0,0,0),(3,40,0,0,0,0),(3,41,0,0,0,0),(3,42,0,0,0,0),(3,43,0,0,0,0),(3,44,0,0,0,0),(3,45,0,0,0,0),(3,46,0,0,0,0),(3,47,0,0,0,0),(3,48,0,0,0,0),(3,49,0,0,0,0),(3,50,0,0,0,0),(3,51,0,0,0,0),(3,52,0,0,0,0),(3,53,0,0,0,0),(3,54,0,0,0,0),(3,55,0,0,0,0),(3,56,0,0,0,0),(3,57,0,0,0,0),(3,58,0,0,0,0),(3,59,1,1,1,1),(3,60,0,0,0,0),(3,61,0,0,0,0),(3,62,0,0,0,0),(3,63,0,0,0,0),(3,64,0,0,0,0),(3,65,0,0,0,0),(3,66,0,0,0,0),(3,67,0,0,0,0),(3,68,0,0,0,0),(3,69,0,0,0,0),(3,70,1,1,1,1),(3,71,0,0,0,0),(3,72,0,0,0,0),(3,73,0,0,0,0),(3,74,0,0,0,0),(3,75,0,0,0,0),(3,76,0,0,0,0),(3,77,0,0,0,0),(3,78,0,0,0,0),(3,79,0,0,0,0),(3,80,0,0,0,0),(3,81,0,0,0,0),(3,82,0,0,0,0),(3,83,0,0,0,0),(3,84,0,0,0,0),(3,85,0,0,0,0),(3,86,0,0,0,0),(3,87,0,0,0,0),(3,88,0,0,0,0),(3,89,0,0,0,0),(3,90,0,0,0,0),(3,91,0,0,0,0),(3,92,0,0,0,0),(3,93,0,0,0,0),(3,94,0,0,0,0),(3,95,0,0,0,0),(3,96,0,0,0,0),(3,97,0,0,0,0),(3,98,0,0,0,0),(3,99,0,0,0,0),(3,100,0,0,0,0),(3,101,0,0,0,0),(3,102,0,0,0,0),(3,103,0,0,0,0),(3,104,0,0,0,0),(3,105,0,0,0,0),(3,106,0,0,0,0),(3,107,0,0,0,0),(4,0,1,1,1,1),(4,1,0,0,0,0),(4,2,0,0,0,0),(4,3,0,0,0,0),(4,4,0,0,0,0),(4,5,1,0,0,0),(4,6,0,0,0,0),(4,7,0,0,0,0),(4,8,0,0,0,0),(4,9,1,1,1,1),(4,10,1,1,1,1),(4,11,1,1,1,1),(4,12,0,0,0,0),(4,13,1,0,1,0),(4,14,0,0,0,0),(4,15,0,0,0,0),(4,16,0,0,0,0),(4,17,0,0,0,0),(4,18,0,0,0,0),(4,19,1,1,1,1),(4,20,1,0,0,0),(4,21,1,1,1,1),(4,22,1,1,1,1),(4,23,0,0,0,0),(4,24,0,0,0,0),(4,25,0,0,0,0),(4,26,1,0,0,0),(4,27,0,0,0,0),(4,28,0,0,0,0),(4,29,0,0,0,0),(4,30,1,1,1,1),(4,31,1,1,1,1),(4,32,0,0,0,0),(4,33,0,0,0,0),(4,34,1,1,1,1),(4,35,0,0,0,0),(4,36,1,1,1,1),(4,37,1,1,1,1),(4,38,1,1,1,1),(4,39,1,1,1,1),(4,40,1,1,1,1),(4,41,0,0,0,0),(4,42,0,0,0,0),(4,43,0,0,0,0),(4,44,0,0,0,0),(4,45,0,0,0,0),(4,46,0,0,0,0),(4,47,0,0,0,0),(4,48,0,0,0,0),(4,49,0,0,0,0),(4,50,0,0,0,0),(4,51,0,0,0,0),(4,52,0,0,0,0),(4,53,0,0,0,0),(4,54,0,0,0,0),(4,55,0,0,0,0),(4,56,0,0,0,0),(4,57,0,0,0,0),(4,58,0,0,0,0),(4,59,0,0,0,0),(4,60,1,0,1,0),(4,61,0,0,0,0),(4,62,0,0,0,0),(4,63,0,0,0,0),(4,64,0,0,0,0),(4,65,0,0,0,0),(4,66,0,0,0,0),(4,67,0,0,0,0),(4,68,0,0,0,0),(4,69,0,0,0,0),(4,70,0,0,0,0),(4,71,0,0,0,0),(4,72,0,0,0,0),(4,73,0,0,0,0),(4,74,0,0,0,0),(4,75,0,0,0,0),(4,76,0,0,0,0),(4,77,0,0,0,0),(4,78,0,0,0,0),(4,79,0,0,0,0),(4,80,0,0,0,0),(4,81,0,0,0,0),(4,82,0,0,0,0),(4,83,0,0,0,0),(4,84,1,1,1,1),(4,85,0,0,0,0),(4,86,0,0,0,0),(4,87,0,0,0,0),(4,88,0,0,0,0),(4,89,0,0,0,0),(4,90,0,0,0,0),(4,91,1,1,1,1),(4,92,0,0,0,0),(4,93,1,1,1,1),(4,94,0,0,0,0),(4,95,0,0,0,0),(4,96,0,0,0,0),(4,97,0,0,0,0),(4,98,0,0,0,0),(4,99,1,0,0,0),(4,100,0,0,0,0),(4,101,0,0,0,0),(4,102,0,0,0,0),(4,103,0,0,0,0),(4,104,0,0,0,0),(4,105,0,0,0,0),(4,106,0,0,0,0),(4,107,0,0,0,0);
/*!40000 ALTER TABLE `ps_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_accessory`
--

DROP TABLE IF EXISTS `ps_accessory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_accessory` (
                              `id_product_1` int(10) unsigned NOT NULL,
                              `id_product_2` int(10) unsigned NOT NULL,
                              KEY `accessory_product` (`id_product_1`,`id_product_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_accessory`
--

LOCK TABLES `ps_accessory` WRITE;
/*!40000 ALTER TABLE `ps_accessory` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_accessory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_address`
--

DROP TABLE IF EXISTS `ps_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_address` (
                            `id_address` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_country` int(10) unsigned NOT NULL,
                            `id_state` int(10) unsigned DEFAULT NULL,
                            `id_customer` int(10) unsigned NOT NULL DEFAULT 0,
                            `id_manufacturer` int(10) unsigned NOT NULL DEFAULT 0,
                            `id_supplier` int(10) unsigned NOT NULL DEFAULT 0,
                            `id_warehouse` int(10) unsigned NOT NULL DEFAULT 0,
                            `alias` varchar(32) NOT NULL,
                            `company` varchar(255) DEFAULT NULL,
                            `lastname` varchar(32) NOT NULL,
                            `firstname` varchar(32) NOT NULL,
                            `address1` varchar(128) NOT NULL,
                            `address2` varchar(128) DEFAULT NULL,
                            `postcode` varchar(12) DEFAULT NULL,
                            `city` varchar(64) NOT NULL,
                            `other` text DEFAULT NULL,
                            `phone` varchar(32) DEFAULT NULL,
                            `phone_mobile` varchar(32) DEFAULT NULL,
                            `vat_number` varchar(32) DEFAULT NULL,
                            `dni` varchar(16) DEFAULT NULL,
                            `date_add` datetime NOT NULL,
                            `date_upd` datetime NOT NULL,
                            `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
                            `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            PRIMARY KEY (`id_address`),
                            KEY `address_customer` (`id_customer`),
                            KEY `id_country` (`id_country`),
                            KEY `id_state` (`id_state`),
                            KEY `id_manufacturer` (`id_manufacturer`),
                            KEY `id_supplier` (`id_supplier`),
                            KEY `id_warehouse` (`id_warehouse`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_address`
--

LOCK TABLES `ps_address` WRITE;
/*!40000 ALTER TABLE `ps_address` DISABLE KEYS */;
INSERT INTO `ps_address` VALUES (1,8,0,1,0,0,0,'Mon adresse','My Company','DOE','John','16, Main street','2nd floor','75002','Paris ','','0102030405','','','','2025-03-04 08:13:15','2025-03-04 08:13:15',1,0),(2,21,32,0,0,1,0,'supplier','Fashion','supplier','supplier','767 Fifth Ave.','','10153','New York','','(212) 336-1440','','','','2025-03-04 08:13:15','2025-03-04 08:13:15',1,0),(3,21,32,0,1,0,0,'manufacturer','Fashion','manufacturer','manufacturer','767 Fifth Ave.','','10154','New York','','(212) 336-1666','','','','2025-03-04 08:13:15','2025-03-04 08:13:15',1,0),(4,21,9,1,0,0,0,'My address','My Company','DOE','John','16, Main street','2nd floor','33133','Miami','','0102030405','','','','2025-03-04 08:13:15','2025-03-04 08:13:15',1,0);
/*!40000 ALTER TABLE `ps_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_address_format`
--

DROP TABLE IF EXISTS `ps_address_format`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_address_format` (
                                   `id_country` int(10) unsigned NOT NULL,
                                   `format` varchar(255) NOT NULL DEFAULT '',
                                   PRIMARY KEY (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_address_format`
--

LOCK TABLES `ps_address_format` WRITE;
/*!40000 ALTER TABLE `ps_address_format` DISABLE KEYS */;
INSERT INTO `ps_address_format` VALUES (1,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(2,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(3,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(4,'firstname lastname\ncompany\naddress1\naddress2\ncity State:name postcode\nCountry:name\nphone\nphone_mobile'),(5,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(6,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(7,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(8,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(9,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(10,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nState:name\nCountry:name\nphone\nphone_mobile'),(11,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nState:name\nCountry:name\nphone\nphone_mobile'),(12,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(13,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(14,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(15,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(16,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(17,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\ncity\npostcode\nCountry:name\nphone\nphone_mobile'),(18,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(19,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(20,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(21,'firstname lastname\ncompany\naddress1 address2\ncity, State:name postcode\nCountry:name\nphone\nphone_mobile'),(22,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(23,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(24,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(25,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(26,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(27,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(28,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(29,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(30,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(31,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(32,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(33,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(34,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(35,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(36,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(37,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(38,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(39,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(40,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(41,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(42,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(43,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(44,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nState:name\nCountry:name\nphone\nphone_mobile'),(45,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(46,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(47,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(48,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(49,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(50,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(51,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(52,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(53,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(54,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(55,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(56,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(57,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(58,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(59,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(60,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(61,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(62,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(63,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(64,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(65,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(66,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(67,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(68,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(69,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(70,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(71,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(72,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(73,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(74,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(75,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(76,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(77,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(78,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(79,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(80,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(81,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(82,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(83,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(84,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(85,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(86,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(87,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(88,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(89,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(90,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(91,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(92,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(93,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(94,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(95,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(96,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(97,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(98,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(99,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(100,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(101,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(102,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(103,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(104,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(105,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(106,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(107,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(108,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(109,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(110,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(111,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nState:name\nCountry:name\nphone\nphone_mobile'),(112,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(113,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(114,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(115,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(116,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(117,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(118,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(119,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(120,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(121,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(122,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(123,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(124,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(125,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(126,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(127,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(128,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(129,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(130,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(131,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(132,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(133,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(134,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(135,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(136,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(137,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(138,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(139,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(140,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(141,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(142,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(143,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(144,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(145,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nState:name\nCountry:name\nphone\nphone_mobile'),(146,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(147,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(148,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(149,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(150,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(151,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(152,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(153,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(154,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(155,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(156,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(157,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(158,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(159,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(160,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(161,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(162,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(163,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(164,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(165,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(166,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(167,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(168,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(169,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(170,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(171,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(172,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(173,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(174,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(175,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(176,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(177,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(178,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(179,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(180,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(181,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(182,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(183,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(184,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(185,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(186,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(187,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(188,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(189,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(190,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(191,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(192,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(193,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(194,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(195,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(196,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(197,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(198,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(199,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(200,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(201,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(202,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(203,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(204,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(205,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(206,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(207,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(208,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(209,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(210,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(211,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(212,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(213,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(214,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(215,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(216,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(217,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(218,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(219,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(220,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(221,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(222,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(223,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(224,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(225,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(226,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(227,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(228,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(229,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(230,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(231,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(232,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(233,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(234,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(235,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(236,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(237,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(238,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(239,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(240,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(241,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(242,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(243,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile'),(244,'firstname lastname\ncompany\nvat_number\naddress1\naddress2\npostcode city\nCountry:name\nphone\nphone_mobile');
/*!40000 ALTER TABLE `ps_address_format` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_advice`
--

DROP TABLE IF EXISTS `ps_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_advice` (
                           `id_advice` int(11) NOT NULL AUTO_INCREMENT,
                           `id_ps_advice` int(11) NOT NULL,
                           `id_tab` int(11) NOT NULL,
                           `ids_tab` text DEFAULT NULL,
                           `validated` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `hide` tinyint(1) NOT NULL DEFAULT 0,
                           `location` enum('after','before') NOT NULL,
                           `selector` varchar(255) DEFAULT NULL,
                           `start_day` int(11) NOT NULL DEFAULT 0,
                           `stop_day` int(11) NOT NULL DEFAULT 0,
                           `weight` int(11) DEFAULT 1,
                           PRIMARY KEY (`id_advice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_advice`
--

LOCK TABLES `ps_advice` WRITE;
/*!40000 ALTER TABLE `ps_advice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_advice_lang`
--

DROP TABLE IF EXISTS `ps_advice_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_advice_lang` (
                                `id_advice` int(11) NOT NULL,
                                `id_lang` int(11) NOT NULL,
                                `html` text DEFAULT NULL,
                                PRIMARY KEY (`id_advice`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_advice_lang`
--

LOCK TABLES `ps_advice_lang` WRITE;
/*!40000 ALTER TABLE `ps_advice_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_advice_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_alias`
--

DROP TABLE IF EXISTS `ps_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_alias` (
                          `id_alias` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `alias` varchar(255) NOT NULL,
                          `search` varchar(255) NOT NULL,
                          `active` tinyint(1) NOT NULL DEFAULT 1,
                          PRIMARY KEY (`id_alias`),
                          UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_alias`
--

LOCK TABLES `ps_alias` WRITE;
/*!40000 ALTER TABLE `ps_alias` DISABLE KEYS */;
INSERT INTO `ps_alias` VALUES (1,'bloose','blouse',1),(2,'blues','blouse',1);
/*!40000 ALTER TABLE `ps_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attachment`
--

DROP TABLE IF EXISTS `ps_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attachment` (
                               `id_attachment` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `file` varchar(40) NOT NULL,
                               `file_name` varchar(128) NOT NULL,
                               `file_size` bigint(10) unsigned NOT NULL DEFAULT 0,
                               `mime` varchar(128) NOT NULL,
                               PRIMARY KEY (`id_attachment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attachment`
--

LOCK TABLES `ps_attachment` WRITE;
/*!40000 ALTER TABLE `ps_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attachment_lang`
--

DROP TABLE IF EXISTS `ps_attachment_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attachment_lang` (
                                    `id_attachment` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_lang` int(10) unsigned NOT NULL,
                                    `name` varchar(32) DEFAULT NULL,
                                    `description` text DEFAULT NULL,
                                    PRIMARY KEY (`id_attachment`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attachment_lang`
--

LOCK TABLES `ps_attachment_lang` WRITE;
/*!40000 ALTER TABLE `ps_attachment_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_attachment_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute`
--

DROP TABLE IF EXISTS `ps_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute` (
                              `id_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_attribute_group` int(10) unsigned NOT NULL,
                              `color` varchar(32) DEFAULT NULL,
                              `position` int(10) unsigned NOT NULL DEFAULT 0,
                              PRIMARY KEY (`id_attribute`),
                              KEY `attribute_group` (`id_attribute_group`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute`
--

LOCK TABLES `ps_attribute` WRITE;
/*!40000 ALTER TABLE `ps_attribute` DISABLE KEYS */;
INSERT INTO `ps_attribute` VALUES (1,1,'',0),(2,1,'',1),(3,1,'',2),(4,1,'',3),(5,3,'#AAB2BD',0),(6,3,'#CFC4A6',1),(7,3,'#f5f5dc',2),(8,3,'#ffffff',3),(9,3,'#faebd7',4),(10,3,'#E84C3D',5),(11,3,'#434A54',6),(12,3,'#C19A6B',7),(13,3,'#F39C11',8),(14,3,'#5D9CEC',9),(15,3,'#A0D468',10),(16,3,'#F1C40F',11),(17,3,'#964B00',12),(18,2,'',0),(19,2,'',1),(20,2,'',2),(21,2,'',3),(22,2,'',4),(23,2,'',5),(24,3,'#FCCACD',13);
/*!40000 ALTER TABLE `ps_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_group`
--

DROP TABLE IF EXISTS `ps_attribute_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_group` (
                                    `id_attribute_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `is_color_group` tinyint(1) NOT NULL DEFAULT 0,
                                    `group_type` enum('select','radio','color') NOT NULL DEFAULT 'select',
                                    `position` int(10) unsigned NOT NULL DEFAULT 0,
                                    PRIMARY KEY (`id_attribute_group`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_group`
--

LOCK TABLES `ps_attribute_group` WRITE;
/*!40000 ALTER TABLE `ps_attribute_group` DISABLE KEYS */;
INSERT INTO `ps_attribute_group` VALUES (1,0,'select',0),(2,0,'select',1),(3,1,'color',2);
/*!40000 ALTER TABLE `ps_attribute_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_group_lang`
--

DROP TABLE IF EXISTS `ps_attribute_group_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_group_lang` (
                                         `id_attribute_group` int(10) unsigned NOT NULL,
                                         `id_lang` int(10) unsigned NOT NULL,
                                         `name` varchar(128) NOT NULL,
                                         `public_name` varchar(64) NOT NULL,
                                         PRIMARY KEY (`id_attribute_group`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_group_lang`
--

LOCK TABLES `ps_attribute_group_lang` WRITE;
/*!40000 ALTER TABLE `ps_attribute_group_lang` DISABLE KEYS */;
INSERT INTO `ps_attribute_group_lang` VALUES (1,1,'Size','Size'),(2,1,'Shoes Size','Size'),(3,1,'Color','Color');
/*!40000 ALTER TABLE `ps_attribute_group_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_group_shop`
--

DROP TABLE IF EXISTS `ps_attribute_group_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_group_shop` (
                                         `id_attribute_group` int(11) unsigned NOT NULL,
                                         `id_shop` int(11) unsigned NOT NULL,
                                         PRIMARY KEY (`id_attribute_group`,`id_shop`),
                                         KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_group_shop`
--

LOCK TABLES `ps_attribute_group_shop` WRITE;
/*!40000 ALTER TABLE `ps_attribute_group_shop` DISABLE KEYS */;
INSERT INTO `ps_attribute_group_shop` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `ps_attribute_group_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_impact`
--

DROP TABLE IF EXISTS `ps_attribute_impact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_impact` (
                                     `id_attribute_impact` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `id_product` int(11) unsigned NOT NULL,
                                     `id_attribute` int(11) unsigned NOT NULL,
                                     `weight` decimal(20,6) NOT NULL,
                                     `price` decimal(17,2) NOT NULL,
                                     PRIMARY KEY (`id_attribute_impact`),
                                     UNIQUE KEY `id_product` (`id_product`,`id_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_impact`
--

LOCK TABLES `ps_attribute_impact` WRITE;
/*!40000 ALTER TABLE `ps_attribute_impact` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_attribute_impact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_lang`
--

DROP TABLE IF EXISTS `ps_attribute_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_lang` (
                                   `id_attribute` int(10) unsigned NOT NULL,
                                   `id_lang` int(10) unsigned NOT NULL,
                                   `name` varchar(128) NOT NULL,
                                   PRIMARY KEY (`id_attribute`,`id_lang`),
                                   KEY `id_lang` (`id_lang`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_lang`
--

LOCK TABLES `ps_attribute_lang` WRITE;
/*!40000 ALTER TABLE `ps_attribute_lang` DISABLE KEYS */;
INSERT INTO `ps_attribute_lang` VALUES (18,1,'35'),(19,1,'36'),(20,1,'37'),(21,1,'38'),(22,1,'39'),(23,1,'40'),(7,1,'Beige'),(11,1,'Black'),(14,1,'Blue'),(17,1,'Brown'),(12,1,'Camel'),(15,1,'Green'),(5,1,'Grey'),(3,1,'L'),(2,1,'M'),(9,1,'Off White'),(4,1,'One size'),(13,1,'Orange'),(24,1,'Pink'),(10,1,'Red'),(1,1,'S'),(6,1,'Taupe'),(8,1,'White'),(16,1,'Yellow');
/*!40000 ALTER TABLE `ps_attribute_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_attribute_shop`
--

DROP TABLE IF EXISTS `ps_attribute_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_attribute_shop` (
                                   `id_attribute` int(11) unsigned NOT NULL,
                                   `id_shop` int(11) unsigned NOT NULL,
                                   PRIMARY KEY (`id_attribute`,`id_shop`),
                                   KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_attribute_shop`
--

LOCK TABLES `ps_attribute_shop` WRITE;
/*!40000 ALTER TABLE `ps_attribute_shop` DISABLE KEYS */;
INSERT INTO `ps_attribute_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1);
/*!40000 ALTER TABLE `ps_attribute_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_badge`
--

DROP TABLE IF EXISTS `ps_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_badge` (
                          `id_badge` int(11) NOT NULL AUTO_INCREMENT,
                          `id_ps_badge` int(11) NOT NULL,
                          `type` varchar(32) NOT NULL,
                          `id_group` int(11) NOT NULL,
                          `group_position` int(11) NOT NULL,
                          `scoring` int(11) NOT NULL,
                          `awb` int(11) DEFAULT 0,
                          `validated` tinyint(1) unsigned NOT NULL DEFAULT 0,
                          PRIMARY KEY (`id_badge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_badge`
--

LOCK TABLES `ps_badge` WRITE;
/*!40000 ALTER TABLE `ps_badge` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_badge_lang`
--

DROP TABLE IF EXISTS `ps_badge_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_badge_lang` (
                               `id_badge` int(11) NOT NULL,
                               `id_lang` int(11) NOT NULL,
                               `name` varchar(64) DEFAULT NULL,
                               `description` varchar(255) DEFAULT NULL,
                               `group_name` varchar(255) DEFAULT NULL,
                               PRIMARY KEY (`id_badge`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_badge_lang`
--

LOCK TABLES `ps_badge_lang` WRITE;
/*!40000 ALTER TABLE `ps_badge_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_badge_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier`
--

DROP TABLE IF EXISTS `ps_carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier` (
                            `id_carrier` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_reference` int(10) unsigned NOT NULL,
                            `id_tax_rules_group` int(10) unsigned DEFAULT 0,
                            `name` varchar(64) NOT NULL,
                            `url` varchar(255) DEFAULT NULL,
                            `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `shipping_handling` tinyint(1) unsigned NOT NULL DEFAULT 1,
                            `range_behavior` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `is_module` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `is_free` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `shipping_external` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `need_range` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `external_module_name` varchar(64) DEFAULT NULL,
                            `shipping_method` int(2) NOT NULL DEFAULT 0,
                            `position` int(10) unsigned NOT NULL DEFAULT 0,
                            `max_width` int(10) DEFAULT 0,
                            `max_height` int(10) DEFAULT 0,
                            `max_depth` int(10) DEFAULT 0,
                            `max_weight` decimal(20,6) DEFAULT 0.000000,
                            `grade` int(10) DEFAULT 0,
                            PRIMARY KEY (`id_carrier`),
                            KEY `deleted` (`deleted`,`active`),
                            KEY `id_tax_rules_group` (`id_tax_rules_group`),
                            KEY `reference` (`id_reference`,`deleted`,`active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier`
--

LOCK TABLES `ps_carrier` WRITE;
/*!40000 ALTER TABLE `ps_carrier` DISABLE KEYS */;
INSERT INTO `ps_carrier` VALUES (1,1,0,'0','',1,0,0,0,0,1,0,0,'',0,0,0,0,0,0.000000,0),(2,2,0,'My carrier','',1,0,1,0,0,0,0,0,'',0,1,0,0,0,0.000000,0);
/*!40000 ALTER TABLE `ps_carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier_group`
--

DROP TABLE IF EXISTS `ps_carrier_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier_group` (
                                  `id_carrier` int(10) unsigned NOT NULL,
                                  `id_group` int(10) unsigned NOT NULL,
                                  PRIMARY KEY (`id_carrier`,`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier_group`
--

LOCK TABLES `ps_carrier_group` WRITE;
/*!40000 ALTER TABLE `ps_carrier_group` DISABLE KEYS */;
INSERT INTO `ps_carrier_group` VALUES (1,1),(1,2),(1,3),(2,1),(2,2),(2,3);
/*!40000 ALTER TABLE `ps_carrier_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier_lang`
--

DROP TABLE IF EXISTS `ps_carrier_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier_lang` (
                                 `id_carrier` int(10) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `delay` varchar(512) DEFAULT NULL,
                                 PRIMARY KEY (`id_lang`,`id_shop`,`id_carrier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier_lang`
--

LOCK TABLES `ps_carrier_lang` WRITE;
/*!40000 ALTER TABLE `ps_carrier_lang` DISABLE KEYS */;
INSERT INTO `ps_carrier_lang` VALUES (1,1,1,'Pick up in-store'),(2,1,1,'Delivery next day!');
/*!40000 ALTER TABLE `ps_carrier_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier_shop`
--

DROP TABLE IF EXISTS `ps_carrier_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier_shop` (
                                 `id_carrier` int(11) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 PRIMARY KEY (`id_carrier`,`id_shop`),
                                 KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier_shop`
--

LOCK TABLES `ps_carrier_shop` WRITE;
/*!40000 ALTER TABLE `ps_carrier_shop` DISABLE KEYS */;
INSERT INTO `ps_carrier_shop` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `ps_carrier_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier_tax_rules_group_shop`
--

DROP TABLE IF EXISTS `ps_carrier_tax_rules_group_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier_tax_rules_group_shop` (
                                                 `id_carrier` int(11) unsigned NOT NULL,
                                                 `id_tax_rules_group` int(11) unsigned NOT NULL,
                                                 `id_shop` int(11) unsigned NOT NULL,
                                                 PRIMARY KEY (`id_carrier`,`id_tax_rules_group`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier_tax_rules_group_shop`
--

LOCK TABLES `ps_carrier_tax_rules_group_shop` WRITE;
/*!40000 ALTER TABLE `ps_carrier_tax_rules_group_shop` DISABLE KEYS */;
INSERT INTO `ps_carrier_tax_rules_group_shop` VALUES (1,1,1),(2,1,1);
/*!40000 ALTER TABLE `ps_carrier_tax_rules_group_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_carrier_zone`
--

DROP TABLE IF EXISTS `ps_carrier_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_carrier_zone` (
                                 `id_carrier` int(10) unsigned NOT NULL,
                                 `id_zone` int(10) unsigned NOT NULL,
                                 PRIMARY KEY (`id_carrier`,`id_zone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_carrier_zone`
--

LOCK TABLES `ps_carrier_zone` WRITE;
/*!40000 ALTER TABLE `ps_carrier_zone` DISABLE KEYS */;
INSERT INTO `ps_carrier_zone` VALUES (1,1),(2,1),(2,2);
/*!40000 ALTER TABLE `ps_carrier_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart`
--

DROP TABLE IF EXISTS `ps_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart` (
                         `id_cart` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `id_shop_group` int(11) unsigned NOT NULL DEFAULT 1,
                         `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                         `id_carrier` int(10) unsigned NOT NULL,
                         `delivery_option` text NOT NULL,
                         `id_lang` int(10) unsigned NOT NULL,
                         `id_address_delivery` int(10) unsigned NOT NULL,
                         `id_address_invoice` int(10) unsigned NOT NULL,
                         `id_currency` int(10) unsigned NOT NULL,
                         `id_customer` int(10) unsigned NOT NULL,
                         `id_guest` int(10) unsigned NOT NULL,
                         `secure_key` varchar(32) NOT NULL DEFAULT '-1',
                         `recyclable` tinyint(1) unsigned NOT NULL DEFAULT 1,
                         `gift` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         `gift_message` text DEFAULT NULL,
                         `mobile_theme` tinyint(1) NOT NULL DEFAULT 0,
                         `allow_seperated_package` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         `date_add` datetime NOT NULL,
                         `date_upd` datetime NOT NULL,
                         PRIMARY KEY (`id_cart`),
                         KEY `cart_customer` (`id_customer`),
                         KEY `id_address_delivery` (`id_address_delivery`),
                         KEY `id_address_invoice` (`id_address_invoice`),
                         KEY `id_carrier` (`id_carrier`),
                         KEY `id_lang` (`id_lang`),
                         KEY `id_currency` (`id_currency`),
                         KEY `id_guest` (`id_guest`),
                         KEY `id_shop_group` (`id_shop_group`),
                         KEY `id_shop_2` (`id_shop`,`date_upd`),
                         KEY `id_shop` (`id_shop`,`date_add`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart`
--

LOCK TABLES `ps_cart` WRITE;
/*!40000 ALTER TABLE `ps_cart` DISABLE KEYS */;
INSERT INTO `ps_cart` VALUES (1,1,1,2,'{\"3\":\"2,\"}',1,4,4,1,1,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1',0,0,'',0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(2,1,1,2,'{\"3\":\"2,\"}',1,4,4,1,1,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1',0,0,'',0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(3,1,1,2,'{\"3\":\"2,\"}',1,4,4,1,1,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1',0,0,'',0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(4,1,1,2,'{\"3\":\"2,\"}',1,4,4,1,1,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1',0,0,'',0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(5,1,1,2,'{\"3\":\"2,\"}',1,4,4,1,1,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1',0,0,'',0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_cart_rule`
--

DROP TABLE IF EXISTS `ps_cart_cart_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_cart_rule` (
                                   `id_cart` int(10) unsigned NOT NULL,
                                   `id_cart_rule` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_cart`,`id_cart_rule`),
                                   KEY `id_cart_rule` (`id_cart_rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_cart_rule`
--

LOCK TABLES `ps_cart_cart_rule` WRITE;
/*!40000 ALTER TABLE `ps_cart_cart_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_cart_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_product`
--

DROP TABLE IF EXISTS `ps_cart_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_product` (
                                 `id_cart` int(10) unsigned NOT NULL,
                                 `id_product` int(10) unsigned NOT NULL,
                                 `id_address_delivery` int(10) unsigned NOT NULL DEFAULT 0,
                                 `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                 `id_product_attribute` int(10) unsigned NOT NULL DEFAULT 0,
                                 `quantity` int(10) unsigned NOT NULL DEFAULT 0,
                                 `date_add` datetime NOT NULL,
                                 PRIMARY KEY (`id_cart`,`id_product`,`id_product_attribute`,`id_address_delivery`),
                                 KEY `id_product_attribute` (`id_product_attribute`),
                                 KEY `id_cart_order` (`id_cart`,`date_add`,`id_product`,`id_product_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_product`
--

LOCK TABLES `ps_cart_product` WRITE;
/*!40000 ALTER TABLE `ps_cart_product` DISABLE KEYS */;
INSERT INTO `ps_cart_product` VALUES (1,2,3,1,10,1,'0000-00-00 00:00:00'),(1,3,3,1,13,1,'0000-00-00 00:00:00'),(2,2,3,1,10,1,'0000-00-00 00:00:00'),(2,6,3,1,32,1,'0000-00-00 00:00:00'),(2,7,3,1,34,1,'0000-00-00 00:00:00'),(3,1,3,1,1,1,'0000-00-00 00:00:00'),(3,2,3,1,10,1,'0000-00-00 00:00:00'),(3,6,3,1,32,1,'0000-00-00 00:00:00'),(4,1,3,1,1,1,'0000-00-00 00:00:00'),(4,3,3,1,13,1,'0000-00-00 00:00:00'),(4,5,3,1,19,1,'0000-00-00 00:00:00'),(4,7,3,1,34,1,'0000-00-00 00:00:00'),(5,1,3,1,1,1,'0000-00-00 00:00:00'),(5,2,3,1,7,1,'0000-00-00 00:00:00'),(5,3,3,1,13,1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ps_cart_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule`
--

DROP TABLE IF EXISTS `ps_cart_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule` (
                              `id_cart_rule` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_customer` int(10) unsigned NOT NULL DEFAULT 0,
                              `date_from` datetime NOT NULL,
                              `date_to` datetime NOT NULL,
                              `description` text DEFAULT NULL,
                              `quantity` int(10) unsigned NOT NULL DEFAULT 0,
                              `quantity_per_user` int(10) unsigned NOT NULL DEFAULT 0,
                              `priority` int(10) unsigned NOT NULL DEFAULT 1,
                              `partial_use` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `code` varchar(254) NOT NULL,
                              `minimum_amount` decimal(17,2) NOT NULL DEFAULT 0.00,
                              `minimum_amount_tax` tinyint(1) NOT NULL DEFAULT 0,
                              `minimum_amount_currency` int(10) unsigned NOT NULL DEFAULT 0,
                              `minimum_amount_shipping` tinyint(1) NOT NULL DEFAULT 0,
                              `country_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `carrier_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `group_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `cart_rule_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `product_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `shop_restriction` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
                              `reduction_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
                              `reduction_amount` decimal(17,2) NOT NULL DEFAULT 0.00,
                              `reduction_tax` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `reduction_currency` int(10) unsigned NOT NULL DEFAULT 0,
                              `reduction_product` int(10) NOT NULL DEFAULT 0,
                              `gift_product` int(10) unsigned NOT NULL DEFAULT 0,
                              `gift_product_attribute` int(10) unsigned NOT NULL DEFAULT 0,
                              `highlight` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `date_add` datetime NOT NULL,
                              `date_upd` datetime NOT NULL,
                              PRIMARY KEY (`id_cart_rule`),
                              KEY `id_customer` (`id_customer`,`active`,`date_to`),
                              KEY `group_restriction` (`group_restriction`,`active`,`date_to`),
                              KEY `id_customer_2` (`id_customer`,`active`,`highlight`,`date_to`),
                              KEY `group_restriction_2` (`group_restriction`,`active`,`highlight`,`date_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule`
--

LOCK TABLES `ps_cart_rule` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_carrier`
--

DROP TABLE IF EXISTS `ps_cart_rule_carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_carrier` (
                                      `id_cart_rule` int(10) unsigned NOT NULL,
                                      `id_carrier` int(10) unsigned NOT NULL,
                                      PRIMARY KEY (`id_cart_rule`,`id_carrier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_carrier`
--

LOCK TABLES `ps_cart_rule_carrier` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_carrier` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_combination`
--

DROP TABLE IF EXISTS `ps_cart_rule_combination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_combination` (
                                          `id_cart_rule_1` int(10) unsigned NOT NULL,
                                          `id_cart_rule_2` int(10) unsigned NOT NULL,
                                          PRIMARY KEY (`id_cart_rule_1`,`id_cart_rule_2`),
                                          KEY `id_cart_rule_1` (`id_cart_rule_1`),
                                          KEY `id_cart_rule_2` (`id_cart_rule_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_combination`
--

LOCK TABLES `ps_cart_rule_combination` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_combination` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_combination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_country`
--

DROP TABLE IF EXISTS `ps_cart_rule_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_country` (
                                      `id_cart_rule` int(10) unsigned NOT NULL,
                                      `id_country` int(10) unsigned NOT NULL,
                                      PRIMARY KEY (`id_cart_rule`,`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_country`
--

LOCK TABLES `ps_cart_rule_country` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_country` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_group`
--

DROP TABLE IF EXISTS `ps_cart_rule_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_group` (
                                    `id_cart_rule` int(10) unsigned NOT NULL,
                                    `id_group` int(10) unsigned NOT NULL,
                                    PRIMARY KEY (`id_cart_rule`,`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_group`
--

LOCK TABLES `ps_cart_rule_group` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_lang`
--

DROP TABLE IF EXISTS `ps_cart_rule_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_lang` (
                                   `id_cart_rule` int(10) unsigned NOT NULL,
                                   `id_lang` int(10) unsigned NOT NULL,
                                   `name` varchar(254) NOT NULL,
                                   PRIMARY KEY (`id_cart_rule`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_lang`
--

LOCK TABLES `ps_cart_rule_lang` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_product_rule`
--

DROP TABLE IF EXISTS `ps_cart_rule_product_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_product_rule` (
                                           `id_product_rule` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                           `id_product_rule_group` int(10) unsigned NOT NULL,
                                           `type` enum('products','categories','attributes','manufacturers','suppliers') NOT NULL,
                                           PRIMARY KEY (`id_product_rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_product_rule`
--

LOCK TABLES `ps_cart_rule_product_rule` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_product_rule_group`
--

DROP TABLE IF EXISTS `ps_cart_rule_product_rule_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_product_rule_group` (
                                                 `id_product_rule_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                                 `id_cart_rule` int(10) unsigned NOT NULL,
                                                 `quantity` int(10) unsigned NOT NULL DEFAULT 1,
                                                 PRIMARY KEY (`id_product_rule_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_product_rule_group`
--

LOCK TABLES `ps_cart_rule_product_rule_group` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_product_rule_value`
--

DROP TABLE IF EXISTS `ps_cart_rule_product_rule_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_product_rule_value` (
                                                 `id_product_rule` int(10) unsigned NOT NULL,
                                                 `id_item` int(10) unsigned NOT NULL,
                                                 PRIMARY KEY (`id_product_rule`,`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_product_rule_value`
--

LOCK TABLES `ps_cart_rule_product_rule_value` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_product_rule_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cart_rule_shop`
--

DROP TABLE IF EXISTS `ps_cart_rule_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cart_rule_shop` (
                                   `id_cart_rule` int(10) unsigned NOT NULL,
                                   `id_shop` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_cart_rule`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cart_rule_shop`
--

LOCK TABLES `ps_cart_rule_shop` WRITE;
/*!40000 ALTER TABLE `ps_cart_rule_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cart_rule_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_category`
--

DROP TABLE IF EXISTS `ps_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_category` (
                             `id_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `id_parent` int(10) unsigned NOT NULL,
                             `id_shop_default` int(10) unsigned NOT NULL DEFAULT 1,
                             `level_depth` tinyint(3) unsigned NOT NULL DEFAULT 0,
                             `nleft` int(10) unsigned NOT NULL DEFAULT 0,
                             `nright` int(10) unsigned NOT NULL DEFAULT 0,
                             `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `date_add` datetime NOT NULL,
                             `date_upd` datetime NOT NULL,
                             `position` int(10) unsigned NOT NULL DEFAULT 0,
                             `is_root_category` tinyint(1) NOT NULL DEFAULT 0,
                             PRIMARY KEY (`id_category`),
                             KEY `category_parent` (`id_parent`),
                             KEY `nleftrightactive` (`nleft`,`nright`,`active`),
                             KEY `level_depth` (`level_depth`),
                             KEY `nright` (`nright`),
                             KEY `activenleft` (`active`,`nleft`),
                             KEY `activenright` (`active`,`nright`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_category`
--

LOCK TABLES `ps_category` WRITE;
/*!40000 ALTER TABLE `ps_category` DISABLE KEYS */;
INSERT INTO `ps_category` VALUES (1,0,1,0,1,22,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(2,1,1,1,2,21,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,1),(3,2,1,2,3,20,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(4,3,1,3,4,11,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(5,4,1,4,5,6,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(6,4,1,4,7,8,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(7,4,1,4,9,10,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(8,3,1,3,12,19,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(9,8,1,4,13,14,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(10,8,1,4,15,16,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0),(11,8,1,4,17,18,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,0);
/*!40000 ALTER TABLE `ps_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_category_group`
--

DROP TABLE IF EXISTS `ps_category_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_category_group` (
                                   `id_category` int(10) unsigned NOT NULL,
                                   `id_group` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_category`,`id_group`),
                                   KEY `id_category` (`id_category`),
                                   KEY `id_group` (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_category_group`
--

LOCK TABLES `ps_category_group` WRITE;
/*!40000 ALTER TABLE `ps_category_group` DISABLE KEYS */;
INSERT INTO `ps_category_group` VALUES (2,0),(2,1),(2,2),(2,3),(3,1),(3,2),(3,3),(4,1),(4,2),(4,3),(5,1),(5,2),(5,3),(6,1),(6,2),(6,3),(7,1),(7,2),(7,3),(8,1),(8,2),(8,3),(9,1),(9,2),(9,3),(10,1),(10,2),(10,3),(11,1),(11,2),(11,3);
/*!40000 ALTER TABLE `ps_category_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_category_lang`
--

DROP TABLE IF EXISTS `ps_category_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_category_lang` (
                                  `id_category` int(10) unsigned NOT NULL,
                                  `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                  `id_lang` int(10) unsigned NOT NULL,
                                  `name` varchar(128) NOT NULL,
                                  `description` text DEFAULT NULL,
                                  `link_rewrite` varchar(128) NOT NULL,
                                  `meta_title` varchar(128) DEFAULT NULL,
                                  `meta_keywords` varchar(255) DEFAULT NULL,
                                  `meta_description` varchar(255) DEFAULT NULL,
                                  PRIMARY KEY (`id_category`,`id_shop`,`id_lang`),
                                  KEY `category_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_category_lang`
--

LOCK TABLES `ps_category_lang` WRITE;
/*!40000 ALTER TABLE `ps_category_lang` DISABLE KEYS */;
INSERT INTO `ps_category_lang` VALUES (1,1,1,'Root','','root','','',''),(2,1,1,'Home','','home','','',''),(3,1,1,'Women','<p><strong>You will find here all woman fashion collections.</strong></p>\r\n<p>This category includes all the basics of your wardrobe and much more:</p>\r\n<p>shoes, accessories, printed t-shirts, feminine dresses, women\'s jeans!</p>','women','','',''),(4,1,1,'Tops','<p>Choose from t-shirts, tops, blouses, short sleeves, long sleeves, tank tops, 3/4 sleeves and more.</p>\r\n<p>Find the cut that suits you the best!</p>','tops','','',''),(5,1,1,'T-shirts','<p>The must have of your wardrobe, take a look at our different colors,</p>\r\n<p>shapes and style of our collection!</p>','tshirts','','',''),(6,1,1,'Tops','Choose the top that best suits you from the wide variety of tops we have. ','top','','',''),(7,1,1,'Blouses','Match your favorites blouses with the right accessories for the perfect look.','blouses','','',''),(8,1,1,'Dresses','<p>Find your favorites dresses from our wide choice of evening, casual or summer dresses!</p>\r\n<p>We offer dresses for every day, every style and every occasion.</p>','dresses','','',''),(9,1,1,'Casual Dresses','<p>You are looking for a dress for every day? Take a look at</p>\r\n<p>our selection of dresses to find one that suits you.</p>','casual-dresses','','',''),(10,1,1,'Evening Dresses','Browse our different dresses to choose the perfect dress for an unforgettable evening!','evening-dresses','','',''),(11,1,1,'Summer Dresses','Short dress, long dress, silk dress, printed dress, you will find the perfect dress for summer.','summer-dresses','','','');
/*!40000 ALTER TABLE `ps_category_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_category_product`
--

DROP TABLE IF EXISTS `ps_category_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_category_product` (
  `id_category` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_category`,`id_product`),
  KEY `id_product` (`id_product`),
  KEY `id_category` (`id_category`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_category_product`
--

LOCK TABLES `ps_category_product` WRITE;
/*!40000 ALTER TABLE `ps_category_product` DISABLE KEYS */;
INSERT INTO `ps_category_product` VALUES (2,1,0),(2,2,1),(2,3,2),(2,4,3),(2,5,4),(2,6,5),(2,7,6),(3,1,0),(3,2,1),(3,3,2),(3,4,3),(3,5,4),(3,6,5),(3,7,6),(4,1,0),(4,2,1),(5,1,0),(7,2,0),(8,3,0),(8,4,1),(8,5,2),(8,6,3),(8,7,4),(9,3,0),(10,4,0),(11,5,0),(11,6,1),(11,7,2);
/*!40000 ALTER TABLE `ps_category_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_category_shop`
--

DROP TABLE IF EXISTS `ps_category_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_category_shop` (
  `id_category` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_category`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_category_shop`
--

LOCK TABLES `ps_category_shop` WRITE;
/*!40000 ALTER TABLE `ps_category_shop` DISABLE KEYS */;
INSERT INTO `ps_category_shop` VALUES (1,1,0),(2,1,0),(3,1,0),(4,1,0),(5,1,0),(6,1,1),(7,1,2),(8,1,1),(9,1,0),(10,1,1),(11,1,2);
/*!40000 ALTER TABLE `ps_category_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms`
--

DROP TABLE IF EXISTS `ps_cms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms` (
  `id_cms` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_category` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `indexation` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cms`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms`
--

LOCK TABLES `ps_cms` WRITE;
/*!40000 ALTER TABLE `ps_cms` DISABLE KEYS */;
INSERT INTO `ps_cms` VALUES (1,1,0,1,0),(2,1,1,1,0),(3,1,2,1,0),(4,1,3,1,0),(5,1,4,1,0);
/*!40000 ALTER TABLE `ps_cms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_block`
--

DROP TABLE IF EXISTS `ps_cms_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_block` (
  `id_cms_block` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_category` int(10) unsigned NOT NULL,
  `location` tinyint(1) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  `display_store` tinyint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cms_block`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_block`
--

LOCK TABLES `ps_cms_block` WRITE;
/*!40000 ALTER TABLE `ps_cms_block` DISABLE KEYS */;
INSERT INTO `ps_cms_block` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `ps_cms_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_block_lang`
--

DROP TABLE IF EXISTS `ps_cms_block_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_block_lang` (
  `id_cms_block` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_cms_block`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_block_lang`
--

LOCK TABLES `ps_cms_block_lang` WRITE;
/*!40000 ALTER TABLE `ps_cms_block_lang` DISABLE KEYS */;
INSERT INTO `ps_cms_block_lang` VALUES (1,1,'Information');
/*!40000 ALTER TABLE `ps_cms_block_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_block_page`
--

DROP TABLE IF EXISTS `ps_cms_block_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_block_page` (
  `id_cms_block_page` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cms_block` int(10) unsigned NOT NULL,
  `id_cms` int(10) unsigned NOT NULL,
  `is_category` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id_cms_block_page`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_block_page`
--

LOCK TABLES `ps_cms_block_page` WRITE;
/*!40000 ALTER TABLE `ps_cms_block_page` DISABLE KEYS */;
INSERT INTO `ps_cms_block_page` VALUES (1,1,1,0),(2,1,2,0),(3,1,3,0),(4,1,4,0),(5,1,5,0);
/*!40000 ALTER TABLE `ps_cms_block_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_block_shop`
--

DROP TABLE IF EXISTS `ps_cms_block_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_block_shop` (
  `id_cms_block` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_cms_block`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_block_shop`
--

LOCK TABLES `ps_cms_block_shop` WRITE;
/*!40000 ALTER TABLE `ps_cms_block_shop` DISABLE KEYS */;
INSERT INTO `ps_cms_block_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_cms_block_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_category`
--

DROP TABLE IF EXISTS `ps_cms_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_category` (
  `id_cms_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) unsigned NOT NULL,
  `level_depth` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_cms_category`),
  KEY `category_parent` (`id_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_category`
--

LOCK TABLES `ps_cms_category` WRITE;
/*!40000 ALTER TABLE `ps_cms_category` DISABLE KEYS */;
INSERT INTO `ps_cms_category` VALUES (1,0,1,1,'2025-03-04 08:13:14','2025-03-04 08:13:14',0);
/*!40000 ALTER TABLE `ps_cms_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_category_lang`
--

DROP TABLE IF EXISTS `ps_cms_category_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_category_lang` (
  `id_cms_category` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
  `name` varchar(128) NOT NULL,
  `description` text DEFAULT NULL,
  `link_rewrite` varchar(128) NOT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_cms_category`,`id_shop`,`id_lang`),
  KEY `category_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_category_lang`
--

LOCK TABLES `ps_cms_category_lang` WRITE;
/*!40000 ALTER TABLE `ps_cms_category_lang` DISABLE KEYS */;
INSERT INTO `ps_cms_category_lang` VALUES (1,1,1,'Home','','home','','','');
/*!40000 ALTER TABLE `ps_cms_category_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_category_shop`
--

DROP TABLE IF EXISTS `ps_cms_category_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_category_shop` (
  `id_cms_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_cms_category`,`id_shop`),
  KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_category_shop`
--

LOCK TABLES `ps_cms_category_shop` WRITE;
/*!40000 ALTER TABLE `ps_cms_category_shop` DISABLE KEYS */;
INSERT INTO `ps_cms_category_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_cms_category_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_lang`
--

DROP TABLE IF EXISTS `ps_cms_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_lang` (
  `id_cms` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
  `meta_title` varchar(128) NOT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `link_rewrite` varchar(128) NOT NULL,
  PRIMARY KEY (`id_cms`,`id_shop`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_lang`
--

LOCK TABLES `ps_cms_lang` WRITE;
/*!40000 ALTER TABLE `ps_cms_lang` DISABLE KEYS */;
INSERT INTO `ps_cms_lang` VALUES (1,1,1,'Delivery','Our terms and conditions of delivery','conditions, delivery, delay, shipment, pack','<h2>Shipments and returns</h2><h3>Your pack shipment</h3><p>Packages are generally dispatched within 2 days after receipt of payment and are shipped via UPS with tracking and drop-off without signature. If you prefer delivery by UPS Extra with required signature, an additional cost will be applied, so please contact us before choosing this method. Whichever shipment choice you make, we will provide you with a link to track your package online.</p><p>Shipping fees include handling and packing fees as well as postage costs. Handling fees are fixed, whereas transport fees vary according to total weight of the shipment. We advise you to group your items in one order. We cannot group two distinct orders placed separately, and shipping fees will apply to each of them. Your package will be dispatched at your own risk, but special care is taken to protect fragile objects.<br /><br />Boxes are amply sized and your items are well-protected.</p>','delivery'),(2,1,1,'Legal Notice','Legal notice','notice, legal, credits','<h2>Legal</h2><h3>Credits</h3><p>Concept and production:</p><p>This Online store was created using <a href=\"http://www.prestashop.com\">Prestashop Shopping Cart Software</a>,check out PrestaShop\'s <a href=\"http://www.prestashop.com/blog/en/\">ecommerce blog</a> for news and advices about selling online and running your ecommerce website.</p>','legal-notice'),(3,1,1,'Terms and conditions of use','Our terms and conditions of use','conditions, terms, use, sell','<h1 class=\"page-heading\">Terms and conditions of use</h1>\n<h3 class=\"page-subheading\">Rule 1</h3>\n<p class=\"bottom-indent\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n<h3 class=\"page-subheading\">Rule 2</h3>\n<p class=\"bottom-indent\">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>\n<h3 class=\"page-subheading\">Rule 3</h3>\n<p class=\"bottom-indent\">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam&#1102;</p>','terms-and-conditions-of-use'),(4,1,1,'About us','Learn more about us','about us, informations','<h1 class=\"page-heading bottom-indent\">About us</h1>\n<div class=\"row\">\n<div class=\"col-xs-12 col-sm-4\">\n<div class=\"cms-block\">\n<h3 class=\"page-subheading\">Our company</h3>\n<p><strong class=\"dark\">Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididun.</strong></p>\n<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.</p>\n<ul class=\"list-1\">\n<li><em class=\"icon-ok\"></em>Top quality products</li>\n<li><em class=\"icon-ok\"></em>Best customer service</li>\n<li><em class=\"icon-ok\"></em>30-days money back guarantee</li>\n</ul>\n</div>\n</div>\n<div class=\"col-xs-12 col-sm-4\">\n<div class=\"cms-box\">\n<h3 class=\"page-subheading\">Our team</h3>\n<img title=\"cms-img\" src=\"../img/cms/cms-img.jpg\" alt=\"cms-img\" width=\"370\" height=\"192\" />\n<p><strong class=\"dark\">Lorem set sint occaecat cupidatat non </strong></p>\n<p>Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>\n</div>\n</div>\n<div class=\"col-xs-12 col-sm-4\">\n<div class=\"cms-box\">\n<h3 class=\"page-subheading\">Testimonials</h3>\n<div class=\"testimonials\">\n<div class=\"inner\"><span class=\"before\">“</span>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.<span class=\"after\">”</span></div>\n</div>\n<p><strong class=\"dark\">Lorem ipsum dolor sit</strong></p>\n<div class=\"testimonials\">\n<div class=\"inner\"><span class=\"before\">“</span>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet conse ctetur adipisicing elit. Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod.<span class=\"after\">”</span></div>\n</div>\n<p><strong class=\"dark\">Ipsum dolor sit</strong></p>\n</div>\n</div>\n</div>','about-us'),(5,1,1,'Secure payment','Our secure payment method','secure payment, ssl, visa, mastercard, paypal','<h2>Secure payment</h2>\r\n<h3>Our secure payment</h3><p>With SSL</p>\r\n<h3>Using Visa/Mastercard/Paypal</h3><p>About this service</p>','secure-payment');
/*!40000 ALTER TABLE `ps_cms_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_role`
--

DROP TABLE IF EXISTS `ps_cms_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_role` (
                             `id_cms_role` int(11) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(50) NOT NULL,
                             `id_cms` int(11) unsigned NOT NULL,
                             PRIMARY KEY (`id_cms_role`,`id_cms`),
                             UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_role`
--

LOCK TABLES `ps_cms_role` WRITE;
/*!40000 ALTER TABLE `ps_cms_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cms_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_role_lang`
--

DROP TABLE IF EXISTS `ps_cms_role_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_role_lang` (
                                  `id_cms_role` int(11) unsigned NOT NULL,
                                  `id_lang` int(11) unsigned NOT NULL,
                                  `id_shop` int(11) unsigned NOT NULL,
                                  `name` varchar(128) DEFAULT NULL,
                                  PRIMARY KEY (`id_cms_role`,`id_lang`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_role_lang`
--

LOCK TABLES `ps_cms_role_lang` WRITE;
/*!40000 ALTER TABLE `ps_cms_role_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_cms_role_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_cms_shop`
--

DROP TABLE IF EXISTS `ps_cms_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_cms_shop` (
                             `id_cms` int(11) unsigned NOT NULL,
                             `id_shop` int(11) unsigned NOT NULL,
                             PRIMARY KEY (`id_cms`,`id_shop`),
                             KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_cms_shop`
--

LOCK TABLES `ps_cms_shop` WRITE;
/*!40000 ALTER TABLE `ps_cms_shop` DISABLE KEYS */;
INSERT INTO `ps_cms_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1);
/*!40000 ALTER TABLE `ps_cms_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_compare`
--

DROP TABLE IF EXISTS `ps_compare`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_compare` (
                            `id_compare` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_customer` int(10) unsigned NOT NULL,
                            PRIMARY KEY (`id_compare`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_compare`
--

LOCK TABLES `ps_compare` WRITE;
/*!40000 ALTER TABLE `ps_compare` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_compare` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_compare_product`
--

DROP TABLE IF EXISTS `ps_compare_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_compare_product` (
                                    `id_compare` int(10) unsigned NOT NULL,
                                    `id_product` int(10) unsigned NOT NULL,
                                    `date_add` datetime NOT NULL,
                                    `date_upd` datetime NOT NULL,
                                    PRIMARY KEY (`id_compare`,`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_compare_product`
--

LOCK TABLES `ps_compare_product` WRITE;
/*!40000 ALTER TABLE `ps_compare_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_compare_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_condition`
--

DROP TABLE IF EXISTS `ps_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_condition` (
                              `id_condition` int(11) NOT NULL AUTO_INCREMENT,
                              `id_ps_condition` int(11) NOT NULL,
                              `type` enum('configuration','install','sql') NOT NULL,
                              `request` text DEFAULT NULL,
                              `operator` varchar(32) DEFAULT NULL,
                              `value` varchar(64) DEFAULT NULL,
                              `result` varchar(64) DEFAULT NULL,
                              `calculation_type` enum('hook','time') DEFAULT NULL,
                              `calculation_detail` varchar(64) DEFAULT NULL,
                              `validated` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              `date_add` datetime NOT NULL,
                              `date_upd` datetime NOT NULL,
                              PRIMARY KEY (`id_condition`,`id_ps_condition`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_condition`
--

LOCK TABLES `ps_condition` WRITE;
/*!40000 ALTER TABLE `ps_condition` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_condition_advice`
--

DROP TABLE IF EXISTS `ps_condition_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_condition_advice` (
                                     `id_condition` int(11) NOT NULL,
                                     `id_advice` int(11) NOT NULL,
                                     `display` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                     PRIMARY KEY (`id_condition`,`id_advice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_condition_advice`
--

LOCK TABLES `ps_condition_advice` WRITE;
/*!40000 ALTER TABLE `ps_condition_advice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_condition_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_condition_badge`
--

DROP TABLE IF EXISTS `ps_condition_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_condition_badge` (
                                    `id_condition` int(11) NOT NULL,
                                    `id_badge` int(11) NOT NULL,
                                    PRIMARY KEY (`id_condition`,`id_badge`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_condition_badge`
--

LOCK TABLES `ps_condition_badge` WRITE;
/*!40000 ALTER TABLE `ps_condition_badge` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_condition_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_configuration`
--

DROP TABLE IF EXISTS `ps_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_configuration` (
                                  `id_configuration` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_shop_group` int(11) unsigned DEFAULT NULL,
                                  `id_shop` int(11) unsigned DEFAULT NULL,
                                  `name` varchar(254) NOT NULL,
                                  `value` text DEFAULT NULL,
                                  `date_add` datetime NOT NULL,
                                  `date_upd` datetime NOT NULL,
                                  PRIMARY KEY (`id_configuration`),
                                  KEY `name` (`name`),
                                  KEY `id_shop` (`id_shop`),
                                  KEY `id_shop_group` (`id_shop_group`)
) ENGINE=InnoDB AUTO_INCREMENT=389 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_configuration`
--

LOCK TABLES `ps_configuration` WRITE;
/*!40000 ALTER TABLE `ps_configuration` DISABLE KEYS */;
INSERT INTO `ps_configuration` VALUES (1,NULL,NULL,'PS_LANG_DEFAULT','1','2025-03-04 08:13:14','2025-03-04 08:13:14'),(2,NULL,NULL,'PS_VERSION_DB','1.6.1.24','2025-03-04 08:13:14','2025-03-04 08:13:14'),(3,NULL,NULL,'PS_INSTALL_VERSION','1.6.1.24','2025-03-04 08:13:14','2025-03-04 08:13:14'),(4,NULL,NULL,'PS_CARRIER_DEFAULT','1','2025-03-04 08:13:14','2025-03-04 08:13:14'),(5,NULL,NULL,'PS_GROUP_FEATURE_ACTIVE','1','2025-03-04 08:13:14','2025-03-04 08:13:14'),(6,NULL,NULL,'PS_SEARCH_INDEXATION','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,NULL,NULL,'PS_ONE_PHONE_AT_LEAST','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,NULL,NULL,'PS_CURRENCY_DEFAULT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,NULL,NULL,'PS_COUNTRY_DEFAULT','17','0000-00-00 00:00:00','2025-03-04 08:13:15'),(10,NULL,NULL,'PS_REWRITING_SETTINGS',NULL,'0000-00-00 00:00:00','2025-03-04 08:13:15'),(11,NULL,NULL,'PS_ORDER_OUT_OF_STOCK','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(12,NULL,NULL,'PS_LAST_QTIES','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(13,NULL,NULL,'PS_CART_REDIRECT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(14,NULL,NULL,'PS_CONDITIONS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(15,NULL,NULL,'PS_RECYCLABLE_PACK','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(16,NULL,NULL,'PS_GIFT_WRAPPING','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(17,NULL,NULL,'PS_GIFT_WRAPPING_PRICE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(18,NULL,NULL,'PS_STOCK_MANAGEMENT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(19,NULL,NULL,'PS_NAVIGATION_PIPE','>','0000-00-00 00:00:00','0000-00-00 00:00:00'),(20,NULL,NULL,'PS_PRODUCTS_PER_PAGE','12','0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,NULL,NULL,'PS_PURCHASE_MINIMUM','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,NULL,NULL,'PS_PRODUCTS_ORDER_WAY','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(23,NULL,NULL,'PS_PRODUCTS_ORDER_BY','4','0000-00-00 00:00:00','0000-00-00 00:00:00'),(24,NULL,NULL,'PS_DISPLAY_QTIES','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(25,NULL,NULL,'PS_SHIPPING_HANDLING','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(26,NULL,NULL,'PS_SHIPPING_FREE_PRICE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(27,NULL,NULL,'PS_SHIPPING_FREE_WEIGHT','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(28,NULL,NULL,'PS_SHIPPING_METHOD','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(29,NULL,NULL,'PS_TAX','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(30,NULL,NULL,'PS_SHOP_ENABLE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,NULL,NULL,'PS_NB_DAYS_NEW_PRODUCT','20','0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,NULL,NULL,'PS_SSL_ENABLED','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(33,NULL,NULL,'PS_WEIGHT_UNIT','kg','0000-00-00 00:00:00','0000-00-00 00:00:00'),(34,NULL,NULL,'PS_BLOCK_CART_AJAX','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(35,NULL,NULL,'PS_ORDER_RETURN','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,NULL,NULL,'PS_ORDER_RETURN_NB_DAYS','14','0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,NULL,NULL,'PS_MAIL_TYPE','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(38,NULL,NULL,'PS_PRODUCT_PICTURE_MAX_SIZE','8388608','0000-00-00 00:00:00','0000-00-00 00:00:00'),(39,NULL,NULL,'PS_PRODUCT_PICTURE_WIDTH','64','0000-00-00 00:00:00','0000-00-00 00:00:00'),(40,NULL,NULL,'PS_PRODUCT_PICTURE_HEIGHT','64','0000-00-00 00:00:00','0000-00-00 00:00:00'),(41,NULL,NULL,'PS_INVOICE_PREFIX','#IN','0000-00-00 00:00:00','0000-00-00 00:00:00'),(42,NULL,NULL,'PS_INVCE_INVOICE_ADDR_RULES','{\"avoid\":[]}','0000-00-00 00:00:00','0000-00-00 00:00:00'),(43,NULL,NULL,'PS_INVCE_DELIVERY_ADDR_RULES','{\"avoid\":[]}','0000-00-00 00:00:00','0000-00-00 00:00:00'),(44,NULL,NULL,'PS_DELIVERY_PREFIX','#DE','0000-00-00 00:00:00','0000-00-00 00:00:00'),(45,NULL,NULL,'PS_DELIVERY_NUMBER','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(46,NULL,NULL,'PS_RETURN_PREFIX','#RE','0000-00-00 00:00:00','0000-00-00 00:00:00'),(47,NULL,NULL,'PS_INVOICE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(48,NULL,NULL,'PS_PASSWD_TIME_BACK','360','0000-00-00 00:00:00','0000-00-00 00:00:00'),(49,NULL,NULL,'PS_PASSWD_TIME_FRONT','360','0000-00-00 00:00:00','0000-00-00 00:00:00'),(50,NULL,NULL,'PS_DISP_UNAVAILABLE_ATTR','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(51,NULL,NULL,'PS_SEARCH_MINWORDLEN','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(52,NULL,NULL,'PS_SEARCH_BLACKLIST','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(53,NULL,NULL,'PS_SEARCH_WEIGHT_PNAME','6','0000-00-00 00:00:00','0000-00-00 00:00:00'),(54,NULL,NULL,'PS_SEARCH_WEIGHT_REF','10','0000-00-00 00:00:00','0000-00-00 00:00:00'),(55,NULL,NULL,'PS_SEARCH_WEIGHT_SHORTDESC','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(56,NULL,NULL,'PS_SEARCH_WEIGHT_DESC','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(57,NULL,NULL,'PS_SEARCH_WEIGHT_CNAME','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(58,NULL,NULL,'PS_SEARCH_WEIGHT_MNAME','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(59,NULL,NULL,'PS_SEARCH_WEIGHT_TAG','4','0000-00-00 00:00:00','0000-00-00 00:00:00'),(60,NULL,NULL,'PS_SEARCH_WEIGHT_ATTRIBUTE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(61,NULL,NULL,'PS_SEARCH_WEIGHT_FEATURE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(62,NULL,NULL,'PS_SEARCH_AJAX','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(63,NULL,NULL,'PS_TIMEZONE','Europe/Paris','0000-00-00 00:00:00','0000-00-00 00:00:00'),(64,NULL,NULL,'PS_THEME_V11','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(65,NULL,NULL,'PRESTASTORE_LIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(66,NULL,NULL,'PS_TIN_ACTIVE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(67,NULL,NULL,'PS_SHOW_ALL_MODULES','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(68,NULL,NULL,'PS_BACKUP_ALL','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(69,NULL,NULL,'PS_1_3_UPDATE_DATE','2011-12-27 10:20:42','0000-00-00 00:00:00','0000-00-00 00:00:00'),(70,NULL,NULL,'PS_PRICE_ROUND_MODE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(71,NULL,NULL,'PS_1_3_2_UPDATE_DATE','2011-12-27 10:20:42','0000-00-00 00:00:00','0000-00-00 00:00:00'),(72,NULL,NULL,'PS_CONDITIONS_CMS_ID','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(73,NULL,NULL,'TRACKING_DIRECT_TRAFFIC','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(74,NULL,NULL,'PS_META_KEYWORDS','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(75,NULL,NULL,'PS_DISPLAY_JQZOOM','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(76,NULL,NULL,'PS_VOLUME_UNIT','cl','0000-00-00 00:00:00','0000-00-00 00:00:00'),(77,NULL,NULL,'PS_CIPHER_ALGORITHM','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(78,NULL,NULL,'PS_ATTRIBUTE_CATEGORY_DISPLAY','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(79,NULL,NULL,'PS_CUSTOMER_SERVICE_FILE_UPLOAD','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(80,NULL,NULL,'PS_CUSTOMER_SERVICE_SIGNATURE','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(81,NULL,NULL,'PS_BLOCK_BESTSELLERS_DISPLAY','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(82,NULL,NULL,'PS_BLOCK_NEWPRODUCTS_DISPLAY','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(83,NULL,NULL,'PS_BLOCK_SPECIALS_DISPLAY','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(84,NULL,NULL,'PS_STOCK_MVT_REASON_DEFAULT','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(85,NULL,NULL,'PS_COMPARATOR_MAX_ITEM','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(86,NULL,NULL,'PS_ORDER_PROCESS_TYPE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(87,NULL,NULL,'PS_SPECIFIC_PRICE_PRIORITIES','id_shop;id_currency;id_country;id_group','0000-00-00 00:00:00','0000-00-00 00:00:00'),(88,NULL,NULL,'PS_TAX_DISPLAY','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(89,NULL,NULL,'PS_SMARTY_FORCE_COMPILE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(90,NULL,NULL,'PS_DISTANCE_UNIT','km','0000-00-00 00:00:00','0000-00-00 00:00:00'),(91,NULL,NULL,'PS_STORES_DISPLAY_CMS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(92,NULL,NULL,'PS_STORES_DISPLAY_FOOTER','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(93,NULL,NULL,'PS_STORES_SIMPLIFIED','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(94,NULL,NULL,'SHOP_LOGO_WIDTH','350','0000-00-00 00:00:00','2025-03-04 08:13:15'),(95,NULL,NULL,'SHOP_LOGO_HEIGHT','99','0000-00-00 00:00:00','2025-03-04 08:13:15'),(96,NULL,NULL,'EDITORIAL_IMAGE_WIDTH','530','0000-00-00 00:00:00','0000-00-00 00:00:00'),(97,NULL,NULL,'EDITORIAL_IMAGE_HEIGHT','228','0000-00-00 00:00:00','0000-00-00 00:00:00'),(98,NULL,NULL,'PS_STATSDATA_CUSTOMER_PAGESVIEWS','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(99,NULL,NULL,'PS_STATSDATA_PAGESVIEWS','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(100,NULL,NULL,'PS_STATSDATA_PLUGINS','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(101,NULL,NULL,'PS_GEOLOCATION_ENABLED','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(102,NULL,NULL,'PS_ALLOWED_COUNTRIES','AF;ZA;AX;AL;DZ;DE;AD;AO;AI;AQ;AG;AN;SA;AR;AM;AW;AU;AT;AZ;BS;BH;BD;BB;BY;BE;BZ;BJ;BM;BT;BO;BA;BW;BV;BR;BN;BG;BF;MM;BI;KY;KH;CM;CA;CV;CF;CL;CN;CX;CY;CC;CO;KM;CG;CD;CK;KR;KP;CR;CI;HR;CU;DK;DJ;DM;EG;IE;SV;AE;EC;ER;ES;EE;ET;FK;FO;FJ;FI;FR;GA;GM;GE;GS;GH;GI;GR;GD;GL;GP;GU;GT;GG;GN;GQ;GW;GY;GF;HT;HM;HN;HK;HU;IM;MU;VG;VI;IN;ID;IR;IQ;IS;IL;IT;JM;JP;JE;JO;KZ;KE;KG;KI;KW;LA;LS;LV;LB;LR;LY;LI;LT;LU;MO;MK;MG;MY;MW;MV;ML;MT;MP;MA;MH;MQ;MR;YT;MX;FM;MD;MC;MN;ME;MS;MZ;NA;NR;NP;NI;NE;NG;NU;NF;NO;NC;NZ;IO;OM;UG;UZ;PK;PW;PS;PA;PG;PY;NL;PE;PH;PN;PL;PF;PR;PT;QA;DO;CZ;RE;RO;GB;RU;RW;EH;BL;KN;SM;MF;PM;VA;VC;LC;SB;WS;AS;ST;SN;RS;SC;SL;SG;SK;SI;SO;SD;LK;SE;CH;SR;SJ;SZ;SY;TJ;TW;TZ;TD;TF;TH;TL;TG;TK;TO;TT;TN;TM;TC;TR;TV;UA;UY;US;VU;VE;VN;WF;YE;ZM;ZW','0000-00-00 00:00:00','0000-00-00 00:00:00'),(103,NULL,NULL,'PS_GEOLOCATION_BEHAVIOR','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(104,NULL,NULL,'PS_LOCALE_LANGUAGE','en','0000-00-00 00:00:00','2025-03-04 08:13:15'),(105,NULL,NULL,'PS_LOCALE_COUNTRY','GB','0000-00-00 00:00:00','2025-03-04 08:13:15'),(106,NULL,NULL,'PS_ATTACHMENT_MAXIMUM_SIZE','8','0000-00-00 00:00:00','0000-00-00 00:00:00'),(107,NULL,NULL,'PS_SMARTY_CACHE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(108,NULL,NULL,'PS_DIMENSION_UNIT','cm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(109,NULL,NULL,'PS_GUEST_CHECKOUT_ENABLED','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(110,NULL,NULL,'PS_DISPLAY_SUPPLIERS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(111,NULL,NULL,'PS_DISPLAY_BEST_SELLERS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(112,NULL,NULL,'PS_CATALOG_MODE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(113,NULL,NULL,'PS_GEOLOCATION_WHITELIST','127;209.185.108;209.185.253;209.85.238;209.85.238.11;209.85.238.4;216.239.33.96;216.239.33.97;216.239.33.98;216.239.33.99;216.239.37.98;216.239.37.99;216.239.39.98;216.239.39.99;216.239.41.96;216.239.41.97;216.239.41.98;216.239.41.99;216.239.45.4;216.239.46;216.239.51.96;216.239.51.97;216.239.51.98;216.239.51.99;216.239.53.98;216.239.53.99;216.239.57.96;91.240.109;216.239.57.97;216.239.57.98;216.239.57.99;216.239.59.98;216.239.59.99;216.33.229.163;64.233.173.193;64.233.173.194;64.233.173.195;64.233.173.196;64.233.173.197;64.233.173.198;64.233.173.199;64.233.173.200;64.233.173.201;64.233.173.202;64.233.173.203;64.233.173.204;64.233.173.205;64.233.173.206;64.233.173.207;64.233.173.208;64.233.173.209;64.233.173.210;64.233.173.211;64.233.173.212;64.233.173.213;64.233.173.214;64.233.173.215;64.233.173.216;64.233.173.217;64.233.173.218;64.233.173.219;64.233.173.220;64.233.173.221;64.233.173.222;64.233.173.223;64.233.173.224;64.233.173.225;64.233.173.226;64.233.173.227;64.233.173.228;64.233.173.229;64.233.173.230;64.233.173.231;64.233.173.232;64.233.173.233;64.233.173.234;64.233.173.235;64.233.173.236;64.233.173.237;64.233.173.238;64.233.173.239;64.233.173.240;64.233.173.241;64.233.173.242;64.233.173.243;64.233.173.244;64.233.173.245;64.233.173.246;64.233.173.247;64.233.173.248;64.233.173.249;64.233.173.250;64.233.173.251;64.233.173.252;64.233.173.253;64.233.173.254;64.233.173.255;64.68.80;64.68.81;64.68.82;64.68.83;64.68.84;64.68.85;64.68.86;64.68.87;64.68.88;64.68.89;64.68.90.1;64.68.90.10;64.68.90.11;64.68.90.12;64.68.90.129;64.68.90.13;64.68.90.130;64.68.90.131;64.68.90.132;64.68.90.133;64.68.90.134;64.68.90.135;64.68.90.136;64.68.90.137;64.68.90.138;64.68.90.139;64.68.90.14;64.68.90.140;64.68.90.141;64.68.90.142;64.68.90.143;64.68.90.144;64.68.90.145;64.68.90.146;64.68.90.147;64.68.90.148;64.68.90.149;64.68.90.15;64.68.90.150;64.68.90.151;64.68.90.152;64.68.90.153;64.68.90.154;64.68.90.155;64.68.90.156;64.68.90.157;64.68.90.158;64.68.90.159;64.68.90.16;64.68.90.160;64.68.90.161;64.68.90.162;64.68.90.163;64.68.90.164;64.68.90.165;64.68.90.166;64.68.90.167;64.68.90.168;64.68.90.169;64.68.90.17;64.68.90.170;64.68.90.171;64.68.90.172;64.68.90.173;64.68.90.174;64.68.90.175;64.68.90.176;64.68.90.177;64.68.90.178;64.68.90.179;64.68.90.18;64.68.90.180;64.68.90.181;64.68.90.182;64.68.90.183;64.68.90.184;64.68.90.185;64.68.90.186;64.68.90.187;64.68.90.188;64.68.90.189;64.68.90.19;64.68.90.190;64.68.90.191;64.68.90.192;64.68.90.193;64.68.90.194;64.68.90.195;64.68.90.196;64.68.90.197;64.68.90.198;64.68.90.199;64.68.90.2;64.68.90.20;64.68.90.200;64.68.90.201;64.68.90.202;64.68.90.203;64.68.90.204;64.68.90.205;64.68.90.206;64.68.90.207;64.68.90.208;64.68.90.21;64.68.90.22;64.68.90.23;64.68.90.24;64.68.90.25;64.68.90.26;64.68.90.27;64.68.90.28;64.68.90.29;64.68.90.3;64.68.90.30;64.68.90.31;64.68.90.32;64.68.90.33;64.68.90.34;64.68.90.35;64.68.90.36;64.68.90.37;64.68.90.38;64.68.90.39;64.68.90.4;64.68.90.40;64.68.90.41;64.68.90.42;64.68.90.43;64.68.90.44;64.68.90.45;64.68.90.46;64.68.90.47;64.68.90.48;64.68.90.49;64.68.90.5;64.68.90.50;64.68.90.51;64.68.90.52;64.68.90.53;64.68.90.54;64.68.90.55;64.68.90.56;64.68.90.57;64.68.90.58;64.68.90.59;64.68.90.6;64.68.90.60;64.68.90.61;64.68.90.62;64.68.90.63;64.68.90.64;64.68.90.65;64.68.90.66;64.68.90.67;64.68.90.68;64.68.90.69;64.68.90.7;64.68.90.70;64.68.90.71;64.68.90.72;64.68.90.73;64.68.90.74;64.68.90.75;64.68.90.76;64.68.90.77;64.68.90.78;64.68.90.79;64.68.90.8;64.68.90.80;64.68.90.9;64.68.91;64.68.92;66.249.64;66.249.65;66.249.66;66.249.67;66.249.68;66.249.69;66.249.70;66.249.71;66.249.72;66.249.73;66.249.78;66.249.79;72.14.199;8.6.48','0000-00-00 00:00:00','0000-00-00 00:00:00'),(114,NULL,NULL,'PS_LOGS_BY_EMAIL','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(115,NULL,NULL,'PS_COOKIE_CHECKIP','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(116,NULL,NULL,'PS_STORES_CENTER_LAT','25.948969','0000-00-00 00:00:00','0000-00-00 00:00:00'),(117,NULL,NULL,'PS_STORES_CENTER_LONG','-80.226439','0000-00-00 00:00:00','0000-00-00 00:00:00'),(118,NULL,NULL,'PS_USE_ECOTAX','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(119,NULL,NULL,'PS_CANONICAL_REDIRECT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(120,NULL,NULL,'PS_IMG_UPDATE_TIME','1324977642','0000-00-00 00:00:00','0000-00-00 00:00:00'),(121,NULL,NULL,'PS_BACKUP_DROP_TABLE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(122,NULL,NULL,'PS_OS_CHEQUE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(123,NULL,NULL,'PS_OS_PAYMENT','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(124,NULL,NULL,'PS_OS_PREPARATION','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(125,NULL,NULL,'PS_OS_SHIPPING','4','0000-00-00 00:00:00','0000-00-00 00:00:00'),(126,NULL,NULL,'PS_OS_DELIVERED','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(127,NULL,NULL,'PS_OS_CANCELED','6','0000-00-00 00:00:00','0000-00-00 00:00:00'),(128,NULL,NULL,'PS_OS_REFUND','7','0000-00-00 00:00:00','0000-00-00 00:00:00'),(129,NULL,NULL,'PS_OS_ERROR','8','0000-00-00 00:00:00','0000-00-00 00:00:00'),(130,NULL,NULL,'PS_OS_OUTOFSTOCK','9','0000-00-00 00:00:00','0000-00-00 00:00:00'),(131,NULL,NULL,'PS_OS_BANKWIRE','10','0000-00-00 00:00:00','0000-00-00 00:00:00'),(132,NULL,NULL,'PS_OS_PAYPAL','11','0000-00-00 00:00:00','0000-00-00 00:00:00'),(133,NULL,NULL,'PS_OS_WS_PAYMENT','12','0000-00-00 00:00:00','0000-00-00 00:00:00'),(134,NULL,NULL,'PS_OS_OUTOFSTOCK_PAID','9','0000-00-00 00:00:00','0000-00-00 00:00:00'),(135,NULL,NULL,'PS_OS_OUTOFSTOCK_UNPAID','13','0000-00-00 00:00:00','0000-00-00 00:00:00'),(136,NULL,NULL,'PS_OS_COD_VALIDATION','14','0000-00-00 00:00:00','0000-00-00 00:00:00'),(137,NULL,NULL,'PS_LEGACY_IMAGES','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(138,NULL,NULL,'PS_IMAGE_QUALITY','jpg','0000-00-00 00:00:00','0000-00-00 00:00:00'),(139,NULL,NULL,'PS_PNG_QUALITY','7','0000-00-00 00:00:00','0000-00-00 00:00:00'),(140,NULL,NULL,'PS_JPEG_QUALITY','90','0000-00-00 00:00:00','0000-00-00 00:00:00'),(141,NULL,NULL,'PS_COOKIE_LIFETIME_FO','480','0000-00-00 00:00:00','0000-00-00 00:00:00'),(142,NULL,NULL,'PS_COOKIE_LIFETIME_BO','480','0000-00-00 00:00:00','0000-00-00 00:00:00'),(143,NULL,NULL,'PS_RESTRICT_DELIVERED_COUNTRIES','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(144,NULL,NULL,'PS_SHOW_NEW_ORDERS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(145,NULL,NULL,'PS_SHOW_NEW_CUSTOMERS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(146,NULL,NULL,'PS_SHOW_NEW_MESSAGES','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(147,NULL,NULL,'PS_FEATURE_FEATURE_ACTIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(148,NULL,NULL,'PS_COMBINATION_FEATURE_ACTIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(149,NULL,NULL,'PS_SPECIFIC_PRICE_FEATURE_ACTIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(150,NULL,NULL,'PS_SCENE_FEATURE_ACTIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(151,NULL,NULL,'PS_VIRTUAL_PROD_FEATURE_ACTIVE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(152,NULL,NULL,'PS_CUSTOMIZATION_FEATURE_ACTIVE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(153,NULL,NULL,'PS_CART_RULE_FEATURE_ACTIVE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(154,NULL,NULL,'PS_PACK_FEATURE_ACTIVE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(155,NULL,NULL,'PS_ALIAS_FEATURE_ACTIVE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(156,NULL,NULL,'PS_TAX_ADDRESS_TYPE','id_address_delivery','0000-00-00 00:00:00','0000-00-00 00:00:00'),(157,NULL,NULL,'PS_SHOP_DEFAULT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(158,NULL,NULL,'PS_CARRIER_DEFAULT_SORT','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(159,NULL,NULL,'PS_STOCK_MVT_INC_REASON_DEFAULT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(160,NULL,NULL,'PS_STOCK_MVT_DEC_REASON_DEFAULT','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(161,NULL,NULL,'PS_ADVANCED_STOCK_MANAGEMENT','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(162,NULL,NULL,'PS_ADMINREFRESH_NOTIFICATION','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(163,NULL,NULL,'PS_STOCK_MVT_TRANSFER_TO','7','0000-00-00 00:00:00','0000-00-00 00:00:00'),(164,NULL,NULL,'PS_STOCK_MVT_TRANSFER_FROM','6','0000-00-00 00:00:00','0000-00-00 00:00:00'),(165,NULL,NULL,'PS_CARRIER_DEFAULT_ORDER','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(166,NULL,NULL,'PS_STOCK_MVT_SUPPLY_ORDER','8','0000-00-00 00:00:00','0000-00-00 00:00:00'),(167,NULL,NULL,'PS_STOCK_CUSTOMER_ORDER_REASON','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(168,NULL,NULL,'PS_UNIDENTIFIED_GROUP','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(169,NULL,NULL,'PS_GUEST_GROUP','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(170,NULL,NULL,'PS_CUSTOMER_GROUP','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(171,NULL,NULL,'PS_SMARTY_CONSOLE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(172,NULL,NULL,'PS_INVOICE_MODEL','invoice','0000-00-00 00:00:00','0000-00-00 00:00:00'),(173,NULL,NULL,'PS_LIMIT_UPLOAD_IMAGE_VALUE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(174,NULL,NULL,'PS_LIMIT_UPLOAD_FILE_VALUE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(175,NULL,NULL,'MB_PAY_TO_EMAIL','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(176,NULL,NULL,'MB_SECRET_WORD','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(177,NULL,NULL,'MB_HIDE_LOGIN','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(178,NULL,NULL,'MB_ID_LOGO','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(179,NULL,NULL,'MB_ID_LOGO_WALLET','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(180,NULL,NULL,'MB_PARAMETERS','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(181,NULL,NULL,'MB_PARAMETERS_2','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(182,NULL,NULL,'MB_DISPLAY_MODE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(183,NULL,NULL,'MB_CANCEL_URL','http://www.yoursite.com','0000-00-00 00:00:00','0000-00-00 00:00:00'),(184,NULL,NULL,'MB_LOCAL_METHODS','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(185,NULL,NULL,'MB_INTER_METHODS','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(186,NULL,NULL,'BANK_WIRE_CURRENCIES','2,1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(187,NULL,NULL,'CHEQUE_CURRENCIES','2,1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(188,NULL,NULL,'PRODUCTS_VIEWED_NBR','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(189,NULL,NULL,'BLOCK_CATEG_DHTML','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(190,NULL,NULL,'BLOCK_CATEG_MAX_DEPTH','4','0000-00-00 00:00:00','0000-00-00 00:00:00'),(191,NULL,NULL,'MANUFACTURER_DISPLAY_FORM','1','0000-00-00 00:00:00','2025-03-04 08:13:16'),(192,NULL,NULL,'MANUFACTURER_DISPLAY_TEXT','1','0000-00-00 00:00:00','2025-03-04 08:13:16'),(193,NULL,NULL,'MANUFACTURER_DISPLAY_TEXT_NB','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(194,NULL,NULL,'NEW_PRODUCTS_NBR','8','0000-00-00 00:00:00','0000-00-00 00:00:00'),(195,NULL,NULL,'PS_TOKEN_ENABLE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(196,NULL,NULL,'PS_STATS_RENDER','graphnvd3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(197,NULL,NULL,'PS_STATS_OLD_CONNECT_AUTO_CLEAN','never','0000-00-00 00:00:00','0000-00-00 00:00:00'),(198,NULL,NULL,'PS_STATS_GRID_RENDER','gridhtml','0000-00-00 00:00:00','0000-00-00 00:00:00'),(199,NULL,NULL,'BLOCKTAGS_NBR','10','0000-00-00 00:00:00','0000-00-00 00:00:00'),(200,NULL,NULL,'CHECKUP_DESCRIPTIONS_LT','100','0000-00-00 00:00:00','0000-00-00 00:00:00'),(201,NULL,NULL,'CHECKUP_DESCRIPTIONS_GT','400','0000-00-00 00:00:00','0000-00-00 00:00:00'),(202,NULL,NULL,'CHECKUP_IMAGES_LT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(203,NULL,NULL,'CHECKUP_IMAGES_GT','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(204,NULL,NULL,'CHECKUP_SALES_LT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(205,NULL,NULL,'CHECKUP_SALES_GT','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(206,NULL,NULL,'CHECKUP_STOCK_LT','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(207,NULL,NULL,'CHECKUP_STOCK_GT','3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(208,NULL,NULL,'FOOTER_CMS','0_3|0_4','0000-00-00 00:00:00','2025-03-04 08:13:16'),(209,NULL,NULL,'FOOTER_BLOCK_ACTIVATION','0_3|0_4','0000-00-00 00:00:00','2025-03-04 08:13:16'),(210,NULL,NULL,'FOOTER_POWEREDBY','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(211,NULL,NULL,'BLOCKADVERT_LINK','http://www.prestashop.com','0000-00-00 00:00:00','0000-00-00 00:00:00'),(212,NULL,NULL,'BLOCKSTORE_IMG','store.jpg','0000-00-00 00:00:00','0000-00-00 00:00:00'),(213,NULL,NULL,'BLOCKADVERT_IMG_EXT','jpg','0000-00-00 00:00:00','0000-00-00 00:00:00'),(214,NULL,NULL,'MOD_BLOCKTOPMENU_ITEMS','CAT3,CAT8,CAT5,LNK1','0000-00-00 00:00:00','2025-03-04 08:13:16'),(215,NULL,NULL,'MOD_BLOCKTOPMENU_SEARCH','0','0000-00-00 00:00:00','2025-03-04 08:13:16'),(216,NULL,NULL,'BLOCKSOCIAL_FACEBOOK','http://www.facebook.com/prestashop','0000-00-00 00:00:00','2025-03-04 08:13:16'),(217,NULL,NULL,'BLOCKSOCIAL_TWITTER','http://www.twitter.com/prestashop','0000-00-00 00:00:00','2025-03-04 08:13:16'),(218,NULL,NULL,'BLOCKSOCIAL_RSS','http://www.prestashop.com/blog/en/','0000-00-00 00:00:00','2025-03-04 08:13:16'),(219,NULL,NULL,'BLOCKCONTACTINFOS_COMPANY','My Company','0000-00-00 00:00:00','2025-03-04 08:13:16'),(220,NULL,NULL,'BLOCKCONTACTINFOS_ADDRESS','42 Puffin street\n12345 Puffinville\nFrance','0000-00-00 00:00:00','2025-03-04 08:13:16'),(221,NULL,NULL,'BLOCKCONTACTINFOS_PHONE','0123-456-789','0000-00-00 00:00:00','2025-03-04 08:13:16'),(222,NULL,NULL,'BLOCKCONTACTINFOS_EMAIL','sales@yourcompany.com','0000-00-00 00:00:00','2025-03-04 08:13:16'),(223,NULL,NULL,'BLOCKCONTACT_TELNUMBER','0123-456-789','0000-00-00 00:00:00','2025-03-04 08:13:16'),(224,NULL,NULL,'BLOCKCONTACT_EMAIL','sales@yourcompany.com','0000-00-00 00:00:00','2025-03-04 08:13:16'),(225,NULL,NULL,'SUPPLIER_DISPLAY_TEXT','1','0000-00-00 00:00:00','2025-03-04 08:13:16'),(226,NULL,NULL,'SUPPLIER_DISPLAY_TEXT_NB','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(227,NULL,NULL,'SUPPLIER_DISPLAY_FORM','1','0000-00-00 00:00:00','2025-03-04 08:13:16'),(228,NULL,NULL,'BLOCK_CATEG_NBR_COLUMN_FOOTER','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(229,NULL,NULL,'UPGRADER_BACKUPDB_FILENAME','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(230,NULL,NULL,'UPGRADER_BACKUPFILES_FILENAME','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(231,NULL,NULL,'BLOCKREINSURANCE_NBBLOCKS','5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(232,NULL,NULL,'HOMESLIDER_WIDTH','779','0000-00-00 00:00:00','2025-03-04 08:13:16'),(233,NULL,NULL,'HOMESLIDER_SPEED','500','0000-00-00 00:00:00','2025-03-04 08:13:16'),(234,NULL,NULL,'HOMESLIDER_PAUSE','3000','0000-00-00 00:00:00','2025-03-04 08:13:16'),(235,NULL,NULL,'HOMESLIDER_LOOP','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(236,NULL,NULL,'PS_BASE_DISTANCE_UNIT','m','0000-00-00 00:00:00','0000-00-00 00:00:00'),(237,NULL,NULL,'PS_SHOP_DOMAIN','localhost:8000','0000-00-00 00:00:00','2025-03-04 08:13:15'),(238,NULL,NULL,'PS_SHOP_DOMAIN_SSL','localhost:8000','0000-00-00 00:00:00','2025-03-04 08:13:15'),(239,NULL,NULL,'PS_SHOP_NAME','PrestaShop','0000-00-00 00:00:00','0000-00-00 00:00:00'),(240,NULL,NULL,'PS_SHOP_EMAIL','admin@prestashop.com','0000-00-00 00:00:00','2025-03-04 08:13:15'),(241,NULL,NULL,'PS_MAIL_METHOD','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(242,NULL,NULL,'PS_SHOP_ACTIVITY','Animaux','0000-00-00 00:00:00','0000-00-00 00:00:00'),(243,NULL,NULL,'PS_LOGO','logo.jpg','0000-00-00 00:00:00','0000-00-00 00:00:00'),(244,NULL,NULL,'PS_FAVICON','favicon.ico','0000-00-00 00:00:00','0000-00-00 00:00:00'),(245,NULL,NULL,'PS_STORES_ICON','logo_stores.png','0000-00-00 00:00:00','0000-00-00 00:00:00'),(246,NULL,NULL,'PS_ROOT_CATEGORY','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(247,NULL,NULL,'PS_HOME_CATEGORY','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(248,NULL,NULL,'PS_CONFIGURATION_AGREMENT','1','0000-00-00 00:00:00','2025-03-04 08:13:15'),(249,NULL,NULL,'PS_MAIL_SERVER','smtp.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(250,NULL,NULL,'PS_MAIL_USER','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(251,NULL,NULL,'PS_MAIL_PASSWD','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(252,NULL,NULL,'PS_MAIL_SMTP_ENCRYPTION','off','0000-00-00 00:00:00','0000-00-00 00:00:00'),(253,NULL,NULL,'PS_MAIL_SMTP_PORT','25','0000-00-00 00:00:00','0000-00-00 00:00:00'),(254,NULL,NULL,'PS_MAIL_COLOR','#db3484','0000-00-00 00:00:00','0000-00-00 00:00:00'),(255,NULL,NULL,'NW_SALT','XMKk4iJYWkikw5fd','0000-00-00 00:00:00','2025-03-04 08:13:16'),(256,NULL,NULL,'PS_PAYMENT_LOGO_CMS_ID','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(257,NULL,NULL,'HOME_FEATURED_NBR','8','0000-00-00 00:00:00','0000-00-00 00:00:00'),(258,NULL,NULL,'SEK_MIN_OCCURENCES','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(259,NULL,NULL,'SEK_FILTER_KW','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(260,NULL,NULL,'PS_ALLOW_MOBILE_DEVICE','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(261,NULL,NULL,'PS_CUSTOMER_CREATION_EMAIL','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(262,NULL,NULL,'PS_SMARTY_CONSOLE_KEY','SMARTY_DEBUG','0000-00-00 00:00:00','0000-00-00 00:00:00'),(263,NULL,NULL,'PS_DASHBOARD_USE_PUSH','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(264,NULL,NULL,'PS_ATTRIBUTE_ANCHOR_SEPARATOR','-','0000-00-00 00:00:00','0000-00-00 00:00:00'),(265,NULL,NULL,'CONF_AVERAGE_PRODUCT_MARGIN','40','0000-00-00 00:00:00','0000-00-00 00:00:00'),(266,NULL,NULL,'PS_DASHBOARD_SIMULATION','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(267,NULL,NULL,'PS_QUICK_VIEW','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(268,NULL,NULL,'PS_USE_HTMLPURIFIER','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(269,NULL,NULL,'PS_SMARTY_CACHING_TYPE','filesystem','0000-00-00 00:00:00','0000-00-00 00:00:00'),(270,NULL,NULL,'PS_SMARTY_CLEAR_CACHE','everytime','0000-00-00 00:00:00','0000-00-00 00:00:00'),(271,NULL,NULL,'PS_DETECT_LANG','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(272,NULL,NULL,'PS_DETECT_COUNTRY','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(273,NULL,NULL,'PS_ROUND_TYPE','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(274,NULL,NULL,'PS_PRICE_DISPLAY_PRECISION','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(275,NULL,NULL,'PS_LOG_EMAILS','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(276,NULL,NULL,'PS_CUSTOMER_NWSL','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(277,NULL,NULL,'PS_CUSTOMER_OPTIN','1','0000-00-00 00:00:00','0000-00-00 00:00:00'),(278,NULL,NULL,'PS_PACK_STOCK_TYPE','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(279,NULL,NULL,'PS_LOG_MODULE_PERFS_MODULO','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(280,NULL,NULL,'PS_DISALLOW_HISTORY_REORDERING','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(281,NULL,NULL,'PS_DISPLAY_PRODUCT_WEIGHT','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(282,NULL,NULL,'PS_PRODUCT_WEIGHT_PRECISION','2','0000-00-00 00:00:00','0000-00-00 00:00:00'),(283,NULL,NULL,'PS_ADVANCED_PAYMENT_API','0','0000-00-00 00:00:00','0000-00-00 00:00:00'),(284,NULL,NULL,'PS_INSTALL_XML_LOADERS_ID','{\"cms_category:Home\":\"1\",\"cms:Delivery\":\"1\",\"cms:Legal_Notice\":\"2\",\"cms:Terms_and_conditions_of_use\":\"3\",\"cms:About_us\":\"4\",\"cms:Secure_payment\":\"5\",\"zone:Europe\":\"1\",\"zone:North_America\":\"2\",\"zone:Asia\":\"3\",\"zone:Africa\":\"4\",\"zone:Oceania\":\"5\",\"zone:South_America\":\"6\",\"zone:Europe_out_E_U\":\"7\",\"zone:Central_America_Antilla\":\"8\",\"country:DE\":1,\"country:AT\":2,\"country:BE\":3,\"country:CA\":4,\"country:CN\":5,\"country:ES\":6,\"country:FI\":7,\"country:FR\":8,\"country:GR\":9,\"country:IT\":10,\"country:JP\":11,\"country:LU\":12,\"country:NL\":13,\"country:PL\":14,\"country:PT\":15,\"country:CZ\":16,\"country:GB\":17,\"country:SE\":18,\"country:CH\":19,\"country:DK\":20,\"country:US\":21,\"country:HK\":22,\"country:NO\":23,\"country:AU\":24,\"country:SG\":25,\"country:IE\":26,\"country:NZ\":27,\"country:KR\":28,\"country:IL\":29,\"country:ZA\":30,\"country:NG\":31,\"country:CI\":32,\"country:TG\":33,\"country:BO\":34,\"country:MU\":35,\"country:RO\":36,\"country:SK\":37,\"country:DZ\":38,\"country:AS\":39,\"country:AD\":40,\"country:AO\":41,\"country:AI\":42,\"country:AG\":43,\"country:AR\":44,\"country:AM\":45,\"country:AW\":46,\"country:AZ\":47,\"country:BS\":48,\"country:BH\":49,\"country:BD\":50,\"country:BB\":51,\"country:BY\":52,\"country:BZ\":53,\"country:BJ\":54,\"country:BM\":55,\"country:BT\":56,\"country:BW\":57,\"country:BR\":58,\"country:BN\":59,\"country:BF\":60,\"country:MM\":61,\"country:BI\":62,\"country:KH\":63,\"country:CM\":64,\"country:CV\":65,\"country:CF\":66,\"country:TD\":67,\"country:CL\":68,\"country:CO\":69,\"country:KM\":70,\"country:CD\":71,\"country:CG\":72,\"country:CR\":73,\"country:HR\":74,\"country:CU\":75,\"country:CY\":76,\"country:DJ\":77,\"country:DM\":78,\"country:DO\":79,\"country:TL\":80,\"country:EC\":81,\"country:EG\":82,\"country:SV\":83,\"country:GQ\":84,\"country:ER\":85,\"country:EE\":86,\"country:ET\":87,\"country:FK\":88,\"country:FO\":89,\"country:FJ\":90,\"country:GA\":91,\"country:GM\":92,\"country:GE\":93,\"country:GH\":94,\"country:GD\":95,\"country:GL\":96,\"country:GI\":97,\"country:GP\":98,\"country:GU\":99,\"country:GT\":100,\"country:GG\":101,\"country:GN\":102,\"country:GW\":103,\"country:GY\":104,\"country:HT\":105,\"country:HM\":106,\"country:VA\":107,\"country:HN\":108,\"country:IS\":109,\"country:IN\":110,\"country:ID\":111,\"country:IR\":112,\"country:IQ\":113,\"country:IM\":114,\"country:JM\":115,\"country:JE\":116,\"country:JO\":117,\"country:KZ\":118,\"country:KE\":119,\"country:KI\":120,\"country:KP\":121,\"country:KW\":122,\"country:KG\":123,\"country:LA\":124,\"country:LV\":125,\"country:LB\":126,\"country:LS\":127,\"country:LR\":128,\"country:LY\":129,\"country:LI\":130,\"country:LT\":131,\"country:MO\":132,\"country:MK\":133,\"country:MG\":134,\"country:MW\":135,\"country:MY\":136,\"country:MV\":137,\"country:ML\":138,\"country:MT\":139,\"country:MH\":140,\"country:MQ\":141,\"country:MR\":142,\"country:HU\":143,\"country:YT\":144,\"country:MX\":145,\"country:FM\":146,\"country:MD\":147,\"country:MC\":148,\"country:MN\":149,\"country:ME\":150,\"country:MS\":151,\"country:MA\":152,\"country:MZ\":153,\"country:NA\":154,\"country:NR\":155,\"country:NP\":156,\"country:AN\":157,\"country:NC\":158,\"country:NI\":159,\"country:NE\":160,\"country:NU\":161,\"country:NF\":162,\"country:MP\":163,\"country:OM\":164,\"country:PK\":165,\"country:PW\":166,\"country:PS\":167,\"country:PA\":168,\"country:PG\":169,\"country:PY\":170,\"country:PE\":171,\"country:PH\":172,\"country:PN\":173,\"country:PR\":174,\"country:QA\":175,\"country:RE\":176,\"country:RU\":177,\"country:RW\":178,\"country:BL\":179,\"country:KN\":180,\"country:LC\":181,\"country:MF\":182,\"country:PM\":183,\"country:VC\":184,\"country:WS\":185,\"country:SM\":186,\"country:ST\":187,\"country:SA\":188,\"country:SN\":189,\"country:RS\":190,\"country:SC\":191,\"country:SL\":192,\"country:SI\":193,\"country:SB\":194,\"country:SO\":195,\"country:GS\":196,\"country:LK\":197,\"country:SD\":198,\"country:SR\":199,\"country:SJ\":200,\"country:SZ\":201,\"country:SY\":202,\"country:TW\":203,\"country:TJ\":204,\"country:TZ\":205,\"country:TH\":206,\"country:TK\":207,\"country:TO\":208,\"country:TT\":209,\"country:TN\":210,\"country:TR\":211,\"country:TM\":212,\"country:TC\":213,\"country:TV\":214,\"country:UG\":215,\"country:UA\":216,\"country:AE\":217,\"country:UY\":218,\"country:UZ\":219,\"country:VU\":220,\"country:VE\":221,\"country:VN\":222,\"country:VG\":223,\"country:VI\":224,\"country:WF\":225,\"country:EH\":226,\"country:YE\":227,\"country:ZM\":228,\"country:ZW\":229,\"country:AL\":230,\"country:AF\":231,\"country:AQ\":232,\"country:BA\":233,\"country:BV\":234,\"country:IO\":235,\"country:BG\":236,\"country:KY\":237,\"country:CX\":238,\"country:CC\":239,\"country:CK\":240,\"country:GF\":241,\"country:PF\":242,\"country:TF\":243,\"country:AX\":244,\"address_format:address_format_1\":\"0\",\"address_format:address_format_2\":\"0\",\"address_format:address_format_3\":\"0\",\"address_format:address_format_4\":\"0\",\"address_format:address_format_5\":\"0\",\"address_format:address_format_6\":\"0\",\"address_format:address_format_7\":\"0\",\"address_format:address_format_8\":\"0\",\"address_format:address_format_9\":\"0\",\"address_format:address_format_10\":\"0\",\"address_format:address_format_11\":\"0\",\"address_format:address_format_12\":\"0\",\"address_format:address_format_13\":\"0\",\"address_format:address_format_14\":\"0\",\"address_format:address_format_15\":\"0\",\"address_format:address_format_16\":\"0\",\"address_format:address_format_17\":\"0\",\"address_format:address_format_18\":\"0\",\"address_format:address_format_19\":\"0\",\"address_format:address_format_20\":\"0\",\"address_format:address_format_21\":\"0\",\"address_format:address_format_22\":\"0\",\"address_format:address_format_23\":\"0\",\"address_format:address_format_24\":\"0\",\"address_format:address_format_25\":\"0\",\"address_format:address_format_26\":\"0\",\"address_format:address_format_27\":\"0\",\"address_format:address_format_28\":\"0\",\"address_format:address_format_29\":\"0\",\"address_format:address_format_30\":\"0\",\"address_format:address_format_31\":\"0\",\"address_format:address_format_32\":\"0\",\"address_format:address_format_33\":\"0\",\"address_format:address_format_34\":\"0\",\"address_format:address_format_35\":\"0\",\"address_format:address_format_36\":\"0\",\"address_format:address_format_37\":\"0\",\"address_format:address_format_38\":\"0\",\"address_format:address_format_39\":\"0\",\"address_format:address_format_40\":\"0\",\"address_format:address_format_41\":\"0\",\"address_format:address_format_42\":\"0\",\"address_format:address_format_43\":\"0\",\"address_format:address_format_44\":\"0\",\"address_format:address_format_45\":\"0\",\"address_format:address_format_46\":\"0\",\"address_format:address_format_47\":\"0\",\"address_format:address_format_48\":\"0\",\"address_format:address_format_49\":\"0\",\"address_format:address_format_50\":\"0\",\"address_format:address_format_51\":\"0\",\"address_format:address_format_52\":\"0\",\"address_format:address_format_53\":\"0\",\"address_format:address_format_54\":\"0\",\"address_format:address_format_55\":\"0\",\"address_format:address_format_56\":\"0\",\"address_format:address_format_57\":\"0\",\"address_format:address_format_58\":\"0\",\"address_format:address_format_59\":\"0\",\"address_format:address_format_60\":\"0\",\"address_format:address_format_61\":\"0\",\"address_format:address_format_62\":\"0\",\"address_format:address_format_63\":\"0\",\"address_format:address_format_64\":\"0\",\"address_format:address_format_65\":\"0\",\"address_format:address_format_66\":\"0\",\"address_format:address_format_67\":\"0\",\"address_format:address_format_68\":\"0\",\"address_format:address_format_69\":\"0\",\"address_format:address_format_70\":\"0\",\"address_format:address_format_71\":\"0\",\"address_format:address_format_72\":\"0\",\"address_format:address_format_73\":\"0\",\"address_format:address_format_74\":\"0\",\"address_format:address_format_75\":\"0\",\"address_format:address_format_76\":\"0\",\"address_format:address_format_77\":\"0\",\"address_format:address_format_78\":\"0\",\"address_format:address_format_79\":\"0\",\"address_format:address_format_80\":\"0\",\"address_format:address_format_81\":\"0\",\"address_format:address_format_82\":\"0\",\"address_format:address_format_83\":\"0\",\"address_format:address_format_84\":\"0\",\"address_format:address_format_85\":\"0\",\"address_format:address_format_86\":\"0\",\"address_format:address_format_87\":\"0\",\"address_format:address_format_88\":\"0\",\"address_format:address_format_89\":\"0\",\"address_format:address_format_90\":\"0\",\"address_format:address_format_91\":\"0\",\"address_format:address_format_92\":\"0\",\"address_format:address_format_93\":\"0\",\"address_format:address_format_94\":\"0\",\"address_format:address_format_95\":\"0\",\"address_format:address_format_96\":\"0\",\"address_format:address_format_97\":\"0\",\"address_format:address_format_98\":\"0\",\"address_format:address_format_99\":\"0\",\"address_format:address_format_100\":\"0\",\"address_format:address_format_101\":\"0\",\"address_format:address_format_102\":\"0\",\"address_format:address_format_103\":\"0\",\"address_format:address_format_104\":\"0\",\"address_format:address_format_105\":\"0\",\"address_format:address_format_106\":\"0\",\"address_format:address_format_107\":\"0\",\"address_format:address_format_108\":\"0\",\"address_format:address_format_109\":\"0\",\"address_format:address_format_110\":\"0\",\"address_format:address_format_111\":\"0\",\"address_format:address_format_112\":\"0\",\"address_format:address_format_113\":\"0\",\"address_format:address_format_114\":\"0\",\"address_format:address_format_115\":\"0\",\"address_format:address_format_116\":\"0\",\"address_format:address_format_117\":\"0\",\"address_format:address_format_118\":\"0\",\"address_format:address_format_119\":\"0\",\"address_format:address_format_120\":\"0\",\"address_format:address_format_121\":\"0\",\"address_format:address_format_122\":\"0\",\"address_format:address_format_123\":\"0\",\"address_format:address_format_124\":\"0\",\"address_format:address_format_125\":\"0\",\"address_format:address_format_126\":\"0\",\"address_format:address_format_127\":\"0\",\"address_format:address_format_128\":\"0\",\"address_format:address_format_129\":\"0\",\"address_format:address_format_130\":\"0\",\"address_format:address_format_131\":\"0\",\"address_format:address_format_132\":\"0\",\"address_format:address_format_133\":\"0\",\"address_format:address_format_134\":\"0\",\"address_format:address_format_135\":\"0\",\"address_format:address_format_136\":\"0\",\"address_format:address_format_137\":\"0\",\"address_format:address_format_138\":\"0\",\"address_format:address_format_139\":\"0\",\"address_format:address_format_140\":\"0\",\"address_format:address_format_141\":\"0\",\"address_format:address_format_142\":\"0\",\"address_format:address_format_143\":\"0\",\"address_format:address_format_144\":\"0\",\"address_format:address_format_145\":\"0\",\"address_format:address_format_146\":\"0\",\"address_format:address_format_147\":\"0\",\"address_format:address_format_148\":\"0\",\"address_format:address_format_149\":\"0\",\"address_format:address_format_150\":\"0\",\"address_format:address_format_151\":\"0\",\"address_format:address_format_152\":\"0\",\"address_format:address_format_153\":\"0\",\"address_format:address_format_154\":\"0\",\"address_format:address_format_155\":\"0\",\"address_format:address_format_156\":\"0\",\"address_format:address_format_157\":\"0\",\"address_format:address_format_158\":\"0\",\"address_format:address_format_159\":\"0\",\"address_format:address_format_160\":\"0\",\"address_format:address_format_161\":\"0\",\"address_format:address_format_162\":\"0\",\"address_format:address_format_163\":\"0\",\"address_format:address_format_164\":\"0\",\"address_format:address_format_165\":\"0\",\"address_format:address_format_166\":\"0\",\"address_format:address_format_167\":\"0\",\"address_format:address_format_168\":\"0\",\"address_format:address_format_169\":\"0\",\"address_format:address_format_170\":\"0\",\"address_format:address_format_171\":\"0\",\"address_format:address_format_172\":\"0\",\"address_format:address_format_173\":\"0\",\"address_format:address_format_174\":\"0\",\"address_format:address_format_175\":\"0\",\"address_format:address_format_176\":\"0\",\"address_format:address_format_177\":\"0\",\"address_format:address_format_178\":\"0\",\"address_format:address_format_179\":\"0\",\"address_format:address_format_180\":\"0\",\"address_format:address_format_181\":\"0\",\"address_format:address_format_182\":\"0\",\"address_format:address_format_183\":\"0\",\"address_format:address_format_184\":\"0\",\"address_format:address_format_185\":\"0\",\"address_format:address_format_186\":\"0\",\"address_format:address_format_187\":\"0\",\"address_format:address_format_188\":\"0\",\"address_format:address_format_189\":\"0\",\"address_format:address_format_190\":\"0\",\"address_format:address_format_191\":\"0\",\"address_format:address_format_192\":\"0\",\"address_format:address_format_193\":\"0\",\"address_format:address_format_194\":\"0\",\"address_format:address_format_195\":\"0\",\"address_format:address_format_196\":\"0\",\"address_format:address_format_197\":\"0\",\"address_format:address_format_198\":\"0\",\"address_format:address_format_199\":\"0\",\"address_format:address_format_200\":\"0\",\"address_format:address_format_201\":\"0\",\"address_format:address_format_202\":\"0\",\"address_format:address_format_203\":\"0\",\"address_format:address_format_204\":\"0\",\"address_format:address_format_205\":\"0\",\"address_format:address_format_206\":\"0\",\"address_format:address_format_207\":\"0\",\"address_format:address_format_208\":\"0\",\"address_format:address_format_209\":\"0\",\"address_format:address_format_210\":\"0\",\"address_format:address_format_211\":\"0\",\"address_format:address_format_212\":\"0\",\"address_format:address_format_213\":\"0\",\"address_format:address_format_214\":\"0\",\"address_format:address_format_215\":\"0\",\"address_format:address_format_216\":\"0\",\"address_format:address_format_217\":\"0\",\"address_format:address_format_218\":\"0\",\"address_format:address_format_219\":\"0\",\"address_format:address_format_220\":\"0\",\"address_format:address_format_221\":\"0\",\"address_format:address_format_222\":\"0\",\"address_format:address_format_223\":\"0\",\"address_format:address_format_224\":\"0\",\"address_format:address_format_225\":\"0\",\"address_format:address_format_226\":\"0\",\"address_format:address_format_227\":\"0\",\"address_format:address_format_228\":\"0\",\"address_format:address_format_229\":\"0\",\"address_format:address_format_230\":\"0\",\"address_format:address_format_231\":\"0\",\"address_format:address_format_232\":\"0\",\"address_format:address_format_233\":\"0\",\"address_format:address_format_234\":\"0\",\"address_format:address_format_235\":\"0\",\"address_format:address_format_236\":\"0\",\"address_format:address_format_237\":\"0\",\"address_format:address_format_238\":\"0\",\"address_format:address_format_239\":\"0\",\"address_format:address_format_240\":\"0\",\"address_format:address_format_241\":\"0\",\"address_format:address_format_242\":\"0\",\"address_format:address_format_243\":\"0\",\"address_format:address_format_244\":\"0\",\"carrier:carrier_1\":\"1\",\"group:Visitor\":\"1\",\"group:Guest\":\"2\",\"group:Customer\":\"3\",\"carrier_group:carrier_group_1_1\":0,\"carrier_group:carrier_group_1_2\":0,\"carrier_group:carrier_group_1_3\":0,\"state:AL\":1,\"state:AK\":2,\"state:AZ\":3,\"state:AR\":4,\"state:CA\":5,\"state:CO\":6,\"state:CT\":7,\"state:DE\":8,\"state:FL\":9,\"state:GA\":10,\"state:HI\":11,\"state:ID\":12,\"state:IL\":13,\"state:IN\":14,\"state:IA\":15,\"state:KS\":16,\"state:KY\":17,\"state:LA\":18,\"state:ME\":19,\"state:MD\":20,\"state:MA\":21,\"state:MI\":22,\"state:MN\":23,\"state:MS\":24,\"state:MO\":25,\"state:MT\":26,\"state:NE\":27,\"state:NV\":28,\"state:NH\":29,\"state:NJ\":30,\"state:NM\":31,\"state:NY\":32,\"state:NC\":33,\"state:ND\":34,\"state:OH\":35,\"state:OK\":36,\"state:OR\":37,\"state:PA\":38,\"state:RI\":39,\"state:SC\":40,\"state:SD\":41,\"state:TN\":42,\"state:TX\":43,\"state:UT\":44,\"state:VT\":45,\"state:VA\":46,\"state:WA\":47,\"state:WV\":48,\"state:WI\":49,\"state:WY\":50,\"state:PR\":51,\"state:VI\":52,\"state:DC\":53,\"state:AGS\":54,\"state:BCN\":55,\"state:BCS\":56,\"state:CAM\":57,\"state:CHP\":58,\"state:CHH\":59,\"state:COA\":60,\"state:COL\":61,\"state:DIF\":62,\"state:DUR\":63,\"state:GUA\":64,\"state:GRO\":65,\"state:HID\":66,\"state:JAL\":67,\"state:MEX\":68,\"state:MIC\":69,\"state:MOR\":70,\"state:NAY\":71,\"state:NLE\":72,\"state:OAX\":73,\"state:PUE\":74,\"state:QUE\":75,\"state:ROO\":76,\"state:SLP\":77,\"state:SIN\":78,\"state:SON\":79,\"state:TAB\":80,\"state:TAM\":81,\"state:TLA\":82,\"state:VER\":83,\"state:YUC\":84,\"state:ZAC\":85,\"state:ON\":86,\"state:QC\":87,\"state:BC\":88,\"state:AB\":89,\"state:MB\":90,\"state:SK\":91,\"state:NS\":92,\"state:NB\":93,\"state:NL\":94,\"state:PE\":95,\"state:NT\":96,\"state:YT\":97,\"state:NU\":98,\"state:B\":99,\"state:K\":100,\"state:H\":101,\"state:U\":102,\"state:C\":103,\"state:X\":104,\"state:W\":105,\"state:E\":106,\"state:P\":107,\"state:Y\":108,\"state:L\":109,\"state:F\":110,\"state:M\":111,\"state:N\":112,\"state:Q\":113,\"state:R\":114,\"state:A\":115,\"state:J\":116,\"state:D\":117,\"state:Z\":118,\"state:S\":119,\"state:G\":120,\"state:V\":121,\"state:T\":122,\"state:AG\":123,\"state:AL_1\":124,\"state:AN\":125,\"state:AO\":126,\"state:AR_1\":127,\"state:AP\":128,\"state:AT\":129,\"state:AV\":130,\"state:BA\":131,\"state:BT\":132,\"state:BL\":133,\"state:BN\":134,\"state:BG\":135,\"state:BI\":136,\"state:BO\":137,\"state:BZ\":138,\"state:BS\":139,\"state:BR\":140,\"state:CA_1\":141,\"state:CL\":142,\"state:CB\":143,\"state:CI\":144,\"state:CE\":145,\"state:CT_1\":146,\"state:CZ\":147,\"state:CH\":148,\"state:CO_1\":149,\"state:CS\":150,\"state:CR\":151,\"state:KR\":152,\"state:CN\":153,\"state:EN\":154,\"state:FM\":155,\"state:FE\":156,\"state:FI\":157,\"state:FG\":158,\"state:FC\":159,\"state:FR\":160,\"state:GE\":161,\"state:GO\":162,\"state:GR\":163,\"state:IM\":164,\"state:IS\":165,\"state:AQ\":166,\"state:SP\":167,\"state:LT\":168,\"state:LE\":169,\"state:LC\":170,\"state:LI\":171,\"state:LO\":172,\"state:LU\":173,\"state:MC\":174,\"state:MN_1\":175,\"state:MS_1\":176,\"state:MT_1\":177,\"state:VS\":178,\"state:ME_1\":179,\"state:MI_1\":180,\"state:MO_1\":181,\"state:MB_1\":182,\"state:NA\":183,\"state:NO\":184,\"state:NU_1\":185,\"state:OG\":186,\"state:OT\":187,\"state:OR_1\":188,\"state:PD\":189,\"state:PA_1\":190,\"state:PR_1\":191,\"state:PV\":192,\"state:PG\":193,\"state:PU\":194,\"state:PE_1\":195,\"state:PC\":196,\"state:PI\":197,\"state:PT\":198,\"state:PN\":199,\"state:PZ\":200,\"state:PO\":201,\"state:RG\":202,\"state:RA\":203,\"state:RC\":204,\"state:RE\":205,\"state:RI_1\":206,\"state:RN\":207,\"state:RM\":208,\"state:RO\":209,\"state:SA\":210,\"state:SS\":211,\"state:SV\":212,\"state:SI\":213,\"state:SR\":214,\"state:SO\":215,\"state:TA\":216,\"state:TE\":217,\"state:TR\":218,\"state:TO\":219,\"state:TP\":220,\"state:TN_1\":221,\"state:TV\":222,\"state:TS\":223,\"state:UD\":224,\"state:VA_1\":225,\"state:VE\":226,\"state:VB\":227,\"state:VC\":228,\"state:VR\":229,\"state:VV\":230,\"state:VI_1\":231,\"state:VT_1\":232,\"state:AC\":233,\"state:BA_1\":234,\"state:BB\":235,\"state:BT_1\":236,\"state:BE\":237,\"state:JT\":238,\"state:KT\":239,\"state:ST\":240,\"state:JI\":241,\"state:KI\":242,\"state:NT_1\":243,\"state:GO_1\":244,\"state:JK\":245,\"state:JA\":246,\"state:LA_1\":247,\"state:MA_1\":248,\"state:MU\":249,\"state:SA_1\":250,\"state:SU\":251,\"state:PA_2\":252,\"state:RI_2\":253,\"state:KR_1\":254,\"state:SG\":255,\"state:KS_1\":256,\"state:SN\":257,\"state:SS_1\":258,\"state:JB\":259,\"state:KB\":260,\"state:NB_1\":261,\"state:PB\":262,\"state:SR_1\":263,\"state:SB\":264,\"state:YO\":265,\"state:JP-23\":266,\"state:JP-05\":267,\"state:JP-02\":268,\"state:JP-12\":269,\"state:JP-38\":270,\"state:JP-18\":271,\"state:JP-40\":272,\"state:JP-07\":273,\"state:JP-21\":274,\"state:JP-10\":275,\"state:JP-34\":276,\"state:JP-01\":277,\"state:JP-28\":278,\"state:JP-08\":279,\"state:JP-17\":280,\"state:JP-03\":281,\"state:JP-37\":282,\"state:JP-46\":283,\"state:JP-14\":284,\"state:JP-39\":285,\"state:JP-43\":286,\"state:JP-26\":287,\"state:JP-24\":288,\"state:JP-04\":289,\"state:JP-45\":290,\"state:JP-20\":291,\"state:JP-42\":292,\"state:JP-29\":293,\"state:JP-15\":294,\"state:JP-44\":295,\"state:JP-33\":296,\"state:JP-47\":297,\"state:JP-27\":298,\"state:JP-41\":299,\"state:JP-11\":300,\"state:JP-25\":301,\"state:JP-32\":302,\"state:JP-22\":303,\"state:JP-09\":304,\"state:JP-36\":305,\"state:JP-13\":306,\"state:JP-31\":307,\"state:JP-16\":308,\"state:JP-30\":309,\"state:JP-06\":310,\"state:JP-35\":311,\"state:JP-19\":312,\"profile:SuperAdmin\":\"1\",\"tab:Dashboard\":1,\"tab:CMS_Pages\":2,\"tab:CMS_Categories\":3,\"tab:Combinations_Generator\":4,\"tab:Search\":5,\"tab:Login\":6,\"tab:Shops\":7,\"tab:Shop_URLs\":8,\"tab:Catalog\":9,\"tab:Orders\":10,\"tab:Customers\":11,\"tab:Price_Rules\":12,\"tab:Modules\":13,\"tab:Shipping\":14,\"tab:Localization\":15,\"tab:Preferences\":16,\"tab:Advanced_Parameters\":17,\"tab:Administration\":18,\"tab:Stats\":19,\"tab:Stock\":20,\"tab:Products\":21,\"tab:Categories\":22,\"tab:Monitoring\":23,\"tab:Attributes_and_Values\":24,\"tab:Features\":25,\"tab:Manufacturers\":26,\"tab:Suppliers\":27,\"tab:Tags\":28,\"tab:Attachments\":29,\"tab:Orders_1\":30,\"tab:Invoices\":31,\"tab:Merchandise_Returns\":32,\"tab:Delivery_Slips\":33,\"tab:Credit_Slips\":34,\"tab:Statuses\":35,\"tab:Order_Messages\":36,\"tab:Customers_1\":37,\"tab:Addresses\":38,\"tab:Groups\":39,\"tab:Shopping_Carts\":40,\"tab:Customer_Service\":41,\"tab:Contacts\":42,\"tab:Titles\":43,\"tab:Outstanding\":44,\"tab:Cart_Rules\":45,\"tab:Catalog_Price_Rules\":46,\"tab:Marketing\":47,\"tab:Carriers\":48,\"tab:Shipping_1\":49,\"tab:CarrierWizard\":50,\"tab:Localization_1\":51,\"tab:Languages\":52,\"tab:Zones\":53,\"tab:Countries\":54,\"tab:States\":55,\"tab:Currencies\":56,\"tab:Taxes\":57,\"tab:Tax_Rules\":58,\"tab:Translations\":59,\"tab:Modules_1\":60,\"tab:Modules_Themes_Catalog\":61,\"tab:Positions\":62,\"tab:Payment\":63,\"tab:General\":64,\"tab:Orders_2\":65,\"tab:Products_1\":66,\"tab:Customers_2\":67,\"tab:Themes\":68,\"tab:SEO_URLs\":69,\"tab:CMS\":70,\"tab:Images\":71,\"tab:Store_Contacts\":72,\"tab:Search_1\":73,\"tab:Maintenance\":74,\"tab:Geolocation\":75,\"tab:Configuration_Information\":76,\"tab:Performance\":77,\"tab:E-mail\":78,\"tab:Multistore\":79,\"tab:CSV_Import\":80,\"tab:DB_Backup\":81,\"tab:SQL_Manager\":82,\"tab:Logs\":83,\"tab:Webservice\":84,\"tab:Preferences_1\":85,\"tab:Quick_Access\":86,\"tab:Employees\":87,\"tab:Profiles\":88,\"tab:Permissions\":89,\"tab:Menus\":90,\"tab:Stats_1\":91,\"tab:Search_Engines\":92,\"tab:Referrers\":93,\"tab:Warehouses\":94,\"tab:Stock_Management\":95,\"tab:Stock_Movement\":96,\"tab:Instant_Stock_Status\":97,\"tab:Stock_Coverage\":98,\"tab:Supply_orders\":99,\"tab:Configuration\":100,\"access:access_1_0\":0,\"access:access_1_1\":0,\"access:access_1_2\":0,\"access:access_1_3\":0,\"access:access_1_4\":0,\"access:access_1_5\":0,\"access:access_1_7\":0,\"access:access_1_8\":0,\"access:access_1_9\":0,\"access:access_1_10\":0,\"access:access_1_11\":0,\"access:access_1_13\":0,\"access:access_1_14\":0,\"access:access_1_15\":0,\"access:access_1_16\":0,\"access:access_1_19\":0,\"access:access_1_20\":0,\"access:access_1_21\":0,\"access:access_1_22\":0,\"access:access_1_23\":0,\"access:access_1_24\":0,\"access:access_1_25\":0,\"access:access_1_26\":0,\"access:access_1_27\":0,\"access:access_1_29\":0,\"access:access_1_30\":0,\"access:access_1_32\":0,\"access:access_1_33\":0,\"access:access_1_34\":0,\"access:access_1_35\":0,\"access:access_1_36\":0,\"access:access_1_37\":0,\"access:access_1_39\":0,\"access:access_1_40\":0,\"access:access_1_41\":0,\"access:access_1_42\":0,\"access:access_1_43\":0,\"access:access_1_44\":0,\"access:access_1_45\":0,\"access:access_1_46\":0,\"access:access_1_47\":0,\"access:access_1_49\":0,\"access:access_1_50\":0,\"access:access_1_51\":0,\"access:access_1_53\":0,\"access:access_1_54\":0,\"access:access_1_55\":0,\"access:access_1_56\":0,\"access:access_1_57\":0,\"access:access_1_58\":0,\"access:access_1_59\":0,\"access:access_1_60\":0,\"access:access_1_62\":0,\"access:access_1_63\":0,\"access:access_1_64\":0,\"access:access_1_67\":0,\"access:access_1_68\":0,\"access:access_1_69\":0,\"access:access_1_70\":0,\"access:access_1_71\":0,\"access:access_1_72\":0,\"access:access_1_73\":0,\"access:access_1_74\":0,\"access:access_1_75\":0,\"access:access_1_76\":0,\"access:access_1_77\":0,\"access:access_1_78\":0,\"access:access_1_79\":0,\"access:access_1_81\":0,\"access:access_1_82\":0,\"access:access_1_83\":0,\"access:access_1_84\":0,\"access:access_1_85\":0,\"access:access_1_87\":0,\"access:access_1_88\":0,\"access:access_1_89\":0,\"access:access_1_90\":0,\"access:access_1_91\":0,\"access:access_1_93\":0,\"access:access_1_94\":0,\"access:access_1_95\":0,\"access:access_1_96\":0,\"access:access_1_97\":0,\"access:access_1_98\":0,\"access:access_1_99\":0,\"access:access_1_100\":0,\"access:access_1_101\":0,\"access:access_1_102\":0,\"hook_alias:payment\":1,\"hook_alias:newOrder\":2,\"hook_alias:paymentConfirm\":3,\"hook_alias:paymentReturn\":4,\"hook_alias:updateQuantity\":5,\"hook_alias:rightColumn\":6,\"hook_alias:leftColumn\":7,\"hook_alias:home\":8,\"hook_alias:header\":9,\"hook_alias:cart\":10,\"hook_alias:authentication\":11,\"hook_alias:addproduct\":12,\"hook_alias:updateproduct\":13,\"hook_alias:top\":14,\"hook_alias:extraRight\":15,\"hook_alias:deleteproduct\":16,\"hook_alias:productfooter\":17,\"hook_alias:invoice\":18,\"hook_alias:updateOrderStatus\":19,\"hook_alias:adminOrder\":20,\"hook_alias:footer\":21,\"hook_alias:PDFInvoice\":22,\"hook_alias:adminCustomers\":23,\"hook_alias:orderConfirmation\":24,\"hook_alias:createAccount\":25,\"hook_alias:customerAccount\":26,\"hook_alias:orderSlip\":27,\"hook_alias:productTab\":28,\"hook_alias:productTabContent\":29,\"hook_alias:shoppingCart\":30,\"hook_alias:createAccountForm\":31,\"hook_alias:AdminStatsModules\":32,\"hook_alias:GraphEngine\":33,\"hook_alias:orderReturn\":34,\"hook_alias:productActions\":35,\"hook_alias:backOfficeHome\":36,\"hook_alias:GridEngine\":37,\"hook_alias:watermark\":38,\"hook_alias:cancelProduct\":39,\"hook_alias:extraLeft\":40,\"hook_alias:productOutOfStock\":41,\"hook_alias:updateProductAttribute\":42,\"hook_alias:extraCarrier\":43,\"hook_alias:shoppingCartExtra\":44,\"hook_alias:search\":45,\"hook_alias:backBeforePayment\":46,\"hook_alias:updateCarrier\":47,\"hook_alias:postUpdateOrderStatus\":48,\"hook_alias:createAccountTop\":49,\"hook_alias:backOfficeHeader\":50,\"hook_alias:backOfficeTop\":51,\"hook_alias:backOfficeFooter\":52,\"hook_alias:deleteProductAttribute\":53,\"hook_alias:processCarrier\":54,\"hook_alias:orderDetail\":55,\"hook_alias:beforeCarrier\":56,\"hook_alias:orderDetailDisplayed\":57,\"hook_alias:paymentCCAdded\":58,\"hook_alias:extraProductComparison\":59,\"hook_alias:categoryAddition\":60,\"hook_alias:categoryUpdate\":61,\"hook_alias:categoryDeletion\":62,\"hook_alias:beforeAuthentication\":63,\"hook_alias:paymentTop\":64,\"hook_alias:afterCreateHtaccess\":65,\"hook_alias:afterSaveAdminMeta\":66,\"hook_alias:attributeGroupForm\":67,\"hook_alias:afterSaveAttributeGroup\":68,\"hook_alias:afterDeleteAttributeGroup\":69,\"hook_alias:featureForm\":70,\"hook_alias:afterSaveFeature\":71,\"hook_alias:afterDeleteFeature\":72,\"hook_alias:afterSaveProduct\":73,\"hook_alias:productListAssign\":74,\"hook_alias:postProcessAttributeGroup\":75,\"hook_alias:postProcessFeature\":76,\"hook_alias:featureValueForm\":77,\"hook_alias:postProcessFeatureValue\":78,\"hook_alias:afterDeleteFeatureValue\":79,\"hook_alias:afterSaveFeatureValue\":80,\"hook_alias:attributeForm\":81,\"hook_alias:postProcessAttribute\":82,\"hook_alias:afterDeleteAttribute\":83,\"hook_alias:afterSaveAttribute\":84,\"hook_alias:taxManager\":85,\"hook_alias:myAccountBlock\":86,\"image_type:cart_default\":\"1\",\"image_type:small_default\":\"2\",\"image_type:medium_default\":\"3\",\"image_type:home_default\":\"4\",\"image_type:large_default\":\"5\",\"image_type:thickbox_default\":\"6\",\"image_type:category_default\":\"7\",\"image_type:scene_default\":\"8\",\"image_type:m_scene_default\":\"9\",\"configuration:PS_SEARCH_INDEXATION\":6,\"configuration:PS_ONE_PHONE_AT_LEAST\":7,\"configuration:PS_CURRENCY_DEFAULT\":8,\"configuration:PS_COUNTRY_DEFAULT\":9,\"configuration:PS_REWRITING_SETTINGS\":10,\"configuration:PS_ORDER_OUT_OF_STOCK\":11,\"configuration:PS_LAST_QTIES\":12,\"configuration:PS_CART_REDIRECT\":13,\"configuration:PS_CONDITIONS\":14,\"configuration:PS_RECYCLABLE_PACK\":15,\"configuration:PS_GIFT_WRAPPING\":16,\"configuration:PS_GIFT_WRAPPING_PRICE\":17,\"configuration:PS_STOCK_MANAGEMENT\":18,\"configuration:PS_NAVIGATION_PIPE\":19,\"configuration:PS_PRODUCTS_PER_PAGE\":20,\"configuration:PS_PURCHASE_MINIMUM\":21,\"configuration:PS_PRODUCTS_ORDER_WAY\":22,\"configuration:PS_PRODUCTS_ORDER_BY\":23,\"configuration:PS_DISPLAY_QTIES\":24,\"configuration:PS_SHIPPING_HANDLING\":25,\"configuration:PS_SHIPPING_FREE_PRICE\":26,\"configuration:PS_SHIPPING_FREE_WEIGHT\":27,\"configuration:PS_SHIPPING_METHOD\":28,\"configuration:PS_TAX\":29,\"configuration:PS_SHOP_ENABLE\":30,\"configuration:PS_NB_DAYS_NEW_PRODUCT\":31,\"configuration:PS_SSL_ENABLED\":32,\"configuration:PS_WEIGHT_UNIT\":33,\"configuration:PS_BLOCK_CART_AJAX\":34,\"configuration:PS_ORDER_RETURN\":35,\"configuration:PS_ORDER_RETURN_NB_DAYS\":36,\"configuration:PS_MAIL_TYPE\":37,\"configuration:PS_PRODUCT_PICTURE_MAX_SIZE\":38,\"configuration:PS_PRODUCT_PICTURE_WIDTH\":39,\"configuration:PS_PRODUCT_PICTURE_HEIGHT\":40,\"configuration:PS_INVOICE_PREFIX\":41,\"configuration:PS_INVCE_INVOICE_ADDR_RULES\":42,\"configuration:PS_INVCE_DELIVERY_ADDR_RULES\":43,\"configuration:PS_DELIVERY_PREFIX\":44,\"configuration:PS_DELIVERY_NUMBER\":45,\"configuration:PS_RETURN_PREFIX\":46,\"configuration:PS_INVOICE\":47,\"configuration:PS_PASSWD_TIME_BACK\":48,\"configuration:PS_PASSWD_TIME_FRONT\":49,\"configuration:PS_DISP_UNAVAILABLE_ATTR\":50,\"configuration:PS_SEARCH_MINWORDLEN\":51,\"configuration:PS_SEARCH_BLACKLIST\":52,\"configuration:PS_SEARCH_WEIGHT_PNAME\":53,\"configuration:PS_SEARCH_WEIGHT_REF\":54,\"configuration:PS_SEARCH_WEIGHT_SHORTDESC\":55,\"configuration:PS_SEARCH_WEIGHT_DESC\":56,\"configuration:PS_SEARCH_WEIGHT_CNAME\":57,\"configuration:PS_SEARCH_WEIGHT_MNAME\":58,\"configuration:PS_SEARCH_WEIGHT_TAG\":59,\"configuration:PS_SEARCH_WEIGHT_ATTRIBUTE\":60,\"configuration:PS_SEARCH_WEIGHT_FEATURE\":61,\"configuration:PS_SEARCH_AJAX\":62,\"configuration:PS_TIMEZONE\":63,\"configuration:PS_THEME_V11\":64,\"configuration:PRESTASTORE_LIVE\":65,\"configuration:PS_TIN_ACTIVE\":66,\"configuration:PS_SHOW_ALL_MODULES\":67,\"configuration:PS_BACKUP_ALL\":68,\"configuration:PS_1_3_UPDATE_DATE\":69,\"configuration:PS_PRICE_ROUND_MODE\":70,\"configuration:PS_1_3_2_UPDATE_DATE\":71,\"configuration:PS_CONDITIONS_CMS_ID\":72,\"configuration:TRACKING_DIRECT_TRAFFIC\":73,\"configuration:PS_META_KEYWORDS\":74,\"configuration:PS_DISPLAY_JQZOOM\":75,\"configuration:PS_VOLUME_UNIT\":76,\"configuration:PS_CIPHER_ALGORITHM\":77,\"configuration:PS_ATTRIBUTE_CATEGORY_DISPLAY\":78,\"configuration:PS_CUSTOMER_SERVICE_FILE_UPLOAD\":79,\"configuration:PS_CUSTOMER_SERVICE_SIGNATURE\":80,\"configuration:PS_BLOCK_BESTSELLERS_DISPLAY\":81,\"configuration:PS_BLOCK_NEWPRODUCTS_DISPLAY\":82,\"configuration:PS_BLOCK_SPECIALS_DISPLAY\":83,\"configuration:PS_STOCK_MVT_REASON_DEFAULT\":84,\"configuration:PS_COMPARATOR_MAX_ITEM\":85,\"configuration:PS_ORDER_PROCESS_TYPE\":86,\"configuration:PS_SPECIFIC_PRICE_PRIORITIES\":87,\"configuration:PS_TAX_DISPLAY\":88,\"configuration:PS_SMARTY_FORCE_COMPILE\":89,\"configuration:PS_DISTANCE_UNIT\":90,\"configuration:PS_STORES_DISPLAY_CMS\":91,\"configuration:PS_STORES_DISPLAY_FOOTER\":92,\"configuration:PS_STORES_SIMPLIFIED\":93,\"configuration:SHOP_LOGO_WIDTH\":94,\"configuration:SHOP_LOGO_HEIGHT\":95,\"configuration:EDITORIAL_IMAGE_WIDTH\":96,\"configuration:EDITORIAL_IMAGE_HEIGHT\":97,\"configuration:PS_STATSDATA_CUSTOMER_PAGESVIEWS\":98,\"configuration:PS_STATSDATA_PAGESVIEWS\":99,\"configuration:PS_STATSDATA_PLUGINS\":100,\"configuration:PS_GEOLOCATION_ENABLED\":101,\"configuration:PS_ALLOWED_COUNTRIES\":102,\"configuration:PS_GEOLOCATION_BEHAVIOR\":103,\"configuration:PS_LOCALE_LANGUAGE\":104,\"configuration:PS_LOCALE_COUNTRY\":105,\"configuration:PS_ATTACHMENT_MAXIMUM_SIZE\":106,\"configuration:PS_SMARTY_CACHE\":107,\"configuration:PS_DIMENSION_UNIT\":108,\"configuration:PS_GUEST_CHECKOUT_ENABLED\":109,\"configuration:PS_DISPLAY_SUPPLIERS\":110,\"configuration:PS_DISPLAY_BEST_SELLERS\":111,\"configuration:PS_CATALOG_MODE\":112,\"configuration:PS_GEOLOCATION_WHITELIST\":113,\"configuration:PS_LOGS_BY_EMAIL\":114,\"configuration:PS_COOKIE_CHECKIP\":115,\"configuration:PS_STORES_CENTER_LAT\":116,\"configuration:PS_STORES_CENTER_LONG\":117,\"configuration:PS_USE_ECOTAX\":118,\"configuration:PS_CANONICAL_REDIRECT\":119,\"configuration:PS_IMG_UPDATE_TIME\":120,\"configuration:PS_BACKUP_DROP_TABLE\":121,\"configuration:PS_OS_CHEQUE\":122,\"configuration:PS_OS_PAYMENT\":123,\"configuration:PS_OS_PREPARATION\":124,\"configuration:PS_OS_SHIPPING\":125,\"configuration:PS_OS_DELIVERED\":126,\"configuration:PS_OS_CANCELED\":127,\"configuration:PS_OS_REFUND\":128,\"configuration:PS_OS_ERROR\":129,\"configuration:PS_OS_OUTOFSTOCK\":130,\"configuration:PS_OS_BANKWIRE\":131,\"configuration:PS_OS_PAYPAL\":132,\"configuration:PS_OS_WS_PAYMENT\":133,\"configuration:PS_OS_OUTOFSTOCK_PAID\":134,\"configuration:PS_OS_OUTOFSTOCK_UNPAID\":135,\"configuration:PS_OS_COD_VALIDATION\":136,\"configuration:PS_LEGACY_IMAGES\":137,\"configuration:PS_IMAGE_QUALITY\":138,\"configuration:PS_PNG_QUALITY\":139,\"configuration:PS_JPEG_QUALITY\":140,\"configuration:PS_COOKIE_LIFETIME_FO\":141,\"configuration:PS_COOKIE_LIFETIME_BO\":142,\"configuration:PS_RESTRICT_DELIVERED_COUNTRIES\":143,\"configuration:PS_SHOW_NEW_ORDERS\":144,\"configuration:PS_SHOW_NEW_CUSTOMERS\":145,\"configuration:PS_SHOW_NEW_MESSAGES\":146,\"configuration:PS_FEATURE_FEATURE_ACTIVE\":147,\"configuration:PS_COMBINATION_FEATURE_ACTIVE\":148,\"configuration:PS_SPECIFIC_PRICE_FEATURE_ACTIVE\":149,\"configuration:PS_SCENE_FEATURE_ACTIVE\":150,\"configuration:PS_VIRTUAL_PROD_FEATURE_ACTIVE\":151,\"configuration:PS_CUSTOMIZATION_FEATURE_ACTIVE\":152,\"configuration:PS_CART_RULE_FEATURE_ACTIVE\":153,\"configuration:PS_PACK_FEATURE_ACTIVE\":154,\"configuration:PS_ALIAS_FEATURE_ACTIVE\":155,\"configuration:PS_TAX_ADDRESS_TYPE\":156,\"configuration:PS_SHOP_DEFAULT\":157,\"configuration:PS_CARRIER_DEFAULT_SORT\":158,\"configuration:PS_STOCK_MVT_INC_REASON_DEFAULT\":159,\"configuration:PS_STOCK_MVT_DEC_REASON_DEFAULT\":160,\"configuration:PS_ADVANCED_STOCK_MANAGEMENT\":161,\"configuration:PS_ADMINREFRESH_NOTIFICATION\":162,\"configuration:PS_STOCK_MVT_TRANSFER_TO\":163,\"configuration:PS_STOCK_MVT_TRANSFER_FROM\":164,\"configuration:PS_CARRIER_DEFAULT_ORDER\":165,\"configuration:PS_STOCK_MVT_SUPPLY_ORDER\":166,\"configuration:PS_STOCK_CUSTOMER_ORDER_REASON\":167,\"configuration:PS_UNIDENTIFIED_GROUP\":168,\"configuration:PS_GUEST_GROUP\":169,\"configuration:PS_CUSTOMER_GROUP\":170,\"configuration:PS_SMARTY_CONSOLE\":171,\"configuration:PS_INVOICE_MODEL\":172,\"configuration:PS_LIMIT_UPLOAD_IMAGE_VALUE\":173,\"configuration:PS_LIMIT_UPLOAD_FILE_VALUE\":174,\"configuration:MB_PAY_TO_EMAIL\":175,\"configuration:MB_SECRET_WORD\":176,\"configuration:MB_HIDE_LOGIN\":177,\"configuration:MB_ID_LOGO\":178,\"configuration:MB_ID_LOGO_WALLET\":179,\"configuration:MB_PARAMETERS\":180,\"configuration:MB_PARAMETERS_2\":181,\"configuration:MB_DISPLAY_MODE\":182,\"configuration:MB_CANCEL_URL\":183,\"configuration:MB_LOCAL_METHODS\":184,\"configuration:MB_INTER_METHODS\":185,\"configuration:BANK_WIRE_CURRENCIES\":186,\"configuration:CHEQUE_CURRENCIES\":187,\"configuration:PRODUCTS_VIEWED_NBR\":188,\"configuration:BLOCK_CATEG_DHTML\":189,\"configuration:BLOCK_CATEG_MAX_DEPTH\":190,\"configuration:MANUFACTURER_DISPLAY_FORM\":191,\"configuration:MANUFACTURER_DISPLAY_TEXT\":192,\"configuration:MANUFACTURER_DISPLAY_TEXT_NB\":193,\"configuration:NEW_PRODUCTS_NBR\":194,\"configuration:PS_TOKEN_ENABLE\":195,\"configuration:PS_STATS_RENDER\":196,\"configuration:PS_STATS_OLD_CONNECT_AUTO_CLEAN\":197,\"configuration:PS_STATS_GRID_RENDER\":198,\"configuration:BLOCKTAGS_NBR\":199,\"configuration:CHECKUP_DESCRIPTIONS_LT\":200,\"configuration:CHECKUP_DESCRIPTIONS_GT\":201,\"configuration:CHECKUP_IMAGES_LT\":202,\"configuration:CHECKUP_IMAGES_GT\":203,\"configuration:CHECKUP_SALES_LT\":204,\"configuration:CHECKUP_SALES_GT\":205,\"configuration:CHECKUP_STOCK_LT\":206,\"configuration:CHECKUP_STOCK_GT\":207,\"configuration:FOOTER_CMS\":208,\"configuration:FOOTER_BLOCK_ACTIVATION\":209,\"configuration:FOOTER_POWEREDBY\":210,\"configuration:BLOCKADVERT_LINK\":211,\"configuration:BLOCKSTORE_IMG\":212,\"configuration:BLOCKADVERT_IMG_EXT\":213,\"configuration:MOD_BLOCKTOPMENU_ITEMS\":214,\"configuration:MOD_BLOCKTOPMENU_SEARCH\":215,\"configuration:blocksocial_facebook\":216,\"configuration:blocksocial_twitter\":217,\"configuration:blocksocial_rss\":218,\"configuration:blockcontactinfos_company\":219,\"configuration:blockcontactinfos_address\":220,\"configuration:blockcontactinfos_phone\":221,\"configuration:blockcontactinfos_email\":222,\"configuration:blockcontact_telnumber\":223,\"configuration:blockcontact_email\":224,\"configuration:SUPPLIER_DISPLAY_TEXT\":225,\"configuration:SUPPLIER_DISPLAY_TEXT_NB\":226,\"configuration:SUPPLIER_DISPLAY_FORM\":227,\"configuration:BLOCK_CATEG_NBR_COLUMN_FOOTER\":228,\"configuration:UPGRADER_BACKUPDB_FILENAME\":229,\"configuration:UPGRADER_BACKUPFILES_FILENAME\":230,\"configuration:BLOCKREINSURANCE_NBBLOCKS\":231,\"configuration:HOMESLIDER_WIDTH\":232,\"configuration:HOMESLIDER_SPEED\":233,\"configuration:HOMESLIDER_PAUSE\":234,\"configuration:HOMESLIDER_LOOP\":235,\"configuration:PS_BASE_DISTANCE_UNIT\":236,\"configuration:PS_SHOP_DOMAIN\":237,\"configuration:PS_SHOP_DOMAIN_SSL\":238,\"configuration:PS_SHOP_NAME\":239,\"configuration:PS_SHOP_EMAIL\":240,\"configuration:PS_MAIL_METHOD\":241,\"configuration:PS_SHOP_ACTIVITY\":242,\"configuration:PS_LOGO\":243,\"configuration:PS_FAVICON\":244,\"configuration:PS_STORES_ICON\":245,\"configuration:PS_ROOT_CATEGORY\":246,\"configuration:PS_HOME_CATEGORY\":247,\"configuration:PS_CONFIGURATION_AGREMENT\":248,\"configuration:PS_MAIL_SERVER\":249,\"configuration:PS_MAIL_USER\":250,\"configuration:PS_MAIL_PASSWD\":251,\"configuration:PS_MAIL_SMTP_ENCRYPTION\":252,\"configuration:PS_MAIL_SMTP_PORT\":253,\"configuration:PS_MAIL_COLOR\":254,\"configuration:NW_SALT\":255,\"configuration:PS_PAYMENT_LOGO_CMS_ID\":256,\"configuration:HOME_FEATURED_NBR\":257,\"configuration:SEK_MIN_OCCURENCES\":258,\"configuration:SEK_FILTER_KW\":259,\"configuration:PS_ALLOW_MOBILE_DEVICE\":260,\"configuration:PS_CUSTOMER_CREATION_EMAIL\":261,\"configuration:PS_SMARTY_CONSOLE_KEY\":262,\"configuration:PS_DASHBOARD_USE_PUSH\":263,\"configuration:PS_ATTRIBUTE_ANCHOR_SEPARATOR\":264,\"configuration:CONF_AVERAGE_PRODUCT_MARGIN\":265,\"configuration:PS_DASHBOARD_SIMULATION\":266,\"configuration:PS_QUICK_VIEW\":267,\"configuration:PS_USE_HTMLPURIFIER\":268,\"configuration:PS_SMARTY_CACHING_TYPE\":269,\"configuration:PS_SMARTY_CLEAR_CACHE\":270,\"configuration:PS_DETECT_LANG\":271,\"configuration:PS_DETECT_COUNTRY\":272,\"configuration:PS_ROUND_TYPE\":273,\"configuration:PS_PRICE_DISPLAY_PRECISION\":274,\"configuration:PS_LOG_EMAILS\":275,\"configuration:PS_CUSTOMER_NWSL\":276,\"configuration:PS_CUSTOMER_OPTIN\":277,\"configuration:PS_PACK_STOCK_TYPE\":278,\"configuration:PS_LOG_MODULE_PERFS_MODULO\":279,\"configuration:PS_DISALLOW_HISTORY_REORDERING\":280,\"configuration:PS_DISPLAY_PRODUCT_WEIGHT\":281,\"configuration:PS_PRODUCT_WEIGHT_PRECISION\":282,\"configuration:PS_ADVANCED_PAYMENT_API\":283,\"theme:default\":\"1\",\"meta:404\":1,\"meta:best-sales\":2,\"meta:contact\":3,\"meta:index\":4,\"meta:manufacturer\":5,\"meta:new-products\":6,\"meta:password\":7,\"meta:prices-drop\":8,\"meta:sitemap\":9,\"meta:supplier\":10,\"meta:address\":11,\"meta:addresses\":12,\"meta:authentication\":13,\"meta:cart\":14,\"meta:discount\":15,\"meta:history\":16,\"meta:identity\":17,\"meta:my-account\":18,\"meta:order-follow\":19,\"meta:order-slip\":20,\"meta:order\":21,\"meta:search\":22,\"meta:stores\":23,\"meta:order-opc\":24,\"meta:guest-tracking\":25,\"meta:order-confirmation\":26,\"meta:product\":27,\"meta:category\":28,\"meta:cms\":29,\"meta:module-cheque-payment\":30,\"meta:module-cheque-validation\":31,\"meta:module-bankwire-validation\":32,\"meta:module-bankwire-payment\":33,\"meta:module-cashondelivery-validation\":34,\"meta:products-comparison\":35,\"theme_meta:theme_meta_1\":1,\"theme_meta:theme_meta_2\":2,\"theme_meta:theme_meta_3\":3,\"theme_meta:theme_meta_4\":4,\"theme_meta:theme_meta_5\":5,\"theme_meta:theme_meta_6\":6,\"theme_meta:theme_meta_7\":7,\"theme_meta:theme_meta_8\":8,\"theme_meta:theme_meta_10\":9,\"theme_meta:theme_meta_11\":10,\"theme_meta:theme_meta_12\":11,\"theme_meta:theme_meta_13\":12,\"theme_meta:theme_meta_14\":13,\"theme_meta:theme_meta_15\":14,\"theme_meta:theme_meta_16\":15,\"theme_meta:theme_meta_17\":16,\"theme_meta:theme_meta_18\":17,\"theme_meta:theme_meta_19\":18,\"theme_meta:theme_meta_20\":19,\"theme_meta:theme_meta_21\":20,\"theme_meta:theme_meta_22\":21,\"theme_meta:theme_meta_23\":22,\"theme_meta:theme_meta_24\":23,\"theme_meta:theme_meta_25\":24,\"theme_meta:theme_meta_26\":25,\"theme_meta:theme_meta_27\":26,\"theme_meta:theme_meta_28\":27,\"theme_meta:theme_meta_29\":28,\"theme_meta:theme_meta_30\":29,\"theme_meta:theme_meta_31\":30,\"theme_meta:theme_meta_32\":31,\"theme_meta:theme_meta_33\":32,\"theme_meta:theme_meta_34\":33,\"theme_meta:theme_meta_35\":34,\"web_browser:Safari\":1,\"web_browser:Safari_ipad\":2,\"web_browser:Firefox\":3,\"web_browser:Opera\":4,\"web_browser:IE_6\":5,\"web_browser:IE_7\":6,\"web_browser:IE_8\":7,\"web_browser:IE_9\":8,\"web_browser:IE_10\":9,\"web_browser:IE_11\":10,\"web_browser:Chrome\":11,\"gender:Mr\":\"1\",\"gender:Mrs\":\"2\",\"quick_access:New_category\":\"1\",\"quick_access:New_product\":\"2\",\"quick_access:New_voucher\":\"3\",\"operating_system:Windows_XP\":1,\"operating_system:Windows_Vista\":2,\"operating_system:Windows_7\":3,\"operating_system:Windows_8\":4,\"operating_system:MacOsX\":5,\"operating_system:Linux\":6,\"operating_system:Android\":7,\"order_state:Awaiting_cheque_payment\":\"1\",\"order_state:Payment_accepted\":\"2\",\"order_state:Preparation_in_progress\":\"3\",\"order_state:Shipped\":\"4\",\"order_state:Delivered\":\"5\",\"order_state:Canceled\":\"6\",\"order_state:Refund\":\"7\",\"order_state:Payment_error\":\"8\",\"order_state:On_backorder_paid\":\"9\",\"order_state:Awaiting_bank_wire_payment\":\"10\",\"order_state:Awaiting_PayPal_payment\":\"11\",\"order_state:Payment_remotely_accepted\":\"12\",\"order_state:On_backorder_unpaid\":\"13\",\"order_state:Awaiting_cod_validation\":\"14\",\"hook:displayPayment\":1,\"hook:actionValidateOrder\":2,\"hook:displayMaintenance\":3,\"hook:actionPaymentConfirmation\":4,\"hook:displayPaymentReturn\":5,\"hook:actionUpdateQuantity\":6,\"hook:displayRightColumn\":7,\"hook:displayLeftColumn\":8,\"hook:displayHome\":9,\"hook:Header\":10,\"hook:actionCartSave\":11,\"hook:actionAuthentication\":12,\"hook:actionProductAdd\":13,\"hook:actionProductUpdate\":14,\"hook:displayTop\":15,\"hook:displayRightColumnProduct\":16,\"hook:actionProductDelete\":17,\"hook:displayFooterProduct\":18,\"hook:displayInvoice\":19,\"hook:actionOrderStatusUpdate\":20,\"hook:displayAdminOrder\":21,\"hook:displayAdminOrderTabOrder\":22,\"hook:displayAdminOrderTabShip\":23,\"hook:displayAdminOrderContentOrder\":24,\"hook:displayAdminOrderContentShip\":25,\"hook:displayFooter\":26,\"hook:displayPDFInvoice\":27,\"hook:displayInvoiceLegalFreeText\":28,\"hook:displayAdminCustomers\":29,\"hook:displayOrderConfirmation\":30,\"hook:actionCustomerAccountAdd\":31,\"hook:displayCustomerAccount\":32,\"hook:displayCustomerIdentityForm\":33,\"hook:actionOrderSlipAdd\":34,\"hook:displayProductTab\":35,\"hook:displayProductTabContent\":36,\"hook:displayShoppingCartFooter\":37,\"hook:displayCustomerAccountForm\":38,\"hook:displayAdminStatsModules\":39,\"hook:displayAdminStatsGraphEngine\":40,\"hook:actionOrderReturn\":41,\"hook:displayProductButtons\":42,\"hook:displayBackOfficeHome\":43,\"hook:displayAdminStatsGridEngine\":44,\"hook:actionWatermark\":45,\"hook:actionProductCancel\":46,\"hook:displayLeftColumnProduct\":47,\"hook:actionProductOutOfStock\":48,\"hook:actionProductAttributeUpdate\":49,\"hook:displayCarrierList\":50,\"hook:displayShoppingCart\":51,\"hook:actionSearch\":52,\"hook:displayBeforePayment\":53,\"hook:actionCarrierUpdate\":54,\"hook:actionOrderStatusPostUpdate\":55,\"hook:displayCustomerAccountFormTop\":56,\"hook:displayBackOfficeHeader\":57,\"hook:displayBackOfficeTop\":58,\"hook:displayBackOfficeFooter\":59,\"hook:actionProductAttributeDelete\":60,\"hook:actionCarrierProcess\":61,\"hook:actionOrderDetail\":62,\"hook:displayBeforeCarrier\":63,\"hook:displayOrderDetail\":64,\"hook:actionPaymentCCAdd\":65,\"hook:displayProductComparison\":66,\"hook:actionCategoryAdd\":67,\"hook:actionCategoryUpdate\":68,\"hook:actionCategoryDelete\":69,\"hook:actionBeforeAuthentication\":70,\"hook:displayPaymentTop\":71,\"hook:actionHtaccessCreate\":72,\"hook:actionAdminMetaSave\":73,\"hook:displayAttributeGroupForm\":74,\"hook:actionAttributeGroupSave\":75,\"hook:actionAttributeGroupDelete\":76,\"hook:displayFeatureForm\":77,\"hook:actionFeatureSave\":78,\"hook:actionFeatureDelete\":79,\"hook:actionProductSave\":80,\"hook:actionProductListOverride\":81,\"hook:displayAttributeGroupPostProcess\":82,\"hook:displayFeaturePostProcess\":83,\"hook:displayFeatureValueForm\":84,\"hook:displayFeatureValuePostProcess\":85,\"hook:actionFeatureValueDelete\":86,\"hook:actionFeatureValueSave\":87,\"hook:displayAttributeForm\":88,\"hook:actionAttributePostProcess\":89,\"hook:actionAttributeDelete\":90,\"hook:actionAttributeSave\":91,\"hook:actionTaxManager\":92,\"hook:displayMyAccountBlock\":93,\"hook:actionModuleInstallBefore\":94,\"hook:actionModuleInstallAfter\":95,\"hook:displayHomeTab\":96,\"hook:displayHomeTabContent\":97,\"hook:displayTopColumn\":98,\"hook:displayBackOfficeCategory\":99,\"hook:displayProductListFunctionalButtons\":100,\"hook:displayNav\":101,\"hook:displayOverrideTemplate\":102,\"hook:actionAdminLoginControllerSetMedia\":103,\"hook:actionOrderEdited\":104,\"hook:actionEmailAddBeforeContent\":105,\"hook:actionEmailAddAfterContent\":106,\"hook:displayCartExtraProductActions\":107,\"stock_mvt_reason:Increase\":\"1\",\"stock_mvt_reason:Decrease\":\"2\",\"stock_mvt_reason:Customer_Order\":\"3\",\"stock_mvt_reason:Regulation_following_an_inventory_of_stock\":\"4\",\"stock_mvt_reason:Regulation_following_an_inventory_of_stock_1\":\"5\",\"stock_mvt_reason:Transfer_to_another_warehouse\":\"6\",\"stock_mvt_reason:Transfer_from_another_warehouse\":\"7\",\"stock_mvt_reason:Supply_Order\":\"8\",\"timezone:Africa_Abidjan\":1,\"timezone:Africa_Accra\":2,\"timezone:Africa_Addis_Ababa\":3,\"timezone:Africa_Algiers\":4,\"timezone:Africa_Asmara\":5,\"timezone:Africa_Asmera\":6,\"timezone:Africa_Bamako\":7,\"timezone:Africa_Bangui\":8,\"timezone:Africa_Banjul\":9,\"timezone:Africa_Bissau\":10,\"timezone:Africa_Blantyre\":11,\"timezone:Africa_Brazzaville\":12,\"timezone:Africa_Bujumbura\":13,\"timezone:Africa_Cairo\":14,\"timezone:Africa_Casablanca\":15,\"timezone:Africa_Ceuta\":16,\"timezone:Africa_Conakry\":17,\"timezone:Africa_Dakar\":18,\"timezone:Africa_Dar_es_Salaam\":19,\"timezone:Africa_Djibouti\":20,\"timezone:Africa_Douala\":21,\"timezone:Africa_El_Aaiun\":22,\"timezone:Africa_Freetown\":23,\"timezone:Africa_Gaborone\":24,\"timezone:Africa_Harare\":25,\"timezone:Africa_Johannesburg\":26,\"timezone:Africa_Kampala\":27,\"timezone:Africa_Khartoum\":28,\"timezone:Africa_Kigali\":29,\"timezone:Africa_Kinshasa\":30,\"timezone:Africa_Lagos\":31,\"timezone:Africa_Libreville\":32,\"timezone:Africa_Lome\":33,\"timezone:Africa_Luanda\":34,\"timezone:Africa_Lubumbashi\":35,\"timezone:Africa_Lusaka\":36,\"timezone:Africa_Malabo\":37,\"timezone:Africa_Maputo\":38,\"timezone:Africa_Maseru\":39,\"timezone:Africa_Mbabane\":40,\"timezone:Africa_Mogadishu\":41,\"timezone:Africa_Monrovia\":42,\"timezone:Africa_Nairobi\":43,\"timezone:Africa_Ndjamena\":44,\"timezone:Africa_Niamey\":45,\"timezone:Africa_Nouakchott\":46,\"timezone:Africa_Ouagadougou\":47,\"timezone:Africa_Porto-Novo\":48,\"timezone:Africa_Sao_Tome\":49,\"timezone:Africa_Timbuktu\":50,\"timezone:Africa_Tripoli\":51,\"timezone:Africa_Tunis\":52,\"timezone:Africa_Windhoek\":53,\"timezone:America_Adak\":54,\"timezone:America_Anchorage\":55,\"timezone:America_Anguilla\":56,\"timezone:America_Antigua\":57,\"timezone:America_Araguaina\":58,\"timezone:America_Argentina_Buenos_Aires\":59,\"timezone:America_Argentina_Catamarca\":60,\"timezone:America_Argentina_ComodRivadavia\":61,\"timezone:America_Argentina_Cordoba\":62,\"timezone:America_Argentina_Jujuy\":63,\"timezone:America_Argentina_La_Rioja\":64,\"timezone:America_Argentina_Mendoza\":65,\"timezone:America_Argentina_Rio_Gallegos\":66,\"timezone:America_Argentina_Salta\":67,\"timezone:America_Argentina_San_Juan\":68,\"timezone:America_Argentina_San_Luis\":69,\"timezone:America_Argentina_Tucuman\":70,\"timezone:America_Argentina_Ushuaia\":71,\"timezone:America_Aruba\":72,\"timezone:America_Asuncion\":73,\"timezone:America_Atikokan\":74,\"timezone:America_Atka\":75,\"timezone:America_Bahia\":76,\"timezone:America_Barbados\":77,\"timezone:America_Belem\":78,\"timezone:America_Belize\":79,\"timezone:America_Blanc-Sablon\":80,\"timezone:America_Boa_Vista\":81,\"timezone:America_Bogota\":82,\"timezone:America_Boise\":83,\"timezone:America_Buenos_Aires\":84,\"timezone:America_Cambridge_Bay\":85,\"timezone:America_Campo_Grande\":86,\"timezone:America_Cancun\":87,\"timezone:America_Caracas\":88,\"timezone:America_Catamarca\":89,\"timezone:America_Cayenne\":90,\"timezone:America_Cayman\":91,\"timezone:America_Chicago\":92,\"timezone:America_Chihuahua\":93,\"timezone:America_Coral_Harbour\":94,\"timezone:America_Cordoba\":95,\"timezone:America_Costa_Rica\":96,\"timezone:America_Cuiaba\":97,\"timezone:America_Curacao\":98,\"timezone:America_Danmarkshavn\":99,\"timezone:America_Dawson\":100,\"timezone:America_Dawson_Creek\":101,\"timezone:America_Denver\":102,\"timezone:America_Detroit\":103,\"timezone:America_Dominica\":104,\"timezone:America_Edmonton\":105,\"timezone:America_Eirunepe\":106,\"timezone:America_El_Salvador\":107,\"timezone:America_Ensenada\":108,\"timezone:America_Fort_Wayne\":109,\"timezone:America_Fortaleza\":110,\"timezone:America_Glace_Bay\":111,\"timezone:America_Godthab\":112,\"timezone:America_Goose_Bay\":113,\"timezone:America_Grand_Turk\":114,\"timezone:America_Grenada\":115,\"timezone:America_Guadeloupe\":116,\"timezone:America_Guatemala\":117,\"timezone:America_Guayaquil\":118,\"timezone:America_Guyana\":119,\"timezone:America_Halifax\":120,\"timezone:America_Havana\":121,\"timezone:America_Hermosillo\":122,\"timezone:America_Indiana_Indianapolis\":123,\"timezone:America_Indiana_Knox\":124,\"timezone:America_Indiana_Marengo\":125,\"timezone:America_Indiana_Petersburg\":126,\"timezone:America_Indiana_Tell_City\":127,\"timezone:America_Indiana_Vevay\":128,\"timezone:America_Indiana_Vincennes\":129,\"timezone:America_Indiana_Winamac\":130,\"timezone:America_Indianapolis\":131,\"timezone:America_Inuvik\":132,\"timezone:America_Iqaluit\":133,\"timezone:America_Jamaica\":134,\"timezone:America_Jujuy\":135,\"timezone:America_Juneau\":136,\"timezone:America_Kentucky_Louisville\":137,\"timezone:America_Kentucky_Monticello\":138,\"timezone:America_Knox_IN\":139,\"timezone:America_La_Paz\":140,\"timezone:America_Lima\":141,\"timezone:America_Los_Angeles\":142,\"timezone:America_Louisville\":143,\"timezone:America_Maceio\":144,\"timezone:America_Managua\":145,\"timezone:America_Manaus\":146,\"timezone:America_Marigot\":147,\"timezone:America_Martinique\":148,\"timezone:America_Mazatlan\":149,\"timezone:America_Mendoza\":150,\"timezone:America_Menominee\":151,\"timezone:America_Merida\":152,\"timezone:America_Mexico_City\":153,\"timezone:America_Miquelon\":154,\"timezone:America_Moncton\":155,\"timezone:America_Monterrey\":156,\"timezone:America_Montevideo\":157,\"timezone:America_Montreal\":158,\"timezone:America_Montserrat\":159,\"timezone:America_Nassau\":160,\"timezone:America_New_York\":161,\"timezone:America_Nipigon\":162,\"timezone:America_Nome\":163,\"timezone:America_Noronha\":164,\"timezone:America_North_Dakota_Center\":165,\"timezone:America_North_Dakota_New_Salem\":166,\"timezone:America_Panama\":167,\"timezone:America_Pangnirtung\":168,\"timezone:America_Paramaribo\":169,\"timezone:America_Phoenix\":170,\"timezone:America_Port-au-Prince\":171,\"timezone:America_Port_of_Spain\":172,\"timezone:America_Porto_Acre\":173,\"timezone:America_Porto_Velho\":174,\"timezone:America_Puerto_Rico\":175,\"timezone:America_Rainy_River\":176,\"timezone:America_Rankin_Inlet\":177,\"timezone:America_Recife\":178,\"timezone:America_Regina\":179,\"timezone:America_Resolute\":180,\"timezone:America_Rio_Branco\":181,\"timezone:America_Rosario\":182,\"timezone:America_Santarem\":183,\"timezone:America_Santiago\":184,\"timezone:America_Santo_Domingo\":185,\"timezone:America_Sao_Paulo\":186,\"timezone:America_Scoresbysund\":187,\"timezone:America_Shiprock\":188,\"timezone:America_St_Barthelemy\":189,\"timezone:America_St_Johns\":190,\"timezone:America_St_Kitts\":191,\"timezone:America_St_Lucia\":192,\"timezone:America_St_Thomas\":193,\"timezone:America_St_Vincent\":194,\"timezone:America_Swift_Current\":195,\"timezone:America_Tegucigalpa\":196,\"timezone:America_Thule\":197,\"timezone:America_Thunder_Bay\":198,\"timezone:America_Tijuana\":199,\"timezone:America_Toronto\":200,\"timezone:America_Tortola\":201,\"timezone:America_Vancouver\":202,\"timezone:America_Virgin\":203,\"timezone:America_Whitehorse\":204,\"timezone:America_Winnipeg\":205,\"timezone:America_Yakutat\":206,\"timezone:America_Yellowknife\":207,\"timezone:Antarctica_Casey\":208,\"timezone:Antarctica_Davis\":209,\"timezone:Antarctica_DumontDUrville\":210,\"timezone:Antarctica_Mawson\":211,\"timezone:Antarctica_McMurdo\":212,\"timezone:Antarctica_Palmer\":213,\"timezone:Antarctica_Rothera\":214,\"timezone:Antarctica_South_Pole\":215,\"timezone:Antarctica_Syowa\":216,\"timezone:Antarctica_Vostok\":217,\"timezone:Arctic_Longyearbyen\":218,\"timezone:Asia_Aden\":219,\"timezone:Asia_Almaty\":220,\"timezone:Asia_Amman\":221,\"timezone:Asia_Anadyr\":222,\"timezone:Asia_Aqtau\":223,\"timezone:Asia_Aqtobe\":224,\"timezone:Asia_Ashgabat\":225,\"timezone:Asia_Ashkhabad\":226,\"timezone:Asia_Baghdad\":227,\"timezone:Asia_Bahrain\":228,\"timezone:Asia_Baku\":229,\"timezone:Asia_Bangkok\":230,\"timezone:Asia_Beirut\":231,\"timezone:Asia_Bishkek\":232,\"timezone:Asia_Brunei\":233,\"timezone:Asia_Calcutta\":234,\"timezone:Asia_Choibalsan\":235,\"timezone:Asia_Chongqing\":236,\"timezone:Asia_Chungking\":237,\"timezone:Asia_Colombo\":238,\"timezone:Asia_Dacca\":239,\"timezone:Asia_Damascus\":240,\"timezone:Asia_Dhaka\":241,\"timezone:Asia_Dili\":242,\"timezone:Asia_Dubai\":243,\"timezone:Asia_Dushanbe\":244,\"timezone:Asia_Gaza\":245,\"timezone:Asia_Harbin\":246,\"timezone:Asia_Ho_Chi_Minh\":247,\"timezone:Asia_Hong_Kong\":248,\"timezone:Asia_Hovd\":249,\"timezone:Asia_Irkutsk\":250,\"timezone:Asia_Istanbul\":251,\"timezone:Asia_Jakarta\":252,\"timezone:Asia_Jayapura\":253,\"timezone:Asia_Jerusalem\":254,\"timezone:Asia_Kabul\":255,\"timezone:Asia_Kamchatka\":256,\"timezone:Asia_Karachi\":257,\"timezone:Asia_Kashgar\":258,\"timezone:Asia_Kathmandu\":259,\"timezone:Asia_Katmandu\":260,\"timezone:Asia_Kolkata\":261,\"timezone:Asia_Krasnoyarsk\":262,\"timezone:Asia_Kuala_Lumpur\":263,\"timezone:Asia_Kuching\":264,\"timezone:Asia_Kuwait\":265,\"timezone:Asia_Macao\":266,\"timezone:Asia_Macau\":267,\"timezone:Asia_Magadan\":268,\"timezone:Asia_Makassar\":269,\"timezone:Asia_Manila\":270,\"timezone:Asia_Muscat\":271,\"timezone:Asia_Nicosia\":272,\"timezone:Asia_Novosibirsk\":273,\"timezone:Asia_Omsk\":274,\"timezone:Asia_Oral\":275,\"timezone:Asia_Phnom_Penh\":276,\"timezone:Asia_Pontianak\":277,\"timezone:Asia_Pyongyang\":278,\"timezone:Asia_Qatar\":279,\"timezone:Asia_Qyzylorda\":280,\"timezone:Asia_Rangoon\":281,\"timezone:Asia_Riyadh\":282,\"timezone:Asia_Saigon\":283,\"timezone:Asia_Sakhalin\":284,\"timezone:Asia_Samarkand\":285,\"timezone:Asia_Seoul\":286,\"timezone:Asia_Shanghai\":287,\"timezone:Asia_Singapore\":288,\"timezone:Asia_Taipei\":289,\"timezone:Asia_Tashkent\":290,\"timezone:Asia_Tbilisi\":291,\"timezone:Asia_Tehran\":292,\"timezone:Asia_Tel_Aviv\":293,\"timezone:Asia_Thimbu\":294,\"timezone:Asia_Thimphu\":295,\"timezone:Asia_Tokyo\":296,\"timezone:Asia_Ujung_Pandang\":297,\"timezone:Asia_Ulaanbaatar\":298,\"timezone:Asia_Ulan_Bator\":299,\"timezone:Asia_Urumqi\":300,\"timezone:Asia_Vientiane\":301,\"timezone:Asia_Vladivostok\":302,\"timezone:Asia_Yakutsk\":303,\"timezone:Asia_Yekaterinburg\":304,\"timezone:Asia_Yerevan\":305,\"timezone:Atlantic_Azores\":306,\"timezone:Atlantic_Bermuda\":307,\"timezone:Atlantic_Canary\":308,\"timezone:Atlantic_Cape_Verde\":309,\"timezone:Atlantic_Faeroe\":310,\"timezone:Atlantic_Faroe\":311,\"timezone:Atlantic_Jan_Mayen\":312,\"timezone:Atlantic_Madeira\":313,\"timezone:Atlantic_Reykjavik\":314,\"timezone:Atlantic_South_Georgia\":315,\"timezone:Atlantic_St_Helena\":316,\"timezone:Atlantic_Stanley\":317,\"timezone:Australia_ACT\":318,\"timezone:Australia_Adelaide\":319,\"timezone:Australia_Brisbane\":320,\"timezone:Australia_Broken_Hill\":321,\"timezone:Australia_Canberra\":322,\"timezone:Australia_Currie\":323,\"timezone:Australia_Darwin\":324,\"timezone:Australia_Eucla\":325,\"timezone:Australia_Hobart\":326,\"timezone:Australia_LHI\":327,\"timezone:Australia_Lindeman\":328,\"timezone:Australia_Lord_Howe\":329,\"timezone:Australia_Melbourne\":330,\"timezone:Australia_North\":331,\"timezone:Australia_NSW\":332,\"timezone:Australia_Perth\":333,\"timezone:Australia_Queensland\":334,\"timezone:Australia_South\":335,\"timezone:Australia_Sydney\":336,\"timezone:Australia_Tasmania\":337,\"timezone:Australia_Victoria\":338,\"timezone:Australia_West\":339,\"timezone:Australia_Yancowinna\":340,\"timezone:Europe_Amsterdam\":341,\"timezone:Europe_Andorra\":342,\"timezone:Europe_Athens\":343,\"timezone:Europe_Belfast\":344,\"timezone:Europe_Belgrade\":345,\"timezone:Europe_Berlin\":346,\"timezone:Europe_Bratislava\":347,\"timezone:Europe_Brussels\":348,\"timezone:Europe_Bucharest\":349,\"timezone:Europe_Budapest\":350,\"timezone:Europe_Chisinau\":351,\"timezone:Europe_Copenhagen\":352,\"timezone:Europe_Dublin\":353,\"timezone:Europe_Gibraltar\":354,\"timezone:Europe_Guernsey\":355,\"timezone:Europe_Helsinki\":356,\"timezone:Europe_Isle_of_Man\":357,\"timezone:Europe_Istanbul\":358,\"timezone:Europe_Jersey\":359,\"timezone:Europe_Kaliningrad\":360,\"timezone:Europe_Kiev\":361,\"timezone:Europe_Lisbon\":362,\"timezone:Europe_Ljubljana\":363,\"timezone:Europe_London\":364,\"timezone:Europe_Luxembourg\":365,\"timezone:Europe_Madrid\":366,\"timezone:Europe_Malta\":367,\"timezone:Europe_Mariehamn\":368,\"timezone:Europe_Minsk\":369,\"timezone:Europe_Monaco\":370,\"timezone:Europe_Moscow\":371,\"timezone:Europe_Nicosia\":372,\"timezone:Europe_Oslo\":373,\"timezone:Europe_Paris\":374,\"timezone:Europe_Podgorica\":375,\"timezone:Europe_Prague\":376,\"timezone:Europe_Riga\":377,\"timezone:Europe_Rome\":378,\"timezone:Europe_Samara\":379,\"timezone:Europe_San_Marino\":380,\"timezone:Europe_Sarajevo\":381,\"timezone:Europe_Simferopol\":382,\"timezone:Europe_Skopje\":383,\"timezone:Europe_Sofia\":384,\"timezone:Europe_Stockholm\":385,\"timezone:Europe_Tallinn\":386,\"timezone:Europe_Tirane\":387,\"timezone:Europe_Tiraspol\":388,\"timezone:Europe_Uzhgorod\":389,\"timezone:Europe_Vaduz\":390,\"timezone:Europe_Vatican\":391,\"timezone:Europe_Vienna\":392,\"timezone:Europe_Vilnius\":393,\"timezone:Europe_Volgograd\":394,\"timezone:Europe_Warsaw\":395,\"timezone:Europe_Zagreb\":396,\"timezone:Europe_Zaporozhye\":397,\"timezone:Europe_Zurich\":398,\"timezone:Indian_Antananarivo\":399,\"timezone:Indian_Chagos\":400,\"timezone:Indian_Christmas\":401,\"timezone:Indian_Cocos\":402,\"timezone:Indian_Comoro\":403,\"timezone:Indian_Kerguelen\":404,\"timezone:Indian_Mahe\":405,\"timezone:Indian_Maldives\":406,\"timezone:Indian_Mauritius\":407,\"timezone:Indian_Mayotte\":408,\"timezone:Indian_Reunion\":409,\"timezone:Pacific_Apia\":410,\"timezone:Pacific_Auckland\":411,\"timezone:Pacific_Chatham\":412,\"timezone:Pacific_Easter\":413,\"timezone:Pacific_Efate\":414,\"timezone:Pacific_Enderbury\":415,\"timezone:Pacific_Fakaofo\":416,\"timezone:Pacific_Fiji\":417,\"timezone:Pacific_Funafuti\":418,\"timezone:Pacific_Galapagos\":419,\"timezone:Pacific_Gambier\":420,\"timezone:Pacific_Guadalcanal\":421,\"timezone:Pacific_Guam\":422,\"timezone:Pacific_Honolulu\":423,\"timezone:Pacific_Johnston\":424,\"timezone:Pacific_Kiritimati\":425,\"timezone:Pacific_Kosrae\":426,\"timezone:Pacific_Kwajalein\":427,\"timezone:Pacific_Majuro\":428,\"timezone:Pacific_Marquesas\":429,\"timezone:Pacific_Midway\":430,\"timezone:Pacific_Nauru\":431,\"timezone:Pacific_Niue\":432,\"timezone:Pacific_Norfolk\":433,\"timezone:Pacific_Noumea\":434,\"timezone:Pacific_Pago_Pago\":435,\"timezone:Pacific_Palau\":436,\"timezone:Pacific_Pitcairn\":437,\"timezone:Pacific_Ponape\":438,\"timezone:Pacific_Port_Moresby\":439,\"timezone:Pacific_Rarotonga\":440,\"timezone:Pacific_Saipan\":441,\"timezone:Pacific_Samoa\":442,\"timezone:Pacific_Tahiti\":443,\"timezone:Pacific_Tarawa\":444,\"timezone:Pacific_Tongatapu\":445,\"timezone:Pacific_Truk\":446,\"timezone:Pacific_Wake\":447,\"timezone:Pacific_Wallis\":448,\"timezone:Pacific_Yap\":449,\"timezone:Brazil_Acre\":450,\"timezone:Brazil_DeNoronha\":451,\"timezone:Brazil_East\":452,\"timezone:Brazil_West\":453,\"timezone:Canada_Atlantic\":454,\"timezone:Canada_Central\":455,\"timezone:Canada_East-Saskatchewan\":456,\"timezone:Canada_Eastern\":457,\"timezone:Canada_Mountain\":458,\"timezone:Canada_Newfoundland\":459,\"timezone:Canada_Pacific\":460,\"timezone:Canada_Saskatchewan\":461,\"timezone:Canada_Yukon\":462,\"timezone:CET\":463,\"timezone:Chile_Continental\":464,\"timezone:Chile_EasterIsland\":465,\"timezone:CST6CDT\":466,\"timezone:Cuba\":467,\"timezone:EET\":468,\"timezone:Egypt\":469,\"timezone:Eire\":470,\"timezone:EST\":471,\"timezone:EST5EDT\":472,\"timezone:Etc_GMT\":473,\"timezone:Etc_GMT_0\":474,\"timezone:Etc_GMT_1\":475,\"timezone:Etc_GMT_10\":476,\"timezone:Etc_GMT_11\":477,\"timezone:Etc_GMT_12\":478,\"timezone:Etc_GMT_2\":479,\"timezone:Etc_GMT_3\":480,\"timezone:Etc_GMT_4\":481,\"timezone:Etc_GMT_5\":482,\"timezone:Etc_GMT_6\":483,\"timezone:Etc_GMT_7\":484,\"timezone:Etc_GMT_8\":485,\"timezone:Etc_GMT_9\":486,\"timezone:Etc_GMT-0\":487,\"timezone:Etc_GMT-1\":488,\"timezone:Etc_GMT-10\":489,\"timezone:Etc_GMT-11\":490,\"timezone:Etc_GMT-12\":491,\"timezone:Etc_GMT-13\":492,\"timezone:Etc_GMT-14\":493,\"timezone:Etc_GMT-2\":494,\"timezone:Etc_GMT-3\":495,\"timezone:Etc_GMT-4\":496,\"timezone:Etc_GMT-5\":497,\"timezone:Etc_GMT-6\":498,\"timezone:Etc_GMT-7\":499,\"timezone:Etc_GMT-8\":500,\"timezone:Etc_GMT-9\":501,\"timezone:Etc_GMT0\":502,\"timezone:Etc_Greenwich\":503,\"timezone:Etc_UCT\":504,\"timezone:Etc_Universal\":505,\"timezone:Etc_UTC\":506,\"timezone:Etc_Zulu\":507,\"timezone:Factory\":508,\"timezone:GB\":509,\"timezone:GB-Eire\":510,\"timezone:GMT\":511,\"timezone:GMT_0\":512,\"timezone:GMT-0\":513,\"timezone:GMT0\":514,\"timezone:Greenwich\":515,\"timezone:Hongkong\":516,\"timezone:HST\":517,\"timezone:Iceland\":518,\"timezone:Iran\":519,\"timezone:Israel\":520,\"timezone:Jamaica\":521,\"timezone:Japan\":522,\"timezone:Kwajalein\":523,\"timezone:Libya\":524,\"timezone:MET\":525,\"timezone:Mexico_BajaNorte\":526,\"timezone:Mexico_BajaSur\":527,\"timezone:Mexico_General\":528,\"timezone:MST\":529,\"timezone:MST7MDT\":530,\"timezone:Navajo\":531,\"timezone:NZ\":532,\"timezone:NZ-CHAT\":533,\"timezone:Poland\":534,\"timezone:Portugal\":535,\"timezone:PRC\":536,\"timezone:PST8PDT\":537,\"timezone:ROC\":538,\"timezone:ROK\":539,\"timezone:Singapore\":540,\"timezone:Turkey\":541,\"timezone:UCT\":542,\"timezone:Universal\":543,\"timezone:US_Alaska\":544,\"timezone:US_Aleutian\":545,\"timezone:US_Arizona\":546,\"timezone:US_Central\":547,\"timezone:US_East-Indiana\":548,\"timezone:US_Eastern\":549,\"timezone:US_Hawaii\":550,\"timezone:US_Indiana-Starke\":551,\"timezone:US_Michigan\":552,\"timezone:US_Mountain\":553,\"timezone:US_Pacific\":554,\"timezone:US_Pacific-New\":555,\"timezone:US_Samoa\":556,\"timezone:UTC\":557,\"timezone:W-SU\":558,\"timezone:WET\":559,\"timezone:Zulu\":560,\"supply_order_state:supply_order_state_1\":\"1\",\"supply_order_state:supply_order_state_2\":\"2\",\"supply_order_state:supply_order_state_3\":\"3\",\"supply_order_state:supply_order_state_4\":\"4\",\"supply_order_state:supply_order_state_5\":\"5\",\"supply_order_state:supply_order_state_6\":\"6\",\"search_engine:google\":\"1\",\"search_engine:aol\":\"2\",\"search_engine:yandex\":\"3\",\"search_engine:ask_com\":\"4\",\"search_engine:nhl_com\":\"5\",\"search_engine:yahoo\":\"6\",\"search_engine:baidu\":\"7\",\"search_engine:lycos\":\"8\",\"search_engine:exalead\":\"9\",\"search_engine:search_live\":\"10\",\"search_engine:voila\":\"11\",\"search_engine:altavista\":\"12\",\"search_engine:bing\":\"13\",\"search_engine:daum\":\"14\",\"search_engine:eniro\":\"15\",\"search_engine:naver\":\"16\",\"search_engine:msn\":\"17\",\"search_engine:netscape\":\"18\",\"search_engine:cnn\":\"19\",\"search_engine:about\":\"20\",\"search_engine:mamma\":\"21\",\"search_engine:alltheweb\":\"22\",\"search_engine:virgilio\":\"23\",\"search_engine:alice\":\"24\",\"search_engine:najdi\":\"25\",\"search_engine:mama\":\"26\",\"search_engine:seznam\":\"27\",\"search_engine:onet\":\"28\",\"search_engine:szukacz\":\"29\",\"search_engine:yam\":\"30\",\"search_engine:pchome\":\"31\",\"search_engine:kvasir\":\"32\",\"search_engine:sesam\":\"33\",\"search_engine:ozu\":\"34\",\"search_engine:terra\":\"35\",\"search_engine:mynet\":\"36\",\"search_engine:ekolay\":\"37\",\"search_engine:rambler\":\"38\",\"carrier_zone:carrier_zone_1_1\":0,\"carrier_tax_rules_group_shop:carrier_tax_rules_group_shop_1_1_1\":0,\"risk:None\":\"1\",\"risk:Low\":\"2\",\"risk:Medium\":\"3\",\"risk:High\":\"4\",\"order_return_state:Waiting_for_confirmation\":\"1\",\"order_return_state:Waiting_for_package\":\"2\",\"order_return_state:Package_received\":\"3\",\"order_return_state:Return_denied\":\"4\",\"order_return_state:Return_completed\":\"5\",\"category:Root\":\"1\",\"category:Home\":\"2\",\"contact:Webmaster\":\"1\",\"contact:Customer_service\":\"2\",\"category_group:category_group_1_1\":0,\"category_group:category_group_1_2\":0,\"category_group:category_group_1_3\":0}','2025-03-04 08:13:15','2025-03-04 08:13:15'),(285,NULL,NULL,'PS_SC_TWITTER','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(286,NULL,NULL,'PS_SC_FACEBOOK','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(287,NULL,NULL,'PS_SC_GOOGLE','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(288,NULL,NULL,'PS_SC_PINTEREST','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(289,NULL,NULL,'BLOCKBANNER_IMG',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(290,NULL,NULL,'BLOCKBANNER_LINK',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(291,NULL,NULL,'BLOCKBANNER_DESC',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(292,NULL,NULL,'CONF_BANKWIRE_FIXED','0.2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(293,NULL,NULL,'CONF_BANKWIRE_VAR','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(294,NULL,NULL,'CONF_BANKWIRE_FIXED_FOREIGN','0.2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(295,NULL,NULL,'CONF_BANKWIRE_VAR_FOREIGN','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(296,NULL,NULL,'PS_BLOCK_BESTSELLERS_TO_DISPLAY','10','2025-03-04 08:13:16','2025-03-04 08:13:16'),(297,NULL,NULL,'PS_BLOCK_CART_XSELL_LIMIT','12','2025-03-04 08:13:16','2025-03-04 08:13:16'),(298,NULL,NULL,'PS_BLOCK_CART_SHOW_CROSSSELLING','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(299,NULL,NULL,'BLOCKSOCIAL_YOUTUBE',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(300,NULL,NULL,'BLOCKSOCIAL_GOOGLE_PLUS','https://www.google.com/+prestashop','2025-03-04 08:13:16','2025-03-04 08:13:16'),(301,NULL,NULL,'BLOCKSOCIAL_PINTEREST',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(302,NULL,NULL,'BLOCKSOCIAL_VIMEO',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(303,NULL,NULL,'BLOCKSOCIAL_INSTAGRAM',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(304,NULL,NULL,'BLOCK_CATEG_ROOT_CATEGORY','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(305,NULL,NULL,'blockfacebook_url','https://www.facebook.com/prestashop','2025-03-04 08:13:16','2025-03-04 08:13:16'),(306,NULL,NULL,'PS_LAYERED_HIDE_0_VALUES','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(307,NULL,NULL,'PS_LAYERED_SHOW_QTIES','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(308,NULL,NULL,'PS_LAYERED_FULL_TREE','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(309,NULL,NULL,'PS_LAYERED_FILTER_PRICE_USETAX','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(310,NULL,NULL,'PS_LAYERED_FILTER_CATEGORY_DEPTH','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(311,NULL,NULL,'PS_LAYERED_FILTER_INDEX_QTY','0','2025-03-04 08:13:16','2025-03-04 08:13:16'),(312,NULL,NULL,'PS_LAYERED_FILTER_INDEX_CDT','0','2025-03-04 08:13:16','2025-03-04 08:13:16'),(313,NULL,NULL,'PS_LAYERED_FILTER_INDEX_MNF','0','2025-03-04 08:13:16','2025-03-04 08:13:16'),(314,NULL,NULL,'PS_LAYERED_FILTER_INDEX_CAT','0','2025-03-04 08:13:16','2025-03-04 08:13:16'),(315,NULL,NULL,'PS_LAYERED_FILTER_PRICE_ROUNDING','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(316,NULL,NULL,'PS_LAYERED_INDEXED','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(317,NULL,NULL,'FOOTER_PRICE-DROP','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(318,NULL,NULL,'FOOTER_NEW-PRODUCTS','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(319,NULL,NULL,'FOOTER_BEST-SALES','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(320,NULL,NULL,'FOOTER_CONTACT','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(321,NULL,NULL,'FOOTER_SITEMAP','1','2025-03-04 08:13:16','2025-03-04 08:13:16'),(322,NULL,NULL,'PS_NEWSLETTER_RAND','1492424414677358916','2025-03-04 08:13:16','2025-03-04 08:13:16'),(323,NULL,NULL,'BLOCKSPECIALS_NB_CACHES','20','2025-03-04 08:13:16','2025-03-04 08:13:16'),(324,NULL,NULL,'BLOCKSPECIALS_SPECIALS_NBR','5','2025-03-04 08:13:16','2025-03-04 08:13:16'),(325,NULL,NULL,'BLOCKTAGS_MAX_LEVEL','3','2025-03-04 08:13:16','2025-03-04 08:13:16'),(326,NULL,NULL,'CONF_CHEQUE_FIXED','0.2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(327,NULL,NULL,'CONF_CHEQUE_VAR','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(328,NULL,NULL,'CONF_CHEQUE_FIXED_FOREIGN','0.2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(329,NULL,NULL,'CONF_CHEQUE_VAR_FOREIGN','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(330,NULL,NULL,'DASHACTIVITY_CART_ACTIVE','30','2025-03-04 08:13:16','2025-03-04 08:13:16'),(331,NULL,NULL,'DASHACTIVITY_CART_ABANDONED_MIN','24','2025-03-04 08:13:16','2025-03-04 08:13:16'),(332,NULL,NULL,'DASHACTIVITY_CART_ABANDONED_MAX','48','2025-03-04 08:13:16','2025-03-04 08:13:16'),(333,NULL,NULL,'DASHACTIVITY_VISITOR_ONLINE','30','2025-03-04 08:13:16','2025-03-04 08:13:16'),(334,NULL,NULL,'PS_DASHGOALS_CURRENT_YEAR','2025','2025-03-04 08:13:16','2025-03-04 08:13:16'),(335,NULL,NULL,'DASHPRODUCT_NBR_SHOW_LAST_ORDER','10','2025-03-04 08:13:16','2025-03-04 08:13:16'),(336,NULL,NULL,'DASHPRODUCT_NBR_SHOW_BEST_SELLER','10','2025-03-04 08:13:16','2025-03-04 08:13:16'),(337,NULL,NULL,'DASHPRODUCT_NBR_SHOW_MOST_VIEWED','10','2025-03-04 08:13:16','2025-03-04 08:13:16'),(338,NULL,NULL,'DASHPRODUCT_NBR_SHOW_TOP_SEARCH','10','2025-03-04 08:13:16','2025-03-04 08:13:16'),(339,NULL,NULL,'HOME_FEATURED_CAT','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(340,NULL,NULL,'PRODUCTPAYMENTLOGOS_IMG','payment-logo.png','2025-03-04 08:13:16','2025-03-04 08:13:16'),(341,NULL,NULL,'PRODUCTPAYMENTLOGOS_LINK',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(342,NULL,NULL,'PRODUCTPAYMENTLOGOS_TITLE',NULL,'2025-03-04 08:13:16','2025-03-04 08:13:16'),(343,NULL,NULL,'PS_TC_THEMES','a:9:{i:0;s:6:\"theme1\";i:1;s:6:\"theme2\";i:2;s:6:\"theme3\";i:3;s:6:\"theme4\";i:4;s:6:\"theme5\";i:5;s:6:\"theme6\";i:6;s:6:\"theme7\";i:7;s:6:\"theme8\";i:8;s:6:\"theme9\";}','2025-03-04 08:13:17','2025-03-04 08:13:17'),(344,NULL,NULL,'PS_TC_FONTS','a:10:{s:5:\"font1\";s:9:\"Open Sans\";s:5:\"font2\";s:12:\"Josefin Slab\";s:5:\"font3\";s:4:\"Arvo\";s:5:\"font4\";s:4:\"Lato\";s:5:\"font5\";s:7:\"Volkorn\";s:5:\"font6\";s:13:\"Abril Fatface\";s:5:\"font7\";s:6:\"Ubuntu\";s:5:\"font8\";s:7:\"PT Sans\";s:5:\"font9\";s:15:\"Old Standard TT\";s:6:\"font10\";s:10:\"Droid Sans\";}','2025-03-04 08:13:17','2025-03-04 08:13:17'),(345,NULL,NULL,'PS_TC_THEME',NULL,'2025-03-04 08:13:17','2025-03-04 08:13:17'),(346,NULL,NULL,'PS_TC_FONT',NULL,'2025-03-04 08:13:17','2025-03-04 08:13:17'),(347,NULL,NULL,'PS_TC_ACTIVE','1','2025-03-04 08:13:17','2025-03-04 08:13:17'),(348,NULL,NULL,'PS_SET_DISPLAY_SUBCATEGORIES','1','2025-03-04 08:13:17','2025-03-04 08:13:17'),(349,NULL,NULL,'GF_INSTALL_CALC','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(350,NULL,NULL,'GF_CURRENT_LEVEL','1','2025-03-04 08:13:33','2025-03-04 08:13:33'),(351,NULL,NULL,'GF_CURRENT_LEVEL_PERCENT','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(352,NULL,NULL,'GF_NOTIFICATION','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(353,NULL,NULL,'PS_ONBOARDING_CURRENT_STEP','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(354,NULL,NULL,'PS_ONBOARDING_LAST_VALIDATE_STEP','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(355,NULL,NULL,'PS_ONBOARDING_STEP_1_COMPLETED','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(356,NULL,NULL,'PS_ONBOARDING_STEP_2_COMPLETED','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(357,NULL,NULL,'PS_ONBOARDING_STEP_3_COMPLETED','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(358,NULL,NULL,'PS_ONBOARDING_STEP_4_COMPLETED','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(359,NULL,NULL,'CONF_PS_CHECKOUT_FIXED','0.2','2025-03-04 08:13:33','2025-03-04 08:13:33'),(360,NULL,NULL,'CONF_PS_CHECKOUT_VAR','2','2025-03-04 08:13:33','2025-03-04 08:13:33'),(361,NULL,NULL,'CONF_PS_CHECKOUT_FIXED_FOREIGN','0.2','2025-03-04 08:13:33','2025-03-04 08:13:33'),(362,NULL,NULL,'CONF_PS_CHECKOUT_VAR_FOREIGN','2','2025-03-04 08:13:33','2025-03-04 08:13:33'),(363,NULL,NULL,'PS_CHECKOUT_INTENT','CAPTURE','2025-03-04 08:13:33','2025-03-04 08:13:33'),(364,NULL,NULL,'PS_CHECKOUT_MODE','LIVE','2025-03-04 08:13:33','2025-03-04 08:13:33'),(365,NULL,NULL,'PS_CHECKOUT_PAYPAL_ID_MERCHANT',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(366,NULL,NULL,'PS_CHECKOUT_PAYPAL_EMAIL_MERCHANT',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(367,NULL,NULL,'PS_CHECKOUT_PAYPAL_EMAIL_STATUS',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(368,NULL,NULL,'PS_CHECKOUT_PAYPAL_PAYMENT_STATUS',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(369,NULL,NULL,'PS_CHECKOUT_CARD_PAYMENT_STATUS',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(370,NULL,NULL,'PS_CHECKOUT_CARD_PAYMENT_ENABLED','1','2025-03-04 08:13:33','2025-03-04 08:13:33'),(371,NULL,NULL,'PS_CHECKOUT_LOGGER_MAX_FILES','15','2025-03-04 08:13:33','2025-03-04 08:13:33'),(372,NULL,NULL,'PS_CHECKOUT_LOGGER_LEVEL','400','2025-03-04 08:13:33','2025-03-04 08:13:33'),(373,NULL,NULL,'PS_CHECKOUT_LOGGER_HTTP','0','2025-03-04 08:13:33','2025-03-04 08:13:33'),(374,NULL,NULL,'PS_CHECKOUT_LOGGER_HTTP_FORMAT','DEBUG','2025-03-04 08:13:33','2025-03-04 08:13:33'),(375,NULL,NULL,'PS_CHECKOUT_INTEGRATION_DATE','2022-14-06','2025-03-04 08:13:33','2025-03-04 08:13:33'),(376,NULL,NULL,'PS_CHECKOUT_WEBHOOK_SECRET',NULL,'2025-03-04 08:13:33','2025-03-04 08:13:33'),(377,NULL,NULL,'PS_CHECKOUT_LIABILITY_SHIFT_REQ','1','2025-03-04 08:13:33','2025-03-04 08:13:33'),(378,NULL,NULL,'PS_CHECKOUT_DISPLAY_LOGO_PRODUCT','1','2025-03-04 08:13:33','2025-03-04 08:13:33'),(379,NULL,NULL,'PS_CHECKOUT_DISPLAY_LOGO_CART','1','2025-03-04 08:13:33','2025-03-04 08:13:33'),(380,NULL,NULL,'PS_CHECKOUT_STATE_COMPLETED','2','2025-03-04 08:13:33','2025-03-04 08:13:33'),(381,NULL,NULL,'PS_CHECKOUT_STATE_CANCELED','6','2025-03-04 08:13:33','2025-03-04 08:13:33'),(382,NULL,NULL,'PS_CHECKOUT_STATE_ERROR','8','2025-03-04 08:13:33','2025-03-04 08:13:33'),(383,NULL,NULL,'PS_CHECKOUT_STATE_REFUNDED','7','2025-03-04 08:13:33','2025-03-04 08:13:33'),(384,NULL,NULL,'PS_CHECKOUT_STATE_PENDING','15','2025-03-04 08:13:33','2025-03-04 08:13:33'),(385,NULL,NULL,'PS_CHECKOUT_STATE_PARTIALLY_REFUNDED','16','2025-03-04 08:13:33','2025-03-04 08:13:33'),(386,NULL,NULL,'PS_CHECKOUT_STATE_PARTIALLY_PAID','17','2025-03-04 08:13:33','2025-03-04 08:13:33'),(387,NULL,NULL,'PS_CHECKOUT_STATE_AUTHORIZED','18','2025-03-04 08:13:33','2025-03-04 08:13:33'),(388,NULL,NULL,'PSX_UUID_V4','f07181f7-2399-406d-9226-4b6c14cf6068','2025-05-13 15:10:51','2025-05-13 15:10:51');
/*!40000 ALTER TABLE `ps_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_configuration_kpi`
--

DROP TABLE IF EXISTS `ps_configuration_kpi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_configuration_kpi` (
                                      `id_configuration_kpi` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                      `id_shop_group` int(11) unsigned DEFAULT NULL,
                                      `id_shop` int(11) unsigned DEFAULT NULL,
                                      `name` varchar(64) NOT NULL,
                                      `value` text DEFAULT NULL,
                                      `date_add` datetime NOT NULL,
                                      `date_upd` datetime NOT NULL,
                                      PRIMARY KEY (`id_configuration_kpi`),
                                      KEY `name` (`name`),
                                      KEY `id_shop` (`id_shop`),
                                      KEY `id_shop_group` (`id_shop_group`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_configuration_kpi`
--

LOCK TABLES `ps_configuration_kpi` WRITE;
/*!40000 ALTER TABLE `ps_configuration_kpi` DISABLE KEYS */;
INSERT INTO `ps_configuration_kpi` VALUES (1,NULL,NULL,'DASHGOALS_TRAFFIC_01_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(2,NULL,NULL,'DASHGOALS_CONVERSION_01_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(3,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_01_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(4,NULL,NULL,'DASHGOALS_TRAFFIC_02_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(5,NULL,NULL,'DASHGOALS_CONVERSION_02_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(6,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_02_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(7,NULL,NULL,'DASHGOALS_TRAFFIC_03_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(8,NULL,NULL,'DASHGOALS_CONVERSION_03_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(9,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_03_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(10,NULL,NULL,'DASHGOALS_TRAFFIC_04_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(11,NULL,NULL,'DASHGOALS_CONVERSION_04_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(12,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_04_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(13,NULL,NULL,'DASHGOALS_TRAFFIC_05_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(14,NULL,NULL,'DASHGOALS_CONVERSION_05_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(15,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_05_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(16,NULL,NULL,'DASHGOALS_TRAFFIC_06_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(17,NULL,NULL,'DASHGOALS_CONVERSION_06_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(18,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_06_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(19,NULL,NULL,'DASHGOALS_TRAFFIC_07_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(20,NULL,NULL,'DASHGOALS_CONVERSION_07_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(21,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_07_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(22,NULL,NULL,'DASHGOALS_TRAFFIC_08_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(23,NULL,NULL,'DASHGOALS_CONVERSION_08_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(24,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_08_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(25,NULL,NULL,'DASHGOALS_TRAFFIC_09_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(26,NULL,NULL,'DASHGOALS_CONVERSION_09_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(27,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_09_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(28,NULL,NULL,'DASHGOALS_TRAFFIC_10_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(29,NULL,NULL,'DASHGOALS_CONVERSION_10_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(30,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_10_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(31,NULL,NULL,'DASHGOALS_TRAFFIC_11_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(32,NULL,NULL,'DASHGOALS_CONVERSION_11_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(33,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_11_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16'),(34,NULL,NULL,'DASHGOALS_TRAFFIC_12_2025','600','2025-03-04 08:13:16','2025-03-04 08:13:16'),(35,NULL,NULL,'DASHGOALS_CONVERSION_12_2025','2','2025-03-04 08:13:16','2025-03-04 08:13:16'),(36,NULL,NULL,'DASHGOALS_AVG_CART_VALUE_12_2025','80','2025-03-04 08:13:16','2025-03-04 08:13:16');
/*!40000 ALTER TABLE `ps_configuration_kpi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_configuration_kpi_lang`
--

DROP TABLE IF EXISTS `ps_configuration_kpi_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_configuration_kpi_lang` (
                                           `id_configuration_kpi` int(10) unsigned NOT NULL,
                                           `id_lang` int(10) unsigned NOT NULL,
                                           `value` text DEFAULT NULL,
                                           `date_upd` datetime DEFAULT NULL,
                                           PRIMARY KEY (`id_configuration_kpi`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_configuration_kpi_lang`
--

LOCK TABLES `ps_configuration_kpi_lang` WRITE;
/*!40000 ALTER TABLE `ps_configuration_kpi_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_configuration_kpi_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_configuration_lang`
--

DROP TABLE IF EXISTS `ps_configuration_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_configuration_lang` (
                                       `id_configuration` int(10) unsigned NOT NULL,
                                       `id_lang` int(10) unsigned NOT NULL,
                                       `value` text DEFAULT NULL,
                                       `date_upd` datetime DEFAULT NULL,
                                       PRIMARY KEY (`id_configuration`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_configuration_lang`
--

LOCK TABLES `ps_configuration_lang` WRITE;
/*!40000 ALTER TABLE `ps_configuration_lang` DISABLE KEYS */;
INSERT INTO `ps_configuration_lang` VALUES (41,1,'#IN',NULL),(44,1,'#DE',NULL),(46,1,'#RE',NULL),(52,1,'a|about|above|after|again|against|all|am|an|and|any|are|aren|as|at|be|because|been|before|being|below|between|both|but|by|can|cannot|could|couldn|did|didn|do|does|doesn|doing|don|down|during|each|few|for|from|further|had|hadn|has|hasn|have|haven|having|he|ll|her|here|hers|herself|him|himself|his|how|ve|if|in|into|is|isn|it|its|itself|let|me|more|most|mustn|my|myself|no|nor|not|of|off|on|once|only|or|other|ought|our|ours|ourselves|out|over|own|same|shan|she|should|shouldn|so|some|such|than|that|the|their|theirs|them|themselves|then|there|these|they|re|this|those|through|to|too|under|until|up|very|was|wasn|we|were|weren|what|when|where|which|while|who|whom|why|with|won|would|wouldn|you|your|yours|yourself|yourselves',NULL),(74,1,'0',NULL),(80,1,'Dear Customer,\r\n\r\nRegards,\r\nCustomer service',NULL),(289,1,'sale70.png','2025-03-04 08:13:16'),(290,1,'','2025-03-04 08:13:16'),(291,1,'','2025-03-04 08:13:16');
/*!40000 ALTER TABLE `ps_configuration_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_connections`
--

DROP TABLE IF EXISTS `ps_connections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_connections` (
                                `id_connections` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `id_shop_group` int(11) unsigned NOT NULL DEFAULT 1,
                                `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                `id_guest` int(10) unsigned NOT NULL,
                                `id_page` int(10) unsigned NOT NULL,
                                `ip_address` bigint(20) DEFAULT NULL,
                                `date_add` datetime NOT NULL,
                                `http_referer` varchar(255) DEFAULT NULL,
                                PRIMARY KEY (`id_connections`),
                                KEY `id_guest` (`id_guest`),
                                KEY `date_add` (`date_add`),
                                KEY `id_page` (`id_page`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_connections`
--

LOCK TABLES `ps_connections` WRITE;
/*!40000 ALTER TABLE `ps_connections` DISABLE KEYS */;
INSERT INTO `ps_connections` VALUES (1,1,1,1,1,2130706433,'2025-03-04 08:13:15','https://www.prestashop.com');
/*!40000 ALTER TABLE `ps_connections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_connections_page`
--

DROP TABLE IF EXISTS `ps_connections_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_connections_page` (
                                     `id_connections` int(10) unsigned NOT NULL,
                                     `id_page` int(10) unsigned NOT NULL,
                                     `time_start` datetime NOT NULL,
                                     `time_end` datetime DEFAULT NULL,
                                     PRIMARY KEY (`id_connections`,`id_page`,`time_start`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_connections_page`
--

LOCK TABLES `ps_connections_page` WRITE;
/*!40000 ALTER TABLE `ps_connections_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_connections_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_connections_source`
--

DROP TABLE IF EXISTS `ps_connections_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_connections_source` (
                                       `id_connections_source` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                       `id_connections` int(10) unsigned NOT NULL,
                                       `http_referer` varchar(255) DEFAULT NULL,
                                       `request_uri` varchar(255) DEFAULT NULL,
                                       `keywords` varchar(255) DEFAULT NULL,
                                       `date_add` datetime NOT NULL,
                                       PRIMARY KEY (`id_connections_source`),
                                       KEY `connections` (`id_connections`),
                                       KEY `orderby` (`date_add`),
                                       KEY `http_referer` (`http_referer`),
                                       KEY `request_uri` (`request_uri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_connections_source`
--

LOCK TABLES `ps_connections_source` WRITE;
/*!40000 ALTER TABLE `ps_connections_source` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_connections_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_contact`
--

DROP TABLE IF EXISTS `ps_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_contact` (
                            `id_contact` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `email` varchar(128) NOT NULL,
                            `customer_service` tinyint(1) NOT NULL DEFAULT 0,
                            `position` tinyint(2) unsigned NOT NULL DEFAULT 0,
                            PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_contact`
--

LOCK TABLES `ps_contact` WRITE;
/*!40000 ALTER TABLE `ps_contact` DISABLE KEYS */;
INSERT INTO `ps_contact` VALUES (1,'admin@prestashop.com',1,0),(2,'admin@prestashop.com',1,0);
/*!40000 ALTER TABLE `ps_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_contact_lang`
--

DROP TABLE IF EXISTS `ps_contact_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_contact_lang` (
                                 `id_contact` int(10) unsigned NOT NULL,
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `name` varchar(32) NOT NULL,
                                 `description` text DEFAULT NULL,
                                 PRIMARY KEY (`id_contact`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_contact_lang`
--

LOCK TABLES `ps_contact_lang` WRITE;
/*!40000 ALTER TABLE `ps_contact_lang` DISABLE KEYS */;
INSERT INTO `ps_contact_lang` VALUES (1,1,'Webmaster','If a technical problem occurs on this website'),(2,1,'Customer service','For any question about a product, an order');
/*!40000 ALTER TABLE `ps_contact_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_contact_shop`
--

DROP TABLE IF EXISTS `ps_contact_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_contact_shop` (
                                 `id_contact` int(11) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 PRIMARY KEY (`id_contact`,`id_shop`),
                                 KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_contact_shop`
--

LOCK TABLES `ps_contact_shop` WRITE;
/*!40000 ALTER TABLE `ps_contact_shop` DISABLE KEYS */;
INSERT INTO `ps_contact_shop` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `ps_contact_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_country`
--

DROP TABLE IF EXISTS `ps_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_country` (
                            `id_country` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_zone` int(10) unsigned NOT NULL,
                            `id_currency` int(10) unsigned NOT NULL DEFAULT 0,
                            `iso_code` varchar(3) NOT NULL,
                            `call_prefix` int(10) NOT NULL DEFAULT 0,
                            `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `contains_states` tinyint(1) NOT NULL DEFAULT 0,
                            `need_identification_number` tinyint(1) NOT NULL DEFAULT 0,
                            `need_zip_code` tinyint(1) NOT NULL DEFAULT 1,
                            `zip_code_format` varchar(12) NOT NULL DEFAULT '',
                            `display_tax_label` tinyint(1) NOT NULL,
                            PRIMARY KEY (`id_country`),
                            KEY `country_iso_code` (`iso_code`),
                            KEY `country_` (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_country`
--

LOCK TABLES `ps_country` WRITE;
/*!40000 ALTER TABLE `ps_country` DISABLE KEYS */;
INSERT INTO `ps_country` VALUES (1,1,0,'DE',49,0,0,0,1,'NNNNN',1),(2,1,0,'AT',43,0,0,0,1,'NNNN',1),(3,1,0,'BE',32,0,0,0,1,'NNNN',1),(4,2,0,'CA',1,0,1,0,1,'LNL NLN',0),(5,3,0,'CN',86,0,0,0,1,'NNNNNN',1),(6,1,0,'ES',34,0,0,1,1,'NNNNN',1),(7,1,0,'FI',358,0,0,0,1,'NNNNN',1),(8,1,0,'FR',33,0,0,0,1,'NNNNN',1),(9,1,0,'GR',30,0,0,0,1,'NNNNN',1),(10,1,0,'IT',39,0,1,0,1,'NNNNN',1),(11,3,0,'JP',81,0,1,0,1,'NNN-NNNN',1),(12,1,0,'LU',352,0,0,0,1,'NNNN',1),(13,1,0,'NL',31,0,0,0,1,'NNNN LL',1),(14,1,0,'PL',48,0,0,0,1,'NN-NNN',1),(15,1,0,'PT',351,0,0,0,1,'NNNN-NNN',1),(16,1,0,'CZ',420,0,0,0,1,'NNN NN',1),(17,1,0,'GB',44,1,0,0,1,'',1),(18,1,0,'SE',46,0,0,0,1,'NNN NN',1),(19,7,0,'CH',41,0,0,0,1,'NNNN',1),(20,1,0,'DK',45,0,0,0,1,'NNNN',1),(21,2,0,'US',1,0,1,0,1,'NNNNN',0),(22,3,0,'HK',852,0,0,0,0,'',1),(23,7,0,'NO',47,0,0,0,1,'NNNN',1),(24,5,0,'AU',61,0,0,0,1,'NNNN',1),(25,3,0,'SG',65,0,0,0,1,'NNNNNN',1),(26,1,0,'IE',353,0,0,0,0,'',1),(27,5,0,'NZ',64,0,0,0,1,'NNNN',1),(28,3,0,'KR',82,0,0,0,1,'NNNNN',1),(29,3,0,'IL',972,0,0,0,1,'NNNNNNN',1),(30,4,0,'ZA',27,0,0,0,1,'NNNN',1),(31,4,0,'NG',234,0,0,0,1,'',1),(32,4,0,'CI',225,0,0,0,1,'',1),(33,4,0,'TG',228,0,0,0,1,'',1),(34,6,0,'BO',591,0,0,0,1,'',1),(35,4,0,'MU',230,0,0,0,1,'',1),(36,1,0,'RO',40,0,0,0,1,'NNNNNN',1),(37,1,0,'SK',421,0,0,0,1,'NNN NN',1),(38,4,0,'DZ',213,0,0,0,1,'NNNNN',1),(39,2,0,'AS',0,0,0,0,1,'',1),(40,7,0,'AD',376,0,0,0,1,'CNNN',1),(41,4,0,'AO',244,0,0,0,0,'',1),(42,8,0,'AI',0,0,0,0,1,'',1),(43,2,0,'AG',0,0,0,0,1,'',1),(44,6,0,'AR',54,0,1,0,1,'LNNNNLLL',1),(45,3,0,'AM',374,0,0,0,1,'NNNN',1),(46,8,0,'AW',297,0,0,0,1,'',1),(47,3,0,'AZ',994,0,0,0,1,'CNNNN',1),(48,2,0,'BS',0,0,0,0,1,'',1),(49,3,0,'BH',973,0,0,0,1,'',1),(50,3,0,'BD',880,0,0,0,1,'NNNN',1),(51,2,0,'BB',0,0,0,0,1,'CNNNNN',1),(52,7,0,'BY',0,0,0,0,1,'NNNNNN',1),(53,8,0,'BZ',501,0,0,0,0,'',1),(54,4,0,'BJ',229,0,0,0,0,'',1),(55,2,0,'BM',0,0,0,0,1,'',1),(56,3,0,'BT',975,0,0,0,1,'',1),(57,4,0,'BW',267,0,0,0,1,'',1),(58,6,0,'BR',55,0,0,0,1,'NNNNN-NNN',1),(59,3,0,'BN',673,0,0,0,1,'LLNNNN',1),(60,4,0,'BF',226,0,0,0,1,'',1),(61,3,0,'MM',95,0,0,0,1,'',1),(62,4,0,'BI',257,0,0,0,1,'',1),(63,3,0,'KH',855,0,0,0,1,'NNNNN',1),(64,4,0,'CM',237,0,0,0,1,'',1),(65,4,0,'CV',238,0,0,0,1,'NNNN',1),(66,4,0,'CF',236,0,0,0,1,'',1),(67,4,0,'TD',235,0,0,0,1,'',1),(68,6,0,'CL',56,0,0,0,1,'NNN-NNNN',1),(69,6,0,'CO',57,0,0,0,1,'NNNNNN',1),(70,4,0,'KM',269,0,0,0,1,'',1),(71,4,0,'CD',242,0,0,0,1,'',1),(72,4,0,'CG',243,0,0,0,1,'',1),(73,8,0,'CR',506,0,0,0,1,'NNNNN',1),(74,7,0,'HR',385,0,0,0,1,'NNNNN',1),(75,8,0,'CU',53,0,0,0,1,'',1),(76,1,0,'CY',357,0,0,0,1,'NNNN',1),(77,4,0,'DJ',253,0,0,0,1,'',1),(78,8,0,'DM',0,0,0,0,1,'',1),(79,8,0,'DO',0,0,0,0,1,'',1),(80,3,0,'TL',670,0,0,0,1,'',1),(81,6,0,'EC',593,0,0,0,1,'CNNNNNN',1),(82,4,0,'EG',20,0,0,0,1,'NNNNN',1),(83,8,0,'SV',503,0,0,0,1,'',1),(84,4,0,'GQ',240,0,0,0,1,'',1),(85,4,0,'ER',291,0,0,0,1,'',1),(86,1,0,'EE',372,0,0,0,1,'NNNNN',1),(87,4,0,'ET',251,0,0,0,1,'',1),(88,8,0,'FK',0,0,0,0,1,'LLLL NLL',1),(89,7,0,'FO',298,0,0,0,1,'',1),(90,5,0,'FJ',679,0,0,0,1,'',1),(91,4,0,'GA',241,0,0,0,1,'',1),(92,4,0,'GM',220,0,0,0,1,'',1),(93,3,0,'GE',995,0,0,0,1,'NNNN',1),(94,4,0,'GH',233,0,0,0,1,'',1),(95,8,0,'GD',0,0,0,0,1,'',1),(96,7,0,'GL',299,0,0,0,1,'',1),(97,7,0,'GI',350,0,0,0,1,'',1),(98,8,0,'GP',590,0,0,0,1,'',1),(99,5,0,'GU',0,0,0,0,1,'',1),(100,8,0,'GT',502,0,0,0,1,'',1),(101,7,0,'GG',0,0,0,0,1,'LLN NLL',1),(102,4,0,'GN',224,0,0,0,1,'',1),(103,4,0,'GW',245,0,0,0,1,'',1),(104,6,0,'GY',592,0,0,0,1,'',1),(105,8,0,'HT',509,0,0,0,1,'',1),(106,5,0,'HM',0,0,0,0,1,'',1),(107,7,0,'VA',379,0,0,0,1,'NNNNN',1),(108,8,0,'HN',504,0,0,0,1,'',1),(109,7,0,'IS',354,0,0,0,1,'NNN',1),(110,3,0,'IN',91,0,0,0,1,'NNN NNN',1),(111,3,0,'ID',62,0,1,0,1,'NNNNN',1),(112,3,0,'IR',98,0,0,0,1,'NNNNN-NNNNN',1),(113,3,0,'IQ',964,0,0,0,1,'NNNNN',1),(114,7,0,'IM',0,0,0,0,1,'CN NLL',1),(115,8,0,'JM',0,0,0,0,1,'',1),(116,7,0,'JE',0,0,0,0,1,'CN NLL',1),(117,3,0,'JO',962,0,0,0,1,'',1),(118,3,0,'KZ',7,0,0,0,1,'NNNNNN',1),(119,4,0,'KE',254,0,0,0,1,'',1),(120,5,0,'KI',686,0,0,0,1,'',1),(121,3,0,'KP',850,0,0,0,1,'',1),(122,3,0,'KW',965,0,0,0,1,'',1),(123,3,0,'KG',996,0,0,0,1,'',1),(124,3,0,'LA',856,0,0,0,1,'',1),(125,1,0,'LV',371,0,0,0,1,'C-NNNN',1),(126,3,0,'LB',961,0,0,0,1,'',1),(127,4,0,'LS',266,0,0,0,1,'',1),(128,4,0,'LR',231,0,0,0,1,'',1),(129,4,0,'LY',218,0,0,0,1,'',1),(130,1,0,'LI',423,0,0,0,1,'NNNN',1),(131,1,0,'LT',370,0,0,0,1,'NNNNN',1),(132,3,0,'MO',853,0,0,0,0,'',1),(133,7,0,'MK',389,0,0,0,1,'',1),(134,4,0,'MG',261,0,0,0,1,'',1),(135,4,0,'MW',265,0,0,0,1,'',1),(136,3,0,'MY',60,0,0,0,1,'NNNNN',1),(137,3,0,'MV',960,0,0,0,1,'',1),(138,4,0,'ML',223,0,0,0,1,'',1),(139,1,0,'MT',356,0,0,0,1,'LLL NNNN',1),(140,5,0,'MH',692,0,0,0,1,'',1),(141,8,0,'MQ',596,0,0,0,1,'',1),(142,4,0,'MR',222,0,0,0,1,'',1),(143,1,0,'HU',36,0,0,0,1,'NNNN',1),(144,4,0,'YT',262,0,0,0,1,'',1),(145,2,0,'MX',52,0,1,1,1,'NNNNN',1),(146,5,0,'FM',691,0,0,0,1,'',1),(147,7,0,'MD',373,0,0,0,1,'C-NNNN',1),(148,7,0,'MC',377,0,0,0,1,'980NN',1),(149,3,0,'MN',976,0,0,0,1,'',1),(150,7,0,'ME',382,0,0,0,1,'NNNNN',1),(151,8,0,'MS',0,0,0,0,1,'',1),(152,4,0,'MA',212,0,0,0,1,'NNNNN',1),(153,4,0,'MZ',258,0,0,0,1,'',1),(154,4,0,'NA',264,0,0,0,1,'',1),(155,5,0,'NR',674,0,0,0,1,'',1),(156,3,0,'NP',977,0,0,0,1,'',1),(157,8,0,'AN',599,0,0,0,1,'',1),(158,5,0,'NC',687,0,0,0,1,'',1),(159,8,0,'NI',505,0,0,0,1,'NNNNNN',1),(160,4,0,'NE',227,0,0,0,1,'',1),(161,5,0,'NU',683,0,0,0,1,'',1),(162,5,0,'NF',0,0,0,0,1,'',1),(163,5,0,'MP',0,0,0,0,1,'',1),(164,3,0,'OM',968,0,0,0,1,'',1),(165,3,0,'PK',92,0,0,0,1,'',1),(166,5,0,'PW',680,0,0,0,1,'',1),(167,3,0,'PS',0,0,0,0,1,'',1),(168,8,0,'PA',507,0,0,0,1,'NNNNNN',1),(169,5,0,'PG',675,0,0,0,1,'',1),(170,6,0,'PY',595,0,0,0,1,'',1),(171,6,0,'PE',51,0,0,0,1,'',1),(172,3,0,'PH',63,0,0,0,1,'NNNN',1),(173,5,0,'PN',0,0,0,0,1,'LLLL NLL',1),(174,8,0,'PR',0,0,0,0,1,'NNNNN',1),(175,3,0,'QA',974,0,0,0,1,'',1),(176,4,0,'RE',262,0,0,0,1,'',1),(177,7,0,'RU',7,0,0,0,1,'NNNNNN',1),(178,4,0,'RW',250,0,0,0,1,'',1),(179,8,0,'BL',0,0,0,0,1,'',1),(180,8,0,'KN',0,0,0,0,1,'',1),(181,8,0,'LC',0,0,0,0,1,'',1),(182,8,0,'MF',0,0,0,0,1,'',1),(183,8,0,'PM',508,0,0,0,1,'',1),(184,8,0,'VC',0,0,0,0,1,'',1),(185,5,0,'WS',685,0,0,0,1,'',1),(186,7,0,'SM',378,0,0,0,1,'NNNNN',1),(187,4,0,'ST',239,0,0,0,1,'',1),(188,3,0,'SA',966,0,0,0,1,'',1),(189,4,0,'SN',221,0,0,0,1,'',1),(190,7,0,'RS',381,0,0,0,1,'NNNNN',1),(191,4,0,'SC',248,0,0,0,1,'',1),(192,4,0,'SL',232,0,0,0,1,'',1),(193,1,0,'SI',386,0,0,0,1,'C-NNNN',1),(194,5,0,'SB',677,0,0,0,1,'',1),(195,4,0,'SO',252,0,0,0,1,'',1),(196,8,0,'GS',0,0,0,0,1,'LLLL NLL',1),(197,3,0,'LK',94,0,0,0,1,'NNNNN',1),(198,4,0,'SD',249,0,0,0,1,'',1),(199,8,0,'SR',597,0,0,0,1,'',1),(200,7,0,'SJ',0,0,0,0,1,'',1),(201,4,0,'SZ',268,0,0,0,1,'',1),(202,3,0,'SY',963,0,0,0,1,'',1),(203,3,0,'TW',886,0,0,0,1,'NNNNN',1),(204,3,0,'TJ',992,0,0,0,1,'',1),(205,4,0,'TZ',255,0,0,0,1,'',1),(206,3,0,'TH',66,0,0,0,1,'NNNNN',1),(207,5,0,'TK',690,0,0,0,1,'',1),(208,5,0,'TO',676,0,0,0,1,'',1),(209,6,0,'TT',0,0,0,0,1,'',1),(210,4,0,'TN',216,0,0,0,1,'',1),(211,7,0,'TR',90,0,0,0,1,'NNNNN',1),(212,3,0,'TM',993,0,0,0,1,'',1),(213,8,0,'TC',0,0,0,0,1,'LLLL NLL',1),(214,5,0,'TV',688,0,0,0,1,'',1),(215,4,0,'UG',256,0,0,0,1,'',1),(216,1,0,'UA',380,0,0,0,1,'NNNNN',1),(217,3,0,'AE',971,0,0,0,1,'',1),(218,6,0,'UY',598,0,0,0,1,'',1),(219,3,0,'UZ',998,0,0,0,1,'',1),(220,5,0,'VU',678,0,0,0,1,'',1),(221,6,0,'VE',58,0,0,0,1,'',1),(222,3,0,'VN',84,0,0,0,1,'NNNNNN',1),(223,2,0,'VG',0,0,0,0,1,'CNNNN',1),(224,2,0,'VI',0,0,0,0,1,'',1),(225,5,0,'WF',681,0,0,0,1,'',1),(226,4,0,'EH',0,0,0,0,1,'',1),(227,3,0,'YE',967,0,0,0,1,'',1),(228,4,0,'ZM',260,0,0,0,1,'',1),(229,4,0,'ZW',263,0,0,0,1,'',1),(230,7,0,'AL',355,0,0,0,1,'NNNN',1),(231,3,0,'AF',93,0,0,0,1,'NNNN',1),(232,5,0,'AQ',0,0,0,0,1,'',1),(233,1,0,'BA',387,0,0,0,1,'',1),(234,5,0,'BV',0,0,0,0,1,'',1),(235,5,0,'IO',0,0,0,0,1,'LLLL NLL',1),(236,1,0,'BG',359,0,0,0,1,'NNNN',1),(237,8,0,'KY',0,0,0,0,1,'',1),(238,3,0,'CX',0,0,0,0,1,'',1),(239,3,0,'CC',0,0,0,0,1,'',1),(240,5,0,'CK',682,0,0,0,1,'',1),(241,6,0,'GF',594,0,0,0,1,'',1),(242,5,0,'PF',689,0,0,0,1,'',1),(243,5,0,'TF',0,0,0,0,1,'',1),(244,7,0,'AX',0,0,0,0,1,'NNNNN',1);
/*!40000 ALTER TABLE `ps_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_country_lang`
--

DROP TABLE IF EXISTS `ps_country_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_country_lang` (
                                 `id_country` int(10) unsigned NOT NULL,
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `name` varchar(64) NOT NULL,
                                 PRIMARY KEY (`id_country`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_country_lang`
--

LOCK TABLES `ps_country_lang` WRITE;
/*!40000 ALTER TABLE `ps_country_lang` DISABLE KEYS */;
INSERT INTO `ps_country_lang` VALUES (1,1,'Germany'),(2,1,'Austria'),(3,1,'Belgium'),(4,1,'Canada'),(5,1,'China'),(6,1,'Spain'),(7,1,'Finland'),(8,1,'France'),(9,1,'Greece'),(10,1,'Italy'),(11,1,'Japan'),(12,1,'Luxemburg'),(13,1,'Netherlands'),(14,1,'Poland'),(15,1,'Portugal'),(16,1,'Czech Republic'),(17,1,'United Kingdom'),(18,1,'Sweden'),(19,1,'Switzerland'),(20,1,'Denmark'),(21,1,'United States'),(22,1,'HongKong'),(23,1,'Norway'),(24,1,'Australia'),(25,1,'Singapore'),(26,1,'Ireland'),(27,1,'New Zealand'),(28,1,'South Korea'),(29,1,'Israel'),(30,1,'South Africa'),(31,1,'Nigeria'),(32,1,'Ivory Coast'),(33,1,'Togo'),(34,1,'Bolivia'),(35,1,'Mauritius'),(36,1,'Romania'),(37,1,'Slovakia'),(38,1,'Algeria'),(39,1,'American Samoa'),(40,1,'Andorra'),(41,1,'Angola'),(42,1,'Anguilla'),(43,1,'Antigua and Barbuda'),(44,1,'Argentina'),(45,1,'Armenia'),(46,1,'Aruba'),(47,1,'Azerbaijan'),(48,1,'Bahamas'),(49,1,'Bahrain'),(50,1,'Bangladesh'),(51,1,'Barbados'),(52,1,'Belarus'),(53,1,'Belize'),(54,1,'Benin'),(55,1,'Bermuda'),(56,1,'Bhutan'),(57,1,'Botswana'),(58,1,'Brazil'),(59,1,'Brunei'),(60,1,'Burkina Faso'),(61,1,'Burma (Myanmar)'),(62,1,'Burundi'),(63,1,'Cambodia'),(64,1,'Cameroon'),(65,1,'Cape Verde'),(66,1,'Central African Republic'),(67,1,'Chad'),(68,1,'Chile'),(69,1,'Colombia'),(70,1,'Comoros'),(71,1,'Congo, Dem. Republic'),(72,1,'Congo, Republic'),(73,1,'Costa Rica'),(74,1,'Croatia'),(75,1,'Cuba'),(76,1,'Cyprus'),(77,1,'Djibouti'),(78,1,'Dominica'),(79,1,'Dominican Republic'),(80,1,'East Timor'),(81,1,'Ecuador'),(82,1,'Egypt'),(83,1,'El Salvador'),(84,1,'Equatorial Guinea'),(85,1,'Eritrea'),(86,1,'Estonia'),(87,1,'Ethiopia'),(88,1,'Falkland Islands'),(89,1,'Faroe Islands'),(90,1,'Fiji'),(91,1,'Gabon'),(92,1,'Gambia'),(93,1,'Georgia'),(94,1,'Ghana'),(95,1,'Grenada'),(96,1,'Greenland'),(97,1,'Gibraltar'),(98,1,'Guadeloupe'),(99,1,'Guam'),(100,1,'Guatemala'),(101,1,'Guernsey'),(102,1,'Guinea'),(103,1,'Guinea-Bissau'),(104,1,'Guyana'),(105,1,'Haiti'),(106,1,'Heard Island and McDonald Islands'),(107,1,'Vatican City State'),(108,1,'Honduras'),(109,1,'Iceland'),(110,1,'India'),(111,1,'Indonesia'),(112,1,'Iran'),(113,1,'Iraq'),(114,1,'Man Island'),(115,1,'Jamaica'),(116,1,'Jersey'),(117,1,'Jordan'),(118,1,'Kazakhstan'),(119,1,'Kenya'),(120,1,'Kiribati'),(121,1,'Korea, Dem. Republic of'),(122,1,'Kuwait'),(123,1,'Kyrgyzstan'),(124,1,'Laos'),(125,1,'Latvia'),(126,1,'Lebanon'),(127,1,'Lesotho'),(128,1,'Liberia'),(129,1,'Libya'),(130,1,'Liechtenstein'),(131,1,'Lithuania'),(132,1,'Macau'),(133,1,'Macedonia'),(134,1,'Madagascar'),(135,1,'Malawi'),(136,1,'Malaysia'),(137,1,'Maldives'),(138,1,'Mali'),(139,1,'Malta'),(140,1,'Marshall Islands'),(141,1,'Martinique'),(142,1,'Mauritania'),(143,1,'Hungary'),(144,1,'Mayotte'),(145,1,'Mexico'),(146,1,'Micronesia'),(147,1,'Moldova'),(148,1,'Monaco'),(149,1,'Mongolia'),(150,1,'Montenegro'),(151,1,'Montserrat'),(152,1,'Morocco'),(153,1,'Mozambique'),(154,1,'Namibia'),(155,1,'Nauru'),(156,1,'Nepal'),(157,1,'Netherlands Antilles'),(158,1,'New Caledonia'),(159,1,'Nicaragua'),(160,1,'Niger'),(161,1,'Niue'),(162,1,'Norfolk Island'),(163,1,'Northern Mariana Islands'),(164,1,'Oman'),(165,1,'Pakistan'),(166,1,'Palau'),(167,1,'Palestinian Territories'),(168,1,'Panama'),(169,1,'Papua New Guinea'),(170,1,'Paraguay'),(171,1,'Peru'),(172,1,'Philippines'),(173,1,'Pitcairn'),(174,1,'Puerto Rico'),(175,1,'Qatar'),(176,1,'Reunion Island'),(177,1,'Russian Federation'),(178,1,'Rwanda'),(179,1,'Saint Barthelemy'),(180,1,'Saint Kitts and Nevis'),(181,1,'Saint Lucia'),(182,1,'Saint Martin'),(183,1,'Saint Pierre and Miquelon'),(184,1,'Saint Vincent and the Grenadines'),(185,1,'Samoa'),(186,1,'San Marino'),(187,1,'São Tomé and Príncipe'),(188,1,'Saudi Arabia'),(189,1,'Senegal'),(190,1,'Serbia'),(191,1,'Seychelles'),(192,1,'Sierra Leone'),(193,1,'Slovenia'),(194,1,'Solomon Islands'),(195,1,'Somalia'),(196,1,'South Georgia and the South Sandwich Islands'),(197,1,'Sri Lanka'),(198,1,'Sudan'),(199,1,'Suriname'),(200,1,'Svalbard and Jan Mayen'),(201,1,'Swaziland'),(202,1,'Syria'),(203,1,'Taiwan'),(204,1,'Tajikistan'),(205,1,'Tanzania'),(206,1,'Thailand'),(207,1,'Tokelau'),(208,1,'Tonga'),(209,1,'Trinidad and Tobago'),(210,1,'Tunisia'),(211,1,'Turkey'),(212,1,'Turkmenistan'),(213,1,'Turks and Caicos Islands'),(214,1,'Tuvalu'),(215,1,'Uganda'),(216,1,'Ukraine'),(217,1,'United Arab Emirates'),(218,1,'Uruguay'),(219,1,'Uzbekistan'),(220,1,'Vanuatu'),(221,1,'Venezuela'),(222,1,'Vietnam'),(223,1,'Virgin Islands (British)'),(224,1,'Virgin Islands (U.S.)'),(225,1,'Wallis and Futuna'),(226,1,'Western Sahara'),(227,1,'Yemen'),(228,1,'Zambia'),(229,1,'Zimbabwe'),(230,1,'Albania'),(231,1,'Afghanistan'),(232,1,'Antarctica'),(233,1,'Bosnia and Herzegovina'),(234,1,'Bouvet Island'),(235,1,'British Indian Ocean Territory'),(236,1,'Bulgaria'),(237,1,'Cayman Islands'),(238,1,'Christmas Island'),(239,1,'Cocos (Keeling) Islands'),(240,1,'Cook Islands'),(241,1,'French Guiana'),(242,1,'French Polynesia'),(243,1,'French Southern Territories'),(244,1,'Åland Islands');
/*!40000 ALTER TABLE `ps_country_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_country_shop`
--

DROP TABLE IF EXISTS `ps_country_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_country_shop` (
                                 `id_country` int(11) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 PRIMARY KEY (`id_country`,`id_shop`),
                                 KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_country_shop`
--

LOCK TABLES `ps_country_shop` WRITE;
/*!40000 ALTER TABLE `ps_country_shop` DISABLE KEYS */;
INSERT INTO `ps_country_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(164,1),(165,1),(166,1),(167,1),(168,1),(169,1),(170,1),(171,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1),(181,1),(182,1),(183,1),(184,1),(185,1),(186,1),(187,1),(188,1),(189,1),(190,1),(191,1),(192,1),(193,1),(194,1),(195,1),(196,1),(197,1),(198,1),(199,1),(200,1),(201,1),(202,1),(203,1),(204,1),(205,1),(206,1),(207,1),(208,1),(209,1),(210,1),(211,1),(212,1),(213,1),(214,1),(215,1),(216,1),(217,1),(218,1),(219,1),(220,1),(221,1),(222,1),(223,1),(224,1),(225,1),(226,1),(227,1),(228,1),(229,1),(230,1),(231,1),(232,1),(233,1),(234,1),(235,1),(236,1),(237,1),(238,1),(239,1),(240,1),(241,1),(242,1),(243,1),(244,1);
/*!40000 ALTER TABLE `ps_country_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_currency`
--

DROP TABLE IF EXISTS `ps_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_currency` (
                             `id_currency` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(32) NOT NULL,
                             `iso_code` varchar(3) NOT NULL DEFAULT '0',
                             `iso_code_num` varchar(3) NOT NULL DEFAULT '0',
                             `sign` varchar(8) NOT NULL,
                             `blank` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `format` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `decimals` tinyint(1) unsigned NOT NULL DEFAULT 1,
                             `conversion_rate` decimal(13,6) NOT NULL,
                             `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
                             PRIMARY KEY (`id_currency`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_currency`
--

LOCK TABLES `ps_currency` WRITE;
/*!40000 ALTER TABLE `ps_currency` DISABLE KEYS */;
INSERT INTO `ps_currency` VALUES (1,'Euro','EUR','978','€',1,2,1,1.000000,0,1),(2,'Dollar','USD','840','$',0,1,1,1.047735,0,1);
/*!40000 ALTER TABLE `ps_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_currency_shop`
--

DROP TABLE IF EXISTS `ps_currency_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_currency_shop` (
                                  `id_currency` int(11) unsigned NOT NULL,
                                  `id_shop` int(11) unsigned NOT NULL,
                                  `conversion_rate` decimal(13,6) NOT NULL,
                                  PRIMARY KEY (`id_currency`,`id_shop`),
                                  KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_currency_shop`
--

LOCK TABLES `ps_currency_shop` WRITE;
/*!40000 ALTER TABLE `ps_currency_shop` DISABLE KEYS */;
INSERT INTO `ps_currency_shop` VALUES (1,1,1.000000),(2,1,1.047735);
/*!40000 ALTER TABLE `ps_currency_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customer`
--

DROP TABLE IF EXISTS `ps_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customer` (
                             `id_customer` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `id_shop_group` int(11) unsigned NOT NULL DEFAULT 1,
                             `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                             `id_gender` int(10) unsigned NOT NULL,
                             `id_default_group` int(10) unsigned NOT NULL DEFAULT 1,
                             `id_lang` int(10) unsigned DEFAULT NULL,
                             `id_risk` int(10) unsigned NOT NULL DEFAULT 1,
                             `company` varchar(64) DEFAULT NULL,
                             `siret` varchar(14) DEFAULT NULL,
                             `ape` varchar(5) DEFAULT NULL,
                             `firstname` varchar(32) NOT NULL,
                             `lastname` varchar(32) NOT NULL,
                             `email` varchar(128) NOT NULL,
                             `passwd` varchar(32) NOT NULL,
                             `last_passwd_gen` timestamp NOT NULL DEFAULT current_timestamp(),
                             `birthday` date DEFAULT NULL,
                             `newsletter` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `ip_registration_newsletter` varchar(15) DEFAULT NULL,
                             `newsletter_date_add` datetime DEFAULT NULL,
                             `optin` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `website` varchar(128) DEFAULT NULL,
                             `outstanding_allow_amount` decimal(20,6) NOT NULL DEFAULT 0.000000,
                             `show_public_prices` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `max_payment_days` int(10) unsigned NOT NULL DEFAULT 60,
                             `secure_key` varchar(32) NOT NULL DEFAULT '-1',
                             `note` text DEFAULT NULL,
                             `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `is_guest` tinyint(1) NOT NULL DEFAULT 0,
                             `deleted` tinyint(1) NOT NULL DEFAULT 0,
                             `date_add` datetime NOT NULL,
                             `date_upd` datetime NOT NULL,
                             PRIMARY KEY (`id_customer`),
                             KEY `customer_email` (`email`),
                             KEY `customer_login` (`email`,`passwd`),
                             KEY `id_customer_passwd` (`id_customer`,`passwd`),
                             KEY `id_gender` (`id_gender`),
                             KEY `id_shop_group` (`id_shop_group`),
                             KEY `id_shop` (`id_shop`,`date_add`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customer`
--

LOCK TABLES `ps_customer` WRITE;
/*!40000 ALTER TABLE `ps_customer` DISABLE KEYS */;
INSERT INTO `ps_customer` VALUES (1,1,1,1,3,1,0,'','','','John','DOE','pub@prestashop.com','045bcca29beb291723d4e51b17d1bde7','2025-03-04 02:13:15','1970-01-15',1,'','2013-12-13 08:19:15',1,'',0.000000,0,0,'3c10d2b85e27acb0b7a98b32d684b634','',1,0,0,'2025-03-04 08:13:15','2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customer_group`
--

DROP TABLE IF EXISTS `ps_customer_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customer_group` (
                                   `id_customer` int(10) unsigned NOT NULL,
                                   `id_group` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_customer`,`id_group`),
                                   KEY `customer_login` (`id_group`),
                                   KEY `id_customer` (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customer_group`
--

LOCK TABLES `ps_customer_group` WRITE;
/*!40000 ALTER TABLE `ps_customer_group` DISABLE KEYS */;
INSERT INTO `ps_customer_group` VALUES (1,3);
/*!40000 ALTER TABLE `ps_customer_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customer_message`
--

DROP TABLE IF EXISTS `ps_customer_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customer_message` (
                                     `id_customer_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `id_customer_thread` int(11) DEFAULT NULL,
                                     `id_employee` int(10) unsigned DEFAULT NULL,
                                     `message` mediumtext NOT NULL,
                                     `file_name` varchar(18) DEFAULT NULL,
                                     `ip_address` varchar(16) DEFAULT NULL,
                                     `user_agent` varchar(128) DEFAULT NULL,
                                     `date_add` datetime NOT NULL,
                                     `date_upd` datetime NOT NULL,
                                     `private` tinyint(4) NOT NULL DEFAULT 0,
                                     `read` tinyint(1) NOT NULL DEFAULT 0,
                                     PRIMARY KEY (`id_customer_message`),
                                     KEY `id_customer_thread` (`id_customer_thread`),
                                     KEY `id_employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customer_message`
--

LOCK TABLES `ps_customer_message` WRITE;
/*!40000 ALTER TABLE `ps_customer_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customer_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customer_message_sync_imap`
--

DROP TABLE IF EXISTS `ps_customer_message_sync_imap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customer_message_sync_imap` (
                                               `md5_header` varbinary(32) NOT NULL,
                                               KEY `md5_header_index` (`md5_header`(4))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customer_message_sync_imap`
--

LOCK TABLES `ps_customer_message_sync_imap` WRITE;
/*!40000 ALTER TABLE `ps_customer_message_sync_imap` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customer_message_sync_imap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customer_thread`
--

DROP TABLE IF EXISTS `ps_customer_thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customer_thread` (
                                    `id_customer_thread` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                    `id_lang` int(10) unsigned NOT NULL,
                                    `id_contact` int(10) unsigned NOT NULL,
                                    `id_customer` int(10) unsigned DEFAULT NULL,
                                    `id_order` int(10) unsigned DEFAULT NULL,
                                    `id_product` int(10) unsigned DEFAULT NULL,
                                    `status` enum('open','closed','pending1','pending2') NOT NULL DEFAULT 'open',
                                    `email` varchar(128) NOT NULL,
                                    `token` varchar(12) DEFAULT NULL,
                                    `date_add` datetime NOT NULL,
                                    `date_upd` datetime NOT NULL,
                                    PRIMARY KEY (`id_customer_thread`),
                                    KEY `id_shop` (`id_shop`),
                                    KEY `id_lang` (`id_lang`),
                                    KEY `id_contact` (`id_contact`),
                                    KEY `id_customer` (`id_customer`),
                                    KEY `id_order` (`id_order`),
                                    KEY `id_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customer_thread`
--

LOCK TABLES `ps_customer_thread` WRITE;
/*!40000 ALTER TABLE `ps_customer_thread` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customer_thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customization`
--

DROP TABLE IF EXISTS `ps_customization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customization` (
                                  `id_customization` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_product_attribute` int(10) unsigned NOT NULL DEFAULT 0,
                                  `id_address_delivery` int(10) unsigned NOT NULL DEFAULT 0,
                                  `id_cart` int(10) unsigned NOT NULL,
                                  `id_product` int(10) NOT NULL,
                                  `quantity` int(10) NOT NULL,
                                  `quantity_refunded` int(11) NOT NULL DEFAULT 0,
                                  `quantity_returned` int(11) NOT NULL DEFAULT 0,
                                  `in_cart` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                  PRIMARY KEY (`id_customization`,`id_cart`,`id_product`,`id_address_delivery`),
                                  KEY `id_product_attribute` (`id_product_attribute`),
                                  KEY `id_cart_product` (`id_cart`,`id_product`,`id_product_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customization`
--

LOCK TABLES `ps_customization` WRITE;
/*!40000 ALTER TABLE `ps_customization` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customization_field`
--

DROP TABLE IF EXISTS `ps_customization_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customization_field` (
                                        `id_customization_field` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                        `id_product` int(10) unsigned NOT NULL,
                                        `type` tinyint(1) NOT NULL,
                                        `required` tinyint(1) NOT NULL,
                                        PRIMARY KEY (`id_customization_field`),
                                        KEY `id_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customization_field`
--

LOCK TABLES `ps_customization_field` WRITE;
/*!40000 ALTER TABLE `ps_customization_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customization_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customization_field_lang`
--

DROP TABLE IF EXISTS `ps_customization_field_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customization_field_lang` (
                                             `id_customization_field` int(10) unsigned NOT NULL,
                                             `id_lang` int(10) unsigned NOT NULL,
                                             `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                             `name` varchar(255) NOT NULL,
                                             PRIMARY KEY (`id_customization_field`,`id_lang`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customization_field_lang`
--

LOCK TABLES `ps_customization_field_lang` WRITE;
/*!40000 ALTER TABLE `ps_customization_field_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customization_field_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_customized_data`
--

DROP TABLE IF EXISTS `ps_customized_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_customized_data` (
                                    `id_customization` int(10) unsigned NOT NULL,
                                    `type` tinyint(1) NOT NULL,
                                    `index` int(3) NOT NULL,
                                    `value` varchar(255) NOT NULL,
                                    PRIMARY KEY (`id_customization`,`type`,`index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_customized_data`
--

LOCK TABLES `ps_customized_data` WRITE;
/*!40000 ALTER TABLE `ps_customized_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_customized_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_date_range`
--

DROP TABLE IF EXISTS `ps_date_range`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_date_range` (
                               `id_date_range` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `time_start` datetime NOT NULL,
                               `time_end` datetime NOT NULL,
                               PRIMARY KEY (`id_date_range`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_date_range`
--

LOCK TABLES `ps_date_range` WRITE;
/*!40000 ALTER TABLE `ps_date_range` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_date_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_delivery`
--

DROP TABLE IF EXISTS `ps_delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_delivery` (
                             `id_delivery` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `id_shop` int(10) unsigned DEFAULT NULL,
                             `id_shop_group` int(10) unsigned DEFAULT NULL,
                             `id_carrier` int(10) unsigned NOT NULL,
                             `id_range_price` int(10) unsigned DEFAULT NULL,
                             `id_range_weight` int(10) unsigned DEFAULT NULL,
                             `id_zone` int(10) unsigned NOT NULL,
                             `price` decimal(20,6) NOT NULL,
                             PRIMARY KEY (`id_delivery`),
                             KEY `id_zone` (`id_zone`),
                             KEY `id_carrier` (`id_carrier`,`id_zone`),
                             KEY `id_range_price` (`id_range_price`),
                             KEY `id_range_weight` (`id_range_weight`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_delivery`
--

LOCK TABLES `ps_delivery` WRITE;
/*!40000 ALTER TABLE `ps_delivery` DISABLE KEYS */;
INSERT INTO `ps_delivery` VALUES (1,NULL,NULL,2,0,1,1,5.000000),(2,NULL,NULL,2,0,1,2,5.000000),(3,NULL,NULL,2,1,0,1,5.000000),(4,NULL,NULL,2,1,0,2,5.000000);
/*!40000 ALTER TABLE `ps_delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_employee`
--

DROP TABLE IF EXISTS `ps_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_employee` (
                             `id_employee` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `id_profile` int(10) unsigned NOT NULL,
                             `id_lang` int(10) unsigned NOT NULL DEFAULT 0,
                             `lastname` varchar(32) NOT NULL,
                             `firstname` varchar(32) NOT NULL,
                             `email` varchar(128) NOT NULL,
                             `passwd` varchar(32) NOT NULL,
                             `last_passwd_gen` timestamp NOT NULL DEFAULT current_timestamp(),
                             `stats_date_from` date DEFAULT NULL,
                             `stats_date_to` date DEFAULT NULL,
                             `stats_compare_from` date DEFAULT NULL,
                             `stats_compare_to` date DEFAULT NULL,
                             `stats_compare_option` int(1) unsigned NOT NULL DEFAULT 1,
                             `preselect_date_range` varchar(32) DEFAULT NULL,
                             `bo_color` varchar(32) DEFAULT NULL,
                             `bo_theme` varchar(32) DEFAULT NULL,
                             `bo_css` varchar(64) DEFAULT NULL,
                             `default_tab` int(10) unsigned NOT NULL DEFAULT 0,
                             `bo_width` int(10) unsigned NOT NULL DEFAULT 0,
                             `bo_menu` tinyint(1) NOT NULL DEFAULT 1,
                             `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                             `optin` tinyint(1) unsigned NOT NULL DEFAULT 1,
                             `id_last_order` int(10) unsigned NOT NULL DEFAULT 0,
                             `id_last_customer_message` int(10) unsigned NOT NULL DEFAULT 0,
                             `id_last_customer` int(10) unsigned NOT NULL DEFAULT 0,
                             `last_connection_date` date DEFAULT '0000-00-00',
                             PRIMARY KEY (`id_employee`),
                             KEY `employee_login` (`email`,`passwd`),
                             KEY `id_employee_passwd` (`id_employee`,`passwd`),
                             KEY `id_profile` (`id_profile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_employee`
--

LOCK TABLES `ps_employee` WRITE;
/*!40000 ALTER TABLE `ps_employee` DISABLE KEYS */;
INSERT INTO `ps_employee` VALUES (1,1,1,'PrestaShop','Admin','admin@prestashop.com','b27c032055d06a09603bdaf1fc583ac4','2025-03-04 02:13:15','2025-02-04','2025-03-04','0000-00-00','0000-00-00',1,NULL,NULL,'default','admin-theme.css',1,0,1,1,1,0,0,0,'0000-00-00');
/*!40000 ALTER TABLE `ps_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_employee_shop`
--

DROP TABLE IF EXISTS `ps_employee_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_employee_shop` (
                                  `id_employee` int(11) unsigned NOT NULL,
                                  `id_shop` int(11) unsigned NOT NULL,
                                  PRIMARY KEY (`id_employee`,`id_shop`),
                                  KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_employee_shop`
--

LOCK TABLES `ps_employee_shop` WRITE;
/*!40000 ALTER TABLE `ps_employee_shop` DISABLE KEYS */;
INSERT INTO `ps_employee_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_employee_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_eventbus_incremental_sync`
--

DROP TABLE IF EXISTS `ps_eventbus_incremental_sync`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_eventbus_incremental_sync` (
                                              `type` varchar(50) NOT NULL,
                                              `action` varchar(50) NOT NULL DEFAULT 'upsert',
                                              `id_object` varchar(50) NOT NULL,
                                              `id_shop` int(10) unsigned NOT NULL,
                                              `lang_iso` varchar(3) NOT NULL,
                                              `created_at` datetime NOT NULL,
                                              PRIMARY KEY (`type`,`id_object`,`id_shop`,`lang_iso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_eventbus_incremental_sync`
--

LOCK TABLES `ps_eventbus_incremental_sync` WRITE;
/*!40000 ALTER TABLE `ps_eventbus_incremental_sync` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_eventbus_incremental_sync` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_eventbus_job`
--

DROP TABLE IF EXISTS `ps_eventbus_job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_eventbus_job` (
                                 `job_id` varchar(200) NOT NULL,
                                 `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_eventbus_job`
--

LOCK TABLES `ps_eventbus_job` WRITE;
/*!40000 ALTER TABLE `ps_eventbus_job` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_eventbus_job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_eventbus_live_sync`
--

DROP TABLE IF EXISTS `ps_eventbus_live_sync`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_eventbus_live_sync` (
                                       `shop_content` varchar(50) NOT NULL,
                                       `last_change_at` datetime NOT NULL,
                                       PRIMARY KEY (`shop_content`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_eventbus_live_sync`
--

LOCK TABLES `ps_eventbus_live_sync` WRITE;
/*!40000 ALTER TABLE `ps_eventbus_live_sync` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_eventbus_live_sync` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_eventbus_type_sync`
--

DROP TABLE IF EXISTS `ps_eventbus_type_sync`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_eventbus_type_sync` (
                                       `type` varchar(50) NOT NULL,
                                       `offset` int(10) unsigned NOT NULL DEFAULT 0,
                                       `id_shop` int(10) unsigned NOT NULL,
                                       `lang_iso` varchar(3) NOT NULL,
                                       `full_sync_finished` tinyint(1) NOT NULL DEFAULT 0,
                                       `last_sync_date` datetime NOT NULL,
                                       PRIMARY KEY (`type`,`id_shop`,`lang_iso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_eventbus_type_sync`
--

LOCK TABLES `ps_eventbus_type_sync` WRITE;
/*!40000 ALTER TABLE `ps_eventbus_type_sync` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_eventbus_type_sync` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature`
--

DROP TABLE IF EXISTS `ps_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature` (
                            `id_feature` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `position` int(10) unsigned NOT NULL DEFAULT 0,
                            PRIMARY KEY (`id_feature`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature`
--

LOCK TABLES `ps_feature` WRITE;
/*!40000 ALTER TABLE `ps_feature` DISABLE KEYS */;
INSERT INTO `ps_feature` VALUES (1,0),(2,1),(3,2),(4,3),(5,4),(6,5),(7,6);
/*!40000 ALTER TABLE `ps_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature_lang`
--

DROP TABLE IF EXISTS `ps_feature_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature_lang` (
                                 `id_feature` int(10) unsigned NOT NULL,
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `name` varchar(128) DEFAULT NULL,
                                 PRIMARY KEY (`id_feature`,`id_lang`),
                                 KEY `id_lang` (`id_lang`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature_lang`
--

LOCK TABLES `ps_feature_lang` WRITE;
/*!40000 ALTER TABLE `ps_feature_lang` DISABLE KEYS */;
INSERT INTO `ps_feature_lang` VALUES (5,1,'Compositions'),(3,1,'Depth'),(1,1,'Height'),(7,1,'Properties'),(6,1,'Styles'),(4,1,'Weight'),(2,1,'Width');
/*!40000 ALTER TABLE `ps_feature_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature_product`
--

DROP TABLE IF EXISTS `ps_feature_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature_product` (
                                    `id_feature` int(10) unsigned NOT NULL,
                                    `id_product` int(10) unsigned NOT NULL,
                                    `id_feature_value` int(10) unsigned NOT NULL,
                                    PRIMARY KEY (`id_feature`,`id_product`),
                                    KEY `id_feature_value` (`id_feature_value`),
                                    KEY `id_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature_product`
--

LOCK TABLES `ps_feature_product` WRITE;
/*!40000 ALTER TABLE `ps_feature_product` DISABLE KEYS */;
INSERT INTO `ps_feature_product` VALUES (5,6,1),(5,7,1),(5,4,3),(5,5,3),(5,1,5),(5,2,5),(5,3,5),(6,1,11),(6,2,11),(6,5,11),(6,3,13),(6,6,13),(6,7,13),(6,4,16),(7,1,17),(7,2,17),(7,3,18),(7,4,19),(7,6,19),(7,7,20),(7,5,21);
/*!40000 ALTER TABLE `ps_feature_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature_shop`
--

DROP TABLE IF EXISTS `ps_feature_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature_shop` (
                                 `id_feature` int(11) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 PRIMARY KEY (`id_feature`,`id_shop`),
                                 KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature_shop`
--

LOCK TABLES `ps_feature_shop` WRITE;
/*!40000 ALTER TABLE `ps_feature_shop` DISABLE KEYS */;
INSERT INTO `ps_feature_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1);
/*!40000 ALTER TABLE `ps_feature_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature_value`
--

DROP TABLE IF EXISTS `ps_feature_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature_value` (
                                  `id_feature_value` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_feature` int(10) unsigned NOT NULL,
                                  `custom` tinyint(3) unsigned DEFAULT NULL,
                                  PRIMARY KEY (`id_feature_value`),
                                  KEY `feature` (`id_feature`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature_value`
--

LOCK TABLES `ps_feature_value` WRITE;
/*!40000 ALTER TABLE `ps_feature_value` DISABLE KEYS */;
INSERT INTO `ps_feature_value` VALUES (1,5,0),(2,5,0),(3,5,0),(4,5,0),(5,5,0),(6,5,0),(7,5,0),(8,5,0),(9,5,0),(10,6,0),(11,6,0),(12,6,0),(13,6,0),(14,6,0),(15,6,0),(16,6,0),(17,7,0),(18,7,0),(19,7,0),(20,7,0),(21,7,0),(22,1,1),(23,2,1),(24,4,1),(25,3,1),(26,1,1),(27,2,1),(28,4,1),(29,3,1),(30,1,1),(31,2,1),(32,4,1),(33,3,1);
/*!40000 ALTER TABLE `ps_feature_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_feature_value_lang`
--

DROP TABLE IF EXISTS `ps_feature_value_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_feature_value_lang` (
                                       `id_feature_value` int(10) unsigned NOT NULL,
                                       `id_lang` int(10) unsigned NOT NULL,
                                       `value` varchar(255) DEFAULT NULL,
                                       PRIMARY KEY (`id_feature_value`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_feature_value_lang`
--

LOCK TABLES `ps_feature_value_lang` WRITE;
/*!40000 ALTER TABLE `ps_feature_value_lang` DISABLE KEYS */;
INSERT INTO `ps_feature_value_lang` VALUES (1,1,'Polyester'),(2,1,'Wool'),(3,1,'Viscose'),(4,1,'Elastane'),(5,1,'Cotton'),(6,1,'Silk'),(7,1,'Suede'),(8,1,'Straw'),(9,1,'Leather'),(10,1,'Classic'),(11,1,'Casual'),(12,1,'Military'),(13,1,'Girly'),(14,1,'Rock'),(15,1,'Basic'),(16,1,'Dressy'),(17,1,'Short Sleeve'),(18,1,'Colorful Dress'),(19,1,'Short Dress'),(20,1,'Midi Dress'),(21,1,'Maxi Dress'),(22,1,'2.75 in'),(23,1,'2.06 in'),(24,1,'49.2 g'),(25,1,'0.26 in'),(26,1,'1.07 in'),(27,1,'1.62 in'),(28,1,'15.5 g'),(29,1,'0.41 in (clip included)'),(30,1,'4.33 in'),(31,1,'2.76 in'),(32,1,'120g'),(33,1,'0.31 in');
/*!40000 ALTER TABLE `ps_feature_value_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_gender`
--

DROP TABLE IF EXISTS `ps_gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_gender` (
                           `id_gender` int(11) NOT NULL AUTO_INCREMENT,
                           `type` tinyint(1) NOT NULL,
                           PRIMARY KEY (`id_gender`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_gender`
--

LOCK TABLES `ps_gender` WRITE;
/*!40000 ALTER TABLE `ps_gender` DISABLE KEYS */;
INSERT INTO `ps_gender` VALUES (1,0),(2,1);
/*!40000 ALTER TABLE `ps_gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_gender_lang`
--

DROP TABLE IF EXISTS `ps_gender_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_gender_lang` (
                                `id_gender` int(10) unsigned NOT NULL,
                                `id_lang` int(10) unsigned NOT NULL,
                                `name` varchar(20) NOT NULL,
                                PRIMARY KEY (`id_gender`,`id_lang`),
                                KEY `id_gender` (`id_gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_gender_lang`
--

LOCK TABLES `ps_gender_lang` WRITE;
/*!40000 ALTER TABLE `ps_gender_lang` DISABLE KEYS */;
INSERT INTO `ps_gender_lang` VALUES (1,1,'Mr.'),(2,1,'Mrs.');
/*!40000 ALTER TABLE `ps_gender_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_group`
--

DROP TABLE IF EXISTS `ps_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_group` (
                          `id_group` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `reduction` decimal(17,2) NOT NULL DEFAULT 0.00,
                          `price_display_method` tinyint(4) NOT NULL DEFAULT 0,
                          `show_prices` tinyint(1) unsigned NOT NULL DEFAULT 1,
                          `date_add` datetime NOT NULL,
                          `date_upd` datetime NOT NULL,
                          PRIMARY KEY (`id_group`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_group`
--

LOCK TABLES `ps_group` WRITE;
/*!40000 ALTER TABLE `ps_group` DISABLE KEYS */;
INSERT INTO `ps_group` VALUES (1,0.00,0,1,'2025-03-04 08:13:14','2025-03-04 08:13:14'),(2,0.00,0,1,'2025-03-04 08:13:14','2025-03-04 08:13:14'),(3,0.00,0,1,'2025-03-04 08:13:14','2025-03-04 08:13:14');
/*!40000 ALTER TABLE `ps_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_group_lang`
--

DROP TABLE IF EXISTS `ps_group_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_group_lang` (
                               `id_group` int(10) unsigned NOT NULL,
                               `id_lang` int(10) unsigned NOT NULL,
                               `name` varchar(32) NOT NULL,
                               PRIMARY KEY (`id_group`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_group_lang`
--

LOCK TABLES `ps_group_lang` WRITE;
/*!40000 ALTER TABLE `ps_group_lang` DISABLE KEYS */;
INSERT INTO `ps_group_lang` VALUES (1,1,'Visitor'),(2,1,'Guest'),(3,1,'Customer');
/*!40000 ALTER TABLE `ps_group_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_group_reduction`
--

DROP TABLE IF EXISTS `ps_group_reduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_group_reduction` (
                                    `id_group_reduction` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_group` int(10) unsigned NOT NULL,
                                    `id_category` int(10) unsigned NOT NULL,
                                    `reduction` decimal(4,3) NOT NULL,
                                    PRIMARY KEY (`id_group_reduction`),
                                    UNIQUE KEY `id_group` (`id_group`,`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_group_reduction`
--

LOCK TABLES `ps_group_reduction` WRITE;
/*!40000 ALTER TABLE `ps_group_reduction` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_group_reduction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_group_shop`
--

DROP TABLE IF EXISTS `ps_group_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_group_shop` (
                               `id_group` int(11) unsigned NOT NULL,
                               `id_shop` int(11) unsigned NOT NULL,
                               PRIMARY KEY (`id_group`,`id_shop`),
                               KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_group_shop`
--

LOCK TABLES `ps_group_shop` WRITE;
/*!40000 ALTER TABLE `ps_group_shop` DISABLE KEYS */;
INSERT INTO `ps_group_shop` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `ps_group_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_guest`
--

DROP TABLE IF EXISTS `ps_guest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_guest` (
                          `id_guest` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `id_operating_system` int(10) unsigned DEFAULT NULL,
                          `id_web_browser` int(10) unsigned DEFAULT NULL,
                          `id_customer` int(10) unsigned DEFAULT NULL,
                          `javascript` tinyint(1) DEFAULT 0,
                          `screen_resolution_x` smallint(5) unsigned DEFAULT NULL,
                          `screen_resolution_y` smallint(5) unsigned DEFAULT NULL,
                          `screen_color` tinyint(3) unsigned DEFAULT NULL,
                          `sun_java` tinyint(1) DEFAULT NULL,
                          `adobe_flash` tinyint(1) DEFAULT NULL,
                          `adobe_director` tinyint(1) DEFAULT NULL,
                          `apple_quicktime` tinyint(1) DEFAULT NULL,
                          `real_player` tinyint(1) DEFAULT NULL,
                          `windows_media` tinyint(1) DEFAULT NULL,
                          `accept_language` varchar(8) DEFAULT NULL,
                          `mobile_theme` tinyint(1) NOT NULL DEFAULT 0,
                          PRIMARY KEY (`id_guest`),
                          KEY `id_customer` (`id_customer`),
                          KEY `id_operating_system` (`id_operating_system`),
                          KEY `id_web_browser` (`id_web_browser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_guest`
--

LOCK TABLES `ps_guest` WRITE;
/*!40000 ALTER TABLE `ps_guest` DISABLE KEYS */;
INSERT INTO `ps_guest` VALUES (1,0,0,1,0,0,0,0,0,0,0,0,0,0,'',0);
/*!40000 ALTER TABLE `ps_guest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_homeslider`
--

DROP TABLE IF EXISTS `ps_homeslider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_homeslider` (
                               `id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `id_shop` int(10) unsigned NOT NULL,
                               PRIMARY KEY (`id_homeslider_slides`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_homeslider`
--

LOCK TABLES `ps_homeslider` WRITE;
/*!40000 ALTER TABLE `ps_homeslider` DISABLE KEYS */;
INSERT INTO `ps_homeslider` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `ps_homeslider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_homeslider_slides`
--

DROP TABLE IF EXISTS `ps_homeslider_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_homeslider_slides` (
                                      `id_homeslider_slides` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                      `position` int(10) unsigned NOT NULL DEFAULT 0,
                                      `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                      PRIMARY KEY (`id_homeslider_slides`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_homeslider_slides`
--

LOCK TABLES `ps_homeslider_slides` WRITE;
/*!40000 ALTER TABLE `ps_homeslider_slides` DISABLE KEYS */;
INSERT INTO `ps_homeslider_slides` VALUES (1,1,1),(2,2,1),(3,3,1);
/*!40000 ALTER TABLE `ps_homeslider_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_homeslider_slides_lang`
--

DROP TABLE IF EXISTS `ps_homeslider_slides_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_homeslider_slides_lang` (
                                           `id_homeslider_slides` int(10) unsigned NOT NULL,
                                           `id_lang` int(10) unsigned NOT NULL,
                                           `title` varchar(255) NOT NULL,
                                           `description` text NOT NULL,
                                           `legend` varchar(255) NOT NULL,
                                           `url` varchar(255) NOT NULL,
                                           `image` varchar(255) NOT NULL,
                                           PRIMARY KEY (`id_homeslider_slides`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_homeslider_slides_lang`
--

LOCK TABLES `ps_homeslider_slides_lang` WRITE;
/*!40000 ALTER TABLE `ps_homeslider_slides_lang` DISABLE KEYS */;
INSERT INTO `ps_homeslider_slides_lang` VALUES (1,1,'Sample 1','<h2>EXCEPTEUR<br />OCCAECAT</h2>\n				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique in tortor et dignissim. Quisque non tempor leo. Maecenas egestas sem elit</p>\n				<p><button class=\"btn btn-default\" type=\"button\">Shop now !</button></p>','sample-1','http://www.prestashop.com/?utm_source=back-office&utm_medium=v16_homeslider&utm_campaign=back-office-EN&utm_content=download','sample-1.jpg'),(2,1,'Sample 2','<h2>EXCEPTEUR<br />OCCAECAT</h2>\n				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique in tortor et dignissim. Quisque non tempor leo. Maecenas egestas sem elit</p>\n				<p><button class=\"btn btn-default\" type=\"button\">Shop now !</button></p>','sample-2','http://www.prestashop.com/?utm_source=back-office&utm_medium=v16_homeslider&utm_campaign=back-office-EN&utm_content=download','sample-2.jpg'),(3,1,'Sample 3','<h2>EXCEPTEUR<br />OCCAECAT</h2>\n				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tristique in tortor et dignissim. Quisque non tempor leo. Maecenas egestas sem elit</p>\n				<p><button class=\"btn btn-default\" type=\"button\">Shop now !</button></p>','sample-3','http://www.prestashop.com/?utm_source=back-office&utm_medium=v16_homeslider&utm_campaign=back-office-EN&utm_content=download','sample-3.jpg');
/*!40000 ALTER TABLE `ps_homeslider_slides_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_hook`
--

DROP TABLE IF EXISTS `ps_hook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_hook` (
                         `id_hook` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(64) NOT NULL,
                         `title` varchar(64) NOT NULL,
                         `description` text DEFAULT NULL,
                         `position` tinyint(1) NOT NULL DEFAULT 1,
                         `live_edit` tinyint(1) NOT NULL DEFAULT 0,
                         PRIMARY KEY (`id_hook`),
                         UNIQUE KEY `hook_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_hook`
--

LOCK TABLES `ps_hook` WRITE;
/*!40000 ALTER TABLE `ps_hook` DISABLE KEYS */;
INSERT INTO `ps_hook` VALUES (1,'displayPayment','Payment','This hook displays new elements on the payment page',1,1),(2,'actionValidateOrder','New orders','',1,0),(3,'displayMaintenance','Maintenance Page','This hook displays new elements on the maintenance page',1,0),(4,'actionPaymentConfirmation','Payment confirmation','This hook displays new elements after the payment is validated',1,0),(5,'displayPaymentReturn','Payment return','',1,0),(6,'actionUpdateQuantity','Quantity update','Quantity is updated only when a customer effectively places their order',1,0),(7,'displayRightColumn','Right column blocks','This hook displays new elements in the right-hand column',1,1),(8,'displayLeftColumn','Left column blocks','This hook displays new elements in the left-hand column',1,1),(9,'displayHome','Homepage content','This hook displays new elements on the homepage',1,1),(10,'Header','Pages html head section','This hook adds additional elements in the head section of your pages (head section of html)',1,0),(11,'actionCartSave','Cart creation and update','This hook is displayed when a product is added to the cart or if the cart\'s content is modified',1,0),(12,'actionAuthentication','Successful customer authentication','This hook is displayed after a customer successfully signs in',1,0),(13,'actionProductAdd','Product creation','This hook is displayed after a product is created',1,0),(14,'actionProductUpdate','Product update','This hook is displayed after a product has been updated',1,0),(15,'displayTop','Top of pages','This hook displays additional elements at the top of your pages',1,0),(16,'displayRightColumnProduct','New elements on the product page (right column)','This hook displays new elements in the right-hand column of the product page',1,0),(17,'actionProductDelete','Product deletion','This hook is called when a product is deleted',1,0),(18,'displayFooterProduct','Product footer','This hook adds new blocks under the product\'s description',1,1),(19,'displayInvoice','Invoice','This hook displays new blocks on the invoice (order)',1,0),(20,'actionOrderStatusUpdate','Order status update - Event','This hook launches modules when the status of an order changes.',1,0),(21,'displayAdminOrder','Display new elements in the Back Office, tab AdminOrder','This hook launches modules when the AdminOrder tab is displayed in the Back Office',1,0),(22,'displayAdminOrderTabOrder','Display new elements in Back Office, AdminOrder, panel Order','This hook launches modules when the AdminOrder tab is displayed in the Back Office and extends / override Order panel tabs',1,0),(23,'displayAdminOrderTabShip','Display new elements in Back Office, AdminOrder, panel Shipping','This hook launches modules when the AdminOrder tab is displayed in the Back Office and extends / override Shipping panel tabs',1,0),(24,'displayAdminOrderContentOrder','Display new elements in Back Office, AdminOrder, panel Order','This hook launches modules when the AdminOrder tab is displayed in the Back Office and extends / override Order panel content',1,0),(25,'displayAdminOrderContentShip','Display new elements in Back Office, AdminOrder, panel Shipping','This hook launches modules when the AdminOrder tab is displayed in the Back Office and extends / override Shipping panel content',1,0),(26,'displayFooter','Footer','This hook displays new blocks in the footer',1,0),(27,'displayPDFInvoice','PDF Invoice','This hook allows you to display additional information on PDF invoices',1,0),(28,'displayInvoiceLegalFreeText','PDF Invoice - Legal Free Text','This hook allows you to modify the legal free text on PDF invoices',1,0),(29,'displayAdminCustomers','Display new elements in the Back Office, tab AdminCustomers','This hook launches modules when the AdminCustomers tab is displayed in the Back Office',1,0),(30,'displayOrderConfirmation','Order confirmation page','This hook is called within an order\'s confirmation page',1,0),(31,'actionCustomerAccountAdd','Successful customer account creation','This hook is called when a new customer creates an account successfully',1,0),(32,'displayCustomerAccount','Customer account displayed in Front Office','This hook displays new elements on the customer account page',1,0),(33,'displayCustomerIdentityForm','Customer identity form displayed in Front Office','This hook displays new elements on the form to update a customer identity',1,0),(34,'actionOrderSlipAdd','Order slip creation','This hook is called when a new credit slip is added regarding client order',1,0),(35,'displayProductTab','Tabs on product page','This hook is called on the product page\'s tab',1,0),(36,'displayProductTabContent','Tabs content on the product page','This hook is called on the product page\'s tab',1,0),(37,'displayShoppingCartFooter','Shopping cart footer','This hook displays some specific information on the shopping cart\'s page',1,0),(38,'displayCustomerAccountForm','Customer account creation form','This hook displays some information on the form to create a customer account',1,0),(39,'displayAdminStatsModules','Stats - Modules','',1,0),(40,'displayAdminStatsGraphEngine','Graph engines','',1,0),(41,'actionOrderReturn','Returned product','This hook is displayed when a customer returns a product ',1,0),(42,'displayProductButtons','Product page actions','This hook adds new action buttons on the product page',1,0),(43,'displayBackOfficeHome','Administration panel homepage','This hook is displayed on the admin panel\'s homepage',1,0),(44,'displayAdminStatsGridEngine','Grid engines','',1,0),(45,'actionWatermark','Watermark','',1,0),(46,'actionProductCancel','Product cancelled','This hook is called when you cancel a product in an order',1,0),(47,'displayLeftColumnProduct','New elements on the product page (left column)','This hook displays new elements in the left-hand column of the product page',1,0),(48,'actionProductOutOfStock','Out-of-stock product','This hook displays new action buttons if a product is out of stock',1,0),(49,'actionProductAttributeUpdate','Product attribute update','This hook is displayed when a product\'s attribute is updated',1,0),(50,'displayCarrierList','Extra carrier (module mode)','',1,0),(51,'displayShoppingCart','Shopping cart - Additional button','This hook displays new action buttons within the shopping cart',1,0),(52,'actionSearch','Search','',1,0),(53,'displayBeforePayment','Redirect during the order process','This hook redirects the user to the module instead of displaying payment modules',1,0),(54,'actionCarrierUpdate','Carrier Update','This hook is called when a carrier is updated',1,0),(55,'actionOrderStatusPostUpdate','Post update of order status','',1,0),(56,'displayCustomerAccountFormTop','Block above the form for create an account','This hook is displayed above the customer\'s account creation form',1,0),(57,'displayBackOfficeHeader','Administration panel header','This hook is displayed in the header of the admin panel',1,0),(58,'displayBackOfficeTop','Administration panel hover the tabs','This hook is displayed on the roll hover of the tabs within the admin panel',1,0),(59,'displayBackOfficeFooter','Administration panel footer','This hook is displayed within the admin panel\'s footer',1,0),(60,'actionProductAttributeDelete','Product attribute deletion','This hook is displayed when a product\'s attribute is deleted',1,0),(61,'actionCarrierProcess','Carrier process','',1,0),(62,'actionOrderDetail','Order detail','This hook is used to set the follow-up in Smarty when an order\'s detail is called',1,0),(63,'displayBeforeCarrier','Before carriers list','This hook is displayed before the carrier list in Front Office',1,0),(64,'displayOrderDetail','Order detail','This hook is displayed within the order\'s details in Front Office',1,0),(65,'actionPaymentCCAdd','Payment CC added','',1,0),(66,'displayProductComparison','Extra product comparison','',1,0),(67,'actionCategoryAdd','Category creation','This hook is displayed when a category is created',1,0),(68,'actionCategoryUpdate','Category modification','This hook is displayed when a category is modified',1,0),(69,'actionCategoryDelete','Category deletion','This hook is displayed when a category is deleted',1,0),(70,'actionBeforeAuthentication','Before authentication','This hook is displayed before the customer\'s authentication',1,0),(71,'displayPaymentTop','Top of payment page','This hook is displayed at the top of the payment page',1,0),(72,'actionHtaccessCreate','After htaccess creation','This hook is displayed after the htaccess creation',1,0),(73,'actionAdminMetaSave','After saving the configuration in AdminMeta','This hook is displayed after saving the configuration in AdminMeta',1,0),(74,'displayAttributeGroupForm','Add fields to the form \'attribute group\'','This hook adds fields to the form \'attribute group\'',1,0),(75,'actionAttributeGroupSave','Saving an attribute group','This hook is called while saving an attributes group',1,0),(76,'actionAttributeGroupDelete','Deleting attribute group','This hook is called while deleting an attributes  group',1,0),(77,'displayFeatureForm','Add fields to the form \'feature\'','This hook adds fields to the form \'feature\'',1,0),(78,'actionFeatureSave','Saving attributes\' features','This hook is called while saving an attributes features',1,0),(79,'actionFeatureDelete','Deleting attributes\' features','This hook is called while deleting an attributes features',1,0),(80,'actionProductSave','Saving products','This hook is called while saving products',1,0),(81,'actionProductListOverride','Assign a products list to a category','This hook assigns a products list to a category',1,0),(82,'displayAttributeGroupPostProcess','On post-process in admin attribute group','This hook is called on post-process in admin attribute group',1,0),(83,'displayFeaturePostProcess','On post-process in admin feature','This hook is called on post-process in admin feature',1,0),(84,'displayFeatureValueForm','Add fields to the form \'feature value\'','This hook adds fields to the form \'feature value\'',1,0),(85,'displayFeatureValuePostProcess','On post-process in admin feature value','This hook is called on post-process in admin feature value',1,0),(86,'actionFeatureValueDelete','Deleting attributes\' features\' values','This hook is called while deleting an attributes features value',1,0),(87,'actionFeatureValueSave','Saving an attributes features value','This hook is called while saving an attributes features value',1,0),(88,'displayAttributeForm','Add fields to the form \'attribute value\'','This hook adds fields to the form \'attribute value\'',1,0),(89,'actionAttributePostProcess','On post-process in admin feature value','This hook is called on post-process in admin feature value',1,0),(90,'actionAttributeDelete','Deleting an attributes features value','This hook is called while deleting an attributes features value',1,0),(91,'actionAttributeSave','Saving an attributes features value','This hook is called while saving an attributes features value',1,0),(92,'actionTaxManager','Tax Manager Factory','',1,0),(93,'displayMyAccountBlock','My account block','This hook displays extra information within the \'my account\' block\"',1,0),(94,'actionModuleInstallBefore','actionModuleInstallBefore','',1,0),(95,'actionModuleInstallAfter','actionModuleInstallAfter','',1,0),(96,'displayHomeTab','Home Page Tabs','This hook displays new elements on the homepage tabs',1,1),(97,'displayHomeTabContent','Home Page Tabs Content','This hook displays new elements on the homepage tabs content',1,1),(98,'displayTopColumn','Top column blocks','This hook displays new elements in the top of columns',1,1),(99,'displayBackOfficeCategory','Display new elements in the Back Office, tab AdminCategories','This hook launches modules when the AdminCategories tab is displayed in the Back Office',1,0),(100,'displayProductListFunctionalButtons','Display new elements in the Front Office, products list','This hook launches modules when the products list is displayed in the Front Office',1,0),(101,'displayNav','Navigation','',1,1),(102,'displayOverrideTemplate','Change the default template of current controller','',1,0),(103,'actionAdminLoginControllerSetMedia','Set media on admin login page header','This hook is called after adding media to admin login page header',1,0),(104,'actionOrderEdited','Order edited','This hook is called when an order is edited.',1,0),(105,'actionEmailAddBeforeContent','Add extra content before mail content','This hook is called just before fetching mail template',1,0),(106,'actionEmailAddAfterContent','Add extra content after mail content','This hook is called just after fetching mail template',1,0),(107,'displayCartExtraProductActions','Extra buttons in shopping cart','This hook adds extra buttons to the product lines, in the shopping cart',1,0),(108,'actionObjectProductUpdateAfter','actionObjectProductUpdateAfter','',0,0),(109,'actionObjectProductDeleteAfter','actionObjectProductDeleteAfter','',0,0),(110,'displayCompareExtraInformation','displayCompareExtraInformation','',1,1),(111,'displaySocialSharing','displaySocialSharing','',1,1),(112,'displayBanner','displayBanner','',1,1),(113,'actionObjectLanguageAddAfter','actionObjectLanguageAddAfter','',0,0),(114,'displayPaymentEU','displayPaymentEU','',1,1),(115,'actionCartListOverride','actionCartListOverride','',0,0),(116,'actionAdminMetaControllerUpdate_optionsBefore','actionAdminMetaControllerUpdate_optionsBefore','',0,0),(117,'actionAdminLanguagesControllerStatusBefore','actionAdminLanguagesControllerStatusBefore','',0,0),(118,'actionObjectCmsUpdateAfter','actionObjectCmsUpdateAfter','',0,0),(119,'actionObjectCmsDeleteAfter','actionObjectCmsDeleteAfter','',0,0),(120,'actionShopDataDuplication','actionShopDataDuplication','',0,0),(121,'actionAdminStoresControllerUpdate_optionsAfter','actionAdminStoresControllerUpdate_optionsAfter','',0,0),(122,'actionObjectManufacturerDeleteAfter','actionObjectManufacturerDeleteAfter','',0,0),(123,'actionObjectManufacturerAddAfter','actionObjectManufacturerAddAfter','',0,0),(124,'actionObjectManufacturerUpdateAfter','actionObjectManufacturerUpdateAfter','',0,0),(126,'actionModuleRegisterHookAfter','actionModuleRegisterHookAfter','',0,0),(127,'actionModuleUnRegisterHookAfter','actionModuleUnRegisterHookAfter','',0,0),(128,'displayMyAccountBlockfooter','My account block','Display extra informations inside the \"my account\" block',1,0),(129,'registerGDPRConsent','registerGDPRConsent','',0,0),(130,'actionExportGDPRData','actionExportGDPRData','',0,0),(131,'actionDeleteGDPRCustomer','actionDeleteGDPRCustomer','',0,0),(132,'displayMobileTopSiteMap','displayMobileTopSiteMap','',1,1),(133,'displaySearch','displaySearch','',1,1),(134,'actionObjectSupplierDeleteAfter','actionObjectSupplierDeleteAfter','',0,0),(135,'actionObjectSupplierAddAfter','actionObjectSupplierAddAfter','',0,0),(136,'actionObjectSupplierUpdateAfter','actionObjectSupplierUpdateAfter','',0,0),(137,'actionObjectCategoryUpdateAfter','actionObjectCategoryUpdateAfter','',0,0),(138,'actionObjectCategoryDeleteAfter','actionObjectCategoryDeleteAfter','',0,0),(139,'actionObjectCategoryAddAfter','actionObjectCategoryAddAfter','',0,0),(140,'actionObjectCmsAddAfter','actionObjectCmsAddAfter','',0,0),(141,'actionObjectProductAddAfter','actionObjectProductAddAfter','',0,0),(142,'dashboardZoneOne','dashboardZoneOne','',0,0),(143,'dashboardData','dashboardData','',0,0),(144,'actionObjectOrderAddAfter','actionObjectOrderAddAfter','',0,0),(145,'actionObjectCustomerAddAfter','actionObjectCustomerAddAfter','',0,0),(146,'actionObjectCustomerMessageAddAfter','actionObjectCustomerMessageAddAfter','',0,0),(147,'actionObjectCustomerThreadAddAfter','actionObjectCustomerThreadAddAfter','',0,0),(148,'actionObjectOrderReturnAddAfter','actionObjectOrderReturnAddAfter','',0,0),(149,'actionAdminControllerSetMedia','actionAdminControllerSetMedia','',0,0),(150,'dashboardZoneTwo','dashboardZoneTwo','',0,0),(151,'displayAdminAfterHeader','displayAdminAfterHeader','',1,1),(152,'displayAdminOrderLeft','displayAdminOrderLeft','',1,1),(153,'displayAdminOrderMainBottom','displayAdminOrderMainBottom','',1,1),(154,'actionObjectShopAddAfter','actionObjectShopAddAfter','',0,0),(155,'actionObjectShopDeleteAfter','actionObjectShopDeleteAfter','',0,0),(156,'displayPaymentByBinaries','displayPaymentByBinaries','',1,1),(157,'actionFrontControllerSetMedia','actionFrontControllerSetMedia','',0,0),(158,'actionObjectOrderPaymentAddAfter','actionObjectOrderPaymentAddAfter','',0,0),(159,'actionObjectOrderPaymentUpdateAfter','actionObjectOrderPaymentUpdateAfter','',0,0),(160,'actionBeforeCartUpdateQty','actionBeforeCartUpdateQty','',0,0),(161,'actionAfterDeleteProductInCart','actionAfterDeleteProductInCart','',0,0),(162,'displayCartTotalPriceLabel','displayCartTotalPriceLabel','',1,1),(163,'actionObjectCarrierAddAfter','actionObjectCarrierAddAfter','',0,0),(164,'actionObjectCarrierUpdateAfter','actionObjectCarrierUpdateAfter','',0,0),(165,'actionObjectCarrierDeleteAfter','actionObjectCarrierDeleteAfter','',0,0),(166,'actionObjectCartAddAfter','actionObjectCartAddAfter','',0,0),(167,'actionObjectCartUpdateAfter','actionObjectCartUpdateAfter','',0,0),(168,'actionObjectCartRuleAddAfter','actionObjectCartRuleAddAfter','',0,0),(169,'actionObjectCartRuleUpdateAfter','actionObjectCartRuleUpdateAfter','',0,0),(170,'actionObjectCartRuleDeleteAfter','actionObjectCartRuleDeleteAfter','',0,0),(171,'actionObjectCombinationAddAfter','actionObjectCombinationAddAfter','',0,0),(172,'actionObjectCombinationUpdateAfter','actionObjectCombinationUpdateAfter','',0,0),(173,'actionObjectCombinationDeleteAfter','actionObjectCombinationDeleteAfter','',0,0),(174,'actionObjectCurrencyAddAfter','actionObjectCurrencyAddAfter','',0,0),(175,'actionObjectCurrencyUpdateAfter','actionObjectCurrencyUpdateAfter','',0,0),(176,'actionObjectCurrencyDeleteAfter','actionObjectCurrencyDeleteAfter','',0,0),(177,'actionObjectCustomerUpdateAfter','actionObjectCustomerUpdateAfter','',0,0),(178,'actionObjectCustomerDeleteAfter','actionObjectCustomerDeleteAfter','',0,0),(179,'actionObjectEmployeeAddAfter','actionObjectEmployeeAddAfter','',0,0),(180,'actionObjectEmployeeUpdateAfter','actionObjectEmployeeUpdateAfter','',0,0),(181,'actionObjectEmployeeDeleteAfter','actionObjectEmployeeDeleteAfter','',0,0),(182,'actionObjectImageAddAfter','actionObjectImageAddAfter','',0,0),(183,'actionObjectImageUpdateAfter','actionObjectImageUpdateAfter','',0,0),(184,'actionObjectImageDeleteAfter','actionObjectImageDeleteAfter','',0,0),(185,'actionObjectImageTypeAddAfter','actionObjectImageTypeAddAfter','',0,0),(186,'actionObjectImageTypeUpdateAfter','actionObjectImageTypeUpdateAfter','',0,0),(187,'actionObjectImageTypeDeleteAfter','actionObjectImageTypeDeleteAfter','',0,0),(188,'actionObjectLanguageUpdateAfter','actionObjectLanguageUpdateAfter','',0,0),(189,'actionObjectLanguageDeleteAfter','actionObjectLanguageDeleteAfter','',0,0),(190,'actionObjectOrderCarrierAddAfter','actionObjectOrderCarrierAddAfter','',0,0),(191,'actionObjectOrderCarrierUpdateAfter','actionObjectOrderCarrierUpdateAfter','',0,0),(192,'actionObjectOrderCartRuleAddAfter','actionObjectOrderCartRuleAddAfter','',0,0),(193,'actionObjectOrderCartRuleUpdateAfter','actionObjectOrderCartRuleUpdateAfter','',0,0),(194,'actionObjectOrderDetailAddAfter','actionObjectOrderDetailAddAfter','',0,0),(195,'actionObjectOrderDetailUpdateAfter','actionObjectOrderDetailUpdateAfter','',0,0),(196,'actionObjectOrderHistoryAddAfter','actionObjectOrderHistoryAddAfter','',0,0),(197,'actionObjectOrderHistoryUpdateAfter','actionObjectOrderHistoryUpdateAfter','',0,0),(198,'actionObjectOrderUpdateAfter','actionObjectOrderUpdateAfter','',0,0),(199,'actionObjectSpecificPriceAddAfter','actionObjectSpecificPriceAddAfter','',0,0),(200,'actionObjectSpecificPriceUpdateAfter','actionObjectSpecificPriceUpdateAfter','',0,0),(201,'actionObjectSpecificPriceDeleteAfter','actionObjectSpecificPriceDeleteAfter','',0,0),(202,'actionObjectStockAvailableAddAfter','actionObjectStockAvailableAddAfter','',0,0),(203,'actionObjectStockAvailableUpdateAfter','actionObjectStockAvailableUpdateAfter','',0,0),(204,'actionObjectStockMvtAddAfter','actionObjectStockMvtAddAfter','',0,0),(205,'actionObjectStoreAddAfter','actionObjectStoreAddAfter','',0,0),(206,'actionObjectStoreUpdateAfter','actionObjectStoreUpdateAfter','',0,0),(207,'actionObjectStoreDeleteAfter','actionObjectStoreDeleteAfter','',0,0),(208,'actionObjectWishlistAddAfter','actionObjectWishlistAddAfter','',0,0),(209,'actionObjectWishlistUpdateAfter','actionObjectWishlistUpdateAfter','',0,0),(210,'actionObjectWishlistDeleteAfter','actionObjectWishlistDeleteAfter','',0,0);
/*!40000 ALTER TABLE `ps_hook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_hook_alias`
--

DROP TABLE IF EXISTS `ps_hook_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_hook_alias` (
                               `id_hook_alias` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `alias` varchar(64) NOT NULL,
                               `name` varchar(64) NOT NULL,
                               PRIMARY KEY (`id_hook_alias`),
                               UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_hook_alias`
--

LOCK TABLES `ps_hook_alias` WRITE;
/*!40000 ALTER TABLE `ps_hook_alias` DISABLE KEYS */;
INSERT INTO `ps_hook_alias` VALUES (1,'payment','displayPayment'),(2,'newOrder','actionValidateOrder'),(3,'paymentConfirm','actionPaymentConfirmation'),(4,'paymentReturn','displayPaymentReturn'),(5,'updateQuantity','actionUpdateQuantity'),(6,'rightColumn','displayRightColumn'),(7,'leftColumn','displayLeftColumn'),(8,'home','displayHome'),(9,'displayHeader','Header'),(10,'cart','actionCartSave'),(11,'authentication','actionAuthentication'),(12,'addproduct','actionProductAdd'),(13,'updateproduct','actionProductUpdate'),(14,'top','displayTop'),(15,'extraRight','displayRightColumnProduct'),(16,'deleteproduct','actionProductDelete'),(17,'productfooter','displayFooterProduct'),(18,'invoice','displayInvoice'),(19,'updateOrderStatus','actionOrderStatusUpdate'),(20,'adminOrder','displayAdminOrder'),(21,'footer','displayFooter'),(22,'PDFInvoice','displayPDFInvoice'),(23,'adminCustomers','displayAdminCustomers'),(24,'orderConfirmation','displayOrderConfirmation'),(25,'createAccount','actionCustomerAccountAdd'),(26,'customerAccount','displayCustomerAccount'),(27,'orderSlip','actionOrderSlipAdd'),(28,'productTab','displayProductTab'),(29,'productTabContent','displayProductTabContent'),(30,'shoppingCart','displayShoppingCartFooter'),(31,'createAccountForm','displayCustomerAccountForm'),(32,'AdminStatsModules','displayAdminStatsModules'),(33,'GraphEngine','displayAdminStatsGraphEngine'),(34,'orderReturn','actionOrderReturn'),(35,'productActions','displayProductButtons'),(36,'backOfficeHome','displayBackOfficeHome'),(37,'GridEngine','displayAdminStatsGridEngine'),(38,'watermark','actionWatermark'),(39,'cancelProduct','actionProductCancel'),(40,'extraLeft','displayLeftColumnProduct'),(41,'productOutOfStock','actionProductOutOfStock'),(42,'updateProductAttribute','actionProductAttributeUpdate'),(43,'extraCarrier','displayCarrierList'),(44,'shoppingCartExtra','displayShoppingCart'),(45,'search','actionSearch'),(46,'backBeforePayment','displayBeforePayment'),(47,'updateCarrier','actionCarrierUpdate'),(48,'postUpdateOrderStatus','actionOrderStatusPostUpdate'),(49,'createAccountTop','displayCustomerAccountFormTop'),(50,'backOfficeHeader','displayBackOfficeHeader'),(51,'backOfficeTop','displayBackOfficeTop'),(52,'backOfficeFooter','displayBackOfficeFooter'),(53,'deleteProductAttribute','actionProductAttributeDelete'),(54,'processCarrier','actionCarrierProcess'),(55,'orderDetail','actionOrderDetail'),(56,'beforeCarrier','displayBeforeCarrier'),(57,'orderDetailDisplayed','displayOrderDetail'),(58,'paymentCCAdded','actionPaymentCCAdd'),(59,'extraProductComparison','displayProductComparison'),(60,'categoryAddition','actionCategoryAdd'),(61,'categoryUpdate','actionCategoryUpdate'),(62,'categoryDeletion','actionCategoryDelete'),(63,'beforeAuthentication','actionBeforeAuthentication'),(64,'paymentTop','displayPaymentTop'),(65,'afterCreateHtaccess','actionHtaccessCreate'),(66,'afterSaveAdminMeta','actionAdminMetaSave'),(67,'attributeGroupForm','displayAttributeGroupForm'),(68,'afterSaveAttributeGroup','actionAttributeGroupSave'),(69,'afterDeleteAttributeGroup','actionAttributeGroupDelete'),(70,'featureForm','displayFeatureForm'),(71,'afterSaveFeature','actionFeatureSave'),(72,'afterDeleteFeature','actionFeatureDelete'),(73,'afterSaveProduct','actionProductSave'),(74,'productListAssign','actionProductListOverride'),(75,'postProcessAttributeGroup','displayAttributeGroupPostProcess'),(76,'postProcessFeature','displayFeaturePostProcess'),(77,'featureValueForm','displayFeatureValueForm'),(78,'postProcessFeatureValue','displayFeatureValuePostProcess'),(79,'afterDeleteFeatureValue','actionFeatureValueDelete'),(80,'afterSaveFeatureValue','actionFeatureValueSave'),(81,'attributeForm','displayAttributeForm'),(82,'postProcessAttribute','actionAttributePostProcess'),(83,'afterDeleteAttribute','actionAttributeDelete'),(84,'afterSaveAttribute','actionAttributeSave'),(85,'taxManager','actionTaxManager'),(86,'myAccountBlock','displayMyAccountBlock');
/*!40000 ALTER TABLE `ps_hook_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_hook_module`
--

DROP TABLE IF EXISTS `ps_hook_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_hook_module` (
                                `id_module` int(10) unsigned NOT NULL,
                                `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                `id_hook` int(10) unsigned NOT NULL,
                                `position` tinyint(2) unsigned NOT NULL,
                                PRIMARY KEY (`id_module`,`id_hook`,`id_shop`),
                                KEY `id_hook` (`id_hook`),
                                KEY `id_module` (`id_module`),
                                KEY `position` (`id_shop`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_hook_module`
--

LOCK TABLES `ps_hook_module` WRITE;
/*!40000 ALTER TABLE `ps_hook_module` DISABLE KEYS */;
INSERT INTO `ps_hook_module` VALUES (1,1,10,1),(1,1,16,1),(1,1,108,1),(1,1,109,1),(1,1,110,1),(1,1,111,1),(2,1,112,1),(2,1,113,1),(3,1,5,1),(3,1,114,1),(4,1,8,1),(4,1,13,1),(4,1,14,1),(4,1,17,1),(4,1,55,1),(5,1,115,1),(7,1,67,1),(7,1,68,1),(7,1,69,1),(7,1,99,1),(7,1,116,1),(7,1,117,1),(11,1,74,1),(11,1,75,1),(11,1,76,1),(11,1,77,1),(11,1,78,1),(11,1,79,1),(11,1,80,1),(11,1,81,1),(11,1,82,1),(11,1,83,1),(11,1,84,1),(11,1,85,1),(11,1,86,1),(11,1,87,1),(11,1,88,1),(11,1,89,1),(11,1,90,1),(11,1,91,1),(12,1,118,1),(12,1,119,1),(12,1,120,1),(12,1,121,1),(16,1,122,1),(16,1,123,1),(16,1,124,1),(17,1,126,1),(17,1,127,1),(19,1,96,1),(19,1,97,1),(20,1,26,1),(20,1,31,1),(20,1,129,1),(20,1,130,1),(20,1,131,1),(22,1,15,1),(22,1,132,1),(22,1,133,1),(25,1,134,1),(25,1,135,1),(25,1,136,1),(27,1,137,1),(27,1,138,1),(27,1,139,1),(27,1,140,1),(27,1,141,1),(28,1,101,1),(31,1,143,1),(31,1,144,1),(31,1,145,1),(31,1,146,1),(31,1,147,1),(31,1,148,1),(31,1,149,1),(32,1,150,1),(34,1,52,1),(35,1,40,1),(36,1,44,1),(37,1,98,1),(40,1,39,1),(50,1,12,1),(63,1,9,1),(63,1,57,1),(65,1,58,1),(66,1,142,1),(67,1,1,1),(67,1,30,1),(67,1,64,1),(67,1,71,1),(67,1,151,1),(67,1,152,1),(67,1,153,1),(67,1,154,1),(67,1,155,1),(67,1,156,1),(67,1,157,1),(67,1,158,1),(67,1,159,1),(67,1,160,1),(67,1,161,1),(67,1,162,1),(69,1,163,1),(69,1,164,1),(69,1,165,1),(69,1,166,1),(69,1,167,1),(69,1,168,1),(69,1,169,1),(69,1,170,1),(69,1,171,1),(69,1,172,1),(69,1,173,1),(69,1,174,1),(69,1,175,1),(69,1,176,1),(69,1,177,1),(69,1,178,1),(69,1,179,1),(69,1,180,1),(69,1,181,1),(69,1,182,1),(69,1,183,1),(69,1,184,1),(69,1,185,1),(69,1,186,1),(69,1,187,1),(69,1,188,1),(69,1,189,1),(69,1,190,1),(69,1,191,1),(69,1,192,1),(69,1,193,1),(69,1,194,1),(69,1,195,1),(69,1,196,1),(69,1,197,1),(69,1,198,1),(69,1,199,1),(69,1,200,1),(69,1,201,1),(69,1,202,1),(69,1,203,1),(69,1,204,1),(69,1,205,1),(69,1,206,1),(69,1,207,1),(69,1,208,1),(69,1,209,1),(69,1,210,1),(2,1,10,2),(3,1,1,2),(5,1,15,2),(6,1,26,2),(7,1,8,2),(8,1,101,2),(9,1,9,2),(11,1,67,2),(11,1,68,2),(11,1,69,2),(18,1,126,2),(18,1,127,2),(19,1,13,2),(19,1,14,2),(19,1,17,2),(27,1,108,2),(27,1,109,2),(27,1,118,2),(27,1,119,2),(27,1,120,2),(27,1,122,2),(27,1,123,2),(27,1,124,2),(27,1,134,2),(27,1,135,2),(27,1,136,2),(30,1,5,2),(30,1,114,2),(31,1,142,2),(32,1,55,2),(32,1,143,2),(32,1,149,2),(33,1,150,2),(34,1,144,2),(38,1,96,2),(38,1,97,2),(39,1,42,2),(41,1,39,2),(50,1,31,2),(60,1,52,2),(63,1,98,2),(63,1,113,2),(64,1,57,2),(69,1,137,2),(69,1,138,2),(69,1,139,2),(69,1,141,2),(69,1,145,2),(4,1,10,3),(4,1,96,3),(4,1,97,3),(7,1,26,3),(10,1,101,3),(11,1,8,3),(13,1,9,3),(23,1,13,3),(23,1,14,3),(23,1,17,3),(23,1,96,3),(23,1,97,3),(27,1,15,3),(27,1,68,3),(30,1,1,3),(33,1,143,3),(33,1,149,3),(34,1,150,3),(37,1,120,3),(42,1,39,3),(67,1,5,3),(69,1,108,3),(69,1,109,3),(69,1,113,3),(69,1,122,3),(69,1,123,3),(69,1,124,3),(69,1,134,3),(69,1,135,3),(69,1,136,3),(69,1,144,3),(5,1,10,4),(12,1,8,4),(12,1,26,4),(14,1,101,4),(26,1,13,4),(26,1,14,4),(26,1,17,4),(28,1,15,4),(34,1,143,4),(35,1,149,4),(38,1,68,4),(43,1,39,4),(6,1,10,5),(16,1,8,5),(18,1,26,5),(38,1,13,5),(38,1,14,5),(38,1,17,5),(40,1,15,5),(44,1,39,5),(64,1,149,5),(7,1,10,6),(15,1,26,6),(17,1,8,6),(41,1,15,6),(45,1,39,6),(65,1,149,6),(8,1,10,7),(19,1,8,7),(46,1,39,7),(50,1,26,7),(67,1,149,7),(9,1,10,8),(21,1,8,8),(47,1,39,8),(63,1,26,8),(10,1,10,9),(23,1,8,9),(48,1,39,9),(11,1,10,10),(24,1,8,10),(49,1,39,10),(12,1,10,11),(25,1,8,11),(51,1,39,11),(14,1,10,12),(26,1,8,12),(52,1,39,12),(15,1,10,13),(29,1,8,13),(53,1,39,13),(16,1,10,14),(54,1,39,14),(63,1,8,14),(17,1,10,15),(55,1,39,15),(18,1,10,16),(56,1,39,16),(19,1,10,17),(57,1,39,17),(20,1,10,18),(58,1,39,18),(21,1,10,19),(59,1,39,19),(22,1,10,20),(60,1,39,20),(23,1,10,21),(61,1,39,21),(24,1,10,22),(62,1,39,22),(25,1,10,23),(26,1,10,24),(27,1,10,25),(28,1,10,26),(29,1,10,27),(37,1,10,28),(38,1,10,29),(39,1,10,30),(63,1,10,31);
/*!40000 ALTER TABLE `ps_hook_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_hook_module_exceptions`
--

DROP TABLE IF EXISTS `ps_hook_module_exceptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_hook_module_exceptions` (
                                           `id_hook_module_exceptions` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                           `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                           `id_module` int(10) unsigned NOT NULL,
                                           `id_hook` int(10) unsigned NOT NULL,
                                           `file_name` varchar(255) DEFAULT NULL,
                                           PRIMARY KEY (`id_hook_module_exceptions`),
                                           KEY `id_module` (`id_module`),
                                           KEY `id_hook` (`id_hook`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_hook_module_exceptions`
--

LOCK TABLES `ps_hook_module_exceptions` WRITE;
/*!40000 ALTER TABLE `ps_hook_module_exceptions` DISABLE KEYS */;
INSERT INTO `ps_hook_module_exceptions` VALUES (1,1,4,8,'category'),(2,1,16,8,'category'),(3,1,17,8,'category'),(4,1,21,8,'category'),(5,1,25,8,'category');
/*!40000 ALTER TABLE `ps_hook_module_exceptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_image`
--

DROP TABLE IF EXISTS `ps_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_image` (
                          `id_image` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `id_product` int(10) unsigned NOT NULL,
                          `position` smallint(2) unsigned NOT NULL DEFAULT 0,
                          `cover` tinyint(1) unsigned DEFAULT NULL,
                          PRIMARY KEY (`id_image`),
                          UNIQUE KEY `id_product_cover` (`id_product`,`cover`),
                          UNIQUE KEY `idx_product_image` (`id_image`,`id_product`,`cover`),
                          KEY `image_product` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_image`
--

LOCK TABLES `ps_image` WRITE;
/*!40000 ALTER TABLE `ps_image` DISABLE KEYS */;
INSERT INTO `ps_image` VALUES (1,1,1,1),(2,1,2,NULL),(3,1,3,NULL),(4,1,4,NULL),(5,2,1,NULL),(6,2,2,NULL),(7,2,3,1),(8,3,1,1),(9,3,2,NULL),(10,4,1,1),(11,4,2,NULL),(12,5,1,1),(13,5,2,NULL),(14,5,3,NULL),(15,5,4,NULL),(16,6,1,1),(17,6,2,NULL),(18,6,3,NULL),(19,6,4,NULL),(20,7,1,1),(21,7,2,NULL),(22,7,3,NULL),(23,7,4,NULL);
/*!40000 ALTER TABLE `ps_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_image_lang`
--

DROP TABLE IF EXISTS `ps_image_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_image_lang` (
                               `id_image` int(10) unsigned NOT NULL,
                               `id_lang` int(10) unsigned NOT NULL,
                               `legend` varchar(128) DEFAULT NULL,
                               PRIMARY KEY (`id_image`,`id_lang`),
                               KEY `id_image` (`id_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_image_lang`
--

LOCK TABLES `ps_image_lang` WRITE;
/*!40000 ALTER TABLE `ps_image_lang` DISABLE KEYS */;
INSERT INTO `ps_image_lang` VALUES (1,1,''),(2,1,''),(3,1,''),(4,1,''),(5,1,''),(6,1,''),(7,1,''),(8,1,''),(9,1,''),(10,1,''),(11,1,''),(12,1,''),(13,1,''),(14,1,''),(15,1,''),(16,1,''),(17,1,''),(18,1,''),(19,1,''),(20,1,''),(21,1,''),(22,1,''),(23,1,'');
/*!40000 ALTER TABLE `ps_image_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_image_shop`
--

DROP TABLE IF EXISTS `ps_image_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_image_shop` (
                               `id_product` int(10) unsigned NOT NULL,
                               `id_image` int(11) unsigned NOT NULL,
                               `id_shop` int(11) unsigned NOT NULL,
                               `cover` tinyint(1) unsigned DEFAULT NULL,
                               PRIMARY KEY (`id_image`,`id_shop`),
                               UNIQUE KEY `id_product` (`id_product`,`id_shop`,`cover`),
                               KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_image_shop`
--

LOCK TABLES `ps_image_shop` WRITE;
/*!40000 ALTER TABLE `ps_image_shop` DISABLE KEYS */;
INSERT INTO `ps_image_shop` VALUES (1,2,1,NULL),(1,3,1,NULL),(1,4,1,NULL),(1,1,1,1),(2,5,1,NULL),(2,6,1,NULL),(2,7,1,1),(3,9,1,NULL),(3,8,1,1),(4,11,1,NULL),(4,10,1,1),(5,13,1,NULL),(5,14,1,NULL),(5,15,1,NULL),(5,12,1,1),(6,17,1,NULL),(6,18,1,NULL),(6,19,1,NULL),(6,16,1,1),(7,21,1,NULL),(7,22,1,NULL),(7,23,1,NULL),(7,20,1,1);
/*!40000 ALTER TABLE `ps_image_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_image_type`
--

DROP TABLE IF EXISTS `ps_image_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_image_type` (
                               `id_image_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `name` varchar(64) NOT NULL,
                               `width` int(10) unsigned NOT NULL,
                               `height` int(10) unsigned NOT NULL,
                               `products` tinyint(1) NOT NULL DEFAULT 1,
                               `categories` tinyint(1) NOT NULL DEFAULT 1,
                               `manufacturers` tinyint(1) NOT NULL DEFAULT 1,
                               `suppliers` tinyint(1) NOT NULL DEFAULT 1,
                               `scenes` tinyint(1) NOT NULL DEFAULT 1,
                               `stores` tinyint(1) NOT NULL DEFAULT 1,
                               PRIMARY KEY (`id_image_type`),
                               KEY `image_type_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_image_type`
--

LOCK TABLES `ps_image_type` WRITE;
/*!40000 ALTER TABLE `ps_image_type` DISABLE KEYS */;
INSERT INTO `ps_image_type` VALUES (1,'cart_default',80,80,1,0,0,0,0,0),(2,'small_default',98,98,1,0,1,1,0,0),(3,'medium_default',125,125,1,1,1,1,0,1),(4,'home_default',250,250,1,0,0,0,0,0),(5,'large_default',458,458,1,0,1,1,0,0),(6,'thickbox_default',800,800,1,0,0,0,0,0),(7,'category_default',870,217,0,1,0,0,0,0),(8,'scene_default',870,270,0,0,0,0,1,0),(9,'m_scene_default',161,58,0,0,0,0,1,0);
/*!40000 ALTER TABLE `ps_image_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_import_match`
--

DROP TABLE IF EXISTS `ps_import_match`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_import_match` (
                                 `id_import_match` int(10) NOT NULL AUTO_INCREMENT,
                                 `name` varchar(32) NOT NULL,
                                 `match` text NOT NULL,
                                 `skip` int(2) NOT NULL,
                                 PRIMARY KEY (`id_import_match`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_import_match`
--

LOCK TABLES `ps_import_match` WRITE;
/*!40000 ALTER TABLE `ps_import_match` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_import_match` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_info`
--

DROP TABLE IF EXISTS `ps_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_info` (
                         `id_info` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `id_shop` int(10) unsigned DEFAULT NULL,
                         PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_info`
--

LOCK TABLES `ps_info` WRITE;
/*!40000 ALTER TABLE `ps_info` DISABLE KEYS */;
INSERT INTO `ps_info` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `ps_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_info_lang`
--

DROP TABLE IF EXISTS `ps_info_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_info_lang` (
                              `id_info` int(10) unsigned NOT NULL,
                              `id_lang` int(10) unsigned NOT NULL,
                              `text` text NOT NULL,
                              PRIMARY KEY (`id_info`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_info_lang`
--

LOCK TABLES `ps_info_lang` WRITE;
/*!40000 ALTER TABLE `ps_info_lang` DISABLE KEYS */;
INSERT INTO `ps_info_lang` VALUES (1,1,'<ul>\n<li><em class=\"icon-truck\" id=\"icon-truck\"></em>\n<div class=\"type-text\">\n<h3>Lorem Ipsum</h3>\n<p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolore eu</p>\n</div>\n</li>\n<li><em class=\"icon-phone\" id=\"icon-phone\"></em>\n<div class=\"type-text\">\n<h3>Dolor Sit Amet</h3>\n<p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolore eu</p>\n</div>\n</li>\n<li><em class=\"icon-credit-card\" id=\"icon-credit-card\"></em>\n<div class=\"type-text\">\n<h3>Ctetur Voluptate</h3>\n<p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolore eu</p>\n</div>\n</li>\n</ul>'),(2,1,'<h3>Custom Block</h3>\n<p><strong class=\"dark\">Lorem ipsum dolor sit amet conse ctetu</strong></p>\n<p>Sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>');
/*!40000 ALTER TABLE `ps_info_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_lang`
--

DROP TABLE IF EXISTS `ps_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_lang` (
                         `id_lang` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(32) NOT NULL,
                         `active` tinyint(3) unsigned NOT NULL DEFAULT 0,
                         `iso_code` char(2) NOT NULL,
                         `language_code` char(5) NOT NULL,
                         `date_format_lite` char(32) NOT NULL DEFAULT 'Y-m-d',
                         `date_format_full` char(32) NOT NULL DEFAULT 'Y-m-d H:i:s',
                         `is_rtl` tinyint(1) NOT NULL DEFAULT 0,
                         PRIMARY KEY (`id_lang`),
                         KEY `lang_iso_code` (`iso_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_lang`
--

LOCK TABLES `ps_lang` WRITE;
/*!40000 ALTER TABLE `ps_lang` DISABLE KEYS */;
INSERT INTO `ps_lang` VALUES (1,'English (English)',1,'en','en-us','m/d/Y','m/d/Y H:i:s',0);
/*!40000 ALTER TABLE `ps_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_lang_shop`
--

DROP TABLE IF EXISTS `ps_lang_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_lang_shop` (
                              `id_lang` int(11) unsigned NOT NULL,
                              `id_shop` int(11) unsigned NOT NULL,
                              PRIMARY KEY (`id_lang`,`id_shop`),
                              KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_lang_shop`
--

LOCK TABLES `ps_lang_shop` WRITE;
/*!40000 ALTER TABLE `ps_lang_shop` DISABLE KEYS */;
INSERT INTO `ps_lang_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_lang_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_category`
--

DROP TABLE IF EXISTS `ps_layered_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_category` (
                                     `id_layered_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `id_shop` int(11) unsigned NOT NULL,
                                     `id_category` int(10) unsigned NOT NULL,
                                     `id_value` int(10) unsigned DEFAULT 0,
                                     `type` enum('category','id_feature','id_attribute_group','quantity','condition','manufacturer','weight','price') NOT NULL,
                                     `position` int(10) unsigned NOT NULL,
                                     `filter_type` int(10) unsigned NOT NULL DEFAULT 0,
                                     `filter_show_limit` int(10) unsigned NOT NULL DEFAULT 0,
                                     PRIMARY KEY (`id_layered_category`),
                                     KEY `id_category` (`id_category`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_category`
--

LOCK TABLES `ps_layered_category` WRITE;
/*!40000 ALTER TABLE `ps_layered_category` DISABLE KEYS */;
INSERT INTO `ps_layered_category` VALUES (1,1,2,NULL,'category',1,0,0),(2,1,2,1,'id_attribute_group',2,0,0),(3,1,2,3,'id_attribute_group',3,0,0),(4,1,2,5,'id_feature',4,0,0),(5,1,2,6,'id_feature',5,0,0),(6,1,2,7,'id_feature',6,0,0),(7,1,2,NULL,'quantity',7,0,0),(8,1,2,NULL,'manufacturer',8,0,0),(9,1,2,NULL,'condition',9,0,0),(10,1,2,NULL,'weight',10,0,0),(11,1,2,NULL,'price',11,0,0),(12,1,3,NULL,'category',1,0,0),(13,1,3,1,'id_attribute_group',2,0,0),(14,1,3,3,'id_attribute_group',3,0,0),(15,1,3,5,'id_feature',4,0,0),(16,1,3,6,'id_feature',5,0,0),(17,1,3,7,'id_feature',6,0,0),(18,1,3,NULL,'quantity',7,0,0),(19,1,3,NULL,'manufacturer',8,0,0),(20,1,3,NULL,'condition',9,0,0),(21,1,3,NULL,'weight',10,0,0),(22,1,3,NULL,'price',11,0,0),(23,1,4,NULL,'category',1,0,0),(24,1,4,1,'id_attribute_group',2,0,0),(25,1,4,3,'id_attribute_group',3,0,0),(26,1,4,5,'id_feature',4,0,0),(27,1,4,6,'id_feature',5,0,0),(28,1,4,7,'id_feature',6,0,0),(29,1,4,NULL,'quantity',7,0,0),(30,1,4,NULL,'manufacturer',8,0,0),(31,1,4,NULL,'condition',9,0,0),(32,1,4,NULL,'weight',10,0,0),(33,1,4,NULL,'price',11,0,0),(34,1,5,NULL,'category',1,0,0),(35,1,5,1,'id_attribute_group',2,0,0),(36,1,5,3,'id_attribute_group',3,0,0),(37,1,5,5,'id_feature',4,0,0),(38,1,5,6,'id_feature',5,0,0),(39,1,5,7,'id_feature',6,0,0),(40,1,5,NULL,'quantity',7,0,0),(41,1,5,NULL,'manufacturer',8,0,0),(42,1,5,NULL,'condition',9,0,0),(43,1,5,NULL,'weight',10,0,0),(44,1,5,NULL,'price',11,0,0),(45,1,7,NULL,'category',1,0,0),(46,1,7,1,'id_attribute_group',2,0,0),(47,1,7,3,'id_attribute_group',3,0,0),(48,1,7,5,'id_feature',4,0,0),(49,1,7,6,'id_feature',5,0,0),(50,1,7,7,'id_feature',6,0,0),(51,1,7,NULL,'quantity',7,0,0),(52,1,7,NULL,'manufacturer',8,0,0),(53,1,7,NULL,'condition',9,0,0),(54,1,7,NULL,'weight',10,0,0),(55,1,7,NULL,'price',11,0,0),(56,1,8,NULL,'category',1,0,0),(57,1,8,1,'id_attribute_group',2,0,0),(58,1,8,3,'id_attribute_group',3,0,0),(59,1,8,5,'id_feature',4,0,0),(60,1,8,6,'id_feature',5,0,0),(61,1,8,7,'id_feature',6,0,0),(62,1,8,NULL,'quantity',7,0,0),(63,1,8,NULL,'manufacturer',8,0,0),(64,1,8,NULL,'condition',9,0,0),(65,1,8,NULL,'weight',10,0,0),(66,1,8,NULL,'price',11,0,0),(67,1,9,NULL,'category',1,0,0),(68,1,9,1,'id_attribute_group',2,0,0),(69,1,9,3,'id_attribute_group',3,0,0),(70,1,9,5,'id_feature',4,0,0),(71,1,9,6,'id_feature',5,0,0),(72,1,9,7,'id_feature',6,0,0),(73,1,9,NULL,'quantity',7,0,0),(74,1,9,NULL,'manufacturer',8,0,0),(75,1,9,NULL,'condition',9,0,0),(76,1,9,NULL,'weight',10,0,0),(77,1,9,NULL,'price',11,0,0),(78,1,10,NULL,'category',1,0,0),(79,1,10,1,'id_attribute_group',2,0,0),(80,1,10,3,'id_attribute_group',3,0,0),(81,1,10,5,'id_feature',4,0,0),(82,1,10,6,'id_feature',5,0,0),(83,1,10,7,'id_feature',6,0,0),(84,1,10,NULL,'quantity',7,0,0),(85,1,10,NULL,'manufacturer',8,0,0),(86,1,10,NULL,'condition',9,0,0),(87,1,10,NULL,'weight',10,0,0),(88,1,10,NULL,'price',11,0,0),(89,1,11,NULL,'category',1,0,0),(90,1,11,1,'id_attribute_group',2,0,0),(91,1,11,3,'id_attribute_group',3,0,0),(92,1,11,5,'id_feature',4,0,0),(93,1,11,6,'id_feature',5,0,0),(94,1,11,7,'id_feature',6,0,0),(95,1,11,NULL,'quantity',7,0,0),(96,1,11,NULL,'manufacturer',8,0,0),(97,1,11,NULL,'condition',9,0,0),(98,1,11,NULL,'weight',10,0,0),(99,1,11,NULL,'price',11,0,0);
/*!40000 ALTER TABLE `ps_layered_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_filter`
--

DROP TABLE IF EXISTS `ps_layered_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_filter` (
                                   `id_layered_filter` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                   `name` varchar(64) NOT NULL,
                                   `filters` text DEFAULT NULL,
                                   `n_categories` int(10) unsigned NOT NULL,
                                   `date_add` datetime NOT NULL,
                                   PRIMARY KEY (`id_layered_filter`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_filter`
--

LOCK TABLES `ps_layered_filter` WRITE;
/*!40000 ALTER TABLE `ps_layered_filter` DISABLE KEYS */;
INSERT INTO `ps_layered_filter` VALUES (1,'My template 2025-03-04','a:13:{s:10:\"categories\";a:9:{i:0;i:2;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:7;i:5;i:8;i:6;i:9;i:7;i:10;i:8;i:11;}s:9:\"shop_list\";a:1:{i:1;i:1;}s:31:\"layered_selection_subcategories\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:22:\"layered_selection_ag_1\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:22:\"layered_selection_ag_3\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:24:\"layered_selection_feat_5\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:24:\"layered_selection_feat_6\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:24:\"layered_selection_feat_7\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:23:\"layered_selection_stock\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:30:\"layered_selection_manufacturer\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:27:\"layered_selection_condition\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:31:\"layered_selection_weight_slider\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}s:30:\"layered_selection_price_slider\";a:2:{s:11:\"filter_type\";i:0;s:17:\"filter_show_limit\";i:0;}}',9,'2025-03-04 07:13:16');
/*!40000 ALTER TABLE `ps_layered_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_filter_shop`
--

DROP TABLE IF EXISTS `ps_layered_filter_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_filter_shop` (
                                        `id_layered_filter` int(10) unsigned NOT NULL,
                                        `id_shop` int(11) unsigned NOT NULL,
                                        PRIMARY KEY (`id_layered_filter`,`id_shop`),
                                        KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_filter_shop`
--

LOCK TABLES `ps_layered_filter_shop` WRITE;
/*!40000 ALTER TABLE `ps_layered_filter_shop` DISABLE KEYS */;
INSERT INTO `ps_layered_filter_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_layered_filter_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_friendly_url`
--

DROP TABLE IF EXISTS `ps_layered_friendly_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_friendly_url` (
                                         `id_layered_friendly_url` int(11) NOT NULL AUTO_INCREMENT,
                                         `url_key` varchar(32) NOT NULL,
                                         `data` varchar(200) NOT NULL,
                                         `id_lang` int(11) NOT NULL,
                                         PRIMARY KEY (`id_layered_friendly_url`),
                                         KEY `id_lang` (`id_lang`),
                                         KEY `url_key` (`url_key`(5))
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_friendly_url`
--

LOCK TABLES `ps_layered_friendly_url` WRITE;
/*!40000 ALTER TABLE `ps_layered_friendly_url` DISABLE KEYS */;
INSERT INTO `ps_layered_friendly_url` VALUES (1,'03c8c4cf29ea8a405778f138021df5df','a:1:{s:8:\"category\";a:1:{i:7;s:1:\"7\";}}',1),(2,'2def08957abfc829e80d5279c5086b73','a:1:{s:8:\"category\";a:1:{i:9;s:1:\"9\";}}',1),(3,'eaaa28d2b62b097bb8706dd014c8203b','a:1:{s:8:\"category\";a:1:{i:8;s:1:\"8\";}}',1),(4,'84ce4d36b2b77bb85d2a7aebd27c8a67','a:1:{s:8:\"category\";a:1:{i:10;s:2:\"10\";}}',1),(5,'e22ad4e9f8f445df1283ec3383c55ed8','a:1:{s:8:\"category\";a:1:{i:2;s:1:\"2\";}}',1),(6,'3f1005f8be7881795fc5feddfdba756f','a:1:{s:8:\"category\";a:1:{i:1;s:1:\"1\";}}',1),(7,'3f9036e3dcf0507782e3d6a1d3ca1fe1','a:1:{s:8:\"category\";a:1:{i:11;s:2:\"11\";}}',1),(8,'6fc253242f3fe98946ecdd26762e95eb','a:1:{s:8:\"category\";a:1:{i:5;s:1:\"5\";}}',1),(9,'c66ef06ef2ca8b06dd3d19b70727adb7','a:1:{s:8:\"category\";a:1:{i:4;s:1:\"4\";}}',1),(10,'929674e49248753da273092629bb45ec','a:1:{s:8:\"category\";a:1:{i:3;s:1:\"3\";}}',1),(11,'c4d7335317f2f1ba381e038fb625d918','a:1:{s:10:\"id_feature\";a:1:{i:1;s:3:\"5_1\";}}',1),(12,'18f41c9cab1c150e429f1b670cae3bc1','a:1:{s:10:\"id_feature\";a:1:{i:2;s:3:\"5_2\";}}',1),(13,'823192a052e44927f06b39b32bcef002','a:1:{s:10:\"id_feature\";a:1:{i:3;s:3:\"5_3\";}}',1),(14,'905fe5b57eb2e1353911171da4ee7706','a:1:{s:10:\"id_feature\";a:1:{i:4;s:3:\"5_4\";}}',1),(15,'ebb42f1bbf0d25b40049c14f1860b952','a:1:{s:10:\"id_feature\";a:1:{i:5;s:3:\"5_5\";}}',1),(16,'f9a71edd8befbb99baceadc2b2fbe793','a:1:{s:10:\"id_feature\";a:1:{i:6;s:3:\"5_6\";}}',1),(17,'e195459fb3d97a32e94673db75dcf299','a:1:{s:10:\"id_feature\";a:1:{i:7;s:3:\"5_7\";}}',1),(18,'b7783cae5eeefc81ff4a69f4ea712ea7','a:1:{s:10:\"id_feature\";a:1:{i:8;s:3:\"5_8\";}}',1),(19,'45f1d9162a9fe2ffcf9f365eace9eeec','a:1:{s:10:\"id_feature\";a:1:{i:9;s:3:\"5_9\";}}',1),(20,'7a04872959f09781f3b883a91c5332c7','a:1:{s:10:\"id_feature\";a:1:{i:10;s:4:\"6_10\";}}',1),(21,'025d11eb379709c8e409a7d712d8e362','a:1:{s:10:\"id_feature\";a:1:{i:11;s:4:\"6_11\";}}',1),(22,'e224c427b75f7805c14e8b63ca9e4e0c','a:1:{s:10:\"id_feature\";a:1:{i:12;s:4:\"6_12\";}}',1),(23,'677717092975926de02151dd9227864e','a:1:{s:10:\"id_feature\";a:1:{i:13;s:4:\"6_13\";}}',1),(24,'00dff7b63b6f7ddb4b341a9308422730','a:1:{s:10:\"id_feature\";a:1:{i:14;s:4:\"6_14\";}}',1),(25,'ff721a9727728b15cd4654a462aaeea0','a:1:{s:10:\"id_feature\";a:1:{i:15;s:4:\"6_15\";}}',1),(26,'0327a5c6fbcd99ae1fa8ef01f1e7e100','a:1:{s:10:\"id_feature\";a:1:{i:16;s:4:\"6_16\";}}',1),(27,'58ddd7a988c042c25121ffeb149f3ac7','a:1:{s:10:\"id_feature\";a:1:{i:17;s:4:\"7_17\";}}',1),(28,'b7248af6c62c1e54b6f13739739e2d17','a:1:{s:10:\"id_feature\";a:1:{i:18;s:4:\"7_18\";}}',1),(29,'b97d201e9d169f46c2a9e6fa356e40d2','a:1:{s:10:\"id_feature\";a:1:{i:19;s:4:\"7_19\";}}',1),(30,'de50b73f078d5cde7cc9d8efc61c9e55','a:1:{s:10:\"id_feature\";a:1:{i:20;s:4:\"7_20\";}}',1),(31,'85a3c64761151fe72e5d027e729072a3','a:1:{s:10:\"id_feature\";a:1:{i:21;s:4:\"7_21\";}}',1),(32,'97d9dd08827238b39342d37e16ee7fc3','a:1:{s:18:\"id_attribute_group\";a:1:{i:1;s:3:\"1_1\";}}',1),(33,'2f3d5048a6335cac20241e0f8cb5294e','a:1:{s:18:\"id_attribute_group\";a:1:{i:2;s:3:\"1_2\";}}',1),(34,'19819345209f29bb2865355fa2cdb800','a:1:{s:18:\"id_attribute_group\";a:1:{i:3;s:3:\"1_3\";}}',1),(35,'27dd5799da96500f9e0ab61387a556b5','a:1:{s:18:\"id_attribute_group\";a:1:{i:4;s:3:\"1_4\";}}',1),(36,'6a73ce72468db97129f092fa3d9a0b2e','a:1:{s:18:\"id_attribute_group\";a:1:{i:5;s:3:\"3_5\";}}',1),(37,'f1fc935c7d64dfac606eb814dcc6c4a7','a:1:{s:18:\"id_attribute_group\";a:1:{i:6;s:3:\"3_6\";}}',1),(38,'f036e061c6e0e9cd6b3c463f72f524a5','a:1:{s:18:\"id_attribute_group\";a:1:{i:7;s:3:\"3_7\";}}',1),(39,'468a278b79ece55c0ed0d3bd1b2dd01f','a:1:{s:18:\"id_attribute_group\";a:1:{i:8;s:3:\"3_8\";}}',1),(40,'8996dbd99c9d2240f117ba0d26b39b10','a:1:{s:18:\"id_attribute_group\";a:1:{i:9;s:3:\"3_9\";}}',1),(41,'601a4dd13077730810f102b18680b537','a:1:{s:18:\"id_attribute_group\";a:1:{i:10;s:4:\"3_10\";}}',1),(42,'0a68b3ba0819d7126935f51335ef9503','a:1:{s:18:\"id_attribute_group\";a:1:{i:11;s:4:\"3_11\";}}',1),(43,'5f556205d67d7c26c2726dba638c2d95','a:1:{s:18:\"id_attribute_group\";a:1:{i:12;s:4:\"3_12\";}}',1),(44,'4b4bb79b20455e8047c972f9ca69cd72','a:1:{s:18:\"id_attribute_group\";a:1:{i:13;s:4:\"3_13\";}}',1),(45,'54dd539ce8bbf02b44485941f2d8d80b','a:1:{s:18:\"id_attribute_group\";a:1:{i:14;s:4:\"3_14\";}}',1),(46,'73b845a28e9ced9709fa414f9b97dae9','a:1:{s:18:\"id_attribute_group\";a:1:{i:15;s:4:\"3_15\";}}',1),(47,'be50cfae4c360fdb124af017a4e80905','a:1:{s:18:\"id_attribute_group\";a:1:{i:16;s:4:\"3_16\";}}',1),(48,'4c4550abfc4eec4c91e558fa9b5171c9','a:1:{s:18:\"id_attribute_group\";a:1:{i:17;s:4:\"3_17\";}}',1),(49,'ab223cc0ca7ebf34af71e067556ee2aa','a:1:{s:18:\"id_attribute_group\";a:1:{i:24;s:4:\"3_24\";}}',1),(50,'14ef3952eddf958ec1f628065f6c7689','a:1:{s:8:\"quantity\";a:1:{i:0;i:0;}}',1),(51,'19e5bdea58716c8f3ff52345d1b5a442','a:1:{s:8:\"quantity\";a:1:{i:0;i:1;}}',1),(52,'11c2881845b925423888cd329d0c4953','a:1:{s:9:\"condition\";a:1:{s:3:\"new\";s:3:\"new\";}}',1),(53,'074755ccbf623ca666bd866203d0dec7','a:1:{s:9:\"condition\";a:1:{s:4:\"used\";s:4:\"used\";}}',1),(54,'70b63b881a45f66c86ea78ace4cfb6a7','a:1:{s:9:\"condition\";a:1:{s:11:\"refurbished\";s:11:\"refurbished\";}}',1),(55,'7b51d2594a28b8f82cfe82b0c3f161e7','a:1:{s:12:\"manufacturer\";a:1:{i:1;s:1:\"1\";}}',1);
/*!40000 ALTER TABLE `ps_layered_friendly_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_attribute_group`
--

DROP TABLE IF EXISTS `ps_layered_indexable_attribute_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_attribute_group` (
                                                      `id_attribute_group` int(11) NOT NULL,
                                                      `indexable` tinyint(1) NOT NULL DEFAULT 0,
                                                      PRIMARY KEY (`id_attribute_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_attribute_group`
--

LOCK TABLES `ps_layered_indexable_attribute_group` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_group` DISABLE KEYS */;
INSERT INTO `ps_layered_indexable_attribute_group` VALUES (1,1),(2,1),(3,1);
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_attribute_group_lang_value`
--

DROP TABLE IF EXISTS `ps_layered_indexable_attribute_group_lang_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_attribute_group_lang_value` (
                                                                 `id_attribute_group` int(11) NOT NULL,
                                                                 `id_lang` int(11) NOT NULL,
                                                                 `url_name` varchar(128) DEFAULT NULL,
                                                                 `meta_title` varchar(128) DEFAULT NULL,
                                                                 PRIMARY KEY (`id_attribute_group`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_attribute_group_lang_value`
--

LOCK TABLES `ps_layered_indexable_attribute_group_lang_value` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_group_lang_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_group_lang_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_attribute_lang_value`
--

DROP TABLE IF EXISTS `ps_layered_indexable_attribute_lang_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_attribute_lang_value` (
                                                           `id_attribute` int(11) NOT NULL,
                                                           `id_lang` int(11) NOT NULL,
                                                           `url_name` varchar(128) DEFAULT NULL,
                                                           `meta_title` varchar(128) DEFAULT NULL,
                                                           PRIMARY KEY (`id_attribute`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_attribute_lang_value`
--

LOCK TABLES `ps_layered_indexable_attribute_lang_value` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_lang_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_layered_indexable_attribute_lang_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_feature`
--

DROP TABLE IF EXISTS `ps_layered_indexable_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_feature` (
                                              `id_feature` int(11) NOT NULL,
                                              `indexable` tinyint(1) NOT NULL DEFAULT 0,
                                              PRIMARY KEY (`id_feature`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_feature`
--

LOCK TABLES `ps_layered_indexable_feature` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_feature` DISABLE KEYS */;
INSERT INTO `ps_layered_indexable_feature` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1);
/*!40000 ALTER TABLE `ps_layered_indexable_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_feature_lang_value`
--

DROP TABLE IF EXISTS `ps_layered_indexable_feature_lang_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_feature_lang_value` (
                                                         `id_feature` int(11) NOT NULL,
                                                         `id_lang` int(11) NOT NULL,
                                                         `url_name` varchar(128) NOT NULL,
                                                         `meta_title` varchar(128) DEFAULT NULL,
                                                         PRIMARY KEY (`id_feature`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_feature_lang_value`
--

LOCK TABLES `ps_layered_indexable_feature_lang_value` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_feature_lang_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_layered_indexable_feature_lang_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_indexable_feature_value_lang_value`
--

DROP TABLE IF EXISTS `ps_layered_indexable_feature_value_lang_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_indexable_feature_value_lang_value` (
                                                               `id_feature_value` int(11) NOT NULL,
                                                               `id_lang` int(11) NOT NULL,
                                                               `url_name` varchar(128) DEFAULT NULL,
                                                               `meta_title` varchar(128) DEFAULT NULL,
                                                               PRIMARY KEY (`id_feature_value`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_indexable_feature_value_lang_value`
--

LOCK TABLES `ps_layered_indexable_feature_value_lang_value` WRITE;
/*!40000 ALTER TABLE `ps_layered_indexable_feature_value_lang_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_layered_indexable_feature_value_lang_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_price_index`
--

DROP TABLE IF EXISTS `ps_layered_price_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_price_index` (
                                        `id_product` int(11) NOT NULL,
                                        `id_currency` int(11) NOT NULL,
                                        `id_shop` int(11) NOT NULL,
                                        `price_min` int(11) NOT NULL,
                                        `price_max` int(11) NOT NULL,
                                        PRIMARY KEY (`id_product`,`id_currency`,`id_shop`),
                                        KEY `id_currency` (`id_currency`),
                                        KEY `price_min` (`price_min`),
                                        KEY `price_max` (`price_max`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_price_index`
--

LOCK TABLES `ps_layered_price_index` WRITE;
/*!40000 ALTER TABLE `ps_layered_price_index` DISABLE KEYS */;
INSERT INTO `ps_layered_price_index` VALUES (1,1,1,16,17),(1,2,1,17,17),(2,1,1,26,27),(2,2,1,28,28),(3,1,1,25,26),(3,2,1,27,27),(4,1,1,50,51),(4,2,1,53,53),(5,1,1,28,29),(5,2,1,30,30),(6,1,1,30,31),(6,2,1,31,32),(7,1,1,16,16),(7,2,1,17,17);
/*!40000 ALTER TABLE `ps_layered_price_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_layered_product_attribute`
--

DROP TABLE IF EXISTS `ps_layered_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_layered_product_attribute` (
                                              `id_attribute` int(10) unsigned NOT NULL,
                                              `id_product` int(10) unsigned NOT NULL,
                                              `id_attribute_group` int(10) unsigned NOT NULL DEFAULT 0,
                                              `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                              PRIMARY KEY (`id_attribute`,`id_product`,`id_shop`),
                                              UNIQUE KEY `id_attribute_group` (`id_attribute_group`,`id_attribute`,`id_product`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_layered_product_attribute`
--

LOCK TABLES `ps_layered_product_attribute` WRITE;
/*!40000 ALTER TABLE `ps_layered_product_attribute` DISABLE KEYS */;
INSERT INTO `ps_layered_product_attribute` VALUES (1,1,1,1),(1,2,1,1),(1,3,1,1),(1,4,1,1),(1,5,1,1),(1,6,1,1),(1,7,1,1),(2,1,1,1),(2,2,1,1),(2,3,1,1),(2,4,1,1),(2,5,1,1),(2,6,1,1),(2,7,1,1),(3,1,1,1),(3,2,1,1),(3,3,1,1),(3,4,1,1),(3,5,1,1),(3,6,1,1),(3,7,1,1),(7,4,3,1),(8,2,3,1),(8,6,3,1),(11,2,3,1),(11,5,3,1),(13,1,3,1),(13,3,3,1),(13,5,3,1),(14,1,3,1),(14,5,3,1),(15,7,3,1),(16,5,3,1),(16,6,3,1),(16,7,3,1),(24,4,3,1);
/*!40000 ALTER TABLE `ps_layered_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_linksmenutop`
--

DROP TABLE IF EXISTS `ps_linksmenutop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_linksmenutop` (
                                 `id_linksmenutop` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 `new_window` tinyint(1) NOT NULL,
                                 PRIMARY KEY (`id_linksmenutop`),
                                 KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_linksmenutop`
--

LOCK TABLES `ps_linksmenutop` WRITE;
/*!40000 ALTER TABLE `ps_linksmenutop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_linksmenutop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_linksmenutop_lang`
--

DROP TABLE IF EXISTS `ps_linksmenutop_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_linksmenutop_lang` (
                                      `id_linksmenutop` int(11) unsigned NOT NULL,
                                      `id_lang` int(11) unsigned NOT NULL,
                                      `id_shop` int(11) unsigned NOT NULL,
                                      `label` varchar(128) NOT NULL,
                                      `link` varchar(128) NOT NULL,
                                      KEY `id_linksmenutop` (`id_linksmenutop`,`id_lang`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_linksmenutop_lang`
--

LOCK TABLES `ps_linksmenutop_lang` WRITE;
/*!40000 ALTER TABLE `ps_linksmenutop_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_linksmenutop_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_log`
--

DROP TABLE IF EXISTS `ps_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_log` (
                        `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `severity` tinyint(1) NOT NULL,
                        `error_code` int(11) DEFAULT NULL,
                        `message` text NOT NULL,
                        `object_type` varchar(32) DEFAULT NULL,
                        `object_id` int(10) unsigned DEFAULT NULL,
                        `id_employee` int(10) unsigned DEFAULT NULL,
                        `date_add` datetime NOT NULL,
                        `date_upd` datetime NOT NULL,
                        PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_log`
--

LOCK TABLES `ps_log` WRITE;
/*!40000 ALTER TABLE `ps_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_mail`
--

DROP TABLE IF EXISTS `ps_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_mail` (
                         `id_mail` int(11) unsigned NOT NULL AUTO_INCREMENT,
                         `recipient` varchar(126) NOT NULL,
                         `template` varchar(62) NOT NULL,
                         `subject` varchar(254) NOT NULL,
                         `id_lang` int(11) unsigned NOT NULL,
                         `date_add` timestamp NOT NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id_mail`),
                         KEY `recipient` (`recipient`(10))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_mail`
--

LOCK TABLES `ps_mail` WRITE;
/*!40000 ALTER TABLE `ps_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_manufacturer`
--

DROP TABLE IF EXISTS `ps_manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_manufacturer` (
                                 `id_manufacturer` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `name` varchar(64) NOT NULL,
                                 `date_add` datetime NOT NULL,
                                 `date_upd` datetime NOT NULL,
                                 `active` tinyint(1) NOT NULL DEFAULT 0,
                                 PRIMARY KEY (`id_manufacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_manufacturer`
--

LOCK TABLES `ps_manufacturer` WRITE;
/*!40000 ALTER TABLE `ps_manufacturer` DISABLE KEYS */;
INSERT INTO `ps_manufacturer` VALUES (1,'Fashion Manufacturer','2025-03-04 08:13:15','2025-03-04 08:13:15',1);
/*!40000 ALTER TABLE `ps_manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_manufacturer_lang`
--

DROP TABLE IF EXISTS `ps_manufacturer_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_manufacturer_lang` (
                                      `id_manufacturer` int(10) unsigned NOT NULL,
                                      `id_lang` int(10) unsigned NOT NULL,
                                      `description` text DEFAULT NULL,
                                      `short_description` text DEFAULT NULL,
                                      `meta_title` varchar(128) DEFAULT NULL,
                                      `meta_keywords` varchar(255) DEFAULT NULL,
                                      `meta_description` varchar(255) DEFAULT NULL,
                                      PRIMARY KEY (`id_manufacturer`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_manufacturer_lang`
--

LOCK TABLES `ps_manufacturer_lang` WRITE;
/*!40000 ALTER TABLE `ps_manufacturer_lang` DISABLE KEYS */;
INSERT INTO `ps_manufacturer_lang` VALUES (1,1,'','','','','');
/*!40000 ALTER TABLE `ps_manufacturer_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_manufacturer_shop`
--

DROP TABLE IF EXISTS `ps_manufacturer_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_manufacturer_shop` (
                                      `id_manufacturer` int(11) unsigned NOT NULL,
                                      `id_shop` int(11) unsigned NOT NULL,
                                      PRIMARY KEY (`id_manufacturer`,`id_shop`),
                                      KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_manufacturer_shop`
--

LOCK TABLES `ps_manufacturer_shop` WRITE;
/*!40000 ALTER TABLE `ps_manufacturer_shop` DISABLE KEYS */;
INSERT INTO `ps_manufacturer_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_manufacturer_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_memcached_servers`
--

DROP TABLE IF EXISTS `ps_memcached_servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_memcached_servers` (
                                      `id_memcached_server` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                      `ip` varchar(254) NOT NULL,
                                      `port` int(11) unsigned NOT NULL,
                                      `weight` int(11) unsigned NOT NULL,
                                      PRIMARY KEY (`id_memcached_server`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_memcached_servers`
--

LOCK TABLES `ps_memcached_servers` WRITE;
/*!40000 ALTER TABLE `ps_memcached_servers` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_memcached_servers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_message`
--

DROP TABLE IF EXISTS `ps_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_message` (
                            `id_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_cart` int(10) unsigned DEFAULT NULL,
                            `id_customer` int(10) unsigned NOT NULL,
                            `id_employee` int(10) unsigned DEFAULT NULL,
                            `id_order` int(10) unsigned NOT NULL,
                            `message` text NOT NULL,
                            `private` tinyint(1) unsigned NOT NULL DEFAULT 1,
                            `date_add` datetime NOT NULL,
                            PRIMARY KEY (`id_message`),
                            KEY `message_order` (`id_order`),
                            KEY `id_cart` (`id_cart`),
                            KEY `id_customer` (`id_customer`),
                            KEY `id_employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_message`
--

LOCK TABLES `ps_message` WRITE;
/*!40000 ALTER TABLE `ps_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_message_readed`
--

DROP TABLE IF EXISTS `ps_message_readed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_message_readed` (
                                   `id_message` int(10) unsigned NOT NULL,
                                   `id_employee` int(10) unsigned NOT NULL,
                                   `date_add` datetime NOT NULL,
                                   PRIMARY KEY (`id_message`,`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_message_readed`
--

LOCK TABLES `ps_message_readed` WRITE;
/*!40000 ALTER TABLE `ps_message_readed` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_message_readed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_meta`
--

DROP TABLE IF EXISTS `ps_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_meta` (
                         `id_meta` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `page` varchar(64) NOT NULL,
                         `configurable` tinyint(1) unsigned NOT NULL DEFAULT 1,
                         PRIMARY KEY (`id_meta`),
                         UNIQUE KEY `page` (`page`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_meta`
--

LOCK TABLES `ps_meta` WRITE;
/*!40000 ALTER TABLE `ps_meta` DISABLE KEYS */;
INSERT INTO `ps_meta` VALUES (1,'pagenotfound',1),(2,'best-sales',1),(3,'contact',1),(4,'index',1),(5,'manufacturer',1),(6,'new-products',1),(7,'password',1),(8,'prices-drop',1),(9,'sitemap',1),(10,'supplier',1),(11,'address',1),(12,'addresses',1),(13,'authentication',1),(14,'cart',1),(15,'discount',1),(16,'history',1),(17,'identity',1),(18,'my-account',1),(19,'order-follow',1),(20,'order-slip',1),(21,'order',1),(22,'search',1),(23,'stores',1),(24,'order-opc',1),(25,'guest-tracking',1),(26,'order-confirmation',1),(27,'product',0),(28,'category',0),(29,'cms',0),(30,'module-cheque-payment',0),(31,'module-cheque-validation',0),(32,'module-bankwire-validation',0),(33,'module-bankwire-payment',0),(34,'module-cashondelivery-validation',0),(35,'products-comparison',1),(36,'module-blocknewsletter-verification',1);
/*!40000 ALTER TABLE `ps_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_meta_lang`
--

DROP TABLE IF EXISTS `ps_meta_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_meta_lang` (
                              `id_meta` int(10) unsigned NOT NULL,
                              `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                              `id_lang` int(10) unsigned NOT NULL,
                              `title` varchar(128) DEFAULT NULL,
                              `description` varchar(255) DEFAULT NULL,
                              `keywords` varchar(255) DEFAULT NULL,
                              `url_rewrite` varchar(254) NOT NULL,
                              PRIMARY KEY (`id_meta`,`id_shop`,`id_lang`),
                              KEY `id_shop` (`id_shop`),
                              KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_meta_lang`
--

LOCK TABLES `ps_meta_lang` WRITE;
/*!40000 ALTER TABLE `ps_meta_lang` DISABLE KEYS */;
INSERT INTO `ps_meta_lang` VALUES (1,1,1,'404 error','This page cannot be found','','page-not-found'),(2,1,1,'Best sales','Our best sales','','best-sales'),(3,1,1,'Contact us','Use our form to contact us','','contact-us'),(4,1,1,'','Shop powered by PrestaShop','',''),(5,1,1,'Manufacturers','Manufacturers list','','manufacturers'),(6,1,1,'New products','Our new products','','new-products'),(7,1,1,'Forgot your password','Enter the e-mail address you use to sign in to receive an e-mail with a new password','','password-recovery'),(8,1,1,'Prices drop','Our special products','','prices-drop'),(9,1,1,'Sitemap','Lost ? Find what your are looking for','','sitemap'),(10,1,1,'Suppliers','Suppliers list','','supplier'),(11,1,1,'Address','','','address'),(12,1,1,'Addresses','','','addresses'),(13,1,1,'Login','','','login'),(14,1,1,'Cart','','','cart'),(15,1,1,'Discount','','','discount'),(16,1,1,'Order history','','','order-history'),(17,1,1,'Identity','','','identity'),(18,1,1,'My account','','','my-account'),(19,1,1,'Order follow','','','order-follow'),(20,1,1,'Credit slip','','','credit-slip'),(21,1,1,'Order','','','order'),(22,1,1,'Search','','','search'),(23,1,1,'Stores','','','stores'),(24,1,1,'Order','','','quick-order'),(25,1,1,'Guest tracking','','','guest-tracking'),(26,1,1,'Order confirmation','','','order-confirmation'),(35,1,1,'Products Comparison','','','products-comparison'),(36,1,1,'','','','');
/*!40000 ALTER TABLE `ps_meta_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module`
--

DROP TABLE IF EXISTS `ps_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module` (
                           `id_module` int(10) unsigned NOT NULL AUTO_INCREMENT,
                           `name` varchar(64) NOT NULL,
                           `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `version` varchar(8) NOT NULL,
                           PRIMARY KEY (`id_module`),
                           KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module`
--

LOCK TABLES `ps_module` WRITE;
/*!40000 ALTER TABLE `ps_module` DISABLE KEYS */;
INSERT INTO `ps_module` VALUES (1,'socialsharing',1,'1.4.3'),(2,'blockbanner',1,'1.4.1'),(3,'bankwire',1,'1.1.2'),(4,'blockbestsellers',1,'1.8.1'),(5,'blockcart',1,'1.6.2'),(6,'blocksocial',1,'1.2.2'),(7,'blockcategories',1,'2.9.4'),(8,'blockcurrencies',1,'0.4.1'),(9,'blockfacebook',1,'1.4.1'),(10,'blocklanguages',1,'1.5.1'),(11,'blocklayered',1,'2.2.1'),(12,'blockcms',1,'2.1.2'),(13,'blockcmsinfo',1,'1.6.1'),(14,'blockcontact',1,'1.4.1'),(15,'blockcontactinfos',1,'1.2.1'),(16,'blockmanufacturer',1,'1.4.1'),(17,'blockmyaccount',1,'1.4.1'),(18,'blockmyaccountfooter',1,'1.6.1'),(19,'blocknewproducts',1,'1.10.1'),(20,'blocknewsletter',1,'2.4.0'),(21,'blockpaymentlogo',1,'0.4.1'),(22,'blocksearch',1,'1.7.1'),(23,'blockspecials',1,'1.3.1'),(24,'blockstore',1,'1.3.1'),(25,'blocksupplier',1,'1.2.1'),(26,'blocktags',1,'1.3.1'),(27,'blocktopmenu',1,'2.2.4'),(28,'blockuserinfo',1,'0.4.1'),(29,'blockviewed',1,'1.3.1'),(30,'cheque',1,'2.7.2'),(31,'dashactivity',1,'1.0.0'),(32,'dashtrends',1,'1.0.0'),(33,'dashgoals',1,'1.0.0'),(34,'dashproducts',1,'1.0.0'),(35,'graphnvd3',1,'1.5.1'),(36,'gridhtml',1,'1.3.1'),(37,'homeslider',1,'1.6.1'),(38,'homefeatured',1,'1.8.1'),(39,'productpaymentlogos',1,'1.4.1'),(40,'pagesnotfound',1,'1.5.1'),(41,'sekeywords',1,'1.4.1'),(42,'statsbestcategories',1,'1.5.1'),(43,'statsbestcustomers',1,'1.5.1'),(44,'statsbestproducts',1,'1.5.1'),(45,'statsbestsuppliers',1,'1.4.1'),(46,'statsbestvouchers',1,'1.5.1'),(47,'statscarrier',1,'1.4.1'),(48,'statscatalog',1,'1.4.0'),(49,'statscheckup',1,'1.5.0'),(50,'statsdata',1,'1.6.2'),(51,'statsequipment',1,'1.3.1'),(52,'statsforecast',1,'1.4.1'),(53,'statslive',1,'1.3.1'),(54,'statsnewsletter',1,'1.4.2'),(55,'statsorigin',1,'1.4.1'),(56,'statspersonalinfos',1,'1.4.1'),(57,'statsproduct',1,'1.5.1'),(58,'statsregistrations',1,'1.4.1'),(59,'statssales',1,'1.3.1'),(60,'statssearch',1,'1.4.1'),(61,'statsstock',1,'1.6.0'),(62,'statsvisits',1,'1.6.1'),(63,'themeconfigurator',1,'2.1.3'),(64,'gamification',1,'2.5.1'),(65,'onboarding',1,'1.0.2'),(66,'psaddonsconnect',1,'1.0.0'),(67,'ps_checkout',1,'6.3.6.3'),(68,'ps_accounts',1,'7.0.2'),(69,'ps_eventbus',1,'0.0.0');
/*!40000 ALTER TABLE `ps_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_access`
--

DROP TABLE IF EXISTS `ps_module_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_access` (
                                  `id_profile` int(10) unsigned NOT NULL,
                                  `id_module` int(10) unsigned NOT NULL,
                                  `view` tinyint(1) NOT NULL DEFAULT 0,
                                  `configure` tinyint(1) NOT NULL DEFAULT 0,
                                  `uninstall` tinyint(1) NOT NULL DEFAULT 0,
                                  PRIMARY KEY (`id_profile`,`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_access`
--

LOCK TABLES `ps_module_access` WRITE;
/*!40000 ALTER TABLE `ps_module_access` DISABLE KEYS */;
INSERT INTO `ps_module_access` VALUES (2,1,1,1,1),(2,2,1,1,1),(2,3,1,1,1),(2,4,1,1,1),(2,5,1,1,1),(2,6,1,1,1),(2,7,1,1,1),(2,8,1,1,1),(2,9,1,1,1),(2,10,1,1,1),(2,11,1,1,1),(2,12,1,1,1),(2,13,1,1,1),(2,14,1,1,1),(2,15,1,1,1),(2,16,1,1,1),(2,17,1,1,1),(2,18,1,1,1),(2,19,1,1,1),(2,20,1,1,1),(2,21,1,1,1),(2,22,1,1,1),(2,23,1,1,1),(2,24,1,1,1),(2,25,1,1,1),(2,26,1,1,1),(2,27,1,1,1),(2,28,1,1,1),(2,29,1,1,1),(2,30,1,1,1),(2,31,1,1,1),(2,32,1,1,1),(2,33,1,1,1),(2,34,1,1,1),(2,35,1,1,1),(2,36,1,1,1),(2,37,1,1,1),(2,38,1,1,1),(2,39,1,1,1),(2,40,1,1,1),(2,41,1,1,1),(2,42,1,1,1),(2,43,1,1,1),(2,44,1,1,1),(2,45,1,1,1),(2,46,1,1,1),(2,47,1,1,1),(2,48,1,1,1),(2,49,1,1,1),(2,50,1,1,1),(2,51,1,1,1),(2,52,1,1,1),(2,53,1,1,1),(2,54,1,1,1),(2,55,1,1,1),(2,56,1,1,1),(2,57,1,1,1),(2,58,1,1,1),(2,59,1,1,1),(2,60,1,1,1),(2,61,1,1,1),(2,62,1,1,1),(2,63,1,1,1),(2,64,1,1,1),(2,65,1,1,1),(2,66,1,1,1),(2,67,1,1,1),(2,68,1,1,1),(2,69,1,1,1),(3,1,1,0,0),(3,2,1,0,0),(3,3,1,0,0),(3,4,1,0,0),(3,5,1,0,0),(3,6,1,0,0),(3,7,1,0,0),(3,8,1,0,0),(3,9,1,0,0),(3,10,1,0,0),(3,11,1,0,0),(3,12,1,0,0),(3,13,1,0,0),(3,14,1,0,0),(3,15,1,0,0),(3,16,1,0,0),(3,17,1,0,0),(3,18,1,0,0),(3,19,1,0,0),(3,20,1,0,0),(3,21,1,0,0),(3,22,1,0,0),(3,23,1,0,0),(3,24,1,0,0),(3,25,1,0,0),(3,26,1,0,0),(3,27,1,0,0),(3,28,1,0,0),(3,29,1,0,0),(3,30,1,0,0),(3,31,1,0,0),(3,32,1,0,0),(3,33,1,0,0),(3,34,1,0,0),(3,35,1,0,0),(3,36,1,0,0),(3,37,1,0,0),(3,38,1,0,0),(3,39,1,0,0),(3,40,1,0,0),(3,41,1,0,0),(3,42,1,0,0),(3,43,1,0,0),(3,44,1,0,0),(3,45,1,0,0),(3,46,1,0,0),(3,47,1,0,0),(3,48,1,0,0),(3,49,1,0,0),(3,50,1,0,0),(3,51,1,0,0),(3,52,1,0,0),(3,53,1,0,0),(3,54,1,0,0),(3,55,1,0,0),(3,56,1,0,0),(3,57,1,0,0),(3,58,1,0,0),(3,59,1,0,0),(3,60,1,0,0),(3,61,1,0,0),(3,62,1,0,0),(3,63,1,0,0),(3,64,1,0,0),(3,65,1,0,0),(3,66,1,0,0),(3,67,1,0,0),(3,68,1,0,0),(3,69,1,0,0),(4,1,1,1,1),(4,2,1,1,1),(4,3,1,1,1),(4,4,1,1,1),(4,5,1,1,1),(4,6,1,1,1),(4,7,1,1,1),(4,8,1,1,1),(4,9,1,1,1),(4,10,1,1,1),(4,11,1,1,1),(4,12,1,1,1),(4,13,1,1,1),(4,14,1,1,1),(4,15,1,1,1),(4,16,1,1,1),(4,17,1,1,1),(4,18,1,1,1),(4,19,1,1,1),(4,20,1,1,1),(4,21,1,1,1),(4,22,1,1,1),(4,23,1,1,1),(4,24,1,1,1),(4,25,1,1,1),(4,26,1,1,1),(4,27,1,1,1),(4,28,1,1,1),(4,29,1,1,1),(4,30,1,1,1),(4,31,1,1,1),(4,32,1,1,1),(4,33,1,1,1),(4,34,1,1,1),(4,35,1,1,1),(4,36,1,1,1),(4,37,1,1,1),(4,38,1,1,1),(4,39,1,1,1),(4,40,1,1,1),(4,41,1,1,1),(4,42,1,1,1),(4,43,1,1,1),(4,44,1,1,1),(4,45,1,1,1),(4,46,1,1,1),(4,47,1,1,1),(4,48,1,1,1),(4,49,1,1,1),(4,50,1,1,1),(4,51,1,1,1),(4,52,1,1,1),(4,53,1,1,1),(4,54,1,1,1),(4,55,1,1,1),(4,56,1,1,1),(4,57,1,1,1),(4,58,1,1,1),(4,59,1,1,1),(4,60,1,1,1),(4,61,1,1,1),(4,62,1,1,1),(4,63,1,1,1),(4,64,1,1,1),(4,65,1,1,1),(4,66,1,1,1),(4,67,1,1,1),(4,68,1,1,1),(4,69,1,1,1);
/*!40000 ALTER TABLE `ps_module_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_country`
--

DROP TABLE IF EXISTS `ps_module_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_country` (
                                   `id_module` int(10) unsigned NOT NULL,
                                   `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                   `id_country` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_module`,`id_shop`,`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_country`
--

LOCK TABLES `ps_module_country` WRITE;
/*!40000 ALTER TABLE `ps_module_country` DISABLE KEYS */;
INSERT INTO `ps_module_country` VALUES (3,1,17),(30,1,17),(67,1,1),(67,1,2),(67,1,3),(67,1,4),(67,1,5),(67,1,6),(67,1,7),(67,1,8),(67,1,9),(67,1,10),(67,1,11),(67,1,12),(67,1,13),(67,1,14),(67,1,15),(67,1,16),(67,1,17),(67,1,18),(67,1,19),(67,1,20),(67,1,21),(67,1,22),(67,1,23),(67,1,24),(67,1,25),(67,1,26),(67,1,27),(67,1,28),(67,1,29),(67,1,30),(67,1,31),(67,1,32),(67,1,33),(67,1,34),(67,1,35),(67,1,36),(67,1,37),(67,1,38),(67,1,40),(67,1,41),(67,1,42),(67,1,43),(67,1,44),(67,1,45),(67,1,46),(67,1,47),(67,1,48),(67,1,49),(67,1,51),(67,1,52),(67,1,53),(67,1,54),(67,1,55),(67,1,56),(67,1,57),(67,1,58),(67,1,59),(67,1,60),(67,1,62),(67,1,63),(67,1,64),(67,1,65),(67,1,67),(67,1,68),(67,1,69),(67,1,70),(67,1,71),(67,1,72),(67,1,73),(67,1,74),(67,1,76),(67,1,77),(67,1,78),(67,1,79),(67,1,81),(67,1,82),(67,1,83),(67,1,85),(67,1,86),(67,1,87),(67,1,88),(67,1,89),(67,1,90),(67,1,91),(67,1,92),(67,1,93),(67,1,95),(67,1,96),(67,1,97),(67,1,98),(67,1,100),(67,1,102),(67,1,103),(67,1,104),(67,1,107),(67,1,108),(67,1,109),(67,1,110),(67,1,111),(67,1,115),(67,1,117),(67,1,118),(67,1,119),(67,1,120),(67,1,122),(67,1,123),(67,1,124),(67,1,125),(67,1,127),(67,1,130),(67,1,131),(67,1,133),(67,1,134),(67,1,135),(67,1,136),(67,1,137),(67,1,138),(67,1,139),(67,1,140),(67,1,141),(67,1,142),(67,1,143),(67,1,144),(67,1,145),(67,1,146),(67,1,147),(67,1,148),(67,1,149),(67,1,150),(67,1,151),(67,1,152),(67,1,153),(67,1,154),(67,1,155),(67,1,156),(67,1,158),(67,1,159),(67,1,160),(67,1,161),(67,1,162),(67,1,164),(67,1,166),(67,1,168),(67,1,169),(67,1,170),(67,1,171),(67,1,172),(67,1,173),(67,1,175),(67,1,176),(67,1,177),(67,1,178),(67,1,180),(67,1,181),(67,1,183),(67,1,184),(67,1,185),(67,1,186),(67,1,187),(67,1,188),(67,1,189),(67,1,190),(67,1,191),(67,1,192),(67,1,193),(67,1,194),(67,1,195),(67,1,197),(67,1,199),(67,1,200),(67,1,201),(67,1,203),(67,1,204),(67,1,205),(67,1,206),(67,1,208),(67,1,209),(67,1,210),(67,1,212),(67,1,213),(67,1,214),(67,1,215),(67,1,216),(67,1,217),(67,1,218),(67,1,220),(67,1,221),(67,1,222),(67,1,223),(67,1,225),(67,1,227),(67,1,228),(67,1,229),(67,1,230),(67,1,233),(67,1,236),(67,1,237),(67,1,240),(67,1,241),(67,1,242);
/*!40000 ALTER TABLE `ps_module_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_currency`
--

DROP TABLE IF EXISTS `ps_module_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_currency` (
                                    `id_module` int(10) unsigned NOT NULL,
                                    `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                    `id_currency` int(11) NOT NULL,
                                    PRIMARY KEY (`id_module`,`id_shop`,`id_currency`),
                                    KEY `id_module` (`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_currency`
--

LOCK TABLES `ps_module_currency` WRITE;
/*!40000 ALTER TABLE `ps_module_currency` DISABLE KEYS */;
INSERT INTO `ps_module_currency` VALUES (3,1,1),(3,1,2),(30,1,1),(30,1,2),(67,1,1),(67,1,2);
/*!40000 ALTER TABLE `ps_module_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_group`
--

DROP TABLE IF EXISTS `ps_module_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_group` (
                                 `id_module` int(10) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                 `id_group` int(11) unsigned NOT NULL,
                                 PRIMARY KEY (`id_module`,`id_shop`,`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_group`
--

LOCK TABLES `ps_module_group` WRITE;
/*!40000 ALTER TABLE `ps_module_group` DISABLE KEYS */;
INSERT INTO `ps_module_group` VALUES (1,1,1),(1,1,2),(1,1,3),(2,1,1),(2,1,2),(2,1,3),(3,1,1),(3,1,2),(3,1,3),(4,1,1),(4,1,2),(4,1,3),(5,1,1),(5,1,2),(5,1,3),(6,1,1),(6,1,2),(6,1,3),(7,1,1),(7,1,2),(7,1,3),(8,1,1),(8,1,2),(8,1,3),(9,1,1),(9,1,2),(9,1,3),(10,1,1),(10,1,2),(10,1,3),(11,1,1),(11,1,2),(11,1,3),(12,1,1),(12,1,2),(12,1,3),(13,1,1),(13,1,2),(13,1,3),(14,1,1),(14,1,2),(14,1,3),(15,1,1),(15,1,2),(15,1,3),(16,1,1),(16,1,2),(16,1,3),(17,1,1),(17,1,2),(17,1,3),(18,1,1),(18,1,2),(18,1,3),(19,1,1),(19,1,2),(19,1,3),(20,1,1),(20,1,2),(20,1,3),(21,1,1),(21,1,2),(21,1,3),(22,1,1),(22,1,2),(22,1,3),(23,1,1),(23,1,2),(23,1,3),(24,1,1),(24,1,2),(24,1,3),(25,1,1),(25,1,2),(25,1,3),(26,1,1),(26,1,2),(26,1,3),(27,1,1),(27,1,2),(27,1,3),(28,1,1),(28,1,2),(28,1,3),(29,1,1),(29,1,2),(29,1,3),(30,1,1),(30,1,2),(30,1,3),(31,1,1),(31,1,2),(31,1,3),(32,1,1),(32,1,2),(32,1,3),(33,1,1),(33,1,2),(33,1,3),(34,1,1),(34,1,2),(34,1,3),(35,1,1),(35,1,2),(35,1,3),(36,1,1),(36,1,2),(36,1,3),(37,1,1),(37,1,2),(37,1,3),(38,1,1),(38,1,2),(38,1,3),(39,1,1),(39,1,2),(39,1,3),(40,1,1),(40,1,2),(40,1,3),(41,1,1),(41,1,2),(41,1,3),(42,1,1),(42,1,2),(42,1,3),(43,1,1),(43,1,2),(43,1,3),(44,1,1),(44,1,2),(44,1,3),(45,1,1),(45,1,2),(45,1,3),(46,1,1),(46,1,2),(46,1,3),(47,1,1),(47,1,2),(47,1,3),(48,1,1),(48,1,2),(48,1,3),(49,1,1),(49,1,2),(49,1,3),(50,1,1),(50,1,2),(50,1,3),(51,1,1),(51,1,2),(51,1,3),(52,1,1),(52,1,2),(52,1,3),(53,1,1),(53,1,2),(53,1,3),(54,1,1),(54,1,2),(54,1,3),(55,1,1),(55,1,2),(55,1,3),(56,1,1),(56,1,2),(56,1,3),(57,1,1),(57,1,2),(57,1,3),(58,1,1),(58,1,2),(58,1,3),(59,1,1),(59,1,2),(59,1,3),(60,1,1),(60,1,2),(60,1,3),(61,1,1),(61,1,2),(61,1,3),(62,1,1),(62,1,2),(62,1,3),(63,1,1),(63,1,2),(63,1,3),(64,1,1),(64,1,2),(64,1,3),(65,1,1),(65,1,2),(65,1,3),(66,1,1),(66,1,2),(66,1,3),(67,1,1),(67,1,2),(67,1,3),(68,1,1),(68,1,2),(68,1,3),(69,1,1),(69,1,2),(69,1,3);
/*!40000 ALTER TABLE `ps_module_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_preference`
--

DROP TABLE IF EXISTS `ps_module_preference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_preference` (
                                      `id_module_preference` int(11) NOT NULL AUTO_INCREMENT,
                                      `id_employee` int(11) NOT NULL,
                                      `module` varchar(255) NOT NULL,
                                      `interest` tinyint(1) DEFAULT NULL,
                                      `favorite` tinyint(1) DEFAULT NULL,
                                      PRIMARY KEY (`id_module_preference`),
                                      UNIQUE KEY `employee_module` (`id_employee`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_preference`
--

LOCK TABLES `ps_module_preference` WRITE;
/*!40000 ALTER TABLE `ps_module_preference` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_module_preference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_module_shop`
--

DROP TABLE IF EXISTS `ps_module_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_module_shop` (
                                `id_module` int(11) unsigned NOT NULL,
                                `id_shop` int(11) unsigned NOT NULL,
                                `enable_device` tinyint(1) NOT NULL DEFAULT 7,
                                PRIMARY KEY (`id_module`,`id_shop`),
                                KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_module_shop`
--

LOCK TABLES `ps_module_shop` WRITE;
/*!40000 ALTER TABLE `ps_module_shop` DISABLE KEYS */;
INSERT INTO `ps_module_shop` VALUES (1,1,7),(2,1,3),(3,1,7),(4,1,7),(5,1,7),(6,1,7),(7,1,7),(8,1,7),(9,1,7),(10,1,7),(11,1,7),(12,1,7),(13,1,1),(14,1,7),(15,1,7),(16,1,7),(17,1,7),(18,1,7),(19,1,7),(20,1,7),(21,1,7),(22,1,7),(23,1,7),(24,1,7),(25,1,7),(26,1,7),(27,1,7),(28,1,7),(29,1,7),(30,1,7),(31,1,7),(32,1,7),(33,1,7),(34,1,7),(35,1,7),(36,1,7),(37,1,3),(38,1,7),(39,1,7),(40,1,7),(41,1,7),(42,1,7),(43,1,7),(44,1,7),(45,1,7),(46,1,7),(47,1,7),(48,1,7),(49,1,7),(50,1,7),(51,1,7),(52,1,7),(53,1,7),(54,1,7),(55,1,7),(56,1,7),(57,1,7),(58,1,7),(59,1,7),(60,1,7),(61,1,7),(62,1,7),(63,1,7),(64,1,7),(65,1,7),(66,1,7),(67,1,7),(68,1,7),(69,1,7);
/*!40000 ALTER TABLE `ps_module_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_modules_perfs`
--

DROP TABLE IF EXISTS `ps_modules_perfs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_modules_perfs` (
                                  `id_modules_perfs` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `session` int(11) unsigned NOT NULL,
                                  `module` varchar(62) NOT NULL,
                                  `method` varchar(126) NOT NULL,
                                  `time_start` double unsigned NOT NULL,
                                  `time_end` double unsigned NOT NULL,
                                  `memory_start` int(10) unsigned NOT NULL,
                                  `memory_end` int(10) unsigned NOT NULL,
                                  PRIMARY KEY (`id_modules_perfs`),
                                  KEY `session` (`session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_modules_perfs`
--

LOCK TABLES `ps_modules_perfs` WRITE;
/*!40000 ALTER TABLE `ps_modules_perfs` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_modules_perfs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_newsletter`
--

DROP TABLE IF EXISTS `ps_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_newsletter` (
                               `id` int(6) NOT NULL AUTO_INCREMENT,
                               `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                               `id_shop_group` int(10) unsigned NOT NULL DEFAULT 1,
                               `email` varchar(255) NOT NULL,
                               `newsletter_date_add` datetime DEFAULT NULL,
                               `ip_registration_newsletter` varchar(15) NOT NULL,
                               `http_referer` varchar(255) DEFAULT NULL,
                               `active` tinyint(1) NOT NULL DEFAULT 0,
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_newsletter`
--

LOCK TABLES `ps_newsletter` WRITE;
/*!40000 ALTER TABLE `ps_newsletter` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_operating_system`
--

DROP TABLE IF EXISTS `ps_operating_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_operating_system` (
                                     `id_operating_system` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `name` varchar(64) DEFAULT NULL,
                                     PRIMARY KEY (`id_operating_system`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_operating_system`
--

LOCK TABLES `ps_operating_system` WRITE;
/*!40000 ALTER TABLE `ps_operating_system` DISABLE KEYS */;
INSERT INTO `ps_operating_system` VALUES (1,'Windows XP'),(2,'Windows Vista'),(3,'Windows 7'),(4,'Windows 8'),(5,'MacOsX'),(6,'Linux'),(7,'Android');
/*!40000 ALTER TABLE `ps_operating_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_carrier`
--

DROP TABLE IF EXISTS `ps_order_carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_carrier` (
                                  `id_order_carrier` int(11) NOT NULL AUTO_INCREMENT,
                                  `id_order` int(11) unsigned NOT NULL,
                                  `id_carrier` int(11) unsigned NOT NULL,
                                  `id_order_invoice` int(11) unsigned DEFAULT NULL,
                                  `weight` decimal(20,6) DEFAULT NULL,
                                  `shipping_cost_tax_excl` decimal(20,6) DEFAULT NULL,
                                  `shipping_cost_tax_incl` decimal(20,6) DEFAULT NULL,
                                  `tracking_number` varchar(64) DEFAULT NULL,
                                  `date_add` datetime NOT NULL,
                                  PRIMARY KEY (`id_order_carrier`),
                                  KEY `id_order` (`id_order`),
                                  KEY `id_carrier` (`id_carrier`),
                                  KEY `id_order_invoice` (`id_order_invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_carrier`
--

LOCK TABLES `ps_order_carrier` WRITE;
/*!40000 ALTER TABLE `ps_order_carrier` DISABLE KEYS */;
INSERT INTO `ps_order_carrier` VALUES (1,1,2,0,0.000000,2.000000,2.000000,'','2025-03-04 08:13:15'),(2,2,2,0,0.000000,2.000000,2.000000,'','2025-03-04 08:13:15'),(3,3,2,0,0.000000,2.000000,2.000000,'','2025-03-04 08:13:15'),(4,4,2,0,0.000000,2.000000,2.000000,'','2025-03-04 08:13:15'),(5,5,2,0,0.000000,2.000000,2.000000,'','2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_order_carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_cart_rule`
--

DROP TABLE IF EXISTS `ps_order_cart_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_cart_rule` (
                                    `id_order_cart_rule` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_order` int(10) unsigned NOT NULL,
                                    `id_cart_rule` int(10) unsigned NOT NULL,
                                    `id_order_invoice` int(10) unsigned DEFAULT 0,
                                    `name` varchar(254) NOT NULL,
                                    `value` decimal(17,2) NOT NULL DEFAULT 0.00,
                                    `value_tax_excl` decimal(17,2) NOT NULL DEFAULT 0.00,
                                    `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
                                    PRIMARY KEY (`id_order_cart_rule`),
                                    KEY `id_order` (`id_order`),
                                    KEY `id_cart_rule` (`id_cart_rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_cart_rule`
--

LOCK TABLES `ps_order_cart_rule` WRITE;
/*!40000 ALTER TABLE `ps_order_cart_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_cart_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_detail`
--

DROP TABLE IF EXISTS `ps_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_detail` (
                                 `id_order_detail` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_order` int(10) unsigned NOT NULL,
                                 `id_order_invoice` int(11) DEFAULT NULL,
                                 `id_warehouse` int(10) unsigned DEFAULT 0,
                                 `id_shop` int(11) unsigned NOT NULL,
                                 `product_id` int(10) unsigned NOT NULL,
                                 `product_attribute_id` int(10) unsigned DEFAULT NULL,
                                 `product_name` varchar(255) NOT NULL,
                                 `product_quantity` int(10) unsigned NOT NULL DEFAULT 0,
                                 `product_quantity_in_stock` int(10) NOT NULL DEFAULT 0,
                                 `product_quantity_refunded` int(10) unsigned NOT NULL DEFAULT 0,
                                 `product_quantity_return` int(10) unsigned NOT NULL DEFAULT 0,
                                 `product_quantity_reinjected` int(10) unsigned NOT NULL DEFAULT 0,
                                 `product_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `reduction_percent` decimal(10,2) NOT NULL DEFAULT 0.00,
                                 `reduction_amount` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `reduction_amount_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `reduction_amount_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `group_reduction` decimal(10,2) NOT NULL DEFAULT 0.00,
                                 `product_quantity_discount` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `product_ean13` varchar(13) DEFAULT NULL,
                                 `product_upc` varchar(12) DEFAULT NULL,
                                 `product_reference` varchar(32) DEFAULT NULL,
                                 `product_supplier_reference` varchar(32) DEFAULT NULL,
                                 `product_weight` decimal(20,6) NOT NULL,
                                 `id_tax_rules_group` int(11) unsigned DEFAULT 0,
                                 `tax_computation_method` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `tax_name` varchar(16) NOT NULL,
                                 `tax_rate` decimal(10,3) NOT NULL DEFAULT 0.000,
                                 `ecotax` decimal(21,6) NOT NULL DEFAULT 0.000000,
                                 `ecotax_tax_rate` decimal(5,3) NOT NULL DEFAULT 0.000,
                                 `discount_quantity_applied` tinyint(1) NOT NULL DEFAULT 0,
                                 `download_hash` varchar(255) DEFAULT NULL,
                                 `download_nb` int(10) unsigned DEFAULT 0,
                                 `download_deadline` datetime DEFAULT NULL,
                                 `total_price_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `total_price_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `unit_price_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `unit_price_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `total_shipping_price_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `total_shipping_price_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `purchase_supplier_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `original_product_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `original_wholesale_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 PRIMARY KEY (`id_order_detail`),
                                 KEY `order_detail_order` (`id_order`),
                                 KEY `product_id` (`product_id`),
                                 KEY `product_attribute_id` (`product_attribute_id`),
                                 KEY `id_tax_rules_group` (`id_tax_rules_group`),
                                 KEY `id_order_id_order_detail` (`id_order`,`id_order_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_detail`
--

LOCK TABLES `ps_order_detail` WRITE;
/*!40000 ALTER TABLE `ps_order_detail` DISABLE KEYS */;
INSERT INTO `ps_order_detail` VALUES (1,1,0,0,1,2,10,'Blouse - Color : White, Size : M',1,1,0,0,0,26.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_2','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',27.000000,27.000000,27.000000,27.000000,0.000000,0.000000,0.000000,26.999852,8.100000),(2,1,0,0,1,3,13,'Printed Dress - Color : Orange, Size : S',1,1,0,0,0,25.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_3','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',26.000000,26.000000,26.000000,26.000000,0.000000,0.000000,0.000000,25.999852,7.800000),(3,2,0,0,1,2,10,'Blouse - Color : White, Size : M',1,1,0,0,0,26.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_2','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',27.000000,27.000000,27.000000,27.000000,0.000000,0.000000,0.000000,26.999852,8.100000),(4,2,0,0,1,6,32,'Printed Summer Dress - Color : Yellow, Size : M',1,1,0,0,0,30.502569,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_6','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',30.500000,30.500000,30.500000,30.500000,0.000000,0.000000,0.000000,30.502569,9.150000),(5,2,0,0,1,7,34,'Printed Chiffon Dress - Color : Yellow, Size : S',1,1,0,0,0,20.501236,20.00,0.000000,0.000000,0.000000,0.00,17.400000,'','','demo_7','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',16.400000,16.400000,16.400000,16.400000,0.000000,0.000000,0.000000,20.501236,6.150000),(6,3,0,0,1,1,1,'Faded Short Sleeve T-shirts - Color : Orange, Size : S',1,1,0,0,0,16.510000,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_1','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',16.510000,16.510000,16.510000,16.510000,0.000000,0.000000,0.000000,16.510000,4.950000),(7,3,0,0,1,2,10,'Blouse - Color : White, Size : M',1,1,0,0,0,26.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_2','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',27.000000,27.000000,27.000000,27.000000,0.000000,0.000000,0.000000,26.999852,8.100000),(8,3,0,0,1,6,32,'Printed Summer Dress - Color : Yellow, Size : M',1,1,0,0,0,30.502569,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_6','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',30.500000,30.500000,30.500000,30.500000,0.000000,0.000000,0.000000,30.502569,9.150000),(9,4,0,0,1,1,1,'Faded Short Sleeve T-shirts - Color : Orange, Size : S',1,1,0,0,0,16.510000,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_1','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',16.510000,16.510000,16.510000,16.510000,0.000000,0.000000,0.000000,16.510000,4.950000),(10,4,0,0,1,3,13,'Printed Dress - Color : Orange, Size : S',1,1,0,0,0,25.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_3','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',26.000000,26.000000,26.000000,26.000000,0.000000,0.000000,0.000000,25.999852,7.800000),(11,4,0,0,1,5,19,'Printed Summer Dress - Color : Yellow, Size : S',1,1,0,0,0,30.506321,5.00,0.000000,0.000000,0.000000,0.00,29.980000,'','','demo_5','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',28.980000,28.980000,28.980000,28.980000,0.000000,0.000000,0.000000,30.506321,9.150000),(12,4,0,0,1,7,34,'Printed Chiffon Dress - Color : Yellow, Size : S',1,1,0,0,0,20.501236,20.00,0.000000,0.000000,0.000000,0.00,17.400000,'','','demo_7','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',16.400000,16.400000,16.400000,16.400000,0.000000,0.000000,0.000000,20.501236,6.150000),(13,5,0,0,1,1,1,'Faded Short Sleeve T-shirts - Color : Orange, Size : S',1,1,0,0,0,16.510000,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_1','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',16.510000,16.510000,16.510000,16.510000,0.000000,0.000000,0.000000,16.510000,4.950000),(14,5,0,0,1,2,7,'Blouse - Color : Black, Size : S',1,1,0,0,0,26.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_2','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',27.000000,27.000000,27.000000,27.000000,0.000000,0.000000,0.000000,26.999852,8.100000),(15,5,0,0,1,3,13,'Printed Dress - Color : Orange, Size : S',1,1,0,0,0,25.999852,0.00,0.000000,0.000000,0.000000,0.00,0.000000,'','','demo_3','',0.000000,0,0,'',0.000,0.000000,0.000,0,'',0,'0000-00-00 00:00:00',26.000000,26.000000,26.000000,26.000000,0.000000,0.000000,0.000000,25.999852,7.800000);
/*!40000 ALTER TABLE `ps_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_detail_tax`
--

DROP TABLE IF EXISTS `ps_order_detail_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_detail_tax` (
                                     `id_order_detail` int(11) NOT NULL,
                                     `id_tax` int(11) NOT NULL,
                                     `unit_amount` decimal(16,6) NOT NULL DEFAULT 0.000000,
                                     `total_amount` decimal(16,6) NOT NULL DEFAULT 0.000000,
                                     KEY `id_order_detail` (`id_order_detail`),
                                     KEY `id_tax` (`id_tax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_detail_tax`
--

LOCK TABLES `ps_order_detail_tax` WRITE;
/*!40000 ALTER TABLE `ps_order_detail_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_detail_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_history`
--

DROP TABLE IF EXISTS `ps_order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_history` (
                                  `id_order_history` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_employee` int(10) unsigned NOT NULL,
                                  `id_order` int(10) unsigned NOT NULL,
                                  `id_order_state` int(10) unsigned NOT NULL,
                                  `date_add` datetime NOT NULL,
                                  PRIMARY KEY (`id_order_history`),
                                  KEY `order_history_order` (`id_order`),
                                  KEY `id_employee` (`id_employee`),
                                  KEY `id_order_state` (`id_order_state`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_history`
--

LOCK TABLES `ps_order_history` WRITE;
/*!40000 ALTER TABLE `ps_order_history` DISABLE KEYS */;
INSERT INTO `ps_order_history` VALUES (1,0,1,1,'2025-03-04 08:13:15'),(2,0,2,1,'2025-03-04 08:13:15'),(3,0,3,1,'2025-03-04 08:13:15'),(4,0,4,1,'2025-03-04 08:13:15'),(5,0,5,10,'2025-03-04 08:13:15'),(6,1,1,6,'2025-03-04 08:13:15'),(7,1,3,8,'2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_order_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_invoice`
--

DROP TABLE IF EXISTS `ps_order_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_invoice` (
                                  `id_order_invoice` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_order` int(11) NOT NULL,
                                  `number` int(11) NOT NULL,
                                  `delivery_number` int(11) NOT NULL,
                                  `delivery_date` datetime DEFAULT NULL,
                                  `total_discount_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_discount_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_paid_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_paid_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_products` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_products_wt` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_shipping_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_shipping_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `shipping_tax_computation_method` int(10) unsigned NOT NULL,
                                  `total_wrapping_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `total_wrapping_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                  `shop_address` text DEFAULT NULL,
                                  `invoice_address` text DEFAULT NULL,
                                  `delivery_address` text DEFAULT NULL,
                                  `note` text DEFAULT NULL,
                                  `date_add` datetime NOT NULL,
                                  PRIMARY KEY (`id_order_invoice`),
                                  KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_invoice`
--

LOCK TABLES `ps_order_invoice` WRITE;
/*!40000 ALTER TABLE `ps_order_invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_invoice_payment`
--

DROP TABLE IF EXISTS `ps_order_invoice_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_invoice_payment` (
                                          `id_order_invoice` int(11) unsigned NOT NULL,
                                          `id_order_payment` int(11) unsigned NOT NULL,
                                          `id_order` int(11) unsigned NOT NULL,
                                          PRIMARY KEY (`id_order_invoice`,`id_order_payment`),
                                          KEY `order_payment` (`id_order_payment`),
                                          KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_invoice_payment`
--

LOCK TABLES `ps_order_invoice_payment` WRITE;
/*!40000 ALTER TABLE `ps_order_invoice_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_invoice_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_invoice_tax`
--

DROP TABLE IF EXISTS `ps_order_invoice_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_invoice_tax` (
                                      `id_order_invoice` int(11) NOT NULL,
                                      `type` varchar(15) NOT NULL,
                                      `id_tax` int(11) NOT NULL,
                                      `amount` decimal(10,6) NOT NULL DEFAULT 0.000000,
                                      KEY `id_tax` (`id_tax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_invoice_tax`
--

LOCK TABLES `ps_order_invoice_tax` WRITE;
/*!40000 ALTER TABLE `ps_order_invoice_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_invoice_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_message`
--

DROP TABLE IF EXISTS `ps_order_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_message` (
                                  `id_order_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `date_add` datetime NOT NULL,
                                  PRIMARY KEY (`id_order_message`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_message`
--

LOCK TABLES `ps_order_message` WRITE;
/*!40000 ALTER TABLE `ps_order_message` DISABLE KEYS */;
INSERT INTO `ps_order_message` VALUES (1,'2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_order_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_message_lang`
--

DROP TABLE IF EXISTS `ps_order_message_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_message_lang` (
                                       `id_order_message` int(10) unsigned NOT NULL,
                                       `id_lang` int(10) unsigned NOT NULL,
                                       `name` varchar(128) NOT NULL,
                                       `message` text NOT NULL,
                                       PRIMARY KEY (`id_order_message`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_message_lang`
--

LOCK TABLES `ps_order_message_lang` WRITE;
/*!40000 ALTER TABLE `ps_order_message_lang` DISABLE KEYS */;
INSERT INTO `ps_order_message_lang` VALUES (1,1,'Delay','Hi,\n\nUnfortunately, an item on your order is currently out of stock. This may cause a slight delay in delivery.\nPlease accept our apologies and rest assured that we are working hard to rectify this.\n\nBest regards,');
/*!40000 ALTER TABLE `ps_order_message_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_payment`
--

DROP TABLE IF EXISTS `ps_order_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_payment` (
                                  `id_order_payment` int(11) NOT NULL AUTO_INCREMENT,
                                  `order_reference` varchar(9) DEFAULT NULL,
                                  `id_currency` int(10) unsigned NOT NULL,
                                  `amount` decimal(10,2) NOT NULL,
                                  `payment_method` varchar(255) NOT NULL,
                                  `conversion_rate` decimal(13,6) NOT NULL DEFAULT 1.000000,
                                  `transaction_id` varchar(254) DEFAULT NULL,
                                  `card_number` varchar(254) DEFAULT NULL,
                                  `card_brand` varchar(254) DEFAULT NULL,
                                  `card_expiration` char(7) DEFAULT NULL,
                                  `card_holder` varchar(254) DEFAULT NULL,
                                  `date_add` datetime NOT NULL,
                                  PRIMARY KEY (`id_order_payment`),
                                  KEY `order_reference` (`order_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_payment`
--

LOCK TABLES `ps_order_payment` WRITE;
/*!40000 ALTER TABLE `ps_order_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_return`
--

DROP TABLE IF EXISTS `ps_order_return`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_return` (
                                 `id_order_return` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_customer` int(10) unsigned NOT NULL,
                                 `id_order` int(10) unsigned NOT NULL,
                                 `state` tinyint(1) unsigned NOT NULL DEFAULT 1,
                                 `question` text NOT NULL,
                                 `date_add` datetime NOT NULL,
                                 `date_upd` datetime NOT NULL,
                                 PRIMARY KEY (`id_order_return`),
                                 KEY `order_return_customer` (`id_customer`),
                                 KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_return`
--

LOCK TABLES `ps_order_return` WRITE;
/*!40000 ALTER TABLE `ps_order_return` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_return` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_return_detail`
--

DROP TABLE IF EXISTS `ps_order_return_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_return_detail` (
                                        `id_order_return` int(10) unsigned NOT NULL,
                                        `id_order_detail` int(10) unsigned NOT NULL,
                                        `id_customization` int(10) unsigned NOT NULL DEFAULT 0,
                                        `product_quantity` int(10) unsigned NOT NULL DEFAULT 0,
                                        PRIMARY KEY (`id_order_return`,`id_order_detail`,`id_customization`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_return_detail`
--

LOCK TABLES `ps_order_return_detail` WRITE;
/*!40000 ALTER TABLE `ps_order_return_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_return_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_return_state`
--

DROP TABLE IF EXISTS `ps_order_return_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_return_state` (
                                       `id_order_return_state` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                       `color` varchar(32) DEFAULT NULL,
                                       PRIMARY KEY (`id_order_return_state`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_return_state`
--

LOCK TABLES `ps_order_return_state` WRITE;
/*!40000 ALTER TABLE `ps_order_return_state` DISABLE KEYS */;
INSERT INTO `ps_order_return_state` VALUES (1,'#4169E1'),(2,'#8A2BE2'),(3,'#32CD32'),(4,'#DC143C'),(5,'#108510');
/*!40000 ALTER TABLE `ps_order_return_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_return_state_lang`
--

DROP TABLE IF EXISTS `ps_order_return_state_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_return_state_lang` (
                                            `id_order_return_state` int(10) unsigned NOT NULL,
                                            `id_lang` int(10) unsigned NOT NULL,
                                            `name` varchar(64) NOT NULL,
                                            PRIMARY KEY (`id_order_return_state`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_return_state_lang`
--

LOCK TABLES `ps_order_return_state_lang` WRITE;
/*!40000 ALTER TABLE `ps_order_return_state_lang` DISABLE KEYS */;
INSERT INTO `ps_order_return_state_lang` VALUES (1,1,'Waiting for confirmation'),(2,1,'Waiting for package'),(3,1,'Package received'),(4,1,'Return denied'),(5,1,'Return completed');
/*!40000 ALTER TABLE `ps_order_return_state_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_slip`
--

DROP TABLE IF EXISTS `ps_order_slip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_slip` (
                               `id_order_slip` int(10) unsigned NOT NULL AUTO_INCREMENT,
                               `conversion_rate` decimal(13,6) NOT NULL DEFAULT 1.000000,
                               `id_customer` int(10) unsigned NOT NULL,
                               `id_order` int(10) unsigned NOT NULL,
                               `total_products_tax_excl` decimal(20,6) DEFAULT NULL,
                               `total_products_tax_incl` decimal(20,6) DEFAULT NULL,
                               `total_shipping_tax_excl` decimal(20,6) DEFAULT NULL,
                               `total_shipping_tax_incl` decimal(20,6) DEFAULT NULL,
                               `shipping_cost` tinyint(3) unsigned NOT NULL DEFAULT 0,
                               `amount` decimal(10,2) NOT NULL,
                               `shipping_cost_amount` decimal(10,2) NOT NULL,
                               `partial` tinyint(1) NOT NULL,
                               `order_slip_type` tinyint(1) unsigned NOT NULL DEFAULT 0,
                               `date_add` datetime NOT NULL,
                               `date_upd` datetime NOT NULL,
                               PRIMARY KEY (`id_order_slip`),
                               KEY `order_slip_customer` (`id_customer`),
                               KEY `id_order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_slip`
--

LOCK TABLES `ps_order_slip` WRITE;
/*!40000 ALTER TABLE `ps_order_slip` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_slip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_slip_detail`
--

DROP TABLE IF EXISTS `ps_order_slip_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_slip_detail` (
                                      `id_order_slip` int(10) unsigned NOT NULL,
                                      `id_order_detail` int(10) unsigned NOT NULL,
                                      `product_quantity` int(10) unsigned NOT NULL DEFAULT 0,
                                      `unit_price_tax_excl` decimal(20,6) DEFAULT NULL,
                                      `unit_price_tax_incl` decimal(20,6) DEFAULT NULL,
                                      `total_price_tax_excl` decimal(20,6) DEFAULT NULL,
                                      `total_price_tax_incl` decimal(20,6) DEFAULT NULL,
                                      `amount_tax_excl` decimal(20,6) DEFAULT NULL,
                                      `amount_tax_incl` decimal(20,6) DEFAULT NULL,
                                      PRIMARY KEY (`id_order_slip`,`id_order_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_slip_detail`
--

LOCK TABLES `ps_order_slip_detail` WRITE;
/*!40000 ALTER TABLE `ps_order_slip_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_slip_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_slip_detail_tax`
--

DROP TABLE IF EXISTS `ps_order_slip_detail_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_slip_detail_tax` (
                                          `id_order_slip_detail` int(11) unsigned NOT NULL,
                                          `id_tax` int(11) unsigned NOT NULL,
                                          `unit_amount` decimal(16,6) NOT NULL DEFAULT 0.000000,
                                          `total_amount` decimal(16,6) NOT NULL DEFAULT 0.000000,
                                          KEY `id_order_slip_detail` (`id_order_slip_detail`),
                                          KEY `id_tax` (`id_tax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_slip_detail_tax`
--

LOCK TABLES `ps_order_slip_detail_tax` WRITE;
/*!40000 ALTER TABLE `ps_order_slip_detail_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_order_slip_detail_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_state`
--

DROP TABLE IF EXISTS `ps_order_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_state` (
                                `id_order_state` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `invoice` tinyint(1) unsigned DEFAULT 0,
                                `send_email` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `module_name` varchar(255) DEFAULT NULL,
                                `color` varchar(32) DEFAULT NULL,
                                `unremovable` tinyint(1) unsigned NOT NULL,
                                `hidden` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `logable` tinyint(1) NOT NULL DEFAULT 0,
                                `delivery` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `shipped` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `paid` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `pdf_invoice` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `pdf_delivery` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                PRIMARY KEY (`id_order_state`),
                                KEY `module_name` (`module_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_state`
--

LOCK TABLES `ps_order_state` WRITE;
/*!40000 ALTER TABLE `ps_order_state` DISABLE KEYS */;
INSERT INTO `ps_order_state` VALUES (1,0,1,'cheque','#4169E1',1,0,0,0,0,0,0,0,0),(2,1,1,'','#32CD32',1,0,1,0,0,1,1,0,0),(3,1,1,'','#FF8C00',1,0,1,1,0,1,0,0,0),(4,1,1,'','#8A2BE2',1,0,1,1,1,1,0,0,0),(5,1,0,'','#108510',1,0,1,1,1,1,0,0,0),(6,0,1,'','#DC143C',1,0,0,0,0,0,0,0,0),(7,1,1,'','#ec2e15',1,0,0,0,0,0,0,0,0),(8,0,1,'','#8f0621',1,0,0,0,0,0,0,0,0),(9,1,1,'','#FF69B4',1,0,0,0,0,1,0,0,0),(10,0,1,'bankwire','#4169E1',1,0,0,0,0,0,0,0,0),(11,0,0,'','#4169E1',1,0,0,0,0,0,0,0,0),(12,1,1,'','#32CD32',1,0,1,0,0,1,0,0,0),(13,0,1,'','#FF69B4',1,0,0,0,0,0,0,0,0),(14,0,0,'cashondelivery','#4169E1',1,0,0,0,0,0,0,0,0),(15,0,0,'ps_checkout','#34209E',1,0,0,0,0,0,0,0,0),(16,0,0,'ps_checkout','#01B887',1,0,0,0,0,0,0,0,0),(17,0,0,'ps_checkout','#3498D8',1,0,0,0,0,0,0,0,0),(18,0,0,'ps_checkout','#3498D8',1,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `ps_order_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_order_state_lang`
--

DROP TABLE IF EXISTS `ps_order_state_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_order_state_lang` (
                                     `id_order_state` int(10) unsigned NOT NULL,
                                     `id_lang` int(10) unsigned NOT NULL,
                                     `name` varchar(64) NOT NULL,
                                     `template` varchar(64) NOT NULL,
                                     PRIMARY KEY (`id_order_state`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_order_state_lang`
--

LOCK TABLES `ps_order_state_lang` WRITE;
/*!40000 ALTER TABLE `ps_order_state_lang` DISABLE KEYS */;
INSERT INTO `ps_order_state_lang` VALUES (1,1,'Awaiting check payment','cheque'),(2,1,'Payment accepted','payment'),(3,1,'Processing in progress','preparation'),(4,1,'Shipped','shipped'),(5,1,'Delivered',''),(6,1,'Canceled','order_canceled'),(7,1,'Refunded','refund'),(8,1,'Payment error','payment_error'),(9,1,'On backorder (paid)','outofstock'),(10,1,'Awaiting bank wire payment','bankwire'),(11,1,'Awaiting PayPal payment',''),(12,1,'Remote payment accepted','payment'),(13,1,'On backorder (not paid)','outofstock'),(14,1,'Awaiting Cash On Delivery validation','cashondelivery'),(15,1,'Waiting for payment',''),(16,1,'Partial refund',''),(17,1,'Partial payment',''),(18,1,'Authorized. To be captured by merchant','');
/*!40000 ALTER TABLE `ps_order_state_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_orders`
--

DROP TABLE IF EXISTS `ps_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_orders` (
                           `id_order` int(10) unsigned NOT NULL AUTO_INCREMENT,
                           `reference` varchar(9) DEFAULT NULL,
                           `id_shop_group` int(11) unsigned NOT NULL DEFAULT 1,
                           `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                           `id_carrier` int(10) unsigned NOT NULL,
                           `id_lang` int(10) unsigned NOT NULL,
                           `id_customer` int(10) unsigned NOT NULL,
                           `id_cart` int(10) unsigned NOT NULL,
                           `id_currency` int(10) unsigned NOT NULL,
                           `id_address_delivery` int(10) unsigned NOT NULL,
                           `id_address_invoice` int(10) unsigned NOT NULL,
                           `current_state` int(10) unsigned NOT NULL,
                           `secure_key` varchar(32) NOT NULL DEFAULT '-1',
                           `payment` varchar(255) NOT NULL,
                           `conversion_rate` decimal(13,6) NOT NULL DEFAULT 1.000000,
                           `module` varchar(255) DEFAULT NULL,
                           `recyclable` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `gift` tinyint(1) unsigned NOT NULL DEFAULT 0,
                           `gift_message` text DEFAULT NULL,
                           `mobile_theme` tinyint(1) NOT NULL DEFAULT 0,
                           `shipping_number` varchar(64) DEFAULT NULL,
                           `total_discounts` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_discounts_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_discounts_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_paid` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_paid_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_paid_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_paid_real` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_products` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_products_wt` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_shipping` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_shipping_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_shipping_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `carrier_tax_rate` decimal(10,3) NOT NULL DEFAULT 0.000,
                           `total_wrapping` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_wrapping_tax_incl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `total_wrapping_tax_excl` decimal(20,6) NOT NULL DEFAULT 0.000000,
                           `round_mode` tinyint(1) NOT NULL DEFAULT 2,
                           `round_type` tinyint(1) NOT NULL DEFAULT 1,
                           `invoice_number` int(10) unsigned NOT NULL DEFAULT 0,
                           `delivery_number` int(10) unsigned NOT NULL DEFAULT 0,
                           `invoice_date` datetime NOT NULL,
                           `delivery_date` datetime NOT NULL,
                           `valid` int(1) unsigned NOT NULL DEFAULT 0,
                           `date_add` datetime NOT NULL,
                           `date_upd` datetime NOT NULL,
                           PRIMARY KEY (`id_order`),
                           KEY `reference` (`reference`),
                           KEY `id_customer` (`id_customer`),
                           KEY `id_cart` (`id_cart`),
                           KEY `invoice_number` (`invoice_number`),
                           KEY `id_carrier` (`id_carrier`),
                           KEY `id_lang` (`id_lang`),
                           KEY `id_currency` (`id_currency`),
                           KEY `id_address_delivery` (`id_address_delivery`),
                           KEY `id_address_invoice` (`id_address_invoice`),
                           KEY `id_shop_group` (`id_shop_group`),
                           KEY `current_state` (`current_state`),
                           KEY `id_shop` (`id_shop`),
                           KEY `date_add` (`date_add`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_orders`
--

LOCK TABLES `ps_orders` WRITE;
/*!40000 ALTER TABLE `ps_orders` DISABLE KEYS */;
INSERT INTO `ps_orders` VALUES (1,'XKBKNABJK',1,1,2,1,1,1,1,4,4,6,'b44a6d9efd7a0076a0fbce6b15eaf3b1','Payment by check',1.000000,'cheque',0,0,'',0,'',0.000000,0.000000,0.000000,55.000000,55.000000,55.000000,0.000000,53.000000,53.000000,2.000000,2.000000,2.000000,0.000,0.000000,0.000000,0.000000,0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(2,'OHSATSERP',1,1,2,1,1,2,1,4,4,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1','Payment by check',1.000000,'cheque',0,0,'',0,'',0.000000,0.000000,0.000000,75.900000,75.900000,75.900000,0.000000,73.900000,73.900000,2.000000,2.000000,2.000000,0.000,0.000000,0.000000,0.000000,0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(3,'UOYEVOLI',1,1,2,1,1,3,1,4,4,8,'b44a6d9efd7a0076a0fbce6b15eaf3b1','Payment by check',1.000000,'cheque',0,0,'',0,'',0.000000,0.000000,0.000000,76.010000,76.010000,76.010000,0.000000,74.010000,74.010000,2.000000,2.000000,2.000000,0.000,0.000000,0.000000,0.000000,0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(4,'FFATNOMMJ',1,1,2,1,1,4,1,4,4,1,'b44a6d9efd7a0076a0fbce6b15eaf3b1','Payment by check',1.000000,'cheque',0,0,'',0,'',0.000000,0.000000,0.000000,89.890000,89.890000,89.890000,0.000000,87.890000,87.890000,2.000000,2.000000,2.000000,0.000,0.000000,0.000000,0.000000,0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(5,'KHWLILZLL',1,1,2,1,1,5,1,4,4,10,'b44a6d9efd7a0076a0fbce6b15eaf3b1','Bank wire',1.000000,'bankwire',0,0,'',0,'',0.000000,0.000000,0.000000,71.510000,71.510000,71.510000,0.000000,69.510000,69.510000,2.000000,2.000000,2.000000,0.000,0.000000,0.000000,0.000000,0,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,'2025-03-04 08:13:15','2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_pack`
--

DROP TABLE IF EXISTS `ps_pack`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_pack` (
                         `id_product_pack` int(10) unsigned NOT NULL,
                         `id_product_item` int(10) unsigned NOT NULL,
                         `id_product_attribute_item` int(10) unsigned NOT NULL,
                         `quantity` int(10) unsigned NOT NULL DEFAULT 1,
                         PRIMARY KEY (`id_product_pack`,`id_product_item`,`id_product_attribute_item`),
                         KEY `product_item` (`id_product_item`,`id_product_attribute_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_pack`
--

LOCK TABLES `ps_pack` WRITE;
/*!40000 ALTER TABLE `ps_pack` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_pack` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_page`
--

DROP TABLE IF EXISTS `ps_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_page` (
                         `id_page` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `id_page_type` int(10) unsigned NOT NULL,
                         `id_object` int(10) unsigned DEFAULT NULL,
                         PRIMARY KEY (`id_page`),
                         KEY `id_page_type` (`id_page_type`),
                         KEY `id_object` (`id_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_page`
--

LOCK TABLES `ps_page` WRITE;
/*!40000 ALTER TABLE `ps_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_page_type`
--

DROP TABLE IF EXISTS `ps_page_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_page_type` (
                              `id_page_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `name` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_page_type`),
                              KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_page_type`
--

LOCK TABLES `ps_page_type` WRITE;
/*!40000 ALTER TABLE `ps_page_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_page_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_page_viewed`
--

DROP TABLE IF EXISTS `ps_page_viewed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_page_viewed` (
                                `id_page` int(10) unsigned NOT NULL,
                                `id_shop_group` int(10) unsigned NOT NULL DEFAULT 1,
                                `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                `id_date_range` int(10) unsigned NOT NULL,
                                `counter` int(10) unsigned NOT NULL,
                                PRIMARY KEY (`id_page`,`id_date_range`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_page_viewed`
--

LOCK TABLES `ps_page_viewed` WRITE;
/*!40000 ALTER TABLE `ps_page_viewed` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_page_viewed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_pagenotfound`
--

DROP TABLE IF EXISTS `ps_pagenotfound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_pagenotfound` (
                                 `id_pagenotfound` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                 `id_shop_group` int(10) unsigned NOT NULL DEFAULT 1,
                                 `request_uri` varchar(256) NOT NULL,
                                 `http_referer` varchar(256) NOT NULL,
                                 `date_add` datetime NOT NULL,
                                 PRIMARY KEY (`id_pagenotfound`),
                                 KEY `date_add` (`date_add`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_pagenotfound`
--

LOCK TABLES `ps_pagenotfound` WRITE;
/*!40000 ALTER TABLE `ps_pagenotfound` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_pagenotfound` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product`
--

DROP TABLE IF EXISTS `ps_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product` (
                            `id_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            `id_supplier` int(10) unsigned DEFAULT NULL,
                            `id_manufacturer` int(10) unsigned DEFAULT NULL,
                            `id_category_default` int(10) unsigned DEFAULT NULL,
                            `id_shop_default` int(10) unsigned NOT NULL DEFAULT 1,
                            `id_tax_rules_group` int(11) unsigned NOT NULL,
                            `on_sale` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `online_only` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `ean13` varchar(13) DEFAULT NULL,
                            `upc` varchar(12) DEFAULT NULL,
                            `ecotax` decimal(17,6) NOT NULL DEFAULT 0.000000,
                            `quantity` int(10) NOT NULL DEFAULT 0,
                            `minimal_quantity` int(10) unsigned NOT NULL DEFAULT 1,
                            `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `wholesale_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `unity` varchar(255) DEFAULT NULL,
                            `unit_price_ratio` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `additional_shipping_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
                            `reference` varchar(32) DEFAULT NULL,
                            `supplier_reference` varchar(32) DEFAULT NULL,
                            `location` varchar(64) DEFAULT NULL,
                            `width` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `height` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `depth` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `weight` decimal(20,6) NOT NULL DEFAULT 0.000000,
                            `out_of_stock` int(10) unsigned NOT NULL DEFAULT 2,
                            `quantity_discount` tinyint(1) DEFAULT 0,
                            `customizable` tinyint(2) NOT NULL DEFAULT 0,
                            `uploadable_files` tinyint(4) NOT NULL DEFAULT 0,
                            `text_fields` tinyint(4) NOT NULL DEFAULT 0,
                            `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                            `redirect_type` enum('','404','301','302') NOT NULL DEFAULT '',
                            `id_product_redirected` int(10) unsigned NOT NULL DEFAULT 0,
                            `available_for_order` tinyint(1) NOT NULL DEFAULT 1,
                            `available_date` date NOT NULL DEFAULT '0000-00-00',
                            `condition` enum('new','used','refurbished') NOT NULL DEFAULT 'new',
                            `show_price` tinyint(1) NOT NULL DEFAULT 1,
                            `indexed` tinyint(1) NOT NULL DEFAULT 0,
                            `visibility` enum('both','catalog','search','none') NOT NULL DEFAULT 'both',
                            `cache_is_pack` tinyint(1) NOT NULL DEFAULT 0,
                            `cache_has_attachments` tinyint(1) NOT NULL DEFAULT 0,
                            `is_virtual` tinyint(1) NOT NULL DEFAULT 0,
                            `cache_default_attribute` int(10) unsigned DEFAULT NULL,
                            `date_add` datetime NOT NULL,
                            `date_upd` datetime NOT NULL,
                            `advanced_stock_management` tinyint(1) NOT NULL DEFAULT 0,
                            `pack_stock_type` int(11) unsigned NOT NULL DEFAULT 3,
                            PRIMARY KEY (`id_product`),
                            KEY `product_supplier` (`id_supplier`),
                            KEY `product_manufacturer` (`id_manufacturer`,`id_product`),
                            KEY `id_category_default` (`id_category_default`),
                            KEY `indexed` (`indexed`),
                            KEY `date_add` (`date_add`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product`
--

LOCK TABLES `ps_product` WRITE;
/*!40000 ALTER TABLE `ps_product` DISABLE KEYS */;
INSERT INTO `ps_product` VALUES (1,1,1,5,1,1,0,0,'0','',0.000000,0,1,16.510000,4.950000,'',0.000000,0.00,'demo_1','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(2,1,1,7,1,1,0,0,'0','',0.000000,0,1,26.999852,8.100000,'',0.000000,0.00,'demo_2','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,7,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(3,1,1,9,1,1,0,0,'0','',0.000000,0,1,25.999852,7.800000,'',0.000000,0.00,'demo_3','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,13,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(4,1,1,10,1,1,0,0,'0','',0.000000,0,1,50.994153,15.300000,'',0.000000,0.00,'demo_4','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,16,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(5,1,1,11,1,1,0,0,'0','',0.000000,0,1,30.506321,9.150000,'',0.000000,0.00,'demo_5','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,19,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(6,1,1,11,1,1,0,0,'0','',0.000000,0,1,30.502569,9.150000,'',0.000000,0.00,'demo_6','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,31,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3),(7,1,1,11,1,1,0,0,'0','',0.000000,0,1,20.501236,6.150000,'',0.000000,0.00,'demo_7','','',0.000000,0.000000,0.000000,0.000000,2,0,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',0,0,0,34,'2025-03-04 08:13:15','2025-03-04 08:13:15',0,3);
/*!40000 ALTER TABLE `ps_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_attachment`
--

DROP TABLE IF EXISTS `ps_product_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_attachment` (
                                       `id_product` int(10) unsigned NOT NULL,
                                       `id_attachment` int(10) unsigned NOT NULL,
                                       PRIMARY KEY (`id_product`,`id_attachment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_attachment`
--

LOCK TABLES `ps_product_attachment` WRITE;
/*!40000 ALTER TABLE `ps_product_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_attribute`
--

DROP TABLE IF EXISTS `ps_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_attribute` (
                                      `id_product_attribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                      `id_product` int(10) unsigned NOT NULL,
                                      `reference` varchar(32) DEFAULT NULL,
                                      `supplier_reference` varchar(32) DEFAULT NULL,
                                      `location` varchar(64) DEFAULT NULL,
                                      `ean13` varchar(13) DEFAULT NULL,
                                      `upc` varchar(12) DEFAULT NULL,
                                      `wholesale_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                      `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                      `ecotax` decimal(17,6) NOT NULL DEFAULT 0.000000,
                                      `quantity` int(10) NOT NULL DEFAULT 0,
                                      `weight` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                      `unit_price_impact` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                      `default_on` tinyint(1) unsigned DEFAULT NULL,
                                      `minimal_quantity` int(10) unsigned NOT NULL DEFAULT 1,
                                      `available_date` date NOT NULL DEFAULT '0000-00-00',
                                      PRIMARY KEY (`id_product_attribute`),
                                      UNIQUE KEY `product_default` (`id_product`,`default_on`),
                                      KEY `product_attribute_product` (`id_product`),
                                      KEY `reference` (`reference`),
                                      KEY `supplier_reference` (`supplier_reference`),
                                      KEY `id_product_id_product_attribute` (`id_product_attribute`,`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_attribute`
--

LOCK TABLES `ps_product_attribute` WRITE;
/*!40000 ALTER TABLE `ps_product_attribute` DISABLE KEYS */;
INSERT INTO `ps_product_attribute` VALUES (1,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(2,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(3,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(4,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(5,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(6,1,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(7,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(8,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(9,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(10,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(11,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(12,2,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(13,3,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(14,3,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(15,3,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(16,4,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(17,4,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(18,4,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(19,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(20,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(21,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(22,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(23,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(24,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(25,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(26,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(27,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(28,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(29,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(30,5,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(31,6,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(32,6,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(33,6,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(34,7,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,1,1,'0000-00-00'),(35,7,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(36,7,'','','','','',0.000000,0.000000,0.000000,100,0.000000,0.000000,NULL,1,'0000-00-00'),(37,7,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(38,7,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(39,7,'','','','','',6.150000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(40,6,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(41,6,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(42,6,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(43,4,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(44,4,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00'),(45,4,'','','','','',0.000000,0.000000,0.000000,0,0.000000,0.000000,NULL,1,'0000-00-00');
/*!40000 ALTER TABLE `ps_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_attribute_combination`
--

DROP TABLE IF EXISTS `ps_product_attribute_combination`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_attribute_combination` (
                                                  `id_attribute` int(10) unsigned NOT NULL,
                                                  `id_product_attribute` int(10) unsigned NOT NULL,
                                                  PRIMARY KEY (`id_attribute`,`id_product_attribute`),
                                                  KEY `id_product_attribute` (`id_product_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_attribute_combination`
--

LOCK TABLES `ps_product_attribute_combination` WRITE;
/*!40000 ALTER TABLE `ps_product_attribute_combination` DISABLE KEYS */;
INSERT INTO `ps_product_attribute_combination` VALUES (1,1),(13,1),(1,2),(14,2),(2,3),(13,3),(2,4),(14,4),(3,5),(13,5),(3,6),(14,6),(1,7),(11,7),(1,8),(8,8),(2,9),(11,9),(2,10),(8,10),(3,11),(11,11),(3,12),(8,12),(1,13),(13,13),(2,14),(13,14),(3,15),(13,15),(1,16),(7,16),(2,17),(7,17),(3,18),(7,18),(1,19),(16,19),(1,20),(14,20),(1,21),(13,21),(1,22),(11,22),(2,23),(16,23),(2,24),(14,24),(2,25),(13,25),(2,26),(11,26),(3,27),(16,27),(3,28),(14,28),(3,29),(13,29),(3,30),(11,30),(1,31),(16,31),(2,32),(16,32),(3,33),(16,33),(1,34),(16,34),(2,35),(16,35),(3,36),(16,36),(1,37),(15,37),(2,38),(15,38),(3,39),(15,39),(1,40),(8,40),(2,41),(8,41),(3,42),(8,42),(1,43),(24,43),(2,44),(24,44),(3,45),(24,45);
/*!40000 ALTER TABLE `ps_product_attribute_combination` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_attribute_image`
--

DROP TABLE IF EXISTS `ps_product_attribute_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_attribute_image` (
                                            `id_product_attribute` int(10) unsigned NOT NULL,
                                            `id_image` int(10) unsigned NOT NULL,
                                            PRIMARY KEY (`id_product_attribute`,`id_image`),
                                            KEY `id_image` (`id_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_attribute_image`
--

LOCK TABLES `ps_product_attribute_image` WRITE;
/*!40000 ALTER TABLE `ps_product_attribute_image` DISABLE KEYS */;
INSERT INTO `ps_product_attribute_image` VALUES (1,1),(3,1),(5,1),(1,2),(3,2),(5,2),(2,3),(4,3),(6,3),(2,4),(4,4),(6,4),(8,5),(10,5),(12,5),(8,6),(10,6),(12,6),(7,7),(9,7),(11,7),(16,10),(17,10),(18,10),(43,11),(44,11),(45,11),(19,12),(23,12),(27,12),(20,13),(24,13),(28,13),(21,14),(25,14),(29,14),(22,15),(26,15),(30,15),(31,16),(32,16),(33,16),(31,17),(32,17),(33,17),(40,18),(41,18),(42,18),(40,19),(41,19),(42,19),(34,20),(35,20),(36,20),(34,21),(35,21),(36,21),(37,22),(38,22),(39,22),(37,23),(38,23),(39,23);
/*!40000 ALTER TABLE `ps_product_attribute_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_attribute_shop`
--

DROP TABLE IF EXISTS `ps_product_attribute_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_attribute_shop` (
                                           `id_product` int(10) unsigned NOT NULL,
                                           `id_product_attribute` int(10) unsigned NOT NULL,
                                           `id_shop` int(10) unsigned NOT NULL,
                                           `wholesale_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                           `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                           `ecotax` decimal(17,6) NOT NULL DEFAULT 0.000000,
                                           `weight` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                           `unit_price_impact` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                           `default_on` tinyint(1) unsigned DEFAULT NULL,
                                           `minimal_quantity` int(10) unsigned NOT NULL DEFAULT 1,
                                           `available_date` date NOT NULL DEFAULT '0000-00-00',
                                           PRIMARY KEY (`id_product_attribute`,`id_shop`),
                                           UNIQUE KEY `id_product` (`id_product`,`id_shop`,`default_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_attribute_shop`
--

LOCK TABLES `ps_product_attribute_shop` WRITE;
/*!40000 ALTER TABLE `ps_product_attribute_shop` DISABLE KEYS */;
INSERT INTO `ps_product_attribute_shop` VALUES (1,1,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(1,2,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(1,3,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(1,4,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(1,5,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(1,6,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(2,7,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(2,8,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(2,9,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(2,10,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(2,11,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(2,12,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(3,13,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(3,14,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(3,15,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(4,16,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(4,17,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(4,18,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,19,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(5,20,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,21,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,22,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,23,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,24,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,25,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,26,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,27,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,28,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,29,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(5,30,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(6,31,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(6,32,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(6,33,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(7,34,1,0.000000,0.000000,0.000000,0.000000,0.000000,1,1,'0000-00-00'),(7,35,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(7,36,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(7,37,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(7,38,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(7,39,1,6.150000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(6,40,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(6,41,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(6,42,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(4,43,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(4,44,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00'),(4,45,1,0.000000,0.000000,0.000000,0.000000,0.000000,NULL,1,'0000-00-00');
/*!40000 ALTER TABLE `ps_product_attribute_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_carrier`
--

DROP TABLE IF EXISTS `ps_product_carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_carrier` (
                                    `id_product` int(10) unsigned NOT NULL,
                                    `id_carrier_reference` int(10) unsigned NOT NULL,
                                    `id_shop` int(10) unsigned NOT NULL,
                                    PRIMARY KEY (`id_product`,`id_carrier_reference`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_carrier`
--

LOCK TABLES `ps_product_carrier` WRITE;
/*!40000 ALTER TABLE `ps_product_carrier` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_country_tax`
--

DROP TABLE IF EXISTS `ps_product_country_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_country_tax` (
                                        `id_product` int(11) NOT NULL,
                                        `id_country` int(11) NOT NULL,
                                        `id_tax` int(11) NOT NULL,
                                        PRIMARY KEY (`id_product`,`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_country_tax`
--

LOCK TABLES `ps_product_country_tax` WRITE;
/*!40000 ALTER TABLE `ps_product_country_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_country_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_download`
--

DROP TABLE IF EXISTS `ps_product_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_download` (
                                     `id_product_download` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                     `id_product` int(10) unsigned NOT NULL,
                                     `display_filename` varchar(255) DEFAULT NULL,
                                     `filename` varchar(255) DEFAULT NULL,
                                     `date_add` datetime NOT NULL,
                                     `date_expiration` datetime DEFAULT NULL,
                                     `nb_days_accessible` int(10) unsigned DEFAULT NULL,
                                     `nb_downloadable` int(10) unsigned DEFAULT 1,
                                     `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
                                     `is_shareable` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                     PRIMARY KEY (`id_product_download`),
                                     UNIQUE KEY `id_product` (`id_product`),
                                     KEY `product_active` (`id_product`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_download`
--

LOCK TABLES `ps_product_download` WRITE;
/*!40000 ALTER TABLE `ps_product_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_group_reduction_cache`
--

DROP TABLE IF EXISTS `ps_product_group_reduction_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_group_reduction_cache` (
                                                  `id_product` int(10) unsigned NOT NULL,
                                                  `id_group` int(10) unsigned NOT NULL,
                                                  `reduction` decimal(4,3) NOT NULL,
                                                  PRIMARY KEY (`id_product`,`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_group_reduction_cache`
--

LOCK TABLES `ps_product_group_reduction_cache` WRITE;
/*!40000 ALTER TABLE `ps_product_group_reduction_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_group_reduction_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_lang`
--

DROP TABLE IF EXISTS `ps_product_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_lang` (
                                 `id_product` int(10) unsigned NOT NULL,
                                 `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `description` text DEFAULT NULL,
                                 `description_short` text DEFAULT NULL,
                                 `link_rewrite` varchar(128) NOT NULL,
                                 `meta_description` varchar(255) DEFAULT NULL,
                                 `meta_keywords` varchar(255) DEFAULT NULL,
                                 `meta_title` varchar(128) DEFAULT NULL,
                                 `name` varchar(128) NOT NULL,
                                 `available_now` varchar(255) DEFAULT NULL,
                                 `available_later` varchar(255) DEFAULT NULL,
                                 PRIMARY KEY (`id_product`,`id_shop`,`id_lang`),
                                 KEY `id_lang` (`id_lang`),
                                 KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_lang`
--

LOCK TABLES `ps_product_lang` WRITE;
/*!40000 ALTER TABLE `ps_product_lang` DISABLE KEYS */;
INSERT INTO `ps_product_lang` VALUES (1,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Faded short sleeves t-shirt with high neckline. Soft and stretchy material for a comfortable fit. Accessorize with a straw hat and you\'re ready for summer!</p>','faded-short-sleeves-tshirt','','','','Faded Short Sleeves T-shirt','In stock',''),(2,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which has since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Short-sleeved blouse with feminine draped sleeve detail.</p>','blouse','','','','Blouse','In stock',''),(3,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>100% cotton double printed dress. Black and white striped top and orange high waisted skater skirt bottom.</p>','printed-dress','','','','Printed Dress','In stock',''),(4,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Printed evening dress with straight sleeves with black thin waist belt and ruffled linings.</p>','printed-dress','','','','Printed Dress','In stock',''),(5,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Long printed dress with thin adjustable straps. V-neckline and wiring under the bust with ruffles at the bottom of the dress.</p>','printed-summer-dress','','','','Printed Summer Dress','In stock',''),(6,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Sleeveless knee-length chiffon dress. V-neckline with elastic under the bust lining.</p>','printed-summer-dress','','','','Printed Summer Dress','In stock',''),(7,1,1,'<p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman\'s wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>','<p>Printed chiffon knee length dress with tank straps. Deep v-neckline.</p>','printed-chiffon-dress','','','','Printed Chiffon Dress','In stock','');
/*!40000 ALTER TABLE `ps_product_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_sale`
--

DROP TABLE IF EXISTS `ps_product_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_sale` (
                                 `id_product` int(10) unsigned NOT NULL,
                                 `quantity` int(10) unsigned NOT NULL DEFAULT 0,
                                 `sale_nbr` int(10) unsigned NOT NULL DEFAULT 0,
                                 `date_upd` date NOT NULL,
                                 PRIMARY KEY (`id_product`),
                                 KEY `quantity` (`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_sale`
--

LOCK TABLES `ps_product_sale` WRITE;
/*!40000 ALTER TABLE `ps_product_sale` DISABLE KEYS */;
INSERT INTO `ps_product_sale` VALUES (1,3,3,'2025-03-04'),(2,4,4,'2025-03-04'),(3,3,3,'2025-03-04'),(5,1,1,'2025-03-04'),(6,2,2,'2025-03-04'),(7,2,2,'2025-03-04');
/*!40000 ALTER TABLE `ps_product_sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_shop`
--

DROP TABLE IF EXISTS `ps_product_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_shop` (
                                 `id_product` int(10) unsigned NOT NULL,
                                 `id_shop` int(10) unsigned NOT NULL,
                                 `id_category_default` int(10) unsigned DEFAULT NULL,
                                 `id_tax_rules_group` int(11) unsigned NOT NULL,
                                 `on_sale` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `online_only` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `ecotax` decimal(17,6) NOT NULL DEFAULT 0.000000,
                                 `minimal_quantity` int(10) unsigned NOT NULL DEFAULT 1,
                                 `price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `wholesale_price` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `unity` varchar(255) DEFAULT NULL,
                                 `unit_price_ratio` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                 `additional_shipping_cost` decimal(20,2) NOT NULL DEFAULT 0.00,
                                 `customizable` tinyint(2) NOT NULL DEFAULT 0,
                                 `uploadable_files` tinyint(4) NOT NULL DEFAULT 0,
                                 `text_fields` tinyint(4) NOT NULL DEFAULT 0,
                                 `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                 `redirect_type` enum('','404','301','302') NOT NULL DEFAULT '',
                                 `id_product_redirected` int(10) unsigned NOT NULL DEFAULT 0,
                                 `available_for_order` tinyint(1) NOT NULL DEFAULT 1,
                                 `available_date` date NOT NULL DEFAULT '0000-00-00',
                                 `condition` enum('new','used','refurbished') NOT NULL DEFAULT 'new',
                                 `show_price` tinyint(1) NOT NULL DEFAULT 1,
                                 `indexed` tinyint(1) NOT NULL DEFAULT 0,
                                 `visibility` enum('both','catalog','search','none') NOT NULL DEFAULT 'both',
                                 `cache_default_attribute` int(10) unsigned DEFAULT NULL,
                                 `advanced_stock_management` tinyint(1) NOT NULL DEFAULT 0,
                                 `date_add` datetime NOT NULL,
                                 `date_upd` datetime NOT NULL,
                                 `pack_stock_type` int(11) unsigned NOT NULL DEFAULT 3,
                                 PRIMARY KEY (`id_product`,`id_shop`),
                                 KEY `id_category_default` (`id_category_default`),
                                 KEY `date_add` (`date_add`,`active`,`visibility`),
                                 KEY `indexed` (`indexed`,`active`,`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_shop`
--

LOCK TABLES `ps_product_shop` WRITE;
/*!40000 ALTER TABLE `ps_product_shop` DISABLE KEYS */;
INSERT INTO `ps_product_shop` VALUES (1,1,5,1,0,0,0.000000,1,16.510000,4.950000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',1,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(2,1,7,1,0,0,0.000000,1,26.999852,8.100000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',7,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(3,1,9,1,0,0,0.000000,1,25.999852,7.800000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',13,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(4,1,10,1,0,0,0.000000,1,50.994153,15.300000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',16,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(5,1,11,1,0,0,0.000000,1,30.506321,9.150000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',19,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(6,1,11,1,0,0,0.000000,1,30.502569,9.150000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',31,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3),(7,1,11,1,0,0,0.000000,1,20.501236,6.150000,'',0.000000,0.00,0,0,0,1,'404',0,1,'0000-00-00','new',1,1,'both',34,0,'2025-03-04 08:13:15','2025-03-04 08:13:15',3);
/*!40000 ALTER TABLE `ps_product_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_supplier`
--

DROP TABLE IF EXISTS `ps_product_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_supplier` (
                                     `id_product_supplier` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                     `id_product` int(11) unsigned NOT NULL,
                                     `id_product_attribute` int(11) unsigned NOT NULL DEFAULT 0,
                                     `id_supplier` int(11) unsigned NOT NULL,
                                     `product_supplier_reference` varchar(32) DEFAULT NULL,
                                     `product_supplier_price_te` decimal(20,6) NOT NULL DEFAULT 0.000000,
                                     `id_currency` int(11) unsigned NOT NULL,
                                     PRIMARY KEY (`id_product_supplier`),
                                     UNIQUE KEY `id_product` (`id_product`,`id_product_attribute`,`id_supplier`),
                                     KEY `id_supplier` (`id_supplier`,`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_supplier`
--

LOCK TABLES `ps_product_supplier` WRITE;
/*!40000 ALTER TABLE `ps_product_supplier` DISABLE KEYS */;
INSERT INTO `ps_product_supplier` VALUES (1,1,0,1,'',0.000000,0),(2,2,0,1,'',0.000000,0),(3,3,0,1,'',0.000000,0),(4,4,0,1,'',0.000000,0),(5,5,0,1,'',0.000000,0),(6,6,0,1,'',0.000000,0),(7,7,0,1,'',0.000000,0);
/*!40000 ALTER TABLE `ps_product_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_product_tag`
--

DROP TABLE IF EXISTS `ps_product_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_product_tag` (
                                `id_product` int(10) unsigned NOT NULL,
                                `id_tag` int(10) unsigned NOT NULL,
                                `id_lang` int(10) unsigned NOT NULL,
                                PRIMARY KEY (`id_product`,`id_tag`),
                                KEY `id_tag` (`id_tag`),
                                KEY `id_lang` (`id_lang`,`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_product_tag`
--

LOCK TABLES `ps_product_tag` WRITE;
/*!40000 ALTER TABLE `ps_product_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_product_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_profile`
--

DROP TABLE IF EXISTS `ps_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_profile` (
                            `id_profile` int(10) unsigned NOT NULL AUTO_INCREMENT,
                            PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_profile`
--

LOCK TABLES `ps_profile` WRITE;
/*!40000 ALTER TABLE `ps_profile` DISABLE KEYS */;
INSERT INTO `ps_profile` VALUES (1),(2),(3),(4);
/*!40000 ALTER TABLE `ps_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_profile_lang`
--

DROP TABLE IF EXISTS `ps_profile_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_profile_lang` (
                                 `id_lang` int(10) unsigned NOT NULL,
                                 `id_profile` int(10) unsigned NOT NULL,
                                 `name` varchar(128) NOT NULL,
                                 PRIMARY KEY (`id_profile`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_profile_lang`
--

LOCK TABLES `ps_profile_lang` WRITE;
/*!40000 ALTER TABLE `ps_profile_lang` DISABLE KEYS */;
INSERT INTO `ps_profile_lang` VALUES (1,1,'SuperAdmin'),(1,2,'Logistician'),(1,3,'Translator'),(1,4,'Salesman');
/*!40000 ALTER TABLE `ps_profile_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_pscheckout_cart`
--

DROP TABLE IF EXISTS `ps_pscheckout_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_pscheckout_cart` (
                                    `id_pscheckout_cart` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `id_cart` int(10) unsigned NOT NULL,
                                    `paypal_intent` varchar(20) DEFAULT 'CAPTURE',
                                    `paypal_order` varchar(20) DEFAULT NULL,
                                    `paypal_status` varchar(20) DEFAULT NULL,
                                    `paypal_funding` varchar(20) DEFAULT NULL,
                                    `paypal_token` text DEFAULT NULL,
                                    `paypal_token_expire` datetime DEFAULT NULL,
                                    `paypal_authorization_expire` datetime DEFAULT NULL,
                                    `environment` varchar(20) DEFAULT NULL,
                                    `isExpressCheckout` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                    `isHostedFields` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                    `date_add` datetime NOT NULL,
                                    `date_upd` datetime NOT NULL,
                                    PRIMARY KEY (`id_pscheckout_cart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_pscheckout_cart`
--

LOCK TABLES `ps_pscheckout_cart` WRITE;
/*!40000 ALTER TABLE `ps_pscheckout_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_pscheckout_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_pscheckout_funding_source`
--

DROP TABLE IF EXISTS `ps_pscheckout_funding_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_pscheckout_funding_source` (
                                              `name` varchar(20) NOT NULL,
                                              `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                              `position` tinyint(2) unsigned NOT NULL,
                                              `id_shop` int(10) unsigned NOT NULL,
                                              PRIMARY KEY (`name`,`id_shop`),
                                              KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_pscheckout_funding_source`
--

LOCK TABLES `ps_pscheckout_funding_source` WRITE;
/*!40000 ALTER TABLE `ps_pscheckout_funding_source` DISABLE KEYS */;
INSERT INTO `ps_pscheckout_funding_source` VALUES ('bancontact',1,4,1),('blik',1,10,1),('card',1,3,1),('eps',1,5,1),('giropay',1,6,1),('ideal',1,7,1),('mybank',1,8,1),('p24',1,9,1),('paylater',1,2,1),('paypal',1,1,1);
/*!40000 ALTER TABLE `ps_pscheckout_funding_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_pscheckout_order_matrice`
--

DROP TABLE IF EXISTS `ps_pscheckout_order_matrice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_pscheckout_order_matrice` (
                                             `id_order_matrice` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                             `id_order_prestashop` int(10) unsigned NOT NULL,
                                             `id_order_paypal` varchar(20) NOT NULL,
                                             PRIMARY KEY (`id_order_matrice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_pscheckout_order_matrice`
--

LOCK TABLES `ps_pscheckout_order_matrice` WRITE;
/*!40000 ALTER TABLE `ps_pscheckout_order_matrice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_pscheckout_order_matrice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_quick_access`
--

DROP TABLE IF EXISTS `ps_quick_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_quick_access` (
                                 `id_quick_access` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `new_window` tinyint(1) NOT NULL DEFAULT 0,
                                 `link` varchar(255) NOT NULL,
                                 PRIMARY KEY (`id_quick_access`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_quick_access`
--

LOCK TABLES `ps_quick_access` WRITE;
/*!40000 ALTER TABLE `ps_quick_access` DISABLE KEYS */;
INSERT INTO `ps_quick_access` VALUES (1,0,'index.php?controller=AdminCategories&addcategory'),(2,0,'index.php?controller=AdminProducts&addproduct'),(3,0,'index.php?controller=AdminCartRules&addcart_rule');
/*!40000 ALTER TABLE `ps_quick_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_quick_access_lang`
--

DROP TABLE IF EXISTS `ps_quick_access_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_quick_access_lang` (
                                      `id_quick_access` int(10) unsigned NOT NULL,
                                      `id_lang` int(10) unsigned NOT NULL,
                                      `name` varchar(32) NOT NULL,
                                      PRIMARY KEY (`id_quick_access`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_quick_access_lang`
--

LOCK TABLES `ps_quick_access_lang` WRITE;
/*!40000 ALTER TABLE `ps_quick_access_lang` DISABLE KEYS */;
INSERT INTO `ps_quick_access_lang` VALUES (1,1,'New category'),(2,1,'New product'),(3,1,'New voucher');
/*!40000 ALTER TABLE `ps_quick_access_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_range_price`
--

DROP TABLE IF EXISTS `ps_range_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_range_price` (
                                `id_range_price` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `id_carrier` int(10) unsigned NOT NULL,
                                `delimiter1` decimal(20,6) NOT NULL,
                                `delimiter2` decimal(20,6) NOT NULL,
                                PRIMARY KEY (`id_range_price`),
                                UNIQUE KEY `id_carrier` (`id_carrier`,`delimiter1`,`delimiter2`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_range_price`
--

LOCK TABLES `ps_range_price` WRITE;
/*!40000 ALTER TABLE `ps_range_price` DISABLE KEYS */;
INSERT INTO `ps_range_price` VALUES (1,2,0.000000,10000.000000);
/*!40000 ALTER TABLE `ps_range_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_range_weight`
--

DROP TABLE IF EXISTS `ps_range_weight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_range_weight` (
                                 `id_range_weight` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_carrier` int(10) unsigned NOT NULL,
                                 `delimiter1` decimal(20,6) NOT NULL,
                                 `delimiter2` decimal(20,6) NOT NULL,
                                 PRIMARY KEY (`id_range_weight`),
                                 UNIQUE KEY `id_carrier` (`id_carrier`,`delimiter1`,`delimiter2`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_range_weight`
--

LOCK TABLES `ps_range_weight` WRITE;
/*!40000 ALTER TABLE `ps_range_weight` DISABLE KEYS */;
INSERT INTO `ps_range_weight` VALUES (1,2,0.000000,10000.000000);
/*!40000 ALTER TABLE `ps_range_weight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_referrer`
--

DROP TABLE IF EXISTS `ps_referrer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_referrer` (
                             `id_referrer` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(64) NOT NULL,
                             `passwd` varchar(32) DEFAULT NULL,
                             `http_referer_regexp` varchar(64) DEFAULT NULL,
                             `http_referer_like` varchar(64) DEFAULT NULL,
                             `request_uri_regexp` varchar(64) DEFAULT NULL,
                             `request_uri_like` varchar(64) DEFAULT NULL,
                             `http_referer_regexp_not` varchar(64) DEFAULT NULL,
                             `http_referer_like_not` varchar(64) DEFAULT NULL,
                             `request_uri_regexp_not` varchar(64) DEFAULT NULL,
                             `request_uri_like_not` varchar(64) DEFAULT NULL,
                             `base_fee` decimal(5,2) NOT NULL DEFAULT 0.00,
                             `percent_fee` decimal(5,2) NOT NULL DEFAULT 0.00,
                             `click_fee` decimal(5,2) NOT NULL DEFAULT 0.00,
                             `date_add` datetime NOT NULL,
                             PRIMARY KEY (`id_referrer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_referrer`
--

LOCK TABLES `ps_referrer` WRITE;
/*!40000 ALTER TABLE `ps_referrer` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_referrer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_referrer_cache`
--

DROP TABLE IF EXISTS `ps_referrer_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_referrer_cache` (
                                   `id_connections_source` int(11) unsigned NOT NULL,
                                   `id_referrer` int(11) unsigned NOT NULL,
                                   PRIMARY KEY (`id_connections_source`,`id_referrer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_referrer_cache`
--

LOCK TABLES `ps_referrer_cache` WRITE;
/*!40000 ALTER TABLE `ps_referrer_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_referrer_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_referrer_shop`
--

DROP TABLE IF EXISTS `ps_referrer_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_referrer_shop` (
                                  `id_referrer` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                                  `cache_visitors` int(11) DEFAULT NULL,
                                  `cache_visits` int(11) DEFAULT NULL,
                                  `cache_pages` int(11) DEFAULT NULL,
                                  `cache_registrations` int(11) DEFAULT NULL,
                                  `cache_orders` int(11) DEFAULT NULL,
                                  `cache_sales` decimal(17,2) DEFAULT NULL,
                                  `cache_reg_rate` decimal(5,4) DEFAULT NULL,
                                  `cache_order_rate` decimal(5,4) DEFAULT NULL,
                                  PRIMARY KEY (`id_referrer`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_referrer_shop`
--

LOCK TABLES `ps_referrer_shop` WRITE;
/*!40000 ALTER TABLE `ps_referrer_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_referrer_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_request_sql`
--

DROP TABLE IF EXISTS `ps_request_sql`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_request_sql` (
                                `id_request_sql` int(11) NOT NULL AUTO_INCREMENT,
                                `name` varchar(200) NOT NULL,
                                `sql` text NOT NULL,
                                PRIMARY KEY (`id_request_sql`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_request_sql`
--

LOCK TABLES `ps_request_sql` WRITE;
/*!40000 ALTER TABLE `ps_request_sql` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_request_sql` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_required_field`
--

DROP TABLE IF EXISTS `ps_required_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_required_field` (
                                   `id_required_field` int(11) NOT NULL AUTO_INCREMENT,
                                   `object_name` varchar(32) NOT NULL,
                                   `field_name` varchar(32) NOT NULL,
                                   PRIMARY KEY (`id_required_field`),
                                   KEY `object_name` (`object_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_required_field`
--

LOCK TABLES `ps_required_field` WRITE;
/*!40000 ALTER TABLE `ps_required_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_required_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_risk`
--

DROP TABLE IF EXISTS `ps_risk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_risk` (
                         `id_risk` int(11) unsigned NOT NULL AUTO_INCREMENT,
                         `percent` tinyint(3) NOT NULL,
                         `color` varchar(32) DEFAULT NULL,
                         PRIMARY KEY (`id_risk`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_risk`
--

LOCK TABLES `ps_risk` WRITE;
/*!40000 ALTER TABLE `ps_risk` DISABLE KEYS */;
INSERT INTO `ps_risk` VALUES (1,0,'#32CD32'),(2,35,'#FF8C00'),(3,75,'#DC143C'),(4,100,'#ec2e15');
/*!40000 ALTER TABLE `ps_risk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_risk_lang`
--

DROP TABLE IF EXISTS `ps_risk_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_risk_lang` (
                              `id_risk` int(10) unsigned NOT NULL,
                              `id_lang` int(10) unsigned NOT NULL,
                              `name` varchar(20) NOT NULL,
                              PRIMARY KEY (`id_risk`,`id_lang`),
                              KEY `id_risk` (`id_risk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_risk_lang`
--

LOCK TABLES `ps_risk_lang` WRITE;
/*!40000 ALTER TABLE `ps_risk_lang` DISABLE KEYS */;
INSERT INTO `ps_risk_lang` VALUES (1,1,'None'),(2,1,'Low'),(3,1,'Medium'),(4,1,'High');
/*!40000 ALTER TABLE `ps_risk_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_scene`
--

DROP TABLE IF EXISTS `ps_scene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_scene` (
                          `id_scene` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `active` tinyint(1) NOT NULL DEFAULT 1,
                          PRIMARY KEY (`id_scene`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_scene`
--

LOCK TABLES `ps_scene` WRITE;
/*!40000 ALTER TABLE `ps_scene` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_scene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_scene_category`
--

DROP TABLE IF EXISTS `ps_scene_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_scene_category` (
                                   `id_scene` int(10) unsigned NOT NULL,
                                   `id_category` int(10) unsigned NOT NULL,
                                   PRIMARY KEY (`id_scene`,`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_scene_category`
--

LOCK TABLES `ps_scene_category` WRITE;
/*!40000 ALTER TABLE `ps_scene_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_scene_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_scene_lang`
--

DROP TABLE IF EXISTS `ps_scene_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_scene_lang` (
                               `id_scene` int(10) unsigned NOT NULL,
                               `id_lang` int(10) unsigned NOT NULL,
                               `name` varchar(100) NOT NULL,
                               PRIMARY KEY (`id_scene`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_scene_lang`
--

LOCK TABLES `ps_scene_lang` WRITE;
/*!40000 ALTER TABLE `ps_scene_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_scene_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_scene_products`
--

DROP TABLE IF EXISTS `ps_scene_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_scene_products` (
                                   `id_scene` int(10) unsigned NOT NULL,
                                   `id_product` int(10) unsigned NOT NULL,
                                   `x_axis` int(4) NOT NULL,
                                   `y_axis` int(4) NOT NULL,
                                   `zone_width` int(3) NOT NULL,
                                   `zone_height` int(3) NOT NULL,
                                   PRIMARY KEY (`id_scene`,`id_product`,`x_axis`,`y_axis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_scene_products`
--

LOCK TABLES `ps_scene_products` WRITE;
/*!40000 ALTER TABLE `ps_scene_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_scene_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_scene_shop`
--

DROP TABLE IF EXISTS `ps_scene_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_scene_shop` (
                               `id_scene` int(11) unsigned NOT NULL,
                               `id_shop` int(11) unsigned NOT NULL,
                               PRIMARY KEY (`id_scene`,`id_shop`),
                               KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_scene_shop`
--

LOCK TABLES `ps_scene_shop` WRITE;
/*!40000 ALTER TABLE `ps_scene_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_scene_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_search_engine`
--

DROP TABLE IF EXISTS `ps_search_engine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_search_engine` (
                                  `id_search_engine` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                  `server` varchar(64) NOT NULL,
                                  `getvar` varchar(16) NOT NULL,
                                  PRIMARY KEY (`id_search_engine`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_search_engine`
--

LOCK TABLES `ps_search_engine` WRITE;
/*!40000 ALTER TABLE `ps_search_engine` DISABLE KEYS */;
INSERT INTO `ps_search_engine` VALUES (1,'google','q'),(2,'aol','q'),(3,'yandex','text'),(4,'ask.com','q'),(5,'nhl.com','q'),(6,'yahoo','p'),(7,'baidu','wd'),(8,'lycos','query'),(9,'exalead','q'),(10,'search.live','q'),(11,'voila','rdata'),(12,'altavista','q'),(13,'bing','q'),(14,'daum','q'),(15,'eniro','search_word'),(16,'naver','query'),(17,'msn','q'),(18,'netscape','query'),(19,'cnn','query'),(20,'about','terms'),(21,'mamma','query'),(22,'alltheweb','q'),(23,'virgilio','qs'),(24,'alice','qs'),(25,'najdi','q'),(26,'mama','query'),(27,'seznam','q'),(28,'onet','qt'),(29,'szukacz','q'),(30,'yam','k'),(31,'pchome','q'),(32,'kvasir','q'),(33,'sesam','q'),(34,'ozu','q'),(35,'terra','query'),(36,'mynet','q'),(37,'ekolay','q'),(38,'rambler','words');
/*!40000 ALTER TABLE `ps_search_engine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_search_index`
--

DROP TABLE IF EXISTS `ps_search_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_search_index` (
                                 `id_product` int(11) unsigned NOT NULL,
                                 `id_word` int(11) unsigned NOT NULL,
                                 `weight` smallint(4) unsigned NOT NULL DEFAULT 1,
                                 PRIMARY KEY (`id_word`,`id_product`),
                                 KEY `id_product` (`id_product`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_search_index`
--

LOCK TABLES `ps_search_index` WRITE;
/*!40000 ALTER TABLE `ps_search_index` DISABLE KEYS */;
INSERT INTO `ps_search_index` VALUES (1,6,1),(1,7,1),(1,8,1),(1,9,1),(1,10,1),(1,11,1),(1,12,1),(1,13,1),(1,14,1),(1,15,1),(1,17,1),(1,19,1),(1,20,1),(1,21,1),(1,22,1),(1,24,1),(1,25,1),(1,26,1),(1,27,1),(1,28,1),(1,29,1),(1,30,1),(1,31,1),(1,32,1),(1,33,1),(1,34,1),(1,35,1),(1,36,1),(1,37,1),(1,38,1),(1,39,1),(1,40,1),(1,41,1),(1,42,1),(1,43,1),(1,44,1),(1,45,1),(1,46,1),(1,47,1),(1,48,1),(1,49,1),(1,50,1),(1,51,1),(1,52,1),(1,53,1),(1,54,1),(1,55,1),(1,56,1),(1,57,1),(1,58,1),(1,59,1),(1,60,1),(1,61,1),(1,62,1),(1,63,1),(1,64,1),(1,65,1),(1,66,1),(1,67,1),(1,68,1),(1,16,2),(1,23,2),(1,73,2),(1,74,2),(1,75,2),(1,69,3),(1,70,3),(1,18,5),(1,71,6),(1,72,6),(1,1,7),(1,3,7),(1,4,7),(1,2,9),(1,5,10),(2,16,1),(2,19,1),(2,20,1),(2,21,1),(2,22,1),(2,24,1),(2,25,1),(2,26,1),(2,28,1),(2,29,1),(2,30,1),(2,31,1),(2,32,1),(2,33,1),(2,34,1),(2,35,1),(2,36,1),(2,37,1),(2,38,1),(2,39,1),(2,40,1),(2,41,1),(2,42,1),(2,43,1),(2,44,1),(2,45,1),(2,46,1),(2,47,1),(2,48,1),(2,49,1),(2,50,1),(2,51,1),(2,52,1),(2,53,1),(2,54,1),(2,55,1),(2,56,1),(2,57,1),(2,58,1),(2,59,1),(2,60,1),(2,61,1),(2,62,1),(2,63,1),(2,64,1),(2,65,1),(2,66,1),(2,67,1),(2,68,1),(2,77,1),(2,78,1),(2,79,1),(2,23,2),(2,27,2),(2,73,2),(2,74,2),(2,2,3),(2,70,3),(2,75,3),(2,80,3),(2,18,5),(2,81,6),(2,82,6),(2,76,7),(2,5,10),(3,6,1),(3,16,1),(3,19,1),(3,20,1),(3,21,1),(3,22,1),(3,24,1),(3,25,1),(3,26,1),(3,27,1),(3,28,1),(3,29,1),(3,30,1),(3,31,1),(3,32,1),(3,34,1),(3,35,1),(3,36,1),(3,37,1),(3,38,1),(3,39,1),(3,40,1),(3,41,1),(3,42,1),(3,43,1),(3,44,1),(3,45,1),(3,46,1),(3,47,1),(3,48,1),(3,49,1),(3,50,1),(3,51,1),(3,52,1),(3,53,1),(3,54,1),(3,55,1),(3,56,1),(3,57,1),(3,58,1),(3,59,1),(3,60,1),(3,61,1),(3,62,1),(3,63,1),(3,64,1),(3,65,1),(3,66,1),(3,67,1),(3,68,1),(3,81,1),(3,82,1),(3,143,1),(3,144,1),(3,145,1),(3,146,1),(3,147,1),(3,148,1),(3,149,1),(3,150,1),(3,23,2),(3,151,2),(3,152,2),(3,70,3),(3,73,3),(3,74,3),(3,33,4),(3,18,5),(3,71,7),(3,141,7),(3,142,9),(3,5,10),(4,3,1),(4,16,1),(4,19,1),(4,20,1),(4,21,1),(4,22,1),(4,24,1),(4,25,1),(4,26,1),(4,27,1),(4,28,1),(4,29,1),(4,30,1),(4,31,1),(4,32,1),(4,34,1),(4,35,1),(4,36,1),(4,37,1),(4,38,1),(4,39,1),(4,40,1),(4,41,1),(4,42,1),(4,43,1),(4,44,1),(4,45,1),(4,46,1),(4,47,1),(4,48,1),(4,49,1),(4,50,1),(4,51,1),(4,52,1),(4,53,1),(4,54,1),(4,55,1),(4,56,1),(4,57,1),(4,58,1),(4,59,1),(4,60,1),(4,61,1),(4,62,1),(4,63,1),(4,64,1),(4,65,1),(4,66,1),(4,67,1),(4,68,1),(4,81,1),(4,214,1),(4,215,1),(4,216,1),(4,217,1),(4,218,1),(4,219,1),(4,2,2),(4,23,2),(4,222,2),(4,223,2),(4,70,3),(4,33,4),(4,213,4),(4,18,5),(4,220,6),(4,221,6),(4,141,7),(4,142,9),(4,5,10),(5,7,1),(5,16,1),(5,19,1),(5,20,1),(5,21,1),(5,22,1),(5,24,1),(5,25,1),(5,26,1),(5,27,1),(5,28,1),(5,29,1),(5,30,1),(5,31,1),(5,32,1),(5,34,1),(5,35,1),(5,36,1),(5,37,1),(5,38,1),(5,39,1),(5,40,1),(5,41,1),(5,42,1),(5,43,1),(5,44,1),(5,45,1),(5,46,1),(5,47,1),(5,48,1),(5,49,1),(5,50,1),(5,51,1),(5,52,1),(5,53,1),(5,54,1),(5,55,1),(5,56,1),(5,57,1),(5,58,1),(5,59,1),(5,60,1),(5,61,1),(5,62,1),(5,63,1),(5,64,1),(5,65,1),(5,66,1),(5,67,1),(5,68,1),(5,150,1),(5,215,1),(5,283,1),(5,284,1),(5,285,1),(5,286,1),(5,287,1),(5,288,1),(5,23,2),(5,74,2),(5,222,2),(5,290,2),(5,70,3),(5,33,4),(5,18,5),(5,71,6),(5,72,6),(5,81,6),(5,289,6),(5,141,7),(5,17,9),(5,5,10),(5,142,10),(6,7,1),(6,16,1),(6,19,1),(6,20,1),(6,21,1),(6,22,1),(6,24,1),(6,25,1),(6,26,1),(6,27,1),(6,28,1),(6,29,1),(6,30,1),(6,31,1),(6,32,1),(6,34,1),(6,35,1),(6,36,1),(6,37,1),(6,38,1),(6,39,1),(6,40,1),(6,41,1),(6,42,1),(6,43,1),(6,44,1),(6,45,1),(6,46,1),(6,47,1),(6,48,1),(6,49,1),(6,50,1),(6,51,1),(6,52,1),(6,53,1),(6,54,1),(6,55,1),(6,56,1),(6,57,1),(6,58,1),(6,59,1),(6,60,1),(6,61,1),(6,62,1),(6,63,1),(6,64,1),(6,65,1),(6,66,1),(6,67,1),(6,68,1),(6,287,1),(6,356,1),(6,357,1),(6,358,1),(6,359,1),(6,360,1),(6,361,1),(6,2,2),(6,23,2),(6,151,2),(6,362,2),(6,70,3),(6,33,4),(6,18,5),(6,82,6),(6,141,6),(6,289,6),(6,17,9),(6,142,9),(6,5,10),(7,7,1),(7,16,1),(7,19,1),(7,20,1),(7,21,1),(7,22,1),(7,24,1),(7,25,1),(7,26,1),(7,27,1),(7,28,1),(7,29,1),(7,30,1),(7,31,1),(7,32,1),(7,34,1),(7,35,1),(7,36,1),(7,37,1),(7,38,1),(7,39,1),(7,40,1),(7,41,1),(7,42,1),(7,43,1),(7,44,1),(7,45,1),(7,46,1),(7,47,1),(7,48,1),(7,49,1),(7,50,1),(7,51,1),(7,52,1),(7,53,1),(7,54,1),(7,55,1),(7,56,1),(7,57,1),(7,58,1),(7,59,1),(7,60,1),(7,61,1),(7,62,1),(7,63,1),(7,64,1),(7,65,1),(7,66,1),(7,67,1),(7,68,1),(7,285,1),(7,357,1),(7,358,1),(7,426,1),(7,427,1),(7,23,2),(7,151,2),(7,362,2),(7,429,2),(7,17,3),(7,70,3),(7,33,4),(7,18,5),(7,289,6),(7,428,6),(7,141,7),(7,359,7),(7,142,9),(7,5,10);
/*!40000 ALTER TABLE `ps_search_index` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_search_word`
--

DROP TABLE IF EXISTS `ps_search_word`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_search_word` (
                                `id_word` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                `id_lang` int(10) unsigned NOT NULL,
                                `word` varchar(15) NOT NULL,
                                PRIMARY KEY (`id_word`),
                                UNIQUE KEY `id_lang` (`id_lang`,`id_shop`,`word`)
) ENGINE=InnoDB AUTO_INCREMENT=495 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_search_word`
--

LOCK TABLES `ps_search_word` WRITE;
/*!40000 ALTER TABLE `ps_search_word` DISABLE KEYS */;
INSERT INTO `ps_search_word` VALUES (143,1,1,'100'),(24,1,1,'2010'),(64,1,1,'accessories'),(13,1,1,'accessorize'),(284,1,1,'adjustable'),(60,1,1,'attention'),(54,1,1,'beautiful'),(220,1,1,'beige'),(217,1,1,'belt'),(68,1,1,'belts'),(81,1,1,'black'),(76,1,1,'blouse'),(80,1,1,'blouses'),(72,1,1,'blue'),(150,1,1,'bottom'),(25,1,1,'brand'),(287,1,1,'bust'),(74,1,1,'casual'),(47,1,1,'chic'),(359,1,1,'chiffon'),(37,1,1,'collection'),(22,1,1,'collections'),(152,1,1,'colorful'),(11,1,1,'comfortable'),(45,1,1,'cool'),(73,1,1,'cotton'),(19,1,1,'creating'),(427,1,1,'deep'),(29,1,1,'delivering'),(5,1,1,'demo'),(21,1,1,'designed'),(28,1,1,'designs'),(79,1,1,'detail'),(144,1,1,'double'),(78,1,1,'draped'),(142,1,1,'dress'),(33,1,1,'dresses'),(223,1,1,'dressy'),(46,1,1,'easy'),(360,1,1,'elastic'),(50,1,1,'elegance'),(213,1,1,'evening'),(38,1,1,'every'),(34,1,1,'evolved'),(62,1,1,'extends'),(1,1,1,'faded'),(18,1,1,'fashion'),(27,1,1,'feminine'),(12,1,1,'fit'),(35,1,1,'full'),(151,1,1,'girly'),(59,1,1,'greatest'),(428,1,1,'green'),(15,1,1,'hat'),(67,1,1,'hats'),(6,1,1,'high'),(65,1,1,'including'),(57,1,1,'italy'),(39,1,1,'item'),(357,1,1,'knee'),(358,1,1,'length'),(361,1,1,'lining'),(219,1,1,'linings'),(283,1,1,'long'),(48,1,1,'looks'),(56,1,1,'made'),(58,1,1,'manufactured'),(70,1,1,'manufacturer'),(10,1,1,'material'),(290,1,1,'maxi'),(429,1,1,'midi'),(7,1,1,'neckline'),(61,1,1,'now'),(26,1,1,'offers'),(71,1,1,'orange'),(41,1,1,'part'),(55,1,1,'pieces'),(221,1,1,'pink'),(362,1,1,'polyester'),(141,1,1,'printed'),(63,1,1,'range'),(16,1,1,'ready'),(44,1,1,'result'),(218,1,1,'ruffled'),(288,1,1,'ruffles'),(31,1,1,'separates'),(4,1,1,'shirt'),(69,1,1,'shirts'),(66,1,1,'shoes'),(2,1,1,'short'),(52,1,1,'signature'),(23,1,1,'since'),(148,1,1,'skater'),(149,1,1,'skirt'),(75,1,1,'sleeve'),(77,1,1,'sleeved'),(356,1,1,'sleeveless'),(3,1,1,'sleeves'),(8,1,1,'soft'),(32,1,1,'statement'),(214,1,1,'straight'),(285,1,1,'straps'),(14,1,1,'straw'),(9,1,1,'stretchy'),(145,1,1,'striped'),(53,1,1,'style'),(30,1,1,'stylish'),(17,1,1,'summer'),(426,1,1,'tank'),(215,1,1,'thin'),(146,1,1,'top'),(51,1,1,'unmistakable'),(222,1,1,'viscose'),(40,1,1,'vital'),(216,1,1,'waist'),(147,1,1,'waisted'),(43,1,1,'wardrobe'),(36,1,1,'wear'),(20,1,1,'well'),(82,1,1,'white'),(286,1,1,'wiring'),(42,1,1,'woman'),(289,1,1,'yellow'),(49,1,1,'youthful');
/*!40000 ALTER TABLE `ps_search_word` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_sekeyword`
--

DROP TABLE IF EXISTS `ps_sekeyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_sekeyword` (
                              `id_sekeyword` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
                              `id_shop_group` int(10) unsigned NOT NULL DEFAULT 1,
                              `keyword` varchar(256) NOT NULL,
                              `date_add` datetime NOT NULL,
                              PRIMARY KEY (`id_sekeyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_sekeyword`
--

LOCK TABLES `ps_sekeyword` WRITE;
/*!40000 ALTER TABLE `ps_sekeyword` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_sekeyword` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_shop`
--

DROP TABLE IF EXISTS `ps_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_shop` (
                         `id_shop` int(11) unsigned NOT NULL AUTO_INCREMENT,
                         `id_shop_group` int(11) unsigned NOT NULL,
                         `name` varchar(64) NOT NULL,
                         `id_category` int(11) unsigned NOT NULL DEFAULT 1,
                         `id_theme` int(1) unsigned NOT NULL,
                         `active` tinyint(1) NOT NULL DEFAULT 1,
                         `deleted` tinyint(1) NOT NULL DEFAULT 0,
                         PRIMARY KEY (`id_shop`),
                         KEY `id_shop_group` (`id_shop_group`,`deleted`),
                         KEY `id_category` (`id_category`),
                         KEY `id_theme` (`id_theme`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_shop`
--

LOCK TABLES `ps_shop` WRITE;
/*!40000 ALTER TABLE `ps_shop` DISABLE KEYS */;
INSERT INTO `ps_shop` VALUES (1,1,'PrestaShop',2,1,1,0);
/*!40000 ALTER TABLE `ps_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_shop_group`
--

DROP TABLE IF EXISTS `ps_shop_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_shop_group` (
                               `id_shop_group` int(11) unsigned NOT NULL AUTO_INCREMENT,
                               `name` varchar(64) NOT NULL,
                               `share_customer` tinyint(1) NOT NULL,
                               `share_order` tinyint(1) NOT NULL,
                               `share_stock` tinyint(1) NOT NULL,
                               `active` tinyint(1) NOT NULL DEFAULT 1,
                               `deleted` tinyint(1) NOT NULL DEFAULT 0,
                               PRIMARY KEY (`id_shop_group`),
                               KEY `deleted` (`deleted`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_shop_group`
--

LOCK TABLES `ps_shop_group` WRITE;
/*!40000 ALTER TABLE `ps_shop_group` DISABLE KEYS */;
INSERT INTO `ps_shop_group` VALUES (1,'Default',0,0,0,1,0);
/*!40000 ALTER TABLE `ps_shop_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_shop_url`
--

DROP TABLE IF EXISTS `ps_shop_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_shop_url` (
                             `id_shop_url` int(11) unsigned NOT NULL AUTO_INCREMENT,
                             `id_shop` int(11) unsigned NOT NULL,
                             `domain` varchar(150) NOT NULL,
                             `domain_ssl` varchar(150) NOT NULL,
                             `physical_uri` varchar(64) NOT NULL,
                             `virtual_uri` varchar(64) NOT NULL,
                             `main` tinyint(1) NOT NULL,
                             `active` tinyint(1) NOT NULL,
                             PRIMARY KEY (`id_shop_url`),
                             UNIQUE KEY `full_shop_url` (`domain`,`physical_uri`,`virtual_uri`),
                             UNIQUE KEY `full_shop_url_ssl` (`domain_ssl`,`physical_uri`,`virtual_uri`),
                             KEY `id_shop` (`id_shop`,`main`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_shop_url`
--

LOCK TABLES `ps_shop_url` WRITE;
/*!40000 ALTER TABLE `ps_shop_url` DISABLE KEYS */;
INSERT INTO `ps_shop_url` VALUES (1,1,'localhost:8000','localhost:8000','/','',1,1);
/*!40000 ALTER TABLE `ps_shop_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_smarty_cache`
--

DROP TABLE IF EXISTS `ps_smarty_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_smarty_cache` (
                                 `id_smarty_cache` char(40) NOT NULL,
                                 `name` char(40) NOT NULL,
                                 `cache_id` varchar(254) DEFAULT NULL,
                                 `modified` timestamp NOT NULL DEFAULT current_timestamp(),
                                 `content` longtext NOT NULL,
                                 PRIMARY KEY (`id_smarty_cache`),
                                 KEY `name` (`name`),
                                 KEY `cache_id` (`cache_id`),
                                 KEY `modified` (`modified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_smarty_cache`
--

LOCK TABLES `ps_smarty_cache` WRITE;
/*!40000 ALTER TABLE `ps_smarty_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_smarty_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_smarty_last_flush`
--

DROP TABLE IF EXISTS `ps_smarty_last_flush`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_smarty_last_flush` (
                                      `type` enum('compile','template') NOT NULL,
                                      `last_flush` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                                      PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_smarty_last_flush`
--

LOCK TABLES `ps_smarty_last_flush` WRITE;
/*!40000 ALTER TABLE `ps_smarty_last_flush` DISABLE KEYS */;
INSERT INTO `ps_smarty_last_flush` VALUES ('template','2025-03-04 07:13:14');
/*!40000 ALTER TABLE `ps_smarty_last_flush` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_smarty_lazy_cache`
--

DROP TABLE IF EXISTS `ps_smarty_lazy_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_smarty_lazy_cache` (
                                      `template_hash` varchar(32) NOT NULL DEFAULT '',
                                      `cache_id` varchar(255) NOT NULL DEFAULT '',
                                      `compile_id` varchar(32) NOT NULL DEFAULT '',
                                      `filepath` varchar(255) NOT NULL DEFAULT '',
                                      `last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                                      PRIMARY KEY (`template_hash`,`cache_id`,`compile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_smarty_lazy_cache`
--

LOCK TABLES `ps_smarty_lazy_cache` WRITE;
/*!40000 ALTER TABLE `ps_smarty_lazy_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_smarty_lazy_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_specific_price`
--

DROP TABLE IF EXISTS `ps_specific_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_specific_price` (
                                   `id_specific_price` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                   `id_specific_price_rule` int(11) unsigned NOT NULL,
                                   `id_cart` int(11) unsigned NOT NULL,
                                   `id_product` int(10) unsigned NOT NULL,
                                   `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                   `id_shop_group` int(11) unsigned NOT NULL,
                                   `id_currency` int(10) unsigned NOT NULL,
                                   `id_country` int(10) unsigned NOT NULL,
                                   `id_group` int(10) unsigned NOT NULL,
                                   `id_customer` int(10) unsigned NOT NULL,
                                   `id_product_attribute` int(10) unsigned NOT NULL,
                                   `price` decimal(20,6) NOT NULL,
                                   `from_quantity` mediumint(8) unsigned NOT NULL,
                                   `reduction` decimal(20,6) NOT NULL,
                                   `reduction_tax` tinyint(1) NOT NULL DEFAULT 1,
                                   `reduction_type` enum('amount','percentage') NOT NULL,
                                   `from` datetime NOT NULL,
                                   `to` datetime NOT NULL,
                                   PRIMARY KEY (`id_specific_price`),
                                   UNIQUE KEY `id_product_2` (`id_product`,`id_product_attribute`,`id_customer`,`id_cart`,`from`,`to`,`id_shop`,`id_shop_group`,`id_currency`,`id_country`,`id_group`,`from_quantity`,`id_specific_price_rule`),
                                   KEY `id_product` (`id_product`,`id_shop`,`id_currency`,`id_country`,`id_group`,`id_customer`,`from_quantity`,`from`,`to`),
                                   KEY `from_quantity` (`from_quantity`),
                                   KEY `id_specific_price_rule` (`id_specific_price_rule`),
                                   KEY `id_cart` (`id_cart`),
                                   KEY `id_product_attribute` (`id_product_attribute`),
                                   KEY `id_shop` (`id_shop`),
                                   KEY `id_customer` (`id_customer`),
                                   KEY `from` (`from`),
                                   KEY `to` (`to`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_specific_price`
--

LOCK TABLES `ps_specific_price` WRITE;
/*!40000 ALTER TABLE `ps_specific_price` DISABLE KEYS */;
INSERT INTO `ps_specific_price` VALUES (1,0,0,5,0,0,0,0,0,0,0,-1.000000,1,0.050000,1,'percentage','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,0,0,7,0,0,0,0,0,0,0,-1.000000,1,0.200000,1,'percentage','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ps_specific_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_specific_price_priority`
--

DROP TABLE IF EXISTS `ps_specific_price_priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_specific_price_priority` (
                                            `id_specific_price_priority` int(11) NOT NULL AUTO_INCREMENT,
                                            `id_product` int(11) NOT NULL,
                                            `priority` varchar(80) NOT NULL,
                                            PRIMARY KEY (`id_specific_price_priority`,`id_product`),
                                            UNIQUE KEY `id_product` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_specific_price_priority`
--

LOCK TABLES `ps_specific_price_priority` WRITE;
/*!40000 ALTER TABLE `ps_specific_price_priority` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_specific_price_priority` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_specific_price_rule`
--

DROP TABLE IF EXISTS `ps_specific_price_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_specific_price_rule` (
                                        `id_specific_price_rule` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                        `name` varchar(255) NOT NULL,
                                        `id_shop` int(11) unsigned NOT NULL DEFAULT 1,
                                        `id_currency` int(10) unsigned NOT NULL,
                                        `id_country` int(10) unsigned NOT NULL,
                                        `id_group` int(10) unsigned NOT NULL,
                                        `from_quantity` mediumint(8) unsigned NOT NULL,
                                        `price` decimal(20,6) DEFAULT NULL,
                                        `reduction` decimal(20,6) NOT NULL,
                                        `reduction_tax` tinyint(1) NOT NULL DEFAULT 1,
                                        `reduction_type` enum('amount','percentage') NOT NULL,
                                        `from` datetime NOT NULL,
                                        `to` datetime NOT NULL,
                                        PRIMARY KEY (`id_specific_price_rule`),
                                        KEY `id_product` (`id_shop`,`id_currency`,`id_country`,`id_group`,`from_quantity`,`from`,`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_specific_price_rule`
--

LOCK TABLES `ps_specific_price_rule` WRITE;
/*!40000 ALTER TABLE `ps_specific_price_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_specific_price_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_specific_price_rule_condition`
--

DROP TABLE IF EXISTS `ps_specific_price_rule_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_specific_price_rule_condition` (
                                                  `id_specific_price_rule_condition` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                                  `id_specific_price_rule_condition_group` int(11) unsigned NOT NULL,
                                                  `type` varchar(255) NOT NULL,
                                                  `value` varchar(255) NOT NULL,
                                                  PRIMARY KEY (`id_specific_price_rule_condition`),
                                                  KEY `id_specific_price_rule_condition_group` (`id_specific_price_rule_condition_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_specific_price_rule_condition`
--

LOCK TABLES `ps_specific_price_rule_condition` WRITE;
/*!40000 ALTER TABLE `ps_specific_price_rule_condition` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_specific_price_rule_condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_specific_price_rule_condition_group`
--

DROP TABLE IF EXISTS `ps_specific_price_rule_condition_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_specific_price_rule_condition_group` (
                                                        `id_specific_price_rule_condition_group` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                                        `id_specific_price_rule` int(11) unsigned NOT NULL,
                                                        PRIMARY KEY (`id_specific_price_rule_condition_group`,`id_specific_price_rule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_specific_price_rule_condition_group`
--

LOCK TABLES `ps_specific_price_rule_condition_group` WRITE;
/*!40000 ALTER TABLE `ps_specific_price_rule_condition_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_specific_price_rule_condition_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_state`
--

DROP TABLE IF EXISTS `ps_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_state` (
                          `id_state` int(10) unsigned NOT NULL AUTO_INCREMENT,
                          `id_country` int(11) unsigned NOT NULL,
                          `id_zone` int(11) unsigned NOT NULL,
                          `name` varchar(64) NOT NULL,
                          `iso_code` varchar(7) NOT NULL,
                          `tax_behavior` smallint(1) NOT NULL DEFAULT 0,
                          `active` tinyint(1) NOT NULL DEFAULT 0,
                          PRIMARY KEY (`id_state`),
                          KEY `id_country` (`id_country`),
                          KEY `name` (`name`),
                          KEY `id_zone` (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_state`
--

LOCK TABLES `ps_state` WRITE;
/*!40000 ALTER TABLE `ps_state` DISABLE KEYS */;
INSERT INTO `ps_state` VALUES (1,21,2,'Alabama','AL',0,1),(2,21,2,'Alaska','AK',0,1),(3,21,2,'Arizona','AZ',0,1),(4,21,2,'Arkansas','AR',0,1),(5,21,2,'California','CA',0,1),(6,21,2,'Colorado','CO',0,1),(7,21,2,'Connecticut','CT',0,1),(8,21,2,'Delaware','DE',0,1),(9,21,2,'Florida','FL',0,1),(10,21,2,'Georgia','GA',0,1),(11,21,2,'Hawaii','HI',0,1),(12,21,2,'Idaho','ID',0,1),(13,21,2,'Illinois','IL',0,1),(14,21,2,'Indiana','IN',0,1),(15,21,2,'Iowa','IA',0,1),(16,21,2,'Kansas','KS',0,1),(17,21,2,'Kentucky','KY',0,1),(18,21,2,'Louisiana','LA',0,1),(19,21,2,'Maine','ME',0,1),(20,21,2,'Maryland','MD',0,1),(21,21,2,'Massachusetts','MA',0,1),(22,21,2,'Michigan','MI',0,1),(23,21,2,'Minnesota','MN',0,1),(24,21,2,'Mississippi','MS',0,1),(25,21,2,'Missouri','MO',0,1),(26,21,2,'Montana','MT',0,1),(27,21,2,'Nebraska','NE',0,1),(28,21,2,'Nevada','NV',0,1),(29,21,2,'New Hampshire','NH',0,1),(30,21,2,'New Jersey','NJ',0,1),(31,21,2,'New Mexico','NM',0,1),(32,21,2,'New York','NY',0,1),(33,21,2,'North Carolina','NC',0,1),(34,21,2,'North Dakota','ND',0,1),(35,21,2,'Ohio','OH',0,1),(36,21,2,'Oklahoma','OK',0,1),(37,21,2,'Oregon','OR',0,1),(38,21,2,'Pennsylvania','PA',0,1),(39,21,2,'Rhode Island','RI',0,1),(40,21,2,'South Carolina','SC',0,1),(41,21,2,'South Dakota','SD',0,1),(42,21,2,'Tennessee','TN',0,1),(43,21,2,'Texas','TX',0,1),(44,21,2,'Utah','UT',0,1),(45,21,2,'Vermont','VT',0,1),(46,21,2,'Virginia','VA',0,1),(47,21,2,'Washington','WA',0,1),(48,21,2,'West Virginia','WV',0,1),(49,21,2,'Wisconsin','WI',0,1),(50,21,2,'Wyoming','WY',0,1),(51,21,2,'Puerto Rico','PR',0,1),(52,21,2,'US Virgin Islands','VI',0,1),(53,21,2,'District of Columbia','DC',0,1),(54,145,2,'Aguascalientes','AGS',0,1),(55,145,2,'Baja California','BCN',0,1),(56,145,2,'Baja California Sur','BCS',0,1),(57,145,2,'Campeche','CAM',0,1),(58,145,2,'Chiapas','CHP',0,1),(59,145,2,'Chihuahua','CHH',0,1),(60,145,2,'Coahuila','COA',0,1),(61,145,2,'Colima','COL',0,1),(62,145,2,'Distrito Federal','DIF',0,1),(63,145,2,'Durango','DUR',0,1),(64,145,2,'Guanajuato','GUA',0,1),(65,145,2,'Guerrero','GRO',0,1),(66,145,2,'Hidalgo','HID',0,1),(67,145,2,'Jalisco','JAL',0,1),(68,145,2,'Estado de México','MEX',0,1),(69,145,2,'Michoacán','MIC',0,1),(70,145,2,'Morelos','MOR',0,1),(71,145,2,'Nayarit','NAY',0,1),(72,145,2,'Nuevo León','NLE',0,1),(73,145,2,'Oaxaca','OAX',0,1),(74,145,2,'Puebla','PUE',0,1),(75,145,2,'Querétaro','QUE',0,1),(76,145,2,'Quintana Roo','ROO',0,1),(77,145,2,'San Luis Potosí','SLP',0,1),(78,145,2,'Sinaloa','SIN',0,1),(79,145,2,'Sonora','SON',0,1),(80,145,2,'Tabasco','TAB',0,1),(81,145,2,'Tamaulipas','TAM',0,1),(82,145,2,'Tlaxcala','TLA',0,1),(83,145,2,'Veracruz','VER',0,1),(84,145,2,'Yucatán','YUC',0,1),(85,145,2,'Zacatecas','ZAC',0,1),(86,4,2,'Ontario','ON',0,1),(87,4,2,'Quebec','QC',0,1),(88,4,2,'British Columbia','BC',0,1),(89,4,2,'Alberta','AB',0,1),(90,4,2,'Manitoba','MB',0,1),(91,4,2,'Saskatchewan','SK',0,1),(92,4,2,'Nova Scotia','NS',0,1),(93,4,2,'New Brunswick','NB',0,1),(94,4,2,'Newfoundland and Labrador','NL',0,1),(95,4,2,'Prince Edward Island','PE',0,1),(96,4,2,'Northwest Territories','NT',0,1),(97,4,2,'Yukon','YT',0,1),(98,4,2,'Nunavut','NU',0,1),(99,44,6,'Buenos Aires','B',0,1),(100,44,6,'Catamarca','K',0,1),(101,44,6,'Chaco','H',0,1),(102,44,6,'Chubut','U',0,1),(103,44,6,'Ciudad de Buenos Aires','C',0,1),(104,44,6,'Córdoba','X',0,1),(105,44,6,'Corrientes','W',0,1),(106,44,6,'Entre Ríos','E',0,1),(107,44,6,'Formosa','P',0,1),(108,44,6,'Jujuy','Y',0,1),(109,44,6,'La Pampa','L',0,1),(110,44,6,'La Rioja','F',0,1),(111,44,6,'Mendoza','M',0,1),(112,44,6,'Misiones','N',0,1),(113,44,6,'Neuquén','Q',0,1),(114,44,6,'Río Negro','R',0,1),(115,44,6,'Salta','A',0,1),(116,44,6,'San Juan','J',0,1),(117,44,6,'San Luis','D',0,1),(118,44,6,'Santa Cruz','Z',0,1),(119,44,6,'Santa Fe','S',0,1),(120,44,6,'Santiago del Estero','G',0,1),(121,44,6,'Tierra del Fuego','V',0,1),(122,44,6,'Tucumán','T',0,1),(123,10,1,'Agrigento','AG',0,1),(124,10,1,'Alessandria','AL',0,1),(125,10,1,'Ancona','AN',0,1),(126,10,1,'Aosta','AO',0,1),(127,10,1,'Arezzo','AR',0,1),(128,10,1,'Ascoli Piceno','AP',0,1),(129,10,1,'Asti','AT',0,1),(130,10,1,'Avellino','AV',0,1),(131,10,1,'Bari','BA',0,1),(132,10,1,'Barletta-Andria-Trani','BT',0,1),(133,10,1,'Belluno','BL',0,1),(134,10,1,'Benevento','BN',0,1),(135,10,1,'Bergamo','BG',0,1),(136,10,1,'Biella','BI',0,1),(137,10,1,'Bologna','BO',0,1),(138,10,1,'Bolzano','BZ',0,1),(139,10,1,'Brescia','BS',0,1),(140,10,1,'Brindisi','BR',0,1),(141,10,1,'Cagliari','CA',0,1),(142,10,1,'Caltanissetta','CL',0,1),(143,10,1,'Campobasso','CB',0,1),(144,10,1,'Carbonia-Iglesias','CI',0,1),(145,10,1,'Caserta','CE',0,1),(146,10,1,'Catania','CT',0,1),(147,10,1,'Catanzaro','CZ',0,1),(148,10,1,'Chieti','CH',0,1),(149,10,1,'Como','CO',0,1),(150,10,1,'Cosenza','CS',0,1),(151,10,1,'Cremona','CR',0,1),(152,10,1,'Crotone','KR',0,1),(153,10,1,'Cuneo','CN',0,1),(154,10,1,'Enna','EN',0,1),(155,10,1,'Fermo','FM',0,1),(156,10,1,'Ferrara','FE',0,1),(157,10,1,'Firenze','FI',0,1),(158,10,1,'Foggia','FG',0,1),(159,10,1,'Forlì-Cesena','FC',0,1),(160,10,1,'Frosinone','FR',0,1),(161,10,1,'Genova','GE',0,1),(162,10,1,'Gorizia','GO',0,1),(163,10,1,'Grosseto','GR',0,1),(164,10,1,'Imperia','IM',0,1),(165,10,1,'Isernia','IS',0,1),(166,10,1,'L\'Aquila','AQ',0,1),(167,10,1,'La Spezia','SP',0,1),(168,10,1,'Latina','LT',0,1),(169,10,1,'Lecce','LE',0,1),(170,10,1,'Lecco','LC',0,1),(171,10,1,'Livorno','LI',0,1),(172,10,1,'Lodi','LO',0,1),(173,10,1,'Lucca','LU',0,1),(174,10,1,'Macerata','MC',0,1),(175,10,1,'Mantova','MN',0,1),(176,10,1,'Massa','MS',0,1),(177,10,1,'Matera','MT',0,1),(178,10,1,'Medio Campidano','VS',0,1),(179,10,1,'Messina','ME',0,1),(180,10,1,'Milano','MI',0,1),(181,10,1,'Modena','MO',0,1),(182,10,1,'Monza e della Brianza','MB',0,1),(183,10,1,'Napoli','NA',0,1),(184,10,1,'Novara','NO',0,1),(185,10,1,'Nuoro','NU',0,1),(186,10,1,'Ogliastra','OG',0,1),(187,10,1,'Olbia-Tempio','OT',0,1),(188,10,1,'Oristano','OR',0,1),(189,10,1,'Padova','PD',0,1),(190,10,1,'Palermo','PA',0,1),(191,10,1,'Parma','PR',0,1),(192,10,1,'Pavia','PV',0,1),(193,10,1,'Perugia','PG',0,1),(194,10,1,'Pesaro-Urbino','PU',0,1),(195,10,1,'Pescara','PE',0,1),(196,10,1,'Piacenza','PC',0,1),(197,10,1,'Pisa','PI',0,1),(198,10,1,'Pistoia','PT',0,1),(199,10,1,'Pordenone','PN',0,1),(200,10,1,'Potenza','PZ',0,1),(201,10,1,'Prato','PO',0,1),(202,10,1,'Ragusa','RG',0,1),(203,10,1,'Ravenna','RA',0,1),(204,10,1,'Reggio Calabria','RC',0,1),(205,10,1,'Reggio Emilia','RE',0,1),(206,10,1,'Rieti','RI',0,1),(207,10,1,'Rimini','RN',0,1),(208,10,1,'Roma','RM',0,1),(209,10,1,'Rovigo','RO',0,1),(210,10,1,'Salerno','SA',0,1),(211,10,1,'Sassari','SS',0,1),(212,10,1,'Savona','SV',0,1),(213,10,1,'Siena','SI',0,1),(214,10,1,'Siracusa','SR',0,1),(215,10,1,'Sondrio','SO',0,1),(216,10,1,'Taranto','TA',0,1),(217,10,1,'Teramo','TE',0,1),(218,10,1,'Terni','TR',0,1),(219,10,1,'Torino','TO',0,1),(220,10,1,'Trapani','TP',0,1),(221,10,1,'Trento','TN',0,1),(222,10,1,'Treviso','TV',0,1),(223,10,1,'Trieste','TS',0,1),(224,10,1,'Udine','UD',0,1),(225,10,1,'Varese','VA',0,1),(226,10,1,'Venezia','VE',0,1),(227,10,1,'Verbano-Cusio-Ossola','VB',0,1),(228,10,1,'Vercelli','VC',0,1),(229,10,1,'Verona','VR',0,1),(230,10,1,'Vibo Valentia','VV',0,1),(231,10,1,'Vicenza','VI',0,1),(232,10,1,'Viterbo','VT',0,1),(233,111,3,'Aceh','AC',0,1),(234,111,3,'Bali','BA',0,1),(235,111,3,'Bangka','BB',0,1),(236,111,3,'Banten','BT',0,1),(237,111,3,'Bengkulu','BE',0,1),(238,111,3,'Central Java','JT',0,1),(239,111,3,'Central Kalimantan','KT',0,1),(240,111,3,'Central Sulawesi','ST',0,1),(241,111,3,'Coat of arms of East Java','JI',0,1),(242,111,3,'East kalimantan','KI',0,1),(243,111,3,'East Nusa Tenggara','NT',0,1),(244,111,3,'Lambang propinsi','GO',0,1),(245,111,3,'Jakarta','JK',0,1),(246,111,3,'Jambi','JA',0,1),(247,111,3,'Lampung','LA',0,1),(248,111,3,'Maluku','MA',0,1),(249,111,3,'North Maluku','MU',0,1),(250,111,3,'North Sulawesi','SA',0,1),(251,111,3,'North Sumatra','SU',0,1),(252,111,3,'Papua','PA',0,1),(253,111,3,'Riau','RI',0,1),(254,111,3,'Lambang Riau','KR',0,1),(255,111,3,'Southeast Sulawesi','SG',0,1),(256,111,3,'South Kalimantan','KS',0,1),(257,111,3,'South Sulawesi','SN',0,1),(258,111,3,'South Sumatra','SS',0,1),(259,111,3,'West Java','JB',0,1),(260,111,3,'West Kalimantan','KB',0,1),(261,111,3,'West Nusa Tenggara','NB',0,1),(262,111,3,'Lambang Provinsi Papua Barat','PB',0,1),(263,111,3,'West Sulawesi','SR',0,1),(264,111,3,'West Sumatra','SB',0,1),(265,111,3,'Yogyakarta','YO',0,1),(266,11,3,'Aichi','23',0,1),(267,11,3,'Akita','05',0,1),(268,11,3,'Aomori','02',0,1),(269,11,3,'Chiba','12',0,1),(270,11,3,'Ehime','38',0,1),(271,11,3,'Fukui','18',0,1),(272,11,3,'Fukuoka','40',0,1),(273,11,3,'Fukushima','07',0,1),(274,11,3,'Gifu','21',0,1),(275,11,3,'Gunma','10',0,1),(276,11,3,'Hiroshima','34',0,1),(277,11,3,'Hokkaido','01',0,1),(278,11,3,'Hyogo','28',0,1),(279,11,3,'Ibaraki','08',0,1),(280,11,3,'Ishikawa','17',0,1),(281,11,3,'Iwate','03',0,1),(282,11,3,'Kagawa','37',0,1),(283,11,3,'Kagoshima','46',0,1),(284,11,3,'Kanagawa','14',0,1),(285,11,3,'Kochi','39',0,1),(286,11,3,'Kumamoto','43',0,1),(287,11,3,'Kyoto','26',0,1),(288,11,3,'Mie','24',0,1),(289,11,3,'Miyagi','04',0,1),(290,11,3,'Miyazaki','45',0,1),(291,11,3,'Nagano','20',0,1),(292,11,3,'Nagasaki','42',0,1),(293,11,3,'Nara','29',0,1),(294,11,3,'Niigata','15',0,1),(295,11,3,'Oita','44',0,1),(296,11,3,'Okayama','33',0,1),(297,11,3,'Okinawa','47',0,1),(298,11,3,'Osaka','27',0,1),(299,11,3,'Saga','41',0,1),(300,11,3,'Saitama','11',0,1),(301,11,3,'Shiga','25',0,1),(302,11,3,'Shimane','32',0,1),(303,11,3,'Shizuoka','22',0,1),(304,11,3,'Tochigi','09',0,1),(305,11,3,'Tokushima','36',0,1),(306,11,3,'Tokyo','13',0,1),(307,11,3,'Tottori','31',0,1),(308,11,3,'Toyama','16',0,1),(309,11,3,'Wakayama','30',0,1),(310,11,3,'Yamagata','06',0,1),(311,11,3,'Yamaguchi','35',0,1),(312,11,3,'Yamanashi','19',0,1);
/*!40000 ALTER TABLE `ps_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_statssearch`
--

DROP TABLE IF EXISTS `ps_statssearch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_statssearch` (
  `id_statssearch` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL DEFAULT 1,
  `id_shop_group` int(10) unsigned NOT NULL DEFAULT 1,
  `keywords` varchar(255) NOT NULL,
  `results` int(6) NOT NULL DEFAULT 0,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_statssearch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_statssearch`
--

LOCK TABLES `ps_statssearch` WRITE;
/*!40000 ALTER TABLE `ps_statssearch` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_statssearch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_stock`
--

DROP TABLE IF EXISTS `ps_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_stock` (
  `id_stock` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_warehouse` int(11) unsigned NOT NULL,
  `id_product` int(11) unsigned NOT NULL,
  `id_product_attribute` int(11) unsigned NOT NULL,
  `reference` varchar(32) NOT NULL,
  `ean13` varchar(13) DEFAULT NULL,
  `upc` varchar(12) DEFAULT NULL,
  `physical_quantity` int(11) unsigned NOT NULL,
  `usable_quantity` int(11) unsigned NOT NULL,
  `price_te` decimal(20,6) DEFAULT 0.000000,
  PRIMARY KEY (`id_stock`),
  KEY `id_warehouse` (`id_warehouse`),
  KEY `id_product` (`id_product`),
  KEY `id_product_attribute` (`id_product_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_stock`
--

LOCK TABLES `ps_stock` WRITE;
/*!40000 ALTER TABLE `ps_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_stock_available`
--

DROP TABLE IF EXISTS `ps_stock_available`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_stock_available` (
  `id_stock_available` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_product` int(11) unsigned NOT NULL,
  `id_product_attribute` int(11) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL,
  `id_shop_group` int(11) unsigned NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT 0,
  `depends_on_stock` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `out_of_stock` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_stock_available`),
  UNIQUE KEY `product_sqlstock` (`id_product`,`id_product_attribute`,`id_shop`,`id_shop_group`),
  KEY `id_shop` (`id_shop`),
  KEY `id_shop_group` (`id_shop_group`),
  KEY `id_product` (`id_product`),
  KEY `id_product_attribute` (`id_product_attribute`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_stock_available`
--

LOCK TABLES `ps_stock_available` WRITE;
/*!40000 ALTER TABLE `ps_stock_available` DISABLE KEYS */;
INSERT INTO `ps_stock_available` VALUES (1,1,0,1,0,1799,0,2),(2,2,0,1,0,1799,0,2),(3,3,0,1,0,899,0,2),(4,4,0,1,0,900,0,2),(5,5,0,1,0,3600,0,2),(6,6,0,1,0,900,0,2),(7,7,0,1,0,1800,0,2),(8,1,1,1,0,299,0,2),(9,1,2,1,0,300,0,2),(10,1,3,1,0,300,0,2),(11,1,4,1,0,300,0,2),(12,1,5,1,0,300,0,2),(13,1,6,1,0,300,0,2),(14,2,7,1,0,299,0,2),(15,2,8,1,0,300,0,2),(16,2,9,1,0,300,0,2),(17,2,10,1,0,300,0,2),(18,2,11,1,0,300,0,2),(19,2,12,1,0,300,0,2),(20,3,13,1,0,299,0,2),(21,3,14,1,0,300,0,2),(22,3,15,1,0,300,0,2),(23,4,16,1,0,300,0,2),(24,4,17,1,0,300,0,2),(25,4,18,1,0,300,0,2),(26,5,19,1,0,300,0,2),(27,5,20,1,0,300,0,2),(28,5,21,1,0,300,0,2),(29,5,22,1,0,300,0,2),(30,5,23,1,0,300,0,2),(31,5,24,1,0,300,0,2),(32,5,25,1,0,300,0,2),(33,5,26,1,0,300,0,2),(34,5,27,1,0,300,0,2),(35,5,28,1,0,300,0,2),(36,5,29,1,0,300,0,2),(37,5,30,1,0,300,0,2),(38,6,31,1,0,300,0,2),(39,6,32,1,0,300,0,2),(40,6,33,1,0,300,0,2),(41,7,34,1,0,300,0,2),(42,7,35,1,0,300,0,2),(43,7,36,1,0,300,0,2),(44,7,37,1,0,300,0,2),(45,7,38,1,0,300,0,2),(46,7,39,1,0,300,0,2),(47,6,40,1,0,0,0,2),(48,6,41,1,0,0,0,2),(49,6,42,1,0,0,0,2),(50,4,43,1,0,0,0,2),(51,4,44,1,0,0,0,2),(52,4,45,1,0,0,0,2);
/*!40000 ALTER TABLE `ps_stock_available` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_stock_mvt`
--

DROP TABLE IF EXISTS `ps_stock_mvt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_stock_mvt` (
  `id_stock_mvt` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_stock` int(11) unsigned NOT NULL,
  `id_order` int(11) unsigned DEFAULT NULL,
  `id_supply_order` int(11) unsigned DEFAULT NULL,
  `id_stock_mvt_reason` int(11) unsigned NOT NULL,
  `id_employee` int(11) unsigned NOT NULL,
  `employee_lastname` varchar(32) DEFAULT '',
  `employee_firstname` varchar(32) DEFAULT '',
  `physical_quantity` int(11) unsigned NOT NULL,
  `date_add` datetime NOT NULL,
  `sign` tinyint(1) NOT NULL DEFAULT 1,
  `price_te` decimal(20,6) DEFAULT 0.000000,
  `last_wa` decimal(20,6) DEFAULT 0.000000,
  `current_wa` decimal(20,6) DEFAULT 0.000000,
  `referer` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_stock_mvt`),
  KEY `id_stock` (`id_stock`),
  KEY `id_stock_mvt_reason` (`id_stock_mvt_reason`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_stock_mvt`
--

LOCK TABLES `ps_stock_mvt` WRITE;
/*!40000 ALTER TABLE `ps_stock_mvt` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_stock_mvt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_stock_mvt_reason`
--

DROP TABLE IF EXISTS `ps_stock_mvt_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_stock_mvt_reason` (
  `id_stock_mvt_reason` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sign` tinyint(1) NOT NULL DEFAULT 1,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_stock_mvt_reason`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_stock_mvt_reason`
--

LOCK TABLES `ps_stock_mvt_reason` WRITE;
/*!40000 ALTER TABLE `ps_stock_mvt_reason` DISABLE KEYS */;
INSERT INTO `ps_stock_mvt_reason` VALUES (1,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(2,-1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(3,-1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(4,-1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(5,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(6,-1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(7,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0),(8,1,'2025-03-04 08:13:15','2025-03-04 08:13:15',0);
/*!40000 ALTER TABLE `ps_stock_mvt_reason` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_stock_mvt_reason_lang`
--

DROP TABLE IF EXISTS `ps_stock_mvt_reason_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_stock_mvt_reason_lang` (
  `id_stock_mvt_reason` int(11) unsigned NOT NULL,
  `id_lang` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_stock_mvt_reason`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_stock_mvt_reason_lang`
--

LOCK TABLES `ps_stock_mvt_reason_lang` WRITE;
/*!40000 ALTER TABLE `ps_stock_mvt_reason_lang` DISABLE KEYS */;
INSERT INTO `ps_stock_mvt_reason_lang` VALUES (1,1,'Increase'),(2,1,'Decrease'),(3,1,'Customer Order'),(4,1,'Regulation following an inventory of stock'),(5,1,'Regulation following an inventory of stock'),(6,1,'Transfer to another warehouse'),(7,1,'Transfer from another warehouse'),(8,1,'Supply Order');
/*!40000 ALTER TABLE `ps_stock_mvt_reason_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_store`
--

DROP TABLE IF EXISTS `ps_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_store` (
  `id_store` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_country` int(10) unsigned NOT NULL,
  `id_state` int(10) unsigned DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `address1` varchar(128) NOT NULL,
  `address2` varchar(128) DEFAULT NULL,
  `city` varchar(64) NOT NULL,
  `postcode` varchar(12) NOT NULL,
  `latitude` decimal(13,8) DEFAULT NULL,
  `longitude` decimal(13,8) DEFAULT NULL,
  `hours` varchar(254) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `fax` varchar(16) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_store`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_store`
--

LOCK TABLES `ps_store` WRITE;
/*!40000 ALTER TABLE `ps_store` DISABLE KEYS */;
INSERT INTO `ps_store` VALUES (1,21,9,'Dade County','3030 SW 8th St Miami','','Miami',' 33135',25.76500500,-80.24379700,'a:7:{i:0;s:13:\"09:00 - 19:00\";i:1;s:13:\"09:00 - 19:00\";i:2;s:13:\"09:00 - 19:00\";i:3;s:13:\"09:00 - 19:00\";i:4;s:13:\"09:00 - 19:00\";i:5;s:13:\"10:00 - 16:00\";i:6;s:13:\"10:00 - 16:00\";}','','','','',1,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(2,21,9,'E Fort Lauderdale','1000 Northeast 4th Ave Fort Lauderdale','','Miami',' 33304',26.13793600,-80.13943500,'a:7:{i:0;s:13:\"09:00 - 19:00\";i:1;s:13:\"09:00 - 19:00\";i:2;s:13:\"09:00 - 19:00\";i:3;s:13:\"09:00 - 19:00\";i:4;s:13:\"09:00 - 19:00\";i:5;s:13:\"10:00 - 16:00\";i:6;s:13:\"10:00 - 16:00\";}','','','','',1,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(3,21,9,'Pembroke Pines','11001 Pines Blvd Pembroke Pines','','Miami','33026',26.00998700,-80.29447200,'a:7:{i:0;s:13:\"09:00 - 19:00\";i:1;s:13:\"09:00 - 19:00\";i:2;s:13:\"09:00 - 19:00\";i:3;s:13:\"09:00 - 19:00\";i:4;s:13:\"09:00 - 19:00\";i:5;s:13:\"10:00 - 16:00\";i:6;s:13:\"10:00 - 16:00\";}','','','','',1,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(4,21,9,'Coconut Grove','2999 SW 32nd Avenue','','Miami',' 33133',25.73629600,-80.24479700,'a:7:{i:0;s:13:\"09:00 - 19:00\";i:1;s:13:\"09:00 - 19:00\";i:2;s:13:\"09:00 - 19:00\";i:3;s:13:\"09:00 - 19:00\";i:4;s:13:\"09:00 - 19:00\";i:5;s:13:\"10:00 - 16:00\";i:6;s:13:\"10:00 - 16:00\";}','','','','',1,'2025-03-04 08:13:15','2025-03-04 08:13:15'),(5,21,9,'N Miami/Biscayne','12055 Biscayne Blvd','','Miami','33181',25.88674000,-80.16329200,'a:7:{i:0;s:13:\"09:00 - 19:00\";i:1;s:13:\"09:00 - 19:00\";i:2;s:13:\"09:00 - 19:00\";i:3;s:13:\"09:00 - 19:00\";i:4;s:13:\"09:00 - 19:00\";i:5;s:13:\"10:00 - 16:00\";i:6;s:13:\"10:00 - 16:00\";}','','','','',1,'2025-03-04 08:13:15','2025-03-04 08:13:15');
/*!40000 ALTER TABLE `ps_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_store_shop`
--

DROP TABLE IF EXISTS `ps_store_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_store_shop` (
                               `id_store` int(11) unsigned NOT NULL,
                               `id_shop` int(11) unsigned NOT NULL,
                               PRIMARY KEY (`id_store`,`id_shop`),
                               KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_store_shop`
--

LOCK TABLES `ps_store_shop` WRITE;
/*!40000 ALTER TABLE `ps_store_shop` DISABLE KEYS */;
INSERT INTO `ps_store_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1);
/*!40000 ALTER TABLE `ps_store_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supplier`
--

DROP TABLE IF EXISTS `ps_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supplier` (
                             `id_supplier` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(64) NOT NULL,
                             `date_add` datetime NOT NULL,
                             `date_upd` datetime NOT NULL,
                             `active` tinyint(1) NOT NULL DEFAULT 0,
                             PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supplier`
--

LOCK TABLES `ps_supplier` WRITE;
/*!40000 ALTER TABLE `ps_supplier` DISABLE KEYS */;
INSERT INTO `ps_supplier` VALUES (1,'Fashion Supplier','2025-03-04 08:13:15','2025-03-04 08:13:15',1);
/*!40000 ALTER TABLE `ps_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supplier_lang`
--

DROP TABLE IF EXISTS `ps_supplier_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supplier_lang` (
                                  `id_supplier` int(10) unsigned NOT NULL,
                                  `id_lang` int(10) unsigned NOT NULL,
                                  `description` text DEFAULT NULL,
                                  `meta_title` varchar(128) DEFAULT NULL,
                                  `meta_keywords` varchar(255) DEFAULT NULL,
                                  `meta_description` varchar(255) DEFAULT NULL,
                                  PRIMARY KEY (`id_supplier`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supplier_lang`
--

LOCK TABLES `ps_supplier_lang` WRITE;
/*!40000 ALTER TABLE `ps_supplier_lang` DISABLE KEYS */;
INSERT INTO `ps_supplier_lang` VALUES (1,1,'','','','');
/*!40000 ALTER TABLE `ps_supplier_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supplier_shop`
--

DROP TABLE IF EXISTS `ps_supplier_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supplier_shop` (
                                  `id_supplier` int(11) unsigned NOT NULL,
                                  `id_shop` int(11) unsigned NOT NULL,
                                  PRIMARY KEY (`id_supplier`,`id_shop`),
                                  KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supplier_shop`
--

LOCK TABLES `ps_supplier_shop` WRITE;
/*!40000 ALTER TABLE `ps_supplier_shop` DISABLE KEYS */;
INSERT INTO `ps_supplier_shop` VALUES (1,1);
/*!40000 ALTER TABLE `ps_supplier_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order`
--

DROP TABLE IF EXISTS `ps_supply_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order` (
                                 `id_supply_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                 `id_supplier` int(11) unsigned NOT NULL,
                                 `supplier_name` varchar(64) NOT NULL,
                                 `id_lang` int(11) unsigned NOT NULL,
                                 `id_warehouse` int(11) unsigned NOT NULL,
                                 `id_supply_order_state` int(11) unsigned NOT NULL,
                                 `id_currency` int(11) unsigned NOT NULL,
                                 `id_ref_currency` int(11) unsigned NOT NULL,
                                 `reference` varchar(64) NOT NULL,
                                 `date_add` datetime NOT NULL,
                                 `date_upd` datetime NOT NULL,
                                 `date_delivery_expected` datetime DEFAULT NULL,
                                 `total_te` decimal(20,6) DEFAULT 0.000000,
                                 `total_with_discount_te` decimal(20,6) DEFAULT 0.000000,
                                 `total_tax` decimal(20,6) DEFAULT 0.000000,
                                 `total_ti` decimal(20,6) DEFAULT 0.000000,
                                 `discount_rate` decimal(20,6) DEFAULT 0.000000,
                                 `discount_value_te` decimal(20,6) DEFAULT 0.000000,
                                 `is_template` tinyint(1) DEFAULT 0,
                                 PRIMARY KEY (`id_supply_order`),
                                 KEY `id_supplier` (`id_supplier`),
                                 KEY `id_warehouse` (`id_warehouse`),
                                 KEY `reference` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order`
--

LOCK TABLES `ps_supply_order` WRITE;
/*!40000 ALTER TABLE `ps_supply_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_supply_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order_detail`
--

DROP TABLE IF EXISTS `ps_supply_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order_detail` (
                                        `id_supply_order_detail` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                        `id_supply_order` int(11) unsigned NOT NULL,
                                        `id_currency` int(11) unsigned NOT NULL,
                                        `id_product` int(11) unsigned NOT NULL,
                                        `id_product_attribute` int(11) unsigned NOT NULL,
                                        `reference` varchar(32) NOT NULL,
                                        `supplier_reference` varchar(32) NOT NULL,
                                        `name` varchar(128) NOT NULL,
                                        `ean13` varchar(13) DEFAULT NULL,
                                        `upc` varchar(12) DEFAULT NULL,
                                        `exchange_rate` decimal(20,6) DEFAULT 0.000000,
                                        `unit_price_te` decimal(20,6) DEFAULT 0.000000,
                                        `quantity_expected` int(11) unsigned NOT NULL,
                                        `quantity_received` int(11) unsigned NOT NULL,
                                        `price_te` decimal(20,6) DEFAULT 0.000000,
                                        `discount_rate` decimal(20,6) DEFAULT 0.000000,
                                        `discount_value_te` decimal(20,6) DEFAULT 0.000000,
                                        `price_with_discount_te` decimal(20,6) DEFAULT 0.000000,
                                        `tax_rate` decimal(20,6) DEFAULT 0.000000,
                                        `tax_value` decimal(20,6) DEFAULT 0.000000,
                                        `price_ti` decimal(20,6) DEFAULT 0.000000,
                                        `tax_value_with_order_discount` decimal(20,6) DEFAULT 0.000000,
                                        `price_with_order_discount_te` decimal(20,6) DEFAULT 0.000000,
                                        PRIMARY KEY (`id_supply_order_detail`),
                                        KEY `id_supply_order` (`id_supply_order`,`id_product`),
                                        KEY `id_product_attribute` (`id_product_attribute`),
                                        KEY `id_product_product_attribute` (`id_product`,`id_product_attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order_detail`
--

LOCK TABLES `ps_supply_order_detail` WRITE;
/*!40000 ALTER TABLE `ps_supply_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_supply_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order_history`
--

DROP TABLE IF EXISTS `ps_supply_order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order_history` (
                                         `id_supply_order_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                         `id_supply_order` int(11) unsigned NOT NULL,
                                         `id_employee` int(11) unsigned NOT NULL,
                                         `employee_lastname` varchar(32) DEFAULT '',
                                         `employee_firstname` varchar(32) DEFAULT '',
                                         `id_state` int(11) unsigned NOT NULL,
                                         `date_add` datetime NOT NULL,
                                         PRIMARY KEY (`id_supply_order_history`),
                                         KEY `id_supply_order` (`id_supply_order`),
                                         KEY `id_employee` (`id_employee`),
                                         KEY `id_state` (`id_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order_history`
--

LOCK TABLES `ps_supply_order_history` WRITE;
/*!40000 ALTER TABLE `ps_supply_order_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_supply_order_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order_receipt_history`
--

DROP TABLE IF EXISTS `ps_supply_order_receipt_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order_receipt_history` (
                                                 `id_supply_order_receipt_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                                 `id_supply_order_detail` int(11) unsigned NOT NULL,
                                                 `id_employee` int(11) unsigned NOT NULL,
                                                 `employee_lastname` varchar(32) DEFAULT '',
                                                 `employee_firstname` varchar(32) DEFAULT '',
                                                 `id_supply_order_state` int(11) unsigned NOT NULL,
                                                 `quantity` int(11) unsigned NOT NULL,
                                                 `date_add` datetime NOT NULL,
                                                 PRIMARY KEY (`id_supply_order_receipt_history`),
                                                 KEY `id_supply_order_detail` (`id_supply_order_detail`),
                                                 KEY `id_supply_order_state` (`id_supply_order_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order_receipt_history`
--

LOCK TABLES `ps_supply_order_receipt_history` WRITE;
/*!40000 ALTER TABLE `ps_supply_order_receipt_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_supply_order_receipt_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order_state`
--

DROP TABLE IF EXISTS `ps_supply_order_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order_state` (
                                       `id_supply_order_state` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                       `delivery_note` tinyint(1) NOT NULL DEFAULT 0,
                                       `editable` tinyint(1) NOT NULL DEFAULT 0,
                                       `receipt_state` tinyint(1) NOT NULL DEFAULT 0,
                                       `pending_receipt` tinyint(1) NOT NULL DEFAULT 0,
                                       `enclosed` tinyint(1) NOT NULL DEFAULT 0,
                                       `color` varchar(32) DEFAULT NULL,
                                       PRIMARY KEY (`id_supply_order_state`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order_state`
--

LOCK TABLES `ps_supply_order_state` WRITE;
/*!40000 ALTER TABLE `ps_supply_order_state` DISABLE KEYS */;
INSERT INTO `ps_supply_order_state` VALUES (1,0,1,0,0,0,'#faab00'),(2,1,0,0,0,0,'#273cff'),(3,0,0,0,1,0,'#ff37f5'),(4,0,0,1,1,0,'#ff3e33'),(5,0,0,1,0,1,'#00d60c'),(6,0,0,0,0,1,'#666666');
/*!40000 ALTER TABLE `ps_supply_order_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_supply_order_state_lang`
--

DROP TABLE IF EXISTS `ps_supply_order_state_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_supply_order_state_lang` (
                                            `id_supply_order_state` int(11) unsigned NOT NULL,
                                            `id_lang` int(11) unsigned NOT NULL,
                                            `name` varchar(128) DEFAULT NULL,
                                            PRIMARY KEY (`id_supply_order_state`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_supply_order_state_lang`
--

LOCK TABLES `ps_supply_order_state_lang` WRITE;
/*!40000 ALTER TABLE `ps_supply_order_state_lang` DISABLE KEYS */;
INSERT INTO `ps_supply_order_state_lang` VALUES (1,1,'1 - Creation in progress'),(2,1,'2 - Order validated'),(3,1,'3 - Pending receipt'),(4,1,'4 - Order received in part'),(5,1,'5 - Order received completely'),(6,1,'6 - Order canceled');
/*!40000 ALTER TABLE `ps_supply_order_state_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tab`
--

DROP TABLE IF EXISTS `ps_tab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tab` (
                        `id_tab` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `id_parent` int(11) NOT NULL,
                        `class_name` varchar(64) NOT NULL,
                        `module` varchar(64) DEFAULT NULL,
                        `position` int(10) unsigned NOT NULL,
                        `active` tinyint(1) NOT NULL DEFAULT 1,
                        `hide_host_mode` tinyint(1) NOT NULL DEFAULT 0,
                        PRIMARY KEY (`id_tab`),
                        KEY `class_name` (`class_name`),
                        KEY `id_parent` (`id_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tab`
--

LOCK TABLES `ps_tab` WRITE;
/*!40000 ALTER TABLE `ps_tab` DISABLE KEYS */;
INSERT INTO `ps_tab` VALUES (1,0,'AdminDashboard',NULL,0,1,0),(2,-1,'AdminCms',NULL,0,1,0),(3,-1,'AdminCmsCategories',NULL,1,1,0),(4,-1,'AdminAttributeGenerator',NULL,2,1,0),(5,-1,'AdminSearch',NULL,3,1,0),(6,-1,'AdminLogin',NULL,4,1,0),(7,-1,'AdminShop',NULL,5,1,0),(8,-1,'AdminShopUrl',NULL,6,1,0),(9,0,'AdminCatalog',NULL,1,1,0),(10,0,'AdminParentOrders',NULL,2,1,0),(11,0,'AdminParentCustomer',NULL,3,1,0),(12,0,'AdminPriceRule',NULL,4,1,0),(13,0,'AdminParentModules',NULL,5,1,0),(14,0,'AdminParentShipping',NULL,6,1,0),(15,0,'AdminParentLocalization',NULL,7,1,0),(16,0,'AdminParentPreferences',NULL,8,1,0),(17,0,'AdminTools',NULL,9,1,0),(18,0,'AdminAdmin',NULL,10,1,0),(19,0,'AdminParentStats',NULL,11,1,0),(20,0,'AdminStock',NULL,12,1,0),(21,9,'AdminProducts',NULL,0,1,0),(22,9,'AdminCategories',NULL,1,1,0),(23,9,'AdminTracking',NULL,2,1,0),(24,9,'AdminAttributesGroups',NULL,3,1,0),(25,9,'AdminFeatures',NULL,4,1,0),(26,9,'AdminManufacturers',NULL,5,1,0),(27,9,'AdminSuppliers',NULL,6,1,0),(28,9,'AdminTags',NULL,7,1,0),(29,9,'AdminAttachments',NULL,8,1,0),(30,10,'AdminOrders',NULL,0,1,0),(31,10,'AdminInvoices',NULL,1,1,0),(32,10,'AdminReturn',NULL,2,1,0),(33,10,'AdminDeliverySlip',NULL,3,1,0),(34,10,'AdminSlip',NULL,4,1,0),(35,10,'AdminStatuses',NULL,5,1,0),(36,10,'AdminOrderMessage',NULL,6,1,0),(37,11,'AdminCustomers',NULL,0,1,0),(38,11,'AdminAddresses',NULL,1,1,0),(39,11,'AdminGroups',NULL,2,1,0),(40,11,'AdminCarts',NULL,3,1,0),(41,11,'AdminCustomerThreads',NULL,4,1,0),(42,11,'AdminContacts',NULL,5,1,0),(43,11,'AdminGenders',NULL,6,1,0),(44,11,'AdminOutstanding',NULL,7,0,0),(45,12,'AdminCartRules',NULL,0,1,0),(46,12,'AdminSpecificPriceRule',NULL,1,1,0),(47,12,'AdminMarketing',NULL,2,1,0),(48,14,'AdminCarriers',NULL,0,1,0),(49,14,'AdminShipping',NULL,1,1,0),(50,14,'AdminCarrierWizard',NULL,2,1,0),(51,15,'AdminLocalization',NULL,0,1,0),(52,15,'AdminLanguages',NULL,1,1,0),(53,15,'AdminZones',NULL,2,1,0),(54,15,'AdminCountries',NULL,3,1,0),(55,15,'AdminStates',NULL,4,1,0),(56,15,'AdminCurrencies',NULL,5,1,0),(57,15,'AdminTaxes',NULL,6,1,0),(58,15,'AdminTaxRulesGroup',NULL,7,1,0),(59,15,'AdminTranslations',NULL,8,1,0),(60,13,'AdminModules',NULL,0,1,0),(61,13,'AdminAddonsCatalog',NULL,1,1,0),(62,13,'AdminModulesPositions',NULL,2,1,0),(63,13,'AdminPayment',NULL,3,1,0),(64,16,'AdminPreferences',NULL,0,1,0),(65,16,'AdminOrderPreferences',NULL,1,1,0),(66,16,'AdminPPreferences',NULL,2,1,0),(67,16,'AdminCustomerPreferences',NULL,3,1,0),(68,16,'AdminThemes',NULL,4,1,0),(69,16,'AdminMeta',NULL,5,1,0),(70,16,'AdminCmsContent',NULL,6,1,0),(71,16,'AdminImages',NULL,7,1,0),(72,16,'AdminStores',NULL,8,1,0),(73,16,'AdminSearchConf',NULL,9,1,0),(74,16,'AdminMaintenance',NULL,10,1,0),(75,16,'AdminGeolocation',NULL,11,1,0),(76,17,'AdminInformation',NULL,0,1,0),(77,17,'AdminPerformance',NULL,1,1,0),(78,17,'AdminEmails',NULL,2,1,0),(79,17,'AdminShopGroup',NULL,3,0,0),(80,17,'AdminImport',NULL,4,1,0),(81,17,'AdminBackup',NULL,5,1,0),(82,17,'AdminRequestSql',NULL,6,1,0),(83,17,'AdminLogs',NULL,7,1,0),(84,17,'AdminWebservice',NULL,8,1,0),(85,18,'AdminAdminPreferences',NULL,0,1,0),(86,18,'AdminQuickAccesses',NULL,1,1,0),(87,18,'AdminEmployees',NULL,2,1,0),(88,18,'AdminProfiles',NULL,3,1,0),(89,18,'AdminAccess',NULL,4,1,0),(90,18,'AdminTabs',NULL,5,1,0),(91,19,'AdminStats',NULL,0,1,0),(92,19,'AdminSearchEngines',NULL,1,1,0),(93,19,'AdminReferrers',NULL,2,1,0),(94,20,'AdminWarehouses',NULL,0,1,0),(95,20,'AdminStockManagement',NULL,1,1,0),(96,20,'AdminStockMvt',NULL,2,1,0),(97,20,'AdminStockInstantState',NULL,3,1,0),(98,20,'AdminStockCover',NULL,4,1,0),(99,20,'AdminSupplyOrders',NULL,5,1,0),(100,20,'AdminStockConfiguration',NULL,6,1,0),(101,-1,'AdminBlockCategories','blockcategories',7,1,0),(102,-1,'AdminDashgoals','dashgoals',8,1,0),(103,-1,'AdminThemeConfigurator','themeconfigurator',9,1,0),(104,18,'AdminGamification','gamification',6,1,0),(105,99999,'AdminOnboarding','onboarding',1,1,0),(106,-1,'AdminAjaxPrestashopCheckout','ps_checkout',10,1,0),(107,-1,'AdminPaypalOnboardingPrestashopCheckout','ps_checkout',11,1,0);
/*!40000 ALTER TABLE `ps_tab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tab_advice`
--

DROP TABLE IF EXISTS `ps_tab_advice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tab_advice` (
                               `id_tab` int(11) NOT NULL,
                               `id_advice` int(11) NOT NULL,
                               PRIMARY KEY (`id_tab`,`id_advice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tab_advice`
--

LOCK TABLES `ps_tab_advice` WRITE;
/*!40000 ALTER TABLE `ps_tab_advice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tab_advice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tab_lang`
--

DROP TABLE IF EXISTS `ps_tab_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tab_lang` (
                             `id_tab` int(10) unsigned NOT NULL,
                             `id_lang` int(10) unsigned NOT NULL,
                             `name` varchar(64) DEFAULT NULL,
                             PRIMARY KEY (`id_tab`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tab_lang`
--

LOCK TABLES `ps_tab_lang` WRITE;
/*!40000 ALTER TABLE `ps_tab_lang` DISABLE KEYS */;
INSERT INTO `ps_tab_lang` VALUES (1,1,'Dashboard'),(2,1,'CMS Pages'),(3,1,'CMS Categories'),(4,1,'Combinations Generator'),(5,1,'Search'),(6,1,'Login'),(7,1,'Shops'),(8,1,'Shop URLs'),(9,1,'Catalog'),(10,1,'Orders'),(11,1,'Customers'),(12,1,'Price Rules'),(13,1,'Modules and Services'),(14,1,'Shipping'),(15,1,'Localization'),(16,1,'Preferences'),(17,1,'Advanced Parameters'),(18,1,'Administration'),(19,1,'Stats'),(20,1,'Stock'),(21,1,'Products'),(22,1,'Categories'),(23,1,'Monitoring'),(24,1,'Product Attributes'),(25,1,'Product Features'),(26,1,'Manufacturers'),(27,1,'Suppliers'),(28,1,'Tags'),(29,1,'Attachments'),(30,1,'Orders'),(31,1,'Invoices'),(32,1,'Merchandise Returns'),(33,1,'Delivery Slips'),(34,1,'Credit Slips'),(35,1,'Statuses'),(36,1,'Order Messages'),(37,1,'Customers'),(38,1,'Addresses'),(39,1,'Groups'),(40,1,'Shopping Carts'),(41,1,'Customer Service'),(42,1,'Contacts'),(43,1,'Titles'),(44,1,'Outstanding'),(45,1,'Cart Rules'),(46,1,'Catalog Price Rules'),(47,1,'Marketing'),(48,1,'Carriers'),(49,1,'Preferences'),(50,1,'Carrier'),(51,1,'Localization'),(52,1,'Languages'),(53,1,'Zones'),(54,1,'Countries'),(55,1,'States'),(56,1,'Currencies'),(57,1,'Taxes'),(58,1,'Tax Rules'),(59,1,'Translations'),(60,1,'Modules and Services'),(61,1,'Modules & Themes Catalog'),(62,1,'Positions'),(63,1,'Payment'),(64,1,'General'),(65,1,'Orders'),(66,1,'Products'),(67,1,'Customers'),(68,1,'Themes'),(69,1,'SEO & URLs'),(70,1,'CMS'),(71,1,'Images'),(72,1,'Store Contacts'),(73,1,'Search'),(74,1,'Maintenance'),(75,1,'Geolocation'),(76,1,'Configuration Information'),(77,1,'Performance'),(78,1,'E-mail'),(79,1,'Multistore'),(80,1,'CSV Import'),(81,1,'DB Backup'),(82,1,'SQL Manager'),(83,1,'Logs'),(84,1,'Webservice'),(85,1,'Preferences'),(86,1,'Quick Access'),(87,1,'Employees'),(88,1,'Profiles'),(89,1,'Permissions'),(90,1,'Menus'),(91,1,'Stats'),(92,1,'Search Engines'),(93,1,'Referrers'),(94,1,'Warehouses'),(95,1,'Stock Management'),(96,1,'Stock Movement'),(97,1,'Instant Stock Status'),(98,1,'Stock Coverage'),(99,1,'Supply orders'),(100,1,'Configuration'),(101,1,'BlockCategories'),(102,1,'Dashgoals'),(103,1,'themeconfigurator'),(104,1,'Merchant Expertise'),(105,1,'Onboarding'),(106,1,'PrestaShop Checkout'),(107,1,'PrestaShop Checkout');
/*!40000 ALTER TABLE `ps_tab_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tab_module_preference`
--

DROP TABLE IF EXISTS `ps_tab_module_preference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tab_module_preference` (
                                          `id_tab_module_preference` int(11) NOT NULL AUTO_INCREMENT,
                                          `id_employee` int(11) NOT NULL,
                                          `id_tab` int(11) NOT NULL,
                                          `module` varchar(255) NOT NULL,
                                          PRIMARY KEY (`id_tab_module_preference`),
                                          UNIQUE KEY `employee_module` (`id_employee`,`id_tab`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tab_module_preference`
--

LOCK TABLES `ps_tab_module_preference` WRITE;
/*!40000 ALTER TABLE `ps_tab_module_preference` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tab_module_preference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tag`
--

DROP TABLE IF EXISTS `ps_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tag` (
                        `id_tag` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `id_lang` int(10) unsigned NOT NULL,
                        `name` varchar(32) NOT NULL,
                        PRIMARY KEY (`id_tag`),
                        KEY `tag_name` (`name`),
                        KEY `id_lang` (`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tag`
--

LOCK TABLES `ps_tag` WRITE;
/*!40000 ALTER TABLE `ps_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tag_count`
--

DROP TABLE IF EXISTS `ps_tag_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tag_count` (
                              `id_group` int(10) unsigned NOT NULL DEFAULT 0,
                              `id_tag` int(10) unsigned NOT NULL DEFAULT 0,
                              `id_lang` int(10) unsigned NOT NULL DEFAULT 0,
                              `id_shop` int(11) unsigned NOT NULL DEFAULT 0,
                              `counter` int(10) unsigned NOT NULL DEFAULT 0,
                              PRIMARY KEY (`id_group`,`id_tag`),
                              KEY `id_group` (`id_group`,`id_lang`,`id_shop`,`counter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tag_count`
--

LOCK TABLES `ps_tag_count` WRITE;
/*!40000 ALTER TABLE `ps_tag_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tag_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tax`
--

DROP TABLE IF EXISTS `ps_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tax` (
                        `id_tax` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `rate` decimal(10,3) NOT NULL,
                        `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
                        `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                        PRIMARY KEY (`id_tax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tax`
--

LOCK TABLES `ps_tax` WRITE;
/*!40000 ALTER TABLE `ps_tax` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tax_lang`
--

DROP TABLE IF EXISTS `ps_tax_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tax_lang` (
                             `id_tax` int(10) unsigned NOT NULL,
                             `id_lang` int(10) unsigned NOT NULL,
                             `name` varchar(32) NOT NULL,
                             PRIMARY KEY (`id_tax`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tax_lang`
--

LOCK TABLES `ps_tax_lang` WRITE;
/*!40000 ALTER TABLE `ps_tax_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tax_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tax_rule`
--

DROP TABLE IF EXISTS `ps_tax_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tax_rule` (
                             `id_tax_rule` int(11) NOT NULL AUTO_INCREMENT,
                             `id_tax_rules_group` int(11) NOT NULL,
                             `id_country` int(11) NOT NULL,
                             `id_state` int(11) NOT NULL,
                             `zipcode_from` varchar(12) NOT NULL,
                             `zipcode_to` varchar(12) NOT NULL,
                             `id_tax` int(11) NOT NULL,
                             `behavior` int(11) NOT NULL,
                             `description` varchar(100) NOT NULL,
                             PRIMARY KEY (`id_tax_rule`),
                             KEY `id_tax_rules_group` (`id_tax_rules_group`),
                             KEY `id_tax` (`id_tax`),
                             KEY `category_getproducts` (`id_tax_rules_group`,`id_country`,`id_state`,`zipcode_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tax_rule`
--

LOCK TABLES `ps_tax_rule` WRITE;
/*!40000 ALTER TABLE `ps_tax_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tax_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tax_rules_group`
--

DROP TABLE IF EXISTS `ps_tax_rules_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tax_rules_group` (
                                    `id_tax_rules_group` int(11) NOT NULL AUTO_INCREMENT,
                                    `name` varchar(50) NOT NULL,
                                    `active` int(11) NOT NULL,
                                    `deleted` tinyint(1) unsigned NOT NULL,
                                    `date_add` datetime NOT NULL,
                                    `date_upd` datetime NOT NULL,
                                    PRIMARY KEY (`id_tax_rules_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tax_rules_group`
--

LOCK TABLES `ps_tax_rules_group` WRITE;
/*!40000 ALTER TABLE `ps_tax_rules_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tax_rules_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_tax_rules_group_shop`
--

DROP TABLE IF EXISTS `ps_tax_rules_group_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_tax_rules_group_shop` (
                                         `id_tax_rules_group` int(11) unsigned NOT NULL,
                                         `id_shop` int(11) unsigned NOT NULL,
                                         PRIMARY KEY (`id_tax_rules_group`,`id_shop`),
                                         KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_tax_rules_group_shop`
--

LOCK TABLES `ps_tax_rules_group_shop` WRITE;
/*!40000 ALTER TABLE `ps_tax_rules_group_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_tax_rules_group_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_theme`
--

DROP TABLE IF EXISTS `ps_theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_theme` (
                          `id_theme` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(64) NOT NULL,
                          `directory` varchar(64) NOT NULL,
                          `responsive` tinyint(1) NOT NULL DEFAULT 0,
                          `default_left_column` tinyint(1) NOT NULL DEFAULT 0,
                          `default_right_column` tinyint(1) NOT NULL DEFAULT 0,
                          `product_per_page` int(10) unsigned NOT NULL,
                          PRIMARY KEY (`id_theme`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_theme`
--

LOCK TABLES `ps_theme` WRITE;
/*!40000 ALTER TABLE `ps_theme` DISABLE KEYS */;
INSERT INTO `ps_theme` VALUES (1,'default-bootstrap','default-bootstrap',1,1,0,12);
/*!40000 ALTER TABLE `ps_theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_theme_meta`
--

DROP TABLE IF EXISTS `ps_theme_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_theme_meta` (
                               `id_theme_meta` int(11) NOT NULL AUTO_INCREMENT,
                               `id_theme` int(11) NOT NULL,
                               `id_meta` int(10) unsigned NOT NULL,
                               `left_column` tinyint(1) NOT NULL DEFAULT 1,
                               `right_column` tinyint(1) NOT NULL DEFAULT 1,
                               PRIMARY KEY (`id_theme_meta`),
                               UNIQUE KEY `id_theme_2` (`id_theme`,`id_meta`),
                               KEY `id_theme` (`id_theme`),
                               KEY `id_meta` (`id_meta`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_theme_meta`
--

LOCK TABLES `ps_theme_meta` WRITE;
/*!40000 ALTER TABLE `ps_theme_meta` DISABLE KEYS */;
INSERT INTO `ps_theme_meta` VALUES (1,1,1,0,0),(2,1,2,1,0),(3,1,3,0,0),(4,1,4,0,0),(5,1,5,1,0),(6,1,6,1,0),(7,1,7,0,0),(8,1,8,1,0),(9,1,9,1,0),(10,1,10,0,0),(11,1,11,0,0),(12,1,12,0,0),(13,1,13,0,0),(14,1,14,0,0),(15,1,15,0,0),(16,1,16,0,0),(17,1,17,0,0),(18,1,18,0,0),(19,1,19,0,0),(20,1,20,0,0),(21,1,21,0,0),(22,1,22,1,0),(23,1,23,0,0),(24,1,24,0,0),(25,1,25,0,0),(26,1,26,0,0),(27,1,28,1,0),(28,1,29,0,0),(29,1,27,0,0),(30,1,30,0,0),(31,1,31,0,0),(32,1,32,0,0),(33,1,33,0,0),(34,1,34,0,0),(35,1,36,1,0);
/*!40000 ALTER TABLE `ps_theme_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_theme_specific`
--

DROP TABLE IF EXISTS `ps_theme_specific`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_theme_specific` (
                                   `id_theme` int(11) unsigned NOT NULL,
                                   `id_shop` int(11) unsigned NOT NULL,
                                   `entity` int(11) unsigned NOT NULL,
                                   `id_object` int(11) unsigned NOT NULL,
                                   PRIMARY KEY (`id_theme`,`id_shop`,`entity`,`id_object`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_theme_specific`
--

LOCK TABLES `ps_theme_specific` WRITE;
/*!40000 ALTER TABLE `ps_theme_specific` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_theme_specific` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_themeconfigurator`
--

DROP TABLE IF EXISTS `ps_themeconfigurator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_themeconfigurator` (
                                      `id_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                      `id_shop` int(10) unsigned NOT NULL,
                                      `id_lang` int(10) unsigned NOT NULL,
                                      `item_order` int(10) unsigned NOT NULL,
                                      `title` varchar(100) DEFAULT NULL,
                                      `title_use` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                      `hook` varchar(100) DEFAULT NULL,
                                      `url` text DEFAULT NULL,
                                      `target` tinyint(1) unsigned NOT NULL DEFAULT 0,
                                      `image` varchar(100) DEFAULT NULL,
                                      `image_w` varchar(10) DEFAULT NULL,
                                      `image_h` varchar(10) DEFAULT NULL,
                                      `html` text DEFAULT NULL,
                                      `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
                                      PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_themeconfigurator`
--

LOCK TABLES `ps_themeconfigurator` WRITE;
/*!40000 ALTER TABLE `ps_themeconfigurator` DISABLE KEYS */;
INSERT INTO `ps_themeconfigurator` VALUES (1,1,1,1,'',0,'home','http://www.prestashop.com/',0,'banner-img1.jpg','383','267','',1),(2,1,1,2,'',0,'home','http://www.prestashop.com/',0,'banner-img2.jpg','383','267','',1),(3,1,1,3,'',0,'home','http://www.prestashop.com/',0,'banner-img3.jpg','383','267','',1),(4,1,1,4,'',0,'home','http://www.prestashop.com/',0,'banner-img4.jpg','383','142','',1),(5,1,1,5,'',0,'home','http://www.prestashop.com/',0,'banner-img5.jpg','777','142','',1),(6,1,1,6,'',0,'top','http://www.prestashop.com/',0,'banner-img6.jpg','381','219','',1),(7,1,1,7,'',0,'top','http://www.prestashop.com/',0,'banner-img7.jpg','381','219','',1);
/*!40000 ALTER TABLE `ps_themeconfigurator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_timezone`
--

DROP TABLE IF EXISTS `ps_timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_timezone` (
                             `id_timezone` int(10) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(32) NOT NULL,
                             PRIMARY KEY (`id_timezone`)
) ENGINE=InnoDB AUTO_INCREMENT=561 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_timezone`
--

LOCK TABLES `ps_timezone` WRITE;
/*!40000 ALTER TABLE `ps_timezone` DISABLE KEYS */;
INSERT INTO `ps_timezone` VALUES (1,'Africa/Abidjan'),(2,'Africa/Accra'),(3,'Africa/Addis_Ababa'),(4,'Africa/Algiers'),(5,'Africa/Asmara'),(6,'Africa/Asmera'),(7,'Africa/Bamako'),(8,'Africa/Bangui'),(9,'Africa/Banjul'),(10,'Africa/Bissau'),(11,'Africa/Blantyre'),(12,'Africa/Brazzaville'),(13,'Africa/Bujumbura'),(14,'Africa/Cairo'),(15,'Africa/Casablanca'),(16,'Africa/Ceuta'),(17,'Africa/Conakry'),(18,'Africa/Dakar'),(19,'Africa/Dar_es_Salaam'),(20,'Africa/Djibouti'),(21,'Africa/Douala'),(22,'Africa/El_Aaiun'),(23,'Africa/Freetown'),(24,'Africa/Gaborone'),(25,'Africa/Harare'),(26,'Africa/Johannesburg'),(27,'Africa/Kampala'),(28,'Africa/Khartoum'),(29,'Africa/Kigali'),(30,'Africa/Kinshasa'),(31,'Africa/Lagos'),(32,'Africa/Libreville'),(33,'Africa/Lome'),(34,'Africa/Luanda'),(35,'Africa/Lubumbashi'),(36,'Africa/Lusaka'),(37,'Africa/Malabo'),(38,'Africa/Maputo'),(39,'Africa/Maseru'),(40,'Africa/Mbabane'),(41,'Africa/Mogadishu'),(42,'Africa/Monrovia'),(43,'Africa/Nairobi'),(44,'Africa/Ndjamena'),(45,'Africa/Niamey'),(46,'Africa/Nouakchott'),(47,'Africa/Ouagadougou'),(48,'Africa/Porto-Novo'),(49,'Africa/Sao_Tome'),(50,'Africa/Timbuktu'),(51,'Africa/Tripoli'),(52,'Africa/Tunis'),(53,'Africa/Windhoek'),(54,'America/Adak'),(55,'America/Anchorage '),(56,'America/Anguilla'),(57,'America/Antigua'),(58,'America/Araguaina'),(59,'America/Argentina/Buenos_Aires'),(60,'America/Argentina/Catamarca'),(61,'America/Argentina/ComodRivadavia'),(62,'America/Argentina/Cordoba'),(63,'America/Argentina/Jujuy'),(64,'America/Argentina/La_Rioja'),(65,'America/Argentina/Mendoza'),(66,'America/Argentina/Rio_Gallegos'),(67,'America/Argentina/Salta'),(68,'America/Argentina/San_Juan'),(69,'America/Argentina/San_Luis'),(70,'America/Argentina/Tucuman'),(71,'America/Argentina/Ushuaia'),(72,'America/Aruba'),(73,'America/Asuncion'),(74,'America/Atikokan'),(75,'America/Atka'),(76,'America/Bahia'),(77,'America/Barbados'),(78,'America/Belem'),(79,'America/Belize'),(80,'America/Blanc-Sablon'),(81,'America/Boa_Vista'),(82,'America/Bogota'),(83,'America/Boise'),(84,'America/Buenos_Aires'),(85,'America/Cambridge_Bay'),(86,'America/Campo_Grande'),(87,'America/Cancun'),(88,'America/Caracas'),(89,'America/Catamarca'),(90,'America/Cayenne'),(91,'America/Cayman'),(92,'America/Chicago'),(93,'America/Chihuahua'),(94,'America/Coral_Harbour'),(95,'America/Cordoba'),(96,'America/Costa_Rica'),(97,'America/Cuiaba'),(98,'America/Curacao'),(99,'America/Danmarkshavn'),(100,'America/Dawson'),(101,'America/Dawson_Creek'),(102,'America/Denver'),(103,'America/Detroit'),(104,'America/Dominica'),(105,'America/Edmonton'),(106,'America/Eirunepe'),(107,'America/El_Salvador'),(108,'America/Ensenada'),(109,'America/Fort_Wayne'),(110,'America/Fortaleza'),(111,'America/Glace_Bay'),(112,'America/Godthab'),(113,'America/Goose_Bay'),(114,'America/Grand_Turk'),(115,'America/Grenada'),(116,'America/Guadeloupe'),(117,'America/Guatemala'),(118,'America/Guayaquil'),(119,'America/Guyana'),(120,'America/Halifax'),(121,'America/Havana'),(122,'America/Hermosillo'),(123,'America/Indiana/Indianapolis'),(124,'America/Indiana/Knox'),(125,'America/Indiana/Marengo'),(126,'America/Indiana/Petersburg'),(127,'America/Indiana/Tell_City'),(128,'America/Indiana/Vevay'),(129,'America/Indiana/Vincennes'),(130,'America/Indiana/Winamac'),(131,'America/Indianapolis'),(132,'America/Inuvik'),(133,'America/Iqaluit'),(134,'America/Jamaica'),(135,'America/Jujuy'),(136,'America/Juneau'),(137,'America/Kentucky/Louisville'),(138,'America/Kentucky/Monticello'),(139,'America/Knox_IN'),(140,'America/La_Paz'),(141,'America/Lima'),(142,'America/Los_Angeles'),(143,'America/Louisville'),(144,'America/Maceio'),(145,'America/Managua'),(146,'America/Manaus'),(147,'America/Marigot'),(148,'America/Martinique'),(149,'America/Mazatlan'),(150,'America/Mendoza'),(151,'America/Menominee'),(152,'America/Merida'),(153,'America/Mexico_City'),(154,'America/Miquelon'),(155,'America/Moncton'),(156,'America/Monterrey'),(157,'America/Montevideo'),(158,'America/Montreal'),(159,'America/Montserrat'),(160,'America/Nassau'),(161,'America/New_York'),(162,'America/Nipigon'),(163,'America/Nome'),(164,'America/Noronha'),(165,'America/North_Dakota/Center'),(166,'America/North_Dakota/New_Salem'),(167,'America/Panama'),(168,'America/Pangnirtung'),(169,'America/Paramaribo'),(170,'America/Phoenix'),(171,'America/Port-au-Prince'),(172,'America/Port_of_Spain'),(173,'America/Porto_Acre'),(174,'America/Porto_Velho'),(175,'America/Puerto_Rico'),(176,'America/Rainy_River'),(177,'America/Rankin_Inlet'),(178,'America/Recife'),(179,'America/Regina'),(180,'America/Resolute'),(181,'America/Rio_Branco'),(182,'America/Rosario'),(183,'America/Santarem'),(184,'America/Santiago'),(185,'America/Santo_Domingo'),(186,'America/Sao_Paulo'),(187,'America/Scoresbysund'),(188,'America/Shiprock'),(189,'America/St_Barthelemy'),(190,'America/St_Johns'),(191,'America/St_Kitts'),(192,'America/St_Lucia'),(193,'America/St_Thomas'),(194,'America/St_Vincent'),(195,'America/Swift_Current'),(196,'America/Tegucigalpa'),(197,'America/Thule'),(198,'America/Thunder_Bay'),(199,'America/Tijuana'),(200,'America/Toronto'),(201,'America/Tortola'),(202,'America/Vancouver'),(203,'America/Virgin'),(204,'America/Whitehorse'),(205,'America/Winnipeg'),(206,'America/Yakutat'),(207,'America/Yellowknife'),(208,'Antarctica/Casey'),(209,'Antarctica/Davis'),(210,'Antarctica/DumontDUrville'),(211,'Antarctica/Mawson'),(212,'Antarctica/McMurdo'),(213,'Antarctica/Palmer'),(214,'Antarctica/Rothera'),(215,'Antarctica/South_Pole'),(216,'Antarctica/Syowa'),(217,'Antarctica/Vostok'),(218,'Arctic/Longyearbyen'),(219,'Asia/Aden'),(220,'Asia/Almaty'),(221,'Asia/Amman'),(222,'Asia/Anadyr'),(223,'Asia/Aqtau'),(224,'Asia/Aqtobe'),(225,'Asia/Ashgabat'),(226,'Asia/Ashkhabad'),(227,'Asia/Baghdad'),(228,'Asia/Bahrain'),(229,'Asia/Baku'),(230,'Asia/Bangkok'),(231,'Asia/Beirut'),(232,'Asia/Bishkek'),(233,'Asia/Brunei'),(234,'Asia/Calcutta'),(235,'Asia/Choibalsan'),(236,'Asia/Chongqing'),(237,'Asia/Chungking'),(238,'Asia/Colombo'),(239,'Asia/Dacca'),(240,'Asia/Damascus'),(241,'Asia/Dhaka'),(242,'Asia/Dili'),(243,'Asia/Dubai'),(244,'Asia/Dushanbe'),(245,'Asia/Gaza'),(246,'Asia/Harbin'),(247,'Asia/Ho_Chi_Minh'),(248,'Asia/Hong_Kong'),(249,'Asia/Hovd'),(250,'Asia/Irkutsk'),(251,'Asia/Istanbul'),(252,'Asia/Jakarta'),(253,'Asia/Jayapura'),(254,'Asia/Jerusalem'),(255,'Asia/Kabul'),(256,'Asia/Kamchatka'),(257,'Asia/Karachi'),(258,'Asia/Kashgar'),(259,'Asia/Kathmandu'),(260,'Asia/Katmandu'),(261,'Asia/Kolkata'),(262,'Asia/Krasnoyarsk'),(263,'Asia/Kuala_Lumpur'),(264,'Asia/Kuching'),(265,'Asia/Kuwait'),(266,'Asia/Macao'),(267,'Asia/Macau'),(268,'Asia/Magadan'),(269,'Asia/Makassar'),(270,'Asia/Manila'),(271,'Asia/Muscat'),(272,'Asia/Nicosia'),(273,'Asia/Novosibirsk'),(274,'Asia/Omsk'),(275,'Asia/Oral'),(276,'Asia/Phnom_Penh'),(277,'Asia/Pontianak'),(278,'Asia/Pyongyang'),(279,'Asia/Qatar'),(280,'Asia/Qyzylorda'),(281,'Asia/Rangoon'),(282,'Asia/Riyadh'),(283,'Asia/Saigon'),(284,'Asia/Sakhalin'),(285,'Asia/Samarkand'),(286,'Asia/Seoul'),(287,'Asia/Shanghai'),(288,'Asia/Singapore'),(289,'Asia/Taipei'),(290,'Asia/Tashkent'),(291,'Asia/Tbilisi'),(292,'Asia/Tehran'),(293,'Asia/Tel_Aviv'),(294,'Asia/Thimbu'),(295,'Asia/Thimphu'),(296,'Asia/Tokyo'),(297,'Asia/Ujung_Pandang'),(298,'Asia/Ulaanbaatar'),(299,'Asia/Ulan_Bator'),(300,'Asia/Urumqi'),(301,'Asia/Vientiane'),(302,'Asia/Vladivostok'),(303,'Asia/Yakutsk'),(304,'Asia/Yekaterinburg'),(305,'Asia/Yerevan'),(306,'Atlantic/Azores'),(307,'Atlantic/Bermuda'),(308,'Atlantic/Canary'),(309,'Atlantic/Cape_Verde'),(310,'Atlantic/Faeroe'),(311,'Atlantic/Faroe'),(312,'Atlantic/Jan_Mayen'),(313,'Atlantic/Madeira'),(314,'Atlantic/Reykjavik'),(315,'Atlantic/South_Georgia'),(316,'Atlantic/St_Helena'),(317,'Atlantic/Stanley'),(318,'Australia/ACT'),(319,'Australia/Adelaide'),(320,'Australia/Brisbane'),(321,'Australia/Broken_Hill'),(322,'Australia/Canberra'),(323,'Australia/Currie'),(324,'Australia/Darwin'),(325,'Australia/Eucla'),(326,'Australia/Hobart'),(327,'Australia/LHI'),(328,'Australia/Lindeman'),(329,'Australia/Lord_Howe'),(330,'Australia/Melbourne'),(331,'Australia/North'),(332,'Australia/NSW'),(333,'Australia/Perth'),(334,'Australia/Queensland'),(335,'Australia/South'),(336,'Australia/Sydney'),(337,'Australia/Tasmania'),(338,'Australia/Victoria'),(339,'Australia/West'),(340,'Australia/Yancowinna'),(341,'Europe/Amsterdam'),(342,'Europe/Andorra'),(343,'Europe/Athens'),(344,'Europe/Belfast'),(345,'Europe/Belgrade'),(346,'Europe/Berlin'),(347,'Europe/Bratislava'),(348,'Europe/Brussels'),(349,'Europe/Bucharest'),(350,'Europe/Budapest'),(351,'Europe/Chisinau'),(352,'Europe/Copenhagen'),(353,'Europe/Dublin'),(354,'Europe/Gibraltar'),(355,'Europe/Guernsey'),(356,'Europe/Helsinki'),(357,'Europe/Isle_of_Man'),(358,'Europe/Istanbul'),(359,'Europe/Jersey'),(360,'Europe/Kaliningrad'),(361,'Europe/Kiev'),(362,'Europe/Lisbon'),(363,'Europe/Ljubljana'),(364,'Europe/London'),(365,'Europe/Luxembourg'),(366,'Europe/Madrid'),(367,'Europe/Malta'),(368,'Europe/Mariehamn'),(369,'Europe/Minsk'),(370,'Europe/Monaco'),(371,'Europe/Moscow'),(372,'Europe/Nicosia'),(373,'Europe/Oslo'),(374,'Europe/Paris'),(375,'Europe/Podgorica'),(376,'Europe/Prague'),(377,'Europe/Riga'),(378,'Europe/Rome'),(379,'Europe/Samara'),(380,'Europe/San_Marino'),(381,'Europe/Sarajevo'),(382,'Europe/Simferopol'),(383,'Europe/Skopje'),(384,'Europe/Sofia'),(385,'Europe/Stockholm'),(386,'Europe/Tallinn'),(387,'Europe/Tirane'),(388,'Europe/Tiraspol'),(389,'Europe/Uzhgorod'),(390,'Europe/Vaduz'),(391,'Europe/Vatican'),(392,'Europe/Vienna'),(393,'Europe/Vilnius'),(394,'Europe/Volgograd'),(395,'Europe/Warsaw'),(396,'Europe/Zagreb'),(397,'Europe/Zaporozhye'),(398,'Europe/Zurich'),(399,'Indian/Antananarivo'),(400,'Indian/Chagos'),(401,'Indian/Christmas'),(402,'Indian/Cocos'),(403,'Indian/Comoro'),(404,'Indian/Kerguelen'),(405,'Indian/Mahe'),(406,'Indian/Maldives'),(407,'Indian/Mauritius'),(408,'Indian/Mayotte'),(409,'Indian/Reunion'),(410,'Pacific/Apia'),(411,'Pacific/Auckland'),(412,'Pacific/Chatham'),(413,'Pacific/Easter'),(414,'Pacific/Efate'),(415,'Pacific/Enderbury'),(416,'Pacific/Fakaofo'),(417,'Pacific/Fiji'),(418,'Pacific/Funafuti'),(419,'Pacific/Galapagos'),(420,'Pacific/Gambier'),(421,'Pacific/Guadalcanal'),(422,'Pacific/Guam'),(423,'Pacific/Honolulu'),(424,'Pacific/Johnston'),(425,'Pacific/Kiritimati'),(426,'Pacific/Kosrae'),(427,'Pacific/Kwajalein'),(428,'Pacific/Majuro'),(429,'Pacific/Marquesas'),(430,'Pacific/Midway'),(431,'Pacific/Nauru'),(432,'Pacific/Niue'),(433,'Pacific/Norfolk'),(434,'Pacific/Noumea'),(435,'Pacific/Pago_Pago'),(436,'Pacific/Palau'),(437,'Pacific/Pitcairn'),(438,'Pacific/Ponape'),(439,'Pacific/Port_Moresby'),(440,'Pacific/Rarotonga'),(441,'Pacific/Saipan'),(442,'Pacific/Samoa'),(443,'Pacific/Tahiti'),(444,'Pacific/Tarawa'),(445,'Pacific/Tongatapu'),(446,'Pacific/Truk'),(447,'Pacific/Wake'),(448,'Pacific/Wallis'),(449,'Pacific/Yap'),(450,'Brazil/Acre'),(451,'Brazil/DeNoronha'),(452,'Brazil/East'),(453,'Brazil/West'),(454,'Canada/Atlantic'),(455,'Canada/Central'),(456,'Canada/East-Saskatchewan'),(457,'Canada/Eastern'),(458,'Canada/Mountain'),(459,'Canada/Newfoundland'),(460,'Canada/Pacific'),(461,'Canada/Saskatchewan'),(462,'Canada/Yukon'),(463,'CET'),(464,'Chile/Continental'),(465,'Chile/EasterIsland'),(466,'CST6CDT'),(467,'Cuba'),(468,'EET'),(469,'Egypt'),(470,'Eire'),(471,'EST'),(472,'EST5EDT'),(473,'Etc/GMT'),(474,'Etc/GMT+0'),(475,'Etc/GMT+1'),(476,'Etc/GMT+10'),(477,'Etc/GMT+11'),(478,'Etc/GMT+12'),(479,'Etc/GMT+2'),(480,'Etc/GMT+3'),(481,'Etc/GMT+4'),(482,'Etc/GMT+5'),(483,'Etc/GMT+6'),(484,'Etc/GMT+7'),(485,'Etc/GMT+8'),(486,'Etc/GMT+9'),(487,'Etc/GMT-0'),(488,'Etc/GMT-1'),(489,'Etc/GMT-10'),(490,'Etc/GMT-11'),(491,'Etc/GMT-12'),(492,'Etc/GMT-13'),(493,'Etc/GMT-14'),(494,'Etc/GMT-2'),(495,'Etc/GMT-3'),(496,'Etc/GMT-4'),(497,'Etc/GMT-5'),(498,'Etc/GMT-6'),(499,'Etc/GMT-7'),(500,'Etc/GMT-8'),(501,'Etc/GMT-9'),(502,'Etc/GMT0'),(503,'Etc/Greenwich'),(504,'Etc/UCT'),(505,'Etc/Universal'),(506,'Etc/UTC'),(507,'Etc/Zulu'),(508,'Factory'),(509,'GB'),(510,'GB-Eire'),(511,'GMT'),(512,'GMT+0'),(513,'GMT-0'),(514,'GMT0'),(515,'Greenwich'),(516,'Hongkong'),(517,'HST'),(518,'Iceland'),(519,'Iran'),(520,'Israel'),(521,'Jamaica'),(522,'Japan'),(523,'Kwajalein'),(524,'Libya'),(525,'MET'),(526,'Mexico/BajaNorte'),(527,'Mexico/BajaSur'),(528,'Mexico/General'),(529,'MST'),(530,'MST7MDT'),(531,'Navajo'),(532,'NZ'),(533,'NZ-CHAT'),(534,'Poland'),(535,'Portugal'),(536,'PRC'),(537,'PST8PDT'),(538,'ROC'),(539,'ROK'),(540,'Singapore'),(541,'Turkey'),(542,'UCT'),(543,'Universal'),(544,'US/Alaska'),(545,'US/Aleutian'),(546,'US/Arizona'),(547,'US/Central'),(548,'US/East-Indiana'),(549,'US/Eastern'),(550,'US/Hawaii'),(551,'US/Indiana-Starke'),(552,'US/Michigan'),(553,'US/Mountain'),(554,'US/Pacific'),(555,'US/Pacific-New'),(556,'US/Samoa'),(557,'UTC'),(558,'W-SU'),(559,'WET'),(560,'Zulu');
/*!40000 ALTER TABLE `ps_timezone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_warehouse`
--

DROP TABLE IF EXISTS `ps_warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_warehouse` (
                              `id_warehouse` int(11) unsigned NOT NULL AUTO_INCREMENT,
                              `id_currency` int(11) unsigned NOT NULL,
                              `id_address` int(11) unsigned NOT NULL,
                              `id_employee` int(11) unsigned NOT NULL,
                              `reference` varchar(32) DEFAULT NULL,
                              `name` varchar(45) NOT NULL,
                              `management_type` enum('WA','FIFO','LIFO') NOT NULL DEFAULT 'WA',
                              `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
                              PRIMARY KEY (`id_warehouse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_warehouse`
--

LOCK TABLES `ps_warehouse` WRITE;
/*!40000 ALTER TABLE `ps_warehouse` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_warehouse_carrier`
--

DROP TABLE IF EXISTS `ps_warehouse_carrier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_warehouse_carrier` (
                                      `id_carrier` int(11) unsigned NOT NULL,
                                      `id_warehouse` int(11) unsigned NOT NULL,
                                      PRIMARY KEY (`id_warehouse`,`id_carrier`),
                                      KEY `id_warehouse` (`id_warehouse`),
                                      KEY `id_carrier` (`id_carrier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_warehouse_carrier`
--

LOCK TABLES `ps_warehouse_carrier` WRITE;
/*!40000 ALTER TABLE `ps_warehouse_carrier` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_warehouse_carrier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_warehouse_product_location`
--

DROP TABLE IF EXISTS `ps_warehouse_product_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_warehouse_product_location` (
                                               `id_warehouse_product_location` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                               `id_product` int(11) unsigned NOT NULL,
                                               `id_product_attribute` int(11) unsigned NOT NULL,
                                               `id_warehouse` int(11) unsigned NOT NULL,
                                               `location` varchar(64) DEFAULT NULL,
                                               PRIMARY KEY (`id_warehouse_product_location`),
                                               UNIQUE KEY `id_product` (`id_product`,`id_product_attribute`,`id_warehouse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_warehouse_product_location`
--

LOCK TABLES `ps_warehouse_product_location` WRITE;
/*!40000 ALTER TABLE `ps_warehouse_product_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_warehouse_product_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_warehouse_shop`
--

DROP TABLE IF EXISTS `ps_warehouse_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_warehouse_shop` (
                                   `id_shop` int(11) unsigned NOT NULL,
                                   `id_warehouse` int(11) unsigned NOT NULL,
                                   PRIMARY KEY (`id_warehouse`,`id_shop`),
                                   KEY `id_warehouse` (`id_warehouse`),
                                   KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_warehouse_shop`
--

LOCK TABLES `ps_warehouse_shop` WRITE;
/*!40000 ALTER TABLE `ps_warehouse_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_warehouse_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_web_browser`
--

DROP TABLE IF EXISTS `ps_web_browser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_web_browser` (
                                `id_web_browser` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                `name` varchar(64) DEFAULT NULL,
                                PRIMARY KEY (`id_web_browser`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_web_browser`
--

LOCK TABLES `ps_web_browser` WRITE;
/*!40000 ALTER TABLE `ps_web_browser` DISABLE KEYS */;
INSERT INTO `ps_web_browser` VALUES (1,'Safari'),(2,'Safari iPad'),(3,'Firefox'),(4,'Opera'),(5,'IE 6'),(6,'IE 7'),(7,'IE 8'),(8,'IE 9'),(9,'IE 10'),(10,'IE 11'),(11,'Chrome');
/*!40000 ALTER TABLE `ps_web_browser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_webservice_account`
--

DROP TABLE IF EXISTS `ps_webservice_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_webservice_account` (
                                       `id_webservice_account` int(11) NOT NULL AUTO_INCREMENT,
                                       `key` varchar(32) NOT NULL,
                                       `description` text DEFAULT NULL,
                                       `class_name` varchar(50) NOT NULL DEFAULT 'WebserviceRequest',
                                       `is_module` tinyint(2) NOT NULL DEFAULT 0,
                                       `module_name` varchar(50) DEFAULT NULL,
                                       `active` tinyint(2) NOT NULL,
                                       PRIMARY KEY (`id_webservice_account`),
                                       KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_webservice_account`
--

LOCK TABLES `ps_webservice_account` WRITE;
/*!40000 ALTER TABLE `ps_webservice_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_webservice_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_webservice_account_shop`
--

DROP TABLE IF EXISTS `ps_webservice_account_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_webservice_account_shop` (
                                            `id_webservice_account` int(11) unsigned NOT NULL,
                                            `id_shop` int(11) unsigned NOT NULL,
                                            PRIMARY KEY (`id_webservice_account`,`id_shop`),
                                            KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_webservice_account_shop`
--

LOCK TABLES `ps_webservice_account_shop` WRITE;
/*!40000 ALTER TABLE `ps_webservice_account_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_webservice_account_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_webservice_permission`
--

DROP TABLE IF EXISTS `ps_webservice_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_webservice_permission` (
                                          `id_webservice_permission` int(11) NOT NULL AUTO_INCREMENT,
                                          `resource` varchar(50) NOT NULL,
                                          `method` enum('GET','POST','PUT','DELETE','HEAD') NOT NULL,
                                          `id_webservice_account` int(11) NOT NULL,
                                          PRIMARY KEY (`id_webservice_permission`),
                                          UNIQUE KEY `resource_2` (`resource`,`method`,`id_webservice_account`),
                                          KEY `resource` (`resource`),
                                          KEY `method` (`method`),
                                          KEY `id_webservice_account` (`id_webservice_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_webservice_permission`
--

LOCK TABLES `ps_webservice_permission` WRITE;
/*!40000 ALTER TABLE `ps_webservice_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `ps_webservice_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_zone`
--

DROP TABLE IF EXISTS `ps_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_zone` (
                         `id_zone` int(10) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(64) NOT NULL,
                         `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                         PRIMARY KEY (`id_zone`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_zone`
--

LOCK TABLES `ps_zone` WRITE;
/*!40000 ALTER TABLE `ps_zone` DISABLE KEYS */;
INSERT INTO `ps_zone` VALUES (1,'Europe',1),(2,'North America',1),(3,'Asia',1),(4,'Africa',1),(5,'Oceania',1),(6,'South America',1),(7,'Europe (non-EU)',1),(8,'Central America/Antilla',1);
/*!40000 ALTER TABLE `ps_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ps_zone_shop`
--

DROP TABLE IF EXISTS `ps_zone_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ps_zone_shop` (
                              `id_zone` int(11) unsigned NOT NULL,
                              `id_shop` int(11) unsigned NOT NULL,
                              PRIMARY KEY (`id_zone`,`id_shop`),
                              KEY `id_shop` (`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ps_zone_shop`
--

LOCK TABLES `ps_zone_shop` WRITE;
/*!40000 ALTER TABLE `ps_zone_shop` DISABLE KEYS */;
INSERT INTO `ps_zone_shop` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1);
/*!40000 ALTER TABLE `ps_zone_shop` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-13 15:11:16
