# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.19)
# Database: twplan
# Generation Time: 2014-08-19 03:18:30 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table bug_reports
# ------------------------------------------------------------

CREATE TABLE `bug_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  `page` text,
  `error_message` text,
  `browser` text,
  `client_ip` text,
  `is_replicable` text,
  `contact_information` text,
  `user_id` int(11) DEFAULT NULL,
  `is_js` tinyint(1) DEFAULT '0',
  `is_suppressed` tinyint(1) DEFAULT '0',
  `date_submitted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table commands
# ------------------------------------------------------------

CREATE TABLE `commands` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slowest_unit` varchar(20) DEFAULT NULL,
  `village` varchar(7) DEFAULT NULL,
  `target` varchar(7) DEFAULT NULL,
  `attack_type` varchar(20) DEFAULT NULL,
  `travel_time` time DEFAULT NULL,
  `launch_datetime` datetime DEFAULT NULL,
  `launch_url` varchar(100) DEFAULT NULL,
  `plan_id` int(11) NOT NULL COMMENT 'Foreign key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table groups
# ------------------------------------------------------------

CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `world` int(2) NOT NULL,
  `villages` text COMMENT 'Stores a JSON array of village objects',
  `date_created` datetime DEFAULT NULL,
  `date_last_updated` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table plans
# ------------------------------------------------------------

CREATE TABLE `plans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `landing_datetime` datetime DEFAULT NULL,
  `world` varchar(4) DEFAULT NULL,
  `is_published` char(3) NOT NULL DEFAULT 'No',
  `published_hash` varchar(32) DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Foreign key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL DEFAULT '',
  `default_world` varchar(3) DEFAULT '72',
  `local_timezone` varchar(15) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table worlds
# ------------------------------------------------------------

CREATE TABLE `worlds` (
  `world_number` int(11) NOT NULL,
  `villages_last_updated` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `players_last_updated` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `plans` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `world_number` (`world_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/**
 * EXAMPLE VILLAGES AND PLAYERS TABLES; AUTO-GENERATED BY THE DB LOAD SCRIPTS
 */

# Dump of table villages_en73
# ------------------------------------------------------------

CREATE TABLE `villages_en73` (
  `village_id` int(11) NOT NULL,
  `village_name` varchar(100) NOT NULL,
  `x_coord` int(11) NOT NULL,
  `y_coord` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  PRIMARY KEY (`village_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table players_en73
# ------------------------------------------------------------

CREATE TABLE `players_en73` (
  `player_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `tribe_id` int(11) NOT NULL,
  PRIMARY KEY (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
