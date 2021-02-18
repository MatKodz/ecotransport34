-- https://mariadb.com/kb/en/mariadb-error-codes/

-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 10, 2021 at 02:35 PM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mobilite`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_vehicule` (IN `idmodele` INT, IN `idagence` INT, OUT `idflotte` INT)  BEGIN
DECLARE EXIT HANDLER FOR SQLSTATE "23000" SELECT "Impossible";
INSERT INTO flotte VALUES (NULL,idagence,idmodele);
SELECT @@identity INTO idflotte;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `reservation` (IN `vehicule` INT, IN `agence` INT, IN `date` DATE, IN `mailU` VARCHAR(70), OUT `resanumber` MEDIUMINT)  MODIFIES SQL DATA
BEGIN
DECLARE EXIT HANDLER FOR 1452 SET resanumber = 0;
DECLARE EXIT HANDLER FOR 1644 SET resanumber = 0;
INSERT INTO location VALUES (NULL,vehicule,agence,date,NULL,NOW(),mailU);
SET resanumber = LAST_INSERT_ID();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `agence`
--

CREATE TABLE `agence` (
  `a_id` int(10) NOT NULL,
  `a_nom` varchar(30) NOT NULL,
  `a_adresse` varchar(100) NOT NULL,
  `a_ouverture` varchar(200) NOT NULL,
  `a_tel` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `a_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `agence`
--

INSERT INTO `agence` (`a_id`, `a_nom`, `a_adresse`, `a_ouverture`, `a_tel`, `a_email`) VALUES
(1, 'Agence Occitanie', 'Av du Doyen Gaston Giraud - Montpellier', 'a:7:{s:5:\"Lundi\";s:6:\"9h-17h\";s:5:\"Mardi\";s:6:\"9h-17h\";s:8:\"Mercredi\";s:6:\"9h-17h\";s:5:\"Jeudi\";s:6:\"9h-17h\";s:8:\"Vendredi\";s:6:\"9h-17h\";s:6:\"Samedi\";s:6:\"Fermé\";s:8:\"Dimanche\";s:6:\"Fermé\";}', 0467121416, 'occitanie@eco-transport34.fr'),
(2, 'Agence Gare', 'rue de Maguelone - Montpellier', 'a:7:{s:5:\"Lundi\";s:6:\"9h-17h\";s:5:\"Mardi\";s:6:\"9h-17h\";s:8:\"Mercredi\";s:6:\"9h-17h\";s:5:\"Jeudi\";s:6:\"9h-17h\";s:8:\"Vendredi\";s:6:\"9h-17h\";s:6:\"Samedi\";s:6:\"9h-12h\";s:8:\"Dimanche\";s:6:\"9h-12h\";}', 0467100806, 'gare@eco-transport34.fr'),
(3, 'Agence Mosson', 'rue Peter Benenson - Montpellier', 'a:7:{s:5:\"Lundi\";s:6:\"9h-18h\";s:5:\"Mardi\";s:6:\"9h-18h\";s:8:\"Mercredi\";s:6:\"9h-18h\";s:5:\"Jeudi\";s:6:\"9h-18h\";s:8:\"Vendredi\";s:6:\"9h-18h\";s:6:\"Samedi\";s:6:\"Fermé\";s:8:\"Dimanche\";s:6:\"Fermé\";}', 0467020406, 'mosson@eco-transport34.fr'),
(4, 'Agence Odysseum', 'avenue Georges Mélies - Montpellier', 'a:7:{s:5:\"Lundi\";s:6:\"9h-17h\";s:5:\"Mardi\";s:6:\"9h-17h\";s:8:\"Mercredi\";s:6:\"9h-17h\";s:5:\"Jeudi\";s:6:\"9h-17h\";s:8:\"Vendredi\";s:6:\"9h-17h\";s:6:\"Samedi\";s:6:\"9h-16h\";s:8:\"Dimanche\";s:6:\"Fermé\";}', 0467646870, 'odysseum@eco-transport34.fr'),
(5, 'Agence Antigone', 'Avenue Jacques Cartier - Montpellier', 'a:7:{s:5:\"Lundi\";s:6:\"9h-17h\";s:5:\"Mardi\";s:6:\"9h-17h\";s:8:\"Mercredi\";s:6:\"9h-17h\";s:5:\"Jeudi\";s:6:\"9h-17h\";s:8:\"Vendredi\";s:6:\"9h-17h\";s:6:\"Samedi\";s:6:\"Fermé\";s:8:\"Dimanche\";s:6:\"Fermé\";}', 0467808284, 'antigone@eco-transport34.fr');

-- --------------------------------------------------------

--
-- Table structure for table `flotte`
--

CREATE TABLE `flotte` (
  `v_id` int(10) NOT NULL,
  `agence_id` int(2) NOT NULL,
  `modele_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flotte`
--

INSERT INTO `flotte` (`v_id`, `agence_id`, `modele_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 1),
(8, 2, 2),
(9, 2, 3),
(10, 2, 4),
(11, 2, 5),
(12, 2, 6),
(13, 3, 1),
(14, 3, 2),
(15, 3, 3),
(16, 3, 4),
(17, 3, 5),
(18, 3, 6),
(19, 4, 1),
(20, 4, 2),
(21, 4, 3),
(22, 4, 4),
(23, 4, 5),
(24, 4, 6),
(25, 5, 1),
(26, 5, 2),
(27, 5, 3),
(28, 5, 4),
(29, 5, 5),
(30, 5, 6),
(31, 1, 1);

--
-- Triggers `flotte`
--
DELIMITER $$
CREATE TRIGGER `check_vehicule_before_delete` BEFORE DELETE ON `flotte` FOR EACH ROW BEGIN
IF EXISTS (SELECT l_id FROM location WHERE l_id_vehicule = OLD.v_id)
	THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = "Suppression impossible du véhicule";
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `l_id` int(6) NOT NULL,
  `l_id_vehicule` int(11) NOT NULL,
  `l_id_agence` int(11) NOT NULL,
  `l_debut` date NOT NULL,
  `l_fin` date DEFAULT NULL,
  `l_creation` datetime DEFAULT NULL,
  `l_user_mail` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`l_id`, `l_id_vehicule`, `l_id_agence`, `l_debut`, `l_fin`, `l_creation`, `l_user_mail`) VALUES
(244, 25, 5, '2021-01-08', NULL, '2021-01-06 15:17:23', 'coucou@ht.gt'),
(245, 28, 5, '2021-01-07', NULL, '2021-01-06 15:22:45', 'coucou@fr.fr'),
(246, 29, 5, '2021-01-07', NULL, '2021-01-06 15:23:54', 'coucou@fr.fr'),
(247, 14, 3, '2021-01-06', NULL, '2021-01-06 15:24:30', 'ol@lo.fr'),
(248, 13, 3, '2021-01-10', NULL, '2021-01-06 15:25:15', 'coucou@ht.gt'),
(249, 13, 3, '2021-01-11', NULL, '2021-01-06 15:25:30', 'coucou@ht.gt'),
(251, 30, 5, '2021-01-11', NULL, '2021-01-07 10:51:19', 'salut@ok.fr'),
(252, 13, 3, '2021-01-08', NULL, '2021-01-07 11:09:23', 'rrrr@lol.fr'),
(253, 27, 5, '2021-01-08', NULL, '2021-01-07 11:25:06', 'jjjj@lol.fr'),
(254, 30, 5, '2021-01-24', NULL, '2021-01-07 11:29:08', 'mathieu@lol.fr'),
(255, 25, 5, '2021-02-12', NULL, '2021-02-09 15:40:48', 'jjjj@lol.fr'),
(256, 31, 1, '2021-02-09', NULL, '2021-02-09 16:15:25', 'coucou@ht.gt');

--
-- Triggers `location`
--
DELIMITER $$
CREATE TRIGGER `check_existed_reservation` BEFORE INSERT ON `location` FOR EACH ROW BEGIN
 IF EXISTS (SELECT  * FROM location WHERE NEW.l_debut = l_debut and NEW.l_id_vehicule = l_id_vehicule)
	THEN SIGNAL SQLSTATE '45000'
	SET MESSAGE_TEXT = "Réservation impossible";
  ELSEIF NEW.l_debut < CURDATE()
  THEN SIGNAL SQLSTATE '45000'
  SET MESSAGE_TEXT = "Réservation annulée";
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `materiel_roulant`
--

CREATE TABLE `materiel_roulant` (
  `m_id` int(10) NOT NULL,
  `m_nom` varchar(30) NOT NULL,
  `m_autonomie` tinyint(2) DEFAULT NULL,
  `m_nbroue` set('1','2') NOT NULL,
  `m_electrique` set('oui','non') NOT NULL,
  `m_prix_location_jour` smallint(2) NOT NULL,
  `m_vignette` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `materiel_roulant`
--

INSERT INTO `materiel_roulant` (`m_id`, `m_nom`, `m_autonomie`, `m_nbroue`, `m_electrique`, `m_prix_location_jour`, `m_vignette`) VALUES
(1, 'Gyropode', 3, '2', 'oui', 20, 'medias/gyropode-500px.jpg'),
(2, 'Gyroroue', 2, '1', 'oui', 18, 'medias/gyroroue-500px.jpg'),
(3, 'Hoverboard', 1, '2', 'oui', 15, 'medias/hoverboard-500px.jpg'),
(4, 'Trottinette électrique', 3, '2', 'oui', 14, 'medias/trotinette-500px.jpg'),
(5, 'Vélo', NULL, '2', 'non', 12, 'medias/velo-ville-500px.jpg'),
(6, 'Vélo électrique', 4, '2', 'oui', 25, 'medias/velo-electrique-500px.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `flotte`
--
ALTER TABLE `flotte`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `vehicule_id` (`modele_id`),
  ADD KEY `agence_id` (`agence_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`l_id`),
  ADD KEY `l_id_agence` (`l_id_agence`),
  ADD KEY `location_ibfk_1` (`l_id_vehicule`);

--
-- Indexes for table `materiel_roulant`
--
ALTER TABLE `materiel_roulant`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agence`
--
ALTER TABLE `agence`
  MODIFY `a_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `flotte`
--
ALTER TABLE `flotte`
  MODIFY `v_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `l_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;
--
-- AUTO_INCREMENT for table `materiel_roulant`
--
ALTER TABLE `materiel_roulant`
  MODIFY `m_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `flotte`
--
ALTER TABLE `flotte`
  ADD CONSTRAINT `flotte_ibfk_1` FOREIGN KEY (`modele_id`) REFERENCES `materiel_roulant` (`m_id`),
  ADD CONSTRAINT `flotte_ibfk_2` FOREIGN KEY (`agence_id`) REFERENCES `agence` (`a_id`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`l_id_vehicule`) REFERENCES `flotte` (`v_id`),
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`l_id_agence`) REFERENCES `agence` (`a_id`);
