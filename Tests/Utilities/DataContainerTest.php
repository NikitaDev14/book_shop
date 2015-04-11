<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 11.04.2015
	 * Time: 20:53
	 */

	namespace Tests\Utilities;

	require_once '../requires.php';

	class DataContainerTest extends \PHPUnit_Framework_TestCase
	{
		private $dataContainer;
		private $className;
		private $testParam;

		public function __construct()
		{
			parent::__construct();

			$this->dataContainer = \Models\Utilities\DataContainer::getInstance();
			$this->className = '\Models\Utilities\DataContainer';
			$this->testParam = ['nextPage' => 'index', 'result' => true];
		}

		public function testHasInstance()
		{
			$this->assertClassHasStaticAttribute('instance', $this->className);
		}

		public function testHasParams()
		{
			$this->assertClassHasAttribute('params', $this->className);
		}

		public function testConstructSingleton()
		{
			$obj1 = $this->dataContainer->getInstance();
			$obj2 = $this->dataContainer->getInstance();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testConstruct()
		{
			$this->assertInstanceOf($this->className, $this->dataContainer);
		}

		public function testGetParams()
		{
			$this->dataContainer->setParams($this->testParam);

			$this->assertArrayHasKey('nextPage',
				$this->dataContainer->getParams());
		}

		public function testSetParams()
		{
			$this->assertInstanceOf($this->className,
				$this->dataContainer->setParams($this->testParam));
		}
	}