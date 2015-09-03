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
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_OBJ);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getCandidatos() {
		try {
			$sql = 'SELECT * FROM candidato';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function getCargos() {
		try {
			$sql = 'SELECT * FROM cargo';
			$query = $this->db->prepare($sql);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function cadastraVotos($dados) {

		if(!is_object($dados) || empty($dados))
			return false;

		$flagAtiva = 1;
		$flagInativa = 0;
		$flagNull = null;
		
		$this->db->beginTransaction();

		foreach ($dados as $idCargo => $dadosVotos) {
			foreach ($dadosVotos as $numCandidato => $qtdVotos) {
				$sql = 'INSERT INTO votacao (id_cargo, numero_candidato,'
					.'voto_branco, voto_nulo, qtd_votos) values ('
					.':id_cargo, :numero_candidato, :voto_branco,'
					.':voto_nulo, :qtd_votos)';

				$query = $this->db->prepare($sql);

				$query->bindParam("id_cargo", $idCargo, \PDO::PARAM_INT);
				$query->bindParam("qtd_votos", $qtdVotos, \PDO::PARAM_INT);

				if($numCandidato == 'branco') {
					$query->bindParam("numero_candidato", $flagNull, \PDO::PARAM_NULL);
					$query->bindParam("voto_branco", $flagAtiva, \PDO::PARAM_INT);
					$query->bindParam("voto_nulo", $flagInativa, \PDO::PARAM_INT);
				}

				if($numCandidato == 'nulo') {
					$query->bindParam("numero_candidato", $flagNull, \PDO::PARAM_NULL);
					$query->bindParam("voto_branco", $flagInativa, \PDO::PARAM_INT);
					$query->bindParam("voto_nulo", $flagAtiva, \PDO::PARAM_INT);
				}

				if($numCandidato != 'branco' && $numCandidato != 'nulo') {
					$query->bindParam("numero_candidato", $numCandidato, \PDO::PARAM_INT);
					$query->bindParam("voto_branco", $flagInativa, \PDO::PARAM_INT);
					$query->bindParam("voto_nulo", $flagInativa, \PDO::PARAM_INT);
				}

				$resultado = $query->execute();

				if(!$resultado) {
					$this->db->rollback();
					return false;
				}
			}
		}

		$this->db->commit();

		return true;
	}

}