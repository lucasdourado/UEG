<?php

namespace app\models;

use app\Conexao;
use app\models\BaseModel;

class VotacaoModel extends BaseModel {

	public function registraVotosUev($dados) {

		if(!is_object($dados) || empty($dados) || !isset($dados->idUev) 
			|| ($dados->idUev == '') || !is_object($dados->votacao) 
			|| empty($dados->votacao) || !is_array($dados->ausentes) 
			|| empty($dados->ausentes))
			return false;

		$flagAtiva = 1; $flagInativa = 0; $flagNull = null;

		$this->db->beginTransaction();

		// Cadastra os votos
		foreach ($dados->votacao as $idCargo => $dadosVotos) {
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

		// Marca eleitores ausentes
		foreach ($dados->ausentes as $eleitor => $numDoc) {
			$sql = 'UPDATE eleitor SET ausente = 1 WHERE numero_doc = :numero_doc AND id_uev = :id_uev';

			$query = $this->db->prepare($sql);

			$query->bindParam("numero_doc", $numDoc, \PDO::PARAM_INT);
			$query->bindParam("id_uev", $dados->idUev, \PDO::PARAM_INT);

			$resultado = $query->execute();

			if(!$resultado) {
				$this->db->rollback();
				return false;
			}
		}

		// Marca que a Uev enviou a votacao
		$sql = 'UPDATE uev SET enviou_votacao = 1 WHERE id = :id_uev';

		$query = $this->db->prepare($sql);

		$query->bindParam("id_uev", $dados->idUev, \PDO::PARAM_INT);

		$resultado = $query->execute();

		if(!$resultado) {
			$this->db->rollback();
			return false;
		}

		$this->db->commit();

		return true;
	}

}