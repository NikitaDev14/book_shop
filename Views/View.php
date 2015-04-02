<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 17:36
	 */

	namespace Views;

	class View
	{
		private $dataContainer;

		public function __construct()
		{
			$this->dataContainer = \Models\Utilities\DataContainer::getInstance();
		}

		public function index()
		{
			require_once 'Resources/html/index.html';
		}

		public function getBookList()
		{
			$data =
				[
					'books' => (new \Models\Performers\Book())->getBooks(),
					'authors' => (new \Models\Performers\Author())->getAuthors(),
					'genres' => (new \Models\Performers\Genre())->getGenres()
				];

			echo json_encode($data);
		}
	}