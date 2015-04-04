<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 23:22
 */

	namespace Models;

	class Model
	{
		protected $objFactory;

		public function __construct()
		{
			$this->objFactory =
				\Models\Utilities\ObjFactory::getInstance();
		}
	}