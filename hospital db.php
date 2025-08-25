-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2025 a las 02:02:33
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
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `id_paciente`, `id_doctor`, `fecha`, `hora`) VALUES
(8, 8, 4, '2024-09-17', '19:21:00'),
(9, 8, 3, '2024-11-22', '10:57:00'),
(10, 10, 12, '2024-12-04', '16:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`id`, `nombre`, `especialidad`, `created_at`) VALUES
(1, 'Arturo Marquez', 'Ginecólogo', '2024-09-05 23:19:25'),
(3, 'Elias  Obregon', 'Nutriólogo', '2024-09-06 00:56:24'),
(4, 'Ernesto Vasquez', 'Pediatra ', '2024-11-14 00:08:58'),
(5, 'Alexis Ibarra', 'Urólogo ', '2024-11-14 00:12:33'),
(6, 'Gorge Villalobos', 'Cardiólogo', '2024-11-14 00:13:06'),
(7, 'Esmeralda Rico', 'Neuróloga', '2024-11-14 00:13:40'),
(8, 'Ignacio Segovia ', 'Dermatólogo ', '2024-11-14 00:14:10'),
(9, 'Yahir Guadalupe Rodríguez Vázquez  ', ' Radiólogo ', '2024-11-14 00:15:48'),
(10, 'José Arnulfo Miravalle De La Torre ', 'Psicólogo ', '2024-11-14 00:17:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_alta` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `fecha_ingreso`, `fecha_alta`, `created_at`) VALUES
(4, 'Andres Flores', '2024-09-05', '2024-09-21', '2024-09-06 00:14:40'),
(8, 'hector martinez', '2024-11-13', '2024-11-22', '2024-11-13 23:57:19'),
(9, 'Osvaldo Martinez', '2024-11-13', '2024-11-23', '2024-11-14 00:05:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'eherca0502', '$2y$10$E5byo19bYuk9JYeh8TPTIOSF2H5S43xx5Y.Zijit1JMERtmbIBJdu', '2024-09-05 23:14:24'),
(2, 'Ketzy', '$2y$10$FHNqvSEnaLXl4r9CJxd9zOSLKmcBBNkk8zOXRydPNoy.gn/v3rJtm', '2024-09-06 00:05:22'),
(3, 'ehc554', '$2y$10$1ADP5jqYcA/pgT8MzLhsLOfrLH2Vw8jA5kIl3IoxXgX6/SUMJeVky', '2024-11-13 23:53:02'),
(4, 'christian', '$2y$10$SQUQYH1XZ7chDcjKzCcVd.jCVUIAyjr7MpqbEaNgyKz5Ql70Nh/NW', '2024-11-19 23:25:14'),
(5, 'MAAURI666', '$2y$10$ZFYf6RO10UwK1mTVlYaZnOkIlfJ0XlWJF6wFXW42cjjiACSqx2zua', '2024-11-28 00:36:07'),
(6, 'Homero', '$2y$10$2V3AdZYmqb/USBMOqkrfFe55SNV0FiwStBdj5g7SoV2tlcmgvadSm', '2024-12-04 01:45:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_doctor` (`id_doctor`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;