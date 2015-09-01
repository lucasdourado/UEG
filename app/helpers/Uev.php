<?php

namespace app\helpers;

class Uev {

	private $msgsErro;

	public function __construct() {

		$this->msgsErro = array(
			'formato_json' => 'Os dados informados estão incorretos. Formato do JSON: {"token": "abc123"}',
			'enviar_token' => 'Informar o token de acesso.',
			'sem_acesso' => 'Token informado não possui acesso.'
		);
	}

	public function getMsgsErro($chave = null) {
		if($chave)
			return $this->msgsErro[$chave];
		return $this->msgsErro;
	}

}