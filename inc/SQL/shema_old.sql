-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 07 Février 2016 à 23:48
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `Intelligent`
--

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id_membre` int(5) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(15) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sexe` enum('m','f') DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `gsm` varchar(10) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `cp` int(10) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `statut` set('MEM','COL','ADM') NOT NULL DEFAULT 'MEM',
  `inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT 'suppression',
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
(1, 'Admin', 'Admin', 'Paz', 'Carlos', 'carlos.paz.dupriez@gmail.com', 'm', '0606060606', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'ADM', CURRENT_TIMESTAMP, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

DROP TABLE IF EXISTS `salles`;
CREATE TABLE IF NOT EXISTS `salles` (
  `id_salle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `cp` varchar(10) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `gsm` varchar(10) DEFAULT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `capacite` int(3) UNSIGNED NOT NULL,
  `categorie` enum('R','C','F') NOT NULL DEFAULT 'R',
  `active` int(1) DEFAULT '0',
  PRIMARY KEY (`id_salle`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salles`
--
-- --------------------------------------------------------

--
-- Structure de la table `checkinscription`
--

DROP TABLE IF EXISTS `checkinscription`;
CREATE TABLE IF NOT EXISTS `checkinscription` (
  `id_membre` int(11) NOT NULL,
  `checkinscription` varchar(250) NOT NULL,
  `inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
