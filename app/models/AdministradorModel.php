<?php

namespace app\models;

use app\Conexao;

class AdministradorModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function abreFechaCadastro($abrir) {
		try {
			$sql = 'UPDATE adm SET cadastro_aberto = :flag';
			$query = $this->db->prepare($sql);
			$query->bindParam('flag', $abrir, \PDO::PARAM_INT);
			$query->execute();
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getStatusCadastro() {
		
	}

}