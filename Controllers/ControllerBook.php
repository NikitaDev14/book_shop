<?php

	namespace Controllers;

	class ControllerBook extends \Controllers\BaseController
	{
		/**
		 * if user is logged, get books from DB
		 * with personal price, normal price otherwise
		 */
		public function getList()
		{
			$result = $this->objFactory->getObjValidatorUser()->isValidUser();

			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'BookList', 'result' => $result]);
		}
	}
