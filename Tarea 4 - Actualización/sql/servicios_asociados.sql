-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2025 a las 23:26:07
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servicios_asociados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `nombre_apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `servicio_interes` varchar(100) NOT NULL,
  `documento` longblob DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `acepto_privacidad` tinyint(1) NOT NULL,
  `fecha_consulta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id_consulta`, `nombre_apellido`, `email`, `telefono`, `servicio_interes`, `documento`, `mensaje`, `acepto_privacidad`, `fecha_consulta`) VALUES
(1, 'w', 'castelli.agustina@gmail.com', '01151656514', 'Asistencia Legal', NULL, 'rrr', 1, '2025-08-26 19:04:18'),
(2, 'w', 'castelli.agustina@gmail.com', '01151656514', 'Armado de muebles', NULL, 'y', 1, '2025-08-26 19:05:16'),
(3, 'w', 'castelli.agustina@gmail.com', '01151656514', 'Plomería', NULL, 'f', 1, '2025-08-26 19:30:42'),
(4, 'w', '0@w.com', '', 'Plomería', NULL, '0', 1, '2025-08-26 19:34:18'),
(5, 'w', 'castelli.agustina@gmail.com', '01151656514', 'Mascotas', NULL, 'e', 1, '2025-08-26 20:18:55'),
(6, 'w', 'agustina.castelli@bue.edu.ar', 'e', 'Asistencia Informática', NULL, '´´', 1, '2025-08-26 20:30:27'),
(7, 'é', 'castelli.agustina@gmail.com', '01151656514', 'Asistencia Informática', NULL, 'e', 1, '2025-08-26 20:31:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_archivo`
--

CREATE TABLE `consulta_archivo` (
  `id` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `mime` varchar(100) NOT NULL,
  `tamano_bytes` int(10) UNSIGNED NOT NULL,
  `sha256` char(64) NOT NULL,
  `ruta_storage` varchar(512) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_archivo`
--

INSERT INTO `consulta_archivo` (`id`, `id_consulta`, `nombre_original`, `mime`, `tamano_bytes`, `sha256`, `ruta_storage`, `created_at`) VALUES
(1, 5, 'SOCKET  - Enviar y recibir texto entre cliente y servidor.pdf', 'application/pdf', 109715, 'b73488093d88276dc8b7e9d6cc99699791aef55f9e9b6f4a16d79cd870d9117c', '/uploads/2025/08/f44d6898a133b6b485d4815461cb9728.pdf', '2025-08-26 20:18:55'),
(2, 6, 'SOCKET  - Enviar y recibir texto entre cliente y servidor.pdf', 'application/pdf', 109715, 'b73488093d88276dc8b7e9d6cc99699791aef55f9e9b6f4a16d79cd870d9117c', '/uploads/2025/08/b6f1350c8a47bf6d9acf3a2405991b29.pdf', '2025-08-26 20:30:27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `consulta_archivo`
--
ALTER TABLE `consulta_archivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_consulta` (`id_consulta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consulta_archivo`
--
ALTER TABLE `consulta_archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consulta_archivo`
--
ALTER TABLE `consulta_archivo`
  ADD CONSTRAINT `fk_consulta_archivo` FOREIGN KEY (`id_consulta`) REFERENCES `consulta` (`id_consulta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
