-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Dic 02, 2021 alle 16:49
-- Versione del server: 5.7.31
-- Versione PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unimol_concorsi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_anagrafica` varchar(255) NOT NULL,
  `cod_risposte` varchar(255) NOT NULL,
  `id_concorso` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_accounts_concorsi` (`id_concorso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `accounts`
--

INSERT INTO `accounts` (`id`, `cod_anagrafica`, `cod_risposte`, `id_concorso`) VALUES
(1, 'test', 'c1', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'testadmin', 'testadmin');

-- --------------------------------------------------------

--
-- Struttura della tabella `concorsi`
--

DROP TABLE IF EXISTS `concorsi`;
CREATE TABLE IF NOT EXISTS `concorsi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominazione` varchar(255) NOT NULL,
  `abilitato` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `concorsi`
--

INSERT INTO `concorsi` (`id`, `denominazione`, `abilitato`) VALUES
(1, 'Concorso009', 1),
(2, 'Concorso2', 0),
(3, 'concorso1111', 0);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `FK_accounts_concorsi` FOREIGN KEY (`id_concorso`) REFERENCES `concorsi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
