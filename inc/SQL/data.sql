-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 28 Janvier 2016 à 20:29
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `intelligent`
--

--
-- Contenu de la table `membre`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
(2, 'Membre', 'membre', 'Paz', 'Carlos', 'carlos.paz@gmail.com', 'm', '0606060606', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'COL', CURRENT_TIMESTAMP , 1),
(3, 'Membre2', 'membre2', 'Paz', 'Carlos', 'carlos.dupriez@gmail.com', 'm', '1212121212', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'MEM', CURRENT_TIMESTAMP, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
