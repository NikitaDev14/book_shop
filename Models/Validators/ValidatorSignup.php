<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 23:15
 */

	namespace Models\Validators;

	class ValidatorSignup
	{
		private $form;
		private $objFactory;

		private static $instance;

		private function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new ValidatorSignup();
			}

			return self::$instance;
		}

		public function setForm($form)
		{
			$this->form = $form;
		}

		public function isValidEmail()
		{
			$userExsists = $this->objFactory->getObjUser()->
				exsistsUser($this->form['email']);

			return preg_match(EMAIL_TEMPLATE, $this->form['email']) &&
				!$userExsists;
		}

		public function isValidPassword()
		{
			return preg_match(PASSWORD_TEMPLATE, $this->form['password']);
		}

		public function isValidPasswordRepeat()
		{
			return $this->form['password'] === $this->form['passwordRepeat'];
		}

		public function isValidForm()
		{
			return $this->isValidEmail() &&
				$this->isValidPassword() &&
				$this->isValidPasswordRepeat();
		}
	}