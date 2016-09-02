-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 12 Juin 2016 à 23:19
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `Intelligent_1206`
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

--
-- Contenu de la table `checkinscription`
--

INSERT INTO `checkinscription` (`id_membre`, `checkinscription`, `inscription`) VALUES
(2, '$2y$10$.bPUqU6RuoQNMzL.bsl0h.DcG3zdqKD2mfsspx2ELuLXZ4BV3d/Du', '2016-05-16 17:14:33');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_reservation` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salle` int(10) UNSIGNED NOT NULL,
  `date_entree` datetime NOT NULL,
  `date_sortie` datetime NOT NULL,
  `prix` float(8,2) NOT NULL,
  `id_promo` int(10) UNSIGNED NOT NULL,
  `prix_TTC` float NOT NULL,
  PRIMARY KEY (`id_reservation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Historique des réservations';

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
  `cp` int(5) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `statut` set('MEM','COL','ADM') NOT NULL DEFAULT 'MEM',
  `inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT 'suppression',
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
(1, 'Admin', '$2y$10$lVg09kE29d1lmGJ2c50gRuT7rnX6y/dR34Hwxna6/EvXWjBpYO.YO', 'BENTAHRA', 'Saeed', 'carlos.paz.dupriez@gmail.com', 'f', '0617900856', '0617900856', 'PARIS', 75011, 'Rue escuder', 'ADM', '2016-05-16 14:13:21', 1),
(2, 'cpaz', '$2y$10$Bdz1aqZ0igqO.kTBtFFbL.OiUIbnnSx1ORsMrxDwyhGtE57mI21SK', 'Paz', 'Magda', 'magda.quintana@free.fr', 'f', '0660249154', '0660249154', 'Boulogne-Billancourt', 92100, '46 rue Escudier', 'MEM', '2016-05-16 14:14:12', 0),
(3, 'toto', '$2y$10$2qy1WURuGQ4yUKyuPKGXeeUvVLF5iJQlAPyh/r/pxp7FjrSZxmaMq', 'toto', 'toto', 'carlos.paz@free.fr', 'm', '0102030405', '0662474323', 'Paris', 75011, 'Ou j&#039;habite', 'MEM', '2016-05-26 22:15:46', 0);

-- --------------------------------------------------------

--
-- Structure de la table `plagehoraires`
--

DROP TABLE IF EXISTS `plagehoraires`;
CREATE TABLE IF NOT EXISTS `plagehoraires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(15) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `plagehoraires`
--

INSERT INTO `plagehoraires` (`id`, `libelle`, `description`) VALUES
(1, 'matinee', 'de 8:00h à 12:00h'),
(2, 'journee', 'de 1300h à 18:00h'),
(3, 'soiree', 'de 19:00h à 22:00h'),
(4, 'nocturne', 'de 22:00h à 5:00h');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salle` int(10) UNSIGNED NOT NULL,
  `id_plagehoraire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COMMENT='Prix des salles';

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `id_salle`, `id_plagehoraire`) VALUES
(28, 1, 2),
(30, 7, 1),
(31, 7, 3),
(34, 3, 1),
(35, 3, 2),
(37, 7, 4),
(38, 7, 2),
(39, 10, 3),
(41, 1, 1),
(45, 5, 3),
(48, 10, 1),
(49, 15, 1),
(50, 15, 2),
(51, 15, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `promotions`
--

INSERT INTO `promotions` (`id`, `id_salle`, `plage_horaire`, `libelle`, `code`, `date_debut`, `dete_fin`) VALUES
(1, 1, 3, 'test', 1245639, '2016-06-11 11:21:42', '2016-06-11 11:21:42');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_membre` int(10) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `telephone`, `gsm`, `description`, `photo`, `capacite`, `cap_min`, `tranche`, `categorie`, `prix_personne`, `active`) VALUES
(1, 'Colombie', 'Cali', 'labas', '89789', 'cathi', '5564557', NULL, 'Cinema tres', 'Colombie_Cali_cathi_57476bd25b25a.jpg', 25, 5, 'T2', 'R', 8.5, 1),
(2, 'France', 'Paris', 'ici', '92100', 'TATTA', '0662474323', NULL, 'ample', 'France_Paris_TATTA_57472fc58c09a.jpg', 60, 1, 'T1', 'F', 5.5, 0),
(3, 'France', 'Paris', 'ici', '92100', 'toto', '0662474323', NULL, 'ample', 'Array_573a2db0a938e.PNG', 160, 144, 'T1', 'R', 5.5, 1),
(4, 'France', 'Paris', 'ici', '92100', 'Model th&eacute;&acirc;tre', '0662474323', NULL, 'ample', 'toto_573a2dda871a9.PNG', 16, 1, 'T2', 'C', 5.5, 0),
(5, 'France', 'Paris', 'ici', '92100', 'toto', '0662474323', NULL, 'ample', 'toto_573a2de64ab23.PNG', 600, 150, 'T2', 'C', 5.5, 0),
(6, 'Colombie', 'Boulogne-Billancourt', 'test', '5689', 'dodo', '124578963', NULL, 'fhdhdhsoe', 'dodo_57420a8d096f4.jpg', 56, 1, 'T2', 'F', 5.5, 0),
(7, 'Colombie', 'test', 'FSBDFBSDFB', '89898', 'paz', '0102030405', NULL, 'GHKJFKFHK', 'paz_57420b776b2d1.jpg', 180, 1, 'T4', 'C', 5.5, 1),
(8, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'cathi', '0662474323', NULL, 'dsqdfa ef qe', 'cathi_57420fee74a4f.png', 60, 1, 'T2', 'R', 5.5, 0),
(9, 'test', 'test', 'test', '787878', 'test', '12457839', NULL, 'jhiug', 'test_5744c1562dca4.jpg', 89, 1, 'T2', 'C', 5.5, 0),
(10, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'test 45', '0662474323', NULL, 'test 45', 'test 45_5744c1ff0cfdb.jpg', 89, 25, 'T3', 'R', 5.5, 1),
(11, 'dSsqd', 'qd qsdc', 'dcqsdvqsdOu j&#039;habite', '898989', 'dqfsdf', '02020202', NULL, 'CSDsd x  SD QSD 4 4DFV 4SVFV FV67B7 DFGB SDFBDescription...', '_____574a0cf068f4d.jpg', 56, 1, 'T2', 'C', 5.5, 0),
(12, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Carlos Paz Dupriez', '0662474323', NULL, 'Dans de nombreuses installations, ces polices sont souvent absentes. Les polices cursives sont alors remplac&eacute;es par une des polices g&eacute;n&eacute;riques par d&eacute;faut (avec ou sans empattement) du moteur de rendu (et &eacute;ventuellement configur&eacute;e par l&rsquo;utilisateur dans les r&eacute;glages du navigateur). Dans certains cas (par exemple les polices d&eacute;coratives dites &laquo; bris&eacute;es &raquo;, il peut &ecirc;tre utile de pr&eacute;ciser une famille g&eacute;n&eacute;rique pr&eacute;f&eacute;r&eacute;e &agrave; celle de leur classification normale, afin de pr&eacute;server leur lisibilit&eacute; si elles sont substitu&eacute;es par une autre dans leur utilisation dans un texte normal.', '_____574a119b78d80.jpg', 600, 110, 'T3', 'C', 5.5, 0),
(13, 'Colombie', 'Boulogne-Billancourt', 'testetets', '89898', 'Mon Th&eacute;&acirc;tre', '0662474323', NULL, 'When using UTF-8 and need to convert to uppercase with \r\nspecial characters like the german &auml;,&ouml;,&uuml; (didn&#039;t test for french,polish,russian but think it should work, too) try this:\r\n\r\nfunction strtoupper_utf8($string){\r\n    $string=utf8_decode($string);\r\n    $string=strtoupper($string);\r\n    $string=utf8_encode($string);\r\n    return $string;\r\n}', '_____574a1560bca2d.jpg', 56, 1, 'T2', 'C', 5.5, 0),
(14, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Mon Th&eacute;&acirc;tre', '0662474323', NULL, 'When using UTF-8 and need to convert to uppercase with \r\nspecial characters like the german &auml;,&ouml;,&uuml; (didn&#039;t test for french,polish,russian but think it should work, too) try this:\r\n\r\nfunction strtoupper_utf8($string){\r\n    $string=utf8_decode($string);\r\n    $string=strtoupper($string);\r\n    $string=utf8_encode($string);\r\n    return $string;\r\n}Description...', '_____574a15be05c2f.jpg', 20, 2, 'T2', 'C', 5.5, 0),
(15, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Mon Th&eacute;&acirc;tre', '0662474323', NULL, 'When using UTF-8 and need to convert to uppercase with \r\nspecial characters like the german &auml;,&ouml;,&uuml; (didn&#039;t test for french,polish,russian but think it should work, too) try this:\r\n\r\nfunction strtoupper_utf8($string){\r\n    $string=utf8_decode($string);\r\n    $string=strtoupper($string);\r\n    $string=utf8_encode($string);\r\n    return $string;\r\n}Description...', 'France_Boulogne-Billancourt_Mon_Theacute;acirc;tre_575d237741fe0.png', 6, 1, 'T1', 'C', 5.5, 1),
(16, 'France', 'Boulogne-Billancourt', 'edok,jv dfvs pd,fo^pv jzedr', '92100', 'Mon th&eacute;&acirc;ttre', '0662474323', NULL, 'hsdcjbqksdj vciqsndkv qsdv cqsd', 'France_Boulogne-Billancourt_Mon th&eacute;&acirc;ttreFrance_Boulogne-Billancourt_Mon_th&eacute;&acirc;ttre_574a2c926856e.jpg', 6, 1, 'T2', 'C', 5.5, 0),
(17, 'France', 'Paris', 'tutut', '75012', 'tree', '0102020202', NULL, 'Descritestption...', 'France_Paris_treeFrance_Paris_tree_575c81b9d1896.gif', 32, 32, 'T1', 'T', 8.0, 0),
(18, 'France', 'Paris', 'Issy', '92100', 'TEST 2', '0230230215', NULL, 'explendide', 'France_Paris_TEST 2France_Paris_TEST_2_575c8738c1c5d.jpg', 500, 210, 'T3', 'T', 9.0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `salles_plagehoraires`
--

DROP TABLE IF EXISTS `salles_plagehoraires`;
CREATE TABLE IF NOT EXISTS `salles_plagehoraires` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_salles` int(10) UNSIGNED NOT NULL,
  `id_plagehoraire` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relationelle';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
