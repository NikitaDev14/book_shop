<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 13:35
	 */

	namespace Tests;

	class RegularTest extends \PHPUnit_Framework_TestCase
	{
		protected $className;
		protected $instance;

		public function __construct($className, $instance)
		{
			parent::__construct();

			$this->className = $className;
			$this->instance = $instance;
		}

		public function testHasObjFactory()
		{
			$this->assertClassHasAttribute('objFactory', $this->className);
		}

		public function testConstruct()
		{
			$this->assertInstanceOf($this->className, $this->instance);
		}
	}