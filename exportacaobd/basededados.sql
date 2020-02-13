CREATE DATABASE  IF NOT EXISTS `augustospet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `augustospet`;
-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: localhost    Database: augustospet
-- ------------------------------------------------------
-- Server version	8.0.17

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
-- Table structure for table `animais`
--

DROP TABLE IF EXISTS `animais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `idade` int(11) NOT NULL,
  `id_porte` int(11) NOT NULL,
  `id_temperamento` int(11) NOT NULL,
  `id_cor` int(11) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `id_raca` int(11) NOT NULL,
  `id_dono` int(11) DEFAULT NULL,
  `nome_dono` varchar(100) DEFAULT NULL,
  `contato_dono` varchar(20) DEFAULT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fkdono_idx` (`id_dono`),
  CONSTRAINT `fkdono` FOREIGN KEY (`id_dono`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animais`
--

LOCK TABLES `animais` WRITE;
/*!40000 ALTER TABLE `animais` DISABLE KEYS */;
/*!40000 ALTER TABLE `animais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_doenca`
--

DROP TABLE IF EXISTS `animal_doenca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animal_doenca` (
  `id_animal` int(11) NOT NULL,
  `id_doenca` int(11) NOT NULL,
  KEY `fkanimal_idx` (`id_animal`),
  KEY `fkdoenca_idx` (`id_doenca`),
  CONSTRAINT `fkanimal` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`),
  CONSTRAINT `fkdoenca` FOREIGN KEY (`id_doenca`) REFERENCES `doencas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_doenca`
--

LOCK TABLES `animal_doenca` WRITE;
/*!40000 ALTER TABLE `animal_doenca` DISABLE KEYS */;
/*!40000 ALTER TABLE `animal_doenca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho_produto`
--

DROP TABLE IF EXISTS `carrinho_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho_produto` (
  `id_produto` int(11) NOT NULL,
  `id_carrinho` int(11) NOT NULL,
  `saida_produto` int(11) DEFAULT '1',
  `saida_preco` decimal(9,2) DEFAULT NULL,
  KEY `fkcarrinho_idx` (`id_carrinho`),
  KEY `fkproduto_idx` (`id_produto`),
  CONSTRAINT `fkcarrinhocompra` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinho_temporario` (`id`),
  CONSTRAINT `fkprodutocompra` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho_produto`
--

LOCK TABLES `carrinho_produto` WRITE;
/*!40000 ALTER TABLE `carrinho_produto` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho_servico`
--

DROP TABLE IF EXISTS `carrinho_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho_servico` (
  `id_servico` int(11) NOT NULL,
  `id_carrinho` int(11) NOT NULL,
  `saida_preco` decimal(9,2) DEFAULT NULL,
  KEY `fkcarrinhoservico_idx` (`id_servico`),
  KEY `fkcarrinhotempservico_idx` (`id_carrinho`),
  CONSTRAINT `fkcarrinhoservico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`),
  CONSTRAINT `fkcarrinhotempservico` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinho_temporario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho_servico`
--

LOCK TABLES `carrinho_servico` WRITE;
/*!40000 ALTER TABLE `carrinho_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrinho_temporario`
--

DROP TABLE IF EXISTS `carrinho_temporario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho_temporario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `preco_temp` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `fkcliente_idx` (`id_cliente`),
  CONSTRAINT `fkclientecompra` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho_temporario`
--

LOCK TABLES `carrinho_temporario` WRITE;
/*!40000 ALTER TABLE `carrinho_temporario` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrinho_temporario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(25) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `cep` varchar(20) NOT NULL,
  `logradouro` varchar(80) NOT NULL,
  `bairro` varchar(80) NOT NULL,
  `cidade` varchar(80) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Nicolas Santos','','','11952185975','nicolas.nicc21@gmail.com','M','06622670','Rua Maíra','Jardim Camila','Jandira','SP','50','man6.png'),(2,'Pedro Medeiros','','','(11)958819879','@peemedeiros','M','06622-330','Rua Embu','Parque Santa Tereza','Jandira','SP','37','man3.png');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_carrinho` int(11) NOT NULL,
  `id_formapagamento` int(11) NOT NULL,
  `data_compra` date DEFAULT NULL,
  `horario_compra` time DEFAULT NULL,
  `preco_total` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcliente_idx` (`id_cliente`),
  KEY `fkformapagamento_idx` (`id_formapagamento`),
  KEY `fkcarrinhocompra_idx` (`id_carrinho`),
  CONSTRAINT `fkcarrinhotemporario` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinho_temporario` (`id`),
  CONSTRAINT `fkcliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fkformapagamento` FOREIGN KEY (`id_formapagamento`) REFERENCES `forma_pagamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra_produto`
--

DROP TABLE IF EXISTS `compra_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra_produto` (
  `id_compra` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  KEY `fkcompra_idx` (`id_compra`),
  KEY `fkproduto_idx` (`id_produto`),
  CONSTRAINT `fkcompra` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`),
  CONSTRAINT `fkproduto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra_produto`
--

LOCK TABLES `compra_produto` WRITE;
/*!40000 ALTER TABLE `compra_produto` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra_servico`
--

DROP TABLE IF EXISTS `compra_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra_servico` (
  `id_compra` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra_servico`
--

LOCK TABLES `compra_servico` WRITE;
/*!40000 ALTER TABLE `compra_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cor_predominante`
--

DROP TABLE IF EXISTS `cor_predominante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cor_predominante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cor_predominante`
--

LOCK TABLES `cor_predominante` WRITE;
/*!40000 ALTER TABLE `cor_predominante` DISABLE KEYS */;
/*!40000 ALTER TABLE `cor_predominante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doencas`
--

DROP TABLE IF EXISTS `doencas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doencas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doencas`
--

LOCK TABLES `doencas` WRITE;
/*!40000 ALTER TABLE `doencas` DISABLE KEYS */;
/*!40000 ALTER TABLE `doencas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especies`
--

DROP TABLE IF EXISTS `especies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especies`
--

LOCK TABLES `especies` WRITE;
/*!40000 ALTER TABLE `especies` DISABLE KEYS */;
/*!40000 ALTER TABLE `especies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_pagamento`
--

DROP TABLE IF EXISTS `forma_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forma_pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_pagamento`
--

LOCK TABLES `forma_pagamento` WRITE;
/*!40000 ALTER TABLE `forma_pagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `forma_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `cnpj` varchar(45) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedores`
--

LOCK TABLES `fornecedores` WRITE;
/*!40000 ALTER TABLE `fornecedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `fornecedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico`
--

DROP TABLE IF EXISTS `ordem_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordem_servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_animal` int(11) DEFAULT NULL,
  `id_formapagamento` int(11) DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `contato_cliente` varchar(20) DEFAULT NULL,
  `data_ordem` date DEFAULT NULL,
  `horario_ordem` time DEFAULT NULL,
  `obs` text,
  `transporte` tinyint(1) DEFAULT NULL,
  `situacao` varchar(1) DEFAULT NULL,
  `situacao_pagamento` tinyint(1) DEFAULT '0',
  `total` decimal(9,2) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `logradouro` varchar(70) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `bairro` varchar(70) DEFAULT NULL,
  `cidade` varchar(70) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `valor_transporte` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcliente-ordem_idx` (`id_cliente`),
  KEY `fkanimal-orderm_idx` (`id_animal`),
  KEY `fkpagamento-ordem_idx` (`id_formapagamento`),
  CONSTRAINT `fkanimal-orderm` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`),
  CONSTRAINT `fkcliente-ordem` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fkpagamento-ordem` FOREIGN KEY (`id_formapagamento`) REFERENCES `forma_pagamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico`
--

LOCK TABLES `ordem_servico` WRITE;
/*!40000 ALTER TABLE `ordem_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordem_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordem_servico_servico`
--

DROP TABLE IF EXISTS `ordem_servico_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordem_servico_servico` (
  `id_ordem_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  KEY `fk-ordem-de-servico_idx` (`id_ordem_servico`),
  KEY `fk-servicos-da-ordemservico_idx` (`id_servico`),
  CONSTRAINT `fk-ordem-de-servico` FOREIGN KEY (`id_ordem_servico`) REFERENCES `ordem_servico` (`id`),
  CONSTRAINT `fk-servicos-da-ordemservico` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordem_servico_servico`
--

LOCK TABLES `ordem_servico_servico` WRITE;
/*!40000 ALTER TABLE `ordem_servico_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordem_servico_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `porte`
--

DROP TABLE IF EXISTS `porte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `porte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `porte`
--

LOCK TABLES `porte` WRITE;
/*!40000 ALTER TABLE `porte` DISABLE KEYS */;
/*!40000 ALTER TABLE `porte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(9,2) DEFAULT NULL,
  `preco_compra` decimal(9,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `descricao` text,
  `ativado` tinyint(1) DEFAULT '1',
  `id_categoria` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkcategoria_idx` (`id_categoria`),
  KEY `fkfornecedor_idx` (`id_fornecedor`),
  CONSTRAINT `fkcategoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  CONSTRAINT `fkprodutoFornecedor` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `racas`
--

DROP TABLE IF EXISTS `racas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `racas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fkespecie_idx` (`id_especie`),
  CONSTRAINT `fkespecie` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `racas`
--

LOCK TABLES `racas` WRITE;
/*!40000 ALTER TABLE `racas` DISABLE KEYS */;
/*!40000 ALTER TABLE `racas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicos`
--

DROP TABLE IF EXISTS `servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `preco` decimal(9,2) NOT NULL,
  `descricao` text,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicos`
--

LOCK TABLES `servicos` WRITE;
/*!40000 ALTER TABLE `servicos` DISABLE KEYS */;
INSERT INTO `servicos` VALUES (1,'Banho Comum PP',35.00,'Banho para animais de porte pequeno',1);
/*!40000 ALTER TABLE `servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temperamentos`
--

DROP TABLE IF EXISTS `temperamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temperamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `ativado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temperamentos`
--

LOCK TABLES `temperamentos` WRITE;
/*!40000 ALTER TABLE `temperamentos` DISABLE KEYS */;
INSERT INTO `temperamentos` VALUES (1,'Brincalhão',1);
/*!40000 ALTER TABLE `temperamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporte`
--

DROP TABLE IF EXISTS `transporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `nome_cliente` varchar(155) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `id_formapagamento` int(11) DEFAULT NULL,
  `valor_transporte` decimal(9,2) DEFAULT '0.00',
  `valor_servicos` decimal(9,2) DEFAULT '0.00',
  `cep` varchar(20) DEFAULT NULL,
  `logradouro` varchar(100) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `data_transporte` date DEFAULT NULL,
  `horario_transporte` time DEFAULT NULL,
  `situacao` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fktransportecliente_idx` (`id_cliente`),
  KEY `fktransportepagamento_idx` (`id_formapagamento`),
  CONSTRAINT `fktransportecliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fktransportepagamento` FOREIGN KEY (`id_formapagamento`) REFERENCES `forma_pagamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporte`
--

LOCK TABLES `transporte` WRITE;
/*!40000 ALTER TABLE `transporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporte_animal`
--

DROP TABLE IF EXISTS `transporte_animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transporte_animal` (
  `id_transporte` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  KEY `fkanimaltransporte_idx` (`id_animal`),
  KEY `fktransporteanimal_idx` (`id_transporte`),
  CONSTRAINT `fkanimaltransporte` FOREIGN KEY (`id_animal`) REFERENCES `animais` (`id`),
  CONSTRAINT `fktransporteanimal` FOREIGN KEY (`id_transporte`) REFERENCES `transporte` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporte_animal`
--

LOCK TABLES `transporte_animal` WRITE;
/*!40000 ALTER TABLE `transporte_animal` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporte_animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporte_servico`
--

DROP TABLE IF EXISTS `transporte_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transporte_servico` (
  `id_transporte` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  KEY `fk-transporte-servico_idx` (`id_transporte`),
  KEY `fk-servicos_idx` (`id_servico`),
  CONSTRAINT `fk-servicos` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`),
  CONSTRAINT `fk-transporte-servico` FOREIGN KEY (`id_transporte`) REFERENCES `transporte` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporte_servico`
--

LOCK TABLES `transporte_servico` WRITE;
/*!40000 ALTER TABLE `transporte_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporte_servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) NOT NULL,
  `username` varchar(45) NOT NULL,
  `senha` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (5,'dev','admin','123');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-12 23:37:32
