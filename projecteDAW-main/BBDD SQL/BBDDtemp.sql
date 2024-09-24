-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Temps de generació: 20-09-2024 a les 10:22:34
-- Versió del servidor: 10.4.32-MariaDB
-- Versió de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `fundacioapelesfenosa`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `registres`
--

CREATE TABLE `registres` (
  `id` int(11) NOT NULL,
  `Fotografia` text NOT NULL,
  `NumeroRegistre` varchar(50) NOT NULL,
  `NomObjecte` varchar(100) NOT NULL,
  `Titol` varchar(150) NOT NULL,
  `Autor` varchar(100) NOT NULL,
  `Datacio` varchar(50) NOT NULL,
  `Ubicacio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de la taula `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `NomUsuari` varchar(50) NOT NULL,
  `Contrasenya` text NOT NULL,
  `Permisos` enum('Admin','Tecnic','Convidat') NOT NULL,
  `FotoPerfil` text DEFAULT 'img/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `registres`
--
ALTER TABLE `registres`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `registres`
--
ALTER TABLE `registres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la taula `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
