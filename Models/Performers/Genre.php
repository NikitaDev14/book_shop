<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 10:44
 */
	namespace Models\Performers;

	class Genre extends \Models\BaseModel
	{
		public function getGenres()
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getGenres(?)')->
				setParam([0])->execute()->getResult();
		}
	}