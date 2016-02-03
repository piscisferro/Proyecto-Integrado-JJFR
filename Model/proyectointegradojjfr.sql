-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
<<<<<<< HEAD
-- Tiempo de generación: 03-02-2016 a las 11:58:35
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3
=======
-- Tiempo de generación: 02-02-2016 a las 21:26:42
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12
>>>>>>> origin/master

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `proyectointegradojjfr`
--
CREATE DATABASE IF NOT EXISTS `proyectointegradojjfr` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `proyectointegradojjfr`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebida`
--

CREATE TABLE IF NOT EXISTS `bebida` (
`id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
<<<<<<< HEAD
  `fecha` date NOT NULL,
  `imagen` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
=======
  `fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
>>>>>>> origin/master

--
-- Volcado de datos para la tabla `bebida`
--

<<<<<<< HEAD
INSERT INTO `bebida` (`id`, `nombre`, `precio`, `cantidad`, `fecha`, `imagen`) VALUES
(1, 'Coca Cola', 1.3, 33, '2016-02-01', ''),
(3, 'Pepsi-Cola', 1.3, 33, '2016-02-02', ''),
(6, 'Fanta de Naranja', 1.3, 20, '2016-02-02', ''),
(7, 'Caña', 1, 20, '2016-02-03', '../View/images/img1454494729.'),
(8, 'Cerveza Cruzcampo', 1.3, 33, '2016-02-03', '../View/images/img1454494753.');
=======
INSERT INTO `bebida` (`id`, `nombre`, `precio`, `cantidad`, `fecha`) VALUES
(1, 'Coca Cola', 1.3, 33, '2016-02-01'),
(3, 'Pepsi-Cola', 1.3, 33, '2016-02-02'),
(6, 'Fanta de Naranja', 1.3, 20, '2016-02-02'),
(7, 'Caña', 1, 20, '2016-02-02'),
(8, 'Cerveza Cruzcampo', 1.3, 33, '2016-02-02');
>>>>>>> origin/master

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comida`
--

CREATE TABLE IF NOT EXISTS `comida` (
`id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `precio` float NOT NULL,
  `ingredientes` varchar(150) COLLATE utf8_bin NOT NULL,
<<<<<<< HEAD
  `fecha` date NOT NULL,
  `imagen` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
=======
  `fecha` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
>>>>>>> origin/master

--
-- Volcado de datos para la tabla `comida`
--

<<<<<<< HEAD
INSERT INTO `comida` (`id`, `nombre`, `precio`, `ingredientes`, `fecha`, `imagen`) VALUES
(1, 'Hamburguesa con Queso', 2.35, 'Hamburguesa de buey, queso, lechuga, cebolla y tomate', '2016-02-01', ''),
(2, 'Campero de Pollo', 3.2, 'Pollo, Queso, Jamon de York, Lechuga y Tomate', '2016-02-03', '../View/images/img1454496017.jpeg'),
(3, 'Pitufo Mixto', 1.5, 'Jamon de York, Queso, Mantequilla', '2016-02-02', ''),
(4, 'Campero de Atun', 3.2, 'Atun, Queso, Jamon de York, Lechuga, Tomate, Mayonesa', '2016-02-03', '../View/images/img1454495458.jpeg'),
(6, 'Gambas al pilpil', 2, 'Gambas, salsa pil pil', '2016-02-03', '');
=======
INSERT INTO `comida` (`id`, `nombre`, `precio`, `ingredientes`, `fecha`) VALUES
(1, 'Hamburguesa con Queso', 2.35, 'Hamburguesa de buey, queso, lechuga, cebolla y tomate', '2016-02-01'),
(2, 'Campero de Pollo', 3.2, 'Pollo, Queso, Jamon de York, Lechuga y Tomate', '2016-02-02'),
(3, 'Pitufo Mixto', 1.5, 'Jamon de York, Queso, Mantequilla', '2016-02-02'),
(4, 'Campero de Atun', 3.2, 'Atun, Queso, Jamon de York, Lechuga, Tomate, Mayonesa', '2016-02-02');
>>>>>>> origin/master

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bebida`
--
ALTER TABLE `bebida`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comida`
--
ALTER TABLE `comida`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bebida`
--
ALTER TABLE `bebida`
<<<<<<< HEAD
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
>>>>>>> origin/master
--
-- AUTO_INCREMENT de la tabla `comida`
--
ALTER TABLE `comida`
<<<<<<< HEAD
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
>>>>>>> origin/master
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
