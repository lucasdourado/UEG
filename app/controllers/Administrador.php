<?php
namespace app\controllers;

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
		//$this->candidatoModel->cadastraVotos($dados->votacao);
		//$this->eleitorModel->marcaEleitoresVotaram($dados->eleitores);
		//$this->uevModel->marcaUevEnviouVotacao($dados->id);
	}

}