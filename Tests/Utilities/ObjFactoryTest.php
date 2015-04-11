<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 10.04.2015
	 * Time: 10:16
	 */

	namespace Tests\Utilities;

	require_once '../requires.php';

	class ObjFactoryTest extends \PHPUnit_Framework_TestCase
	{
		private $objFactory;

		public function __construct()
		{
			parent::__construct();

			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}

		public function testConstructSingleton()
		{
			$obj1 = $this->objFactory->getInstance();
			$obj2 = $this->objFactory->getInstance();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testConstruct()
		{
			$obj = $this->objFactory->getInstance();

			$this->assertInstanceOf('\Models\Utilities\ObjFactory', $obj);
		}

		public function testHasInstance()
		{
			$this->assertClassHasStaticAttribute('instance', '\Models\Utilities\ObjFactory');
		}

		public function testHasDatabase()
		{
			$this->assertClassHasStaticAttribute('database', '\Models\Utilities\ObjFactory');
		}

		/*
		public function testGetDatabase()
		{
			$obj1 = \Models\Utilities\ObjFactory::getInstance()->getObjDatabase();
			$obj2 = \Models\Utilities\ObjFactory::getInstance()->getObjDatabase();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}
		*/
		public function testGetDataContainer()
		{
			$obj1 = $this->objFactory->getInstance()->getObjDataContainer();
			$obj2 = $this->objFactory->getInstance()->getObjDataContainer();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testGetValidatorSignup()
		{
			$obj1 = $this->objFactory->getInstance()->getObjValidatorSignup();
			$obj2 = $this->objFactory->getInstance()->getObjValidatorSignup();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testGetValidatorUser()
		{
			$obj1 = $this->objFactory->getInstance()->getObjValidatorUser();
			$obj2 = $this->objFactory->getInstance()->getObjValidatorUser();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testGetValidatorLogin()
		{
			$obj1 = $this->objFactory->getInstance()->getObjValidatorLogin();
			$obj2 = $this->objFactory->getInstance()->getObjValidatorLogin();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testGetHttp()
		{
			$obj1 = $this->objFactory->getInstance()->getObjHttp();
			$obj2 = $this->objFactory->getInstance()->getObjHttp();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		/*
		public function testGetSession()
		{
			$obj = $this->objFactory->getInstance()->getObjSession();

			$this->assertNotEmpty($obj, gettype($obj));
		}
		*/
		public function testGetCookie()
		{
			$obj = $this->objFactory->getInstance()->getObjCookie();

			$this->assertInstanceOf('\Models\Interfaces\Cookie', $obj);
		}

		public function testGetBook()
		{
			$obj = $this->objFactory->getInstance()->getObjBook();

			$this->assertInstanceOf('\Models\Performers\Book', $obj);
		}

		public function testGetAuthor()
		{
			$obj = $this->objFactory->getInstance()->getObjAuthor();

			$this->assertInstanceOf('\Models\Performers\Author', $obj);
		}

		public function testGetGenre()
		{
			$obj = $this->objFactory->getInstance()->getObjGenre();

			$this->assertInstanceOf('\Models\Performers\Genre', $obj);
		}

		public function testGetUser()
		{
			$obj = $this->objFactory->getInstance()->getObjUser();

			$this->assertInstanceOf('\Models\Performers\User', $obj);
		}

		public function testGetCart()
		{
			$obj = $this->objFactory->getInstance()->getObjCart();

			$this->assertInstanceOf('\Models\Performers\Cart', $obj);
		}

		public function testGetOrder()
		{
			$obj = $this->objFactory->getInstance()->getObjOrder();

			$this->assertInstanceOf('\Models\Performers\Order', $obj);
		}
	}