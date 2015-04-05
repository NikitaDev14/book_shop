<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 21:33
 */

	namespace Controllers;

	class BaseController
	{
		protected $objFactory;
		protected $form;

		public function __construct($form)
		{
			$this->objFactory = \Models\Utilities\ObjFactory::getInstance();
			$this->form = $form;
		}
	}