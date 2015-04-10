<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 07.04.2015
 * Time: 11:29
 */

	namespace Views\Pallets;

	class OrderListPallet extends BasePallet
	{
		public function generate($idUser)
		{
			$data = $this->objFactory->getObjOrder()->getOrders($idUser);

			echo json_encode($data);
		}
	}
