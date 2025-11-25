CREATE DATABASE  IF NOT EXISTS `dbgeekartifacts` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbgeekartifacts`;
-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: dbgeekartifacts
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
  `imagem_categoria` varchar(255) NOT NULL DEFAULT 'sem_imagem.png',
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `un_NomeCategoria_tbCategoria` (`nome_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcategoria`
--

LOCK TABLES `tbcategoria` WRITE;
/*!40000 ALTER TABLE `tbcategoria` DISABLE KEYS */;
INSERT INTO `tbcategoria` VALUES (2,'Quadrinhos','categoria_692513e360e548.05333419.jpg'),(7,'Mangá','categoria_692513ee83c835.04849685.jpg'),(8,'Jogo','categoria_692513f849d115.18007987.jpg'),(9,'Música','categoria_6925141722dfe2.91928605.jpg'),(10,'Série','categoria_6925141d81f607.18306708.jpg');
/*!40000 ALTER TABLE `tbcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbcompra`
--

DROP TABLE IF EXISTS `tbcompra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbcompra` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `data_hora_compra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unidades_compra` int NOT NULL,
  `valor_total_compra` double NOT NULL,
  `id_usuario` int NOT NULL,
  `id_produto` int NOT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `fk_tbCompra_tbUsuario` (`id_usuario`),
  KEY `fk_tbCompra_tbProduto` (`id_produto`),
  CONSTRAINT `fk_tbCompra_tbProduto` FOREIGN KEY (`id_produto`) REFERENCES `tbproduto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tbCompra_tbUsuario` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcompra`
--

LOCK TABLES `tbcompra` WRITE;
/*!40000 ALTER TABLE `tbcompra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbcompra` ENABLE KEYS */;
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
  `lance_inicial_leilao` double NOT NULL,
  `lance_atual_leilao` double NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbobra`
--

LOCK TABLES `tbobra` WRITE;
/*!40000 ALTER TABLE `tbobra` DISABLE KEYS */;
INSERT INTO `tbobra` VALUES (2,'Dragon Ball Z','Anime clássico de ação e aventura'),(3,'Marvel Comics','Universo dos super-heróis da Marvel'),(4,'Star Wars','Saga épica de ficção científica'),(5,'One Piecee','Mangá e anime de piratas'),(6,'Batman','O Cavaleiro das Trevas');
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
  CONSTRAINT `fk_tbObraCategoria_tbCategoria` FOREIGN KEY (`id_categoria`) REFERENCES `tbcategoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tbObraCategoria_tbObra` FOREIGN KEY (`id_obra`) REFERENCES `tbobra` (`id_obra`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `preco_produto` double NOT NULL,
  `quantidade_produto` int NOT NULL,
  `imagem_produto` varchar(255) NOT NULL DEFAULT 'sem_imagem.png',
  `id_obra` int NOT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `fk_tbProduto_tbObra` (`id_obra`),
  CONSTRAINT `fk_tbProduto_tbObra` FOREIGN KEY (`id_obra`) REFERENCES `tbobra` (`id_obra`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbproduto`
--

LOCK TABLES `tbproduto` WRITE;
/*!40000 ALTER TABLE `tbproduto` DISABLE KEYS */;
INSERT INTO `tbproduto` VALUES (16,'Orbis','Orbis para envocar o Dragon',1000,9,'produto_692593b1dde956.16200002.jpg',2),(17,'Dector','dector',14000,2,'produto_692593fc7a2331.80700152.jpg',2),(18,'Robo','robo de Star wars',50000,4,'produto_69259459cc82f1.71354479.webp',4),(19,'Capacete','Capacete colecionaveis',22000,3,'produto_692594ab4bf940.90393758.webp',4),(20,'Iron Main','Universo dos super-heróis da Marvel',41111,22,'produto_69259523099513.09095114.jpg',3),(21,'Batman: The Dark Knight','O cavaleiro das trevas',1000,1,'produto_6925956da8bcf8.34717814.jpg',6),(22,'One Piece Vol.1','Mangá e anime de piratas',39.9,3,'produto_692595c9571a11.78105580.jpg',5),(23,'One Piece Vol.2','Mangá e anime de piratas',80,1,'semImagem.png',5);
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
  `imagem_usuario` varchar(255) NOT NULL DEFAULT 'icon_user_branco.svg',
  `saldo_usuario` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `un_EmailUsuario_tbUsuario` (`email_usuario`),
  CONSTRAINT `ch_TipoUsuario_tbUsuario` CHECK ((`tipo_usuario` in (_utf8mb4'User',_utf8mb4'Admin')))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuario`
--

LOCK TABLES `tbusuario` WRITE;
/*!40000 ALTER TABLE `tbusuario` DISABLE KEYS */;
INSERT INTO `tbusuario` VALUES (1,'Caronte','0001-01-01','caronte@gmail.com','1234567','Admin','icon_user_branco.svg',1122),(9,'User','2009-05-25','user@gmail.com','123456','User','icon_user_branco.svg',0);
/*!40000 ALTER TABLE `tbusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbusuarioleilao`
--

DROP TABLE IF EXISTS `tbusuarioleilao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbusuarioleilao` (
  `id_usuario` int NOT NULL,
  `id_leilao` int NOT NULL,
  `valor_lance` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_leilao`),
  KEY `fk_tbUsuarioLeilao_tbLeilao` (`id_leilao`),
  CONSTRAINT `fk_tbUsuarioLeilao_tbLeilao` FOREIGN KEY (`id_leilao`) REFERENCES `tbleilao` (`id_leilao`),
  CONSTRAINT `fk_tbUsuarioLeilao_tbUsuario` FOREIGN KEY (`id_usuario`) REFERENCES `tbusuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuarioleilao`
--

LOCK TABLES `tbusuarioleilao` WRITE;
/*!40000 ALTER TABLE `tbusuarioleilao` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbusuarioleilao` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-25  8:44:35
