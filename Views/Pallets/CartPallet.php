<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 14:06
 */

	namespace Views\Pallets;

	class CartPallet
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function generate($idUser)
		{
			$data = $this->objFactory->getObjCart()->getCart($idUser);

			echo json_encode($data);
		}
	}