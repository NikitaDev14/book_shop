<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 14:08
 */

	namespace Controllers;

	class ControllerCart
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function getCart()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Cart', 'result' => $result]);
		}
	}