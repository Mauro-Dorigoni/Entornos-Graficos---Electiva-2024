CREATE DATABASE  IF NOT EXISTS `promoshop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `promoshop`;
-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: promoshop
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `newsText` text NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  `idAdmin` int unsigned DEFAULT NULL,
  `idUserCategory` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idAdmin` (`idAdmin`),
  KEY `idUserCategory` (`idUserCategory`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`idUserCategory`) REFERENCES `usercategory` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promotion` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `promoText` text NOT NULL,
  `dateFrom` date NOT NULL,
  `dateTo` date NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  `imageUUID` varchar(255) DEFAULT NULL,
  `idShop` int unsigned DEFAULT NULL,
  `idUserCategory` int unsigned DEFAULT NULL,
  `idAdmin` int unsigned DEFAULT NULL,
  `status` varchar(9) DEFAULT NULL,
  `motivoRechazo` text,
  PRIMARY KEY (`id`),
  KEY `idShop` (`idShop`),
  KEY `idUserCategory` (`idUserCategory`),
  KEY `idAdmin` (`idAdmin`),
  CONSTRAINT `promotion_ibfk_1` FOREIGN KEY (`idShop`) REFERENCES `shop` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `promotion_ibfk_2` FOREIGN KEY (`idUserCategory`) REFERENCES `usercategory` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `promotion_ibfk_3` FOREIGN KEY (`idAdmin`) REFERENCES `user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `promouse`
--

DROP TABLE IF EXISTS `promouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `promouse` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `useDate` date DEFAULT NULL,
  `uniqueCode` varchar(255) DEFAULT NULL,
  `wasUser` tinyint(1) DEFAULT NULL,
  `idPromo` int unsigned DEFAULT NULL,
  `idOwner` int unsigned DEFAULT NULL,
  `idUser` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idOwner` (`idOwner`),
  KEY `idUser` (`idUser`),
  KEY `idPromo` (`idPromo`),
  CONSTRAINT `promouse_ibfk_1` FOREIGN KEY (`idOwner`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `promouse_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `promouse_ibfk_3` FOREIGN KEY (`idPromo`) REFERENCES `promotion` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shop` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  `idOwner` int unsigned DEFAULT NULL,
  `idShopType` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idOwner` (`idOwner`),
  KEY `idShopType` (`idShopType`),
  CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`idOwner`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `shop_ibfk_2` FOREIGN KEY (`idShopType`) REFERENCES `shoptype` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shopimages`
--

DROP TABLE IF EXISTS `shopimages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopimages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imageUUID` varchar(255) DEFAULT NULL,
  `idShop` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idShop` (`idShop`),
  CONSTRAINT `shopimages_ibfk_1` FOREIGN KEY (`idShop`) REFERENCES `shop` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shoptype`
--

DROP TABLE IF EXISTS `shoptype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoptype` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `description` text,
  `dateDeleted` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `isOwner` tinyint(1) DEFAULT NULL,
  `dateDeleted` date DEFAULT NULL,
  `emailToken` varchar(255) DEFAULT NULL,
  `isEmailVerified` tinyint(1) DEFAULT NULL,
  `idUserCategory` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `emailToken` (`emailToken`),
  KEY `idUserCategory` (`idUserCategory`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idUserCategory`) REFERENCES `usercategory` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usercategory`
--

DROP TABLE IF EXISTS `usercategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usercategory` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `categoryType` varchar(255) NOT NULL,
  `dateDeleted` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoryType` (`categoryType`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `validpromoday`
--

DROP TABLE IF EXISTS `validpromoday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `validpromoday` (
  `idPromotion` int unsigned NOT NULL,
  `monday` tinyint(1) DEFAULT '0',
  `tuesday` tinyint(1) DEFAULT '0',
  `wednesday` tinyint(1) DEFAULT '0',
  `thursday` tinyint(1) DEFAULT '0',
  `friday` tinyint(1) DEFAULT '0',
  `saturday` tinyint(1) DEFAULT '0',
  `sunday` tinyint(1) DEFAULT '0',
  KEY `idPromotion` (`idPromotion`),
  CONSTRAINT `validpromoday_ibfk_1` FOREIGN KEY (`idPromotion`) REFERENCES `promotion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-28 18:55:59
