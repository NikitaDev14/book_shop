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
		private $objFactory;

		public function __construct()
		{
			$this->dataContainer = \Models\Utilities\DataContainer::getInstance();
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
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
						'books' => $this->objFactory->getBook()->getBooks(),
						'authors' => $this->objFactory->getAuthor()->getAuthors(),
						'genres' => $this->objFactory->getGenre()->getGenres()
					];

				echo json_encode($data);
			}
		}
	}