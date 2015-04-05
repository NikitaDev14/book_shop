<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 14:19
 */

	namespace Views\Pallets;

	class BookListPallet
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function generate()
		{
			$data =
				[
					'books' => $this->objFactory->getObjBook()->getBooks(),
					'authors' => $this->objFactory->getObjAuthor()->getAuthors(),
					'genres' => $this->objFactory->getObjGenre()->getGenres()
				];

			echo json_encode($data);
		}
	}