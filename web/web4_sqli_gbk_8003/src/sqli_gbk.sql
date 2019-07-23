-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 �?05 �?07 �?10:37
-- 服务器版本: 5.5.53
-- PHP 版本: 5.6.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sqli_gbk`
--

-- --------------------------------------------------------

--
-- 表的结构 `flag`
--

CREATE TABLE IF NOT EXISTS `flag` (
  `flag` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `flag`
--

INSERT INTO `flag` (`flag`) VALUES
('SKCTF{cHang_T1a0&RAP}');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `name` text NOT NULL,
  `id` bigint(11) NOT NULL,
  `class` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`name`, `id`, `class`) VALUES
('蔡徐坤', 1, '打篮球一班'),
('菜虚坤', 2, '打篮球二班'),
('鸡你太美', 3, 'RAP一班'),
('弗莱格', 4, 'not_real_flag');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
