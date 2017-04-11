SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `buh_product_oil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(7) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `date_payment` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
