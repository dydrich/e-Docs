-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Ott 08, 2017 alle 12:11
-- Versione del server: 5.5.57-0ubuntu0.14.04.1
-- Versione PHP: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `edocs`
--

--
-- Dump dei dati per la tabella `rb_edocs_users`
--

INSERT INTO `rb_edocs_users` (`uid`, `username`, `password`, `firstname`, `lastname`, `accesses_count`, `last_access`, `previous_access`, `active`, `files_count`, `downloads`) VALUES
(1, 'admin', 'ed5e9dd0aba4cf0d013201e6521330bf', 'System', 'Admin', 0, '2017-10-08 09:49:29', '0000-00-00 00:00:00', 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
