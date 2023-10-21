CREATE DATABASE  IF NOT EXISTS `laboratorio` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `laboratorio`;
-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: laboratorio
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `esporte`
--

DROP TABLE IF EXISTS `esporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `esporte` (
  `CODESPORTE` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `DESCRICAO` varchar(100) DEFAULT NULL,
  `FORCA` int DEFAULT (0),
  `VELOCIDADE` int DEFAULT (0),
  `INTELIGENCIA` int DEFAULT (0),
  `ATIVO` varchar(1) DEFAULT (_utf8mb4'S'),
  PRIMARY KEY (`CODESPORTE`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `esporte`
--

LOCK TABLES `esporte` WRITE;
/*!40000 ALTER TABLE `esporte` DISABLE KEYS */;
INSERT INTO `esporte` VALUES (1,'Futebol','Esporte de equipe que envolve chutar uma bola no gol',10,8,6,'S'),(2,'Basquete','Esporte de equipe jogado com uma bola em uma quadra',8,9,7,'S'),(3,'Vôlei','Esporte de equipe jogado em uma quadra dividida por uma rede',7,8,7,'S'),(4,'Luta','Esporte individual que envolve combate corpo a corpo',9,6,6,'S'),(5,'Atletismo','Esporte que envolve corrida, saltos e arremessos',10,9,7,'S'),(6,'eSports','Competições de videogame entre jogadores profissionais',5,6,8,'S');
/*!40000 ALTER TABLE `esporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gosto_musical`
--

DROP TABLE IF EXISTS `gosto_musical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gosto_musical` (
  `CODGENERO` int NOT NULL AUTO_INCREMENT,
  `GENERO` varchar(30) NOT NULL,
  `DESCRICAO` varchar(100) DEFAULT NULL,
  `FORCA` int DEFAULT (0),
  `VELOCIDADE` int DEFAULT (0),
  `INTELIGENCIA` int DEFAULT (0),
  `ATIVO` varchar(1) DEFAULT (_utf8mb4'S'),
  PRIMARY KEY (`CODGENERO`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gosto_musical`
--

LOCK TABLES `gosto_musical` WRITE;
/*!40000 ALTER TABLE `gosto_musical` DISABLE KEYS */;
INSERT INTO `gosto_musical` VALUES (1,'Pop','Gênero musical popular com canções cativantes',7,7,6,'S'),(2,'Rock','Gênero musical com influências de guitarra e bateria',8,7,7,'S'),(3,'Pagode','Gênero musical brasileiro com batucada e pandeiro',6,7,6,'S'),(4,'Sertanejo','Gênero musical country brasileiro com duplas',7,6,6,'S'),(5,'Hip-Hop/Rap','Gênero musical com rimas e batidas rítmicas',8,8,7,'S'),(6,'Eletrônica','Gênero musical com batidas eletrônicas e sintetizadores',7,9,7,'S'),(7,'Funk','Gênero musical brasileiro com ritmos dançantes',7,8,6,'S'),(8,'Metal','Gênero musical pesado com guitarras distorcidas',9,7,7,'S');
/*!40000 ALTER TABLE `gosto_musical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospedeiro`
--

DROP TABLE IF EXISTS `hospedeiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospedeiro` (
  `CODHOSPEDEIRO` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `IDADE` int NOT NULL,
  `SEXO` int NOT NULL,
  `PESO` decimal(5,2) NOT NULL,
  `ALTURA` decimal(5,2) NOT NULL,
  `TIPO_SANGUINEO` varchar(3) NOT NULL,
  `CODSTATUS` int NOT NULL,
  PRIMARY KEY (`CODHOSPEDEIRO`),
  KEY `FK_HOSPEDEIRO_STATUS` (`CODSTATUS`),
  CONSTRAINT `FK_HOSPEDEIRO_STATUS` FOREIGN KEY (`CODSTATUS`) REFERENCES `status` (`CODSTATUS`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospedeiro`
--

LOCK TABLES `hospedeiro` WRITE;
/*!40000 ALTER TABLE `hospedeiro` DISABLE KEYS */;
INSERT INTO `hospedeiro` VALUES (2,'zumbi teste',34,2,50.00,1.23,'A+',2),(3,'teste',123,2,123.00,1.23,'A+',2);
/*!40000 ALTER TABLE `hospedeiro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospedeiro_esporte`
--

DROP TABLE IF EXISTS `hospedeiro_esporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospedeiro_esporte` (
  `CODHOSPEDEIRO` int NOT NULL,
  `CODESPORTE` int NOT NULL,
  PRIMARY KEY (`CODHOSPEDEIRO`,`CODESPORTE`),
  KEY `FK_HOSPEDEIRO_ESPORTE_ESPORTE` (`CODESPORTE`),
  CONSTRAINT `FK_HOSPEDEIRO_ESPORTE_ESPORTE` FOREIGN KEY (`CODESPORTE`) REFERENCES `esporte` (`CODESPORTE`),
  CONSTRAINT `FK_HOSPEDEIRO_ESPORTE_HOSPEDEIRO` FOREIGN KEY (`CODHOSPEDEIRO`) REFERENCES `hospedeiro` (`CODHOSPEDEIRO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospedeiro_esporte`
--

LOCK TABLES `hospedeiro_esporte` WRITE;
/*!40000 ALTER TABLE `hospedeiro_esporte` DISABLE KEYS */;
INSERT INTO `hospedeiro_esporte` VALUES (3,1),(3,2),(3,3);
/*!40000 ALTER TABLE `hospedeiro_esporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospedeiro_gosto_musical`
--

DROP TABLE IF EXISTS `hospedeiro_gosto_musical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospedeiro_gosto_musical` (
  `CODHOSPEDEIRO` int NOT NULL,
  `CODGENERO` int NOT NULL,
  PRIMARY KEY (`CODHOSPEDEIRO`,`CODGENERO`),
  KEY `FK_HOSPEDEIRO_GOSTO_MUSICAL_GOSTO_MUSICAL` (`CODGENERO`),
  CONSTRAINT `FK_HOSPEDEIRO_GOSTO_MUSICAL_GOSTO_MUSICAL` FOREIGN KEY (`CODGENERO`) REFERENCES `gosto_musical` (`CODGENERO`),
  CONSTRAINT `FK_HOSPEDEIRO_GOSTO_MUSICAL_HOSPEDEIRO` FOREIGN KEY (`CODHOSPEDEIRO`) REFERENCES `hospedeiro` (`CODHOSPEDEIRO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospedeiro_gosto_musical`
--

LOCK TABLES `hospedeiro_gosto_musical` WRITE;
/*!40000 ALTER TABLE `hospedeiro_gosto_musical` DISABLE KEYS */;
INSERT INTO `hospedeiro_gosto_musical` VALUES (2,1),(3,1),(3,2);
/*!40000 ALTER TABLE `hospedeiro_gosto_musical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospedeiro_jogo`
--

DROP TABLE IF EXISTS `hospedeiro_jogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hospedeiro_jogo` (
  `CODHOSPEDEIRO` int NOT NULL,
  `CODJOGO` int NOT NULL,
  PRIMARY KEY (`CODHOSPEDEIRO`,`CODJOGO`),
  KEY `FK_HOSPEDEIRO_JOGO_JOGO` (`CODJOGO`),
  CONSTRAINT `FK_HOSPEDEIRO_JOGO_HOSPEDEIRO` FOREIGN KEY (`CODHOSPEDEIRO`) REFERENCES `hospedeiro` (`CODHOSPEDEIRO`),
  CONSTRAINT `FK_HOSPEDEIRO_JOGO_JOGO` FOREIGN KEY (`CODJOGO`) REFERENCES `jogo` (`CODJOGO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospedeiro_jogo`
--

LOCK TABLES `hospedeiro_jogo` WRITE;
/*!40000 ALTER TABLE `hospedeiro_jogo` DISABLE KEYS */;
INSERT INTO `hospedeiro_jogo` VALUES (3,1),(3,2);
/*!40000 ALTER TABLE `hospedeiro_jogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jogo`
--

DROP TABLE IF EXISTS `jogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jogo` (
  `CODJOGO` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `DESCRICAO` varchar(100) DEFAULT NULL,
  `FORCA` int DEFAULT (0),
  `VELOCIDADE` int DEFAULT (0),
  `INTELIGENCIA` int DEFAULT (0),
  `ATIVO` varchar(1) DEFAULT (_utf8mb4'S'),
  PRIMARY KEY (`CODJOGO`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jogo`
--

LOCK TABLES `jogo` WRITE;
/*!40000 ALTER TABLE `jogo` DISABLE KEYS */;
INSERT INTO `jogo` VALUES (1,'Counter-Strike','Jogo de tiro em primeira pessoa com equipes',8,8,7,'S'),(2,'Minecraft','Jogo de construção e exploração em mundo aberto',6,7,8,'S'),(3,'Fortnite','Battle royale com construção de estruturas',7,8,7,'S'),(4,'The Witcher','Jogo de RPG de ação baseado em fantasia',8,7,8,'S'),(5,'Valorant','Jogo de tiro tático em equipe',7,8,7,'S'),(6,'Assassin\'s Creed','Jogo de ação e aventura histórica',7,7,8,'S'),(7,'World of Warcraft','MMORPG de mundo aberto e fantasia',7,6,8,'S'),(8,'FIFA','Jogo de futebol com times e jogadores reais',8,7,7,'S'),(9,'League of Legends','Jogo MOBA de batalha em equipe',7,8,8,'S'),(10,'Dota','Jogo MOBA com estratégia e heróis únicos',8,8,8,'S'),(11,'Rocket League','Futebol com carros em alta velocidade',7,9,7,'S');
/*!40000 ALTER TABLE `jogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patos`
--

DROP TABLE IF EXISTS `patos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patos` (
  `CODPATO` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `DESCRICAO` varchar(100) DEFAULT NULL,
  `FORCA` int DEFAULT (0),
  `VELOCIDADE` int DEFAULT (0),
  `INTELIGENCIA` int DEFAULT (0),
  `POSSUI_CHIP` varchar(1) DEFAULT (_utf8mb4'S'),
  `CODSTATUS` int NOT NULL,
  PRIMARY KEY (`CODPATO`),
  KEY `FK_DUCK_STATUS` (`CODSTATUS`),
  CONSTRAINT `FK_DUCK_STATUS` FOREIGN KEY (`CODSTATUS`) REFERENCES `status` (`CODSTATUS`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patos`
--

LOCK TABLES `patos` WRITE;
/*!40000 ALTER TABLE `patos` DISABLE KEYS */;
INSERT INTO `patos` VALUES (1,'teste  pato','',5,5,5,'S',1);
/*!40000 ALTER TABLE `patos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status` (
  `CODSTATUS` int NOT NULL AUTO_INCREMENT,
  `NOME` varchar(30) DEFAULT NULL,
  `ATIVO` varchar(1) DEFAULT (_utf8mb4'S'),
  PRIMARY KEY (`CODSTATUS`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'ELIMINADO','S'),(2,'NÂO ELIMINADO','S');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-20 21:13:40
