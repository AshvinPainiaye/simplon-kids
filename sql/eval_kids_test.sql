-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Mai 2017 à 09:54
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `eval_kids`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `address`
--

INSERT INTO `address` (`id`, `address`, `complement`, `city`, `zipcode`) VALUES
(1, '15 rue des saphirs', '', 'Sainte-Suzanne', '97441'),
(2, '10 rue des goyave', '', 'Saint-Denis', '97400'),
(3, 'Avenue des letchi', '', 'Saint-Pierre', '97410'),
(4, 'Rue des kebab', 'chemin 4', 'Saint-André', '97490'),
(5, '15 rue des saphirs quartier français', '15 rue des saphirs quartier français', 'Sainte Suzanne', '97441');

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3');

-- --------------------------------------------------------

--
-- Structure de la table `establishment`
--

CREATE TABLE `establishment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `establishment`
--

INSERT INTO `establishment` (`id`, `name`, `address_id`) VALUES
(1, 'College Quartier Francais', 2),
(2, 'College Lucet', 3),
(3, 'Ecole 2 canon', 4);

-- --------------------------------------------------------

--
-- Structure de la table `kid`
--

CREATE TABLE `kid` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `classroom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `kid`
--

INSERT INTO `kid` (`id`, `firstname`, `lastname`, `birthday`, `classroom`) VALUES
(1, 'John', 'Doe', '2008-02-19', 'CM2'),
(2, 'Ashvin', 'PAINIAYE', '2009-05-06', 'CM2');

-- --------------------------------------------------------

--
-- Structure de la table `kid_has_parent`
--

CREATE TABLE `kid_has_parent` (
  `kid_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `kid_has_parent`
--

INSERT INTO `kid_has_parent` (`kid_id`, `parent_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `parent`
--

CREATE TABLE `parent` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `parent`
--

INSERT INTO `parent` (`id`, `firstname`, `lastname`, `email`, `address_id`, `phone`) VALUES
(1, 'Jane', 'Doe', 'jane@doe.com', 1, '+262692123456'),
(2, 'Ashvin', 'PAINIAYE', 'contact@ashvinpainiaye.com', 5, '0692162099');

-- --------------------------------------------------------

--
-- Structure de la table `public_age`
--

CREATE TABLE `public_age` (
  `id` int(11) NOT NULL,
  `start` int(3) NOT NULL,
  `end` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `public_age`
--

INSERT INTO `public_age` (`id`, `start`, `end`) VALUES
(1, 1, 18),
(2, 10, 18),
(3, 8, 13),
(4, 4, 9),
(5, 10, 15);

-- --------------------------------------------------------

--
-- Structure de la table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `startAt` datetime NOT NULL,
  `endAt` datetime NOT NULL,
  `enable` tinyint(4) DEFAULT NULL,
  `workshop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `timetable`
--

INSERT INTO `timetable` (`id`, `startAt`, `endAt`, `enable`, `workshop_id`) VALUES
(1, '2017-05-09 08:30:00', '2017-05-09 16:30:00', 1, 1),
(2, '2017-05-21 11:30:00', '2017-05-21 15:30:00', NULL, 2),
(3, '2017-06-07 08:00:00', '2017-06-07 18:00:00', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `workshop`
--

CREATE TABLE `workshop` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `max_kids` int(3) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `visible` tinyint(4) DEFAULT NULL,
  `public_age_id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `workshop_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `workshop`
--

INSERT INTO `workshop` (`id`, `title`, `description`, `price`, `max_kids`, `image`, `visible`, `public_age_id`, `establishment_id`, `workshop_category_id`) VALUES
(1, 'HTML', 'Debuter en html', '10.00', 18, '1.jpg', 1, 1, 1, 1),
(2, 'CSS', 'Ateliers css', '20.00', 15, '14944840290.jpg', 1, 2, 1, 3),
(3, 'Code academy', 'code academy !!!!', '69.00', 30, '14944840972.jpg', 1, 4, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `workshop_category`
--

CREATE TABLE `workshop_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `workshop_category`
--

INSERT INTO `workshop_category` (`id`, `name`) VALUES
(1, 'ART'),
(2, 'Jeux video'),
(3, 'Detente'),
(4, 'Logique');

-- --------------------------------------------------------

--
-- Structure de la table `workshop_has_kid`
--

CREATE TABLE `workshop_has_kid` (
  `workshop_id` int(11) NOT NULL,
  `kid_id` int(11) NOT NULL,
  `has_participated` tinyint(4) DEFAULT NULL,
  `validated` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `workshop_has_kid`
--

INSERT INTO `workshop_has_kid` (`workshop_id`, `kid_id`, `has_participated`, `validated`) VALUES
(1, 1, NULL, 1),
(1, 2, NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_establishment_address1` (`address_id`);

--
-- Index pour la table `kid`
--
ALTER TABLE `kid`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `kid_has_parent`
--
ALTER TABLE `kid_has_parent`
  ADD PRIMARY KEY (`kid_id`,`parent_id`),
  ADD KEY `fk_kid_has_parent_parent1` (`parent_id`);

--
-- Index pour la table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parent_address1` (`address_id`);

--
-- Index pour la table `public_age`
--
ALTER TABLE `public_age`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_timetable_workshop1` (`workshop_id`);

--
-- Index pour la table `workshop`
--
ALTER TABLE `workshop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_workshop_public_age` (`public_age_id`),
  ADD KEY `fk_workshop_establishment1` (`establishment_id`),
  ADD KEY `fk_workshop_workshop_category1` (`workshop_category_id`);

--
-- Index pour la table `workshop_category`
--
ALTER TABLE `workshop_category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `workshop_has_kid`
--
ALTER TABLE `workshop_has_kid`
  ADD PRIMARY KEY (`workshop_id`,`kid_id`),
  ADD KEY `fk_workshop_has_kid_kid1` (`kid_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `kid`
--
ALTER TABLE `kid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `parent`
--
ALTER TABLE `parent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `public_age`
--
ALTER TABLE `public_age`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `workshop`
--
ALTER TABLE `workshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `workshop_category`
--
ALTER TABLE `workshop_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `establishment`
--
ALTER TABLE `establishment`
  ADD CONSTRAINT `fk_establishment_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `kid_has_parent`
--
ALTER TABLE `kid_has_parent`
  ADD CONSTRAINT `fk_kid_has_parent_kid1` FOREIGN KEY (`kid_id`) REFERENCES `kid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kid_has_parent_parent1` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `fk_parent_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `fk_timetable_workshop1` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `workshop`
--
ALTER TABLE `workshop`
  ADD CONSTRAINT `fk_workshop_establishment1` FOREIGN KEY (`establishment_id`) REFERENCES `establishment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workshop_public_age` FOREIGN KEY (`public_age_id`) REFERENCES `public_age` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workshop_workshop_category1` FOREIGN KEY (`workshop_category_id`) REFERENCES `workshop_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `workshop_has_kid`
--
ALTER TABLE `workshop_has_kid`
  ADD CONSTRAINT `fk_workshop_has_kid_kid1` FOREIGN KEY (`kid_id`) REFERENCES `kid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_workshop_has_kid_workshop1` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
