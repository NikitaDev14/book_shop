<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 22:37
 */

	namespace Models\Validators;

	class ValidatorUser
	{
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
				self::$instance = new ValidatorUser();
			}

			return self::$instance;
		}
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