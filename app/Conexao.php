<?php

namespace app;

class Conexao {

	private static $instance;

	public static function conectar() {
		try {
			if(!isset($instance)) {
				$dsn = 'mysql:host=localhost;dbname=ueg';
				self::$instance = new \PDO($dsn, 'root', 'root', array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			}
			return self::$instance;
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}