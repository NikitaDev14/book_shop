<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 12:57
 */

	namespace Models\Performers;

	class Cart extends \Models\BaseModel
	{
		public function getCart($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getCart(?)')->
				setParam([$idUser])->
				execute()->getResult();
		}
		public function addToCart($idUser, $idBook, $quantity)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL addToCart(?, ?, ?)')->
				setParam([$idUser, $idBook, $quantity])->
				execute()->getResult();
		}
		public function deleteFromCart($idUser, $idBook)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL deleteFromCart(?, ?)')->
				setParam([$idUser, $idBook])->
				execute()->getResult();
		}
		public function updateQuantity($idUser, $idBook, $quantity)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL updateQuantityInCart(?, ?, ?)')->
				setParam([$idUser, $idBook, $quantity])->
				execute()->getResult();
		}
	}