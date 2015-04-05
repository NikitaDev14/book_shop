<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 18:42
 */

	namespace Controllers;

	class ControllerBook extends \Controllers\BaseController
	{
		public function getList()
		{
			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'BookList', 'result' => true]);
		}
	}