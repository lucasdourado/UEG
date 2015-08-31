<?php

namespace app\controllers;

use app\models\CandidatoModel;

class Candidato {
	
	private $candidatoModel;

	public function __construct() {
		$this->candidatoModel = new CandidatoModel();
	}

	public function listaCandidatos() {
		return $this->candidatoModel->listaTodosCandidatos();
	}

	public function insereCandidato($dadosCandidato) {
		return $this->candidatoModel->insereCandidato($dadosCandidato);
	}

}