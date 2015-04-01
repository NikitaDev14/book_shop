CREATE DATABASE book_shop DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

SET TIME_ZONE = "+02:00";

USE book_shop;

DELIMITER $$
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

DROP PROCEDURE IF EXISTS `deleteGenre`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteGenre`(IN `idGenre` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idGenre'
BEGIN
	DELETE FROM genres
    WHERE genres.idGenre = idGenre;

    SELECT ROW_COUNT();
END$$

DROP PROCEDURE IF EXISTS `getAuthors`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getAuthors`(IN `idAuthor` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT 'get all authors if @idAuthor is not specified'
BEGIN
	IF(idAuthor = 0)THEN
    	SELECT authors.idAuthor, authors.Name
        FROM authors;
    ELSE
    	SELECT authors.idAuthor, authors.Name
        FROM authors
        WHERE authors.idAuthor = idAuthor;
    END IF;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBooks`()
    READS SQL DATA
BEGIN
	   	SELECT GROUP_CONCAT(DISTINCT authors.Name) AS Authors, GROUP_CONCAT(DISTINCT genres.Name) AS Genres, books.idBook, books.Name, books.Image, books.Price, descriptions.Content AS Description
        	FROM genres
            	JOIN genres2books
                	ON genres.idGenre = genres2books.idGenre
                JOIN books
                    ON genres2books.idBook = books.idBook
                JOIN descriptions
                	ON books.idBook = descriptions.idBook
                JOIN authors2books
                	ON books.idBook = authors2books.idBook
                JOIN authors
                	ON authors2books.idAuthor = authors.idAuthor
        GROUP BY(books.idBook);
END$$

DROP PROCEDURE IF EXISTS `getGenres`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getGenres`(IN `idGenre` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT 'get all genres if @idGenre is not specified'
BEGIN
	IF(idGenre = 0)THEN
    	SELECT genres.idGenre, genres.Name
        FROM genres;
    ELSE
    	SELECT genres.idGenre, genres.Name
        FROM genres
        WHERE genres.idGenre = idGenre;
    END IF;
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

DROP FUNCTION IF EXISTS `strSplit`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `strSplit`(`str` TEXT CHARSET utf8, `pos` INT(6) UNSIGNED) RETURNS text CHARSET utf8
    NO SQL
BEGIN
    RETURN REPLACE(substring(substring_index(str, ',', pos), length(substring_index(str, ',', pos - 1)) + 1), ',', '');
END$$

DELIMITER ;

CREATE TABLE authors(
    idAuthor INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idAuthor)
) Engine = InnoDB;
	
CREATE TABLE genres(
    idGenre INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idGenre)
) Engine = InnoDB;
	
CREATE TABLE books(
    idBook INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL,
	price DECIMAL(6,2) UNSIGNED NOT NULL,
    PRIMARY KEY(idBook)
) Engine = InnoDB;

CREATE TABLE discounts(
    idDiscount INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Size DECIMAL(3,3) UNSIGNED NOT NULL UNIQUE,
    PRIMARY KEY(idDiscount)
) ENGINE=InnoDB;
	
CREATE TABLE descriptions(
    idBook INT(6) UNSIGNED NOT NULL,
    Content TEXT(1000) NOT NULL,
	FOREIGN KEY(idBook) REFERENCES books(idBook)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;
	
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

CREATE TABLE pay_methods(
    idPayMethod INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY(idPayMethod)
) Engine = InnoDB;

CREATE TABLE users(
    idUser INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    Login VARCHAR(45) NOT NULL UNIQUE,
    Password VARCHAR(45) NOT NULL,
    idDiscount INT(6) UNSIGNED,
    PRIMARY KEY(idUser),
    FOREIGN KEY(idDiscount) REFERENCES discounts(idDiscount)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) Engine = InnoDB;

CREATE TABLE orders(
    idOrder INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    idUser INT(6) UNSIGNED NOT NULL,
    idPayMethod INT(6) UNSIGNED NOT NULL,
    Date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(idOrder),
	FOREIGN KEY(idUser) REFERENCES users(idUser)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(idPayMethod) REFERENCES pay_methods(idPayMethod)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) Engine = InnoDB;

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