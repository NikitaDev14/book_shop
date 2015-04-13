<?php

	namespace Models\Performers;

	class Order extends \BaseRegular
	{
		/**
		 * @return all available pay methods (idPayMethod, Name)
		 */
		public function getPayMethods()
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getPayMethods()')->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $idPayMethod
		 * add the new order of user with specified pay method
		 * @return (idOrder)
		 */
		public function addOrder($idUser, $idPayMethod)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL addOrder(?, ?)')->
				setParam([$idUser, $idPayMethod])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * get general information of all orders, of specified user
		 * @return (idOrder, Date, PayMethod, Summ, OrderStatus)
		 */
		public function getOrders($idUser)
		{
			return $this->objFactory->getObjDatabase()->
			setQuery('CALL getOrdersByUser(?)')->
				setParam([$idUser])->execute()->getResult();
		}

		/**
		 * @param $idOrder
		 * @param $idUser
		 * get detail information of specified order, of specified user
		 * @return (idBook, BookName, Quantity, Price)
		 */
		public function getOrderDetails($idOrder, $idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL getOrderDetails(?, ?)')->
				setParam([$idOrder, $idUser])->
				execute()->getResult();
		}
	}