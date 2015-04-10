<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 14:06
 */

	namespace Views\Pallets;

	class CartPallet extends BasePallet
	{
		public function generate($idUser)
		{
			$data = $this->objFactory->getObjCart()->getCart($idUser);

			echo json_encode($data);
		}
	}
