<?php

namespace app\models;

use app\Conexao;

class CandidatoModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function listaCandidatos() {
		try {
			$sql = 'SELECT c.numero, c.nome, c.apelido, c.foto, ca.nome as nome_cargo FROM candidato c INNER JOIN cargo ca ON ca.id = c.id_cargo';
			$candidatos = $this->db->prepare($sql);
			$candidatos->execute();
			$resultado = $candidatos->fetchAll(\PDO::FETCH_OBJ);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}