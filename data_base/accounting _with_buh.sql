-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 06 2017 г., 10:33
-- Версия сервера: 5.6.12-log
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `accounting`
--
CREATE DATABASE IF NOT EXISTS `accounting` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `accounting`;

-- --------------------------------------------------------

--
-- Структура таблицы `buh_account`
--

CREATE TABLE IF NOT EXISTS `buh_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Структура таблицы `buh_category`
--

CREATE TABLE IF NOT EXISTS `buh_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Структура таблицы `buh_operation`
--

CREATE TABLE IF NOT EXISTS `buh_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `buh_operation`
--

INSERT INTO `buh_operation` (`id`, `name`) VALUES
(1, 'Приход'),
(2, 'Расход');

-- --------------------------------------------------------

--
-- Структура таблицы `buh_transaction`
--

CREATE TABLE IF NOT EXISTS `buh_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` int(11) NOT NULL,
  `operations` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `date_operations` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `operations` (`operations`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(10,2) NOT NULL,
  `payment_category` int(1) NOT NULL,
  `Payment_for_month` varchar(7) NOT NULL,
  `Payment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Payment_for_month` (`Payment_for_month`),
  KEY `payment_category` (`payment_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- --------------------------------------------------------

--
-- Структура таблицы `payment_category`
--

CREATE TABLE IF NOT EXISTS `payment_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--

-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `buh_transaction`
--
ALTER TABLE `buh_transaction`
  ADD CONSTRAINT `buh_transaction_ibfk_3` FOREIGN KEY (`category`) REFERENCES `buh_category` (`id`),
  ADD CONSTRAINT `buh_transaction_ibfk_1` FOREIGN KEY (`account`) REFERENCES `buh_account` (`id`),
  ADD CONSTRAINT `buh_transaction_ibfk_2` FOREIGN KEY (`operations`) REFERENCES `buh_operation` (`id`);

--
-- Ограничения внешнего ключа таблицы `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`payment_category`) REFERENCES `payment_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
