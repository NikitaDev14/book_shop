<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 19:33
	 */
	namespace Models\Performers;

	class Book extends \Models\Model
	{
		public function getBooks()
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getBooks()')->execute()->getResult();
		}
	}