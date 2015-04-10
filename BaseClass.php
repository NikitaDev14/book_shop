<?php

	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 10.04.2015
	 * Time: 11:06
	 */
	class BaseClass
	{
		protected $objFactory;

		protected function __construct()
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
		}
	}