<?php

namespace app\controllers;

use app\models\EleitorModel;
use Slim\Slim as Slim;

class Eleitor {
	
	private $eleitorModel;

	public function __construct() {
		$this->eleitorModel = new EleitorModel();
	}

	public function listaEleitores() {
		$app = Slim::getInstance();
		$eleitores = $this->eleitorModel->listaEleitores();
		$data = array("eleitores" => $eleitores);
		$app->render('eleitor.php', $data);
	}

}