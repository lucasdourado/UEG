<?php

namespace app\controllers;

use app\models\UevModel;
use Slim\Slim as Slim;
use app\controllers\Administrador;
use app\helpers\Uev as UevHelper;

class Uev {

	private $uevModel;
	private $uevHelper;
	private $administrador;

	public function __construct() {
		$this->uevModel = new UevModel();
		$this->uevHelper = new UevHelper();
		$this->administrador = new Administrador();
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
		$dados = $this->administrador->getDadosCarga($idUev);

		echo utf8_decode(json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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
		$registra = $this->administrador->registraVotosUev($dadosUEV);

		if($registra)
			echo 'OK';
		else
			return false;
	}

}