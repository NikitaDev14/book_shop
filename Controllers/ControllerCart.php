<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 14:08
 */

	namespace Controllers;

	class ControllerCart extends \Controllers\BaseController
	{
		public function getCart()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Cart', 'result' => $result]);
		}
		public function addToCart()
		{
			$formData = $this->objFactory->getObjHttp()->
				setParams($this->form)->getParams();

			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			if(false != $result)
			{
				$result = $this->objFactory->getObjCart()->
					addToCart($result, $formData['idBook'], $formData['quantity']);
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Echo', 'result' => $result]);
		}
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