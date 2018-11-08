-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 03, 2018 at 09:59 PM
-- Server version: 5.7.21
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `detexis_soporte`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Seguridad Física'),
(2, 'Seguridad Lógica');

-- --------------------------------------------------------

--
-- Table structure for table `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `depto_nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `departamentos`
--

INSERT INTO `departamentos` (`id`, `depto_nombre`) VALUES
(1, 'Aguas, Servicios e Inversiones de México, S. de R.L. de C.V.'),
(2, 'Beatriz Escobedo Conover'),
(3, 'Biofuels de México, S.A. de C.V.'),
(4, 'CHRISTIAN MARIE BOULNOIS'),
(5, 'Cimentaciones Mexicanas, S.A. de C.V.'),
(6, 'Correo Internacional Privado, S.A. de C.V.'),
(7, 'DETEXIS'),
(8, 'Diego Nazar Jalili Pastelería, Panificadora y Confitería la Clochette, S.A. de C.V.'),
(9, 'DVA Mexicana, S.A. de C.V.'),
(10, 'Emma Rodríguez Hernández'),
(11, 'Entrepose'),
(12, 'Arrendadora Ferrer y Asociados, S.A. de C.V.'),
(13, 'Surete México, S.A. de C.V. / Grupo Guiqueaux México, S.A. de C.V.'),
(14, 'JD Finance'),
(15, 'Hegart México, S.A. de C.V.'),
(16, 'Grupo Mediatec (Alfred Rodríguez DEMO)'),
(17, 'Mejoramientos de Suelos Menard México, S.A. de C.V.'),
(18, 'Aseguradora Patria '),
(19, 'Regie T. México / Regie T. Internacional'),
(20, 'Rodolfo Martínez Reyes'),
(21, 'Saint Gobain Glass Operadora, S.A. de C.V.'),
(22, 'Société Air France'),
(23, 'SOLDATA MÉXICO'),
(24, 'TAR INTERNACIONAL'),
(25, 'TRASLADOS MEXFIVE, S.A DE C.V'),
(26, 'Grupo Herradura Occidente, S.A. de C.V.'),
(27, 'Grupo Irena'),
(28, 'Manuel Escobedo'),
(29, 'Miguel Escobedo'),
(30, 'Salvatore Ferragamo'),
(31, 'Prueba Jorge'),
(32, 'Jacques Petit');

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `id_ticket` int(11) DEFAULT NULL,
  `tms_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comentario` longtext COLLATE utf8_spanish_ci,
  `status` text COLLATE utf8_spanish_ci,
  `id_especialista` int(11) DEFAULT '0',
  `id_Usuario` int(11) DEFAULT NULL,
  `tms_cierre` timestamp NULL DEFAULT NULL,
  `id_evento_padre` int(11) DEFAULT NULL,
  `secuencia` decimal(11,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id`, `id_ticket`, `tms_creacion`, `comentario`, `status`, `id_especialista`, `id_Usuario`, `tms_cierre`, `id_evento_padre`, `secuencia`) VALUES
(1, 1, '2018-08-03 18:13:12', 'Se resolvio el problema exitosamente.\nGracias', NULL, 17, NULL, '2018-08-03 18:40:59', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `preguntas`
--

CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL,
  `pregunta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `peso` int(11) DEFAULT NULL,
  `tms_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`, `peso`, `tms_creacion`) VALUES
(1, '¿Su problema su resuelto?', 3, '2018-07-09 18:15:24'),
(3, '¿Esta satisfecho con la atención, respuesta y solución de Detexis?', 2, '2018-07-09 18:16:14'),
(4, '¿Recomendaria a un conocido los servicios de Detexis?', 1, '2018-07-09 18:17:57');

-- --------------------------------------------------------

--
-- Table structure for table `prioridad`
--

CREATE TABLE `prioridad` (
  `id` int(11) NOT NULL,
  `tiempo` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `tiempo_maximo_horas` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prioridad`
--

INSERT INTO `prioridad` (`id`, `tiempo`, `nombre`, `tiempo_maximo_horas`) VALUES
(1, '2 hrs.', 'alta', 2),
(2, '4 hrs.', 'media', 4),
(3, '8 - 24 hrs.', 'baja', 24);

-- --------------------------------------------------------

--
-- Table structure for table `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL,
  `Pregunta` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_Pregunta` int(11) DEFAULT NULL,
  `id_Ticket` int(11) DEFAULT NULL,
  `tms_creacion` timestamp NULL DEFAULT NULL,
  `tms_actualizacion` timestamp NULL DEFAULT NULL,
  `respuesta` int(11) DEFAULT '0',
  `id_Especialista` int(11) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `respuesta`
--

INSERT INTO `respuesta` (`id`, `Pregunta`, `id_Pregunta`, `id_Ticket`, `tms_creacion`, `tms_actualizacion`, `respuesta`, `id_Especialista`, `peso`) VALUES
(1, '¿Su problema su resuelto?', 1, 1, '2018-08-03 21:57:22', '2018-08-03 21:57:27', 1, 17, 3),
(2, '¿Esta satisfecho con la atención, respuesta y solución de Detexis?', 3, 1, '2018-08-03 21:57:22', '2018-08-03 21:57:29', -1, 17, 2),
(3, '¿Recomendaria a un conocido los servicios de Detexis?', 4, 1, '2018-08-03 21:57:22', '2018-08-03 21:57:30', 1, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `id_categoria`, `nombre`) VALUES
(1, 1, 'Camaras'),
(2, 1, 'Alarmas'),
(3, 1, 'GPS'),
(4, 1, 'Otro'),
(5, 2, 'Consultoria'),
(6, 2, 'Prueba de Concepto'),
(7, 2, 'Otro');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `resumen` varchar(250) DEFAULT NULL,
  `detalle` longtext,
  `id_categoria` int(11) DEFAULT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT 'abierto',
  `id_usuario` int(11) DEFAULT NULL,
  `prioridad` varchar(45) DEFAULT 'normal',
  `tms_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tms_deadline` timestamp NULL DEFAULT NULL,
  `id_especialista` int(11) DEFAULT '0',
  `depto` varchar(100) DEFAULT NULL,
  `usuario_creacion` varchar(100) DEFAULT NULL,
  `archivo` varchar(200) DEFAULT NULL,
  `causa` varchar(45) DEFAULT NULL,
  `medio` varchar(100) DEFAULT NULL,
  `estado_usuario` varchar(45) DEFAULT 'abierto',
  `estado_especialista` varchar(45) DEFAULT 'abierto',
  `reabierto` int(11) DEFAULT '0',
  `id_ticket_reabierto` int(11) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `resumen`, `detalle`, `id_categoria`, `id_subcategoria`, `estado`, `id_usuario`, `prioridad`, `tms_creacion`, `tms_deadline`, `id_especialista`, `depto`, `usuario_creacion`, `archivo`, `causa`, `medio`, `estado_usuario`, `estado_especialista`, `reabierto`, `id_ticket_reabierto`, `uuid`) VALUES
(1, 'No tengo sistema', 'Favor de dar acceso al sistema.\nGracias', 2, 6, 'cerrado', 20, 'normal', '2018-08-03 18:01:02', '2018-08-03 18:40:59', 17, 'Aguas, Servicios e Inversiones de México, S. de R.L. de C.V.', 'José Garrido', 'TransactionRecord_1530717901503.pdf', 'Falla del sistema', 'Sistema de tickets', 'abierto', 'cerrado', 0, NULL, '5b64a1bb0fd99');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `empleado` int(11) NOT NULL,
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
  `celular` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `ID_TeamViewer` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `comentario` longtext COLLATE latin1_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`empleado`, `cuenta`, `nombre`, `paterno`, `materno`, `puesto`, `mail`, `es_admin`, `activo`, `password`, `id_departamento`, `notificacion`, `ip`, `celular`, `telefono`, `ID_TeamViewer`, `comentario`) VALUES
(1, 'admin', 'Administrador del Sistema', NULL, NULL, 'Sistema', 'g.hernandez@detexis.com', 0, 1, 'admin', 7, 1, '201.149.58.78', '', '', '', 'Cuenta genérica del administrador del sistema'),
(17, 'j.salgado', 'Jorge', 'Salgado', 'Mendoza', 'Desarrollador ERP', 'j.salgado@detexis.com', 1, 1, 'Alfa1810', 7, 1, NULL, '5584674649', '52490950', 'XXX', NULL),
(18, 'm.hidalgo', 'Miguel', 'Hidalgo', 'Borraz', 'Gerente de SOC Manager', 'm.hidalgo@detexis.com', 2, 1, 'm.hidalgo', 7, 1, NULL, '5513667016', '52490950', '', NULL),
(19, 'jm.martinez', 'Juan', 'Manuel', '', 'Investigación y Desarrollo', 'jm.martinez', 3, 1, 'jm.martinez', 7, 1, NULL, '5529546604', '', '', NULL),
(20, 'jgarrido', 'José', 'Garrido', '', 'Contacto de Seguridad', 'salgado.jm.91@gmail.com', 0, 1, 'Alfa1810', 1, 1, NULL, '', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id_subcategoria_id_idx` (`id_categoria`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_categorias_id_idx` (`id_categoria`),
  ADD KEY `fk_tickets_id_subcategoria_idx` (`id_subcategoria`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`empleado`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
