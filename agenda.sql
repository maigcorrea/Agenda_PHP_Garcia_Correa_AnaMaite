-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2025 a las 16:33:29
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigo`
--

CREATE TABLE `amigo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `f_nac` date NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `amigo`
--

INSERT INTO `amigo` (`id`, `nombre`, `apellidos`, `f_nac`, `usuario`) VALUES
(1, 'Pachito', 'Rodrï¿½guez', '2002-01-15', 2),
(2, 'Manuel', 'Castillo', '2004-05-09', 4),
(3, 'Jaled', 'no se', '2001-09-12', 2),
(4, 'asfd', 'crfeg', '2025-01-16', 1),
(5, 't45t', 'gers5t', '2025-01-08', 1),
(6, 'Juande', 'no me acuerdo', '2025-01-08', 1),
(19, 'Manu', 'Romero', '2025-01-01', 1),
(20, 'Dani', 'MartÃ­n', '2025-01-02', 3),
(21, 'Dani', 'MartÃ­n', '2025-01-02', 3),
(22, 'Dani', 'MartÃ­n', '2025-01-02', 3),
(23, 'Ale', 'cdrswgf', '2025-01-17', 1),
(24, 't45t', 'gers5t', '2025-02-06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `plataforma` varchar(100) NOT NULL,
  `lanzamiento` int(4) NOT NULL,
  `img` varchar(450) NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`id`, `titulo`, `plataforma`, `lanzamiento`, `img`, `usuario`) VALUES
(1, 'Goat Simulator', 'PC', 2018, '../img/Erica/202211181651421_1.jpg', 1),
(2, 'MineCraft', 'PC', 2009, 'luego', 4),
(3, 'WOW', 'PC', 2004, '../img/Erica/wallpaper_world_of_warcraft_wrath_of_the_lich_king_classic_01_1920x1080.jpg', 1),
(5, 'Fortnite1', 'PC', 2025, '../img/Erica/2x1_Fortnite_Generic_image1600w.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL,
  `amigo` bigint(20) UNSIGNED NOT NULL,
  `juego` bigint(20) UNSIGNED NOT NULL,
  `f_prestamo` date NOT NULL,
  `devuelto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id`, `usuario`, `amigo`, `juego`, `f_prestamo`, `devuelto`) VALUES
(1, 1, 1, 1, '2025-01-01', 1),
(2, 1, 3, 3, '2025-01-08', 1),
(3, 1, 1, 3, '2025-01-14', 1),
(4, 1, 1, 3, '2025-01-21', 1),
(5, 1, 3, 1, '2025-01-08', 1),
(6, 1, 6, 3, '2025-01-21', 0),
(7, 1, 4, 3, '2025-01-28', 0),
(8, 1, 4, 3, '2020-03-04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `tipo` set('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contrasenia`, `tipo`) VALUES
(1, 'Erica', 'hola123', 'usuario'),
(2, 'Maite', 'hola123', 'usuario'),
(3, 'Redu', 'hola123', 'usuario'),
(4, 'Fran', 'Morales', 'usuario'),
(5, 'admin', 'admin', 'admin'),
(10, 'Pepa Pig', 'holaMundo', 'usuario'),
(11, 'ayuda', 'hola', 'usuario'),
(12, '0', 'puto', 'usuario'),
(13, 'hola', 'puto', 'usuario'),
(14, 'hola', 'puto', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_amigo_usuario` (`usuario`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_juego_usuario` (`usuario`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_prestamo_usuario` (`usuario`),
  ADD KEY `fk_prestamo_amigo` (`amigo`),
  ADD KEY `fk_prestamo_juego` (`juego`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigo`
--
ALTER TABLE `amigo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD CONSTRAINT `fk_amigo_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juego`
--
ALTER TABLE `juego`
  ADD CONSTRAINT `fk_juego_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_prestamo_amigo` FOREIGN KEY (`amigo`) REFERENCES `amigo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_juego` FOREIGN KEY (`juego`) REFERENCES `juego` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
