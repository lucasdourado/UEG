<?php

namespace app\models;

use app\Conexao;
use app\models\BaseModel;

class RelatorioModel extends BaseModel {

	public function votosCandidatosPorCargo($idCargo) {
		try {
			$sql = 'SELECT c.nome
						 , c.foto
						 , c.apelido
						 , c.numero
						 , IFNULL(SUM(v.qtd_votos),0) as qtd_votos
					  FROM candidato c
				 LEFT JOIN votacao v ON v.numero_candidato = c.numero
					 WHERE c.id_cargo = :id_cargo
				  GROUP BY c.numero
				  ORDER BY qtd_votos DESC;';

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
			$arrayRetorno = array(
				array('nome' => 'NULOS', 'qtd_votos' => 0),
				array('nome' => 'BRANCOS', 'qtd_votos' => 0),
			);

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

			return (!empty($resultado)) ? $resultado : $arrayRetorno;
			
		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}