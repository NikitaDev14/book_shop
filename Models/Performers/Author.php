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
			return $this->objFactory->getObjDatabase()->
			setQuery('CALL getAuthors(?)')->
				setParam([0])->execute()->getResult();
		}
	}