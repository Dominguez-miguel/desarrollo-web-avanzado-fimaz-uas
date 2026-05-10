-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 10-05-2026 a las 08:21:01
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
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `id` int(11) NOT NULL,
  `nombreTorneo` varchar(40) NOT NULL,
  `organizador` varchar(40) NOT NULL,
  `patrocinadores` varchar(255) NOT NULL,
  `sede` varchar(50) NOT NULL,
  `categoria` varchar(40) NOT NULL,
  `premio1` int(11) NOT NULL,
  `premio2` int(11) NOT NULL,
  `premio3` int(11) NOT NULL,
  `otroPremio` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`id`, `nombreTorneo`, `organizador`, `patrocinadores`, `sede`, `categoria`, `premio1`, `premio2`, `premio3`, `otroPremio`, `usuario`, `contrasena`) VALUES
(2, 'Liga MX', 'ASDF', '   Nike ', 'CDMX', 'Juvenil', 1000112, 500123, 20012, 100123, 'miguel', 'asdfg'),
(5, 'Liga Peru', 'ASD', 'Nike', 'Lima', 'Juvenil', 2222, 222, 22, 223, 'miguel', 'asdfg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
