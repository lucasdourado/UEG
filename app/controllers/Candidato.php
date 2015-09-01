<?php

namespace app\controllers;

use app\models\CandidatoModel;
use Slim\Slim as Slim;

class Candidato {
	
	private $candidatoModel;

	public function __construct() {
		$this->candidatoModel = new CandidatoModel();
	}

	public function listaCandidatos() {
		$app = Slim::getInstance();
		$candidatos = $this->candidatoModel->listaCandidatos();
		$data = array("candidatos" => $candidatos);
		$app->render('candidato.php', $data);
	}

}