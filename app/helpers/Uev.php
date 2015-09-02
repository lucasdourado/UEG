<?php

namespace app\helpers;

class Uev {

	private $msgsErro;

	public function __construct() {

		$this->msgsErro = array(
			'formato_json_dados' => 'Os dados informados estão incorretos. Formato do JSON: {"token": "abc123"}',
			'enviar_token' => 'Informar o token de acesso.',
			'sem_acesso' => 'Token informado não possui acesso.',
			'formato_json_votos' => 'Os dados informados estão incorretos. Formato do JSON:'
				. '{"token":"123","votacao":{"id_cargo1":{"numero_cadidato1":123,"numero_cadidato1":52,"branco":20,"nulo":20},'
				. '"id_cargo2":{"numero_cadidato1":85,"numero_cadidato2":37,"branco":2,"nulo":33}},'
				. '"eleitores":{"id_eleitor1":"nome_eleitor1","id_eleitor2":"nome_eleitor2"}}'
		);
	}

	public function getMsgsErro($chave = null) {
		if($chave)
			return $this->msgsErro[$chave];
		return $this->msgsErro;
	}

}