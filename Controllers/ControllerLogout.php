<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 23:29
 */

	namespace Controllers;

	class ControllerLogout
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function run()
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
	}