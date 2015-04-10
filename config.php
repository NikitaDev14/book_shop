<?php
	
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'user10');
	define('DB_USER', 'user10');
	define('DB_PASS', 'tuser10');

	define('BASE_URL', '/~user10/PHP/book_shop/');
	define('BASE_URL_ADMIN', '/~user10/PHP/book_shop/admin/');
	/*
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'book_shop');
	define('DB_USER', 'root');
	define('DB_PASS', '1234');

	define('BASE_URL', '/book_shop/');
	define('BASE_URL_ADMIN', '/book_shop/admin/');
	*/
	define('EMAIL_TEMPLATE', '/[0-9a-z_]+@[0-9a-z_]+\\.[a-z]{1,5}/i');
	define('PASSWORD_TEMPLATE', '/.{4,}/');

	define('COOKIE_EXPIRE', 60*15);

	define('BASE_PATH_FOR_TESTS', '../../');
