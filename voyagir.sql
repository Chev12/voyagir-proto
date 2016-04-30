-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `activity_commitment`;
CREATE TABLE `activity_commitment` (
  `activity_type` int(11) unsigned NOT NULL,
  `commitment` int(11) unsigned NOT NULL,
  PRIMARY KEY (`activity_type`,`commitment`),
  KEY `commitment` (`commitment`),
  CONSTRAINT `activity_commitment_ibfk_1` FOREIGN KEY (`activity_type`) REFERENCES `activity_type` (`id`),
  CONSTRAINT `activity_commitment_ibfk_2` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity_commitment` (`activity_type`, `commitment`) VALUES
(1,	2),
(1,	3);

DROP TABLE IF EXISTS `activity_type`;
CREATE TABLE `activity_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `activity_type` (`id`, `name`) VALUES
(1,	'Engaged Fishing'),
(2,	'Hunting'),
(3,	'Kayak'),
(4,	'Snorkeling'),
(5,	'Dive');

DROP TABLE IF EXISTS `base_user`;
CREATE TABLE `base_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1BF018B992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1BF018B9A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `base_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`) VALUES
(1,	'mat',	'mat',	'erfmath@gmail.com',	'erfmath@gmail.com',	1,	'c4jemskjbzwc0s08woogc04kss8s84k',	'$2y$13$c4jemskjbzwc0s08woogcuQoJzRg7.lKvdrJlrCfiuoXHgyPlF1..',	'2016-04-30 14:34:07',	0,	0,	NULL,	NULL,	NULL,	'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',	0,	NULL),
(2,	'mat2',	'mat2',	'erfmath@orange.Fr',	'erfmath@orange.fr',	1,	'htbapp711b4ks8skgsskkwskwsc4408',	'$2y$13$htbapp711b4ks8skgsskkuMUMH5RsSin1qnQg6itlgwRUAW7CLCEa',	'2015-11-19 20:17:25',	0,	0,	NULL,	NULL,	NULL,	'a:0:{}',	0,	NULL),
(3,	'test',	'test',	'test@gmail.com',	'test@gmail.com',	1,	'no6z49fdmio44ggg8cs40g4g8wkw0c8',	'$2y$13$no6z49fdmio44ggg8cs40ePqRk1SNifUEv4/1IfSY13ovWJJDxvKK',	'2016-04-15 12:35:23',	0,	0,	NULL,	NULL,	NULL,	'a:0:{}',	0,	NULL);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `limit_inf` int(11) unsigned NOT NULL,
  `limit_sup` int(11) unsigned NOT NULL,
  `level` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `limits` (`limit_inf`,`limit_sup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `category` (`id`, `limit_inf`, `limit_sup`, `level`, `name`, `description`) VALUES
(1,	0,	1,	0,	'Etablissement',	'Catégorie racine');

DROP TABLE IF EXISTS `category_commitment`;
CREATE TABLE `category_commitment` (
  `commitment` int(11) unsigned NOT NULL,
  `category` int(11) unsigned NOT NULL,
  PRIMARY KEY (`commitment`,`category`),
  KEY `category` (`category`),
  CONSTRAINT `category_commitment_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `category_commitment_ibfk_1` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `comment_establishment`;
CREATE TABLE `comment_establishment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` int(11) unsigned NOT NULL,
  `user` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_com_etb_user` (`user`),
  KEY `establishment` (`establishment`),
  CONSTRAINT `comment_establishment_ibfk_1` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `fk_com_etb_user` FOREIGN KEY (`user`) REFERENCES `base_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `commitment`;
CREATE TABLE `commitment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `commitment` (`id`, `icon`, `description`) VALUES
(1,	'Test',	'Tri des déchets'),
(2,	'Test',	'Développement durable'),
(3,	'Test',	'Doux foyer');

DROP TABLE IF EXISTS `commitment_question`;
CREATE TABLE `commitment_question` (
  `id` int(11) unsigned NOT NULL,
  `commitment` int(11) unsigned NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) unsigned NOT NULL,
  `level` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commitment_order` (`commitment`,`level`),
  CONSTRAINT `commitment_question_ibfk_2` FOREIGN KEY (`commitment`) REFERENCES `commitment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `establishment`;
CREATE TABLE `establishment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID de l''établissement',
  `user_owner` int(11) NOT NULL COMMENT 'Propriétaire de l''établissement',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nom de l''établissement',
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Description de l''établissement',
  `adress` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Adresse de l''établissement',
  `category` int(11) unsigned NOT NULL COMMENT 'Catégorie d''établissement',
  PRIMARY KEY (`id`),
  KEY `id_user` (`user_owner`),
  KEY `category` (`category`),
  CONSTRAINT `establishment_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `fk_establishment_user` FOREIGN KEY (`user_owner`) REFERENCES `base_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Etablissement touristique';

INSERT INTO `establishment` (`id`, `user_owner`, `name`, `description`, `adress`, `category`) VALUES
(8,	1,	'Chez oim',	'C\'est d\'la balle',	'35 rue des Champions',	1),
(9,	3,	'Etablissement de test',	'test',	'404 rue des Tests',	1);

DROP TABLE IF EXISTS `establishment_activity`;
CREATE TABLE `establishment_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `establishment` int(11) unsigned NOT NULL,
  `activity_type` int(11) unsigned NOT NULL DEFAULT '0',
  `description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `price` int(11) DEFAULT NULL,
  `level` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `establishment_order` (`establishment`,`level`),
  KEY `activity_type` (`activity_type`),
  CONSTRAINT `establishment_activity_ibfk_2` FOREIGN KEY (`activity_type`) REFERENCES `activity_type` (`id`),
  CONSTRAINT `establishment_activity_ibfk_3` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table des activités touristiques';

INSERT INTO `establishment_activity` (`id`, `establishment`, `activity_type`, `description`, `price`, `level`) VALUES
(1,	8,	1,	'Venez pêchez !',	100,	1);

DROP TABLE IF EXISTS `establishment_label`;
CREATE TABLE `establishment_label` (
  `label` int(11) unsigned NOT NULL,
  `establishment` int(11) unsigned NOT NULL,
  PRIMARY KEY (`label`,`establishment`),
  KEY `establishment` (`establishment`),
  CONSTRAINT `establishment_label_ibfk_1` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `establishment_label_ibfk_2` FOREIGN KEY (`label`) REFERENCES `label` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `label`;
CREATE TABLE `label` (
  `id` int(11) unsigned NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_answer`;
CREATE TABLE `user_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `establishment` int(11) unsigned NOT NULL,
  `question` int(11) unsigned NOT NULL,
  `answer` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `establishment` (`establishment`),
  KEY `user` (`user`),
  KEY `question_id` (`question`),
  CONSTRAINT `user_answer_ibfk_2` FOREIGN KEY (`user`) REFERENCES `base_user` (`id`),
  CONSTRAINT `user_answer_ibfk_3` FOREIGN KEY (`establishment`) REFERENCES `establishment` (`id`),
  CONSTRAINT `user_answer_ibfk_4` FOREIGN KEY (`question`) REFERENCES `commitment_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2016-04-30 14:11:36
