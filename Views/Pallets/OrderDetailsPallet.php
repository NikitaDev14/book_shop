<?php

	namespace Views\Pallets;

	class OrderDetailsPallet extends \BaseRegular
	{
		/**
		 * @param $params (idOrder, idUser)
		 * show idBook, BookName, Quantity, Price of specified order
		 */
		public function generate($params)
		{
			$data = $this->objFactory->getObjOrder()->
			getOrderDetails($params['idOrder'], $params['idUser']);

			echo json_encode($data);
		}
	}