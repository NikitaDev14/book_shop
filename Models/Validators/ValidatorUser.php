<?php

	namespace Models\Validators;

	class ValidatorUser extends \BaseSingleton
	{
		private static $instance;

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new ValidatorUser();
			}

			return self::$instance;
		}

		/**
		 * @return idUser if session is set and cookie is not expired
		 * otherwise delete cookie and session, return false
		 */
		public function isValidUser()
		{
			$cookie = $this->objFactory->getObjCookie();

			$idUser = $cookie->getCookie('id');
			$sessionId = $cookie->getCookie('session');

			if(!empty($idUser) && !empty($sessionId))
			{
				$user = $this->objFactory->getObjUser()->
					isValidUser($idUser, $sessionId);

				if($user[0]['idUser'] === $idUser &&
					$user[0]['SessionId'] === $sessionId)
				{
					$result = $idUser;
				}
				else
				{
					$cookie->deleteCookie('id')->deleteCookie('session');

					$result = false;
				}
			}
			else
			{
				$result = false;
			}

			return $result;
		}
	}