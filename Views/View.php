<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 17:36
	 */

	namespace Views;

	class View
	{
		private $objFactory;

		public function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}

		public function render()
		{
			$params = $this->objFactory->getObjDataContainer()->getParams();

			$palletName = '\Views\Pallets\\' . $params['nextPage'] . 'Pallet';

			$palletObj = new $palletName();

			$palletObj->generate($params['result']);
		}
	}