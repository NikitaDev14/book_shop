<?php

	namespace Controllers;

	class ControllerOrder extends \Controllers\BaseController
	{
		/**
		 * if user is logged next page will show list of pay methods
		 */
		public function getPayMethods()
		{
			$result = (bool)$this->objFactory->getObjValidatorUser()
				->isValidUser();

			$nextPage = 'Echo';

			if(true === $result)
			{
				$nextPage = 'PayMethodList';
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => $nextPage, 'result' => $result]);
		}

		/**
		 * get from HTTP form idPayMethod
		 * if user is logged add new order for this user with
		 * chosen pay method, set response true, false otherwise
		 */
		public function addOrder()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false !== $result)
			{
				$result = (bool) $this->objFactory->getObjOrder()->
					addOrder($result, $formData['payMethod']);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}

		/**
		 * if user is logged get all his orders
		 */
		public function getOrders()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$nextPage = 'Echo';

			if(false !== $result)
			{
				$nextPage = 'OrderList';
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => $nextPage, 'result' => $result]);
		}

		/**
		 * if user is logged get details of the clicked order
		 */
		public function getOrderDetails()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$nextPage = 'Echo';

			if(false !== $result)
			{
				$nextPage = 'OrderDetails';
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => $nextPage,
				'result' =>
					['idUser' => $result,
						'idOrder' => $formData['idOrder']]
			]);
		}
	}