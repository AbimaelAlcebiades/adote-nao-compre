<?php

namespace TrabalhoG2;

// Usa classe PDO nativo do PHP.
use \PDO;

/**
* Classe de conexão com o banco de dados.
*/
class Connection
{
	
	public static $instance;

	public function __construct()
	{
		
	}

	public function getInstance()
	{
		if (!isset(self::$instance)) 
		{
			self::$instance = new PDO('mysql:host=localhost;dbname=trabalhog2', 'root', '',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$instance;
	}
}

?>