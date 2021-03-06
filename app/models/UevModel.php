<?php

namespace app\models;

use app\Conexao;
use app\models\BaseModel;

class UevModel extends BaseModel {

	public function verificaAcesso($senha, $retornaID = false) {
		try {
			$sql = 'SELECT id FROM uev WHERE senha = :senha';
			$query = $this->db->prepare($sql);
			$query->bindParam("senha", $senha, \PDO::PARAM_STR);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			if(!$retornaID)
				return (empty($resultado)) ? false : true;
			return $resultado[0]['id'];

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getQtdUevCadastrada() {
		try {
			$sql = 'SELECT COUNT(*) AS QTD FROM uev';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado[0]['QTD'];

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getQtdUevEnviouVotos() {
		try {
			$sql = 'SELECT COUNT(*) AS QTD FROM uev WHERE enviou_votacao = 1';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado[0]['QTD'];

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function verificaUevEnviouVotacao($senha) {
		try {
			$sql = 'SELECT * FROM uev WHERE senha = :senha AND enviou_votacao = 1';
			$query = $this->db->prepare($sql);
			$query->bindParam("senha", $senha, \PDO::PARAM_STR);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return (empty($resultado)) ? false : true;
			

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}