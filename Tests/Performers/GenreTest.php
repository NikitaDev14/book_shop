<?php

	namespace Tests\Performers;

	require_once '../requires.php';

	class GenreTest extends \Tests\RegularTest
	{
		public function __construct()
		{
			parent::__construct('\Models\Performers\Genre',
				new \Models\Performers\Genre());
		}

		public function testGetBooksKey()
		{
			$this->assertArrayHasKey('idGenre',
				$this->instance->getGenres(0)[0]);
		}
	}