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
		private $performer;

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
			$this->performer = new \Models\Performers\Book();

			echo json_encode($this->performer->getBooks());
		}
	}