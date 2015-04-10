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
		public function testConstruct()
		{
			$obj1 = \Models\Utilities\ObjFactory::getInstance();
			$obj2 = \Models\Utilities\ObjFactory::getInstance();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}

		public function testGetDatabase()
		{
			$obj1 = \Models\Utilities\ObjFactory::getInstance()->getObjDatabase();
			$obj2 = \Models\Utilities\ObjFactory::getInstance()->getObjDatabase();

			$this->assertSame($obj1, $obj2, 'Objects are not the same');
		}
	}