-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: fepla_crm
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `clase` varchar(10) NOT NULL,
  `apellido1` varchar(255) DEFAULT NULL,
  `apellido2` varchar(255) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_profesor_alumno` (`profesor_id`),
  CONSTRAINT `fk_profesor_alumno` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` VALUES (23,'',NULL,NULL,'2DAM',NULL,NULL,8),(24,'Angel','angebuigues@gmail.com','123456789','2DAM','Buigues','',8),(25,'Atteneri','AtteneriLaMejor@gmail.com','123456789','2DAM','Cimadevilla','',8),(26,'Adrianee Madeley Lee','meGustaPegarAIvan@gmail.com','123456789','2DAM','Navas','BriceÃ±o',8);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asignaciones`
--

DROP TABLE IF EXISTS `asignaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `fk_profesor_asignacion` (`profesor_id`),
  CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `fk_profesor_asignacion` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaciones`
--

LOCK TABLES `asignaciones` WRITE;
/*!40000 ALTER TABLE `asignaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `asignaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactos_empresas`
--

DROP TABLE IF EXISTS `contactos_empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  CONSTRAINT `contactos_empresas_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactos_empresas`
--

LOCK TABLES `contactos_empresas` WRITE;
/*!40000 ALTER TABLE `contactos_empresas` DISABLE KEYS */;
INSERT INTO `contactos_empresas` VALUES (4,'123','123@123','123',NULL,0),(5,'1','1234@1231','123',NULL,1);
/*!40000 ALTER TABLE `contactos_empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('interesada','no_interesada','ya_no_existe') DEFAULT 'interesada',
  `creado_por` int(11) NOT NULL,
  `modificado_por` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nombre_oficial` varchar(255) DEFAULT NULL,
  `direccion_sede_central` varchar(255) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `provincia` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `correo_electronico_principal` varchar(255) DEFAULT NULL,
  `actividad_principal` text DEFAULT NULL,
  `otras_actividades` text DEFAULT NULL,
  `descripcion_breve` text DEFAULT NULL,
  `contacto_principal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contacto_principal` (`contacto_principal`),
  CONSTRAINT `FK_contacto_principal` FOREIGN KEY (`contacto_principal`) REFERENCES `contactos_empresas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresas`
--

LOCK TABLES `empresas` WRITE;
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` VALUES (7,'12341s','','','ya_no_existe',8,8,'2024-12-16 22:09:18','2024-12-16 23:09:07','12341s','123441s','12341s','12341s','41231s','https://www.cocacola.es4134s','cocacolaEnElBronx@gmail.com4121s','s12341s','12341s','12341s',4),(8,'JordiSLd',NULL,NULL,'interesada',8,NULL,'2024-12-16 22:09:56','2024-12-16 22:09:56','','','','','','','123@fd','','','',4);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_empresas`
--

DROP TABLE IF EXISTS `log_empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `accion` longtext NOT NULL,
  `datos_anteriores` longtext DEFAULT NULL,
  `datos_nuevos` longtext DEFAULT NULL,
  `explicado_por` text DEFAULT NULL,
  `realizado_por` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `realizado_por` (`realizado_por`),
  CONSTRAINT `log_empresas_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `log_empresas_ibfk_2` FOREIGN KEY (`realizado_por`) REFERENCES `profesores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_empresas`
--

LOCK TABLES `log_empresas` WRITE;
/*!40000 ALTER TABLE `log_empresas` DISABLE KEYS */;
INSERT INTO `log_empresas` VALUES (9,7,'','Nombre: 123, Contacto: 4, Email: , TelÃ©fono: , Estado: ya_no_existe','Nombre: 123, Contacto: 4, Email: , TelÃ©fono: , Estado: ya_no_existe','123',8,'2024-12-16 22:23:41'),(10,7,'Cambio de estado','Nombre: 123, Contacto: 4, Email: , TelÃ©fono: , Estado: ya_no_existe','Nombre: 123, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada','123',8,'2024-12-16 22:23:55'),(11,7,'Cambio de nombre','Nombre: 123, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada','12',8,'2024-12-16 22:24:59'),(12,7,'Cambio de direcciÃ³n sede central','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 123, DirecciÃ³n Sede Central: 123, PoblaciÃ³n: 123, CÃ³digo Postal: 123, Provincia: 123, Web: https://www.cocacola.es, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com, Actividad Principal: 123, Otras Actividades: 123, DescripciÃ³n Breve: 123','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 123, DirecciÃ³n Sede Central: 1234, PoblaciÃ³n: 123, CÃ³digo Postal: 123, Provincia: 123, Web: https://www.cocacola.es, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com, Actividad Principal: 123, Otras Actividades: 123, DescripciÃ³n Breve: 123','4',8,'2024-12-16 22:31:35'),(13,7,'Cambio de estado, Cambio de nombre oficial, Cambio de direcciÃ³n sede central, Cambio de poblaciÃ³n, Cambio de cÃ³digo postal, Cambio de provincia, Cambio de pÃ¡gina web, Cambio de correo electrÃ³nico principal, Cambio de actividad principal, Cambio de otras actividades, Cambio de descripciÃ³n breve','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 123, DirecciÃ³n Sede Central: 1234, PoblaciÃ³n: 123, CÃ³digo Postal: 123, Provincia: 123, Web: https://www.cocacola.es, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com, Actividad Principal: 123, Otras Actividades: 123, DescripciÃ³n Breve: 123','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: interesada, Nombre Oficial: 1234, DirecciÃ³n Sede Central: 12344, PoblaciÃ³n: 1234, CÃ³digo Postal: 1234, Provincia: 4123, Web: https://www.cocacola.es4, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4, Actividad Principal: 1234, Otras Actividades: 1234, DescripciÃ³n Breve: 1234','4',8,'2024-12-16 22:31:46'),(14,7,'Cambio de nombre, Cambio de estado, Cambio de nombre oficial, Cambio de direcciÃ³n sede central, Cambio de poblaciÃ³n, Cambio de cÃ³digo postal, Cambio de provincia, Cambio de pÃ¡gina web, Cambio de correo electrÃ³nico principal, Cambio de actividad principal, Cambio de otras actividades, Cambio de descripciÃ³n breve','Nombre: 1234, Contacto: 4, Email: , TelÃ©fono: , Estado: interesada, Nombre Oficial: 1234, DirecciÃ³n Sede Central: 12344, PoblaciÃ³n: 1234, CÃ³digo Postal: 1234, Provincia: 4123, Web: https://www.cocacola.es4, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4, Actividad Principal: 1234, Otras Actividades: 1234, DescripciÃ³n Breve: 1234','Nombre: 12341, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es41, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com41, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','123',8,'2024-12-16 22:39:13'),(15,7,'Cambio de contacto principal','Nombre: 12341, Contacto: 4, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es41, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com41, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','Nombre: 12341, Contacto: 5, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es41, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com41, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','12',8,'2024-12-16 22:39:34'),(16,7,'Cambio de pÃ¡gina web, Cambio de correo electrÃ³nico principal','Nombre: 12341, Contacto: 5, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es41, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com41, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','Nombre: 12341, Contacto: 5, Email: , TelÃ©fono: , Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es4134, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4121, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','g',8,'2024-12-16 22:50:28'),(17,7,'Cambio de nombre, Cambio de contacto principal, Cambio de estado, Cambio de nombre oficial, Cambio de direcciÃ³n sede central, Cambio de poblaciÃ³n, Cambio de cÃ³digo postal, Cambio de provincia, Cambio de pÃ¡gina web, Cambio de correo electrÃ³nico principal, Cambio de actividad principal, Cambio de otras actividades, Cambio de descripciÃ³n breve','Nombre: 12341, Contacto: 5, Estado: no_interesada, Nombre Oficial: 12341, DirecciÃ³n Sede Central: 123441, PoblaciÃ³n: 12341, CÃ³digo Postal: 12341, Provincia: 41231, Web: https://www.cocacola.es4134, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4121, Actividad Principal: 12341, Otras Actividades: 12341, DescripciÃ³n Breve: 12341','Nombre: 12341s, Contacto: 4, Estado: interesada, Nombre Oficial: 12341s, DirecciÃ³n Sede Central: 123441s, PoblaciÃ³n: 12341s, CÃ³digo Postal: 12341s, Provincia: 41231s, Web: https://www.cocacola.es4134s, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4121s, Actividad Principal: s12341s, Otras Actividades: 12341s, DescripciÃ³n Breve: 12341s','ss',8,'2024-12-16 23:01:03'),(18,7,'','Nombre: 12341s, Contacto: 4, Estado: ya_no_existe, Nombre Oficial: 12341s, DirecciÃ³n Sede Central: 123441s, PoblaciÃ³n: 12341s, CÃ³digo Postal: 12341s, Provincia: 41231s, Web: https://www.cocacola.es4134s, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4121s, Actividad Principal: s12341s, Otras Actividades: 12341s, DescripciÃ³n Breve: 12341s','Nombre: 12341s, Contacto: 4, Estado: ya_no_existe, Nombre Oficial: 12341s, DirecciÃ³n Sede Central: 123441s, PoblaciÃ³n: 12341s, CÃ³digo Postal: 12341s, Provincia: 41231s, Web: https://www.cocacola.es4134s, Correo ElectrÃ³nico Principal: cocacolaEnElBronx@gmail.com4121s, Actividad Principal: s12341s, Otras Actividades: 12341s, DescripciÃ³n Breve: 12341s','dsadsa',8,'2024-12-16 23:09:15');
/*!40000 ALTER TABLE `log_empresas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `apellido1` varchar(255) DEFAULT NULL,
  `apellido2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (3,'Pepe','pedroandreu@gmail.com','$2y$10$aD/Fb3o6zG3GIy2Ti/AcmuPrnkIEBq.RfB3OQloSYerfE7DjjQOR6','holalaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','Pastor','Pastor'),(7,'Luisss','luisitosantapola@gmail.com','$2y$10$IQEhtEYfRBVnAt2argl2.eJEqeoXjVrNylwyRLVevIkTfLmEbKRKa','123','gsoncalvess','gsoncalvess'),(8,'Pedro','pedroandreu12@gmail.com','$2y$10$mnozTgqbxX.MU3BFoshGcudiey9fCcjUiUlUCpANPMivjubDTHrnC','','Andreu','Campello');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `superusuarios`
--

DROP TABLE IF EXISTS `superusuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `superusuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `superusuarios`
--

LOCK TABLES `superusuarios` WRITE;
/*!40000 ALTER TABLE `superusuarios` DISABLE KEYS */;
INSERT INTO `superusuarios` VALUES (1,'pedroandreu@feplacrm.es','Pedro','Andreu','Campello','$2y$10$7gF6znl.PoJ/v0Q/FzWN7.DZnsAmTkdiENhBNZ6TaEeSCmOnQwG3S','2024-11-20 17:01:11');
/*!40000 ALTER TABLE `superusuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fepla_crm'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-17 12:34:25
