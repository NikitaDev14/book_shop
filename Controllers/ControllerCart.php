<?php

	namespace Controllers;

	class ControllerCart extends \Controllers\BaseController
	{
		/**
		 * if user is logged, next page will be cart with him ID
		 */
		public function getCart()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Cart', 'result' => $result]);
		}

		/**
		 * get from HTTP form idBook and its quantity
		 * set response true and add these params into cart
		 * if user is logged, false otherwise
		 */
		public function addToCart()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false != $result)
			{
				$result = $this->objFactory->getObjCart()->addToCart(
					$result,
					$formData['idBook'],
					$formData['quantity']
				);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}

		/**
		 * get from HTTP form idBook
		 * if user is logged delete this book from the cart
		 * set response true, false otherwise
		 */
		public function deleteFromCart()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false != $result)
			{
				$result = $this->objFactory->getObjCart()->
					deleteFromCart($result, $formData['idBook']);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}

		/**
		 * get from HTTP form idBook and its quantity
		 * if user is logged set new quantity to idBook in the cart,
		 * set response true, false otherwise
		 */
		public function updateQuantity()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false != $result)
			{
				$result = $this->objFactory->getObjCart()->
					updateQuantity($result,
						$formData['idBook'], $formData['quantity']);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
	}