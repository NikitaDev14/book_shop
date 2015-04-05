<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 12:57
 */

	namespace Models\Performers;

	class Cart extends \Models\Model
	{
		public function getCart($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getCart(?)')->
				setParam([$idUser])->
				execute()->getResult();
		}
	}