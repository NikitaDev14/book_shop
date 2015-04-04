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
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function actionSignup($form)
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($form)->getParams();

			$validator = $this->objFactory->getObjValidatorSignup();

			$validator->setForm($formData);

			$isValidForm = $validator->isValidForm();

			$result = false;

			if($isValidForm)
			{
				$result = (bool) $this->objFactory->getUser()->
					addUser($formData['email'], $formData['password']);
			}

			//echo $result;

			$this->objFactory->getObjDataContainer()->setParams(['nextPage' => 'Signup', 'result' => $result]);
		}
	}