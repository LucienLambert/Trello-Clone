-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 07 fév. 2021 à 13:41
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
(5, 'aezra', 6, '2021-02-07 12:54:40', NULL),
(6, 'Board Test Final', 7, '2021-02-07 12:58:40', '2021-02-07 13:27:25'),
(8, 'Pour vos testes ^^', 7, '2021-02-07 13:13:42', '2021-02-07 13:13:52');

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
  PRIMARY KEY (`ID`),
  KEY `Author` (`Author`),
  KEY `Column` (`Column`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `card`
--

INSERT INTO `card` (`ID`, `Title`, `Body`, `Position`, `CreatedAt`, `ModifiedAt`, `Author`, `Column`) VALUES
(1, 'Analyse conceptuelle', 'Faire l\'analyse conceptuelle de la base de données du projet.', 1, '2020-10-11 17:56:40', '2020-11-27 13:07:39', 2, 3),
(2, 'Mockups itération 1', 'Faire des prototypes d\'écrans pour les fonctionnalités de la première itération.', 0, '2020-10-11 17:56:40', '2020-11-27 13:07:40', 1, 2),
(3, 'Ecrire énoncé itération 1.', '', 1, '2020-10-11 17:58:37', '2020-11-27 13:07:42', 4, 2),
(4, 'Echéances IT1 !', 'Décider des dates d\'échéance pour la première itération.', 0, '2020-10-11 17:58:37', '2020-11-27 13:07:34', 1, 3),
(6, 'Enoncé itération 2', '', 0, '2020-11-27 13:07:54', NULL, 5, 1),
(8, 'Test Modif Cartes Title & Body', 'les testes de modification titre et body OK\r\nles testes modification titre avec un titre existant OK\r\nles testes de mise à jour date de modification OK', 0, '2021-02-07 13:00:15', '2021-02-07 13:35:02', 7, 16),
(13, 'Test Modif titre colonnes', 'Test modification titre colonne OK', 1, '2021-02-07 13:06:20', '2021-02-07 13:06:20', 7, 17),
(14, 'Test Déplacement Colonnes', 'Test Déplacement colonne OK\r\nTest mise à jour position colonne OK', 0, '2021-02-07 13:06:55', '2021-02-07 13:43:40', 7, 17),
(15, 'Test Del Colonne', 'Test suppression colonnes OK', 2, '2021-02-07 13:07:18', '2021-02-07 13:07:18', 7, 17),
(16, 'Test Modif titre Board', 'Test Modif titre board OK', 0, '2021-02-07 13:08:03', '2021-02-07 13:08:03', 7, 18),
(17, 'Test Del Board', 'Test suppression board OK', 1, '2021-02-07 13:08:13', '2021-02-07 13:08:13', 7, 18),
(18, 'Test Add Colonnes', 'Test ajouter colonne OK\r\nTest ajouter de colonne doublon OK', 3, '2021-02-07 13:10:37', '2021-02-07 13:10:37', 7, 17),
(19, 'conclusion des testes', 'Apres avoir refait les testes, tous me semble OK\r\nsauf oublie de ma part. :(', 0, '2021-02-07 13:11:41', '2021-02-07 13:11:41', 7, 19),
(20, 'Message', 'Petite blague pour décompresser :)\r\n\r\nSite : Créez votre mot de passe:\r\n\r\nUser : carotte\r\nSite : Désolé, votre mot de passe doit faire plus de 8 caractères\r\n\r\nUser : carrotegéante\r\nSite : Désolé, votre mot de passe doit contenir un chiffre:\r\n\r\nUser : 1carottegéante\r\nSite : Désolé, votre mot de passe ne soit pas contenir de caractère accentué:\r\n\r\nUser : 50putaindecarottesgeantes\r\nSite : Désolé, votre mot de passe doit contenir au moins une majuscule:\r\n\r\nUser : 50PUTAINdecarottesgeantes\r\nSite : Désolé, votre mot de passe ne doit pas contenir deux majuscules consécutives:\r\n\r\nUser : 50PutainDeCarottesGeantes-QueJeVaisTeMettreAuCul-SiTuNeMedonnesPas-ImmediatementUnAcces!\r\nSite : Désolé, votre mot de passe ne doit pas contenir de caractère de ponctuation:\r\n\r\nUser : AttentionMaintenantJeVaisAller-TeTrouverEtTeMettreVraiment-Les50CarottesGeantes-SiTuContinues\r\nSite : Désolé, ce mot de passe est déjà utilisé:', 0, '2021-02-07 13:14:33', '2021-02-07 14:31:09', 7, 20),
(24, 'Test Del Carte', 'Test Del Carte OK\r\nTest mise à jour position apres suppression carte OK', 1, '2021-02-07 13:53:50', '2021-02-07 14:05:49', 7, 16),
(27, 'Test Add Carte', 'Test ajout de carte OK\r\nTest ajout carte avec titre doublon OK', 2, '2021-02-07 14:05:58', '2021-02-07 14:07:17', 7, 16),
(28, 'Test Déplacement Carte', 'Test déplacement carte OK\r\nTest mise à jour position carte apres déplacement OK', 3, '2021-02-07 14:06:09', '2021-02-07 14:07:51', 7, 16);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

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
(16, 'Carte', 0, '2021-02-07 12:59:20', NULL, 6),
(17, 'Colonne', 1, '2021-02-07 12:59:27', NULL, 6),
(18, 'Board', 2, '2021-02-07 12:59:31', NULL, 6),
(19, 'Conclusion', 3, '2021-02-07 12:59:43', '2021-02-07 13:11:16', 6),
(20, 'Un Petit Mot', 4, '2021-02-07 13:14:28', NULL, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`ID`, `Body`, `CreatedAt`, `ModifiedAt`, `Author`, `Card`) VALUES
(1, 'Ceci est un commentaire', '2020-11-27 14:45:39', NULL, 5, 6),
(2, 'Voilà un autre commentaire', '2020-11-27 14:46:02', NULL, 1, 6),
(3, 'Je dirais même plus : ceci est mon commentaire', '2020-11-27 14:48:56', NULL, 3, 6);

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
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Mail` (`Mail`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`ID`, `Mail`, `FullName`, `Password`, `RegisteredAt`) VALUES
(1, 'boverhaegen@epfc.eu', 'Boris Verhaegen', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:46:19'),
(2, 'bepenelle@epfc.eu', 'Benoît Penelle', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:46:19'),
(3, 'brlacroix@epfc.eu', 'Bruno Lacroix', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:47:20'),
(4, 'xapigeolet@epfc.eu', 'Xavier Pigeolet', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-10-11 17:47:20'),
(5, 'galagaffe@epfc.eu', 'Gaston Lagaffe', '56ce92d1de4f05017cf03d6cd514d6d1', '2020-11-25 18:46:55'),
(6, 'Test@gmail.com', 'Test', 'dcdcc4617364b0d387bdc8f819a9e825', '2021-02-07 12:53:06'),
(7, 'Lucien@gmail.com', 'Lucien', '56ce92d1de4f05017cf03d6cd514d6d1', '2021-02-07 12:58:01');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
