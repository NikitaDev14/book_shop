<?php

	namespace Models\Performers;

	class Genre extends \BaseRegular
	{
		/**
		 * @return all genre (idGenre, Name)
		 */
		public function getGenres()
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getGenres(?)')->
				setParam([0])->execute()->getResult();
		}
	}