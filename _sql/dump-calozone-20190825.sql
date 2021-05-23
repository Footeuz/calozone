-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 31 mai 2017 à 10:14
-- Version du serveur :  5.6.30-1
-- Version de PHP :  7.0.16-3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `calozone`
--

--
-- Structure de la table `caloz_lang`
--

CREATE TABLE `caloz_lang` (
  `id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `caloz_lang`
--

INSERT INTO `caloz_lang` (`id`, `nom`, `code`) VALUES
(1, 'Français', 'fr'),
(2, 'English', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `caloz_trad`
--

CREATE TABLE `caloz_trad` (
  `id` int(11) NOT NULL,
  `type` enum('web','mobile','api') DEFAULT NULL,
  `text` text NOT NULL COMMENT 'Clef',
  `fr` text NOT NULL COMMENT 'Français',
  `en` text NOT NULL COMMENT 'English'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Traductions';

--
-- Structure de la table `caloz_user`
--

CREATE TABLE `caloz_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `stamp_created` int(11) NOT NULL,
  `stamp_last` int(11) NOT NULL,
  `mailing_id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `genre` enum('H','F','A') NOT NULL DEFAULT 'A',
  `age` int(11) NOT NULL DEFAULT '0',
  `dep` varchar(3) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `caloz_user_admin`
--

CREATE TABLE `caloz_user_admin` (
  `id` int(11) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('admin','superadmin','customer') NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subscription_stamp_start` int(11) NOT NULL,
  `subscription_stamp_end` int(11) NOT NULL,
  `client_theme_id` int(11) NOT NULL,
  `client_logo` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `caloz_user_admin`
--

INSERT INTO `caloz_user_admin` (`id`, `login`, `password`, `active`, `email`, `status`, `name`, `url`, `subscription_stamp_start`, `subscription_stamp_end`, `client_theme_id`, `client_logo`) VALUES
(1, 'smichel', '$2y$10$jXjbwyZI8s2IQnYanDbMceFAiiGPc3YXafFSA4jjfLHriujjTdEQ2', 1, 'footeuz@gmail.com', 'superadmin', '', '', 1484262000, 1577833200, 1, '')
;
--
-- Index pour la table `caloz_lang`
--
ALTER TABLE `caloz_lang`
  ADD PRIMARY KEY (`id`);

-- Index pour la table `caloz_trad`
--
ALTER TABLE `caloz_trad`
  ADD PRIMARY KEY (`id`);

-- Index pour la table `caloz_user`
--
ALTER TABLE `caloz_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`),
  ADD KEY `mailing_id` (`mailing_id`);

--
-- Index pour la table `caloz_user_admin`
--
ALTER TABLE `caloz_user_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`),
  ADD KEY `login` (`login`),
  ADD KEY `email` (`email`),
  ADD KEY `subscription_stamp_start` (`subscription_stamp_start`),
  ADD KEY `subscription_stamp_end` (`subscription_stamp_end`),
  ADD KEY `client_theme_id` (`client_theme_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
ALTER TABLE `caloz_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
ALTER TABLE `caloz_trad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
--
--
-- AUTO_INCREMENT pour la table `caloz_user`
--
ALTER TABLE `caloz_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `caloz_user_admin`
--
ALTER TABLE `caloz_user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
