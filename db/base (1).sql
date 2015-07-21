-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 22 2015 г., 00:17
-- Версия сервера: 5.5.43-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Base`
--

CREATE TABLE IF NOT EXISTS `Base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `keyfield_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6086515FA76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `Base`
--

INSERT INTO `Base` (`id`, `user_id`, `title`, `color`, `keyfield_id`, `created_at`) VALUES
(1, 1, 'base_1', 'green', 5, '2015-07-15 00:00:00'),
(2, 1, 'kino', 'red', 132, '2015-07-15 09:00:00'),
(3, 2, 'rock', 'black', 1, '2015-07-16 00:00:00'),
(4, 2, 'Films', 'white', 21, '2015-07-14 00:00:00'),
(10, 1, 'pppoooppp', 'pink', 0, '2015-07-17 17:31:47');

-- --------------------------------------------------------

--
-- Структура таблицы `BaseField`
--

CREATE TABLE IF NOT EXISTS `BaseField` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_id` int(11) DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `config` longtext COLLATE utf8_unicode_ci,
  `is_show` tinyint(1) NOT NULL,
  `is_requiered` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D38356146967DF41` (`base_id`),
  KEY `IDX_D3835614C54C8C93` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=108 ;

--
-- Дамп данных таблицы `BaseField`
--

INSERT INTO `BaseField` (`id`, `base_id`, `title`, `type_id`, `config`, `is_show`, `is_requiered`) VALUES
(102, 4, 'title', 1, NULL, 1, 1),
(103, 4, 'type', 4, 'Скачать\r\nПосмотрел', 1, 1),
(104, 4, 'rank', 4, '1\r\n2\r\n3\r\n4\r\n5', 1, 0),
(105, 4, 'year', 2, NULL, 0, 0),
(106, 4, 'url', 3, NULL, 0, 0),
(107, 4, 'genre', 4, 'Детектив\r\nФантастика\r\nФентези\r\nКомедия\r\nдругое', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `BaseRow`
--

CREATE TABLE IF NOT EXISTS `BaseRow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CE693D66967DF41` (`base_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=603 ;

--
-- Дамп данных таблицы `BaseRow`
--

INSERT INTO `BaseRow` (`id`, `base_id`) VALUES
(600, 3),
(601, 4),
(602, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `FieldType`
--

CREATE TABLE IF NOT EXISTS `FieldType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `FieldType`
--

INSERT INTO `FieldType` (`id`, `title`, `code`) VALUES
(1, 'string', 'STR'),
(2, 'integer', 'INT'),
(3, 'url', 'URL'),
(4, 'list', 'LIST'),
(5, 'checkbox', 'CH'),
(6, 'image', 'IMG');

-- --------------------------------------------------------

--
-- Структура таблицы `FieldValue`
--

CREATE TABLE IF NOT EXISTS `FieldValue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_row_id` int(11) DEFAULT NULL,
  `base_field_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD026D41EDCA448` (`base_field_id`),
  KEY `IDX_DD026D41EBC2F19B` (`base_row_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1041 ;

--
-- Дамп данных таблицы `FieldValue`
--

INSERT INTO `FieldValue` (`id`, `base_row_id`, `base_field_id`, `value`) VALUES
(1029, 601, 102, 'АБВ'),
(1030, 601, 103, 'Скачать'),
(1031, 601, 104, NULL),
(1032, 601, 105, '2014'),
(1033, 601, 106, 'http://youtube.com/1234'),
(1034, 601, 107, 'Фантастика'),
(1035, 602, 102, 'КЛМН'),
(1036, 602, 103, 'Посмотрел'),
(1037, 602, 104, '4'),
(1038, 602, 105, '2011'),
(1039, 602, 106, 'http://rutracker.org/12345'),
(1040, 602, 107, 'Комедия');

-- --------------------------------------------------------

--
-- Структура таблицы `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`id`, `email`, `password`, `name`) VALUES
(1, 'burut@base.lan', '123', 'Burut Burutovich'),
(2, 'test@test.com', '123', 'Test User'),
(3, 'burut21@gmail.com', '123454321', 'бурут бурутович '),
(14, 'vasya@base.lan', '12321', 'vasya'),
(15, '', '', ''),
(16, '', '', ''),
(17, '', '', ''),
(18, '', '', ''),
(19, '', '', ''),
(20, 'qwe@qwe.lan', '123', 'qwe'),
(21, '', '', ''),
(22, '8нп@еав.шг', 'kj', 'uhiuh'),
(23, 'we@yhgj.kj', 'kjjhjh', '11111111111111'),
(24, 'kjgh@jhjh.jo', '090909', 'lpo'),
(25, '123@321.lan', '000', 'burut'),
(26, '000@0.lan', '000', '0!0!0!');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Base`
--
ALTER TABLE `Base`
  ADD CONSTRAINT `FK_6086515FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);

--
-- Ограничения внешнего ключа таблицы `BaseField`
--
ALTER TABLE `BaseField`
  ADD CONSTRAINT `FK_D38356146967DF41` FOREIGN KEY (`base_id`) REFERENCES `Base` (`id`),
  ADD CONSTRAINT `FK_D3835614C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `FieldType` (`id`);

--
-- Ограничения внешнего ключа таблицы `BaseRow`
--
ALTER TABLE `BaseRow`
  ADD CONSTRAINT `FK_7CE693D66967DF41` FOREIGN KEY (`base_id`) REFERENCES `Base` (`id`);

--
-- Ограничения внешнего ключа таблицы `FieldValue`
--
ALTER TABLE `FieldValue`
  ADD CONSTRAINT `FK_DD026D41EBC2F19B` FOREIGN KEY (`base_row_id`) REFERENCES `BaseRow` (`id`),
  ADD CONSTRAINT `FK_DD026D41EDCA448` FOREIGN KEY (`base_field_id`) REFERENCES `BaseField` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
