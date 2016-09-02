-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Client :  rdbms
-- Généré le :  Sam 18 Juin 2016 à 17:26
-- Version du serveur :  5.5.48-log
-- Version de PHP :  5.5.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `DB2407285`
--

-- --------------------------------------------------------

--

-- Structure de la table `checkinscription`
--

CREATE TABLE IF NOT EXISTS `checkinscription` (
  `id_membre` int(11) NOT NULL,
  `checkinscription` varchar(250) NOT NULL,
  `inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
`id_commande` int(6) NOT NULL,
  `id_membre` int(5) DEFAULT NULL,
  `montant` double(7,2) NOT NULL,
  `date` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL DEFAULT 'en cours de traitement'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE IF NOT EXISTS `commandes` (
`id` int(10) unsigned NOT NULL,
  `id_reservation` int(10) unsigned NOT NULL,
  `id_salle` int(10) unsigned NOT NULL,
  `date_entree` datetime NOT NULL,
  `date_sortie` datetime NOT NULL,
  `prix` float(8,2) NOT NULL,
  `id_promo` int(10) unsigned NOT NULL,
  `prix_TTC` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Historique des réservations';

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE IF NOT EXISTS `details_commande` (
`id_details_commande` int(5) NOT NULL,
  `id_commande` int(6) NOT NULL,
  `id_article` int(5) DEFAULT NULL,
  `quantite` int(4) NOT NULL,
  `prix` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
`id` int(5) NOT NULL,
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
  `active` int(1) unsigned NOT NULL DEFAULT '2' COMMENT 'suppression'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `telephone`, `gsm`, `ville`, `cp`, `adresse`, `statut`, `inscription`, `active`) VALUES
(1, 'Admin', '$2y$10$gRCkhbidbCKCKA7OchNKXOXNQim025U8QwZBiuwa4CFxn8UdTd16m', 'Paz', 'Carlos', 'carlos.paz.dupriez@gmail.com', 'm', '0606060606', '0662474323', 'Boulogne-Billancourt', 92100, 'Rue escuder', 'ADM', '2016-05-25 11:02:02', 1);

-- --------------------------------------------------------

--
-- Structure de la table `plagehoraires`
--

CREATE TABLE IF NOT EXISTS `plagehoraires` (
`id` int(11) NOT NULL,
  `libelle` varchar(15) NOT NULL,
  `description` text
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

CREATE TABLE IF NOT EXISTS `produits` (
`id` int(10) unsigned NOT NULL,
  `id_salle` int(10) unsigned NOT NULL,
  `id_plagehoraire` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='Prix des salles';

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `id_salle`, `id_plagehoraire`) VALUES
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
(68, 4, 2),
(72, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
`id` int(10) unsigned NOT NULL,
  `id_membre` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE IF NOT EXISTS `salles` (
`id_salle` int(10) unsigned NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `cp` varchar(10) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `gsm` varchar(10) DEFAULT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `capacite` int(3) unsigned NOT NULL,
  `cap_min` int(11) NOT NULL DEFAULT '1',
  `tranche` enum('T1','T2','T3','T4') NOT NULL DEFAULT 'T1',
  `categorie` enum('R','C','F','T') NOT NULL DEFAULT 'R',
  `prix_personne` float(4,1) NOT NULL DEFAULT '5.5',
  `active` int(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salles`
--

INSERT INTO `salles` (`id_salle`, `pays`, `ville`, `adresse`, `cp`, `titre`, `telephone`, `gsm`, `description`, `photo`, `capacite`, `cap_min`, `tranche`, `categorie`, `prix_personne`, `active`) VALUES
(1, 'France', 'Boulogne-Billancourt', 'Ou j&#039;habite', '92100', 'MonTh', '0660474300', NULL, 'Un v&Atilde;&copy;ritable th&Atilde;&copy;&Atilde;&cent;tre est a votre disposition pour les &Atilde;&copy;v&Atilde;&copy;nements culturels.', '_____5745ab427a580.jpg', 150, 1, 'T1', 'F', 5.5, 1),
(2, 'Colombie', 'Bogota', 'C&#039;est la mienne', '89895', 'Diviel', '12023024', NULL, 'Una berraquera.', '_____574626fc8673a.jpg', 89, 1, 'T1', 'C', 5.5, 1),
(3, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Carlos Paz Dupriez', '0662474323', NULL, 'erazevr aez faef \r\naef aerf aerg aerg zdfg zv&#039;(-&Atilde;&uml;(e- erzerf\r\nvzer gz&#039;( ytfvsfdb\r\n sdfb dfng dghn dghj&Atilde;&nbsp;\r\nxfb sdf \r\n&Atilde;&copy;\r\nf gsdfbf', 'France_Boulogne-Billancourt_Carlos_Paz_Dupriez_574beadf3f21b.gif', 6, 1, 'T1', 'C', 5.5, 1),
(4, 'France', 'Boulogne-Billancourt', '46 rue Escudier', '92100', 'Mon Th&Atilde;&copy;&Atilde;&cent;tre', '0662474323', NULL, 'Dans de nombreuses installations, ces polices sont souvent absentes. Les polices cursives sont alors remplac&Atilde;&copy;es par une des polices g&Atilde;&copy;n&Atilde;&copy;riques par d&Atilde;&copy;faut (avec ou sans empattement) du moteur de rendu (et &Atilde;&copy;ventuellement configur&Atilde;&copy;', 'France_Boulogne-Billancourt_Mon_ThAtilde;copy;Atil_574afc013d41d.jpg', 600, 150, 'T4', 'C', 10.0, 1),
(5, 'France', 'Levallois Perret', '157 rue Jules guesde', '92300', 'Frias Garcia', '+336437385', NULL, ' Le Hall, grand espace ouvert, lumineux et convivial, est un lieu de rencontre et d&acirc;€™&Atilde;&copy;change, agr&Atilde;&copy;able &Atilde;&nbsp; fr&Atilde;&copy;quenter les soirs de spectacle autour d&acirc;€™un verre, d&acirc;€™un repas ou tout simplement en journ&Atilde;&copy;e pour acc&Atilde;&copy;der aux diff&Atilde;&copy;rents &Atilde;&copy;quipements du Toboggan, prendre vos places de spectacles &Atilde;&nbsp; l&acirc;€™accueil billetterie. Des animations en lien avec les diff&Atilde;&copy;rentes programmations donnent vie au hall tout au long de la saison.', 'France_Levallois Perret_Frias GarciaFrance_Levallois_Perret_Frias_Garcia_574a175181f40.jpg', 6, 1, 'T1', 'R', 5.5, 1),
(6, 'rep dom', 'sto dgo', '50 rue saint-sebastien', '75011', 'L. Deprez', '+336437385', NULL, ' Le Hall, grand espace ouvert, lumineux et convivial, est un lieu de rencontre et d&acirc;€™&Atilde;&copy;change, agr&Atilde;&copy;able &Atilde;&nbsp; fr&Atilde;&copy;quenter les soirs de spectacle autour d&acirc;€™un verre, d&acirc;€™un repas ou tout simplement en journ&Atilde;&copy;e pour acc&Atilde;&copy;der aux diff&Atilde;&copy;rents &Atilde;&copy;quipements du Toboggan, prendre vos places de spectacles &Atilde;&nbsp; l&acirc;€™accueil billetterie. Des animations en lien avec les diff&Atilde;&copy;rentes programmations donnent vie au hall tout au long de la saison.', 'rep dom_sto dgo_paz pazrep_dom_sto_dgo_paz_paz_574b40711dd69.jpg', 150, 1, 'T1', 'F', 5.5, 1),
(7, 'France', 'Boulogne-Billancourt', '56 Aristide briant', '92100', 'test', '0662474323', NULL, 'grand salle', 'France_Boulogne-Billancourt_test_574ca864ccfde.png', 6, 1, 'T1', 'C', 5.5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `salles_plagehoraires`
--

CREATE TABLE IF NOT EXISTS `salles_plagehoraires` (
`id` int(10) unsigned NOT NULL,
  `id_salles` int(10) unsigned NOT NULL,
  `id_plagehoraire` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='relationelle';

--
-- Index pour les tables exportées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
 ADD PRIMARY KEY (`id_article`), ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
 ADD PRIMARY KEY (`id_commande`), ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
 ADD PRIMARY KEY (`id_details_commande`), ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `plagehoraires`
--
ALTER TABLE `plagehoraires`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
 ADD PRIMARY KEY (`id_salle`), ADD KEY `id_salle` (`id_salle`);

--
-- Index pour la table `salles_plagehoraires`
--
ALTER TABLE `salles_plagehoraires`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
MODIFY `id_article` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
MODIFY `id_commande` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
MODIFY `id_details_commande` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `plagehoraires`
--
ALTER TABLE `plagehoraires`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
MODIFY `id_salle` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `salles_plagehoraires`
--
ALTER TABLE `salles_plagehoraires`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
