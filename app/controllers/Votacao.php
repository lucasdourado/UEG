<?php
namespace app\controllers;

use app\models\VotacaoModel;
use app\models\CandidatoModel;
use app\models\EleitorModel;

class Votacao {

	// Tempo de votação (em segundos)
	private $tempoExpiracao = 600;
	private $candidatoModel;
	private $eleitorModel;
	private $votacaoModel;

	public function __construct() {
		$this->candidatoModel = CandidatoModel::getInstance();
		$this->eleitorModel = EleitorModel::getInstance();
		$this->votacaoModel = VotacaoModel::getInstance();
	}

	public function getTempoExpiracao() {
		return $this->tempoExpiracao;
	}

	public function getDadosCarga($idUev) {
		$dados = array();
		
		$dados['cargos'] = $this->candidatoModel->getCargos();
		$dados['candidatos'] = $this->candidatoModel->getCandidatos();
		$dados['eleitores'] = $this->eleitorModel->getEleitores($idUev);
		$dados['tempo_expiracao'] = $this->getTempoExpiracao();

		return $dados;
	}

	public function registraVotosUev($dados) {
		$registra = $this->votacaoModel->registraVotosUev($dados);
		return $registra;
	}

}