CREATE DATABASE  IF NOT EXISTS `dbprojetoweb1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbprojetoweb1`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: dbprojetoweb1
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `tbcategoria`
--

DROP TABLE IF EXISTS `tbcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbcategoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcategoria`
--

LOCK TABLES `tbcategoria` WRITE;
/*!40000 ALTER TABLE `tbcategoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbleilao`
--

DROP TABLE IF EXISTS `tbleilao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbleilao` (
  `id_leilao` int NOT NULL AUTO_INCREMENT,
  `data_horario_inicio_leilao` date NOT NULL,
  `lance_inicial_leilao` float NOT NULL,
  `lance_atual_leilao` float NOT NULL,
  `id_produto` int NOT NULL,
  PRIMARY KEY (`id_leilao`),
  KEY `fk_tbLelao_tbProduto` (`id_produto`),
  CONSTRAINT `fk_tbLelao_tbProduto` FOREIGN KEY (`id_produto`) REFERENCES `tbproduto` (`id_produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbleilao`
--

LOCK TABLES `tbleilao` WRITE;
/*!40000 ALTER TABLE `tbleilao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbleilao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbobra`
--

DROP TABLE IF EXISTS `tbobra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbobra` (
  `id_obra` int NOT NULL AUTO_INCREMENT,
  `nome_obra` varchar(80) DEFAULT NULL,
  `descricao_obra` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_obra`),
  UNIQUE KEY `un_NomeObra_tbUsuario` (`nome_obra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbobra`
--

LOCK TABLES `tbobra` WRITE;
/*!40000 ALTER TABLE `tbobra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbobra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbobracategoria`
--

DROP TABLE IF EXISTS `tbobracategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbobracategoria` (
  `id_obra` int NOT NULL,
  `id_categoria` int NOT NULL,
  PRIMARY KEY (`id_obra`,`id_categoria`),
  KEY `fk_tbObraCategoria_tbCategoria` (`id_categoria`),
  CONSTRAINT `fk_tbObraCategoria_tbCategoria` FOREIGN KEY (`id_categoria`) REFERENCES `tbcategoria` (`id_categoria`),
  CONSTRAINT `fk_tbObraCategoria_tbObra` FOREIGN KEY (`id_obra`) REFERENCES `tbobra` (`id_obra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbobracategoria`
--

LOCK TABLES `tbobracategoria` WRITE;
/*!40000 ALTER TABLE `tbobracategoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbobracategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbproduto`
--

DROP TABLE IF EXISTS `tbproduto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbproduto` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(50) NOT NULL,
  `descricao_produto` varchar(255) NOT NULL,
  `preco_produto` decimal(10,0) NOT NULL,
  `id_obra` int NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `fk_tbProduto_tbObra` (`id_obra`),
  CONSTRAINT `fk_tbProduto_tbObra` FOREIGN KEY (`id_obra`) REFERENCES `tbobra` (`id_obra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbproduto`
--

LOCK TABLES `tbproduto` WRITE;
/*!40000 ALTER TABLE `tbproduto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbproduto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbusuario`
--

DROP TABLE IF EXISTS `tbusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbusuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(50) NOT NULL,
  `data_nascimento_usuario` date NOT NULL,
  `email_usuario` varchar(200) NOT NULL,
  `senha_usuario` varchar(100) NOT NULL,
  `tipo_usuario` varchar(15) NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `un_EmailUsuario_tbUsuario` (`email_usuario`),
  CONSTRAINT `ch_TipoUsuario_tbUsuario` CHECK ((`tipo_usuario` in (_utf8mb4'User',_utf8mb4'Admin')))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuario`
--

LOCK TABLES `tbusuario` WRITE;
/*!40000 ALTER TABLE `tbusuario` DISABLE KEYS */;
INSERT INTO `tbusuario` VALUES (1,'Caronte','0001-01-01','caronte@gmail.com','123456','Admin');
/*!40000 ALTER TABLE `tbusuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-14 17:17:04
