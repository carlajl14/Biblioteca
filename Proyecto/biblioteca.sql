-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2023 a las 16:46:48
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
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bibliotecas`
--

CREATE TABLE `bibliotecas` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Telefono` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bibliotecas`
--

INSERT INTO `bibliotecas` (`Id`, `Nombre`, `Direccion`, `Telefono`) VALUES
(1, 'Biblioteca Niveiro Alfar El Carmen', 'Pi. San Andrés, 6, 45600 Talavera de la Reina', 925812908),
(2, 'Biblioteca Pública Municipal José Hierro', 'Av. Toledo, 37, 45600 Talavera de la Reina', 925813454),
(3, 'Biblioteca de Talavera de la Reina (UCLM)', 'Avda, Av. Real Fábrica de Sedas, s/n,45600 Talavera de la Reina', 925194714),
(4, 'Biblioteca Pública Municipal de Talavera la Nueva', 'Rda. Sol, 0 s/n, 45694 Talavera la Nueva', 925850369);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(100) NOT NULL,
  `Autor` varchar(50) NOT NULL,
  `Editorial` varchar(100) DEFAULT NULL,
  `ISBN` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`Id`, `Titulo`, `Autor`, `Editorial`, `ISBN`) VALUES
(1, 'Las hijas de las criadas', 'Sonsoles Onega', 'PLANETA', 9788408280170),
(2, 'La sangre del padre', 'Alfonso Goizueta', 'PLANETA', 9788408280187),
(3, 'El problema final', 'Arturo Perez Reverte', 'ALFAGUARA', 9788420476360),
(4, 'La armadura de la luz', 'Ken Follett', 'PLAZA & JANE EDITORES', 9788401030130),
(5, 'Le dedico mi silencio', 'Mario Vargas Llosa', 'ALFAGUARA', 9788420476599),
(6, 'El cuco de cristal', 'Javier Castillo', 'SUMA', 9788491293552),
(7, 'Te di ojos y mirastes las tinieblas', 'Irene Sola Saez', 'ANAGRAMA', 9788433906281),
(8, 'Lecciones de quimica', 'Bonnie Garmus', 'SALAMANDRA', 9788418363436),
(9, 'Los misterios de la taberna Kamogawa', 'Hisashi Kashiwai', 'SALAMANDRA', 9788419346025),
(10, 'La clase de griego', 'Han Kang', 'LITERATURA RANDOM HOUSE', 9788439741817),
(11, 'Delito', 'Carme Chaparro', 'ESPASA LIBROS', 9788467068702),
(12, 'Tasmania', 'Paolo Giordano', 'TUSQUETS EDITORES', 9788411073295);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_bibliotecas`
--

CREATE TABLE `libros_bibliotecas` (
  `Id_libro` int(3) NOT NULL,
  `Id_biblioteca` int(3) NOT NULL,
  `Disponibilidad` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_bibliotecas`
--

INSERT INTO `libros_bibliotecas` (`Id_libro`, `Id_biblioteca`, `Disponibilidad`) VALUES
(1, 4, 200),
(3, 1, 57),
(3, 2, 105),
(5, 3, 442),
(5, 4, 759),
(6, 3, 178),
(8, 2, 274),
(9, 1, 125),
(10, 2, 20),
(10, 4, 423);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Contraseña` varchar(200) NOT NULL,
  `Rol` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Nombre`, `Contraseña`, `Rol`) VALUES
(1, 'Sheila', 'd56c8b4a39f60d541d982fa579322c9a48697f09', 1),
(2, 'Carla', '5f126c5742546995c30f56bb6b1916d768624929', 1),
(3, 'Alba', 'f045489c5d2cffca1d4d892c5f61e6e1f8a8e524', 1),
(4, 'Luismi', '70f106fd19de33baf34bc6866b5f76c9b5803978', 1),
(5, 'Pepe', '8d78fb402a331bdfecab3033c902fd469c33d3d7', 0),
(6, 'Rosa', '2c0d557df1c97d2febfed7de875d344d6f4a1625', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bibliotecas`
--
ALTER TABLE `bibliotecas`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `libros_bibliotecas`
--
ALTER TABLE `libros_bibliotecas`
  ADD PRIMARY KEY (`Id_libro`,`Id_biblioteca`),
  ADD KEY `BI_ID_FK` (`Id_biblioteca`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bibliotecas`
--
ALTER TABLE `bibliotecas`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libros_bibliotecas`
--
ALTER TABLE `libros_bibliotecas`
  ADD CONSTRAINT `BI_ID_FK` FOREIGN KEY (`Id_biblioteca`) REFERENCES `bibliotecas` (`Id`),
  ADD CONSTRAINT `LI_ID_FK` FOREIGN KEY (`Id_libro`) REFERENCES `libros` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
