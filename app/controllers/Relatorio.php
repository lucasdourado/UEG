<?php

namespace app\controllers;

use app\models\RelatorioModel;
use app\models\CandidatoModel;
use app\helpers\Relatorio as RelatorioHelper;
use Slim\Slim as Slim;
use app\models\EleitorModel;

class Relatorio {

	private $relatorioModel;
	private $candidatoModel;

	public function __construct() {
		$this->relatorioModel = new RelatorioModel();
		$this->candidatoModel = new CandidatoModel();
		$this->relatorioHelper = new RelatorioHelper();
		$this->eleitorModel = new EleitorModel();
	}

	public function selecionaCargo() {
		$app = Slim::getInstance();
		$cargos = $this->candidatoModel->getCargos();
		$qtdAusentes = $this->eleitorModel->getQuantidadeAusentes();
		$data = array('cargos' => $cargos, 'qtdAusentes' => $qtdAusentes);
		$app->render('seleciona_cargo.php', $data);
	}

	public function votacao($idCargo, $nomeCargo) {
		$app = Slim::getInstance();
		$votosCandidatos = $this->relatorioModel->votosCandidatosPorCargo($idCargo);
		$votosBrancosNulos = $this->relatorioModel->votosBrancosNulosPorCargo($idCargo);
		$porcentagemVotos = $this->relatorioHelper->getPorcentagemVotosApurados();
		$votos = array_merge($votosCandidatos, $votosBrancosNulos);
		$data = array(
			'votacao' => $votos,
			'nomeCargo' => $nomeCargo,
			'porcentagemVotos' => $porcentagemVotos
		);
		$app->render('votacao.php', $data);
	}

}