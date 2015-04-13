<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 13:48
	 */

	namespace Tests\Performers;

	require_once '../requires.php';


	class CartTest extends \Tests\RegularTest
	{
		public function __construct()
		{
			parent::__construct('\Models\Performers\Cart',
				new \Models\Performers\Cart());
		}

		public function testAddToCart()
		{
			$this->assertTrue($this->instance->
			addToCart(TEST_ID_USER, TEST_ID_BOOK, 1));
		}

		public function testGetCart()
		{
			$this->assertArrayHasKey('idBook',
				$this->instance->getCart(TEST_ID_USER)[0]);
		}

		public function testUpdateQuantity()
		{
			$this->assertTrue($this->instance->
			updateQuantity(TEST_ID_USER, TEST_ID_BOOK, 2));
		}

		public function testDeleteFromCart()
		{
			$this->assertTrue($this->instance->
			deleteFromCart(TEST_ID_USER, TEST_ID_BOOK));
		}
	}