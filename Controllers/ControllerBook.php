<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 18:42
 */

	namespace Controllers;

	class ControllerBook
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
		public function run()
		{
			$this->objFactory->getObjDataContainer()->
				setParams(['nextPage' => 'BookList', 'result' => true]);
		}
	}