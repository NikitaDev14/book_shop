<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 18:43
	 */

	namespace Models\Interfaces;

	class Database
	{
		private $db;
		private $sth;

		public function __construct($name, $host, $user, $pass)
		{
			$this->db = new \PDO('mysql:dbname=' . $name . ';host=' . $host, $user, $pass);
		}

		public function setQuery($query)
		{
			$this->sth = $this->db->prepare($query);

			return $this;
		}

		public function setParam($params)
		{
			$count = count($params);

			for ($i = 1; $i <= $count; $i++)
			{
				$this->sth->bindParam($i, $params[$i - 1]);
			}
			/*
			foreach($params as $key => $val)
			{
				echo $key . ' ; ' . $val . '</br>';

				$this->sth->bindParam($key, $val);
			}
			*/

			return $this;
		}

		public function execute()
		{
			$this->sth->execute();

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getResult()
		{
			return $this->sth->fetchAll();
		}

		public function __destruct()
		{
			$this->db = null;
		}
	}