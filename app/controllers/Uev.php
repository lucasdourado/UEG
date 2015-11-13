<?php

namespace app\controllers;

use app\models\UevModel;
use Slim\Slim as Slim;
use app\controllers\Votacao;

class Uev {

	private $uevModel;
	private $votacao;

	public function __construct() {
		$this->uevModel = UevModel::getInstance();
		$this->votacao = new Votacao();
	}

	public function solicitaDados() {
		$request = Slim::getInstance()->request();
		$dadosUEV = json_decode($request->getBody());
		$dados = array();

		// Verifica se foi enviado os dados necessários (senha)
		if(!isset($dadosUEV) || !isset($dadosUEV->senha) || ($dadosUEV->senha == ''))
			return false;

		// Verifica se UEV possui acesso aos dados
		if(!$this->uevModel->verificaAcesso($dadosUEV->senha))
			return false;

		// Se estiver tudo OK, retorna os dados para a UEV
		$idUev = $this->uevModel->verificaAcesso($dadosUEV->senha, true);
		$dados = $this->votacao->getDadosCarga($idUev);

		echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	}

	public function enviaVotacao() {
		$request = Slim::getInstance()->request();
		$dadosUEV = json_decode($request->getBody());
		$dados = array();

		// Verifica se foi enviado os dados necessários (senha, votos e eleitores)
		if(!isset($dadosUEV) || !isset($dadosUEV->senha) || !isset($dadosUEV->votacao) || !isset($dadosUEV->ausentes))
			return false;

		// Verifica se o senha enviado não está vazio
		if(($dadosUEV->senha == ''))
			return false;

		// Verifica se UEV possui acesso aos dados
		if(!$this->uevModel->verificaAcesso($dadosUEV->senha))
			return false;

		// Se estiver tudo OK, cadastra os votos e os eleitores que nao votaram
		$idUev = $this->uevModel->verificaAcesso($dadosUEV->senha, true);
		$dadosUEV->idUev = $idUev;
		$registra = $this->votacao->registraVotosUev($dadosUEV);

		if($registra)
			echo 'OK';
		else
			return false;
	}

}