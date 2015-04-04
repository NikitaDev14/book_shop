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

			$userId = $this->objFactory->getObjValidatorLogin()
				->setForm($formData)->isValidForm();

			$result = false;

			if(!empty($userId))
			{
				$userId = $userId[0]['idUser'];

				$sessionId = $this->objFactory->getObjSession()->getSessionId();

				$this->objFactory->getUser()->sessionStart($userId, $sessionId);

				$this->objFactory->getObjCookie()->
					setCookie('id', $userId)->
					setCookie('session', $sessionId);

				$result = $userId;
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
	}