<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 11.04.2015
	 * Time: 22:44
	 */

	namespace Tests\Validators;

	require_once '../requires.php';

	class ValidatorLoginTest extends \PHPUnit_Framework_TestCase
	{
		private $className;
		private $validatorLogin;

		public function __construct()
		{
			parent::__construct();

			$this->className = '\Models\Validators\ValidatorLogin';
			$this->validatorLogin = \Models\Validators\ValidatorLogin::getInstance();
		}

		public function testHasIntance()
		{
			$this->assertClassHasStaticAttribute('instance', $this->className);
		}

		public function testHasForm()
		{
			$this->assertClassHasAttribute('form', $this->className);
		}

		public function testContructSingleton()
		{
			$obj1 = $this->validatorLogin->getInstance();
			$obj2 = $this->validatorLogin->getInstance();

			$this->assertSame($obj1, $obj2);
		}

		public function testConstruct()
		{
			$this->assertInstanceOf($this->className, $this->validatorLogin);
		}

		public function testSetForm()
		{
			$this->assertInstanceOf($this->className,
				$this->validatorLogin->setForm(
					['email' => TEST_EMAIL, 'password' => TEST_PASSWORD]
				));
		}

		public function testIsValidForm()
		{
			$result = $this->validatorLogin->isValidForm();

			$this->assertEquals(TEST_ID_USER, $result[0]['idUser']);
		}
	}