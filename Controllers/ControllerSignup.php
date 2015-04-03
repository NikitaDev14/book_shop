<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 23:14
 */

	namespace Controllers;

	class ControllerSignup
	{
		private $form;
		private $validator;
		private $dataContainer;

		public function __construct($form)
		{
			$this->form = \Models\Interfaces\Http::getInstance()->setParams($form)->getParams();
			$this->validator = \Models\Validators\ValidatorSignup::getInstance();
			$this->dataContainer = \Models\Utilities\DataContainer::getInstance();
		}
		public function actionSignup()
		{
			$this->validator->setForm($this->form);

			$result = $this->validator->isValidForm();

			var_dump($result);

			$this->dataContainer->setNextPage($result);
		}
	}