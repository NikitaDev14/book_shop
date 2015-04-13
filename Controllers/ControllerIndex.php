<?php

	namespace Controllers;

	class ControllerIndex extends \Controllers\BaseController
	{
		public function index()
		{
			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Index', 'result' => true]);
		}
	}
