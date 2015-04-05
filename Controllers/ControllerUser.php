<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 23:15
 */

	namespace Controllers;

	class ControllerUser extends \Controllers\BaseController
	{
		public function validate()
		{
			$result = (bool) $this->objFactory->getObjValidatorUser()->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
		public function login()
		{
			$formData = $this->objFactory->getObjHttp()->
			setParams($this->form)->getParams();

			$userId = $this->objFactory->getObjValidatorLogin()
				->setForm($formData)->isValidForm();

			$result = false;

			if(!empty($userId))
			{
				$userId = $userId[0]['idUser'];

				$sessionId = $this->objFactory->getObjSession()->getSessionId();

				$this->objFactory->getObjUser()->sessionStart($userId, $sessionId);

				$this->objFactory->getObjCookie()->
					setCookie('id', $userId)->
					setCookie('session', $sessionId);

				$result = $userId;
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
		public function logout()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false !== $result)
			{
				$this->objFactory->getObjUser()->sessionDestroy($result);

				$this->objFactory->getObjCookie()->
					deleteCookie('id')->deleteCookie('session');
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Logout', 'result' => $result]);
		}
		public function singup()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$validator = $this->objFactory->getObjValidatorSignup();

			$validator->setForm($formData);

			$isValidForm = $validator->isValidForm();

			$result = false;

			if($isValidForm)
			{
				$result = (bool) $this->objFactory->getObjUser()->
					addUser($formData['email'], $formData['password']);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
	}