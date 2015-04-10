<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 19:33
	 */
	namespace Models\Performers;

	class Book extends \Models\BaseModel
	{
		public function getBooks($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getBooks(?)')->
				setParam([$idUser])->execute()->getResult();
		}
	}