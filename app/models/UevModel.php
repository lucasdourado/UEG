<?php

namespace app\models;

use app\Conexao;

class UevModel {
	
	private $db;

	public function __construct() {
		$this->db = Conexao::conectar();
	}

	public function verificaAcesso($token, $retornaID = false) {
		try {
			$sql = 'SELECT id FROM uev WHERE token_acesso = :token';
			$query = $this->db->prepare($sql);
			$query->bindParam("token", $token, \PDO::PARAM_STR);
			$query->execute();
			$resultado = $query->fetchAll(\PDO::FETCH_ASSOC);

			if(!$retornaID)
				return (empty($resultado)) ? false : true;
			return $resultado[0]['id'];

		} catch(PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
	}

}