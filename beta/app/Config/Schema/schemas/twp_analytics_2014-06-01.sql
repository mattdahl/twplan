# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.12)
# Database: twp_analytics
# Generation Time: 2014-06-01 23:44:03 +0000
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
  `is_replicable` text,
  `contact_information` text,
  `user_id` int(11) DEFAULT NULL,
  `is_js` tinyint(1) DEFAULT '0',
  `date_submitted` datetime DEFAULT NULL,
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




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
