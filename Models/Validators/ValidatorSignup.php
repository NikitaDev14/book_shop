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
		private $database;

		private static $instance;

		private function __construct()
		{
			$this->database =
				new \Models\Interfaces\Database();
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
			$userExsists = $this->database->setQuery('CALL getUser(:email)')->
				setParam([':email' => $this->form['email']])->execute()->getResult();

			return preg_match(EMAIL_TEMPLATE, $this->form['email']) && !$userExsists;
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