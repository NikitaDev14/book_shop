-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 29 2014 г., 10:27
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `bookcatalogue`
--
CREATE DATABASE IF NOT EXISTS `book_shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `book_shop`;

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `author` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author` (`author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Очистить таблицу перед добавлением данных `authors`
--

TRUNCATE TABLE `authors`;
--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `author`) VALUES
(4, 'Б.Эккель'),
(13, 'Г.Шилдт'),
(15, 'Д.Ритчи'),
(1, 'Н.Культин'),
(17, 'Р.Никсон'),
(18, 'Х.Кейтел');

-- --------------------------------------------------------

--
-- Структура таблицы `authors_books`
--

CREATE TABLE IF NOT EXISTS `authors_books` (
  `id_author` int(6) NOT NULL,
  `id_book` int(6) NOT NULL,
  KEY `id_author` (`id_author`),
  KEY `id_book` (`id_book`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- СВЯЗИ ТАБЛИЦЫ `authors_books`:
--   `id_author`
--       `authors` -> `id`
--   `id_book`
--       `books` -> `id`
--

--
-- Очистить таблицу перед добавлением данных `authors_books`
--

TRUNCATE TABLE `authors_books`;
--
-- Дамп данных таблицы `authors_books`
--

INSERT INTO `authors_books` (`id_author`, `id_book`) VALUES
(13, 31),
(17, 32),
(4, 33),
(13, 34),
(4, 21),
(1, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Очистить таблицу перед добавлением данных `books`
--

TRUNCATE TABLE `books`;
--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `name`, `price`) VALUES
(20, 'C/C++ в задачах и примерах', '5.99'),
(21, 'Язык программирования С', '8.49'),
(31, 'С++: руководство для начинающих', '7.01'),
(32, 'Создаем динамические веб-сайты с', '9.01'),
(33, 'Философия Java', '4.01'),
(34, 'Полное руководство Java', '8.01');

-- --------------------------------------------------------

--
-- Структура таблицы `descriptions`
--

CREATE TABLE IF NOT EXISTS `descriptions` (
  `id_book` int(6) NOT NULL,
  `description` text NOT NULL,
  KEY `id_book` (`id_book`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- СВЯЗИ ТАБЛИЦЫ `descriptions`:
--   `id_book`
--       `books` -> `id`
--

--
-- Очистить таблицу перед добавлением данных `descriptions`
--

TRUNCATE TABLE `descriptions`;
--
-- Дамп данных таблицы `descriptions`
--

INSERT INTO `descriptions` (`id_book`, `description`) VALUES
(20, 'Сборник задач по профаммированию на языке C/C++, как типовых\r\n— ввод/вывод, управление вычислительным процессом, работа\r\nс массивами, поиск и сортировка, так и тех, которые чаще всего не\r\nвходят в традиционные курсы — работа со строками и файлами,\r\nвывод на принтер, деловая графика, рекурсия. Для большинства задач\r\nприведены решения, представляющие собой документированные\r\nисходные тексты программ. Книга содержит также справочник\r\nпо наиболее часто используемым функциям языка C/C++ и может\r\nслужить задачником для студентов и школьников, изучающих программирование.'),
(21, 'ваиепаиткеап'),
(31, 'трпт ртвнротн ыартне'),
(32, 'В данном руководстве каждая технология рассматривается отдельно.'),
(33, 'Java нельзя понять, взгянув на него только как на коллекцию некоторых характеристик.'),
(34, 'Java - один из самых важных и популярных компьютерных языков в мире.');

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `genre` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genre` (`genre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Очистить таблицу перед добавлением данных `genres`
--

TRUNCATE TABLE `genres`;
--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(4, 'Аудиокнига'),
(1, 'Научная'),
(2, 'Учебная'),
(5, 'Фантастика');

-- --------------------------------------------------------

--
-- Структура таблицы `genres_books`
--

CREATE TABLE IF NOT EXISTS `genres_books` (
  `id_genre` int(6) NOT NULL,
  `id_book` int(6) NOT NULL,
  KEY `id_genre` (`id_genre`),
  KEY `id_book` (`id_book`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- СВЯЗИ ТАБЛИЦЫ `genres_books`:
--   `id_genre`
--       `genres` -> `id`
--   `id_book`
--       `books` -> `id`
--

--
-- Очистить таблицу перед добавлением данных `genres_books`
--

TRUNCATE TABLE `genres_books`;
--
-- Дамп данных таблицы `genres_books`
--

INSERT INTO `genres_books` (`id_genre`, `id_book`) VALUES
(1, 31),
(2, 31),
(1, 32),
(2, 32),
(1, 33),
(2, 33),
(1, 34),
(2, 34),
(4, 21),
(1, 21),
(2, 21),
(2, 20);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `authors_books`
--
ALTER TABLE `authors_books`
  ADD CONSTRAINT `authors_books_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `authors_books_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `descriptions`
--
ALTER TABLE `descriptions`
  ADD CONSTRAINT `descriptions_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `genres_books`
--
ALTER TABLE `genres_books`
  ADD CONSTRAINT `genres_books_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genres_books_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;