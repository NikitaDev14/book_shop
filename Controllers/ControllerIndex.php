<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 23:25
	 */

	namespace Controllers;

	class ControllerIndex extends \Controllers\BaseController
	{
		public function index()
		{
			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'Index', 'result' => true]);
		}
	}
