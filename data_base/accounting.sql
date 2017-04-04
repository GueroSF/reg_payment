-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 03 2017 г., 10:49
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
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` decimal(7,2) NOT NULL,
  `payment_category` int(1) NOT NULL,
  `Payment_for_month` varchar(7) NOT NULL,
  `Payment_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Payment_for_month` (`Payment_for_month`),
  KEY `payment_category` (`payment_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `money`, `payment_category`, `Payment_for_month`, `Payment_date`) VALUES
(1, 100, 1, '2_2017', '2017-04-03'),
(2, 3000, 2, '2_2017', '2017-04-03'),
(3, 350, 3, '2_2017', '2017-04-03'),
(4, 2000, 2, '3_2017', '2017-04-03'),
(5, 320, 3, '3_2017', '2017-04-03');

-- --------------------------------------------------------

--
-- Структура таблицы `payment_category`
--

CREATE TABLE IF NOT EXISTS `payment_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `payment_category`
--

INSERT INTO `payment_category` (`id`, `name`) VALUES
(1, 'Офицальная'),
(2, 'Неофицальная'),
(3, 'Ласточка');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`payment_category`) REFERENCES `payment_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;