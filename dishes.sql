-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 02 2021 г., 12:26
-- Версия сервера: 5.7.31
-- Версия PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dishes`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dishes`
--

DROP TABLE IF EXISTS `dishes`;
CREATE TABLE IF NOT EXISTS `dishes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `fk-dishes-status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `dishes`
--

INSERT INTO `dishes` (`id`, `name`, `status_id`) VALUES
(5, 'fhk', 1),
(6, 'мрод', 1),
(7, 'nl\'jop', 1),
(8, 'flgil', 1),
(10, 'ародпд', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `dishes_ingredients`
--

DROP TABLE IF EXISTS `dishes_ingredients`;
CREATE TABLE IF NOT EXISTS `dishes_ingredients` (
  `dishes_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  PRIMARY KEY (`dishes_id`,`ingredients_id`),
  KEY `idx-dishes_ingredients-dishes_id` (`dishes_id`),
  KEY `idx-dishes_ingredients-ingredients_id` (`ingredients_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `dishes_ingredients`
--

INSERT INTO `dishes_ingredients` (`dishes_id`, `ingredients_id`) VALUES
(5, 1),
(5, 10),
(5, 12),
(6, 1),
(6, 13),
(7, 2),
(7, 5),
(7, 13),
(8, 2),
(8, 13),
(8, 14),
(10, 1),
(10, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `fk-ingredients-status_id` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `status_id`) VALUES
(1, 'Мука', 1),
(2, 'Соль', 1),
(3, 'Сахар', 1),
(4, 'Молоко', 1),
(5, 'Яйцо', 1),
(6, 'Растительное масло', 1),
(7, 'Сливочное масло', 1),
(8, 'Сода', 1),
(9, 'Уксус', 1),
(10, 'Лук', 1),
(11, 'Чеснок', 1),
(12, 'Перец', 1),
(13, 'Картофель', 1),
(14, 'Капуста', 1),
(15, 'Морковь', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1614395672),
('m210227_011726_create_dishes_table', 1614395675),
('m210227_013519_create_statuses_table', 1614395675),
('m210227_013547_create_ingredients_table', 1614395676),
('m210227_032527_create_junction_table_for_dishes_and_ingredients_tables', 1614396352),
('m210301_043415_add_status_id_column_to_dishes_table', 1614573928);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name2` (`name2`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `name2`) VALUES
(1, 'Актуально', 'Актуальные'),
(2, 'Скрыто', 'Скрытые');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `fk-dishes-status_id` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

--
-- Ограничения внешнего ключа таблицы `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `fk-ingredients-status_id` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
