-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 16 avr. 2021 à 16:03
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `prwb_2021_d02`
--

-- --------------------------------------------------------

--
-- Structure de la table `board`
--

DROP TABLE IF EXISTS `board`;
CREATE TABLE IF NOT EXISTS `board` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(128) NOT NULL,
  `Owner` int(11) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Title` (`Title`),
  KEY `Owner` (`Owner`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `board`
--

INSERT INTO `board` (`ID`, `Title`, `Owner`, `CreatedAt`, `ModifiedAt`) VALUES
(1, 'Projet PRWB', 1, '2020-10-11 17:48:59', NULL),
(2, 'Projet ANC3', 3, '2020-10-11 17:48:59', NULL),
(4, 'Boulot', 5, '2020-11-25 18:54:53', NULL),
(8, 'Board Lulu', 6, '2021-02-12 18:02:40', '2021-02-12 18:48:11');

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(128) NOT NULL,
  `Body` text NOT NULL,
  `Position` int(11) NOT NULL DEFAULT '0',
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedAt` datetime DEFAULT NULL,
  `Author` int(11) NOT NULL,
  `Column` int(11) NOT NULL,
  `DueDate` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Author` (`Author`),
  KEY `Column` (`Column`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `card`
--

INSERT INTO `card` (`ID`, `Title`, `Body`, `Position`, `CreatedAt`, `ModifiedAt`, `Author`, `Column`, `DueDate`) VALUES
(1, 'Analyse conceptuelle', 'Faire l\'analyse conceptuelle de la base de données du projet.', 1, '2020-10-11 17:56:40', '2020-11-27 13:07:39', 2, 3, NULL),
(2, 'Mockups itération 1', 'Faire des prototypes d\'écrans pour les fonctionnalités de la première itération.', 0, '2020-10-11 17:56:40', '2020-11-27 13:07:40', 1, 2, NULL),
(3, 'Ecrire énoncé itération 1.', '', 1, '2020-10-11 17:58:37', '2020-11-27 13:07:42', 4, 2, '2021-01-01'),
(4, 'Echéances IT1 !', 'Décider des dates d\'échéance pour la première itération.', 0, '2020-10-11 17:58:37', '2020-11-27 13:07:34', 1, 3, NULL),
(6, 'Enoncé itération 2', '', 0, '2020-11-27 13:07:54', NULL, 5, 1, NULL),
(14, 'Card BA', 'test Itération 2', 0, '2021-02-12 18:29:07', '2021-04-16 13:32:22', 6, 20, '2021-04-16'),
(15, 'Card AB', 'Card Due Date Invalide !', 0, '2021-02-12 18:29:12', '2021-02-24 14:23:45', 6, 19, '2021-02-24'),
(18, 'Card BC', '', 2, '2021-02-12 18:29:34', '2021-02-24 14:23:17', 6, 20, '2021-02-24'),
(19, 'Card C', '', 0, '2021-02-12 18:29:53', '2021-02-24 14:50:57', 6, 21, '2021-02-22'),
(20, 'Card CB', '', 1, '2021-02-12 18:29:57', '2021-02-12 18:47:44', 6, 21, NULL),
(21, 'Card BB', '', 1, '2021-03-08 19:08:04', NULL, 6, 20, NULL),
(22, 'cfv', '', 0, '2021-04-16 12:11:46', NULL, 5, 11, NULL),
(23, 'fgdhdfgh', '', 0, '2021-04-16 16:46:31', NULL, 3, 4, NULL),
(24, 'dfghdfghfdgh', '', 1, '2021-04-16 16:46:34', NULL, 3, 4, NULL),
(25, 'dfghfgdh', '', 0, '2021-04-16 16:46:35', NULL, 3, 5, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `collaborate`
--

DROP TABLE IF EXISTS `collaborate`;
CREATE TABLE IF NOT EXISTS `collaborate` (
  `Board` int(11) NOT NULL,
  `Collaborator` int(11) NOT NULL,
  PRIMARY KEY (`Board`,`Collaborator`),
  KEY `Collaborator` (`Collaborator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `collaborate`
--

INSERT INTO `collaborate` (`Board`, `Collaborator`) VALUES
(4, 1),
(8, 1),
(1, 2),
(8, 3),
(1, 4),
(1, 5),
(1, 6),
(4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `column`
--

DROP TABLE IF EXISTS `column`;
CREATE TABLE IF NOT EXISTS `column` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(128) NOT NULL,
  `Position` int(11) NOT NULL DEFAULT '0',
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedAt` datetime DEFAULT NULL,
  `Board` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Board` (`Board`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `column`
--

INSERT INTO `column` (`ID`, `Title`, `Position`, `CreatedAt`, `ModifiedAt`, `Board`) VALUES
(1, 'A faire', 0, '2020-10-11 17:51:59', NULL, 1),
(2, 'En cours', 1, '2020-10-11 17:51:59', NULL, 1),
(3, 'Terminé', 2, '2020-10-11 17:52:27', NULL, 1),
(4, 'A faire', 0, '2020-10-11 17:52:27', NULL, 2),
(5, 'Fini', 1, '2020-10-11 17:53:07', NULL, 2),
(6, 'Abandonné', 2, '2020-10-11 17:53:07', NULL, 2),
(11, 'Pas urgent...', 0, '2020-11-25 18:55:06', NULL, 4),
(12, 'Ne pas perdre de vue', 1, '2020-11-25 18:55:17', NULL, 4),
(13, 'Pour hier', 2, '2020-11-25 18:55:32', NULL, 4),
(15, 'Trop tard', 3, '2020-11-25 18:56:11', NULL, 4),
(19, 'column A', 0, '2021-02-12 18:02:48', '2021-02-12 18:02:54', 8),
(20, 'column B', 1, '2021-02-12 18:29:01', NULL, 8),
(21, 'column C', 2, '2021-02-12 18:29:49', NULL, 8);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Body` text NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedAt` datetime DEFAULT NULL,
  `Author` int(11) NOT NULL,
  `Card` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Author` (`Author`),
  KEY `Card` (`Card`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`ID`, `Body`, `CreatedAt`, `ModifiedAt`, `Author`, `Card`) VALUES
(1, 'Ceci est un commentaire', '2020-11-27 14:45:39', NULL, 5, 6),
(2, 'Voilà un autre commentaire', '2020-11-27 14:46:02', NULL, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `participate`
--

DROP TABLE IF EXISTS `participate`;
CREATE TABLE IF NOT EXISTS `participate` (
  `Participant` int(11) NOT NULL,
  `Card` int(11) NOT NULL,
  PRIMARY KEY (`Participant`,`Card`),
  KEY `Card` (`Card`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `participate`
--

INSERT INTO `participate` (`Participant`, `Card`) VALUES
(1, 1),
(5, 1),
(1, 15),
(2, 15),
(3, 15);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Mail` varchar(128) NOT NULL,
  `FullName` varchar(128) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `RegisteredAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Mail` (`Mail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`ID`, `Mail`, `FullName`, `Password`, `RegisteredAt`, `Role`) VALUES
(1, 'boverhaegen@epfc.eu', 'Boris Verhaegen', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:46:19', 'admin'),
(2, 'bepenelle@epfc.eu', 'Benoît Penelle', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:46:19', 'user'),
(3, 'brlacroix@epfc.eu', 'Bruno Lacroix', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:47:20', 'user'),
(4, 'xapigeolet@epfc.eu', 'Xavier Pigeolet', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:47:20', 'admin'),
(5, 'galagaffe@epfc.eu', 'Gaston Lagaffe', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-11-25 18:46:55', 'user'),
(6, 'Lucien@gmail.com', 'Lucien', '56ce92d1de4f05017cf03d6cd514d6d1', '2021-02-10 15:31:44', 'admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `board_ibfk_1` FOREIGN KEY (`Owner`) REFERENCES `user` (`ID`);

--
-- Contraintes pour la table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `card_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `card_ibfk_2` FOREIGN KEY (`Column`) REFERENCES `column` (`ID`);

--
-- Contraintes pour la table `collaborate`
--
ALTER TABLE `collaborate`
  ADD CONSTRAINT `collaborate_ibfk_1` FOREIGN KEY (`Collaborator`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `collaborate_ibfk_2` FOREIGN KEY (`Board`) REFERENCES `board` (`ID`);

--
-- Contraintes pour la table `column`
--
ALTER TABLE `column`
  ADD CONSTRAINT `column_ibfk_1` FOREIGN KEY (`Board`) REFERENCES `board` (`ID`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`Author`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`Card`) REFERENCES `card` (`ID`);

--
-- Contraintes pour la table `participate`
--
ALTER TABLE `participate`
  ADD CONSTRAINT `participate_ibfk_1` FOREIGN KEY (`Card`) REFERENCES `card` (`ID`),
  ADD CONSTRAINT `participate_ibfk_2` FOREIGN KEY (`Participant`) REFERENCES `user` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
