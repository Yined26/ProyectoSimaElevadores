-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2024 a las 16:17:48
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
-- Base de datos: `elevadores`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `ID` int(11) NOT NULL,
  `CONTRASENA` text DEFAULT NULL,
  `NOMBRE` text DEFAULT NULL,
  `CELULAR` text DEFAULT NULL,
  `ESTADO` text DEFAULT NULL,
  `CORREO` varchar(50) DEFAULT NULL,
  `FOTO` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`ID`, `CONTRASENA`, `NOMBRE`, `CELULAR`, `ESTADO`, `CORREO`, `FOTO`) VALUES
(1, '123', 'Brayan Andres Martinez Lemos', '3211234567', 'Calle falsa 123 #45-67 Sur', 'Bosa', 'default.jpg'),
(2, '123', 'juan marquez', '301225', NULL, NULL, 'default.jpg'),
(3, 'abc456', 'Ana Maria Torres', '3006547890', 'Carrera 45 #67-89 Norte', 'ana.torres@example.com', 'foto3.jpg'),
(4, 'def789', 'Carlos Martinez', '3109876543', 'Avenida 22 #34-56 Este', 'carlos.martinez@example.com', 'foto4.jpg'),
(5, '3', 'daniela', '12', NULL, NULL, ''),
(6, 'u', 'u', '1', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados_laborales`
--

CREATE TABLE `certificados_laborales` (
  `ID_CL` int(11) NOT NULL,
  `ID_Colaborador` int(11) NOT NULL,
  `FECHA_INGRESO_C` date NOT NULL,
  `ESTADO_ACTUAL_C` varchar(11) NOT NULL,
  `FECHA_RETIRO_C` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificados_laborales`
--

INSERT INTO `certificados_laborales` (`ID_CL`, `ID_Colaborador`, `FECHA_INGRESO_C`, `ESTADO_ACTUAL_C`, `FECHA_RETIRO_C`) VALUES
(1, 1, '2023-01-15', 'Activo', '2023-12-31'),
(2, 2, '2022-05-20', 'Activo', '2024-05-20'),
(3, 3, '2021-03-10', 'Activo', '2023-06-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaboradores`
--

CREATE TABLE `colaboradores` (
  `ID` int(11) NOT NULL,
  `Contrasena` varchar(12) NOT NULL,
  `NOMBRE` text DEFAULT NULL,
  `CELULAR` text DEFAULT NULL,
  `CORREO` varchar(50) DEFAULT NULL,
  `CC` varchar(50) NOT NULL,
  `RH` varchar(15) NOT NULL,
  `CARGO` varchar(20) NOT NULL,
  `ESTADO_ACTUAL` varchar(11) NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `FECHA_INGRESO` date DEFAULT NULL,
  `FECHA_RETIRO` date DEFAULT NULL,
  `salario_base` int(50) NOT NULL,
  `bonificacion` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colaboradores`
--

INSERT INTO `colaboradores` (`ID`, `Contrasena`, `NOMBRE`, `CELULAR`, `CORREO`, `CC`, `RH`, `CARGO`, `ESTADO_ACTUAL`, `FECHA_NACIMIENTO`, `FECHA_INGRESO`, `FECHA_RETIRO`, `salario_base`, `bonificacion`) VALUES
(1, '1234', 'John Doe', '0000000000', 'user1@gmail.com', '123123123', 'AB+', 'Developer', 'Activo', '1990-01-01', '2023-01-01', NULL, 50000, 5000),
(2, '123', 'Jane Smith', '1112223333', 'user2@gmail.com', '1010221417', 'O+', 'Manager', 'Activo', '1985-05-15', '2022-06-01', NULL, 60000, 6000),
(3, '123', 'Alice Johnson', '2223334444', 'user3@gmail.com', '222', 'B-', 'Analyst', 'Inactivo', '1992-07-20', '2024-02-01', '2024-06-13', 55000, 5500),
(4, '123', 'Robert Brown', '3334445555', 'user4@gmail.com', '1010221417', 'AB-', 'Consultant', 'Active', '1980-11-11', '2021-08-01', NULL, 70000, 7000),
(5, '123', 'Emily Davis', '4445556666', 'user5@gmail.com', '1010', 'A+', 'HR Specialist', 'Active', '1988-09-09', '2023-03-01', NULL, 65000, 6500),
(6, '123', 'Michael Wilson', '5556667777', 'user6@gmail.com', '1010', 'O-', 'Sales Manager', 'Active', '1975-12-12', '2020-01-01', NULL, 75000, 7500),
(7, '456def', 'Luis Fernando Pérez', '3219876543', 'user7@gmail.com', '3030303030', 'A+', 'Consultor', 'Activo', '1985-07-22', '2023-01-01', NULL, 2200, 300),
(8, '789ghi', 'Sara Gómez', '3201234567', 'user8@gmail.com', '4040404040', 'B+', 'Analista', 'Activo', '1990-09-15', '2024-06-01', NULL, 2500, 400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante`
--

CREATE TABLE `comprobante` (
  `ID_Comprobante` int(50) NOT NULL,
  `ID_Colaborador` int(11) NOT NULL,
  `Salario_Base` int(50) NOT NULL,
  `bonificacion` int(50) NOT NULL,
  `Descuentos_Salud` int(11) NOT NULL,
  `Descuentos_Pension` int(11) NOT NULL,
  `Descuentos_Incapacidad` int(11) NOT NULL,
  `ID_A` int(50) NOT NULL,
  `Periodo_Pago` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprobante`
--

INSERT INTO `comprobante` (`ID_Comprobante`, `ID_Colaborador`, `Salario_Base`, `bonificacion`, `Descuentos_Salud`, `Descuentos_Pension`, `Descuentos_Incapacidad`, `ID_A`, `Periodo_Pago`) VALUES
(10, 1, 2000000, 300000, 100000, 80000, 50000, 1, '2024-08'),
(11, 2, 2500000, 500000, 120000, 90000, 40000, 2, '2024-08'),
(12, 3, 1800000, 250000, 90000, 70000, 60000, 3, '2024-08'),
(13, 4, 2200000, 350000, 110000, 85000, 30000, 4, '2024-08'),
(14, 5, 2400000, 400000, 115000, 88000, 20000, 5, '2024-08'),
(15, 6, 2100000, 320000, 105000, 82000, 45000, 6, '2024-08'),
(16, 7, 2300000, 370000, 112000, 87000, 25000, 7, '2024-08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `image`) VALUES
(1, 'johndoe', 'john_doe.jpg'),
(2, 'janesmith', 'jane_smith.jpg'),
(3, 'alicejohnson', 'alice_johnson.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones`
--

CREATE TABLE `vacaciones` (
  `ID` int(11) NOT NULL,
  `ID_C` int(11) NOT NULL,
  `dias_pendientes` int(25) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `total_dias` int(11) NOT NULL,
  `vacaciones_acumuladas` int(11) NOT NULL,
  `Estado` enum('Pendiente','Aprobado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `Fecha_Solicitud` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacaciones`
--

INSERT INTO `vacaciones` (`ID`, `ID_C`, `dias_pendientes`, `fecha_inicio`, `total_dias`, `vacaciones_acumuladas`, `Estado`, `Fecha_Solicitud`) VALUES
(1, 1, 15, '2024-06-01', 20240615, 15, 'Pendiente', '2024-08-30'),
(2, 2, 10, '2024-07-01', 20240710, 10, 'Pendiente', '2024-08-30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `certificados_laborales`
--
ALTER TABLE `certificados_laborales`
  ADD PRIMARY KEY (`ID_CL`),
  ADD KEY `ID_Colaborador` (`ID_Colaborador`);

--
-- Indices de la tabla `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD PRIMARY KEY (`ID_Comprobante`),
  ADD KEY `ID_Colaborador` (`ID_Colaborador`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vacaciones`
--
ALTER TABLE `vacaciones`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `certificados_laborales`
--
ALTER TABLE `certificados_laborales`
  MODIFY `ID_CL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `comprobante`
--
ALTER TABLE `comprobante`
  MODIFY `ID_Comprobante` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `certificados_laborales`
--
ALTER TABLE `certificados_laborales`
  ADD CONSTRAINT `certificados_laborales_ibfk_1` FOREIGN KEY (`ID_Colaborador`) REFERENCES `colaboradores` (`ID`);

--
-- Filtros para la tabla `comprobante`
--
ALTER TABLE `comprobante`
  ADD CONSTRAINT `comprobante_ibfk_1` FOREIGN KEY (`ID_Colaborador`) REFERENCES `colaboradores` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
