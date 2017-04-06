-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 06 2017 г., 19:24
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

-- --------------------------------------------------------

--
-- Структура таблицы `buh_comment_payment`
--

CREATE TABLE IF NOT EXISTS `buh_comment_payment` (
  `transaction_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `buh_comment_payment`
--
ALTER TABLE `buh_comment_payment`
  ADD CONSTRAINT `buh_comment_payment_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `buh_transaction` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
