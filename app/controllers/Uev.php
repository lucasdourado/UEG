<?php

namespace app\controllers;

use app\models\UevModel;
use Slim\Slim as Slim;

class Uev {

	private $uevModel;
	private $uevHelper;

	public function __construct() {
		$this->uevModel = new UevModel();
		$this->uevHelper = new \app\helpers\Uev();
	}

	public function solicitaDados() {
		$request = Slim::getInstance()->request();
		$dadosUEV = json_decode($request->getBody());
		$msgErro = '';
		$dados = array();

		// Verifica se foi enviado os dados necessários (token)
		if(!isset($dadosUEV->token))
			$msgErro = $this->uevHelper->getMsgsErro('formato_json');

		// Verifica se o token enviado não está vazio
		if(($msgErro == '') && (isset($dadosUEV->token)) && ($dadosUEV->token == ''))
			$msgErro = $this->uevHelper->getMsgsErro('enviar_token');

		// Verifica se UEV possui acesso aos dados
		if($msgErro == '' && !$this->uevModel->verificaAcesso($dadosUEV->token))
			$msgErro = $this->uevHelper->getMsgsErro("sem_acesso");

		if($msgErro == ''){
			$idUev = $this->uevModel->verificaAcesso($dadosUEV->token, true);
			$dados = \app\controllers\Administrador::getDadosCarga($idUev);
		}

		$dados['erro'] = $msgErro;

		echo json_encode($dados);
	}

}