<?php
namespace app\controllers;

use app\models\AdministradorModel;
use app\models\CandidatoModel;
use app\models\EleitorModel;

class Administrador {

	// Tempo de votação (em minutos)
	private $tempoExpiracao = 10;
	private $candidatoModel;
	private $eleitorModel;

	public function __construct() {
		$this->candidatoModel = new CandidatoModel();
		$this->eleitorModel = new EleitorModel();
		$this->admModel = new AdministradorModel();
	}

	public function getTempoExpiracao() {
		return $this->tempoExpiracao;
	}

	public function getDadosCarga($idUev) {
		$dados = array();
		
		$dados['cargo'] = $this->candidatoModel->getCargos();
		$dados['candidatos'] = $this->candidatoModel->getCandidatos();
		$dados['eleitores'] = $this->eleitorModel->getEleitores($idUev);
		$dados['tempo_expiracao'] = $this->getTempoExpiracao();

		return $dados;
	}

	public function registraVotosUev($dados) {
		$registra = $this->admModel->registraVotosUev($dados);
		return $registra;
	}

}