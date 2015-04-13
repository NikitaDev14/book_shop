<?php

	namespace Models\Performers;

	class Book extends \BaseRegular
	{
		/**
		 * @param $idUser if it's specified,
		 * price will reduced on user discount
		 * otherwise normal price
		 * @return all books (Authors, Genres, idBook,
		 *      Name, Image, Price, Description)
		 */
		public function getBooks($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getBooks(?)')->
				setParam([$idUser])->execute()->getResult();
		}
	}