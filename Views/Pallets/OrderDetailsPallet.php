<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 07.04.2015
 * Time: 19:05
 */

	namespace Views\Pallets;

	class OrderDetailsPallet
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function generate($params)
		{
			$data = $this->objFactory->getObjOrder()->getOrderDetails($params['idOrder'], $params['idUser']);

			echo json_encode($data);
		}
	}