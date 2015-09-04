<?php

namespace app\controllers;

use app\models\UevModel;
use Slim\Slim as Slim;
use app\controllers\Administrador;
use app\helpers\Uev as UevHelper;

class Uev {

	private $uevModel;
	private $uevHelper;
	private $admModel;

	public function __construct() {
		$this->uevModel = new UevModel();
		$this->uevHelper = new UevHelper();
		$this->admModel = new Administrador();
	}

	public function solicitaDados() {
		$request = Slim::getInstance()->request();
		$dadosUEV = json_decode($request->getBody());
		$msgErro = '';
		$dados = array();

		// Verifica se foi enviado os dados necessários (token)
		if(!isset($dadosUEV) || !isset($dadosUEV->token))
			$msgErro = $this->uevHelper->getMsgsErro('formato_json_dados');

		// Verifica se o token enviado não está vazio
		if(($msgErro == '') && ($dadosUEV->token == ''))
			$msgErro = $this->uevHelper->getMsgsErro('enviar_token');

		// Verifica se UEV possui acesso aos dados
		if($msgErro == '' && !$this->uevModel->verificaAcesso($dadosUEV->token))
			$msgErro = $this->uevHelper->getMsgsErro("sem_acesso");

		// Se estiver tudo OK, retorna os dados para a UEV
		if($msgErro == ''){
			$idUev = $this->uevModel->verificaAcesso($dadosUEV->token, true);
			$dados = $this->admModel->getDadosCarga($idUev);
		}

		$dados['erro'] = $msgErro;

		echo json_encode($dados);
	}

	public function enviaVotacao() {
		$request = Slim::getInstance()->request();
		$dadosUEV = json_decode($request->getBody());
		$msgErro = '';
		$dados = array();

		// Verifica se foi enviado os dados necessários (token, votos e eleitores)
		if(!isset($dadosUEV) || !isset($dadosUEV->token) || !isset($dadosUEV->votacao) || !isset($dadosUEV->eleitores))
			$msgErro = $this->uevHelper->getMsgsErro('formato_json_votos');

		// Verifica se o token enviado não está vazio
		if(($msgErro == '') && ($dadosUEV->token == ''))
			$msgErro = $this->uevHelper->getMsgsErro('enviar_token');

		// Verifica se UEV possui acesso aos dados
		if($msgErro == '' && !$this->uevModel->verificaAcesso($dadosUEV->token))
			$msgErro = $this->uevHelper->getMsgsErro("sem_acesso");

		// Se estiver tudo OK, cadastra os votos e os eleitores que votaram
		if($msgErro == '') {
			$idUev = $this->uevModel->verificaAcesso($dadosUEV->token, true);
			$dadosUEV->idUev = $idUev;
			$registra = $this->admModel->registraVotosUev($dadosUEV);
			$dados['votacao'] = (!$registra) ? 
								'Erro ao cadastrar os votos'
								: 'Votos cadastrados com sucesso.';
		}

		$dados['erro'] = $msgErro;

		echo json_encode($dados);
	}

}