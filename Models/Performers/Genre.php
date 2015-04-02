<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 10:44
 */
	namespace Models\Performers;

	class Genre extends \Models\Model
	{
		public function getGenres()
		{
			return $this->database->setQuery('CALL getGenres(:genre)')->
				setParam([':genre' => 0])->execute()->getResult();
		}
	}