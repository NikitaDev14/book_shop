<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 21:33
 */

	namespace Controllers;

	class BaseController extends \BaseClass
	{
		protected $form;

		public function __construct($form)
		{
			parent::__construct();

			$this->form = $form;
		}
	}