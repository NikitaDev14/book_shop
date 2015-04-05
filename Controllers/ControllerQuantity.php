<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 12:54
 */

	namespace Controllers;

	class ControllerQuantity
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function run()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$quantity = null;

			if(false !== $result)
			{
				$quantity = $this->objFactory->getObjCart()->getCart($result)[0]['Quantity'];
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $quantity]);
		}
	}