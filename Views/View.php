<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 17:36
	 */

	namespace Views;

	class View extends \BaseRegular
	{
		/**
		 * define needed pallet and call it
		 */
		public function render()
		{
			$params = $this->objFactory->getObjDataContainer()->getParams();

			$palletName = '\Views\Pallets\\' . $params['nextPage'] . 'Pallet';

			$palletObj = new $palletName();

			$palletObj->generate($params['result']);
		}
	}