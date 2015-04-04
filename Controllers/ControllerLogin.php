<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 16:45
 */

	namespace Controllers;

	class ControllerLogin
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function run($form)
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($form)->getParams();

			$validator = $this->objFactory->getObjValidatorLogin();

			$validator->setForm($formData);

			$userId = $validator->isValidForm();

			$result = false;

			if(null != $userId)
			{
				$userId = $userId[0]['idUser'];

				$sessionId = $this->objFactory->getObjSession()->getSessionId();

				$this->objFactory->getUser()->sessionStart($userId, $sessionId);

				$this->objFactory->getObjCookie()->
					setCookie('id', $userId)->
					setCookie('session', $sessionId);

				var_dump($sessionId);
				var_dump($userId[0]['idUser']);

				$result = true;
			}

			var_dump($result);

			//$this->objFactory->getObjDataContainer()->setParams(['nextPage' => 'Signup', 'result' => $result]);
		}
	}