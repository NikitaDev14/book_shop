<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 10:44
 */
	namespace Models\Performers;

	class Genre
	{
		private $database;

		public function __construct()
		{
			$this->database =
				new \Models\Interfaces\Database('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
		}

		public function getGenres()
		{
			return $this->database->setQuery('CALL getGenres(:genre)')->
				setParam([':genre' => 0])->execute()->getResult();
		}
	}