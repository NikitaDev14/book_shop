<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 19:33
	 */
	namespace Models\Performers;

	class Book
	{
		private $database;

		public function __construct()
		{
			$this->database =
				new \Models\Interfaces\Database('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
		}

		public function getBooks()
		{
			return $this->database->setQuery('CALL getBooks()')->execute()->getResult();
		}
	}