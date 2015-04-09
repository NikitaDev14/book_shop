-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Апр 06 2015 г., 23:05
-- Версия сервера: 5.6.21
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `book_shop`
--
USE `user10`;

--
-- Структура таблицы `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE IF NOT EXISTS `authors` (
`idAuthor` int(6) unsigned NOT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`idAuthor`, `Name`) VALUES
(2, 'Pushkin'),
(1, 'Shekspire'),
(3, 'Shevtchenko'),
(4, 'Skovoroda');

-- --------------------------------------------------------

--
-- Структура таблицы `authors2books`
--

DROP TABLE IF EXISTS `authors2books`;
CREATE TABLE IF NOT EXISTS `authors2books` (
  `idAuthor` int(6) unsigned NOT NULL,
  `idBook` int(6) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
`idBook` int(6) unsigned NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Price` decimal(6,2) unsigned NOT NULL,
  `Image` varchar(25) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
`idDiscount` int(6) unsigned NOT NULL,
  `Size` decimal(3,3) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `discounts`
--

INSERT INTO `discounts` (`idDiscount`, `Size`) VALUES
(2, '0.012'),
(1, '0.050');

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
`idGenre` int(6) unsigned NOT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`idGenre`, `Name`) VALUES
(2, 'Fantasy'),
(3, 'Horror'),
(1, 'Story');

-- --------------------------------------------------------

--
-- Структура таблицы `genres2books`
--

DROP TABLE IF EXISTS `genres2books`;
CREATE TABLE IF NOT EXISTS `genres2books` (
  `idGenre` int(6) unsigned NOT NULL,
  `idBook` int(6) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
`idOrder` int(6) unsigned NOT NULL,
  `idUser` int(6) unsigned NOT NULL,
  `idPayMethod` int(6) unsigned NOT NULL,
  `Date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `idStatus` int(6) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders2books`
--

DROP TABLE IF EXISTS `orders2books`;
CREATE TABLE IF NOT EXISTS `orders2books` (
  `idOrder` int(6) unsigned NOT NULL,
  `idBook` int(6) unsigned NOT NULL,
  `Quantity` int(6) unsigned NOT NULL,
  `Price` decimal(6,2) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
`idStatus` int(6) unsigned NOT NULL,
  `Name` varchar(90) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`idStatus`, `Name`) VALUES
(1, 'Formalizing'),
(2, 'Shipping'),
(3, 'Waiting');

-- --------------------------------------------------------

--
-- Структура таблицы `pay_methods`
--

DROP TABLE IF EXISTS `pay_methods`;
CREATE TABLE IF NOT EXISTS `pay_methods` (
`idPayMethod` int(6) unsigned NOT NULL,
  `Name` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pay_methods`
--

INSERT INTO `pay_methods` (`idPayMethod`, `Name`) VALUES
(3, 'Bank transfer'),
(1, 'Cash'),
(4, 'PayPal'),
(2, 'WebMoney');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`idUser` int(6) unsigned NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `idDiscount` int(6) unsigned DEFAULT '1',
  `SessionId` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users2books`
--

DROP TABLE IF EXISTS `users2books`;
CREATE TABLE IF NOT EXISTS `users2books` (
  `idUser` int(6) unsigned NOT NULL,
  `idBook` int(6) unsigned NOT NULL,
  `Quantity` int(6) unsigned NOT NULL,
  `Price` decimal(6,2) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
 ADD PRIMARY KEY (`idAuthor`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Индексы таблицы `authors2books`
--
ALTER TABLE `authors2books`
 ADD KEY `idAuthor` (`idAuthor`), ADD KEY `idBook` (`idBook`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
 ADD PRIMARY KEY (`idBook`);

--
-- Индексы таблицы `discounts`
--
ALTER TABLE `discounts`
 ADD PRIMARY KEY (`idDiscount`), ADD UNIQUE KEY `Size` (`Size`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
 ADD PRIMARY KEY (`idGenre`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Индексы таблицы `genres2books`
--
ALTER TABLE `genres2books`
 ADD KEY `idGenre` (`idGenre`), ADD KEY `idBook` (`idBook`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`idOrder`), ADD KEY `idUser` (`idUser`), ADD KEY `idPayMethod` (`idPayMethod`), ADD KEY `idStatus` (`idStatus`);

--
-- Индексы таблицы `orders2books`
--
ALTER TABLE `orders2books`
 ADD KEY `idOrder` (`idOrder`), ADD KEY `idBook` (`idBook`);

--
-- Индексы таблицы `order_status`
--
ALTER TABLE `order_status`
 ADD PRIMARY KEY (`idStatus`);

--
-- Индексы таблицы `pay_methods`
--
ALTER TABLE `pay_methods`
 ADD PRIMARY KEY (`idPayMethod`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`idUser`), ADD UNIQUE KEY `Email` (`Email`), ADD KEY `idDiscount` (`idDiscount`);

--
-- Индексы таблицы `users2books`
--
ALTER TABLE `users2books`
 ADD KEY `idUser` (`idUser`), ADD KEY `idBook` (`idBook`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
MODIFY `idAuthor` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
MODIFY `idBook` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `discounts`
--
ALTER TABLE `discounts`
MODIFY `idDiscount` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
MODIFY `idGenre` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
MODIFY `idOrder` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `order_status`
--
ALTER TABLE `order_status`
MODIFY `idStatus` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `pay_methods`
--
ALTER TABLE `pay_methods`
MODIFY `idPayMethod` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
MODIFY `idUser` int(6) unsigned NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `authors2books`
--
ALTER TABLE `authors2books`
ADD CONSTRAINT `authors2books_ibfk_1` FOREIGN KEY (`idAuthor`) REFERENCES `authors` (`idAuthor`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `authors2books_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `genres2books`
--
ALTER TABLE `genres2books`
ADD CONSTRAINT `genres2books_ibfk_1` FOREIGN KEY (`idGenre`) REFERENCES `genres` (`idGenre`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `genres2books_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`idPayMethod`) REFERENCES `pay_methods` (`idPayMethod`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`idStatus`) REFERENCES `order_status` (`idStatus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders2books`
--
ALTER TABLE `orders2books`
ADD CONSTRAINT `orders2books_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`idOrder`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `orders2books_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idDiscount`) REFERENCES `discounts` (`idDiscount`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users2books`
--
ALTER TABLE `users2books`
ADD CONSTRAINT `users2books_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `users2books_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `books` (`idBook`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
