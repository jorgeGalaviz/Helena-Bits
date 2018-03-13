-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: ely
-- ------------------------------------------------------
-- Server version	5.6.23

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
-- Table structure for table `ap_usuarios`
--

DROP TABLE IF EXISTS `ap_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ap_usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_estatus` int(11) DEFAULT NULL,
  `fec_alta` datetime DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `pass` varchar(45) DEFAULT NULL,
  `pass_cod` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `accesos` int(11) DEFAULT '0',
  PRIMARY KEY (`id_usuario`),
  KEY `key_usuario_es_idx` (`id_estatus`),
  CONSTRAINT `key_usuario_es` FOREIGN KEY (`id_estatus`) REFERENCES `es_ap_usuarios` (`id_estatus`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ap_usuarios`
--

LOCK TABLES `ap_usuarios` WRITE;
/*!40000 ALTER TABLE `ap_usuarios` DISABLE KEYS */;
INSERT INTO `ap_usuarios` VALUES (1,3,'2017-09-24 19:52:52','jorge','galaviz','a08c994741a670b1cce10f27d9fd3909c6e89e1b','Jorge Galaviz',157),(2,3,'2017-10-04 23:58:00','antonio','galaviz1','1b65d9b2539728e5f3694fc840c5da64291e7a1d','Antonio Bonilla',6);
/*!40000 ALTER TABLE `ap_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_base`
--

DROP TABLE IF EXISTS `cat_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_base` (
  `id_clave` int(11) NOT NULL AUTO_INCREMENT,
  `id_estatus` int(11) DEFAULT NULL,
  `ip_cliente` varchar(45) DEFAULT NULL,
  `dispositivo` varchar(255) DEFAULT NULL,
  `llave` varchar(45) DEFAULT NULL,
  `intentos` int(11) DEFAULT NULL,
  `n_pagina` int(11) DEFAULT NULL,
  `tp_cuestionario` int(11) DEFAULT NULL,
  `base` int(11) DEFAULT NULL,
  `fec_inicio` datetime DEFAULT NULL,
  `fec_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id_clave`),
  KEY `fk_cat_base_es_cat_base1_idx` (`id_estatus`),
  KEY `fk_cat_base_cat_campanias1_idx` (`tp_cuestionario`),
  CONSTRAINT `fk_cat_base_cat_campanias1` FOREIGN KEY (`tp_cuestionario`) REFERENCES `cat_campanias` (`id_campania`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cat_base_es_cat_base1` FOREIGN KEY (`id_estatus`) REFERENCES `es_cat_base` (`id_estatus`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_base`
--

LOCK TABLES `cat_base` WRITE;
/*!40000 ALTER TABLE `cat_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `cat_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_campanias`
--

DROP TABLE IF EXISTS `cat_campanias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_campanias` (
  `id_campania` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_estatus` int(11) DEFAULT NULL,
  `base` varchar(255) DEFAULT NULL,
  `tabla` varchar(255) DEFAULT NULL,
  `name_nombre` varchar(255) DEFAULT NULL,
  `fec_alta` datetime DEFAULT NULL,
  PRIMARY KEY (`id_campania`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_campanias`
--

LOCK TABLES `cat_campanias` WRITE;
/*!40000 ALTER TABLE `cat_campanias` DISABLE KEYS */;
INSERT INTO `cat_campanias` VALUES (1,1,0,'ely','cat_base','Campaña Prueba',NULL),(2,1,2,NULL,NULL,'Prueba 2','2017-10-04 23:20:18'),(3,1,2,NULL,NULL,'Prueba 3','2017-10-04 23:23:14'),(4,1,2,NULL,NULL,'Prueba 4','2017-10-04 23:23:20'),(5,1,2,NULL,NULL,'Prueba 5','2017-10-04 23:28:45'),(6,1,0,NULL,NULL,'Campaña Aqui','2017-10-04 23:29:38'),(7,1,0,NULL,NULL,'Mi campaña movil','2017-10-04 23:29:58'),(8,1,2,NULL,NULL,'Pruebas 12','2017-10-04 23:52:46'),(9,1,0,NULL,NULL,'Mi prueba Jorge','2017-10-04 23:52:55'),(10,1,2,NULL,NULL,'Jorge','2017-10-04 23:53:00'),(11,2,0,NULL,NULL,'Hola','2017-10-05 00:16:47'),(12,2,0,NULL,NULL,'Otra mas','2017-10-05 00:16:54'),(13,2,0,NULL,NULL,'Campaña Antonio','2017-10-05 00:16:59'),(14,1,2,NULL,NULL,'Mini dos','2017-10-13 14:24:26'),(15,1,2,NULL,NULL,'Dos','2017-10-13 14:24:33'),(16,1,0,NULL,NULL,'Otra','2017-10-13 14:53:38');
/*!40000 ALTER TABLE `cat_campanias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_ingresos`
--

DROP TABLE IF EXISTS `cat_ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_ingresos` (
  `id_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_ingreso`),
  KEY `key_user_ingresoidx` (`id_usuario`),
  CONSTRAINT `key_user_ingreso` FOREIGN KEY (`id_usuario`) REFERENCES `ap_usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_ingresos`
--

LOCK TABLES `cat_ingresos` WRITE;
/*!40000 ALTER TABLE `cat_ingresos` DISABLE KEYS */;
INSERT INTO `cat_ingresos` VALUES (1,'::1',1,'2017-09-24 21:35:21','ACCESO'),(2,'::1',1,'2017-09-24 21:35:49','ACCESO'),(3,'::1',1,'2017-09-24 21:36:00','ACCESO'),(4,'::1',1,'2017-09-24 21:40:13','ACCESO'),(5,'::1',1,'2017-09-24 21:40:28','ACCESO'),(6,'::1',1,'2017-09-24 21:42:36','ACCESO'),(7,'::1',1,'2017-09-24 21:51:21','ACCESO'),(8,'::1',1,'2017-09-24 21:59:52','ACCESO'),(9,'::1',1,'2017-09-24 22:00:24','ACCESO'),(10,'',1,'2017-09-24 22:18:22','SALIDA'),(11,'',1,'2017-09-24 22:18:55','SALIDA'),(12,'::1',1,'2017-09-24 22:20:52','SALIDA'),(13,'::1',1,'2017-09-24 22:25:53','SALIDA'),(14,'::1',1,'2017-09-24 22:33:50','SALIDA'),(15,'::1',1,'2017-09-24 22:33:57','SALIDA'),(16,'::1',1,'2017-09-24 22:33:59','SALIDA'),(17,'::1',1,'2017-09-24 22:34:17','SALIDA'),(18,'::1',1,'2017-09-24 22:34:50','SALIDA'),(19,'::1',1,'2017-09-24 22:34:53','SALIDA'),(20,'::1',1,'2017-09-24 22:34:58','SALIDA'),(21,'::1',1,'2017-09-24 22:35:00','SALIDA'),(22,'::1',1,'2017-09-24 22:35:12','SALIDA'),(23,'::1',1,'2017-09-24 22:35:55','SALIDA'),(24,'::1',1,'2017-09-24 22:36:18','SALIDA'),(25,'::1',1,'2017-09-24 22:36:19','SALIDA'),(26,'::1',1,'2017-09-24 22:36:20','SALIDA'),(27,'::1',1,'2017-09-24 22:36:22','SALIDA'),(28,'::1',1,'2017-09-24 22:36:28','SALIDA'),(29,'::1',1,'2017-09-24 22:37:09','SALIDA'),(30,'::1',1,'2017-09-24 22:37:52','SALIDA'),(31,'::1',1,'2017-09-24 22:38:04','SALIDA'),(32,'::1',1,'2017-09-24 22:38:06','SALIDA'),(33,'::1',1,'2017-09-24 22:38:06','SALIDA'),(34,'::1',1,'2017-09-24 22:38:10','SALIDA'),(35,'::1',1,'2017-09-24 22:38:18','SALIDA'),(36,'::1',1,'2017-09-24 22:38:40','SALIDA'),(37,'::1',1,'2017-09-24 22:38:49','SALIDA'),(38,'::1',1,'2017-09-24 22:38:59','SALIDA'),(39,'::1',1,'2017-09-24 22:39:13','SALIDA'),(40,'::1',1,'2017-09-24 22:39:46','ACCESO'),(41,'::1',1,'2017-09-24 22:39:52','SALIDA'),(42,'::1',1,'2017-09-24 22:39:58','ACCESO'),(43,'::1',1,'2017-09-24 22:40:38','ACCESO'),(44,'::1',1,'2017-09-24 22:40:41','ACCESO'),(45,'::1',1,'2017-09-24 22:40:52','ACCESO'),(46,'::1',1,'2017-09-24 22:45:25','SALIDA'),(47,'::1',1,'2017-09-24 22:45:46','ACCESO'),(48,'::1',1,'2017-09-24 22:51:58','ACCESO'),(49,'::1',1,'2017-09-24 22:51:59','SALIDA'),(50,'::1',1,'2017-09-24 22:52:03','ACCESO'),(51,'::1',1,'2017-09-24 22:53:03','ACCESO'),(52,'::1',1,'2017-09-24 22:53:04','SALIDA'),(53,'::1',1,'2017-09-24 22:53:12','ACCESO'),(54,'::1',1,'2017-09-24 22:53:14','SALIDA'),(55,'::1',1,'2017-09-24 22:54:00','ACCESO'),(56,'::1',1,'2017-09-24 22:56:37','SALIDA'),(57,'::1',1,'2017-09-24 22:58:21','ACCESO'),(58,'::1',1,'2017-09-24 22:59:53','ACCESO'),(59,'::1',1,'2017-09-24 23:00:06','ACCESO'),(60,'::1',1,'2017-09-24 23:00:18','SALIDA'),(61,'::1',1,'2017-09-24 23:00:22','ACCESO'),(62,'::1',1,'2017-09-24 23:00:24','SALIDA'),(63,'::1',1,'2017-09-24 23:02:39','ACCESO'),(64,'::1',1,'2017-09-24 23:04:04','ACCESO'),(65,'::1',1,'2017-09-24 23:04:06','SALIDA'),(66,'::1',1,'2017-09-24 23:04:10','ACCESO'),(67,'::1',1,'2017-09-24 23:04:31','ACCESO'),(68,'::1',1,'2017-09-24 23:04:59','SALIDA'),(69,'::1',1,'2017-09-24 23:05:07','ACCESO'),(70,'::1',1,'2017-09-24 23:05:12','ACCESO'),(71,'::1',1,'2017-09-24 23:05:31','ACCESO'),(72,'::1',1,'2017-09-24 23:05:37','ACCESO'),(73,'::1',1,'2017-09-24 23:05:41','ACCESO'),(74,'::1',1,'2017-09-24 23:08:03','SALIDA'),(75,'::1',1,'2017-09-24 23:08:07','ACCESO'),(76,'::1',1,'2017-09-24 23:08:10','SALIDA'),(77,'::1',1,'2017-09-24 23:14:29','ACCESO'),(78,'::1',1,'2017-09-24 23:14:32','SALIDA'),(79,'::1',1,'2017-10-04 14:53:22','ACCESO'),(80,'::1',1,'2017-10-04 14:54:57','ACCESO'),(81,'::1',1,'2017-10-04 14:55:04','ACCESO'),(82,'::1',1,'2017-10-04 14:55:17','ACCESO'),(83,'::1',1,'2017-10-04 14:55:46','ACCESO'),(84,'::1',1,'2017-10-04 14:56:02','ACCESO'),(85,'::1',1,'2017-10-04 15:02:02','ACCESO'),(86,'::1',1,'2017-10-04 15:02:17','ACCESO'),(87,'::1',1,'2017-10-04 15:02:35','ACCESO'),(88,'::1',1,'2017-10-04 15:03:13','ACCESO'),(89,'::1',1,'2017-10-04 15:03:14','ACCESO'),(90,'::1',1,'2017-10-04 15:03:22','ACCESO'),(91,'::1',1,'2017-10-04 15:04:01','ACCESO'),(92,'::1',1,'2017-10-04 15:04:45','ACCESO'),(93,'::1',1,'2017-10-04 15:04:46','ACCESO'),(94,'::1',1,'2017-10-04 15:04:46','ACCESO'),(95,'::1',1,'2017-10-04 15:04:47','ACCESO'),(96,'::1',1,'2017-10-04 15:04:47','ACCESO'),(97,'::1',1,'2017-10-04 15:04:48','ACCESO'),(98,'::1',1,'2017-10-04 15:04:51','ACCESO'),(99,'::1',1,'2017-10-04 15:05:53','ACCESO'),(100,'::1',1,'2017-10-04 15:09:20','ACCESO'),(101,'::1',1,'2017-10-04 15:11:34','ACCESO'),(102,'::1',1,'2017-10-04 15:11:41','ACCESO'),(103,'::1',1,'2017-10-04 15:11:53','ACCESO'),(104,'::1',1,'2017-10-04 15:13:40','ACCESO'),(105,'::1',1,'2017-10-04 15:13:41','ACCESO'),(106,'::1',1,'2017-10-04 15:13:42','ACCESO'),(107,'::1',1,'2017-10-04 15:13:43','ACCESO'),(108,'::1',1,'2017-10-04 15:13:56','ACCESO'),(109,'::1',1,'2017-10-04 15:14:08','ACCESO'),(110,'::1',1,'2017-10-04 15:15:53','ACCESO'),(111,'::1',1,'2017-10-04 15:15:59','ACCESO'),(112,'::1',1,'2017-10-04 15:16:13','ACCESO'),(113,'::1',1,'2017-10-04 15:28:31','ACCESO'),(114,'::1',1,'2017-10-04 15:29:32','ACCESO'),(115,'::1',1,'2017-10-04 15:29:34','ACCESO'),(116,'::1',1,'2017-10-04 15:30:00','ACCESO'),(117,'::1',1,'2017-10-04 15:30:23','ACCESO'),(118,'::1',1,'2017-10-04 15:41:40','ACCESO'),(119,'::1',1,'2017-10-04 15:43:34','ACCESO'),(120,'::1',1,'2017-10-04 15:43:49','ACCESO'),(121,'::1',1,'2017-10-04 15:43:51','ACCESO'),(122,'::1',1,'2017-10-04 15:50:20','SALIDA'),(123,'::1',1,'2017-10-04 15:50:33','ACCESO'),(124,'::1',1,'2017-10-04 15:51:35','ACCESO'),(125,'::1',1,'2017-10-04 15:51:36','ACCESO'),(126,'::1',1,'2017-10-04 15:51:45','SALIDA'),(127,'::1',1,'2017-10-04 15:51:49','ACCESO'),(128,'::1',1,'2017-10-04 15:53:06','ACCESO'),(129,'::1',1,'2017-10-04 15:55:36','ACCESO'),(130,'::1',1,'2017-10-04 15:56:06','ACCESO'),(131,'::1',1,'2017-10-04 15:56:07','ACCESO'),(132,'::1',1,'2017-10-04 15:56:15','ACCESO'),(133,'::1',1,'2017-10-04 17:03:06','SALIDA'),(134,'::1',1,'2017-10-04 17:05:49','ACCESO'),(135,'::1',1,'2017-10-04 17:28:53','SALIDA'),(136,'::1',1,'2017-10-04 17:28:56','ACCESO'),(137,'::1',1,'2017-10-04 17:53:19','ACCESO'),(138,'::1',1,'2017-10-04 18:06:44','ACCESO'),(139,'::1',1,'2017-10-04 18:07:30','ACCESO'),(140,'::1',1,'2017-10-04 18:15:45','ACCESO'),(141,'::1',1,'2017-10-04 18:16:19','ACCESO'),(142,'::1',1,'2017-10-04 18:16:40','ACCESO'),(143,'::1',1,'2017-10-04 18:18:28','ACCESO'),(144,'::1',1,'2017-10-04 18:19:00','ACCESO'),(145,'::1',1,'2017-10-04 18:19:18','ACCESO'),(146,'::1',1,'2017-10-04 18:19:20','ACCESO'),(147,'::1',1,'2017-10-04 18:19:42','ACCESO'),(148,'::1',1,'2017-10-04 18:19:55','ACCESO'),(149,'::1',1,'2017-10-04 18:19:56','ACCESO'),(150,'::1',1,'2017-10-04 18:20:18','ACCESO'),(151,'::1',1,'2017-10-04 18:20:20','ACCESO'),(152,'::1',1,'2017-10-04 18:21:02','ACCESO'),(153,'::1',1,'2017-10-04 18:21:04','ACCESO'),(154,'::1',1,'2017-10-04 18:21:05','ACCESO'),(155,'::1',1,'2017-10-04 18:21:13','ACCESO'),(156,'::1',1,'2017-10-04 18:22:31','ACCESO'),(157,'::1',1,'2017-10-04 18:22:43','ACCESO'),(158,'::1',1,'2017-10-04 18:23:15','ACCESO'),(159,'::1',1,'2017-10-04 18:24:02','ACCESO'),(160,'::1',1,'2017-10-04 18:26:40','ACCESO'),(161,'::1',1,'2017-10-04 18:28:27','SALIDA'),(162,'::1',1,'2017-10-04 18:28:32','ACCESO'),(163,'::1',1,'2017-10-04 18:28:37','ACCESO'),(164,'::1',1,'2017-10-04 18:28:39','SALIDA'),(165,'::1',1,'2017-10-04 18:28:45','ACCESO'),(166,'::1',1,'2017-10-04 18:28:52','ACCESO'),(167,'::1',1,'2017-10-04 18:29:03','ACCESO'),(168,'::1',1,'2017-10-04 18:29:06','ACCESO'),(169,'::1',1,'2017-10-04 18:29:10','ACCESO'),(170,'::1',1,'2017-10-04 18:29:14','SALIDA'),(171,'::1',1,'2017-10-04 18:29:24','ACCESO'),(172,'::1',1,'2017-10-04 18:29:28','ACCESO'),(173,'::1',1,'2017-10-04 18:29:37','ACCESO'),(174,'::1',1,'2017-10-04 18:29:39','ACCESO'),(175,'::1',1,'2017-10-04 18:29:45','ACCESO'),(176,'::1',1,'2017-10-04 18:29:48','ACCESO'),(177,'::1',1,'2017-10-04 18:31:07','ACCESO'),(178,'::1',1,'2017-10-04 18:31:09','SALIDA'),(179,'::1',1,'2017-10-04 18:31:12','ACCESO'),(180,'::1',1,'2017-10-04 18:31:17','ACCESO'),(181,'::1',1,'2017-10-04 18:32:16','ACCESO'),(182,'::1',1,'2017-10-04 18:32:46','ACCESO'),(183,'::1',1,'2017-10-04 18:32:48','SALIDA'),(184,'::1',1,'2017-10-04 18:32:52','ACCESO'),(185,'::1',1,'2017-10-04 18:42:22','SALIDA'),(186,'::1',1,'2017-10-04 18:42:26','ACCESO'),(187,'::1',1,'2017-10-04 18:49:19','SALIDA'),(188,'::1',1,'2017-10-04 18:49:25','ACCESO'),(189,'::1',1,'2017-10-04 18:49:27','ACCESO'),(190,'::1',1,'2017-10-04 18:49:28','ACCESO'),(191,'::1',1,'2017-10-04 18:49:29','ACCESO'),(192,'::1',1,'2017-10-04 18:49:34','SALIDA'),(193,'::1',1,'2017-10-04 18:49:39','ACCESO'),(194,'::1',1,'2017-10-04 19:07:43','SALIDA'),(195,'::1',1,'2017-10-04 19:07:47','ACCESO'),(196,'::1',1,'2017-10-04 23:58:10','SALIDA'),(197,'::1',2,'2017-10-05 00:00:17','ACCESO'),(198,'::1',2,'2017-10-05 00:13:32','SALIDA'),(199,'::1',2,'2017-10-05 00:13:43','ACCESO'),(200,'::1',2,'2017-10-05 00:14:33','ACCESO'),(201,'::1',2,'2017-10-05 00:15:47','ACCESO'),(202,'::1',2,'2017-10-05 00:17:03','SALIDA'),(203,'::1',1,'2017-10-05 00:17:08','ACCESO'),(204,'::1',1,'2017-10-05 00:35:38','ACCESO'),(205,'::1',1,'2017-10-05 00:36:58','SALIDA'),(206,'::1',1,'2017-10-05 00:37:45','ACCESO'),(207,'::1',1,'2017-10-05 00:38:46','SALIDA'),(208,'::1',1,'2017-10-11 22:38:41','ACCESO'),(209,'::1',1,'2017-10-13 13:29:40','ACCESO'),(210,'::1',1,'2017-10-13 18:13:19','SALIDA'),(211,'::1',2,'2017-10-13 18:14:03','ACCESO'),(212,'::1',2,'2017-10-13 18:14:39','ACCESO'),(213,'::1',2,'2017-10-13 18:14:44','SALIDA'),(214,'::1',1,'2017-10-13 18:14:49','ACCESO');
/*!40000 ALTER TABLE `cat_ingresos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_log`
--

DROP TABLE IF EXISTS `cat_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `ip_cliente` varchar(45) DEFAULT NULL,
  `dispositivo` varchar(255) DEFAULT NULL,
  `name_tipo` varchar(45) DEFAULT NULL,
  `fec_alta` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_log`
--

LOCK TABLES `cat_log` WRITE;
/*!40000 ALTER TABLE `cat_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `cat_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_preguntas`
--

DROP TABLE IF EXISTS `cat_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_preguntas` (
  `id_pregunta` int(11) NOT NULL AUTO_INCREMENT,
  `id_sub` int(11) DEFAULT NULL,
  `id_estatus` int(11) DEFAULT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `categoria` varchar(2) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `subtipo` int(11) DEFAULT NULL,
  `nombre_corto` varchar(45) DEFAULT NULL,
  `pregunta` varchar(500) DEFAULT NULL,
  `campo` varchar(45) DEFAULT NULL,
  `opcion` int(11) DEFAULT NULL,
  `pagina` varchar(5) DEFAULT NULL,
  `fec_Add` datetime DEFAULT NULL,
  `R1` varchar(255) DEFAULT NULL,
  `R2` varchar(255) DEFAULT NULL,
  `R3` varchar(255) DEFAULT NULL,
  `R4` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pregunta`),
  KEY `fk_cat_preguntas_cat_campanias_idx` (`id_sub`),
  CONSTRAINT `fk_cat_preguntas_cat_campanias` FOREIGN KEY (`id_sub`) REFERENCES `cat_campanias` (`id_campania`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_preguntas`
--

LOCK TABLES `cat_preguntas` WRITE;
/*!40000 ALTER TABLE `cat_preguntas` DISABLE KEYS */;
INSERT INTO `cat_preguntas` VALUES (1,1,1,1,'NA',0,NULL,NULL,'Label tipo 1',NULL,NULL,'P1','2016-08-30 00:54:44',NULL,NULL,NULL,NULL),(2,1,1,2,'NA',1,NULL,NULL,'Label tipo 2',NULL,NULL,'P1','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(3,1,1,3,'AP',1,NULL,'1.','Pregunta abierta','p1',NULL,'P2','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(4,1,1,4,'AP',2,NULL,'1.1','Escala 1','p2',NULL,'P2','2016-08-30 00:55:27','Ancla Left','Ancla Right','0','5'),(5,1,1,5,'AP',2,NULL,'2.','Escala','p3',NULL,'P3','2016-08-30 00:55:27','Ancla1','Ancla2','10','1'),(6,1,1,6,'AP',3,1,'2.1','Respuesta Unica','p4',NULL,'P3','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(7,1,1,7,'AP',3,2,'2.2','Respuesta multiple','p5',NULL,'P3','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(8,1,1,8,'AP',3,1,'3','Respuesta unica - orden aleatorio','p6',NULL,'P4','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(9,1,1,9,'AP',3,3,'3.1','Respuesta unica - orden abc - menciones','p7',NULL,'P4','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(10,1,1,10,'AP',4,1,'4','Bateria escala','p8',NULL,'P5','2016-08-30 00:55:27','Ancla1','Ancla2','1','5'),(11,1,1,11,'AP',4,1,'4.1','Bateria escala invertida','p9',NULL,'P5','2016-08-30 00:55:27','Ancla1','Ancla2','10','0'),(12,1,1,12,'AP',4,2,'5','Bateria SI/NO','p10',NULL,'P6','2016-08-30 00:55:27',NULL,NULL,NULL,NULL),(13,1,1,13,'AP',4,2,'5.1','Bateria multiple','p11',NULL,'P6','2016-08-30 00:55:27',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `cat_preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_respuestas`
--

DROP TABLE IF EXISTS `cat_respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_respuestas` (
  `id_prespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegunta` int(11) DEFAULT NULL,
  `respuesta` varchar(255) DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  `opcion` int(11) DEFAULT NULL,
  `es_otro` tinyint(1) DEFAULT NULL,
  `campo` varchar(45) DEFAULT NULL,
  `fec_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id_prespuesta`),
  KEY `fk_cat_respuestas_cat_preguntas1_idx` (`id_pegunta`),
  CONSTRAINT `fk_cat_respuestas_cat_preguntas1` FOREIGN KEY (`id_pegunta`) REFERENCES `cat_preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_respuestas`
--

LOCK TABLES `cat_respuestas` WRITE;
/*!40000 ALTER TABLE `cat_respuestas` DISABLE KEYS */;
INSERT INTO `cat_respuestas` VALUES (2,6,'Si',1,1,0,'','2016-08-30 01:18:08'),(3,6,'NO',2,1,0,'','2016-08-30 01:18:08'),(4,7,'Respuesta 1',1,2,0,'p2_1','2016-08-30 01:18:08'),(5,7,'Respuesta 2',2,2,0,'p2_2','2016-08-30 01:18:08'),(6,7,'Otro',99,2,1,'p3_99','2016-08-30 01:18:08'),(7,8,'A',1,1,0,'','2016-08-30 01:18:08'),(8,8,'B',2,1,0,'','2016-08-30 01:18:08'),(9,8,'C',3,1,0,'','2016-08-30 01:18:08'),(10,8,'D',4,1,0,'','2016-08-30 01:18:08'),(11,9,'C - 1',1,3,0,'','2016-08-30 01:18:08'),(12,9,'W -2',2,3,0,'','2016-08-30 01:18:08'),(13,9,'H - 3',3,3,0,'','2016-08-30 01:18:08'),(14,9,'J - 4',4,3,1,'','2016-08-30 01:18:08'),(15,10,'Escala A',1,1,0,'p4_a','2016-08-30 01:18:08'),(16,10,'Escala B',2,1,0,'p4_b','2016-08-30 01:18:08'),(17,10,'Escala C',3,1,0,'p4_c','2016-08-30 01:18:08'),(18,10,'Escala D',4,1,1,'p4_d','2016-08-30 01:18:08'),(19,11,'Esc 1',1,2,0,'p4_1_1','2016-08-30 01:18:08'),(20,11,'Esc 2',2,2,0,'p4_1_2','2016-08-30 01:18:08'),(21,11,'Esc 3',3,2,0,'p4_1_3','2016-08-30 01:18:08'),(22,11,'Esc 4',4,2,1,'p4_1_4','2016-08-30 01:18:08'),(23,12,'Bat SI NO 1',1,1,0,'p5_1','2016-08-30 01:18:08'),(24,12,'Bat SI NO 2',2,1,0,'p5_2','2016-08-30 01:18:08'),(25,12,'Bat SI NO 3',3,1,0,'p5_3','2016-08-30 01:18:08'),(26,12,'SI',1,2,1,'','2016-08-30 01:18:08'),(27,12,'NO',2,2,1,'','2016-08-30 01:18:08'),(28,13,'Bat M1',1,1,0,'p5_1_1','2016-08-30 01:18:08'),(29,13,'Bat M2',2,1,0,'p5_1_2','2016-08-30 01:18:08'),(30,13,'Bat M3',3,1,0,'p5_1_3','2016-08-30 01:18:08'),(31,13,'Uno',1,2,1,'','2016-08-30 01:18:08'),(32,13,'Dos',2,2,1,'','2016-08-30 01:18:08'),(33,13,'Tres',3,2,1,'','2016-08-30 01:18:08');
/*!40000 ALTER TABLE `cat_respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_subcampanias`
--

DROP TABLE IF EXISTS `cat_subcampanias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_subcampanias` (
  `id_sub` int(11) NOT NULL AUTO_INCREMENT,
  `id_campania` int(11) DEFAULT NULL,
  `id_estatus` int(11) DEFAULT NULL,
  `fec_alta` datetime DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_sub`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_subcampanias`
--

LOCK TABLES `cat_subcampanias` WRITE;
/*!40000 ALTER TABLE `cat_subcampanias` DISABLE KEYS */;
INSERT INTO `cat_subcampanias` VALUES (1,9,0,'2017-10-13 14:21:33','Base Encuestas'),(2,9,2,'2017-10-13 14:24:07','Sub Jorge 2'),(3,9,2,'2017-10-13 14:24:45','Otro'),(4,9,2,'2017-10-13 14:24:58','Mas dos'),(5,9,2,'2017-10-13 14:25:35','mas dos'),(6,9,2,'2017-10-13 14:45:32','BBVA'),(7,9,2,'2017-10-13 14:54:23','mas 4 2'),(8,9,2,'2017-10-13 15:14:13','Jorge'),(9,9,1,'2017-10-13 15:14:30','Dos'),(10,9,1,'2017-10-13 15:22:21','mas 6'),(11,9,1,'2017-10-13 15:22:32','mas 4');
/*!40000 ALTER TABLE `cat_subcampanias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `es_ap_usuarios`
--

DROP TABLE IF EXISTS `es_ap_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_ap_usuarios` (
  `id_estatus` int(11) NOT NULL,
  `fec_alta` datetime DEFAULT NULL,
  `estatus` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `es_ap_usuarios`
--

LOCK TABLES `es_ap_usuarios` WRITE;
/*!40000 ALTER TABLE `es_ap_usuarios` DISABLE KEYS */;
INSERT INTO `es_ap_usuarios` VALUES (1,'2017-05-25 20:52:15','Sin asignar'),(2,'2017-05-25 20:52:15','Baja temporal'),(3,'2017-05-25 20:52:15','Activo'),(4,'2017-05-25 20:52:15','En validacion'),(5,'2017-05-25 20:52:15','Eliminado');
/*!40000 ALTER TABLE `es_ap_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `es_cat_base`
--

DROP TABLE IF EXISTS `es_cat_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_cat_base` (
  `id_estatus` int(11) NOT NULL AUTO_INCREMENT,
  `name_estatus` varchar(255) DEFAULT NULL,
  `fec_add` datetime DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `es_cat_base`
--

LOCK TABLES `es_cat_base` WRITE;
/*!40000 ALTER TABLE `es_cat_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `es_cat_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `es_cat_campanias`
--

DROP TABLE IF EXISTS `es_cat_campanias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_cat_campanias` (
  `id_estatus` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `lb_class` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `es_cat_campanias`
--

LOCK TABLES `es_cat_campanias` WRITE;
/*!40000 ALTER TABLE `es_cat_campanias` DISABLE KEYS */;
INSERT INTO `es_cat_campanias` VALUES (0,'Inactivo','info'),(1,'Activo','success'),(2,'Eliminado','danger');
/*!40000 ALTER TABLE `es_cat_campanias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tp_cat_preguntas`
--

DROP TABLE IF EXISTS `tp_cat_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_cat_preguntas` (
  `tipo` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `lb_class` varchar(45) DEFAULT NULL,
  `lb_icono` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tp_cat_preguntas`
--

LOCK TABLES `tp_cat_preguntas` WRITE;
/*!40000 ALTER TABLE `tp_cat_preguntas` DISABLE KEYS */;
INSERT INTO `tp_cat_preguntas` VALUES (0,'Cuadro te Información','bg-gray','fa-align-left'),(1,'Pregunta abierta','bg-purple','fa-italic'),(2,'Escala','bg-orange','fa-sort-numeric-asc'),(3,'Opción Múltiple','bg-maroon','fa-list-ol'),(4,'Batería de Opciones','bg-teal','fa-th');
/*!40000 ALTER TABLE `tp_cat_preguntas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-13 19:51:54
