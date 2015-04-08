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

DELIMITER $$
--
-- Процедуры
--
DROP PROCEDURE IF EXISTS `addAuthor`$$
CREATE PROCEDURE `addAuthor`(IN `author` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@name'
BEGIN
    INSERT INTO authors (Name) VALUES (author);
    
    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `addAuthorsOfBooks`$$
CREATE PROCEDURE `addAuthorsOfBooks`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `idNewBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idAuthors @idBook'
BEGIN
	DECLARE i INT UNSIGNED DEFAULT 1;
    DECLARE tempId INT UNSIGNED;
    
    insertAuthors: LOOP
    
        SELECT strSplit(auth, i) INTO tempId;
    
        IF (tempId = '') THEN
            LEAVE insertAuthors;
        END IF;
        
        INSERT INTO authors2books (authors2books.idAuthor, authors2books.idBook) VALUES (tempId, idNewBook);
        
        SET i = i + 1;
        
    END LOOP insertAuthors;
END$$

DROP PROCEDURE IF EXISTS `addBook`$$
CREATE PROCEDURE `addBook`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `genr` VARCHAR(1000) CHARSET utf8, IN `name` VARCHAR(45) CHARSET utf8, IN `descr` TEXT CHARSET utf8, IN `price` DECIMAL(6,2) UNSIGNED, IN `imgType` VARCHAR(10) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@authors @genres @name @descr @price @imgType'
BEGIN
    DECLARE idNewBook INT(6) UNSIGNED;

    INSERT INTO books (books.Name, books.Price, books.Description) VALUES (name, price, descr);

    SELECT LAST_INSERT_ID() INTO idNewBook;

    UPDATE books SET Image = CONCAT(idNewBook, '.', imgType) WHERE books.idBook = idNewBook;
    
    CALL addAuthorsOfBooks(auth, idNewBook);
    
    CALL addGenresOfBooks(genr, idNewBook);
    
    SELECT idNewBook;
END$$

DROP PROCEDURE IF EXISTS `addGenre`$$
CREATE PROCEDURE `addGenre`(IN `genre` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@name'
BEGIN
    INSERT INTO genres (Name) VALUES (genre);
    
    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `addGenresOfBooks`$$
CREATE PROCEDURE `addGenresOfBooks`(IN `genr` VARCHAR(1000) CHARSET utf8, IN `idNewBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idGenres @idBook'
BEGIN
	DECLARE i INT UNSIGNED DEFAULT 1;
    DECLARE tempId INT UNSIGNED;
    
    insertGenres: LOOP
        
            SELECT strSplit(genr, i) INTO tempId;
        
            IF (tempId = '') THEN
                LEAVE insertGenres;
            END IF;
            
            INSERT INTO genres2books (genres2books.idGenre, genres2books.idBook) VALUES (tempId, idNewBook);
            
            SET i = i + 1;
        
    END LOOP insertGenres;
END$$

DROP PROCEDURE IF EXISTS `addOrder`$$
CREATE PROCEDURE `addOrder`(IN `idUser` INT(6) UNSIGNED, IN `idPayMethod` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idPayMethod'
BEGIN
	DECLARE idOrder INT(6) UNSIGNED;
    
	INSERT INTO orders (orders.idUser, orders.idPaymethod)
    VALUES (idUser, idPayMethod);
    
    SELECT LAST_INSERT_ID()
    INTO idOrder;
    
    INSERT INTO orders2books (orders2books.idOrder, orders2books.idBook, orders2books.Quantity, orders2books.Price)
    SELECT idOrder, u2b.idBook, u2b.Quantity, u2b.Price
    FROM users2books AS u2b
    WHERE u2b.idUser = idUser;
    
    DELETE FROM users2books
    WHERE users2books.idUser = idUser;
    
    SELECT idOrder;
END$$

DROP PROCEDURE IF EXISTS `addToCart`$$
CREATE PROCEDURE `addToCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `quantity` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idBook @quantity'
BEGIN
	DECLARE exsistsQuantity INT(6) UNSIGNED;
    DECLARE price DECIMAL(6,2) UNSIGNED;
    DECLARE discount DECIMAL(3,3) UNSIGNED;
    
    SELECT u2b.Quantity
    INTO exsistsQuantity
    FROM users2books AS u2b
    WHERE u2b.idUser = idUser 
    	AND u2b.idBook = idBook;
        
    IF(exsistsQuantity IS NULL) THEN
        
        SELECT b.Price
        INTO price
        FROM books AS b
        WHERE b.idBook = idBook;
        
        SELECT getDiscount(idUser)
        INTO discount;
        
    	INSERT INTO users2books (users2books.idUser, users2books.idBook, users2books.Quantity, users2books.Price)
        VALUES (idUser, idBook, quantity, price-price*discount);
        
    ELSE
    
    	UPDATE users2books
        SET users2books.Quantity = quantity + exsistsQuantity
        WHERE users2books.idUser = idUser 
        	AND users2books.idBook = idBook;
            
    END IF;
        
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `addUser`$$
CREATE PROCEDURE `addUser`(IN `email` VARCHAR(255) CHARSET utf8, IN `passw` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@email @password'
BEGIN
	INSERT INTO users (users.Email, users.Password) 
    VALUES (email, PASSWORD(passw));
    
    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `deleteAuthor`$$
CREATE PROCEDURE `deleteAuthor`(IN `idAuthor` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idAuthor'
BEGIN
	DELETE FROM authors
    WHERE authors.idAuthor = idAuthor;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteBook`$$
CREATE PROCEDURE `deleteBook`(IN `idBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idBook'
BEGIN
	DELETE FROM books
    WHERE books.idBook = idBook;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteFromCart`$$
CREATE PROCEDURE `deleteFromCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idBook'
BEGIN
	DELETE FROM users2books
    WHERE users2books.idUser = idUser
    	AND users2books.idBook = idBook;
        
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteGenre`$$
CREATE PROCEDURE `deleteGenre`(IN `idGenre` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idGenre'
BEGIN
	DELETE FROM genres
    WHERE genres.idGenre = idGenre;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `exsistsUser`$$
CREATE PROCEDURE `exsistsUser`(IN `email` VARCHAR(255) CHARSET utf8)
    READS SQL DATA
    COMMENT '@email'
BEGIN
   	SELECT users.idUser
    FROM users
    WHERE users.Email = email;
END$$

DROP PROCEDURE IF EXISTS `getAuthors`$$
CREATE PROCEDURE `getAuthors`(IN `idAuthor` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT 'get all authors if @idAuthor is not specified'
BEGIN
	IF(idAuthor = 0)THEN
    	SELECT authors.idAuthor, authors.Name 
        FROM authors
        ORDER BY authors.Name;
    ELSE
    	SELECT authors.idAuthor, authors.Name 
        FROM authors 
        WHERE authors.idAuthor = idAuthor;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `getBookCount`$$
CREATE PROCEDURE `getBookCount`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
	SELECT SUM(users2books.Quantity) AS Quantity
    FROM users2books
    WHERE users2books.idUser = idUser;
END$$

DROP PROCEDURE IF EXISTS `getBookDetails`$$
CREATE PROCEDURE `getBookDetails`(IN `id` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idBook'
BEGIN
       	SELECT GROUP_CONCAT(DISTINCT authors.Name) AS Authors, GROUP_CONCAT(DISTINCT genres.Name) AS Gesres, books.Name, books.Price, books.Image, descriptions.Content AS Description
        	FROM genres
            	JOIN genres2books
                	ON genres.idGenre = genres2books.idGenre
                JOIN books
                    ON genres2books.idBook = books.idBook
                JOIN authors2books
                    ON books.idBook = authors2books.idBook
                JOIN authors
               	    ON authors2books.idAuthor = authors.idAuthor
                JOIN descriptions
                	ON books.idBook = descriptions.idBook
            WHERE books.idBook = id;
END$$

DROP PROCEDURE IF EXISTS `getBooks`$$
CREATE PROCEDURE `getBooks`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '[@idUser]'
BEGIN
	DECLARE discount DECIMAL(3,3) UNSIGNED;
    
    SELECT getDiscount(idUser)
    INTO discount;
    
   	SELECT GROUP_CONCAT(DISTINCT a.Name) AS Authors, GROUP_CONCAT(DISTINCT g.Name) AS Genres, b.idBook, b.Name, b.Image, ROUND(b.Price-b.Price*discount, 2) AS Price, b.Description
       	FROM genres AS g
           	JOIN genres2books AS g2b
               	ON g.idGenre = g2b.idGenre
            JOIN books AS b
                ON g2b.idBook = b.idBook
            JOIN authors2books AS a2b
              	ON b.idBook = a2b.idBook
            JOIN authors AS a
              	ON a2b.idAuthor = a.idAuthor
    GROUP BY(b.idBook)
    ORDER BY b.Name;
END$$

DROP PROCEDURE IF EXISTS `getCart`$$
CREATE PROCEDURE `getCart`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
	SELECT u2b.idBook, u2b.Quantity, u2b.Price, books.Name
    FROM users2books AS u2b
    JOIN books
    	ON u2b.idBook = books.idBook
    WHERE u2b.idUser = idUser;
END$$

DROP PROCEDURE IF EXISTS `getGenres`$$
CREATE PROCEDURE `getGenres`(IN `idGenre` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT 'get all genres if @idGenre is not specified'
BEGIN
	IF(idGenre = 0)THEN
    	SELECT genres.idGenre, genres.Name 
        FROM genres
        ORDER BY genres.Name;
    ELSE
    	SELECT genres.idGenre, genres.Name 
        FROM genres 
        WHERE genres.idGenre = idGenre;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `getPayMethods`$$
CREATE PROCEDURE `getPayMethods`()
    READS SQL DATA
BEGIN
	SELECT pm.idPayMethod, pm.Name
    FROM pay_methods AS pm;
END$$

DROP PROCEDURE IF EXISTS `getUser`$$
CREATE PROCEDURE `getUser`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
	SELECT users.idUser, users.Email, discounts.Size AS Discount
    FROM users
    	JOIN discounts
        	ON users.idDiscount = discounts.idDiscount
    WHERE users.idUser = idUser;
END$$

DROP PROCEDURE IF EXISTS `isValidLogin`$$
CREATE PROCEDURE `isValidLogin`(IN `email` VARCHAR(255) CHARSET utf8, IN `passw` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@email @password'
BEGIN
   	SELECT users.idUser
    FROM users
    WHERE users.Email = email 
    	AND users.Password = PASSWORD(passw);
END$$

DROP PROCEDURE IF EXISTS `isValidUser`$$
CREATE PROCEDURE `isValidUser`(IN `idUser` INT(6) UNSIGNED, IN `sessionId` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@idUser @sessionId'
BEGIN
	SELECT users.idUser, users.SessionId
    FROM users
    WHERE users.idUser = idUser AND users.SessionId = sessionId;
END$$

DROP PROCEDURE IF EXISTS `sessionDestroy`$$
CREATE PROCEDURE `sessionDestroy`(IN `idUser` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser'
BEGIN
	UPDATE users 
    SET users.SessionId = ''
    WHERE users.idUser = idUser;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `sessionStart`$$
CREATE PROCEDURE `sessionStart`(IN `idUser` INT(6) UNSIGNED, IN `sessionId` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@idUser @sessionId'
BEGIN
	UPDATE users 
    SET users.SessionId = sessionId
    WHERE users.idUser = idUser;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateAuthor`$$
CREATE PROCEDURE `updateAuthor`(IN `idAuthor` INT(6) UNSIGNED, IN `newName` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@idAuthor @newName'
BEGIN
	UPDATE authors 
    SET authors.Name = newName 
    WHERE authors.idAuthor = idAuthor;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateBook`$$
CREATE PROCEDURE `updateBook`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `genr` VARCHAR(1000) CHARSET utf8, IN `name` VARCHAR(1000) CHARSET utf8, IN `descr` VARCHAR(1000) CHARSET utf8, IN `price` DECIMAL(6,2) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `imgType` VARCHAR(10) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@auth @genr @name @descr @price @idBook @imgType'
BEGIN
IF(imgType = '') THEN
        UPDATE books
        SET books.Name = name, books.Price = price, books.Description = descr
        WHERE books.idBook = idBook;
    ELSE
    	UPDATE books
        SET books.Name = name, books.Price = price, books.Description = descr, books.Image = CONCAT(idBook, '.', imgType)
        WHERE books.idBook = idBook;
    END IF;
    
    DELETE FROM authors2books WHERE authors2books.idBook = idBook;
    
    DELETE FROM genres2books WHERE genres2books.idBook = idBook;
    
    CALL addAuthorsOfBooks(auth, idBook);
    
    CALL addGenresOfBooks(genr, idBook);
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateGenre`$$
CREATE PROCEDURE `updateGenre`(IN `idGenre` INT(6) UNSIGNED, IN `newName` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@idGenre @name'
BEGIN
	UPDATE genres 
    SET genres.Name = newName 
    WHERE genres.idGenre = idGenre;
    
    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateQuantityInCart`$$
CREATE PROCEDURE `updateQuantityInCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `quantity` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idBook @quantity'
BEGIN
	UPDATE users2books
    SET users2books.Quantity = quantity
    WHERE users2books.idUser = idUser
    	AND users2books.idBook = idBook;
        
    SELECT ROW_COUNT();
END$$

--
-- Функции
--
DROP FUNCTION IF EXISTS `getDiscount`$$
CREATE FUNCTION `getDiscount`(`idUser` INT(6) UNSIGNED) RETURNS decimal(3,3) unsigned
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
	DECLARE discount DECIMAL(3,3) UNSIGNED DEFAULT 0;
    
	SELECT d.Size
    INTO discount
    FROM discounts AS d
        JOIN users AS u
            ON d.idDiscount = u.idDiscount
    WHERE u.idUser = idUser;
    
    RETURN discount;
END$$

DROP FUNCTION IF EXISTS `strSplit`$$
CREATE FUNCTION `strSplit`(`str` TEXT CHARSET utf8, `pos` INT(6) UNSIGNED) RETURNS text CHARSET utf8
    NO SQL
BEGIN
    RETURN REPLACE(substring(substring_index(str, ',', pos), length(substring_index(str, ',', pos - 1)) + 1), ',', '');
END$$

DELIMITER ;

-- --------------------------------------------------------

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