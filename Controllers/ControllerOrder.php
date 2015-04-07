<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 06.04.2015
 * Time: 20:11
 */

	namespace Controllers;

	class ControllerOrder extends \Controllers\BaseController
	{
		public function getPayMethods()
		{
			$result = (bool) $this->objFactory->getObjValidatorUser()->isValidUser();

			$nextPage = 'Echo';

			if(true === $result)
			{
				$nextPage = 'PayMethodList';
			}

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => $nextPage, 'result' => $result]);
		}
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
					'result' => ['idUser' => $result,
							'idOrder' => $formData['idOrder']]]);
		}
	}