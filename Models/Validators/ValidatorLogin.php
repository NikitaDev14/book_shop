<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 19:01
 */

	namespace Models\Validators;

	class ValidatorLogin extends \BaseClass
	{
		private static $instance;
		private $form;

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
				$result = $this->objFactory->getObjUser()->
					isValidLogin($this->form['email'], $this->form['password']);
			}
			else
			{
				$result = false;
			}

			return $result;
		}
	}