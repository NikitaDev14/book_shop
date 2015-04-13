<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 13:32
	 */

	namespace Tests\Performers;

	require_once '../requires.php';

	class BookTest extends \Tests\RegularTest
	{
		public function __construct()
		{
			parent::__construct('\Models\Performers\Book',
				new \Models\Performers\Book());
		}

		public function testGetBooksKey()
		{
			$this->assertArrayHasKey('idBook', $this->instance->getBooks(0)[0]);
		}
	}