<?php

namespace app\models;

use app\Conexao;

class RelatorioModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function votosCandidatosPorCargo($idCargo) {
		try {
			$sql = 'SELECT c.nome
						 , c.foto
						 , c.apelido
						 , v.numero_candidato
						 , SUM(v.qtd_votos) as qtd_votos
					  FROM votacao v
				 INNER JOIN ueg.candidato c ON c.numero = v.numero_candidato
				  	 WHERE v.id_cargo = :id_cargo
				  GROUP BY v.numero_candidato
				  ORDER BY SUM(v.qtd_votos) DESC';

			$query = $this->db->prepare($sql);
			$query->bindParam("id_cargo", $idCargo, \PDO::PARAM_INT);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

	public function votosBrancosNulosPorCargo($idCargo) {
		try {
			$sql = 'SELECT CASE WHEN (voto_branco = 1) THEN \'BRANCOS\'
								WHEN (voto_nulo = 1) THEN \'NULOS\'
							END AS nome
						 , SUM(qtd_votos) as qtd_votos
					  FROM votacao
					 WHERE id_cargo = :id_cargo
					   AND (voto_branco = 1 OR voto_nulo = 1)
				  GROUP BY voto_branco, voto_nulo
				  ORDER BY SUM(qtd_votos) DESC';

			$query = $this->db->prepare($sql);
			$query->bindParam("id_cargo", $idCargo, \PDO::PARAM_INT);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			return $resultado;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}