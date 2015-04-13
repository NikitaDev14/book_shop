<?php

	namespace Models\Performers;

	class Author extends \BaseRegular
	{
		/**
		 * @return all authors (idAuthor, Name)
		 */
		public function getAuthors()
		{
			return $this->objFactory->getObjDatabase()->
			setQuery('CALL getAuthors(?)')->
				setParam([0])->execute()->getResult();
		}
	}