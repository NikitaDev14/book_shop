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
		private $book;
		private $author;
		private $genre;

		public function __construct()
		{
			$this->dataContainer = \Models\Utilities\DataContainer::getInstance();
			$this->book = new \Models\Performers\Book();
			$this->author = new \Models\Performers\Author();
			$this->genre = new \Models\Performers\Genre();
		}

		public function render()
		{
			$nextPage = $this->dataContainer->getNextPage();

			if('index' === $nextPage)
			{
				require_once 'Resources/html/index.html';
			}
			else
			{
				$data =
					[
						'books' => $this->book->getBooks(),
						'authors' => $this->author->getAuthors(),
						'genres' => $this->genre->getGenres()
					];

				echo json_encode($data);
			}
		}
	}