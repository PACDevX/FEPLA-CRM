-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2024 a las 16:07:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fepla_crm`
--
CREATE DATABASE IF NOT EXISTS `fepla_crm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fepla_crm`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
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
  KEY `fk_profesor_alumno` (`profesor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `nombre`, `email`, `telefono`, `clase`, `apellido1`, `apellido2`, `profesor_id`) VALUES
(17, '', NULL, NULL, '1DAM', NULL, NULL, 8),
(18, 'Pedro', 'pedroandreu@gmail.com', '1234', '2DAM', 'dsa', 'ddasa', 8),
(19, '', NULL, NULL, '2DAM', NULL, NULL, 8),
(20, '', NULL, NULL, '1ESO', NULL, NULL, 8),
(22, 'Pedro', 'pedroandreu@feplacrm.es', '1234', '2DAM', 'Andreu', 'Landa', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

DROP TABLE IF EXISTS `asignaciones`;
CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alumno_id` (`alumno_id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `fk_profesor_asignacion` (`profesor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `alumno_id`, `empresa_id`, `profesor_id`) VALUES
(6, 18, 4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `contacto_principal` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `contacto_principal`, `email`, `telefono`) VALUES
(2, 'JordiSLDD', 'Jordi Manareldd', '1@1asd', '6157das'),
(3, 'JordiSL', 'Jordi', 'jordigormiti@gmail.com', '123'),
(4, 'The CocaCola Company', 'Àngel Buigues', 'cocacola@gmail.es', '123456789'),
(5, 'Pedro', 'Jordi Manarel', 'pedroandreu12@gmail.com', '615712965a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

DROP TABLE IF EXISTS `profesores`;
CREATE TABLE IF NOT EXISTS `profesores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `email`, `password`, `apellido`, `descripcion`) VALUES
(3, 'Pepe', 'pedroandreu@gmail.com', '$2y$10$aD/Fb3o6zG3GIy2Ti/AcmuPrnkIEBq.RfB3OQloSYerfE7DjjQOR6', 'Pastor', 'holalaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(7, 'Luisss', 'luisitosantapola@gmail.com', '$2y$10$IQEhtEYfRBVnAt2argl2.eJEqeoXjVrNylwyRLVevIkTfLmEbKRKa', 'gsoncalvess', '123'),
(8, 'Pedro', 'pedroandreu12@gmail.com', '$2y$10$mnozTgqbxX.MU3BFoshGcudiey9fCcjUiUlUCpANPMivjubDTHrnC', 'Andreu', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `superusuarios`
--

DROP TABLE IF EXISTS `superusuarios`;
CREATE TABLE IF NOT EXISTS `superusuarios` (
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

--
-- Volcado de datos para la tabla `superusuarios`
--

INSERT INTO `superusuarios` (`id`, `email`, `nombre`, `apellido1`, `apellido2`, `password`, `fecha_creacion`) VALUES
(1, 'pedroandreu@feplacrm.es', 'Pedro', 'Andreu', 'Campello', '$2y$10$7gF6znl.PoJ/v0Q/FzWN7.DZnsAmTkdiENhBNZ6TaEeSCmOnQwG3S', '2024-11-20 18:01:11');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `fk_profesor_alumno` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  ADD CONSTRAINT `fk_profesor_asignacion` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
