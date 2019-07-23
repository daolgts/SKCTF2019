SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

USE `skctf2019`;

DROP TABLE IF EXISTS `skctf2019_admin`;
CREATE TABLE IF NOT EXISTS `skctf2019_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `skctf2019_admin`(`id`, `username`, `password`) VALUES (0, 'skctf2o19', 'skctf20l9');
COMMIT;
