<?php

	namespace Controllers;

	class ControllerUser extends \Controllers\BaseController
	{
		/**
		 * if user is logged
		 * set response true, false otherwise
		 */
		public function validate()
		{
			$result = (bool)$this->objFactory->getObjValidatorUser()
				->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}

		/**
		 * get from HTTP form an email and password
		 * if this pair is valid begin session and set cookie,
		 * set response true, false otherwise
		 */
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

				$sessionId = $this->objFactory->getObjSession()
					->getSessionId();

				$this->objFactory->getObjUser()
					->sessionStart($userId, $sessionId);

				$this->objFactory->getObjCookie()->
					setCookie('id', $userId)->
					setCookie('session', $sessionId);

				$result = $userId;
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}

		/**
		 * if user is logged delete cookie and session
		 * set response true, false otherwise
		 */
		public function logout()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false != $result)
			{
				$this->objFactory->getObjUser()->sessionDestroy($result);

				$this->objFactory->getObjCookie()->
					deleteCookie('id')->deleteCookie('session');
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Logout', 'result' => $result]);
		}

		/**
		 * get from HTTP form an email, password and repeated password
		 * if this params is valid add a new user,
		 * set response true, false otherwise
		 */
		public function signup()
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