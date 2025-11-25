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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcategoria`
--

LOCK TABLES `tbcategoria` WRITE;
/*!40000 ALTER TABLE `tbcategoria` DISABLE KEYS */;
INSERT INTO `tbcategoria` VALUES (2,'Quadrinhos','categoria_692513e360e548.05333419.jpg'),(7,'Mangás','categoria_692513ee83c835.04849685.jpg'),(8,'Jogos','categoria_692513f849d115.18007987.jpg'),(9,'Músicas','categoria_6925141722dfe2.91928605.jpg'),(10,'Séries','categoria_6925141d81f607.18306708.jpg'),(12,'Animes','categoria_6925c4a49b4f65.61293827.jpg'),(13,'Filmes','categoria_6925c8d4df91a5.17704048.jpg'),(14,'Livros','categoria_6925c903b341f5.61352682.jpg'),(15,'Desenhos/Cartoons','categoria_69262a26d8ece9.46539425.png');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbcompra`
--

LOCK TABLES `tbcompra` WRITE;
/*!40000 ALTER TABLE `tbcompra` DISABLE KEYS */;
INSERT INTO `tbcompra` VALUES (4,'2025-11-25 12:22:25',3,30,1,27),(5,'2025-11-25 12:22:39',2,20,1,27);
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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbobra`
--

LOCK TABLES `tbobra` WRITE;
/*!40000 ALTER TABLE `tbobra` DISABLE KEYS */;
INSERT INTO `tbobra` VALUES (10,'Naruto','Naruto é uma série de mangá escrita e ilustrada por Masashi Kishimoto, que conta a história de Naruto Uzumaki, um jovem ninja que constantemente procura por reconhecimento e sonha em se tornar Hokage, o ninja líder de sua vila.'),(12,'Hunter X Hunter','Hunter x Hunter é um mangá e anime sobre a jornada de Gon Freecss para se tornar um Hunter, um profissional com licença para caçar tesouros, criaturas raras e lugares perigosos, a fim de encontrar seu pai desaparecido.'),(16,'Harry Potter','Harry Potter conta a história de um jovem bruxo que descobre seus poderes, entra em Hogwarts e enfrenta o vilão Voldemort enquanto vive amizades, aventuras e desafios no mundo mágico.'),(18,'Steven Universe','Pedras espaciais que lutam na terra!'),(19,'Ben 10','A história começou quando um relógio esquisito\r\nGrudou no pulso dele, vindo lá do infinito\r\nAgora tem poderes e com eles faz bonito\r\nÉ o Ben 10 (Ben 10)'),(20,'Boku no Hero','My Hero Academia (Boku no Hero Academia) é uma série de anime que combina ação, narrativa comovente e o crescimento pessoal de jovens em um mundo dinâmico de super-heróis.'),(22,'Fullmetal Alchemist','O descaso com as leis da alquimia tomou dois dos membros de Edward Elric e deixou a alma de Alphonse presa a uma armadura. Para recuperar o que perderam, os irmãos procuram a Pedra Filosofal.'),(63,'Digimon','Durante um acampamento de verão, sete crianças encontram sete Digivices e são transportados para um estranho mundo digital.'),(65,'Pokémon','Neste mundo vibrante, humanos convivem com criaturas incríveis. A cada passo, novos mistérios se revelam, mostrando a magia profunda que permeia todo o universo Pokémon.');
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
INSERT INTO `tbobracategoria` VALUES (12,2),(16,2),(18,2),(19,2),(10,7),(12,7),(20,7),(22,7),(65,7),(12,8),(18,8),(19,8),(20,8),(65,8),(18,9),(19,10),(20,12),(22,12),(63,12),(65,12),(16,13),(18,13),(19,13),(20,13),(65,13),(16,14),(22,14),(19,15),(63,15),(65,15);
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbproduto`
--

LOCK TABLES `tbproduto` WRITE;
/*!40000 ALTER TABLE `tbproduto` DISABLE KEYS */;
INSERT INTO `tbproduto` VALUES (26,'Samehada','A espada dos sete espadachins da nevoa.',15000,10,'produto_6925c79d844883.51418535.png',10),(27,'Varinha Magica','Uma varinha é um instrumento mágico quase consciente pelo qual uma bruxa ou bruxo (escolhido pela varinha) canaliza seus poderes mágicos.',300,1,'produto_692638cab96358.54245544.png',16),(28,'Omnitrix','O Omnimatrix, mais conhecido como Omnitrix, era um dispositivo em forma de relógio que foi ligado ao pulso e ao DNA de Ben 10.',15000,1,'produto_6926385aad1aa4.45961923.png',19),(29,'Shurikens','Shuriken, assim como a kunai, é uma das armas shinobi mais recorrentes na série Naruto. Essas estrelas metálicas afiadas possuem quatro pontas e são utilizadas tanto em combates à distância quanto, embora menos eficazes, em confrontos próximos.',15,35,'produto_69263919bc44a8.27879815.png',10),(31,'Espada de Rose Quartz','A Espada de Rose foi uma arma criada por Bismuto para Rose Quartz. Sendo descoberta por Steven e Connie.',13500,1,'produto_69263a3bab92c5.05427618.png',18),(32,'Armadura do Alphonse','A armadura de Al é o receptáculo da alma presa pelo selo de sangue após a tentativa de transmutação humana. Vazia por dentro, protege Al e simboliza sua perda e determinação ao lado de Ed',35000,1,'produto_69263b42bb0907.85950552.png',22),(33,'Pokébola','A Pokébola é o icônico dispositivo usado para conter e transportar Pokémon. Criada para facilitar o vínculo entre treinadores e criaturas, representa aventura, captura e parceria duradoura e laços af.',25,12,'produto_69263c3bb73cf1.82405245.png',65);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbusuario`
--

LOCK TABLES `tbusuario` WRITE;
/*!40000 ALTER TABLE `tbusuario` DISABLE KEYS */;
INSERT INTO `tbusuario` VALUES (1,'Caronte','0001-01-01','caronte@geeks.com','1234567','Admin','icon_user_branco.svg',10000),(13,'Thiago K.','2000-02-20','thaigo@exemplo.com','123@e','User','icon_user_branco.svg',0),(14,'Sergio L.','2000-12-15','sergio@exemplo.com','123456','User','icon_user_branco.svg',0);
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

-- Dump completed on 2025-11-25 20:36:44
