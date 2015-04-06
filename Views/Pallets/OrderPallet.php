<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 06.04.2015
 * Time: 20:34
 */

	namespace Views\Pallets;

	class OrderPallet
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function generate()
		{
			$data = $this->objFactory->getObjOrder()->getPayMethods();

			echo json_encode($data);
		}
	}