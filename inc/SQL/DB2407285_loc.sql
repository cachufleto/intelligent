-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 18 Juin 2016 à 17:26
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
(2, '$2y$10$wxJ8lyMkz2.ijBRwyHaeBuicU8NfxG92IcxDdPVrBOoxJLskczi3C', '2016-06-18 10:15:45');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_reservation` int(10) UNSIGNED NOT NULL,
  `id_salle` int(10) UNSIGNED NOT NULL,
  `date_entree` datetime NOT NULL,
  `date_sortie` datetime NOT NULL,
  `prix` float(8,2) NOT NULL,
  `id_promo` int(10) UNSIGNED NOT NULL,
  `prix_TTC` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Historique des réservations';

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
(1, 'Admin', '$2y$10$gRCkhbidbCKCKA7OchNKXOXNQim025U8QwZBiuwa4CFxn8UdTd16m', 'Paz', 'Carlos', 'carlos.paz.dupriez@gmail.com', 'm', '0606060606', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'ADM', '2016-05-25 11:02:02', 1),
(2, 'toto', '$2y$10$wxJ8lyMkz2.ijBRwyHaeBuicU8NfxG92IcxDdPVrBOoxJLskczi3C', 'Paz', 'Carlos', 'carlos.paz@free.fr', 'm', '0606060606', NULL, 'Paris', 75012, 'Aqui', 'MEM', '2016-06-18 10:15:45', 1),
(3, 'tatra', '$2y$10$lG.QxTFmz2XfZYyZTkMf6ew5rkP7A.OFxRxVmHxyOUzK8EHUgEjk2', 'Paz', 'Carlos', 'carlos.paz2@free.fr', 'm', '0606060606', NULL, 'Paris', 75012, 'Aqui', 'MEM', '2016-06-18 10:22:37', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='Prix des salles';

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `id_salle`, `id_plagehoraire`) VALUES
(52, 1, 4),
(53, 4, 1),
(54, 4, 2),
(55, 3, 1),
(56, 3, 2),
(57, 3, 3),
(58, 5, 1),
(59, 5, 2),
(60, 7, 1),
(61, 7, 2),
(62, 7, 3),
(63, 2, 3),
(64, 2, 4),
(65, 6, 2),
(66, 6, 3),
(67, 3, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `telephone`, `gsm`, `description`, `photo`, `capacite`, `cap_min`, `tranche`, `categorie`, `prix_personne`, `active`) VALUES
(1, 'France', 'Boulogne-Billancourt', 'Ou j&#039;habite', '92100', 'MonTh', '0660474300', NULL, 'Un v&Atilde;&copy;ritable th&Atilde;&copy;&Atilde;&cent;tre est a votre disposition pour les &Atilde;&copy;v&Atilde;&copy;nements culturels.', '_____5745ab427a580.jpg', 150, 1, 'T1', 'F', 5.5, 1),
(2, 'Colombie', 'Bogota', 'C&#039;est la mienne', '89895', 'Diviel', '12023024', NULL, 'Una berraquera.', '_____574626fc8673a.jpg', 89, 1, 'T1', 'C', 5.5, 1),
(3, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Carlos Paz Dupriez', '0662474323', NULL, 'erazevr aez faef \r\naef aerf aerg aerg zdfg zv&#039;(-&Atilde;&uml;(e- erzerf\r\nvzer gz&#039;( ytfvsfdb\r\n sdfb dfng dghn dghj&Atilde;&nbsp;\r\nxfb sdf \r\n&Atilde;&copy;\r\nf gsdfbf', 'France_Boulogne-Billancourt_Carlos_Paz_Dupriez_574beadf3f21b.gif', 900, 250, 'T4', 'C', 10.0, 1),
(4, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Mon Th&eacute;&acirc;tre', '0662474323', NULL, 'Dans de nombreuses installations, ces polices sont souvent absentes. Les polices cursives sont alors remplac&eacute;es par une des polices g&eacute;n&eacute;riques par d&eacute;faut (avec ou sans empattement) du moteur de rendu (et &eacute;ventuellement configur&eacute;e par l&#039;utilisateur dans les r&eacute;glages du navigateur). ', 'France_Boulogne-Billancourt_Mon_ThAtilde;copy;Atil_574afc013d41d.jpg', 60, 15, 'T1', 'C', 5.5, 1),
(5, 'France', 'Levallois Perret', '157 rue Jules guesde', '92300', 'Frias Garcia', '+336437385', NULL, ' Le Hall, grand espace ouvert, lumineux et convivial, est un lieu de rencontre et d&acirc;€™&Atilde;&copy;change, agr&Atilde;&copy;able &Atilde;&nbsp; fr&Atilde;&copy;quenter les soirs de spectacle autour d&acirc;€™un verre, d&acirc;€™un repas ou tout simplement en journ&Atilde;&copy;e pour acc&Atilde;&copy;der aux diff&Atilde;&copy;rents &Atilde;&copy;quipements du Toboggan, prendre vos places de spectacles &Atilde;&nbsp; l&acirc;€™accueil billetterie. Des animations en lien avec les diff&Atilde;&copy;rentes programmations donnent vie au hall tout au long de la saison.', 'France_Levallois Perret_Frias GarciaFrance_Levallois_Perret_Frias_Garcia_574a175181f40.jpg', 6, 1, 'T1', 'R', 5.5, 1),
(6, 'rep dom', 'sto dgo', '50 rue saint-sebastien', '75011', 'L. Deprez', '+336437385', NULL, ' Le Hall, grand espace ouvert, lumineux et convivial, est un lieu de rencontre et d&acirc;€™&Atilde;&copy;change, agr&Atilde;&copy;able &Atilde;&nbsp; fr&Atilde;&copy;quenter les soirs de spectacle autour d&acirc;€™un verre, d&acirc;€™un repas ou tout simplement en journ&Atilde;&copy;e pour acc&Atilde;&copy;der aux diff&Atilde;&copy;rents &Atilde;&copy;quipements du Toboggan, prendre vos places de spectacles &Atilde;&nbsp; l&acirc;€™accueil billetterie. Des animations en lien avec les diff&Atilde;&copy;rentes programmations donnent vie au hall tout au long de la saison.', 'rep dom_sto dgo_paz pazrep_dom_sto_dgo_paz_paz_574b40711dd69.jpg', 150, 1, 'T1', 'F', 5.5, 1),
(7, 'France', 'Boulogne-Billancourt', '56 Aristide briant', '92100', 'test', '0662474323', NULL, 'grand salle', 'France_Boulogne-Billancourt_test_574ca864ccfde.png', 6, 1, 'T1', 'C', 5.5, 1);

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
