<?php

namespace app\models;

use app\Conexao;

class UevModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function getNumUEVCadastradas() {
		try {
			$sql = 'SELECT COUNT(*) AS QTDE FROM uev';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_OBJ);

			return $resultado[0]->QTDE;

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function cadastraUEV($dados) {
		try {
			$sql = 'INSERT INTO uev (nome, url_resposta) values (:nome, :url_resposta)';
			$query = $this->db->prepare($sql);
			$query->bindParam("nome", $dados->nome, \PDO::PARAM_STR);
			$query->bindParam("url_resposta", $dados->url_resposta, \PDO::PARAM_STR);
			$query->execute();
			$dados->id = $this->db->lastInsertId();
			
			return $dados;

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}