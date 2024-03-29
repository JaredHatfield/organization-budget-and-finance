-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.36-community-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema budget
--

CREATE DATABASE IF NOT EXISTS budget;
USE budget;

--
-- Definition of table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_distinct` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Definition of table `documentation`
--
DROP TABLE IF EXISTS `documentation`;
CREATE TABLE `documentation` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  `lineitem` INTEGER UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `link` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_documentation_lineitem` FOREIGN KEY `FK_documentation_lineitem` (`lineitem`)
    REFERENCES `lineitem` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Definition of table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE `form` (
  `key` varchar(50) NOT NULL,
  `expires` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL,
  `pk` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`key`),
  KEY `Index_form_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `funds`
--

DROP TABLE IF EXISTS `funds`;
CREATE TABLE `funds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lineitem` int(10) unsigned NOT NULL,
  `source` int(10) unsigned NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_distinct` (`lineitem`,`source`),
  KEY `FK_funds_source` (`source`),
  CONSTRAINT `FK_funds_lineitem` FOREIGN KEY (`lineitem`) REFERENCES `lineitem` (`id`),
  CONSTRAINT `FK_funds_source` FOREIGN KEY (`source`) REFERENCES `source` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Definition of table `lineitem`
--

DROP TABLE IF EXISTS `lineitem`;
CREATE TABLE `lineitem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_lineitem_parent` (`parent`),
  CONSTRAINT `FK_lineitem_parent` FOREIGN KEY (`parent`) REFERENCES `lineitem` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lineitem`
--

/*!40000 ALTER TABLE `lineitem` DISABLE KEYS */;
INSERT INTO `lineitem` (`id`,`name`,`description`,`parent`,`public`) VALUES 
 (1,'Root','Root',1,1);
/*!40000 ALTER TABLE `lineitem` ENABLE KEYS */;


--
-- Definition of table `receipt`
--

DROP TABLE IF EXISTS `receipt`;
CREATE TABLE `receipt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `company` int(10) unsigned NOT NULL,
  `amount` double NOT NULL,
  `lineitem` int(10) unsigned NOT NULL,
  `rdate` date NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_receipt_lineitem` (`lineitem`),
  KEY `FK_receipt_company` (`company`),
  CONSTRAINT `FK_receipt_company` FOREIGN KEY (`company`) REFERENCES `company` (`id`),
  CONSTRAINT `FK_receipt_lineitem` FOREIGN KEY (`lineitem`) REFERENCES `lineitem` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Definition of table `source`
--

DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `public` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_distinct` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` char(40) NOT NULL,
  `group` varchar(45) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`username`,`password`,`group`,`active`) VALUES 
 (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','Administrator',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
