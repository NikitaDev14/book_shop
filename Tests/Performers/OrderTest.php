<?php

	namespace Tests\Performers;

	require_once '../requires.php';

	class OrderTest extends \Tests\RegularTest
	{
		private static $testOrder;
		private $cart;

		public function __construct()
		{
			parent::__construct('\Models\Performers\Order',
				new \Models\Performers\Order());

			$this->cart = new \Models\Performers\Cart();
		}

		public function testGetPayMethods()
		{
			$this->assertArrayHasKey('idPayMethod',
				$this->instance->getPayMethods()[0]);
		}

		public function testPayMethodsCount()
		{
			$this->assertEquals(PAY_METHODS_COUNT,
				count($this->instance->getPayMethods()));
		}

		public function testAddOrder()
		{
			$this->cart->addToCart(TEST_ID_USER, TEST_ID_BOOK, TEST_QUANTITY);

			self::$testOrder = (int)$this->instance->addOrder(
				TEST_ID_USER, TEST_ID_PAY_METHOD
			)[0]['idOrder'];

			$this->assertTrue(0 < self::$testOrder);
		}

		public function testGetOrders()
		{
			$this->assertEquals(self::$testOrder,
				$this->instance->getOrders(TEST_ID_USER)[0]['idOrder']);
		}

		public function testGetOrderDetails()
		{
			$result = $this->instance->getOrderDetails(
				self::$testOrder, TEST_ID_USER
			)[0];

			$this->assertTrue(TEST_ID_BOOK == $result['idBook'] &&
				TEST_QUANTITY == $result['Quantity']);
		}

		public function testDeleteOrder()
		{
			$query = 'DELETE FROM orders
						WHERE orders.idOrder = ?';

			$result = $this->objFactory->getObjDatabase()->
			setQuery($query)->setParam([self::$testOrder])->
			execute()->getResult();

			$this->assertTrue(0 < $result);
		}
	}