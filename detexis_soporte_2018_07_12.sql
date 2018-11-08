-- MySQL dump 10.13  Distrib 5.6.38, for osx10.9 (x86_64)
--
-- Host: localhost    Database: detexis_soporte
-- ------------------------------------------------------
-- Server version	5.6.38

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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Seguridad Física'),(2,'Seguridad Lógica');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depto_nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'Aguas, Servicios e Inversiones de México, S. de R.L. de C.V.'),(2,'Beatriz Escobedo Conover'),(3,'Biofuels de México, S.A. de C.V.'),(4,'CHRISTIAN MARIE BOULNOIS'),(5,'Cimentaciones Mexicanas, S.A. de C.V.'),(6,'Correo Internacional Privado, S.A. de C.V.'),(7,'DETEXIS'),(8,'Diego Nazar Jalili Pastelería, Panificadora y Confitería la Clochette, S.A. de C.V.'),(9,'DVA Mexicana, S.A. de C.V.'),(10,'Emma Rodríguez Hernández'),(11,'Entrepose'),(12,'Arrendadora Ferrer y Asociados, S.A. de C.V.'),(13,'Surete México, S.A. de C.V. / Grupo Guiqueaux México, S.A. de C.V.'),(14,'JD Finance'),(15,'Hegart México, S.A. de C.V.'),(16,'Grupo Mediatec (Alfred Rodríguez DEMO)'),(17,'Mejoramientos de Suelos Menard México, S.A. de C.V.'),(18,'Aseguradora Patria '),(19,'Regie T. México / Regie T. Internacional'),(20,'Rodolfo Martínez Reyes'),(21,'Saint Gobain Glass Operadora, S.A. de C.V.'),(22,'Société Air France'),(23,'SOLDATA MÉXICO'),(24,'TAR INTERNACIONAL'),(25,'TRASLADOS MEXFIVE, S.A DE C.V'),(26,'Grupo Herradura Occidente, S.A. de C.V.'),(27,'Grupo Irena'),(28,'Manuel Escobedo'),(29,'Miguel Escobedo'),(30,'Salvatore Ferragamo'),(31,'Prueba Jorge'),(32,'Jacques Petit');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ticket` int(11) NOT NULL,
  `tms_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comentario` longtext COLLATE utf8_spanish_ci,
  `status` text COLLATE utf8_spanish_ci,
  `id_especialista` int(11) DEFAULT '0',
  `id_Usuario` int(11) NOT NULL,
  `tms_cierre` timestamp NULL DEFAULT NULL,
  `id_evento_padre` int(11) DEFAULT NULL,
  `secuencia` decimal(11,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,1,'2018-07-06 18:22:58','Se revisarón cada uña de las flotas y funciona correctamente! . ¿tÀL vez a fernando Juarez le falto informar al cliente oportunamente.\nSaludos.',NULL,14,0,'2018-07-06 18:54:42',NULL,1),(2,2,'2018-07-09 17:55:12','Se restablecio la conexion a l proxy.\nSe soluciono correctamente.',NULL,3,0,'2018-07-09 17:56:52',NULL,1),(3,3,'2018-07-10 15:44:37',NULL,NULL,14,0,NULL,NULL,1);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_servicio`
--

DROP TABLE IF EXISTS `nivel_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivel_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_especialista` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_nivel_servicio_especialistas_idx` (`id_especialista`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_servicio`
--

LOCK TABLES `nivel_servicio` WRITE;
/*!40000 ALTER TABLE `nivel_servicio` DISABLE KEYS */;
INSERT INTO `nivel_servicio` VALUES (1,2,'Primer nivel'),(2,3,'Primer nivel'),(3,4,'Primer nivel'),(4,6,'Segundo nivel'),(5,7,'Segundo nivel'),(6,1,'Tercer nivel'),(7,5,'Tercer nivel');
/*!40000 ALTER TABLE `nivel_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ruta` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (8,'Registrar Nuevos Tickets','imagenes/nuevo.png'),(9,'Buscar Tickets','imagenes/buscar.png'),(12,'Actualizar Tickets','imagenes/actualizar.png'),(14,'Abrir Tickets Cerrados',NULL),(17,'Agregar Categorias',NULL),(18,'Eliminar Categorias',NULL),(19,'Ejecutar Reportes',NULL),(20,'Administrar Usuarios perfiles',NULL);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `peso` int(11) NOT NULL,
  `tms_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` VALUES (1,'¿Su problema su resuelto?',3,'2018-07-09 18:15:24'),(3,'¿Esta satisfecho con la atención, respuesta y solución de Detexis?',2,'2018-07-09 18:16:14'),(4,'¿Recomendaria a un conocido los servicios de Detexis?',1,'2018-07-09 18:17:57');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prioridad`
--

DROP TABLE IF EXISTS `prioridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prioridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tiempo` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tiempo_maximo_horas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prioridad`
--

LOCK TABLES `prioridad` WRITE;
/*!40000 ALTER TABLE `prioridad` DISABLE KEYS */;
INSERT INTO `prioridad` VALUES (1,'2 hrs.','alta',2),(2,'4 hrs.','media',4),(3,'8 - 24 hrs.','baja',24);
/*!40000 ALTER TABLE `prioridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuesta`
--

DROP TABLE IF EXISTS `respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Pregunta` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_Pregunta` int(11) NOT NULL,
  `id_Ticket` int(11) NOT NULL,
  `tms_creacion` timestamp NULL DEFAULT NULL,
  `tms_actualizacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `respuesta` int(11) NOT NULL,
  `id_Especialista` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuesta`
--

LOCK TABLES `respuesta` WRITE;
/*!40000 ALTER TABLE `respuesta` DISABLE KEYS */;
INSERT INTO `respuesta` VALUES (1,'¿Su problema su resuelto?',1,1,'2018-07-11 16:39:52','2018-07-12 16:40:21',1,14,3),(2,'¿Esta satisfecho con la atención, respuesta y solución de Detexis?',3,1,'2018-07-10 16:39:52','2018-07-12 17:18:09',1,14,2),(3,'¿Recomendaria a un conocido los servicios de Detexis?',4,1,'2018-07-12 16:39:52','2018-07-12 17:18:13',1,14,1),(4,'¿Su problema su resuelto?',1,2,'2018-07-12 18:13:12','2018-07-12 18:13:15',1,3,3),(5,'¿Esta satisfecho con la atención, respuesta y solución de Detexis?',3,2,'2018-07-12 18:13:12','2018-07-12 18:13:20',1,3,2),(6,'¿Recomendaria a un conocido los servicios de Detexis?',4,2,'2018-07-12 18:13:12','2018-07-12 18:13:22',-1,3,1);
/*!40000 ALTER TABLE `respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subareas`
--

DROP TABLE IF EXISTS `subareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_area` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_subarea_id_idx` (`id_area`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subareas`
--

LOCK TABLES `subareas` WRITE;
/*!40000 ALTER TABLE `subareas` DISABLE KEYS */;
INSERT INTO `subareas` VALUES (1,1,'Pólizas'),(2,1,'Balanza'),(3,1,'Relación de Saldos'),(4,1,'Gastos por centro de costos'),(5,1,'Auxiliares'),(6,1,'Póliza fluctuación'),(7,1,'Póliza perdida o ganancia'),(8,1,'Contabilidad Electrónica'),(9,1,'Reporte corte por póliza'),(10,1,'Divisas'),(11,1,'Proveedores'),(12,1,'Catalogo de Cuentas'),(13,2,'Requisiciones'),(14,2,'Cotizaciones'),(15,2,'Ordenes de compra'),(16,2,'Requisiciones compra directa'),(17,2,'Catalogo de artículos'),(18,2,'Catalogo de proveedores'),(19,3,'Entrada de almacén'),(20,3,'Salida de almacén'),(21,3,'Reporte salidas de almacén'),(22,3,'Reporte entradas de almacén'),(23,3,'Reporte auxiliares de almacén'),(24,3,'Reporte consumos de almacén'),(25,3,'Reporte inv. Teorico vs Fisico'),(26,3,'Nivel de inventario (punto de re orden)'),(27,3,'Reporte existencia por lote'),(28,3,'Captura inventario fisico'),(29,4,'Programación de pagos'),(30,4,'Relación de cheques'),(31,4,'Consulta de cheques'),(32,4,'Modificación CxP'),(33,4,'Consulta CxP'),(34,4,'Cancelación de cheque'),(35,4,'Protección de cheque'),(36,5,'Relación de cheques'),(37,5,'Consulta cheque'),(38,5,'Reembolso'),(39,6,'Liquidación de Ruta'),(40,6,'Reporte de cobranza'),(41,6,'Cartera historica'),(42,6,'Diario de venta'),(43,6,'Reporte de cobranza (Depo y Cob)'),(44,6,'Relación de facturas por ruta'),(45,6,'Consulta queja de producto'),(46,6,'Reporte notas de crédito'),(47,6,'Compensación 1 cuenta'),(48,6,'Compensación 1 a varias cuentas');
/*!40000 ALTER TABLE `subareas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategorias`
--

DROP TABLE IF EXISTS `subcategorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_subcategoria_id_idx` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategorias`
--

LOCK TABLES `subcategorias` WRITE;
/*!40000 ALTER TABLE `subcategorias` DISABLE KEYS */;
INSERT INTO `subcategorias` VALUES (1,1,'Camaras'),(2,1,'Alarmas'),(3,1,'GPS'),(4,1,'Otro'),(5,2,'Consultoria'),(6,2,'Prueba de Concepto'),(7,2,'Otro');
/*!40000 ALTER TABLE `subcategorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resumen` varchar(250) NOT NULL,
  `detalle` longtext,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL DEFAULT 'abierto',
  `id_usuario` int(11) NOT NULL,
  `prioridad` varchar(45) NOT NULL DEFAULT 'normal',
  `tms_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tms_deadline` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_especialista` int(11) DEFAULT '0',
  `depto` varchar(100) DEFAULT NULL,
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `archivo` varchar(200) DEFAULT NULL,
  `causa` varchar(45) DEFAULT NULL,
  `medio` varchar(100) DEFAULT NULL,
  `estado_usuario` varchar(45) NOT NULL DEFAULT 'abierto',
  `estado_especialista` varchar(45) DEFAULT 'abierto',
  `reabierto` int(11) DEFAULT '0',
  `id_ticket_reabierto` int(11) DEFAULT NULL,
  `uuid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_categorias_id_idx` (`id_categoria`),
  KEY `fk_tickets_id_subcategoria_idx` (`id_subcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'La unidad registrada con el no. 284UXM no reporta','Favor de corregir la asignacion de la flota la unidad ...\nPrueba Prueba de plataforma con signaos de puntaciòn ! Nélia. Nèlia.\nGracias\n\nSaludos.!!!@',2,6,'cerrado',11,'normal','2018-07-06 15:15:01','2018-07-11 17:16:45',14,'Saint Gobain Glass Operadora, S.A. de C.V.','Silvestre Herrera','Untitled.xlsx','Falla del usuario','Sistema de tickets','abierto','cerrado',0,NULL,'5b463b7dcacf7'),(2,'La flota Pruebas no reporta','Favor de informarme cuando la flota Ü´--?!!1¿¿¡¡*++\"#\nAl correo pruebas@prueba.null\n\nGracias ! @@',1,3,'cerrado',10,'normal','2018-07-07 15:22:51','2018-07-12 18:12:37',3,'Saint Gobain Glass Operadora, S.A. de C.V.','Evangelina Cazares','Captura de pantalla 2018-07-03 a la(s) 16.50.43.png','Falla en comunicaciones','Sistema de tickets','abierto','cerrado',0,NULL,'5b479a15c3e1e'),(3,'No tengo acceso a la poc Info security','favor de recordarme el acceso a la prueba de concepto.\nGracias\nPorfavor a la siguiente adjuntar imagenes. 3',2,5,'abierto',11,'media','2018-07-10 14:54:38','0000-00-00 00:00:00',14,'Saint Gobain Glass Operadora, S.A. de C.V.','Silvestre Herrera',' ','Desconocido','Sistema de tickets','abierto','abierto',0,NULL,'');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `empleado` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `paterno` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `materno` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `puesto` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `mail` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `es_admin` int(11) DEFAULT '0',
  `activo` int(11) DEFAULT '1',
  `password` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `notificacion` int(11) DEFAULT '1',
  `ip` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `celular` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `telefono` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ID_TeamViewer` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `comentario` longtext COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`empleado`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','Administrador del Sistema',NULL,NULL,'Sistema','g.hernandez@detexis.com',0,1,'admin',7,1,'201.149.58.78','','','','Cuenta genérica del administrador del sistema'),(2,'j.salgado','Jorge','Salgado','Mendoza','Programador Sistemas','j.salgado@detexis.com',2,1,'j.salgado',7,1,'201.149.58.78','5584674649','','tm',''),(3,'m.hidalgo','Miguel','Hidalgo','Y costilla','Soc Manager','m.hidalgo@detexis.com',1,1,'m.hidalgo',7,1,'201.149.58.78','5513667016','','','Profesional con mas de 2 años de experiencia en seguridad informática, 1 año en Mattica primer laboratorio forense en américa latina y actualmente realizando , implementación, configuración y administración de controles de seguridad en un SOC . Trabajo en equipo y bajo presión, autodidacta'),(4,'s.reyes','Sonia','Reyes',NULL,'Supervisor de Monitoreo','s.reyes@detexis.com',3,1,'s.reyes',7,1,'201.149.58.78','5534195136','','',''),(5,'m.lopez','Maria','Lopez',' ','Consultor ciber','m.lopez@detexis.com',0,1,'m.lopez',7,1,NULL,'5583350240','52490950 ext ciber','0100',''),(6,'n.carrasco','Nélia','Carrasco','Serena','Servicio al Cliente','n.carrasco@detexis.com',0,1,'n.carrasco',7,1,NULL,'5559171134','52490960 5278','0111',''),(7,'j.petit','Jacques','Petit','','Direccion','j.petit@detexis.com',0,1,'j.petit',7,1,NULL,'5520958582','52490950','0101',''),(8,'f.coste','Frédéric','Coste','','Direccion Cyber','f.coste@detexis.com',0,1,'f.coste',7,1,NULL,'5529546604','52490950','0102',''),(9,'c.boulnois','Christian','Boulnois','','Jefe de Seguridad','salgado.jm.91@gmail.com',0,1,'c.boulnois',21,1,NULL,'5584674649','','',''),(10,'e.cazares','Evangelina','Cazares','','Asistente','g.hernandez@detexis.com',0,1,'e.cazares',21,1,NULL,'','','',''),(11,'silvestre','Silvestre','Herrera','','Direccion de RH','tendroidventa@gmail.com',0,1,'silvestre',21,1,NULL,'5539245354','','',''),(12,'quiroz','eduardo','quiroz','','jefe de seguridad','g.hernandez@detexis.com',0,1,'quiroz',5,1,NULL,'','','',''),(13,'maldonado','oscar','maldonado','morales','desconocido','s.franco@detexis.com',0,1,'maldonado',5,1,NULL,'','','',''),(14,'g.hernandez','Guadalupe','Hernandez','Hernandez','Desarrollador Sr','g.hernandez@detexis.com',0,1,'g.hernandez',7,1,NULL,'5539245354','52490950 ext desarrollo','Desarrollo','Implementing security controls to protect client\'s System Information: This 3-years project aims to evaluate the current status of client\'s System Information to detect how vulnerable is using black-box, gray-box and white-box pentesting to later implement different kinds of security controls such as Web Application Firewall(WAF), Intrusion Detection Systems(IDS) and other kinds of controls to ensure the integrity of critical servers and databases. On the other hand such project involves to protect personal information of CEO and directives making use of different crypto-tools to protect the information contained into their devices and their emails.');
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

-- Dump completed on 2018-07-12 16:09:44
