SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `accounting` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `accounting`;

CREATE TABLE IF NOT EXISTS `buh_account` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `buh_category` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `buh_comment_payment` (
  `transaction_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `buh_operation` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `buh_operation` (`id`, `name`) VALUES
(1, 'Приход'),
(2, 'Расход');

CREATE TABLE IF NOT EXISTS `buh_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` tinyint(3) unsigned NOT NULL,
  `operations` tinyint(2) unsigned NOT NULL,
  `category` tinyint(3) unsigned NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `date_operations` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `operations` (`operations`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(10,2) NOT NULL,
  `payment_category` tinyint(3) unsigned NOT NULL,
  `Payment_for_month` varchar(7) NOT NULL,
  `Payment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Payment_for_month` (`Payment_for_month`),
  KEY `payment_category` (`payment_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `payment_category` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `payment_category` (`id`, `name`) VALUES
(1, 'Офицальная'),
(2, 'Неофицальная'),
(3, 'Ласточка');

CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `user` (`id`, `name`, `pass`) VALUES
(1, '1', 'c4ca4238a0b923820dcc509a6f75849b'),
(2, '2', 'c4ca4238a0b923820dcc509a6f75849b');


ALTER TABLE `buh_comment_payment`
  ADD CONSTRAINT `buh_comment_payment_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `buh_transaction` (`id`);

ALTER TABLE `buh_transaction`
  ADD CONSTRAINT `buh_transaction_ibfk_3` FOREIGN KEY (`category`) REFERENCES `buh_category` (`id`),
  ADD CONSTRAINT `buh_transaction_ibfk_1` FOREIGN KEY (`account`) REFERENCES `buh_account` (`id`),
  ADD CONSTRAINT `buh_transaction_ibfk_2` FOREIGN KEY (`operations`) REFERENCES `buh_operation` (`id`);

ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`payment_category`) REFERENCES `payment_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
