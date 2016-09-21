-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 21 Septembre 2016 à 22:01
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

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `produit` varchar(150) NOT NULL,
  `fabricant` varchar(150) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `cp` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `ean` varchar(13) DEFAULT NULL,
  `quantite` int(11) NOT NULL DEFAULT '1',
  `categorie` enum('R','C','F','T') NOT NULL DEFAULT 'R',
  `prix_Achat` float(4,1) NOT NULL DEFAULT '5.5',
  `active` int(1) DEFAULT '0',
  PRIMARY KEY (`id_article`),
  KEY `id_salle` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `articles_plagehoraires`
--

DROP TABLE IF EXISTS `articles_plagehoraires`;
CREATE TABLE IF NOT EXISTS `articles_plagehoraires` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salles` int(10) UNSIGNED NOT NULL,
  `id_plagehoraire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relationelle';

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

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_reservation` int(10) UNSIGNED NOT NULL,
  `id_article` int(10) UNSIGNED DEFAULT NULL,
  `id_salle` int(10) UNSIGNED DEFAULT NULL,
  `date_facturacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_reserve` datetime NOT NULL,
  `tranche` tinyint(1) NOT NULL,
  `capacitee` int(11) NOT NULL,
  `prix` float(8,2) NOT NULL,
  `reduction` float(8,2) NOT NULL,
  `prix_TTC` float(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservations` (`id_salle`,`date_reserve`,`tranche`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Historique des rÃ©servations';

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
  (1, 'Admin', 'Admin', 'Paz', 'Carlos', 'carlos.paz.dupriez@gmail.com', 'm', '0606060606', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'ADM', '2016-05-25 11:02:02', 1);

-- --------------------------------------------------------

--
-- Structure de la table `plagehoraires`
--

DROP TABLE IF EXISTS `plagehoraires`;
CREATE TABLE IF NOT EXISTS `plagehoraires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(15) NOT NULL,
  `description` text,
  `heure_entree` time NOT NULL,
  `heure_sortie` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `plagehoraires`
--

INSERT INTO `plagehoraires` (`id`, `libelle`, `description`, `heure_entree`, `heure_sortie`) VALUES
  (1, 'matinee', '8:00h - 12:00h', '08:00:00', '12:00:00'),
  (2, 'journee', '1300h - 17:00h', '13:00:00', '17:00:00'),
  (3, 'soiree', '18:00h - 22:00h', '18:00:00', '22:00:00'),
  (4, 'nocturne', '22:00h - 5:00h', '22:00:00', '23:59:00');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_article` int(10) UNSIGNED DEFAULT NULL,
  `id_salle` int(10) UNSIGNED DEFAULT NULL,
  `id_plagehoraire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Prix des salles';

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salle` int(10) UNSIGNED NOT NULL,
  `plage_horaire` tinyint(1) NOT NULL DEFAULT '0',
  `libelle` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `date_debut` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dete_fin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_membre` int(10) UNSIGNED NOT NULL,
  `date_facturacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `cap_min` int(11) NOT NULL DEFAULT '1',
  `tranche` enum('T1','T2','T3','T4') NOT NULL DEFAULT 'T1',
  `categorie` enum('R','C','F','T') NOT NULL DEFAULT 'R',
  `prix_personne` float(4,1) NOT NULL DEFAULT '5.5',
  `active` int(1) DEFAULT '0',
  PRIMARY KEY (`id_salle`),
  KEY `id_salle` (`id_salle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `salles_plagehoraires`
--

DROP TABLE IF EXISTS `salles_plagehoraires`;
CREATE TABLE IF NOT EXISTS `salles_plagehoraires` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salles` int(10) UNSIGNED NOT NULL,
  `id_article` int(10) UNSIGNED NOT NULL,
  `id_plagehoraire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relationelle';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
