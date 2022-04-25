-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-03-2022 a las 18:26:26
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pedidoslab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins_permissions`
--

CREATE TABLE `admins_permissions` (
  `permission_id` tinyint(3) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_login_fail`
--

CREATE TABLE `auth_login_fail` (
  `log_id` int(11) NOT NULL COMMENT 'id del acceso. autonumerico',
  `username` varchar(50) DEFAULT NULL COMMENT 'nombre de usuario usado.',
  `password` varchar(75) DEFAULT NULL COMMENT 'motivo por el que no pudo acceder',
  `reason` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL COMMENT 'fecha del acceso',
  `time` time DEFAULT NULL COMMENT 'hora del acceso.',
  `user_agent` text COMMENT 'informacion sobre el navegador del cliente',
  `ip` varchar(50) DEFAULT NULL COMMENT 'ip del usuario.'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tabla que contiene los intentos de acceso ilegales.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_login_success`
--

CREATE TABLE `auth_login_success` (
  `log_id` int(11) NOT NULL COMMENT 'id del acceso. autonumerico',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL COMMENT 'fecha del acceso',
  `time` time DEFAULT NULL COMMENT 'hora del acceso.',
  `user_agent` text COMMENT 'informacion sobre el navegador del cliente',
  `ip` varchar(50) DEFAULT NULL COMMENT 'ip del usuario.'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='tabla que contiene los intentos de acceso ilegales.';

--
-- Volcado de datos para la tabla `auth_login_success`
--

INSERT INTO `auth_login_success` (`log_id`, `user_id`, `date`, `time`, `user_agent`, `ip`) VALUES
(122, 1, '2022-03-03', '16:45:12', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', '127.0.0.1'),
(123, 1, '2022-03-17', '18:25:38', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_acciones`
--

CREATE TABLE `log_acciones` (
  `log_id` int(7) NOT NULL,
  `user_id` int(6) NOT NULL,
  `controlador` varchar(150) NOT NULL DEFAULT '',
  `objeto` varchar(10) NOT NULL DEFAULT '',
  `concepto` varchar(150) NOT NULL DEFAULT '',
  `tabla` varchar(150) NOT NULL DEFAULT '',
  `texto` text NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `log_acciones`
--

INSERT INTO `log_acciones` (`log_id`, `user_id`, `controlador`, `objeto`, `concepto`, `tabla`, `texto`, `create_time`) VALUES
(1, 1, 'contactosweb editContacto', '', 'Se ha editado el contacto: 4', 'Contacto web', 'Array\n(\n    [idcontactoWeb] => 4\n    [tipo] => 0\n    [nombre] => Edwin Rojas\n    [email] => rojaedwin@gmail.com\n    [telefono] => 637018839\n    [comentarios] => mi mensaje de prueba\n    [leido] => 1\n    [leido_by] => 1\n    [fecha] => 2021-03-07 21:02:05\n    [fechaLeido] => 2021-08-31 03:36:50\n    [establecido] => 0\n)\n', '2021-08-31 01:36:58'),
(2, 1, 'contactosweb deleteContacto', '', 'Se ha eliminado el contacto: 4', 'contactos web', 'Array\n(\n    [idcontactoWeb] => 4\n    [tipo] => 0\n    [nombre] => Edwin Rojas\n    [email] => rojaedwin@gmail.com\n    [telefono] => 637018839\n    [comentarios] => mi mensaje de pruebas\n    [leido] => 1\n    [leido_by] => 1\n    [fecha] => 2021-03-07 21:02:05\n    [fechaLeido] => 2021-08-31 03:36:50\n    [establecido] => 0\n)\n', '2021-08-31 01:37:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_dni` varchar(10) NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_avatar` varchar(255) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_phone` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_imagen` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_fecha_nacimiento` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_sexo` varchar(10) NOT NULL,
  `user_monedero` decimal(7,2) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_codigo_postal` varchar(15) NOT NULL,
  `user_localidad` varchar(10) NOT NULL,
  `user_id_provincia` int(10) NOT NULL,
  `user_club` varchar(100) NOT NULL,
  `user_menor` varchar(100) NOT NULL,
  `user_dni_tutor` varchar(100) NOT NULL,
  `user_nombre_tutor` varchar(100) NOT NULL,
  `user_nacionalidad` int(4) NOT NULL,
  `user_about` varchar(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `user_type` tinyint(1) NOT NULL DEFAULT '1',
  `user_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_borrado` tinyint(4) NOT NULL DEFAULT '0',
  `user_pwd` varchar(255) NOT NULL,
  `user_pwd_old` varchar(255) NOT NULL,
  `user_pwd_token` varchar(255) NOT NULL,
  `user_selectorvalidator` varchar(255) DEFAULT NULL,
  `user_hashedvalidator` varchar(255) DEFAULT NULL,
  `user_created_by` tinyint(1) NOT NULL DEFAULT '0',
  `user_create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_pwd_seed` varchar(255) DEFAULT NULL,
  `user_pwd_seed_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_dni`, `user_email`, `user_avatar`, `user_name`, `user_lastname`, `user_phone`, `user_imagen`, `user_fecha_nacimiento`, `user_sexo`, `user_monedero`, `user_address`, `user_codigo_postal`, `user_localidad`, `user_id_provincia`, `user_club`, `user_menor`, `user_dni_tutor`, `user_nombre_tutor`, `user_nacionalidad`, `user_about`, `user_type`, `user_active`, `user_borrado`, `user_pwd`, `user_pwd_old`, `user_pwd_token`, `user_selectorvalidator`, `user_hashedvalidator`, `user_created_by`, `user_create_time`, `user_pwd_seed`, `user_pwd_seed_time`) VALUES
(1, '', 'admin@pedidoslab.com', '', 'admin', '', '', '', '', '', '0.00', '', '', '', 0, '', '', '', '', 0, '', 0, 1, 0, '$2y$10$uoSR3IIR397CC2JTo5HZRuE8x5Gz79ktNsEs9KHUluyDm3j0SaVmm', '', '', '1:DnNY&@2086', '$2y$10$At9ybkBSeYKo5iU2NxMLWeyrXOQGnCuFvfkTVZshjnf2dCX/dntuu', 0, '2020-02-17 07:11:57', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins_permissions`
--
ALTER TABLE `admins_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`);

--
-- Indices de la tabla `auth_login_fail`
--
ALTER TABLE `auth_login_fail`
  ADD KEY `log_id` (`log_id`);

--
-- Indices de la tabla `auth_login_success`
--
ALTER TABLE `auth_login_success`
  ADD KEY `log_id` (`log_id`);

--
-- Indices de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auth_login_fail`
--
ALTER TABLE `auth_login_fail`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del acceso. autonumerico', AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `auth_login_success`
--
ALTER TABLE `auth_login_success`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del acceso. autonumerico', AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `log_acciones`
--
ALTER TABLE `log_acciones`
  MODIFY `log_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
