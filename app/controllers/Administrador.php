<?php
namespace app\controllers;

use app\models\CandidatoModel;
use app\models\EleitorModel;

class Administrador {

	public static function getDadosCarga($idUev) {
		$dados = array();
		$candidatoModel = new CandidatoModel();
		$eleitorModel = new EleitorModel();

		$dados['cargo'] = $candidatoModel->getCargos();
		$dados['candidatos'] = $candidatoModel->getCandidatos();
		$dados['eleitores'] = $eleitorModel->getEleitores($idUev);

		return $dados;
	}

}