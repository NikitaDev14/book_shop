<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 9:19
	 */

	namespace Tests\Validators;

	require_once '../requires.php';

	class ValidatorSignupTest extends \Tests\SingletonTest
	{
		public function __construct()
		{
			parent::__construct('\Models\Validators\ValidatorSignup',
				\Models\Validators\ValidatorSignup::getInstance());
		}

		public function testHasForm()
		{
			$this->assertClassHasAttribute('form', $this->className);
		}

		public function testSetForm()
		{
			$this->assertInstanceOf($this->className,
				$this->instance->setForm([
						'email' => TEST_EMAIL,
						'password' => TEST_PASSWORD,
						'passwordRepeat' => TEST_PASSWORD_REPEAT]
				));
		}

		public function testIsValidEmail()
		{
			$this->assertFalse($this->instance->isValidEmail());
		}

		public function testIsValidPassword()
		{
			$this->assertTrue($this->instance->isValidPassword());
		}

		public function testIsValidPasswordRepeat()
		{
			$this->assertTrue($this->instance->isValidPasswordRepeat());
		}

		public function testIsValidForm()
		{
			$this->assertFalse($this->instance->isValidForm());
		}
	}