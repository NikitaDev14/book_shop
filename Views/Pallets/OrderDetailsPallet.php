<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 07.04.2015
 * Time: 19:05
 */

	namespace Views\Pallets;

	class OrderDetailsPallet extends BasePallet
	{
		public function generate($params)
		{
			$data = $this->objFactory->getObjOrder()->getOrderDetails($params['idOrder'], $params['idUser']);

			echo json_encode($data);
		}
	}
