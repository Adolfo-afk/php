-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 13-03-2025 a las 09:46:07
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
-- Base de datos: `faunacompleja`
--
drop database if exists faunacompleja;
create database faunacompleja;
use faunacompleja;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentacion`
--

CREATE TABLE `alimentacion` (
  `id_alimentacion` int(11) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `tipo_alimento` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alimentacion`
--

INSERT INTO `alimentacion` (`id_alimentacion`, `id_especie`, `tipo_alimento`, `descripcion`) VALUES
(1, 1, 'Carnívoro', 'Se alimenta de ciervos y jabalíes'),
(2, 2, 'Carnívoro', 'Caza pequeños mamíferos y aves'),
(3, 3, 'Carnívoro', 'Principalmente focas'),
(4, 4, 'Carnívoro', 'Consume ciervos y alces'),
(5, 5, 'Herbívoro', 'Come frutas y semillas de la selva'),
(6, 6, 'Herbívoro', 'Se alimenta de bambú');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especies`
--

CREATE TABLE `especies` (
  `id_especie` int(11) NOT NULL,
  `nombre_comun` varchar(100) NOT NULL,
  `nombre_cientifico` varchar(150) NOT NULL,
  `familia` varchar(100) DEFAULT NULL,
  `clase` varchar(50) DEFAULT NULL,
  `orden` varchar(50) DEFAULT NULL,
  `estado_conservacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especies`
--

INSERT INTO `especies` (`id_especie`, `nombre_comun`, `nombre_cientifico`, `familia`, `clase`, `orden`, `estado_conservacion`) VALUES
(1, 'Tigre de Bengala', 'Panthera tigris tigris', 'Felidae', 'Mammalia', 'Carnivora', 'En peligro'),
(2, 'Águila Real', 'Aquila chrysaetos', 'Accipitridae', 'Aves', 'Accipitriformes', 'Preocupación menor'),
(3, 'Oso Polar', 'Ursus maritimus', 'Ursidae', 'Mammalia', 'Carnivora', 'Vulnerable'),
(4, 'Lobo Gris', 'Canis lupus', 'Canidae', 'Mammalia', 'Carnivora', 'Casi amenazado'),
(5, 'Guacamayo Azul', 'Anodorhynchus hyacinthinus', 'Psittacidae', 'Aves', 'Psittaciformes', 'En peligro'),
(6, 'Panda Gigante', 'Ailuropoda melanoleuca', 'Ursidae', 'Mammalia', 'Carnivora', 'Vulnerable'),
(7, 'Colibrí Esmeralda', 'Chlorostilbon mellisugus', 'Trochilidae', 'Aves', 'Apodiformes', 'Preocupación menor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitats`
--

CREATE TABLE `habitats` (
  `id_habitat` int(11) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitats`
--

INSERT INTO `habitats` (`id_habitat`, `id_especie`, `nombre`, `tipo`, `ubicacion`) VALUES
(1, 1, 'Selva Tropical', 'Bosque', 'Amazonas'),
(2, 2, 'Montañas Rocosas', 'Montaña', 'América del Norte'),
(3, 3, 'Ártico', 'Polar', 'Círculo Polar Ártico'),
(4, 4, 'Sabana Africana', 'Sabana', 'África'),
(5, 5, 'Bosque Mediterráneo', 'Bosque', 'Europa'),
(6, 6, 'Bosque de Bambú', 'Bosque', 'China'),
(7, 7, 'Jardín Tropical', 'Jardín', 'Costa Rica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `id_region` int(11) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `pais` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id_region`, `id_especie`, `nombre`, `pais`) VALUES
(1, 1, 'Amazonas', 'Brasil'),
(2, 2, 'Yosemite', 'Estados Unidos'),
(3, 3, 'Groenlandia', 'Dinamarca'),
(4, 4, 'Serengeti', 'Tanzania'),
(5, 5, 'Andalucía', 'España'),
(6, 6, 'Sichuan', 'China'),
(7, 7, 'Monteverde', 'Costa Rica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `rol`) VALUES
(1, 'adolfo', '$2y$10$0Uc3jJxRy0GZNJOyaw.miezbTftK9YF5MB8Ft/Otd10omfVDes5ta', 'usuario'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(3, 'guille', '63b4f252da3eb0e674b7298aeee97d9b', ''),
(4, 'adolfo4', '94061038e32584971223e244eb1d3c13', 'admin'),
(5, 'a', '0cc175b9c0f1b6a831c399e269772661', 'usuario'),
(6, 'toni', 'aefe34008e63f1eb205dc4c4b8322253', 'admin'),
(7, 'b', '7b8b965ad4bca0e41ab51de7b31363a1', 'usuario'),
(8, 'd', '8277e0910d750195b448797616e091ad', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
  ADD PRIMARY KEY (`id_alimentacion`),
  ADD KEY `id_especie` (`id_especie`);

--
-- Indices de la tabla `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`id_especie`);

--
-- Indices de la tabla `habitats`
--
ALTER TABLE `habitats`
  ADD PRIMARY KEY (`id_habitat`),
  ADD KEY `id_especie` (`id_especie`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`id_region`),
  ADD KEY `id_especie` (`id_especie`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
  MODIFY `id_alimentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especies`
--
ALTER TABLE `especies`
  MODIFY `id_especie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id_habitat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `id_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimentacion`
--
ALTER TABLE `alimentacion`
  ADD CONSTRAINT `alimentacion_ibfk_1` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id_especie`);

--
-- Filtros para la tabla `habitats`
--
ALTER TABLE `habitats`
  ADD CONSTRAINT `habitats_ibfk_1` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id_especie`);

--
-- Filtros para la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD CONSTRAINT `regiones_ibfk_1` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id_especie`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
