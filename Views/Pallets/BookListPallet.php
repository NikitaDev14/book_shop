<?php

	namespace Views\Pallets;

	class BookListPallet extends \BaseRegular
	{
		/**
		 * show all book +
		 * all authors and genres as filters
		 * @param $idUser , if he's logged price will reduced
		 * on size of personal discount
		 */
		public function generate($idUser)
		{
			$data =
				[
					'books' => $this->objFactory->getObjBook()->getBooks($idUser),
					'authors' => $this->objFactory->getObjAuthor()->getAuthors(),
					'genres' => $this->objFactory->getObjGenre()->getGenres()
				];

			echo json_encode($data);
		}
	}
