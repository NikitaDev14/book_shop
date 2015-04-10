<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 14:19
 */

	namespace Views\Pallets;

	class BookListPallet extends BasePallet
	{
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
