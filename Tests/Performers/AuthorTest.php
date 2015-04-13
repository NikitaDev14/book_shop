<?php

	namespace Tests\Performers;

	require_once '../requires.php';

	class AuthorTest extends \Tests\RegularTest
	{
		public function __construct()
		{
			parent::__construct('\Models\Performers\Author',
				new \Models\Performers\Author());
		}

		public function testGetAuthorsKey()
		{
			$this->assertArrayHasKey('idAuthor',
				$this->instance->getAuthors()[0]);
		}
	}