-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 03 avr. 2024 à 13:54
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `DAW_Project`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `mdp`, `prenom`, `nom`, `role`) VALUES
(1, 'admintest', 'adminTestmdp!', 'Jean', 'ZIDANE', 'administrateur'),
(2, 'JD21', 'jd21mdp', 'Jacques', 'DUPONT', 'etudiant'),
(3, 'BN22', 'bn22mdp', 'Noé', 'BENITO', 'professeur'),
(4, 'JD22', 'jd21mdp', 'Jacques', 'DUPONT ', 'etudiant');
COMMIT;

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `nom` int NOT NULL AUTO_INCREMENT,
  `login_responsable` varchar(50) NOT NULL,
  PRIMARY KEY (`cours`),
  KEY `fk_login_responsable` (`login_responsable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

CREATE TABLE `Topic`(
  `nom` VARCHAR(100) NOT NULL,
  CONSTRAINT `fk_topic_cours` FOREIGN KEY `nom` REFERENCES cours(`nom`), /*identifiant reliant topic au cours | On ne pourra insérer qu'un topic dont le nom figure dans la table cours*/
  `titre` VARCHAR(200) NOT NULL DEFAULT `titre topic`,
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `auteur` VARCHAR(50) NOT NULL,
  CONSTRAINT `fk_topicAuthor_users` FOREIGN KEY `auteur` REFERENCES utilisateurs(`login`) /*l'auteur d'un topic doit figurer dans la table utilisateur*/
);

CREATE TABLE `Messages`(
  `id_topic` INTEGER UNSIGNED NOT NULL,
  CONSTRAINT `fk_message_topic`FOREIGN KEY `id_topic` REFERENCES Topic(`nom`),
  `id_message` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `contenu` VARCHAR(500) NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` VARCHAR(50) NOT NULL,
  CONSTRAINT `fk_msgauthor_users` FOREIGN KEY `author` REFERENCES utilisateurs(`login`)
);

DROP TABLE IF EXISTS `cours_valider`;
CREATE TABLE IF NOT EXISTS `cours_valider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomcours` varchar(40) NOT NULL,
  `lv` int NOT NULL,
  `login` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- ajouter les clé etrangere
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
