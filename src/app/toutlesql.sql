-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 22 sep. 2023 à 14:14
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SA`
--

-- --------------------------------------------------------

--
-- Structure de la table `archiveprob`
--

CREATE TABLE `archiveprob` (
  `idp` int(11) NOT NULL,
  `mail` text NOT NULL,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL,
  `produit` text NOT NULL,
  `description` text NOT NULL,
  `fichier` text NOT NULL,
  `statut` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `archiveprob`
--

INSERT INTO `archiveprob` (`idp`, `mail`, `datedebut`, `datefin`, `produit`, `description`, `fichier`, `statut`) VALUES
(35, 'alanohayon@gmail.com', '2022-03-03', '2022-03-04', 'ordinateur', 'ezfarfzae', '', 'Termine');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `mail` text NOT NULL,
  `mdp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `mail`, `mdp`) VALUES
(1, 'ohayon', 'alan', 'alanohayon@gmail.com', 'alan'),
(2, 'Jon', 'Snow', 'castle@black.net', 'jon'),
(4, 'Heisenberg', 'Werner', 'wernerd@gmail.com', 'werner'),
(5, 'Carlsen', 'Magnus', 'magnusmate@gmail.com', 'magnus'),
(6, 'Norris', 'Lando', 'chuck@yahoo.fr', 'chuck'),
(7, 'AZEE', 'ERA', 'alanohayon@gmail.com', 'OP');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `idm` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `expediteur` varchar(20) NOT NULL,
  `destinataire` varchar(20) NOT NULL,
  `message` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`idm`, `date`, `expediteur`, `destinataire`, `message`) VALUES
(1, '0000-00-00 00:00:00', 'Paul H.', 'Chris J.', 'je suis tres content de votre travail'),
(2, '0000-00-00 00:00:00', 'Idriss A.', 'Greg', 'Votre ordinateur peut désormais s\'allumer'),
(3, '0000-00-00 00:00:00', 'Raph. E.', 'Yohann V.', 'La cafetiere de votre salle de bain est insolente'),
(13, '2023-03-26 00:13:24', 'alan', 'hillel', 'e'),
(14, '2023-03-26 00:13:48', 'alan', 'Alex', 'e'),
(15, '2023-03-26 00:13:53', 'alan', 'hillel', 'e'),
(16, '2023-03-26 00:21:11', 'alan', 'hillel', 'e'),
(17, '2023-03-26 00:24:46', 'alan', 'hillel', 'bojour les pd'),
(18, '2023-03-26 01:54:56', 'alan', 'hillel', 'e');

-- --------------------------------------------------------

--
-- Structure de la table `probleme`
--

CREATE TABLE `probleme` (
  `idp` int(11) NOT NULL,
  `mail` text NOT NULL,
  `date` datetime NOT NULL,
  `produit` text NOT NULL,
  `description` text NOT NULL,
  `fichier` text NOT NULL,
  `technicien` text NOT NULL,
  `statut` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `probleme`
--

INSERT INTO `probleme` (`idp`, `mail`, `date`, `produit`, `description`, `fichier`, `technicien`, `statut`) VALUES
(34, 'rick@morty.fr', '2022-03-02 23:51:45', 'Cafetiere', 'ma cafetiere fais du sirop de grenadine', '', 'Theo, ursul', 'Termine'),
(36, 'greg@greg.fr', '2022-03-09 00:08:40', 'Ordinateur HP', 'La carte graphique crée un faux contact avec le processeur.', '', 'Boudet, Alex, Theo, Hector', 'Termine'),
(37, 'jon@gmail.com', '2022-03-09 20:08:08', 'ordinateur', 'gfuuhhgliyv', 'azerty', 'Theo, casper', 'Termine'),
(38, 'jon@gmail.com', '2022-03-09 20:08:17', 'ordinateur', 'zadtyfzdau', 'azerty', 'casper', 'En cours'),
(39, 'alanohayon@gmail.com', '2023-03-26 00:24:22', 'Caftiere', 'caftiere probleme', 'Victor.jpg', 'Theo', 'En cours'),
(40, 'alanohayon@gmail.com', '2023-07-09 16:54:38', 'ordinateur', 'YESHLI UN PROBLEME', 'IMG_0395.HEIC', '', 'En attente'),
(41, 'alanohayon@gmail.com', '2023-09-22 15:43:25', 'Caftiere', 'klnio\"f', '', 'Theo', 'Termine');

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

CREATE TABLE `responsable` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `mail` text NOT NULL,
  `mdp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id`, `nom`, `prenom`, `mail`, `mdp`) VALUES
(1, 'ohayon', 'eliel', 'eliel@gmail.com', 'eliel'),
(2, 'Bacques', 'Maude', 'maudepasselebac@gmail.com', 'maude'),
(3, 'Kaplan', 'Laura', 'laurakaplan@gmail.com', 'laura'),
(4, 'Pichard', 'Dorothee', 'doropichard@gmail.com', 'dorothee'),
(5, 'Bourgeois', 'Agathe', 'alagath@protonmail.com', 'agathe'),
(6, 'Trottier', 'Carla', 'carla_garfield@gmail.com', 'carla'),
(7, 'Chevalier', 'Mathilde', 'mathilde_chevalier@tableronde.fr', 'mathilde');

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

CREATE TABLE `technicien` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `mail` text NOT NULL,
  `mdp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `technicien`
--

INSERT INTO `technicien` (`id`, `nom`, `prenom`, `mail`, `mdp`) VALUES
(1, 'ohayon', 'hillel', 'hillel@gmail.com', 'hillel'),
(2, 'Picasso', 'Pablo', 'pablo@picasso.fr', 'pablo'),
(3, 'Regnard', 'Theo', 'theoregnard@gmail.com', 'theo'),
(4, 'Renaudin', 'Alex', 'alexrenaudin_lefoufou@gmail.com', 'alex'),
(5, 'Jean-Noel', 'Boudet', 'jn_boudet@gmail.com', 'jean-noel'),
(6, 'Masson', 'Basile', 'basilemasson@gmail.com', 'basile');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idm`);

--
-- Index pour la table `probleme`
--
ALTER TABLE `probleme`
  ADD PRIMARY KEY (`idp`);

--
-- Index pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `idm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `probleme`
--
ALTER TABLE `probleme`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `technicien`
--
ALTER TABLE `technicien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
