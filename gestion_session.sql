-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour gestion_session
CREATE DATABASE IF NOT EXISTS `gestion_session` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gestion_session`;

-- Listage de la structure de la table gestion_session. belong
CREATE TABLE IF NOT EXISTS `belong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFFF81BB613FECDF` (`session_id`),
  KEY `IDX_BFFF81BBAFC2B591` (`module_id`),
  CONSTRAINT `FK_BFFF81BB613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_BFFF81BBAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.belong : ~3 rows (environ)
/*!40000 ALTER TABLE `belong` DISABLE KEYS */;
INSERT INTO `belong` (`id`, `session_id`, `module_id`, `duration`) VALUES
	(3, 1, 2, 4),
	(4, 1, 1, 1),
	(5, 1, 10, 2);
/*!40000 ALTER TABLE `belong` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.categorie : ~4 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `title`, `created_at`, `updated_at`) VALUES
	(1, 'Bureautique', '2020-05-31 03:09:53', '2020-05-31 03:09:54'),
	(3, 'Infographie', '2020-05-31 03:11:00', '2020-05-31 03:11:01'),
	(4, 'Dev-Web', '2020-05-31 13:16:37', '2020-05-31 13:16:39'),
	(6, 'Danse sur clavier 1er niveau', '2020-05-31 11:44:00', '2020-05-31 11:44:00');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. migration_versions
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.migration_versions : ~10 rows (environ)
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
	('20200527151733', '2020-05-27 15:26:03'),
	('20200529145440', '2020-05-29 14:59:30'),
	('20200530014519', '2020-05-30 01:46:45'),
	('20200531010841', '2020-05-31 01:08:57'),
	('20200531134835', '2020-05-31 13:48:51'),
	('20200531140828', '2020-05-31 14:08:40'),
	('20200601120122', '2020-06-01 12:01:37'),
	('20200601123553', '2020-06-01 12:41:23'),
	('20200601124412', '2020-06-01 12:44:46'),
	('20200601154332', '2020-06-01 15:45:57');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628A21214B7` (`categories_id`),
  CONSTRAINT `FK_C242628A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.module : ~9 rows (environ)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `title`, `created_at`, `categories_id`) VALUES
	(1, 'Word', '2020-05-31 15:49:52', 1),
	(2, 'Excel', '2020-05-31 15:50:24', 1),
	(3, 'Photoshop', '2020-05-31 15:50:40', 3),
	(4, 'Illustrator', '2020-05-31 15:50:58', 3),
	(5, 'InDesign', '2020-05-31 15:51:20', 3),
	(6, 'Symfony', '2020-05-31 14:22:58', 4),
	(7, 'Java Script', '2020-05-31 14:39:24', 4),
	(8, 'Pas de droite', '2020-05-31 14:41:22', 4),
	(10, 'Outlook', '2020-06-02 02:39:08', 1);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `space_available` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.session : ~8 rows (environ)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `title`, `date_start`, `date_end`, `space_available`, `created_at`, `updated_at`) VALUES
	(1, 'Initiation Comptabilité', '2020-06-04 00:00:00', '2020-06-04 00:00:00', 8, '2020-06-01 12:42:37', '2020-06-01 14:42:41'),
	(4, 'Initiation infographie (PS, INDD, AI)', '2020-06-07 00:00:00', '2020-06-07 00:00:00', 4, '2020-06-02 02:49:46', '2020-06-02 02:49:46'),
	(5, 'Initiation à Word et Excel', '2020-06-04 00:00:00', '2020-06-04 00:00:00', 8, '2020-06-02 02:51:19', '2020-06-02 02:51:19'),
	(6, 'Perfectionnement Word Excel et Powerpoint', '2020-07-08 00:00:00', '2020-07-12 00:00:00', 6, '2020-06-02 02:57:32', '2020-06-02 02:57:32'),
	(7, 'Initiation Bureautique et infographie', '2020-07-12 00:00:00', '2020-08-07 00:00:00', 10, '2020-06-02 02:58:29', '2020-06-02 02:58:29'),
	(8, 'Initiation en PHP / SQL', '2020-09-01 00:00:00', '2020-12-12 00:00:00', 12, '2020-06-02 02:59:15', '2020-06-02 02:59:15'),
	(9, 'Test', '2020-06-04 00:00:00', '2020-06-04 00:00:00', 2, '2020-06-02 14:21:24', '2020-06-02 14:21:24'),
	(12, 'Initiation infographie (PS, INDD, AI)', '2020-06-04 00:00:00', '2020-06-04 00:00:00', 2, '2020-06-03 22:58:59', '2020-06-03 22:58:59');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` int(11) NOT NULL,
  `born` datetime NOT NULL,
  `town` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.stagiaire : ~52 rows (environ)
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `lastname`, `firstname`, `sexe`, `born`, `town`, `email`, `phone`, `created_at`, `updated_at`, `actif`, `filename`) VALUES
	(58, 'Gosgnack', 'Dani-Lee', 1, '2008-08-15 00:00:00', 'Riou', 'ninjadadar@gmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-30 16:32:14', 1, '5ed28a8f370ab208691435.jpg'),
	(59, 'Verdier', 'Corinne', 2, '2020-06-06 00:00:00', 'Chauvet-la-Forêt', 'ninjadaz@gmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-30 16:33:00', 1, '5ed28abd8c7a8111088260.jpg'),
	(60, 'Aubert', 'Alice', 1, '2007-11-20 00:00:00', 'Fleury', 'paris.alfred@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-30 16:40:28', 1, '5ed28c7cab627153501330.jpg'),
	(63, 'Torres', 'Maurice', 3, '2005-08-15 00:00:00', 'Gonzalezboeuf', 'auguste.bazin@tiscali.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-31 00:05:53', 0, '5ed2f4e26e4d2878202832.jpg'),
	(64, 'Pottier', 'Grégoire', 1, '2020-08-19 00:00:00', 'Caronnec', 'marine68@dbmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-31 20:03:08', 0, '5ed40d7d06ed9069885536.jpg'),
	(65, 'Teixeira', 'Sylvie', 3, '1959-04-01 00:00:00', 'Lecomte', 'yjacques@laposte.net', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(66, 'Louis', 'Gérard', 1, '1959-08-26 00:00:00', 'Bonneaudan', 'amelie42@bouygtel.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(67, 'Baudry', 'Catherine', 3, '2006-10-14 00:00:00', 'Camus', 'constance.berthelot@free.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(68, 'Tessier', 'Yves', 2, '2020-03-12 00:00:00', 'Marion', 'roy.martin@orange.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(69, 'Dufour', 'Margot', 3, '2020-10-10 00:00:00', 'Lacombe', 'augustin.alexandre@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(70, 'Launay', 'Alphonse', 2, '1927-10-13 22:37:32', 'Duhamelboeuf', 'nathalie.joly@free.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(71, 'Blanchard', 'Gilbert', 1, '2020-08-29 00:00:00', 'CordierVille', 'juliette84@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(72, 'Raymond', 'Tristan', 3, '1978-11-01 00:00:00', 'Marchand-sur-Mer', 'ubarthelemy@gmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(73, 'Charrier', 'Dorothée', 2, '1971-07-27 14:36:41', 'Bonneau', 'rene03@live.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(74, 'Berthelot', 'Denise', 1, '2020-01-16 00:00:00', 'Thierry', 'valentine.guilbert@club-internet.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(75, 'Bonnin', 'Noémi', 1, '2007-07-20 00:00:00', 'Mallet-les-Bains', 'dantoine@sfr.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(76, 'Bazin', 'Valérie', 3, '2013-06-19 00:00:00', 'Georges', 'perez.benjamin@free.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(77, 'Breton', 'Geneviève', 2, '1943-12-17 06:51:52', 'Aubry', 'masse.benoit@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(78, 'Valette', 'Alice', 1, '2003-10-28 19:49:19', 'Durand', 'andre.laporte@live.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(79, 'Carre', 'Océane', 1, '2013-06-17 00:00:00', 'Delannoy', 'lombard.jacqueline@live.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(80, 'Schmitt', 'Stéphane', 1, '2012-02-23 20:13:44', 'Chauvet', 'briand.francois@sfr.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(81, 'Dos Santos', 'René', 1, '2011-12-04 16:31:27', 'Collinnec', 'amelie.lecoq@hotmail.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(82, 'Rousset', 'Gérard', 3, '1999-02-04 08:18:51', 'Marion', 'hardy.charlotte@yahoo.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(83, 'Rocher', 'Aimée', 1, '1985-11-23 08:35:45', 'Rogerboeuf', 'dossantos.arnaude@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(84, 'Normand', 'Adèle', 1, '1997-07-09 11:28:24', 'Guillou', 'thibault.carlier@orange.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(85, 'Royer', 'Virginie', 2, '2010-11-11 21:01:37', 'Ribeirodan', 'grondin.nathalie@live.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(86, 'Renard', 'Émilie', 1, '1982-01-09 09:16:31', 'Bruneau', 'margot63@hotmail.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(87, 'Delmas', 'Léon', 1, '1951-02-27 10:51:49', 'Lamy', 'wcordier@noos.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(88, 'Poirier', 'Marc', 1, '1956-08-01 20:12:40', 'Delmasboeuf', 'zacharie.rey@hotmail.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(89, 'Nguyen', 'Valentine', 1, '1959-01-14 19:38:19', 'Laurentboeuf', 'hdelmas@voila.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(90, 'Teixeira', 'Marc', 2, '1993-06-15 08:21:02', 'Philippe-la-Forêt', 'alphonse71@gmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(91, 'Alexandre', 'Paul', 1, '2007-06-06 00:00:00', 'Chretien', 'philippe.riviere@club-internet.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(92, 'Bonnet', 'Rogerer', 3, '2020-01-16 00:00:00', 'Carrenec', 'bourdon.georges@dbmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(93, 'Dupre', 'Arnaude', 1, '1944-07-07 19:43:59', 'Robert', 'merle.laetitia@free.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(94, 'Tanguy', 'Constance', 1, '1978-08-07 03:40:45', 'Vasseur-sur-Hardy', 'faure.marine@hotmail.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(95, 'Thibault', 'Valérie', 1, '1968-12-28 07:06:04', 'Masson', 'idijoux@club-internet.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(96, 'Delattre', 'Alfred', 1, '1976-05-03 00:40:23', 'Gomez', 'royer.arthur@voila.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(97, 'Gomes', 'Emmanuelle', 1, '2004-08-31 03:25:52', 'Guerin', 'marcel.bruneau@bouygtel.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(98, 'Teixeira', 'Margot', 2, '2001-01-03 17:40:10', 'Moreau', 'roger56@club-internet.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(99, 'Paul', 'Marcel', 2, '1950-06-25 05:05:45', 'Clement-les-Bains', 'jacques31@laposte.net', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(100, 'Colin', 'Pénélope', 2, '1954-01-11 09:12:09', 'Colas', 'vasseur.maggie@tele2.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(101, 'Collet', 'Véronique', 1, '2017-04-12 01:10:49', 'RogerVille', 'denis21@tiscali.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(102, 'Rocher', 'Capucine', 1, '1933-04-30 04:38:52', 'Louis-sur-Riou', 'riviere.monique@laposte.net', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(103, 'Merle', 'Martine', 2, '1943-06-11 20:14:40', 'PonsBourg', 'zduhamel@gmail.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(104, 'Remy', 'Raymond', 2, '1970-04-19 01:15:13', 'Lenoir-les-Bains', 'daniel.alexandre@ifrance.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(105, 'Garnier', 'Lucy', 1, '1944-05-09 01:16:18', 'Schneider', 'oreynaud@live.com', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(106, 'Lemaire', 'Honoré', 2, '1989-03-16 15:27:29', 'Henry-sur-Picard', 'uparent@noos.fr', '0607060706', '2020-05-29 12:25:17', '2020-05-29 12:25:17', 0, ''),
	(107, 'Gosgnack', 'Jérémie', 1, '1975-03-16 00:00:00', 'KEMBS', 'jeremie@gmail.com', '0607060706', '2020-05-29 12:32:50', '2020-05-29 12:32:50', 0, ''),
	(108, 'Térieur', 'Alain', 3, '1987-01-01 00:00:00', 'STRASBOURG', 'azeerty@gmail.com', '0612341223', '2020-05-29 17:23:25', '2020-05-29 17:23:25', 1, ''),
	(110, 'MAN', 'Iron', 3, '1985-01-01 00:00:00', 'STRASBOURG', 'dzedzedz@gamil.Com', '0612341223', '2020-05-31 00:34:03', '2020-05-31 00:34:03', 1, '5ed2fb7c555f9754647076.jpg'),
	(111, 'Gosgnack', 'Lucie-Lee', 2, '2005-05-27 00:00:00', 'kembs', 'lulusmiley27@gmail.com', '0621307920', '2020-06-03 19:34:06', '2020-06-03 19:34:07', 0, '5ed7fb3030aa7163225868.jpg'),
	(112, 'Man', 'Iron', 1, '1968-01-01 00:00:00', 'STRASBOURG', 'dzedzeggrgerdz@gamil.Com', '0612341223', '2020-06-07 15:01:25', '2020-06-07 15:01:26', 0, '5edd01470d1be174120233.jpg');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table gestion_session. stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table gestion_session.stagiaire_session : ~20 rows (environ)
/*!40000 ALTER TABLE `stagiaire_session` DISABLE KEYS */;
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(58, 1),
	(58, 9),
	(58, 12),
	(60, 1),
	(60, 4),
	(60, 12),
	(66, 1),
	(67, 1),
	(67, 4),
	(71, 1),
	(74, 1),
	(74, 4),
	(75, 4),
	(76, 1),
	(76, 5),
	(91, 5),
	(91, 6),
	(92, 1),
	(111, 9),
	(112, 8);
/*!40000 ALTER TABLE `stagiaire_session` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
