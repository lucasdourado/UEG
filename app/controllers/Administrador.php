<?php
namespace app\controllers;

use app\models\AdministradorModel;

class Administrador {

	private $admModel;

	public function __construct() {
		$this->admModel = new AdministradorModel();
	}

	public function abreCadastro() {
		$this->admModel->abreFechaCadastro(1);
	}

	public function fechaCadastro() {
		$this->admModel->abreFechaCadastro(0);
	}
}