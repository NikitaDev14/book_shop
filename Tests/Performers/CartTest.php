<?php

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
			addToCart(TEST_ID_USER, TEST_ID_BOOK, TEST_QUANTITY));
		}

		public function testUpdateQuantity()
		{
			$this->assertTrue($this->instance->
			updateQuantity(TEST_ID_USER, TEST_ID_BOOK, TEST_QUANTITY));
		}

		public function testGetCart()
		{
			$result = $this->instance->getCart(TEST_ID_USER)[0];

			$this->assertTrue(TEST_ID_BOOK == $result['idBook']
				&& TEST_QUANTITY == $result['Quantity']);
		}

		public function testDeleteFromCart()
		{
			$this->assertTrue($this->instance->
			deleteFromCart(TEST_ID_USER, TEST_ID_BOOK));
		}
	}