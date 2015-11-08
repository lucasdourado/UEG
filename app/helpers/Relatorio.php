<?php

namespace app\helpers;

use app\models\UevModel;

class Relatorio {

	private $uevModel;

	public function __construct() {
		$this->uevModel = UevModel::getInstance();
	}

	public function getPorcentagemVotosApurados() {
		$qtdUevCadastrada = $this->uevModel->getQtdUevCadastrada();
		$qtdUevEnviouVotos = $this->uevModel->getQtdUevEnviouVotos();
		$porcentagem = (($qtdUevEnviouVotos/$qtdUevCadastrada)*100);
		$porcentagem = number_format($porcentagem, 2, ',', '');
		return $porcentagem;
	}

}