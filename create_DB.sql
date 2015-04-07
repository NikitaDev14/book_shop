CREATE DATABASE book_shop DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

SET TIME_ZONE = "+02:00";

USE book_shop;

DELIMITER $$
--
-- Процедуры
--
DROP PROCEDURE IF EXISTS `addAuthor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addAuthor`(IN `author` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@name'
BEGIN
    INSERT INTO authors (Name) VALUES (author);

    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `addAuthorsOfBooks`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addAuthorsOfBooks`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `idNewBook` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addBook`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `genr` VARCHAR(1000) CHARSET utf8, IN `name` VARCHAR(45) CHARSET utf8, IN `descr` TEXT CHARSET utf8, IN `price` DECIMAL(6,2) UNSIGNED, IN `imgType` VARCHAR(10) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@authors @genres @name @descr @price @imgType'
BEGIN
    DECLARE idNewBook INT(6) UNSIGNED;

    INSERT INTO books (books.Name, books.Price) VALUES (name, price);

    SELECT LAST_INSERT_ID() INTO idNewBook;

    UPDATE books SET Image = CONCAT(idNewBook, '.', imgType) WHERE books.idBook = idNewBook;

    INSERT INTO descriptions (descriptions.idBook, descriptions.Content) VALUES (idNewBook, descr);

    CALL addAuthorsOfBooks(auth, idNewBook);

    CALL addGenresOfBooks(genr, idNewBook);

    SELECT idNewBook;
END$$

DROP PROCEDURE IF EXISTS `addGenre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addGenre`(IN `genre` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@name'
BEGIN
    INSERT INTO genres (Name) VALUES (genre);

    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `addGenresOfBooks`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addGenresOfBooks`(IN `genr` VARCHAR(1000) CHARSET utf8, IN `idNewBook` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addOrder`(IN `idUser` INT(6) UNSIGNED, IN `idPayMethod` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addToCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `quantity` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUser`(IN `email` VARCHAR(255) CHARSET utf8, IN `passw` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@email @password'
BEGIN
	INSERT INTO users (users.Email, users.Password)
    VALUES (email, PASSWORD(passw));

    SELECT LAST_INSERT_ID();
END$$

DROP PROCEDURE IF EXISTS `deleteAuthor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAuthor`(IN `idAuthor` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idAuthor'
BEGIN
	DELETE FROM authors
    WHERE authors.idAuthor = idAuthor;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteBook`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBook`(IN `idBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idBook'
BEGIN
	DELETE FROM books
    WHERE books.idBook = idBook;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteFromCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteFromCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idBook'
BEGIN
	DELETE FROM users2books
    WHERE users2books.idUser = idUser
    	AND users2books.idBook = idBook;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `deleteGenre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteGenre`(IN `idGenre` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idGenre'
BEGIN
	DELETE FROM genres
    WHERE genres.idGenre = idGenre;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `exsistsUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `exsistsUser`(IN `email` VARCHAR(255) CHARSET utf8)
    READS SQL DATA
    COMMENT '@email'
BEGIN
   	SELECT users.idUser
    FROM users
    WHERE users.Email = email;
END$$

DROP PROCEDURE IF EXISTS `getAuthors`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAuthors`(IN `idAuthor` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBookCount`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
	SELECT SUM(users2books.Quantity) AS Quantity
    FROM users2books
    WHERE users2books.idUser = idUser;
END$$

DROP PROCEDURE IF EXISTS `getBookDetails`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBookDetails`(IN `id` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBooks`(IN `idUser` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getCart`(IN `idUser` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getGenres`(IN `idGenre` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getPayMethods`()
    READS SQL DATA
BEGIN
	SELECT pm.idPayMethod, pm.Name
    FROM pay_methods AS pm;
END$$

DROP PROCEDURE IF EXISTS `getUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser`(IN `idUser` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `isValidLogin`(IN `email` VARCHAR(255) CHARSET utf8, IN `passw` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@email @password'
BEGIN
   	SELECT users.idUser
    FROM users
    WHERE users.Email = email
    	AND users.Password = PASSWORD(passw);
END$$

DROP PROCEDURE IF EXISTS `isValidUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `isValidUser`(IN `idUser` INT(6) UNSIGNED, IN `sessionId` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@idUser @sessionId'
BEGIN
	SELECT users.idUser, users.SessionId
    FROM users
    WHERE users.idUser = idUser AND users.SessionId = sessionId;
END$$

DROP PROCEDURE IF EXISTS `sessionDestroy`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sessionDestroy`(IN `idUser` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser'
BEGIN
	UPDATE users
    SET users.SessionId = ''
    WHERE users.idUser = idUser;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `sessionStart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sessionStart`(IN `idUser` INT(6) UNSIGNED, IN `sessionId` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@idUser @sessionId'
BEGIN
	UPDATE users
    SET users.SessionId = sessionId
    WHERE users.idUser = idUser;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateAuthor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateAuthor`(IN `idAuthor` INT(6) UNSIGNED, IN `newName` VARCHAR(45) CHARSET utf8)
    MODIFIES SQL DATA
    COMMENT '@idAuthor @newName'
BEGIN
	UPDATE authors
    SET authors.Name = newName
    WHERE authors.idAuthor = idAuthor;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateBook`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateBook`(IN `auth` VARCHAR(1000) CHARSET utf8, IN `genr` VARCHAR(1000) CHARSET utf8, IN `name` VARCHAR(1000) CHARSET utf8, IN `descr` VARCHAR(1000) CHARSET utf8, IN `price` DECIMAL(6,2) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `imgType` INT)
    MODIFIES SQL DATA
    COMMENT '@auth @genr @name @descr @price @idBook @imgType'
BEGIN
    UPDATE books SET books.Name = name, books.Price = price, books.Image = CONCAT(idBook, '.', imgType) WHERE books.idBook = idBook;

    UPDATE descriptions SET descriptions.Content = descr WHERE descriptions.idBook = idBook;

    DELETE FROM authors2books WHERE authors2books.idBook = idBook;

    DELETE FROM genres2books WHERE genres2books.idBook = idBook;

    CALL addAuthorsOfBooks(auth, idBook);

    CALL addGenresOfBooks(genr, idBook);

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateGenre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateGenre`(IN `idGenre` INT(6) UNSIGNED, IN `newName` VARCHAR(45) CHARSET utf8)
    READS SQL DATA
    COMMENT '@idGenre @name'
BEGIN
	UPDATE genres
    SET genres.Name = newName
    WHERE genres.idGenre = idGenre;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `updateQuantityInCart`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateQuantityInCart`(IN `idUser` INT(6) UNSIGNED, IN `idBook` INT(6) UNSIGNED, IN `quantity` INT(6) UNSIGNED)
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
CREATE DEFINER=`root`@`localhost` FUNCTION `getDiscount`(`idUser` INT(6) UNSIGNED) RETURNS decimal(3,3) unsigned
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
CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(`str` TEXT CHARSET utf8, `pos` INT(6) UNSIGNED) RETURNS text CHARSET utf8
    NO SQL
BEGIN
    RETURN REPLACE(substring(substring_index(str, ',', pos), length(substring_index(str, ',', pos - 1)) + 1), ',', '');
END$$

DELIMITER ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS authors;
CREATE TABLE authors(
    idAuthor INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idAuthor)
) Engine = InnoDB;

DROP TABLE IF EXISTS genres;
CREATE TABLE genres(
    idGenre INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idGenre)
) Engine = InnoDB;

DROP TABLE IF EXISTS books;
CREATE TABLE books(
    idBook INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL,
	Price DECIMAL(6,2) UNSIGNED NOT NULL,
	Image varchar(25) NOT NULL,
    Description text NOT NULL,
    PRIMARY KEY(idBook)
) Engine = InnoDB;

DROP TABLE IF EXISTS discounts;
CREATE TABLE discounts(
    idDiscount INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Size DECIMAL(3,3) UNSIGNED NOT NULL UNIQUE,
    PRIMARY KEY(idDiscount)
) ENGINE = InnoDB;

INSERT INTO discounts (idDiscount, Size) VALUES
(1, '0.050');

DROP TABLE IF EXISTS order_status;
CREATE TABLE order_status (
    idStatus int(6) UNSIGNED NOT NULL,
    Name varchar(90) NOT NULL UNIQUE,
    PRIMARY KEY(idStatus)
) ENGINE=InnoDB;

INSERT INTO order_status (idStatus, Name) VALUES
(1, 'Formalizing');

DROP TABLE IF EXISTS pay_methods;
CREATE TABLE pay_methods(
    idPayMethod INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idPayMethod)
) Engine = InnoDB;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
    idUser INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Email VARCHAR(45) NOT NULL UNIQUE,
    Password VARCHAR(45) NOT NULL,
    idDiscount INT(6) UNSIGNED,
    PRIMARY KEY(idUser),
    FOREIGN KEY(idDiscount) REFERENCES discounts(idDiscount)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) Engine = InnoDB;


DROP TABLE IF EXISTS users2books;
CREATE TABLE users2books(
    idUser INT(6) UNSIGNED NOT NULL,
    idBook INT(6) UNSIGNED NOT NULL,
    Quantity INT(6) UNSIGNED NOT NULL,
    Price DECIMAL(6,2) UNSIGNED NOT NULL,
	FOREIGN KEY(idUser) REFERENCES users(idUser)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idBook) REFERENCES books(idBook)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;

DROP TABLE IF EXISTS authors2books;
CREATE TABLE authors2books(
    idAuthor INT(6) UNSIGNED NOT NULL,
    idBook INT(6) UNSIGNED NOT NULL,
	FOREIGN KEY(idAuthor) REFERENCES authors(idAuthor)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idBook) REFERENCES books(idBook)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;

DROP TABLE IF EXISTS genres2books;
CREATE TABLE genres2books(
    idGenre INT(6) UNSIGNED NOT NULL,
    idBook INT(6) UNSIGNED NOT NULL,
	FOREIGN KEY(idGenre) REFERENCES genres(idGenre)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idBook) REFERENCES books(idBook)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;

DROP TABLE IF EXISTS orders;
CREATE TABLE orders(
    idOrder INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    idUser INT(6) UNSIGNED NOT NULL,
    idPayMethod INT(6) UNSIGNED NOT NULL,
    Date DATETIME DEFAULT CURRENT_TIMESTAMP,
    idStatus INT(6) UNSIGNED NOT NULL,
    PRIMARY KEY(idOrder),
	FOREIGN KEY(idUser) REFERENCES users(idUser)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idPayMethod) REFERENCES pay_methods(idPayMethod)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
    FOREIGN KEY(idStatus) REFERENCES order_status(idStatus)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;

DROP TABLE IF EXISTS orders2books;
CREATE TABLE orders2books(
    idOrder INT(6) UNSIGNED NOT NULL,
    idBook INT(6) UNSIGNED NOT NULL,
    Quantity INT(6) UNSIGNED NOT NULL,
    Price DECIMAL(6,2) UNSIGNED NOT NULL,
	FOREIGN KEY(idOrder) REFERENCES orders(idOrder)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idBook) REFERENCES books(idBook)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;