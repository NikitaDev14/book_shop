<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 11:35
	 */

	namespace Tests\Interfaces;

	require_once '../requires.php';

	class DatabaseTest extends \PHPUnit_Framework_TestCase
	{
		private $className;
		private $instance;

		public function __construct()
		{
			parent::__construct();

			$this->className = '\Models\Interfaces\Database';
			$this->instance =
				new \Models\Interfaces\Database(DB_NAME, DB_HOST, DB_USER, DB_PASS);
		}

		public function testHasDb()
		{
			$this->assertClassHasAttribute('db', $this->className);
		}

		public function testHasSth()
		{
			$this->assertClassHasAttribute('sth', $this->className);
		}

		public function testConstruct()
		{
			$this->assertInstanceOf($this->className, $this->instance);
		}

		public function testSetQuery()
		{
			$query = 'SELECT u.idUser, u.Email
					FROM users AS u
					WHERE u.idUser = ' . TEST_ID_USER;
			$this->assertInstanceOf($this->className,
				$this->instance->setQuery($query));
		}
	}