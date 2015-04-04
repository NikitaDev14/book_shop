<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 19:01
 */

	namespace Models\Validators;

	class ValidatorLogin
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
				self::$instance = new ValidatorLogin();
			}

			return self::$instance;
		}

		public function setForm($form)
		{
			$this->form = $form;

			return self::$instance;
		}
		public function isValidForm()
		{
			if(isset($this->form['email'], $this->form['password']))
			{
				$result = $this->objFactory->getUser()->
					isValidLogin($this->form['email'], $this->form['password']);
			}
			else
			{
				$result = false;
			}

			return $result;
		}
	}