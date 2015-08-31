<?php

namespace app\controllers;
use app\models\UevModel;

class Uev {

	private $uevModel;
	private $uevHelper;

	public function __construct() {
		$this->uevModel = new UevModel();
		$this->uevHelper = new \app\helpers\Uev();
	}

	public function SolicitaCadastroUEV() {
		$request = \Slim\Slim::getInstance()->request();
        $dadosUEV = json_decode($request->getBody());
		$msgRetorno = '';

		/* Validação - Inicio */
		if(!isset($dadosUEV->nome) || !isset($dadosUEV->url_resposta))
			$msgRetorno .= $uevHelper->getMsgsErro("formato_json");

		if(isset($dadosUEV->nome) && $dadosUEV->nome == '')
			$msgRetorno .= $uevHelper->getMsgsErro("nome_uev");

		if(isset($dadosUEV->nome) && $dadosUEV->url_resposta == '')
			$msgRetorno .= $uevHelper->getMsgsErro("url_resposta_uev");

		if($this->uevModel->getNumUEVCadastradas() >= 10)
			$msgRetorno .= $uevHelper->getMsgsErro("num_maximo");
		/* Validação - Fim */ 

		// Se algum problema na validação, retorna a msg de erro
		if($msgRetorno != '')
			echo $msgRetorno;

		// Se validação ok, cadastra a UEV
		print_r($this->uevModel->cadastraUEV($dadosUEV));
	}

}