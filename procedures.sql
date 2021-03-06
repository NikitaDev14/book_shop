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

DROP PROCEDURE IF EXISTS `getAllDiscounts`$$
CREATE PROCEDURE `getAllDiscounts`()
    READS SQL DATA
BEGIN
	SELECT d.idDiscount, d.Size
    FROM discounts AS d;
END$$

DROP PROCEDURE IF EXISTS `getAllOrders`$$
CREATE PROCEDURE `getAllOrders`()
    READS SQL DATA
BEGIN
    SELECT o.idOrder, o.Date, pm.Name AS PayMethod, SUM(o2b.Price*o2b.Quantity) AS Summ, os.Name AS OrderStatus
    FROM orders AS o
    	JOIN pay_methods AS pm
        	ON pm.idPayMethod = o.idPayMethod
        JOIN orders2books AS o2b
        	ON o2b.idOrder = o.idOrder
        JOIN order_status AS os
        	ON os.idStatus = o.idStatus
    GROUP BY(o.idOrder)
    ORDER BY(o.Date) DESC;
END$$

DROP PROCEDURE IF EXISTS `getAllUsers`$$
CREATE PROCEDURE `getAllUsers`()
    READS SQL DATA
BEGIN
	SELECT users.idUser, users.Email, discounts.Size AS Discount
    FROM users
    	JOIN discounts
        	ON users.idDiscount = discounts.idDiscount;
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

DROP PROCEDURE IF EXISTS `getDiscount`$$
CREATE PROCEDURE `getDiscount`(IN `idDiscount` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idDiscount'
BEGIN
	SELECT d.idDiscount, d.Size
    FROM discounts AS d
    WHERE d.idDiscount = idDiscount;
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

DROP PROCEDURE IF EXISTS `getOrderById`$$
CREATE PROCEDURE `getOrderById`(IN `idOrder` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idOrder'
BEGIN
    SELECT o.idOrder, o.Date, pm.Name AS PayMethod, SUM(o2b.Price*o2b.Quantity) AS Summ, os.idStatus, os.Name AS OrderStatus
    FROM orders AS o
    	JOIN pay_methods AS pm
        	ON pm.idPayMethod = o.idPayMethod
        JOIN orders2books AS o2b
        	ON o2b.idOrder = o.idOrder
        JOIN order_status AS os
        	ON os.idStatus = o.idStatus
    WHERE o.idOrder = idOrder
    GROUP BY(o.idOrder)
    ORDER BY(o.Date) DESC;
END$$

DROP PROCEDURE IF EXISTS `getOrderDetails`$$
CREATE PROCEDURE `getOrderDetails`(IN `idOrder` INT(6) UNSIGNED, IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idOrder @idUser'
BEGIN
    SELECT o2b.idBook, b.Name AS BookName, o2b.Quantity, o2b.Price
    FROM orders AS o
        JOIN orders2books AS o2b
        	ON o2b.idOrder = o.idOrder
        JOIN books AS b
        	ON b.idBook = o2b.idBook
    WHERE o.idUser = idUser
    	AND o.idOrder = idOrder
    ORDER BY(o.idOrder);
END$$

DROP PROCEDURE IF EXISTS `getOrdersByUser`$$
CREATE PROCEDURE `getOrdersByUser`(IN `idUser` INT(6) UNSIGNED)
    READS SQL DATA
    COMMENT '@idUser'
BEGIN
    SELECT o.idOrder, o.Date, pm.Name AS PayMethod, SUM(o2b.Price*o2b.Quantity) AS Summ, os.Name AS OrderStatus
    FROM orders AS o
    	JOIN pay_methods AS pm
        	ON pm.idPayMethod = o.idPayMethod
        JOIN orders2books AS o2b
        	ON o2b.idOrder = o.idOrder
        JOIN order_status AS os
        	ON os.idStatus = o.idStatus
    WHERE o.idUser = idUser
    GROUP BY(o.idOrder)
    ORDER BY(o.Date) DESC;
END$$

DROP PROCEDURE IF EXISTS `getOrderStatuses`$$
CREATE PROCEDURE `getOrderStatuses`()
    READS SQL DATA
BEGIN
	SELECT os.idStatus, os.Name
    FROM order_status AS os;
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
	SELECT u.idUser, u.Email, d.idDiscount, d.Size AS Discount
    FROM users AS u
    	JOIN discounts AS d
        	ON u.idDiscount = d.idDiscount
    WHERE u.idUser = idUser;
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

DROP PROCEDURE IF EXISTS `updateDiscount`$$
CREATE PROCEDURE `updateDiscount`(IN `idDiscount` INT(6) UNSIGNED, IN `size` DECIMAL(3,3) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idDiscount @size'
BEGIN
	UPDATE discounts
    SET discounts.Size = size
    WHERE discounts.idDiscount = idDiscount;

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

DROP PROCEDURE IF EXISTS `updateOrderStatus`$$
CREATE PROCEDURE `updateOrderStatus`(IN `idOrder` INT(6) UNSIGNED, IN `idStatus` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idOrder @idStatus'
BEGIN
	UPDATE orders
    SET orders.idStatus = idStatus
    WHERE orders.idOrder = idOrder;

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

DROP PROCEDURE IF EXISTS `updateUserDiscount`$$
CREATE PROCEDURE `updateUserDiscount`(IN `idUser` INT(6) UNSIGNED, IN `idDiscount` INT(6) UNSIGNED)
    MODIFIES SQL DATA
    COMMENT '@idUser @idDiscount'
BEGIN
	UPDATE users
    SET users.idDiscount = idDiscount
    WHERE users.idUser = idUser;

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