<?php

	namespace Views\Pallets;

	class CartPallet extends \BaseRegular
	{
		/**
		 * @param $idUser
		 * show all books in the cart
		 */
		public function generate($idUser)
		{
			$data = $this->objFactory->getObjCart()->getCart($idUser);

			echo json_encode($data);
		}
	}
