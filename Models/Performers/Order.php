<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 06.04.2015
 * Time: 20:18
 */

	namespace Models\Performers;

	class Order extends \Models\Model
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
	}