-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-08-2025 a las 01:28:35
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
-- Base de datos: `satya`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `id_coach` int(11) NOT NULL,
  `hora_inicio` varchar(200) NOT NULL,
  `hora_fin` varchar(200) NOT NULL,
  `aforo` int(11) NOT NULL,
  `reservados` int(11) NOT NULL DEFAULT 0,
  `id_disciplina` int(11) NOT NULL,
  `estatus` varchar(2) DEFAULT '1',
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coaches`
--

CREATE TABLE `coaches` (
  `id` int(11) NOT NULL,
  `nombre_coach` varchar(255) NOT NULL,
  `descripcion_coach` text NOT NULL,
  `id_disciplina` int(11) DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_vencidos`
--

CREATE TABLE `creditos_vencidos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creditos_vencidos` varchar(200) DEFAULT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  `fecha_procesado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplinas`
--

CREATE TABLE `disciplinas` (
  `id` int(11) NOT NULL,
  `nombre_disciplina` varchar(255) NOT NULL,
  `descripcion_disciplina` text NOT NULL,
  `subdescripcion_texto1` varchar(20) DEFAULT NULL,
  `subdescripcion_texto2` varchar(20) DEFAULT NULL,
  `subdescripcion_texto3` varchar(20) DEFAULT NULL,
  `id_coach` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egr`
--

CREATE TABLE `egr` (
  `id` int(11) NOT NULL,
  `fecha` varchar(220) NOT NULL,
  `concepto` varchar(220) NOT NULL,
  `tipo` varchar(220) NOT NULL,
  `monto` varchar(220) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `clases` varchar(255) DEFAULT NULL,
  `costo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `vigencia` varchar(100) DEFAULT NULL,
  `invitados` varchar(255) DEFAULT NULL,
  `persona` varchar(2) DEFAULT NULL,
  `descuento` varchar(200) DEFAULT NULL,
  `finalizadsc` varchar(200) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `clases`, `costo`, `nombre`, `vigencia`, `invitados`, `persona`, `descuento`, `finalizadsc`, `fecha`) VALUES
(1, '8', '859', 'Movement', '30', '0', '1', NULL, NULL, '2025-08-12 17:08:48'),
(2, '12', '1129', 'Movement', '30', '0', '1', NULL, NULL, '2025-08-12 17:09:15'),
(3, 'ILIMITADO', '1449', 'Movement', '30', '0', '1', NULL, NULL, '2025-08-12 17:09:50'),
(4, 'ANUALIDAD', '16999', 'Movement', '365', '0', '1', NULL, NULL, '2025-08-12 17:10:19'),
(5, '8', '999', 'Pilates Reformer', '30', '0', '1', NULL, NULL, '2025-08-12 17:10:49'),
(6, '12', '1299', 'Pilates Reformer', '30', '0', '1', NULL, NULL, '2025-08-12 17:11:17'),
(7, 'ILIMITADO', '1599', 'Pilates Reformer', '30', '0', '1', NULL, NULL, '2025-08-12 17:12:13'),
(8, 'ANUALIDAD', '17999', 'Pilates Reformer', '365', '0', '1', NULL, NULL, '2025-08-12 17:12:13'),
(9, '8', '1129', 'Mixto', '30', '0', '1', NULL, NULL, '2025-08-12 17:13:32'),
(10, '12', '1479', 'Mixto', '30', '0', '1', NULL, NULL, '2025-08-12 17:13:32'),
(11, 'ILIMITADO', '1799', 'Mixto', '30', '0', '1', NULL, NULL, '2025-08-12 17:14:16'),
(12, 'ANUALIDAD', '20999', 'Mixto', '365', '0', '1', NULL, NULL, '2025-08-12 17:14:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id` int(11) NOT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `idClase` varchar(255) DEFAULT NULL,
  `alumno` varchar(255) DEFAULT NULL,
  `dura` varchar(255) DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `idInstructor` varchar(2) DEFAULT NULL,
  `invitado` varchar(255) DEFAULT '0',
  `activo` varchar(255) DEFAULT NULL,
  `asiste` varchar(20) DEFAULT NULL,
  `inicio` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `fechaReserva` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `monto` varchar(255) DEFAULT NULL,
  `creditos` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `metodo` varchar(255) DEFAULT NULL,
  `idpago` varchar(255) DEFAULT NULL,
  `mrecibido` varchar(255) DEFAULT NULL,
  `fecha` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `iduser` varchar(255) DEFAULT NULL,
  `tipoUser` varchar(10) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `fecha_nacimiento` varchar(220) DEFAULT NULL,
  `credit` varchar(255) DEFAULT NULL,
  `venceCredit` varchar(20) DEFAULT NULL,
  `fechaCredit` varchar(100) DEFAULT NULL,
  `maxInvitados` varchar(10) DEFAULT NULL,
  `claseBienvenida` varchar(2) DEFAULT NULL,
  `tlogin` varchar(6) DEFAULT NULL,
  `dlogin` varchar(100) DEFAULT NULL,
  `statu` varchar(255) DEFAULT NULL,
  `idpago` varchar(255) DEFAULT NULL,
  `montoPagado` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `activo` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_cards`
--

CREATE TABLE `user_cards` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) NOT NULL,
  `card_id` varchar(255) DEFAULT NULL,
  `last_four_digits` varchar(4) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `card_type` varchar(20) NOT NULL COMMENT 'credit, debit, etc',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditos_vencidos`
--
ALTER TABLE `creditos_vencidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `egr`
--
ALTER TABLE `egr`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `creditos_vencidos`
--
ALTER TABLE `creditos_vencidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disciplinas`
--
ALTER TABLE `disciplinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `egr`
--
ALTER TABLE `egr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
