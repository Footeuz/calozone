-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 25 Mai 2021 à 19:06
-- Version du serveur :  10.1.48-MariaDB-0+deb9u2
-- Version de PHP :  7.2.28-1+0~20200220.36+debian9~1.gbpcf4a75

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `bOuTlQU3aLf0Rm3`
--

-- --------------------------------------------------------

--
-- Structure de la table `caloz_menu`
--

CREATE TABLE `caloz_menu` (
  `id` int(8) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `caloz_menu_item`
--

CREATE TABLE `caloz_menu_item` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link_url` varchar(255) NOT NULL,
  `page_id` int(8) NOT NULL DEFAULT '0',
  `categoryproduct_id` int(8) NOT NULL,
  `blank` int(11) NOT NULL DEFAULT '0' COMMENT 'link should open on blank page or not',
  `menu_id` int(8) NOT NULL,
  `position` int(8) NOT NULL,
  `parent_id` int(8) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `caloz_menu`
--
ALTER TABLE `caloz_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`);

--
-- Index pour la table `caloz_menu_item`
--
ALTER TABLE `caloz_menu_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `position` (`position`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `categoryproduct_id` (`categoryproduct_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `caloz_menu`
--
ALTER TABLE `caloz_menu`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `caloz_menu_item`
--
ALTER TABLE `caloz_menu_item`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;