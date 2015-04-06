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
				$nextPage = 'Order';
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
	}