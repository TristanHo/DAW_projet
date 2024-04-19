-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 19 avr. 2024 à 13:09
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
-- Base de données : `daw_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id_cours` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `login_responsable` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cours`),
  KEY `fk_responsable` (`login_responsable`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `nom`, `login_responsable`) VALUES
(1, 'mécanique', 'BN22');

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `path` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `cours` varchar(50) NOT NULL,
  `nv_cours` int NOT NULL,
  `login_user` varchar(50) NOT NULL,
  `id_file` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`path`),
  UNIQUE KEY `id_file` (`id_file`),
  KEY `fk_login_user` (`login_user`),
  KEY `fk_cours` (`cours`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fichiers`
--

INSERT INTO `fichiers` (`path`, `type`, `cours`, `nv_cours`, `login_user`, `id_file`) VALUES
('/DAW-projet/BD/fichiers/images/photo_test-pp', 'pp', '', 0, 'photo_test', 22),
('/DAW-projet/BD/fichiers/cours/mécanique-2-0-test_méca.txt', 'cours', 'mécanique', 2, 'BN22', 36);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_topic` int NOT NULL,
  `id_message` int NOT NULL AUTO_INCREMENT,
  `contenu` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(50) NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `fk_id_topic` (`id_topic`),
  KEY `fk_msgauthor` (`author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `nom` varchar(100) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `auteur` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_topicAuthor_users` (`auteur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `mdp`, `prenom`, `nom`, `role`) VALUES
(1, 'admintest', 'adminTestmdp!', 'Jean', 'ZIDANE', 'administrateur'),
(2, 'JD21', 'jd21mdp', 'Jacques', 'DUPONT', 'etudiant'),
(3, 'BN22', 'bn22mdp', 'Noé', 'BENITO', 'professeur'),
(4, 'JD22', 'jd21mdp', 'Jacques', 'DUPONT ', 'etudiant'),
(39, 'test_ss_photo', 'photomdp', 'photo', 'TEST', 'etudiant'),
(36, 'photo_test', 'photomdp', 'test', 'PHOTO', 'etudiant');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
