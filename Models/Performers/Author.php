<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 10:21
 */
	namespace Models\Performers;

	class Author extends \Models\Model
	{
		public function getAuthors()
		{
			return $this->database->setQuery('CALL getAuthors(:author)')->
				setParam([':author' => 0])->execute()->getResult();
		}
	}