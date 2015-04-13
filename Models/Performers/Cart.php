<?php

	namespace Models\Performers;

	class Cart extends \BaseRegular
	{
		/**
		 * @param $idUser
		 * get cart content of specified user
		 * @return (idBook, Quantity, Price, Name)
		 */
		public function getCart($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getCart(?)')->
				setParam([$idUser])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $idBook
		 * @param $quantity
		 * add to user cart the book with specified quantity
		 * @return if success true
		 * otherwise false
		 */
		public function addToCart($idUser, $idBook, $quantity)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL addToCart(?, ?, ?)')->
				setParam([$idUser, $idBook, $quantity])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $idBook
		 * delete from user cart the book
		 * @return if success true
		 * otherwise false
		 */
		public function deleteFromCart($idUser, $idBook)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL deleteFromCart(?, ?)')->
				setParam([$idUser, $idBook])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $idBook
		 * @param $quantity
		 * change quantity of the book witch exists in the user cart
		 * @return  if success true
		 * otherwise false
		 */
		public function updateQuantity($idUser, $idBook, $quantity)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL updateQuantityInCart(?, ?, ?)')->
				setParam([$idUser, $idBook, $quantity])->
				execute()->getResult();
		}
	}