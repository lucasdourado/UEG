<?php

namespace app\models;

use app\Conexao;

class EleitorModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function listaEleitores() {
		try {
			$sql = 'SELECT e.numero_doc, e.nome, e.foto, u.id as uev FROM eleitor e INNER JOIN uev u ON u.id = e.id_uev';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_OBJ);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getEleitores($idUev) {
		try {
			$sql = 'SELECT * FROM eleitor WHERE id_uev = :uev';
			$query = $this->db->prepare($sql);
			$query->bindParam("uev", $idUev, \PDO::PARAM_INT);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}