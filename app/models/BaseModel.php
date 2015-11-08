<?php

namespace app\models;

use app\Conexao;

class BaseModel {
	private static $instance;
	protected $db;

	private function __construct() {
		$this->db = Conexao::conectar();
	}

	public static function getInstance() {
		$class = get_called_class();
		if(!isset(self::$instance[$class])) {
			self::$instance[$class] = new $class;
		}
		return self::$instance[$class];
	}
}