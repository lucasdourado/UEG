<?php

namespace app\models;

use app\Conexao;

class CandidatoModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function listaTodosCandidatos() {
		try {
			$sql = 'SELECT * FROM candidato';
			$candidatos = $this->db->prepare($sql);
			$candidatos->execute();
			$resultado = $candidatos->fetchAll(\PDO::FETCH_OBJ);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function insereCandidato($dados) {
		try {
			$sql = 'INSERT INTO candidato (numero, nome, apelido, foto, id_cargo) values (:numero, :nome, :apelido, :foto, :id_cargo)';
			$query = $this->db->prepare($sql);
			$query->bindParam("numero", $dados->numero, \PDO::PARAM_INT);
			$query->bindParam("nome", $dados->nome, \PDO::PARAM_STR);
			$query->bindParam("apelido", $dados->apelido, \PDO::PARAM_STR);
			$query->bindParam("foto", $dados->foto, \PDO::PARAM_STR);
			$query->bindParam("id_cargo", $dados->id_cargo, \PDO::PARAM_INT);
			$query->execute();

			return $dados;

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}
}