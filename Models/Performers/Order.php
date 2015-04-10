<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 06.04.2015
 * Time: 20:18
 */

	namespace Models\Performers;

	class Order extends \Models\BaseModel
	{
		public function getPayMethods()
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getPayMethods()')->
				execute()->getResult();
		}
		public function addOrder($idUser, $idPayMethod)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL addOrder(?, ?)')->
				setParam([$idUser, $idPayMethod])->
				execute()->getResult();
		}
		public function getOrders($idUser)
		{
			return $this->objFactory->getObjDatabase()->
			setQuery('CALL getOrdersByUser(?)')->
				setParam([$idUser])->execute()->getResult();
		}
		public function getOrderDetails($idOrder, $idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getOrderDetails(?, ?)')->
				setParam([$idOrder, $idUser])->
				execute()->getResult();
		}
	}