<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 10:21
 */
	namespace Models\Performers;

	class Author
	{
		private $database;

		public function __construct()
		{
			$this->database =
				new \Models\Interfaces\Database('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
		}

		public function getAuthors()
		{
			return $this->database->setQuery('CALL getAuthors(:author)')->
				setParam([':author' => 0])->execute()->getResult();
		}
	}